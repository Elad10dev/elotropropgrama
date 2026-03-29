<?
$Item3 = "";
$sql = "select IdVarios,ITEM from PosUpvarios where IdCompany = '" . $_SESSION["CompanyActual"] . "' and TIPOITEM = 3 order by ITEM ASC";
if ($query = mysqli_query($conn, $sql)) {
	while ($row = mysqli_fetch_array($query)) {
		$Item3 .= "<option value='" . $row['IdVarios'] . "'>" . $row['ITEM'] . "</option>";
	}
}
$EstadoCredito = "0";
$query4 = " select validCredit from PosUpCompany where Id = " . trim($_SESSION["CompanyActual"]) . " ";
if ($result3 = mysqli_query($conn, $query4)) {
	while ($row3 = mysqli_fetch_assoc($result3)) {
		$EstadoCredito = $row3['validCredit'];
	}
	mysqli_free_result($result3);
}
?>

<style>
	@media screen and (max-width: 400px) {
		.text-check {
			font-size: 0.84em !important;
		}
	}

	.modal {
		overflow-y: auto;
	}
</style>
<span id='Estees' style='display:none'><?php echo $_SESSION['Ec']; ?></span>

<div class="fixed-top " id='elfixed' style='display:none; padding-top:50px;  z-index:10000;'>
	<div class="col-12 col-sm-6 col-md-5 col-lg-4 col-xl-3 float-end">
		<div id="valida" class="alert alert-danger" role="alert" style="display:none;">
			<span id='contenido'> </span>
		</div>
	</div>
</div>
<header id="header">
	<div class="container">
		<div class="row">

			<div class="col-md-8">
				<?php if ($_SESSION['Ec'] == 0) { ?>
					<h1 id="TituloModulo"><i><img src="/img/beneficiarios.png" width="20" height="20"></i> <?php echo lang('Beneficiarios'); ?> </h1>
				<?php } ?>
				<?php if ($_SESSION['Ec'] == 1) { ?>
					<h1 id="TituloModulo"><i><img src="/img/beneficiarios.png" width="20" height="20"></i> <?php echo lang('Terceros'); ?> </h1>
				<?php } ?>
			</div>

		</div>

	</div>
</header>


<nav aria-label="breadcrumb">
	<div class="container d-flex justify-content-between">
		<ol class="breadcrumb">
			<?php if ($_SESSION['Ec'] == 0) { ?>
				<li class="breadcrumb-item "><a href="app.php?opcion=configurador.php"><?php echo lang('Configurador'); ?></a></li>
				<li class="breadcrumb-item "><a href="app.php?opcion=tablasnew.php"><?php echo lang('Tablas'); ?></a></li>
				<li class="breadcrumb-item active"><?php echo lang('Beneficiarios'); ?></li>
			<?php } ?>
			<?php if ($_SESSION['Ec'] == 1) { ?>
				<li class="breadcrumb-item "><a href="app.php?opcion=dashboard.php"><?php echo lang('Escritorio'); ?></a></li>
				<li class="breadcrumb-item "><a href="app.php?opcion=empresasdecontabilidad.php"><?php echo lang('Empresas'); ?></a></li>
				<li class="breadcrumb-item "><a href="app.php?opcion=configuracioncrud.php&P1=<?php echo $_SESSION['CTBIdCompany']; ?>&P2=<?php echo $_SESSION['CTBIdEmpresa']; ?>&P3=<?php echo $_SESSION['CTBOrigen']; ?>&P4=<?php echo $_SESSION['CTBlitfiscal']; ?>&P5=<?php echo $_SESSION['CTBidfiscal']; ?>&P6=<?php echo $_SESSION['CTBcomercio']; ?>"><?php echo $_SESSION['CTBcomercio']; ?></a></li>
				<li class="breadcrumb-item "><a href="app.php?opcion=tablacontabilidad.php&P7=<?php echo $_SESSION['CTBPeriodo']; ?>&P8=<?php echo $_SESSION['CTBPeriodoNom']; ?>"><?php echo $_SESSION['CTBPeriodoNom']; ?></li></a>
				<li class="breadcrumb-item active"><?php echo lang('Terceros'); ?></li>
			<?php } ?>
		</ol>
		<div class="d-flex justify-content-end text-end gap-2" id="spinner_load_DatatableConPro">
			<div><strong class="text-primary fs-6"><?php echo lang('Cargando'); ?></strong></div>
			<div class="spinner-grow text-primary fs-6 ms-auto" role="status" aria-hidden="true" style="width: 1.3rem !important; height: 1.3rem !important;"></div>
		</div>
	</div>
