<?php
// 1. CONFIGURACIÓN DE ALTO RENDIMIENTO
ini_set('memory_limit', '2048M');
ini_set('max_execution_time', '1800');
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', 0);

session_start();
require_once __DIR__ . '/vendor/autoload.php';
require_once 'ambiente.php'; 

use Mpdf\Mpdf;

if (function_exists('conectar')) { $conn = conectar(); } 
elseif (function_exists('ConectarConsultas')) { $conn = ConectarConsultas(); } 
else { die("Error Crítico: No hay conexión a la base de datos."); }

// 2. RECEPCIÓN DE DATOS Y CONFIGURACIÓN ORIGINAL
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

if (isset($_POST["costozzzv"]) && $_POST["costozzzv"] == "on") { $n++; $Having[] = "costo > 0"; }
if (isset($_POST["precioz"]) && $_POST["precioz"] == "on") { $n++; $Having[] = "PrecioNeto > 0"; }
if (isset($_POST["precio2z"]) && $_POST["precio2z"] == "on") { $n++; $Having[] = "PrecioNeto2 > 0"; }
if (isset($_POST["precio3z"]) && $_POST["precio3z"] == "on") { $n++; $Having[] = "PrecioNeto3 > 0"; }
if (isset($_POST["precio4z"]) && $_POST["precio4z"] == "on") { $n++; $Having[] = "PrecioNeto4 > 0"; }
if (isset($_POST["precio5z"]) && $_POST["precio5z"] == "on") { $n++; $Having[] = "PrecioNeto5 > 0"; }
if (isset($_POST["precio6z"]) && $_POST["precio6z"] == "on") { $n++; $Having[] = "PrecioNeto6 > 0"; }
if (isset($_POST["precio7z"]) && $_POST["precio7z"] == "on") { $n++; $Having[] = "PrecioNeto7 > 0"; }
if (isset($_POST["precio8z"]) && $_POST["precio8z"] == "on") { $n++; $Having[] = "PrecioNeto8 > 0"; }
if (isset($_POST["precio9z"]) && $_POST["precio9z"] == "on") { $n++; $Having[] = "PrecioNeto9 > 0"; }
if (isset($_POST["precio10z"]) && $_POST["precio10z"] == "on") { $n++; $Having[] = "PrecioNeto10 > 0"; }

// SOLUCIÓN AL ERROR 500 Y PANTALLA CONGELADA
if ($n == 0) {
    echo "<script>
        alert('Seleccione al menos un precio a reflejar.');
        window.history.back();
        setTimeout(function() { window.close(); }, 100);
    </script>";
    exit;
}

$calc = $calcTotal / $n;
$limit = "";

// ==== INICIAMOS LA CAPTURA DE HTML PARA EL PDF ====
ob_start();
?>

