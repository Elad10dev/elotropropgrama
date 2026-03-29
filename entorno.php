<?php
$PaisID = "";
$query = "SELECT IdPais FROM PosUpCompany WHERE Id=" . $_SESSION['CompanyActual'] . "";
if ($result = mysqli_query($conn, $query)) {
	while ($row = mysqli_fetch_assoc($result)) {
		$PaisID = $row["IdPais"];
	}
	mysqli_free_result($result);
}

$SucursalMDP = "";
$query = "SELECT IdUbi,Nombre FROM PosUpUbicacion where IdCompany= " . $_SESSION["CompanyActual"];
if ($result = mysqli_query($conn, $query)) {
	while ($row = mysqli_fetch_assoc($result)) {
		$SucursalMDP .= "<option value='" . $row['IdUbi'] . "'>" . $row['Nombre'] . "</option>";
	}
	mysqli_free_result($result);
}
$MonedaMdp = "";
$query = "SELECT Id,Nombre FROM PosUpMonedas where IdCompany= " . $_SESSION["CompanyActual"];
if ($result = mysqli_query($conn, $query)) {
	while ($row = mysqli_fetch_assoc($result)) {
		$MonedaMdp .= "<option value='" . $row['Id'] . "'>" . $row['Nombre'] . "</option>";
	}
	mysqli_free_result($result);
}

$printcaja = 1;
$query = "SELECT printcaja FROM posupcompany where id = " . $_SESSION["CompanyActual"] . " ";
if ($result = mysqli_query($conn, $query)) {
	while ($row = mysqli_fetch_assoc($result)) {
		$printcaja = $row["printcaja"];
	}
}

$FacElec = "";
$query2 = "SELECT FacEle FROM PosUpPais WHERE Id='" . $PaisID . "'";
if ($result2 = mysqli_query($conn, $query2)) {
	while ($row2 = mysqli_fetch_assoc($result2)) {
		$FacElec = $row2["FacEle"];
	}
	mysqli_free_result($result2);
}

$optiontx = "";
$query = "SELECT Idtipotx,Titulo FROM PosUpTx ";
if ($result = mysqli_query($conn, $query)) {
	while ($row = mysqli_fetch_assoc($result)) {
		$optiontx .= "<option value='" . trim($row['Idtipotx']) . "'>" . trim($row['Titulo']) . "</option>";
	}
	mysqli_free_result($result);
}
$ImptxCompany = "";
$query = "SELECT Id,comercio FROM PosUpCompany WHERE Id not in (" . $_SESSION["CompanyActual"] . ",0,1008,133,134,144,1007,1011,1068,1074,1120,1121,1128)";
if ($result = mysqli_query($conn, $query)) {
	while ($row = mysqli_fetch_assoc($result)) {
		$ImptxCompany .= "<option value='" . trim($row['Id']) . "'>" . trim($row['comercio']) . "</option>";
	}
	mysqli_free_result($result);
}


$sql = "SELECT a.* ,b.Descripcion as ModuloName , b.Link as Archivo FROM PosUpOpciones a inner join PosUpModulo b on a.IdModulo=b.IdModulo where a.IdModulo='" . $_SESSION["ModuloActual"] . "' and a.Link='" . $_SESSION['opcion'] . "'  limit 1";
if ($resu = mysqli_query($conn, $sql)) {
	while ($rw = mysqli_fetch_assoc($resu)) {
		$nameopcion = str_replace('2', '', str_replace(' R', '', str_replace(' -S', '', $rw['Descripcion'])));
		$namemodulo = str_replace('2', '', str_replace(' R', '', str_replace(' -S', '', $rw['ModuloName'])));
		$archimodulo = $rw['Archivo'];
		$header = "
				<header id='header'>
					<div class='container'>
						<div class='row'>
							<div class='col-8'>
								<h1><i><img src='/img/" . $rw['Img'] . "' width='20' height='20'></i> " . lang(str_replace('2', '', str_replace(' R', '', str_replace(' -S', '', $rw['Descripcion'])))) . " </h1>
							</div>
							<div class='col-4'>
								<div class='row'>
								<div class='col-11'>
								<small>" . lang($rw['ExplicacionOpcion']) . "</small>
							</div>
							<div class='col-1'>
								" . ($rw['LinkVideo'] <> '' ? "<button type='button' class='btn btn-outline-primary px-1 m-1' onclick='getVideo(`" . $rw['LinkVideo'] . "`,`" . lang(str_replace('2', '', str_replace(' R', '', str_replace(' -S', '', $rw['Descripcion'])))) . "`)'> <img src='/img/video.png' width='36' height='36'> </button>" : "") . "
							</div>
								</div>
							</div>
						</div>
					</div>
				</header>
			";
	}
	mysqli_free_result($resu);
}
echo $header;
?>
<style>
	.slim-btn {
		font-size: 1em;
		background-image: none;
		display: none;
	}

	@media print {
		.modal-backdrop {
			background: none !important;
		}
	}
</style>
<nav aria-label="breadcrumb">
	<div class="container">
		<ol class="breadcrumb">
			<li class="breadcrumb-item "><a href="app.php?opcion=<?php echo $archimodulo; ?>"><?php echo lang($namemodulo); ?></a></li>
			<li class="breadcrumb-item active"><?php echo lang($nameopcion); ?></li>
		</ol>
	</div>
</nav>

