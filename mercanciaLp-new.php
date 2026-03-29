<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';
require_once 'ambiente.php';

use Mpdf\Mpdf;

// Obtener parámetros GET y limpiar formato
$desde = isset($_POST['desde']) ? str_replace('T', ' ', $_POST['desde']) : date('Y-m-01 00:00:00');
$hasta = isset($_POST['hasta']) ? str_replace('T', ' ', $_POST['hasta']) : date('Y-m-d 23:59:59');


// Conexión
$connsultas = conectar();
if (!$connsultas) {
    die("Error de conexión con la base de datos.");
}

// Consulta SQL 
if ($_POST["OrdenLP"] == "Codigo") {
    $Orden = "order by a.CodIdBasico";
}
if ($_POST["OrdenLP"] == "Descripcion") {
    $Orden = "order by a.Descripcion";
}
if ($_POST["OrdenLP"] == "Referencia") {
    $Orden = "order by a.CodBarra";
}
if ($_POST["OrdenLP"] == "Instancia") {
    $Orden = "order by e.ITEM";
}
if ($_POST["OrdenLP"] == "Marca") {
    $Orden = "order by d.nombre";
}

if ($_POST["OrdenLP"] == "PrecioNeto") {
    $Orden = "order by a.PrecioNeto desc";
}

if (!empty($_POST["mIdfamilia"])) {
    $familia = " and a.Idfamilia in ('" . implode("','", $_POST["mIdfamilia"]) . "') ";
}

if (!empty($_POST["mIdProductos"])) {
    $beetween = " and a.CodIdBasico in ('" . implode("','", $_POST["mIdProductos"]) . "') ";
}
if (!empty($_POST["mIdAlmacen"])) {
    $Deposito = " and b.IdAlm in ('" . implode("','", $_POST["mIdAlmacen"]) . "')";
    $Deposito2 = "where a.IdAlm in ('" . implode("','", $_POST["mIdAlmacen"]) . "')";
    $Deposito4 = " and a.IdAlm in ('" . implode("','", $_POST["mIdAlmacen"]) . "')";
}

if (!empty($_POST["mIdMarca"])) {
    $Marca = "and a.Marca in ('" . implode("','", $_POST["mIdMarca"]) . "')";
}

$buscar = "";

if ($_POST["EnvioEstado"] !== "*") {
    $buscar .= "and a.Estado = " . $_POST["EnvioEstado"];
}


if (!$_POST["ExistenciaCero"] == "on") {
    $ExistenciaCero = " and round(b.cantidad,3)<>0";
}

//---------------------------------------------------------------------------------------------------------------------------
if ($_POST["RefLP1"] == true) {
    $referencia = "and a.CodBarra='" . $_POST["RefLP1"] . "'";
}

if ($_POST["Existencia"] == "on") {
    $existencia = "round(coalesce(b.cantidad,0),2) as Existencia,  ";
}
if (!$_POST["Existencia"] == "on") {
    $existencia = "1 as Existencia,";
}
//---------------------------------------------------------------------------------------------------------------------------

$fechaA = " where a.Fectxclient <= '" . $_POST["FechaHastalista"] . " 23:59:59'";
$fechaC = " where c.Fectxclient <= '" . $_POST["FechaHastalista"] . " 23:59:59'";
$fechaAA = " and a.Fectxclient <= '" . $_POST["FechaHastalista"] . " 23:59:59'";
$fechaCA = " and c.Fectxclient <= '" . $_POST["FechaHastalista"] . " 23:59:59'";


