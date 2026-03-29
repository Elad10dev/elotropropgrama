<?php

if ($_SESSION['IdiomaActual'] == '') {
    $_SESSION['IdiomaActual'] = $_POST['IdiomaActual'];
}
$fechaD = $_POST["FECH4"];
$fechaH = $_POST["FECH24"];

if ($_POST['CIdPlan'] == '0000000019') {
    if ($_POST['IdCompanySelect'] == '' or $_POST['IdCompanySelect'] == $_POST["IdCompanyGrp"]) {
        $companygrp = " in (" . $_POST["CompanyActual"] . "," . $_POST["IdCompanyGrp"] . ") ";
    } else {
        $companygrp = " in (" . $_POST["IdCompanySelect"] . ") ";
    }
} else {
    $companygrp = " = " . $_POST["CompanyActual"] . "  ";
}

include "ambiente.php";
$conn = ConectarConsultas();
session_start();
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
    <title>
        <?php echo lang("Operación de Inventario"); ?></title>
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
            size: A4 landscape;
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
        margin-right: 1px;
        font-size: 10px;

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
    <button class='ocultoimpresion ' onclick='document.getElementById(`formexcel`).submit()'><img src='/img/excel.png' width='28' height='28'><br>Operacion<br></button>
    <div class="pagina" style="font-size: 12px;">
        <div class="sup">
            <div style="float:left; width: 23%;">
                <div class="TituloEmpresa" id="Titulo">
                    <?php echo $_POST["NameCompany"]; ?></div>
                <div class="Subtituloempresa" id="Ubicacion">
                    <?php echo $_POST["direccion"]; ?></div>
                <div class="Subtituloempresa" id="Literal Fiscal">
                    <?php echo $_POST["litfiscal"]; ?>-<?php echo $_POST["rute"]; ?></div>
            </div>
            <div style="float:left; width: 53%;">
                <div class="TituloEmpresa" style="float: center; text-align: center;">
                    <?php echo lang("Operación de Inventario"); ?></div>
                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                    <?php echo lang("Orden por"); ?>:
                    <?php
                    if ($_POST["OrdenSE4"] == "1") {
                        echo "Codigo";
                    }
                    if ($_POST["OrdenSE4"] == "2") {
                        echo "Descripcion";
                    }
                    if ($_POST["OrdenSE4"] == "3") {
                        echo "Fecha";
                    }
                    ?>
                </div>
                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">Fecha:
                    <?php
                    if ($_POST["FECH4"] == true) {
                        echo $fechaD;
                    }
                    if ($_POST["FECH24"] == true) {
                        echo "  al  " . $fechaH;
                    }
                    ?>
                </div>
                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                    <?php
                    if ($_POST["Almacen234"] == FALSE) {
                        echo "--------------------";
                    }
                    if ($_POST["Almacen234"] == true) {
                        echo lang("Almacen") . ":";
                        $array2 = $_POST["Almacen234"];
                        foreach ($array2 as $array2) {
                            $query123 = "Select IdAlm,Nombre from PosUpAlmacen where IdCompany " . $companygrp . " 
                            and IdAlm=" . $array2 . "
                            ";

                            if ($result123 = mysqli_query($conn, $query123)) {
                                while ($row123 = mysqli_fetch_assoc($result123)) {
                                    echo "   " . $row123["Nombre"];
                                }
                                mysqli_free_result($result123);
                            }
                        }
                    }
                    ?>
                </div>
                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                    <?php
                    if ($_POST["Filtrar4"] == FALSE) {
                        echo "--------------------";
                    }
                    if ($_POST["Filtrar4"] == true) {
                        echo "Tipo de Transaccion :";
                        $array = $_POST["Filtrar4"];
                        foreach ($array as $array) {
                            $query321 = "Select idtipotx,Titulo from PosUpTx where Inventario<>0
                                and idtipotx=" . $array . "
                            ";
                            if ($result321 = mysqli_query($conn, $query321)) {
                                while ($row321 = mysqli_fetch_assoc($result321)) {
                                    echo "   " . lang($row321["Titulo"]);
                                }
                                mysqli_free_result($result321);
                            }
                        }
                    }
                    ?>
                </div>
                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                    <?php if ($_POST["Cliente22"] == TRUE) {
                        echo lang("Cliente") . ": " . $_POST["Cliente32"];
                    } else {
                        echo "--------------------";
                    }
                    ?>
                </div>
                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                    <?php if ($_POST["BeneficiarioSE22"] == TRUE) {
                        echo lang("Beneficiario") . ": " . $_POST["BeneficiarioSE222"];
                    } else {
                        echo "--------------------";
                    }
                    ?>
                </div>

                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                    <?php if ($_POST["Producto22"] == TRUE) {
                        echo lang("Producto") . ": " . $_POST["Producto32"];
                    } else {
                        echo "--------------------";
                    }
                    ?>
                </div>

            </div>
            <div style="float:left; width: 23%;">
                <div class="FechaI"><span id="fectx">
                        <?php echo $_POST["fectx5"]; ?></span></div><br>
                <div class="FechaI">
                    <div class="page"></div>
                </div><br>
                <div class="FechaI"><img style="width: 30%;" src="img/AZUL.svg" /></div><br><br>
                <div class="FechaI">https://PosUp.cl Email: info@posup.cl</div>
            </div>
        </div>

        <div class="encabezado">
            <div class="campo" style=" text-align: left; width: 7%; background-color: gray;">
                <?php echo lang("Documento"); ?></div>
            <div class="campo" style=" text-align: left; width: 9%; background-color: gray;">
                <?php echo lang("Nombre"); ?>
            </div>
            <div class="campo" style=" text-align: left; width: 4%; background-color: gray;">
                <?php echo lang("Fecha"); ?></div>
            <div class="campo" style=" text-align: left; width: 7%; background-color: gray;">
                <?php echo lang("Código"); ?>
            </div>

            <div class="campo" style=" text-align: left; width: 13%; background-color: gray;">
                <?php echo lang("Descripción"); ?></div>

            <div class="campo" style=" text-align: left; width: 12%; background-color: gray;">
                <?php echo lang("Depósito"); ?>
            </div>

            <div class="campo" style=" text-align: left; width: 4.5%; background-color: gray;">
                <?php echo lang("Vendedor"); ?>
            </div>
            <?php if ($_POST["Precioop"] == true) { ?>
                <div class="campo" style=" text-align: left; width: 2%; background-color: gray;">P</div>
            <?php }
            ?>

            <div class="campo" style=" text-align: right; width: 9.5%; background-color: gray;">
                <?php echo lang("Cantidad"); ?></div>
            <?php if ($_POST["Costoop"] == true) { ?>
                <div class="campo" style=" text-align: right; width: 5%; background-color: gray;">
                    <?php echo lang("Costo s/Imp"); ?></div>
            <?php }
            ?>
            <?php if ($_POST["Precioop"] == true) { ?>
                <div class="campo" style=" text-align: right; width: 4.5%; background-color: gray;">
                    <?php echo lang("Precio s/Imp"); ?></div>
            <?php }
            ?>

        </div>
        <?php
        if (!empty($_POST["mIdProductos"])) {
            $Producto = " and a.CodIdBasico in ('" . implode("','", $_POST["mIdProductos"]) . "')";
        }
        $OrdenBy = "order by a.CodIdBasico,b.Referencia,c.Seriales,b.Fectxclient";
        if ($_POST["OrdenSE4"] == "1") {
            $OrdenBy = " order by Documento,Tipo,a.CodIdBasico,b.Fectxserver,c.Cant*d.Inventario ASC";
        }
        if ($_POST["OrdenSE4"] == "2") {
            $OrdenBy = " order by a.Descripcion ASC";
        }
        if ($_POST["OrdenSE4"] == "3") {
            $OrdenBy = " order by b.Fectxclient ASC";
        }
        if (!empty($_POST["mIdProevedor"])) {
            $BeneficiarioSE = " and e.RUT in ('" . implode("','", $_POST["mIdProevedor"]) . "')";
        }

        if (!empty($_POST["mIdAlmacen"])) {
            $Almacen23 = " and c.IdAlm in (" . implode(",", $_POST["mIdAlmacen"]) . ")";
        }

        if ($_POST["Costoop"] == true) {
            $costo = "round((c.Costo/if(c.Impuesto=1,1.16,1))*d.inventario,2) as Costos,";
        }
        if ($_POST["SerialesOPe"] == true) {
            $seriales = ",
            GROUP_CONCAT(DISTINCT c.Seriales ORDER BY c.Seriales ASC SEPARATOR ' ') as Serialesx";
        }
        if ($_POST['icd'] == true) {
            if (!empty($_POST["Filtrar4"])) {
                $buscar .=  " and ( (d.Idtipotx in (3,27) and b.IdTipotxPadre in (" . implode(",", $_POST["Filtrar4"]) . ") ) or d.Idtipotx in(" . implode(",", $_POST["Filtrar4"]) . ") )";
            }
        } else {
            if (!empty($_POST["Filtrar4"])) {
                $buscar .= " and d.Idtipotx in (" . implode(",", $_POST["Filtrar4"]) . ")";
            }
        }

        $arrayx = [];

        $arrayx[] = [
            "Documento" => lang("Documento"),
            "Nombre" => lang("Nombre"),
            "Fecha" => lang("Fecha"),
            "Código" => lang("Código"),
            "Descripción" => lang("Descripción"),
            "Depósito" => lang("Depósito"),
            "Vendedor" => lang("Vendedor"),
            "Precio" => ($_POST["Precioop"] == true ? lang("Precio") : ""),
            "Cantidad" => lang("Cantidad"),
            "Costo" => ($_POST["Costoop"] == true ? lang("Costo s/Imp") : ""),
            "Preciosimp" => ($_POST["Precioop"] == true ? lang("Precio s/Imp") : ""),
            "Seriales" => ($_POST["SerialesOPe"] == true ? lang("Seriales") : ""),
        ];

        $query = "SET SESSION group_concat_max_len = 1000000";
        $result = mysqli_query($conn, $query);
        $idUbi = "";
        if ($_POST['sucursal'] !== '0') {
            $idUbi = " AND f.IdUbi=" . $_POST['sucursal'] . " and";
        }

        $NumTxViewVTA = "";
        $NumTxViewCOM = "";
        $NumTxViewINV = "";
        $query = "SELECT NumTxViewVTA , NumTxViewCOM , NumTxViewINV FROM PosUpCompany where id  = " . $_POST["CompanyActual"] . " ";
        if ($result = mysqli_query($conn, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $NumTxViewVTA = $row['NumTxViewVTA'];
                $NumTxViewCOM = $row['NumTxViewCOM'];
                $NumTxViewINV = $row['NumTxViewINV'];
            }
            mysqli_free_result($result);
        }

        $query = "
            select
                concat(d.TitCto, '-' , LPAD( if(if(b.Idtipotx in (1, 2, 3, 4, 5, 6, 11, 12, 13, 15, 21, 22, 23, 24, 25, 26, 31, 35, 36, 37), " . $NumTxViewVTA . ", if(b.Idtipotx in (7, 14, 20, 27, 28), " . $NumTxViewCOM . ", if(b.Idtipotx in (8, 9, 10, 16, 17, 18, 19, 29, 30, 32, 33, 34, 39), " . $NumTxViewINV . ", ''))) = 0, b.IdtxCompany, if(if(b.Idtipotx in (1, 2, 3, 4, 5, 6, 11, 12, 13, 15, 21, 22, 23, 24, 25, 26, 31, 35, 36, 37), " . $NumTxViewVTA . ", if(b.Idtipotx in (7, 14, 20, 27, 28), " . $NumTxViewCOM . ", if(b.Idtipotx in (8, 9, 10, 16, 17, 18, 19, 29, 30, 32, 33, 34, 39), " . $NumTxViewINV . ", ''))) = 1, b.Idtx, b.Referencia)), 6, '0')) as Documento,
                CONCAT(e.RUT, ' ', e.Nombre) as beneficiario,
                b.Fectxclient,
                a.CodIdBasico,
                a.CodBarra,
                a.CodIdAmpliado,
                a.Descripcion,
                concat('(', c.IdAlm, ') ', f.Nombre) as Almacen ,
                c.IdAlm as IdAlmacen,
                a.Medida,
                c.precioactual as PrecioActual,
                a.factorunit,
                sum(c.Cant * d.Inventario) as cant,
                if(b.UserVendedor='0','COMERCIO',ex.Nombre) as Vendedor,
                " . $costo . "
                round((c.Total-c.MontoImpuesto)*d.inventario,2) as Precio
                " . $seriales . "
            from
                PosUpTxD c
            inner join PosUpTx d on
                d.Idtipotx = c.Idtipotx
            inner join PosUpProducto a on
                a.CodIdBasico = c.CodIdBasico
                and a.IdCompany = c.IdCompany
            inner join PosUpTxC b on
                b.Idtx = c.Idtx
                and b.Idtipotx = c.Idtipotx
                and b.IdEstacion = c.IdEstacion
                and b.IdCompany = c.IdCompany
            left join PosUpUsers ex on 
                ex.IdCompany = b.IdCompany and ex.Login = b.UserVendedor
            left join PosUpclientes e on
                e.IdCompany = b.IdCompany
                and e.RUT = b.IdBen
            left join PosUpAlmacen f on
                f.IdCompany = c.IdCompany
                and f.IdAlm = c.IdAlm
            where
                c.IdCompany " . $companygrp . "
                and c.Fectxclient BETWEEN '" . $fechaD . " 00:00:00' 
                and '" . $fechaH . " 23:59:59'
                " . $Almacen23 . "
                " . $Producto . "
                " . $BeneficiarioSE . "
                " . $vende . "
                " . $user . "
                " . $buscar . "
                " . $idUbi . "
            group by
                c.Idtipotx,
                c.Idtx,
                c.IdEstacion,
                c.IdAlm,
                c.CodIdBasico
            " . $OrdenBy . "
        ";

        if ($result = mysqli_query($conn, $query)) {
            $n = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                $n = $n + 1.5;
                $nt = $nt + 1;
                $np = $np + 1;
                $npi = 1;
                $documentA = $row["Documento"];
                $codA = $row["CodIdBasico"];

                if ($color == 0) {
                    $color = 1;
                } else {
                    $color = 0;
                }

                if ($documentA <> $documentB and $npi2 >= 1) {
        ?>
                    <div style="text-align: left; float:left; width: 100%;">

                        <div class="campo" style="visibility:hidden; text-align: left; width: 58%; ">
                            <?php
                            if ($row['beneficiario'] == "") {
                                echo ".";
                            } else {
                                echo $row['beneficiario'] . ".";
                            }
                            ?>
                        </div>

                        <?php
                        if ($_POST["Precioop"] == true) {
                        ?>
                            <div class="campo" style="visibility:hidden; text-align: left; width: 2%; ">.</div>
                        <?php
                        }
                        ?>

                        <div class="campo" style="text-align: right; width: 4%;"> <strong>_________</strong> </div>


                        <?php if ($_POST["Costoop"] == true) { ?>
                            <div class="campo" style="text-align: right; width: 5%;"> <strong>_________</strong> </div>
                        <?php }
                        ?>

                        <?php if ($_POST["Precioop"] == true) { ?>
                            <div class="campo" style="text-align: right; width: 4.5%;"> <strong>_________</strong> </div>
                        <?php }
                        ?>
                    </div>
                    <div style="text-align: left; float:left; width: 100%;">


                        <div class="campo" style="visibility:hidden; text-align: left; width: 45.85%; ">
                            <?php
                            if ($row['beneficiario'] == "") {
                                echo ".";
                            } else {
                                echo $row['beneficiario'] . ".";
                            }
                            ?>
                        </div>

                        <?php
                        if ($_POST["Precioop"] == true) {
                        ?>
                            <div class="campo" style="visibility:hidden; text-align: left; width: 2%; ">.</div>
                        <?php
                        }
                        ?>
                        <div class="campo" style=" text-align: left; width: 7%; ">Sub-Totales</div>
                        <div class="campo" style=" text-align: right; width: 9%; ">
                            <?php echo getcantformat($cantTotal, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></div>

                        <?php if ($_POST["Costoop"] == true) { ?>
                            <div class="campo" style=" text-align: right; width: 5%; ">
                                <?php echo getcantformat($costoTotal, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></div>
                        <?php }
                        ?>

                        <?php if ($_POST["Precioop"] == true) { ?>
                            <div class="campo" style=" text-align: right; width: 4.5%; ">
                                <?php echo getcantformat($PrecioTotal, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></div>
                        <?php }
                        ?>


                    </div>
                <?php

                    $n = $n + 2;
                    $npi = 0;
                    $cantTotal = 0;
                    $PrecioTotal = 0;
                    $costoTotal = 0;
                }
                ?>
                <div style="text-align: left; float:left; width: 100%; <?php echo ($color == 0 ? "" : "background: #EDECEC;"); ?>">
                    <div class="campo" style=" text-align: left; width: 7%; ">
                        <?php
                        if ($documentA == $documentB) {
                            echo '"';
                        } else {
                            if ($row['Documento'] == "") {
                                echo "-";
                            } else {
                                echo  $row['Documento'];
                                if ($npi <= 1) {
                                    $npi = $npi + 1;
                                }
                            }
                        }
                        ?>
                    </div>
                    <div class="campo" style=" text-align: left; width: 9%; ">
                        <?php
                        if ($documentA == $documentB) {
                            echo '""';
                        } else {
                            if ($row['beneficiario'] == "") {
                                echo "&nbsp;";
                            } else {
                                echo $row['beneficiario'] . ".";
                            }
                        }
                        ?>
                    </div>

                    <div class="campo" style=" text-align: left; width: 4%; ">
                        <?php
                        if ($documentA == $documentB) {
                            echo '""';
                        } else {
                            if ($row['Fectxclient'] == "") {
                                echo "&nbsp;";
                            } else {
                                echo $row['Fectxclient'];
                            }
                        }
                        ?>
                    </div>
                    <div class="campo" style=" text-align: left; width: 7%; ">
                        <?php
                        if ($row['CodBarra'] == "") {
                            echo "-";
                        } else {
                            echo $row['CodBarra'];
                        }
                        ?>
                    </div>
                    <div class="campo" style=" text-align: left; width: 13%; ">
                        <?php if ($row['Descripcion'] == '') {
                            echo "-";
                        } else {
                            echo $row['Descripcion'] . ".";
                        }
                        ?></div>
                    <div class="campo" style=" text-align: left; width: 12%; ">
                        <?php
                        if ($row['Almacen'] == "") {
                            echo "-";
                        } else {
                            echo $row['Almacen'];
                        }
                        ?>
                    </div>
                    <div class="campo" style=" text-align: left; width: 4.5%; ">
                        <?php
                        echo $row["Vendedor"];
                        ?>
                    </div>
                    <?php

                    if ($codA == $codB) {
                    } else {
                        $query4 = "SELECT coalesce(sum(b.Cantidad),0) as InvInicial,a.CantP1,a.UnidadP1,a.CantP2,a.UnidadP1 as uniP2d, a.Medida as medida 
                        from PosUpProducto a 
                        inner join (select CodIdBasico,sum(Cantidad) as Cantidad, IdAlm 
                            from (
                                SELECT
                                    f.CodIdBasico,
                                    sum(f.Cantidad) AS Cantidad,
                                    f.IdAlm 
                                FROM
                                    posupproductostockmes f
                                WHERE
                                    f.IdCompany " . $companygrp . " and f.Periodo < DATE_FORMAT('" . $firstDayOfMonth . " 00:00:00', '%Y%m') 
                                    " . (!empty($_POST["mIdAlmacen"]) ? " and f.IdAlm in ('" . implode("','", $_POST["mIdAlmacen"]) . "')" : "") . "
                                    and f.CodIdBasico='" . $row["CodIdBasico"] . "'  and f.IdAlm=" . $row['IdAlmacen'] . "   
                                    GROUP BY
                                    f.CodIdBasico,
                                    f.IdAlm
                                HAVING
                                    Cantidad <> 0
                                UNION ALL
                                select
                                    ba.CodIdBasico,
                                    sum(ba.Cant * bb.Inventario) as Cantidad,
                                    ba.IdAlm
                                from
                                    PosUpTxD ba
                                left join PosUpTx bb on
                                    ba.Idtipotx = bb.Idtipotx
                                where
                                    ba.IdCompany " . $companygrp . "
                                    and ba.Fectxclient >= '" . $firstDayOfMonth . " 00:00:00' and ba.Fectxclient < '" . $fechaD . " 00:00:00'
                                    and ba.CodIdBasico='" . $row["CodIdBasico"] . "'  and ba.IdAlm=" . $row['IdAlmacen'] . "   
                                group by
                                    ba.CodIdBasico,
                                    ba.IdAlm
                                ) bpre 
                            group by CodIdBasico 
                    ) b on b.CodIdBasico = a.CodIdBasico
                    where a.IdCompany " . $companygrp . "  and a.CodIdBasico='" . $row["CodIdBasico"] . "'  ";
                        if ($result4 = mysqli_query($conn, $query4)) {
                            while ($row4 = mysqli_fetch_assoc($result4)) {
                                $invIni = 0;
                                $medida = $row4['medida'];
                                $desg = $row4['CantP1'];
                                $desg2 = $row4['UnidadP1'];
                                $entUni1 = intval($row4['InvInicial']);
                                $entUni2 = round(($row4['InvInicial'] - intval($row4['InvInicial'])) * $row4['CantP1']);
                            }
                            mysqli_free_result($result4);
                        }
                    }

                    if ($desg == 0) {
                        $acd = $desg;
                    }

                    $entUni1T = intval($row['cant']);
                    $entUni2T = round(($row['cant'] - intval($row['cant'])) * $desg);

                    $entUnia = $entUnia + $entUni1;
                    $entUnib = $entUnib + $entUni2T;
                    $cantTotal = $cantTotal + $row["cant"];
                    $cantTotal2 = $cantTotal2 + $row["cant"];
                    ?>
                    <?php if ($_POST["Precioop"] == true) { ?>
                        <div class="campo" style=" text-align: left; width: 2%; ">
                            <?php if ($row['PrecioActual'] == "") {
                                echo "-";
                            } else {
                                echo "P: " . $row['PrecioActual'];
                            }
                            ?></div>
                    <?php }
                    ?>
                    <div class="campo" style=" text-align: right; width: 9.5%; ">&nbsp;
                        <?php
                        if ($row["factorunit"] <> 1 && $row["factorunit"] <> 0) {
                            echo " " . $row["factorunit"] . " x " . getcantformat($row["cant"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " = " . getcantformat($row["cant"] * $row["factorunit"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $row["Medida"];
                        } else {
                            if ($entUni1T <> 0) {
                                if ($entUni1T == 0) {
                                    echo "";
                                } else {
                                    echo getcantformat($entUni1T, 2, $_POST["SimDec"], $_POST["SimMil"]);
                                }
                                if ($medida == "") {
                                    echo "";
                                } else {
                                    echo  '(' . substr($medida, 0, 3) . ')';
                                }
                            }
                            if ($entUni2T <> 0 and $entUni1T <> 0 and $entUni2T <> $entUni1T) {
                                echo ' y ';
                            }
                            if ($entUni2T <> 0 and $entUni2T <> $entUni1T) {
                                if ($entUni2T == 0) {
                                    echo "";
                                } else {
                                    echo getcantformat($entUni2T, 2, $_POST["SimDec"], $_POST["SimMil"]);
                                }

                                if ($desg2 == '') {
                                    echo "";
                                } else {
                                    echo  '(' . substr($desg2, 0, 3) . ')';
                                }
                            }
                        }
                        ?>
                    </div>
                    <?php if ($_POST["Costoop"] == true) { ?>
                        <div class="campo" style=" text-align: right; width: 5%; ">&nbsp;<?php if ($row['Costos'] == "") {
                                                                                                echo "-";
                                                                                            } else {
                                                                                                echo number_format($row['Costos'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                            }
                                                                                            $costoTotal = $costoTotal + $row["Costos"];
                                                                                            $costoTotal2 = $costoTotal2 + $row["Costos"];
                                                                                            ?></div>
                    <?php }
                    ?>
                    <?php
                    if ($_POST["Precioop"] == true) {
                    ?>
                        <div class="campo" style=" text-align: right; width: 4.5%; ">
                            <?php if ($row['Precio'] == "") {
                                echo "-";
                            } else {
                                echo number_format($row['Precio'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                            }
                            $PrecioTotal = $PrecioTotal + $row["Precio"];
                            $PrecioTotal2 = $PrecioTotal2 + $row["Precio"];
                            ?>
                        </div>
                    <?php
                    }
                    ?>
                    <?php if ($_POST["SerialesOPe"] == true) {

                    ?>

                        <div class="campo" style=" text-align: left; width: 90%; padding-left:10%;"><strong>
                                <?php
                                echo $row['Serialesx'];
                                ?></strong></div>

                    <?php
                        //echo $n;
                        $n = $n + 1;
                    }
                    ?>
                </div>
                <?php

                $arrayx[] = [
                    "Documento" => $row['Documento'],
                    "Nombre" => str_replace("'", " ", $row['beneficiario']) . ".",
                    "Fecha" => $row['Fectxclient'],
                    "Código" => $row['CodBarra'],
                    "Descripción" => $row['Descripcion'] . ".",
                    "Depósito" => $row['Almacen'],
                    "Vendedor" => $row['Vendedor'],
                    "Precio" => ($_POST["Precioop"] == true ? number_format($row['PrecioActual'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : ""),
                    "Cantidad" => ($row["factorunit"] <> 0 && $row["factorunit"] <> 1 ? $row["factorunit"] . " x " . getcantformat($row["cant"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " = " . getcantformat($row["cant"] * $row["factorunit"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $row["Medida"] : getcantformat($row["cant"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $row["Medida"]),
                    "Costo" => ($_POST["Costoop"] == true ? number_format($row['Costos'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : ""),
                    "Preciosimp" => ($_POST["Precioop"] == true ? number_format($row['Precio'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : ""),
                    "Seriales" => ($_POST["SerialesOPe"] == true ? strval($row['Serialesx']) . "," : ""),
                ];

                $npi2 = $npi2 + 1;
                $documentB = $row['Documento'];
                $codB = $row["CodIdBasico"];

                $unidadTotal = $unidadTotal + $row["unidad"];
                $ExistenciaTotal = $ExistenciaTotal + $row["Cantidad"];

                if ($n >= 27) { ?>
                    <div class="encabezado" style="font-size: 2px;">
                        <hr>

                        <div class="campo" style=" text-align: left; width: 20%; background-color: white;">
                            <?php echo lang("Totales Registros"); ?></div>

                        <div class="campo" style=" text-align: left; width: 15%; background-color: white;">
                            <?php echo lang("Registro por Pagina") . "= " . $np; ?></div>

                        <div class="campo" style=" text-align: left; width: 15%; background-color: white;">
                            <?php echo lang("Registro Total acumulado") . "= " . $nt; ?></div>


                        <div class="campo" style=" text-align: left; width: 15%; background-color: white;">
                            <?php echo lang("Total Cantidad Acumulado") . ": " .  getcantformat($cantTotal2, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></div>
                        <?php if ($_POST["Costoop"] == true) { ?>
                            <div class="campo" style=" text-align: left; width: 15%; background-color: white;">
                                <?php echo lang("Total Costo Acumulado") . ": " . number_format($costoTotal2, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></div>
                        <?php }
                        ?>

                        <?php if ($_POST["Precioop"] == true) { ?>
                            <div class="campo" style=" text-align: left; width: 15%; background-color: white;">
                                <?php echo lang("Total Precio Acumulado") . ": " .   number_format($PrecioTotal2, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>
                        <?php }
                        ?>

                    </div>


                    <div style="PAGE-BREAK-AFTER: always"></div>
                    <div class="campo" style="visibility:hidden; text-align: right; width: 6%; ">
                        <?php echo number_format($PrecioTotal, 2); ?>.</div>

                    <div class="sup">
                        <div style="float:left; width: 23%;">
                            <div class="TituloEmpresa" id="Titulo">
                                <?php echo $_POST["NameCompany"]; ?></div>
                            <div class="Subtituloempresa" id="Ubicacion">
                                <?php echo $_POST["direccion"]; ?></div>
                            <div class="Subtituloempresa" id="Literal Fiscal">
                                <?php echo $_POST["litfiscal"]; ?>-<?php echo $_POST["rute"]; ?></div>
                        </div>
                        <div style="float:left; width: 53%;">
                            <div class="TituloEmpresa" style="float: center; text-align: center;">
                                <?php echo lang("Operación de Inventario"); ?></div>
                            <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                                <?php echo lang("Orden por"); ?>:
                                <?php
                                if ($_POST["OrdenSE4"] == "1") {
                                    echo "Codigo";
                                }
                                if ($_POST["OrdenSE4"] == "2") {
                                    echo "Descripcion";
                                }
                                if ($_POST["OrdenSE4"] == "3") {
                                    echo "Fecha";
                                }
                                ?>
                            </div>
                            <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">Fecha:
                                <?php
                                if ($_POST["FECH4"] == true) {
                                    echo $fechaD;
                                }
                                if ($_POST["FECH24"] == true) {
                                    echo "  al  " . $fechaH;
                                }
                                ?>
                            </div>
                            <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                                <?php
                                if ($_POST["Almacen234"] == FALSE) {
                                    echo "--------------------";
                                }
                                if ($_POST["Almacen234"] == true) {
                                    echo lang("Almacen") . ":";
                                    $array2 = $_POST["Almacen234"];
                                    foreach ($array2 as $array2) {
                                        $query123 = "Select IdAlm,Nombre from PosUpAlmacen where IdCompany " . $companygrp . " 
                                        and IdAlm=" . $array2 . "
                                        ";

                                        if ($result123 = mysqli_query($conn, $query123)) {
                                            while ($row123 = mysqli_fetch_assoc($result123)) {
                                                echo "   " . $row123["Nombre"];
                                            }
                                            mysqli_free_result($result123);
                                        }
                                    }
                                }
                                ?>
                            </div>
                            <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                                <?php
                                if ($_POST["Filtrar4"] == FALSE) {
                                    echo "--------------------";
                                }
                                if ($_POST["Filtrar4"] == true) {
                                    echo "Tipo de Transaccion :";
                                    $array = $_POST["Filtrar4"];
                                    foreach ($array as $array) {
                                        $query321 = "Select idtipotx,Titulo from PosUpTx where Inventario<>0
                                            and idtipotx=" . $array . "
                                        ";
                                        if ($result321 = mysqli_query($conn, $query321)) {
                                            while ($row321 = mysqli_fetch_assoc($result321)) {
                                                echo "   " . lang($row321["Titulo"]);
                                            }
                                            mysqli_free_result($result321);
                                        }
                                    }
                                }
                                ?>
                            </div>
                            <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                                <?php if ($_POST["Cliente22"] == TRUE) {
                                    echo lang("Cliente") . ": " . $_POST["Cliente32"];
                                } else {
                                    echo "--------------------";
                                }
                                ?>
                            </div>
                            <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                                <?php if ($_POST["BeneficiarioSE22"] == TRUE) {
                                    echo lang("Beneficiario") . ": " . $_POST["BeneficiarioSE222"];
                                } else {
                                    echo "--------------------";
                                }
                                ?>
                            </div>

                            <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                                <?php if ($_POST["Producto22"] == TRUE) {
                                    echo lang("Producto") . ": " . $_POST["Producto32"];
                                } else {
                                    echo "--------------------";
                                }
                                ?>
                            </div>

                        </div>
                        <div style="float:left; width: 23%;">
                            <div class="FechaI"><span id="fectx">
                                    <?php echo $_POST["fectx5"]; ?></span></div><br>
                            <div class="FechaI">
                                <div class="page"></div>
                            </div><br>
                            <div class="FechaI"><img style="width: 30%;" src="img/AZUL.svg" /></div><br><br>
                            <div class="FechaI">https://PosUp.cl Email: info@posup.cl</div>
                        </div>
                    </div>

                    <div class="encabezado">
                        <div class="campo" style=" text-align: left; width: 7%; background-color: gray;">
                            <?php echo lang("Documento"); ?></div>
                        <div class="campo" style=" text-align: left; width: 9%; background-color: gray;">
                            <?php echo lang("Nombre"); ?>
                        </div>
                        <div class="campo" style=" text-align: left; width: 4%; background-color: gray;">
                            <?php echo lang("Fecha"); ?></div>
                        <div class="campo" style=" text-align: left; width: 7%; background-color: gray;">
                            <?php echo lang("Código"); ?>
                        </div>

                        <div class="campo" style=" text-align: left; width: 13%; background-color: gray;">
                            <?php echo lang("Descripción"); ?></div>

                        <div class="campo" style=" text-align: left; width: 12%; background-color: gray;">
                            <?php echo lang("Depósito"); ?>
                        </div>
                        <div class="campo" style=" text-align: left; width: 4.5%; background-color: gray;">
                            <?php echo lang("Vendedor"); ?>
                        </div>
                        <?php if ($_POST["Precioop"] == true) { ?>
                            <div class="campo" style=" text-align: left; width: 2%; background-color: gray;">P</div>
                        <?php }
                        ?>

                        <div class="campo" style=" text-align: right; width: 9.5%; background-color: gray;">
                            <?php echo lang("Cantidad"); ?></div>
                        <?php if ($_POST["Costoop"] == true) { ?>
                            <div class="campo" style=" text-align: right; width: 5%; background-color: gray;">
                                <?php echo lang("Costo s/Imp"); ?></div>
                        <?php }
                        ?>
                        <?php if ($_POST["Precioop"] == true) { ?>
                            <div class="campo" style=" text-align: right; width: 4.5%; background-color: gray;">
                                <?php echo lang("Precio s/Imp"); ?></div>
                        <?php }
                        ?>

                    </div>


            <?php $n = 0;
                    $np = 0;
                }
            }
            mysqli_free_result($result);

            ?>
            <div style="text-align: left; float:left; width: 100%;">
                <div style="text-align: left; float:left; width: 100%;">

                    <div class="campo" style="visibility:hidden; text-align: right; width: 59.5%;"> <strong>____________</strong> </div>
                    <div class="campo" style="visibility:hidden; text-align: right; width: 1%;"> <strong>____________</strong> </div>
                    <div class="campo" style="visibility:hidden; text-align: right; width: 1%;"> <strong>____________</strong> </div>
                    <div class="campo" style="visibility:hidden; text-align: right; width: 1%;"> <strong>____________</strong> </div>
                    <div class="campo" style="visibility:hidden; text-align: right; width: 1%;"> <strong>____________</strong> </div>
                    <div class="campo" style="visibility:hidden; text-align: right; width: 1%;"> <strong>____________</strong> </div>
                    <div class="campo" style="visibility:hidden; text-align: right; width: 6%;"> <strong>____________</strong> </div>

                    <?php if ($_POST["Precioop"] == true) { ?>
                        <div class="campo" style="visibility:hidden; text-align: right; width: 2%;"> <strong>____________</strong> </div>
                    <?php }
                    ?>
                    <div class="campo" style="text-align: right; width: 4%;"> <strong>_________</strong> </div>


                    <?php if ($_POST["Costoop"] == true) { ?>
                        <div class="campo" style="text-align: right; width: 5%;"> <strong>_________</strong> </div>
                    <?php }
                    ?>

                    <?php if ($_POST["Precioop"] == true) { ?>
                        <div class="campo" style="text-align: right; width: 4.5%;"> <strong>_________</strong> </div>
                    <?php }
                    ?>
                </div>
                <div style="text-align: left; float:left; width: 100%;">
                    <div class="campo" style="visibility:hidden; text-align: left; width: 7%; ">
                        <?php if ($documentA == $documentB) {
                            echo '"';
                        } else {
                            if ($row['Documento'] == "") {
                                echo "-";
                            } else {
                                echo $row['Documento'];
                            }
                        }
                        ?></div>
                    <div class="campo" style="visibility:hidden; text-align: left; width: 9%; ">
                        <?php if ($row['beneficiario'] == "") {
                            echo ".";
                        } else {
                            echo $row['beneficiario'] . ".";
                        }
                        ?>
                    </div>

                    <div class="campo" style="visibility:hidden; text-align: left; width: 4%; ">
                        <?php if ($row['Fectxclient'] == "") {
                            echo ".";
                        } else {
                            echo  ' .';
                        }
                        ?></div>
                    <div class="campo" style="visibility:hidden; text-align: left; width: 7%; ">
                        <?php if ($row['Fectxclient'] == "") {
                            echo ".";
                        } else {
                            echo $row['Fectxclient'];
                        }
                        ?></div>
                    <div class="campo" style="visibility:hidden; text-align: left; width: 7%; ">
                        <?php if ($row['CodIdBasico'] == "") {
                            echo ".";
                        } else {
                            echo $row['CodIdBasico'];
                        }
                        ?></div>
                    <div class="campo" style="visibility:hidden; text-align: left; width: 12.6%; ">
                        <?php if ($row['Descripcion'] == '') {
                            echo ".";
                        } else {
                            echo $row['Descripcion'] . ".";
                        }
                        ?></div>

                    <div class="campo" style="visibility:hidden; text-align: left; width: 12%; ">
                        <?php if ($row['Almacen'] == "") {
                            echo ".";
                        } else {
                            echo $row['Almacen'];
                        }  ?></div>
                    <?php if ($_POST["Precioop"] == true) { ?>
                        <div class="campo" style="visibility:hidden; text-align: right; width: 2%;"> <strong>.</strong> </div>
                    <?php }
                    ?>
                    <div class="campo" style=" text-align: left; width: 7%; ">
                        <?php echo lang("Sub-Totales"); ?></div>

                    <div class="campo" style=" text-align: right; width: 9%; ">
                        <?php echo getcantformat($cantTotal, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></div>

                    <?php if ($_POST["Costoop"] == true) { ?>
                        <div class="campo" style=" text-align: right; width: 5%; ">
                            <?php echo number_format($costoTotal, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></div>
                    <?php }
                    ?>
                    <?php if ($_POST["Precioop"] == true) { ?>
                        <div class="campo" style=" text-align: right; width: 4.5%; ">
                            <?php echo number_format($PrecioTotal, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></div>
                    <?php }
                    ?>
                </div>

                <div style="visibility:hidden; text-align: left; float:right; width: 20%;"><strong>______________________________</strong> </div>
            <?php
            $n = $n + 3;
            $npi = 0;
            $cantTotal = 0;
            $PrecioTotal = 0;
            $costoTotal = 0;
        }




            ?>

            <div class="encabezado" style="font-size: 2px;">
                <hr>
                <div class="campo" style=" text-align: left; width: 20%; background-color: white;">
                    <?php echo lang("Totales Registros"); ?></div>
                <div class="campo" style=" text-align: left; width: 15%; background-color: white;">
                    <?php echo lang("Registro por Pagina") . "= " . $np; ?></div>
                <div class="campo" style=" text-align: left; width: 15%; background-color: white;">
                    <?php echo lang("Registro Total acumulado") . "= " . $nt; ?></div>

                <div class="campo" style=" text-align: left; width: 15%; background-color: white;">
                    <?php echo lang("Total Cantidad Acumulado") . ": " . getcantformat($cantTotal2, 2, $_SESSION["SimDec"], $_SESSION["SimMil"]); ?></div>
                <?php if ($_POST["Costoop"] == true) { ?>
                    <div class="campo" style=" text-align: left; width: 15%; background-color: white;">
                        <?php echo lang("Total Costo Acumulado") . ": " . number_format($costoTotal2, 2); ?></div>
                <?php }
                ?>
                <?php if ($_POST["Precioop"] == true) { ?>
                    <div class="campo" style=" text-align: left; width: 15%; background-color: white;">
                        <?php echo lang("Total Precio Acumulado") . ": " . number_format($PrecioTotal2, 2);  ?></div>
                <?php }
                ?>
            </div>
            </div>
    </div>
    <div style="PAGE-BREAK-AFTER: always; visibility: hidden;">a</div>
    <form id="formexcel" action="excelnew.php" method="post">
        <?php
        $compa = $_POST["CompanyActual"];
        $name = lang("OperacionesDeInventario");
        ?>
        <input type="hidden" name="array" value='<?php echo json_encode($arrayx, JSON_UNESCAPED_UNICODE); ?>'>
        <input type="hidden" name="Query" id="Query" value="<?php echo $query; ?>" />
        <input type="hidden" name="Name" id="Name" value="<?php echo $name; ?>" />
        <input type="hidden" name="SimDec" id="SimDec" value="<?php echo $_POST['SimDec']; ?>" />
        <input type="hidden" name="SimMil" id="SimMil" value="<?php echo $_POST['SimMil']; ?>" />
        <input type="hidden" name="CD" id="CD" value="<?php echo $_POST['CD']; ?>" />
        <input type="hidden" name="Costoop" id="Costoop" value="<?php echo $_POST['Costoop']; ?>" />
        <input type="hidden" name="Precioop" id="Precioop" value="<?php echo $_POST['Precioop']; ?>" />
        <input type="hidden" name="CompanyActual" id="CompanyActual" value="<?php echo $_POST['CompanyActual']; ?>" />
        <input type="hidden" name="vas" id="vas" value="operaciones-inv" />
    </form>




</body>
<script>
    const totalPages = document.querySelectorAll('.page').length;
    document.documentElement.style.setProperty('--total-pages', totalPages);
</script>

</html>