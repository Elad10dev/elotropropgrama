<?php
$sql = "SELECT a.* ,b.Descripcion as ModuloName , b.Link as Archivo FROM PosUpOpciones a   
    inner join PosUpModulo b on a.IdModulo=b.IdModulo
    where a.IdModulo='" . $_SESSION["ModuloActual"] . "' and a.Link='" . $_SESSION['opcion'] . "'  limit 1";

if ($resu = mysqli_query($conn, $sql)) {
	while ($rw = mysqli_fetch_assoc($resu)) {
		$nameopcion = lang(str_replace('2', '', str_replace(' R', '', str_replace(' -S', '', $rw['Descripcion']))));
		$namemodulo = str_replace('2', '', str_replace(' R', '', str_replace(' -S', '', $rw['ModuloName'])));
		$archimodulo = $rw['Archivo'];
?>
		<header id="header">
			<div class="container">
				<div class="row align-items-center pt-1.5">
					<div class="col-12 col-md-8 text-center text-md-start ">
						<h1><i><img src="/img/<?php echo $rw['Img']; ?>" width="24" height="24"></i> <?php echo $nameopcion; ?> </h1>
					</div>
					<div class="col-12 col-md-4 text-center text-md-start">
						<small><?php echo lang($rw['ExplicacionOpcion']); ?></small>
						<?php if ($rw['LinkVideo'] <> '') { ?>
							<span type='button' class='btn btn-outline-primary' onclick="getVideo(`<?php echo $rw['LinkVideo']; ?>`,`<?php echo $nameopcion; ?>`)"> <img src="/img/video.png" width="36" height="36"> </span>
						<?php } ?>
					</div>
				</div>
			</div>
		</header>
<?php
	}
	mysqli_free_result($resu);
}


$CantAlmacenes = 0;
$homologacion = 0;
$cantReg = 0;

$sqlcompany = "SELECT cantAlmacen,homologacion FROM PosUpCompany where Id='" . $_SESSION['CompanyActual'] . "'";
if ($params = mysqli_query($conn, $sqlcompany)) {
	while ($pam = mysqli_fetch_assoc($params)) {
		$CantAlmacenes = $pam['cantAlmacen'];
		$homologacion = $pam['homologacion'];
	}
	mysqli_free_result($params);
}

$query3 = "SELECT count(IdAlm) as cant FROM PosUpAlmacen a INNER JOIN PosUpUbicacion b on a.IdUbi = b.IdUbi and a.idCompany= b.idCompany where a.IdCompany=" . $_SESSION["CompanyActual"];
if ($result3 = mysqli_query($conn, $query3)) {
	while ($row3 = mysqli_fetch_assoc($result3)) {
		$cantReg = $row3['cant'];
	}
	mysqli_free_result($result3);
}

$button = "";
if ($cantReg < $CantAlmacenes or $CantAlmacenes == 0) $button .= "<button class='btn btn-outline-primary m-1 px-1' id='btn-agg' type='button' title='" . lang("Agregar") . "' onclick='agregaralm()'><i class='fa fa-plus'></i> " . lang("Agregar") . "</button>";

$ModalIdUbi = "";
$query = "SELECT IdUbi,Nombre FROM PosUpUbicacion where IdCompany= " . $_SESSION["CompanyActual"];
if ($result = mysqli_query($conn, $query)) {
	while ($row = mysqli_fetch_assoc($result)) {
		$ModalIdUbi .= "<option value='" . $row['IdUbi'] . "'>" . $row['Nombre'] . "</option>";
	}
	mysqli_free_result($result);
}

?>
<nav aria-label="breadcrumb">
	<div class="container">
		<ol class="breadcrumb">
			<li class="breadcrumb-item "><a href="app.php?opcion=<?php echo $archimodulo; ?>"><?php echo lang($namemodulo); ?></a></li>
			<li class="breadcrumb-item active"><?php echo lang($nameopcion); ?></li>
		</ol>
	</div>
</nav>

