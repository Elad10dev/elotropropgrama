<?php
/**
 * retencion_islr_1140.php (Manejo VZLA con Firma Personalizada para Impresión)
 */

ini_set('display_errors', '0');
ini_set('log_errors', '1');

include 'ambienteconsultas.php';

function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
// Usamos REQUEST para que funcione tanto en el modal como al abrir la pestaña de impresión
function post($k, $default=null){ return isset($_REQUEST[$k]) ? $_REQUEST[$k] : $default; }

function as_int($v, $default=0){
  if ($v === null || $v === '') return $default;
  return (int)$v;
}
function as_bigint($v, $default=0){
  if ($v === null || $v === '') return $default;
  return (int)$v;
}
function as_str($v, $default=''){
  if ($v === null) return $default;
  return trim((string)$v);
}
function as_date($v){
  $v = trim((string)$v);
  if ($v === '') return '';
  if (!preg_match('/^\d{4}\-\d{2}\-\d{2}$/', $v)) return '';
  return $v;
}

function fmt_money($n){ return number_format((float)$n, 2, ',', '.'); }
function fmt_input($n){ return number_format((float)$n, 2, '.', ''); }

function die_html($title, $msg){
  echo "<div class='p-3'><div class='alert alert-danger'><b>".h($title)."</b><br>".h($msg)."</div></div>";
  exit;
}

function map_tipoBenef($tipoBenef){
  $tb = strtoupper(trim((string)$tipoBenef));
  $valid = ["PNRE","PNNR","PJDOM","PJNDOM"];
  // Si no es válido, devolvemos 'DESCONOCIDO' en vez de forzar 'PNRE'
  if (!in_array($tb, $valid, true)) return "DESCONOCIDO"; 
  return $tb;
}

function calc_retencion($tx, $prov, $regla){
  $imponible = (float)$tx['imponible'];
  $exento    = (float)$tx['excento'];
  $baseFiscal = $imponible + $exento;
  $tipoBenef = map_tipoBenef($prov['TipoBenef']);

  $BI = 0.0; $TAR = 0.0; $PM = 0.0; $SUST = 0.0; $COD=''; $PA = 0.0;

  switch($tipoBenef){
    case 'PNRE':  $BI = (float)$regla['PNREBI']; $TAR = (float)$regla['PNRETAR']; $PM = (float)$regla['PNREPM']; $SUST = (float)$regla['PNRESUST']; $COD = (string)$regla['PNRECOD']; break;
    case 'PNNR':  $BI = (float)$regla['PNNRBI']; $TAR = (float)$regla['PNNRTAR']; $PM = (float)$regla['PNNRBIPA']; $SUST = (float)$regla['PNNRSUS']; $COD = (string)$regla['PNNRCOD']; break;
    case 'PJDOM': $BI = (float)$regla['PJDOMBI']; $TAR = (float)$regla['PJDOMTAR']; $COD = (string)$regla['PJDOMCOD']; $PA = (float)$regla['PJDOMPA']; break;
    case 'PJNDOM':$BI = (float)$regla['PJNDOMBI']; $TAR = (float)$regla['PJNDOMTAR']; $COD = (string)$regla['PJNDOMCOD']; $PA = (float)$regla['PJNDOMPA']; break;
  }

  $baseRet = $baseFiscal * $BI;
  $tarifaEf = $TAR;
  if ($PA > 0) $tarifaEf = $TAR * (1.0 + ($PA / 100.0));

  if ($PM > 0 && $baseRet > 0 && $baseRet < $PM) {
    return ['tipoBenef' => $tipoBenef, 'imponible' => $imponible, 'exento' => $exento, 'baseFiscal' => $baseFiscal, 'BI' => $BI, 'baseRet' => $baseRet, 'TAR' => $TAR, 'PA' => $PA, 'tarifaEf' => $tarifaEf, 'SUST' => $SUST, 'PM' => $PM, 'COD' => $COD, 'retencion' => 0.0, 'retencion_raw' => 0.0, 'nota' => 'Base menor al mínimo'];
  }

  $retRaw = ($baseRet * $tarifaEf);
  $ret = $retRaw - $SUST;
  if ($ret < 0) $ret = 0.0;

  return ['tipoBenef' => $tipoBenef, 'imponible' => $imponible, 'exento' => $exento, 'baseFiscal' => $baseFiscal, 'BI' => $BI, 'baseRet' => $baseRet, 'TAR' => $TAR, 'PA' => $PA, 'tarifaEf' => $tarifaEf, 'SUST' => $SUST, 'PM' => $PM, 'COD' => $COD, 'retencion' => $ret, 'retencion_raw' => $retRaw, 'nota' => ''];
}