</nav>

<div class="container" style='padding-bottom:78px;'>
	<?php if ($_SESSION["userperfil"] <= 2000 or $_SESSION["userperfil"] == "2055") { ?>
		<div class="col-12 mb-1">
			<button class="btn btn-outline-primary p-1" id='btn-agg' title="<?php echo lang('Descargar'); ?>" onclick="document.getElementById(`formexcel4`).submit();">
				<i class="fa fa-download"></i> <i class="fa fa-file-excel-o"></i>
				<?php echo lang('Descargar Beneficiarios'); ?>
			</button>
			<form id="formexcel4" action="excelnew.php" method="post">
				<?php
				// coalesce(if(round((b.cantidad-floor(b.cantidad))*a.CantP1,3)<>0,concat(round((b.cantidad-floor(b.cantidad))*a.CantP1,3)),''),0)
				$compa = $_SESSION["CompanyActual"];
				$name = "Beneficiarios_Totales";
				$query2 = "SELECT RUT,CodIntDeudor,codBarra,Nombre,fono,email,Direccion,Giro,ciudad,EsCliente,EsProveedor,EsTrabajador,EsOtro FROM PosUpclientes WHERE IdCompany =" . $_SESSION["CompanyActual"];
				?>
				<input type="hidden" name="Query" id="Query" value="<?php echo $query2;       ?>" />
				<input type="hidden" name="Name" id="Name" value="<?php echo $name; ?>" />
				<input type="hidden" name="vas" id="vas" value="Beneficiarios_Totales" />
				<input type="hidden" name="CompanyActual" id="CompanyActual" value="<?php echo  $_SESSION["CompanyActual"]; ?>" />
			</form>
		</div>
	<?php } ?>
	<div id="alertaerrorenproducto2"></div>
	<div class="table-responsive">
		<table class="table table-hover table-striped nowrap" id="DatatableConPro" cellspacing="0" style="width:100%">
			<thead>
				<tr>
					<th><?php echo $_SESSION['litfiscal'];
						if ($_SESSION["userperfil"] < 20000) { ?> <button class="btn btn-outline-primary p-1" type="button" onclick="recibir(0);"><span class="fa fa-plus"></span> <?php echo lang("Agregar"); ?></button> <?php } ?></th>
					<th><?php echo lang('Estado'); ?></th>
					<th><?php echo lang('Cliente'); ?></th>
					<th><?php echo lang('Proveedor'); ?></th>
					<th><?php echo lang('Trabajador'); ?></th>
					<th><?php echo lang('Otro'); ?> </th>
				</tr>
			</thead>
		</table>
	</div>
</div>

