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

// RECEPCIÓN DE DATOS (Mismos nombres que tu HTML)
$fechaD = $_POST["FECH"];
$fechaH = $_POST["FECH2"];

if ($_SESSION['IdiomaActual'] == '') {
    $_SESSION['IdiomaActual'] = $_POST['IdiomaActual'];
}

// LÓGICA DE EMPRESA/GRUPO
if (($_POST['CIdPlan'] ?? '') == '0000000019') {
    if (($_POST['IdCompanySelect'] ?? '') == '' or $_POST['IdCompanySelect'] == $_POST["IdCompanyGrp"]) {
        $companygrp = " in (" . $_POST["CompanyActual"] . "," . $_POST["IdCompanyGrp"] . ") ";
    } else {
        $companygrp = " in (" . $_POST["IdCompanySelect"] . ") ";
    }
} else {
    $companygrp = " = " . $_POST["CompanyActual"] . "  ";
}

// CONFIGURACIÓN DE FORMATOS
$dec = $_POST["SimDec"] ?? '.';
$mil = $_POST["SimMil"] ?? ',';
$cd = $_POST["CD"] ?? 2;

// INICIAMOS CAPTURA DE HTML
ob_start();
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Tahoma, Verdana, sans-serif; font-size: 8pt; color: #333; margin: 0; }
        .table-main { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table-main th { background-color: #888; color: #fff; font-weight: bold; text-align: left; padding: 5px 2px; border: 1px solid #666; font-size: 7.5pt; }
        .table-main td { padding: 4px 2px; border-bottom: 1px solid #ccc; vertical-align: top; font-size: 7.5pt; }
        .num { text-align: right !important; }
        .total-row { background-color: #f2f2f2; font-weight: bold; border-top: 1px solid #000; }
        .acumulado-row { background-color: #333; color: #fff; font-weight: bold; }
    </style>
</head>
<body>

    <table class="table-main">
        <thead>
            <tr>
                <th width="10%">C/Barra</th>
                <th width="18%">Descripción</th>
                <th width="10%">Serial</th>
                <th width="12%">Fecha</th>
                <th width="8%">Operación</th>
                <th width="8%">Usuario</th>
                <th width="15%">Cliente / Prov.</th>
                <th width="10%">Depósito</th>
                <th width="6%" class="num">Cant.</th>
                <?php if ($_POST['userperfil'] <= 2000 || in_array($_POST["userperfil"], ['2055', '2054', '2053'])) { ?>
                    <th width="6%" class="num">Monto</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php
            // 3. CONSTRUCCIÓN DE FILTROS SQL (Tu lógica exacta)
            $Producto = "";
            if (!empty($_POST["mIdProductos"])) {
                $Producto = " and a.CodIdBasico in ('" . implode("','", $_POST["mIdProductos"]) . "')";
            }

            $OrdenBy = " order by b.Fectxserver, a.Cant*d.Inventario ASC";
            if (($_POST["OrdenSE"] ?? '') != "") {
                if ($_POST["OrdenSE"] == "1") $OrdenBy = " order by a.CodIdBasico, b.Fectxserver ASC";
                if ($_POST["OrdenSE"] == "2") $OrdenBy = " order by a.Descripcion, b.Fectxserver ASC";
                if ($_POST["OrdenSE"] == "3") $OrdenBy = " order by a.Seriales, b.Fectxserver ASC";
                if ($_POST["OrdenSE"] == "4") $OrdenBy = " order by b.Fectxserver ASC";
            }

            $Betweenserial = "";
            if (($_POST["Serial"] ?? '') != "" || ($_POST["Serial2"] ?? '') != "") {
                $s1 = $_POST["Serial"] ?: $_POST["Serial2"];
                $s2 = $_POST["Serial2"] ?: $_POST["Serial"];
                $Betweenserial = "and a.Seriales BETWEEN '$s1' and '$s2'";
            } else {
                $Betweenserial = " and a.Seriales <> ''";
            }

            $Almacen23 = "";
            if (!empty($_POST["mIdAlmacen"])) {
                $Almacen23 = " and a.IdAlm in ('" . implode("','", $_POST["mIdAlmacen"]) . "')";
            }

            $Idtipotx = "";
            if (!empty($_POST["Filtrar"])) {
                $Idtipotx = " and d.Idtipotx in ('" . implode("','", $_POST["Filtrar"]) . "')";
            }

            $BeneficiarioSE = "";
            if (!empty($_POST["mIdProevedor"])) {
                $BeneficiarioSE = " and e.RUT in ('" . implode("','", $_POST["mIdProevedor"]) . "')";
            }

            // Configuración Numeración Documentos
            $qCfg = mysqli_query($conn, "SELECT NumTxViewVTA, NumTxViewCOM, NumTxViewINV FROM PosUpCompany where id = ".$_POST["CompanyActual"]);
            $rCfg = mysqli_fetch_assoc($qCfg);
            $vta = $rCfg['NumTxViewVTA']; $com = $rCfg['NumTxViewCOM']; $inv = $rCfg['NumTxViewINV'];

            $query = "SELECT b.Idtipotx, b.IdtipotxPadre, b.IdtxPadre, b.IdEstacionPadre, c.CodBarra, c.CodIdBasico, c.Descripcion, a.Seriales,
                DATE_FORMAT(a.Fectxclient, '%d/%m/%Y %h:%i:%s %p') as Fectxclient,
                concat(d.TitCto, '-', if(if(a.Idtipotx in (1,2,3,4,5,6,11,12,13,15,21,22,23,24,25,26,31,35,36,37), $vta, if(a.Idtipotx in (7,14,20,27,28), $com, if(a.Idtipotx in (8,9,10,16,17,18,19,29,30,32,33,34,39), $inv, ''))) = 0, b.IdtxCompany, if(if(a.Idtipotx in (1,2,3,4,5,6,11,12,13,15,21,22,23,24,25,26,31,35,36,37), $vta, if(b.Idtipotx in (7,14,20,27,28), $com, if(b.Idtipotx in (8,9,10,16,17,18,19,29,30,32,33,34,39), $inv, ''))) = 1, b.Idtx, b.Referencia))) as Titulo,
                CONCAT(e.RUT, ' ', e.Nombre) as beneficiario, concat('(', a.IdAlm, ') ', f.Nombre) as Almacen, a.factorunit, a.Medida, b.DAmpliado, a.Cant * d.Inventario as cant, users.Nombre as Usuario, round(b.Total * d.Inventario, 2) as Monto
                FROM PosUpTxD a
                INNER JOIN PosUpProducto c ON c.IdCompany = a.IdCompany AND c.CodIdBasico = a.CodIdBasico 
                INNER JOIN PosUpTxC b ON b.IdCompany = a.IdCompany AND b.Idtx = a.Idtx AND b.Idtipotx = a.Idtipotx AND b.IdEstacion = a.IdEstacion
                INNER JOIN posupusers users ON users.IdCompany = b.IdCompany AND users.Login = b.IdUser 
                INNER JOIN PosUpTx d ON d.Idtipotx = a.Idtipotx
                LEFT JOIN PosUpclientes e ON e.IdCompany = b.IdCompany AND e.RUT = b.IdBen
                INNER JOIN PosUpAlmacen f ON f.IdCompany = a.IdCompany AND f.IdAlm = a.IdAlm
                WHERE a.IdCompany=" . $_POST["CompanyActual"] . " 
                AND a.Fectxclient BETWEEN '$fechaD 00:00:00' and '$fechaH 23:59:59' 
                $Almacen23 $Producto $Betweenserial $BeneficiarioSE $Idtipotx
                $OrdenBy";

            $n = 0; $costoTot = 0; $cantTot = 0;
            if ($result = mysqli_query($conn, $query)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $n++;
                    $costoTot += $row["Monto"];
                    $cantTot += $row["cant"];
            ?>
                <tr>
                    <td><?php echo $row['CodBarra'] ?: "-"; ?></td>
                    <td><?php echo mb_strtoupper($row['Descripcion']); ?></td>
                    <td style="font-weight: bold;"><?php echo $row['Seriales']; ?></td>
                    <td><?php echo $row['Fectxclient']; ?></td>
                    <td><?php echo $row['Titulo']; ?></td>
                    <td><?php echo $row['Usuario']; ?></td>
                    <td><?php echo $row['beneficiario'] . ($row['DAmpliado'] ? "<br><i>".$row['DAmpliado']."</i>" : ""); ?></td>
                    <td><?php echo $row['Almacen']; ?></td>
                    <td class="num"><?php echo number_format($row['cant'], $cd, $dec, $mil) . " " . $row['Medida']; ?></td>
                    <?php if ($_POST['userperfil'] <= 2000 || in_array($_POST["userperfil"], ['2055', '2054', '2053'])) { ?>
                        <td class="num"><?php echo number_format($row['Monto'], $cd, $dec, $mil); ?></td>
                    <?php } ?>
                </tr>
            <?php
                }
            }
            ?>
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="8" align="right">TOTALES POR PÁGINA (<?php echo $n; ?> reg.):</td>
                <td class="num"><?php echo number_format($cantTot, $cd, $dec, $mil); ?></td>
                <?php if ($_POST['userperfil'] <= 2000 || in_array($_POST["userperfil"], ['2055', '2054', '2053'])) { ?>
                    <td class="num"><?php echo number_format($costoTot, $cd, $dec, $mil); ?></td>
                <?php } ?>
            </tr>
        </tfoot>
    </table>

</body>
</html>

<?php
// 5. FINALIZAR Y GENERAR PDF
$html = ob_get_clean();

$mpdf = new Mpdf([
    'mode' => 'utf-8',
    'format' => 'Letter-L',
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

$cabeceraPDF = '
<table width="100%" style="font-family: sans-serif; border-bottom: 2px solid #ccc; padding-bottom: 5px;">
    <tr>
        <td width="25%" style="vertical-align: top;">
            <img src="'.$srcLogo.'" style="max-height: 45px; margin-bottom:5px;"><br>
            <div style="font-weight: bold; font-size: 11pt;">'.mb_strtoupper($_POST["NameCompany"]).'</div>
            <div style="font-size: 7pt;">'.($_POST["direccion"] ?? '').'</div>
        </td>
        <td width="50%" align="center" style="vertical-align: top;">
            <div style="font-size: 14pt; font-weight: bold; color: #1a73e8; margin-bottom:5px;">HISTORIAL DE SERIALES</div>
            <div style="font-size: 8pt;">Orden por: <b>'.($_POST["OrdenSE"] == "1" ? "Código" : ($_POST["OrdenSE"] == "2" ? "Descripción" : ($_POST["OrdenSE"] == "3" ? "Serial" : "Fecha"))).'</b></div>
            <div style="font-size: 8pt;">Periodo: <b>'.$fechaD.'</b> al <b>'.$fechaH.'</b></div>
        </td>
        <td width="25%" align="right" style="vertical-align: top;">
            <div style="font-size: 8pt; font-weight: bold;">'.$_POST["fectx5"].'</div>
            <div style="font-size: 8pt; margin-top:5px;">Pág. {PAGENO}/{nbpg}</div>
        </td>
    </tr>
</table>';

$mpdf->SetHTMLHeader($cabeceraPDF);
$mpdf->WriteHTML($html);
$mpdf->Output('Historial_Seriales.pdf', 'I');
?>