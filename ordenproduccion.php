<?php


include "ambiente.php";
$conn = ConectarReport();
session_start();

$fechaD = $_POST["fechM"];
$fechaH = $_POST["fechM2"];
// if($_POST["familiaM"]==true){
//     $array=$_POST["familiaM"];
//     $p1="(";
//     $p2=")";
//     $Idtipotx="and z.IdVarios in ";
//     $nor=0;
//     foreach($array as $array){



//         $query32="SELECT * FROM PosUpvarios a where a.IdCompany=".$_POST['CompanyActual']."  and a.TIPOITEM=2 
//         and a.IdVarios=" . $array . " " ;
//         if($result32= mysqli_query($conn,$query32)){

//             while($row32= mysqli_fetch_assoc($result32)){

//                 $nor=$nor+1;
//                 if($nor <=1 ){ 
//                     $filtrar=  $row32["IdVarios"];
//                     $Opera=  $row32["ITEM"];

//                 }
//                 if($nor>1) {

//                     $coma=",";
//                     $filtrar=   $filtrar .  $coma . $row32["IdVarios"] ;

//                     $Opera=   $Opera .  $coma . $row32["ITEM"] ;


//                 }
//             }
//             mysqli_free_result($result32);
//         }
//     }
// }  
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
    <title><?php echo lang("Producción por Almacén de Venta"); ?></title>
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
    <button class='ocultoimpresion ' onclick='document.getElementById(`formexcel`).submit()'><img src='/img/excel.png' width='28' height='28'><br>Producción<br></button>
    <div class="pagina" style="font-size: 12px;">
        <div class="sup">
            <div style="float:left; width: 23%;">
                <div class="TituloEmpresa" id="Titulo"><?php echo $_POST["NameCompany"]; ?></div>
                <div class="Subtituloempresa" id="Ubicacion"><?php echo $_POST["direccion"]; ?></div>
                <div class="Subtituloempresa" id="Literal Fiscal"><?php echo $_POST["litfiscal"]; ?>-<?php echo $_POST["rute"]; ?></div>
            </div>
            <div style="float:left; width: 53%;">
                <div class="TituloEmpresa" style="float: center; text-align: center;"><?php echo lang("Producción por Almacén de Venta"); ?></div>
                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php echo lang("Fecha"); ?>: <?php
                                                                                                                                                            if ($_POST["fechM"] == true) {
                                                                                                                                                                echo $fechaD;
                                                                                                                                                            }
                                                                                                                                                            if ($_POST["fechM2"] == true) {
                                                                                                                                                                echo "  " . lang("al") . "  " . $fechaH;
                                                                                                                                                            }
                                                                                                                                                            ?>
                </div>
                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php
                                                                                                                            if ($_POST["almacenM"] == FALSE) {
                                                                                                                                echo "--------------------";
                                                                                                                            }
                                                                                                                            if ($_POST["almacenM"] == true) {
                                                                                                                                echo lang("Almacén") . ":";
                                                                                                                                $array2 = $_POST["almacenM"];
                                                                                                                                foreach ($array2 as $array2) {
                                                                                                                                    $query123 = "Select IdAlm,Nombre from PosUpAlmacen where IdCompany=" . $_POST["CompanyActual"] . "
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
                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php
                                                                                                                            if ($_POST["filtroM"] == FALSE) {
                                                                                                                                echo "--------------------";
                                                                                                                            }
                                                                                                                            if ($_POST["filtroM"] == true) {
                                                                                                                                echo lang("Filtrado por") . ":";
                                                                                                                                $array = $_POST["filtroM"];
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
                                                                                                                            } ?>
                </div>
                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php if ($_POST["productoinv2"] == TRUE) {
                                                                                                                                echo lang("Producto") . ": " . $_POST["productoinv2"];
                                                                                                                            } else {
                                                                                                                                echo "--------------------";
                                                                                                                            } ?> </div>
                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php if ($_POST["familiaM"] == false) {
                                                                                                                                echo "------------";
                                                                                                                            }
                                                                                                                            if ($_POST["familiaM"] == false) {
                                                                                                                            } else {
                                                                                                                                echo " " . lang("Familias") . " : " . $Opera;
                                                                                                                            } ?></div>
                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php if ($_POST["marcainv2"] == TRUE) {
                                                                                                                                echo "" . lang("Marca") . ": " . $_POST["marcainv2"];
                                                                                                                            } else {
                                                                                                                                echo "--------------------";
                                                                                                                            } ?> </div>
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

        <div class="encabezado">
            <div class="campo" style=" text-align: left; width: 6%; background-color: gray;"><?php echo lang("Fuente"); ?></div>
            <div class="campo" style=" text-align: left; width: 7%; background-color: gray;"><?php echo lang("Familia"); ?></div>
            <div class="campo" style=" text-align: left; width: 8%; background-color: gray;"><?php echo lang("S.K.U"); ?></div>
            <div class="campo" style=" text-align: left; width: 16%; background-color: gray;"><?php echo lang("Descripción"); ?></div>
            <div class="campo" style=" text-align: left; width: 6%; background-color: gray;"><?php echo lang("Marca"); ?></div>
            <div class="campo" style=" text-align: right; width: 7%; background-color: gray;"><?php echo lang("Cantidad Insumo"); ?></div>
            <div class="campo" style=" text-align: right; width: 7%; background-color: gray;"><?php echo lang("Costo S/Impto Insumo"); ?>. </div>
            <div class="campo" style=" text-align: right; width: 7%; background-color: gray;"><?php echo lang("Cantidad producción"); ?></div>
            <div class="campo" style=" text-align: right; width: 7%; background-color: gray;"><?php echo lang("Costo S/Impto producción"); ?>. </div>
            <div class="campo" style=" text-align: right; width: 7%; background-color: gray;"><?php echo lang("Cantidad venta"); ?></div>
            <div class="campo" style=" text-align: right; width: 7%; background-color: gray;"><?php echo lang("Costo S/Impto venta"); ?>.</div>

            <div class="campo" style=" text-align: right; width: 7%; background-color: gray;"><?php echo lang("Precio de Venta"); ?>. </div>
            <div class="campo" style=" text-align: right; width: 5%; background-color: gray;">%<?php echo lang("Utilidad"); ?></div>
        </div>
        <?php
        // if ($_POST["Producto2"] == true) {
        //     //$Producto= "and concat(a.CodIdBasico,a.CodIdAmpliado,a.CodBarra) like '%" . $_POST["Producto2"] . "%' ";
        //     $Producto = "and (a.CodIdBasico='" . $_POST["Producto2"] . "' or a.CodBarra = '" . $_POST["Producto2"] . "' or a.CodIdAmpliado='" . $_POST["Producto2"] . "')";
        // }

        if (!empty($_POST["mIdProductos"])) {
            $produc = " and a.CodIdBasico in ('" . implode("','", $_POST["mIdProductos"]) . "') ";
        }
        $familia = '';

        if (!empty($_POST["mIdfamilia"])) {
            $familia = " and z.IdVarios in ('" . implode("','", $_POST["mIdfamilia"]) . "') ";
        }

        if (!empty($_POST["mIdAlmacen"])) {
            $Almacen23 = " and al.IdAlm in ('" . implode("','", $_POST["mIdAlmacen"]) . "')";
        }
        // if ($_POST["almacenM"] == true) {
        //     $array2 = $_POST["almacenM"];
        //     $p11 = "(";
        //     $p22 = ")";
        //     $Alma = "and al.IdAlm in ";
        //     $nor2 = 0;
        //     foreach ($array2 as $array2) {
        //         //echo $array2;

        //         $query322 = "Select IdAlm,Nombre from PosUpAlmacen where IdCompany=" . $_POST["CompanyActual"] . "
        //         and IdAlm=" . $array2 . "
        //         ";
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
        // if ($_POST["filtroM"] == true) {
        //     $array = $_POST["filtroM"];
        //     $p1 = "(";
        //     $p2 = ")";
        //     $Idtipotx = "and c.Idtipotx in ";
        //     $nor = 0;
        //     foreach ($array as $array) {

        //         $query32 = "Select idtipotx,Titulo from PosUpTx where Inventario<>0
        //         and idtipotx=" . $array . "
        //         ";
        //         if ($result32 = mysqli_query($conn, $query32)) {
        //             while ($row32 = mysqli_fetch_assoc($result32)) {
        //                 $nor = $nor + 1;
        //                 if ($nor <= 1) {

        //                     $filtrar =  $row32["idtipotx"];
        //                 }
        //                 if ($nor > 1) {
        //                     $coma = ",";
        //                     $filtrar =   $filtrar .  $coma . $row32["idtipotx"];
        //                 }
        //             }
        //             mysqli_free_result($result32);
        //         }
        //     }
        // }

        // if ($_POST["productoinv"] == true) {
        //     $produc = "and e.CodIdAmpliado= '" . $_POST["productoinv"] . "'";
        // }
        $buscar .= $familia;

        if (!empty($_POST["mIdMarca"])) {
            $marca = " and e.Marca in ('" . implode("','", $_POST["mIdMarca"]) . "') ";
        }
        $query = "SELECT 'PRODUCCION' as Fuente,a.IdAlm as IdAlmacen,al.Nombre as Almacen ,e.CodIdAmpliado as SKU, 
            pd.Descripcion as Descripcion, 
            z.ITEM AS Familia, y.nombre as Marca, coalesce(sum(pd.Cant),0)  as Cantidad, coalesce(sum(round(pd.Costo/(1+pu.VALOR)," . $_POST["CD"] . ")),0) as Costo   ,0 as  Precio ,
            0 as Util
            from PosUpTxD a 
            left join PosUpTxC b on a.IdCompany = b.IdCompany and a.Idtipotx = b.Idtipotx and a.Idtx = b.Idtx and a.IdEstacion = b.IdEstacion 
            inner join PosUpTx c on a.Idtipotx = c.Idtipotx 
            left join PosUpTxC p on a.IdCompany =p.IdCompany and CONCAT(a.IdAlm,'-',c.TitCto,'-',Lpad(IF(trim(b.Referencia)='',if (b.DTE=0,if (b.IdTxCompany<>0,b.IdTxCompany,b.Idtx),b.DTE),b.Referencia ),4,'0'),'-',a.Item)=p.Referencia 
            left join PosUpTxD pd on pd.IdCompany = p.IdCompany and pd.Idtipotx = p.Idtipotx and pd.IdEstacion = p.IdEstacion and pd.Idtx = p.idtx   and pd.Idtipotx <> 23
            left join PosUpAlmacen al on al.IdCompany =a.IdCompany and al.IdAlm =a.IdAlm 
            left join PosUpUbicacion bl on bl.IdCompany =al.IdCompany and bl.IdUbi =al.IdUbi 
            left join PosUpProducto e on pd.IdCompany=e.IdCompany and pd.CodIdBasico=e.CodIdBasico 
            left join PosUpvarios z on e.IdCompany=z.IdCompany and e.idfamilia=z.IdVarios and z.TIPOITEM=2 
            left join PosUpc_marcas y on e.IdCompany=y.IdCompany and e.Marca=y.idmarca 
            left join PosUpvarios pu on e.IdCompany=pu.IdCompany and e.Impuesto = pu.IdVarios and pu.TIPOITEM =0 
            where a.EstadoOrden = 1 and a.IdCompany= " . $_POST['CompanyActual'] . " AND 
            p.Fectxclient BETWEEN '" . $_POST["fechM"] . " 00:00:00' and '" . $_POST["fechM2"] . " 23:59:59'
            " . $Almacen23 . "
            " . $produc . "
            " . $familia . "
            " . $marca . "
            " . $ubic . "
            " . $buscar . "  
            group by a.IdAlm,pd.CodIdBasico 
            UNION 
            SELECT 'VENTA' as Fuente,a.IdAlm as IdAlmacen,al.Nombre as Almacen ,e.CodIdAmpliado as SKU, e.Descripcion as Descripcion, 
            z.ITEM AS Familia, y.nombre as Marca, sum(coalesce(a.Cant,0)) as Cantidad,coalesce(sum(round(e.Costo/(1+pu.VALOR)," . $_POST["CD"] . ")),0) as Costo ,
            sum(round(coalesce(a.Total /(1+pu.VALOR),0),0)) as Precio,
            coalesce(round((sum(round(coalesce(a.Total /(1+pu.VALOR),0),0)) - sum(round(e.Costo/(1+pu.VALOR),0))) / sum(round(e.Costo/(1+pu.VALOR),0) )* 100,2),0) as Util
            from PosUpTxD a 
            left join PosUpAlmacen al on al.IdCompany =a.IdCompany and al.IdAlm =a.IdAlm 
            left join PosUpProducto e on a.IdCompany=e.IdCompany and a.CodIdBasico=e.CodIdBasico 
            left join PosUpvarios z on e.IdCompany=z.IdCompany and e.idfamilia=z.IdVarios and z.TIPOITEM=2 
            left join PosUpc_marcas y on e.IdCompany=y.IdCompany and e.Marca=y.idmarca 
            left join PosUpvarios pu on e.IdCompany=pu.IdCompany and e.Impuesto = pu.IdVarios and pu.TIPOITEM =0 
            where   a.IdCompany= " . $_POST['CompanyActual'] . " AND 
            a.Fectxclient BETWEEN '" . $_POST["fechM"] . " 00:00:00' and '" . $_POST["fechM2"] . " 23:59:59'
            " . $Almacen23 . "
            " . $produc . "
            " . $familia . "
            " . $buscar . "
            " . $marca . "
            " . $ubic . " and a.idtipotx in (1,2,3,31,15,22)
            group by a.IdAlm,a.CodIdBasico order by IdAlmacen,fuente,Familia,SKU";
        //echo $query;
        if ($result = mysqli_query($conn, $query)) {
            $n = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                $n = $n + 1;
                $ignore = $ignore + 1;
                $alm = $row['IdAlmacen'] . $row['Almacen'];
                if ($alm <> $alm2) {
                    if ($ignore > 1) { ?>
                        <div style="text-align: left; float:left; width: 100%;">
                            <div class="campo" style=" text-align: left; width: 6%; visibility:hidden;">.</div>


                            <div class="campo" style=" text-align: left; width: 7%; visibility:hidden;">.</div>
                            <div class="campo" style=" text-align: left; width: 6%; visibility:hidden;">.</div>
                            <div class="campo" style=" text-align: left; width: 8%; visibility:hidden;">.</div>
                            <div class="campo" style=" text-align: right; width: 16%; ">Totales </div>

                            <?php
                            $totalcosta = $costprod + $Costo;
                            $util = (($price - $totalcosta) / $totalcosta) * 100;
                            ?>
                            <div class="campo" style=" text-align: right; width: 7%; "><?php echo number_format($cantinsu, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>

                            <div class="campo" style=" text-align: right; width: 7%; "><?php echo number_format($costprod, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>
                            <div class="campo" style=" text-align: right; width: 7%; "><?php echo number_format($cantprod, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>

                            <div class="campo" style=" text-align: right; width: 7%; "><?php echo number_format($costinsu, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>
                            <div class="campo" style=" text-align: right; width: 7%; "><?php echo number_format($Cantidad, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>
                            <div class="campo" style=" text-align: right; width: 7%; "><?php echo number_format($Costo, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>
                            <div class="campo" style=" text-align: right; width: 7%; "><?php echo number_format($price, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>

                            <div class="campo" style=" text-align: right; width: 5%; "><?php echo number_format($util, 2, $_POST["SimDec"], $_POST["SimMil"]);  ?>%</div>

                        </div>
                    <?php } ?>
                    <div style="text-align: left; float:left; width: 100%;">
                        <div class="campo" style="text-align: lefet; background-color: #EDECEC; width: 100%; font-size: 13px;"><strong>Almacen: <?php if ($row['Almacen'] == "") {
                                                                                                                                                    echo "-";
                                                                                                                                                } else {
                                                                                                                                                    echo "(" . $row['IdAlmacen'] . ")" . $row['Almacen'];
                                                                                                                                                } ?></strong></div>
                    </div>
                <?php
                    if ($ignore > 1) {
                        $cantinsu = 0;
                        $costinsu = 0;
                        $cantprod = 0;
                        $costprod = 0;
                        $Costo = 0;
                        $Cantidad = 0;
                        $Costop = 0;
                        $Cantidadp = 0;
                        $price = 0;
                    }
                }
                ?>

                <div style="text-align: left; float:left; width: 100%;">
                    <div class="campo" style=" text-align: left; width: 6%; "><?php if ($row['Fuente'] == "") {
                                                                                    echo ".";
                                                                                } else {
                                                                                    echo $row['Fuente'];
                                                                                } ?></div>

                    <div class="campo" style=" text-align: left; width: 7%; "><?php if ($row['Familia'] == "") {
                                                                                    echo ".";
                                                                                } else {
                                                                                    echo $row['Familia'];
                                                                                } ?></div>
                    <div class="campo" style=" text-align: left; width: 8%; "><?php if ($row['SKU'] == "") {
                                                                                    echo ".";
                                                                                } else {
                                                                                    echo $row['SKU'];
                                                                                } ?></div>

                    <div class="campo" style=" text-align: left; width: 16%; "><?php if ($row['Descripcion'] == "") {
                                                                                    echo ".";
                                                                                } else {
                                                                                    echo $row['Descripcion'];
                                                                                } ?></div>


                    <div class="campo" style=" text-align: left; width: 6%; "><?php if ($row['Marca'] == "") {
                                                                                    echo ".";
                                                                                } else {
                                                                                    echo $row['Marca'];
                                                                                } ?></div>
                    <div class="campo" style=" text-align: right; width: 7%; "><?php if ($row['Cantidad'] == "") {
                                                                                    echo ".";
                                                                                } else {
                                                                                    if ($row['Fuente'] == 'VENTA') {
                                                                                        echo number_format(0, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                    } else {
                                                                                        if ($row['Cantidad'] > 0) {
                                                                                            echo  number_format(0, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                        } else {
                                                                                            echo number_format($row['Cantidad'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                        }
                                                                                    }
                                                                                } ?></div>
                    <div class="campo" style=" text-align: right; width: 7%; "><?php if ($row['Costo'] == "") {
                                                                                    echo ".";
                                                                                } else {
                                                                                    if ($row['Fuente'] == 'VENTA') {
                                                                                        echo number_format(0, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                    } else {
                                                                                        if ($row['Cantidad'] > 0) {
                                                                                            echo number_format(0, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                        } else {
                                                                                            echo number_format($row['Costo'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                        }
                                                                                    }
                                                                                } ?></div>
                    <div class="campo" style=" text-align: right; width: 7%; "><?php if ($row['Cantidad'] == "") {
                                                                                    echo ".";
                                                                                } else {
                                                                                    if ($row['Fuente'] == 'VENTA') {
                                                                                        echo number_format(0, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                    } else {
                                                                                        if ($row['Cantidad'] < 0) {
                                                                                            echo number_format(0, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                        } else {
                                                                                            echo number_format($row['Cantidad'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                        }
                                                                                    }
                                                                                } ?></div>

                    <div class="campo" style=" text-align: right; width: 7%; "><?php if ($row['Costo'] == "") {
                                                                                    echo ".";
                                                                                } else {
                                                                                    if ($row['Fuente'] == 'VENTA') {
                                                                                        echo number_format(0, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                    } else {
                                                                                        if ($row['Cantidad'] < 0) {
                                                                                            echo number_format(0, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                        } else {
                                                                                            echo number_format($row['Costo'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                        }
                                                                                    }
                                                                                } ?></div>
                    <div class="campo" style=" text-align: right; width: 7%; "><?php if ($row['Cantidad'] == "") {
                                                                                    echo ".";
                                                                                } else {
                                                                                    if ($row['Fuente'] == 'PRODUCCION') {
                                                                                        echo number_format(0, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                    } else {
                                                                                        echo number_format($row['Cantidad'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                    }
                                                                                } ?></div>
                    <div class="campo" style=" text-align: right; width: 7%; "><?php if ($row['Costo'] == "") {
                                                                                    echo ".";
                                                                                } else {
                                                                                    if ($row['Fuente'] == 'PRODUCCION') {
                                                                                        echo number_format(0, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                    } else {
                                                                                        echo number_format($row['Costo'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                    }
                                                                                } ?></div>

                    <div class="campo" style=" text-align: right; width: 7%; "><?php if ($row['Precio'] == "") {
                                                                                    echo ".";
                                                                                } else {
                                                                                    echo number_format($row['Precio'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                                                                                } ?></div>
                    <div class="campo" style=" text-align: right; width: 5%; "><?php if ($row['Util'] == "") {
                                                                                    echo ".";
                                                                                } else {
                                                                                    echo number_format($row['Util'], 2, $_POST["SimDec"], $_POST["SimMil"]);
                                                                                } ?>%</div>
                </div>
                <?php
                if ($n >= 45) { ?>
                    <div style="PAGE-BREAK-AFTER: always"></div>
                    <div class="sup">
                        <div style="float:left; width: 23%;">
                            <div class="TituloEmpresa" id="Titulo"><?php echo $_POST["NameCompany"]; ?></div>
                            <div class="Subtituloempresa" id="Ubicacion"><?php echo $_POST["direccion"]; ?></div>
                            <div class="Subtituloempresa" id="Literal Fiscal"><?php echo $_POST["litfiscal"]; ?>-<?php echo $_POST["rute"]; ?></div>
                        </div>
                        <div style="float:left; width: 53%;">
                            <div class="TituloEmpresa" style="float: center; text-align: center;"><?php echo lang("Producción por Almacén de Venta"); ?></div>
                            <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php echo lang("Fecha"); ?>: <?php
                                                                                                                                                                        if ($_POST["fechM"] == true) {
                                                                                                                                                                            echo $fechaD;
                                                                                                                                                                        }
                                                                                                                                                                        if ($_POST["fechM2"] == true) {
                                                                                                                                                                            echo "  " . lang("al") . "  " . $fechaH;
                                                                                                                                                                        }
                                                                                                                                                                        ?>
                            </div>
                            <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php
                                                                                                                                        if ($_POST["almacenM"] == FALSE) {
                                                                                                                                            echo "--------------------";
                                                                                                                                        }
                                                                                                                                        if ($_POST["almacenM"] == true) {
                                                                                                                                            echo lang("Almacén") . ":";
                                                                                                                                            $array2 = $_POST["almacenM"];
                                                                                                                                            foreach ($array2 as $array2) {
                                                                                                                                                $query123 = "Select IdAlm,Nombre from PosUpAlmacen where IdCompany=" . $_POST["CompanyActual"] . "
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
                            <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php
                                                                                                                                        if ($_POST["filtroM"] == FALSE) {
                                                                                                                                            echo "--------------------";
                                                                                                                                        }
                                                                                                                                        if ($_POST["filtroM"] == true) {
                                                                                                                                            echo lang("Filtrado por") . ":";
                                                                                                                                            $array = $_POST["filtroM"];
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
                                                                                                                                        } ?>
                            </div>
                            <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php if ($_POST["productoinv2"] == TRUE) {
                                                                                                                                            echo lang("Producto") . ": " . $_POST["productoinv2"];
                                                                                                                                        } else {
                                                                                                                                            echo "--------------------";
                                                                                                                                        } ?> </div>
                            <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php if ($_POST["familiaM"] == false) {
                                                                                                                                            echo "------------";
                                                                                                                                        }
                                                                                                                                        if ($_POST["familiaM"] == false) {
                                                                                                                                        } else {
                                                                                                                                            echo " " . lang("Familias") . " : " . $Opera;
                                                                                                                                        } ?></div>
                            <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php if ($_POST["marcainv2"] == TRUE) {
                                                                                                                                            echo "" . lang("Marca") . ": " . $_POST["marcainv2"];
                                                                                                                                        } else {
                                                                                                                                            echo "--------------------";
                                                                                                                                        } ?> </div>
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

                    <div class="encabezado">
                        <div class="campo" style=" text-align: left; width: 6%; background-color: gray;"><?php echo lang("Fuente"); ?></div>
                        <div class="campo" style=" text-align: left; width: 7%; background-color: gray;"><?php echo lang("Familia"); ?></div>
                        <div class="campo" style=" text-align: left; width: 8%; background-color: gray;"><?php echo lang("S.K.U"); ?></div>
                        <div class="campo" style=" text-align: left; width: 16%; background-color: gray;"><?php echo lang("Descripción"); ?></div>
                        <div class="campo" style=" text-align: left; width: 6%; background-color: gray;"><?php echo lang("Marca"); ?></div>
                        <div class="campo" style=" text-align: right; width: 7%; background-color: gray;"><?php echo lang("Cantidad Insumo"); ?></div>
                        <div class="campo" style=" text-align: right; width: 7%; background-color: gray;"><?php echo lang("Costo S/Impto Insumo"); ?>. </div>
                        <div class="campo" style=" text-align: right; width: 7%; background-color: gray;"><?php echo lang("Cantidad producción"); ?></div>
                        <div class="campo" style=" text-align: right; width: 7%; background-color: gray;"><?php echo lang("Costo S/Impto producción"); ?>. </div>
                        <div class="campo" style=" text-align: right; width: 7%; background-color: gray;"><?php echo lang("Cantidad venta"); ?></div>
                        <div class="campo" style=" text-align: right; width: 7%; background-color: gray;"><?php echo lang("Costo S/Impto venta"); ?>.</div>

                        <div class="campo" style=" text-align: right; width: 7%; background-color: gray;"><?php echo lang("Precio de Venta"); ?>. </div>
                        <div class="campo" style=" text-align: right; width: 5%; background-color: gray;">%<?php echo lang("Utilidad"); ?></div>
                    </div>
        <?php
                    $n = 0;
                }
                if ($row['Fuente'] == 'PRODUCCION') {

                    if ($row["Cantidad"] < 0) {

                        $costprod = $costprod + $row["Costo"];
                        $costprod2 = $costprod2 + $row["Costo"];
                        $cantinsu = $cantinsu + $row["Cantidad"];
                        $cantinsu2 = $cantinsu2 + $row["Cantidad"];
                    } else {

                        $costinsu = $costinsu + $row["Costo"];
                        $costinsu2 = $costinsu2 + $row["Costo"];
                        $cantprod = $cantprod + $row["Cantidad"];
                        $cantprod2 = $cantprod2 + $row["Cantidad"];
                    }
                } else {
                    $Costo = $Costo + $row["Costo"];
                    $Cantidad = $Cantidad + $row["Cantidad"];
                    $Costo2 = $Costo2 + $row["Costo"];
                    $Cantidad2 = $Cantidad2 + $row["Cantidad"];
                }
                $price = $price + $row['Precio'];
                $price2 = $price2 + $row['Precio'];
                $alm2 = $row['IdAlmacen'] . $row['Almacen'];
            }
            mysqli_free_result($result);
        } ?>
        <div style="text-align: left; float:left; width: 100%;">
            <div class="campo" style=" text-align: left; width: 6%; visibility:hidden;">.</div>


            <div class="campo" style=" text-align: left; width: 7%; visibility:hidden;">.</div>
            <div class="campo" style=" text-align: left; width: 6%; visibility:hidden;">.</div>
            <div class="campo" style=" text-align: left; width: 8%; visibility:hidden;">.</div>
            <div class="campo" style=" text-align: right; width: 16%; ">Totales </div>

            <?php
            $totalcost = $costprod + $Costo;
            $util = (($price - $totalcost) / $totalcost) * 100;
            ?>
            <div class="campo" style=" text-align: right; width: 7%; "><?php echo number_format($cantinsu, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>

            <div class="campo" style=" text-align: right; width: 7%; "><?php echo number_format($costprod, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>
            <div class="campo" style=" text-align: right; width: 7%; "><?php echo number_format($cantprod, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>

            <div class="campo" style=" text-align: right; width: 7%; "><?php echo number_format($costinsu, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>
            <div class="campo" style=" text-align: right; width: 7%; "><?php echo number_format($Cantidad, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>
            <div class="campo" style=" text-align: right; width: 7%; "><?php echo number_format($Costo, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>
            <div class="campo" style=" text-align: right; width: 7%; "><?php echo number_format($price, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>

            <div class="campo" style=" text-align: right; width: 5%; "><?php echo number_format($util, 2, $_POST["SimDec"], $_POST["SimMil"]);  ?>%</div>

        </div>
        <div style="text-align: left; float:left; width: 100%;">
            <div class="campo" style=" text-align: left; width: 6%; visibility:hidden;">.</div>


            <div class="campo" style=" text-align: left; width: 7%; visibility:hidden;">.</div>
            <div class="campo" style=" text-align: left; width: 6%; visibility:hidden;">.</div>
            <div class="campo" style=" text-align: left; width: 8%; visibility:hidden;">.</div>
            <div class="campo" style=" text-align: right; width: 16%; "><?php echo lang("Totales"); ?> </div>

            <?php
            $totalcost = $costprod2 + $Costo2;
            $util = (($price2 - $totalcost) / $totalcost) * 100;
            ?>
            <div class="campo" style=" text-align: right; width: 7%; "><?php echo number_format($cantinsu2, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>

            <div class="campo" style=" text-align: right; width: 7%; "><?php echo number_format($costprod2, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>
            <div class="campo" style=" text-align: right; width: 7%; "><?php echo number_format($cantprod2, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>

            <div class="campo" style=" text-align: right; width: 7%; "><?php echo number_format($costinsu2, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>
            <div class="campo" style=" text-align: right; width: 7%; "><?php echo number_format($Cantidad2, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>
            <div class="campo" style=" text-align: right; width: 7%; "><?php echo number_format($Costo2, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>
            <div class="campo" style=" text-align: right; width: 7%; "><?php echo number_format($price2, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>

            <div class="campo" style=" text-align: right; width: 5%; "><?php echo number_format($util, 2, $_POST["SimDec"], $_POST["SimMil"]);  ?>%</div>

        </div>
        <div style="PAGE-BREAK-AFTER: always; visibility: hidden;"></div>
        <form id="formexcel" action="excelproduccion.php" method="post">

            <?php
            $compa = $_POST["CompanyActual"];
            $name = "OrdenDeProduccion";
            ?>
            <input type="hidden" name="Query" id="Query" value="<?php echo $query; ?>" />
            <input type="hidden" name="Name" id="Name" value="<?php echo $name; ?>" />
            <input type="hidden" name="vas" id="vas" value="Produccion" />
        </form>
</body>
<script>
    const totalPages = document.querySelectorAll('.page').length;
    document.documentElement.style.setProperty('--total-pages', totalPages);
</script>

</html>