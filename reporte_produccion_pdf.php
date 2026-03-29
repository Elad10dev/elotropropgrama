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

// 2. RECEPCIÓN DE DATOS Y FILTROS (Idénticos a tu HTML)
$fechaD = $_POST["fechM"];
$fechaH = $_POST["fechM2"];
$cd = $_POST["CD"] ?? 2;
$simD = $_POST["SimDec"] ?? '.';
$simM = $_POST["SimMil"] ?? ',';

// Filtros Dinámicos
$produc = "";
if (!empty($_POST["mIdProductos"])) {
    $produc = " and a.CodIdBasico in ('" . implode("','", $_POST["mIdProductos"]) . "') ";
}

$familia = '';
if (!empty($_POST["mIdfamilia"])) {
    $familia = " and z.IdVarios in ('" . implode("','", $_POST["mIdfamilia"]) . "') ";
}

$Almacen23 = "";
if (!empty($_POST["mIdAlmacen"])) {
    $Almacen23 = " and al.IdAlm in ('" . implode("','", $_POST["mIdAlmacen"]) . "')";
}

$marca = "";
if (!empty($_POST["mIdMarca"])) {
    $marca = " and e.Marca in ('" . implode("','", $_POST["mIdMarca"]) . "') ";
}

$ubic = "";
if (($_POST['sucursal'] ?? '0') !== '0') {
    $ubic = " and al.IdUbi=" . $_POST['sucursal'];
}

