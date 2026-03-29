<?php
/**
 * retension_islr.php (Manejo VZLA Blindado y Limpio)
 * - Render para modal Bootstrap (AJAX): selector de concepto (NumLit), fecha editable
 * - Permite editar Base de Retención manualmente y avisa si ya existen retenciones.
 * - Tablas simplificadas, columnas innecesarias removidas y firmas ancladas al final.
 *
 * Requiere: conectar() que retorne mysqli
 */

use function PHPSTORM_META\elementType;

ini_set('display_errors', '0');
ini_set('log_errors', '1');

include 'ambienteconsultas.php';

function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function post($k, $default=null){ return isset($_POST[$k]) ? $_POST[$k] : $default; }

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
// Formato Venezuela para cálculos visuales y PDF
function fmt_money($n){ return number_format((float)$n, 2, ',', '.'); }
// Formato plano para inputs HTML5 de tipo number
function fmt_input($n){ return number_format((float)$n, 2, '.', ''); }

function die_html($title, $msg){
  echo "<div class='p-3'>";
  echo "<div class='d-flex align-items-center justify-content-between mb-2'>";
  echo "<div class='h5 mb-0'>".h($title)."</div>";
  echo "</div>";
  echo "<div class='alert alert-danger mb-0'>".h($msg)."</div>";
  echo "</div>";
  exit;
}

/**
 * Decide columna según TipoBenef
 * PNRE | PNNR | PJDOM | PJNDOM
 */
function map_tipoBenef($tipoBenef){
  $tb = strtoupper(trim((string)$tipoBenef));
  $valid = ["PNDOM","PNNDOM","PJDOM","PJNDOM"];
  // Si no es válido, devolvemos 'DESCONOCIDO' en vez de forzar 'PNRE'
  //if (!in_array($tb, $valid, true)) return "DESCONOCIDO"; 
  return $tipoBenef;
}

function calc_retencion($tx, $prov, $regla, $utve = 43, $bff=0){
  if ($bff==0){
    $imponible = (float)$tx['imponible'];
    $exento    = (float)$tx['excento'];

    $baseFiscal = $imponible + $exento; 
  }else{
    $baseFiscal = (float)$bff;
  }
  

  $tipoBenef = map_tipoBenef($prov['TipoPersona'] . $prov['Domicilio']);

  $BI = 0.0; $TAR = 0.0; $PM = 0.0; $SUST = 0.0; $COD=''; $PA = 0.0;

  switch($tipoBenef){
    case 'PNDOM':
      $BI   = (float)$regla['PNREBI'];
      $TAR  = (float)$regla['PNRETAR'];
      $PM   = (float)$regla['PNREPM'];
      $SUST = (float)$regla['PNRESUST'];
      $COD  = (string)$regla['PNRECOD'];
      $PA   = 0.0;
      break;

    case 'PNNDOM':
      $BI   = (float)$regla['PNNRBI'];
      $TAR  = (float)$regla['PNNRTAR'];
      $PM   = (float)$regla['PNNRBIPA'];
      $SUST = (float)$regla['PNNRSUS'];
      $COD  = (string)$regla['PNNRCOD'];
      $PA   = 0.0;
      break;

    case 'PJDOM':
      $BI   = (float)$regla['PJDOMBI'];
      $TAR  = (float)$regla['PJDOMTAR'];
      $PM   = 0.0;
      $SUST = 0.0;
      $COD  = (string)$regla['PJDOMCOD'];
      $PA   = (float)$regla['PJDOMPA'];
      break;

    case 'PJNDOM':
      $BI   = (float)$regla['PJNDOMBI'];
      $TAR  = (float)$regla['PJNDOMTAR'];
      $PM   = 0.0;
      $SUST = 0.0;
      if (($baseFiscal* $BI)>=0 && ($baseFiscal* $BI)<=(2000*$utve)) {
          $PM   = 0;
          $TAR = 0.15;
          $SUST = 0.0;
      }
      if (($baseFiscal* $BI)>(2000*$utve) && ($baseFiscal* $BI)<=(3000*$utve)) {
          $PM   =0;
          
          $TAR = 0.22;
          $SUST = 140*$utve;
      }
      if (($baseFiscal* $BI)>(3000*$utve)) {
          $PM   =0;
          
          $TAR = 0.34;
          $SUST = 500*$utve;
      }
      $COD  = (string)$regla['PJNDOMCOD'];
      $PA   = (float)$regla['PJNDOMPA'];
      break;
  }

  $baseRet = $baseFiscal * $BI;

  $tarifaEf = $TAR;
  if ($PA > 0) $tarifaEf = $TAR * (1.0 + ($PA / 100.0));

  if ($PM > 0 && $baseRet > 0 && $baseRet < $PM) {
    return [
      'tipoBenef'  => $tipoBenef,
      'imponible'  => $imponible,
      'exento'     => $exento,
      'baseFiscal' => $baseFiscal,
      'BI' => $BI,
      'baseRet' => $baseRet,
      'TAR' => $TAR,
      'PA' => $PA,
      'tarifaEf' => $tarifaEf,
      'SUST' => $SUST,
      'PM' => $PM,
      'COD' => $COD,
      'retencion' => 0.0,
      'retencion_raw' => 0.0,
      'nota' => 'Base menor al mínimo/umbral → Retención = 0'
    ];
  }

  $retRaw = ($baseRet * $tarifaEf);
  $ret = $retRaw - $SUST;
  if ($ret < 0) $ret = 0.0;

  return [
    'tipoBenef' => $tipoBenef,
    'imponible' => $imponible,
    'exento' => $exento,
    'baseFiscal' => $baseFiscal,
    'BI' => $BI,
    'baseRet' => $baseRet,
    'TAR' => $TAR,
    'PA' => $PA,
    'tarifaEf' => $tarifaEf,
    'SUST' => $SUST,
    'PM' => $PM,
    'COD' => $COD,
    'retencion' => $ret,
    'retencion_raw' => $retRaw,
    'nota' => ''
  ];
}

