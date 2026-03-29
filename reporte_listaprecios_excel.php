<?php
// 1. CONFIGURACIÓN DE ALTO RENDIMIENTO
ini_set('memory_limit', '2048M');
ini_set('max_execution_time', '1800');
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', 0);

include "ambiente.php";
$conn = ConectarConsultas();
session_start();

if ($_SESSION['IdiomaActual'] == '') {
    $_SESSION['IdiomaActual'] = $_POST['IdiomaActual'];
}

$sql = "SELECT LitP01,LitP02,LitP03,LitP04,LitP05,LitP06,LitP07,LitP08,LitP09,LitP10,LitCosto,MonedaS,FactorDolarCash,MonedaP,FactorDolarPaypal,Moneda3,FactorDolarZelle,Moneda4,FactorDolar5,Moneda5,FactorDolar6,Moneda6,FactorDolar7,Moneda7 FROM PosUpCompany 
where Id=" . $_POST["CompanyActual"] . "";
if ($result = mysqli_query($conn, $sql)) {
    while ($row = mysqli_fetch_assoc($result)) {
        $LitP01 = $row["LitP01"];
        $LitP02 = $row["LitP02"];
        $LitP03 = $row["LitP03"];
        $LitP04 = $row["LitP04"];
        $LitP05 = $row["LitP05"];
        $LitP06 = $row["LitP06"];
        $LitP07 = $row["LitP07"];
        $LitP08 = $row["LitP08"];
        $LitP09 = $row["LitP09"];
        $LitP10 = $row["LitP10"];
        $LitCosto = $row["LitCosto"];
        $company = [
            "FactorDolarCash" => $row["FactorDolarCash"],
            "MonedaS" => $row["MonedaS"],
            "FactorDolarPaypal" => $row["FactorDolarPaypal"],
            "Moneda3" => $row["Moneda3"],
            "FactorDolarZelle" => $row["FactorDolarZelle"],
            "Moneda4" => $row["Moneda4"],
            "FactorDolar5" => $row["FactorDolar5"],
            "Moneda5" => $row["Moneda5"],
            "FactorDolar6" => $row["FactorDolar6"],
            "Moneda6" => $row["Moneda6"],
            "FactorDolar7" => $row["FactorDolar7"],
            "Moneda7" => $row["Moneda7"],
            "MonedaP" => $row["MonedaP"],
        ];
    }
}
$tasa = 1;
$moneda = $company["MonedaP"];
if (trim($_POST["SelectTasa"]) === "2") {
    $tasa = floatval($company["FactorDolarCash"]);
    $moneda = $company["MonedaS"];
} else if (trim($_POST["SelectTasa"]) === "3") {
    $tasa = floatval($company["FactorDolarPaypal"]);
    $moneda = $company["Moneda3"];
} else if (trim($_POST["SelectTasa"]) === "4") {
    $tasa = floatval($company["FactorDolarZelle"]);
    $moneda = $company["Moneda4"];
} else if (trim($_POST["SelectTasa"]) === "5") {
    $tasa = floatval($company["FactorDolar5"]);
    $moneda = $company["Moneda5"];
} else if (trim($_POST["SelectTasa"]) === "6") {
    $tasa = floatval($company["FactorDolar6"]);
    $moneda = $company["Moneda6"];
} else if (trim($_POST["SelectTasa"]) === "7") {
    $tasa = floatval($company["FactorDolar7"]);
    $moneda = $company["Moneda7"];
}

$calcTotal = 38.5;
$n = 0;
$Having = [];

