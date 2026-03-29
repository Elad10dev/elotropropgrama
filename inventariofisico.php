<?php

include "ambiente.php";
$conn = ConectarConsultas();
session_start();
if ($_SESSION['IdiomaActual'] == '') {
    $_SESSION['IdiomaActual'] = $_POST['IdiomaActual'];
}
// if ($_POST["Proevedor/"] == true) {
//     $having = "having";
//     $Proevedor = "and c.idBen= '" . $_POST["Proevedor"] . "'";
// }
$Deposito2 = "";
$Deposito = "";
if (!empty($_POST["mIdAlmacen"])) {
    $Deposito = " and a.IdAlm in ('" . implode("','", $_POST["mIdAlmacen"]) . "')";
    $Deposito2 = "having IdDeposito  in ('" . implode("','", $_POST["mIdAlmacen"]) . "','0')";
}
if (!empty($_POST["mIdMarca"])) {
    $having = "having";
    $Marca = "and a.Marca in ('" . implode("','", $_POST["mIdMarca"]) . "')";
}
if ($_POST['group'] == 'fami') {
    $fam = " v.ITEM,";
}
if ($_POST['group'] == 'marc') {
    $mar = " d.nombre,";
}
if ($_POST["OrdenXXX"] == "Codigo") {
    $Orden = "order by " . $mar . $fam . " a.CodIdBasico";
}
if ($_POST["OrdenXXX"] == "Descripcion") {
    $Orden = "order by " . $mar . $fam . "a.Descripcion,a.CodIdAmpliado";
}
if ($_POST["OrdenXXX"] == "Referencia") {
    $Orden = "order by " . $mar . $fam . "a.CodBarra";
}
if ($_POST["OrdenXXX"] == "Instancia") {
    $Orden = "order by " . $mar . $fam . "a.Idfamilia,a.CodIdAmpliado";
}
if (!empty($_POST["mIdfamilia"])) {
    $familia = " and a.Idfamilia in ('" . implode("','", $_POST["mIdfamilia"]) . "') ";
}

if (!empty($_POST["mIdProductos"])) {
    $beetween = " and a.CodIdBasico in ('" . implode("','", $_POST["mIdProductos"]) . "') ";
}
if (!$_POST["ExistenciaXXX"] == "on") {
    $ExistenciaCero = " and round(b.cantidad,3)<>0";
}
if (!$_POST["AlmacenXXX"] == "on") {
    $AlmacenXXX = " and b.idalm > 0";
}

$buscar = "";
if ($_POST["EnvioEstado"] !== "*") {
    $buscar .= " and a.Estado = " . $_POST["EnvioEstado"];
}
$fechaA = " where a.Fectxclient <= '" . $_POST["FechaHastafisico"] . " 23:59:59' ";
//$fechaC = " where c.Fectxclient <= '" . $_POST["FechaHastafisico"] . " 23:59:59' and a.IdCompany=" . $_POST["CompanyActual"] . "";
//$fechaAA = " and a.Fectxclient <= '" . $_POST["FechaHastafisico"] . " 23:59:59'";
//$fechaCA = " and c.Fectxclient <= '" . $_POST["FechaHastafisico"] . " 23:59:59'";
if ($_POST['mexis'] == true) {
    $actexi = 1;
}
if ($_POST['sucursal'] <> '0') {
    $ubic = "and y.IdUbi=" . $_POST['sucursal'] . "";
}
$query = "SET SESSION group_concat_max_len = 1000000";
$result = mysqli_query($conn, $query);
if ($_POST["SerialesXXX"] == "on") {
    $seriales = ",Seriales";
}
$array = [];

$cuniP1d = "";
if ($row['cuniP1d'] <> 0) {
    if (trim($row['cuniP1d']) !== "") {
        $cuniP1d .= number_format($row['cuniP1d'], 0, $_POST["SimDec"], $_POST["SimMil"]) . " ";
    } else {
        $cuniP1d .= number_format($row['cuniP1d'], 0, $_POST["SimDec"], $_POST["SimMil"]) . " ";
    }
    if (trim($row['uniP1d']) !== "") {
        $cuniP1d .= '(' . substr($row['uniP1d'], 0, 3) . ')';
    } else {
        $cuniP1d .= '(UND)';
    }
} else {
    $cuniP1d .= "- ";
}
if ($row['cuniP2d'] <> 0 and $row['cuniP1d'] <> 0) {
    $cuniP1d .= ' y ';
}
if ($row['cuniP2d'] <> 0) {
    if (trim($row['cuniP2d']) !== "") {
        $cuniP1d .=  " " . number_format($row['cuniP2d'], 0, $_POST["SimDec"], $_POST["SimMil"]) . " ";
    }
    if (trim($row['uniP2d']) !== "") {
        $cuniP1d .=   '(' . substr($row['uniP2d'], 0, 3) . ')';
    }
}

