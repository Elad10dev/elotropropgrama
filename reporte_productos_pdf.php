<?php
// 1. CONFIGURACIÓN DE ALTO RENDIMIENTO
ini_set('memory_limit', '2048M');
ini_set('max_execution_time', '1800');
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', 0);

require_once __DIR__ . '/vendor/autoload.php';
use Mpdf\Mpdf;

// Conexión específica para reposición
include "ambienteconsultas.php";
$conn = Conectar();
session_start();

if ($_SESSION['IdiomaActual'] == '') {
    $_SESSION['IdiomaActual'] = $_POST['IdiomaActual'];
}

// 2. RECEPCIÓN DE DATOS Y CONFIGURACIÓN
$company = $_POST["CompanyActual"];
$sucursal = $_POST['sucursal'] ?? '0';
$fechaHAS3 = $_POST["FechaHastares"] ?? date('Y-m-d');

// Lógica de Empresa / Grupo
if ($_POST['CIdPlan'] == '0000000019') {
    if ($_POST['IdCompanySelect'] == '' or $_POST['IdCompanySelect'] == $_POST["IdCompanyGrp"]) {
        $companygrp = " in (" . $_POST["CompanyActual"] . "," . $_POST["IdCompanyGrp"] . ") ";
    } else {
        $companygrp = " in (" . $_POST["IdCompanySelect"] . ") ";
    }
} else {
    $companygrp = " = " . $_POST["CompanyActual"] . "  ";
}

// 3. CONSTRUCCIÓN DE FILTROS PARA EL SQL (Tu código intacto)
$beetween = ""; 
$almacenn = ""; 
$familia = ""; 
$marca = ""; 
$Order = "Order by a.CodIdBasico"; 
$SinM = ""; 
$ConMov = ""; 

if (!empty($_POST["mIdProductos"])) { $beetween = " and a.CodIdBasico in ('" . implode("','", $_POST["mIdProductos"]) . "') "; }
if (!empty($_POST["mIdAlmacen"])) { $almacenn = " and c.idal in ('" . implode("','", $_POST["mIdAlmacen"]) . "')"; }
if (!empty($_POST["mIdfamilia"])) { $familia = " and a.Idfamilia in ('" . implode("','", $_POST["mIdfamilia"]) . "') "; }
if (!empty($_POST["mIdMarca"])) { $marca = "and a.Marca in ('" . implode("','", $_POST["mIdMarca"]) . "')"; }

// Ordenamiento
if ($_POST["OrdenRESres"] == "1") { $Order = "Order by a.CodIdBasico"; $ordenTxt = "Código"; }
elseif ($_POST["OrdenRESres"] == "2") { $Order = "Order by a.Descripcion"; $ordenTxt = "Descripción"; }
elseif ($_POST["OrdenRESres"] == "3") { $Order = "Order by a.CodBarra"; $ordenTxt = "Referencia"; }
elseif ($_POST["OrdenRESres"] == "4") { $Order = "Order by a.Idfamilia"; $ordenTxt = "Familia"; }
else { $ordenTxt = "Código"; }

if (($_POST["SinM"] ?? '') == "on") { $SinM = " and c.cantidad <> 0"; }
if (($_POST["referenciares"] ?? '') == "on") { $ConMov = " and a.CodBarra <> 0"; }

// Lógica de Existencia
$mexis = "round(coalesce(c.cantidad,0),2) as ExisActual,";
$ExisAct = "";
if (($_POST["ExistenciaNULL"] ?? '') != "on") {
    $ExisAct = "HAVING ExisActual<>0";
}

// Textos descriptivos de filtros para la cabecera PDF
$filtrosTxt = "";
if (($_POST["ExistenciaNULL"] ?? '') == "on") $filtrosTxt .= " / Existencia Cero";
if (($_POST["referenciares"] ?? '') == "on") $filtrosTxt .= " / Prod. con Referencia";
if (($_POST["SinM"] ?? '') == "on") $filtrosTxt .= " / Sin Movimientos";
$filtrosTxt = ($filtrosTxt != "") ? "Incluyendo: " . trim($filtrosTxt, " /") : "Filtro Padrón";

