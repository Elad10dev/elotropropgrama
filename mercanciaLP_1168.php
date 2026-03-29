<?php


include "ambiente.php";
$conn = ConectarConsultas();
session_start();

if ($_SESSION['IdiomaActual'] == '') {
    $_SESSION['IdiomaActual'] = $_POST['IdiomaActual'];
}

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


$calcTotal = 38.5;
$n = 0;

$Having = [];

if ($_POST["costozzzv"] == "on") {
    $n++;
    $Having[] = "costo > 0";
}
if ($_POST["precioz"] == "on") {
    $n++;
    $Having[] = "PrecioNeto > 0";
}
if ($_POST["precio2z"] == "on") {
    $n++;
    $Having[] = "PrecioNeto2 > 0";
}
if ($_POST["precio3z"] == "on") {
    $n++;
    $Having[] = "PrecioNeto3 > 0";
}
if ($_POST["precio4z"] == "on") {
    $n++;
    $Having[] = "PrecioNeto4 > 0";
}
if ($_POST["precio5z"] == "on") {
    $n++;
    $Having[] = "PrecioNeto5 > 0";
}
if ($_POST["precio6z"] == "on") {
    $n++;
    $Having[] = "PrecioNeto6 > 0";
}
if ($_POST["precio7z"] == "on") {
    $n++;
    $Having[] = "PrecioNeto7 > 0";
}
if ($_POST["precio8z"] == "on") {
    $n++;
    $Having[] = "PrecioNeto8 > 0";
}
if ($_POST["precio9z"] == "on") {
    $n++;
    $Having[] = "PrecioNeto9 > 0";
}
if ($_POST["precio10z"] == "on") {
    $n++;
    $Having[] = "PrecioNeto10 > 0";
}

$calc = $calcTotal / $n;