function next_numret(mysqli $cn, $IdCompany, $FechaRet){
  $year = (int)substr($FechaRet, 0, 4);
  $sql = "
    SELECT LPAD(IFNULL(MAX(CAST(Referencia AS UNSIGNED)),0)+1, 11, '0') AS nxt
    FROM posuptxp
    WHERE IdCompany = ?
      AND tiporetencion = 1
      AND YEAR(TxfecVence) = ?
      AND Referencia REGEXP '^[0-9]+$'
  ";
  $stmt = $cn->prepare($sql);
  $stmt->bind_param('ii', $IdCompany, $year);
  $stmt->execute();
  $row = $stmt->get_result()->fetch_assoc();
  $stmt->close();
  return ($row && $row['nxt']) ? $row['nxt'] : '00000000001';
}

function posuptxp_columns(mysqli $cn){
  static $cols = null;
  if ($cols !== null) return $cols;
  $cols = [];
  $sql = "SELECT COLUMN_NAME
          FROM INFORMATION_SCHEMA.COLUMNS
          WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'posuptxp'";
  if ($res = $cn->query($sql)) {
    while ($row = $res->fetch_assoc()) {
      $cols[strtolower($row['COLUMN_NAME'])] = true;
    }
    $res->free();
  }
  return $cols;
}

function insert_retencion_posuptxp(
  mysqli $cn,
  $IdCompany, $IdTipoTx, $IdTx, $IdEstacion,
  $FechaRet,
  $montoBCV, // <--- Bolívares
  $montoUSD, // <--- Dólares
  $tasaTx,
  $tipoRetencion,
  $numLit,
  $numComprobante,
  $dAmpliado = ''
){
  $sqlItem = "
    SELECT IFNULL(MAX(Item),0)+1 AS nxt
    FROM posuptxp
    WHERE IdCompany=? AND Idtipotx=? AND Idtx=? AND IdEstacion=?
  ";
  $st = $cn->prepare($sqlItem);
  $st->bind_param('iiis', $IdCompany, $IdTipoTx, $IdTx, $IdEstacion);
  $st->execute();
  $r = $st->get_result()->fetch_assoc();
  $st->close();
  $item = (int)($r['nxt'] ?? 1);

  $cols = posuptxp_columns($cn);

  $insertCols = [
    'IdCompany','Idtipotx','Idtx','IdEstacion','Item',
    'Fectxserver','Fectxclient',
    'MontoPagar','Contado','Credito','Efectivo','Vuelto',
    'Tarjeta','TarjetaD','Cheque','ChequeD',
    'Tipo01','Tipo01D','Tipo02','Tipo02D','Tipo03','Tipo03D','Tipo04','Tipo04D',
    'Login','IdcompanyUser','IdResponsable','Caja',
    'tasa','TxfecVence'
  ];

  $extras = [];
  if (isset($cols['montoretencion'])) $extras[] = 'montoretencion';
  if (isset($cols['tiporetencion']))  $extras[] = 'tiporetencion';
  if (isset($cols['numret']))         $extras[] = 'numret';
  if (isset($cols['referencia']))     $extras[] = 'Referencia';
  if (isset($cols['dampliado']))      $extras[] = 'DAmpliado';

  foreach ($extras as $c) $insertCols[] = $c;

  $valuesSql = [];
  foreach ($insertCols as $c) {
    if ($c === 'Fectxserver' || $c === 'Fectxclient') $valuesSql[] = 'NOW()';
    else $valuesSql[] = '?';
  }

  $sqlIns = "INSERT INTO posuptxp (".implode(',', $insertCols).") VALUES (".implode(',', $valuesSql).")";
  $stmt = $cn->prepare($sqlIns);
  if (!$stmt) throw new Exception("Error prepare posuptxp: ".$cn->error);

  $params = [];
  $types  = '';

  $push = function($type, $val) use (&$types, &$params){
    $types .= $type;
    $params[] = $val;
  };

  $push('i', (int)$IdCompany);
  $push('i', (int)$IdTipoTx);
  $push('i', (int)$IdTx);
  $push('s', (string)$IdEstacion);
  $push('i', (int)$item);

  // ¡LA CORRECCIÓN ESTÁ AQUÍ!
  $push('d', (float)$montoBCV); // MontoPagar en Bolívares
  $push('d', 0); // Contado DEBE SER CERO
  $push('d', 0); $push('d', 0); $push('d', 0); // Credito, Efectivo, Vuelto
  $push('d', 0); $push('s', ''); $push('d', 0); $push('s', '');
  $push('d', 0); $push('s', ''); $push('d', 0); $push('s', ''); $push('d', 0); $push('s', ''); $push('d', 0); $push('s', '');
  $push('s', ''); $push('i', 0); $push('s', ''); $push('i', 1);

  $push('d', (float)$tasaTx);
  $push('s', (string)$FechaRet);

  foreach ($extras as $c) {
    $lc = strtolower($c);
    if ($lc === 'montopagar')         $push('d', (float)$montoBCV); // Bolívares
    elseif ($lc === 'montoretencion') $push('d', (float)$montoUSD); // Dólares a la retención
    elseif ($lc === 'tiporetencion')  $push('i', (int)$tipoRetencion);
    elseif ($lc === 'numret')         $push('s', (string)$numLit);
    elseif ($lc === 'referencia')     $push('s', (string)$numComprobante);
    elseif ($lc === 'dampliado')      $push('s', (string)$dAmpliado);
    else $push('s', '');
  }

  $bindNames = [];
  $bindNames[] = $types;
  for ($i=0; $i<count($params); $i++){
    $bindNames[] = &$params[$i];
  }
  call_user_func_array([$stmt, 'bind_param'], $bindNames);

  $ok = $stmt->execute();
  $err = $stmt->error;
  $stmt->close();

  if (!$ok) throw new Exception("Error insertando retención (posuptxp): ".$err);

  return $item;
}

