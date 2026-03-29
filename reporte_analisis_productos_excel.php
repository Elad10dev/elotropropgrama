<?php
// Configuración de alto rendimiento
ini_set('memory_limit', '1024M');
ini_set('max_execution_time', '600');
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', 0);

session_start();
require_once 'ambiente.php'; 

if (function_exists('conectar')) { $conn = conectar(); } 
elseif (function_exists('ConectarConsultas')) { $conn = ConectarConsultas(); } 
else { die("Error de conexión."); }

// 1. RECEPCIÓN DE PARÁMETROS
$company = $_SESSION['CompanyActual'] ?? $_POST['CompanyActual'];
$nombreEmpresa = $_POST['NameCompany'] ?? 'Empresa';
$direccion = $_POST['direccion'] ?? '';
$litFiscal = $_SESSION['litfiscal'] ?? $_POST['litfiscal'] ?? 'RIF';
$rif = $_POST['rute'] ?? '';

// Fechas específicas para este reporte (según tu JS)
$fec1 = $_POST["FECHAX"] ?? date('Y-m-01');
$fec2 = $_POST["FECHAX2"] ?? date('Y-m-d');

// Lógica de Empresa/Grupo
if (isset($_POST['CIdPlan']) && $_POST['CIdPlan'] == '0000000019') {
    $companygrp = (empty($_POST['IdCompanySelect']) || $_POST['IdCompanySelect'] == ($_POST["IdCompanyGrp"] ?? '')) 
        ? " in (" . $company . "," . ($_POST["IdCompanyGrp"] ?? $company) . ") " 
        : " in (" . $_POST["IdCompanySelect"] . ") ";
} else {
    $companygrp = " = " . $company;
}

// 3. CONSULTA SQL
$sucursal_filtro = "";
if (isset($_POST['sucursal']) && $_POST['sucursal'] != '0') {
    // Si hay filtro de sucursal, unimos con ubicacion
    $sucursal_filtro = " AND z.IdUbi=" . $_POST['sucursal'];
}

// Filtros dinámicos
$filtros_adicionales = "";
if (!empty($_POST["mIdProductos"])) { 
    $filtros_adicionales .= " AND a.CodIdBasico in ('" . implode("','", $_POST["mIdProductos"]) . "') "; 
}
if (!empty($_POST["mIdMarca"])) { 
    $filtros_adicionales .= " AND a.Marca in ('" . implode("','", $_POST["mIdMarca"]) . "') "; 
}
if (!empty($_POST["mIdfamilia"])) { 
    $filtros_adicionales .= " AND a.Idfamilia in ('" . implode("','", $_POST["mIdfamilia"]) . "') "; 
}

// Ordenamiento
$orden_str = "ORDER BY Monto DESC"; // Por defecto ventas
if (($_POST["OrdenAX222"] ?? '') == "Cantidad") $orden_str = "ORDER BY Cantidad DESC";
if (($_POST["OrdenAX222"] ?? '') == "Utilidad") $orden_str = "ORDER BY util DESC";

// Límite de registros
$limit_str = "";
if (!empty($_POST["cant"])) {
    $limit_str = " LIMIT " . (int)$_POST["cant"];
}

$query = "SELECT DISTINCT a.CodBarra, a.CodIdAmpliado, a.Descripcion,
          abs(sum(c.Cant * d.inventario)) as Cantidad,
          round(sum(c.Total * d.caja), 2) as Monto,
          round(sum(c.Costo * d.caja), 2) as Costo,
          round(sum(c.Total * d.caja) - sum(c.Costo * d.caja), 2) as util
          FROM PosUpProducto a 
          INNER JOIN PosUpTxC b ON a.IdCompany = b.IdCompany 
          INNER JOIN PosUpTxD c ON a.CodIdBasico = c.CodIdBasico AND a.IdCompany = c.IdCompany AND b.Idtx = c.Idtx AND b.Idtipotx = c.Idtipotx AND b.IdEstacion = c.IdEstacion 
          INNER JOIN PosUpTx d ON b.Idtipotx = d.Idtipotx AND d.Inventario <> 0 AND d.Idtipotx in (1,2,15,23) 
          INNER JOIN PosUpAlmacen f ON c.IdCompany = f.IdCompany AND c.IdAlm = f.IdAlm 
          LEFT JOIN PosUpUbicacion z ON f.IdCompany = z.IdCompany AND f.IdUbi = z.IdUbi
          WHERE a.IdCompany $companygrp 
          AND b.Fectxclient BETWEEN '$fec1 00:00:00' AND '$fec2 23:59:59' 
          AND a.EsCompuesto = 0 AND d.caja <> 0
          $sucursal_filtro $filtros_adicionales
          GROUP BY a.CodIdBasico
          $orden_str $limit_str";

