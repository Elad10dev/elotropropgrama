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

// Valores por defecto para las fechas (Desde el primer día del mes hasta hoy)
$fechaDesde = date('Y-m-01');
$fechaHasta = date('Y-m-d');
?>

<header id="header" class="d-print-none">
    <div class="container">
        <div class="row">
            <div class="col-md-8 d-none d-lg-block d-xl-block d-xxl-block">
                <h1>
                    <div>
                        <i><img src="/img/impuestos.png" width="24" height="24" onerror="this.src='/img/informez.png'"></i> <?php echo lang("Relación de Retenciones"); ?>
                    </div>
                    <div><small class="small fs-6"><?php echo lang("Gestión de ISLR e IVA"); ?></small></div>
                </h1>
            </div>
            <div class="col-lg-4 col-xs-12 row p-2" id="headerprintxd2"></div>
        </div>
    </div>
</header>

<nav aria-label="breadcrumb">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item "><a href="app.php?opcion=impuestosmenu.php"><?php echo lang("Impuestos"); ?></a></li>
            <li class="breadcrumb-item active"><?php echo lang("Relación de Retenciones"); ?></li>
        </ol>
    </div>
</nav>

<div class="container" id="contenedortotal">
    <div class='col-12 d-print-none'>
        
        <div class="row mb-3 shadow-sm p-3 bg-white rounded">
            <div class="col-12 col-md-3 p-1">
                <div class="form-floating">
                    <input class="form-control" type="date" id="FiltroDesde" name="FiltroDesde" value="<?php echo $fechaDesde; ?>">
                    <label><i class="fa fa-calendar"></i> <?php echo lang('Desde la Fecha'); ?></label>
                </div>
            </div>
            <div class="col-12 col-md-3 p-1">
                <div class="form-floating">
                    <input class="form-control" type="date" id="FiltroHasta" name="FiltroHasta" value="<?php echo $fechaHasta; ?>">
                    <label><i class="fa fa-calendar"></i> <?php echo lang('Hasta la Fecha'); ?></label>
                </div>
            </div>
            <div class="col-12 col-md-3 p-1">
                <div class="form-floating">
                    <select class="form-select" id="TipoRetencion" name="TipoRetencion">
                        <option value="*"><?php echo lang("Todos los Impuestos"); ?></option>
                        <option value="IVA"><?php echo lang("Retención de I.V.A."); ?></option>
                        <option value="ISLR"><?php echo lang("Retención de I.S.L.R."); ?></option>
                    </select>
                    <label><i class="fa fa-filter"></i> <?php echo lang('Tipo de Impuesto'); ?></label>
                </div>
            </div>
            <div class="col-12 col-md-3 p-1 d-flex align-items-center">
                <button class="btn btn-primary w-100" style="height: 58px;" onclick="CargarTablaRetenciones()">
                    <i class="fa fa-search"></i> <?php echo lang("Buscar"); ?>
                </button>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12 text-end">
                <form id="formExportar" action="" method="post" target="_blank" class="d-inline">
                    <input type="hidden" name="ExpDesde" id="ExpDesde">
                    <input type="hidden" name="ExpHasta" id="ExpHasta">
                    <input type="hidden" name="ExpTipo" id="ExpTipo">
                    <input type="hidden" name="CompanyActual" value="<?php echo $_SESSION['CompanyActual']; ?>">
                    
                    <button type="button" class="btn btn-outline-success" onclick="ExportarArchivo('XML')">
                        <i class="fa fa-file-code-o"></i> <?php echo lang("Exportar XML"); ?>
                    </button>
                    <button type="button" class="btn btn-outline-secondary" onclick="ExportarArchivo('TXT')">
                        <i class="fa fa-file-text-o"></i> <?php echo lang("Exportar TXT"); ?>
                    </button>
                </form>
            </div>
        </div>

        <span id='error_retencion' style='color:red'></span>
        
        <div class="table-responsive bg-white p-3 rounded shadow-sm">
            <table class="table table-hover table-striped nowrap" id="TablaRetenciones" cellspacing="0" style="width:100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th class="text-start"><?php echo lang("Fecha"); ?></th>
                        <th class="text-start"><?php echo lang("Comprobante"); ?></th>
                        <th class="text-start"><?php echo lang("Factura Afectada"); ?></th>
                        <th class="text-start"><?php echo lang("RIF"); ?></th>
                        <th class="text-start"><?php echo lang("Beneficiario"); ?></th>
                        <th class="text-center"><?php echo lang("Tipo"); ?></th>
                        <th class="text-end"><?php echo lang("Base Imponible"); ?></th>
                        <th class="text-center"><?php echo lang("% Ret"); ?></th>
                        <th class="text-end"><?php echo lang("Monto Retenido"); ?></th>
                    </tr>
                </thead>
                <tbody>
                    </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Variables globales de Datatable
    var dtRetenciones;

    $(document).ready(function() {
        // Inicializamos la tabla al cargar la página
        CargarTablaRetenciones();
    });

    function CargarTablaRetenciones() {
        var desde = $("#FiltroDesde").val();
        var hasta = $("#FiltroHasta").val();
        var tipo = $("#TipoRetencion").val();
        
        var languageUrl = "lang/datatables/" + document.getElementById("IdiomaActual").innerHTML + ".json";

        // Si ya existe la destruimos para volver a cargarla
        if ($.fn.DataTable.isDataTable('#TablaRetenciones')) {
            $('#TablaRetenciones').DataTable().destroy();
        }

        // Aquí apuntaremos al archivo PHP que devolverá el JSON (Lo crearemos en el siguiente paso)
        dtRetenciones = $('#TablaRetenciones').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            language: { url: languageUrl },
            ajax: {
                type: "POST",
                url: "retenciones_data_seek.php", // <--- Archivo pendiente por crear
                data: {
                    Accion: "BuscarRetenciones",
                    FechaDesde: desde,
                    FechaHasta: hasta,
                    TipoRetencion: tipo,
                    CompanyActual: "<?php echo $_SESSION['CompanyActual']; ?>"
                }
            },
            columns: [
                { data: "Fecha" },
                { data: "Comprobante" },
                { data: "Factura" },
                { data: "RIF" },
                { data: "Beneficiario" },
                { data: "Tipo", className: "text-center font-weight-bold" },
                { data: "Base", className: "text-end" },
                { data: "Porcentaje", className: "text-center" },
                { data: "Retenido", className: "text-end font-weight-bold text-danger" }
            ],
            order: [[0, "desc"]] // Ordenar por fecha descendente por defecto
        });
    }

    function ExportarArchivo(formato) {
        var form = document.getElementById("formExportar");
        
        // Pasamos los filtros actuales al formulario oculto
        document.getElementById("ExpDesde").value = $("#FiltroDesde").val();
        document.getElementById("ExpHasta").value = $("#FiltroHasta").val();
        document.getElementById("ExpTipo").value = $("#TipoRetencion").val();

        if (formato === 'XML') {
            form.action = 'exportar_retenciones_xml.php'; // Archivo que crearemos luego
        } else if (formato === 'TXT') {
            form.action = 'exportar_retenciones_txt.php'; // Archivo que crearemos luego
        }

        form.submit();
    }
</script>