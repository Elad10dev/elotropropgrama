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
$users = [];
if (trim($_POST["users"]) !== "") $users = explode(",", $_POST["users"]);

$Nombre = [];

if (!empty($users)) {
    $query = "SELECT a.Nombre from PosUpUsers a where a.IdCompany='" . $_POST["CompanyActual"] . "'
" . (!empty($users) ? " and a.Login in ('" . implode("','", $users) . "')" : "") . "
";

    if ($result = mysqli_query($connsultas, $query)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $Nombre[] = $row["Nombre"];
        }
    }
}

$query = "
SELECT
    b.Titulo,
    b.TitCto,
    IF(a.dte = 0, a.Idtx, a.DTE) AS Nro,
    IF(a.dte = 0, a.IdTxCompany, a.numctrol) AS ControlFiscal,
    IF(d.dte = 0, d.IdTxCompany, d.DTE) AS NroAfectado,
    a.Fectxclient,
    CONCAT(c.Nombre, ' (', a.IdUser, ')') AS IdUser,
    a.imponible * b.caja AS imponible,
    a.impuesto * b.caja AS Impuesto,
    a.totalimp * b.caja AS TotalImp
FROM posuptxc a
INNER JOIN posuptx b ON a.Idtipotx = b.Idtipotx
INNER JOIN posupusers c ON a.IdCompany = c.IdCompany AND a.IdUser = c.Login
LEFT JOIN posuptxc d ON a.IdCompany = d.IdCompany AND a.idtipotxpadre = d.Idtipotx AND a.idtxpadre = d.Idtx AND a.idestacionpadre = d.IdEstacion
WHERE a.IdCompany = " . $_POST["CompanyActual"] . "
  AND a.Idtipotx IN (2, 3, 15, 22, 31, 44)
  " . (!empty($users) ? " and a.IdUser in ('" . implode("','", $users) . "')" : "") . "
  AND a.Fectxclient BETWEEN ? AND ?
ORDER BY a.Fectxserver ASC
";
$query = "
SELECT
    b.Titulo,
    b.TitCto,
    IF(a.dte = 0, a.Idtx, a.DTE) AS Nro,
    IF(a.dte = 0, 'FORMA LIBRE', a.numctrol) AS ControlFiscal,
    IF(d.dte = 0, d.IdTx, d.DTE) AS NroAfectado,
    a.Fectxclient,
    CONCAT(c.Nombre, ' (', a.IdUser, ')') AS IdUser,
    a.imponible * b.caja AS imponible,
    a.impuesto * b.caja AS Impuesto,
    a.totalimp * b.caja AS TotalImp,
    a.tasa
FROM posuptxc a
INNER JOIN posuptx b ON a.Idtipotx = b.Idtipotx
INNER JOIN posupusers c ON a.IdCompany = c.IdCompany AND a.IdUser = c.Login
LEFT JOIN posuptxc d ON a.IdCompany = d.IdCompany AND a.idtipotxpadre = d.Idtipotx AND a.idtxpadre = d.Idtx AND a.idestacionpadre = d.IdEstacion
WHERE a.IdCompany = " . $_POST["CompanyActual"] . "
  AND a.Idtipotx IN (2, 3, 15, 22, 31, 44)
  " . (!empty($users) ? " and a.IdUser in ('" . implode("','", $users) . "')" : "") . "
  AND a.Fectxclient BETWEEN ? AND ?
ORDER BY a.Fectxserver ASC
";
$stmt = mysqli_prepare($connsultas, $query);
mysqli_stmt_bind_param($stmt, 'ss', $desde, $hasta);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

// Convertir resultados en array

//echo (!empty($_POST["users"]) ? implode(",", $_POST["users"]) : "");

$registros = [];
while ($row = mysqli_fetch_assoc($resultado)) {
    $registros[] = [
        "Titulo" => $row["Titulo"],
        "TitCto" => $row["TitCto"],
        "Numero" => $row["Nro"],
        "Control Fiscal" => $row["ControlFiscal"],
        "Numero Afectado" => $row["NroAfectado"],
        "Fechas" => (new DateTime($row["Fectxclient"]))->format('d/m/Y h:i A'),
        "Usuario" => $row["IdUser"],
        "Imponible" => $row["imponible"] * $row["tasa"],
        "Impuesto" => $row["Impuesto"] * $row["tasa"],
        "Total Impuesto" => $row["TotalImp"] * $row["tasa"],
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
$columnasNumericas = ['Total Impuesto', 'Impuesto', 'Imponible'];

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
