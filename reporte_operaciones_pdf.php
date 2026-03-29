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
$fechaD = $_POST["FECH4"];
$fechaH = $_POST["FECH24"];

if (($_POST['CIdPlan'] ?? '') == '0000000019') {
    if (($_POST['IdCompanySelect'] ?? '') == '' or $_POST['IdCompanySelect'] == $_POST["IdCompanyGrp"]) {
        $companygrp = " in (" . $_POST["CompanyActual"] . "," . $_POST["IdCompanyGrp"] . ") ";
    } else {
        $companygrp = " in (" . $_POST["IdCompanySelect"] . ") ";
    }
} else {
    $companygrp = " = " . $_POST["CompanyActual"] . "  ";
}

// Captura del Nombre de los Almacenes para la cabecera
$txtAlmacenes = "Todos";
if (!empty($_POST["Almacen234"])) {
    $txtAlmacenes = "";
    $idsAlm = implode(",", $_POST["Almacen234"]);
    $resAlm = mysqli_query($conn, "SELECT Nombre FROM PosUpAlmacen WHERE IdAlm IN ($idsAlm) AND IdCompany " . $companygrp);
    while($rA = mysqli_fetch_assoc($resAlm)) { $txtAlmacenes .= $rA['Nombre'] . " "; }
}

// 3. CONFIGURACIÓN DE FILTROS SQL (Tu lógica original)
$Producto = "";
if (!empty($_POST["mIdProductos"])) {
    $Producto = " and a.CodIdBasico in ('" . implode("','", $_POST["mIdProductos"]) . "')";
}

$OrdenBy = "order by b.Fectxclient ASC"; // Default
if (($_POST["OrdenSE4"] ?? '') == "1") { $OrdenBy = " order by Documento, a.CodIdBasico ASC"; }
if (($_POST["OrdenSE4"] ?? '') == "2") { $OrdenBy = " order by a.Descripcion ASC"; }
if (($_POST["OrdenSE4"] ?? '') == "3") { $OrdenBy = " order by b.Fectxclient ASC"; }

$BeneficiarioSE = "";
if (!empty($_POST["mIdProevedor"])) {
    $BeneficiarioSE = " and e.RUT in ('" . implode("','", $_POST["mIdProevedor"]) . "')";
}

$Almacen23 = "";
if (!empty($_POST["Almacen234"])) {
    $Almacen23 = " and c.IdAlm in (" . implode(",", $_POST["Almacen234"]) . ")";
}

$buscar = "";
if (!empty($_POST["Filtrar4"])) {
    $idsTx = implode(",", $_POST["Filtrar4"]);
    if (($_POST['icd'] ?? '') == true) {
        $buscar .=  " and ( (d.Idtipotx in (3,27) and b.IdTipotxPadre in ($idsTx) ) or d.Idtipotx in($idsTx) )";
    } else {
        $buscar .= " and d.Idtipotx in ($idsTx)";
    }
}

$idUbi = "";
if (($_POST['sucursal'] ?? '0') !== '0') {
    $idUbi = " AND f.IdUbi=" . $_POST['sucursal'];
}

// Configuración de visualización de Tipos de Documento
$sqlCfg = "SELECT NumTxViewVTA, NumTxViewCOM, NumTxViewINV FROM PosUpCompany where id  = " . $_POST["CompanyActual"];
$resCfg = mysqli_query($conn, $sqlCfg);
$rowCfg = mysqli_fetch_assoc($resCfg);
$vta = $rowCfg['NumTxViewVTA']; $com = $rowCfg['NumTxViewCOM']; $inv = $rowCfg['NumTxViewINV'];

$sqlCosto = (($_POST["Costoop"] ?? '') == true) ? "round((c.Costo/if(c.Impuesto=1,1.16,1))*d.inventario,2) as Costos," : "";