<div class="container" style='padding-bottom:78px;'>
	<div id="alertaerrorenproducto2"></div>
	<div class="table-responsive">

		<table id="ServerSideTable" class="table table-striped table-hover" cellspacing="0" style="width:100%">
			<thead>
				<tr>
					<th class=" text-center ">#</th>
					<th class=" "><?php echo lang('Nombre'); ?> <?php echo ($_SESSION["userperfil"] <= 2000 || $_SESSION["userperfil"] == "2055" || $_SESSION["userperfil"] == "2054" || $_SESSION["userperfil"] == "2053" ? $button : ""); ?> </th>
					<th style="display:none;"><?php echo lang('Nombre'); ?></th>
					<th class=" "><?php echo lang('Tipo'); ?></th>
					<th class=" "><?php echo lang('Ubicación'); ?></th>
				</tr>
			</thead>
		</table>
	</div>
</div>

<div id="apps-modal" class="modal fade" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 id="titlemodal" class="modal-title"><?php echo lang('Editar Almacén'); ?></h5>
				<button data-bs-dismiss="modal" class='btn-close' type="button"></button>
			</div>
			<div class="modal-body p-1">
				<div id="alertaerrorenproducto"></div>
				<input type="hidden" id="ModalIdAlm" name="ModalIdAlm" />
				<input type="hidden" id="ModalIdAlm2" name="ModalIdAlm2" />
				<div class="row">
					<div class="col-12 col-lg-3 my-1">
						<div class="form-floating">
							<input type="text" class="form-control" id="ModalNombre" name="ModalNombre" />
							<label for="ModalNombre"><i class="fa fa-archive"></i>&nbsp;<?php echo lang('Nombre'); ?></label>
						</div>
					</div>

					<div class="col-12 col-lg-3 my-1">
						<div class="form-floating">
							<select class="form-select" name="ModalTipo" id="ModalTipo">
								<option value="0"><?php echo lang('Inhabilitado para Transacciones'); ?></option>
								<option value="1"><?php echo lang('Venta'); ?></option>
								<option value="2"><?php echo lang('Almacenaje'); ?></option>
								<option value="3"><?php echo lang('Almacén de Producción'); ?></option>
								<option value="4"><?php echo lang('Almacén para comprometer inventario'); ?></option>
							</select>
							<label for="ModalTipo"><i class="fa fa-archive"></i>&nbsp;<?php echo lang('Tipo'); ?></label>
						</div>
					</div>

					<div class="col-12 col-lg-3 my-1">
						<div class="form-floating">
							<select class="form-select" id="ModalIdUbi" name="ModalIdUbi">
								<?php echo $ModalIdUbi
								?>
							</select>
							<label><i class="fa fa-map-marker"></i>&nbsp;<?php echo lang('Ubicación'); ?></label>
						</div>
					</div>
					<div class="col-12 col-lg-3 my-1">
						<div class="col">
							<div class="form-floating">
								<input type="text" class="form-control text-end" id="ModalCodigoContable" name="ModalCodigoContable" />
								<label><i class="fa fa-hashtag"></i>&nbsp;<?php echo lang('Código Contable'); ?></label>
							</div>
						</div>
					</div>

					<div class="col-12 col-lg-6 my-1">
						<div class="form-floating">
							<select class="form-select" id="ImpFac" name="ImpFac">
								<option value="0"><?php echo lang('Hoja Completa') ?></option>
								<option value="1"><?php echo lang('Media Hoja') ?></option>
								<option value="3"><?php echo lang('Ticket 58mm') ?> </option>
								<option value="4"><?php echo lang('Ticket 80mm') ?></option>
							</select>
							<label><i class="fa fa-print"></i>&nbsp;<?php echo lang('Impresión Factura') ?></label>
						</div>
					</div>

					<div class="col-12 col-lg-6 my-1">
						<div class="form-floating">
							<input type="text" class="form-control" id="FormaFac" name="FormaFac" />
							<label><i class="fa fa-print"></i>&nbsp;<?php echo lang('Impresión Factura Personalizada') ?></label>
						</div>
					</div>

					<div class="col-12 col-lg-6 my-1" style="<?php echo $homologacion == "1" ? 'display: none;' : ''; ?>">
						<div class="form-floating">
							<select class="form-select" id="impBoleta" name="impBoleta">
								<option value="0"><?php echo lang('Hoja Completa') ?></option>
								<option value="1"><?php echo lang('Media Hoja') ?></option>
								<option value="3"><?php echo lang('Ticket 58mm') ?> </option>
								<option value="4"><?php echo lang('Ticket 80mm') ?></option>
							</select>
							<label><i class="fa fa-print"></i>&nbsp;<?php echo lang('Impresión Boleta') ?></label>
						</div>
					</div>

					<div class="col-12 col-lg-6 my-1" style="<?php echo $homologacion == "1" ? 'display: none;' : ''; ?>">
						<div class="form-floating">
							<input type="text" class="form-control" id="FormaBol" name="FormaBol" />
							<label><i class="fa fa-print"></i>&nbsp;<?php echo lang('Impresión Boleta Personalizada') ?></label>
						</div>
					</div>

					<div class="col-12 col-lg-6 my-1" style="<?php echo $homologacion == "1" ? 'display: none;' : ''; ?>">
						<div class="form-floating">
							<select class="form-select" id="ImpGuia" name="ImpGuia">
								<option value="0"><?php echo lang('Hoja Completa') ?></option>
								<option value="1"><?php echo lang('Media Hoja') ?></option>
								<option value="3"><?php echo lang('Ticket 58mm') ?> </option>
								<option value="4"><?php echo lang('Ticket 80mm') ?></option>
							</select>
							<label><i class="fa fa-print"></i>&nbsp;<?php echo lang('Impresión Guía') ?></label>
						</div>
					</div>

					<div class="col-12 col-lg-6 my-1" style="<?php echo $homologacion == "1" ? 'display: none;' : ''; ?>">
						<div class="form-floating">
							<input type="text" class="form-control" id="FormaGuia" name="FormaGuia" />
							<label><i class="fa fa-print"></i>&nbsp;<?php echo lang('Impresión Guía Personalizada') ?></label>
						</div>
					</div>

					<div class="col-12 col-lg-6 my-1" style="<?php echo $homologacion == "1" ? 'display: none;' : ''; ?>">
						<div class="form-floating">
							<select class="form-select" id="ImpNotaEnt" name="ImpNotaEnt">
								<option value="0"><?php echo lang('Hoja Completa') ?></option>
								<option value="1"><?php echo lang('Media Hoja') ?></option>
								<option value="3"><?php echo lang('Ticket 58mm') ?> </option>
								<option value="4"><?php echo lang('Ticket 80mm') ?></option>
							</select>
							<label><i class="fa fa-print"></i>&nbsp;<?php echo lang('Impresión Nota de Entrega') ?></label>
						</div>
					</div>

					<div class="col-12 col-lg-6 my-1" style="<?php echo $homologacion == "1" ? 'display: none;' : ''; ?>">
						<div class="form-floating">
							<input type="text" class="form-control" id="FormaNote" name="FormaNote" />
							<label><i class="fa fa-print"></i>&nbsp;<?php echo lang('Impresión Nota de Entrega Personalizada') ?></label>
						</div>
					</div>

					<div class="col-12 col-lg-6 my-1">
						<div class="form-floating">
							<select class="form-select" id="ImpMovInventario" name="ImpMovInventario">
								<option value="0"><?php echo lang('Hoja Completa') ?></option>
								<option value="1"><?php echo lang('Media Hoja') ?></option>
								<option value="3"><?php echo lang('Ticket 58mm') ?> </option>
								<option value="4"><?php echo lang('Ticket 80mm') ?></option>
							</select>
							<label><i class="fa fa-print"></i>&nbsp;<?php echo lang('Impresión Movimiento de Inventario') ?></label>
						</div>
					</div>

					<div class="col-12 col-lg-6 my-1">
						<div class="form-floating">
							<input type="text" class="form-control" id="FormaMovi" name="FormaMovi" />
							<label><i class="fa fa-print"></i>&nbsp;<?php echo lang('Impresión Movimiento de Inventario Personalizada') ?></label>
						</div>
					</div>

					<div class="col-12 col-lg-6 my-1">
						<div class="form-floating">
							<input type="text" class="form-control" id="FormPedid" name="FormPedid" />
							<label><i class="fa fa-print"></i>&nbsp;<?php echo lang('Impresión Pedido Personalizada') ?></label>
						</div>
					</div>

					<div class="col-12 col-lg-6 my-1">
						<div class="form-floating">
							<input type="text" class="form-control" id="FormPresu" name="FormPresu" />
							<label><i class="fa fa-print"></i>&nbsp;<?php echo lang('Impresión Presupuesto Personalizada') ?></label>
						</div>
					</div>
					<div class="col-12  my-1">
						<div class="form-floating">
							<input type="text" class="form-control" id="FormOC" name="FormOC" />
							<label><i class="fa fa-print"></i>&nbsp;<?php echo lang('Impresión Orden de Compra') ?></label>
						</div>
					</div>
					<div class="col-12 my-1">
						<?php
						$ModalDeposito22 = "";
						$query = "SELECT IdAtt, Nombre FROM posupzonaatt WHERE IdCompany =" . $_SESSION["CompanyActual"] . "";
						if ($result = mysqli_query($conn, $query)) {
							while ($row = mysqli_fetch_assoc($result)) {
								$ModalDeposito22 .= "<option value='" . $row['IdAtt'] . "'>" . $row['Nombre'] . "</option>";
							}
							mysqli_free_result($result);
						}
						?>
						<div class="form-floating">
							<select class="form-select" id="ModalAtencion" name="ModalAtencion">
								<option value="0"><?php echo lang("Seleccionar"); ?></option>
								<?php
								echo $ModalDeposito22;
								?>
							</select>
							<label><i class="fa fa-archive"></i> <?php echo lang('Zona de Atencion'); ?></label>
						</div>
					</div>
					<div class="col-12 col-lg-4  my-1">
						<div class="form-floating">
							<input type="text" class="form-control" id="CasheAliado" name="CasheAliado" />
							<label><i class="fa fa-print"></i>&nbsp;<?php echo lang('Cashea Aliado') ?></label>
						</div>
					</div>
					<div class="col-12 col-lg-4  my-1">
						<div class="form-floating">
							<input type="text" class="form-control" id="CasheApikey" name="CasheApikey" />
							<label><i class="fa fa-print"></i>&nbsp;<?php echo lang('Cashea Api-key') ?></label>
						</div>
					</div>
					<div class="col-12 col-lg-4  my-1">
						<div class="form-floating">
							<select name="CasheaPrecio" id="CasheaPrecio" class="form-select">
								<?php

								$sql = "SELECT LitP01,LitP02,LitP03,LitP04,LitP05,LitP06,LitP07,LitP08,LitP09,LitP10 FROM PosUpCompany 
