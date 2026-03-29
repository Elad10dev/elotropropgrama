<?php

use Dom\Document;


if ($_POST["Accion"] === "cleanidben") {
	session_start();
	$_SESSION["idben"] = "";
}


if ($_POST["Accion"] == "1") {
	include "ambienteconsultas.php";
	$conn = conectar();

	if ($_POST["Ini"] == "0") {
?>
		<table class="table nowrap" id="estadocbtable" cellspacing="0" style="width:100%">
			<thead>
				<tr>
					<th class="text-center"><?php echo lang("Tx"); ?></th>
					<th class="text-center"><?php echo lang("Idtx"); ?></th>
					<th class="text-center"><?php echo lang("Fecha"); ?></th>
					<th class="text-end"><?php echo lang("Total") . " (" . $_POST["MonedaP"] . ")"; ?></th>
					<th class="text-end"><?php echo lang("Contado") . " (" . $_POST["MonedaP"] . ")"; ?></th>
					<th class="text-end"><?php echo lang("Crédito") . " (" . $_POST["MonedaP"] . ")"; ?></th>
					<th class="text-start"><?php echo lang("Beneficiario"); ?></th>
				</tr>
			</thead>
		</table>
		<?php
	}

	if ($_POST["Ini"] == "1") {
		$request = $_REQUEST;
		$col = array(
			0   =>  'Tx',
			1   =>  'Idtx',
			2   =>  'Fecha',
			3   =>  'Total',
			4   =>  'Contado',
			5   =>  'Credito',
			6   =>  'IdBen,NomBeneficiario',
		);
		$buscar = "";
		if ($_POST["Modaldesde"] <> "") {
			$buscar = $buscar . " and a.Fectxclient >='" . trim($_POST["Modaldesde"]) . "'";
		}
		if ($_POST["Modalhasta"] <> "") {
			$buscar = $buscar . " and a.Fectxclient < '" . trim($_POST["Modalhasta"]) . "'";
		}
		if ($_POST["Modaltipotrans"] == "*") {
			$buscar = $buscar . " and b.caja <> 0 and a.Idtipotx <> 1";
		} else {
			$buscar = $buscar . " and a.Idtipotx = '" . trim($_POST["Modaltipotrans"]) . "'";
		}
		if ($_POST["Modalnroid"] <> "") {
			$buscar = $buscar . " and Concat(a.Referencia ,a.DTE,a.IdTxCompany,a.Idtx) like'%" . trim($_POST["Modalnroid"]) . "%'";
		}
		if ($_POST["Modalmodalidad"] == "1") {
			$buscar = $buscar . " and a.Contado <> 0 ";
		}
		if ($_POST["Modalmodalidad"] == "2") {
			$buscar = $buscar . " and a.Credito <> 0 ";
		}
		$sql = "SELECT a.Total*b.caja as Total,a.Contado*b.caja as Contado,a.Credito*b.caja As Credito,b.TitCto as Tx,a.Idtipotx,a.IdEstacion,if(a.Referencia='',if (a.DTE=0,if (a.IdTxCompany<>0,a.IdTxCompany,a.Idtx),a.DTE),a.Referencia ) as Idtx,DATE_FORMAT(a.Fectxclient,'%d/%m/%Y %h:%i:%s %p') as Fecha ,a.IdBen,d.Nombre as NomBeneficiario from PosUpTxC a left Join PosUpTx b on a.Idtipotx=b.Idtipotx left join PosUpclientes d on a.IdBen = d.rut and a.Idcompany=d.Idcompany WHERE a.IdCompany=" . $_POST["CompanyActual"] . $buscar;
		$query = mysqli_query($conn, $sql);
		$totalData = mysqli_num_rows($query);
		$totalFilter = $totalData;
		if (!empty($request['search']['value'])) {
			if (!empty($request['search']['value'])) {
				$sql .= " AND ( Tx Like '%" . $request['search']['value'] . "%'";
				$sql .= " OR Idtx Like '%" . $request['search']['value'] . "%' ";
				$sql .= " OR Fecha Like '%" . $request['search']['value'] . "%' ";
				$sql .= " OR NomBeneficiario Like '%" . $request['search']['value'] . "%' ";
				$sql .= " OR IdBen Like '%" . $request['search']['value'] . "%' )";
			}
		}
		$query = mysqli_query($conn, $sql);
		$totalData = mysqli_num_rows($query);
		if ($col[$request['order'][0]['column']] && $request['order'][0]['dir']) {
			$sql .= " ORDER BY " . $col[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'] . "";
		}

		$sql .= " LIMIT " . $request['start'] . "  ," . $request['length'] . "  ";
		$query = mysqli_query($conn, $sql);
		$data = array();
		while ($row = mysqli_fetch_array($query)) {
			$subdata = array();
			if ($row["Tx"] == "") {
				$Tx = "-";
			} else {
				$Tx = $row["Tx"];
			}
			if ($row["Idtx"] == "") {
				$Idtx = "-";
			} else {
				$Idtx = $row["Idtx"];
			}
			if ($row["Fecha"] == "") {
				$Fecha = "-";
			} else {
				$Fecha = $row["Fecha"];
			}
			$subdata[] = $Tx . " -> " . "<div class='btn-group'><button class='btn btn-primary' type='button' onclick='Editar(`" . $row['IdBen'] . "`,`" . $row['NomBeneficiario'] . "`);'>  <i class='fa fa-user'></i></button></div>";
			$subdata[] = $Idtx;
			$subdata[] = $Fecha;
			$subdata[] = "<div class='text-end'>" . number_format(trim($row['Total']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . "</div>";
			$subdata[] = "<div class='text-end'>" . number_format(trim($row['Contado']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . "</div>";
			$subdata[] = "<div class='text-end'>" . number_format(trim($row['Credito']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . "</div>";
			$subdata[] = $row['IdBen'] . ' - ' . $row['NomBeneficiario'];
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
}

if ($_POST["Accion"] === "2") {

	include "ambienteconsultas.php";
	$conn = conectar();

	echo TableResponse($conn, $_POST);
}

// =====================================================================
// BUSCAR TASA HISTÓRICA POR FECHA (USANDO TABLA OFICIAL JSON BCV)
// =====================================================================
if ($_POST["Accion"] === "BuscarTasaPorFecha") {
    include "ambienteconsultas.php";
    $conn = conectar();
    
    $fecha = trim($_POST['Fecha']); // Formato YYYY-MM-DD
    $company = trim($_POST['CompanyActual']);
    $tasa_encontrada = 0;
    
    // 1. Buscamos en posuptasasbcv. 
    // Usamos SUBSTRING para ignorar el " GMT-03:00" y comparar solo la fecha.
    $sqlBCV = "SELECT tasas FROM posuptasasbcv 
               WHERE SUBSTRING(fecha_valor_bcv, 1, 10) <= '$fecha' 
               ORDER BY SUBSTRING(fecha_valor_bcv, 1, 10) DESC 
               LIMIT 1";
               
    $resBCV = mysqli_query($conn, $sqlBCV);
    
    if ($resBCV && mysqli_num_rows($resBCV) > 0) {
        $rowBCV = mysqli_fetch_assoc($resBCV);
        $json_tasas = $rowBCV['tasas'];
        
        // Decodificamos el string JSON que trae la BD: {"DOLAR":"...","EURO":"..."}
        $data_tasas = json_decode($json_tasas, true);
        
        // Si existe el valor DOLAR, lo extraemos
        if(isset($data_tasas['DOLAR'])) {
            $tasa_encontrada = (float)$data_tasas['DOLAR'];
        }
    }
    
    // 2. Retornar el resultado. Si falló la tabla BCV, usamos el Fallback de la empresa.
    if ($tasa_encontrada > 0) {
        echo json_encode([
            "status" => true, 
            "tasa" => number_format($tasa_encontrada, 8, '.', '')
        ]);
    } else {
        // Fallback: Tasa actual de la empresa
        $sqlActual = "SELECT FactorDolarCash FROM PosUpCompany WHERE Id = '$company' LIMIT 1";
        $resActual = mysqli_query($conn, $sqlActual);
        if ($resActual && mysqli_num_rows($resActual) > 0) {
            $rowActual = mysqli_fetch_assoc($resActual);
            echo json_encode([
                "status" => true, 
                "tasa" => number_format((float)$rowActual['FactorDolarCash'], 8, '.', '')
            ]);
        } else {
            echo json_encode(["status" => false, "tasa" => 1]);
        }
    }
    exit;
}
// =====================================================================

if ($_POST["Accion"] === "GuardarBeneficiario") {
	include "ambiente.php";
	$conn = conectar();

	echo GuardarBeneficiario($conn, $_POST);
}

if ($_POST["Accion"] === "DeleteAnticipo") {
	include "ambiente.php";
	$conn = conectar();

	echo DeleteAnticipo($conn, $_POST);
}

if ($_POST["Accion"] === "DeletePago") {
	include "ambiente.php";
	$conn = conectar();

	echo EliminarPago($conn, $_POST);
}

if ($_POST["Accion"] === "AnticipadosCrud") {
	include "ambienteconsultas.php";
	$conn = conectar();

	echo AnticipadosCrud($conn, $_POST, $_REQUEST);
}
if ($_POST["Accion"] === "BuscarTasaPorFecha") {
    include "ambienteconsultas.php";
    $conn = conectar();
    
    $fecha = $_POST['Fecha'];
    $company = $_POST['CompanyActual'];
    
    // 1. Buscamos si existe una tasa guardada para esa fecha exacta en el historial
    // (Asegúrate de que el nombre de la tabla 'posuptasas_historia' sea el correcto en tu BD)
    $sql = "SELECT tasa_valor FROM posuptasas_historia 
            WHERE IdCompany = '$company' AND fecha_tasa = '$fecha' 
            LIMIT 1";
            
    $result = mysqli_query($conn, $sql);
    
    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode([
            "status" => true, 
            "tasa" => $row['tasa_valor']
        ]);
    } else {
        // 2. Fallback: Si no hay historial para ese día, traemos la tasa actual de la empresa
        $sqlActual = "SELECT FactorDolarCash FROM PosUpCompany WHERE Id = '$company'";
        $resActual = mysqli_query($conn, $sqlActual);
        $rowActual = mysqli_fetch_assoc($resActual);
        
        echo json_encode([
            "status" => true, 
            "tasa" => $rowActual['FactorDolarCash']
        ]);
    }
    exit;
}
function DeleteAnticipo($conn, $post)
{
	$IdCompany = -1;
	$Idtipotx = -1;
	$Idtx = -1;
	$IdEstacion = -1;
	$query = "SELECT IdCompany,Idtipotx,Idtx,IdEstacion from PosUpTxC WHERE IdBarcode = " . $post["IdBarcode"] . " and IdCompany = " . $post["CompanyActual"];
	if ($result = mysqli_query($conn, $query)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$IdCompany = $row['IdCompany'];
			$Idtipotx = $row['Idtipotx'];
			$Idtx = $row['Idtx'];
			$IdEstacion = $row['IdEstacion'];
		}
		mysqli_free_result($result);
	}

	$conn->autocommit(FALSE);
	if ($IdCompany !== -1 && $Idtipotx !== -1 && $Idtx !== -1 && $IdEstacion !== -1) {
		$statement = "DELETE FROM PosUpTxP WHERE IdCompany = " . $IdCompany . " and Idtipotx = " . $Idtipotx . " and Idtx = " . $Idtx . " and IdEstacion = '" . $IdEstacion . "'";
		$result =  mysqli_query($conn, $statement);
		if ($result === true) {
			$statement = "DELETE FROM PosUpTxC WHERE IdCompany = " . $IdCompany . " and Idtipotx = " . $Idtipotx . " and Idtx = " . $Idtx . " and IdEstacion = '" . $IdEstacion . "'";
			$result =  mysqli_query($conn, $statement);
			if ($result === true) {
				$conn->commit();
				return json_encode(["status" => true]);
			}
			$conn->rollback();
			return json_encode(["status" => false]);
		}
		$conn->rollback();
		return json_encode(["status" => false]);
	}
	return json_encode(["status" => false]);
}

function GuardarBeneficiario($conn, $post)
{
    $can = 0;

    $sql = "select count(IdCompany) as Cantidad from PosUpclientes where IdCompany =" . $post["CompanyActual"] . " and RUT = '" . trim($post["Rut"]) . "'";
    if ($result = mysqli_query($conn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $can = intval($row["Cantidad"]);
        }
    }
    
    if ($can === 0) {
        // 1. CAPTURAR LOS NUEVOS CAMPOS (Evita que queden en blanco)
        $tipoPersona = isset($post["TipoPersona"]) ? trim($post["TipoPersona"]) : 'PN';
        $domicilio = isset($post["Domicilio"]) ? trim($post["Domicilio"]) : 'DOM';

        // 2. AGREGARLOS A LA CONSULTA SQL (Al final de la lista de columnas y valores)
        $sql = "insert into PosUpclientes (IdCompany,RUT,Nombre,Fono,Direccion,TipoCredito,EstadoCredito,DeudaMaxBoleta,DeudaMaxLibreta,FechPago1,FechPago2,NroCorr,Comuna,Giro,CreditoFactura,CreditoUsado,Estado,EsCliente,EsProveedor,EsTrabajador,EsOtro,email,provincia,region,ciudad,Latitud,Longitud, TipoBenef, TipoPersona, Domicilio) values(" . $post["CompanyActual"] . ",'" . trim($post["Rut"]) . "','" . substr(trim($post["anombreFA"]), 0, 50) . "','" . trim($post["TelefonoFA"]) . "','" . trim($post["DirecionFA"]) . "','',0,0,0,0,0,0,'','" . trim($post["GiroFA"]) . "',0,0,'1','1','0','0','0','" . trim($post["EmailFA"]) . "','','','" . trim($post["CiudadFA"]) . "',0,0,'" . $post["TipoBeneficiario"] . "', '" . $tipoPersona . "', '" . $domicilio . "')";
        
        $stmt = mysqli_query($conn, $sql);
        if ($stmt === true) {
            return json_encode(["status" => true, "msg" => 1]);
        } else {
            // Nota: Se quitó mysqli_free_result porque INSERT no devuelve un result set, sino un boolean.
            return json_encode(["status" => false, "msg" => 2]);
        }
    }
    return json_encode(["status" => false, "msg" => 3]);
}
/*
function TableResponse($conn, $post)
{
	$Saldo = 0;
	$n = 0;
	$buscar = "";

	if ($post["MostrarTodos"] === "1") {
		$buscar .= " and ((Pagos.Fectxclient >= '" . trim($post["Modaldesde"]) . "' and Pagos.Fectxclient <= '" . trim($post["Modalhasta"]) . "' and a.Credito = 0) or (a.Credito <> 0))";
	}

	$query = "SELECT coalesce(adev.idBarcode,a.idBarcode) as orrd,if(a.Idtipotx in (27,3),a.IdtxPadre,0) as IdtxAsoc,if(a.Idtipotx in (27,3),a.IdtipotxPadre,0) as IdtipotxAsoc,a.IdEstacion, a.Idtipotx ,a.Idtx as IdtxDef,
	if(a.Idtipotx in (27,3),a.IdEstacionPadre,0) as IdEstacionAsoc,d.Nombre as Usuario,if(Pagos.Caja2<>-1,Pagos.Caja2,Pagos.Caja) as Caja,Pagos.tiporetencion,Pagos.Idtipotx as ElCodi,Pagos.tasa as tasaDef,Pagos.montoretencion as Retencion,Pagos.item,Pagos.Contado*b.Caja as Contado,b.Titulo,Pagos.Credito*b.Caja as Credito ,Pagos.Anticipo*b.Caja as anticipo ,Pagos.Efectivo,Pagos.Tarjeta ,Pagos.Cheque ,Pagos.Tipo01 ,Pagos.Tipo02 ,Pagos.Tipo03 ,Pagos.Tipo04 ,Pagos.Anticipo ,Pagos.TarjetaD ,Pagos.ChequeD ,Pagos.Tipo01D ,Pagos.Tipo02D ,Pagos.Tipo03D ,Pagos.Tipo04D ,Pagos.AnticipoD ,Pagos.Fectxclient as FechaPag,coalesce(bdev.TitCto,b.TitCto) as txOrden,coalesce(if(adev.Referencia='',if (adev.IdTxCompany<>0,adev.IdTxCompany,adev.Idtx),adev.Referencia),if(a.Referencia='',if (a.IdTxCompany<>0,a.IdTxCompany,a.Idtx),a.Referencia)) as IdtxOrden,b.TitCto as Tipo , b.Idtipotx  , if(if(a.Idtipotx in (1,2,3,4,5,6,11,12,13,15,21,22,23,24,25,26,31,35,36,37),company.NumTxViewVTA,if(a.Idtipotx in (7,14,20,27,28),company.NumTxViewCOM,if(a.Idtipotx in (8,9,10,16,17,18,19,29,30,32,33,34,39),company.NumTxViewINV,''))) = 0,a.IdtxCompany,if(if(a.Idtipotx in (1,2,3,4,5,6,11,12,13,15,21,22,23,24,25,26,31,35,36,37),company.NumTxViewVTA,if(a.Idtipotx in (7,14,20,27,28),company.NumTxViewCOM,if(a.Idtipotx in (8,9,10,16,17,18,19,29,30,32,33,34,39),company.NumTxViewINV,''))) = 1,a.Idtx,a.Referencia)) as Idtx, if(a.Referencia='',if (a.DTE=0,if (a.IdTxCompany<>0,'',f.etiqueta),''),'') as Etiqueta,f.etiqueta as etiqueta2,fff.etiqueta as etiqueta3, bdev.TitCto as TipoDev, if(adev.Referencia='',if (adev.DTE=0,if (adev.IdTxCompany<>0,adev.IdTxCompany,adev.Idtx),adev.DTE),adev.Referencia) as Idtxdev, h.Nombre as Ubicacion,a.Fectxclient as Fecha,DATE_FORMAT(Pagos.Fectxclient,'%d/%m/%Y<br>%h:%i:%s %p') AS Fecha2 , coalesce(adev.Fectxclient ,a.Fectxclient) as FectxOrden,a.TxfecVence as Vencimiento, DATEDIFF('" . $post["Fecha"] . " 23:59:59',DATE(coalesce(adev.TxfecVence ,a.TxfecVence))) as Dias_Vencidos,c.Nombre as Beneficiario, a.IdBen as RUT, c.Fono as Telefono ,coalesce(((a.Contado*b.Caja+a.Credito*b.Caja)),0) as Total_Operacion2,Pagos.MontoPagar as Total_Operacion, a.tasa as Tasa , c.Email as Correo, if(a.UserVendedor='0','COMERCIO',e.Nombre) as Vendedor ,count(detalle.idtx) as Detalle,count(Pagos.idtx) as Pagos,a.IdBarcode,company.LitEfectivo,company.LitTarjeta,company.LitCheque,company.LitO01,company.LitO02,company.LitO03,company.LitO04,DATE_FORMAT(a.TxfecVence,'%d/%m/%Y') as TxfecVence
	,a.IdTxCompany, max(Pagos.item) as lastItem,Pagos.numret
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
	left join PosUpTxP Pagos on a.IdCompany = Pagos.IdCompany and a.IdEstacion = Pagos.IdEstacion and a.Idtipotx = Pagos.Idtipotx and a.Idtx = Pagos.Idtx 
	left join PosUpUsers d on Pagos.IdCompany = d.IdCompany and Pagos.Login = d.Login 
	left join PosUpCompanyEstacion fff on Pagos.IdCompany = fff.IdCompany and if(Pagos.Caja2<>-1,Pagos.IdEstacion2,Pagos.IdEstacion)= fff.token 
	where a.IdCompany = " . trim($post["CompanyActual"]) . " 
	AND a.Idben='" . $post['IdBen'] . "' 
	AND b.Idtipotx in (1,2,3,7,15,22,27,28)
	" . $buscar . "
	group by txOrden,IdtxOrden,b.TitCto,Idtx,Item 
	";
	// order by  Pagos.Fectxclient asc
	if ($post["OrderBy"] === "Fectxclient") {
		$query .= " order by
		orrd " . $post["SortBy"] . ",
		txOrden,
		IdtxOrden,
		Pagos.Item,
		Pagos.Fectxclient ASC ";
	}

	$query .= "limit 50";

	$SaldoVencido = 0;
	$MontoTotal = 0;
	$CreditoTotal = 0;
	$ContadoTotal = 0;

	$ContadoTotal2 = 0;
	$array = [];
	$tableResponse = [];
	$x = 0;
	if ($result = mysqli_query($conn, $query)) {
		while ($row = mysqli_fetch_assoc($result)) {

			$Idtx = $row["IdtxDef"];
			$Idtipotx = $row["Idtipotx"];
			$IdEstacion = $row["IdEstacion"];
			$Contado = 0;
			$Credito = 0;
			$Credito2 = 0;
			$CreditoTxP = 0;
			$ContadoTxP = 0;
			$CreditoTxP2 = 0;
			$ContadoTxP2 = 0;
			$Retencion = 0;
			$Retencion2 = 0;
			$Retencion3 = 0;
			$m = 0;
			$query2x = "select
				a.Total as MontoAPagar,
				coalesce(bdev.TitCto, b.TitCto) as txOrden,
				Pagos.tasa as tasap,
				a.tasa as tasa,
				a.IdEstacion ,
				Pagos.montoretencion as Retencion,
				Pagos.Contado as Contado,
				Pagos.Credito as Credito ,
				Pagos.Item,
				coalesce(if(adev.Referencia = '', if (adev.IdTxCompany <> 0, adev.IdTxCompany, adev.Idtx), adev.Referencia), if(a.Referencia = '', if (a.IdTxCompany <> 0, a.IdTxCompany, a.Idtx), a.Referencia)) as IdtxOrden,
				b.Idtipotx as Idtipotx,
				a.Idtx
			from
				PosUpTxC a
			inner join PosUpTx b on
				a.Idtipotx = b.Idtipotx
			left join PosUpTxC adev on
				a.IdCompany = adev.IdCompany
				and a.IdEstacionPadre = adev.IdEstacion
				and a.IdtipotxPadre = adev.Idtipotx
				and a.IdtxPadre = adev.Idtx
				and adev.Idtipotx in (1, 2, 7, 15, 22, 28)
			left join PosUpTx bdev on
				adev.Idtipotx = bdev.Idtipotx
			inner join PosUpTxP Pagos on
				a.IdCompany = Pagos.IdCompany
				and a.IdEstacion = Pagos.IdEstacion
				and a.Idtipotx = Pagos.Idtipotx
				and a.Idtx = Pagos.Idtx
			where a.IdCompany = " . trim($post["CompanyActual"]) . " and a.Idben='" . $post['IdBen'] . "' and b.Idtipotx in (1,2,3,7,15,22,27,28) 
			group by IdtxOrden,txOrden,b.TitCto,Pagos.Item,a.IdBarcode 
			HAVING IdtxOrden='" . $row["IdtxOrden"] . "' and txOrden = '" . $row["txOrden"] . "'  order by IdtxOrden asc";

			if ($result2 = mysqli_query($conn, $query2x)) {
				while ($row2 = mysqli_fetch_assoc($result2)) {
					$m++;

					if (($row2["Idtipotx"] === "3") or ($row2["Idtipotx"] === "27")) {
						$Contado -= (($row2["Retencion"] / ($row2["tasap"] > 0 ? $row2["tasap"] : 1)) + ($row2["Contado"] / ($row2["tasap"] > 0 ? $row2["tasap"] : 1))) - ($row2["Credito"] / ($row2["tasap"] > 0 ? $row2["tasap"] : 1));
						$Credito -= ($row2["Credito"] / ($row2["tasap"] > 0 ? $row2["tasap"] : 1)) - (($row2["Retencion"] / ($row2["tasap"] > 0 ? $row2["tasap"] : 1)) + ($row2["Contado"] / ($row2["tasap"] > 0 ? $row2["tasap"] : 1)));
						$CreditoTxP -= ($row2["Credito"] / ($row2["tasap"] > 0 ? $row2["tasap"] : 1));
						$ContadoTxP -= (($row2["Contado"] / ($row2["tasap"] > 0 ? $row2["tasap"] : 1)) + ($row2["Retencion"] / ($row2["tasap"] > 0 ? $row2["tasap"] : 1)));
						$CreditoTxP2 -= $row2["Credito"];
						$ContadoTxP2 -= ($row2["Contado"] + $row2["Retencion"]);
					} else {

						$Contado += (($row2["Retencion"] / ($row2["tasap"] > 0 ? $row2["tasap"] : 1)) + ($row2["Contado"] / ($row2["tasap"] > 0 ? $row2["tasap"] : 1))) - ($row2["Credito"] / ($row2["tasap"] > 0 ? $row2["tasap"] : 1));
						$Credito += ($row2["Credito"] / ($row2["tasap"] > 0 ? $row2["tasap"] : 1)) - (($row2["Retencion"] / ($row2["tasap"] > 0 ? $row2["tasap"] : 1)) + ($row2["Contado"] / ($row2["tasap"] > 0 ? $row2["tasap"] : 1)));
						$CreditoTxP += ($row2["Credito"] / ($row2["tasap"] > 0 ? $row2["tasap"] : 1));
						$ContadoTxP += (($row2["Contado"] / ($row2["tasap"] > 0 ? $row2["tasap"] : 1)) + ($row2["Retencion"] / ($row2["tasap"] > 0 ? $row2["tasap"] : 1)));
						$CreditoTxP2 += $row2["Credito"];
						$ContadoTxP2 += $row2["Contado"] + $row2["Retencion"];
					}



					$tasa = $row2["tasa"];
					$MontoAPagar = $row2["MontoAPagar"];
					$MontoAPagar2 = $row2["MontoAPagar"] * ($row2["tasap"] > 0 ? $row2["tasap"] : 1);
				}
			}

			if ($post["MostrarTodos"] === "1" || ($post["MostrarTodos"] === "0" && (ROUND($Contado, 1)  <> 0))) {
				if ($row["Tasa2"] > 0) {
					$Saldo = $Saldo + ROUND(($row["Retencion"] / ($row["Tasa2"] > 0 ? $row["Tasa2"] : 1)), 2);
					if ($row['item'] > 1) {
						$Saldo = $Saldo + ROUND(($row["Contado"] / ($row["Tasa2"] > 0 ? $row["Tasa2"] : 1)), 2);
					} else if ($row["Idtipotx"] === "4" || $row["Idtipotx"] === "5") {
						$Saldo = $Saldo + ROUND(($row["Contado"] / ($row["Tasa2"] > 0 ? $row["Tasa2"] : 1)), 2);
					}

					if ($row["Idtipotx"] === "7" || $row["Idtipotx"] === "28") {
						$Saldo = $Saldo - ROUND((abs($row["Credito"]) / ($row["Tasa2"] > 0 ? $row["Tasa2"] : 1)), 2);
					} else {

						$Saldo = $Saldo - ROUND((($row["Credito"]) / ($row["Tasa2"] > 0 ? $row["Tasa2"] : 1)), 2);
					}
				}
				$n++;
				$Tipa = "";
				if ($row['Tipo'] <> "") {
					$Tipa .= $row['Tipo'] . "-";
				} else if ($row['Etiqueta'] <> "") {
					$Tipa .= $row['Etiqueta'] . "-";
				}
				if ($row['Idtx'] <> "") {
					$Tipa .= str_pad($row['Idtx'], 6, "0", STR_PAD_LEFT) . " ";
				}

				$Documento = "";

				if (round($row['Contado']) <> 0 && $row['item'] > 1) {
					$Medio = "";

					if ($row["Efectivo"] <> 0) {
						$Medio = $row["LitEfectivo"];
					} else if ($row["Tarjeta"] <> 0) {
						$Medio = $row["LitTarjeta"];
					} else if ($row["Cheque"] <> 0) {
						$Medio = $row["LitCheque"];
					} else if ($row["Tipo01"] <> 0) {
						$Medio = $row["LitO01"];
						$Tipo01D = explode("|", $row["Tipo01D"]);
						if ($Tipo01D) $Medio .= " (" . $Tipo01D[0] . ") ";
					} else if ($row["Tipo02"] <> 0) {
						$Medio = $row["LitO02"];
					} else if ($row["Tipo03"] <> 0) {
						$Medio = $row["LitO03"];
					} else if ($row["Tipo04"] <> 0) {
						$Medio = $row["LitO04"];
					} else if ($row["Anticipo"] <> 0) {
						$Medio = lang("Anticipo Utilizado");
					}

					if ($row['Contado'] > 0) {
						$Documento .= "<span class='badge bg-info text-dark'>" . lang("Pago");
					} else if ($row["Idtipotx"] === "3" || $row["Idtipotx"] === "27") {
						$Documento .= "<span class='badge bg-info text-dark'>" . lang("Pago");
					} else {
						$Documento .= "<span class='badge bg-info text-dark'>" . lang("Vuelto");
					}

					$Documento .= " " . $Medio . "</span>";
					$Documento .= "<br><span class='badge bg-warning text-dark'>" . $Tipa . "</span>";
					$Documento .= "<br><span class='badge bg-light text-dark'>Nro. " . strtoupper(str_pad($row['IdTxCompany'], 8, "0", STR_PAD_LEFT)) . "</span>";
					$Documento .= '<br>' . number_format($row['Contado'] / ($row["Tasa2"] > 0 ? $row["Tasa2"] : 1), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' x ' . number_format($row['Tasa2'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' = ' . number_format($row['Contado'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
				}
				if (round($row['Credito']) <> 0 && $row['item'] > 1) {
					$Documento .= "<span class='badge bg-danger text-light'>" . lang("Crédito") . "</span>";
					$Documento .= '<br>' . number_format(($row['Credito'] / ($row["Tasa2"] > 0 ? $row["Tasa2"] : 1)), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' x ' . number_format($row['Tasa2'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' = ' . number_format($row['Credito'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
				}
				if (trim($row['tiporetencion']) == "0" && $row['item'] > 1 && round($row['Retencion']) <> 0) $Documento .= lang("Ret. Impto");
				if (trim($row['tiporetencion']) == "1" && $row['item'] > 1 && round($row['Retencion']) <> 0) {
					$Documento .= lang("Ret. I.S.L.R");
					$Nombre = "";
					$query2 = "SELECT Nombre FROM PosUpRetencion WHERE TipoRet = 1 and IdCompany=" . $_POST["CompanyActual"] . " AND NumLit = '" . $row["numret"] . "' ";
					if ($result2 = mysqli_query($conn, $query2)) {
						while ($row2 = mysqli_fetch_assoc($result2)) {
							$Nombre = $row2["Nombre"];
						}
					}
					$Documento .= " (" . $Nombre . ") ";
				}
				if (trim($row['tiporetencion']) == "2" && $row['item'] > 1 && round($row['Retencion']) <> 0) $Documento .= lang("Ret. Mun");
				if ($row['item'] > 1 && round($row['Retencion']) <> 0) $Documento .= '<br>' . number_format(($row['Retencion'] / ($row["Tasa2"] > 0 ? $row["Tasa2"] : 1)), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' x ' . number_format($row['Tasa2'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' = ' . number_format($row['Retencion'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);


				if ($row['item'] <= 1) {
					$Documento .= $row['Titulo'];
					if ($row['TipoDev'] <> "") $Documento .= "<br>(" . $row['TipoDev'] . "-";
					if ($row['Idtxdev'] <> "" && $row['TipoDev'] <> "") $Documento .=  str_pad($row['Idtxdev'], 6, "0", STR_PAD_LEFT) . ") ";
					$Documento .= '<br>' . number_format(abs($row['Credito']) / ($row["Tasa2"] > 0 ? $row["Tasa2"] : 1), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' x ' . number_format($row['Tasa2'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' = ' . number_format(abs($row['Credito']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
					$Documento .= "<br><span class='badge bg-warning text-dark'>" . $Tipa . "</span>";
					$Documento .= "<br><span class='badge bg-light text-dark'>Nro. " . strtoupper(str_pad($row['IdTxCompany'], 8, "0", STR_PAD_LEFT)) . "</span>";
				}

				$ExtraData = "";
				if (($row["ElCodi"] === "1" or $row["ElCodi"] === "2" or $row["ElCodi"] === "7") && $row['item'] === "1") $ExtraData .= "<i class='fa fa-file-text-o'></i>";
				if (($row["ElCodi"] === "22" or $row["ElCodi"] === "28" or $row["ElCodi"] === "15") && $row['item'] === "1") $ExtraData .= "<i class='fa fa-truck'></i>";
				if (($row["ElCodi"] === "3" or $row["ElCodi"] === "27") && $row['item'] === "1") $ExtraData .= "<i class='fa fa-undo'></i>";

				if ($row['Contado'] > 0 && $row['item'] <> "1") $ExtraData .= "<i class='fa fa-plus'></i>";
				if ($row['Contado'] < 0 && $row['item'] <> "1") $ExtraData .= "<i class='fa fa-minus'></i>";
				if ($row['Retencion'] <> 0 && $row['item'] <> "1") $ExtraData .= "<i class='fa fa-percent'></i>";
				if ($row['Credito'] <> 0 && $row['item'] <> "1") $ExtraData .= "<i class='fa fa-minus'></i>";

				$Monto = 0;

				if (round($row['Contado']) <> 0 && $row['item'] > 1) {
					$Monto = $row['Contado'] / ($row["Tasa2"] > 0 ? $row["Tasa2"] : 1);
				} else if (round($row['Credito']) <> 0 && $row['item'] > 1) {
					$Monto = $row['Credito'] / ($row["Tasa2"] > 0 ? $row["Tasa2"] : 1);
				} else if (round($row['Retencion']) <> 0 && $row['item'] > 1) {
					$Monto = $row['Retencion'] / ($row["Tasa2"] > 0 ? $row["Tasa2"] : 1);
				} else if ($row['item'] <= 1) {
					$Monto = $row['Total_Operacion'];
				}

				$MontoCont = "";
				if (round($row['Contado']) <> 0) $MontoCont .= ($row['Contado'] / ($row["Tasa2"] > 0 ? $row["Tasa2"] : 1)) * $tasa;

				if (round($row['Retencion']) <> 0) $MontoCont .= ($row['Retencion'] / ($row["Tasa2"] > 0 ? $row["Tasa2"] : 1)) * $tasa;

				if ((round($row['Retencion']) == 0) and (round($row['Contado']) == 0)) $MontoCont .= ($row['Contado'] / ($row["Tasa2"] > 0 ? $row["Tasa2"] : 1)) * $tasa;

				$Credito = $row['Credito'];

				$Credito2 = $CreditoTxP;

				$Credito2 += ($ContadoTxP * -1);


				$SaldoA = number_format(ROUND($Saldo, 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);

				$button = "";

				if ($row["Idtipotx"] === "25") $button .= "<button class='btn btn-light' title='" . lang("Eliminar") . "' onclick='EliminarAnticipo(`" . $Idtx . "`,`" . $Idtipotx . "`,`" . $IdEstacion . "`,`" . $row["item"] . "`)'><i class='fa fa-times'></i></button>";
				if ($row["item"] === "1") {
					$button .= "<button class='btn btn-light text-bottom' type='button' onclick='Impresion(`" . $IdEstacion . "`,`" . $Idtipotx . "`,`" . $Idtx . "`,`1`,`1`)' title='" . lang("Vista Previa") . "'> <i class='fa fa-print'></i></button>";
				} else if (trim($row['tiporetencion']) == "0" && $row['item'] > 1 && round($row['Retencion']) <> 0) {
					$button .= "<button class='btn btn-light  text-bottom' type='button' onclick='ImpresionOp4(`" . $Idtx . "`,`" . $Idtipotx . "`,`" . $IdEstacion . "`,`" . $row["item"] . "`)' title='" . lang("Vista Previa") . "'> <i class='fa fa-print'></i></button>";
				} else if (trim($row['tiporetencion']) == "1" && $row['item'] > 1 && round($row['Retencion']) <> 0) {
					$button .= "<button class='btn btn-light  text-bottom' type='button' onclick='ImpresionOp5(`" . $Idtx . "`,`" . $Idtipotx . "`,`" . $IdEstacion . "`,`" . $row["item"] . "`)' title='" . lang("Vista Previa") . "'> <i class='fa fa-print'></i></button>";
				} else if (trim($row['tiporetencion']) == "2" && $row['item'] > 1 && round($row['Retencion']) <> 0) {
				} else if ($row["item"] > 1 && (round($row['Contado']) <> 0) or (round($row['Credito']) <> 0)) {
					if ($post["CajaC"] !== "0") {
						$button .= "<button class='btn btn-light text-bottom' type='button' onclick='OpenUp(`" . $Idtx . "`,`" . $Idtipotx . "`,`" . $IdEstacion . "`,`" . $row["item"] . "`)' title='" . lang("Vista Previa") . "'> <i class='fa fa-print'></i></button>";
					}
				} else if ($row["item"] > 1 && round($row['Contado']) == 0 && round($row['Credito']) == 0) {
					$button .= "<button class='btn btn-light  text-bottom' type='button' onclick='ImpresionOp4(`" . $Idtx . "`,`" . $Idtipotx . "`,`" . $IdEstacion . "`,`" . $row["item"] . "`)' title='" . lang("Vista Previa") . "'> <i class='fa fa-print'></i></button>";
				}

				if ($row["item"] > 1 && $post["userperfil"] <= 2000) $button .= "<button class='btn btn-light text-bottom' type='button' onclick='DeletePay(`" . $Idtx . "`,`" . $Idtipotx . "`,`" . $IdEstacion . "`,`" . $row["item"] . "`," . ($row["Anticipo"] <> 0 ? "true" : "false") . ")' title='" . lang("Borrar Pago") . "'> <i class='fa fa-trash'></i></button>";

				if ($Credito < 0 && $row["Idtipotx"] !== "25") $Credito = $Credito * -1;

				if (round($Credito - $Contado) == 0 && $row["Idtipotx"] === "2" && $row["item"] > 1 && $row["Retencion"] > 0) $button .= "<button class='btn btn-light' title='" . lang("Eliminar") . "' onclick='Eliminar(`" . $Idtx . "`,`" . $Idtipotx . "`,`" . $IdEstacion . "`,`" . $row["item"] . "`)'><i class='fa fa-times'></i></button>";

				if ($row["item"] === "1" && $row["Detalle"] === "0" && $m === 1) $button .= "<button class='btn btn-light' title='" . lang("Eliminar") . "' onclick='EliminarTX(`" . $row["IdBarcode"] . "`, `" . $Tipa . "`)'><i class='fa fa-times'></i></button>";
				if (($Credito2 < 0 ? 0 : ROUND($Credito2, 2)) > 0 || ($Contado < 0 ? 0 : ROUND($Contado, 2)) > 0) {
					if ($row["Idtipotx"] === "2" || $row["Idtipotx"] === "7") {
						if ($row["Retencion"] > 0 && $row["item"] > 1) $button .= "<button class='btn btn-light' title='" . lang("Eliminar") . "' onclick='Eliminar(`" . $Idtx . "`,`" . $Idtipotx . "`,`" . $IdEstacion . "`,`" . $row["item"] . "`)'><i class='fa fa-times'></i></button>";
						if ($row["item"] <= 1) {
							if ($post["CajaC"] !== "0") {
								$button .= "
								<button class='btn btn-light' title='" . lang("Pago") . "' onclick='Abonos(`" . $Idtx . "`,`" . $Idtipotx . "`,`" . $IdEstacion . "`,`" . ROUND($Contado, 2) . "`,`" . ROUND($Credito2, 2) . "`,`" . $tasa . "`)'><i class='fa fa-money'></i></button>
								<button class='btn btn-light' title='" . lang("Credito") . "' onclick='Creditos2(`" . $Idtx . "`,`" . $Idtipotx . "`,`" . $IdEstacion . "`,`" . ROUND($Contado, 2) . "`,`" . ROUND($Credito2, 2) . "`,`" . $tasa . "`)'><i class='fa fa-credit-card'></i></button>
								<button class='btn btn-light' title='" . lang("Retencion Impuesto") . "' onclick='Retenciones(`" . $Idtx . "`,`" . $Idtipotx . "`,`" . $IdEstacion . "`,`" . $Retencion . "`,`" . ($Credito * $tasa) . "`)'><i class='fa fa-calculator'></i></button>
								<button class='btn btn-light' title='" . lang("Retencion I.S.R.L") . "' onclick='Retenciones2(`" . $Idtx . "`,`" . $Idtipotx . "`,`" . $IdEstacion . "`,`" . $Retencion . "`,`" . ($Credito * $tasa) . "`)'><i class='fa fa-sticky-note'></i></button>
							";
							}
							if (($Credito2 < 0 ? 0 : ROUND($Credito2, 2)) > 0) {
								$array[$row["orrd"]] = [
									"Caja" => "<span class='badge bg-dark text-light'>" . $row["etiqueta3"] . " No. " . $row["Caja"] . "</span><br>" . '<span class="badge bg-primary text-light"><i class="fa fa-user"></i> ' . $row['Usuario'] . '</span>',
									"Documento" => $Documento,
									"ExtraData" => $ExtraData,
									"Fecha" => $row['Fecha2'],
									"Monto" => "<strong>" . $_POST["MonedaP"] . "</strong> " . number_format($Monto, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . ($row['Tasa2'] > 1 ? "<br> <strong>" . $_POST["MonedaS"] . "</strong> " . (number_format($Monto * $row["Tasa2"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])) : ""),
									"Debito" => number_format($MontoCont  / ($row["Tasa2"] > 0 ? $row["Tasa2"] : 1), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . ($row['Tasa2'] > 1 ? "<br> " . (number_format($MontoCont, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])) : ""),
									"Credito" => number_format($Credito / ($row["Tasa2"] > 0 ? $row["Tasa2"] : 1), $_POST["CD"], $_POST["SimDec"], $_POST['SimMil']) . " " . ($row['Tasa2'] > 1 ? "<br> " . (number_format($Credito, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])) : ""),
									"Saldo" => number_format(ROUND($Saldo, 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]),
									"Contado" => ROUND($Contado, 2),
									"Credito2" => ROUND($Credito2, 2),
									"Titulo" => $row['Titulo'],
									"Tipo" => $row['Tipo'],
									"Etiqueta" => $row['Etiqueta'],
									"Idtx" => str_pad($row['Idtx'], 6, "0", STR_PAD_LEFT),
									"IdBarcode" => $row["IdBarcode"],
									"tasa" => $row["Tasa"],
									"IdtxF" => $Idtx,
									"Idtipotx" => $Idtipotx,
									"IdEstacion" => $IdEstacion,
								];
							}
						}
					} else if (($row["Idtipotx"] <> "3" && $row["Idtipotx"] <> "27") && $row["item"] == 1) {
						if (($Credito2 < 0 ? 0 : ROUND($Credito2, 2)) > 0) {
							if ($post["CajaC"] !== "0") {

								$button .= "<button class='btn btn-light' title='" . lang("Pago") . "' onclick='Abonos(`" . $Idtx . "`,`" . $Idtipotx . "`,`" . $IdEstacion . "`,`" . ($Contado < 0 ? 0 : ROUND($Contado, 2)) . "`,`" . ($Credito2 < 0 ? 0 : ROUND($Credito2, 2)) . "`,`" . $tasa . "`)'><i class='fa fa-money'></i></button>";
							}
							$array[$row["orrd"]] = [
								"Caja" => "<span class='badge bg-dark text-light'>" . $row["etiqueta3"] . " No. " . $row["Caja"] . "</span><br>" . '<span class="badge bg-primary text-light"><i class="fa fa-user"></i> ' . $row['Usuario'] . '</span>',
								"Documento" => $Documento,
								"ExtraData" => $ExtraData,
								"Fecha" => $row['Fecha2'],
								"Monto" => "<strong>" . $_POST["MonedaP"] . "</strong> " . number_format($Monto, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . ($row['Tasa2'] > 1 ? "<br> <strong>" . $_POST["MonedaS"] . "</strong> " . (number_format($Monto * $row["Tasa2"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])) : ""),
								"Debito" => number_format($MontoCont  / ($row["Tasa2"] > 0 ? $row["Tasa2"] : 1), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . ($row['Tasa2'] > 1 ? "<br> " . (number_format($MontoCont, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])) : ""),
								"Credito" => number_format($Credito / ($row["Tasa2"] > 0 ? $row["Tasa2"] : 1), $_POST["CD"], $_POST["SimDec"], $_POST['SimMil']) . " " . ($row['Tasa2'] > 1 ? "<br> " . (number_format($Credito, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])) : ""),
								"Saldo" => number_format(ROUND($Saldo, 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]),
								"Contado" => ($Contado < 0 ? 0 : ROUND($Contado, 2)),
								"Credito2" => ($Credito2 < 0 ? 0 : ROUND($Credito2, 2)),
								"Titulo" => $row['Titulo'],
								"Tipo" => $row['Tipo'],
								"Etiqueta" => $row['Etiqueta'],
								"Idtx" => str_pad($row['Idtx'], 6, "0", STR_PAD_LEFT),
								"IdBarcode" => $row["IdBarcode"],
								"tasa" => $row["Tasa"],
								"IdtxF" => $Idtx,
								"Idtipotx" => $Idtipotx,
								"IdEstacion" => $IdEstacion,
							];
						}
						if (($Contado < 0 ? 0 : ROUND($Contado, 2)) > 0) {
							if ($post["CajaC"] !== "0") {

								$button .= "<button class='btn btn-light' title='" . lang("Credito") . "' onclick='Creditos2(`" . $Idtx . "`,`" . $Idtipotx . "`,`" . $IdEstacion . "`,`" . ($Contado < 0 ? 0 : ROUND($Contado, 2)) . "`,`" . ($Credito2 < 0 ? 0 : ROUND($Credito2, 2))  . "`,`" . $tasa . "`)'><i class='fa fa-credit-card'></i></button>";
							}
						}
					} else if (($row["Idtipotx"] === "3" || $row["Idtipotx"] === "27") && $row["item"] == 1) {
						if ($post["CajaC"] !== "0") {
							if (ROUND($Credito2, 2) < 0) $button .= "<button class='btn btn-light' title='" . lang("Pago") . "' onclick='Abonos(`" . $Idtx . "`,`" . $Idtipotx . "`,`" . $IdEstacion . "`,`" . ROUND($Credito2, 2) . "`,`" . ROUND($Contado, 2) . "`,`" . $tasa . "`)'><i class='fa fa-money'></i></button>";

							if (ROUND($Contado, 2) < 0) $button .= "<button class='btn btn-light' title='" . lang("Credito") . "' onclick='Creditos2(`" . $Idtx . "`,`" . $Idtipotx . "`,`" . $IdEstacion . "`,`" . ROUND($Credito2, 2) . "`,`" . ROUND($Contado, 2) . "`,`" . $tasa . "`)'><i class='fa fa-credit-card'></i></button>";
						}
					}
				} else {
					if ($post["CajaC"] !== "0") {
						if (round($Credito - $Contado) == 0 && $row["Idtipotx"] === "2" && $row["item"] <= 1) $button .= "<button class='btn btn-light' title='" . lang("Credito") . "' onclick='Creditos2(`" . $Idtx . "`,`" . $Idtipotx . "`,`" . $IdEstacion . "`,`" . $Contado . "`,`" . $Credito . "`,`" . $tasa . "`)'><i class='fa fa-credit-card'></i></button>";
						if (round($Credito - $Contado) == 0 && $row["Idtipotx"] !== "25" && $row["item"] == 1) $button .= "<button class='btn btn-light' title='" . lang("Credito") . "' onclick='Creditos2(`" . $Idtx . "`,`" . $Idtipotx . "`,`" . $IdEstacion . "`,`" . $Contado . "`,`" . $Credito . "`,`" . $tasa . "`)'><i class='fa fa-credit-card'></i></button>";
					}
				}


				if ($row["Idtipotx"] === "4" || $row["Idtipotx"] === "5") $button = "";

				if ($row["Dias_Vencidos"] >= 0) {
					$SaldoVencido += ROUND($row["Credito"] / ($row["Tasa2"] > 0 ? $row["Tasa2"] : 1), 2) - ROUND($row["Contado"] / ($row["Tasa2"] > 0 ? $row["Tasa2"] : 1), 2);
				}

				$CreditoTotal += $Credito;
				if (round($row['Contado']) <> 0 && $row['item'] > 1) {
					$MontoTotal += ($row['Contado'] / ($row["Tasa2"] > 0 ? $row["Tasa2"] : 1));
				} else if (round($row['Credito']) <> 0 && $row['item'] > 1) {
					$MontoTotal += ($row['Credito'] / ($row["Tasa2"] > 0 ? $row["Tasa2"] : 1));
				} else if (round($row['Retencion']) <> 0 && $row['item'] > 1) {
					$MontoTotal += ($row['Retencion'] / ($row["Tasa2"] > 0 ? $row["Tasa2"] : 1));
				} else if ($row['item'] <= 1) {
					$MontoTotal += ($row['Total_Operacion']);
				}

				if (round($row['Contado']) <> 0) {
					$ContadoTotal += ($row['Contado'] / ($row["Tasa2"] > 0 ? $row["Tasa2"] : 1)) * $tasa;
				} else if (round($row['Retencion']) <> 0) {
					$ContadoTotal += ($row['Retencion'] / ($row["Tasa2"] > 0 ? $row["Tasa2"] : 1)) * $tasa;
				} else if ((round($row['Retencion']) == 0) and (round($row['Contado']) == 0)) {
					$ContadoTotal += ($row['Contado'] / ($row["Tasa2"] > 0 ? $row["Tasa2"] : 1)) * $tasa;
				}

				if (round($row['Contado']) <> 0) {
					$ContadoTotal2 += ($row['Contado'] / ($row["Tasa2"] > 0 ? $row["Tasa2"] : 1));
				} else if (round($row['Retencion']) <> 0) {
					$ContadoTotal2 += ($row['Retencion'] / ($row["Tasa2"] > 0 ? $row["Tasa2"] : 1));
				} else if ((round($row['Retencion']) == 0) and (round($row['Contado']) == 0)) {
					$ContadoTotal2 += ($row['Contado'] / ($row["Tasa2"] > 0 ? $row["Tasa2"] : 1));
				}

				$tableResponse[] = [
					"etiqueta" => "<span class='badge bg-dark text-light'>" . $row["etiqueta3"] . " No. " . $row["Caja"] . "</span><br><span class='badge bg-primary text-light'><i class='fa fa-user'></i> " . $row['Usuario'] . "</span>",
					"documento" => $Documento,
					"extradata" => $ExtraData,
					"fechatabla" => $row['Fecha2'],
					"monto" => "<strong>" . $_POST["MonedaP"] . "</strong> " . number_format($Monto, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . ($row['Tasa2'] > 1 ? "<br> <strong>" . $_POST["MonedaS"] . "</strong> " . (number_format($Monto * $row["Tasa2"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])) : ""),
					"contable" => number_format($MontoCont  / ($row["Tasa2"] > 0 ? $row["Tasa2"] : 1), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . ($row['Tasa2'] > 1 ? "<br> " . (number_format($MontoCont, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])) : ""),
					"credito" => number_format($Credito / ($row["Tasa2"] > 0 ? $row["Tasa2"] : 1), $_POST["CD"], $_POST["SimDec"], $_POST['SimMil']) . " " . ($row['Tasa2'] > 1 ? "<br> " . (number_format($Credito, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])) : ""),
					"saldo" => $SaldoA,
					"btn" => "
						<div class='btn-group'>
							<div>
								" . $button . "
								<button class='btn btn-light' type='button' title='" . lang("Ver Imagen") . "' onclick='Recibir4(`" . ($IdEstacion . $Idtipotx . $Idtx) . "`,`" . $row["Tipo"] . "N°: " . str_pad($row["Idtx"], 10, "0", STR_PAD_LEFT) . "`);'><i class='fa fa-image'></i></button>
							</div>
						</div>
						" .
						(ROUND($Contado, 1) == 0 ? "<div><span class='badge bg-success text-light'>" . lang("Pagado") . "</span></div>" : "<div><span class='badge " . ($row["Dias_Vencidos"] >= 0 ? "bg-danger text-light" : "bg-light text-dark") . "'>" . lang("Vence") . ": (" . $row["Dias_Vencidos"] . ") " . $row["TxfecVence"] . "</span></div>"),
					"span" => [
						"ContadoAct" => $Contado,
						"CreditoAct" => $Credito2,
						"TasaAct" => $tasa,
						"IdtxAct" => $Idtx,
						"IdtipotxAct" => $Idtipotx,
						"IdEstacionAct" => $IdEstacion,
						"RetenidoActualmente" => $Retencion,
						"RetenidoActualmente2" => $Retencion2,
						"RetenidoActualmente3" => $Retencion3,
						"CreditoTxP" => $CreditoTxP,
						"ContadoTxP" => $ContadoTxP,
						"CreditoTxPx" => $CreditoTxP2,
						"ContadoTxPx" => $ContadoTxP2,
						"MontoAPagarqk" => $MontoAPagar,
						"MontoAPagarqkx" => $MontoAPagar2,
						"ItemAct" => $row["item"],
						"RetencionAct" => $row["Retencion"],
						"lastItemA" => $row["lastItem"],
					],
				];
				$x++;
			}
		}
	}

	$ab = [];

	foreach ($array as $value) {
		$ab[] = $value;
	}

	return json_encode([
		"data" => $tableResponse,
		"general" => [
			"SaldoDadoVencido" => abs($SaldoVencido),
			"SaldoTotal" => abs(ROUND($Saldo, 2)),
			"MontoTotalA" => ($ContadoTotal2 + abs(ROUND($Saldo, 2))),
			"ContadoTotalA" => $ContadoTotal2,
			"CreditoTotalA" => abs(ROUND($Saldo, 2)),
			"query" => $query,
		],
		"array" => $ab,
	], JSON_UNESCAPED_UNICODE);
}
*/
function TableResponse($conn, $post)
{
	$Saldo = 0;
	$n = 0;
	// $buscar = "";

	// if ($post["MostrarTodos"] === "1") {
	// 	$buscar .= " and ((Pagos.Fectxclient >= '" . trim($post["Modaldesde"]) . "' and Pagos.Fectxclient <= '" . trim($post["Modalhasta"]) . "' and a.Credito = 0) or (a.Credito <> 0))";
	// }

	$query = "SELECT
		n.IdDef,
		n.IdBarcode,
		bb.titulo,
		b.titulo as titulodef,
		n.Idtipotx,
		n.Idtx,
		n.IdEstacion,
		n.Fectxclient,
		n.FectxclientDef,
		n.idtipotxDef,
		n.idtxDef,
		n.idtxEstacionDef,
		c.Caja              AS cajaDef,
		c.tasa              AS tasaDef,
		n.Total * bb.Caja    AS Total,
		c.MontoPagar,
		c.Credito * bb.Caja  AS Credito,
		c.Contado * bb.Caja  AS Contado,
		c.IdEstacion2,
        n.IdTxCompany,
		c.Caja2,
		c.Item as item,
		c.montoretencion as Retencion,
		bb.TitCto as Tipo,
		c.tiporetencion,
		c.numret,
		c.Efectivo,
		c.Tarjeta,
		c.Cheque,
		c.Tipo01,
		c.Tipo01D,
		c.Tipo02,
		c.Tipo03,
		c.Tipo04,
		DATE_FORMAT(c.Fectxclient,'%d/%m/%Y<br>%h:%i:%s %p') AS Fecha2,
		DATE_FORMAT(c.Fectxclient,'%d/%m/%Y %h:%i:%s %p') AS Fecha3,
		c.Anticipo,
		d.etiqueta,
		users.Nombre as Usuario,
		p.creditot ,
		p.contadot,
		DATEDIFF('" . $post["Fecha"] . " 23:59:59',DATE(n.TxfecVenceDef)) as Dias_Vencidos,
		DATE_FORMAT(n.TxfecVenceDef,'%d/%m/%Y') as TxfecVence,
        n.TxfecVenceDef,
		p.pagado
		FROM
		(
		SELECT
			a.*,
			IF(a.IdtipotxPadre in ('0','11','12'), a.Idtipotx,       a.IdtipotxPadre)   AS idtipotxDef,
			IF(a.IdtipotxPadre in ('0','11','12'), a.Idtx,           a.IdtxPadre)       AS idtxDef,
			IF(a.IdtipotxPadre in ('0','11','12'), a.IdEstacion,     a.IdEstacionPadre) AS idtxEstacionDef,
			IF(a.IdtipotxPadre in ('0','11','12'), a.IdBarcode,      ab.IdBarcode)      AS IdDef,
			IF(a.IdtipotxPadre in ('0','11','12'), a.Fectxclient,    ab.Fectxclient)    AS FectxclientDef,
			if(a.IdtipotxPadre in ('0','11','12'), a.TxfecVence, ab.TxfecVence) as TxfecVenceDef
		FROM posuptxc a
		LEFT JOIN posuptxc ab
				ON a.IdCompany        = ab.IdCompany
				AND a.IdtipotxPadre    = ab.Idtipotx
				AND a.IdEstacionPadre  = ab.IdEstacion
				AND a.IdtxPadre        = ab.Idtx
		WHERE
			a.IdCompany = " . trim($post["CompanyActual"]) . "
			AND a.IdBen = '" . $post['IdBen'] . "' 
			AND a.Idtipotx IN (1,2,3,15,22,7,27,28)
		) AS n
		INNER JOIN posuptx bb
				ON n.Idtipotx = bb.Idtipotx
		INNER JOIN posuptx b
				ON n.idtipotxDef = b.Idtipotx
		LEFT JOIN posuptxp c
			ON n.IdCompany       = c.IdCompany
			AND n.Idtipotx     = c.Idtipotx
			AND n.IdEstacion = c.IdEstacion
			AND n.Idtx         = c.Idtx
		LEFT JOIN posupcompanyestacion d
			ON n.IdCompany = d.IdCompany AND n.IdEstacion = d.token
		LEFT JOIN posupcompanyestacion e
			ON n.IdCompany = e.IdCompany AND c.IdEstacion = e.token
		left join posupusers users on
			c.IdCompany = users.IdCompany
			and c.Login = users.Login
		LEFT JOIN (
			SELECT
		 nn.IdCompany,
			nn.IdDef,
			SUM(cc.Credito * bb2.Caja / IF(cc.tasa>0,cc.tasa,1)) as CreditoTx,
			SUM(cc.Credito * bb2.Caja / IF(cc.tasa>0,cc.tasa,1))  - SUM(( (cc.Contado / IF(cc.tasa>0,cc.tasa,1)) + IF(cc.tiporetencion=1 AND cc.Fectxclient >= '2026-03-09', COALESCE(cc.montoretencion, 0), COALESCE(cc.montoretencion, 0) / IF(cc.tasa>0,cc.tasa,1)) ) * bb2.Caja ) as CreditoT,
			SUM(( (cc.Contado / IF(cc.tasa>0,cc.tasa,1)) + IF(cc.tiporetencion=1 AND cc.Fectxclient >= '2026-03-09', COALESCE(cc.montoretencion, 0), COALESCE(cc.montoretencion, 0) / IF(cc.tasa>0,cc.tasa,1)) ) * bb2.Caja ) as ContadoT,
			ROUND(SUM(cc.Credito * bb2.Caja / IF(cc.tasa>0,cc.tasa,1)) - SUM(( (cc.Contado / IF(cc.tasa>0,cc.tasa,1)) + IF(cc.tiporetencion=1 AND cc.Fectxclient >= '2026-03-09', COALESCE(cc.montoretencion, 0), COALESCE(cc.montoretencion, 0) / IF(cc.tasa>0,cc.tasa,1)) ) * bb2.Caja ), 0) as x,
			if(
			ROUND(SUM(cc.Credito * bb2.Caja / IF(cc.tasa>0,cc.tasa,1)) - SUM(( (cc.Contado / IF(cc.tasa>0,cc.tasa,1)) + IF(cc.tiporetencion=1 AND cc.Fectxclient >= '2026-03-09', COALESCE(cc.montoretencion, 0), COALESCE(cc.montoretencion, 0) / IF(cc.tasa>0,cc.tasa,1)) ) * bb2.Caja ), 0) = 0,
			1, 0
			) as pagado
		FROM
		(
			SELECT
			a.IdCompany,
			a.IdEstacion,
			a.Idtx,
			IF(a.IdtipotxPadre in ('0','11','12'), a.Idtipotx,       a.IdtipotxPadre)   AS idtipotxDef,
			IF(a.IdtipotxPadre in ('0','11','12'), a.Idtx,           a.IdtxPadre)       AS idtxDef,
			IF(a.IdtipotxPadre in ('0','11','12'), a.IdEstacion,     a.IdEstacionPadre) AS idtxEstacionDef,
			IF(a.IdtipotxPadre in ('0','11','12'), a.IdBarcode,     ab.IdBarcode) AS IdDef,
			a.Idtipotx as Idtipotx
			FROM posuptxc a
			LEFT JOIN posuptxc ab
				ON a.IdCompany        = ab.IdCompany
				AND a.IdtipotxPadre    = ab.Idtipotx
				AND a.IdEstacionPadre  = ab.IdEstacion
				AND a.IdtxPadre        = ab.Idtx
			WHERE
			a.IdCompany = " . trim($post["CompanyActual"]) . "
			AND a.IdBen = '" . $post['IdBen'] . "' 
			AND a.Idtipotx IN (1,2,3,15,22,7,27,28)
		) AS nn
        inner join posuptx bb2           
                    on
            nn.Idtipotx = bb2.Idtipotx
        left join posuptxp cc         
                    on
            nn.IdCompany = cc.IdCompany
                and nn.Idtipotx = cc.Idtipotx
                and nn.IdEstacion = cc.IdEstacion
                and nn.Idtx = cc.Idtx
		GROUP BY nn.IdCompany, nn.IdDef
		) AS p
		ON n.IdCompany = p.IdCompany
		AND n.IdDef     = p.IdDef
		ORDER BY
n.IdCompany,n.IdDef,n.IdBarcode ,
		n.TxfecVenceDef,
	c.Item 
		
	";
	$array = [];
	$SaldoVencido = 0;
	$Saldo = 0;
	$ContadoTotal2 = 0;
	$tableResponse = [];
	if ($result = mysqli_query($conn, $query)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$Retencion = 0;
			$Credito = $row["Credito"];

			if ($row["item"] == 1 && $row["Idtipotx"] !== "3" && $row["Idtipotx"] !== "27") {
				$SaldoShow = 0;
			}

			// Extraemos la fecha real de la retención/pago para validar
			$fecha_str = $row['Fecha3']; 
			$fecha_ymd = substr($fecha_str, 6, 4) . '-' . substr($fecha_str, 3, 2) . '-' . substr($fecha_str, 0, 2);
			$isUsdRet = (trim($row['tiporetencion']) == "1" && strtotime($fecha_ymd) >= strtotime('2026-03-09'));
			
			$ret_usd = $isUsdRet ? $row["Retencion"] : ($row["Retencion"] / ($row["tasaDef"] > 0 ? $row["tasaDef"] : 1));
			$SaldoShow += ROUND($ret_usd, 2);
			if ($row["Idtipotx"] === "7" || $row["Idtipotx"] === "28") {
				$SaldoShow += ROUND((abs($row["Contado"]) / ($row["tasaDef"] > 0 ? $row["tasaDef"] : 1)), 2);
			} else if ($row['item'] > 1) {
				$SaldoShow += ROUND(($row["Contado"] / ($row["tasaDef"] > 0 ? $row["tasaDef"] : 1)), 2);
			} else if ($row["Idtipotx"] === "4" || $row["Idtipotx"] === "5") {
				$SaldoShow += ROUND(($row["Contado"] / ($row["tasaDef"] > 0 ? $row["tasaDef"] : 1)), 2);
			}

			if ($row["Idtipotx"] === "7" || $row["Idtipotx"] === "28") {
				$SaldoShow -= ROUND((abs($row["Credito"]) / ($row["tasaDef"] > 0 ? $row["tasaDef"] : 1)), 2);
			} else {
				$SaldoShow -= ROUND((($row["Credito"]) / ($row["tasaDef"] > 0 ? $row["tasaDef"] : 1)), 2);
			}


			$Idtipotx = $row["Idtipotx"];
			$idtx = $row['Idtx'];
			$IdEstacion = $row['IdEstacion'];
			$tasa = $row["tasaDef"];
			$ContadoTxP = $row["contadot"];
			$ContadoTxP2 = $row["contadot"] * ($row["tasaDef"] > 0 ? $row["tasaDef"] : 1);

			$CreditoTxP = $row["creditot"];
			$CreditoTxP2 = $row["creditot"] * ($row["tasaDef"] > 0 ? $row["tasaDef"] : 1);



			$MontoAPagar = $row["MontoPagar"];
			$MontoAPagar2 = $row["MontoPagar"] * ($row["tasaDef"] > 0 ? $row["tasaDef"] : 1);


			$n++;
			$Tipa = "";
			if ($row['Tipo'] <> "") {
				$Tipa .= $row['Tipo'] . "-";
			} else if ($row['etiqueta'] <> "") {
				$Tipa .= $row['etiqueta'] . "-";
			}

			if ($idtx <> "") {
				$Tipa .= str_pad($idtx, 6, "0", STR_PAD_LEFT) . " ";
			}
			$ExtraData = "";
			if (($row["Idtipotx"] === "1" or $row["Idtipotx"] === "2" or $row["Idtipotx"] === "7") && $row['item'] === "1") $ExtraData .= "<i class='fa fa-file-text-o'></i>";
			if (($row["Idtipotx"] === "22" or $row["Idtipotx"] === "28" or $row["Idtipotx"] === "15") && $row['item'] === "1") $ExtraData .= "<i class='fa fa-truck'></i>";
			if (($row["Idtipotx"] === "3" or $row["Idtipotx"] === "27") && $row['item'] === "1") $ExtraData .= "<i class='fa fa-undo'></i>";

			if ($row['Contado'] > 0 && $row['item'] <> "1") $ExtraData .= "<i class='fa fa-plus'></i>";
			if ($row['Contado'] < 0 && $row['item'] <> "1") $ExtraData .= "<i class='fa fa-minus'></i>";
			if ($row['Retencion'] <> 0 && $row['item'] <> "1") $ExtraData .= "<i class='fa fa-percent'></i>";
			if ($row['Credito'] <> 0 && $row['item'] <> "1") $ExtraData .= "<i class='fa fa-minus'></i>";
			$Documento = "";
			$Documento2 = "
			   <div class='fs-6'> <button class='btn btn-outline-light px-1 ' type='button' onclick='ImprimirEstado(`" . $row["IdDef"] . "`)'><i class='fa fa-print'></i></button> " . $ExtraData . " " . $row['titulo'] . " <span class='badge bg-warning text-dark fs-6'>" . $Tipa . "</span> <span class='badge bg-light text-dark fs-6'>Nro. " . strtoupper(str_pad($row['IdTxCompany'], 8, "0", STR_PAD_LEFT)) . "</span> <span class='badge bg-secondary text-white fs-6'> " . $row['Fecha3'] . "</div>
			";
			$Documento3 =  "<div class='d-flex justify-content-center'>" . ($row["pagado"] == 1 ? "<span class='badge bg-success text-light fs-6'><i class='fa fa-check'></i> " . lang("Pagado") . "</span>" : "<span class='badge " . ($row["Dias_Vencidos"] >= 0 ? "bg-danger text-light" : "bg-light text-dark") . " fs-6'><i class='fa fa-close'></i> " . lang("Vence") . ": (" . $row["Dias_Vencidos"] . ") " . $row["TxfecVence"] . "  <br> " . lang("Saldo") . ": " . number_format(($CreditoTxP * -1), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . "  " . $_POST["MonedaP"] . "</span> </span>") . " </div>";

			if (round($row['Contado'], 4) != 0 && $row['item'] > 1) {
				$Medio = "";

				if ($row["Efectivo"] <> 0) {
					$Medio = $_POST["LitEfectivo"];
				} else if ($row["Tarjeta"] <> 0) {
					$Medio = $_POST["LitTarjeta"];
				} else if ($row["Cheque"] <> 0) {
					$Medio = $_POST["LitCheque"];
				} else if ($row["Tipo01"] <> 0) {
					$Medio = $_POST["LitO01"];
					$Tipo01D = explode("|", $row["Tipo01D"]);
					if ($Tipo01D) $Medio .= " (" . $Tipo01D[0] . ") ";
					// if ($Tipo01D) $Medio .= " " . $Tipo01D[1] . "";
				} else if ($row["Tipo02"] <> 0) {
					$Medio = $_POST["LitO02"];
				} else if ($row["Tipo03"] <> 0) {
					$Medio = $_POST["LitO03"];
				} else if ($row["Tipo04"] <> 0) {
					$Medio = $_POST["LitO04"];
				} else if ($row["Anticipo"] <> 0) {
					$Medio = lang("Anticipo Utilizado");
				}

				if ($row['Contado'] > 0) {
					$Documento .= "<span class='badge bg-info text-dark'>" . lang("Pago");
				} else if ($row["Idtipotx"] === "3" || $row["Idtipotx"] === "27") {
					$Documento .= "<span class='badge bg-info text-dark'>" . lang("Pago");
				} else if (($row["Idtipotx"] === "7" || $row["Idtipotx"] === "28") && $row['Contado'] <= 0) {
					$Documento .= "<span class='badge bg-info text-dark'>" . lang("Pago");
				} else {
					$Documento .= "<span class='badge bg-info text-dark'>" . lang("Vuelto");
				}

				$Documento .= " " . $Medio . "</span>";
				if ($Tipo01D) $Documento .= " <span class='badge bg-success'>" . $Tipo01D[1] . "</span>";
				// $Documento .= "<br><span class='badge bg-warning text-dark'>" . $Tipa . "</span>";
				// $Documento .= "<br><span class='badge bg-light text-dark'>Nro. " . strtoupper(str_pad($row['IdTxCompany'], 8, "0", STR_PAD_LEFT)) . "</span>";
				$Documento .= '<br>' . number_format($row['Contado'] / ($row["tasaDef"] > 0 ? $row["tasaDef"] : 1), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' x ' . number_format($row['tasaDef'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' = ' . number_format($row['Contado'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
			}
			if (round($row['Credito'], 4) != 0 && $row['item'] > 1) {
				$Documento .= "<span class='badge bg-danger text-light'>" . lang("Crédito") . "</span>";
				$Documento .= '<br>' . number_format(($row['Credito'] / ($row["tasaDef"] > 0 ? $row["tasaDef"] : 1)), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' x ' . number_format($row['tasaDef'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' = ' . number_format($row['Credito'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
			}
			if (trim($row['tiporetencion']) == "0" && $row['item'] > 1 && round($row['Retencion'], 4) != 0) $Documento .= lang("Ret. Impto");
			if (trim($row['tiporetencion']) == "1" && $row['item'] > 1 && round($row['Retencion'], 4) != 0) {
				$Documento .= lang("Ret. I.S.L.R");
				$Nombre = "";
				$query2 = "SELECT Nombre FROM PosUpRetencion WHERE TipoRet = 1 and IdCompany=" . $_POST["CompanyActual"] . " AND NumLit = '" . $row["numret"] . "' ";
				if ($result2 = mysqli_query($conn, $query2)) {
					while ($row2 = mysqli_fetch_assoc($result2)) {
						$Nombre = $row2["Nombre"];
					}
				}
				$Documento .= " (" . $Nombre . ") ";
			}
			if (trim($row['tiporetencion']) == "2" && $row['item'] > 1 && round($row['Retencion']) <> 0) $Documento .= lang("Ret. Mun");
			if ($row['item'] > 1 && round($row['Retencion'], 4) != 0) {
				if ($isUsdRet) {
					$usdRet = $row['Retencion'];
					$bcvRet = $usdRet * $row['tasaDef'];
					$Documento .= '<br>' . $_POST["MonedaP"] . ' ' . number_format($usdRet, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' x ' . number_format($row['tasaDef'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' = ' . $_POST["MonedaS"] . ' ' . number_format($bcvRet, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
				} else {
					$Documento .= '<br>' . number_format(($row['Retencion'] / ($row["tasaDef"] > 0 ? $row["tasaDef"] : 1)), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' x ' . number_format($row['tasaDef'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' = ' . number_format($row['Retencion'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
				}
			}

			if ($row['item'] <= 1) {
				if ($row["IdBarcode"] <> $row["IdDef"]) {
					$Documento .= $row['titulo'];
					// if ($row['titulodef'] <> "") $Documento .= "<br>(" . $row['titulodef'] . "-";
					// if ($row['idtxDef'] <> "" && $row['titulodef'] <> "") $Documento .=  str_pad($row['idtxDef'], 6, "0", STR_PAD_LEFT) . ") ";
					$Documento .= "<br>";
				}

				$Documento .= '' . number_format(abs($row['Credito']) / ($row["tasaDef"] > 0 ? $row["tasaDef"] : 1), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' x ' . number_format($row['tasaDef'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' = ' . number_format(abs($row['Credito']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
				if ($row["IdBarcode"] <> $row["IdDef"]) {

					$Documento .= "<br><span class='badge bg-warning text-dark'>" . $Tipa . "</span>";
					$Documento .= " <span class='badge bg-light text-dark'>Nro. " . strtoupper(str_pad($row['IdTxCompany'], 8, "0", STR_PAD_LEFT)) . "</span>";
				}
			}



			$button = "";

			if ($row["Idtipotx"] === "25") $button .= "<button class='btn btn-light' title='" . lang("Eliminar") . "' onclick='EliminarAnticipo(`" . $idtx . "`,`" . $Idtipotx . "`,`" . $IdEstacion . "`,`" . $row["item"] . "`)'><i class='fa fa-times'></i></button>";
			if ($row["item"] === "1") {
				$button .= "<button class='btn btn-light text-bottom' type='button' onclick='Impresion(`" . $IdEstacion . "`,`" . $Idtipotx . "`,`" . $idtx . "`,`1`,`1`)' title='" . lang("Vista Previa") . "'> <i class='fa fa-print'></i></button>";
			} else if (trim($row['tiporetencion']) == "0" && $row['item'] > 1 && round($row['Retencion']) <> 0) {
				$button .= "<button class='btn btn-light  text-bottom' type='button' onclick='ImpresionOp4(`" . $idtx . "`,`" . $Idtipotx . "`,`" . $IdEstacion . "`,`" . $row["item"] . "`)' title='" . lang("Vista Previa") . "'> <i class='fa fa-print'></i></button>";
			} else if (trim($row['tiporetencion']) == "1" && $row['item'] > 1 && round($row['Retencion']) <> 0) {
				$button .= "<button class='btn btn-light  text-bottom' type='button' onclick='ImpresionOp5(`" . $idtx . "`,`" . $Idtipotx . "`,`" . $IdEstacion . "`,`" . $row["item"] . "`)' title='" . lang("Vista Previa") . "'> <i class='fa fa-print'></i></button>";
			} else if (trim($row['tiporetencion']) == "2" && $row['item'] > 1 && round($row['Retencion'], 4) != 0) {
			} else if ($row["item"] > 1 && (round($row['Contado'], 4) != 0) or (round($row['Credito'], 4) != 0)) {
				if ($post["CajaC"] !== "0") {
					$button .= "<button class='btn btn-light text-bottom' type='button' onclick='ImpresionOp4(`" . $idtx . "`,`" . $Idtipotx . "`,`" . $IdEstacion . "`,`" . $row["item"] . "`)' title='" . lang("Vista Previa") . "'> <i class='fa fa-print'></i></button>";
				}
			} else if ($row["item"] > 1 && round($row['Contado']) == 0 && round($row['Credito']) == 0) {
				$button .= "<button class='btn btn-light  text-bottom' type='button' onclick='ImpresionOp4(`" . $idtx . "`,`" . $Idtipotx . "`,`" . $IdEstacion . "`,`" . $row["item"] . "`)' title='" . lang("Vista Previa") . "'> <i class='fa fa-print'></i></button>";
			}

			if ($row["item"] > 1 && $post["userperfil"] <= 2000) $button .= "<button class='btn btn-light text-bottom' type='button' onclick='DeletePay(`" . $idtx . "`,`" . $Idtipotx . "`,`" . $IdEstacion . "`,`" . $row["item"] . "`," . ($row["Anticipo"] <> 0 ? "true" : "false") . ")' title='" . lang("Borrar Pago") . "'> <i class='fa fa-trash'></i></button>";

			$Monto = 0;
			if (round($row['Contado']) <> 0 && $row['item'] > 1) {
				$Monto = $row['Contado'] / ($row["tasaDef"] > 0 ? $row["tasaDef"] : 1);
			} else if (round($row['Credito']) <> 0 && $row['item'] > 1) {
				$Monto = $row['Credito'] / ($row["tasaDef"] > 0 ? $row["tasaDef"] : 1);
			} else if (round($row['Retencion'], 4) != 0 && $row['item'] > 1) {
				$Monto = $isUsdRet ? $row['Retencion'] : ($row['Retencion'] / ($row["tasaDef"] > 0 ? $row["tasaDef"] : 1));
			} else if ($row['item'] <= 1) {
				$Monto = $row['MontoPagar'] / ($row["tasaDef"] > 0 ? $row["tasaDef"] : 1);
			}

			if ($row["pagado"] == 1 && $row["Idtipotx"] === "2" && $row["item"] > 1 && $row["Retencion"] > 0) $button .= "<button class='btn btn-light' title='" . lang("Eliminar") . "' onclick='Eliminar(`" . $idtx . "`,`" . $Idtipotx . "`,`" . $IdEstacion . "`,`" . $row["item"] . "`)'><i class='fa fa-times'></i></button>";
			
			// Aseguramos que la tasa nunca sea 0 para evitar divisiones fatales (inf)
            $tasa_segura = ($row["tasaDef"] > 0) ? $row["tasaDef"] : 1;

            $MontoCont = 0;
            if (round($row['Contado'], 4) != 0) { $MontoCont = ($row['Contado'] / $tasa_segura); }
            if (round($row['Retencion'], 4) != 0) { $MontoCont = $row['Retencion']; } 
            if ((round($row['Retencion'], 4) == 0) and (round($row['Contado'], 4) == 0)) { $MontoCont = ($row['Contado'] / $tasa_segura); }

            // NUEVO: Generador Visual para Débito y Crédito (2 líneas siempre)
            $str_debito = "";
            $str_credito = "";
            
            // Es una Retención
            if ($row['item'] > 1 && trim($row['tiporetencion']) != "") {
                $usd = number_format($row['Retencion'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                $bcv = number_format($row['MontoPagar'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                $str_debito = $usd . ($tasaDef > 1 ? "<br>" . $bcv : "");
                $str_credito = "0.00 <br> 0.00";
            } 
            // Es la Factura original (Crédito)
            else if ($row['item'] == 1) {
                $usd = number_format($row['Credito'] / $tasaDef, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                $bcv = number_format($row['Credito'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
                $str_credito = $usd . ($tasaDef > 1 ? "<br>" . $bcv : "");
                $str_debito = "0.00 <br> 0.00";
            } 
            // Es un Pago Normal (Débito)
			else {
				$usd = number_format($MontoCont, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
				$bcv = number_format($row['Contado'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
				$str_debito = $usd . ($tasaDef > 1 ? "<br>" . $bcv : "");
				$str_credito = "0.00 <br> 0.00";
			}

			// RESTAURAMOS EL SALDO OCULTO PARA EL MODAL
			$Credito2 = $CreditoTxP;
			$Credito2 += ($ContadoTxP * -1);

			if ($post["MostrarTodos"] === "1" || ($post["MostrarTodos"] === "0" && $row["pagado"] == 0)) {

				if ($row["tasaDef"] > 0) {
					// 1. Extraemos la fecha garantizada desde Fecha3 (Formato: DD/MM/YYYY)
					$fecha_str = $row['Fecha3']; 
					$fecha_ymd = substr($fecha_str, 6, 4) . '-' . substr($fecha_str, 3, 2) . '-' . substr($fecha_str, 0, 2);
					
					// 2. Validamos si es una retención nueva (ISLR después del 9 de Marzo)
					$es_ret_usd = (trim($row['tiporetencion']) == "1" && strtotime($fecha_ymd) >= strtotime('2026-03-09'));
					
					// 3. Calculamos la retención en USD puros
					$ret_calculada = $es_ret_usd ? $row["Retencion"] : ($row["Retencion"] / ($row["tasaDef"] > 0 ? $row["tasaDef"] : 1));
					
					// 4. APLICAMOS AL SALDO DIRECTAMENTE
					$Saldo = $Saldo + ROUND($ret_calculada, 2);
					
					if ($row['item'] > 1) {
						$Saldo = $Saldo + ROUND(($row["Contado"] / ($row["tasaDef"] > 0 ? $row["tasaDef"] : 1)), 2);
					} else if ($row["Idtipotx"] === "4" || $row["Idtipotx"] === "5") {
						$Saldo = $Saldo + ROUND(($row["Contado"] / ($row["tasaDef"] > 0 ? $row["tasaDef"] : 1)), 2);
					}

					if ($row["Idtipotx"] === "7" || $row["Idtipotx"] === "28") {
						$Saldo = $Saldo - ROUND((abs($row["Credito"]) / ($row["tasaDef"] > 0 ? $row["tasaDef"] : 1)), 2);
					} else {
						$Saldo = $Saldo - ROUND((($row["Credito"]) / ($row["tasaDef"] > 0 ? $row["tasaDef"] : 1)), 2);
					}
				}

				if ($row["Dias_Vencidos"] >= 0) {
					$SaldoVencido += ROUND($row["Credito"] / ($row["tasaDef"] > 0 ? $row["tasaDef"] : 1), 2) - ROUND($row["Contado"] / ($row["tasaDef"] > 0 ? $row["tasaDef"] : 1), 2);
				}
				if ($row["pagado"] == 0) {
					$ContadoTotal2 += ROUND(($row["Contado"] / ($row["tasaDef"] > 0 ? $row["tasaDef"] : 1)), 2);

					if ($row["Idtipotx"] === "2" || $row["Idtipotx"] === "7") {
						if ($row["Retencion"] > 0 && $row["item"] > 1) $button .= "<button class='btn btn-light' title='" . lang("Eliminar") . "' onclick='Eliminar(`" . $idtx . "`,`" . $Idtipotx . "`,`" . $IdEstacion . "`,`" . $row["item"] . "`)'><i class='fa fa-times'></i></button>";
						if ($row["item"] <= 1) {
							$button .= "
								<button class='btn btn-light' title='" . lang("Pago") . "' onclick='Abonos(`" . $idtx . "`,`" . $Idtipotx . "`,`" . $IdEstacion . "`,`" . ROUND($ContadoTxP, 2) . "`,`" . ROUND(abs($CreditoTxP), 2) . "`,`" . $tasa . "`)'><i class='fa fa-money'></i></button>
								<button class='btn btn-light' title='" . lang("Credito") . "' onclick='Creditos2(`" . $idtx . "`,`" . $Idtipotx . "`,`" . $IdEstacion . "`,`" . ROUND($ContadoTxP, 2) . "`,`" . ROUND($CreditoTxP, 2) . "`,`" . $tasa . "`)'><i class='fa fa-credit-card'></i></button>
								
								
							";
							 
								$vbnm="<button class='btn btn-light' title='" . lang("Retencion I.S.R.L") . "' onclick='RetencionesISLRnew(`" . $idtx . "`,`" . $Idtipotx . "`,`" . $IdEstacion . "`,`" . $Retencion . "`,`" . ($Credito) . "`)'><i class='fa fa-sticky-note'></i></button>";
								$button .=$vbnm;
								$vbnm="<button class='btn btn-light' title='" . lang("Retencion Impuesto") . "' onclick='Retenciones(`" . $idtx . "`,`" . $Idtipotx . "`,`" . $IdEstacion . "`,`" . $Retencion . "`,`" . ($Credito) . "`)'><i class='fa fa-calculator'></i></button>";
								$button .=$vbnm;
							
							if (($CreditoTxP < 0 ? 0 : ROUND($CreditoTxP, 2)) > 0) {
								$array[$row["IdDef"]] = [
									"Caja" => "<span class='badge bg-dark text-light'>" . $row["etiqueta"] . " No. " . $row["cajaDef"] . "</span><br><span class='badge bg-primary text-light'><i class='fa fa-user'></i> " . $row['Usuario'] . "</span>",
									"Documento" => $Documento,
									"ExtraData" => $ExtraData,
									"Fecha" => $row['Fecha2'],
									"Monto" => "<strong>" . $_POST["MonedaP"] . "</strong> " . number_format($Monto, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . ($row['tasaDef'] > 1 ? "<br> <strong>" . $_POST["MonedaS"] . "</strong> " . (number_format($Monto * $row["tasaDef"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])) : ""),
									"Debito" => ($isUsdRet && round($row['Retencion'], 4) != 0) 
										? (number_format($MontoCont, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . ($row['tasaDef'] > 1 ? "<br> " . (number_format($MontoCont * $row["tasaDef"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])) : ""))
										: (number_format($MontoCont / ($row["tasaDef"] > 0 ? $row["tasaDef"] : 1), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . ($row['tasaDef'] > 1 ? "<br> " . (number_format($MontoCont, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])) : "")),
									"Credito" => number_format($Credito / ($row["tasaDef"] > 0 ? $row["tasaDef"] : 1), $_POST["CD"], $_POST["SimDec"], $_POST['SimMil']) . " " . ($row['tasaDef'] > 1 ? "<br> " . (number_format($Credito, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])) : ""),
									"Saldo" => number_format(ROUND($Saldo, 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]),
									"Contado" => ($ContadoTxP < 0 ? 0 : ROUND($ContadoTxP, 2)),
									"Credito2" => ($CreditoTxP < 0 ? 0 : ROUND($CreditoTxP, 2)),
									"Titulo" => $row['titulo'],
									"Tipo" => $row['Tipo'],
									"Etiqueta" => $row['etiqueta'],
									"Idtx" => str_pad($row['Idtx'], 6, "0", STR_PAD_LEFT),
									"IdBarcode" => $row["IdBarcode"],
									"tasa" => $row["tasaDef"],
									"IdtxF" => $idtx,
									"Idtipotx" => $Idtipotx,
									"IdEstacion" => $IdEstacion,
								];
							}
						}
					} else if (($row["Idtipotx"] <> "3" && $row["Idtipotx"] <> "27") && $row["item"] == 1) {
						if (($CreditoTxP < 0 ? 0 : ROUND($CreditoTxP, 2)) > 0) {
							if ($post["CajaC"] !== "0") {

								$button .= "<button class='btn btn-light' title='" . lang("Pago") . "' onclick='Abonos(`" . $idtx . "`,`" . $Idtipotx . "`,`" . $IdEstacion . "`,`" . ($ContadoTxP < 0 ? 0 : ROUND($ContadoTxP, 2)) . "`,`" . ($CreditoTxP < 0 ? 0 : ROUND($CreditoTxP, 2)) . "`,`" . $tasa . "`)'><i class='fa fa-money'></i></button>";
							}
							$array[$row["IdDef"]] = [
								"Caja" => "<span class='badge bg-dark text-light'>" . $row["etiqueta"] . " No. " . $row["cajaDef"] . "</span><br><span class='badge bg-primary text-light'><i class='fa fa-user'></i> " . $row['Usuario'] . "</span>",
								"Documento" => $Documento,
								"ExtraData" => $ExtraData,
								"Fecha" => $row['Fecha2'],
								"Monto" => "<strong>" . $_POST["MonedaP"] . "</strong> " . number_format($Monto, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . ($row['tasaDef'] > 1 ? "<br> <strong>" . $_POST["MonedaS"] . "</strong> " . (number_format($Monto * $row["tasaDef"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])) : ""),
								"Debito" => number_format($MontoCont  / ($row["tasaDef"] > 0 ? $row["tasaDef"] : 1), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . ($row['tasaDef'] > 1 ? "<br> " . (number_format($MontoCont, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])) : ""),
								"Credito" => number_format($Credito / ($row["tasaDef"] > 0 ? $row["tasaDef"] : 1), $_POST["CD"], $_POST["SimDec"], $_POST['SimMil']) . " " . ($row['tasaDef'] > 1 ? "<br> " . (number_format($Credito, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])) : ""),
								"Saldo" => number_format(ROUND($Saldo, 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]),
								"Contado" => ($ContadoTxP < 0 ? 0 : ROUND($ContadoTxP, 2)),
								"Credito2" => ($CreditoTxP < 0 ? 0 : ROUND($CreditoTxP, 2)),
								"Titulo" => $row['titulo'],
								"Tipo" => $row['Tipo'],
								"Etiqueta" => $row['etiqueta'],
								"Idtx" => str_pad($row['Idtx'], 6, "0", STR_PAD_LEFT),
								"IdBarcode" => $row["IdBarcode"],
								"tasa" => $row["tasaDef"],
								"IdtxF" => $idtx,
								"Idtipotx" => $Idtipotx,
								"IdEstacion" => $IdEstacion,
							];
						}
						if (($ContadoTxP < 0 ? 0 : ROUND($ContadoTxP, 2)) > 0) {
							if ($post["CajaC"] !== "0") {

								$button .= "<button class='btn btn-light' title='" . lang("Credito") . "' onclick='Creditos2(`" . $idtx . "`,`" . $Idtipotx . "`,`" . $IdEstacion . "`,`" . ($ContadoTxP < 0 ? 0 : ROUND($ContadoTxP, 2)) . "`,`" . ($CreditoTxP < 0 ? 0 : ROUND($CreditoTxP, 2))  . "`,`" . $tasa . "`)'><i class='fa fa-credit-card'></i></button>";
							}
						}
					} else if (($row["Idtipotx"] === "3" || $row["Idtipotx"] === "27") && $row["item"] == 1) {
						if ($post["CajaC"] !== "0") {
							if (ROUND($CreditoTxP, 2) < 0) {
								$array[$row["IdDef"]] = [
									"Caja" => "<span class='badge bg-dark text-light'>" . $row["etiqueta"] . " No. " . $row["cajaDef"] . "</span><br><span class='badge bg-primary text-light'><i class='fa fa-user'></i> " . $row['Usuario'] . "</span>",
									"Documento" => $Documento,
									"ExtraData" => $ExtraData,
									"Fecha" => $row['Fecha2'],
									"Monto" => "<strong>" . $_POST["MonedaP"] . "</strong> " . number_format($Monto, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . ($row['tasaDef'] > 1 ? "<br> <strong>" . $_POST["MonedaS"] . "</strong> " . (number_format($Monto * $row["tasaDef"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])) : ""),
									"Debito" => number_format($MontoCont  / ($row["tasaDef"] > 0 ? $row["tasaDef"] : 1), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . ($row['tasaDef'] > 1 ? "<br> " . (number_format($MontoCont, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])) : ""),
									"Credito" => number_format($Credito / ($row["tasaDef"] > 0 ? $row["tasaDef"] : 1), $_POST["CD"], $_POST["SimDec"], $_POST['SimMil']) . " " . ($row['tasaDef'] > 1 ? "<br> " . (number_format($Credito, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])) : ""),
									"Saldo" => number_format(ROUND($Saldo, 2), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]),
									"Contado" => ($ContadoTxP * -1 < 0 ? 0 : ROUND($ContadoTxP * -1, 2)),
									"Credito2" => ($CreditoTxP * -1 < 0 ? 0 : ROUND($CreditoTxP * -1, 2)),
									"Titulo" => $row['titulo'],
									"Tipo" => $row['Tipo'],
									"Etiqueta" => $row['etiqueta'],
									"Idtx" => str_pad($row['Idtx'], 6, "0", STR_PAD_LEFT),
									"IdBarcode" => $row["IdBarcode"],
									"tasa" => $row["tasaDef"],
									"IdtxF" => $idtx,
									"Idtipotx" => $Idtipotx,
									"IdEstacion" => $IdEstacion,
								];
								$button .= "<button class='btn btn-light' title='" . lang("Pago") . "' onclick='Abonos(`" . $idtx . "`,`" . $Idtipotx . "`,`" . $IdEstacion . "`,`" . ($ContadoTxP * -1 < 0 ? 0 : ROUND($ContadoTxP * -1, 2)) . "`,`" . ($CreditoTxP * -1 < 0 ? 0 : ROUND($CreditoTxP * -1, 2)) . "`,`" . $tasa . "`)'><i class='fa fa-money'></i></button>";
							}

							if (ROUND($ContadoTxP, 2) < 0) $button .= "<button class='btn btn-light' title='" . lang("Credito") . "' onclick='Creditos2(`" . $idtx . "`,`" . $Idtipotx . "`,`" . $IdEstacion . "`,`" . ROUND($CreditoTxP, 2) . "`,`" . ROUND($ContadoTxP, 2) . "`,`" . $tasa . "`)'><i class='fa fa-credit-card'></i></button>";
						}
					}
				} else {
					if ($post["CajaC"] !== "0") {
						if ($row["pagado"] == 1 && $row["Idtipotx"] === "2" && $row["item"] <= 1) {
							$button .= "<button class='btn btn-light' title='" . lang("Credito") . "' onclick='Creditos2(`" . $idtx . "`,`" . $Idtipotx . "`,`" . $IdEstacion . "`,`" . $ContadoTxP . "`,`" . $CreditoTxP . "`,`" . $tasa . "`)'><i class='fa fa-credit-card'></i></button>";
						} else if ($row["pagado"] == 1 && $row["Idtipotx"] !== "25" && $row["item"] == 1) $button .= "<button class='btn btn-light' title='" . lang("Credito") . "' onclick='Creditos2(`" . $idtx . "`,`" . $Idtipotx . "`,`" . $IdEstacion . "`,`" . $ContadoTxP . "`,`" . $CreditoTxP . "`,`" . $tasa . "`)'><i class='fa fa-credit-card'></i></button>";
					}
				}

				$tableResponse[] = [
					"etiqueta" => "<span class='badge bg-dark text-light'>" . $row["etiqueta"] . " No. " . $row["cajaDef"] . "</span><br><span class='badge bg-primary text-light'><i class='fa fa-user'></i> " . $row['Usuario'] . "</span>",
					"documento3" => $Documento3,
					"documento2" => $Documento2,
					"documento" => $Documento,
					"extradata" => $ExtraData,
					"fechatabla" => $row['Fecha2'],
					"monto" => ($row["tiporetencion"] != "" && $row["item"] > 1) 
    					? "<strong>" . $_POST["MonedaP"] . "</strong> " . number_format($row["MontoPagar"] / ($row['tasaDef'] > 0 ? $row['tasaDef'] : 1), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . ($row['tasaDef'] > 1 ? "<br> <strong>" . $_POST["MonedaS"] . "</strong> " . (number_format($row["MontoPagar"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])) : "")
    					: "<strong>" . $_POST["MonedaP"] . "</strong> " . number_format($row["MontoPagar"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . ($row['tasaDef'] > 1 ? "<br> <strong>" . $_POST["MonedaS"] . "</strong> " . (number_format($row["MontoPagar"] * $row["tasaDef"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])) : ""),
					"contable" => number_format($MontoCont, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . ($row['tasaDef'] > 1 ? "<br> " . (number_format($MontoCont * $row["tasaDef"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])) : ""),
					"credito" => number_format($row["Credito"] / ($row["tasaDef"] > 0 ? $row["tasaDef"] : 1), $_POST["CD"], $_POST["SimDec"], $_POST['SimMil']) . " " . ($row['tasaDef'] > 1 ? "<br> " . (number_format($row["Credito"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])) : ""),
					"saldo" => number_format($SaldoShow, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]),
					"btn" => "	<div class='btn-group'>
						<div>
							" . $button . "
							<button class='btn btn-light' type='button' title='" . lang("Ver Imagen") . "' onclick='Recibir4(`" . ($IdEstacion . $Idtipotx . $idtx) . "`,`" . $row["Tipo"] . "N°: " . str_pad($row["Idtx"], 10, "0", STR_PAD_LEFT) . "`);'><i class='fa fa-image'></i></button>
						</div>
					</div>",
					"span" => [
						"ContadoAct" => $Contado,
						"CreditoAct" => $Credito2,
						"TasaAct" => $tasa,
						"IdtxAct" => $idtx,
						"IdtipotxAct" => $Idtipotx,
						"IdEstacionAct" => $IdEstacion,
						"RetenidoActualmente" => $Retencion,
						"RetenidoActualmente2" => $Retencion2,
						"RetenidoActualmente3" => $Retencion3,
						"IdDef" => $row["IdDef"],
						"CreditoTxP" => $CreditoTxP,
						"ContadoTxP" => $ContadoTxP,
						"CreditoTxPx" => $CreditoTxP2,
						"ContadoTxPx" => $ContadoTxP2,
						"MontoAPagarqk" => $MontoAPagar,
						"MontoAPagarqkx" => $MontoAPagar2,
						"ItemAct" => $row["item"],
						"RetencionAct" => $row["Retencion"],
						"IdtipotxP" => $Idtipotx,
						"Saldo" => ($row["contadot"] - $row["creditot"])
					],
				];
			}
		}
	}


	$ab = [];

	foreach ($array as $value) {
		$ab[] = $value;
	}
	return json_encode([
		"data" => $tableResponse,
		"general" => [
			"SaldoDadoVencido" => abs($SaldoVencido),
			"SaldoTotal" => abs(ROUND($Saldo, 2)),
			"MontoTotalA" => ($ContadoTotal2 + abs(ROUND($Saldo, 2))),
			"ContadoTotalA" => $ContadoTotal2,
			"CreditoTotalA" => abs(ROUND($Saldo, 2)),
			"query" => $query,
		],
		"array" => $ab,

	], JSON_UNESCAPED_UNICODE);
}


function EliminarTx($conn, $post)
{
	$IdCompany = -1;
	$Idtipotx = -1;
	$Idtx = -1;
	$IdEstacion = -1;
	$query = "SELECT IdCompany,Idtipotx,Idtx,IdEstacion from PosUpTxC WHERE IdBarcode = " . $post["IdBarcode"] . "";
	if ($result = mysqli_query($conn, $query)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$IdCompany = $row['IdCompany'];
			$Idtipotx = $row['Idtipotx'];
			$Idtx = $row['Idtx'];
			$IdEstacion = $row['IdEstacion'];
		}
		mysqli_free_result($result);
	}

	if ($IdCompany !== -1 && $Idtipotx !== -1 && $Idtx !== -1 && $IdEstacion !== -1) {
		$statement = "DELETE FROM PosUpTxP WHERE IdCompany = " . $IdCompany . " and Idtipotx = " . $Idtipotx . " and Idtx = " . $Idtx . " and IdEstacion = '" . $IdEstacion . "'";
		$result =  mysqli_query($conn, $statement);

		if ($result === true) {

			$statement = "DELETE FROM PosUpTxC WHERE IdCompany = " . $IdCompany . " and Idtipotx = " . $Idtipotx . " and Idtx = " . $Idtx . " and IdEstacion = '" . $IdEstacion . "'";
			$result =  mysqli_query($conn, $statement);
			if ($result === true) return 1;
		}
	}
	return 0;
}

function EliminarPago($conn, $post)
{
	$IdCompany = $post['CompanyActual'];
	$Idtipotx = $post['Idtipotx'];
	$Idtx = $post['Idtx'];
	$IdEstacion = $post['IdEstacion'];
	$item = $post['item'];

	$MontoPagar = 0;
	$query = "SELECT MontoPagar, Contado, tasa, EfectivoD FROM PosUpTxP 
		WHERE IdCompany = " . $IdCompany . " and Idtipotx = " . $Idtipotx . " and Idtx = " . $Idtx . " and IdEstacion = '" . $IdEstacion . "' and item = '" . $item . "'";
	if ($result = mysqli_query($conn, $query)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$MontoPagar = $row["MontoPagar"];
			$tasa = $row["tasa"];
			$IdBarcode = $row["EfectivoD"];
		}
		mysqli_free_result($result);
	}


	$query = "SELECT Contado,Credito,tasa, IdBen FROM PosUpTxC WHERE IdCompany=" . $IdCompany . " and Idtx='" . $Idtx . "' and Idtipotx='" . $Idtipotx . "' and IdEstacion='" . $IdEstacion . "'";
	if ($result = mysqli_query($conn, $query)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$tasa = 1;
			if ($row['tasa'] > 1) {
				$tasa = $row['tasa'];
			}
			$ContadoTxC = $row['Contado'] - ($MontoPagar * $tasa);
			$CreditoTxC = $row['Credito'] + ($MontoPagar * $tasa);
			// $IdBen = $row["IdBen"];
		}
		mysqli_free_result($result);
	}
	$conn->autocommit(FALSE);
	if ($post['Anticipo'] === "true") {
		$TxP = [];
		$query = "SELECT IdCompany, Idtipotx, Idtx, IdEstacion, Item, Fectxserver, Fectxclient, MontoPagar, ROUND(IF(Idtipotx in (7,27,28), Contado * -1, Contado),2) as Contado, Credito, Efectivo, Vuelto, Tarjeta, TarjetaD, Cheque, ChequeD, Tipo01, Tipo01D, Tipo02, Tipo02D, Tipo03, Tipo03D, Tipo04, Tipo04D,Login, IdcompanyUser, IdResponsable,Caja,TxfecVence,DAmpliado,Referencia,tasa,TarjetaB,ChequeB,Tipo01B,Tipo02B,Tipo03B,Tipo04B,ROUND(IF(Idtipotx in (7,27,28), Anticipo * -1, Anticipo),2) as Anticipo,AnticipoD,AnticipoB FROM PosUpTxP WHERE IdCompany=" . $IdCompany . " and Idtx='" . $Idtx . "' and Idtipotx='" . $Idtipotx . "' and IdEstacion='" . $IdEstacion . "'";
		if ($result = mysqli_query($conn, $query)) {
			while ($row = mysqli_fetch_assoc($result)) {
				$TxP = $row;
			}
			mysqli_free_result($result);
		}

		$query = "SELECT a.Idtipotx,a.Idtx,a.IdEstacion,a.MontoPagar,
		a.tasa
		FROM PosUpTxP a 
		inner join PosUpTxC b on b.IdCompany = a.IdCompany 
		AND b.Idtx = a.Idtx 
		AND b.Idtipotx = a.Idtipotx 
		AND b.IdEstacion = a.IdEstacion 
		WHERE b.IdBarcode = '" . $IdBarcode . "'";
		if ($result = mysqli_query($conn, $query)) {
			while ($row = mysqli_fetch_assoc($result)) {
				$IdtipotxTXC = $row["Idtipotx"];
				$IdtxTXC = $row["Idtx"];
				$IdEstacionTXC = $row["IdEstacion"];
				$MontoPagar = $row["MontoPagar"];
				$Monto = $TxP["Anticipo"] / $TxP["tasa"];
				$Anticipo = ($Monto * $row["tasa"]);
			}
			mysqli_free_result($result);
		}
		foreach (
			["UPDATE PosUpTxP SET MontoPagar=? WHERE IdCompany=? AND Idtx=? AND Idtipotx=? AND IdEstacion=?" => [
				$MontoPagar - $Anticipo,
				$post["CompanyActual"],
				$IdtxTXC,
				$IdtipotxTXC,
				$IdEstacionTXC
			],] as $query => $params
		) {
			$stmt = $conn->prepare($query);
			$stmt->bind_param(str_repeat("s", count($params)), ...$params);
			if (!$stmt->execute()) {
			}
			$stmt->close();
		}
	}
	/*
	if ($post['Anticipo'] === "true") {
		$TxP = [];
		$query = "SELECT IdCompany, Idtipotx, Idtx, IdEstacion, Item, Fectxserver, Fectxclient, MontoPagar, ROUND(IF(Idtipotx in (7,27,28), Contado * -1, Contado),2) as Contado, Credito, Efectivo, Vuelto, Tarjeta, TarjetaD, Cheque, ChequeD, Tipo01, Tipo01D, Tipo02, Tipo02D, Tipo03, Tipo03D, Tipo04, Tipo04D,Login, IdcompanyUser, IdResponsable,Caja,TxfecVence,DAmpliado,Referencia,tasa,TarjetaB,ChequeB,Tipo01B,Tipo02B,Tipo03B,Tipo04B,ROUND(IF(Idtipotx in (7,27,28), Anticipo * -1, Anticipo),2) as Anticipo,AnticipoD,AnticipoB FROM PosUpTxP WHERE IdCompany=" . $IdCompany . " and Idtx='" . $Idtx . "' and Idtipotx='" . $Idtipotx . "' and IdEstacion='" . $IdEstacion . "'";
		if ($result = mysqli_query($conn, $query)) {
			while ($row = mysqli_fetch_assoc($result)) {
				$TxP = $row;
			}
			mysqli_free_result($result);
		}
		$query = "SELECT a.Efectivo,
		a.Tarjeta,
		a.TarjetaD,
		a.Cheque,
		a.ChequeD,
		a.Tipo01,
		a.Tipo01D,
		a.Tipo02,
		a.Tipo02D,
		a.Tipo03,
		a.Tipo03D,
		a.Tipo04,
		a.Tipo04D,
		a.tasa
		FROM PosUpTxP a 
		inner join PosUpTxC b on b.IdCompany = a.IdCompany 
		AND b.Idtx = a.Idtx 
		AND b.Idtipotx = a.Idtipotx 
		AND b.IdEstacion = a.IdEstacion 
		WHERE b.IdBarcode = '" . $IdBarcode . "'";
		if ($result = mysqli_query($conn, $query)) {
			while ($row = mysqli_fetch_assoc($result)) {
				$tasaOriginal = $row["tasa"];
				$Monto = $TxP["Anticipo"] / $TxP["tasa"];
				$Anticipo = ($Monto * $tasaOriginal);
				$TxP["Contado"] = $Anticipo;
				if ($row["Efectivo"] <> 0) {
					$TxP["Efectivo"] = $Anticipo;
				} else if ($row["Tarjeta"] <> 0) {
					$TxP["Tarjeta"] = $Anticipo;
					$TxP["TarjetaD"] = $row["TarjetaD"];
				} else if ($row["Cheque"] <> 0) {
					$TxP["Cheque"] = $Anticipo;
					$TxP["ChequeD"] = $row["ChequeD"];
				} else if ($row["Tipo01"] <> 0) {
					$TxP["Tipo01"] = $Anticipo;
					if ($tasaOriginal > 1) {
						$ref = explode("|", $row["Tipo01D"]);
						$TxP["Tipo01D"] = $Monto . "|" . $ref[1] . "|" . ROUND($tasaOriginal, 2);
					} else {
						$TxP["Tipo01D"] = $row["Tipo01D"];
					}
				} else if ($row["Tipo02"] <> 0) {
					$TxP["Tipo02"] = $Anticipo;
					$TxP["Tipo02D"] = $row["Tipo02D"];
				} else if ($row["Tipo03"] <> 0) {
					$TxP["Tipo03"] = $Anticipo;
					$TxP["Tipo03D"] = $row["Tipo03D"];
				} else if ($row["Tipo04"] <> 0) {
					$TxP["Tipo04"] = $Anticipo;
					$TxP["Tipo04D"] = $row["Tipo04D"];
				}
			}
			mysqli_free_result($result);
		}
		$TxP["tasa"] = $tasaOriginal;
		$TxP["Anticipo"] = 0;
		$ttx = "numanticipo";
		$statementI = "insert into PosUpTxP (IdCompany, Idtipotx, Idtx, IdEstacion, Item, Fectxserver, Fectxclient, MontoPagar, Contado, Credito, Efectivo, Vuelto, Tarjeta, TarjetaD, Cheque, ChequeD, Tipo01, Tipo01D, Tipo02, Tipo02D, Tipo03, Tipo03D, Tipo04, Tipo04D,Login, IdcompanyUser, IdResponsable,Caja,TxfecVence,DAmpliado,Referencia,tasa,TarjetaB,ChequeB,Tipo01B,Tipo02B,Tipo03B,Tipo04B,Anticipo,AnticipoD,AnticipoB) values ";
		$statement = $statementI . "(" . $TxP["IdCompany"] . " ,'25',(SELECT " . $ttx . "+1 FROM PosUpCompanyEstacion where token='" . $IdEstacion . "'),'" . $IdEstacion . "',1,'" . $TxP["Fectxserver"] . "','" . $TxP["Fectxclient"] . "','0','" . $TxP["Contado"] . "','" . $TxP["Credito"] . "','" . $TxP["Efectivo"] . "','" . $TxP["Vuelto"] . "','" . $TxP["Tarjeta"] . "','" . $TxP["TarjetaD"] . "','" . $TxP["Cheque"] . "','" . $TxP["ChequeD"] . "','" . $TxP["Tipo01"] . "','" . $TxP["Tipo01D"] . "','" . $TxP["Tipo02"] . "','" . $TxP["Tipo02D"] . "','" . $TxP["Tipo03"] . "','" . $TxP["Tipo03D"] . "','" . $TxP["Tipo04"] . "','" . $TxP["Tipo04D"] . "','" . $TxP['Login'] . "','" . $TxP["IdcompanyUser"] . "','" . $TxP["IdResponsable"] . "',(SELECT CajaActual FROM PosUpCompanyEstacion where token='" . $IdEstacion . "'),'" . $TxP["TxfecVence"] . "','" . $TxP["DAmpliado"] . "','" . $TxP["Referencia"] . "','" . $TxP["tasa"] . "','" . $TxP["TarjetaB"] . "','" . $TxP["ChequeB"] . "','" . $TxP["Tipo01B"] . "','" . $TxP["Tipo02B"] . "','" . $TxP["Tipo03B"] . "','" . $TxP["Tipo04B"] . "','" . $TxP["Anticipo"] . "','" . $TxP["AnticipoD"] . "','" . $TxP["AnticipoB"] . "')";
		$resultTXP =  mysqli_query($conn, $statement);

		if ($resultTXP === false) {
			$conn->rollback();
			return json_encode(["status" => false, $statement]);
		}

		$statement2 = "insert into PosUpTxC (IdCompany, Idtipotx, Idtx, Fectxserver, Fectxclient,  IdUser, IdUserAutDcto, SubTotal, Dcto, Total, Costo, Margen, DctoAplicado, MargenDcto, Items, IdEstacion, Contado, Credito, Cobrado,IdCompanyUserAutDcto, IdCompanyUser,IdtipotxPadre, IdtxPadre, IdEstacionPadre,IdAlmO,IdAlmD,motivo,DAmpliado,IdBen,Referencia,excento,imponible,impuesto,totalimp,numctrol,TxfecVence,tasa) values (" . $IdCompany . ",'25',(SELECT " . $ttx . "+1 FROM PosUpCompanyEstacion where token='" . $IdEstacion . "'),now(),'" . $_POST['Fectxclient'] . "','" . $_POST['userlogin'] . "','0','" . $TxP["Contado"] . "','0','" . $TxP["Contado"] . "','0','0','0','0','','" . $IdEstacion . "','" . $TxP["Contado"] . "','0','0','0','" . $_POST['IdCompanyUser'] . "','0','0','0','0','0','0','','" . $IdBen . "','','0','0','0','0','0','" . $_POST['Fectxclient'] . "','" . $TxP["tasa"] . "')";
		$resultTXC =  mysqli_query($conn, $statement2);

		if ($resultTXC === false) {
			$conn->rollback();
			return json_encode(["status" => false, $statement2]);
		}

		$statement3 = "update PosUpCompanyEstacion set " . $ttx . "=" . $ttx . "+1 where token='" . $IdEstacion . "'";
		$resultEst = mysqli_query($conn, $statement3);

		if ($resultEst === false) {
			$conn->rollback();
			return json_encode(["status" => false, $statement3]);
		}
	}
	*/

	$statement2 = "update PosUpTxC set Cobrado='" . $ContadoTxC . "',Contado='" . $ContadoTxC . "',Credito=" . $CreditoTxC . " 
		where IdCompany=" . trim($IdCompany) . " and Idtx=" . trim($Idtx) . " and Idtipotx=" . trim($Idtipotx) . " and IdEstacion='" . trim($IdEstacion) . "'";
	$resultado2 =  mysqli_query($conn, $statement2);


	$statement = "DELETE FROM PosUpTxP WHERE IdCompany = " . $IdCompany . " and Idtipotx = " . $Idtipotx . " and Idtx = " . $Idtx . " and IdEstacion = '" . $IdEstacion . "' and item = '" . $item . "'";
	$result =  mysqli_query($conn, $statement);

	if ($resultado2 && $result) {
		$conn->commit();
		return json_encode(["status" => true,]);
	} else {
		$conn->rollback();
		return json_encode(["status" => false,]);
	}
}

function AnticipadosCrud($conn, $post, $request)
{

	$sql = "SELECT ROUND(abs(a.Contado/b.tasa),2) as Contado,ROUND(abs(a.MontoPagar/b.tasa),2) as MontoPagar,a.Referencia,DATE_FORMAT(a.Fectxclient,'%d/%m/%Y %h:%i:%s %p') as Fecha,b.IdBarcode,
	if(if(b.Idtipotx in (1,2,3,4,5,6,11,12,13,15,21,22,23,24,25,26,31,35,36,37),ee.NumTxViewVTA,if(b.Idtipotx in (7,14,20,27,28),ee.NumTxViewCOM,if(b.Idtipotx in (8,9,10,16,17,18,19,29,30,32,33,34,39),ee.NumTxViewINV,''))) = 0,b.IdtxCompany,if(if(b.Idtipotx in (1,2,3,4,5,6,11,12,13,15,21,22,23,24,25,26,31,35,36,37),ee.NumTxViewVTA,if(b.Idtipotx in (7,14,20,27,28),ee.NumTxViewCOM,if(b.Idtipotx in (8,9,10,16,17,18,19,29,30,32,33,34,39),ee.NumTxViewINV,''))) = 1,b.Idtx,b.Referencia)) as IdtxDef,
	IF(a.Contado > 0, 1, 0) as TipoAnticipo 
	FROM PosUpTxP a 
	left join PosUpCompany ee on ee.id = " . trim($post["CompanyActual"]) . "
	left join PosUpTxC b on b.IdCompany=a.IdCompany and a.Idtipotx=b.Idtipotx and a.Idtx=b.Idtx and a.IdEstacion=b.IdEstacion
	WHERE a.IdCompany = " . trim($post["CompanyActual"]) . " AND a.IdResponsable = '" . trim($post['IdBen']) . "' and a.Idtipotx=25 
	and ROUND(ABS(a.Contado),2) != ROUND(ABS(a.MontoPagar),2)";
	$query = mysqli_query($conn, $sql);
	$totalData = mysqli_num_rows($query);
	$totalFilter = $totalData;
	if (!empty($request['search']['value'])) {
		$sql .= " AND ( if(if(b.Idtipotx in (1,2,3,4,5,6,11,12,13,15,21,22,23,24,25,26,31,35,36,37),ee.NumTxViewVTA,if(b.Idtipotx in (7,14,20,27,28),ee.NumTxViewCOM,if(b.Idtipotx in (8,9,10,16,17,18,19,29,30,32,33,34,39),ee.NumTxViewINV,''))) = 0,b.IdtxCompany,if(if(b.Idtipotx in (1,2,3,4,5,6,11,12,13,15,21,22,23,24,25,26,31,35,36,37),ee.NumTxViewVTA,if(b.Idtipotx in (7,14,20,27,28),ee.NumTxViewCOM,if(b.Idtipotx in (8,9,10,16,17,18,19,29,30,32,33,34,39),ee.NumTxViewINV,''))) = 1,b.Idtx,b.Referencia)) Like '%" . $request['search']['value'] . "%' )";
	}
	$query = mysqli_query($conn, $sql);
	$totalData = mysqli_num_rows($query);
	$sql .= " ORDER BY Fecha ASC  LIMIT " .
		$request['start'] . "  ," . $request['length'] . "  ";
	$query = mysqli_query($conn, $sql);
	$data = array();
	while ($row = mysqli_fetch_array($query)) {
		$subdata = array();
		$tag = "";
		if ($row["TipoAnticipo"] == 1) {
			$tag = "<span class='badge bg-success text-light'>" . lang("Anticipo Para Ventas") . "</span>";
		} else {
			$tag = "<span class='badge bg-danger text-light'>" . lang("Anticipo Para Compras") . "</span>";
		}

		$subdata[] = $tag . "<span class='badge bg-light text-dark'>#" . str_pad($row["IdtxDef"], 6, "0", STR_PAD_LEFT)  . "</span> " . (trim($row['Referencia']) !== "" ? "<span class='badge bg-dark text-light'>" .  $row['Referencia'] . "</span>" : "") . " <span class='badge bg-success text-light'><i class='fa fa-calendar'></i> " . $row['Fecha'] . "</span>";
		$subdata[] = "<div class='text-end'>" . number_format(abs($row['MontoPagar']), $_POST['CD'], $_POST['SimDec'], $_POST['SimMil']) . " / " . number_format(abs($row['Contado']), $_POST['CD'], $_POST['SimDec'], $_POST['SimMil']) . "</div>";
		$subdata[] = "<div class='btn-group'><button class='btn btn-outline-danger px-1' type='button' onclick='DeleteAnticipo(`" . $row['IdBarcode'] . "`);'><i class='fa fa-trash'></i> " . lang("Eliminar") . "</button></div>";
		$data[] = $subdata;
	}
	$json_data = array(
		"draw"              =>  intval($request['draw']),
		"recordsTotal"      =>  intval($totalData),
		"recordsFiltered"   =>  intval($totalFilter),
		"data"              =>  $data,
		"sql" => $sql,
	);
	return json_encode($json_data);
}

/*
if ($_POST["Accion"] === "RefreshTable") {

	include "ambienteconsultas.php";
	$conn = conectar();

	echo RefreshTable($conn, $_POST);
}
*/

if ($_POST["Accion"] == "3") {
	include "ambienteconsultas.php";
	$conn = conectar();
	$SaldoAnticipo = 0;
	$query3 = "select
	sum(((ABS(a.Contado))-ABS(a.MontoPagar)) / IF(a.tasa <= 0,1,a.tasa)) as Total
from
	PosUpTxP a
where
	a.IdCompany = " . trim($_POST["CompanyActual"]) . " 
	and a.IdResponsable = '" . trim($_POST['IdBen']) . "'
	and a.Idtipotx = 25
    and Contado > 0
";
	if ($result3 = mysqli_query($conn, $query3)) {
		while ($row3 = mysqli_fetch_assoc($result3)) {
			$SaldoAnticipo = $SaldoAnticipo + $row3['Total'];
		}
		mysqli_free_result($result3);
	}
	$SaldoAnticipo2 = 0;
	$query3 = "select
	sum(((ABS(a.Contado))-ABS(a.MontoPagar)) / IF(a.tasa <= 0,1,a.tasa)) as Total
from
	PosUpTxP a
where
	a.IdCompany = " . trim($_POST["CompanyActual"]) . " 
	and a.IdResponsable = '" . trim($_POST['IdBen']) . "'
	and a.Idtipotx = 25
    and Contado < 0
";
	if ($result3 = mysqli_query($conn, $query3)) {
		while ($row3 = mysqli_fetch_assoc($result3)) {
			$SaldoAnticipo2 = $SaldoAnticipo2 + $row3['Total'];
		}
		mysqli_free_result($result3);
	}
	$query2 = "SELECT Nombre,Fono,Direccion,Comuna,email,TipoCredito FROM PosUpclientes WHERE IdCompany='" . trim($_POST['CompanyActual']) . "' and RUT='" . trim($_POST['IdBen']) . "'";
	if ($result2 = mysqli_query($conn, $query2)) {
		while ($row2 = mysqli_fetch_assoc($result2)) {
		?>
			<div class="row">
				<div class="card bg-light border-0 shadow-sm mb-4 col-lg-4 col-md-6 col-sm-12 col-12 px-0" style="border-radius: 10px;">
					<div class="card-header bg-white d-flex justify-content-between align-items-center px-4" style=" border-bottom: 1px solid #dee2e6;">
						<h5 class="mb-0"><?php echo lang("Beneficiario"); ?></h5>
					</div>
					<div class="card-body px-4">
						<div class="row">
							<div class="col-6">
								<div class="text-secondary" style="font-size: 0.6rem;"><?php echo $_POST['litfiscal']; ?></div>
								<div class="font-weight-bold" style="font-size: 0.75rem;"><?php echo $_POST['IdBen']; ?></div>
							</div>
							<div class="col-6">
								<div class="text-secondary" style="font-size: 0.6rem;"><?php echo lang("Nombre"); ?></div>
								<div class="font-weight-bold" style="font-size: 0.75rem;" id="NameBeneficairio"><?php echo $row2['Nombre']; ?></div>
							</div>
						</div>
						<div class="row">
							<div class="col-6">
								<div class="text-secondary" style="font-size: 0.6rem;"><?php echo lang("Teléfono"); ?></div>
								<div class="font-weight-bold" style="font-size: 0.75rem;"><?php echo $row2['Fono']; ?></div>
							</div>
							<div class="col-6">
								<div class="text-secondary" style="font-size: 0.6rem;"><?php echo lang("Dirección"); ?></div>
								<div class="font-weight-bold" style="font-size: 0.75rem;"><?php echo $row2['Direccion']; ?></div>
							</div>
						</div>
						<div class="row">
							<div class="col-6">
								<div class="text-secondary" style="font-size: 0.6rem;"><?php echo lang("Comuna"); ?></div>
								<div class="font-weight-bold" style="font-size: 0.75rem;"><?php echo $row2['Comuna']; ?></div>
							</div>
							<div class="col-6">
								<div class="text-secondary" style="font-size: 0.6rem;"><?php echo lang("Email"); ?></div>
								<div class="font-weight-bold" style="font-size: 0.75rem;"><?php echo $row2['email']; ?></div>
							</div>
						</div>
						<div class="row">
							<div class="col-6">
								<div class="text-secondary" style="font-size: 0.6rem;"><?php echo lang("Límite De Crédito"); ?></div>
								<div class="font-weight-bold" style="font-size: 0.75rem;"><?php echo number_format($row2['TipoCredito'], $_POST['CD'], $_POST['SimDec'], $_POST['SimMil']); ?></div>
							</div>
							<div class="col-6">
								<div class="text-secondary d-flex justify-content-between align-items-center" style="font-size: 0.6rem;">
									<?php echo lang("Saldo Anticipo"); ?>
									<button class="btn btn-outline-dark btn-sm p-1" type="button" onclick="AnticipadosCrud();" style="font-size: 0.6rem;">
										<i class="fa fa-eye"></i>
									</button>
								</div>
								<div class="font-weight-bold" style="font-size: 0.75rem;">
									<span class="badge bg-success text-light"><?php echo lang("Venta") . ": " . number_format($SaldoAnticipo, $_POST['CD'], $_POST['SimDec'], $_POST['SimMil']); ?></span>
									/
									<span class="badge bg-danger text-light"><?php echo lang("Compra") . ": " . number_format($SaldoAnticipo2, $_POST['CD'], $_POST['SimDec'], $_POST['SimMil']); ?></span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card bg-warning text-dark border-0 shadow-sm mb-4 col-lg-4 col-md-6 col-sm-12 col-12 px-0" style="border-radius: 10px;">
					<div class="card-header bg-white d-flex justify-content-between align-items-center px-4" style=" border-bottom: 1px solid #dee2e6;">
						<h5 class="mb-0"><?php echo lang("Totales"); ?></h5>
					</div>
					<div class="card-body px-4">
						<div class="row">
							<div class="dashleft col-4 text-start">
								<div class="dashletg" style="font-size: 0.75rem;"><?php echo lang("Monto"); ?> </div>
							</div>
							<div class="dashright col-8 text-end">
								<div class="dashletg" id="Monto001" style="font-size: 0.6rem;"></div>
								<div class="dashletp" id="Monto002" style="font-size: 0.6rem;"></div>
							</div>
						</div>
						<div class="row">
							<div class="dashleft col-4 text-start">
								<div class="dashletg" style="font-size: 0.75rem;"><?php echo lang("Débito"); ?> </div>
							</div>
							<div class="dashright col-8 text-end">
								<div class="dashletg" id="Monto003" style="font-size: 0.6rem;"></div>
								<div class="dashletp" id="Monto004" style="font-size: 0.6rem;"></div>
							</div>
						</div>
						<div class="row">
							<div class="dashleft col-4 text-start">
								<div class="dashletg" style="font-size: 0.75rem;"><?php echo lang("Crédito"); ?> </div>
							</div>
							<div class="dashright col-8 text-end">
								<div class="dashletg" id="Monto005" style="font-size: 0.6rem;"></div>
								<div class="dashletp" id="Monto006" style="font-size: 0.6rem;"></div>
							</div>
						</div>
						<div class="row" style="display: none;">
							<div class="dashleft col-4 text-start">
								<div class="dashletg" style="font-size: 0.75rem;"><?php echo lang("Saldo"); ?> </div>
							</div>
							<div class="dashright col-8 text-end">
								<div class="dashletg" id="Monto007" style="font-size: 0.6rem;"></div>
								<div class="dashletp" id="Monto008" style="font-size: 0.6rem;"></div>
							</div>
						</div>
						<div class="row">
							<div class="dashleft col-4 text-start">
								<div class="dashletg" style="font-size: 0.75rem;"><?php echo lang("S. Vencido"); ?> </div>
							</div>
							<div class="dashright col-8 text-end">
								<div class="dashletg" id="SaldoPCXXXX" style="font-size: 0.6rem;"></div>
								<div class="dashletp" id="SaldoPC2XXXX" style="font-size: 0.6rem;"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="card bg-primary text-light border-0 shadow-sm mb-4 col-lg-4 col-md-6 col-sm-12 col-12 px-0 d-none" style="border-radius: 10px;" id="divmayor">
					<div class="card-header bg-white text-dark d-flex justify-content-between align-items-center px-4" style=" border-bottom: 1px solid #dee2e6;">
						<h5 class="mb-0"><?php echo lang("Movimiento"); ?></h5>
					</div>
					<div class="card-body px-4 ">
						<div class="row">
							<div class="dashleft col-4 text-start">
								<div class="dashletg" style="font-size: 0.75rem;"><?php echo lang("Monto"); ?> </div>
							</div>
							<div class="dashright col-8 text-end">
								<div class="dashletg" id="MontoPC" style="font-size: 0.6rem;"></div>
								<div class="dashletp" id="MontoPC2" style="font-size: 0.6rem;"></div>
							</div>
						</div>
						<div class="row">
							<div class="dashleft col-4 text-start">
								<div class="dashletg" style="font-size: 0.75rem;"><?php echo lang("Débito"); ?> </div>
							</div>
							<div class="dashright col-8 text-end">
								<div class="dashletg" id="DebitoPC" style="font-size: 0.6rem;"></div>
								<div class="dashletp" id="DebitoPC2" style="font-size: 0.6rem;"></div>
							</div>
						</div>
						<div class="row">
							<div class="dashleft col-4 text-start">
								<div class="dashletg" style="font-size: 0.75rem;"><?php echo lang("Crédito"); ?> </div>
							</div>
							<div class="dashright col-8 text-end">
								<div class="dashletg" id="CreditoPC" style="font-size: 0.6rem;"></div>
								<div class="dashletp" id="CreditoPC2" style="font-size: 0.6rem;"></div>
							</div>
						</div>
						<div class="row" style="display: none;">
							<div class="dashleft col-4 text-start">
								<div class="dashletg" style="font-size: 0.75rem;"><?php echo lang("Saldo"); ?> </div>
							</div>
							<div class="dashright col-8 text-end">
								<div class="dashletg" id="SaldoPC" style="font-size: 0.6rem;"></div>
								<div class="dashletp" id="SaldoPC2" style="font-size: 0.6rem;"></div>
							</div>
						</div>
						<div class="row">
							<div class="dashleft col-4 text-start">
								<div class="dashletg" style="font-size: 0.75rem;"><?php echo lang("Emisión"); ?> </div>
							</div>
							<div class="dashright col-8 text-end">
								<div class="dashletg" id="EmisionPC" style="font-size: 0.6rem;"></div>
								<div class="dashletp" id="SaldoPC2XXXX" style="font-size: 0.6rem;"></div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<span id="LimiCreditoA" style="display: none;"><?php echo $row2["TipoCredito"]; ?></span>
	<?php
		}
		mysqli_free_result($result);
	}
}

if ($_POST["Accion"] == "4") {
	include "ambienteconsultas.php";
	$conn = conectar();

	$Fecha = $_POST['Fecha'];
	$año = substr($Fecha, 0, 4);
	$mes = substr($Fecha, 5, 2);
	$Codigo = $año . $mes;
	$query = "select concat('" . $Codigo . "',LPAD(max(CAST(replace(Referencia,'" . $Codigo . "','') AS UNSIGNED)+1), 8, '0')) as df2  from PosUpTxP where IdCompany = " . trim($_POST["CompanyActual"]) . " and left(Referencia,LENGTH('" . $Codigo . "')) = '" . $Codigo . "' and tiporetencion = 0";
	if ($result = mysqli_query($conn, $query)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$Cod = $row['df2'];
		}
		mysqli_free_result($result);
	}
	if (trim($Cod) == "") {
		$Cod = $Codigo . str_pad("1", 8, "0", STR_PAD_LEFT);
	}
	echo $Cod;
}

if ($_POST["Accion"] == "5") {
	include "ambienteconsultas.php";
	$conn = conectar();

	$query = "SELECT total,tasa,Idtx,Idtipotx,(impuesto*tasa) as impuesto,(imponible*tasa) as imponible,(excento*tasa) as excento,DATE_FORMAT(Fectxclient,'%Y-%m-%d') as fecha FROM PosUpTxC where IdCompany=" . trim($_POST["CompanyActual"]) . " and Idtx='" . $_POST["Idtx"] . "' and Idtipotx='" . $_POST["Idtipotx"] . "' and IdEstacion='" . $_POST["IdEstacion"] . "'";
	if ($result = mysqli_query($conn, $query)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$impuesto = $row['impuesto'];
			$imponible = $row['imponible'];
			$excento = $row['excento'];
			$fecha = $row['fecha'];
			$Idtipotx = $row['Idtipotx'];
			$Idtx = $row['Idtx'];
			$total = $row['total'];
			$totaltasa = $row['total'] * $row['tasa'];
			$tasa = $row['tasa'];
		}
		mysqli_free_result($result);
	}
	$CreditoActual = $_POST["CreditoActual"];
	$RetenidoActual = $impuesto - $_POST['RetenidoActual'];
	if ($CreditoActual > $RetenidoActual) {
		$MontoMaximiliano = $RetenidoActual;
	} else {
		if ($CreditoActual < $RetenidoActual) {
			$MontoMaximiliano = $CreditoActual;
		}
	}
	?>
	<span id="ImpuActTxC"><?php echo $impuesto; ?></span>
	<span id="ImpoActTxC"><?php echo $imponible; ?></span>
	<span id="ExcActTxC"><?php echo $excento; ?></span>
	<span id="FectxActTxC"><?php echo $fecha; ?></span>
	<span id="totalTxC"><?php echo number_format($total, $_POST['CD'], $_POST['SimDec'], $_POST['SimMil']); ?></span>
	<span id="totaltasaTxC"><?php echo number_format($totaltasa, $_POST['CD'], $_POST['SimDec'], $_POST['SimMil']); ?></span>
	<span id="tasaTxC"><?php echo number_format($tasa, $_POST['CD'], $_POST['SimDec'], $_POST['SimMil']); ?></span>
	<span id="RetenidoActualTXCDUD"><?php echo number_format($MontoMaximiliano, $_POST['CD'], $_POST['SimDec'], $_POST['SimMil']); ?></span>
	<span id="IdtipotxActTxC"><?php echo $Idtipotx; ?></span>
	<span id="IdtxActTxC"><?php echo $Idtx; ?></span>
<?php
}

if ($_POST["Accion"] == "6") {
	include "ambienteconsultas.php";
	$conn = conectar();

	$Fecha = $_POST['Fecha'];
	$año = substr($Fecha, 0, 4);
	$mes = substr($Fecha, 5, 2);
	$Codigo = $año . $mes;
	$query = "select concat('" . $Codigo . "',LPAD(max(CAST(replace(Referencia,'" . $Codigo . "','') AS UNSIGNED)+1), 8, '0')) as df2  from PosUpTxP where IdCompany = " . trim($_POST["CompanyActual"]) . " and left(Referencia,LENGTH('" . $Codigo . "')) = '" . $Codigo . "' and tiporetencion = 1";
	if ($result = mysqli_query($conn, $query)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$Cod = $row['df2'];
		}
		mysqli_free_result($result);
	}
	if (trim($Cod) == "") {
		$Cod = $Codigo . str_pad("1", 8, "0", STR_PAD_LEFT);
	}
	echo $Cod;
}

if ($_POST["Accion"] == "7") {
	include "ambienteconsultas.php";
	$conn = conectar();

	$query = "SELECT total,tasa,Idtx,Idtipotx,(impuesto*tasa) as impuesto,(imponible*tasa) as imponible,(excento*tasa) as excento,DATE_FORMAT(Fectxclient,'%Y-%m-%d') as fecha FROM PosUpTxC where IdCompany=" . trim($_POST["CompanyActual"]) . " and Idtx='" . $_POST["Idtx"] . "' and Idtipotx='" . $_POST["Idtipotx"] . "' and IdEstacion='" . $_POST["IdEstacion"] . "'";
	if ($result = mysqli_query($conn, $query)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$impuesto = $row['impuesto'];
			$imponible = $row['imponible'];
			$excento = $row['excento'];
			$fecha = $row['fecha'];
			$Idtipotx = $row['Idtipotx'];
			$Idtx = $row['Idtx'];
			$total = $row['total'];
			$totaltasa = $row['total'] * $row['tasa'];
			$tasa = $row['tasa'];
		}
		mysqli_free_result($result);
	}
?>
	<span id="ImpuActTxC2"><?php echo $impuesto; ?></span>
	<span id="ImpoActTxC2"><?php echo $imponible; ?></span>
	<span id="ExcActTxC2"><?php echo $excento; ?></span>
	<span id="FectxActTxC2"><?php echo $fecha; ?></span>
	<span id="totalTxC2"><?php echo number_format($total, $_POST['CD'], $_POST['SimDec'], $_POST['SimMil']); ?></span>
	<span id="totaltasaTxC2"><?php echo number_format($totaltasa, $_POST['CD'], $_POST['SimDec'], $_POST['SimMil']); ?></span>
	<span id="tasaTxC2"><?php echo number_format($tasa, $_POST['CD'], $_POST['SimDec'], $_POST['SimMil']); ?></span>
	<span id="RetenidoActualTXCDUD2"><?php echo number_format($impuesto - $_POST['RetenidoActual'], $_POST['CD'], $_POST['SimDec'], $_POST['SimMil']); ?></span>
	<span id="IdtipotxActTxC2"><?php echo $Idtipotx; ?></span>
	<span id="IdtxActTxC2"><?php echo $Idtx; ?></span>
	<?php
}

if ($_POST['Accion'] == '8') {
	include "ambienteconsultas.php";
	$conn = conectar();

	if ($_POST["Ini"] == "0") {
	?>
		<table class="table nowrap" id="AnticipoSelecTable" cellspacing="0" style="width:100%">
			<thead>
				<tr>
					<th class="text-start">#</th>
					<th class="text-start"><?php echo lang("Fecha"); ?></th>
					<th class="text-start"><?php echo lang("Referencia"); ?></th>
					<th class="text-end"><?php echo lang("Monto") . " (" . $_POST["MonedaP"] . ")"; ?></th>
					<th class="text-end"><?php echo lang("Usado") . " (" . $_POST["MonedaP"] . ")"; ?></th>
					<th class="text-start"><?php echo lang("Opciones"); ?></th>
				</tr>
			</thead>
		</table>
	<?php
	}
	if ($_POST["Ini"] == "1") {
		$request = $_REQUEST;
		$col = array(
			0   =>  'Idtx',
			1   =>  'Fectxclient',
			2   =>  'Referencia',
			3   =>  'Contado',
			4   =>  'MontoPagar',
			5   =>  'Credito',
		);
		if ($_POST["Idtipotx"] === "7") {

			$sql = "SELECT a.Idtx,(abs(a.Contado)/b.tasa) as Contado, (abs(a.MontoPagar)/b.tasa) as MontoPagar,a.Referencia,DATE_FORMAT(a.Fectxclient,'%Y-%m-%d') as Fectxclient,a.IdEstacion,a.Idtipotx FROM PosUpTxP a inner join PosUpTxC b on a.IdCompany=b.IdCompany and a.Idtipotx=b.Idtipotx and a.Idtx=b.Idtx and a.IdEstacion=b.IdEstacion  WHERE a.IdCompany = " . trim($_POST["CompanyActual"]) . " AND a.IdResponsable = '" . trim($_POST['IdBen']) . "' and a.Idtipotx=25 and a.Contado < 0 and ABS(a.Contado)!=ABS(a.MontoPagar)";
		} else {
			$sql = "SELECT a.Idtx,(a.Contado/b.tasa) as Contado, (a.MontoPagar/b.tasa) as MontoPagar,a.Referencia,DATE_FORMAT(a.Fectxclient,'%Y-%m-%d') as Fectxclient,a.IdEstacion,a.Idtipotx FROM PosUpTxP a inner join PosUpTxC b on a.IdCompany=b.IdCompany and a.Idtipotx=b.Idtipotx and a.Idtx=b.Idtx and a.IdEstacion=b.IdEstacion  WHERE a.IdCompany = " . trim($_POST["CompanyActual"]) . " AND a.IdResponsable = '" . trim($_POST['IdBen']) . "' and a.Idtipotx=25 and a.Contado > 0 and ROUND(a.Contado,2) != ROUND(a.MontoPagar,2)
			";
		}
		$query = mysqli_query($conn, $sql);
		$totalData = mysqli_num_rows($query);
		$totalFilter = $totalData;
		if (!empty($request['search']['value'])) {
			if (!empty($request['search']['value'])) {
				$sql .= " AND ( Idtx Like '%" . $request['search']['value'] . "%'";
				$sql .= " OR Fectxclient Like '%" . $request['search']['value'] . "%' ";
				$sql .= " OR Referencia Like '%" . $request['search']['value'] . "%' )";
			}
		}
		$query = mysqli_query($conn, $sql);
		$totalData = mysqli_num_rows($query);
		if ($col[$request['order'][0]['column']] && $request['order'][0]['dir']) {
			$sql .= " ORDER BY " . $col[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'] . "";
		}

		$sql .= " LIMIT " . $request['start'] . "  ," . $request['length'] . "  ";
		$query = mysqli_query($conn, $sql);
		$data = array();
		while ($row = mysqli_fetch_array($query)) {
			$subdata = array();
			$subdata[] = $row['Idtx'];
			$subdata[] = $row['Fectxclient'];
			$subdata[] = $row['Referencia'];
			$subdata[] = "<div class='text-end'>" . number_format($row['Contado'], $_POST['CD'], $_POST['SimDec'], $_POST['SimMil']) . "</div>";
			$subdata[] = "<div class='text-end'>" . number_format($row['MontoPagar'], $_POST['CD'], $_POST['SimDec'], $_POST['SimMil']) . "</div>";
			$subdata[] = "<div class='btn-group'><button class='btn btn-outline-dark' type='button' title='" . lang("Seleccionar Registro") . "' onclick='TomarComoPago(`" . $row['Idtx'] . "`,`" . $row["Idtipotx"] . "`,`" . $row["IdEstacion"] . "`,`" . $row["Contado"] . "`,`" . $row["MontoPagar"] . "`);'><i class='fa fa-arrow-right'></i> " . lang("Usar") . "</button></div>";
			$data[] = $subdata;
		}
		$json_data = array(
			"draw"              =>  intval($request['draw']),
			"recordsTotal"      =>  intval($totalData),
			"recordsFiltered"   =>  intval($totalFilter),
			"data"              =>  $data,
		);
		echo json_encode($json_data);
	}
}

if ($_POST['Accion'] == '9') {
	include "ambienteconsultas.php";
	$conn = conectar();
	if ($_POST["Idtipotx"] === "7") {
		$query3 = "select sum(ABS(Contado)-ABS(MontoPagar)) as Total from PosUpTxP where IdCompany = " . trim($_POST["CompanyActual"]) . " and IdResponsable='" . trim($_POST['IdBen']) . "' and Idtipotx=25 and Contado < 0 and ABS(Contado)!=ABS(MontoPagar)";
	} else {
		$query3 = "select sum((Contado)-MontoPagar) as Total from PosUpTxP where IdCompany = " . trim($_POST["CompanyActual"]) . " and IdResponsable='" . trim($_POST['IdBen']) . "' and Contado > 0 and Idtipotx=25 and ROUND(Contado,2) != ROUND(MontoPagar,2)";
	}
	$SaldoAnticipo = 0;
	if ($result3 = mysqli_query($conn, $query3)) {
		while ($row3 = mysqli_fetch_assoc($result3)) {
			$SaldoAnticipo = $SaldoAnticipo + $row3['Total'];
		}
		mysqli_free_result($result3);
	}
	if ($SaldoAnticipo > 0) {
		echo 1;
	} else {
		echo 0;
	}
}

if ($_POST['Accion'] == '10') {
	include "ambienteconsultas.php";
	$conn = conectar();

	if ($_POST['Editar'] == "NO") {
		$query = "select coalesce(CONCAT(year(FectxClient),'-',lpad(month(FectxClient),2,'0'),'-',lpad(mid(max(Referencia),9,10)+1,10,'0')),CONCAT(year(FectxClient),'-',month(FectxClient),'-','00000000001')) as refnew from PosUpTxP where IdCompany = " . trim($_POST["CompanyActual"]) . " and montoretencion > 0";
		//echo $query;
		if ($result = mysqli_query($conn, $query)) {
			while ($row = mysqli_fetch_assoc($result)) {
				$refnew = $row['refnew'];
			}
			mysqli_free_result($result);
		}
		echo $refnew;
	}
	if ($_POST['Editar'] == 'SI') {
		$conn = conectar();
		$query = "SELECT a.DAmpliado,a.Referencia FROM PosUpTxP a WHERE a.IdCompany='" . trim($_POST['CompanyActual']) . "' and a.Idtx='" . $_POST['Idtx'] . "' and a.Idtipotx='" . $_POST['Idtipotx'] . "' and a.IdEstacion='" . $_POST['IdEstacion'] . "' and a.Item='" . $_POST['Item'] . "'";
		//echo $query;
		$DAmpliado = "";
		$Referencia = "";
		if ($result = mysqli_query($conn, $query)) {
			while ($row = mysqli_fetch_assoc($result)) {
				$DAmpliado = $row['DAmpliado'];
				$Referencia = $row['Referencia'];
			}
			mysqli_free_result($result);
		}
	?>
		<span style='display:none;' id='Dampliadoactual'><?php echo $DAmpliado; ?></span>
		<span style='display:none;' id='Referenciactual'><?php echo $Referencia; ?></span>
<?php
	}
}

if ($_POST["Accion"] == "11") {
	include "ambiente.php";
	$conn = conectar();

	$control = $_POST["nroControl"];
	$numz = $_POST["numz"];
	$Fectxclient = $_POST["Fectxclient"];
	$TxfecVence = $_POST["TxfecVence"];
	$Idtipotx = $_POST["Idtipotx"];
	$IdBen = $_POST["IdBen"];
	$DAmpliado = $_POST["DAmpliado"];
	$Referencia = $_POST["Referencia"];
	$IdImpuesto = $_POST["IdImpuesto"];
	$Tasa = abs($_POST["Tasa"]);

	$Imponible = abs($_POST["Imponible"]);
	$Impuesto = abs($_POST["Impuesto"]);
	$Exento = abs($_POST["Exento"]);
	$SubTotal = abs($Exento + $Impuesto + $Imponible);
	$Total = abs($Exento + $Impuesto + $Imponible);
	$token = sha1($_POST['correo']);
	$IdEstacion = $_POST['IdEstacion'];
	$IdUser = $_POST['IdUser'];


	if ($Idtipotx == 1) {
		$ttx = "numboleta";
	}

	if ($Idtipotx == 2) {
		$ttx = "numfactura";
	}

	if ($Idtipotx == 15) {
		$ttx = "numnota";
	}

	if ($Idtipotx == 22) {
		$ttx = "numnec";
	}

	if ($Idtipotx == 7) {
		$ttx = "numcom";
	}

	if ($Idtipotx == 28) {
		$ttx = "numguiacompra";
	}

	$newIdtx = "";
	$query = "SELECT max(IdTxCompany)+1 as newIdtx from PosUpTxC where IdCompany = '" . $_POST["CompanyActual"] . "' and idtipotx='" . $Idtipotx . "'";
	if ($result = mysqli_query($conn, $query)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$newIdtx = $row['newIdtx'];
		}
		mysqli_free_result($result);
	}

	if (trim($newIdtx) === "") $newIdtx = 1;

	$conn->autocommit(FALSE);

	$query = "SELECT prefac," . $ttx . "+1 as Idtx FROM PosUpCompanyEstacion where token='" . $IdEstacion . "'";
	if ($result = mysqli_query($conn, $query)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$prefac = $row['prefac'];
			$Idtx = $row['Idtx'];
		}
		mysqli_free_result($result);
	}

	$statement = "insert into PosUpTxC (IdCompany, Idtipotx, Idtx, Fectxserver, Fectxclient,  IdUser, IdUserAutDcto, SubTotal, Dcto, Total, Costo, Margen, DctoAplicado, MargenDcto, Items, IdEstacion, Contado, Credito, Cobrado,IdCompanyUserAutDcto, IdCompanyUser,IdtipotxPadre, IdtxPadre, IdEstacionPadre,IdAlmO,IdAlmD,motivo,DAmpliado,IdBen,Referencia,excento,imponible,impuesto,totalimp,numctrol,TxfecVence,tasa,UserVendedor,IdTxCompany,TrackIdDTE,añolibro,meslibro) values ((SELECT Id FROM PosUpCompany where token='" . $token . "'),'" . $Idtipotx . "',(SELECT " . $ttx . "+1 FROM PosUpCompanyEstacion where token='" . $IdEstacion . "'),now(),'" . $Fectxclient . "','" . $IdUser . "','','" . $SubTotal . "','0','" . $Total . "','0','0','0','0','1','" . $IdEstacion . "','0','" . ($Total * $Tasa) . "','0','','" . $_POST["userCompany"] . "','0','0','0','" . $_POST['IdAlm'] . "','" . $_POST['IdAlm'] . "','','" . $DAmpliado . "','" . $IdBen . "','" . $Referencia . "','" . $Exento . "','" . $Imponible . "','" . $Impuesto . "','" . ($Imponible + $Impuesto) . "','" . $control . "','" . $TxfecVence . "','" . $Tasa . "','0','" . $newIdtx . "','" . $numz . "', '" . $_POST["ano"] . "', '" . $_POST["mes"] . "')";
	$statamen1 = $statement;
	$resultado1 =  mysqli_query($conn, $statement);

	$statement = "insert into PosUpTxP (IdCompany, Idtipotx, Idtx, IdEstacion, Item, Fectxserver, Fectxclient, MontoPagar, Contado, Credito, Efectivo,Vuelto, Tarjeta, TarjetaD, Cheque, ChequeD, Tipo01, Tipo01D, Tipo02, Tipo02D, Tipo03, Tipo03D, Tipo04, Tipo04D,Login, IdcompanyUser, IdResponsable,Caja,TxfecVence,TarjetaB,ChequeB,Tipo01B,Tipo02B,Tipo03B,Tipo04B,tasa) values ";
	$statement = $statement . "((SELECT Id FROM PosUpCompany where token='" . $token . "'),'" . $Idtipotx . "',(SELECT " . $ttx . "+1 FROM PosUpCompanyEstacion where token='" . $IdEstacion . "'),'" . $IdEstacion . "','1',now(),'" . $Fectxclient . "','" . $Total . "','0','" . ($Total * $Tasa) . "','0','" . $Vuelto . "','0','','0','','0','','0','','0','','0','','" . $IdUser . "','" . $_POST["userCompany"] . "','" . $IdBen . "',(SELECT CajaActual FROM PosUpCompanyEstacion where token='" . $IdEstacion . "'),'" . $TxfecVence . "','0','0','0','0','0','0','" . $Tasa . "')";
	$statamen4 = $statamen4 . " " . $statement;
	$resultado4 =  mysqli_query($conn, $statement);

	$statement = "update PosUpCompanyEstacion set " . $ttx . "=" . $ttx . "+1 where token='" . $IdEstacion . "'";
	$resultado2 = mysqli_query($conn, $statement);
	$statamen2 = $statement;

	if ($resultado1 and $resultado4 and $resultado2) {
		$conn->commit();
		echo $Idtx;
	} else {
		$conn->rollback();
		echo "0";
	}
	$errorrun = false;
}

if ($_POST["Accion"] === "EliminarTx") {
	include "ambiente.php";
	$conn = conectar();

	echo EliminarTx($conn, $_POST);
}



?>