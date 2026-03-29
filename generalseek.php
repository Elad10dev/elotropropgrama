<?php

function VerificarFiscal($conn, $post)
{
    $statusfiscal = "1";
    $query = "SELECT statusfiscal FROM PosUpCompanyEstacion where token='" . $post['token'] . "' and IdCompany = '" . $post["CompanyActual"] . "' and transdecaja = 1 and tipocaja = 0 and IfiscalSerie <> ''";
    if ($result = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $statusfiscal = $row["statusfiscal"];
        }
    }

    return ["msg" => $statusfiscal];
}

function actualizarFavoritos($conn, $post)
{
    if (empty($post["CompanyActual"]) || empty($post["userlogin"])) {
        return ["status" => false, "msg" => "Parámetros inválidos", "debug" => $post];
    }

    $company = mysqli_real_escape_string($conn, $post["CompanyActual"]);
    $login   = mysqli_real_escape_string($conn, $post["userlogin"]);

    $favoritosRaw = [];
    $favoritosLimpios = [];

    // 1) Leer favoritos
    $query = "SELECT favoritos
              FROM posupusers
              WHERE IdCompany = '$company' AND Login = '$login'
              LIMIT 1";

    $result = mysqli_query($conn, $query);
    if (!$result) {
        return [
            "status" => false,
            "msg" => "Error SELECT favoritos",
            "debug" => [
                "query" => $query,
                "error" => mysqli_error($conn)
            ]
        ];
    }

    $row = mysqli_fetch_assoc($result);
    mysqli_free_result($result);

    if (!$row) {
        return [
            "status" => false,
            "msg" => "No existe el usuario (IdCompany/Login no coinciden)",
            "debug" => [
                "query" => $query,
                "IdCompany" => $post["CompanyActual"],
                "Login" => $post["userlogin"]
            ]
        ];
    }

    $rawJson = $row["favoritos"];

    // Si viene NULL o vacío en DB
    if ($rawJson === null || trim($rawJson) === '') {
        $favoritosRaw = [];
    } else {
        $tmp = json_decode($rawJson, true);
        $favoritosRaw = is_array($tmp) ? $tmp : [];
    }

    // 2) Limpiar: elimina null, [], strings raros, etc.
    $seen = [];
    foreach ($favoritosRaw as $fav) {

        if (!is_array($fav)) continue;  // elimina null/string/number
        if (count($fav) === 0) continue; // elimina []

        if (!isset($fav["url"])) continue;
        $url = trim($fav["url"]);
        if ($url === '') continue;

        if (isset($seen[$url])) continue; // dedupe por url
        $seen[$url] = true;

        $favoritosLimpios[] = [
            "id"       => isset($fav["id"]) ? $fav["id"] : "",
            "IdModulo" => isset($fav["IdModulo"]) ? $fav["IdModulo"] : "",
            "img"      => isset($fav["img"]) ? $fav["img"] : "",
            "desc"     => isset($fav["desc"]) ? $fav["desc"] : "",
            "url"      => $url
        ];
    }

    // 3) Actualizar SIEMPRE (para que sea imposible que “no haga nada”)
    $json = json_encode($favoritosLimpios, JSON_UNESCAPED_UNICODE);
    $jsonEsc = mysqli_real_escape_string($conn, $json);

    $sql = "UPDATE posupusers
            SET favoritos = '$jsonEsc'
            WHERE IdCompany = '$company' AND Login = '$login'";

    $ok = mysqli_query($conn, $sql);

    return [
        "status" => $ok ? true : false,
        "msg" => $favoritosLimpios,
        "debug" => [
            "select_query" => $query,
            "update_query" => $sql,
            "raw_db" => $rawJson,
            "raw_count" => is_array($favoritosRaw) ? count($favoritosRaw) : -1,
            "clean_count" => count($favoritosLimpios),
            "affected_rows" => mysqli_affected_rows($conn),
            "update_error" => $ok ? "" : mysqli_error($conn)
        ]
    ];
}



function setFavoritos($conn, $post)
{
    // Helpers rápidos (compatibles PHP 5.4)
    $esc = function($v) use ($conn) {
        return mysqli_real_escape_string($conn, (string)$v);
    };

    // 1) Resolver $data desde PosUpModulo o PosUpOpciones
    $data = array();

    $opcion = isset($post['opcion']) ? trim($post['opcion']) : '';
    if ($opcion === '') {
        return array("status" => false, "msg" => "Opción inválida");
    }

    // Buscar en PosUpModulo
    $sql = "SELECT IdModulo, Img, Descripcion, Link FROM PosUpModulo WHERE Link = '" . $esc($opcion) . "' LIMIT 1";
    if ($resu = mysqli_query($conn, $sql)) {
        if ($rw = mysqli_fetch_assoc($resu)) {
            $data = array(
                "id"       => (string)$rw["IdModulo"],
                "IdModulo" => (string)$rw["IdModulo"],
                "img"      => (string)$rw["Img"],
                "desc"     => (string)$rw["Descripcion"],
                "url"      => (string)$rw["Link"],
            );
        }
        mysqli_free_result($resu);
    }

    // Si no existe, buscar en PosUpOpciones
    if (empty($data)) {
        $sql = "SELECT IdOpcion, IdModulo, Img, Descripcion, Link FROM PosUpOpciones WHERE Link = '" . $esc($opcion) . "' LIMIT 1";
        if ($resu = mysqli_query($conn, $sql)) {
            if ($rw = mysqli_fetch_assoc($resu)) {
                $data = array(
                    "id"       => (string)$rw["IdOpcion"],
                    "IdModulo" => (string)$rw["IdModulo"],
                    "img"      => (string)$rw["Img"],
                    "desc"     => (string)$rw["Descripcion"],
                    "url"      => (string)$rw["Link"],
                );
            }
            mysqli_free_result($resu);
        }
    }

    // Validación fuerte: no permitimos favoritos inválidos
    if (
        empty($data) ||
        !isset($data["url"]) ||
        trim($data["url"]) === ''
    ) {
        return array("status" => false, "msg" => "Favorito inválido (no encontrado)");
    }

    // 2) Leer favoritos actuales del usuario
    $favoritos = array();

    $company = isset($post["CompanyActual"]) ? $post["CompanyActual"] : '';
    $login   = isset($post["userlogin"]) ? $post["userlogin"] : '';

    if ($company === '' || $login === '') {
        return array("status" => false, "msg" => "Usuario/Company inválidos");
    }

    $query = "SELECT favoritos FROM posupusers 
              WHERE IdCompany = '" . $esc($company) . "' 
              AND Login = '" . $esc($login) . "' 
              LIMIT 1";

    if ($result = mysqli_query($conn, $query)) {
        if ($row = mysqli_fetch_assoc($result)) {
            $tmp = json_decode($row["favoritos"], true);
            if (is_array($tmp)) {
                $favoritos = $tmp;
            } else {
                $favoritos = array(); // si es null/false/string, lo normalizamos
            }
        }
        mysqli_free_result($result);
    }

    // Guardar copia para detectar cambios reales
    $originalJson = json_encode($favoritos);

    // 3) Aplicar cambio (agregar/quitar) evitando basura y duplicados
    $change = (isset($post["change"]) && $post["change"] === "true") ? "true" : "false";

    $found  = false;
    $newFavs = array();

    foreach ($favoritos as $fav) {
        // Ignorar entradas corruptas: arrays vacíos, null, strings, etc.
        if (!is_array($fav)) continue;
        if (!isset($fav["url"]) || trim($fav["url"]) === '') continue;

        // Comparar por URL
        if ($fav["url"] === $data["url"]) {
            $found = true;
            if ($change !== "true") {
                // Se pidió quitar: no lo agregamos
                continue;
            }
        }

        // Mantener favorito válido
        $newFavs[] = $fav;
    }

    // Agregar solo si se pidió agregar y no existía
    if ($change === "true" && !$found) {
        $newFavs[] = $data;
    }

    $favoritos = $newFavs;

    // 4) Si no hubo cambios, no actualizar
    if (json_encode($favoritos) === $originalJson) {
        return array("status" => true, "msg" => "Sin cambios");
    }

    // 5) Si queda vacío, NO guardamos (evita guardar [])
    if (empty($favoritos)) {
        return array("status" => true, "msg" => "Favoritos vacíos, no se guarda");
    }

    // 6) Update seguro
    $favJson = json_encode($favoritos, JSON_UNESCAPED_UNICODE);

    $sql = "UPDATE posupusers 
            SET favoritos = '" . $esc($favJson) . "'
            WHERE IdCompany = '" . $esc($company) . "' 
            AND Login = '" . $esc($login) . "'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        // IMPORTANTE: afected_rows puede ser 0 aunque se haya ejecutado,
        // pero para ti sirve para detectar si realmente cambió algo.
        return array(
            "status" => true,
            "saved"  => true,
            "rows"   => mysqli_affected_rows($conn),
            "favoritos" => $favoritos
        );
    }

    return array(
        "status" => false,
        "saved"  => false,
        "msg"    => "No se pudo actualizar favoritos",
        "mysql_errno" => mysqli_errno($conn),
        "mysql_error" => mysqli_error($conn)
    );
}


if ($_POST["Action"] === "actualizarFavoritos") {
    include "ambiente.php";
    $conn = conectar();
    echo json_encode(actualizarFavoritos($conn, $_POST), JSON_UNESCAPED_UNICODE);
}

if ($_POST["Action"] === "setFavoritos") {
    include "ambiente.php";
    $conn = conectar();
    echo json_encode(setFavoritos($conn, $_POST), JSON_UNESCAPED_UNICODE);
}

if ($_POST["Accion"] == "0") {
    include "ambienteconsultas.php";
    $conn = conectar();
    if ($_POST["Ini"] == "0") {
?>
        <span id="NumG001"><?php echo lang("Detección de Inactividad de sesión"); ?></span>
        <span id="NumG002"><?php echo lang("Si no responde a este mensaje la sesión se apagara en"); ?></span>
        <span id="NumG003"><?php echo lang("Tiempo Restante") . ":"; ?></span>
        <span id="NumG004"><?php echo lang("Hemos detectado inactividad en la sesión actual, ¿Usted desea continuar?."); ?></span>
        <span id="NumG005"><?php echo lang("No"); ?></span>
        <span id="NumG006"><?php echo lang("Si"); ?></span>
        <span id="NumG007"><?php echo lang("Se ha perdido la conexion de internet"); ?></span>
        <span id="NumG008"><?php echo lang("Se ha actualizado correctamente el archivo de idiomas"); ?></span>
        <span id="NumG009"><?php echo lang("Ha ocurrido un error al actualizar el archivo de idiomas"); ?></span>
        <span id="NumG010"><?php echo lang("Se ha eliminado correctamente el archivo de idiomas"); ?></span>
        <span id="NumG011"><?php echo lang("Ha ocurrido un error al eliminar el archivo de idiomas"); ?></span>
        <span id="NumG012"><?php echo lang("Archivo de idiomas"); ?></span>
        <span id="NumG013"><?php echo lang("Base"); ?></span>
        <span id="NumG014"><img width="18px" height="20px" src="/img/VE.png" /> <?php echo lang("Español Venezuela"); ?></span>
        <span id="NumG015"><img width="18px" height="20px" src="/img/CL.png" /> <?php echo lang("Español Chile"); ?></span>
        <span id="NumG016"><img width="18px" height="20px" src="/img/HN.png" /> <?php echo lang("Español Honduras"); ?></span>
        <span id="NumG017"><img width="18px" height="20px" src="/img/US.png" /> <?php echo lang("Ingles USA"); ?></span>
        <span id="NumG018"><img width="18px" height="20px" src="/img/US.png" /> <?php echo lang("Español USA"); ?></span>
        <span id="NumG019"><img width="18px" height="20px" src="/img/BR.png" /> <?php echo lang("Portugues Brasil"); ?></span>
        <span id="NumG020"><img width="18px" height="20px" src="/img/DE.png" /> <?php echo lang("Aleman Alemania"); ?></span>
        <span id="NumG021"><img width="18px" height="20px" src="/img/FR.png" /> <?php echo lang("Frances Francia"); ?></span>
        <span id="NumG022"><?php echo lang("Cerrar"); ?></span>
        <span id="NumG023"><?php echo lang("Guardar"); ?></span>
        <span id="NumG02"><?php echo lang(""); ?></span>
    <?php

    }
    if ($_POST["Ini"] == "1") {
    ?>
        <span id="NumBaGeneral001"><strong><i class="fa fa-search"></i> <?php echo lang('Formato no encontrado'); ?></strong><br><?php echo lang("No existe formato establecido para esta transaccion"); ?></span>
        <span id="NumBaGeneral002"><?php echo lang("El correo ingresado es invalido"); ?></span>
        <span id="NumBaGeneral003"><?php echo lang("El correo fue enviado correctamente"); ?></span>
        <span id="NumBaGeneral004"><?php echo lang("Hubo un error en el envio del correo"); ?></span>

        <span id="NumBaGeneral005"><strong><i class="fa fa-info-circle"></i> <?php echo lang('Falta Informacion'); ?></strong><br><?php echo lang('El campo "contraseña" no puede estar vacío.'); ?></span>
        <span id="NumBaGeneral006"><strong><i class="fa fa-info-circle"></i> <?php echo lang('Falta Informacion'); ?></strong><br><?php echo lang("Seleccione al menos un Precio entre Precio 1 , Precio 2 o Precio 3."); ?></span>
        <span id="NumBaGeneral007"><strong><i class="fa fa-info-circle"></i> <?php echo lang('Falta Informacion'); ?></strong><br><?php echo lang("Seleccione al menos una Unidad"); ?></span>
        <span id="NumBaGeneral008"><strong><i class="fa fa-info-circle"></i> <?php echo lang('Falta Informacion'); ?></strong><br><?php echo lang('El campo "login" no puede estar vacío.'); ?></span>
        <span id="NumBaGeneral009"><strong><i class="fa fa-info-circle"></i> <?php echo lang('Falta Informacion'); ?></strong><br><?php echo lang('El campo "nombre" no puede estar vacío.'); ?></span>
        <span id="NumBaGeneral010"><strong><i class="fa fa-info-circle"></i> <?php echo lang('Falta Informacion'); ?></strong><br><?php echo lang('El campo "correo" no puede estar vacío.'); ?></span>
        <span id="NumBaGeneral011"><strong><i class="fa fa-info-circle"></i> <?php echo lang('Falta Informacion'); ?></strong><br><?php echo lang('El campo "contraseña" no puede estar vacío.'); ?></span>
        <span id="NumBaGeneral012"><strong><i class="fa fa-question-circle"></i> <?php echo lang('No puede estar en negativo'); ?></strong><br><?php echo lang("El campo % comisión por venta no puede estar en negativo."); ?></span>
        <span id="NumBaGeneral013"><strong><i class="fa fa-question-circle"></i> <?php echo lang('No puede estar en negativo'); ?></strong><br><?php echo lang("El campo % comisión por cobro no puede estar en negativo."); ?></span>
        <span id="NumBaGeneral014"><strong><i class="fa fa-question-circle"></i> <?php echo lang('Login existente'); ?></strong><br><?php echo lang("El login ingresado ya existe."); ?></span>
        <span id="NumBaGeneral015"><strong><i class="fa fa-info-circle"></i> <?php echo lang('Falta Informacion'); ?></strong><br><?php echo lang('El campo "tipo" no puede estar vacío.'); ?></span>
        <span id="NumBaGeneral016"><strong><i class="fa fa-question-circle"></i> <?php echo lang('Ubicacion Inválida'); ?></strong><br><?php echo lang("Cree o elija una ubicación valida."); ?></span>
        <span id="NumBaGeneral017"><strong><i class="fa fa-info-circle"></i> <?php echo lang('Falta Informacion'); ?></strong><br><?php echo lang('El campo "valor" no puede estar vacío.'); ?></span>
        <span id="NumBaGeneral018"><strong><i class="fa fa-question-circle"></i> <?php echo lang('Caracteres Inválidos'); ?></strong><br><?php echo lang("El código de barras, S.K.U o la descripción estan utilizando caracteres no válidos."); ?></span>
        <span id="NumBaGeneral019"><strong><i class="fa fa-question-circle"></i> <?php echo lang('S.K.U Repetido'); ?></strong><br><?php echo lang("El código S.K.U no se puede repetir."); ?></span>
        <span id="NumBaGeneral021"><strong><i class="fa fa-info-circle"></i> <?php echo lang('Falta Informacion'); ?></strong><br><?php echo lang('Por favor inserte el código S.K.U y el código de barras.'); ?></span>
        <span id="NumBaGeneral022"><strong><i class="fa fa-question-circle"></i> <?php echo lang('Código Repetido'); ?></strong><br><?php echo lang("No puede repetir el mismo código en este Producto."); ?></span>
        <?php
    }
}

