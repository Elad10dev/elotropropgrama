<?php


include "ambiente.php";
$conn = ConectarConsultas();

$sql = "SELECT LitP01,LitP02,LitP03,LitP04,LitP05,LitP06,LitP07,LitP08,LitP09,LitP10,LitCosto,MonedaS,FactorDolarCash,MonedaP,FactorDolarPaypal,Moneda3,FactorDolarZelle,Moneda4,FactorDolar5,Moneda5,FactorDolar6,Moneda6,FactorDolar7,Moneda7 FROM PosUpCompany 
where Id=" . $_POST["CompanyActual"] . "";
if ($result = mysqli_query($conn, $sql)) {
    while ($row = mysqli_fetch_assoc($result)) {
        $LitP01 = $row["LitP01"];
        $LitP02 = $row["LitP02"];
        $LitP03 = $row["LitP03"];
        $LitP04 = $row["LitP04"];
        $LitP05 = $row["LitP05"];
        $LitP06 = $row["LitP06"];
        $LitP07 = $row["LitP07"];
        $LitP08 = $row["LitP08"];
        $LitP09 = $row["LitP09"];
        $LitP10 = $row["LitP10"];
        $LitCosto = $row["LitCosto"];
        $company = [
            "FactorDolarCash" => $row["FactorDolarCash"],
            "MonedaS" => $row["MonedaS"],
            "FactorDolarPaypal" => $row["FactorDolarPaypal"],
            "Moneda3" => $row["Moneda3"],
            "FactorDolarZelle" => $row["FactorDolarZelle"],
            "Moneda4" => $row["Moneda4"],
            "FactorDolar5" => $row["FactorDolar5"],
            "Moneda5" => $row["Moneda5"],
            "FactorDolar6" => $row["FactorDolar6"],
            "Moneda6" => $row["Moneda6"],
            "FactorDolar7" => $row["FactorDolar7"],
            "Moneda7" => $row["Moneda7"],
            "MonedaP" => $row["MonedaP"],
        ];
    }
}
$tasa = 1;
$moneda = $company["MonedaP"];

$BCVtasa = floatval($_POST["TasaBCV"]);
$BCVmoneda = lang("BCV");
if (trim($_POST["SelectTasa"]) === "2") {
    $tasa = floatval($company["FactorDolarCash"]);
    $moneda = $company["MonedaS"];
} else if (trim($_POST["SelectTasa"]) === "3") {
    $tasa = floatval($company["FactorDolarPaypal"]);
    $moneda = $company["Moneda3"];
} else if (trim($_POST["SelectTasa"]) === "4") {
    $tasa = floatval($company["FactorDolarZelle"]);
    $moneda = $company["Moneda4"];
} else if (trim($_POST["SelectTasa"]) === "5") {
    $tasa = floatval($company["FactorDolar5"]);
    $moneda = $company["Moneda5"];
} else if (trim($_POST["SelectTasa"]) === "6") {
    $tasa = floatval($company["FactorDolar6"]);
    $moneda = $company["Moneda6"];
} else if (trim($_POST["SelectTasa"]) === "7") {
    $tasa = floatval($company["FactorDolar7"]);
    $moneda = $company["Moneda7"];
}


$VisualExist = "";
$sql = "
select
    group_concat(Idtipotx) as Idtipotx
from
    posuptx
where
    Inventario <> 0
    and CompInv = 0
";
$Operainv = "";
if ($result = mysqli_query($conn, $sql)) {
    while ($row = mysqli_fetch_assoc($result)) {
        $Operainv = $row["Idtipotx"];
    }
}
$sql = "
select
group_concat(Idtipotx) as Idtipotx
from
posuptx
where
Inventario = 1
and CompInv = 0
";
$Suminv = "";
if ($result = mysqli_query($conn, $sql)) {
    while ($row = mysqli_fetch_assoc($result)) {
        $Suminv = $row["Idtipotx"];
    }
}
$sql = "
select
    group_concat(Idtipotx) as Idtipotx
from
    posuptx
where
    Inventario = -1
    and CompInv = 0
";
$Resinv = "";
if ($result = mysqli_query($conn, $sql)) {
    while ($row = mysqli_fetch_assoc($result)) {
        $Resinv = $row["Idtipotx"];
    }
};
$firstDayOfMonth = ((new DateTime(date('Y-m-d'))))->format('Y-m-') . '01';
$LastDayOfMonth = ((new DateTime(date('Y-m-d'))))->format('Y-m-d');

$almacenes = [];
$buscar = "";

if (!empty($_POST["mIdAlmacen"])) {
    $buscar .= " and IdAlm " . ($_POST["NotIncludeAlmacen"] === "on" ? "not" : "") . " in ('" . implode("','", $_POST["mIdAlmacen"]) . "')";
}

if (!empty($_POST["ModalUbicaciones"])) {
    $buscar .= " and IdUbi " . ($_POST["NotIncludeUbicacion"] === "on" ? "not" : "") . " in ('" . implode("','", $_POST['ModalUbicaciones']) . "')";
}

if (!empty($_POST["ModalAtencion"])) {
    $buscar .= " and IdAtt " . ($_POST["NotIncludeZonaAtencion"] === "on" ? "not" : "") . " in ('" . implode("','", $_POST["ModalAtencion"]) . "')";
}

$sql = "
        select
            IdAlm
        from
            posupalmacen
        where
            idcompany = " . $_POST["CompanyActual"] . " 
            " . $buscar . "
        ";
if ($result = mysqli_query($conn, $sql)) {
    while ($row = mysqli_fetch_assoc($result)) {
        $almacenes[] = $row["IdAlm"];
    }
}

$buscar = "";

