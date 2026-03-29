<?php
// 1. CONFIGURACIÓN DE ALTO RENDIMIENTO
ini_set('memory_limit', '2048M');
ini_set('max_execution_time', '1800');
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', 0);

require_once __DIR__ . '/vendor/autoload.php';
use Mpdf\Mpdf;

include "ambiente.php";
$conn = ConectarConsultas();
session_start();

if ($_SESSION['IdiomaActual'] == '') {
    $_SESSION['IdiomaActual'] = $_POST['IdiomaActual'];
}

// Función auxiliar por si no está declarada en ambiente.php
if (!function_exists('getcantformat')) {
    function getcantformat($val, $cd, $dec, $mil) {
        return number_format((float)$val, $cd, $dec, $mil);
    }
}

// =========================================================================
// INICIO DE TU LÓGICA SQL EXACTA
// =========================================================================
$Deposito2 = "";
$Deposito = "";
if (!empty($_POST["mIdAlmacen"])) {
    $Deposito = " and a.IdAlm in ('" . implode("','", $_POST["mIdAlmacen"]) . "')";
    $Deposito2 = "having IdDeposito  in ('" . implode("','", $_POST["mIdAlmacen"]) . "','0')";
}
if (!empty($_POST["mIdMarca"])) {
    $having = "having";
    $Marca = "and a.Marca in ('" . implode("','", $_POST["mIdMarca"]) . "')";
}

$fam = ""; $mar = "";
if (($_POST['group'] ?? '') == 'fami') { $fam = " v.ITEM,"; }
if (($_POST['group'] ?? '') == 'marc') { $mar = " d.nombre,"; }

$Orden = "order by a.CodIdBasico"; // Default
if (($_POST["OrdenXXX"] ?? '') == "Codigo") { $Orden = "order by " . $mar . $fam . " a.CodIdBasico"; }
if (($_POST["OrdenXXX"] ?? '') == "Descripcion") { $Orden = "order by " . $mar . $fam . "a.Descripcion,a.CodIdAmpliado"; }
if (($_POST["OrdenXXX"] ?? '') == "Referencia") { $Orden = "order by " . $mar . $fam . "a.CodBarra"; }
if (($_POST["OrdenXXX"] ?? '') == "Instancia") { $Orden = "order by " . $mar . $fam . "a.Idfamilia,a.CodIdAmpliado"; }

$familia = "";
if (!empty($_POST["mIdfamilia"])) {
    $familia = " and a.Idfamilia in ('" . implode("','", $_POST["mIdfamilia"]) . "') ";
}

$beetween = "";
if (!empty($_POST["mIdProductos"])) {
    $beetween = " and a.CodIdBasico in ('" . implode("','", $_POST["mIdProductos"]) . "') ";
}

$ExistenciaCero = "";
if (($_POST["ExistenciaXXX"] ?? '') != "on") {
    $ExistenciaCero = " and round(b.cantidad,3)<>0";
}

$AlmacenXXX = "";
if (($_POST["AlmacenXXX"] ?? '') != "on") {
    $AlmacenXXX = " and b.idalm > 0";
}

$buscar = "";
if (($_POST["EnvioEstado"] ?? '*') !== "*") {
    $buscar .= " and a.Estado = " . $_POST["EnvioEstado"];
}

$fechaA = " where a.Fectxclient <= '" . $_POST["FechaHastafisico"] . " 23:59:59' ";

$actexi = 0;
if (($_POST['mexis'] ?? '') == true) {
    $actexi = 1;
}

$ubic = "";
if (($_POST['sucursal'] ?? '0') <> '0') {
    $ubic = "and y.IdUbi=" . $_POST['sucursal'] . "";
}

mysqli_query($conn, "SET SESSION group_concat_max_len = 1000000");

$seriales = "";
if (($_POST["SerialesXXX"] ?? '') == "on") {
    $seriales = ",Seriales";
}