/* =======================
   INPUT
======================= */

$IdCompany  = as_int(post('IdCompany'));
$IdTipoTx   = as_int(post('IdTipoTx'));
$IdTx       = as_bigint(post('IdTx'));
$IdEstacion = as_str(post('IdEstacion'));

$NumLit     = as_str(post('NumLit'));
$FechaRet   = as_date(post('FechaRet'));
$CustomBaseRet = as_str(post('CustomBaseRet', '')); 
$do         = as_str(post('do', 'preview')); // preview | process

if ($IdCompany <= 0 || $IdTipoTx <= 0 || $IdTx <= 0 || $IdEstacion === '') {
  die_html('Retención ISLR', 'Faltan parámetros base. Requiere: IdCompany, IdTipoTx, IdTx, IdEstacion.');
}
if ($FechaRet === '') {
  $FechaRet = date('Y-m-d');
}

$cn = conectar();
if (!$cn || $cn->connect_error) {
  die_html('Retención ISLR', 'No hay conexión a BD.');
}
$cn->set_charset('utf8');

/* =======================
   VERIFICAR SI YA EXISTE RETENCIÓN PARA ESTA FACTURA
======================= */
$sqlExist = "SELECT COUNT(*) as cant FROM posuptxp WHERE IdCompany=? AND Idtipotx=? AND Idtx=? AND IdEstacion=? AND tiporetencion=1";
$stExist = $cn->prepare($sqlExist);
$stExist->bind_param('iiis', $IdCompany, $IdTipoTx, $IdTx, $IdEstacion);
$stExist->execute();
$rowExist = $stExist->get_result()->fetch_assoc();
$existingCount = (int)$rowExist['cant'];
$stExist->close();

/* =======================
   LOAD TX (incluye tasa TX)
======================= */

$sqlTx = "
  SELECT
    IdBen,
    tasa AS tasa_tx,
    imponible * tasa AS imponible,
    excento * tasa AS excento,
    impuesto * tasa AS impuesto,
    totalimp * tasa AS totalimp,
    Total * tasa AS Total,
    SubTotal * tasa AS SubTotal,
    Dcto * tasa AS Dcto,
    numctrol,
    prefijo,
    Referencia,
    Fectxclient
  FROM posuptxc
  WHERE IdCompany=? AND Idtipotx=? AND Idtx=? AND IdEstacion=?
  LIMIT 1
";
$st = $cn->prepare($sqlTx);
$st->bind_param('iiis', $IdCompany, $IdTipoTx, $IdTx, $IdEstacion);
$st->execute();
$tx = $st->get_result()->fetch_assoc();
$st->close();

if (!$tx) {
  die_html('Retención ISLR', 'No encontré la transacción en posuptxc con esos datos.');
}

$IdBen = trim((string)$tx['IdBen']);
if ($IdBen === '') {
  die_html('Retención ISLR', 'La TX no tiene IdBen (proveedor/beneficiario) en posuptxc.');
}

$tasaTx = (float)($tx['tasa_tx'] ?? 1);
$fechaFactura = date('d/m/Y', strtotime($tx['Fectxclient']));
$fechaComprobanteFormat = date('d/m/Y', strtotime($FechaRet));

/* =======================
   LOAD PROV (posupclientes)
======================= */

$sqlProv = "
  SELECT RUT, Nombre, Direccion, TipoBenef, TipoPersona, Domicilio
  FROM posupclientes
  WHERE IdCompany=? AND RUT=?
  LIMIT 1
";
$st = $cn->prepare($sqlProv);
$st->bind_param('is', $IdCompany, $IdBen);
$st->execute();
$prov = $st->get_result()->fetch_assoc();
$st->close();

if (!$prov) {
  die_html('Retención ISLR', 'No encontré el proveedor en posupclientes (RUT = IdBen).');
}

// 1. Extraemos TipoPersona y Domicilio de la base de datos de forma segura
// 1. Extraemos ESTRICTAMENTE lo que dice la tabla posupclientes
$tp  = isset($prov['TipoPersona']) ? strtoupper(trim((string)$prov['TipoPersona'])) : '';
$dom = isset($prov['Domicilio'])   ? strtoupper(trim((string)$prov['Domicilio'])) : '';

// 2. Asignamos el código basado únicamente en la base de datos
if ($tp === 'PN' && $dom === 'DOM')  { 
    $prov['TipoBenef'] = 'PNRE'; 
} elseif ($tp === 'PN' && $dom === 'NDOM') { 
    $prov['TipoBenef'] = 'PNNR'; 
} elseif ($tp === 'PJ' && $dom === 'DOM')  { 
    $prov['TipoBenef'] = 'PJDOM'; 
} elseif ($tp === 'PJ' && $dom === 'NDOM') { 
    $prov['TipoBenef'] = 'PJNDOM'; 
}

