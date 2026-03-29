<?php

if ($_POST["tabla"] == "estadocb") {
    include "ambiente.php";
    $conn = Conectar();
    session_start();
    $token['Token'] = sha1($_POST['correo']);

    if ($_POST['decisions'] == '3') {
        $query = "SELECT TxfecVence, max(item)+1 as Masimo FROM PosUpTxP WHERE IdCompany=" . $_POST["CompanyActual"] . " and Idtx='" . $_POST['Idtx'] . "' and Idtipotx='" . $_POST['Idtipotx'] . "' and IdEstacion='" . $_POST['IdEstacion'] . "'";
        $Vencimiento = '';
        $Masimo = '';
        if ($result = mysqli_query($conn, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $Vencimiento = $row['TxfecVence'];
                $Masimo = $row['Masimo'];
            }
            mysqli_free_result($result);
        }
        $CreditoDeVerdad = 0;
        $ContadoDeVerdad = ($_POST['Contado'] + ($_POST['ModalVuelto'] * $_POST['FactorDCambio']));
        $MontoPagar = $_POST['MontoPagar'] + $_POST['ModalVuelto'];

        $Efectivo = 0;
        $Vuelto = 0;
        $Tarjeta = 0;
        $Cheque = 0;
        $Tipo01 = 0;
        $Tipo02 = 0;
        $Tipo03 = 0;
        $Tipo04 = 0;
        if ($_POST['Efectivo'] > 0) {
            $_POST['Efectivo'] += $_POST['ModalVuelto'];
        } else  if ($_POST['Tarjeta'] > 0) {
            $_POST['Tarjeta'] += $_POST['ModalVuelto'];
        } else  if ($_POST['Cheque'] > 0) {
            $_POST['Cheque'] += $_POST['ModalVuelto'];
        } else  if ($_POST['Tipo01'] > 0) {
            $_POST['Tipo01'] += $_POST['ModalVuelto'];
        } else  if ($_POST['Tipo02'] > 0) {
            $_POST['Tipo02'] += $_POST['ModalVuelto'];
        } else  if ($_POST['Tipo03'] > 0) {
            $_POST['Tipo03'] += $_POST['ModalVuelto'];
        } else  if ($_POST['Tipo04'] > 0) {
            $_POST['Tipo04'] += $_POST['ModalVuelto'];
        }

        $statementI = "insert into PosUpTxP (IdCompany, Idtipotx, Idtx, IdEstacion, Item, Fectxserver, Fectxclient, MontoPagar, Contado, Credito, Efectivo, Vuelto, Tarjeta, TarjetaD, Cheque, ChequeD, Tipo01, Tipo01D, Tipo02, Tipo02D, Tipo03, Tipo03D, Tipo04, Tipo04D,Login, IdcompanyUser, IdResponsable,Caja,TxfecVence,DAmpliado,Referencia,tasa,TarjetaB,ChequeB,Tipo01B,Tipo02B,Tipo03B,Tipo04B,IdEstacion2,Caja2) values ";
        $statement = $statementI . "((SELECT Id FROM PosUpCompany where token='" . $token['Token'] . "'),'" . $_POST['Idtipotx'] . "','" . $_POST['Idtx'] . "','" . $_POST['IdEstacion'] . "'," . $Masimo . ",now(),'" . $_POST['Fectxclient2'] . "','" . $MontoPagar . "','" . $ContadoDeVerdad . "','" . $CreditoDeVerdad . "','" . $_POST['Efectivo'] . "','" . ($Vuelto) . "','" . $_POST['Tarjeta'] . "','" . $_POST['TarjetaD'] . "','" . $_POST['Cheque'] . "','" . $_POST['ChequeD'] . "','" . $_POST['Tipo01'] . "','" . $_POST['Tipo01D'] . "','" . $_POST['Tipo02'] . "','" . $_POST['Tipo02D'] . "','" . $_POST['Tipo03'] . "','" . $_POST['Tipo03D'] . "','" . $_POST['Tipo04'] . "','" . $_POST['Tipo04D'] . "','" . $_POST['IdUser'] . "','" . $_POST['IdCompanyUser'] . "','" . $_POST['IdBen'] . "',(SELECT CajaActual FROM PosUpCompanyEstacion where token='" . $_POST['IdEstacion'] . "'),'" . $Vencimiento . "','" . $_POST['dampliado'] . "','" . $_POST['Referencia'] . "','" . $_POST['FactorDCambio'] . "','" . $_POST['TarjetaB'] . "','" . $_POST['ChequeB'] . "','" . $_POST['Tipo01B'] . "','" . $_POST['Tipo02B'] . "','" . $_POST['Tipo03B'] . "','" . $_POST['Tipo04B'] . "','" . $_POST["IdEstacion2"] . "','" . $_POST["CajaActual"] . "')";
        $resultado =  mysqli_query($conn, $statement);
        if ($_POST['ModalVuelto'] > 0) {
            foreach ($_POST["Vueltos"] as $vuelto) {
                $CreditoVuelto = 0;
                $ContadoVuelto = (($vuelto["amount"] * $_POST['FactorDCambio'])) * -1;
                $MontoPagarVuelto = $vuelto["amount"] * -1;
                $Efectivo = 0;
                $Tarjeta = 0;
                $Cheque = 0;
                $Tipo01 = 0;
                $Tipo02 = 0;
                $Tipo03 = 0;
                $Tipo04 = 0;

                if ($vuelto["type"] === "1") {
                    $Efectivo = ($vuelto["amount"] * $_POST['FactorDCambio']) * -1;
                } else if ($vuelto["type"] === "2") {
                    $Tarjeta = ($vuelto["amount"] * $_POST['FactorDCambio']) * -1;
                } else if ($vuelto["type"] === "3") {
                    $Cheque = ($vuelto["amount"] * $_POST['FactorDCambio']) * -1;
                } else if ($vuelto["type"] === "4") {
                    $Tipo01 = ($vuelto["amount"] * $_POST['FactorDCambio']) * -1;
                } else if ($vuelto["type"] === "5") {
                    $Tipo02 = ($vuelto["amount"] * $_POST['FactorDCambio']) * -1;
                } else if ($vuelto["type"] === "6") {
                    $Tipo03 = ($vuelto["amount"] * $_POST['FactorDCambio']) * -1;
                } else if ($vuelto["type"] === "7") {
                    $Tipo04 = ($vuelto["amount"] * $_POST['FactorDCambio']) * -1;
                }
                $Masimo++;
                $statementI = "insert into PosUpTxP (IdCompany, Idtipotx, Idtx, IdEstacion, Item, Fectxserver, Fectxclient, MontoPagar, Contado, Credito, Efectivo, Vuelto, Tarjeta, TarjetaD, Cheque, ChequeD, Tipo01, Tipo01D, Tipo02, Tipo02D, Tipo03, Tipo03D, Tipo04, Tipo04D,Login, IdcompanyUser, IdResponsable,Caja,TxfecVence,DAmpliado,Referencia,tasa,TarjetaB,ChequeB,Tipo01B,Tipo02B,Tipo03B,Tipo04B,IdEstacion2,Caja2) values ";
                $statement = $statementI . "((SELECT Id FROM PosUpCompany where token='" . $token['Token'] . "'),'" . $_POST['Idtipotx'] . "','" . $_POST['Idtx'] . "','" . $_POST['IdEstacion'] . "'," . $Masimo . ",now(),'" . $_POST['Fectxclient2'] . "','" . $MontoPagarVuelto . "','" . $ContadoVuelto . "','" . $CreditoVuelto . "','" . $Efectivo . "',0,'" . $Tarjeta . "','','" . $Cheque . "','','" . $Tipo01 . "','','" . $Tipo02 . "','','" . $Tipo03 . "','','" . $Tipo04 . "','0','" . $_POST['IdUser'] . "','" . $_POST['IdCompanyUser'] . "','" . $_POST['IdBen'] . "',(SELECT CajaActual FROM PosUpCompanyEstacion where token='" . $_POST['IdEstacion'] . "'),'" . $Vencimiento . "','" . $_POST['dampliado'] . "','" . $_POST['Referencia'] . "','" . $_POST['FactorDCambio'] . "','0','0','0','0','0','0','" . $_POST["IdEstacion2"] . "','" . $_POST["CajaActual"] . "')";
                $resultado =  mysqli_query($conn, $statement);
                if ($resultado === false) {
                    echo $statement;
                }
            }
        }


        if ($resultado === true) {
            $query = "SELECT Contado,Credito,tasa FROM PosUpTxC WHERE IdCompany=" . $_POST["CompanyActual"] . " and Idtx='" . $_POST['Idtx'] . "' and Idtipotx='" . $_POST['Idtipotx'] . "' and IdEstacion='" . $_POST['IdEstacion'] . "'";
            if ($result = mysqli_query($conn, $query)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $tasa = 1;
                    if ($row['tasa'] > 1) {
                        $tasa = $row['tasa'];
                    }
                    $Contadoxd = $row['Contado'] + ($_POST['MontoPagar'] * $tasa);
                    $CreditoDeVerdad2 = $row['Credito'] - ($_POST['MontoPagar'] * $tasa);
                }
                mysqli_free_result($result);
            }
            $statement2 = "update PosUpTxC set Cobrado='" . $Contadoxd . "',Contado='" . $Contadoxd . "',Credito=" . $CreditoDeVerdad2 . " where IdCompany=" . trim($_POST["CompanyActual"]) . " and Idtx=" . trim($_POST["Idtx"]) . " and Idtipotx=" . trim($_POST["Idtipotx"]) . " and IdEstacion='" . trim($_POST["IdEstacion"]) . "'";
            $resultado2 =  mysqli_query($conn, $statement2);
            if ($resultado2 === true) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
    }

    if ($_POST['decisions'] == '4') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        echo TransactionAnticipo($conn, $_POST,  $token);
    }

    if ($_POST['decisions'] == '1') {
        $query = "SELECT TxfecVence, max(item)+1 as Masimo FROM PosUpTxP WHERE IdCompany=" . $_POST["CompanyActual"] . " and Idtx='" . $_POST['Idtx'] . "' and Idtipotx='" . $_POST['Idtipotx'] . "' and IdEstacion='" . $_POST['IdEstacion'] . "'";
        //echo $query;
        $Vencimiento = '';
        $Masimo = '';
        if ($result = mysqli_query($conn, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $Vencimiento = $row['TxfecVence'];
                $Masimo = $row['Masimo'];
            }
            mysqli_free_result($result);
        }
        $CreditoDeVerdad = $_POST['Credito'];
        $ContadoDeVerdad = $_POST['Contado'];
        $MontoPagar = $_POST['MontoPagar'];
        $statementI = "insert into PosUpTxP (IdCompany, Idtipotx, Idtx, IdEstacion, Item, Fectxserver, Fectxclient, MontoPagar, Contado, Credito, Efectivo, Vuelto, Tarjeta, TarjetaD, Cheque, ChequeD, Tipo01, Tipo01D, Tipo02, Tipo02D, Tipo03, Tipo03D, Tipo04, Tipo04D,Login, IdcompanyUser, IdResponsable,Caja,TxfecVence,DAmpliado,Referencia,tasa,TarjetaB,ChequeB,Tipo01B,Tipo02B,Tipo03B,Tipo04B,IdEstacion2,Caja2) values ";
        $statement = $statementI . "((SELECT Id FROM PosUpCompany where token='" . $token['Token'] . "'),'" . $_POST['Idtipotx'] . "','" . $_POST['Idtx'] . "','" . $_POST['IdEstacion'] . "'," . $Masimo . ",now(),'" . $_POST['Fectxclient2'] . "','" . $MontoPagar . "','" . $ContadoDeVerdad . "','" . $CreditoDeVerdad . "','" . $_POST['Efectivo'] . "','" . $_POST['Vuelto'] . "','" . $_POST['Tarjeta'] . "','" . $_POST['TarjetaD'] . "','" . $_POST['Cheque'] . "','" . $_POST['ChequeD'] . "','" . $_POST['Tipo01'] . "','" . $_POST['Tipo01D'] . "','" . $_POST['Tipo02'] . "','" . $_POST['Tipo02D'] . "','" . $_POST['Tipo03'] . "','" . $_POST['Tipo03D'] . "','" . $_POST['Tipo04'] . "','" . $_POST['Tipo04D'] . "','" . $_POST['IdUser'] . "','" . $_POST['IdCompanyUser'] . "','" . $_POST['IdBen'] . "',(SELECT CajaActual FROM PosUpCompanyEstacion where token='" . $_POST['IdEstacion'] . "'),'" . $Vencimiento . "','" . $_POST['dampliado'] . "','" . $_POST['Referencia'] . "','" . $_POST['FactorDCambio'] . "','" . $_POST['TarjetaB'] . "','" . $_POST['ChequeB'] . "','" . $_POST['Tipo01B'] . "','" . $_POST['Tipo02B'] . "','" . $_POST['Tipo03B'] . "','" . $_POST['Tipo04B'] . "','" . $_POST["IdEstacion2"] . "','" . $_POST["CajaActual"] . "')";
        //echo $statement;
        $resultado =  mysqli_query($conn, $statement);
        if ($resultado === true) {
            $query = "SELECT Contado,Credito,tasa FROM PosUpTxC WHERE IdCompany=" . $_POST["CompanyActual"] . " and Idtx='" . $_POST['Idtx'] . "' and Idtipotx='" . $_POST['Idtipotx'] . "' and IdEstacion='" . $_POST['IdEstacion'] . "'";
            //echo $query;
            if ($result = mysqli_query($conn, $query)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['tasa'] > 1) {
                        $tasa = $row['tasa'];
                    } else {
                        $tasa = 1;
                    }
                    $Contadoxd = $row['Contado'] - ($_POST['MontoPagar'] * $tasa);
                    $CreditoDeVerdad2 = $row['Credito'] + ($_POST['MontoPagar'] * $tasa);
                }
                mysqli_free_result($result);
            }
            $statement2 = "update PosUpTxC set Cobrado='" . $Contadoxd . "',Contado='" . $Contadoxd . "',Credito=" . $CreditoDeVerdad2 . " where IdCompany=" . trim($_POST["CompanyActual"]) . " and Idtx=" . trim($_POST["Idtx"]) . " and Idtipotx=" . trim($_POST["Idtipotx"]) . " and IdEstacion='" . trim($_POST["IdEstacion"]) . "'";
            $resultado2 =  mysqli_query($conn, $statement2);
            if ($resultado2 === true) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
    }

    if ($_POST['decisions'] == "5") {
        $ttx = "numanticipo";
        $CreditoDeVerdad = 0;

        $factor = 1;

        if ($_POST["AnticipoCompra"] == "true")   $factor = -1;

        $ContadoDeVerdad = $_POST['Contado'] * $factor;
        $MontoPagar = $_POST['MontoPagar'] * $factor;
        $statementI = "insert into PosUpTxP (IdCompany, Idtipotx, Idtx, IdEstacion, Item, Fectxserver, Fectxclient, MontoPagar, Contado, Credito, Efectivo, Vuelto, Tarjeta, TarjetaD, Cheque, ChequeD, Tipo01, Tipo01D, Tipo02, Tipo02D, Tipo03, Tipo03D, Tipo04, Tipo04D,Login, IdcompanyUser, IdResponsable,Caja,TxfecVence,DAmpliado,Referencia,tasa,TarjetaB,ChequeB,Tipo01B,Tipo02B,Tipo03B,Tipo04B) values ";
        $statement = $statementI . "((SELECT Id FROM PosUpCompany where token='" . $token['Token'] . "'),'25',(SELECT " . $ttx . "+1 FROM PosUpCompanyEstacion where token='" . $_POST["IdEstacion2"] . "'),'" . $_POST["IdEstacion2"] . "',1,now(),'" . $_POST['Fectxclient2'] . "','0','" . $ContadoDeVerdad . "','" . $CreditoDeVerdad . "','" . $_POST['Efectivo']  * $factor . "','" . $_POST['Vuelto'] * $factor . "','" . $_POST['Tarjeta'] * $factor . "','" . $_POST['TarjetaD'] . "','" . $_POST['Cheque'] * $factor . "','" . $_POST['ChequeD'] . "','" . $_POST['Tipo01']  * $factor . "','" . $_POST['Tipo01D'] . "','" . $_POST['Tipo02'] * $factor . "','" . $_POST['Tipo02D'] . "','" . $_POST['Tipo03'] * $factor . "','" . $_POST['Tipo03D'] . "','" . $_POST['Tipo04'] * $factor . "','" . $_POST['Tipo04D'] . "','" . $_POST['IdUser'] . "','" . $_POST['IdCompanyUser'] . "','" . $_POST['IdBen'] . "',(SELECT CajaActual FROM PosUpCompanyEstacion where token='" . $_POST["IdEstacion2"] . "'),'" . $_POST['Fectxclient2'] . "','" . $_POST['dampliado'] . "','" . $_POST['Referencia'] . "','" . $_POST['FactorDCambio'] . "','" . $_POST['TarjetaB'] . "','" . $_POST['ChequeB'] . "','" . $_POST['Tipo01B'] . "','" . $_POST['Tipo02B'] . "','" . $_POST['Tipo03B'] . "','" . $_POST['Tipo04B'] . "')";
        $resultado =  mysqli_query($conn, $statement);
        if ($resultado === true) {
            $statement2 = "insert into PosUpTxC (IdCompany, Idtipotx, Idtx, Fectxserver, Fectxclient,  IdUser, IdUserAutDcto, SubTotal, Dcto, Total, Costo, Margen, DctoAplicado, MargenDcto, Items, IdEstacion, Contado, Credito, Cobrado,IdCompanyUserAutDcto, IdCompanyUser,IdtipotxPadre, IdtxPadre, IdEstacionPadre,IdAlmO,IdAlmD,motivo,DAmpliado,IdBen,Referencia,excento,imponible,impuesto,totalimp,numctrol,TxfecVence,tasa) values ((SELECT Id FROM PosUpCompany where token='" . $token['Token'] . "'),'25',(SELECT " . $ttx . "+1 FROM PosUpCompanyEstacion where token='" . $_POST["IdEstacion2"] . "'),now(),'" . $_POST['Fectxclient'] . "','" . $_POST['IdUser'] . "','0','" . $ContadoDeVerdad . "','0','" . $ContadoDeVerdad . "','0','0','0','0','','" . $_POST["IdEstacion2"] . "','" . $ContadoDeVerdad . "','0','0','0','" . $_POST['IdCompanyUser'] . "','0','0','0','0','0','0','" . $_POST['dampliado'] . "','" . $_POST['IdBen'] . "','" . $_POST['Referencia'] . "','0','0','0','0','0','" . $_POST['Fectxclient'] . "','" . $_POST['FactorDCambio'] . "')";
            //echo $statement2;
            $resultado1 =  mysqli_query($conn, $statement2);
            if ($resultado1 === true) {
                $statement3 = "update PosUpCompanyEstacion set " . $ttx . "=" . $ttx . "+1 where token='" . $_POST["IdEstacion2"] . "'";
                //echo $statement3;
                $resultado2 = mysqli_query($conn, $statement3);
                if ($resultado2 === true) {
                    echo 1;
                } else {
                    echo $statement3;
                    echo 0;
                }
            } else {
                echo $statement2;
                echo 0;
            }
        } else {
            echo $statement;
            echo 0;
        }
    }

    if ($_POST['decisions'] == "2") {
        $query = "SELECT tasa FROM PosUpTxC WHERE IdCompany=" . $_POST["CompanyActual"] . " and Idtx='" . $_POST['Idtx'] . "' and Idtipotx='" . $_POST['Idtipotx'] . "' and IdEstacion='" . $_POST['IdEstacion'] . "'";
        $tasa = 0;
        if ($result = mysqli_query($conn, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $tasa = $row['tasa'];
            }
            mysqli_free_result($result);
        }
        $query = "SELECT TxfecVence, max(item)+1 as Masimo FROM PosUpTxP WHERE IdCompany=" . $_POST["CompanyActual"] . " and Idtx='" . $_POST['Idtx'] . "' and Idtipotx='" . $_POST['Idtipotx'] . "' and IdEstacion='" . $_POST['IdEstacion'] . "'";
        $Vencimiento = "";
        $ItemMaximo = "";
        if ($result = mysqli_query($conn, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $Vencimiento = $row['TxfecVence'];
                $ItemMaximo = $row['Masimo'];
            }
            mysqli_free_result($result);
        }
        $CreditoTxP = 0;
        $ContadoTxP = $_POST['Retencion'];
        $MontoPagar = ($_POST['MontoPagar'] / $tasa);

        $Efectivo = 0;
        $Vuelto = 0;
        $Tarjeta = 0;
        $Cheque = 0;
        $Tipo01 = 0;
        $Tipo02 = 0;
        $Tipo03 = 0;
        $Tipo04 = 0;

        if ($_POST['Efectivo'] > 0) {
            $_POST['Efectivo'] += $_POST['ModalVuelto'];
        } else  if ($_POST['Tarjeta'] > 0) {
            $_POST['Tarjeta'] += $_POST['ModalVuelto'];
        } else  if ($_POST['Cheque'] > 0) {
            $_POST['Cheque'] += $_POST['ModalVuelto'];
        } else  if ($_POST['Tipo01'] > 0) {
            $_POST['Tipo01'] += $_POST['ModalVuelto'];
        } else  if ($_POST['Tipo02'] > 0) {
            $_POST['Tipo02'] += $_POST['ModalVuelto'];
        } else  if ($_POST['Tipo03'] > 0) {
            $_POST['Tipo03'] += $_POST['ModalVuelto'];
        } else  if ($_POST['Tipo04'] > 0) {
            $_POST['Tipo04'] += $_POST['ModalVuelto'];
        }

        $statementI = "insert into PosUpTxP (IdCompany, Idtipotx, Idtx, IdEstacion, Item, Fectxserver, Fectxclient, MontoPagar, Contado, Credito, Efectivo, Vuelto, Tarjeta, TarjetaD, Cheque, ChequeD, Tipo01, Tipo01D, Tipo02, Tipo02D, Tipo03, Tipo03D, Tipo04, Tipo04D,Login, IdcompanyUser, IdResponsable,Caja,TxfecVence,DAmpliado,Referencia,montoretencion,tasa,TarjetaB,ChequeB,Tipo01B,Tipo02B,Tipo03B,Tipo04B,tiporetencion,numret,IdEstacion2,Caja2) values ";
        $statement = $statementI . "((SELECT Id FROM PosUpCompany where token='" . $token['Token'] . "'),'" . $_POST['Idtipotx'] . "','" . $_POST['Idtx'] . "','" . $_POST['IdEstacion'] . "'," . $ItemMaximo . ",now(),'" . $_POST['Fectxclient2'] . "','" . ($MontoPagar + $_POST['ModalVuelto']) . "','0','" . $CreditoTxP . "','" . $_POST['Efectivo'] . "','" . $Vuelto . "','" . $_POST['Tarjeta'] . "','" . $_POST['TarjetaD'] . "','" . $_POST['Cheque'] . "','" . $_POST['ChequeD'] . "','" . $_POST['Tipo01'] . "','" . $_POST['Tipo01D'] . "','" . $_POST['Tipo02'] . "','" . $_POST['Tipo02D'] . "','" . $_POST['Tipo03'] . "','" . $_POST['Tipo03D'] . "','" . $_POST['Tipo04'] . "','" . $_POST['Tipo04D'] . "','" . $_POST['IdUser'] . "','" . $_POST['IdCompanyUser'] . "','" . $_POST['IdBen'] . "',(SELECT CajaActual FROM PosUpCompanyEstacion where token='" . $_POST['IdEstacion'] . "'),'" . $Vencimiento . "','" . $_POST['dampliado'] . "','" . $_POST['Referencia'] . "','" . $ContadoTxP . "','" . $tasa . "','" . $_POST['TarjetaB'] . "','" . $_POST['ChequeB'] . "','" . $_POST['Tipo01B'] . "','" . $_POST['Tipo02B'] . "','" . $_POST['Tipo03B'] . "','" . $_POST['Tipo04B'] . "','0','" . trim($_POST['numret']) . "','" . $_POST["IdEstacion2"] . "','" . $_POST["CajaActual"] . "')";
        $resultado =  mysqli_query($conn, $statement);
        if ($_POST['ModalVuelto'] > 0) {
            foreach ($_POST["Vueltos"] as $vuelto) {
                $CreditoVuelto = 0;
                $ContadoVuelto = (($vuelto["amount"] * $_POST['FactorDCambio'])) * -1;
                $MontoPagarVuelto = $vuelto["amount"] * -1;
                $Efectivo = 0;
                $Tarjeta = 0;
                $Cheque = 0;
                $Tipo01 = 0;
                $Tipo02 = 0;
                $Tipo03 = 0;
                $Tipo04 = 0;

                if ($vuelto["type"] === "1") {
                    $Efectivo = ($vuelto["amount"] * $_POST['FactorDCambio']) * -1;
                } else if ($vuelto["type"] === "2") {
                    $Tarjeta = ($vuelto["amount"] * $_POST['FactorDCambio']) * -1;
                } else if ($vuelto["type"] === "3") {
                    $Cheque = ($vuelto["amount"] * $_POST['FactorDCambio']) * -1;
                } else if ($vuelto["type"] === "4") {
                    $Tipo01 = ($vuelto["amount"] * $_POST['FactorDCambio']) * -1;
                } else if ($vuelto["type"] === "5") {
                    $Tipo02 = ($vuelto["amount"] * $_POST['FactorDCambio']) * -1;
                } else if ($vuelto["type"] === "6") {
                    $Tipo03 = ($vuelto["amount"] * $_POST['FactorDCambio']) * -1;
                } else if ($vuelto["type"] === "7") {
                    $Tipo04 = ($vuelto["amount"] * $_POST['FactorDCambio']) * -1;
                }
                $ItemMaximo++;
                $statementI = "insert into PosUpTxP (IdCompany, Idtipotx, Idtx, IdEstacion, Item, Fectxserver, Fectxclient, MontoPagar, Contado, Credito, Efectivo, Vuelto, Tarjeta, TarjetaD, Cheque, ChequeD, Tipo01, Tipo01D, Tipo02, Tipo02D, Tipo03, Tipo03D, Tipo04, Tipo04D,Login, IdcompanyUser, IdResponsable,Caja,TxfecVence,DAmpliado,Referencia,tasa,TarjetaB,ChequeB,Tipo01B,Tipo02B,Tipo03B,Tipo04B,IdEstacion2,Caja2) values ";
                $statement = $statementI . "((SELECT Id FROM PosUpCompany where token='" . $token['Token'] . "'),'" . $_POST['Idtipotx'] . "','" . $_POST['Idtx'] . "','" . $_POST['IdEstacion'] . "'," . $ItemMaximo . ",now(),'" . $_POST['Fectxclient2'] . "','" . $MontoPagarVuelto . "','" . $ContadoVuelto . "','" . $CreditoVuelto . "','" . $Efectivo . "',0,'" . $Tarjeta . "','','" . $Cheque . "','','" . $Tipo01 . "','','" . $Tipo02 . "','','" . $Tipo03 . "','','" . $Tipo04 . "','0','" . $_POST['IdUser'] . "','" . $_POST['IdCompanyUser'] . "','" . $_POST['IdBen'] . "',(SELECT CajaActual FROM PosUpCompanyEstacion where token='" . $_POST['IdEstacion'] . "'),'" . $Vencimiento . "','" . $_POST['dampliado'] . "','" . $_POST['Referencia'] . "','" . $_POST['FactorDCambio'] . "','0','0','0','0','0','0','" . $_POST["IdEstacion2"] . "','" . $_POST["CajaActual"] . "')";
                $resultado =  mysqli_query($conn, $statement);
                if ($resultado === false) {
                    echo $statement;
                }
            }
        }
        if ($resultado === true) {
            $query = "SELECT Contado,Credito,tasa FROM PosUpTxC WHERE IdCompany=" . $_POST["CompanyActual"] . " and Idtx='" . $_POST['Idtx'] . "' and Idtipotx='" . $_POST['Idtipotx'] . "' and IdEstacion='" . $_POST['IdEstacion'] . "'";
            if ($result = mysqli_query($conn, $query)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['tasa'] > 1) {
                        $tasa = $row['tasa'];
                    } else {
                        $tasa = 1;
                    }
                    $ContadoTxC = $row['Contado'] + ($MontoPagar * $tasa);
                    $CreditoTxC = $row['Credito'] - ($MontoPagar * $tasa);
                }
                mysqli_free_result($result);
            }
            $statement2 = "update PosUpTxC set Cobrado='" . $ContadoTxC . "',Contado='" . $ContadoTxC . "',Credito=" . $CreditoTxC . " where IdCompany=" . trim($_POST["CompanyActual"]) . " and Idtx=" . trim($_POST["Idtx"]) . " and Idtipotx=" . trim($_POST["Idtipotx"]) . " and IdEstacion='" . trim($_POST["IdEstacion"]) . "'";
            $resultado2 =  mysqli_query($conn, $statement2);
            if ($resultado2 === true) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
    }

    if ($_POST['decisions'] == '9') {
        $query = "SELECT tasa FROM PosUpTxC WHERE IdCompany=" . $_POST["CompanyActual"] . " and Idtx='" . $_POST['Idtx'] . "' and Idtipotx='" . $_POST['Idtipotx'] . "' and IdEstacion='" . $_POST['IdEstacion'] . "'";
        $tasa = 0;
        if ($result = mysqli_query($conn, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $tasa = $row['tasa'];
            }
            mysqli_free_result($result);
        }
        $query = "SELECT TxfecVence, max(item)+1 as Masimo FROM PosUpTxP WHERE IdCompany=" . $_POST["CompanyActual"] . " and Idtx='" . $_POST['Idtx'] . "' and Idtipotx='" . $_POST['Idtipotx'] . "' and IdEstacion='" . $_POST['IdEstacion'] . "'";
        $Vencimiento = "";
        $ItemMaximo = "";
        if ($result = mysqli_query($conn, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $Vencimiento = $row['TxfecVence'];
                $ItemMaximo = $row['Masimo'];
            }
            mysqli_free_result($result);
        }
        $CreditoTxP = 0;
        $ContadoTxP = $_POST['Retencion'];
        $MontoPagar = ($_POST['MontoPagar'] / $tasa);
        $statementI = "insert into PosUpTxP (IdCompany, Idtipotx, Idtx, IdEstacion, Item, Fectxserver, Fectxclient, MontoPagar, Contado, Credito, Efectivo, Vuelto, Tarjeta, TarjetaD, Cheque, ChequeD, Tipo01, Tipo01D, Tipo02, Tipo02D, Tipo03, Tipo03D, Tipo04, Tipo04D,Login, IdcompanyUser, IdResponsable,Caja,TxfecVence,DAmpliado,Referencia,montoretencion,tasa,TarjetaB,ChequeB,Tipo01B,Tipo02B,Tipo03B,Tipo04B,tiporetencion,numret,IdEstacion2,Caja2) values ";
        $statement = $statementI . "((SELECT Id FROM PosUpCompany where token='" . $token['Token'] . "'),'" . $_POST['Idtipotx'] . "','" . $_POST['Idtx'] . "','" . $_POST['IdEstacion'] . "'," . $ItemMaximo . ",now(),'" . $_POST['Fectxclient2'] . "','" . $MontoPagar . "','0','" . $CreditoTxP . "','" . $_POST['Efectivo'] . "','" . $_POST['Vuelto'] . "','" . $_POST['Tarjeta'] . "','" . $_POST['TarjetaD'] . "','" . $_POST['Cheque'] . "','" . $_POST['ChequeD'] . "','" . $_POST['Tipo01'] . "','" . $_POST['Tipo01D'] . "','" . $_POST['Tipo02'] . "','" . $_POST['Tipo02D'] . "','" . $_POST['Tipo03'] . "','" . $_POST['Tipo03D'] . "','" . $_POST['Tipo04'] . "','" . $_POST['Tipo04D'] . "','" . $_POST['IdUser'] . "','" . $_POST['IdCompanyUser'] . "','" . $_POST['IdBen'] . "',(SELECT CajaActual FROM PosUpCompanyEstacion where token='" . $_POST['IdEstacion'] . "'),'" . $Vencimiento . "','" . $_POST['dampliado'] . "','" . $_POST['Referencia'] . "','" . $ContadoTxP . "','" . $tasa . "','" . $_POST['TarjetaB'] . "','" . $_POST['ChequeB'] . "','" . $_POST['Tipo01B'] . "','" . $_POST['Tipo02B'] . "','" . $_POST['Tipo03B'] . "','" . $_POST['Tipo04B'] . "','1','" . trim($_POST['numret']) . "','" . $_POST["IdEstacion2"] . "','" . $_POST["CajaActual"] . "')";
        $resultado =  mysqli_query($conn, $statement);
        if ($resultado === true) {
            $query = "SELECT Contado,Credito,tasa FROM PosUpTxC WHERE IdCompany=" . $_POST["CompanyActual"] . " and Idtx='" . $_POST['Idtx'] . "' and Idtipotx='" . $_POST['Idtipotx'] . "' and IdEstacion='" . $_POST['IdEstacion'] . "'";
            if ($result = mysqli_query($conn, $query)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['tasa'] > 1) {
                        $tasa = $row['tasa'];
                    } else {
                        $tasa = 1;
                    }
                    $ContadoTxC = $row['Contado'] + ($MontoPagar * $tasa);
                    $CreditoTxC = $row['Credito'] - ($MontoPagar * $tasa);
                }
                mysqli_free_result($result);
            }
            $statement2 = "update PosUpTxC set Cobrado='" . $ContadoTxC . "',Contado='" . $ContadoTxC . "',Credito=" . $CreditoTxC . " where IdCompany=" . trim($_POST["CompanyActual"]) . " and Idtx=" . trim($_POST["Idtx"]) . " and Idtipotx=" . trim($_POST["Idtipotx"]) . " and IdEstacion='" . trim($_POST["IdEstacion"]) . "'";
            $resultado2 =  mysqli_query($conn, $statement2);
            if ($resultado2 === true) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
    }

    if ($_POST['decisions'] == '7') {
        $query = "SELECT Contado,Credito,montoretencion,tasa FROM PosUpTxP WHERE IdCompany=" . $_POST["CompanyActual"] . " and Idtx='" . $_POST['Idtx'] . "' and Idtipotx='" . $_POST['Idtipotx'] . "' and IdEstacion='" . $_POST['IdEstacion'] . "' and item='" . $_POST['Item'] . "'";
        //echo $query;
        $Contado = 0;
        $Credito = 0;
        if ($result = mysqli_query($conn, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $Contado = ($row['Contado'] + $row['montoretencion']) / $row['tasa'];
                $Credito = $row['Credito'] / $row['tasa'];
            }
            mysqli_free_result($result);
        }
        $statement = "DELETE FROM PosUpTxP WHERE IdCompany='" . $_POST['CompanyActual'] . "' and item='" . $_POST['Item'] . "' and Idtx='" . $_POST['Idtx'] . "' and Idtipotx='" . $_POST['Idtipotx'] . "' and IdEstacion='" . $_POST['IdEstacion'] . "'";
        //echo $statement;
        $resultado =  mysqli_query($conn, $statement);
        if ($resultado === true) {
            $query = "SELECT Contado,Credito,tasa FROM PosUpTxC WHERE IdCompany=" . $_POST["CompanyActual"] . " and Idtx='" . $_POST['Idtx'] . "' and Idtipotx='" . $_POST['Idtipotx'] . "' and IdEstacion='" . $_POST['IdEstacion'] . "'";
            //echo $query;
            if ($result = mysqli_query($conn, $query)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $Contadoxd = ($row['Contado'] - ($Contado * $row['tasa'])) + ($Credito * $row['tasa']);
                    $CreditoDeVerdad2 = ($row['Credito'] - ($Credito * $row['tasa'])) + ($Contado * $row['tasa']);
                }
                mysqli_free_result($result);
            }
            $statement2 = "update PosUpTxC set Cobrado='" . $Contadoxd . "',Contado='" . $Contadoxd . "',Credito=" . $CreditoDeVerdad2 . " where IdCompany=" . trim($_POST["CompanyActual"]) . " and Idtx=" . trim($_POST["Idtx"]) . " and Idtipotx=" . trim($_POST["Idtipotx"]) . " and IdEstacion='" . trim($_POST["IdEstacion"]) . "'";
            $resultado2 =  mysqli_query($conn, $statement2);
            if ($resultado2 === true) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
    }

    if ($_POST['decisions'] == '8') {
        $statement = "DELETE FROM PosUpTxP WHERE IdCompany='" . $_POST['CompanyActual'] . "' and Idtx='" . $_POST['Idtx'] . "' and Idtipotx='" . $_POST['Idtipotx'] . "' and IdEstacion='" . $_POST['IdEstacion'] . "'";
        $resultado =  mysqli_query($conn, $statement);
        if ($resultado === true) {
            $statement2 = "DELETE FROM PosUpTxC WHERE IdCompany='" . $_POST['CompanyActual'] . "' and Idtx='" . $_POST['Idtx'] . "' and Idtipotx='" . $_POST['Idtipotx'] . "' and IdEstacion='" . $_POST['IdEstacion'] . "'";
            $resultado2 =  mysqli_query($conn, $statement2);
            if ($resultado2 === true) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
    }

    if ($_POST['decisions'] == '6') {
        $query = "SELECT Contado,Credito,montoretencion,TxfecVence FROM PosUpTxP WHERE IdCompany=" . $_POST["CompanyActual"] . " and Idtx='" . $_POST['Idtx'] . "' and Idtipotx='" . $_POST['Idtipotx'] . "' and IdEstacion='" . $_POST['IdEstacion'] . "' and item='" . $_POST['Item'] . "'";
        //echo $query;
        $Contado = 0;
        $Credito = 0;
        $Vencimiento = "";
        if ($result = mysqli_query($conn, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $Contado = $row['Contado'] + $row['montoretencion'];
                $Credito = $row['Credito'];
                $Vencimiento = $row['TxfecVence'];
            }
            mysqli_free_result($result);
        }
        $statement = "DELETE FROM PosUpTxP WHERE IdCompany='" . $_POST['CompanyActual'] . "' and item='" . $_POST['Item'] . "' and Idtx='" . $_POST['Idtx'] . "' and Idtipotx='" . $_POST['Idtipotx'] . "' and IdEstacion='" . $_POST['IdEstacion'] . "'";
        //echo $statement;
        $resultado =  mysqli_query($conn, $statement);
        $CreditoDeVerdad = 0;
        $ContadoDeVerdad = $_POST['MontoPagar'];
        $MontoPagar = $_POST['MontoPagar'];
        $statementI = "insert into PosUpTxP (IdCompany, Idtipotx, Idtx, IdEstacion, Item, Fectxserver, Fectxclient, MontoPagar, Contado, Credito, Efectivo, Vuelto, Tarjeta, TarjetaD, Cheque, ChequeD, Tipo01, Tipo01D, Tipo02, Tipo02D, Tipo03, Tipo03D, Tipo04, Tipo04D,Login, IdcompanyUser, IdResponsable,Caja,TxfecVence,DAmpliado,Referencia,montoretencion) values ";
        $statement = $statementI . "((SELECT Id FROM PosUpCompany where token='" . $token['Token'] . "'),'" . $_POST['Idtipotx'] . "','" . $_POST['Idtx'] . "','" . $_POST['IdEstacion'] . "','" . $_POST['Item'] . "',now(),'" . $_POST['Fectxclient2'] . "','" . $MontoPagar . "','0','" . $CreditoDeVerdad . "',0,0,0,'',0,'',0,'',0,'',0,'',0,'','" . $_POST['IdUser'] . "','" . $_POST['IdCompanyUser'] . "','" . $_POST['IdBen'] . "',(SELECT CajaActual FROM PosUpCompanyEstacion where token='" . $_POST['IdEstacion'] . "'),'" . $Vencimiento . "','" . $_POST['dampliado'] . "','" . $_POST['Referencia'] . "','" . $ContadoDeVerdad . "')";
        $resultado =  mysqli_query($conn, $statement);
        //echo $statement;
        if ($resultado === true) {
            $query = "SELECT Contado,Credito,tasa FROM PosUpTxC WHERE IdCompany=" . $_POST["CompanyActual"] . " and Idtx='" . $_POST['Idtx'] . "' and Idtipotx='" . $_POST['Idtipotx'] . "' and IdEstacion='" . $_POST['IdEstacion'] . "'";
            //echo $query;
            if ($result = mysqli_query($conn, $query)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['tasa'] > 1) {
                        $tasa = $row['tasa'];
                    } else {
                        $tasa = 1;
                    }
                    $Contadoxd = $row['Contado'] + ($_POST['MontoPagar'] * $tasa);
                    $CreditoDeVerdad2 = $row['Credito'] - ($_POST['MontoPagar'] * $tasa);
                }
                mysqli_free_result($result);
            }
            $statement2 = "update PosUpTxC set Cobrado='" . $Contadoxd . "',Contado='" . $Contadoxd . "',Credito=" . $CreditoDeVerdad2 . " where IdCompany=" . trim($_POST["CompanyActual"]) . " and Idtx=" . trim($_POST["Idtx"]) . " and Idtipotx=" . trim($_POST["Idtipotx"]) . " and IdEstacion='" . trim($_POST["IdEstacion"]) . "'";
            $resultado2 =  mysqli_query($conn, $statement2);
            if ($resultado2 === true) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
    }
}