$tss="SELECT LitP01,LitP02,LitP03,LitP04,LitP05,LitP06,LitP07,LitP08,LitP09,LitP10,LitCosto FROM PosUpCompany 
where Id=" . $_POST["CompanyActual"] . "";
$tasa = 1;
if ($_POST['cimp'] == false) {
    $price1 = "round(coalesce(a.PrecioNeto * " . $tasa . ",0),2) as PrecioNeto, ";
    $price2 = "round(coalesce(a.PrecioNeto2 * " . $tasa . ",0),2) as PrecioNeto2, ";
    $price3 = "round(coalesce(a.PrecioNeto3 * " . $tasa . ",0),2) as PrecioNeto3, ";
    $price4 = "round(coalesce(a.PrecioNeto4 * " . $tasa . ",0),2) as PrecioNeto4, ";
    $price5 = "round(coalesce(a.PrecioNeto5 * " . $tasa . ",0),2) as PrecioNeto5, ";
    $price6 = "round(coalesce(a.PrecioNeto6 * " . $tasa . ",0),2) as PrecioNeto6, ";
    $price7 = "round(coalesce(a.PrecioNeto7 * " . $tasa . ",0),2) as PrecioNeto7, ";
    $price8 = "round(coalesce(a.PrecioNeto8 * " . $tasa . ",0),2) as PrecioNeto8, ";
    $price9 = "round(coalesce(a.PrecioNeto9 * " . $tasa . ",0),2) as PrecioNeto9, ";
    $price10 = "round(coalesce(a.PrecioNeto10 * " . $tasa . ",0),2) as PrecioNeto10, ";
} else {

    $price1 = "round(coalesce(a.PrecioVenta * " . $tasa . ",0),2) as PrecioNeto, ";
    $price2 = "round(coalesce(a.PrecioVenta2 * " . $tasa . ",0),2) as PrecioNeto2, ";
    $price3 = "round(coalesce(a.PrecioVenta3 * " . $tasa . ",0),2) as PrecioNeto3, ";
    $price4 = "round(coalesce(a.PrecioVenta4 * " . $tasa . ",0),2) as PrecioNeto4, ";
    $price5 = "round(coalesce(a.PrecioVenta5 * " . $tasa . ",0),2) as PrecioNeto5, ";
    $price6 = "round(coalesce(a.PrecioVenta6 * " . $tasa . ",0),2) as PrecioNeto6, ";
    $price7 = "round(coalesce(a.PrecioVenta7 * " . $tasa . ",0),2) as PrecioNeto7, ";
    $price8 = "round(coalesce(a.PrecioVenta8 * " . $tasa . ",0),2) as PrecioNeto8, ";
    $price9 = "round(coalesce(a.PrecioVenta9 * " . $tasa . ",0),2) as PrecioNeto9, ";
    $price10 = "round(coalesce(a.PrecioVenta10 * " . $tasa . ",0),2) as PrecioNeto10, ";
}
$costo = "";

if ($_POST['cimp'] == false) {
    $costo = "round(coalesce(a.CostoNeto * " . $tasa . ",0),2) as costo,";
} else {
    $costo = "round(coalesce(a.Costo * " . $tasa . ",0),2) as costo,";
}

if ($_POST['sucursal'] <> '0') {
    $ubic = " and f.IdUbi=" . $_POST['sucursal'];
}

