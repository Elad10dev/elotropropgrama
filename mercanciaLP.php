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

if ($_POST["Agrupar"] == "empty") {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta http-equiv="Expires" content="0">
        <meta http-equiv="Last-Modified" content="0">
        <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
        <meta http-equiv="Pragma" content="no-cache">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Hugo 0.82.0">
        <title><?php echo lang("Lista de Precios"); ?></title>
        <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css"> -->
        <link rel="shortcut icon" href="img/AZUL.png" type="image/x-icon">
        <link rel="icon" href="img/ISO AZUL.svg" sizes="32x32" type="image/png">
        <link rel="apple-touch-icon" href="img/ISO AZUL.svg" sizes="180x180">
        <link rel="icon" href="img/ISO AZUL.svg" sizes="16x16" type="image/png">
        <link rel="icon" href="img/ISO AZUL.svg">
    </head>
    <style>
        @media print {
            .ocultoimpresion {
                display: none !important;
            }

            @page {
                margin: 0;
                size: landscape;
            }

            .saltopagina {
                display: block;
                page-break-before: always;
            }

        }

        :root {
            --total-pages: 0;
        }

        .page {}

        body {
            counter-reset: page-counter 0 total-pages var(--total-pages);
            font-family: Tahoma, Verdana, Segoe, sans-serif;
            line-height: 1;
            margin: 5mm 5mm 5mm 5mm;
        }

        .pagina {}

        .sup {
            float: left;
            width: 100%;
        }

        .TituloEmpresa {
            font-weight: 600;
            font-size: 16.4px;
            text-align: left;
        }

        .Subtituloempresa {
            font-size: 9.3px;
            text-align: left;
        }

        .FechaI {
            font-size: 10px;
            text-align: right;
            float: right;

        }

        .page::before {
            counter-increment: page-counter 1;
            font-size: 10px;


            content: "Pagina " counter(page-counter) " de " counter(total-pages);
            align-content: right;
        }

        .encabezado {
            margin-top: 5px;
            float: left;
            width: 100%;
            padding: 0 2px 0 0;
            margin-right: 1%;
            text-align: left;
            background-color: white;
            font-size: 10px;
        }

        .campo {
            float: left;
            margin-right: 3px;
            font-size: 9px;

        }

        .registro {
            float: left;
            width: 100%;
            padding: 0 2px 0 0;
            margin-right: 1%;
            text-align: left;
            background-color: white;
        }

        .secciones {
            width: 80%;
            font-size: 11px;
            text-align: center;
            margin-left: 16%;
            background-color: black;
        }

        .rsecciones {
            width: 34%;
            float: left;
        }

        .TodosLosRecuadros {
            width: 100%;
            background-color: black;
            font-family: Tahoma, Verdana, Segoe, sans-serif;
            font-size: 10px;
            text-align: right
        }

        .Recuadros {
            width: 10%;
            float: left;
            display: block;
            margin-left: 5px;
            margin-right: 5px;
        }

        .TituloR {
            background-color: gray;
        }

        .pie {}
    </style>

    <body>
        <button type='submit' class='ocultoimpresion ' onclick='window.print();'><img src='/img/pdf.png' width='28' height='28'><br>PDF</button>
        <button class='ocultoimpresion ' onclick='document.getElementById(`formexcel`).submit()'><img src='/img/excel.png' width='28' height='28'><br><?php echo lang("ListaPrecios"); ?><br></button>
        <div class="pagina" style="font-size: 12px;">
            <div class="sup">
                <div style="float:left; width: 33%;">
                    <div class="TituloEmpresa" id="Titulo"><?php echo $_POST["NameCompany"]; ?></div>
                    <div class="Subtituloempresa" id="Ubicacion"><?php echo $_POST["direccion"]; ?></div>
                    <div class="Subtituloempresa" id="Literal Fiscal"><?php echo $_POST["litfiscal"]; ?>-<?php echo $_POST["rute"]; ?></div>
                </div>
                <div style="float:left; width: 33%;">
                    <div class="TituloEmpresa" style="float: center; text-align: center;"><?php echo lang("Lista de Precios"); ?></div>
                    <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php echo lang("Fecha"); ?>:<?php echo $_POST["FechaHastalista"]; ?> </div>
                    <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php echo lang("Orden por"); ?>:
                        <?php echo $_POST["OrdenLP"];
                        if ($_POST["CodigoDesdeLP"] == true) {
                            echo " / " . lang("Desde el Producto:") . $_POST["CodigoDesdeLP"];
                        }
                        if ($_POST["CodigoHastaLP"] == true) {
                            echo "al " . $_POST["CodigoHastaLP"];
                        }
                        ?>
                    </div>
                    <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                        <?php
                        if ($_POST["Instancia2LP"] == true) {
                            echo "De la Familia: / " . $_POST["Instancia2LP"];
                        }
                        ?>
                    </div>
                    <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                        <?php
                        if ($_POST["Proevedor2LP"] == true or $_POST["MarcaLPUTA2"] == true or $_POST["Deposito2LP"] == true) {
                            echo "Con:";
                        } else {
                            echo "--------------------";
                        } ?>
                        <?php
                        if ($_POST["Proevedor2LP"] == true) {
                            echo lang("Beneficiario") . ":/" . $_POST["Proevedor2LP"];
                        }
                        if ($_POST["MarcaLPUTA2"] == true) {
                            echo " / " . lang("Marca") . ":" . $_POST["MarcaLPUTA2"];
                        }
                        if ($_POST["Deposito2LP"] == true) {
                            echo " / " . lang("Almacen:") . $_POST["Deposito2LP"];
                        }
                        ?>
                    </div>
                    <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                        <?php
                        if ($_POST["ExistenciaCero"] == "on") {
                            echo lang("Incluyendo:");
                        } else {
                            echo "--------------------";
                        }
                        if ($_POST["ExistenciaCero"] == "on") {
                            echo " / " . lang("Existencia Cero");
                        }
                        ?>
                    </div>
                    <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                        <?php
                        if ($_POST["precioz"] == "on" or $_POST["precio2z"] == "on" or $_POST["precio3z"] == "on" or $_POST["precio4z"] == "on" or $_POST["precio5z"] == "on"  or $_POST["precio6z"] == "on" or $_POST["precio7z"] == "on" or $_POST["precio8z"] == "on" or $_POST["precio9z"] == "on" or $_POST["precio10z"] == "on") {
                            echo lang("Precio") . ' ';
                            if ($_POST['cimp'] == true) {
                                echo lang("Con Impuesto");
                            } else {
                                echo lang("Sin Impuesto");
                            }
                        }
                        ?>
                    </div>
                </div>

                <div style="float:left; width: 33%;">
                    <div class="FechaI"><span id="fectx"><?php echo $_POST["fectx5"]; ?></span></div><br>
                    <div class="FechaI">
                        <div class="page"></div>
                    </div><br>
                    <div class="FechaI"><img style="width: 30%;" src="img/AZUL.svg" /></div><br><br>
                    <div class="FechaI">-</div>
                </div>
            </div>
            <div class="encabezado" style="">

                <div class="campo" style=" text-align: left; width: 11.5%; background-color: gray;"><?php echo lang("S.K.U"); ?></div>

                <div class="campo" style=" text-align: left; width: 20%; background-color: gray;"><?php echo lang("Descripción"); ?></div>
                <?php
                if ($_POST["MostrarMarcas"] === "on") {
                ?>
                    <div class="campo" style=" text-align: left; width: 6%; background-color: gray;"><?php echo lang("Marca"); ?></div>

                <?php
                }
                if ($_POST["MostrarFamilias"] === "on") { ?>
                    <div class="campo" style=" text-align: left; width: 6%; background-color: gray;"><?php echo lang("Familia"); ?></div>

                <?php
                }
                ?>



                <?php if ($_POST["Existencia"] == "on") {
                ?>

                    <!-- <div class="campo" style=" text-align: left; width: 6%; background-color: gray;"><?php echo lang("Referencia"); ?> </div> -->
                    <div class="campo" style=" text-align: right; width: 6%; background-color: gray;"><?php echo lang("Existencia"); ?> </div>
                    <div class="campo" style=" text-align: right; width: 6%; background-color: gray;"><?php echo lang("Desglose"); ?> </div>

                <?php }





                if ($_POST["costozzzv"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitCosto) !== "" ? $LitCosto : lang("Costo")); ?></div>
                <?php
                }
                if ($_POST["precioz"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP01) !== "" ? $LitP01 : lang("Precio") . " 1"); ?></div>
                <?php
                } ?>
                <?php if ($_POST["precio2z"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP02) !== "" ? $LitP02 : lang("Precio") . " 2"); ?></div>
                <?php
                } ?>

                <?php if ($_POST["precio3z"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP03) !== "" ? $LitP03 : lang("Precio") . " 3"); ?></div>
                <?php
                }  ?>

                <?php if ($_POST["precio4z"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP04) !== "" ? $LitP04 : lang("Precio") . " 4"); ?> </div>
                <?php
                }  ?>

                <?php if ($_POST["precio5z"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP05) !== "" ? $LitP05 : lang("Precio") . " 5"); ?> </div>
                <?php
                }  ?>

                <?php if ($_POST["precio6z"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP06) !== "" ? $LitP06 : lang("Precio") . " 6"); ?> </div>
                <?php
                }  ?>

                <?php if ($_POST["precio7z"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP07) !== "" ? $LitP07 : lang("Precio") . " 7"); ?> </div>
                <?php
                }  ?>

                <?php if ($_POST["precio8z"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP08) !== "" ? $LitP08 : lang("Precio") . " 8"); ?> </div>
                <?php
                }  ?>

                <?php if ($_POST["precio9z"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP09) !== "" ? $LitP09 : lang("Precio") . " 9"); ?> </div>
                <?php
                }  ?>

                <?php if ($_POST["precio10z"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP10) !== "" ? $LitP10 : lang("Precio") . " 10"); ?> </div>
                <?php
                }  ?>

                <?php if ($_POST["cimp"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: 2%; background-color: gray;">%<?php echo lang("Imp"); ?></div>
                <?php
                }  ?>
            </div> <?php
                    //---------------------------------------------------------------------------------------------------------------------------

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

                    if ($result = mysqli_query($conn, $query)) {
                        $n = 0;
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


                            if ($color == 0) {
                                $color = 1;
                            } else {
                                $color = 0;
                            }
                    ?>
                    <div style="text-align: left; float:left; width: 100%; <?php echo ($color == 0 ? "" : "background: #EDECEC;"); ?>">



                        <div class="campo" style=" text-align: left; width: 11.5%; text-wrap: wrap; white-space: normal !important; ">
                            <?php
                            if (trim(trim($row['CodIdAmpliado'])) === "") {
                                echo "-";
                            } else {
                                echo trim($row['CodIdAmpliado']);
                            }
                            ?>
                        </div>
                        <div class="campo" style=" text-align: left; width: 20%; text-wrap: wrap; white-space: normal !important; ">
                            <?php
                            if (trim(trim($row['Descripcion'])) === "") {
                                echo "-";
                            } else {
                                echo trim($row['Descripcion']);
                            }
                            //  if ($row['Envase'] == "" or $row['Envase'] == "0") {
                            //     echo "";
                            // } else {
                            //     echo "<br>"; // ; 
                            //     $explode = explode("|", $row['Envase']);
                            //     foreach ($explode as $val) {
                            //         if (trim($val) <> '') {
                            //             echo "<span style='background:#EAEAEA;'>" . $val . "</span>&nbsp; ";
                            //         }
                            //         # code...
                            //     }
                            // }
                            $explode = '';
                            ?>


                        </div>
                        <?php
                            if ($_POST["MostrarMarcas"] === "on") {
                        ?> <div class="campo" style=" text-align: left; width: 6%; ">
                                <?php
                                if (trim($row['Marca']) == "") {
                                    echo "-";
                                } else {
                                    echo trim($row['Marca']);
                                }
                                ?>
                            </div>

                        <?php
                            }
                            if ($_POST["MostrarFamilias"] === "on") { ?>
                            <div class="campo" style=" text-align: left; width: 6%; ">
                                <?php
                                if (trim($row['Familia']) == "") {
                                    echo "-";
                                } else {
                                    echo trim($row['Familia']);
                                }
                                ?>
                            </div>


                        <?php
                            }
                        ?>

                        <?php if ($_POST["Existencia"] == "on") {
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
                            <div class="campo" style=" text-align: right; width: 6% ">
                                <?php
                                if ($row['Existencia'] == "") {
                                    echo "-";
                                } else {
                                    echo ($row["factorunit"] <> 1 && $row["factorunit"] <> 0 ? " " . $row["factorunit"] . " x " . getcantformat($row["Existencia"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " = " . getcantformat($row["Existencia"] * $row["factorunit"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $row["Medida"] : number_format($row['Existencia'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]));
                                }
                                ?>
                            </div>
                            <div class="campo" style=" text-align: right; width: 6%; ">&nbsp;
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
                            </div>
                        <?php
                            }
                            if ($_POST["costozzzv"] == "on") {
                        ?>
                            <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; ">
                                <?php
                                if (trim($row['costo']) == "") {
                                    echo "-";
                                } else {
                                    echo number_format(trim($row['costo']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;
                                }
                                ?>
                            </div>
                        <?php
                            }
                            if ($_POST["precioz"] == "on") {
                        ?>
                            <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; ">
                                <?php
                                if (trim($row['PrecioNeto']) == "") {
                                    echo "-";
                                } else {
                                    echo number_format(trim($row['PrecioNeto']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;
                                }
                                ?>
                            </div>
                        <?php
                            }
                            if ($_POST["precio2z"] == "on") {
                        ?>
                            <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; ">
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
                            </div>
                        <?php
                            }

                            if ($_POST["precio3z"] == "on") {
                        ?>
                            <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; ">
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
                            </div>
                        <?php
                            }

                            if ($_POST["precio4z"] == "on") {
                        ?>
                            <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; ">
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
                            </div>
                        <?php
                            }

                            if ($_POST["precio5z"] == "on") {
                        ?>
                            <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; ">
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
                            </div>
                        <?php
                            }

                            if ($_POST["precio6z"] == "on") {
                        ?>
                            <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; ">
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
                            </div>
                        <?php
                            }

                            if ($_POST["precio7z"] == "on") {
                        ?>
                            <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; ">
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
                            </div>
                        <?php
                            }

                            if ($_POST["precio8z"] == "on") {
                        ?>
                            <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; ">
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
                            </div>
                        <?php
                            }

                            if ($_POST["precio9z"] == "on") {
                        ?>
                            <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; ">
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
                            </div>
                        <?php
                            }

                            if ($_POST["precio10z"] == "on") {
                        ?>
                            <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; ">
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
                            </div>
                        <?php
                            }

                            if ($_POST["cimp"] == "on") {
                        ?>
                            <div class="campo" style=" text-align: right; width: 2%; ">
                                <?php
                                if (trim($row['ValorImpuesto']) == "") {
                                    echo "-";
                                } else {
                                    echo trim($row['ValorImpuesto']);
                                }
                                ?>
                            </div>
                        <?php
                            } ?>


                    </div><?php

                            if ($n >= 50) {
                            ?>
                        <div class="encabezado" style="font-size: 2px;">
                            <hr>
                        </div>
                        <div class="encabezado" style="">
                            <div class="campo" style="visibility:hidden; text-align: left; width: 6.5%; background-color: gray;">Código Barra</div>
                            <div class="campo" style="visibility:hidden; text-align: left; width: 5%; background-color: gray;">S.K.U</div>
                            <div class="campo" style="visibility:hidden; text-align: left; width: 20%; background-color: gray;">Descripción</div> <?php
                                                                                                                                                    if ($_POST["MostrarMarcas"] === "on") {
                                                                                                                                                    ?>
                                <div class="campo" style=" text-align: left; width: 6%; background-color: gray;"><?php echo lang("Marca"); ?></div>

                            <?php
                                                                                                                                                    }
                            ?>
                            <?php if ($_POST["precioz"] == "on" or $_POST["precio2z"] == "on" or $_POST["precio3z"] == "on" or $_POST["precio4z"] == "on" or $_POST["precio5z"] == "on"  or $_POST["precio6z"] == "on" or $_POST["precio7z"] == "on" or $_POST["precio8z"] == "on" or $_POST["precio9z"] == "on" or $_POST["precio10z"] == "on" or $_POST["Existencia"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: left; width: 6%; background-color: gray;"><?php echo lang("Totales por pagina"); ?></div>
                            <?php
                                } ?>
                            <?php if ($_POST["Existencia"] == "on") {
                            ?>
                                <!-- <div class="campo" style="visibility:hidden; text-align: right; width: 6%; background-color: gray;">UND </div> -->
                                <div class="campo" style=" text-align: right; width: 6%; background-color: gray;"> <?php echo  number_format($existenciaX, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></div>
                                <div class="campo" style="visibility:hidden; text-align: right; width: 6%; background-color: gray;">UND </div>
                            <?php }
                                if ($_POST["costozzzv"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($CostoXexistT, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?></div>
                            <?php
                                }
                                if ($_POST["precioz"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                                } ?>
                            <?php if ($_POST["precio2z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"> <?php echo  number_format($precioT2, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?></div>
                            <?php
                                }
                                if ($_POST["precio3z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT3, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                                }
                                if ($_POST["precio4z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT4, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                                }
                                if ($_POST["precio5z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT5, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                                }
                                if ($_POST["precio6z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT6, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                                }
                                if ($_POST["precio7z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT7, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                                }
                                if ($_POST["precio8z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT8, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                                }
                                if ($_POST["precio9z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT9, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                                }
                                if ($_POST["precio10z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT10, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                                }
                            ?>
                        </div>

                        <?php
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
                        <div class="encabezado" style="font-size: 2px;">
                            <hr>
                        </div>

                        <div style="PAGE-BREAK-AFTER: always"></div>
                        <div class="sup">
                            <div style="float:left; width: 33%;">
                                <div class="TituloEmpresa" id="Titulo"><?php echo $_POST["NameCompany"]; ?></div>
                                <div class="Subtituloempresa" id="Ubicacion"><?php echo $_POST["direccion"]; ?></div>
                                <div class="Subtituloempresa" id="Literal Fiscal"><?php echo $_POST["litfiscal"]; ?>-<?php echo $_POST["rute"]; ?></div>
                            </div>
                            <div style="float:left; width: 33%;">
                                <div class="TituloEmpresa" style="float: center; text-align: center;"><?php echo lang("Lista de Precios"); ?></div>
                                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php echo lang("Fecha"); ?>:<?php echo $_POST["FechaHastalista"]; ?> </div>
                                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php echo lang("Orden por"); ?>:
                                    <?php echo $_POST["OrdenLP"];
                                    if ($_POST["CodigoDesdeLP"] == true) {
                                        echo " / " . lang("Desde el Producto:") . $_POST["CodigoDesdeLP"];
                                    }
                                    if ($_POST["CodigoHastaLP"] == true) {
                                        echo "al " . $_POST["CodigoHastaLP"];
                                    }
                                    ?>
                                </div>
                                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                                    <?php
                                    if ($_POST["Instancia2LP"] == true) {
                                        echo "De la Familia: / " . $_POST["Instancia2LP"];
                                    }
                                    ?>
                                </div>
                                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                                    <?php
                                    if ($_POST["Proevedor2LP"] == true or $_POST["MarcaLPUTA2"] == true or $_POST["Deposito2LP"] == true) {
                                        echo "Con:";
                                    } else {
                                        echo "--------------------";
                                    } ?>
                                    <?php
                                    if ($_POST["Proevedor2LP"] == true) {
                                        echo lang("Beneficiario") . ":/" . $_POST["Proevedor2LP"];
                                    }
                                    if ($_POST["MarcaLPUTA2"] == true) {
                                        echo " / " . lang("Marca") . ":" . $_POST["MarcaLPUTA2"];
                                    }
                                    if ($_POST["Deposito2LP"] == true) {
                                        echo " / " . lang("Almacen:") . $_POST["Deposito2LP"];
                                    }
                                    ?>
                                </div>
                                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                                    <?php
                                    if ($_POST["ExistenciaCero"] == "on") {
                                        echo lang("Incluyendo:");
                                    } else {
                                        echo "--------------------";
                                    }
                                    if ($_POST["ExistenciaCero"] == "on") {
                                        echo " / " . lang("Existencia Cero");
                                    }
                                    ?>
                                </div>
                                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                                    <?php
                                    if ($_POST["precioz"] == "on" or $_POST["precio2z"] == "on" or $_POST["precio3z"] == "on" or $_POST["precio4z"] == "on" or $_POST["precio5z"] == "on"  or $_POST["precio6z"] == "on" or $_POST["precio7z"] == "on" or $_POST["precio8z"] == "on" or $_POST["precio9z"] == "on" or $_POST["precio10z"] == "on") {
                                        echo lang("Precio") . ' ';
                                        if ($_POST['cimp'] == true) {
                                            echo lang("Con Impuesto");
                                        } else {
                                            echo lang("Sin Impuesto");
                                        }
                                    }
                                    ?>
                                </div>
                            </div>

                            <div style="float:left; width: 33%;">
                                <div class="FechaI"><span id="fectx"><?php echo $_POST["fectx5"]; ?></span></div><br>
                                <div class="FechaI">
                                    <div class="page"></div>
                                </div><br>
                                <div class="FechaI"><img style="width: 30%;" src="img/AZUL.svg" /></div><br><br>
                                <div class="FechaI">-</div>
                            </div>
                        </div>
                        <div class="encabezado">
                            <div class="campo" style=" text-align: left; width: 11.5%; background-color: gray;"><?php echo lang("S.K.U"); ?></div>

                            <div class="campo" style=" text-align: left; width: 20%; background-color: gray;"><?php echo lang("Descripción"); ?></div>
                            <?php
                                if ($_POST["MostrarMarcas"] === "on") {
                            ?>
                                <div class="campo" style=" text-align: left; width: 6%; background-color: gray;"><?php echo lang("Marca"); ?></div>

                            <?php
                                }
                                if ($_POST["MostrarFamilias"] === "on") {
                            ?>
                                <div class="campo" style=" text-align: left; width: 6%; background-color: gray;"><?php echo lang("Familia"); ?></div>

                            <?php
                                }
                            ?>



                            <?php if ($_POST["Existencia"] == "on") {
                            ?>

                                <!-- <div class="campo" style=" text-align: left; width: 6%; background-color: gray;"><?php echo lang("Referencia"); ?> </div> -->
                                <div class="campo" style=" text-align: right; width: 6%; background-color: gray;"><?php echo lang("Existencia"); ?> </div>
                                <div class="campo" style=" text-align: right; width: 6%; background-color: gray;"><?php echo lang("Desglose"); ?> </div>

                            <?php }
                                if ($_POST["costozzzv"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitCosto) !== "" ? $LitCosto : lang("Costo")); ?></div>
                            <?php
                                }
                                if ($_POST["precioz"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP01) !== "" ? $LitP01 : lang("Precio") . " 1"); ?></div>
                            <?php
                                } ?>
                            <?php if ($_POST["precio2z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP02) !== "" ? $LitP02 : lang("Precio") . " 2"); ?></div>
                            <?php
                                }
                                if ($_POST["precio3z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP03) !== "" ? $LitP03 : lang("Precio") . " 3"); ?></div>
                            <?php
                                }
                                if ($_POST["precio4z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP04) !== "" ? $LitP04 : lang("Precio") . " 4"); ?> </div>
                            <?php
                                }
                                if ($_POST["precio5z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP05) !== "" ? $LitP05 : lang("Precio") . " 5"); ?> </div>
                            <?php
                                }
                                if ($_POST["precio6z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP06) !== "" ? $LitP06 : lang("Precio") . " 6"); ?> </div>
                            <?php
                                }
                                if ($_POST["precio7z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP07) !== "" ? $LitP07 : lang("Precio") . " 7"); ?> </div>
                            <?php
                                }
                                if ($_POST["precio8z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP08) !== "" ? $LitP08 : lang("Precio") . " 8"); ?> </div>
                            <?php
                                }

                                if ($_POST["precio9z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP09) !== "" ? $LitP09 : lang("Precio") . " 9"); ?> </div>
                            <?php
                                }
                                if ($_POST["precio10z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP10) !== "" ? $LitP10 : lang("Precio") . " 10"); ?> </div>
                            <?php
                                }
                                if ($_POST["cimp"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: 2%; background-color: gray;">%<?php echo lang("Imp"); ?></div>
                            <?php
                                }  ?>
                        </div>
            <?php

                                $CostoExistencia = 0;
                                $unidadTotal = 0;
                                $ExistenciaTotal = 0;
                                $n = 0;
                            }
                        }
                        mysqli_free_result($result);
                    }
                    $UltimoRegistro = $row["CodIdBasico"];
            ?>
            <div class="encabezado" style="font-size: 2px;">
                <hr>
            </div>
            <div class="encabezado" style="">
                <div class="campo" style="visibility:hidden; text-align: left; width: 6.5%; background-color: gray;">Código Barra</div>
                <div class="campo" style="visibility:hidden; text-align: left; width: 5%; background-color: gray;">S.K.U</div>
                <div class="campo" style="visibility:hidden; text-align: left; width: 20%; background-color: gray;">Descripción</div> <?php
                                                                                                                                        if ($_POST["MostrarMarcas"] === "on") {
                                                                                                                                        ?>
                    <div class="campo" style=" text-align: left; width: 6%; background-color: gray;"><?php echo lang("Marca"); ?></div>

                <?php
                                                                                                                                        }
                                                                                                                                        if ($_POST["precioz"] == "on" or $_POST["precio2z"] == "on" or $_POST["precio3z"] == "on" or $_POST["precio4z"] == "on" or $_POST["precio5z"] == "on"  or $_POST["precio6z"] == "on" or $_POST["precio7z"] == "on" or $_POST["precio8z"] == "on" or $_POST["precio9z"] == "on" or $_POST["precio10z"] == "on" or $_POST["Existencia"] == "on") {
                ?>
                    <div class="campo" style=" text-align: left; width: 6%; background-color: gray;"><?php echo lang("Totales por pagina"); ?></div>
                <?php
                                                                                                                                        } ?>
                <?php if ($_POST["Existencia"] == "on") {
                ?>
                    <!-- <div class="campo" style="visibility:hidden; text-align: right; width: 6%; background-color: gray;">UND </div> -->
                    <div class="campo" style=" text-align: right; width: 6%; background-color: gray;"> <?php echo  number_format($existenciaX, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></div>
                    <div class="campo" style="visibility:hidden; text-align: right; width: 6%; background-color: gray;">UND </div>
                <?php }
                if ($_POST["costozzzv"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($CostoXexistT, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?></div>
                <?php
                }
                if ($_POST["precioz"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                <?php
                } ?>
                <?php if ($_POST["precio2z"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"> <?php echo  number_format($precioT2, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?></div>
                <?php
                }
                if ($_POST["precio3z"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT3, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                <?php
                }
                if ($_POST["precio4z"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT4, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                <?php
                }
                if ($_POST["precio5z"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT5, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                <?php
                }
                if ($_POST["precio6z"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT6, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                <?php
                }
                if ($_POST["precio7z"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT7, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                <?php
                }
                if ($_POST["precio8z"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT8, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                <?php
                }
                if ($_POST["precio9z"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT9, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                <?php
                }
                if ($_POST["precio10z"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT10, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                <?php
                }
                ?>
            </div>
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
<?php
} else  if ($_POST["Agrupar"] == "Marcazp") {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta http-equiv="Expires" content="0">
        <meta http-equiv="Last-Modified" content="0">
        <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
        <meta http-equiv="Pragma" content="no-cache">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Hugo 0.82.0">
        <title><?php echo lang("Lista de Precios"); ?></title>
        <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css"> -->
        <link rel="shortcut icon" href="img/AZUL.png" type="image/x-icon">
        <link rel="icon" href="img/ISO AZUL.svg" sizes="32x32" type="image/png">
        <link rel="apple-touch-icon" href="img/ISO AZUL.svg" sizes="180x180">
        <link rel="icon" href="img/ISO AZUL.svg" sizes="16x16" type="image/png">
        <link rel="icon" href="img/ISO AZUL.svg">
    </head>
    <style>
        @media print {
            .ocultoimpresion {
                display: none !important;
            }

            @page {
                margin: 0;
                size: landscape;
            }

            .saltopagina {
                display: block;
                page-break-before: always;
            }

        }

        :root {
            --total-pages: 0;
        }

        body {
            counter-reset: page-counter 0 total-pages var(--total-pages);
            font-family: Tahoma, Verdana, Segoe, sans-serif;
            line-height: 1;
            margin: 5mm 5mm 5mm 5mm;
        }

        .sup {
            float: left;
            width: 100%;
        }

        .TituloEmpresa {
            font-weight: 600;
            font-size: 16.4px;
            text-align: left;
        }

        .TituloEmpresa2 {
            font-size: 16.4px;
        }

        .Subtituloempresa {
            font-size: 9.3px;
            text-align: left;
        }

        .FechaI {
            font-size: 10px;
            text-align: right;
            float: right;

        }

        .page::before {
            counter-increment: page-counter 1;
            font-size: 10px;


            content: "Pagina " counter(page-counter) " de " counter(total-pages);
            align-content: right;
        }

        .encabezado {
            margin-top: 5px;
            float: left;
            width: 100%;
            padding: 0 2px 0 0;
            margin-right: 1%;
            text-align: left;
            background-color: white;
            font-size: 10px;
        }

        .campo {
            float: left;
            margin-right: 3px;
            font-size: 9px;

        }

        .registro {
            float: left;
            width: 100%;
            padding: 0 2px 0 0;
            margin-right: 1%;
            text-align: left;
            background-color: white;
        }

        .secciones {
            width: 80%;
            font-size: 11px;
            text-align: center;
            margin-left: 16%;
            background-color: black;
        }

        .rsecciones {
            width: 34%;
            float: left;
        }

        .TodosLosRecuadros {
            width: 100%;
            background-color: black;
            font-family: Tahoma, Verdana, Segoe, sans-serif;
            font-size: 10px;
            text-align: right
        }

        .Recuadros {
            width: 10%;
            float: left;
            display: block;
            margin-left: 5px;
            margin-right: 5px;
        }

        .TituloR {
            background-color: gray;
        }

        .pie {}
    </style>

    <body>
        <button type='submit' class='ocultoimpresion ' onclick='window.print();'><img src='/img/pdf.png' width='28' height='28'><br>PDF</button>
        <button class='ocultoimpresion ' onclick='document.getElementById(`formexcel`).submit()'><img src='/img/excel.png' width='28' height='28'><br>ListaPrecios<br></button>
        <div class="pagina" style="font-size: 12px;">
            <div class="sup">
                <div style="float:left; width: 23%;">
                    <div class="TituloEmpresa" id="Titulo"><?php echo $_POST["NameCompany"]; ?></div>
                    <div class="Subtituloempresa" id="Ubicacion"><?php echo $_POST["direccion"]; ?></div>
                    <div class="Subtituloempresa" id="Literal Fiscal"><?php echo $_POST["litfiscal"]; ?>-<?php echo $_POST["rute"]; ?></div>
                </div>
                <div style="float:left; width: 53%;">
                    <div class="TituloEmpresa" style="float: center; text-align: center;"><?php echo lang("Lista de Precios"); ?></div>
                    <div class="TituloEmpresa" style="float: center; text-align: center;"><?php echo lang("Agrupado por Marcas"); ?></div>
                    <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php echo lang("Fecha"); ?>:<?php echo $_POST["FechaHastalista"]; ?> </div>
                    <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php echo lang("Orden por"); ?>:
                        <?php
                        echo $_POST["OrdenLP"];
                        if ($_POST["CodigoDesdeLP"] == true) {
                            echo " / " . lang("Desde el Producto:") . $_POST["CodigoDesdeLP"];
                        }
                        if ($_POST["CodigoHastaLP"] == true) {
                            echo "al " . $_POST["CodigoHastaLP"];
                        }
                        ?>
                    </div>
                    <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                        <?php
                        if ($_POST["Instancia2LP"] == true) {
                            echo "De la Familia: / " . $_POST["Instancia2LP"];
                        }
                        ?>
                    </div>
                    <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                        <?php
                        if ($_POST["Proevedor2LP"] == true or $_POST["MarcaLPUTA2"] == true or $_POST["Deposito2LP"] == true) {
                            echo "Con:";
                        } else {
                            echo "--------------------";
                        } ?>
                        <?php
                        if ($_POST["Proevedor2LP"] == true) {
                            echo lang("Beneficiario") . ":/" . $_POST["Proevedor2LP"];
                        }
                        if ($_POST["MarcaLPUTA2"] == true) {
                            echo " / " . lang("Marca") . ":" . $_POST["MarcaLPUTA2"];
                        }
                        if ($_POST["Deposito2LP"] == true) {
                            echo " / " . lang("Almacen:") . $_POST["Deposito2LP"];
                        }
                        ?>
                    </div>
                    <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                        <?php
                        if ($_POST["ExistenciaCero"] == "on") {
                            echo lang("Incluyendo:");
                        } else {
                            echo "--------------------";
                        }
                        if ($_POST["ExistenciaCero"] == "on") {
                            echo " / " . lang("Existencia Cero");
                        }
                        ?>
                    </div>
                    <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                        <?php
                        if ($_POST["precioz"] == "on" or $_POST["precio2z"] == "on" or $_POST["precio3z"] == "on" or $_POST["precio4z"] == "on" or $_POST["precio5z"] == "on"  or $_POST["precio6z"] == "on" or $_POST["precio7z"] == "on" or $_POST["precio8z"] == "on" or $_POST["precio9z"] == "on" or $_POST["precio10z"] == "on") {
                            echo lang("Precio") . ' ';
                            if ($_POST['cimp'] == true) {
                                echo lang("Con Impuesto");
                            } else {
                                echo lang("Sin Impuesto");
                            }
                        }
                        ?>
                    </div>
                </div>
                <div style="float:left; width: 23%;">
                    <div class="FechaI"><span id="fectx"><?php echo $_POST["fectx5"]; ?></span></div><br>
                    <div class="FechaI">
                        <div class="page"></div>
                    </div><br>
                    <div class="FechaI"><img style="width: 30%;" src="img/AZUL.svg" /></div><br><br>
                    <div class="FechaI">-</div>
                </div>
            </div>
            <?php
            $conn = conectar();
            //---------------------------------------------------------------------------------------------------------------------------

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
                        $npix2 = $npix2 + 12; ?>
                        <div style="text-align: left; float:left; width: 100%;">
                            <div class="campo" style=" text-align: left; width: 36%;  font-weight:1400; font-size: 14px; "><strong> <?php echo $MarAct;  ?> </strong> </div>


                        </div>
                        <div class="encabezado">
                            <div class="campo" style=" text-align: left; width: 12%; background-color: gray;"><?php echo lang("S.K.U"); ?></div>
                            <div class="campo" style=" text-align: left; width: 22%; background-color: gray;"><?php echo lang("Descripción"); ?></div>
                            <?php

                            if ($_POST["MostrarFamilias"] === "on") {
                            ?>
                                <div class="campo" style=" text-align: left; width: 6%; background-color: gray;"><?php echo lang("Familia"); ?></div>

                            <?php
                            }
                            if ($_POST["Existencia"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: 6%; background-color: gray;"><?php echo lang("Existencia"); ?></div>
                                <div class="campo" style=" text-align: right; width: 7.5%; background-color: gray;"><?php echo lang("Desglose"); ?> </div>
                            <?php }
                            if ($_POST["costozzzv"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitCosto) !== "" ? $LitCosto : lang("Costo")); ?></div>
                            <?php
                            }
                            if ($_POST["precioz"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP01) !== "" ? $LitP01 : lang("Precio") . " 1"); ?></div>
                            <?php
                            } ?>
                            <?php if ($_POST["precio2z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP02) !== "" ? $LitP02 : lang("Precio") . " 2"); ?></div>
                            <?php
                            } ?>
                            <?php if ($_POST["precio3z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP03) !== "" ? $LitP03 : lang("Precio") . " 3"); ?></div>
                            <?php
                            } ?>

                            <?php if ($_POST["precio4z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP04) !== "" ? $LitP04 : lang("Precio") . " 4"); ?> </div>
                            <?php
                            }  ?>

                            <?php if ($_POST["precio5z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP05) !== "" ? $LitP05 : lang("Precio") . " 5"); ?> </div>
                            <?php
                            }  ?>

                            <?php if ($_POST["precio6z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP06) !== "" ? $LitP06 : lang("Precio") . " 6"); ?> </div>
                            <?php
                            }  ?>

                            <?php if ($_POST["precio7z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP07) !== "" ? $LitP07 : lang("Precio") . " 7"); ?> </div>
                            <?php
                            }  ?>

                            <?php if ($_POST["precio8z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP08) !== "" ? $LitP08 : lang("Precio") . " 8"); ?> </div>
                            <?php
                            }  ?>

                            <?php if ($_POST["precio9z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP09) !== "" ? $LitP09 : lang("Precio") . " 9"); ?> </div>
                            <?php
                            }  ?>

                            <?php if ($_POST["precio10z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP10) !== "" ? $LitP10 : lang("Precio") . " 10"); ?> </div>
                            <?php
                            }  ?>
                            <?php if ($_POST['cimp'] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: 2%; background-color: gray;">%<?php echo lang("Imp"); ?></div>
                            <?php
                            } ?>
                        </div>
                    <?php $n = $n + 2;
                    }
                    if ($MarAct <> $MarAct2 and $npi2 >= 1) {
                        $nas = 0;
                        $nel = 0;
                        $nop = 0;
                    ?>
                        <div class="encabezado">
                            <div class="campo" style="visibility:hidden; text-align: left; width: 12%; background-color: gray;">Código Barra</div>
                            <div class="campo" style="visibility:hidden; text-align: left; width: 22%; background-color: gray;">S.K.U</div>
                            <div class="campo" style="visibility:hidden; text-align: left; width: 6%; background-color: gray;">Descripción</div>
                            <?php if ($_POST["precioz"] == "on" or $_POST["precio2z"] == "on" or $_POST["precio3z"] == "on" or $_POST["precio4z"] == "on" or $_POST["precio5z"] == "on"  or $_POST["precio6z"] == "on" or $_POST["precio7z"] == "on" or $_POST["precio8z"] == "on" or $_POST["precio9z"] == "on" or $_POST["precio10z"] == "on" or $_POST["Existencia"] == "on") {
                            ?>
                                <!-- <div class="campo" style=" text-align: left; width: 6%; background-color: gray;"><?php echo lang("Total por Grupo"); ?> </div> -->
                                <!-- <div class="campo" style="visibility:hidden; text-align: right; width: 6%; background-color: gray;">UND </div> -->
                            <?php
                            } ?>
                            <?php if ($_POST["Existencia"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: 6%; background-color: gray;"> <?php echo  number_format($existenciaX, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></div>
                                <div class="campo" style="visibility:hidden; text-align: right; width: 7.5%; background-color: gray;">UND </div>
                            <?php }
                            if ($_POST["costozzzv"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($CostoXexistT, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?></div>
                            <?php
                            }
                            if ($_POST["precioz"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                            } ?>
                            <?php if ($_POST["precio2z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"> <?php echo  number_format($precioT2, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?></div>
                            <?php
                            } ?>
                            <?php if ($_POST["precio3z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT3, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                            }
                            if ($_POST["precio4z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT4, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                            }
                            if ($_POST["precio5z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT5, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                            }
                            if ($_POST["precio6z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT6, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                            }
                            if ($_POST["precio7z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT7, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                            }
                            if ($_POST["precio8z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT8, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                            }
                            if ($_POST["precio9z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT9, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                            }
                            if ($_POST["precio10z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT10, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                            }
                            ?>
                        </div>

                        <?php
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

                        <div class="campo" style="text-align: left; float:left; width: 100%;">
                            <div class="campo" style=" text-align: left; width: 36%;  font-weight:1400; font-size: 14px; "><strong> <?php echo $MarAct;  ?> </strong> </div>
                        </div>
                        <div style="text-align: left; float:left; width: 100%;">
                            <div class="campo" style=" text-align: left; width: 12%; background-color: gray;"><?php echo lang("S.K.U"); ?></div>
                            <div class="campo" style=" text-align: left; width: 22%; background-color: gray;"><?php echo lang("Descripción"); ?></div>
                            <?php

                            if ($_POST["MostrarFamilias"] === "on") {
                            ?>
                                <div class="campo" style=" text-align: left; width: 6%; background-color: gray;"><?php echo lang("Familia"); ?></div>

                            <?php
                            }
                            if ($_POST["Existencia"] == "on") {
                            ?>
                                <!-- <div class="campo" style=" text-align: left; width: 8%; background-color: gray;"><?php echo lang("Referencia"); ?> </div> -->
                                <div class="campo" style=" text-align: right; width: 6%; background-color: gray;"><?php echo lang("Existencia"); ?> </div>
                                <div class="campo" style=" text-align: right; width: 7.5%; background-color: gray;"><?php echo lang("Desglose"); ?> </div>
                            <?php }
                            if ($_POST["costozzzv"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitCosto) !== "" ? $LitCosto : lang("Costo")); ?></div>
                            <?php
                            }
                            if ($_POST["precioz"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP01) !== "" ? $LitP01 : lang("Precio") . " 1"); ?></div>
                            <?php
                            } ?>
                            <?php if ($_POST["precio2z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP02) !== "" ? $LitP02 : lang("Precio") . " 2"); ?></div>
                            <?php
                            } ?>
                            <?php if ($_POST["precio3z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP03) !== "" ? $LitP03 : lang("Precio") . " 3"); ?></div>
                            <?php
                            } ?>

                            <?php if ($_POST["precio4z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP04) !== "" ? $LitP04 : lang("Precio") . " 4"); ?> </div>
                            <?php
                            }  ?>

                            <?php if ($_POST["precio5z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP05) !== "" ? $LitP05 : lang("Precio") . " 5"); ?> </div>
                            <?php
                            }  ?>

                            <?php if ($_POST["precio6z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP06) !== "" ? $LitP06 : lang("Precio") . " 6"); ?> </div>
                            <?php
                            }  ?>

                            <?php if ($_POST["precio7z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP07) !== "" ? $LitP07 : lang("Precio") . " 7"); ?> </div>
                            <?php
                            }  ?>

                            <?php if ($_POST["precio8z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP08) !== "" ? $LitP08 : lang("Precio") . " 8"); ?> </div>
                            <?php
                            }  ?>

                            <?php if ($_POST["precio9z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP09) !== "" ? $LitP09 : lang("Precio") . " 9"); ?> </div>
                            <?php
                            }  ?>

                            <?php if ($_POST["precio10z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP10) !== "" ? $LitP10 : lang("Precio") . " 10"); ?> </div>
                            <?php
                            }  ?>
                            <?php if ($_POST['cimp'] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: 2%; background-color: gray;">%<?php echo lang("Imp"); ?></div>
                            <?php
                            } ?>
                        </div>

                    <?php $n = $n + 2;
                    }

                    ?>

                    <div style="text-align: left; float:left; width: 100%;">

                        <div class="campo" style=" text-align: left; width: 12%; text-wrap: wrap; white-space: normal !important;">
                            <?php
                            if (trim($row['CodIdAmpliado']) == "") {
                                echo "-";
                            } else {
                                echo trim($row['CodIdAmpliado']);
                            }
                            ?>
                        </div>
                        <div class="campo" style=" text-align: left; width: 22%; text-wrap: wrap; white-space: normal !important;">
                            <?php
                            if (trim($row['Descripcion']) == "") {
                                echo "-";
                            } else {
                                echo trim($row['Descripcion']);
                            }
                            // if ($row['Envase'] == "" or $row['Envase'] == "0") {
                            //     echo "";
                            // } else {
                            //     echo "<br>"; // ; 
                            //     $explode = explode("|", $row['Envase']);
                            //     foreach ($explode as $val) {
                            //         if (trim($val) <> '') {
                            //             echo "<span style='background:#EAEAEA;'>" . $val . "</span>&nbsp; ";
                            //         }
                            //         # code...
                            //     }
                            // }
                            $explode = '';
                            ?>
                        </div>
                        <?php
                        if ($_POST["MostrarFamilias"] === "on") {
                        ?>
                            <div class="campo" style=" text-align: left; width: 6%; ">
                                <?php
                                if (trim($row['Familia']) === "") {
                                    echo "-";
                                } else {
                                    echo trim($row['Familia']);
                                }
                                ?>
                            </div>

                        <?php
                        }
                        if ($_POST["Existencia"] == "on") {
                        ?>
                            <!-- <div class="campo" style="text-align: left; width: 6%  <?php echo ($color == 0 ? "" : "background: #EDECEC;"); ?>">
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
                                } ?>) </div> -->
                            <div class="campo" style=" text-align: right; width: 6%; ">
                                <?php

                                if ($row['Existencia'] == "") {
                                    echo "-";
                                } else {
                                    echo ($row["factorunit"] <> 1 && $row["factorunit"] <> 0 ? " " . $row["factorunit"] . " x " . getcantformat($row["Existencia"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " = " . getcantformat($row["Existencia"] * $row["factorunit"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $row["Medida"] : number_format($row['Existencia'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]));
                                }
                                ?>
                            </div>
                            <div class="campo" style=" text-align: right; width: 7.5%; ">&nbsp;
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
                            </div>
                        <?php
                        }
                        if ($_POST["costozzzv"] == "on") {
                        ?>
                            <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; ">
                                <?php
                                if (trim($row['costo']) === "") {
                                    echo "-";
                                } else {
                                    echo number_format(trim($row['costo']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;;
                                }
                                ?>
                            </div>
                        <?php
                        }
                        if ($_POST["precioz"] == "on") {
                        ?>
                            <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; ">
                                <?php
                                if (trim($row['PrecioNeto']) === "") {
                                    echo "-";
                                } else {
                                    echo number_format(trim($row['PrecioNeto']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;;
                                }
                                ?>
                            </div>
                        <?php
                        } ?>
                        <?php if ($_POST["precio2z"] == "on") {
                        ?>
                            <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; ">
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
                            </div>
                        <?php
                        } ?>
                        <?php if ($_POST["precio3z"] == "on") {
                        ?>
                            <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; ">
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
                            </div>
                        <?php
                        }
                        if ($_POST["precio4z"] == "on") {
                        ?>
                            <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; ">
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
                            </div>
                        <?php
                        }

                        if ($_POST["precio5z"] == "on") {
                        ?>
                            <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; ">
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
                            </div>
                        <?php
                        }

                        if ($_POST["precio6z"] == "on") {
                        ?>
                            <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; ">
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
                            </div>
                        <?php
                        }

                        if ($_POST["precio7z"] == "on") {
                        ?>
                            <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; ">
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
                            </div>
                        <?php
                        }

                        if ($_POST["precio8z"] == "on") {
                        ?>
                            <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; ">
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
                            </div>
                        <?php
                        }

                        if ($_POST["precio9z"] == "on") {
                        ?>
                            <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; ">
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
                            </div>
                        <?php
                        }

                        if ($_POST["precio10z"] == "on") {
                        ?>
                            <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; ">
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
                            </div>
                        <?php
                        }
                        if ($_POST['cimp'] == "on") {
                        ?>
                            <div class="campo" style=" text-align: right; width: 2%; ">
                                <?php
                                if (trim($row['ValorImpuesto']) == "") {
                                    echo "-";
                                } else {
                                    echo trim($row['ValorImpuesto']);
                                }
                                ?>
                            </div>
                        <?php
                        } ?>

                    </div>
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


                    if ($n >= 50) {     ?>
                        <div class="encabezado" style="">
                            <div class="campo" style="visibility:hidden; text-align: left; width: 12%; background-color: gray;">Código Barra</div>
                            <div class="campo" style="visibility:hidden; text-align: left; width: 22%; background-color: gray;">S.K.U</div>
                            <div class="campo" style="visibility:hidden; text-align: left; width: 6%; background-color: gray;">Descripción</div>
                            <?php if ($_POST["precioz"] == "on" or $_POST["precio2z"] == "on" or $_POST["precio3z"] == "on" or $_POST["precio4z"] == "on" or $_POST["precio5z"] == "on"  or $_POST["precio6z"] == "on" or $_POST["precio7z"] == "on" or $_POST["precio8z"] == "on" or $_POST["precio9z"] == "on" or $_POST["precio10z"] == "on" or $_POST["Existencia"] == "on") {
                            ?>
                                <!-- <div class="campo" style=" text-align: left; width: 8%; background-color: gray;"><?php echo lang("Total por Grupo"); ?> </div> -->
                                <!-- <div class="campo" style="visibility:hidden; text-align: right; width: 6%; background-color: gray;">UND </div> -->
                            <?php
                            } ?>
                            <?php if ($_POST["Existencia"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: 6%; background-color: gray;"> <?php echo  number_format($existenciaX, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></div>
                                <div class="campo" style="visibility:hidden; text-align: right; width: 7.5%; background-color: gray;">UND </div>
                            <?php }
                            if ($_POST["costozzzv"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($CostoXexistT, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?></div>
                            <?php
                            }
                            if ($_POST["precioz"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                            } ?>
                            <?php if ($_POST["precio2z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"> <?php echo  number_format($precioT2, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?></div>
                            <?php
                            } ?>
                            <?php if ($_POST["precio3z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT3, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                            }
                            if ($_POST["precio4z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT4, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                            }
                            if ($_POST["precio5z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT5, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                            }
                            if ($_POST["precio6z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT6, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                            }
                            if ($_POST["precio7z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT7, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                            }
                            if ($_POST["precio8z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT8, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                            }
                            if ($_POST["precio9z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT9, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                            }
                            if ($_POST["precio10z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT10, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                            } ?>
                        </div>

                        <?php
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
                        <div style="PAGE-BREAK-AFTER: always"></div>
                        <div class="campo" style="visibility:hidden; text-align: right; width: 6%; "><?php echo number_format($PrecioTotal, 2); ?>.</div>
                        <div style="text-align: left; float:left; width: 100%;">
                            <div class="sup">
                                <div style="float:left; width: 23%;">
                                    <div class="TituloEmpresa" id="Titulo"><?php echo $_POST["NameCompany"]; ?></div>
                                    <div class="Subtituloempresa" id="Ubicacion"><?php echo $_POST["direccion"]; ?></div>
                                    <div class="Subtituloempresa" id="Literal Fiscal"><?php echo $_POST["litfiscal"]; ?>-<?php echo $_POST["rute"]; ?></div>
                                </div>


                                <div style="float:left; width: 53%;">
                                    <div class="TituloEmpresa" style="float: center; text-align: center;"><?php echo lang("Lista de Precios"); ?></div>
                                    <div class="TituloEmpresa" style="float: center; text-align: center;"><?php echo lang("Agrupado por Marcas"); ?></div>
                                    <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php echo lang("Fecha"); ?>:<?php echo $_POST["FechaHastalista"]; ?> </div>
                                    <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php echo lang("Orden por"); ?>:<?php echo $_POST["OrdenLP"];
                                                                                                                                                                                    if ($_POST["CodigoDesdeLP"] == true) {
                                                                                                                                                                                        echo " / " . lang("Desde el Producto:") . $_POST["CodigoDesdeLP"];
                                                                                                                                                                                    }
                                                                                                                                                                                    if ($_POST["CodigoHastaLP"] == true) {
                                                                                                                                                                                        echo "al " . $_POST["CodigoHastaLP"];
                                                                                                                                                                                    }
                                                                                                                                                                                    ?>
                                    </div>
                                    <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                                        <?php
                                        if ($_POST["Instancia2LP"] == true) {
                                            echo "De la Familia: / " . $_POST["Instancia2LP"];
                                        }
                                        ?>
                                    </div>
                                    <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                                        <?php
                                        if ($_POST["Proevedor2LP"] == true or $_POST["MarcaLPUTA2"] == true or $_POST["Deposito2LP"] == true) {
                                            echo "Con:";
                                        } else {
                                            echo "--------------------";
                                        } ?>
                                        <?php
                                        if ($_POST["Proevedor2LP"] == true) {
                                            echo lang("Beneficiario") . ":/" . $_POST["Proevedor2LP"];
                                        }
                                        if ($_POST["MarcaLPUTA2"] == true) {
                                            echo " / " . lang("Marca") . ":" . $_POST["MarcaLPUTA2"];
                                        }
                                        if ($_POST["Deposito2LP"] == true) {
                                            echo " / " . lang("Almacen:") . $_POST["Deposito2LP"];
                                        }
                                        ?>
                                    </div>
                                    <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                                        <?php
                                        if ($_POST["ExistenciaCero"] == "on") {
                                            echo lang("Incluyendo:");
                                        } else {
                                            echo "--------------------";
                                        }
                                        if ($_POST["ExistenciaCero"] == "on") {
                                            echo " / " . lang("Existencia Cero");
                                        }
                                        ?>
                                    </div>
                                    <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                                        <?php
                                        if ($_POST["precioz"] == "on" or $_POST["precio2z"] == "on" or $_POST["precio3z"] == "on" or $_POST["precio4z"] == "on" or $_POST["precio5z"] == "on"  or $_POST["precio6z"] == "on" or $_POST["precio7z"] == "on" or $_POST["precio8z"] == "on" or $_POST["precio9z"] == "on" or $_POST["precio10z"] == "on") {
                                            echo lang("Precio") . ' ';
                                            if ($_POST['cimp'] == true) {
                                                echo lang("Con Impuesto");
                                            } else {
                                                echo lang("Sin Impuesto");
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>

                                <div style="float:left; width: 23%;">
                                    <div class="FechaI"><span id="fectx"><?php echo $_POST["fectx5"]; ?></span></div><br>
                                    <div class="FechaI">
                                        <div class="page"></div>
                                    </div><br>
                                    <div class="FechaI"><img style="width: 30%;" src="img/AZUL.svg" /></div><br><br>
                                    <div class="FechaI">-</div>
                                </div>
                            </div>
                        </div>

                        <div style="text-align: left; float:left; width: 100%;">
                            <div class="campo" style=" text-align: left; width: 36%;  font-weight:1400; font-size: 14px; "><strong> <?php echo $MarAct;  ?> </strong> </div>
                        </div>
                        <div style="text-align: left; float:left; width: 100%;">
                            <!-- <div class="campo" style=" text-align: left; width: 8%; background-color: gray;"><?php echo lang("Código Barra"); ?></div> -->
                            <div class="campo" style=" text-align: left; width: 12%; background-color: gray;"><?php echo lang("S.K.U"); ?></div>
                            <div class="campo" style=" text-align: left; width: 22%; background-color: gray;"><?php echo lang("Descripción"); ?></div>
                            <?php
                            if ($_POST["MostrarFamilias"] === "on") {
                            ?>
                                <div class="campo" style=" text-align: left; width: 6%; background-color: gray;"><?php echo lang("Familia"); ?></div>

                            <?php
                            }
                            ?>
                            <?php if ($_POST["Existencia"] == "on") {
                            ?>
                                <!-- <div class="campo" style=" text-align: left; width: 8%; background-color: gray;"><?php echo lang("Referencia"); ?> </div> -->
                                <div class="campo" style=" text-align: right; width: 6%; background-color: gray;"><?php echo lang("Existencia"); ?> </div>
                                <div class="campo" style=" text-align: right; width: 7.5%; background-color: gray;"><?php echo lang("Desglose"); ?> </div>
                            <?php }
                            if ($_POST["costozzzv"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitCosto) !== "" ? $LitCosto : lang("Costo")); ?></div>
                            <?php
                            }
                            if ($_POST["precioz"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP01) !== "" ? $LitP01 : lang("Precio") . " 1"); ?></div>
                            <?php
                            } ?>
                            <?php if ($_POST["precio2z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP02) !== "" ? $LitP02 : lang("Precio") . " 2"); ?></div>
                            <?php
                            } ?>
                            <?php if ($_POST["precio3z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP03) !== "" ? $LitP03 : lang("Precio") . " 3"); ?></div>
                            <?php
                            } ?>

                            <?php if ($_POST["precio4z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP04) !== "" ? $LitP04 : lang("Precio") . " 4"); ?> </div>
                            <?php
                            }  ?>

                            <?php if ($_POST["precio5z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP05) !== "" ? $LitP05 : lang("Precio") . " 5"); ?> </div>
                            <?php
                            }  ?>

                            <?php if ($_POST["precio6z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP06) !== "" ? $LitP06 : lang("Precio") . " 6"); ?> </div>
                            <?php
                            }  ?>

                            <?php if ($_POST["precio7z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP07) !== "" ? $LitP07 : lang("Precio") . " 7"); ?> </div>
                            <?php
                            }  ?>

                            <?php if ($_POST["precio8z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP08) !== "" ? $LitP08 : lang("Precio") . " 8"); ?> </div>
                            <?php
                            }  ?>

                            <?php if ($_POST["precio9z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP09) !== "" ? $LitP09 : lang("Precio") . " 9"); ?> </div>
                            <?php
                            }  ?>

                            <?php if ($_POST["precio10z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP10) !== "" ? $LitP10 : lang("Precio") . " 10"); ?> </div>
                            <?php
                            }  ?>
                            <?php if ($_POST['cimp'] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: 2%; background-color: gray;">%Imp</div>
                            <?php
                            } ?>
                        </div>
            <?php
                        $n = 0;
                        $npa = 0;
                    }
                    $npi2 = $npi2 + 1;
                    $MarAct2 = trim($row['Marca']);
                }
                mysqli_free_result($result);
            }
            $UltimoRegistro = $row["CodIdBasico"];
            ?>
            <div class="encabezado" style="">
                <div class="campo" style="visibility:hidden; text-align: left; width: 12%; background-color: gray;">Código Barra</div>
                <div class="campo" style="visibility:hidden; text-align: left; width: 22%; background-color: gray;">S.K.U</div>
                <div class="campo" style="visibility:hidden; text-align: left; width: 6%; background-color: gray;">Descripción</div>
                <?php if ($_POST["precioz"] == "on" or $_POST["precio2z"] == "on" or $_POST["precio3z"] == "on" or $_POST["precio4z"] == "on" or $_POST["precio5z"] == "on"  or $_POST["precio6z"] == "on" or $_POST["precio7z"] == "on" or $_POST["precio8z"] == "on" or $_POST["precio9z"] == "on" or $_POST["precio10z"] == "on" or $_POST["Existencia"] == "on") {
                ?>
                    <!-- <div class="campo" style=" text-align: left; width: 8%; background-color: gray;"><?php echo lang("Total  Grupo"); ?> </div> -->
                    <!-- <div class="campo" style="visibility:hidden; text-align: right; width: 6%; background-color: gray;">UND </div> -->
                <?php
                } ?>
                <?php if ($_POST["Existencia"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: 6%; background-color: gray;"> <?php echo  number_format($existenciaX, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></div>
                    <div class="campo" style="visibility:hidden; text-align: right; width: 7.5%; background-color: gray;">UND </div>
                <?php }
                if ($_POST["costozzzv"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($CostoXexistT, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?></div>
                <?php
                }
                if ($_POST["precioz"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                <?php
                } ?>
                <?php if ($_POST["precio2z"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"> <?php echo  number_format($precioT2, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?></div>
                <?php
                } ?>
                <?php if ($_POST["precio3z"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT3, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                <?php
                }
                if ($_POST["precio4z"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT4, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                <?php
                }
                if ($_POST["precio5z"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT5, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                <?php
                }
                if ($_POST["precio6z"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT6, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                <?php
                }
                if ($_POST["precio7z"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT7, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                <?php
                }
                if ($_POST["precio8z"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT8, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                <?php
                }
                if ($_POST["precio9z"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT9, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                <?php
                }
                if ($_POST["precio10z"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT10, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                <?php
                } ?>
            </div>



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



<?php

} else {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta http-equiv="Expires" content="0">
        <meta http-equiv="Last-Modified" content="0">
        <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
        <meta http-equiv="Pragma" content="no-cache">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Hugo 0.82.0">
        <title><?php echo lang("Lista de Precios"); ?></title>
        <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css"> -->
        <link rel="shortcut icon" href="img/AZUL.png" type="image/x-icon">
        <link rel="icon" href="img/ISO AZUL.svg" sizes="32x32" type="image/png">
        <link rel="apple-touch-icon" href="img/ISO AZUL.svg" sizes="180x180">
        <link rel="icon" href="img/ISO AZUL.svg" sizes="16x16" type="image/png">
        <link rel="icon" href="img/ISO AZUL.svg">
    </head>

    <style>
        @media print {
            .ocultoimpresion {
                display: none !important;
            }

            @page {
                margin: 0;
                size: landscape;
            }

            .saltopagina {
                display: block;
                page-break-before: always;
            }

        }

        :root {
            --total-pages: 0;
        }

        .page {}

        body {
            counter-reset: page-counter 0 total-pages var(--total-pages);
            font-family: Tahoma, Verdana, Segoe, sans-serif;
            line-height: 1;
            margin: 5mm 5mm 5mm 5mm;
        }

        .pagina {}

        .sup {
            float: left;
            width: 100%;
        }

        .TituloEmpresa {
            font-weight: 600;
            font-size: 16.4px;
            text-align: left;
        }

        .Subtituloempresa {
            font-size: 9.3px;
            text-align: left;
        }

        .FechaI {
            font-size: 10px;
            text-align: right;
            float: right;

        }

        .page::before {
            counter-increment: page-counter 1;
            font-size: 10px;


            content: "Pagina " counter(page-counter) " de " counter(total-pages);
            align-content: right;
        }

        .encabezado {
            margin-top: 5px;
            float: left;
            width: 100%;
            padding: 0 2px 0 0;
            margin-right: 1%;
            text-align: left;
            background-color: white;
            font-size: 10px;
        }

        .campo {
            float: left;
            margin-right: 3px;
            font-size: 9px;

        }

        .registro {
            float: left;
            width: 100%;
            padding: 0 2px 0 0;
            margin-right: 1%;
            text-align: left;
            background-color: white;
        }

        .secciones {
            width: 80%;
            font-size: 11px;
            text-align: center;
            margin-left: 16%;
            background-color: black;
        }

        .rsecciones {
            width: 34%;
            float: left;
        }

        .TodosLosRecuadros {
            width: 100%;
            background-color: black;
            font-family: Tahoma, Verdana, Segoe, sans-serif;
            font-size: 10px;
            text-align: right
        }

        .Recuadros {
            width: 10%;
            float: left;
            display: block;
            margin-left: 5px;
            margin-right: 5px;
        }

        .TituloR {
            background-color: gray;
        }
    </style>

    <body>
        <button type='submit' class='ocultoimpresion ' onclick='window.print();'><img src='/img/pdf.png' width='28' height='28'><br>PDF</button>
        <button class='ocultoimpresion ' onclick='document.getElementById(`formexcel`).submit()'><img src='/img/excel.png' width='28' height='28'><br>ListaPrecios<br></button>
        <div class="pagina" style="font-size: 12px;">
            <div class="sup">
                <div style="float:left; width: 23%;">
                    <div class="TituloEmpresa" id="Titulo"><?php echo $_POST["NameCompany"]; ?></div>
                    <div class="Subtituloempresa" id="Ubicacion"><?php echo $_POST["direccion"]; ?></div>
                    <div class="Subtituloempresa" id="Literal Fiscal"><?php echo $_POST["litfiscal"]; ?>-<?php echo $_POST["rute"]; ?></div>
                </div>
                <div style="float:left; width: 53%;">
                    <div class="TituloEmpresa" style="float: center; text-align: center;"><?php echo lang("Lista de Precios"); ?></div>
                    <div class="TituloEmpresa" style="float: center; text-align: center;"><?php echo lang("Agrupado por Familias"); ?></div>
                    <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php echo lang("Fecha"); ?>:<?php echo $_POST["FechaHastalista"]; ?> </div>
                    <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php echo lang("Orden por"); ?>:
                        <?php echo $_POST["OrdenLP"];
                        if ($_POST["CodigoDesdeLP"] == true) {
                            echo " / " . lang("Desde el Producto:") . $_POST["CodigoDesdeLP"];
                        }
                        if ($_POST["CodigoHastaLP"] == true) {
                            echo "al " . $_POST["CodigoHastaLP"];
                        }
                        ?>
                    </div>
                    <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                        <?php
                        if ($_POST["Instancia2LP"] == true) {
                            echo "De la Familia: / " . $_POST["Instancia2LP"];
                        }
                        ?>
                    </div>
                    <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                        <?php
                        if ($_POST["Proevedor2LP"] == true or $_POST["MarcaLPUTA2"] == true or $_POST["Deposito2LP"] == true) {
                            echo "Con:";
                        } else {
                            echo "--------------------";
                        } ?>
                        <?php
                        if ($_POST["Proevedor2LP"] == true) {
                            echo lang("Beneficiario") . ":/" . $_POST["Proevedor2LP"];
                        }
                        if ($_POST["MarcaLPUTA2"] == true) {
                            echo " / " . lang("Marca") . ":" . $_POST["MarcaLPUTA2"];
                        }
                        if ($_POST["Deposito2LP"] == true) {
                            echo " / " . lang("Almacen:") . $_POST["Deposito2LP"];
                        }
                        ?>
                    </div>
                    <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                        <?php
                        if ($_POST["ExistenciaCero"] == "on") {
                            echo lang("Incluyendo:");
                        } else {
                            echo "--------------------";
                        }
                        if ($_POST["ExistenciaCero"] == "on") {
                            echo " / " . lang("Existencia Cero");
                        }
                        ?>
                    </div>
                    <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                        <?php
                        if ($_POST["precioz"] == "on" or $_POST["precio2z"] == "on" or $_POST["precio3z"] == "on" or $_POST["precio4z"] == "on" or $_POST["precio5z"] == "on"  or $_POST["precio6z"] == "on" or $_POST["precio7z"] == "on" or $_POST["precio8z"] == "on" or $_POST["precio9z"] == "on" or $_POST["precio10z"] == "on") {
                            echo lang("Precio") . ' ';
                            if ($_POST['cimp'] == true) {
                                echo lang("Con Impuesto");
                            } else {
                                echo lang("Sin Impuesto");
                            }
                        }
                        ?>
                    </div>
                </div>
                <div style="float:left; width: 23%;">
                    <div class="FechaI"><span id="fectx"><?php echo $_POST["fectx5"]; ?></span></div><br>
                    <div class="FechaI">
                        <div class="page"></div>
                    </div><br>
                    <div class="FechaI"><img style="width: 30%;" src="img/AZUL.svg" /></div><br><br>
                    <div class="FechaI">-</div>
                </div>
            </div>
            <?php
            $conn = conectar();
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
                $familia = " and a.Idfamilia in ('" . implode("','", $_POST["mIdfamilia"]) . "') ";
            }
            $buscar = "";
            if ($_POST["EnvioEstado"] !== "*") {
                $buscar .= "and a.Estado = " . $_POST["EnvioEstado"];
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
                        <div style="text-align: left; float:left; width: 100%;">

                            <div class="campo" style=" text-align: left; width: 36%;  font-weight:1400; font-size: 14px; "><strong> <?php echo $MarAct;  ?> </strong> </div>
                        </div>
                        <div class="encabezado" style="">
                            <div class="campo" style=" text-align: left; width: 12%; background-color: gray;"><?php echo lang("S.K.U"); ?></div>
                            <div class="campo" style=" text-align: left; width: 22%; background-color: gray;"><?php echo lang("Descripción"); ?></div> <?php
                                                                                                                                                        if ($_POST["MostrarMarcas"] === "on") {
                                                                                                                                                        ?>
                                <div class="campo" style=" text-align: left; width: 6%; background-color: gray;"><?php echo lang("Marca"); ?></div>

                            <?php
                                                                                                                                                        }
                            ?>
                            <?php if ($_POST["Existencia"] == "on") {
                            ?>
                                <!-- <div class="campo" style=" text-align: left; width: 8%; background-color: gray;"><?php echo lang("Referencia"); ?> </div> -->
                                <div class="campo" style=" text-align: right; width: 6%; background-color: gray;"><?php echo lang("Existencia"); ?> </div>
                                <div class="campo" style=" text-align: right; width: 7.5%; background-color: gray;"><?php echo lang("Desglose"); ?> </div>
                            <?php }
                            if ($_POST["costozzzv"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitCosto) !== "" ? $LitCosto : lang("Costo")); ?></div>
                            <?php
                            }
                            if ($_POST["precioz"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP01) !== "" ? $LitP01 : lang("Precio") . " 1"); ?></div>
                            <?php
                            } ?>
                            <?php if ($_POST["precio2z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP02) !== "" ? $LitP02 : lang("Precio") . " 2"); ?></div>
                            <?php
                            } ?>
                            <?php if ($_POST["precio3z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP03) !== "" ? $LitP03 : lang("Precio") . " 3"); ?></div>
                            <?php
                            } ?>

                            <?php if ($_POST["precio4z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP04) !== "" ? $LitP04 : lang("Precio") . " 4"); ?> </div>
                            <?php
                            }  ?>

                            <?php if ($_POST["precio5z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP05) !== "" ? $LitP05 : lang("Precio") . " 5"); ?> </div>
                            <?php
                            }  ?>

                            <?php if ($_POST["precio6z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP06) !== "" ? $LitP06 : lang("Precio") . " 6"); ?> </div>
                            <?php
                            }  ?>

                            <?php if ($_POST["precio7z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP07) !== "" ? $LitP07 : lang("Precio") . " 7"); ?> </div>
                            <?php
                            }  ?>

                            <?php if ($_POST["precio8z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP08) !== "" ? $LitP08 : lang("Precio") . " 8"); ?> </div>
                            <?php
                            }  ?>

                            <?php if ($_POST["precio9z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP09) !== "" ? $LitP09 : lang("Precio") . " 9"); ?> </div>
                            <?php
                            }  ?>

                            <?php if ($_POST["precio10z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP10) !== "" ? $LitP10 : lang("Precio") . " 10"); ?> </div>
                            <?php
                            }  ?>
                            <?php if ($_POST['cimp'] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: 2%; background-color: gray;">%Imp</div>
                            <?php
                            } ?>
                        </div>
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
                        <div class="encabezado">

                            <div class="campo" style=" visibility:hidden;text-align: left; width: 12%; background-color: gray;"><?php echo lang("S.K.U"); ?></div>
                            <div class="campo" style=" visibility:hidden;text-align: left; width: 22%; background-color: gray;"><?php echo lang("Descripción"); ?></div> <?php
                                                                                                                                                                            if ($_POST["MostrarMarcas"] === "on") {
                                                                                                                                                                            ?>
                                <div class="campo" style=" text-align: left; width: 6%; background-color: gray;"><?php echo lang("Marca"); ?></div>

                            <?php
                                                                                                                                                                            }
                            ?>
                            <?php if ($_POST["precioz"] == "on" or $_POST["precio2z"] == "on" or $_POST["precio3z"] == "on" or $_POST["precio4z"] == "on" or $_POST["precio5z"] == "on"  or $_POST["precio6z"] == "on" or $_POST["precio7z"] == "on" or $_POST["precio8z"] == "on" or $_POST["precio9z"] == "on" or $_POST["precio10z"] == "on" or $_POST["Existencia"] == "on") {
                            ?>
                                <!-- <div class="campo" style=" text-align: left; width: 8%; background-color: gray;"><?php echo lang("Total por Grupo"); ?> </div> -->
                            <?php
                            } ?>
                            <?php if ($_POST["Existencia"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: 6%; background-color: gray;"> <?php echo  number_format($existenciaX, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></div>
                                <div class="campo" style="visibility:hidden; text-align: right; width: 7.5%; background-color: gray;">UND </div>
                            <?php }
                            if ($_POST["costozzzv"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($CostoXexistT, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?></div>
                            <?php
                            }
                            if ($_POST["precioz"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                            } ?>
                            <?php if ($_POST["precio2z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"> <?php echo  number_format($precioT2, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?></div>
                            <?php
                            } ?>
                            <?php if ($_POST["precio3z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT3, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                            }
                            if ($_POST["precio4z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT4, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                            }
                            if ($_POST["precio5z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT5, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                            }
                            if ($_POST["precio6z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT6, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                            }
                            if ($_POST["precio7z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT7, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                            }
                            if ($_POST["precio8z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT8, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                            }
                            if ($_POST["precio9z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT9, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                            }
                            if ($_POST["precio10z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT10, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                            } ?>
                        </div>

                        <?php
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
                        <div style="text-align: left; float:left; width: 100%;">
                            <div class="campo" style=" text-align: left; width: 36%;  font-weight:1400; font-size: 14px; "><strong> <?php echo $MarAct;  ?> </strong> </div>
                        </div>

                        <div class="encabezado" style="">
                            <div class="campo" style=" text-align: left; width: 12%; background-color: gray;"><?php echo lang("S.K.U"); ?></div>
                            <div class="campo" style=" text-align: left; width: 22%; background-color: gray;"><?php echo lang("Descripción"); ?></div> <?php
                                                                                                                                                        if ($_POST["MostrarMarcas"] === "on") {
                                                                                                                                                        ?>
                                <div class="campo" style=" text-align: left; width: 6%; background-color: gray;"><?php echo lang("Marca"); ?></div>

                            <?php
                                                                                                                                                        }
                            ?>
                            <?php if ($_POST["Existencia"] == "on") {
                            ?>
                                <!-- <div class="campo" style=" text-align: left; width: 6%; background-color: gray;"><?php echo lang("Referencia"); ?> </div> -->
                                <div class="campo" style=" text-align: right; width: 6%; background-color: gray;"><?php echo lang("Existencia"); ?> </div>
                                <div class="campo" style=" text-align: right; width: 7.5%; background-color: gray;"><?php echo lang("Desglose"); ?> </div>
                            <?php }
                            if ($_POST["costozzzv"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitCosto) !== "" ? $LitCosto : lang("Costo")); ?></div>
                            <?php
                            }
                            if ($_POST["precioz"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP01) !== "" ? $LitP01 : lang("Precio") . " 1"); ?></div>
                            <?php
                            } ?>
                            <?php if ($_POST["precio2z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP02) !== "" ? $LitP02 : lang("Precio") . " 2"); ?></div>
                            <?php
                            } ?>
                            <?php if ($_POST["precio3z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP03) !== "" ? $LitP03 : lang("Precio") . " 3"); ?></div>
                            <?php
                            } ?>

                            <?php if ($_POST["precio4z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP04) !== "" ? $LitP04 : lang("Precio") . " 4"); ?> </div>
                            <?php
                            }  ?>

                            <?php if ($_POST["precio5z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP05) !== "" ? $LitP05 : lang("Precio") . " 5"); ?> </div>
                            <?php
                            }  ?>

                            <?php if ($_POST["precio6z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP06) !== "" ? $LitP06 : lang("Precio") . " 6"); ?> </div>
                            <?php
                            }  ?>

                            <?php if ($_POST["precio7z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP07) !== "" ? $LitP07 : lang("Precio") . " 7"); ?> </div>
                            <?php
                            }  ?>

                            <?php if ($_POST["precio8z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP08) !== "" ? $LitP08 : lang("Precio") . " 8"); ?> </div>
                            <?php
                            }  ?>

                            <?php if ($_POST["precio9z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP09) !== "" ? $LitP09 : lang("Precio") . " 9"); ?> </div>
                            <?php
                            }  ?>

                            <?php if ($_POST["precio10z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP10) !== "" ? $LitP10 : lang("Precio") . " 10"); ?> </div>
                            <?php
                            }  ?>
                            <?php if ($_POST['cimp'] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: 2%; background-color: gray;">%<?php echo lang("Imp"); ?></div>
                            <?php
                            } ?>
                        </div>
                    <?php $n = $n + 1;
                    }
                    ?>

                    <div style="text-align: left; float:left; width: 100%;">

                        <div class="campo" style=" text-align: left; width: 12%; text-wrap: wrap; white-space: normal !important;">
                            <?php
                            if (trim($row['CodIdAmpliado']) === "") {
                                echo "-";
                            } else {
                                echo trim($row['CodIdAmpliado']);
                            }
                            ?>
                        </div>
                        <div class="campo" style=" text-align: left; width: 22%; text-wrap: wrap; white-space: normal !important;">
                            <?php
                            if (trim($row['Descripcion']) === "") {
                                echo "-";
                            } else {
                                echo trim($row['Descripcion']);
                            }
                            // if ($row['Envase'] == "" or $row['Envase'] == "0") {
                            //     echo "";
                            // } else {
                            //     echo "<br>"; // ; 
                            //     $explode = explode("|", $row['Envase']);
                            //     foreach ($explode as $val) {
                            //         if (trim($val) <> '') {
                            //             echo "<span style='background:#EAEAEA;'>" . $val . "</span>&nbsp; ";
                            //         }
                            //         # code...
                            //     }
                            // }
                            $explode = '';
                            ?>
                        </div>
                        <?php
                        if ($_POST["MostrarMarcas"] === "on") {
                        ?>
                            <div class="campo" style=" text-align: left; width: 6%; ">
                                <?php
                                if (trim($row['Marca']) === "") {
                                    echo "-";
                                } else {
                                    echo trim($row['Marca']);
                                }
                                ?>
                            </div>

                        <?php
                        }
                        ?>

                        <?php if ($_POST["Existencia"] == "on") {
                        ?>
                            <!-- <div class="campo" style="text-align: left; width: 8%;  <?php echo ($color == 0 ? "" : "background: #EDECEC;"); ?>">(1
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
                                } ?>) 
                            </div> -->
                            <div class="campo" style=" text-align: right; width: 6%; ">
                                <?php

                                if ($row['Existencia'] == "") {
                                    echo "-";
                                } else {
                                    echo ($row["factorunit"] <> 1 && $row["factorunit"] <> 0 ? " " . $row["factorunit"] . " x " . getcantformat($row["Existencia"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " = " . getcantformat($row["Existencia"] * $row["factorunit"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $row["Medida"] : number_format($row['Existencia'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]));
                                }
                                ?>
                            </div>
                            <div class="campo" style=" text-align: right; width: 7.5%; ">&nbsp;
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
                            </div>
                        <?php
                        }
                        if ($_POST["costozzzv"] == "on") {
                        ?>
                            <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; ">
                                <?php
                                if (trim($row['costo']) == "") {
                                    echo "-";
                                } else {
                                    echo number_format(trim($row['costo']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;
                                }
                                ?>
                            </div>
                        <?php
                        }
                        if ($_POST["precioz"] == "on") {
                        ?>
                            <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; ">
                                <?php
                                if (trim($row['PrecioNeto']) == "") {
                                    echo "-";
                                } else {
                                    echo number_format(trim($row['PrecioNeto']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda;
                                }
                                ?>
                            </div>
                        <?php
                        } ?>
                        <?php if ($_POST["precio2z"] == "on") {
                        ?>
                            <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; ">
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
                            </div>
                        <?php
                        } ?>
                        <?php if ($_POST["precio3z"] == "on") {
                        ?>
                            <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; ">
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
                            </div>
                        <?php
                        }
                        if ($_POST["precio4z"] == "on") {
                        ?>
                            <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; ">
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
                            </div>
                        <?php
                        }

                        if ($_POST["precio5z"] == "on") {
                        ?>
                            <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; ">
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
                            </div>
                        <?php
                        }

                        if ($_POST["precio6z"] == "on") {
                        ?>
                            <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; ">
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
                            </div>
                        <?php
                        }

                        if ($_POST["precio7z"] == "on") {
                        ?>
                            <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; ">
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
                            </div>
                        <?php
                        }

                        if ($_POST["precio8z"] == "on") {
                        ?>
                            <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; ">
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
                            </div>
                        <?php
                        }

                        if ($_POST["precio9z"] == "on") {
                        ?>
                            <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; ">
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
                            </div>
                        <?php
                        }

                        if ($_POST["precio10z"] == "on") {
                        ?>
                            <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; ">
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
                            </div>
                        <?php
                        }
                        if ($_POST['cimp'] == "on") {
                        ?>
                            <div class="campo" style=" text-align: right; width: 2%; ">
                                <?php
                                if (trim($row['ValorImpuesto']) === "") {
                                    echo "-";
                                } else {
                                    echo trim($row['ValorImpuesto']);
                                }
                                ?>
                            </div>
                        <?php
                        } ?>

                    </div>
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
                    if ($n > 54) {



                    ?>
                        <div class="encabezado" style="">

                            <div class="campo" style="visibility:hidden; text-align: left; width: 12%; background-color: gray;">Código Barra</div>
                            <div class="campo" style="visibility:hidden; text-align: left; width: 22%; background-color: gray;">S.K.U</div>
                            <div class="campo" style="visibility:hidden; text-align: left; width: 6%; background-color: gray;">Descripción</div>
                            <?php if ($_POST["precioz"] == "on" or $_POST["precio2z"] == "on" or $_POST["precio3z"] == "on" or $_POST["precio4z"] == "on" or $_POST["precio5z"] == "on"  or $_POST["precio6z"] == "on" or $_POST["precio7z"] == "on" or $_POST["precio8z"] == "on" or $_POST["precio9z"] == "on" or $_POST["precio10z"] == "on" or $_POST["Existencia"] == "on") {
                            ?>
                                <!-- <div class="campo" style=" text-align: left; width: 8%; background-color: gray;"><?php echo lang("Total por Grupo"); ?> </div> -->
                            <?php
                            } ?>
                            <?php if ($_POST["Existencia"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: 6%; background-color: gray;"> <?php echo  number_format($existenciaX, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></div>
                                <div class="campo" style="visibility:hidden; text-align: right; width: 7.5%; background-color: gray;">UND </div>
                            <?php }
                            if ($_POST["costozzzv"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($CostoXexistT, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?></div>
                            <?php
                            }
                            if ($_POST["precioz"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                            } ?>
                            <?php if ($_POST["precio2z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"> <?php echo  number_format($precioT2, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?></div>
                            <?php
                            } ?>
                            <?php if ($_POST["precio3z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT3, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                            }
                            if ($_POST["precio4z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT4, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                            }
                            if ($_POST["precio5z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT5, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                            }
                            if ($_POST["precio6z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT6, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                            }
                            if ($_POST["precio7z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT7, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                            }
                            if ($_POST["precio8z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT8, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                            }
                            if ($_POST["precio9z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT9, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                            }
                            if ($_POST["precio10z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT10, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                            <?php
                            } ?>
                        </div>

                        <?php
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
                        <div style="PAGE-BREAK-AFTER: always"></div>
                        <div class="campo" style="visibility:hidden; text-align: right; width: 6%; "><?php echo number_format($PrecioTotal, 2); ?>.</div>
                        <div style="text-align: left; float:left; width: 100%;">
                            <div class="sup">
                                <div style="float:left; width: 23%;">
                                    <div class="TituloEmpresa" id="Titulo"><?php echo $_POST["NameCompany"]; ?></div>
                                    <div class="Subtituloempresa" id="Ubicacion"><?php echo $_POST["direccion"]; ?></div>
                                    <div class="Subtituloempresa" id="Literal Fiscal"><?php echo $_POST["litfiscal"]; ?>-<?php echo $_POST["rute"]; ?></div>
                                </div>

                                <div style="float:left; width: 53%;">
                                    <div class="TituloEmpresa" style="float: center; text-align: center;"><?php echo lang("Lista de Precios"); ?></div>
                                    <div class="TituloEmpresa" style="float: center; text-align: center;"><?php echo lang("Agrupado por Familias"); ?></div>
                                    <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php echo lang("Fecha"); ?>:<?php echo $_POST["FechaHastalista"]; ?> </div>
                                    <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php echo lang("Orden por"); ?>:<?php echo $_POST["OrdenLP"];
                                                                                                                                                                                    if ($_POST["CodigoDesdeLP"] == true) {
                                                                                                                                                                                        echo " / " . lang("Desde el Producto:") . $_POST["CodigoDesdeLP"];
                                                                                                                                                                                    }
                                                                                                                                                                                    if ($_POST["CodigoHastaLP"] == true) {
                                                                                                                                                                                        echo "al " . $_POST["CodigoHastaLP"];
                                                                                                                                                                                    }
                                                                                                                                                                                    ?>
                                    </div>
                                    <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                                        <?php
                                        if ($_POST["Instancia2LP"] == true) {
                                            echo "De la Familia: / " . $_POST["Instancia2LP"];
                                        }
                                        ?>
                                    </div>
                                    <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                                        <?php
                                        if ($_POST["Proevedor2LP"] == true or $_POST["MarcaLPUTA2"] == true or $_POST["Deposito2LP"] == true) {
                                            echo "Con:";
                                        } else {
                                            echo "--------------------";
                                        } ?>
                                        <?php
                                        if ($_POST["Proevedor2LP"] == true) {
                                            echo lang("Beneficiario") . ":/" . $_POST["Proevedor2LP"];
                                        }
                                        if ($_POST["MarcaLPUTA2"] == true) {
                                            echo " / " . lang("Marca") . ":" . $_POST["MarcaLPUTA2"];
                                        }
                                        if ($_POST["Deposito2LP"] == true) {
                                            echo " / " . lang("Almacen:") . $_POST["Deposito2LP"];
                                        }
                                        ?>
                                    </div>
                                    <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                                        <?php
                                        if ($_POST["ExistenciaCero"] == "on") {
                                            echo lang("Incluyendo:");
                                        } else {
                                            echo "--------------------";
                                        }
                                        if ($_POST["ExistenciaCero"] == "on") {
                                            echo " / " . lang("Existencia Cero");
                                        }
                                        ?>
                                    </div>
                                    <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                                        <?php
                                        if ($_POST["precioz"] == "on" or $_POST["precio2z"] == "on" or $_POST["precio3z"] == "on" or $_POST["precio4z"] == "on" or $_POST["precio5z"] == "on"  or $_POST["precio6z"] == "on" or $_POST["precio7z"] == "on" or $_POST["precio8z"] == "on" or $_POST["precio9z"] == "on" or $_POST["precio10z"] == "on") {
                                            echo lang("Precio") . ' ';
                                            if ($_POST['cimp'] == true) {
                                                echo lang("Con Impuesto");
                                            } else {
                                                echo lang("Sin Impuesto");
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>

                                <div style="float:left; width: 23%;">
                                    <div class="FechaI"><span id="fectx"><?php echo $_POST["fectx5"]; ?></span></div><br>
                                    <div class="FechaI">
                                        <div class="page"></div>
                                    </div><br>
                                    <div class="FechaI"><img style="width: 30%;" src="img/AZUL.svg" /></div><br><br>
                                    <div class="FechaI">-</div>
                                </div>
                            </div>
                        </div>


                        <div style="text-align: left; float:left; width: 100%;">

                            <div class="campo" style=" text-align: left; width: 36%;  font-weight:1400; font-size: 14px; "><strong> <?php echo $MarAct;  ?> </strong> </div>


                        </div>
                        <div class="encabezado" style="">
                            <div class="campo" style=" text-align: left; width: 12%; background-color: gray;"><?php echo lang("S.K.U"); ?></div>
                            <div class="campo" style=" text-align: left; width: 22%; background-color: gray;"><?php echo lang("Descripción"); ?></div> <?php
                                                                                                                                                        if ($_POST["MostrarMarcas"] === "on") {
                                                                                                                                                        ?>
                                <div class="campo" style=" text-align: left; width: 6%; background-color: gray;"><?php echo lang("Marca"); ?></div>

                            <?php
                                                                                                                                                        }
                            ?>
                            <?php if ($_POST["Existencia"] == "on") {
                            ?>
                                <!-- <div class="campo" style=" text-align: left; width: 8%; background-color: gray;"><?php echo lang("Referencia"); ?> </div> -->
                                <div class="campo" style=" text-align: right; width: 6%; background-color: gray;"><?php echo lang("Existencia"); ?></div>
                                <div class="campo" style=" text-align: right; width: 7.5%; background-color: gray;"><?php echo lang("Desglose"); ?> </div>
                            <?php }
                            if ($_POST["costozzzv"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitCosto) !== "" ? $LitCosto : lang("Costo")); ?></div>
                            <?php
                            }
                            if ($_POST["precioz"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP01) !== "" ? $LitP01 : lang("Precio") . " 1"); ?></div>
                            <?php
                            } ?>
                            <?php if ($_POST["precio2z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP02) !== "" ? $LitP02 : lang("Precio") . " 2"); ?></div>
                            <?php
                            } ?>
                            <?php if ($_POST["precio3z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP03) !== "" ? $LitP03 : lang("Precio") . " 3"); ?></div>
                            <?php
                            } ?>

                            <?php if ($_POST["precio4z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP04) !== "" ? $LitP04 : lang("Precio") . " 4"); ?> </div>
                            <?php
                            }  ?>

                            <?php if ($_POST["precio5z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP05) !== "" ? $LitP05 : lang("Precio") . " 5"); ?> </div>
                            <?php
                            }  ?>

                            <?php if ($_POST["precio6z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP06) !== "" ? $LitP06 : lang("Precio") . " 6"); ?> </div>
                            <?php
                            }  ?>

                            <?php if ($_POST["precio7z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP07) !== "" ? $LitP07 : lang("Precio") . " 7"); ?> </div>
                            <?php
                            }  ?>

                            <?php if ($_POST["precio8z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP08) !== "" ? $LitP08 : lang("Precio") . " 8"); ?> </div>
                            <?php
                            }  ?>

                            <?php if ($_POST["precio9z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP09) !== "" ? $LitP09 : lang("Precio") . " 9"); ?> </div>
                            <?php
                            }  ?>

                            <?php if ($_POST["precio10z"] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo (trim($LitP10) !== "" ? $LitP10 : lang("Precio") . " 10"); ?> </div>
                            <?php
                            }  ?>
                            <?php if ($_POST['cimp'] == "on") {
                            ?>
                                <div class="campo" style=" text-align: right; width: 2%; background-color: gray;">%<?php echo lang("Imp"); ?></div>
                            <?php
                            } ?>
                        </div>

            <?php
                        $n = 0;
                        $npa = 0;
                    }

                    $npi2 = $npi2 + 1;
                    $MarAct2 = trim($row['Familia']);
                }
                mysqli_free_result($result);
            }
            $UltimoRegistro = $row["CodIdBasico"];


            ?>
            <div class="encabezado" style="">
                <div class="campo" style="visibility:hidden; text-align: left; width: 12%; background-color: gray;">Código Barra</div>
                <div class="campo" style="visibility:hidden; text-align: left; width: 22%; background-color: gray;">S.K.U</div>
                <div class="campo" style="visibility:hidden; text-align: left; width: 6%; background-color: gray;">Descripción</div>
                <?php if ($_POST["precioz"] == "on" or $_POST["precio2z"] == "on" or $_POST["precio3z"] == "on" or $_POST["precio4z"] == "on" or $_POST["precio5z"] == "on"  or $_POST["precio6z"] == "on" or $_POST["precio7z"] == "on" or $_POST["precio8z"] == "on" or $_POST["precio9z"] == "on" or $_POST["precio10z"] == "on" or $_POST["Existencia"] == "on") {
                ?>
                    <!-- <div class="campo" style=" text-align: left; width: 8%; background-color: gray;"><?php echo lang("Total por Grupo"); ?> </div> -->
                    <!-- <div class="campo" style="visibility:hidden; text-align: right; width: 6%; background-color: gray;">UND </div>  -->
                <?php
                } ?>
                <?php if ($_POST["Existencia"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: 6%; background-color: gray;"> <?php echo  number_format($existenciaX, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></div>
                    <div class="campo" style="visibility:hidden; text-align: right; width: 7.5%; background-color: gray;">UND </div>
                <?php }
                if ($_POST["costozzzv"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: 5%; background-color: gray;"><?php echo number_format($CostoXexistT, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?></div>
                <?php
                }
                if ($_POST["precioz"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                <?php
                } ?>
                <?php if ($_POST["precio2z"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"> <?php echo  number_format($precioT2, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?></div>
                <?php
                } ?>
                <?php if ($_POST["precio3z"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT3, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                <?php
                }
                if ($_POST["precio4z"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT4, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                <?php
                }
                if ($_POST["precio5z"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT5, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                <?php
                }
                if ($_POST["precio6z"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT6, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                <?php
                }
                if ($_POST["precio7z"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT7, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                <?php
                }
                if ($_POST["precio8z"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT8, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                <?php
                }
                if ($_POST["precio9z"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT9, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                <?php
                }
                if ($_POST["precio10z"] == "on") {
                ?>
                    <div class="campo" style=" text-align: right; width: <?php echo $calc; ?>%; background-color: gray;"><?php echo number_format($precioT10, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $moneda; ?> </div>
                <?php
                } ?>
            </div>
            <div class="encabezado" style="font-size: 2px;">
                <hr>
            </div>



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



<?php

}




?>
<script>
    const totalPages = document.querySelectorAll('.page').length;
    document.documentElement.style.setProperty('--total-pages', totalPages);
</script>