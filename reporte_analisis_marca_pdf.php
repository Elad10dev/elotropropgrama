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

// 2. RECEPCIÓN DE DATOS Y LÓGICA DE EMPRESA
if (($_POST['CIdPlan'] ?? '') == '0000000019') {
    if (empty($_POST['IdCompanySelect']) || $_POST['IdCompanySelect'] == $_POST["IdCompanyGrp"]) {
        $companygrp = " in (" . $_POST["CompanyActual"] . "," . $_POST["IdCompanyGrp"] . ") ";
    } else {
        $companygrp = " in (" . $_POST["IdCompanySelect"] . ") ";
    }
} else {
    $companygrp = " = " . $_POST["CompanyActual"] . "  ";
}

$dec = $_POST["SimDec"] ?? '.';
$mil = $_POST["SimMil"] ?? ',';
$cd = $_POST["CD"] ?? 2;
$fechaA = $_POST["FECHAX2z"];
$fechaB = $_POST["FECHAX22z"];

ob_start();

// 3. FILTROS SQL
$Proevedor = "";
if (!empty($_POST["mIdProevedor"])) {
    $Proevedor = "and b.idBen in ('" . implode("','", $_POST["mIdProevedor"]) . "')";
}
$Deposito = "";
if (!empty($_POST["mIdAlmacen"])) {
    $Deposito = " and c.IdAlm in ('" . implode("','", $_POST["mIdAlmacen"]) . "')";
}
$Orden = "order by h.nombre asc";
if (trim($_POST["OrdenA22"] ?? '') == "Ventas") { $Orden = "order by Monto desc"; }
if (trim($_POST["OrdenA22"] ?? '') == "Cantidad") { $Orden = "order by Cantidad desc"; }
if (trim($_POST["OrdenA22"] ?? '') == "Utilidad") { $Orden = "order by util desc"; }

$beetween = "";
if (!empty($_POST["mIdMarca"])) {
    $beetween = " and h.idmarca in ('" . implode("','", $_POST["mIdMarca"]) . "') ";
}
$limit = " limit " . ($_POST["cant223"] ?? '50');

// QUERY PRINCIPAL
if (($_POST['sucursal'] ?? '0') == '0') {
    $query = "SELECT DISTINCT h.idmarca as IdMarca, h.nombre as Marca,
    abs(sum(c.Cant*d.inventario)) as Cantidad,
    round(sum(c.Total*d.caja),2) as Monto,
    round(sum(c.Costo*d.caja),2) as Costo,
    round(sum(c.Total*d.caja),2)-round(sum(c.Costo*d.caja),2) as util
    FROM PosUpProducto a 
    inner join PosUpTxC b on a.IdCompany = b.IdCompany 
    inner join PosUpTxD c on a.CodIdBasico=c.CodIdBasico AND a.IdCompany=c.IdCompany and b.Idtx=c.Idtx and b.Idtipotx=c.Idtipotx and b.IdEstacion = c.IdEstacion 
    inner join PosUpTx d on b.Idtipotx = d.Idtipotx and d.Inventario <> 0 and d.Idtipotx in (1,2,15,23) 
    inner join PosUpAlmacen f on c.IdCompany = f.IdCompany and c.IdAlm = f.IdAlm 
    inner join PosUpc_marcas h on h.IdCompany = a.IdCompany and a.Marca = h.idmarca 
    where a.IdCompany $companygrp and b.Fectxclient BETWEEN '$fechaA 00:00:00' and '$fechaB 23:59:59' 
    and d.caja<>0 $beetween $Proevedor $Deposito
    group by a.Marca $Orden $limit";
} else {
    $query = "SELECT DISTINCT h.idmarca as IdMarca, h.nombre as Marca,
    abs(sum(c.Cant*d.inventario)) as Cantidad,
    round(sum(c.Total*d.caja),2) as Monto,
    round(sum(c.Costo*d.caja),2) as Costo,
    round(sum(c.Total*d.caja),2)-round(sum(c.Costo*d.caja),2) as util
    FROM PosUpProducto a 
    inner join PosUpTxC b on a.IdCompany = b.IdCompany 
    inner join PosUpTxD c on a.CodIdBasico=c.CodIdBasico AND a.IdCompany=c.IdCompany and b.Idtx=c.Idtx and b.Idtipotx=c.Idtipotx and b.IdEstacion = c.IdEstacion 
    inner join PosUpTx d on b.Idtipotx = d.Idtipotx and d.Inventario <> 0 and d.Idtipotx in (1,2,15,23) 
    inner join PosUpAlmacen f on c.IdCompany = f.IdCompany and c.IdAlm = f.IdAlm 
    inner join PosUpUbicacion z on f.IdCompany=z.IdCompany and f.IdUbi=z.IdUbi
    inner join PosUpc_marcas h on h.IdCompany = a.IdCompany and a.Marca = h.idmarca 
    where z.IdUbi=" . $_POST['sucursal'] . " and a.IdCompany $companygrp and b.Fectxclient BETWEEN '$fechaA 00:00:00' and '$fechaB 23:59:59' 
    and d.caja<>0 $beetween $Proevedor $Deposito
    group by a.Marca $Orden $limit";
}