function next_numret(mysqli $cn, $IdCompany, $FechaRet){
  $year = (int)substr($FechaRet, 0, 4);
  $sql = "SELECT LPAD(IFNULL(MAX(CAST(Referencia AS UNSIGNED)),0)+1, 11, '0') AS nxt FROM posuptxp WHERE IdCompany = ? AND tiporetencion = 1 AND YEAR(TxfecVence) = ? AND Referencia REGEXP '^[0-9]+$'";
  $stmt = $cn->prepare($sql);
  $stmt->bind_param('ii', $IdCompany, $year);
  $stmt->execute();
  $row = $stmt->get_result()->fetch_assoc();
  $stmt->close();
  return ($row && $row['nxt']) ? $row['nxt'] : '00000000001';
}

/* =======================
   CONEXIÓN E INPUT
======================= */
$IdCompany  = as_int(post('IdCompany'));
$IdTipoTx   = as_int(post('IdTipoTx'));
$IdTx       = as_bigint(post('IdTx'));
$IdEstacion = as_str(post('IdEstacion'));
$NumLit     = as_str(post('NumLit'));
$FechaRet   = as_date(post('FechaRet'));
$CustomBaseRet = as_str(post('CustomBaseRet', '')); 
$do         = as_str(post('do', 'preview')); 

$cn = conectar();
if (!$cn || $cn->connect_error) die_html('Error', 'No hay conexión a BD.');
$cn->set_charset('utf8');

// Recuperar datos faltantes para apertura por URL (GET)
if ($IdTx > 0 && $IdCompany > 0 && ($IdTipoTx <= 0 || $IdEstacion === '')) {
    $stFill = $cn->prepare("SELECT Idtipotx, IdEstacion FROM posuptxc WHERE Idtx=? AND IdCompany=? LIMIT 1");
    $stFill->bind_param('ii', $IdTx, $IdCompany);
    $stFill->execute();
    if ($rowFill = $stFill->get_result()->fetch_assoc()) {
        $IdTipoTx = (int)$rowFill['Idtipotx'];
        $IdEstacion = (string)$rowFill['IdEstacion'];
    }
    $stFill->close();
}

if ($IdCompany <= 0 || $IdTipoTx <= 0 || $IdTx <= 0 || $IdEstacion === '') {
  die_html('Retención ISLR', 'Faltan parámetros base. Requiere: IdCompany, IdTipoTx, IdTx, IdEstacion.');
}
if ($FechaRet === '') $FechaRet = date('Y-m-d');

/* =======================
   CARGAR DATOS
======================= */
$sqlExist = "SELECT COUNT(*) as cant, MAX(Referencia) as nro_existente FROM posuptxp WHERE IdCompany=? AND Idtipotx=? AND Idtx=? AND IdEstacion=? AND tiporetencion=1";
$stExist = $cn->prepare($sqlExist);
$stExist->bind_param('iiis', $IdCompany, $IdTipoTx, $IdTx, $IdEstacion);
$stExist->execute();
$rowExist = $stExist->get_result()->fetch_assoc();
$existingCount = (int)$rowExist['cant'];
$stExist->close();

$sqlTx = "SELECT IdBen, tasa AS tasa_tx, imponible * tasa AS imponible, excento * tasa AS excento, numctrol, prefijo, Referencia, Fectxclient FROM posuptxc WHERE IdCompany=? AND Idtipotx=? AND Idtx=? AND IdEstacion=? LIMIT 1";
$st = $cn->prepare($sqlTx);
$st->bind_param('iiis', $IdCompany, $IdTipoTx, $IdTx, $IdEstacion);
$st->execute();
$tx = $st->get_result()->fetch_assoc();
$st->close();

if (!$tx) die_html('Error', 'No encontré la transacción.');
$IdBen = trim((string)$tx['IdBen']);

$sqlProv = "SELECT RUT, Nombre, Direccion, TipoBenef, TipoPersona, Domicilio FROM posupclientes WHERE IdCompany=? AND RUT=? LIMIT 1";
$st = $cn->prepare($sqlProv);
$st->bind_param('is', $IdCompany, $IdBen);
$st->execute();
$prov = $st->get_result()->fetch_assoc();
$st->close();

