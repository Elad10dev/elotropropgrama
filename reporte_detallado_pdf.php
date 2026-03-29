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

// Función auxiliar para formato de cantidades
if (!function_exists('getcantformat')) {
    function getcantformat($val, $cd, $dec, $mil) {
        return number_format((float)$val, $cd, $dec, $mil);
    }
}

// 2. RECEPCIÓN DE DATOS Y FILTROS (Idénticos a tu HTML)
$fechaDES = $_POST["DesdeFechaX"];
$fechaHAS = $_POST["FechaHastaX"];
$cd = $_POST["CD"] ?? 2;
$simD = $_POST["SimDec"] ?? '.';
$simM = $_POST["SimMil"] ?? ',';

if (($_POST['CIdPlan'] ?? '') == '0000000019') {
    if (empty($_POST['IdCompanySelect']) || $_POST['IdCompanySelect'] == $_POST["IdCompanyGrp"]) {
        $companygrp = " in (" . $_POST["CompanyActual"] . "," . $_POST["IdCompanyGrp"] . ") ";
    } else {
        $companygrp = " in (" . $_POST["IdCompanySelect"] . ") ";
    }
} else {
    $companygrp = " = " . $_POST["CompanyActual"] . "  ";
}

$beetween = "";
if (!empty($_POST["mIdProductos"])) {
    $beetween = " and a.CodIdBasico in ('" . implode("','", $_POST["mIdProductos"]) . "') ";
}

$tipoTrans = "";
if (($_POST["TransaccionX"] ?? '*') !== '*') $tipoTrans = " and a.Idtipotx = '" . trim($_POST["TransaccionX"]) . "'";

$almceFiltro = "";
$almceFiltro2 = "";
if (!empty($_POST["mIdAlmacen"])) {
    $almceFiltro = " and d.IdAlm in ('" . implode("','", $_POST["mIdAlmacen"]) . "')";
    $almceFiltro2 = " and a.IdAlm in ('" . implode("','", $_POST["mIdAlmacen"]) . "')";
}

$familia2 = "";
if (!empty($_POST["mIdfamilia"])) {
    $familia2 = " and e.Idfamilia in ('" . implode("','", $_POST["mIdfamilia"]) . "') ";
}

$marca = "";
if (!empty($_POST["mIdMarca"])) {
    $marca = " and e.Marca in ('" . implode("','", $_POST["mIdMarca"]) . "')";
}

$ConMov = "";
if (($_POST["ProductosMovX"] ?? '') !== "on") { $ConMov = " and Cant<>0 "; }

