<?php
// 1. CONFIGURACIÓN DE ALTO RENDIMIENTO
ini_set('memory_limit', '2048M');
ini_set('max_execution_time', '1800');
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', 0);

session_start();
require_once 'ambiente.php'; 

if (function_exists('conectar')) { $conn = conectar(); } 
elseif (function_exists('ConectarConsultas')) { $conn = ConectarConsultas(); } 
else { die("Error Crítico: No hay conexión."); }

// 2. RECEPCIÓN DE DATOS
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

// 3. CONSTRUCCIÓN DE LA CONSULTA OPTIMIZADA
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

// =========================================================================
// INICIAMOS DESCARGA EN EXCEL
// =========================================================================
$nombreArchivo = "Listado_Productos_" . date('Ymd_His') . ".xls";

// Cabeceras HTTP para forzar la descarga en formato Excel (.xls)
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=$nombreArchivo");
header("Pragma: no-cache");
header("Expires: 0");

// Agregamos el BOM para que Excel respete tildes (á,é,í,ó,ú) y la letra ñ
echo "\xEF\xBB\xBF";
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; font-size: 10pt; color: #333; margin:0; }
        .table-main { width: 100%; border-collapse: collapse; margin-top: 5px; }
        .table-main th { 
            background-color: #1a73e8; /* Azul PosUp */
            color: #ffffff; 
            font-weight: bold; 
            text-align: center; 
            padding: 5px; 
            border: 1px solid #aaa; 
        }
        .table-main td { 
            padding: 4px; 
            border: 1px solid #ccc; 
            vertical-align: middle; 
        }
        .num { text-align: right !important; }
        /* Esta clase obliga a Excel a tratar la celda como TEXTO puro (mantiene ceros a la izquierda) */
        .text-format { mso-number-format: '\@'; text-align: center; } 
    </style>
</head>
<body>

    <table width="100%">
        <tr>
            <td colspan="6" align="center" style="font-size: 16pt; font-weight: bold; color: #1a73e8;">
                LISTADO DE PRODUCTOS
            </td>
        </tr>
        <tr>
            <td colspan="6" align="center" style="font-size: 12pt; font-weight: bold;">
                <?php echo mb_strtoupper($nombreEmpresa); ?>
            </td>
        </tr>
        <tr>
            <td colspan="6" align="center">
                <b>Corte al:</b> <?php echo date('d/m/Y', strtotime($fechaHasta)); ?>
            </td>
        </tr>
        <tr><td colspan="6"></td></tr>
    </table>

    <table class="table-main">
        <thead>
            <tr>
                <th>CÓDIGO</th>
                <th>REF</th>
                <th>DESCRIPCIÓN</th>
                <th>PRECIO</th>
                <th>EXISTENCIA</th>
                <th>UND</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $totalItems = 0;
            $totalExistencia = 0;

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $totalItems++;
                    $totalExistencia += $row['Existencia'];
                    
                    $codigo = $row['CodIdAmpliado'] ?: '-';
                    $ref = $row['CodBarra'] ?: '-';
            ?>
            <tr>
                <td class="text-format"><?php echo $codigo; ?></td>
                <td class="text-format"><?php echo $ref; ?></td>
                <td><?php echo mb_strtoupper($row['Descripcion']); ?></td>
                <td class="num"><?php echo number_format($row['Precio'], 2); ?></td>
                <td class="num"><?php echo number_format($row['Existencia'], 2); ?></td>
                <td align="center"><?php echo $row['Und']; ?></td>
            </tr>
            <?php
                }
            }

            if ($totalItems == 0) {
                echo '<tr><td colspan="6" align="center" style="padding:15px; color:red; font-weight:bold;">No se encontraron productos.</td></tr>';
            }
            ?>
        </tbody>
    </table>

    <table width="100%">
        <tr><td colspan="6"></td></tr>
        <tr>
            <td colspan="6" style="border-top:2px solid #000; font-size:10pt;">
                <b>Total Ítems: </b><?php echo $totalItems; ?> | <b>Stock Total: </b><?php echo number_format($totalExistencia, 2); ?>
            </td>
        </tr>
    </table>

</body>
</html>
<?php
// Cerramos la conexión y terminamos el script
mysqli_free_result($result);
exit;
?>