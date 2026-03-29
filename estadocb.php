<?php

if ($_SESSION["IdPais"] === "VE") {

	$n = 0;
	$query = "SELECT * FROM posupretencion WHERE IdCompany=" . $_SESSION['CompanyActual'] . "";
	if ($result = mysqli_query($conn, $query)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$n++;
		}
	}

	if ($n === 0) {
		$sql = "
			INSERT INTO posup.posupretencion (IdCompany,TipoRet,BaseLegal,NumLit,PNREBI,PNRETAR,PNREPM,PNRESUST,PNRECOD,PNNRBI,PNNRTAR,PNNRBIPA,PNNRSUS,PNNRCOD,PJDOMBI,PJDOMTAR,PJDOMPA,PJDOMCOD,PJNDOMBI,PJNDOMTAR,PJNDOMPA,PJNDOMCOD,Nombre) VALUES
				(" . $_SESSION['CompanyActual'] . ",1,'Dec. 1.808','9.1.a',0.0,0.0,0.0,0.0,'',0.9,0.34,0.0,0.0,'',0.9,0.0,0.0,'',0.0,0.0,0.0,NULL,'HONORARIOS PROFESIONALES'),
				(" . $_SESSION['CompanyActual'] . ",1,'Dec. 1.808','9.1.b',1.0,0.03,1666668.0,50000.04,'',0.0,0.0,0.0,0.0,'',0.0,0.0,0.0,'',1.0,0.05,25.0,NULL,'HONORARIOS PROFESIONALES'),
				(" . $_SESSION['CompanyActual'] . ",1,'Dec. 1.808','9.1.c',1.0,0.03,1666668.0,50000.04,'',1.0,0.34,0.0,0.0,'',0.0,0.0,0.0,'',0.0,0.0,0.0,NULL,'PREPARADORES DE ANIMALES'),
				(" . $_SESSION['CompanyActual'] . ",1,'Dec. 1.808','9.1.d',1.0,0.03,1666668.0,50000.04,'',1.0,0.34,0.0,0.0,'',0.0,0.0,0.0,'',0.0,0.0,0.0,NULL,'HONORARIOS PROFESIONALES EN CLINICAS'),
				(" . $_SESSION['CompanyActual'] . ",1,'Dec. 1.808','9.10',1.0,0.03,1666668.0,50000.04,'',1.0,0.34,0.0,0.0,'',1.0,0.05,0.0,'',1.0,0.05,25.0,NULL,'PREMIOS DE ANIMALES DE CARRERA'),
				(" . $_SESSION['CompanyActual'] . ",1,'Dec. 1.808','9.11',1.0,0.01,1666668.0,16666.68,'',1.0,0.34,0.0,0.0,'',1.0,0.0,0.0,'',1.0,0.02,0.0,NULL,'SERVICIOS '),
				(" . $_SESSION['CompanyActual'] . ",1,'Dec. 1.808','9.12',1.0,0.03,1666668.0,50000.04,'',1.0,0.34,0.0,0.0,'',1.0,0.0,0.0,'',1.0,0.05,25.0,NULL,'ARRENDAMIENTO BIENES INMUEBLES'),
				(" . $_SESSION['CompanyActual'] . ",1,'Dec. 1.808','9.13',1.0,0.03,1666668.0,50000.04,'',1.0,0.34,0.0,0.0,'',1.0,0.05,0.0,'',1.0,0.05,25.0,NULL,'ARRENDAMIENTO BIENES MUEBLES '),
				(" . $_SESSION['CompanyActual'] . ",1,'Dec. 1.808','9.14.1',1.0,0.03,0.0,0.0,'',1.0,0.34,0.0,0.0,'',1.0,0.05,0.0,'',1.0,0.05,0.0,NULL,'PAGOS DE TARJETAS DE CREDITO'),
				(" . $_SESSION['CompanyActual'] . ",1,'Dec. 1.808','9.14.2',1.0,0.01,0.0,0.0,'',0.0,0.0,0.0,0.0,'',0.0,0.0,0.0,'',1.0,0.01,0.0,NULL,'VENTA DE GASOLINA CON T. DE CREDITO'),
				(" . $_SESSION['CompanyActual'] . ",1,'Dec. 1.808','9.15',1.0,0.01,1666668.0,16666.68,'',0.0,0.0,0.0,0.0,'',0.0,0.0,0.0,'',1.0,0.03,25.0,NULL,'FLETES GTOS. DE TRANSP. NACIONAL'),
				(" . $_SESSION['CompanyActual'] . ",1,'Dec. 1.808','9.16',1.0,0.03,1666668.0,50000.04,'',0.0,0.0,0.0,0.0,'',0.0,0.0,0.0,'',1.0,0.05,25.0,NULL,'PAGOS DE EMPRESAS DE SEGURO'),
				(" . $_SESSION['CompanyActual'] . ",1,'Dec. 1.808','9.17',1.0,0.03,1666668.0,50000.04,'',0.0,0.0,0.0,0.0,'',0.0,0.0,0.0,'',1.0,0.05,25.0,NULL,'PAGOS DE EMPRESAS DE SEGURO'),
				(" . $_SESSION['CompanyActual'] . ",1,'Dec. 1.808','9.18',1.0,0.03,1666668.0,50000.04,'',1.0,0.34,0.0,0.0,'',1.0,0.05,0.0,'',1.0,0.05,25.0,NULL,'VENTA DE FONDOS DE COMERCIO'),
				(" . $_SESSION['CompanyActual'] . ",1,'Dec. 1.808','9.19.1',1.0,0.03,1666668.0,50000.04,'',0.0,0.0,0.0,NULL,'',1.0,0.05,0.0,'',1.0,0.05,25.0,NULL,'PUBLICIDAD Y PROPAGANDA'),
				(" . $_SESSION['CompanyActual'] . ",1,'Dec. 1.808','9.19.2',0.0,0.0,0.0,0.0,'',0.0,0.0,0.0,0.0,'',0.0,0.0,0.0,'',1.0,0.03,25.0,NULL,'PUBLICIDAD Y PROPAGANDA RADIO'),
				(" . $_SESSION['CompanyActual'] . ",1,'Dec. 1.808','9.2.a',1.0,0.03,1666668.0,50000.04,'',1.0,0.34,0.0,0.0,'',1.0,0.05,0.0,'',1.0,0.05,25.0,NULL,'COMISIONES ENAJENACION INMUEBLES'),
				(" . $_SESSION['CompanyActual'] . ",1,'Dec. 1.808','9.2.b',1.0,0.03,1666668.0,50000.04,'',1.0,0.34,0.0,0.0,'',1.0,0.05,0.0,'',1.0,0.05,25.0,NULL,'COMISIONES MERCANTILES'),
				(" . $_SESSION['CompanyActual'] . ",1,'Dec. 1.808','9.20',1.0,0.01,0.0,0.0,'',1.0,0.01,0.0,0.0,'',1.0,0.01,0.0,'',1.0,0.01,0.0,NULL,'VENTA DE ACCIONES EN BOLSA'),
				(" . $_SESSION['CompanyActual'] . ",1,'Dec. 1.808','9.21',1.0,0.03,1666668.0,50000.04,'',1.0,0.34,0.0,0.0,'',1.0,0.05,0.0,'',1.0,0.05,25.0,NULL,'VENTA DE ACCIONES FUERA DE BOLSA'),
				(" . $_SESSION['CompanyActual'] . ",1,'Dec. 1.808','9.3.A',0.0,0.0,0.0,0.0,'',0.95,0.34,0.0,0.0,'',0.95,0.0,0.0,'',0.0,0.0,0.0,NULL,'INTERESES ART N° 27 #2 L.I.S.R'),
				(" . $_SESSION['CompanyActual'] . ",1,'Dec. 1.808','9.3.b',0.0,0.0,0.0,0.0,'',0.0,0.0,0.0,0.0,'',1.0,0.0495,0.0,'',0.0,0.0,0.0,NULL,'INTERESES ART N° 53 PAR 1°'),
				(" . $_SESSION['CompanyActual'] . ",1,'Dec. 1.808','9.3.c',1.0,0.03,1666668.0,50000.04,'',1.0,0.34,0.0,0.0,'',1.0,0.0,0.0,'',1.0,0.05,25.0,NULL,'INTERESES'),
				(" . $_SESSION['CompanyActual'] . ",1,'Dec. 1.808','9.4',0.0,0.0,0.0,0.0,'',0.0,0.0,0.0,0.0,'',0.15,0.0,0.0,'',0.0,0.0,0.0,NULL,'AGENCIAS DE NOTICIAS INTERNACIONAL'),
				(" . $_SESSION['CompanyActual'] . ",1,'Dec. 1.808','9.5',0.0,0.0,0.0,0.0,'',0.0,0.0,0.0,0.0,'',0.1,0.0,0.0,'',0.0,0.0,0.0,NULL,'FLETES Y GTOS. DE TRANSP. INTERNAC'),
				(" . $_SESSION['CompanyActual'] . ",1,'Dec. 1.808','9.6',0.0,0.0,0.0,0.0,'',0.25,0.34,0.0,0.0,'',0.25,0.0,0.0,'',0.0,0.0,0.0,NULL,'EXHIBICION PELICULAS ART 27 # 15'),
				(" . $_SESSION['CompanyActual'] . ",1,'Dec. 1.808','9.7.1',0.0,0.0,0.0,0.0,'',0.9,0.34,0.0,0.0,'',0.9,0.0,0.0,'',0.0,0.0,0.0,NULL,'REGALIAS ART 27 # 16'),
				(" . $_SESSION['CompanyActual'] . ",1,'Dec. 1.808','9.7.2',0.0,0.0,0.0,0.0,'',0.3,0.34,0.0,0.0,'',0.3,0.0,0.0,'',0.0,0.0,0.0,NULL,'ASISTENCIA TECNICA ART 27 # 16'),
				(" . $_SESSION['CompanyActual'] . ",1,'Dec. 1.808','9.7.3',0.0,0.0,0.0,0.0,'',0.5,0.34,0.0,0.0,'',0.5,0.0,0.0,'',0.0,0.0,0.0,NULL,'SERVICIOS TECNOLÓGICOS ART 27 # 16'),
				(" . $_SESSION['CompanyActual'] . ",1,'Dec. 1.808','9.8',0.0,0.0,0.0,0.0,'',0.0,0.0,0.0,0.0,'',0.3,0.1,0.0,'',0.0,0.0,0.0,NULL,'PRIMAS DE SEGURO ART 27 # 18'),
				(" . $_SESSION['CompanyActual'] . ",1,'Dec. 1.808','9.9.1',1.0,0.34,0.0,0.0,'',1.0,0.34,0.0,0.0,'',1.0,0.34,0.0,'',1.0,0.34,0.0,NULL,'GANANCIAS / PREMIOS Y APUESTAS'),
				(" . $_SESSION['CompanyActual'] . ",1,'Dec. 1.808','9.9.2',1.0,0.16,0.0,0.0,'',1.0,0.16,0.0,0.0,'',1.0,0.16,0.0,'',1.0,0.16,0.0,NULL,'PREMIOS LOT. E HIP. ART 55 Y 56');
		";
		mysqli_query($conn, $sql);
	}
}

$BenePreter = "";

if (isset($_SESSION["idben"])) $BenePreter = $_SESSION["idben"];

// $_SESSION["idben"] = "";
$GenTxFactorDCambio = "";
$FactorCambio = [];
$query = "SELECT FactorDolarCash,FactorDolarPaypal,FactorDolarZelle,Moneda3,Moneda4,MonedaP,MonedaS,Moneda5,Moneda6,Moneda7,FactorDolar5,FactorDolar6,FactorDolar7,LitPrincipalEfectivo FROM PosUpCompany WHERE Id=" . $_SESSION['CompanyActual'] . "";
if ($result = mysqli_query($conn, $query)) {
	while ($row = mysqli_fetch_assoc($result)) {
		$FactorDolarCash = $row['FactorDolarCash'];
		$GenTxFactorDCambio .= "<option value='" . $row['FactorDolarCash'] . "' >" . ($row["LitPrincipalEfectivo"] === "" ? (trim($row['MonedaS']) === "" ? $row['MonedaP'] : $row['MonedaS']) : $row["LitPrincipalEfectivo"])  . " (" . $row['FactorDolarCash'] . ")</option>";
		if ($row['FactorDolarPaypal'] > 1) $GenTxFactorDCambio .= "<option value='" . $row['FactorDolarPaypal'] . "'>" . $row['Moneda3'] . "</option>";
		if ($row['FactorDolarZelle'] > 1) $GenTxFactorDCambio .= "<option value='" . $row['FactorDolarZelle'] . "'>" . $row['Moneda4'] . "</option>";
		if ($row['FactorDolar5'] > 1) $GenTxFactorDCambio .= "<option value='" . $row['FactorDolar5'] . "'>" . $row['Moneda5'] . "</option>";
		if ($row['FactorDolar6'] > 1) $GenTxFactorDCambio .= "<option value='" . $row['FactorDolar6'] . "'>" . $row['Moneda6'] . "</option>";
		if ($row['FactorDolar7'] > 1) $GenTxFactorDCambio .= "<option value='" . $row['FactorDolar7'] . "'>" . $row['Moneda7'] . "</option>";
		$GenTxFactorDCambio .= "<option value='-1'>" . lang("Libre") . "</option>";
		$FactorCambio = [
			"FactorDolarCash" => $row["FactorDolarCash"],
			"FactorDolarPaypal" => $row["FactorDolarPaypal"],
			"FactorDolarZelle" => $row["FactorDolarZelle"],
			"FactorDolar5" => $row["FactorDolar5"],
			"FactorDolar6" => $row["FactorDolar6"],
			"FactorDolar7" => $row["FactorDolar7"],
			"MonedaP" => $row["MonedaP"],
			"MonedaS" => ($row["LitPrincipalEfectivo"] === "" ? $row['MonedaS'] : $row["LitPrincipalEfectivo"]),
			"Moneda3" => $row["Moneda3"],
			"Moneda4" => $row["Moneda4"],
			"Moneda5" => $row["Moneda5"],
			"Moneda6" => $row["Moneda6"],
			"Moneda7" => $row["Moneda7"],
		];
		$Moendas[] = [
			"id" => 1,
			"name" => $row["MonedaP"],
			"value" => 1,
		];

		$Moendas[] = [
			"id" => 2,
			"name" => $row["MonedaS"],
			"value" => $row["FactorDolarCash"],
		];

		$Moendas[] = [
			"id" => 3,
			"name" => $row["Moneda3"],
			"value" => $row["FactorDolarPaypal"],
		];

		$Moendas[] = [
			"id" => 4,
			"name" => $row["Moneda4"],
			"value" => $row["FactorDolarZelle"],
		];

		$Moendas[] = [
			"id" => 5,
			"name" => $row["Moneda5"],
			"value" => $row["FactorDolar5"],
		];

		$Moendas[] = [
			"id" => 6,
			"name" => $row["Moneda6"],
			"value" => $row["FactorDolar6"],
		];

		$Moendas[] = [
			"id" => 7,
			"name" => $row["Moneda7"],
			"value" => $row["FactorDolar7"],
		];
	}
	mysqli_free_result($result);
}