// QUERY PRINCIPAL
$query = "SELECT 
    concat(d.TitCto, '-' , LPAD( if(if(b.Idtipotx in (1, 2, 3, 4, 5, 6, 11, 12, 13, 15, 21, 22, 23, 24, 25, 26, 31, 35, 36, 37), $vta, if(b.Idtipotx in (7, 14, 20, 27, 28), $com, if(b.Idtipotx in (8, 9, 10, 16, 17, 18, 19, 29, 30, 32, 33, 34, 39), $inv, ''))) = 0, b.IdtxCompany, if(if(b.Idtipotx in (1, 2, 3, 4, 5, 6, 11, 12, 13, 15, 21, 22, 23, 24, 25, 26, 31, 35, 36, 37), $vta, if(b.Idtipotx in (7, 14, 20, 27, 28), $com, if(b.Idtipotx in (8, 9, 10, 16, 17, 18, 19, 29, 30, 32, 33, 34, 39), $inv, ''))) = 1, b.Idtx, b.Referencia)), 6, '0')) as Documento,
    CONCAT(e.RUT, ' ', e.Nombre) as beneficiario,
    b.Fectxclient, a.CodIdBasico, a.CodBarra, a.Descripcion, f.Nombre as Almacen, a.Medida,
    if(b.UserVendedor='0','COMERCIO',ex.Nombre) as Vendedor,
    $sqlCosto
    sum(c.Cant * d.Inventario) as cant,
    round((c.Total-c.MontoImpuesto)*d.inventario,2) as Precio
    FROM PosUpTxD c
    INNER JOIN PosUpTx d ON d.Idtipotx = c.Idtipotx
    INNER JOIN PosUpProducto a ON a.CodIdBasico = c.CodIdBasico AND a.IdCompany = c.IdCompany
    INNER JOIN PosUpTxC b ON b.Idtx = c.Idtx AND b.Idtipotx = c.Idtipotx AND b.IdEstacion = c.IdEstacion AND b.IdCompany = c.IdCompany
    LEFT JOIN PosUpUsers ex ON ex.IdCompany = b.IdCompany AND ex.Login = b.UserVendedor
    LEFT JOIN PosUpclientes e ON e.IdCompany = b.IdCompany AND e.RUT = b.IdBen
    LEFT JOIN PosUpAlmacen f ON f.IdCompany = c.IdCompany AND f.IdAlm = c.IdAlm
    WHERE c.IdCompany $companygrp AND c.Fectxclient BETWEEN '$fechaD 00:00:00' and '$fechaH 23:59:59'
    $Almacen23 $Producto $BeneficiarioSE $buscar $idUbi
    GROUP BY c.Idtipotx, c.Idtx, c.IdEstacion, c.IdAlm, c.CodIdBasico
    $OrdenBy";

$result = mysqli_query($conn, $query);