$query = "SELECT  a.CodIdAmpliado,a.CodBarra,a.CodIdBasico, a.Descripcion as Producto, coalesce(b.idalm,0) as IdDeposito, Coalesce(b.NomAlm,'No Utilizado') as Deposito,COALESCE(round(coalesce(b.cantidad,0),2),0) as exist, ROUND(COALESCE(round(coalesce(b.cantidad,0),2),0) * a.factorunit,2) as exist2, COALESCE(a.medida,'UND') as uniP1,COALESCE(a.medida,'UND') as uniP1d,a.UnidadP1 as uniP2d,a.CantP1,COALESCE(a.medida,'UND') as Medida,COALESCE(a.factorunit,1) as factorunit, truncate(b.cantidad,0) as cuniP1d, round(a.CantP1 * (b.cantidad-truncate(b.cantidad,0)),0) as cuniP2d, d.nombre as NombreMarca,v.ITEM as Familia" . $seriales . "  
    FROM PosUpProducto a 
    left join (
            select kk.IdCompany,kk.IdAlm,kk.NomAlm as NomAlm, kk.CodIdBasico, sum(kk.Cantidad) as Cantidad,GROUP_CONCAT(distinct Seriales ORDER BY Seriales ASC SEPARATOR ' ') as Seriales 
            from (
                SELECT a.IdCompany,a.IdAlm,e.Nombre as NomAlm, b.CodIdBasico, sum(coalesce(a.Cant)*coalesce(d.Inventario)) as Cantidad, Seriales
                FROM PosUpTxD a 
                right join PosUpProducto b on a.IdCompany=b.IdCompany and a.CodIdBasico=b.CodIdBasico 
                inner join PosUpTx d on a.Idtipotx=d.Idtipotx and d.Inventario <> 0 
                left join PosUpAlmacen e on a.IdCompany = e.IdCompany and a.IdAlm = e.IdAlm 
                " . $fechaA . " and a.IdCompany = " . $_POST["CompanyActual"] . "
                " . $Deposito . "
                group by a.IdCompany,a.idalm,b.CodIdBasico,Seriales having Cantidad<>0
                ) kk
        WHERE kk.IdCompany = " . $_POST["CompanyActual"] . "
        group by kk.IdCompany,kk.idalm,kk.CodIdBasico) b on a.IdCompany = b.IdCompany and a.CodIdBasico = b.CodIdBasico 
        left join (SELECT a.IdCompany,a.RUT, b.idBen,c.IdAlm, c.CodIdBasico 
        from PosUpclientes a inner join PosUpTxC b on a.IdCompany=b.IdCompany and a.RUT = b.idBen
        inner join PosUpTxD c on b.IdCompany =c.IdCompany and b.Idtipotx = c.Idtipotx and b.Idtx = c.Idtx and b.IdEstacion = c.IdEstacion
        inner join PosUpTx d on b.Idtipotx = d.Idtipotx and d.Inventario <> 0 
        WHERE a.IdCompany = " . $_POST["CompanyActual"] . "
        group by a.IdCompany, a.RUT,c.CodIdBasico
    ) c on a.IdCompany = c.IdCompany and a.CodIdBasico = c.CodIdBasico 
    left join PosUpAlmacen y on b.IdCompany = y.IdCompany and b.idalm = y.IdAlm 
    left join PosUpUbicacion z on y.IdCompany=c.IdCompany and y.IdUbi=z.IdUbi
    left join PosUpc_marcas d on a.IdCompany=d.IdCompany and a.Marca=d.idmarca 
    left join PosUpvarios v on v.IdCompany=a.IdCompany and v.IdVarios=a.Idfamilia and v.TIPOITEM = 2
    where a.IdCompany = " . $_POST["CompanyActual"] . " " . $ubic . " and a.EsCompuesto=0
    " . $buscar . "
    " . $beetween . "
    " . $ExistenciaCero . "                                       
    " . $AlmacenXXX . "
    " . ($Marca ?? '') . "
    " . $familia . "
    group by a.CodIdBasico,b.idalm
    " . $Orden . "
";

$titt = 'Marca';
if (($_POST['group'] ?? '') == 'fami') { $titt = 'Marca'; }
if (($_POST['group'] ?? '') == 'marc') { $titt = 'Familia'; }
if (($_POST['group'] ?? '') == '0') { $titt = 'Marca'; }

