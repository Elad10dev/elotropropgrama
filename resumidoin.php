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
                                                                                                                                        if ($resultqueryAlma2 = mysqli_query($conn, $queryAlma2)) {
                                                                                                                                            while ($rowqueryAlma2 = mysqli_fetch_assoc($resultqueryAlma2)) {
                                                                                                                                                echo " Familia: " . $rowqueryAlma2["ITEM"];
                                                                                                                                            }

                                                                                                                                            mysqli_free_result($resultqueryAlma2);
                                                                                                                                        }
                                                                                                                                    } ?> </div>

                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php if ($_POST["ProductosInv"] == "on" or $_POST["ProductosMov"] == "on") {
                                                                                                                                echo "" . lang("Incluyendo") . ":";
                                                                                                                            } else {
                                                                                                                                echo "--------------------";
                                                                                                                            } ?> <?php if ($_POST["ProductosInv"] == "on") {
                                                                                                                                        echo "" . lang("Productos con Inventario") . " ";
                                                                                                                                    }
                                                                                                                                    if ($_POST["ProductosMov"]) {
                                                                                                                                        echo " " . lang("Productos con Movimiento") . "";
                                                                                                                                    } ?> </div>

            </div>
            <div style="float:left; width: 23%;">
                <div class="FechaI"><span id="fectx"><?php echo $_POST["fectx5"]; ?></span></div><br>
                <div class="FechaI">
                    <div class="page"></div>
                </div><br>
                <div class="FechaI"><img style="width: 30%;" src="img/AZUL.svg" /></div><br><br>
                <div class="FechaI">https://PosUp.cl Email: info@posup.cl</div>
            </div>
        </div>

        <div class="encabezado">
            <div class="campo" style=" text-align: left; width: 100%; font-size:7.5px;"><strong><?php echo  $idk; ?></strong></div>
        </div>
        <div class="encabezado">
            <div class="campo" style=" text-align: left; width: 30.7%; visibility:hidden">.</div>
            <div class="campo" style="text-align: left; width: 14.47%; background-color: gray;"><?php echo lang("Afecta Venta"); ?></div>
            <div class="campo" style="text-align: left; width: 10.9%; background-color: gray;"><?php echo lang("Afecta Compras"); ?></div>
            <div class="campo" style="text-align: left; width: 25.6%; background-color: gray;"><?php echo lang("Operaciones de inventario"); ?></div>
            <div class="campo" style="text-align: left; width: 4.3%; background-color: gray; visibility:hidden">E </div>
            <div class="campo" style="text-align: left; width: 7.1%; background-color: gray;"><?php echo lang("En tránsito"); ?> </div>
        </div>
        <?php $br = "";  ?>
        <div class="encabezado" style="">
            <div class="campo" style=" text-align: left; width: 6.5%; background-color: gray;"><?php echo lang("Código Barra"); ?></div>
            <div class="campo" style=" text-align: left; width: 6%; background-color: gray;"><?php echo lang("S.K.U"); ?></div>
            <div class="campo" style=" text-align: left; width: 13%; background-color: gray;"><?php echo lang("Descripción"); ?></div>
            <div class="campo" style=" text-align: right; width: 4.5%; background-color: gray;"><?php echo lang("Inv. Inicial"); ?></div>
            <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"> <?php echo $br . $bol . '/' . $fac; ?> </div>
            <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"> <?php echo $br . $gde; ?></div>
            <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo $br . $dev; ?> </div>
            <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo $br . $nte; ?></div>
            <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo $br . $com; ?> </div>
            <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo $br . $gdc; ?></div>
            <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo $br . $dec; ?> </div>
            <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"> <?php echo $br . $mov; ?></div>
            <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo $br . $car; ?> </div>
            <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"> <?php echo $br . $des; ?></div>
            <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo $br . $aj; ?> </div>
            <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"> <?php echo $br . $tom; ?></div>
            <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"> <?php echo $br . $mov2; ?></div>
            <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"> <?php echo $br . $pro; ?></div>
            <div class="campo" style=" text-align: right; width: 4.5%; background-color: gray;"><?php echo lang("Inv. Final"); ?> </div>
            <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo $br . $oc; ?> </div>
            <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo $br . $ped; ?></div>
            <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo lang("T.Final"); ?></div>
        </div>
        <?php
        if (!empty($_POST["mIdProductos"])) {
            $beetween = " and a.CodIdBasico in ('" . implode("','", $_POST["mIdProductos"]) . "') ";
        }
        if ($_POST["ProductosInv"] == "on") {  /// producstos con inventario lalsad
            $ConInv = "and round(coalesce(b.cantidad,0),2)+round(coalesce(c.cantidad,0),2)>0";
        }

        if (!empty($_POST["mIdAlmacen"])) {
            $Almacen23 = " and ba.IdAlm in ('" . implode("','", $_POST["mIdAlmacen"]) . "')";
        }

        $familia = '';

        if (!empty($_POST["mIdfamilia"])) {
            $familia = " and a.Idfamilia in ('" . implode("','", $_POST["mIdfamilia"]) . "') ";
        }
        if ($_POST["ProductosMov"] == "on") {
            $ConMov = " and (c.cguiav <> 0 or c.cdevolucion  <> 0 or c.NotaEntrega  <> 0 or  c.Ccompras  <> 0 or c.CGcompras  <> 0 or c.CDevcompra  <> 0 or c.Ctraslados  <> 0 or c.CCargos  <> 0 or c.CDescargos  <> 0 or  c.Cajustes  <> 0 or c.CTomas  <> 0 or  c.Movimiento  <> 0 or c.CProduccion <> 0 or coalesce(c.cboletas,0)+coalesce(c.cfacturas,0) <> 0)";
        }
        if ($_POST["OrdenRES"] == true) {
            if ($_POST["OrdenRES"] == "1") {
                $OrdenBy = " order by a.CodIdAmpliado";
            }
            if ($_POST["OrdenRES"] == "2") {
                $OrdenBy = " order by a.Descripcion";
            }
            if ($_POST["OrdenRES"] == "3") {
                $OrdenBy = " order by  round(coalesce(b.cantidad,0),2)+round(coalesce(c.cantidad,0),2) ASC";
            }

            if ($_POST["OrdenRES"] == "6") {
                $OrdenBy = "order by coalesce(c.cboletas,0)+coalesce(c.cfacturas,0) ASC";
            }
        }


        $query = "select
        a.CodBarra,
        a.CodIdAmpliado,
        c.tipox as tipox,
        a.Descripcion,
        coalesce(b.cantidad, 0) as InventarioInicial,
        coalesce(c.cboletas, 0)+ coalesce(c.cfacturas, 0) as Ventas,
        coalesce(c.cguiav, 0) as Guias,
        round(coalesce(c.cdevolucion, 0), 2) as Devolucion,
        round(coalesce(c.NotaEntrega, 0), 2) as NotaEntrega,
        round(coalesce(c.Ccompras, 0), 2) as Compras,
        round(coalesce(c.CGcompras, 0), 2) as GuiasCompras,
        round(coalesce(c.CDevcompra, 0), 2) as DevCompras,
        round(coalesce(c.Ctraslados, 0), 2) as Traslados,
        round(coalesce(c.CCargos, 0), 2) as Cargos,
        round(coalesce(c.CDescargos, 0), 2) as Descargos,
        round(coalesce(c.Cajustes, 0), 2) as Ajustes,
        round(coalesce(c.CTomas, 0), 2) as Tomas,
        round(coalesce(c.Movimiento, 0), 2) as Movimiento,
        round(coalesce(c.CProduccion, 0), 2) as Produccion,
        round(coalesce(b.cantidad, 0), 2)+ round(coalesce(c.cantidad, 0), 2) as InventarioFinal,
        coalesce(d.COcompra , 0) as Ocompra,
        coalesce(d.CPedidos , 0) as Pedidos
    from
        PosUpProducto a
    left join (select
		IdCompany,
		CodIdBasico,
		sum(Cantidad) as Cantidad
	from
		(
		select
			ba.IdCompany,
			ba.CodIdBasico,
			sum(ba.Cant * bb.Inventario) as Cantidad
		from
			PosUpTxD ba
		left join PosUpTx bb on
			ba.Idtipotx = bb.Idtipotx
		where
            ba.IdCompany " . $companygrp . "
            and ba.Fectxclient < '" . $fechaDES . " 00:00:00' 
            " . (!empty($_POST["mIdAlmacen"]) ? " and ba.IdAlm in ('" . implode("','", $_POST["mIdAlmacen"]) . "')" : "") . "
     	group by
			ba.IdCompany,
			ba.CodIdBasico) bpre
	group by
		IdCompany,
		CodIdBasico ) b on
	a.IdCompany = b.IdCompany
	and a.CodIdBasico = b.CodIdBasico