// =========================================================================
// INICIAMOS LA CAPTURA DEL HTML
// =========================================================================
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Tahoma, sans-serif; font-size: 8pt; color: #333; margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 5px; }
        th { background-color: #f2f2f2; font-weight: bold; padding: 5px; border: 1px solid #ccc; text-align: left; }
        td { padding: 4px; border-bottom: 1px solid #eee; vertical-align: top; }
        .num { text-align: right !important; }
        .subtotal-row { background-color: #f9f9f9; font-weight: bold; border-top: 1px solid #999; }
        .total-row { background-color: #2c3e50; color: #fff; font-weight: bold; font-size: 10pt; }
        .doc-header { background-color: #e8f0fe; color: #1a73e8; font-weight: bold; padding: 5px; border-top: 1px solid #1a73e8; }
    </style>
</head>
<body>
    <table class="main-table">
        <thead>
            <tr>
                <th width="12%">Código / Ref</th>
                <th width="35%">Descripción</th>
                <th width="15%">Almacén</th>
                <th width="10%">Vendedor</th>
                <th width="10%" class="num">Cantidad</th>
                <?php if (($_POST["Costoop"] ?? '') == true) { ?><th width="8%" class="num">Costo</th><?php } ?>
                <?php if (($_POST["Precioop"] ?? '') == true) { ?><th width="10%" class="num">Precio</th><?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $last_doc = ""; $nt = 0;
            $sub_cant = 0; $sub_costo = 0; $sub_precio = 0;
            $tot_cant = 0; $tot_costo = 0; $tot_precio = 0;

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $nt++;
                    $current_doc = $row['Documento'];

                    // Cambio de Documento: Imprimir Subtotal y nuevo encabezado
                    if ($current_doc != $last_doc) {
                        if ($last_doc != "") {
                            // Imprimir Fila Subtotal
                            echo "<tr class='subtotal-row'>";
                            echo "<td colspan='4' align='right'>SUBTOTAL " . $last_doc . ":</td>";
                            echo "<td class='num'>" . number_format($sub_cant, 2) . "</td>";
                            if (($_POST["Costoop"] ?? '') == true) echo "<td class='num'>" . number_format($sub_costo, 2) . "</td>";
                            if (($_POST["Precioop"] ?? '') == true) echo "<td class='num'>" . number_format($sub_precio, 2) . "</td>";
                            echo "</tr>";
                            // Reset Subtotales
                            $sub_cant = 0; $sub_costo = 0; $sub_precio = 0;
                        }
                        // Encabezado de Documento
                        echo "<tr><td colspan='7' class='doc-header'>DOCUMENTO: " . $current_doc . " | CLIENTE: " . ($row['beneficiario'] ?: 'N/A') . " | FECHA: " . $row['Fectxclient'] . "</td></tr>";
                        $last_doc = $current_doc;
                    }

                    // Acumuladores
                    $sub_cant += $row['cant'];
                    $tot_cant += $row['cant'];
                    if (isset($row['Costos'])) { $sub_costo += $row['Costos']; $tot_costo += $row['Costos']; }
                    if (isset($row['Precio'])) { $sub_precio += $row['Precio']; $tot_precio += $row['Precio']; }

                    // Fila de datos
                    ?>
                    <tr>
                        <td><?php echo $row['CodBarra'] ?: $row['CodIdBasico']; ?></td>
                        <td><?php echo mb_strtoupper($row['Descripcion']); ?></td>
                        <td><?php echo $row['Almacen']; ?></td>
                        <td><?php echo $row['Vendedor']; ?></td>
                        <td class="num"><?php echo number_format($row['cant'], 2) . " " . $row['Medida']; ?></td>
                        <?php if (($_POST["Costoop"] ?? '') == true) { ?> <td class="num"><?php echo number_format($row['Costos'], 2); ?></td> <?php } ?>
                        <?php if (($_POST["Precioop"] ?? '') == true) { ?> <td class="num"><?php echo number_format($row['Precio'], 2); ?></td> <?php } ?>
                    </tr>
                    <?php
                }
                
                // Subtotal del último documento
                if ($last_doc != "") {
                    echo "<tr class='subtotal-row'>";
                    echo "<td colspan='4' align='right'>SUBTOTAL " . $last_doc . ":</td>";
                    echo "<td class='num'>" . number_format($sub_cant, 2) . "</td>";
                    if (($_POST["Costoop"] ?? '') == true) echo "<td class='num'>" . number_format($sub_costo, 2) . "</td>";
                    if (($_POST["Precioop"] ?? '') == true) echo "<td class='num'>" . number_format($sub_precio, 2) . "</td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4" align="right">TOTAL GENERAL (<?php echo $nt; ?> Movimientos):</td>
                <td class="num"><?php echo number_format($tot_cant, 2); ?></td>
                <?php if (($_POST["Costoop"] ?? '') == true) { ?> <td class="num"><?php echo number_format($tot_costo, 2); ?></td> <?php } ?>
                <?php if (($_POST["Precioop"] ?? '') == true) { ?> <td class="num"><?php echo number_format($tot_precio, 2); ?></td> <?php } ?>
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
    'format' => 'Letter-L', // Horizontal para que entren todas las columnas
    'margin_top' => 35,
    'margin_bottom' => 15,
    'margin_left' => 8,
    'margin_right' => 8,
    'tempDir' => __DIR__ . '/tmp'
]);

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
            <div style="font-size: 7.5pt;">'.($_POST["direccion"] ?? '').'</div>
        </td>
        <td width="50%" align="center" style="vertical-align: top;">
            <div style="font-size: 14pt; font-weight: bold; color: #1a73e8; margin-bottom:5px;">OPERACIONES DE INVENTARIO</div>
            <div style="font-size: 8.5pt;">Almacén: <b>'.$txtAlmacenes.'</b></div>
            <div style="font-size: 8.5pt;">Periodo: <b>'.$fechaD.'</b> hasta <b>'.$fechaH.'</b></div>
        </td>
        <td width="25%" align="right" style="vertical-align: top;">
            <div style="font-size: 8pt; font-weight: bold;">'.$_POST["fectx5"].'</div>
            <div style="font-size: 8pt; margin-top:10px;">Pág. {PAGENO}/{nbpg}</div>
        </td>
    </tr>
</table>';

$mpdf->SetHTMLHeader($cabeceraPDF);
$mpdf->WriteHTML($html);
$mpdf->Output('Operaciones_Inventario.pdf', 'I');
?>