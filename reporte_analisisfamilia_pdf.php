<?php
// 1. CONFIGURACIÓN DE ALTO RENDIMIENTO
ini_set('memory_limit', '2048M');
ini_set('max_execution_time', '1800');
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', 0);

require_once __DIR__ . '/vendor/autoload.php';
use Mpdf\Mpdf;

include "ambiente.php";
$conn = ConectarConsultas();
session_start();

if ($_SESSION['IdiomaActual'] == '') {
    $_SESSION['IdiomaActual'] = $_POST['IdiomaActual'];
}

// Lógica de Compañía/Grupo (Tu código original)
if (($_POST['CIdPlan'] ?? '') == '0000000019') {
    if (($_POST['IdCompanySelect'] ?? '') == '' or $_POST['IdCompanySelect'] == $_POST["IdCompanyGrp"]) {
        $companygrp = " in (" . $_POST["CompanyActual"] . "," . $_POST["IdCompanyGrp"] . ") ";
    } else {
        $companygrp = " in (" . $_POST["IdCompanySelect"] . ") ";
    }
} else {
    $companygrp = " = " . $_POST["CompanyActual"] . "  ";
}

// =========================================================================
// INICIAMOS LA CAPTURA DEL HTML PARA EL PDF
// =========================================================================
ob_start();

// 2. CONSTRUCCIÓN DE FILTROS SQL (Tu lógica intacta)
$Proevedor = "";
if (!empty($_POST["mIdProevedor"])) {
    $Proevedor = "and b.idBen in ('" . implode("','", $_POST["mIdProevedor"]) . "')";
}

$Deposito = "";
if (!empty($_POST["mIdAlmacen"])) {
    $Deposito = " and c.IdAlm in ('" . implode("','", $_POST["mIdAlmacen"]) . "')";
}

$Orden = "order by Monto desc"; // Default
if (trim($_POST["OrdenA222"] ?? '') == "Ventas") { $Orden = "order by Monto desc"; }
if (trim($_POST["OrdenA222"] ?? '') == "Cantidad") { $Orden = "order by Cantidad desc"; }
if (trim($_POST["OrdenA222"] ?? '') == "Utilidad") { $Orden = "order by util desc"; }

$beetween = "";
if (!empty($_POST["mIdfamilia"])) {
    $beetween = " and g.Idvarios in ('" . implode("','", $_POST["mIdfamilia"]) . "') ";
}

$limit = " limit " . ($_POST["cant2232"] ?? '100');
$fechaA = $_POST["FECHAX2z2nj"];
$fechaB = $_POST["FECHAX22z2njz"];

