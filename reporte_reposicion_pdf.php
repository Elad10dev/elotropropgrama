<?php
// ALTO RENDIMIENTO
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
else { die("Error Crítico: No hay conexión."); }

// 1. RECEPCIÓN DE DATOS
$company = $_SESSION['CompanyActual'] ?? $_POST['CompanyActual'];
$nombreEmpresa = $_POST['NameCompany'] ?? 'Empresa';
$fechaHasta = $_POST['FechaHastaproductos'] ?? date('Y-m-d');
$firstDayOfMonth = (new DateTime($fechaHasta))->format('Y-m-') . '01';

// Lógica de IDs Transacción
$sqlO = "SELECT GROUP_CONCAT(IF(Inventario<>0 AND CompInv=0,Idtipotx,NULL)) as t, 
         GROUP_CONCAT(IF(Inventario=1 AND CompInv=0,Idtipotx,NULL)) as s, 
         GROUP_CONCAT(IF(Inventario=-1 AND CompInv=0,Idtipotx,NULL)) as r FROM posuptx";
$resO = mysqli_query($conn, $sqlO); $rowO = mysqli_fetch_assoc($resO);
$Operainv = $rowO['t']; $Suminv = $rowO['s']; $Resinv = $rowO['r'];

// 2. CONSTRUCCIÓN DE LA CONSULTA OPTIMIZADA
$filtroAlmStock = ""; $filtroAlmTx = "";
if (!empty($_POST["mIdAlmacen"])) {
    $ids = implode("','", $_POST["mIdAlmacen"]);
    $filtroAlmStock = " AND f.IdAlm in ('$ids')";
    $filtroAlmTx = " AND ba.IdAlm in ('$ids')";
}

// Filtros Generales
$where = " WHERE a.IdCompany = $company AND a.EsCompuesto = 0 ";
if (!empty($_POST["mIdProductos"])) $where .= " AND a.CodIdBasico in ('" . implode("','", $_POST["mIdProductos"]) . "') ";
if (!empty($_POST["mIdfamilia"])) $where .= " AND a.Idfamilia in ('" . implode("','", $_POST["mIdfamilia"]) . "') ";
if (!empty($_POST["mIdMarca"])) $where .= " AND a.Marca in ('" . implode("','", $_POST["mIdMarca"]) . "') ";
if (($_POST["EnvioEstado"] ?? '*') !== "*") $where .= " AND a.Estado = " . $_POST["EnvioEstado"];

// Lógica de HAVING (Existencia)
$having = "";
if (($_POST["ExistenciaCero"] ?? '') === "on") {
    // Solo mostrar CERO exacto
    $having = " HAVING (ROUND(Existencia, 2) = 0) ";
} elseif (($_POST["MostrarExistencia"] ?? '') === "on") {
    $having = ""; // Mostrar todo
} else {
    // Por defecto: Mostrar solo lo que tiene stock
    $having = " HAVING (ROUND(Existencia, 2) <> 0) ";
}

$orden = " ORDER BY a.Descripcion ASC";
if (($_POST["Orden"] ?? '') == "Codigo") $orden = " ORDER BY a.CodIdBasico ASC";
if (($_POST["Orden"] ?? '') == "Referencia") $orden = " ORDER BY a.CodBarra ASC";

// CONSULTA SQL (JOIN en lugar de subconsulta por fila)
$query = "
SELECT 
    a.CodBarra, 
    a.CodIdAmpliado, 
    a.Descripcion, 
    round(a.PrecioNeto, 2) as Precio,
    a.Medida as Und,
    COALESCE(stock_calc.TotalCantidad, 0) as Existencia
