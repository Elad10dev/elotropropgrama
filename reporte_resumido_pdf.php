<?php
// 1. CONFIGURACIÓN ALTO RENDIMIENTO
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

// 2. RECEPCIÓN DE DATOS
$company = $_SESSION['CompanyActual'] ?? $_POST['CompanyActual'];
if (empty($company)) { die("Error: ID Company no recibido."); }

$nombreEmpresa = $_POST['NameCompany'] ?? 'Empresa';
$direccion = $_POST['direccion'] ?? '';
$litFiscal = $_POST['litfiscal'] ?? 'RIF';
$rif = $_POST['rute'] ?? '';

// Fechas
$fechaD = $_POST["DesdeFecha"] ?? date('Y-m-01');
$fechaH = $_POST["FechaHasta"] ?? date('Y-m-d');

// Configuración Numérica
$cd = $_POST["CD"] ?? 2;
$dec = $_POST["SimDec"] ?? '.';
$mil = $_POST["SimMil"] ?? ',';

// Permisos para ver montos (Lógica del sistema original)
$userPerfil = $_POST['userperfil'] ?? 9999;
$verMontos = ($userPerfil <= 2000 || in_array($userPerfil, ['2055', '2054', '2053']));

// 3. CONSTRUCCIÓN DE FILTROS
$filtros = "";
$filtroAlm = "";

// Filtros Generales
if (!empty($_POST["mIdProductos"])) {
    $filtros .= " AND a.CodIdBasico IN ('" . implode("','", $_POST["mIdProductos"]) . "') ";
}
if (!empty($_POST["mIdfamilia"])) {
    $filtros .= " AND a.Idfamilia IN ('" . implode("','", $_POST["mIdfamilia"]) . "') ";
}
if (!empty($_POST["mIdMarca"])) {
    $filtros .= " AND a.Marca IN ('" . implode("','", $_POST["mIdMarca"]) . "') ";
}
if (($_POST["EnvioEstado"] ?? '*') !== "*") {
    $filtros .= " AND a.Estado = " . $_POST["EnvioEstado"];
}

// Filtro Almacén
if (!empty($_POST["mIdAlmacen"])) {
    $ids = implode("','", $_POST["mIdAlmacen"]);
    $filtroAlm = " AND d.IdAlm IN ('$ids') "; 
    // Nota: El filtro de almacén aplica a las transacciones (d), no al producto directo en este reporte
}

// Filtro Sucursal
if (($_POST['sucursal'] ?? '0') != '0') {
    // Se aplicaría sobre el join de almacenes
    $filtroAlm .= " AND d.IdAlm IN (SELECT IdAlm FROM PosUpAlmacen WHERE IdCompany=$company AND IdUbi=" . $_POST['sucursal'] . ") ";
}

// Ordenamiento
$orden = " ORDER BY a.Descripcion ASC ";
if (($_POST["OrdenRES"] ?? '') == "1") $orden = " ORDER BY a.CodIdBasico ASC ";
if (($_POST["OrdenRES"] ?? '') == "3") $orden = " ORDER BY StockFinal DESC ";

