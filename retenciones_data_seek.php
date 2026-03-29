<?php
// CONFIGURACIÓN DE ALTO RENDIMIENTO
/*
ini_set('memory_limit', '2048M');
ini_set('max_execution_time', '1800');
error_reporting(0); // Apaga errores visuales que rompen DataTables

session_start();
require_once 'ambiente.php'; 

header('Content-Type: application/json; charset=utf-8');

if (function_exists('conectar')) { $conn = conectar(); } 
elseif (function_exists('ConectarConsultas')) { $conn = ConectarConsultas(); } 
else { 
    echo json_encode(["draw" => 1, "recordsTotal" => 0, "recordsFiltered" => 0, "data" => []]); 
    exit; 
}

$id_tipotx_iva = "18"; 
$id_tipotx_islr = "19"; 

$accion = $_POST['Accion'] ?? '';

if ($accion === 'BuscarRetenciones') {
    
    $company = $_POST['CompanyActual'] ?? $_SESSION['CompanyActual'];
    $fechaDesde = $_POST['FechaDesde'] ?? '2020-01-01';
    $fechaHasta = $_POST['FechaHasta'] ?? date('Y-m-d');
    $tipoFiltro = $_POST['TipoRetencion'] ?? '*';

    $draw = intval($_POST['draw'] ?? 1);
    $start = intval($_POST['start'] ?? 0);
    $length = intval($_POST['length'] ?? 10); 
    $searchValue = strtolower(trim($_POST['search']['value'] ?? ''));

    // FILTRO SQL BASE
    $where = "WHERE IdCompany = '$company' AND Fectxclient BETWEEN '$fechaDesde 00:00:00' AND '$fechaHasta 23:59:59'";
    if ($tipoFiltro === 'IVA') $where .= " AND Idtipotx = '$id_tipotx_iva'";
    elseif ($tipoFiltro === 'ISLR') $where .= " AND Idtipotx = '$id_tipotx_islr'";
    else $where .= " AND Idtipotx IN ('$id_tipotx_iva', '$id_tipotx_islr')";

    $orderDir = $_POST['order'][0]['dir'] ?? 'desc';
    $sql = "SELECT * FROM PosUpTxC $where ORDER BY Fectxclient $orderDir";
    $result = mysqli_query($conn, $sql);
    
    $all_data = [];

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            
            $r = array_change_key_case($row, CASE_LOWER);
            
            $idTx = $r['idtx'] ?? '';
            $idtipotx = $r['idtipotx'] ?? '';
            $fecha = $r['fectxclient'] ?? '';
            
            $dampliado = trim($r['dampliado'] ?? '');
            $nroControl = trim($r['nrocontrol'] ?? '');
            $idBen = trim($r['idben'] ?? '');

            $montoBase = floatval($r['impoacttxc'] ?? $r['subtotal'] ?? 0);
            $montoRetenido = floatval($r['totaltxc'] ?? $r['montototal'] ?? 0);
            $porcentaje = floatval($r['impuacttxc'] ?? $r['impuesto'] ?? 0);

            // =========================================================================
            // 1. RESCATE DE MONTOS Y FACTURA (En PosUpTx)
            // =========================================================================
            if ($montoBase <= 0 || empty($dampliado)) {
                $qR = mysqli_query($conn, "SELECT TotalTx, Impuesto, Dampliado, nroControl FROM PosUpTx WHERE Idtx = '$idTx' AND IdCompany = '$company' LIMIT 1");
                if ($qR && $rr = mysqli_fetch_assoc($qR)) {
                    if ($montoBase <= 0) $montoBase = floatval($rr['TotalTx']);
                    if ($porcentaje <= 0) $porcentaje = floatval($rr['Impuesto']);
                    if (empty($dampliado)) $dampliado = trim($rr['Dampliado']);
                    if (empty($nroControl)) $nroControl = trim($rr['nroControl']);
                }
            }

            // Ocultar si está verdaderamente en cero
            if ($montoBase <= 0) {
                continue; 
            }

            // =========================================================================
            // 2. LA MAGIA: RESCATE DE RIF (IdResponsable en PosUpTxP)
            // =========================================================================
            $rifReal = $idBen;
            
            // Buscamos directamente el IdResponsable usando el IdTx
            $qP = mysqli_query($conn, "SELECT IdResponsable FROM PosUpTxP WHERE IdTx = '$idTx' AND IdCompany = '$company' LIMIT 1");
            if ($qP && $rp = mysqli_fetch_assoc($qP)) {
                $idResp = trim($rp['IdResponsable']);
                if (!empty($idResp) && $idResp !== '0' && $idResp !== 'NA') {
                    $rifReal = $idResp; // Reemplazamos el RIF con el real de los pagos
                }
            }

            // =========================================================================
            // 3. BUSCAR EL NOMBRE DE LA EMPRESA (RUT = IdResponsable)
            // =========================================================================
            $nombreEmpresa = "";
            if (!empty($rifReal) && $rifReal !== '0' && $rifReal !== 'NA') {
                
                // Intento 1: Búsqueda exacta en Clientes por RUT
                $qC = mysqli_query($conn, "SELECT Nombre FROM PosUpclientes WHERE IdCompany = '$company' AND RUT = '$rifReal' LIMIT 1");
                if ($qC && $rowC = mysqli_fetch_assoc($qC)) {
                    $nombreEmpresa = trim($rowC['Nombre']);
                } else {
                    // Intento 2: Búsqueda en Proveedores por RUT
                    $qProv = mysqli_query($conn, "SELECT Nombre FROM PosUpproveedor WHERE IdCompany = '$company' AND RUT = '$rifReal' LIMIT 1");
                    if ($qProv && $rowProv = mysqli_fetch_assoc($qProv)) {
                        $nombreEmpresa = trim($rowProv['Nombre']);
                    }
                }
            }
            
            // Si sigue vacío, mostramos el RIF para que sepas qué estaba buscando
            if (empty($nombreEmpresa)) {
                $nombreEmpresa = "SIN REGISTRO (" . ($rifReal ?: 'Sin RIF') . ")";
            }

            // =========================================================================
            // MAQUETACIÓN DE COLUMNAS
            // =========================================================================
            $referenciaFinal = "";
            if (!empty($dampliado) && $dampliado !== '0') $referenciaFinal = "Reg-" . $dampliado;
            elseif (!empty($nroControl) && $nroControl !== '0') $referenciaFinal = "Ctrl-" . $nroControl;
            else $referenciaFinal = "Reg-" . $idTx;

            // Buscador Interactivo
            if (!empty($searchValue)) {
                $searchStr = strtolower($referenciaFinal . " " . $rifReal . " " . $nombreEmpresa);
                if (strpos($searchStr, $searchValue) === false) {
                    continue; 
                }
            }

            $tipoEtiqueta = ($idtipotx == $id_tipotx_iva) ? 'RETENCI&Oacute;N IVA' : 'RETENCI&Oacute;N ISLR';
            $colorBadge = ($idtipotx == $id_tipotx_iva) ? 'info' : 'warning';

            // HTML FINAL
            $htmlTipo = utf8_encode("<span class='badge bg-{$colorBadge} text-dark fs-6 py-2'>{$tipoEtiqueta}</span>");
            $htmlFecha = utf8_encode("<div style='font-size: 14px; font-weight: 500;'>".date('d/m/Y', strtotime($fecha))."</div>");
            $htmlFactura = utf8_encode("<span class='text-secondary fw-bold fs-6'>{$referenciaFinal}</span>");
            
            // COLUMNA DE LA EMPRESA (Azul y llamativa)
            $empresaDisplay = mb_convert_encoding(mb_strtoupper($nombreEmpresa), 'HTML-ENTITIES', 'UTF-8');
            $htmlEmpresa = "<span class='text-primary fw-bold' style='font-size: 13px;'><i class='fa fa-building-o'></i> " . $empresaDisplay . "</span>";

            $htmlBase = utf8_encode("<span style='font-size:15px'>".number_format($montoBase, 2)." $</span>");
            $htmlPorc = utf8_encode("<span class='badge bg-dark fs-6'>".number_format($porcentaje, 2)."%</span>");
            $htmlRetenido = utf8_encode("<strong class='text-danger fs-5'>".number_format($montoRetenido, 2)." $</strong>");

            $all_data[] = [
                "Tipo" => $htmlTipo,
                "Fecha" => $htmlFecha,
                "Factura" => $htmlFactura,
                "Empresa" => $htmlEmpresa, 
                "Base" => $htmlBase,
                "Porcentaje" => $htmlPorc,
                "Retenido" => $htmlRetenido
            ];
        }
    }

    $recordsFiltered = count($all_data);
    $data_sliced = ($length != -1) ? array_slice($all_data, $start, $length) : $all_data;

    ob_clean(); 
    echo json_encode([
        "draw" => intval($draw),
        "recordsTotal" => $recordsFiltered, 
        "recordsFiltered" => $recordsFiltered,
        "data" => $data_sliced
    ]);
    exit;
}
?>*/

