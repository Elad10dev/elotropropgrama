<?php
// 1. CONFIGURACIÓN DE ALTO RENDIMIENTO
ini_set('memory_limit', '2048M');
ini_set('max_execution_time', '1800');
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', 0);

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

// Textos descriptivos de filtros para la cabecera
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
// INICIAMOS CAPTURA DE HTML PARA EL EXCEL
// =========================================================================
ob_start();

// Definimos el nombre del archivo
$nombreArchivo = "Reposicion_Inventario_" . date('Ymd_His') . ".xls";

// Cabeceras HTTP para forzar la descarga en Excel
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
        body { font-family: Tahoma, Verdana, Segoe, sans-serif; font-size: 10pt; color: #333; margin:0; }
        
        /* Tabla Principal */
        .table-main { width: 100%; border-collapse: collapse; margin-top: 5px; }
        .table-main th { 
            background-color: #1a73e8; /* Azul PosUp para Excel */
            color: #ffffff; 
            font-weight: bold; 
            text-align: center; 
            padding: 5px 2px; 
            border: 1px solid #aaa; 
        }
        .table-main td { 
            padding: 4px 2px; 
            border: 1px solid #ccc; 
            vertical-align: middle; 
        }
    </style>
</head>
<body>

    <table width="100%">
        <tr>
            <td colspan="14" align="center" style="font-size: 16pt; font-weight: bold; color: #1a73e8;">
                REPOSICIÓN DE INVENTARIO
            </td>
        </tr>
        <tr>
            <td colspan="14" align="center" style="font-size: 12pt; font-weight: bold;">
                <?php echo mb_strtoupper($_POST["NameCompany"]); ?>
            </td>
        </tr>
        <tr>
            <td colspan="14" align="center">
                <b>Orden por:</b> <?php echo $ordenTxt; ?> | <b>Filtros:</b> <?php echo $filtrosTxt; ?> | <b>Fecha:</b> <?php echo date('d/m/Y'); ?>
            </td>
        </tr>
        <tr><td colspan="14"></td></tr> </table>

    <table class="table-main">
        <thead>
            <tr>
                <th>Codigo Barra</th>
                <th>Codigo Basico</th>
                <th>Codigo Ampliado</th>
                <th>Descripcion</th>
                <th>Existencia Actual</th>
                <th>DS/Mov</th>
                <th>E/Maxima</th>
                <th>E/Minima</th>
                <th>Pedido</th>
                <th>Comprom</th>
                <th>Diferencia</th>
                <th>Faltante</th>
                <th>Costo Actual</th>
                <th>Costo Pedido</th>
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
                    
                    // Tratamiento visual de campos
                    $codBarra = trim($row['CodBarra']) === "" ? "-" : $row['CodBarra'];
                    $codBasico = trim($row['CodIdBasico']) === "" ? "-" : $row['CodIdBasico'];
                    $codAmp = trim($row['CodIdAmpliado']) === "" ? "-" : $row['CodIdAmpliado'];
                    $desc = trim($row['Descripcion']) === "" ? "-" : $row['Descripcion'];

                    // Existencia
                    if (trim($row["ExisActual"]) === "") {
                        $exisTxt = "-";
                    } else {
                        // Formula original
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
                <td align="center" style="mso-number-format:'\@';"><?php echo $codBarra; ?></td> <td align="center" style="mso-number-format:'\@';"><?php echo $codBasico; ?></td>
                <td align="center" style="mso-number-format:'\@';"><?php echo $codAmp; ?></td>
                <td><?php echo mb_strtoupper($desc); ?></td>
                <td align="right"><?php echo $exisTxt; ?></td>
                <td align="right"><?php echo $dsMov; ?></td>
                <td align="right"><?php echo $max; ?></td>
                <td align="right"><?php echo $min; ?></td>
                <td align="right"><?php echo $pedido; ?></td>
                <td align="right"><?php echo $comprom; ?></td>
                <td align="right"><?php echo $dif; ?></td>
                <td align="right"><?php echo $faltante; ?></td>
                <td align="right"><?php echo $costo; ?></td>
                <td align="right"><?php echo $costoPed; ?></td>
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

    <table width="100%">
        <tr><td colspan="14"></td></tr>
        <tr>
            <td colspan="14" align="left" style="border-top:2px solid #000; font-weight:bold; font-size:10pt;">
                Total Registros Acumulados: <?php echo $nt; ?>
            </td>
        </tr>
    </table>

</body>
</html>
<?php
// Imprimimos todo el buffer y terminamos la ejecución
ob_end_flush();
exit;
?>