<div class="container" id='option' style='padding-bottom:78px;'>
	<div id="alertaerrorenproducto"></div>
	<div class="text-center mb-1" id="CargandoContainer">
		<img src="/img/procesando.gif" width="128" height="128" />
		<h4><?php echo lang("Cargando"); ?></h4>
	</div>
	<div class="row" id='maincontainer' style="display:none;">

		<ul class="nav nav-tabs" id="myTab" role="tablist">
			<li class="nav-item" role="presentation">
				<button class="nav-link active" id="Regional-tab" data-bs-toggle="tab" data-bs-target="#Regional" type="button" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-cogs"></i> <?php echo lang('Regional'); ?></button>
			</li>
			<li class="nav-item " role="presentation">
				<button class="nav-link " id="Logotipo-tab" data-bs-toggle="tab" data-bs-target="#Logotipo" type="button" role="tab" aria-controls="profile" aria-selected="false"><i class="fa fa-image"></i> <?php echo lang('Logotipo'); ?></button>
			</li>
			<li class="nav-item" role="presentation">
				<button class="nav-link" id="FormasDpago-tab" data-bs-toggle="tab" data-bs-target="#FormasDpago" type="button" role="tab" aria-controls="contact" aria-selected="false"><i class="fa fa-money"></i> <?php echo lang('Formas De Pago'); ?></button>
			</li>
			<?php
			if ($FacElec == "1") {
			?>
				<li class="nav-item" role="presentation">
					<button class="nav-link" id="Certificacion-tab" data-bs-toggle="tab" data-bs-target="#Certificacion" type="button" role="tab" aria-controls="contact" aria-selected="false"><i class="fa fa-cog"></i> <?php echo lang('Certificación Electrónica'); ?></button>
				</li>

				<li class="nav-item" role="presentation">
					<button class="nav-link" id="Firma-tab" data-bs-toggle="tab" data-bs-target="#Firma" type="button" role="tab" aria-controls="contact" aria-selected="false"><i class="fa fa-lock"></i> <?php echo lang('Firma Electrónica (PFX P12)'); ?></button>
				</li>

				<li class="nav-item" role="presentation">
					<button class="nav-link" id="CAF-tab" data-bs-toggle="tab" data-bs-target="#CAF" type="button" role="tab" aria-controls="contact" aria-selected="false"><i class="fa fa-file-text-o"></i> <?php echo lang('CAF'); ?></button>
				</li>
			<?php
			}
			?>
			<li class="nav-item" role="presentation">
				<button class="nav-link" id="Procesos-tab" data-bs-toggle="tab" data-bs-target="#Procesos" type="button" role="tab" aria-controls="contact" aria-selected="false"><i class="fa fa-file-code-o"></i> <?php echo lang('Gestor de Scripts'); ?></button>
			</li>
			<li class="nav-item" role="presentation">
				<button class="nav-link" id="Literales-tab" data-bs-toggle="tab" data-bs-target="#Literales" type="button" role="tab" aria-controls="contact" aria-selected="false"><i class="fa fa-file-code-o"></i> <?php echo lang('Literales'); ?></button>
			</li>
			<li class="nav-item" role="presentation">
				<button class="nav-link" id="SMTP-tab" data-bs-toggle="tab" data-bs-target="#SMTP" type="button" role="tab" aria-controls="contact" aria-selected="false"><i class="fa fa-envelope"></i> <?php echo lang('Correo Eléctronico'); ?></button>
			</li>
		</ul>
		<div class="tab-content p-0" id="myTabContent">
			<div class="tab-pane fadeshow active" id="Regional" role="tabpanel">
				<div class="card">
					<div class="card-header">
						<h5 class="modal-title"><i class="fa fa-cogs"></i> <?php echo lang("Regional"); ?></h5>
					</div>
					<div class="card-body p-1">

						<div class="row">
							<div class="col-12 col-lg-2 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalID" name="ModalID" readOnly />
									<label><i class="fa fa-book"></i>&nbsp;ID</label>
								</div>
							</div>

							<div class="col-12 col-lg-5 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalNombre" name="ModalNombre" readOnly />
									<label><i class="fa fa-user" aria-hidden="true"></i>&nbsp;<?php echo lang('Nombre del Representante'); ?></label>
								</div>
							</div>

							<div class="col-12 col-lg-5 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalComercio" name="ModalComercio" readOnly />
									<label><i class="fa fa-university"></i>&nbsp;<?php echo lang('Nombre del Comercio'); ?></label>
								</div>
							</div>

							<div class="col-12 col-lg-2 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalFiscal" name="ModalFiscal" />
									<label><i class="fa fa-gavel"></i>&nbsp;<?php echo lang('Literal Fiscal'); ?></label>
								</div>
							</div>

							<div class="col-12 col-lg-3 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" id="rifemp" readOnly />
									<label><i class="fa fa-file-o"></i>&nbsp;<?php echo $_SESSION["litfiscal"]; ?></label>
								</div>
							</div>

							<div class="col-12 col-lg-7 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" id="Modaldireccion" name="Modaldireccion" />
									<label><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;<?php echo lang('Dirección'); ?></label>
								</div>
							</div>

							<div class="col-12 col-lg-3 my-1" <?php echo ($printcaja == 0 ? "style='display:none'" : ""); ?>>
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalMonedaP" name="ModalMonedaP" onkeyup="CambiarLitFiscal(1);" <?php echo ($printcaja == 0 ? "disabled" : ""); ?> />
									<label><i class="fa fa-money" aria-hidden="true"></i>&nbsp;<?php echo lang('Literal Moneda Principal') ?></label>
								</div>
							</div>

							<div class="col-12 col-lg-3 my-1" <?php echo ($printcaja == 0 ? "style='display:none'" : ""); ?>>
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalMonedaS" name="ModalMonedaS" onkeyup="CambiarLitFiscal(2);" <?php echo ($printcaja == 0 ? "disabled" : ""); ?> />
									<label><i class="fa fa-money" aria-hidden="true"></i>&nbsp;<?php echo lang('Literal 2da. Moneda') ?> </label>
								</div>
							</div>

							<div class="col-12 col-lg-3 my-1" <?php echo ($printcaja == 0 ? "style='display:none'" : ""); ?>>
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalMonedaT" name="ModalMonedaT" onkeyup="CambiarLitFiscal(3);" <?php echo ($printcaja == 0 ? "disabled" : ""); ?> />
									<label><i class="fa fa-money" aria-hidden="true"></i>&nbsp;<?php echo lang('Literal 3era. Moneda') ?> </label>
								</div>
							</div>

							<div class="col-12 col-lg-3 my-1" <?php echo ($printcaja == 0 ? "style='display:none'" : ""); ?>>
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalMonedaC" name="ModalMonedaC" onkeyup="CambiarLitFiscal(4);" <?php echo ($printcaja == 0 ? "disabled" : ""); ?> />
									<label><i class="fa fa-money" aria-hidden="true"></i>&nbsp;<?php echo lang('Literal 4ta. Moneda') ?> </label>
								</div>
							</div>


							<div class="col-12 col-lg-3 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" value="1" readOnly />
									<label><i class="fa fa-exchange" aria-hidden="true"></i>&nbsp;<span id="Monedaunomanin"></span> </label>
								</div>
							</div>

							<div class="col-12 col-lg-3 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalFactorDolarCash" name="ModalFactorDolarCash" readOnly />
									<label><i class="fa fa-exchange" aria-hidden="true"></i>&nbsp;<span id="Monedadosmanin"></span> </label>
								</div>
							</div>

							<div class="col-12 col-lg-3 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalFactorDolarPaypal" name="ModalFactorDolarPaypal" readOnly />
									<label><i class="fa fa-exchange" aria-hidden="true"></i>&nbsp;<span id="Monedatresmanin"></span> </label>
								</div>
							</div>

							<div class="col-12 col-lg-3 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalFactorDolarZelle" name="ModalFactorDolarZelle" readOnly />
									<label><i class="fa fa-exchange" aria-hidden="true"></i>&nbsp;<span id="Monedacuatromanin"></span> </label>
								</div>
							</div>


							<div class="col-12 col-lg-4 my-1" <?php echo ($printcaja == 0 ? "style='display:none'" : ""); ?>>
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalMoneda5" name="ModalMoneda5" onkeyup="CambiarLitFiscal(5);" <?php echo ($printcaja == 0 ? "disabled" : ""); ?> />
									<label><i class="fa fa-money" aria-hidden="true"></i>&nbsp;<?php echo lang('Literal 5ta. Moneda') ?></label>
								</div>
							</div>

							<div class="col-12 col-lg-4 my-1" <?php echo ($printcaja == 0 ? "style='display:none'" : ""); ?>>
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalMoneda6" name="ModalMoneda6" onkeyup="CambiarLitFiscal(6);" <?php echo ($printcaja == 0 ? "disabled" : ""); ?> />
									<label><i class="fa fa-money" aria-hidden="true"></i>&nbsp;<?php echo lang('Literal 6ta. Moneda') ?></label>
								</div>
							</div>

							<div class="col-12 col-lg-4 my-1" <?php echo ($printcaja == 0 ? "style='display:none'" : ""); ?>>
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalMoneda7" name="ModalMoneda7" onkeyup="CambiarLitFiscal(7);" <?php echo ($printcaja == 0 ? "disabled" : ""); ?> />
									<label><i class="fa fa-money" aria-hidden="true"></i>&nbsp;<?php echo lang('Literal 7ta. Moneda') ?></label>
								</div>
							</div>
							<div class="col-12 col-lg-4 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalFactorDolar5" name="ModalFactorDolar5" readOnly />
									<label><i class="fa fa-exchange" aria-hidden="true"></i>&nbsp;<span id="Monedacincomanin"></span> </label>
								</div>
							</div>

							<div class="col-12 col-lg-4 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalFactorDolar6" name="ModalFactorDolar6" readOnly />
									<label><i class="fa fa-exchange" aria-hidden="true"></i>&nbsp;<span id="Monedaseismanin"></span> </label>
								</div>
							</div>

							<div class="col-12 col-lg-4 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalFactorDolar7" name="ModalFactorDolar7" readOnly />
									<label><i class="fa fa-exchange" aria-hidden="true"></i>&nbsp;<span id="Monedasietemanin"></span> </label>
								</div>
							</div>


							<div class="col-12  my-1" <?php echo ($printcaja == 0 ? "style='display:none'" : ""); ?>>
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalMonedaPrincipal" name="ModalMonedaPrincipal" />
									<label><i class="fa fa-money" aria-hidden="true"></i>&nbsp;<?php echo lang('Literal Moneda Principal') ?></label>
								</div>
							</div>


							<div class="col-12 my-1">
								<div>
									<a class='btn btn-outline-primary m-1 px-1' href="?opcion=cambiodetasa.php&Ec=1"> <i class="fa fa-cog "></i> <?php echo lang('Cambio de Tasa') ?></a>
									<a class='btn btn-outline-primary m-1 px-1' href="?opcion=cambiomoneda.php" style="display: none;"> <i class="fa fa-money "></i> <?php echo lang('Monedas') ?></a>
								</div>
							</div>
						<!-- Este es un Comentario 
							<div class="col-12 my-1">
								<label><i class="fa fa-th-large"></i>&nbsp;<?php echo lang('Empresas que puede importar transacciones'); ?></label>
								<select id="ImptxCompany" name="ImptxCompany[]" onchange="stringImptxCompany();" multiple="multiple" style="width: 100%">
									<?php echo $ImptxCompany; ?>
								</select>
								<span id="mRegUnoImptxCompany" class="d-none"></span>
							</div>
						-->
							<div class="col-12 col-lg-4 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalCD" name="ModalCD" onkeypress="return OnlyNumbers003(event)" />
									<label><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;<?php echo lang('Cantidad de Decimales') ?></label>
								</div>
							</div>

							<div class="col-12 col-lg-4 my-1">
								<div class="form-floating">
									<select name="ModalSimDec" id="ModalSimDec" class="form-select" onchange="cambiopuntocoma(1);">
										<option value=".">.</option>
										<option value=",">,</option>
									</select>
									<label><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;<?php echo lang('Símbolo de decimales') ?></label>
								</div>
							</div>

							<div class="col-12 col-lg-4 my-1">
								<div class="form-floating">
									<input type="text" name="ModalSimMil" id="ModalSimMil" class="form-control" readOnly>
									<label><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;<?php echo lang('Símbolo de miles') ?></label>
								</div>
							</div>

							<div class="col-12 col-lg-6 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalVencePre" name="ModalVencePre" onkeypress="return valideKey(event);" />
									<label><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;<?php echo lang('Vencimiento de Presupuesto (Horas)') ?></label>
								</div>
							</div>

							<div class="col-12 col-lg-6 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalVencePed" name="ModalVencePed" onkeypress="return valideKey(event);" />
									<label><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;<?php echo lang('Vencimiento de Pedidos (Horas)') ?></label>
								</div>
							</div>

							<div class="col-12 col-lg-3 my-1">
								<div class="form-floating">
									<input type="color" class="form-control" id="entcol" name="entcol" />
									<label><i class="fa fa-paint-brush" aria-hidden="true"></i>&nbsp;<?php echo lang('Color Entorno') ?></label>
								</div>
							</div>

							<div class="col-12 col-lg-3 my-1">
								<div class="form-floating">
									<select name="TipoCsoto" id="TipoCsoto" class="form-select">
										<option value="0"><?php echo lang('Seleccionar') ?></option>
										<option value="1"><?php echo lang('Ultimo Costo') ?></option>
										<option value="2"><?php echo lang('Costo Promedio') ?></option>
										<option value="3"><?php echo lang('Costo Mas Alto') ?></option>
									</select>
									<label><i class="fa fa-bar-chart" aria-hidden="true"></i>&nbsp;<?php echo lang('Tipo Costo') ?></label>
								</div>
							</div>
							<div class="col-12 col-lg-3 my-1">
								<div class="form-floating">
									<input type="number" class="form-control" id="TolCostoC" name="TolCostoC" min="1" max="100" />
									<label> <?php echo lang('Tolerancia de Costo') ?></label>
								</div>
							</div>

							<div class="col-12 col-lg-3 my-1">
								<div class="form-floating">
									<select name="VisualPrecios" id="VisualPrecios" class="form-select">
										<option value="1"><?php echo lang('Precios sin impuesto') ?></option>
										<option value="2"><?php echo lang('Precios con impuesto') ?></option>
									</select>
									<label><i class="fa fa-bar-chart" aria-hidden="true"></i>&nbsp;<?php echo lang('Visualización de precios') ?></label>
								</div>
							</div>

							<div class="col-12 col-lg-6 my-1">
								<div class="form-floating">
									<select name="formatdate" id="formatdate" class="form-select">
										<option value="d-m-Y"><?php echo lang('Dia-Mes-Año (03-11-2021)') ?></option>
										<option value="d/m/Y"><?php echo lang('Dia/Mes/Año (03/11/2021)') ?></option>
										<option value="Y-m-d"><?php echo lang('Año-Mes-Dia (2021-11-03)') ?></option>
										<option value="Y/m/d"><?php echo lang('Año/Mes/Dia (2021/11/03)') ?></option>
										<option value="m-d-Y"><?php echo lang('Mes-Dia-Año (11-03-2021)') ?></option>
										<option value="m/d/Y"><?php echo lang('Mes/Dia/Año (11/03/2021)') ?></option>
									</select>
									<label><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;<?php echo lang('Formato de Fecha') ?></label>
								</div>
							</div>

							<div class="col-12 col-lg-6 my-1">
								<div class="form-floating">
									<select name="formathour" id="formathour" class="form-select">
										<option value="H:i:s"><?php echo lang('Hora:Minuto:Segundo (15:09:23)'); ?></option>
										<option value="H:i"><?php echo lang('Hora:Minuto (15:09)'); ?></option>
									</select>
									<label><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;<?php echo lang('Formato de Hora') ?></label>
								</div>
							</div>

							<div class="col-12 col-lg-3 my-1">
								<div class="form-floating">
									<select name="recalprice" id="recalprice" class="form-select">
										<option value="1"><?php echo lang('Recalcular Precio') ?></option>
										<option value="2"><?php echo lang('Recalcular Margen Utilidad') ?></option>
									</select>
									<label><i class="fa fa-money" aria-hidden="true"></i>&nbsp;<?php echo lang('Al actualizar costo') ?></label>
								</div>
							</div>

							<div class="col-12 col-lg-3 my-1">
								<div class="form-floating">
									<select name="numeracventas" id="numeracventas" class="form-select">
										<option value="0"><?php echo lang("Unica x Empresa"); ?></option>
										<option value="1"><?php echo lang("Unica x Estación"); ?></option>
										<option value="2"><?php echo lang("Referencia de la transacción"); ?></option>
									</select>
									<label><i class="fa fa-money" aria-hidden="true"></i>&nbsp;<?php echo lang('Tx Visualizado en Venta') ?></label>
								</div>
							</div>

							<div class="col-12 col-lg-3 my-1">
								<div class="form-floating">
									<select name="numeraccompras" id="numeraccompras" class="form-select">
										<option value="0"><?php echo lang("Unica x Empresa"); ?></option>
										<option value="1"><?php echo lang("Unica x Estación"); ?></option>
										<option value="2"><?php echo lang("Referencia de la transacción"); ?></option>
									</select>
									<label><i class="fa fa-money" aria-hidden="true"></i>&nbsp;<?php echo lang('Tx Visualizado en Compra') ?></label>
								</div>
							</div>

							<div class="col-12 col-lg-3 my-1">
								<div class="form-floating">
									<select name="numeracinventario" id="numeracinventario" class="form-select">
										<option value="0"><?php echo lang("Unica x Empresa"); ?></option>
										<option value="1"><?php echo lang("Unica x Estación"); ?></option>
										<option value="2"><?php echo lang("Referencia de la transacción"); ?></option>
									</select>
									<label><i class="fa fa-money" aria-hidden="true"></i>&nbsp;<?php echo lang('Tx Visualizado en Inventario') ?></label>
								</div>
							</div>

							<div class="col-12 col-lg-4 my-1">
								<div class="form-floating">
									<select name="validCreditC" id="validCreditC" class="form-select">
										<option value="0"><?php echo lang('No Activar Credito a los Clientes Nuevos Por Defecto') ?></option>
										<option value="1"><?php echo lang('Activar Credito a los Clientes Nuevos Por Defecto') ?></option>
									</select>
									<label><i class="fa fa-bar-chart" aria-hidden="true"></i>&nbsp;<?php echo lang('Credito Activado') ?></label>
								</div>
							</div>

							<div class="col-12">
								<h4 class="m-t-sm m-b"><?php echo lang('Trabaja con') ?> :</h4>
							</div>
							<div class="col-12 col-md-6 col-lg-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="p0z" id="p0z">
									<label class="form-check-label" for="p0z"><?php echo lang('Precio') ?> 0</label>
								</div>
							</div>
							<div class="col-12 col-md-6 col-lg-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="p1z" id="p1z">
									<label class="form-check-label" for="p1z"><span id="LitPriceSpan1"></span></label>
								</div>
							</div>
							<div class="col-12 col-md-6 col-lg-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="p2z" id="p2z">
									<label class="form-check-label" for="p2z"><span id="LitPriceSpan2"></span></label>
								</div>
							</div>
							<div class="col-12 col-md-6 col-lg-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="p3z" id="p3z">
									<label class="form-check-label" for="p3z"><span id="LitPriceSpan3"></span></label>
								</div>
							</div>
							<div class="col-12 col-md-6 col-lg-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="p4z" id="p4z">
									<label class="form-check-label" for="p4z"><span id="LitPriceSpan4"></span></label>
								</div>
							</div>
							<div class="col-12 col-md-6 col-lg-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="p5z" id="p5z">
									<label class="form-check-label" for="p5z"><span id="LitPriceSpan5"></span></label>
								</div>
							</div>
							<div class="col-12 col-md-6 col-lg-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="p6z" id="p6z">
									<label class="form-check-label" for="p6z"><span id="LitPriceSpan6"></span></label>
								</div>
							</div>
							<div class="col-12 col-md-6 col-lg-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="p7z" id="p7z">
									<label class="form-check-label" for="p7z"><span id="LitPriceSpan7"></span></label>
								</div>
							</div>
							<div class="col-12 col-md-6 col-lg-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="p8z" id="p8z">
									<label class="form-check-label" for="p8z"><span id="LitPriceSpan8"></span></label>
								</div>
							</div>
							<div class="col-12 col-md-6 col-lg-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="p9z" id="p9z">
									<label class="form-check-label" for="p9z"><span id="LitPriceSpan9"></span></label>
								</div>
							</div>
							<div class="col-12 col-md-6 col-lg-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="p10z" id="p10z">
									<label class="form-check-label" for="p10z"><span id="LitPriceSpan10"></span></label>
								</div>
							</div>
							<div class="col-12 col-md-6 col-lg-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="u1z" id="u1z">
									<label class="form-check-label" for="u1z"><?php echo lang('Unidad') ?> 1 </label>
								</div>
							</div>
							<div class="col-12 col-md-6 col-lg-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="u2z" id="u2z">
									<label class="form-check-label" for="u2z"><?php echo lang('Unidad') ?> 2 </label>
								</div>
							</div>
							<div class="col-12 col-md-6 col-lg-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="u3z" id="u3z">
									<label class="form-check-label" for="u3z"><?php echo lang('Unidad') ?> 3 </label>
								</div>
							</div>
							<div class="col-12 col-md-6 col-lg-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="u4z" id="u4z">
									<label class="form-check-label" for="u4z"><?php echo lang('Unidad') ?> 4 </label>
								</div>
							</div>
							<div class="col-12 col-md-6 col-lg-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="u5z" id="u5z">
									<label class="form-check-label" for="u5z"><?php echo lang('Unidad') ?> 5 </label>
								</div>
							</div>
							<div class="col-12 col-md-6 col-lg-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="u6z" id="u6z">
									<label class="form-check-label" for="u6z"><?php echo lang('Unidad') ?> 6 </label>
								</div>
							</div>
							<div class="col-12 col-md-6 col-lg-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="u7z" id="u7z">
									<label class="form-check-label" for="u7z"><?php echo lang('Unidad') ?> 7 </label>
								</div>
							</div>
							<div class="col-12 col-md-6 col-lg-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="u8z" id="u8z">
									<label class="form-check-label" for="u8z"><?php echo lang('Unidad') ?> 8 </label>
								</div>
							</div>
							<div class="col-12 col-md-6 col-lg-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="u9z" id="u9z">
									<label class="form-check-label" for="u9z"><?php echo lang('Unidad') ?> 9 </label>
								</div>
							</div>
							<div class="col-12 col-md-6 col-lg-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="u10z" id="u10z">
									<label class="form-check-label" for="u10z"><?php echo lang('Unidad') ?> 10 </label>
								</div>
							</div>
							<div class="col-12 col-md-6 col-lg-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="punz" id="punz">
									<label class="form-check-label" for="punz"><?php echo lang('Asociar Precio a la Unidad') ?></label>
								</div>
							</div>
							<div class="col-12 col-md-6 col-lg-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="vcz" id="vcz">
									<label class="form-check-label" for="vcz"><?php echo lang('Visualizar Costo') ?> </label>
								</div>
							</div>
							<div class="col-12 col-md-6 col-lg-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="AlmacenNegativo" id="AlmacenNegativo">
									<label class="form-check-label" for="AlmacenNegativo"><?php echo lang('Permitir Vender en Negativo') ?></label>
								</div>
							</div>
							<div class="col-12 col-md-6 col-lg-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="PerVenderMenorCosto" id="PerVenderMenorCosto">
									<label class="form-check-label" for="PerVenderMenorCosto"><?php echo lang('Permitir Vender menor al costo') ?> </label>
								</div>
							</div>

							<span id="Resultdo">
								<div class="row">
									<div class="col-12 col-lg-3 my-1">
										<div class="form-floating">
											<select class="form-select" id="Modaltipotxd" name="Modaltipotxd">
												<?php echo $optiontx; ?>
											</select>
											<label><i class="fa fa-cog" aria-hidden="true"></i>&nbsp;<?php echo lang('Tipo de Transacción') ?></label>
										</div>
									</div>
									<div class="col-12 col-lg-3 my-1">
										<div class="form-floating">
											<select class="form-select" id="ModalPreciotx" name="ModalPreciotx">
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
											</select>
											<label><i class="fa fa-cog" aria-hidden="true"></i>&nbsp;<?php echo lang('Precio') ?></label>
										</div>
									</div>
									<div class="col-12  ps-2  col-lg-3">
										<div class="form-check">
											<input class="form-check-input" type="checkbox" id="Preterminado" id="Preterminado" onchange="IsPreterminado();">
											<label class="form-check-label" for="Preterminado"><?php echo lang('Es Preterminado') ?></label>
										</div>
									</div>
									<div class="col-12 col-lg-3">
										<br>
										<button id='Estac' class="btn btn-outline-primary m-1 px-1" type="button" onclick="EnviarTx();"><i class="fa fa-plus"></i> <?php echo lang("Agregar"); ?></button>
									</div>
								</div>
							</span>
							<input type="hidden" name="teoricopensamiento" id="teoricopensamiento" value="<?php echo $txVenta; ?>">

							<div class="col-12">
								<h4 class="m-t-sm m-b"><?php echo lang('Items máximos (0 es igual a ilimitados) ') ?> :</h4>
							</div>

							<div class="col-12 col-md-6 col-lg-3 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" id="ItemsMaxFact" name="ItemsMaxFact" />
									<label><i class="fa fa-cog" aria-hidden="true"></i>&nbsp;<?php echo lang('Factura') ?> </label>
								</div>
							</div>

							<div class="row" style='display:none'>
								
								<div class="col-12">
									<h4 class="m-t-sm m-b"><?php echo lang('Factores Aplicables al Precio para seleccionar al vender') ?>:</h4>
								</div>
								<div id="alertaerrorenfactor"></div>
								<div class="col-12 col-md-6 col-lg-3 my-1">
									<div class="form-floating">
										<input type="text" class="form-control" id="FactorAg1" name="FactorAg1" />
										<label><i class="fa fa-calculator" aria-hidden="true"></i>&nbsp;<?php echo lang('Factor') ?> 1</label>
									</div>
								</div>
								<div class="col-12 col-md-6 col-lg-3 my-1">
									<div class="form-floating">
										<input type="text" class="form-control" id="FactorAg2" name="FactorAg2" />
										<label><i class="fa fa-calculator" aria-hidden="true"></i>&nbsp;<?php echo lang('Factor') ?> 2</label>
									</div>

								</div>
								<div class="col-12 col-md-6 col-lg-3 my-1">
									<div class="form-floating">
										<input type="text" class="form-control" id="FactorAg3" name="FactorAg3" />
										<label><i class="fa fa-calculator" aria-hidden="true"></i>&nbsp;<?php echo lang('Factor') ?> 3</label>
									</div>

								</div>
								<div class="col-12 col-md-6 col-lg-3 my-1">
									<div class="form-floating">
										<input type="text" class="form-control" id="FactorAg4" name="FactorAg4" />
										<label><i class="fa fa-calculator" aria-hidden="true"></i>&nbsp;<?php echo lang('Factor') ?> 4</label>
									</div>

								</div>
								<div class="col-12 col-md-6 col-lg-3 my-1">
									<div class="form-floating">
										<input type="text" class="form-control" id="FactorAg5" name="FactorAg5" />
										<label><i class="fa fa-calculator" aria-hidden="true"></i>&nbsp;<?php echo lang('Factor') ?> 5</label>
									</div>

								</div>
								<div class="col-12 col-md-6 col-lg-3 my-1">
									<div class="form-floating">
										<input type="text" class="form-control" id="FactorAg6" name="FactorAg6" />
										<label><i class="fa fa-calculator" aria-hidden="true"></i>&nbsp;<?php echo lang('Factor') ?> 6</label>
									</div>

								</div>
								<div class="col-12 col-md-6 col-lg-3 my-1">
									<div class="form-floating">
										<input type="text" class="form-control" id="FactorAg7" name="FactorAg7" />
										<label><i class="fa fa-calculator" aria-hidden="true"></i>&nbsp;<?php echo lang('Factor') ?> 7</label>
									</div>

								</div>
								<div class="col-12 col-md-6 col-lg-3 my-1">
									<div class="form-floating">
										<input type="text" class="form-control" id="FactorAg8" name="FactorAg8" />
										<label><i class="fa fa-calculator" aria-hidden="true"></i>&nbsp;<?php echo lang('Factor') ?> 8</label>
									</div>

								</div>
								
							</div>
							<div class="col-12 col-lg-6 my-1" style="display: none;">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="MostrarTodasLasTx" id="MostrarTodasLasTx">
								</div>
							</div>
							<div class="col-12 col-lg-6 my-1">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="AlertExistMin" id="AlertExistMin">
									<label class="form-check-label" for="AlertExistMin"><?php echo lang('Alertar Existencia Minima') ?></label>
								</div>
							</div>

							<div class="col-12 col-lg-6 my-1">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="AllExistencia" id="AllExistencia">
									<label class="form-check-label" for="AllExistencia"><?php echo lang('Ver Productos de todas las Ubicaciones al Vender') ?></label>
								</div>
							</div>

							<div class="col-12 col-lg-6 my-1">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="InsuRec" id="InsuRec">
									<label class="form-check-label" for="InsuRec"><?php echo lang('Descontar Insumos de Recetas') ?></label>
								</div>
							</div>

							<div class="col-12 col-lg-6 my-1">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="viewRateRec" id="viewRateRec">
									<label class="form-check-label" for="viewRateRec"><?php echo lang('Mostrar Tasa de la Transacción') ?></label>
								</div>
							</div>

							<div class="col-12 col-lg-6 my-1" style="display: none;">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="hidecurrencyRec" id="hidecurrencyRec">
								</div>
							</div>
							<div class="col-12 col-md-6 col-lg-3" style="display: none;">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="printcajaz" id="printcajaz">
								</div>
							</div>


						</div>
					</div>
					<div class="card-footer">
						<div class="d-flex justify-content-end">
							<button class="btn btn-outline-primary m-1 px-1" type="button" onclick="Regional();"><i class="fa fa-save"></i> <?php echo lang('Guardar'); ?></button>
						</div>
					</div>
				</div>
			</div>

			<div class="tab-pane fade" id="Logotipo" role="tabpanel" aria-labelledby="profile-tab">
				<div class="card">
					<div class="card-header">
						<h5 class="modal-title"><i class="fa fa-image"></i> <?php echo lang("Logotipo"); ?></h5>
					</div>
					<div class="card-body p-1">
						<div id="algojpg2" class="row"></div>
					</div>
				</div>
				<!--
				<div class="card m-b-0">
					<div class="card-block"> <div class="row input-group">
							<div class="col-12">
								<h5 class="card-title pl-2"><?php echo lang('Imagen asociada al comercio, aparecerá para identificar reportes formatos y en el pie de página visualizado.'); ?></h5>
							</div>
						</div>
					</div>
				</div> -->




			</div>

			<div class="tab-pane fade" id="FormasDpago" role="tabpanel" aria-labelledby="contact-tab">
				<div class="card">
					<div class="card-header">
						<h5 class="modal-title"><i class="fa fa-money"></i> <?php echo lang('Formas De Pago'); ?></h5>
					</div>
					<div class="card-body p-1">
						<span id="MonedaPPPP" style="display:none;"><?php echo $Moneda; ?></span>
						<h6 class="modal-title my-1"><?php echo lang("Información solicitada para ventas"); ?></h6>
						<div class="row">
							<div class="col-12 col-md-12  col-lg-3 my-1">
								<div class="form-floating">
									<select class="form-select" id="ValTelefVent" name="ValTelefVent">
										<option value="0"><?php echo lang("Invisible"); ?></option>
										<option value="1"><?php echo lang("Visible"); ?></option>
										<option value="2"><?php echo lang("Visible y Obligatorio"); ?></option>
									</select>
									<label><?php echo lang("Teléfono"); ?></label>
								</div>
							</div>
							<div class="col-12 col-md-6  col-lg-3 my-1">
								<div class="form-floating">
									<select class="form-select" id="ValEmailVent" name="ValEmailVent">
										<option value="0"><?php echo lang("Invisible"); ?></option>
										<option value="1"><?php echo lang("Visible"); ?></option>
										<option value="2"><?php echo lang("Visible y Obligatorio"); ?></option>
									</select>
									<label><?php echo lang("Email"); ?></label>
								</div>
							</div>
							<div class="col-12 col-md-6  col-lg-3 my-1">
								<div class="form-floating">
									<select class="form-select" id="ValComVent" name="ValComVent">
										<option value="0"><?php echo lang("Invisible"); ?></option>
										<option value="1"><?php echo lang("Visible"); ?></option>
										<option value="2"><?php echo lang("Visible y Obligatorio"); ?></option>
									</select>
									<label><?php echo lang("Comuna / Provincia / Region"); ?></label>
								</div>
							</div>
							<div class="col-12 col-md-6 col-lg-3 my-1">
								<div class="form-floating">
									<select class="form-select" id="ValDirVent" name="ValDirVent">
										<option value="0"><?php echo lang("Invisible"); ?></option>
										<option value="1"><?php echo lang("Visible"); ?></option>
										<option value="2"><?php echo lang("Visible y Obligatorio"); ?></option>
									</select>
									<label><?php echo lang("Dirección"); ?></label>
								</div>
							</div>
							<div class="col-12 col-md-6  col-lg-4 my-1">
								<div class="form-floating">
									<select class="form-select" id="ValCiudVent" name="ValCiudVent">
										<option value="0"><?php echo lang("Invisible"); ?></option>
										<option value="1"><?php echo lang("Visible"); ?></option>
										<option value="2"><?php echo lang("Visible y Obligatorio"); ?></option>
									</select>
									<label><?php echo lang("Ciudad"); ?></label>
								</div>
							</div>
							<div class="col-12 col-md-6  col-lg-4 my-1">
								<div class="form-floating">
									<select class="form-select" id="ValGiroVent" name="ValGiroVent">
										<option value="0"><?php echo lang("Invisible"); ?></option>
										<option value="1"><?php echo lang("Visible"); ?></option>
										<option value="2"><?php echo lang("Visible y Obligatorio"); ?></option>
									</select>
									<label><?php echo lang("Giro"); ?></label>
								</div>
							</div>
							<div class="col-12 col-md-6  col-lg-4 my-1">
								<div class="form-floating">
									<select class="form-select" id="ValObsVent" name="ValObsVent">
										<option value="0"><?php echo lang("Invisible"); ?></option>
										<option value="1"><?php echo lang("Visible"); ?></option>
										<option value="2"><?php echo lang("Visible y Obligatorio"); ?></option>
									</select>
									<label><?php echo lang("Observación"); ?></label>
								</div>
							</div>
						</div>
						<h6 class="modal-title my-1"><?php echo lang('Literales de formas de pago utilizadas en todas las transacciones que afecten caja para recibir dinero'); ?></h6>
						<div class="row">
							<div class="col-12 col-md-6 col-lg-4 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalLE" name="ModalLE">
									<label><i class="fa fa-money"></i>&nbsp;<?php echo lang('Literal Efectivo'); ?></label>
								</div>
							</div>

							<div class="col-12 col-md-6 col-lg-4 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalLT" name="ModalLT" />
									<label><i class="fa fa-credit-card"></i>&nbsp;<?php echo lang('Literal Tarjeta'); ?></label>
								</div>
							</div>

							<div class="col-12 col-md-6 col-lg-4 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalLC" name="ModalLC" />
									<label><i class="fa fa-list-alt"></i>&nbsp;<?php echo lang('Literal Cheque'); ?></label>
								</div>
							</div>

							<div class="col-12 col-md-6 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalLFP1" name="ModalLFP1" />
									<label><i class="fa fa-money"></i>&nbsp;<?php echo lang('Literal de Forma de Pago 01'); ?></label>
								</div>
							</div>

							<div class="col-12 col-md-6 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalLFP2" name="ModalLFP2" />
									<label><i class="fa fa-money"></i>&nbsp;<?php echo lang('Literal de Forma de Pago 02'); ?></label>
								</div>
							</div>

							<div class="col-12 col-md-6 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalLFP3" name="ModalLFP3" />
									<label><i class="fa fa-money"></i>&nbsp;<?php echo lang('Literal de Forma de Pago 03'); ?></label>
								</div>
							</div>

							<div class="col-12 col-lg-6 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalLFP4" name="ModalLFP4" />
									<label><i class="fa fa-money"></i>&nbsp;<?php echo lang('Literal de Forma de Pago 04'); ?></label>
								</div>
							</div>
						</div>
						<h6 class="modal-title my-1"><?php echo lang('Literales de formas de pago utilizadas en todas las transacciones que afecten caja para recibir dinero'); ?></h6>
						<div class="row">
							<div class="col-12 col-md-6 col-lg-4 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalCodigoContableLE" name="ModalCodigoContableLE">
									<label><i class="fa fa-money"></i>&nbsp;<?php echo lang('Codigo Contable de Efectivo'); ?></label>
								</div>
							</div>

							<div class="col-12 col-md-6 col-lg-4 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalCodigoContableLT" name="ModalCodigoContableLT" />
									<label><i class="fa fa-credit-card"></i>&nbsp;<?php echo lang('Codigo Contable de Tarjeta'); ?></label>
								</div>
							</div>

							<div class="col-12 col-md-6 col-lg-4 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalCodigoContableLC" name="ModalCodigoContableLC" />
									<label><i class="fa fa-list-alt"></i>&nbsp;<?php echo lang('Codigo Contable de Cheque'); ?></label>
								</div>
							</div>

							<div class="col-12 col-md-6 col-lg-4 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalCodigoContableLFP1" name="ModalCodigoContableLFP1" />
									<label><i class="fa fa-money"></i>&nbsp;<?php echo lang('Codigo Contable de Forma de Pago 01'); ?></label>
								</div>
							</div>

							<div class="col-12 col-md-6 col-lg-4 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalCodigoContableLFP2" name="ModalCodigoContableLFP2" />
									<label><i class="fa fa-money"></i>&nbsp;<?php echo lang('Codigo Contable de Forma de Pago 02'); ?></label>
								</div>
							</div>

							<div class="col-12 col-md-6 col-lg-4 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalCodigoContableLFP3" name="ModalCodigoContableLFP3" />
									<label><i class="fa fa-money"></i>&nbsp;<?php echo lang('Codigo Contable de Forma de Pago 03'); ?></label>
								</div>
							</div>

							<div class="col-12 col-md-6 col-lg-4 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalCodigoContableLFP4" name="ModalCodigoContableLFP4" />
									<label><i class="fa fa-money"></i>&nbsp;<?php echo lang('Codigo Contable de Forma de Pago 04'); ?></label>
								</div>
							</div>

							<div class="col-12 col-md-6 col-lg-4 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalCodigoContableRetencion" name="ModalCodigoContableRetencion" />
									<label><i class="fa fa-money"></i>&nbsp;<?php echo lang('Codigo Contable de Retencion'); ?></label>
								</div>
							</div>

							<div class="col-12 col-md-6 col-lg-4 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalCodigoContableCredito" name="ModalCodigoContableCredito" />
									<label><i class="fa fa-money"></i>&nbsp;<?php echo lang('Codigo Contable de Credito'); ?></label>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="table-responsive" style="<?php echo ($_SESSION['CompanyActual'] !== "133" ? 'display: none;' : ''); ?>">

								<div class="d-flex justify-content-end text-end gap-2" id="spinner_load_DatatableMDP">
									<div><strong class="text-primary fs-6"><?php echo lang('Cargando'); ?></strong></div>
									<div class="spinner-grow text-primary fs-6" role="status" aria-hidden="true" style="width: 1.3rem !important; height: 1.3rem !important;"></div>
								</div>
								<table class="table table-hover table-striped nowrap" id="DatatableMDP" cellspacing="0" style="width:100%">
									<thead>
										<tr>
											<th>#</th>
											<th><?php echo lang('Descripcion') . " " . ($_SESSION["userperfil"] <= 2000 or $_SESSION["userperfil"] == "2055" ? '<button class="btn btn-outline-primary m-1 px-1" type="button" onclick="RecibirMDP(0);"><i class="fa fa-plus"></i> ' . lang("Agregar") . '</button>' : ""); ?></th>
											<th><?php echo lang('Moneda') ?> </th>
											<th><?php echo lang('Afecta Compras') ?> </th>
											<th><?php echo lang('Afecta Ventas') ?> </th>
											<th><i class="fa fa-cogs"></i></th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="d-flex justify-content-end">
							<button class="btn btn-outline-primary m-1 px-1" type="button" onclick="FPS();"><i class="fa fa-save"></i> <?php echo lang('Guardar'); ?></button>
						</div>
					</div>
				</div>
			</div>

			<?php
			if ($FacElec == "1") {
			?>
				<div class="tab-pane fade" id="Certificacion" role="tabpanel">
					<div class="card">
						<div class="card-header">
							<h5 class="modal-title"><i class="fa fa-cog"></i> <?php echo lang('Certificación Electrónica'); ?></h5>
						</div>
						<div class="card-body p-1">
							<h6 class="modal-title my-1"><strong><?php echo lang("Identificación"); ?></strong></h6>

							<div class="row">
								<div class="col-12 col-lg-4 my-1">
									<div class="col">
										<div class="form-floating">
											<input type="text" class="form-control" id="Modalrute" name="Modalrute" readonly />
											<label><i class="fa fa-file-o"></i>&nbsp;<?php echo $_SESSION["litfiscal"] . " " . lang('Empresarial'); ?> </label>
										</div>
									</div>
								</div>

								<div class="col-12 col-lg-4 my-1">
									<div class="col">
										<div class="form-floating">
											<input type="text" class="form-control" id="Modalrazon" name="Modalrazon" />
											<label><i class="fa fa-university"></i>&nbsp;<?php echo lang('Razón Social'); ?> </label>
										</div>
									</div>
								</div>

								<div class="col-12 col-lg-4 my-1">
									<div class="col">
										<div class="form-floating">
											<input type="text" class="form-control" id="ModalGComer" name="ModalGComer" />
											<label><i class="fa fa-university"></i>&nbsp;<?php echo lang('Giro Comercial'); ?> </label>
										</div>
									</div>
								</div>
							</div>
							<h6 class="modal-title my-1"><strong><?php echo lang("Ubicación"); ?></strong></h6>

							<div class="row">
								<div class="col-12 col-lg-4 my-1">
									<div class="col">
										<div class="form-floating">
											<input type="text" class="form-control" id="ModalComuna" name="ModalComuna" />
											<label><i class="fa fa-map-marker"></i>&nbsp;<?php echo lang('Comuna'); ?> </label>
										</div>
									</div>
								</div>

								<div class="col-12 col-lg-4 my-1">
									<div class="col">
										<div class="form-floating">
											<input type="text" class="form-control" id="ModalCiudad" name="ModalCiudad" />
											<label><i class="fa fa-map-marker"></i>&nbsp;<?php echo lang('Ciudad'); ?> </label>
										</div>
									</div>
								</div>

								<div class="col-12 col-lg-4 my-1">
									<div class="col">
										<div class="form-floating">
											<input type="text" class="form-control" id="ModalZonaSII" name="ModalZonaSII" />
											<label><i class="fa fa-map-marker"></i>&nbsp;<?php echo lang('Zona SII'); ?> </label>
										</div>
									</div>
								</div>
							</div>
							<h6 class="modal-title my-1"><strong><?php echo lang("Datos Certificados"); ?></strong></h6>

							<div class="row">
								<div class="col-12 col-lg-6 my-1">
									<div class="col">
										<div class="form-floating">
											<input type="text" class="form-control" id="Modalrutp" name="Modalrutp" />
											<label><i class="fa fa-file-o"></i>&nbsp;<?php echo $_SESSION["litfiscal"] . " " . lang('Personal'); ?> </label>
										</div>
									</div>
								</div>

								<div class="col-12 col-lg-6 my-1">
									<div class="col">
										<div class="form-floating">
											<input type="text" class="form-control" id="Modalnd" name="Modalnd" />
											<label><i class="fa fa-user"></i>&nbsp;<?php echo lang('Nombre Descriptivo'); ?> </label>
										</div>
									</div>
								</div>

							</div>
							<h6 class="modal-title my-1"><strong><?php echo lang("Set Básico"); ?></strong></h6>
							<div class="row">
								<div class="col-12 col-lg-6 my-1">
									<div class="col">
										<div class="form-floating">
											<input type="number" class="form-control" id="Modalnr1" name="Modalnr1" />
											<label><i class="fa fa-hashtag"></i>&nbsp;<?php echo lang('N° Resolución'); ?> </label>
										</div>
									</div>
								</div>
								<div class="col-12 col-lg-6 my-1">
									<div class="col">
										<div class="form-floating">
											<input type="date" class="form-control" id="Modalfr1" name="Modalfr1" />
											<label><i class="fa fa-calendar-o"></i>&nbsp;<?php echo lang('Fecha de Resolución'); ?> </label>
										</div>
									</div>
								</div>
							</div>
							<h6 class="modal-title my-1"><strong><?php echo lang("Boleta"); ?></strong></h6>
							<div class="row">
								<div class="col-12 col-lg-6 my-1">
									<div class="col">
										<div class="form-floating">
											<input type="number" class="form-control" id="Modalnr2" name="Modalnr2" />
											<label><i class="fa fa-hashtag"></i>&nbsp;<?php echo lang('N° Resolución'); ?> </label>
										</div>
									</div>
								</div>

								<div class="col-12 col-lg-6 my-1">
									<div class="col">
										<div class="form-floating">
											<input type="date" class="form-control" id="Modalfr2" name="Modalfr2" />
											<label><i class="fa fa-calendar-o"></i>&nbsp;<?php echo lang('Fecha de Resolución'); ?> </label>
										</div>
									</div>
								</div>
							</div>
							<h6 class="modal-title my-1"><strong><?php echo lang("Guía"); ?></strong></h6>
							<div class="row">
								<div class="col-12 col-lg-6 my-1">
									<div class="col">
										<div class="form-floating">
											<input type="number" class="form-control" id="Modalnr3" name="Modalnr3" />
											<label><i class="fa fa-hashtag"></i>&nbsp;<?php echo lang('N° Resolución'); ?> </label>
										</div>
									</div>
								</div>

								<div class="col-12 col-lg-6 my-1">
									<div class="col">
										<div class="form-floating">
											<input type="date" class="form-control" id="Modalfr3" name="Modalfr3" />
											<label><i class="fa fa-calendar-o"></i>&nbsp;<?php echo lang('Fecha Resolución'); ?> </label>
										</div>
									</div>
								</div>
							</div>
							<h6 class="modal-title my-1"><strong><?php echo lang("Exportación"); ?></strong></h6>
							<div class="row">
								<div class="col-12 col-lg-6 my-1">
									<div class="col">
										<div class="form-floating">
											<input type="number" class="form-control" id="Modalnr4" name="Modalnr4" />
											<label><i class="fa fa-hashtag"></i>&nbsp;<?php echo lang('N° Resolución'); ?> </label>
										</div>
									</div>
								</div>

								<div class="col-12 col-lg-6 my-1">
									<div class="col">
										<div class="form-floating">
											<input type="date" class="form-control" id="Modalfr4" name="Modalfr4" />
											<label><i class="fa fa-calendar-o"></i>&nbsp;<?php echo lang('Fecha de Resolución'); ?> </label>
										</div>
									</div>
								</div>
							</div>







							<div class="row">
								<div class="col-6 my-1">
									<div class="btn-group">
										<button class="btn btn-outline-dark px-1 m-1" onclick="ElegirCertificacion(0)"><i class="fa fa-cog"></i> <?php echo lang("Iniciar Proceso de Certificación"); ?></button>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-12 my-1">
									<span id="ActividadesEconomicasSpam"></span>
								</div>
							</div>

						</div>
						<div class="card-footer">
							<div class="d-flex justify-content-end">
								<button class="btn btn-outline-primary m-1 px-1" type="button" onclick="guardarCertificacionElect();"><i class="fa fa-save"></i> <?php echo lang('Guardar'); ?></button>
							</div>
						</div>
					</div>
				</div>

				<div class="tab-pane fade" id="Firma" role="tabpanel" aria-labelledby="profile-tab">
					<div class="card">
						<div class="card-header">
							<h5 class="modal-title"><i class="fa fa-lock"></i> <?php echo lang('Firma Electrónica (PFX P12)'); ?></h5>
						</div>
						<div class="card-body p-1">
							<div class="row">
								<span id="CEspam"></span>
								<input class="form-control" type="hidden" name="nombre_archivo" id="nombre_archivo" value="<?php echo $_POST["CompanyActual"]; ?>" readonly>

								<div class="col-12 my-1">
									<input class='form-control' type="file" name="archivo" id="archivo" />
								</div>


								<div class="col-12  my-1">
									<div class="progress">
										<div id='barra_de_progreso' class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemax="100"></div>
									</div>
								</div>
								<div class="col-12 col-lg-6 my-1">
									<div class="col">
										<div class="form-floating">
											<input class="form-control" type="password" name="Contraseña1" id="Contraseña1">
											<label><i class="fa fa-expeditedssl"></i>&nbsp;<?php echo lang('Contraseña del pfx'); ?></label>
										</div>
									</div>
								</div>
								<div class="col-12 col-lg-6 my-1">
									<div class="col">
										<div class="form-floating">
											<input class="form-control" type="password" name="Contraseña2" id="Contraseña2">
											<label><i class="fa fa-expeditedssl"></i>&nbsp;<?php echo lang('Repetir Contraseña'); ?></label>
										</div>
									</div>
								</div>
								<div id="Comercio"></div>
								<span id="ERROR" style="color:red"></span>
								<input type="hidden" name="CertificadoElectronicoProceso" id="CertificadoElectronicoProceso" value="1">
							</div>
						</div>

						<div class="card-footer">
							<div class="d-flex justify-content-end">
								<button class="btn btn-outline-primary m-1 px-1" type="button" onclick="presubida();"><i class="fa fa-save"></i> <?php echo lang('Guardar'); ?></button>
							</div>
						</div>
					</div>
				</div>

				<div class="tab-pane fade" id="CAF" role="tabpanel" aria-labelledby="contact-tab">
					<div class="card">
						<div class="card-header">
							<h5 class="modal-title"><i class="fa fa-file-text-o"></i> <?php echo lang('CAF'); ?></h5>
						</div>
						<div class="card-body p-1">
							<div class="col-12 my-1">
								<div class="form-floating">
									<select class="form-control" name="TipodeCaf" id="TipodeCaf" onchange="MuestraProd();">
										<option value="*"><?php echo lang("Todos"); ?></option>
										<option value="30"><?php echo lang("Factura"); ?></option>
										<option value="33"><?php echo lang("Factura Electronica"); ?></option>
										<option value="34"><?php echo lang("Factura Electronica Exenta"); ?></option>
										<option value="39"><?php echo lang("Boleta Electronica"); ?></option>
										<option value="41"><?php echo lang("Boleta Electronica Exenta"); ?></option>
										<option value="46"><?php echo lang("Factura Compra Electronica"); ?></option>
										<option value="52"><?php echo lang("Guia Despacho Electronica"); ?></option>
										<option value="56"><?php echo lang("Nota Debito Electronica"); ?></option>
										<option value="60"><?php echo lang("Nota de Credito"); ?></option>
										<option value="61"><?php echo lang("Nota de Credito Electronica"); ?></option>
										<option value="110"><?php echo lang("Factura de Exportacion Electronica"); ?></option>
										<option value="111"><?php echo lang("Nota de Debito Exportacion Electronica"); ?></option>
										<option value="112"><?php echo lang("Nota de Credito Exportacion Electronica"); ?></option>
									</select>
									<label><i class="fa fa-file-text-o"></i>&nbsp;<?php echo lang('Tipo CAF'); ?></label>

								</div>
							</div>

							<div class="table-responsive">
								<table class="table table-hover table-striped nowrap" id="DatatableConPro" cellspacing="0" style="width:100%">
									<thead>
										<tr>
											<th><?php echo lang('Tipo') ?> <button class="btn btn-outline-primary m-1 px-1" onclick="recibir5();"><span class="fa fa-plus"></span> <?php echo lang("Agregar"); ?> </button> </th>
											<th><?php echo lang('Folio Actual') ?> </th>
											<th><?php echo lang('Emisión') ?> </th>
											<th><?php echo lang('Desde') ?> </th>
											<th><?php echo lang('Hasta') ?> </th>
											<th><?php echo lang('Estado') ?> </th>
										</tr>
									</thead>
								</table>
							</div>

							<div id="devueltacaf">
								<span style="display:none" id="PagAct">1</span>
								<span style="display:none" id="Rpa">1</span>
								<input style="display:none" type="text" name="Limit" id="Limit" value="10">
							</div>
						</div>
					</div>
				</div>
			<?php
			}
			?>

			<div class="tab-pane fade" id="Procesos" role="tabpanel">
				<div class="card">
					<div class="card-header">
						<h5 class="modal-title"><i class="fa fa-file-code-o"></i> <?php echo lang('Gestor de Scripts'); ?></h5>
					</div>
					<div class="card-body p-1">
						<div class="row">
							<div class="col-12 col-lg-6 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" id="Modalscrpttablas" name="Modalscrpttablas" onchange="buttondisabledable();" />
									<label><i class="fa fa-code"></i> <?php echo lang('Script Tablas') ?></label>
								</div>
							</div>
							<div class="col-12 col-lg-6 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" id="Modalscrptprocesos" name="Modalscrptprocesos" onchange="buttondisabledable();" />
									<label><i class="fa fa-code"></i> <?php echo lang('Script Procesos') ?></label>
								</div>
							</div>
							<div class="col-12 col-lg-12 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" id="Modalscrptdownloadprod" name="Modalscrptdownloadprod" onchange="buttondisabledable();" />
									<label><i class="fa fa-code"></i> <?php echo lang('Script de descarga de productos') ?></label>
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="d-flex justify-content-end">
							<button class="btn btn-outline-primary m-1 px-1" id="buttonscript" type="button" onclick="safeprocesos();"><i class="fa fa-save"></i> <?php echo lang('Guardar'); ?></button>
						</div>
					</div>
				</div>
				<span class="d-none" id="spanprocces"></span>
			</div>
			<div class="tab-pane fade" id="Literales" role="tabpanel">
				<div class="card">
					<div class="card-header">
						<h5 class="modal-title"><i class="fa fa-file-code-o"></i> <?php echo lang('Literales'); ?></h5>
					</div>
					<div class="card-body p-1">
						<div class="row">
							<div class="col-12 col-lg-4 my-1">
								<div class="col">
									<div class="form-floating">
										<input class="form-control" type="text" name="LitP01Input" id="LitP01Input">
										<label>&nbsp;<?php echo lang('Literal de Precio') . " 01"; ?></label>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-4 my-1">
								<div class="col">
									<div class="form-floating">
										<input class="form-control" type="text" name="LitP02Input" id="LitP02Input">
										<label>&nbsp;<?php echo lang('Literal de Precio') . " 02"; ?></label>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-4 my-1">
								<div class="col">
									<div class="form-floating">
										<input class="form-control" type="text" name="LitP03Input" id="LitP03Input">
										<label>&nbsp;<?php echo lang('Literal de Precio') . " 03"; ?></label>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-4 my-1">
								<div class="col">
									<div class="form-floating">
										<input class="form-control" type="text" name="LitP04Input" id="LitP04Input">
										<label>&nbsp;<?php echo lang('Literal de Precio') . " 04"; ?></label>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-4 my-1">
								<div class="col">
									<div class="form-floating">
										<input class="form-control" type="text" name="LitP05Input" id="LitP05Input">
										<label>&nbsp;<?php echo lang('Literal de Precio') . " 05"; ?></label>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-4 my-1">
								<div class="col">
									<div class="form-floating">
										<input class="form-control" type="text" name="LitP06Input" id="LitP06Input">
										<label>&nbsp;<?php echo lang('Literal de Precio') . " 06"; ?></label>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-4 my-1">
								<div class="col">
									<div class="form-floating">
										<input class="form-control" type="text" name="LitP07Input" id="LitP07Input">
										<label>&nbsp;<?php echo lang('Literal de Precio') . " 07"; ?></label>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-4 my-1">
								<div class="col">
									<div class="form-floating">
										<input class="form-control" type="text" name="LitP08Input" id="LitP08Input">
										<label>&nbsp;<?php echo lang('Literal de Precio') . " 08"; ?></label>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-4 my-1">
								<div class="col">
									<div class="form-floating">
										<input class="form-control" type="text" name="LitP09Input" id="LitP09Input">
										<label>&nbsp;<?php echo lang('Literal de Precio') . " 09"; ?></label>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-6 my-1">
								<div class="col">
									<div class="form-floating">
										<input class="form-control" type="text" name="LitP10Input" id="LitP10Input">
										<label>&nbsp;<?php echo lang('Literal de Precio') . " 10"; ?></label>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-6 my-1">
								<div class="col">
									<div class="form-floating">
										<input class="form-control" type="text" name="LitCostoInput" id="LitCostoInput">
										<label>&nbsp;<?php echo lang('Costo'); ?></label>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="d-flex justify-content-end">
							<button class="btn btn-outline-primary m-1 px-1" id="buttonscript" type="button" onclick="literalesSave();"><i class="fa fa-save"></i> <?php echo lang('Guardar'); ?></button>
						</div>
					</div>
				</div>
			</div>
			<div class="tab-pane fade" id="SMTP" role="tabpanel">
				<div class="card">
					<div class="card-header">
						<h5 class="modal-title"><i class="fa fa-envelope"></i> <?php echo lang('Correo Eléctronico'); ?></h5>
					</div>
					<div class="card-body p-1">
						<div class="row">
							<div class="col-12 col-lg-6 my-1">
								<div class="col">
									<div class="form-floating">
										<input class="form-control" type="text" name="EmailSMTP" id="EmailSMTP">
										<label>&nbsp;<?php echo lang('Email'); ?></label>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-6 my-1">
								<div class="col">
									<div class="form-floating">
										<input class="form-control" type="text" name="ServerSMTP" id="ServerSMTP">
										<label>&nbsp;<?php echo lang('Server'); ?></label>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-6 my-1">
								<div class="col">
									<div class="form-floating">
										<input class="form-control" type="number" name="PuertoSMTP" id="PuertoSMTP">
										<label>&nbsp;<?php echo lang('Puerto'); ?></label>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-6 my-1">
								<div class="col">
									<div class="form-floating">
										<input class="form-control" type="text" name="PasswordSMTP" id="PasswordSMTP">
										<label>&nbsp;<?php echo lang('Password'); ?></label>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="card-footer">
						<div class="d-flex justify-content-end">
							<button class="btn btn-outline-primary m-1 px-1" id="buttonscript" type="button" onclick="smtpSave();"><i class="fa fa-save"></i> <?php echo lang('Guardar'); ?></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="apps-modal" class="modal fade" tabindex="-1" role="dialog" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"> <?php echo lang("Certificación Electrónica"); ?> <span id="CerCerCertificado"></span></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="FacturaElectronicaFase0">
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item" role="presentation">
							<button class="nav-link active" id="Fase1Tab" data-bs-toggle="tab" data-bs-target="#Fase1" type="button" role="tab" aria-controls="home" aria-selected="true"><?php echo lang('Fase 1'); ?></button>
						</li>
						<li class="nav-item" role="presentation">
							<button class="nav-link" id="Fase2Tab" data-bs-toggle="tab" data-bs-target="#Fase2" type="button" role="tab" aria-controls="home" aria-selected="true"><?php echo lang('Fase 2'); ?></button>
						</li>
						<li class="nav-item" role="presentation">
							<button class="nav-link" id="Fase3Tab" data-bs-toggle="tab" data-bs-target="#Fase3" type="button" role="tab" aria-controls="home" aria-selected="true"><?php echo lang('Fase 3'); ?></button>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="Fase1">
							<div class="row p-1" id="MostrarSubirArchivoCer">
								<div class="col-9 p-1">
									<label><?php echo lang("Seleccionar Para Subir Archivo (txt)"); ?></label>
									<input class="form-control" type="file" name="subirarchivotxt" id="subirarchivotxt" accept="application/txt, .txt" />
								</div>
								<div class="col-3 p-1">
									<br>
									<button class="btn btn-outline-primary fs-6 p-1 m-1" id="buttonact" onclick="subirtxtcertificacion()"><?php echo lang("Subir Archivo"); ?></button>
								</div>
							</div>
							<div class="row p-1" id="TextoEnSetBasico">
								<div class="col-12 col-lg-12 p-1">
									<div class="input-group">
										<div class="col">
											<div class="form-floating">
												<input type="text" class="form-control" value="SIISetDePruebas.txt" readonly>
												<label><?php echo lang("Set de Pruebas - Factura"); ?></label>
											</div>
										</div>
										<a class="btn btn-outline-primary p-1" href='<?php echo "Comercio/" . $_SESSION['CompanyActual'] . "/certificacion/certificaciontxt.txt"; ?>' download="SIISetDePruebas.txt"><i class="fa fa-arrow-down pt-3"></i></a>
									</div>
								</div>
							</div>
							<div class="col-12" id="MostrarResultado">
								<span id="jsonresponse"></span>
							</div>
							<div class="col-12 text-center" id="MostrarCargando">
								<img src="/img/procesando.gif" width="128" height="128" />
								<h4><?php echo lang("Cargando"); ?></h4>
							</div>
							<div class="col-12 text-center" id="MostrarError">
								<img src="/img/emailerror.png " width="128" height="128" />
								<h4><?php echo lang("Error al subir el archivo"); ?></h4>
							</div>
						</div>
						<div class="tab-pane" id="Fase2">
							<div class="row p-1">
								<div class="col-12" id="MostrarSubirArchivoSim">
									<?php echo lang("Generar los DTE del periodo de simulación"); ?>
									<button class="btn btn-outline-dark p-1 m-1" type="button" id="botoniniciasim" onclick="IniciarSimulacion();"><?php echo lang("Generar"); ?></button>
								</div>
								<div class="col-12" id="MostrarResultadofas2">
									<span id="jsonresponsefase2" style="display:none;"></span>
								</div>
								<div class="col-12 text-center" id="MostrarCargando2">
									<img src="/img/procesando.gif" width="128" height="128" />
									<h4><?php echo lang("Cargando"); ?></h4>
								</div>
							</div>
						</div>
						<div class="tab-pane" id="Fase3">
							<div class="row p-1">
								<div class="row p-1" id="MostrarSubirArchivoInter">
									<div class="col-9 p-1">
										<label><?php echo lang("Seleccionar Para Subir Archivo (xml)"); ?></label>
										<input class="form-control" type="file" name="subirarchivoxml" id="subirarchivoxml" accept="application/xml, .xml" />
									</div>
									<div class="col-3 p-1">
										<br>
										<button class="btn btn-outline-primary fs-6 p-1 m-1" id="buttonactfas3" onclick="subirxmlinter()"><?php echo lang("Subir Archivo"); ?></button>
									</div>
								</div>
								<div class="row p-1" id="TextoEnSetInterCambio">
									<div class="col-12 col-lg-12 p-1">
										<div class="input-group">
											<div class="col">
												<div class="form-floating">
													<input type="text" class="form-control" value="SetIntercambios.xml" readonly>
													<label><?php echo lang("Set de Intercambios"); ?></label>
												</div>
											</div>
											<a class="btn btn-outline-primary p-1" href='<?php echo "Comercio/" . $_SESSION['CompanyActual'] . "/certificacion/SetIntercambios.xml"; ?>' download="SetIntercambios.xml"><i class="fa fa-arrow-down pt-3"></i></a>
										</div>
									</div>
								</div>
								<div class="col-12" id="MostrarResultadofas3">
									<span id="jsonresponsefase3" style="display:none;"></span>
								</div>
								<div class="col-12 text-center" id="MostrarCargando3">
									<img src="/img/procesando.gif" width="128" height="128" />
									<h4><?php echo lang("Cargando"); ?></h4>
								</div>
								<div class="col-12 text-center" id="MostrarError3">
									<img src="/img/emailerror.png " width="128" height="128" />
									<h4><?php echo lang("Error al subir el archivo"); ?></h4>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="BoletaElectronicaFase0">
					<ul class="nav nav-tabs" id="myTa2b" role="tablist">
						<li class="nav-item" role="presentation">
							<button class="nav-link active" id="Fase1TabBol" data-bs-toggle="tab" data-bs-target="#Fase1Bol" type="button" role="tab" aria-controls="home" aria-selected="true"><?php echo lang('Fase 1'); ?></button>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="Fase1Bol">
							<div class="row p-1" id="MostrarSubirArchivoCerBol">
								<div class="col-9 p-1">
									<label><?php echo lang("Seleccionar Para Subir Archivo (txt)"); ?></label>
									<input class="form-control" type="file" name="subirarchivotxtBol" id="subirarchivotxtBol" accept="application/txt, .txt" />
								</div>
								<div class="col-3 p-1">
									<br>
									<button class="btn btn-outline-primary fs-6 p-1 m-1" type="button" id="ButtonBol001" onclick="SubirBoletaCer();"><?php echo lang("Subir Archivo"); ?></button>
								</div>
							</div>
							<div class="row p-1" id="TextoEnSetBasicoBol">
								<div class="col-12 col-lg-12 p-1">
									<div class="input-group">
										<div class="col">
											<div class="form-floating">
												<input type="text" class="form-control" value="SIISetDePruebasBoleta.txt" readonly>
												<label><?php echo lang("Set de Pruebas - Boleta"); ?></label>
											</div>
										</div>
										<a class="btn btn-outline-primary p-1" href='<?php echo "Comercio/" . $_SESSION['CompanyActual'] . "/certificacion/certificaciontxtBoleta.txt"; ?>' download="SIISetDePruebasBoleta.txt"><i class="fa fa-arrow-down pt-3"></i></a>
										<button class="btn btn-outline-danger fs-6 p-1" type="button" id="ButtonBol003" onclick='$("#apps-delet").modal("show");'><i class="fa fa-trash"></i></button>
									</div>
								</div>
							</div>
							<div class="col-12" id="MostrarResultadoBol001">
								<span id="jsonresponseBoleta"></span>
							</div>
							<div class="col-12 text-center" id="MostrarCargandoBol001">
								<img src="/img/procesando.gif" width="128" height="128" />
								<h4><?php echo lang("Cargando"); ?></h4>
							</div>
							<div class="col-12 text-center" id="MostrarErrorBol001">
								<img src="/img/emailerror.png " width="128" height="128" />
								<h4><?php echo lang("Error al subir el archivo"); ?></h4>
							</div>
						</div>
					</div>
				</div>
				<div id="MenuPrincipalElectronico">
					<button class="btn btn-outline-dark p-1 m-1" type="button" onclick="ElegirCertificacion(1);"> <?php echo lang("Certificador de Factura Electrónica"); ?> </button>
					<button class="btn btn-outline-dark p-1 m-1" type="button" onclick="ElegirCertificacion(2);"> <?php echo lang("Certificador de Boleta Electrónica"); ?> </button>
				</div>
			</div>
			<div class="modal-footer" id="MostrarSiAvanzar"></div>
		</div>
	</div>
