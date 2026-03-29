<?php

<?php
// ==============================================================================
// 1. INICIO DEL PORTERO: DESVÍO A FORMATO PERSONALIZADO (ISLR)
// ==============================================================================
// Aseguramos que la conexión esté disponible. Ajusta la ruta si es necesario.
if (!isset($conn) || !$conn) {
    include_once 'ambienteconsultas.php';
    $conn = conectar();
}

$IdCompany = isset($_POST['CompanyActual']) ? (int)$_POST['CompanyActual'] : 0;
$IdEstacion = isset($_POST['IdEstacion']) ? $_POST['IdEstacion'] : '';
$IdTx = isset($_POST['Idtx']) ? $_POST['Idtx'] : '';
$IdTipoTx = isset($_POST['Idtipotx']) ? $_POST['Idtipotx'] : '';

// Solo hacemos el desvío si es un tipo de transacción de Retención (ej. 7) y tenemos los datos.
// Ajusta el TipoTx si en tu base de datos el ISLR es otro número (ej. 7).
if ($IdCompany > 0 && $IdEstacion !== '') {
    
    // LA CONSULTA QUE ME DISTE (Adaptada a PHP Seguro)
    $sqlCustom = "SELECT a.FormaISLR 
                  FROM posupalmacen a 
                  INNER JOIN posupcompanyestacion p ON a.IdCompany = p.IdCompany AND a.IdAlm = p.IdAlmVta AND p.tipoestacion=999
                  WHERE a.IdCompany = ? AND p.token = ? LIMIT 1";
                  
    $stmt = $conn->prepare($sqlCustom);
    if ($stmt) {
        $stmt->bind_param('is', $IdCompany, $IdEstacion);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        
        $archivoPersonalizado = isset($resultado['FormaISLR']) ? trim($resultado['FormaISLR']) : '';
        
        // Si encontró algo en la celda FormaISLR (ej. retension_islr_firma.php)
        if ($archivoPersonalizado !== '') {
            
            // Construimos la URL como la espera tu archivo
            $urlDestino = $archivoPersonalizado . "?IdTx=" . $IdTx . "&IdCompany=" . $IdCompany . "&IdEstacion=" . $IdEstacion . "&IdTipoTx=" . $IdTipoTx;
            
            // Le decimos al JavaScript del AJAX que abra una nueva pestaña y cerramos este PHP.
            echo "<script>
                    window.open('{$urlDestino}', '_blank');
                    // Opcional: Cerrar algún modal si está abierto en la vista principal
                    if(typeof $('#modalPrint').modal === 'function') { $('#modalPrint').modal('hide'); }
                  </script>";
            exit; // MUY IMPORTANTE: Evita que se ejecute el resto del código de formatoisrl.php
        }
    }
}
// ==============================================================================
// FIN DEL PORTERO. Si pasa de aquí, ejecutará tu código normal de formatoisrl.php
// ==============================================================================


// ... AQUÍ CONTINÚA TU CÓDIGO ORIGINAL DE formatoisrl.php ...

include "ambienteconsultas.php";
$conn = conectar();
session_start();

$CompanyActual = trim($_POST["CompanyActual"]);
$Idtx = trim($_POST["Idtx"]);
$Idtipotx = trim($_POST["Idtipotx"]);
$IdEstacion = trim($_POST["IdEstacion"]);
$Item = trim($_POST["Item"]);
$Logotipo = trim($_SESSION["Logotipo"]);

// ====================================================================
// 1. OBTENER CABECERA DE LA FACTURA Y RIF DEL PROVEEDOR (IdBen)
// ====================================================================
$IdBen = '';
$numctrol = '';
$Idtx2 = '';
$imponible = 0;
$excento = 0;
$impuesto = 0;
$tasaTxC = 1;

