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

// Función para formatear cantidades (Idéntica a tu lógica)
if (!function_exists('getcantformat')) {
    function getcantformat($val, $cd, $dec, $mil) {
        return number_format((float)$val, $cd, $dec, $mil);
    }
}

// 2. RECEPCIÓN DE DATOS Y FILTROS
$fechaDES = $_POST["DesdeFechaG"];
$fechaHAS = $_POST["FechaHastaG"];
$cd = $_POST["CD"] ?? 2;
$simD = $_POST["SimDec"] ?? '.';
$simM = $_POST["SimMil"] ?? ',';

$companygrp = " = " . $_POST["CompanyActual"] . "  ";
if (($_POST['CIdPlan'] ?? '') == '0000000019') {
    if (($_POST['IdCompanySelect'] ?? '') == '' or $_POST['IdCompanySelect'] == $_POST["IdCompanyGrp"]) {
        $companygrp = " in (" . $_POST["CompanyActual"] . "," . $_POST["IdCompanyGrp"] . ") ";
    } else {
        $companygrp = " in (" . $_POST["IdCompanySelect"] . ") ";
    }
}

$beetween = "";
if (!empty($_POST["mIdProductos"])) {
    $beetween = " and a.CodIdBasico in ('" . implode("','", $_POST["mIdProductos"]) . "') ";
}

$familia = "";
if (!empty($_POST["mIdfamilia"])) {
    $familia = " and a.Idfamilia in ('" . implode("','", $_POST["mIdfamilia"]) . "') ";
}

$Almacen23 = "";
if (!empty($_POST["mIdAlmacen"])) {
    $Almacen23 = " and ba.IdAlm in ('" . implode("','", $_POST["mIdAlmacen"]) . "')";
}

$sucursal = "";
if (($_POST['sucursal'] ?? '0') !== '0') {
    $sucursal = " and f.IdUbi=" . $_POST['sucursal'];
}

$ConInv = (($_POST["ProductosInvG"] ?? '') == "on") ? " HAVING (InventarioInicial + Entrada - Salida) <> 0 " : "";
$ConMov = (($_POST["ProductosMovG"] ?? '') == "on") ? " AND (COALESCE(c.cEntrada,0) <> 0 OR COALESCE(c.cSalida,0) <> 0) " : "";

$OrdenBy = " ORDER BY a.CodIdBasico ASC";
if (($_POST["OrdenRESG"] ?? '') == "2") { $OrdenBy = " ORDER BY a.Descripcion ASC"; }
if (($_POST["OrdenRESG"] ?? '') == "3") { $OrdenBy = " ORDER BY InventarioFinal ASC"; }

