<?php
include "ambiente.php";
$conn = ConectarConsultas();
session_start();
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


$fechaHAS3 = $_POST["FechaHastares"];

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
        <?php echo lang("Reposición de Inventario"); ?>
    </title>
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
        font-size: 11px;

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
    <button class='ocultoimpresion ' onclick='document.getElementById(`formexcel`).submit()'><img src='/img/excel.png' width='28' height='28'><br>Reposición<br></button>
    <div class="pagina" style="font-size: 12px;">
        <div class="sup">
            <div style="float:left; width: 23%;">
                <div class="TituloEmpresa" id="Titulo">
                    <?php echo $_POST["NameCompany"]; ?>
                </div>
                <div class="Subtituloempresa" id="Ubicacion">
                    <?php echo $_POST["direccion"]; ?>
                </div>
                <div class="Subtituloempresa" id="Literal Fiscal">
                    <?php echo $_POST["litfiscal"]; ?>-<?php echo $_POST["rute"]; ?>
                </div>
            </div>
            <div style="float:left; width: 53%;">
                <div class="TituloEmpresa" style="float: center; text-align: center;">Reposición de Inventario</div>
                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">Orden por:
                    <?php
                    if ($_POST["OrdenRESres"] == "1") {
                        echo "Codigo";
                    }
                    if ($_POST["OrdenRESres"] == "2") {
                        echo "Descripcion";
                    }
                    if ($_POST["OrdenRESres"] == "3") {
                        echo "Referencia";
                    }
                    if ($_POST["OrdenRESres"] == "4") {
                        echo "Instancia";
                    }
                    ?>
                </div>
                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                    <?php if ($_POST["CodigoDesdeLPRESres"] == true) {
                        echo " Desde el Codigo:/" . $_POST["CodigoDesdeLPRESres"];
                    }
                    if ($_POST["CodigoHastaLPRESres"] == true) {
                        echo "Hasta el codigo:/" . $_POST["CodigoHastaLPRESres"];
                    } ?>
                </div>

                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                    <?php if ($_POST["FechaHastares"] == true) {
                        echo $fechaHAS;
                    } ?>
                </div>

                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                    <?php if ($_POST["MarcaLPUTA1res"] == true) {
                        echo "Marca:/" . $_POST["MarcaLPUTA2res"];
                    } ?>
                </div>

                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                    <?php if ($_POST["Familias2asdres"] == '*' and $_POST["AlmacenRESres"] == "*") {
                        echo "--------------------";
                    } else {
                        echo "Filtrado por:";
                    }
                    /*
 
                    if ($_POST["Familias2asdres"] == "*") {
                    } else {
                        $queryAlma2 = " SELECT IdVarios,ITEM FROM PosUpvarios WHERE TIPOITEM=2 and IdCompany " . $companygrp . " and IdVarios=" . $_POST["Familias2asdres"] . " ";
                        if ($resultqueryAlma2 = mysqli_query($conn, $queryAlma2)) {
                            while ($rowqueryAlma2 = mysqli_fetch_assoc($resultqueryAlma2)) {
                                echo " /Familia:" . $rowqueryAlma2["ITEM"];
                            }
                            mysqli_free_result($result2);
                        }
                    }

                    if ($_POST["AlmacenRESres"] !== "*") {
                        $queryAlma = "select IdAlm,Nombre FROM PosUpAlmacen WHERE IdCompany " . $companygrp . " and IdAlm=" . $_POST["AlmacenRESres"] . " ";
                        if ($resultqueryAlma = mysqli_query($conn, $queryAlma)) {
                            while ($rowqueryAlma = mysqli_fetch_assoc($resultqueryAlma)) {
                                echo "/Almacen:" . $rowqueryAlma["Nombre"] . " ";
                            }

                            mysqli_free_result($result);
                        }
                    } 
                    */

                    ?> </div>
                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                    <?php
                    if ($_POST["ExistenciaNULL"] == "on" or $_POST["referenciares"] == "on" or $_POST["SinM"] == "on") {
                        echo "Incluyendo:";
                    } else {
                        echo "--------------------";
                    }
                    if ($_POST["ExistenciaNULL"] == "on") {
                        echo " / Existencia Cero";
                    }
                    if ($_POST["referenciares"]) {
                        echo "/Productos con referencia";
                    }
                    if ($_POST["SinM"] == "on") {
                        echo "/Sin Movimientos";
                    }
                    ?>
                </div>
            </div>
            <div style="float:left; width: 23%;">
                <div class="FechaI"><span id="fectx">
                        <?php echo $_POST["fectx5"]; ?>
                    </span></div><br>
                <div class="FechaI">
                    <div class="page"></div>
                </div><br>
                <div class="FechaI"><img style="width: 30%;" src="img/AZUL.svg" /></div><br><br>
                <div class="FechaI">https://PosUp.cl Email: info@posup.cl</div>
            </div>
        </div>
        <div class="encabezado" style="">
            <div class="campo" style=" text-align: left; width: 7%; background-color: gray;">Codigo Barra</div>
            <div class="campo" style=" text-align: left; width: 6%; background-color: gray;">Codigo Basico</div>
            <div class="campo" style=" text-align: left; width: 7%; background-color: gray;">Codigo Ampliado</div>
            <div class="campo" style=" text-align: left; width: 24%; background-color: gray;">Descripcion</div>
            <?php
            if ($_POST["mexis"] == true) {
            ?>
                <div class="campo" style=" text-align: right; width: 10%; background-color: gray;">Existencia Actual </div>
            <?php
            }
            ?>

            <div class="campo" style=" text-align: right; width: 4%; background-color: gray;"> DS/Mov</div>
            <div class="campo" style=" text-align: right; width: 4%; background-color: gray;">E/Maxima </div>
            <div class="campo" style=" text-align: right; width: 4%; background-color: gray;">E/Minima </div>
            <div class="campo" style=" text-align: right; width: 5%; background-color: gray;">Pedido </div>
            <div class="campo" style=" text-align: right; width: 5%; background-color: gray;">Comprom </div>
            <div class="campo" style=" text-align: right; width: 5%; background-color: gray;">Diferencia </div>
            <div class="campo" style=" text-align: right; width: 5%; background-color: gray;">Faltante </div>
            <div class="campo" style=" text-align: right; width: 5%; background-color: gray;">Costo Actual </div>
            <div class="campo" style=" text-align: right; width: 5%; background-color: gray;">Costo Pedido </div>

        </div>
        <?php
        /*
        if ($_POST["CodigoDesdeLPRESres"] == true and $_POST["CodigoHastaLPRESres"] == true) {
            $beetween = "and a.CodIdAmpliado between '" . $_POST["CodigoDesdeLPRESres"] . "' and '" . $_POST["CodigoHastaLPRESres"] . "' ";
        }
        if ($_POST["CodigoDesdeLPRESres"] == true and $_POST["CodigoHastaLPRESres"] === false) {
            $beetween = "and a.CodIdAmpliado between '" . $_POST["CodigoDesdeLPRESres"] . "' and '" . $_POST["CodigoDesdeLPRESres"] . "' ";
        }
        if ($_POST["CodigoDesdeLPRESres"] === false and $_POST["CodigoHastaLPRESres"] == true) {
            $beetween = "and a.CodIdAmpliado between '" . $_POST["CodigoHastaLPRESres"] . "' and '" . $_POST["CodigoHastaLPRESres"] . "' ";
        }
        */

        if (!empty($_POST["mIdProductos"])) {
            $beetween = " and a.CodIdBasico in ('" . implode("','", $_POST["mIdProductos"]) . "') ";
        }

        if ($_POST["TransaccionXXXzzz"] !== '*') {
            $tipoTrans = " and bb.Idtipotx = '" . trim($_POST["TransaccionXXXzzz"]) . "'";
        }

        if (!empty($_POST["mIdAlmacen"])) {
            $almacenn = " and c.idal in ('" . implode("','", $_POST["mIdAlmacen"]) . "')";
        }

        if (!empty($_POST["mIdfamilia"])) {
            $familia = " and a.Idfamilia in ('" . implode("','", $_POST["mIdfamilia"]) . "') ";
        }

        if (!empty($_POST["mIdMarca"])) {
            $marca = "and a.Marca in ('" . implode("','", $_POST["mIdMarca"]) . "')";
        }

        if ($_POST["OrdenRESres"] == true) {
            if ($_POST["OrdenRESres"] == "1") {
                $Order = "Order by a.CodIdBasico";
            }

            if ($_POST["OrdenRESres"] == "2") {
                $Order = "Order by a.Descripcion";
            }

            if ($_POST["OrdenRESres"] == "3") {
                $Order = "Order by a.CodBarra";
            }

            if ($_POST["OrdenRESres"] == "4") {
                $Order = "Order by a.Idfamilia";
            }
        }

        if ($_POST["SinM"] == "on") {
            $SinM = " and c.cantidad <> 0";
        }
        if ($_POST["referenciares"] == "on") {
            $ConMov = " and a.CodBarra <> 0";
        }

        if ($_POST["mexis"] == true) {
            $mexis = "round(coalesce(c.cantidad,0),2) as ExisActual,";
            if (!$_POST["ExistenciaNULL"] == "on") {
                $ExisAct = "HAVING ExisActual<>0";
            }
        }
        if ($_POST['sucursal'] == '0') {
            $query = "SELECT a.CodIdAmpliado,a.CodIdBasico,a.CodBarra, a.Descripcion, " . $mexis . " c.Fectxclient,a.factorunit,a.Medida,
        (a.factorunit * round(coalesce(c.cantidad,0),2)) as CantX,
        a.Min as Minimo, coalesce(a.max,0) as Maximo,
        coalesce(c.cantidad,0) as Movimientos,
        round(coalesce(c.COrdCompras,0),2) as Pedido,
        round(coalesce(c.Comprometido,0),2) as Comprometido, 
        coalesce(round(coalesce(c.cantidad,0)+c.COrdCompras-c.Comprometido,2),0) as Diferencia,
        coalesce(round(a.max - (round(coalesce(c.cantidad,0),3)+c.COrdCompras-c.Comprometido),2),0) as Faltante, 
        round(a.Costo,2) as Costo, 
        coalesce(round(a.Costo,2)*round(a.max - (round(coalesce(c.cantidad,0),3)+c.COrdCompras-c.Comprometido),2),0) as CostaPedido
        FROM PosUpProducto a 
        left join (select ba.IdCompany, ba.CodIdBasico,ba.IdAlm as idal,ba.Fectxclient,
        sum(if(ba.Idtipotx=1,ba.Cant*bb.Inventario,0)) as cboletas,
        sum(if(ba.Idtipotx=2,ba.Cant*bb.Inventario,0)) as cfacturas,
        sum(if(ba.Idtipotx=3,ba.Cant*bb.Inventario,0)) as cdevolucion,
        sum(if(ba.Idtipotx=7,ba.Cant*bb.Inventario,0)) as Ccompras, 
        sum(if(ba.Idtipotx=8,ba.Cant*bb.Inventario,0)) as Cajustes,
        sum(if(ba.Idtipotx=9,ba.Cant*bb.Inventario,0)) as Ctraslados,
        sum(if(ba.Idtipotx=14,ba.Cant,0)) as COrdCompras,
        sum(if(ba.Idtipotx=11,ba.Cant,0)) as Comprometido,
        sum(if(ba.Idtipotx=10,ba.Cant*bb.Inventario,0)) as CTomas,
        sum(ba.Cant*bb.Inventario) as cantidad
        from PosUpTxD ba inner join PosUpTx bb on ba.Idtipotx = bb.Idtipotx 
        where ba.IdCompany " . $companygrp . " and ba.Fectxclient <='" . $fechaHAS3 . " 23:59:59'
        GROUP by ba.IdCompany,ba.CodIdBasico ) c on a.IdCompany = c.IdCompany and a.CodIdBasico = c.CodIdBasico 
        where a.IdCompany " . $companygrp . " AND a.EsCompuesto=0 and c.Fectxclient <='" . $fechaHAS3 . " 23:59:59'
        " . $almacenn . "
        " . $familia . "
        " . $marca . "
        " . $ConMov . "
        " . $SinM . "
        " . $beetween . "
        " . $ExisAct . "
        " . $Order . "
    ";
        } else {
            $query = "SELECT a.CodIdAmpliado,a.CodIdBasico,a.CodBarra, a.Descripcion, " . $mexis . " c.Fectxclient,a.factorunit,a.Medida,
        a.Min as Minimo, coalesce(a.max,0) as Maximo,
        (a.factorunit * round(coalesce(c.cantidad,0),2)) as CantX,
        coalesce(c.cantidad,0) as Movimientos,
        round(coalesce(c.COrdCompras,0),2) as Pedido,
        round(coalesce(c.Comprometido,0),2) as Comprometido, 
        coalesce(round(coalesce(c.cantidad,0)+c.COrdCompras-c.Comprometido,2),0) as Diferencia,
        coalesce(round(a.max - (round(coalesce(c.cantidad,0),3)+c.COrdCompras-c.Comprometido),2),0) as Faltante, 
        round(a.Costo,2) as Costo, 
        coalesce(round(a.Costo,2)*round(a.max - (round(coalesce(c.cantidad,0),3)+c.COrdCompras-c.Comprometido),2),0) as CostaPedido
        FROM PosUpProducto a 
        left join (select ba.IdCompany, ba.CodIdBasico,ba.IdAlm as idal,ba.Fectxclient,
        sum(if(ba.Idtipotx=1,ba.Cant*bb.Inventario,0)) as cboletas,
        sum(if(ba.Idtipotx=2,ba.Cant*bb.Inventario,0)) as cfacturas,
        sum(if(ba.Idtipotx=3,ba.Cant*bb.Inventario,0)) as cdevolucion,
        sum(if(ba.Idtipotx=7,ba.Cant*bb.Inventario,0)) as Ccompras, 
        sum(if(ba.Idtipotx=8,ba.Cant*bb.Inventario,0)) as Cajustes,
        sum(if(ba.Idtipotx=9,ba.Cant*bb.Inventario,0)) as Ctraslados,
        sum(if(ba.Idtipotx=14,ba.Cant,0)) as COrdCompras,
        sum(if(ba.Idtipotx=11,ba.Cant,0)) as Comprometido,
        sum(if(ba.Idtipotx=10,ba.Cant*bb.Inventario,0)) as CTomas,
        sum(ba.Cant*bb.Inventario) as cantidad
        from PosUpTxD ba inner join PosUpTx bb on ba.Idtipotx = bb.Idtipotx 
        inner join PosUpAlmacen z on ba.IdCompany=z.IdCompany and ba.IdAlm=z.IdAlm
        inner join PosUpAlmacen x on x.IdCompany=z.IdCompany and x.IdUbi=z.IdUbi
        where ba.IdCompany " . $companygrp . " and z.IdUbi=" . $_POST['sucursal'] . " and ba.Fectxclient <='" . $fechaHAS3 . " 23:59:59'  GROUP by ba.IdCompany,ba.CodIdBasico ) c on a.IdCompany = c.IdCompany and a.CodIdBasico = c.CodIdBasico 
        where a.IdCompany " . $companygrp . " AND a.EsCompuesto=0 and c.Fectxclient <='" . $fechaHAS3 . " 23:59:59'
        " . $almacenn . "
        " . $familia . "
        " . $marca . "
        " . $ConMov . "
        " . $SinM . "
        " . $beetween . "
        " . $ExisAct . "
        " . $Order . "
    ";
        }
        echo $query;
        if ($result = mysqli_query($conn, $query)) {
            $n = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                $nt = $nt + 1;
                $n = $n + 1;
        ?>
                <div style="text-align: left; float:left; width: 100%;">
                    <div class="campo" style=" text-align: left; width: 7%; ">
                        <?php echo (trim($row['CodBarra']) === "" ? "-" : $row['CodBarra']); ?>
                    </div>
                    <div class="campo" style=" text-align: left; width: 6%; ">
                        <?php echo (trim($row['CodIdBasico']) === "" ? "-" : $row['CodIdBasico']); ?>
                    </div>
                    <div class="campo" style=" text-align: left; width: 7%; ">
                        <?php echo (trim($row['CodIdAmpliado']) === "" ? "-" : $row['CodIdAmpliado']);  ?>
                    </div>
                    <div class="campo" style=" text-align: left; width: 24%; ">
                        <?php echo (trim($row['Descripcion']) === "" ? "-" : $row['Descripcion']);  ?>
                    </div>
                    <?php
                    if ($_POST["mexis"] == true) {
                    ?>
                        <div class="campo" style=" text-align: right; width: 10%; ">
                            <?php
                            if (trim($row["ExisActual"]) === "") {
                                echo "-";
                            } else {
                                echo ($row["factorunit"] <> 1 && $row["factorunit"] <> 0 ? " " . $row["factorunit"] . " x " . getcantformat($row["ExisActual"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " = " . getcantformat($row["CantX"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $row["Medida"] : number_format($row['ExisActual'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]));
                            }
                            ?>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="campo" style=" text-align: right; width: 4%; ">
                        <?php
                        if (trim($row['DsMov']) === "") {
                            echo "-";
                        } else {
                            echo $row["DsMov"];
                        }
                        ?>
                    </div>
                    <div class="campo" style=" text-align: right; width: 4%; ">
                        <?php
                        if (trim($row['Maximo']) === "") {
                            echo "-";
                        } else {
                            echo $row['Maximo'];
                        }
                        ?>
                    </div>

                    <div class="campo" style=" text-align: right; width: 4%; ">
                        <?php
                        if (trim($row['Minimo']) === "") {
                            echo "-";
                        } else {
                            echo $row["Minimo"];
                        }
                        ?>
                    </div>
                    <div class="campo" style=" text-align: right; width: 5%; ">
                        <?php
                        if (trim($row['Pedido']) === "") {
                            echo "-";
                        } else {
                            echo number_format($row['Pedido'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                        }
                        ?>
                    </div>
                    <div class="campo" style=" text-align: right; width: 5%; ">
                        <?php
                        if (trim($row['Comprometido']) === "") {
                            echo "-";
                        } else {
                            echo number_format($row['Comprometido'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                        }
                        ?>
                    </div>
                    <div class="campo" style=" text-align: right; width: 5%; ">
                        <?php
                        if (trim($row['Diferencia']) === "") {
                            echo "-";
                        } else {
                            echo number_format($row['Diferencia'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                        }
                        ?>
                    </div>
                    <div class="campo" style=" text-align: right; width: 5%; ">
                        <?php
                        if (trim($row['Faltante']) === "") {
                            echo "-";
                        } else {
                            echo number_format($row['Faltante'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                        }
                        ?>
                    </div>
                    <div class="campo" style=" text-align: right; width: 5%; ">
                        <?php
                        if (trim($row['Costo']) === "") {
                            echo "-";
                        } else {
                            echo number_format($row['Costo'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                        }
                        ?>
                    </div>

                    <div class="campo" style=" text-align: right; width: 5%; ">
                        <?php
                        if (trim($row['CostaPedido']) === "") {
                            echo "-";
                        } else {
                            echo number_format($row['CostaPedido'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                        }
                        ?>
                    </div>
                </div>
                <?php
                if ($n >= 54) {
                ?>


                    <div class="encabezado" style="font-size: 2px;">
                        <hr>
                    </div>
                    <div class="campo" style=" text-align: left; width: 24%; background-color: white;">Totales Registros</div>
                    <div class="campo" style=" text-align: left; width: 15%; background-color: white;">
                        <?php echo "Registro por Pagina=" . $n ?>
                    </div>
                    <div class="campo" style=" text-align: left; width: 15%; background-color: white;">
                        <?php echo "   Registro Total acumulado=" . $nt ?>
                    </div>


                    <div style="PAGE-BREAK-AFTER: always"></div>
                    <div class="campo" style=" visibility: hidden; text-align: right; width: 8%; background-color: white;">
                        <?php echo number_format($CostoExistencia2, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?>.</div>
                    <div class="sup">
                        <div style="float:left; width: 23%;">
                            <div class="TituloEmpresa" id="Titulo">
                                <?php echo $_POST["NameCompany"]; ?>
                            </div>
                            <div class="Subtituloempresa" id="Ubicacion">
                                <?php echo $_POST["direccion"]; ?>
                            </div>
                            <div class="Subtituloempresa" id="Literal Fiscal">
                                <?php echo $_POST["litfiscal"]; ?>-<?php echo $_POST["rute"]; ?>
                            </div>
                        </div>
                        <div style="float:left; width: 53%;">
                            <div class="TituloEmpresa" style="float: center; text-align: center;">Reposición de Inventario</div>
                            <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">Orden por:
                                <?php
                                if ($_POST["OrdenRESres"] == "1") {
                                    echo "Codigo";
                                }
                                if ($_POST["OrdenRESres"] == "2") {
                                    echo "Descripcion";
                                }
                                if ($_POST["OrdenRESres"] == "3") {
                                    echo "Referencia";
                                }
                                if ($_POST["OrdenRESres"] == "4") {
                                    echo "Instancia";
                                }
                                ?>
                            </div>
                            <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                                <?php
                                if ($_POST["CodigoDesdeLPRESres"] == true) {
                                    echo " Desde el Producto:" . $_POST["CodigoDesdeLPRESres"];
                                }

                                if ($_POST["CodigoHastaLPRESres"] == true) {
                                    echo "al " . $_POST["CodigoHastaLPRESres"];
                                }
                                ?>
                            </div>

                            <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                                <?php
                                if ($_POST["FechaHastares"] == true) {
                                    echo $fechaHAS;
                                }
                                ?>
                            </div>
                            <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                                <?php if ($_POST["MarcaLPUTA1res"] == true) {
                                    echo "Marca:/" . $_POST["MarcaLPUTA2res"];
                                }
                                ?>
                            </div>

                            <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                                <?php
                                if ($_POST["Familias2asdres"] == '*' and $_POST["AlmacenRESres"] == "*") {
                                    echo "--------------------";
                                } else {
                                    echo "Filtrado por:";
                                }
                                if ($_POST["Familias2asdres"] !== "*") {
                                    $queryAlma2 = " SELECT IdVarios,ITEM FROM PosUpvarios WHERE TIPOITEM=2 and IdCompany " . $companygrp . " and IdVarios=" . $_POST["Familias2asdres"] . " ";
                                    if ($resultqueryAlma2 = mysqli_query($conn, $queryAlma2)) {
                                        while ($rowqueryAlma2 = mysqli_fetch_assoc($resultqueryAlma2)) {
                                            echo " /Familia:" . $rowqueryAlma2["ITEM"];
                                        }

                                        mysqli_free_result($result2);
                                    }
                                }
                                if ($_POST["AlmacenRESres"] !== "*") {
                                    $queryAlma = "select IdAlm,Nombre FROM PosUpAlmacen WHERE IdCompany " . $companygrp . " and IdAlm=" . $_POST["AlmacenRESres"] . " ";
                                    if ($resultqueryAlma = mysqli_query($conn, $queryAlma)) {
                                        while ($rowqueryAlma = mysqli_fetch_assoc($resultqueryAlma)) {
                                            echo "/Almacen:" . $rowqueryAlma["Nombre"] . " ";
                                        }

                                        mysqli_free_result($result);
                                    }
                                }
                                ?>
                            </div>
                            <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                                <?php
                                if ($_POST["ExistenciaNULL"] == "on" or $_POST["referenciares"] == "on" or $_POST["SinM"] == "on") {
                                    echo "Incluyendo:";
                                } else {
                                    echo "--------------------";
                                }
                                if ($_POST["ExistenciaNULL"] == "on") {
                                    echo " / Existencia Cero";
                                }
                                if ($_POST["referenciares"]) {
                                    echo "/Productos con referencia";
                                }
                                if ($_POST["SinM"] == "on") {
                                    echo "/Sin Movimientos";
                                }
                                ?>
                            </div>
                        </div>
                        <div style="float:left; width: 23%;">
                            <div class="FechaI"><span id="fectx">
                                    <?php echo $_POST["fectx5"]; ?>
                                </span></div><br>
                            <div class="FechaI">
                                <div class="page"></div>
                            </div><br>
                            <div class="FechaI"><img style="width: 30%;" src="img/AZUL.svg" /></div><br><br>
                            <div class="FechaI">https://PosUp.cl Email: info@posup.cl</div>
                        </div>
                    </div>
                    <div class="encabezado" style="">
                        <div class="campo" style=" text-align: left; width: 7%; background-color: gray;">Codigo Barra</div>
                        <div class="campo" style=" text-align: left; width: 6%; background-color: gray;">Codigo Basico</div>
                        <div class="campo" style=" text-align: left; width: 7%; background-color: gray;">Codigo Ampliado</div>
                        <div class="campo" style=" text-align: left; width: 24%; background-color: gray;">Descripcion</div>
                        <?php
                        if ($_POST["mexis"] == true) {
                        ?>
                            <div class="campo" style=" text-align: right; width: 7%; background-color: gray;">Existencia Actual </div>
                        <?php
                        }
                        ?>
                        <div class="campo" style=" text-align: right; width: 5%; background-color: gray;"> DS/Mov</div>
                        <div class="campo" style=" text-align: right; width: 5%; background-color: gray;">E/Maxima </div>
                        <div class="campo" style=" text-align: right; width: 5%; background-color: gray;">E/Minima </div>
                        <div class="campo" style=" text-align: right; width: 5%; background-color: gray;">Pedido </div>
                        <div class="campo" style=" text-align: right; width: 5%; background-color: gray;">Comprom </div>
                        <div class="campo" style=" text-align: right; width: 5%; background-color: gray;">Diferencia </div>
                        <div class="campo" style=" text-align: right; width: 5%; background-color: gray;">Faltante </div>
                        <div class="campo" style=" text-align: right; width: 5%; background-color: gray;">Costo Actual </div>
                        <div class="campo" style=" text-align: right; width: 5%; background-color: gray;">Costo Pedido </div>

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
        ?>
        <div class="encabezado" style="font-size: 2px;">
            <hr>
            <div class="campo" style=" visibility: hidden; text-align: left; width: 9%; background-color: white;">Troductos</div>

            <div class="campo" style=" text-align: left; width: 24%; background-color: white;">Totales Registros</div>
            <div class="campo" style=" text-align: left; width: 15%; background-color: white;">
                <?php echo "Registro por Pagina=" . $n ?>
            </div>
            <div class="campo" style=" text-align: left; width: 15%; background-color: white;">
                <?php echo "   Registro Total acumulado=" . $nt ?>
            </div>

        </div>
    </div>
    <div style="PAGE-BREAK-AFTER: always; visibility: hidden;">a</div>


    <form id="formexcel" action="excelnew.php" method="post">
        <?php
        $compa = $_POST["CompanyActual"];
        $name = lang("Reposicion");
        ?>
        <?php if ($_POST['mexist'] == true) { ?>
            <input type="hidden" name="check01" id="check01" value="1" />
        <?php } ?>
        <input type="hidden" name="Query" id="Query" value="<?php echo $query; ?>" />
        <input type="hidden" name="Name" id="Name" value="<?php echo $name; ?>" />
        <input type="hidden" name="SimDec" id="SimDec" value="<?php echo $_POST['SimDec']; ?>" />
        <input type="hidden" name="SimMil" id="SimMil" value="<?php echo $_POST['SimMil']; ?>" />
        <input type="hidden" name="CD" id="CD" value="<?php echo $_POST['CD']; ?>" />
        <input type="hidden" name="CompanyActual" id="CompanyActual" value="<?php echo $_POST['CompanyActual']; ?>" />
        <input type="hidden" name="vas" id="vas" value="Reposicion" />
    </form>
    <form id="formexceel" action="excelv3led.php" method="post">
        <?php
        $compa = $_POST["CompanyActual"];
        $name = "Reposicion.csv";
        ?>

        <input type="hidden" name="registro" id="registro" value="<?php echo $pro2; ?>" />
        <input type="hidden" name="Qry" id="Qry" value="<?php echo $query; ?>" />
        <input type="hidden" name="Name" id="Name" value="<?php echo $name; ?>" />
        <input type="hidden" name="Company" id="Company" value="<?php echo $compa; ?>" />
        <input type="hidden" name="ser" id="ser" value="" />
    </form>

</body>
<script>
    const totalPages = document.querySelectorAll('.page').length;
    document.documentElement.style.setProperty('--total-pages', totalPages);
</script>

</html>