// 4. CONSULTA SQL MAESTRA (Resumen de Movimientos)
$query = "SELECT 
            a.CodIdAmpliado, 
            a.CodBarra, 
            a.Descripcion, 
            a.Medida,
            -- Saldo Anterior (Todo lo anterior a Fecha Desde)
            COALESCE(ini.SaldoIni, 0) as SaldoInicial,
            -- Movimientos del Periodo
            COALESCE(mov.Entradas, 0) as Entradas,
            COALESCE(mov.Salidas, 0) as Salidas,
            -- Cálculo Final
            (COALESCE(ini.SaldoIni, 0) + COALESCE(mov.Entradas, 0) - COALESCE(mov.Salidas, 0)) as StockFinal
            
            " . ($verMontos ? ", COALESCE(mov.CostoEntradas, 0) as CostoEntradas, COALESCE(mov.MontoSalidas, 0) as MontoSalidas" : "") . "

          FROM PosUpProducto a
          -- Subconsulta Saldo Inicial
          LEFT JOIN (
              SELECT d.CodIdBasico, SUM(d.Cant * t.Inventario) as SaldoIni
              FROM PosUpTxD d
              INNER JOIN PosUpTx t ON d.Idtipotx = t.Idtipotx AND t.Inventario <> 0
              WHERE d.IdCompany = $company 
                AND d.Fectxclient < '$fechaD 00:00:00'
                $filtroAlm
              GROUP BY d.CodIdBasico
          ) ini ON a.CodIdBasico = ini.CodIdBasico
          -- Subconsulta Movimientos del Periodo
          LEFT JOIN (
              SELECT d.CodIdBasico, 
                     SUM(IF(t.Inventario > 0, d.Cant, 0)) as Entradas,
                     SUM(IF(t.Inventario < 0, d.Cant, 0)) as Salidas
                     " . ($verMontos ? ", SUM(IF(t.Inventario > 0, d.Costo * d.Cant, 0)) as CostoEntradas, SUM(IF(t.Inventario < 0, d.Total, 0)) as MontoSalidas" : "") . "
              FROM PosUpTxD d
              INNER JOIN PosUpTx t ON d.Idtipotx = t.Idtipotx AND t.Inventario <> 0
              WHERE d.IdCompany = $company 
                AND d.Fectxclient BETWEEN '$fechaD 00:00:00' AND '$fechaH 23:59:59'
                $filtroAlm
              GROUP BY d.CodIdBasico
          ) mov ON a.CodIdBasico = mov.CodIdBasico
          
          WHERE a.IdCompany = $company 
            AND a.EsCompuesto = 0
            $filtros
            -- Filtro para no mostrar productos sin ningún movimiento ni saldo
            AND (COALESCE(ini.SaldoIni, 0) <> 0 OR COALESCE(mov.Entradas, 0) <> 0 OR COALESCE(mov.Salidas, 0) <> 0)
          $orden";

$result = mysqli_query($conn, $query, MYSQLI_USE_RESULT); // Streaming

if (!$result) { die("Error SQL: " . mysqli_error($conn)); }

// 5. GENERACIÓN PDF
$mpdf = new Mpdf([
    'mode' => 'utf-8',
    'format' => 'Letter-L', // Landscape
    'margin_top' => 38,
    'tempDir' => __DIR__ . '/tmp'
]);

// Cabecera
$src = "img/informez.png"; 
$pathEntorno = "Comercio/$company/entorno";
if (is_dir($pathEntorno) && $scan = @scandir($pathEntorno)) {
    foreach($scan as $f){ if(strpos($f, "Logotipo") === 0){ $src = "$pathEntorno/$f"; break; } }
}

$header = '
<table width="100%" style="border-bottom: 2px solid #333; font-family: sans-serif; padding-bottom:5px;">
    <tr>
        <td width="15%"><img src="'.$src.'" style="max-height: 50px;"></td>
        <td width="70%" align="center">
            <div style="font-size: 16pt; font-weight: bold;">' . mb_strtoupper($nombreEmpresa) . '</div>
            <div style="font-size: 9pt;">' . $direccion . '</div>
            <div style="font-size: 14pt; font-weight: bold; color: #0056b3; margin-top: 5px;">RESUMEN DE MOVIMIENTOS DE INVENTARIO</div>
            <div style="font-size: 9pt; font-weight: bold;">Desde: ' . date('d/m/Y', strtotime($fechaD)) . ' Hasta: ' . date('d/m/Y', strtotime($fechaH)) . '</div>
        </td>
        <td width="15%" align="right" style="font-size: 8pt;">Impreso: '.date('d/m/Y H:i').'<br>Pág. {PAGENO}/{nbpg}</td>
    </tr>
</table>';
$mpdf->SetHTMLHeader($header);