// INICIAMOS CAPTURA DE HTML
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Tahoma, sans-serif; font-size: 7pt; color: #333; margin: 0; }
        .table-main { width: 100%; border-collapse: collapse; table-layout: fixed; }
        .table-main th { background-color: #888; color: #fff; font-weight: bold; border: 1px solid #666; padding: 3px; text-align: center; font-size: 6.5pt; }
        .table-main td { border: 1px solid #ccc; padding: 3px; vertical-align: middle; word-wrap: break-word; }
        .num { text-align: right !important; }
        .header-alm { background-color: #e8f0fe; color: #1a73e8; font-weight: bold; font-size: 9pt; padding: 5px; border: 1px solid #1a73e8; }
        .total-row { background-color: #f2f2f2; font-weight: bold; }
        .grand-total { background-color: #92b6da; color: #fff; font-weight: bold; font-size: 8pt; }
    </style>
</head>
<body>

    <table class="table-main">
        <thead>
            <tr>
                <th width="6%">Fuente</th>
                <th width="7%">Familia</th>
                <th width="8%">S.K.U</th>
                <th width="16%">Descripción</th>
                <th width="6%">Marca</th>
                <th width="7%">Cant. Insumo</th>
                <th width="7%">Costo Insu.</th>
                <th width="7%">Cant. Prod.</th>
                <th width="7%">Costo Prod.</th>
                <th width="7%">Cant. Venta</th>
                <th width="7%">Costo Venta</th>
                <th width="7%">P. Venta</th>
                <th width="8%">% Util</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // QUERY ORIGINAL (UNION PRODUCCION + VENTA)
            $query = "SELECT 'PRODUCCION' as Fuente,a.IdAlm as IdAlmacen,al.Nombre as Almacen ,e.CodIdAmpliado as SKU, 
                pd.Descripcion as Descripcion, 
                z.ITEM AS Familia, y.nombre as Marca, coalesce(sum(pd.Cant),0)  as Cantidad, coalesce(sum(round(pd.Costo/(1+ifnull(pu.VALOR,0))," . $cd . ")),0) as Costo   ,0 as  Precio ,
                0 as Util, e.CodBarra
                from PosUpTxD a 
                left join PosUpTxC b on a.IdCompany = b.IdCompany and a.Idtipotx = b.Idtipotx and a.Idtx = b.Idtx and a.IdEstacion = b.IdEstacion 
                inner join PosUpTx c on a.Idtipotx = c.Idtipotx 
                left join PosUpTxC p on a.IdCompany =p.IdCompany and CONCAT(a.IdAlm,'-',c.TitCto,'-',Lpad(IF(trim(b.Referencia)='',if (b.DTE=0,if (b.IdTxCompany<>0,b.IdTxCompany,b.Idtx),b.DTE),b.Referencia ),4,'0'),'-',a.Item)=p.Referencia 
                left join PosUpTxD pd on pd.IdCompany = p.IdCompany and pd.Idtipotx = p.Idtipotx and pd.IdEstacion = p.IdEstacion and pd.Idtx = p.idtx   and pd.Idtipotx <> 23
                left join PosUpAlmacen al on al.IdCompany =a.IdCompany and al.IdAlm =a.IdAlm 
                left join PosUpProducto e on pd.IdCompany=e.IdCompany and pd.CodIdBasico=e.CodIdBasico 
                left join PosUpvarios z on e.IdCompany=z.IdCompany and e.idfamilia=z.IdVarios and z.TIPOITEM=2 
                left join PosUpc_marcas y on e.IdCompany=y.IdCompany and e.Marca=y.idmarca 
                left join PosUpvarios pu on e.IdCompany=pu.IdCompany and e.Impuesto = pu.IdVarios and pu.TIPOITEM =0 
                where a.EstadoOrden = 1 and a.IdCompany= " . $_POST['CompanyActual'] . " AND 
                p.Fectxclient BETWEEN '$fechaD 00:00:00' and '$fechaH 23:59:59'
                $Almacen23 $produc $familia $marca $ubic
                group by a.IdAlm,pd.CodIdBasico 
                UNION 
                SELECT 'VENTA' as Fuente,a.IdAlm as IdAlmacen,al.Nombre as Almacen ,e.CodIdAmpliado as SKU, e.Descripcion as Descripcion, 
                z.ITEM AS Familia, y.nombre as Marca, sum(coalesce(a.Cant,0)) as Cantidad,coalesce(sum(round(e.Costo/(1+ifnull(pu.VALOR,0))," . $cd . ")),0) as Costo ,
                sum(round(coalesce(a.Total /(1+ifnull(pu.VALOR,0)),0),0)) as Precio,
                coalesce(round((sum(round(coalesce(a.Total /(1+ifnull(pu.VALOR,0)),0),0)) - sum(round(e.Costo/(1+ifnull(pu.VALOR,0)),0))) / sum(round(e.Costo/(1+ifnull(pu.VALOR,0)),0) )* 100,2),0) as Util, e.CodBarra
                from PosUpTxD a 
                left join PosUpAlmacen al on al.IdCompany =a.IdCompany and al.IdAlm =a.IdAlm 
                left join PosUpProducto e on a.IdCompany=e.IdCompany and a.CodIdBasico=e.CodIdBasico 
                left join PosUpvarios z on e.IdCompany=z.IdCompany and e.idfamilia=z.IdVarios and z.TIPOITEM=2 
                left join PosUpc_marcas y on e.IdCompany=y.IdCompany and e.Marca=y.idmarca 
                left join PosUpvarios pu on e.IdCompany=pu.IdCompany and e.Impuesto = pu.IdVarios and pu.TIPOITEM =0 
                where   a.IdCompany= " . $_POST['CompanyActual'] . " AND 
                a.Fectxclient BETWEEN '$fechaD 00:00:00' and '$fechaH 23:59:59'
                $Almacen23 $produc $familia $marca $ubic and a.idtipotx in (1,2,3,31,15,22)
                group by a.IdAlm,a.CodIdBasico order by IdAlmacen,fuente,Familia,SKU";

            $res = mysqli_query($conn, $query);
            
            $alm2 = ""; $ignore = 0;
            $cantinsu = 0; $costinsu = 0; $cantprod = 0; $costprod = 0; $Costo = 0; $Cantidad = 0; $price = 0;
            $cantinsu2 = 0; $costinsu2 = 0; $cantprod2 = 0; $costprod2 = 0; $Costo2 = 0; $Cantidad2 = 0; $price2 = 0;

            if ($res) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $ignore++;
                    $alm = $row['IdAlmacen'] . $row['Almacen'];

                    // CABECERA DE ALMACEN
                    if ($alm <> $alm2) {
                        if ($ignore > 1) {
                            // Imprimir Totales del Almacen anterior
                            $totalcosta = $costprod + $Costo;
                            $util_alm = ($totalcosta != 0) ? (($price - $totalcosta) / $totalcosta) * 100 : 0;
                            echo "<tr class='total-row'><td colspan='5' align='right'>TOTAL ALMACÉN</td>";
                            echo "<td class='num'>".number_format($cantinsu, $cd, $simD, $simM)."</td><td class='num'>-</td>";
                            echo "<td class='num'>".number_format($cantprod, $cd, $simD, $simM)."</td><td class='num'>".number_format($costprod, $cd, $simD, $simM)."</td>";
                            echo "<td class='num'>".number_format($Cantidad, $cd, $simD, $simM)."</td><td class='num'>".number_format($Costo, $cd, $simD, $simM)."</td>";
                            echo "<td class='num'>".number_format($price, $cd, $simD, $simM)."</td><td class='num'>".number_format($util_alm, 2)."%</td></tr>";
                            
                            // Reset Almacen
                            $cantinsu = 0; $costinsu = 0; $cantprod = 0; $costprod = 0; $Costo = 0; $Cantidad = 0; $price = 0;
                        }
                        echo "<tr><td colspan='13' class='header-alm'>ALMACÉN: (" . $row['IdAlmacen'] . ") " . $row['Almacen'] . "</td></tr>";
                        $alm2 = $alm;
                    }

                    // Lógica de datos por fila
                    $c_insu = 0; $v_insu = 0; $c_prod = 0; $v_prod = 0; $c_venta = 0; $v_venta = 0; $p_venta = 0; $u_fila = 0;

                    if ($row['Fuente'] == 'PRODUCCION') {
                        if ($row["Cantidad"] < 0) {
                            $c_insu = $row["Cantidad"]; $v_insu = $row["Costo"];
                            $cantinsu += $c_insu; $costinsu += $v_insu;
                            $cantinsu2 += $c_insu; $costinsu2 += $v_insu;
                        } else {
                            $c_prod = $row["Cantidad"]; $v_prod = $row["Costo"];
                            $cantprod += $c_prod; $costprod += $v_prod;
                            $cantprod2 += $c_prod; $costprod2 += $v_prod;
                        }
                    } else {
                        $c_venta = $row["Cantidad"]; $v_venta = $row["Costo"]; $p_venta = $row["Precio"]; $u_fila = $row["Util"];
                        $Cantidad += $c_venta; $Costo += $v_venta; $price += $p_venta;
                        $Cantidad2 += $c_venta; $Costo2 += $v_venta; $price2 += $p_venta;
                    }
            ?>
                <tr>
                    <td><?php echo $row['Fuente']; ?></td>
                    <td><?php echo $row['Familia']; ?></td>
                    <td><?php echo $row['SKU']; ?></td>
                    <td><?php echo mb_strtoupper(mb_substr($row['Descripcion'], 0, 35)); ?></td>
                    <td><?php echo $row['Marca']; ?></td>
                    <td class="num"><?php echo ($c_insu != 0) ? number_format($c_insu, $cd, $simD, $simM) : "-"; ?></td>
                    <td class="num"><?php echo ($v_insu != 0) ? number_format($v_insu, $cd, $simD, $simM) : "-"; ?></td>
                    <td class="num"><?php echo ($c_prod != 0) ? number_format($c_prod, $cd, $simD, $simM) : "-"; ?></td>
                    <td class="num"><?php echo ($v_prod != 0) ? number_format($v_prod, $cd, $simD, $simM) : "-"; ?></td>
                    <td class="num"><?php echo ($c_venta != 0) ? number_format($c_venta, $cd, $simD, $simM) : "-"; ?></td>
                    <td class="num"><?php echo ($v_venta != 0) ? number_format($v_venta, $cd, $simD, $simM) : "-"; ?></td>
                    <td class="num"><?php echo ($p_venta != 0) ? number_format($p_venta, $cd, $simD, $simM) : "-"; ?></td>
                    <td class="num"><?php echo ($u_fila != 0) ? number_format($u_fila, 2) . "%" : "-"; ?></td>
                </tr>
            <?php
                }

                // TOTALES FINALES (Último almacén y General)
                $totalcosta_last = $costprod + $Costo;
                $util_alm_last = ($totalcosta_last != 0) ? (($price - $totalcosta_last) / $totalcosta_last) * 100 : 0;
                echo "<tr class='total-row'><td colspan='5' align='right'>TOTAL ALMACÉN</td>";
                echo "<td class='num'>".number_format($cantinsu, $cd, $simD, $simM)."</td><td class='num'>-</td>";
                echo "<td class='num'>".number_format($cantprod, $cd, $simD, $simM)."</td><td class='num'>".number_format($costprod, $cd, $simD, $simM)."</td>";
                echo "<td class='num'>".number_format($Cantidad, $cd, $simD, $simM)."</td><td class='num'>".number_format($Costo, $cd, $simD, $simM)."</td>";
                echo "<td class='num'>".number_format($price, $cd, $simD, $simM)."</td><td class='num'>".number_format($util_alm_last, 2)."%</td></tr>";

                $totalcosta_gen = $costprod2 + $Costo2;
                $util_gen = ($totalcosta_gen != 0) ? (($price2 - $totalcosta_gen) / $totalcosta_gen) * 100 : 0;
                echo "<tr class='grand-total'><td colspan='5' align='right'>TOTALES GENERALES</td>";
                echo "<td class='num'>".number_format($cantinsu2, $cd, $simD, $simM)."</td><td class='num'>-</td>";
                echo "<td class='num'>".number_format($cantprod2, $cd, $simD, $simM)."</td><td class='num'>".number_format($costprod2, $cd, $simD, $simM)."</td>";
                echo "<td class='num'>".number_format($Cantidad2, $cd, $simD, $simM)."</td><td class='num'>".number_format($Costo2, $cd, $simD, $simM)."</td>";
                echo "<td class='num'>".number_format($price2, $cd, $simD, $simM)."</td><td class='num'>".number_format($util_gen, 2)."%</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
<?php
$html = ob_get_clean();
$mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'Letter-L', 'margin_top' => 35, 'tempDir' => __DIR__ . '/tmp']);

$srcLogo = "img/informez.png"; 
$pathEntorno = "Comercio/" . $_POST['CompanyActual'] . "/entorno";
if (is_dir($pathEntorno) && $scan = @scandir($pathEntorno)) {
    foreach($scan as $f){ if(strpos($f, "Logotipo") === 0){ $srcLogo = "$pathEntorno/$f"; break; } }
}

$header = '
<table width="100%" style="border-bottom: 2px solid #ccc; padding-bottom: 10px; font-family: sans-serif;">
    <tr>
        <td width="25%"><img src="'.$srcLogo.'" style="max-height: 45px;"><br>
            <b>'.mb_strtoupper($_POST["NameCompany"]).'</b><br><small>'.$_POST["direccion"].'</small></td>
        <td width="50%" align="center">
            <div style="font-size: 14pt; font-weight: bold; color: #1a73e8;">PRODUCCIÓN POR ALMACÉN DE VENTA</div>
            <div style="font-size: 9pt;">Periodo: '.$fechaD.' al '.$fechaH.'</div>
        </td>
        <td width="25%" align="right" style="font-size: 8pt;">
            Pág. {PAGENO}/{nbpg}<br>Impreso: '.$_POST["fectx5"].'
        </td>
    </tr>
</table>';

$mpdf->SetHTMLHeader($header);
$mpdf->WriteHTML($html);
$mpdf->Output('Produccion_Venta.pdf', 'I');
?>