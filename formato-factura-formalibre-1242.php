<?php

$query2 = "select
    e.LitEfectivo,
    e.LitCheque,
    e.LitTarjeta,
    e.LitO01,
    e.LitO02,
    e.LitO03,
    e.LitO04,
    e.CD,
    e.SimDec,
    e.SimMil,
    e.litfiscal,
    if(if(a.Idtipotx in (1, 2, 3, 4, 5, 6, 11, 12, 13, 15, 21, 22, 23, 24, 25, 26, 31, 35, 36, 37), e.NumTxViewVTA, if(a.Idtipotx in (7, 14, 20, 27, 28), e.NumTxViewCOM, if(a.Idtipotx in (8, 9, 10, 16, 17, 18, 19, 29, 30, 32, 33, 34, 39), e.NumTxViewINV, ''))) = 0, a.IdtxCompany, if(if(a.Idtipotx in (1, 2, 3, 4, 5, 6, 11, 12, 13, 15, 21, 22, 23, 24, 25, 26, 31, 35, 36, 37), e.NumTxViewVTA, if(a.Idtipotx in (7, 14, 20, 27, 28), e.NumTxViewCOM, if(a.Idtipotx in (8, 9, 10, 16, 17, 18, 19, 29, 30, 32, 33, 34, 39), e.NumTxViewINV, ''))) = 1, a.Idtx, a.Referencia)) as idtxdefin,
    a.DTE,
    a.tasa,
    e.IdPais,
    a.Dcto,
    a.Items,
    a.DAmpliado,
    e.Comercio,
    e.giroco as GiroComercial,
    e.Telefono,
    e.correorep,
    b.TituloFe,
    a.excento,
    a.imponible,
    a.impuesto,
    e.MonedaP,
    a.SubTotal,
    a.DctoAplicado,
    a.Total,
    coalesce(cc.RUT, c.RUT) as IdBen,   
    coalesce(cc.Fono, c.Fono) as Fono,  
    coalesce(cc.Direccion, c.Direccion) as BeneDireccion,   
    coalesce(cc.Nombre, c.Nombre) as Beneficiario,  
    coalesce(cc.giro, c.giro) as GiroCl,    
    coalesce(cc.ciudad, c.ciudad) as CiudadCl,  
    coalesce(cc.email, c.email) as email,   
    coalesce(cc.Comuna, c.Comuna) as Comuna,    
    DATE_FORMAT(a.TxfecVence, '%d/%m/%Y') as TxfecVence,
    DATE_FORMAT(a.Fectxclient, '%d/%m/%Y') as Fectxclient,
    a.Contado,
    a.Credito,
    d.Nombre as Usuario,
    f.Nombre as Vendedor,
    e.IDFiscal,
    b.Titulo,
    b.TitCto,
    a.IdTxCompany,
    a.Referencia
from
    PosUpTxC a
left join PosUpTx b on
    b.Idtipotx = a.Idtipotx
left join PosUpclientes c on
    c.RUT = a.IdBen
    and a.IdCompany = c.IdCompany
left join PosUpclientes cc on
    cc.RUT = if(a.IdBen2 = '',
    null,
    a.IdBen2)
    and cc.IdCompany = a.IdCompany
left join PosUpUsers d on
    d.login = a.IdUser
    and a.IdCompany = d.IdCompany
left join PosUpCompany e on
    e.Id = a.IdCompany
left join PosUpUsers f on
    f.Login = a.UserVendedor
    and a.IdCompany = f.IdCompany
where
    a.IdCompany =" . $_POST["CompanyActual"] . " and a.Idtipotx=" . $_POST["Idtipotx"] . " and a.Idtx=" . $Idtx . " and a.IdEstacion='" . $_POST["IdEstacion"] . "'";

