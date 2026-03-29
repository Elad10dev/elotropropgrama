<?php

include "ambiente.php";
$conn = ConectarReport();
session_start();

$fechaDES = $_POST["DesdeFecha"];
$fechaHAS = $_POST["FechaHasta"];

if ($_SESSION['IdiomaActual'] == '') {
    $_SESSION['IdiomaActual'] = $_POST['IdiomaActual'];
}

if ($_POST['CIdPlan'] == '0000000019') {
    if ($_POST['IdCompanySelect'] == '' or $_POST['IdCompanySelect'] == $_POST["IdCompanyGrp"]) {
        $companygrp = " in (" . $_POST["CompanyActual"] . "," . $_POST["IdCompanyGrp"] . ") ";
    } else {
        $companygrp = " in (" . $_POST["IdCompanySelect"] . ") ";
    }
} else {
    $companygrp = " = " . $_POST["CompanyActual"] . "  ";
}
if (trim($_POST["sucursal"]) == '') {
    $_POST['sucursal'] = $_POST["sucursal"];
}

$queryz = "SELECT GROUP_CONCAT(DISTINCT concat('(',TitCto,')=',Titulo)
    ORDER BY  TitCto ASC SEPARATOR  ' ') as tx from PosUpTx where Inventario <> 0 or CompInv<>0";
$queryzz = "SELECT TitCto
    from PosUpTx 
    where Idtipotx = 2";
if ($resultz = mysqli_query($conn, $queryz)) {
    $n = 0;
    while ($rowz = mysqli_fetch_assoc($resultz)) {
        $idk = $rowz['tx'];
    }
    mysqli_free_result($resultz);
}

$cboletas = "SELECT TitCto
    from PosUpTx 
    where Idtipotx =1";
$resulset = mysqli_query($conn, $cboletas);
$rowy = mysqli_fetch_assoc($resulset);
$bol = $rowy['TitCto'];

$cfacturas = "SELECT TitCto
    from PosUpTx 
    where Idtipotx =2";
$resulset = mysqli_query($conn, $cfacturas);
$rowy = mysqli_fetch_assoc($resulset);
$fac = $rowy['TitCto'];
$cguiav = "SELECT TitCto
    from PosUpTx 
    where Idtipotx =22";
$resulset = mysqli_query($conn, $cguiav);
$rowy = mysqli_fetch_assoc($resulset);
$gde = $rowy['TitCto'];
$cdevolucion = "SELECT TitCto
    from PosUpTx 
    where Idtipotx =3";
$resulset = mysqli_query($conn, $cdevolucion);
$rowy = mysqli_fetch_assoc($resulset);
$dev = $rowy['TitCto'];
$Ccompras = "SELECT TitCto
    from PosUpTx 
    where Idtipotx =7";
$resulset = mysqli_query($conn, $Ccompras);
$rowy = mysqli_fetch_assoc($resulset);
$com = $rowy['TitCto'];
$CDevcompra = "SELECT TitCto
    from PosUpTx 
    where Idtipotx =27";
$resulset = mysqli_query($conn, $CDevcompra);
$rowy = mysqli_fetch_assoc($resulset);
$dec = $rowy['TitCto'];
$CGcompras = "SELECT TitCto
    from PosUpTx 
    where Idtipotx =28";
$resulset = mysqli_query($conn, $CGcompras);
$rowy = mysqli_fetch_assoc($resulset);
$gdc = $rowy['TitCto'];
$Cajustes = "SELECT TitCto
    from PosUpTx 
    where Idtipotx =8";
$resulset = mysqli_query($conn, $Cajustes);
$rowy = mysqli_fetch_assoc($resulset);
$aj = $rowy['TitCto'];
$CCargos = "SELECT TitCto
    from PosUpTx 
    where Idtipotx =18";
$resulset = mysqli_query($conn, $CCargos);
$rowy = mysqli_fetch_assoc($resulset);
$car = $rowy['TitCto'];

$Ctraslados = "SELECT TitCto
    from PosUpTx 
    where Idtipotx =17";
$resulset = mysqli_query($conn, $Ctraslados);
$rowy = mysqli_fetch_assoc($resulset);
$mov = $rowy['TitCto'];
$movimiento = "SELECT TitCto
    from PosUpTx 
    where Idtipotx =9";
$resulset = mysqli_query($conn, $movimiento);
$rowy = mysqli_fetch_assoc($resulset);
$mov2 = $rowy['TitCto'];
$CDescargos = "SELECT TitCto
    from PosUpTx 
    where Idtipotx =19";
$resulset = mysqli_query($conn, $CDescargos);
$rowy = mysqli_fetch_assoc($resulset);
$des = $rowy['TitCto'];
$CTomas = "SELECT TitCto
    from PosUpTx 
    where Idtipotx =10";