if ($_POST["Accion"] === "VerificarFiscal") {
    include "ambiente.php";
    $conn = conectar();
    echo json_encode(VerificarFiscal($conn, $_POST), JSON_UNESCAPED_UNICODE);
}

if ($_POST["Accion"] == "1") {
    if (trim($_SESSION["CompanyActual"]) == "") {
        echo "1";
    } else {
        echo "0";
    }
}

if ($_POST["Action"] === "TrasladosActive") {
    include "ambienteconsultas.php";
    $conn = conectar();
    echo TrasladoActive($conn, $_POST);
}

if ($_POST["Action"] === "DemosEnd") {
    include "ambiente.php";
    $conn = conectar();
    session_start();
    echo DemosEnd($conn, $_POST);
}
/*
if ($_POST["Action"] === "LetsStockMonth") {
    include "ambiente.php";
    $conn = conectar();
    session_start();

    $_SESSION["PeriodoStock"] = $_POST["today"];
    // echo json_encode(["status" => true]);
    echo LetsStockMonth($conn, $_POST);
}
*/

if ($_POST["Action"] === "ImprimirFormato") {
    if (!isset($_SESSION["TemporalFactura"])) {
        include "ambiente.php";
        $conn = conectar();
        session_start();
    } else {
        $_SESSION["TemporalFactura"] = "";
    }
    if (isset($_POST["Idtx"])) {
        $Idtx = $_POST["Idtx"];
    } else {
        $query = "SELECT numfactura FROM PosUpCompanyEstacion where token='" . $_POST['IdEstacion'] . "'";
        if ($result = mysqli_query($conn, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $Idtx = $row["numfactura"];
            }
        }
    }
    $query = "SELECT a.etiqueta,b.IdUbi FROM PosUpCompanyEstacion a left join PosUpAlmacen b on b.IdAlm = a.IdAlmVta and a.IdCompany = b.IdCompany where a.token='" . $_POST["IdEstacion"] . "' and a.IdCompany = " . $_POST["CompanyActual"] . "";
    if ($result = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $etiqueta = $row["etiqueta"];
            $IdUbi = $row["IdUbi"];
        }
    }
    $src = "";
    if ($IdUbi <> 0) {
        $scanpath = scandir("Comercio/" . $_POST["CompanyActual"] . "/sucursal");
        foreach ($scanpath as $item) {
            if ($item != '.' and $item != '..') {
                $file_name = explode(".", $item);
                $Mbooking_number = "sucursal" . $IdUbi;
                if ($file_name[0] == $Mbooking_number) {
                    $src = "Comercio/" . $_POST["CompanyActual"] . "/sucursal" . "/" . $item;
                }
            }
        }
    }
    if (trim($src) == "") {
        $directorio_escaneado = scandir("Comercio/" . $_POST["CompanyActual"] . "/entorno");
        foreach ($directorio_escaneado as $item) {
            if ($item != '.' and $item != '..') {
                $nnn = preg_split('/_/', $item);
                $Mbooking_number = "Logotipo";
                if ($nnn[0] == $Mbooking_number) {
                    $src = "Comercio/" . $_POST["CompanyActual"] . "/entorno" . "/" . $item;
                }
            }
        }
    }
    if (trim($src) == "") {
        $src = "img/ISO_AMARILLO.svg";
    }


    $query = "SELECT sum(a.Efectivo) as Efectivo,sum(a.Vuelto) as Vuelto,sum(a.Cheque) as Cheque,sum(a.Tarjeta) as Tarjeta,sum(a.Tipo01) as Tipo01,sum(a.Tipo02) as Tipo02,sum(a.Tipo03) as Tipo03,sum(a.Tipo04) as Tipo04 FROM PosUpTxP a WHERE a.IdCompany=" . $_POST["CompanyActual"] . " and a.Idtipotx=" . $_POST["Idtipotx"] . " and a.Idtx=" . $Idtx . " and a.IdEstacion='" . $_POST["IdEstacion"] . "'";
    if ($result = mysqli_query($conn, $query)) {
        $Efectivo = 0;
        $Vuelto = 0;
        $TEfectivo = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $Efectivo = $row['Efectivo'];
            $Vuelto = $row['Vuelto'];
            $Tefectivo = $Efectivo - $Vuelto;
            $Cheque = $row['Cheque'];
            $Tarjeta = $row['Tarjeta'];
            $Tipo01 = $row['Tipo01'];
            $Tipo02 = $row['Tipo02'];
            $Tipo03 = $row['Tipo03'];
            $Tipo04 = $row['Tipo04'];
        }
        mysqli_free_result($result);
    }
    $stail = 'style="height: 660px;"';

    $query = "SELECT x.IdAlmVta,e.CD,e.SimDec,e.SimMil,e.litfiscal,if(if(a.Idtipotx in (1,2,3,4,5,6,11,12,13,15,21,22,23,24,25,26,31,35,36,37),e.NumTxViewVTA,if(a.Idtipotx in (7,14,20,27,28),e.NumTxViewCOM,if(a.Idtipotx in (8,9,10,16,17,18,19,29,30,32,33,34,39),e.NumTxViewINV,''))) = 0,a.IdtxCompany,if(if(a.Idtipotx in (1,2,3,4,5,6,11,12,13,15,21,22,23,24,25,26,31,35,36,37),e.NumTxViewVTA,if(a.Idtipotx in (7,14,20,27,28),e.NumTxViewCOM,if(a.Idtipotx in (8,9,10,16,17,18,19,29,30,32,33,34,39),e.NumTxViewINV,''))) = 1,a.Idtx,a.Referencia)) as IdtxDef,a.DTE,e.MonedaS,a.tasa,e.IdPais,a.Dcto,a.Items,a.DAmpliado,e.Comercio,e.giroco as GiroComercial,c.giro as GiroCl,c.ciudad as CiudadCl,e.direccion as DirComercio,e.Telefono,e.correorep,b.TituloFe,a.excento,a.imponible,a.impuesto,e.MonedaP,a.SubTotal,a.DctoAplicado,a.Total,c.email,c.Comuna,a.IdBen,c.Fono,c.Direccion as BeneDireccion,c.Nombre as Beneficiario,DATE_FORMAT(a.TxfecVence,'%d/%m/%Y') as TxfecVence,DATE_FORMAT(a.Fectxclient,'%d/%m/%Y') as Fectxclient,a.Contado,a.Credito,d.Nombre as Usuario,f.Nombre as Vendedor,e.IDFiscal,b.Titulo,b.TitCto,a.IdTxCompany,a.Referencia 
    FROM PosUpTxC a 
    left join PosUpTx b on b.Idtipotx = a.Idtipotx 
    left join PosUpclientes c on c.RUT = a.IdBen and a.IdCompany = c.IdCompany 
    left join PosUpUsers d on d.login = a.IdUser and a.IdCompany = d.IdCompany 
    left join PosUpCompany e on e.Id=a.IdCompany 
    left join PosUpUsers f on f.Login=a.UserVendedor and a.IdCompany=f.IdCompany 
    left join PosUpCompanyEstacion x on x.token = a.IdEstacion and a.IdCompany = x.IdCompany 
    WHERE a.IdCompany=" . $_POST["CompanyActual"] . " and a.Idtipotx=" . $_POST["Idtipotx"] . " and a.Idtx=" . $Idtx . " and a.IdEstacion='" . $_POST["IdEstacion"] . "'";

    if ($result = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $IdPais = $row["IdPais"];
            $IdAlmVta = $row["IdAlmVta"];
            $tasa = $row["tasa"];
            $DAmpliado = $row["DAmpliado"];
            $Cliente = $row["Beneficiario"];
            $CiudadCl = $row["CiudadCl"];
            $GiroCl = $row["GiroCl"];
            $Usuario = $row["Usuario"];
            $DirCl = $row["BeneDireccion"];
            $IdenCl = $row["IdBen"];
            $CD = $row["CD"];
            $MonedaP = $row["MonedaP"];
            $MonedaS = $row["MonedaS"];
            $SimMil = $row["SimMil"];
            $SimDec = $row["SimDec"];
            $item = $row["Items"];
            $Dcto = $row["Dcto"];
            $litfiscal = $row["litfiscal"];

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
            $IdtxDef = $row['IdtxDef'];
            $Referencia = $row['Referencia'];
            $Beneficiario = $row['Beneficiario'];
            $BeneDireccion = $row['BeneDireccion'];
            $Fono = $row['Fono'];
            $email = $row['email'];
            $Fectxclient = $row['Fectxclient'];
            $Credito = $row['Credito'];
            $Contado = $row['Contado'];
            $TxfecVence = $row['TxfecVence'];
            $Usuario = $row['Usuario'];
            $excento = $row['excento'];
            $Imponible = $row['imponible'];
            $Impuesto = $row['impuesto'];
            $SubTotal = $row['SubTotal'];
            $Total = $row['Total'];
            $DctoAplicado = $row['DctoAplicado'];
            $IdBen = $row['IdBen'];
            $NombrePag = $row["Titulo"] . " - " . str_pad($row["IdtxDef"], 6, "0", STR_PAD_LEFT) . " - " . $IdBen . " - " . $Beneficiario;
            if ($DTE !== 0) {
                $IdtxDef = $DTE;
                $NombrePag = $row["Titulo"] . " - " . str_pad($DTE, 6, "0", STR_PAD_LEFT) . " - " . $IdBen . " - " . $Beneficiario;
            }
        }
        mysqli_free_result($result);
    }

    $IGTF = 0;
    if ($IdPais == "VE") {
        $IGTF = $Tipo01 * 0.03;
    }

    if ($tasa < 1) {
        $tasa = 1;
    }
    if ($tasa > 1) {
        $Moneda = $MonedaS;
    } else {
        $Moneda = $MonedaP;
    }
    if (($Impuesto > 0) and ($Imponible > 0)) {
        $IVA = ($Impuesto / $Imponible) * 100;
        if (is_nan($IVA)) {
            $IVA = 0;
        }
    } else {
        $IVA = 0;
    }
    include("" . $_POST["Format"]);
}

if ($_POST["Action"] === "form") {
    include "ambienteconsultas.php";
    $conn = conectar();
    echo ImpresionData($conn, $_POST);
}