if ($result2 = mysqli_query($conn, $query2)) {
    while ($row = mysqli_fetch_assoc($result2)) {
        $LitEfectivo = $row["LitEfectivo"];
        $LitCheque = $row["LitCheque"];
        $LitTarjeta = $row["LitTarjeta"];
        $LitO01 = $row["LitO01"];
        $LitO02 = $row["LitO02"];
        $LitO03 = $row["LitO03"];
        $LitO04 = $row["LitO04"];
        $IdPais = $row["IdPais"];
        $DAmpliado = $row["DAmpliado"];
        $Cliente = $row["Beneficiario"];
        $CiudadCl = $row["CiudadCl"];
        $GiroCl = $row["GiroCl"];
        $Usuario = $row["Usuario"];
        $DirCl = $row["BeneDireccion"];
        $IdenCl = $row["IdBen"];
        $CD = $row["CD"];
        $MonedaP = $row["MonedaP"];
        $SimMil = $row["SimMil"];
        $SimDec = $row["SimDec"];
        $item = $row["Items"];
        $Dcto = $row["Dcto"];
        $litfiscal = $row["litfiscal"];
        $Vendedor = $row["Vendedor"];

        $correorep = $row['correorep'];
        $Telefono = $row['Telefono'];
        $ComunaCl = $row['Comuna'];
        $DirComercio = $row['DirComercio'];
        $GiroComercial = $row['GiroComercial'];
        $Comercio = $row['Comercio'];
        $IDFiscal = $row['IDFiscal'];
        $direccion = $row['direccion'];
        $Titulo = $row['Titulo'];
        $TitCto = $row['TitCto'];
        $IdTxCompany = $row['IdTxCompany'];
        $DTE = $row['DTE'];
        $idtxdefin = $row['idtxdefin'];
        $Referencia = $row['Referencia'];
        $Beneficiario = $row['Beneficiario'];
        $BeneDireccion = $row['BeneDireccion'];
        $Fono = $row['Fono'];
        $email = $row['email'];
        $Fectxclient = $row['Fectxclient'];
        $Credito = $row['Credito'];
        $Contado = $row['Contado'];
        $TxfecVence = $row['TxfecVence'];
        
        // TOTALES EXTRACCIÓN REAL (Cero cálculos manuales, pura base de datos)
        $excento = floatval($row['excento']);
        $Imponible = floatval($row['imponible']);
        $Impuesto = floatval($row['impuesto']);
        $SubTotal = floatval($row['SubTotal']);
        $Total = floatval($row['Total']);
        $DctoAplicado = floatval($row['DctoAplicado']);
        
        $IdBen = $row['IdBen'];

        if ($DTE !== "0") {
            $idtxdefin = $DTE;
        }

        $NombrePag = $row["Titulo"] . " - " . str_pad($idtxdefin, 6, "0", STR_PAD_LEFT) . " - " . $IdBen . " - " . $Beneficiario;

        if (trim($_POST["Idtipotx"]) === "22" || trim($_POST["Idtipotx"]) === "15") {
            $Titulo = "";
            $TitCto = "";
            $NombrePag =  str_pad($idtxdefin, 6, "0", STR_PAD_LEFT) . " - " . $IdBen . " - " . $Beneficiario;
        }
    }
    mysqli_free_result($result2);
}

$query = "SELECT a.Nombre,a.Descripcion,a.Telefono,a.Correo FROM PosUpUbicacion a where a.IdUbi='" . $IdUbi . "' and a.IdCompany='" . $_POST["CompanyActual"] . "' and a.mostrarubi=1";
if ($result = mysqli_query($conn, $query)) {
    while ($row = mysqli_fetch_assoc($result)) {
        if (trim($row["Nombre"]) <> "") {
            $Comercio = trim($row["Nombre"]);
        }
        if (trim($row["Descripcion"]) <> "") {
            $DirComercio = trim($row["Descripcion"]);
        }
        if (trim($row["Telefono"]) <> "") {
            $Telefono = trim($row["Telefono"]);
        }
        if (trim($row["Correo"]) <> "") {
            $correorep = trim($row["Correo"]);
        }
    }
}
?>

<style>
    @media print {
        @page {
            margin: 0;
        }
        body {
            margin: 1cm;
        }
    }
</style>