$query = "SELECT DISTINCT a.CodIdAmpliado,a.CodIdBasico,a.CodBarra, a.Descripcion ,a.Envase,e.ITEM as Familia,a.factorunit,a.Medida,
                    a.CodBarra, d.nombre as Marca, a.Medida as Unidades,
                    a.medida as uniP1,truncate(b.cantidad,0) as cuniP1d,a.medida as uniP1d,
                    round(a.CantP1 * (b.cantidad-truncate(b.cantidad,0)),0) as cuniP2d,a.UnidadP1 as uniP2d,a.CantP1, 
                    " . $existencia . "
                    " . $costo . "
                    " . $price1 . "
                    " . $price2 . "
                    " . $price3 . "
                    " . $price4 . "
                    " . $price5 . "
                    " . $price6 . "
                    " . $price7 . "
                    " . $price8 . "
                    " . $price9 . "
                    " . $price10 . "
                    coalesce(f.VALOR*100,0) as ValorImpuesto
                    FROM PosUpProducto a
                    left join (SELECT a.IdCompany,a.IdAlm, b.CodIdBasico,sum(coalesce(a.Cant)*coalesce(d.Inventario)) as Cantidad 
                    FROM PosUpTxD a
                    inner join PosUpTx d on a.Idtipotx=d.Idtipotx and d.Inventario <> 0
                    left join PosUpAlmacen f on a.IdCompany=f.IdCompany and a.IdAlm=f.IdAlm
                    left join PosUpUbicacion z on f.IdCompany=z.IdCompany and f.IdUbi=z.IdUbi
                    inner join PosUpProducto b on a.IdCompany=b.IdCompany and a.CodIdBasico=b.CodIdBasico
                    " . $fechaA . " " . $ubic . " and a.IdCompany= " . $_POST["CompanyActual"] . "
                    " . $Deposito4 . "
                    group by a.IdCompany,b.CodIdBasico
                    ) b on a.IdCompany = b.IdCompany and a.CodIdBasico = b.CodIdBasico
                    left join (SELECT a.IdCompany,a.RUT, b.idBen, c.CodIdBasico 
                    from PosUpclientes a
                    inner join PosUpTxC b on a.IdCompany=b.IdCompany and a.RUT = b.idBen
                    inner join PosUpTxD c on b.IdCompany =c.IdCompany and b.Idtipotx = c.Idtipotx and b.Idtx = c.Idtx and b.IdEstacion = c.IdEstacion 
                    inner join PosUpTx d on b.Idtipotx = d.Idtipotx and d.Inventario <> 0
                    left join PosUpAlmacen f on c.IdCompany=f.IdCompany and c.IdAlm=f.IdAlm
                    left join PosUpUbicacion z on f.IdCompany=z.IdCompany and f.IdUbi=z.IdUbi
                    " . $fechaC . "  " . $ubic . " and a.IdCompany= " . $_POST["CompanyActual"] . "
                    group by a.IdCompany, a.RUT,c.CodIdBasico) c on a.IdCompany = c.IdCompany and a.CodIdBasico = c.CodIdBasico 
                    left join (select a.nombre,a.idmarca,a.IdCompany,b.CodIdBasico from PosUpc_marcas a 
                    inner join PosUpProducto b on a.IdCompany=b.IdCompany and a.idmarca=b.Marca
                    WHERE a.IdCompany= " . $_POST["CompanyActual"] . "
                    GROUP by a.IdCompany,b.CodIdBasico) d on a.IdCompany= d.IdCompany and a.CodIdBasico=d.CodIdBasico
                    left join PosUpvarios e on a.IdCompany=e.IdCompany and a.Idfamilia=e.IdVarios and e.TIPOITEM= 2
                    left join PosUpvarios f on a.IdCompany=f.IdCompany and a.Impuesto=f.IdVarios and f.TIPOITEM= 0
                    where a.IdCompany= " . $_POST["CompanyActual"] . " and a.EsCompuesto in (20,1,0) " . $beetween . " 
                    " . $buscar . "
                    " . $ExistenciaCero . "                                       
                    " . $Marca . "
                    " . $familia . "
                    " . $referencia . "
                    " . (!empty($Having) ? "HAVING " . implode(" or ", $Having) : "") . "
                    " . $Orden ;

                                        
$stmt = mysqli_prepare($connsultas, $query);
mysqli_stmt_bind_param($stmt, 'ss', $desde, $hasta);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

// Convertir resultados en array

//echo (!empty($_POST["users"]) ? implode(",", $_POST["users"]) : "");
$registros = [];
while ($row = mysqli_fetch_assoc($resultado)) {
    $registros[] = [
        "CodBarra" => $row["CodBarra"],
        "Descripcion" => $row["Descripcion"],
        "Familia" => $row["Familia"],
        "Medida" => $row["Medida"],
        "PrecioNeto" => $row["PrecioNeto"],
        "PrecioNeto2" => $row["PrecioNeto2"],
    ];
    // $registros[] = $row;
}
mysqli_stmt_close($stmt);

// Validar resultados
if (empty($registros)) {
    die("No se encontraron registros para el rango de fechas indicado.");
}

