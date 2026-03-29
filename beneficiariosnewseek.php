<?php

// --- NUEVO: VERIFICAR SI EL BENEFICIARIO YA EXISTE ---
if (isset($_POST["Accion"]) && $_POST["Accion"] === "VerificarRUT") {
    include "ambienteconsultas.php";
    $conn = conectar();
    
    $rut = mysqli_real_escape_string($conn, trim($_POST['RUT']));
    $company = (int)$_POST['CompanyActual'];

    $sql = "SELECT Nombre FROM PosUpclientes WHERE IdCompany = $company AND RUT = '$rut' LIMIT 1";
    $res = mysqli_query($conn, $sql);
    
    if ($res && $row = mysqli_fetch_assoc($res)) {
        echo json_encode(["existe" => true, "nombre" => $row['Nombre']]);
    } else {
        echo json_encode(["existe" => false]);
    }
    exit;
}
// -----------------------------------------------------

if (isset($_POST["Accion"]) && $_POST["Accion"] == "0") {
    include "ambienteconsultas.php";
    $conn = conectar();
    $request = $_REQUEST;
    $col = array(
        0   =>  'RUT',
        1   =>  'CodIntDeudor',
        2   =>  'Nombre',
        3   =>  'Fono',
        4   =>  'Estado',
        5   =>  'EsCliente',
        6   =>  'EsProveedor',
        7   =>  'EsOtro'
    );
    $sql = "SELECT * FROM PosUpclientes where IdCompany='" . $_POST["CompanyActual"] . "' ";
    $query = mysqli_query($conn, $sql);
    $totalFilter = mysqli_num_rows($query);
    if (!empty($request['search']['value'])) {
        $sql .= " AND concat(COALESCE(RUT,''),COALESCE(CodIntDeudor,''),COALESCE(codBarra,''),COALESCE(Nombre,'')) like '%" . $request['search']['value'] . "%' ";
    }
    $query = mysqli_query($conn, $sql);
    $totalData = mysqli_num_rows($query);
    if ($col[$request['order'][0]['column']] && $request['order'][0]['dir']) {
        $sql .= " ORDER BY " . $col[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'] . "";
    }

    $sql .= " LIMIT " . $request['start'] . "  ," . $request['length'] . "  ";
    $query = mysqli_query($conn, $sql);
    $data = array();
    $n = 0;
    while ($row = mysqli_fetch_array($query)) {
        $subdata = array();
        $n++;
        $informacion = "";
        $informacion .= "<span id='rissf" . $n . "' style='display:none;'>" . trim($row['RUT']) . "</span>";
        $informacion .= "<span id='cidss" . $n . "' style='display:none;'>" . trim($row['CodIntDeudor']) . "</span>";
        $informacion .= "<span id='nossm" . $n . "' style='display:none;'>" . trim($row['Nombre']) . "</span>";
        $informacion .= "<span id='tesslf" . $n . "' style='display:none;'>" . trim($row['Fono']) . "</span>";
        $informacion .= "<span id='rif" . $n . "' style='display:none;'>" . trim($row['RUT']) . "</span>";
        $informacion .= "<span id='cid" . $n . "' style='display:none;'>" . trim($row['CodIntDeudor']) . "</span>";
        $informacion .= "<span id='codb" . $n . "' style='display:none;'>" . trim($row['codBarra']) . "</span>";
        $informacion .= "<span id='nom" . $n . "' style='display:none;'>" . trim($row['Nombre']) . "</span>";
        $informacion .= "<span id='telf" . $n . "' style='display:none;'>" . trim($row['Fono']) . "</span>";
        $informacion .= "<span id='dir" . $n . "' style='display:none;'>" . trim($row['Direccion']) . "</span>";
        $informacion .= "<span id='tipoc" . $n . "' style='display:none;'>" . trim($row['TipoCredito']) . "</span>";
        $informacion .= "<span id='edoc" . $n . "' style='display:none;'>" . trim($row['EstadoCredito']) . "</span>";
        $informacion .= "<span id='deudamb" . $n . "' style='display:none;'>" . trim($row['DeudaMaxBoleta']) . "</span>";
        $informacion .= "<span id='deudaml" . $n . "' style='display:none;'>" . trim($row['DeudaMaxLibreta']) . "</span>";
        $informacion .= "<span id='fechap1" . $n . "' style='display:none;'>" . trim($row['FechPago1']) . "</span>";
        $informacion .= "<span id='fechap2" . $n . "' style='display:none;'>" . trim($row['FechPago2']) . "</span>";
        $informacion .= "<span id='nroc" . $n . "' style='display:none;'>" . trim($row['NroCorr']) . "</span>";
        $informacion .= "<span id='com" . $n . "' style='display:none;'>" . trim($row['Comuna']) . "</span>";
        $informacion .= "<span id='giro" . $n . "' style='display:none;'>" . trim($row['Giro']) . "</span>";
        $informacion .= "<span id='credf" . $n . "' style='display:none;'>" . trim($row['CreditoFactura']) . "</span>";
        $informacion .= "<span id='credu" . $n . "' style='display:none;'>" . trim($row['CreditoUsado']) . "</span>";
        $informacion .= "<span id='edo" . $n . "' style='display:none;'>" . trim($row['Estado']) . "</span>";
        $informacion .= "<span id='provinciaS" . $n . "' style='display:none;'>" . trim($row['provincia']) . "</span>";
        $informacion .= "<span id='lat" . $n . "' style='display:none;'>" . trim($row['Latitud']) . "</span>";
        $informacion .= "<span id='lon" . $n . "' style='display:none;'>" . trim($row['Longitud']) . "</span>";
        $informacion .= "<span id='regionS" . $n . "' style='display:none;'>" . trim($row['region']) . "</span>";
        $informacion .= "<span id='ciudadxd" . $n . "' style='display:none;'>" . trim($row['ciudad']) . "</span>";
        $informacion .= "<span id='email" . $n . "' style='display:none;'>" . trim($row['email']) . "</span>";
        $informacion .= "<span id='cli" . $n . "' style='display:none;'>" . trim($row['EsCliente']) . "</span>";
        $informacion .= "<span id='prov" . $n . "' style='display:none;'>" . trim($row['EsProveedor']) . "</span>";
        $informacion .= "<span id='trab" . $n . "' style='display:none;'>" . trim($row['EsTrabajador']) . "</span>";
        $informacion .= "<span id='otro" . $n . "' style='display:none;'>" . trim($row['EsOtro']) . "</span>";
        $informacion .= "<span id='esservidor" . $n . "' style='display:none;'>" . trim($row['esservidor']) . "</span>";
        $informacion .= "<span id='TipoBenef" . $n . "' style='display:none;'>" . trim($row['TipoBenef']) . "</span>";
        $informacion .= "<span id='TipoPersona" . $n . "' style='display:none;'>" . trim((isset($row['TipoPersona']) && $row['TipoPersona'] !== null && $row['TipoPersona'] !== '') ? $row['TipoPersona'] : 'PN') . "</span>";
        $informacion .= "<span id='Domicilio" . $n . "' style='display:none;'>" . trim((isset($row['Domicilio']) && $row['Domicilio'] !== null && $row['Domicilio'] !== '') ? $row['Domicilio'] : 'DOM') . "</span>";
        $informacion .= "<span id='TipoContribuyente" . $n . "' style='display:none;'>" . trim((isset($row['TipoContribuyente']) && $row['TipoContribuyente'] !== null && $row['TipoContribuyente'] !== '') ? $row['TipoContribuyente'] : 'ORDINARIO') . "</span>";

        $buttones = "";
        $buttones .= "<button class='btn btn-outline-primary p-1 m-1' type='button' onclick='recibir(" . $n . ");'><span class='fa fa-edit'></span></button>";
        if ($_POST["userperfil"] <= 2000 or $_POST["userperfil"] == "2055" or $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") {
            $buttones .= "<button class='btn btn-outline-danger p-1 m-1' type='button' onclick='alertaborrar(" . $n . ");'><span class='fa fa-trash'></span></button>";
        }

        $subdata[] = "<strong>" . trim($row['RUT']) . "</strong><br>" . trim($row['Nombre']) . "<br>" . trim($row['Fono']) . "<br>" . $buttones . $informacion;
        $subdata[] = (($row['Estado'] == 0) ? "<i class='fa fa-toggle-off'></i>" : "<i class='fa fa-toggle-on'></i>");
        $subdata[] = (($row['EsCliente'] == 0) ? "<i class='fa fa-toggle-off'></i>" : "<i class='fa fa-toggle-on'></i>");
        $subdata[] = (($row['EsProveedor'] == 0) ? "<i class='fa fa-toggle-off'></i>" : "<i class='fa fa-toggle-on'></i>");
        $subdata[] = (($row['EsTrabajador'] == 0) ? "<i class='fa fa-toggle-off'></i>" : "<i class='fa fa-toggle-on'></i>");
        $subdata[] = (($row['EsOtro'] == 0) ? "<i class='fa fa-toggle-off'></i>" : "<i class='fa fa-toggle-on'></i>");
        $data[] = $subdata;
    }

    $json_data = array(
        "draw"              =>  intval($request['draw']),
        "recordsTotal"      =>  intval($totalFilter),
        "recordsFiltered"   =>  intval($totalData),
        "data"              =>  $data
    );

    echo json_encode($json_data);
    exit;
}

if (isset($_POST["Accion"]) && $_POST["Accion"] == "2") {
    include "ambienteconsultas.php";
    $conn = conectar();
    $Pais = trim($_POST['IdPais']);

    $request = $_REQUEST;
    $col = array(
        0   =>  'a.comuna_nombre',
        1   =>  'a.comuna_nombre',
    );

    $sql = "SELECT a.comuna_nombre,a.comuna_id,a.PaisId,a.provincia_id,b.provincia_nombre,c.region_nombre FROM PosUpGeoComunas a inner join PosUpGeoProvincias b on b.provincia_id=a.provincia_id and a.PaisId=b.PaisId inner join PosUpGeoRegion c on c.region_id=b.region_id and a.PaisId=c.PaisId where a.PaisId='" . $Pais . "'";
    $query = mysqli_query($conn, $sql);
    $totalData = mysqli_num_rows($query);

    if (!empty($request['search']['value'])) {
        $sql .= " AND concat(a.comuna_nombre) like '%" . $request['search']['value'] . "%' ";
    }
    $query = mysqli_query($conn, $sql);
    $totalFilter = mysqli_num_rows($query);

    if ($col[$request['order'][0]['column']] && $request['order'][0]['dir']) {
        $sql .= " ORDER BY " . $col[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'] . "";
    }

    $sql .= " LIMIT " . $request['start'] . "  ," . $request['length'] . "  ";
    $query = mysqli_query($conn, $sql);

    $data = array();
    $n = 0;
    while ($row = mysqli_fetch_array($query)) {
        $subdata = array();
        $n++;
        $informacion = "";
        $informacion .= "<span id='comunaid" . $n . "' style='display:none;'>" . trim($row['comuna_id']) . "</span>";
        $informacion .= "<span id='comuna_nombre" . $n . "' style='display:none;'>" . trim($row['comuna_nombre']) . "</span>";
        $informacion .= "<span id='provincia_id" . $n . "' style='display:none;'>" . trim($row['provincia_id']) . "</span>";
        $informacion .= "<span id='provincia_nombre" . $n . "' style='display:none;'>" . trim($row['provincia_nombre']) . "</span>";
        $informacion .= "<span id='paisid" . $n . "' style='display:none;'>" . trim($row['PaisId']) . "</span>";
        $informacion .= "<span id='region" . $n . "' style='display:none;'>" . trim($row['region_nombre']) . "</span>";
        $buttones = "";
        $buttones .= "<button class='btn btn-outline-dark p-1 m-1' type='button' onclick='enviar3(" . $n . ");'><span class='fa fa-check-circle'></span> " . lang("Usar") . "</button>";

        $subdata[] = trim($row['comuna_nombre']) . $informacion;
        $subdata[] = $buttones;
        $data[] = $subdata;
    }

    $json_data = array(
        "draw"              =>  intval($request['draw']),
        "recordsTotal"      =>  intval($totalData),
        "recordsFiltered"   =>  intval($totalFilter),
        "data"              =>  $data
    );

    echo json_encode($json_data);
    exit;
}

if (isset($_POST["tabla"]) && $_POST["tabla"] == "beneficiarios") {
    include "ambiente.php";
    $conn = conectar();
    $connsultas = ConectarConsultas();
    
    if (!isset($_POST["borrar"])) {
        $latitud = trim($_POST["latitud"]);
        $longitud = trim($_POST["longitud"]);
        $query = "SELECT IdPais FROM PosUpCompany WHERE Id=" . $_POST["companyUser"] . "";
        $IdPais = '';
        if ($result = mysqli_query($connsultas, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $IdPais = $row['IdPais'];
            }
            mysqli_free_result($result);
        }
        $Comuna = '';
        $Region = '';
        $Provincia = '';

        $Region = trim($_POST['ModalReg']);
        $TipoBeneficiario = trim($_POST['TipoBeneficiario']);
        $Provincia = trim($_POST['ModalPro']);
        $Comuna = trim($_POST['ModalCom']);

        // Se usa isset() para evitar warnings en checkboxes si no vienen en el POST
        $a = (isset($_POST["ModalEdoc"]) && $_POST["ModalEdoc"] == "on") ? "1" : "0";
        $b = (isset($_POST["ModalEdo"]) && $_POST["ModalEdo"] == "on") ? "1" : "0";
        $c = (isset($_POST["ModalCli"]) && $_POST["ModalCli"] == "on") ? "1" : "0";
        $d = (isset($_POST["ModalProv"]) && $_POST["ModalProv"] == "on") ? "1" : "0";
        $e = (isset($_POST["ModalTrab"]) && $_POST["ModalTrab"] == "on") ? "1" : "0";
        $f = (isset($_POST["ModalOtro"]) && $_POST["ModalOtro"] == "on") ? "1" : "0";
        $ModalServicio = (isset($_POST["ModalServicio"]) && $_POST["ModalServicio"] == "on") ? "1" : "0";
        
        $si = 0;
        
        if ($_POST["new"] === "0") {
            if ($IdPais == 'CL') {
                $sql = "select count(IdCompany) as Cantidad from PosUpclientes where IdCompany =" . $_POST["companyUser"] . " and RUT = '" . trim($_POST["ModalRut"]) . "-" . trim($_POST["ModalRut2"]) . "'";
            } else {
                $sql = "select count(IdCompany) as Cantidad from PosUpclientes where IdCompany =" . $_POST["companyUser"] . " and RUT = '" . trim($_POST["ModalRif"]) . "'";
            }
            $can = 0;
            if ($result = mysqli_query($connsultas, $sql)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $can = $row["Cantidad"];
                }
            }
            if ($can > 0) {
                echo "3";
                $si = 1;
            }
            
            if ($si == 0) {
                $ModalRif = mysqli_real_escape_string($conn, $_POST["ModalRif"]);
                $ModalCid = mysqli_real_escape_string($conn, $_POST["ModalCid"]);
                $ModalCodb = mysqli_real_escape_string($conn, $_POST["ModalCodb"]);
                $ModalNombre = mysqli_real_escape_string($conn, substr(trim($_POST["ModalNombre"]), 0, 50));
                $ModalTelf = mysqli_real_escape_string($conn, $_POST["ModalTelf"]);
                $ModalDir = mysqli_real_escape_string($conn, $_POST["ModalDir"]);
                $ModalTipoc = mysqli_real_escape_string($conn, $_POST["ModalTipoc"]);
                $ModalGiro = mysqli_real_escape_string($conn, $_POST["ModalGiro"]);
                $ModalEmailCorreo = mysqli_real_escape_string($conn, $_POST["ModalEmailCorreo"]);
                $ModalCiudad = mysqli_real_escape_string($conn, $_POST["ModalCiudad"]);
                
                // NUEVAS VARIABLES AL INSERTAR
                $TipoPersona = isset($_POST["TipoPersona"]) ? mysqli_real_escape_string($conn, $_POST["TipoPersona"]) : 'PN';
                $Domicilio = isset($_POST["Domicilio"]) ? mysqli_real_escape_string($conn, $_POST["Domicilio"]) : 'DOM';

                if ($IdPais == 'CL') {
                    $sql = "insert into PosUpclientes (IdCompany,RUT,CodIntDeudor,codBarra,Nombre,Fono,Direccion,TipoCredito,EstadoCredito,DeudaMaxBoleta,DeudaMaxLibreta,FechPago1,FechPago2,NroCorr,Comuna,Giro,CreditoFactura,CreditoUsado,Estado,EsCliente,EsProveedor,EsTrabajador,EsOtro,email,provincia,region,ciudad,Latitud,Longitud, TipoBenef, esservidor, TipoPersona, Domicilio) values(" . $_POST["companyUser"] . ",'" . trim($_POST["ModalRut"]) . "-" . strtoupper(trim($_POST["ModalRut2"])) . "','" . trim($ModalCid) . "','" . trim($ModalCodb) . "','" . trim($ModalNombre) . "','" . trim($ModalTelf) . "','" . trim($ModalDir) . "','" . trim($ModalTipoc) . "','" . $a . "',0,0,0,0,0,'" . $Comuna . "','" . trim($ModalGiro) . "',0,0,'" . $b . "','" . $c . "','" . $d . "','" . $e . "','" . $f . "','" . trim($ModalEmailCorreo) . "','" . trim($Provincia) . "','" . trim($Region) . "','" . trim($ModalCiudad) . "','" . $latitud . "','" . $longitud . "','" . $_POST["TipoBeneficiario"] . "','" . $ModalServicio . "','" . $TipoPersona . "','" . $Domicilio . "')";
                } else {
                    $sql = "insert into PosUpclientes (IdCompany,RUT,CodIntDeudor,codBarra,Nombre,Fono,Direccion,TipoCredito,EstadoCredito,DeudaMaxBoleta,DeudaMaxLibreta,FechPago1,FechPago2,NroCorr,Comuna,Giro,CreditoFactura,CreditoUsado,Estado,EsCliente,EsProveedor,EsTrabajador,EsOtro,email,provincia,region,ciudad,Latitud,Longitud, TipoBenef, esservidor, TipoPersona, Domicilio) values(" . $_POST["companyUser"] . ",'" . trim($ModalRif) . "','" . trim($ModalCid) . "','" . trim($ModalCodb) . "','" . trim($ModalNombre) . "','" . trim($ModalTelf) . "','" . trim($ModalDir) . "','" . trim($ModalTipoc) . "','" . $a . "',0,0,0,0,0,'" . $Comuna . "','" . trim($ModalGiro) . "',0,0,'" . $b . "','" . $c . "','" . $d . "','" . $e . "','" . $f . "','" . trim($ModalEmailCorreo) . "','" . trim($Provincia) . "','" . trim($Region) . "','" . trim($ModalCiudad) . "','" . $latitud . "','" . $longitud . "','" . $_POST["TipoBeneficiario"] . "','" . $ModalServicio . "','" . $TipoPersona . "','" . $Domicilio . "')";
                }
                $stmt = mysqli_query($conn, $sql);
                if ($stmt === true) {
                    echo "1";
                } else {
                    echo "0";
                }
            }
        }

        if ($_POST["new"] === "1") {
            $ModalCid = mysqli_real_escape_string($conn, $_POST["ModalCid"]);
            $ModalCodb = mysqli_real_escape_string($conn, $_POST["ModalCodb"]);
            $ModalNombre = mysqli_real_escape_string($conn, $_POST["ModalNombre"]);
            $ModalTelf = mysqli_real_escape_string($conn, $_POST["ModalTelf"]);
            $ModalDir = mysqli_real_escape_string($conn, $_POST["ModalDir"]);
            $ModalTipoc = mysqli_real_escape_string($conn, $_POST["ModalTipoc"]);
            $ModalGiro = mysqli_real_escape_string($conn, $_POST["ModalGiro"]);
            $ModalEmailCorreo = mysqli_real_escape_string($conn, $_POST["ModalEmailCorreo"]);
            $ModalCiudad = mysqli_real_escape_string($conn, $_POST["ModalCiudad"]);
            
            // NUEVAS VARIABLES AL ACTUALIZAR
            $TipoPersona = isset($_POST["TipoPersona"]) ? mysqli_real_escape_string($conn, $_POST["TipoPersona"]) : 'PN';
            $Domicilio = isset($_POST["Domicilio"]) ? mysqli_real_escape_string($conn, $_POST["Domicilio"]) : 'DOM';

            if ($IdPais == 'CL') {
                $sql = "update PosUpclientes set TipoPersona='" . $TipoPersona . "', Domicilio='" . $Domicilio . "', TipoBenef='" . $_POST["TipoBeneficiario"] . "',Longitud='" . $longitud . "',Latitud='" . $latitud . "', region = '" . trim($Region) . "',provincia = '" . trim($Provincia) . "',email='" . trim($ModalEmailCorreo) . "',CodIntDeudor='" . trim($ModalCid) . "',codBarra='" . trim($ModalCodb) . "',Nombre='" . trim($ModalNombre) . "',Fono='" . trim($ModalTelf) . "',Direccion='" . trim($ModalDir) . "',TipoCredito='" . trim($ModalTipoc) . "',EstadoCredito='" . $a . "',Comuna='" . $Comuna . "',Giro='" . trim($ModalGiro) . "',Estado='" . $b . "',EsCliente='" . $c . "',EsProveedor='" . $d . "',EsTrabajador='" . $e . "',EsOtro='" . $f . "',ciudad='" . trim($ModalCiudad) . "',esservidor='" . $ModalServicio . "' where RUT='" . trim($_POST["ModalRut"]) . "-" . trim($_POST["ModalRut2"]) . "' and IdCompany=" . trim($_POST["companyUser"]);
            } else {
                $sql = "update PosUpclientes set TipoPersona='" . $TipoPersona . "', Domicilio='" . $Domicilio . "', TipoBenef='" . $_POST["TipoBeneficiario"] . "',Longitud='" . $longitud . "',Latitud='" . $latitud . "', region = '" . trim($Region) . "',provincia = '" . trim($Provincia) . "',email='" . trim($ModalEmailCorreo) . "',CodIntDeudor='" . trim($ModalCid) . "',codBarra='" . trim($ModalCodb) . "',Nombre='" . trim($ModalNombre) . "',Fono='" . trim($ModalTelf) . "',Direccion='" . trim($ModalDir) . "',TipoCredito='" . trim($ModalTipoc) . "',EstadoCredito='" . $a . "',Comuna='" . $Comuna . "',Giro='" . trim($ModalGiro) . "',Estado='" . $b . "',EsCliente='" . $c . "',EsProveedor='" . $d . "',EsTrabajador='" . $e . "',EsOtro='" . $f . "',ciudad='" . trim($ModalCiudad) . "',esservidor='" . $ModalServicio . "' where RUT='" . trim($_POST["ModalRif"]) . "' and IdCompany=" . trim($_POST["companyUser"]);
            }
            $stmt = mysqli_query($conn, $sql);
            if ($stmt === true) {
                echo "1";
            } else {
                echo "0";
            }
        }
    } else {
        $sql = "delete from PosUpclientes where RUT='" . trim($_POST["ModalRif"]) . "' and IdCompany=" . trim($_POST["companyUser"]);
        $stmt = mysqli_query($conn, $sql);
        if ($stmt === true) {
            echo "1";
        } else {
            echo "0";
        }
    }
}
?>