$result = mysqli_query($conn, $query);

// =========================================================================
// INICIAMOS DESCARGA EN EXCEL
// =========================================================================
$nombreArchivo = "Analisis_Productos_" . date('Ymd_His') . ".xls";

// Cabeceras HTTP para forzar la descarga en formato Excel (.xls)
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=$nombreArchivo");
header("Pragma: no-cache");
header("Expires: 0");

// Agregamos el BOM para que Excel respete tildes y eñes
echo "\xEF\xBB\xBF";
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; font-size: 10pt; color: #333; margin:0; }
        .table-main { width: 100%; border-collapse: collapse; margin-top: 5px; }
        .table-main th { 
            background-color: #1a73e8; /* Azul PosUp */
            color: #ffffff; 
            font-weight: bold; 
            text-align: center; 
            padding: 5px; 
            border: 1px solid #aaa; 
        }
        .table-main td { 
            padding: 4px; 
            border: 1px solid #ccc; 
            vertical-align: middle; 
        }
        .num { text-align: right !important; }
        .utilidad { font-weight: bold; color: #28a745; }
        .footer-total { background-color: #e9e9e9; font-weight: bold; font-size: 11pt; }
        /* Esta clase obliga a Excel a tratar la celda como TEXTO puro (mantiene ceros a la izquierda) */
        .text-format { mso-number-format: '\@'; text-align: center; } 
    </style>
</head>
<body>

    <table width="100%">
        <tr>
            <td colspan="5" align="center" style="font-size: 16pt; font-weight: bold; color: #1a73e8;">
                ANÁLISIS DE PRODUCTOS (VENTAS Y UTILIDAD)
            </td>
        </tr>
        <tr>
            <td colspan="5" align="center" style="font-size: 12pt; font-weight: bold;">
                <?php echo mb_strtoupper($nombreEmpresa); ?>
            </td>
        </tr>
        <tr>
            <td colspan="5" align="center">
                <b>Periodo:</b> <?php echo date('d/m/Y', strtotime($fec1)) . ' al ' . date('d/m/Y', strtotime($fec2)); ?>
            </td>
        </tr>
        <tr><td colspan="5"></td></tr>
    </table>

    <table class="table-main">
        <thead>
            <tr>
                <th>CÓDIGO</th>
                <th>DESCRIPCIÓN</th>
                <th>UNIDADES</th>
                <th>MONTO VENTAS</th>
                <th>MONTO UTILIDAD</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $tCant = 0; $tMonto = 0; $tUtil = 0;

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $tCant += $row['Cantidad'];
                    $tMonto += $row['Monto'];
                    $tUtil += $row['util'];
                    
                    $codigo = $row['CodIdAmpliado'] ?: $row['CodBarra'];
            ?>
            <tr>
                <td class="text-format"><?php echo $codigo; ?></td>
                <td><?php echo mb_strtoupper($row['Descripcion']); ?></td>
                <td class="num"><?php echo number_format($row['Cantidad'], 2); ?></td>
                <td class="num"><?php echo number_format($row['Monto'], 2); ?></td>
                <td class="num utilidad"><?php echo number_format($row['util'], 2); ?></td>
            </tr>
            <?php
                }
            ?>
            <tr class="footer-total">
                <td colspan="2" align="right">TOTALES GENERALES:</td>
                <td class="num"><?php echo number_format($tCant, 2); ?></td>
                <td class="num"><?php echo number_format($tMonto, 2); ?></td>
                <td class="num"><?php echo number_format($tUtil, 2); ?></td>
            </tr>
            <?php
            } else {
                echo '<tr><td colspan="5" align="center" style="padding:15px; color:red; font-weight:bold;">No hay datos de ventas para mostrar en este periodo.</td></tr>';
            }
            ?>
        </tbody>
    </table>

</body>
</html>
<?php
// Cerramos la conexión y terminamos el script
mysqli_free_result($result);
exit;
?>