if (!$prov) {
  die_html('Retención ISLR', 'No encontré el proveedor en posupclientes (RUT = IdBen).');
}


// 1. Extraemos ESTRICTAMENTE lo que dice la tabla posupclientes
$tp  = isset($prov['TipoPersona']) && trim((string)$prov['TipoPersona']) !== '' ? strtoupper(trim((string)$prov['TipoPersona'])) : 'VACIO';
$dom = isset($prov['Domicilio']) && trim((string)$prov['Domicilio']) !== ''   ? strtoupper(trim((string)$prov['Domicilio'])) : 'VACIO';

// 2. Armamos el texto visual EXACTO y asignamos los datos matemáticos
$textoMostrar = "";
$colCodSeniat = 'CSPNR'; // Por defecto para evitar errores SQL

if ($tp === 'PN') {
    $textoMostrar .= "PN (Natural)";
    if ($dom === 'DOM') {
        $prov['TipoBenef'] = 'PNRE';
        $colCodSeniat = 'CSPNR';
    } else {
        $prov['TipoBenef'] = 'PNNR';
        $colCodSeniat = 'CSPNNR';
    }
} elseif ($tp === 'PJ') {
    $textoMostrar .= "PJ (Jurídica)";
    if ($dom === 'DOM') {
        $prov['TipoBenef'] = 'PJDOM';
        $colCodSeniat = 'CSPJDOM';
    } else {
        $prov['TipoBenef'] = 'PJNDOM';
        $colCodSeniat = 'CSPJNDOM';
    }
} else {
    $textoMostrar .= "Tipo: " . $tp;
    $prov['TipoBenef'] = 'PNRE'; // Fallback solo para que la matemática no colapse
    $colCodSeniat = 'CSPNR';
}

$textoMostrar .= " - ";

if ($dom === 'DOM') {
    $textoMostrar .= "DOM (Domiciliada)";
} elseif ($dom === 'NDOM') {
    $textoMostrar .= "NDOM (No Domiciliada)";
} else {
    $textoMostrar .= "Dom: " . $dom;
}

$badgeTipo = map_tipoBenef($prov['TipoBenef']);
$badgeTipoLargoPersonalizado = $textoMostrar; // Guardamos el texto final

// AQUÍ VOLVEMOS A COLOCAR TU LÓGICA EXACTA PARA LA EMPRESA Y LOGO
$agente = ['comercio' => 'Empresa Desconocida', 'IDFiscal' => '', 'direccion' => '', 'correorep' => '', 'Telefono' => ''];
$sqlCompany = "SELECT comercio, IDFiscal, direccion, correorep, Telefono FROM PosUpCompany WHERE Id=? LIMIT 1";
$stC = $cn->prepare($sqlCompany);
if ($stC) { 
    $stC->bind_param('i', $IdCompany);
    $stC->execute();
    if ($resC = $stC->get_result()->fetch_assoc()) $agente = $resC; // Asignación directa en una línea
    $stC->close();
}


// AQUI CARGAMOS EL CONCEPTO Y SACAMOS EL CODIGO SENIAT CON LA VARIABLE CORRECTA
$conceptos = [];
$validNumLits = [];
$sqlConceptos = "
  SELECT NumLit, Nombre
  FROM posupretencion
  WHERE IdCompany=? AND TipoRet=1
    AND $colCodSeniat IS NOT NULL 
    AND $colCodSeniat != ''
  ORDER BY NumLit
";
$st = $cn->prepare($sqlConceptos);
$st->bind_param('i', $IdCompany);
$st->execute();
$rs = $st->get_result();
while($row = $rs->fetch_assoc()){ 
    $conceptos[] = $row; 
    $validNumLits[] = (string)$row['NumLit']; 
}
$st->close();

if (empty($conceptos)) {
    die_html('Configuración Incompleta', "No existen conceptos de retención con Código SENIAT asignado para el tipo de contribuyente: $badgeTipo. Por favor, asigne códigos SENIAT en el panel de Retenciones.");
}

if ($NumLit === '' || !in_array($NumLit, $validNumLits)) {
    $NumLit = (string)$conceptos[0]['NumLit'];
}

$st = $cn->prepare("SELECT * FROM posupretencion WHERE IdCompany=? AND TipoRet=1 AND NumLit=? LIMIT 1");
$st->bind_param('is', $IdCompany, $NumLit);
$st->execute();
$regla = $st->get_result()->fetch_assoc();
$st->close();

