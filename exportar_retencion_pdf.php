<?php
/**
 * exportar_retencion_pdf.php
 * Genera un reporte imprimible (PDF) de las retenciones ISLR con diseño Empresarial.
 */

ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('memory_limit', '2048M');
ini_set('max_execution_time', '1800');

@session_start(); // Aseguramos traer las variables de sesión como el Logotipo
include 'ambienteconsultas.php';

function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

$IdCompany = isset($_POST['CompanyActual']) ? (int)$_POST['CompanyActual'] : 0;
$FechaDesde = isset($_POST['FechaDesde']) ? trim($_POST['FechaDesde']) : date('Y-m-01');
$FechaHasta = isset($_POST['FechaHasta']) ? trim($_POST['FechaHasta']) : date('Y-m-t');

if ($IdCompany <= 0) die("Error: No se recibió la empresa.");

$cn = conectar();
if (!$cn || $cn->connect_error) die("Error de conexión a la BD.");
$cn->set_charset('utf8');

// 1. DATOS DEL AGENTE DE RETENCIÓN (LA EMPRESA)
$agente = ['comercio' => 'Empresa Desconocida', 'IDFiscal' => '', 'direccion' => '', 'Telefono' => '', 'correorep' => ''];
// CORRECCIÓN: Quitamos "logotipo" de la consulta SQL para que no falle
$stC = $cn->prepare("SELECT comercio, IDFiscal, direccion, Telefono, correorep FROM PosUpCompany WHERE Id=? LIMIT 1");
if ($stC) {
    $stC->bind_param('i', $IdCompany);
    $stC->execute();
    if ($resC = $stC->get_result()->fetch_assoc()) {
        $agente = $resC;
    }
    $stC->close();
}

// Extraemos el logotipo de la sesión (como se hace en PosUp)
$Logotipo = isset($_SESSION['Logotipo']) ? trim((string)$_SESSION['Logotipo']) : (isset($Logotipo) ? $Logotipo : '');

$fechaImpresion = date('d/m/Y h:i A');
$periodoD = date('d/m/Y', strtotime($FechaDesde));
$periodoH = date('d/m/Y', strtotime($FechaHasta));

// 2. CONSULTAR TODAS LAS RETENCIONES
$sql = "
    SELECT 
        p.Idtx, p.TxfecVence AS FechaRetencion, p.dampliado, p.numret, p.Referencia as NroRetencion,
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

$filasHTML = "";
$totalBase = 0;
$totalRetenido = 0;