if ($_POST["Action"] === "TrasladosUpdate") {
    include "ambiente.php";
    $conn = conectar();
    echo TrasladosUpdate($conn, $_POST);
}
/*

function LetsStockMonth($conn, $post)
{


    $sql = "insert
	into
	posup.posupproductostockmes
    (IdCompany,
        Periodo,
        CodIdBasico,
        Seriales,
        IdAlm,
        Cantidad)
    select
        *
    from
        (
        select
            a.IdCompany,
            concat(year(a.Fectxclient), LPAD(month(a.Fectxclient), 2, '0')) as Periodo,
            a.CodIdBasico,
            a.Seriales,
            a.IdAlm ,
            sum(a.Cant * d.Inventario) as Cantidad2
        from
            PosUpTxD a
        inner join PosUpTx d on
            a.Idtipotx = d.Idtipotx
            and (d.Inventario <> 0)
        where
            concat(year(a.Fectxclient), LPAD(month(a.Fectxclient), 2, '0'))<concat(year(now()), LPAD(month(now()), 2, '0' )) and a.IdCompany = " . $post["CompanyActual"] . "
        group by
            year(a.Fectxclient),
            month(a.Fectxclient),
            a.CodIdBasico,
            a.IdAlm,
            a.Seriales
            ) as dt on
        DUPLICATE key
    update
	Cantidad = Cantidad2;";
    $result = mysqli_query($conn, $sql);

    if ($result) {

        $sql = "delete from posupproductostockmesT where idcompany = " . $post["CompanyActual"] . "";
        $result = mysqli_query($conn, $sql);

        $sql = "insert into posupproductostockmesT (IdCompany,Periodo,CodIdBasico,Seriales,IdAlm,Cantidad) 
        (SELECT IdCompany,max(Periodo) as Periodo,CodIdBasico,Seriales,IdAlm,sum(Cantidad) as Cantidad FROM posup.posupproductostockmes
        where idcompany = " . $post["CompanyActual"] . "
        group by IdCompany,CodIdBasico,IdAlm,Seriales)";

        $result = mysqli_query($conn, $sql);
        $_SESSION["PeriodoStock"] = $_POST["today"];
        return json_encode(["status" => true]);
    }

    return json_encode(["status" => false]);
}
*/
function DemosEnd($conn, $post)
{

    try {
        // 1) Sanitizar e iniciar
        $companyId = isset($_POST['CompanyActual']) ? (int)$_POST['CompanyActual'] : 0;
        if ($companyId <= 0) {
            echo json_encode(["status" => false, "error" => "CompanyActual inválido"]);
            exit;
        }

        // Opcional: fijar zona horaria a nivel de sesión DB si te interesa coherencia
        // $conn->query("SET time_zone = '-04:00'");

        // 2) Iniciar transacción
        $conn->begin_transaction();

        // 3) Calcular delta una sola vez
        $sqlDelta = "SELECT COALESCE(DATEDIFF(CURDATE(), MAX(Fectxclient)), 0) AS dias
                 FROM posuptxc
                 WHERE IdCompany = ?";
        $stmt = $conn->prepare($sqlDelta);
        $stmt->bind_param("i", $companyId);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        $dias = (int)$row['dias'];
        $stmt->close();

        // Si no hay nada que mover, confirmamos y salimos "ok"
        if ($dias === 0) {
            $_SESSION["esDemo"] = '0';
            $conn->commit();
            echo json_encode(["status" => true, "delta" => 0, "rows" => ["posuptxd" => 0, "posuptxp" => 0, "posuptxc" => 0]]);
            exit;
        }

        // 4) Preparar updates reutilizando el mismo delta
        // posuptxd
        $sql1 = "UPDATE posuptxd
             SET fectxclient = fectxclient + INTERVAL ? DAY
             WHERE IdCompany = ? AND fectxclient IS NOT NULL";
        $u1 = $conn->prepare($sql1);
        $u1->bind_param("ii", $dias, $companyId);
        $u1->execute();
        $rows1 = $u1->affected_rows;
        $u1->close();

        // posuptxp
        $sql2 = "UPDATE posuptxp
             SET fectxclient = fectxclient + INTERVAL ? DAY
             WHERE IdCompany = ? AND fectxclient IS NOT NULL";
        $u2 = $conn->prepare($sql2);
        $u2->bind_param("ii", $dias, $companyId);
        $u2->execute();
        $rows2 = $u2->affected_rows;
        $u2->close();

        // posuptxc (incluye TxfecVence, preservando NULL)
        $sql3 = "UPDATE posuptxc
             SET fectxclient = fectxclient + INTERVAL ? DAY,
                 TxfecVence  = CASE
                                 WHEN TxfecVence IS NOT NULL
                                   THEN TxfecVence + INTERVAL ? DAY
                                 ELSE NULL
                               END
             WHERE IdCompany = ? AND fectxclient IS NOT NULL";
        $u3 = $conn->prepare($sql3);
        $u3->bind_param("iii", $dias, $dias, $companyId);
        $u3->execute();
        $rows3 = $u3->affected_rows;
        $u3->close();

        // 5) Commit y respuesta
        $conn->commit();
        $_SESSION["esDemo"] = '0';

        echo json_encode([
            "status" => true,
            "delta"  => $dias,
            "rows"   => ["posuptxd" => $rows1, "posuptxp" => $rows2, "posuptxc" => $rows3]
        ]);
    } catch (Throwable $e) {
        // Rollback seguro y error detallado
        if ($conn && $conn->errno === 0) { // si no hay error de conexión
            $conn->rollback();
        }
        echo json_encode([
            "status" => false,
            "error"  => "Exception: " . $e->getMessage()
        ]);
    }
}

function ImpresionData($conn, $post)
{
    if ($post["Idtipotx"] == 1) {
        $ttx = "numboleta";
    }
    if ($post["Idtipotx"] == 2) {
        $ttx = "numfactura";
    }
    if ($post["Idtipotx"] == 3) {
        $ttx = "numdevo";
    }
    if ($post["Idtipotx"] == 4) {
        $ttx = "numentcja";
    }
    if ($post["Idtipotx"] == 5) {
        $ttx = "numsalcja";
    }
    if ($post["Idtipotx"] == 6) {
        $ttx = "numarq";
    }
    if ($post["Idtipotx"] == 7) {
        $ttx = "numcom";
    }
    if ($post["Idtipotx"] == 8) {
        $ttx = "numaju";
    }
    if ($post["Idtipotx"] == 9) {
        $ttx = "nummovi";
    }
    if ($post["Idtipotx"] == 10) {
        $ttx = "numtoma";
    }
    if ($post["Idtipotx"] == 11) {
        $ttx = "numpedido";
    }
    if ($post["Idtipotx"] == 12) {
        $ttx = "numpre";
    }
    if ($post["Idtipotx"] == 13) {
        $ttx = "numcaja";
    }
    if ($post["Idtipotx"] == 14) {
        $ttx = "numoc";
    }
    if ($post["Idtipotx"] == 15) {
        $ttx = "numnota";
    }
    if ($post["Idtipotx"] == 16) {
        $ttx = "numcc";
    }
    if ($post["Idtipotx"] == 17) {
        $ttx = "numtra";
    }
    if ($post["Idtipotx"] == 18) {
        $ttx = "numcar";
    }
    if ($post["Idtipotx"] == 19) {
        $ttx = "numdes";
    }
    if ($post["Idtipotx"] == 20) {
        $ttx = "NoProcesar"; //Orden de Compra Anulada
    }
    if ($post["Idtipotx"] == 21) {
        $ttx = "NoProcesar"; //Boleta Manual
    }
    if ($post["Idtipotx"] == 22) {
        $ttx = "numnec"; //Guia de Despacho
    }
    if ($post["Idtipotx"] == 23) {
        $ttx = "NoProcesar"; //Pedido Anulada
    }
    if ($post["Idtipotx"] == 24) {
        $ttx = "numces";
    }
    if ($post["Idtipotx"] == 25) {
        $ttx = "numanticipo";
    }

    if ($post["Idtipotx"] == 27) {
        $ttx = "numcompdev";
    }

    if ($post["Idtipotx"] == 30) {
        $ttx = "numprod";
    }

    if ($post["Idtipotx"] == 31) {
        $ttx = "numnotacred";
    }

    if ($post["Idtipotx"] == 32) {
        $ttx = "numplain";
    }

    if ($post["Idtipotx"] == 36) {
        $ttx = "numcajon";
    }

    if ($post["Idtipotx"] == 39) {
        $ttx = "numop";
    }

    if ($post["Idtipotx"] == 41) {
        $ttx = "numreturn";
    }


    if ($post["Idtipotx"] == 44) {
        $ttx = "numnotadeb";
    }


    if (isset($post["Idtx"])) {
        $SupuestoIdtx = trim($post["Idtx"]);
    } else {
        $SupuestoIdtx = "c." . $ttx;
    }

    $query = "SELECT b.FormaFac,b.FormaBol,b.FormaGuia,b.FormaNote,b.FormaMovi,b.FormPedid,b.FormOCCompra,b.FormPresu,b.FormaOC,a.IdtipotxPadre FROM PosUpTxC a left join PosUpAlmacen b on b.IdAlm = a.IdAlmO and a.IdCompany = b.IdCompany left join PosUpCompanyEstacion c on c.token = a.IdEstacion and a.IdCompany = c.IdCompany WHERE a.IdCompany=" . trim($post["CompanyActual"]) . " and a.Idtipotx=" . $post['Idtipotx'] . " and a.Idtx=" . $SupuestoIdtx . " and a.IdEstacion='" . trim($post["IdEstacion"]) . "'";
    if ($result = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $FormaFac = $row["FormaFac"];
            $FormaBol = $row["FormaBol"];
            $FormaGuia = $row["FormaGuia"];
            $FormaNote = $row["FormaNote"];
            $FormPedid = $row["FormPedid"];
            $FormPresu = $row["FormPresu"];
            $FormaOC = $row["FormaOC"];
            $IdtipotxPadre = $row["IdtipotxPadre"];
        }

        if ($post["Idtipotx"] === "31" or $post["Idtipotx"] === "44") {
            $IdtipotxPadre = "";
        }

        $FormaFac = explode(";", $FormaFac);
        $FormaBol = explode(";", $FormaBol);
        $FormaGuia = explode(";", $FormaGuia);
        $FormaNote = explode(";", $FormaNote);
        $FormPedid = explode(";", $FormPedid);
        $FormPresu = explode(";", $FormPresu);
        $FormaOC = explode(";", $FormaOC);

        if (trim($post["Idtipotx"]) === "1") {
            if (count($FormaBol) > 1) return json_encode(["status" => true, "response" => $FormaBol], JSON_UNESCAPED_UNICODE);
            return json_encode(["status" => false, "response" => $FormaBol], JSON_UNESCAPED_UNICODE);
        } else if (trim($post["Idtipotx"]) === "2" || trim($IdtipotxPadre) === "2") {
            if (count($FormaFac) > 1) return json_encode(["status" => true, "response" => $FormaFac], JSON_UNESCAPED_UNICODE);
            return json_encode(["status" => false, "response" => $FormaFac], JSON_UNESCAPED_UNICODE);
        } else if (trim($post["Idtipotx"]) === "11") {
            if (count($FormPedid) > 1) return json_encode(["status" => true, "response" => $FormPedid], JSON_UNESCAPED_UNICODE);
            return json_encode(["status" => false, "response" => $FormPedid], JSON_UNESCAPED_UNICODE);
        } else if (trim($post["Idtipotx"]) === "12") {
            if (count($FormPresu) > 1) return json_encode(["status" => true, "response" => $FormPresu], JSON_UNESCAPED_UNICODE);
            return json_encode(["status" => false, "response" => $FormPresu], JSON_UNESCAPED_UNICODE);
        } else if (trim($post["Idtipotx"]) === "14") {
            if (count($FormaOC) > 1) return json_encode(["status" => true, "response" => $FormaOC], JSON_UNESCAPED_UNICODE);
            return json_encode(["status" => false, "response" => $FormaOC], JSON_UNESCAPED_UNICODE);
        } else  if (trim($post["Idtipotx"]) === "15" || trim($IdtipotxPadre) === "15") {
            if (count($FormaNote) > 1) return json_encode(["status" => true, "response" => $FormaNote], JSON_UNESCAPED_UNICODE);
            return json_encode(["status" => false, "response" => $FormaNote], JSON_UNESCAPED_UNICODE);
        } elseif (trim($post["Idtipotx"]) === "22" || trim($IdtipotxPadre) === "22") {
            if (count($FormaGuia) > 1) return json_encode(["status" => true, "response" => $FormaGuia], JSON_UNESCAPED_UNICODE);
            return json_encode(["status" => false, "response" => $FormaGuia], JSON_UNESCAPED_UNICODE);
        } else {
            return json_encode(["status" => false], JSON_UNESCAPED_UNICODE);
        }
    }


    return json_encode(["status" => false], JSON_UNESCAPED_UNICODE);
}