if (!$regla) {
  die_html('Retención ISLR', "No encontré la regla en posupretencion para NumLit='".h($NumLit)."' (TipoRet=1).");
}

$calc = calc_retencion($tx, $prov, $regla);
$preNumRet = next_numret($cn, $IdCompany, $FechaRet);
$numret = ($existingCount > 0) ? $rowExist['nro_existente'] : $preNumRet; 

// Sobreescribimos el nombre largo con nuestro texto personalizado directo de la BD
$badgeTipoLargo = $badgeTipoLargoPersonalizado;
$codSeniat = trim($regla[$colCodSeniat] ?? 'SIN CÓDIGO');
$conceptoNombre = trim((string)$regla['Nombre']);
$tasaTx = (float)($tx['tasa_tx'] ?? 1);
$fechaFactura = date('d/m/Y', strtotime($tx['Fectxclient']));
$fechaComprobanteFormat = date('d/m/Y', strtotime($FechaRet));
$refTx = trim((string)($tx['Referencia'] ?? '0'));
$numctrol = trim((string)($tx['numctrol'] ?? '0'));
$docInterno = (trim((string)($tx['prefijo'] ?? '')) !== '') ? trim((string)($tx['prefijo'])) . '-' . $IdTx : $IdTx;

$procesado = true; 
?>

