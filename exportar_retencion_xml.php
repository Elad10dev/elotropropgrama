<?php
/**
 * exportar_retencion_xml.php
 * Genera el XML forzando la búsqueda del Código SENIAT directo en la Base de Datos.
 */

ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('memory_limit', '2048M');
ini_set('max_execution_time', '1800');

include 'ambienteconsultas.php';

function clean_rif($rif) {
    // Quita todo lo que no sea letra o número
    $rif = preg_replace('/[^A-Za-z0-9]/', '', strtoupper(trim((string)$rif)));
    // Si el RIF quedó vacío o es un simple 0, le damos el formato neutro
    if ($rif === '0' || $rif === '00000000' || $rif === '') return '000000000';
    return $rif;
}

$IdCompany = isset($_POST['CompanyActual']) ? (int)$_POST['CompanyActual'] : 0;
$FechaDesde = isset($_POST['FechaDesde']) ? trim($_POST['FechaDesde']) : date('Y-m-01');
$FechaHasta = isset($_POST['FechaHasta']) ? trim($_POST['FechaHasta']) : date('Y-m-t');

if ($IdCompany <= 0) die("Error: No se recibió la empresa.");

$cn = conectar();
if (!$cn || $cn->connect_error) die("Error de conexión a la BD.");
$cn->set_charset('utf8');

// 1. RIF DEL AGENTE DE RETENCIÓN (LA EMPRESA)
$rifAgente = "J000000000";
$stC = $cn->prepare("SELECT IDFiscal FROM PosUpCompany WHERE Id=? LIMIT 1");
if ($stC) {
    $stC->bind_param('i', $IdCompany);
    $stC->execute();
    $resC = $stC->get_result()->fetch_assoc();
    if ($resC && !empty($resC['IDFiscal'])) $rifAgente = clean_rif($resC['IDFiscal']);
    $stC->close();
}

// 2. PERIODO
$periodo = date('Ym', strtotime($FechaHasta));

// FORZAR DESCARGA DEL ARCHIVO XML
header('Content-Type: text/xml; charset=utf-8');
header('Content-Disposition: attachment; filename="Retenciones_ISLR_'.$periodo.'.xml"');

$xmlString = '<?xml version="1.0" encoding="utf-8"?>' . "\n";
$xmlString .= '<RelacionRetencionesISLR RifAgenteRetencion="'.$rifAgente.'" Periodo="'.$periodo.'">' . "\n";

// 3. CONSULTAR TODAS LAS RETENCIONES
$sql = "
    SELECT 
        p.Idtx, p.TxfecVence AS FechaRetencion, p.dampliado, p.numret, 
        c.Referencia AS NroFactura, c.numctrol AS NroControl, c.IdBen AS RUTCliente, c.Fectxclient AS FechaFactura,
        (c.imponible * c.tasa) as baseFactura, (c.excento * c.tasa) as exentoFactura
    FROM posuptxp p
    INNER JOIN posuptxc c ON p.IdCompany = c.IdCompany AND p.Idtx = c.Idtx AND p.Idtipotx = c.Idtipotx AND p.IdEstacion = c.IdEstacion
    WHERE p.IdCompany = ? AND p.tiporetencion = 1 AND p.TxfecVence BETWEEN ? AND ?
    ORDER BY p.TxfecVence ASC
";

