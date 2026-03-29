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

// INICIAMOS LA CAPTURA INVISIBLE DEL CÓDIGO HTML
ob_start();

if ($_SESSION['IdiomaActual'] == '') {
    $_SESSION['IdiomaActual'] = $_POST['IdiomaActual'];
}

// OBTENER TASAS DE CAMBIO
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

// APLICAR TASA SELECCIONADA
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

// Tasa BCV 
$BCVtasa = floatval($_POST["TasaBCV"] ?? 1);
if ($BCVtasa == 0) $BCVtasa = 1;

// SELECCIÓN DE PRECIO
$nPrecio = $_POST["SelectPrecio"] ?? ''; 
$campoPrecioBase = (($_POST['cimp'] ?? '') == 'on') ? "PrecioVenta" : "PrecioNeto";
$campoFinal = $campoPrecioBase . $nPrecio;

$formula_precio_pri = "round((coalesce(a.$campoFinal * $tasa, 0) / $BCVtasa), 2)";

$agrupar = $_POST["Agrupar"] ?? 'empty';
$order_sql = " ORDER BY a.Descripcion ASC";
$group_by_field = "";
$titulo_agrupacion = "";

if ($agrupar == "Marcazp") {
    $group_by_field = "Marca";
    $titulo_agrupacion = "AGRUPADO POR MARCA";
    $order_sql = " ORDER BY d.nombre, a.Descripcion ASC";
} elseif ($agrupar == "FamiliaMarca" || $agrupar == "Familiazp") {
    $group_by_field = "Familia";
    $titulo_agrupacion = "AGRUPADO POR FAMILIA";
    $order_sql = " ORDER BY e.ITEM, a.Descripcion ASC";
}

$where = " WHERE a.IdCompany = " . $_POST["CompanyActual"] . " AND a.EsCompuesto IN (0,1,20) ";

if (!empty($_POST["mIdfamilia"])) {
    $op = (($_POST["NotIncludeFamilia"] ?? '') === "on") ? "NOT IN" : "IN";
    $where .= " AND a.Idfamilia $op ('" . implode("','", $_POST["mIdfamilia"]) . "') ";
}
if (!empty($_POST["mIdMarca"])) {
    $op = (($_POST["NotIncludeMarca"] ?? '') === "on") ? "NOT IN" : "IN";
    $where .= " AND a.Marca $op ('" . implode("','", $_POST["mIdMarca"]) . "') ";
}
if (!empty($_POST["mIdProductos"])) {
    $op = (($_POST["NotIncludeProductos"] ?? '') === "on") ? "NOT IN" : "IN";
    $where .= " AND a.CodIdBasico $op ('" . implode("','", $_POST["mIdProductos"]) . "') ";
}
if (($_POST["EnvioEstado"] ?? '*') !== "*") {
    $where .= " AND a.Estado = " . $_POST["EnvioEstado"];
}
if (($_POST["ExistenciaCero"] ?? '') !== "on") {
    $where .= " AND (SELECT SUM(qty_on_hand) FROM inv_existencias WHERE CodIdBasico = a.CodIdBasico AND IdCompany = a.IdCompany) > 0";
}

$query = "SELECT a.CodIdAmpliado, a.Descripcion, a.CodBarra, 
          d.nombre as Marca, e.ITEM as Familia, 
          $formula_precio_pri as PrecioNetoPri
          FROM PosUpProducto a 
          LEFT JOIN PosUpc_marcas d ON a.Marca = d.idmarca AND a.IdCompany = d.IdCompany
          LEFT JOIN PosUpvarios e ON a.Idfamilia = e.IdVarios AND e.TIPOITEM = 2
          $where
          $order_sql";

$result = mysqli_query($conn, $query);