$sql1 = "SELECT IdBen, if(Referencia='',if (DTE=0,if (IdTxCompany<>0,IdTxCompany,Idtx),DTE),Referencia) as Idtx2, numctrol, Total, excento, imponible, impuesto, tasa FROM PosUpTxC WHERE IdCompany='$CompanyActual' AND Idtipotx='$Idtipotx' AND IdEstacion='$IdEstacion' AND Idtx='$Idtx' LIMIT 1";
if ($res1 = mysqli_query($conn, $sql1)) {
    if ($row1 = mysqli_fetch_assoc($res1)) {
        $IdBen = trim($row1['IdBen']);
        $numctrol = trim($row1['numctrol']);
        $Idtx2 = trim($row1['Idtx2']); 
        $excento = (float)$row1['excento'];
        $imponible = (float)$row1['imponible'];
        $impuesto = (float)$row1['impuesto'];
        $tasaTxC = (float)$row1['tasa'];
    }
    mysqli_free_result($res1);
}

// ====================================================================
// 2. OBTENER DATOS DEL SUJETO RETENIDO (PROVEEDOR)
// ====================================================================
$SujetoNombre = '';
$SujetoRIF = $IdBen;
$SujetoDireccion = '';
$SujetoTipoBenef = 'PNRE'; // Valor por defecto seguro
$tp = '';
$dom = '';

if ($IdBen !== '') {
    $sql2 = "SELECT RUT, Nombre, Direccion, TipoPersona, Domicilio FROM PosUpclientes WHERE IdCompany='$CompanyActual' AND RUT='$IdBen' LIMIT 1";
    if ($res2 = mysqli_query($conn, $sql2)) {
        if ($row2 = mysqli_fetch_assoc($res2)) {
            $SujetoNombre = trim($row2['Nombre']);
            $SujetoDireccion = trim($row2['Direccion']);
            
            // Extraemos la info directa de la base de datos
            $tp  = (isset($row2['TipoPersona']) && trim((string)$row2['TipoPersona']) !== '') ? strtoupper(trim((string)$row2['TipoPersona'])) : 'VACIO';
            $dom = (isset($row2['Domicilio']) && trim((string)$row2['Domicilio']) !== '')   ? strtoupper(trim((string)$row2['Domicilio'])) : 'VACIO';
        }
        mysqli_free_result($res2);
    }
}

// ====================================================================
// 3. LÓGICA STRICTA PARA MOSTRAR EXACTAMENTE LA BASE DE DATOS
// ====================================================================

// Construimos el texto exacto que quieres mostrar en el HTML (Ej: PN - DOM)
$badgeTipoLargoPersonalizado = $tp . " - " . $dom;

// Asignamos los códigos internos para que las matemáticas (SENIAT y Porcentajes) no fallen
$colCodSeniat = 'CSPNR'; // Por defecto

if ($tp === 'PJ') {
    if ($dom === 'DOM') {
        $SujetoTipoBenef = 'PJDOM';
        $colCodSeniat = 'CSPJDOM';
    } else {
        $SujetoTipoBenef = 'PJNDOM';
        $colCodSeniat = 'CSPJNDOM';
    }
} else {
    // Si es PN, o si está VACIO, forzamos PNRE para la matemática
    if ($dom === 'NDOM') {
        $SujetoTipoBenef = 'PNNR';
        $colCodSeniat = 'CSPNNR';
    } else {
        $SujetoTipoBenef = 'PNRE';
        $colCodSeniat = 'CSPNR';
    }
}

// ====================================================================
// 4. OBTENER DETALLE DEL PAGO / RETENCIÓN Y LA EMPRESA
// ====================================================================
$query3 = "SELECT
    a.tasa as tasa2,
    e.MonedaS, e.MonedaP, e.CD, e.SimDec, e.SimMil,
    a.montoretencion, a.numret, a.Referencia, a.DAmpliado,
    DATE_FORMAT(a.Fectxclient, '%d/%m/%Y') as Fectxclient2,
    e.comercio as NameCompany, e.IDFiscal, e.direccion as DireccionEmpresa, e.Telefono as Fono, e.correorep as email,
    x.Nombre as ConceptoNombre, x.CSPNR, x.CSPNNR, x.CSPJDOM, x.CSPJNDOM, x.PNRESUST, x.PNRETAR