$Item3 = "";
$sql = "select IdVarios,ITEM from PosUpvarios where IdCompany = '" . $_SESSION["CompanyActual"] . "' and TIPOITEM = 3 order by ITEM ASC";
if ($query = mysqli_query($conn, $sql)) {
	while ($row = mysqli_fetch_array($query)) {
		$Item3 .= "<option value='" . $row['ITEM'] . "'>" . $row['ITEM'] . "</option>";
	}
}
$ModalDeposito22 = "";
$query = "SELECT a.IdAlm,a.Nombre FROM PosUpAlmacen a WHERE a.IdCompany=" . $_SESSION['CompanyActual'] . "";
if ($result = mysqli_query($conn, $query)) {
	while ($row = mysqli_fetch_assoc($result)) {
		$ModalDeposito22 .= "<option value='" . $row['IdAlm'] . "'>" . $row['Nombre'] . "</option>";
	}
	mysqli_free_result($result);
}
$AutorizaIntCaja = "0";
$verTx = "0";
$query = "SELECT AutorizaIntCaja,verTx from PosUpUsers a where a.IdCompany='" . $_SESSION["userCompany"] . "' and a.login='" . $_SESSION["userlogin"] . "'";
if ($result = mysqli_query($conn, $query)) {
	while ($row = mysqli_fetch_assoc($result)) {
		$AutorizaIntCaja = $row["AutorizaIntCaja"];
		$verTx = $row["verTx"];
	}
}

$CajaAct = "";
$RowCaja = "";
$RowCaja2 = "";
$showCaja = lang("Seleccione Caja");
$dataCaja = [];
if ($_SESSION["IdAtt"] !== "0") {
	$buscar .= " and b.IdAtt = " . $_SESSION["IdAtt"];
}
$n = 0;
$PosUpRetencionOptionSelect = "";
$PosUpRetencionOptionSpan = "";
$query = "SELECT * FROM PosUpRetencion WHERE TipoRet = 1 and IdCompany=" . $_SESSION["CompanyActual"] . "";
if ($result = mysqli_query($conn, $query)) {
	while ($row = mysqli_fetch_assoc($result)) {
		$n = $n + 1;
		$PosUpRetencionOptionSelect .= '<option value="' . trim($n) . '">' . trim($row['Nombre']) . '</option>';
		$PosUpRetencionOptionSpan .= '
		<span style="display:none;" id="BaseLegal' . $n . '">' . $row["BaseLegal"] . '</span>
		<span style="display:none;" id="NumLit' . $n . '">' . $row["NumLit"] . '</span>
		<span style="display:none;" id="PNREBI' . $n . '">' . $row["PNREBI"] . '</span>
		<span style="display:none;" id="PNRETAR' . $n . '">' . $row["PNRETAR"] . '</span>
		<span style="display:none;" id="PNREPM' . $n . '">' . $row["PNREPM"] . '</span>
		<span style="display:none;" id="PNRESUST' . $n . '">' . $row["PNRESUST"] . '</span>
		<span style="display:none;" id="PNRECOD' . $n . '">' . $row["PNRECOD"] . '</span>
		<span style="display:none;" id="PNNRBI' . $n . '">' . $row["PNNRBI"] . '</span>
		<span style="display:none;" id="PNNRTAR' . $n . '">' . $row["PNNRTAR"] . '</span>
		<span style="display:none;" id="PNNRBIPA' . $n . '">' . $row["PNNRBIPA"] . '</span>
		<span style="display:none;" id="PNNRSUS' . $n . '">' . $row["PNNRSUS"] . '</span>
		<span style="display:none;" id="PNNRCOD' . $n . '">' . $row["PNNRCOD"] . '</span>
		<span style="display:none;" id="PJDOMBI' . $n . '">' . $row["PJDOMBI"] . '</span>
		<span style="display:none;" id="PJDOMTAR' . $n . '">' . $row["PJDOMTAR"] . '</span>
		<span style="display:none;" id="PJDOMPA' . $n . '">' . $row["PJDOMPA"] . '</span>
		<span style="display:none;" id="PJDOMCOD' . $n . '">' . $row["PJDOMCOD"] . '</span>
		<span style="display:none;" id="PJNDOMBI' . $n . '">' . $row["PJNDOMBI"] . '</span>
		<span style="display:none;" id="PJNDOMTAR' . $n . '">' . $row["PJNDOMTAR"] . '</span>
		<span style="display:none;" id="PJNDOMPA' . $n . '">' . $row["PJNDOMPA"] . '</span>
		<span style="display:none;" id="PJNDOMCOD' . $n . '">' . $row["PJNDOMCOD"] . '</span>
		<span style="display:none;" id="Nombre' . $n . '">' . $row["Nombre"] . '</span>
		<span style="display:none;" id="Id' . $n . '">' . $row["Id"] . '</span>
		';
	}
	mysqli_free_result($result);
}

$query = "SELECT a.token,a.etiqueta,a.CajaActual 
FROM PosUpCompanyEstacion a 
left join posupalmacen b on b.IdCompany = a.IdCompany and b.IdAlm = a.IdAlmVta
where a.transdecaja = 1 and a.IdCompany = " . $_SESSION["CompanyActual"] . " " . $buscar . "
ORDER BY a.etiqueta ASC";
if ($result = mysqli_query($conn, $query)) {
	while ($row = mysqli_fetch_assoc($result)) {
		$dataCaja[] = [
			"token" => $row["token"],
			"etiqueta" => $row["etiqueta"],
			"CajaActual" => $row["CajaActual"],
		];
		$icon = "";

		if (explode(",", $_SESSION["PerfilVentas"])[11] === "E") {
			$icon = '<i class="fa fa-laptop" aria-hidden="true"></i>';
		} else if (explode(",", $_SESSION["PerfilVentas"])[11] === "U") {
			$icon = '<i class="fa fa-user" aria-hidden="true"></i>';
		} else if (explode(",", $_SESSION["PerfilVentas"])[11] === "C") {
			$icon = '<i class="fa fa-building" aria-hidden="true"></i>';
		}


		$RowCaja .= "<option value='" . $row["token"] . "' " . ($row["token"] === $_SESSION["TokenSeleccionado"] ? "selected" : "") . ">" . "(" . explode(",", $_SESSION["PerfilVentas"])[11] . ") " . $row["etiqueta"] . ($row["CajaActual"] === "0" ? " CERRADO" : "  No. " . $row["CajaActual"]) . "</option>";
		$RowCaja2 .= '
        <li class="bg-light text-dark" onclick="CambioUsoToken(`' . $row["token"] . '`)" style="cursor: pointer;">
            <a class="dropdown-item bg-light text-dark"  data-value="' . $row["token"] . '">
				' . $icon . ' ' . $row["etiqueta"] . ($row["CajaActual"] === "0" ? '<span class="badge bg-danger ms-2">' . lang("Cerrado") . '</span>' : '<span class="badge bg-success ms-2">' . lang("Abierto") . ' No. ' . $row["CajaActual"] . '</span>') . '
            </a>
        </li>
		';
		if ($row["token"] === $_SESSION["TokenSeleccionado"]) {
			$showCaja =  $icon . ' '  . $row["etiqueta"] . ($row["CajaActual"] === "0" ? '<span class="badge bg-danger ms-2">' . lang("Cerrado") . '</span>' : '<span class="badge bg-success ms-2">' . lang("Abierto") . ' No. ' . $row["CajaActual"] . '</span>') . '';
		}
	}
}

if ($AutorizaIntCaja === "1") {
	$CajaAct = "
		<select class='d-none' id='tokeninUse' >
			" . $RowCaja . "
		</select>
	" .
		'<div class="dropdown">
			<button class="btn btn-light text-dark p-1 dropdown-toggle" type="button" id="MenuTokenCambiar" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 0.75rem !important;">
				' . $showCaja . '
			</button>
			<ul class="dropdown-menu dropdown-scrollable bg-light text-dark" aria-labelledby="MenuTokenCambiar">
			' . $RowCaja2 . '
			</ul>
		</div>
	';
} else {
	$CajaAct = "(" . explode(",", $_SESSION["PerfilVentas"])[11] . ") " . $_SESSION["CajaNombre"] . " No." . $_SESSION["CajaActual"] . " <input value='" . $_SESSION["TokenSeleccionado"] . "' type='hidden' id='tokeninUse' />";
}


?>
<style>
	.table tbody tr:nth-of-type(odd) {
		background-color: #f9f9f9;
	}

	.table tbody tr:nth-of-type(even) {
		background-color: #e9ecef;
	}

	.table th,
	.table td {
		text-align: right;
	}

	.table th:first-child,
	.table td:first-child {
		text-align: left;
	}
</style>

<header id="header" class="d-print-none">
	<div class="container">
		<div class="row">
			<div class="col-12 col-lg-5 p-3 shadow-sm rounded">
				<h2 class="mb-3">
					<div class="d-flex align-items-center">
						<!-- Using Font Awesome financial icon for the account -->
						<i class="fa fa-credit-card fs-4 me-2"></i>
						<span>Estado de Cuenta del Beneficiario </span>
					</div>
					<div>
						<small class="fs-6 text-muted">
							<?php echo $CajaAct; ?>

						</small>
					</div>
				</h2>
			</div>
			<div class="col-12 col-lg-7 p-1">
				<div class="row" id="headerprintxd2"></div>
			</div>
		</div>
	</div>
</header>

<nav aria-label="breadcrumb">
	<div class="container">
		<ol class="breadcrumb">
			<li class="breadcrumb-item "><a href="app.php?opcion=cajamenu.php"><?php echo lang("Caja"); ?></a></li>
			<li class="breadcrumb-item active"><?php echo lang("Estado de Cuenta del Beneficiario"); ?></li>
		</ol>
	</div>
</nav>

<div class="container" id="contenedortotal">
	<div class='col-12 d-print-none'>
		<div class="row">
			<span id="backreporte3"></span>
			<span id="backreporte2"></span>
			<span id="backreporte2AB" style="display:none;">
				<table class='table ' style='font-size: 13px;'>
					<thead class='table-light'>
						<tr>
							<th class='text-start'><?php echo lang("Caja") . " / " . lang("Usuario"); ?></th>
							<th class='text-start'><?php echo lang("Documento"); ?></th>
							<th class='text-center'></th>
							<th class='text-center'><?php echo lang("Fecha"); ?></th>
							<th class='text-end'><?php echo lang("Monto") . " (" . $_SESSION["MonedaP"] . ")"; ?></th>
							<th class='text-end'><?php echo lang("Débito") . " (" . $_SESSION["MonedaP"] . ") "; ?></th>
							<th class='text-end'><?php echo lang("Crédito") . " (" . $_SESSION["MonedaP"] . ")"; ?></th>
							<th class='text-end'><?php echo lang("Saldo") . " (" . $_SESSION["MonedaP"] . ")"; ?></th>
							<th class='text-center'><?php echo lang("Acción"); ?></th>
						</tr>
					</thead>
					<tbody id="backreporte2A">
					</tbody>
				</table>
			</span>
			<div id="PaginationFormCB"></div>

			<input type="hidden" name="Modalrut" id="Modalrut" />
			<input type="hidden" name="Fectxclient" id="Fectxclient" />
			<input type="hidden" name="Modalnombre" id="Modalnombre" />
		</div>
	</div>
</div>

<div style="color:white;"></br>.</br>.</br>.</div>

<div class="offcanvas offcanvas-end" id="demo" tabindex="-1" style="z-index:9999;">
	<div class="offcanvas-header">
		<div>
			<h1 class="offcanvas-title">
				<?php echo lang("Filtros"); ?>
			</h1>
			<span class="float-start"> <?php echo $Titulo; ?></span>
		</div>
		<div>
			<button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
		</div>
	</div>
	<div class="offcanvas-body">
		<div class="row gap-2">
			<div class="col-12 my-1">
				<label class='d-flex gap-2 align-items-center'>
					<i class="fa fa-sort"></i>
					<?php echo lang('Orden'); ?>
				</label>
				<select class="form-select" id="OrderBy" onchange="ActTable();">
					<option value="Fectxclient"><?php echo lang("Fecha"); ?></option>
				</select>
			</div>
			<div class="col-12 my-1">
				<label class='d-flex gap-2 align-items-center'>
					<i class="fa fa-sort"></i>
					<?php echo lang('Orientación'); ?>
				</label>
				<select class="form-select" id="SortBy" onchange="ActTable();">
					<option value="ASC" selected><?php echo lang("Ascendente"); ?></option>
					<option value="DESC"><?php echo lang("Descendente"); ?></option>
				</select>
			</div>

			<div id="CheckCK">
				<div class="form-check gap-2">
					<input class="form-check-input" type="checkbox" id="MostrarTodos" name="MostrarTodos" onchange="ActTable();">
					<label class="form-check-label" for="MostrarTodos">
						<?php echo lang('Mostrar Documentos Cancelados'); ?>
					</label>
				</div>
			</div>
			<div class='col-12 mt-1'>
				<label class='d-flex gap-2 align-items-center'>
					<i class="fa fa-bars"></i>
					<?php echo lang('Rango'); ?>
				</label>
				<select class='form-select' name='SelectorDiaMes' id='SelectorDiaMes' onchange='Selectorangodel();'>
					<option value='1'><?php echo lang("Del Día"); ?></option>
					<option value='2'><?php echo lang("Del Día Anterior"); ?></option>
					<option value='3'><?php echo lang("Del Mes"); ?></option>
					<option value='4'><?php echo lang("Del Mes Anterior"); ?></option>
					<option value='5'><?php echo lang("Por Rango"); ?></option>
				</select>
			</div>
			<div class='col-12 mt-1'>
				<label class='d-flex gap-2 align-items-center'>
					<i class="fa fa-calendar"></i>
					<?php echo lang('Desde'); ?>
				</label>
				<input class='form-control' type='DATETIME-LOCAL' name='ModaldesdeA' id='ModaldesdeA' onchange='ActTable();' disabled />
			</div>

			<div class='col-12 mt-1'>
				<label class='d-flex gap-2 align-items-center'>
					<i class="fa fa-calendar"></i>
					<?php echo lang('Hasta'); ?>
				</label>
				<input class='form-control' type='DATETIME-LOCAL' name='ModalhastaA' id='ModalhastaA' onchange='ActTable();' disabled />
			</div>
		</div>
		<div class="row" style="font-size: 15px;">
			<button type="button" class="btn fs-2" data-bs-dismiss="offcanvas">
				<?php echo lang("Ocultar"); ?> <i class="fa fa-arrow-right"></i>
			</button>
		</div>
	</div>