function TrasladoActive($conn, $post)
{
    /*
    $IdAlmVta = "0";
    $query = "SELECT IdAlmVta FROM PosUpCompanyEstacion WHERE IdCompany=" . $post["CompanyActual"] . " and token='" . trim($post["TokenSeleccionado"]) . "'";
    if ($result = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $IdAlmVta = $row['IdAlmVta'];
        }
        mysqli_free_result($result);
    }

    if ($IdAlmVta === "0") return json_encode(["status" => false, "response" => []]);
    */
    $IdUbic = "0";
    $query = "SELECT IdUbic FROM posupusers WHERE IdCompany=" . $post["CompanyActual"] . " and Login='" . trim($post["userlogin"]) . "'";
    if ($result = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $IdUbic = $row['IdUbic'];
        }
        mysqli_free_result($result);
    }
    $response = [];
    if ($IdUbic === "0") return json_encode(["status" => false, "response" => []]);
    $query = "select
        a.IdCompany,
        a.Idtipotx,
        a.IdEstacion,
        a.Idtx,
        a.IdBarcode,
        a.DetalleDTE
    from
        posuptxc a
    inner join posupalmacen b on
        b.IdAlm = a.IdAlmD
        and b.IdCompany = a.IdCompany
    where a.IdCompany=" . $post["CompanyActual"] . " 
    and b.IdUbi=" . $IdUbic . " 
    and a.Idtipotx = 17 
    and a.Fectxclient >= '" . $post["date"] . "'";
    if ($result = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $IdCompany = $row['IdCompany'];
            $Idtipotx = $row['Idtipotx'];
            $Idtx = $row['Idtx'];
            $IdEstacion = $row['IdEstacion'];
            $IdBarcode = $row['IdBarcode'];
            $DetalleDTE = json_decode($row['DetalleDTE'], true);
            $calc = array_filter($DetalleDTE, function ($v) use ($post) {
                return $v == $post["userlogin"];
            }, ARRAY_FILTER_USE_BOTH);

            if (empty($calc)) $response[] = [
                "IdCompany" => $IdCompany,
                "Idtipotx" => $Idtipotx,
                "Idtx" => $Idtx,
                "IdEstacion" => $IdEstacion,
                "IdBarcode" => $IdBarcode,
            ];
        }
        mysqli_free_result($result);
    }

    if (!empty($response)) return json_encode(["status" => true, "response" => $response]);

    return json_encode(["status" => false, "response" => []]);
}

function TrasladosUpdate($conn, $post)
{
    $DetalleDTE = [];
    $query = "SELECT DetalleDTE FROM posuptxc WHERE IdCompany=" . $post["CompanyActual"] . " and IdBarcode = '" . $post["IdBarcode"] . "'";
    if ($result = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $DetalleDTE = $row['DetalleDTE'];
        }
        mysqli_free_result($result);
    }

    $DetalleDTE = json_decode($DetalleDTE, true);

    $DetalleDTE[] = $post['userlogin'];

    $query = "UPDATE posuptxc set DetalleDTE = '" . json_encode($DetalleDTE, JSON_UNESCAPED_UNICODE) . "'  WHERE IdCompany=" . $post["CompanyActual"] . " and IdBarcode = '" . $post["IdBarcode"] . "'";
    $result = mysqli_query($conn, $query);

    return json_encode(["status" => $result]);
}

function StockNone($conn, $post, $request)
{
    $col = array(
        0   =>  'a.CodIdBasico,a.CodIdAmpliado,a.CodBarra,a.Descripcion',
    );

    $search = " and a.CodIdBasico in (" . implode(",", json_decode($post["implode"], true)) . ")";
    $sql = "SELECT count(a.IdCompany) as counta FROM PosUpProducto a WHERE a.IdCompany=" . $post["CompanyActual"] . " and a.Estado=1 " . $search;

    $query = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($query)) {
        $totalData = $row["counta"];
    }

    if (!empty($request['search']['value'])) {
        $sql .= " AND (a.Descripcion Like '%" . $request['search']['value'] . "%' ";
        $sql .= " OR a.CodBarra Like '%" . $request['search']['value'] . "%' ";
        $sql .= " OR a.Envase Like '%" . $request['search']['value'] . "%' ";
        $sql .= " OR a.CodIdAmpliado Like '%" . $request['search']['value'] . "%' )";
    }

    $query = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($query)) {
        $totalFilter = $row["counta"];
    }
    $sql = "SELECT a.min,GROUP_CONCAT(h.almacen ORDER BY h.almacen ASC) as Almcacen,GROUP_CONCAT(h.idalm ORDER BY h.almacen ASC) as idalmA,
    sum(h.cantidad) as existotal,
    GROUP_CONCAT(h.Cantidad ORDER BY h.almacen ASC) as Cantidad,a.*,g.ITEM as ImpuestoName,(g.VALOR*100) as ImpuestoPorcentaje,b.nombre as Marcaxd,
    c.esmedida,c.ITEM as Familia,c.esserial,d.AllExistencia  
    FROM PosUpProducto a 
    left join PosUpc_marcas b on a.IdCompany = b.IdCompany and a.Marca = b.idmarca 
    left join PosUpvarios c on a.IdCompany = c.IdCompany and a.Idfamilia = c.IdVarios and c.TIPOITEM = 2
    left join  PosUpCompany d on d.Id=a.IdCompany
    left join PosUpvarios g on a.IdCompany = g.IdCompany and a.Impuesto = g.IdVarios and g.TIPOITEM = 0
    left join (
    SELECT a.CodIdBasico, a.idalm,c.nombre as Almacen,sum(a.Cant*d.Inventario) as Cantidad
    from PosUpTxD a  
    left join PosUpAlmacen c on a.IdCompany=c.IdCompany and a.IdAlm=c.IdAlm and c.tipo <> 3 
    left join PosUpTx d on a.Idtipotx=d.Idtipotx
    where a.IdCompany=" . $post["CompanyActual"] . "
    group by a.IdCompany,a.CodIdBasico,a.IdAlm
    ) h on a.CodIdBasico = h.codidbasico
    where  a.IdCompany=" . $post["CompanyActual"] . " and a.Estado=1    " . $search;
    if (!empty($request['search']['value'])) {
        $sql .= " AND (a.Descripcion Like '%" . $request['search']['value'] . "%' ";
        $sql .= " OR a.CodBarra Like '%" . $request['search']['value'] . "%' ";
        $sql .= " OR a.Envase Like '%" . $request['search']['value'] . "%' ";
        $sql .= " OR a.CodIdAmpliado Like '%" . $request['search']['value'] . "%' )";
    }
    $sql .= " group by a.IdCompany,a.CodIdBasico  ORDER BY " . $col[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'] . "  LIMIT " .
        $request['start'] . "  ," . $request['length'] . "  ";
    $query = mysqli_query($conn, $sql);
    $data = array();
    $n = 0;
    while ($row = mysqli_fetch_array($query)) {
        $subdata = array();
        $almacenes = explode(",", $row["idalmA"]);
        $almacenesName = explode(",", $row["Almcacen"]);
        $almacenesCantidad = explode(",", $row["Cantidad"]);

        $n++;
        $PosStock = "";
        $Cantotal = 0;
        $path = "Comercio/" . $post["CompanyActual"] . "/productos";
        $images2 = "";
        $images2x = [];
        if (file_exists($path)) {
            $directorio_escaneado = scandir($path);
            if (is_array($directorio_escaneado)) {
                $hhh = 0;
                foreach ($directorio_escaneado as $item) {
                    if ($item != '.' and $item != '..') {
                        $nnn = preg_split('/_/', $item);
                        if ($nnn[0] == trim($row["CodIdBasico"])) {
                            $hhh += 1;
                            $images2x[] = "Comercio/" . $post["CompanyActual"] . "/productos/" . $item;
                            $images2 .= "
                                <div class='carousel-item " . ($hhh == 1 ? "active" : "") . "' style='width: 50px;'>
                                    <img src='Comercio/" . $post["CompanyActual"] . "/productos/" . $item . "' class='d-block w-100' alt='...' />
                                </div>
                            ";
                        }
                    }
                }
            } else {
                $images2x[] = "../img/no-photo-available2.png";
            }
        }

        if (empty($images2x)) {
            $images2x[] = "/img/no-photo-available2.png";
            $images2 .= "
                <div class='carousel-item active' style='width: 50px;'>
                    <img src='img/no-photo-available2.png' class='d-block w-100' alt='...' />
                </div>
            ";
        }

        $Hashtags = "";
        $array = explode("|", $row["Envase"]);
        if (is_array($array)) {
            foreach ($array as $key => $val) {
                if (trim($val) <> "") {
                    $Hashtags .= "<span class='badge bg-light text-dark p-1 m-1'><i class='fa fa-tag'></i> " . $val . "</span>";
                }
            }
        }
        if (trim($Hashtags) <> "") {
            $Hashtags = "<br>" . $Hashtags;
        }
        $n = 0;
        foreach ($almacenes as $almacen) {
            if ($almacenesCantidad[$n] <= $row["min"]) {
                $PosStock .= "<div class='d-flex align-items-center gap-2 mb-1 text-wrap'><span class='badge bg-danger text-light'>" . $almacenesName[$n] . "</span> <span class='badge bg-danger text-light'>" . ($row["factorunit"] <> 1 && $row["factorunit"] <> 0 ? " " . $row["factorunit"] . " x " . getcantformat($almacenesCantidad[$n], $post["CD"], $post["SimDec"], $post["SimMil"]) . " = " . getcantformat($almacenesCantidad[$n] * $row["factorunit"], $post["CD"], $post["SimDec"], $post["SimMil"]) : getcantformat($almacenesCantidad[$n], $post["CD"], $post["SimDec"], $post["SimMil"])) . " " . $row["Medida"] . " <i class='fa fa-check'></i></span></div>";
            } else {
                $PosStock .= "<div class='d-flex align-items-center gap-2 mb-1 text-wrap'><span class='badge bg-light text-dark'>" . $almacenesName[$n] . "</span> <span class='badge bg-warning text-dark'>" . ($row["factorunit"] <> 1 && $row["factorunit"] <> 0 ? " " . $row["factorunit"] . " x " . getcantformat($almacenesCantidad[$n], $post["CD"], $post["SimDec"], $post["SimMil"]) . " = " . getcantformat($almacenesCantidad[$n] * $row["factorunit"], $post["CD"], $post["SimDec"], $post["SimMil"]) : getcantformat($almacenesCantidad[$n], $post["CD"], $post["SimDec"], $post["SimMil"])) . " " . $row["Medida"] . "</span></div>";
            }
            $Cantotal = $Cantotal + round($almacenesCantidad[$n], 3);
            $n++;
        }
        if ($Cantotal == 0) {
            $PosStock = "<span class='badge bg-danger text-light'>" . lang("Agotada") . "</span></br>";
        }


        $Medida = '';
        $Medida = $row["Medida"];
        $UnidadP1 = $row["UnidadP1"];
        $UnidadP2 = $row["UnidadP2"];
        $UnidadP4 = $row["UnidadP4"];

        if ($Medida <> '') {
            $Medida = "<span class='badge bg-success text-white'>" . $row["Medida"] . "</span>";
        }

        if ($UnidadP1 <> '') {
            $UnidadP1 = "<span class='badge bg-success text-white'>" . $row["UnidadP1"] . ($row["CantP1"] == 1 ? "" : " (" . $row["CantP1"] . ")") . "</span>";
        }

        if ($UnidadP2 <> '') {
            $UnidadP2 = "<span class='badge bg-success text-white'>" . $row["UnidadP2"] . ($row["CantP2"] == 1 ? "" : " (" . $row["CantP2"] . ")") . "</span>";
        }

        if ($UnidadP4 <> '') {
            $UnidadP4 = "<span class='badge bg-success text-white'>" . $row["UnidadP4"] . ($row["CantP4"] == 1 ? "" : " (" . $row["CantP4"] . ")") . "</span>";
        }
        $PosPVP = "";


        $images = "
        " . ($images2 !== "" ? $images2 : "
        ") . "
        ";

        $row['images'] = $images;

        $Main = "
            <div class='d-flex justify-content-start'>
                <div class='p-1'>" . $images . "</div>
                <div class='text-wrap p-1'>
                    <strong>" . $row["Descripcion"] . "</strong><br>
                    <span class='badge bg-light text-dark'>" . lang('SKU') . ": " . $row["CodIdAmpliado"] . '</span>
                    <span class="badge bg-light text-dark">' . lang("BarCode") . ': <span class="fa fa-barcode"></span> ' . $row["CodBarra"] . '</span>
                </div>
            </div>
        ';
        $subdata[] = "
        <div class='row'>
            <div class='col-12 col-lg-6'>" . $Main . "</div>
            <div class='col-12 col-lg-6'>" . $PosStock . "</div>
        </div>
        ";
        $data[] = $subdata;
    }
    $json_data = array(
        "draw"              =>  intval($request['draw']),
        "recordsTotal"      =>  intval($totalData),
        "recordsFiltered"   =>  intval($totalFilter),
        "data"              =>  $data
    );
    return json_encode($json_data);
}