if ($_POST['group'] == 'fami') {
    $titt = 'Marca';
}
if ($_POST['group'] == 'marc') {
    $titt = 'Familia';
}
if ($_POST['group'] == '0') {
    $titt = 'Marca';
}


$array[] = [
    "CodBarra" => lang("Código Barra"),
    "CodIdAmpliado" => lang("S.K.U"),
    "Producto" => lang("Descripción"),
    "groups" => $titt,
    "Deposito" => lang("Deposito"),
    "uniP1d" => lang("Referencia"),
    "mexis1" => $_POST['mexis'] == true ? lang("Exis.Teorica") : "",
    "mexis2" => $_POST['mexis'] == true ? lang("Desglose") : "",
    "uniP1d2" => lang("Exis. Real"),
    "Seriales" =>  $_POST['SerialesXXX'] == true ? lang("Seriales") : "",
];

$detalleInv = "";

$query = "SELECT  a.CodIdAmpliado,a.CodBarra,a.CodIdBasico, a.Descripcion as Producto, coalesce(b.idalm,0) as IdDeposito, Coalesce(b.NomAlm,'No Utilizado') as Deposito,COALESCE(round(coalesce(b.cantidad,0),2),0) as exist, ROUND(COALESCE(round(coalesce(b.cantidad,0),2),0) * a.factorunit,2) as exist2, COALESCE(a.medida,'UND') as uniP1,COALESCE(a.medida,'UND') as uniP1d,a.UnidadP1 as uniP2d,a.CantP1,COALESCE(a.medida,'UND') as Medida,COALESCE(a.factorunit,1) as factorunit, truncate(b.cantidad,0) as cuniP1d, round(a.CantP1 * (b.cantidad-truncate(b.cantidad,0)),0) as cuniP2d, d.nombre as NombreMarca,v.ITEM as Familia" . $seriales . "  
    FROM PosUpProducto a 
    left join (
            select kk.IdCompany,kk.IdAlm,kk.NomAlm as NomAlm, kk.CodIdBasico, sum(kk.Cantidad) as Cantidad,GROUP_CONCAT(distinct Seriales ORDER BY Seriales ASC SEPARATOR ' ') as Seriales 
            from (
                SELECT a.IdCompany,a.IdAlm,e.Nombre as NomAlm, b.CodIdBasico, sum(coalesce(a.Cant)*coalesce(d.Inventario)) as Cantidad, Seriales
                FROM PosUpTxD a 
                right join PosUpProducto b on a.IdCompany=b.IdCompany and a.CodIdBasico=b.CodIdBasico 
                inner join PosUpTx d on a.Idtipotx=d.Idtipotx and d.Inventario <> 0 
                left join PosUpAlmacen e on a.IdCompany = e.IdCompany and a.IdAlm = e.IdAlm 
                " . $fechaA . " and a.IdCompany = " . $_POST["CompanyActual"] . "
                " . $Deposito . "
                group by a.IdCompany,a.idalm,b.CodIdBasico,Seriales having Cantidad<>0
                ) kk
        WHERE kk.IdCompany = " . $_POST["CompanyActual"] . "
        group by kk.IdCompany,kk.idalm,kk.CodIdBasico) b on a.IdCompany = b.IdCompany and a.CodIdBasico = b.CodIdBasico 
        left join (SELECT a.IdCompany,a.RUT, b.idBen,c.IdAlm, c.CodIdBasico 
        from PosUpclientes a inner join PosUpTxC b on a.IdCompany=b.IdCompany and a.RUT = b.idBen
        inner join PosUpTxD c on b.IdCompany =c.IdCompany and b.Idtipotx = c.Idtipotx and b.Idtx = c.Idtx and b.IdEstacion = c.IdEstacion
        inner join PosUpTx d on b.Idtipotx = d.Idtipotx and d.Inventario <> 0 
        WHERE a.IdCompany = " . $_POST["CompanyActual"] . "
        group by a.IdCompany, a.RUT,c.CodIdBasico
    ) c on a.IdCompany = c.IdCompany and a.CodIdBasico = c.CodIdBasico 
    left join PosUpAlmacen y on b.IdCompany = y.IdCompany and b.idalm = y.IdAlm 
    left join PosUpUbicacion z on y.IdCompany=c.IdCompany and y.IdUbi=z.IdUbi
    left join PosUpc_marcas d on a.IdCompany=d.IdCompany and a.Marca=d.idmarca 
    left join PosUpvarios v on v.IdCompany=a.IdCompany and v.IdVarios=a.Idfamilia and v.TIPOITEM = 2
    where a.IdCompany = " . $_POST["CompanyActual"] . " " . $ubic . " and a.EsCompuesto=0
    " . $buscar . "
    " . $beetween . "
    " . $ExistenciaCero . "                                       
    " . $AlmacenXXX . "
    " . $Marca . "
    " . $familia . "
    group by a.CodIdBasico,b.idalm
    " . $Orden . "