// INICIAMOS CAPTURA DE HTML
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 7.5pt; color: #7dacdb; margin: 0; }
        .table-main { width: 100%; border-collapse: collapse; }
        
        /* Cabeceras */
        .table-main th { padding: 4px 2px; border: 1px solid #d6e4ee; text-align: center; font-weight: bold; }
        .header-top { background-color: #34495e; color: #ffffff; text-transform: uppercase; font-size: 7pt; }
        .header-sub { background-color: #f2f4f4; color: #d6e4ee; font-size: 6.5pt; }
        
        /* Celdas */
        .table-main td { border: 1px solid #505a5c; padding: 4px 2px; vertical-align: middle; }
        .num { text-align: right !important; font-family: 'Courier', monospace; }
        .txt-left { text-align: left !important; }
        
        /* Zebra y Totales */
        tbody tr:nth-child(even) { background-color: #fdfdfd; }
        .total-row td { background-color: #79869e; color: #1e242d; font-weight: bold; border-top: 2px solid #1a73e8; font-size: 8pt; }
        .final-col { background-color: #f9f9f9; font-weight: bold; }
    </style>
</head>
<body>

    <table class="table-main">
        <thead>
            <tr class="header-top">
                <th rowspan="2" width="9%">CÓDIGO</th>
                <th rowspan="2" width="23%">DESCRIPCIÓN</th>
                <th colspan="3">EXISTENCIA INICIAL</th>
                <th colspan="2">ENTRADAS</th>
                <th colspan="2">SALIDAS</th>
                <th colspan="3">EXISTENCIA FINAL</th>
            </tr>
            <tr class="header-sub">
                <th width="5%">CANT</th>
                <th width="6%">COSTO U.</th>
                <th width="7%">TOTAL</th>
                <th width="5%">CANT</th>
                <th width="6%">MONTO</th>
                <th width="5%">CANT</th>
                <th width="6%">MONTO</th>
                <th width="5%">CANT</th>
                <th width="6%">COSTO U.</th>
                <th width="7%">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT a.CodBarra, a.Descripcion, a.CodIdBasico,
                round(coalesce(b.cantidad,0),2) as InventarioInicial,
                round(a.Costo,2) as Costo,
                (round(coalesce(b.cantidad,0),2) * a.Costo) as MtoTotal,
                round(coalesce(c.cEntrada,0),2) as Entrada, 
                round(coalesce(c.cEntrada,0)*a.Costo,2) as Montoentrada,
                round(coalesce(c.cSalida,0),2) as Salida,
                round(coalesce(c.cSalida,0)*a.Costo,2) as Montosalida,
                round(a.Costo,2) as CostoFinal
                FROM PosUpProducto a 
                LEFT JOIN (SELECT ba.IdCompany, ba.CodIdBasico, sum(ba.Cant*bb.Inventario) as cantidad
                    FROM PosUpTxD ba 
                    INNER JOIN PosUpAlmacen f ON ba.IdCompany = f.IdCompany and ba.IdAlm = f.IdAlm 
                    INNER JOIN PosUpTx bb ON ba.Idtipotx = bb.Idtipotx  
                    WHERE ba.IdCompany $companygrp AND ba.Fectxclient < '$fechaDES 00:00:00' $Almacen23 $sucursal 
                    GROUP BY ba.IdCompany, ba.CodIdBasico) b ON a.IdCompany = b.IdCompany AND a.CodIdBasico = b.CodIdBasico 
                LEFT JOIN (SELECT ba.IdCompany, ba.CodIdBasico,
                    sum(if(ba.Idtipotx in (7,18,3,28,30) or (ba.Idtipotx in (8,10,9,17) and ba.Cant > 0),ba.Cant*bb.Inventario,0)) as cEntrada, 
                    sum(if(ba.Idtipotx in (1,2,11,15,19,21,22,27,31,35,38) or (ba.Idtipotx in (8,10,9,17) and ba.Cant < 0),abs(ba.Cant*bb.Inventario),0)) as cSalida
                    FROM PosUpTxD ba
                    INNER JOIN PosUpAlmacen f ON ba.IdCompany = f.IdCompany AND ba.IdAlm = f.IdAlm 
                    INNER JOIN PosUpTx bb ON ba.Idtipotx = bb.Idtipotx 
                    WHERE ba.IdCompany $companygrp AND ba.Fectxclient BETWEEN '$fechaDES 00:00:00' AND '$fechaHAS 23:59:59' $Almacen23 $sucursal  
                    GROUP BY ba.IdCompany, ba.CodIdBasico ) c ON a.IdCompany = c.IdCompany AND a.CodIdBasico = c.CodIdBasico
                WHERE a.IdCompany $companygrp AND a.EsCompuesto=0 $beetween $familia $ConMov $OrdenBy";

            $res = mysqli_query($conn, $query);
            $tMtoIni = 0; $tMtoEnt = 0; $tMtoSal = 0; $tMtoFin = 0; $count = 0;

            if ($res) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $invFinal = $row['InventarioInicial'] + $row['Entrada'] - $row['Salida'];
                    $mtoFinal = $invFinal * $row['CostoFinal'];
                    
                    // Solo mostrar si tiene stock o hubo movimiento
                    if ($invFinal == 0 && $row['Entrada'] == 0 && $row['Salida'] == 0 && $row['InventarioInicial'] == 0) continue;

                    $count++;
                    $tMtoIni += $row["MtoTotal"];
                    $tMtoEnt += $row["Montoentrada"];
                    $tMtoSal += $row["Montosalida"];
                    $tMtoFin += $mtoFinal;
            ?>
                <tr>
                    <td class="txt-left"><?php echo $row['CodBarra'] ?: $row['CodIdBasico']; ?></td>
                    <td class="txt-left"><?php echo mb_strtoupper(mb_substr($row['Descripcion'], 0, 45)); ?></td>
                    
                    <td class="num"><?php echo number_format($row['InventarioInicial'], $cd, $simD, $simM); ?></td>
                    <td class="num"><?php echo number_format($row['Costo'], $cd, $simD, $simM); ?></td>
                    <td class="num"><?php echo number_format($row['MtoTotal'], $cd, $simD, $simM); ?></td>
                    
                    <td class="num" style="color: #27ae60;"><?php echo number_format($row['Entrada'], $cd, $simD, $simM); ?></td>
                    <td class="num"><?php echo number_format($row['Montoentrada'], $cd, $simD, $simM); ?></td>
                    
                    <td class="num" style="color: #e74c3c;"><?php echo number_format($row['Salida'], $cd, $simD, $simM); ?></td>
                    <td class="num"><?php echo number_format($row['Montosalida'], $cd, $simD, $simM); ?></td>
                    
                    <td class="num final-col"><?php echo number_format($invFinal, $cd, $simD, $simM); ?></td>
                    <td class="num final-col"><?php echo number_format($row['CostoFinal'], $cd, $simD, $simM); ?></td>
                    <td class="num final-col" style="color:#1a73e8;"><?php echo number_format($mtoFinal, $cd, $simD, $simM); ?></td>
                </tr>
            <?php
                }
            }
            ?>
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="2" align="right">TOTALES GENERALES (<?php echo $count; ?> ART.):</td>
                <td colspan="2"></td>
                <td class="num"><?php echo number_format($tMtoIni, $cd, $simD, $simM); ?></td>
                <td></td>
                <td class="num"><?php echo number_format($tMtoEnt, $cd, $simD, $simM); ?></td>
                <td></td>
                <td class="num"><?php echo number_format($tMtoSal, $cd, $simD, $simM); ?></td>
                <td colspan="2"></td>
                <td class="num"><?php echo number_format($tMtoFin, $cd, $simD, $simM); ?></td>
            </tr>
        </tfoot>
    </table>

</body>
</html>
<?php
// =========================================================================
// RENDERIZADO MPDF
// =========================================================================
$html = ob_get_clean();
$mpdf = new Mpdf([
    'mode' => 'utf-8', 
    'format' => 'Letter-L', 
    'margin_top' => 32, 
    'margin_bottom' => 12,
    'margin_left' => 5,
    'margin_right' => 5,
    'tempDir' => __DIR__ . '/tmp'
]);

$srcLogo = "img/informez.png"; 
$pathEntorno = "Comercio/" . $_POST['CompanyActual'] . "/entorno";
if (is_dir($pathEntorno) && $scan = @scandir($pathEntorno)) {
    foreach($scan as $f){ if(strpos($f, "Logotipo") === 0){ $srcLogo = "$pathEntorno/$f"; break; } }
}

$header = '
<table width="100%" style="border-bottom: 1px solid #c2d6e3; padding-bottom: 8px; font-family: sans-serif;">
    <tr>
        <td width="20%"><img src="'.$srcLogo.'" style="max-height: 45px;"></td>
        <td width="60%" align="center">
            <div style="font-size: 13pt; font-weight: bold; color:#2c3e50;">'.mb_strtoupper($_POST["NameCompany"]).'</div>
            <div style="font-size: 14pt; font-weight: bold; color: #1a73e8; margin-top:3px;">MOVIMIENTO FISCAL DE INVENTARIO</div>
            <div style="font-size: 8.5pt; color:#7f8c8d; margin-top:2px;">Periodo: '.$fechaDES.' al '.$fechaHAS.'</div>
        </td>
        <td width="20%" align="right" style="font-size: 7.5pt; color:#7f8c8d;">
            Generado: '.$_POST["fectx5"].'<br>
            Página {PAGENO} de {nbpg}
        </td>
    </tr>
</table>';

$mpdf->SetHTMLHeader($header);
$mpdf->WriteHTML($html);
$mpdf->Output('Movimiento_Fiscal_Inventario.pdf', 'I');
?>