function ActualizarTasaBCV($conn, $post)
{
    ini_set('precision', -1);
    ini_set('serialize_precision', -1);
    $tasas = [];
    // $query = "SELECT fecha_valor_bcv, tasas FROM posuptasasbcv WHERE fecha_valor_bcv <= '" . explode(" ", $post["fechaclient"])[0] . "' ORDER BY fecha_valor_bcv DESC LIMIT 1 ";
    $query = "SELECT fecha_valor_bcv, tasas FROM posuptasasbcv where fecha_valor_bcv <= '".$post['fechaclient']."' ORDER by fecha_valor_bcv DESC LIMIT 1";
    $rr=$query;
    if ($result = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $json_con_comillas = preg_replace('/:\s*(-?\d+(\.\d+)?([eE][+-]?\d+)?)/', ':"$1"', $row["tasas"]);
            $tasas = json_decode($json_con_comillas, true);
        }
        mysqli_free_result($result);
    }
    $fecha = $post['fechaclient'];
    $fechahora = $post['fechahoraclient'];
    $decimal = 15;
    if ($tasas) {
        $Dolar = 0;
        $Euro = 0;
        $Yuan = 0;
        $Lira = 0;
        $Rublo = 0;
        $FactorDolar7 = 0;
        $query = "SELECT FactorDolarCash, FactorDolarPaypal, FactorDolarZelle, FactorDolar5, FactorDolar6, FactorDolar7, IdPais, MonedaUnica FROM posupcompany WHERE Id = " . $post["CompanyActual"] . " ";
        if ($result = mysqli_query($conn, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $Dolar = $row["FactorDolarCash"];
                $Euro = $row["FactorDolarPaypal"];
                $Yuan = $row["FactorDolarZelle"];
                $Lira = $row["FactorDolar5"];
                $Rublo = $row["FactorDolar6"];
                $FactorDolar7 = $row["FactorDolar7"];
                $mIdPais = $row["IdPais"];
                $mMonedaUnica = $row["MonedaUnica"];
            }
            mysqli_free_result($result);
        }

        if ($Dolar === 0 || $Euro === 0 || $Yuan === 0 || $Lira === 0 || $Rublo === 0 || ROUND($tasas["DOLAR"], $decimal) === 0 || ROUND($tasas["EURO"], $decimal) === 0 || ROUND($tasas["YUAN"], $decimal) === 0 || ROUND($tasas["LIRA"], $decimal) === 0 || ROUND($tasas["RUBLO"], $decimal) === 0) return ["status" => false];
        $save = false;
        $result = true;
        $stmt2 = true;
        $factor1 = $Dolar;
        $factor2 = $Euro;
        $factor3 = $Yuan;
        $factor5 = $Lira;
        $factor6 = $Rublo;
        $factor7 = $FactorDolar7;


        $posicionPunto = strpos($tasas["DOLAR"], '.');
        if ($posicionPunto !== false) {
            $DOLAR = substr($tasas["DOLAR"], 0, $posicionPunto + $decimal);
        } else {
            $DOLAR = $tasas["DOLAR"];
        }
        $tasas["DOLAR"] = $DOLAR;

        $posicionPunto = strpos($tasas["EURO"], '.');
        if ($posicionPunto !== false) {
            $EURO = substr($tasas["EURO"], 0, $posicionPunto + $decimal);
        } else {
            $EURO = $tasas["EURO"];
        }
        $tasas["EURO"] = $EURO;

        $posicionPunto = strpos($tasas["YUAN"], '.');
        if ($posicionPunto !== false) {
            $YUAN = substr($tasas["YUAN"], 0, $posicionPunto + $decimal);
        } else {
            $YUAN = $tasas["YUAN"];
        }
        $tasas["YUAN"] = $YUAN;

        $posicionPunto = strpos($tasas["LIRA"], '.');
        if ($posicionPunto !== false) {
            $LIRA = substr($tasas["LIRA"], 0, $posicionPunto + $decimal);
        } else {
            $LIRA = $tasas["LIRA"];
        }
        $tasas["LIRA"] = $LIRA;

        $posicionPunto = strpos($tasas["RUBLO"], '.');
        if ($posicionPunto !== false) {
            $RUBLO = substr($tasas["RUBLO"], 0, $posicionPunto + $decimal);
        } else {
            $RUBLO = $tasas["RUBLO"];
        }
        $tasas["RUBLO"] = $RUBLO;
        if (($mIdPais=="VE") && ($mMonedaUnica=="0")) 
        {
            if ($Dolar <> $tasas["DOLAR"]) {
                $query = "UPDATE posupcompany set MonedaS = 'BCV', 
                FactorDolarCash = '" . $tasas["DOLAR"] . "' 
                WHERE Id = " . $post["CompanyActual"] . " ";

                
                $result = mysqli_query($conn, $query);
                $factor1 = $tasas["DOLAR"];
                $save = true;
            }

            if ($Euro <> $tasas["EURO"]) {
                $query = "UPDATE posupcompany set Moneda3 = 'EUR', 
                FactorDolarPaypal = '" . $tasas["EURO"] . "' 
                WHERE Id = " . $post["CompanyActual"] . " ";
                $result = mysqli_query($conn, $query);
                $factor2 = $tasas["EURO"];
                $save = true;
            }

            if ($Yuan <> $tasas["YUAN"]) {
                $query = "UPDATE posupcompany set Moneda4 = 'CNY', 
                FactorDolarZelle = '" . $tasas["YUAN"] . "' 
                WHERE Id = " . $post["CompanyActual"] . " ";
                $result = mysqli_query($conn, $query);
                $factor3 = $tasas["YUAN"];
                $save = true;
            }

            if ($Lira <> $tasas["LIRA"]) {
                $query = "UPDATE posupcompany set Moneda5 = 'TRY', 
                FactorDolar5 = '" . $tasas["LIRA"] . "' 
                WHERE Id = " . $post["CompanyActual"] . " ";
                $result = mysqli_query($conn, $query);
                $factor5 = $tasas["LIRA"];
                $save = true;
            }

            if ($Rublo <> $tasas["RUBLO"]) {
                $query = "UPDATE posupcompany set Moneda6 = 'RUB', 
                FactorDolar6 = '" . $tasas["RUBLO"] . "' 
                WHERE Id = " . $post["CompanyActual"] . " ";
                $result = mysqli_query($conn, $query);
                $factor6 = $tasas["RUBLO"];
                $save = true;
            }
            if ($save) {
                $text = "BCVUSER|T1:" . $factor1 . "|T2:" . $factor2 . "|T3:" . $factor3 . "|T4:" . $factor5 . "|T5:" . $factor6 . "|T6:" . $factor7;

                $sql2 = "insert Into PosUpCompanyHistoriaTasa (Id,CompanyId,Fecha,Comentario)  (select COALESCE(max(Id),0)+1 as Id," . trim($post["CompanyActual"]) . " as CompanyId,'" . $fechahora . "' as Fecha,'" . $text . "' as Comentario From PosUpCompanyHistoriaTasa where CompanyId=" . trim($post["CompanyActual"]) . ")";
                $stmt2 = mysqli_query($conn, $sql2);

                if ($result && $stmt2) return ["status" => $rr];
            }
        }
        return ["status" => false, $tasas["DOLAR"], $Dolar];
    }
}

if ($_POST["Accion"] == "3") {
    include "ambiente.php";
    $conn = conectar();

    if ($_POST["Opcion"] == "0") { //Actualizar / Crear
        $path = "lang";
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $array = array();
        $array2 = array();
        $query = "SELECT * FROM PosUpIdiomasTraductor";
        if ($result = mysqli_query($conn, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $array[] = $row;
                $array2[$row['Base']] = ['ES-VE' => $row[''], 'ES-CL' => $row['ES-CL'], 'ES-HN' => $row['ES-HN'], 'EN-US' => $row['EN-US'], 'ES-US' => $row['ES-US'], 'PT-BR' => $row['PT-BR'], 'DE-DE' => $row['DE-DE'], 'FR-FR' => $row['FR-FR']];
            }
        }

        $json = json_encode($array);
        $path = "lang/languagefile.json";
        if (file_exists($path)) {
            unlink($path);
        }
        file_put_contents("lang/languagefile.json", $json);
        if (file_exists($path)) {
            echo "1";
        } else {
            echo "0";
        }



        $json2 = json_encode($array2, JSON_UNESCAPED_UNICODE);
        $path2 = "lang/languagefile2.json";
        if (file_exists($path2)) {
            unlink($path2);
        }
        file_put_contents("lang/languagefile2.json", $json2);
    }

    if ($_POST["Opcion"] == "1") { //Eliminar
        $path = "lang/languagefile.json";
        if (file_exists($path)) {
            unlink($path);
        }
        if (!file_exists($path)) {
            echo "1";
        } else {
            echo "0";
        }
    }

    if ($_POST["Opcion"] == "2") { //Verificar
        $path = "lang/languagefile.json";
        if (!file_exists($path)) {
            echo "1";
        } else {
            echo "0";
        }
    }

    if ($_POST["Opcion"] == "4") { //Ver Tabla
        if ($_POST["Ini"] == "0") {
        ?>
            <table class="table table-hover table-striped nowrap" id="LanguageTable" cellspacing="0" style="width:100%">
                <thead>
                    <tr>
                        <th><?php echo lang("Base"); ?></th>
                        <th><img width="18px" height="20px" src="/img/VE.png" alt="Generic placeholder image" /><?php echo lang("Español Venezuela"); ?></th>
                        <th><img width="18px" height="20px" src="/img/CL.png" alt="Generic placeholder image" /><?php echo lang("Español Chile"); ?></th>
                        <th><img width="18px" height="20px" src="/img/HN.png" alt="Generic placeholder image" /><?php echo lang("Español Honduras"); ?></th>
                        <th><img width="18px" height="20px" src="/img/US.png" alt="Generic placeholder image" /><?php echo lang("Ingles USA"); ?></th>
                        <th><img width="18px" height="20px" src="/img/US.png" alt="Generic placeholder image" /><?php echo lang("Español USA"); ?></th>
                        <th><img width="18px" height="20px" src="/img/BR.png" alt="Generic placeholder image" /><?php echo lang("Portugues Brasil"); ?></th>
                        <th><img width="18px" height="20px" src="/img/DE.png" alt="Generic placeholder image" /><?php echo lang("Aleman Alemania"); ?></th>
                        <th><img width="18px" height="20px" src="/img/FR.png" alt="Generic placeholder image" /><?php echo lang("Frances Francia"); ?></th>
                    </tr>
                </thead>
            </table>
    <?php
        }
        if ($_POST["Ini"] == "1") {
            $path = "lang/languagefile.json";
            if (file_exists($path)) {
                $hh = 2;
            } else {
                $hh = 1;
            }
            $hh = 1;
            if ($hh == 2) {
                $request = $_REQUEST;
                $datos = file_get_contents($path);
                $array = json_decode($datos, true);
                $n = 0;
                foreach ($array as $value) {
                    $n = $n + 1;
                }
                $totalData = $n;
                $totalFilter = $totalData;
                $data = array();
                $m = 0;
                foreach ($array as $row) {
                    if (trim($row["Base"]) <> "") {
                        $m = $m + 1;
                        if ($m >= $request['start']) {
                            $subdata = array();
                            $subdata[] = $row["Base"];
                            $subdata[] = $row["ES-VE"];
                            $subdata[] = $row["ES-CL"];
                            $subdata[] = $row["ES-HN"];
                            $subdata[] = $row["EN-US"];
                            $subdata[] = $row["ES-US"];
                            $subdata[] = $row["PT-BR"];
                            $subdata[] = $row["DE-DE"];
                            $subdata[] = $row["FR-FR"];
                            $data[] = $subdata;
                            if (($request['start'] + $request['length']) == $m) {
                                break;
                            }
                        }
                    }
                }
                $json_data = array(
                    "draw"              =>  intval($request['draw']),
                    "recordsTotal"      =>  intval($totalFilter),
                    "recordsFiltered"   =>  intval($totalData),
                    "data"              =>  $data
                );
                echo json_encode($json_data);
            }
            if ($hh == 1) {
                $request = $_REQUEST;
                $col = array(
                    0   =>  "Base",
                    1   =>  "'ES-VE'",
                    2   =>  "'ES-CL'",
                    3   =>  "'ES-HN'",
                    4   =>  "'EN-US'",
                    5   =>  "'ES-US'",
                    6   =>  "'PT-BR'",
                    7   =>  "'DE-DE'",
                    8   =>  "'FR-FR'"
                );
                $sql = "SELECT * from PosUpIdiomasTraductor";
                $query = mysqli_query($conn, $sql);
                $totalData = mysqli_num_rows($query);
                $totalFilter = $totalData;
                if (!empty($request['search']['value'])) {
                    $sql .= " WHERE Base Like '%" . $request['search']['value'] . "%' ";
                    /*
                        $sql.=" WHERE ('Base' Like '%".$request['search']['value']."%' ";
                        $sql.=" OR 'ES-VE' Like '%".$request['search']['value']."%' ";
                        $sql.=" OR 'ES-CL' Like '%".$request['search']['value']."%' ";
                        $sql.=" OR 'ES-HN' Like '%".$request['search']['value']."%' ";
                        $sql.=" OR 'EN-US' Like '%".$request['search']['value']."%' ";
                        $sql.=" OR 'ES-US' Like '%".$request['search']['value']."%' ";
                        $sql.=" OR 'PT-BR' Like '%".$request['search']['value']."%' ";
                        $sql.=" OR 'DE-DE' Like '%".$request['search']['value']."%' ";
                        $sql.=" OR 'FR-FR' Like '%".$request['search']['value']."%' )";
                        */
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
                    if (trim($row["Base"]) <> "") {
                        $n = $n + 1;
                        $subdata = array();
                        $subdata[] = $row["Base"] . " " . "<div class='btn-group'><button type='button' class='btn btn-primary' onclick='editaridioma(`" . $row["Base"] . "`,`" . $row["ES-VE"] . "`,`" . $row["ES-CL"] . "`,`" . $row["ES-HN"] . "`,`" . $row["EN-US"] . "`,`" . $row["ES-US"] . "`,`" . $row["PT-BR"] . "`,`" . $row["DE-DE"] . "`,`" . $row["FR-FR"] . "`)' ><i class='fa fa-edit'></i></button><button type='button' class='btn btn-danger' id='botoneliminar" . $n . "' onclick='eliminaridioma(`" . $row["Base"] . "`,`" . $n . "`)' ><i class='fa fa-close'></i></button></div>";
                        $subdata[] = $row["ES-VE"];
                        $subdata[] = $row["ES-CL"];
                        $subdata[] = $row["ES-HN"];
                        $subdata[] = $row["EN-US"];
                        $subdata[] = $row["ES-US"];
                        $subdata[] = $row["PT-BR"];
                        $subdata[] = $row["DE-DE"];
                        $subdata[] = $row["FR-FR"];
                        $data[] = $subdata;
                    }
                }

                $json_data = array(
                    "draw"              =>  intval($request['draw']),
                    "recordsTotal"      =>  intval($totalFilter),
                    "recordsFiltered"   =>  intval($totalData),
                    "data"              =>  $data
                );
                echo json_encode($json_data);
            }
        }
    }

    if ($_POST["Opcion"] == "5") { //Guardar / Eliminar
        if ($_POST["Ini"] == "0") { //Guardar
            $sql = "update PosUpIdiomasTraductor set `ES-VE`='" . $_POST["ESVEInputIdi"] . "',`ES-CL`='" . $_POST["ESCLInputIdi"] . "',`ES-HN`='" . $_POST["ESHNInputIdi"] . "',`EN-US`='" . $_POST["ENUSInputIdi"] . "',`ES-US`='" . $_POST["ESUSInputIdi"] . "',`PT-BR`='" . $_POST["PTBRInputIdi"] . "',`DE-DE`='" . $_POST["DEDEInputIdi"] . "',`FR-FR`='" . $_POST["FRFRInputIdi"] . "'  where Base='" . $_POST["BaseInputIdi"] . "' ";
            $stmt = mysqli_query($conn, $sql);
            if ($stmt === true) {
                $path = "lang";
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                $array = array();
                $query = "SELECT * FROM PosUpIdiomasTraductor";
                if ($result = mysqli_query($conn, $query)) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $array[] = $row;
                    }
                }

                $json = json_encode($array);
                $path = "lang/languagefile.json";
                if (file_exists($path)) {
                    unlink($path);
                }
                file_put_contents("lang/languagefile.json", $json);
                if (file_exists($path)) {
                    echo "1";
                } else {
                    echo "0";
                }
            } else {
                mysqli_free_result($stmt);
                echo "0";
            }
        }
        if ($_POST["Ini"] == "1") { //Eliminar
            $sql = "delete from PosUpIdiomasTraductor where Base='" . $_POST["BaseInputIdi"] . "'";
            $stmt = mysqli_query($conn, $sql);
            if ($stmt === true) {
                $path = "lang";
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                $array = array();
                $query = "SELECT * FROM PosUpIdiomasTraductor";
                if ($result = mysqli_query($conn, $query)) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $array[] = $row;
                    }
                }

                $json = json_encode($array);
                $path = "lang/languagefile.json";
                if (file_exists($path)) {
                    unlink($path);
                }
                file_put_contents("lang/languagefile.json", $json);
                if (file_exists($path)) {
                    echo "1";
                } else {
                    echo "0";
                }
            } else {
                mysqli_free_result($stmt);
                echo "0";
            }
        }
    }
}