// =========================================================================
// INICIAMOS LA CAPTURA DEL CÓDIGO HTML PARA PASARLO A MPDF
// =========================================================================
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Tahoma, Verdana, Segoe, sans-serif; font-size: 8pt; color: #000; margin: 0; }
        
        /* ESTILOS DE TABLAS PARA MPDF */
        .table-main { width: 100%; border-collapse: collapse; margin-top: 5px; }
        .table-main th { background-color: #888888; color: #ffffff; font-weight: bold; text-align: left; padding: 4px 2px; font-size: 8pt; border: 1px solid #666; }
        .table-main td { padding: 4px 2px; border-bottom: 1px solid #ccc; vertical-align: middle; font-size: 8pt; }
        
        .txt-right { text-align: right !important; }
        .txt-center { text-align: center !important; }
        
        .grupo-titulo { background-color: #f2f2f2; font-weight: bold; font-size: 9pt; border-bottom: 1px solid #999; }
        .serial-box { font-size: 7.5pt; color: #444; font-style: italic; display: block; margin-top: 2px; }
    </style>
</head>
<body>

    <table class="table-main">
        <thead>
            <tr>
                <th width="12%">Código Barra</th>
                <th width="8%">S.K.U</th>
                <th width="20%">Descripción</th>
                <th width="10%"><?php echo $titt; ?></th>
                <th width="11%">Deposito</th>
                <th width="13%">Referencia</th>
                <?php if (($_POST['mexis'] ?? '') == true) { ?>
                    <th width="9%" class="txt-right">Exis. Teórica</th>
                    <th width="9%" class="txt-right">Desglose</th>
                <?php } ?>
                <th width="8%" class="txt-right">Exis. Real</th>
            </tr>
        </thead>
        <tbody>

        <?php
        if ($result = mysqli_query($conn, $query)) {
            $n = 0;
            $zz = "";
            $cd = $_POST["CD"] ?? 2;
            $simD = $_POST["SimDec"] ?? '.';
            $simM = $_POST["SimMil"] ?? ',';

            while ($row = mysqli_fetch_assoc($result)) {
                $n++;

                // Cálculos y Formateos (Idénticos a tu código)
                $groups = "(Sin Marca)";
                $yy = "";
                if (($_POST['group'] ?? '') == 'fami') {
                    $yy = trim($row['Familia']) ?: "(Sin Familia)";
                    $groups = trim($row['NombreMarca']) ?: "(Sin Marca)";
                } elseif (($_POST['group'] ?? '') == 'marc') {
                    $yy = trim($row['NombreMarca']) ?: "(Sin Marca)";
                    $groups = trim($row['Familia']) ?: "(Sin Familia)";
                } else {
                    $groups = trim($row['NombreMarca']) ?: "(Sin Marca)";
                }

                // Imprimir separador de grupo si aplica
                if ($yy != "" && $yy != $zz) {
                    $colspan = ($_POST['mexis'] ?? '') == true ? 9 : 7;
                    echo "<tr><td colspan='$colspan' class='grupo-titulo'>".mb_strtoupper($yy)."</td></tr>";
                    $zz = $yy;
                }

                // Variables base
                $CodBarra = trim($row['CodBarra']) !== "" ? $row['CodBarra'] : "-";
                $CodIdAmpliado = trim($row['CodIdAmpliado']) !== "" ? $row['CodIdAmpliado'] : "-";
                $Producto = trim($row['Producto']) !== "" ? $row['Producto'] : "-";
                $DepositoXA = trim($row['Deposito']) !== "" ? $row['Deposito'] : "-";

                // Construir "Referencia"
                $Abc = ($row['uniP1d'] === "" ? "UND" : $row['uniP1d']) . " ";
                if ($row['CantP1'] <> 0) {
                    if ($row['CantP1'] !== "" && $row['CantP1'] != 1) {
                        $Abc .= ' = ' . number_format($row['CantP1'], 0, $simD, $simM);
                    }
                    if (trim($row['uniP2d']) !== "") {
                        $Abc .= ' ' . $row['uniP2d'];
                    } else {
                        $Abc .= ' UND ';
                    }
                }

                // Construir "Existencia Teórica" y "Desglose"
                $exisTeorica = "";
                $desglose = "";
                if (($_POST['mexis'] ?? '') == true) {
                    
                    // Desglose
                    if ($row['cuniP1d'] <> 0) {
                        if (trim($row['cuniP1d']) !== "") {
                            $desglose .= number_format($row['cuniP1d'], 0, $simD, $simM) . " ";
                        } else {
                            $desglose .= number_format(0, 0, $simD, $simM) . " ";
                        }
                        if (trim($row['uniP1d']) !== "") {
                            $desglose .= '(' . substr($row['uniP1d'], 0, 3) . ')';
                        } else {
                            $desglose .= '(UND)';
                        }
                    } else {
                        $desglose .= '(UND)';
                    }
                    
                    if ($row['cuniP2d'] <> 0 and $row['cuniP1d'] <> 0) {
                        $desglose .= ' y ';
                    }
                    
                    if ($row['cuniP2d'] <> 0) {
                        if (trim($row['cuniP2d']) !== "") {
                            $desglose .= " " . number_format($row['cuniP2d'], 0, $simD, $simM) . " ";
                        }
                        if (trim($row['uniP2d']) !== "") {
                            $desglose .= '(' . substr($row['uniP2d'], 0, 3) . ')';
                        }
                    }

                    // Exis. Teorica
                    if ($row["factorunit"] <> 1 && $row["factorunit"] <> 0) {
                        $exisTeorica = $row["factorunit"] . " x " . getcantformat($row["exist"], $cd, $simD, $simM) . " = " . getcantformat($row["exist2"], $cd, $simD, $simM) . ' ' . $row["Medida"];
                    } else {
                        $exisTeorica = getcantformat($row["exist"], $cd, $simD, $simM) . ' ' . ($row["Medida"] === "" ? "UND" : $row["Medida"]);
                    }
                }

                // Construir "Exis. Real" (Líneas en blanco)
                $uniP1d = "";
                if (trim($row['uniP1d']) !== "") {
                    $uniP1d .= '_____(' . substr($row['uniP1d'], 0, 3) . ') ';
                } else {
                    $uniP1d = '_____(UND) ';
                }
                if (trim($row['uniP2d']) !== "") {
                    $uniP1d .= '<br>_____(' . substr($row['uniP2d'], 0, 3) . ')';
                }

                // ==========================================
                // IMPRIMIR FILA EN LA TABLA HTML
                // ==========================================
                echo "<tr>";
                echo "<td>" . $CodBarra . "</td>";
                echo "<td>" . $CodIdAmpliado . "</td>";
                echo "<td>";
                echo $Producto;
                // Si lleva seriales, se imprimen debajo del nombre
                if (($_POST["SerialesXXX"] ?? '') == "on" && !empty($row['Seriales'])) {
                    echo "<br><span class='serial-box'>" . $row['Seriales'] . "</span>";
                }
                echo "</td>";
                echo "<td>" . $groups . "</td>";
                echo "<td>" . $DepositoXA . "</td>";
                echo "<td>" . $Abc . "</td>";

                if (($_POST['mexis'] ?? '') == true) {
                    echo "<td class='txt-right'>" . $exisTeorica . "</td>";
                    echo "<td class='txt-right'>" . $desglose . "</td>";
                }

                echo "<td class='txt-right' style='white-space: nowrap;'>" . $uniP1d . "</td>";
                echo "</tr>";
            }
            mysqli_free_result($result);

            if ($n == 0) {
                $colspan = ($_POST['mexis'] ?? '') == true ? 9 : 7;
                echo "<tr><td colspan='$colspan' style='text-align:center; color:red; padding:15px; font-weight:bold;'>No se encontraron productos.</td></tr>";
            }
        }
        ?>
        </tbody>
    </table>

    <div style="margin-top: 15px; font-weight: bold; border-top: 1px solid #000; padding-top: 5px;">
        Total Registros Acumulados: <?php echo $n ?? 0; ?>
    </div>

</body>
</html>
<?php
// =========================================================================
// FINALIZAMOS LA CAPTURA Y GENERAMOS EL PDF CON MPDF
// =========================================================================
$html = ob_get_clean();

$mpdf = new Mpdf([
    'mode' => 'utf-8',
    'format' => 'Letter-L', // Horizontal obligado
    'margin_top' => 30,
    'margin_bottom' => 15,
    'margin_left' => 10,
    'margin_right' => 10,
    'tempDir' => __DIR__ . '/tmp'
]);

// Cabecera Dinámica para el PDF
$srcLogo = "img/informez.png"; 
$pathEntorno = "Comercio/" . $_POST['CompanyActual'] . "/entorno";
if (is_dir($pathEntorno) && $scan = @scandir($pathEntorno)) {
    foreach($scan as $f){ if(strpos($f, "Logotipo") === 0){ $srcLogo = "$pathEntorno/$f"; break; } }
}

$filtro1 = "";
if (($_POST["DesdeAXX"] ?? '') == true && ($_POST["HastaAXX"] ?? '') == true) {
    $filtro1 = " / Desde: " . $_POST["DesdeAXX"] . " Al " . $_POST["HastaAXX"];
} elseif (($_POST["DesdeAXX"] ?? '') == true) {
    $filtro1 = " / Desde: " . $_POST["DesdeAXX"];
} elseif (($_POST["HastaAXX"] ?? '') == true) {
    $filtro1 = " / Hasta: " . $_POST["HastaAXX"];
}

$filtro2 = "";
if (($_POST["ReferenciaXXX"] ?? '') == "on" || ($_POST["AlmacenXXX"] ?? '') == "on" || ($_POST["ExistenciaXXX"] ?? '') == "on" || ($_POST["SerialesXXX"] ?? '') == "on") {
    $filtro2 .= "Incluyendo: ";
    if (($_POST["AlmacenXXX"] ?? '') == "on") $filtro2 .= " / Prod. Sin Almacén";
    if (($_POST["ExistenciaXXX"] ?? '') == "on") $filtro2 .= " / Existencia Cero";
    if (($_POST["Referencia"] ?? '') == "on") $filtro2 .= " / Referencia";
    if (($_POST["SerialesXXX"] ?? '') == "on") $filtro2 .= " / Seriales";
} else {
    $filtro2 = "--------------------";
}

$cabeceraPDF = '
<table width="100%" style="font-family: sans-serif; border-bottom: 2px solid #ccc; padding-bottom: 5px;">
    <tr>
        <td width="25%" style="vertical-align: top;">
            <img src="'.$srcLogo.'" style="max-height: 45px; margin-bottom:5px;"><br>
            <div style="font-weight: bold; font-size: 11pt;">'.mb_strtoupper($_POST["NameCompany"]).'</div>
            <div style="font-size: 7pt;">'.($_POST["direccion"] ?? '').'</div>
            <div style="font-size: 7pt;">'.($_POST["litfiscal"] ?? '').'-'.($_POST["rute"] ?? '').'</div>
        </td>
        <td width="50%" align="center" style="vertical-align: top;">
            <div style="font-size: 14pt; font-weight: bold; color: #1a73e8; margin-bottom:5px;">INVENTARIO FÍSICO</div>
            <div style="font-size: 8pt;"><b>Orden por:</b> '.($_POST["OrdenXXX"] ?? '').' '.$filtro1.'</div>
            <div style="font-size: 8pt;">'.$filtro2.'</div>
        </td>
        <td width="25%" align="right" style="vertical-align: top;">
            <div style="font-size: 8pt; font-weight: bold;">Corte: '.($_POST["fectx5"] ?? '').'</div>
            <div style="font-size: 8pt; margin-top:5px;">Pág. {PAGENO}/{nbpg}</div>
        </td>
    </tr>
</table>';

$mpdf->SetHTMLHeader($cabeceraPDF);

// Inyectamos la tabla convertida
$mpdf->WriteHTML($html);

// Renderizamos el archivo
$mpdf->Output('Inventario_Fisico.pdf', 'I');
?>