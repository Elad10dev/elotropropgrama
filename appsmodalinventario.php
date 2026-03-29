<?php
include "ambienteconsultas.php";
$conn = Conectar();
session_start();

if ($_POST['CIdPlan'] == '0000000019') {
	if ($_POST['IdCompanySelect'] == '') {
		$companygrp = " in (" . $_POST["Company"] . "," . $_POST["IdCompanyGrp"] . ") ";
	} else {
		$companygrp = " in (" . $_POST["IdCompanySelect"] . ") ";
	}


	if (strpos($companygrp, ",")) {
		$notfil = 'd-none';
	} else {
		$notfil = '';
	}
} else {
	$companygrp = " = " . $_POST["Company"] . "  ";
	$notemprise = "d-none";
}



if ($_SESSION['IdiomaActual'] == '') {
	$_SESSION['IdiomaActual'] = $_POST['IdiomaActual'];
}

$PerfilVentas = explode(",", $_POST["PerfilVentas"]);

$p0 = $PerfilVentas[0];
$p1 = $PerfilVentas[1];
$p2 = $PerfilVentas[2];
$p3 = $PerfilVentas[3];
$c0 = $PerfilVentas[4];
$u1 = $PerfilVentas[5];
$u2 = $PerfilVentas[6];
$u3 = $PerfilVentas[7];
$UnidosoDesunidos = $PerfilVentas[8];
$u4 = $PerfilVentas[9];
$p4 = $PerfilVentas[10];
$u5 = $PerfilVentas[12];
$p5 = $PerfilVentas[13];
$u6 = $PerfilVentas[14];
$p6 = $PerfilVentas[15];
$u7 = $PerfilVentas[16];
$p7 = $PerfilVentas[17];
$u8 = $PerfilVentas[18];
$p8 = $PerfilVentas[19];
$u9 = $PerfilVentas[20];
$p9 = $PerfilVentas[21];
$u10 = $PerfilVentas[22];
$p10 = $PerfilVentas[23];

if ($_POST["Accion"] === "1") {
	$IdCompanySelect = "";
	$query = "SELECT '" . $_POST["IdCompanyGrp"] . "' as ID, ' [" . lang('Todas') . "]' as Empresa  union  SELECT Id as ID, comercio as Empresa FROM PosUpCompany where Id in ( " . $_POST["IdCompanyGrp"] . ")  order by Empresa ";
	if ($result = mysqli_query($conn, $query)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$IdCompanySelect .= "<option value='" . $row['ID'] . "' " . (trim($row['ID']) == trim($_POST['emprise']) ? "selected" : "") . ">" . $row['Empresa'] . "</option>";
		}
		mysqli_free_result($result);
	}
	$sql = "SELECT LitP01,LitP02,LitP03,LitP04,LitP05,LitP06,LitP07,LitP08,LitP09,LitP10,LitCosto FROM PosUpCompany 
	where Id=" . $_POST["Company"] . "";
	if ($result = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$LitP01 = $row["LitP01"];
			$LitP02 = $row["LitP02"];
			$LitP03 = $row["LitP03"];
			$LitP04 = $row["LitP04"];
			$LitP05 = $row["LitP05"];
			$LitP06 = $row["LitP06"];
			$LitP07 = $row["LitP07"];
			$LitP08 = $row["LitP08"];
			$LitP09 = $row["LitP09"];
			$LitP10 = $row["LitP10"];
			$LitCosto = $row["LitCosto"];
		}
	}