if (($_POST["costozzzv"] ?? '') == "on") { $n++; $Having[] = "costo > 0"; }
if (($_POST["precioz"] ?? '') == "on") { $n++; $Having[] = "PrecioNeto > 0"; }
if (($_POST["precio2z"] ?? '') == "on") { $n++; $Having[] = "PrecioNeto2 > 0"; }
if (($_POST["precio3z"] ?? '') == "on") { $n++; $Having[] = "PrecioNeto3 > 0"; }
if (($_POST["precio4z"] ?? '') == "on") { $n++; $Having[] = "PrecioNeto4 > 0"; }
if (($_POST["precio5z"] ?? '') == "on") { $n++; $Having[] = "PrecioNeto5 > 0"; }
if (($_POST["precio6z"] ?? '') == "on") { $n++; $Having[] = "PrecioNeto6 > 0"; }
if (($_POST["precio7z"] ?? '') == "on") { $n++; $Having[] = "PrecioNeto7 > 0"; }
if (($_POST["precio8z"] ?? '') == "on") { $n++; $Having[] = "PrecioNeto8 > 0"; }
if (($_POST["precio9z"] ?? '') == "on") { $n++; $Having[] = "PrecioNeto9 > 0"; }
if (($_POST["precio10z"] ?? '') == "on") { $n++; $Having[] = "PrecioNeto10 > 0"; }

$calc = $n > 0 ? $calcTotal / $n : 0;