<style>
    body { font-family: Arial, sans-serif; color: #333; margin: 0; padding: 0; font-size: 9pt; }
    h2 { font-size: 12pt; color: #1a73e8; margin: 15px 0 5px; text-transform: uppercase; border-bottom: 2px solid #1a73e8; padding-bottom: 3px; }
    h3 { font-size: 10pt; color: #1a73e8; margin: 10px 0 5px; padding: 0 4px; text-transform: uppercase; border-bottom: 1px solid #1a73e8; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
    thead th { background-color: #1a73e8; color: white; padding: 5px; text-align: left; font-weight: bold; border: 1px solid #1a73e8; }
    td { padding: 4px; border: 1px solid #ddd; text-align: left; }
    tbody tr:nth-child(even) { background-color: #f9f9f9; }
</style>

<?php
if ($_POST["Agrupar"] == "empty") {
?>
    <table>
        <thead>
            <tr>
                <th><?php echo lang("Descripción"); ?></th>
                <?php if (($_POST["MostrarMarcas"] ?? '') === "on") { echo '<th>'.lang("Marca").'</th>'; } ?>
                <?php if (($_POST["MostrarFamilias"] ?? '') === "on") { echo '<th>'.lang("Familia").'</th>'; } ?>
                <?php if (($_POST["Existencia"] ?? '') == "on") { echo '<th>'.lang("Existencia").'</th><th>'.lang("Desglose").'</th>'; } ?>
                <?php if (($_POST["costozzzv"] ?? '') == "on") { echo '<th>'.(trim($LitCosto) !== "" ? $LitCosto : lang("Costo")).'</th>'; } ?>
                <?php if (($_POST["precioz"] ?? '') == "on") { echo '<th>'.(trim($LitP01) !== "" ? $LitP01 : lang("Precio") . " 1").'</th>'; } ?>
                <?php if (($_POST["precio2z"] ?? '') == "on") { echo '<th>'.(trim($LitP02) !== "" ? $LitP02 : lang("Precio") . " 2").'</th>'; } ?>
                <?php if (($_POST["precio3z"] ?? '') == "on") { echo '<th>'.(trim($LitP03) !== "" ? $LitP03 : lang("Precio") . " 3").'</th>'; } ?>
                <?php if (($_POST["precio4z"] ?? '') == "on") { echo '<th>'.(trim($LitP04) !== "" ? $LitP04 : lang("Precio") . " 4").'</th>'; } ?>
                <?php if (($_POST["precio5z"] ?? '') == "on") { echo '<th>'.(trim($LitP05) !== "" ? $LitP05 : lang("Precio") . " 5").'</th>'; } ?>
                <?php if (($_POST["precio6z"] ?? '') == "on") { echo '<th>'.(trim($LitP06) !== "" ? $LitP06 : lang("Precio") . " 6").'</th>'; } ?>
                <?php if (($_POST["precio7z"] ?? '') == "on") { echo '<th>'.(trim($LitP07) !== "" ? $LitP07 : lang("Precio") . " 7").'</th>'; } ?>
                <?php if (($_POST["precio8z"] ?? '') == "on") { echo '<th>'.(trim($LitP08) !== "" ? $LitP08 : lang("Precio") . " 8").'</th>'; } ?>
                <?php if (($_POST["precio9z"] ?? '') == "on") { echo '<th>'.(trim($LitP09) !== "" ? $LitP09 : lang("Precio") . " 9").'</th>'; } ?>
                <?php if (($_POST["precio10z"] ?? '') == "on") { echo '<th>'.(trim($LitP10) !== "" ? $LitP10 : lang("Precio") . " 10").'</th>'; } ?>
                <?php if (($_POST["cimp"] ?? '') == "on") { echo '<th>%'.lang("Imp").'</th>'; } ?>
            </tr>
        </thead>
        <tbody>
<?php
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
        if (isset($_POST["EnvioEstado"]) && $_POST["EnvioEstado"] !== "*") { 
            $buscar .= "and a.Estado = " . $_POST["EnvioEstado"]; 
        }
        
        $ExistenciaCero = "";
        if (!isset($_POST["ExistenciaCero"]) || $_POST["ExistenciaCero"] !== "on") { 
            $ExistenciaCero = " and coalesce(round(b.cantidad,3),0)<>0"; 
        }
        
        $referencia = "";
        if (!empty($_POST["RefLP1"])) { 
            $referencia = "and a.CodBarra='" . $_POST["RefLP1"] . "'"; 
        }
        
        $existencia = "1 as Existencia,";
        if (isset($_POST["Existencia"]) && $_POST["Existencia"] == "on") { 
            $existencia = "round(coalesce(b.cantidad,0),2) as Existencia,  "; 
        }

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

        if ($result = mysqli_query($conn, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
?>
                <tr>
                    <td><?php echo (trim($row['Descripcion']) === "" ? "-" : trim($row['Descripcion'])); ?></td>
                    <?php if (($_POST["MostrarMarcas"] ?? '') === "on") { echo '<td>'.(trim($row['Marca']) == "" ? "-" : trim($row['Marca'])).'</td>'; } ?>
                    <?php if (($_POST["MostrarFamilias"] ?? '') === "on") { echo '<td>'.(trim($row['Familia']) == "" ? "-" : trim($row['Familia'])).'</td>'; } ?>
                    
                    <?php if (($_POST["Existencia"] ?? '') == "on") { ?>
                        <td><?php echo ($row['Existencia'] == "" ? "-" : ($row["factorunit"] <> 1 && $row["factorunit"] <> 0 ? " " . $row["factorunit"] . " x " . number_format($row["Existencia"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " = " . number_format($row["Existencia"] * $row["factorunit"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $row["Medida"] : number_format($row['Existencia'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]))); ?></td>
                        <td>
                            <?php 
                            if ($row['cuniP1d'] <> 0) {
                                echo number_format($row['cuniP1d'], 0, $_POST["SimDec"], $_POST["SimMil"]) . ($row['uniP1d'] == "" ? "" : ' ('.substr($row['uniP1d'], 0, 3).')');
                            }
                            if ($row['cuniP2d'] <> 0 and $row['cuniP1d'] <> 0) { echo ' y '; }
                            if ($row['cuniP2d'] <> 0) {
                                echo number_format($row['cuniP2d'], 0, $_POST["SimDec"], $_POST["SimMil"]) . ($row['uniP2d'] == "" ? "" : ' ('.substr($row['uniP2d'], 0, 3).')');
                            }
                            ?>
                        </td>
                    <?php } ?>
                    
                    <?php if (($_POST["costozzzv"] ?? '') == "on") { echo '<td>'.(trim($row['costo']) == "" ? "-" : number_format($row['costo'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda).'</td>'; } ?>
                    <?php if (($_POST["precioz"] ?? '') == "on") { echo '<td>'.(trim($row['PrecioNeto']) == "" ? "-" : number_format($row['PrecioNeto'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda).'</td>'; } ?>
                    <?php if (($_POST["precio2z"] ?? '') == "on") { echo '<td>'.(trim($row['PrecioNeto2']) == "" ? "-" : number_format($row['PrecioNeto2'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . ($row['CantP1']>1 ? ' / ' . number_format(trim($row['PrecioNeto2']) / $row['CantP1'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '')).'</td>'; } ?>
                    <?php if (($_POST["precio3z"] ?? '') == "on") { echo '<td>'.(trim($row['PrecioNeto3']) == "" ? "-" : number_format($row['PrecioNeto3'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . ($row['CantP2']>1 ? ' / ' . number_format(trim($row['PrecioNeto3']) / $row['CantP2'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '')).'</td>'; } ?>
                    <?php if (($_POST["precio4z"] ?? '') == "on") { echo '<td>'.(trim($row['PrecioNeto4']) == "" ? "-" : number_format($row['PrecioNeto4'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . ($row['CantP4']>1 ? ' / ' . number_format(trim($row['PrecioNeto4']) / $row['CantP4'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '')).'</td>'; } ?>
                    <?php if (($_POST["precio5z"] ?? '') == "on") { echo '<td>'.(trim($row['PrecioNeto5']) == "" ? "-" : number_format($row['PrecioNeto5'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . ($row['CantP5']>1 ? ' / ' . number_format(trim($row['PrecioNeto5']) / $row['CantP5'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '')).'</td>'; } ?>
                    <?php if (($_POST["precio6z"] ?? '') == "on") { echo '<td>'.(trim($row['PrecioNeto6']) == "" ? "-" : number_format($row['PrecioNeto6'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . ($row['CantP6']>1 ? ' / ' . number_format(trim($row['PrecioNeto6']) / $row['CantP6'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '')).'</td>'; } ?>
                    <?php if (($_POST["precio7z"] ?? '') == "on") { echo '<td>'.(trim($row['PrecioNeto7']) == "" ? "-" : number_format($row['PrecioNeto7'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . ($row['CantP7']>1 ? ' / ' . number_format(trim($row['PrecioNeto7']) / $row['CantP7'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '')).'</td>'; } ?>
                    <?php if (($_POST["precio8z"] ?? '') == "on") { echo '<td>'.(trim($row['PrecioNeto8']) == "" ? "-" : number_format($row['PrecioNeto8'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . ($row['CantP8']>1 ? ' / ' . number_format(trim($row['PrecioNeto8']) / $row['CantP8'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '')).'</td>'; } ?>
                    <?php // LA LÍNEA DEL ERROR DE TIPEO HA SIDO CORREGIDA AQUÍ ?>
                    <?php if (($_POST["precio9z"] ?? '') == "on") { echo '<td>'.(trim($row['PrecioNeto9']) == "" ? "-" : number_format($row['PrecioNeto9'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . ($row['CantP9']>1 ? ' / ' . number_format(trim($row['PrecioNeto9']) / $row['CantP9'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '')).'</td>'; } ?>
                    <?php if (($_POST["precio10z"] ?? '') == "on") { echo '<td>'.(trim($row['PrecioNeto10']) == "" ? "-" : number_format($row['PrecioNeto10'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . ($row['CantP10']>1 ? ' / ' . number_format(trim($row['PrecioNeto10']) / $row['CantP10'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '')).'</td>'; } ?>
                    <?php if (($_POST["cimp"] ?? '') == "on") { echo '<td>'.(trim($row['ValorImpuesto']) == "" ? "-" : trim($row['ValorImpuesto'])).'</td>'; } ?>
                </tr>
<?php
            }
            mysqli_free_result($result);
        }
?>
        </tbody>
    </table>
<?php
} else if ($_POST["Agrupar"] == "Marcazp" || $_POST["Agrupar"] == "Familiazp" || $_POST["Agrupar"] == "FamiliaMarca") {

    $Orden = "order by a.Descripcion";
    if ($_POST["Agrupar"] == "Marcazp") { $Orden = "order by d.nombre, a.Descripcion"; }
    if ($_POST["Agrupar"] == "Familiazp") { $Orden = "order by e.ITEM, a.Descripcion"; }
    if ($_POST["Agrupar"] == "FamiliaMarca") { $Orden = "order by e.ITEM, d.nombre, a.Descripcion"; }

    $familia = "";
    if (!empty($_POST["mIdfamilia"])) {
        $familia = " and a.Idfamilia " . (($_POST["NotIncludeFamilia"] ?? '') === "on" ? "not" : "") . " in ('" . implode("','", $_POST["mIdfamilia"]) . "') ";
    }
    $beetween = "";
    if (!empty($_POST["mIdProductos"])) {
        $beetween = " and a.CodIdBasico " . (($_POST["NotIncludeProductos"] ?? '') === "on" ? "not" : "") . " in ('" . implode("','", $_POST["mIdProductos"]) . "') ";
    }
    $Deposito4 = "";
    $almacenes = [];
    if (!empty($_POST["mIdAlmacen"])) {
        $Deposito4 = " and a.IdAlm " . (($_POST["NotIncludeAlmacen"] ?? '') === "on" ? "not" : "") . " in ('" . implode("','", $_POST["mIdAlmacen"]) . "') ";
        $almacenes = $_POST["mIdAlmacen"];
    }
    $Marca = "";
    if (!empty($_POST["mIdMarca"])) {
        $Marca = "and a.Marca " . (($_POST["NotIncludeMarca"] ?? '') === "on" ? "not" : "") . " in ('" . implode("','", $_POST["mIdMarca"]) . "')";
    }

    $buscar = "";
    if (isset($_POST["EnvioEstado"]) && $_POST["EnvioEstado"] !== "*") { 
        $buscar .= "and a.Estado = " . $_POST["EnvioEstado"]; 
    }
    
    $ExistenciaCero = "";
    if (!isset($_POST["ExistenciaCero"]) || $_POST["ExistenciaCero"] !== "on") { 
        $ExistenciaCero = " and coalesce(round(b.cantidad,3),0)<>0"; 
    }
    
    $referencia = "";
    if (!empty($_POST["RefLP1"])) { 
        $referencia = "and a.CodBarra='" . $_POST["RefLP1"] . "'"; 
    }
    
    $existencia = "1 as Existencia,";
    if (isset($_POST["Existencia"]) && $_POST["Existencia"] == "on") { 
        $existencia = "round(coalesce(b.cantidad,0),2) as Existencia,  "; 
    }

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

    $joinExist = " left join inv_existencias h on h.IdCompany = a.IdCompany and h.CodIdBasico = a.CodIdBasico ";
    
    $query = "SELECT DISTINCT a.CodIdAmpliado,a.CodIdBasico,a.CodBarra, a.Descripcion ,a.Envase,e.ITEM as Familia,a.factorunit,a.Medida,
        d.nombre as Marca, a.Medida as Unidades,
        a.medida as uniP1,truncate(b.cantidad,0) as cuniP1d,a.medida as uniP1d,
        round(a.CantP1 * (b.cantidad-truncate(b.cantidad,0)),0) as cuniP2d,a.UnidadP1 as uniP2d,a.CantP1, 
        " . $existencia . $costo . $price1 . $price2 . $price3 . $price4 . $price5 . $price6 . $price7 . $price8 . $price9 . $price10 . "
        coalesce(f.VALOR*100,0) as ValorImpuesto
        FROM PosUpProducto a
        " . ($_POST["Agrupar"] === "FamiliaMarca" ? $joinExist : "") . "
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
        " . $Orden;

    if ($_POST["Agrupar"] === "FamiliaMarca") {
        
        $ExistenciaCeroFM = "";
        if (empty($_POST["ExistenciaCero"]) || $_POST["ExistenciaCero"] !== "on") {
            $ExistenciaCeroFM = " HAVING coalesce(round(sum(h.Cantidad),3), 0) <> 0 ";
        }

        $joinExist = " left join inv_existencias h on h.IdCompany = a.IdCompany and h.CodIdBasico = a.CodIdBasico " . (!empty($almacenes) ? " and h.IdAlm in (" . implode(",", $almacenes) . ")" : "");
        
        $query = "SELECT a.CodIdAmpliado,a.CodIdBasico,a.CodBarra, a.Descripcion ,a.Envase,e.ITEM as Familia,b.Nombre as Marca, a.CodBarra,
            " . $costo . "
            " . $price1 . "
            " . $price2 . "
            " . $price3 . "
            " . $price4 . "
            " . $price5 . "
            " . $price6 . "
            " . $price7 . "
            " . $price8 . "
            " . $price9 . "
            " . $price10 . "
            a.CantP1,sum(h.Cantidad) as Cantidad,
            sum(h.Cantidad) as Existencia,
            truncate(sum(h.Cantidad),0) as cuniP1d,
            a.medida as uniP1d,
            round(a.CantP1 * (sum(h.Cantidad)-truncate(sum(h.Cantidad),0)),0) as cuniP2d,
            a.UnidadP1 as uniP2d,
            coalesce(f.VALOR*100,0) as ValorImpuesto
            FROM PosUpProducto a
            " . $joinExist . "
            left join PosUpc_marcas b on a.IdCompany = b.IdCompany and a.Marca = b.idmarca 
            left join PosUpvarios e on a.IdCompany=e.IdCompany and a.Idfamilia=e.IdVarios and e.TIPOITEM= 2
            left join PosUpvarios f on a.IdCompany=f.IdCompany and a.Impuesto=f.IdVarios and f.TIPOITEM= 0
            where a.IdCompany= " . $_POST["CompanyActual"] . " 
            and a.EsCompuesto in (20,1,0) 
            " . $beetween . " 
            " . $buscar . "
        group by a.CodIdBasico
        " . $ExistenciaCeroFM . "
        " . $Orden;
    }

    $m = 0;
    $last_group = null;
    $table_open = false;

    if ($result = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($result)) {
            
            $current_group = "";
            if ($_POST["Agrupar"] == "Marcazp") $current_group = trim($row['Marca']);
            if ($_POST["Agrupar"] == "Familiazp") $current_group = trim($row['Familia']);
            if ($_POST["Agrupar"] == "FamiliaMarca") $current_group = trim($row['Familia']) . " - " . trim($row['Marca']);

            if ($current_group !== $last_group) {
                if ($table_open) { echo '</tbody></table>'; }
                echo '<div><h2><strong>' . ($current_group ?: 'Sin Categoría') . '</strong></h2></div>';
                ?>
                <table>
                    <thead>
                        <tr>
                            <th><?php echo lang("Descripción"); ?></th>
                            <?php if (($_POST["MostrarMarcas"] ?? '') === "on" && $_POST["Agrupar"] != "Marcazp") { echo '<th>'.lang("Marca").'</th>'; } ?>
                            <?php if (($_POST["MostrarFamilias"] ?? '') === "on" && $_POST["Agrupar"] != "Familiazp") { echo '<th>'.lang("Familia").'</th>'; } ?>
                            <?php if (($_POST["Existencia"] ?? '') == "on") { echo '<th>'.lang("Existencia").'</th><th>'.lang("Desglose").'</th>'; } ?>
                            <?php if (($_POST["costozzzv"] ?? '') == "on") { echo '<th>'.(trim($LitCosto) !== "" ? $LitCosto : lang("Costo")).'</th>'; } ?>
                            <?php if (($_POST["precioz"] ?? '') == "on") { echo '<th>'.(trim($LitP01) !== "" ? $LitP01 : lang("Precio") . " 1").'</th>'; } ?>
                            <?php if (($_POST["precio2z"] ?? '') == "on") { echo '<th>'.(trim($LitP02) !== "" ? $LitP02 : lang("Precio") . " 2").'</th>'; } ?>
                            <?php if (($_POST["precio3z"] ?? '') == "on") { echo '<th>'.(trim($LitP03) !== "" ? $LitP03 : lang("Precio") . " 3").'</th>'; } ?>
                            <?php if (($_POST["precio4z"] ?? '') == "on") { echo '<th>'.(trim($LitP04) !== "" ? $LitP04 : lang("Precio") . " 4").'</th>'; } ?>
                            <?php if (($_POST["precio5z"] ?? '') == "on") { echo '<th>'.(trim($LitP05) !== "" ? $LitP05 : lang("Precio") . " 5").'</th>'; } ?>
                            <?php if (($_POST["precio6z"] ?? '') == "on") { echo '<th>'.(trim($LitP06) !== "" ? $LitP06 : lang("Precio") . " 6").'</th>'; } ?>
                            <?php if (($_POST["precio7z"] ?? '') == "on") { echo '<th>'.(trim($LitP07) !== "" ? $LitP07 : lang("Precio") . " 7").'</th>'; } ?>
                            <?php if (($_POST["precio8z"] ?? '') == "on") { echo '<th>'.(trim($LitP08) !== "" ? $LitP08 : lang("Precio") . " 8").'</th>'; } ?>
                            <?php if (($_POST["precio9z"] ?? '') == "on") { echo '<th>'.(trim($LitP09) !== "" ? $LitP09 : lang("Precio") . " 9").'</th>'; } ?>
                            <?php if (($_POST["precio10z"] ?? '') == "on") { echo '<th>'.(trim($LitP10) !== "" ? $LitP10 : lang("Precio") . " 10").'</th>'; } ?>
                            <?php if (($_POST["cimp"] ?? '') == "on") { echo '<th>%'.lang("Imp").'</th>'; } ?>
                        </tr>
                    </thead>
                    <tbody>
                <?php
                $table_open = true;
                $last_group = $current_group;
            }
            ?>
            <tr>
                <td><?php echo (trim($row['Descripcion']) === "" ? "-" : trim($row['Descripcion'])); ?></td>
                <?php if (($_POST["MostrarMarcas"] ?? '') === "on" && $_POST["Agrupar"] != "Marcazp") { echo '<td>'.(trim($row['Marca']) == "" ? "-" : trim($row['Marca'])).'</td>'; } ?>
                <?php if (($_POST["MostrarFamilias"] ?? '') === "on" && $_POST["Agrupar"] != "Familiazp") { echo '<td>'.(trim($row['Familia']) == "" ? "-" : trim($row['Familia'])).'</td>'; } ?>
                
                <?php if (($_POST["Existencia"] ?? '') == "on") { ?>
                    <td><?php echo ($row['Existencia'] == "" ? "-" : ($row["factorunit"] <> 1 && $row["factorunit"] <> 0 ? " " . $row["factorunit"] . " x " . number_format($row["Existencia"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " = " . number_format($row["Existencia"] * $row["factorunit"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $row["Medida"] : number_format($row['Existencia'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]))); ?></td>
                    <td>
                        <?php 
                        if ($row['cuniP1d'] <> 0) {
                            echo number_format($row['cuniP1d'], 0, $_POST["SimDec"], $_POST["SimMil"]) . ($row['uniP1d'] == "" ? "" : ' ('.substr($row['uniP1d'], 0, 3).')');
                        }
                        if ($row['cuniP2d'] <> 0 and $row['cuniP1d'] <> 0) { echo ' y '; }
                        if ($row['cuniP2d'] <> 0) {
                            echo number_format($row['cuniP2d'], 0, $_POST["SimDec"], $_POST["SimMil"]) . ($row['uniP2d'] == "" ? "" : ' ('.substr($row['uniP2d'], 0, 3).')');
                        }
                        ?>
                    </td>
                <?php } ?>
                
                <?php if (($_POST["costozzzv"] ?? '') == "on") { echo '<td>'.(trim($row['costo']) == "" ? "-" : number_format($row['costo'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda).'</td>'; } ?>
                <?php if (($_POST["precioz"] ?? '') == "on") { echo '<td>'.(trim($row['PrecioNeto']) == "" ? "-" : number_format($row['PrecioNeto'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda).'</td>'; } ?>
                <?php if (($_POST["precio2z"] ?? '') == "on") { echo '<td>'.(trim($row['PrecioNeto2']) == "" ? "-" : number_format($row['PrecioNeto2'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . ($row['CantP1']>1 ? ' / ' . number_format(trim($row['PrecioNeto2']) / $row['CantP1'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '')).'</td>'; } ?>
                <?php if (($_POST["precio3z"] ?? '') == "on") { echo '<td>'.(trim($row['PrecioNeto3']) == "" ? "-" : number_format($row['PrecioNeto3'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . ($row['CantP2']>1 ? ' / ' . number_format(trim($row['PrecioNeto3']) / $row['CantP2'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '')).'</td>'; } ?>
                <?php if (($_POST["precio4z"] ?? '') == "on") { echo '<td>'.(trim($row['PrecioNeto4']) == "" ? "-" : number_format($row['PrecioNeto4'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . ($row['CantP4']>1 ? ' / ' . number_format(trim($row['PrecioNeto4']) / $row['CantP4'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '')).'</td>'; } ?>
                <?php if (($_POST["precio5z"] ?? '') == "on") { echo '<td>'.(trim($row['PrecioNeto5']) == "" ? "-" : number_format($row['PrecioNeto5'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . ($row['CantP5']>1 ? ' / ' . number_format(trim($row['PrecioNeto5']) / $row['CantP5'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '')).'</td>'; } ?>
                <?php if (($_POST["precio6z"] ?? '') == "on") { echo '<td>'.(trim($row['PrecioNeto6']) == "" ? "-" : number_format($row['PrecioNeto6'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . ($row['CantP6']>1 ? ' / ' . number_format(trim($row['PrecioNeto6']) / $row['CantP6'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '')).'</td>'; } ?>
                <?php if (($_POST["precio7z"] ?? '') == "on") { echo '<td>'.(trim($row['PrecioNeto7']) == "" ? "-" : number_format($row['PrecioNeto7'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . ($row['CantP7']>1 ? ' / ' . number_format(trim($row['PrecioNeto7']) / $row['CantP7'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '')).'</td>'; } ?>
                <?php if (($_POST["precio8z"] ?? '') == "on") { echo '<td>'.(trim($row['PrecioNeto8']) == "" ? "-" : number_format($row['PrecioNeto8'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . ($row['CantP8']>1 ? ' / ' . number_format(trim($row['PrecioNeto8']) / $row['CantP8'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '')).'</td>'; } ?>
                <?php if (($_POST["precio9z"] ?? '') == "on") { echo '<td>'.(trim($row['PrecioNeto9']) == "" ? "-" : number_format($row['PrecioNeto9'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . ($row['CantP9']>1 ? ' / ' . number_format(trim($row['PrecioNeto9']) / $row['CantP9'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '')).'</td>'; } ?>
                <?php if (($_POST["precio10z"] ?? '') == "on") { echo '<td>'.(trim($row['PrecioNeto10']) == "" ? "-" : number_format($row['PrecioNeto10'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . ($row['CantP10']>1 ? ' / ' . number_format(trim($row['PrecioNeto10']) / $row['CantP10'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '')).'</td>'; } ?>
                <?php if (($_POST["cimp"] ?? '') == "on") { echo '<td>'.(trim($row['ValorImpuesto']) == "" ? "-" : trim($row['ValorImpuesto'])).'</td>'; } ?>
            </tr>
<?php
        }
        if ($table_open) { echo '</tbody></table>'; }
    }
}
?>
</div>
<?php
// CAPTURA DEL CONTENIDO GENERADO (Output Buffering)
$htmlContent = ob_get_clean();

// INICIALIZACIÓN DE MPDF
$mpdf = new Mpdf([
    'mode' => 'utf-8',
    'format' => 'Letter-L', // Horizontal
    'margin_top' => 30,
    'tempDir' => __DIR__ . '/tmp'
]);

// Cabecera PDF
$src = "img/informez.png"; 
$pathEntorno = "Comercio/" . $_POST['CompanyActual'] . "/entorno";
if (is_dir($pathEntorno) && $scan = @scandir($pathEntorno)) {
    foreach($scan as $f){ if(strpos($f, "Logotipo") === 0){ $src = "$pathEntorno/$f"; break; } }
}

$nombreEmpresa = isset($_POST["NameCompany"]) ? $_POST["NameCompany"] : "";

$headerPDF = '
<table width="100%" style="border-bottom: 2px solid #333; font-family: sans-serif; padding-bottom:5px;">
    <tr>
        <td width="20%"><img src="'.$src.'" style="max-height: 50px;"></td>
        <td width="60%" align="center">
            <div style="font-size: 14pt; font-weight: bold;">' . mb_strtoupper($nombreEmpresa) . '</div>
            <div style="font-size: 10pt; font-weight: bold; color: #1a73e8;">LISTA DE PRECIOS AVANZADA</div>
            <div style="font-size: 8pt; color: #555;">Expresado en: ' . $moneda . ' (Tasa: ' . number_format($tasa, 2) . ')</div>
        </td>
        <td width="20%" align="right" style="font-size: 8pt;">
            Fecha: ' . date('d/m/Y') . '<br>
            Pág. {PAGENO}/{nbpg}
        </td>
    </tr>
</table>';

$mpdf->SetHTMLHeader($headerPDF);

// Escribir y generar PDF
$mpdf->WriteHTML($htmlContent);
$mpdf->Output('Lista_Precios_Avanzada.pdf', 'I');
?>