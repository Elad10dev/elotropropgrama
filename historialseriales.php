<?php

include "ambiente.php";
$conn = ConectarConsultas();
session_start();

$fechaD = $_POST["FECH"];
$fechaH = $_POST["FECH2"];

if ($_POST['IdiomaActual'] == '') {
    $_POST['IdiomaActual'] = $_POST['IdiomaActual'];
}
if ($_POST["CD"] == '') {
    $_POST["CD"] = $_POST["CD"];
}
if ($_POST["SimDec"] == '') {
    $_POST["SimDec"] = $_POST["SimDec"];
}
if ($_POST["SimMil"] == '') {
    $_POST["SimMil"] = $_POST["SimMil"];
}
if ($_POST["CompanyActual"] == '') {
    $_POST["CompanyActual"] = $_POST["CompanyActual"];
}
if ($_POST["litfiscal"] == '') {
    $_POST["litfiscal"] = $_POST["litfiscal"];
}
if ($_POST["direccion"] == '') {
    $_POST["direccion"] = $_POST["direccion"];
}
if ($_POST["NameCompany"] == '') {
    $_POST["NameCompany"] = $_POST["NameCompany"];
}
if ($_POST["CompanyActual"] == '') {
    $_POST["CompanyActual"] = $_POST["CompanyActual"];
}
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
        <?php echo lang("Historial de Seriales"); ?></title>
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
    <button class='ocultoimpresion ' onclick='document.getElementById(`formexcel`).submit()'><img src='/img/excel.png' width='28' height='28'><br>Histórico <br></button>
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
                    <?php echo lang("Historial de Seriales"); ?></div>
                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                    <?php echo lang("Orden por"); ?>:
                    <?php
                    if ($_POST["OrdenSE"] == "1") {
                        echo lang("Código");
                    }
                    if ($_POST["OrdenSE"] == "2") {
                        echo lang("Descripción");
                    }
                    if ($_POST["OrdenSE"] == "3") {
                        echo lang("Seriales");
                    }
                    if ($_POST["OrdenSE"] == "4") {
                        echo lang("Fecha");
                    }
                    ?>
                </div>

                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">Fecha:
                    <?php
                    if ($_POST["FECH"] == true) {
                        echo $fechaD;
                    }
                    if ($_POST["FECH2"] == true) {
                        echo "  " . lang("al") . "  " . $fechaH;
                    }
                    ?>
                </div>
                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                    <?php
                    if ($_POST["Almacen23"] == FALSE) {
                        echo "--------------------";
                    }
                    if ($_POST["Almacen23"] == true) {
                        echo lang("Almacen") . ":";
                        $array2 = $_POST["Almacen23"];
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
                    } ?></div>

                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                    <?php
                    if ($_POST["Filtrar"] == FALSE) {
                        echo "--------------------";
                    }
                    if ($_POST["Filtrar"] == true) {
                        echo lang("Filtrado por") . ":";
                        $array = $_POST["Filtrar"];
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
                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                    <?php if ($_POST["BeneficiarioSE"] == TRUE) {
                        echo lang("Beneficiario") . ": " . $_POST["BeneficiarioSE2"];
                    } else {
                        echo "--------------------";
                    } ?>
                </div>
                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                    <?php if ($_POST["Producto2"] == TRUE) {
                        echo lang("Producto") . ": " . $_POST["Producto3"];
                    } else {
                        echo "--------------------";
                    } ?>
                </div>
                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                    <?php
                    if ($_POST["Serial"] == TRUE or $_POST["serialH"] == TRUE) {
                        if ($_POST["Serial"] == TRUE and $_POST["serialH"] == TRUE) {
                            echo lang("Serial desde") . ":" . $_POST["Serial"] . " " . lang("Serial hasta") . ": " . $_POST["serialH"];
                        } ?>
                    <?php
                        if ($_POST["Serial"] == TRUE and $_POST["serialH"] == false) {
                            echo lang("Serial desde") . ":" . $_POST["Serial"];
                        }
                        if ($_POST["Serial"] == false and $_POST["serialH"] == TRUE) {
                            echo lang("Serial hasta") . ":" . $_POST["serialH"];
                        }
                    } else {
                        echo "--------------------";
                    } ?>
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
            <div class="campo" style=" text-align: left; width: 6%; background-color: gray;">
                <?php echo lang("C/Barra"); ?></div>
            <div class="campo" style=" text-align: left; width: 15%; background-color: gray;">
                <?php echo lang("Descripción"); ?></div>
            <div class="campo" style=" text-align: left; width: 8%; background-color: gray;">
                <?php echo lang("Serial"); ?>
            </div>
            <div class="campo" style=" text-align: left; width: 11%; background-color: gray;">
                <?php echo lang("Fecha"); ?></div>
            <div class="campo" style=" text-align: left; width: 9%; background-color: gray;">
                <?php echo lang("Operación"); ?>
            </div>
            <div class="campo" style=" text-align: left; width: 7%; background-color: gray;">
                <?php echo lang("Usuario"); ?>
            </div>
            <div class="campo" style=" text-align: left; width: 15%; background-color: gray;">
                <?php echo lang("Cliente o Proveedor"); ?>
            </div>
            <div class="campo" style=" text-align: left; width: 10%; background-color: gray;">
                <?php echo lang("Depósito"); ?>
            </div>
            <div class="campo" style=" text-align: right; width: 10%; background-color: gray;">
                <?php echo lang("Cantidad"); ?>
            </div>
            <?php if ($_POST['userperfil'] <= 2000 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
                <div class="campo" style=" text-align: right; width: 6%; background-color: gray;">
                    <?php echo lang("Monto"); ?>
                </div>
            <?php } ?>
        </div>
        <?php
        if (!empty($_POST["mIdProductos"])) {
            $Producto = " and a.CodIdBasico in ('" . implode("','", $_POST["mIdProductos"]) . "')";
        }


        if ($_POST["OrdenSE"] == TRUE) {
            "order by a.CodIdBasico,b.Referencia,a.Seriales,b.Fectxclient";
            if ($_POST["OrdenSE"] == "1") {
                $OrdenBy = " order by a.CodIdBasico,b.Fectxserver,a.Cant*d.Inventario ASC";
            }
            if ($_POST["OrdenSE"] == "2") {
                $OrdenBy = " order by a.Descripcion,b.Fectxserver,a.Cant*d.Inventario ASC";
            }
            if ($_POST["OrdenSE"] == "3") {
                $OrdenBy = " order by a.Seriales,b.Fectxserver,a.Cant*d.Inventario ASC";
            }
            if ($_POST["OrdenSE"] == "4") {
                $OrdenBy = " order by b.Fectxserver,a.Cant*d.Inventario ASC";
            }
        }
        $Betweenserial = "";

        if ($_POST["Serial"] == true and $_POST["Serial2"] == true) {
            $Betweenserial = "and a.Seriales BETWEEN '" . $_POST["Serial"] . "' and '" . $_POST["Serial2"] . "'";
        }
        if ($_POST["Serial"] == true and $_POST["Serial2"] == false) {
            $Betweenserial = "and a.Seriales BETWEEN '" . $_POST["Serial"] . "' and '" . $_POST["Serial"] . "'";
        }
        if ($_POST["Serial"] == false and $_POST["Serial2"] == true) {
            $Betweenserial = "and a.Seriales BETWEEN '" . $_POST["Serial2"] . "' and '" . $_POST["Serial2"] . "'";
        }

        if (!empty($_POST["mIdAlmacen"])) {
            $Almacen23 = " and a.IdAlm in ('" . implode("','", $_POST["mIdAlmacen"]) . "')";
        }
        if ($_POST['userperfil'] <= 2000 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") {
            $monto = ",round(b.Total*d.Inventario,2) as Monto";
        }

        $Idtipotx = "";
        if (!empty($_POST["Filtrar"])) {
            $Idtipotx = " and d.Idtipotx in ('" . implode("','", $_POST["Filtrar"]) . "')";
        }

        $BeneficiarioSE = "";
        if (!empty($_POST["mIdProevedor"])) {
            $BeneficiarioSE = "and e.RUT in ('" . implode("','", $_POST["mIdProevedor"]) . "')";
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
                b.Idtipotx,
                b.IdtipotxPadre,
                b.IdtxPadre,
                b.IdEstacionPadre,
                c.CodBarra,
                c.CodIdBasico,
                c.CodIdAmpliado,
                c.Descripcion,
                a.Seriales,
                DATE_FORMAT(a.Fectxclient, '%d/%m/%Y %h:%i:%s %p') as Fectxclient,
                concat(d.TitCto, '-', if(if(a.Idtipotx in (1, 2, 3, 4, 5, 6, 11, 12, 13, 15, 21, 22, 23, 24, 25, 26, 31, 35, 36, 37), " . $NumTxViewVTA . ", if(a.Idtipotx in (7, 14, 20, 27, 28), " . $NumTxViewCOM . ", if(a.Idtipotx in (8, 9, 10, 16, 17, 18, 19, 29, 30, 32, 33, 34, 39), " . $NumTxViewINV . ", ''))) = 0, b.IdtxCompany, if(if(a.Idtipotx in (1, 2, 3, 4, 5, 6, 11, 12, 13, 15, 21, 22, 23, 24, 25, 26, 31, 35, 36, 37), " . $NumTxViewVTA . ", if(b.Idtipotx in (7, 14, 20, 27, 28), " . $NumTxViewCOM . ", if(b.Idtipotx in (8, 9, 10, 16, 17, 18, 19, 29, 30, 32, 33, 34, 39), " . $NumTxViewINV . ", ''))) = 1, b.Idtx, b.Referencia))) as Titulo ,
                CONCAT(e.RUT, ' ', e.Nombre) as beneficiario,
                concat('(', a.IdAlm, ') ', f.Nombre) as Almacen ,
                a.factorunit,
                a.Medida,
                b.DAmpliado,
                a.Cant * d.Inventario as cant ,
                users.Nombre as Usuario,
                round(b.Total * d.Inventario, 2) as Monto
            from
                PosUpTxD a
            inner join PosUpProducto c on
                c.IdCompany = a.IdCompany
	            and c.CodIdBasico = a.CodIdBasico 
            inner join PosUpTxC b on
                b.IdCompany = a.IdCompany
                and b.Idtx = a.Idtx
                and b.Idtipotx = a.Idtipotx
                and b.IdEstacion = a.IdEstacion
            inner join posupusers users on
                users.IdCompany = b.IdCompany
	            and users.Login = b.IdUser 
            inner join PosUpTx d on
                d.Idtipotx = a.Idtipotx
            left join PosUpclientes e on
                e.IdCompany = b.IdCompany
                and e.RUT = b.IdBen
            inner join PosUpAlmacen f on
                f.IdCompany = a.IdCompany
                and f.IdAlm = a.IdAlm
            where a.IdCompany=" . $_POST["CompanyActual"] . " 
                and a.Fectxclient BETWEEN '" . $fechaD . " 00:00:00' 
                and '" . $fechaH . " 23:59:59' 
                " . $Almacen23 . "
                " . $Producto . "
                " . ($Betweenserial !== "" ? $Betweenserial : " and a.Seriales <> ''")  . "
                " . $BeneficiarioSE . "
                " . $Idtipotx . "
                " . $OrdenBy . "
        ";




        if ($result = mysqli_query($conn, $query)) {
            $n = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                $n = $n + 1;
                $nt = $nt + 1;
                $costo = $costo + $row["Monto"];
                $cantidad = $cantidad + $row["cant"];
                $costo2 = $costo2 + $row["Monto"];
                $cantidad2 = $cantidad2 + $row["cant"];
        ?>
                <div style="text-align: left; float:left; width: 100%;">
                    <div class="campo" style=" text-align: left; width: 6%; ">
                        <?php if ($row['CodBarra'] == "") {
                            echo "-";
                        } else {
                            echo $row['CodBarra'];
                        } ?></div>
                    <div class="campo" style=" text-align: left; width: 15%; ">
                        <?php if ($row['Descripcion'] == "") {
                            echo ".";
                        } else {
                            echo $row['Descripcion'];
                        } ?>
                    </div>
                    <div class="campo" style=" text-align: left; width: 8%; ">
                        <?php if ($row['Seriales'] == "") {
                            echo ".";
                        } else {
                            echo $row['Seriales'];
                        } ?></div>
                    <div class="campo" style=" text-align: left; width: 11%; ">
                        <?php if ($row['Fectxclient'] == "") {
                            echo ".";
                        } else {
                            echo $row['Fectxclient'];
                        } ?></div>
                    <?PHP if ($row['Idtipotx'] == "7") {
                        $querycc = "select y.Referencia,y.DAmpliado from  PosUpTxC y 
                    where y.IdCompany = " . $_POST["CompanyActual"] . "
                    and y.Idtx=" . $row["IdtxPadre"] . " 
                    and y.Idtipotx in (" . $row["IdtipotxPadre"] . ",20) 
                    and y.IdEstacion = '" . $row["IdEstacionPadre"] . "'";
                        //echo $querycc;
                        $refen = "";
                        if ($resultcc = mysqli_query($conn, $querycc)) {
                            while ($rowcc = mysqli_fetch_assoc($resultcc)) {
                                $refen = " " . $rowcc['Referencia'];
                                $refen .= " " . $rowcc['DAmpliado'];
                            }
                        }
                        //$refe="";
                        //echo $refen;
                    ?>
                        <div class="campo" style=" text-align: left; width: 9%; ">
                            <?php if ($row['Titulo'] == "") {
                                echo "." . $refen;
                            } else {
                                echo $row['Titulo'] . $refen;
                            } ?></div>
                    <?PHP } else { ?>
                        <div class="campo" style=" text-align: left; width: 9%; ">
                            <?php if ($row['Titulo'] == "") {
                                echo ".";
                            } else {
                                echo $row['Titulo'];
                            } ?></div>
                    <?PHP } ?>
                    <div class="campo" style=" text-align: left; width: 7%; ">
                        <?php if ($row['Usuario'] == "") {
                            echo ".";
                        } else {
                            echo $row['Usuario'];
                        } ?></div>
                    <div class="campo" style=" text-align: left; width: 15%; ">
                        <?php if ($row['beneficiario'] == '') {
                            echo ".";
                        } else {
                            echo $row['beneficiario'] . ".";
                        }
                        echo (trim($row['DAmpliado']) !== "" ? "<br><div style='text-align: left; width: 100%; background-color: gray; font-weight: bold;'>" . trim($row['DAmpliado']) . "</div>" : "")
                        ?></div>
                    <div class="campo" style=" text-align: left; width: 10%; ">
                        <?php if ($row['Almacen'] == "") {
                            echo ".";
                        } else {
                            echo $row['Almacen'];
                        }  ?></div>
                    <div class="campo" style=" text-align: right; width: 10%; ">
                        <?php
                        if ($row['cant'] == "") {
                            echo ".";
                        } else {
                            echo ($row['factorunit'] <> 1 ? " " . $row['factorunit'] . " x " . getcantformat($row['cant'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " = " . getcantformat($row['cant'] * $row['factorunit'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])  : number_format($row['cant'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])) . " " . $row["Medida"];
                        }
                        ?>
                    </div>
                    <?php if ($_POST['userperfil'] <= 2000 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
                        <div class="campo" style=" text-align: right; width: 6%; ">
                            <?php if ($row['Monto'] == "") {
                                echo ".";
                            } else {
                                echo number_format($row['Monto'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                            } ?></div> <?php } ?>
                </div>

                <?php
                if ($_POST['ivs'] == true) {
                    $querys = "SELECT f.ITEM,e.VALOR,f.pathimg,e.IdVariacion , g.ITEM,g.IdVarios,g.pathimg as icono, f.ITEM AS varias
                    from PosUpProductoVar e
                    inner join  PosUpvarios f on e.IdCompany=f.IdCompany and f.IdVarios=e.IDVariacion and f.TIPOITEM=1002
                    LEFT join  PosUpvarios g on f.IdCompany=g.IdCompany and f.esserial=g.esserial and g.TIPOITEM=1001
                    where e.IdCompany =" . $_POST["CompanyActual"] . " and e.Serial = '" . $row["Seriales"] . "' 
                    Order by g.ITEM ";
                    if ($results = mysqli_query($conn, $querys)) {
                        $n = $n + 2;
                ?><div style="text-align: left; float:left; width: 100%;">
                            <?php
                            $espacio = 0;
                            while ($rows = mysqli_fetch_assoc($results)) {
                                $espacio = $espacio + 1;
                                if ($espacio == 1) {
                                    echo " Variaciones &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                } else {
                                }
                            ?>
                                <i style="color:<?php echo $rows["pathimg"]; ?>" class="<?php echo  $rows["icono"];  ?> fa-1x" name="busca" value="">
                                    <?php echo  $rows["varias"];  ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i>
                                <?php
                                if ($espacio == 1) {
                                ?><div class="encabezado" style="font-size: 2px;">
                                        <hr>
                                        </hr>
                                    </div>
                            <?php
                                } else {
                                }
                            }
                            mysqli_free_result($results);
                            ?>
                        </div>

                <?php
                    }
                }
                ?>




                <?php
                $unidadTotal = $unidadTotal + $row["unidad"];
                $ExistenciaTotal = $ExistenciaTotal + $row["Cantidad"];
                if ($n >= 45) { ?>
                    <div class="encabezado" style="font-size: 2px;">
                        <hr>
                        <div class="campo" style="visibility:hidden; text-align: left; width: 9%; background-color: white;">Totales Registros</div>
                        <div class="campo" style="visibility:hidden; text-align: left; width: 3%; background-color: white;">Totales Registros</div>
                        <div class="campo" style="visibility:hidden; text-align: left; width: 3%; background-color: white;">Totales Registros</div>
                        <div class="campo" style="visibility:hidden; text-align: left; width: 3%; background-color: white;">Totales Registros</div>
                        <div class="campo" style="visibility:hidden; text-align: left; width: 6%; background-color: white;">Totales Registros</div>
                        <div class="campo" style=" text-align: left; width: 16%; background-color: white;">
                            <?php echo "Registros por Pagina=" . $n ?></div>
                        <div class="campo" style=" text-align: right; width: 15%; background-color: white;">Totales por pagina</div>
                        <div class="campo" style="visibility:hidden;  text-align: left; width: 15%; background-color: white;">a</div>
                        <div class="campo" style="visibility:hidden;  text-align: left; width: 16%; background-color: white;">a<?php ?></div>
                        <div class="campo" style=" text-align: right; width: 5%; "><strong>
                                <?php echo $cantidad; ?></strong></div>
                        <?php if ($_POST['userperfil'] <= 2000 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
                            <div class="campo" style=" text-align: right; width: 6%; "><strong>
                                    <?php echo $costo; ?></strong> </div>
                        <?php } ?>
                    </div>
                    <div class="encabezado" style="font-size: 2px;">
                        <hr>
                        <div class="campo" style="visibility:hidden; text-align: left; width: 9%; background-color: white;">Totales Registros</div>
                        <div class="campo" style="visibility:hidden; text-align: left; width: 3%; background-color: white;">Totales Registros</div>
                        <div class="campo" style="visibility:hidden; text-align: left; width: 3%; background-color: white;">Totales Registros</div>
                        <div class="campo" style="visibility:hidden; text-align: left; width: 3%; background-color: white;">Totales Registros</div>
                        <div class="campo" style="visibility:hidden; text-align: left; width: 6%; background-color: white;">Totales Registros</div>
                        <div class="campo" style=" text-align: left; width: 16%; background-color: white;">
                            <?php echo "Registros Acumulados=" . $n ?></div>
                        <div class="campo" style=" text-align: right; width: 15%; background-color: white;">Totales Acumulados</div>
                        <div class="campo" style="visibility:hidden;  text-align: left; width: 15%; background-color: white;">a</div>
                        <div class="campo" style="visibility:hidden;  text-align: left; width: 16%; background-color: white;">a<?php ?></div>
                        <div class="campo" style=" text-align: right; width: 5%; ">
                            <?php echo $cantidad2; ?></div>
                        <?php if ($_POST['userperfil'] <= 2000 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
                            <div class="campo" style=" text-align: right; width: 6%; ">
                                <?php echo $costo2; ?></div>
                        <?php } ?>
                    </div>
                    <div style="PAGE-BREAK-AFTER: always"></div>
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
                                <?php echo lang("Historial de Seriales"); ?></div>
                            <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                                <?php echo lang("Orden por"); ?>: <?php
                                                                    if ($_POST["OrdenSE"] == "1") {
                                                                        echo lang("Código");
                                                                    }
                                                                    if ($_POST["OrdenSE"] == "2") {
                                                                        echo lang("Descripción");
                                                                    }
                                                                    if ($_POST["OrdenSE"] == "3") {
                                                                        echo lang("Seriales");
                                                                    }
                                                                    if ($_POST["OrdenSE"] == "4") {
                                                                        echo lang("Fecha");
                                                                    }
                                                                    ?>
                            </div>

                            <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">Fecha: <?php
                                                                                                                                                if ($_POST["FECH"] == true) {
                                                                                                                                                    echo $fechaD;
                                                                                                                                                }
                                                                                                                                                if ($_POST["FECH2"] == true) {
                                                                                                                                                    echo "  " . lang("al") . "  " . $fechaH;
                                                                                                                                                }
                                                                                                                                                ?>
                            </div>
                            <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                                <?php
                                if ($_POST["Almacen23"] == FALSE) {
                                    echo "--------------------";
                                }
                                if ($_POST["Almacen23"] == true) {
                                    echo lang("Almacen") . ":";
                                    $array2 = $_POST["Almacen23"];
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
                                } ?></div>

                            <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                                <?php
                                if ($_POST["Filtrar"] == FALSE) {
                                    echo "--------------------";
                                }
                                if ($_POST["Filtrar"] == true) {
                                    echo lang("Filtrado por") . ":";
                                    $array = $_POST["Filtrar"];
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
                            <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                                <?php if ($_POST["BeneficiarioSE"] == TRUE) {
                                    echo lang("Beneficiario") . ": " . $_POST["BeneficiarioSE2"];
                                } else {
                                    echo "--------------------";
                                } ?>
                            </div>
                            <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                                <?php if ($_POST["Producto2"] == TRUE) {
                                    echo lang("Producto") . ": " . $_POST["Producto3"];
                                } else {
                                    echo "--------------------";
                                } ?>
                            </div>
                            <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
                                <?php
                                if ($_POST["Serial"] == TRUE or $_POST["serialH"] == TRUE) {
                                    if ($_POST["Serial"] == TRUE and $_POST["serialH"] == TRUE) {
                                        echo lang("Serial desde") . ":" . $_POST["Serial"] . " " . lang("Serial hasta") . ": " . $_POST["serialH"];
                                    } ?>
                                <?php
                                    if ($_POST["Serial"] == TRUE and $_POST["serialH"] == false) {
                                        echo lang("Serial desde") . ":" . $_POST["Serial"];
                                    }
                                    if ($_POST["Serial"] == false and $_POST["serialH"] == TRUE) {
                                        echo lang("Serial hasta") . ":" . $_POST["serialH"];
                                    }
                                } else {
                                    echo "--------------------";
                                } ?>
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
                        <div class="campo" style=" text-align: left; width: 6%; background-color: gray;">
                            <?php echo lang("C/Barra"); ?></div>
                        <div class="campo" style=" text-align: left; width: 15%; background-color: gray;">
                            <?php echo lang("Descripción"); ?></div>
                        <div class="campo" style=" text-align: left; width: 8%; background-color: gray;">
                            <?php echo lang("Serial"); ?>
                        </div>
                        <div class="campo" style=" text-align: left; width: 11%; background-color: gray;">
                            <?php echo lang("Fecha"); ?></div>
                        <div class="campo" style=" text-align: left; width: 9%; background-color: gray;">
                            <?php echo lang("Operación"); ?>
                        </div>
                        <div class="campo" style=" text-align: left; width: 7%; background-color: gray;">
                            <?php echo lang("Usuario"); ?>
                        </div>
                        <div class="campo" style=" text-align: left; width: 15%; background-color: gray;">
                            <?php echo lang("Cliente o Proveedor"); ?>
                        </div>
                        <div class="campo" style=" text-align: left; width: 10%; background-color: gray;">
                            <?php echo lang("Depósito"); ?>
                        </div>
                        <div class="campo" style=" text-align: right; width: 10%; background-color: gray;">
                            <?php echo lang("Cantidad"); ?>
                        </div>
                        <?php if ($_POST['userperfil'] <= 2000 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?><div class="campo" style=" text-align: right; width: 6%; background-color: gray;">
                                <?php echo lang("Monto"); ?>
                            </div>
                        <?php } ?>
                    </div>

        <?php
                    $n = 0;
                    $costo = 0;
                    $cantidad = 0;
                }
            }
            mysqli_free_result($result);
        } ?>
        <div class="encabezado" style="font-size: 2px;">
            <hr>
            <div class="campo" style="visibility:hidden; text-align: left; width: 9%; background-color: white;">Totales Registros</div>
            <div class="campo" style="visibility:hidden; text-align: left; width: 3%; background-color: white;">Totales Registros</div>
            <div class="campo" style="visibility:hidden; text-align: left; width: 3%; background-color: white;">Totales Registros</div>
            <div class="campo" style="visibility:hidden; text-align: left; width: 3%; background-color: white;">Totales Registros</div>
            <div class="campo" style="visibility:hidden; text-align: left; width: 6%; background-color: white;">Totales Registros</div>
            <div class="campo" style=" text-align: left; width: 16%; background-color: white;">
                <?php echo lang("Registros por Pagina") . "=" . $n ?></div>
            <div class="campo" style=" text-align: right; width: 15%; background-color: white;">
                <?php echo lang("Totales por pagina"); ?></div>
            <div class="campo" style="visibility:hidden;  text-align: left; width: 15%; background-color: white;">a</div>
            <div class="campo" style="visibility:hidden;  text-align: left; width: 16%; background-color: white;">a<?php ?></div>
            <div class="campo" style=" text-align: right; width: 5%; "><strong>
                    <?php echo $cantidad; ?></strong></div>
            <?php if ($_POST['userperfil'] <= 2000 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?><div class="campo" style=" text-align: right; width: 6%; "><strong>
                        <?php echo $costo; ?></strong> </div>
            <?php } ?>
        </div>
        <div class="encabezado" style="font-size: 2px;">
            <hr>
            <div class="campo" style="visibility:hidden; text-align: left; width: 9%; background-color: white;">Totales Registros</div>
            <div class="campo" style="visibility:hidden; text-align: left; width: 3%; background-color: white;">Totales Registros</div>
            <div class="campo" style="visibility:hidden; text-align: left; width: 3%; background-color: white;">Totales Registros</div>
            <div class="campo" style="visibility:hidden; text-align: left; width: 3%; background-color: white;">Totales Registros</div>
            <div class="campo" style="visibility:hidden; text-align: left; width: 6%; background-color: white;">Totales Registros</div>
            <div class="campo" style=" text-align: left; width: 16%; background-color: white;">
                <?php echo lang("Registros Acumulados") . "=" . $n ?></div>
            <div class="campo" style=" text-align: right; width: 15%; background-color: white;">
                <?php echo lang("Totales Acumulados"); ?></div>
            <div class="campo" style="visibility:hidden;  text-align: left; width: 15%; background-color: white;">a</div>
            <div class="campo" style="visibility:hidden;  text-align: left; width: 16%; background-color: white;">a<?php ?></div>
            <div class="campo" style=" text-align: right; width: 5%; ">
                <?php echo $cantidad2; ?></div>
            <?php if ($_POST['userperfil'] <= 2000 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?><div class="campo" style=" text-align: right; width: 6%; ">
                    <?php echo $costo2; ?></div>
            <?php } ?>
        </div>
        <div style="PAGE-BREAK-AFTER: always; visibility: hidden;">a</div>
        <form id="formexcel" action="excelv3led.php" method="post">
            <?php
            ?>
            <?php
            $compa = $_POST["CompanyActual"];
            $name = lang("HistoricoSeriales") . ".csv";
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