$badgeTipo = map_tipoBenef($prov['TipoBenef']);

$colCodSeniat = 'CSPNR'; // Por defecto
switch ($badgeTipo) {
    case 'PNRE':   $colCodSeniat = 'CSPNR'; break;
    case 'PNNR':   $colCodSeniat = 'CSPNNR'; break;
    case 'PJDOM':  $colCodSeniat = 'CSPJDOM'; break;
    case 'PJNDOM': $colCodSeniat = 'CSPJNDOM'; break;
}

/* =======================
   LOAD COMPANY (Agente de Retencion)
======================= */
$agente = [
    'comercio' => 'Empresa Desconocida',
    'IDFiscal' => '',
    'direccion' => '',
    'correorep' => '',
    'Telefono' => '',
    'UTVE' => '43'
];

$sqlCompany = "SELECT comercio, IDFiscal, direccion, correorep, Telefono, UTVE FROM PosUpCompany WHERE Id=? LIMIT 1";
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

/* =======================
   LOAD CONCEPTOS (posupretencion) FILTRADOS
======================= */

$conceptos = [];
$validNumLits = [];

$sqlConceptos = "
  SELECT NumLit, Nombre
  FROM posupretencion
  WHERE IdCompany=? AND TipoRet=1
  ORDER BY NumLit
";
//$prov['RUT']
$sqlConceptos = "
  SELECT r.NumLit, r.Nombre
  FROM posup.posupretencion r
  JOIN posup.posupclientes c
      ON c.IdCompany = r.IdCompany
  WHERE c.IdCompany = ?
    AND c.RUT = ?
    AND (
          (c.TipoPersona = 'PN' AND c.Domicilio = 'DOM'    AND IFNULL(TRIM(r.CSPNR), '')   <> '')
      OR (c.TipoPersona = 'PN' AND c.Domicilio IN ('NDOM','NODOM') AND IFNULL(TRIM(r.CSPNNR), '') <> '')
      OR (c.TipoPersona = 'PJ' AND c.Domicilio = 'DOM'    AND IFNULL(TRIM(r.CSPJDOM), '') <> '')
      OR (c.TipoPersona = 'PJ' AND c.Domicilio IN ('NDOM','NODOM') AND IFNULL(TRIM(r.CSPJNDOM), '') <> '')
    );
";

$st = $cn->prepare($sqlConceptos);
$st->bind_param('is', $IdCompany,$prov['RUT']);
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

/* =======================
   LOAD REGLA ACTUAL
======================= */

$regla = null;
if ($NumLit !== '') {
  $sqlReg = "
    SELECT *
    FROM posupretencion
    WHERE IdCompany=? AND TipoRet=1 AND NumLit=?
    LIMIT 1
  ";
  $st = $cn->prepare($sqlReg);
  $st->bind_param('is', $IdCompany, $NumLit);
  $st->execute();
  $regla = $st->get_result()->fetch_assoc();
  $st->close();
}

if (!$regla) {
  die_html('Retención ISLR', "No encontré la reglapara NumLit='".h($NumLit)."' (TipoRet=1).");
}

$calc = calc_retencion($tx, $prov, $regla);

/* =======================
   BLINDAJE VZLA: REESCRIBIR BASE DE RETENCIÓN SI FUE EDITADA MANUALMENTE
======================= */
if ($CustomBaseRet !== '') {
    $cleanedBase = str_replace('.', '', $CustomBaseRet); // Quita dots (miles)
    $cleanedBase = str_replace(',', '.', $cleanedBase); // Cambia coma por dot (decimal)

    if (is_numeric($cleanedBase)) {
        $calc = calc_retencion($tx, $prov, $regla,43, $cleanedBase);
        $calc['baseRet'] = (float)$cleanedBase;
        
        $retRaw = ($calc['baseRet'] * $calc['tarifaEf']);
        $ret = $retRaw - $calc['SUST'];
        if ($ret < 0) $ret = 0.0;

        if ($calc['PM'] > 0 && $calc['baseRet'] > 0 && $calc['baseRet'] < $calc['PM']) {
            $calc['retencion'] = 0.0;
            $calc['retencion_raw'] = 0.0;
            $calc['nota'] = 'Base menor al mínimo/umbral → Retención = 0';
        } else {
            
            $calc['retencion'] = $ret;
            $calc['retencion_raw'] = $retRaw;
            $calc['nota'] = 'Calculado con base editada manualmente';
        }
    }
}

/* =======================
   PRECALC N° RET (SIEMPRE) -> correlativo numérico (se guardará en Referencia)
======================= */

$preNumRet = next_numret($cn, $IdCompany, $FechaRet);

// Alias para UI/impresión
$numret = $preNumRet;

/* =======================
   PROCESS
======================= */

$procesado = false;
$procesar_msg = '';
$itemInserted = null;
$numret = null;