// CONFIGURACIÓN DE ALTO RENDIMIENTO
ini_set('memory_limit', '2048M');
ini_set('max_execution_time', '1800');
error_reporting(0); // Apaga errores visuales que rompen DataTables

session_start();
require_once 'ambiente.php'; 

header('Content-Type: application/json; charset=utf-8');

if (function_exists('conectar')) { $conn = conectar(); } 
elseif (function_exists('ConectarConsultas')) { $conn = ConectarConsultas(); } 
else { 
    echo json_encode(["draw" => 1, "recordsTotal" => 0, "recordsFiltered" => 0, "data" => []]); 
    exit; 
}

$id_tipotx_iva = "18"; 
$id_tipotx_islr = "19"; 

$accion = $_POST['Accion'] ?? '';

if ($accion === 'BuscarRetenciones') {
    
    $company = $_POST['CompanyActual'] ?? $_SESSION['CompanyActual'];
    $fechaDesde = $_POST['FechaDesde'] ?? '2020-01-01';
    $fechaHasta = $_POST['FechaHasta'] ?? date('Y-m-d');
    $tipoFiltro = $_POST['TipoRetencion'] ?? '*';

    $draw = intval($_POST['draw'] ?? 1);
    $start = intval($_POST['start'] ?? 0);
    $length = intval($_POST['length'] ?? 10); 
    $searchValue = strtolower(trim($_POST['search']['value'] ?? ''));

    $all_data = []; // Aquí meteremos lo viejo y lo nuevo

    // =========================================================================
    // 1. RESCATE DEL SISTEMA VIEJO (PosUpTxC)
    // =========================================================================
    $whereOld = "WHERE IdCompany = '$company' AND Fectxclient BETWEEN '$fechaDesde 00:00:00' AND '$fechaHasta 23:59:59'";
    if ($tipoFiltro === 'IVA') $whereOld .= " AND Idtipotx = '$id_tipotx_iva'";
    elseif ($tipoFiltro === 'ISLR') $whereOld .= " AND Idtipotx = '$id_tipotx_islr'";
    else $whereOld .= " AND Idtipotx IN ('$id_tipotx_iva', '$id_tipotx_islr')";

    $sqlOld = "SELECT * FROM PosUpTxC $whereOld";
    $resultOld = mysqli_query($conn, $sqlOld);
    
    if ($resultOld) {
        while ($row = mysqli_fetch_assoc($resultOld)) {
            $r = array_change_key_case($row, CASE_LOWER);
            
            $idTx = $r['idtx'] ?? '';
            $idtipotx = $r['idtipotx'] ?? '';
            $fecha = $r['fectxclient'] ?? '';
            
            $dampliado = trim($r['dampliado'] ?? '');
            $nroControl = trim($r['nrocontrol'] ?? '');
            $idBen = trim($r['idben'] ?? '');

            $montoBase = floatval($r['impoacttxc'] ?? $r['subtotal'] ?? 0);
            $montoRetenido = floatval($r['totaltxc'] ?? $r['montototal'] ?? 0);
            $porcentaje = floatval($r['impuacttxc'] ?? $r['impuesto'] ?? 0);

            if ($montoBase <= 0 || empty($dampliado)) {
                $qR = mysqli_query($conn, "SELECT TotalTx, Impuesto, Dampliado, nroControl FROM PosUpTx WHERE Idtx = '$idTx' AND IdCompany = '$company' LIMIT 1");
                if ($qR && $rr = mysqli_fetch_assoc($qR)) {
                    if ($montoBase <= 0) $montoBase = floatval($rr['TotalTx']);
                    if ($porcentaje <= 0) $porcentaje = floatval($rr['Impuesto']);
                    if (empty($dampliado)) $dampliado = trim($rr['Dampliado']);
                    if (empty($nroControl)) $nroControl = trim($rr['nroControl']);
                }
            }

            if ($montoBase <= 0) continue; 

            $rifReal = $idBen;
            $qP = mysqli_query($conn, "SELECT IdResponsable FROM PosUpTxP WHERE IdTx = '$idTx' AND IdCompany = '$company' LIMIT 1");
            if ($qP && $rp = mysqli_fetch_assoc($qP)) {
                $idResp = trim($rp['IdResponsable']);
                if (!empty($idResp) && $idResp !== '0' && $idResp !== 'NA') $rifReal = $idResp; 
            }

            $nombreEmpresa = "";
            if (!empty($rifReal) && $rifReal !== '0' && $rifReal !== 'NA') {
                $qC = mysqli_query($conn, "SELECT Nombre FROM PosUpclientes WHERE IdCompany = '$company' AND RUT = '$rifReal' LIMIT 1");
                if ($qC && $rowC = mysqli_fetch_assoc($qC)) {
                    $nombreEmpresa = trim($rowC['Nombre']);
                } else {
                    $qProv = mysqli_query($conn, "SELECT Nombre FROM PosUpproveedor WHERE IdCompany = '$company' AND RUT = '$rifReal' LIMIT 1");
                    if ($qProv && $rowProv = mysqli_fetch_assoc($qProv)) $nombreEmpresa = trim($rowProv['Nombre']);
                }
            }
            if (empty($nombreEmpresa)) $nombreEmpresa = "SIN REGISTRO (" . ($rifReal ?: 'Sin RIF') . ")";

            $referenciaFinal = "";
            if (!empty($dampliado) && $dampliado !== '0') $referenciaFinal = "Reg-" . $dampliado;
            elseif (!empty($nroControl) && $nroControl !== '0') $referenciaFinal = "Ctrl-" . $nroControl;
            else $referenciaFinal = "Reg-" . $idTx;

            if (!empty($searchValue)) {
                $searchStr = strtolower($referenciaFinal . " " . $rifReal . " " . $nombreEmpresa);
                if (strpos($searchStr, $searchValue) === false) continue; 
            }

            $tipoEtiqueta = ($idtipotx == $id_tipotx_iva) ? 'RETENCI&Oacute;N IVA' : 'RETENCI&Oacute;N ISLR';
            $colorBadge = ($idtipotx == $id_tipotx_iva) ? 'info' : 'warning';

            $all_data[] = [
                "Tipo" => utf8_encode("<span class='badge bg-{$colorBadge} text-dark fs-6 py-2'>{$tipoEtiqueta}</span>"),
                "Fecha" => utf8_encode("<div style='font-size: 14px; font-weight: 500;'>".date('d/m/Y', strtotime($fecha))."</div>"),
                "Factura" => utf8_encode("<span class='text-secondary fw-bold fs-6'>{$referenciaFinal}</span>"),
                "Empresa" => "<span class='text-primary fw-bold' style='font-size: 13px;'><i class='fa fa-building-o'></i> " . mb_convert_encoding(mb_strtoupper($nombreEmpresa), 'HTML-ENTITIES', 'UTF-8') . "</span>", 
                "Base" => utf8_encode("<span style='font-size:15px'>".number_format($montoBase, 2)." $</span>"),
                "Porcentaje" => utf8_encode("<span class='badge bg-dark fs-6'>".number_format($porcentaje, 2)."%</span>"),
                "Retenido" => utf8_encode("<strong class='text-danger fs-5'>".number_format($montoRetenido, 2)." $</strong>"),
                "timestamp" => strtotime($fecha) // Clave interna para ordenar
            ];
        }
    }

    // =========================================================================
    // 2. RESCATE DEL SISTEMA NUEVO Y BLINDADO (posuptxp)
    // =========================================================================
    $whereNew = "WHERE p.IdCompany = '$company' AND DATE(p.TxfecVence) BETWEEN '$fechaDesde' AND '$fechaHasta'";
    if ($tipoFiltro === 'IVA') $whereNew .= " AND p.tiporetencion = 2";
    elseif ($tipoFiltro === 'ISLR') $whereNew .= " AND p.tiporetencion = 1";
    else $whereNew .= " AND p.tiporetencion IN (1, 2)";

    $sqlNew = "
        SELECT 
            p.tiporetencion, p.TxfecVence, p.numret, p.Referencia as CompRetencion, p.DAmpliado, p.MontoPagar,
            tx.Referencia as RefFactura, tx.IdBen, tx.prefijo, tx.Idtx
        FROM posuptxp p
        INNER JOIN posuptxc tx ON p.Idtx = tx.Idtx AND p.IdCompany = tx.IdCompany
        $whereNew
    ";
    
    $resultNew = mysqli_query($conn, $sqlNew);
    
    if ($resultNew) {
        while ($rowN = mysqli_fetch_assoc($resultNew)) {
            // Leer la magia del JSON
            $calc = null;
            if (!empty($rowN['DAmpliado'])) {
                $calc = json_decode($rowN['DAmpliado'], true);
            }
            
            // Si no tiene el JSON estructurado, saltamos (es de otra cosa)
            if (!$calc || !isset($calc['baseRet'])) continue;

            $fechaN = $rowN['TxfecVence'];
            $idBenN = trim($rowN['IdBen']);
            $nroCompN = trim($rowN['CompRetencion']);
            $numLitN = trim($rowN['numret']);
            $facturaBase = trim($rowN['RefFactura']);

            $montoBaseN = floatval($calc['baseRet']);
            $porcentajeN = floatval($calc['tarifaEf']) * 100;
            $montoRetenidoN = floatval($rowN['MontoPagar']);

            // Buscar Empresa (RUT)
            $nombreEmpresaN = "SIN REGISTRO ($idBenN)";
            $qCN = mysqli_query($conn, "SELECT Nombre FROM PosUpclientes WHERE IdCompany = '$company' AND RUT = '$idBenN' LIMIT 1");
            if ($qCN && $rowCN = mysqli_fetch_assoc($qCN)) {
                $nombreEmpresaN = trim($rowCN['Nombre']);
            }

            // Buscador Interactivo
            if (!empty($searchValue)) {
                $searchStr = strtolower($nroCompN . " " . $idBenN . " " . $nombreEmpresaN . " " . $facturaBase);
                if (strpos($searchStr, $searchValue) === false) continue; 
            }

            $tipoEtiquetaN = ($rowN['tiporetencion'] == 2) ? 'RETENCI&Oacute;N IVA' : 'RETENCI&Oacute;N ISLR';
            $colorBadgeN = ($rowN['tiporetencion'] == 2) ? 'info' : 'warning';

            $all_data[] = [
                "Tipo" => utf8_encode("<span class='badge bg-{$colorBadgeN} text-dark fs-6 py-2'>{$tipoEtiquetaN}</span><br><small class='text-muted'>Concp: {$numLitN}</small>"),
                "Fecha" => utf8_encode("<div style='font-size: 14px; font-weight: 500;'>".date('d/m/Y', strtotime($fechaN))."</div>"),
                "Factura" => utf8_encode("<span class='text-secondary fw-bold fs-6'>Comp: {$nroCompN}</span><br><small>Fact: {$facturaBase}</small>"),
                "Empresa" => "<span class='text-primary fw-bold' style='font-size: 13px;'><i class='fa fa-building-o'></i> " . mb_convert_encoding(mb_strtoupper($nombreEmpresaN), 'HTML-ENTITIES', 'UTF-8') . "</span>", 
                "Base" => utf8_encode("<span style='font-size:15px'>".number_format($montoBaseN, 2, ',', '.')." Bs</span>"),
                "Porcentaje" => utf8_encode("<span class='badge bg-dark fs-6'>".number_format($porcentajeN, 2)."%</span>"),
                "Retenido" => utf8_encode("<strong class='text-danger fs-5'>".number_format($montoRetenidoN, 2, ',', '.')." Bs</strong>"),
                "timestamp" => strtotime($fechaN) // Clave interna para ordenar
            ];
        }
    }

    // =========================================================================
    // 3. ORDENAR, PAGINAR Y DEVOLVER
    // =========================================================================
    
    // Ordenar combinados por fecha (más recientes primero)
    usort($all_data, function($a, $b) {
        return $b['timestamp'] <=> $a['timestamp']; 
    });

    $recordsFiltered = count($all_data);
    $data_sliced = ($length != -1) ? array_slice($all_data, $start, $length) : $all_data;

    // Limpiamos el timestamp porque DataTables no lo espera en las columnas
    foreach ($data_sliced as &$row) {
        unset($row['timestamp']);
    }

    ob_clean(); 
    echo json_encode([
        "draw" => intval($draw),
        "recordsTotal" => $recordsFiltered, 
        "recordsFiltered" => $recordsFiltered,
        "data" => $data_sliced
    ]);
    exit;
}
?>