if ($_POST["tabla"] === "registrarPago") {
    include "ambiente.php";
    $conn = Conectar();

    echo json_encode(registrarPago($conn, $_POST));
}

if ($_POST["tabla"] == "PagoUnico") {
    include "ambiente.php";
    $conn = conectar();

    echo SavePagoUnico($conn, $_POST);
}

function registrarPago($conn, $post)
{
    $array = json_decode($post["json"], true);


    $datos['FactorDolarActual'] = $post['tasa'];
    $datos['Idtipotx'] = $post['Idtipotx'];
    $datos['Idtx'] = $post['Idtx'];
    $datos['IdEstacion'] = $post['IdEstacion'];
    $datos['Fectxclient'] = $post["Fectxclient"];
    $datos['IdUser'] = $post["IdUser"];
    $datos['IdBen'] = $post["IdBen"];
    $token['Token'] = sha1($post['correo']);

    $Vencimiento = '';
    $it = 1;
    $query = "SELECT TxfecVence, max(item)+1 as it FROM PosUpTxP WHERE IdCompany=" . $post["CompanyActual"] . " and Idtx='" . $datos['Idtx'] . "' and Idtipotx='" . $datos['Idtipotx'] . "' and IdEstacion='" . $datos['IdEstacion'] . "'";
    if ($result = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $Vencimiento = $row['TxfecVence'];
            $it = $row['it'];
        }
        mysqli_free_result($result);
    }
    $CD = $_POST["CD"];
    $statamen4 = "";
    foreach ($array as $data) {
        // $MontoAPagar = ROUND($data["Monto"] / $datos['FactorDolarActual'], $CD);

        $Efectivo = 0;
        $Tarjeta = 0;
        $TarjetaD = "";
        $TarjetaB = 0;
        $Cheque = 0;
        $ChequeD = "";
        $ChequeB = 0;
        $Tipo01 = 0;
        $Tipo01D = "";
        $Tipo01B = 0;
        $Tipo02 = 0;
        $Tipo02D = "";
        $Tipo02B = 0;
        $Tipo03 = 0;
        $Tipo03D = "";
        $Tipo03B = 0;
        $Tipo04 = 0;
        $Tipo04D = "";
        $Tipo04B = 0;

        $statement = "insert into PosUpTxP (IdCompany, Idtipotx, Idtx, IdEstacion, Item, Fectxserver, Fectxclient, MontoPagar, Contado, Credito, Efectivo,Vuelto, Tarjeta, TarjetaD, Cheque, ChequeD, Tipo01, Tipo01D, Tipo02, Tipo02D, Tipo03, Tipo03D, Tipo04, Tipo04D,Login, IdcompanyUser, IdResponsable,Caja,TxfecVence,TarjetaB,ChequeB,Tipo01B,Tipo02B,Tipo03B,Tipo04B,tasa,IdEstacion2,Caja2,DAmpliado,Referencia) values ";

        if (trim($data["IdPago"]) == "1") {
            $MontoAPagar = $data["Monto"] / $data['tasa'];
            $Efectivo = $data["Monto"];
            $Contado = $data["Monto"];

            $Credito = 0;
            $it++;
            $statement = $statement . "((SELECT Id FROM PosUpCompany where token='" . $token['Token'] . "'),'" . $datos['Idtipotx'] . "','" . $datos['Idtx'] . "','" . $datos['IdEstacion'] . "','" . $it . "',now(),'" . $datos['Fectxclient'] . "','" . $MontoAPagar . "','" . $Contado . "','" . $Credito . "','" . $Efectivo . "',0,'" . $Tarjeta . "','" . $TarjetaD . "','" . $Cheque . "','" . $ChequeD . "','" . $Tipo01 . "','" . $Tipo01D . "','" . $Tipo02 . "','" . $Tipo02D . "','" . $Tipo03 . "','" . $Tipo03D . "','" . $Tipo04 . "','" . $Tipo04D . "','" . $datos['IdUser'] . "','" . $datos['IdCompanyUser'] . "','" . trim($datos['IdBen']) . "',(SELECT CajaActual FROM PosUpCompanyEstacion where token='" . $datos['IdEstacion'] . "'),'" . $Vencimiento . "','" . $TarjetaB . "','" . $ChequeB . "','" . $Tipo01B . "','" . $Tipo02B . "','" . $Tipo03B . "','" . $Tipo04B . "','" . $data["tasa"] . "','" . $post["IdEstacion2"] . "','" . $post["CajaActual"] . "','" . $post['dampliado'] . "','" . $post['Referencia'] . "')";
            $resultado4 =  mysqli_query($conn, $statement);
            if (!$resultado4) {
                $statamen4 .= " " . $statement;
                $errorMsg = mysqli_error($conn);
                break;
            }
        } else if (trim($data["IdPago"]) == "2") {
            $MontoAPagar = $data["Monto"] / $data['tasa'];
            $Tarjeta = $data["Monto"];
            $TarjetaD = $data["Referencia"];
            $TarjetaB = $data["Banco"];

            $Contado = $data["Monto"];

            $Credito = 0;
            $it++;
            $statement = $statement . "((SELECT Id FROM PosUpCompany where token='" . $token['Token'] . "'),'" . $datos['Idtipotx'] . "','" . $datos['Idtx'] . "','" . $datos['IdEstacion'] . "','" . $it . "',now(),'" . $datos['Fectxclient'] . "','" . $MontoAPagar . "','" . $Contado . "','" . $Credito . "','" . $Efectivo . "',0,'" . $Tarjeta . "','" . $TarjetaD . "','" . $Cheque . "','" . $ChequeD . "','" . $Tipo01 . "','" . $Tipo01D . "','" . $Tipo02 . "','" . $Tipo02D . "','" . $Tipo03 . "','" . $Tipo03D . "','" . $Tipo04 . "','" . $Tipo04D . "','" . $datos['IdUser'] . "','" . $datos['IdCompanyUser'] . "','" . trim($datos['IdBen']) . "',(SELECT CajaActual FROM PosUpCompanyEstacion where token='" . $datos['IdEstacion'] . "'),'" . $Vencimiento . "','" . $TarjetaB . "','" . $ChequeB . "','" . $Tipo01B . "','" . $Tipo02B . "','" . $Tipo03B . "','" . $Tipo04B . "','" . $data["tasa"] . "','" . $post["IdEstacion2"] . "','" . $post["CajaActual"] . "','" . $post['dampliado'] . "','" . $post['Referencia'] . "')";
            $resultado4 =  mysqli_query($conn, $statement);
            if (!$resultado4) {
                $statamen4 .= " " . $statement;
                $errorMsg = mysqli_error($conn);
                break;
            }
        } else if (trim($data["IdPago"]) == "3") {
            $MontoAPagar = $data["Monto"] / $data['tasa'];
            $Cheque = $data["Monto"];
            $ChequeD = $data["Referencia"];
            $ChequeB = $data["Banco"];

            $Contado = $data["Monto"];

            $Credito = 0;
            $it++;
            $statement = $statement . "((SELECT Id FROM PosUpCompany where token='" . $token['Token'] . "'),'" . $datos['Idtipotx'] . "','" . $datos['Idtx'] . "','" . $datos['IdEstacion'] . "','" . $it . "',now(),'" . $datos['Fectxclient'] . "','" . $MontoAPagar . "','" . $Contado . "','" . $Credito . "','" . $Efectivo . "',0,'" . $Tarjeta . "','" . $TarjetaD . "','" . $Cheque . "','" . $ChequeD . "','" . $Tipo01 . "','" . $Tipo01D . "','" . $Tipo02 . "','" . $Tipo02D . "','" . $Tipo03 . "','" . $Tipo03D . "','" . $Tipo04 . "','" . $Tipo04D . "','" . $datos['IdUser'] . "','" . $datos['IdCompanyUser'] . "','" . trim($datos['IdBen']) . "',(SELECT CajaActual FROM PosUpCompanyEstacion where token='" . $datos['IdEstacion'] . "'),'" . $Vencimiento . "','" . $TarjetaB . "','" . $ChequeB . "','" . $Tipo01B . "','" . $Tipo02B . "','" . $Tipo03B . "','" . $Tipo04B . "','" . $data["tasa"] . "','" . $post["IdEstacion2"] . "','" . $post["CajaActual"] . "','" . $post['dampliado'] . "','" . $post['Referencia'] . "')";
            $resultado4 =  mysqli_query($conn, $statement);
            if (!$resultado4) {
                $statamen4 .= " " . $statement;
                $errorMsg = mysqli_error($conn);
                break;
            }
        } else if (trim($data["IdPago"]) == "4") {
            $MontoAPagar = $data["Monto"] / $data['tasa'];
            $Tipo01 = $data["Monto"];
            $Tipo01D = $data["Referencia"];
            $Tipo01B = $data["Banco"];

            $Contado = $data["Monto"];

            $Credito = 0;
            $it++;
            $statement = $statement . "((SELECT Id FROM PosUpCompany where token='" . $token['Token'] . "'),'" . $datos['Idtipotx'] . "','" . $datos['Idtx'] . "','" . $datos['IdEstacion'] . "','" . $it . "',now(),'" . $datos['Fectxclient'] . "','" . $MontoAPagar . "','" . $Contado . "','" . $Credito . "','" . $Efectivo . "',0,'" . $Tarjeta . "','" . $TarjetaD . "','" . $Cheque . "','" . $ChequeD . "','" . $Tipo01 . "','" . $Tipo01D . "','" . $Tipo02 . "','" . $Tipo02D . "','" . $Tipo03 . "','" . $Tipo03D . "','" . $Tipo04 . "','" . $Tipo04D . "','" . $datos['IdUser'] . "','" . $datos['IdCompanyUser'] . "','" . trim($datos['IdBen']) . "',(SELECT CajaActual FROM PosUpCompanyEstacion where token='" . $datos['IdEstacion'] . "'),'" . $Vencimiento . "','" . $TarjetaB . "','" . $ChequeB . "','" . $Tipo01B . "','" . $Tipo02B . "','" . $Tipo03B . "','" . $Tipo04B . "','" . $data["tasa"] . "','" . $post["IdEstacion2"] . "','" . $post["CajaActual"] . "','" . $post['dampliado'] . "','" . $post['Referencia'] . "')";
            $resultado4 =  mysqli_query($conn, $statement);
            if (!$resultado4) {
                $statamen4 .= " " . $statement;
                $errorMsg = mysqli_error($conn);
                break;
            }
        } else if (trim($data["IdPago"]) == "5") {
            $MontoAPagar = $data["Monto"] / $data['tasa'];
            $Tipo02 = $data["Monto"];
            $Tipo02D = $data["Referencia"];
            $Tipo02B = $data["Banco"];

            $Contado = $data["Monto"];

            $Credito = 0;
            $it++;
            $statement = $statement . "((SELECT Id FROM PosUpCompany where token='" . $token['Token'] . "'),'" . $datos['Idtipotx'] . "','" . $datos['Idtx'] . "','" . $datos['IdEstacion'] . "','" . $it . "',now(),'" . $datos['Fectxclient'] . "','" . $MontoAPagar . "','" . $Contado . "','" . $Credito . "','" . $Efectivo . "',0,'" . $Tarjeta . "','" . $TarjetaD . "','" . $Cheque . "','" . $ChequeD . "','" . $Tipo01 . "','" . $Tipo01D . "','" . $Tipo02 . "','" . $Tipo02D . "','" . $Tipo03 . "','" . $Tipo03D . "','" . $Tipo04 . "','" . $Tipo04D . "','" . $datos['IdUser'] . "','" . $datos['IdCompanyUser'] . "','" . trim($datos['IdBen']) . "',(SELECT CajaActual FROM PosUpCompanyEstacion where token='" . $datos['IdEstacion'] . "'),'" . $Vencimiento . "','" . $TarjetaB . "','" . $ChequeB . "','" . $Tipo01B . "','" . $Tipo02B . "','" . $Tipo03B . "','" . $Tipo04B . "','" . $data["tasa"] . "','" . $post["IdEstacion2"] . "','" . $post["CajaActual"] . "','" . $post['dampliado'] . "','" . $post['Referencia'] . "')";
            $resultado4 =  mysqli_query($conn, $statement);
            if (!$resultado4) {
                $statamen4 .= " " . $statement;
                $errorMsg = mysqli_error($conn);
                break;
            }
        } else if (trim($data["IdPago"]) == "6") {
            $MontoAPagar = $data["Monto"] / $data['tasa'];
            $Tipo03 = $data["Monto"];
            $Tipo03D = $data["Referencia"];
            $Tipo03B = $data["Banco"];

            $Contado = $data["Monto"];

            $Credito = 0;
            $it++;
            $statement = $statement . "((SELECT Id FROM PosUpCompany where token='" . $token['Token'] . "'),'" . $datos['Idtipotx'] . "','" . $datos['Idtx'] . "','" . $datos['IdEstacion'] . "','" . $it . "',now(),'" . $datos['Fectxclient'] . "','" . $MontoAPagar . "','" . $Contado . "','" . $Credito . "','" . $Efectivo . "',0,'" . $Tarjeta . "','" . $TarjetaD . "','" . $Cheque . "','" . $ChequeD . "','" . $Tipo01 . "','" . $Tipo01D . "','" . $Tipo02 . "','" . $Tipo02D . "','" . $Tipo03 . "','" . $Tipo03D . "','" . $Tipo04 . "','" . $Tipo04D . "','" . $datos['IdUser'] . "','" . $datos['IdCompanyUser'] . "','" . trim($datos['IdBen']) . "',(SELECT CajaActual FROM PosUpCompanyEstacion where token='" . $datos['IdEstacion'] . "'),'" . $Vencimiento . "','" . $TarjetaB . "','" . $ChequeB . "','" . $Tipo01B . "','" . $Tipo02B . "','" . $Tipo03B . "','" . $Tipo04B . "','" . $data["tasa"] . "','" . $post["IdEstacion2"] . "','" . $post["CajaActual"] . "','" . $post['dampliado'] . "','" . $post['Referencia'] . "')";
            $resultado4 =  mysqli_query($conn, $statement);
            if (!$resultado4) {
                $statamen4 .= " " . $statement;
                $errorMsg = mysqli_error($conn);
                break;
            }
        } else if (trim($data["IdPago"]) == "7") {
            $MontoAPagar = $data["Monto"] / $data['tasa'];
            $Tipo04 = $data["Monto"];
            $Tipo04D = $data["Referencia"];
            $Tipo04B = $data["Banco"];

            $Contado = $data["Monto"];

            $Credito = 0;
            $it++;
            $statement = $statement . "((SELECT Id FROM PosUpCompany where token='" . $token['Token'] . "'),'" . $datos['Idtipotx'] . "','" . $datos['Idtx'] . "','" . $datos['IdEstacion'] . "','" . $it . "',now(),'" . $datos['Fectxclient'] . "','" . $MontoAPagar . "','" . $Contado . "','" . $Credito . "','" . $Efectivo . "',0,'" . $Tarjeta . "','" . $TarjetaD . "','" . $Cheque . "','" . $ChequeD . "','" . $Tipo01 . "','" . $Tipo01D . "','" . $Tipo02 . "','" . $Tipo02D . "','" . $Tipo03 . "','" . $Tipo03D . "','" . $Tipo04 . "','" . $Tipo04D . "','" . $datos['IdUser'] . "','" . $datos['IdCompanyUser'] . "','" . trim($datos['IdBen']) . "',(SELECT CajaActual FROM PosUpCompanyEstacion where token='" . $datos['IdEstacion'] . "'),'" . $Vencimiento . "','" . $TarjetaB . "','" . $ChequeB . "','" . $Tipo01B . "','" . $Tipo02B . "','" . $Tipo03B . "','" . $Tipo04B . "','" . $data["tasa"] . "','" . $post["IdEstacion2"] . "','" . $post["CajaActual"] . "','" . $post['dampliado'] . "','" . $post['Referencia'] . "')";
            $resultado4 =  mysqli_query($conn, $statement);
            if (!$resultado4) {
                $statamen4 .= " " . $statement;
                $errorMsg = mysqli_error($conn);
                break;
            }
        }
    }


    if ($resultado4 === true) {/*
        $query = "SELECT Contado,Credito,tasa FROM PosUpTxC WHERE IdCompany=" . $post["CompanyActual"] . " and Idtx='" . $post['Idtx'] . "' and Idtipotx='" . $post['Idtipotx'] . "' and IdEstacion='" . $post['IdEstacion'] . "'";
        if ($result = mysqli_query($conn, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $tasa = 1;
                if ($row['tasa'] > 1) {
                    $tasa = $row['tasa'];
                }
                $Contadoxd = $row['Contado'] + ($post['MontoPagar'] * $tasa);
                $CreditoDeVerdad2 = $row['Credito'] - ($post['MontoPagar'] * $tasa);
            }
            mysqli_free_result($result);
        }
        $statement2 = "update PosUpTxC set Cobrado='" . $Contadoxd . "',Contado='" . $Contadoxd . "',Credito=" . $CreditoDeVerdad2 . " where IdCompany=" . trim($post["CompanyActual"]) . " and Idtx=" . trim($post["Idtx"]) . " and Idtipotx=" . trim($post["Idtipotx"]) . " and IdEstacion='" . trim($post["IdEstacion"]) . "'";
        $resultado2 =  mysqli_query($conn, $statement2);
        if ($resultado2 === true) {
            return ["status" => true,];
        } else {
            $errorMsg = mysqli_error($conn);
            return ["status" => false, "response" => $statement2, "errorMsg" => $errorMsg];
        }*/
        return ["status" => true,];
    } else {

        return ["status" => false, "response" => $statamen4, "errorMsg" => $errorMsg];
    }
}