</div>

<div id="apps-mdp" class="modal fade" tabindex="-1" role="dialog" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"> <?php echo lang("Medios de Pago"); ?> </h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body p-1">
				<div id="alertaborrarm"></div>
				<div class="row">

					<div class="col-12 col-lg-6 my-1">
						<div class="col">
							<div class="form-floating">
								<input type="text" name="DescripcionMDP" id="DescripcionMDP" class="form-control">
								<label for="DescripcionMDP"><?php echo lang("Descripcion"); ?></label>
							</div>
						</div>
					</div>

					<div class="col-12 col-lg-4 my-1">
						<div class="col">
							<div class="form-floating">
								<input type="text" name="AbreviacionMdp" id="AbreviacionMdp" class="form-control">
								<label for="AbreviacionMdp"><?php echo lang("Abreviación"); ?></label>
							</div>
						</div>
					</div>

					<div class="col-12 col-lg-2 my-1">
						<div class="col">
							<div class="form-floating">
								<input type="number" name="ordenmdp" id="ordenmdp" class="form-control text-end">
								<label for="ordenmdp"><?php echo lang("Orden"); ?></label>
							</div>
						</div>
					</div>

					<div class="col-12 col-lg-6 my-1">
						<div class="col">
							<div class="form-floating">
								<select name="SucursalMDP" id="SucursalMDP" class="form-select">
									<option value="-"><?php echo lang("Seleccionar"); ?></option>
									<?php echo $SucursalMDP; ?>
								</select>
								<label for="DescripcionMDP"><?php echo lang("Sucursal"); ?></label>
							</div>
						</div>
					</div>

					<div class="col-12 col-lg-6 my-1">
						<div class="col">
							<div class="form-floating">
								<select name="MonedaMDP" id="MonedaMDP" class="form-select">
									<option value="0"><?php echo lang("Ninguno"); ?></option>
									<?php echo $MonedaMdp; ?>
								</select>
								<label for="DescripcionMDP"><?php echo lang("Moneda"); ?></label>
							</div>
						</div>
					</div>

					<div class="col-12 col-lg-4 my-1">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="AfecCompras" id="AfecCompras">
							<label class="form-check-label" for="AfecCompras">
								<?php echo lang("Afecta Compras"); ?>
							</label>
						</div>
					</div>

					<div class="col-12 col-lg-4 my-1">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="AfecVentas" id="AfecVentas">
							<label class="form-check-label" for="AfecVentas">
								<?php echo lang("Afecta Ventas"); ?>
							</label>
						</div>
					</div>

					<div class="col-12 col-lg-4 my-1">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="TipoEfectivoMDP" id="TipoEfectivoMDP">
							<label class="form-check-label" for="TipoEfectivoMDP">
								<?php echo lang("Tipo Efectivo"); ?>
							</label>
						</div>
					</div>

					<div class="col-12 col-lg-4 my-1">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="ControlDelFlujoMDP" id="ControlDelFlujoMDP">
							<label class="form-check-label" for="ControlDelFlujoMDP">
								<?php echo lang("Control del flujo de dinero"); ?>
							</label>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-outline-secondary m-1 px-1" type="button" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang("Cerrar"); ?></button>
				<button class="btn btn-outline-primary m-1 px-1" type="button" id="UpdateMDP" onclick="GuardarMDP()"><i class="fa fa-save"></i> <?php echo lang("Guardar"); ?></button>
			</div>
		</div>
	</div>