// QUERY PRINCIPAL (Ajustado según Sucursal como tu código)
if (($_POST['sucursal'] ?? '0') == '0') {
    $query = "SELECT DISTINCT g.ITEM as Familia, g.IdVarios as IdFamilia,
    abs(sum(c.Cant*d.inventario)) as Cantidad,
    round(sum(c.Total*d.caja),2) as Monto,
    round(sum(c.Costo*d.caja),2) as Costo,
    round(sum(c.Margen*d.caja),2) as margen,
    round(sum(c.Total*d.caja),2)-round(sum(c.Costo*d.caja),2) as util
    FROM PosUpProducto a 
    inner join PosUpTxC b on a.IdCompany = b.IdCompany 
    inner join PosUpTxD c on a.CodIdBasico=c.CodIdBasico AND a.IdCompany=c.IdCompany and b.Idtx=c.Idtx and b.Idtipotx=c.Idtipotx and b.IdEstacion = c.IdEstacion 
    inner join PosUpTx d on b.Idtipotx = d.Idtipotx and d.Inventario <> 0 and d.Idtipotx in (1,2,15,23) 
    inner join PosUpAlmacen f on c.IdCompany = f.IdCompany and c.IdAlm = f.IdAlm 
    inner join PosUpvarios g on g.IdCompany = a.IdCompany and a.Idfamilia = g.IdVarios and g.TIPOITEM = 2
    where a.IdCompany $companygrp and b.Fectxclient BETWEEN '$fechaA 00:00:00' and '$fechaB 23:59:59' 
    and d.caja<>0 $beetween $Proevedor $Deposito
    group by a.Idfamilia $Orden $limit";
} else {
    $query = "SELECT DISTINCT g.ITEM as Familia, g.IdVarios as IdFamilia,
    abs(sum(c.Cant*d.inventario)) as Cantidad,
    round(sum(c.Total*d.caja),2) as Monto,
    round(sum(c.Costo*d.caja),2) as Costo,
    round(sum(c.Margen*d.caja),2) as margen,
    round(sum(c.Total*d.caja),2)-round(sum(c.Costo*d.caja),2) as util
    FROM PosUpProducto a 
    inner join PosUpTxC b on a.IdCompany = b.IdCompany 
    inner join PosUpTxD c on a.CodIdBasico=c.CodIdBasico AND a.IdCompany=c.IdCompany and b.Idtx=c.Idtx and b.Idtipotx=c.Idtipotx and b.IdEstacion = c.IdEstacion 
    inner join PosUpTx d on b.Idtipotx = d.Idtipotx and d.Inventario <> 0 and d.Idtipotx in (1,2,15,23) 
    inner join PosUpAlmacen f on c.IdCompany = f.IdCompany and c.IdAlm = f.IdAlm 
    inner join PosUpUbicacion z on f.IdCompany=z.IdCompany and f.IdUbi=z.IdUbi
    inner join PosUpvarios g on g.IdCompany = a.IdCompany and a.Idfamilia = g.IdVarios and g.TIPOITEM = 2
    where z.IdUbi=" . $_POST['sucursal'] . " and a.IdCompany $companygrp and b.Fectxclient BETWEEN '$fechaA 00:00:00' and '$fechaB 23:59:59' 
    and d.caja<>0 $beetween $Proevedor $Deposito
    group by a.Idfamilia $Orden $limit";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Tahoma, Verdana, Segoe, sans-serif; font-size: 9pt; color: #000; margin: 0; }
        .table-main { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table-main th { background-color: #888; color: #fff; font-weight: bold; text-align: left; padding: 6px 4px; border: 1px solid #666; }
        .table-main td { padding: 6px 4px; border-bottom: 1px solid #ccc; font-size: 9pt; }
        .num { text-align: right !important; }
        .total-row { background-color: #eee; font-weight: bold; }
    </style>
</head>
<body>

    <table class="table-main">
        <thead>
            <tr>
                <th width="55%">Descripción (Familia)</th>
                <th width="15%" class="num">Unidades</th>
                <th width="15%" class="num">Montos Ventas</th>
                <th width="15%" class="num">Monto Utilidad</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $totaluni = 0; $totalMonto = 0; $totalutil = 0; $count = 0;
            $dec = $_POST["SimDec"] ?? '.';
            $mil = $_POST["SimMil"] ?? ',';
            $cd = $_POST["CD"] ?? 2;

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $count++;
                    $totaluni += $row["Cantidad"];
                    $totalMonto += $row["Monto"];
                    $totalutil += $row["util"];
            ?>
                <tr>
                    <td><?php echo trim($row['Familia']) ?: "- Sin Nombre -"; ?></td>
                    <td class="num"><?php echo number_format($row['Cantidad'], $cd, $dec, $mil); ?></td>
                    <td class="num"><?php echo number_format($row['Monto'], $cd, $dec, $mil); ?></td>
                    <td class="num"><?php echo number_format($row['util'], $cd, $dec, $mil); ?></td>
                </tr>
            <?php
                }
            }
            ?>
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td>TOTAL FAMILIAS (<?php echo $count; ?>)</td>
                <td class="num"><?php echo number_format($totaluni, $cd, $dec, $mil); ?></td>
                <td class="num"><?php echo number_format($totalMonto, $cd, $dec, $mil); ?></td>
                <td class="num"><?php echo number_format($totalutil, $cd, $dec, $mil); ?></td>
            </tr>
        </tfoot>
    </table>

</body>
</html>

<?php
// =========================================================================
// FINALIZAMOS CAPTURA Y GENERAMOS EL PDF
// =========================================================================
$html = ob_get_clean();

$mpdf = new Mpdf([
    'mode' => 'utf-8',
    'format' => 'Letter-L', // Horizontal para que quepa bien la info
    'margin_top' => 35,
    'margin_bottom' => 15,
    'margin_left' => 10,
    'margin_right' => 10,
    'tempDir' => __DIR__ . '/tmp'
]);

// Carga de Logotipo
$srcLogo = "img/informez.png"; 
$pathEntorno = "Comercio/" . $_POST['CompanyActual'] . "/entorno";
if (is_dir($pathEntorno) && $scan = @scandir($pathEntorno)) {
    foreach($scan as $f){ if(strpos($f, "Logotipo") === 0){ $srcLogo = "$pathEntorno/$f"; break; } }
}

// Filtros para la cabecera
$txtFiltroFamilia = ($_POST["DesdeAX22z22Y"] ?? '') != '' ? "Familia: " . $_POST["DesdeAX22z22Y"] : "Todas las Familias";

$cabeceraPDF = '
<table width="100%" style="font-family: sans-serif; border-bottom: 2px solid #ccc; padding-bottom: 10px;">
    <tr>
        <td width="25%" style="vertical-align: top;">
            <img src="'.$srcLogo.'" style="max-height: 50px; margin-bottom:5px;"><br>
            <div style="font-weight: bold; font-size: 11pt;">'.mb_strtoupper($_POST["NameCompany"]).'</div>
            <div style="font-size: 7.5pt;">'.($_POST["direccion"] ?? '').'</div>
            <div style="font-size: 7.5pt;">'.($_POST["litfiscal"] ?? '').'-'.($_POST["rute"] ?? '').'</div>
        </td>
        <td width="50%" align="center" style="vertical-align: top;">
            <div style="font-size: 14pt; font-weight: bold; color: #1a73e8; margin-bottom:5px;">ANÁLISIS DE FAMILIA</div>
            <div style="font-size: 8.5pt;"><b>Orden por:</b> '.($_POST["OrdenA222"] ?? '').' | '.$txtFiltroFamilia.'</div>
            <div style="font-size: 8.5pt;"><b>Periodo:</b> '.$fechaA.' hasta '.$fechaB.'</div>
        </td>
        <td width="25%" align="right" style="vertical-align: top;">
            <div style="font-size: 8pt; font-weight: bold;">'.$_POST["fectx5"].'</div>
            <div style="font-size: 8pt; margin-top:10px;">Pág. {PAGENO}/{nbpg}</div>
        </td>
    </tr>
</table>';

$mpdf->SetHTMLHeader($cabeceraPDF);
$mpdf->WriteHTML($html);
$mpdf->Output('Analisis_Familia.pdf', 'I');
?>