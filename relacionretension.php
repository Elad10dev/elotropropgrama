<?php
// CONFIGURACIÓN DE ALTO RENDIMIENTO
ini_set('memory_limit', '2048M');
ini_set('max_execution_time', '1800');
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', 0);

session_start();
require_once 'ambiente.php'; 

if (function_exists('conectar')) { $conn = conectar(); } 
elseif (function_exists('ConectarConsultas')) { $conn = ConectarConsultas(); } 
else { die("Error Crítico: No hay conexión a la base de datos."); }

// Ponemos una fecha desde muy antigua para que por defecto muestre TODOS los registros
$fechaDesde = '2020-01-01';
$fechaHasta = date('Y-m-d');
?>

<style>
    /* =======================================================================
       FRONTEND FIX: ELIMINAR SCROLL INTERNO Y AJUSTAR FOOTER
       ======================================================================= */
    
    .table-responsive {
        overflow-y: visible !important; 
        overflow-x: auto !important;    
        max-height: none !important;
        height: auto !important;
    }
    
    #TablaRetenciones_wrapper {
        overflow: visible !important;
    }

    .dataTables_length, .dataTables_info {
        display: none !important;
    }

    .top-controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .dataTables_paginate {
        display: flex !important;
        justify-content: flex-start !important;
        margin-top: 0 !important;
    }

    .pagination {
        margin: 0 !important;
    }

    /* DISEÑO DE LOS BOTONES DE PAGINACIÓN */
    .page-item .page-link {
        border-radius: 50% !important;
        width: 38px !important;
        height: 38px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        margin: 0 4px !important;
        background-color: #0b1727 !important; 
        color: #ffffff !important;
        border: none !important;
        font-weight: bold !important;
        font-size: 14px !important;
        box-shadow: 0 4px 6px rgba(0,0,0,0.15);
        transition: all 0.2s ease;
        padding: 0 !important;
        cursor: pointer;
    }

    .page-item.previous .page-link,
    .page-item.next .page-link {
        border-radius: 20px !important; 
        width: auto !important;
        padding: 0 16px !important;
    }

    .page-item.active .page-link, 
    .page-item .page-link:hover {
        background-color: #00b4d8 !important; 
        color: #ffffff !important;
        box-shadow: 0 4px 8px rgba(0, 180, 216, 0.4);
    }

    .page-item.disabled .page-link {
        background-color: #e9ecef !important;
        color: #adb5bd !important;
        box-shadow: none !important;
        cursor: not-allowed;
    }

    .anti-footer-spacer {
        height: 180px;
        width: 100%;
        display: block;
        clear: both;
    }
</style>

<header id="header" class="d-print-none">
    <div class="container">
        <div class="row">
            <div class="col-md-8 d-none d-lg-block d-xl-block d-xxl-block">
                <h1>
                    <div>
                        <i><img src="/img/impuestos.png" width="24" height="24" onerror="this.src='/img/informez.png'"></i> <?php echo lang("Relación de Retenciones"); ?>
                    </div>
                    <div><small class="small fs-6"><?php echo lang("ISLR e IVA"); ?></small></div>
                </h1>
            </div>
            
            <div class="col-lg-4 col-xs-12 p-2" id="headerprintxd2">
                <div class='btn-group float-end'>
                    <button class="btn btn-outline-danger fs-6 p-2 me-1" type="button" onclick="ExportarMasivo('PDF')">
                        <i class="fa fa-file-pdf-o fs-3"></i> <br> <b>PDF</b>
                    </button>

                    <button class="btn btn-outline-success fs-6 p-2 me-1" type="button" onclick="ExportarMasivo('XML')">
                        <i class="fa fa-file-code-o fs-3"></i> <br> <b>XML</b>
                    </button>
                    <button class="btn btn-outline-secondary fs-6 p-2 me-2" type="button" onclick="ExportarMasivo('TXT')">
                        <i class="fa fa-file-text-o fs-3"></i> <br> <b>TXT</b>
                    </button>
                    <button class="btn btn-light border-secondary text-dark fs-6 p-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#PanelFiltros">
                        <i class="fa fa-filter fs-3 text-dark"></i> <br> <b><?php echo lang("Filtros"); ?></b>
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>

<nav aria-label="breadcrumb">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item "><a href="app.php?opcion=impuestosnew.php"><?php echo lang("Impuestos"); ?></a></li>
            <li class="breadcrumb-item active"><?php echo lang("Relación de Retenciones"); ?></li>
        </ol>
    </div>
</nav>

<form id="formExportarMasivo" action="" method="post" target="_blank" class="d-none">
    <input type="hidden" name="FechaDesde" id="ExportFechaDesde">
    <input type="hidden" name="FechaHasta" id="ExportFechaHasta">
    <input type="hidden" name="TipoRetencion" id="ExportTipoRetencion">
    <input type="hidden" name="CompanyActual" value="<?php echo $_SESSION['CompanyActual']; ?>">
</form>

<div class="container" id="contenedortotal">
    <div class='col-12 d-print-none'>
        <span id='error_retencion' style='color:red'></span>
        
        <div class="table-responsive border-0">
            <table class="table table-hover table-striped nowrap" id="TablaRetenciones" cellspacing="0" style="width:100%">
                <thead>
                    <tr style="border-bottom: 2px solid #ccc;">
                        <th class="text-start"><?php echo lang("Tipo Registro"); ?></th>
                        <th class="text-start"><?php echo lang("Fecha"); ?></th>
                        <th class="text-start"><?php echo lang("Factura"); ?></th>
                        <th class="text-start"><?php echo lang("Empresa"); ?></th>
                        <th class="text-end"><?php echo lang("Base Imponible"); ?></th>
                        <th class="text-center"><?php echo lang("% Ret"); ?></th>
                        <th class="text-end text-danger"><?php echo lang("Retenido"); ?></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        
        <div class="anti-footer-spacer"></div>
        
    </div>