$resulset = mysqli_query($conn, $CTomas);
$rowy = mysqli_fetch_assoc($resulset);
$tom = $rowy['TitCto'];
$COcompra = "SELECT TitCto
    from PosUpTx 
    where Idtipotx =14";
$resulset = mysqli_query($conn, $COcompra);
$rowy = mysqli_fetch_assoc($resulset);
$oc = $rowy['TitCto'];
$CPedidos = "SELECT TitCto
    from PosUpTx 
    where Idtipotx =11";
$resulset = mysqli_query($conn, $CPedidos);
$rowy = mysqli_fetch_assoc($resulset);
$ped = $rowy['TitCto'];
$NotaEntre = "SELECT TitCto
    from PosUpTx 
    where Idtipotx =15";
$resulset = mysqli_query($conn, $NotaEntre);
$rowy = mysqli_fetch_assoc($resulset);
$nte = $rowy['TitCto'];

$produ = "SELECT TitCto
    from PosUpTx 
    where Idtipotx =30";
$resulset = mysqli_query($conn, $produ);
$rowy = mysqli_fetch_assoc($resulset);
$pro = $rowy['TitCto'];


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
    <title>Movimiento de Inventario Resumido</title>
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
        margin-right: 3px;
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
</style>

<body>
    <button type='submit' class='ocultoimpresion ' onclick='window.print();'><img src='/img/pdf.png' width='28' height='28'><br>PDF</button>
    <button class='ocultoimpresion ' onclick='document.getElementById(`formexcel`).submit()'><img src='/img/excel.png' width='28' height='28'><br><?php echo lang("Resumido"); ?><br></button>
    <div class="pagina" style="font-size: 12px;">

        <div class="sup">
            <div style="float:left; width: 23%;">
                <div class="TituloEmpresa" id="Titulo"><?php echo $_POST["NameCompany"]; ?></div>
                <div class="Subtituloempresa" id="Ubicacion"><?php echo $_POST["direccion"]; ?></div>
                <div class="Subtituloempresa" id="Literal Fiscal"><?php echo $_POST["litfiscal"]; ?>-<?php echo $_POST["rute"]; ?></div>
            </div>
            <div style="float:left; width: 53%;">
                <div class="TituloEmpresa" style="float: center; text-align: center;"><?php echo lang("Movimiento de Inventario Resumido"); ?></div>
                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php
                                                                                                                            if ($_POST["Almacen234"] == FALSE) {
                                                                                                                                echo "--------------------";
                                                                                                                            }
                                                                                                                            if ($_POST["Almacen234"] == true) {
                                                                                                                                echo "Almacen:";
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
                                                                                                                            } ?>
                </div>


                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                    <?php echo lang("Orden por"); ?>: <?php
                                                        if ($_POST["OrdenRES"] == "1") {
                                                            echo lang("Codigo");
                                                        }
                                                        if ($_POST["OrdenRES"] == "2") {
                                                            echo lang("Descripcion");
                                                        }
                                                        if ($_POST["OrdenRES"] == "3") {
                                                            echo lang("Cantidad de Inventario");
                                                        }
                                                        if ($_POST["OrdenRES"] == "4") {
                                                            echo lang("Monto de Inventario");
                                                        }
                                                        if ($_POST["OrdenRES"] == "5") {
                                                            echo lang("Mayor Utilidad");
                                                        }
                                                        if ($_POST["OrdenRES"] == "6") {
                                                            echo lang("Mayor Venta");
                                                        }                               ?> </div>
                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php if ($_POST["CodigoDesdeLPRES"] == true) {
                                                                                                                                echo " " . lang("Desde el Codigo") . ":" . $_POST["CodigoDesdeLPRES"];
                                                                                                                            } ?> <?php if ($_POST["CodigoHastaLPRES"] == true) {
                                                                                                                                        echo "" . lang("al") . " " . $_POST["CodigoHastaLPRES"];
                                                                                                                                    } ?></div>
                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php
                                                                                                                            if ($fechaDES == true) {
                                                                                                                                echo $fechaDES . " " . lang("hasta") . " " . "";
                                                                                                                            }
                                                                                                                            if ($_POST["FechaHasta"] == true) {
                                                                                                                                echo $fechaHAS;
                                                                                                                            }
                                                                                                                            ?></div>
                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php if ($_POST["Familias2asd"] == "*" or $_POST["Familias2asd"] == "") {
                                                                                                                                echo "--------------------";
                                                                                                                            } else {
                                                                                                                                echo "";
                                                                                                                            } ?><?php
                                                                                                                                ?><?php if ($_POST["Familias2asd"] == "*" or $_POST["Familias2asd"] == "") {
                                                                                                                                    } else {
                                                                                                                                        $queryAlma2 = " SELECT IdVarios,ITEM FROM PosUpvarios WHERE TIPOITEM=2 and IdCompany " . $companygrp . "  and IdVarios=" . $_POST["Familias2asd"] . " ";
                                                                                                    