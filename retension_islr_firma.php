<?php
/**
 * retension_islr_firma.php (ARCHIVO DE IMPRESIÓN CON FIRMA - BLINDADO)
 * Imprime exactamente el mismo resultado del modal leyendo el JSON guardado.
 */

ini_set('display_errors', '0');
ini_set('log_errors', '1');

include 'ambienteconsultas.php';

function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function post($k, $default=null){ return isset($_REQUEST[$k]) ? $_REQUEST[$k] : $default; }

function as_int($v, $default=0){
  if ($v === null || $v === '') return $default;
  return (int)$v;
}
function as_bigint($v, $default=0){
  if ($v === null || $v === '') return $default;
  return (int)$v;
}
// Formato Venezuela para impresión
function fmt_money($n){ return number_format((float)$n, 2, ',', '.'); }

function die_html($title, $msg){
  echo "<div style='padding: 30px; font-family: Arial, sans-serif;'>";
  echo "<h2 style='color: #d9534f;'>".h($title)."</h2>";
  echo "<p style='font-size: 16px;'>".h($msg)."</p>";
  echo "<p style='color: #666; font-size: 12px;'>Cierre esta pestaña e intente procesar la retención nuevamente.</p>";
  echo "</div>";
  exit;
}

/**
 * Mismo mapeo que tienes en tu modal
 */
function map_tipoBenef($tipoBenef){
  $tb = strtoupper(trim((string)$tipoBenef));
  $valid = ["PNDOM","PNNDOM","PJDOM","PJNDOM"];
  // Si no es válido, devolvemos 'DESCONOCIDO' en vez de forzar 'PNRE'
  //if (!in_array($tb, $valid, true)) return "DESCONOCIDO"; 
  return $tipoBenef;
}

/* =======================
   CONEXIÓN E INPUTS
======================= */
// Capturamos los parámetros que envía el modal (URL: ?IdTx=...&IdCompany=...)
$IdCompany  = as_int(post('IdCompany') ?: post('idcompany'));
$IdTx       = as_bigint(post('IdTx') ?: post('Idtx') ?: post('idtx'));

$cn = conectar();
if (!$cn || $cn->connect_error) {
  die_html('Error de Conexión', 'No hay conexión a la base de datos.');
}
$cn->set_charset('utf8');

if ($IdCompany <= 0 || $IdTx <= 0) {
  die_html('Faltan Datos', 'No se recibieron los parámetros correctos para imprimir la factura (IdCompany o IdTx). Revise la URL.');
}

/* =======================
   BUSCAR TRANSACCIÓN BASE
======================= */
$stFill = $cn->prepare("SELECT Idtipotx, IdEstacion FROM posuptxc WHERE Idtx=? AND IdCompany=? LIMIT 1");
$stFill->bind_param('ii', $IdTx, $IdCompany);
$stFill->execute();
$rowFill = $stFill->get_result()->fetch_assoc();
$stFill->close();

if (!$rowFill) {
    die_html('Error', 'No se encontró la transacción de venta base para imprimir.');
}
$IdTipoTx = (int)$rowFill['Idtipotx'];
$IdEstacion = (string)$rowFill['IdEstacion'];

/* =======================
   BUSCAR LA RETENCIÓN GUARDADA (BÚSQUEDA FLEXIBLE)
   Solo exigimos IdCompany e IdTx para no fallar por diferencias de "Estacion"
======================= */
$sqlExist = "
    SELECT Referencia, numret, TxfecVence, DAmpliado 
    FROM posuptxp 
    WHERE IdCompany=? AND Idtx=? AND tiporetencion=1 
    ORDER BY Item DESC LIMIT 1
";
$stExist = $cn->prepare($sqlExist);
$stExist->bind_param('ii', $IdCompany, $IdTx);
$stExist->execute();
$rowExist = $stExist->get_result()->fetch_assoc();
$stExist->close();

if (!$rowExist) {
    die_html('Aviso', 'Aún no se ha procesado y guardado una retención para esta transacción. No hay comprobante que imprimir. Por favor, dale al botón azul "Procesar (Guardar)" en el modal.');
}