</div>
<div class="modal fade" id="modalRetISLR" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Retención ISLR</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-0">
        <div id="frameRetISLR"></div>
      </div>
    </div>
  </div>
</div>
<div class="modal" id="apps-modal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header bg-success text-light">
				<h5 class="modal-title">
					<i class="fa fa-search"></i>
					<?php echo lang("Transacciones"); ?>
				</h5>
				<button data-bs-dismiss="modal" class="btn-close" type="button"></button>
			</div>
			<div class="modal-body">
				<div class="row" id="Encabezado">
					<input type="hidden" name="ModalDesded" id="ModalDesded">
					<input type="hidden" name="ModalHastah" id="ModalHastah">
					<input type="hidden" name="fectx" id="fectx">
					<div class="col-12 col-lg-4 p-1">
						<div class="col">
							<div class="form-floating">
								<select class="form-select" name="Modaltipotrans" id="Modaltipotrans" onchange="Enviar()">
									<option value="*"><?php echo lang("Todos"); ?></option>
									<?php
									$query = "SELECT Idtipotx,Titulo FROM PosUpTx WHERE caja <> 0 order by Titulo asc";
									if ($result = mysqli_query($conn, $query)) {
										while ($row = mysqli_fetch_assoc($result)) {
									?>
											<option value="<?php echo trim($row['Idtipotx']); ?>"><?php echo trim($row['Titulo']); ?></option>
									<?
										}
										mysqli_free_result($result);
									}
									?>
								</select>
								<label><?php echo lang("Tipo de transaccion"); ?></label>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-4 p-1">
						<div class="col">
							<div class="form-floating">
								<input class="form-control" type="text" name="Modalnroid" id="Modalnroid" onchange="Enviar()">
								<label><?php echo lang("Numero Id"); ?></label>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-4 p-1">
						<div class="col">
							<div class="form-floating">
								<select class="form-select" name="Modalmodalidad" id="Modalmodalidad" onchange="Enviar()">
									<option value="0"><?php echo lang("Todas"); ?></option>
									<option value="1"><?php echo lang("Contado"); ?></option>
									<option value="2"><?php echo lang("Crédito"); ?></option>
								</select>
								<label><?php echo lang("Modalidad"); ?></label>
							</div>
						</div>
					</div>
					<div class="col-6 p-1">
						<div class="col">
							<div class="form-floating">
								<input class="form-control" type="DATETIME-LOCAL" name="Modaldesde" id="Modaldesde" onchange="x(1); Enviar();" onfocus="x(1)" />
								<label><?php echo lang("Desde"); ?></label>
							</div>
						</div>
					</div>
					<div class="col-6 p-1">
						<div class="col">
							<div class="form-floating">
								<input class="form-control" type="DATETIME-LOCAL" name="Modalhasta" id="Modalhasta" onchange="x(2); Enviar();" onfocus="x(2)" />
								<label><?php echo lang("Hasta"); ?></label>
							</div>
						</div>
					</div>

				</div>
				<div class="table-responsive" id="DatatablesFD"></div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang("Cerrar"); ?></button>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="Beneficiario-Modal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header bg-info text-dark">
				<h5 class="modal-title">
					<i class="fa fa-user"></i> <?php echo lang("Buscar"); ?>
				</h5>
				<button data-bs-dismiss="modal" class="btn-close" type="button"></button>
			</div>
			<div class="modal-body">
				<div class="table-responsive" id="Beneficiario001"></div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="modal-a2" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header bg-danger text-light">
				<h5 class="modal-title"><i class="fa fa-trash"></i> <?php echo lang("Eliminar"); ?></h5>
				<button id="boton001" data-bs-dismiss="modal" class="btn-close" type="button"></button>
			</div>
			<div class="modal-body">
				<h4><?php echo lang("¿Desea eliminar el pago?"); ?></h4>
			</div>
			<span id='ItemActual' style='display:none;'></span>
			<div class="modal-footer">
				<button id="boton002" class="btn btn-outline-secondary px-1" type="button" data-bs-dismiss='modal'><i class="fa fa-times"></i> <?php echo lang("Cerrar"); ?></button>
				<button id="boton003" class="btn btn-outline-primary px-1" type="button" onclick="Procesar(4);"><i class="fa fa-arrow-right"></i> <?php echo lang("Avanzar"); ?></button>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="modalaxx" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header bg-danger text-light">
				<h5 class="modal-title"><i class="fa fa-trash"></i> <?php echo lang("Eliminar Transacción"); ?></h5>
				<button class="btn-close" type="button" data-bs-dismiss="modal"></button>
			</div>
			<div class="modal-body">
				<div class="row float-center text-center">
					<div class="col-12">
						<img src="img/warningtriangle.gif" style="width: 128px;">
					</div>
					<div class="col-12">
						<h3><strong><?php echo lang("¿Esta Seguro?"); ?></strong></h3>
					</div>
					<div class="col-12"><?php echo lang("Se va a eliminar") . " <strong id='desckk'></strong>" . ", " . lang("Esta acción no se puede deshacer."); ?></div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-outline-secondary px-1" type="button" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang("Cerrar"); ?></button>
				<button class="btn btn-outline-primary px-1" type="button" onclick="ProcessDelete();"><i class="fa fa-arrow-right"></i> <?php echo lang("Procesar"); ?></button>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="deletepago" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header bg-danger text-light">
				<h5 class="modal-title"><i class="fa fa-trash"></i> <?php echo lang("Eliminar Pago"); ?></h5>
				<button class="btn-close" type="button" data-bs-dismiss="modal"></button>
			</div>
			<div class="modal-body">
				<div class="row float-center text-center">
					<div class="col-12">
						<img src="img/warningtriangle.gif" style="width: 128px;">
					</div>
					<div class="col-12">
						<h3><strong><?php echo lang("¿Esta Seguro?"); ?></strong></h3>
					</div>
					<div class="col-12"><?php echo lang("Se va a eliminar") . " <strong id='elimPago'></strong>" . ", " . lang("Esta acción no se puede deshacer."); ?></div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-outline-secondary px-1" type="button" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang("Cerrar"); ?></button>
				<button class="btn btn-outline-primary px-1" type="button" onclick="ProcessPago();"><i class="fa fa-arrow-right"></i> <?php echo lang("Procesar"); ?></button>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="modal-a" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><img src="/img/dinero.png" width="32" height="32" /><?php echo lang("Utilizar el anticipo"); ?></h5>
				<button id="boton004" data-bs-dismiss="modal" class="btn-close" type="button"></button>
			</div>
			<div class="modal-body">
				<h4><?php echo lang("¿Desea utilizar el anticipo pago?"); ?></h4>
			</div>
			<div class="modal-footer">
				<button id="boton005" class="btn btn-outline-secondary px-1" type="button" data-bs-dismiss='modal' onclick="UtiAnt();"><i class="fa fa-times"></i> <?php echo lang("Cerrar"); ?></button>
				<button id="boton006" class="btn btn-outline-primary px-1" type="button" data-bs-dismiss='modal' onclick='MuestraProd3()'><i class="fa fa-arrow-right"></i> <?php echo lang("Avanzar"); ?></button>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="apps-modal2x" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><img src="/img/dinero.png" width="32" height="32" /> <?php echo lang("Retención Impuesto"); ?></h5>
				<button data-bs-dismiss="modal" class="btn-close" type="button"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-3 p-1">
						<div class="col">
							<div class="form-floating">
								<input type="text" name="CodigoActualizable" id="CodigoActualizable" class="form-control" onchange="GenerarCodigo();">
								<label><?php echo lang("N° de Retención"); ?></label>
							</div>
						</div>
					</div>
					<div class="col-3 p-1">
						<div class="col">
							<div class="form-floating">
								<input type="text" name="Totalenmonedauno" id="Totalenmonedauno" class="form-control text-end" readonly>
								<label><?php echo $_SESSION["MonedaP"]; ?></label>
							</div>
						</div>
					</div>
					<div class="col-3 p-1">
						<div class="col">
							<div class="form-floating">
								<input type="text" name="Totalenmonedados" id="Totalenmonedados" class="form-control text-end" readonly>
								<label><?php echo $_SESSION["MonedaP"]; ?></label>
							</div>
						</div>
					</div>
					<div class="col-3 p-1">
						<div class="col">
							<div class="form-floating">
								<input type="text" name="Totalenmonedatres" id="Totalenmonedatres" class="form-control text-end" readonly>
								<label><?php echo lang("Tasa"); ?></label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 p-1">
						<div class="col">
							<div class="form-floating">
								<input type="text" name="Totalenmonedacuatro" id="Totalenmonedacuatro" class="form-control text-end" readonly>
								<label><?php echo lang("El monto maximo para esta retención es de"); ?></label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-lg-4 p-1">
						<div class="col">
							<div class="form-floating">
								<select name="RetencionOfTable" id="RetencionOfTable" class="form-select" onchange="ColocarRetencion();">
									<option value="0"> - </option>
									<?php
									$query = "SELECT IdVarios,ITEM FROM PosUpvarios WHERE TIPOITEM=1003 and IdCompany=" . $_SESSION["CompanyActual"] . "";
									if ($result = mysqli_query($conn, $query)) {
										while ($row = mysqli_fetch_assoc($result)) {
									?>
											<option value="<?php echo $row['IdVarios']; ?>"><?php echo trim($row['ITEM']); ?></option>
									<?
										}
										mysqli_free_result($result);
									}
									?>
								</select>
								<?php
								$query = "SELECT IdVarios,ITEM,(VALOR) as Porcentaje FROM PosUpvarios WHERE TIPOITEM=1003 and IdCompany=" . $_SESSION["CompanyActual"] . "";
								if ($result = mysqli_query($conn, $query)) {
									while ($row = mysqli_fetch_assoc($result)) {
								?>
										<span style="display:none;" id="IdVarios<?php echo $row['IdVarios']; ?>"><?php echo $row["IdVarios"]; ?></span>
										<span style="display:none;" id="ITEM<?php echo $row['IdVarios']; ?>"><?php echo $row["ITEM"]; ?></span>
										<span style="display:none;" id="Porcentaje<?php echo $row['IdVarios']; ?>"><?php echo $row["Porcentaje"]; ?></span>
								<?
									}
									mysqli_free_result($result);
								}
								?>
								<label><?php echo lang("Tipo de Retencion"); ?></label>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-4 p-1">
						<div class="col">
							<div class="form-floating">
								<input type="text" name="MontoRetencion" id="MontoRetencion" class="form-control text-end" onkeypress="return OnlyNumbers001(event)" onchange="Totalizar(this)">
								<label><?php echo lang("Monto Retención"); ?></label>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-4 p-1">
						<div class="col">
							<div class="form-floating">
								<input type="text" name="PorceRetencion" id="PorceRetencion" class="form-control text-end" onkeypress="return OnlyNumbers001(event)" onchange="Totalizar(this)">
								<label><?php echo lang("Porcentaje Retención"); ?></label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-3 p-1">
						<div class="col">
							<div class="form-floating">
								<input type="text" name="BaseImponibleActualizable" id="BaseImponibleActualizable" class="form-control text-end" readonly>
								<label><?php echo lang("Total Base Imponible"); ?></label>
							</div>
						</div>
					</div>
					<div class="col-3 p-1">
						<div class="col">
							<div class="form-floating">
								<input type="text" name="SDCFActualizable" id="SDCFActualizable" class="form-control text-end" readonly>
								<label><?php echo lang("Total SDCF"); ?></label>
							</div>
						</div>
					</div>
					<div class="col-3 p-1">
						<div class="col">
							<div class="form-floating">
								<input type="text" name="TotalImpuestoActualizable" id="TotalImpuestoActualizable" class="form-control text-end" readonly>
								<label><?php echo lang("Total Impuesto"); ?></label>
							</div>
						</div>
					</div>
					<div class="col-3 p-1">
						<div class="col">
							<div class="form-floating">
								<input type="Date" name="FechaRetencion" id="FechaRetencion" class="form-control" onchange="GenerarCodigo();">
								<label><?php echo lang("Fecha de Comprobante"); ?></label>
							</div>
						</div>
					</div>
					<input type="hidden" name="RetenidoActual" id="RetenidoActual">
					<span id="errorretencion" style="color:red;"></span>
					<input type="hidden" name="codigodelimpuestopa" id="codigodelimpuestopa">
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-outline-secondary px-1" type="button" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang("Cerrar"); ?></button>
				<button class="btn btn-outline-primary px-1" type="button" onclick="proceso(2);"><i class="fa fa-arrow-right"></i> <?php echo lang("Avanzar"); ?></button>
			</div>
			<span id="ReTEMPcion" style="display:none;"></span>
		</div>
	</div>
</div>