if (!empty($_POST["mIdfamilia"])) {
    $buscar .= " and a.Idfamilia " . ($_POST["NotIncludeFamilia"] === "on" ? "not" : "") . " in ('" . implode("','", $_POST["mIdfamilia"]) . "') ";
}
if (!empty($_POST["mIdMarca"])) {
    $buscar .= "and a.Marca " . ($_POST["NotIncludeMarca"] === "on" ? "not" : "") . " in ('" . implode("','", $_POST["mIdMarca"]) . "')";
}



if ($_POST["EnvioEstado"] !== "*") {
    $buscar .= "and a.Estado = " . $_POST["EnvioEstado"];
}

if (!empty($_POST["mIdProductos"])) {
    $buscar .= " and a.CodIdBasico " . ($_POST["NotIncludeProductos"] === "on" ? "not" : "") . " in ('" . implode("','", $_POST["mIdProductos"]) . "') ";
}

if ($_POST["RefLP1"] == true) {
    $buscar .=  "and a.CodBarra='" . $_POST["RefLP1"] . "'";
}


$buscarAlm = "";


$left = [];
$right = [];

if ($_POST["Agrupar"] === "Familiazp" || $_POST["Agrupar"] === "FamiliaMarca") {
    $Orden = "order by e.ITEM";
    $Agrupar = "e.ITEM";

    $query = "SELECT a.Idfamilia as id,count(a.CodIdBasico) as Cant
    FROM PosUpProducto a
    left join inv_existencias h on a.CodIdBasico = h.CodIdBasico
    and h.IdCompany = a.IdCompany
    where a.IdCompany= " . $_POST["CompanyActual"] . " 
    " . (!empty($almacenes) ? " and h.IdAlm in (" . implode(",", $almacenes) . ")" : "") . "
    AND h.qty_on_hand > 0
    and a.EsCompuesto in (20,1,0) 
    " . $buscar . "
    GROUP by a.Idfamilia
    ORDER BY Cant DESC
";
} else if ($_POST["Agrupar"] === "Marcazp") {
    $Orden = "order by b.Nombre";
    $Agrupar = "b.Nombre";

    $query = "SELECT a.Marca as id,count(a.CodIdBasico) as Cant
    FROM PosUpProducto a
    left join inv_existencias h on a.CodIdBasico = h.CodIdBasico
    and h.IdCompany = a.IdCompany
    where a.IdCompany= " . $_POST["CompanyActual"] . " 
    " . (!empty($almacenes) ? " and h.IdAlm in (" . implode(",", $almacenes) . ")" : "") . "
    AND h.qty_on_hand > 0
    and a.EsCompuesto in (20,1,0) 
    " . $buscar . "
    GROUP by a.Marca
    ORDER BY Cant DESC
";
}
$CantLeft = 0;
$CantRight = 0;
if ($result = mysqli_query($conn, $query)) {
    while ($row = mysqli_fetch_assoc($result)) {
        if ($CantLeft === 0) {
            $left[] = $row["id"];
            $CantLeft += floatval($row["Cant"]);
        } else if ($CantRight < $CantLeft) {
            $right[] = $row["id"];
            $CantRight += floatval($row["Cant"]);
        } else if ($CantRight > $CantLeft) {
            $left[] = $row["id"];
            $CantLeft += floatval($row["Cant"]);
        }
    }
}

$buscar = "";

$agregarLeft = "";
$agregarRight = "";
if ($_POST["Agrupar"] === "Familiazp" || $_POST["Agrupar"] === "FamiliaMarca") {

    $agregarLeft = " and a.Idfamilia in ('" . implode("','", $left) . "') ";
    $agregarRight = " and a.Idfamilia in ('" . implode("','", $right) . "') ";

    if (!empty($_POST["mIdMarca"]) && $_POST["Agrupar"] !== "FamiliaMarca") {
        $buscar .= "and a.Marca " . ($_POST["NotIncludeMarca"] === "on" ? "not" : "") . " in ('" . implode("','", $_POST["mIdMarca"]) . "')";
    }


    if ($_POST["EnvioEstado"] !== "*") {
        $buscar .= "and a.Estado = " . $_POST["EnvioEstado"];
    }

    if (!empty($_POST["mIdProductos"])) {
        $buscar .= " and a.CodIdBasico " . ($_POST["NotIncludeProductos"] === "on" ? "not" : "") . " in ('" . implode("','", $_POST["mIdProductos"]) . "') ";
    }

    if ($_POST["RefLP1"] == true) {
        $buscar .=  "and a.CodBarra='" . $_POST["RefLP1"] . "'";
    }
} else if ($_POST["Agrupar"] === "Marcazp") {

    $agregarLeft = " and a.Marca in ('" . implode("','", $left) . "') ";
    $agregarRight = " and a.Marca in ('" . implode("','", $right) . "') ";

    if (!empty($_POST["mIdfamilia"])) {
        $buscar .= " and a.Idfamilia " . ($_POST["NotIncludeFamilia"] === "on" ? "not" : "") . " in ('" . implode("','", $_POST["mIdfamilia"]) . "') ";
    }
    if ($_POST["EnvioEstado"] !== "*") {
        $buscar .= "and a.Estado = " . $_POST["EnvioEstado"];
    }

    if (!empty($_POST["mIdProductos"])) {
        $buscar .= " and a.CodIdBasico " . ($_POST["NotIncludeProductos"] === "on" ? "not" : "") . " in ('" . implode("','", $_POST["mIdProductos"]) . "') ";
    }

    if ($_POST["RefLP1"] == true) {
        $buscar .=  "and a.CodBarra='" . $_POST["RefLP1"] . "'";
    }
}