?>
	<div class="modal-header">
		<h5 class="modal-title"><img src="/img/informez.png" alt="informe" height="24px" width="24px"> <?php echo lang('Productos'); ?></h5>
		<button class="btn-close" type="button" data-bs-dismiss="modal"></button>
	</div>
	<form id="Productos" method="POST" target="_Blank" action="mercancia.php" onsubmit="return false">
		<div class="modal-body">
			<input type="hidden" name="CompanyActual" value="<?php echo $_POST['Company']; ?>" />
			<input type="hidden" name="IdCompanyGrp" value="<?php echo $_POST['IdCompanyGrp']; ?>" />
			<input type="hidden" name="CIdPlan" value="<?php echo $_POST['CIdPlan']; ?>" />
			<input type="hidden" name="SimMil" value="<?php echo $_POST['SimMil']; ?>" />
			<input type="hidden" name="SimDec" value="<?php echo $_POST['SimDec']; ?>" />
			<input type="hidden" name="CD" value="<?php echo $_POST['CD']; ?>" />
			<input type="hidden" name="direccion" value="<?php echo $_POST['direccion']; ?>" />
			<input type="hidden" name="NameCompany" value="<?php echo $_POST['NameCompany']; ?>" />
			<input type="hidden" name="sucursal" value="<?php echo $_POST['sucursal']; ?>" />

			<input type="hidden" name="fectx5" id="fectx5">
			<span style="display:none" id="devueltachavales"></span>
			<span style="display:none" id="CodigoDesaL"></span>
			<span style="display:none" id="CodigoHasaL"></span>
			<span style="display:none" id="BenefeL"></span>
			<span style="display:none" id="AlmaL"></span>
			<span style="display:none" id="MarL"></span>
			<div class="row p-1">

				<div class="col-12 <?php echo $notemp; ?> p-1">
					<div class="col">
						<div class="form-floating">
							<select id='IdCompanySelect' name='IdCompanySelect' onchange='selectidcomp(document.getElementById("IdCompanySelect").value);' class="form-select <?php echo $notemprise; ?>" aria-label="Default select example">
								<?php echo $IdCompanySelect ?>
							</select>
							<label><i class="fa fa-sort"></i> <?php echo lang('Empresa'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1">
					<div class="col">
						<div class="form-floating">
							<select class="form-select" id="Orden" name="Orden">
								<option value="Codigo"><?php echo lang('Código'); ?></option>
								<option value="Descripcion"><?php echo lang('Descripción'); ?></option>
								<option value="Referencia"><?php echo lang('Referencia'); ?></option>
								<option value="Instancia"><?php echo lang('Familia'); ?></option>
								<?php if ($_POST['userperfil'] <= 2000 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
									<option value="Rentables"><?php echo lang('Rentables'); ?></option>
									<option value="Costo"><?php echo lang('Costo'); ?></option>
									<option value="Precio"><?php echo lang('Precio'); ?></option>
								<?php } ?>
							</select>
							<label><i class="fa fa-sort"></i> <?php echo lang('Orden'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1">
					<div class="col">
						<div class="form-floating">
							<select class="form-select" id="Orientacion" name="Orientacion">
								<option value="ASC"><?php echo lang('Ascendente'); ?></option>
								<option value="DESC"><?php echo lang('Descendente'); ?></option>
							</select>
							<label><i class="fa fa-sort"></i> <?php echo lang('Orientacion'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<div class="form-floating">
						<select name="SelectTasa" id="SelectTasa" class="form-select">
							<?php
							$MonedaP = "";
							$MonedaS = "";
							$GenTxFactorDCambio = "";
							$query = "SELECT FactorDolarCash,FactorDolarPaypal,FactorDolarZelle,Moneda3,Moneda4,MonedaP,MonedaS,MonedaP,LitPrincipalEfectivo,Moneda5,Moneda6,Moneda7,FactorDolar5,FactorDolar6,FactorDolar7 FROM PosUpCompany WHERE Id=" . $_POST['Company'] . "";
							if ($result = mysqli_query($conn, $query)) {
								while ($row = mysqli_fetch_assoc($result)) {
									$MonedaP = $row["MonedaP"];
									$MonedaS =  ($row["LitPrincipalEfectivo"] === "" ? $row['MonedaS'] : $row["LitPrincipalEfectivo"]);
									$GenTxFactorDCambio .= "<option value='1' >" . $row['MonedaP'] . "</option>";
									if ($row['FactorDolarCash'] > 1) $GenTxFactorDCambio .= "<option value='2' >" . $row['MonedaS']  . "</option>";
									if ($row['FactorDolarPaypal'] > 1) $GenTxFactorDCambio .= "<option value='3' >" . $row['Moneda3'] . "</option>";
									if ($row['FactorDolarZelle'] > 1) $GenTxFactorDCambio .= "<option value='4' >" . $row['Moneda4'] . "</option>";
									if ($row['FactorDolar5'] > 1) $GenTxFactorDCambio .= "<option value='5' >" . $row['Moneda5'] . "</option>";
									if ($row['FactorDolar6'] > 1) $GenTxFactorDCambio .= "<option value='6' >" . $row['Moneda6'] . "</option>";
									if ($row['FactorDolar7'] > 1) $GenTxFactorDCambio .= "<option value='7' >" . $row['Moneda7'] . "</option>";
								}
								mysqli_free_result($result);
							}
							echo $GenTxFactorDCambio;
							?>
						</select>
						<label><i class="fa fa-money" aria-hidden="true"></i>&nbsp;<?php echo lang('Tasa') ?></label>
					</div>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<div class="form-floating">
						<select name="SelectPrecio" id="SelectPrecio" class="form-select">

							<option value="">
								<?php echo (trim($LitP01) !== "" ? $LitP01 : lang("Precio") . " 1"); ?>
							</option>
							<option value="2">
								<?php echo (trim($LitP02) !== "" ? $LitP02 : lang("Precio") . " 2"); ?>
							</option>
							<option value="3">
								<?php echo (trim($LitP03) !== "" ? $LitP03 : lang("Precio") . " 3"); ?>
							</option>
							<option value="4">
								<?php echo (trim($LitP04) !== "" ? $LitP04 : lang("Precio") . " 4"); ?>
							</option>
							<option value="5">
								<?php echo (trim($LitP05) !== "" ? $LitP05 : lang("Precio") . " 5"); ?>
							</option>
							<option value="6">
								<?php echo (trim($LitP06) !== "" ? $LitP06 : lang("Precio") . " 6"); ?>
							</option>
							<option value="7">
								<?php echo (trim($LitP07) !== "" ? $LitP07 : lang("Precio") . " 7"); ?>
							</option>
							<option value="8">
								<?php echo (trim($LitP08) !== "" ? $LitP08 : lang("Precio") . " 8"); ?>
							</option>
							<option value="9">
								<?php echo (trim($LitP09) !== "" ? $LitP09 : lang("Precio") . " 9"); ?>
							</option>
							<option value="10">
								<?php echo (trim($LitP10) !== "" ? $LitP10 : lang("Precio") . " 10"); ?>
							</option>
						</select>
						<label><i class="fa fa-money" aria-hidden="true"></i>&nbsp;<?php echo lang('Precio') ?></label>
					</div>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<div class="col">
						<div class="form-floating">
							<input style='display:none' class="input-daterange input-group" data-date-format="dd/mm/yyyy" />
							<input class="form-control " type="date" id="FechaHastaproductos" name="FechaHastaproductos">
							<label><i class="fa fa-calendar"></i> <?php echo lang('Hasta la Fecha'); ?></label>
						</div>
					</div>
				</div>

				<!-- <div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="col">
						<div class="form-floating">
							<input class="form-control filt " type="text" id="InstanciaNK" name="InstanciaNK" onchange="familia();" />
							<label><i class="fa fa-th-large"></i> <?php echo lang('Familia'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="Instancia2NK" name="Instancia2NK" readonly />
								<label></label>
							</div>
						</div>
						<button class="btn btn-outline-primary px-1" type="button" onclick="asd(1)"><i class="fa fa-search"></i></button>
					</div>
				</div> -->

				<!-- <div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
					<div class="col">
						<div class="form-floating">
							<input class="form-control filt" type="text" id="CodigoDesde" name="CodigoDesde" onchange="CodigoDes();" />
							<label><i class="fa fa-hashtag"></i> <?php echo lang('Código Desde'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="CodigoDesde2" name="CodigoDesde2" readonly />
								<label></label>
							</div>
						</div>
						<button class="btn btn-outline-primary px-1" type="button" onclick="asd(2)"><i class="fa fa-search"></i></button>
					</div>
				</div>

				<div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
					<div class="col">
						<div class="form-floating">
							<input class="form-control filt" type="text" id="CodigoHasta" name="CodigoHasta" onchange="CodigoHas();" />
							<label><i class="fa fa-hashtag"></i> <?php echo lang('Código Hasta'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="CodigoHasta2" name="CodigoHasta2" readonly />
								<label></label>
							</div>
						</div>
						<button class="btn btn-outline-primary px-1" type="button" onclick="asd(3)"><i class="fa fa-search"></i></button>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
					<div class="col">
						<div class="form-floating">
							<input class="form-control filt" type="text" id="Proevedor" name="Proevedor" onchange="Benefe();" />
							<label><i class="fa fa-user"></i> <?php echo lang('Beneficiario'); ?></label>
						</div>
					</div>
				</div>
				
				<div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="Proevedor2" name="Proevedor2" readonly />
								<label></label>
							</div>
						</div>
						<button class="btn btn-outline-primary px-1" type="button" onclick="asd(4)"><i class="fa fa-search"></i></button>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
					<div class="col">
						<div class="form-floating">
							<input class="form-control filt" type="text" id="DepositoNK" name="DepositoNK" onchange="Alma();" />
							<label><i class="fa fa-archive"></i> <?php echo lang('Almacen'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt " type="text" id="Deposito2NK" name="Deposito2NK" readonly />
								<label></label>
							</div>
						</div>
						<button class="btn btn-outline-primary px-1" type="button" onclick="asd(5)"><i class="fa fa-search"></i></button>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
					<div class="col">
						<div class="form-floating">
							<input class="form-control filt" type="text" id="Marca" name="Marca" onchange="Mar();" />
							<label><i class="fa fa-tags"></i> <?php echo lang('Marca'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="Marca2" name="Marca2" readonly />
								<label></label>
							</div>
						</div>
						<button class="btn btn-outline-primary px-1" type="button" onclick="asd(6)"><i class="fa fa-search"></i></button>
					</div>
				</div>
			 -->

				<div class="col-12 col-lg-4 p-1">
					<label for="mIdfamilia"><?php echo lang("Familia"); ?></label>
					<select id="mIdfamilia" name="mIdfamilia[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$query = "SELECT a.IdVarios,if(a.IdVariosPadre=0,a.ITEM,concat(b.ITEM,' > ', a.ITEM)) AS ITEM FROM PosUpvarios a left join PosUpvarios b on a.IdCompany=b.IdCompany and a.IdVariosPadre = b.IdVarios and a.TIPOITEM = b.TIPOITEM and b.TIPOITEM = 2 WHERE a.IdCompany=" . $_POST["Company"] . " and a.TIPOITEM = 2 order by if(a.IdVariosPadre=0,a.ITEM,concat(b.ITEM,' > ', a.ITEM)) asc";
						//echo $query;
						if ($result = mysqli_query($conn, $query)) {
							while ($row = mysqli_fetch_assoc($result)) {

						?>
								<option value="<?php echo trim($row['IdVarios']); ?>"><?php echo trim($row['ITEM']); ?></option>
						<?

							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<label for="mIdMarca"><?php echo lang('Marca'); ?></label>
					<select id="mIdMarca" name="mIdMarca[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$sql = "SELECT idmarca,nombre FROM PosUpc_marcas a where a.IdCompany = " . $_POST["Company"];
						if ($result = mysqli_query($conn, $sql)) {
							while ($row = mysqli_fetch_assoc($result)) {
						?>
								<option value="<?php echo trim($row['idmarca']); ?>"><?php echo trim($row['nombre']); ?></option>
						<?
							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>

				<div class="col-12 col-lg-4 p-1">
					<label for="mIdAlmacen">Almacen</label>
					<select id="mIdAlmacen" name="mIdAlmacen[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						if ($_POST['sucursal'] == '0') {
							$sql = "SELECT a.*,b.Nombre as UBicacion FROM PosUpAlmacen a inner join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi WHERE a.IdCompany = " . $_POST["Company"] . " ";
						} else {
							$sql = "SELECT a.*,b.Nombre as UBicacion FROM PosUpAlmacen a inner join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi WHERE a.IdCompany = " . $_POST["Company"] . " and b.IdUbi=" . $_POST['sucursal'];
						}
						if ($result = mysqli_query($conn, $sql)) {
							while ($row = mysqli_fetch_assoc($result)) {
						?>
								<option value="<?php echo trim($row['IdAlm']); ?>"><?php echo trim($row['Nombre']); ?></option>
						<?
							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>
				<div class="col-12 col-lg-8 p-1">
					<label for="mIdProductos"><i class="fa fa-archive" aria-hidden="true"></i> <?php echo lang("Productos"); ?></label>
					<select id="mIdProductos" name="mIdProductos[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$query = "SELECT CodIdBasico,CodIdAmpliado,CodBarra,Descripcion FROM PosUpProducto a where a.EsCompuesto=0 and a.IdCompany = " . $_POST["Company"] . "";
						if ($result = mysqli_query($conn, $query)) {
							while ($row = mysqli_fetch_assoc($result)) {

						?>
								<option value="<?php echo trim($row['CodIdBasico']); ?>"><?php echo trim($row['Descripcion']); ?></option>
						<?

							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<label><i class="fa fa-sort"></i> <?php echo lang('Estados de los Productos'); ?></label>
					<div class="col">
						<select class="form-select" id="StatusCode" name="StatusCode">
							<option value="*"><?php echo lang('Todos'); ?></option>
							<option value="1"><?php echo lang('Activos'); ?></option>
							<option value="0"><?php echo lang('Inactivos'); ?></option>
						</select>
					</div>
				</div>
				<div class="col-12 p-1">
					<label for="mIdProevedor"><?php echo lang("Beneficiarios"); ?></label>
					<select id="mIdProevedor" name="mIdProevedor[]" multiple="multiple" style="width: 100%">
					</select>
				</div>



				<script>
					$(document).ready(function() {
						$("#mIdfamilia").select2({
							dropdownParent: $("#apps-modalz"),
						});
						$("#mIdProductos").select2({
							dropdownParent: $("#apps-modalz"),
						});
						$("#mIdProevedor").select2({
							ajax: {
								delay: 1000,
								type: "POST",
								dataType: 'json',
								url: 'informezseek.php',
								data: function(params) {
									var queryParameters = {
										search: params.term,
										Accion: "ProveedorBA",
										CompanyActual: document.getElementById("CompanyActual").innerHTML
									}

									return queryParameters;
								},
								processResults: function(data) {
									return {
										results: data.results
									};
								}
							},
							dropdownParent: $("#apps-modalz"),
						});
						$("#mIdAlmacen").select2({
							dropdownParent: $("#apps-modalz"),
						});
						$("#mIdMarca").select2({
							dropdownParent: $("#apps-modalz"),
						});
					});
				</script>

				<div class="col-12 p-1">
					<div class="row ms-3">
						<?php if ($_POST['userperfil'] <= 2000 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
							<div class="col-6 col-md-4 col-lg-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" name="Incluirimpuestos" id="Incluirimpuestos">
									<label class="form-check-label" for="Incluirimpuestos">
										<?php echo lang('Incluir Impuestos'); ?>
									</label>
								</div>
							</div>
							<div class="col-6  col-md-4 col-lg-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" name="ExistenciaCero" id="ExistenciaCero">
									<label class="form-check-label" for="ExistenciaCero">
										<?php echo lang('Existencia Cero'); ?>
									</label>
								</div>
							</div>
							<div class="col-6  col-md-4 col-lg-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" name="mexist" id="mexist">
									<label class="form-check-label" for="mexist">
										<?php echo lang('Mostrar Existencia'); ?>
									</label>
								</div>
							</div>
							<div class="col-6  col-md-4 col-lg-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" name="Utilidad" id="Utilidad">
									<label class="form-check-label" for="Utilidad">
										<?php echo lang('Porcentaje de Utilidad'); ?>
									</label>
								</div>
							</div>
							<div class="col-6 col-md-4 col-lg-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" name="cos" id="cos">
									<label class="form-check-label" for="cos">
										<?php echo lang('Costo'); ?>
									</label>
								</div>
							</div>
						<?php } ?>

						<div class="col-6 col-md-4 col-lg-3">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="Seriales" id="Seriales">
								<label class="form-check-label" for="Seriales">
									<?php echo lang('Seriales'); ?>
								</label>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<!-- 	
		reportes productos 1.0.0 - 2024-06-20
		 -->
		<div class="row input-group w-100 m-0">
    		<div class="col-3 text-center p-1">
        		<button class="btn btn-outline-danger w-100" type="reset" id="limpiar"><i class="fa fa-trash"></i> <?php echo lang('Limpiar'); ?></button>
    		</div>
    		<div class="col-3 text-center p-1">
        		<button type="button" class="btn btn-outline-primary w-100" onclick="var f = this.closest('form'); f.action='mercancia.php'; f.target='_blank'; f.submit();">
            		<i class="fa fa-print"></i> <?php echo lang('Preliminar'); ?>
        		</button>
    		</div>
    		<div class="col-3 text-center p-1">
        		<button type="button" class="btn btn-danger w-100" onclick="var f = this.closest('form'); f.action='reporte_productos_pdf.php'; f.target='_blank'; f.submit();">
            		<i class="fa fa-file-pdf-o"></i> PDF
        		</button>
    		</div>
			<div class="col-3 text-center p-1">
    			<button type="button" class="btn btn-success w-100" onclick="var f = this.closest('form'); f.action='reporte_productos_excel.php'; f.target='_self'; f.submit();">
        			<i class="fa fa-file-excel-o"></i> Excel
    			</button>
			</div>
    		<div class="col-3 text-center p-1">
        		<button class="btn btn-outline-secondary w-100" type="button" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?></button>
    		</div>
		</div>
	</form>

	<script>
		var fecha = new Date();
		var mes = fecha.getMonth() + 1;
		var dia = fecha.getDate();
		var ano = fecha.getFullYear();
		if (dia < 10)
			dia = '0' + dia;
		if (mes < 10)
			mes = '0' + mes
		document.getElementById('FechaHastaproductos').value = ano + "-" + mes + "-" + dia;
	</script>
<?php
}

if ($_POST["Accion"] === "2") {
?>
	<div class="modal-header">
		<h5 class="modal-title"><img src="/img/informez.png" alt="informe" height="24px" width="24px"> <?php echo lang('Reposición de Inventario'); ?></h5>
		<button class="btn-close" type="button" data-bs-dismiss="modal"></button>
	</div>
	<form id="ListaPrecio" method="POST" target="_Blank" action="reposicion.php" onsubmit="return false">
		<div class="modal-body">
			<input type="hidden" name="fectx5" id="fectx5">

			<input type="hidden" name="CompanyActual" value="<?php echo $_POST['Company']; ?>" />
			<input type="hidden" name="IdCompanyGrp" value="<?php echo $_POST['IdCompanyGrp']; ?>" />
			<input type="hidden" name="CIdPlan" value="<?php echo $_POST['CIdPlan']; ?>" />
			<input type="hidden" name="SimMil" value="<?php echo $_POST['SimMil']; ?>" />
			<input type="hidden" name="SimDec" value="<?php echo $_POST['SimDec']; ?>" />
			<input type="hidden" name="CD" value="<?php echo $_POST['CD']; ?>" />
			<input type="hidden" name="direccion" value="<?php echo $_POST['direccion']; ?>" />
			<input type="hidden" name="NameCompany" value="<?php echo $_POST['NameCompany']; ?>" />
			<input type="hidden" name="sucursal" value="<?php echo $_POST['sucursal']; ?>" />

			<span style="display:none" id="devueltachavalesLPRESres"></span>
			<span style="display:none" id="CodigoDesaLLPRESres"></span>
			<span style="display:none" id="CodigoHasaLLPRESres"></span>
			<span style="display:none" id="BenefeLLPRESres"></span>
			<span style="display:none" id="AlmaLLPRESres"></span>

			<div class="row p-1">

				<div class="col-12 <?php echo $notemp; ?>  p-1">
					<div class="col">
						<div class="form-floating">
							<select id='IdCompanySelect' name='IdCompanySelect' onchange='selectidcomp(document.getElementById("IdCompanySelect").value);' class="form-select <?php echo $notemprise; ?>" aria-label="Default select example">
								<?php
								$conn = conectar();

								$query = "SELECT '" . $_POST["IdCompanyGrp"] . "' as ID, ' [" . lang('Todas') . "]' as Empresa  union  SELECT Id as ID, comercio as Empresa FROM PosUpCompany where Id in ( " . $_POST["IdCompanyGrp"] . ")  order by Empresa ";
								if ($result = mysqli_query($conn, $query)) {
									$n = 0;
									while ($row = mysqli_fetch_assoc($result)) {
								?><option value="<?php echo trim($row['ID']); ?>" <?php if (trim($row['ID']) == trim($_POST['emprise'])) {
																						echo "selected";
																					}; ?>><?php echo trim($row['Empresa']); ?></option><?
																																	}

																																	mysqli_free_result($result);
																																}
																																		?>
							</select>
							<label><i class="fa fa-sorttt"></i> <?php echo lang('Empresa'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1">
					<div class="col">
						<div class="form-floating">
							<select class="form-select" id="OrdenRESres" name="OrdenRESres">
								<option value="1"><?php echo lang('Código'); ?></option>
								<option value="2"><?php echo lang('Descripción'); ?></option>
								<option value="3"><?php echo lang('Referencia'); ?></option>
								<option value="4"><?php echo lang('Familia'); ?></option>
							</select>
							<label><i class="fa fa-sort"></i> <?php echo lang('Orden'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1">
					<div class="col">
						<div class="form-floating">
							<input class="form-control " type="date" id="FechaHastares" name="FechaHastares" />
							<div class="input-daterange input-group" style='display:none' data-date-format="Y-m-d"></div>
							<label><i class="fa fa-calendar"></i> <?php echo lang('Hasta la Fecha'); ?></label>
						</div>
					</div>
				</div>
				<!-- 
				<div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="col">
						<div class="form-floating">
							<input class="form-control filt " type="text" id="Familias2asdres" name="Familias2asdres" onchange="familia();" />
							<label><i class="fa fa-th-large"></i> <?php echo lang('Familia'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="Instancia2NK" name="Instancia2NK" readonly />
								<label></label>
							</div>
						</div>
						<button class="btn btn-outline-primary px-1" type="button" onclick="asd(1)"><i class="fa fa-search"></i></button>
					</div>
				</div>

				<div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
					<div class="col">
						<div class="form-floating">
							<input class="form-control filt" type="text" id="AlmacenRESres" name="AlmacenRESres" onchange="Alma();" />
							<label><i class="fa fa-archive"></i> <?php echo lang('Almacen'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt " type="text" id="Deposito2NK" name="Deposito2NK" readonly />
								<label></label>
							</div>
						</div>
						<button class="btn btn-outline-primary px-1" type="button" onclick="asd(5)"><i class="fa fa-search"></i></button>
					</div>
				</div>

				<div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="col">
						<div class="form-floating">
							<input class="form-control filt" type="text" id="CodigoDesdeLPRESres" name="CodigoDesdeLPRESres" onchange="CodigoDesLPRESres();" />
							<label><i class="fa fa-archive"></i> <?php echo lang('Desde Producto'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="CodigoDesde2LPRESres" name="CodigoDesde2LPRESres" readonly />
							</div>
						</div>
						<button class="btn btn-outline-primary px-1" type="button" onclick="ListaLPRESres(2)"><i class=" fa fa-search"></i></button>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="col">
						<div class="form-floating">
							<input class="form-control filt" type="text" id="CodigoHastaLPRESres" name="CodigoHastaLPRESres" onchange="CodigoHasLPRESres();" />
							<label><i class="fa fa-archive"></i> <?php echo lang('Hasta Producto'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="CodigoHasta2LPRESres" name="CodigoHasta2LPRESre" readonly />
							</div>
						</div>
						<button class="btn btn-outline-primary px-1" type="button" onclick="ListaLPRESres(3)"><i class=" fa fa-search"></i></button>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="col">
						<div class="form-floating">
							<input class="form-control filt" type="text" id="MarcaLPUTA1res" name="MarcaLPUTA1res" res onchange="marcaploz();" />
							<label><i class="fa fa-tags"></i> <?php echo lang('Marca'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="MarcaLPUTA2res" name="MarcaLPUTA2res" readonly />
							</div>
						</div>
						<button class="btn btn-outline-primary px-1" type="button" onclick="ListaLPRESres(5)"><i class=" fa fa-search"></i></button>
					</div>
				</div>
			-->

				<div class="col-12 col-lg-4 p-1">
					<label for="mIdfamilia"><?php echo lang("Familia"); ?></label>
					<select id="mIdfamilia" name="mIdfamilia[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$query = "SELECT a.IdVarios,if(a.IdVariosPadre=0,a.ITEM,concat(b.ITEM,' > ', a.ITEM)) AS ITEM FROM PosUpvarios a left join PosUpvarios b on a.IdCompany=b.IdCompany and a.IdVariosPadre = b.IdVarios and a.TIPOITEM = b.TIPOITEM and b.TIPOITEM = 2 WHERE a.IdCompany=" . $_POST["Company"] . " and a.TIPOITEM = 2 order by if(a.IdVariosPadre=0,a.ITEM,concat(b.ITEM,' > ', a.ITEM)) asc";
						//echo $query;
						if ($result = mysqli_query($conn, $query)) {
							while ($row = mysqli_fetch_assoc($result)) {

						?>
								<option value="<?php echo trim($row['IdVarios']); ?>"><?php echo trim($row['ITEM']); ?></option>
						<?

							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>

				<div class="col-12 col-lg-4 p-1">
					<label for="mIdMarca"><?php echo lang('Marca'); ?></label>
					<select id="mIdMarca" name="mIdMarca[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$sql = "SELECT idmarca,nombre FROM PosUpc_marcas a where a.IdCompany = " . $_POST["Company"];
						if ($result = mysqli_query($conn, $sql)) {
							while ($row = mysqli_fetch_assoc($result)) {
						?>
								<option value="<?php echo trim($row['idmarca']); ?>"><?php echo trim($row['nombre']); ?></option>
						<?
							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>

				<div class="col-12 col-lg-4 p-1">
					<label for="mIdAlmacen"><?php echo lang('Almacén'); ?></label>
					<select id="mIdAlmacen" name="mIdAlmacen[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						if ($_POST['sucursal'] == '0') {
							$sql = "SELECT a.*,b.Nombre as UBicacion FROM PosUpAlmacen a inner join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi WHERE a.IdCompany = " . $_POST["Company"] . " ";
						} else {
							$sql = "SELECT a.*,b.Nombre as UBicacion FROM PosUpAlmacen a inner join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi WHERE a.IdCompany = " . $_POST["Company"] . " and b.IdUbi=" . $_POST['sucursal'];
						}
						if ($result = mysqli_query($conn, $sql)) {
							while ($row = mysqli_fetch_assoc($result)) {
						?>
								<option value="<?php echo trim($row['IdAlm']); ?>"><?php echo trim($row['Nombre']); ?></option>
						<?
							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>

				<div class="col-12 p-1">
					<label for="mIdProductos"><i class="fa fa-archive" aria-hidden="true"></i> <?php echo lang("Productos"); ?></label>
					<select id="mIdProductos" name="mIdProductos[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$query = "SELECT CodIdBasico,CodIdAmpliado,CodBarra,Descripcion FROM PosUpProducto a where a.EsCompuesto=0 and a.IdCompany = " . $_POST["Company"] . "";
						if ($result = mysqli_query($conn, $query)) {
							while ($row = mysqli_fetch_assoc($result)) {

						?>
								<option value="<?php echo trim($row['CodIdBasico']); ?>"><?php echo trim($row['Descripcion']); ?></option>
						<?

							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>

			</div>

			<script>
				$(document).ready(function() {
					$("#mIdfamilia").select2({
						dropdownParent: $("#apps-modalz"),
					});
					$("#mIdProductos").select2({
						dropdownParent: $("#apps-modalz"),
					});
					$("#mIdAlmacen").select2({
						dropdownParent: $("#apps-modalz"),
					});
					$("#mIdMarca").select2({
						dropdownParent: $("#apps-modalz"),
					});
				});
			</script>


			<div class="row p-1">
				<?php
				if ($_POST['userperfil'] <= 2000 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") {
				?>
					<div class="col-12 col-md-6 col-lg-3 mb-2">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="ExistenciaNULL" id="ExistenciaNULL">
							<label class="form-check-label" for="ExistenciaNULL">
								<?php echo lang('Existencia Cero'); ?>
							</label>
						</div>
					</div>
					<div class="col-12 col-md-6 col-lg-3 mb-2">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="mexis" id="mexis">
							<label class="form-check-label" for="mexis">
								<?php echo lang('Mostrar Existencia'); ?>
							</label>
						</div>
					</div>
				<?php
				}
				?>
				<div class="col-12 col-md-6 col-lg-3 mb-2">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="SinM" id="SinM">
						<label class="form-check-label" for="SinM">
							<?php echo lang('Sin Movimientos'); ?>
						</label>
					</div>
				</div>
			</div>
		</div>
<!-- reporte reposiscion de inventario -->
		<div class="modal-footer" style="width: 100%;">
 		   <div class="row input-group w-100 m-0">
 		       <div class="col-3 text-center p-1">
 		           <button class="btn btn-outline-danger w-100" type="reset" id="limpiarLP">
 		               <i class="fa fa-trash"></i> <?php echo lang('Limpiar'); ?>
  		          </button>
 		       </div>
 		       <div class="col-3 text-center p-1">
  		          <button class="btn btn-outline-primary w-100" type="button" onclick="var f = this.closest('form'); f.action='reposicion.php'; f.target='_blank'; f.submit();">
 		               <i class="fa fa-print"></i> <?php echo lang('Preliminar'); ?>
 		           </button>
		        </div>
 		       <div class="col-3 text-center p-1">
 		           <button class="btn btn-danger w-100" type="button" onclick="var f = this.closest('form'); f.action='reporte_reposicion_pdf.php'; f.target='_blank'; f.submit();">
 		               <i class="fa fa-file-pdf-o"></i> PDF
  		          </button>
  		      </div>
			  <div class="col text-center p-1">
            		<button class="btn btn-success w-100" type="button" onclick="var f = this.closest('form'); f.action='reporte_reposicion_excel.php'; f.target='_self'; f.submit();">
                		<i class="fa fa-file-excel-o"></i> Excel
            		</button>
        		</div>
 		       <div class="col-3 text-center p-1">
 		           <button class="btn btn-outline-secondary w-100" type="button" data-bs-dismiss="modal">
 		               <i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?>
  		          </button>
  		      </div>
 		   </div>
		</div>
	</form>
	<script>
		var fecha = new Date();
		var mes = fecha.getMonth() + 1;
		var dia = fecha.getDate();
		var ano = fecha.getFullYear();
		if (dia < 10) {
			dia = '0' + dia;
		}
		if (mes < 10) {
			mes = '0' + mes;
		}
		document.getElementById('FechaHastares').value = ano + "-" + mes + "-" + dia;
	</script>
<?php
}

if ($_POST["Accion"] === "3") {
?>
	<div class="modal-header">
		<h5 class="modal-title"><img src="/img/informez.png" alt="informe" height="24px" width="24px"> <?php echo lang('Análisis de Producto'); ?></h5>
		<button class="btn-close" type="button" data-bs-dismiss="modal"></button>
	</div>
	<form id="analisisprod" method="POST" target="_Blank" action="analisisproducto.php" onsubmit="return false">
		<div class="modal-body">
			<input type="hidden" name="fectx5" id="fectx5" />

			<input type="hidden" name="CompanyActual" value="<?php echo $_POST['Company']; ?>" />
			<input type="hidden" name="IdCompanyGrp" value="<?php echo $_POST['IdCompanyGrp']; ?>" />
			<input type="hidden" name="CIdPlan" value="<?php echo $_POST['CIdPlan']; ?>" />
			<input type="hidden" name="SimMil" value="<?php echo $_POST['SimMil']; ?>" />
			<input type="hidden" name="SimDec" value="<?php echo $_POST['SimDec']; ?>" />
			<input type="hidden" name="CD" value="<?php echo $_POST['CD']; ?>" />
			<input type="hidden" name="direccion" value="<?php echo $_POST['direccion']; ?>" />
			<input type="hidden" name="NameCompany" value="<?php echo $_POST['NameCompany']; ?>" />
			<input type="hidden" name="sucursal" value="<?php echo $_POST['sucursal']; ?>" />
			<span style="display:none" id="devueltachavalesAX"></span>
			<span style="display:none" id="CodigoDesaAX"></span>
			<span style="display:none" id="CodigoHasaAX"></span>
			<span style="display:none" id="BenefeAX"></span>
			<span style="display:none" id="AlmaAX"></span>
			<div class="row p-1">

				<!-- <div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
	<div class="col">
		<div class="form-floating">
			<input class="form-control filt" type="text" id="DesdeAX" name="DesdeAX" onchange="CodigoDesAX();" />
			<label><i class="fa fa-archive"></i> <?php echo lang('Desde Producto'); ?></label>
		</div>
	</div>
</div>
<div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
	<div class="input-group">
		<div class="col">
			<div class="form-floating">
				<input class="form-control filt" type="text" id="DesdeAX2" name="DesdeAX2" readonly />
			</div>
		</div>
		<button class="btn btn-outline-primary px-1" type="button" onclick="AXmodal(1)"><i class="fa fa-search"></i></button>
	</div>
</div>
<div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
	<div class="col">
		<div class="form-floating">
			<input class="form-control filt" type="text" id="HastaAX" name="HastaAX" onchange="CodigoHasAX();" />
			<label><i class="fa fa-archive"></i> <?php echo lang('Hasta Producto'); ?></label>
		</div>
	</div>
</div>
<div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
	<div class="input-group">
		<div class="col">
			<div class="form-floating">
				<input class="form-control filt" type="text" id="HastaAX2" name="HastaAX2" readonly />
			</div>
		</div>
		<button class="btn btn-outline-primary px-1" type="button" onclick="AXmodal(2)"><i class="fa fa-search"></i></button>
	</div>
</div> -->
				<!-- <div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
	<div class="col">
		<div class="form-floating">
			<input class="form-control filt" type="text" id="BeneficiarioAX" name="BeneficiarioAX" onchange="BenefeAX();" />
			<label><i class="fa fa-user"></i> <?php echo lang('Beneficiario'); ?></label>
		</div>
	</div>
</div>
<div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
	<div class="input-group">
		<div class="col">
			<div class="form-floating">
				<input class="form-control filt" type="text" id="BeneficiarioAX2" name="BeneficiarioSE2" readonly />
			</div>
		</div>
		<button class="btn btn-outline-primary px-1" type="button" onclick="AXmodal(3)"><i class="fa fa-search"></i></button>
	</div>
</div> -->
				<!-- <div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
	<div class="col">
		<div class="form-floating">
			<input class="form-control filt" type="text" id="AlmacenAX" name="AlmacenAX" onchange="AlmaAX();" />
			<label><i class="fa fa-archive"></i> <?php echo lang('Almacén'); ?></label>
		</div>
	</div>
</div>
<div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
	<div class="input-group">
		<div class="col">
			<div class="form-floating">
				<input class="form-control filt" type="text" id="AlmacenAX2" name="AlmacenAX2" readonly />
			</div>
		</div>
		<button class="btn btn-outline-primary px-1" type="button" onclick="AXmodal(4)"><i class="fa fa-search"></i></button>
	</div>
</div> -->

				<div class="col-12 p-1 <?php echo $notemp; ?>">
					<div class="col">
						<div class="form-floating">
							<select id='IdCompanySelect' name='IdCompanySelect' onchange='selectidcomp(document.getElementById("IdCompanySelect").value);' class="form-select <?php echo $notemprise; ?>" aria-label="Default select example">
								<?php
								$conn = conectar();

								$query = "SELECT '" . $_POST["IdCompanyGrp"] . "' as ID, ' [" . lang('Todas') . "]' as Empresa  union  SELECT Id as ID, comercio as Empresa FROM PosUpCompany where Id in ( " . $_POST["IdCompanyGrp"] . ")  order by Empresa ";
								//echo $query;
								if ($result = mysqli_query($conn, $query)) {
									$n = 0;
									/* obtener array asociativo */
									while ($row = mysqli_fetch_assoc($result)) {
								?><option value="<?php echo trim($row['ID']); ?>" <?php if (trim($row['ID']) == trim($_POST['emprise'])) {
																						echo "selected";
																					}; ?>><?php echo trim($row['Empresa']); ?></option><?
																																	}

																																	mysqli_free_result($result);
																																}
																																		?>
							</select>
							<label><i class="fa fa-sorttt"></i> <?php echo lang('Empresa'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1">
					<div class="col">
						<div class="form-floating">
							<div class="input-daterange input-group" style='display:none' data-date-format="dd/mm/yyyy"></div>
							<input class="form-control " type="date" id="FECHAX" name="FECHAX" />
							<label><i class="fa fa-calendar"></i> <?php echo lang('Desde la Fecha'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1">
					<div class="col">
						<div class="form-floating">
							<div class="input-daterange input-group" style='display:none' data-date-format="dd/mm/yyyy"></div>
							<input class="form-control " type="date" id="FECHAX2" name="FECHAX2" />
							<label><i class="fa fa-calendar"></i> <?php echo lang('Hasta la Fecha'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1">
					<div class="col">
						<div class="form-floating">
							<select class="form-select" id="OrdenAX222" name="OrdenAX222">
								<option value="Ventas"><?php echo lang('Ventas'); ?></option>
								<option value="Cantidad"><?php echo lang('Cantidad'); ?></option>
								<option value="Utilidad"><?php echo lang('Utilidad'); ?></option>
							</select>
							<label><i class="fa fa-sort"></i> <?php echo lang('Orden'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1">
					<div class="col">
						<div class="form-floating">
							<input class="form-control filt" type="text" id="cant" name="cant" value="50" />
							<label><i class="fa fa-bookmark"></i> <?php echo lang('Cantidad'); ?></label>
						</div>
					</div>
				</div>

				<div class="col-12 col-lg-4  p-1">
					<label for="mIdProductos"><i class="fa fa-archive" aria-hidden="true"></i> <?php echo lang("Productos"); ?></label>
					<select id="mIdProductos" name="mIdProductos[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$query = "SELECT CodIdBasico,CodIdAmpliado,CodBarra,Descripcion FROM PosUpProducto a where a.EsCompuesto=0 and a.IdCompany = " . $_POST["Company"] . "";
						if ($result = mysqli_query($conn, $query)) {
							while ($row = mysqli_fetch_assoc($result)) {

						?>
								<option value="<?php echo trim($row['CodIdBasico']); ?>"><?php echo trim($row['Descripcion']); ?></option>
						<?

							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>

				<div class="col-12 col-lg-4  p-1">
					<label for="mIdProevedor"><?php echo lang("Beneficiarios"); ?></label>
					<select id="mIdProevedor" name="mIdProevedor[]" multiple="multiple" style="width: 100%">
					</select>
				</div>

				<div class="col-12 col-lg-4 p-1">
					<label for="mIdAlmacen"><?php echo lang('Almacén'); ?></label>
					<select id="mIdAlmacen" name="mIdAlmacen[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						if ($_POST['sucursal'] == '0') {
							$sql = "SELECT a.*,b.Nombre as UBicacion FROM PosUpAlmacen a inner join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi WHERE a.IdCompany = " . $_POST["Company"] . " ";
						} else {
							$sql = "SELECT a.*,b.Nombre as UBicacion FROM PosUpAlmacen a inner join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi WHERE a.IdCompany = " . $_POST["Company"] . " and b.IdUbi=" . $_POST['sucursal'];
						}
						if ($result = mysqli_query($conn, $sql)) {
							while ($row = mysqli_fetch_assoc($result)) {
						?>
								<option value="<?php echo trim($row['IdAlm']); ?>"><?php echo trim($row['Nombre']); ?></option>
						<?
							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>


				<div class="col-12 col-lg-6 p-1">
					<label for="mIdfamilia"><?php echo lang("Familia"); ?></label>
					<select id="mIdfamilia" name="mIdfamilia[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$query = "SELECT a.IdVarios,if(a.IdVariosPadre=0,a.ITEM,concat(b.ITEM,' > ', a.ITEM)) AS ITEM FROM PosUpvarios a left join PosUpvarios b on a.IdCompany=b.IdCompany and a.IdVariosPadre = b.IdVarios and a.TIPOITEM = b.TIPOITEM and b.TIPOITEM = 2 WHERE a.IdCompany=" . $_POST["Company"] . " and a.TIPOITEM = 2 order by if(a.IdVariosPadre=0,a.ITEM,concat(b.ITEM,' > ', a.ITEM)) asc";
						//echo $query;
						if ($result = mysqli_query($conn, $query)) {
							while ($row = mysqli_fetch_assoc($result)) {

						?>
								<option value="<?php echo trim($row['IdVarios']); ?>"><?php echo trim($row['ITEM']); ?></option>
						<?

							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>
				<div class="col-12 col-lg-6 p-1">
					<label for="mIdMarca"><?php echo lang('Marca'); ?></label>
					<select id="mIdMarca" name="mIdMarca[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$sql = "SELECT idmarca,nombre FROM PosUpc_marcas a where a.IdCompany = " . $_POST["Company"];
						if ($result = mysqli_query($conn, $sql)) {
							while ($row = mysqli_fetch_assoc($result)) {
						?>
								<option value="<?php echo trim($row['idmarca']); ?>"><?php echo trim($row['nombre']); ?></option>
						<?
							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>

				<script>
					$(document).ready(function() {
						$("#mIdProductos").select2({
							dropdownParent: $("#apps-modalz"),
						});
						$("#mIdProevedor").select2({
							ajax: {
								delay: 1000,
								type: "POST",
								dataType: 'json',
								url: 'informezseek.php',
								data: function(params) {
									var queryParameters = {
										search: params.term,
										Accion: "ProveedorBA",
										CompanyActual: document.getElementById("CompanyActual").innerHTML
									}

									return queryParameters;
								},
								processResults: function(data) {
									return {
										results: data.results
									};
								}
							},
							dropdownParent: $("#apps-modalz"),
						});
						$("#mIdAlmacen").select2({
							dropdownParent: $("#apps-modalz"),
						});
						$("#mIdMarca").select2({
							dropdownParent: $("#apps-modalz"),
						});
						$("#mIdfamilia").select2({
							dropdownParent: $("#apps-modalz"),
						});
					});
				</script>
			</div>
		</div>
<!-- analisis producto  -->
		<div class="modal-footer" style="width: 100%;">
		    <div class="row input-group w-100 m-0">
		        <div class="col-3 text-center p-1">
   		         <button class="btn btn-outline-danger w-100" type="reset" id="limpiar">
    		            <i class="fa fa-trash"></i> <?php echo lang('Limpiar'); ?>
   		         </button>
   		     </div>
   		     <div class="col-3 text-center p-1">
   		         <button class="btn btn-outline-primary w-100" type="button" onclick="var f = this.closest('form'); f.action='analisisproducto.php'; f.target='_blank'; f.submit();">
   		             <i class="fa fa-print"></i> <?php echo lang('Preliminar'); ?>
   		         </button>
     		   </div>
     		   <div class="col-3 text-center p-1">
    		        <button class="btn btn-danger w-100" type="button" onclick="var f = this.closest('form'); f.action='reporte_analisis_productos_pdf.php'; f.target='_blank'; f.submit();">
    		            <i class="fa fa-file-pdf-o"></i> PDF
    		        </button>
    		    </div>
				<div class="col text-center p-1">
            		<button class="btn btn-success w-100" type="button" onclick="var f = this.closest('form'); f.action='reporte_analisis_productos_excel.php'; f.target='_self'; f.submit();">
                		<i class="fa fa-file-excel-o"></i> Excel
            		</button>
        		</div>
    		    <div class="col-3 text-center p-1">
    		        <button class="btn btn-outline-secondary w-100" type="button" data-bs-dismiss="modal">
    		            <i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?>
    		        </button>
    		    </div>
    		</div>
		</div>
	</form>
	<script>
		var fecha = new Date();
		var mes = fecha.getMonth() + 1;
		var dia = fecha.getDate();
		var ano = fecha.getFullYear();
		if (dia < 10) {
			dia = '0' + dia;
		}
		if (mes < 10) {
			mes = '0' + mes;
		}
		document.getElementById('FECHAX').value = ano + "-" + mes + "-" + dia;
		document.getElementById('FECHAX2').value = ano + "-" + mes + "-" + dia;
	</script>
<?php
}

if ($_POST["Accion"] === "4") {
	$sql = "SELECT LitP01,LitP02,LitP03,LitP04,LitP05,LitP06,LitP07,LitP08,LitP09,LitP10,LitCosto FROM PosUpCompany 
	where Id=" . $_POST["Company"] . "";
	if ($result = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$LitP01 = $row["LitP01"];
			$LitP02 = $row["LitP02"];
			$LitP03 = $row["LitP03"];
			$LitP04 = $row["LitP04"];
			$LitP05 = $row["LitP05"];
			$LitP06 = $row["LitP06"];
			$LitP07 = $row["LitP07"];
			$LitP08 = $row["LitP08"];
			$LitP09 = $row["LitP09"];
			$LitP10 = $row["LitP10"];
			$LitCosto = $row["LitCosto"];
		}
	}
	?>
	<div class="modal-header">
		<h5 class="modal-title"><img src="/img/informez.png" alt="informe" height="24px" width="24px"> <?php echo lang('Lista de Precios'); ?></h5>
		<button class="btn-close" type="button" data-bs-dismiss="modal"></button>
	</div>
	<form id="ListaPrecio" method="POST" target="_Blank" action="mercanciaLP.php" onsubmit="return false">
		<div class="modal-body">
			<input type="hidden" name="fectx5" id="fectx5" />

			<input type="hidden" name="CompanyActual" value="<?php echo $_POST['Company']; ?>" />
			<input type="hidden" name="IdCompanyGrp" value="<?php echo $_POST['IdCompanyGrp']; ?>" />
			<input type="hidden" name="CIdPlan" value="<?php echo $_POST['CIdPlan']; ?>" />
			<input type="hidden" name="SimMil" value="<?php echo $_POST['SimMil']; ?>" />
			<input type="hidden" name="SimDec" value="<?php echo $_POST['SimDec']; ?>" />
			<input type="hidden" name="CD" value="<?php echo $_POST['CD']; ?>" />
			<input type="hidden" name="direccion" value="<?php echo $_POST['direccion']; ?>" />
			<input type="hidden" name="NameCompany" value="<?php echo $_POST['NameCompany']; ?>" />
			<input type="hidden" name="sucursal" value="<?php echo $_POST['sucursal']; ?>" />
			<span style="display:none" id="devueltachavalesLP"></span>
			<span style="display:none" id="CodigoDesaLLP"></span>
			<span style="display:none" id="CodigoHasaLLP"></span>
			<span style="display:none" id="BenefeLLP"></span>
			<span style="display:none" id="AlmaLLP"></span>
			<span style="display:none" id="MarLLP"></span>


			<div class="row p-1">
				<div class="col-12  p-1 <?php echo $notemp; ?>">
					<div class="col">
						<div class="form-floating">
							<select id='IdCompanySelect' name='IdCompanySelect' onchange='selectidcomp(document.getElementById("IdCompanySelect").value);' class="form-select <?php echo $notemprise; ?>" aria-label="Default select example">
								<?php
								$conn = conectar();

								$query = "SELECT '" . $_POST["IdCompanyGrp"] . "' as ID, ' [" . lang('Todas') . "]' as Empresa  union  SELECT Id as ID, comercio as Empresa FROM PosUpCompany where Id in ( " . $_POST["IdCompanyGrp"] . ")  order by Empresa ";
								//echo $query;
								if ($result = mysqli_query($conn, $query)) {
									$n = 0;
									/* obtener array asociativo */
									while ($row = mysqli_fetch_assoc($result)) {
								?><option value="<?php echo trim($row['ID']); ?>" <?php if (trim($row['ID']) == trim($_POST['emprise'])) {
																						echo "selected";
																					}; ?>><?php echo trim($row['Empresa']); ?></option><?
																																	}

																																	mysqli_free_result($result);
																																}
																																		?>
							</select>
							<label><i class="fa fa-sorttt"></i> <?php echo lang('Empresa'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 p-1">
					<div class="form-floating">
						<select name="SelectTasa" id="SelectTasa" class="form-select">
							<?php

							$GenTxFactorDCambio = "";
							$query = "SELECT FactorDolarCash,FactorDolarPaypal,FactorDolarZelle,Moneda3,Moneda4,MonedaP,MonedaS,MonedaP,LitPrincipalEfectivo,Moneda5,Moneda6,Moneda7,FactorDolar5,FactorDolar6,FactorDolar7 FROM PosUpCompany WHERE Id=" . $_POST['Company'] . "";
							if ($result = mysqli_query($conn, $query)) {
								while ($row = mysqli_fetch_assoc($result)) {
									$GenTxFactorDCambio .= "<option value='1' >" . $row['MonedaP'] . "</option>";
									if ($row['FactorDolarCash'] > 1) $GenTxFactorDCambio .= "<option value='2' >" . ($row["LitPrincipalEfectivo"] === "" ? $row['MonedaS'] : $row["LitPrincipalEfectivo"])  . "</option>";
									if ($row['FactorDolarPaypal'] > 1) $GenTxFactorDCambio .= "<option value='3' >" . $row['Moneda3'] . "</option>";
									if ($row['FactorDolarZelle'] > 1) $GenTxFactorDCambio .= "<option value='4' >" . $row['Moneda4'] . "</option>";
									if ($row['FactorDolar5'] > 1) $GenTxFactorDCambio .= "<option value='5' >" . $row['Moneda5'] . "</option>";
									if ($row['FactorDolar6'] > 1) $GenTxFactorDCambio .= "<option value='6' >" . $row['Moneda6'] . "</option>";
									if ($row['FactorDolar7'] > 1) $GenTxFactorDCambio .= "<option value='7' >" . $row['Moneda7'] . "</option>";
								}
								mysqli_free_result($result);
							}
							echo $GenTxFactorDCambio;
							?>
						</select>
						<label><i class="fa fa-money" aria-hidden="true"></i>&nbsp;<?php echo lang('Tasa') ?></label>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1">
					<div class="col">
						<div class="form-floating">
							<select class="form-select" id="OrdenLP" name="OrdenLP">
								<option value="Codigo"><?php echo lang('Código'); ?></option>
								<option value="Descripcion"><?php echo lang('Descripción'); ?></option>
								<option value="Instancia"><?php echo lang('Familia'); ?></option>
								<option value="PrecioNeto"><?php echo lang('Precio'); ?></option>
								<option value="Marca"><?php echo lang('Marca'); ?></option>
							</select>
							<label><i class="fa fa-sort"></i> <?php echo lang('Orden'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1">
					<div class="col">
						<div class="form-floating">
							<div class="input-daterange input-group" style='display:none' data-date-format="dd/mm/yyyy"></div>
							<input class="form-control" type="date" id="FechaHastalista" name="FechaHastalista">
							<label><i class="fa fa-calendar"></i> <?php echo lang('Hasta la Fecha'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1">
					<div class="col">
						<div class="form-floating">
							<select class="form-select" id="Agrupar" name="Agrupar">
								<option value="empty"><?php echo lang('Ninguno'); ?></option>
								<option value="Familiazp"><?php echo lang('Familia'); ?></option>
								<option value="Marcazp"><?php echo lang('Marca'); ?></option>
							</select>
							<label><i class="fa fa-object-group"></i> <?php echo lang('Agrupamiento'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1">
					<div class="col">
						<div class="form-floating">
							<select class="form-select" name="EnvioEstado" id="EnvioEstado">
								<option value="*"><?php echo lang("Todos"); ?></option>
								<option value="1"><?php echo lang("Activo"); ?></option>
								<option value="0"><?php echo lang("Inactivo"); ?></option>
							</select>
							<label><i class="fa fa-hourglass" aria-hidden="true"></i>&nbsp;<?php echo lang('Estado'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<label for="mIdfamilia"><?php echo lang("Familia"); ?></label>
					<select id="mIdfamilia" name="mIdfamilia[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$query = "SELECT a.IdVarios,if(a.IdVariosPadre=0,a.ITEM,concat(b.ITEM,' > ', a.ITEM)) AS ITEM FROM PosUpvarios a left join PosUpvarios b on a.IdCompany=b.IdCompany and a.IdVariosPadre = b.IdVarios and a.TIPOITEM = b.TIPOITEM and b.TIPOITEM = 2 WHERE a.IdCompany=" . $_POST["Company"] . " and a.TIPOITEM = 2 order by if(a.IdVariosPadre=0,a.ITEM,concat(b.ITEM,' > ', a.ITEM)) asc";
						//echo $query;
						if ($result = mysqli_query($conn, $query)) {
							while ($row = mysqli_fetch_assoc($result)) {

						?>
								<option value="<?php echo trim($row['IdVarios']); ?>"><?php echo trim($row['ITEM']); ?></option>
						<?

							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<label for="mIdMarca"><?php echo lang('Marca'); ?></label>
					<select id="mIdMarca" name="mIdMarca[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$sql = "SELECT idmarca,nombre FROM PosUpc_marcas a where a.IdCompany = " . $_POST["Company"];
						if ($result = mysqli_query($conn, $sql)) {
							while ($row = mysqli_fetch_assoc($result)) {
						?>
								<option value="<?php echo trim($row['idmarca']); ?>"><?php echo trim($row['nombre']); ?></option>
						<?
							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<label for="mIdAlmacen"><?php echo lang('Almacén'); ?></label>
					<select id="mIdAlmacen" name="mIdAlmacen[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						if ($_POST['sucursal'] == '0') {
							$sql = "SELECT a.*,b.Nombre as UBicacion FROM PosUpAlmacen a inner join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi WHERE a.IdCompany = " . $_POST["Company"] . " ";
						} else {
							$sql = "SELECT a.*,b.Nombre as UBicacion FROM PosUpAlmacen a inner join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi WHERE a.IdCompany = " . $_POST["Company"] . " and b.IdUbi=" . $_POST['sucursal'];
						}
						if ($result = mysqli_query($conn, $sql)) {
							while ($row = mysqli_fetch_assoc($result)) {
						?>
								<option value="<?php echo trim($row['IdAlm']); ?>"><?php echo trim($row['Nombre']); ?></option>
						<?
							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>

				<div class="col-12 p-1">
					<label for="mIdProductos"><i class="fa fa-archive" aria-hidden="true"></i> <?php echo lang("Productos"); ?></label>
					<select id="mIdProductos" name="mIdProductos[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$query = "SELECT CodIdBasico,CodIdAmpliado,CodBarra,Descripcion FROM PosUpProducto a where  a.IdCompany = " . $_POST["Company"] . " and a.EsCompuesto in (20,1,0)";
						if ($result = mysqli_query($conn, $query)) {
							while ($row = mysqli_fetch_assoc($result)) {

						?>
								<option value="<?php echo trim($row['CodIdBasico']); ?>">(<?php echo $row["CodIdAmpliado"]; ?>) <?php echo trim($row['Descripcion']); ?></option>
						<?

							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>
				<script>
					$(document).ready(function() {
						$("#mIdProductos").select2({
							dropdownParent: $("#apps-modalz"),
						});
						$("#mIdMarca").select2({
							dropdownParent: $("#apps-modalz"),
						});
						$("#mIdAlmacen").select2({
							dropdownParent: $("#apps-modalz"),
						});
						$("#mIdfamilia").select2({
							dropdownParent: $("#apps-modalz"),
						});
					});
				</script>

			</div>

			<div class="row p-1">
				<?php if ($_POST["userperfil"] <= 2000 or $c0 == 1 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="costozzzv" id="costozzzv">
							<label class="form-check-label" for="costozzzv">
								<?php echo (trim($LitCosto) !== "" ? $LitCosto : lang("Costo")); ?>
							</label>
						</div>
					</div>
				<?php } ?>
				<?php if ($_POST["userperfil"] <= 2000 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="Existencia" id="Existencia">
							<label class="form-check-label" for="Existencia">
								<?php echo lang('Mostrar Existencia'); ?>
							</label>
						</div>
					</div>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="cimp" id="cimp">
							<label class="form-check-label" for="cimp">
								<?php echo lang('Con Impuesto'); ?>
							</label>
						</div>
					</div>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="ExistenciaCero" id="ExistenciaCero">
							<label class="form-check-label" for="ExistenciaCero">
								<?php echo lang('Existencia Cero'); ?>
							</label>
						</div>
					</div>
				<?php } ?>

				<?php if ($_POST['userperfil'] <= 2000 or $p1 == 1 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="precioz" id="precioz">
							<label class="form-check-label" for="precioz">
								<?php echo (trim($LitP01) !== "" ? $LitP01 : lang("Precio") . " 1"); ?>
							</label>
						</div>
					</div>
				<?php } ?>

				<?php if ($_POST['userperfil'] <= 2000 or $p2 == 1 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="precio2z" id="precio2z">
							<label class="form-check-label" for="precio2z">
								<?php echo (trim($LitP02) !== "" ? $LitP02 : lang("Precio") . " 2"); ?>
							</label>
						</div>
					</div>
				<?php } ?>

				<?php if ($_POST['userperfil'] <= 2000 or $p3 == 1 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="precio3z" id="precio3z">
							<label class="form-check-label" for="precio3z">
								<?php echo (trim($LitP03) !== "" ? $LitP03 : lang("Precio") . " 3"); ?>
							</label>
						</div>
					</div>
				<?php } ?>
				<?php if ($_POST['userperfil'] <= 2000 or $p4 == 1 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="precio4z" id="precio4z">
							<label class="form-check-label" for="precio4z">
								<?php echo (trim($LitP04) !== "" ? $LitP04 : lang("Precio") . " 4"); ?>
							</label>
						</div>
					</div>
				<?php } ?>
				<?php if ($_POST['userperfil'] <= 2000 or $p5 == 1 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="precio5z" id="precio5z">
							<label class="form-check-label" for="precio5z">
								<?php echo (trim($LitP05) !== "" ? $LitP05 : lang("Precio") . " 5"); ?>
							</label>
						</div>
					</div>
				<?php } ?>
				<?php if ($_POST['userperfil'] <= 2000 or $p6 == 1 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="precio6z" id="precio6z">
							<label class="form-check-label" for="precio6z">
								<?php echo (trim($LitP06) !== "" ? $LitP06 : lang("Precio") . " 6"); ?>
							</label>
						</div>
					</div>
				<?php } ?>
				<?php if ($_POST['userperfil'] <= 2000 or $p7 == 1 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="precio7z" id="precio7z">
							<label class="form-check-label" for="precio7z">
								<?php echo (trim($LitP07) !== "" ? $LitP07 : lang("Precio") . " 7"); ?>
							</label>
						</div>
					</div>
				<?php } ?>
				<?php if ($_POST['userperfil'] <= 2000 or $p8 == 1 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="precio8z" id="precio8z">
							<label class="form-check-label" for="precio8z">
								<?php echo (trim($LitP08) !== "" ? $LitP08 : lang("Precio") . " 8"); ?>
							</label>
						</div>
					</div>
				<?php } ?>
				<?php if ($_POST['userperfil'] <= 2000 or $p9 == 1 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="precio9z" id="precio9z">
							<label class="form-check-label" for="precio9z">
								<?php echo (trim($LitP09) !== "" ? $LitP09 : lang("Precio") . " 9"); ?>
							</label>
						</div>
					</div>
				<?php } ?>
				<?php if ($_POST['userperfil'] <= 2000 or $p10 == 1 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="precio10z" id="precio10z">
							<label class="form-check-label" for="precio10z">
								<?php echo (trim($LitP10) !== "" ? $LitP10 : lang("Precio") . " 10"); ?>
							</label>
						</div>
					</div>
				<?php } ?>

				<div class="col-6 col-md-4">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="PreciosCeroNo" id="PreciosCeroNo">
						<label class="form-check-label" for="PreciosCeroNo">
							<?php echo lang('No Mostrar Precios en cero'); ?>
						</label>
					</div>
				</div>
				<div class="col-6 col-md-4">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="MostrarFamilias" id="MostrarFamilias">
						<label class="form-check-label" for="MostrarFamilias">
							<?php echo lang('Familia'); ?>
						</label>
					</div>
				</div>
				<div class="col-6 col-md-4">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="MostrarMarcas" id="MostrarMarcas">
						<label class="form-check-label" for="MostrarMarcas">
							<?php echo lang('Marca'); ?>
						</label>
					</div>
				</div>
			</div>
		</div>
<!-- Lista de Precios -->
		<div class="row input-group w-100 m-0">
   			 <div class="col-3 text-center p-1">
  			      <button class="btn btn-outline-danger w-100" type="reset" id="limpiar">
  			          <i class="fa fa-trash"></i> <?php echo lang('Limpiar'); ?>
 			       </button>
 			   </div>
 			   <div class="col-3 text-center p-1">
 			       <button class="btn btn-outline-primary w-100" type="button" onclick="var f = this.closest('form'); f.action='mercanciaLP.php'; f.target='_blank'; f.submit();">
 			           <i class="fa fa-print"></i> <?php echo lang('Preliminar'); ?>
 			       </button>
 			   </div>
 			   <div class="col-3 text-center p-1">
 			       <button class="btn btn-danger w-100" type="button" onclick="var f = this.closest('form'); f.action='reporte_listaprecios_pdf.php'; f.target='_blank'; f.submit();">
 			           <i class="fa fa-file-pdf-o"></i> PDF
 			       </button>
 			   </div>
			   <div class="col text-center p-1">
            		<button class="btn btn-success w-100" type="button" onclick="var f = this.closest('form'); f.action='reporte_listaprecios_excel.php'; f.target='_self'; f.submit();">
                		<i class="fa fa-file-excel-o"></i> Excel
            		</button>
       			</div>
 			   <div class="col-3 text-center p-1">
  			      <button class="btn btn-outline-secondary w-100" type="button" data-bs-dismiss="modal">
    			        <i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?>
    			    </button>
    			</div>
			</div>
	</form>

	<script>
		var fecha = new Date();
		var mes = fecha.getMonth() + 1;
		var dia = fecha.getDate();
		var ano = fecha.getFullYear();
		if (dia < 10) {
			dia = '0' + dia;
		}
		if (mes < 10) {
			mes = '0' + mes;
		}
		document.getElementById('FechaHastalista').value = ano + "-" + mes + "-" + dia;
	</script>
<?php
}
if ($_POST["Accion"] === "99") {
	$sql = "SELECT LitP01,LitP02,LitP03,LitP04,LitP05,LitP06,LitP07,LitP08,LitP09,LitP10,LitCosto FROM PosUpCompany 
	where Id=" . $_POST["Company"] . "";
	if ($result = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$LitP01 = $row["LitP01"];
			$LitP02 = $row["LitP02"];
			$LitP03 = $row["LitP03"];
			$LitP04 = $row["LitP04"];
			$LitP05 = $row["LitP05"];
			$LitP06 = $row["LitP06"];
			$LitP07 = $row["LitP07"];
			$LitP08 = $row["LitP08"];
			$LitP09 = $row["LitP09"];
			$LitP10 = $row["LitP10"];
			$LitCosto = $row["LitCosto"];
		}
	}
	?>
	<div class="modal-header">
		<h5 class="modal-title"><img src="/img/informez.png" alt="informe" height="24px" width="24px"> <?php echo lang('Lista de Precios'); ?></h5>
		<button class="btn-close" type="button" data-bs-dismiss="modal"></button>
	</div>
	<form id="ListaPrecio" method="POST" target="_Blank" action="mercanciaLp-new.php" onsubmit="return false">
		<div class="modal-body">
			<input type="hidden" name="fectx5" id="fectx5" />

			<input type="hidden" name="CompanyActual" value="<?php echo $_POST['Company']; ?>" />
			<input type="hidden" name="IdCompanyGrp" value="<?php echo $_POST['IdCompanyGrp']; ?>" />
			<input type="hidden" name="CIdPlan" value="<?php echo $_POST['CIdPlan']; ?>" />
			<input type="hidden" name="SimMil" value="<?php echo $_POST['SimMil']; ?>" />
			<input type="hidden" name="SimDec" value="<?php echo $_POST['SimDec']; ?>" />
			<input type="hidden" name="CD" value="<?php echo $_POST['CD']; ?>" />
			<input type="hidden" name="direccion" value="<?php echo $_POST['direccion']; ?>" />
			<input type="hidden" name="NameCompany" value="<?php echo $_POST['NameCompany']; ?>" />
			<input type="hidden" name="sucursal" value="<?php echo $_POST['sucursal']; ?>" />
			<span style="display:none" id="devueltachavalesLP"></span>
			<span style="display:none" id="CodigoDesaLLP"></span>
			<span style="display:none" id="CodigoHasaLLP"></span>
			<span style="display:none" id="BenefeLLP"></span>
			<span style="display:none" id="AlmaLLP"></span>
			<span style="display:none" id="MarLLP"></span>


			<div class="row p-1">
				<div class="col-12  p-1 <?php echo $notemp; ?>">
					<div class="col">
						<div class="form-floating">
							<select id='IdCompanySelect' name='IdCompanySelect' onchange='selectidcomp(document.getElementById("IdCompanySelect").value);' class="form-select <?php echo $notemprise; ?>" aria-label="Default select example">
								<?php
								$conn = conectar();

								$query = "SELECT '" . $_POST["IdCompanyGrp"] . "' as ID, ' [" . lang('Todas') . "]' as Empresa  union  SELECT Id as ID, comercio as Empresa FROM PosUpCompany where Id in ( " . $_POST["IdCompanyGrp"] . ")  order by Empresa ";
								//echo $query;
								if ($result = mysqli_query($conn, $query)) {
									$n = 0;
									/* obtener array asociativo */
									while ($row = mysqli_fetch_assoc($result)) {
								?><option value="<?php echo trim($row['ID']); ?>" <?php if (trim($row['ID']) == trim($_POST['emprise'])) {
																						echo "selected";
																					}; ?>><?php echo trim($row['Empresa']); ?></option><?
																																	}

																																	mysqli_free_result($result);
																																}
																																		?>
							</select>
							<label><i class="fa fa-sorttt"></i> <?php echo lang('Empresa'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 p-1">
					<div class="form-floating">
						<select name="SelectTasa" id="SelectTasa" class="form-select">
							<?php

							$GenTxFactorDCambio = "";
							$query = "SELECT FactorDolarCash,FactorDolarPaypal,FactorDolarZelle,Moneda3,Moneda4,MonedaP,MonedaS,MonedaP,LitPrincipalEfectivo,Moneda5,Moneda6,Moneda7,FactorDolar5,FactorDolar6,FactorDolar7 FROM PosUpCompany WHERE Id=" . $_POST['Company'] . "";
							if ($result = mysqli_query($conn, $query)) {
								while ($row = mysqli_fetch_assoc($result)) {
									$GenTxFactorDCambio .= "<option value='1' >" . $row['MonedaP'] . "</option>";
									if ($row['FactorDolarCash'] > 1) $GenTxFactorDCambio .= "<option value='2' >" . ($row["LitPrincipalEfectivo"] === "" ? $row['MonedaS'] : $row["LitPrincipalEfectivo"])  . "</option>";
									if ($row['FactorDolarPaypal'] > 1) $GenTxFactorDCambio .= "<option value='3' >" . $row['Moneda3'] . "</option>";
									if ($row['FactorDolarZelle'] > 1) $GenTxFactorDCambio .= "<option value='4' >" . $row['Moneda4'] . "</option>";
									if ($row['FactorDolar5'] > 1) $GenTxFactorDCambio .= "<option value='5' >" . $row['Moneda5'] . "</option>";
									if ($row['FactorDolar6'] > 1) $GenTxFactorDCambio .= "<option value='6' >" . $row['Moneda6'] . "</option>";
									if ($row['FactorDolar7'] > 1) $GenTxFactorDCambio .= "<option value='7' >" . $row['Moneda7'] . "</option>";
								}
								mysqli_free_result($result);
							}
							echo $GenTxFactorDCambio;
							?>
						</select>
						<label><i class="fa fa-money" aria-hidden="true"></i>&nbsp;<?php echo lang('Tasa') ?></label>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1">
					<div class="col">
						<div class="form-floating">
							<select class="form-select" id="OrdenLP" name="OrdenLP">
								<option value="Codigo"><?php echo lang('Código'); ?></option>
								<option value="Descripcion"><?php echo lang('Descripción'); ?></option>
								<option value="Instancia"><?php echo lang('Familia'); ?></option>
								<option value="PrecioNeto"><?php echo lang('Precio'); ?></option>
								<option value="Marca"><?php echo lang('Marca'); ?></option>
							</select>
							<label><i class="fa fa-sort"></i> <?php echo lang('Orden'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1">
					<div class="col">
						<div class="form-floating">
							<div class="input-daterange input-group" style='display:none' data-date-format="dd/mm/yyyy"></div>
							<input class="form-control" type="date" id="FechaHastalista" name="FechaHastalista">
							<label><i class="fa fa-calendar"></i> <?php echo lang('Hasta la Fecha'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1">
					<div class="col">
						<div class="form-floating">
							<select class="form-select" id="Agrupar" name="Agrupar">
								<option value="empty"><?php echo lang('Ninguno'); ?></option>
								<option value="Familiazp"><?php echo lang('Familia'); ?></option>
								<option value="Marcazp"><?php echo lang('Marca'); ?></option>
							</select>
							<label><i class="fa fa-object-group"></i> <?php echo lang('Agrupamiento'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1">
					<div class="col">
						<div class="form-floating">
							<select class="form-select" name="EnvioEstado" id="EnvioEstado">
								<option value="*"><?php echo lang("Todos"); ?></option>
								<option value="1"><?php echo lang("Activo"); ?></option>
								<option value="0"><?php echo lang("Inactivo"); ?></option>
							</select>
							<label><i class="fa fa-hourglass" aria-hidden="true"></i>&nbsp;<?php echo lang('Estado'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<label for="mIdfamilia"><?php echo lang("Familia"); ?></label>
					<select id="mIdfamilia" name="mIdfamilia[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$query = "SELECT a.IdVarios,if(a.IdVariosPadre=0,a.ITEM,concat(b.ITEM,' > ', a.ITEM)) AS ITEM FROM PosUpvarios a left join PosUpvarios b on a.IdCompany=b.IdCompany and a.IdVariosPadre = b.IdVarios and a.TIPOITEM = b.TIPOITEM and b.TIPOITEM = 2 WHERE a.IdCompany=" . $_POST["Company"] . " and a.TIPOITEM = 2 order by if(a.IdVariosPadre=0,a.ITEM,concat(b.ITEM,' > ', a.ITEM)) asc";
						//echo $query;
						if ($result = mysqli_query($conn, $query)) {
							while ($row = mysqli_fetch_assoc($result)) {

						?>
								<option value="<?php echo trim($row['IdVarios']); ?>"><?php echo trim($row['ITEM']); ?></option>
						<?

							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<label for="mIdMarca"><?php echo lang('Marca'); ?></label>
					<select id="mIdMarca" name="mIdMarca[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$sql = "SELECT idmarca,nombre FROM PosUpc_marcas a where a.IdCompany = " . $_POST["Company"];
						if ($result = mysqli_query($conn, $sql)) {
							while ($row = mysqli_fetch_assoc($result)) {
						?>
								<option value="<?php echo trim($row['idmarca']); ?>"><?php echo trim($row['nombre']); ?></option>
						<?
							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<label for="mIdAlmacen"><?php echo lang('Almacén'); ?></label>
					<select id="mIdAlmacen" name="mIdAlmacen[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						if ($_POST['sucursal'] == '0') {
							$sql = "SELECT a.*,b.Nombre as UBicacion FROM PosUpAlmacen a inner join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi WHERE a.IdCompany = " . $_POST["Company"] . " ";
						} else {
							$sql = "SELECT a.*,b.Nombre as UBicacion FROM PosUpAlmacen a inner join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi WHERE a.IdCompany = " . $_POST["Company"] . " and b.IdUbi=" . $_POST['sucursal'];
						}
						if ($result = mysqli_query($conn, $sql)) {
							while ($row = mysqli_fetch_assoc($result)) {
						?>
								<option value="<?php echo trim($row['IdAlm']); ?>"><?php echo trim($row['Nombre']); ?></option>
						<?
							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>

				<div class="col-12 p-1">
					<label for="mIdProductos"><i class="fa fa-archive" aria-hidden="true"></i> <?php echo lang("Productos"); ?></label>
					<select id="mIdProductos" name="mIdProductos[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$query = "SELECT CodIdBasico,CodIdAmpliado,CodBarra,Descripcion FROM PosUpProducto a where  a.IdCompany = " . $_POST["Company"] . " and a.EsCompuesto in (20,1,0)";
						if ($result = mysqli_query($conn, $query)) {
							while ($row = mysqli_fetch_assoc($result)) {

						?>
								<option value="<?php echo trim($row['CodIdBasico']); ?>">(<?php echo $row["CodIdAmpliado"]; ?>) <?php echo trim($row['Descripcion']); ?></option>
						<?

							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>
				<script>
					$(document).ready(function() {
						$("#mIdProductos").select2({
							dropdownParent: $("#apps-modalz"),
						});
						$("#mIdMarca").select2({
							dropdownParent: $("#apps-modalz"),
						});
						$("#mIdAlmacen").select2({
							dropdownParent: $("#apps-modalz"),
						});
						$("#mIdfamilia").select2({
							dropdownParent: $("#apps-modalz"),
						});
					});
				</script>

			</div>

			<div class="row p-1">
				<?php if ($_POST["userperfil"] <= 2000 or $c0 == 1 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="costozzzv" id="costozzzv">
							<label class="form-check-label" for="costozzzv">
								<?php echo (trim($LitCosto) !== "" ? $LitCosto : lang("Costo")); ?>
							</label>
						</div>
					</div>
				<?php } ?>
				<?php if ($_POST["userperfil"] <= 2000 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="Existencia" id="Existencia">
							<label class="form-check-label" for="Existencia">
								<?php echo lang('Mostrar Existencia'); ?>
							</label>
						</div>
					</div>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="cimp" id="cimp">
							<label class="form-check-label" for="cimp">
								<?php echo lang('Con Impuesto'); ?>
							</label>
						</div>
					</div>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="ExistenciaCero" id="ExistenciaCero">
							<label class="form-check-label" for="ExistenciaCero">
								<?php echo lang('Existencia Cero'); ?>
							</label>
						</div>
					</div>
				<?php } ?>

				<?php if ($_POST['userperfil'] <= 2000 or $p1 == 1 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="precioz" id="precioz">
							<label class="form-check-label" for="precioz">
								<?php echo (trim($LitP01) !== "" ? $LitP01 : lang("Precio") . " 1"); ?>
							</label>
						</div>
					</div>
				<?php } ?>

				<?php if ($_POST['userperfil'] <= 2000 or $p2 == 1 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="precio2z" id="precio2z">
							<label class="form-check-label" for="precio2z">
								<?php echo (trim($LitP02) !== "" ? $LitP02 : lang("Precio") . " 2"); ?>
							</label>
						</div>
					</div>
				<?php } ?>

				<?php if ($_POST['userperfil'] <= 2000 or $p3 == 1 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="precio3z" id="precio3z">
							<label class="form-check-label" for="precio3z">
								<?php echo (trim($LitP03) !== "" ? $LitP03 : lang("Precio") . " 3"); ?>
							</label>
						</div>
					</div>
				<?php } ?>
				<?php if ($_POST['userperfil'] <= 2000 or $p4 == 1 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="precio4z" id="precio4z">
							<label class="form-check-label" for="precio4z">
								<?php echo (trim($LitP04) !== "" ? $LitP04 : lang("Precio") . " 4"); ?>
							</label>
						</div>
					</div>
				<?php } ?>
				<?php if ($_POST['userperfil'] <= 2000 or $p5 == 1 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="precio5z" id="precio5z">
							<label class="form-check-label" for="precio5z">
								<?php echo (trim($LitP05) !== "" ? $LitP05 : lang("Precio") . " 5"); ?>
							</label>
						</div>
					</div>
				<?php } ?>
				<?php if ($_POST['userperfil'] <= 2000 or $p6 == 1 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="precio6z" id="precio6z">
							<label class="form-check-label" for="precio6z">
								<?php echo (trim($LitP06) !== "" ? $LitP06 : lang("Precio") . " 6"); ?>
							</label>
						</div>
					</div>
				<?php } ?>
				<?php if ($_POST['userperfil'] <= 2000 or $p7 == 1 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="precio7z" id="precio7z">
							<label class="form-check-label" for="precio7z">
								<?php echo (trim($LitP07) !== "" ? $LitP07 : lang("Precio") . " 7"); ?>
							</label>
						</div>
					</div>
				<?php } ?>
				<?php if ($_POST['userperfil'] <= 2000 or $p8 == 1 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="precio8z" id="precio8z">
							<label class="form-check-label" for="precio8z">
								<?php echo (trim($LitP08) !== "" ? $LitP08 : lang("Precio") . " 8"); ?>
							</label>
						</div>
					</div>
				<?php } ?>
				<?php if ($_POST['userperfil'] <= 2000 or $p9 == 1 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="precio9z" id="precio9z">
							<label class="form-check-label" for="precio9z">
								<?php echo (trim($LitP09) !== "" ? $LitP09 : lang("Precio") . " 9"); ?>
							</label>
						</div>
					</div>
				<?php } ?>
				<?php if ($_POST['userperfil'] <= 2000 or $p10 == 1 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="precio10z" id="precio10z">
							<label class="form-check-label" for="precio10z">
								<?php echo (trim($LitP10) !== "" ? $LitP10 : lang("Precio") . " 10"); ?>
							</label>
						</div>
					</div>
				<?php } ?>

				<div class="col-6 col-md-4">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="PreciosCeroNo" id="PreciosCeroNo">
						<label class="form-check-label" for="PreciosCeroNo">
							<?php echo lang('No Mostrar Precios en cero'); ?>
						</label>
					</div>
				</div>
				<div class="col-6 col-md-4">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="MostrarFamilias" id="MostrarFamilias">
						<label class="form-check-label" for="MostrarFamilias">
							<?php echo lang('Familia'); ?>
						</label>
					</div>
				</div>
				<div class="col-6 col-md-4">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="MostrarMarcas" id="MostrarMarcas">
						<label class="form-check-label" for="MostrarMarcas">
							<?php echo lang('Marca'); ?>
						</label>
					</div>
				</div>
			</div>
		</div>
<!-- Lista de Precios  4 -->
		<div class="row input-group w-100 m-0">
   			 <div class="col-3 text-center p-1">
  			      <button class="btn btn-outline-danger w-100" type="reset" id="limpiar">
  			          <i class="fa fa-trash"></i> <?php echo lang('Limpiar'); ?>
 			       </button>
 			   </div>
 			   <div class="col-3 text-center p-1">
 			       <button class="btn btn-outline-primary w-100" type="button" onclick="var f = this.closest('form'); f.action='mercanciaLP.php'; f.target='_blank'; f.submit();">
 			           <i class="fa fa-print"></i> <?php echo lang('Preliminar'); ?>
 			       </button>
 			   </div>
 			   
 			   <div class="col-3 text-center p-1">
  			      <button class="btn btn-outline-secondary w-100" type="button" data-bs-dismiss="modal">
    			        <i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?>
    			    </button>
    			</div>
			</div>
	</form>

	<script>
		var fecha = new Date();
		var mes = fecha.getMonth() + 1;
		var dia = fecha.getDate();
		var ano = fecha.getFullYear();
		if (dia < 10) {
			dia = '0' + dia;
		}
		if (mes < 10) {
			mes = '0' + mes;
		}
		document.getElementById('FechaHastalista').value = ano + "-" + mes + "-" + dia;
	</script>
<?php
}
if ($_POST["Accion"] === "5") {
?>
	<div class="modal-header">
		<h5 class="modal-title"><img src="/img/informez.png" alt="informe" height="24px" width="24px"> <?php echo lang('Inventario Físico'); ?></h5>
		<button class="btn-close" type="button" data-bs-dismiss="modal"></button>
	</div>
	<form id="Productos" method="POST" target="_Blank" action="inventariofisico.php" onsubmit="return false">
		<div class="modal-body">
			<input type="hidden" name="fectx5" id="fectx5" />

			<input type="hidden" name="CompanyActual" value="<?php echo $_POST['Company']; ?>" />
			<input type="hidden" name="IdCompanyGrp" value="<?php echo $_POST['IdCompanyGrp']; ?>" />
			<input type="hidden" name="CIdPlan" value="<?php echo $_POST['CIdPlan']; ?>" />
			<input type="hidden" name="SimMil" value="<?php echo $_POST['SimMil']; ?>" />
			<input type="hidden" name="SimDec" value="<?php echo $_POST['SimDec']; ?>" />
			<input type="hidden" name="CD" value="<?php echo $_POST['CD']; ?>" />
			<input type="hidden" name="direccion" value="<?php echo $_POST['direccion']; ?>" />
			<input type="hidden" name="NameCompany" value="<?php echo $_POST['NameCompany']; ?>" />
			<input type="hidden" name="sucursal" value="<?php echo $_POST['sucursal']; ?>" />
			<span style="display:none" id="devueltachavalesAXX"></span>
			<span style="display:none" id="CodigoDesaAXX"></span>
			<span style="display:none" id="CodigoHasaAXX"></span>
			<span style="display:none" id="BenefeAXX"></span>
			<span style="display:none" id="AlmaAXX"></span>
			<div class="row p-1">

				<div class="col-12 p-1 <?php echo $notemp; ?>">
					<div class="col">
						<div class="form-floating">
							<select id='IdCompanySelect' name='IdCompanySelect' onchange='selectidcomp(document.getElementById("IdCompanySelect").value);' class="form-select <?php echo $notemprise; ?>" aria-label="Default select example">
								<?php
								$conn = conectar();

								$query = "SELECT '" . $_POST["IdCompanyGrp"] . "' as ID, ' [" . lang('Todas') . "]' as Empresa  union  SELECT Id as ID, comercio as Empresa FROM PosUpCompany where Id in ( " . $_POST["IdCompanyGrp"] . ")  order by Empresa ";
								//echo $query;
								if ($result = mysqli_query($conn, $query)) {
									$n = 0;
									/* obtener array asociativo */
									while ($row = mysqli_fetch_assoc($result)) {
								?><option value="<?php echo trim($row['ID']); ?>" <?php if (trim($row['ID']) == trim($_POST['emprise'])) {
																						echo "selected";
																					}; ?>><?php echo trim($row['Empresa']); ?></option><?
																																	}

																																	mysqli_free_result($result);
																																}
																																		?>
							</select>
							<label><i class="fa fa-sorttt"></i> <?php echo lang('Empresa'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-3 p-1">
					<div class="col">
						<div class="form-floating">
							<div class="input-daterange input-group" style='display:none' data-date-format="dd/mm/yyyy"></div>
							<input class="form-control" type="date" id="FechaHastafisico" name="FechaHastafisico">
							<label><i class="fa fa-calendar"></i> <?php echo lang('Hasta la Fecha'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-3 p-1">
					<div class="col">
						<div class="form-floating">
							<select class="form-select" id="OrdenXXX" name="OrdenXXX">
								<option value="Descripcion"><?php echo lang('Descripción'); ?></option>
								<option value="Referencia"><?php echo lang('Referencia'); ?></option>
								<option value="Instancia"><?php echo lang('Familia'); ?></option>
								<option value="Codigo"><?php echo lang('Código'); ?></option>
							</select>
							<label><i class="fa fa-sort"></i> <?php echo lang('Orden'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-3 p-1">
					<div class="col">
						<div class="form-floating">
							<select class="form-select" id="group" name="group">
								<option value="0"><?php echo lang('Ninguno'); ?></option>
								<option value="fami"><?php echo lang('Por Familia'); ?></option>
								<option value="marc"><?php echo lang('Por Marca'); ?></option>
							</select>
							<label><i class="fa fa-object-group"></i> <?php echo lang('Agrupamiento'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-3 p-1">
					<div class="col">
						<div class="form-floating">
							<select class="form-select" name="EnvioEstado" id="EnvioEstado">
								<option value="*"><?php echo lang("Todos"); ?></option>
								<option value="1"><?php echo lang("Activo"); ?></option>
								<option value="0"><?php echo lang("Inactivo"); ?></option>
							</select>
							<label><i class="fa fa-hourglass" aria-hidden="true"></i>&nbsp;<?php echo lang('Estado'); ?></label>
						</div>
					</div>
				</div>

				<div class="col-12 col-lg-4 p-1">
					<label for="mIdfamilia"><?php echo lang("Familia"); ?></label>
					<select id="mIdfamilia" name="mIdfamilia[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$query = "SELECT a.IdVarios,if(a.IdVariosPadre=0,a.ITEM,concat(b.ITEM,' > ', a.ITEM)) AS ITEM FROM PosUpvarios a left join PosUpvarios b on a.IdCompany=b.IdCompany and a.IdVariosPadre = b.IdVarios and a.TIPOITEM = b.TIPOITEM and b.TIPOITEM = 2 WHERE a.IdCompany=" . $_POST["Company"] . " and a.TIPOITEM = 2 order by if(a.IdVariosPadre=0,a.ITEM,concat(b.ITEM,' > ', a.ITEM)) asc";
						//echo $query;
						if ($result = mysqli_query($conn, $query)) {
							while ($row = mysqli_fetch_assoc($result)) {

						?>
								<option value="<?php echo trim($row['IdVarios']); ?>"><?php echo trim($row['ITEM']); ?></option>
						<?

							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<label for="mIdAlmacen"><?php echo lang('Almacén'); ?></label>
					<select id="mIdAlmacen" name="mIdAlmacen[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();

						if ($_POST["userperfil"] <= 2000 || $_POST["userperfil"] === "2055" || $_POST["userperfil"] === "2405") {

							if ($_POST['sucursal'] == '0') {
								$sql = "SELECT a.*,b.Nombre as UBicacion FROM PosUpAlmacen a inner join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi WHERE a.IdCompany = " . $_POST["Company"] . " ";
							} else {
								$sql = "SELECT a.*,b.Nombre as UBicacion FROM PosUpAlmacen a inner join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi WHERE a.IdCompany = " . $_POST["Company"] . " and b.IdUbi=" . $_POST['sucursal'];
							}
						} else {
							$sql = "SELECT a.* FROM PosUpAlmacen a  WHERE a.IdCompany = " . $_POST["Company"] . " and a.IdAlm=" . $_POST['IdAlmVta'];
						}

						if ($result = mysqli_query($conn, $sql)) {
							while ($row = mysqli_fetch_assoc($result)) {
						?>
								<option value="<?php echo trim($row['IdAlm']); ?>"><?php echo trim($row['Nombre']); ?></option>
						<?
							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<label for="mIdMarca"><?php echo lang('Marca'); ?></label>
					<select id="mIdMarca" name="mIdMarca[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$sql = "SELECT idmarca,nombre FROM PosUpc_marcas a where a.IdCompany = " . $_POST["Company"];
						if ($result = mysqli_query($conn, $sql)) {
							while ($row = mysqli_fetch_assoc($result)) {
						?>
								<option value="<?php echo trim($row['idmarca']); ?>"><?php echo trim($row['nombre']); ?></option>
						<?
							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>
				<div class="col-12 p-1">
					<label for="mIdProductos"><i class="fa fa-archive" aria-hidden="true"></i> <?php echo lang("Productos"); ?></label>
					<select id="mIdProductos" name="mIdProductos[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$query = "SELECT CodIdBasico,CodIdAmpliado,CodBarra,Descripcion FROM PosUpProducto a where a.EsCompuesto=0 and a.IdCompany = " . $_POST["Company"] . "";
						if ($result = mysqli_query($conn, $query)) {
							while ($row = mysqli_fetch_assoc($result)) {

						?>
								<option value="<?php echo trim($row['CodIdBasico']); ?>"><?php echo trim($row['Descripcion']); ?></option>
						<?

							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>
				<!-- <div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="col">
						<div class="form-floating">
							<input class="form-control filt" type="text" id="FamiliaXX" name="FamiliaXX" onchange="intanciaAXX();" />
							<label><i class="fa fa-th-large"></i> <?php echo lang('Familia'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="FamiliaXX2" name="FamiliaXX2" readonly />
							</div>
						</div>
						<button class="btn btn-outline-primary px-1" type="button" onclick="AXmodalX(1)"><i class="fa fa-search"></i></button>
					</div>
				</div> -->
				<!-- <div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="col">
						<div class="form-floating">
							<input class="form-control filt" type="text" id="DesdeAXX" name="DesdeAXX" onchange="CodigoDesAXX();" />
							<label><i class="fa fa-archive"></i> <?php echo lang('Desde Producto'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="DesdeAXX2" name="DesdeAXX2" readonly />
							</div>
						</div>
						<button class="btn btn-outline-primary px-1" type="button" onclick="AXmodalX(2)"><i class="fa fa-search"></i></button>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="col">
						<div class="form-floating">
							<input class="form-control filt" type="text" id="HastaAXX" name="HastaAXX" onchange="CodigoHasAXX();" />
							<label><i class="fa fa-archive"></i> <?php echo lang('Hasta Producto'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="HastaAXX2" name="HastaAXX2" readonly />
							</div>
						</div>
						<button class="btn btn-outline-primary px-1" type="button" onclick="AXmodalX(3)"><i class="fa fa-search"></i></button>
					</div>
				</div> -->
				<!-- <div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="col">
						<div class="form-floating">
							<input class="form-control filt" type="text" id="AlmacenAXX" name="AlmacenAXX" onchange="AlmaAXX();" />
							<label><i class="fa fa-archive"></i> <?php echo lang('Almacén'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="AlmacenAXX2" name="AlmacenAXX2" readonly />
							</div>
						</div>
						<button class="btn btn-outline-primary px-1" type="button" onclick="AXmodalX(4)"><i class="fa fa-search"></i></button>
					</div>
				</div> -->

				<!-- <div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="col">
						<div class="form-floating">
							<input class="form-control filt" type="text" id="marAX" name="marAX" onchange="MarcaAXX();" />
							<label><i class="fa fa-tags"></i> <?php echo lang('Marca'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="marAX2" name="marAX2" readonly />
							</div>
						</div>
						<button class="btn btn-outline-primary px-1" type="button" onclick="AXmodalX(5)"><i class="fa fa-search"></i></button>
					</div>
				</div> -->
			</div>

			<div class='row p-1'>
				<div class="col-12 col-md-4 col-lg-3">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="mexis" id="mexis">
						<label class="form-check-label" for="mexis">
							<?php echo lang('Mostrar Existencia'); ?>
						</label>
					</div>
				</div>
				<div class="col-12 col-md-4 col-lg-3">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="ExistenciaXXX" id="ExistenciaXXX">
						<label class="form-check-label" for="ExistenciaXXX">
							<?php echo lang('Incluir Existencia Cero'); ?>
						</label>
					</div>
				</div>
				<div class="col-12 col-md-4 col-lg-3">
					<div class="form-check">a
						<input class="form-check-input" type="checkbox" name="AlmacenXXX" id="AlmacenXXX">
						<label class="form-check-label" for="AlmacenXXX">
							<?php echo lang('Producto sin Almacén'); ?>
						</label>
					</div>
				</div>
				<div class="col-12 col-md-4 col-lg-3">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="SerialesXXX" id="SerialesXXX">
						<label class="form-check-label" for="SerialesXXX">
							<?php echo lang('Seriales'); ?>
						</label>
					</div>
				</div>
			</div>
		</div>

		<script>
			$(document).ready(function() {
				$("#mIdProductos").select2({
					dropdownParent: $("#apps-modalz"),
				});
				$("#mIdMarca").select2({
					dropdownParent: $("#apps-modalz"),
				});
				$("#mIdAlmacen").select2({
					dropdownParent: $("#apps-modalz"),
				});
				$("#mIdfamilia").select2({
					dropdownParent: $("#apps-modalz"),
				});
			});
		</script>
		<!-- Inventario Físico  -->
		<div class="modal-footer" style="width: 100%;">
    		<div class="row input-group w-100 m-0">
        		<div class="col-3 text-center p-1">
            		<button class="btn btn-outline-danger w-100" type="reset" id="limpiar">
                		<i class="fa fa-trash"></i> <?php echo lang('Limpiar'); ?>
           		 </button>
       		 </div>
       		 <div class="col-3 text-center p-1">
      		      <button class="btn btn-outline-primary w-100" type="button" onclick="var f = this.closest('form'); f.action='inventariofisico.php'; f.target='_blank'; f.submit();">
     		           <i class="fa fa-print"></i> <?php echo lang('Preliminar'); ?>
      		      </button>
      		  </div>
      		  <div class="col-3 text-center p-1">
     		       <button class="btn btn-danger w-100" type="button" onclick="var f = this.closest('form'); f.action='reporte_fisico_pdf.php'; f.target='_blank'; f.submit();">
      		          <i class="fa fa-file-pdf-o"></i> PDF
       		     </button>
       		 </div>
			 <div class="col text-center p-1">
    			<button class="btn btn-success w-100" type="button" onclick="var f = this.closest('form'); f.action='reporte_fisico_excel.php'; f.target='_self'; f.submit();">
        			<i class="fa fa-file-excel-o"></i> Excel
    			</button>
			</div>
      		  <div class="col-3 text-center p-1">
    		        <button class="btn btn-outline-secondary w-100" type="button" data-bs-dismiss="modal">
     		           <i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?>
     		       </button>
   		     </div>
  		  </div>
		</div>
	</form>

	<script>
		var fecha = new Date();
		var mes = fecha.getMonth() + 1;
		var dia = fecha.getDate();
		var ano = fecha.getFullYear();
		if (dia < 10) {
			dia = '0' + dia;
		}
		if (mes < 10) {
			mes = '0' + mes;
		}
		document.getElementById('FechaHastafisico').value = ano + "-" + mes + "-" + dia;
	</script>
<?php
}

if ($_POST["Accion"] === "6") {
?>
	<div class="modal-header">
		<h5 class="modal-title"><img src="/img/informez.png" alt="informe" height="24px" width="24px"> <?php echo lang('Análisis de Familia'); ?></h5>
		<button class="btn-close" type="button" data-bs-dismiss="modal"></button>
	</div>
	<form id="ListaPrecio" method="POST" target="_Blank" action="analisisdefamilia.php" onsubmit="return false">
		<div class="modal-body">
			<input type="hidden" name="fectx5" id="fectx5">

			<input type="hidden" name="CompanyActual" value="<?php echo $_POST['Company']; ?>" />
			<input type="hidden" name="IdCompanyGrp" value="<?php echo $_POST['IdCompanyGrp']; ?>" />
			<input type="hidden" name="CIdPlan" value="<?php echo $_POST['CIdPlan']; ?>" />
			<input type="hidden" name="SimMil" value="<?php echo $_POST['SimMil']; ?>" />
			<input type="hidden" name="SimDec" value="<?php echo $_POST['SimDec']; ?>" />
			<input type="hidden" name="CD" value="<?php echo $_POST['CD']; ?>" />
			<input type="hidden" name="direccion" value="<?php echo $_POST['direccion']; ?>" />
			<input type="hidden" name="NameCompany" value="<?php echo $_POST['NameCompany']; ?>" />
			<input type="hidden" name="sucursal" value="<?php echo $_POST['sucursal']; ?>" />
			<span style="display:none" id="devueltachavalesAX22"></span>
			<span style="display:none" id="CodigoDesaAX2z2"></span>
			<span style="display:none" id="CodigoHasaAX2z2"></span>
			<span style="display:none" id="BenefeAX2z2"></span>
			<span style="display:none" id="AlmaAX2z2"></span>

			<div class="row p-1">

				<div class="col-12 p-1 <?php echo $notemp; ?>">
					<div class="col">
						<div class="form-floating">
							<select id='IdCompanySelect' name='IdCompanySelect' onchange='selectidcomp(document.getElementById("IdCompanySelect").value);' class="form-select <?php echo $notemprise; ?>" aria-label="Default select example">
								<?php
								$conn = conectar();

								$query = "SELECT '" . $_POST["IdCompanyGrp"] . "' as ID, ' [" . lang('Todas') . "]' as Empresa  union  SELECT Id as ID, comercio as Empresa FROM PosUpCompany where Id in ( " . $_POST["IdCompanyGrp"] . ")  order by Empresa ";
								//echo $query;
								if ($result = mysqli_query($conn, $query)) {
									$n = 0;
									/* obtener array asociativo */
									while ($row = mysqli_fetch_assoc($result)) {
								?><option value="<?php echo trim($row['ID']); ?>" <?php if (trim($row['ID']) == trim($_POST['emprise'])) {
																						echo "selected";
																					}; ?>><?php echo trim($row['Empresa']); ?></option><?
																																	}

																																	mysqli_free_result($result);
																																}
																																		?>
							</select>
							<label><i class="fa fa-sorttt"></i> <?php echo lang('Empresa'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1">
					<div class="col">
						<div class="form-floating">
							<div class="input-daterange input-group" style='display:none' data-date-format="dd/mm/yyyy"></div>
							<input class="form-control" type="date" id="FECHAX2z2nj" name="FECHAX2z2nj">
							<label><i class="fa fa-calendar"></i> <?php echo lang('Desde la Fecha'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1">
					<div class="col">
						<div class="form-floating">
							<div class="input-daterange input-group" style='display:none' data-date-format="dd/mm/yyyy"></div>
							<input class="form-control" type="date" id="FECHAX22z2njz" name="FECHAX22z2njz">
							<label><i class="fa fa-calendar"></i> <?php echo lang('Hasta la Fecha'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1">
					<div class="col">
						<div class="form-floating">
							<select class="form-select" id="OrdenA222" name="OrdenA222">
								<option value="Ventas"><?php echo lang('Ventas'); ?></option>
								<option value="Cantidad"><?php echo lang('Cantidad'); ?></option>
								<option value="Utilidad"><?php echo lang('Utilidad'); ?></option>
							</select>
							<label><i class="fa fa-sort"></i> <?php echo lang('Orden'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1">
					<div class="col">
						<div class="form-floating">
							<input class="form-control filt" type="text" id="cant2232" name="cant2232" value="50" />
							<label><i class="fa fa-bookmark"></i> <?php echo lang('Cantidad'); ?></label>
						</div>
					</div>
				</div>

				<!-- <div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="col">
						<div class="form-floating">
							<input class="form-control filt" type="text" id="DesdeAX2z2Y" name="DesdeAX2z2Y" onchange="CodigoDesAX2pz2();" />
							<label><i class="fa fa-th-large"></i> <?php echo lang('Desde la Familia'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="DesdeAX22z22Y" name="DesdeAX22z22Y" readonly />
							</div>
						</div>
						<button class="btn btn-outline-primary px-1" type="button" onclick="AXmodal22(1)"><i class="fa fa-search"></i></button>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="col">
						<div class="form-floating">
							<input class="form-control filt" type="text" id="HastaAX2z2Y" name="HastaAX2z2Y" onchange="CodigoHasAX2pzz2();" />
							<label><i class="fa fa-th-large"></i> <?php echo lang('Hasta la Familia'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="HastaAX22z2Y" name="HastaAX22z2Y" readonly />
							</div>
						</div>
						<button class="btn btn-outline-primary px-1" type="button" onclick="AXmodal22(2)"><i class="fa fa-search"></i></button>
					</div>
				</div> -->

				<div class="col-12 col-lg-4 p-1">
					<label for="mIdfamilia"><?php echo lang("Familia"); ?></label>
					<select id="mIdfamilia" name="mIdfamilia[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$query = "SELECT a.IdVarios,if(a.IdVariosPadre=0,a.ITEM,concat(b.ITEM,' > ', a.ITEM)) AS ITEM FROM PosUpvarios a left join PosUpvarios b on a.IdCompany=b.IdCompany and a.IdVariosPadre = b.IdVarios and a.TIPOITEM = b.TIPOITEM and b.TIPOITEM = 2 WHERE a.IdCompany=" . $_POST["Company"] . " and a.TIPOITEM = 2 order by if(a.IdVariosPadre=0,a.ITEM,concat(b.ITEM,' > ', a.ITEM)) asc";
						//echo $query;
						if ($result = mysqli_query($conn, $query)) {
							while ($row = mysqli_fetch_assoc($result)) {

						?>
								<option value="<?php echo trim($row['IdVarios']); ?>"><?php echo trim($row['ITEM']); ?></option>
						<?

							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>
				<!-- <div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="col">
						<div class="form-floating">
							<input class="form-control filt" type="text" id="BeneficiarioAX2z2" name="BeneficiarioAX2z2" onchange="BenefeAX22();" />
							<label><i class="fa fa-user"></i> <?php echo lang('Beneficiario'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="BeneficiarioAX22z2" name="BeneficiarioSE22z2" readonly />
							</div>
						</div>
						<button class="btn btn-outline-primary px-1" type="button" onclick="AXmodal22(3)"><i class="fa fa-search"></i></button>
					</div>
				</div> -->

				<div class="col-12 col-lg-4 p-1">
					<label for="mIdProevedor"><?php echo lang("Beneficiarios"); ?></label>
					<select id="mIdProevedor" name="mIdProevedor[]" multiple="multiple" style="width: 100%">
					</select>
				</div>
				<!-- <div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="col">
						<div class="form-floating">
							<input class="form-control filt" type="text" id="AlmacenAX2z2" name="AlmacenAX2z2" onchange="AlmaAX22();" />
							<label><i class="fa fa-archive"></i> <?php echo lang('Almacén'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="AlmacenAX22z2" name="AlmacenAX22z2" readonly />
							</div>
						</div>
						<button class="btn btn-outline-primary px-1" type="button" onclick="AXmodal22(4)"><i class="fa fa-search"></i></button>
					</div>
				</div> -->

				<div class="col-12 col-lg-4 p-1">
					<label for="mIdAlmacen"><?php echo lang('Almacén'); ?></label>
					<select id="mIdAlmacen" name="mIdAlmacen[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						if ($_POST['sucursal'] == '0') {
							$sql = "SELECT a.*,b.Nombre as UBicacion FROM PosUpAlmacen a inner join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi WHERE a.IdCompany = " . $_POST["Company"] . " ";
						} else {
							$sql = "SELECT a.*,b.Nombre as UBicacion FROM PosUpAlmacen a inner join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi WHERE a.IdCompany = " . $_POST["Company"] . " and b.IdUbi=" . $_POST['sucursal'];
						}
						if ($result = mysqli_query($conn, $sql)) {
							while ($row = mysqli_fetch_assoc($result)) {
						?>
								<option value="<?php echo trim($row['IdAlm']); ?>"><?php echo trim($row['Nombre']); ?></option>
						<?
							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>

				<script>
					$(document).ready(function() {
						$("#mIdProevedor").select2({
							ajax: {
								delay: 1000,
								type: "POST",
								dataType: 'json',
								url: 'informezseek.php',
								data: function(params) {
									var queryParameters = {
										search: params.term,
										Accion: "ProveedorBA",
										CompanyActual: document.getElementById("CompanyActual").innerHTML
									}

									return queryParameters;
								},
								processResults: function(data) {
									return {
										results: data.results
									};
								}
							},
							dropdownParent: $("#apps-modalz"),
						});
						$("#mIdAlmacen").select2({
							dropdownParent: $("#apps-modalz"),
						});
						$("#mIdfamilia").select2({
							dropdownParent: $("#apps-modalz"),
						});
					});
				</script>
			</div>
		</div>
		<!-- Análisis de Familia -->
		<div class="modal-footer" style="width: 100%;">
    	<div class="row input-group w-100 m-0">
      	  <div class="col-3 text-center p-1">
      	      <button class="btn btn-outline-danger w-100" type="reset" id="limpiar">
      	          <i class="fa fa-trash"></i> <?php echo lang('Limpiar'); ?>
      	      </button>
       	 </div>
       	 <div class="col-3 text-center p-1">
      	      <button class="btn btn-outline-primary w-100" type="button" onclick="var f = this.closest('form'); f.action='analisisdefamilia.php'; f.target='_blank'; f.submit();">
      	          <i class="fa fa-print"></i> <?php echo lang('Preliminar'); ?>
      	      </button>
      	  </div>
      	  <div class="col-3 text-center p-1">
     	       <button class="btn btn-danger w-100" type="button" onclick="var f = this.closest('form'); f.action='reporte_analisisfamilia_pdf.php'; f.target='_blank'; f.submit();">
     	           <i class="fa fa-file-pdf-o"></i> PDF
      	      </button>
     	   </div>
      	  <div class="col-3 text-center p-1">
            	<button class="btn btn-outline-secondary w-100" type="button" data-bs-dismiss="modal">
                	<i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?>
            	</button>
        	</div>
    	</div>
	</div>
	</form>
	<script>
		var fecha = new Date();
		var mes = fecha.getMonth() + 1;
		var dia = fecha.getDate();
		var ano = fecha.getFullYear();
		if (dia < 10) {
			dia = '0' + dia;
		}
		if (mes < 10) {
			mes = '0' + mes;
		}
		document.getElementById('FECHAX2z2nj').value = ano + "-" + mes + "-" + dia;
		document.getElementById('FECHAX22z2njz').value = ano + "-" + mes + "-" + dia;
	</script>
<?php
}

if ($_POST["Accion"] === "7") {
?>
	<div class="modal-header">
		<h5 class="modal-title"><img src="/img/informez.png" alt="informe" height="24px" width="24px"> <?php echo lang('Análisis de Marca'); ?></h5>
		<button class="btn-close" type="button" data-bs-dismiss="modal"></button>
	</div>
	<form id="ListaPrecio" method="POST" target="_Blank" action="analisismarca.php" onsubmit="return false">
		<div class="modal-body">
			<input type="hidden" name="fectx5" id="fectx5" />

			<input type="hidden" name="CompanyActual" value="<?php echo $_POST['Company']; ?>" />
			<input type="hidden" name="IdCompanyGrp" value="<?php echo $_POST['IdCompanyGrp']; ?>" />
			<input type="hidden" name="CIdPlan" value="<?php echo $_POST['CIdPlan']; ?>" />
			<input type="hidden" name="SimMil" value="<?php echo $_POST['SimMil']; ?>" />
			<input type="hidden" name="SimDec" value="<?php echo $_POST['SimDec']; ?>" />
			<input type="hidden" name="CD" value="<?php echo $_POST['CD']; ?>" />
			<input type="hidden" name="direccion" value="<?php echo $_POST['direccion']; ?>" />
			<input type="hidden" name="NameCompany" value="<?php echo $_POST['NameCompany']; ?>" />
			<input type="hidden" name="sucursal" value="<?php echo $_POST['sucursal']; ?>" />
			<span style="display:none" id="devueltachavalesAX2"></span>
			<span style="display:none" id="CodigoDesaAX2z"></span>
			<span style="display:none" id="CodigoHasaAX2z"></span>
			<span style="display:none" id="BenefeAX2z"></span>
			<span style="display:none" id="AlmaAX2z"></span>

			<div class="row p-1">
				<div class="col-12  p-1 <?php echo $notemp; ?>">
					<div class="col">
						<div class="form-floating">
							<select id='IdCompanySelect' name='IdCompanySelect' onchange='selectidcomp(document.getElementById("IdCompanySelect").value);' class="form-select <?php echo $notemprise; ?>" aria-label="Default select example">
								<?php
								$conn = conectar();

								$query = "SELECT '" . $_POST["IdCompanyGrp"] . "' as ID, ' [" . lang('Todas') . "]' as Empresa  union  SELECT Id as ID, comercio as Empresa FROM PosUpCompany where Id in ( " . $_POST["IdCompanyGrp"] . ")  order by Empresa ";
								//echo $query;
								if ($result = mysqli_query($conn, $query)) {
									$n = 0;
									/* obtener array asociativo */
									while ($row = mysqli_fetch_assoc($result)) {
								?><option value="<?php echo trim($row['ID']); ?>" <?php if (trim($row['ID']) == trim($_POST['emprise'])) {
																						echo "selected";
																					}; ?>><?php echo trim($row['Empresa']); ?></option><?
																																	}

																																	mysqli_free_result($result);
																																}
																																		?>
							</select>
							<label><i class="fa fa-sorttt"></i> <?php echo lang('Empresa'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1">
					<div class="col">
						<div class="form-floating">
							<div class="input-daterange input-group" style='display:none' data-date-format="dd/mm/yyyy"></div>
							<input class="form-control  " type="date" id="FECHAX2z" name="FECHAX2z" />
							<label><i class="fa fa-calendar"></i> <?php echo lang('Desde la Fecha'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1">
					<div class="col">
						<div class="form-floating">
							<div class="input-daterange input-group" style='display:none' data-date-format="dd/mm/yyyy"></div>
							<input class="form-control  " type="date" id="FECHAX22z" name="FECHAX22z" />
							<label><i class="fa fa-calendar"></i> <?php echo lang('Hasta la Fecha'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1">
					<div class="col">
						<div class="form-floating">
							<select class="form-select" id="OrdenA22" name="OrdenA22">
								<option value="Ventas"><?php echo lang('Ventas'); ?></option>
								<option value="Cantidad"><?php echo lang('Cantidad'); ?></option>
								<option value="Utilidad"><?php echo lang('Utilidad'); ?></option>
							</select>
							<label><i class="fa fa-sort"></i> <?php echo lang('Orden'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1">
					<div class="col">
						<div class="form-floating">
							<input class="form-control filt" type="text" id="cant223" name="cant223" value="50" />
							<label><i class="fa fa-bookmark"></i> <?php echo lang('Cantidad'); ?></label>
						</div>
					</div>
				</div>

				<div class="col-12 col-lg-4 p-1">
					<label for="mIdMarca"><?php echo lang('Marca'); ?></label>
					<select id="mIdMarca" name="mIdMarca[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$sql = "SELECT idmarca,nombre FROM PosUpc_marcas a where a.IdCompany = " . $_POST["Company"];
						if ($result = mysqli_query($conn, $sql)) {
							while ($row = mysqli_fetch_assoc($result)) {
						?>
								<option value="<?php echo trim($row['idmarca']); ?>"><?php echo trim($row['nombre']); ?></option>
						<?
							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>

				<div class="col-12 col-lg-4 p-1">
					<label for="mIdProevedor"><?php echo lang("Beneficiarios"); ?></label>
					<select id="mIdProevedor" name="mIdProevedor[]" multiple="multiple" style="width: 100%">
					</select>
				</div>


				<div class="col-12 col-lg-4 p-1">
					<label for="mIdAlmacen"><?php echo lang('Almacén'); ?></label>
					<select id="mIdAlmacen" name="mIdAlmacen[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						if ($_POST['sucursal'] == '0') {
							$sql = "SELECT a.*,b.Nombre as UBicacion FROM PosUpAlmacen a inner join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi WHERE a.IdCompany = " . $_POST["Company"] . " ";
						} else {
							$sql = "SELECT a.*,b.Nombre as UBicacion FROM PosUpAlmacen a inner join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi WHERE a.IdCompany = " . $_POST["Company"] . " and b.IdUbi=" . $_POST['sucursal'];
						}
						if ($result = mysqli_query($conn, $sql)) {
							while ($row = mysqli_fetch_assoc($result)) {
						?>
								<option value="<?php echo trim($row['IdAlm']); ?>"><?php echo trim($row['Nombre']); ?></option>
						<?
							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>
			</div>

			<script>
				$(document).ready(function() {
					$("#mIdProevedor").select2({
						ajax: {
							delay: 1000,
							type: "POST",
							dataType: 'json',
							url: 'informezseek.php',
							data: function(params) {
								var queryParameters = {
									search: params.term,
									Accion: "ProveedorBA",
									CompanyActual: document.getElementById("CompanyActual").innerHTML
								}

								return queryParameters;
							},
							processResults: function(data) {
								return {
									results: data.results
								};
							}
						},
						dropdownParent: $("#apps-modalz"),
					});
					$("#mIdAlmacen").select2({
						dropdownParent: $("#apps-modalz"),
					});
					$("#mIdMarca").select2({
						dropdownParent: $("#apps-modalz"),
					});
				});
			</script>

			<!-- <div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="col">
						<div class="form-floating">
							<input class="form-control filt" type="text" id="BeneficiarioAX2z" name="BeneficiarioAX2z" onchange="BenefeAX2();" />
							<label><i class="fa fa-user"></i> <?php echo lang('Beneficiario'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="BeneficiarioAX22z" name="BeneficiarioSE22z" readonly />
							</div>
						</div>
						<button class="btn btn-outline-primary px-1" type="button" onclick="AXmodal2(3)"><i class="fa fa-search"></i></button>
					</div>
				</div> -->

			<!-- <div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="col">
						<div class="form-floating">
							<input class="form-control filt" type="text" id="DesdeAX2z" name="DesdeAX2z" onchange="CodigoDesAX2pz();" />
							<label><i class="fa fa-tags"></i> <?php echo lang('Desde la Marca'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="DesdeAX22z" name="DesdeAX22z" readonly />
							</div>
						</div>
						<button class="btn btn-outline-primary px-1" type="button" onclick="AXmodal2(1)"><i class="fa fa-search"></i></button>
					</div>
				</div>

				<div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="col">
						<div class="form-floating">
							<input class="form-control filt" type="text" id="HastaAX2z" name="HastaAX2z" onchange="CodigoHasAX2pzz();" />
							<label><i class="fa fa-tags"></i> <?php echo lang('Hasta la Marca'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="HastaAX22z" name="HastaAX22z" readonly />
							</div>
						</div>
						<button class="btn btn-outline-primary px-1" type="button" onclick="AXmodal2(2)"><i class="fa fa-search"></i></button>
					</div>
				</div> -->
			<!-- <div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="col">
						<div class="form-floating">
							<input class="form-control filt" type="text" id="AlmacenAX2z" name="AlmacenAX2z" onchange="AlmaAX2();" />
							<label><i class="fa fa-archive"></i> <?php echo lang('Almacén'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="AlmacenAX22z" name="AlmacenAX22z" readonly />
							</div>
						</div>
						<button class="btn btn-outline-primary px-1" type="button" onclick="AXmodal2(4)"><i class="fa fa-search"></i></button>
					</div>
				</div> -->
		</div>
<!-- Análisis de Marca -->
		<div class="modal-footer" style="width: 100%;">
 		   <div class="row input-group w-100 m-0">
 		       <div class="col-3 text-center p-1">
  		          <button class="btn btn-outline-danger w-100" type="reset" id="limpiar">
   		             <i class="fa fa-trash"></i> <?php echo lang('Limpiar'); ?>
     		       </button>
    		    </div>
   		     <div class="col-3 text-center p-1">
    		        <button class="btn btn-outline-primary w-100" type="button" onclick="var f = this.closest('form'); f.action='analisismarca.php'; f.target='_blank'; f.submit();">
    		            <i class="fa fa-print"></i> <?php echo lang('Preliminar'); ?>
    		        </button>
    		    </div>
   		     <div class="col-3 text-center p-1">
    		        <button class="btn btn-danger w-100" type="button" onclick="var f = this.closest('form'); f.action='reporte_analisis_marca_pdf.php'; f.target='_blank'; f.submit();">
   		             <i class="fa fa-file-pdf-o"></i> PDF
   		         </button>
   		     </div>
   		     <div class="col-3 text-center p-1">
   		         <button class="btn btn-outline-secondary w-100" type="button" data-bs-dismiss="modal">
   		             <i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?>
   		         </button>
   		     </div>
  		  </div>
		</div>
	</form>
	<script>
		var fecha = new Date();
		var mes = fecha.getMonth() + 1;
		var dia = fecha.getDate();
		var ano = fecha.getFullYear();
		if (dia < 10) {
			dia = '0' + dia;
		}
		if (mes < 10) {
			mes = '0' + mes
		}
		document.getElementById('FECHAX2z').value = ano + "-" + mes + "-" + dia;
		document.getElementById('FECHAX22z').value = ano + "-" + mes + "-" + dia;
	</script>
<?php
}


if ($_POST["Accion"] === "8") {
?>
	<div class="modal-header">
		<h5 class="modal-title"><img src="/img/informez.png" alt="informe" height="24px" width="24px"> <?php echo lang('Operaciones de Inventario'); ?></h5>
		<button class="btn-close" type="button" data-bs-dismiss="modal"></button>
	</div>
	<form id="ListaPrecio" method="POST" target="_Blank" action="operainve.php" onsubmit="return false">
		<div class="modal-body">

			<input type="hidden" name="CompanyActual" value="<?php echo $_POST['Company']; ?>" />
			<input type="hidden" name="IdCompanyGrp" value="<?php echo $_POST['IdCompanyGrp']; ?>" />
			<input type="hidden" name="CIdPlan" value="<?php echo $_POST['CIdPlan']; ?>" />
			<input type="hidden" name="SimMil" value="<?php echo $_POST['SimMil']; ?>" />
			<input type="hidden" name="SimDec" value="<?php echo $_POST['SimDec']; ?>" />
			<input type="hidden" name="CD" value="<?php echo $_POST['CD']; ?>" />
			<input type="hidden" name="direccion" value="<?php echo $_POST['direccion']; ?>" />
			<input type="hidden" name="NameCompany" value="<?php echo $_POST['NameCompany']; ?>" />
			<input type="hidden" name="sucursal" value="<?php echo $_POST['sucursal']; ?>" />
			<input type="hidden" name="fectx5" id="fectx5" />
			<span style="display:none" id="devueltachavalesSE2"></span>
			<span style="display:none" id="CodigoDesaSE2"></span>
			<span style="display:none" id="CodigoHasaSE2"></span>
			<span style="display:none" id="BenefeSE2"></span>
			<span style="display:none" id="AlmaSE2"></span>
			<div class="row p-1">

				<div class="col-12 p-1  <?php echo $notemp; ?>">
					<div class="col">
						<div class="form-floating">
							<select id='IdCompanySelect' name='IdCompanySelect' onchange='selectidcomp(document.getElementById("IdCompanySelect").value); changeinput("0","ModalUsuarioCC","");changeinput("1","","Almacen234[]");' class="form-select <?php echo $notemprise; ?>" aria-label="Default select example">
								<?php
								$conn = conectar();

								$query = "SELECT '" . $_POST["IdCompanyGrp"] . "' as ID, ' [" . lang('Todas') . "]' as Empresa  union  SELECT Id as ID, comercio as Empresa FROM PosUpCompany where Id in ( " . $_POST["IdCompanyGrp"] . ")  order by Empresa ";
								//echo $query;
								if ($result = mysqli_query($conn, $query)) {
									$n = 0;
									/* obtener array asociativo */
									while ($row = mysqli_fetch_assoc($result)) {
								?><option value="<?php echo trim($row['ID']); ?>" <?php if (trim($row['ID']) == trim($_POST['emprise'])) {
																						echo "selected";
																					}; ?>><?php echo trim($row['Empresa']); ?></option><?
																																	}

																																	mysqli_free_result($result);
																																}
																																		?>
							</select>
							<label><i class="fa fa-sorttt"></i> <?php echo lang('Empresa'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<div class="col">
						<div class="form-floating">
							<div class="input-daterange input-group" style='display:none' data-date-format="dd/mm/yyyy"></div>
							<input class="form-control  " type="date" id="FECH4" name="FECH4" />
							<label><i class="fa fa-calendar"></i> <?php echo lang('Desde la Fecha'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<div class="col">
						<div class="form-floating">
							<div class="input-daterange input-group" style='display:none' data-date-format="dd/mm/yyyy"></div>
							<input class="form-control  " type="date" id="FECH24" name="FECH24" />
							<label><i class="fa fa-calendar"></i> <?php echo lang('Hasta la Fecha'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-4 p-1 <?php echo $notfil; ?> nfilt">
					<div class="col">
						<div class="form-floating">
							<select class="form-select" id="OrdenSE4" name="OrdenSE4">
								<option value="1"><?php echo lang('Código'); ?></option>
								<option value="2"><?php echo lang('Descripción'); ?></option>
								<option value="3"><?php echo lang('Fecha'); ?></option>
							</select>
							<label><i class="fa fa-sort"></i> <?php echo lang('Orden'); ?></label>
						</div>
					</div>
				</div>
				<!-- <div class="col-12 col-lg-6 p-1">
						<label for="ModalUsuarioCC"><i class="fa fa-user"></i> <?php echo lang('Usuario'); ?></label>
						<select id="ModalUsuarioCC" name="ModalUsuarioCC[]" multiple="multiple" style="width: 100%">
							<?php
							$conn = conectar();
							$query = "SELECT Login,Nombre FROM PosUpUsers WHERE IdCompany=" . $_POST['Company'] . "";

							if ($result = mysqli_query($conn, $query)) {
								while ($row = mysqli_fetch_assoc($result)) {
							?>
									<option value="<?php echo trim($row['Login']); ?>"><?php echo trim($row['Nombre']); ?></option>
							<?
								}
								mysqli_free_result($result);
							}
							?>
						</select>
					</div> -->
				<!-- <div class="col-12 col-lg-6 p-1">
						<label for="mIdVendedor">Vendedor</label>
						<select id="mIdVendedor" name="mIdVendedor[]" multiple="multiple" style="width: 100%">
							<?php
							$conn = conectar();
							$query = "SELECT b.Login, b.Nombre FROM PosUpTxC a inner join PosUpUsers b on b.login = a.IdUser and a.IdcompanyUser=b.IdCompany where a.IdCompany = " . $_POST["Company"] . " and a.IdUser <> '' GROUP by a.IdUser ";

							if ($result = mysqli_query($conn, $query)) {
								while ($row = mysqli_fetch_assoc($result)) {
							?>
									<option value="<?php echo trim($row['Login']); ?>"><?php echo trim($row['Nombre']); ?></option>
							<?
								}
								mysqli_free_result($result);
							}
							?>
						</select>
					</div> -->
				<div class="col-12 col-lg-4 p-1">
					<label for="Filtrar4"><?php echo lang('Tipo de Operación'); ?></label>

					<select id="Filtrar4" name="Filtrar4[]" style="width: 100%;" multiple>
						<?php
						$conn = conectar();
						$query = "SELECT Idtipotx,Titulo from PosUpTx where Inventario<>0 and Idtipotx<>3 and Idtipotx<>27";
						if ($result = mysqli_query($conn, $query)) {
							while ($row = mysqli_fetch_assoc($result)) {
						?><option value="<?php echo $row["Idtipotx"]; ?> "><?php echo lang($row["Titulo"]) ?></option> <?php
																													}
																													mysqli_free_result($result);
																												}
																														?>
					</select>
				</div>

				<div class="col-12 col-lg-4 p-1">
					<label for="mIdAlmacen"><?php echo lang('Almacén'); ?></label>
					<select id="mIdAlmacen" name="mIdAlmacen[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						if ($_POST['sucursal'] == '0') {
							$sql = "SELECT a.*,b.Nombre as UBicacion FROM PosUpAlmacen a inner join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi WHERE a.IdCompany = " . $_POST["Company"] . " ";
						} else {
							$sql = "SELECT a.*,b.Nombre as UBicacion FROM PosUpAlmacen a inner join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi WHERE a.IdCompany = " . $_POST["Company"] . " and b.IdUbi=" . $_POST['sucursal'];
						}
						if ($result = mysqli_query($conn, $sql)) {
							while ($row = mysqli_fetch_assoc($result)) {
						?>
								<option value="<?php echo trim($row['IdAlm']); ?>"><?php echo trim($row['Nombre']); ?></option>
						<?
							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>


				<div class="col-12 col-lg-4 p-1">
					<label for="mIdProductos"><i class="fa fa-archive" aria-hidden="true"></i> <?php echo lang("Productos"); ?></label>
					<select id="mIdProductos" name="mIdProductos[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$query = "SELECT CodIdBasico,CodIdAmpliado,CodBarra,Descripcion FROM PosUpProducto a where a.EsCompuesto=0 and a.IdCompany = " . $_POST["Company"] . "";
						if ($result = mysqli_query($conn, $query)) {
							while ($row = mysqli_fetch_assoc($result)) {

						?>
								<option value="<?php echo trim($row['CodIdBasico']); ?>"><?php echo trim($row['Descripcion']); ?></option>
						<?

							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>

				<div class="col-12 p-1">
					<label for="mIdProevedor"><?php echo lang("Beneficiarios"); ?></label>
					<select id="mIdProevedor" name="mIdProevedor[]" multiple="multiple" style="width: 100%">
					</select>
				</div>
				<!-- <div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="Cliente22" name="Cliente22" onchange="vendedor();" />
								<label><i class="fa fa-group"></i> <?php echo lang('Vendedor'); ?></label>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
						<div class="input-group">
							<div class="col">
								<div class="form-floating">
									<input class="form-control filt" type="text" id="Cliente32" name="Cliente32" readonly />
								</div>
							</div>
							<button class="btn btn-outline-primary px-1" type="button" onclick="Seriales2(3)"><i class="fa fa-search"></i></button>
						</div>
					</div> -->
			</div>

			<script>
				$(document).ready(function() {
					$("#mIdProevedor").select2({
						ajax: {
							delay: 1000,
							type: "POST",
							dataType: 'json',
							url: 'informezseek.php',
							data: function(params) {
								var queryParameters = {
									search: params.term,
									Accion: "ProveedorBA",
									CompanyActual: document.getElementById("CompanyActual").innerHTML
								}

								return queryParameters;
							},
							processResults: function(data) {
								return {
									results: data.results
								};
							}
						},
						dropdownParent: $("#apps-modalz"),
					});
					$("#mIdAlmacen").select2({
						dropdownParent: $("#apps-modalz"),
					});
					$("#Filtrar4").select2({
						dropdownParent: $("#apps-modalz"),
					});
					$("#mIdVendedor").select2({
						dropdownParent: $("#apps-modalz"),
					});
					$("#mIdProductos").select2({
						dropdownParent: $("#apps-modalz"),
					});
					$("#ModalUsuarioCC").select2({
						dropdownParent: $("#apps-modalz"),
					});
				});
			</script>
			<div class='row p-1'>
				<?php if ($_POST['userperfil'] <= 2000 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="Costoop" id="Costoop">
							<label class="form-check-label" for="Costoop">
								<?php echo lang('Costo'); ?>
							</label>
						</div>
					</div>
				<?php } ?>

				<div class="col-6 col-md-4">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="Precioop" id="Precioop">
						<label class="form-check-label" for="Precioop">
							<?php echo lang('Precio'); ?>
						</label>
					</div>
				</div>

				<div class="col-6 col-md-4">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="SerialesOPe" id="SerialesOPe">
						<label class="form-check-label" for="SerialesOPe">
							<?php echo lang('Seriales'); ?>
						</label>
					</div>
				</div>

				<div class="col-6 col-md-4">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="icd" id="icd" checked>
						<label class="form-check-label" for="icd">
							<?php echo lang('Incluir Devoluciones'); ?>
						</label>
					</div>
				</div>
			</div>

			<!-- <div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="BeneficiarioSE22" name="BeneficiarioSE22" onchange="BenefeSE2();" />
								<label><i class="fa fa-user"></i> <?php echo lang('Beneficiario'); ?></label>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
						<div class="input-group">
							<div class="col">
								<div class="form-floating">
									<input class="form-control filt" type="text" id="BeneficiarioSE222" name="BeneficiarioSE222" readonly />
								</div>
							</div>
							<button class="btn btn-outline-primary px-1" type="button" onclick="Seriales2(2)"><i class="fa fa-search"></i></button>
						</div>
					</div> -->
			<!-- <div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
						<div class="col">
							<div class="form-floating" id="almaceninput">
								<select class="form-select" id="Almacen234[]" name="Almacen234[]" style="height:100px" multiple>
									<?php
									if ($_POST['sucursal'] == 0) {
										$query3224 = "Select a.IdAlm,a.Nombre from PosUpAlmacen a left join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi where a.IdCompany=" . $_POST['Company'];
										if ($result3224 = mysqli_query($conn, $query3224)) {
											while ($row3224 = mysqli_fetch_assoc($result3224)) {
									?><option value="<?php echo $row3224["IdAlm"]; ?> "><?php echo $row3224["Nombre"] ?></option> <?php
																																}
																																mysqli_free_result($result3224);
																															}
																														} else {
																															$query3224 = "Select a.IdAlm,a.Nombre from PosUpAlmacen a left join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi where a.IdUbi=" . $_POST['sucursal'] . " and a.IdCompany=" . $_POST['Company'];
																															if ($result3224 = mysqli_query($conn, $query3224)) {
																																while ($row3224 = mysqli_fetch_assoc($result3224)) {
																																	?><option value="<?php echo $row3224["IdAlm"]; ?> "><?php echo $row3224["Nombre"] ?></option> <?php
																																																								}
																																																								mysqli_free_result($result3224);
																																																							}
																																																						}
																																																									?>
								</select>
								<label><i class="fa fa-archive"></i> <?php echo lang('Almacén'); ?></label>
							</div>
						</div>
					</div> -->
			<!-- <div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="Producto22" name="Producto22" onchange="Producto2();" />
								<label><i class="fa fa-archive"></i> <?php echo lang('Producto'); ?></label>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
						<div class="input-group">
							<div class="col">
								<div class="form-floating">
									<input class="form-control filt" type="text" id="Producto32" name="Producto32" readonly />
								</div>
							</div>
							<button class="btn btn-outline-primary px-1" type="button" onclick="Seriales2(1)"><i class="fa fa-search"></i></button>
						</div>
					</div> -->
		</div>
<!-- Operaciones de inventario -->
		<div class="modal-footer" style="width: 100%;">
   		 <div class="row input-group w-100 m-0">
     		   <div class="col-3 text-center p-1">
     		       <button class="btn btn-outline-danger w-100" type="reset" id="limpiar">
     		           <i class="fa fa-trash"></i> <?php echo lang('Limpiar'); ?>
    		        </button>
     		   </div>
     		   <div class="col-3 text-center p-1">
     		       <button class="btn btn-outline-primary w-100" type="button" onclick="var f = this.closest('form'); f.action='operainve.php'; f.target='_blank'; f.submit();">
     		           <i class="fa fa-print"></i> <?php echo lang('Preliminar'); ?>
    		        </button>
     		   </div>
    		    <div class="col-3 text-center p-1">
     		       <button class="btn btn-danger w-100" type="button" onclick="var f = this.closest('form'); f.action='reporte_operaciones_pdf.php'; f.target='_blank'; f.submit();">
    		            <i class="fa fa-file-pdf-o"></i> PDF
     		       </button>
     		   </div>
     		   <div class="col-3 text-center p-1">
        		    <button class="btn btn-outline-secondary w-100" type="button" data-bs-dismiss="modal">
        		        <i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?>
        		    </button>
       		 </div>
    		</div>
		</div>
	</form>
	<script>
		var fecha = new Date();
		var mes = fecha.getMonth() + 1;
		var dia = fecha.getDate();
		var ano = fecha.getFullYear();
		if (dia < 10) {
			dia = '0' + dia;
		}
		if (mes < 10) {
			mes = '0' + mes;
		}
		document.getElementById('FECH4').value = ano + "-" + mes + "-" + dia;
		document.getElementById('FECH24').value = ano + "-" + mes + "-" + dia;
	</script>
<?php
}

if ($_POST["Accion"] === "9") {
?>
	<div class="modal-header">
		<h5 class="modal-title"><img src="/img/informez.png" alt="informe" height="24px" width="24px"> <?php echo lang('Histórico de Seriales'); ?></h5>
		<button class="btn-close" type="button" data-bs-dismiss="modal"></button>
	</div>
	<form id="ListaPrecio" method="POST" target="_Blank" action="historialseriales.php" onsubmit="return false">
		<div class="modal-body">

			<input type="hidden" name="CompanyActual" value="<?php echo $_POST['Company']; ?>" />
			<input type="hidden" name="IdCompanyGrp" value="<?php echo $_POST['IdCompanyGrp']; ?>" />
			<input type="hidden" name="CIdPlan" value="<?php echo $_POST['CIdPlan']; ?>" />
			<input type="hidden" name="SimMil" value="<?php echo $_POST['SimMil']; ?>" />
			<input type="hidden" name="SimDec" value="<?php echo $_POST['SimDec']; ?>" />
			<input type="hidden" name="CD" value="<?php echo $_POST['CD']; ?>" />
			<input type="hidden" name="direccion" value="<?php echo $_POST['direccion']; ?>" />
			<input type="hidden" name="NameCompany" value="<?php echo $_POST['NameCompany']; ?>" />
			<input type="hidden" name="sucursal" value="<?php echo $_POST['sucursal']; ?>" />
			<input type="hidden" name="fectx5" id="fectx5" />
			<span style="display:none" id="devueltachavalesSE"></span>
			<span style="display:none" id="CodigoDesaSE"></span>
			<span style="display:none" id="CodigoHasaSE"></span>
			<span style="display:none" id="BenefeSE"></span>
			<span style="display:none" id="AlmaSE"></span>

			<div class="row p-1">

				<div class="col-12 p-1 <?php echo $notemp; ?>">
					<div class="col">
						<div class="form-floating">
							<select id='IdCompanySelect' name='IdCompanySelect' onchange='selectidcomp(document.getElementById("IdCompanySelect").value); changeinput("1","","Almacen23[]");' class="form-select <?php echo $notemprise; ?>" aria-label="Default select example">
								<?php
								$conn = conectar();

								$query = "SELECT '" . $_POST["IdCompanyGrp"] . "' as ID, ' [" . lang('Todas') . "]' as Empresa  union  SELECT Id as ID, comercio as Empresa FROM PosUpCompany where Id in ( " . $_POST["IdCompanyGrp"] . ")  order by Empresa ";
								//echo $query;
								if ($result = mysqli_query($conn, $query)) {
									$n = 0;
									/* obtener array asociativo */
									while ($row = mysqli_fetch_assoc($result)) {
								?><option value="<?php echo trim($row['ID']); ?>" <?php if (trim($row['ID']) == trim($_POST['emprise'])) {
																						echo "selected";
																					}; ?>><?php echo trim($row['Empresa']); ?></option><?
																																	}

																																	mysqli_free_result($result);
																																}
																																		?>
							</select>
							<label><i class="fa fa-sorttt"></i> <?php echo lang('Empresa'); ?></label>
						</div>
					</div>
				</div>

				<div class="col-12 col-lg-4 p-1">
					<div class="col">
						<div class="form-floating">
							<div class="input-daterange input-group" style='display:none' data-date-format="dd/mm/yyyy"></div>
							<input class="form-control" type="date" id="FECH" name="FECH">
							<label><i class="fa fa-calendar"></i> <?php echo lang('Desde la Fecha'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<div class="col">
						<div class="form-floating">
							<div class="input-daterange input-group" style='display:none' data-date-format="dd/mm/yyyy"></div>
							<input class="form-control" type="date" id="FECH2" name="FECH2" />
							<label><i class="fa fa-calendar"></i> <?php echo lang('Hasta la Fecha'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<div class="col">
						<div class="form-floating">
							<select class="form-select" id="OrdenSE" name="OrdenSE">
								<option value="1"><?php echo lang('Código'); ?></option>
								<option value="2"><?php echo lang('Descripción'); ?></option>
								<option value="3"><?php echo lang('Seriales'); ?></option>
								<option value="4"><?php echo lang('Fecha'); ?></option>
							</select>
							<label><i class="fa fa-sort"></i> <?php echo lang('Orden'); ?></label>
						</div>
					</div>
				</div>
				<!-- <div class="col-12 col-lg-6 p-1 ">
					<div class="col">
						<div class="form-floating">
							<select class="form-select" id="Filtrar[]" name="Filtrar[]" style="height:100px" multiple>
								<?php
								$query32 = "Select idtipotx,Titulo from PosUpTx where Inventario<>0";
								if ($result32 = mysqli_query($conn, $query32)) {
									while ($row32 = mysqli_fetch_assoc($result32)) {
								?><option value="<?php echo $row32["idtipotx"]; ?> "><?php echo lang($row32["Titulo"]) ?></option> <?php
																																}
																																mysqli_free_result($result32);
																															}
																																	?>
							</select>
							<label><i class="fa fa-credit-card"></i> <?php echo lang('Tipo de Transacción'); ?></label>
						</div>
					</div>
				</div> -->
				<!-- <div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="col">
						<div class="form-floating" id="almaceninput">
							<select class="form-select" id="Almacen23[]" name="Almacen23[]" style="height:100px" multiple>
								<?php
								if ($_POST['sucursal'] == 0) {
									$query3224 = "Select a.IdAlm,a.Nombre from PosUpAlmacen a left join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi where  a.IdCompany=" . $_POST['Company'];
									if ($result3224 = mysqli_query($conn, $query3224)) {
										while ($row3224 = mysqli_fetch_assoc($result3224)) {
								?><option value="<?php echo $row3224["IdAlm"]; ?> "><?php echo $row3224["Nombre"] ?></option> <?php
																															}
																															mysqli_free_result($result3224);
																														}
																													} else {
																														//$query3224="Select a.IdAlm,a.Nombre from PosUpAlmacen a left join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi where a.IdUbi=".$_POST['sucursal']." and a.IdCompany=" . $_POST['Company'];
																														$query3224 = "Select a.IdAlm,a.Nombre from PosUpAlmacen a left join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi where  a.IdCompany=" . $_POST['Company'];
																														if ($result3224 = mysqli_query($conn, $query3224)) {
																															while ($row3224 = mysqli_fetch_assoc($result3224)) {
																																?><option value="<?php echo $row3224["IdAlm"]; ?> "><?php echo $row3224["Nombre"] ?></option> <?php
																																																							}
																																																							mysqli_free_result($result3224);
																																																						}
																																																					}
																																																								?>
							</select>
							<label><i class="fa fa-archive"></i> <?php echo lang('Almacén'); ?></label>
						</div>
					</div>
				</div> --><!-- <div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
					<div class="col">
						<div class="form-floating">
							<input class="form-control filt" type="text" id="Producto2" name="Producto2" onchange="Producto();" />
							<label><i class="fa fa-archive"></i> <?php echo lang('Producto'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="Producto3" name="Producto3" readonly />
							</div>
						</div>
						<button class="btn btn-outline-primary px-1" type="button" onclick="Seriales(1)"><i class="fa fa-search"></i></button>
					</div>
				</div> -->

				<!-- <div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
					<div class="col">
						<div class="form-floating">
							<input class="form-control filt" type="text" id="BeneficiarioSE" name="BeneficiarioSE" onchange="BenefeSE();" />
							<label><i class="fa fa-user"></i> <?php echo lang('Beneficiario'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="BeneficiarioSE2" name="BeneficiarioSE2" readonly />
							</div>
						</div>
						<button class="btn btn-outline-primary px-1" type="button" onclick="Seriales(2)"><i class="fa fa-search"></i></button>
					</div>
				</div> -->

				<!-- <div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
					<div class="col">
						<div class="form-floating">
							<input class="form-control filt" type="text" id="Cliente2" name="Cliente2" onchange="Clientado();" />
							<label><i class="fa fa-user"></i> <?php echo lang('Cliente'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="Cliente3" name="Cliente3" readonly />
							</div>
						</div>
						<button class="btn btn-outline-primary px-1" type="button" onclick="Seriales(3)"><i class="fa fa-search"></i></button>
					</div>
				</div> -->

				<div class="col-12 col-lg-6 p-1">
					<label for="Filtrar"><?php echo lang('Tipo de Operación'); ?></label>

					<select id="Filtrar" name="Filtrar[]" multiple style="width: 100%">
						<?php
						$conn = conectar();
						$query32 = "Select idtipotx,Titulo from PosUpTx where Inventario<>0";
						if ($result32 = mysqli_query($conn, $query32)) {
							while ($row32 = mysqli_fetch_assoc($result32)) {
						?><option value="<?php echo $row32["idtipotx"]; ?> "><?php echo lang($row32["Titulo"]) ?></option> <?php
																														}
																														mysqli_free_result($result32);
																													}
																															?>
					</select>
				</div>

				<div class="col-12 col-lg-6 p-1">
					<label for="mIdAlmacen"><?php echo lang('Almacén'); ?></label>
					<select id="mIdAlmacen" name="mIdAlmacen[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						if ($_POST['sucursal'] == '0') {
							$sql = "SELECT a.*,b.Nombre as UBicacion FROM PosUpAlmacen a inner join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi WHERE a.IdCompany = " . $_POST["Company"] . " ";
						} else {
							$sql = "SELECT a.*,b.Nombre as UBicacion FROM PosUpAlmacen a inner join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi WHERE a.IdCompany = " . $_POST["Company"] . " and b.IdUbi=" . $_POST['sucursal'];
						}
						if ($result = mysqli_query($conn, $sql)) {
							while ($row = mysqli_fetch_assoc($result)) {
						?>
								<option value="<?php echo trim($row['IdAlm']); ?>"><?php echo trim($row['Nombre']); ?></option>
						<?
							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>


				<div class="col-12 col-lg-6 p-1">
					<label for="mIdProductos"><i class="fa fa-archive" aria-hidden="true"></i> <?php echo lang("Productos"); ?></label>
					<select id="mIdProductos" name="mIdProductos[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$query = "SELECT CodIdBasico,CodIdAmpliado,CodBarra,Descripcion FROM PosUpProducto a where a.EsCompuesto=0 and a.IdCompany = " . $_POST["Company"] . "";
						if ($result = mysqli_query($conn, $query)) {
							while ($row = mysqli_fetch_assoc($result)) {

						?>
								<option value="<?php echo trim($row['CodIdBasico']); ?>"><?php echo trim($row['Descripcion']); ?></option>
						<?

							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>


				<div class="col-12 col-lg-6 p-1">
					<label for="mIdProevedor"><?php echo lang("Beneficiarios"); ?></label>
					<select id="mIdProevedor" name="mIdProevedor[]" multiple="multiple" style="width: 100%">
					</select>
				</div>
				<div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
					<div class="col">
						<div class="form-floating">
							<input class="form-control filt" type="text" id="Serial" name="Serial" onchange="CodigoHasLPRES();" />
							<label><i class="fa fa-hashtag"></i> <?php echo lang('Desde Serial'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
					<div class="col">
						<div class="form-floating">
							<input class="form-control filt" type="text" id="serialH" name="serialH" onchange="CodigoHasLPRES();" />
							<label><i class="fa fa-hashtag"></i> <?php echo lang('Hasta Serial'); ?></label>
						</div>
					</div>
				</div>
			</div>

			<div class="form-check">
				<input class="form-check-input" type="checkbox" name="ivs" id="ivs">
				<label class="form-check-label" for="ivs">
					<?php echo lang('Incluir Variaciones del Serial'); ?>
				</label>
			</div>

			<script>
				$(document).ready(function() {
					$("#mIdProevedor").select2({
						ajax: {
							delay: 1000,
							type: "POST",
							dataType: 'json',
							url: 'informezseek.php',
							data: function(params) {
								var queryParameters = {
									search: params.term,
									Accion: "ProveedorBA",
									CompanyActual: document.getElementById("CompanyActual").innerHTML
								}

								return queryParameters;
							},
							processResults: function(data) {
								return {
									results: data.results
								};
							}
						},
						dropdownParent: $("#apps-modalz"),
					});
					$("#mIdAlmacen").select2({
						dropdownParent: $("#apps-modalz"),
					});
					$("#Filtrar").select2({
						dropdownParent: $("#apps-modalz"),
					});
					$("#mIdVendedor").select2({
						dropdownParent: $("#apps-modalz"),
					});
					$("#mIdProductos").select2({
						dropdownParent: $("#apps-modalz"),
					});
				});
			</script>
		</div>
		<!-- Histórico de Seriales -->
		<div class="modal-footer" style="width: 100%;">
  		  <div class="row input-group w-100 m-0">
  		      <div class="col-3 text-center p-1">
   		         <button class="btn btn-outline-danger w-100" type="reset" id="limpiar">
   		             <i class="fa fa-trash"></i> <?php echo lang('Limpiar'); ?>
   		         </button>
   		     </div>
  		      <div class="col-3 text-center p-1">
   		         <button class="btn btn-outline-primary w-100" type="button" onclick="var f = this.closest('form'); f.action='historialseriales.php'; f.target='_blank'; f.submit();">
   		             <i class="fa fa-print"></i> <?php echo lang('Preliminar'); ?>
   		         </button>
   		     </div>
   		     <div class="col-3 text-center p-1">
   		         <button class="btn btn-danger w-100" type="button" onclick="var f = this.closest('form'); f.action='reporte_historial_seriales_pdf.php'; f.target='_blank'; f.submit();">
   		             <i class="fa fa-file-pdf-o"></i> PDF
   		         </button>
    		    </div>
    		    <div class="col-3 text-center p-1">
    		        <button class="btn btn-outline-secondary w-100" type="button" data-bs-dismiss="modal">
    		            <i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?>
    		        </button>
     		   </div>
    		</div>
		</div>
	</form>
	<script>
		var fecha = new Date();
		var mes = fecha.getMonth() + 1;
		var dia = fecha.getDate();
		var ano = fecha.getFullYear();
		if (dia < 10) {
			dia = '0' + dia;
		}
		if (mes < 10) {
			mes = '0' + mes;
		}
		document.getElementById('FECH').value = ano + "-" + mes + "-" + dia;
		document.getElementById('FECH2').value = ano + "-" + mes + "-" + dia;
	</script>
<?php
}

if ($_POST["Accion"] === "10") {
?>
	<div class="modal-header">
		<h5 class="modal-title"><img src="/img/informez.png" alt="informe" height="24px" width="24px"> <?php echo lang('Movimiento Detallados'); ?></h5>
		<button class="btn-close" type="button" data-bs-dismiss="modal"></button>
	</div>
	<form id="ListaPrecio" method="POST" target="_Blank" action="detalladoin.php" onsubmit="return false">
		<div class="modal-body">

			<input type="hidden" name="CompanyActual" value="<?php echo $_POST['Company']; ?>" />
			<input type="hidden" name="IdCompanyGrp" value="<?php echo $_POST['IdCompanyGrp']; ?>" />
			<input type="hidden" name="CIdPlan" value="<?php echo $_POST['CIdPlan']; ?>" />
			<input type="hidden" name="SimMil" value="<?php echo $_POST['SimMil']; ?>" />
			<input type="hidden" name="SimDec" value="<?php echo $_POST['SimDec']; ?>" />
			<input type="hidden" name="CD" value="<?php echo $_POST['CD']; ?>" />
			<input type="hidden" name="direccion" value="<?php echo $_POST['direccion']; ?>" />
			<input type="hidden" name="NameCompany" value="<?php echo $_POST['NameCompany']; ?>" />
			<input type="hidden" name="sucursal" value="<?php echo $_POST['sucursal']; ?>" />
			<input type="hidden" name="fectx5" id="fectx5" />
			<span style="display:none" id="devueltachavalesLPRESX"></span>
			<span style="display:none" id="CodigoDesaLLPRESX"></span>
			<span style="display:none" id="CodigoHasaLLPRESX"></span>
			<span style="display:none" id="BenefeLLPRESX"></span>
			<span style="display:none" id="AlmaLLPRESX"></span>

			<div class="row p-1">

				<div class="col-12 p-1 <?php echo $notemp; ?>">
					<div class="col">
						<div class="form-floating">
							<select id='IdCompanySelect' name='IdCompanySelect' onchange='selectidcomp(document.getElementById("IdCompanySelect").value);changeinput("0","","AlmacenRESX");changeinput("0","","","","Familias2asdX");' class="form-select <?php echo $notemprise; ?>" aria-label="Default select example">
								<?php
								$conn = conectar();

								$query = "SELECT '" . $_POST["IdCompanyGrp"] . "' as ID, ' [" . lang('Todas') . "]' as Empresa  union  SELECT Id as ID, comercio as Empresa FROM PosUpCompany where Id in ( " . $_POST["IdCompanyGrp"] . ")  order by Empresa ";
								//echo $query;
								if ($result = mysqli_query($conn, $query)) {
									$n = 0;
									/* obtener array asociativo */
									while ($row = mysqli_fetch_assoc($result)) {
								?><option value="<?php echo trim($row['ID']); ?>" <?php if (trim($row['ID']) == trim($_POST['emprise'])) {
																						echo "selected";
																					}; ?>><?php echo trim($row['Empresa']); ?></option><?
																																	}

																																	mysqli_free_result($result);
																																}
																																		?>
							</select>
							<label><i class="fa fa-sorttt"></i> <?php echo lang('Empresa'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<div class="input-daterange input-group" style='display:none' data-date-format="dd/mm/yyyy"></div>
								<input class="form-control" type="date" id="DesdeFechaX" name="DesdeFechaX">
								<label><i class="fa fa-calendar"></i> <?php echo lang('Desde la Fecha'); ?></label>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<div class="input-daterange input-group" style='display:none' data-date-format="dd/mm/yyyy"></div>
								<input class="form-control" type="date" id="FechaHastaX" name="FechaHastaX" placeholder="To">
								<label><i class="fa fa-calendar"></i> <?php echo lang('Hasta la Fecha'); ?></label>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<select class="form-select" id="TransaccionX" name="TransaccionX">
									<?php
									$query = "select '*','" . lang('TODOS') . "' union SELECT Idtipotx,Titulo FROM PosUpTx WHERE Inventario <>0 ";
									if ($result = mysqli_query($conn, $query)) {
										while ($row = mysqli_fetch_assoc($result)) {
									?><option value="<?php echo trim($row['*']); ?>"><?php echo trim($row[lang('TODOS')]); ?></option><?
																																	}
																																	mysqli_free_result($result);
																																}
																																		?>
								</select>
								<label><i class="fa fa-credit-card"></i> <?php echo lang('Tipo de Transacción'); ?></label>
							</div>
						</div>
					</div>
				</div>

				<div class="col-12 col-lg-6 p-1">
					<label for="mIdAlmacen"><?php echo lang('Almacén'); ?></label>
					<select id="mIdAlmacen" name="mIdAlmacen[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						if ($_POST['sucursal'] == '0') {
							$sql = "SELECT a.*,b.Nombre as UBicacion FROM PosUpAlmacen a inner join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi WHERE a.IdCompany = " . $_POST["Company"] . " ";
						} else {
							$sql = "SELECT a.*,b.Nombre as UBicacion FROM PosUpAlmacen a inner join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi WHERE a.IdCompany = " . $_POST["Company"] . " and b.IdUbi=" . $_POST['sucursal'];
						}
						if ($result = mysqli_query($conn, $sql)) {
							while ($row = mysqli_fetch_assoc($result)) {
						?>
								<option value="<?php echo trim($row['IdAlm']); ?>"><?php echo trim($row['Nombre']); ?></option>
						<?
							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>

				<div class="col-12 col-lg-6 p-1">
					<label for="mIdfamilia"><?php echo lang("Familia"); ?></label>
					<select id="mIdfamilia" name="mIdfamilia[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$query = "SELECT a.IdVarios,if(a.IdVariosPadre=0,a.ITEM,concat(b.ITEM,' > ', a.ITEM)) AS ITEM FROM PosUpvarios a left join PosUpvarios b on a.IdCompany=b.IdCompany and a.IdVariosPadre = b.IdVarios and a.TIPOITEM = b.TIPOITEM and b.TIPOITEM = 2 WHERE a.IdCompany=" . $_POST["Company"] . " and a.TIPOITEM = 2 order by if(a.IdVariosPadre=0,a.ITEM,concat(b.ITEM,' > ', a.ITEM)) asc";
						//echo $query;
						if ($result = mysqli_query($conn, $query)) {
							while ($row = mysqli_fetch_assoc($result)) {

						?>
								<option value="<?php echo trim($row['IdVarios']); ?>"><?php echo trim($row['ITEM']); ?></option>
						<?

							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>
				<div class="col-12 col-lg-6 p-1">
					<label for="mIdMarca"><?php echo lang('Marca'); ?></label>
					<select id="mIdMarca" name="mIdMarca[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$sql = "SELECT idmarca,nombre FROM PosUpc_marcas a where a.IdCompany = " . $_POST["Company"];
						if ($result = mysqli_query($conn, $sql)) {
							while ($row = mysqli_fetch_assoc($result)) {
						?>
								<option value="<?php echo trim($row['idmarca']); ?>"><?php echo trim($row['nombre']); ?></option>
						<?
							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>

				<div class="col-12 col-lg-6 p-1">
					<label for="mIdProductos"><i class="fa fa-archive" aria-hidden="true"></i> <?php echo lang("Productos"); ?></label>
					<select id="mIdProductos" name="mIdProductos[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$query = "SELECT CodIdBasico,CodIdAmpliado,CodBarra,Descripcion FROM PosUpProducto a where a.EsCompuesto=0 and a.IdCompany = " . $_POST["Company"] . "";
						if ($result = mysqli_query($conn, $query)) {
							while ($row = mysqli_fetch_assoc($result)) {

						?>
								<option value="<?php echo trim($row['CodIdBasico']); ?>"><?php echo trim($row['Descripcion']); ?></option>
						<?

							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>

				<script>
					$(document).ready(function() {
						$("#mIdProevedor").select2({
							ajax: {
								delay: 1000,
								type: "POST",
								dataType: 'json',
								url: 'informezseek.php',
								data: function(params) {
									var queryParameters = {
										search: params.term,
										Accion: "ProveedorBA",
										CompanyActual: document.getElementById("CompanyActual").innerHTML
									}

									return queryParameters;
								},
								processResults: function(data) {
									return {
										results: data.results
									};
								}
							},
							dropdownParent: $("#apps-modalz"),
						});
						$("#mIdAlmacen").select2({
							dropdownParent: $("#apps-modalz"),
						});
						$("#mIdfamilia").select2({
							dropdownParent: $("#apps-modalz"),
						});
						$("#mIdMarca").select2({
							dropdownParent: $("#apps-modalz"),
						});
						$("#mIdProductos").select2({
							dropdownParent: $("#apps-modalz"),
						});
					});
				</script>
				<!-- <div class="col-12 col-lg-4 p-1 <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating" id="almaceninput">
								<select class="form-select" id="AlmacenRESX" name="AlmacenRESX">
									<?php
									if ($_POST['sucursal'] == '0') {
										$query = "select '*','" . lang('TODOS') . "' union SELECT IdAlm,Nombre FROM PosUpAlmacen WHERE IdCompany=" . $_POST["Company"] . "";
										if ($result = mysqli_query($conn, $query)) {
											while ($row = mysqli_fetch_assoc($result)) {
									?><option value="<?php echo trim($row['*']); ?>"><?php echo trim($row[lang('TODOS')]); ?></option><?
																																	}
																																	mysqli_free_result($result);
																																}
																															} else {
																																$query = " SELECT a.IdAlm, a.Nombre FROM PosUpAlmacen a inner join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi WHERE a.IdCompany=" . $_POST["Company"] . " and b.IdUbi=" . $_POST['sucursal'];
																																if ($result = mysqli_query($conn, $query)) {
																																	while ($row = mysqli_fetch_assoc($result)) {
																																		?><option value="<?php echo trim($row['IdAlm']); ?>"><?php echo trim($row['Nombre']); ?></option><?
																																																										}
																																																										mysqli_free_result($result);
																																																									}
																																																								}
																																																											?>
								</select>
								<label><i class="fa fa-archive"></i> <?php echo lang('Almacén'); ?></label>
							</div>
						</div>
					</div>
				</div> -->
				<!-- <div class="col-12 col-lg-4 p-1 <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating" id="familiainput">
								<select class="form-select" id="Familias2asdX" name="Familias2asdX">
									<?php
									$query2 = "select '*','" . lang('TODOS') . "' union SELECT IdVarios,ITEM FROM PosUpvarios WHERE TIPOITEM=2 and IdCompany=" . $_POST['Company'] . "";
									if ($result2 = mysqli_query($conn, $query2)) {
										while ($row2 = mysqli_fetch_assoc($result2)) {
									?><option value="<?php echo trim($row2['*']); ?>"><?php echo trim($row2[lang('TODOS')]); ?></option><?
																																	}
																																	mysqli_free_result($result);
																																}
																																		?>
								</select>
								<label><i class="fa fa-th-large"></i> <?php echo lang('Familia'); ?></label>
							</div>
						</div>
					</div>
				</div> -->
				<!-- <div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="CodigoDesdeLPRESX" name="CodigoDesdeLPRESX" onchange="CodigoDesLPRESX();" />
								<label><i class="fa fa-archive"></i> <?php echo lang('Desde Producto'); ?></label>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="CodigoDesde2LPRESX" name="CodigoDesde2LPRESX" readonly />
							</div>
						</div>
						<button class="btn btn-outline-primary px-1" type="button" onclick="ListaLPRESX(2)"><i class="fa fa-search"></i></button>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="CodigoHastaLPRESX" name="CodigoHastaLPRESX" onchange="CodigoHasLPRESX();" />
								<label><i class="fa fa-archive"></i> <?php echo lang('Hasta Producto'); ?></label>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="CodigoHasta2LPRESX" name="CodigoHasta2LPRESX" readonly />
							</div>
						</div>
						<button class="btn btn-outline-primary px-1" type="button" onclick="ListaLPRESX(3)"><i class="fa fa-search"></i></button>
					</div>
				</div> -->
				<!-- <div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="MarcaDetal" name="MarcaDetal" onchange="MarcaEnterita();" />
								<label><i class="fa fa-tags"></i> <?php echo lang('Marca'); ?></label>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="MarcaDetal2" name="MarcaDetal2" readonly />
							</div>
						</div>
						<button class="btn btn-outline-primary px-1" type="button" onclick="ListaLPRESX(4)"><i class="fa fa-search"></i></button>
					</div>
				</div> -->
			</div>

			<div class='row p-1'>
				<div class="col-6 col-md-6">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="ProductosInvX" id="ProductosInvX">
						<label class="form-check-label" for="ProductosInvX">
							<?php echo lang('Productos Con Inventario'); ?>
						</label>
					</div>
				</div>

				<div class="col-6 col-md-6">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="ProductosMovX" id="ProductosMovX">
						<label class="form-check-label" for="ProductosMovX">
							<?php echo lang('Incluir Productos sin Movimiento'); ?>
						</label>
					</div>
				</div>

				<div class="col-6 col-md-6">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="SerialesZZ" id="SerialesZZ">
						<label class="form-check-label" for="SerialesZZ">
							<?php echo lang('Seriales'); ?>
						</label>
					</div>
				</div>
			</div>
		</div>

<!-- Movimiento Detallados

 -->
		<div class="modal-footer" style="width: 100%;">
   			 <div class="row input-group w-100 m-0">
   			     <div class="col-3 text-center p-1">
    			        <button class="btn btn-outline-danger w-100" type="reset" id="limpiar">
    			            <i class="fa fa-trash"></i> <?php echo lang('Limpiar'); ?>
     			       </button>
    			    </div>
    			    <div class="col-3 text-center p-1">
    			        <button class="btn btn-outline-primary w-100" type="button" onclick="var f = this.closest('form'); f.action='detalladoin.php'; f.target='_blank'; f.submit();">
    			            <i class="fa fa-print"></i> <?php echo lang('Preliminar'); ?>
    			        </button>
    			    </div>
    			    <div class="col-3 text-center p-1">
    			        <button class="btn btn-danger w-100" type="button" onclick="var f = this.closest('form'); f.action='reporte_detallado_pdf.php'; f.target='_blank'; f.submit();">
    			            <i class="fa fa-file-pdf-o"></i> PDF
    			        </button>
   			     </div>
   			     <div class="col-3 text-center p-1">
   			         <button class="btn btn-outline-secondary w-100" type="button" data-bs-dismiss="modal">
    			            <i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?>
      			      </button>
     			   </div>
    			</div>
			</div>
	</form>

	<script>
		var fecha = new Date();
		var mes = fecha.getMonth() + 1;
		var dia = fecha.getDate();
		var ano = fecha.getFullYear();
		if (dia < 10)
			dia = '0' + dia;
		if (mes < 10)
			mes = '0' + mes
		document.getElementById('DesdeFechaX').value = ano + "-" + mes + "-" + dia;
		document.getElementById('FechaHastaX').value = ano + "-" + mes + "-" + dia;
	</script>
<?php
}

if ($_POST["Accion"] === "11") {
?>
	<div class="modal-header">
		<h5 class="modal-title"><img src="/img/informez.png" alt="informe" height="24px" width="24px"> <?php echo lang('Movimiento Resumido'); ?></h5>
		<button class="btn-close" type="button" data-bs-dismiss="modal"></button>
	</div>
	<form id="ListaPrecio" method="POST" target="_Blank" action="resumidoin.php" onsubmit="return false">
		<div class="modal-body">

			<input type="hidden" name="CompanyActual" value="<?php echo $_POST['Company']; ?>" />
			<input type="hidden" name="IdCompanyGrp" value="<?php echo $_POST['IdCompanyGrp']; ?>" />
			<input type="hidden" name="CIdPlan" value="<?php echo $_POST['CIdPlan']; ?>" />
			<input type="hidden" name="SimMil" value="<?php echo $_POST['SimMil']; ?>" />
			<input type="hidden" name="SimDec" value="<?php echo $_POST['SimDec']; ?>" />
			<input type="hidden" name="CD" value="<?php echo $_POST['CD']; ?>" />
			<input type="hidden" name="direccion" value="<?php echo $_POST['direccion']; ?>" />
			<input type="hidden" name="NameCompany" value="<?php echo $_POST['NameCompany']; ?>" />
			<input type="hidden" name="sucursal" value="<?php echo $_POST['sucursal']; ?>" />
			<input type="hidden" name="fectx5" id="fectx5">
			<span style="display:none" id="devueltachavalesLPRES"></span>
			<span style="display:none" id="CodigoDesaLLPRES"></span>
			<span style="display:none" id="CodigoHasaLLPRES"></span>
			<span style="display:none" id="BenefeLLPRES"></span>
			<span style="display:none" id="AlmaLLPRES"></span>

			<div class="row p-1">
				<div class="col-12 p-1 <?php echo $notemp; ?>">
					<div class="col">
						<div class="form-floating">
							<select id='IdCompanySelect' name='IdCompanySelect' onchange='selectidcomp(document.getElementById("IdCompanySelect").value);changeinput("0","","","","Familias2asd");changeinput("1","","Almacen234[]");' class="form-select  <?php echo $notemprise; ?>" aria-label="Default select example">
								<?php
								$conn = conectar();

								$query = "SELECT '" . $_POST["IdCompanyGrp"] . "' as ID, ' [" . lang('Todas') . "]' as Empresa  union  SELECT Id as ID, comercio as Empresa FROM PosUpCompany where Id in ( " . $_POST["IdCompanyGrp"] . ")  order by Empresa ";
								//echo $query;
								if ($result = mysqli_query($conn, $query)) {
									$n = 0;
									/* obtener array asociativo */
									while ($row = mysqli_fetch_assoc($result)) {
								?><option value="<?php echo trim($row['ID']); ?>" <?php if (trim($row['ID']) == trim($_POST['emprise'])) {
																						echo "selected";
																					}; ?>><?php echo trim($row['Empresa']); ?></option><?
																																	}

																																	mysqli_free_result($result);
																																}
																																		?>
							</select>
							<label><i class="fa fa-sorttt"></i> <?php echo lang('Empresa'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<div class="input-daterange input-group" style='display:none' data-date-format="dd/mm/yyyy"></div>
								<input class="form-control" type="date" id="DesdeFecha" name="DesdeFecha">
								<label><i class="fa fa-calendar"></i> <?php echo lang('Desde la Fecha'); ?></label>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<div class="input-daterange input-group" style='display:none' data-date-format="dd/mm/yyyy"></div>
								<input class="form-control" type="date" id="FechaHasta" name="FechaHasta">
								<label><i class="fa fa-calendar"></i> <?php echo lang('Hasta la Fecha'); ?></label>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<select class="form-select" id="OrdenRES" name="OrdenRES">
									<option value="1"><?php echo lang('Código'); ?></option>
									<option value="2"><?php echo lang('Descripción'); ?></option>
									<option value="3"><?php echo lang('Cantidad de Inventario'); ?></option>
									<option value="6"><?php echo lang('Mayor Venta'); ?></option>
								</select>
								<label><i class="fa fa-sort"></i> <?php echo lang('Orden'); ?></label>
							</div>
						</div>
					</div>
				</div>
				<!-- <div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating" id="familiainput">
								<select class="form-select" id="Familias2asd" name="Familias2asd">
									<?php $query2 = "select '*','" . lang('TODOS') . "' union SELECT IdVarios,ITEM FROM PosUpvarios WHERE TIPOITEM=2 and IdCompany=" . $_POST['Company'] . "";
									if ($result2 = mysqli_query($conn, $query2)) {
										$n = 0;
										while ($row2 = mysqli_fetch_assoc($result2)) {
									?><option value="<?php echo trim($row2['*']); ?>"><?php echo trim($row2[lang('TODOS')]); ?></option><?
																																	}
																																	mysqli_free_result($result2);
																																} ?>
								</select>
								<label><i class="fa fa-th-large"></i> <?php echo lang('Familia'); ?></label>
							</div>
						</div>
					</div>
				</div> -->

				<div class="col-12 col-lg-4 p-1">
					<label for="mIdfamilia"><?php echo lang("Familia"); ?></label>
					<select id="mIdfamilia" name="mIdfamilia[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$query = "SELECT a.IdVarios,if(a.IdVariosPadre=0,a.ITEM,concat(b.ITEM,' > ', a.ITEM)) AS ITEM FROM PosUpvarios a left join PosUpvarios b on a.IdCompany=b.IdCompany and a.IdVariosPadre = b.IdVarios and a.TIPOITEM = b.TIPOITEM and b.TIPOITEM = 2 WHERE a.IdCompany=" . $_POST["Company"] . " and a.TIPOITEM = 2 order by if(a.IdVariosPadre=0,a.ITEM,concat(b.ITEM,' > ', a.ITEM)) asc";
						//echo $query;
						if ($result = mysqli_query($conn, $query)) {
							while ($row = mysqli_fetch_assoc($result)) {

						?>
								<option value="<?php echo trim($row['IdVarios']); ?>"><?php echo trim($row['ITEM']); ?></option>
						<?

							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>
				<!-- <div class="col-12 col-lg-12 p-1  <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating" id="almaceninput">
								<select class="form-select" id="Almacen234[]" name="Almacen234[]" style="height:100px" multiple>
									<?php
									if ($_POST['sucursal'] == 0) {
										$query3224 = "Select a.IdAlm,a.Nombre from PosUpAlmacen a left join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi where  a.IdCompany=" . $_POST['Company'];
										if ($result3224 = mysqli_query($conn, $query3224)) {
											while ($row3224 = mysqli_fetch_assoc($result3224)) {
									?><option value="<?php echo $row3224["IdAlm"]; ?> "><?php echo $row3224["Nombre"] ?></option> <?php
																																}
																																mysqli_free_result($result3224);
																															}
																														} else {
																															$query3224 = "Select a.IdAlm,a.Nombre from PosUpAlmacen a left join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi where a.IdUbi=" . $_POST['sucursal'] . " and a.IdCompany=" . $_POST['Company'];
																															if ($result3224 = mysqli_query($conn, $query3224)) {
																																while ($row3224 = mysqli_fetch_assoc($result3224)) {
																																	?><option value="<?php echo $row3224["IdAlm"]; ?> "><?php echo $row3224["Nombre"] ?></option> <?php
																																																								}
																																																								mysqli_free_result($result3224);
																																																							}
																																																						}
																																																									?>
								</select>
								<label><i class="fa fa-archive"></i> <?php echo lang('Almacén'); ?></label>
							</div>
						</div>
					</div>
				</div> -->

				<div class="col-12 col-lg-4 p-1">
					<label for="mIdAlmacen"><?php echo lang('Almacén'); ?></label>
					<select id="mIdAlmacen" name="mIdAlmacen[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						if ($_POST['sucursal'] == '0') {
							$sql = "SELECT a.*,b.Nombre as UBicacion FROM PosUpAlmacen a inner join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi WHERE a.IdCompany = " . $_POST["Company"] . " ";
						} else {
							$sql = "SELECT a.*,b.Nombre as UBicacion FROM PosUpAlmacen a inner join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi WHERE a.IdCompany = " . $_POST["Company"] . " and b.IdUbi=" . $_POST['sucursal'];
						}
						if ($result = mysqli_query($conn, $sql)) {
							while ($row = mysqli_fetch_assoc($result)) {
						?>
								<option value="<?php echo trim($row['IdAlm']); ?>"><?php echo trim($row['Nombre']); ?></option>
						<?
							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>
				<!-- <div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="CodigoDesdeLPRES" name="CodigoDesdeLPRES" onchange="CodigoDesLPRES();" />
								<label><i class="fa fa-archive"></i> <?php echo lang('Desde Producto'); ?></label>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="CodigoDesde2LPRES" name="CodigoDesde2LPRES" readonly />
							</div>
						</div>
						<button class="btn btn-outline-primary px-1" type="button" onclick="ListaLPRES(2)"><i class="fa fa-search"></i></button>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="CodigoHastaLPRES" name="CodigoHastaLPRES" onchange="CodigoHasLPRES();" />
								<label><i class="fa fa-archive"></i> <?php echo lang('Hasta Producto'); ?></label>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="CodigoHasta2LPRES" name="CodigoHasta2LPRES" readonly />
							</div>
						</div>
						<button class="btn btn-outline-primary px-1" type="button" onclick="ListaLPRES(3)"><i class="fa fa-search"></i></button>
					</div>
				</div> -->

				<div class="col-12 col-lg-4 p-1">
					<label for="mIdProductos"><i class="fa fa-archive" aria-hidden="true"></i> <?php echo lang("Productos"); ?></label>
					<select id="mIdProductos" name="mIdProductos[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$query = "SELECT CodIdBasico,CodIdAmpliado,CodBarra,Descripcion FROM PosUpProducto a where a.IdCompany = " . $_POST["Company"] . " and Estado = 1";
						if ($result = mysqli_query($conn, $query)) {
							while ($row = mysqli_fetch_assoc($result)) {

						?>
								<option value="<?php echo trim($row['CodIdBasico']); ?>"><?php echo trim($row['Descripcion']); ?></option>
						<?

							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>


				<script>
					$(document).ready(function() {
						$("#mIdAlmacen").select2({
							dropdownParent: $("#apps-modalz"),
						});
						$("#mIdfamilia").select2({
							dropdownParent: $("#apps-modalz"),
						});
						$("#mIdProductos").select2({
							dropdownParent: $("#apps-modalz"),
						});
					});
				</script>
			</div>

			<div class='row p-1'>
				<div class="col-6 col-md-6">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="ProductosInv" id="ProductosInv">
						<label class="form-check-label" for="ProductosInv">
							<?php echo lang('Productos Con Inventario'); ?>
						</label>
					</div>
				</div>
				<div class="col-6 col-md-6">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="ProductosMov" id="ProductosMov">
						<label class="form-check-label" for="ProductosMov">
							<?php echo lang('Productos con Movimiento'); ?>
						</label>
					</div>
				</div>
			</div>
		</div>
		<!-- Movimiento Resumido -->
		<div class="modal-footer" style="width: 100%;">
    		<div class="row input-group w-100 m-0">
        		<div class="col-3 text-center p-1">
            		<button class="btn btn-outline-danger w-100" type="reset" id="limpiar">
       		         <i class="fa fa-trash"></i> <?php echo lang('Limpiar'); ?>
      		      </button>
     		   </div>
      		  <div class="col-3 text-center p-1">
      		      <button class="btn btn-outline-primary w-100" type="button" onclick="var f = this.closest('form'); f.action='resumidoin.php'; f.target='_blank'; f.submit();">
      		          <i class="fa fa-print"></i> <?php echo lang('Preliminar'); ?>
      		      </button>
      		  </div>
       		 <div class="col-3 text-center p-1">
       		     <button class="btn btn-danger w-100" type="button" onclick="var f = this.closest('form'); f.action='reporte_resumido_pdf.php'; f.target='_blank'; f.submit();">
       		         <i class="fa fa-file-pdf-o"></i> PDF
       		     </button>
      		  </div>
     		   <div class="col-3 text-center p-1">
     		       <button class="btn btn-outline-secondary w-100" type="button" data-bs-dismiss="modal">
      		          <i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?>
     		       </button>
    		    </div>
   		 </div>
		</div>
	</form>
	<script>
		var fecha = new Date();
		var mes = fecha.getMonth() + 1;
		var dia = fecha.getDate();
		var ano = fecha.getFullYear();
		if (dia < 10)
			dia = '0' + dia;
		if (mes < 10)
			mes = '0' + mes
		document.getElementById('DesdeFecha').value = ano + "-" + mes + "-" + dia;
		document.getElementById('FechaHasta').value = ano + "-" + mes + "-" + dia;
	</script>
<?php
}

if ($_POST["Accion"] === "12") {
?>
	<div class="modal-header">
		<h5 class="modal-title"><img src="/img/informez.png" alt="informe" height="24px" width="24px"> <?php echo lang('Movimiento Fiscal'); ?></h5>
		<button class="btn-close" type="button" data-bs-dismiss="modal"></button>
	</div>
	<form id="ListaPrecio" method="POST" target="_Blank" action="fiscal.php" onsubmit="return false">
		<div class="modal-body">
			<input type="hidden" name="fectx5" id="fectx5" />

			<input type="hidden" name="CompanyActual" value="<?php echo $_POST['Company']; ?>" />
			<input type="hidden" name="IdCompanyGrp" value="<?php echo $_POST['IdCompanyGrp']; ?>" />
			<input type="hidden" name="CIdPlan" value="<?php echo $_POST['CIdPlan']; ?>" />
			<input type="hidden" name="SimMil" value="<?php echo $_POST['SimMil']; ?>" />
			<input type="hidden" name="SimDec" value="<?php echo $_POST['SimDec']; ?>" />
			<input type="hidden" name="CD" value="<?php echo $_POST['CD']; ?>" />
			<input type="hidden" name="direccion" value="<?php echo $_POST['direccion']; ?>" />
			<input type="hidden" name="NameCompany" value="<?php echo $_POST['NameCompany']; ?>" />
			<input type="hidden" name="sucursal" value="<?php echo $_POST['sucursal']; ?>" />
			<span style="display:none" id="devueltachavalesLPRESG"></span>
			<span style="display:none" id="CodigoDesaLLPRESG"></span>
			<span style="display:none" id="CodigoHasaLLPRESG"></span>
			<span style="display:none" id="BenefeLLPRESG"></span>
			<span style="display:none" id="AlmaLLPRESG"></span>

			<div class="row p-1">

				<div class="col-12 p-1 <?php echo $notemp; ?>">
					<div class="col">
						<div class="form-floating">
							<select id='IdCompanySelect' name='IdCompanySelect' onchange='selectidcomp(document.getElementById("IdCompanySelect").value);changeinput("1","","Almacen234G[]");' class="form-select <?php echo $notemprise; ?>" aria-label="Default select example">
								<?php
								$conn = conectar();

								$query = "SELECT '" . $_POST["IdCompanyGrp"] . "' as ID, ' [" . lang('Todas') . "]' as Empresa  union  SELECT Id as ID, comercio as Empresa FROM PosUpCompany where Id in ( " . $_POST["IdCompanyGrp"] . ")  order by Empresa ";
								//echo $query;
								if ($result = mysqli_query($conn, $query)) {
									$n = 0;
									/* obtener array asociativo */
									while ($row = mysqli_fetch_assoc($result)) {
								?><option value="<?php echo trim($row['ID']); ?>" <?php if (trim($row['ID']) == trim($_POST['emprise'])) {
																						echo "selected";
																					}; ?>><?php echo trim($row['Empresa']); ?></option><?
																																	}

																																	mysqli_free_result($result);
																																}
																																		?>
							</select>
							<label><i class="fa fa-sorttt"></i> <?php echo lang('Empresa'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<div class="input-daterange input-group" style='display:none' data-date-format="dd/mm/yyyy"></div>
								<input class="form-control" type="date" id="DesdeFechaG" name="DesdeFechaG">
								<label><i class="fa fa-calendar"></i> <?php echo lang('Desde la Fecha'); ?></label>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<div class="input-daterange input-group" style='display:none' data-date-format="dd/mm/yyyy"></div>
								<input class="form-control" type="date" id="FechaHastaG" name="FechaHastaG">
								<label><i class="fa fa-calendar"></i> <?php echo lang('Hasta la Fecha'); ?></label>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<select class="form-select" id="OrdenRESG" name="OrdenRESG">
									<option value="1"><?php echo lang('Código'); ?></option>
									<option value="2"><?php echo lang('Descripción'); ?></option>
									<option value="3"><?php echo lang('Cantidad de Inventario'); ?></option>
								</select>
								<label><i class="fa fa-sort"></i> <?php echo lang('Orden'); ?></label>
							</div>
						</div>
					</div>
				</div>
				<!-- <div class="col-12 col-lg-12 p-1 <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating" id="almaceninput">
								<select class="form-select" id="Almacen234G[]" name="Almacen234G[]" style="height:100px" multiple>
									<?php
									if ($_POST['sucursal'] == 0) {
										$query3224 = "Select a.IdAlm,a.Nombre from PosUpAlmacen a left join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi where  a.IdCompany=" . $_POST['Company'];
										if ($result3224 = mysqli_query($conn, $query3224)) {
											while ($row3224 = mysqli_fetch_assoc($result3224)) {
									?><option value="<?php echo $row3224["IdAlm"]; ?> "><?php echo $row3224["Nombre"] ?></option> <?php
																																}
																																mysqli_free_result($result3224);
																															}
																														} else {
																															$query3224 = "Select a.IdAlm,a.Nombre from PosUpAlmacen a left join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi where a.IdUbi=" . $_POST['sucursal'] . " and a.IdCompany=" . $_POST['Company'];
																															if ($result3224 = mysqli_query($conn, $query3224)) {
																																while ($row3224 = mysqli_fetch_assoc($result3224)) {
																																	?><option value="<?php echo $row3224["IdAlm"]; ?> "><?php echo $row3224["Nombre"] ?></option> <?php
																																																								}
																																																								mysqli_free_result($result3224);
																																																							}
																																																						}
																																																									?>
								</select>
								<label><i class="fa fa-archive"></i> <?php echo lang('Almacén'); ?></label>
							</div>
						</div>
					</div>
				</div> -->

				<div class="col-12 col-lg-6 p-1">
					<label for="mIdAlmacen"><?php echo lang('Almacén'); ?></label>
					<select id="mIdAlmacen" name="mIdAlmacen[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						if ($_POST['sucursal'] == '0') {
							$sql = "SELECT a.*,b.Nombre as UBicacion FROM PosUpAlmacen a inner join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi WHERE a.IdCompany = " . $_POST["Company"] . " ";
						} else {
							$sql = "SELECT a.*,b.Nombre as UBicacion FROM PosUpAlmacen a inner join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi WHERE a.IdCompany = " . $_POST["Company"] . " and b.IdUbi=" . $_POST['sucursal'];
						}
						if ($result = mysqli_query($conn, $sql)) {
							while ($row = mysqli_fetch_assoc($result)) {
						?>
								<option value="<?php echo trim($row['IdAlm']); ?>"><?php echo trim($row['Nombre']); ?></option>
						<?
							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>
				<!-- <div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="CodigoDesdeLPRESG" name="CodigoDesdeLPRESG" onchange="CodigoDesLPRESG();" />
								<label><i class="fa fa-archive"></i> <?php echo lang('Desde Producto'); ?></label>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="CodigoDesde2LPRESG" name="CodigoDesde2LPRESG" readonly />
							</div>
						</div>
						<button class="btn btn-outline-primary px-1" type="button" onclick="ListaLPRESG(2)"><i class="fa fa-search"></i></button>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="CodigoHastaLPRESG" name="CodigoHastaLPRESG" onchange="CodigoHasLPRESG();" />
								<label><i class="fa fa-archive"></i> <?php echo lang('Hasta Producto'); ?></label>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1 <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="CodigoHasta2LPRESG" name="CodigoHasta2LPRESG" readonly />
							</div>
						</div>
						<button class="btn btn-outline-primary px-1" type="button" onclick="ListaLPRESG(3)"><i class="fa fa-search"></i></button>
					</div>
				</div> -->

				<div class="col-12 col-lg-6 p-1">
					<label for="mIdProductos"><i class="fa fa-archive" aria-hidden="true"></i> <?php echo lang("Productos"); ?></label>
					<select id="mIdProductos" name="mIdProductos[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$query = "SELECT CodIdBasico,CodIdAmpliado,CodBarra,Descripcion FROM PosUpProducto a where a.EsCompuesto=0 and a.IdCompany = " . $_POST["Company"] . "";
						if ($result = mysqli_query($conn, $query)) {
							while ($row = mysqli_fetch_assoc($result)) {

						?>
								<option value="<?php echo trim($row['CodIdBasico']); ?>"><?php echo trim($row['Descripcion']); ?></option>
						<?

							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>
				<script>
					$(document).ready(function() {
						$("#mIdAlmacen").select2({
							dropdownParent: $("#apps-modalz"),
						});
						$("#mIdProductos").select2({
							dropdownParent: $("#apps-modalz"),
						});
					});
				</script>
			</div>

			<div class="row p-1">
				<div class="col-6 col-md-4">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="ProductosInvG" id="ProductosInvG">
						<label class="form-check-label" for="ProductosInvG">
							<?php echo lang('Productos Con Inventario'); ?>
						</label>
					</div>
				</div>

				<div class="col-6 col-md-4">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="ProductosMovG" id="ProductosMovG">
						<label class="form-check-label" for="ProductosMovG">
							<?php echo lang('Productos con Movimiento'); ?>
						</label>
					</div>
				</div>

				<div class="col-6 col-md-4">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="SerialesG" id="SerialesG">
						<label class="form-check-label" for="SerialesG">
							<?php echo lang('Seriales'); ?>
						</label>
					</div>
				</div>
			</div>

		</div>
		<!--- Movimiento Fiscal  -->
		<div class="modal-footer" style="width: 100%;">
  		  <div class="row input-group w-100 m-0">
  		      <div class="col-3 text-center p-1">
 		           <button class="btn btn-outline-danger w-100" type="reset" id="limpiar">
 		               <i class="fa fa-trash"></i> <?php echo lang('Limpiar'); ?>
		            </button>
 		       </div>
 		       <div class="col-3 text-center p-1">
 		           <button class="btn btn-outline-primary w-100" type="button" onclick="var f = this.closest('form'); f.action='fiscal.php'; f.target='_blank'; f.submit();">
 		               <i class="fa fa-print"></i> <?php echo lang('Preliminar'); ?>
 		           </button>
 		       </div>
 		       <div class="col-3 text-center p-1">
 		           <button class="btn btn-danger w-100" type="button" onclick="var f = this.closest('form'); f.action='reporte_fiscal_pdf.php'; f.target='_blank'; f.submit();">
 		               <i class="fa fa-file-pdf-o"></i> PDF
 		           </button>
 		       </div>
 		       <div class="col-3 text-center p-1">
 		           <button class="btn btn-outline-secondary w-100" type="button" data-bs-dismiss="modal">
 		               <i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?>
 		           </button>
 		       </div>
 		   </div>
		</div>
	</form>
	<script>
		var fecha = new Date();
		var mes = fecha.getMonth() + 1;
		var dia = fecha.getDate();
		var ano = fecha.getFullYear();
		if (dia < 10)
			dia = '0' + dia;
		if (mes < 10)
			mes = '0' + mes
		document.getElementById('DesdeFechaG').value = ano + "-" + mes + "-" + dia;
		document.getElementById('FechaHastaG').value = ano + "-" + mes + "-" + dia;
	</script>
<?php
}

if ($_POST["Accion"] === "13") {
?>
	<div class="modal-header">
		<h5 class="modal-title"><img src="/img/informez.png" alt="informe" height="24px" width="24px"> <?php echo lang('Producción por Almacén de Venta'); ?></h5>
		<button class="btn-close" type="button" data-bs-dismiss="modal"></button>
	</div>
	<form id="ListaPrecio" method="POST" target="_Blank" action="ordenproduccion.php" onsubmit="return false">
		<div class="modal-body">
			<input type="hidden" name="fectx5" id="fectx5" />

			<input type="hidden" name="CompanyActual" value="<?php echo $_POST['Company']; ?>" />
			<input type="hidden" name="IdCompanyGrp" value="<?php echo $_POST['IdCompanyGrp']; ?>" />
			<input type="hidden" name="CIdPlan" value="<?php echo $_POST['CIdPlan']; ?>" />
			<input type="hidden" name="SimMil" value="<?php echo $_POST['SimMil']; ?>" />
			<input type="hidden" name="SimDec" value="<?php echo $_POST['SimDec']; ?>" />
			<input type="hidden" name="CD" value="<?php echo $_POST['CD']; ?>" />
			<input type="hidden" name="direccion" value="<?php echo $_POST['direccion']; ?>" />
			<input type="hidden" name="NameCompany" value="<?php echo $_POST['NameCompany']; ?>" />
			<input type="hidden" name="sucursal" value="<?php echo $_POST['sucursal']; ?>" />

			<div class="row p-1">

				<div class="col-12  p-1 <?php echo $notemp; ?>">
					<div class="col">
						<div class="form-floating">
							<select id='IdCompanySelect' name='IdCompanySelect' onchange='selectidcomp(document.getElementById("IdCompanySelect").value);  changeinput("1","","","","familiaM[]"); changeinput("1","","almacenM[]");' class="form-select <?php echo $notemprise; ?>" aria-label="Default select example">
								<?php
								$conn = conectar();

								$query = "SELECT '" . $_POST["IdCompanyGrp"] . "' as ID, ' [" . lang('Todas') . "]' as Empresa  union  SELECT Id as ID, comercio as Empresa FROM PosUpCompany where Id in ( " . $_POST["IdCompanyGrp"] . ")  order by Empresa ";
								//echo $query;
								if ($result = mysqli_query($conn, $query)) {
									$n = 0;
									/* obtener array asociativo */
									while ($row = mysqli_fetch_assoc($result)) {
								?><option value="<?php echo trim($row['ID']); ?>" <?php if (trim($row['ID']) == trim($_POST['emprise'])) {
																						echo "selected";
																					}; ?>><?php echo trim($row['Empresa']); ?></option><?
																																	}

																																	mysqli_free_result($result);
																																}
																																		?>
							</select>
							<label><i class="fa fa-sorttt"></i> <?php echo lang('Empresa'); ?></label>
						</div>
					</div>
				</div>

				<div class="col-12 col-lg-6 p-1">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<div class="input-daterange input-group" style='display:none' data-date-format="dd/mm/yyyy"></div>
								<input class="form-control " type="date" id="fechM" name="fechM">
								<label><i class="fa fa-calendar"></i> <?php echo lang('Desde la Fecha'); ?></label>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<div class="input-daterange input-group" style='display:none' data-date-format="dd/mm/yyyy"></div>
								<input class="form-control " type="date" id="fechM2" name="fechM2">
								<label><i class="fa fa-calendar"></i> <?php echo lang('Hasta la Fecha'); ?></label>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1">
					<label for="mIdAlmacen"><?php echo lang('Almacén'); ?></label>
					<select id="mIdAlmacen" name="mIdAlmacen[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						if ($_POST['sucursal'] == '0') {
							$sql = "SELECT a.*,b.Nombre as UBicacion FROM PosUpAlmacen a inner join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi WHERE a.IdCompany = " . $_POST["Company"] . " ";
						} else {
							$sql = "SELECT a.*,b.Nombre as UBicacion FROM PosUpAlmacen a inner join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi WHERE a.IdCompany = " . $_POST["Company"] . " and b.IdUbi=" . $_POST['sucursal'];
						}
						if ($result = mysqli_query($conn, $sql)) {
							while ($row = mysqli_fetch_assoc($result)) {
						?>
								<option value="<?php echo trim($row['IdAlm']); ?>"><?php echo trim($row['Nombre']); ?></option>
						<?
							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>

				<div class="col-12 col-lg-6 p-1">
					<label for="mIdfamilia"><?php echo lang("Familia"); ?></label>
					<select id="mIdfamilia" name="mIdfamilia[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$query = "SELECT a.IdVarios,if(a.IdVariosPadre=0,a.ITEM,concat(b.ITEM,' > ', a.ITEM)) AS ITEM FROM PosUpvarios a left join PosUpvarios b on a.IdCompany=b.IdCompany and a.IdVariosPadre = b.IdVarios and a.TIPOITEM = b.TIPOITEM and b.TIPOITEM = 2 WHERE a.IdCompany=" . $_POST["Company"] . " and a.TIPOITEM = 2 order by if(a.IdVariosPadre=0,a.ITEM,concat(b.ITEM,' > ', a.ITEM)) asc";
						//echo $query;
						if ($result = mysqli_query($conn, $query)) {
							while ($row = mysqli_fetch_assoc($result)) {

						?>
								<option value="<?php echo trim($row['IdVarios']); ?>"><?php echo trim($row['ITEM']); ?></option>
						<?

							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>


				<div class="col-12 col-lg-6 p-1">
					<label for="mIdProductos"><i class="fa fa-archive" aria-hidden="true"></i> <?php echo lang("Productos"); ?></label>
					<select id="mIdProductos" name="mIdProductos[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$query = "SELECT CodIdBasico,CodIdAmpliado,CodBarra,Descripcion FROM PosUpProducto a where a.EsCompuesto=0 and a.IdCompany = " . $_POST["Company"] . "";
						if ($result = mysqli_query($conn, $query)) {
							while ($row = mysqli_fetch_assoc($result)) {

						?>
								<option value="<?php echo trim($row['CodIdBasico']); ?>"><?php echo trim($row['Descripcion']); ?></option>
						<?

							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>

				<div class="col-12 col-lg-6 p-1">
					<label for="mIdMarca"><?php echo lang('Marca'); ?></label>
					<select id="mIdMarca" name="mIdMarca[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$sql = "SELECT idmarca,nombre FROM PosUpc_marcas a where a.IdCompany = " . $_POST["Company"];
						if ($result = mysqli_query($conn, $sql)) {
							while ($row = mysqli_fetch_assoc($result)) {
						?>
								<option value="<?php echo trim($row['idmarca']); ?>"><?php echo trim($row['nombre']); ?></option>
						<?
							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>
				<!-- <div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating" id="almaceninput">
								<select class="form-select" id="almacenM[]" name="almacenM[]" style="height:100px" multiple>
									<?php
									if ($_POST['sucursal'] == 0) {
										$query3224 = "Select a.IdAlm,a.Nombre from PosUpAlmacen a left join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi where  a.IdCompany=" . $_POST['Company'];
										if ($result3224 = mysqli_query($conn, $query3224)) {
											while ($row3224 = mysqli_fetch_assoc($result3224)) {
									?><option value="<?php echo $row3224["IdAlm"]; ?> "><?php echo $row3224["Nombre"] ?></option> <?php
																																}
																																mysqli_free_result($result3224);
																															}
																														} else {
																															$query3224 = "Select a.IdAlm,a.Nombre from PosUpAlmacen a left join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi where a.IdUbi=" . $_POST['sucursal'] . " and a.IdCompany=" . $_POST['Company'];
																															if ($result3224 = mysqli_query($conn, $query3224)) {
																																while ($row3224 = mysqli_fetch_assoc($result3224)) {
																																	?><option value="<?php echo $row3224["IdAlm"]; ?> "><?php echo $row3224["Nombre"] ?></option> <?php
																																																								}
																																																								mysqli_free_result($result3224);
																																																							}
																																																						}
																																																									?>
								</select>
								<label><i class="fa fa-archive"></i> <?php echo lang('Almacén'); ?></label>
							</div>
						</div>
					</div>
				</div> -->
				<!-- <div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating" id="familiainput">
								<select class="form-select" id="familiaM[]" name="familiaM[]" style="height:100px" multiple>
									<?php
									$query3224 = "SELECT * FROM PosUpvarios a where a.TIPOITEM=2 AND a.IdCompany=" . $_POST["Company"] . " Order by a.ITEM ";
									if ($result3224 = mysqli_query($conn, $query3224)) {
										while ($row3224 = mysqli_fetch_assoc($result3224)) {
									?><option value="<?php echo $row3224["IdVarios"]; ?> "><?php echo $row3224["ITEM"] ?></option> <?php
																																}
																																mysqli_free_result($result3224);
																															}
																																	?>
								</select>
								<label><i class="fa fa-th-large"></i> <?php echo lang('Familia'); ?></label>
							</div>
						</div>
					</div>
				</div> -->
				<!-- <div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="productoinv" name="productoinv" onchange="CodigoDesLPRESG('productoinv','productoinv2');" />
								<label><i class="fa fa-archive"></i> <?php echo lang('Producto'); ?></label>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="productoinv2" name="productoinv2" readonly />
							</div>
						</div>
						<button class="btn btn-outline-primary px-1" type="button" onclick="ListaLPRESGXQ(1)"><i class="fa fa-search"></i></button>
					</div>
				</div> -->
				<!-- <div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="marcainv" name="marcainv" onchange="Mar('marcainv','marcainv2');" />
								<label><i class="fa fa-tags"></i> <?php echo lang('Marca'); ?></label>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1  <?php echo $notfil; ?> nfilt">
					<div class="input-group">
						<div class="col">
							<div class="form-floating">
								<input class="form-control filt" type="text" id="marcainv2" name="marcainv2" readonly />
							</div>
						</div>
						<button class="btn btn-outline-primary px-1" type="button" onclick="ListaLPRESGXQ(2)"><i class="fa fa-search"></i></button>
					</div>
				</div> -->
			</div>

			<div class="row p-1">
				<div class="col-6 col-md-4">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="ProductosInvG" id="ProductosInvG">
						<label class="form-check-label" for="ProductosInvG">
							<?php echo lang('Productos Con Inventario'); ?>
						</label>
					</div>
				</div>

				<div class="col-6 col-md-4">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="ProductosMovG" id="ProductosMovG">
						<label class="form-check-label" for="ProductosMovG">
							<?php echo lang('Productos con Movimiento'); ?>
						</label>
					</div>
				</div>

				<div class="col-6 col-md-4">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="SerialesG" id="SerialesG">
						<label class="form-check-label" for="SerialesG">
							<?php echo lang('Seriales'); ?>
						</label>
					</div>
				</div>
			</div>
			<script>
				$(document).ready(function() {
					$("#mIdAlmacen").select2({
						dropdownParent: $("#apps-modalz"),
					});
					$("#mIdProductos").select2({
						dropdownParent: $("#apps-modalz"),
					});
					$("#mIdMarca").select2({
						dropdownParent: $("#apps-modalz"),
					});
					$("#mIdfamilia").select2({
						dropdownParent: $("#apps-modalz"),
					});
				});
			</script>
		</div>
		<!-- Producción por Almacén de Venta -->
		<!-- Producción por Almacén de Venta -->
		<div class="modal-footer" style="width: 100%;">
    		<div class="row input-group w-100 m-0">
    		    <div class="col-3 text-center p-1">
    		        <button class="btn btn-outline-danger w-100" type="reset" id="limpiar">
    		            <i class="fa fa-trash"></i> <?php echo lang('Limpiar'); ?>
    		        </button>
    		   </div>
     		   <div class="col-3 text-center p-1">
     		       <button class="btn btn-outline-primary w-100" type="button" onclick="var f = this.closest('form'); f.action='ordenproduccion.php'; f.target='_blank'; f.submit();">
    		            <i class="fa fa-print"></i> <?php echo lang('Preliminar'); ?>
     		       </button>
    		   </div>
    		    <div class="col-3 text-center p-1">
    		        <button class="btn btn-danger w-100" type="button" onclick="var f = this.closest('form'); f.action='reporte_produccion_pdf.php'; f.target='_blank'; f.submit();">
    		            <i class="fa fa-file-pdf-o"></i> PDF
    		        </button>
     		   </div>
    		    <div class="col-3 text-center p-1">
   		         <button class="btn btn-outline-secondary w-100" type="button" data-bs-dismiss="modal">
   		             <i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?>
    		        </button>
    		    </div>
    		</div>
		</div>
	</form>
	<script>
		var fecha = new Date();
		var mes = fecha.getMonth() + 1;
		var dia = fecha.getDate();
		var ano = fecha.getFullYear();
		if (dia < 10)
			dia = '0' + dia;
		if (mes < 10)
			mes = '0' + mes
		document.getElementById('fechM').value = ano + "-" + mes + "-" + dia;
		document.getElementById('fechM2').value = ano + "-" + mes + "-" + dia;
	</script>

<?php
}



if ($_POST["Accion"] === "15") {

	$sql = "SELECT LitP01,LitP02,LitP03,LitP04,LitP05,LitP06,LitP07,LitP08,LitP09,LitP10,LitCosto,MonedaS,FactorDolarCash,MonedaP,FactorDolarPaypal,Moneda3,FactorDolarZelle,Moneda4,FactorDolar5,Moneda5,FactorDolar6,Moneda6,FactorDolar7,Moneda7 FROM PosUpCompany 
	where Id=" . $_POST["Company"] . "";
	if ($result = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$LitP01 = $row["LitP01"];
			$LitP02 = $row["LitP02"];
			$LitP03 = $row["LitP03"];
			$LitP04 = $row["LitP04"];
			$LitP05 = $row["LitP05"];
			$LitP06 = $row["LitP06"];
			$LitP07 = $row["LitP07"];
			$LitP08 = $row["LitP08"];
			$LitP09 = $row["LitP09"];
			$LitP10 = $row["LitP10"];
			$LitCosto = $row["LitCosto"];
			$company = [
				"FactorDolarCash" => $row["FactorDolarCash"],
				"MonedaS" => $row["MonedaS"],
				"FactorDolarPaypal" => $row["FactorDolarPaypal"],
				"Moneda3" => $row["Moneda3"],
				"FactorDolarZelle" => $row["FactorDolarZelle"],
				"Moneda4" => $row["Moneda4"],
				"FactorDolar5" => $row["FactorDolar5"],
				"Moneda5" => $row["Moneda5"],
				"FactorDolar6" => $row["FactorDolar6"],
				"Moneda6" => $row["Moneda6"],
				"FactorDolar7" => $row["FactorDolar7"],
				"Moneda7" => $row["Moneda7"],
				"MonedaP" => $row["MonedaP"],
			];
		}
	}

	if ($_POST["Company"] === "1167") {

		$tasa = floatval($company["FactorDolarZelle"]);
		$moneda = $company["Moneda4"];
	} else if ($_POST["Company"] === "1168") {
		$tasa = floatval($company["FactorDolarPaypal"]);
		$moneda = $company["Moneda3"];
	} else if ($_POST["Company"] === "1174") {

		$tasa = floatval($company["FactorDolar7"]);
		$moneda = $company["Moneda7"];
	} else if ($_POST["Company"] === "1181") {

		$tasa = floatval($company["FactorDolarPaypal"]);
		$moneda = $company["Moneda3"];
	}

?>
	<div class="modal-header">
		<h5 class="modal-title"><img src="/img/informez.png" alt="informe" height="24px" width="24px"> <?php echo lang('Lista de Precios'); ?> 2</h5>
		<button class="btn-close" type="button" data-bs-dismiss="modal"></button>
	</div>
	<form id="ListaPrecio" method="POST" target="_Blank" action="mercanciaLP_1167.php" onsubmit="return false">
		<div class="modal-body">
			<input type="hidden" name="fectx5" id="fectx5" />

			<input type="hidden" name="CompanyActual" value="<?php echo $_POST['Company']; ?>" />
			<input type="hidden" name="IdCompanyGrp" value="<?php echo $_POST['IdCompanyGrp']; ?>" />
			<input type="hidden" name="CIdPlan" value="<?php echo $_POST['CIdPlan']; ?>" />
			<input type="hidden" name="SimMil" value="<?php echo $_POST['SimMil']; ?>" />
			<input type="hidden" name="SimDec" value="<?php echo $_POST['SimDec']; ?>" />
			<input type="hidden" name="CD" value="<?php echo $_POST['CD']; ?>" />
			<input type="hidden" name="direccion" value="<?php echo $_POST['direccion']; ?>" />
			<input type="hidden" name="NameCompany" value="<?php echo $_POST['NameCompany']; ?>" />
			<input type="hidden" name="sucursal" value="<?php echo $_POST['sucursal']; ?>" />
			<span style="display:none" id="devueltachavalesLP"></span>
			<span style="display:none" id="CodigoDesaLLP"></span>
			<span style="display:none" id="CodigoHasaLLP"></span>
			<span style="display:none" id="BenefeLLP"></span>
			<span style="display:none" id="AlmaLLP"></span>
			<span style="display:none" id="MarLLP"></span>


			<div class="row p-1">
				<div class="col-12  p-1 <?php echo $notemp; ?>">
					<div class="col">
						<div class="form-floating">
							<select id='IdCompanySelect' name='IdCompanySelect' onchange='selectidcomp(document.getElementById("IdCompanySelect").value);' class="form-select <?php echo $notemprise; ?>" aria-label="Default select example">
								<?php
								$conn = conectar();

								$query = "SELECT '" . $_POST["IdCompanyGrp"] . "' as ID, ' [" . lang('Todas') . "]' as Empresa  union  SELECT Id as ID, comercio as Empresa FROM PosUpCompany where Id in ( " . $_POST["IdCompanyGrp"] . ")  order by Empresa ";
								//echo $query;
								if ($result = mysqli_query($conn, $query)) {
									$n = 0;
									/* obtener array asociativo */
									while ($row = mysqli_fetch_assoc($result)) {
								?><option value="<?php echo trim($row['ID']); ?>" <?php if (trim($row['ID']) == trim($_POST['emprise'])) {
																						echo "selected";
																					}; ?>><?php echo trim($row['Empresa']); ?></option><?
																																	}

																																	mysqli_free_result($result);
																																}
																																		?>
							</select>
							<label><i class="fa fa-sorttt"></i> <?php echo lang('Empresa'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<div class="col">
						<div class="form-floating">
							<select class="form-select" name="EnvioEstado" id="EnvioEstado">
								<option value="*"><?php echo lang("Todos"); ?></option>
								<option value="1"><?php echo lang("Activo"); ?></option>
								<option value="0"><?php echo lang("Inactivo"); ?></option>
							</select>
							<label><i class="fa fa-hourglass" aria-hidden="true"></i>&nbsp;<?php echo lang('Estado'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<div class="form-floating">
						<select name="SelectTasa" id="SelectTasa" class="form-select">
							<?php
							$MonedaP = "";
							$MonedaS = "";
							$GenTxFactorDCambio = "";
							$query = "SELECT FactorDolarCash,FactorDolarPaypal,FactorDolarZelle,Moneda3,Moneda4,MonedaP,MonedaS,MonedaP,LitPrincipalEfectivo,Moneda5,Moneda6,Moneda7,FactorDolar5,FactorDolar6,FactorDolar7 FROM PosUpCompany WHERE Id=" . $_POST['Company'] . "";
							if ($result = mysqli_query($conn, $query)) {
								while ($row = mysqli_fetch_assoc($result)) {
									$MonedaP = $row["MonedaP"];
									$MonedaS =  ($row["LitPrincipalEfectivo"] === "" ? $row['MonedaS'] : $row["LitPrincipalEfectivo"]);
									// $GenTxFactorDCambio .= "<option value='1' >" . $row['MonedaP'] . "</option>";
									if ($row['FactorDolarCash'] > 1) $GenTxFactorDCambio .= "<option value='2' >" . ($row["LitPrincipalEfectivo"] === "" ? $row['MonedaS'] : $row["LitPrincipalEfectivo"])  . "</option>";
									if ($row['FactorDolarPaypal'] > 1) $GenTxFactorDCambio .= "<option value='3' >" . $row['Moneda3'] . "</option>";
									if ($row['FactorDolarZelle'] > 1) $GenTxFactorDCambio .= "<option value='4' >" . $row['Moneda4'] . "</option>";
									if ($row['FactorDolar5'] > 1) $GenTxFactorDCambio .= "<option value='5' >" . $row['Moneda5'] . "</option>";
									if ($row['FactorDolar6'] > 1) $GenTxFactorDCambio .= "<option value='6' >" . $row['Moneda6'] . "</option>";
									if ($row['FactorDolar7'] > 1) $GenTxFactorDCambio .= "<option value='7' >" . $row['Moneda7'] . "</option>";
								}
								mysqli_free_result($result);
							}
							echo $GenTxFactorDCambio;
							?>
						</select>
						<label><i class="fa fa-money" aria-hidden="true"></i>&nbsp;<?php echo lang('Tasa') ?></label>
					</div>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<div class="col">
						<div class="form-floating">
							<input class="form-control text-end" type="number" name="TasaBCV" value="<?php echo $tasa; ?>">
							<label><i class="fa fa-money" aria-hidden="true"></i>&nbsp;<?php echo lang('BCV'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1">
					<div class="form-floating">
						<select name="SelectPrecio" id="SelectPrecio" class="form-select">

							<option value="">
								<?php echo (trim($LitP01) !== "" ? $LitP01 : lang("Precio") . " 1"); ?>
							</option>
							<option value="2">
								<?php echo (trim($LitP02) !== "" ? $LitP02 : lang("Precio") . " 2"); ?>
							</option>
							<option value="3">
								<?php echo (trim($LitP03) !== "" ? $LitP03 : lang("Precio") . " 3"); ?>
							</option>
							<option value="4">
								<?php echo (trim($LitP04) !== "" ? $LitP04 : lang("Precio") . " 4"); ?>
							</option>
							<option value="5">
								<?php echo (trim($LitP05) !== "" ? $LitP05 : lang("Precio") . " 5"); ?>
							</option>
							<option value="6">
								<?php echo (trim($LitP06) !== "" ? $LitP06 : lang("Precio") . " 6"); ?>
							</option>
							<option value="7">
								<?php echo (trim($LitP07) !== "" ? $LitP07 : lang("Precio") . " 7"); ?>
							</option>
							<option value="8">
								<?php echo (trim($LitP08) !== "" ? $LitP08 : lang("Precio") . " 8"); ?>
							</option>
							<option value="9">
								<?php echo (trim($LitP09) !== "" ? $LitP09 : lang("Precio") . " 9"); ?>
							</option>
							<option value="10">
								<?php echo (trim($LitP10) !== "" ? $LitP10 : lang("Precio") . " 10"); ?>
							</option>
						</select>
						<label><i class="fa fa-money" aria-hidden="true"></i>&nbsp;<?php echo lang('Precio') ?></label>
					</div>
				</div>

				<div class="col-12 col-lg-6 p-1">
					<div class="col">
						<div class="form-floating">
							<select class="form-select" id="Agrupar" name="Agrupar">
								<option value="Familiazp"><?php echo lang('Familia'); ?></option>
								<option value="Marcazp"><?php echo lang('Marca'); ?></option>
								<option value="FamiliaMarca"><?php echo lang('Familia y marca'); ?></option>
							</select>
							<label><i class="fa fa-object-group"></i> <?php echo lang('Agrupamiento'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<label class='d-flex gap-2 align-items-center'>
						<?php echo lang('Familia'); ?>
						<div class='form-check'>
							<input class='form-check-input' type='checkbox' name='NotIncludeFamilia'>
							<label class='form-check-label'><?php echo lang('No Incluir'); ?></label>
						</div>
					</label>
					<select id="mIdfamilia" name="mIdfamilia[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$query = "SELECT a.IdVarios,if(a.IdVariosPadre=0,a.ITEM,concat(b.ITEM,' > ', a.ITEM)) AS ITEM FROM PosUpvarios a left join PosUpvarios b on a.IdCompany=b.IdCompany and a.IdVariosPadre = b.IdVarios and a.TIPOITEM = b.TIPOITEM and b.TIPOITEM = 2 WHERE a.IdCompany=" . $_POST["Company"] . " and a.TIPOITEM = 2 order by if(a.IdVariosPadre=0,a.ITEM,concat(b.ITEM,' > ', a.ITEM)) asc";
						//echo $query;
						if ($result = mysqli_query($conn, $query)) {
							while ($row = mysqli_fetch_assoc($result)) {

						?>
								<option value="<?php echo trim($row['IdVarios']); ?>"><?php echo trim($row['ITEM']); ?></option>
						<?

							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<label class='d-flex gap-2 align-items-center'>
						<?php echo lang('Marca'); ?>
						<div class='form-check'>
							<input class='form-check-input' type='checkbox' name='NotIncludeMarca'>
							<label class='form-check-label'><?php echo lang('No Incluir'); ?></label>
						</div>
					</label>
					<select id="mIdMarca" name="mIdMarca[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$sql = "SELECT idmarca,nombre FROM PosUpc_marcas a where a.IdCompany = " . $_POST["Company"];
						if ($result = mysqli_query($conn, $sql)) {
							while ($row = mysqli_fetch_assoc($result)) {
						?>
								<option value="<?php echo trim($row['idmarca']); ?>"><?php echo trim($row['nombre']); ?></option>
						<?
							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>

				<div class="col-12 col-lg-4 p-1">
					<label class='d-flex gap-2 align-items-center'>
						<?php echo lang('Productos'); ?>
						<div class='form-check'>
							<input class='form-check-input' type='checkbox' name='NotIncludeProductos'>
							<label class='form-check-label'><?php echo lang('No Incluir'); ?></label>
						</div>
					</label>
					<select id="mIdProductos" name="mIdProductos[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$query = "SELECT CodIdBasico,CodIdAmpliado,CodBarra,Descripcion FROM PosUpProducto a where  a.IdCompany = " . $_POST["Company"] . " and a.EsCompuesto in (20,1,0)";
						if ($result = mysqli_query($conn, $query)) {
							while ($row = mysqli_fetch_assoc($result)) {

						?>
								<option value="<?php echo trim($row['CodIdBasico']); ?>">(<?php echo $row["CodIdAmpliado"]; ?>) <?php echo trim($row['Descripcion']); ?></option>
						<?

							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<label class='d-flex gap-2 align-items-center'>
						<?php echo lang('Almacén'); ?>
						<div class='form-check'>
							<input class='form-check-input' type='checkbox' name='NotIncludeAlmacen'>
							<label class='form-check-label'><?php echo lang('No Incluir'); ?></label>
						</div>
					</label>
					<select id="mIdAlmacen" name="mIdAlmacen[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						if ($_POST['sucursal'] == '0') {
							$sql = "SELECT a.*  FROM PosUpAlmacen a WHERE a.IdCompany = " . $_POST["Company"] . " ";
						} else {
							$sql = "SELECT a.* FROM PosUpAlmacen a WHERE a.IdCompany = " . $_POST["Company"] . " and a.IdUbi=" . $_POST['sucursal'];
						}
						if ($result = mysqli_query($conn, $sql)) {
							while ($row = mysqli_fetch_assoc($result)) {
						?>
								<option value="<?php echo trim($row['IdAlm']); ?>"><?php echo trim($row['Nombre']); ?></option>
						<?php
							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<label class='d-flex gap-2 align-items-center'>
						<?php echo lang('Ubicación'); ?>
						<div class='form-check'>
							<input class='form-check-input' type='checkbox' name='NotIncludeUbicacion'>
							<label class='form-check-label'><?php echo lang('No Incluir'); ?></label>
						</div>
					</label>
					<select id="ModalUbicaciones" name="ModalUbicaciones[]" style="width:100%" multiple>
						<?php
						$queryUB = " SELECT IdUbi,Nombre FROM PosUpUbicacion WHERE IdCompany=" . $_POST["Company"] . "";
						if ($resultUB = mysqli_query($conn, $queryUB)) {
							while ($rowUB = mysqli_fetch_assoc($resultUB)) {
								$ModalZona2C2 .= "<option value='" . $rowUB['IdUbi'] . "'>" . $rowUB["Nombre"] . "</option>";
							}
							mysqli_free_result($resultUB);
						}
						echo $ModalZona2C2;
						?>
					</select>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<label class='d-flex gap-2 align-items-center'>
						<?php echo lang('Zona Atenciòn'); ?>
						<div class='form-check'>
							<input class='form-check-input' type='checkbox' name='NotIncludeZonaAtencion'>
							<label class='form-check-label'><?php echo lang('No Incluir'); ?></label>
						</div>
					</label>
					<select class='form-select' id='ModalAtencion' name='ModalAtencion[]' style='width:100%' multiple>
						<?php

						$ZonaAtt = "";

						$query = "SELECT IdAtt,Nombre FROM posupzonaatt WHERE IdCompany=" . $_POST["Company"] . " ";
						if ($result = mysqli_query($conn, $query)) {
							while ($row = mysqli_fetch_assoc($result)) {
								$ZonaAtt .= '<option value="' . trim($row['IdAtt']) . '">' . trim($row['Nombre']) . '</option>';
							}
							mysqli_free_result($result);
						}

						echo $ZonaAtt;
						?>
					</select>
				</div>
				<div class="row">
					<?php if ($_POST["userperfil"] <= 2000 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
						<div class="col-6 col-md-4">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="cimp" id="cimp">
								<label class="form-check-label" for="cimp">
									<?php echo lang('Con Impuesto'); ?>
								</label>
							</div>
						</div>
					<?php } ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="redondeadoCheck" id="redondeadoCheck">
							<label class="form-check-label" for="redondeadoCheck">
								<?php echo lang('Redondeado'); ?>
							</label>
						</div>
					</div>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="pricemayor" id="pricemayor">
							<label class="form-check-label" for="pricemayor">
								<?php echo lang('Precios mayor a cero'); ?>
							</label>
						</div>
					</div>

					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="MonedaPrimeriaMostrar" id="MonedaPrimeriaMostrar" checked>
							<label class="form-check-label" for="MonedaPrimeriaMostrar">
								<?php echo lang('Precio') . " " . $MonedaP; ?>
							</label>
						</div>
					</div>

					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="MonedaSecundariaMostrar" id="MonedaSecundariaMostrar" checked>
							<label class="form-check-label" for="MonedaSecundariaMostrar">
								<?php echo lang('Precio') . " " . $MonedaS; ?>
							</label>
						</div>
					</div>
				</div>
				<script>
					$(document).ready(function() {
						$("#mIdProductos").select2({
							dropdownParent: $("#apps-modalz"),
						});
						$("#mIdMarca").select2({
							dropdownParent: $("#apps-modalz"),
						});
						$("#mIdAlmacen").select2({
							dropdownParent: $("#apps-modalz"),
						});
						$("#mIdfamilia").select2({
							dropdownParent: $("#apps-modalz"),
						});
						$("#ModalUbicaciones").select2({
							dropdownParent: $("#apps-modalz"),
						});
						$("#ModalAtencion").select2({
							dropdownParent: $("#apps-modalz"),
						});
					});
				</script>
			</div>

		</div>
<!--Lista de Precios 2 -->
		<div class="row input-group w-100 m-0">
   			 <div class="col-3 text-center p-1">
  			      <button class="btn btn-outline-danger w-100" type="reset" id="limpiar">
  			          <i class="fa fa-trash"></i> <?php echo lang('Limpiar'); ?>
 			       </button>
 			   </div>
 			   <div class="col-3 text-center p-1">
 			       <button class="btn btn-outline-primary w-100" type="button" onclick="var f = this.closest('form'); f.action='mercanciaLP_1167.php'; f.target='_blank'; f.submit();">
 			           <i class="fa fa-print"></i> <?php echo lang('Preliminar'); ?>
 			       </button>
 			   </div>
 			   <div class="col-3 text-center p-1">
 			       <button class="btn btn-danger w-100" type="button" onclick="var f = this.closest('form'); f.action='reporte_listaprecios_avanzado1167_pdf.php'; f.target='_blank'; f.submit();">
 			           <i class="fa fa-file-pdf-o"></i> PDF
 			       </button>
 			   </div>
			   <div class="col text-center p-1">
    				<button class="btn btn-success w-100" type="button" onclick="var f = this.closest('form'); f.action='reporte_listaprecios_avanzado1167_excel.php'; f.target='_self'; f.submit();">
        				<i class="fa fa-file-excel-o"></i> Excel
    				</button>
				</div>
 			   <div class="col-3 text-center p-1">
  			      <button class="btn btn-outline-secondary w-100" type="button" data-bs-dismiss="modal">
    			        <i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?>
    			    </button>
    			</div>
			</div>
	</form>

	<script>
		var fecha = new Date();
		var mes = fecha.getMonth() + 1;
		var dia = fecha.getDate();
		var ano = fecha.getFullYear();
		if (dia < 10) {
			dia = '0' + dia;
		}
		if (mes < 10) {
			mes = '0' + mes;
		}
		document.getElementById('FechaHastalista').value = ano + "-" + mes + "-" + dia;
	</script>
<?php
}


if ($_POST["Accion"] === "16") {
	$sql = "SELECT LitP01,LitP02,LitP03,LitP04,LitP05,LitP06,LitP07,LitP08,LitP09,LitP10,LitCosto FROM PosUpCompany 
	where Id=" . $_POST["Company"] . "";
	if ($result = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$LitP01 = $row["LitP01"];
			$LitP02 = $row["LitP02"];
			$LitP03 = $row["LitP03"];
			$LitP04 = $row["LitP04"];
			$LitP05 = $row["LitP05"];
			$LitP06 = $row["LitP06"];
			$LitP07 = $row["LitP07"];
			$LitP08 = $row["LitP08"];
			$LitP09 = $row["LitP09"];
			$LitP10 = $row["LitP10"];
			$LitCosto = $row["LitCosto"];
		}
	}
?>
	<div class="modal-header">
		<h5 class="modal-title"><img src="/img/informez.png" alt="informe" height="24px" width="24px"> <?php echo lang('Lista de Precios'); ?> 3</h5>
		<button class="btn-close" type="button" data-bs-dismiss="modal"></button>
	</div>
	<form id="ListaPrecio" method="POST" target="_Blank" action="mercanciaLP_1168.php" onsubmit="return false">
		<div class="modal-body">
			<input type="hidden" name="fectx5" id="fectx5" />

			<input type="hidden" name="CompanyActual" value="<?php echo $_POST['Company']; ?>" />
			<input type="hidden" name="IdCompanyGrp" value="<?php echo $_POST['IdCompanyGrp']; ?>" />
			<input type="hidden" name="CIdPlan" value="<?php echo $_POST['CIdPlan']; ?>" />
			<input type="hidden" name="SimMil" value="<?php echo $_POST['SimMil']; ?>" />
			<input type="hidden" name="SimDec" value="<?php echo $_POST['SimDec']; ?>" />
			<input type="hidden" name="CD" value="<?php echo $_POST['CD']; ?>" />
			<input type="hidden" name="direccion" value="<?php echo $_POST['direccion']; ?>" />
			<input type="hidden" name="NameCompany" value="<?php echo $_POST['NameCompany']; ?>" />
			<input type="hidden" name="sucursal" value="<?php echo $_POST['sucursal']; ?>" />
			<span style="display:none" id="devueltachavalesLP"></span>
			<span style="display:none" id="CodigoDesaLLP"></span>
			<span style="display:none" id="CodigoHasaLLP"></span>
			<span style="display:none" id="BenefeLLP"></span>
			<span style="display:none" id="AlmaLLP"></span>
			<span style="display:none" id="MarLLP"></span>


			<div class="row p-1">
				<div class="col-12  p-1 <?php echo $notemp; ?>">
					<div class="col">
						<div class="form-floating">
							<select id='IdCompanySelect' name='IdCompanySelect' onchange='selectidcomp(document.getElementById("IdCompanySelect").value);' class="form-select <?php echo $notemprise; ?>" aria-label="Default select example">
								<?php
								$conn = conectar();

								$query = "SELECT '" . $_POST["IdCompanyGrp"] . "' as ID, ' [" . lang('Todas') . "]' as Empresa  union  SELECT Id as ID, comercio as Empresa FROM PosUpCompany where Id in ( " . $_POST["IdCompanyGrp"] . ")  order by Empresa ";
								//echo $query;
								if ($result = mysqli_query($conn, $query)) {
									$n = 0;
									/* obtener array asociativo */
									while ($row = mysqli_fetch_assoc($result)) {
								?><option value="<?php echo trim($row['ID']); ?>" <?php if (trim($row['ID']) == trim($_POST['emprise'])) {
																						echo "selected";
																					}; ?>><?php echo trim($row['Empresa']); ?></option><?
																																	}

																																	mysqli_free_result($result);
																																}
																																		?>
							</select>
							<label><i class="fa fa-sorttt"></i> <?php echo lang('Empresa'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 p-1">
					<div class="form-floating">
						<select name="SelectTasa" id="SelectTasa" class="form-select">
							<?php

							$GenTxFactorDCambio = "";
							$query = "SELECT FactorDolarCash,FactorDolarPaypal,FactorDolarZelle,Moneda3,Moneda4,MonedaP,MonedaS,MonedaP,LitPrincipalEfectivo,Moneda5,Moneda6,Moneda7,FactorDolar5,FactorDolar6,FactorDolar7 FROM PosUpCompany WHERE Id=" . $_POST['Company'] . "";
							if ($result = mysqli_query($conn, $query)) {
								while ($row = mysqli_fetch_assoc($result)) {
									$GenTxFactorDCambio .= "<option value='1' >" . $row['MonedaP'] . "</option>";
									if ($row['FactorDolarCash'] > 1) $GenTxFactorDCambio .= "<option value='2' >" . ($row["LitPrincipalEfectivo"] === "" ? $row['MonedaS'] : $row["LitPrincipalEfectivo"])  . "</option>";
									if ($row['FactorDolarPaypal'] > 1) $GenTxFactorDCambio .= "<option value='3' >" . $row['Moneda3'] . "</option>";
									if ($row['FactorDolarZelle'] > 1) $GenTxFactorDCambio .= "<option value='4' >" . $row['Moneda4'] . "</option>";
									if ($row['FactorDolar5'] > 1) $GenTxFactorDCambio .= "<option value='5' >" . $row['Moneda5'] . "</option>";
									if ($row['FactorDolar6'] > 1) $GenTxFactorDCambio .= "<option value='6' >" . $row['Moneda6'] . "</option>";
									if ($row['FactorDolar7'] > 1) $GenTxFactorDCambio .= "<option value='7' >" . $row['Moneda7'] . "</option>";
								}
								mysqli_free_result($result);
							}
							echo $GenTxFactorDCambio;
							?>
						</select>
						<label><i class="fa fa-money" aria-hidden="true"></i>&nbsp;<?php echo lang('Tasa') ?></label>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1">
					<div class="col">
						<div class="form-floating">
							<select class="form-select" id="OrdenLP" name="OrdenLP">
								<option value="Codigo"><?php echo lang('Código'); ?></option>
								<option value="Descripcion"><?php echo lang('Descripción'); ?></option>
								<option value="Instancia"><?php echo lang('Familia'); ?></option>
								<option value="PrecioNeto"><?php echo lang('Precio'); ?></option>
								<option value="Marca"><?php echo lang('Marca'); ?></option>
							</select>
							<label><i class="fa fa-sort"></i> <?php echo lang('Orden'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1">
					<div class="col">
						<div class="form-floating">
							<div class="input-daterange input-group" style='display:none' data-date-format="dd/mm/yyyy"></div>
							<input class="form-control" type="date" id="FechaHastalista" name="FechaHastalista">
							<label><i class="fa fa-calendar"></i> <?php echo lang('Hasta la Fecha'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1">
					<div class="col">
						<div class="form-floating">
							<select class="form-select" id="Agrupar" name="Agrupar">
								<option value="empty"><?php echo lang('Ninguno'); ?></option>
								<option value="Familiazp"><?php echo lang('Familia'); ?></option>
								<option value="Marcazp"><?php echo lang('Marca'); ?></option>
								<option value="FamiliaMarca"><?php echo lang('Familia y marca'); ?></option>
							</select>
							<label><i class="fa fa-object-group"></i> <?php echo lang('Agrupamiento'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1">
					<div class="col">
						<div class="form-floating">
							<select class="form-select" name="EnvioEstado" id="EnvioEstado">
								<option value="*"><?php echo lang("Todos"); ?></option>
								<option value="1"><?php echo lang("Activo"); ?></option>
								<option value="0"><?php echo lang("Inactivo"); ?></option>
							</select>
							<label><i class="fa fa-hourglass" aria-hidden="true"></i>&nbsp;<?php echo lang('Estado'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<label class='d-flex gap-2 align-items-center'>
						<?php echo lang("Familia"); ?>
						<div class='form-check'>
							<input class='form-check-input' type='checkbox' name='NotIncludeFamilia'>
							<label class='form-check-label'><?php echo lang('No Incluir'); ?></label>
						</div>
					</label>
					<select id="mIdfamilia" name="mIdfamilia[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$query = "SELECT a.IdVarios,if(a.IdVariosPadre=0,a.ITEM,concat(b.ITEM,' > ', a.ITEM)) AS ITEM FROM PosUpvarios a left join PosUpvarios b on a.IdCompany=b.IdCompany and a.IdVariosPadre = b.IdVarios and a.TIPOITEM = b.TIPOITEM and b.TIPOITEM = 2 WHERE a.IdCompany=" . $_POST["Company"] . " and a.TIPOITEM = 2 order by if(a.IdVariosPadre=0,a.ITEM,concat(b.ITEM,' > ', a.ITEM)) asc";
						//echo $query;
						if ($result = mysqli_query($conn, $query)) {
							while ($row = mysqli_fetch_assoc($result)) {

						?>
								<option value="<?php echo trim($row['IdVarios']); ?>"><?php echo trim($row['ITEM']); ?></option>
						<?

							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<label class='d-flex gap-2 align-items-center'>
						<?php echo lang('Marca'); ?>
						<div class='form-check'>
							<input class='form-check-input' type='checkbox' name='NotIncludeMarca'>
							<label class='form-check-label'><?php echo lang('No Incluir'); ?></label>
						</div>
					</label>
					<select id="mIdMarca" name="mIdMarca[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$sql = "SELECT idmarca,nombre FROM PosUpc_marcas a where a.IdCompany = " . $_POST["Company"];
						if ($result = mysqli_query($conn, $sql)) {
							while ($row = mysqli_fetch_assoc($result)) {
						?>
								<option value="<?php echo trim($row['idmarca']); ?>"><?php echo trim($row['nombre']); ?></option>
						<?
							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<label class='d-flex gap-2 align-items-center'>
						<?php echo lang('Almacén'); ?>
						<div class='form-check'>
							<input class='form-check-input' type='checkbox' name='NotIncludeAlmacen'>
							<label class='form-check-label'><?php echo lang('No Incluir'); ?></label>
						</div>
					</label>
					<select id="mIdAlmacen" name="mIdAlmacen[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						if ($_POST['sucursal'] == '0') {
							$sql = "SELECT a.*,b.Nombre as UBicacion FROM PosUpAlmacen a inner join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi WHERE a.IdCompany = " . $_POST["Company"] . " ";
						} else {
							$sql = "SELECT a.*,b.Nombre as UBicacion FROM PosUpAlmacen a inner join PosUpUbicacion b on a.IdCompany=b.IdCompany and a.IdUbi=b.IdUbi WHERE a.IdCompany = " . $_POST["Company"] . " and b.IdUbi=" . $_POST['sucursal'];
						}
						if ($result = mysqli_query($conn, $sql)) {
							while ($row = mysqli_fetch_assoc($result)) {
						?>
								<option value="<?php echo trim($row['IdAlm']); ?>"><?php echo trim($row['Nombre']); ?></option>
						<?
							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>

				<div class="col-12 p-1">
					<label class='d-flex gap-2 align-items-center'>
						<i class="fa fa-archive" aria-hidden="true"></i> <?php echo lang("Productos"); ?>
						<div class='form-check'>
							<input class='form-check-input' type='checkbox' name='NotIncludeProductos'>
							<label class='form-check-label'><?php echo lang('No Incluir'); ?></label>
						</div>
					</label>
					<select id="mIdProductos" name="mIdProductos[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$query = "SELECT CodIdBasico,CodIdAmpliado,CodBarra,Descripcion FROM PosUpProducto a where  a.IdCompany = " . $_POST["Company"] . " and a.EsCompuesto in (20,1,0)";
						if ($result = mysqli_query($conn, $query)) {
							while ($row = mysqli_fetch_assoc($result)) {

						?>
								<option value="<?php echo trim($row['CodIdBasico']); ?>">(<?php echo $row["CodIdAmpliado"]; ?>) <?php echo trim($row['Descripcion']); ?></option>
						<?

							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>
				<script>
					$(document).ready(function() {
						$("#mIdProductos").select2({
							dropdownParent: $("#apps-modalz"),
						});
						$("#mIdMarca").select2({
							dropdownParent: $("#apps-modalz"),
						});
						$("#mIdAlmacen").select2({
							dropdownParent: $("#apps-modalz"),
						});
						$("#mIdfamilia").select2({
							dropdownParent: $("#apps-modalz"),
						});
					});
				</script>

			</div>

			<div class="row p-1">
				<?php if ($_POST["userperfil"] <= 2000 or $c0 == 1 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="costozzzv" id="costozzzv">
							<label class="form-check-label" for="costozzzv">
								<?php echo (trim($LitCosto) !== "" ? $LitCosto : lang("Costo")); ?>
							</label>
						</div>
					</div>
				<?php } ?>
				<?php if ($_POST["userperfil"] <= 2000 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="Existencia" id="Existencia">
							<label class="form-check-label" for="Existencia">
								<?php echo lang('Mostrar Existencia'); ?>
							</label>
						</div>
					</div>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="cimp" id="cimp">
							<label class="form-check-label" for="cimp">
								<?php echo lang('Con Impuesto'); ?>
							</label>
						</div>
					</div>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="ExistenciaCero" id="ExistenciaCero">
							<label class="form-check-label" for="ExistenciaCero">
								<?php echo lang('Existencia Cero'); ?>
							</label>
						</div>
					</div>
				<?php } ?>

				<?php if ($_POST['userperfil'] <= 2000 or $p1 == 1 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="precioz" id="precioz">
							<label class="form-check-label" for="precioz">
								<?php echo (trim($LitP01) !== "" ? $LitP01 : lang("Precio") . " 1"); ?>
							</label>
						</div>
					</div>
				<?php } ?>

				<?php if ($_POST['userperfil'] <= 2000 or $p2 == 1 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="precio2z" id="precio2z">
							<label class="form-check-label" for="precio2z">
								<?php echo (trim($LitP02) !== "" ? $LitP02 : lang("Precio") . " 2"); ?>
							</label>
						</div>
					</div>
				<?php } ?>

				<?php if ($_POST['userperfil'] <= 2000 or $p3 == 1 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="precio3z" id="precio3z">
							<label class="form-check-label" for="precio3z">
								<?php echo (trim($LitP03) !== "" ? $LitP03 : lang("Precio") . " 3"); ?>
							</label>
						</div>
					</div>
				<?php } ?>
				<?php if ($_POST['userperfil'] <= 2000 or $p4 == 1 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="precio4z" id="precio4z">
							<label class="form-check-label" for="precio4z">
								<?php echo (trim($LitP04) !== "" ? $LitP04 : lang("Precio") . " 4"); ?>
							</label>
						</div>
					</div>
				<?php } ?>
				<?php if ($_POST['userperfil'] <= 2000 or $p5 == 1 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="precio5z" id="precio5z">
							<label class="form-check-label" for="precio5z">
								<?php echo (trim($LitP05) !== "" ? $LitP05 : lang("Precio") . " 5"); ?>
							</label>
						</div>
					</div>
				<?php } ?>
				<?php if ($_POST['userperfil'] <= 2000 or $p6 == 1 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="precio6z" id="precio6z">
							<label class="form-check-label" for="precio6z">
								<?php echo (trim($LitP06) !== "" ? $LitP06 : lang("Precio") . " 6"); ?>
							</label>
						</div>
					</div>
				<?php } ?>
				<?php if ($_POST['userperfil'] <= 2000 or $p7 == 1 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="precio7z" id="precio7z">
							<label class="form-check-label" for="precio7z">
								<?php echo (trim($LitP07) !== "" ? $LitP07 : lang("Precio") . " 7"); ?>
							</label>
						</div>
					</div>
				<?php } ?>
				<?php if ($_POST['userperfil'] <= 2000 or $p8 == 1 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="precio8z" id="precio8z">
							<label class="form-check-label" for="precio8z">
								<?php echo (trim($LitP08) !== "" ? $LitP08 : lang("Precio") . " 8"); ?>
							</label>
						</div>
					</div>
				<?php } ?>
				<?php if ($_POST['userperfil'] <= 2000 or $p9 == 1 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="precio9z" id="precio9z">
							<label class="form-check-label" for="precio9z">
								<?php echo (trim($LitP09) !== "" ? $LitP09 : lang("Precio") . " 9"); ?>
							</label>
						</div>
					</div>
				<?php } ?>
				<?php if ($_POST['userperfil'] <= 2000 or $p10 == 1 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="precio10z" id="precio10z">
							<label class="form-check-label" for="precio10z">
								<?php echo (trim($LitP10) !== "" ? $LitP10 : lang("Precio") . " 10"); ?>
							</label>
						</div>
					</div>
				<?php } ?>

				<div class="col-6 col-md-4">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="PreciosCeroNo" id="PreciosCeroNo">
						<label class="form-check-label" for="PreciosCeroNo">
							<?php echo lang('No Mostrar Precios en cero'); ?>
						</label>
					</div>
				</div>
				<div class="col-6 col-md-4">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="MostrarFamilias" id="MostrarFamilias">
						<label class="form-check-label" for="MostrarFamilias">
							<?php echo lang('Familia'); ?>
						</label>
					</div>
				</div>
				<div class="col-6 col-md-4">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="MostrarMarcas" id="MostrarMarcas">
						<label class="form-check-label" for="MostrarMarcas">
							<?php echo lang('Marca'); ?>
						</label>
					</div>
				</div>
			</div>
		</div>
<!-- Lista de Precios 3 -->
		<div class="modal-footer" style="width: 100%;">
    		<div class="row input-group w-100 m-0">
    		    <div class="col-3 text-center p-1">
    		        <button class="btn btn-outline-danger w-100" type="reset" id="limpiar">
                <i class="fa fa-trash"></i> <?php echo lang('Limpiar'); ?>
    		        </button>
    		    </div>
    		    <div class="col-3 text-center p-1">
     		       <button class="btn btn-outline-primary w-100" type="button" onclick="var f = this.closest('form'); f.action='mercanciaLP_1168.php'; f.target='_blank'; f.submit();">
     		           <i class="fa fa-print"></i> <?php echo lang('Preliminar'); ?>
    		        </button>
      		  </div>
     		   <div class="col-3 text-center p-1">
    		        <button class="btn btn-danger w-100" type="button" onclick="var f = this.closest('form'); f.action='reporte_listaprecios_avanzado_pdf.php'; f.target='_blank'; f.submit();">
    		            <i class="fa fa-file-pdf-o"></i> PDF
     		       </button>
    		    </div>
				<div class="col text-center p-1">
    				<button class="btn btn-success w-100" type="button" onclick="var f = this.closest('form'); f.action='reporte_listaprecios_avanzado_excel.php'; f.target='_self'; f.submit();">
        				<i class="fa fa-file-excel-o"></i> Excel
    				</button>
				</div>
   		     <div class="col-3 text-center p-1">
   		         <button class="btn btn-outline-secondary w-100" type="button" data-bs-dismiss="modal">
   		             <i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?>
   		         </button>
   		     </div>
  		  </div>
		</div>
	</form>

	<script>
		var fecha = new Date();
		var mes = fecha.getMonth() + 1;
		var dia = fecha.getDate();
		var ano = fecha.getFullYear();
		if (dia < 10) {
			dia = '0' + dia;
		}
		if (mes < 10) {
			mes = '0' + mes;
		}
		document.getElementById('FechaHastalista').value = ano + "-" + mes + "-" + dia;
	</script>
<?php
}




if ($_POST["Accion"] === "17") {
?>
	<div class="modal-header">
		<h5 class="modal-title"><img src="/img/informez.png" alt="informe" height="24px" width="24px"> <?php echo lang('Recetas'); ?></h5>
		<button class="btn-close" type="button" data-bs-dismiss="modal"></button>
	</div>
	<form id="Productos" method="POST" target="_Blank" action="recetasReporte.php" onsubmit="return false">
		<div class="modal-body">
			<input type="hidden" name="CompanyActual" value="<?php echo $_POST['Company']; ?>" />
			<input type="hidden" name="IdCompanyGrp" value="<?php echo $_POST['IdCompanyGrp']; ?>" />
			<input type="hidden" name="CIdPlan" value="<?php echo $_POST['CIdPlan']; ?>" />
			<input type="hidden" name="SimMil" value="<?php echo $_POST['SimMil']; ?>" />
			<input type="hidden" name="SimDec" value="<?php echo $_POST['SimDec']; ?>" />
			<input type="hidden" name="CD" value="<?php echo $_POST['CD']; ?>" />
			<input type="hidden" name="direccion" value="<?php echo $_POST['direccion']; ?>" />
			<input type="hidden" name="NameCompany" value="<?php echo $_POST['NameCompany']; ?>" />
			<input type="hidden" name="sucursal" value="<?php echo $_POST['sucursal']; ?>" />

			<input type="hidden" name="fectx5" id="fectx5">
			<span style="display:none" id="devueltachavales"></span>
			<span style="display:none" id="CodigoDesaL"></span>
			<span style="display:none" id="CodigoHasaL"></span>
			<span style="display:none" id="BenefeL"></span>
			<span style="display:none" id="AlmaL"></span>
			<span style="display:none" id="MarL"></span>
			<div class="row p-1">

				<div class="col-12 col-lg-3 p-1">
					<label for="mIdfamilia"><?php echo lang("Familia"); ?></label>
					<select id="mIdfamilia" name="mIdfamilia[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$query = "SELECT a.IdVarios,if(a.IdVariosPadre=0,a.ITEM,concat(b.ITEM,' > ', a.ITEM)) AS ITEM FROM PosUpvarios a left join PosUpvarios b on a.IdCompany=b.IdCompany and a.IdVariosPadre = b.IdVarios and a.TIPOITEM = b.TIPOITEM and b.TIPOITEM = 2 WHERE a.IdCompany=" . $_POST["Company"] . " and a.TIPOITEM = 2 order by if(a.IdVariosPadre=0,a.ITEM,concat(b.ITEM,' > ', a.ITEM)) asc";
						//echo $query;
						if ($result = mysqli_query($conn, $query)) {
							while ($row = mysqli_fetch_assoc($result)) {

						?>
								<option value="<?php echo trim($row['IdVarios']); ?>"><?php echo trim($row['ITEM']); ?></option>
						<?

							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>
				<div class="col-12 col-lg-3 p-1">
					<label for="mIdMarca"><?php echo lang('Marca'); ?></label>
					<select id="mIdMarca" name="mIdMarca[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$sql = "SELECT idmarca,nombre FROM PosUpc_marcas a where a.IdCompany = " . $_POST["Company"];
						if ($result = mysqli_query($conn, $sql)) {
							while ($row = mysqli_fetch_assoc($result)) {
						?>
								<option value="<?php echo trim($row['idmarca']); ?>"><?php echo trim($row['nombre']); ?></option>
						<?
							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>

				<div class="col-12 col-lg-3 p-1">
					<label for="mIdProductos"><i class="fa fa-archive" aria-hidden="true"></i> <?php echo lang("Productos"); ?></label>
					<select id="mIdProductos" name="mIdProductos[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$query = "SELECT CodIdBasico,CodIdAmpliado,CodBarra,Descripcion FROM PosUpProducto a where a.EsCompuesto=20 and a.IdCompany = " . $_POST["Company"] . "";
						if ($result = mysqli_query($conn, $query)) {
							while ($row = mysqli_fetch_assoc($result)) {

						?>
								<option value="<?php echo trim($row['CodIdBasico']); ?>"><?php echo trim($row['Descripcion']); ?></option>
						<?

							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>

				<div class="col-12 col-lg-3 p-1">
					<label><i class="fa fa-sort"></i> <?php echo lang('Estados de los Productos'); ?></label>
					<div class="col">
						<select class="form-select" id="StatusCode" name="StatusCode">
							<option value="*"><?php echo lang('Todos'); ?></option>
							<option value="1"><?php echo lang('Activos'); ?></option>
							<option value="0"><?php echo lang('Inactivos'); ?></option>
						</select>
					</div>
				</div>


				<div class="col-12 p-1">
					<div class="row ms-3">
						<?php if ($_POST['userperfil'] <= 2000 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
							<div class="col-6 col-md-4 col-lg-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" name="Incluirimpuestos" id="Incluirimpuestos">
									<label class="form-check-label" for="Incluirimpuestos">
										<?php echo lang('Incluir Impuestos'); ?>
									</label>
								</div>
							</div>

							<div class="col-6  col-md-4 col-lg-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" name="Utilidad" id="Utilidad">
									<label class="form-check-label" for="Utilidad">
										<?php echo lang('Porcentaje de Utilidad'); ?>
									</label>
								</div>
							</div>
							<div class="col-6 col-md-4 col-lg-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" name="cos" id="cos">
									<label class="form-check-label" for="cos">
										<?php echo lang('Costo'); ?>
									</label>
								</div>
							</div>
						<?php } ?>

					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="row input-group ">
					<div class="col-4 text-center">
						<button class="btn btn-outline-danger px-1" type="reset" id="limpiar"><i class="fa fa-trash"></i> <?php echo lang('Limpiar'); ?></button>
					</div>
					<div class="col-4 text-center">
						<button type="button" class="btn btn-outline-primary px-1" onclick="document.getElementById(`Productos`).submit();"><i class="fa fa-print"></i> <?php echo lang('Preliminar'); ?></button>
					</div>
					<div class="col-4 text-center">
						<button class="btn btn-outline-secondary px-1" type="button" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?></button>
					</div>
				</div>
			</div>
		</div>
	</form>

	<script>
		$(document).ready(function() {
			$("#mIdfamilia").select2({
				dropdownParent: $("#apps-modalz"),
			});
			$("#mIdProductos").select2({
				dropdownParent: $("#apps-modalz"),
			});
			$("#mIdMarca").select2({
				dropdownParent: $("#apps-modalz"),
			});
		});
	</script>
<?php
}



if ($_POST["Accion"] === "18") {

	$sql = "SELECT LitP01,LitP02,LitP03,LitP04,LitP05,LitP06,LitP07,LitP08,LitP09,LitP10,LitCosto,MonedaS,FactorDolarCash,MonedaP,FactorDolarPaypal,Moneda3,FactorDolarZelle,Moneda4,FactorDolar5,Moneda5,FactorDolar6,Moneda6,FactorDolar7,Moneda7 FROM PosUpCompany 
	where Id=" . $_POST["Company"] . "";
	if ($result = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$LitP01 = $row["LitP01"];
			$LitP02 = $row["LitP02"];
			$LitP03 = $row["LitP03"];
			$LitP04 = $row["LitP04"];
			$LitP05 = $row["LitP05"];
			$LitP06 = $row["LitP06"];
			$LitP07 = $row["LitP07"];
			$LitP08 = $row["LitP08"];
			$LitP09 = $row["LitP09"];
			$LitP10 = $row["LitP10"];
			$LitCosto = $row["LitCosto"];
			$company = [
				"FactorDolarCash" => $row["FactorDolarCash"],
				"MonedaS" => $row["MonedaS"],
				"FactorDolarPaypal" => $row["FactorDolarPaypal"],
				"Moneda3" => $row["Moneda3"],
				"FactorDolarZelle" => $row["FactorDolarZelle"],
				"Moneda4" => $row["Moneda4"],
				"FactorDolar5" => $row["FactorDolar5"],
				"Moneda5" => $row["Moneda5"],
				"FactorDolar6" => $row["FactorDolar6"],
				"Moneda6" => $row["Moneda6"],
				"FactorDolar7" => $row["FactorDolar7"],
				"Moneda7" => $row["Moneda7"],
				"MonedaP" => $row["MonedaP"],
			];
		}
	}

	if ($_POST["Company"] === "1167") {

		$tasa = floatval($company["FactorDolarZelle"]);
		$moneda = $company["Moneda4"];
	} else if ($_POST["Company"] === "1168") {
		$tasa = floatval($company["FactorDolarPaypal"]);
		$moneda = $company["Moneda3"];
	} else if ($_POST["Company"] === "1174") {

		$tasa = floatval($company["FactorDolar7"]);
		$moneda = $company["Moneda7"];
	} else if ($_POST["Company"] === "1181") {

		$tasa = floatval($company["FactorDolarPaypal"]);
		$moneda = $company["Moneda3"];
	}

?>
	<div class="modal-header">
		<h5 class="modal-title"><img src="/img/informez.png" alt="informe" height="24px" width="24px"> <?php echo lang('Lista de Precios'); ?> II & IV</h5>
		<button class="btn-close" type="button" data-bs-dismiss="modal"></button>
	</div>
	<form id="ListaPrecio" method="POST" target="_Blank" action="mercanciaLP_1167.php" onsubmit="return false">
		<div class="modal-body">
			<input type="hidden" name="fectx5" id="fectx5" />

			<input type="hidden" name="CompanyActual" value="<?php echo $_POST['Company']; ?>" />
			<input type="hidden" name="IdCompanyGrp" value="<?php echo $_POST['IdCompanyGrp']; ?>" />
			<input type="hidden" name="CIdPlan" value="<?php echo $_POST['CIdPlan']; ?>" />
			<input type="hidden" name="SimMil" value="<?php echo $_POST['SimMil']; ?>" />
			<input type="hidden" name="SimDec" value="<?php echo $_POST['SimDec']; ?>" />
			<input type="hidden" name="CD" value="<?php echo $_POST['CD']; ?>" />
			<input type="hidden" name="direccion" value="<?php echo $_POST['direccion']; ?>" />
			<input type="hidden" name="NameCompany" value="<?php echo $_POST['NameCompany']; ?>" />
			<input type="hidden" name="sucursal" value="<?php echo $_POST['sucursal']; ?>" />
			<span style="display:none" id="devueltachavalesLP"></span>
			<span style="display:none" id="CodigoDesaLLP"></span>
			<span style="display:none" id="CodigoHasaLLP"></span>
			<span style="display:none" id="BenefeLLP"></span>
			<span style="display:none" id="AlmaLLP"></span>
			<span style="display:none" id="MarLLP"></span>


			<div class="row p-1">
				<div class="col-12  p-1 <?php echo $notemp; ?>">
					<div class="col">
						<div class="form-floating">
							<select id='IdCompanySelect' name='IdCompanySelect' onchange='selectidcomp(document.getElementById("IdCompanySelect").value);' class="form-select <?php echo $notemprise; ?>" aria-label="Default select example">
								<?php
								$conn = conectar();

								$query = "SELECT '" . $_POST["IdCompanyGrp"] . "' as ID, ' [" . lang('Todas') . "]' as Empresa  union  SELECT Id as ID, comercio as Empresa FROM PosUpCompany where Id in ( " . $_POST["IdCompanyGrp"] . ")  order by Empresa ";
								//echo $query;
								if ($result = mysqli_query($conn, $query)) {
									$n = 0;
									/* obtener array asociativo */
									while ($row = mysqli_fetch_assoc($result)) {
								?><option value="<?php echo trim($row['ID']); ?>" <?php if (trim($row['ID']) == trim($_POST['emprise'])) {
																						echo "selected";
																					}; ?>><?php echo trim($row['Empresa']); ?></option><?
																																	}

																																	mysqli_free_result($result);
																																}
																																		?>
							</select>
							<label><i class="fa fa-sorttt"></i> <?php echo lang('Empresa'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<div class="col">
						<div class="form-floating">
							<select class="form-select" name="EnvioEstado" id="EnvioEstado">
								<option value="*"><?php echo lang("Todos"); ?></option>
								<option value="1"><?php echo lang("Activo"); ?></option>
								<option value="0"><?php echo lang("Inactivo"); ?></option>
							</select>
							<label><i class="fa fa-hourglass" aria-hidden="true"></i>&nbsp;<?php echo lang('Estado'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<div class="form-floating">
						<select name="SelectTasa" id="SelectTasa" class="form-select">
							<?php
							$MonedaP = "";
							$MonedaS = "";
							$GenTxFactorDCambio = "";
							$query = "SELECT FactorDolarCash,FactorDolarPaypal,FactorDolarZelle,Moneda3,Moneda4,MonedaP,MonedaS,MonedaP,LitPrincipalEfectivo,Moneda5,Moneda6,Moneda7,FactorDolar5,FactorDolar6,FactorDolar7 FROM PosUpCompany WHERE Id=" . $_POST['Company'] . "";
							if ($result = mysqli_query($conn, $query)) {
								while ($row = mysqli_fetch_assoc($result)) {
									$MonedaP = $row["MonedaP"];
									$MonedaS =  ($row["LitPrincipalEfectivo"] === "" ? $row['MonedaS'] : $row["LitPrincipalEfectivo"]);
									// $GenTxFactorDCambio .= "<option value='1' >" . $row['MonedaP'] . "</option>";
									if ($row['FactorDolarCash'] > 1) $GenTxFactorDCambio .= "<option value='2' >" . ($row["LitPrincipalEfectivo"] === "" ? $row['MonedaS'] : $row["LitPrincipalEfectivo"])  . "</option>";
									if ($row['FactorDolarPaypal'] > 1) $GenTxFactorDCambio .= "<option value='3' >" . $row['Moneda3'] . "</option>";
									if ($row['FactorDolarZelle'] > 1) $GenTxFactorDCambio .= "<option value='4' >" . $row['Moneda4'] . "</option>";
									if ($row['FactorDolar5'] > 1) $GenTxFactorDCambio .= "<option value='5' >" . $row['Moneda5'] . "</option>";
									if ($row['FactorDolar6'] > 1) $GenTxFactorDCambio .= "<option value='6' >" . $row['Moneda6'] . "</option>";
									if ($row['FactorDolar7'] > 1) $GenTxFactorDCambio .= "<option value='7' >" . $row['Moneda7'] . "</option>";
								}
								mysqli_free_result($result);
							}
							echo $GenTxFactorDCambio;
							?>
						</select>
						<label><i class="fa fa-money" aria-hidden="true"></i>&nbsp;<?php echo lang('Tasa') ?></label>
					</div>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<div class="col">
						<div class="form-floating">
							<input class="form-control text-end" type="number" name="TasaBCV" value="<?php echo $tasa; ?>">
							<label><i class="fa fa-money" aria-hidden="true"></i>&nbsp;<?php echo lang('BCV'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6 p-1">
					<div class="form-floating">
						<select name="SelectPrecio" id="SelectPrecio" class="form-select">

							<option value="">
								<?php echo (trim($LitP01) !== "" ? $LitP01 : lang("Precio") . " 1"); ?>
							</option>
							<option value="2">
								<?php echo (trim($LitP02) !== "" ? $LitP02 : lang("Precio") . " 2"); ?>
							</option>
							<option value="3">
								<?php echo (trim($LitP03) !== "" ? $LitP03 : lang("Precio") . " 3"); ?>
							</option>
							<option value="4">
								<?php echo (trim($LitP04) !== "" ? $LitP04 : lang("Precio") . " 4"); ?>
							</option>
							<option value="5">
								<?php echo (trim($LitP05) !== "" ? $LitP05 : lang("Precio") . " 5"); ?>
							</option>
							<option value="6">
								<?php echo (trim($LitP06) !== "" ? $LitP06 : lang("Precio") . " 6"); ?>
							</option>
							<option value="7">
								<?php echo (trim($LitP07) !== "" ? $LitP07 : lang("Precio") . " 7"); ?>
							</option>
							<option value="8">
								<?php echo (trim($LitP08) !== "" ? $LitP08 : lang("Precio") . " 8"); ?>
							</option>
							<option value="9">
								<?php echo (trim($LitP09) !== "" ? $LitP09 : lang("Precio") . " 9"); ?>
							</option>
							<option value="10">
								<?php echo (trim($LitP10) !== "" ? $LitP10 : lang("Precio") . " 10"); ?>
							</option>
						</select>
						<label><i class="fa fa-money" aria-hidden="true"></i>&nbsp;<?php echo lang('Precio') ?></label>
					</div>
				</div>

				<div class="col-12 col-lg-6 p-1">
					<div class="col">
						<div class="form-floating">
							<select class="form-select" id="Agrupar" name="Agrupar">
								<option value="Familiazp"><?php echo lang('Familia'); ?></option>
								<option value="Marcazp"><?php echo lang('Marca'); ?></option>
								<option value="FamiliaMarca"><?php echo lang('Familia y marca'); ?></option>
							</select>
							<label><i class="fa fa-object-group"></i> <?php echo lang('Agrupamiento'); ?></label>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<label class='d-flex gap-2 align-items-center'>
						<?php echo lang('Familia'); ?>
						<div class='form-check'>
							<input class='form-check-input' type='checkbox' name='NotIncludeFamilia'>
							<label class='form-check-label'><?php echo lang('No Incluir'); ?></label>
						</div>
					</label>
					<select id="mIdfamilia" name="mIdfamilia[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$query = "SELECT a.IdVarios,if(a.IdVariosPadre=0,a.ITEM,concat(b.ITEM,' > ', a.ITEM)) AS ITEM FROM PosUpvarios a left join PosUpvarios b on a.IdCompany=b.IdCompany and a.IdVariosPadre = b.IdVarios and a.TIPOITEM = b.TIPOITEM and b.TIPOITEM = 2 WHERE a.IdCompany=" . $_POST["Company"] . " and a.TIPOITEM = 2 order by if(a.IdVariosPadre=0,a.ITEM,concat(b.ITEM,' > ', a.ITEM)) asc";
						//echo $query;
						if ($result = mysqli_query($conn, $query)) {
							while ($row = mysqli_fetch_assoc($result)) {

						?>
								<option value="<?php echo trim($row['IdVarios']); ?>"><?php echo trim($row['ITEM']); ?></option>
						<?

							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<label class='d-flex gap-2 align-items-center'>
						<?php echo lang('Marca'); ?>
						<div class='form-check'>
							<input class='form-check-input' type='checkbox' name='NotIncludeMarca'>
							<label class='form-check-label'><?php echo lang('No Incluir'); ?></label>
						</div>
					</label>
					<select id="mIdMarca" name="mIdMarca[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$sql = "SELECT idmarca,nombre FROM PosUpc_marcas a where a.IdCompany = " . $_POST["Company"];
						if ($result = mysqli_query($conn, $sql)) {
							while ($row = mysqli_fetch_assoc($result)) {
						?>
								<option value="<?php echo trim($row['idmarca']); ?>"><?php echo trim($row['nombre']); ?></option>
						<?
							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>

				<div class="col-12 col-lg-4 p-1">
					<label class='d-flex gap-2 align-items-center'>
						<?php echo lang('Productos'); ?>
						<div class='form-check'>
							<input class='form-check-input' type='checkbox' name='NotIncludeProductos'>
							<label class='form-check-label'><?php echo lang('No Incluir'); ?></label>
						</div>
					</label>
					<select id="mIdProductos" name="mIdProductos[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						$query = "SELECT CodIdBasico,CodIdAmpliado,CodBarra,Descripcion FROM PosUpProducto a where  a.IdCompany = " . $_POST["Company"] . " and a.EsCompuesto in (20,1,0)";
						if ($result = mysqli_query($conn, $query)) {
							while ($row = mysqli_fetch_assoc($result)) {

						?>
								<option value="<?php echo trim($row['CodIdBasico']); ?>">(<?php echo $row["CodIdAmpliado"]; ?>) <?php echo trim($row['Descripcion']); ?></option>
						<?

							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<label class='d-flex gap-2 align-items-center'>
						<?php echo lang('Almacén'); ?>
						<div class='form-check'>
							<input class='form-check-input' type='checkbox' name='NotIncludeAlmacen'>
							<label class='form-check-label'><?php echo lang('No Incluir'); ?></label>
						</div>
					</label>
					<select id="mIdAlmacen" name="mIdAlmacen[]" multiple="multiple" style="width: 100%">
						<?php
						$conn = conectar();
						if ($_POST['sucursal'] == '0') {
							$sql = "SELECT a.*  FROM PosUpAlmacen a WHERE a.IdCompany = " . $_POST["Company"] . " ";
						} else {
							$sql = "SELECT a.* FROM PosUpAlmacen a WHERE a.IdCompany = " . $_POST["Company"] . " and a.IdUbi=" . $_POST['sucursal'];
						}
						if ($result = mysqli_query($conn, $sql)) {
							while ($row = mysqli_fetch_assoc($result)) {
						?>
								<option value="<?php echo trim($row['IdAlm']); ?>"><?php echo trim($row['Nombre']); ?></option>
						<?php
							}
							mysqli_free_result($result);
						}
						?>
					</select>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<label class='d-flex gap-2 align-items-center'>
						<?php echo lang('Ubicación'); ?>
						<div class='form-check'>
							<input class='form-check-input' type='checkbox' name='NotIncludeUbicacion'>
							<label class='form-check-label'><?php echo lang('No Incluir'); ?></label>
						</div>
					</label>
					<select id="ModalUbicaciones" name="ModalUbicaciones[]" style="width:100%" multiple>
						<?php
						$queryUB = " SELECT IdUbi,Nombre FROM PosUpUbicacion WHERE IdCompany=" . $_POST["Company"] . "";
						if ($resultUB = mysqli_query($conn, $queryUB)) {
							while ($rowUB = mysqli_fetch_assoc($resultUB)) {
								$ModalZona2C2 .= "<option value='" . $rowUB['IdUbi'] . "'>" . $rowUB["Nombre"] . "</option>";
							}
							mysqli_free_result($resultUB);
						}
						echo $ModalZona2C2;
						?>
					</select>
				</div>
				<div class="col-12 col-lg-4 p-1">
					<label class='d-flex gap-2 align-items-center'>
						<?php echo lang('Zona Atenciòn'); ?>
						<div class='form-check'>
							<input class='form-check-input' type='checkbox' name='NotIncludeZonaAtencion'>
							<label class='form-check-label'><?php echo lang('No Incluir'); ?></label>
						</div>
					</label>
					<select class='form-select' id='ModalAtencion' name='ModalAtencion[]' style='width:100%' multiple>
						<?php

						$ZonaAtt = "";

						$query = "SELECT IdAtt,Nombre FROM posupzonaatt WHERE IdCompany=" . $_POST["Company"] . " ";
						if ($result = mysqli_query($conn, $query)) {
							while ($row = mysqli_fetch_assoc($result)) {
								$ZonaAtt .= '<option value="' . trim($row['IdAtt']) . '">' . trim($row['Nombre']) . '</option>';
							}
							mysqli_free_result($result);
						}

						echo $ZonaAtt;
						?>
					</select>
				</div>
				<div class="row">
					<?php if ($_POST["userperfil"] <= 2000 || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053") { ?>
						<div class="col-6 col-md-4">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="cimp" id="cimp">
								<label class="form-check-label" for="cimp">
									<?php echo lang('Con Impuesto'); ?>
								</label>
							</div>
						</div>
					<?php } ?>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="redondeadoCheck" id="redondeadoCheck">
							<label class="form-check-label" for="redondeadoCheck">
								<?php echo lang('Redondeado'); ?>
							</label>
						</div>
					</div>
					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="pricemayor" id="pricemayor">
							<label class="form-check-label" for="pricemayor">
								<?php echo lang('Precios mayor a cero'); ?>
							</label>
						</div>
					</div>

					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="MonedaPrimeriaMostrar" id="MonedaPrimeriaMostrar" checked>
							<label class="form-check-label" for="MonedaPrimeriaMostrar">
								<?php echo lang('Precio') . " " . $MonedaP; ?>
							</label>
						</div>
					</div>

					<div class="col-6 col-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="MonedaSecundariaMostrar" id="MonedaSecundariaMostrar" checked>
							<label class="form-check-label" for="MonedaSecundariaMostrar">
								<?php echo lang('Precio') . " " . $MonedaS; ?>
							</label>
						</div>
					</div>
				</div>
				<script>
					$(document).ready(function() {
						$("#mIdProductos").select2({
							dropdownParent: $("#apps-modalz"),
						});
						$("#mIdMarca").select2({
							dropdownParent: $("#apps-modalz"),
						});
						$("#mIdAlmacen").select2({
							dropdownParent: $("#apps-modalz"),
						});
						$("#mIdfamilia").select2({
							dropdownParent: $("#apps-modalz"),
						});
						$("#ModalUbicaciones").select2({
							dropdownParent: $("#apps-modalz"),
						});
						$("#ModalAtencion").select2({
							dropdownParent: $("#apps-modalz"),
						});
					});
				</script>
			</div>

		</div>

		<div class="modal-footer">
			<div class="row input-group ">
				<div class="col-4 text-center">
					<button class="btn btn-outline-danger px-1" type="reset" id="limpiar"><i class="fa fa-trash"></i> <?php echo lang('Limpiar'); ?></button>
				</div>
				<div class="col-4 text-center">
					<button class="btn btn-outline-primary px-1" type="button" onclick="submit();"><i class="fa fa-print"></i> <?php echo lang('Preliminar'); ?></button>
				</div>
				<div class="col-4 text-center">
					<button class="btn btn-outline-secondary px-1" type="button" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?></button>
				</div>
			</div>
		</div>
	</form>

	<script>
		var fecha = new Date();
		var mes = fecha.getMonth() + 1;
		var dia = fecha.getDate();
		var ano = fecha.getFullYear();
		if (dia < 10) {
			dia = '0' + dia;
		}
		if (mes < 10) {
			mes = '0' + mes;
		}
		document.getElementById('FechaHastalista').value = ano + "-" + mes + "-" + dia;
	</script>
	<script>
$(document).ready(function() {
    // Tomamos el número de Acción que se abrió
    var accion = parseInt("<?php echo $_POST['Accion'] ?? '0'; ?>");
    var urlPdf = "";

    // Mapa de rutas exacto de tu sistema
    switch(accion) {
        case 1:  urlPdf = "reporte_productos_pdf.php"; break;
        case 2:  urlPdf = "reporte_reposicion_pdf.php"; break;
        case 3:  urlPdf = "reporte_analisis_productos_pdf.php"; break;
        case 4:  urlPdf = "reporte_listaprecios_pdf.php"; break;
        case 5:  urlPdf = "reporte_fisico_pdf.php"; break;
        case 6:  urlPdf = "reporte_analisisfamilia_pdf.php"; break;
        case 7:  urlPdf = "reporte_analisis_marca_pdf.php"; break; // El que estamos probando
        case 8:  urlPdf = "reporte_operaciones_pdf.php"; break;
        case 9:  urlPdf = "reporte_historial_seriales_pdf.php"; break;
        case 10: urlPdf = "reporte_detallado_pdf.php"; break;
        case 11: urlPdf = "reporte_resumido_pdf.php"; break;
        case 12: urlPdf = "reporte_fiscal_pdf.php"; break;
        case 13: urlPdf = "reporte_produccion_pdf.php"; break;
        case 15: urlPdf = "reporte_listaprecios_avanzado1167_pdf.php"; break;
        case 16: urlPdf = "reporte_listaprecios_avanzado_pdf.php"; break;
        case 18: urlPdf = "reporte_listaprecios_avanzado1167_pdf.php"; break;
    }

    // Si la tarjeta tiene un PDF asignado, inyectamos el botón
    if (urlPdf !== "") {
        // Buscamos el formulario de este modal
        var $form = $(".modal-body").closest("form");
        
        if ($form.length > 0) {
            // Guardamos a dónde iba originalmente (Ej: analisismarca.php)
            var originalAction = $form.attr("action");

            // Buscamos el pie de página donde están los botones
            var $footerRow = $form.find(".modal-footer .row");
            
            if ($footerRow.length > 0) {
                // 1. Achicamos los botones existentes para que quepa uno más (de col-4 a col-3)
                $footerRow.find(".col-4").removeClass("col-4").addClass("col-3 px-1");
                $footerRow.find("button").addClass("w-100"); // Que ocupen el ancho completo
                
                // 2. Modificamos el botón Preliminar para asegurar que vaya al HTML original
                var $btnPreliminar = $footerRow.find("button:has(.fa-print)");
                $btnPreliminar.removeAttr("onclick").off("click").on("click", function() {
                    $form.attr("action", originalAction);
                    $form.attr("target", "_blank");
                    $form[0].submit();
                });

                // 3. Creamos el botón PDF
                var btnPdfHtml = '<div class="col-3 text-center px-1">' +
                                 '<button type="button" class="btn btn-danger w-100" id="btnGenerarPDF">' +
                                 '<i class="fa fa-file-pdf-o"></i> PDF</button>' +
                                 '</div>';
                
                // 4. Lo insertamos justo después del botón de Preliminar
                $btnPreliminar.parent().after(btnPdfHtml);

                // 5. Le damos la función al botón PDF para que apunte al archivo correcto
                $("#btnGenerarPDF").on("click", function() {
                    $form.attr("action", urlPdf);
                    $form.attr("target", "_blank");
                    $form[0].submit();
                });
            }
        }
    }
});
</script>
<?php
}