<div id="apps-modal" class="modal fade" tabindex="1" role="dialog">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">
					<i class="fa fa-edit"></i>

					<?php
					if ($_SESSION['Ec'] == 0) {
						echo lang('Editar Beneficiario');
					}
					if ($_SESSION['Ec'] == 1) {
						echo lang('Editar Tercero');
					}
					?>
				</h5>
				<button data-bs-dismiss="modal" class="btn-close" type="button"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="border border-3 border-warning p-2 rounded-2" role="alert" id="alertaerrorenproducto" style="display:none;"></div>
					<form class="fieldset" method="post" id="formdata">
						<input type="hidden" id="tabla" name="tabla" value="beneficiarios" />
						<input type="hidden" id="companyUser" name="companyUser" value="<?php echo $_SESSION["CompanyActual"]; ?>" />
						<input type="hidden" id="edit" name="edit" value="" />
						<input type="hidden" id="new" name="new" value="" />
						<input type="hidden" id="longitud" name="longitud" />
						<input type="hidden" id="latitud" name="latitud" />
						<input type="hidden" id="ModalDeudamb" name="ModalDeudamb" />
						<input type="hidden" id="ModalDeudaml" name="ModalDeudaml" />
						<input type="hidden" id="ModalFechap1" name="ModalFechap1" />
						<input type="hidden" id="ModalFechap2" name="ModalFechap2" />
						<input type="hidden" id="ModalNroc" name="ModalNroc" />
						<input type="hidden" id="ModalCredf" name="ModalCredf" />
						<input type="hidden" id="ModalCredu" name="ModalCredu" />
						<span id='usuario' style='display:none;'><?php echo $usuario; ?></span>

						<div class="row">
							<div class="row input-group text-check">
								<div class="col-6 col-md-6 col-lg-3 text-start">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="ModalCli" id="ModalCli">
										<label class="form-check-label" for="ModalCli">
											<?php echo lang('Es'); ?>&nbsp;<?php echo lang('Cliente'); ?>
										</label>
									</div>
								</div>

								<div class="col-6 col-md-6 col-lg-3 text-start">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="ModalProv" id="ModalProv">
										<label class="form-check-label" for="ModalProv">
											<?php echo lang('Es'); ?>&nbsp;<?php echo lang('Proveedor'); ?>
										</label>
									</div>
								</div>

								<div class="col-6 col-md-6 col-lg-3 text-start">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="ModalTrab" id="ModalTrab">
										<label class="form-check-label" for="ModalTrab">
											<?php echo lang('Es'); ?>&nbsp;<?php echo lang('Trabajador'); ?>
										</label>
									</div>
								</div>

								<div class="col-6 col-md-6 col-lg-3 text-start">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="ModalOtro" id="ModalOtro">
										<label class="form-check-label" for="ModalOtro">
											<?php echo lang('Es'); ?>&nbsp;<?php echo lang('Otro'); ?>
										</label>
									</div>
								</div>

								<div class="col-6 col-md-6 col-lg-3 text-start">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="ModalServicio" id="ModalServicio">
										<label class="form-check-label" for="ModalServicio">
											<?php echo lang('Es'); ?>&nbsp;<?php echo lang('Servidor'); ?>
										</label>
									</div>
								</div>

								<div class="col-xs-12 col-md-6 col-lg-3 text-start">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="ModalEdo" id="ModalEdo">
										<label class="form-check-label" for="ModalEdo">
											<?php echo lang('Estado'); ?>
										</label>
									</div>
								</div>

							</div>
							<div class="col-12 col-md-6 p-1">
								<?php if ($_SESSION["IdPais"] == 'CL') { ?>
									<div class="col">
										<div class="form-floating">
											<input type="text" class="form-control" id="ModalRut" name="ModalRut" onchange='dgv(this.value)' />
											<label><i class="fa fa-file-o"></i>&nbsp;<?php echo Lang("R.U.T."); ?></label>
										</div>
									</div>
									<div class="col">
										<div class="form-floating">
											<input type="text" class="form-control" id="ModalRut2" name="ModalRut2" readonly />
										</div>
									</div>
								<?php } else { ?>
									<div class="col">
										<div class="form-floating">
											<input type="text" class="form-control" id="ModalRif" name="ModalRif" />
											<label><i class="fa fa-file-o"></i>&nbsp;<?php echo $_SESSION["litfiscal"]; ?></label>
										</div>
									</div>
								<?php } ?>
							</div>

							<div class="col-12 col-md-6 p-1">
								<div class="col">
									<div class="form-floating">
										<input type="text" class="form-control" id="ModalNombre" name="ModalNombre" />
										<label><i class="fa fa-university"></i>&nbsp;<?php echo lang('Razón Social'); ?></label>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-6 p-1">
								<div class="col">
									<div class="form-floating">
										<input type="text" class="form-control" id="ModalCodb" name="ModalCodb" />
										<label><i class="fa fa-barcode"></i>&nbsp;<?php echo lang('Codigo de Barras'); ?></label>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-6 p-1">
								<div class="col">
									<div class="form-floating">
										<input type="text" class="form-control" id="ModalEmailCorreo" name="ModalEmailCorreo" />
										<label><i class="fa fa-envelope"></i>&nbsp;<?php echo lang('Email'); ?></label>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-6 p-1">
								<div class="col">
									<div class="form-floating">
										<input type="text" class="form-control" id="ModalCid" name="ModalCid" />
										<label><i class="fa fa-hashtag"></i>&nbsp;<?php echo lang('Código Interno'); ?></label>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-6 p-1">
								<div class="col">
									<div class="form-floating">
										<input type="text" class="form-control" id="ModalTelf" name="ModalTelf" onkeypress="return OnlyPhoners(event)" />
										<label><i class="fa fa-phone"></i>&nbsp;<?php echo lang('Teléfono'); ?></label>
									</div>
								</div>
							</div>
							<div class="col-12  <?php echo ($_SESSION["userperfil"] > 2000 && $_SESSION["userperfil"] !== "2050" && $_SESSION["userperfil"] !== "2055"  && $_SESSION["userperfil"] !== "2056"   ? '' : 'col-md-6'); ?> p-1">
								<div class="col">
									<div class="form-floating">
										<input type="text" class="form-control" id="ModalDir" name="ModalDir" />
										<label><i class="fa fa-map-marker"></i>&nbsp;<?php echo lang('Dirección'); ?></label>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-6 p-1" <?php echo ($_SESSION["userperfil"] > 2000 && $_SESSION["userperfil"] !== "2050" && $_SESSION["userperfil"] !== "2055"  && $_SESSION["userperfil"] !== "2056"   ? "style='display:none;'" : ""); ?>>
								<div class="col">
									<div class="form-floating">
										<input type="number" class="form-control" id="ModalTipoc" name="ModalTipoc" />
										<label><i class="fa fa-money"></i>&nbsp;<?php echo lang('Crédito Máximo'); ?></label>
									</div>
									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="ModalEdoc" id="ModalEdoc">
										<label class="form-check-label" for="ModalEdoc">
											<?php echo lang('Crédito Permitido'); ?>
										</label>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-4 p-1">
								<div class="col">
									<div class="form-floating">
										<input type="text" class="form-control" id="ModalGiro" name="ModalGiro" />
										<label><i class="fa fa-list-alt"></i>&nbsp;<?php echo lang('Giro'); ?></label>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-6 col-lg-4 p-1">
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
										<input type="text" class="form-control" id="ModalCiudad" name="ModalCiudad" />
										<label><i class="fa fa-map-marker"></i>&nbsp;<?php echo lang('Ciudad'); ?></label>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-4 p-1">
								<div class="col">
									<div class="form-floating">
										<input type="text" class="form-control" id="ModalCom" name="ModalCom" onclick="comuna()" readonly />
										<label><i class="fa fa-map-marker"></i>&nbsp;<?php echo lang('Comuna'); ?></label>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-4 p-1">
								<div class="col">
									<div class="form-floating">
										<input type="text" class="form-control" id="ModalPro" name="ModalPro" onclick="comuna()" readonly />
										<label><i class="fa fa-map-marker"></i>&nbsp;<?php echo lang('Provincia'); ?></label>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-4 p-1">
								<div class="col">
									<div class="form-floating">
										<input type="text" class="form-control" id="ModalReg" name="ModalReg" onclick="comuna()" readonly />
										<label><i class="fa fa-map-marker"></i>&nbsp;<?php echo lang('Region'); ?></label>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-outline-secondary px-1" type="button" id='boton1' data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?></button>
				<button class="btn btn-outline-primary px-1" type="button" id='boton2' onclick="guardar();"><i class="fa fa-save"></i> <?php echo lang('Guardar'); ?> </button>
			</div>
		</div>
	</div>