if ($do === 'process') {
  if ((float)$calc['retencion'] <= 0) {
    $procesado = false;
    $procesar_msg = 'Retención calculada = 0.00. No se guarda registro (según tu regla).';
  } else {
    $cn->begin_transaction();
    try {
      $numComprobante = next_numret($cn, $IdCompany, $FechaRet);
      $numret = $numComprobante;

      $tipoRetencion = 1;          // ISLR
      $numLitSave    = $NumLit;    // ej: 9.1.a
      $tasaGuardar   = (float)$tasaTx;

      // Separamos la lógica de monedas
      $montoBCV = (float)$calc['retencion'];
      $montoUSD = $tasaGuardar > 0 ? ($montoBCV / $tasaGuardar) : $montoBCV;

      $itemInserted = insert_retencion_posuptxp(
        $cn,
        $IdCompany, $IdTipoTx, $IdTx, $IdEstacion,
        $FechaRet,
        $montoBCV, // Bolívares
        $montoUSD, // Dólares
        $tasaGuardar,
        $tipoRetencion,
        $numLitSave,
        $numComprobante,
        json_encode($calc, JSON_UNESCAPED_UNICODE) 
      );
        
      $cn->commit();
      $procesado = true;
      $procesar_msg = "Retención guardada exitosamente. Item={$itemInserted}, N° Comprobante={$numComprobante}.";
      
      $existingCount++; 
    } catch (Throwable $e) {
      $cn->rollback();
      $procesado = false;
      $procesar_msg = 'No se pudo procesar: '.$e->getMessage();
    }
  }
}

/* =======================
   BUSCAR FORMATO PERSONALIZADO (FormaISLR)
======================= */
$FormaISLR = '';

// Intento 1: Búsqueda por el Token de la estación actual
$sqlForma = "SELECT a.FormaISLR 
             FROM PosUpAlmacen a 
             INNER JOIN posupcompanyestacion p ON a.IdCompany = p.IdCompany AND a.IdAlm = p.IdAlmVta
             WHERE a.IdCompany=? AND p.token=? LIMIT 1";
$stF = $cn->prepare($sqlForma);
if ($stF) {
    $stF->bind_param('is', $IdCompany, $IdEstacion);
    $stF->execute();
    $resF = $stF->get_result()->fetch_assoc();
    if ($resF && isset($resF['FormaISLR']) && trim($resF['FormaISLR']) !== '') {
        $FormaISLR = trim((string)$resF['FormaISLR']);
    }
    $stF->close();
}

// Intento 2 (EL SALVAVIDAS): Si falló lo anterior, busca cualquiera de esa empresa
if ($FormaISLR === '') {
    $sqlFallback = "SELECT FormaISLR FROM PosUpAlmacen WHERE IdCompany=? AND FormaISLR IS NOT NULL AND FormaISLR != '' LIMIT 1";
    $stFB = $cn->prepare($sqlFallback);
    if ($stFB) {
        $stFB->bind_param('i', $IdCompany);
        $stFB->execute();
        $resFB = $stFB->get_result()->fetch_assoc();
        if ($resFB && isset($resFB['FormaISLR']) && trim($resFB['FormaISLR']) !== '') {
            $FormaISLR = trim((string)$resFB['FormaISLR']);
        }
        $stFB->close();
    }
}
/* =======================
   OUTPUT Y PREPARACIÓN DE VARIABLES
======================= */

$conceptoNombre = trim((string)$regla['Nombre']);
$codigoRet = $calc['COD'] !== '' ? $calc['COD'] : '';

$nombresBenef = [
    'PNRE' => 'Persona Natural Residenciada',
    'PNNR' => 'Persona Natural No Residenciada',
    'PJDOM' => 'Persona Jurídica Domiciliada',
    'PJNDOM' => 'Persona Jurídica No Domiciliada'
];
$badgeTipoLargo = isset($nombresBenef[$badgeTipo]) ? $nombresBenef[$badgeTipo] : $badgeTipo;

$codSeniat = isset($regla[$colCodSeniat]) ? $regla[$colCodSeniat] : '';
$codSeniat = trim($codSeniat);
if ($codSeniat === '') {
    $codSeniat = 'SIN CÓDIGO'; 
}

$prefijo = trim((string)($tx['prefijo'] ?? ''));
$numctrol = trim((string)($tx['numctrol'] ?? ''));
$refTx = trim((string)($tx['Referencia'] ?? '')); // Nro de Factura

$docInterno = (string)$IdTx;
if ($prefijo !== '') {
    $docInterno = $prefijo . '-' . $docInterno;
}

$elementos = [];
if ($refTx !== '') {
    $elementos[] = "Nro Factura: " . $refTx;
} elseif ($numctrol !== '') {
    $elementos[] = "Nro Ctrl: " . $numctrol;
} else {
    $elementos[] = "Nro Doc: " . $docInterno;
}
$docFull = implode(' | ', $elementos);

$msgClass = 'alert-info';
if ($procesar_msg !== '') {
  if ($procesado) $msgClass = 'alert-success';
  else if ((float)$calc['retencion'] <= 0) $msgClass = 'alert-warning';
  else $msgClass = 'alert-danger';
}

?>

