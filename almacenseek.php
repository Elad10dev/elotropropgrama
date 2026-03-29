<?php
$IdCompany = $_POST["IdCompany"] ?? 0;
$request = $_REQUEST;

if (isset($_POST['go']) && $_POST['go'] == 'datatable') {
    include "ambienteconsultas.php";
    $conn = conectar();
    
    $sqlcompany = "SELECT cantAlmacen FROM PosUpCompany where Id='" . mysqli_real_escape_string($conn, $IdCompany) . "'";
    $CantAlmacenes = 0;
    if ($params = mysqli_query($conn, $sqlcompany)) {
        if ($pam = mysqli_fetch_assoc($params)) {
            $CantAlmacenes = $pam['cantAlmacen'];
        }
        mysqli_free_result($params);
    }

    $query3 = "SELECT count(IdAlm) as cant FROM posupalmacen WHERE IdCompany=" . $IdCompany;
    $cantReg = 0;
    if ($result3 = mysqli_query($conn, $query3)) {
        if ($row3 = mysqli_fetch_assoc($result3)) {
            $cantReg = $row3['cant'];
        }
        mysqli_free_result($result3);
    }
    
    $PermiteClonar = "0";
    if (isset($_POST["userperfil"]) && ($_POST["userperfil"] <= 2000 || $_SESSION["userperfil"] == "2055" || $_SESSION["userperfil"] == "2054"  || $_SESSION["userperfil"] == "2053")) {
        if ($cantReg < $CantAlmacenes or $CantAlmacenes == 0) {
            $PermiteClonar = "1";
        }
    }
    
    $col = array(
        0   =>  'a.IdAlm',
        1   =>  'a.Nombre',
        2   =>  'a.Tipo',
        3   =>  'b.Nombre'
    );

    // CONSULTA BLINDADA CON ALIAS (f_islr y f_retiva)
    $query2 = "SELECT SQL_NO_CACHE a.Cashea_AliadoName, a.Cashea_APIKEY, a.Cashea_Precio, a.codigocontable, a.IdAtt, a.FormaOC, 
        a.FormPresu, a.FormPedid, a.FormaFac, a.FormaBol, a.FormaGuia, a.FormaNote, a.FormaMovi, a.ImpFac, a.impBoleta, 
        a.ImpGuia, a.ImpNotaEnt, a.ImpMovInventario, a.IdAlm, a.Nombre, a.Tipo, a.IdUbi, 
        IFNULL(a.FormaISLR, '') as f_islr, IFNULL(a.FormaRETIVA, '') as f_retiva, b.Nombre as Ubicacion 
        FROM posupalmacen a 
        INNER JOIN PosUpUbicacion b on a.IdUbi = b.IdUbi and a.idCompany= b.idCompany 
        WHERE a.IdCompany=" . $IdCompany;
        
    if (!empty($request['search']['value'])) {
        $search = mysqli_real_escape_string($conn, $request['search']['value']);
        $query2 .= " AND (a.Nombre Like '%" . $search . "%' OR b.Nombre Like '%" . $search . "%' OR a.IdAlm Like '%" . $search . "%' )";
    }
    $sql = $query2;

    $query = mysqli_query($conn, $sql);
    $totalData = mysqli_num_rows($query);
    $totalFilter = $totalData;

    if (isset($request['order'][0]['column']) && isset($request['order'][0]['dir'])) {
        $sql .= " ORDER BY " . $col[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];
    }

    $sql .= " LIMIT " . $request['start'] . "  ," . $request['length'];

    $query = mysqli_query($conn, $sql);
    $data = array();
    $n = 0;

    while ($row = mysqli_fetch_assoc($query)) {
        $n++;
        $subdata = array();

        $edit = '<button class="btn btn-outline-primary p-1 m-1" type="button" data-toggle="tooltip" title="Editar" id="editar' . $n . '" onclick="recibir(' . $n . ');"><i class="fa fa-edit"></i></button>';
        if ($PermiteClonar == "1") {
            $edit .= '<button class="btn btn-outline-primary p-1 m-1" type="button" data-toggle="tooltip" onclick="ClonarReg(' . $n . ');"><i class="fa fa-clone"></i></button>';
        }
        
        $Cant = 0;
        $sql2 = "SELECT count(IdCompany) as Cant FROM PosUpTxD where IdCompany=" . $IdCompany . " and IdAlm='" . $row["IdAlm"] . "'";
        if ($result2 = mysqli_query($conn, $sql2)) {
            if ($row2 = mysqli_fetch_assoc($result2)) {
                $Cant = $row2["Cant"];
            }
            mysqli_free_result($result2);
        }
        
        $delete = "";
        if (isset($_POST["userperfil"]) && ($_POST["userperfil"] <= 2000 || $_SESSION["userperfil"] == "2055" || $_SESSION["userperfil"] == "2054"  || $_SESSION["userperfil"] == "2053") and ($Cant == 0)) {
            $delete = '<button class="btn btn-outline-danger p-1 m-1" type="button" data-toggle="tooltip" title="Eliminar" id="eliminar' . $n . '" onclick="alertaborrar(' . $n . ');"><i class="fa fa-trash"></i></button>';
        }
        
        // LEEMOS DIRECTO DEL ALIAS EXACTO
        $formaIslrVal = trim($row['f_islr']);
        $formaRetivaVal = trim($row['f_retiva']);

        // CONSTRUIMOS EL DOM OCULTO
        $hiddenTags = '
            <label style="display:none" id="ImpFa' . $n . '">' . trim((string)$row['ImpFac']) . '</label>
            <label style="display:none" id="impBolet' . $n . '">' . trim((string)$row['impBoleta']) . '</label>
            <label style="display:none" id="ImpGui' . $n . '">' . trim((string)$row['ImpGuia']) . '</label>
            <label style="display:none" id="ImpNotaEn' . $n . '">' . trim((string)$row['ImpNotaEnt']) . '</label>
            <label style="display:none" id="ImpMovInventari' . $n . '">' . trim((string)$row['ImpMovInventario']) . '</label>
            <label style="display:none" id="ImpFa2' . $n . '">' . trim((string)$row['FormaFac']) . '</label>
            <label style="display:none" id="impBolet2' . $n . '">' . trim((string)$row['FormaBol']) . '</label>
            <label style="display:none" id="ImpGui2' . $n . '">' . trim((string)$row['FormaGuia']) . '</label>
            <label style="display:none" id="ImpNotaEn2' . $n . '">' . trim((string)$row['FormaNote']) . '</label>
            <label style="display:none" id="tipo2' . $n . '">' . trim((string)$row['Tipo']) . '</label>
            <label style="display:none" id="IdUbi' . $n . '">' . trim((string)$row['IdUbi']) . '</label>
            <label style="display:none" id="ImpMovInventari2' . $n . '">' . trim((string)$row['FormaMovi']) . '</label>
            <label style="display:none" id="FormPresup' . $n . '">' . trim((string)$row['FormPresu']) . '</label>
            <label style="display:none" id="FormPedido' . $n . '">' . trim((string)$row['FormPedid']) . '</label>
            <label style="display:none" id="IdAttA' . $n . '">' . trim((string)$row['IdAtt']) . '</label>
            <label style="display:none" id="codigocontable' . $n . '">' . trim((string)$row['codigocontable']) . '</label>
            <label style="display:none" id="Cashea_AliadoName' . $n . '">' . trim((string)$row['Cashea_AliadoName']) . '</label>
            <label style="display:none" id="Cashea_APIKEY' . $n . '">' . trim((string)$row['Cashea_APIKEY']) . '</label>
            <label style="display:none" id="Cashea_Precio' . $n . '">' . trim((string)$row['Cashea_Precio']) . '</label>
            <label style="display:none" id="FormOC' . $n . '">' . trim((string)$row['FormaOC']) . '</label>
            <label style="display:none" id="FormaISLR' . $n . '">' . $formaIslrVal . '</label>
            <label style="display:none" id="FormaRETIVA' . $n . '">' . $formaRetivaVal . '</label>';

        $subdata[] = "<div class='text-center' id='IdAlm" . $n . "'>" . $row['IdAlm'] . "</div>"; 
        $subdata[] = "<span id='nom" . $n . "'>" . $row['Nombre'] . "</span><br>" . $edit . $delete . $hiddenTags;
        
        $subdata[] = $row['Nombre']; 
        
        $tipo = '';
        if (trim($row['Tipo']) == "0") { $tipo = "Inhabilitado para Transacciones"; }
        if (trim($row['Tipo']) == "1") { $tipo = "Venta"; }
        if (trim($row['Tipo']) == "2") { $tipo = "Almacen"; }
        if (trim($row['Tipo']) == "3") { $tipo = "Almacén de Producción"; }
        
        $subdata[] = "<span id='zzz" . $n . "'>" . $tipo . "</span>"; 
        $subdata[] = "<span id='" . $n . "'>" . $row['Ubicacion'] . "</span>"; 

        $data[] = $subdata;
    }
    
    $json_data = array(
        "draw"              =>  intval($request['draw']),
        "recordsTotal"      =>  intval($totalData),
        "recordsFiltered"   =>  intval($totalFilter),
        "data"              =>  $data
    );

    echo json_encode($json_data);
}

