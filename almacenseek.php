<?php
$IdCompany = $_POST["IdCompany"];
$request = $_REQUEST;

if ($_POST['go'] == 'datatable') {
    include "ambienteconsultas.php";
    $conn = conectar();
    $sqlcompany = "SELECT * FROM PosUpCompany where Id='" . $_POST['IdCompany'] . "'";
    if ($params = mysqli_query($conn, $sqlcompany)) {
        while ($pam = mysqli_fetch_assoc($params)) {
            $CantAlmacenes = $pam['cantAlmacen'];
        }
        mysqli_free_result($params);
    }

    $query3 = "SELECT count(IdAlm) as cant, a.Nombre as Nombre, a.Tipo as Tipo, a.IdUbi as IdUbi, b.Nombre FROM PosUpAlmacen a INNER JOIN PosUpUbicacion b on a.IdUbi = b.IdUbi and a.idCompany= b.idCompany where a.IdCompany=" . $_POST["IdCompany"];
    $cantReg = 0;
    if ($result3 = mysqli_query($conn, $query3)) {
        while ($row3 = mysqli_fetch_assoc($result3)) {
            $cantReg = $row3['cant'];
        }
    }
    $PermiteClonar = "0";
    if ($_POST["userperfil"] <= 2000 || $_SESSION["userperfil"] == "2055" || $_SESSION["userperfil"] == "2054"  || $_SESSION["userperfil"] == "2053") {
        if ($cantReg < $CantAlmacenes or $CantAlmacenes == 0) {
            $PermiteClonar = "1";
        }
    }
    $col = array(
        0   =>  'a.IdAlm',
        1   =>  'b.Nombre',
        2   =>  'a.Tipo',
        3   =>  'b.Nombre'

    );

    $query2 = "SELECT a.codigocontable,a.IdAtt,a.FormaOC,a.FormPresu,a.FormPedid,a.FormaFac,a.FormaBol,a.FormaGuia,a.FormaNote,a.FormaMovi,a.ImpFac,a.impBoleta,a.ImpGuia,a.ImpNotaEnt,a.ImpMovInventario, a.IdAlm as IdAlm,
        a.Nombre as Nombre, a.Tipo as Tipo, a.IdUbi, b.Nombre as Ubicacion FROM PosUpAlmacen a 
        INNER JOIN PosUpUbicacion b on a.IdUbi = b.IdUbi and a.idCompany= b.idCompany where a.IdCompany=" . $_POST["IdCompany"] . "";
    if (!empty($request['search']['value'])) {
        $query2 .= " AND (a.Nombre Like '%" . $request['search']['value'] . "%' ";
        $query2 .= " OR b.Nombre Like '%" . $request['search']['value'] . "%' ";
        $query2 .= " OR a.IdAlm Like '%" . $request['search']['value'] . "%' )";
    }
    $sql = $query2;

    $query = mysqli_query($conn, $sql);

    $totalData = mysqli_num_rows($query);

    $totalFilter = $totalData;

    //Search
    //$sql ="SELECT Descripcion,CodBarra,Medida,Idfamilia,Marca,Estado,PrecioVenta,CodIdAmpliado,CodIdBasico FROM PosUpProducto WHERE IdCompany=150";
    //if(!empty($request['search']['value'])){
    //    $sql.=" AND (Descripcion Like '%".$request['search']['value']."%' ";
    //    $sql.=" OR CodBarra Like '%".$request['search']['value']."%' ";
    //   $sql.=" OR Medida Like '%".$request['search']['value']."%' )";
    //}
    $query = mysqli_query($conn, $sql);
    $totalData = mysqli_num_rows($query);

    //Order
    if ($col[$request['order'][0]['column']] && $request['order'][0]['dir']) {
        $sql .= " ORDER BY " . $col[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'] . "";
    }

    $sql .= " LIMIT " . $request['start'] . "  ," . $request['length'] . "  ";

    $query = mysqli_query($conn, $sql);

    $data = array();

    while ($row = mysqli_fetch_array($query)) {
        $n = $n + 1;
        $subdata = array();

        $edit = '<button class="btn btn-outline-primary p-1 m-1" type="button" data-toggle="tooltip" title="Editar" id="editar' . $n . '" onclick="recibir(' . $n . ');"><i class="fa fa-edit"></i></button>';
        if ($PermiteClonar == "1") {
            $edit .= '<button class="btn btn-outline-primary p-1 m-1" type="button" data-toggle="tooltip" onclick="ClonarReg(' . $n . ');"><i class="fa fa-clone"></i></button>';
        }
        $Cant = 0;
        $sql2 = "SELECT count(IdCompany) as Cant FROM PosUpTxD where IdCompany=" . trim($_POST["IdCompany"]) . " and IdAlm='" . $row["IdAlm"] . "'";
        if ($result2 = mysqli_query($conn, $sql2)) {
            while ($row2 = mysqli_fetch_assoc($result2)) {
                $Cant = $row2["Cant"];
            }
            mysqli_free_result($result2);
        }
        if (($_POST["userperfil"] <= 2000 || $_SESSION["userperfil"] == "2055" || $_SESSION["userperfil"] == "2054"  || $_SESSION["userperfil"] == "2053") and ($Cant == 0)) {
            $delete = '<button class="btn btn-outline-danger p-1 m-1" type="button" data-toggle="tooltip" title="Eliminar" id="eliminar' . $n . '" onclick="alertaborrar(' . $n . ');"><i class="fa fa-trash"></i></button>';
        }
        $subdata[] = "<div class='text-center' id='IdAlm" . $n . "'>" . $row['IdAlm'] . "</div>"; //salary
        $subdata[] = "<span class='' id='nom" . $n . "'>" . $row['Nombre'] . "</span>" . '<br>
            ' . $edit . '
            ' . $delete . '
            <label style="display:none" class="text-center" id="ImpFa' . $n . '">' . trim($row['ImpFac']) . '</label>
            <label style="display:none" class="text-center" id="impBolet' . $n . '">' . trim($row['impBoleta']) . '</label>
            <label style="display:none" class="text-center" id="ImpGui' . $n . '">' . trim($row['ImpGuia']) . '</label>
            <label style="display:none" class="text-center" id="ImpNotaEn' . $n . '">' . trim($row['ImpNotaEnt']) . '</label>
            <label style="display:none" class="text-center" id="ImpMovInventari' . $n . '">' . trim($row['ImpMovInventario']) . '</label>
            <label style="display:none" class="text-center" id="ImpFa2' . $n . '">' . trim($row['FormaFac']) . '</label>
            <label style="display:none" class="text-center" id="impBolet2' . $n . '">' . trim($row['FormaBol']) . '</label>
            <label style="display:none" class="text-center" id="ImpGui2' . $n . '">' . trim($row['FormaGuia']) . '</label>
            <label style="display:none" class="text-center" id="ImpNotaEn2' . $n . '">' . trim($row['FormaNote']) . '</label>
            <label style="display:none" class="text-center" id="tipo2' . $n . '">' . trim($row['Tipo']) . '</label>
            <label style="display:none" class="text-center" id="IdUbi' . $n . '">' . trim($row['IdUbi']) . '</label>
            <label style="display:none" class="text-center" id="ImpMovInventari2' . $n . '">' . trim($row['FormaMovi']) . '</label>
            <label style="display:none" class="text-center" id="FormPresup' . $n . '">' . trim($row['FormPresu']) . '</label>
            <label style="display:none" class="text-center" id="FormPedido' . $n . '">' . trim($row['FormPedid']) . '</label>
            <label style="display:none" class="text-center" id="IdAttA' . $n . '">' . trim($row['IdAtt']) . '</label>
            <label style="display:none" class="text-center" id="codigocontable' . $n . '">' . trim($row['codigocontable']) . '</label>
            <label style="display:none" class="text-center" id="FormOC' . $n . '">' . trim($row['FormaOC']) . '</label>'; //salary
        $subdata[] = $row['Nombre'];
        $tipo = '';
        if (trim($row['Tipo']) == "0") {
            $tipo = "Inhabilitado para Transacciones";
        }
        if (trim($row['Tipo']) == "1") {
            $tipo = "Venta";
        }
        if (trim($row['Tipo']) == "2") {
            $tipo = "Almacen";
        }
        if (trim($row['Tipo']) == "3") {
            $tipo = "Almacén de Producción";
        }
        $subdata[] = "<span class='' id='zzz" . $n . "'>" . $tipo . "</span>"; //salary
        $subdata[] = "<span class='' id='" . $n . "'>" . $row['Ubicacion'] . "</span>"; //salary





        //$subdata[]='<button type="button" id="getEdit" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal" data-id="'.$row[0].'"><i class="ion-edit"></i></button>
        //            <button type="button" id="getEdit" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal" data-id="'.$row[0].'"><i class="ion-android-delete"></i></button>';
        $data[] = $subdata;
    }
    /*
        $subdata=array();
            $subdata[]=$query2;
            $data[]=$subdata; */
    $json_data = array(
        "draw"              =>  intval($request['draw']),
        "recordsTotal"      =>  intval($totalData),
        "recordsFiltered"   =>  intval($totalFilter),
        "data"              =>  $data
    );

    echo json_encode($json_data);
}

if ($_POST['go'] == 'verif-alm') {

    include "ambienteconsultas.php";
    $conn = conectar();
    $sqlcompany = "SELECT * FROM PosUpCompany where Id='" . $_POST['company'] . "'";
    if ($params = mysqli_query($conn, $sqlcompany)) {
        while ($pam = mysqli_fetch_assoc($params)) {
            $CantAlmacenes = $pam['cantAlmacen'];
        }
        mysqli_free_result($params);
    }

    $query3 = "SELECT count(IdAlm) as cant, a.Nombre as Nombre, a.Tipo as Tipo, a.IdUbi as IdUbi, b.Nombre FROM PosUpAlmacen a 
        INNER JOIN PosUpUbicacion b on a.IdUbi = b.IdUbi and a.idCompany= b.idCompany where a.IdCompany=" . $_POST["company"];
    //echo $query3;
    $cantReg = 0;
    if ($result3 = mysqli_query($conn, $query3)) {
        while ($row3 = mysqli_fetch_assoc($result3)) {
            $cantReg = $row3['cant'];
        }
    }
    if ($cantReg < $CantAlmacenes or $CantAlmacenes == 0) {
        echo '1';
    } else {
        echo '0';
    }
}

if ($_POST["tabla"] == "almacen") {
    include "ambiente.php";
    $conn = conectar();
    $connsultas = ConectarConsultas();
    if (!isset($_POST["borrar"])) {
        $ModalNombre = mysqli_real_escape_string($conn, $_POST["ModalNombre"]);
        $ModalTipo = mysqli_real_escape_string($conn, $_POST["ModalTipo"]);
        $ModalIdUbi = mysqli_real_escape_string($conn, $_POST["ModalIdUbi"]);
        $ImpFac = mysqli_real_escape_string($conn, $_POST["ImpFac"]);
        $impBoleta = mysqli_real_escape_string($conn, $_POST["impBoleta"]);
        $ImpGuia = mysqli_real_escape_string($conn, $_POST["ImpGuia"]);
        $ImpNotaEnt = mysqli_real_escape_string($conn, $_POST["ImpNotaEnt"]);
        $ImpMovInventario = mysqli_real_escape_string($conn, $_POST["ImpMovInventario"]);
        $FormaFac = mysqli_real_escape_string($conn, $_POST["FormaFac"]);
        $FormaBol = mysqli_real_escape_string($conn, $_POST["FormaBol"]);
        $FormaGuia = mysqli_real_escape_string($conn, $_POST["FormaGuia"]);
        $FormaNote = mysqli_real_escape_string($conn, $_POST["FormaNote"]);
        $FormaMovi = mysqli_real_escape_string($conn, $_POST["FormaMovi"]);
        $FormPedid = mysqli_real_escape_string($conn, $_POST["FormPedid"]);
        $FormPresu = mysqli_real_escape_string($conn, $_POST["FormPresu"]);
        $ModalAtencion = mysqli_real_escape_string($conn, $_POST["ModalAtencion"]);
        $ModalCodigoContable = mysqli_real_escape_string($conn, $_POST["ModalCodigoContable"]);
        $FormOC = mysqli_real_escape_string($conn, $_POST["FormOC"]);
        if ($_POST["ModalIdAlm"] == "") {
            $sql = "insert into PosUpAlmacen (FormaOC,FormPresu,IdAlm,Nombre,Tipo,IdCompany,IdUbi,ImpFac,impBoleta,ImpGuia,ImpNotaEnt,ImpMovInventario,FormaFac,FormaBol,FormaGuia,FormaNote,FormaMovi,FormPedid,IdAtt,codigocontable) (select '" . trim($FormOC) . "','" . trim($FormPresu) . "', COALESCE(max(IdAlm),0)+1 as IdAlm,'" . trim($ModalNombre) . "'," . trim($ModalTipo) . "," . $_POST["companyUser"] . "," . trim($ModalIdUbi) . "," . trim($ImpFac) . "," . trim($impBoleta) . "," . trim($ImpGuia) . "," . trim($ImpNotaEnt) . "," . trim($ImpMovInventario) . ",'" . trim($FormaFac) . "','" . trim($FormaBol) . "','" . trim($FormaGuia) . "','" . trim($FormaNote) . "','" . trim($FormaMovi) . "','" . trim($FormPedid) . "','" . $ModalAtencion . "','" . $ModalCodigoContable . "' from PosUpAlmacen where IdCompany = " . $_POST["companyUser"] . ")";
        } else {
            $sql = "update PosUpAlmacen set codigocontable='" . trim($ModalCodigoContable) . "',IdAtt='" . trim($ModalAtencion) . "',FormaOC='" . trim($FormOC) . "',FormPresu='" . trim($FormPresu) . "',FormPedid='" . trim($FormPedid) . "',FormaFac='" . trim($FormaFac) . "',FormaBol='" . trim($FormaBol) . "',FormaGuia='" . trim($FormaGuia) . "',FormaNote='" . trim($FormaNote) . "',FormaMovi='" . trim($FormaMovi) . "',ImpFac='" . trim($ImpFac) . "',impBoleta='" . trim($impBoleta) . "',ImpGuia='" . trim($ImpGuia) . "',ImpNotaEnt='" . trim($ImpNotaEnt) . "',ImpMovInventario='" . trim($ImpMovInventario) . "',Nombre='" . trim($ModalNombre) . "',Tipo='" . trim($ModalTipo) . "',IdUbi= " . trim($ModalIdUbi) . " where IdAlm=" . trim($_POST["ModalIdAlm"]) . " and IdCompany=" . trim($_POST["companyUser"]);
        }
        $stmt = mysqli_query($conn, $sql);
        if ($stmt === true) {
            echo "1";
        } else {
            echo "0";
        }
        mysqli_free_result($stmt);
    } else {
        $sql2 = "SELECT * FROM PosUpTxD where IdCompany=" . trim($_POST["companyUser"]) . " and IdAlm='" . trim($_POST["ModalIdAlm"]) . "' limit 2 ";
        if ($result = mysqli_query($connsultas, $sql2)) {
            $n = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                $n = $n + 1;
            }
        }
        if ($n > 1) {
            echo '-0';
        } else {
            $sql = "delete from PosUpAlmacen where IdAlm=" . trim($_POST["ModalIdAlm"]) . " and IdCompany=" . trim($_POST["companyUser"]);
            $stmt = mysqli_query($conn, $sql);
            if ($stmt === true) {
                echo "1";
            } else {
                echo "0";
            }
            mysqli_free_result($stmt);
        }
    }
}