// Columnas y columnas numéricas
$columnas = array_keys($registros[0]);
$columnasNumericas = ['PrecioNeto', 'PrecioNeto2'];

// Crear PDF
$mpdf = new Mpdf([
    'format' => 'Letter-L',
    'margin_top' => 30,
    'margin_bottom' => 10,
    'margin_left' => 10,
    'margin_right' => 10,
]);
$fechaActual = date('Y-m-d H:i');



$src = "";
if ($IdUbi <> 0) {
    $scanpath = scandir("Comercio/" . $_POST["CompanyActual"] . "/sucursal");
    foreach ($scanpath as $item) {
        if ($item != '.' and $item != '..') {
            $file_name = explode(".", $item);
            $Mbooking_number = "sucursal" . $IdUbi;
            if ($file_name[0] == $Mbooking_number) {
                $src = "Comercio/" . $_POST["CompanyActual"] . "/sucursal" . "/" . $item;
            }
        }
    }
}
if (trim($src) == "") {
    $directorio_escaneado = scandir("Comercio/" . $_POST["CompanyActual"] . "/entorno");
    foreach ($directorio_escaneado as $item) {
        if ($item != '.' and $item != '..') {
            $nnn = preg_split('/_/', $item);
            $Mbooking_number = "Logotipo";
            if ($nnn[0] == $Mbooking_number) {
                $src = "Comercio/" . $_POST["CompanyActual"] . "/entorno" . "/" . $item;
            }
        }
    }
}

// Encabezado con logos
$mpdf->SetHTMLHeader('
<table width="100%" style="border: none; border-collapse: collapse;">
    <tr>
        <td width="10%" style="border: none;" >
            <img src="/' . $src . '" height="60">
        </td>
        <td width="40%" style="border: none;">
            ' . $_POST["NameCompanyActual"] . '<br>' .
    $_POST["litfiscal"] . ' ' . $_POST["rute"] . '<br>' .
    $_POST["direccion"] . '
        </td>
        <td width="35%" style="border: none;">
            <h2>Documentos Emitidos</h2>
            <div><strong>Desde:</strong> ' . $desde . ' </div>
            <div><strong>Hasta:</strong> ' . $hasta . ' </div>
' . (!empty($Nombre) ? " <div><strong>Usuarios:</strong> " . implode("','", $Nombre) . " </div>" : "") . '
            
        </td>
        <td width="10%" style="text-align: right; border: none;">
            <img src="/img/logoposuprpt.png" height="20">
            <br>
            Página {PAGENO} de {nbpg}
            <br>
            Impreso: ' . $fechaActual . '
        </td>
    </tr>

</table>

', 'O'); // 'O' significa "todas las páginas"

// Pie de página con fecha y número de página



// Encabezado HTML
$html = '';
$html .= '';
$html .= '<style>
    table { border-collapse: collapse; width: 100%; font-size: 10px; }
    th, td { border: 1px solid #aaa; padding: 4px; vertical-align: top; word-wrap: break-word; }
    th { background-color: #f0f0f0; }
</style>';

// Construir tabla
$html .= '<table autosize="1"><thead><tr>';
foreach ($columnas as $col) {
    $html .= '<th>' . htmlspecialchars($col) . '</th>';
}
$html .= '</tr></thead><tbody>';

// Filas
foreach ($registros as $fila) {
    $html .= '<tr>';
    foreach ($columnas as $col) {
        $valor = $fila[$col] ?? '';
        if (in_array($col, $columnasNumericas)) {
            $valor = number_format((float)$valor, 2, '.', ',');
            $html .= '<td style="text-align: right;">' . $valor . '</td>';
        } else {
            $html .= '<td>' . htmlspecialchars($valor) . '</td>';
        }
    }
    $html .= '</tr>';
}

$html .= '</tbody></table>';

// Generar PDF
$mpdf->WriteHTML($html);
$mpdf->Output('Documentos Emitidos.pdf', 'I');