// =========================================================================
// INICIAMOS CAPTURA DE HTML
// =========================================================================
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Tahoma, sans-serif; font-size: 8pt; color: #333; }
        .table-prod { width: 100%; border-collapse: collapse; margin-bottom: 20px; page-break-inside: avoid; }
        .header-azul { background-color: #e8f0fe; color: #1a73e8; font-weight: bold; padding: 5px; font-size: 9pt; border-bottom: 1px solid #1a73e8; }
        .thead-gray th { background-color: #888; color: #fff; padding: 4px; font-size: 7.5pt; text-align: left; }
        .row-data td { padding: 3px; border-bottom: 1px solid #eee; font-size: 7.5pt; }
        .num { text-align: right !important; }
        .line-total { border-top: 1px solid #333; font-weight: bold; background-color: #f9f9f9; }
        .inicial-box { text-align: right; font-size: 8pt; color: #444; }
    </style>
</head>
<body>

<?php
// QUERY 1: Obtener productos con movimientos en el rango
$queryMain = "SELECT DISTINCT e.CodIdAmpliado, a.CodIdBasico, e.factorunit, e.Descripcion, e.CodBarra
    FROM PosUpTxD a 
    inner join PosUpTx f on a.Idtipotx=f.Idtipotx 
    left join PosUpProducto e on a.IdCompany = e.IdCompany and a.CodIdBasico = e.CodIdBasico 
    where a.IdCompany $companygrp and a.Fectxclient between '$fechaDES 00:00:00' and '$fechaHAS 23:59:59' 
    and e.EsCompuesto=0 and f.Inventario<>0 $almceFiltro2 $familia2 $tipoTrans $ConMov $beetween $marca 
    group by a.CodIdBasico Order by a.Fectxclient, a.CodIdBasico ASC";

if ($resultMain = mysqli_query($conn, $queryMain)) {
    while ($row = mysqli_fetch_assoc($resultMain)) {
        
        // --- CALCULAR INVENTARIO INICIAL ---
        $invIni = 0; $medida = "UND"; $desg = 0; $desg2 = "";
        $query3 = "SELECT coalesce(sum(d.Cant * f.Inventario),0) as InvInicial, e.CantP1, e.UnidadP1, e.Medida as medida, e.factorunit 
                   FROM PosUpTxC a 
                   left join PosUpTxD d on a.IdCompany = d.IdCompany and a.Idtipotx = d.idtipotx and a.Idtx = d.Idtx and a.IdEstacion = d.IdEstacion 
                   left join PosUpProducto e on a.IdCompany = e.IdCompany and d.CodIdBasico = e.CodIdBasico 
                   inner Join PosUpTx f on a.Idtipotx=f.Idtipotx 
                   where a.IdCompany $companygrp and a.Fectxclient < '$fechaDES 00:00:00'
                   and e.CodIdBasico='".$row["CodIdBasico"]."' and e.EsCompuesto=0 and f.Inventario<>0 $almceFiltro $tipoTrans
                   group by d.IdCompany";
        
        if ($result3 = mysqli_query($conn, $query3)) {
            if ($row3 = mysqli_fetch_assoc($result3)) {
                $invIni = $row3['InvInicial'];
                $medida = $row3['medida'];
                $desg = $row3['CantP1'];
                $desg2 = $row3['UnidadP1'];
            }
        }

        // --- ENCABEZADO DE PRODUCTO ---
        ?>
        <table class="table-prod">
            <tr>
                <td colspan="5" class="header-azul">
                    <?php echo ($row['CodBarra'] ?: "-") . " - " . $row['Descripcion']; ?>
                </td>
                <td colspan="3" class="inicial-box">
                    INICIAL AL <?php echo $fechaDES; ?>: <strong><?php echo number_format($invIni, $cd, $simD, $simM); ?></strong> (<?php echo $medida; ?>)
                </td>
            </tr>
            <tr class="thead-gray">
                <th width="15%">Fecha</th>
                <th width="12%">Tipo</th>
                <th width="8%">Ref.</th>
                <th width="20%">Beneficiario</th>
                <th width="20%">Depósito</th>
                <th width="12%" class="num">Movimiento</th>
                <th width="13%" class="num">Desglose</th>
            </tr>
            <?php
            // --- QUERY 2: MOVIMIENTOS DETALLADOS ---
            $query2 = "SELECT f.TitCto as NombreTransaccion, a.Idtx, a.Referencia, a.Fectxclient, 
                       concat(a.IdBen,'-',ifnull(h.Nombre,'')) as Beneficiario, e.factorunit,
                       a.IdUser as Usuario, d.cant, e.medida as uniP1, e.UnidadP1 as uniP2d, e.CantP1,
                       f.Inventario, g.Nombre as DepositoNom, d.IdAlm
                       FROM PosUpTxC a 
                       left join PosUpTxD d on a.IdCompany = d.IdCompany and a.Idtipotx = d.idtipotx and a.Idtx = d.Idtx and a.IdEstacion = d.IdEstacion 
                       left join PosUpProducto e on a.IdCompany = e.IdCompany and d.CodIdBasico = e.CodIdBasico 
                       inner Join PosUpTx f on a.Idtipotx=f.Idtipotx 
                       inner join PosUpAlmacen g on d.IdAlm = g.IdAlm and d.IdCompany = g.IdCompany 
                       LEFT join PosUpclientes h on a.IdCompany=h.IdCompany and a.IdBen=h.RUT 
                       where a.IdCompany $companygrp and a.Fectxclient between '$fechaDES 00:00:00' and '$fechaHAS 23:59:59'
                       and e.CodIdBasico='".$row["CodIdBasico"]."' $almceFiltro $tipoTrans
                       group by d.Idtipotx, d.Idtx, d.IdEstacion, d.IdAlm, d.CodIdBasico 
                       Order by a.Fectxclient ASC";

            $cantTotalPeriodo = 0;
            if ($result2 = mysqli_query($conn, $query2)) {
                while ($row2 = mysqli_fetch_assoc($result2)) {
                    $movimiento = $row2['cant'] * $row2['Inventario'];
                    $cantTotalPeriodo += $movimiento;
                    
                    // Desglose visual
                    $cuni1 = truncate($row2['cant'], 0) * $row2['Inventario'];
                    $cuni2 = round($row2['CantP1'] * ($row2['cant'] - truncate($row2['cant'], 0)), 0) * $row2['Inventario'];
                    $txtDesglose = number_format($cuni1, 0) . " (".substr($row2['uniP1'],0,3).")";
                    if($cuni2 != 0) $txtDesglose .= " y " . number_format($cuni2, 0) . " (".substr($row2['uniP2d'],0,3).")";
                    ?>
                    <tr class="row-data">
                        <td><?php echo $row2['Fectxclient']; ?></td>
                        <td><?php echo $row2['NombreTransaccion'] . "-" . $row2['Idtx']; ?></td>
                        <td><?php echo $row2['Referencia'] ?: "-"; ?></td>
                        <td><?php echo mb_substr($row2['Beneficiario'], 0, 25); ?></td>
                        <td><?php echo "(" . $row2['IdAlm'] . ") " . $row2['DepositoNom']; ?></td>
                        <td class="num"><?php echo number_format($movimiento, $cd, $simD, $simM); ?></td>
                        <td class="num"><?php echo $txtDesglose; ?></td>
                    </tr>
                    <?php
                }
            }
            $final = $invIni + $cantTotalPeriodo;
            ?>
            <tr class="line-total">
                <td colspan="5" align="right">MOVIMIENTO TOTAL DEL PERIODO:</td>
                <td class="num"><?php echo number_format($cantTotalPeriodo, $cd, $simD, $simM); ?></td>
                <td></td>
            </tr>
            <tr class="line-total" style="background-color: #fff;">
                <td colspan="5" align="right">INVENTARIO FINAL AL <?php echo $fechaHAS; ?>:</td>
                <td class="num" style="color:#1a73e8; font-size:10pt;"><?php echo number_format($final, $cd, $simD, $simM); ?></td>
                <td class="num"><?php echo $medida; ?></td>
            </tr>
        </table>
        <?php
    }
}

function truncate($val, $f) {
    if (floatval($val) >= 0) return floor($val);
    else return ceil($val);
}
?>

</body>
</html>

<?php
// =========================================================================
// GENERACIÓN DEL PDF CON MPDF
// =========================================================================
$html = ob_get_clean();
$mpdf = new Mpdf([
    'mode' => 'utf-8', 
    'format' => 'Letter-L', 
    'margin_top' => 35, 
    'tempDir' => __DIR__ . '/tmp'
]);

$srcLogo = "img/informez.png"; 
$pathEntorno = "Comercio/" . $_POST['CompanyActual'] . "/entorno";
if (is_dir($pathEntorno) && $scan = @scandir($pathEntorno)) {
    foreach($scan as $f){ if(strpos($f, "Logotipo") === 0){ $srcLogo = "$pathEntorno/$f"; break; } }
}

$header = '
<table width="100%" style="border-bottom: 1px solid #333; padding-bottom: 10px;">
    <tr>
        <td width="20%"><img src="'.$srcLogo.'" style="max-height: 50px;"></td>
        <td width="60%" align="center">
            <div style="font-size: 14pt; font-weight: bold;">'.mb_strtoupper($_POST["NameCompany"]).'</div>
            <div style="font-size: 12pt; color: #1a73e8; font-weight: bold;">MOVIMIENTO DETALLADO DE INVENTARIO</div>
            <div style="font-size: 9pt;">Periodo: '.$fechaDES.' al '.$fechaHAS.'</div>
        </td>
        <td width="20%" align="right" style="font-size: 8pt;">
            Impreso: '.date('d/m/Y H:i').'<br>Pág. {PAGENO}/{nbpg}
        </td>
    </tr>
</table>';

$mpdf->SetHTMLHeader($header);
$mpdf->WriteHTML($html);
$mpdf->Output('Movimiento_Detallado_Inventario.pdf', 'I');
?>