<style>
  .islr-kv{font-size:.80rem;color:#6c757d;text-transform:uppercase;letter-spacing:.02em}
  .islr-v{font-weight:600}
  .islr-soft{background:rgba(0,0,0,.03);border-radius:.75rem}
  .islr-table td,.islr-table th{vertical-align:middle}
  .islr-mono{font-family:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace}
</style>

<div class="p-3">

  <?php if ($existingCount > 0 && $procesado === false): ?>
    <div class="alert alert-warning py-2 mb-3 shadow-sm border-warning">
      <i class="fa fa-exclamation-triangle me-1"></i> <b>¡Aviso!</b> Ya existe(n) <b><?=$existingCount?></b> retención(es) de ISLR guardada(s) para esta transacción.
    </div>
  <?php endif; ?>

  <?php if ($procesar_msg !== ''): ?>
    <div class="alert <?=h($msgClass)?> py-2 mb-3">
      <?=h($procesar_msg)?>
    </div>
  <?php endif; ?>

  <div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
      <div class="row g-3">
        <div class="col-lg-6">
          <div class="islr-soft p-3">
            <div class="text-end">
                <div class="islr-kv">Pre-N° Retención</div>
                <div class="islr-v islr-mono"><?=h($procesado ? $numret : $preNumRet)?></div>
            </div>
            <!--<div class="text-end">
                <div class="islr-kv">Unidad Tributaria</div>
                <div class="islr-v islr-mono"><?=h($agente['UTVE'] ?? '')?></div>
            </div>-->
            <div class="text-muted small mt-1">
              <span class="badge bg-light text-dark border"><span class="islr-mono"><?=h($docFull)?></span></span>
            </div>
            <div class="islr-kv">Proveedor / Sujeto retenido</div>
            <div class="islr-v"><?=h($prov['Nombre'])?></div>
            <div class="text-muted small">RIF: <span class="islr-mono"><?=h($prov['RUT'])?></span></div>
            <div class="mt-2">
              <span class="badge bg-dark text-white"><?=h($badgeTipoLargo)?></span>
              <span class="badge bg-dark text-white ms-1">Cód. SENIAT: <?=h($codSeniat)?></span>
              <span class="badge bg-dark text-white ms-1">Tasa TX: <span class="islr-mono"><?=h($tasaTx)?></span></span>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="row g-3">
            <div class="col-12">
              <label class="form-label mb-1">Concepto / NumLit</label>
              <select id="islr_NumLit" class="form-select form-select-sm">
                <?php foreach($conceptos as $c):
                  $v = (string)$c['NumLit'];
                  $n = (string)$c['Nombre'];
                  $sel = ($v === (string)$NumLit) ? 'selected' : '';
                ?>
                  <option value="<?=h($v)?>" <?=$sel?>><?=h($v)?> — <?=h($n)?></option>
                <?php endforeach; ?>
              </select>
              <div class="form-text">Selecciona el concepto y se recalcula automáticamente.</div>
            </div>

            <div class="col-md-6">
              <label class="form-label mb-1">Fecha retención</label>
              <input id="islr_FechaRet" type="date" class="form-control form-control-sm" value="<?=h($FechaRet)?>">
              <div class="form-text">Puedes ajustarla antes de guardar.</div>
            </div>

            <div class="col-md-6">
              <label class="form-label mb-1">N° Retención (pre)</label>
              <input type="text" class="form-control form-control-sm islr-mono" value="<?=h($procesado ? $numret : $preNumRet)?>" disabled>
              <div class="form-text">Se genera por año (Company + ISLR) usando Referencia.</div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-sm table-striped islr-table mb-0">
          <thead>
            <tr>
              <th>Dato</th>
              <th class="text-end" style="width: 30%;">Valor (Bs)</th>
              <th class="text-muted">Cómo se usó</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="align-middle">Monto Imponible (TX)</td>
              <td class="text-end align-middle islr-mono"><?=fmt_money($calc['imponible'])?></td>
              <td class="text-muted align-middle">Base para cálculo</td>
            </tr>
            <tr>
              <td class="align-middle">Monto Exento (TX)</td>
              <td class="text-end align-middle islr-mono"><?=fmt_money($calc['exento'])?></td>
              <td class="text-muted align-middle">También se suma para base fiscal</td>
            </tr>
            <tr>
              <td class="align-middle">Base Imponible de Factura</td>
              <td class="text-end align-middle islr-mono"><?=fmt_money($calc['baseFiscal'])?></td>
              <td class="text-muted align-middle">BaseImponible = imponible + exento</td>
            </tr>
            
            <tr class="table-primary">
              <td class="align-middle fw-bold">Base de Retención</td>
              <td class="text-end">
                <input type="text" class="form-control form-control-sm text-end islr-mono fw-bold text-primary" id="islr_CustomBaseRet" value="<?=fmt_money($calc['baseRet'])?>">
              </td>
              <td class="text-muted align-middle"><i class="fa fa-pencil text-primary"></i> Editable (Modifique VZLA y presione Recalcular)</td>
            </tr>
            <tr>
              <td class="align-middle">% Ret.</td>
              <td class="text-end align-middle islr-mono"><?=h($calc['tarifaEf'])?></td>
              <td class="text-muted align-middle">La que se multiplica por la base</td>
            </tr>
            <tr>
              <td class="align-middle">Sustraendo</td>
              <td class="text-end align-middle islr-mono"><?=fmt_money($calc['SUST'])?></td>
              <td class="text-muted align-middle">Ret = (BaseRet * % Ret.) - Sustraendo</td>
            </tr>
            <tr>
              <td class="fw-bold align-middle fs-5">Retención Calculada</td>
              <td class="text-end fw-bold align-middle text-success islr-mono fs-5"><?=fmt_money($calc['retencion'])?></td>
              <td class="text-muted align-middle"><?=h($calc['nota'])?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="d-flex flex-wrap gap-2 justify-content-end">
    <button type="button" class="btn btn-sm btn-outline-secondary" id="islr_btnRecalc">
      <i class="fa fa-rotate-right me-1 p-1"></i>Recalcular
    </button>

    <button type="button" class="btn btn-sm btn-primary" id="islr_btnSave" <?=((float)$calc['retencion']<=0?'disabled':'')?> >
      <i class="fa fa-floppy-disk me-1 p-1"></i>Procesar (Guardar)
    </button>

    <?php if ($procesado): ?>
      <button type="button" class="btn btn-sm btn-outline-dark" onclick="islrPrint()">
        <i class="fa fa-print me-1 p-1"></i>Imprimir
      </button>
    <?php endif; ?>

    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-dismiss="modal">
      <i class="fa fa-xmark me-1 p-1"></i>Salir
    </button>
  </div>

  <?php if ($procesado): ?>
    <div class="mt-4" id="islr_print_area" style="display:none">
        
        <div style='margin: 0 auto; width: 100%; box-sizing: border-box; padding: 10mm; font-size: 11px; font-family: Arial, sans-serif; display: flex; flex-direction: column; min-height: 85vh;'>
            
            <div style="flex: 1;">
                <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                    <tr>
                        <td style="width: 15%; text-align: left; vertical-align: middle;">
                            <?php if ($Logotipo !== "" && $Logotipo !== null): ?>
                                <img src="<?= 'Comercio/' . $IdCompany . '/entorno/' . $Logotipo ?>" style="max-width: 80px; max-height: 80px;">
                            <?php else: ?>
                                <img src="img/logo.png" style="max-width: 80px; max-height: 80px;">
                            <?php endif; ?>
                        </td>
                        <td style="width: 85%; text-align: center; vertical-align: middle;">
                            <div style="font-size: 14px; font-weight:bold;">COMPROBANTE DE RETENCIÓN DEL IMPUESTO SOBRE LA RENTA</div>
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
                
                <table style="width: 100%; border-collapse: collapse; font-size: 12px; margin-bottom: 15px;">
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
                            <b>Correo:</b> <?=h($agente['correorep'] ?? '')?><br>
                            <b>Unidad Tributaria:</b> <?=h($agente['UTVE'] ?? '')?>
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
                <table style="width: 100%; border-collapse: collapse; font-size: 11px; margin-bottom: 15px; text-align: center;">
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
                            <td style="border: 1px solid #bbb; padding: 5px;"><?=h($numctrol !== '' ? $numctrol : '—')?></td>
                            <td style="border: 1px solid #bbb; padding: 5px;"><?=h($refTx !== '' ? $refTx : ($numctrol !== '' ? $numctrol : $docInterno))?></td>
                            <td style="border: 1px solid #bbb; padding: 5px; font-weight: bold; text-transform: uppercase;"><?=h($codSeniat)?></td>
                            <td style="border: 1px solid #bbb; padding: 5px; text-align: left;"><?=h($conceptoNombre)?></td>
                        </tr>
                    </tbody>
                </table>

                <div style="font-size: 13px; margin-bottom: 5px;"><b>Detalle del Cálculo de Retención:</b></div>
                <table style="width: 100%; border-collapse: collapse; font-size: 11px; text-align: center;">
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
                            <td style="border: 1px solid #bbb; padding: 5px;"><?=h($calc['tarifaEf'])?></td>
                            <td style="border: 1px solid #bbb; padding: 5px;"><?=fmt_money($calc['SUST'])?></td>
                            <td style="border: 1px solid #bbb; padding: 5px; font-weight: bold; font-size: 13px;"><?=fmt_money($calc['retencion'])?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div style="margin-top: auto; padding-top: 40px;">
                <table style="width: 100%; font-size: 12px; text-align: center;">
                    <tr>
                    <td style="width: 50%;">
                        <div style="border-top: 1px solid #000; width: 70%; margin: 0 auto; padding-top: 5px; font-weight: bold; text-transform: uppercase;">AGENTE DE RETENCIÓN</div>
                    </td>
                    <td style="width: 50%;">
                        <div style="border-top: 1px solid #000; width: 70%; margin: 0 auto; padding-top: 5px; font-weight: bold; text-transform: uppercase;">SUJETO RETENIDO</div>
                    </td>
                    </tr>
                </table>
            </div>

        </div>
    </div>
  <?php endif; ?>

</div>

<script>
var IslrHasExistingRet = <?= ($existingCount > 0 ? 'true' : 'false') ?>;


var IslrHasExistingRet = <?php echo ($existingCount > 0 ? 'true' : 'false'); ?>;
var FormaISLR = <?php echo json_encode(isset($FormaISLR) ? $FormaISLR : ''); ?>;
var PrintIdTx = <?php echo json_encode(isset($IdTx) ? $IdTx : ''); ?>;
var PrintIdCompany = <?php echo json_encode(isset($IdCompany) ? $IdCompany : ''); ?>;

// DEBUG PARA VER QUÉ ARCHIVO DETECTÓ
console.log("El formato personalizado detectado es: -> " + FormaISLR);

function islrPrint(){
  // 1. SI TIENE FORMATO PERSONALIZADO, ABRE LA PESTAÑA NUEVA
  if (FormaISLR && FormaISLR.trim() !== '') {
      var customUrl = FormaISLR.trim() + "?IdTx=" + PrintIdTx + "&IdCompany=" + PrintIdCompany;
      
      // Intentamos abrir en pestaña nueva
      var newWin = window.open(customUrl, '_blank');
      
      // Si el navegador bloqueó la pestaña (Popup Blocker), lo abrimos en la misma ventana
      if(!newWin || newWin.closed || typeof newWin.closed == 'undefined') { 
          window.location.href = customUrl;
      }
      return;
  }

  // 2. SI NO TIENE FORMATO, IMPRIME EL DISEÑO POR DEFECTO
  try {
    var area = document.getElementById('islr_print_area');
    if(!area) { 
        console.error("No se encontró el área de impresión");
        window.print(); 
        return; 
    }

    var w = window.open('', 'PRINT_ISLR', 'width=950,height=700');
    if(!w) {
        alert("Por favor, permite las ventanas emergentes (popups) en tu navegador para imprimir.");
        window.print();
        return;
    }

    var baseUrl = window.location.protocol + "//" + window.location.host + "/";

    w.document.open();
    w.document.write('<!doctype html><html><head><meta charset="utf-8">');
    w.document.write('<title>Comprobante Retención ISLR</title>');
    w.document.write('<base href="' + baseUrl + '">');
    w.document.write('<style>body{font-family:Arial,Helvetica,sans-serif;margin:0;padding:0;box-sizing:border-box;} @media print { @page { size: landscape; margin: 10mm; } body { -webkit-print-color-adjust: exact; print-color-adjust: exact; } } table{width:100%;border-collapse:collapse} th,td{border:1px solid #bbb;padding:6px;font-size:12px} th{background:#f3f3f3;text-align:left}</style>');
    w.document.write('</head><body>');
    w.document.write(area.innerHTML);
    w.document.write('</body></html>');
    w.document.close();

    setTimeout(function(){
        w.focus();
        w.print();
    }, 600);

  } catch(e) {
    console.error("Error en islrPrint:", e);
    window.print();
  }
}

(function(){
  if (typeof window.jQuery === 'undefined') return;

  function payload(doAction, clearBase = false){
    return {
      IdCompany: <?=json_encode($IdCompany)?>,
      IdTipoTx: <?=json_encode($IdTipoTx)?>,
      IdTx: <?=json_encode($IdTx)?>,
      IdEstacion: <?=json_encode($IdEstacion)?>,
      NumLit: $('#islr_NumLit').val(),
      FechaRet: $('#islr_FechaRet').val(),
      CustomBaseRet: clearBase ? '' : $('#islr_CustomBaseRet').val(),
      do: doAction
    };
  }

  function reload(doAction, clearBase = false){
    var $root = $('.modal.show .modal-body');
    if ($root.length === 0) $root = $(document.body);

    if(doAction === 'process') {
        $('#islr_btnSave').prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-1 p-1"></i> Procesando...');
    }

    $.ajax({
      type: 'POST',
      url: 'retension_islr.php',
      data: payload(doAction, clearBase),
      success: function(html){
        if ($('.modal.show .modal-body').length) {
          $('.modal.show .modal-body').html(html);
        } else {
          $root.html(html);
        }

        if (doAction === 'process' && $('#islr_print_area').length > 0) {
            
            IslrHasExistingRet = true; 

            $('.modal.show').modal('hide');

            function refrescarTablaFondo() {
                if ($.fn.DataTable && $.fn.DataTable.isDataTable('#estadocbtable')) {
                    $('#estadocbtable').DataTable().ajax.reload(null, false);
                } else if (typeof Buscar === 'function') {
                    Buscar();
                }
            }

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: "¡Retención Exitosa!",
                    html: "Se ha guardado y descontado correctamente del saldo.<br><br><b>¿Deseas imprimir el comprobante?</b>",
                    icon: "success",
                    showCancelButton: true,
                    confirmButtonText: '<i class="fa fa-print me-1"></i> Imprimir',
                    cancelButtonText: '<i class="fa fa-times me-1"></i> Cerrar',
                    customClass: {
                        confirmButton: 'btn btn-primary px-4',
                        cancelButton: 'btn btn-outline-secondary px-4 me-3'
                    },
                    buttonsStyling: false, 
                    reverseButtons: true,
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        islrPrint();
                    }
                    refrescarTablaFondo();
                });
            } else {
                if (confirm("¡Retención guardada con éxito!\n\n¿Deseas imprimir el comprobante ahora?")) {
                    islrPrint();
                }
                refrescarTablaFondo();
            }
        }
      },
      error: function(xhr){
        var msg = 'Error AJAX ('+xhr.status+').';
        if ($('.modal.show .modal-body').length) {
          $('.modal.show .modal-body').html('<div class="p-3"><div class="alert alert-danger">'+msg+'</div></div>');
        }
      }
    });
  }

  $(document).off('change.islr', '#islr_NumLit').on('change.islr', '#islr_NumLit', function(){
    reload('preview', true); 
  });

  $(document).off('change.islr', '#islr_FechaRet').on('change.islr', '#islr_FechaRet', function(){
    reload('preview', false);
  });

  $(document).off('click.islr', '#islr_btnRecalc').on('click.islr', '#islr_btnRecalc', function(){
    reload('preview', false);
  });

  $(document).off('click.islr', '#islr_btnSave').on('click.islr', '#islr_btnSave', function(){
    if (IslrHasExistingRet === true) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: "¡Atención!",
                text: "Ya existe una retención de ISLR para esta transacción. ¿Desea agregar una NUEVA retención?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, agregar nueva",
                cancelButtonText: "Cancelar",
                customClass: {
                    confirmButton: 'btn btn-warning px-4 text-dark',
                    cancelButton: 'btn btn-outline-secondary px-4 me-3'
                },
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    reload('process', false); 
                }
            });
        } else {
            if(confirm("Ya existe una retención para esta transacción. ¿Desea agregar una NUEVA?")) {
                reload('process', false);
            }
        }
    } else {
        reload('process', false);
    }
  });
})();
</script>