where Id=" . $_SESSION["CompanyActual"] . "";
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
									}
								}
								?>
								<option value="1" selected><?php echo (trim($LitP01) !== "" ? $LitP01 : lang("Precio") . " 1"); ?></option>
								<option value="2"><?php echo (trim($LitP02) !== "" ? $LitP02 : lang("Precio") . " 2"); ?></option>
								<option value="3"><?php echo (trim($LitP03) !== "" ? $LitP03 : lang("Precio") . " 3"); ?></option>
								<option value="4"><?php echo (trim($LitP04) !== "" ? $LitP04 : lang("Precio") . " 4"); ?></option>
								<option value="5"><?php echo (trim($LitP05) !== "" ? $LitP05 : lang("Precio") . " 5"); ?></option>
								<option value="6"><?php echo (trim($LitP06) !== "" ? $LitP06 : lang("Precio") . " 6"); ?></option>
								<option value="7"><?php echo (trim($LitP07) !== "" ? $LitP07 : lang("Precio") . " 7"); ?></option>
								<option value="8"><?php echo (trim($LitP08) !== "" ? $LitP08 : lang("Precio") . " 8"); ?></option>
								<option value="9"><?php echo (trim($LitP09) !== "" ? $LitP09 : lang("Precio") . " 9"); ?></option>
								<option value="10"><?php echo (trim($LitP10) !== "" ? $LitP10 : lang("Precio") . " 10"); ?></option>
							</select>
							<label><i class="fa fa-print"></i>&nbsp;<?php echo lang('Cashea Precio') ?></label>
						</div>
					</div>


				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-outline-secondary px-1 m-1" id="boton1" type="button" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?></button>
				<button class="btn btn-outline-primary px-1 m-1" id="boton2" type="button" onclick="guardar();"><i class="fa fa-save"></i> <?php echo lang('Guardar'); ?> </button>
			</div>
		</div>
	</div>