// Estilos
$style = '
<style>
    table { width: 100%; border-collapse: collapse; font-family: sans-serif; font-size: 8pt; }
    th { background-color: #808080; color: white; padding: 4px; text-align: left; font-weight: bold; }
    td { border-bottom: 1px solid #ccc; padding: 4px; vertical-align: top; color: #333; }
    .num { text-align: right; }
    .total-row { background-color: #333; color: #fff; font-weight: bold; }
</style>
<table>
    <thead>
        <tr>
            <th width="10%">CÓDIGO</th>
            <th width="30%">DESCRIPCIÓN</th>
            <th width="10%" class="num">SALDO INI.</th>
            <th width="10%" class="num">ENTRADAS</th>
            <th width="10%" class="num">SALIDAS</th>
            <th width="10%" class="num">SALDO FINAL</th>
            '.($verMontos ? '<th width="10%" class="num">COSTO ENT.</th><th width="10%" class="num">VENTA SAL.</th>' : '').'
        </tr>
    </thead>
    <tbody>';
$mpdf->WriteHTML($style);

// Totales
$totIni = 0; $totEnt = 0; $totSal = 0; $totFin = 0;
$totCosto = 0; $totVenta = 0;
$items = 0;

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $items++;
        
        $totIni += $row['SaldoInicial'];
        $totEnt += $row['Entradas'];
        $totSal += $row['Salidas'];
        $totFin += $row['StockFinal'];
        
        if ($verMontos) {
            $totCosto += $row['CostoEntradas'];
            $totVenta += $row['MontoSalidas'];
        }

        $htmlRow = '<tr>
            <td>' . ($row['CodIdAmpliado'] ?: $row['CodBarra']) . '</td>
            <td>' . mb_strtoupper(mb_substr($row['Descripcion'], 0, 45)) . '</td>
            <td class="num">' . number_format($row['SaldoInicial'], $cd, $dec, $mil) . '</td>
            <td class="num" style="color:green;">' . number_format($row['Entradas'], $cd, $dec, $mil) . '</td>
            <td class="num" style="color:red;">' . number_format($row['Salidas'], $cd, $dec, $mil) . '</td>
            <td class="num" style="font-weight:bold;">' . number_format($row['StockFinal'], $cd, $dec, $mil) . '</td>
            '.($verMontos ? 
                '<td class="num">' . number_format($row['CostoEntradas'], 2, $dec, $mil) . '</td>
                 <td class="num">' . number_format($row['MontoSalidas'], 2, $dec, $mil) . '</td>' 
            : '').'
        </tr>';
        
        $mpdf->WriteHTML($htmlRow);
    }
}

if ($items == 0) {
    $mpdf->WriteHTML('<tr><td colspan="'.($verMontos?8:6).'" align="center">No se encontraron movimientos en el periodo seleccionado.</td></tr>');
}

// Pie de Tabla con Totales
$htmlFooter = '
    </tbody>
    <tfoot>
        <tr><td colspan="'.($verMontos?8:6).'" style="border:none; height:5px;"></td></tr>
        <tr class="total-row">
            <td colspan="2" align="right">TOTALES GENERALES:</td>
            <td class="num">' . number_format($totIni, $cd, $dec, $mil) . '</td>
            <td class="num">' . number_format($totEnt, $cd, $dec, $mil) . '</td>
            <td class="num">' . number_format($totSal, $cd, $dec, $mil) . '</td>
            <td class="num">' . number_format($totFin, $cd, $dec, $mil) . '</td>
            '.($verMontos ? 
                '<td class="num">' . number_format($totCosto, 2, $dec, $mil) . '</td>
                 <td class="num">' . number_format($totVenta, 2, $dec, $mil) . '</td>' 
            : '').'
        </tr>
    </tfoot>
</table>';

$mpdf->WriteHTML($htmlFooter);
$mpdf->Output('Resumen_Movimiento.pdf', 'I');
?>