</div>

<div id="apps-delet" class="modal fade" tabindex="-1" role="dialog" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header bg-danger text-light">
				<h5 class="modal-title"><i class="fa fa-trash"></i> <?php echo lang('Borrar Certificado'); ?></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="BorrarCertificadoAlert"></div>
				<div class="row float-center text-center">
					<div class="col-12">
						<img src="img/warningtriangle.gif" style="width: 128px;">
					</div>
					<div class="col-12">
						<h3><strong><?php echo lang("¿Esta Seguro?"); ?></strong></h3>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-outline-secondary px-1 m-1" type="button" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?></button>
				<button class="btn btn-outline-danger px-1 m-1" type="button" onclick="DeleteBoletaCer();" id="ButtonBol002"><i class="fa fa-trash"></i> <?php echo lang('Si, bórralo!'); ?></button>
			</div>
		</div>
	</div>
</div>

<div id="apps-delet2" class="modal fade" tabindex="-1" role="dialog" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header bg-danger text-light">
				<h5 class="modal-title"><i class="fa fa-trash"></i> <?php echo lang('Eliminar Registro'); ?></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="BorrarCertificadoAlert2"></div>
				<div class="row float-center text-center">
					<div class="col-12">
						<img src="img/warningtriangle.gif" style="width: 128px;">
					</div>
					<div class="col-12">
						<div>
							<h3><strong><?php echo lang("¿Esta Seguro?"); ?></strong></h3>
						</div>
						<div>
							<h5><?php echo lang("Se va a eliminar el registro") . " "; ?> <strong id='RegistroEliminarName'></strong></h5>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-outline-secondary px-1 m-1" type="button" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?></button>
				<button class="btn btn-outline-danger px-1 m-1" type="button" onclick="DeleteRegistroMDP();"><i class="fa fa-trash"></i> <?php echo lang('Si, bórralo!'); ?></button>
			</div>
		</div>
	</div>