<div class="modal" id="apps-modal2c" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-tilte"><?php echo lang("Retención I.S.R.L"); ?></h5>
				<button data-bs-dismiss="modal" class="btn-close" type="button"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12 p-1">
						<div class="col">
							<div class="form-floating">
								<select class="form-control" name="RetencionOfTable2" id="RetencionOfTable2" onchange="ColocarRetencion2();">
									<option value="0"> - </option>
									<?php
									echo $PosUpRetencionOptionSelect;
									?>
								</select>

								<label><?php echo lang("Tipo Retencion"); ?></label>
							</div>
						</div>
					</div>
				</div>
				<?php echo $PosUpRetencionOptionSpan; ?>
				<div class="row">
					<div class="col-6 p-1">
						<div class="col">
							<div class="form-floating">
								<input type="text" class="form-control" name="NumbaOfRetencion" id="NumbaOfRetencion" onchange="GenerarCodigo2(this.value);">
								<label><?php echo lang("Numero Retención"); ?></label>
							</div>
						</div>
					</div>
					<div class="col-6 p-1">
						<div class="col">
							<div class="form-floating">
								<input type="text" class="form-control" name="TotalofBaseImponible" id="TotalofBaseImponible" onkeypress="return OnlyNumbers001(event)" onchange="Totalizar2(this)">
								<label><?php echo lang("Base Imponible"); ?></label>
							</div>
						</div>
					</div>
					<div class="col-6 p-1">
						<div class="col">
							<div class="form-floating">
								<input type="Date" class="form-control" name="FechaRetencion2" id="FechaRetencion2">
								<label><?php echo lang("Fecha"); ?></label>
							</div>
						</div>
					</div>
					<div class="col-6 p-1">
						<div class="col">
							<div class="form-floating">
								<input type="text" class="form-control" name="TotalOfMenSDCF" id="TotalOfMenSDCF">
								<label><?php echo lang("S.D.C.F"); ?></label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-lg-4 p-1">
						<div class="col">
							<div class="form-floating">
								<input type="text" class="form-control" name="CodigoDlaRetencion" id="CodigoDlaRetencion">
								<label><?php echo lang("Codigo Retención"); ?></label>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-4 p-1">
						<div class="col">
							<div class="form-floating">
								<input type="text" class="form-control" name="CodigoLiteralRetencion" id="CodigoLiteralRetencion">
								<label><?php echo lang("Literal"); ?></label>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-4 p-1">
						<div class="col">
							<div class="form-floating">
								<input type="text" class="form-control" name="CodigodelseniatReten" id="CodigodelseniatReten">
								<label><?php echo lang("Codigo del Seniat"); ?></label>
							</div>
						</div>
					</div>
					<div class="col-6 p-1">
						<div class="col">
							<div class="form-floating">
								<input type="text" class="form-control" name="DescripcionDelServicio" id="DescripcionDelServicio">
								<label><?php echo lang("Descripción del Servicio"); ?></label>
							</div>
						</div>
					</div>
					<div class="col-6 p-1">
						<div class="col">
							<div class="form-floating">
								<input type="text" class="form-control" name="Descripcionnormalreten" id="Descripcionnormalreten">
								<label><?php echo lang("Descripción"); ?></label>
							</div>
						</div>
					</div>
					<div class="col-3 p-1">
						<div class="col">
							<div class="form-floating">
								<input type="text" class="form-control" name="Sustraendoinretencio" id="Sustraendoinretencio" onkeypress="return OnlyNumbers001(event)" onchange="Totalizar2(this)">
								<label><?php echo lang("Sustraendo"); ?></label>
							</div>
						</div>
					</div>
					<div class="col-3 p-1">
						<div class="col">
							<div class="form-floating">
								<input type="text" class="form-control" name="BaseOfImponibleReten" id="BaseOfImponibleReten" onkeypress="return OnlyNumbers001(event)" onchange="Totalizar2(this)">
								<label><?php echo lang("Base Imponible"); ?></label>
							</div>
						</div>
					</div>
					<div class="col-3 p-1">
						<div class="col">
							<div class="form-floating">
								<input type="text" class="form-control" name="PorcentaofRetencionPlz" id="PorcentaofRetencionPlz" onkeypress="return OnlyNumbers001(event)" onchange="Totalizar2(this)">
								<label><?php echo lang("% Retencion"); ?></label>
							</div>
						</div>
					</div>
					<div class="col-3 p-1">
						<div class="col">
							<div class="form-floating">
								<input type="text" class="form-control" name="MontoRetenidoporm" id="MontoRetenidoporm" onkeypress="return OnlyNumbers001(event)" onchange="Totalizar2(this)">
								<label><?php echo lang("Monto Retenido"); ?></label>
							</div>
						</div>
					</div>
				</div>
				<input type="hidden" name="RetenidoActual2" id="RetenidoActual2">
				<span id="errorretencion2" style="color:red;"></span>

			</div>
			<div class="modal-footer">
				<button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang("Cerrar"); ?></button>
				<button class="btn btn-outline-primary" type="button" onclick="proceso(3);"><i class="fa fa-arrow-right"></i> <?php echo lang("Avanzar"); ?></button>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="apps-modal2" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><span id="resultestadocb019"></span> <span id="resultestadocb020"></span></h5>
				<button data-bs-dismiss="modal" class="btn-close" type="button"></button>
			</div>
			<div class="modal-body">
				<div id="alertaerror"></div>
				<div class="row">
					<input type="hidden" name="fectx" id="fectx" value="">
					<div style="display: none;" id="htotal" name="htotal"></div>
					<div class="row" id="realmenteimporta">
						<div class="col-6 p-1">
							<div class="col">
								<div class="form-floating">
									<input type="text" class="form-control text-end" name="SaldoActual" id="SaldoActual" style="font-size:15px;" readonly>
									<label><?php echo lang("Saldo Actual"); ?> <span id="Logitodemoneda2"></span></label>
								</div>
							</div>
						</div>
						<div class="col-6 p-1">
							<div class="col">
								<div class="form-floating">
									<input type="text" class="form-control text-end" name="SaldoActual2" id="SaldoActual2" style="font-size:15px;" readonly>
									<label><?php echo lang("Saldo Actual"); ?> (<?php echo $_SESSION["MonedaP"]; ?>)</label>
								</div>
							</div>
						</div>
					</div>
					<div class="row" id="ModoAnticipo">
						<div class=" d-flex justify-content-center">
							<div class="btn-group">
								<input type="radio" class="btn-check" name="AnticipoTipo" id="VentaAnticipo" autocomplete="off" />
								<label class="btn btn-outline-primary" for="VentaAnticipo">Anticipo para Venta</label>

								<input type="radio" class="btn-check" name="AnticipoTipo" id="CompraAnticipo" autocomplete="off" checked />
								<label class="btn btn-outline-primary" for="CompraAnticipo">Anticipo para Compra</label>

							</div>
						</div>

					</div>
					<div class="row">
						<div class="col-12 p-1">
							<div class="col">
								<div class="form-floating">
									<textarea class="form-control" id="ModalEA" name="ModalEA" rows="4"></textarea>
									<label><?php echo lang("Explicación Ampliado"); ?></label>
								</div>
							</div>
						</div>
						<div class="col-12 col-lg-4 p-1">
							<div class="col">
								<div class="form-floating">
									<input class="form-control" type="date" id="ModalFecha" name="ModalFecha">
									<label><?php echo lang("Fecha"); ?></label>
								</div>
							</div>
						</div>
						<div class="col-12 col-lg-4 p-1">
							<div class="col">
								<div class="form-floating">
									<input class="form-control" type="text" name="ModalReferencia" id="ModalReferencia">
									<label><?php echo lang("Referencia"); ?></label>
								</div>
							</div>
						</div>
						<div class="col-12 col-lg-4 p-1">
							<div class="col">
								<div class="form-floating">
									<select class="form-control" name="FactorDCambio" id="FactorDCambio" onchange="TipoMonedaChangin();">
										<option value="0">Tasa de La Transaccion</option>
										<?php
										$query = "SELECT FactorDolarCash,FactorDolarPaypal,FactorDolarZelle,Moneda3,Moneda4,MonedaP,MonedaS,Moneda5,Moneda6,Moneda7,FactorDolar5,FactorDolar6,FactorDolar7 FROM PosUpCompany WHERE Id=" . $_SESSION['CompanyActual'] . "";
										if ($result = mysqli_query($conn, $query)) {
											while ($row = mysqli_fetch_assoc($result)) {
												$FactorDolarCash = $row['FactorDolarCash'];
										?>
												<option value="<?php echo $row['FactorDolarCash']; ?>"><?php echo $row['MonedaS']; ?></option>
												<?php
												if ($row['FactorDolarPaypal'] > 1) {
												?>
													<option value="<?php echo $row['FactorDolarPaypal']; ?>"><?php echo $row['Moneda3']; ?></option>
												<?php
												}
												if ($row['FactorDolarZelle'] > 1) {
												?>
													<option value="<?php echo $row['FactorDolarZelle']; ?>"><?php echo $row['Moneda4']; ?></option>
												<?php
												}
												if ($row['FactorDolar5'] > 1) {
												?>
													<option value="<?php echo $row['FactorDolar5']; ?>"><?php echo $row['Moneda5']; ?></option>
												<?php
												}
												if ($row['FactorDolar6'] > 1) {
												?>
													<option value="<?php echo $row['FactorDolar6']; ?>"><?php echo $row['Moneda6']; ?></option>
												<?php
												}
												if ($row['FactorDolar7'] > 1) {
												?>
													<option value="<?php echo $row['FactorDolar7']; ?>"><?php echo $row['Moneda7']; ?></option>
										<?php
												}
											}
											mysqli_free_result($result);
										}
										?>
										<option value="-1">Libre</option>
									</select>
									<label><?php echo lang("Tipo de Moneda"); ?></label>
								</div>
							</div>
						</div>
						<div class="col-12 col-lg-4 p-1" id="Div001V">
							<div class="col">
								<div class="form-floating">
									<input type="text" class="form-control text-end" style="font-size: 1.5em;" name="ModalMonto" id="ModalMonto" onchange="Totalizarmp3(this);" onkeypress="return OnlyNumbers001(event)">
									<label><?php echo lang("Monto") . " (" . $_SESSION["MonedaP"] . ")"; ?> <span class="text-primary" id="LimitCreditCar"></span></label>
								</div>
							</div>
						</div>
						<div class="col-12 col-lg-4 p-1" id="Div002V">
							<div class="col">
								<div class="form-floating">
									<input class="form-control text-end" style="font-size: 1.5em;" type="text" name="FactorDeCambioActual" id="FactorDeCambioActual" onchange="Totalizarmp3(this);" onkeypress="return OnlyNumbers001(event)">
									<label><?php echo lang("Factor de Cambio"); ?> <span id="Logitodemoneda"></span></label>
								</div>
							</div>
						</div>
						<div class="col-12 col-lg-4 p-1" id="Div003V">
							<div class="col">
								<div class="form-floating">
									<input class="form-control text-end" style="font-size: 1.5em;" type="text" name="ModalMonto2" id="ModalMonto2" onchange="Totalizarmp3(this);" onkeypress="return OnlyNumbers001(event)">
									<label><?php echo lang("Total"); ?> <span id="Logitodemoneda3"></span></label>
								</div>
							</div>
						</div>
					</div>
					<div class="row " id="Div004V" style="display:none;">
						<div class="col-12 col-lg-3 p-1">
							<div class="col">
								<div class="form-floating">
									<input class="form-control text-end" style="font-size: 1.5em;" type="text" name="ModalVuelto" id="ModalVuelto" disabled>
									<label><?php echo lang("Vuelto Total"); ?></label>
								</div>
							</div>
						</div>
						<div class="col-12 col-lg-3 p-1">
							<div class="col">
								<div class="form-floating">
									<input class="form-control text-end" style="font-size: 1.5em;" type="text" name="ModalVuelto2" id="ModalVuelto2" onchange="Totalizarmp4(this); " onkeypress="return OnlyNumbers001(event); AvanceMod(event,this);">
									<label><?php echo lang("Vuelto"); ?></label>
								</div>
							</div>
						</div>
						<div class="col-12 col-lg-6 p-1">
							<div class="input-group">
								<div class="col">
									<div class="form-floating">
										<select name="VueltoPago" id="VueltoPago" class="form-control">
											<?php echo (trim($_SESSION["LitEfectivo"]) !== "" ? "<option value='1'>" . $_SESSION["LitEfectivo"] . "</option>" : ""); ?>
											<?php echo (trim($_SESSION["LitTarjeta"]) !== "" ? "<option value='2'>" . $_SESSION["LitTarjeta"] . "</option>" : ""); ?>
											<?php echo (trim($_SESSION["LitCheque"]) !== "" ? "<option value='3'>" . $_SESSION["LitCheque"] . "</option>" : ""); ?>
											<?php echo (trim($_SESSION["LitO01"]) !== "" ? "<option value='4'>" . $_SESSION["LitO01"] . "</option>" : ""); ?>
											<?php echo (trim($_SESSION["LitO02"]) !== "" ? "<option value='5'>" . $_SESSION["LitO02"] . "</option>" : ""); ?>
											<?php echo (trim($_SESSION["LitO03"]) !== "" ? "<option value='6'>" . $_SESSION["LitO03"] . "</option>" : ""); ?>
											<?php echo (trim($_SESSION["LitO04"]) !== "" ? "<option value='7'>" . $_SESSION["LitO04"] . "</option>" : ""); ?>
										</select>
										<label><?php echo lang("Vuelto Pago"); ?></label>
									</div>
								</div>
								<button class="btn btn-outline-primary px-1" type="button" onclick="AddVuelto();"><i class="fa fa-arrow-down"></i></button>
							</div>
						</div>
						<div class="row m-0 p-0" id="VueltosAgregados">

						</div>
					</div>
					<div class="row ">
						<div class="col-3 p-1" id="palostiposdepago">
							<div class="col">
								<div class="form-floating">
									<select name="TipodPagoPah" id="TipodPagoPah" class="form-control" onchange="changeornot();">
										<?php echo (trim($_SESSION["LitEfectivo"]) !== "" ? "<option value='1'>" . $_SESSION["LitEfectivo"] . "</option>" : ""); ?>
										<?php echo (trim($_SESSION["LitTarjeta"]) !== "" ? "<option value='2'>" . $_SESSION["LitTarjeta"] . "</option>" : ""); ?>
										<?php echo (trim($_SESSION["LitCheque"]) !== "" ? "<option value='3'>" . $_SESSION["LitCheque"] . "</option>" : ""); ?>
										<?php echo (trim($_SESSION["LitO01"]) !== "" ? "<option value='4'>" . $_SESSION["LitO01"] . "</option>" : ""); ?>
										<?php echo (trim($_SESSION["LitO02"]) !== "" ? "<option value='5'>" . $_SESSION["LitO02"] . "</option>" : ""); ?>
										<?php echo (trim($_SESSION["LitO03"]) !== "" ? "<option value='6'>" . $_SESSION["LitO03"] . "</option>" : ""); ?>
										<?php echo (trim($_SESSION["LitO04"]) !== "" ? "<option value='7'>" . $_SESSION["LitO04"] . "</option>" : ""); ?>
									</select>
									<label><?php echo lang("Tipo de Pago"); ?></label>
								</div>
							</div>
						</div>
						<div class="col-3 p-1" id="palostiposdepago">
							<div class="col">
								<div class="form-floating">
									<input type="text" class="form-control" name="Referenciadeltipo" id="Referenciadeltipo">
									<label><?php echo lang("Referencia"); ?></label>
								</div>
							</div>
						</div>
						<div class="col-3 p-1" id="palostiposdepago">
							<div class="col">
								<div class="form-floating">
									<select class="form-control" name="Bancodeltipo" id="Bancodeltipo">
										<option value="0"><?php echo lang("Seleccione Banco"); ?></option>
										<?php
										$query = "SELECT id,Descrip FROM PosUpBANCuentas WHERE IdCompany = " . $_SESSION['CompanyActual'] . " order by Descrip ";
										if ($result = mysqli_query($conn, $query)) {
											while ($row = mysqli_fetch_assoc($result)) {
										?>
												<option value="<?php echo $row['id']; ?>"><?php echo $row['Descrip']; ?></option>
										<?php
											}
											mysqli_free_result($result);
										}
										?>
									</select>
									<label><?php echo lang("Banco"); ?></label>
								</div>
							</div>
						</div>
						<div class="col-3 p-1" id="palostiposdepago">
							<div class="col">
								<div class="form-floating">
									<input class="form-control" type="date" name="Fechadeltipodpago" id="Fechadeltipodpago">
									<label><?php echo lang("Fecha del Pago"); ?></label>
								</div>
							</div>
						</div>
						<span id='erroralgo' style="color:red;"></span>
						<span id="IdtxActual" class="d-none"></span>
						<span id="IdtipotxActual" class="d-none"></span>
						<span id="IdEstacionActual" class="d-none"></span>
						<span id="ContadoActual" class="d-none"></span>
						<span id="CreditoActual" class="d-none"></span>
						<span id="RetencionActual" class="d-none"></span>
						<span id="tasaactual" class="d-none"></span>
						<span id="IdtxActual2" class="d-none"></span>
						<span id="IdtipotxActual2" class="d-none"></span>
						<span id="IdEstacionActual2" class="d-none"></span>
						<span id="ContadoActual2" class="d-none"></span>
						<span id="CreditoActual2" class="d-none"></span>
						<span id="RetencionActual2" class="d-none"></span>
						<input type="date" class="d-none" name="fechadehoy" id="fechadehoy">
					</div>

				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang("Cerrar"); ?></button>
				<button class="btn btn-outline-primary" type="button" onclick="proceso(0)"><i class="fa fa-arrow-right"></i> <?php echo lang("Avanzar"); ?></button>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="modal-proce" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<img src="/img/procesando.gif" width="128" height="128" />
				<h4><?php echo lang("PosUp Esta Procesando"); ?></h4>
				<br>
				<span id="errorprocesando"></span>
				<input type="hidden" name="MontoPagar" id="MontoPagar" value="">
				<input type="hidden" name="Contado" id="Contado" value="">
				<input type="hidden" name="Credito" id="Credito" value="">
				<input type="hidden" name="Efectivo" id="Efectivo" value="">
				<input type="hidden" name="Vuelto" id="Vuelto" value="">
				<input type="hidden" name="Tarjeta" id="Tarjeta" value="">
				<input type="hidden" name="TarjetaD" id="TarjetaD" value="">
				<input type="hidden" name="Cheque" id="Cheque" value="">
				<input type="hidden" name="ChequeD" id="ChequeD" value="">
				<input type="hidden" name="Tipo01" id="Tipo01" value="">
				<input type="hidden" name="Tipo01D" id="Tipo01D" value="">
				<input type="hidden" name="Tipo02" id="Tipo02" value="">
				<input type="hidden" name="Tipo02D" id="Tipo02D" value="">
				<input type="hidden" name="Tipo03" id="Tipo03" value="">
				<input type="hidden" name="Tipo03D" id="Tipo03D" value="">
				<input type="hidden" name="Tipo04" id="Tipo04" value="">
				<input type="hidden" name="Tipo04D" id="Tipo04D" value="">
				<input type="hidden" name="Anticipo" id="Anticipo" value="">
				<input type="hidden" name="AnticipoD" id="AnticipoD" value="">
				<input type="hidden" name="Fectxclient2" id="Fectxclient2" value="">
				<input type="hidden" name="TarjetaB" id="TarjetaB" value="">
				<input type="hidden" name="ChequeB" id="ChequeB" value="">
				<input type="hidden" name="Tipo01B" id="Tipo01B" value="">
				<input type="hidden" name="Tipo02B" id="Tipo02B" value="">
				<input type="hidden" name="Tipo03B" id="Tipo03B" value="">
				<input type="hidden" name="Tipo04B" id="Tipo04B" value="">
				<input type="hidden" name="AnticipoB" id="AnticipoB" value="">
				<input type="hidden" name="Retencion" id="Retencion" value="">
				<input type="hidden" name="numret" id="numret" value="">
			</div>
		</div>
	</div>