FROM PosUpTxP a
INNER JOIN PosUpCompany e ON a.IdCompany = e.Id
LEFT JOIN posupretencion x ON x.NumLit = a.numret AND x.IdCompany = a.IdCompany AND x.TipoRet = 1
WHERE a.IdCompany='$CompanyActual' AND a.Idtipotx='$Idtipotx' AND a.IdEstacion='$IdEstacion' AND a.Idtx='$Idtx' AND a.item='$Item'";

if ($result3 = mysqli_query($conn, $query3)) {
    if ($row3 = mysqli_fetch_assoc($result3)) {
        $PNRESUST = $row3["PNRESUST"];
        $PNRETAR = $row3["PNRETAR"];
        $ConceptoNombre = $row3['ConceptoNombre'];
        
        $NameCompany = trim($row3['NameCompany']);
        $IDFiscal = trim($row3['IDFiscal']);
        $DireccionEmpresa = trim($row3['DireccionEmpresa']);
        $Fono = trim($row3['Fono']);
        $email = trim($row3['email']);
        
        $Fectxclient2 = $row3['Fectxclient2'];
        $DAmpliado = $row3['DAmpliado'];
        $Referencia = trim($row3['Referencia']); 
        $numret = $row3['numret'];
        $Retencion = $row3['montoretencion'];
        $CD = $row3['CD'];
        $SimDec = $row3['SimDec'];
        $SimMil = $row3['SimMil'];
        
        $CSPNR = $row3['CSPNR'];
        $CSPNNR = $row3['CSPNNR'];
        $CSPJDOM = $row3['CSPJDOM'];
        $CSPJNDOM = $row3['CSPJNDOM'];

        $tasa2 = $row3["tasa2"] > 0 ? $row3["tasa2"] : 1;
    }
    mysqli_free_result($result3);
}

// ---------------------------------------------------------
// PROCESAMIENTO DE CLASIFICACIÓN FISCAL Y CÁLCULOS
// ---------------------------------------------------------

// Usamos tu texto personalizado para la vista
$badgeTipoLargo = $badgeTipoLargoPersonalizado;

$calc = json_decode($DAmpliado, true);
if (!$calc || !isset($calc['baseFiscal'])) {
    $calc = [
        'baseFiscal' => ($imponible + $excento) * $tasaTxC,
        'baseRet' => ($imponible + $excento) * $tasaTxC,
        'TAR' => $PNRETAR,
        'PA' => 0,
        'tarifaEf' => $PNRETAR,
        'SUST' => $PNRESUST,
        'PM' => 0,
        'retencion' => $Retencion * $tasa2
    ];
}

// Extracción estricta del código SENIAT ahora garantizada
$codSeniat = '';
switch ($SujetoTipoBenef) {
    case 'PNRE':   $codSeniat = $CSPNR ?? ''; break;
    case 'PNNR':   $codSeniat = $CSPNNR ?? ''; break;
    case 'PJDOM':  $codSeniat = $CSPJDOM ?? ''; break;
    case 'PJNDOM': $codSeniat = $CSPJNDOM ?? ''; break;
}
$codSeniat = trim((string)$codSeniat);

// Fallback final visual en caso de que esté vacío en la BD
if ($codSeniat === '') {
    $codSeniat = 'SIN CÓDIGO'; 
}

// ====================================================================
// 5. BUSCAR FORMATO PERSONALIZADO (FormaISLR) PARA LA IMPRESIÓN
// ====================================================================
$FormaISLR = '';

// Intento 1: Buscar en PosUpAlmacen
$sqlForma = "SELECT a.FormaISLR 
             FROM PosUpAlmacen a 
             INNER JOIN posupcompanyestacion p ON a.IdCompany = p.IdCompany AND a.IdAlm = p.IdAlmVta
             WHERE a.IdCompany='$CompanyActual' AND p.token='$IdEstacion' LIMIT 1";