?>
<!DOCTYPE html>
<html lang="en">

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
    <div style="font-size: 11px;">
        <?php
        if ($_POST["Agrupar"] == "empty") {
        ?>
            <table>
                <thead>
                    <tr>
                        <!-- <th><?php echo lang("S.K.U"); ?></th> -->

                        <th><?php echo lang("Descripción"); ?></th>
                        <?php
                        if ($_POST["MostrarMarcas"] === "on") {
                        ?>
                            <th><?php echo lang("Marca"); ?></th>

                        <?php
                        }
                        if ($_POST["MostrarFamilias"] === "on") {
                        ?>
                            <th><?php echo lang("Familia"); ?></th>

                        <?php
                        }
                        if ($_POST["Existencia"] == "on") {
                        ?>

                            <th><?php echo lang("Existencia"); ?> </th>
                            <th><?php echo lang("Desglose"); ?> </th>

                        <?php
                        }

                        if ($_POST["costozzzv"] == "on") {
                        ?>
                            <th><?php echo (trim($LitCosto) !== "" ? $LitCosto : lang("Costo")); ?></th>
                        <?php
                        }
                        if ($_POST["precioz"] == "on") {
                        ?>
                            <th><?php echo (trim($LitP01) !== "" ? $LitP01 : lang("Precio") . " 1"); ?></th>
                        <?php
                        }
                        if ($_POST["precio2z"] == "on") {
                        ?>
                            <th><?php echo (trim($LitP02) !== "" ? $LitP02 : lang("Precio") . " 2"); ?></th>
                        <?php
                        }
                        if ($_POST["precio3z"] == "on") {
                        ?>
                            <th><?php echo (trim($LitP03) !== "" ? $LitP03 : lang("Precio") . " 3"); ?></th>
                        <?php
                        }
                        if ($_POST["precio4z"] == "on") {
                        ?>
                            <th><?php echo (trim($LitP04) !== "" ? $LitP04 : lang("Precio") . " 4"); ?> </th>
                        <?php
                        }
                        if ($_POST["precio5z"] == "on") {
                        ?>
                            <th><?php echo (trim($LitP05) !== "" ? $LitP05 : lang("Precio") . " 5"); ?> </th>
                        <?php
                        }
                        if ($_POST["precio6z"] == "on") {
                        ?>
                            <th><?php echo (trim($LitP06) !== "" ? $LitP06 : lang("Precio") . " 6"); ?> </th>
                        <?php
                        }
                        if ($_POST["precio7z"] == "on") {
                        ?>
                            <th><?php echo (trim($LitP07) !== "" ? $LitP07 : lang("Precio") . " 7"); ?> </th>
                        <?php
                        }
                        if ($_POST["precio8z"] == "on") {
                        ?>
                            <th><?php echo (trim($LitP08) !== "" ? $LitP08 : lang("Precio") . " 8"); ?> </th>
                        <?php
                        }
                        if ($_POST["precio9z"] == "on") {
                        ?>
                            <th><?php echo (trim($LitP09) !== "" ? $LitP09 : lang("Precio") . " 9"); ?> </th>
                        <?php
                        }
                        if ($_POST["precio10z"] == "on") {
                        ?>
                            <th><?php echo (trim($LitP10) !== "" ? $LitP10 : lang("Precio") . " 10"); ?> </th>
                        <?php
                        }
                        if ($_POST["cimp"] == "on") {
                        ?>
                            <th>%<?php echo lang("Imp"); ?></th>
                        <?php
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>

                    <?php

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
                        $familia = " and a.Idfamilia " . ($_POST["NotIncludeFamilia"] === "on" ? "not" : "") . " in ('" . implode("','", $_POST["mIdfamilia"]) . "') ";
                    }

                    if (!empty($_POST["mIdProductos"])) {
                        $beetween = " and a.CodIdBasico " . ($_POST["NotIncludeProductos"] === "on" ? "not" : "") . " in ('" . implode("','", $_POST["mIdProductos"]) . "') ";
                    }
                    if (!empty($_POST["mIdAlmacen"])) {
                        $Deposito = " and b.IdAlm " . ($_POST["NotIncludeAlmacen"] === "on" ? "not" : "") . " in ('" . implode("','", $_POST["mIdAlmacen"]) . "')";
                        $Deposito2 = "where a.IdAlm " . ($_POST["NotIncludeAlmacen"] === "on" ? "not" : "") . " in ('" . implode("','", $_POST["mIdAlmacen"]) . "')";
                        $Deposito4 = " and a.IdAlm " . ($_POST["NotIncludeAlmacen"] === "on" ? "not" : "") . " in ('" . implode("','", $_POST["mIdAlmacen"]) . "')";
                    }

                    if (!empty($_POST["mIdMarca"])) {
                        $Marca = "and a.Marca " . ($_POST["NotIncludeMarca"] === "on" ? "not" : "") . " in ('" . implode("','", $_POST["mIdMarca"]) . "')";
                    }

                    $buscar = "";

                    if ($_POST["EnvioEstado"] !== "*") {
                        $buscar .= "and a.Estado = " . $_POST["EnvioEstado"];
                    }


                    if (!$_POST["ExistenciaCero"] == "on") {
                        $ExistenciaCero = " and round(b.cantidad,3)<>0";
                    }

                    if ($_POST["RefLP1"] == true) {
                        $referencia = "and a.CodBarra='" . $_POST["RefLP1"] . "'";
                    }

                    if ($_POST["Existencia"] == "on") {
                        $existencia = "round(coalesce(b.cantidad,0),2) as Existencia,  ";
                    }
                    if (!$_POST["Existencia"] == "on") {
                        $existencia = "1 as Existencia,";
                    }

                    $fechaA = " where a.Fectxclient <= '" . $_POST["FechaHastalista"] . " 23:59:59'";
                    $fechaC = " where c.Fectxclient <= '" . $_POST["FechaHastalista"] . " 23:59:59'";
                    $fechaAA = " and a.Fectxclient <= '" . $_POST["FechaHastalista"] . " 23:59:59'";
                    $fechaCA = " and c.Fectxclient <= '" . $_POST["FechaHastalista"] . " 23:59:59'";


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
                        " . $Orden . "
                        " . $limit . "
                    ";
                    $n = 0;
                    if ($result = mysqli_query($conn, $query)) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $n = $n + 1;
                            $nt = $nt + 1;

                            $CostoXexist = $row["costo"] * $row["Existencia"];
                            $CostoXexistT = $CostoXexist + $CostoXexistT;
                            $existenciaX = $existenciaX + $row["Existencia"];

                            $precio = $row["PrecioNeto"] * $row["Existencia"];
                            $precio2 = $row["PrecioNeto2"] * $row["Existencia"];
                            $precio3 = $row["PrecioNeto3"] * $row["Existencia"];
                            $precio4 = $row["PrecioNeto4"] * $row["Existencia"];
                            $precio5 = $row["PrecioNeto5"] * $row["Existencia"];
                            $precio6 = $row["PrecioNeto6"] * $row["Existencia"];
                            $precio7 = $row["PrecioNeto7"] * $row["Existencia"];
                            $precio8 = $row["PrecioNeto8"] * $row["Existencia"];
                            $precio9 = $row["PrecioNeto9"] * $row["Existencia"];
                            $precioT10 = $row["PrecioNeto10"] * $row["Existencia"];
                            $precioT = $precioT + $precio;
                            $precioT2 = $precioT2 + $precio2;
                            $precioT3 = $precioT3 + $precio3;
                            $precioT4 = $precioT4 + $precio4;
                            $precioT5 = $precioT5 + $precio5;
                            $precioT6 = $precioT6 + $precio6;
                            $precioT7 = $precioT7 + $precio7;
                            $precioT8 = $precioT8 + $precio8;
                            $precioT9 = $precioT9 + $precio9;
                            $precioT10 = $precioT10 + $precioT10;
                            $preciozz = $row["PrecioNeto"] * $row["Existencia"];
                            $precio2zz = $row["PrecioNeto2"] * $row["Existencia"];
                            $precio3zz = $row["PrecioNeto3"] * $row["Existencia"];
                            $precio4zz = $row["PrecioNeto4"] * $row["Existencia"];
                            $precio5zz = $row["PrecioNeto5"] * $row["Existencia"];
                            $precio6zz = $row["PrecioNeto6"] * $row["Existencia"];
                            $precio7zz = $row["PrecioNeto7"] * $row["Existencia"];
                            $precio8zz = $row["PrecioNeto8"] * $row["Existencia"];
                            $precio9zz = $row["PrecioNeto9"] * $row["Existencia"];
                            $precio10zz = $row["PrecioNeto10"] * $row["Existencia"];
                            $precioTz = $precioTz + $preciozz;
                            $precioT2z = $precioT2z + $precio2zz;
                            $precioT3z = $precioT3z + $precio3zz;
                            $precioT4z = $precioT4z + $precio4zz;
                            $precioT5z = $precioT5z + $precio5zz;
                            $precioT6z = $precioT6z + $precio6zz;
                            $precioT7z = $precioT7z + $precio7zz;
                            $precioT8z = $precioT8z + $precio8zz;
                            $precioT9z = $precioT9z + $precio9zz;
                            $precioT10z = $precioT10z + $precio10zz;

                            $CostoXexis2t = $row["costo"] * $row["Existencia"];
                            $CostoXexistT2 = $CostoXexis2t + $CostoXexistT2;
                            $existenciaX2 = $existenciaX2 + $row["Existencia"];

                    ?>
                            <tr>
                                <!-- <td>
                                    <?php
                                    if (trim(trim($row['CodIdAmpliado'])) === "") {
                                        echo "-";
                                    } else {
                                        echo trim($row['CodIdAmpliado']);
                                    }
                                    ?>
                                </td> -->
                                <td>
                                    <?php
                                    if (trim(trim($row['Descripcion'])) === "") {
                                        echo "-";
                                    } else {
                                        echo trim($row['Descripcion']);
                                    }
                                    ?>
                                </td>
                                <?php
                                if ($_POST["MostrarMarcas"] === "on") {
                                ?>
                                    <td>
                                        <?php
                                        if (trim($row['Marca']) == "") {
                                            echo "-";
                                        } else {
                                            echo trim($row['Marca']);
                                        }
                                        ?>
                                    </td>

                                <?php
                                }
                                if ($_POST["MostrarFamilias"] === "on") {
                                ?>
                                    <td>
                                        <?php
                                        if (trim($row['Familia']) == "") {
                                            echo "-";
                                        } else {
                                            echo trim($row['Familia']);
                                        }
                                        ?>
                                    </td>


                                <?php
                                }

                                if ($_POST["Existencia"] == "on") {
                                ?>
                                    <!-- <div class="campo" style="text-align: left; width:6%; ">(1
                <?php
                                    echo $row['uniP1d'];
                                    if ($row['CantP1'] <> 0) {
                                        if ($row['CantP1'] == "" or $row['CantP1'] == 1) {
                                            echo "";
                                        } else {
                                            echo ' = ' . number_format($row['CantP1'], 0, $_POST["SimDec"], $_POST["SimMil"]);
                                            if ($row['uniP2d'] == "") {
                                                echo "";
                                            } else {
                                                echo  ' ' . $row['uniP2d'];
                                            }
                                        }
                                    }
                ?>
                )
            </div> -->
                                    <td>
                                        <?php
                                        if ($row['Existencia'] == "") {
                                            echo "-";
                                        } else {
                                            echo ($row["factorunit"] <> 1 && $row["factorunit"] <> 0 ? " " . $row["factorunit"] . " x " . getcantformat($row["Existencia"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " = " . getcantformat($row["Existencia"] * $row["factorunit"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $row["Medida"] : number_format($row['Existencia'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]));
                                        }
                                        ?>
                                    </td>
                                    <td>&nbsp;
                                        <?php
                                        if ($row['cuniP1d'] <> 0) {
                                            if ($row['cuniP1d'] == "") {
                                                echo "-";
                                            } else {
                                                echo number_format($row['cuniP1d'], 0, $_POST["SimDec"], $_POST["SimMil"]);
                                            }
                                            if ($row['uniP1d'] == "") {
                                                echo "";
                                            } else {
                                                echo  ' (' . substr($row['uniP1d'], 0, 3) . ')';
                                            }
                                        }
                                        if ($row['cuniP2d'] <> 0 and $row['cuniP1d'] <> 0) {
                                            echo ' y ';
                                        }
                                        if ($row['cuniP2d'] <> 0) {
                                            if ($row['cuniP2d'] == "") {
                                                echo "-";
                                            } else {
                                                echo number_format($row['cuniP2d'], 0, $_POST["SimDec"], $_POST["SimMil"]);
                                            }
                                            if ($row['uniP2d'] == "") {
                                                echo "";
                                            } else {
                                                echo  ' (' . substr($row['uniP2d'], 0, 3) . ')';
                                            }
                                        }
                                        ?>
                                    </td>
                                <?php
                                }
                                if ($_POST["costozzzv"] == "on") {
                                ?>
                                    <td>
                                        <?php
                                        if (trim($row['costo']) == "") {
                                            echo "-";
                                        } else {
                                            echo number_format(trim($row['costo']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;
                                        }
                                        ?>
                                    </td>
                                <?php
                                }
                                if ($_POST["precioz"] == "on") {
                                ?>
                                    <td>
                                        <?php
                                        if (trim($row['PrecioNeto']) == "") {
                                            echo "-";
                                        } else {
                                            echo number_format(trim($row['PrecioNeto']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;
                                        }
                                        ?>
                                    </td>
                                <?php
                                }
                                if ($_POST["precio2z"] == "on") {
                                ?>
                                    <td>
                                        <?php
                                        if (trim($row['PrecioNeto2']) == "") {
                                            echo "-";
                                        } else {
                                            echo number_format(trim($row['PrecioNeto2']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;
                                            if ($row['CantP1'] > 1) {
                                                echo  ' / ' . number_format(trim($row['PrecioNeto2']) / $row['CantP1'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                            }
                                        }
                                        ?>
                                    </td>
                                <?php
                                }

                                if ($_POST["precio3z"] == "on") {
                                ?>
                                    <td>
                                        <?php
                                        if (trim($row['PrecioNeto3']) == "") {
                                            echo "-";
                                        } else {
                                            echo number_format(trim($row['PrecioNeto3']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;
                                            if ($row['CantP2'] > 1) {
                                                echo  ' / ' . number_format(trim($row['PrecioNeto3']) / $row['CantP2'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                            }
                                        }
                                        ?>
                                    </td>
                                <?php
                                }

                                if ($_POST["precio4z"] == "on") {
                                ?>
                                    <td>
                                        <?php
                                        if (trim($row['PrecioNeto4']) == "") {
                                            echo "-";
                                        } else {
                                            echo number_format(trim($row['PrecioNeto4']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;
                                            if ($row['CantP4'] > 1) {
                                                echo  ' / ' . number_format(trim($row['PrecioNeto4']) / $row['CantP4'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                            }
                                        }
                                        ?>
                                    </td>
                                <?php
                                }

                                if ($_POST["precio5z"] == "on") {
                                ?>
                                    <td>
                                        <?php
                                        if (trim($row['PrecioNeto5']) == "") {
                                            echo "-";
                                        } else {
                                            echo number_format(trim($row['PrecioNeto5']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;
                                            if ($row['CantP5'] > 1) {
                                                echo  ' / ' . number_format(trim($row['PrecioNeto5']) / $row['CantP5'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                            }
                                        }
                                        ?>
                                    </td>
                                <?php
                                }

                                if ($_POST["precio6z"] == "on") {
                                ?>
                                    <td>
                                        <?php
                                        if (trim($row['PrecioNeto6']) == "") {
                                            echo "-";
                                        } else {
                                            echo number_format(trim($row['PrecioNeto6']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;
                                            if ($row['CantP6'] > 1) {
                                                echo  ' / ' . number_format(trim($row['PrecioNeto6']) / $row['CantP6'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                            }
                                        }
                                        ?>
                                    </td>
                                <?php
                                }

                                if ($_POST["precio7z"] == "on") {
                                ?>
                                    <td>
                                        <?php
                                        if (trim($row['PrecioNeto7']) == "") {
                                            echo "-";
                                        } else {
                                            echo number_format(trim($row['PrecioNeto7']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;
                                            if ($row['CantP7'] > 1) {
                                                echo  ' / ' . number_format(trim($row['PrecioNeto7']) / $row['CantP7'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                            }
                                        }
                                        ?>
                                    </td>
                                <?php
                                }

                                if ($_POST["precio8z"] == "on") {
                                ?>
                                    <td>
                                        <?php
                                        if (trim($row['PrecioNeto8']) == "") {
                                            echo "-";
                                        } else {
                                            echo number_format(trim($row['PrecioNeto8']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;
                                            if ($row['CantP8'] > 1) {
                                                echo  ' / ' . number_format(trim($row['PrecioNeto8']) / $row['CantP8'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                            }
                                        }
                                        ?>
                                    </td>
                                <?php
                                }

                                if ($_POST["precio9z"] == "on") {
                                ?>
                                    <td>
                                        <?php
                                        if (trim($row['PrecioNeto9']) == "") {
                                            echo "-";
                                        } else {
                                            echo number_format(trim($row['PrecioNeto9']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;
                                            if ($row['CantP9'] > 1) {
                                                echo  ' / ' . number_format(trim($row['PrecioNeto9']) / $row['CantP9'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                            }
                                        }
                                        ?>
                                    </td>
                                <?php
                                }

                                if ($_POST["precio10z"] == "on") {
                                ?>
                                    <td>
                                        <?php
                                        if (trim($row['PrecioNeto10']) == "") {
                                            echo "-";
                                        } else {
                                            echo number_format(trim($row['PrecioNeto10']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;
                                            if ($row['CantP10'] > 1) {
                                                echo  ' / ' . number_format(trim($row['PrecioNeto10']) / $row['CantP10'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                            }
                                        }
                                        ?>
                                    </td>
                                <?php
                                }

                                if ($_POST["cimp"] == "on") {
                                ?>
                                    <td>
                                        <?php
                                        if (trim($row['ValorImpuesto']) == "") {
                                            echo "-";
                                        } else {
                                            echo trim($row['ValorImpuesto']);
                                        }
                                        ?>
                                    </td>
                                <?php
                                }
                                ?>


                                </td>
                        <?php


                        }
                        mysqli_free_result($result);
                    }
                    $UltimoRegistro = $row["CodIdBasico"];
                        ?>

                </tbody>
            </table>

            <?php
        } else if ($_POST["Agrupar"] == "Marcazp") {
            if ($_POST["OrdenLP"] == "Codigo") {
                $Orden = "order by d.nombre,a.CodIdBasico";
            }
            if ($_POST["OrdenLP"] == "Descripcion") {
                $Orden = "order by d.nombre,a.Descripcion";
            }
            if ($_POST["OrdenLP"] == "Referencia") {
                $Orden = "order by d.nombre, a.CodBarra";
            }
            if ($_POST["OrdenLP"] == "Marca") {
                $Orden = "order by d.nombre";
            }
            if ($_POST["OrdenLP"] == "Instancia") {
                $Orden = "order by d.nombre,e.ITEM";
            }

            if ($_POST["OrdenLP"] == "PrecioNeto") {
                $Orden = "order by a.PrecioNeto desc";
            }

            if (!empty($_POST["mIdfamilia"])) {
                $familia = " and a.Idfamilia " . ($_POST["NotIncludeFamilia"] === "on" ? "not" : "") . " in ('" . implode("','", $_POST["mIdfamilia"]) . "') ";
            }

            if (!empty($_POST["mIdProductos"])) {
                $beetween = " and a.CodIdBasico " . ($_POST["NotIncludeProductos"] === "on" ? "not" : "") . " in ('" . implode("','", $_POST["mIdProductos"]) . "') ";
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
            if ($_POST['costozzzv'] == true) {
                if ($_POST['cimp'] == false) {
                    $costo = "round(coalesce(a.CostoNeto,0),2) as costo,";
                } else {
                    $costo = "round(coalesce(a.Costo,0),2) as costo,";
                }
            } else {

                $costo = "";
            }
            if ($_POST['sucursal'] <> '0') {
                $ubic = " and f.IdUbi=" . $_POST['sucursal'];
            }
            $query = "SELECT DISTINCT a.CodIdAmpliado,a.CodIdBasico,a.CodBarra, a.Descripcion ,a.Envase,e.ITEM as Familia,
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
                " . $fechaA . " " . $ubic . " 
                " . $Deposito4 . " and a.IdCompany= " . $_POST["CompanyActual"] . "
                group by a.IdCompany,b.CodIdBasico
                ) b on a.IdCompany = b.IdCompany and a.CodIdBasico = b.CodIdBasico
                left join (SELECT a.IdCompany,a.RUT, b.idBen, c.CodIdBasico from PosUpclientes a
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
                inner join PosUpvarios f on a.IdCompany=f.IdCompany and a.Impuesto=f.IdVarios and f.TIPOITEM= 0
                where a.IdCompany= " . $_POST["CompanyActual"] . " and a.EsCompuesto in (20,1,0) " . $beetween . " 
                " . $buscar . "
                " . $ExistenciaCero . "                                       
                " . $Marca . "
                " . $familia . "
                " . $referencia . "
                    " . (!empty($Having) ? "HAVING " . implode(" or ", $Having) : "") . "
                " . $Orden . "
                " . $limit . "
            ";
            if ($result = mysqli_query($conn, $query)) {
                $n = 0;

                while ($row = mysqli_fetch_assoc($result)) {
                    $n = $n + 1;
                    $ntp = $ntp + 1;
                    $nt = $nt + 1;
                    $npa = $npa + 1;

                    $MarAct = trim($row['Marca']);

                    $nas = $nas + 1;
                    $nel = $nel + 1;
                    $nop = $nop + 1;
                    if ($MarAct == $MarAct) {
                        if ($nas > 7 and $nel < 14) {
                            $n = $n - 2;
                            $nas = 0;
                        } else if ($nel > 14) {
                            $n = $n - 1;
                            $nel = 0;
                        }
                    }
                    if ($MarAct == $MarAct and $npix2 == false) {
                        $npix2 = $npix2 + 12;
            ?>
                        <div>
                            <h2><strong> <?php echo $MarAct;  ?> </strong> </h2>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <!-- <th ><?php echo lang("S.K.U"); ?></th> -->
                                    <th><?php echo lang("Descripción"); ?></th>
                                    <?php

                                    if ($_POST["MostrarFamilias"] === "on") {
                                    ?>
                                        <th><?php echo lang("Familia"); ?></th>

                                    <?php
                                    }
                                    if ($_POST["Existencia"] == "on") {
                                    ?>
                                        <th><?php echo lang("Existencia"); ?></th>
                                        <th><?php echo lang("Desglose"); ?> </th>
                                    <?php
                                    }
                                    if ($_POST["costozzzv"] == "on") {
                                    ?>
                                        <th><?php echo (trim($LitCosto) !== "" ? $LitCosto : lang("Costo")); ?></th>
                                    <?php
                                    }
                                    if ($_POST["precioz"] == "on") {
                                    ?>
                                        <th><?php echo (trim($LitP01) !== "" ? $LitP01 : lang("Precio") . " 1"); ?></th>
                                    <?php
                                    }
                                    ?>
                                    <?php if ($_POST["precio2z"] == "on") {
                                    ?>
                                        <th><?php echo (trim($LitP02) !== "" ? $LitP02 : lang("Precio") . " 2"); ?></th>
                                    <?php
                                    }
                                    ?>
                                    <?php if ($_POST["precio3z"] == "on") {
                                    ?>
                                        <th><?php echo (trim($LitP03) !== "" ? $LitP03 : lang("Precio") . " 3"); ?></th>
                                    <?php
                                    }
                                    ?>

                                    <?php if ($_POST["precio4z"] == "on") {
                                    ?>
                                        <th><?php echo (trim($LitP04) !== "" ? $LitP04 : lang("Precio") . " 4"); ?> </th>
                                    <?php
                                    }  ?>

                                    <?php if ($_POST["precio5z"] == "on") {
                                    ?>
                                        <th><?php echo (trim($LitP05) !== "" ? $LitP05 : lang("Precio") . " 5"); ?> </th>
                                    <?php
                                    }  ?>

                                    <?php if ($_POST["precio6z"] == "on") {
                                    ?>
                                        <th><?php echo (trim($LitP06) !== "" ? $LitP06 : lang("Precio") . " 6"); ?> </th>
                                    <?php
                                    }  ?>

                                    <?php if ($_POST["precio7z"] == "on") {
                                    ?>
                                        <th><?php echo (trim($LitP07) !== "" ? $LitP07 : lang("Precio") . " 7"); ?> </th>
                                    <?php
                                    }  ?>

                                    <?php if ($_POST["precio8z"] == "on") {
                                    ?>
                                        <th><?php echo (trim($LitP08) !== "" ? $LitP08 : lang("Precio") . " 8"); ?> </th>
                                    <?php
                                    }  ?>

                                    <?php if ($_POST["precio9z"] == "on") {
                                    ?>
                                        <th><?php echo (trim($LitP09) !== "" ? $LitP09 : lang("Precio") . " 9"); ?> </th>
                                    <?php
                                    }  ?>

                                    <?php if ($_POST["precio10z"] == "on") {
                                    ?>
                                        <th><?php echo (trim($LitP10) !== "" ? $LitP10 : lang("Precio") . " 10"); ?> </th>
                                    <?php
                                    }  ?>
                                    <?php if ($_POST['cimp'] == "on") {
                                    ?>
                                        <th>%<?php echo lang("Imp"); ?></th>
                                    <?php
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $n = $n + 2;
                        }
                        if ($MarAct <> $MarAct2 and $npi2 >= 1) {
                            $nas = 0;
                            $nel = 0;
                            $nop = 0;
                            $CostoXexistT = 0;
                            $existenciaX = 0;
                            $precioT = 0;
                            $precioT2 = 0;
                            $precioT3 = 0;
                            $precioT4 = 0;
                            $precioT5 = 0;
                            $precioT6 = 0;
                            $precioT7 = 0;
                            $precioT8 = 0;
                            $precioT9 = 0;
                            $precioT10 = 0;
                            ?>
                            </tbody>
                        </table>

                        <div class="campo">
                            <h2><strong> <?php echo $MarAct;  ?> </strong> </h2>
                        </div>

                        <table>
                            <thead>
                                <tr>
                                    <!-- <th ><?php echo lang("S.K.U"); ?></th> -->
                                    <th><?php echo lang("Descripción"); ?></th>
                                    <?php

                                    if ($_POST["MostrarFamilias"] === "on") {
                                    ?>
                                        <th><?php echo lang("Familia"); ?></th>

                                    <?php
                                    }
                                    if ($_POST["Existencia"] == "on") {
                                    ?>
                                        <!-- <th class="campo" style=" text-align: left; width: 8%; background-color: gray;"><?php echo lang("Referencia"); ?> </th> -->
                                        <th><?php echo lang("Existencia"); ?> </th>
                                        <th><?php echo lang("Desglose"); ?> </th>
                                    <?php }
                                    if ($_POST["costozzzv"] == "on") {
                                    ?>
                                        <th><?php echo (trim($LitCosto) !== "" ? $LitCosto : lang("Costo")); ?></th>
                                    <?php
                                    }
                                    if ($_POST["precioz"] == "on") {
                                    ?>
                                        <th><?php echo (trim($LitP01) !== "" ? $LitP01 : lang("Precio") . " 1"); ?></th>
                                    <?php
                                    }
                                    ?>
                                    <?php if ($_POST["precio2z"] == "on") {
                                    ?>
                                        <th><?php echo (trim($LitP02) !== "" ? $LitP02 : lang("Precio") . " 2"); ?></th>
                                    <?php
                                    }
                                    ?>
                                    <?php if ($_POST["precio3z"] == "on") {
                                    ?>
                                        <th><?php echo (trim($LitP03) !== "" ? $LitP03 : lang("Precio") . " 3"); ?></th>
                                    <?php
                                    }
                                    ?>

                                    <?php if ($_POST["precio4z"] == "on") {
                                    ?>
                                        <th><?php echo (trim($LitP04) !== "" ? $LitP04 : lang("Precio") . " 4"); ?> </th>
                                    <?php
                                    }  ?>

                                    <?php if ($_POST["precio5z"] == "on") {
                                    ?>
                                        <th><?php echo (trim($LitP05) !== "" ? $LitP05 : lang("Precio") . " 5"); ?> </th>
                                    <?php
                                    }  ?>

                                    <?php if ($_POST["precio6z"] == "on") {
                                    ?>
                                        <th><?php echo (trim($LitP06) !== "" ? $LitP06 : lang("Precio") . " 6"); ?> </th>
                                    <?php
                                    }  ?>

                                    <?php if ($_POST["precio7z"] == "on") {
                                    ?>
                                        <th><?php echo (trim($LitP07) !== "" ? $LitP07 : lang("Precio") . " 7"); ?> </th>
                                    <?php
                                    }  ?>

                                    <?php if ($_POST["precio8z"] == "on") {
                                    ?>
                                        <th><?php echo (trim($LitP08) !== "" ? $LitP08 : lang("Precio") . " 8"); ?> </th>
                                    <?php
                                    }  ?>

                                    <?php if ($_POST["precio9z"] == "on") {
                                    ?>
                                        <th><?php echo (trim($LitP09) !== "" ? $LitP09 : lang("Precio") . " 9"); ?> </th>
                                    <?php
                                    }  ?>

                                    <?php if ($_POST["precio10z"] == "on") {
                                    ?>
                                        <th><?php echo (trim($LitP10) !== "" ? $LitP10 : lang("Precio") . " 10"); ?> </th>
                                    <?php
                                    }  ?>
                                    <?php if ($_POST['cimp'] == "on") {
                                    ?>
                                        <th>%<?php echo lang("Imp"); ?></th>
                                    <?php
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>

                            <?php
                            $n = $n + 2;
                        }

                            ?>

                            <tr>

                                <!-- <td >
                                    <?php
                                    if (trim($row['CodIdAmpliado']) == "") {
                                        echo "-";
                                    } else {
                                        echo trim($row['CodIdAmpliado']);
                                    }
                                    ?>
                                </td> -->
                                <td>
                                    <?php
                                    if (trim($row['Descripcion']) == "") {
                                        echo "-";
                                    } else {
                                        echo trim($row['Descripcion']);
                                    }
                                    ?>
                                </td>
                                <?php
                                if ($_POST["MostrarFamilias"] === "on") {
                                ?>
                                    <td>
                                        <?php
                                        if (trim($row['Familia']) === "") {
                                            echo "-";
                                        } else {
                                            echo trim($row['Familia']);
                                        }
                                        ?>
                                    </td>

                                <?php
                                }
                                if ($_POST["Existencia"] == "on") {
                                ?>
                                    <!-- <td class="campo" style="text-align: left; width: 6%  <?php echo ($color == 0 ? "" : "background: #EDECEC;"); ?>">
                                (1
                                <?php
                                    echo $row['uniP1d'];
                                    if ($row['CantP1'] <> 0) {
                                        if ($row['CantP1'] == "" or $row['CantP1'] == 1) {
                                            echo "";
                                        } else {
                                            echo ' = ' . number_format($row['CantP1'], 0, $_POST["SimDec"], $_POST["SimMil"]);
                                        }
                                        if ($row['uniP2d'] == "") {
                                            echo "";
                                        } else {
                                            echo  '' . $row['uniP2d'] . '';
                                        }
                                    }
                                ?>) </td> -->
                                    <td>
                                        <?php

                                        if ($row['Existencia'] == "") {
                                            echo "-";
                                        } else {
                                            echo ($row["factorunit"] <> 1 && $row["factorunit"] <> 0 ? " " . $row["factorunit"] . " x " . getcantformat($row["Existencia"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " = " . getcantformat($row["Existencia"] * $row["factorunit"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $row["Medida"] : number_format($row['Existencia'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]));
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($row['cuniP1d'] <> 0) {
                                            if ($row['cuniP1d'] == "") {
                                                echo "-";
                                            } else {
                                                echo number_format($row['cuniP1d'], 0, $_POST["SimDec"], $_POST["SimMil"]);
                                            }
                                            if ($row['uniP1d'] == "") {
                                                echo "";
                                            } else {
                                                echo  '(' . substr($row['uniP1d'], 0, 3) . ')';
                                            }
                                        }
                                        if ($row['cuniP2d'] <> 0 and $row['cuniP1d'] <> 0) {
                                            echo ' y ';
                                        }
                                        if ($row['cuniP2d'] <> 0) {
                                            if ($row['cuniP2d'] == "") {
                                                echo "-";
                                            } else {
                                                echo number_format($row['cuniP2d'], 0, $_POST["SimDec"], $_POST["SimMil"]);
                                            }
                                            if ($row['uniP2d'] == "") {
                                                echo "";
                                            } else {
                                                echo  '(' . substr($row['uniP2d'], 0, 3) . ')';
                                            }
                                        }
                                        ?>
                                    </td>
                                <?php
                                }
                                if ($_POST["costozzzv"] == "on") {
                                ?>
                                    <td>
                                        <?php
                                        if (trim($row['costo']) === "") {
                                            echo "-";
                                        } else {
                                            echo number_format(trim($row['costo']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;;
                                        }
                                        ?>
                                    </td>
                                <?php
                                }
                                if ($_POST["precioz"] == "on") {
                                ?>
                                    <td>
                                        <?php
                                        if (trim($row['PrecioNeto']) === "") {
                                            echo "-";
                                        } else {
                                            echo number_format(trim($row['PrecioNeto']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;;
                                        }
                                        ?>
                                    </td>
                                <?php
                                }
                                ?>
                                <?php if ($_POST["precio2z"] == "on") {
                                ?>
                                    <td>
                                        <?php
                                        if (trim($row['PrecioNeto2']) === "") {
                                            echo "-";
                                        } else {
                                            echo number_format(trim($row['PrecioNeto2']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;;
                                            if ($row['CantP1'] > 1) {
                                                echo  ' / ' . number_format(trim($row['PrecioNeto2']) / $row['CantP1'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                            }
                                        }
                                        ?>
                                    </td>
                                <?php
                                }
                                ?>
                                <?php if ($_POST["precio3z"] == "on") {
                                ?>
                                    <td>
                                        <?php
                                        if (trim($row['PrecioNeto3']) == "") {
                                            echo "-";
                                        } else {
                                            echo number_format(trim($row['PrecioNeto3']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;;
                                            if ($row['CantP2'] > 1) {
                                                echo  ' / ' . number_format(trim($row['PrecioNeto3']) / $row['CantP2'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                            }
                                        }
                                        ?>
                                    </td>
                                <?php
                                }
                                if ($_POST["precio4z"] == "on") {
                                ?>
                                    <td>
                                        <?php
                                        if (trim($row['PrecioNeto4']) == "") {
                                            echo "-";
                                        } else {
                                            echo number_format(trim($row['PrecioNeto4']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;;
                                            if ($row['CantP4'] > 1) {
                                                echo  ' / ' . number_format(trim($row['PrecioNeto4']) / $row['CantP4'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                            }
                                        }
                                        ?>
                                    </td>
                                <?php
                                }

                                if ($_POST["precio5z"] == "on") {
                                ?>
                                    <td>
                                        <?php
                                        if (trim($row['PrecioNeto5']) == "") {
                                            echo "-";
                                        } else {
                                            echo number_format(trim($row['PrecioNeto5']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;;
                                            if ($row['CantP5'] > 1) {
                                                echo  ' / ' . number_format(trim($row['PrecioNeto5']) / $row['CantP5'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                            }
                                        }
                                        ?>
                                    </td>
                                <?php
                                }

                                if ($_POST["precio6z"] == "on") {
                                ?>
                                    <td>
                                        <?php
                                        if (trim($row['PrecioNeto6']) == "") {
                                            echo "-";
                                        } else {
                                            echo number_format(trim($row['PrecioNeto6']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;;
                                            if ($row['CantP6'] > 1) {
                                                echo  ' / ' . number_format(trim($row['PrecioNeto6']) / $row['CantP6'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                            }
                                        }
                                        ?>
                                    </td>
                                <?php
                                }

                                if ($_POST["precio7z"] == "on") {
                                ?>
                                    <td>
                                        <?php
                                        if (trim($row['PrecioNeto7']) == "") {
                                            echo "-";
                                        } else {
                                            echo number_format(trim($row['PrecioNeto7']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;
                                            if ($row['CantP7'] > 1) {
                                                echo  ' / ' . number_format(trim($row['PrecioNeto7']) / $row['CantP7'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                            }
                                        }
                                        ?>
                                    </td>
                                <?php
                                }

                                if ($_POST["precio8z"] == "on") {
                                ?>
                                    <td>
                                        <?php
                                        if (trim($row['PrecioNeto8']) == "") {
                                            echo "-";
                                        } else {
                                            echo number_format(trim($row['PrecioNeto8']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;
                                            if ($row['CantP8'] > 1) {
                                                echo  ' / ' . number_format(trim($row['PrecioNeto8']) / $row['CantP8'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                            }
                                        }
                                        ?>
                                    </td>
                                <?php
                                }

                                if ($_POST["precio9z"] == "on") {
                                ?>
                                    <td>
                                        <?php
                                        if (trim($row['PrecioNeto9']) == "") {
                                            echo "-";
                                        } else {
                                            echo number_format(trim($row['PrecioNeto9']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;
                                            if ($row['CantP9'] > 1) {
                                                echo  ' / ' . number_format(trim($row['PrecioNeto9']) / $row['CantP9'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                            }
                                        }
                                        ?>
                                    </td>
                                <?php
                                }

                                if ($_POST["precio10z"] == "on") {
                                ?>
                                    <td>
                                        <?php
                                        if (trim($row['PrecioNeto10']) == "") {
                                            echo "-";
                                        } else {
                                            echo number_format(trim($row['PrecioNeto10']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;
                                            if ($row['CantP10'] > 1) {
                                                echo  ' / ' . number_format(trim($row['PrecioNeto10']) / $row['CantP10'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                            }
                                        }
                                        ?>
                                    </td>
                                <?php
                                }
                                if ($_POST['cimp'] == "on") {
                                ?>
                                    <td>
                                        <?php
                                        if (trim($row['ValorImpuesto']) == "") {
                                            echo "-";
                                        } else {
                                            echo trim($row['ValorImpuesto']);
                                        }
                                        ?>
                                    </td>
                                <?php
                                }
                                ?>

                            </tr>
                            <?php
                            $CostoXexist = $row["costo"] * $row["Existencia"];
                            $CostoXexistT = $CostoXexist + $CostoXexistT;
                            $existenciaX = $existenciaX + $row["Existencia"];


                            $precio = $row["PrecioNeto"] * $row["Existencia"];
                            $precio2 = $row["PrecioNeto2"] * $row["Existencia"];
                            $precio3 = $row["PrecioNeto3"] * $row["Existencia"];
                            $precio4 = $row["PrecioNeto4"] * $row["Existencia"];
                            $precio5 = $row["PrecioNeto5"] * $row["Existencia"];
                            $precio6 = $row["PrecioNeto6"] * $row["Existencia"];
                            $precio7 = $row["PrecioNeto7"] * $row["Existencia"];
                            $precio8 = $row["PrecioNeto8"] * $row["Existencia"];
                            $precio9 = $row["PrecioNeto9"] * $row["Existencia"];
                            $precioT10 = $row["PrecioNeto10"] * $row["Existencia"];
                            $precioT = $precioT + $precio;
                            $precioT2 = $precioT2 + $precio2;
                            $precioT3 = $precioT3 + $precio3;
                            $precioT4 = $precioT4 + $precio4;
                            $precioT5 = $precioT5 + $precio5;
                            $precioT6 = $precioT6 + $precio6;
                            $precioT7 = $precioT7 + $precio7;
                            $precioT8 = $precioT8 + $precio8;
                            $precioT9 = $precioT9 + $precio9;
                            $precioT10 = $precioT10 + $precioT10;
                            $preciozz = $row["PrecioNeto"] * $row["Existencia"];
                            $precio2zz = $row["PrecioNeto2"] * $row["Existencia"];
                            $precio3zz = $row["PrecioNeto3"] * $row["Existencia"];
                            $precio4zz = $row["PrecioNeto4"] * $row["Existencia"];
                            $precio5zz = $row["PrecioNeto5"] * $row["Existencia"];
                            $precio6zz = $row["PrecioNeto6"] * $row["Existencia"];
                            $precio7zz = $row["PrecioNeto7"] * $row["Existencia"];
                            $precio8zz = $row["PrecioNeto8"] * $row["Existencia"];
                            $precio9zz = $row["PrecioNeto9"] * $row["Existencia"];
                            $precio10zz = $row["PrecioNeto10"] * $row["Existencia"];
                            $precioTz = $precioTz + $preciozz;
                            $precioT2z = $precioT2z + $precio2zz;
                            $precioT3z = $precioT3z + $precio3zz;
                            $precioT4z = $precioT4z + $precio4zz;
                            $precioT5z = $precioT5z + $precio5zz;
                            $precioT6z = $precioT6z + $precio6zz;
                            $precioT7z = $precioT7z + $precio7zz;
                            $precioT8z = $precioT8z + $precio8zz;
                            $precioT9z = $precioT9z + $precio9zz;
                            $precioT10z = $precioT10z + $precio10zz;

                            $CostoXexis2t = $row["costo"] * $row["Existencia"];
                            $CostoXexistT2 = $CostoXexis2t + $CostoXexistT2;
                            $existenciaX2 = $existenciaX2 + $row["Existencia"];


                            $npi2 = $npi2 + 1;
                            $MarAct2 = trim($row['Marca']);
                        }
                        mysqli_free_result($result);
                    }
                    $UltimoRegistro = $row["CodIdBasico"];
                } else if ($_POST["Agrupar"] == "Familiazp") {

                    if ($_POST["OrdenLP"] == "Codigo") {
                        $Orden = "order by e.ITEM,a.CodIdBasico";
                    }
                    if ($_POST["OrdenLP"] == "Descripcion") {
                        $Orden = "order by e.ITEM,a.Descripcion";
                    }
                    if ($_POST["OrdenLP"] == "Referencia") {
                        $Orden = "order by e.ITEM,a.CodBarra";
                    }
                    if ($_POST["OrdenLP"] == "Instancia") {
                        $Orden = "order by e.ITEM";
                    }
                    if ($_POST["OrdenLP"] == "Marca") {
                        $Orden = "order by e.ITEM,d.nombre";
                    }

                    if ($_POST["OrdenLP"] == "PrecioNeto") {
                        $Orden = "order by e.ITEM,a.PrecioNeto desc";
                    }

                    if (!empty($_POST["mIdfamilia"])) {
                        $familia = " and a.Idfamilia " . ($_POST["NotIncludeFamilia"] === "on" ? "not" : "") . " in ('" . implode("','", $_POST["mIdfamilia"]) . "') ";
                    }
                    $buscar = "";
                    if ($_POST["EnvioEstado"] !== "*") {
                        $buscar .= "and a.Estado = " . $_POST["EnvioEstado"];
                    }

                    if (!empty($_POST["mIdProductos"])) {
                        $beetween = " and a.CodIdBasico " . ($_POST["NotIncludeProductos"] === "on" ? "not" : "") . " in ('" . implode("','", $_POST["mIdProductos"]) . "') ";
                    }
                    if (!empty($_POST["mIdAlmacen"])) {
                        $Deposito = " and b.IdAlm in ('" . implode("','", $_POST["mIdAlmacen"]) . "')";
                        $Deposito2 = "where a.IdAlm in ('" . implode("','", $_POST["mIdAlmacen"]) . "')";
                        $Deposito4 = " and a.IdAlm in ('" . implode("','", $_POST["mIdAlmacen"]) . "')";
                    }
                    if (!empty($_POST["mIdMarca"])) {
                        $Marca = "and a.Marca in ('" . implode("','", $_POST["mIdMarca"]) . "')";
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
                    if ($_POST['costozzzv'] == true) {

                        if ($_POST['cimp'] == false) {
                            $costo = "round(coalesce(a.CostoNeto,0),2) as costo,";
                        } else {
                            $costo = "round(coalesce(a.Costo,0),2) as costo,";
                        }
                    } else {

                        $costo = "";
                    }
                    if ($_POST['sucursal'] <> '0') {
                        $ubic = " and f.IdUbi=" . $_POST['sucursal'];
                    }
                    $query = "SELECT DISTINCT a.CodIdAmpliado,a.CodIdBasico,a.CodBarra, a.Descripcion ,a.Envase,e.ITEM as Familia,
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
            " . $fechaA . " " . $ubic . " 
            " . $Deposito4 . " and a.IdCompany= " . $_POST["CompanyActual"] . "
            group by a.IdCompany,b.CodIdBasico
            ) b on a.IdCompany = b.IdCompany and a.CodIdBasico = b.CodIdBasico
            left join (SELECT a.IdCompany,a.RUT, b.idBen, c.CodIdBasico from PosUpclientes a
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
            inner join PosUpvarios f on a.IdCompany=f.IdCompany and a.Impuesto=f.IdVarios and f.TIPOITEM= 0
            where a.IdCompany= " . $_POST["CompanyActual"] . " and a.EsCompuesto in (20,1,0) " . $beetween . " 
            " . $buscar . "
            " . $ExistenciaCero . "                                       
            " . $Marca . "
            " . $familia . "
            " . $referencia . "
                                       " . (!empty($Having) ? "HAVING " . implode(" or ", $Having) : "") . "
            " . $Orden . "
            " . $limit . "
            ";
                    if ($result = mysqli_query($conn, $query)) {
                        $n = 0;

                        while ($row = mysqli_fetch_assoc($result)) {
                            $n = $n + 1;
                            $nt = $nt + 1;
                            $npa = $npa + 1;

                            $nas = $nas + 1;
                            $nel = $nel + 1;
                            if ($MarAct == $MarAct) {
                                if ($nas > 7 and $nel < 14) {
                                    $n = $n - 2;
                                    $nas = 0;
                                } else if ($nel > 14) {
                                    $n = $n - 1;
                                    $nel = 1;
                                }
                            }

                            $MarAct = trim($row['Familia']);
                            if ($MarAct == $MarAct and $npix2 == false) {
                                $npix2 = $npix2 + 12; ?>

                                <div>
                                    <h2><strong> <?php echo $MarAct;  ?> </strong>
                                    </h2>
                                </div>
                                <table>
                                    <thead>
                                        <tr>
                                            <!-- <th class="campo" style=" text-align: left; width: 12%; background-color: gray;"><?php echo lang("S.K.U"); ?></th> -->
                                            <th><?php echo lang("Descripción"); ?></th> <?php
                                                                                        if ($_POST["MostrarMarcas"] === "on") {
                                                                                        ?>
                                                <th><?php echo lang("Marca"); ?></th>

                                            <?php
                                                                                        }
                                            ?>
                                            <?php if ($_POST["Existencia"] == "on") {
                                            ?>
                                                <!-- <th class="campo" style=" text-align: left; width: 8%; background-color: gray;"><?php echo lang("Referencia"); ?> </th> -->
                                                <th><?php echo lang("Existencia"); ?> </th>
                                                <th><?php echo lang("Desglose"); ?> </th>
                                            <?php }
                                            if ($_POST["costozzzv"] == "on") {
                                            ?>
                                                <th><?php echo (trim($LitCosto) !== "" ? $LitCosto : lang("Costo")); ?></th>
                                            <?php
                                            }
                                            if ($_POST["precioz"] == "on") {
                                            ?>
                                                <th><?php echo (trim($LitP01) !== "" ? $LitP01 : lang("Precio") . " 1"); ?></th>
                                            <?php
                                            }
                                            ?>
                                            <?php if ($_POST["precio2z"] == "on") {
                                            ?>
                                                <th><?php echo (trim($LitP02) !== "" ? $LitP02 : lang("Precio") . " 2"); ?></th>
                                            <?php
                                            }
                                            ?>
                                            <?php if ($_POST["precio3z"] == "on") {
                                            ?>
                                                <th><?php echo (trim($LitP03) !== "" ? $LitP03 : lang("Precio") . " 3"); ?></th>
                                            <?php
                                            }
                                            ?>

                                            <?php if ($_POST["precio4z"] == "on") {
                                            ?>
                                                <th><?php echo (trim($LitP04) !== "" ? $LitP04 : lang("Precio") . " 4"); ?> </th>
                                            <?php
                                            }  ?>

                                            <?php if ($_POST["precio5z"] == "on") {
                                            ?>
                                                <th><?php echo (trim($LitP05) !== "" ? $LitP05 : lang("Precio") . " 5"); ?> </th>
                                            <?php
                                            }  ?>

                                            <?php if ($_POST["precio6z"] == "on") {
                                            ?>
                                                <th><?php echo (trim($LitP06) !== "" ? $LitP06 : lang("Precio") . " 6"); ?> </th>
                                            <?php
                                            }  ?>

                                            <?php if ($_POST["precio7z"] == "on") {
                                            ?>
                                                <th><?php echo (trim($LitP07) !== "" ? $LitP07 : lang("Precio") . " 7"); ?> </th>
                                            <?php
                                            }  ?>

                                            <?php if ($_POST["precio8z"] == "on") {
                                            ?>
                                                <th><?php echo (trim($LitP08) !== "" ? $LitP08 : lang("Precio") . " 8"); ?> </th>
                                            <?php
                                            }  ?>

                                            <?php if ($_POST["precio9z"] == "on") {
                                            ?>
                                                <th><?php echo (trim($LitP09) !== "" ? $LitP09 : lang("Precio") . " 9"); ?> </th>
                                            <?php
                                            }  ?>

                                            <?php if ($_POST["precio10z"] == "on") {
                                            ?>
                                                <th><?php echo (trim($LitP10) !== "" ? $LitP10 : lang("Precio") . " 10"); ?> </th>
                                            <?php
                                            }  ?>
                                            <?php if ($_POST['cimp'] == "on") {
                                            ?>
                                                <th>%Imp</th>
                                            <?php
                                            }
                                            ?>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php $n = $n + 2;
                                }
                                if ($MarAct <> $MarAct2 and $npi2 >= 1) {
                                    $block = $block + 1;
                                    $nas = 0;
                                    $nel = 0;
                                    if ($block > 4) {
                                        $block = 0;
                                        $n = $n - 2;
                                    } else if ($block > 2) {
                                        $block = 0;
                                        $n = $n - 1;
                                    }
                                    ?>
                                    </tbody>
                                </table>
                                <div>
                                    <h2><strong> <?php echo $MarAct;  ?> </strong> </h2>
                                </div>
                                <table>
                                    <thead>
                                        <tr>
                                            <!-- <th class="campo" style=" text-align: left; width: 12%; background-color: gray;"><?php echo lang("S.K.U"); ?></th> -->
                                            <th><?php echo lang("Descripción"); ?></th> <?php
                                                                                        if ($_POST["MostrarMarcas"] === "on") {
                                                                                        ?>
                                                <th><?php echo lang("Marca"); ?></th>

                                            <?php
                                                                                        }
                                            ?>
                                            <?php if ($_POST["Existencia"] == "on") {
                                            ?>
                                                <!-- <th ><?php echo lang("Referencia"); ?> </th> -->
                                                <th><?php echo lang("Existencia"); ?> </th>
                                                <th><?php echo lang("Desglose"); ?> </th>
                                            <?php }
                                            if ($_POST["costozzzv"] == "on") {
                                            ?>
                                                <th><?php echo (trim($LitCosto) !== "" ? $LitCosto : lang("Costo")); ?></th>
                                            <?php
                                            }
                                            if ($_POST["precioz"] == "on") {
                                            ?>
                                                <th><?php echo (trim($LitP01) !== "" ? $LitP01 : lang("Precio") . " 1"); ?></th>
                                            <?php
                                            }
                                            ?>
                                            <?php if ($_POST["precio2z"] == "on") {
                                            ?>
                                                <th><?php echo (trim($LitP02) !== "" ? $LitP02 : lang("Precio") . " 2"); ?></th>
                                            <?php
                                            }
                                            ?>
                                            <?php if ($_POST["precio3z"] == "on") {
                                            ?>
                                                <th><?php echo (trim($LitP03) !== "" ? $LitP03 : lang("Precio") . " 3"); ?></th>
                                            <?php
                                            }
                                            ?>

                                            <?php if ($_POST["precio4z"] == "on") {
                                            ?>
                                                <th><?php echo (trim($LitP04) !== "" ? $LitP04 : lang("Precio") . " 4"); ?> </th>
                                            <?php
                                            }  ?>

                                            <?php if ($_POST["precio5z"] == "on") {
                                            ?>
                                                <th><?php echo (trim($LitP05) !== "" ? $LitP05 : lang("Precio") . " 5"); ?> </th>
                                            <?php
                                            }  ?>

                                            <?php if ($_POST["precio6z"] == "on") {
                                            ?>
                                                <th><?php echo (trim($LitP06) !== "" ? $LitP06 : lang("Precio") . " 6"); ?> </th>
                                            <?php
                                            }  ?>

                                            <?php if ($_POST["precio7z"] == "on") {
                                            ?>
                                                <th><?php echo (trim($LitP07) !== "" ? $LitP07 : lang("Precio") . " 7"); ?> </th>
                                            <?php
                                            }  ?>

                                            <?php if ($_POST["precio8z"] == "on") {
                                            ?>
                                                <th><?php echo (trim($LitP08) !== "" ? $LitP08 : lang("Precio") . " 8"); ?> </th>
                                            <?php
                                            }  ?>

                                            <?php if ($_POST["precio9z"] == "on") {
                                            ?>
                                                <th><?php echo (trim($LitP09) !== "" ? $LitP09 : lang("Precio") . " 9"); ?> </th>
                                            <?php
                                            }  ?>

                                            <?php if ($_POST["precio10z"] == "on") {
                                            ?>
                                                <th><?php echo (trim($LitP10) !== "" ? $LitP10 : lang("Precio") . " 10"); ?> </th>
                                            <?php
                                            }  ?>
                                            <?php if ($_POST['cimp'] == "on") {
                                            ?>
                                                <th>%<?php echo lang("Imp"); ?></th>
                                            <?php
                                            }
                                            ?>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php $n = $n + 1;
                                }
                                    ?>

                                    <tr>

                                        <!-- <td class="campo" style=" text-align: left; width: 12%; text-wrap: wrap; white-space: normal !important;">
                                                <?php
                                                if (trim($row['CodIdAmpliado']) === "") {
                                                    echo "-";
                                                } else {
                                                    echo trim($row['CodIdAmpliado']);
                                                }
                                                ?>
                                            </td> -->
                                        <td>
                                            <?php
                                            if (trim($row['Descripcion']) === "") {
                                                echo "-";
                                            } else {
                                                echo trim($row['Descripcion']);
                                            }
                                            ?>
                                        </td>
                                        <?php
                                        if ($_POST["MostrarMarcas"] === "on") {
                                        ?>
                                            <td>
                                                <?php
                                                if (trim($row['Marca']) === "") {
                                                    echo "-";
                                                } else {
                                                    echo trim($row['Marca']);
                                                }
                                                ?>
                                            </td>

                                        <?php
                                        }
                                        ?>

                                        <?php if ($_POST["Existencia"] == "on") {
                                        ?>
                                            <!-- <td class="campo" style="text-align: left; width: 8%;  <?php echo ($color == 0 ? "" : "background: #EDECEC;"); ?>">(1
                                <?php
                                            echo $row['uniP1d'];
                                            if ($row['CantP1'] <> 0) {
                                                if ($row['CantP1'] == "" or $row['CantP1'] == 1) {
                                                    echo "";
                                                } else {
                                                    echo ' = ' . number_format($row['CantP1'], 0, $_POST["SimDec"], $_POST["SimMil"]);
                                                }
                                                if ($row['uniP2d'] == "") {
                                                    echo "";
                                                } else {
                                                    echo  '' . $row['uniP2d'] . '';
                                                }
                                            }
                                ?>) 
                            </td> -->
                                            <td>
                                                <?php

                                                if ($row['Existencia'] == "") {
                                                    echo "-";
                                                } else {
                                                    echo ($row["factorunit"] <> 1 && $row["factorunit"] <> 0 ? " " . $row["factorunit"] . " x " . getcantformat($row["Existencia"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " = " . getcantformat($row["Existencia"] * $row["factorunit"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $row["Medida"] : number_format($row['Existencia'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]));
                                                }
                                                ?>
                                            </td>
                                            <td>&nbsp;
                                                <?php
                                                if ($row['cuniP1d'] <> 0) {
                                                    if ($row['cuniP1d'] == "") {
                                                        echo "-";
                                                    } else {
                                                        echo number_format($row['cuniP1d'], 0, $_POST["SimDec"], $_POST["SimMil"]);
                                                    }
                                                    if ($row['uniP1d'] == "") {
                                                        echo "";
                                                    } else {
                                                        echo  '(' . substr($row['uniP1d'], 0, 3) . ')';
                                                    }
                                                }
                                                if ($row['cuniP2d'] <> 0 and $row['cuniP1d'] <> 0) {
                                                    echo ' y ';
                                                }
                                                if ($row['cuniP2d'] <> 0) {
                                                    if ($row['cuniP2d'] == "") {
                                                        echo "-";
                                                    } else {
                                                        echo number_format($row['cuniP2d'], 0, $_POST["SimDec"], $_POST["SimMil"]);
                                                    }
                                                    if ($row['uniP2d'] == "") {
                                                        echo "";
                                                    } else {
                                                        echo  '(' . substr($row['uniP2d'], 0, 3) . ')';
                                                    }
                                                }
                                                ?>
                                            </td>
                                        <?php
                                        }
                                        if ($_POST["costozzzv"] == "on") {
                                        ?>
                                            <td>
                                                <?php
                                                if (trim($row['costo']) == "") {
                                                    echo "-";
                                                } else {
                                                    echo number_format(trim($row['costo']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;
                                                }
                                                ?>
                                            </td>
                                        <?php
                                        }
                                        if ($_POST["precioz"] == "on") {
                                        ?>
                                            <td>
                                                <?php
                                                if (trim($row['PrecioNeto']) == "") {
                                                    echo "-";
                                                } else {
                                                    echo number_format(trim($row['PrecioNeto']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;
                                                }
                                                ?>
                                            </td>
                                        <?php
                                        }
                                        ?>
                                        <?php if ($_POST["precio2z"] == "on") {
                                        ?>
                                            <td>
                                                <?php
                                                if (trim($row['PrecioNeto2']) == "") {
                                                    echo "-";
                                                } else {
                                                    echo number_format(trim($row['PrecioNeto2']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;
                                                    if ($row['CantP1'] > 1) {
                                                        echo  ' / ' . number_format(trim($row['PrecioNeto2']) / $row['CantP1'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                    }
                                                }
                                                ?>
                                            </td>
                                        <?php
                                        }
                                        ?>
                                        <?php if ($_POST["precio3z"] == "on") {
                                        ?>
                                            <td>
                                                <?php
                                                if (trim($row['PrecioNeto3']) == "") {
                                                    echo "-";
                                                } else {
                                                    echo number_format(trim($row['PrecioNeto3']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;
                                                    if ($row['CantP2'] > 1) {
                                                        echo  ' / ' . number_format(trim($row['PrecioNeto3']) / $row['CantP2'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                    }
                                                }
                                                ?>
                                            </td>
                                        <?php
                                        }
                                        if ($_POST["precio4z"] == "on") {
                                        ?>
                                            <td>
                                                <?php
                                                if (trim($row['PrecioNeto4']) == "") {
                                                    echo "-";
                                                } else {
                                                    echo number_format(trim($row['PrecioNeto4']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;
                                                    if ($row['CantP4'] > 1) {
                                                        echo  ' / ' . number_format(trim($row['PrecioNeto4']) / $row['CantP4'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                    }
                                                }
                                                ?>
                                            </td>
                                        <?php
                                        }

                                        if ($_POST["precio5z"] == "on") {
                                        ?>
                                            <td>
                                                <?php
                                                if (trim($row['PrecioNeto5']) == "") {
                                                    echo "-";
                                                } else {
                                                    echo number_format(trim($row['PrecioNeto5']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;
                                                    if ($row['CantP5'] > 1) {
                                                        echo  ' / ' . number_format(trim($row['PrecioNeto5']) / $row['CantP5'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                    }
                                                }
                                                ?>
                                            </td>
                                        <?php
                                        }

                                        if ($_POST["precio6z"] == "on") {
                                        ?>
                                            <td>
                                                <?php
                                                if (trim($row['PrecioNeto6']) == "") {
                                                    echo "-";
                                                } else {
                                                    echo number_format(trim($row['PrecioNeto6']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;
                                                    if ($row['CantP6'] > 1) {
                                                        echo  ' / ' . number_format(trim($row['PrecioNeto6']) / $row['CantP6'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                    }
                                                }
                                                ?>
                                            </td>
                                        <?php
                                        }

                                        if ($_POST["precio7z"] == "on") {
                                        ?>
                                            <td>
                                                <?php
                                                if (trim($row['PrecioNeto7']) == "") {
                                                    echo "-";
                                                } else {
                                                    echo number_format(trim($row['PrecioNeto7']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;
                                                    if ($row['CantP7'] > 1) {
                                                        echo  ' / ' . number_format(trim($row['PrecioNeto7']) / $row['CantP7'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                    }
                                                }
                                                ?>
                                            </td>
                                        <?php
                                        }

                                        if ($_POST["precio8z"] == "on") {
                                        ?>
                                            <td>
                                                <?php
                                                if (trim($row['PrecioNeto8']) == "") {
                                                    echo "-";
                                                } else {
                                                    echo number_format(trim($row['PrecioNeto8']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;
                                                    if ($row['CantP8'] > 1) {
                                                        echo  ' / ' . number_format(trim($row['PrecioNeto8']) / $row['CantP8'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                    }
                                                }
                                                ?>
                                            </td>
                                        <?php
                                        }

                                        if ($_POST["precio9z"] == "on") {
                                        ?>
                                            <td>
                                                <?php
                                                if (trim($row['PrecioNeto9']) == "") {
                                                    echo "-";
                                                } else {
                                                    echo number_format(trim($row['PrecioNeto9']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;
                                                    if ($row['CantP9'] > 1) {
                                                        echo  ' / ' . number_format(trim($row['PrecioNeto9']) / $row['CantP9'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                    }
                                                }
                                                ?>
                                            </td>
                                        <?php
                                        }

                                        if ($_POST["precio10z"] == "on") {
                                        ?>
                                            <td>
                                                <?php
                                                if (trim($row['PrecioNeto10']) == "") {
                                                    echo "-";
                                                } else {
                                                    echo number_format(trim($row['PrecioNeto10']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;
                                                    if ($row['CantP10'] > 1) {
                                                        echo  ' / ' . number_format(trim($row['PrecioNeto10']) / $row['CantP10'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                    }
                                                }
                                                ?>
                                            </td>
                                        <?php
                                        }
                                        if ($_POST['cimp'] == "on") {
                                        ?>
                                            <td>
                                                <?php
                                                if (trim($row['ValorImpuesto']) === "") {
                                                    echo "-";
                                                } else {
                                                    echo trim($row['ValorImpuesto']);
                                                }
                                                ?>
                                            </td>
                                        <?php
                                        }
                                        ?>

                                    </tr>
                        <?php
                            $CostoXexist = $row["costo"] * $row["Existencia"];
                            $CostoXexistT = $CostoXexist + $CostoXexistT;
                            $existenciaX = $existenciaX + $row["Existencia"];


                            $precio = $row["PrecioNeto"] * $row["Existencia"];
                            $precio2 = $row["PrecioNeto2"] * $row["Existencia"];
                            $precio3 = $row["PrecioNeto3"] * $row["Existencia"];
                            $precio4 = $row["PrecioNeto4"] * $row["Existencia"];
                            $precio5 = $row["PrecioNeto5"] * $row["Existencia"];
                            $precio6 = $row["PrecioNeto6"] * $row["Existencia"];
                            $precio7 = $row["PrecioNeto7"] * $row["Existencia"];
                            $precio8 = $row["PrecioNeto8"] * $row["Existencia"];
                            $precio9 = $row["PrecioNeto9"] * $row["Existencia"];
                            $precioT10 = $row["PrecioNeto10"] * $row["Existencia"];
                            $precioT = $precioT + $precio;
                            $precioT2 = $precioT2 + $precio2;
                            $precioT3 = $precioT3 + $precio3;
                            $precioT4 = $precioT4 + $precio4;
                            $precioT5 = $precioT5 + $precio5;
                            $precioT6 = $precioT6 + $precio6;
                            $precioT7 = $precioT7 + $precio7;
                            $precioT8 = $precioT8 + $precio8;
                            $precioT9 = $precioT9 + $precio9;
                            $precioT10 = $precioT10 + $precioT10;
                            $preciozz = $row["PrecioNeto"] * $row["Existencia"];
                            $precio2zz = $row["PrecioNeto2"] * $row["Existencia"];
                            $precio3zz = $row["PrecioNeto3"] * $row["Existencia"];
                            $precio4zz = $row["PrecioNeto4"] * $row["Existencia"];
                            $precio5zz = $row["PrecioNeto5"] * $row["Existencia"];
                            $precio6zz = $row["PrecioNeto6"] * $row["Existencia"];
                            $precio7zz = $row["PrecioNeto7"] * $row["Existencia"];
                            $precio8zz = $row["PrecioNeto8"] * $row["Existencia"];
                            $precio9zz = $row["PrecioNeto9"] * $row["Existencia"];
                            $precio10zz = $row["PrecioNeto10"] * $row["Existencia"];
                            $precioTz = $precioTz + $preciozz;
                            $precioT2z = $precioT2z + $precio2zz;
                            $precioT3z = $precioT3z + $precio3zz;
                            $precioT4z = $precioT4z + $precio4zz;
                            $precioT5z = $precioT5z + $precio5zz;
                            $precioT6z = $precioT6z + $precio6zz;
                            $precioT7z = $precioT7z + $precio7zz;
                            $precioT8z = $precioT8z + $precio8zz;
                            $precioT9z = $precioT9z + $precio9zz;
                            $precioT10z = $precioT10z + $precio10zz;

                            $CostoXexis2t = $row["costo"] * $row["Existencia"];
                            $CostoXexistT2 = $CostoXexis2t + $CostoXexistT2;
                            $existenciaX2 = $existenciaX2 + $row["Existencia"];

                            $npi2 = $npi2 + 1;
                            $MarAct2 = trim($row['Familia']);
                        }
                        mysqli_free_result($result);
                    }
                    $UltimoRegistro = $row["CodIdBasico"];
                } else  if ($_POST["Agrupar"] === "FamiliaMarca") {
                    if ($_POST["OrdenLP"] == "Codigo") {
                        $Orden = "order by e.ITEM,a.CodIdBasico";
                    }
                    if ($_POST["OrdenLP"] == "Descripcion") {
                        $Orden = "order by e.ITEM,a.Descripcion";
                    }
                    if ($_POST["OrdenLP"] == "Referencia") {
                        $Orden = "order by e.ITEM,a.CodBarra";
                    }
                    if ($_POST["OrdenLP"] == "Instancia") {
                        $Orden = "order by e.ITEM";
                    }
                    if ($_POST["OrdenLP"] == "Marca") {
                        $Orden = "order by e.ITEM,d.nombre";
                    }

                    if ($_POST["OrdenLP"] == "PrecioNeto") {
                        $Orden = "order by e.ITEM,a.PrecioNeto desc";
                    }

                    $almacenes = [];
                    $buscar = "";

                    if (!empty($_POST["mIdAlmacen"])) {
                        $buscar .= " and IdAlm in ('" . implode("','", $_POST["mIdAlmacen"]) . "')";
                    }

                    if (!empty($_POST["ModalUbicaciones"])) {
                        $buscar .= " and IdUbi in ('" . implode("','", $_POST['ModalUbicaciones']) . "')";
                    } else if ($_POST['sucursal'] <> '0') {
                        $ubic = " and f.IdUbi=" . $_POST['sucursal'];
                        $buscar .= " and IdUbi in ('" . $_POST['sucursal'] . "')";
                    }

                    if (!empty($_POST["ModalAtencion"])) {
                        $buscar .= " and IdAtt in ('" . implode("','", $_POST["ModalAtencion"]) . "')";
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

                    if (!empty($_POST["mIdfamilia"])) {
                        $familia = " and a.Idfamilia " . ($_POST["NotIncludeFamilia"] === "on" ? "not" : "") . " in ('" . implode("','", $_POST["mIdfamilia"]) . "') ";
                    }
                    $buscar = "";
                    if ($_POST["EnvioEstado"] !== "*") {
                        $buscar .= "and a.Estado = " . $_POST["EnvioEstado"];
                    }

                    if (!empty($_POST["mIdProductos"])) {
                        $beetween = " and a.CodIdBasico in ('" . implode("','", $_POST["mIdProductos"]) . "') ";
                    }
                    if (!empty($_POST["mIdMarca"])) {
                        $Marca = "and a.Marca in ('" . implode("','", $_POST["mIdMarca"]) . "')";
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
                    if ($_POST['costozzzv'] == true) {

                        if ($_POST['cimp'] == false) {
                            $costo = "round(coalesce(a.CostoNeto,0),2) as costo,";
                        } else {
                            $costo = "round(coalesce(a.Costo,0),2) as costo,";
                        }
                    } else {

                        $costo = "";
                    }

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


                    $query = "SELECT a.CodIdAmpliado,a.CodIdBasico,a.CodBarra, a.Descripcion ,a.Envase,e.ITEM as Familia,b.Nombre as Marca, a.CodBarra,
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
                        a.CantP1,h.Cantidad
                        FROM PosUpProducto a
                        left join (
                            select dt.CodIdBasico,sum(dt.Cantidad) as Cantidad from 
                                (select f.IdCompany,f.CodIdBasico,sum(f.Cantidad) as Cantidad
                                    from posupproductostockmest f
                                    where f.IdCompany = " . $_POST["CompanyActual"] . " 
                                    " . (!empty($almacenes) ? " and f.IdAlm in (" . implode(",", $almacenes) . ")" : "") . "
                                    group by f.IdCompany,f.CodIdBasico
                                union all
                                    SELECT a.IdCompany, a.CodIdBasico,sum(a.Cant * (if(a.Idtipotx in (" . $Suminv . "),1,0) + if(a.Idtipotx in (" . $Resinv . "),-1,0))) as Cantidad
                                    from
                                    posuptxd a				
                                    where a.IdCompany=" . $_POST["CompanyActual"] . " and a.FecTxClient BETWEEN '" . $firstDayOfMonth . " 00:00:00' AND '" . $LastDayOfMonth . " 23:59:59'
                            and a.idtipotx in (" . $Operainv . ") 
                                    " . (!empty($almacenes) ? " and a.IdAlm in (" . implode(",", $almacenes) . ")" : "") . "
                                    group by a.IdCompany,a.CodIdBasico
                                ) as dt
                                group by dt.IdCompany, dt.CodIdBasico
                        ) h on a.CodIdBasico = h.CodIdBasico
                        left join PosUpc_marcas b on a.IdCompany = b.IdCompany and a.Marca = b.idmarca 
                        left join PosUpvarios e on a.IdCompany=e.IdCompany and a.Idfamilia=e.IdVarios and e.TIPOITEM= 2
                        where a.IdCompany= " . $_POST["CompanyActual"] . " 
                        and a.EsCompuesto in (20,1,0) 
                        " . $beetween . " 
                        " . $buscar . "
                    ";
                    $n = 0;
                    $m = 0;

                    if ($result = mysqli_query($conn, $query . " order by e.ITEM ASC, b.Nombre desc")) {
                        while ($row = mysqli_fetch_assoc($result)) {

                            if ($m === 0) {
                                $Familia = $row["Familia"];
                                $Marca = $row["Marca"];
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
                                            <th>' . lang("Descripción") . '</th>
                                            ' . ($_POST["Existencia"] == "on" ? '<th>' . lang("Existencia") . '</th>' : '') . '
                                            ' . ($_POST["Existencia"] == "on" ? '<th>' . lang("Desglose") . '</th>' : '') . '
                                            ' . ($_POST["costozzzv"] == "on" ? '<th>' . (trim($LitCosto) !== "" ? $LitCosto : lang("Costo")) . '</th>' : '') . '
                                            ' . ($_POST["precioz"] == "on" ? '<th>' . (trim($LitP01) !== "" ? $LitP01 : lang("Precio") . " 1") . '</th>' : '') . '
                                            ' . ($_POST["precio2z"] == "on" ? '<th>' . (trim($LitP02) !== "" ? $LitP02 : lang("Precio") . " 2") . '</th>' : '') . '
                                            ' . ($_POST["precio3z"] == "on" ? '<th>' . (trim($LitP03) !== "" ? $LitP03 : lang("Precio") . " 3") . '</th>' : '') . '
                                            ' . ($_POST["precio4z"] == "on" ? '<th>' . (trim($LitP04) !== "" ? $LitP04 : lang("Precio") . " 4") . '</th>' : '') . '
                                            ' . ($_POST["precio5z"] == "on" ? '<th>' . (trim($LitP05) !== "" ? $LitP05 : lang("Precio") . " 5") . '</th>' : '') . '
                                            ' . ($_POST["precio6z"] == "on" ? '<th>' . (trim($LitP06) !== "" ? $LitP06 : lang("Precio") . " 6") . '</th>' : '') . '
                                            ' . ($_POST["precio7z"] == "on" ? '<th>' . (trim($LitP07) !== "" ? $LitP07 : lang("Precio") . " 7") . '</th>' : '') . '
                                            ' . ($_POST["precio8z"] == "on" ? '<th>' . (trim($LitP08) !== "" ? $LitP08 : lang("Precio") . " 8") . '</th>' : '') . '
                                            ' . ($_POST["precio9z"] == "on" ? '<th>' . (trim($LitP09) !== "" ? $LitP09 : lang("Precio") . " 9") . '</th>' : '') . '
                                            ' . ($_POST["precio10z"] == "on" ? '<th>' . (trim($LitP10) !== "" ? $LitP10 : lang("Precio") . " 10") . '</th>' : '') . '
                                            ' . ($_POST["cimp"] == "on" ? '<th>' . lang("Imp") . '</th>' : '') . '
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
                                " . (($_POST["Existencia"] == "on" ? "<td>" . ($row["factorunit"] <> 1 && $row["factorunit"] <> 0 ? " " . $row["factorunit"] . " x " . getcantformat($row["Existencia"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " = " . getcantformat($row["Existencia"] * $row["factorunit"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $row["Medida"] : number_format($row['Existencia'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])) . "</td>" : "")) . "
                                " . (($_POST["Existencia"] == "on" ? "<td>-</td>" : "")) . "
                                " . (($_POST["costozzzv"] == "on" ? "<td>" . number_format(($row['costo']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . "</td>" : "")) . "
                                " . (($_POST["precioz"] == "on" ? "<td>" . number_format(($row['PrecioNeto']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . "</td>" : "")) . "
                                " . (($_POST["precio2z"] == "on" ? "<td>" . number_format(($row['PrecioNeto2']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . " " . (($row['CantP1'] > 1) ? ' / ' . number_format(trim($row['PrecioNeto2']) / $row['CantP1'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '') . "</td>" : "")) . "
                                " . (($_POST["precio3z"] == "on" ? "<td>" . number_format(($row['PrecioNeto3']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . " " . (($row['CantP2'] > 1) ? ' / ' . number_format(trim($row['PrecioNeto3']) / $row['CantP2'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '') . "</td>" : "")) . "
                                " . (($_POST["precio4z"] == "on" ? "<td>" . number_format(($row['PrecioNeto4']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . " " . (($row['CantP4'] > 1) ? ' / ' . number_format(trim($row['PrecioNeto4']) / $row['CantP4'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '') . "</td>" : "")) . "
                                " . (($_POST["precio5z"] == "on" ? "<td>" . number_format(($row['PrecioNeto5']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . " " . (($row['CantP5'] > 1) ? ' / ' . number_format(trim($row['PrecioNeto5']) / $row['CantP5'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '') . "</td>" : "")) . "
                                " . (($_POST["precio6z"] == "on" ? "<td>" . number_format(($row['PrecioNeto6']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . " " . (($row['CantP6'] > 1) ? ' / ' . number_format(trim($row['PrecioNeto6']) / $row['CantP6'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '') . "</td>" : "")) . "
                                " . (($_POST["precio7z"] == "on" ? "<td>" . number_format(($row['PrecioNeto7']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . " " . (($row['CantP7'] > 1) ? ' / ' . number_format(trim($row['PrecioNeto7']) / $row['CantP7'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '') . "</td>" : "")) . "
                                " . (($_POST["precio8z"] == "on" ? "<td>" . number_format(($row['PrecioNeto8']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . " " . (($row['CantP8'] > 1) ? ' / ' . number_format(trim($row['PrecioNeto8']) / $row['CantP8'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '') . "</td>" : "")) . "
                                " . (($_POST["precio9z"] == "on" ? "<td>" . number_format(($row['PrecioNeto9']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . " " . (($row['CantP9'] > 1) ? ' / ' . number_format(trim($row['PrecioNeto9']) / $row['CantP9'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '') . "</td>" : "")) . "
                                " . (($_POST["precio10z"] == "on" ? "<td>" . number_format(($row['PrecioNeto10']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . " " . (($row['CantP10'] > 1) ? ' / ' . number_format(trim($row['PrecioNeto10']) / $row['CantP10'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '') . "</td>" : "")) . "
                                " . (($_POST["cimp"] == "on" ? "<td>" . trim($row['ValorImpuesto']) . "</td>" : "")) . "
                            </tr>
                        ";
                                $n = 1;
                            } else if ($Marca <> $row["Marca"]) {
                                echo '
                            <section class="product-category">
                                <h3>' . $Marca . '</h3>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>' . lang("Descripción") . '</th>
                                            ' . ($_POST["Existencia"] == "on" ? '<th>' . lang("Existencia") . '</th>' : '') . '
                                            ' . ($_POST["Existencia"] == "on" ? '<th>' . lang("Desglose") . '</th>' : '') . '
                                            ' . ($_POST["costozzzv"] == "on" ? '<th>' . (trim($LitCosto) !== "" ? $LitCosto : lang("Costo")) . '</th>' : '') . '
                                            ' . ($_POST["precioz"] == "on" ? '<th>' . (trim($LitP01) !== "" ? $LitP01 : lang("Precio") . " 1") . '</th>' : '') . '
                                            ' . ($_POST["precio2z"] == "on" ? '<th>' . (trim($LitP02) !== "" ? $LitP02 : lang("Precio") . " 2") . '</th>' : '') . '
                                            ' . ($_POST["precio3z"] == "on" ? '<th>' . (trim($LitP03) !== "" ? $LitP03 : lang("Precio") . " 3") . '</th>' : '') . '
                                            ' . ($_POST["precio4z"] == "on" ? '<th>' . (trim($LitP04) !== "" ? $LitP04 : lang("Precio") . " 4") . '</th>' : '') . '
                                            ' . ($_POST["precio5z"] == "on" ? '<th>' . (trim($LitP05) !== "" ? $LitP05 : lang("Precio") . " 5") . '</th>' : '') . '
                                            ' . ($_POST["precio6z"] == "on" ? '<th>' . (trim($LitP06) !== "" ? $LitP06 : lang("Precio") . " 6") . '</th>' : '') . '
                                            ' . ($_POST["precio7z"] == "on" ? '<th>' . (trim($LitP07) !== "" ? $LitP07 : lang("Precio") . " 7") . '</th>' : '') . '
                                            ' . ($_POST["precio8z"] == "on" ? '<th>' . (trim($LitP08) !== "" ? $LitP08 : lang("Precio") . " 8") . '</th>' : '') . '
                                            ' . ($_POST["precio9z"] == "on" ? '<th>' . (trim($LitP09) !== "" ? $LitP09 : lang("Precio") . " 9") . '</th>' : '') . '
                                            ' . ($_POST["precio10z"] == "on" ? '<th>' . (trim($LitP10) !== "" ? $LitP10 : lang("Precio") . " 10") . '</th>' : '') . '
                                            ' . ($_POST["cimp"] == "on" ? '<th>' . lang("Imp") . '</th>' : '') . '
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
                                " . (($_POST["Existencia"] == "on" ? "<td>" . ($row["factorunit"] <> 1 && $row["factorunit"] <> 0 ? " " . $row["factorunit"] . " x " . getcantformat($row["Existencia"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " = " . getcantformat($row["Existencia"] * $row["factorunit"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $row["Medida"] : number_format($row['Existencia'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])) . "</td>" : "")) . "
                                " . (($_POST["Existencia"] == "on" ? "<td>-</td>" : "")) . "
                                " . (($_POST["costozzzv"] == "on" ? "<td>" . number_format(($row['costo']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . "</td>" : "")) . "
                                " . (($_POST["precioz"] == "on" ? "<td>" . number_format(($row['PrecioNeto']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . "</td>" : "")) . "
                                " . (($_POST["precio2z"] == "on" ? "<td>" . number_format(($row['PrecioNeto2']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . " " . (($row['CantP1'] > 1) ? ' / ' . number_format(trim($row['PrecioNeto2']) / $row['CantP1'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '') . "</td>" : "")) . "
                                " . (($_POST["precio3z"] == "on" ? "<td>" . number_format(($row['PrecioNeto3']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . " " . (($row['CantP2'] > 1) ? ' / ' . number_format(trim($row['PrecioNeto3']) / $row['CantP2'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '') . "</td>" : "")) . "
                                " . (($_POST["precio4z"] == "on" ? "<td>" . number_format(($row['PrecioNeto4']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . " " . (($row['CantP4'] > 1) ? ' / ' . number_format(trim($row['PrecioNeto4']) / $row['CantP4'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '') . "</td>" : "")) . "
                                " . (($_POST["precio5z"] == "on" ? "<td>" . number_format(($row['PrecioNeto5']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . " " . (($row['CantP5'] > 1) ? ' / ' . number_format(trim($row['PrecioNeto5']) / $row['CantP5'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '') . "</td>" : "")) . "
                                " . (($_POST["precio6z"] == "on" ? "<td>" . number_format(($row['PrecioNeto6']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . " " . (($row['CantP6'] > 1) ? ' / ' . number_format(trim($row['PrecioNeto6']) / $row['CantP6'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '') . "</td>" : "")) . "
                                " . (($_POST["precio7z"] == "on" ? "<td>" . number_format(($row['PrecioNeto7']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . " " . (($row['CantP7'] > 1) ? ' / ' . number_format(trim($row['PrecioNeto7']) / $row['CantP7'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '') . "</td>" : "")) . "
                                " . (($_POST["precio8z"] == "on" ? "<td>" . number_format(($row['PrecioNeto8']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . " " . (($row['CantP8'] > 1) ? ' / ' . number_format(trim($row['PrecioNeto8']) / $row['CantP8'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '') . "</td>" : "")) . "
                                " . (($_POST["precio9z"] == "on" ? "<td>" . number_format(($row['PrecioNeto9']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . " " . (($row['CantP9'] > 1) ? ' / ' . number_format(trim($row['PrecioNeto9']) / $row['CantP9'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '') . "</td>" : "")) . "
                                " . (($_POST["precio10z"] == "on" ? "<td>" . number_format(($row['PrecioNeto10']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . " " . (($row['CantP10'] > 1) ? ' / ' . number_format(trim($row['PrecioNeto10']) / $row['CantP10'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '') . "</td>" : "")) . "
                                " . (($_POST["cimp"] == "on" ? "<td>" . trim($row['ValorImpuesto']) . "</td>" : "")) . "
                            </tr>
                        ";
                                $n = 1;
                            } else {
                                $body .= "
                            <tr>
                                <td>" . trim($row['Descripcion']) . "</td>
                                " . (($_POST["Existencia"] == "on" ? "<td>" . ($row["factorunit"] <> 1 && $row["factorunit"] <> 0 ? " " . $row["factorunit"] . " x " . getcantformat($row["Existencia"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " = " . getcantformat($row["Existencia"] * $row["factorunit"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $row["Medida"] : number_format($row['Existencia'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])) . "</td>" : "")) . "
                                " . (($_POST["Existencia"] == "on" ? "<td>-</td>" : "")) . "
                                " . (($_POST["costozzzv"] == "on" ? "<td>" . number_format(($row['costo']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . "</td>" : "")) . "
                                " . (($_POST["precioz"] == "on" ? "<td>" . number_format(($row['PrecioNeto']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . "</td>" : "")) . "
                                " . (($_POST["precio2z"] == "on" ? "<td>" . number_format(($row['PrecioNeto2']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . " " . (($row['CantP1'] > 1) ? ' / ' . number_format(trim($row['PrecioNeto2']) / $row['CantP1'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '') . "</td>" : "")) . "
                                " . (($_POST["precio3z"] == "on" ? "<td>" . number_format(($row['PrecioNeto3']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . " " . (($row['CantP2'] > 1) ? ' / ' . number_format(trim($row['PrecioNeto3']) / $row['CantP2'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '') . "</td>" : "")) . "
                                " . (($_POST["precio4z"] == "on" ? "<td>" . number_format(($row['PrecioNeto4']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . " " . (($row['CantP4'] > 1) ? ' / ' . number_format(trim($row['PrecioNeto4']) / $row['CantP4'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '') . "</td>" : "")) . "
                                " . (($_POST["precio5z"] == "on" ? "<td>" . number_format(($row['PrecioNeto5']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . " " . (($row['CantP5'] > 1) ? ' / ' . number_format(trim($row['PrecioNeto5']) / $row['CantP5'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '') . "</td>" : "")) . "
                                " . (($_POST["precio6z"] == "on" ? "<td>" . number_format(($row['PrecioNeto6']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . " " . (($row['CantP6'] > 1) ? ' / ' . number_format(trim($row['PrecioNeto6']) / $row['CantP6'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '') . "</td>" : "")) . "
                                " . (($_POST["precio7z"] == "on" ? "<td>" . number_format(($row['PrecioNeto7']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . " " . (($row['CantP7'] > 1) ? ' / ' . number_format(trim($row['PrecioNeto7']) / $row['CantP7'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '') . "</td>" : "")) . "
                                " . (($_POST["precio8z"] == "on" ? "<td>" . number_format(($row['PrecioNeto8']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . " " . (($row['CantP8'] > 1) ? ' / ' . number_format(trim($row['PrecioNeto8']) / $row['CantP8'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '') . "</td>" : "")) . "
                                " . (($_POST["precio9z"] == "on" ? "<td>" . number_format(($row['PrecioNeto9']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . " " . (($row['CantP9'] > 1) ? ' / ' . number_format(trim($row['PrecioNeto9']) / $row['CantP9'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '') . "</td>" : "")) . "
                                " . (($_POST["precio10z"] == "on" ? "<td>" . number_format(($row['PrecioNeto10']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda . " " . (($row['CantP10'] > 1) ? ' / ' . number_format(trim($row['PrecioNeto10']) / $row['CantP10'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : '') . "</td>" : "")) . "
                                " . (($_POST["cimp"] == "on" ? "<td>" . trim($row['ValorImpuesto']) . "</td>" : "")) . "
                                
                            </tr>
                        ";
                                $n++;
                            }
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
                                            <th>' . lang("Descripción") . '</th>
                                            ' . ($_POST["Existencia"] == "on" ? '<th>' . lang("Existencia") . '</th>' : '') . '
                                            ' . ($_POST["Existencia"] == "on" ? '<th>' . lang("Desglose") . '</th>' : '') . '
                                            ' . ($_POST["costozzzv"] == "on" ? '<th>' . (trim($LitCosto) !== "" ? $LitCosto : lang("Costo")) . '</th>' : '') . '
                                            ' . ($_POST["precioz"] == "on" ? '<th>' . (trim($LitP01) !== "" ? $LitP01 : lang("Precio") . " 1") . '</th>' : '') . '
                                            ' . ($_POST["precio2z"] == "on" ? '<th>' . (trim($LitP02) !== "" ? $LitP02 : lang("Precio") . " 2") . '</th>' : '') . '
                                            ' . ($_POST["precio3z"] == "on" ? '<th>' . (trim($LitP03) !== "" ? $LitP03 : lang("Precio") . " 3") . '</th>' : '') . '
                                            ' . ($_POST["precio4z"] == "on" ? '<th>' . (trim($LitP04) !== "" ? $LitP04 : lang("Precio") . " 4") . '</th>' : '') . '
                                            ' . ($_POST["precio5z"] == "on" ? '<th>' . (trim($LitP05) !== "" ? $LitP05 : lang("Precio") . " 5") . '</th>' : '') . '
                                            ' . ($_POST["precio6z"] == "on" ? '<th>' . (trim($LitP06) !== "" ? $LitP06 : lang("Precio") . " 6") . '</th>' : '') . '
                                            ' . ($_POST["precio7z"] == "on" ? '<th>' . (trim($LitP07) !== "" ? $LitP07 : lang("Precio") . " 7") . '</th>' : '') . '
                                            ' . ($_POST["precio8z"] == "on" ? '<th>' . (trim($LitP08) !== "" ? $LitP08 : lang("Precio") . " 8") . '</th>' : '') . '
                                            ' . ($_POST["precio9z"] == "on" ? '<th>' . (trim($LitP09) !== "" ? $LitP09 : lang("Precio") . " 9") . '</th>' : '') . '
                                            ' . ($_POST["precio10z"] == "on" ? '<th>' . (trim($LitP10) !== "" ? $LitP10 : lang("Precio") . " 10") . '</th>' : '') . '
                                            ' . ($_POST["cimp"] == "on" ? '<th>' . lang("Imp") . '</th>' : '') . '
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
                }




                        ?>
                        <div class="encabezado" style="font-size: 2px;">
                            <hr>
                        </div>


                        <div style="PAGE-BREAK-AFTER: always; visibility: hidden;">a</div>
                        <form id="formexcel" action="excelv3led.php" method="post">
                            <?php
                            ?>
                            <?php
                            $compa = $_POST["CompanyActual"];
                            $name = lang("ListaPrecios") . ".csv";
                            ?>

                            <input type="hidden" name="registro" id="registro" value="<?php echo $pro2; ?>" />
                            <input type="hidden" name="Qry" id="Qry" value="<?php echo $query; ?>" />
                            <input type="hidden" name="Name" id="Name" value="<?php echo $name; ?>" />
                            <input type="hidden" name="Company" id="Company" value="<?php echo $compa; ?>" />
                            <input type="hidden" name="ser" id="ser" value="" />
                        </form>
</body>

</html>
<script>
    const totalPages = document.querySelectorAll('.page').length;
    document.documentElement.style.setProperty('--total-pages', totalPages);
</script>