function getTableData($conn, $post, $data)
{
    $query = "SELECT coalesce(adev.idBarcode,a.idBarcode) as orrd,if(a.Idtipotx in (27,3),a.IdtxPadre,0) as IdtxAsoc,if(a.Idtipotx in (27,3),a.IdtipotxPadre,0) as IdtipotxAsoc,a.IdEstacion, a.Idtipotx ,a.Idtx as IdtxDef,
	if(a.Idtipotx in (27,3),a.IdEstacionPadre,0) as IdEstacionAsoc,d.Nombre as Usuario,if(Pagos.Caja2<>-1,Pagos.Caja2,Pagos.Caja) as Caja,Pagos.tiporetencion,Pagos.Idtipotx as ElCodi,Pagos.tasa as Tasa2,Pagos.montoretencion as Retencion,Pagos.item,Pagos.Contado*b.Caja as Contado,b.Titulo,Pagos.Credito*b.Caja as Credito ,Pagos.Anticipo*b.Caja as anticipo ,Pagos.Efectivo,Pagos.Tarjeta ,Pagos.Cheque ,Pagos.Tipo01 ,Pagos.Tipo02 ,Pagos.Tipo03 ,Pagos.Tipo04 ,Pagos.Anticipo ,Pagos.TarjetaD ,Pagos.ChequeD ,Pagos.Tipo01D ,Pagos.Tipo02D ,Pagos.Tipo03D ,Pagos.Tipo04D ,Pagos.AnticipoD ,ban.Descrip as TarjetaB ,ban2.Descrip as ChequeB ,ban3.Descrip as Tipo01B ,ban4.Descrip as Tipo02B ,ban5.Descrip as Tipo03B ,ban6.Descrip as Tipo04B ,ban7.Descrip as AnticipoB ,Pagos.Fectxclient as FechaPag,coalesce(bdev.TitCto,b.TitCto) as txOrden,coalesce(if(adev.Referencia='',if (adev.IdTxCompany<>0,adev.IdTxCompany,adev.Idtx),adev.Referencia),if(a.Referencia='',if (a.IdTxCompany<>0,a.IdTxCompany,a.Idtx),a.Referencia)) as IdtxOrden,b.TitCto as Tipo , b.Idtipotx  , if(if(a.Idtipotx in (1,2,3,4,5,6,11,12,13,15,21,22,23,24,25,26,31,35,36,37),company.NumTxViewVTA,if(a.Idtipotx in (7,14,20,27,28),company.NumTxViewCOM,if(a.Idtipotx in (8,9,10,16,17,18,19,29,30,32,33,34,39),company.NumTxViewINV,''))) = 0,a.IdtxCompany,if(if(a.Idtipotx in (1,2,3,4,5,6,11,12,13,15,21,22,23,24,25,26,31,35,36,37),company.NumTxViewVTA,if(a.Idtipotx in (7,14,20,27,28),company.NumTxViewCOM,if(a.Idtipotx in (8,9,10,16,17,18,19,29,30,32,33,34,39),company.NumTxViewINV,''))) = 1,a.Idtx,a.Referencia)) as Idtx, if(a.Referencia='',if (a.DTE=0,if (a.IdTxCompany<>0,'',f.etiqueta),''),'') as Etiqueta,f.etiqueta as etiqueta2,fff.etiqueta as etiqueta3, bdev.TitCto as TipoDev, if(adev.Referencia='',if (adev.DTE=0,if (adev.IdTxCompany<>0,adev.IdTxCompany,adev.Idtx),adev.DTE),adev.Referencia) as Idtxdev, h.Nombre as Ubicacion,a.Fectxclient as Fecha,DATE_FORMAT(Pagos.Fectxclient,'%d/%m/%Y<br>%h:%i:%s %p') AS Fecha2 , coalesce(adev.Fectxclient ,a.Fectxclient) as FectxOrden,a.TxfecVence as Vencimiento, DATEDIFF('" . $post["Fecha"] . " 23:59:59',DATE(coalesce(adev.TxfecVence ,a.TxfecVence))) as Dias_Vencidos,c.Nombre as Beneficiario, a.IdBen as RUT, c.Fono as Telefono ,coalesce(((a.Contado*b.Caja+a.Credito*b.Caja)),0) as Total_Operacion2,Pagos.MontoPagar as Total_Operacion, a.tasa as Tasa , c.Email as Correo, if(a.UserVendedor='0','COMERCIO',e.Nombre) as Vendedor ,count(detalle.idtx) as Detalle,count(Pagos.idtx) as Pagos,a.IdBarcode,company.LitEfectivo,company.LitTarjeta,company.LitCheque,company.LitO01,company.LitO02,company.LitO03,company.LitO04,DATE_FORMAT(a.TxfecVence,'%d/%m/%Y') as TxfecVence
	,a.IdTxCompany, max(Pagos.item) as lastItem 
	from PosUpTxC a 
	left join PosUpCompany company on company.id = a.IdCompany
	left join PosUpTxD detalle on a.IdCompany = detalle.IdCompany and a.IdEstacion = detalle.IdEstacion and a.Idtipotx = detalle.Idtipotx and a.Idtx = detalle.Idtx
	left join PosUpTx b on a.Idtipotx = b.Idtipotx 
	left join PosUpclientes c on a.IdCompany = c.IdCompany and a.IdBen = c.RUT 
	left join PosUpUsers e on a.IdCompany = e.IdCompany and a.UserVendedor = e.Login 
	left join PosUpCompanyEstacion f on a.IdCompany = f.IdCompany and a.IdEstacion = f.token 
	left join PosUpAlmacen g on f.IdCompany = g.IdCompany and f.IdAlmVta = g.IdAlm 
	left join PosUpUbicacion h on h.IdCompany = g.IdCompany and h.IdUbi= g.IdUbi 
	left join PosUpTxC adev on a.IdCompany = adev.IdCompany and a.IdEstacionPadre = adev.IdEstacion and a.IdtipotxPadre = adev.Idtipotx and a.IdtxPadre = adev.Idtx AND adev.Idtipotx IN (1,2,7,15,22,28) 
	left join PosUpTx bdev on adev.Idtipotx = bdev.Idtipotx 
	left join PosUpTx aafectado on a.IdtipotxPadre = aafectado.Idtipotx 
	inner join PosUpTxP Pagos on a.IdCompany = Pagos.IdCompany and a.IdEstacion = Pagos.IdEstacion and a.Idtipotx = Pagos.Idtipotx and a.Idtx = Pagos.Idtx 
	left join PosUpUsers d on Pagos.IdCompany = d.IdCompany and Pagos.Login = d.Login 
	left join PosUpCompanyEstacion fff on Pagos.IdCompany = fff.IdCompany and if(Pagos.Caja2<>-1,Pagos.IdEstacion2,Pagos.IdEstacion)= fff.token 
	left join PosUpBANCuentas  ban on Pagos.IdCompany = ban.IdCompany and Pagos.TarjetaB = ban.Id left join PosUpBANCuentas  ban2 on Pagos.IdCompany = ban2.IdCompany and Pagos.ChequeB = ban2.Id 
	left join PosUpBANCuentas  ban3 on Pagos.IdCompany = ban3.IdCompany and Pagos.Tipo01B = ban3.Id left join PosUpBANCuentas  ban4 on Pagos.IdCompany = ban4.IdCompany and Pagos.Tipo02B = ban4.Id 
	left join PosUpBANCuentas  ban5 on Pagos.IdCompany = ban5.IdCompany and Pagos.Tipo03B = ban5.Id left join PosUpBANCuentas  ban6 on Pagos.IdCompany = ban6.IdCompany and Pagos.Tipo04B = ban6.Id 
	left join PosUpBANCuentas  ban7 on Pagos.IdCompany = ban7.IdCompany and Pagos.AnticipoB = ban7.Id 
	where a.IdCompany = " . trim($post["CompanyActual"]) . " and a.Idben='" . $post['IdBen'] . "' and b.Idtipotx in (1,2,3,4,5,7,15,22,27,28) group by txOrden,IdtxOrden,b.TitCto,Idtx,Item 
    HAVING IdBarcode = " . $data["IdBarcode"] . "
	";

    $array = [
        "Contado" => 0,
        "Credito" => 0,
    ];

    if ($result = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $Contado = 0;
            $Credito = 0;
            $Credito2 = 0;
            $CreditoTxP = 0;
            $ContadoTxP = 0;
            $CreditoTxP2 = 0;
            $ContadoTxP2 = 0;
            $m = 0;
            $query2x = "SELECT a.Total as MontoAPagar,coalesce(bdev.TitCto,b.TitCto) as txOrden,Pagos.tasa as tasap,a.tasa as tasa,a.IdEstacion ,Pagos.montoretencion as Retencion,Pagos.Contado as Contado,Pagos.Credito as Credito ,Pagos.Item, coalesce(if(adev.Referencia='',if (adev.IdTxCompany<>0,adev.IdTxCompany,adev.Idtx),adev.Referencia),if(a.Referencia='',if (a.IdTxCompany<>0,a.IdTxCompany,a.Idtx),a.Referencia)) as IdtxOrden, b.Idtipotx as Idtipotx,a.Idtx
			from PosUpTxC a 
			inner join PosUpTx b on a.Idtipotx = b.Idtipotx 
			inner join PosUpclientes c on a.IdCompany = c.IdCompany and a.IdBen = c.RUT 
			inner join PosUpUsers d on a.IdCompany = d.IdCompany and a.IdUser = d.Login 
			left join PosUpUsers e on a.IdCompany = e.IdCompany and a.UserVendedor = e.Login 
			left join PosUpCompanyEstacion f on a.IdCompany = f.IdCompany and a.IdEstacion = f.token 
			left join PosUpAlmacen g on f.IdCompany = g.IdCompany and f.IdAlmVta = g.IdAlm 
			left join PosUpUbicacion h on h.IdCompany = g.IdCompany and h.IdUbi= g.IdUbi 
			left join PosUpTxC adev on a.IdCompany = adev.IdCompany and a.IdEstacionPadre = adev.IdEstacion and a.IdtipotxPadre = adev.Idtipotx and a.IdtxPadre = adev.Idtx AND adev.Idtipotx IN (1,2,7,15,22,28) 
			left join PosUpTx bdev on adev.Idtipotx = bdev.Idtipotx 
			left join PosUpTx aafectado on a.IdtipotxPadre = aafectado.Idtipotx 
			inner join PosUpTxP Pagos on a.IdCompany = Pagos.IdCompany and a.IdEstacion = Pagos.IdEstacion and a.Idtipotx = Pagos.Idtipotx and a.Idtx = Pagos.Idtx 
			left join PosUpBANCuentas ban on Pagos.IdCompany = ban.IdCompany and Pagos.TarjetaB = ban.Id 
			left join PosUpBANCuentas ban2 on Pagos.IdCompany = ban2.IdCompany and Pagos.ChequeB = ban2.Id 
			left join PosUpBANCuentas ban3 on Pagos.IdCompany = ban3.IdCompany and Pagos.Tipo01B = ban3.Id 
			left join PosUpBANCuentas ban4 on Pagos.IdCompany = ban4.IdCompany and Pagos.Tipo02B = ban4.Id 
			left join PosUpBANCuentas ban5 on Pagos.IdCompany = ban5.IdCompany and Pagos.Tipo03B = ban5.Id 
			left join PosUpBANCuentas ban6 on Pagos.IdCompany = ban6.IdCompany and Pagos.Tipo04B = ban6.Id 
			left join PosUpBANCuentas ban7 on Pagos.IdCompany = ban7.IdCompany and Pagos.AnticipoB = ban7.Id 
			where a.IdCompany = " . trim($post["CompanyActual"]) . " and a.Idben='" . $post['IdBen'] . "' and b.Idtipotx in (1,2,3,4,5,7,15,22,27,28) group by IdtxOrden,txOrden,b.TitCto,Pagos.Item,a.IdBarcode HAVING IdtxOrden='" . $row["IdtxOrden"] . "' and txOrden = '" . $row["txOrden"] . "'  order by IdtxOrden asc";

            if ($result2 = mysqli_query($conn, $query2x)) {
                while ($row2 = mysqli_fetch_assoc($result2)) {
                    $m++;

                    if (($row2["Idtipotx"] === "3") or ($row2["Idtipotx"] === "27")) {
                        $Contado -= (($row2["Retencion"] / $row2["tasap"]) + ($row2["Contado"] / $row2["tasap"])) - ($row2["Credito"] / $row2["tasap"]);
                        $Credito -= ($row2["Credito"] / $row2["tasap"]) - (($row2["Retencion"] / $row2["tasap"]) + ($row2["Contado"] / $row2["tasap"]));
                        $CreditoTxP -= ($row2["Credito"] / $row2["tasap"]);
                        $ContadoTxP -= (($row2["Contado"] / $row2["tasap"]) + ($row2["Retencion"] / $row2["tasap"]));
                        $CreditoTxP2 -= $row2["Credito"];
                        $ContadoTxP2 -= ($row2["Contado"] + $row2["Retencion"]);
                    } else {
                        $Contado += (($row2["Retencion"] / $row2["tasap"]) + ($row2["Contado"] / $row2["tasap"])) - ($row2["Credito"] / $row2["tasap"]);
                        $Credito += ($row2["Credito"] / $row2["tasap"]) - (($row2["Retencion"] / $row2["tasap"]) + ($row2["Contado"] / $row2["tasap"]));
                        $CreditoTxP += ($row2["Credito"] / $row2["tasap"]);
                        $ContadoTxP += (($row2["Contado"] / $row2["tasap"]) + ($row2["Retencion"] / $row2["tasap"]));
                        $CreditoTxP2 += $row2["Credito"];
                        $ContadoTxP2 += $row2["Contado"] + $row2["Retencion"];
                    }
                }
            }

            $Credito2 = $CreditoTxP;
            $Credito2 += ($ContadoTxP * -1);

            if (($Credito2 < 0 ? 0 : ROUND($Credito2, 2)) > 0 || ($Contado < 0 ? 0 : ROUND($Contado, 2)) > 0) {
                if ($row["Idtipotx"] === "2" || $row["Idtipotx"] === "7") {
                    if ($row["item"] <= 1) {
                        if (($Credito2 < 0 ? 0 : ROUND($Credito2, 2)) > 0) {
                            $array = [
                                "Contado" => ROUND($Contado, 2),
                                "Credito" => ROUND($Credito2, 2),
                            ];
                        }
                    }
                } else if (($row["Idtipotx"] <> "3" && $row["Idtipotx"] <> "27") && $row["item"] == 1) {
                    if (($Credito2 < 0 ? 0 : ROUND($Credito2, 2)) > 0) {
                        $array = [
                            "Contado" => ($Contado < 0 ? 0 : ROUND($Contado, 2)),
                            "Credito" => ($Credito2 < 0 ? 0 : ROUND($Credito2, 2)),
                        ];
                    }
                } else if (($row["Idtipotx"] === "3" || $row["Idtipotx"] === "27") && $row["item"] == 1) {
                    if (ROUND($Credito2, 2) < 0) {
                        $array = [
                            "Contado" => ($Credito2 < 0 ? 0 : ROUND($Credito2, 2)),
                            "Credito" => ($Contado < 0 ? 0 : ROUND($Contado, 2)),
                        ];
                    }
                }
            }
        }
    }

    return $array;
}