while ($row = $result->fetch_assoc()) {
    
    // DATOS CLIENTE
    $rifRetenido = trim($row['RUTCliente']);
    $nombreCliente = "Desconocido";
    $tp = 'PN'; $dom = 'DOM'; 

    $sqlProv = "SELECT Nombre, TipoPersona, Domicilio FROM posupclientes WHERE IdCompany=? AND RUT=? LIMIT 1";
    $stP = $cn->prepare($sqlProv);
    $stP->bind_param('is', $IdCompany, $row['RUTCliente']);
    $stP->execute();
    if ($rp = $stP->get_result()->fetch_assoc()) {
        $nombreCliente = trim($rp['Nombre']);
        if(trim($rp['TipoPersona']) !== '') $tp = strtoupper(trim((string)$rp['TipoPersona']));
        if(trim($rp['Domicilio']) !== '') $dom = strtoupper(trim((string)$rp['Domicilio']));
    }
    $stP->close();

    $nroFactura = trim((string)$row['NroFactura']);
    if ($nroFactura === '' || $nroFactura === '0') $nroFactura = $row['Idtx']; 
    
    $nroControl = trim((string)$row['NroControl']);
    if ($nroControl === '' || $nroControl === '0') $nroControl = '—';

    $nroRetencion = trim((string)$row['NroRetencion']);
    $fechaOperacion = date('d/m/Y', strtotime($row['FechaRetencion'])); 

    // LÓGICA DE SENIAT Y CÁLCULO
    $badgeTipo = 'PNRE';
    if ($tp === 'PN' && $dom === 'DOM')  $badgeTipo = 'PNRE';
    if ($tp === 'PN' && ($dom === 'NDOM' || $dom === 'NODOM')) $badgeTipo = 'PNNR';
    if ($tp === 'PJ' && $dom === 'DOM')  $badgeTipo = 'PJDOM';
    if ($tp === 'PJ' && ($dom === 'NDOM' || $dom === 'NODOM')) $badgeTipo = 'PJNDOM';

    $colCodSeniat = 'CSPNR'; 
    switch ($badgeTipo) {
        case 'PNRE':   $colCodSeniat = 'CSPNR'; break;
        case 'PNNR':   $colCodSeniat = 'CSPNNR'; break;
        case 'PJDOM':  $colCodSeniat = 'CSPJDOM'; break;
        case 'PJNDOM': $colCodSeniat = 'CSPJNDOM'; break;
    }

    $codigoConcepto = "000";
    $nombreConcepto = "";
    $sqlReg = "SELECT * FROM posupretencion WHERE IdCompany=? AND TipoRet=1 AND NumLit=? LIMIT 1";
    $stR = $cn->prepare($sqlReg);
    $stR->bind_param('is', $IdCompany, $row['numret']);
    $stR->execute();
    $regla = $stR->get_result()->fetch_assoc();
    $stR->close();

    if ($regla) {
        $codigoConcepto = isset($regla[$colCodSeniat]) ? trim((string)$regla[$colCodSeniat]) : "000";
        if ($codigoConcepto === '') $codigoConcepto = "000";
        $nombreConcepto = trim((string)$regla['Nombre']);
    }

    // EXTRACCIÓN DE MONTOS
    $montoOperacion = 0.00;
    $porcentajeRetencion = 0.00;
    $montoRetenido = 0.00;

    $dampliado = trim((string)$row['dampliado']);
    $calc = null;
    if ($dampliado !== '' && strpos($dampliado, '{') === 0) {
        $calc = json_decode($dampliado, true);
    }

    if (is_array($calc) && isset($calc['retencion'])) {
        $montoOperacion = (float)$calc['baseRet'];
        $porcentajeRetencion = (float)$calc['tarifaEf'] * 100;
        $montoRetenido = (float)$calc['retencion'];
    } else {
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
            $montoRetenido = $montoOperacion * $tar;
        }
    }

    if ($montoOperacion <= 0) continue;

    $totalBase += $montoOperacion;
    $totalRetenido += $montoRetenido;

    $filasHTML .= "<tr>";
    $filasHTML .= "<td class='text-center'><b>{$nroRetencion}</b></td>";
    $filasHTML .= "<td class='text-center'>{$fechaOperacion}</td>";
    $filasHTML .= "<td class='text-center'>F: {$nroFactura}<br><small style='color:#666;'>C: {$nroControl}</small></td>";
    $filasHTML .= "<td><div style='font-weight:bold; font-size:10px; word-wrap:break-word;'>".h($nombreCliente)."</div><small>".h($rifRetenido)."</small></td>";
    $filasHTML .= "<td><div style='font-size:9px; color:#444; word-wrap:break-word;'>".h($nombreConcepto)."</div><div style='font-weight:bold; text-align:center;'>{$codigoConcepto}</div></td>";
    $filasHTML .= "<td class='text-right'>" . number_format($montoOperacion, 2, ',', '.') . "</td>";
    $filasHTML .= "<td class='text-center'>" . number_format($porcentajeRetencion, 2, ',', '.') . "%</td>";
    $filasHTML .= "<td class='text-right' style='font-weight:bold; color:#000;'>" . number_format($montoRetenido, 2, ',', '.') . "</td>";
    $filasHTML .= "</tr>";
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Retenciones ISLR</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; color: #000; margin: 0; padding: 0; box-sizing: border-box; }
        
        .print-container { 
            display: flex; 
            flex-direction: column; 
            min-height: 85vh; 
            width: 100%; 
            max-width: 1100px; 
            margin: 0 auto; 
            padding: 10mm; 
            font-size: 11px; 
            box-sizing: border-box;
        }
        
        .header-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .header-table td { vertical-align: middle; border: none; }
        
        .info-table { width: 100%; border-collapse: collapse; font-size: 11px; margin-bottom: 15px; }
        .info-table th { width: 50%; border: 1px solid #bbb; background: #f3f3f3; padding: 6px; text-align: left; text-transform: uppercase; }
        .info-table td { border: 1px solid #bbb; padding: 6px; vertical-align: top; line-height: 1.5; }
        
        .data-table { table-layout: fixed; width: 100%; border-collapse: collapse; font-size: 10px; margin-bottom: 15px; }
        .data-table th { border: 1px solid #bbb; padding: 4px; background-color: #f3f3f3; text-align: center; text-transform: uppercase; font-size: 9px; }
        .data-table td { border: 1px solid #bbb; padding: 4px; vertical-align: middle; word-wrap: break-word; overflow-wrap: break-word; }
        .data-table tbody tr:nth-child(even) { background-color: #fafafa; }
        
        .totals-row td { background-color: #eaeaea; font-size: 11px; font-weight: bold; border: 1px solid #bbb; padding: 6px; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        
        @media print {
            @page { margin: 5mm; size: landscape; }
            body { background: #fff; -webkit-print-color-adjust: exact; print-color-adjust: exact; width: 100%; }
            .print-container { padding: 0; width: 100%; max-width: 100%; }
            .d-print-none { display: none !important; }
        }
    </style>
</head>
<body>

<div class="print-container">
    
    <div class="d-print-none" style="text-align: right; margin-bottom: 15px;">
        <button onclick="window.print()" style="background-color: #0b1727; color: white; border: none; padding: 10px 20px; font-size: 14px; font-weight: bold; cursor: pointer; border-radius: 5px; box-shadow: 0 4px 6px rgba(0,0,0,0.2);">
            🖨️ IMPRIMIR REPORTE (PDF)
        </button>
        
    </div>

    <table class="header-table">
        <tr>
            <td style="width: 15%; text-align: left;">
                <?php if ($Logotipo !== ""): ?>
                    <img src="<?= '/Comercio/' . $IdCompany . '/entorno/' . $Logotipo ?>" style="max-width: 90px; max-height: 90px;">
                <?php else: ?>
                    <img src="img/logo.png" style="max-width: 90px; max-height: 90px;">
                <?php endif; ?>
            </td>
            <td style="width: 85%; text-align: center;">
                <div style="font-size: 16px; font-weight:bold; letter-spacing: 1px;">REPORTE DE RETENCIONES DEL IMPUESTO SOBRE LA RENTA (I.S.L.R.)</div>
                <div style="font-size: 12px; margin-top: 5px; color: #444;">Relación detallada de retenciones practicadas a proveedores / sujetos retenidos.</div>
                <div style="font-size: 12px; margin-top: 5px;">
                    <b>Período Consultado:</b> Del <?= $periodoD ?> al <?= $periodoH ?>
                </div>
            </td>
        </tr>
    </table>

    <table class="info-table">
        <tr>
            <th colspan="2">Datos del Agente de Retención (Empresa)</th>
        </tr>
        <tr>
            <td>
                <b>Razón Social:</b> <?=h($agente['comercio'])?><br>
                <b>RIF:</b> <?=h($agente['IDFiscal'])?><br>
                <b>Dirección:</b> <?=h($agente['direccion'])?>
            </td>
            <td>
                <b>Teléfono:</b> <?=h($agente['Telefono'] ?? 'No registrado')?><br>
                <b>Correo Electrónico:</b> <?=h($agente['correorep'] ?? 'No registrado')?><br>
                <b>Fecha de Generación:</b> <?= $fechaImpresion ?>
            </td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 12%;">N° Retención</th>
                <th style="width: 8%;">Fecha</th>
                <th style="width: 13%;">Factura / Control</th>
                <th style="width: 20%; text-align: left;">Sujeto Retenido</th>
                <th style="width: 18%;">Concepto / Cód. SENIAT</th>
                <th style="width: 12%; text-align: right;">Base Imponible</th>
                <th style="width: 6%;">% Ret.</th>
                <th style="width: 11%; text-align: right;">Retenido</th>
            </tr>
        </thead>
        <tbody>
            <?= $filasHTML ?>
            <?php if(empty($filasHTML)): ?>
                <tr>
                    <td colspan="8" class="text-center" style="padding: 30px; font-size: 14px; color: #888;">
                        No se encontraron retenciones de I.S.L.R. procesadas en el período seleccionado.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr class="totals-row">
                <td colspan="5" class="text-right">TOTALES DEL PERÍODO:</td>
                <td class="text-right"><?= number_format($totalBase, 2, ',', '.') ?> Bs</td>
                <td></td>
                <td class="text-right" style="color: #d9534f;"><?= number_format($totalRetenido, 2, ',', '.') ?> Bs</td>
            </tr>
        </tfoot>
    </table>

    <div style="margin-top: 40px; text-align: center; font-size: 11px; color: #666;">
        <p>Este documento es un resumen administrativo y no sustituye los comprobantes individuales entregados a los contribuyentes.</p>
    </div>

</div>

<script>
window.onload = function() {
    setTimeout(function() {
        window.print();
    }, 600);
};
</script>
</body>
</html>