</div>

<div id="apps-modal5" class="modal fade" tabindex="-1" role="dialog" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-plus"></i> <?php echo lang("CAF"); ?></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="alertaerrorenproducto5"></div>
				<form action="javascript:void(0);" id="algo" name="algo">
					<div class="row p-1">
						<div class="col-12 p-1">
							<label for="abc"><?php echo lang('Seleccionar Para Subir Archivo (CAF)'); ?></label>
							<input class="form-control" type="file" name="archivo2" id="archivo2" accept="application/xml, .xml" onchange="subircaf2()" />
						</div>
						<div class="col-12 p-1">
							<div class="progress"></div>
							<div id="barra_de_progreso2" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemax="100"></div>
						</div>
					</div>

					<div class="col-12 p-1">
						<div class="container">
							<span id="mostrarcaf"></span>
						</div>
					</div>
					<div id="Comercio"></div>
				</form>
				<input type="hidden" name="Fectxclient" id="Fectxclient">
				<input type="hidden" name="litfiscal" id="litfiscal" value="<?php echo $_SESSION["litfiscal"]; ?>">
			</div>
			<div class="modal-footer">
				<button class="btn btn-outline-secondary m-1 px-1" type="button" onclick="limpiar();"><i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?></button>
				<span id="puesnada"></span>
			</div>
		</div>
	</div>