</div>

<div id="apps-modal2y2" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4><?php echo lang('Comuna'); ?></h4>
				<div class="card-actions">
					<div class='float-end'>
						<button data-bs-dismiss="modal" onclick='$("#apps-modal").modal("show")' class='btn-close' type="button"></button>
					</div>
				</div>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<div class="d-flex justify-content-end text-end gap-2" id="spinner_load_DatatableConCOM">
						<div><strong class="text-primary fs-6"><?php echo lang('Cargando'); ?></strong></div>
						<div class="spinner-grow text-primary fs-6 " role="status" aria-hidden="true" style="width: 1.3rem !important; height: 1.3rem !important;"></div>
					</div>
					<table class="table table-hover table-striped nowrap" id="DatatableConCOM" cellspacing="0" style="width:100%">
						<thead>
							<tr>
								<th><?php echo lang('Comuna Nombre'); ?> </th>
								<th><?php echo lang('Acción'); ?> </th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="apps-delet" class="modal fade" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header bg-danger text-light">
				<h5 class="modal-title"><i class="fa fa-trash"></i> <?php echo lang('Borrar Registro'); ?></h5>
				<button data-bs-dismiss="modal" class="btn-close" type="button"></button>
			</div>
			<div class="modal-body">
				<div id="alertaerrorenproducto3"></div>
				<span id="CodeDel" class="d-none"></span>
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
				<button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal"><?php echo lang('Cancelar'); ?></button>
				<button class="btn btn-outline-danger" type="button" onclick="alertaborrar2();"><i class="fa fa-trash"></i> <?php echo lang('Si, bórralo!'); ?></button>
			</div>
		</div>
	</div>