left join (
        select
            ba.IdCompany,
            ba.CodIdBasico,
            sum(if(ba.Idtipotx = 1, ba.Cant * bb.Inventario, 0)) as cboletas,
            sum(if(ba.Idtipotx = 2, ba.Cant * bb.Inventario, 0)) as cfacturas,
            sum(if(ba.Idtipotx = 3, ba.Cant * bb.Inventario, 0)) as cdevolucion,
            sum(if(ba.Idtipotx = 7, ba.Cant * bb.Inventario, 0)) as Ccompras,
            sum(if(ba.Idtipotx = 8, ba.Cant * bb.Inventario, 0)) as Cajustes,
            sum(if(ba.Idtipotx = 9, ba.Cant * bb.Inventario, 0)) as Movimiento,
            sum(if(ba.Idtipotx = 10, ba.Cant * bb.Inventario, 0)) as CTomas,
            sum(if(ba.Idtipotx = 15, ba.Cant * bb.Inventario, 0)) as NotaEntrega,
            sum(if(ba.Idtipotx = 17, ba.Cant * bb.Inventario, 0)) as Ctraslados,
            sum(if(ba.Idtipotx = 18, ba.Cant * bb.Inventario, 0)) as CCargos,
            sum(if(ba.Idtipotx = 19, ba.Cant * bb.Inventario, 0)) as CDescargos,
            sum(if(ba.Idtipotx = 22, ba.Cant * bb.Inventario, 0)) as cguiav,
            sum(if(ba.Idtipotx = 27, ba.Cant * bb.Inventario, 0)) as CDevcompra,
            sum(if(ba.Idtipotx = 28, ba.Cant * bb.Inventario, 0)) as CGcompras,
            sum(if(ba.Idtipotx = 30, ba.Cant * bb.Inventario, 0)) as CProduccion,
            ba.Idtipotx as tipox,
            sum(ba.Cant * bb.Inventario) as cantidad
        from
            PosUpTxD ba
        left join PosUpTx bb on
            ba.Idtipotx = bb.Idtipotx
        where
            ba.IdCompany " . $companygrp . "
            and ba.Fectxclient >= '" . $fechaDES . " 00:00:00' and ba.Fectxclient <= '" . ((new DateTime($fechaHAS))->modify('+1 day'))->format('Y-m-d') . " 00:00:00'
            " . (!empty($_POST["mIdAlmacen"]) ? " and ba.IdAlm in ('" . implode("','", $_POST["mIdAlmacen"]) . "')" : "") . "
        group by
            ba.IdCompany,
            ba.CodIdBasico ) c on
        a.IdCompany = c.IdCompany
        and a.CodIdBasico = c.CodIdBasico
    left join (
        select
            ba.IdCompany,
            ba.CodIdBasico,
            sum(if(ba.Idtipotx = 14, ba.Cant * bb.CompInv, 0)) as COcompra,
            sum(if(ba.Idtipotx = 11, ba.Cant * bb.Inventario, 0)) as CPedidos
        from
            PosUpTxD ba
        inner join PosUpTx bb on
            ba.Idtipotx = bb.Idtipotx
        where
            ba.IdCompany " . $companygrp . " and ba.idtipotx in (14,11)
        group by
            ba.IdCompany,
            ba.CodIdBasico ) d on
        a.IdCompany = d.IdCompany
        and a.CodIdBasico = d.CodIdBasico
    where
        a.IdCompany " . $companygrp . " 
        " . $beetween . "
        " . $familia . "
        " . $ConInv . "
        " . $ConMov . " 
        " . $OrdenBy . " 
   ";
        if ($result = mysqli_query($conn, $query)) {
            $n = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                $n = $n + 1;
                $nt = $nt + 1;

                if ($color == 0) {
                    $color = 1;
                } else {
                    $color = 0;
                }
        ?>
                <div style="text-align: left; float:left; width: 100%; <?php echo ($color == 0 ? "" : "background: #EDECEC;"); ?> ">
                    <div class="campo" style=" text-align: left; width: 6.5%; "><?php if ($row['CodBarra'] == "") {
                                                                                    echo "-";
                                                                                } else {
                                                                                    echo $row['CodBarra'];
                                                                                } ?>&nbsp;</div>
                    <div class="campo" style=" text-align: left; width: 6%; "><?php if ($row['CodIdAmpliado'] == "") {
                                                                                    echo "-";
                                                                                } else {
                                                                                    echo $row['CodIdAmpliado'];
                                                                                } ?>&nbsp;</div>
                    <div class="campo" style=" text-align: left; width: 13%; "><?php if ($row['Descripcion'] == "") {
                                                                                    echo "-";
                                                                                } else {
                                                                                    echo $row['Descripcion'];
                                                                                } ?>&nbsp;</div>

                    <div class="campo" style=" text-align: right; width: 4.5%; ">&nbsp;<?php if ($row['InventarioInicial'] == "") {
                                                                                            echo "-";
                                                                                        } else {
                                                                                            echo number_format($row['InventarioInicial'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                        } ?></div>
                    <div class="campo" style=" text-align: right; width: 3.45%; ">&nbsp;<?php if ($row['Ventas'] == "") {
                                                                                            echo "-";
                                                                                        } else {
                                                                                            echo number_format($row["Ventas"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                        } ?>
                    </div>
                    <div class="campo" style=" text-align: right; width: 3.45%; ">&nbsp;<?php echo number_format($row['Guias'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></div>
                    <div class="campo" style=" text-align: right; width: 3.45%; ">&nbsp;<?php if ($row['Devolucion'] == "") {
                                                                                            echo "-";
                                                                                        } else {
                                                                                            echo number_format($row['Devolucion'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                        }
                                                                                        ?></div>
                    <div class="campo" style=" text-align: right; width: 3.45%; ">&nbsp;<?php if ($row['NotaEntrega'] == "") {
                                                                                            echo "-";
                                                                                        } else {
                                                                                            echo number_format($row['NotaEntrega'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                        } ?></div>


                    <div class="campo" style=" text-align: right; width: 3.45%; ">&nbsp;<?php if ($row['Compras'] == "") {
                                                                                            echo "-";
                                                                                        } else {
                                                                                            echo number_format($row['Compras'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                        } ?></div>
                    <div class="campo" style=" text-align: right; width: 3.45%; ">&nbsp;<?php if ($row['GuiasCompras'] == "") {
                                                                                            echo "-";
                                                                                        } else {
                                                                                            echo number_format($row['GuiasCompras'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                        } ?></div>
                    <div class="campo" style=" text-align: right; width: 3.45%; ">&nbsp;<?php if ($row['DevCompras'] == "") {
                                                                                            echo "-";
                                                                                        } else {
                                                                                            echo number_format($row['DevCompras'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                        } ?></div>
                    <div class="campo" style=" text-align: right; width: 3.45%; ">&nbsp;<?php if ($row['Traslados'] == "") {
                                                                                            echo "-";
                                                                                        } else {
                                                                                            echo number_format($row['Traslados'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                        } ?></div>

                    <div class="campo" style=" text-align: right; width: 3.45%; ">&nbsp;<?php if ($row['Cargos'] == "") {
                                                                                            echo "-";
                                                                                        } else {
                                                                                            echo number_format($row['Cargos'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                        } ?></div>
                    <div class="campo" style=" text-align: right; width: 3.45%; ">&nbsp;<?php if ($row['Descargos'] == "") {
                                                                                            echo "-";
                                                                                        } else {
                                                                                            echo number_format($row['Descargos'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                        } ?></div>
                    <div class="campo" style=" text-align: right; width: 3.45%; ">&nbsp;<?php if ($row['Ajustes'] == "") {
                                                                                            echo "-";
                                                                                        } else {
                                                                                            echo
                                                                                            number_format($row['Ajustes'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                        } ?></div>
                    <div class="campo" style=" text-align: right; width: 3.45%; ">&nbsp;<?php if ($row['Tomas'] == "") {
                                                                                            echo "-";
                                                                                        } else {
                                                                                            echo number_format($row['Tomas'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                        } ?></div>
                    <div class="campo" style=" text-align: right; width: 3.45%; ">&nbsp;<?php if ($row['Movimiento'] == "") {
                                                                                            echo "-";
                                                                                        } else {
                                                                                            echo number_format($row['Movimiento'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                        } ?></div>
                    <div class="campo" style=" text-align: right; width: 3.45%; ">&nbsp;<?php if ($row['Produccion'] == "") {
                                                                                            echo "-";
                                                                                        } else {
                                                                                            echo number_format($row['Produccion'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                        } ?></div>

                    <div class="campo" style=" text-align: right; width: 4.5%; ">&nbsp;<?php if ($row['InventarioFinal'] == "") {
                                                                                            echo "-";
                                                                                        } else {
                                                                                            echo number_format($row['InventarioFinal'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                        } ?></div>

                    <div class="campo" style=" text-align: right; width: 3.45%; ">&nbsp;<?php if ($row['Ocompra'] == "") {
                                                                                            echo "-";
                                                                                        } else {
                                                                                            echo number_format($row['Ocompra'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                        } ?></div>

                    <div class="campo" style=" text-align: right; width: 3.45%; ">&nbsp;<?php if ($row['Pedidos'] == "") {
                                                                                            echo "-";
                                                                                        } else {
                                                                                            echo number_format($row['Pedidos'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                        } ?></div>


                    <div class="campo" style=" text-align: right; width: 3.45%; ">&nbsp;<?php
                                                                                        $finally = $row['Pedidos'] + $row['Ocompra'] + $row['InventarioFinal'];
                                                                                        echo number_format($finally, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);


                                                                                        ?></div>
                </div> <?php
                        $unidadTotal = $unidadTotal + $row["unidad"];
                        $ExistenciaTotal = $ExistenciaTotal + $row["Cantidad"];
                        if ($n >= 40) { ?>

                    <div style="PAGE-BREAK-AFTER: always"></div>

                    <div class="encabezado">
                        <div class="campo" style=" text-align: left; width: 100%; font-size:7.5px;"><strong><?php echo  $idk; ?></strong></div>
                    </div>
                    <div class="encabezado">
                        <div class="campo" style=" text-align: left; width: 30.7%; visibility:hidden">.</div>
                        <div class="campo" style="text-align: left; width: 14.47%; background-color: gray;"><?php echo lang("Afecta Venta"); ?></div>
                        <div class="campo" style="text-align: left; width: 10.9%; background-color: gray;"><?php echo lang("Afecta Compras"); ?></div>
                        <div class="campo" style="text-align: left; width: 25.6%; background-color: gray;"><?php echo lang("Operaciones de inventario"); ?></div>
                        <div class="campo" style="text-align: left; width: 4.3%; background-color: gray; visibility:hidden">E </div>
                        <div class="campo" style="text-align: left; width: 7.1%; background-color: gray;"><?php echo lang("En tránsito"); ?> </div>
                    </div>
                    <?php $br = "";  ?>
                    <div class="encabezado" style="">
                        <div class="campo" style=" text-align: left; width: 6.5%; background-color: gray;"><?php echo lang("Código Barra"); ?></div>
                        <div class="campo" style=" text-align: left; width: 6%; background-color: gray;"><?php echo lang("S.K.U"); ?></div>
                        <div class="campo" style=" text-align: left; width: 13%; background-color: gray;"><?php echo lang("Descripción"); ?></div>
                        <div class="campo" style=" text-align: right; width: 4.5%; background-color: gray;"><?php echo lang("Inv. Inicial"); ?></div>
                        <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"> <?php echo $br . $bol . '/' . $fac; ?> </div>
                        <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"> <?php echo $br . $gde; ?></div>
                        <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo $br . $dev; ?> </div>
                        <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo $br . $nte; ?></div>
                        <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo $br . $com; ?> </div>
                        <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo $br . $gdc; ?></div>
                        <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo $br . $dec; ?> </div>
                        <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"> <?php echo $br . $mov; ?></div>
                        <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo $br . $car; ?> </div>
                        <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"> <?php echo $br . $des; ?></div>
                        <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo $br . $aj; ?> </div>
                        <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"> <?php echo $br . $tom; ?></div>
                        <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"> <?php echo $br . $mov2; ?></div>
                        <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"> <?php echo $br . $pro; ?></div>
                        <div class="campo" style=" text-align: right; width: 4.5%; background-color: gray;"><?php echo lang("Inv. Final"); ?> </div>
                        <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo $br . $oc; ?> </div>
                        <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo $br . $ped; ?></div>
                        <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo lang("T.Final"); ?></div>
                    </div>
        <?php
                            $CostoExistencia = 0;
                            $unidadTotal = 0;
                            $ExistenciaTotal = 0;
                            $n = 0;
                        }
                    }
                    mysqli_free_result($result);
                } else {
                    echo mysqli_error($conn);
                }
        ?>


    </div>
    </div>
    <div style="PAGE-BREAK-AFTER: always; visibility: hidden;">a</div>

    <form id="formexcel" action="excelnew.php" method="post">
        <?php
        $compa = $_POST["CompanyActual"];
        $name = lang("MovimientoResumido");
        ?>

        <input type="hidden" name="Query" id="Query" value="<?php echo $query; ?>" />
        <input type="hidden" name="Name" id="Name" value="<?php echo $name; ?>" />
        <input type="hidden" name="SimDec" id="SimDec" value="<?php echo $_POST['SimDec']; ?>" />
        <input type="hidden" name="SimMil" id="SimMil" value="<?php echo $_POST['SimMil']; ?>" />
        <input type="hidden" name="CD" id="CD" value="<?php echo $_POST['CD']; ?>" />
        <input type="hidden" name="CompanyActual" id="CompanyActual" value="<?php echo $_POST['CompanyActual']; ?>" />
        <input type="hidden" name="vas" id="vas" value="MovimientoResumido" />
    </form>
    <form id="formexceel" action="excelv3led.php" method="post">
        <?php
        ?>
        <?php
        $compa = $_POST["CompanyActual"];
        $name = lang("MovimientoResumido") . ".csv";
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
<?
/*
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
$companygrp = " = " . $_POST["CompanyActual"] . " ";
}
if (trim($_POST["sucursal"]) == '') {
$_POST['sucursal'] = $_POST["sucursal"];
}

$queryz = "SELECT GROUP_CONCAT(DISTINCT concat('(',TitCto,')=',Titulo)
ORDER BY TitCto ASC SEPARATOR ' ') as tx from PosUpTx where Inventario <> 0 or CompInv<>0";
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

            .pie {}
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
                                                                                                                                    if ($_POST["DesdeFecha"] == true) {
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
                                                                                                                                        if ($resultqueryAlma2 = mysqli_query($conn, $queryAlma2)) {
                                                                                                                                            while ($rowqueryAlma2 = mysqli_fetch_assoc($resultqueryAlma2)) {
                                                                                                                                                echo " Familia: " . $rowqueryAlma2["ITEM"];
                                                                                                                                            }

                                                                                                                                            mysqli_free_result($resultqueryAlma2);
                                                                                                                                        }
                                                                                                                                    } ?> </div>

                        <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php if ($_POST["ProductosInv"] == "on" or $_POST["ProductosMov"] == "on") {
                                                                                                                                        echo "" . lang("Incluyendo") . ":";
                                                                                                                                    } else {
                                                                                                                                        echo "--------------------";
                                                                                                                                    } ?> <?php if ($_POST["ProductosInv"] == "on") {
                                                                                                                                        echo "" . lang("Productos con Inventario") . " ";
                                                                                                                                    }
                                                                                                                                    if ($_POST["ProductosMov"]) {
                                                                                                                                        echo " " . lang("Productos con Movimiento") . "";
                                                                                                                                    } ?> </div>

                    </div>
                    <div style="float:left; width: 23%;">
                        <div class="FechaI"><span id="fectx"><?php echo $_POST["fectx5"]; ?></span></div><br>
                        <div class="FechaI">
                            <div class="page"></div>
                        </div><br>
                        <div class="FechaI"><img style="width: 30%;" src="img/AZUL.svg" /></div><br><br>
                        <div class="FechaI">https://PosUp.cl Email: info@posup.cl</div>
                    </div>
                </div>

                <div class="encabezado">
                    <div class="campo" style=" text-align: left; width: 100%; font-size:7.5px;"><strong><?php echo  $idk; ?></strong></div>
                </div>
                <div class="encabezado">
                    <div class="campo" style=" text-align: left; width: 30.7%; visibility:hidden">.</div>
                    <div class="campo" style="text-align: left; width: 14.47%; background-color: gray;"><?php echo lang("Afecta Venta"); ?></div>
                    <div class="campo" style="text-align: left; width: 10.9%; background-color: gray;"><?php echo lang("Afecta Compras"); ?></div>
                    <div class="campo" style="text-align: left; width: 25.6%; background-color: gray;"><?php echo lang("Operaciones de inventario"); ?></div>
                    <div class="campo" style="text-align: left; width: 4.3%; background-color: gray; visibility:hidden">E </div>
                    <div class="campo" style="text-align: left; width: 7.1%; background-color: gray;"><?php echo lang("En tránsito"); ?> </div>
                </div>
                <?php $br = "";  ?>
                <div class="encabezado" style="">
                    <div class="campo" style=" text-align: left; width: 6.5%; background-color: gray;"><?php echo lang("Código Barra"); ?></div>
                    <div class="campo" style=" text-align: left; width: 6%; background-color: gray;"><?php echo lang("S.K.U"); ?></div>
                    <div class="campo" style=" text-align: left; width: 13%; background-color: gray;"><?php echo lang("Descripción"); ?></div>
                    <div class="campo" style=" text-align: right; width: 4.5%; background-color: gray;"><?php echo lang("Inv. Inicial"); ?></div>
                    <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"> <?php echo $br . $bol . '/' . $fac; ?> </div>
                    <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"> <?php echo $br . $gde; ?></div>
                    <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo $br . $dev; ?> </div>
                    <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo $br . $nte; ?></div>
                    <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo $br . $com; ?> </div>
                    <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo $br . $gdc; ?></div>
                    <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo $br . $dec; ?> </div>
                    <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"> <?php echo $br . $mov; ?></div>
                    <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo $br . $car; ?> </div>
                    <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"> <?php echo $br . $des; ?></div>
                    <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo $br . $aj; ?> </div>
                    <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"> <?php echo $br . $tom; ?></div>
                    <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"> <?php echo $br . $mov2; ?></div>
                    <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"> <?php echo $br . $pro; ?></div>
                    <div class="campo" style=" text-align: right; width: 4.5%; background-color: gray;"><?php echo lang("Inv. Final"); ?> </div>
                    <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo $br . $oc; ?> </div>
                    <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo $br . $ped; ?></div>
                    <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo lang("T.Final"); ?></div>
                </div>
                <?php
                // if ($_POST["CodigoDesdeLPRES"] == true and $_POST["CodigoHastaLPRES"] == true) {
                //     $beetween = "and a.CodIdAmpliado between '" . $_POST["CodigoDesdeLPRES"] . "' and '" . $_POST["CodigoHastaLPRES"] . "' ";
                // }
                // if ($_POST["CodigoDesdeLPRES"] == true and $_POST["CodigoHastaLPRES"] == false) {
                //     $beetween = "and a.CodIdAmpliado between '" . $_POST["CodigoDesdeLPRES"] . "' and '" . $_POST["CodigoDesdeLPRES"] . "' ";
                // }
                if (!empty($_POST["mIdProductos"])) {
                    $beetween = " and a.CodIdBasico in ('" . implode("','", $_POST["mIdProductos"]) . "') ";
                }
                if ($_POST["ProductosInv"] == "on") {  /// producstos con inventario lalsad
                    $ConInv = "and round(coalesce(b.cantidad,0),2)+round(coalesce(c.cantidad,0),2)>0";
                }
                // if ($_POST["Almacen234"] == true) {
                //     $array2 = $_POST["Almacen234"];
                //     $p11 = "(";
                //     $p22 = ")";
                //     $Alma = "and ba.IdAlm in ";
                //     $nor2 = 0;
                //     foreach ($array2 as $array2) {
                //         //echo $array2;

                //         $query322 = "Select IdAlm,Nombre from PosUpAlmacen where IdCompany " . $companygrp . " 
                //     and IdAlm=" . $array2 . "
                //     ";
                //         if ($result322 = mysqli_query($conn, $query322)) {
                //             while ($row322 = mysqli_fetch_assoc($result322)) {
                //                 $nor2 = $nor2 + 1;
                //                 if ($nor2 <= 1) {

                //                     $Almacen23 =  $row322["IdAlm"];
                //                 }
                //                 if ($nor2 > 1) {
                //                     $coma = ",";
                //                     $Almacen23 =   $Almacen23 .  $coma . $row322["IdAlm"];
                //                 }
                //             }
                //             mysqli_free_result($result322);
                //         }
                //     }
                // }

                if (!empty($_POST["mIdAlmacen"])) {
                    $Almacen23 = " and ba.IdAlm in ('" . implode("','", $_POST["mIdAlmacen"]) . "')";
                }

                $familia = '';

                if (!empty($_POST["mIdfamilia"])) {
                    $familia = " and a.Idfamilia in ('" . implode("','", $_POST["mIdfamilia"]) . "') ";
                }
                if ($_POST["ProductosMov"] == "on") {

                    $ConMov = " and (c.cguiav <> 0 or c.cdevolucion  <> 0 or c.NotaEntrega  <> 0 or  c.Ccompras  <> 0 or c.CGcompras  <> 0 or c.CDevcompra  <> 0 or c.Ctraslados  <> 0 or c.CCargos  <> 0 or c.CDescargos  <> 0 or  c.Cajustes  <> 0 or c.CTomas  <> 0 or  c.Movimiento  <> 0 or c.CProduccion <> 0 or coalesce(c.cboletas,0)+coalesce(c.cfacturas,0) <> 0)";
                }
                if ($_POST["OrdenRES"] == true) {
                    if ($_POST["OrdenRES"] == "1") {
                        $OrdenBy = " order by a.CodIdAmpliado";
                    }
                    if ($_POST["OrdenRES"] == "2") {
                        $OrdenBy = " order by a.Descripcion";
                    }
                    if ($_POST["OrdenRES"] == "3") {
                        $OrdenBy = " order by  round(coalesce(b.cantidad,0),2)+round(coalesce(c.cantidad,0),2) ASC";
                    }

                    if ($_POST["OrdenRES"] == "6") {
                        $OrdenBy = "order by coalesce(c.cboletas,0)+coalesce(c.cfacturas,0) ASC";
                    }
                }

                if ($_POST['sucursal'] == '0') {

                    $query = "SELECT a.CodBarra,a.CodIdAmpliado, 
            c.tipox as tipox,
            a.Descripcion, coalesce(b.cantidad,0) as InventarioInicial,
            coalesce(c.cboletas,0)+coalesce(c.cfacturas,0) as Ventas,  
            coalesce(c.cguiav,0) as Guias, 
            round(coalesce(c.cdevolucion,0),2) as Devolucion, 
            round(coalesce(c.NotaEntrega,0),2) as NotaEntrega, 
            round(coalesce(c.Ccompras,0),2) as Compras,
            round(coalesce(c.CGcompras,0),2) as GuiasCompras, 
            round(coalesce(c.CDevcompra,0),2) as DevCompras,
            round(coalesce(c.Ctraslados,0),2) as Traslados,
            round(coalesce(c.CCargos,0),2) as Cargos,
            round(coalesce(c.CDescargos,0),2) as Descargos, 
             round(coalesce(c.Cajustes,0),2) as Ajustes, 
            round(coalesce(c.CTomas,0),2) as Tomas,
            round(coalesce(c.Movimiento,0),2) as Movimiento, 
            round(coalesce(c.CProduccion,0),2) as Produccion, 
            round(coalesce(b.cantidad,0),2)+round(coalesce(c.cantidad,0),2) as InventarioFinal,
            coalesce(d.COcompra ,0) as Ocompra,
            coalesce(d.CPedidos ,0) as Pedidos
            FROM PosUpProducto a 
            left join (select ba.IdCompany, ba.CodIdBasico, sum(ba.Cant*bb.Inventario) as cantidad, ba.IdAlm as idal, bb.Idtipotx as tipotrans 
            from PosUpTxD ba 
            left join PosUpTx bb on ba.Idtipotx = bb.Idtipotx 
						where ba.IdCompany  " . $companygrp . "  and ba.Fectxclient <'" . $fechaDES . " 00:00:00' " . $Almacen23 . " 
            GROUP by ba.IdCompany,ba.CodIdBasico) b  on a.IdCompany = b.IdCompany and a.CodIdBasico = b.CodIdBasico 
            left join (select ba.IdCompany, ba.CodIdBasico, sum(if(ba.Idtipotx=1,ba.Cant*bb.Inventario,0)) as cboletas,
						sum(if(ba.Idtipotx=2,ba.Cant*bb.Inventario,0)) as cfacturas, 
            sum(if(ba.Idtipotx=22,ba.Cant*bb.Inventario,0)) as cguiav, ba.Idtipotx as tipox,
            sum(if(ba.Idtipotx=3,ba.Cant*bb.Inventario,0)) as cdevolucion,
            sum(if(ba.Idtipotx=30,ba.Cant*bb.Inventario,0)) as CProduccion, 
            sum(if(ba.Idtipotx=7,ba.Cant*bb.Inventario,0)) as Ccompras,
            sum(if(ba.Idtipotx=27,ba.Cant*bb.Inventario,0)) as CDevcompra,
            sum(if(ba.Idtipotx=28,ba.Cant*bb.Inventario,0)) as CGcompras, 
            sum(if(ba.Idtipotx=8,ba.Cant*bb.Inventario,0)) as Cajustes,
            sum(if(ba.Idtipotx=18,ba.Cant*bb.Inventario,0)) as CCargos,
            sum(if(ba.Idtipotx=17,ba.Cant*bb.Inventario,0)) as Ctraslados,
            sum(if(ba.Idtipotx=19,ba.Cant*bb.Inventario,0)) as CDescargos,
            sum(if(ba.Idtipotx=10,ba.Cant*bb.Inventario,0)) as CTomas, 
            sum(if(ba.Idtipotx=9,ba.Cant*bb.Inventario,0)) as Movimiento, 
            sum(if(ba.Idtipotx=15,ba.Cant*bb.Inventario,0)) as NotaEntrega, 
            sum(ba.Cant*bb.Inventario) as cantidad from PosUpTxD ba 
            inner join PosUpTx bb on ba.Idtipotx = bb.Idtipotx 
            where ba.IdCompany  " . $companygrp . "  and  ba.Fectxclient  BETWEEN '" . $fechaDES . " 00:00:00' and '" . $fechaHAS . " 23:59:59' " . $Almacen23 . "  GROUP by ba.IdCompany,ba.CodIdBasico ) c  on a.IdCompany = c.IdCompany and a.CodIdBasico = c.CodIdBasico 
            left join (select ba.IdCompany, ba.CodIdBasico, sum(if(ba.Idtipotx=14,ba.Cant*bb.CompInv,0)) as COcompra, sum(if(ba.Idtipotx=11,ba.Cant*bb.Inventario,0)) as CPedidos from PosUpTxD ba inner join PosUpTx bb on ba.Idtipotx = bb.Idtipotx 
            WHERE ba.IdCompany  " . $companygrp . " GROUP by 
            ba.IdCompany,ba.CodIdBasico ) d on a.IdCompany = d.IdCompany and a.CodIdBasico = d.CodIdBasico 
            where a.IdCompany  " . $companygrp . "   
                " . $beetween . "
                " . $familia . "
                " . $ConInv . "
                " . $ConMov . " 
                " . $OrdenBy . " 
            ";
                } else {

                    $query = "SELECT a.CodBarra,a.CodIdAmpliado, 
        c.tipox as tipox,
        a.Descripcion, coalesce(b.cantidad,0) as InventarioInicial,
        coalesce(c.cboletas,0)+coalesce(c.cfacturas,0) as Ventas,  
        coalesce(c.cguiav,0) as Guias, 
        round(coalesce(c.cdevolucion,0),2) as Devolucion, 
        round(coalesce(c.NotaEntrega,0),2) as NotaEntrega, 
        round(coalesce(c.Ccompras,0),2) as Compras,
        round(coalesce(c.CGcompras,0),2) as GuiasCompras, 
        round(coalesce(c.CDevcompra,0),2) as DevCompras,
        round(coalesce(c.Ctraslados,0),2) as Traslados,
        round(coalesce(c.CCargos,0),2) as Cargos,
        round(coalesce(c.CDescargos,0),2) as Descargos, 
        round(coalesce(c.Cajustes,0),2) as Ajustes, 
        round(coalesce(c.CTomas,0),2) as Tomas,
        round(coalesce(c.Movimiento,0),2) as Movimiento, 
        round(coalesce(c.CProduccion,0),2) as Produccion, 
        round(coalesce(b.cantidad,0),2)+round(coalesce(c.cantidad,0),2) as InventarioFinal,
        coalesce(d.COcompra ,0) as Ocompra,
        coalesce(d.CPedidos ,0) as Pedidos
        FROM PosUpProducto a 
        left join (select ba.IdCompany, ba.CodIdBasico, sum(ba.Cant*bb.Inventario) as cantidad, ba.IdAlm as idal, bb.Idtipotx as tipotrans 
        from PosUpTxD ba 
        inner join PosUpAlmacen f on ba.IdCompany = f.IdCompany and ba.IdAlm = f.IdAlm 
        inner join PosUpUbicacion z on f.IdCompany=z.IdCompany and f.IdUbi=z.IdUbi
        inner join PosUpTx bb on ba.Idtipotx = bb.Idtipotx
        where f.IdUbi=" . $_POST['sucursal'] . " and ba.IdCompany  " . $companygrp . " and ba.Fectxclient < '" . $fechaDES . " 00:00:00' " . $Almacen23 . " 
        GROUP by ba.IdCompany,ba.CodIdBasico) b on a.IdCompany = b.IdCompany and a.CodIdBasico = b.CodIdBasico 
        left join (select ba.IdCompany, ba.CodIdBasico, sum(if(ba.Idtipotx=1,ba.Cant*bb.Inventario,0)) as cboletas, sum(if(ba.Idtipotx=2,ba.Cant*bb.Inventario,0)) as cfacturas, 
        sum(if(ba.Idtipotx=22,ba.Cant*bb.Inventario,0)) as cguiav,  ba.Idtipotx as tipox,
        sum(if(ba.Idtipotx=3,ba.Cant*bb.Inventario,0)) as cdevolucion, sum(if(ba.Idtipotx=7,ba.Cant*bb.Inventario,0)) as Ccompras,
        sum(if(ba.Idtipotx=27,ba.Cant*bb.Inventario,0)) as CDevcompra, sum(if(ba.Idtipotx=28,ba.Cant*bb.Inventario,0)) as CGcompras, 
        sum(if(ba.Idtipotx=8,ba.Cant*bb.Inventario,0)) as Cajustes, sum(if(ba.Idtipotx=18,ba.Cant*bb.Inventario,0)) as CCargos,
        sum(if(ba.Idtipotx=17,ba.Cant*bb.Inventario,0)) as Ctraslados,sum(if(ba.Idtipotx=19,ba.Cant*bb.Inventario,0)) as CDescargos,
        sum(if(ba.Idtipotx=10,ba.Cant*bb.Inventario,0)) as CTomas, 
        sum(if(ba.Idtipotx=30,ba.Cant*bb.Inventario,0)) as CProduccion, 
        sum(if(ba.Idtipotx=15,ba.Cant*bb.Inventario,0)) as NotaEntrega, 
        sum(if(ba.Idtipotx=9,ba.Cant*bb.Inventario,0)) as Movimiento, 
        sum(ba.Cant*bb.Inventario) as cantidad from PosUpTxD ba 
        inner join PosUpTx bb on ba.Idtipotx = bb.Idtipotx 
        inner join PosUpAlmacen f on ba.IdCompany = f.IdCompany and ba.IdAlm = f.IdAlm 
        inner join PosUpUbicacion z on f.IdCompany=z.IdCompany and f.IdUbi=z.IdUbi
        where f.IdUbi=" . $_POST['sucursal'] . " and ba.IdCompany  " . $companygrp . " and  ba.Fectxclient  BETWEEN '" . $fechaDES . " 00:00:00' and '" . $fechaHAS . " 23:59:59' " . $Almacen23 . "  GROUP by ba.IdCompany,ba.CodIdBasico ) c  on a.IdCompany = c.IdCompany and a.CodIdBasico = c.CodIdBasico 
        left join (select ba.IdCompany, ba.CodIdBasico,
         sum(if(ba.Idtipotx=14,ba.Cant*bb.CompInv,0)) as COcompra,
        sum(if(ba.Idtipotx=11,ba.Cant*bb.Inventario,0)) as CPedidos 
        from PosUpTxD ba
        inner join PosUpTx bb on ba.Idtipotx = bb.Idtipotx 
        inner join PosUpAlmacen f on ba.IdCompany = f.IdCompany and ba.IdAlm = f.IdAlm 
        inner join PosUpUbicacion z on f.IdCompany=z.IdCompany and f.IdUbi=z.IdUbi
        where f.IdUbi=" . $_POST['sucursal'] . " and ba.IdCompany  " . $companygrp . "
        GROUP by  ba.IdCompany,ba.CodIdBasico ) d on a.IdCompany = d.IdCompany and a.CodIdBasico = d.CodIdBasico 
        where a.IdCompany  " . $companygrp . "   
            " . $beetween . "
            " . $familia . "
            " . $ConInv . "
            " . $ConMov . " 
            " . $OrdenBy . " 
        ";
                }
                if ($result = mysqli_query($conn, $query)) {
                    $n = 0;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $n = $n + 1;
                        $nt = $nt + 1;

                        if ($color == 0) {
                            $color = 1;
                        } else {
                            $color = 0;
                        }
                ?>
                        <div style="text-align: left; float:left; width: 100%; <?php echo ($color == 0 ? "" : "background: #EDECEC;"); ?> ">
                            <div class="campo" style=" text-align: left; width: 6.5%; "><?php if ($row['CodBarra'] == "") {
                                                                                            echo "-";
                                                                                        } else {
                                                                                            echo $row['CodBarra'];
                                                                                        } ?>&nbsp;</div>
                            <div class="campo" style=" text-align: left; width: 6%; "><?php if ($row['CodIdAmpliado'] == "") {
                                                                                            echo "-";
                                                                                        } else {
                                                                                            echo $row['CodIdAmpliado'];
                                                                                        } ?>&nbsp;</div>
                            <div class="campo" style=" text-align: left; width: 13%; "><?php if ($row['Descripcion'] == "") {
                                                                                            echo "-";
                                                                                        } else {
                                                                                            echo $row['Descripcion'];
                                                                                        } ?>&nbsp;</div>

                            <div class="campo" style=" text-align: right; width: 4.5%; ">&nbsp;<?php if ($row['InventarioInicial'] == "") {
                                                                                                    echo "-";
                                                                                                } else {
                                                                                                    echo number_format($row['InventarioInicial'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                                } ?></div>
                            <div class="campo" style=" text-align: right; width: 3.45%; ">&nbsp;<?php if ($row['Ventas'] == "") {
                                                                                                    echo "-";
                                                                                                } else {
                                                                                                    echo number_format($row["Ventas"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                                } ?>
                            </div>
                            <div class="campo" style=" text-align: right; width: 3.45%; ">&nbsp;<?php echo number_format($row['Guias'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></div>
                            <div class="campo" style=" text-align: right; width: 3.45%; ">&nbsp;<?php if ($row['Devolucion'] == "") {
                                                                                                    echo "-";
                                                                                                } else {
                                                                                                    echo number_format($row['Devolucion'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                                }
                                                                                                ?></div>
                            <div class="campo" style=" text-align: right; width: 3.45%; ">&nbsp;<?php if ($row['NotaEntrega'] == "") {
                                                                                                    echo "-";
                                                                                                } else {
                                                                                                    echo number_format($row['NotaEntrega'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                                } ?></div>


                            <div class="campo" style=" text-align: right; width: 3.45%; ">&nbsp;<?php if ($row['Compras'] == "") {
                                                                                                    echo "-";
                                                                                                } else {
                                                                                                    echo number_format($row['Compras'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                                } ?></div>
                            <div class="campo" style=" text-align: right; width: 3.45%; ">&nbsp;<?php if ($row['GuiasCompras'] == "") {
                                                                                                    echo "-";
                                                                                                } else {
                                                                                                    echo number_format($row['GuiasCompras'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                                } ?></div>
                            <div class="campo" style=" text-align: right; width: 3.45%; ">&nbsp;<?php if ($row['DevCompras'] == "") {
                                                                                                    echo "-";
                                                                                                } else {
                                                                                                    echo number_format($row['DevCompras'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                                } ?></div>
                            <div class="campo" style=" text-align: right; width: 3.45%; ">&nbsp;<?php if ($row['Traslados'] == "") {
                                                                                                    echo "-";
                                                                                                } else {
                                                                                                    echo number_format($row['Traslados'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                                } ?></div>

                            <div class="campo" style=" text-align: right; width: 3.45%; ">&nbsp;<?php if ($row['Cargos'] == "") {
                                                                                                    echo "-";
                                                                                                } else {
                                                                                                    echo number_format($row['Cargos'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                                } ?></div>
                            <div class="campo" style=" text-align: right; width: 3.45%; ">&nbsp;<?php if ($row['Descargos'] == "") {
                                                                                                    echo "-";
                                                                                                } else {
                                                                                                    echo number_format($row['Descargos'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                                } ?></div>
                            <div class="campo" style=" text-align: right; width: 3.45%; ">&nbsp;<?php if ($row['Ajustes'] == "") {
                                                                                                    echo "-";
                                                                                                } else {
                                                                                                    echo
                                                                                                    number_format($row['Ajustes'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                                } ?></div>
                            <div class="campo" style=" text-align: right; width: 3.45%; ">&nbsp;<?php if ($row['Tomas'] == "") {
                                                                                                    echo "-";
                                                                                                } else {
                                                                                                    echo number_format($row['Tomas'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                                } ?></div>
                            <div class="campo" style=" text-align: right; width: 3.45%; ">&nbsp;<?php if ($row['Movimiento'] == "") {
                                                                                                    echo "-";
                                                                                                } else {
                                                                                                    echo number_format($row['Movimiento'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                                } ?></div>
                            <div class="campo" style=" text-align: right; width: 3.45%; ">&nbsp;<?php if ($row['Produccion'] == "") {
                                                                                                    echo "-";
                                                                                                } else {
                                                                                                    echo number_format($row['Produccion'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                                } ?></div>

                            <div class="campo" style=" text-align: right; width: 4.5%; ">&nbsp;<?php if ($row['InventarioFinal'] == "") {
                                                                                                    echo "-";
                                                                                                } else {
                                                                                                    echo number_format($row['InventarioFinal'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                                } ?></div>

                            <div class="campo" style=" text-align: right; width: 3.45%; ">&nbsp;<?php if ($row['Ocompra'] == "") {
                                                                                                    echo "-";
                                                                                                } else {
                                                                                                    echo number_format($row['Ocompra'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                                } ?></div>

                            <div class="campo" style=" text-align: right; width: 3.45%; ">&nbsp;<?php if ($row['Pedidos'] == "") {
                                                                                                    echo "-";
                                                                                                } else {
                                                                                                    echo number_format($row['Pedidos'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                                } ?></div>


                            <div class="campo" style=" text-align: right; width: 3.45%; ">&nbsp;<?php
                                                                                                $finally = $row['Pedidos'] + $row['Ocompra'] + $row['InventarioFinal'];
                                                                                                echo number_format($finally, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);


                                                                                                ?></div>
                        </div> <?php
                                $unidadTotal = $unidadTotal + $row["unidad"];
                                $ExistenciaTotal = $ExistenciaTotal + $row["Cantidad"];
                                if ($n >= 40) { ?>

                            <div style="PAGE-BREAK-AFTER: always"></div>

                            <div class="encabezado">
                                <div class="campo" style=" text-align: left; width: 100%; font-size:7.5px;"><strong><?php echo  $idk; ?></strong></div>
                            </div>
                            <div class="encabezado">
                                <div class="campo" style=" text-align: left; width: 30.7%; visibility:hidden">.</div>
                                <div class="campo" style="text-align: left; width: 14.47%; background-color: gray;"><?php echo lang("Afecta Venta"); ?></div>
                                <div class="campo" style="text-align: left; width: 10.9%; background-color: gray;"><?php echo lang("Afecta Compras"); ?></div>
                                <div class="campo" style="text-align: left; width: 25.6%; background-color: gray;"><?php echo lang("Operaciones de inventario"); ?></div>
                                <div class="campo" style="text-align: left; width: 4.3%; background-color: gray; visibility:hidden">E </div>
                                <div class="campo" style="text-align: left; width: 7.1%; background-color: gray;"><?php echo lang("En tránsito"); ?> </div>
                            </div>
                            <?php $br = "";  ?>
                            <div class="encabezado" style="">
                                <div class="campo" style=" text-align: left; width: 6.5%; background-color: gray;"><?php echo lang("Código Barra"); ?></div>
                                <div class="campo" style=" text-align: left; width: 6%; background-color: gray;"><?php echo lang("S.K.U"); ?></div>
                                <div class="campo" style=" text-align: left; width: 13%; background-color: gray;"><?php echo lang("Descripción"); ?></div>
                                <div class="campo" style=" text-align: right; width: 4.5%; background-color: gray;"><?php echo lang("Inv. Inicial"); ?></div>
                                <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"> <?php echo $br . $bol . '/' . $fac; ?> </div>
                                <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"> <?php echo $br . $gde; ?></div>
                                <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo $br . $dev; ?> </div>
                                <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo $br . $nte; ?></div>
                                <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo $br . $com; ?> </div>
                                <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo $br . $gdc; ?></div>
                                <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo $br . $dec; ?> </div>
                                <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"> <?php echo $br . $mov; ?></div>
                                <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo $br . $car; ?> </div>
                                <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"> <?php echo $br . $des; ?></div>
                                <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo $br . $aj; ?> </div>
                                <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"> <?php echo $br . $tom; ?></div>
                                <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"> <?php echo $br . $mov2; ?></div>
                                <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"> <?php echo $br . $pro; ?></div>
                                <div class="campo" style=" text-align: right; width: 4.5%; background-color: gray;"><?php echo lang("Inv. Final"); ?> </div>
                                <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo $br . $oc; ?> </div>
                                <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo $br . $ped; ?></div>
                                <div class="campo" style=" text-align: right; width: 3.45%; background-color: gray;"><?php echo lang("T.Final"); ?></div>
                            </div>
                <?php
                                    $CostoExistencia = 0;
                                    $unidadTotal = 0;
                                    $ExistenciaTotal = 0;
                                    $n = 0;
                                }
                            }
                            mysqli_free_result($result);
                        } ?>


            </div>
            </div>
            <div style="PAGE-BREAK-AFTER: always; visibility: hidden;">a</div>

            <form id="formexcel" action="excelnew.php" method="post">
                <?php
                $compa = $_POST["CompanyActual"];
                $name = lang("MovimientoResumido");
                ?>

                <input type="hidden" name="Query" id="Query" value="<?php echo $query; ?>" />
                <input type="hidden" name="Name" id="Name" value="<?php echo $name; ?>" />
                <input type="hidden" name="SimDec" id="SimDec" value="<?php echo $_POST['SimDec']; ?>" />
                <input type="hidden" name="SimMil" id="SimMil" value="<?php echo $_POST['SimMil']; ?>" />
                <input type="hidden" name="CD" id="CD" value="<?php echo $_POST['CD']; ?>" />
                <input type="hidden" name="CompanyActual" id="CompanyActual" value="<?php echo $_POST['CompanyActual']; ?>" />
                <input type="hidden" name="vas" id="vas" value="MovimientoResumido" />
            </form>
            <form id="formexceel" action="excelv3led.php" method="post">
                <?php
                ?>
                <?php
                $compa = $_POST["CompanyActual"];
                $name = lang("MovimientoResumido") . ".csv";
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
        */