if ($_POST["Accion"] == "4") {
    include "ambienteconsultas.php";
    $conn = conectar();

    $TotalMaximilian = 0;
    $query2 = "SELECT a.PorcProd,b.CostoNeto FROM PosUpPRprocesosProd a left join PosUpProducto b on b.CodIdBasico = a.CodIdBasicoPP and a.IdCompany = b.IdCompany WHERE a.IdCompany=" . $_POST["CompanyActual"] . " and a.OriDest='-1' and a.Paso = '" . $_POST["Paso"] . "' and a.CodIdBasico = '" . $_POST["CodIdBasico"] . "'";
    if ($result2 = mysqli_query($conn, $query2)) {
        while ($row2 = mysqli_fetch_assoc($result2)) {
            $TotalMaximilian = $TotalMaximilian + ($row2["PorcProd"] * $row2["CostoNeto"]);
        }
        mysqli_free_result($result);
    }
    $Maquinaria = 0;
    $query2 = "SELECT a.CantTiempo,b.CostoxTime FROM PosUpPRprocesosMaq a left join PosUpPRmaquinarias b on b.Id = a.IdMaquinaria and a.IdCompany = b.IdCompany WHERE a.IdCompany=" . $_POST["CompanyActual"] . " and a.Paso = '" . $_POST["Paso"] . "' and a.CodIdBasico = '" . $_POST["CodIdBasico"] . "'";
    if ($result2 = mysqli_query($conn, $query2)) {
        while ($row2 = mysqli_fetch_assoc($result2)) {
            $Maquinaria = $Maquinaria + ($row2["CantTiempo"] * $row2["CostoxTime"]);
        }
        mysqli_free_result($result);
    }
    $Operador = 0;
    $query2 = "SELECT a.CantTiempo,b.CostoxTime FROM PosUpPRprocesosOper a left join PosUpPRoperadores b on b.Id = a.IdOper and a.IdCompany = b.IdCompany WHERE a.IdCompany=" . $_POST["CompanyActual"] . " and a.Paso = '" . $_POST["Paso"] . "' and a.CodIdBasico = '" . $_POST["CodIdBasico"] . "'";
    if ($result2 = mysqli_query($conn, $query2)) {
        while ($row2 = mysqli_fetch_assoc($result2)) {
            $Operador = $Operador + ($row2["CantTiempo"] * $row2["CostoxTime"]);
        }
        mysqli_free_result($result);
    }
}

if ($_POST["Accion"] == "5") {
    include "ambienteconsultas.php";
    $conn = conectar();

    if ($_POST["Idtipotx"] == 1) {
        $ttx = "numboleta";
    }
    if ($_POST["Idtipotx"] == 2) {
        $ttx = "numfactura";
    }
    if ($_POST["Idtipotx"] == 3) {
        $ttx = "numdevo";
    }
    if ($_POST["Idtipotx"] == 4) {
        $ttx = "numentcja";
    }
    if ($_POST["Idtipotx"] == 5) {
        $ttx = "numsalcja";
    }
    if ($_POST["Idtipotx"] == 6) {
        $ttx = "numarq";
    }
    if ($_POST["Idtipotx"] == 7) {
        $ttx = "numcom";
    }
    if ($_POST["Idtipotx"] == 8) {
        $ttx = "numaju";
    }
    if ($_POST["Idtipotx"] == 9) {
        $ttx = "nummovi";
    }
    if ($_POST["Idtipotx"] == 10) {
        $ttx = "numtoma";
    }
    if ($_POST["Idtipotx"] == 11) {
        $ttx = "numpedido";
    }
    if ($_POST["Idtipotx"] == 12) {
        $ttx = "numpre";
    }
    if ($_POST["Idtipotx"] == 13) {
        $ttx = "numcaja";
    }
    if ($_POST["Idtipotx"] == 14) {
        $ttx = "numoc";
    }
    if ($_POST["Idtipotx"] == 15) {
        $ttx = "numnota";
    }
    if ($_POST["Idtipotx"] == 16) {
        $ttx = "numcc";
    }
    if ($_POST["Idtipotx"] == 17) {
        $ttx = "numtra";
    }
    if ($_POST["Idtipotx"] == 18) {
        $ttx = "numcar";
    }
    if ($_POST["Idtipotx"] == 19) {
        $ttx = "numdes";
    }
    if ($_POST["Idtipotx"] == 20) {
        $ttx = "NoProcesar"; //Orden de Compra Anulada
    }
    if ($_POST["Idtipotx"] == 21) {
        $ttx = "NoProcesar"; //Boleta Manual
    }
    if ($_POST["Idtipotx"] == 22) {
        $ttx = "numnec"; //Guia de Despacho
    }
    if ($_POST["Idtipotx"] == 23) {
        $ttx = "NoProcesar"; //Pedido Anulada
    }
    if ($_POST["Idtipotx"] == 24) {
        $ttx = "numces";
    }
    if ($_POST["Idtipotx"] == 25) {
        $ttx = "numanticipo";
    }

    if ($_POST["Idtipotx"] == 27) {
        $ttx = "numcompdev";
    }

    if ($_POST["Idtipotx"] == 30) {
        $ttx = "numprod";
    }

    if ($_POST["Idtipotx"] == 32) {
        $ttx = "numplain";
    }
    $query = "SELECT " . $ttx . " FROM PosUpCompanyEstacion where token='" . $_POST['IdEstacion'] . "'";
    if ($result = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $Idtx = $row[$ttx];
        }
    }

    $query = "SELECT a.IdBarcode,a.IdTxCompany,b.TituloFe,b.Titulo,a.IdCompany,a.IdEstacion,a.Idtipotx,g.FacEle,a.Fectxclient,a.IdUser,b.Fe,a.DTE,a.Idtx,c.IdAlmVta,f.CD,f.SimDec,f.SimMil,
    f.MonedaP,f.MonedaS,f.Comercio,f.Direccion,f.litfiscal,f.rute,f.`Email-correo`,f.`Email-server`,f.`Email-puerto`,f.`Email-password`
    FROM PosUpTxC a 
    inner join PosUpTx b on b.Idtipotx=a.Idtipotx 
    left join PosUpCompanyEstacion c on c.token = a.IdEstacion and a.IdCompany = c.IdCompany 
    left join PosUpCompany f on f.Id = a.IdCompany 
    left join PosUpPais g on g.Id = f.IdPais 
    WHERE a.IdCompany=" . $_POST["CompanyActual"] . " and a.Idtipotx=" . trim($_POST["Idtipotx"]) . " 
    and a.Idtx=" . $Idtx . " and a.IdEstacion='" . $_POST["IdEstacion"] . "'";
    if ($result = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $IdTxCompany = $row['IdTxCompany'];
            $FacEle = $row["FacEle"];
            $Idtipotx = $row["Idtipotx"];
            $IdEstacion = $row["IdEstacion"];
            $DTE = $row["DTE"];
            $Idtx = $row["Idtx"];
            $TituloFe = $row["TituloFe"];
            $Titulo = $row["Titulo"];
            $IdBarcode = $row["IdBarcode"];
            $Comercio = $row["Comercio"];
            $EmailCorreo = trim($row['Email-correo']);
            $EmailServer = trim($row['Email-server']);
            $EmailPuerto = trim($row['Email-puerto']);
            $EmailPassword = trim($row['Email-password']);
        }
        mysqli_free_result($result);
    }
    if (($FacEle == 1) and (($Idtipotx == 1) || ($Idtipotx == 2) || ($Idtipotx == 3) || ($Idtipotx == 21))) {
        $NombrePag = $TituloFe . " - " . str_pad($DTE, 6, "0", STR_PAD_LEFT);
    } else {
        $NombrePag = $Titulo . " - " . str_pad($IdTxCompany, 6, "0", STR_PAD_LEFT);
    }

    require("class.phpmailer.php");
    $mail = new PHPMailer();
    $mail->CharSet = 'UTF-8';
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = $EmailServer;
    $mail->Username = $EmailCorreo;
    $mail->Password = $EmailPassword;
    $mail->SMTPSecure = 'tls';
    $mail->Port = $EmailPuerto;
    $mail->From = $EmailCorreo;
    $mail->FromName = "Notifications - " . $Comercio;

    $mail->AddAddress($_POST["CorreoEnviar"]);
    $mail->IsHTML(true);

    $mail->Subject = "Doc. #(" . $NombrePag . ")";

    $archivo = file_get_contents("emailsposup/EnvioImpresion.html");
    $archivo_nuevo = str_replace("[NOMBRE COMERCIO]", $Comercio, str_replace("%%Documento%%", $NombrePag, str_replace("%%OptionIndaLaif%%", $IdBarcode, $archivo)));
    $body = $archivo_nuevo;
    $mail->Body = $body;
    $mail->AltBody = "";
    $exito = $mail->Send();
    if ($exito) {
        echo "1";
    } else {
        echo "0";
    }
}

if ($_POST["Accion"] == "6") {
    include "ambienteconsultas.php";
    $conn = conectar();

    $Idtx = $_POST["Idtx"];

    $query = "SELECT a.IdBarcode,a.IdTxCompany,b.TituloFe,b.Titulo,a.IdCompany,a.IdEstacion,a.Idtipotx,g.FacEle,a.Fectxclient,a.IdUser,b.Fe,a.DTE,a.Idtx,c.IdAlmVta,f.CD,f.SimDec,f.SimMil,
    f.MonedaP,f.MonedaS,f.Comercio,f.Direccion,f.litfiscal,f.rute,f.`Email-correo`,f.`Email-server`,f.`Email-puerto`,f.`Email-password`
    FROM PosUpTxC a 
    inner join PosUpTx b on b.Idtipotx=a.Idtipotx 
    left join PosUpCompanyEstacion c on c.token = a.IdEstacion and a.IdCompany = c.IdCompany 
    left join PosUpCompany f on f.Id = a.IdCompany 
    left join PosUpPais g on g.Id = f.IdPais 
    WHERE a.IdCompany=" . $_POST["CompanyActual"] . " and a.Idtipotx=" . trim($_POST["Idtipotx"]) . " 
    and a.Idtx=" . $Idtx . " and a.IdEstacion='" . $_POST["IdEstacion"] . "'";
    if ($result = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $IdTxCompany = $row['IdTxCompany'];
            $FacEle = $row["FacEle"];
            $Idtipotx = $row["Idtipotx"];
            $IdEstacion = $row["IdEstacion"];
            $DTE = $row["DTE"];
            $Idtx = $row["Idtx"];
            $TituloFe = $row["TituloFe"];
            $Titulo = $row["Titulo"];
            $IdBarcode = $row["IdBarcode"];
            $Comercio = $row["Comercio"];
            $EmailCorreo = trim($row['Email-correo']);
            $EmailServer = trim($row['Email-server']);
            $EmailPuerto = trim($row['Email-puerto']);
            $EmailPassword = trim($row['Email-password']);
        }
        mysqli_free_result($result);
    }
    if (($FacEle == 1) and (($Idtipotx == 1) || ($Idtipotx == 2) || ($Idtipotx == 3) || ($Idtipotx == 21))) {
        $NombrePag = $TituloFe . " - " . str_pad($DTE, 6, "0", STR_PAD_LEFT);
    } else {
        $NombrePag = $Titulo . " - " . str_pad($IdTxCompany, 6, "0", STR_PAD_LEFT);
    }

    require("class.phpmailer.php");
    $mail = new PHPMailer();
    $mail->CharSet = 'UTF-8';
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = $EmailServer;
    $mail->Username = $EmailCorreo;
    $mail->Password = $EmailPassword;
    $mail->SMTPSecure = 'tls';
    $mail->Port = $EmailPuerto;
    $mail->From = $EmailCorreo;
    $mail->FromName = "Notifications - " . $Comercio;

    $mail->AddAddress($_POST["CorreoEnviar"]);
    $mail->IsHTML(true);

    $mail->Subject = "Doc. #(" . $NombrePag . ")";

    $archivo = file_get_contents("emailsposup/EnvioImpresion.html");
    $archivo_nuevo = str_replace("[NOMBRE COMERCIO]", $Comercio, str_replace("%%Documento%%", $NombrePag, str_replace("%%OptionIndaLaif%%", $IdBarcode, $archivo)));
    $body = $archivo_nuevo;
    $mail->Body = $body;
    $mail->AltBody = "";
    $exito = $mail->Send();
    if ($exito) {
        echo "1";
    } else {
        echo "0";
    }
}