if ($resF = mysqli_query($conn, $sqlForma)) {
    if ($rowF = mysqli_fetch_assoc($resF)) {
        if (isset($rowF['FormaISLR']) && trim($rowF['FormaISLR']) !== '') {
            $FormaISLR = trim((string)$rowF['FormaISLR']);
        }
    }
    mysqli_free_result($resF);
}

// Intento 2: Si no lo encontró, buscar en PosUpCompany
if ($FormaISLR === '') {
    $sqlC2 = "SELECT FormaISLR FROM PosUpCompany WHERE Id='$CompanyActual' LIMIT 1";
    if ($resC2 = mysqli_query($conn, $sqlC2)) {
        if ($rowC2 = mysqli_fetch_assoc($resC2)) {
            if (isset($rowC2['FormaISLR']) && trim($rowC2['FormaISLR']) !== '') {
                $FormaISLR = trim((string)$rowC2['FormaISLR']);
            }
        }
        mysqli_free_result($resC2);
    }
}

function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function fmt($val, $cd, $dec, $mil) { return number_format((float)$val, $cd, $dec, $mil); }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante ISLR - <?= h($Referencia) ?></title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; color: #000; margin: 0; padding: 0; box-sizing: border-box; }
        
        /* Flexbox structure to push signatures to the bottom */
        .print-container { 
            display: flex; 
            flex-direction: column; 
            min-height: 85vh; 
            width: 100%; 
            max-width: 1100px; 
            margin: 0 auto; 
            padding: 10mm; 
            font-size: 11px; 
        }
        .content-main { flex: 1; }
        .signatures-area { margin-top: auto; padding-top: 40px; }

        .info-table { width: 100%; border-collapse: collapse; font-size: 12px; margin-bottom: 15px; }
        .info-table th { width: 50%; border: 1px solid #bbb; background: #f3f3f3; padding: 6px; text-align: left; }
        .info-table td { border: 1px solid #bbb; padding: 6px; vertical-align: top; line-height: 1.4; }
        
        .data-table { width: 100%; border-collapse: collapse; font-size: 11px; margin-bottom: 15px; text-align: center; }
        .data-table th { border: 1px solid #bbb; padding: 5px; background-color: #f3f3f3; }
        .data-table td { border: 1px solid #bbb; padding: 5px; }
        
        .signatures { width: 100%; font-size: 12px; text-align: center; }
        .signatures td { width: 50%; }
        .sign-line { border-top: 1px solid #000; width: 70%; margin: 0 auto; padding-top: 5px; font-weight: bold; text-transform: uppercase; }
        
        @media print {
            @page { margin: 10mm; size: landscape; }
            body { background: #fff; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

<div class="print-container">
    
    <div class="content-main">
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <tr>
                <td style="width: 10%; text-align: left; vertical-align: middle;">
                    <?php if ($Logotipo !== ""): ?>
                        <img src="<?= 'Comercio/' . $CompanyActual . '/entorno/' . $Logotipo ?>" style="max-width: 80px; max-height: 80px;">
                    <?php else: ?>
                        <img src="img/logo.png" style="max-width: 80px; max-height: 80px;">
                    <?php endif; ?>
                </td>
                <td style="width: 90%; text-align: center; vertical-align: middle;">
                    <div style="font-size: 14px; font-weight:bold;">COMPROBANTE DE RETENCIÓN DEL IMPUESTO SOBRE LA RENTA</div>
                    <div style="font-size: 11px; font-weight:bold; margin-top: 5px;">Decreto 1.808 Art. 24 los agentes de retención estan obligados a los contribuyentes:</div>
                    <div style="font-size: 11px;">un comprobante por cada retención de impuesto que le practiquen en el cual se indica, entre otra Información.</div>
                    <div style="font-size: 11px;">el monto de lo pagado o abonado en cuenta y cantidad retenida.</div>
                </td>
            </tr>
        </table>
        
        <div style="font-size: 12px; color: #333; margin-bottom: 15px; text-align: center;">
            <b>N° Comprobante:</b> <?=h($Referencia)?> &nbsp;&nbsp;|&nbsp;&nbsp;
            <b>Fecha Comprobante:</b> <?=h($Fectxclient2)?> &nbsp;&nbsp;|&nbsp;&nbsp;
            <b>Fecha Factura:</b> <?=h($Fectxclient2)?>
        </div>

        <table class="info-table">
            <tr>
                <th>Agente de Retención</th>
                <th>Sujeto Retenido</th>
            </tr>
            <tr>
                <td>
                    <b>Nombre:</b> <?=h($NameCompany)?><br>
                    <b>RIF:</b> <?=h($IDFiscal)?><br>
                    <b>Dirección:</b> <?=h($DireccionEmpresa)?><br>
                    <b>Teléfono:</b> <?=h($Fono)?><br>
                    <b>Correo:</b> <?=h($email)?>
                </td>
                <td>
                    <?php if ($Item == '5'): ?>
                        <b>Razón Social:</b> <?=h($SujetoNombre)?><br>
                        <b>RIF:</b> <?=h($SujetoRIF)?><br>
                    <?php else: ?>
                        <b>Nombre y Apellido:</b> <?=h($SujetoNombre)?><br>
                        <b>C.I. / Pasaporte:</b> <?=h($SujetoRIF)?><br>
                    <?php endif; ?>
                    
                    <b>Dirección:</b> <?=h($SujetoDireccion)?><br>
                    <b>Clasificación Fiscal:</b> <?=h($badgeTipoLargo)?>
                </td>
            </tr>
        </table>

        <div style="font-size: 13px; margin-bottom: 5px;"><b>Datos de la Transacción:</b></div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>N° Control</th>
                    <th>Nro Factura</th>
                    <th>Cód. SENIAT</th>
                    <th style="text-align: left;">Concepto</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=h($numctrol ?: '—')?></td>
                    <td><?=h($Idtx2 ?: ($Idtx ?: '—'))?></td>
                    <td style="font-weight: bold;"><?=h($codSeniat)?></td>
                    <td style="text-align: left;"><?=h($ConceptoNombre)?></td>
                </tr>
            </tbody>
        </table>

        <div style="font-size: 13px; margin-bottom: 5px;"><b>Detalle del Cálculo de Retención:</b></div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Base Imponible de Factura</th>
                    <th>Base Ret.</th>
                    <th>% Ret.</th>
                    <th>Sustraendo</th>
                    <th style="font-size: 12px;">Retención</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=fmt($calc['baseFiscal'], $CD, $SimDec, $SimMil)?></td>
                    <td><?=fmt($calc['baseRet'], $CD, $SimDec, $SimMil)?></td>
                    <td><?=h($calc['tarifaEf'])?></td>
                    <td><?=fmt($calc['SUST'], $CD, $SimDec, $SimMil)?></td>
                    <td style="font-weight: bold; font-size: 13px;"><?=fmt($calc['retencion'], $CD, $SimDec, $SimMil)?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="signatures-area">
        <table class="signatures">
            <tr>
                <td><div class="sign-line">AGENTE DE RETENCIÓN</div></td>
                <td><div class="sign-line">SUJETO RETENIDO</div></td>
            </tr>
        </table>
    </div>

</div>

<script>
    var FormaISLR = <?php echo json_encode($FormaISLR); ?>;
    var PrintIdTx = <?php echo json_encode($Idtx); ?>;
    var PrintIdCompany = <?php echo json_encode($CompanyActual); ?>;

    window.onload = function() {
        // SI TIENE FORMATO PERSONALIZADO, REDIRIGE A ESE ARCHIVO
        if (FormaISLR && FormaISLR.trim() !== '') {
            var customUrl = FormaISLR.trim() + "?IdTx=" + PrintIdTx + "&IdCompany=" + PrintIdCompany;
            window.location.replace(customUrl); // Evita que se quede atrapado en el historial
            return;
        }

        // SI NO TIENE FORMATO (ESTÁ VACÍO), IMPRIME ESTE
        setTimeout(function() { window.print(); }, 400);
    };
</script>
</body>
</html>