";
if ($_POST['group'] == 'fami') {
    $titt = 'Marca';
}
if ($_POST['group'] == 'marc') {
    $titt = 'Familia';
}
if ($_POST['group'] == '0') {
    $titt = 'Marca';
}
if ($result = mysqli_query($conn, $query)) {
    $pro = 0;
    $n = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $rowcount = $rowcount + 1;
        $n = $n + 1;
        $pro = $pro + 1;
        $pro2 = $pro2 + 1;
        $CostoExistencia = $CostoExistencia + $row["CostoExistencia"]; //c
        $ExistenciaTotal = $ExistenciaTotal + $row["exist"];
        $CostoExistencia2 = $CostoExistencia2 + $row["CostoExistencia"]; //c
        $ExistenciaTotal2 = $ExistenciaTotal2 + $row["exist"];
        if ($color == 0) {
            $color = 1;
        } else {
            $color = 0;
        }
        $groups = "-";
        if ($_POST['group'] == 'fami') {
            $yy = $row['Familia'];
            $groups = $row['NombreMarca'];
        }
        if ($_POST['group'] == 'marc') {
            $yy = $row['NombreMarca'];
            $groups = $row['Familia'];
        }
        if ($_POST['group'] == '0') {
            $groups = $row['NombreMarca'];
        }


        $Valid01 = "";
        if ($yy <> $zz) {
            $Valid01 .= "
            <div style='text-align: left; float:left; width: 100%;'>
                <div class='campo' style=' text-align: left; width: 45%;  font-weight:1400; font-size: 8px; padding-top:6px; '><strong> " . $yy . " </strong> </div>
            </div>";
        }
        $CodBarra = "";
        if (trim($row['CodBarra']) !== "") {
            $CodBarra = $row['CodBarra'];
        }
        $CodIdAmpliado = "";
        if (trim($row['CodIdAmpliado']) !== "") {
            $CodIdAmpliado = $row['CodIdAmpliado'];
        }
        $Producto = "";
        if (trim($row['Producto']) !== "") {
            $Producto = $row['Producto'];
        }
        $DepositoXA = "";
        if (trim($row['Deposito']) !== "") {
            $DepositoXA = $row['Deposito'];
        }
        $Abc = "";
        $Abc .= ($row['uniP1d'] === "" ? "UND" : $row['uniP1d']) . " ";
        if ($row['CantP1'] <> 0) {
            if ($row['CantP1'] !== "" && $row['CantP1'] !== 1) {
                $Abc .= ' = ' . number_format($row['CantP1'], 0, $_POST["SimDec"], $_POST["SimMil"]);
            }
            if (trim($row['uniP2d']) !== "") {
                $Abc .=  ' ' . $row['uniP2d'] . '';
            } else {
                $Abc .=  ' UND ';
            }
        }
        $mexis = "";
        if ($_POST['mexis'] == true) {
            $mexis2 = "";
            if ($row['cuniP1d'] <> 0) {
                if (trim($row['cuniP1d']) !== "") {
                    $mexis2 .= number_format($row['cuniP1d'], 0, $_POST["SimDec"], $_POST["SimMil"]) . " ";
                } else {
                    $mexis2 .= number_format(0, 0, $_POST["SimDec"], $_POST["SimMil"]) . " ";
                }
                if (trim($row['uniP1d']) !== "") {
                    $mexis2 .= '(' . substr($row['uniP1d'], 0, 3) . ')';
                } else {
                    $mexis2 .= '(UND)';
                }
            } else {
                $mexis2 .= '(UND)';
            }
            if ($row['cuniP2d'] <> 0 and $row['cuniP1d'] <> 0) {
                $mexis2 .= ' y ';
            }
            if ($row['cuniP2d'] <> 0) {
                if (trim($row['cuniP2d']) !== "") {
                    $mexis2 .= " " . number_format($row['cuniP2d'], 0, $_POST["SimDec"], $_POST["SimMil"]) . " ";
                }
                if (trim($row['uniP2d']) !== "") {
                    $mexis2 .= '(' . substr($row['uniP2d'], 0, 3) . ')';
                }
            }
            $mexis .= "

                <div class='campo' style='text-align: right; width: 10%; " . ($color == 0 ? "" : "background: #EDECEC;") . "'>
                " . ($row["factorunit"] <> 1 && $row["factorunit"] <> 0 ? " " . $row["factorunit"] . " x " . getcantformat($row["exist"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " = " . getcantformat($row["exist2"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $row["Medida"] : getcantformat($row["exist"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . ($row["Medida"] === "" ? "UND" : $row["Medida"])) . "
            </div>
                <div class='campo' style='text-align: right; width: 7%; " . ($color == 0 ? "" : "background: #EDECEC;") . "'>
               " . $mexis2 . "
            </div>
                ";
        }

        $uniP1d = "";
        if (trim($row['uniP1d']) !== "") {
            $uniP1d .= '_____(' . substr($row['uniP1d'], 0, 3) . ') ';
        } else {
            $uniP1d = '_____(UND) ';
        }
        if (trim($row['uniP2d']) !== "") {
            $uniP1d .= '_____(' . substr($row['uniP2d'], 0, 3) . ')';
        }

        $array[] = [
            "CodBarra" => $row['CodBarra'],
            "CodIdAmpliado" => $row['CodIdAmpliado'],
            "Producto" => $row['Producto'],
            "groups" => $groups,
            "Deposito" => $row['Deposito'],
            "uniP1d" => $row['uniP1d'] . " " . ($row['CantP1'] <> 0 ? ($row['CantP1'] == "" or $row['CantP1'] == 1 ? "" : ' = ' . number_format($row['CantP1'], 0, $_POST["SimDec"], $_POST["SimMil"])) . (trim($row['uniP2d']) !== "" ? '' . $row['uniP2d'] . '' : "") : "-"),
            "mexis1" => $_POST['mexis'] == true ? ($row["factorunit"] <> 1 && $row["factorunit"] <> 0 ? " " . $row["factorunit"] . " x " . getcantformat($row["exist"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " = " . getcantformat($row["exist2"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $row["Medida"] : getcantformat($row["exist"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $row["Medida"]) : "",
            "mexis2" => $_POST['mexis'] == true ? $mexis2 : "",
            "uniP1d2" => $uniP1d,
            "Seriales" =>  $_POST['SerialesXXX'] == true ? $row["Seriales"] . "," : "",
        ];

        $serialesXX = "";
        if ($_POST["SerialesXXX"] == "on") {
            $serialesXX .= "
            <div style='text-align: left; float:left; width: 100%;'>
                <div class='campo' style=' text-align: left; width: 90%;'>
                " . ($row['Seriales'] !== "" ? $row['Seriales'] : "") . "
                </div>
            </div>
                " . ($row['Seriales'] !== "" ? "
                <div class='encabezado' style='font-size: 8px;'>
                    <hr>
                </div>" : "") . "
            ";
        }
        if ($_POST['group'] == 'fami') {
            $zz = $row['Familia'];
        }
        if ($_POST['group'] == 'marc') {
            $zz = $row['NombreMarca'];
        }

        if ($n > 40) {
            $n = 0;
            $detalleInv .= '
		<div style="PAGE-BREAK-AFTER: always; visibility: hidden;">a</div>
                <div class=" encabezado" style=" font-size: 8px;"></div>
                <div class=" encabezado" style=" font-size: 8px;"></div>
                <div class=" encabezado" style=" font-size: 8px;"></div>
                <div class=" encabezado" style=" font-size: 8px;"></div>
                <div class="sup ">
                    <div style="float:left; width: 23%;">
                        <div class="TituloEmpresa" id="Titulo">
                            ' . $_POST["NameCompany"] . '
                        </div>
                        <div class="Subtituloempresa" id="Ubicacion">
                            ' . $_POST["direccion"] . '
                        </div>
                        <div class="Subtituloempresa" id="Literal Fiscal">
                            ' . $_POST["litfiscal"] . '-' . $_POST["rute"] . '
                        </div>
                    </div>
                    <div style="float:left; width: 53%;">
                        <div class="TituloEmpresa" style="float: center; text-align: center;">
                            ' . lang("Inventario Físico") . '
                        </div>
                        <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 8px;">
                            ' . lang("Orden por") . ":" . $_POST["OrdenXXX"] . " " . '
                            ' . ($_POST["DesdeAXX"] == true and $_POST["HastaAXX"] == true ? " / " . lang("Desde el código") . ":" . $_POST["DesdeAXX"] . " " . lang("Al") . " " . $_POST["HastaAXX"] . " " : "") . '
                            ' . ($_POST["DesdeAXX"] == true and $_POST["HastaAXX"] == false ? "/ " . lang("Desde el código") . $_POST["DesdeAXX"] : "") . '
                            ' . ($_POST["DesdeAXX"] == false and $_POST["HastaAXX"] == true ? "/ " . lang("Hasta el código") . $_POST["HastaAXX"] : "") . '
                        </div>
                        <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 8px;">
                            ' . ($_POST["FamiliaXX"] == true ? lang("De la Familia") . ": / " . $_POST["FamiliaXX2"] : "--------------------") . '
                        </div>
                        <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 8px;">
                            ' . ($_POST["marAX"] == true or $_POST["AlmacenAXX"] == true ? lang("Filtrado por") . " : " : "-------------------- ") . '
                            ' . ($_POST["marAX"] == true ? " / " . lang("Marca") . ":" . $_POST["marAX2"] . " " : "") . '
                            ' . ($_POST["AlmacenAXX"] == true ? " / Almacen:" . $_POST["AlmacenAXX2"] . " " : "") . '
                        </div>
                        <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 8px;">
                            ' . ($_POST["ReferenciaXXX"] == "on" or $_POST["AlmacenXXX"] == "on" or $_POST["ExistenciaXXX"] == "on" or $_POST["SerialesXXX"] == "on" ? lang("Incluyendo") . ": " : "-------------------- ") . '
                            ' . ($_POST["AlmacenXXX"] == "on" ? " / " . lang("Productos Sin Almacén") . " " : "") . '
                            ' . ($_POST["ExistenciaXXX"] == "on" ? " / " . lang("Existencia") . "  " : "") . '
                            ' . ($_POST["Referencia"] == "on" ? "/ " . lang("Referencia") . " " : "") . '
                            ' . ($_POST["SeriaSerialesXXXles"] == "on" ? "/ " . lang("Seriales") . " " : "") . '
                        </div>
                    </div>
                    <div style="float:left; width: 23%;">
                        <div class="FechaI"><span id="fectx">
                                ' . $_POST["fectx5"] . '
                            </span></div><br>
                        <div class="FechaI">
                            <div class="page"></div>
                        </div><br>
                        <div class="FechaI"><img style="width: 30%;" src="img/AZUL.svg" /></div><br><br>
                        <div class="FechaI">-</div>
                    </div>
                </div>
                <div class="encabezado">
                    <div class="campo" style=" text-align: left; width: 13%; background-color: gray;">
                        ' . lang("Código Barra") . '
                    </div>
                    <div class="campo" style=" text-align: left; width: 8%; background-color: gray;">
                        ' . lang("S.K.U") . '
                    </div>
                    <div class="campo" style=" text-align: left; width: 19%; background-color: gray;">
                        ' . lang("Descripción") . '
                    </div>
                    <div class="campo" style=" text-align: left; width: 8%; background-color: gray;"> ' . $titt . '</div>
                    <div class="campo" style=" text-align: left; width: 11%; background-color: gray;">
                        ' . lang("Deposito") . ' 
                    </div>
                    <div class="campo" style=" text-align: left; width: 13.5%; background-color: gray;">
                        ' . lang("Referencia") . '
                    </div>
                    
                    ' . ($_POST['mexis'] == true ? '
                        <div class="campo" style=" text-align: right; width: 10%; background-color: gray;">
                            ' . lang("Exis.Teorica") . '
                        </div>
                        <div class="campo" style=" text-align: right; width: 7%; background-color: gray;">
                            ' . lang("Desglose") . '
                        </div>
                    ' : '') . '
                    <div class="campo" style=" text-align: right; width: 8%; background-color: gray;">
                        ' . lang("Exis. Real") . '
                    </div>
                </div>
            ';
            $detalleInv .= $Valid01 . "
                <div style=' text-align: left; float:left; width: 100%; padding-top:6px;'>
                    <div class='campo' style='text-align: left; width: 13%; " . ($color == 0 ? "" : "background: #EDECEC;") . "'>
                        " . $CodBarra . "
                    </div>
                    <div class='campo' style='text-align: left; width: 8%; " . ($color == 0 ? "" : "background: #EDECEC;") . "'>
                        " . $CodIdAmpliado . "
                    </div>
                    <div class='campo' style='text-align: left; width: 19%; " . ($color == 0 ? "" : "background: #EDECEC;") . "'>
                        " . $Producto . "
                    </div>
                    <div class='campo' style='text-align: left; width: 8%; " . ($color == 0 ? "" : "background: #EDECEC;") . "'>
                        " . $groups . "
                    </div>
                    <div class='campo' style='text-align: left; width: 11%; " . ($color == 0 ? "" : "background: #EDECEC;") . "'>
                        " . $DepositoXA . "
                    </div>
                    <div class='campo' style='text-align: left; width: 13.5%; " . ($color == 0 ? "" : "background: #EDECEC;") . "'>
                    " . $Abc . "
                    </div>
                    " . $mexis . "
                    <div class='campo' style='text-align: right; width: 8%; " . ($color == 0 ? "" : "background: #EDECEC;") . "'>
                    " . $uniP1d . "
                    </div>
                    " . $serialesXX . "
                </div>
            ";
        } else {

            $detalleInv .= $Valid01 . "
                <div style=' text-align: left; float:left; width: 100%; padding-top:6px;'>
                    <div class='campo' style='text-align: left; width: 13%; " . ($color == 0 ? "" : "background: #EDECEC;") . "'>
                        " . $CodBarra . "
                    </div>
                    <div class='campo' style='text-align: left; width: 8%; " . ($color == 0 ? "" : "background: #EDECEC;") . "'>
                        " . $CodIdAmpliado . "
                    </div>
                    <div class='campo' style='text-align: left; width: 19%; " . ($color == 0 ? "" : "background: #EDECEC;") . "'>
                        " . $Producto . "
                    </div>
                    <div class='campo' style='text-align: left; width: 8%; " . ($color == 0 ? "" : "background: #EDECEC;") . "'>
                        " . $groups . "
                    </div>
                    <div class='campo' style='text-align: left; width: 11%; " . ($color == 0 ? "" : "background: #EDECEC;") . "'>
                        " . $DepositoXA . "
                    </div>
                    <div class='campo' style='text-align: left; width: 13.5%; " . ($color == 0 ? "" : "background: #EDECEC;") . "'>
                    " . $Abc . "
                    </div>
                    " . $mexis . "
                    <div class='campo' style='text-align: right; width: 8%; " . ($color == 0 ? "" : "background: #EDECEC;") . "'>
                    " . $uniP1d . "
                    </div>
                    " . $serialesXX . "
                </div>
            ";
        }
    }
    mysqli_free_result($result);
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
        <?php echo lang("Inventario físico"); ?>
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
        @page {
            margin: 0;
            size: landscape;
        }

        :root {
            --total-pages: 0;
        }

        .ocultoimpresion {
            display: none !important;
        }

        div.saltopagina {
            display: block;
            page-break-before: always;
        }

        .page-break {
            display: block;
            page-break-before: always;
        }

        .page::before {
            counter-increment: page-counter 1;
            font-size: 8px;
            content: "Pagina " counter(page-counter) " de " counter(total-pages);
            align-content: right;
        }
    }

    body {
        counter-reset: page-counter 0 total-pages var(--total-pages);
        font-family: Tahoma, Verdana, Segoe, sans-serif;
        line-height: 1;
        margin: 5mm 5mm 5mm 5mm;
    }

    :root {
        --total-pages: 0;
    }

    .sup {
        float: left;
        width: 100%;
    }

    .TituloEmpresa {
        font-weight: 600;
        font-size: 15.4px;
        text-align: left;
    }

    .Subtituloempresa {
        font-size: 8.3px;
        text-align: left;
    }

    .FechaI {
        font-size: 8px;
        text-align: right;
        float: right;
    }

    .encabezado {
        margin-top: 5px;
        float: left;
        width: 100%;
        padding: 0 2px 0 0;
        margin-right: 1%;
        text-align: left;
        background-color: white;
        font-size: 8px;
        font-weight: bold;
    }

    .campo {
        float: left;
        margin-right: 3px;
        font-size: 7px;
        text-wrap: wrap;
        white-space: normal !important;
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
        font-size: 8px;
        text-align: center;
        margin-left: 16%;
        background-color: black;
        font-weight: bold;
    }

    .rsecciones {
        width: 34%;
        float: left;
    }

    .TodosLosRecuadros {
        width: 100%;
        background-color: black;
        font-family: Tahoma, Verdana, Segoe, sans-serif;
        font-size: 8px;
        text-align: right;
        font-weight: bold;
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

    thead {
        display: table-header-group;
    }

    tfoot {
        display: table-footer-group;
    }

    .Rows {
        display: table-row-group;
    }
</style>

<body>
    <button type='submit' class='ocultoimpresion ' onclick='window.print();'><img src='/img/pdf.png' width='28' height='28'><br>PDF</button>
    <button class='ocultoimpresion ' onclick='document.getElementById(`formexcel`).submit()'><img src='/img/excel.png' width='28' height='28'><br>
        <?php echo lang("InvetarioF"); ?>
        <br></button>
    <button class='ocultoimpresion ' onclick='document.getElementById(`formexcel4`).submit()'><img src='/img/excel.png' width='28' height='28'><br>
        <?php echo lang("Importar Para toma de Inventario"); ?>
        <br></button>
    <div style="font-size: 8px; margin:1px;">

        <div class="sup ">
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
                <div class="TituloEmpresa" style="float: center; text-align: center;">
                    <?php echo lang("Inventario Físico"); ?>
                </div>
                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 8px;">
                    <?php echo lang("Orden por") . ":" . $_POST["OrdenXXX"] . " "; ?>
                    <?php
                    if ($_POST["DesdeAXX"] == true and $_POST["HastaAXX"] == true) {
                        echo " / " . lang("Desde el código") . ":" . $_POST["DesdeAXX"] . " " . lang("Al") . " " . $_POST["HastaAXX"] . " ";
                    }
                    if ($_POST["DesdeAXX"] == true and $_POST["HastaAXX"] == false) {
                        echo "/ " . lang("Desde el código") . $_POST["DesdeAXX"];
                    }
                    if ($_POST["DesdeAXX"] == false and $_POST["HastaAXX"] == true) {
                        echo "/ " . lang("Hasta el código") . $_POST["HastaAXX"];
                    }
                    ?>
                </div>
                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 8px;">
                    <?php
                    if ($_POST["FamiliaXX"] == true) {
                        echo lang("De la Familia") . ": / " . $_POST["FamiliaXX2"];
                    } else {
                        echo "--------------------";
                    }
                    ?>
                </div>
                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 8px;">
                    <?php
                    if ($_POST["marAX"] == true or $_POST["AlmacenAXX"] == true) {
                        echo lang("Filtrado por") . " : ";
                    } else {
                        echo "-------------------- ";
                    }
                    if ($_POST["marAX"] == true) {
                        echo " / " . lang("Marca") . ":" . $_POST["marAX2"] . " ";
                    }
                    if ($_POST["AlmacenAXX"] == true) {
                        echo " / Almacen:" . $_POST["AlmacenAXX2"] . " ";
                    }
                    ?>
                </div>
                <div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 8px;">
                    <?php
                    if ($_POST["ReferenciaXXX"] == "on" or $_POST["AlmacenXXX"] == "on" or $_POST["ExistenciaXXX"] == "on" or $_POST["SerialesXXX"] == "on") {
                        echo lang("Incluyendo") . ": ";
                    } else {
                        echo "-------------------- ";
                    }
                    if ($_POST["AlmacenXXX"] == "on") {
                        echo " / " . lang("Productos Sin Almacén") . " ";
                    }
                    if ($_POST["ExistenciaXXX"] == "on") {
                        echo " / " . lang("Existencia") . "  ";
                    }
                    if ($_POST["Referencia"] == "on") {
                        echo "/ " . lang("Referencia") . " ";
                    }
                    if ($_POST["SeriaSerialesXXXles"] == "on") {
                        echo "/ " . lang("Seriales") . " ";
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
                <div class="FechaI">-</div>
            </div>
        </div>
        <div class="encabezado">
            <div class="campo" style=" text-align: left; width: 13%; background-color: gray;">
                <?php echo lang("Código Barra"); ?>
            </div>
            <div class="campo" style=" text-align: left; width: 8%; background-color: gray;">
                <?php echo lang("S.K.U"); ?>
            </div>
            <div class="campo" style=" text-align: left; width: 19%; background-color: gray;">
                <?php echo lang("Descripción"); ?>
            </div>
            <?php
            if ($_POST['group'] == 'fami') {
                $titt = 'Marca';
            }
            if ($_POST['group'] == 'marc') {
                $titt = 'Familia';
            }
            if ($_POST['group'] == '0') {
                $titt = 'Marca';
            }
            ?>
            <div class="campo" style=" text-align: left; width: 8%; background-color: gray;"> <?php echo $titt; ?>
            </div>
            <div class="campo" style=" text-align: left; width: 11%; background-color: gray;">
                <?php echo lang("Deposito"); ?> </div>
            <div class="campo" style=" text-align: left; width: 13.5%; background-color: gray;">
                <?php echo lang("Referencia"); ?> </div>
            <?php
            if ($_POST['mexis'] == true) {
            ?>
                <div class="campo" style=" text-align: right; width: 10%; background-color: gray;">
                    <?php echo lang("Exis.Teorica"); ?> </div>
                <div class="campo" style=" text-align: right; width: 7%; background-color: gray;">
                    <?php echo lang("Desglose"); ?> </div>
            <?php
            }
            ?>
            <div class="campo" style=" text-align: right; width: 8%; background-color: gray;">
                <?php echo lang("Exis. Real"); ?> </div>
        </div>
        <?php
        echo $detalleInv;
        ?>
    </div>
    <!-- <div class="pagina " style="font-size: 8px; margin:1px;">
        <table id="content" style="width: 100%;">
            <thead>
                <tr>
                    <th>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="content " style="width: 100%;">
                          
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div> -->

    <form id="formexcel" action="excelnew.php" method="post">
        <input type="hidden" name="vas" id="vas" value="InventarioFisico" />
        <input type="hidden" name="array" value='<?php echo json_encode($array, JSON_UNESCAPED_UNICODE); ?>'>
        <input type="hidden" name="Name" value="Inventario Fisico" />
    </form>
    <form id="formexcel3" action="excelv3led.php" method="post">
        <?php
        ?>
        <?php
        $compa = $_POST["CompanyActual"];
        $name = "InventarioFisicoSeriales.csv";
        ?>
        <input type="hidden" name="Objeto" id="Objeto" value="<?php echo $objPHPExcel; ?>" />
    </form>
    <form id="formexcel4" action="excelnew.php" method="post">
        <?php
        // coalesce(if(round((b.cantidad-floor(b.cantidad))*a.CantP1,3)<>0,concat(round((b.cantidad-floor(b.cantidad))*a.CantP1,3)),''),0)
        $compa = $_POST["CompanyActual"];
        $name = "InventarioFisicoTomaDeInventario";

        ?>
        <input type="hidden" name="Name" value="<?php echo $name; ?>" />
        <input type="hidden" name="CompanyActual" value="<?php echo $compa; ?>" />
        <input type="hidden" name="vas" value="toma" />
    </form>
</body>
<script>
    const totalPages = document.querySelectorAll('.page').length;
    document.documentElement.style.setProperty('--total-pages', totalPages);
</script>

</html>