function SavePagoUnico($conn, $post)
{
    // $data = getTableData($conn, $post);

    $data = $post["data"];
    $token['Token'] = sha1($post['correo']);
    $error = 1;
    $conn->autocommit(false);
    $sumAnticipo = 0;
    if ($data) {
        foreach ($data as $rowData) {
            if ($rowData["anticipo"] === true) {
                $sumAnticipo += $rowData["Debito"];
                continue;
            }
            /*
            $txdata = getTableData($conn, $post, $rowData);
            if ($txdata["Credito"] <= 0) {
                $sumAnticipo += $rowData["Debito"];
                continue;
            }
            */
            if ($rowData["Credito2"] <= 0) {
                $sumAnticipo += $rowData["Debito"];
                continue;
            }

            if (intval($post["FactorCambio"]) == 1) {
                $tasa = $rowData["tasa"];
            } else {
                $tasa = $post["tasa"];
            }

            $MontoPagar = $rowData["Debito"];

            $sqlData = [
                "Vencimiento" => "",
                "MaxItem" => "",
                "Caja" => 0,
            ];

            $query = "SELECT TxfecVence, max(item)+1 as MaxItem,Caja FROM PosUpTxP WHERE IdCompany=" . $post["CompanyActual"] . " and Idtx='" . $rowData['IdtxF'] . "' and Idtipotx='" . $rowData['Idtipotx'] . "' and IdEstacion='" . $rowData['IdEstacion'] . "'";
            if ($result = mysqli_query($conn, $query)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $sqlData = [
                        "Vencimiento" => $row['TxfecVence'],
                        "MaxItem" => $row['MaxItem'],
                        "Caja" => $row['Caja'],
                    ];
                }
                mysqli_free_result($result);
            }

            $ContadoDeVerdad = ($MontoPagar * $tasa);

            $Vuelto = 0;
            $Efectivo = 0;
            $Tarjeta = 0;
            $Cheque = 0;
            $Tipo01 = 0;
            $Tipo02 = 0;
            $Tipo03 = 0;
            $Tipo04 = 0;

            $EfectivoD = "";
            $TarjetaD = "";
            $ChequeD = "";
            $Tipo01D = "";
            $Tipo02D = "";
            $Tipo03D = "";
            $Tipo04D = "";

            $TarjetaB = 0;
            $ChequeB = 0;
            $Tipo01B = 0;
            $Tipo02B = 0;
            $Tipo03B = 0;
            $Tipo04B = 0;

            if (intval($post["TipoPago"]) === 1) {
                $Efectivo = $ContadoDeVerdad;
                $EfectivoD = $post["Referencia"];
            } else if (intval($post["TipoPago"]) === 2) {
                $Tarjeta = $ContadoDeVerdad;
                $TarjetaD = $post["Referencia"];
                $TarjetaB = $post["Banco"];
            } else if (intval($post["TipoPago"]) === 3) {
                $Cheque = $ContadoDeVerdad;
                $ChequeD = $post["Referencia"];
                $ChequeB = $post["Banco"];
            } else if (intval($post["TipoPago"]) === 4) {
                $Tipo01 = $ContadoDeVerdad;
                $Tipo01D = $post["Referencia"];
                if ($tasa > 1) {
                    $Tipo01D = number_format($MontoPagar, $post["CD"], $post["SimDec"], $post["SimMil"]) . "|" . $post["tasaText"] . "|" . number_format($tasa, $post["CD"], $post["SimDec"], $post["SimMil"]);
                }
                $Tipo01B = $post["Banco"];
            } else if (intval($post["TipoPago"]) === 5) {
                $Tipo02 = $ContadoDeVerdad;
                $Tipo02D = $post["Referencia"];
                $Tipo02B = $post["Banco"];
            } else if (intval($post["TipoPago"]) === 6) {
                $Tipo03 = $ContadoDeVerdad;
                $Tipo03D = $post["Referencia"];
                $Tipo03B = $post["Banco"];
            } else if (intval($post["TipoPago"]) === 7) {
                $Tipo04 = $ContadoDeVerdad;
                $Tipo04D = $post["Referencia"];
                $Tipo04B = $post["Banco"];
            }

            $statementI = "insert into PosUpTxP (IdCompany, Idtipotx, Idtx, IdEstacion, Item, Fectxserver, Fectxclient, MontoPagar, Contado, Credito, Efectivo, Vuelto, Tarjeta, TarjetaD, Cheque, ChequeD, Tipo01, Tipo01D, Tipo02, Tipo02D, Tipo03, Tipo03D, Tipo04, Tipo04D,Login, IdcompanyUser, IdResponsable,Caja,TxfecVence,DAmpliado,Referencia,tasa,TarjetaB,ChequeB,Tipo01B,Tipo02B,Tipo03B,Tipo04B,IdEstacion2,Caja2) values ";
            $statement = $statementI . "((SELECT Id FROM PosUpCompany where token='" . $token['Token'] . "'),'" . $rowData['Idtipotx'] . "','" . $rowData['IdtxF'] . "','" . $rowData['IdEstacion'] . "'," . $sqlData["MaxItem"] . ",now(),'" . $post['Fecha'] . "','" . $MontoPagar . "','" . $ContadoDeVerdad . "',0,'" . $Efectivo . "','" . ($Vuelto) . "','" . $Tarjeta . "','" . $TarjetaD . "','" . $Cheque . "','" . $ChequeD . "','" . $Tipo01 . "','" . $Tipo01D . "','" . $Tipo02 . "','" . $Tipo02D . "','" . $Tipo03 . "','" . $Tipo03D . "','" . $Tipo04 . "','" . $Tipo04D . "','" . $post['IdUser'] . "','" . $post['CompanyActual'] . "','" . $post['IdBen'] . "','" . $sqlData["Caja"] . "','" . $sqlData["Vencimiento"] . "','" . $post['dampliado'] . "','" . $EfectivoD . "','" . $tasa . "','" . $TarjetaB . "','" . $ChequeB . "','" . $Tipo01B . "','" . $Tipo02B . "','" . $Tipo03B . "','" . $Tipo04B . "','" . $post["IdEstacion2"] . "','" . $post["CajaActual"] . "')";
            $resultado =  mysqli_query($conn, $statement);
            if (!$resultado) {
                $error = 0;
                break;
            }

            $query = "SELECT Contado,Credito,tasa FROM PosUpTxC WHERE IdCompany=" . $post["CompanyActual"] . " and Idtx='" . $rowData['IdtxF'] . "' and Idtipotx='" . $rowData['Idtipotx'] . "' and IdEstacion='" . $rowData['IdEstacion'] . "'";
            if ($result = mysqli_query($conn, $query)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $tasax = 1;
                    if ($row['tasa'] > 1) {
                        $tasax = $row['tasa'];
                    }
                    $Contadoxd = $row['Contado'] + ($MontoPagar * $tasax);
                    $CreditoDeVerdad2 = $row['Credito'] - ($MontoPagar * $tasax);
                }
                mysqli_free_result($result);
            }

            $statement2 = "update PosUpTxC set Cobrado='" . $Contadoxd . "',Contado='" . $Contadoxd . "',Credito=" . $CreditoDeVerdad2 . " where IdCompany=" . trim($post["CompanyActual"]) . " and Idtx=" . trim($rowData["Idtx"]) . " and Idtipotx=" . trim($rowData["Idtipotx"]) . " and IdEstacion='" . trim($rowData["IdEstacion"]) . "'";
            $resultado2 =  mysqli_query($conn, $statement2);

            if (!$resultado2) {
                $error = 0;
                break;
            }
        }
    }
    if ($error === 0) {
        $connError = $conn->error;
        $conn->rollback();
        return json_encode([
            "status" => false,
            "msg" => $connError,
        ], JSON_UNESCAPED_UNICODE);
    }

    if (intval($post["FactorCambio"]) === 1) {
        $tasa = $post["FactorDolarCash"];
    }

    if ($sumAnticipo > 0) {
        $ttx = "numanticipo";
        $MontoPagar = $sumAnticipo;
        $ContadoDeVerdad = ($MontoPagar * $tasa);
        $Vuelto = 0;
        $Efectivo = 0;
        $Tarjeta = 0;
        $Cheque = 0;
        $Tipo01 = 0;
        $Tipo02 = 0;
        $Tipo03 = 0;
        $Tipo04 = 0;

        $EfectivoD = "";
        $TarjetaD = "";
        $ChequeD = "";
        $Tipo01D = "";
        $Tipo02D = "";
        $Tipo03D = "";
        $Tipo04D = "";

        $TarjetaB = 0;
        $ChequeB = 0;
        $Tipo01B = 0;
        $Tipo02B = 0;
        $Tipo03B = 0;
        $Tipo04B = 0;

        if (intval($post["TipoPagoPagoUnico"]) === 1) {
            $Efectivo = $ContadoDeVerdad;
            $EfectivoD = $post["Referencia"];
        } else if (intval($post["TipoPagoPagoUnico"]) === 2) {
            $Tarjeta = $ContadoDeVerdad;
            $TarjetaD = $post["Referencia"];
            $TarjetaB = $post["Banco"];
        } else if (intval($post["TipoPagoPagoUnico"]) === 3) {
            $Cheque = $ContadoDeVerdad;
            $ChequeD = $post["Referencia"];
            $ChequeB = $post["Banco"];
        } else if (intval($post["TipoPagoPagoUnico"]) === 4) {
            $Tipo01 = $ContadoDeVerdad;
            $Tipo01D = $post["Referencia"];
            if ($tasa > 1) {
                $Tipo01D = number_format($MontoPagar, $post["CD"], $post["SimDec"], $post["SimMil"]) . "|" . $post["tasaText"] . "|" . number_format($tasa, $post["CD"], $post["SimDec"], $post["SimMil"]);
            }
            $Tipo01B = $post["Banco"];
        } else if (intval($post["TipoPagoPagoUnico"]) === 5) {
            $Tipo02 = $ContadoDeVerdad;
            $Tipo02D = $post["Referencia"];
            $Tipo02B = $post["Banco"];
        } else if (intval($post["TipoPagoPagoUnico"]) === 6) {
            $Tipo03 = $ContadoDeVerdad;
            $Tipo03D = $post["Referencia"];
            $Tipo03B = $post["Banco"];
        } else if (intval($post["TipoPagoPagoUnico"]) === 7) {
            $Tipo04 = $ContadoDeVerdad;
            $Tipo04D = $post["Referencia"];
            $Tipo04B = $post["Banco"];
        }

        $statementI = "insert into PosUpTxP (IdCompany, Idtipotx, Idtx, IdEstacion, Item, Fectxserver, Fectxclient, MontoPagar, Contado, Credito, Efectivo, Vuelto, Tarjeta, TarjetaD, Cheque, ChequeD, Tipo01, Tipo01D, Tipo02, Tipo02D, Tipo03, Tipo03D, Tipo04, Tipo04D,Login, IdcompanyUser, IdResponsable,Caja,TxfecVence,DAmpliado,Referencia,tasa,TarjetaB,ChequeB,Tipo01B,Tipo02B,Tipo03B,Tipo04B) values ";
        $statement = $statementI . "((SELECT Id FROM PosUpCompany where token='" . $token['Token'] . "'),'25',(SELECT " . $ttx . "+1 FROM PosUpCompanyEstacion where token='" . $post["IdEstacion2"] . "'),'" . $post["IdEstacion2"] . "',1,now(),'" . $post['Fecha'] . "','0','" . $ContadoDeVerdad . "',0,'" . $Efectivo . "',0,'" . $Tarjeta . "','" . $TarjetaD . "','" . $Cheque . "','" . $ChequeD . "','" . $Tipo01 . "','" . $Tipo01D . "','" . $Tipo02 . "','" . $Tipo02D . "','" . $Tipo03 . "','" . $Tipo03D . "','" . $Tipo04 . "','" . $Tipo04D . "','" . $post['IdUser'] . "','" . $post['CompanyActual'] . "','" . $post['IdBen'] . "',(SELECT CajaActual FROM PosUpCompanyEstacion where token='" . $post["IdEstacion2"] . "'),'" . $post['Fecha'] . "','" . $post['dampliado'] . "','" . $EfectivoD . "','" . $tasa . "','" . $TarjetaB . "','" . $ChequeB . "','" . $Tipo01B . "','" . $Tipo02B . "','" . $Tipo03B . "','" . $Tipo04B . "')";
        $resultado =  mysqli_query($conn, $statement);
        if (!$resultado) {
            $connError = $conn->error;
            $conn->rollback();
            return json_encode([
                "status" => false,
                "msg" => $connError,
            ], JSON_UNESCAPED_UNICODE);
        }
        $statement2 = "insert into PosUpTxC (IdCompany, Idtipotx, Idtx, Fectxserver, Fectxclient,  IdUser, IdUserAutDcto, SubTotal, Dcto, Total, Costo, Margen, DctoAplicado, MargenDcto, Items, IdEstacion, Contado, Credito, Cobrado,IdCompanyUserAutDcto, IdCompanyUser,IdtipotxPadre, IdtxPadre, IdEstacionPadre,IdAlmO,IdAlmD,motivo,DAmpliado,IdBen,Referencia,excento,imponible,impuesto,totalimp,numctrol,TxfecVence,tasa) values ((SELECT Id FROM PosUpCompany where token='" . $token['Token'] . "'),'25',(SELECT " . $ttx . "+1 FROM PosUpCompanyEstacion where token='" . $post["IdEstacion2"] . "'),now(),'" . $post['Fecha'] . "','" . $post['IdUser'] . "','0','" . $ContadoDeVerdad . "','0','" . $ContadoDeVerdad . "','0','0','0','0','','" . $post["IdEstacion2"] . "','" . $ContadoDeVerdad . "','0','0','0','" . $post['CompanyActual'] . "','0','0','0','0','0','0','" . $post['dampliado'] . "','" . $post['IdBen'] . "','" . $post['Referencia'] . "','0','0','0','0','0','" . $post['Fecha'] . "','" . $tasa . "')";
        $resultado1 =  mysqli_query($conn, $statement2);
        if (!$resultado1) {
            $connError = $conn->error;
            $conn->rollback();
            return json_encode([
                "status" => false,
                "msg" => $connError,
            ], JSON_UNESCAPED_UNICODE);
        }
        $statement3 = "update PosUpCompanyEstacion set " . $ttx . "=" . $ttx . "+1 where token='" . $post["IdEstacion2"] . "'";
        $resultado2 = mysqli_query($conn, $statement3);
        if (!$resultado2) {
            $connError = $conn->error;
            $conn->rollback();
            return json_encode([
                "status" => false,
                "msg" => $connError,
            ], JSON_UNESCAPED_UNICODE);
        }
    }

    $conn->commit();
    return json_encode([
        "status" => true,
        "msg" => "",
    ], JSON_UNESCAPED_UNICODE);
}