$fechaA = " where a.Fectxclient <= '" . $_POST["FechaHastalista"] . " 23:59:59'";
$fechaC = " where c.Fectxclient <= '" . $_POST["FechaHastalista"] . " 23:59:59'";
$fechaAA = " and a.Fectxclient <= '" . $_POST["FechaHastalista"] . " 23:59:59'";
$fechaCA = " and c.Fectxclient <= '" . $_POST["FechaHastalista"] . " 23:59:59'";

if ($_POST['cimp'] == false) {
    $price = "(coalesce(((a.PrecioNeto" . $_POST["SelectPrecio"] . " * " . $tasa . ") / " . $BCVtasa . ")  ,0)) as PrecioNetoPri, ";
    // $price .= "round(coalesce(((a.PrecioNeto" . $_POST["SelectPrecio"] . " * " . $tasa . ") / " . $BCVtasa . ") * " . $BCVtasa . ",0),2) as PrecioNeto, ";
    // $price .= "round(coalesce((a.PrecioNeto" . $_POST["SelectPrecio"] . " )  ,0),2) as PrecioNetoPriOrg, ";
} else {
    $price = "(coalesce((a.PrecioVenta" . $_POST["SelectPrecio"] . " * " . $tasa . ") / " . $BCVtasa . "  ,0)) as PrecioNetoPri, ";
    // $price .= "round(coalesce(((a.PrecioVenta" . $_POST["SelectPrecio"] . " * " . $tasa . ") / " . $BCVtasa . ") * " . $BCVtasa . ",0),2) as PrecioNeto, ";
    // $price .= "round(coalesce((a.PrecioVenta" . $_POST["SelectPrecio"] . " )  ,0),2) as PrecioNetoPriOrg, ";
}

if ($_POST["pricemayor"]) $buscar .= " and a.PrecioNeto" . $_POST["SelectPrecio"] . " > 0";

$query = "SELECT a.CodIdAmpliado,a.CodIdBasico,a.CodBarra, a.Descripcion ,a.Envase," . $Agrupar . " as Familia, a.CodBarra,
    " . $price . "
    a.CantP1,h.qty_on_hand as Cantidad
    FROM PosUpProducto a
    left join inv_existencias h on a.CodIdBasico = h.CodIdBasico
    and h.IdCompany = a.IdCompany
    left join PosUpc_marcas b on a.IdCompany = b.IdCompany and a.Marca = b.idmarca 
    left join PosUpvarios e on a.IdCompany=e.IdCompany and a.Idfamilia=e.IdVarios and e.TIPOITEM= 2
    where a.IdCompany= " . $_POST["CompanyActual"] . " 
    " . (!empty($almacenes) ? " and h.IdAlm in (" . implode(",", $almacenes) . ")" : "") . "
    AND h.qty_on_hand > 0
    and a.EsCompuesto in (20,1,0) 
    " . $beetween . " 
    " . $buscar . "
";
$PrecioActual = "";
if ($_POST["SelectPrecio"] === "") {
    $PrecioActual = $LitP01;
} else if ($_POST["SelectPrecio"] === "2") {
    $PrecioActual = $LitP02;
} else if ($_POST["SelectPrecio"] === "3") {
    $PrecioActual = $LitP03;
} else if ($_POST["SelectPrecio"] === "4") {
    $PrecioActual = $LitP04;
} else if ($_POST["SelectPrecio"] === "5") {
    $PrecioActual = $LitP05;
} else if ($_POST["SelectPrecio"] === "6") {
    $PrecioActual = $LitP06;
} else if ($_POST["SelectPrecio"] === "7") {
    $PrecioActual = $LitP07;
} else if ($_POST["SelectPrecio"] === "8") {
    $PrecioActual = $LitP08;
} else if ($_POST["SelectPrecio"] === "9") {
    $PrecioActual = $LitP09;
} else if ($_POST["SelectPrecio"] === "10") {
    $PrecioActual = $LitP10;
}
$Familia = "";
$body = "";
$n = 0;