$show_pri = (($_POST["MonedaPrimeriaMostrar"] ?? '') != false);
$show_sec = (($_POST["MonedaSecundariaMostrar"] ?? '') != false);
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Tahoma, Verdana, Segoe, sans-serif; font-size: 8pt; color: #000; margin: 0; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 5px; margin-bottom:15px; }
        th { background-color: #f2f2f2; color: #000; font-weight: bold; text-align: left; padding: 4px 2px; font-size: 8pt; border-bottom: 2px solid #ccc; }
        td { padding: 4px 2px; border-bottom: 1px solid #eee; vertical-align: top; font-size: 7.5pt; }
        
        .num { text-align: right !important; }
        .grp-header { background-color: #333; color: #fff; font-weight: bold; font-size: 10pt; padding: 5px; }
    </style>
</head>
<body>
    <?php
    $last_group = null;
    $table_open = false;
    $items = 0;

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $items++;
            $current_group = ($group_by_field) ? ($row[$group_by_field] ?: 'SIN CATEGORÍA') : '';

            // Cambio de grupo
            if ($current_group !== $last_group) {
                if ($table_open) { echo '</tbody></table>'; }

                if ($current_group) {
                    echo '<table><tr><td class="grp-header">' . mb_strtoupper($current_group) . '</td></tr></table>';
                }

                echo '<table>
                        <thead>
                            <tr>
                                <th width="60%">Producto</th>
                                ' . ($show_pri ? '<th width="20%" class="num">Precio (' . $moneda . ')</th>' : '') . '
                                ' . ($show_sec ? '<th width="20%" class="num">Precio (BCV)</th>' : '') . '
                            </tr>
                        </thead>
                        <tbody>';
                
                $table_open = true;
                $last_group = $current_group;
            }

            $precio_pri = $row['PrecioNetoPri'];
            $precio_sec = $precio_pri * $BCVtasa;

            if (($_POST["redondeadoCheck"] ?? '') === "on") {
                $precio_pri = round($precio_pri);
                $precio_sec = round($precio_sec);
            }

            echo '<tr>
                    <td>' . mb_strtoupper($row['Descripcion']) . '</td>
                    ' . ($show_pri ? '<td class="num">' . number_format($precio_pri, 2) . '</td>' : '') . '
                    ' . ($show_sec ? '<td class="num">' . number_format($precio_sec, 2) . '</td>' : '') . '
                  </tr>';
        }
        if ($table_open) { echo '</tbody></table>'; }
    } else {
        echo '<div style="text-align:center; padding:20px; color:red; font-weight:bold;">No se encontraron productos.</div>';
    }
    ?>
</body>
</html>
<?php
// =========================================================================
// TERMINA LA EJECUCIÓN Y GENERAMOS EL PDF CON MPDF (2 COLUMNAS)
// =========================================================================
$html = ob_get_clean();

$mpdf = new Mpdf([
    'mode' => 'utf-8',
    'format' => 'Letter', // Vertical porque usaremos 2 columnas
    'margin_top' => 35,
    'margin_bottom' => 10,
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
            <div style="font-size: 14pt; font-weight: bold; color: #1a73e8; margin-bottom:5px;">LISTA DE PRECIOS</div>
            <div style="font-size: 8pt;"><b>'.$titulo_agrupacion.'</b></div>
            <div style="font-size: 8pt;">Orden por: '.($_POST["OrdenLP"] ?? '').'</div>
        </td>
        <td width="25%" align="right" style="vertical-align: top;">
            <div style="font-size: 8pt; font-weight: bold;">Corte: '.($_POST["fectx5"] ?? '').'</div>
            <div style="font-size: 8pt; margin-top:5px;">Tasa: '.number_format($tasa, 2).' | BCV: '.number_format($BCVtasa, 2).'</div>
            <div style="font-size: 8pt; margin-top:5px;">Pág. {PAGENO}/{nbpg}</div>
        </td>
    </tr>
</table>';

$mpdf->SetHTMLHeader($cabeceraPDF);

// Configuración a dos columnas como lo mostraste en el texto!
$mpdf->SetColumns(2); 

$mpdf->WriteHTML($html);
$mpdf->Output('Lista_Precios_1167.pdf', 'I');
?>