</div>

<div class="offcanvas offcanvas-end" id="PanelFiltros" tabindex="-1" style="z-index:9999;">
    <div class="offcanvas-header bg-light border-bottom">
        <div>
            <h3 class="offcanvas-title text-primary"><i class="fa fa-filter"></i> <?php echo lang("Filtros"); ?></h3>
            <span class="float-start text-muted"><?php echo lang("Relación de Retenciones"); ?></span>
        </div>
        <div>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
    </div>
    <div class="offcanvas-body">
        <div class="row">
            <div class="col-12 p-1 mb-2">
                <div class="form-floating">
                    <input class="form-control" type="date" id="FiltroDesde" value="<?php echo $fechaDesde; ?>" onchange="CargarTablaRetenciones()">
                    <label><i class="fa fa-calendar"></i> <?php echo lang('Desde la Fecha'); ?></label>
                </div>
            </div>
            <div class="col-12 p-1 mb-2">
                <div class="form-floating">
                    <input class="form-control" type="date" id="FiltroHasta" value="<?php echo $fechaHasta; ?>" onchange="CargarTablaRetenciones()">
                    <label><i class="fa fa-calendar"></i> <?php echo lang('Hasta la Fecha'); ?></label>
                </div>
            </div>
            <div class="col-12 p-1 mb-4">
                <div class="form-floating">
                    <select class="form-select" id="TipoRetencion" onchange="CargarTablaRetenciones()">
                        <option value="*"><?php echo lang("Todos los Impuestos"); ?></option>
                        <option value="IVA"><?php echo lang("Retención de I.V.A."); ?></option>
                        <option value="ISLR"><?php echo lang("Retención de I.S.L.R."); ?></option>
                    </select>
                    <label><i class="fa fa-filter"></i> <?php echo lang('Tipo de Impuesto'); ?></label>
                </div>
            </div>
            <div class="col-12 p-1">
                <button class="btn btn-primary w-100 p-2 fs-5" type="button" onclick="CargarTablaRetenciones(); $('#PanelFiltros').offcanvas('hide');">
                    <i class="fa fa-search"></i> <?php echo lang("Aplicar Filtros"); ?>
                </button>
            </div>
        </div>
        <hr>
        <div class="row mt-2" style="font-size: 15px;">
            <button type="button" class="btn fs-5 text-secondary" data-bs-dismiss="offcanvas">
                <?php echo lang("Ocultar Panel"); ?> <i class="fa fa-arrow-right"></i>
            </button>
        </div>
    </div>
</div>

<script>
    var dtRetenciones = null;

    $(document).ready(function() {
        CargarTablaRetenciones();
    });

    function CargarTablaRetenciones() {
        var languageUrl = "lang/datatables/" + document.getElementById("IdiomaActual").innerHTML + ".json";

        if (dtRetenciones == null) {
            dtRetenciones = $('#TablaRetenciones').DataTable({
                dom: '<"row align-items-center mb-3"<"col-sm-12 col-md-6 d-flex justify-content-start"p><"col-sm-12 col-md-6 d-flex justify-content-end"f>>rt', 
                pageLength: 10, 
                pagingType: "simple_numbers",
                responsive: true,
                processing: true,
                serverSide: true,
                language: { 
                    url: languageUrl,
                    search: "<?php echo lang('Buscar'); ?>:",
                    paginate: {
                        previous: "<i class='fa fa-chevron-left me-1'></i>",
                        next: "<i class='fa fa-chevron-right ms-1'></i>"
                    }
                },
                ajax: {
                    type: "POST",
                    url: "retenciones_data_seek.php", 
                    data: function(d) { 
                        d.Accion = "BuscarRetenciones";
                        d.FechaDesde = $("#FiltroDesde").val();
                        d.FechaHasta = $("#FiltroHasta").val();
                        d.TipoRetencion = $("#TipoRetencion").val();
                        d.CompanyActual = "<?php echo $_SESSION['CompanyActual']; ?>";
                    }
                },
                columns: [
                    { data: "Tipo", orderable: false },
                    { data: "Fecha" },
                    { data: "Factura", orderable: false },
                    { data: "Empresa", orderable: false }, 
                    { data: "Base", className: "text-end", orderable: false },
                    { data: "Porcentaje", className: "text-center", orderable: false },
                    { data: "Retenido", className: "text-end", orderable: false }
                ],
                order: [[1, "desc"]] 
            });
        } else {
            dtRetenciones.ajax.reload(); 
        }
    }

    function ExportarMasivo(formato) {
        var form = document.getElementById("formExportarMasivo");
        
        document.getElementById("ExportFechaDesde").value = document.getElementById("FiltroDesde").value;
        document.getElementById("ExportFechaHasta").value = document.getElementById("FiltroHasta").value;
        document.getElementById("ExportTipoRetencion").value = document.getElementById("TipoRetencion").value;

        if (formato === 'XML') {
            form.action = 'exportar_retencion_xml.php'; 
        } else if (formato === 'TXT') {
            form.action = 'exportar_retencion_txt.php'; 
        } else if (formato === 'PDF') {
            form.action = 'exportar_retencion_pdf.php'; // <-- NUEVA ACCIÓN PARA EL PDF
        }
        form.submit();
    }
</script>