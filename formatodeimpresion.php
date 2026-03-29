<?php
include "ambienteconsultas.php";
$conn = conectar();
session_start();
$CompanyActual = trim($_POST["CompanyActual"]);
$Idtx = trim($_POST["Idtx"]);
$Idtipotx = trim($_POST["Idtipotx"]);
$IdEstacion = trim($_POST["IdEstacion"]);
$Item = trim($_POST["Item"]);
$Logotipo = trim($_SESSION["Logotipo"]);
// =========================================================================
// ENRUTADOR SENIOR: Si es ISLR (Tipo 7), cargamos el diseño nuevo y salimos
// =========================================================================
if ($Idtipotx == '7') {
    include 'formatodeimpresion_islr.php';
    exit; // Detenemos la ejecución aquí para que no imprima el IVA de abajo
}
// =========================================================================


$query = "SELECT a.tasa as tasa2,e.Moneda3,e.Moneda4,e.FactorDolarZelle,e.FactorDolarPaypal,e.FactorDolarCash,e.SimMil,e.MonedaS,e.SimDec,e.CD,e.MonedaP,e.litfiscal,e.fresolucionb,e.nresolucionb,e.fresolucion,e.nresolucion,a.montoretencion,DATE_FORMAT(a.Fectxclient,'%m') as meh,a.Referencia,DATE_FORMAT(a.Fectxclient,'%Y') as ano,a.Contado,a.Credito,e.IDFiscal,a.DAmpliado,e.comercio,e.correorep as email,e.Telefono as Fono,e.direccion as Direccion,DATE_FORMAT(a.Fectxclient,'%d/%m/%Y') as Fectxclient,a.IdResponsable,b.Nombre as Beneficiario,c.TitCto,c.Titulo FROM PosUpTxP a inner join PosUpclientes b on b.Rut=a.IdResponsable and a.IdCompany=b.IdCompany inner join PosUpTx c on a.Idtipotx=c.Idtipotx inner join PosUpCompany e on a.Idcompany=e.Id WHERE a.IdCompany=" . $CompanyActual . " and a.Idtipotx = " . $Idtipotx . " and a.IdEstacion = '" . $IdEstacion . "' and a.Idtx = " . $Idtx . " and item='" . $Item . "'";
if ($result = mysqli_query($conn, $query)) {
    while ($row = mysqli_fetch_assoc($result)) {
        $IdResponsable = $row['IdResponsable'];
        $Beneficiario = $row['Beneficiario'];
        $Direccion = $row['Direccion'];
        $Fono = $row['Fono'];
        $email = $row['email'];
        $TitCto = $row['TitCto'];
        $Fectxclient = $row['Fectxclient'];
        $DAmpliado = $row['DAmpliado'];
        $IDFiscal = $row['IDFiscal'];
        $Contado = $row['Contado'];
        $Credito = $row['Credito'];
        $Mes = $row['meh'];
        $Año = $row['ano'];
        $Referencia = $row['Referencia'];
        $Retencion = $row['montoretencion'];
        $Titulo = $row['Titulo'];
        $NameCompany = $row['comercio'];
        $LitFis = $row['litfiscal'];
        $MonedaP = $row['MonedaP'];
        $MonedaS = $row['MonedaS'];
        $CD = $row['CD'];
        $SimDec = $row['SimDec'];
        $SimMil = $row['SimMil'];
        $FactorDolarCash = $row['FactorDolarCash'];
        $FactorDolarPaypal = $row['FactorDolarPaypal'];
        $Moneda3 = $row['Moneda3'];
        $Moneda4 = $row['Moneda4'];
        $FactorDolarZelle = $row['FactorDolarZelle'];
        if ($row["tasa2"] > 0) {
            $tasa2 = $row['tasa2'];
        } else {
            $tasa2 = 1;
        }
        if ($Idtipotx == '1') {
            $NResolucion = $row['nresolucionb'];
            $FResolucion = $row['fresolucionb'];
        } else {
            $NResolucion = $row['nresolucion'];
            $FResolucion = $row['fresolucion'];
        }
    }
    mysqli_free_result($result);
}