$numComprobante = trim((string)$rowExist['Referencia']);
$NumLit = trim((string)$rowExist['numret']);
$FechaRet = trim((string)$rowExist['TxfecVence']);

// Extraer el cálculo matemático exacto que guardaste
$calc = null;
if (!empty($rowExist['DAmpliado'])) {
    $calc = json_decode($rowExist['DAmpliado'], true);
}

if (!$calc || !isset($calc['retencion'])) {
    die_html('Error en los Datos', 'Se encontró la retención, pero no tiene los detalles matemáticos guardados. Por favor, anula la retención y vuelve a procesarla.');
}

/* =======================
   CARGAR RESTO DE DATOS (Empresa, Cliente, Factura)
======================= */
// Búsqueda flexible para la factura
$sqlTx = "SELECT IdBen, numctrol, prefijo, Referencia, Fectxclient FROM posuptxc WHERE IdCompany=? AND Idtx=? LIMIT 1";
$st = $cn->prepare($sqlTx);
$st->bind_param('ii', $IdCompany, $IdTx);
$st->execute();
$tx = $st->get_result()->fetch_assoc();
$st->close();

$IdBen = trim((string)$tx['IdBen']);

$sqlProv = "SELECT RUT, Nombre, Direccion, TipoBenef, TipoPersona, Domicilio FROM posupclientes WHERE IdCompany=? AND RUT=? LIMIT 1";
$st = $cn->prepare($sqlProv);
$st->bind_param('is', $IdCompany, $IdBen);
$st->execute();
$prov = $st->get_result()->fetch_assoc();
$st->close();

// Agente de Retención
$agente = [
    'comercio' => 'Empresa Desconocida', 
    'IDFiscal' => '', 
    'direccion' => '', 
    'correorep' => '', 
    'Telefono' => ''
];

// Quitamos "logotipo" de la consulta SQL para que no dé error
$sqlCompany = "SELECT comercio, IDFiscal, direccion, correorep, Telefono FROM PosUpCompany WHERE Id=? LIMIT 1";
$stC = $cn->prepare($sqlCompany);

if ($stC) { 
    $stC->bind_param('i', $IdCompany);
    $stC->execute();
    $resC = $stC->get_result()->fetch_assoc();
    if ($resC) {
        $agente = $resC;
    }
    $stC->close();
}

// Mantenemos la variable $Logotipo global por si viene de ambienteconsultas.php (igual que en el modal)
$Logotipo = isset($Logotipo) ? $Logotipo : "";

// Concepto (Nombre)
// Concepto y Códigos SENIAT
$st = $cn->prepare("SELECT * FROM posupretencion WHERE IdCompany=? AND TipoRet=1 AND NumLit=? LIMIT 1");
$st->bind_param('is', $IdCompany, $NumLit);
$st->execute();
$regla = $st->get_result()->fetch_assoc();
$st->close();


/* =======================
   PREPARACIÓN DE VARIABLES VISUALES
======================= */
$tp  = isset($prov['TipoPersona']) ? strtoupper(trim((string)$prov['TipoPersona'])) : '';
$dom = isset($prov['Domicilio'])   ? strtoupper(trim((string)$prov['Domicilio'])) : '';

// 1. Asignar el tipo de beneficiario correcto soportando NDOM y NODOM
if ($tp === 'PN' && $dom === 'DOM')  { 
    $prov['TipoBenef'] = 'PNRE'; 
} elseif ($tp === 'PN' && ($dom === 'NDOM' || $dom === 'NODOM')) { 
    $prov['TipoBenef'] = 'PNNR'; 
} elseif ($tp === 'PJ' && $dom === 'DOM')  { 
    $prov['TipoBenef'] = 'PJDOM'; 
} elseif ($tp === 'PJ' && ($dom === 'NDOM' || $dom === 'NODOM')) { 
    $prov['TipoBenef'] = 'PJNDOM'; 
} else {
    $prov['TipoBenef'] = 'PNRE'; // Por defecto
}

$badgeTipo = map_tipoBenef($prov['TipoBenef']);