</div>

<div id="ver-foto-modal" class="modal fade" tabindex="-1" role="dialog" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-lg modal-dialog modal-dialog-top">
		<div class="modal-content">
			<div class="card m-b-0">
				<div class="card-header bg-app bg-inverse">
					<h4>Foto Ampliada</h4>
				</div>
				<div class="card-block">
					<span id="verimagenampliada"></span>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<div id="apps-modal4" class="modal fade" tabindex="-1" role="dialog" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-image"></i> <?php echo lang("Imagenes de los Medios de Pago"); ?></h5>
				<button data-bs-dismiss="modal" class="btn-close" type="button"></button>
			</div>
			<div class="modal-body p-1" id="ModalImagenes">
			</div>
			<div class="modal-footer">
				<button class="btn btn-outline-secondary px-1 m-1" type="button" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?></button>
			</div>
		</div>
	</div>
</div>

<span id="Temporal" style="display:none;"></span>
<script src="jsdev/entorno.js?v=<? echo random_int(1, 9999999); ?>"></script>
<script>
	function stringImptxCompany() {
		var values = $('#ImptxCompany').val();
		$('#mRegUnoImptxCompany').html(values.toString());
	};
	const FacElec = <?php echo $FacElec; ?>;

	const Utils = {
		"mensajemostrar001": '<?php echo lang("¿Esta Seguro?"); ?>',
		"mensajemostrar002": '<?php echo lang("¿Esta Seguro de eliminar?"); ?>',
		"Cargando": '<?php echo lang("Cargando"); ?>',
	}

	const Success = {
		"title": "<?php echo lang('Guardado con exito'); ?>",
		"desc": "<?php echo lang('Tu informacion ha sido guardada correctamente.'); ?>",
	}
	const Danger = {
		"title": "<?php echo lang('Error al guardar'); ?>",
		"desc": "<?php echo lang('Se ha producido un error durante el guardado.'); ?>",
	}
	const Num001 = {
		"title": "<?php echo lang('Falta Información'); ?>",
		"desc": "<?php echo lang('El campo de Literal de Forma de Pago 01 no puede quedar vacio a menos de que el cambio de tasa sea menor o igual a 1.'); ?>",
	}

	const Num002 = {
		"title": "<?php echo lang('Falta Información'); ?>",
		"desc": "<?php echo lang('Factores deben ser numéricos, puede dejar en blanco si no lo va utilizar') ?>",
	}

	const Num003 = {
		"title": "<?php echo lang('Orden Inválido'); ?>",
		"desc": "<?php echo lang('El campo de Literal de Forma de Pago 03 no puede quedar vacio si el Literal de Forma de Pago 04 esta en uso.'); ?>",
	}

	const Num004 = {
		"title": "<?php echo lang('Orden Inválido'); ?>",
		"desc": "<?php echo lang('El campo de Literal de Forma de Pago 02 no puede quedar vacio si el Literal de Forma de Pago 03 esta en uso.'); ?>",
	}

	const Num005 = {
		"title": "<?php echo lang('Orden Inválido'); ?>",
		"desc": "<?php echo lang('El campo de Literal de Forma de Pago 02 no puede quedar vacio si el Literal de Forma de Pago 04 esta en uso.'); ?>",
	}

	const Num006 = {
		"title": "<?php echo lang('Orden Inválido'); ?>",
		"desc": "<?php echo lang('El campo de Literal de Forma de Pago 01 no puede quedar vacio si el Literal de Forma de Pago 02 esta en uso.'); ?>",
	}

	const Num007 = {
		"title": "<?php echo lang('Orden Inválido'); ?>",
		"desc": "<?php echo lang('El campo de Literal de Forma de Pago 01 no puede quedar vacio si el Literal de Forma de Pago 03 esta en uso.'); ?>",
	}

	const Num008 = {
		"title": "<?php echo lang('Orden Inválido'); ?>",
		"desc": "<?php echo lang('El campo de Literal de Forma de Pago 01 no puede quedar vacio si el Literal de Forma de Pago 04 esta en uso.'); ?>",
	}

	const Num009 = {
		"title": "<?php echo lang('Orden Inválido'); ?>",
		"desc": "<?php echo lang('El campo de Literal Cheque no puede quedar vacio si el Literal de Forma de Pago 01 esta en uso.'); ?>",
	}

	const Num010 = {
		"title": "<?php echo lang('Orden Inválido'); ?>",
		"desc": "<?php echo lang('El campo de Literal Cheque no puede quedar vacio si el Literal de Forma de Pago 02 esta en uso.'); ?>",
	}

	const Num011 = {
		"title": "<?php echo lang('Orden Inválido'); ?>",
		"desc": "<?php echo lang('El campo de Literal Cheque no puede quedar vacio si el Literal de Forma de Pago 03 esta en uso.'); ?>",
	}

	const Num012 = {
		"title": "<?php echo lang('Orden Inválido'); ?>",
		"desc": "<?php echo lang('El campo de Literal Cheque no puede quedar vacio si el Literal de Forma de Pago 04 esta en uso.'); ?>",
	}

	const Num013 = {
		"title": "<?php echo lang('Orden Inválido'); ?>",
		"desc": "<?php echo lang('El campo de Literal Tarjeta no puede quedar vacio si el Literal de Cheque esta en uso.'); ?>",
	}

	const Num014 = {
		"title": "<?php echo lang('Orden Inválido'); ?>",
		"desc": "<?php echo lang('El campo de Literal Tarjeta no puede quedar vacio si el Literal de Forma de Pago 01 esta en uso.'); ?>",
	}

	const Num015 = {
		"title": "<?php echo lang('Orden Inválido'); ?>",
		"desc": "<?php echo lang('El campo de Literal Tarjeta no puede quedar vacio si el Literal de Forma de Pago 02 esta en uso.'); ?>",
	}

	const Num016 = {
		"title": "<?php echo lang('Orden Inválido'); ?>",
		"desc": "<?php echo lang('El campo de Literal Tarjeta no puede quedar vacio si el Literal de Forma de Pago 03 esta en uso.'); ?>",
	}

	const Num017 = {
		"title": "<?php echo lang('Orden Inválido'); ?>",
		"desc": "<?php echo lang('El campo de Literal Tarjeta no puede quedar vacio si el Literal de Forma de Pago 04 esta en uso.'); ?>",
	}

	const Num018 = {
		"title": "<?php echo lang('Orden Inválido'); ?>",
		"desc": "<?php echo lang('El campo de Literal Efectivo no puede quedar vacio si el Literal de Tarjeta esta en uso.'); ?>",
	}

	const Num019 = {
		"title": "<?php echo lang('Orden Inválido'); ?>",
		"desc": "<?php echo lang('El campo de Literal Efectivo no puede quedar vacio si el Literal de Cheque esta en uso.'); ?>",
	}

	const Num020 = {
		"title": "<?php echo lang('Orden Inválido'); ?>",
		"desc": "<?php echo lang('El campo de Literal Efectivo no puede quedar vacio si el Literal de Forma de Pago 01 esta en uso.'); ?>",
	}

	const Num021 = {
		"title": "<?php echo lang('Orden Inválido'); ?>",
		"desc": "<?php echo lang('El campo de Literal Efectivo no puede quedar vacio si el Literal de Forma de Pago 02 esta en uso.'); ?>",
	}

	const Num022 = {
		"title": "<?php echo lang('Orden Inválido'); ?>",
		"desc": "<?php echo lang('El campo de Literal Efectivo no puede quedar vacio si el Literal de Forma de Pago 03 esta en uso.'); ?>",
	}

	const Num023 = {
		"title": "<?php echo lang('Orden Inválido'); ?>",
		"desc": "<?php echo lang('El campo de Literal Efectivo no puede quedar vacio si el Literal de Forma de Pago 04 esta en uso.'); ?>",
	}

	const Num024 = {
		"title": "<?php echo lang('Orden Inválido'); ?>",
		"desc": "<?php echo lang('El campo de Literal Efectivo no puede quedar vacio si el Literal de Forma de Pago 01 esta en uso.'); ?>",
	}

	const Num025 = {
		"title": "<?php echo lang('Seleccionar Precio'); ?>",
		"desc": "<?php echo lang('Seleccione al menos un Precio entre Precio 1 , Precio 2 o Precio 3.'); ?>",
	}

	const Num026 = {
		"title": "<?php echo lang('Seleccionar Unidad'); ?>",
		"desc": "<?php echo lang('Seleccione al menos una Unidad.'); ?>",
	};

	const Num027 = {
		"title": "<?php echo lang('No Coinciden las Contraseñas'); ?>",
		"desc": "<?php echo lang('Las contraseñas no coinciden entre si.'); ?>",
	};

	const Num028 = {
		"title": "<?php echo lang('Falta archivo CAF'); ?>",
		"desc": "<?php echo lang('Ingresa el archivo caf.'); ?>",
	};

	const Num029 = {
		"title": "<?php echo lang('Error Archivo CAF'); ?>",
		"desc": "<?php echo lang('Error al subir archivo CAF.'); ?>",
	};

	const Num030 = {
		"title": "<?php echo lang('Error Archivo CAF'); ?>",
		"desc": "<?php echo lang('El archivo CAF es invalido.'); ?>",
	};

	const Num032 = {
		"title": "<?php echo lang('Error Archivo CAF'); ?>",
		"desc": "<?php echo lang('Este archivo CAF no pertenece a su comercio.'); ?>",
	};

	const Num033 = {
		"title": "<?php echo lang('Error Archivo CAF'); ?>",
		"desc": "<?php echo lang('Este archivo CAF ya existe.'); ?>",
	};

	const Num034 = {
		"title": "<?php echo lang('Error Archivo CAF'); ?>",
		"desc": "<?php echo lang('Verifique que el archivo o la contraseña esten correctos.'); ?>",
	};

	const Num035 = {
		"title": "<?php echo lang('Falta Información'); ?>",
		"desc": "<?php echo lang('El Campo de Descripcion no puede estar vacio'); ?>",
	};

	const Num036 = {
		"title": "<?php echo lang('Falta Información'); ?>",
		"desc": "<?php echo lang('Debe seleccionar la sucursal del metodo de pago'); ?>",
	};

	const Num037 = {
		"title": "<?php echo lang('Falta Información'); ?>",
		"desc": "<?php echo lang('Debe seleccionar si afecta la compra o no en el metodo de pago'); ?>",
	};

	const Num038 = {
		"title": "<?php echo lang('Falta Información'); ?>",
		"desc": "<?php echo lang('Debe seleccionar si afecta la venta o no en el metodo de pago'); ?>",
	};

	const Num039 = {
		"title": "<?php echo lang('Orden Inválido'); ?>",
		"desc": "<?php echo lang('El numero de orden debe ser mayor a cero'); ?>",
	};
	const Num040 = {
		"title": "<?php echo lang('Orden esta repetido'); ?>",
		"desc": "<?php echo lang('El medio de pago tiene el numero de orden repetido'); ?>",
	};

	const PrecioSpan = "<?php echo lang('Precio') ?>";

	window.onload = function() {
		IniEntorno();
		if (CompanyActual == "133") RefreshMDP();
	}
</script>

<div class="app-ui-mask-modal"></div>