$query = "SELECT if(Referencia='',if (DTE=0,if (IdTxCompany<>0,IdTxCompany,Idtx),DTE),Referencia) as Idtx2,numctrol,IdtxPadre,Total,excento,imponible,impuesto,tasa FROM PosUpTxC a WHERE a.IdCompany=" . $CompanyActual . " and a.Idtipotx = " . $Idtipotx . " and a.IdEstacion = '" . $IdEstacion . "' and a.Idtx = " . $Idtx . "";
if ($result = mysqli_query($conn, $query)) {
    while ($row = mysqli_fetch_assoc($result)) {
        $numctrol = $row['numctrol'];
        $IdtxPadre = $row['IdtxPadre'];
        $Idtx2 = $row['Idtx2'];
        $Total = $row['Total'];
        $excento = $row['excento'];
        $imponible = $row['imponible'];
        $polcentaje = $row['impuesto'] / $row['imponible'];
        $impuesto = $row['impuesto'];
        $tasa = $row['tasa'];
    }
    mysqli_free_result($result);
}

$polcentaje = $polcentaje * 100;
if ($_POST["Moneda"] == "0") {
    if ($tasa2 > 1) {
        $Moneda = $MonedaS;
        $Factor = $tasa2;
    } else {
        $Moneda = $MonedaP;
    }
}

if ($_POST["Moneda"] == "1") {
    $Moneda = $MonedaP;
    $Factor = 1;
}

if ($_POST["Moneda"] == "2") {
    $Moneda = $MonedaS;
    $Factor = $FactorDolarCash;
}

if ($_POST["Moneda"] == "3") {
    $Moneda = $Moneda3;
    $Factor = $FactorDolarPaypal;
}

if ($_POST["Moneda"] == "4") {
    $Moneda = $Moneda4;
    $Factor = $FactorDolarZelle;
}

if ($_POST["Moneda"] == "5") {
    $Moneda = $MonedaS;
    $Factor = $tasa;
}

if ($_POST["Moneda"] == "6") {
    $Moneda = $MonedaS;
    $Factor = $tasa2;
}