function TransactionAnticipo($conn, $post, $token)
{
    $sql = "
        SELECT 
            a.TxfecVence,
            COALESCE(MAX(a.item), 0) + 1 AS item
        FROM PosUpTxP a
        WHERE a.IdCompany = ? 
          AND a.Idtx = ? 
          AND a.Idtipotx = ? 
          AND a.IdEstacion = ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $post["CompanyActual"], $post["Idtx"], $post["Idtipotx"], $post["IdEstacion"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    $Vencimiento = $data["TxfecVence"] ?? null;
    $item = $data["item"] ?? 1;
    $stmt->close();

    $sql = "
        SELECT 
            b.IdBarcode
        FROM PosUpTxP a
        LEFT JOIN PosUpTxC b 
            ON b.IdCompany = a.IdCompany 
            AND a.Idtipotx = b.Idtipotx 
            AND a.Idtx = b.Idtx 
            AND a.IdEstacion = b.IdEstacion
        WHERE a.IdCompany = ? 
          AND a.Idtx = ? 
          AND a.Idtipotx = ? 
          AND a.IdEstacion = ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $post["CompanyActual"], $post["Idtx2"], $post["Idtipotx2"], $post["IdEstacion3"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    $IdBarcode = $data["IdBarcode"] ?? null;
    $stmt->close();

    $statementI = "insert into PosUpTxP (IdCompany, Idtipotx, Idtx, IdEstacion, Item, Fectxserver, Fectxclient, MontoPagar, Contado, Credito, Efectivo, Vuelto, Tarjeta, TarjetaD, Cheque, ChequeD, Tipo01, Tipo01D, Tipo02, Tipo02D, Tipo03, Tipo03D, Tipo04, Tipo04D,Login, IdcompanyUser, IdResponsable,Caja,TxfecVence,DAmpliado,Referencia,tasa,TarjetaB,ChequeB,Tipo01B,Tipo02B,Tipo03B,Tipo04B,Anticipo,AnticipoD,AnticipoB,IdEstacion2,Caja2, EfectivoD) values ";
    $statement = $statementI . "((SELECT Id FROM PosUpCompany where token='" . $token['Token'] . "'),'" . $post['Idtipotx'] . "','" . $post['Idtx'] . "','" . $post['IdEstacion'] . "'," . $item . ",now(),'" . $post['Fectxclient2'] . "','" . $post['MontoPagar'] . "','" . $post['Anticipos'] . "','0','0','0','0','','0','','0','','0','','0','','0','','" . $post['IdUser'] . "','" . $post['IdCompanyUser'] . "','" . $post['IdBen'] . "',(SELECT CajaActual FROM PosUpCompanyEstacion where token='" . $post['IdEstacion'] . "'),'" . $Vencimiento . "','" . $post['dampliado'] . "','" . $post['Referencia'] . "','" . $post['FactorDCambio'] . "','" . $post['TarjetaB'] . "','" . $post['ChequeB'] . "','" . $post['Tipo01B'] . "','" . $post['Tipo02B'] . "','" . $post['Tipo03B'] . "','" . $post['Tipo04B'] . "','" . $post['Anticipos'] . "','" . $post['AnticiposRefe'] . "','" . $post['AnticiposBanco'] . "','" . $post["IdEstacion2"] . "','" . $post["CajaActual"] . "',
        $IdBarcode)";
    $resultado =  mysqli_query($conn, $statement);
    if (!$resultado) {
        return 0;
    }
    // 4️⃣ Recalcular montos y actualizar tablas
    $sqlMonto = "
        SELECT MontoPagar, tasa 
        FROM PosUpTxP 
        WHERE IdCompany = ? AND Idtx = ? AND Idtipotx = ? AND IdEstacion = ?
    ";
    $stmt = $conn->prepare($sqlMonto);
    $stmt->bind_param("isss", $post["CompanyActual"], $post["Idtx2"], $post["Idtipotx2"], $post["IdEstacion3"]);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    $MontoPagarExistente = $res["MontoPagar"] ?? 0;
    $tasaAnti = $res["tasa"] ?? 1;

    $Antip = ($post["Anticipos"] / $post["FactorDCambio"]);

    $MontoPagar = abs($MontoPagarExistente) + abs($Antip * $tasaAnti);

    if ($post["Idtipotx"] == 7) $MontoPagar = $MontoPagar * -1;

    // 5️⃣ Actualizar PosUpTxC
    $sqlContado = "
        SELECT Contado, Credito FROM PosUpTxC 
        WHERE IdCompany = ? AND Idtx = ? AND Idtipotx = ? AND IdEstacion = ?
    ";
    $stmt = $conn->prepare($sqlContado);
    $stmt->bind_param("isss", $post["CompanyActual"], $post["Idtx"], $post["Idtipotx"], $post["IdEstacion"]);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    // Actualizaciones encadenadas
    $updates = [
        "UPDATE PosUpTxC SET Cobrado=?, Contado=?, Credito=? WHERE IdCompany=? AND Idtx=? AND Idtipotx=? AND IdEstacion=?" => [
            ($res["Contado"] ?? 0) + $post["Contado"],
            ($res["Contado"] ?? 0) + $post["Contado"],
            ($res["Credito"] ?? 0) - $post["Contado"],
            $post["CompanyActual"],
            $post["Idtx"],
            $post["Idtipotx"],
            $post["IdEstacion"]
        ],
        "UPDATE PosUpTxP SET MontoPagar=? WHERE IdCompany=? AND Idtx=? AND Idtipotx=? AND IdEstacion=?" => [
            $MontoPagar,
            $post["CompanyActual"],
            $post["Idtx2"],
            $post["Idtipotx2"],
            $post["IdEstacion3"]
        ],
        "UPDATE PosUpTxC SET Cobrado=? WHERE IdCompany=? AND Idtx=? AND Idtipotx=? AND IdEstacion=?" => [
            $MontoPagar,
            $post["CompanyActual"],
            $post["Idtx2"],
            $post["Idtipotx2"],
            $post["IdEstacion3"]
        ]
    ];

    foreach ($updates as $query => $params) {
        $stmt = $conn->prepare($query);
        $stmt->bind_param(str_repeat("s", count($params)), ...$params);
        if (!$stmt->execute()) {
            return 0;
        }
        $stmt->close();
    }

    return 1;
}