</div>

<div class="modal" id="apps-modal3" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?php echo lang("Seleccionar Anticipo"); ?></h5>
				<button data-bs-dismiss="modal" class="btn-close" type="button"></button>
			</div>
			<div class="modal-body">
				<div class="table-responsive" id="Anticiposxd">

				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="modal-fabo" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?php echo lang("Seleccione la moneda en que desea sea impreso el recibo"); ?></h5>
				<button data-bs-dismiss="modal" class="btn-close" type="button"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<button class="btn btn-light" type="button" onclick="ImpresionEstadocb(1)"><?php echo $_SESSION['MonedaP']; ?></button><br>
					<button class="btn btn-light" type="button" onclick="ImpresionEstadocb(2)"><?php echo $_SESSION['MonedaS']; ?></button><br>
					<button class="btn btn-light" type="button" onclick="ImpresionEstadocb(3)"><?php echo $_SESSION['Moneda3']; ?></button><br>
					<button class="btn btn-light" type="button" onclick="ImpresionEstadocb(4)"><?php echo $_SESSION['Moneda4']; ?></button><br>
					<button class="btn btn-light" type="button" onclick="ImpresionEstadocb(5)"><?php echo lang("Tasa de la transaccion"); ?></button><br>
					<button class="btn btn-light" type="button" onclick="ImpresionEstadocb(6)"><?php echo lang("Tasa del pago"); ?></button><br>
				</div>
				<input type="hidden" name="A001" id="A001">
				<input type="hidden" name="A002" id="A002">
				<input type="hidden" name="A003" id="A003">
				<input type="hidden" name="A004" id="A004">
			</div>
			<div class="modal-footer">
				<button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang("Cerrar"); ?></button>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="apps-modal4" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">
					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 92.59 100.23" height="32px">
						<defs>
							<style>
								.cls-1 {
									fill: none;
								}

								.cls-2 {
									clip-path: url(#clip-path);
								}

								.cls-3 {
									fill: #002b45;
								}
							</style>
							<clipPath id="clip-path" transform="translate(0)">
								<rect class="cls-1" width="92.59" height="100.23" />
							</clipPath>
						</defs>
						<title>ISO AZUL</title>
						<g id="Capa_2" data-name="Capa 2">
							<g id="Capa_1-2" data-name="Capa 1">
								<g class="cls-2">
									<path class="cls-3" d="M70.58,74c-4.75,2.31-9.77,2.74-14.72,4.31A31.28,31.28,0,0,0,43,86.12c-3.11,3.17-5.21,7-8.81,9.72a22.55,22.55,0,0,1-11.53,4.32C13,100.94,4.53,95.46.28,87c-.91-1.81.57-4.2,2.29-4.78,2.09-.72,3.86.47,4.78,2.29a15.2,15.2,0,0,0,21.56,5.82c3.54-2.28,5.44-6.12,8.34-9.07a40.11,40.11,0,0,1,12.07-8.49c4.15-1.91,8.45-2.35,12.78-3.58a31.49,31.49,0,0,0,.55-60.56A31.82,31.82,0,0,0,25.08,25.82C21.39,33.89,23,42.73,20.27,51a45.76,45.76,0,0,1-9,15.14L20.49,74,34.93,57c1.81-2.12,4-5.89,6.92-6.43,3.49-.65,7.25-.6,10.79-.88l1.77-.15-18.82-16A3.79,3.79,0,0,1,37.71,27L66,23.74c4.81-.54,5.41,6.94.62,7.47L47.05,33.43,66.17,49.66a3.79,3.79,0,0,1-2.12,6.59L44,57.9,23.78,81.71a3.8,3.8,0,0,1-5.28.43L3.5,69.42a3.8,3.8,0,0,1-.43-5.29c6.85-7.44,11.51-15.4,11.71-25.76A39.43,39.43,0,0,1,28.37,9.29C41.64-2.28,61.43-3,75.86,6.8,90.51,16.71,96.2,35.88,90.29,52.34A39.12,39.12,0,0,1,70.58,74" transform="translate(0)" />
								</g>
							</g>
						</g>
					</svg>
					<?php echo lang("Fotografias de la transaccion"); ?> <strong id="algov22"></strong>
				</h5>
				<button data-bs-dismiss="modal" class="btn-close" type="button"></button>
			</div>
			<div class="modal-body">
				<div id="ledner"> </div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal"> <?php echo lang("Volver"); ?></button>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="apps-modal5" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo lang("Generar Transacción"); ?></h5>
                <button class="btn-close" type="button" id="boton001" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="alertaerrorenproducto"></div>
                
                <style>
                    .form-floating.etiqueta-visible > label {
                        white-space: nowrap !important;
                        overflow: hidden !important;
                        text-overflow: ellipsis !important;
                        max-width: 90% !important; 
                        opacity: 0.65 !important;
                    }
                </style>

                <div class="row p-1">
                    <div class="col-12 mb-3 px-2">
                        <div class="card border-info shadow-sm bg-light">
                            <div class="card-body p-2 d-flex align-items-center gap-2">
                                <div class="form-floating flex-grow-1">
                                    <input type="hidden" name="GexTxIdBen" id="GexTxIdBen">
                                    <input type="text" class="form-control text-primary fw-bold fs-5 bg-white" name="GexTxBenName" id="GexTxBenName" readonly placeholder="Beneficiario">
                                    <label><i class="fa fa-user"></i> <?php echo lang("Beneficiario"); ?></label>
                                </div>
                                <button class="btn btn-outline-danger" type="button" onclick="limpiar(); document.getElementById('btnLimpiarBen').style.display='none';" title="Quitar Beneficiario" id="btnLimpiarBen" style="display:none;">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-3 p-1">
                        <div class="input-group">
                            <div class="col">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="GenTxFechO" id="GenTxFechO">
                                    <label><i class="fa fa-calendar-o"></i> <?php echo lang("Fecha Transacción"); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3 p-1">
                        <div class="input-group">
                            <div class="col">
                                <div class="form-floating">
                                    <input type="date" class="form-control" name="GenTxFechV" id="GenTxFechV">
                                    <label><i class="fa fa-calendar-o"></i> <?php echo lang("Fecha Vencimiento"); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3 p-1">
                        <div class="input-group">
                            <div class="col">
                                <div class="form-floating">
                                    <select name="GenTxAño" id="GenTxAño" class="form-select">
                                    </select>
                                    <label><i class="fa fa-calendar-o"></i> <?php echo lang("Año"); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3 p-1">
                        <div class="input-group">
                            <div class="col">
                                <div class="form-floating">
                                    <select name="GenTxMes" id="GenTxMes" class="form-select">
                                        <option value="1"><?php echo lang("Enero"); ?></option>
                                        <option value="2"><?php echo lang("Febrero"); ?></option>
                                        <option value="3"><?php echo lang("Marzo"); ?></option>
                                        <option value="4"><?php echo lang("Abril"); ?></option>
                                        <option value="5"><?php echo lang("Mayo"); ?></option>
                                        <option value="6"><?php echo lang("Junio"); ?></option>
                                        <option value="7"><?php echo lang("Julio"); ?></option>
                                        <option value="8"><?php echo lang("Agosto"); ?></option>
                                        <option value="9"><?php echo lang("Septiembre"); ?></option>
                                        <option value="10"><?php echo lang("Octubre"); ?></option>
                                        <option value="11"><?php echo lang("Noviembre"); ?></option>
                                        <option value="12"><?php echo lang("Diciembre"); ?></option>
                                    </select>
                                    <label><i class="fa fa-calendar-o"></i> <?php echo lang("Mes"); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-3 p-1">
                        <div class="input-group">
                            <div class="col">
                                <div class="form-floating">
                                    <select class="form-select" name="GenTxIdtipotx" id="GenTxIdtipotx" onchange="changTipotx();">
                                        <?php
                                        $query = "SELECT Idtipotx,Titulo FROM PosUpTx WHERE Idtipotx in (2,15,22,7,28)";
                                        if ($result = mysqli_query($conn, $query)) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                        ?><option value="<?php echo trim($row['Idtipotx']); ?>"><?php echo ucwords(strtolower(Lang(trim($row['Titulo'])))); ?></option><?php
                                            }
                                            mysqli_free_result($result);
                                        }
                                        ?>
                                    </select>
                                    <label><i class="fa fa-book"></i> <?php echo lang("Tipo de Transacción"); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-2 p-1">
                        <div class="input-group">
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="GenTxRefere" id="GenTxRefere" required>
                                    <label><i class="fa fa-file-o"></i> <?php echo lang("N° Transacción"); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-lg-2 p-1">
                        <div class="col">
                            <div class="form-floating">
                               <select class="form-select" id="GexTxnumz" name="GexTxnumz" onchange="CambiarEtiquetaControl();">
    								<option value="2">FORMA LIBRE</option>
    								<option value="1">FACTURA FISCAL</option>
								</select>
                                <label><i class="fa fa-print"></i> <?php echo lang("Emisión"); ?></label>
                            </div>
                        </div>
                    </div>
					
                    <div class="col">
    					<div class="form-floating etiqueta-visible">
        					<input type="text" class="form-control" name="GexTxnroControl" id="GexTxnroControl" value="0" placeholder="0">
        					<label id="LabelNroControl"><?php echo lang("N° Control"); ?></label>
    					</div>
    				