if ($_POST["tabla"] == "IniPosUp") {
    include "ambiente.php";
    $conn = conectar();

    if ($_POST["cbox6CUsuario"] == "on") {
        $fe = "1";
    } else {
        $fe = "0";
    }

    if ($_POST["AutorizaVarnCUsuario"] == "on") {
        $atvar = "1";
    } else {
        $atvar = "0";
    }

    if ($_POST['u1aCUsuario'] == true) {
        $u1 = 1;
    } else {
        $u1 = 0;
    }

    if ($_POST['u2aCUsuario'] == true) {
        $u2 = 1;
    } else {
        $u2 = 0;
    }

    if ($_POST['u3aCUsuario'] == true) {
        $u3 = 1;
    } else {
        $u3 = 0;
    }

    if ($_POST['p0aCUsuario'] == true) {
        $p0 = 1;
    } else {
        $p0 = 0;
    }

    if ($_POST['p1aCUsuario'] == true) {
        $p1 = 1;
    } else {
        $p1 = 0;
    }

    if ($_POST['p2aCUsuario'] == true) {
        $p2 = 1;
    } else {
        $p2 = 0;
    }

    if ($_POST['p3aCUsuario'] == true) {
        $p3 = 1;
    } else {
        $p3 = 0;
    }

    if ($_POST['vcaCUsuario'] == true) {
        $c0 = 1;
    } else {
        $c0 = 0;
    }

    if ($_POST['valiv1aCUsuario'] == true) {
        $vali = 1;
    } else {
        $vali = 0;
    }

    if ($_POST['pun2CUsuario'] == true) {
        $pun = 1;
    } else {
        $pun = 0;
    }

    if ($_POST["ModalSerialcfamilia"] == "on") {
        $a = "1";
    } else {
        $a = "0";
    }
    if ($_POST["ModalLotecfamilia"] == "on") {
        $b = "1";
    } else {
        $b = "0";
    }

    if ($_POST["ordenscfamilia"] == "on") {
        $c = "1";
    } else {
        $c = "0";
    }
    if ($_POST["vntacfamilia"] == "on") {
        $v = "1";
    } else {
        $v = "0";
    }
    $ModalItemcimpuesto = str_replace("'", "´", str_replace('"', "´´", str_replace('`', "´", trim($_POST["ModalItemcimpuesto"]))));
    $ModalItemcfamilia = str_replace("'", "´", str_replace('"', "´´", str_replace('`', "´", trim($_POST["ModalItemcfamilia"]))));

    $ModalNombre = str_replace("'", "´", str_replace('"', "´´", str_replace('`', "´", trim($_POST["ModalNombrecubicacion"]))));
    $ModalDescripcion = str_replace("'", "´", str_replace('"', "´´", str_replace('`', "´", trim($_POST["ModalDescripcioncubicacion"]))));
    $ModalDireccion = str_replace("'", "´", str_replace('"', "´´", str_replace('`', "´", trim($_POST["Modalidenfiscubicacion"]))));
    $ModalComercio = str_replace("'", "´", str_replace('"', "´´", str_replace('`', "´", trim($_POST["Modalcorreocubicacion"]))));
    $telefono = str_replace("'", "´", str_replace('"', "´´", str_replace('`', "´", trim($_POST["Modaltelfcubicacion"]))));

    $comision = $_POST["Comisioncproductoyservicio"] / 100;
    $comision2 = $_POST["Comision2cproductoyservicio"] / 100;
    $comision3 = $_POST["Comision3cproductoyservicio"] / 100;


    if ($_POST["ModalPorKilocproductoyservicio"] == "on") {
        $a = "1";
    } else {
        $a = "0";
    }
    $b = "1";
    if ($_POST["ModalCodIdAmpliadocproductoyservicio"] == "") {
        $c = "LPAD(CAST(COALESCE(max(CodIdAmpliado+1),0) as CHAR), 4, '0') as CodIdAmpliado";
    } else {
        $c = "'" . trim($_POST["ModalCodIdAmpliadocproductoyservicio"]) . "'";
    }
    $ModalDescripcioncproductoyservicio = str_replace("'", "´", str_replace('"', "´´", str_replace('`', "´", str_replace('&', "y", trim($_POST["ModalDescripcioncproductoyservicio"])))));
    $ModalMedida = str_replace("'", "´", str_replace('"', "´´", str_replace('`', "´", str_replace('&', "y", trim($_POST["ModalMedidascproductoyservicio"])))));
    $ModalCodIdAmpliado = str_replace("'", "´", str_replace('"', "´´", str_replace('`', "´", str_replace('&', "y", trim($_POST["ModalCodIdAmpliadocproductoyservicio"])))));
    $ModalCodBarra = str_replace("'", "´", str_replace('"', "´´", str_replace('`', "´", str_replace('&', "y", trim($_POST["ModalCodBarracproductoyservicio"])))));
    $ModalCodBarra = '';
    $g = json_decode($_POST["json"], true);
    foreach ($g as $clave => $valor) {
        $limit = $limit + 1;
    }

    if (trim($_POST["ModalMedida2cproductoyservicio"]) == '') {
        $medida2 = $ModalMedida;
    } else {
        $medida2 = trim($_POST["ModalMedida2cproductoyservicio"]);
    }

    if (trim($_POST["ModalMedida3cproductoyservicio"]) == '') {
        $medida3 = $ModalMedida;
    } else {
        $medida3 = trim($_POST["ModalMedida3cproductoyservicio"]);
    }

    foreach ($g as $clave => $valor) {
        $lit = $lit + 1;
        if ($lit == $limit) {
            $ModalCodBarra = $ModalCodBarra . $valor['CodBarra'] . ' ';
        } else {
            $ModalCodBarra =  $valor['CodBarra'] . ' | ' . $ModalCodBarra;
        }
    }

    $query = "select a.id,a.comercio,b.almacenes,c.ubicaciones,d.usuarios,e.estaciones,f.familias,g.impuestos,h.marcas,i.productosservicios from PosUpCompany a
        left join  (select idcompany,count(*) as almacenes from PosUpAlmacen group by idcompany) b on a.id=b.IdCompany 
        left join  (select idcompany,count(*) as ubicaciones from PosUpUbicacion group by idcompany) c on a.id=c.IdCompany 
        left join  (select idcompany,count(*) as usuarios from PosUpUsers group by idcompany) d on a.id=d.IdCompany 
        left join  (select idcompany,count(*) as estaciones from PosUpCompanyEstacion group by idcompany) e on a.id=e.IdCompany 
        left join  (select idcompany,count(*) as familias from PosUpvarios aa where aa.TIPOITEM = 2 group by idcompany) f on a.id=f.IdCompany 
        left join  (select idcompany,count(*) as impuestos from PosUpvarios aa where aa.TIPOITEM = 0 group by idcompany) g on a.id=g.IdCompany 
        left join  (select idcompany,count(*) as marcas from PosUpc_marcas aa  group by idcompany) h on a.id=h.IdCompany 
        left join  (select idcompany,count(*) as productosservicios from PosUpProducto aa where aa.escompuesto in (0,9)  group by idcompany) i on a.id=i.IdCompany 
        where a.id=" . $_POST["companyUser"];
    if ($result = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $almacenes = $row["almacenes"];
            $ubicaciones = $row["ubicaciones"];
            $usuarios = $row["usuarios"];
            $estaciones = $row["estaciones"];
            $familias = $row["familias"];
            $impuestos = $row["impuestos"];
            $marcas = $row["marcas"];
            $productosservicios = $row["productosservicios"];
        }
    }
    if (trim($almacenes) == "") {
        if ($_POST["OpcionAEleccion003"] == "1") {
            $almacenes = 0;
        } else {
            $almacenes = 1;
        }
    }
    if (trim($ubicaciones) == "") {
        if ($_POST["OpcionAEleccion002"] == "1") {
            $ubicaciones = 0;
        } else {
            $ubicaciones = 1;
        }
    }
    if (trim($usuarios) == "") {
        if ($_POST["OpcionAEleccion001"] == "1") {
            $usuarios = 0;
        } else {
            $usuarios = 1;
        }
    }
    if (trim($familias) == "") {
        if ($_POST["OpcionAEleccion005"] == "1") {
            $familias = 0;
        } else {
            $familias = 1;
        }
    }
    if (trim($impuestos) == "") {
        if ($_POST["OpcionAEleccion006"] == "1") {
            $impuestos = 0;
        } else {
            $impuestos = 1;
        }
    }
    if (trim($marcas) == "") {
        if ($_POST["OpcionAEleccion004"] == "1") {
            $marcas = 0;
        } else {
            $marcas = 1;
        }
    }
    if (trim($productosservicios) == "") {
        if ($_POST["OpcionAEleccion007"] == "1") {
            $productosservicios = 0;
        } else {
            $productosservicios = 1;
        }
    }

    $conn->autocommit(FALSE);

    if ($usuarios == 0) {
        $sql = "insert into PosUpUsers (AutorizaVar,PrecioUnidad,valiv1,p0,p1,p2,p3,c0,u1,u2,u3,PorComiVta,PorComiCob,login,nombre,correo,idcompany,idnivel,password,autorizadcto,autorizadev,autorizaarqueo,autorizacompra,autorizadvta,IdUbic,autorizatasa) values(" . $atvar . "," . $pun . "," . $vali . "," . $p0 . "," . $p1 . "," . $p2 . "," . $p3 . "," . $c0 . "," . $u1 . "," . $u2 . "," . $u3 . ", '" . trim($_POST["Modalvtapor2CUsuario"]) . "','" . trim($_POST["Modalvtapor2CUsuario"]) . "','" . strtoUPPER(trim($_POST["ModalLoginCUsuario "])) . "','" . ucwords(strtolower(trim($_POST["ModalNombreCUsuario"]))) . "','" . strtolower(trim($_POST["ModalCorreoCUsuario"])) . "'," . trim($_POST["companyUser"]) . "," . trim($_POST["ModalNivelCUsuario"]) . ",'" . sha1(trim($_POST["ModalPassCUsuario"])) . "','1','1','1','1','1','" . $_POST["ModalSucursalCUsuario"] . "'," . $fe . ")";
        $stmt001 = mysqli_query($conn, $sql);
    } else {
        $stmt001 = true;
    }

    if ($ubicaciones == 0) {
        $sql = "insert into PosUpUbicacion (AlmacenProduccion,IDUbi,Nombre,IdCompany,Descripcion,IdenFiscal,Correo,Telefono) (select " . $_POST["Modalampcubicacion"] . ",COALESCE(max(IDUbi),0)+1 as IDUbi,'" . $ModalNombre . "'," . $_POST["companyUser"] . ",'" . $ModalDescripcion . "','" . $ModalDireccion . "','" . $ModalComercio . "' ,'" . $telefono . "' from PosUpUbicacion where IdCompany = " . $_POST["companyUser"] . ")";
        $stmt002 = mysqli_query($conn, $sql);
    } else {
        $stmt002 = true;
    }

    if ($almacenes == 0) {
        if (trim($_POST["ModalIdUbicalmacen"]) == "") {
            $IDUbi = 1;
            $query = "SELECT IdUbi FROM PosUpUbicacion WHERE IdCompany=" . $_POST["companyUser"] . " ";
            if ($result = mysqli_query($conn, $query)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $IDUbi = $row["IdUbi"];
                }
                mysqli_free_result($result);
            }
        } else {
            $IDUbi = trim($_POST["ModalIdUbicalmacen"]);
        }

        $sql = "insert into PosUpAlmacen (IdAlm,Nombre,Tipo,IdCompany,IdUbi,ImpFac,impBoleta,ImpGuia,ImpNotaEnt,ImpMovInventario,FormaFac,FormaBol,FormaGuia,FormaNote,FormaMovi,FormPedid) (select COALESCE(max(IdAlm),0)+1 as IdAlm,'" . trim($_POST["ModalNombrecalmacen"]) . "'," . trim($_POST["ModalTipocalmacen"]) . "," . $_POST["companyUser"] . "," . $IDUbi . "," . trim($_POST["ImpFaccalmacen"]) . "," . trim($_POST["impBoletacalmacen"]) . "," . trim($_POST["ImpGuiacalmacen"]) . "," . trim($_POST["ImpNotaEntcalmacen"]) . "," . trim($_POST["ImpMovInventariocalmacen"]) . ",'" . trim($_POST["FormaFaccalmacen"]) . "','" . trim($_POST["FormaBolcalmacen"]) . "','" . trim($_POST["FormaGuiacalmacen"]) . "','" . trim($_POST["FormaNotecalmacen"]) . "','" . trim($_POST["FormaMovicalmacen"]) . "','" . trim($_POST["FormPedidcalmacen"]) . "' from PosUpAlmacen where IdCompany = " . $_POST["companyUser"] . ")";
        $stmt003 = mysqli_query($conn, $sql);
    } else {
        $stmt003 = true;
    }

    if ($marcas == 0) {
        $sql = "insert into PosUpc_marcas (IdCompany,idmarca,nombre,idfabricante) (select " . $_POST["companyUser"] . ",COALESCE(max(idmarca),0)+1 as idmarca,'" . trim($_POST["ModalNombrecmarca"]) . "',0 from PosUpc_marcas where IdCompany = " . $_POST["companyUser"] . ")";
        $stmt004 = mysqli_query($conn, $sql);
    } else {
        $stmt004 = true;
    }

    if ($familias == 0) {
        $sql = "insert into PosUpvarios (venta,generaorden,IdCompany,IdVarios,TIPOITEM,ITEM,VALOR,pathimg,esserial,eslote) (select " . $v . "," . $c . "," . $_POST["companyUser"] . ",COALESCE(max(IdVarios),0)+1 as IdVarios,2,'" . $ModalItemcfamilia . "',0,'NULL'," . $a . "," . $b . " from PosUpvarios where IdCompany = " . $_POST["companyUser"] . " and TIPOITEM=2 )";
        $stmt005 = mysqli_query($conn, $sql);
    } else {
        $stmt005 = true;
    }

    if ($impuestos == 0) {
        $sql = "insert into PosUpvarios (IdCompany,IdVarios,TIPOITEM,ITEM,VALOR,pathimg,esserial,eslote) (select " . $_POST["companyUser"] . ",COALESCE(max(IdVarios),0)+1 as IdVarios,0,'" . $ModalItemcimpuesto . "'," . trim($_POST["ModalValorcimpuesto"] / 100) . ",'NULL',0,0 from PosUpvarios where IdCompany = " . $_POST["companyUser"] . "  and TIPOITEM=0 )";
        $stmt006 = mysqli_query($conn, $sql);
    } else {
        $stmt006 = true;
    }

    if ($productosservicios == 0) {
        if (trim($_POST["ModalIdfamiliacproductoyservicio"]) == "") {
            $query = "SELECT IdVarios FROM PosUpvarios WHERE IdCompany=" . $_POST["companyUser"] . " and TIPOITEM=2";
            if ($result = mysqli_query($conn, $query)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $IdVariosFam = $row["IdVarios"];
                }
                mysqli_free_result($result);
            }
        } else {
            $IdVariosFam = trim($_POST["ModalIdfamiliacproductoyservicio"]);
        }

        if (trim($_POST["ModalImpuestoscproductoyservicio"]) == "") {
            $query = "SELECT IdVarios FROM PosUpvarios WHERE IdCompany=" . $_POST["companyUser"] . " and TIPOITEM=0";
            if ($result = mysqli_query($conn, $query)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $IdVariosImp = $row["IdVarios"];
                }
                mysqli_free_result($result);
            }
        } else {
            $IdVariosImp = trim($_POST["ModalImpuestoscproductoyservicio"]);
        }

        if (trim($_POST["ModalMarcacproductoyservicio"]) == "") {
            $query = "SELECT idmarca FROM PosUpc_marcas WHERE IdCompany=" . $_POST["companyUser"] . "";
            if ($result = mysqli_query($conn, $query)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $idmarca = $row["idmarca"];
                }
                mysqli_free_result($result);
            }
        } else {
            $idmarca = trim($_POST["ModalMarcacproductoyservicio"]);
        }

        $sql = "insert into PosUpProducto (Comision,Comision2,Comision3,IdCompany,CodBarra,CodIdBasico,CodIdAmpliado,Descripcion,Medida,Impuesto,Costo,Margen,PrecioVenta,CostoNeto,PrecioNeto,Estado,RutUltimoProveedor,Envase,Idfamilia,Marca,Min,Max,Exis,PorKilo,EsCompuesto,bodega,sala,Margen2,Margen3,PrecioNeto2,PrecioNeto3,PrecioVenta2,PrecioVenta3,CantP1,UnidadP1,CantP2,UnidadP2) (select  '" . $comision . "', '" . $comision2 . "','" . $comision3 . "'," . $_POST["companyUser"] . ",'" . $ModalCodBarra . "',LPAD(CAST(COALESCE(max(CodIdBasico+1),0) as CHAR), 10, '0') as CodIdBasico," . $c . ",'" . $ModalDescripcioncproductoyservicio . "','" . $ModalMedida . "'," . $IdVariosImp . "," . trim($_POST["ModalCostoNetocproductoyservicio"]) . "," . trim($_POST["ModalMargencproductoyservicio"]) . "," . trim($_POST["ModalPrecioVentacproductoyservicio"]) . "," . trim($_POST["ModalCostoscproductoyservicio"]) . "," . trim($_POST["ModalPrecioNetocproductoyservicio"]) . ",1,0,'" . trim($_POST["ModalEnvasecproductoyservicio"]) . "'," . $IdVariosFam . "," . $idmarca . "," . trim($_POST["ModalMincproductoyservicio"]) . "," . trim($_POST["ModalMaxcproductoyservicio"]) . ",0," . $a . "," . $_POST['EsCompuesto'] . ",0,0,'" . trim($_POST["ModalMargen2cproductoyservicio"]) . "','" . trim($_POST["ModalMargen3cproductoyservicio"]) . "','" . trim($_POST["ModalPrecioNeto2cproductoyservicio"]) . "','" . trim($_POST["ModalPrecioNeto3cproductoyservicio"]) . "','" . trim($_POST["ModalPrecioVenta2cproductoyservicio"]) . "','" . trim($_POST["ModalPrecioVenta3cproductoyservicio"]) . "','" . trim($_POST["ModalCant2cproductoyservicio"]) . "','" . $medida2 . "','" . trim($_POST["ModalCant3cproductoyservicio"]) . "','" . $medida3 . "' from PosUpProducto where IdCompany=" . trim($_POST["companyUser"]) . ")";
        $stmt007 = mysqli_query($conn, $sql);
    } else {
        $stmt007 = true;
    }

    if (($stmt001 === true) and ($stmt002 === true) and ($stmt003 === true) and ($stmt004 === true) and ($stmt005 === true) and ($stmt006 === true) and ($stmt007 === true)) {
        $conn->commit();
        $_SESSION["Preguntar"] = 1;
        echo "1";
    } else {
        $conn->rollback();
        echo "0";
    }
}