</div>

<div id="apps-delet" class="modal fade" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header bg-danger text-light">
				<h5 class="modal-title"><?php echo lang('Borrar Registro'); ?></h5>
				<button data-bs-dismiss="modal" class='btn-close' type="button"></button>
			</div>
			<div class="modal-body">
				<div id="alertaerrorenproducto5"></div>
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
				<button class="btn btn-outline-secondary m-1 px-1" type="button" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang('Cancelar'); ?></button>
				<button class="btn btn-outline-danger m-1 px-1" type="button" onclick="alertaborrar2();"><i class="fa fa-trash"></i> <?php echo lang('Si, bórralo!'); ?></button>
			</div>
		</div>
	</div>
</div>

<div id="apps-copiar" class="modal fade" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header bg-primary text-light">
				<h5 class="modal-title"><i class="fa fa-clone"></i> <?php echo lang('Copiar Registro'); ?></h5>
				<button data-bs-dismiss="modal" class='btn-close' type="button"></button>
			</div>
			<div class="modal-body">
				<span id="CodeDelCopiar" class="d-none"></span>
				<div class="row float-center text-center">
					<div class="col-12">
						<img src="img/warningtriangle.gif" style="width: 128px;">
					</div>
					<div class="col-12">
						<h3><strong><?php echo lang("¿Esta Seguro?"); ?></strong></h3>
					</div>
					<div class="col-12"><?php echo lang("¿Desea copiar el registro") . " <strong id='descopiar'></strong>" . "?"; ?></div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-outline-secondary m-1 px-1" type="button" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang('Cancelar'); ?></button>
				<button class="btn btn-outline-primary m-1 px-1" type="button" onclick="ClonarReg2();"><i class="fa fa-clone"></i> <?php echo lang('Si, Copialo!'); ?></button>
			</div>
		</div>
	</div>
