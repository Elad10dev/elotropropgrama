<?php
// Configuración de alto rendimiento
ini_set('memory_limit', '1024M');
ini_set('max_execution_time', '600');

session_start();
require_once __DIR__ . '/vendor/autoload.php';
require_once 'ambiente.php'; 

use Mpdf\Mpdf;

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

// 2. BUSCAR LOGOTIPO
$src = "img/informez.png"; 
$pathEntorno = "Comercio/$company/entorno";
if ($scan = @scandir($pathEntorno)) {
    foreach ($scan as $f) {
        if (strpos($f, "Logotipo") === 0) {
            $src = "$pathEntorno/$f";
            break;
        }
    }
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

// 4. GENERACIÓN DEL PDF
$mpdf = new Mpdf([
    'mode' => 'utf-8',
    'format' => 'Letter-L', // Horizontal
    'margin_top' => 45
]);

$header = '
<table width="100%" style="border-bottom: 2px solid #333; vertical-align: middle; font-family: sans-serif; padding-bottom: 10px;">
    <tr>
        <td width="15%"><img src="'.$src.'" style="max-height: 80px;"></td>
        <td width="70%" align="center">
            <div style="font-size: 18px; font-weight: bold; color: #000;">' . mb_strtoupper($nombreEmpresa) . '</div>
            <div style="font-size: 10px;">' . $litFiscal . ': ' . $rif . ' | ' . $direccion . '</div>
            <div style="font-size: 15px; font-weight: bold; color: #0056b3; margin-top: 8px;">ANÁLISIS DE PRODUCTOS (VENTAS Y UTILIDAD)</div>
            <div style="font-size: 10px; font-weight: bold;">Periodo: ' . date('d/m/Y', strtotime($fec1)) . ' al ' . date('d/m/Y', strtotime($fec2)) . '</div>
        </td>
        <td width="15%" align="right" style="font-size: 9px; color: #666;">
            Impreso: '.date('d/m/Y H:i').'<br>Pág. {PAGENO}/{nbpg}
        </td>
    </tr>
</table>';

$mpdf->SetHTMLHeader($header);

$html = '
<style>
    table { width: 100%; border-collapse: collapse; font-family: sans-serif; }
    th { background-color: #f2f2f2; border-top: 2px solid #333; border-bottom: 2.5px solid #333; padding: 8px; font-size: 9pt; text-align: left; }
    td { border-bottom: 1px solid #ddd; padding: 6px; font-size: 8pt; color: #333; }
    .num { text-align: right; }
    .utilidad { font-weight: bold; color: #28a745; }
    .footer-total { background-color: #e9e9e9; font-weight: bold; font-size: 9pt; }
</style>
<table>
    <thead>
        <tr>
            <th width="15%">CÓDIGO</th>
            <th width="45%">DESCRIPCIÓN</th>
            <th width="10%" class="num">UNIDADES</th>
            <th width="15%" class="num">MONTO VENTAS</th>
            <th width="15%" class="num">MONTO UTILIDAD</th>
        </tr>
    </thead>
    <tbody>';

$tCant = 0; $tMonto = 0; $tUtil = 0;

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $tCant += $row['Cantidad'];
        $tMonto += $row['Monto'];
        $tUtil += $row['util'];
        
        $html .= '<tr>
            <td>' . ($row['CodIdAmpliado'] ?: $row['CodBarra']) . '</td>
            <td>' . mb_strtoupper($row['Descripcion']) . '</td>
            <td class="num">' . number_format($row['Cantidad'], 2) . '</td>
            <td class="num">' . number_format($row['Monto'], 2) . '</td>
            <td class="num utilidad">' . number_format($row['util'], 2) . '</td>
        </tr>';
    }
    // Fila de Totales
    $html .= '<tr class="footer-total">
                <td colspan="2" align="right">TOTALES GENERALES:</td>
                <td class="num">' . number_format($tCant, 2) . '</td>
                <td class="num">' . number_format($tMonto, 2) . '</td>
                <td class="num">' . number_format($tUtil, 2) . '</td>
              </tr>';
} else {
    $html .= '<tr><td colspan="5" align="center">No hay datos de ventas para mostrar en este periodo.</td></tr>';
}

$html .= '</tbody></table>';

$mpdf->WriteHTML($html);
$mpdf->Output('Analisis_Productos.pdf', 'I');