// 2. Definir en qué columna de la base de datos vamos a buscar el código de 3 dígitos
$colCodSeniat = 'CSPNR'; // Por defecto
switch ($badgeTipo) {
    case 'PNRE':   $colCodSeniat = 'CSPNR'; break;
    case 'PNNR':   $colCodSeniat = 'CSPNNR'; break;
    case 'PJDOM':  $colCodSeniat = 'CSPJDOM'; break;
    case 'PJNDOM': $colCodSeniat = 'CSPJNDOM'; break;
}

$nombresBenef = [
    'PNRE' => 'Persona Natural Residenciada',
    'PNNR' => 'Persona Natural No Residenciada',
    'PJDOM' => 'Persona Jurídica Domiciliada',
    'PJNDOM' => 'Persona Jurídica No Domiciliada'
];
$badgeTipoLargo = isset($nombresBenef[$badgeTipo]) ? $nombresBenef[$badgeTipo] : $badgeTipo;

// 3. Extraer el código SENIAT directamente de la regla guardada en la base de datos
$codSeniat = isset($regla[$colCodSeniat]) ? trim((string)$regla[$colCodSeniat]) : '';

if ($codSeniat === '') {
    $codSeniat = 'SIN CÓDIGO'; 
}

$conceptoNombre = trim((string)($regla['Nombre'] ?? 'HONORARIOS PROFESIONALES'));

$fechaFactura = date('d/m/Y', strtotime($tx['Fectxclient']));
$fechaComprobanteFormat = date('d/m/Y', strtotime($FechaRet));
$refTx = trim((string)($tx['Referencia'] ?? '0'));
$numctrol = trim((string)($tx['numctrol'] ?? '0'));
$docInterno = (trim((string)($tx['prefijo'] ?? '')) !== '') ? trim((string)($tx['prefijo'])) . '-' . $IdTx : $IdTx;