if (isset($_POST['go']) && $_POST['go'] == 'verif-alm') {
    include "ambienteconsultas.php";
    $conn = conectar();
    $sqlcompany = "SELECT cantAlmacen FROM PosUpCompany where Id='" . mysqli_real_escape_string($conn, $_POST['company']) . "'";
    $CantAlmacenes = 0;
    if ($params = mysqli_query($conn, $sqlcompany)) {
        if ($pam = mysqli_fetch_assoc($params)) {
            $CantAlmacenes = $pam['cantAlmacen'];
        }
        mysqli_free_result($params);
    }

    $query3 = "SELECT count(IdAlm) as cant FROM posupalmacen WHERE IdCompany=" . mysqli_real_escape_string($conn, $_POST['company']);
    $cantReg = 0;
    if ($result3 = mysqli_query($conn, $query3)) {
        if ($row3 = mysqli_fetch_assoc($result3)) {
            $cantReg = $row3['cant'];
        }
        mysqli_free_result($result3);
    }
    
    if ($cantReg < $CantAlmacenes or $CantAlmacenes == 0) {
        echo '1';
    } else {
        echo '0';
    }
}

if (isset($_POST["tabla"]) && $_POST["tabla"] == "almacen") {
    include "ambiente.php";
    $conn = conectar();
    $connsultas = ConectarConsultas();
    
    $companyUser = mysqli_real_escape_string($conn, $_POST["companyUser"]);
    $ModalIdAlm = mysqli_real_escape_string($conn, $_POST["ModalIdAlm"]);

    if (!isset($_POST["borrar"])) {
        $ModalNombre = mysqli_real_escape_string($conn, $_POST["ModalNombre"] ?? '');
        $ModalTipo = mysqli_real_escape_string($conn, $_POST["ModalTipo"] ?? '0');
        $ModalIdUbi = mysqli_real_escape_string($conn, $_POST["ModalIdUbi"] ?? '0');
        $ImpFac = mysqli_real_escape_string($conn, $_POST["ImpFac"] ?? '0');
        $impBoleta = mysqli_real_escape_string($conn, $_POST["impBoleta"] ?? '0');
        $ImpGuia = mysqli_real_escape_string($conn, $_POST["ImpGuia"] ?? '0');
        $ImpNotaEnt = mysqli_real_escape_string($conn, $_POST["ImpNotaEnt"] ?? '0');
        $ImpMovInventario = mysqli_real_escape_string($conn, $_POST["ImpMovInventario"] ?? '0');
        
        $FormaFac = mysqli_real_escape_string($conn, $_POST["FormaFac"] ?? '');
        $FormaBol = mysqli_real_escape_string($conn, $_POST["FormaBol"] ?? '');
        $FormaGuia = mysqli_real_escape_string($conn, $_POST["FormaGuia"] ?? '');
        $FormaNote = mysqli_real_escape_string($conn, $_POST["FormaNote"] ?? '');
        $FormaMovi = mysqli_real_escape_string($conn, $_POST["FormaMovi"] ?? '');
        $FormPedid = mysqli_real_escape_string($conn, $_POST["FormPedid"] ?? '');
        $FormPresu = mysqli_real_escape_string($conn, $_POST["FormPresu"] ?? '');
        $FormOC = mysqli_real_escape_string($conn, $_POST["FormOC"] ?? '');
        
        $ModalAtencion = mysqli_real_escape_string($conn, $_POST["ModalAtencion"] ?? '0');
        $ModalCodigoContable = mysqli_real_escape_string($conn, $_POST["ModalCodigoContable"] ?? '');
        $CasheAliado = mysqli_real_escape_string($conn, $_POST["CasheAliado"] ?? '');
        $CasheApikey = mysqli_real_escape_string($conn, $_POST["CasheApikey"] ?? '');
        $CasheaPrecio = mysqli_real_escape_string($conn, $_POST["CasheaPrecio"] ?? '1');

        $FormaISLR = isset($_POST["FormaISLR"]) ? mysqli_real_escape_string($conn, trim($_POST["FormaISLR"])) : '';
        $FormaRETIVA = isset($_POST["FormaRETIVA"]) ? mysqli_real_escape_string($conn, trim($_POST["FormaRETIVA"])) : '';

        if ($ModalIdAlm == "") {
            $sql = "INSERT INTO posupalmacen (FormaISLR,FormaRETIVA,FormaOC,FormPresu,IdAlm,Nombre,Tipo,IdCompany,IdUbi,ImpFac,impBoleta,ImpGuia,ImpNotaEnt,ImpMovInventario,FormaFac,FormaBol,FormaGuia,FormaNote,FormaMovi,FormPedid,IdAtt,codigocontable,Cashea_AliadoName,Cashea_APIKEY,Cashea_Precio) 
                    (SELECT '" . $FormaISLR . "','" . $FormaRETIVA . "','" . $FormOC . "','" . $FormPresu . "', COALESCE(max(IdAlm),0)+1 as IdAlm,'" . $ModalNombre . "'," . $ModalTipo . "," . $companyUser . "," . $ModalIdUbi . "," . $ImpFac . "," . $impBoleta . "," . $ImpGuia . "," . $ImpNotaEnt . "," . $ImpMovInventario . ",'" . $FormaFac . "','" . $FormaBol . "','" . $FormaGuia . "','" . $FormaNote . "','" . $FormaMovi . "','" . $FormPedid . "','" . $ModalAtencion . "','" . $ModalCodigoContable . "','" . $CasheAliado . "','" . $CasheApikey . "','" . $CasheaPrecio . "' FROM posupalmacen WHERE IdCompany = " . $companyUser . ")";
        } else {
            // AQUÍ ESTÁ LA ESTRUCTURA SQL EXACTA QUE PEDISTE 
            $sql = "UPDATE posupalmacen 
                    SET FormaISLR = '" . $FormaISLR . "', 
                        FormaRETIVA = '" . $FormaRETIVA . "', 
                        Cashea_AliadoName = '" . $CasheAliado . "',
                        Cashea_APIKEY = '" . $CasheApikey . "',
                        Cashea_Precio = '" . $CasheaPrecio . "',
                        codigocontable = '" . $ModalCodigoContable . "',
                        IdAtt = '" . $ModalAtencion . "',
                        FormaOC = '" . $FormOC . "',
                        FormPresu = '" . $FormPresu . "',
                        FormPedid = '" . $FormPedid . "',
                        FormaFac = '" . $FormaFac . "',
                        FormaBol = '" . $FormaBol . "',
                        FormaGuia = '" . $FormaGuia . "',
                        FormaNote = '" . $FormaNote . "',
                        FormaMovi = '" . $FormaMovi . "',
                        ImpFac = '" . $ImpFac . "',
                        impBoleta = '" . $impBoleta . "',
                        ImpGuia = '" . $ImpGuia . "',
                        ImpNotaEnt = '" . $ImpNotaEnt . "',
                        ImpMovInventario = '" . $ImpMovInventario . "',
                        Nombre = '" . $ModalNombre . "',
                        Tipo = '" . $ModalTipo . "',
                        IdUbi = " . $ModalIdUbi . " 
                    WHERE IdCompany = " . $companyUser . " AND IdAlm = " . $ModalIdAlm;
        }
        
        $stmt = mysqli_query($conn, $sql);
        if ($stmt === true) { echo "1"; } else { echo "0"; }
        
    } else {
        $sql2 = "SELECT * FROM PosUpTxD where IdCompany=" . $companyUser . " and IdAlm='" . $ModalIdAlm . "' limit 2 ";
        if ($result = mysqli_query($connsultas, $sql2)) {
            $n = 0;
            while ($row = mysqli_fetch_assoc($result)) { $n = $n + 1; }
            mysqli_free_result($result);
        }
        if ($n > 1) {
            echo '-0';
        } else {
            $sql = "DELETE FROM posupalmacen WHERE IdAlm=" . $ModalIdAlm . " AND IdCompany=" . $companyUser;
            $stmt = mysqli_query($conn, $sql);
            if ($stmt === true) { echo "1"; } else { echo "0"; }
        }
    }
}