<div  style="   border: 0px solid gray;
                margin-top:3.7cm;
                height: 8cm;
                padding-left: 1cm;
                padding-right: 1cm;">
    
    <div class="row p-0 m-0" style="font-size: 8px !important;">
        <div class="border rounded p-0 m-0">
            <div class="row p-0 m-0" style="font-size: 8px !important;">
                <div class="col-3 m-0 ">
                    <div class="text-muted"><?php echo "Señor (es)"; ?></div>
                    <strong><?php echo $Cliente; ?></strong>
                </div>
                <div class="col-3 m-0 ">
                    <div class="text-muted"><?php echo $litfiscal; ?></div>
                    <strong><?php echo $IdenCl; ?></strong>
                </div>
                <div class="col-3 m-0 ">
                    <div class="text-muted">Teléfono</div>
                    <strong><?php echo $Fono; ?></strong>
                </div>
                <div class="col-3 m-0 ">
                    <DIV><strong>FACTURA No. <?php echo str_pad($idtxdefin, 5, '0', STR_PAD_LEFT); ?></strong></DIV>
                    <div class="text-muted">Email</div>
                    <?php echo $email; ?>
                </div>
            </div>
            <div class="row p-0 m-0" style="font-size: 8px !important;">
                <div class="col-6 m-0">
                    <div class="text-muted"><?php echo "Dirección"; ?></div>
                    <strong><?php echo $DirCl; ?></strong>
                </div>
                <div class="col-3 m-0 ">
                    <div class="text-muted"><?php echo "Cajero"; ?></div>
                    <strong><?php echo $Usuario; ?></strong>
                </div>
                <div class="col-3 m-0 ">
                    <div class="text-muted"><?php echo "Vendedor"; ?></div>
                    <strong><?php echo $Vendedor; ?></strong>
                </div>
            </div>
            <div class="row p-0 m-0" style="font-size: 8px !important;">
                <div class="col-3 m-0 ">
                    <div class="text-muted"><?php echo "Fecha Documento"; ?></div>
                    <strong><?php echo $Fectxclient; ?></strong>
                </div>
                <div class="col-3 m-0 ">
                    <div class="text-muted"><?php echo "Fecha de Vencimiento"; ?></div>
                    <strong><?php echo $TxfecVence; ?></strong>
                </div>
                <div class="col-3 m-0 ">
                    <div class="text-muted"><?php echo "Condición de pago"; ?></div>
                    <strong>
                        <?php
                        if ($Credito > 0) {
                            echo "Credito";
                        } else {
                            echo "Contado";
                        }
                        ?>
                    </strong>
                </div>
                <div class="col-3 m-0 ">
                    <div class="text-muted"><?php echo "Items(s)"; ?></div>
                    <strong><?php echo $item; ?></strong>
                </div>
            </div>
        </div>
    </div>

    <?php
    $n = 0;
    $am = "";
    $query = "SELECT a.DescripOrden,CONCAT(a.IdAlm,'-',d.TitCto,'-',Lpad(IF(trim(z.Referencia)='',if (z.DTE=0,if (z.IdTxCompany<>0,z.IdTxCompany,z.Idtx),z.DTE),z.Referencia ),4,'0'),'-',a.Item) as orden,a.Descripcion,a.Cant,a.Precio,a.Dcto,a.Total,a.Medida,a.Fraccion,b.CodIdAmpliado,a.Seriales,a.Tasa,a.totalsinimp,a.preciosinimp FROM PosUpTxD a left join PosUpProducto b on b.CodIdBasico = a.CodIdBasico and a.IdCompany = b.IdCompany left join PosUpTxC z on a.IdCompany=z.IdCompany and a.Idtipotx=z.Idtipotx and a.IdEstacion=z.IdEstacion and a.Idtx=z.Idtx left join PosUpAlmacen c on a.IdCompany = c.IdCompany and a.IdAlm = c.IdAlm left join PosUpTx d on a.Idtipotx = d.Idtipotx WHERE a.IdCompany=" . $_POST["CompanyActual"] . " and a.Idtipotx=" . $_POST["Idtipotx"] . " and a.Idtx=" . $Idtx . " and a.IdEstacion='" . $_POST["IdEstacion"] . "'";

    if ($result = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($result)) {

            $n++;
            $ordenp = $row['DescripOrden'];
            $orgen = $row['orden'];
            $am .= '
                    <div class="row p-0 m-0" style="font-size: 8px !important;">
                        <div class="col-4 m-0 text-start text-wrap" style="width: 16%; ">' . $row["CodIdAmpliado"] . '</div>
                        <div class="col-8 m-0" style="width: 36%;">' . $row["Descripcion"] . " " . (trim($row["Seriales"]) <> '' ? "<br>" . $row["Seriales"] : '') . '</div>
                        <div class="col-3 m-0 text-end" style="width: 12%;">' . getcantformat($row["Cant"] * $row["Fraccion"],$CD, $SimDec, $SimMil) . " " . $row["Medida"] . '</div>
                        <div class="col-3 m-0 text-end" style="width: 12%;">' . number_format($row["preciosinimp"] / $row["Fraccion"]*$row["Tasa"], 2, $SimDec, $SimMil)  . '</div>
                        <div class="col-3 m-0 text-end" style="width: 12%;">' . number_format($row["Dcto"]*$row["Tasa"], $CD, $SimDec, $SimMil)  . '</div>
                        <div class="col-3 m-0 text-end" style="width: 12%;">' . number_format($row["totalsinimp"]*$row["Tasa"], $CD, $SimDec, $SimMil) . '</div>
                    </div>
                    ';

            if ($ordenp <> '') {
                $listado = $ordenp;
                $listado = explode(';', $listado);
                $ab = "";
                foreach ($listado as $key) {
                    $listado2 = explode('|', $key);
                    $codigo = $listado2[1];
                    $descp = $listado2[2];
                    $cantidad = $listado2[3];

                    if ($cantidad > 0) {
                        $ab .= '
                            <div class="row p-0 m-0" style="font-size: 8px !important;">
                                <div class="col-6 p-0 m-0">
                                    <div class="row p-0 m-0" style="font-size: 8px !important;">
                                        <div class="col-1 m-0 text-center" >' . $n . '</div>
                                        <div class="col-3 m-0 text-start">' . $codigo . '</div>
                                        <div class="col-8 m-0">' . $descp . '</div>
                                    </div>
                                </div>
                                <div class="col-6 p-0 m-0">
                                    <div class="row p-0 m-0" style="font-size: 8px !important;">
                                        <div class="col-3 m-0 text-end">' . getcantformat($cantidad, $CD, $SimDec, $SimMil) . '</div>
                                    </div>
                                </div>
                            </div>
                        ';
                    }
                    $listado2 = '';
                    $codigo = '';
                    $descp = '';
                    $cantidad = '';
                }
                $am .= '
                    <div class="border-top">
                        ' . $ab . '
                    </div>
                ';
            }
        }
        mysqli_free_result($result);
    }
    ?>

    <div class="row p-0 m-0" style="font-size: 8px !important;">
        <div class="border rounded p-0 m-0" style="min-height: 120px;">
            <div class="row p-0 m-0" style="font-size: 8px !important;">
                <div class="bg-light text-dark border-bottom text-start m-0" style="width: 16%;"><?php echo "Código"; ?></div>
                <div class="bg-light text-dark border-bottom m-0" style="width: 36%;"><?php echo "Detalle"; ?></div>
                <div class="text-end bg-light text-dark border-bottom m-0" style="width: 12%;"><?php echo "Cant"; ?></div>
                <div class="text-end bg-light text-dark border-bottom m-0" style="width: 12%;"><?php echo "P. Unitario"; ?></div>
                <div class="text-end bg-light text-dark border-bottom m-0" style="width: 12%;"><?php echo "Desc"; ?></div>
                <div class="text-end bg-light text-dark border-bottom m-0" style="width: 12%;"><?php echo "Total"; ?></div>
            </div>
            <?php echo $am; ?>
        </div>
    </div>

    <div class="row p-0 m-0" style="font-size: 8px !important;">
        <div class="col-8 p-0 m-0">
            <div class="border px-1 py-2 rounded m-0" style="height:75px;"><?php echo "Observacíon" . "<br>" . $DAmpliado; ?></div>
        </div>
        <div class="col-4 p-0 m-0">
            <div class="row p-0 m-0 border rounded pt-1 pb-1">
                <?php
                // =========================================================================
                // NUEVA ESTRUCTURA DE TOTALES SEGÚN PROVIDENCIA 00071 SENIAT
                // =========================================================================
                ?>
                <div class="col-6 m-0 text-start text-muted fw-bold">SubTotal</div>
                <div class="col-6 m-0 text-end text-dark fw-bold"><?php echo number_format($SubTotal, $CD, $SimDec, $SimMil); ?></div>

                <?php if ($Dcto > 0) { ?>
                    <div class="col-6 m-0 text-start text-muted">Recargo/Dscto</div>
                    <div class="col-6 m-0 text-end text-dark"><?php echo number_format($Dcto, $CD, $SimDec, $SimMil); ?></div>
                <?php } ?>

                <div class="col-6 m-0 text-start text-muted">Monto Exento</div>
                <div class="col-6 m-0 text-end text-dark"><?php echo number_format($excento, $CD, $SimDec, $SimMil); ?></div>

                <div class="col-6 m-0 text-start text-muted">Monto Gravado</div>
                <div class="col-6 m-0 text-end text-dark"><?php echo number_format($Imponible, $CD, $SimDec, $SimMil); ?></div>

                <?php 
                // Calculamos de forma real el porcentaje de IVA para ponerlo en la etiqueta
                $porcEtiqueta = ($Imponible > 0 && $Impuesto > 0) ? round(($Impuesto / $Imponible) * 100, 2) : 0;
                $txtIVA = ($porcEtiqueta > 0) ? "I.V.A. (" . $porcEtiqueta . "%)" : "I.V.A.";
                ?>
                <div class="col-6 m-0 text-start text-muted"><?php echo $txtIVA; ?></div>
                <div class="col-6 m-0 text-end text-dark"><?php echo number_format($Impuesto, $CD, $SimDec, $SimMil); ?></div>

                <div class="col-6 m-0 text-start text-muted fw-bold border-top mt-1 pt-1">Total</div>
                <div class="col-6 m-0 text-end text-danger fw-bold border-top mt-1 pt-1"><?php echo number_format($Total, $CD, $SimDec, $SimMil); ?></div>

                <?php 
                if (!isset($IGTF) || $IGTF == 0) { 
                ?>
                    <div class="col-12 m-0 text-end p-0 mt-1"><small><?php echo convertir(round($Total, 2)); ?></small></div>
                <?php 
                } 
                
                if (isset($IGTF) && $IGTF > 0) {
                ?>
                    <div class="col-6 m-0 text-start text-muted"><?php echo "IGTF 3% de " . (isset($Tipo01) ? $Tipo01 : ''); ?></div>
                    <div class="col-6 m-0 text-end text-dark"><?php echo number_format($IGTF, $CD, $SimDec, $SimMil); ?></div>
                    <div class="col-6 m-0 text-start text-muted fw-bold">A Pagar</div>
                    <div class="col-6 m-0 text-end text-danger fw-bold"><?php echo number_format(($Total) + $IGTF, $CD, $SimDec, $SimMil); ?></div>
                    <div class="col-12 text-end p-0 m-0"><small><?php echo convertir(($Total) + $IGTF); ?></small></div>
                <?php
                }
                ?>
            </div>
        </div>

        <div class="col-8 p-0 m-0" style="font-size: 6px !important;">
            <div class="row p-0 m-0 border rounded mb-1">
                <div class="col-5 p-0 m-0 fw-bold">
                    <div class="row p-0 m-0" style="font-size: 8px !important;">
                        <div class="col-8 m-0">
                            Medios de Pago
                        </div>
                        <div class="col-4 m-0 text-end">
                            Vuelto
                        </div>
                    </div>
                </div>
                <div class="col-4 p-0 m-0 text-start fw-bold" style="font-size: 8px !important;">
                    <div class="row p-0 m-0" style="font-size: 8px !important;">
                        <div class="col-4 m-0">
                            Referencia
                        </div>
                        <div class="col-8 m-0">
                            Fecha
                        </div>
                    </div>
                </div>
                <div class="col-3 p-0 m-0 text-start fw-bold" style="font-size: 8px !important;">
                    <div class="row p-0 m-0" style="font-size: 8px !important;">
                        <div class="col-6 m-0">
                            Estacion
                        </div>
                        <div class="col-6 m-0">
                            Usuario
                        </div>
                    </div>
                </div>
                <?php
                $query3 = "SELECT a.MontoPagar,sum(if(a.Efectivo > 0,a.Efectivo, 0)) as Efectivo,sum(if(a.Efectivo < 0,a.Efectivo, 0)) as EfectivoVuelto,
                    sum(if(a.Cheque > 0,a.Cheque, 0)) as Cheque,sum(if(a.Cheque < 0,a.Cheque, 0)) as ChequeVuelto,
                    sum(if(a.Tarjeta > 0,a.Tarjeta, 0)) as Tarjeta,sum(if(a.Tarjeta < 0,a.Tarjeta, 0)) as TarjetaVuelto,
                    sum(if(a.Tipo01 > 0,a.Tipo01, 0)) as Tipo01,sum(if(a.Tipo01 < 0,a.Tipo01, 0)) as Tipo01Vuelto,
                    sum(if(a.Tipo02 > 0,a.Tipo02, 0)) as Tipo02,sum(if(a.Tipo02 < 0,a.Tipo02, 0)) as Tipo02Vuelto,
                    sum(if(a.Tipo03 > 0,a.Tipo03, 0)) as Tipo03,sum(if(a.Tipo03 < 0,a.Tipo03, 0)) as Tipo03Vuelto,
                    sum(if(a.Tipo04 > 0,a.Tipo04, 0)) as Tipo04,sum(if(a.Tipo04 < 0,a.Tipo04, 0)) as Tipo04Vuelto,
                    sum(if(a.Anticipo > 0,a.Anticipo, 0)) as Anticipo,
                    a.Credito,DATE_FORMAT(a.Fectxclient,'%d/%m/%Y %h:%i:%s %p') as Fecha,if(a.Caja2<>-1,a.Caja2,a.Caja) as CajaActual,b.Nombre as Usuario,c.Etiqueta as Estacion,
                    TarjetaD,ChequeD,Tipo01D,Tipo02D,Tipo03D,Tipo04D,a.AnticipoD,
                    a.tasa
                    FROM PosUpTxP a 
                    left join posupusers b on b.Login = a.Login and a.IdCompany = b.IdCompany
                    left join PosUpCompanyEstacion c on if(a.Caja2<>-1,a.IdEstacion2,a.IdEstacion)=c.token and a.IdCompany=c.IdCompany
                    WHERE a.IdCompany=" . trim($_POST["CompanyActual"]) . " and a.Idtipotx=" . trim($_POST["Idtipotx"]) . " and a.Idtx=" . $Idtx . " and a.IdEstacion='" . trim($_POST["IdEstacion"]) . "' 
                    group by Item
                    order by fectxclient asc, MontoPagar desc ";
                if ($result3 = mysqli_query($conn, $query3)) {
                    while ($row3 = mysqli_fetch_assoc($result3)) {
                        $Fech = $row3['Fecha'];
                        $Efectivo = $row3['Efectivo'] ;
                        $EfectivoVuelto = $row3['EfectivoVuelto'] ;
                        $Cheque = $row3['Cheque'] ;
                        $ChequeVuelto = $row3['ChequeVuelto'] ;
                        $Tarjeta = $row3['Tarjeta'] ;
                        $TarjetaVuelto = $row3['TarjetaVuelto'] ;
                        $Tipo01 = $row3['Tipo01'];
                        $Tipo01Vuelto = $row3['Tipo01Vuelto'];
                        $Tipo02 = $row3['Tipo02'];
                        $Tipo02Vuelto = $row3['Tipo02Vuelto'];
                        $Tipo03 = $row3['Tipo03'];
                        $Tipo03Vuelto = $row3['Tipo03Vuelto'];
                        $Tipo04 = $row3['Tipo04'];
                        $Tipo04Vuelto = $row3['Tipo04Vuelto'] ;
                        $Anticipo = $row3['Anticipo'];

                        if ($row3["Credito"] > 0) {
                ?>
                            <div class="col-5 p-0 m-0  fw-bold" style="font-size: 8px !important;">
                                <div class="row p-0 m-0" style="font-size: 8px !important;">
                                    <div class="col-4 m-0 d-flex gap-2 align-items-center">
                                        <i class='fa fa-minus' style='font-size: 7px !important;'></i> <?php echo "Credito"; ?>
                                    </div>
                                    <div class="col-4 m-0 text-end">
                                        <?php echo number_format($row3["Credito"] , $CD, $SimDec, $SimMil) ; ?>
                                    </div>
                                    <div class="col-4 m-0 text-end">
                                        <?php echo number_format(0, $CD, $SimDec, $SimMil) ; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 p-0 m-0 text-start fw-bold" style="font-size: 8px !important;">
                                <div class="row p-0 m-0" style="font-size: 8px !important;">
                                    <div class="col-4 m-0">
                                    </div>
                                    <div class="col-8 m-0">
                                        <?php echo $row3["Fecha"] ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3 p-0 m-0 text-start fw-bold" style="font-size: 8px !important;">
                                <div class="row p-0 m-0" style="font-size: 8px !important;">
                                    <div class="col-6 m-0">
                                        <?php echo $row3["Estacion"] ?> No. <?php echo $row3["CajaActual"] ?>
                                    </div>
                                    <div class="col-6 m-0">
                                        <?php echo $row3["Usuario"] ?>
                                    </div>
                                </div>
                            </div>
                        <?php }

                        if ($Efectivo > 0 || $EfectivoVuelto < 0) {
                        ?>
                            <div class="col-5 p-0 m-0  fw-bold" style="font-size: 8px !important;">
                                <div class="row p-0 m-0" style="font-size: 8px !important;">
                                    <div class="col-4 m-0 d-flex gap-2 align-items-center">
                                        <?php echo ($Efectivo > 0 ? "<i class='fa fa-plus' style='font-size: 7px !important;'></i>" : ($EfectivoVuelto < 0 ? "<i class='fa fa-minus' style='font-size: 7px !important;'></i>" : "")); ?> <?php echo $LitEfectivo; ?>
                                    </div>
                                    <div class="col-4 m-0 text-end">
                                        <?php echo number_format($Efectivo, $CD, $SimDec, $SimMil); ?>
                                    </div>
                                    <div class="col-4 m-0 text-end">
                                        <?php echo number_format($EfectivoVuelto, $CD, $SimDec, $SimMil); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 p-0 m-0 text-start fw-bold" style="font-size: 8px !important;">
                                <div class="row p-0 m-0" style="font-size: 8px !important;">
                                    <div class="col-4 m-0">
                                    </div>
                                    <div class="col-8 m-0">
                                        <?php echo $row3["Fecha"] ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3 p-0 m-0 text-start fw-bold" style="font-size: 8px !important;">
                                <div class="row p-0 m-0" style="font-size: 8px !important;">
                                    <div class="col-6 m-0">
                                        <?php echo $row3["Estacion"] ?> No. <?php echo $row3["CajaActual"] ?>
                                    </div>
                                    <div class="col-6 m-0">
                                        <?php echo $row3["Usuario"] ?>
                                    </div>
                                </div>
                            </div>
                        <?php }
                        
                        if ($Cheque > 0 || $ChequeVuelto < 0) {
                        ?>
                            <div class="col-5 p-0 m-0  fw-bold" style="font-size: 8px !important;">
                                <div class="row p-0 m-0" style="font-size: 8px !important;">
                                    <div class="col-4 m-0 d-flex gap-2 align-items-center">
                                        <?php echo ($Cheque > 0 ? "<i class='fa fa-plus' style='font-size: 7px !important;'></i>" : ($ChequeVuelto < 0 ? "<i class='fa fa-minus' style='font-size: 7px !important;'></i>" : "")); ?> <?php echo $LitCheque; ?>
                                    </div>
                                    <div class="col-4 m-0 text-end">
                                        <?php echo number_format($Cheque, $CD, $SimDec, $SimMil); ?>
                                    </div>
                                    <div class="col-4 m-0 text-end">
                                        <?php echo number_format($ChequeVuelto, $CD, $SimDec, $SimMil); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 p-0 m-0 text-start fw-bold" style="font-size: 8px !important;">
                                <div class="row p-0 m-0" style="font-size: 8px !important;">
                                    <div class="col-4 m-0">
                                        <?php echo $row3["ChequeD"] ?>
                                    </div>
                                    <div class="col-8 m-0">
                                        <?php echo $row3["Fecha"] ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3 p-0 m-0 text-start fw-bold" style="font-size: 8px !important;">
                                <div class="row p-0 m-0" style="font-size: 8px !important;">
                                    <div class="col-6 m-0">
                                        <?php echo $row3["Estacion"] ?> No. <?php echo $row3["CajaActual"] ?>
                                    </div>
                                    <div class="col-6 m-0">
                                        <?php echo $row3["Usuario"] ?>
                                    </div>
                                </div>
                            </div>
                        <?php }
                        
                        if ($Tarjeta > 0 || $TarjetaVuelto < 0) {
                        ?>
                            <div class="col-5 p-0 m-0  fw-bold" style="font-size: 8px !important;">
                                <div class="row p-0 m-0" style="font-size: 8px !important;">
                                    <div class="col-4 m-0 d-flex gap-2 align-items-center">
                                        <?php echo ($Tarjeta > 0 ? "<i class='fa fa-plus' style='font-size: 7px !important;'></i>" : ($TarjetaVuelto < 0 ? "<i class='fa fa-minus' style='font-size: 7px !important;'></i>" : "")); ?> <?php echo $LitTarjeta; ?>
                                    </div>
                                    <div class="col-4 m-0 text-end">
                                        <?php echo number_format($Tarjeta, $CD, $SimDec, $SimMil); ?>
                                    </div>
                                    <div class="col-4 m-0 text-end">
                                        <?php echo number_format($TarjetaVuelto, $CD, $SimDec, $SimMil); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 p-0 m-0 text-start fw-bold" style="font-size: 8px !important;">
                                <div class="row p-0 m-0" style="font-size: 8px !important;">
                                    <div class="col-4 m-0">
                                        <?php echo $row3["TarjetaD"] ?>
                                    </div>
                                    <div class="col-8 m-0">
                                        <?php echo $row3["Fecha"] ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3 p-0 m-0 text-start fw-bold" style="font-size: 8px !important;">
                                <div class="row p-0 m-0" style="font-size: 8px !important;">
                                    <div class="col-6 m-0">
                                        <?php echo $row3["Estacion"] ?> No. <?php echo $row3["CajaActual"] ?>
                                    </div>
                                    <div class="col-6 m-0">
                                        <?php echo $row3["Usuario"] ?>
                                    </div>
                                </div>
                            </div>
                        <?php }
                        
                        if ($Tipo01 > 0 || $Tipo01Vuelto < 0) {
                        ?>
                            <div class="col-5 p-0 m-0  fw-bold" style="font-size: 8px !important;">
                                <div class="row p-0 m-0" style="font-size: 8px !important;">
                                    <div class="col-4 m-0 d-flex gap-2 align-items-center">
                                        <?php echo ($Tipo01 > 0 ? "<i class='fa fa-plus' style='font-size: 7px !important;'></i>" : ($Tipo01Vuelto < 0 ? "<i class='fa fa-minus' style='font-size: 7px !important;'></i>" : "")); ?> <?php echo $LitO01; ?>
                                    </div>
                                    <div class="col-4 m-0 text-end">
                                        <?php echo number_format($Tipo01, $CD, $SimDec, $SimMil); ?>
                                    </div>
                                    <div class="col-4 m-0 text-end">
                                        <?php echo number_format($Tipo01Vuelto, $CD, $SimDec, $SimMil); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 p-0 m-0 text-start fw-bold" style="font-size: 8px !important;">
                                <div class="row p-0 m-0" style="font-size: 8px !important;">
                                    <div class="col-4 m-0">
                                        <?php echo $row3["Tipo01D"] ?>
                                    </div>
                                    <div class="col-8 m-0">
                                        <?php echo $row3["Fecha"] ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3 p-0 m-0 text-start fw-bold" style="font-size: 8px !important;">
                                <div class="row p-0 m-0" style="font-size: 8px !important;">
                                    <div class="col-6 m-0">
                                        <?php echo $row3["Estacion"] ?> No. <?php echo $row3["CajaActual"] ?>
                                    </div>
                                    <div class="col-6 m-0">
                                        <?php echo $row3["Usuario"] ?>
                                    </div>
                                </div>
                            </div>
                        <?php }
                        
                        if ($Tipo02 > 0 || $Tipo02Vuelto < 0) {
                        ?>
                            <div class="col-5 p-0 m-0  fw-bold" style="font-size: 8px !important;">
                                <div class="row p-0 m-0" style="font-size: 8px !important;">
                                    <div class="col-4 m-0 d-flex gap-2 align-items-center">
                                        <?php echo ($Tipo02 > 0 ? "<i class='fa fa-plus' style='font-size: 7px !important;'></i>" : ($Tipo02Vuelto < 0 ? "<i class='fa fa-minus' style='font-size: 7px !important;'></i>" : "")); ?> <?php echo $LitO02; ?>
                                    </div>
                                    <div class="col-4 m-0 text-end">
                                        <?php echo number_format($Tipo02, $CD, $SimDec, $SimMil); ?>
                                    </div>
                                    <div class="col-4 m-0 text-end">
                                        <?php echo number_format($Tipo02Vuelto, $CD, $SimDec, $SimMil); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 p-0 m-0 text-start fw-bold" style="font-size: 8px !important;">
                                <div class="row p-0 m-0" style="font-size: 8px !important;">
                                    <div class="col-4 m-0">
                                        <?php echo $row3["Tipo02D"] ?>
                                    </div>
                                    <div class="col-8 m-0">
                                        <?php echo $row3["Fecha"] ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3 p-0 m-0 text-start fw-bold" style="font-size: 8px !important;">
                                <div class="row p-0 m-0" style="font-size: 8px !important;">
                                    <div class="col-6 m-0">
                                        <?php echo $row3["Estacion"] ?> No. <?php echo $row3["CajaActual"] ?>
                                    </div>
                                    <div class="col-6 m-0">
                                        <?php echo $row3["Usuario"] ?>
                                    </div>
                                </div>
                            </div>
                        <?php }
                        
                        if ($Tipo03 > 0 || $Tipo03Vuelto < 0) {
                        ?>
                            <div class="col-5 p-0 m-0  fw-bold" style="font-size: 8px !important;">
                                <div class="row p-0 m-0" style="font-size: 8px !important;">
                                    <div class="col-4 m-0 d-flex gap-2 align-items-center">
                                        <?php echo ($Tipo03 > 0 ? "<i class='fa fa-plus' style='font-size: 7px !important;'></i>" : ($Tipo03Vuelto < 0 ? "<i class='fa fa-minus' style='font-size: 7px !important;'></i>" : "")); ?> <?php echo $LitO03; ?>
                                    </div>
                                    <div class="col-4 m-0 text-end">
                                        <?php echo number_format($Tipo03, $CD, $SimDec, $SimMil); ?>
                                    </div>
                                    <div class="col-4 m-0 text-end">
                                        <?php echo number_format($Tipo03Vuelto, $CD, $SimDec, $SimMil); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 p-0 m-0 text-start fw-bold" style="font-size: 8px !important;">
                                <div class="row p-0 m-0" style="font-size: 8px !important;">
                                    <div class="col-4 m-0">
                                        <?php echo $row3["Tipo03D"] ?>
                                    </div>
                                    <div class="col-8 m-0">
                                        <?php echo $row3["Fecha"] ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3 p-0 m-0 text-start fw-bold" style="font-size: 8px !important;">
                                <div class="row p-0 m-0" style="font-size: 8px !important;">
                                    <div class="col-6 m-0">
                                        <?php echo $row3["Estacion"] ?> No. <?php echo $row3["CajaActual"] ?>
                                    </div>
                                    <div class="col-6 m-0">
                                        <?php echo $row3["Usuario"] ?>
                                    </div>
                                </div>
                            </div>
                        <?php }
                        
                        if ($Tipo04 > 0 || $Tipo04Vuelto < 0) {
                        ?>
                            <div class="col-5 p-0 m-0  fw-bold" style="font-size: 8px !important;">
                                <div class="row p-0 m-0" style="font-size: 8px !important;">
                                    <div class="col-4 m-0 d-flex gap-2 align-items-center">
                                        <?php echo ($Tipo04 > 0 ? "<i class='fa fa-plus' style='font-size: 7px !important;'></i>" : ($Tipo04Vuelto < 0 ? "<i class='fa fa-minus' style='font-size: 7px !important;'></i>" : "")); ?> <?php echo $LitO04; ?>
                                    </div>
                                    <div class="col-4 m-0 text-end">
                                        <?php echo number_format($Tipo04, $CD, $SimDec, $SimMil); ?>
                                    </div>
                                    <div class="col-4 m-0 text-end">
                                        <?php echo number_format($Tipo04Vuelto, $CD, $SimDec, $SimMil); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 p-0 m-0 text-start fw-bold" style="font-size: 8px !important;">
                                <div class="row p-0 m-0" style="font-size: 8px !important;">
                                    <div class="col-4 m-0">
                                        <?php echo $row3["Tipo04D"] ?>
                                    </div>
                                    <div class="col-8 m-0">
                                        <?php echo $row3["Fecha"] ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3 p-0 m-0 text-start fw-bold" style="font-size: 8px !important;">
                                <div class="row p-0 m-0" style="font-size: 8px !important;">
                                    <div class="col-6 m-0">
                                        <?php echo $row3["Estacion"] ?> No. <?php echo $row3["CajaActual"] ?>
                                    </div>
                                    <div class="col-6 m-0">
                                        <?php echo $row3["Usuario"] ?>
                                    </div>
                                </div>
                            </div>
                        <?php }
                        
                        if ($Anticipo > 0) {
                        ?>
                            <div class="col-5 p-0 m-0 fw-bold" style="font-size: 8px !important;">
                                <div class="row p-0 m-0" style="font-size: 8px !important;">
                                    <div class="col-4 m-0 d-flex gap-2 align-items-center">
                                        <?php echo ($Anticipo > 0 ? "<i class='fa fa-plus' style='font-size: 7px !important;'></i>" :  ""); ?> <?php echo "Anticipo Aplicados"; ?>
                                    </div>
                                    <div class="col-4 m-0 text-end">
                                        <?php echo number_format($Anticipo, $CD, $SimDec, $SimMil); ?>
                                    </div>
                                    <div class="col-4 m-0 text-end">
                                        <?php echo number_format(0, $CD, $SimDec, $SimMil); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 p-0 m-0 text-start fw-bold" style="font-size: 8px !important;">
                                <div class="row p-0 m-0" style="font-size: 8px !important;">
                                    <div class="col-4 m-0">
                                        <?php echo $row3["AnticipoD"] ?>
                                    </div>
                                    <div class="col-8 m-0">
                                        <?php echo $row3["Fecha"] ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3 p-0 m-0 text-start fw-bold" style="font-size: 8px !important;">
                                <div class="row p-0 m-0" style="font-size: 8px !important;">
                                    <div class="col-6 m-0">
                                        <?php echo $row3["Estacion"] ?> No. <?php echo $row3["CajaActual"] ?>
                                    </div>
                                    <div class="col-6 m-0">
                                        <?php echo $row3["Usuario"] ?>
                                    </div>
                                </div>
                            </div>
                <?php
                        }
                    }
                    mysqli_free_result($result3);
                }
                ?>
            </div>
        </div>
        <div class="col-2 p-0 m-0" style="font-size: 8px !important;text-align: center !important; ">
            <div>Por POSUPVEN, C.A.</div>
            <br><br>

            <div>__________________</div>
        </div>
        <div class="col-2 p-0 m-0" style="font-size: 8px !important;text-align: center !important; ">
            <div>Firma y aceptación del cliente </div>
            <br><br>

            <div>___________________</div>
        </div>
    </div>
</div>
<script>
    document.getElementById("Titulodelapagina").innerHTML = "<?php echo $NombrePag; ?>";
</script>