</div>


                    <div class="col-12 col-lg-3 p-1">
                        <div class="input-group">
                            <div class="col">
                                <div class="form-floating">
                                    <select class="form-select bg-warning text-dark fw-bold" name="ModoIngresoMoneda" id="ModoIngresoMoneda" onchange="AjustarCalculoMoneda()">
                                        <option value="USD" selected>Divisa</option>
                                        <option value="VES">Bolívares</option>
                                    </select>
                                    <label><i class="fa fa-exchange"></i> <?php echo lang("Ingreso de Montos en"); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-2 p-1">
                        <div class="input-group">
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="GenTxMontoImponible" id="GenTxMontoImponible" onkeyup="AjustarCalculoMoneda();" onchange="MaskNambar(this,this.value); AjustarCalculoMoneda();">
                                    <label><i class="fa fa-money"></i> <?php echo lang("Imponible"); ?> <span id="LimitCreditTrans" class="text-primary"></span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-2 p-1">
                        <div class="input-group">
                            <div class="col">
                                <div class="form-floating">
                                    <?php
                                    $query = "SELECT IdVarios,ITEM,VALOR FROM PosUpvarios WHERE IdCompany=" . $_SESSION["CompanyActual"] . " and TIPOITEM=0";
                                    if ($result = mysqli_query($conn, $query)) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                    ?><span id="ValorImpuesto<?php echo trim($row['IdVarios']); ?>" style="display:none;"><?php echo $row['VALOR'] * 100; ?></span><?php
                                        }
                                        mysqli_free_result($result);
                                    }
                                    ?>
                                    <select class="form-select" id="GenTxImpuestos" name="GenTxImpuestos" onchange="AjustarCalculoMoneda();">
                                        <?php
                                        $query = "SELECT IdVarios,ITEM,VALOR FROM PosUpvarios WHERE IdCompany=" . $_SESSION["CompanyActual"] . " and TIPOITEM=0";
                                        if ($result = mysqli_query($conn, $query)) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                        ?><option value="<?php echo trim($row['IdVarios']); ?>"><?php echo trim($row['ITEM']) . "   (" . trim($row['VALOR'] * 100) . "%" . ")"; ?></option><?php
                                            }
                                            mysqli_free_result($result);
                                        }
                                        ?>
                                    </select>
                                    <label><i class="fa fa-percent"></i> <?php echo lang("Impuesto"); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-2 p-1">
                        <div class="input-group">
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="GenTxMontoImpuesto" id="GenTxMontoImpuesto" readonly>
                                    <label><i class="fa fa-money"></i> <?php echo lang("Impuesto"); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-2 p-1">
                        <div class="input-group">
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="GenTxSubTotal" id="GenTxSubTotal" readonly>
                                    <label><i class="fa fa-money"></i> <?php echo lang("Sub total"); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-2 p-1">
                        <div class="input-group">
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="GenTxMontoExe" id="GenTxMontoExe" onkeyup="AjustarCalculoMoneda();" onchange="MaskNambar(this,this.value); AjustarCalculoMoneda();">
                                    <label><i class="fa fa-money"></i> <?php echo lang("Exento"); ?> <span id="LimitCreditTrans2" class="text-primary"></span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-2 p-1">
                        <div class="input-group">
                            <div class="col">
                                <div class="form-floating">
                                    <input type="text" class="form-control fw-bold text-success" name="GenTxMontoTotal" id="GenTxMontoTotal" readonly>
                                    <label id="LabelTotalBase"><i class="fa fa-money"></i> <?php echo lang("Total (Ingresado)"); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>

                   <div class="col-12 col-lg-4 p-1">
                        <div class="col">
                            <div class="form-floating">
                                <select class="form-select" name="GenTxFactorDCambio" id="GenTxFactorDCambio" onchange="CambioAnbio(); setTimeout(AjustarCalculoMoneda, 200);">
                                    <?php
                                    echo $GenTxFactorDCambio;
                                    ?>
                                </select>
                                <label><?php echo lang("Tipo de Moneda de Tasa"); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 p-1">
                        <div class="col">
                            <div class="form-floating">
                                <input class="form-control text-end" pattern="^\d*(\.\d{0,2})?$" type="number" name="GenTxFactorDeCambioActual" id="GenTxFactorDeCambioActual" onkeyup="AjustarCalculoMoneda();" onchange="FactorDoChange(); AjustarCalculoMoneda();" disabled>
                                <label id="LabelFactorCambio"><?php echo lang("Factor de Cambio"); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 p-1">
                        <div class="col">
                            <div class="form-floating">
                                <input class="form-control text-end fw-bold text-danger" type="text" name="GenTxMontoTotal2" id="GenTxMontoTotal2" onkeyup="RecalcularTasaReal();" onchange="RecalcularTasaReal();" readonly>
                                <label id="LabelTotalConvertido"><?php echo lang("Total Convertido"); ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 p-1">
                        <div class="col">
                            <div class="form-floating">
                                <select class="form-select" name="AlmacenSelect" id="AlmacenSelect">
                                    <?php
                                    echo $ModalDeposito22;
                                    ?>
                                </select>
                                <label><?php echo lang("Almacen"); ?></label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-lg-12 p-1">
                        <div class="col">
                            <div class="form-floating">
                                <textarea class="form-control" name="GexTxObservacion" id="GexTxObservacion"></textarea>
                                <label><?php echo lang("Observación"); ?></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-secondary px-1" type="button" id="boton002" data-bs-dismiss="modal"><i class="fa fa-arrow-left"></i> <?php echo lang("Volver"); ?></button>
                <button class="btn btn-outline-primary px-1" type="button" id="boton003" onclick="GenerarTranx();"><i class="fa fa-arrow-right"></i> <?php echo lang("Procesar"); ?></button>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="modalBenefe" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-danger text-light">
                <h5 class="modal-title"><i class="fa fa-user"></i> <?php echo lang("Beneficiario"); ?></h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body ">
                <div id="alertaerrorenproducto2"></div>
                <div class="row">

                    <div class="col-12 col-lg-6 p-1">
                        <?php
                        if ($_SESSION["IdPais"] == "CL") {
                        ?>
                            <div class="input-group">
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="ModalRut" name="ModalRut" />
                                        <label><?php echo Lang("R.U.T."); ?></label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="ModalRut2" name="ModalRut2" readonly />
                                    </div>
                                </div>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="input-group">
                                <div class="col">
                                    <div class="form-floating">
                                        <input class="form-control" type="text" id="RutFa" name="RutFa" onchange="VerificarBeneficiarioExistente(this.value)" />
                                        <label><?php echo $_SESSION["litfiscal"]; ?></label>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="col-12 col-lg-6 p-1">
                        <div class="input-group">
                            <div class="col">
                                <div class="form-floating">
                                    <input class="form-control" type="text" name="anombreFA" id="anombreFA">
                                    <label> <?php echo Lang("A nombre de"); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 p-1">
                        <div class="col">
                            <div class="form-floating">
                                <input class="form-control" type="text" name="TelefonoFA" id="TelefonoFA">
                                <label> <?php echo Lang("Telefonó"); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 p-1">
                        <div class="col">
                            <div class="form-floating">
                                <input class="form-control" type="email" name="EmailFA" id="EmailFA">
                                <label> <?php echo Lang("Email"); ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-12 p-1">
                        <div class="col">
                            <div class="form-floating">
                                <input class="form-control" type="text" name="DirecionFA" id="DirecionFA">
                                <label> <?php echo Lang("Dirección"); ?></label>
                            </div>
                        </div>
                    </div>

                    <div class=" col-12 col-lg-4 p-1">
                        <div class="col">
                            <div class="form-floating">
                                <input class="form-control" type="text" name="CiudadFA" id="CiudadFA">
                                <label> <?php echo Lang("Ciudad"); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 p-1">
                        <div class="col">
                            <div class="form-floating">
                                <input class="form-control" type="text" name="GiroFA" id="GiroFA" onkeyup="buscarunidad(4);" onfocus="byebyemen(4);" onblur="setTimeout(byebyemen(5), 1000);">
                                <div id="suggesstion-box4" class="dropdown-menu bg-light"></div>
                                <label> <?php echo Lang("Giro"); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 p-1">
                        <div class="col">
                            <div class="form-floating">
                                <select name="TipoBeneficiario" id="TipoBeneficiario" class="form-select">
                                    <option value="0">Normal</option>
                                    <?php echo $Item3; ?>
                                </select>
                                <label><i class="fa fa-list-alt"></i>&nbsp;<?php echo lang('Tipo Beneficiario'); ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-4 p-1">
                        <div class="col">
                            <div class="form-floating">
                                <select name="TipoPersona" id="TipoPersona" class="form-select">
                                    <option value="PN">PN - Persona Natural</option>
                                    <option value="PJ">PJ - Persona Jurídica</option>
                                </select>
                                <label><i class="fa fa-user"></i>&nbsp;<?php echo lang('Tipo de Persona'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 p-1">
                        <div class="col">
                            <div class="form-floating">
                                <select name="Domicilio" id="Domicilio" class="form-select">
                                    <option value="DOM">DOM - Domiciliado</option>
                                    <option value="NDOM">NDOM - No Domiciliado</option>
                                </select>
                                <label><i class="fa fa-home"></i>&nbsp;<?php echo lang('Domicilio Fiscal'); ?></label>
                            </div>
                        </div>
                    </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-secondary px-1" type="button" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?></button>
                <button class="btn btn-outline-primary px-1" type="button" onclick="GuardarBeneficiario();"><i class="fa fa-save"></i> <?php echo lang('Guardar'); ?> </button>
            </div>
        </div>
    </div>
</div>

<div id="DeleteAnticipoModal" class="modal fade" tabindex="-1" role="dialog" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header bg-danger text-light">
				<h5 class="modal-title"><i class="fa fa-trash"></i> <?php echo lang('Eliminar Anticipo'); ?></h5>
			</div>
			<div class="modal-body">
				<div id="alertAnticipo"></div>
				<div class="row float-center text-center">
					<div class="col-12">
						<img src="img/warningtriangle.gif" style="width: 128px;">
					</div>
					<div class="col-12">
						<h3><strong><?php echo lang("¿Esta Seguro?"); ?></strong></h3>
					</div>
					<div class="col-12"><?php echo lang("Este cambio no se puede deshacer"); ?></div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-outline-secondary px-1 m-1" type="button" onclick="closeAnticipo()"><i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?></button>
				<button class="btn btn-outline-danger px-1 m-1" type="button" onclick="DeleteAnticipo2()"><i class="fa fa-trash"></i> <?php echo lang('Eliminar'); ?></button>
			</div>
		</div>
	</div>
</div>

<div id="DeletePayModal" class="modal fade" tabindex="-1" role="dialog" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header bg-danger text-light">
				<h5 class="modal-title"><i class="fa fa-trash"></i> <?php echo lang('Eliminar Pago'); ?></h5>
			</div>
			<div class="modal-body">
				<div id="alertPago"></div>
				<div class="row float-center text-center">
					<div class="col-12">
						<img src="img/warningtriangle.gif" style="width: 128px;">
					</div>
					<div class="col-12">
						<h3><strong><?php echo lang("¿Esta Seguro?"); ?></strong></h3>
					</div>
					<div class="col-12"><?php echo lang("Este cambio no se puede deshacer"); ?></div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-outline-secondary px-1 m-1" type="button" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?></button>
				<button class="btn btn-outline-danger px-1 m-1" type="button" onclick="DeletePago()"><i class="fa fa-trash"></i> <?php echo lang('Eliminar'); ?></button>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="appAntipcipo" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-user"></i> <?php echo lang("Anticipos"); ?></h5>
				<button class="btn-close" type="button" data-bs-dismiss="modal"></button>
			</div>
			<div class="modal-body ">
				<div class="table-responsive">
					<table class="table nowrap" id="anticipotablex" cellspacing="0" style="width:100%">
						<thead>
							<tr>
								<th><?php echo lang("Fecha"); ?></th>
								<th class='text-end'><?php echo lang("Monto"); ?></th>
								<th><?php echo lang("Accion"); ?></th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="Comuna-Modal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-xl modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4><img src="/img/beneficiarios.png" width="32" height="32" /><?php echo Lang("Comuna"); ?></h4>
				<div class="card-actions">
					<div class="float-end">
						<button class="btn btn-secondary" type="button" data-bs-dismiss="modal" onclick="closeBeneficiario()"><span class="fa fa-close"></span></button>
					</div>
				</div>
			</div>
			<div class="modal-body">
				<form method="post" onkeydown="return event.key != 'Enter';" autocomplete="off">
					<div class="table-responsive" id="datatable3000">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="Giro-Modal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-xl modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4><img src="/img/beneficiarios.png" width="32" height="32" /> <?php echo Lang("Giro Comercial"); ?></h4>
				<div class="card-actions">
					<div class="float-end">
						<button class="btn btn-secondary" type="button" data-bs-dismiss="modal" onclick="closeBeneficiario()"><span class="fa fa-close"></span></button>
					</div>
				</div>
			</div>
			<div class="modal-body">
				<form method="post" onkeydown="return event.key != 'Enter';" autocomplete="off">
					<div class="table-responsive" id="datatable4000">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="ModalPagoUnico" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-lg modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5><i class="fa fa-money"></i> <?php echo Lang("Pago Unico"); ?></h5>
				<button class="btn-close" type="button" data-bs-dismiss="modal"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12 col-lg-6 p-1">
						<div class="col">
							<div class="form-floating">
								<select class="form-select" id="TipoPagoPagoUnico" name="TipoPagoPagoUnico" onchange="TipoPagoAPagoUnico();">
									<?php echo (trim($_SESSION["LitEfectivo"]) !== "" ? "<option value='1'>" . $_SESSION["LitEfectivo"] . "</option>" : ""); ?>
									<?php echo (trim($_SESSION["LitTarjeta"]) !== "" ? "<option value='2'>" . $_SESSION["LitTarjeta"] . "</option>" : ""); ?>
									<?php echo (trim($_SESSION["LitCheque"]) !== "" ? "<option value='3'>" . $_SESSION["LitCheque"] . "</option>" : ""); ?>
									<?php echo (trim($_SESSION["LitO01"]) !== "" ? "<option value='4'>" . $_SESSION["LitO01"] . "</option>" : ""); ?>
									<?php echo (trim($_SESSION["LitO02"]) !== "" ? "<option value='5'>" . $_SESSION["LitO02"] . "</option>" : ""); ?>
									<?php echo (trim($_SESSION["LitO03"]) !== "" ? "<option value='6'>" . $_SESSION["LitO03"] . "</option>" : ""); ?>
									<?php echo (trim($_SESSION["LitO04"]) !== "" ? "<option value='7'>" . $_SESSION["LitO04"] . "</option>" : ""); ?>
								</select>
								<label><?php echo lang("Tipo de Pago"); ?></label>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-6 p-1">
						<div class="col">
							<div class="form-floating">
								<select class="form-select" name="FactorCambioPagoUnico" id="FactorCambioPagoUnico" onchange="TipoMonedaPagoUnico();">
									<option value="1"><?php echo lang("Tasa de las Transacciones"); ?></option>
									<?php echo ($FactorCambio["MonedaS"] !== "" ? "<option value='2'>" . $FactorCambio["MonedaS"] . "</option>" : ""); ?>
									<?php echo ($FactorCambio["Moneda3"] !== "" ? "<option value='3'>" . $FactorCambio["Moneda3"] . "</option>" : ""); ?>
									<?php echo ($FactorCambio["Moneda4"] !== "" ? "<option value='4'>" . $FactorCambio["Moneda4"] . "</option>" : ""); ?>
									<?php echo ($FactorCambio["Moneda5"] !== "" ? "<option value='5'>" . $FactorCambio["Moneda5"] . "</option>" : ""); ?>
									<?php echo ($FactorCambio["Moneda6"] !== "" ? "<option value='6'>" . $FactorCambio["Moneda6"] . "</option>" : ""); ?>
									<?php echo ($FactorCambio["Moneda7"] !== "" ? "<option value='7'>" . $FactorCambio["Moneda7"] . "</option>" : ""); ?>
								</select>
								<label><?php echo lang("Tipo de Moneda"); ?></label>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-4 p-1">
						<div class="col">
							<div class="form-floating">
								<input type="text" id="ModalMontoPagoUnico" name="ModalMontoPagoUnico" class="form-control text-end" style="font-size: 1.5em;" onchange="TotalizarPagoUnico(this);" onkeypress="return OnlyNumbers001(event)" />
								<label><?php echo lang("Monto") . " (" . $_SESSION["MonedaP"] . ")"; ?> </label>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-4 p-1">
						<div class="col">
							<div class="form-floating">
								<input class="form-control text-end" id="TasaCambioPagoUnico" name="TasaCambioPagoUnico" style="font-size: 1.5em;" type="text" />
								<label><?php echo lang("Factor de Cambio"); ?> <span id="LogitodemonedaPagoUnico"></span></label>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-4 p-1">
						<div class="col">
							<div class="form-floating">
								<input class="form-control text-end" id="ModalMonto2PagoUnico" name="ModalMonto2PagoUnico" style="font-size: 1.5em;" onchange="TotalizarPagoUnico(this);" onkeypress="return OnlyNumbers001(event)" disabled />
								<label><?php echo lang("Total"); ?> <span id="Logitodemoneda3PagoUnico"></span></label>
							</div>
						</div>
					</div>


					<div class="col-12 col-lg-4 p-1">
						<div class="col">
							<div class="form-floating">
								<input type="date" name="ModalFechaPagoUnico" id="ModalFechaPagoUnico" class="form-control">
								<label><?php echo lang("Fecha"); ?></label>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-4 p-1">
						<div class="col">
							<div class="form-floating">
								<select class="form-select" name="BancoPagoUnico" id="BancoPagoUnico">
									<option value="0"><?php echo lang("Seleccione Banco"); ?></option>
									<?php
									$query = "SELECT id,Descrip FROM PosUpBANCuentas WHERE IdCompany = " . $_SESSION['CompanyActual'] . " order by Descrip ";
									if ($result = mysqli_query($conn, $query)) {
										while ($row = mysqli_fetch_assoc($result)) {
									?>
											<option value="<?php echo $row['id']; ?>"><?php echo $row['Descrip']; ?></option>
									<?php
										}
										mysqli_free_result($result);
									}
									?>
								</select>
								<label><?php echo lang("Banco"); ?></label>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-4 p-1">
						<div class="col">
							<div class="form-floating">
								<input type="text" name="ModalReferenciaPagoUnico" id="ModalReferenciaPagoUnico" class="form-control">
								<label><?php echo lang("Referencia"); ?></label>
							</div>
						</div>
					</div>

					<div class="col-12  p-1">
						<div class="col">
							<div class="form-floating">
								<textarea class="form-control" id="ObsevacionPagoUnico" name="ObsevacionPagoUnico" rows="4"></textarea>
								<label><?php echo lang("Observación"); ?></label>
							</div>
						</div>
					</div>
					<div class="col-12" id="LoadingScreen">
						<div class="text-center">
							<div class="spinner-border" role="status" style="width: 12rem; height: 12rem;">
								<span class="visually-hidden">Loading...</span>
							</div>
						</div>
					</div>
					<div class="col-12" id="TableResponse">
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>Fecha</th>
										<th>Tipo</th>
										<th>Documento</th>
										<th>Saldo</th>
										<th>Aplicado</th>
									</tr>
								</thead>
								<tbody id="PutAplicar">
								</tbody>
							</table>
						</div>
						<div id="PaginationForm"></div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-outline-secondary px-1 m-1" type="button" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?></button>
				<button class="btn btn-outline-primary px-1 m-1" type="button" onclick="PagoEnviarDatos();"><i class="fa fa-arrow-right"></i> <?php echo lang('Procesar'); ?></button>
			</div>
		</div>
	</div>
</div>


<div class="modal" id="registrarPago" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Registro de Pago</h5>
				<button data-bs-dismiss="modal" class="btn-close" type="button"></button>
			</div>
			<div class="modal-body">
				<input type='hidden' id='json' name='json' value='[]' />
				<input type='hidden' id='spanDivisaIsa' name='spanDivisaIsa' value='' />
				<div id="alertRegistroPago"></div>

				<div class="row">
					<div class="col-12 col-lg-4 p-1">
						<div class="col">
							<div class="form-floating">
								<input type="text" class="form-control text-end" name="SaldoRegPago" id="SaldoRegPago" style="font-size:15px;" readonly>
								<label><?php echo lang("Saldo Actual"); ?> <span id="Logitodemoneda2x"></span></label>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-4 p-1">
						<div class="col">
							<div class="form-floating">
								<input type="text" class="form-control text-end" name="SaldoRegPago2" id="SaldoRegPago2" style="font-size:15px;" readonly>
								<label><?php echo lang("Saldo Actual"); ?> (<?php echo $_SESSION["MonedaP"]; ?>)</label>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-4 p-1">
						<div class="col">
							<div class="form-floating">
								<select class="form-select" name="FactorCambioRegistroPago" id="FactorCambioRegistroPago" onchange="TipoMonedaRegistroPago();">
									<option value="1"><?php echo lang("Tasa de las Transacciones"); ?></option>
									<?php echo ($FactorCambio["MonedaS"] !== "" ? "<option value='2'>" . $FactorCambio["MonedaS"] . "</option>" : ""); ?>
									<?php echo ($FactorCambio["Moneda3"] !== "" ? "<option value='3'>" . $FactorCambio["Moneda3"] . "</option>" : ""); ?>
									<?php echo ($FactorCambio["Moneda4"] !== "" ? "<option value='4'>" . $FactorCambio["Moneda4"] . "</option>" : ""); ?>
									<?php echo ($FactorCambio["Moneda5"] !== "" ? "<option value='5'>" . $FactorCambio["Moneda5"] . "</option>" : ""); ?>
									<?php echo ($FactorCambio["Moneda6"] !== "" ? "<option value='6'>" . $FactorCambio["Moneda6"] . "</option>" : ""); ?>
									<?php echo ($FactorCambio["Moneda7"] !== "" ? "<option value='7'>" . $FactorCambio["Moneda7"] . "</option>" : ""); ?>
								</select>
								<label><?php echo lang("Tipo de Moneda"); ?></label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 p-1">
						<div class="col">
							<div class="form-floating">
								<textarea class="form-control" id="ModalEARegPag" name="ModalEARegPag" rows="4"></textarea>
								<label><?php echo lang("Explicación Ampliado"); ?></label>
							</div>
						</div>
					</div>

					<div class="col-12 col-lg-4 p-1">
						<div class="col">
							<div class="form-floating">
								<input class="form-control" type="date" id="ModalFechaRegPag" name="ModalFechaRegPag">
								<label><?php echo lang("Fecha"); ?></label>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-4 p-1">
						<div class="form-floating">
							<select class="form-select" id="spago" name="spago" onchange="tdoccentonce()">
								<?php echo (trim($_SESSION["LitEfectivo"]) !== "" ? "<option value='1'>" . $_SESSION["LitEfectivo"] . "</option>" : ""); ?>
								<?php echo (trim($_SESSION["LitTarjeta"]) !== "" ? "<option value='2'>" . $_SESSION["LitTarjeta"] . "</option>" : ""); ?>
								<?php echo (trim($_SESSION["LitCheque"]) !== "" ? "<option value='3'>" . $_SESSION["LitCheque"] . "</option>" : ""); ?>
								<?php echo (trim($_SESSION["LitO01"]) !== "" ? "<option value='4'>" . $_SESSION["LitO01"] . "</option>" : ""); ?>
								<?php echo (trim($_SESSION["LitO02"]) !== "" ? "<option value='5'>" . $_SESSION["LitO02"] . "</option>" : ""); ?>
								<?php echo (trim($_SESSION["LitO03"]) !== "" ? "<option value='6'>" . $_SESSION["LitO03"] . "</option>" : ""); ?>
								<?php echo (trim($_SESSION["LitO04"]) !== "" ? "<option value='7'>" . $_SESSION["LitO04"] . "</option>" : ""); ?>
								<?php echo "<option value='9'>" . lang("Vuelto") . "/" . lang("Cambio") . "</option>"; ?>
							</select>
							<label><?php echo lang("Tipo de pago"); ?></label>
						</div>
					</div>
					<div class="col-12 col-lg-4 p-1">
						<div class="form-floating">
							<input class="form-control" id="tpag" name="tpag" readonly="">
							<label><?php echo lang("Total a Pagar"); ?></label>
						</div>
					</div>
					<div class="row p-0 m-0" id="divisiainf" style="display: none;">
						<div class="col-12 p-1" id="DivisaEn">
							<div class="col">
								<div class="form-floating">
									<select class="form-select" name="TipoDivisaFA2" id="TipoDivisaFA2" onchange="FactorMoneda(1);">
										<option value="1"><?php echo lang("Tasa de las Transacciones"); ?></option>
										<?php echo ($FactorCambio["MonedaS"] !== "" ? "<option value='2'>" . $FactorCambio["MonedaS"] . "</option>" : ""); ?>
										<?php echo ($FactorCambio["Moneda3"] !== "" ? "<option value='3'>" . $FactorCambio["Moneda3"] . "</option>" : ""); ?>
										<?php echo ($FactorCambio["Moneda4"] !== "" ? "<option value='4'>" . $FactorCambio["Moneda4"] . "</option>" : ""); ?>
										<?php echo ($FactorCambio["Moneda5"] !== "" ? "<option value='5'>" . $FactorCambio["Moneda5"] . "</option>" : ""); ?>
										<?php echo ($FactorCambio["Moneda6"] !== "" ? "<option value='6'>" . $FactorCambio["Moneda6"] . "</option>" : ""); ?>
										<?php echo ($FactorCambio["Moneda7"] !== "" ? "<option value='7'>" . $FactorCambio["Moneda7"] . "</option>" : ""); ?>
									</select>
									<label> <?php echo lang("Tasa"); ?></label>
								</div>
								<input class="form-control" type="hidden" name="TipoDivisaFA2Factor" id="TipoDivisaFA2Factor" value="1">
							</div>
						</div>
						<div class="col-12 p-1">
							<div class="input-group">
								<div class="col">
									<div class="form-floating">
										<input class="form-control text-end" type="number" step="1" min="1" name="MontoDivisa" id="MontoDivisa" value="1" onchange="FactorMoneda(4);">
										<label>Monto <span id="TipoDivisaFA2Factor22x"></span> <span id="TipoDivisaFA2Factor22">750,000.00</span></label>
									</div>
									<input class="form-control" type="hidden" name="TipoDivisaFA2Factor2" id="TipoDivisaFA2Factor2" value="750000.00">
								</div>
								<button id="mmlimpiar" class="btn btn-outline-danger fs-5 px-1" onclick="FactorMoneda(5);"> <i class="fa fa-trash"></i></button>
								<button class="btn btn-outline-primary fs-5 px-1" id="Botondivisa001" onclick="FactorMoneda(4);"> <i class="fa fa-check"></i></button>
							</div>
						</div>
						<div id="MostrarDivisaVuelto" style="display:none;">
							<div>
								<span>Aplicar Vuelto:</span>
								<button class="btn btn-outline-primary px-1 m-1" type="button" onclick="FactorMoneda(6);"><i class="fa fa-arrow-down"></i> <strong id="MostrarDivisaVueltoSpan"></strong></button>
								<span>/</span>
								<button class="btn btn-outline-primary px-1 m-1" type="button" onclick="FactorMoneda(7);"><i class="fa fa-arrow-down"></i> <strong id="MostrarDivisaVueltoSpan2"></strong></button>
							</div>
							<div>
								<button class="btn btn-outline-primary px-1 m-1" type="button" onclick="FactorMoneda(8);"><i class="fa fa-arrow-down"></i> <strong> Pago Exacto</strong></button>

							</div>
						</div>
					</div>
					<div class="col-12 col-lg-6 p-1">
						<div class="form-floating">
							<input class="form-control text-end" onkeypress="if(event.keyCode == 13) { addpago(); } " type="number" min="0" id="tpags" name="tpags" onchange="autoFixed(this);">
							<label>&nbsp;Monto</label>
						</div>
					</div>
					<div class="col-12 col-lg-6 p-1" id="MediosDepago">
						<div class="form-floating">
							<select class="form-select" id="VueltopagoABC" name="VueltopagoABC">
								<?php echo (trim($_SESSION["LitEfectivo"]) !== "" ? "<option value='1'>" . $_SESSION["LitEfectivo"] . "</option>" : ""); ?>
								<?php echo (trim($_SESSION["LitTarjeta"]) !== "" ? "<option value='2'>" . $_SESSION["LitTarjeta"] . "</option>" : ""); ?>
								<?php echo (trim($_SESSION["LitCheque"]) !== "" ? "<option value='3'>" . $_SESSION["LitCheque"] . "</option>" : ""); ?>
								<?php echo (trim($_SESSION["LitO01"]) !== "" ? "<option value='4'>" . $_SESSION["LitO01"] . "</option>" : ""); ?>
								<?php echo (trim($_SESSION["LitO02"]) !== "" ? "<option value='5'>" . $_SESSION["LitO02"] . "</option>" : ""); ?>
								<?php echo (trim($_SESSION["LitO03"]) !== "" ? "<option value='6'>" . $_SESSION["LitO03"] . "</option>" : ""); ?>
								<?php echo (trim($_SESSION["LitO04"]) !== "" ? "<option value='7'>" . $_SESSION["LitO04"] . "</option>" : ""); ?>

							</select>
							<label>&nbsp;Vuelto de pago</label>
						</div>
					</div>
					<div class="col-12 col-lg-6 p-1" id="ReferenciaPersoanl">
						<div class="col">
							<div class="form-floating">
								<input class="form-control" type="text" id="ModalReferenciaRegPag" name="ModalReferenciaRegPag" disabled="">
								<label>Referencia</label>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-6 p-1">
						<div class="col">
							<div class="form-floating">
								<select class="form-select" name="BancodelDocumento" id="BancodelDocumento" disabled="">
									<option value="0">Seleccionar Banco</option>
									<?php

									$BancodelDocumento = "";
									$query = "SELECT id,Descrip FROM PosUpBANCuentas WHERE IdCompany = " . $_SESSION['CompanyActual'] . " order by Descrip ";
									if ($result = mysqli_query($conn, $query)) {
										while ($row = mysqli_fetch_assoc($result)) {
											$BancodelDocumento .= "<option value='" . $row['id'] . "'>" . $row['Descrip'] . "</option>";
										}
										mysqli_free_result($result);
									}
									echo $BancodelDocumento;
									?>
								</select>
								<label>Banco</label>
							</div>
						</div>
					</div>
					<div class="col-12 p-1">
						<button class="btn btn-outline-primary col-12 px-1 fs-5 d-flex gap-2 align-items-center justify-content-center text-center py-1" type="button" onclick="addpago();"><i class="fa fa-plus"></i> Agregar Pago</button>
					</div>
					<div class="col-12 p-1">
						<span id="pagos" name="pagos">
						</span>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-outline-secondary px-1" type="button" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang("Cerrar"); ?></button>
				<button class="btn btn-outline-primary px-1" type="button" onclick="procesoRegistroPago(0);"><i class="fa fa-arrow-right"></i> <?php echo lang("Procesar"); ?></button>
			</div>
		</div>
	</div>
</div>

<span id="fechaktual" class="d-none"></span>
<span id="Temporal" class="d-none"></span>
<span id="goodbye" class="d-none"></span>
<span id="selectbenef" class="d-none">0</span>

<input type="hidden" name="ImpuActTxCAct" id="ImpuActTxCAct">
<input type="hidden" name="ImpoActTxCAct" id="ImpoActTxCAct">

<div class="app-ui-mask-modal d-print-none"></div>
<?php
// === CONSULTA EXACTA PARA BUSCAR EL ARCHIVO DE IMPRESIÓN ===
$FormaISLR_global = "";
$queryForma = "SELECT a.FormaISLR 
               FROM posupalmacen a 
               INNER JOIN posupcompanyestacion p ON a.IdCompany = p.IdCompany AND a.IdAlm = p.IdAlmVta 
               WHERE a.IdCompany = '" . $_SESSION["CompanyActual"] . "' 
               AND p.token = '" . $_SESSION["TokenSeleccionado"] . "' LIMIT 1";

if ($resForma = mysqli_query($conn, $queryForma)) {
    if ($rowForma = mysqli_fetch_assoc($resForma)) {
        $FormaISLR_global = trim((string)$rowForma['FormaISLR']);
    }
    mysqli_free_result($resForma);
}
?>
<input type="hidden" id="FormaISLR_global" value="<?php echo $FormaISLR_global; ?>">
<script src="jsdev/estadocb.js?v=<?php echo random_int(1, 9999999); ?>"></script>
<script src="jsdev/bben.js?v=<?php echo random_int(1, 9999999); ?>"></script>
<script src="jsdev/bcom.js?v=<?php echo random_int(1, 9999999); ?>"></script>
<script src="jsdev/bgiro.js?v=<?php echo random_int(1, 9999999); ?>"></script>

<script>
    // Corrección crítica: PHP escribe el JSON directamente, sin comillas envolventes ni JSON.parse
    const dataCaja = <?php echo json_encode($dataCaja, JSON_UNESCAPED_UNICODE | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
    const FactorCambio = <?php echo json_encode($FactorCambio, JSON_UNESCAPED_UNICODE | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
    const AutorizaIntCaja = '<?php echo $AutorizaIntCaja; ?>';
    const verTx = '<?php echo $verTx; ?>';
    let Moendas = <?php echo json_encode($Moendas, JSON_UNESCAPED_UNICODE | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
    
    const CargandoHTML = `
    <div class="text-center">
        <div class="spinner-border" role="status" style="width: 12rem; height: 12rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    `;
    const TokenSeleccionadoAB = '<?php echo $_SESSION["TokenSeleccionado"]; ?>';
    const BenePreter = '<?php echo $BenePreter; ?>';
    
    window.onload = function() {
        document.getElementById("tokeninUse").value = TokenSeleccionadoAB;
        if (typeof IniEstadocb === 'function') {
            IniEstadocb();
        }
    }
    
    const Utils = {
        LitEfectivo: "<?php echo $_SESSION['LitEfectivo']; ?>",
        LitTarjeta: "<?php echo $_SESSION['LitTarjeta']; ?>",
        LitCheque: "<?php echo $_SESSION['LitCheque']; ?>",
        LitO01: "<?php echo $_SESSION['LitO01']; ?>",
        LitO02: "<?php echo $_SESSION['LitO02']; ?>",
        LitO03: "<?php echo $_SESSION['LitO03']; ?>",
        LitO04: "<?php echo $_SESSION['LitO04']; ?>",
        Anticipo: "<?php echo lang("Anticipo"); ?>",
        Credito: "<?php echo lang("Crédito"); ?>",
        Retencion: "<?php echo lang("Retencion"); ?>",
        Filtros: "<?php echo lang("Filtros"); ?>",
        Pago: "<?php echo lang("Pago"); ?>",
        Num009: { title: "<?php echo lang('Total Inválido'); ?>", desc: "<?php echo lang('La transacción no puede tener el total menor o igual a cero'); ?>" },
        Num008: { title: "<?php echo lang('Falta Beneficiario'); ?>", desc: "<?php echo lang('No hay Beneficiario asociado a la transacción'); ?>" },
        Num007: { title: "<?php echo lang('Fecha menor a la de la transacción'); ?>", desc: "<?php echo lang('La fecha de vencimiento no es mayor o igual a la fecha de la transacción'); ?>" },
        Num006: { title: "<?php echo lang('Fecha mayor a la actual'); ?>", desc: "<?php echo lang('La fecha de la transacción supera la fecha actual'); ?>" },
        Num003: '<?php echo lang("Buscar Transacción"); ?>',
        Num004: '<?php echo lang("Buscar Beneficiario"); ?>',
        Num005: '<?php echo lang("Anticipo"); ?>',
        Num024: '<?php echo lang("Saldo Maximo del Anticipo"); ?>',
        Num025: '<?php echo lang("Pago con Anticipo"); ?>',
        Num030: '<?php echo lang("Editar Retenciones"); ?>',
        Num031: '<?php echo lang("Registro de Pago"); ?>',
        Num032: '<?php echo lang("Saldo de Anticipo"); ?>',
        Num033: '<?php echo lang("Retencion"); ?>',
        Num034: '<?php echo lang("Reverso de Crédito"); ?>',
        Num035: '<?php echo lang("Retencion2"); ?>',
        Num036: '<?php echo lang("Eliminar"); ?>',
        Num037: '<?php echo lang("EliminarAnticipo"); ?>',
        Num038: '<?php echo lang("Transacción"); ?>',
        Num400: '<?php echo lang("Tipo de Pago"); ?>',
        Num401: '<?php echo lang("Vuelto Pago"); ?>',
        Num402: '<?php echo lang("Vuelto"); ?>',
        AgrBene: '<?php echo lang("Beneficiarios"); ?>',
        Imprimir: '<?php echo lang("Imprimir"); ?>',
        num039: { title: '<?php echo Lang("Falta seleccionar banco"); ?>', desc: '<?php echo Lang("Por favor seleccione el banco que afecta la transacción"); ?>' },
        Num040: { title: '<?php echo Lang("Falta Informacion"); ?>', desc: '<?php echo Lang("Ingrese una monto valido"); ?>' },
        Num041: { title: '<?php echo Lang("Falta Informacion"); ?>', desc: '<?php echo Lang("Ingrese una fecha valida"); ?>' },
        Num042: { title: '<?php echo Lang("Falta Informacion"); ?>', desc: '<?php echo Lang("La Retencion no puede superar el monto a crédito, que es de"); ?>' },
        Num043: { title: '<?php echo Lang("Vuelto Faltante"); ?>', desc: '<?php echo Lang("Tiene que especificar en cuales medios de pago va estar devuelto"); ?>' },
        Num043x: { title: '<?php echo Lang("Identificador Fiscal Repetido"); ?>', desc: '<?php echo Lang("Este Identificador ya existe."); ?>' },
        Num043xx: { title: '<?php echo Lang("Error al enviar la información"); ?>', desc: '<?php echo Lang("Ha ocurrido un error al enviar la información por favor revise que esté ingresando los datos en los campos correspondientes."); ?>' },
        Danger: { "title": "<?php echo lang('Error al guardar'); ?>", "desc": "<?php echo lang('Se ha producido un error durante el guardado.'); ?>" },
        num048: { title: '<?php echo lang("Monto Excedido"); ?>', desc: '<?php echo Lang("El monto insertado supera el monto a pagar"); ?>' },
    };

    // --- FUNCIÓN SENIOR UX PARA AUTO-REFRESCADO CON FORZADO DE CACHÉ ---
    window.refrescarTablaPosUp = function() {
        // Cierre rápido y limpio de cualquier modal abierto
        $('.modal.show').modal('hide');
        
        // Llamamos a la función principal que recarga los cuadros
        if (typeof ActTable === 'function') {
            ActTable();
        } else {
            // Recarga dura de la página saltándose la caché (si falla ActTable)
            window.location.reload(true); 
        }
    };
    // ----------------------------------------------------

    // --- MANEJO DE ACTUALIZACIONES POST-GUARDADO Y LIMPIEZA ---
    $(document).ready(function() {
        var modalesDeAccion = '#registrarPago, #apps-modal2c, #apps-modal2x, #modalaxx, #deletepago, #DeleteAnticipoModal, #DeletePayModal, #modalRetISLR, #ModalPagoUnico';
        
        // 1. AL CERRAR MODAL: Reconstruimos el contenedor de forma segura para no romper el DOM
        $(document).on('hidden.bs.modal', modalesDeAccion, function (e) {
            if(e.target.id === 'modalRetISLR') {
                // En vez de vaciarlo, restauramos la etiqueta para que pueda volver a usarse
                $(this).find('.modal-body').html('<div id="frameRetISLR"></div>'); 
            }
        });

        // 2. ANTES DE ABRIR MODAL: Mostrar el loader correctamente
        $('#modalRetISLR').on('show.bs.modal', function () {
            $(this).find('.modal-body').html('<div id="frameRetISLR" class="text-center p-5"><i class="fa fa-spinner fa-spin fa-3x"></i><br><p class="mt-2">Cargando retención...</p></div>');
        });

        // 3. REFRESCO EXCLUSIVO DESPUÉS DE GUARDAR/PROCESAR
        $(document).ajaxSuccess(function(event, xhr, settings) {
            // Identificar si la llamada AJAX interactuó con procesos de DB
            if (settings.url && (settings.url.indexOf("process") !== -1 || settings.url.indexOf("delete") !== -1 || settings.url.indexOf("retension_islr.php") !== -1)) {
                
                // Validamos que la petición es de guardado (do=process) y no un "preview" de cambio de combo
                var esGuardado = (settings.data && settings.data.indexOf("do=process") !== -1) || 
                                 (settings.type && settings.type.toUpperCase() === 'POST');

                if (esGuardado) {
                    if (typeof ActTable === 'function') {
                        // Timeout ligero para dar tiempo a la base de datos de persistir
                        setTimeout(function(){ 
                            ActTable(); 
                        }, 600);
                    } else if (typeof Buscar === 'function') {
                        setTimeout(function(){ Buscar(); }, 600);
                    }
                }
            }
        });
    });
</script>