<div id="islr_print_area">
    <div style='margin: 0 auto; width: 100%; box-sizing: border-box; padding: 10mm; font-size: 11px; font-family: Arial, sans-serif; display: flex; flex-direction: column; min-height: 85vh; background: #fff;'>
        
        <div style="flex: 1;">
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <tr>
                    <td style="width: 15%; text-align: left; vertical-align: middle;">
                        <?php if ($Logotipo !== "" && $Logotipo !== null): ?>
                            <img src="<?= '/Comercio/' . $IdCompany . '/entorno/' . $Logotipo ?>" style="max-width: 80px; max-height: 80px;">
                        <?php else: ?>
                            <img src="img/logo.png" style="max-width: 80px; max-height: 80px;">
                        <?php endif; ?>
                    </td>
                    <td style="width: 85%; text-align: center; vertical-align: middle;">
                        <div style="font-size: 14px; font-weight:bold;">NUEVO COMPROBANTE DE RETENCIÓN DEL IMPUESTO SOBRE LA RENTA</div>
                        <div style="font-size: 11px; font-weight:bold; margin-top: 5px;">Decreto 1.808 Art. 24 los agentes de retención estan obligados a los contribuyentes:</div>
                        <div style="font-size: 11px;">un comprobante por cada retención de impuesto que le practiquen en el cual se indica, entre otra Información.</div>
                        <div style="font-size: 11px;">el monto de lo pagado o abonado en cuenta y cantidad retenida.</div>
                    </td>
                </tr>
            </table>

            <div style="text-align: center; margin-bottom: 15px; font-size: 12px;">
                <b>N° Comprobante:</b> <?=h($numret)?> &nbsp;&nbsp;|&nbsp;&nbsp; 
                <b>Fecha Comprobante:</b> <?=h($fechaComprobanteFormat)?> &nbsp;&nbsp;|&nbsp;&nbsp; 
                <b>Fecha Factura:</b> <?=h($fechaFactura)?>
            </div>
            
            <table class="bordes-impresion" style="width: 100%; border-collapse: collapse; font-size: 12px; margin-bottom: 15px;">
                <tr>
                    <th style="width: 50%; border: 1px solid #bbb; background: #f3f3f3; padding: 6px; text-align: left;">Agente de Retención</th>
                    <th style="width: 50%; border: 1px solid #bbb; background: #f3f3f3; padding: 6px; text-align: left;">Sujeto Retenido</th>
                </tr>
                <tr>
                    <td style="border: 1px solid #bbb; padding: 6px; vertical-align: top; line-height: 1.4;">
                        <b>Nombre:</b> <?=h($agente['comercio'] ?? '')?><br>
                        <b>RIF:</b> <?=h($agente['IDFiscal'] ?? '')?><br>
                        <b>Dirección:</b> <?=h($agente['direccion'] ?? '')?><br>
                        <b>Teléfono:</b> <?=h($agente['Telefono'] ?? '')?><br>
                        <b>Correo:</b> <?=h($agente['correorep'] ?? '')?>
                    </td>
                    <td style="border: 1px solid #bbb; padding: 6px; vertical-align: top; line-height: 1.4;">
                        <b>Nombre:</b> <?=h($prov['Nombre'] ?? '')?><br>
                        <b>RIF:</b> <?=h($prov['RUT'] ?? '')?><br>
                        <b>Dirección:</b> <?=h($prov['Direccion'] ?? '')?><br>
                        <b>Clasificación Fiscal:</b> <?=h($badgeTipoLargo)?>
                    </td>
                </tr>
            </table>

            <div style="font-size: 13px; margin-bottom: 5px;"><b>Datos de la Transacción:</b></div>
            <table class="bordes-impresion" style="width: 100%; border-collapse: collapse; font-size: 11px; margin-bottom: 15px; text-align: center;">
                <thead style="background-color: #f3f3f3;">
                    <tr>
                        <th style="border: 1px solid #bbb; padding: 5px;">N° Control</th>
                        <th style="border: 1px solid #bbb; padding: 5px;">Nro Factura</th>
                        <th style="border: 1px solid #bbb; padding: 5px;">Cód. SENIAT</th>
                        <th style="border: 1px solid #bbb; padding: 5px; text-align: left;">Concepto</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="border: 1px solid #bbb; padding: 5px;"><?=h($numctrol !== '' ? $numctrol : '0')?></td>
                        <td style="border: 1px solid #bbb; padding: 5px;"><?=h($refTx !== '' && $refTx !== '0' ? $refTx : $docInterno)?></td>
                        <td style="border: 1px solid #bbb; padding: 5px; font-weight: bold; text-transform: uppercase;"><?=h($codSeniat)?></td>
                        <td style="border: 1px solid #bbb; padding: 5px; text-align: left;"><?=h($conceptoNombre)?></td>
                    </tr>
                </tbody>
            </table>

            <div style="font-size: 13px; margin-bottom: 5px;"><b>Detalle del Cálculo de Retención:</b></div>
            <table class="bordes-impresion" style="width: 100%; border-collapse: collapse; font-size: 11px; text-align: center;">
                <thead style="background-color: #f3f3f3;">
                    <tr>
                        <th style="border: 1px solid #bbb; padding: 5px;">Base Imponible de Factura</th>
                        <th style="border: 1px solid #bbb; padding: 5px;">Base Ret.</th>
                        <th style="border: 1px solid #bbb; padding: 5px;">% Ret.</th>
                        <th style="border: 1px solid #bbb; padding: 5px;">Sustraendo</th>
                        <th style="border: 1px solid #bbb; padding: 5px; font-size: 12px;">Retención</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="border: 1px solid #bbb; padding: 5px;"><?=fmt_money($calc['baseFiscal'])?></td>
                        <td style="border: 1px solid #bbb; padding: 5px;"><?=fmt_money($calc['baseRet'])?></td>
                        <td style="border: 1px solid #bbb; padding: 5px;"><?=h($calc['tarifaEf'])?> %</td>
                        <td style="border: 1px solid #bbb; padding: 5px;"><?=fmt_money($calc['SUST'])?></td>
                        <td style="border: 1px solid #bbb; padding: 5px; font-weight: bold; font-size: 13px;"><?=fmt_money($calc['retencion'])?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="margin-top: auto; padding-top: 40px;">
            <table style="width: 100%; font-size: 12px; text-align: center; border:none;">
                <tr>
                    <td style="width: 50%; vertical-align: bottom; border:none;">
                        <div style="width: 70%; margin: 0 auto; position: relative;">
                            <img src="./img/img11.png" style="width: 160px; mix-blend-mode: multiply; margin-bottom: -8px; position: relative; z-index: 0;">
                            <div style="border-top: 1px solid #000; padding-top: 5px; font-weight: bold; text-transform: uppercase; position: relative; z-index: 1;">AGENTE DE RETENCIÓN</div>
                        </div>
                    </td>
                    
                    <td style="width: 50%; vertical-align: bottom; border:none;">
                        <div style="width: 70%; margin: 0 auto;">
                            <div style="height: 60px;"></div> 
                            <div style="border-top: 1px solid #000; padding-top: 5px; font-weight: bold; text-transform: uppercase;">SUJETO RETENIDO</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

    </div>
</div>

<script>
// COMO ESTE ARCHIVO ES SOLO VISUAL Y PARA IMPRIMIR, SE LANZA DIRECTO:
window.onload = function() {
    setTimeout(function() {
        window.print();
    }, 500);
};
</script>