</div>

<span class='d-none' id="VerifAlm"></span>
<script>
	const Success = {
		title: "<?php echo lang('Guardado con exito'); ?>",
		desc: "<?php echo lang('Tu informacion ha sido guardada correctamente.'); ?>",
	};

	const Danger = {
		title: "<?php echo lang('Error al guardar'); ?>",
		desc: "<?php echo lang('Se ha producido un error durante el guardado.'); ?>",
	};

	const Num001 = {
		title: "<?php echo lang('Falta Información'); ?>",
		desc: '<?php echo lang("El Campo Nombre no puede estar vacío."); ?>',
	};

	const Num002 = {
		title: "<?php echo lang('Falta Información'); ?>",
		desc: '<?php echo lang("El Campo Tipo no puede estar vacío."); ?>',
	};

	const Num003 = {
		title: "<?php echo lang('Falta Información'); ?>",
		desc: '<?php echo lang("Cree o elija una ubicación valida."); ?>',
	};

	const Num004 = {
		title: "<?php echo lang('Editar Almacén'); ?>",
		desc: '<?php echo lang("Editar Almacén"); ?>',
	};

	const Num005 = {
		title: "<?php echo lang('Guardar Almacén'); ?>",
		desc: '<?php echo lang("Guardar Almacén"); ?>',
	};

	const Num006 = {
		title: "<?php echo lang('Registro Asociado'); ?>",
		desc: '<?php echo lang("Este registro esta asociado, solo se puede inactivar."); ?>',
	};

	const Num007 = {
		title: "<?php echo lang('Limite de almacenes alcanzado'); ?>",
		desc: '<?php echo lang("Ha alcanzado el limite de almacenes que permite su plan."); ?>',
	};
</script>
<script src="jsdev/almacennew.js?v=<? echo random_int(1, 9999999); ?>"></script>
<span id="Temporal" class="d-none"></span>
<script>
	window.onload = function() {
		MuestraProd();
	}
</script>
<div class="app-ui-mask-modal"></div>