$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 9pt; color: #2c3e50; margin: 0; }
        .table-main { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table-main th { 
            text-align: left; 
            padding: 10px 5px; 
            color: #34495e; 
            border-bottom: 2px solid #1a73e8; 
            background-color: #ffffff;
            font-size: 8pt;
        }
        .table-main td { padding: 8px 5px; border-bottom: 1px solid #ecf0f1; }
        .table-main tbody tr:nth-child(even) { background-color: #f8f9fa; }
        .num { text-align: right !important; }
        .total-row td { 
            background-color: #e8f0fe; 
            color: #1a73e8; 
            font-weight: bold; 
            border-top: 2px solid #1a73e8;
            padding: 10px 5px;
        }
    </style>
</head>
<body>
    <table class="table-main">
        <thead>
            <tr>
                <th width="50%">DESCRIPCIÓN DE LA MARCA</th>
                <th width="15%" class="num">UNIDADES</th>
                <th width="15%" class="num">MONTO VENTAS</th>
                <th width="20%" class="num">MONTO UTILIDAD</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $totalUni = 0; $totalMonto = 0; $totalUtil = 0; $count = 0;
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $count++;
                    $totalUni += $row["Cantidad"];
                    $totalMonto += $row["Monto"];
                    $totalUtil += $row["util"];
            ?>
                <tr>
                    <td style="font-weight: bold;"><?php echo trim($row['Marca']) ?: "- Sin Nombre -"; ?></td>
                    <td class="num"><?php echo number_format($row['Cantidad'], $cd, $dec, $mil); ?></td>
                    <td class="num"><?php echo number_format($row['Monto'], $cd, $dec, $mil); ?></td>
                    <td class="num" style="color:<?php echo ($row['util'] < 0) ? '#e74c3c' : '#2c3e50'; ?>;">
                        <?php echo number_format($row['util'], $cd, $dec, $mil); ?>
                    </td>
                </tr>
            <?php
                }
            }
            ?>
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td align="right">TOTAL PRODUCTOS (<?php echo $count; ?>):</td>
                <td class="num"><?php echo number_format($totalUni, $cd, $dec, $mil); ?></td>
                <td class="num"><?php echo number_format($totalMonto, $cd, $dec, $mil); ?></td>
                <td class="num"><?php echo number_format($totalUtil, $cd, $dec, $mil); ?></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
<?php
$html = ob_get_clean();
$mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'Letter-L', 'margin_top' => 35, 'tempDir' => __DIR__ . '/tmp']);

$srcLogo = "img/informez.png"; 
$pathEntorno = "Comercio/" . $_POST['CompanyActual'] . "/entorno";
if (is_dir($pathEntorno) && $scan = @scandir($pathEntorno)) {
    foreach($scan as $f){ if(strpos($f, "Logotipo") === 0){ $srcLogo = "$pathEntorno/$f"; break; } }
}

$cabeceraPDF = '
<table width="100%" style="font-family: sans-serif; border-bottom: 1px solid #bdc3c7; padding-bottom: 10px;">
    <tr>
        <td width="25%" style="vertical-align: top;">
            <img src="'.$srcLogo.'" style="max-height: 50px; margin-bottom:5px;"><br>
            <div style="font-weight: bold; font-size: 11pt;">'.mb_strtoupper($_POST["NameCompany"]).'</div>
            <div style="font-size: 7.5pt; color: #7f8c8d;">'.($_POST["direccion"] ?? '').'</div>
        </td>
        <td width="50%" align="center" style="vertical-align: top;">
            <div style="font-size: 16pt; font-weight: bold; color: #1a73e8; margin-bottom:5px;">ANÁLISIS DE MARCAS</div>
            <div style="font-size: 8.5pt;">Orden por: <b>'.($_POST["OrdenA22"] ?? 'Ventas').'</b></div>
            <div style="font-size: 8.5pt;">Periodo: <b>'.$fechaA.'</b> hasta <b>'.$fechaB.'</b></div>
        </td>
        <td width="25%" align="right" style="vertical-align: top;">
            <div style="font-size: 8pt; font-weight: bold;">'.$_POST["fectx5"].'</div>
            <div style="font-size: 8pt; color: #7f8c8d; margin-top:10px;">Página {PAGENO} de {nbpg}</div>
        </td>
    </tr>
</table>';

$mpdf->SetHTMLHeader($cabeceraPDF);
$mpdf->WriteHTML($html);
$mpdf->Output('Analisis_Marca.pdf', 'I');