?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Comprobante Retención ISLR</title>
<style>
    body { font-family: Arial, Helvetica, sans-serif; margin: 0; padding: 0; box-sizing: border-box; } 
    @media print { 
        @page { size: landscape; margin: 10mm; } 
        body { -webkit-print-color-adjust: exact; print-color-adjust: exact; } 
    } 
    table { width: 100%; border-collapse: collapse; } 
    th, td { border: 1px solid #bbb; padding: 6px; font-size: 12px; } 
    th { background: #f3f3f3; text-align: left; }
    .text-center { text-align: center; }
</style>
</head>
<body>

<div style='margin: 0 auto; width: 100%; box-sizing: border-box; padding: 5mm; display: flex; flex-direction: column; min-height: 85vh;'>
    
    <div style="flex: 1;">
        <table style="border:none; margin-bottom: 20px;">
            <tr>
                <td style="width: 15%; text-align: left; vertical-align: middle; border:none;">
                    <?php if ($Logotipo !== ""): ?>
                        <img src="<?= '/Comercio/' . $IdCompany . '/entorno/' . $Logotipo ?>" style="max-width: 80px; max-height: 80px;">
                    <?php else: ?>
                        <img src="img/logo.png" style="max-width: 80px; max-height: 80px;">
                    <?php endif; ?>
                </td>
                <td style="width: 85%; text-align: center; vertical-align: middle; border:none;">
                    <div style="font-size: 14px; font-weight:bold;">COMPROBANTE DE RETENCIÓN DEL IMPUESTO SOBRE LA RENTA</div>
                    <div style="font-size: 11px; font-weight:bold; margin-top: 5px;">Decreto 1.808 Art. 24 los agentes de retención estan obligados a los contribuyentes:</div>
                    <div style="font-size: 11px;">un comprobante por cada retención de impuesto que le practiquen en el cual se indica, entre otra Información.</div>
                    <div style="font-size: 11px;">el monto de lo pagado o abonado en cuenta y cantidad retenida.</div>
                </td>
            </tr>
        </table>

        <div style="text-align: center; margin-bottom: 15px; font-size: 12px;">
            <b>N° Comprobante:</b> <?=h($numComprobante)?> &nbsp;&nbsp;|&nbsp;&nbsp; 
            <b>Fecha Comprobante:</b> <?=h($fechaComprobanteFormat)?> &nbsp;&nbsp;|&nbsp;&nbsp; 
            <b>Fecha Factura:</b> <?=h($fechaFactura)?>
        </div>
        
        <table style="margin-bottom: 15px;">
            <tr>
                <th style="width: 50%;">Agente de Retención</th>
                <th style="width: 50%;">Sujeto Retenido</th>
            </tr>
            <tr>
                <td style="vertical-align: top; line-height: 1.4;">
                    <b>Nombre:</b> <?=h($agente['comercio'] ?? '')?><br>
                    <b>RIF:</b> <?=h($agente['IDFiscal'] ?? '')?><br>
                    <b>Dirección:</b> <?=h($agente['direccion'] ?? '')?><br>
                    <b>Teléfono:</b> <?=h($agente['Telefono'] ?? '')?><br>
                    <b>Correo:</b> <?=h($agente['correorep'] ?? '')?>
                </td>
                <td style="vertical-align: top; line-height: 1.4;">
                    <b>Nombre:</b> <?=h($prov['Nombre'] ?? '')?><br>
                    <b>RIF:</b> <?=h($prov['RUT'] ?? '')?><br>
                    <b>Dirección:</b> <?=h($prov['Direccion'] ?? '')?><br>
                    <b>Clasificación Fiscal:</b> <?=h($badgeTipoLargo)?>
                </td>
            </tr>
        </table>

        <div style="font-size: 13px; margin-bottom: 5px;"><b>Datos de la Transacción:</b></div>
        <table class="text-center" style="margin-bottom: 15px;">
            <thead style="background-color: #f3f3f3;">
                <tr>
                    <th class="text-center">N° Control</th>
                    <th class="text-center">Nro Factura</th>
                    <th class="text-center">Cód. SENIAT</th>
                    <th style="text-align: left;">Concepto</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=h($numctrol !== '' && $numctrol !== '0' ? $numctrol : '0')?></td>
                    <td><?=h($refTx !== '' && $refTx !== '0' ? $refTx : $docInterno)?></td>
                    <td style="font-weight: bold; text-transform: uppercase;"><?=h($codSeniat)?></td>
                    <td style="text-align: left;"><?=h($conceptoNombre)?></td>
                </tr>
            </tbody>
        </table>

        <div style="font-size: 13px; margin-bottom: 5px;"><b>Detalle del Cálculo de Retención:</b></div>
        <table class="text-center">
            <thead style="background-color: #f3f3f3;">
                <tr>
                    <th class="text-center">Base Imponible de Factura</th>
                    <th class="text-center">Base Ret.</th>
                    <th class="text-center">% Ret.</th>
                    <th class="text-center">Sustraendo</th>
                    <th class="text-center" style="font-size: 12px;">Retención</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=fmt_money($calc['baseFiscal'])?></td>
                    <td><?=fmt_money($calc['baseRet'])?></td>
                    <td><?=number_format((float)($calc['tarifaEf'] * 100), 2, ',', '.')?> %</td>
                    <td><?=fmt_money($calc['SUST'])?></td>
                    <td style="font-weight: bold; font-size: 13px;"><?=fmt_money($calc['retencion'])?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div style="margin-top: auto; padding-top: 40px;">
        <table class="text-center" style="border:none;">
            <tr>
            <td style="width: 50%; border:none; vertical-align: bottom;">
                <div style="width: 70%; margin: 0 auto; position: relative;">
                    <img src="./img/img11.png" style="width: 160px; mix-blend-mode: multiply; margin-bottom: -8px; position: relative; z-index: 0;">
                    <div style="border-top: 1px solid #000; padding-top: 5px; font-weight: bold; text-transform: uppercase; position: relative; z-index: 1;">AGENTE DE RETENCIÓN</div>
                </div>
            </td>
            <td style="width: 50%; border:none; vertical-align: bottom;">
                <div style="width: 70%; margin: 0 auto;">
                    <div style="height: 60px;"></div> 
                    <div style="border-top: 1px solid #000; padding-top: 5px; font-weight: bold; text-transform: uppercase;">SUJETO RETENIDO</div>
                </div>
            </td>
            </tr>
        </table>
    </div>

</div>

<script>
// Auto imprimir al cargar la página
window.onload = function() {
    setTimeout(function() {
        window.print();
    }, 500);
};
</script>
</body>
</html>