// 4. CONSULTA SQL ORIGINAL
if ($sucursal == '0') {
    $query = "SELECT a.CodIdAmpliado,a.CodIdBasico,a.CodBarra, a.Descripcion, " . $mexis . " c.Fectxclient,a.factorunit,a.Medida,
    (a.factorunit * round(coalesce(c.cantidad,0),2)) as CantX,
    a.Min as Minimo, coalesce(a.max,0) as Maximo,
    coalesce(c.cantidad,0) as Movimientos,
    round(coalesce(c.COrdCompras,0),2) as Pedido,
    round(coalesce(c.Comprometido,0),2) as Comprometido, 
    coalesce(round(coalesce(c.cantidad,0)+c.COrdCompras-c.Comprometido,2),0) as Diferencia,
    coalesce(round(a.max - (round(coalesce(c.cantidad,0),3)+c.COrdCompras-c.Comprometido),2),0) as Faltante, 
    round(a.Costo,2) as Costo, 
    coalesce(round(a.Costo,2)*round(a.max - (round(coalesce(c.cantidad,0),3)+c.COrdCompras-c.Comprometido),2),0) as CostaPedido
    FROM PosUpProducto a 
    left join (select ba.IdCompany, ba.CodIdBasico,ba.IdAlm as idal,ba.Fectxclient,
    sum(if(ba.Idtipotx=1,ba.Cant*bb.Inventario,0)) as cboletas,
    sum(if(ba.Idtipotx=2,ba.Cant*bb.Inventario,0)) as cfacturas,
    sum(if(ba.Idtipotx=3,ba.Cant*bb.Inventario,0)) as cdevolucion,
    sum(if(ba.Idtipotx=7,ba.Cant*bb.Inventario,0)) as Ccompras, 
    sum(if(ba.Idtipotx=8,ba.Cant*bb.Inventario,0)) as Cajustes,
    sum(if(ba.Idtipotx=9,ba.Cant*bb.Inventario,0)) as Ctraslados,
    sum(if(ba.Idtipotx=14,ba.Cant,0)) as COrdCompras,
    sum(if(ba.Idtipotx=11,ba.Cant,0)) as Comprometido,
    sum(if(ba.Idtipotx=10,ba.Cant*bb.Inventario,0)) as CTomas,
    sum(ba.Cant*bb.Inventario) as cantidad
    from PosUpTxD ba inner join PosUpTx bb on ba.Idtipotx = bb.Idtipotx 
    where ba.IdCompany " . $companygrp . " and ba.Fectxclient <='" . $fechaHAS3 . " 23:59:59'
    GROUP by ba.IdCompany,ba.CodIdBasico ) c on a.IdCompany = c.IdCompany and a.CodIdBasico = c.CodIdBasico 
    where a.IdCompany " . $companygrp . " AND a.EsCompuesto=0 and c.Fectxclient <='" . $fechaHAS3 . " 23:59:59'
    " . $almacenn . " " . $familia . " " . $marca . " " . $ConMov . " " . $SinM . " " . $beetween . " " . $ExisAct . " " . $Order;
} else {
    $query = "SELECT a.CodIdAmpliado,a.CodIdBasico,a.CodBarra, a.Descripcion, " . $mexis . " c.Fectxclient,a.factorunit,a.Medida,
    a.Min as Minimo, coalesce(a.max,0) as Maximo,
    (a.factorunit * round(coalesce(c.cantidad,0),2)) as CantX,
    coalesce(c.cantidad,0) as Movimientos,
    round(coalesce(c.COrdCompras,0),2) as Pedido,
    round(coalesce(c.Comprometido,0),2) as Comprometido, 
    coalesce(round(coalesce(c.cantidad,0)+c.COrdCompras-c.Comprometido,2),0) as Diferencia,
    coalesce(round(a.max - (round(coalesce(c.cantidad,0),3)+c.COrdCompras-c.Comprometido),2),0) as Faltante, 
    round(a.Costo,2) as Costo, 
    coalesce(round(a.Costo,2)*round(a.max - (round(coalesce(c.cantidad,0),3)+c.COrdCompras-c.Comprometido),2),0) as CostaPedido
    FROM PosUpProducto a 
    left join (select ba.IdCompany, ba.CodIdBasico,ba.IdAlm as idal,ba.Fectxclient,
    sum(if(ba.Idtipotx=1,ba.Cant*bb.Inventario,0)) as cboletas,
    sum(if(ba.Idtipotx=2,ba.Cant*bb.Inventario,0)) as cfacturas,
    sum(if(ba.Idtipotx=3,ba.Cant*bb.Inventario,0)) as cdevolucion,
    sum(if(ba.Idtipotx=7,ba.Cant*bb.Inventario,0)) as Ccompras, 
    sum(if(ba.Idtipotx=8,ba.Cant*bb.Inventario,0)) as Cajustes,
    sum(if(ba.Idtipotx=9,ba.Cant*bb.Inventario,0)) as Ctraslados,
    sum(if(ba.Idtipotx=14,ba.Cant,0)) as COrdCompras,
    sum(if(ba.Idtipotx=11,ba.Cant,0)) as Comprometido,
    sum(if(ba.Idtipotx=10,ba.Cant*bb.Inventario,0)) as CTomas,
    sum(ba.Cant*bb.Inventario) as cantidad
    from PosUpTxD ba inner join PosUpTx bb on ba.Idtipotx = bb.Idtipotx 
    inner join PosUpAlmacen z on ba.IdCompany=z.IdCompany and ba.IdAlm=z.IdAlm
    inner join PosUpAlmacen x on x.IdCompany=z.IdCompany and x.IdUbi=z.IdUbi
    where ba.IdCompany " . $companygrp . " and z.IdUbi=" . $sucursal . " and ba.Fectxclient <='" . $fechaHAS3 . " 23:59:59'  GROUP by ba.IdCompany,ba.CodIdBasico ) c on a.IdCompany = c.IdCompany and a.CodIdBasico = c.CodIdBasico 
    where a.IdCompany " . $companygrp . " AND a.EsCompuesto=0 and c.Fectxclient <='" . $fechaHAS3 . " 23:59:59'
    " . $almacenn . " " . $familia . " " . $marca . " " . $ConMov . " " . $SinM . " " . $beetween . " " . $ExisAct . " " . $Order;
}