if ($_POST["Agrupar"] == "empty") {

    // LOGICA DE CONSULTA (Idéntica a tu PDF)
    $Orden = "order by a.Descripcion";
    if (($_POST["OrdenLP"] ?? '') == "Codigo") { $Orden = "order by a.CodIdBasico"; }
    if (($_POST["OrdenLP"] ?? '') == "Descripcion") { $Orden = "order by a.Descripcion"; }
    if (($_POST["OrdenLP"] ?? '') == "Referencia") { $Orden = "order by a.CodBarra"; }
    if (($_POST["OrdenLP"] ?? '') == "Instancia") { $Orden = "order by e.ITEM"; }
    if (($_POST["OrdenLP"] ?? '') == "Marca") { $Orden = "order by d.nombre"; }
    if (($_POST["OrdenLP"] ?? '') == "PrecioNeto") { $Orden = "order by a.PrecioNeto desc"; }

    $familia = "";
    if (!empty($_POST["mIdfamilia"])) {
        $familia = " and a.Idfamilia " . (($_POST["NotIncludeFamilia"] ?? '') === "on" ? "not" : "") . " in ('" . implode("','", $_POST["mIdfamilia"]) . "') ";
    }
    $beetween = "";
    if (!empty($_POST["mIdProductos"])) {
        $beetween = " and a.CodIdBasico " . (($_POST["NotIncludeProductos"] ?? '') === "on" ? "not" : "") . " in ('" . implode("','", $_POST["mIdProductos"]) . "') ";
    }
    $Deposito4 = "";
    if (!empty($_POST["mIdAlmacen"])) {
        $Deposito4 = " and a.IdAlm " . (($_POST["NotIncludeAlmacen"] ?? '') === "on" ? "not" : "") . " in ('" . implode("','", $_POST["mIdAlmacen"]) . "') ";
    }
    $Marca = "";
    if (!empty($_POST["mIdMarca"])) {
        $Marca = "and a.Marca " . (($_POST["NotIncludeMarca"] ?? '') === "on" ? "not" : "") . " in ('" . implode("','", $_POST["mIdMarca"]) . "')";
    }

    $buscar = "";
    if (($_POST["EnvioEstado"] ?? '*') !== "*") { $buscar .= "and a.Estado = " . $_POST["EnvioEstado"]; }
    
    $ExistenciaCero = "";
    if (!isset($_POST["ExistenciaCero"]) || $_POST["ExistenciaCero"] !== "on") {
        $ExistenciaCero = " and coalesce(round(b.cantidad,3),0)<>0";
    }
    
    $referencia = "";
    if (!empty($_POST["RefLP1"])) { $referencia = "and a.CodBarra='" . $_POST["RefLP1"] . "'"; }
    
    $existencia = (($_POST["Existencia"] ?? '') == "on") ? "round(coalesce(b.cantidad,0),2) as Existencia,  " : "1 as Existencia,";

    $fechaA = " where a.Fectxclient <= '" . $_POST["FechaHastalista"] . " 23:59:59'";
    $fechaC = " where c.Fectxclient <= '" . $_POST["FechaHastalista"] . " 23:59:59'";

    if (($_POST['cimp'] ?? '') == false) {
        $price1 = "round(coalesce(a.PrecioNeto * " . $tasa . ",0),2) as PrecioNeto, ";
        $price2 = "round(coalesce(a.PrecioNeto2 * " . $tasa . ",0),2) as PrecioNeto2, ";
        $price3 = "round(coalesce(a.PrecioNeto3 * " . $tasa . ",0),2) as PrecioNeto3, ";
        $price4 = "round(coalesce(a.PrecioNeto4 * " . $tasa . ",0),2) as PrecioNeto4, ";
        $price5 = "round(coalesce(a.PrecioNeto5 * " . $tasa . ",0),2) as PrecioNeto5, ";
        $price6 = "round(coalesce(a.PrecioNeto6 * " . $tasa . ",0),2) as PrecioNeto6, ";
        $price7 = "round(coalesce(a.PrecioNeto7 * " . $tasa . ",0),2) as PrecioNeto7, ";
        $price8 = "round(coalesce(a.PrecioNeto8 * " . $tasa . ",0),2) as PrecioNeto8, ";
        $price9 = "round(coalesce(a.PrecioNeto9 * " . $tasa . ",0),2) as PrecioNeto9, ";
        $price10 = "round(coalesce(a.PrecioNeto10 * " . $tasa . ",0),2) as PrecioNeto10, ";
    } else {
        $price1 = "round(coalesce(a.PrecioVenta * " . $tasa . ",0),2) as PrecioNeto, ";
        $price2 = "round(coalesce(a.PrecioVenta2 * " . $tasa . ",0),2) as PrecioNeto2, ";
        $price3 = "round(coalesce(a.PrecioVenta3 * " . $tasa . ",0),2) as PrecioNeto3, ";
        $price4 = "round(coalesce(a.PrecioVenta4 * " . $tasa . ",0),2) as PrecioNeto4, ";
        $price5 = "round(coalesce(a.PrecioVenta5 * " . $tasa . ",0),2) as PrecioNeto5, ";
        $price6 = "round(coalesce(a.PrecioVenta6 * " . $tasa . ",0),2) as PrecioNeto6, ";
        $price7 = "round(coalesce(a.PrecioVenta7 * " . $tasa . ",0),2) as PrecioNeto7, ";
        $price8 = "round(coalesce(a.PrecioVenta8 * " . $tasa . ",0),2) as PrecioNeto8, ";
        $price9 = "round(coalesce(a.PrecioVenta9 * " . $tasa . ",0),2) as PrecioNeto9, ";
        $price10 = "round(coalesce(a.PrecioVenta10 * " . $tasa . ",0),2) as PrecioNeto10, ";
    }
    
    $costo = "";
    if (($_POST['costozzzv'] ?? '') == "on") {
        $costo = (($_POST['cimp'] ?? '') == false) ? "round(coalesce(a.CostoNeto * " . $tasa . ",0),2) as costo," : "round(coalesce(a.Costo * " . $tasa . ",0),2) as costo,";
    }

    $ubic = "";
    if (($_POST['sucursal'] ?? '0') <> '0') {
        $ubic = " and f.IdUbi=" . $_POST['sucursal'];
    }

    $query = "SELECT DISTINCT a.CodIdAmpliado,a.CodIdBasico,a.CodBarra, a.Descripcion ,a.Envase,e.ITEM as Familia,a.factorunit,a.Medida,
        d.nombre as Marca, a.Medida as Unidades,
        a.medida as uniP1,truncate(b.cantidad,0) as cuniP1d,a.medida as uniP1d,
        round(a.CantP1 * (b.cantidad-truncate(b.cantidad,0)),0) as cuniP2d,a.UnidadP1 as uniP2d,a.CantP1, 
        " . $existencia . $costo . $price1 . $price2 . $price3 . $price4 . $price5 . $price6 . $price7 . $price8 . $price9 . $price10 . "
        coalesce(f.VALOR*100,0) as ValorImpuesto
        FROM PosUpProducto a
        left join (SELECT a.IdCompany,a.IdAlm, b.CodIdBasico,sum(coalesce(a.Cant)*coalesce(d.Inventario)) as Cantidad 
        FROM PosUpTxD a
        inner join PosUpTx d on a.Idtipotx=d.Idtipotx and d.Inventario <> 0
        left join PosUpAlmacen f on a.IdCompany=f.IdCompany and a.IdAlm=f.IdAlm
        left join PosUpUbicacion z on f.IdCompany=z.IdCompany and f.IdUbi=z.IdUbi
        inner join PosUpProducto b on a.IdCompany=b.IdCompany and a.CodIdBasico=b.CodIdBasico
        " . $fechaA . " " . $ubic . " and a.IdCompany= " . $_POST["CompanyActual"] . "
        " . $Deposito4 . "
        group by a.IdCompany,b.CodIdBasico
        ) b on a.IdCompany = b.IdCompany and a.CodIdBasico = b.CodIdBasico
        left join (select a.nombre,a.idmarca,a.IdCompany,b.CodIdBasico from PosUpc_marcas a 
        inner join PosUpProducto b on a.IdCompany=b.IdCompany and a.idmarca=b.Marca
        WHERE a.IdCompany= " . $_POST["CompanyActual"] . "
        GROUP by a.IdCompany,b.CodIdBasico) d on a.IdCompany= d.IdCompany and a.CodIdBasico=d.CodIdBasico
        left join PosUpvarios e on a.IdCompany=e.IdCompany and a.Idfamilia=e.IdVarios and e.TIPOITEM= 2
        left join PosUpvarios f on a.IdCompany=f.IdCompany and a.Impuesto=f.IdVarios and f.TIPOITEM= 0
        where a.IdCompany= " . $_POST["CompanyActual"] . " and a.EsCompuesto in (20,1,0) " . $beetween . " 
        " . $buscar . "
        " . $ExistenciaCero . "                                        
        " . $Marca . "
        " . $familia . "
        " . $referencia . "
        " . (!empty($Having) ? "HAVING " . implode(" or ", $Having) : "") . "
        " . $Orden . "
        " . $limit;

    $result = mysqli_query($conn, $query);

// =========================================================================
// INICIAMOS DESCARGA EN EXCEL
// =========================================================================
    $nombreArchivo = "Lista_de_Precios_" . date('Ymd_His') . ".xls";
    header("Content-Type: application/vnd.ms-excel; charset=utf-8");
    header("Content-Disposition: attachment; filename=$nombreArchivo");
    header("Pragma: no-cache");
    header("Expires: 0");
    echo "\xEF\xBB\xBF"; // BOM para UTF-8

?>
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; font-size: 10pt; color: #333; margin:0; }
        table { width: 100%; border-collapse: collapse; margin-top: 5px; }
        th { background-color: #1a73e8; color: #ffffff; font-weight: bold; text-align: center; padding: 5px; border: 1px solid #aaa; }
        td { padding: 4px; border: 1px solid #ccc; vertical-align: middle; }
        .num { text-align: right !important; }
        .text-format { mso-number-format: '\@'; text-align: left; } 
    </style>
</head>
<body>

    <table width="100%">
        <tr><td colspan="15" align="center" style="font-size: 16pt; font-weight: bold; color: #1a73e8;">LISTA DE PRECIOS</td></tr>
        <tr><td colspan="15" align="center" style="font-size: 12pt; font-weight: bold;"><?php echo mb_strtoupper($_POST["NameCompany"]); ?></td></tr>
        <tr>
            <td colspan="15" align="center">
                <b>Fecha:</b> <?php echo $_POST["FechaHastalista"]; ?> | 
                <b>Orden:</b> <?php echo $_POST["OrdenLP"]; ?> | 
                <b>Tasa:</b> <?php echo number_format($tasa, 2) . " " . $moneda; ?>
            </td>
        </tr>
        <tr><td colspan="15"></td></tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>S.K.U</th>
                <th>Descripción</th>
                <?php if (($_POST["MostrarMarcas"] ?? '') === "on") { echo '<th>Marca</th>'; } ?>
                <?php if (($_POST["MostrarFamilias"] ?? '') === "on") { echo '<th>Familia</th>'; } ?>
                <?php if (($_POST["Existencia"] ?? '') == "on") { echo '<th>Existencia</th><th>Desglose</th>'; } ?>
                <?php if (($_POST["costozzzv"] ?? '') == "on") { echo '<th>'.(trim($LitCosto) !== "" ? $LitCosto : "Costo").'</th>'; } ?>
                <?php if (($_POST["precioz"] ?? '') == "on") { echo '<th>'.(trim($LitP01) !== "" ? $LitP01 : "Precio 1").'</th>'; } ?>
                <?php if (($_POST["precio2z"] ?? '') == "on") { echo '<th>'.(trim($LitP02) !== "" ? $LitP02 : "Precio 2").'</th>'; } ?>
                <?php if (($_POST["precio3z"] ?? '') == "on") { echo '<th>'.(trim($LitP03) !== "" ? $LitP03 : "Precio 3").'</th>'; } ?>
                <?php if (($_POST["precio4z"] ?? '') == "on") { echo '<th>'.(trim($LitP04) !== "" ? $LitP04 : "Precio 4").'</th>'; } ?>
                <?php if (($_POST["precio5z"] ?? '') == "on") { echo '<th>'.(trim($LitP05) !== "" ? $LitP05 : "Precio 5").'</th>'; } ?>
                <?php if (($_POST["precio6z"] ?? '') == "on") { echo '<th>'.(trim($LitP06) !== "" ? $LitP06 : "Precio 6").'</th>'; } ?>
                <?php if (($_POST["precio7z"] ?? '') == "on") { echo '<th>'.(trim($LitP07) !== "" ? $LitP07 : "Precio 7").'</th>'; } ?>
                <?php if (($_POST["precio8z"] ?? '') == "on") { echo '<th>'.(trim($LitP08) !== "" ? $LitP08 : "Precio 8").'</th>'; } ?>
                <?php if (($_POST["precio9z"] ?? '') == "on") { echo '<th>'.(trim($LitP09) !== "" ? $LitP09 : "Precio 9").'</th>'; } ?>
                <?php if (($_POST["precio10z"] ?? '') == "on") { echo '<th>'.(trim($LitP10) !== "" ? $LitP10 : "Precio 10").'</th>'; } ?>
                <?php if (($_POST["cimp"] ?? '') == "on") { echo '<th>%Imp</th>'; } ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $existenciaX = 0;
            $CostoXexistT = 0;
            $precioT = 0; $precioT2 = 0; $precioT3 = 0; $precioT4 = 0; $precioT5 = 0;
            $precioT6 = 0; $precioT7 = 0; $precioT8 = 0; $precioT9 = 0; $precioT10 = 0;

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    
                    // Cálculos de Totales
                    $existenciaX += $row["Existencia"];
                    $CostoXexistT += ($row["costo"] * $row["Existencia"]);
                    $precioT += ($row["PrecioNeto"] * $row["Existencia"]);
                    $precioT2 += ($row["PrecioNeto2"] * $row["Existencia"]);
                    $precioT3 += ($row["PrecioNeto3"] * $row["Existencia"]);
                    $precioT4 += ($row["PrecioNeto4"] * $row["Existencia"]);
                    $precioT5 += ($row["PrecioNeto5"] * $row["Existencia"]);
                    $precioT6 += ($row["PrecioNeto6"] * $row["Existencia"]);
                    $precioT7 += ($row["PrecioNeto7"] * $row["Existencia"]);
                    $precioT8 += ($row["PrecioNeto8"] * $row["Existencia"]);
                    $precioT9 += ($row["PrecioNeto9"] * $row["Existencia"]);
                    $precioT10 += ($row["PrecioNeto10"] * $row["Existencia"]);
            ?>
            <tr>
                <td class="text-format"><?php echo (trim($row['CodIdAmpliado']) === "" ? "-" : trim($row['CodIdAmpliado'])); ?></td>
                <td><?php echo (trim($row['Descripcion']) === "" ? "-" : mb_strtoupper(trim($row['Descripcion']))); ?></td>
                
                <?php if (($_POST["MostrarMarcas"] ?? '') === "on") { echo '<td>'.(trim($row['Marca']) == "" ? "-" : trim($row['Marca'])).'</td>'; } ?>
                <?php if (($_POST["MostrarFamilias"] ?? '') === "on") { echo '<td>'.(trim($row['Familia']) == "" ? "-" : trim($row['Familia'])).'</td>'; } ?>
                
                <?php if (($_POST["Existencia"] ?? '') == "on") { ?>
                    <td class="num"><?php echo ($row['Existencia'] == "" ? "-" : ($row["factorunit"] <> 1 && $row["factorunit"] <> 0 ? " " . $row["factorunit"] . " x " . number_format($row["Existencia"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " = " . number_format($row["Existencia"] * $row["factorunit"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $row["Medida"] : number_format($row['Existencia'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]))); ?></td>
                    <td class="num">
                        <?php 
                        $txtDesglose = "";
                        if ($row['cuniP1d'] <> 0) {
                            $txtDesglose .= number_format($row['cuniP1d'], 0, $_POST["SimDec"], $_POST["SimMil"]) . ($row['uniP1d'] == "" ? "" : ' ('.substr($row['uniP1d'], 0, 3).')');
                        }
                        if ($row['cuniP2d'] <> 0 and $row['cuniP1d'] <> 0) { $txtDesglose .= ' y '; }
                        if ($row['cuniP2d'] <> 0) {
                            $txtDesglose .= number_format($row['cuniP2d'], 0, $_POST["SimDec"], $_POST["SimMil"]) . ($row['uniP2d'] == "" ? "" : ' ('.substr($row['uniP2d'], 0, 3).')');
                        }
                        echo $txtDesglose;
                        ?>
                    </td>
                <?php } ?>

                <?php if (($_POST["costozzzv"] ?? '') == "on") { echo '<td class="num">'.(trim($row['costo']) == "" ? "-" : number_format($row['costo'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])).'</td>'; } ?>
                <?php if (($_POST["precioz"] ?? '') == "on") { echo '<td class="num">'.(trim($row['PrecioNeto']) == "" ? "-" : number_format($row['PrecioNeto'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])).'</td>'; } ?>
                <?php if (($_POST["precio2z"] ?? '') == "on") { echo '<td class="num">'.(trim($row['PrecioNeto2']) == "" ? "-" : number_format($row['PrecioNeto2'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ($row['CantP1']>1 ? ' / ' . number_format(trim($row['PrecioNeto2']) / $row['CantP1'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '')).'</td>'; } ?>
                <?php if (($_POST["precio3z"] ?? '') == "on") { echo '<td class="num">'.(trim($row['PrecioNeto3']) == "" ? "-" : number_format($row['PrecioNeto3'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ($row['CantP2']>1 ? ' / ' . number_format(trim($row['PrecioNeto3']) / $row['CantP2'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '')).'</td>'; } ?>
                <?php if (($_POST["precio4z"] ?? '') == "on") { echo '<td class="num">'.(trim($row['PrecioNeto4']) == "" ? "-" : number_format($row['PrecioNeto4'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ($row['CantP4']>1 ? ' / ' . number_format(trim($row['PrecioNeto4']) / $row['CantP4'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '')).'</td>'; } ?>
                <?php if (($_POST["precio5z"] ?? '') == "on") { echo '<td class="num">'.(trim($row['PrecioNeto5']) == "" ? "-" : number_format($row['PrecioNeto5'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ($row['CantP5']>1 ? ' / ' . number_format(trim($row['PrecioNeto5']) / $row['CantP5'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '')).'</td>'; } ?>
                <?php if (($_POST["precio6z"] ?? '') == "on") { echo '<td class="num">'.(trim($row['PrecioNeto6']) == "" ? "-" : number_format($row['PrecioNeto6'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ($row['CantP6']>1 ? ' / ' . number_format(trim($row['PrecioNeto6']) / $row['CantP6'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '')).'</td>'; } ?>
                <?php if (($_POST["precio7z"] ?? '') == "on") { echo '<td class="num">'.(trim($row['PrecioNeto7']) == "" ? "-" : number_format($row['PrecioNeto7'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ($row['CantP7']>1 ? ' / ' . number_format(trim($row['PrecioNeto7']) / $row['CantP7'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '')).'</td>'; } ?>
                <?php if (($_POST["precio8z"] ?? '') == "on") { echo '<td class="num">'.(trim($row['PrecioNeto8']) == "" ? "-" : number_format($row['PrecioNeto8'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ($row['CantP8']>1 ? ' / ' . number_format(trim($row['PrecioNeto8']) / $row['CantP8'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '')).'</td>'; } ?>
                <?php if (($_POST["precio9z"] ?? '') == "on") { echo '<td class="num">'.(trim($row['PrecioNeto9']) == "" ? "-" : number_format($row['PrecioNeto9'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ($row['CantP9']>1 ? ' / ' . number_format(trim($row['PrecioNeto9']) / $row['CantP9'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '')).'</td>'; } ?>
                <?php if (($_POST["precio10z"] ?? '') == "on") { echo '<td class="num">'.(trim($row['PrecioNeto10']) == "" ? "-" : number_format($row['PrecioNeto10'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ($row['CantP10']>1 ? ' / ' . number_format(trim($row['PrecioNeto10']) / $row['CantP10'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '')).'</td>'; } ?>
                <?php if (($_POST["cimp"] ?? '') == "on") { echo '<td class="num">'.(trim($row['ValorImpuesto']) == "" ? "-" : trim($row['ValorImpuesto'])).'</td>'; } ?>
            </tr>
            <?php
                }
            }
            ?>
            
            <?php if ($_POST["precioz"] == "on" or $_POST["precio2z"] == "on" or $_POST["precio3z"] == "on" or $_POST["precio4z"] == "on" or $_POST["precio5z"] == "on"  or $_POST["precio6z"] == "on" or $_POST["precio7z"] == "on" or $_POST["precio8z"] == "on" or $_POST["precio9z"] == "on" or $_POST["precio10z"] == "on" or $_POST["Existencia"] == "on") { ?>
            <tr style="background-color: #e0e0e0; font-weight: bold;">
                <td colspan="2" align="right">TOTALES:</td>
                <?php if (($_POST["MostrarMarcas"] ?? '') === "on") echo "<td></td>"; ?>
                <?php if (($_POST["MostrarFamilias"] ?? '') === "on") echo "<td></td>"; ?>
                
                <?php if ($_POST["Existencia"] == "on") { ?>
                    <td class="num"><?php echo number_format($existenciaX, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></td>
                    <td></td>
                <?php } ?>
                
                <?php if ($_POST["costozzzv"] == "on") { ?>
                    <td class="num"><?php echo number_format($CostoXexistT, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></td>
                <?php } ?>
                <?php if ($_POST["precioz"] == "on") { ?>
                    <td class="num"><?php echo number_format($precioT, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></td>
                <?php } ?>
                <?php if ($_POST["precio2z"] == "on") { ?>
                    <td class="num"><?php echo number_format($precioT2, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></td>
                <?php } ?>
                <?php if ($_POST["precio3z"] == "on") { ?>
                    <td class="num"><?php echo number_format($precioT3, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></td>
                <?php } ?>
                <?php if ($_POST["precio4z"] == "on") { ?>
                    <td class="num"><?php echo number_format($precioT4, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></td>
                <?php } ?>
                <?php if ($_POST["precio5z"] == "on") { ?>
                    <td class="num"><?php echo number_format($precioT5, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></td>
                <?php } ?>
                <?php if ($_POST["precio6z"] == "on") { ?>
                    <td class="num"><?php echo number_format($precioT6, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></td>
                <?php } ?>
                <?php if ($_POST["precio7z"] == "on") { ?>
                    <td class="num"><?php echo number_format($precioT7, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></td>
                <?php } ?>
                <?php if ($_POST["precio8z"] == "on") { ?>
                    <td class="num"><?php echo number_format($precioT8, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></td>
                <?php } ?>
                <?php if ($_POST["precio9z"] == "on") { ?>
                    <td class="num"><?php echo number_format($precioT9, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></td>
                <?php } ?>
                <?php if ($_POST["precio10z"] == "on") { ?>
                    <td class="num"><?php echo number_format($precioT10, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></td>
                <?php } ?>
                <?php if ($_POST["cimp"] == "on") echo "<td></td>"; ?>
            </tr>
            <?php } ?>

        </tbody>
    </table>
</body>
</html>
<?php
}
exit;
?>