FROM PosUpProducto a
LEFT JOIN (
    SELECT CodIdBasico, SUM(Cantidad) as TotalCantidad 
    FROM (
        SELECT f.CodIdBasico, sum(f.Cantidad) as Cantidad 
        FROM posupproductostockmes f 
        WHERE f.IdCompany = $company 
        AND f.Periodo < DATE_FORMAT('$firstDayOfMonth', '%Y%m') 
        $filtroAlmStock 
        GROUP BY f.CodIdBasico
        
        UNION ALL
        
        SELECT ba.CodIdBasico, sum(ba.Cant * (if(ba.Idtipotx in ($Suminv),1,0) + if(ba.Idtipotx in ($Resinv),-1,0))) as Cantidad 
        FROM PosUpTxD ba 
        WHERE ba.IdCompany = $company 
        AND ba.Fectxclient >= '$firstDayOfMonth' AND ba.Fectxclient <= '$fechaHasta 23:59:59' 
        AND ba.idtipotx in ($Operainv) 
        $filtroAlmTx 
        GROUP BY ba.CodIdBasico
    ) as union_stock
    GROUP BY CodIdBasico
) as stock_calc ON a.CodIdBasico = stock_calc.CodIdBasico
$where
$having
$orden
";

$result = mysqli_query($conn, $query, MYSQLI_USE_RESULT); // Streaming activado

// 3. PDF
$mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'Letter-L', 'margin_top' => 38, 'tempDir' => __DIR__ . '/tmp']);

$src = "img/informez.png"; 
$pathEntorno = "Comercio/$company/entorno";
if (is_dir($pathEntorno) && $scan = @scandir($pathEntorno)) {
    foreach($scan as $f){ if(strpos($f, "Logotipo") === 0){ $src = "$pathEntorno/$f"; break; } }
}

$header = '
<table width="100%" style="border-bottom: 2px solid #333; font-family: sans-serif; padding-bottom:5px;">
    <tr>
        <td width="15%"><img src="'.$src.'" style="max-height: 60px;"></td>
        <td width="70%" align="center">
            <div style="font-size: 16pt; font-weight: bold;">' . mb_strtoupper($nombreEmpresa) . '</div>
            <div style="font-size: 9pt;">' . $_POST['direccion'] . '</div>
            <div style="font-size: 12pt; font-weight: bold; color: #0056b3; margin-top: 5px;">LISTADO DE PRODUCTOS</div>
            <div style="font-size: 9pt;">Corte al: ' . date('d/m/Y', strtotime($fechaHasta)) . '</div>
        </td>
        <td width="15%" align="right" style="font-size: 8pt;">Pág. {PAGENO}/{nbpg}</td>
    </tr>
</table>';
$mpdf->SetHTMLHeader($header);

$htmlHead = '
<style>table{width:100%;border-collapse:collapse;font-family:sans-serif;font-size:9pt;} th{background:#f0f0f0;border:1px solid #ccc;padding:5px;} td{border:1px solid #eee;padding:4px;} .num{text-align:right;}</style>
<table><thead><tr>
<th width="12%">CÓDIGO</th><th width="12%">REF</th><th width="40%">DESCRIPCIÓN</th><th width="12%" class="num">PRECIO</th><th width="12%" class="num">EXISTENCIA</th><th width="12%">UND</th>
</tr></thead><tbody>';
$mpdf->WriteHTML($htmlHead);

$totalItems = 0;
$totalExistencia = 0;

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $totalItems++;
        $totalExistencia += $row['Existencia'];
        
        $mpdf->WriteHTML('<tr>
            <td>' . ($row['CodIdAmpliado'] ?: '-') . '</td>
            <td>' . ($row['CodBarra'] ?: '-') . '</td>
            <td>' . mb_strtoupper($row['Descripcion']) . '</td>
            <td class="num">' . number_format($row['Precio'], 2) . '</td>
            <td class="num">' . number_format($row['Existencia'], 2) . '</td>
            <td>' . $row['Und'] . '</td>
        </tr>');
    }
}

if ($totalItems == 0) {
    $mpdf->WriteHTML('<tr><td colspan="6" align="center" style="padding:15px;">No se encontraron productos.</td></tr>');
}

$mpdf->WriteHTML('</tbody></table><div style="font-size:9pt; margin-top:10px;"><b>Total Ítems: </b>'.$totalItems.' | <b>Stock Total: </b>'.number_format($totalExistencia,2).'</div>');
$mpdf->Output('Productos.pdf', 'I');
?>