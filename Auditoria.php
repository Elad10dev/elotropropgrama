<?php
$usuario = '';
$sql = "SELECT Login,Nombre FROM PosUpUsers WHERE IdCompany=" . $_SESSION["CompanyActual"] . "";
if ($result = mysqli_query($conn, $sql)) {
    while ($row = mysqli_fetch_array($result)) {
        $usuario .= "<option value='" . $row["Login"] . "'>" . $row["Nombre"] . "</option>";
    }
}
$impuestos = '';
$sql = "SELECT IdVarios,ITEM FROM PosUpvarios WHERE IdCompany=" . $_SESSION["CompanyActual"] . " and TIPOITEM = 0";
if ($result = mysqli_query($conn, $sql)) {
    while ($row = mysqli_fetch_array($result)) {
        $impuestos .= "<option value='" . $row["IdVarios"] . "'>" . $row["ITEM"] . "</option>";
    }
}
$maquinafiscal = '';
$sql = "SELECT numctrol FROM posuptxc WHERE IdCompany=" . $_SESSION["CompanyActual"] . " AND numctrol like 'Z%' GROUP BY numctrol";
if ($result = mysqli_query($conn, $sql)) {
    while ($row = mysqli_fetch_array($result)) {
        $maquinafiscal .= "<option value='" . $row["numctrol"] . "'>" . $row["numctrol"] . "</option>";
    }
}
$tipo = '';
$sql = "
SELECT
    Tipo
FROM
	posupauditoria a
where
	a.IdCompany = " . $_SESSION["CompanyActual"] . " 
    AND a.IdReg = 'USO'
    AND a.Tipo in ('Ingreso al sistema','Accedio','Acceso Denegado')
    GROUP BY a.Tipo
";
if ($result = mysqli_query($conn, $sql)) {
    while ($row = mysqli_fetch_array($result)) {
        $tipo .= "<option value='" . $row["Tipo"] . "'>" . $row["Tipo"] . "</option>";
    }
}

$tabla = '';
$sql = "
SELECT
    Tabla
FROM
	posupauditoria a
where
	a.IdCompany = " . $_SESSION["CompanyActual"] . " 
    AND a.IdReg = 'USO'
    AND a.Tipo in ('Ingreso al sistema','Accedio','Acceso Denegado')
    GROUP BY a.Tabla
";
if ($result = mysqli_query($conn, $sql)) {
    while ($row = mysqli_fetch_array($result)) {
        $tabla .= "<option value='" . $row["Tabla"] . "'>" . $row["Tabla"] . "</option>";
    }
}
/*
$tipo2 = '';
$sql = "
SELECT
    Tipo
FROM
	posupauditoria a
where
	a.IdCompany = " . $_SESSION["CompanyActual"] . " 
    AND a.IdReg = 'USO'
    AND a.Tipo in ('Acceso Denegado')
    GROUP BY a.Tipo
";
if ($result = mysqli_query($conn, $sql)) {
    while ($row = mysqli_fetch_array($result)) {
        $tipo2 .= "<option value='" . $row["Tipo"] . "'>" . $row["Tipo"] . "</option>";
    }
}

$tabla2 = '';
$sql = "
SELECT
    Tabla
FROM
	posupauditoria a
where
	a.IdCompany = " . $_SESSION["CompanyActual"] . " 
    AND a.IdReg = 'USO'
    AND a.Tipo in ('Acceso Denegado')
    GROUP BY a.Tabla
";
if ($result = mysqli_query($conn, $sql)) {
    while ($row = mysqli_fetch_array($result)) {
        $tabla2 .= "<option value='" . $row["Tabla"] . "'>" . $row["Tabla"] . "</option>";
    }
}
*/
?>
<header id="header">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1><i><img src="/img/Auditoria.png" width="20" height="20"></i> <?php echo lang("Auditoría"); ?> </h1>
            </div>
            <div class="col-md-4 row ">
                <div class="col-11">
                    <small></small>
                </div>
                <div class="col-1">
                </div>
            </div>
        </div>
    </div>