if (($Item > 1)  and ($Retencion == 0) and (($Contado <> 0) or ($Credito <> 0))) {
?>
    <div style='border: solid 1px black; font-size: 14px;'>
        <div style="padding: 10px;">
            <table>
                <thead>
                    <tr>
                        <th>
                            <div class="row">
                                <div class="col-6">
                                    <div style='font-weight:bold; font-size: 18px;'><?php echo $NameCompany; ?></div>
                                    <div style='font-weight:bold; font-size: 12px;'>
                                        <?php
                                        if ($Direccion <> "") {
                                            echo lang("Direccion") . ': ' . $Direccion . '<br>';
                                        }
                                        if ($Fono <> "") {
                                            echo lang("Telefono") . ': ' . $Fono . '<br>';
                                        }
                                        if ($email <> "") {
                                            echo lang("Email") . ': ' . $email . '<br>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class='col-6 row'>
                                    <div class="col-6" style='border: solid 1px gray;'><?php echo $LitFis; ?></div>
                                    <div class="col-6" style='border: solid 1px gray;'><?php echo $IDFiscal; ?></div>
                                    <div class="col-6" style='border: solid 1px gray;'><?php echo lang("N° de Recibo"); ?>:</div>
                                    <div class="col-6" style='border: solid 1px gray;'><?php echo $TitCto . "-" . str_pad($Idtx2, 10, "0", STR_PAD_LEFT); ?></div>
                                    <div class="col-6" style='border: solid 1px gray;'><?php echo lang("Fecha Emision"); ?></div>
                                    <div class="col-6" style='border: solid 1px gray;'><?php echo $Fectxclient; ?></div>
                                </div>
                                <div class='col-12'>
                                    <div class='text-center' style='font-weight:bold; font-size: 18px;'>
                                        <?php
                                        if ($Contado > 0) {
                                            $Monto = ($Contado / $tasa2) * $Factor;
                                            echo lang("RECIBO DE PAGO POR") . ' ' . $Moneda . ' ' . number_format(($Contado / $tasa2) * $Factor, $CD, $SimDec, $SimMil);
                                        } else {
                                            $Monto = ($Credito / $tasa2) * $Factor;
                                            echo lang("DEVOLUCION DE PAGO POR") . ' ' . $Moneda . '  ' . number_format(($Credito / $tasa2) * $Factor, $CD, $SimDec, $SimMil);
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class='col-2 text-center' style='border: solid 1px black'><?php echo lang("Recibi de"); ?>:</div>
                                <div class='col-4 text-center' style='border: solid 1px black'><?php echo $Beneficiario; ?></div>
                                <div class='col-2 text-center' style='border: solid 1px black'><?php echo $LitFis; ?></div>
                                <div class='col-4 text-center' style='border: solid 1px black'><?php echo $IdResponsable; ?></div>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class='row'>
                                <div class='col-12'>
                                    <strong class='text-center' style='font-weight:bold;'><?php echo lang("LA SUMA DE"); ?>: </strong><br>
                                    <p style='text-align: justify;'>
                                        <?php
                                        if ($Contado > 0) {
                                            echo convertir($Monto);
                                        } else {
                                            echo convertir($Monto);
                                        }
                                        ?>
                                    </p>
                                    <br>
                                </div>
                                <div class='col-12'>
                                    <strong class='text-center' style='font-weight:bold;'><?php echo lang("POR CONCEPTO DE"); ?>: </strong><br>
                                    <p style='text-align: justify;'><?php echo strtoupper($DAmpliado); ?></p><br>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
                <tfoot style='position:fixed; bottom:0; z-index:999999;'>
                    <tr>
                        <td>
                            <div class='row' style='border: solid 1px black;'>
                                <div class="col-6"> <?php echo lang("Por") . ' ' . $Beneficiario . " " . $LitFis . ": " . $IdResponsable . " " . lang("Recibe Conforme") . ": _________________________________"; ?></div>
                                <div class="col-6"> <?php echo lang("Por") . ' ' . $NameCompany . " " . $LitFis . ": " . $IDFiscal . " " . lang("Entrega Conforme") . ": _________________________________"; ?></div>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
<?php
}

if (($Item > 1) and ($Retencion <> 0)) {
?>
    <style>
        @media print {
            @page {
                margin: 0;
                size: auto;
            }

            .nomostrar {
                display: contents !important;
            }

            .mostrar {
                display: none !important;
            }
        }

        .nomostrar {
            display: none;
        }

        .mostrar {
            display: contents;
        }

        .fullscreen-modal .modal-dialog {
            margin: 0;
            margin-right: auto;
            margin-left: auto;
            width: 100%;
        }

        @media (min-width: 768px) {
            .fullscreen-modal .modal-dialog {
                width: 750px;
            }
        }

        @media (min-width: 992px) {
            .fullscreen-modal .modal-dialog {
                width: 970px;
            }
        }

        @media (min-width: 1200px) {
            .fullscreen-modal .modal-dialog {
                width: 1170px;
            }
        }

        .colorazul {
            background-color: blue;
            color: white;
        }

        .grid {
            display: grid;
            grid-template-columns: 50px 300px;
            grid-template-rows: 200px 75px;
        }

        #modal-probol {
            overflow-y: scroll;
        }

        #modal-probol-fa {
            overflow-y: scroll;
        }
    </style>
    <div style='margin-left: 2cm; margin-right: 2cm; font-size: 10px; padding-top: 2cm;'>
        <table>
            <thead>
                <tr>
                    <th>
                        <div style='width:100%;'>
                            <div style='width:10%; float:left;'>
                                <?php
                                if ($Logotipo !== "") {
                                ?><img src="<?php echo 'Comercio/' . $CompanyActual . '/' . 'entorno/' . $Logotipo; ?>" alt="" style="width: 50px; height: 50px;"><?php
                                                                                                                                                                } else {
                                                                                                                                                                    ?><img src="img/logo.png" style="width: 50px; height: 50px;"><?php
                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                    ?>
                            </div>
                            <div style='width:90%; float:left;'>
                                <strong style='font-size: 14px; font-weight:bold;'>COMPROBANTE DE RETENCION DEL IMPUESTO AL VALOR AGREGADO</strong><br>
                                <strong style='font-size: 10px; font-weight:bold;'>Ley IVA. Art. 11:</strong>
                                <strong style='font-size: 10px;'>Seran responsables del pago del impuesto en calidad de agentes de retencion, los compradores o adquirientes de determinados bienes muebles y los receptores de ciertos servicios, a quienes la Administracion Tributaria designe como tal.</strong>
                            </div>
                        </div>
                        <div class='row' style='font-size: 8px;'>
                            <div class='col-8'>
                                <br>
                                <div class='row'>
                                    <div class='col-5' style='border: solid 2px black;'>
                                        <strong style='font-weight: bold;'>NOMBRE O RAZÓN SOCIAL AGENTE DE RETENCIÓN</strong>
                                        <br>
                                        <?php echo $NameCompany; ?>
                                    </div>
                                    <div class='col-1' style='visibility:hidden;'>1</div>
                                    <div class='col-6' style='border: solid 2px black;'>
                                        <strong style='font-weight: bold;'>RIF DEL AGENTE DE RETENCIÓN</strong>
                                        <br>
                                        <?php
                                        if ($IDFiscal <> "") {
                                            echo $IDFiscal;
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-12' style='border: solid 2px black;'>
                                        <strong style='font-weight: bold;'>DIRECCION FISCAL DEL AGENTE DE RETENCIÓN</strong>
                                        <br>
                                        <?php
                                        if ($Direccion <> "") {
                                            echo $Direccion;
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-5' style='border: solid 2px black;'>
                                        <strong style='font-weight: bold;'>NOMBRE O RAZÓN SOCIAL DEL SUJETO RETENIDO</strong>
                                        <br><?php echo $Beneficiario; ?>
                                    </div>
                                    <div class='col-1' style='visibility:hidden;'>1</div>
                                    <div class='col-6' style='border: solid 2px black;'>
                                        <strong style='font-weight: bold;'>RIF DEL SUJETO RETENIDO</strong>
                                        <br><?php echo $IdResponsable; ?>
                                    </div>
                                </div>
                            </div>
                            <div class='col-1'>
                                <strong style='visibility:hidden;'>-</strong>
                            </div>
                            <div class='col-3'>
                                <div class='row'>
                                    <div class='col-12 text-center' style='border: solid 2px black; '>
                                        N° COMPROBANTE
                                        <br><strong style='font-weight: bold;'><?php echo $Referencia; ?></strong>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-6' style='border-top: solid 2px black; border-left: solid 2px black; border-right: solid 1px black; border-bottom: solid 2px black; font-weight: bold;'><?php echo $Fectxclient; ?><br></div>
                                    <div class='col-6' style='border-top: solid 2px black; border-left: solid 1px black; border-right: solid 2px black; border-bottom: solid 2px black; font-weight: bold;'><?php echo $Fectxclient; ?><br></div>
                                </div>
                                <div class='row'>
                                    <div class='col-12 text-center' style='border: solid 2px black; font-weight: bold;'>
                                        PERIODO FISCAL
                                        <div class='col-6'>AÑO: <?php echo $Año; ?></div>
                                        <div class='col-6'>MES: <?php echo $Mes; ?></div>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div style='width:100%;'>
                            <div style='width:100%; text-align: center; font-size: 6px;'>
                                <div style='float:left; width:5%; border: solid 1px black; text-align: center'><br>OPER<br><br><br></div>
                                <div style='float:left; width:9%; border: solid 1px black; text-align: center'><br>FECHA FACTURA<br><br><br></div>
                                <div style='float:left; width:8%; border: solid 1px black; text-align: center'><br>N° FACTURA<br><br><br></div>
                                <div style='float:left; width:8%; border: solid 1px black; text-align: center'><br>N° CONTROL FACTURA<br><br></div>
                                <div style='float:left; width:6%; border: solid 1px black;'><br>N° NOTA DEBITO<br><br></div>
                                <div style='float:left; width:7%; border: solid 1px black; text-align: center'><br>N° NOTA CREDITO<br><br></div>
                                <div style='float:left; width:8%; border: solid 1px black; text-align: center'><br>N° FACTURA AFECTADA<br><br></div>
                                <div style='float:left; width:9%; border: solid 1px black; text-align: right;'><br>TOTAL COMPRA INCLUYENDO IVA<br><br></div>
                                <div style='float:left; width:9%; border: solid 1px black; text-align: right;'><br>COMPRAS SIN DERECHO A CREDITO FISCAL</div>
                                <div style='float:left; width:9%; border: solid 1px black; text-align: right;'><br>BASE IMPONIBLE<br><br><br></div>
                                <div style='float:left; width:5%; border: solid 1px black; text-align: right;'><br>% ALICUOTA<br><br></div>
                                <div style='float:left; width:9%; border: solid 1px black; text-align: right;'><br>IMPUESTO IVA<br><br><br></div>
                                <div style='float:left; width:8%; border: solid 1px black; text-align: right;'><br>IVA RETENIDO<br><br><br></div>
                            </div>
                            <div style='width:100%; font-size: 6px;'>
                                <div style='float:left; width:5%; border: solid 1px black; text-align: center;'>1</div>
                                <div style='float:left; width:9%; border: solid 1px black; text-align: center;'><?php echo $Fectxclient; ?></div>
                                <div style='float:left; width:8%; border: solid 1px black; text-align: center;'><?php if (($Idtipotx == 2) or ($Idtipotx == 7)) {
                                                                                                                    echo $Idtx;
                                                                                                                } else { ?><strong style='visibility:hidden;'>-</strong><?php } ?></div>
                                <div style='float:left; width:8%; border: solid 1px black; text-align: center'><?php if ($numctrol <> "") {
                                                                                                                    echo $numctrol;
                                                                                                                } else { ?><strong style='visibility:hidden;'>-</strong><?php } ?></div>
                                <div style='float:left; width:6%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:7%; border: solid 1px black; text-align: center;'><?php if ($Idtipotx == 3) {
                                                                                                                    echo $Idtx;
                                                                                                                } else { ?><strong style='visibility:hidden;'>-</strong><?php } ?></div>
                                <div style='float:left; width:8%; border: solid 1px black; text-align: center;'><?php if ($Idtipotx == 3) {
                                                                                                                    echo $IdtxPadre;
                                                                                                                } else { ?><strong style='visibility:hidden;'>-</strong><?php } ?></div>
                                <div style='float:left; width:9%; border: solid 1px black; text-align: right;'><?php echo number_format($Total * $tasa, $CD, $SimDec, $SimMil); ?></div>
                                <div style='float:left; width:9%; border: solid 1px black; text-align: right;'><?php echo number_format($excento * $tasa, $CD, $SimDec, $SimMil); ?></div>
                                <div style='float:left; width:9%; border: solid 1px black; text-align: right;'><?php echo number_format($imponible * $tasa, $CD, $SimDec, $SimMil); ?></div>
                                <div style='float:left; width:5%; border: solid 1px black; text-align: right;'><?php echo number_format($polcentaje, 2, ".", ""); ?></div>
                                <div style='float:left; width:9%; border: solid 1px black; text-align: right;'><?php echo number_format($impuesto * $tasa, $CD, $SimDec, $SimMil); ?></div>
                                <div style='float:left; width:8%; border: solid 1px black; text-align: right;'><?php echo number_format($Retencion , $CD, $SimDec, $SimMil); ?></div>
                            </div>
                            <div style='width:100%; font-size: 6px;'>
                                <div style='float:left; width:5%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:6%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:7%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:5%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                            </div>
                            <div style='width:100%; font-size: 6px;'>
                                <div style='float:left; width:5%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:6%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:7%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:5%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                            </div>
                            <div style='width:100%; font-size: 6px;'>
                                <div style='float:left; width:5%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:6%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:7%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:5%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                            </div>
                            <div style='width:100%; font-size: 6px;'>
                                <div style='float:left; width:5%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:6%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:7%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:5%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                            </div>
                            <div style='width:100%; font-size: 6px; '>
                                <div style='float:left; width:5%; border: solid 1px black; text-align: center;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black; text-align: center;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black; text-align: center;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black; text-align: center'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:6%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:7%; border: solid 1px black; text-align: center;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black; text-align: center;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black; text-align: right;'><?php echo number_format($Total * $tasa, $CD, $SimDec, $SimMil); ?></div>
                                <div style='float:left; width:9%; border: solid 1px black; text-align: right;'><?php echo number_format($excento * $tasa, $CD, $SimDec, $SimMil); ?></div>
                                <div style='float:left; width:9%; border: solid 1px black; text-align: right;'><?php echo number_format($imponible * $tasa, $CD, $SimDec, $SimMil); ?></div>
                                <div style='float:left; width:5%; border: solid 1px black; text-align: right;'><?php echo number_format($polcentaje, 2, ".", ""); ?></div>
                                <div style='float:left; width:9%; border: solid 1px black; text-align: right;'><?php echo number_format($impuesto * $tasa, $CD, $SimDec, $SimMil); ?></div>
                                <div style='float:left; width:8%; border: solid 1px black; text-align: right;'><?php echo number_format($Retencion , $CD, $SimDec, $SimMil); ?></div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td>
                        <br>
                        <br>
                        <br>
                        <br>
                        <div class='row'>
                            <div class='col-6 text-center'>___________________________________________________
                                <br>
                                FIRMA BENEFICIARIO
                            </div>
                            <div class='col-6 text-center'>___________________________________________________
                                <br>
                                FIRMA Y SELLO DEL AGENTE DE RETENCION
                            </div>
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
        <br>
        <br>
        <table>
            <thead>
                <tr>
                    <th>
                        <div style='width:100%;'>
                            <div style='width:10%; float:left;'>
                                <?php
                                if ($Logotipo !== "") {
                                ?><img src="<?php echo 'Comercio/' . $CompanyActual . '/' . 'entorno/' . $Logotipo; ?>" alt="" style="width: 50px; height: 50px;"><?php
                                                                                                                                                                } else {
                                                                                                                                                                    ?><img src="img/logo.png" style="width: 50px; height: 50px;"><?php
                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                    ?>
                            </div>
                            <div style='width:90%; float:left;'>
                                <strong style='font-size: 14px; font-weight:bold;'>COMPROBANTE DE RETENCION DEL IMPUESTO AL VALOR AGREGADO</strong><br>
                                <strong style='font-size: 10px; font-weight:bold;'>Ley IVA. Art. 11:</strong>
                                <strong style='font-size: 10px;'>Seran responsables del pago del impuesto en calidad de agentes de retencion, los compradores o adquirientes de determinados bienes muebles y los receptores de ciertos servicios, a quienes la Administracion Tributaria designe como tal.</strong>
                            </div>
                        </div>
                        <div class='row' style='font-size: 8px;'>
                            <div class='col-8'>
                                <br>
                                <div class='row'>
                                    <div class='col-5' style='border: solid 2px black;'><strong style='font-weight: bold;'>NOMBRE O RAZÓN SOCIAL AGENTE DE RETENCIÓN</strong><br><?php echo $NameCompany; ?></div>
                                    <div class='col-1' style='visibility:hidden;'>1</div>
                                    <div class='col-6' style='border: solid 2px black;'><strong style='font-weight: bold;'>RIF DEL AGENTE DE RETENCIÓN</strong><br><?php if ($IDFiscal <> "") {
                                                                                                                                                                        echo $IDFiscal;
                                                                                                                                                                    } else {
                                                                                                                                                                        echo '-';
                                                                                                                                                                    } ?></div>
                                </div>
                                <div class='row'>
                                    <div class='col-12' style='border: solid 2px black;'><strong style='font-weight: bold;'>DIRECCION FISCAL DEL AGENTE DE RETENCIÓN</strong><br><?php if ($Direccion <> "") {
                                                                                                                                                                                        echo $Direccion;
                                                                                                                                                                                    } else {
                                                                                                                                                                                        echo '-';
                                                                                                                                                                                    } ?></div>
                                </div>
                                <div class='row'>
                                    <div class='col-5' style='border: solid 2px black;'><strong style='font-weight: bold;'>NOMBRE O RAZÓN SOCIAL DEL SUJETO RETENIDO</strong><br><?php echo $Beneficiario; ?></div>
                                    <div class='col-1' style='visibility:hidden;'>1</div>
                                    <div class='col-6' style='border: solid 2px black;'><strong style='font-weight: bold;'>RIF DEL SUJETO RETENIDO</strong><br><?php echo $IdResponsable; ?></div>
                                </div>
                            </div>
                            <div class='col-1'>
                                <strong style='visibility:hidden;'>-</strong>
                            </div>
                            <div class='col-3'>
                                <div class='row'>
                                    <div class='col-12 text-center' style='border: solid 2px black; '>
                                        N° COMPROBANTE <br>
                                        <strong style='font-weight: bold;'><?php echo $Referencia; ?></strong>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-6' style='border-top: solid 2px black; border-left: solid 2px black; border-right: solid 1px black; border-bottom: solid 2px black; font-weight: bold;'><?php echo $Fectxclient; ?><br></div>
                                    <div class='col-6' style='border-top: solid 2px black; border-left: solid 1px black; border-right: solid 2px black; border-bottom: solid 2px black; font-weight: bold;'><?php echo $Fectxclient; ?><br></div>
                                </div>
                                <div class='row'>
                                    <div class='col-12 text-center' style='border: solid 2px black; font-weight: bold;'>
                                        PERIODO FISCAL
                                        <div class='col-6'>AÑO: <?php echo $Año; ?></div>
                                        <div class='col-6'>MES: <?php echo $Mes; ?></div>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div style='width:100%;'>
                            <div style='width:100%; text-align: center; font-size: 6px;'>
                                <div style='float:left; width:5%; border: solid 1px black; text-align: center'><br>OPER<br><br><br></div>
                                <div style='float:left; width:9%; border: solid 1px black; text-align: center'><br>FECHA FACTURA<br><br><br></div>
                                <div style='float:left; width:8%; border: solid 1px black; text-align: center'><br>N° FACTURA<br><br><br></div>
                                <div style='float:left; width:8%; border: solid 1px black; text-align: center'><br>N° CONTROL FACTURA<br><br></div>
                                <div style='float:left; width:6%; border: solid 1px black;'><br>N° NOTA DEBITO<br><br></div>
                                <div style='float:left; width:7%; border: solid 1px black; text-align: center'><br>N° NOTA CREDITO<br><br></div>
                                <div style='float:left; width:8%; border: solid 1px black; text-align: center'><br>N° FACTURA AFECTADA<br><br></div>
                                <div style='float:left; width:9%; border: solid 1px black; text-align: right;'><br>TOTAL COMPRA INCLUYENDO IVA<br><br></div>
                                <div style='float:left; width:9%; border: solid 1px black; text-align: right;'><br>COMPRAS SIN DERECHO A CREDITO FISCAL</div>
                                <div style='float:left; width:9%; border: solid 1px black; text-align: right;'><br>BASE IMPONIBLE<br><br><br></div>
                                <div style='float:left; width:5%; border: solid 1px black; text-align: right;'><br>% ALICUOTA<br><br></div>
                                <div style='float:left; width:9%; border: solid 1px black; text-align: right;'><br>IMPUESTO IVA<br><br><br></div>
                                <div style='float:left; width:8%; border: solid 1px black; text-align: right;'><br>IVA RETENIDO<br><br><br></div>
                            </div>
                            <div style='width:100%; font-size: 6px;'>
                                <div style='float:left; width:5%; border: solid 1px black; text-align: center;'>1</div>
                                <div style='float:left; width:9%; border: solid 1px black; text-align: center;'><?php echo $Fectxclient; ?></div>
                                <div style='float:left; width:8%; border: solid 1px black; text-align: center;'><?php if (($Idtipotx == 2) or ($Idtipotx == 7)) {
                                                                                                                    echo $Idtx;
                                                                                                                } else { ?><strong style='visibility:hidden;'>-</strong><?php } ?></div>
                                <div style='float:left; width:8%; border: solid 1px black; text-align: center'><?php if ($numctrol <> "") {
                                                                                                                    echo $numctrol;
                                                                                                                } else { ?><strong style='visibility:hidden;'>-</strong><?php } ?></div>
                                <div style='float:left; width:6%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:7%; border: solid 1px black; text-align: center;'><?php if ($Idtipotx == 3) {
                                                                                                                    echo $Idtx;
                                                                                                                } else { ?><strong style='visibility:hidden;'>-</strong><?php } ?></div>
                                <div style='float:left; width:8%; border: solid 1px black; text-align: center;'><?php if ($Idtipotx == 3) {
                                                                                                                    echo $IdtxPadre;
                                                                                                                } else { ?><strong style='visibility:hidden;'>-</strong><?php } ?></div>
                                <div style='float:left; width:9%; border: solid 1px black; text-align: right;'><?php echo number_format($Total * $tasa, $CD, $SimDec, $SimMil); ?></div>
                                <div style='float:left; width:9%; border: solid 1px black; text-align: right;'><?php echo number_format($excento * $tasa, $CD, $SimDec, $SimMil); ?></div>
                                <div style='float:left; width:9%; border: solid 1px black; text-align: right;'><?php echo number_format($imponible * $tasa, $CD, $SimDec, $SimMil); ?></div>
                                <div style='float:left; width:5%; border: solid 1px black; text-align: right;'><?php echo number_format($polcentaje, 2, ".", ""); ?></div>
                                <div style='float:left; width:9%; border: solid 1px black; text-align: right;'><?php echo number_format($impuesto * $tasa, $CD, $SimDec, $SimMil); ?></div>
                                <div style='float:left; width:8%; border: solid 1px black; text-align: right;'><?php echo number_format($Retencion, $CD, $SimDec, $SimMil); ?></div>
                            </div>
                            <div style='width:100%; font-size: 6px;'>
                                <div style='float:left; width:5%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:6%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:7%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:5%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                            </div>
                            <div style='width:100%; font-size: 6px;'>
                                <div style='float:left; width:5%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:6%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:7%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:5%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                            </div>
                            <div style='width:100%; font-size: 6px;'>
                                <div style='float:left; width:5%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:6%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:7%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:5%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                            </div>
                            <div style='width:100%; font-size: 6px;'>
                                <div style='float:left; width:5%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:6%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:7%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:5%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                            </div>
                            <div style='width:100%; font-size: 6px; '>
                                <div style='float:left; width:5%; border: solid 1px black; text-align: center;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black; text-align: center;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black; text-align: center;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black; text-align: center'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:6%; border: solid 1px black;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:7%; border: solid 1px black; text-align: center;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:8%; border: solid 1px black; text-align: center;'><strong style='visibility:hidden;'>-</strong></div>
                                <div style='float:left; width:9%; border: solid 1px black; text-align: right;'><?php echo number_format($Total * $tasa, $CD, $SimDec, $SimMil); ?></div>
                                <div style='float:left; width:9%; border: solid 1px black; text-align: right;'><?php echo number_format($excento * $tasa, $CD, $SimDec, $SimMil); ?></div>
                                <div style='float:left; width:9%; border: solid 1px black; text-align: right;'><?php echo number_format($imponible * $tasa, $CD, $SimDec, $SimMil); ?></div>
                                <div style='float:left; width:5%; border: solid 1px black; text-align: right;'><?php echo number_format($polcentaje, 2, ".", ""); ?></div>
                                <div style='float:left; width:9%; border: solid 1px black; text-align: right;'><?php echo number_format($impuesto * $tasa, $CD, $SimDec, $SimMil); ?></div>
                                <div style='float:left; width:8%; border: solid 1px black; text-align: right;'><?php echo number_format($Retencion , $CD, $SimDec, $SimMil); ?></div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td>
                        <br>
                        <br>
                        <br>
                        <br>
                        <div class='row'>
                            <div class='col-6 text-center'>___________________________________________________
                                <br>
                                FIRMA BENEFICIARIO
                            </div>
                            <div class='col-6 text-center'>___________________________________________________
                                <br>
                                FIRMA Y SELLO DEL AGENTE DE RETENCION
                            </div>
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
<?php
}