</div>

<div class="app-ui-mask-modal"></div>

<span id="Temporal" class="d-none"></span>
<div id="map" style='display:none'></div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRK6GynrUmaQmP2uwp90hzKNXOPpjk-mY&callback=initMap&callback=initMap&libraries=&v=weekly" async></script>
<script src="jsdev/beneficiariosnew.js?v=<? echo random_int(1, 9999999); ?>"></script>
<script>
	const EstadoCredito = <?php echo $EstadoCredito; ?>;
	window.onload = function() {
		CargarDatatable();
	}

	const Utils = {
		"Num001": {
			"title": "<?php echo lang('Falta Información'); ?>",
			"desc": "<?php echo lang('El campo Id Tributario Fiscal no puede estar vacío.'); ?>",
		},
		"Num002": {
			"title": "<?php echo lang('Falta Información'); ?>",
			"desc": "<?php echo lang('El campo Razón Social no puede estar vacío.'); ?>",
		},
		"Num003": {
			"title": "<?php echo lang('Falta Información'); ?>",
			"desc": "<?php echo lang('Debe elegir que tipo de beneficiarios es.'); ?>",
		},
		"Num004": {
			"title": "<?php echo lang('Identificador Fiscal Repetido'); ?>",
			"desc": "<?php echo lang('Este Identificador ya existe.'); ?>",
		},
		"Num005": "<?php echo lang('¿Desea eliminar este beneficiario?'); ?>",
		"Num006": {
			"title": "<?php echo lang('Falta Información'); ?>",
			"desc": "<?php echo lang('El campo del Codigo de Interno no puede estar vacío.'); ?>",
		},
		"Num007": {
			"title": "<?php echo lang('Falta Información'); ?>",
			"desc": "<?php echo lang('El campo de del Teléfono no puede estar vacío.'); ?>",
		},
		"Num008": {
			"title": "<?php echo lang('Error al enviar la información'); ?>",
			"desc": "<?php echo lang('Ha ocurrido un error al enviar la información por favor revise que esté ingresando los datos en los campos correspondientes.'); ?>",
		},
		"Success": {
			"title": "<?php echo lang('Guardado con exito'); ?>",
			"desc": "<?php echo lang('Tu informacion ha sido guardada correctamente.'); ?>",
		},
		"Danger": {
			"title": "<?php echo lang('Error al guardar'); ?>",
			"desc": "<?php echo lang('Se ha producido un error durante el guardado.'); ?>",
		}
	};

	if (document.getElementById("IdPaisAct").innerHTML == "CL") {

		jQuery(document).ready(function() {
			jQuery("#ModalRut").on('input', function(evt) {
				jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
			});
		});

		var input = document.getElementById('ModalRut');
		input.addEventListener('input', function() {
			if (this.value.length > 8)
				this.value = this.value.slice(0, 8);
		})

		function dgv(T) {
			var M = 0,
				S = 1;
			for (; T; T = Math.floor(T / 10))
				S = (S + T % 10 * (9 - M++ % 6)) % 11;
			//return S?S-1:'k';

			document.getElementById('ModalRut2').value = S ? S - 1 : 'k';
		}
	}
</script>