$stmt = $cn->prepare($sql);
$fechaD = $FechaDesde . " 00:00:00";
$fechaH = $FechaHasta . " 23:59:59";
$stmt->bind_param('iss', $IdCompany, $fechaD, $fechaH);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    
    $rifRetenido = clean_rif($row['RUTCliente']);
    
    $nroFactura = trim((string)$row['NroFactura']);
    if ($nroFactura === '' || $nroFactura === '0') $nroFactura = $row['Idtx']; 
    
    $nroControl = trim((string)$row['NroControl']);
    if ($nroControl === '' || $nroControl === '0') $nroControl = 'NA';
    
    $fechaOperacion = date('d/m/Y', strtotime($row['FechaFactura'])); 

    // =======================================================================
    // AQUI COMIENZA LA EXTRACCIÓN INTELIGENTE DEL CÓDIGO SENIAT DESDE LA BD
    // =======================================================================
    
    // A. Buscamos al cliente para saber si es PN o PJ, DOM o NDOM
    $tp = 'PN'; $dom = 'DOM'; 
    $sqlProv = "SELECT TipoPersona, Domicilio FROM posupclientes WHERE IdCompany=? AND RUT=? LIMIT 1";
    $stP = $cn->prepare($sqlProv);
    $stP->bind_param('is', $IdCompany, $row['RUTCliente']);
    $stP->execute();
    if ($rp = $stP->get_result()->fetch_assoc()) {
        if(trim($rp['TipoPersona']) !== '') $tp = strtoupper(trim((string)$rp['TipoPersona']));
        if(trim($rp['Domicilio']) !== '') $dom = strtoupper(trim((string)$rp['Domicilio']));
    }
    $stP->close();

    // B. Traducimos a tu lógica
    $badgeTipo = 'PNRE';
    if ($tp === 'PN' && $dom === 'DOM')  $badgeTipo = 'PNRE';
    if ($tp === 'PN' && ($dom === 'NDOM' || $dom === 'NODOM')) $badgeTipo = 'PNNR';
    if ($tp === 'PJ' && $dom === 'DOM')  $badgeTipo = 'PJDOM';
    if ($tp === 'PJ' && ($dom === 'NDOM' || $dom === 'NODOM')) $badgeTipo = 'PJNDOM';

    // C. Seleccionamos la columna exacta de la tabla posupretenciones
    $colCodSeniat = 'CSPNR'; 
    switch ($badgeTipo) {
        case 'PNRE':   $colCodSeniat = 'CSPNR'; break;
        case 'PNNR':   $colCodSeniat = 'CSPNNR'; break;
        case 'PJDOM':  $colCodSeniat = 'CSPJDOM'; break;
        case 'PJNDOM': $colCodSeniat = 'CSPJNDOM'; break;
    }

    // D. Buscamos el código SENIAT en base a su NumLit (ej. 9.1.b)
    $codigoConcepto = "000";
    $sqlReg = "SELECT * FROM posupretencion WHERE IdCompany=? AND TipoRet=1 AND NumLit=? LIMIT 1";
    $stR = $cn->prepare($sqlReg);
    $stR->bind_param('is', $IdCompany, $row['numret']);
    $stR->execute();
    $regla = $stR->get_result()->fetch_assoc();
    $stR->close();

    if ($regla) {
        // Extraemos el código limpio, usando la columna (ej. CSPJDOM)
        $codigoConcepto = isset($regla[$colCodSeniat]) ? trim((string)$regla[$colCodSeniat]) : "000";
        if ($codigoConcepto === '') $codigoConcepto = "000";
    }

    // =======================================================================
    // EXTRACCIÓN DE MONTOS
    // =======================================================================
    $montoOperacion = 0.00;
    $porcentajeRetencion = 0.00;

    $dampliado = trim((string)$row['dampliado']);
    $calc = null;
    if ($dampliado !== '' && strpos($dampliado, '{') === 0) {
        $calc = json_decode($dampliado, true);
    }

    if (is_array($calc) && isset($calc['retencion'])) {
        // Extraemos la matemática del JSON
        $montoOperacion = (float)$calc['baseRet'];
        $porcentajeRetencion = (float)$calc['tarifaEf'] * 100;
    } else {
        // Si es una retención vieja sin JSON, la recalculamos
        if ($regla) {
            switch($badgeTipo){
                case 'PNRE':   $bi = (float)$regla['PNREBI']; $tar = (float)$regla['PNRETAR']; break;
                case 'PNNR':   $bi = (float)$regla['PNNRBI']; $tar = (float)$regla['PNNRTAR']; break;
                case 'PJDOM':  $bi = (float)$regla['PJDOMBI']; $tar = (float)$regla['PJDOMTAR']; break;
                case 'PJNDOM': $bi = (float)$regla['PJNDOMBI']; $tar = (float)$regla['PJNDOMTAR']; break;
                default: $bi = 0; $tar = 0;
            }
            $montoOperacion = ($row['baseFactura'] + $row['exentoFactura']) * $bi;
            $porcentajeRetencion = $tar * 100;
        }
    }

    if ($montoOperacion <= 0) continue; // Saltamos retenciones en cero

    // IMPRESIÓN DEL NODO XML
    $xmlString .= "    <DetalleRetencion>\n";
    $xmlString .= "        <RifRetenido>" . htmlspecialchars($rifRetenido) . "</RifRetenido>\n";
    $xmlString .= "        <NumeroFactura>" . htmlspecialchars($nroFactura) . "</NumeroFactura>\n";
    $xmlString .= "        <NumeroControl>" . htmlspecialchars($nroControl) . "</NumeroControl>\n";
    $xmlString .= "        <FechaOperacion>" . $fechaOperacion . "</FechaOperacion>\n";
    $xmlString .= "        <CodigoConcepto>" . htmlspecialchars($codigoConcepto) . "</CodigoConcepto>\n";
    $xmlString .= "        <MontoOperacion>" . number_format($montoOperacion, 2, '.', '') . "</MontoOperacion>\n";
    $xmlString .= "        <PorcentajeRetencion>" . number_format($porcentajeRetencion, 2, '.', '') . "</PorcentajeRetencion>\n";
    $xmlString .= "    </DetalleRetencion>\n";
}

$stmt->close();
$xmlString .= '</RelacionRetencionesISLR>';

echo $xmlString;
?>