if ($_POST["Accion"] == "7") {
    include "ambienteconsultas.php";
    $conn = conectar();

    $query = "select a.id,a.comercio,b.almacenes,c.ubicaciones,d.usuarios,e.estaciones,f.familias,g.impuestos,h.marcas,i.productosservicios from PosUpCompany a
        left join  (select idcompany,count(*) as almacenes from PosUpAlmacen group by idcompany) b on a.id=b.IdCompany 
        left join  (select idcompany,count(*) as ubicaciones from PosUpUbicacion group by idcompany) c on a.id=c.IdCompany 
        left join  (select idcompany,count(*) as usuarios from PosUpUsers group by idcompany) d on a.id=d.IdCompany 
        left join  (select idcompany,count(*) as estaciones from PosUpCompanyEstacion group by idcompany) e on a.id=e.IdCompany 
        left join  (select idcompany,count(*) as familias from PosUpvarios aa where aa.TIPOITEM = 2 group by idcompany) f on a.id=f.IdCompany 
        left join  (select idcompany,count(*) as impuestos from PosUpvarios aa where aa.TIPOITEM = 0 group by idcompany) g on a.id=g.IdCompany 
        left join  (select idcompany,count(*) as marcas from PosUpc_marcas aa  group by idcompany) h on a.id=h.IdCompany 
        left join  (select idcompany,count(*) as productosservicios from PosUpProducto aa where aa.escompuesto in (0,9)  group by idcompany) i on a.id=i.IdCompany 
        where a.id=" . $_POST["CompanyActual"];
    if ($result = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $almacenes = $row["almacenes"];
            $ubicaciones = $row["ubicaciones"];
            $usuarios = $row["usuarios"];
            $estaciones = $row["estaciones"];
            $familias = $row["familias"];
            $impuestos = $row["impuestos"];
            $marcas = $row["marcas"];
            $productosservicios = $row["productosservicios"];
        }
    }
    if (trim($almacenes) == "") {
        $almacenes = 0;
    }
    if (trim($ubicaciones) == "") {
        $ubicaciones = 0;
    }
    if (trim($usuarios) == "") {
        $usuarios = 0;
    }
    if (trim($estaciones) == "") {
        $estaciones = 0;
    }
    if (trim($familias) == "") {
        $familias = 0;
    }
    if (trim($impuestos) == "") {
        $impuestos = 0;
    }
    if (trim($marcas) == "") {
        $marcas = 0;
    }
    if (trim($productosservicios) == "") {
        $productosservicios = 0;
    }

    if (($almacenes == 0) || ($ubicaciones == 0) || ($usuarios == 0) || ($familias == 0) || ($impuestos == 0) || ($marcas == 0) || ($productosservicios == 0)) {
        echo "1";
    } else {
        $_SESSION["Preguntar"] = 1;
        echo "0";
    }
}

if ($_POST["Accion"] == "8") {
    $_SESSION["Preguntar"] = 1;
}

if ($_POST["Accion"] == "9") {
    include "ambienteconsultas.php";
    $conn = conectar();
    $query = "select a.id,a.comercio,b.almacenes,c.ubicaciones,d.usuarios,e.estaciones,f.familias,g.impuestos,h.marcas,i.productosservicios from PosUpCompany a
        left join  (select idcompany,count(*) as almacenes from PosUpAlmacen group by idcompany) b on a.id=b.IdCompany 
        left join  (select idcompany,count(*) as ubicaciones from PosUpUbicacion group by idcompany) c on a.id=c.IdCompany 
        left join  (select idcompany,count(*) as usuarios from PosUpUsers group by idcompany) d on a.id=d.IdCompany 
        left join  (select idcompany,count(*) as estaciones from PosUpCompanyEstacion group by idcompany) e on a.id=e.IdCompany 
        left join  (select idcompany,count(*) as familias from PosUpvarios aa where aa.TIPOITEM = 2 group by idcompany) f on a.id=f.IdCompany 
        left join  (select idcompany,count(*) as impuestos from PosUpvarios aa where aa.TIPOITEM = 0 group by idcompany) g on a.id=g.IdCompany 
        left join  (select idcompany,count(*) as marcas from PosUpc_marcas aa  group by idcompany) h on a.id=h.IdCompany 
        left join  (select idcompany,count(*) as productosservicios from PosUpProducto aa where aa.escompuesto in (0,9)  group by idcompany) i on a.id=i.IdCompany 
        where a.id=" . $_POST["CompanyActual"];
    if ($result = mysqli_query($conn, $query)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $almacenes = $row["almacenes"];
            $ubicaciones = $row["ubicaciones"];
            $usuarios = $row["usuarios"];
            $estaciones = $row["estaciones"];
            $familias = $row["familias"];
            $impuestos = $row["impuestos"];
            $marcas = $row["marcas"];
            $productosservicios = $row["productosservicios"];
        }
    }
    if (trim($almacenes) == "") {
        $almacenes = 0;
    }
    if (trim($ubicaciones) == "") {
        $ubicaciones = 0;
    }
    if (trim($usuarios) == "") {
        $usuarios = 0;
    }
    if (trim($estaciones) == "") {
        $estaciones = 0;
    }
    if (trim($familias) == "") {
        $familias = 0;
    }
    if (trim($impuestos) == "") {
        $impuestos = 0;
    }
    if (trim($marcas) == "") {
        $marcas = 0;
    }
    if (trim($productosservicios) == "") {
        $productosservicios = 0;
    }

    ?>
    <span id="StarterOpcionalmacenes"><?php echo $almacenes; ?></span>
    <span id="StarterOpcionubicaciones"><?php echo $ubicaciones; ?></span>
    <span id="StarterOpcionusuarios"><?php echo $usuarios; ?></span>
    <span id="StarterOpcionestaciones"><?php echo $estaciones; ?></span>
    <span id="StarterOpcionfamilias"><?php echo $familias; ?></span>
    <span id="StarterOpcionimpuestos"><?php echo $impuestos; ?></span>
    <span id="StarterOpcionmarcas"><?php echo $marcas; ?></span>
    <span id="StarterOpcionproductosservicios"><?php echo $productosservicios; ?></span>
<?php
}

if ($_POST["Accion"] == "50") {
    include "ambiente.php";
    $conn = conectar();
    echo StockNone($conn, $_POST, $_REQUEST);
}

if ($_POST["Accion"] == "ActualizarTasaBCV") {
    include "ambiente.php";
    $conn = conectar();
    echo json_encode(ActualizarTasaBCV($conn, $_POST), JSON_UNESCAPED_UNICODE);
}
?>