$result = mysqli_query($conn, $query);

// =========================================================================
// INICIAMOS CAPTURA DE HTML PARA MPDF
// =========================================================================
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Tahoma, Verdana, Segoe, sans-serif; font-size: 7.5pt; color: #333; margin:0; }
        
        /* Tabla Principal */
        .table-main { width: 100%; border-collapse: collapse; margin-top: 5px; }
        .table-main th { 
            background-color: #f2f2f2; 
            color: #000; 
            font-weight: bold; 
            text-align: center; 
            padding: 5px 2px; 
            border: 1px solid #aaa; 
            font-size: 7pt;
        }
        .table-main td { 
            padding: 4px 2px; 
            border: 1px solid #ccc; 
            vertical-align: middle; 
            font-size: 7pt; 
        }
        .num { text-align: right !important; }
        .cen { text-align: center !important; }
        
        /* Fila Zebra */
        tbody tr:nth-child(even) { background-color: #fcfcfc; }
    </style>
</head>
<body>

    <table class="table-main">
        <thead>
            <tr>
                <th width="8%">Codigo Barra</th>
                <th width="7%">Codigo Basico</th>
                <th width="8%">Codigo Ampliado</th>
                <th width="23%">Descripcion</th>
                <th width="7%">Existencia Actual</th>
                <th width="6%">DS/Mov</th>
                <th width="6%">E/Maxima</th>
                <th width="6%">E/Minima</th>
                <th width="6%">Pedido</th>
                <th width="6%">Comprom</th>
                <th width="6%">Diferencia</th>
                <th width="6%">Faltante</th>
                <th width="7%">Costo Actual</th>
                <th width="8%">Costo Pedido</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $nt = 0;
            $dec = $_POST["SimDec"] ?? '.';
            $mil = $_POST["SimMil"] ?? ',';
            $cd = $_POST["CD"] ?? 2;

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $nt++;
                    
                    // Tratamiento visual de campos según tu lógica
                    $codBarra = trim($row['CodBarra']) === "" ? "-" : $row['CodBarra'];
                    $codBasico = trim($row['CodIdBasico']) === "" ? "-" : $row['CodIdBasico'];
                    $codAmp = trim($row['CodIdAmpliado']) === "" ? "-" : $row['CodIdAmpliado'];
                    $desc = trim($row['Descripcion']) === "" ? "-" : $row['Descripcion'];

                    // Existencia
                    if (trim($row["ExisActual"]) === "") {
                        $exisTxt = "-";
                    } else {
                        // Formula de tu código original:
                        if ($row["factorunit"] <> 1 && $row["factorunit"] <> 0) {
                            $exisTxt = $row["factorunit"] . " x " . number_format($row["ExisActual"], $cd, $dec, $mil) . " = " . number_format($row["CantX"], $cd, $dec, $mil) . ' ' . $row["Medida"];
                        } else {
                            $exisTxt = number_format($row['ExisActual'], $cd, $dec, $mil);
                        }
                    }

                    $dsMov = trim($row['DsMov'] ?? '') === "" ? "-" : $row["DsMov"];
                    $max = trim($row['Maximo']) === "" ? "-" : $row['Maximo'];
                    $min = trim($row['Minimo']) === "" ? "-" : $row['Minimo'];
                    
                    $pedido = trim($row['Pedido']) === "" ? "-" : number_format($row['Pedido'], $cd, $dec, $mil);
                    $comprom = trim($row['Comprometido']) === "" ? "-" : number_format($row['Comprometido'], $cd, $dec, $mil);
                    $dif = trim($row['Diferencia']) === "" ? "-" : number_format($row['Diferencia'], $cd, $dec, $mil);
                    $faltante = trim($row['Faltante']) === "" ? "-" : number_format($row['Faltante'], $cd, $dec, $mil);
                    $costo = trim($row['Costo']) === "" ? "-" : number_format($row['Costo'], $cd, $dec, $mil);
                    $costoPed = trim($row['CostaPedido']) === "" ? "-" : number_format($row['CostaPedido'], $cd, $dec, $mil);

            ?>
            <tr>
                <td class="cen"><?php echo $codBarra; ?></td>
                <td class="cen"><?php echo $codBasico; ?></td>
                <td class="cen"><?php echo $codAmp; ?></td>
                <td><?php echo $desc; ?></td>
                <td class="num"><?php echo $exisTxt; ?></td>
                <td class="num"><?php echo $dsMov; ?></td>
                <td class="num"><?php echo $max; ?></td>
                <td class="num"><?php echo $min; ?></td>
                <td class="num"><?php echo $pedido; ?></td>
                <td class="num"><?php echo $comprom; ?></td>
                <td class="num"><?php echo $dif; ?></td>
                <td class="num"><?php echo $faltante; ?></td>
                <td class="num"><?php echo $costo; ?></td>
                <td class="num"><?php echo $costoPed; ?></td>
            </tr>
            <?php
                }
            }
            
            if ($nt == 0) {
                echo '<tr><td colspan="14" align="center" style="padding:15px; color:red; font-weight:bold;">No se encontraron resultados con los filtros actuales.</td></tr>';
            }
            ?>
        </tbody>
    </table>

    <div style="margin-top:15px; border-top:1px solid #000; padding-top:5px; font-weight:bold; font-size:9pt;">
        Total Registros Acumulados: <?php echo $nt; ?>
    </div>