$body = "";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos</title>
    <style>
        /* Estilo base */
        body {
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* Contenedor principal con dos columnas */
        .container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            /* Espacio entre las columnas */
            padding: 20px;
        }

        /* Encabezados de categorías */
        h2 {
            font-size: 1rem;
            color: #1a73e8;
            margin: 0 0 10px;
            padding: 0;
            text-transform: uppercase;
            border-bottom: 2px solid #1a73e8;
            padding-bottom: 5px;
        }

        h3 {
            font-size: 0.75rem;
            color: #1a73e8;
            margin: 0 0 10px;
            padding: 0px 4px;
            text-transform: uppercase;
            border-bottom: 2px solid #1a73e8;
            padding-bottom: 5px;
        }

        /* Tablas */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-size: 0.8rem;
        }

        /* Estilo del encabezado de la tabla */
        thead {
            background-color: #1a73e8;
            color: white;
        }

        th,
        td {
            padding: 6px 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        /* Filas alternadas */
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Estilo para impresión */
        @media print {

            /* Ajuste de márgenes para impresión */
            body {
                margin: 0;
            }

            /* Ocultar elementos no necesarios en la impresión */
            .container {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 0px;
                /* Espacio entre las columnas */
                padding: 10px;
            }

            h2 {
                font-size: 0.9rem;
                margin: 0 0 5px;
            }

            h3 {
                font-size: 0.6rem;
                margin: 0 0 5px;
            }

            table {
                font-size: 0.45rem;
                margin-bottom: 10px;
            }

            th,
            td {
                padding: 0px;
            }

            /* Opcional: eliminar sombras para que las tablas se impriman planas */
            table {
                box-shadow: none;
            }

            header {
                display: none;
            }
        }
    </style>
</head>

<body>

    <header>
        <h1>
            <button type='submit' onclick='window.print();'><img src='/img/pdf.png' width='28' height='28'><br>PDF</button>
            <button class='ocultoimpresion ' onclick='document.getElementById(`formexcel`).submit()'><img src='/img/excel.png' width='28' height='28'><br>ListaPrecios<br></button>
        </h1>

    </header>

    <div style="flex-wrap: wrap; display:flex;">
        <div style="width: 50%">
            <?php
            $Familia = "";
            $Marca = "";
            $body = "";
            $excel = [];
            if ($_POST["Agrupar"] === "FamiliaMarca") {
                $query = "SELECT a.CodIdAmpliado,a.CodIdBasico,a.CodBarra, a.Descripcion ,a.Envase,e.ITEM as Familia,b.Nombre as Marca, a.CodBarra,
                    " . $price . "
                    a.CantP1,h.qty_on_hand as Cantidad
                    FROM PosUpProducto a
                    left join inv_existencias h on a.CodIdBasico = h.CodIdBasico
                    and h.IdCompany = a.IdCompany
                    left join PosUpc_marcas b on a.IdCompany = b.IdCompany and a.Marca = b.idmarca 
                    left join PosUpvarios e on a.IdCompany=e.IdCompany and a.Idfamilia=e.IdVarios and e.TIPOITEM= 2
                    where a.IdCompany= " . $_POST["CompanyActual"] . " 
                    " . (!empty($almacenes) ? " and h.IdAlm in (" . implode(",", $almacenes) . ")" : "") . "
                    AND h.qty_on_hand > 0
                    and a.EsCompuesto in (20,1,0) 
                    " . $beetween . " 
                    " . $buscar . "

                ";
                $n = 0;
                $m = 0;

                if ($result = mysqli_query($conn, $query . " " . $agregarLeft . " GROUP by a.CodIdBasico order by e.ITEM ASC, b.Nombre desc
                    ")) {
                    while ($row = mysqli_fetch_assoc($result)) {

                        if ($m === 0) {
                            $Familia = $row["Familia"];
                            $Marca = $row["Marca"];
                            $excel[] = [
                                "Descripcion" => "",
                                "PrecioNetoPri" => "",
                                "PrecioNeto" => "",
                            ];
                            $excel[] = [
                                "Descripcion" => $Familia,
                                "PrecioNetoPri" => "",
                                "PrecioNeto" => "",
                            ];
                            $excel[] = [
                                "Descripcion" => "",
                                "PrecioNetoPri" => $Marca,
                                "PrecioNeto" => "",
                            ];

                            $excel[] = [
                                "Descripcion" => "Producto",
                                "PrecioNetoPri" => ($_POST["MonedaPrimeriaMostrar"] != false ? "Precio (" . $company["MonedaP"] . ") " : ""),
                                "PrecioNeto" => ($_POST["MonedaSecundariaMostrar"] != false ? "Precio (BCV)" : ""),
                            ];
                            echo '
                                <div><h2>' . $Familia . '</h2></div>
                            ';
                        }
                        if ($Familia <> $row["Familia"]) {
                            echo '
                                <section class="product-category">
                                    <h3>' . $Marca . '</h3>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                ' . ($_POST["MonedaPrimeriaMostrar"] != false ? '<th style="text-align: end;">' . "Precio (" . $company["MonedaP"] . ") " . '</th>' : '') . '
                                                ' . ($_POST["MonedaSecundariaMostrar"] != false ? '<th style="text-align: end;">' . "Precio (BCV) " . '</th>' : '') . '
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ' . $body . '
                                        </tbody>
                                    </table>
                                </section>
                            ';
                            $Marca = $row["Marca"];
                            $Familia = $row["Familia"];
                            echo '
                                <div><h2>' . $Familia . '</h2></div>
                            ';
                            $body = "
                                <tr>
                                    <td>" . trim($row['Descripcion']) . "</td>
                                    " . ($_POST["MonedaPrimeriaMostrar"] != false ? "<td style='text-align: end;'>" . number_format(ROUND($row["PrecioNetoPri"], $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])  . "</td>" : "") . "
                                    " . ($_POST["MonedaSecundariaMostrar"] != false ? ($moneda !== $company["MonedaP"] ? "<td style='text-align: end;'>" . number_format(ROUND($row["PrecioNetoPri"] * $BCVtasa, $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . "</td>" : "") : "") . "
                                </tr>
                            ";

                            $excel[] = [
                                "Descripcion" => "",
                                "PrecioNetoPri" => "",
                                "PrecioNeto" => "",
                            ];
                            $excel[] = [
                                "Descripcion" => $Familia,
                                "PrecioNetoPri" => "",
                                "PrecioNeto" => "",
                            ];
                            $excel[] = [
                                "Descripcion" => "",
                                "PrecioNetoPri" => $Marca,
                                "PrecioNeto" => "",
                            ];

                            $excel[] = [
                                "Descripcion" => "Producto",
                                "PrecioNetoPri" => ($_POST["MonedaPrimeriaMostrar"] != false ? "Precio (" . $company["MonedaP"] . ") " : ""),
                                "PrecioNeto" => ($_POST["MonedaSecundariaMostrar"] != false ? "Precio (BCV)" : ""),
                            ];
                            $n = 1;
                        } else if ($Marca <> $row["Marca"]) {
                            echo '
                                <section class="product-category">
                                    <h3>' . $Marca . '</h3>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                ' . ($_POST["MonedaPrimeriaMostrar"] != false ? '<th style="text-align: end;">' . "Precio (" . $company["MonedaP"] . ") " . '</th>' : '') . '
                                                ' . ($_POST["MonedaSecundariaMostrar"] != false ? '<th style="text-align: end;">' . "Precio (BCV) " . '</th>' : '') . '
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ' . $body . '
                                        </tbody>
                                    </table>
                                </section>
                            ';
                            $Marca = $row["Marca"];
                            $body = "
                                <tr>
                                    <td>" . trim($row['Descripcion']) . "</td>
                                    " . ($_POST["MonedaPrimeriaMostrar"] != false ? "<td style='text-align: end;'>" . number_format(ROUND($row["PrecioNetoPri"], $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])  . "</td>" : "") . "
                                    " . ($_POST["MonedaSecundariaMostrar"] != false ? "<td style='text-align: end;'>" . number_format(ROUND($row["PrecioNetoPri"] * $BCVtasa, $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . "</td>" : "") . "
                                </tr>
                            ";

                            $excel[] = [
                                "Descripcion" => "",
                                "PrecioNetoPri" => "",
                                "PrecioNeto" => "",
                            ];
                            $excel[] = [
                                "Descripcion" => "",
                                "PrecioNetoPri" => $Marca,
                                "PrecioNeto" => "",
                            ];

                            $excel[] = [
                                "Descripcion" => "Producto",
                                "PrecioNetoPri" => ($_POST["MonedaPrimeriaMostrar"] != false ? "Precio (" . $company["MonedaP"] . ") " : ""),
                                "PrecioNeto" => ($_POST["MonedaSecundariaMostrar"] != false ? "Precio (BCV)" : ""),
                            ];
                            $n = 1;
                        } else {
                            $body .= "
                                <tr>
                                    <td>" . trim($row['Descripcion']) . "</td>
                                    " . ($_POST["MonedaPrimeriaMostrar"] != false ? "<td style='text-align: end;'>" . number_format(ROUND($row["PrecioNetoPri"], $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . "</td>" : "") . "
                                    " . ($_POST["MonedaSecundariaMostrar"] != false ? "<td style='text-align: end;'>" . number_format(ROUND($row["PrecioNetoPri"] * $BCVtasa, $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . "</td>" : "") . "
                                    
                                </tr>
                            ";
                            $n++;
                        }

                        $excel[] = [
                            "Descripcion" => trim($row['Descripcion']),
                            "PrecioNetoPri" => ($_POST["MonedaPrimeriaMostrar"] != false ? number_format(ROUND(ROUND($row["PrecioNetoPri"], $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : ""),
                            "PrecioNeto" => ($_POST["MonedaSecundariaMostrar"] != false ? ($moneda !== $company["MonedaP"] ? number_format(ROUND(ROUND($row["PrecioNetoPri"] * $BCVtasa, $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : "") : ""),
                        ];
                        $m++;
                    }
                    mysqli_free_result($result);
                }
                if ($n > 0) {
                    echo '
                        <section class="product-category">
                            <h3>' . $Marca . '</h3>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                                ' . ($_POST["MonedaPrimeriaMostrar"] != false ? '<th style="text-align: end;">' . "Precio (" . $company["MonedaP"] . ") " . '</th>' : '') . '
                                                ' . ($_POST["MonedaSecundariaMostrar"] != false ? '<th style="text-align: end;">' . "Precio (BCV) " . '</th>' : '') . '
                                    </tr>
                                </thead>
                                <tbody>
                                    ' . $body . '
                                </tbody>
                            </table>
                        </section>
                    ';
                    $Marca = "";
                    $Familia = "";
                    $body = "";
                    $n = 0;
                }
            } else {

                if ($result = mysqli_query($conn, $query . " " . $agregarLeft . " " . $Orden)) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        if ($Familia === "") {
                            $Familia = $row["Familia"];

                            $excel[] = [
                                "Descripcion" => $Familia,
                                "PrecioNetoPri" => "",
                                "PrecioNeto" => "",
                            ];

                            $excel[] = [
                                "Descripcion" => "Producto",
                                "PrecioNetoPri" => ($_POST["MonedaPrimeriaMostrar"] != false ? "Precio (" . $company["MonedaP"] . ") " : ""),
                                "PrecioNeto" => ($_POST["MonedaSecundariaMostrar"] != false ? "Precio (BCV)" : ""),
                            ];
                        }
                        if ($Familia <> $row["Familia"]) {
                            echo '
                            <section class="product-category">
                                <h2>' . $Familia . '</h2>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                                ' . ($_POST["MonedaPrimeriaMostrar"] != false ? '<th style="text-align: end;">' . "Precio (" . $company["MonedaP"] . ") " . '</th>' : '') . '
                                                ' . ($_POST["MonedaSecundariaMostrar"] != false ? '<th style="text-align: end;">' . "Precio (BCV) " . '</th>' : '') . '
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ' . $body . '
                                    </tbody>
                                </table>
                            </section>
                        ';

                            $Familia = $row["Familia"];


                            $body = "";
                            $body .= "
                                        <tr>
                                            <td>" . trim($row['Descripcion']) . "</td>
                                            " . ($_POST["MonedaPrimeriaMostrar"] != false ? "<td style='text-align: end;'>" . number_format(ROUND($row["PrecioNetoPri"], $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . "</td>" : "") . "
                                            " . ($_POST["MonedaSecundariaMostrar"] != false ? ($moneda !== $company["MonedaP"] ? "<td style='text-align: end;'>" . number_format(ROUND($row["PrecioNetoPri"] * $BCVtasa, $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . "</td>" : "") : "") . "
                                        </tr>
                                    ";
                            $excel[] = [
                                "Descripcion" => "",
                                "PrecioNetoPri" => "",
                                "PrecioNeto" => "",
                            ];

                            $excel[] = [
                                "Descripcion" => $Familia,
                                "PrecioNetoPri" => "",
                                "PrecioNeto" => "",
                            ];
                            $excel[] = [
                                "Descripcion" => "Producto",
                                "PrecioNetoPri" => ($_POST["MonedaPrimeriaMostrar"] != false ? "Precio (" . $company["MonedaP"] . ") " : ""),
                                "PrecioNeto" => ($_POST["MonedaSecundariaMostrar"] != false ? "Precio (BCV)" : ""),
                            ];
                            $excel[] = [
                                "Descripcion" => trim($row['Descripcion']),
                                "PrecioNetoPri" => ($_POST["MonedaPrimeriaMostrar"] != false ? number_format(ROUND(ROUND($row["PrecioNetoPri"], $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])  : ""),
                                "PrecioNeto" => ($_POST["MonedaSecundariaMostrar"] != false ? ($moneda !== $company["MonedaP"] ? number_format(ROUND(ROUND($row["PrecioNetoPri"] * $BCVtasa, $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : "") : ""),
                            ];

                            $n = 0;
                        } else {
                            $body .= "
                                        <tr>
                                            <td>" . trim($row['Descripcion']) . "</td>
                                            " . ($_POST["MonedaPrimeriaMostrar"] != false ? "<td style='text-align: end;'>" . number_format(ROUND($row["PrecioNetoPri"], $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])  . "</td>" : "") . "
                                            " . ($_POST["MonedaSecundariaMostrar"] != false ? ($moneda !== $company["MonedaP"] ? "<td style='text-align: end;'>" . number_format(ROUND($row["PrecioNetoPri"] * $BCVtasa, $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . "</td>" : "") : "") . "
                                        </tr>
                                    ";
                            $excel[] = [
                                "Descripcion" => trim($row['Descripcion']),
                                "PrecioNetoPri" => ($_POST["MonedaPrimeriaMostrar"] != false ? number_format(ROUND(ROUND($row["PrecioNetoPri"], $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : ""),
                                "PrecioNeto" => ($_POST["MonedaSecundariaMostrar"] != false ? ($moneda !== $company["MonedaP"] ? number_format(ROUND(ROUND($row["PrecioNetoPri"] * $BCVtasa, $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])  : "") : ""),
                            ];
                            $n++;
                        }
                    }
                    mysqli_free_result($result);
                }

                if ($n > 0) {
                    echo '
                    <section class="product-category">
                        <h2>' . $Familia . '</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                                ' . ($_POST["MonedaPrimeriaMostrar"] != false ? '<th style="text-align: end;">' . "Precio (" . $company["MonedaP"] . ") " . '</th>' : '') . '
                                                ' . ($_POST["MonedaSecundariaMostrar"] != false ? '<th style="text-align: end;">' . "Precio (BCV) " . '</th>' : '') . '
                                </tr>
                            </thead>
                            <tbody>
                                ' . $body . '
                            </tbody>
                        </table>
                    </section>
                ';
                }
            }
            ?>
        </div>
        <div style="width: 50%">
            <?php
            $Familia2 = "";
            $Marca2 = "";
            $body2 = "";
            if ($_POST["Agrupar"] === "FamiliaMarca") {
                $query2 = "SELECT a.CodIdAmpliado,a.CodIdBasico,a.CodBarra, a.Descripcion ,a.Envase,e.ITEM as Familia,b.Nombre as Marca, a.CodBarra,
                    " . $price . "
                    a.CantP1,h.qty_on_hand as Cantidad
                    FROM PosUpProducto a
    left join inv_existencias h on a.CodIdBasico = h.CodIdBasico
    and h.IdCompany = a.IdCompany
                    left join PosUpc_marcas b on a.IdCompany = b.IdCompany and a.Marca = b.idmarca 
                    left join PosUpvarios e on a.IdCompany=e.IdCompany and a.Idfamilia=e.IdVarios and e.TIPOITEM= 2
                    where a.IdCompany= " . $_POST["CompanyActual"] . " 
    " . (!empty($almacenes) ? " and h.IdAlm in (" . implode(",", $almacenes) . ")" : "") . "
                    and a.EsCompuesto in (20,1,0) 
    AND h.qty_on_hand > 0
                    " . $beetween . " 
                    " . $buscar . "
                ";
                $n2 = 0;
                $m2 = 0;
                if ($result2 = mysqli_query($conn, $query2 . " " . $agregarRight . "  GROUP by a.CodIdBasico order by e.ITEM ASC, b.Nombre desc")) {
                    while ($row2 = mysqli_fetch_assoc($result2)) {

                        if ($m2 === 0) {
                            $Familia2 = $row2["Familia"];
                            $Marca2 = $row2["Marca"];

                            $excel[] = [
                                "Descripcion" => "",
                                "PrecioNetoPri" => "",
                                "PrecioNeto" => "",
                            ];

                            $excel[] = [
                                "Descripcion" => $Familia2,
                                "PrecioNetoPri" => "",
                                "PrecioNeto" => "",
                            ];


                            $excel[] = [
                                "Descripcion" => "",
                                "PrecioNetoPri" => $Marca2,
                                "PrecioNeto" => "",
                            ];

                            $excel[] = [
                                "Descripcion" => "Producto",
                                "PrecioNetoPri" => ($_POST["MonedaPrimeriaMostrar"] != false ? "Precio (" . $company["MonedaP"] . ") " : ""),
                                "PrecioNeto" => ($_POST["MonedaSecundariaMostrar"] != false ? "Precio (BCV)" : ""),
                            ];
                            echo '
                                <div><h2>' . $Familia2 . '</h2></div>
                            ';
                        }
                        if ($Familia2 <> $row2["Familia"]) {
                            echo '
                                <section class="product-category">
                                    <h3>' . $Marca2 . '</h3>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                ' . ($_POST["MonedaPrimeriaMostrar"] != false ? '<th style="text-align: end;">' . "Precio (" . $company["MonedaP"] . ") " . '</th>' : '') . '
                                                ' . ($_POST["MonedaSecundariaMostrar"] != false ? '<th style="text-align: end;">' . "Precio (BCV) " . '</th>' : '') . '
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ' . $body2 . '
                                        </tbody>
                                    </table>
                                </section>
                            ';
                            $Familia2 = $row2["Familia"];
                            echo '
                                <div><h2>' . $Familia2 . '</h2></div>
                            ';
                            $Marca2 = $row2["Marca"];
                            $body2 = "
                                <tr>
                                    <td>" . trim($row2['Descripcion']) . "</td>
                                    " . ($_POST["MonedaPrimeriaMostrar"] != false ? "<td style='text-align: end;'>" . number_format(ROUND($row2["PrecioNetoPri"], $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . "</td>" : "") . "
                                    " . ($_POST["MonedaSecundariaMostrar"] != false ? "<td style='text-align: end;'>" . number_format(ROUND($row2["PrecioNetoPri"] * $BCVtasa, $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . "</td>" : "") . "
                                </tr>
                            ";
                            $excel[] = [
                                "Descripcion" => "",
                                "PrecioNetoPri" => "",
                                "PrecioNeto" => "",
                            ];

                            $excel[] = [
                                "Descripcion" => $Familia2,
                                "PrecioNetoPri" => "",
                                "PrecioNeto" => "",
                            ];


                            $excel[] = [
                                "Descripcion" => "",
                                "PrecioNetoPri" => $Marca2,
                                "PrecioNeto" => "",
                            ];

                            $excel[] = [
                                "Descripcion" => "Producto",
                                "PrecioNetoPri" => ($_POST["MonedaPrimeriaMostrar"] != false ? "Precio (" . $company["MonedaP"] . ") " : ""),
                                "PrecioNeto" => ($_POST["MonedaSecundariaMostrar"] != false ? "Precio (BCV)" : ""),
                            ];

                            $n2 = 1;
                        } else if ($Marca2 <> $row2["Marca"]) {
                            echo '
                                <section class="product-category">
                                    <h3>' . $Marca2 . '</h3>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                ' . ($_POST["MonedaPrimeriaMostrar"] != false ? '<th style="text-align: end;">' . "Precio (" . $company["MonedaP"] . ") " . '</th>' : '') . '
                                                ' . ($_POST["MonedaSecundariaMostrar"] != false ? '<th style="text-align: end;">' . "Precio (BCV) " . '</th>' : '') . '
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ' . $body2 . '
                                        </tbody>
                                    </table>
                                </section>
                            ';
                            $Marca2 = $row2["Marca"];
                            $body2 = "
                                <tr>
                                    <td>" . trim($row2['Descripcion']) . "</td>
                                    " . ($_POST["MonedaPrimeriaMostrar"] != false ? "<td style='text-align: end;'>" . number_format(ROUND($row2["PrecioNetoPri"], $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])  . "</td>" : "") . "
                                    " . ($_POST["MonedaSecundariaMostrar"] != false ? "<td style='text-align: end;'>" . number_format(ROUND($row2["PrecioNetoPri"] * $BCVtasa, $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])  . "</td>" : "") . "
                                </tr>
                            ";
                            $n2 = 1;
                            $excel[] = [
                                "Descripcion" => "",
                                "PrecioNetoPri" => "",
                                "PrecioNeto" => "",
                            ];

                            $excel[] = [
                                "Descripcion" => "",
                                "PrecioNetoPri" => $Marca2,
                                "PrecioNeto" => "",
                            ];

                            $excel[] = [
                                "Descripcion" => "Producto",
                                "PrecioNetoPri" => ($_POST["MonedaPrimeriaMostrar"] != false ? "Precio (" . $company["MonedaP"] . ") " : ""),
                                "PrecioNeto" => ($_POST["MonedaSecundariaMostrar"] != false ? "Precio (BCV)" : ""),
                            ];
                        } else {
                            $body2 .= "
                                <tr>
                                    <td>" . trim($row2['Descripcion']) . "</td>
                                    " . ($_POST["MonedaPrimeriaMostrar"] != false ? "<td style='text-align: end;'>" . number_format(ROUND($row2["PrecioNetoPri"], $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . "</td>" : "") . "
                                    " . ($_POST["MonedaSecundariaMostrar"] != false ? "<td style='text-align: end;'>" . number_format(ROUND($row2["PrecioNetoPri"] * $BCVtasa, $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])  . "</td>" : "") . "
                                </tr>
                            ";
                            $n2++;
                        }


                        $excel[] = [
                            "Descripcion" => trim($row2['Descripcion']),
                            "PrecioNetoPri" => ($_POST["MonedaPrimeriaMostrar"] != false ? number_format(ROUND($row2["PrecioNetoPri"], $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])  : ""),
                            "PrecioNeto" => ($_POST["MonedaSecundariaMostrar"] != false ? ($moneda !== $company["MonedaP"] ? number_format(ROUND(ROUND($row2["PrecioNetoPri"] * $BCVtasa, $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : "") : ""),
                        ];
                        $m2++;
                    }
                    mysqli_free_result($result2);
                }

                if ($n2 > 0) {
                    echo '
                        <section class="product-category">
                            <h3>' . $Marca2 . '</h3>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        ' . ($_POST["MonedaPrimeriaMostrar"] != false ? '<th style="text-align: end;">' . "Precio (" . $company["MonedaP"] . ") " . '</th>' : '') . '
                                        ' . ($_POST["MonedaSecundariaMostrar"] != false ? '<th style="text-align: end;">' . "Precio (BCV) " . '</th>' : '') . '
                                    </tr>
                                </thead>
                                <tbody>
                                    ' . $body2 . '
                                </tbody>
                            </table>
                        </section>
                    ';
                    $Marca2 = "";
                    $Familia2 = "";
                    $body2 = "";
                    $n2 = 0;
                }
            } else {
                if ($result2 = mysqli_query($conn, $query . " " . $agregarRight . " " . $Orden)) {
                    while ($row2 = mysqli_fetch_assoc($result2)) {
                        if ($Familia2 === "") {
                            $Familia2 = $row2["Familia"];

                            $excel[] = [
                                "Descripcion" => $Familia2,
                                "PrecioNetoPri" => "",
                                "PrecioNeto" => "",
                            ];

                            $excel[] = [
                                "Descripcion" => "Producto",
                                "PrecioNetoPri" => ($_POST["MonedaPrimeriaMostrar"] != false ? "Precio (" . $company["MonedaP"] . ") " : ""),
                                "PrecioNeto" => ($_POST["MonedaSecundariaMostrar"] != false ? "Precio (BCV)" : ""),
                            ];
                        }
                        if ($Familia2 <> $row2["Familia"]) {
                            echo '
                            <section class="product-category">
                                <h2>' . $Familia2 . '</h2>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                                ' . ($_POST["MonedaPrimeriaMostrar"] != false ? '<th style="text-align: end;">' . "Precio (" . $company["MonedaP"] . ") " . '</th>' : '') . '
                                                ' . ($_POST["MonedaSecundariaMostrar"] != false ? '<th style="text-align: end;">' . "Precio (BCV) " . '</th>' : '') . '
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ' . $body2 . '
                                    </tbody>
                                </table>
                            </section>
                        ';

                            $Familia2 = $row2["Familia"];
                            $body2 = "
                        <tr>
                            <td>" . trim($row2['Descripcion']) . "</td>
                            " . ($_POST["MonedaPrimeriaMostrar"] != false ? "<td style='text-align: end;'>" . number_format(ROUND($row2["PrecioNetoPri"], $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . "</td>" : "") . "
                            " . ($_POST["MonedaSecundariaMostrar"] != false ? ($moneda !== $company["MonedaP"] ? "<td style='text-align: end;'>" . number_format(ROUND($row2["PrecioNetoPri"] * $BCVtasa, $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . "</td>" : "") : "") . "
                        </tr>
                    ";
                            $excel[] = [
                                "Descripcion" => "",
                                "PrecioNetoPri" => "",
                                "PrecioNeto" => "",
                            ];

                            $excel[] = [
                                "Descripcion" => $Familia2,
                                "PrecioNetoPri" => "",
                                "PrecioNeto" => "",
                            ];
                            $excel[] = [
                                "Descripcion" => "Producto",
                                "PrecioNetoPri" => ($_POST["MonedaPrimeriaMostrar"] != false ? "Precio (" . $company["MonedaP"] . ") " : ""),
                                "PrecioNeto" => ($_POST["MonedaSecundariaMostrar"] != false ? "Precio (BCV)" : ""),
                            ];
                            $excel[] = [
                                "Descripcion" => trim($row2['Descripcion']),
                                "PrecioNetoPri" => ($_POST["MonedaPrimeriaMostrar"] != false ? number_format(ROUND($row2["PrecioNetoPri"], $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : ""),
                                "PrecioNeto" => ($_POST["MonedaSecundariaMostrar"] != false ?  ($moneda !== $company["MonedaP"] ? number_format(ROUND($row2["PrecioNetoPri"] * $BCVtasa, $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : "") : ""),
                            ];

                            $n2 = 0;
                        } else {
                            $body2 .= "
                        <tr>
                            <td>" . trim($row2['Descripcion']) . "</td>
                            " . ($_POST["MonedaPrimeriaMostrar"] != false ?  "<td style='text-align: end;'>" . number_format(ROUND($row2["PrecioNetoPri"], $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . "</td>" : "") . "
                            " . ($_POST["MonedaSecundariaMostrar"] != false ? ($moneda !== $company["MonedaP"] ? "<td style='text-align: end;'>" . number_format(ROUND($row2["PrecioNetoPri"] * $BCVtasa, $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . "</td>" : "") : "") . "
                        </tr>
                    ";
                            $excel[] = [
                                "Descripcion" => trim($row2['Descripcion']),
                                "PrecioNetoPri" => ($_POST["MonedaPrimeriaMostrar"] != false ? number_format(ROUND($row2["PrecioNetoPri"], $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])  : ""),
                                "PrecioNeto" => ($_POST["MonedaSecundariaMostrar"] != false ?  ($moneda !== $company["MonedaP"] ?  number_format(ROUND($row2["PrecioNetoPri"] * $BCVtasa, $_POST["redondeadoCheck"] === "on" ? 0 : 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : "") : ""),
                            ];
                            $n2++;
                        }
                    }
                    mysqli_free_result($result2);
                }

                if ($n2 > 0) {
                    echo '
                    <section class="product-category">
                        <h2>' . $Familia2 . '</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    ' . ($_POST["MonedaPrimeriaMostrar"] != false ? '<th style="text-align: end;">' . "Precio (" . $company["MonedaP"] . ") " . '</th>' : '') . '
                                    ' . ($_POST["MonedaSecundariaMostrar"] != false ? '<th style="text-align: end;">' . "Precio (BCV) " . '</th>' : '') . '
                                </tr>
                            </thead>
                            <tbody>
                                ' . $body2 . '
                            </tbody>
                        </table>
                    </section>
                ';
                }
            }
            ?>
        </div>

        <form id="formexcel" action="excelnew.php" method="post">
            <?php
            $name = lang("ListaPrecios");
            ?>

            <input type="hidden" name="array" value='<?php echo json_encode($excel, JSON_UNESCAPED_UNICODE); ?>' />
            <input type="hidden" name="Name" value='<?php echo $name; ?>' />
            <input type="hidden" name="vas" value='listapreciogoubat' />
        </form>
    </div>

</body>

</html>
<?php