</header>
<div class="container" id='option' style='padding-bottom:78px;'>
    <?php

    if ($_SESSION['userperfil'] == '2000' || $_SESSION['userperfil'] == '4000') {
    ?>
        <!-- Modal -->
        <div class="modal fade" id="filtroModal" tabindex="-1" aria-labelledby="filtroModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="formFiltros">
                        <div class="modal-header">
                            <h5 class="modal-title" id="filtroModalLabel">Parámetros del Reporte</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-2">
                                <label for="desde" class="form-label">Desde:</label>
                                <input type="datetime-local" id="desde" class="form-control">
                            </div>
                            <div class="mb-2">
                                <label for="hasta" class="form-label">Hasta:</label>
                                <input type="datetime-local" id="hasta" class="form-control">
                            </div>

                            <div class="mb-2">
                                <label for="desde" class="form-label">Usuario:</label>
                                <select class="form-control" id="usuarioemitidos" name="usuarioemitidos[]" style="width:100%;" multiple>
                                    <?php
                                    echo $usuario;
                                    ?>
                                </select>
                            </div>
                        </div>

                    </form>
                    <div class="modal-footer">
                        <button type="button" onclick="DocumentosEmitidos()" class="btn btn-outline-primary p-1 m-1">
                            <i class="fa fa-arrow-right"> </i> <?php echo lang('Generar Reporte'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="filtroModalHistorico" tabindex="-1" aria-labelledby="filtroModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="filtroModalLabelHistorico">Parámetros del Reporte</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <form id="formFiltrosHistoricos">
                        <div class="modal-body">
                            <div class="mb-2">
                                <label for="desde" class="form-label">Desde:</label>
                                <input type="datetime-local" id="desdeHistorico" class="form-control">
                            </div>
                            <div class="mb-2">
                                <label for="hasta" class="form-label">Hasta:</label>
                                <input type="datetime-local" id="hastaHistorico" class="form-control">
                            </div>

                            <div class="mb-2">
                                <label for="desde" class="form-label">Usuario:</label>
                                <select class="form-control" id="usuarioHistorico" name="usuarioHistorico[]" style="width:100%;" multiple>
                                    <?php
                                    echo $usuario;
                                    ?>
                                </select>
                            </div>
                        </div>

                    </form>
                    <div class="modal-footer">
                        <button type="button" onclick="HistoricoTasas()" class="btn btn-outline-primary p-1 m-1">
                            <i class="fa fa-arrow-right"> </i> <?php echo lang('Generar Reporte'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="filtroModalImpuesto" tabindex="-1" aria-labelledby="filtroModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="filtroModalLabelHistorico">Parámetros del Reporte</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <form id="formFiltrosHistoricos">
                        <div class="modal-body">
                            <div class="mb-2">
                                <label for="desde" class="form-label">Desde:</label>
                                <input type="datetime-local" id="desdeImpuesto" class="form-control">
                            </div>
                            <div class="mb-2">
                                <label for="hasta" class="form-label">Hasta:</label>
                                <input type="datetime-local" id="hastaImpuesto" class="form-control">
                            </div>

                            <div class="mb-2">
                                <label for="desde" class="form-label">Usuario:</label>
                                <select class="form-control" id="usuarioImpuesto" name="usuarioImpuesto[]" style="width:100%;" multiple>
                                    <?php
                                    echo $usuario;
                                    ?>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label for="desde" class="form-label">Impuesto:</label>
                                <select class="form-control" id="addImpuesto" name="addImpuesto[]" style="width:100%;" multiple>
                                    <?php
                                    echo $impuestos;
                                    ?>
                                    <option value='Eliminados'>Mostrar Eliminados</option>
                                </select>
                            </div>
                        </div>

                    </form>
                    <div class="modal-footer">
                        <button type="button" onclick="HistoricoImpuesto()" class="btn btn-outline-primary p-1 m-1">
                            <i class="fa fa-arrow-right"> </i> <?php echo lang('Generar Reporte'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="filtroModalOperaciones" tabindex="-1" aria-labelledby="filtroModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="filtroModalLabelHistorico">Parámetros del Reporte</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <form id="formFiltrosModalOperaciones">
                        <div class="modal-body">
                            <div class="mb-2">
                                <label for="desde" class="form-label">Desde:</label>
                                <input type="datetime-local" id="desdeOperaciones" class="form-control">
                            </div>
                            <div class="mb-2">
                                <label for="hasta" class="form-label">Hasta:</label>
                                <input type="datetime-local" id="hastaOperaciones" class="form-control">
                            </div>

                            <div class="mb-2">
                                <label for="desde" class="form-label">Usuario:</label>
                                <select class="form-control" id="usuarioOperaciones" style="width:100%;" multiple>
                                    <?php
                                    echo $usuario;
                                    ?>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label for="desde" class="form-label">Tablas:</label>
                                <select class="form-control" id="TablasOperaciones" style="width:100%;" multiple>
                                    <?php
                                    echo $tabla;
                                    ?>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label for="desde" class="form-label">Tipo:</label>
                                <select class="form-control" id="TipoOperaciones" style="width:100%;" multiple>
                                    <?php
                                    echo $tipo;
                                    ?>
                                </select>
                            </div>
                        </div>

                    </form>
                    <div class="modal-footer">
                        <button type="button" onclick="HistoricoOperaciones()" class="btn btn-outline-primary p-1 m-1">
                            <i class="fa fa-arrow-right"> </i> <?php echo lang('Generar Reporte'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="filtroModalEventosCriticos" tabindex="-1" aria-labelledby="filtroModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="filtroModalLabelHistorico">Parámetros del Reporte</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <form id="formFiltrosEventosCriticoss">
                        <div class="modal-body">
                            <div class="mb-2">
                                <label for="hasta" class="form-label">Hasta:</label>
                                <input type="datetime-local" id="hastaEventosCriticos" class="form-control">
                            </div>
                            <div class="mb-2">
                                <label for="desde" class="form-label">Rango:</label>
                                <select name="RangodeDias" id="RangodeDias" class="form-select">
                                    <?php
                                    $i = 1;
                                    while ($i < 14) {
                                        echo "<option value='" . $i . "'>" . $i . " " . ($i === 1 ? lang("Dia atras") : lang("Dias atras")) . "</option>";
                                        $i++;
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                    </form>
                    <div class="modal-footer">
                        <button type="button" onclick="HistoricoEventosCriticos()" class="btn btn-outline-primary p-1 m-1">
                            <i class="fa fa-arrow-right"> </i> <?php echo lang('Generar Reporte'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="filtroModalHistoricoInteraccion" tabindex="-1" aria-labelledby="filtroModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="filtroModalLabelHistorico">Parámetros del Reporte</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <form id="formFiltrosHistoricoInteraccion">
                        <div class="modal-body">
                            <div class="mb-2">
                                <label for="desde" class="form-label">Desde:</label>
                                <input type="datetime-local" id="desdeHistoricoInteraccion" class="form-control">
                            </div>
                            <div class="mb-2">
                                <label for="hasta" class="form-label">Hasta:</label>
                                <input type="datetime-local" id="hastaHistoricoInteraccion" class="form-control">
                            </div>

                            <div class="mb-2">
                                <label for="desde" class="form-label">Impresora Fiscal:</label>
                                <select class="form-control" id="maquinaHistoricoInteraccion" style="width:100%;" multiple>
                                    <?php
                                    echo $maquinafiscal;
                                    ?>
                                </select>
                            </div>
                        </div>

                    </form>
                    <div class="modal-footer">
                        <button type="button" onclick="HistoricoHistoricoInteraccion()" class="btn btn-outline-primary p-1 m-1">
                            <i class="fa fa-arrow-right"> </i> <?php echo lang('Generar Reporte'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="filtroModalHistoricoError" tabindex="-1" aria-labelledby="filtroModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="filtroModalLabelHistorico">Parámetros del Reporte</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <form id="formFiltrosHistoricoError">
                        <div class="modal-body">
                            <div class="mb-2">
                                <label for="desde" class="form-label">Desde:</label>
                                <input type="datetime-local" id="desdeHistoricoError" class="form-control">
                            </div>
                            <div class="mb-2">
                                <label for="hasta" class="form-label">Hasta:</label>
                                <input type="datetime-local" id="hastaHistoricoError" class="form-control">
                            </div>

                            <div class="mb-2">
                                <label for="desde" class="form-label">Impresora Fiscal:</label>
                                <select class="form-control" id="maquinaHistoricoError" style="width:100%;" multiple>
                                    <?php
                                    echo $maquinafiscal;
                                    ?>
                                </select>
                            </div>
                        </div>

                    </form>
                    <div class="modal-footer">
                        <button type="button" onclick="HistoricoHistoricoError()" class="btn btn-outline-primary p-1 m-1">
                            <i class="fa fa-arrow-right"> </i> <?php echo lang('Generar Reporte'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="MovimientosCaja" tabindex="-1" aria-labelledby="filtroModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="filtroModalLabelHistorico">Parámetros del Reporte</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <form id="formFiltrosMovimientosCaja">
                        <div class="modal-body">
                            <div class="mb-2">
                                <label for="desde" class="form-label">Desde:</label>
                                <input type="datetime-local" id="desdeMovimientosCaja" class="form-control">
                            </div>
                            <div class="mb-2">
                                <label for="hasta" class="form-label">Hasta:</label>
                                <input type="datetime-local" id="hastaMovimientosCaja" class="form-control">
                            </div>

                            <div class="mb-2">
                                <label for="CajaMovimientosCaja" class="form-label">Estación POS:</label>
                                <select class="form-control" id="CajaMovimientosCaja" name="CajaMovimientosCaja[]" style="width:100%;" multiple>
                                    <?php
                                    $query = "SELECT token,etiqueta FROM PosUpCompanyEstacion WHERE IdCompany=" . $_SESSION["CompanyActual"] . " and transdecaja = 1";
                                    if ($result = mysqli_query($conn, $query)) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                            <option value="<?php echo trim($row['token']); ?>"><?php echo trim($row['etiqueta']); ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label for="desde" class="form-label">Usuario:</label>
                                <select class="form-control" id="usuarioMovimientosCaja" name="usuarioMovimientosCaja[]" style="width:100%;" multiple>
                                    <?php
                                    echo $usuario;
                                    ?>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label for="desde" class="form-label">Acción:</label>
                                <select class="form-control" id="accionMovimientoCaja" name="accionMovimientoCaja[]" style="width:100%;" multiple>
                                    <?php
                                    foreach (
                                        [
                                            "Abrir Arqueo",
                                            "Agregar Arqueo",
                                            "Cerrar Arqueo",
                                            "Cierre de Caja",
                                            "Cuadrar Caja",
                                            "Imprimir Cierre de Caja",
                                            "Inicio de Caja",
                                            "Reabrir Caja",
                                        ] as $val
                                    ) {
                                    ?>
                                        <option value="<?php echo $val; ?>"> <?php echo $val; ?></option>

                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                    </form>
                    <div class="modal-footer">
                        <button type="button" onclick="MovimientosCajaBBC()" class="btn btn-outline-primary p-1 m-1">
                            <i class="fa fa-arrow-right"> </i> <?php echo lang('Generar Reporte'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card border-light mb-2 col-md-4">
                <div class="card-body">
                    <h2><img src="/img/documentosemitidos.png"> </h2>
                    <h4><?php echo lang('Documentos Emitidos'); ?></h4>

                    <button class="btn btn-outline-primary p-1 m-1" data-bs-toggle="modal" data-bs-target="#filtroModal">
                        <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?>
                    </button>
                </div>
            </div>
            <div class="card border-light mb-2 col-md-4">
                <div class="card-body">
                    <h2><img src="/img/historiacambiotasa.png"> </h2>
                    <h4><?php echo lang('Histórico Tasas de Cambio'); ?></h4>

                    <button class="btn btn-outline-primary p-1 m-1" data-bs-toggle="modal" data-bs-target="#filtroModalHistorico">
                        <!-- data-bs-target="#filtroModal" -->
                        <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?>
                    </button>
                </div>
            </div>
            <div class="card border-light mb-2 col-md-4">
                <div class="card-body">
                    <h2><img src="/img/histimpuesto.png"> </h2>
                    <h4><?php echo lang('Histórico Tasas de Impuestos'); ?></h4>

                    <button class="btn btn-outline-primary p-1 m-1" data-bs-toggle="modal" data-bs-target="#filtroModalImpuesto">
                        <!-- data-bs-target="#filtroModal" -->
                        <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?>
                    </button>
                </div>
            </div>
            <div class="card border-light mb-2 col-md-4">
                <div class="card-body">
                    <h2><img src="/img/operacionesuser.png"> </h2>
                    <h4><?php echo lang('Histórico Operaciones realizadas por usuarios'); ?></h4>

                    <button class="btn btn-outline-primary p-1 m-1" data-bs-toggle="modal" data-bs-target="#filtroModalOperaciones">
                        <!-- data-bs-target="#filtroModal" -->
                        <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?>
                    </button>
                </div>
            </div>

            <div class="card border-light mb-2 col-md-4">
                <div class="card-body">
                    <h2><img src="/img/errorescriticossistema.png"> </h2>
                    <h4><?php echo lang('Eventos críticos del sistema'); ?></h4>

                    <button class="btn btn-outline-primary p-1 m-1" data-bs-toggle="modal" data-bs-target="#filtroModalEventosCriticos">
                        <!-- data-bs-target="#filtroModal" -->
                        <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?>
                    </button>
                </div>
            </div>
            <div class="card border-light mb-2 col-md-4">
                <div class="card-body">
                    <h2><img src="/img/printerfiscal.png"> </h2>
                    <h4><?php echo lang('Histórico de Interacción con Impresoras fiscales'); ?></h4>

                    <button class="btn btn-outline-primary p-1 m-1" data-bs-toggle="modal" data-bs-target="#filtroModalHistoricoInteraccion">
                        <!-- data-bs-target="#filtroModal" -->
                        <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?>
                    </button>
                </div>
            </div>
            <div class="card border-light mb-2 col-md-4">
                <div class="card-body">
                    <h2><img src="/img/eventosprinterfiscal.png"> </h2>
                    <h4><?php echo lang('Histórico de Errores y eventos asociados con Impresoras fiscales'); ?></h4>

                    <button class="btn btn-outline-primary p-1 m-1" data-bs-toggle="modal" data-bs-target="#filtroModalHistoricoError">
                        <!-- data-bs-target="#filtroModal" -->
                        <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?>
                    </button>
                </div>
            </div>
            <div class="card border-light mb-2 col-md-4">
                <div class="card-body">
                    <!-- <h2><img src="/img/eventosprinterfiscal.png"> </h2> -->
                    <h4><?php echo lang('Movimientos de Caja'); ?></h4>

                    <button class="btn btn-outline-primary p-1 m-1" data-bs-toggle="modal" data-bs-target="#MovimientosCaja">
                        <!-- data-bs-target="#filtroModal" -->
                        <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?>
                    </button>
                </div>
            </div>
        </div>
    <?php

    }
    ?>

</div>
<!-- Script para manejar fechas y envío -->
<script>
    function MovimientosCajaBBC() {
        const desde = document.getElementById('desdeMovimientosCaja').value;
        const hasta = document.getElementById('hastaMovimientosCaja').value;
        const CompanyActual = document.getElementById('CompanyActual').innerHTML;
        const CD = document.getElementById('CD').innerHTML;
        const SimDec = document.getElementById('SimDec').innerHTML;
        const SimMil = document.getElementById('SimMil').innerHTML;
        const NameCompanyActual = document.getElementById('NameCompanyActual').innerHTML;
        const litfiscal = document.getElementById('litfiscal').innerHTML;
        const direccionActSe = document.getElementById('direccionActSe').innerHTML;
        const IDFiscal = document.getElementById('ruteAcx').innerHTML;
        const caja = $("#CajaMovimientosCaja").val();
        const users = $("#usuarioMovimientosCaja").val();
        const accion = $("#accionMovimientoCaja").val();

        if (!desde || !hasta || new Date(desde) > new Date(hasta)) {
            alert('Please make sure the dates are valid and "from" is not after "to".');
            return;
        }

        // Open the popup window first
        const newWindow = window.open('', 'reportWindow', 'width=900,height=800');

        // Create form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'historialcaja.php';
        form.target = 'reportWindow';

        // Helper to append input fields
        function addField(name, value) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value;
            form.appendChild(input);
        }

        addField('desde', desde);
        addField('hasta', hasta);
        addField('CompanyActual', CompanyActual);
        addField('CD', CD);
        addField('SimDec', SimDec);
        addField('SimMil', SimMil);
        addField('NameCompanyActual', NameCompanyActual);
        addField('litfiscal', litfiscal);
        addField('direccion', direccionActSe);
        addField('IDFiscal', IDFiscal);
        addField('types', caja);
        addField('users', users);
        addField('accion', accion);

        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);

        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('MovimientosCaja'));
        modal.hide();
    }

    function HistoricoHistoricoError() {
        const desde = document.getElementById('desdeHistoricoError').value;
        const hasta = document.getElementById('hastaHistoricoError').value;
        const CompanyActual = document.getElementById('CompanyActual').innerHTML;
        const CD = document.getElementById('CD').innerHTML;
        const SimDec = document.getElementById('SimDec').innerHTML;
        const SimMil = document.getElementById('SimMil').innerHTML;
        const NameCompanyActual = document.getElementById('NameCompanyActual').innerHTML;
        const litfiscal = document.getElementById('litfiscal').innerHTML;
        const direccionActSe = document.getElementById('direccionActSe').innerHTML;
        const IDFiscal = document.getElementById('ruteAcx').innerHTML;
        const types = $("#maquinaHistoricoError").val();

        if (!desde || !hasta || new Date(desde) > new Date(hasta)) {
            alert('Please make sure the dates are valid and "from" is not after "to".');
            return;
        }

        // Open the popup window first
        const newWindow = window.open('', 'reportWindow', 'width=900,height=800');

        // Create form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'historicoerror.php';
        form.target = 'reportWindow';

        // Helper to append input fields
        function addField(name, value) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value;
            form.appendChild(input);
        }

        addField('desde', desde);
        addField('hasta', hasta);
        addField('CompanyActual', CompanyActual);
        addField('CD', CD);
        addField('SimDec', SimDec);
        addField('SimMil', SimMil);
        addField('NameCompanyActual', NameCompanyActual);
        addField('litfiscal', litfiscal);
        addField('direccion', direccionActSe);
        addField('IDFiscal', IDFiscal);
        addField('types', types);

        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);

        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('filtroModalHistoricoError'));
        modal.hide();
    }

    function HistoricoHistoricoInteraccion() {
        const desde = document.getElementById('desdeHistoricoInteraccion').value;
        const hasta = document.getElementById('hastaHistoricoInteraccion').value;
        const CompanyActual = document.getElementById('CompanyActual').innerHTML;
        const CD = document.getElementById('CD').innerHTML;
        const SimDec = document.getElementById('SimDec').innerHTML;
        const SimMil = document.getElementById('SimMil').innerHTML;
        const NameCompanyActual = document.getElementById('NameCompanyActual').innerHTML;
        const litfiscal = document.getElementById('litfiscal').innerHTML;
        const direccionActSe = document.getElementById('direccionActSe').innerHTML;
        const IDFiscal = document.getElementById('ruteAcx').innerHTML;
        const types = $("#maquinaHistoricoInteraccion").val();

        if (!desde || !hasta || new Date(desde) > new Date(hasta)) {
            alert('Please make sure the dates are valid and "from" is not after "to".');
            return;
        }

        // Open the popup window first
        const newWindow = window.open('', 'reportWindow', 'width=900,height=800');

        // Create form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'historicointeraccion.php';
        form.target = 'reportWindow';

        // Helper to append input fields
        function addField(name, value) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value;
            form.appendChild(input);
        }

        addField('desde', desde);
        addField('hasta', hasta);
        addField('CompanyActual', CompanyActual);
        addField('CD', CD);
        addField('SimDec', SimDec);
        addField('SimMil', SimMil);
        addField('NameCompanyActual', NameCompanyActual);
        addField('litfiscal', litfiscal);
        addField('direccion', direccionActSe);
        addField('IDFiscal', IDFiscal);
        addField('types', types);

        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);

        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('filtroModalHistoricoInteraccion'));
        modal.hide();
    }

    function addDaysToDate(date, days) {
        let new_date = new Date(date);
        new_date.setDate(new_date.getDate() + days);
        return new_date;
    }


    function HistoricoEventosCriticos() {
        const hasta = document.getElementById('hastaEventosCriticos').value;
        const fecha = addDaysToDate(hasta, parseInt(document.getElementById("RangodeDias").value) * -1);
        var mes = fecha.getMonth() + 1;
        var dia = fecha.getDate();
        var hora = fecha.getHours();
        var min = fecha.getMinutes();
        var seg = fecha.getSeconds();
        if (dia < 10) dia = "0" + dia;
        if (mes < 10) mes = "0" + mes;
        if (hora < 10) hora = "0" + hora;
        if (seg < 10) seg = "0" + seg;

        const desde = fecha.getFullYear() +
            "-" +
            mes +
            "-" +
            dia +
            " " +
            hora +
            ":" +
            min +
            ":" +
            seg;
        const CompanyActual = document.getElementById('CompanyActual').innerHTML;
        const CD = document.getElementById('CD').innerHTML;
        const SimDec = document.getElementById('SimDec').innerHTML;
        const SimMil = document.getElementById('SimMil').innerHTML;
        const NameCompanyActual = document.getElementById('NameCompanyActual').innerHTML;
        const litfiscal = document.getElementById('litfiscal').innerHTML;
        const direccionActSe = document.getElementById('direccionActSe').innerHTML;
        const IDFiscal = document.getElementById('ruteAcx').innerHTML;

        if (!desde || !hasta || new Date(desde) > new Date(hasta)) {
            alert('Please make sure the dates are valid and "from" is not after "to".');
            return;
        }

        // Open the popup window first
        const newWindow = window.open('', 'reportWindow', 'width=900,height=800');

        // Create form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'historicoeventoscriticos.php';
        form.target = 'reportWindow';

        // Helper to append input fields
        function addField(name, value) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value;
            form.appendChild(input);
        }

        addField('desde', desde);
        addField('hasta', hasta);
        addField('CompanyActual', CompanyActual);
        addField('CD', CD);
        addField('SimDec', SimDec);
        addField('SimMil', SimMil);
        addField('NameCompanyActual', NameCompanyActual);
        addField('litfiscal', litfiscal);
        addField('direccion', direccionActSe);
        addField('IDFiscal', IDFiscal);

        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);

        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('filtroModalHistorico'));
        modal.hide();
    }

    function HistoricoOperaciones() {
        const desde = document.getElementById('desdeOperaciones').value;
        const hasta = document.getElementById('hastaOperaciones').value;
        const CompanyActual = document.getElementById('CompanyActual').innerHTML;
        const CD = document.getElementById('CD').innerHTML;
        const SimDec = document.getElementById('SimDec').innerHTML;
        const SimMil = document.getElementById('SimMil').innerHTML;
        const NameCompanyActual = document.getElementById('NameCompanyActual').innerHTML;
        const litfiscal = document.getElementById('litfiscal').innerHTML;
        const direccionActSe = document.getElementById('direccionActSe').innerHTML;
        const IDFiscal = document.getElementById('ruteAcx').innerHTML;
        const users = $("#usuarioOperaciones").val();
        const tables = $("#TablasOperaciones").val();
        const types = $("#TipoOperaciones").val();

        if (!desde || !hasta || new Date(desde) > new Date(hasta)) {
            alert('Please make sure the dates are valid and "from" is not after "to".');
            return;
        }

        // Open the popup window first
        const newWindow = window.open('', 'reportWindow', 'width=900,height=800');

        // Create form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'historicooperaciones.php';
        form.target = 'reportWindow';

        // Helper to append input fields
        function addField(name, value) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value;
            form.appendChild(input);
        }

        addField('desde', desde);
        addField('hasta', hasta);
        addField('CompanyActual', CompanyActual);
        addField('CD', CD);
        addField('SimDec', SimDec);
        addField('SimMil', SimMil);
        addField('NameCompanyActual', NameCompanyActual);
        addField('litfiscal', litfiscal);
        addField('direccion', direccionActSe);
        addField('IDFiscal', IDFiscal);
        addField('users', users);
        addField('tables', tables);
        addField('types', types);

        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);

        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('filtroModalHistorico'));
        modal.hide();
    }

    function HistoricoImpuesto() {
        const desde = document.getElementById('desdeImpuesto').value;
        const hasta = document.getElementById('hastaImpuesto').value;
        const CompanyActual = document.getElementById('CompanyActual').innerHTML;
        const CD = document.getElementById('CD').innerHTML;
        const SimDec = document.getElementById('SimDec').innerHTML;
        const SimMil = document.getElementById('SimMil').innerHTML;
        const NameCompanyActual = document.getElementById('NameCompanyActual').innerHTML;
        const litfiscal = document.getElementById('litfiscal').innerHTML;
        const direccionActSe = document.getElementById('direccionActSe').innerHTML;
        const IDFiscal = document.getElementById('ruteAcx').innerHTML;
        const users = $("#usuarioImpuesto").val();
        const impuesto = $("#addImpuesto").val();

        if (!desde || !hasta || new Date(desde) > new Date(hasta)) {
            alert('Please make sure the dates are valid and "from" is not after "to".');
            return;
        }

        // Open the popup window first
        const newWindow = window.open('', 'reportWindow', 'width=900,height=800');

        // Create form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'historicoimpuesto.php';
        form.target = 'reportWindow';

        // Helper to append input fields
        function addField(name, value) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value;
            form.appendChild(input);
        }

        addField('desde', desde);
        addField('hasta', hasta);
        addField('CompanyActual', CompanyActual);
        addField('CD', CD);
        addField('SimDec', SimDec);
        addField('SimMil', SimMil);
        addField('NameCompanyActual', NameCompanyActual);
        addField('litfiscal', litfiscal);
        addField('direccion', direccionActSe);
        addField('IDFiscal', IDFiscal);
        addField('users', users);
        addField('tax', impuesto);

        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);

        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('filtroModalHistorico'));
        modal.hide();
    }

    function HistoricoTasas() {
        const desde = document.getElementById('desdeHistorico').value;
        const hasta = document.getElementById('hastaHistorico').value;
        const CompanyActual = document.getElementById('CompanyActual').innerHTML;
        const CD = document.getElementById('CD').innerHTML;
        const SimDec = document.getElementById('SimDec').innerHTML;
        const SimMil = document.getElementById('SimMil').innerHTML;
        const NameCompanyActual = document.getElementById('NameCompanyActual').innerHTML;
        const litfiscal = document.getElementById('litfiscal').innerHTML;
        const direccionActSe = document.getElementById('direccionActSe').innerHTML;
        const IDFiscal = document.getElementById('ruteAcx').innerHTML;
        const users = $("#usuarioHistorico").val();

        if (!desde || !hasta || new Date(desde) > new Date(hasta)) {
            alert('Please make sure the dates are valid and "from" is not after "to".');
            return;
        }

        // Open the popup window first
        const newWindow = window.open('', 'reportWindow', 'width=900,height=800');

        // Create form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'historicoTasasCambio.php';
        form.target = 'reportWindow';

        // Helper to append input fields
        function addField(name, value) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value;
            form.appendChild(input);
        }

        addField('desde', desde);
        addField('hasta', hasta);
        addField('CompanyActual', CompanyActual);
        addField('CD', CD);
        addField('SimDec', SimDec);
        addField('SimMil', SimMil);
        addField('NameCompanyActual', NameCompanyActual);
        addField('litfiscal', litfiscal);
        addField('direccion', direccionActSe);
        addField('IDFiscal', IDFiscal);
        addField('users', users);

        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);

        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('filtroModalHistorico'));
        modal.hide();
    }

    function DocumentosEmitidos() {

        const desde = document.getElementById('desde').value;
        const hasta = document.getElementById('hasta').value;
        const CompanyActual = document.getElementById('CompanyActual').innerHTML;
        const CD = document.getElementById('CD').innerHTML;
        const SimDec = document.getElementById('SimDec').innerHTML;
        const SimMil = document.getElementById('SimMil').innerHTML;
        const NameCompanyActual = document.getElementById('NameCompanyActual').innerHTML;
        const litfiscal = document.getElementById('litfiscal').innerHTML;
        const direccionActSe = document.getElementById('direccionActSe').innerHTML;
        const IDFiscal = document.getElementById('ruteAcx').innerHTML;
        const users = $("#usuarioemitidos").val();

        if (!desde || !hasta || new Date(desde) > new Date(hasta)) {
            alert('Please make sure the dates are valid and "from" is not after "to".');
            return;
        }

        // Open the popup window first
        const newWindow = window.open('', 'reportWindow', 'width=900,height=800');

        // Create form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'testreporte.php';
        form.target = 'reportWindow';

        // Helper to append input fields
        function addField(name, value) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value;
            form.appendChild(input);
        }

        addField('desde', desde);
        addField('hasta', hasta);
        addField('CompanyActual', CompanyActual);
        addField('CD', CD);
        addField('SimDec', SimDec);
        addField('SimMil', SimMil);
        addField('NameCompanyActual', NameCompanyActual);
        addField('litfiscal', litfiscal);
        addField('direccion', direccionActSe);
        addField('IDFiscal', IDFiscal);
        addField('users', users);

        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);

        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('filtroModal'));
        modal.hide();
    }

    document.addEventListener("DOMContentLoaded", function() {
        // Obtener fechas del mes actual por defecto

        $("#usuarioHistorico").select2({
            dropdownParent: $("#filtroModalHistorico"),
        });

        $("#usuarioemitidos").select2({
            dropdownParent: $("#filtroModal"),
        });

        $("#usuarioOperaciones").select2({
            dropdownParent: $("#filtroModalOperaciones"),
        });

        $("#TablasOperaciones").select2({
            dropdownParent: $("#filtroModalOperaciones"),
        });

        $("#TipoOperaciones").select2({
            dropdownParent: $("#filtroModalOperaciones"),
        });

        $("#usuarioImpuesto").select2({
            dropdownParent: $("#filtroModalImpuesto"),
        });

        $("#addImpuesto").select2({
            dropdownParent: $("#filtroModalImpuesto"),
        });

        $("#maquinaHistoricoInteraccion").select2({
            dropdownParent: $("#filtroModalHistoricoInteraccion"),
        });

        $("#maquinaHistoricoError").select2({
            dropdownParent: $("#filtroModalHistoricoError"),
        });
        $("#CajaMovimientosCaja").select2({
            dropdownParent: $("#MovimientosCaja"),
        });
        $("#usuarioMovimientosCaja").select2({
            dropdownParent: $("#MovimientosCaja"),
        });
        $("#accionMovimientoCaja").select2({
            dropdownParent: $("#MovimientosCaja"),
        });



        const ahora = new Date();
        const inicioMes = new Date(ahora.getFullYear(), ahora.getMonth(), 1, 0, 0);

        document.getElementById('desde').value = inicioMes.toISOString().slice(0, 16);
        document.getElementById('hasta').value = ahora.toISOString().slice(0, 16);

        document.getElementById('desdeHistorico').value = inicioMes.toISOString().slice(0, 16);
        document.getElementById('hastaHistorico').value = ahora.toISOString().slice(0, 16);

        document.getElementById('desdeImpuesto').value = inicioMes.toISOString().slice(0, 16);
        document.getElementById('hastaImpuesto').value = ahora.toISOString().slice(0, 16);

        document.getElementById('desdeOperaciones').value = inicioMes.toISOString().slice(0, 16);
        document.getElementById('hastaOperaciones').value = ahora.toISOString().slice(0, 16);

        document.getElementById('desdeHistoricoError').value = inicioMes.toISOString().slice(0, 16);
        document.getElementById('hastaHistoricoError').value = ahora.toISOString().slice(0, 16);

        document.getElementById('desdeHistoricoInteraccion').value = inicioMes.toISOString().slice(0, 16);
        document.getElementById('hastaHistoricoInteraccion').value = ahora.toISOString().slice(0, 16);

        document.getElementById('desdeMovimientosCaja').value = inicioMes.toISOString().slice(0, 16);
        document.getElementById('hastaMovimientosCaja').value = ahora.toISOString().slice(0, 16);

        document.getElementById('hastaEventosCriticos').value = ahora.toISOString().slice(0, 16);


        //alert (document.getElementById('hasta').value);
        // Validar formulario y abrir nueva ventana


    });
</script>