</body>
</html>
<?php
// =========================================================================
// TERMINA CAPTURA Y CONFIGURACIÓN MPDF
// =========================================================================
$html = ob_get_clean();

$mpdf = new Mpdf([
    'mode' => 'utf-8',
    'format' => 'Letter-L', // HORIZONTAL OBLIGATORIO PARA 14 COLUMNAS
    'margin_top' => 25,     // Espacio para la cabecera
    'margin_bottom' => 10,
    'margin_left' => 8,
    'margin_right' => 8,
    'tempDir' => __DIR__ . '/tmp'
]);

// Carga de Logo
$srcLogo = "img/informez.png"; 
$pathEntorno = "Comercio/" . $_POST['CompanyActual'] . "/entorno";
if (is_dir($pathEntorno) && $scan = @scandir($pathEntorno)) {
    foreach($scan as $f){ if(strpos($f, "Logotipo") === 0){ $srcLogo = "$pathEntorno/$f"; break; } }
}

// Cabecera PDF idéntica a tu HTML original
$cabeceraPDF = '
<table width="100%" style="font-family: sans-serif; border-bottom: 2px solid #ccc; padding-bottom: 5px;">
    <tr>
        <td width="20%" style="vertical-align: top;">
            <img src="'.$srcLogo.'" style="max-height: 45px; margin-bottom:5px;"><br>
            <div style="font-weight: bold; font-size: 11pt;">'.mb_strtoupper($_POST["NameCompany"]).'</div>
            <div style="font-size: 7.5pt;">'.($_POST["direccion"] ?? '').'</div>
            <div style="font-size: 7.5pt;">'.($_POST["litfiscal"] ?? '').'-'.($_POST["rute"] ?? '').'</div>
        </td>
        <td width="60%" align="center" style="vertical-align: top;">
            <div style="font-size: 14pt; font-weight: bold; color: #1a73e8; margin-bottom:5px;">REPOSICIÓN DE INVENTARIO</div>
            <div style="font-size: 8pt;"><b>Orden por:</b> '.$ordenTxt.'</div>
            <div style="font-size: 8pt;"><b>Filtrado por:</b></div>
            <div style="font-size: 8pt;">'.$filtrosTxt.'</div>
        </td>
        <td width="20%" align="right" style="vertical-align: top;">
            <div style="font-size: 8pt; font-weight: bold;">'.$_POST["fectx5"].'</div>
            <div style="font-size: 8pt; margin-top:5px;">Pág. {PAGENO}/{nbpg}</div>
            <div style="font-size: 8pt; color: #1a73e8; margin-top:10px;">https://PosUp.cl<br>Email: info@posup.cl</div>
        </td>
    </tr>
</table>';

$mpdf->SetHTMLHeader($cabeceraPDF);

// Inyectar HTML de la tabla
$mpdf->WriteHTML($html);
$mpdf->Output('Reposicion_Inventario.pdf', 'I');
?>