<?php
$sql = "SELECT ScriptDownloadProd,LitP01,LitP02,LitP03,LitP04,LitP05,LitP06,LitP07,LitP08,LitP09,LitP10,LitCosto FROM PosUpCompany 
where Id=" . $_SESSION["CompanyActual"] . "";
if ($result = mysqli_query($conn, $sql)) {
	while ($row = mysqli_fetch_assoc($result)) {
		$ScriptDownloadProd = $row["ScriptDownloadProd"];
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
$c0 = "0";
$IdAlmAsign = "";

$query = "SELECT c0,IdAlmAsign FROM posupusers WHERE IdCompany=" . trim($_SESSION["CompanyActual"]) . " and Login = '" . $_SESSION["userlogin"] . "'";
if ($result = mysqli_query($conn, $query)) {
	while ($row = mysqli_fetch_assoc($result)) {
		$c0 = $row["c0"];
		$IdAlmAsign = $row["IdAlmAsign"];
	}
	mysqli_free_result($result);
}
$EnvioFamilia = "";
$ff = 0;
$query = "SELECT a.IdVarios,if(a.IdVariosPadre=0,a.ITEM,concat(b.ITEM,' > ', a.ITEM)) AS ITEM FROM PosUpvarios a
left join PosUpvarios b on a.IdCompany=b.IdCompany and a.IdVariosPadre = b.IdVarios and a.TIPOITEM = b.TIPOITEM and b.TIPOITEM = 2
WHERE a.IdCompany=" . $_SESSION["CompanyActual"] . " and a.TIPOITEM = 2
order by if(a.IdVariosPadre=0,a.ITEM,concat(b.ITEM,' > ', a.ITEM)) asc";
if ($result = mysqli_query($conn, $query)) {
	while ($row = mysqli_fetch_assoc($result)) {
		$ff = $ff + 1;
		if ($ff == 1) {
			$Familia = trim($row['IdVarios']);
		}
		$EnvioFamilia .= "<option value='" . trim($row['IdVarios']) . "'>" . trim($row['ITEM']) . "</option>";
	}
	mysqli_free_result($result);
}

$EnvioMarca = "";
$query = "SELECT idmarca,nombre FROM PosUpc_marcas WHERE IdCompany=" . $_SESSION["CompanyActual"] . " order by nombre asc";
if ($result = mysqli_query($conn, $query)) {
	while ($row = mysqli_fetch_assoc($result)) {
		$EnvioMarca .= "<option value='" . trim($row['idmarca']) . "'>" . trim($row['nombre']) . "</option>";
	}
	mysqli_free_result($result);
}
$option = '<option value="*">' . lang("Seleccionar Almacen") . '</option>';
$query = "SELECT IdAlm,Nombre FROM PosUpAlmacen WHERE IdCompany=" . $_SESSION["CompanyActual"];
if ($result = mysqli_query($conn, $query)) {
	while ($row = mysqli_fetch_assoc($result)) {
		$option .= "<option value='" . $row["IdAlm"] . "'>" . $row['Nombre'] . "</option>";
	}
}



$buscarubicacion = "";


if ($IdAlmAsign !== "" && $_SESSION['userperfil'] > 2000) {
	$buscarubicacion .= " and IdAlm in (" . $IdAlmAsign . ")";
} else if ($_SESSION["sucursal"] !== "0") {
	$buscarubicacion .= " and IdUbi='" . $_SESSION["sucursal"] . "'";
	$ubicacion = "";
}

$EnvioAlmacen = "";

$query = "SELECT IdAlm,Nombre FROM posupalmacen WHERE IdCompany=" . $_SESSION["CompanyActual"] . " " . $buscarubicacion;
if ($result = mysqli_query($conn, $query)) {
	while ($row = mysqli_fetch_assoc($result)) {
		$EnvioAlmacen .= '<option value="' . trim($row['IdAlm']) . '">' . trim($row['Nombre']) . '</option>';
	}
	mysqli_free_result($result);
}


$EnvioZonaAtencion = "";

$query = "SELECT a.IdAtt,a.Nombre FROM posupzonaatt a inner join posupalmacen b on b.IdAtt = a.IdAtt and b.IdCompany = a.IdCompany
WHERE a.IdCompany=" . $_SESSION["CompanyActual"] . " " . $buscarubicacion . " group by a.IdAtt";
if ($result = mysqli_query($conn, $query)) {
	while ($row = mysqli_fetch_assoc($result)) {
		$EnvioZonaAtencion .= '<option value="' . trim($row['IdAtt']) . '">' . trim($row['Nombre']) . '</option>';
	}
	mysqli_free_result($result);
}
$EnvioUbicacion = "";

$query = "SELECT IdUbi,Nombre FROM PosUpUbicacion WHERE IdCompany=" . $_SESSION["CompanyActual"] . $buscarubicacion;
if ($result = mysqli_query($conn, $query)) {
	while ($row = mysqli_fetch_assoc($result)) {
		$EnvioUbicacion .= "<option value='" . trim($row['IdUbi']) . "'>" . trim($row['Nombre']) . "</option>";
	}
	mysqli_free_result($result);
}

$Familia = "";
$ModalIdfamilia = "";
$ModalIdfamiliaSSpan = "";
$ModalIdfamiliaSpan = "";
$ff = 0;
$query = "SELECT a.IdVarios,if(a.IdVariosPadre=0,a.ITEM,concat(b.ITEM,' > ', a.ITEM)) AS ITEM,a.esmedida FROM PosUpvarios a
					left join PosUpvarios b on a.IdCompany=b.IdCompany and a.IdVariosPadre = b.IdVarios and a.TIPOITEM = b.TIPOITEM and b.TIPOITEM = 2
					WHERE a.IdCompany=" . $_SESSION["CompanyActual"] . " and a.TIPOITEM = 2
					order by if(a.IdVariosPadre=0,a.ITEM,concat(b.ITEM,' > ', a.ITEM)) asc";
if ($result = mysqli_query($conn, $query)) {
	while ($row = mysqli_fetch_assoc($result)) {
		$ff++;
		if ($ff == 1) $Familia = trim($row['IdVarios']);
		$ModalIdfamilia .= "<option value='" . trim($row['IdVarios']) . "' >" . trim($row['ITEM']) . " </option>";
		$ModalIdfamiliaSpan .= "<span style='display:none;' id='ModalIdfamiliaSpan" . $row['IdVarios'] . "'>" . $row["esmedida"] . "</span>";
		$ModalIdfamiliaSSpan .= "<span style='display:none;' id='ModalIdfamiliaSSpan" . $row['IdVarios'] . "'>" . $row["esmedida"] . "</span>";
	}
	mysqli_free_result($result);
}
$SelectorAlmacen = "";
$query = "SELECT IdAlm,Nombre FROM PosUpAlmacen WHERE IdCompany=" . $_SESSION["CompanyActual"];
if ($result = mysqli_query($conn, $query)) {
	while ($row = mysqli_fetch_assoc($result)) {
		$SelectorAlmacen .= "<option value='" . trim($row['IdAlm']) . "'>" . trim($row['Nombre']) . "</option>";
	}
	mysqli_free_result($result);
}
$response = "	
<select class='form-select' id='SelectorAlmacen' onchange='HistoricoSerial2();'>
	<option value='*'>" . lang("Todos") . "</option>
	" . $SelectorAlmacen . "
</select>
<label><i class='fa fa-archive'></i> " . lang("Almacén") . "</label>
";

if ($_SESSION["Ec"] == 0) {
	$Titulo = lang('Productos');
} else {
	$Titulo = lang('Servicios');
}

?>
<style>
	@media print {
		.modal-backdrop {
			background: none !important;
		}
	}
</style>

<div class="fixed-top " id='elfixed' style='display:none; padding-top:50px;  z-index:10000;'>
	<div class="col-12 col-sm-6 col-md-5 col-lg-4 col-xl-3 float-end">
		<div id="valida" class="alert alert-danger" role="alert" style="display:none;">
			<span id='contenido'> </span>
		</div>
	</div>
</div>
<header id="header">
	<div class="container">
		<div class="row p-0 m-0">
			<div class="col-12 col-lg-8">
				<div>
					<h1><i><img src="/img/producto.png" width="22" height="22"></i> <?php echo $Titulo; ?> </h1>
				</div>
				<div><small><?php echo lang('Cadenas que contienen información acerca del entorno para el sistema y el usuario que ha iniciado sesión en ese momento'); ?></small></div>
			</div>

			<div class="col-12 col-lg-4 text-end d-flex">
				<button class='btn btn-light fs-6 p-1' type='button' data-bs-toggle='offcanvas' data-bs-target='#demo'><i class='fa fa-filter fs-3'></i> <br> <?php echo lang("Filtros"); ?></button>
				<div class="bg-light text-dark d-flex justify-content-between fw-bold w-100 align-items-center px-2 border-2 border-dark" style="border-radius: 0.5rem; <?php echo ($_SESSION['userperfil'] > 2000 ? 'display: none !important;' : ''); ?>">
					<div>
						<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-archive-fill" viewBox="0 0 16 16">
							<path d="M12.643 15C13.979 15 15 13.845 15 12.5V5H1v7.5C1 13.845 2.021 15 3.357 15h9.286zM5.5 7h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1zM.8 1a.8.8 0 0 0-.8.8V3a.8.8 0 0 0 .8.8h14.4A.8.8 0 0 0 16 3V1.8a.8.8 0 0 0-.8-.8H.8z" />
						</svg>
						Stock Total s/Filtro
					</div>
					<div id="CantMaxStockAV"></div>
				</div>
			</div>
		</div>
	</div>
</header>
<nav aria-label="breadcrumb" <?php echo ($_GET && isset($_GET['frame']) && $_GET['frame'] == '1' ? "style='display:none !important'" : ""); ?>>
	<div class="container d-flex justify-content-between">
		<ol class="breadcrumb">
			<li class="breadcrumb-item "><a href="app.php?opcion=configurador.php"><?php echo lang('Configurador'); ?></a></li>
			<li class="breadcrumb-item "><a href="app.php?opcion=catalogo.php"><?php echo lang('Catálogo'); ?></a></li>
			<li class="breadcrumb-item active"><?php echo $Titulo; ?></li>
		</ol>
		<div class="d-flex justify-content-end text-end gap-2" id="spinner_load">
			<div><strong class="text-primary fs-6"><?php echo lang('Cargando'); ?></strong></div>
			<div class="spinner-grow text-primary fs-6 ms-auto" role="status" aria-hidden="true" style="width: 1.3rem !important; height: 1.3rem !important;"></div>
		</div>
	</div>
</nav>
<span style="display:none;" id='jsonpedido'>
</span>
<div class="container" id='option' style='padding-bottom:78px;'>
	<div class="border border-3 border-success p-2 rounded-2" id="alertaerrorenproducto2" style="display:none;"><strong><i class="fa fa-check-circle text-success"></i> <?php echo lang('Guardado con exito'); ?></strong><br><small><?php echo lang('Tu informacion ha sido guardada correctamente.'); ?></small></div>
	<div class="row ">
		<div class="table-responsive">
			<table id="ServerSideTable" class="table table-striped table-hover" cellspacing="0" style="width:100%">
				<thead>
					<tr>
						<th><?php echo lang('Descripción') . " " . ($_SESSION["userperfil"] <= 2000 || $_SESSION["userperfil"] === "2055" || $_SESSION["userperfil"] == "2054" || $_SESSION["userperfil"] == "2053" || $_SESSION["userperfil"] === "3200" || $_SESSION["userperfil"] === "2710"  || $_SESSION["userperfil"] === "2080" || $_SESSION["userperfil"] === "2060" || ($_SESSION["userlogin"] === "DULCE" && $_SESSION["CompanyActual"] === "1125") ? '<button class="btn btn-outline-primary px-1 m-1" onclick="recibir(0);"><span class="fa fa-plus"></span> ' . lang('Agregar') . ' </button>' : ''); ?></th>
						<th <?php echo ($_SESSION["Ec"] == '9' ? "style='display:none;'" : "") ?>><?php echo lang('Existencia'); ?></th>
						<th style="min-width: 30% !important;"><?php echo lang('Montos') . " " . ($_SESSION["VisualizaPrecio"] === "1" ? lang("Con Impuesto") : lang("Sin Impuesto")); ?></th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

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
				<select class="form-select" id="OrderBy" onchange="MuestraProd();">
					<option value="CodBasico"><?php echo lang("Código"); ?></option>
					<option value="Nombre"><?php echo lang("Descripción"); ?></option>
					<option value="CodBar"><?php echo lang("Código de barras"); ?></option>
					<option value="CodIdAmpliado"><?php echo lang("S.K.U"); ?></option>
				</select>
			</div>
			<div class="col-12 my-1">
				<label class='d-flex gap-2 align-items-center'>
					<i class="fa fa-sort"></i>
					<?php echo lang('Orientación'); ?>
				</label>
				<select class="form-select" id="SortBy" onchange="MuestraProd();">
					<option value="ASC" selected><?php echo lang("Ascendente"); ?></option>
					<option value="DESC"><?php echo lang("Descendente"); ?></option>
				</select>
			</div>

			<div class="col-12 my-1">
				<label class='d-flex gap-2 align-items-center'>
					<i class="fa fa-tags"></i>
					<?php echo lang('Marcas'); ?>
					<div class='form-check'>
						<input class='form-check-input' type='checkbox' id='NotIncludeMarcas' onchange="MuestraProd();">
						<label class='form-check-label'><?php echo lang('No Incluir'); ?></label>
					</div>
				</label>
				<select class="form-select" id="EnvioMarca" onchange="MuestraProd();" style="width:100%; max-height: 100px;" multiple>
					<?php
					echo $EnvioMarca;
					?>
				</select>
			</div>

			<div class="col-12 my-1">
				<label class='d-flex gap-2 align-items-center'>
					<i class="fa fa-archive"></i>
					<?php echo lang('Familia'); ?>
					<div class='form-check'>
						<input class='form-check-input' type='checkbox' id='NotIncludeFamilia' onchange="MuestraProd();">
						<label class='form-check-label'><?php echo lang('No Incluir'); ?></label>
					</div>
				</label>
				<select class="form-select" id="EnvioFamilia" onchange="MuestraProd();" style="width:100%; max-height: 100px;" multiple>
					<?php
					echo $EnvioFamilia;
					?>
				</select>
			</div>

			<div class="col-12">
				<div class="form-floating">
					<select class="form-select" name="EnvioEstado" id="EnvioEstado" onchange="MuestraProd()">
						<option value="*"><?php echo lang("Todos"); ?></option>
						<option value="1" selected><?php echo lang("Activo"); ?></option>
						<option value="0"><?php echo lang("Inactivo"); ?></option>
					</select>
					<label><i class="fa fa-hourglass" aria-hidden="true"></i>&nbsp;<?php echo lang('Estado'); ?></label>
				</div>
			</div>
			<div class="col-12" <?php echo ($_SESSION["Ec"] == '9' ? "style='display:none;'" : "") ?>>
				<div class="form-floating">
					<select class="form-select" name="EnvioPeso" id="EnvioPeso" onchange="MuestraProd()">
						<option value="*"><?php echo lang("Todos"); ?></option>
						<option value="1"><?php echo lang("Por Peso"); ?></option>
						<option value="0"><?php echo lang("Sin Peso"); ?></option>
					</select>
					<label><i class="fa fa-balance-scale" aria-hidden="true"></i>&nbsp;<?php echo lang('Peso'); ?></label>
				</div>
			</div>
			<div class="col-12" <?php echo ($_SESSION["Ec"] == '9' ? "style='display:none;'" : "") ?>>
				<div class="form-floating">
					<select class="form-control " name="VisualExist" id="VisualExist" onchange="MuestraProd()">
						<option value="0"><?php echo lang("Por Almacen"); ?></option>
						<option value="1"><?php echo lang("Por Ubicacion"); ?></option>
						<option value="2"><?php echo lang("Por Zona de Atención"); ?></option>
					</select>
					<label><i class="fa fa-balance-scale" aria-hidden="true"></i>&nbsp;<?php echo lang('Visualizar Existencia'); ?></label>
				</div>
			</div>
			<div class="col-12" style="<?php echo ($_SESSION["Ec"] == '9' ? 'display:none;' : '') ?>">
				<div class="form-check">
					<input class="form-check-input" type="checkbox" id="SoloExistencia" name="SoloExistencia" onchange="SoloExistenciaProd();">
					<label class="form-check-label" for="SoloExistencia">
						<?php echo lang('Con Existencias'); ?>
					</label>
				</div>
			</div>
			<div id="MostrarFiltros" style="display: none;">
				<div class="col-12 my-1">
					<label class='d-flex gap-2 align-items-center'>
						<i class="fa fa-archive"></i>
						<?php echo lang('Almacen'); ?>
						<div class='form-check'>
							<input class='form-check-input' type='checkbox' id='NotIncludeAlmacen' onchange="MuestraProd();">
							<label class='form-check-label'><?php echo lang('No Incluir'); ?></label>
						</div>
					</label>
					<select class="form-select" id="EnvioAlmacen" onchange="MuestraProd();" style="width:100%; max-height: 100px;" multiple>
						<?php
						echo $EnvioAlmacen;
						?>
					</select>
				</div>
				<div class="col-12 my-1">
					<label class='d-flex gap-2 align-items-center'>
						<i class="fa fa-archive"></i>
						<?php echo lang('Ubicaciòn'); ?>
						<div class='form-check'>
							<input class='form-check-input' type='checkbox' id='NotIncludeUbicacion' onchange="MuestraProd();">
							<label class='form-check-label'><?php echo lang('No Incluir'); ?></label>
						</div>
					</label>
					<select class="form-select" id="EnvioUbicacion" onchange="MuestraProd();" style="width:100%; max-height: 100px;" multiple>
						<?php
						echo $EnvioUbicacion;
						?>
					</select>
				</div>
				<div class="col-12 my-1">
					<label class='d-flex gap-2 align-items-center'>
						<i class="fa fa-archive"></i>
						<?php echo lang('Zona de Atención'); ?>
						<div class='form-check'>
							<input class='form-check-input' type='checkbox' id='NotIncludeZonaAtencion' onchange="MuestraProd();">
							<label class='form-check-label'><?php echo lang('No Incluir'); ?></label>
						</div>
					</label>
					<select class="form-select" id="EnvioZonaAtencion" onchange="MuestraProd();" style="width:100%; max-height: 100px;" multiple>
						<?php
						echo $EnvioZonaAtencion;
						?>
					</select>
				</div>
			</div>
			<div class="col-12">
				<div class="form-floating">
					<button class="btn btn-outline-dark" style="width: 100%;" data-bs-dismiss="offcanvas" title="<?php echo lang('Seriales'); ?>" data-bs-toggle="modal" data-bs-target="#ModalHistoricoSerial" onclick="HistoricoSerial(0)">
						<i class="fa fa-eye"></i> <?php echo lang('Seriales'); ?>
					</button>
				</div>
			</div>
			<div class="col-12">
				<div class="form-floating">
					<button type="button" class="btn btn-outline-dark" style="width: 100%;" data-bs-dismiss="offcanvas" onclick="OpenModalScan();"><i class="fa fa-barcode"></i> <?php echo lang("Codigo de Barras"); ?></button>
				</div>
			</div>
			<?php if ($_SESSION["userperfil"] <= 2000 || $_SESSION["userperfil"] === "2055" || $_SESSION["userperfil"] == "2054" || $_SESSION["userperfil"] == "2053" || $_SESSION["userperfil"] === "2710" || $_SESSION["userperfil"] === "2080" || $_SESSION["userperfil"] === "2060" || ($_SESSION["userlogin"] === "DULCE" && $_SESSION["CompanyActual"] === "1125")) { ?>

				<div class="col-12">
					<div class="form-floating">
						<button class="btn btn-outline-primary " style="width: 100%;" type="button" data-bs-dismiss="offcanvas" data-bs-toggle="modal" data-bs-target="#Modal-SubirExcel">
							<i class="fa fa-upload"></i> <i class="fa fa-file-excel-o"></i>
						</button>
					</div>
				</div>
				<div class="col-12">
					<div class="form-floating">
						<button class="btn btn-outline-primary" style="width: 100%;" title="<?php echo lang('Descargar'); ?>" onclick="document.getElementById(`formexcel4`).submit();">
							<i class="fa fa-download"></i> <i class="fa fa-file-excel-o"></i>
						</button>
					</div>
				</div>
				<form id="formexcel4" action="<?php echo (trim($ScriptDownloadProd) !== '' ? $ScriptDownloadProd : 'excelnew.php'); ?>" method="post">
					<?php
					$compa = $_SESSION["CompanyActual"];
					$name = "Productos_Posup_Woocomerce";
					$query2 = "SELECT a.CodIdBasico+0 as ID,a.CodIdAmpliado as SKU,a.Descripcion,a.medida,a.PrecioVenta, d.DescripcionLarga,d.DescripcionCorta,upper(b.nombre) as Marca,upper(c.Item) as Categoria,sum(coalesce(h.qty_on_hand,0)) as Existencia
					FROM PosUpProducto a 
					left join PosUpc_marcas b on a.IdCompany=b.IdCompany and a.Marca=b.idmarca 
					left join PosUpvarios c on c.IdCompany=a.IdCompany and c.IdVarios=a.Idfamilia and c.TIPOITEM = 2 
					left join PosUpProductoWeb d on a.IdCompany = d.IdCompany and a.CodIdBasico = d.CodIdBasico 
					left join inv_existencias  h on a.CodIdBasico = h.CodIdBasico
    				and h.IdCompany = a.IdCompany
					where a.IdCompany=" . $_SESSION["CompanyActual"] . " 
					and a.EsCompuesto=" . $_SESSION["Ec"] . " 
					and a.Estado = 1
					GROUP BY a.CodIdBasico
					";
					?>
					<input type="hidden" name="Query" value="<?php echo $query2;       ?>" />
					<input type="hidden" name="Name" value="<?php echo $name; ?>" />
					<input type="hidden" name="vas" value="<?php echo  'ProdWeb'; ?>" />
					<input type="hidden" name="CompanyActual" value="<?php echo  $_SESSION["CompanyActual"]; ?>" />
				</form>
			<?php } ?>
		</div>
		<div class="row" style="font-size: 15px;">
			<button type="button" class="btn fs-2" data-bs-dismiss="offcanvas">
				<?php echo lang("Ocultar"); ?> <i class="fa fa-arrow-right"></i>
			</button>
		</div>
	</div>
</div>

<div class="modal" id="Modal-SubirExcel" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-file-excel-o"></i> <?php echo lang("Subir Productos por excel") ?></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body p-1">
				<div class="border border-3 border-warning p-2 rounded-2" id="alertasubirexcel" style="display:none;"><strong><i class="fa fa-triangle-exclamation text-warning"></i> <?php echo lang('Error en el procesoo'); ?></strong><br><small id="alertasubirexcel2"></small></div>
				<div class="border border-3 border-success p-2 rounded-2" id="alertasubirexcel3" style="display:none;"><strong><i class="fa fa-check-circle text-success"></i> <?php echo lang('Guardado con exito'); ?></strong><br><small><?php echo lang('Todos los productos, familias, impuestos y marcas se han generado exitosamente.'); ?></small></div>
				<div class="row">
					<div class="col-12">
						<div class="input-group">
							<input type="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" name="Archivosubir" id="Archivosubir" class="form-control" onchange="onLoadingExcel();">
							<select name="AlmacenesExcel" id="AlmacenesExcel" class="form-select" style="display:none;">
								<?php
								echo $option;
								?>
							</select>
							<button class="btn btn-outline-primary px-1" type="button" id="ButtonSubirExcel" style="display:none;" onclick="SaveProdExcel();"><i class="fa fa-arrow-down"></i></button>
							<a class="btn btn-outline-primary px-1" href="/Comercio/recursos/prodexcel.xlsx" id="ButtonSubirExcel3"><i class="fa fa-file-excel-o"></i></a>
						</div>
					</div>
					<div class="text-center mb-1" id="CargandoSubirProd" style="display:none;">
						<img src="/img/procesando.gif" width="128" height="128" />
						<h4><?php echo lang("Cargando"); ?></h4>
					</div>
					<div class="col-12" style="max-height:600px; overflow-y: scroll;" id="resujltado">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="apps-modal" class="modal fade" tabindex="-1" role="dialog" data-bs-keyboard="false">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="titlemodal"> <?php echo lang("Editar") . " " . $Titulo; ?> </h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="puesnosecierra();"></button>
			</div>
			<div class="modal-body p-1">
				<div class="border border-3 border-danger p-2 rounded-2" id="alertaerrorenproducto3" style="display:none;"><strong><i class="fa fa-times-circle text-danger"></i> <?php echo lang('Error al guardar'); ?></strong><br><small><?php echo lang('Se ha producido un error durante el guardado.'); ?></small></div>
				<div class="border border-3 border-warning p-2 rounded-2" role="alert" id="alertaerrorenproducto" style="display:none;"></div>
				<ul class="nav nav-tabs" id="myTab" role="tablist">
					<li class="nav-item" role="presentation">
						<button class="nav-link active" id="Informacion2" data-bs-toggle="tab" data-bs-target="#Informacion" type="button" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-file"></i> <?php echo lang('Información'); ?></button>
					</li>
					<?php if ($_SESSION["Ec"] == 0) { ?>
						<li class="nav-item" role="presentation">
							<button class="nav-link" id="Variaciones2" data-bs-toggle="tab" data-bs-target="#Variaciones" type="button" role="tab" aria-controls="contact" aria-selected="false"><i class="fa-paint-brush"></i> <?php echo lang('Variaciones'); ?></button>
						</li>
					<?php } ?>
					<?php if ($_SESSION['userperfil'] <= 2000 || $_SESSION["userperfil"] === "2055" || $_SESSION["userperfil"] == "2054" || $_SESSION["userperfil"] == "2053" || $_SESSION["userperfil"] === "2056" || $_SESSION["userperfil"] === "2710"  || $_SESSION["userperfil"] === "2080" || $_SESSION["userperfil"] === "2060" || ($_SESSION["userlogin"] === "DULCE" && $_SESSION["CompanyActual"] === "1125")) { ?>

						<li class="nav-item " role="presentation">
							<button class="nav-link " id="Costos2" data-bs-toggle="tab" data-bs-target="#Costos" type="button" role="tab" aria-controls="profile" aria-selected="false"><i class="fa fa-money"></i> <?php echo lang('Costos'); ?></button>
						</li>
					<?php } ?>
					<?php
					if ($_SESSION["Ec"] == 0) { ?>
						<li class="nav-item" role="presentation">
							<button class="nav-link" id="Inventario2" data-bs-toggle="tab" data-bs-target="#Inventario" type="button" role="tab" aria-controls="contact" aria-selected="false"><i class="fa fa fa-archive"></i> <?php echo lang('Inventario'); ?></button>
						</li>
					<?php } ?>
				</ul>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane active" id="Informacion">
						<?php if ($_SESSION["Ec"] == 0) { ?>
							<input type="hidden" class="form-control" id="tabla" name="tabla" value="ProductosP1" />
						<?php } ?>
						<?php if ($_SESSION["Ec"] == 9) { ?>
							<input type="hidden" class="form-control" id="tabla" name="tabla" value="ServiciosP1" />
						<?php } ?>
						<input type="hidden" class="form-control" id="companyUser" name="companyUser" value="<?php echo $_SESSION["CompanyActual"]; ?>" />
						<div class="row">
							<div class="col-12 col-lg-6 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalDescripcion" name="ModalDescripcion" pattern="[A-Za-z0-9_-]" />
									<label><i class="fa fa-bars" aria-hidden="true"></i>&nbsp;<?php echo lang('Descripción'); ?></label>
								</div>
							</div>
							<div class="col-12 col-lg-6 my-1">
								<div class="input-group">
									<div class="col">
										<div class="form-floating" id="ReloadMarcaSend">
											<select id="ModalMarca" name="ModalMarca" class="form-select">
												<?php
												$conn = conectar();
												$query = "SELECT idmarca,nombre FROM PosUpc_marcas WHERE IdCompany=" . $_SESSION["CompanyActual"] . " order by nombre asc";
												if ($result = mysqli_query($conn, $query)) {
													while ($row = mysqli_fetch_assoc($result)) {
														$nm = $nm + 1;
												?>
														<option value="<?php echo trim($row['idmarca']); ?>" <?php echo ($nm == 1 ? 'selected' : ''); ?>>
															<?php echo trim($row['nombre']); ?>
														</option>
												<?
														if ($nm == 1) {
															$idmarca = $row["idmarca"];
														}
													}
													mysqli_free_result($result);
												}
												?>
											</select>
											<span id="RegUnoMarca" style="display:none;"><?php echo $idmarca ?></span>
											<label><i class="fa fa-tags"></i>&nbsp;<?php echo lang('Marcas'); ?></label>
										</div>
									</div>
									<button class="btn btn-outline-primary px-1" type="button" onclick="AddMarca();">
										<i class="fa fa-plus"></i>
									</button>
								</div>
							</div>
							<div class="col-12 col-lg-6 my-1">
								<div class="btn-group col-12">
									<div class="form-floating col-10">
										<input type="text" class="form-control" id="ModalCodIdAmpliado" name="ModalCodIdAmpliado" />
										<label><span class="fa fa-hashtag"></span>&nbsp;<?php echo lang('Código (S.K.U.)'); ?></label>
									</div>
									<button class="col-2 btn btn-outline-primary px-1" onclick="traetec(1);" type="button" data-toggle="tooltip"><i class="fa fa-asterisk" width="32" height="32"> </i> <?php echo lang('Sugerir Código'); ?></button>
								</div>
							</div>
							<div class=" col-12 col-md-6 my-1">
								<div class="input-group">
									<div class="col">
										<div class="form-floating" id="ReloadFamiliaSend">
											<select id="ModalIdfamilia" name="ModalIdfamilia" class="form-select" onchange="ChangeWidthHeight();">
												<?php
												echo $ModalIdfamilia;
												?>
											</select>
											<span id="RegUnoFamilia" style="display:none;"><?php echo $Familia ?></span>
											<?php echo $ModalIdfamiliaSpan; ?>
											<label><i class="fa fa-th-large"></i>&nbsp;<?php echo lang('Familia Principal'); ?></label>
										</div>
									</div>
									<button class="btn btn-outline-primary px-1" type="button" onclick="AddFamilia();">
										<i class="fa fa-plus"></i>
									</button>
								</div>
							</div>
							<div class=" col-12 col-md-12 my-1" style="display: none;">
								<label><i class="fa fa-th-large"></i>&nbsp;<?php echo lang('Familias Adicionales'); ?></label>
								<select id="mIdfamilia" name="mIdfamilia[]" onchange="stringfam();" multiple="multiple" style="width: 100%">
									<?php
									$conn = conectar();
									$query = "SELECT a.IdVarios,if(a.IdVariosPadre=0,a.ITEM,concat(b.ITEM,' > ', a.ITEM)) AS ITEM FROM PosUpvarios a left join PosUpvarios b on a.IdCompany=b.IdCompany and a.IdVariosPadre = b.IdVarios and a.TIPOITEM = b.TIPOITEM and b.TIPOITEM = 2 WHERE a.IdCompany=" . $_SESSION["CompanyActual"] . " and a.TIPOITEM = 2 order by if(a.IdVariosPadre=0,a.ITEM,concat(b.ITEM,' > ', a.ITEM)) asc";
									//echo $query;
									if ($result = mysqli_query($conn, $query)) {
										while ($row = mysqli_fetch_assoc($result)) {
											$ff = $ff + 1;
											if ($ff == 1) {
												$Familiam = trim($row['IdVarios']);;
											}
									?>
											<option value="<?php echo trim($row['IdVarios']); ?>"><?php echo trim($row['ITEM']); ?></option>
									<?

										}
										mysqli_free_result($result);
									}
									?>
								</select>
								<span id="mRegUnoFamilia" class="d-none"></span>
								<?php echo $ModalIdfamiliaSpan; ?>
							</div>
							<div class=" col-12 col-lg-6  my-1">
								<div class="form-floating">
									<input type="text" autocomplete="off" class="form-control" id="ModalMedida" name="ModalMedida" onfocus="buscarunidad();" onkeyup="buscarunidad();" onblur="setTimeout(() => { $('#suggesstion-box').hide() }, 500);" />
									<?php if ($_SESSION["Ec"] == 0) { ?>
										<label for="ModalMedida"><i class="fa fa-bookmark"></i> <?php echo lang('Unidad de Medida'); ?></label>
									<?php } else { ?>
										<label for="ModalMedida"><i class="fa fa-bookmark"></i> <?php echo lang('Unidad de Medida'); ?></label>
									<?php } ?>
									<div id="suggesstion-box" class="align-self-left dropdown-menu" aria-labelledby="dropdownMenuButton"></div>
								</div>
							</div>
							<div class=" col-12 col-lg-6  my-1">
								<div class="input-group mb-2">
									<?php if ($_SESSION["Ec"] == 0) { ?>
										<div class="form-check">
											<input class="form-check-input" type="checkbox" id="ModalPorKilo" name="ModalPorKilo">
											<label class="form-check-label" for="ModalPorKilo">
												<?php echo lang("Este Producto utiliza balanza"); ?>
											</label>
										</div>
									<?php } ?>

									<label id="ModalEstadoact"><input type="checkbox" id="ModalEstado" name="ModalEstado" onchange="ChangeEstado()" checked> <?php echo lang('Estado'); ?> <strong id="EstadoEstado"></strong></label> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
									<label id="ModalNoEstado"><i class="fa fa-exclamation-triangle text-warning"></i> <strong><?php echo lang("Para poder inactivar este producto la existencia de ese producto debe estar ajustada a cero"); ?></strong></label>
									<label style="display:none" id="checkvar"><input type="checkbox" id="OnVariacion" name="OnVariacion" onchange=" checkedvaria()"> <?php echo lang('Permite Variaciones'); ?> </label>
								</div>
							</div>
							<div style="display:none" class="col-12 col-lg-6" id='variac'>
								<div class="form-floating d-none my-1">
									<input type="text" class="form-control" id="Groupvar" name="Groupvar" value="" />
									<label><span class="fa fa-bars"></span>&nbsp;<?php echo lang('Variación'); ?></label>
								</div>
							</div>
							<div style="display:none" class="col-12 col-lg-6" id='variac2'>
								<div class="form-floating d-none my-1">
									<input type="text" class="form-control" id="TextVar" name="TextVar" value="" />
									<label><span class="fa fa-bars"></span>&nbsp;<?php echo lang('Descripción de Variación'); ?></label>
								</div>
							</div>
							<div class="col-12 text-left my-1">
								<div class="btn-group col-12">
									<div class="form-floating col-8 col-lg-8">
										<input type="text" class="form-control" id="ModalCodBarra" onKeypress="if(event.keyCode == 13) { barraCod(document.getElementById('ModalCodBarra').value); } " onkeyup="DeshabilitarButtond(1);" onblur="DeshabilitarButtond(1)" name="ModalCodBarra" />
										<label><i class="fa fa-barcode" aria-hidden="true"></i>&nbsp;<?php echo lang('Código de Barras'); ?></label>
									</div>
									<button class="col-2 col-lg-2 btn btn-outline-primary px-1" onclick="traetec(2);" type="button" data-toggle="tooltip" data-original-title="" title=""><span class="fa fa-asterisk" width="32" height="32"> </span> <?php echo lang("Sugerir Código"); ?></button>
									<button class="col-2 col-lg-2 btn btn-outline-primary px-1" type="button" id="ModalButtonCodBar" onclick="barraCod(document.getElementById('ModalCodBarra').value);" data-toggle="tooltip"><span class="fa fa-arrow-down" width="32" height="32"> </span> <?php echo lang("Crear Código"); ?></button>
								</div>
							</div>
							<input id='jcod2' name='jcod2' style='display:none' />
							<span class="pt-2" id='barrascod'>
								<input id='jcod' name='jcod' style='display:none'></input>
							</span>
						</div>
						<div style="display:none" class="form-group row">
							<div class="col-xs-6">
								<label for="ModalCodIdBasico">ID</label>
								<input type="text" class="form-control" id="ModalCodIdBasico" name="ModalCodIdBasico" />
								<input type="text" class="form-control" id="ModalCodIdBasicoPadre" name="ModalCodIdBasicoPadre" />
							</div>
						</div>
					</div>
					<div class="tab-pane " id="Variaciones">

						<div id="visibleVar" class="row">
							<div class="col-12   ">
								<label for="Price" class="form-label"><?php echo lang('Definir tipos de variación y establecer valores para este producto principal'); ?></label>
								<div class='col-12 btn-group'>
									<input id="tags" name="tags" type="text" onKeypress="if(event.keyCode == 13) { addtag(); } " class="form-control">
									<button type='button' onclick='addtag();' class="btn btn-outline-primary  px-1"> <i class='fa fa-plus'></i></button>
								</div>
								<div class="row">
									<span class="text-muted col-12"><?php echo lang('Para agregar múltiplos, sepárelos con comas y presione el ícono Más o presione enter'); ?></span>
								</div>
							</div>
						</div>
						<div id="visibleVar2" class="row d-none">
							<h5 for="Price" id="contentsetvar" class="modal-title"><?php echo lang('Establecer valores para este producto principal'); ?></h5>
						</div>
						<div class="row">
							<span id="tagsview" class=" row">
								<input id="tagsinput" class="d-none" />
								<input id="tagsinputtext" class="d-none" />
								<input id="cont" class="d-none" value="0" />
							</span>
							<div class="col-12" id='datatableproduct2'>
								<table id="data-table-product2" class="display nowrap " width="100%">
									<thead>
										<tr>
											<th class='text-start'><?php echo lang('Descripción'); ?></th>
											<th class='text-start'><?PHP echo lang('Precios'); ?></th>
										</tr>
									</thead>
								</table>
							</div>
						</div>




					</div>
					<div class="tab-pane " id="Costos">
						<div class="form-group row">
							<?php if ($_SESSION["Ec"] == 0) { ?>
								<input type="hidden" class="form-control" id="tabla" name="tabla" value="ProductosP2" />
							<?php } ?>
							<?php if ($_SESSION["Ec"] == 9) { ?>
								<input type="hidden" class="form-control" id="tabla" name="tabla" value="ServiciosP2" />
							<?php } ?>
							<input type="hidden" class="form-control" id="companyUser" name="companyUser" value="<?php echo $_SESSION["CompanyActual"]; ?>" />
							<div class="row  ">
								<div class="col-12 col-lg">
									<div class="form-floating my-1">
										<input type="text" class="form-control" id="ModalDescripcion2" name="ModalDescripcion2" readonly />
										<label><i class="fa fa-bars" aria-hidden="true"></i>&nbsp;<?php echo lang('Descripción'); ?></label>
									</div>
								</div>
								<div class="col-12 col-lg-6 my-1">
									<div class="form-floating">
										<input type="text" class="form-control" id="ModalFactorAltName" name="ModalFactorAltName" />
										<label for="ModalFactorAltName"><i class="fa fa-braille" aria-hidden="true"></i>&nbsp;<?php echo lang('Unidad Alternativo'); ?></label>
									</div>
								</div>
								<div class="col-12 col-lg-6 my-1">
									<div class="form-floating">
										<input type="number" min="0" class="form-control text-end" id="ModalFactorAltValue" name="ModalFactorAltValue" onchange="MaskNumberMoneda3(this,this.value);" />
										<label for="ModalFactorAltValue"><i class="fa fa-percent" aria-hidden="true"></i>&nbsp;<?php echo lang('Factor Alternativo'); ?></label>
									</div>
								</div>
								<div class="col-12 col-lg-6 my-1">
									<div class="form-floating">
										<input type="text" pattern="^\d*(\.\d{0,0})?$" class="form-control" id="ModalCantxfactor" name="ModalCantxfactor" onchange="MaskNumberMoneda3(this,this.value);" />
										<label for="ModalCantxfactor"><i class="fa fa-braille" aria-hidden="true"></i>&nbsp;<?php echo lang('Cantidad'); ?></label>
									</div>
								</div>
								<div class="col-12 col-lg-6 my-1">
									<div class="input-group">
										<div class="col">
											<div class="form-floating">
												<input type="text" pattern="^\d*(\.\d{0,2})?$" class="form-control" id="Modalfactor" name="Modalfactor" onchange="MaskNumberMoneda3(this,this.value);" />
												<label for="Modalfactor"><i class="fa fa-percent" aria-hidden="true"></i>&nbsp;<?php echo lang('Factor'); ?></label>
											</div>
										</div>
										<button class="btn btn-outline-primary px-1 " type="button" data-toggle="tooltip" id="agrfac" onclick="agrfac();"><span class="fa fa-arrow-down"></span></button>
									</div>
								</div>
								<div class="col-12 my-1">
									<span id="visfactor"></span>
									<span id="jsonfactor" class="d-none"></span>
								</div>
								<?php
								if ($_SESSION['userperfil'] <= 2000 || $_SESSION["userperfil"] === "2080" || $_SESSION["userperfil"] === "2060" || $_SESSION["userperfil"] === "2055" || $_SESSION["userperfil"] == "2054" || $_SESSION["userperfil"] == "2053" || $_SESSION["userperfil"] === "2056" || $_SESSION["userperfil"] === "2710" || ($_SESSION["userlogin"] === "DULCE" && $_SESSION["CompanyActual"] === "1125")) { ?>
									<div class="col-12 col-lg" style="<?php echo ($_SESSION['Ec'] == 0 ? 'display:none;' : ''); ?>">
										<div class="form-floating my-1">
											<select id="ModalTipOCosto" name="ModalTipOCosto" class="form-select" onchange="TipoCostoChange();">
												<option value="0">Costo Normal</option>
												<option value="1">Costo Porcentaje</option>
											</select>
											<label><i class="fa fa-percent" aria-hidden="true"></i>&nbsp;<?php echo lang('Impuestos'); ?> (%)</label>
										</div>
									</div>
								<?php
								} else {
								?>
									<select id="ModalTipOCosto" name="ModalTipOCosto" class="d-none">
										<option value="0">Costo Normal</option>
									</select>
									<?php
								}
								if ($_SESSION['userperfil'] <= 2000 || $_SESSION["userperfil"] === "2080" || $_SESSION["userperfil"] === "2060" || $_SESSION["userperfil"] === "2055" || $_SESSION["userperfil"] == "2054" || $_SESSION["userperfil"] == "2053" || $_SESSION["userperfil"] === "2056" || $_SESSION["userperfil"] === "2710" || ($_SESSION["userlogin"] === "DULCE" && $_SESSION["CompanyActual"] === "1125")) {

									if ($_SESSION['Ec'] == 0) {
									?>
										<div class="col-12">
											<div class="input-group">
												<input type="text" class="form-control form-control-sm bg-success text-success" style="width: 10%;" value="-" disabled>
												<input type="text" class="form-control form-control-sm bg-success text-light text-end" id="CostoTitle01" style="width: 30%;" value='<?php echo lang("Sin impuesto") . " (" . $_SESSION["MonedaP"] . ")"; ?>' disabled>
												<input type="text" class="form-control form-control-sm bg-success text-light text-end" id="CostoTitle03" style="width: 60%; display:none;" value='<?php echo lang("Monto Porcentaje") . " (%)"; ?>' disabled>
												<input type="text" class="form-control form-control-sm bg-success text-light text-end" style="width: 30%;" value='<?php echo lang("Impuesto") . " (%)"; ?>' disabled>
												<input type="text" class="form-control form-control-sm bg-success text-light text-end" id="CostoTitle02" style="width: 30%;" value='<?php echo lang("Con impuesto") . " (" . $_SESSION["MonedaP"] . ")"; ?>' disabled>
											</div>
										</div>
									<?
									}
									?>

									<div class="col-12">
										<div class="input-group">
											<input type="text" class="form-control form-control-sm bg-success text-light" style="width: 10%;" value='<?php echo (trim($LitCosto) !== "" ? $LitCosto : lang("Costo")); ?>' disabled>
											<input type="text" pattern="^\d*(\.\d{0,2})?$" class="form-control form-control-sm text-end" style="width: 60%; display: none;" id="ModalCostoPercent" name="ModalCostoPercent" onchange="MaskNumberMoneda3(this,this.value);" />
											<input type="text" pattern="^\d*(\.\d{0,2})?$" class="form-control form-control-sm text-end " style="width: 30%; <?php echo ($_SESSION["userperfil"] === "2056" ? "display:none;" : ""); ?>" id="ModalCostos" name="ModalCostos" onchange="MaskNumberMoneda3(this,this.value);" />

											<select class="form-select " id="ModalImpuestos" name="ModalImpuestos" style="width: 30%;" onchange="MaskNumberMoneda3(this,this.value);">
												<?php
												$conn = conectar();
												$n = 0;
												$query10 = "SELECT * FROM PosUpvarios WHERE IdCompany=" . $_SESSION["CompanyActual"] . " and TIPOITEM=0 and pathimg = 0";
												if ($result = mysqli_query($conn, $query10)) {
													while ($row = mysqli_fetch_assoc($result)) {
														$n++;
														if ($n == 1) {
															$Impuestoa = $row['IdVarios'];
														}
												?>
														<option value="<?php echo trim($row['IdVarios']); ?>"><?php echo trim($row['ITEM']) . "   (" . trim($row['VALOR'] * 100) . "%" . ")"; ?></option>
												<?
													}
													mysqli_free_result($result);
												}
												?>
											</select>
											<?php
											$query10 = "SELECT * FROM PosUpvarios WHERE IdCompany=" . $_SESSION["CompanyActual"] . " and TIPOITEM=0 and pathimg = 0";
											if ($result = mysqli_query($conn, $query10)) {
												while ($row = mysqli_fetch_assoc($result)) {
											?>
													<span style="display:none;" id="ValordelImpuesto<?php echo $row['IdVarios']; ?>"><?php echo $row['VALOR'] * 100; ?></span>
											<?php
												}
												mysqli_free_result($result);
											};
											?>
											</select>
											<span id="RegUnoImpuesto" style="display:none;"><?php echo $Impuestoa ?></span>
											<input type="text" pattern="^\d*(\.\d{0,2})?$" class="form-control form-control-sm text-end " style="width: 30%; <?php echo ($_SESSION["userperfil"] === "2056" ? "display:none;" : ""); ?>" id="ModalCostoNeto" name="ModalCostoNeto" onchange="MaskNumberMoneda3(this,this.value);">
										</div>
									</div>
									<?php
								} else {

									if ($_SESSION['Ec'] == 0) {
									?>
										<div class="col-12">
											<div class="input-group">
												<input type="text" class="form-control form-control-sm bg-success text-success" style="width: 10%;" value="-" disabled>
												<input type="hidden" id="CostoTitle01">
												<input type="hidden" id="CostoTitle03">
												<input type="hidden" id="CostoTitle02">
												<input type="text" class="form-control form-control-sm bg-success text-light text-end" style="width: 30%;" value='' disabled>
												<input type="text" class="form-control form-control-sm bg-success text-light text-end" style="width: 30%;" value='<?php echo lang("Impuesto") . " (%)"; ?>' disabled>
												<input type="text" class="form-control form-control-sm bg-success text-light text-end" style="width: 30%;" value='' disabled>
											</div>
										</div>
									<?
									}
									?>

									<div class="col-12">
										<div class="input-group">
											<input type="text" class="form-control form-control-sm bg-success text-light" style="width: 10%;" value='' disabled>
											<input type="hidden" id="ModalCostoPercent">
											<input type="hidden" id="ModalCostos">
											<input type="hidden" id="ModalCostoNeto">
											<input type="text" class="form-control form-control-sm bg-success text-light" style="width: 30%;" value='' disabled>

											<select class="form-select " id="ModalImpuestos" name="ModalImpuestos" style="width: 30%;" onchange="MaskNumberMoneda3(this,this.value);">
												<?php
												$conn = conectar();
												$n = 0;
												$query10 = "SELECT * FROM PosUpvarios WHERE IdCompany=" . $_SESSION["CompanyActual"] . " and TIPOITEM=0 and pathimg = 0";
												if ($result = mysqli_query($conn, $query10)) {
													while ($row = mysqli_fetch_assoc($result)) {
														$n++;
														if ($n == 1) {
															$Impuestoa = $row['IdVarios'];
														}
												?>
														<option value="<?php echo trim($row['IdVarios']); ?>"><?php echo trim($row['ITEM']) . "   (" . trim($row['VALOR'] * 100) . "%" . ")"; ?></option>
												<?
													}
													mysqli_free_result($result);
												}
												?>
											</select>
											<?php
											$query10 = "SELECT * FROM PosUpvarios WHERE IdCompany=" . $_SESSION["CompanyActual"] . " and TIPOITEM=0 and pathimg = 0";
											if ($result = mysqli_query($conn, $query10)) {
												while ($row = mysqli_fetch_assoc($result)) {
											?>
													<span style="display:none;" id="ValordelImpuesto<?php echo $row['IdVarios']; ?>"><?php echo $row['VALOR'] * 100; ?></span>
											<?php
												}
												mysqli_free_result($result);
											};
											?>
											</select>
											<span id="RegUnoImpuesto" style="display:none;"><?php echo $Impuestoa ?></span>
											<input type="text" class="form-control form-control-sm bg-success text-light" style="width: 30%;" value='' disabled>
										</div>
									</div>
								<?php
								}
								?>
								<div class="col-12">
									<div class="input-group">
										<input type="text" class="form-control form-control-sm bg-warning text-dark" style="width: 20%;" value='<?php echo lang("Precios"); ?>' disabled>
										<?php if ($_SESSION['userperfil'] <= 2000 || $_SESSION["userperfil"] === "2080" || $_SESSION["userperfil"] === "2060" || $_SESSION["userperfil"] === "2055" || $_SESSION["userperfil"] == "2054" || $_SESSION["userperfil"] == "2053" || $_SESSION["userperfil"] === "2056" || $_SESSION["userperfil"] === "2710" || ($_SESSION["userlogin"] === "DULCE" && $_SESSION["CompanyActual"] === "1125")) { ?>
										<?php } ?>
										<input type="text" class="form-control form-control-sm text-end bg-warning text-dark" style="width: 10%;" value='<?php echo lang("Fraccion"); ?>' disabled>
										<input type="text" class="form-control form-control-sm text-start bg-warning text-dark" style="width: 15%;" value='<?php echo lang("Medida"); ?>' disabled>

										<input type="text" class="form-control form-control-sm text-end bg-warning text-dark" style="width: 15%;" value='<?php echo lang("Sin impuesto") . " (" . $_SESSION["MonedaP"] . ")"; ?>' disabled>
										<input type="text" class="form-control form-control-sm text-end bg-warning text-dark" style="width: 15%;" value='<?php echo lang("Margen"); ?>' disabled>
										<input type="text" class="form-control form-control-sm text-end bg-warning text-dark" style="width: 15%;" value='<?php echo lang("Con impuesto") . " (" . $_SESSION["MonedaP"] . ")"; ?>' disabled>
										<input type="text" class="form-control form-control-sm text-end bg-warning text-dark" style="width: 10%;" value='<?php echo lang("Comision"); ?>' disabled>
									</div>
								</div>
								<div class="col-12">
									<div class="input-group">
										<input type="text" class="form-control form-control-sm bg-warning text-dark" style="width: 20%;" value='<?php echo (trim($LitP01) !== "" ? $LitP01 : lang("Precio") . " 1"); ?>' disabled>
										<?php if ($_SESSION['userperfil'] <= 2000 || $_SESSION["userperfil"] === "2080" || $_SESSION["userperfil"] === "2060" || $_SESSION["userperfil"] === "2055" || $_SESSION["userperfil"] == "2054" || $_SESSION["userperfil"] == "2053" || $_SESSION["userperfil"] === "2056" || $_SESSION["userperfil"] === "2710" || ($_SESSION["userlogin"] === "DULCE" && $_SESSION["CompanyActual"] === "1125")) { ?>
										<?php } ?>
										<input type="text" class="form-control form-control-sm text-end" pattern="^\d*(\.\d{0,2})?$" style="width: 10%;" id="ModalCant1" name="ModalCant1" value="1" readonly>
										<input type="text" class="form-control form-control-sm" style="width: 15%;" id="ModalMedidas" name="ModalMedidas" disabled>

										<input type="text" pattern="^\d*(\.\d{0,2})?$" class="form-control form-control-sm text-end" style="width: 15%;" id="ModalPrecioNeto" name="ModalPrecioNeto" onchange="MaskNumberMoneda3(this,this.value);">
										<input type="text" pattern="^\d*(\.\d{0,2})?$" class="form-control form-control-sm text-end" style='width: 15%; <?php echo ($_SESSION["userperfil"] === "2056" ? "display:none;" : ""); ?>' id="ModalMargen" name="ModalMargen" onchange="MaskNumberMoneda3(this,this.value);">
										<input type="text" pattern="^\d*(\.\d{0,2})?$" class="form-control form-control-sm text-end" style="width: 15%;" id="ModalPrecioVenta" name="ModalPrecioVenta" onchange="MaskNumberMoneda3(this,this.value);">
										<input type="text" class="form-control form-control-sm" pattern="^\d*(\.\d{0,2})?$" style="width: 10%;" id="Comision" name="Comision">
									</div>
								</div>
								<div class="col-12 ">
									<div class="input-group">
										<div style="width: 25%;"></div>
										<div class="text-muted py-0 ps-0 pe-1" style="width: 15%; margin:0px; font-size:0.6em; text-align: right;" id="spp1"></div>
										<div style="width: 15%;"></div>
										<div style="width: 15%;"></div>
									</div>
								</div>

								<div class="col-12 ">
									<div class="input-group">
										<input type="text" class="form-control form-control-sm bg-warning text-dark" style="width: 20%;" value='<?php echo (trim($LitP02) !== "" ? $LitP02 : lang("Precio") . " 2"); ?>' disabled>
										<?php if ($_SESSION['userperfil'] <= 2000 || $_SESSION["userperfil"] === "2080" || $_SESSION["userperfil"] === "2060" || $_SESSION["userperfil"] === "2055" || $_SESSION["userperfil"] == "2054" || $_SESSION["userperfil"] == "2053" || $_SESSION["userperfil"] === "2056" || $_SESSION["userperfil"] === "2710" || ($_SESSION["userlogin"] === "DULCE" && $_SESSION["CompanyActual"] === "1125")) { ?>
										<?php } ?>
										<input type="text" class="form-control form-control-sm text-end" pattern="^\d*(\.\d{0,2})?$" style="width: 10%;" id="ModalCant2" name="ModalCant2" onchange="MaskNumberMoneda3(this,this.value);" onkeypress="return valideKey(event);" <?php echo ($_SESSION['Ec'] == 9 ? "disabled" : ""); ?> />
										<input type="text" class="form-control form-control-sm" pattern="^\d*(\.\d{0,2})?$" style="width: 15%;" id="ModalMedida2" name="ModalMedida2">
										<input type="text" class="form-control form-control-sm text-end" pattern="^\d*(\.\d{0,2})?$" style="width: 15%;" id="ModalPrecioNeto2" name="ModalPrecioNeto2" onchange="MaskNumberMoneda3(this,this.value);">
										<input type="text" class="form-control form-control-sm text-end" pattern="^\d*(\.\d{0,2})?$" style="width: 15%; <?php echo ($_SESSION["userperfil"] === "2056" ? "display:none;" : ""); ?>" id="ModalMargen2" name="ModalMargen2" onchange="MaskNumberMoneda3(this,this.value);">
										<input type="text" class="form-control form-control-sm text-end" pattern="^\d*(\.\d{0,2})?$" style="width: 15%;" id="ModalPrecioVenta2" name="ModalPrecioVenta2" onchange="MaskNumberMoneda3(this,this.value);">
										<input type="text" class="form-control form-control-sm" pattern="^\d*(\.\d{0,2})?$" style="width: 10%;" id="Comision2" name="Comision2">
									</div>
								</div>

								<div class="col-12 ">
									<div class="input-group">
										<div style="width: 25%;"></div>
										<div class="text-muted py-0 ps-0 pe-1" style="width: 15%; margin:0px; font-size:0.6em; text-align: right;" id="cantsimp"></div>
										<div style="width: 15%;"></div>
										<div class="text-muted py-0 ps-0 pe-1" style="width: 15%; margin:0px; font-size:0.6em; text-align: right;" id="cantcimp"></div>
										<div style="width: 15%;"></div>
									</div>
								</div>

								<div class="col-12 ">
									<div class="input-group">
										<input type="text" class="form-control form-control-sm bg-warning text-dark" style="width: 20%;" value='<?php echo (trim($LitP03) !== "" ? $LitP03 : lang("Precio") . " 3"); ?>' disabled>
										<?php if ($_SESSION['userperfil'] <= 2000 || $_SESSION["userperfil"] === "2080" || $_SESSION["userperfil"] === "2060" || $_SESSION["userperfil"] === "2055" || $_SESSION["userperfil"] == "2054" || $_SESSION["userperfil"] == "2053" || $_SESSION["userperfil"] === "2056" || $_SESSION["userperfil"] === "2710" || ($_SESSION["userlogin"] === "DULCE" && $_SESSION["CompanyActual"] === "1125")) { ?>
										<?php } ?>
										<input type="text" class="form-control form-control-sm text-end" pattern="^\d*(\.\d{0,2})?$" style="width: 10%;" id="ModalCant3" name="ModalCant3" onchange="MaskNumberMoneda3(this,this.value);" onkeypress="return valideKey(event);" <?php echo ($_SESSION['Ec'] == 9 ? "disabled" : ""); ?> />
										<input type="text" class="form-control form-control-sm" pattern="^\d*(\.\d{0,2})?$" style="width: 15%;" id="ModalMedida3" name="ModalMedida3">
										<input type="text" class="form-control form-control-sm text-end" pattern="^\d*(\.\d{0,2})?$" style="width: 15%;" id="ModalPrecioNeto3" name="ModalPrecioNeto3" onchange="MaskNumberMoneda3(this,this.value);">
										<input type="text" class="form-control form-control-sm text-end" pattern="^\d*(\.\d{0,2})?$" style="width: 15%; <?php echo ($_SESSION["userperfil"] === "2056" ? "display:none;" : ""); ?>" id="ModalMargen3" name="ModalMargen3" onchange="MaskNumberMoneda3(this,this.value);">
										<input type="text" class="form-control form-control-sm text-end" pattern="^\d*(\.\d{0,2})?$" style="width: 15%;" id="ModalPrecioVenta3" name="ModalPrecioVenta3" onchange="MaskNumberMoneda3(this,this.value);">
										<input type="text" class="form-control form-control-sm" pattern="^\d*(\.\d{0,2})?$" style="width: 10%;" id="Comision3" name="Comision3">
									</div>
								</div>

								<div class="col-12 ">
									<div class="input-group">
										<div style="width: 25%;"></div>
										<div class="text-muted py-0 ps-0 pe-1" style="width: 15%; margin:0px; font-size:0.6em; text-align: right;" id="cantsimp2"></div>
										<div style="width: 15%;"></div>
										<div class="text-muted py-0 ps-0 pe-1" style="width: 15%; margin:0px; font-size:0.6em; text-align: right;" id="cantcimp2"></div>
										<div style="width: 15%;"></div>
									</div>
								</div>

								<div class="col-12 ">
									<div class="input-group">
										<input type="text" class="form-control form-control-sm bg-warning text-dark" style="width: 20%;" value='<?php echo (trim($LitP04) !== "" ? $LitP04 : lang("Precio") . " 4"); ?>' disabled>
										<?php if ($_SESSION['userperfil'] <= 2000 || $_SESSION["userperfil"] === "2080" || $_SESSION["userperfil"] === "2060" || $_SESSION["userperfil"] === "2055" || $_SESSION["userperfil"] == "2054" || $_SESSION["userperfil"] == "2053" || $_SESSION["userperfil"] === "2056" || $_SESSION["userperfil"] === "2710" || ($_SESSION["userlogin"] === "DULCE" && $_SESSION["CompanyActual"] === "1125")) { ?>
										<?php } ?>
										<input type="text" class="form-control form-control-sm text-end" pattern="^\d*(\.\d{0,2})?$" style="width: 10%;" id="ModalCant4" name="ModalCant4" onchange="MaskNumberMoneda3(this,this.value);" onkeypress="return valideKey(event);" <?php echo ($_SESSION['Ec'] == 9 ? "disabled" : ""); ?> />
										<input type="text" class="form-control form-control-sm" pattern="^\d*(\.\d{0,2})?$" style="width: 15%;" id="ModalMedida4" name="ModalMedida4 ">
										<input type="text" class="form-control form-control-sm text-end" pattern="^\d*(\.\d{0,2})?$" style="width: 15%;" id="ModalPrecioNeto4" name="ModalPrecioNeto4" onchange="MaskNumberMoneda3(this,this.value);">
										<input type="text" class="form-control form-control-sm text-end" pattern="^\d*(\.\d{0,2})?$" style="width: 15%; <?php echo ($_SESSION["userperfil"] === "2056" ? "display:none;" : ""); ?>" id="ModalMargen4" name="ModalMargen4" onchange="MaskNumberMoneda3(this,this.value);">
										<input type="text" class="form-control form-control-sm text-end" pattern="^\d*(\.\d{0,2})?$" style="width: 15%;" id="ModalPrecioVenta4" name="ModalPrecioVenta4" onchange="MaskNumberMoneda3(this,this.value);">
										<input type="text" class="form-control form-control-sm" pattern="^\d*(\.\d{0,2})?$" style="width: 10%;" id="Comision4" name="Comision4">

									</div>
								</div>

								<div class="col-12 ">
									<div class="input-group">
										<div style="width: 25%;"></div>
										<div class="text-muted py-0 ps-0 pe-1" style="width: 15%; margin:0px; font-size:0.6em; text-align: right;" id="cantsimp4"></div>
										<div style="width: 15%;"></div>
										<div class="text-muted py-0 ps-0 pe-1" style="width: 15%; margin:0px; font-size:0.6em; text-align: right;" id="cantcimp4"></div>
										<div style="width: 15%;"></div>
									</div>
								</div>

								<div class="col-12 ">
									<div class="input-group">
										<input type="text" class="form-control form-control-sm bg-warning text-dark" style="width: 20%;" value='<?php echo (trim($LitP05) !== "" ? $LitP05 : lang("Precio") . " 5"); ?>' disabled>
										<?php if ($_SESSION['userperfil'] <= 2000 || $_SESSION["userperfil"] === "2080" || $_SESSION["userperfil"] === "2060" || $_SESSION["userperfil"] === "2055" || $_SESSION["userperfil"] == "2054" || $_SESSION["userperfil"] == "2053" || $_SESSION["userperfil"] === "2056" || $_SESSION["userperfil"] === "2710" || ($_SESSION["userlogin"] === "DULCE" && $_SESSION["CompanyActual"] === "1125")) { ?>
										<?php } ?>
										<input type="text" class="form-control form-control-sm text-end" pattern="^\d*(\.\d{0,2})?$" style="width: 10%;" id="ModalCant5" name="ModalCant5" onchange="MaskNumberMoneda3(this,this.value);" onkeypress="return valideKey(event);" <?php echo ($_SESSION['Ec'] == 9 ? "disabled" : ""); ?> />
										<input type="text" class="form-control form-control-sm" pattern="^\d*(\.\d{0,2})?$" style="width: 15%;" id="ModalMedida5" name="ModalMedida5 ">
										<input type="text" class="form-control form-control-sm text-end" pattern="^\d*(\.\d{0,2})?$" style="width: 15%;" id="ModalPrecioNeto5" name="ModalPrecioNeto5" onchange="MaskNumberMoneda3(this,this.value);">
										<input type="text" class="form-control form-control-sm text-end" pattern="^\d*(\.\d{0,2})?$" style="width: 15%; <?php echo ($_SESSION["userperfil"] === "2056" ? "display:none;" : ""); ?>" id="ModalMargen5" name="ModalMargen5" onchange="MaskNumberMoneda3(this,this.value);">
										<input type="text" class="form-control form-control-sm text-end" pattern="^\d*(\.\d{0,2})?$" style="width: 15%;" id="ModalPrecioVenta5" name="ModalPrecioVenta5" onchange="MaskNumberMoneda3(this,this.value);">
										<input type="text" class="form-control form-control-sm" pattern="^\d*(\.\d{0,2})?$" style="width: 10%;" id="Comision5" name="Comision5">

									</div>
								</div>

								<div class="col-12 ">
									<div class="input-group">
										<div style="width: 25%;"></div>
										<div class="text-muted py-0 ps-0 pe-1" style="width: 15%; margin:0px; font-size:0.6em; text-align: right;" id="cantsimp5"></div>
										<div style="width: 15%;"></div>
										<div class="text-muted py-0 ps-0 pe-1" style="width: 15%; margin:0px; font-size:0.6em; text-align: right;" id="cantcimp5"></div>
										<div style="width: 15%;"></div>
									</div>
								</div>

								<div class="col-12 ">
									<div class="input-group">
										<input type="text" class="form-control form-control-sm bg-warning text-dark" style="width: 20%;" value='<?php echo (trim($LitP06) !== "" ? $LitP06 : lang("Precio") . " 6"); ?>' disabled>
										<?php if ($_SESSION['userperfil'] <= 2000 || $_SESSION["userperfil"] === "2080" || $_SESSION["userperfil"] === "2060" || $_SESSION["userperfil"] === "2055" || $_SESSION["userperfil"] == "2054" || $_SESSION["userperfil"] == "2053" || $_SESSION["userperfil"] === "2056" || $_SESSION["userperfil"] === "2710" || ($_SESSION["userlogin"] === "DULCE" && $_SESSION["CompanyActual"] === "1125")) { ?>
										<?php } ?>
										<input type="text" class="form-control form-control-sm text-end" pattern="^\d*(\.\d{0,2})?$" style="width: 10%;" id="ModalCant6" name="ModalCant6" onchange="MaskNumberMoneda3(this,this.value);" onkeypress="return valideKey(event);" <?php echo ($_SESSION['Ec'] == 9 ? "disabled" : ""); ?> />
										<input type="text" class="form-control form-control-sm" pattern="^\d*(\.\d{0,2})?$" style="width: 15%;" id="ModalMedida6" name="ModalMedida6 ">
										<input type="text" class="form-control form-control-sm text-end" pattern="^\d*(\.\d{0,2})?$" style="width: 15%;" id="ModalPrecioNeto6" name="ModalPrecioNeto6" onchange="MaskNumberMoneda3(this,this.value);">
										<input type="text" class="form-control form-control-sm text-end" pattern="^\d*(\.\d{0,2})?$" style="width: 15%; <?php echo ($_SESSION["userperfil"] === "2056" ? "display:none;" : ""); ?>" id="ModalMargen6" name="ModalMargen6" onchange="MaskNumberMoneda3(this,this.value);">
										<input type="text" class="form-control form-control-sm text-end" pattern="^\d*(\.\d{0,2})?$" style="width: 15%;" id="ModalPrecioVenta6" name="ModalPrecioVenta6" onchange="MaskNumberMoneda3(this,this.value);">
										<input type="text" class="form-control form-control-sm" pattern="^\d*(\.\d{0,2})?$" style="width: 10%;" id="Comision6" name="Comision6">

									</div>
								</div>

								<div class="col-12 ">
									<div class="input-group">
										<div style="width: 25%;"></div>
										<div class="text-muted py-0 ps-0 pe-1" style="width: 15%; margin:0px; font-size:0.6em; text-align: right;" id="cantsimp6"></div>
										<div style="width: 15%;"></div>
										<div class="text-muted py-0 ps-0 pe-1" style="width: 15%; margin:0px; font-size:0.6em; text-align: right;" id="cantcimp6"></div>
										<div style="width: 15%;"></div>
									</div>
								</div>

								<div class="col-12 ">
									<div class="input-group">
										<input type="text" class="form-control form-control-sm bg-warning text-dark" style="width: 20%;" value='<?php echo (trim($LitP07) !== "" ? $LitP07 : lang("Precio") . " 7"); ?>' disabled>
										<?php if ($_SESSION['userperfil'] <= 2000 || $_SESSION["userperfil"] === "2080" || $_SESSION["userperfil"] === "2060" || $_SESSION["userperfil"] === "2055" || $_SESSION["userperfil"] == "2054" || $_SESSION["userperfil"] == "2053" || $_SESSION["userperfil"] === "2056" || $_SESSION["userperfil"] === "2710" || ($_SESSION["userlogin"] === "DULCE" && $_SESSION["CompanyActual"] === "1125")) { ?>
										<?php } ?>
										<input type="text" class="form-control form-control-sm text-end" pattern="^\d*(\.\d{0,2})?$" style="width: 10%;" id="ModalCant7" name="ModalCant7" onchange="MaskNumberMoneda3(this,this.value);" onkeypress="return valideKey(event);" <?php echo ($_SESSION['Ec'] == 9 ? "disabled" : ""); ?> />
										<input type="text" class="form-control form-control-sm" pattern="^\d*(\.\d{0,2})?$" style="width: 15%;" id="ModalMedida7" name="ModalMedida7 ">
										<input type="text" class="form-control form-control-sm text-end" pattern="^\d*(\.\d{0,2})?$" style="width: 15%;" id="ModalPrecioNeto7" name="ModalPrecioNeto7" onchange="MaskNumberMoneda3(this,this.value);">
										<input type="text" class="form-control form-control-sm text-end" pattern="^\d*(\.\d{0,2})?$" style="width: 15%; <?php echo ($_SESSION["userperfil"] === "2056" ? "display:none;" : ""); ?>" id="ModalMargen7" name="ModalMargen7" onchange="MaskNumberMoneda3(this,this.value);">
										<input type="text" class="form-control form-control-sm text-end" pattern="^\d*(\.\d{0,2})?$" style="width: 15%;" id="ModalPrecioVenta7" name="ModalPrecioVenta7" onchange="MaskNumberMoneda3(this,this.value);">
										<input type="text" class="form-control form-control-sm" pattern="^\d*(\.\d{0,2})?$" style="width: 10%;" id="Comision7" name="Comision7">

									</div>
								</div>

								<div class="col-12 ">
									<div class="input-group">
										<div style="width: 25%;"></div>
										<div class="text-muted py-0 ps-0 pe-1" style="width: 15%; margin:0px; font-size:0.6em; text-align: right;" id="cantsimp7"></div>
										<div style="width: 15%;"></div>
										<div class="text-muted py-0 ps-0 pe-1" style="width: 15%; margin:0px; font-size:0.6em; text-align: right;" id="cantcimp7"></div>
										<div style="width: 15%;"></div>
									</div>
								</div>

								<div class="col-12 ">
									<div class="input-group">
										<input type="text" class="form-control form-control-sm bg-warning text-dark" style="width: 20%;" value='<?php echo (trim($LitP08) !== "" ? $LitP08 : lang("Precio") . " 8"); ?>' disabled>
										<?php if ($_SESSION['userperfil'] <= 2000 || $_SESSION["userperfil"] === "2080" || $_SESSION["userperfil"] === "2060" || $_SESSION["userperfil"] === "2055" || $_SESSION["userperfil"] == "2054" || $_SESSION["userperfil"] == "2053" || $_SESSION["userperfil"] === "2056" || $_SESSION["userperfil"] === "2710" || ($_SESSION["userlogin"] === "DULCE" && $_SESSION["CompanyActual"] === "1125")) { ?>
										<?php } ?>
										<input type="text" class="form-control form-control-sm text-end" pattern="^\d*(\.\d{0,2})?$" style="width: 10%;" id="ModalCant8" name="ModalCant8" onchange="MaskNumberMoneda3(this,this.value);" onkeypress="return valideKey(event);" <?php echo ($_SESSION['Ec'] == 9 ? "disabled" : ""); ?> />
										<input type="text" class="form-control form-control-sm" pattern="^\d*(\.\d{0,2})?$" style="width: 15%;" id="ModalMedida8" name="ModalMedida8 ">
										<input type="text" class="form-control form-control-sm text-end" pattern="^\d*(\.\d{0,2})?$" style="width: 15%;" id="ModalPrecioNeto8" name="ModalPrecioNeto8" onchange="MaskNumberMoneda3(this,this.value);">
										<input type="text" class="form-control form-control-sm text-end" pattern="^\d*(\.\d{0,2})?$" style="width: 15%; <?php echo ($_SESSION["userperfil"] === "2056" ? "display:none;" : ""); ?>" id="ModalMargen8" name="ModalMargen8" onchange="MaskNumberMoneda3(this,this.value);">
										<input type="text" class="form-control form-control-sm text-end" pattern="^\d*(\.\d{0,2})?$" style="width: 15%;" id="ModalPrecioVenta8" name="ModalPrecioVenta8" onchange="MaskNumberMoneda3(this,this.value);">
										<input type="text" class="form-control form-control-sm" pattern="^\d*(\.\d{0,2})?$" style="width: 10%;" id="Comision8" name="Comision8">

									</div>
								</div>

								<div class="col-12 ">
									<div class="input-group">
										<div style="width: 25%;"></div>
										<div class="text-muted py-0 ps-0 pe-1" style="width: 15%; margin:0px; font-size:0.6em; text-align: right;" id="cantsimp8"></div>
										<div style="width: 15%;"></div>
										<div class="text-muted py-0 ps-0 pe-1" style="width: 15%; margin:0px; font-size:0.6em; text-align: right;" id="cantcimp8"></div>
										<div style="width: 15%;"></div>
									</div>
								</div>

								<div class="col-12 ">
									<div class="input-group">
										<input type="text" class="form-control form-control-sm bg-warning text-dark" style="width: 20%;" value='<?php echo (trim($LitP09) !== "" ? $LitP09 : lang("Precio") . " 9"); ?>' disabled>
										<?php if ($_SESSION['userperfil'] <= 2000 || $_SESSION["userperfil"] === "2080" || $_SESSION["userperfil"] === "2060" || $_SESSION["userperfil"] === "2055" || $_SESSION["userperfil"] == "2054" || $_SESSION["userperfil"] == "2053" || $_SESSION["userperfil"] === "2056" || $_SESSION["userperfil"] === "2710" || ($_SESSION["userlogin"] === "DULCE" && $_SESSION["CompanyActual"] === "1125")) { ?>
										<?php } ?>
										<input type="text" class="form-control form-control-sm text-end" pattern="^\d*(\.\d{0,2})?$" style="width: 10%;" id="ModalCant9" name="ModalCant9" onchange="MaskNumberMoneda3(this,this.value);" onkeypress="return valideKey(event);" <?php echo ($_SESSION['Ec'] == 9 ? "disabled" : ""); ?> />
										<input type="text" class="form-control form-control-sm" pattern="^\d*(\.\d{0,2})?$" style="width: 15%;" id="ModalMedida9" name="ModalMedida9 ">
										<input type="text" class="form-control form-control-sm text-end" pattern="^\d*(\.\d{0,2})?$" style="width: 15%;" id="ModalPrecioNeto9" name="ModalPrecioNeto9" onchange="MaskNumberMoneda3(this,this.value);">
										<input type="text" class="form-control form-control-sm text-end" pattern="^\d*(\.\d{0,2})?$" style="width: 15%; <?php echo ($_SESSION["userperfil"] === "2056" ? "display:none;" : ""); ?>" id="ModalMargen9" name="ModalMargen9" onchange="MaskNumberMoneda3(this,this.value);">
										<input type="text" class="form-control form-control-sm text-end" pattern="^\d*(\.\d{0,2})?$" style="width: 15%;" id="ModalPrecioVenta9" name="ModalPrecioVenta9" onchange="MaskNumberMoneda3(this,this.value);">
										<input type="text" class="form-control form-control-sm" pattern="^\d*(\.\d{0,2})?$" style="width: 10%;" id="Comision9" name="Comision9">

									</div>
								</div>

								<div class="col-12 ">
									<div class="input-group">
										<div style="width: 25%;"></div>
										<div class="text-muted py-0 ps-0 pe-1" style="width: 15%; margin:0px; font-size:0.6em; text-align: right;" id="cantsimp9"></div>
										<div style="width: 15%;"></div>
										<div class="text-muted py-0 ps-0 pe-1" style="width: 15%; margin:0px; font-size:0.6em; text-align: right;" id="cantcimp9"></div>
										<div style="width: 15%;"></div>
									</div>
								</div>

								<div class="col-12 ">
									<div class="input-group">
										<input type="text" class="form-control form-control-sm bg-warning text-dark" style="width: 20%;" value='<?php echo (trim($LitP10) !== "" ? $LitP10 : lang("Precio") . " 10"); ?>' disabled>
										<?php if ($_SESSION['userperfil'] <= 2000 || $_SESSION["userperfil"] === "2080" || $_SESSION["userperfil"] === "2060" || $_SESSION["userperfil"] === "2055" || $_SESSION["userperfil"] == "2054" || $_SESSION["userperfil"] == "2053" || $_SESSION["userperfil"] === "2056" || $_SESSION["userperfil"] === "2710" || ($_SESSION["userlogin"] === "DULCE" && $_SESSION["CompanyActual"] === "1125")) { ?>
										<?php } ?>
										<input type="text" class="form-control form-control-sm text-end" pattern="^\d*(\.\d{0,2})?$" style="width: 10%;" id="ModalCant10" name="ModalCant10" onchange="MaskNumberMoneda3(this,this.value);" onkeypress="return valideKey(event);" <?php echo ($_SESSION['Ec'] == 9 ? "disabled" : ""); ?> />
										<input type="text" class="form-control form-control-sm" pattern="^\d*(\.\d{0,2})?$" style="width: 15%;" id="ModalMedida10" name="ModalMedida10 ">
										<input type="text" class="form-control form-control-sm text-end" pattern="^\d*(\.\d{0,2})?$" style="width: 15%;" id="ModalPrecioNeto10" name="ModalPrecioNeto10" onchange="MaskNumberMoneda3(this,this.value);">
										<input type="text" class="form-control form-control-sm text-end" pattern="^\d*(\.\d{0,2})?$" style="width: 15%; <?php echo ($_SESSION["userperfil"] === "2056" ? "display:none;" : ""); ?>" id="ModalMargen10" name="ModalMargen10" onchange="MaskNumberMoneda3(this,this.value);">
										<input type="text" class="form-control form-control-sm text-end" pattern="^\d*(\.\d{0,2})?$" style="width: 15%;" id="ModalPrecioVenta10" name="ModalPrecioVenta10" onchange="MaskNumberMoneda3(this,this.value);">
										<input type="text" class="form-control form-control-sm" pattern="^\d*(\.\d{0,2})?$" style="width: 10%;" id="Comision10" name="Comision10">

									</div>
								</div>

								<div class="col-12 ">
									<div class="input-group">
										<div style="width: 25%;"></div>
										<div class="text-muted py-0 ps-0 pe-1" style="width: 15%; margin:0px; font-size:0.6em; text-align: right;" id="cantsimp10"></div>
										<div style="width: 15%;"></div>
										<div class="text-muted py-0 ps-0 pe-1" style="width: 15%; margin:0px; font-size:0.6em; text-align: right;" id="cantcimp10"></div>
										<div style="width: 15%;"></div>
									</div>
								</div>


							</div>
							<span style="display:none" id="cantcimp3"></span>
							<span style="display:none" id="Revelations"></span>
							<input type="hidden" name="formidabc" id="formidabc">
							<input type="hidden" id="ModalCodIdBasico02" name="ModalCodIdBasico02" />
						</div>
					</div>
					<div class="tab-pane " id="Inventario">
						<input type="hidden" id="tabla" name="tabla" value="ProductosP3" />
						<input type="hidden" id="companyUser" name="companyUser" value="<?php echo $_SESSION["CompanyActual"]; ?>" />
						<input type="hidden" id="ModalDescripcion3" name="ModalDescripcion3" />
						<input type="hidden" id="ModalCodIdBasico3" name="ModalCodIdBasico3" />
						<div class="row ">
							<div class="col-12 col-lg-6 my-1">
								<div class="form-floating">
									<input type="number" class="form-control" id="ModalMin" name="ModalMin" />
									<label><i class="fa fa-archive" aria-hidden="true"></i>&nbsp;<?php echo lang('Mínimo'); ?></label>
								</div>
							</div>
							<div class="col-12 col-lg-6 my-1">
								<div class="form-floating">
									<input type="number" class="form-control" id="ModalMax" name="ModalMax" />
									<label><i class="fa fa-archive" aria-hidden="true"></i>&nbsp;<?php echo lang('Máximo'); ?></label>
								</div>
							</div>
						</div>
						<div class="row" id="ModalHeightModalWeighModalAreat">
							<div class="col-12 col-lg-3 my-1">
								<div class="col">
									<div class="form-floating">
										<input type="number" autocomplete="off" class="form-control text-end" id="ModalHeight" name="ModalHeight" onkeyup="calcArea();" value="<? echo $pr[0]["alto"]; ?>">
										<label for="ModalHeight"><i class="fa fa-arrows-v"></i> <? echo lang('Alto'); ?></label>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-3 my-1">
								<div class="col">
									<div class="form-floating">
										<input type="number" autocomplete="off" class="form-control text-end" id="ModalWeight" name="ModalWeight" onkeyup="calcArea();" value="<? echo $pr[0]["ancho"]; ?>">
										<label for="ModalWeight"><i class="fa fa-arrows-h"></i> <? echo lang('Ancho'); ?></label>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-6 my-1">
								<div class="col">
									<div class="form-floating">
										<input type="number" autocomplete="off" class="form-control text-end" id="ModalArea" name="ModalArea" disabled="true" value="<? echo $pr[0]["factorunit"]; ?>">
										<label for="ModalArea"><i class="fa fa-arrows-alt"></i> <? echo lang('Superficie por unidad Completa'); ?></label>
									</div>
								</div>
							</div>
						</div>
						<div class="row ">
							<div class="col-12 my-1">
								<div class="input-group">
									<div class="col">
										<div class="form-floating" id="SelectorUbik">
											<select name="ModalUbiProdX" id="ModalUbiProdX" class="form-select">
												<?php
												$query = "SELECT IdUbi,Nombre FROM PosUpUbicacion WHERE IdCompany=" . $_SESSION["CompanyActual"] . "";
												if ($result = mysqli_query($conn, $query)) {
													while ($row = mysqli_fetch_assoc($result)) {
												?><option value="<?php echo trim($row['IdUbi']); ?>"><?php echo trim($row['Nombre']); ?></option><?
																																				}
																																				mysqli_free_result($result);
																																			}
																																					?>
											</select>
											<label><i class="fa fa-map-marker"></i> <?php echo lang("Ubicaciones que usan este producto"); ?></label>
										</div>
									</div>
									<button class="btn btn-outline-success" type="button" onclick="AgregarUbi();"><?php echo lang("Añadir"); ?></button>
								</div>
							</div>
							<div class="col-12 my-1">
								<span id="MostrarUbicacion"></span>
								<span id="jsonUbicacion" style="display:none;"></span>
							</div>
							<div class="col-12 my-1">
								<div class="input-group">
									<div class="col">
										<div class="form-floating">
											<input type="text" class="form-control" id="ModalEnvase" name="ModalEnvase" onkeyup="buscarunidad2(2)" onblur="setTimeout(() => { $('#suggesstion-box2x').hide(); }, 1000);" onkeypress="if(event.keyCode == '13'){ AgregarEtiqueta(); }" />
											<label><i class="fa fa-bookmark" aria-hidden="true"></i>&nbsp;<?php echo lang('Caracteristicas del Producto'); ?></label>
											<div id="suggesstion-box2x" class="dropdown-menu bg-light"></div>
										</div>
									</div>
									<button class="btn btn-outline-success" type="button" onclick="AgregarEtiqueta();"><?php echo lang("Añadir"); ?></button>
								</div>
								<div class="text-muted small my-1"><?php echo lang("Separar etiquetas por coma"); ?></div>
							</div>
							<div class="col-12 my-1">
								<div class="form-floating">
									<button type="button" class="btn btn-outline-dark" onclick="buscarunidad2(1)" onblur="setTimeout(() => { $('#suggesstion-box2q').hide(); }, 1000);"><?php echo lang("Elegir etiquetas mas utilizadas"); ?></button>
									<div id="suggesstion-box2q" class="dropdown-menu bg-light"></div>
								</div>
							</div>
							<div class="col-12 my-1">
								<span id="MostrarEtiquetas"></span>
								<span id="jsonEtiquetas" style="display:none;"></span>
							</div>
							<div class="col-12 col-lg-6 my-1">
								<div class="input-group mb-2 col-lg-4">
									<span id="Resultado" name="Resultado"></span>
									<span id="abcdfghjqwet" name="abcdfghjqwet"></span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-outline-secondary px-1 m-1" id='boton3' type="button" onclick="puesnosecierra();" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?></button>
					<button class="btn btn-outline-primary px-1 m-1" id='boton4' type="button" onclick="preguardar('');"><i class="fa fa-save"></i> <?php echo lang('Guardar'); ?></button>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="apps-modalS" class="modal fade" tabindex="-1" role="dialog" data-bs-keyboard="false">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="titlemodalS"><?php echo lang("Agregar"); ?></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body p-1">
				<div class="border border-3 border-warning p-2 rounded-2" role="alert" id="alertaerrorenproductoS" style="display:none;">
				</div>
				<ul class="nav nav-tabs" id="myTabS" role="tablist">
					<li class="nav-item" role="presentation">
						<button class="nav-link active" id="Informacion2S" data-bs-toggle="tab" data-bs-target="#InformacionS" type="button" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-file"></i> <?php echo lang('Información'); ?></button>
					</li>
					<?php if ($_SESSION["Ec"] == 0) { ?>
						<li class="nav-item" role="presentation">
							<button class="nav-link" id="Variaciones2S" data-bs-toggle="tab" data-bs-target="#VariacionesS" type="button" role="tab" aria-controls="contact" aria-selected="false"><i class="fa-paint-brush"></i> <?php echo lang('Variaciones'); ?></button>
						</li>
					<?php } ?>
					<?php if ($_SESSION['userperfil'] <= 2000 || $_SESSION["userperfil"] === "2080" || $_SESSION["userperfil"] === "2060" || $_SESSION["userperfil"] === "2055" || $_SESSION["userperfil"] == "2054" || $_SESSION["userperfil"] == "2053"  || $_SESSION["userperfil"] === "2056" || $_SESSION["userperfil"] === "2710" || ($_SESSION["userlogin"] === "DULCE" && $_SESSION["CompanyActual"] === "1125")) { ?>
						<li class="nav-item " role="presentation">
							<button class="nav-link " id="Costos2S" data-bs-toggle="tab" data-bs-target="#CostosS" type="button" role="tab" aria-controls="profile" aria-selected="false"><i class="fa fa-money"></i> <?php echo lang('Costos'); ?></button>
						</li>
					<?php } ?>
					<?php
					if ($_SESSION["Ec"] == 0) { ?>
						<li class="nav-item" role="presentation">
							<button class="nav-link" id="Inventario2S" data-bs-toggle="tab" data-bs-target="#InventarioS" type="button" role="tab" aria-controls="contact" aria-selected="false"><i class="fa fa fa-archive"></i> <?php echo lang('Inventario'); ?></button>
						</li>
					<?php } ?>
				</ul>
				<div class="tab-content" id="myTabContentS">
					<div class="tab-pane active" id="InformacionS">
						<?php if ($_SESSION["Ec"] == 0) { ?>
							<input type="hidden" class="form-control" id="tablaS" name="tablaS" value="ProductosP1" />
						<?php } ?>
						<?php if ($_SESSION["Ec"] == 9) { ?>
							<input type="hidden" class="form-control" id="tablaS" name="tablaS" value="ServiciosP1" />
						<?php } ?>
						<input type="hidden" class="form-control" id="companyUserS" name="companyUserS" value="<?php echo $_SESSION["CompanyActual"]; ?>" />
						<div class="row  ">
							<div class="col-12 col-lg-6 my-1">
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalDescripcionS" name="ModalDescripcionS" pattern="[A-Za-z0-9_-]" />
									<label><i class="fa fa-bars" aria-hidden="true"></i>&nbsp;<?php echo lang('Descripción'); ?></label>
								</div>
							</div>
							<div class="col-12 col-lg-6 my-1">
								<div class="form-floating">
									<select id="ModalMarcaS" name="ModalMarcaS" class="form-select">
										<?php
										$conn = conectar();
										$query = "SELECT idmarca,nombre FROM PosUpc_marcas WHERE IdCompany=" . $_SESSION["CompanyActual"] . " order by nombre asc";
										if ($result = mysqli_query($conn, $query)) {
											while ($row = mysqli_fetch_assoc($result)) {
												$nm = $nm + 1;
										?><option value="<?php echo trim($row['idmarca']); ?>" <?php if ($nm == 1) {
																									echo 'selected';
																								}  ?>><?php echo trim($row['nombre']); ?></option><?
																																					if ($nm == 1) {
																																						$idmarca = $row["idmarca"];
																																					}
																																				}
																																				mysqli_free_result($result);
																																			}
																																					?>
									</select>
									<span id="RegUnoMarca" style="display:none;"><?php echo $idmarca ?></span>
									<label><i class="fa fa-tags"></i>&nbsp;<?php echo lang('Marcas'); ?></label>
								</div>
							</div>

							<div class="col-12 col-lg-6 my-1">
								<div class="btn-group col-12">
									<div class="form-floating col-10">
										<input type="text" class="form-control" id="ModalCodIdAmpliadoS" name="ModalCodIdAmpliadoS" />
										<label><span class="fa fa-hashtag"></span>&nbsp;<?php echo lang('Código (S.K.U.)'); ?></label>
									</div>
									<button class="col-2 btn btn-outline-primary px-1" onclick="traetec(1,'S');" type="button" data-toggle="tooltip"><span class="fa fa-asterisk" width="32" height="32"> </span><?php echo lang('Sugerir Código'); ?></button>
								</div>
							</div>
							<div class=" col-12 col-md-6 my-1">
								<div class="form-floating">
									<select id="ModalIdfamiliaS" name="ModalIdfamiliaS" class="form-select">
										<?php
										echo $ModalIdfamilia;
										?>
									</select>
									<span id="RegUnoFamiliaS" style="display:none;"><?php echo $Familia ?></span>
									<?php echo $ModalIdfamiliaSSpan; ?>
									<label><i class="fa fa-th-large"></i>&nbsp;<?php echo lang('Familias'); ?></label>
								</div>
							</div>
							<div class=" col-12 col-lg-6  my-1">
								<div class="form-floating">
									<input type="text" autocomplete="off" class="form-control" id="ModalMedidaS" name="ModalMedidaS" onfocus="buscarunidad();" onkeyup="buscarunidad();" onblur="setTimeout(() => { $('#suggesstion-box').hide() }, 500);" />
									<?php if ($_SESSION["Ec"] == 0) { ?>
										<label for="ModalMedida"><i class="fa fa-bookmark"></i> <?php echo lang('Unidad de Medida'); ?></label>
									<?php } else { ?>
										<label for="ModalMedida"><i class="fa fa-bookmark"></i> <?php echo lang('Unidad de Medida'); ?></label>
									<?php } ?>
									<div id="suggesstion-box" class="align-self-left dropdown-menu" aria-labelledby="dropdownMenuButton"></div>
								</div>
							</div>
							<div class=" col-12 col-lg-6  my-1">
								<div class="input-group mb-2">
									<?php if ($_SESSION["Ec"] == 0) { ?>
										<label><input type="checkbox" id="ModalPorKiloS" name="ModalPorKiloS" checked> <?php echo lang('Este Producto utiliza balanza'); ?></label> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
									<?php } ?>

									<label><input type="checkbox" id="ModalEstadoS" name="ModalEstadoS" onchange="ChangeEstado()" checked> <?php echo lang('Estado'); ?> <strong id="EstadoEstado"></strong></label> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
									<label style="display:none" id="checkvarS"><input type="checkbox" id="OnVariacion" name="OnVariacion" onchange=" checkedvaria()"> <?php echo lang('Permite Variaciones'); ?> </label>
								</div>
							</div>
							<div style="display:none" class="col-12 col-lg-6" id='variac'>
								<div class="form-floating d-none my-1">
									<input type="text" class="form-control" id="GroupvarS" name="GroupvarS" value="" />
									<label><span class="fa fa-bars"></span>&nbsp;<?php echo lang('Variación'); ?></label>
								</div>
							</div>
							<div style="display:none" class="col-12 col-lg-6" id='variac2S'>
								<div class="form-floating d-none my-1">
									<input type="text" class="form-control" id="TextVarS" name="TextVarS" value="" />
									<label><span class="fa fa-bars"></span>&nbsp;<?php echo lang('Descripción de Variación'); ?></label>
								</div>
							</div>
							<div class="col-12 text-left my-1">
								<div class="btn-group col-12">
									<div class="form-floating col-8 col-lg-8">
										<input type="text" class="form-control" id="ModalCodBarraS" onKeypress="if(event.keyCode == 13) { barraCodS(document.getElementById('ModalCodBarraS').value,'S'); } " onkeyup="DeshabilitarButtond(1);" name="ModalCodBarra" />
										<label><i class="fa fa-barcode" aria-hidden="true"></i>&nbsp;<?php echo lang('Código de Barras'); ?></label>
									</div>
									<button class="col-2 btn btn-outline-primary px-1" onclick="traetec(2,'S');" type="button" data-toggle="tooltip" data-original-title="" title=""><span class="fa fa-asterisk" onclick="traetec(2);  " width="32" height="32"> </span> <?php echo lang("Sugerir Código"); ?></button>
									<button class="col-2 btn btn-outline-primary px-1" type="button" id="ModalButtonCodBarS" onclick="barraCodS(document.getElementById('ModalCodBarraS').value,'S');" data-toggle="tooltip" data-original-title="" title=""><span class="fa fa-arrow-down" width="32" height="32"> </span> <?php echo lang("Crear Código"); ?></button>
								</div>
							</div>
							<input id='jcod2S' name='jcod2S' style='display:none' />
							<span class="pt-2" id='barrascodS'>
								<input id='jcodS' name='jcodS' style='display:none'></input>
							</span>
						</div>
						<div style="display:none" class="form-group row">
							<div class="col-xs-6">
								<label for="ModalCodIdBasico">ID</label>
								<input type="text" class="form-control" id="ModalCodIdBasicoS" name="ModalCodIdBasicoS" />
								<input type="text" class="form-control" id="ModalCodIdBasicoPadreS" name="ModalCodIdBasicoPadreS" />
							</div>
						</div>
					</div>
					<div class="tab-pane " id="VariacionesS">
						<div class="row">
							<h5 class="modal-title"><?php echo lang('Información secundaria del producto con su variación.'); ?></h5>
							<div class="col-12   ">
							</div>
							<span id="tagsview2" class=" row">
								<input id="tagsinputS" class="d-none" />
								<input id="tagsinputtextS" class="d-none" />
								<input id="contS" class="d-none" value="0" />
							</span>
						</div>
					</div>
					<div class="tab-pane " id="CostosS">
						<div class="form-group row">
							<?php if ($_SESSION["Ec"] == 0) { ?>
								<input type="hidden" class="form-control" id="tablaS" name="tablaS" value="ProductosP2" />
							<?php } ?>
							<?php if ($_SESSION["Ec"] == 9) { ?>
								<input type="hidden" class="form-control" id="tablaS" name="tablaS" value="ServiciosP2" />
							<?php } ?>
							<input type="hidden" class="form-control" id="companyUser" name="companyUser" value="<?php echo $_SESSION["CompanyActual"]; ?>" />
							<div class="row  ">
								<div class="col-12 col-lg-6">
									<div class="form-floating my-1">
										<input type="text" class="form-control" id="ModalDescripcion2S" name="ModalDescripcion2S" readonly />
										<label><i class="fa fa-bars" aria-hidden="true"></i>&nbsp;<?php echo lang('Descripción'); ?></label>
									</div>
									<div class="form-floating my-1">
										<input type="text" pattern="^\d*(\.\d{0,2})?$" class="form-control" id="ModalCostosS" name="ModalCostosS" onchange="MaskNumberMoneda3S(this,this.value);" />
										<label for="ModalCostos"><i class="fa fa-money" aria-hidden="true"></i>&nbsp;<?php echo lang('Costo Sin Impuesto'); ?>(<?php echo $_SESSION["MonedaP"]; ?>)</label>
									</div>
								</div>
								<div class="col-12 col-lg-6 my-1">
									<div class="form-floating">
										<input type="text" class="form-control" id="ModalFactorAltNameS" name="ModalFactorAltNameS" />
										<label for="ModalFactorAltNameS"><i class="fa fa-braille" aria-hidden="true"></i>&nbsp;<?php echo lang('Unidad Alternativo'); ?></label>
									</div>
								</div>
								<div class="col-12 col-lg-6 my-1">
									<div class="form-floating">
										<input type="number" min="0" class="form-control text-end" id="ModalFactorAltValueS" name="ModalFactorAltValueS" onchange="MaskNumberMoneda3(this,this.value);" />
										<label for="ModalFactorAltValueS"><i class="fa fa-percent" aria-hidden="true"></i>&nbsp;<?php echo lang('Factor Alternativo'); ?></label>
									</div>
								</div>
								<div class="col-12 col-lg-6">
									<div class="form-floating my-1">
										<select id="ModalImpuestosS" name="ModalImpuestosS" class="form-select" onchange="MaskNumberMoneda3S(this,this.value);">
											<?php
											$conn = conectar();
											$n = 0;
											$query10 = "SELECT * FROM PosUpvarios WHERE IdCompany=" . $_SESSION["CompanyActual"] . " and TIPOITEM=0 and pathimg = 0";
											if ($result = mysqli_query($conn, $query10)) {
												while ($row = mysqli_fetch_assoc($result)) {
													$n++;
													if ($n == 1) {
														$Impuestoa = $row['IdVarios'];
													}
											?><option value="<?php echo trim($row['IdVarios']); ?>"><?php echo trim($row['ITEM']); ?><?php echo "   (";
																																		echo trim($row['VALOR'] * 100);
																																		echo "%";
																																		echo ")"; ?></option><?
																																							}
																																							mysqli_free_result($result);
																																						}
																																								?>
										</select>
										<?php
										$query10 = "SELECT * FROM PosUpvarios WHERE IdCompany=" . $_SESSION["CompanyActual"] . " and TIPOITEM=0 and pathimg = 0";
										// echo $query10 . '<-------------------------------------------';
										if ($result = mysqli_query($conn, $query10)) {
											while ($row = mysqli_fetch_assoc($result)) {
										?><span style="display:none;" id="ValordelImpuesto<?php echo $row['IdVarios']; ?>"><?php echo $row['VALOR'] * 100; ?></span><?php
																																								}
																																								mysqli_free_result($result);
																																							}

																																									?>
										<span id="RegUnoImpuestoS" style="display:none;"><?php echo $Impuestoa ?></span>
										<label><i class="fa fa-percent" aria-hidden="true"></i>&nbsp;<?php echo lang('Impuestos'); ?> (%)</label>
									</div>
									<div class="form-floating my-1">
										<input type="text" pattern="^\d*(\.\d{0,2})?$" class="form-control" id="ModalCostoNetoS" name="ModalCostoNetoS" onchange="MaskNumberMoneda3S(this,this.value);" />
										<label for="ModalCostoNeto"><i class="fa fa-money" aria-hidden="true"></i>&nbsp;<?php echo lang('Costo Con Impuesto'); ?>(<?php echo $_SESSION["MonedaP"]; ?>)</label>
									</div>
								</div>
								<div class="col-12 col-lg-3">
									<?php if ($_SESSION['userperfil'] <= 2000 || $_SESSION["userperfil"] === "2080" || $_SESSION["userperfil"] === "2060" || $_SESSION["userperfil"] === "2055" || $_SESSION["userperfil"] == "2054" || $_SESSION["userperfil"] == "2053" || $_SESSION["userperfil"] === "2056" || $_SESSION["userperfil"] === "2710" || ($_SESSION["userlogin"] === "DULCE" && $_SESSION["CompanyActual"] === "1125")) { ?>
										<div class="form-floating my-1">
											<input type="text" class="form-control" id="ModalMedidasS" name="ModalMedidasS" onkeyup="buscarunidadS(1);" />
											<label><i class="fa fa-bookmark" aria-hidden="true"></i>&nbsp;<?php echo lang('Medida'); ?></label>
											<div id="suggesstion-box" class="dropdown-menu" aria-labelledby="dropdownMenuButton"></div>
										</div>
										<div class="form-floating my-1">
											<input type="text" pattern="^\d*(\.\d{0,2})?$" class="form-control" id="ModalCant1S" name="ModalCant1S" value="1" readonly />
											<label><i class="fa fa-bookmark" aria-hidden="true"></i>&nbsp;<?php echo lang('Cantidad'); ?></label>
										</div>
									<?php } ?>
									<div class="form-floating my-1">
										<input type="text" pattern="^\d*(\.\d{0,2})?$" class="form-control" id="ModalPrecioNetoS" name="ModalPrecioNetoS" onchange="MaskNumberMoneda3S(this,this.value);" />
										<label><i class="fa fa-credit-card" aria-hidden="true"></i>&nbsp;<?php echo lang('Precio Sin Impuesto'); ?>(<?php echo $_SESSION["MonedaP"]; ?>)</label>
										<div class='col-12 text-center'><label style="font-size:12px;color:blue;" id=''></label><span id='sp1S'></span></div>
									</div>
									<div class="form-floating my-1">
										<input type="text" pattern="^\d*(\.\d{0,2})?$" class="form-control" id="ModalMargenS" name="ModalMargenS" onchange="MaskNumberMoneda3S(this,this.value);" />
										<label for="ModalMargenS"><i class="fa fa-percent" aria-hidden="true"></i>&nbsp;<?php echo lang('Margen'); ?> (%)</label>
									</div>
									<div class="form-floating my-1">
										<input type="text" pattern="^\d*(\.\d{0,2})?$" class="form-control" id="ModalPrecioVentaS" name="ModalPrecioVentaS" onchange="MaskNumberMoneda3S(this,this.value);" />
										<label for="ModalPrecioVentaS"><i class="fa fa-credit-card" aria-hidden="true"></i>&nbsp;<?php echo lang('Precio Con Impuesto'); ?>(<?php echo $_SESSION["MonedaP"]; ?>)</label>
										<div class='col-12 text-center'><label style="font-size:12px;color:blue;" id=''></label><span id='spp1S'> </div>
									</div>
									<div class="form-floating my-1">
										<input type="number" min='0' max='100' step="0.01" class="form-control" id="ComisionS" name="ComisionS" />
										<label for="ModalPrecioVenta"><i class="fa fa-percent" aria-hidden="true"></i>&nbsp;<?php echo lang('Comisión'); ?> </label>
										<div class='col-12 text-center'><label style="font-size:12px;color:blue;" id=''></label>&nbsp; </div>
									</div>

								</div>

								<div class="col-12 col-lg-3">
									<?php if ($_SESSION['userperfil'] <= 2000 || $_SESSION["userperfil"] === "2080" || $_SESSION["userperfil"] === "2060" || $_SESSION["userperfil"] === "2055" || $_SESSION["userperfil"] == "2054" || $_SESSION["userperfil"] == "2053" || $_SESSION["userperfil"] === "2056" || $_SESSION["userperfil"] === "2710" || ($_SESSION["userlogin"] === "DULCE" && $_SESSION["CompanyActual"] === "1125")) { ?>
										<div class="form-floating my-1">
											<input type="text" class="form-control" id="ModalMedida2S" name="ModalMedida2S" onkeyup="buscarunidadS(2);" />
											<label><i class="fa fa-bookmark" aria-hidden="true"></i>&nbsp;<?php echo lang('Medida'); ?> 2</label>
											<div id="suggesstion-box22S" class="dropdown-menu" aria-labelledby="dropdownMenuButton"></div>
										</div>
										<div class="form-floating my-1">
											<input type="text" pattern="^\d*(\.\d{0,2})?$" class="form-control" id="ModalCant2S" name="ModalCant2S" onchange="MaskNumberMoneda3S(this,this.value);" onkeypress="return valideKeyS(event);" />
											<label><i class="fa fa-bookmark" aria-hidden="true"></i>&nbsp;<?php echo lang('Cantidad'); ?> 2</label>
										</div>
									<?php } ?>
									<div class="form-floating my-1">
										<input type="text" pattern="^\d*(\.\d{0,2})?$" class="form-control" id="ModalPrecioNeto2S" name="ModalPrecioNeto2S" onchange="MaskNumberMoneda3S(this,this.value);" />
										<label for="ModalPrecioNeto2"><i class="fa fa-credit-card" aria-hidden="true"></i>&nbsp;<?php echo lang('Precio Sin Impuesto'); ?> 2(<?php echo $_SESSION["MonedaP"]; ?>)</label>
										<div class='col-12 text-center'><label style="font-size:12px;color:blue;" id='cantsimpS'></label><span id='sp2S'></span> </div>
									</div>
									<div class="form-floating my-1">
										<input type="text" pattern="^\d*(\.\d{0,2})?$" class="form-control" id="ModalMargen2S" name="ModalMargen2S" onchange="MaskNumberMoneda3S(this,this.value);" />
										<label for="ModalMargen2"><i class="fa fa-percent" aria-hidden="true"></i>&nbsp;<?php echo lang('Margen'); ?> 2 (%)</label>
									</div>
									<div class="form-floating my-1">
										<input type="text" pattern="^\d*(\.\d{0,2})?$" class="form-control" id="ModalPrecioVenta2S" name="ModalPrecioVenta2S" onchange="MaskNumberMoneda3S(this,this.value);" />
										<label for="ModalPrecioVenta2"><i class="fa fa-credit-card" aria-hidden="true"></i>&nbsp;<?php echo lang('Precio Con Impuesto'); ?> 2(<?php echo $_SESSION["MonedaP"]; ?>)</label>
										<div class='col-12 text-center'> <label style="font-size:12px;color:blue;" id='cantcimpS'></label><span id='spp2S'></span> </div>
									</div>
									<div class="form-floating my-1">
										<input type="number" min='0' max='100' step="0.01" class="form-control" id="Comision2S" name="Comision2S" />
										<label for="ModalPrecioVenta"><i class="fa fa-percent" aria-hidden="true"></i>&nbsp;<?php echo lang('Comisión'); ?> 2 </label>
										<div class='col-12 text-center'><label style="font-size:12px;color:blue;" id=''></label>&nbsp; </div>
									</div>
								</div>
								<div class="col-12 col-lg-3">
									<?php if ($_SESSION['userperfil'] <= 2000 || $_SESSION["userperfil"] === "2080" || $_SESSION["userperfil"] === "2060" || $_SESSION["userperfil"] === "2055" || $_SESSION["userperfil"] == "2054" || $_SESSION["userperfil"] == "2053" || $_SESSION["userperfil"] === "2056" || $_SESSION["userperfil"] === "2710" || ($_SESSION["userlogin"] === "DULCE" && $_SESSION["CompanyActual"] === "1125")) { ?>
										<div class="form-floating my-1">
											<input type="text" class="form-control" id="ModalMedida3S" name="ModalMedida3S" onkeyup="buscarunidad(3);" />
											<label><i class="fa fa-bookmark" aria-hidden="true"></i>&nbsp;<?php echo lang('Medida'); ?> 3</label>
											<div id="suggesstion-box33S" class="dropdown-menu" aria-labelledby="dropdownMenuButton"></div>
										</div>
										<div class="form-floating my-1">
											<input type="text" pattern="^\d*(\.\d{0,2})?$" class="form-control" id="ModalCant3S" name="ModalCant3S" onchange="MaskNumberMoneda3S(this,this.value);" onkeypress="return valideKeyS(event);" />
											<label><i class="fa fa-bookmark" aria-hidden="true"></i>&nbsp;<?php echo lang('Cantidad'); ?> 3</label>
										</div>
									<?php } ?>
									<div class="form-floating my-1">
										<input type="text" pattern="^\d*(\.\d{0,2})?$" class="form-control" id="ModalPrecioNeto3S" name="ModalPrecioNeto3S" onchange="MaskNumberMoneda3S(this,this.value);" />
										<label for="ModalPrecioNeto3"><i class="fa fa-credit-card" aria-hidden="true"></i>&nbsp;<?php echo lang('Precio Sin Impuesto'); ?> 3(<?php echo $_SESSION["MonedaP"]; ?>)</label>
										<div class='col-12 text-center'><label style="font-size:12px;color:blue;" id='cantsimp2S'></label><span id='sp3S'></span> </div>
									</div>
									<div class="form-floating my-1">
										<input type="text" pattern="^\d*(\.\d{0,2})?$" class="form-control" id="ModalMargen3S" name="ModalMargen3S" onchange="MaskNumberMoneda3S(this,this.value);" />
										<label for="ModalMargen3"><i class="fa fa-percent" aria-hidden="true"></i>&nbsp;<?php echo lang('Margen'); ?> 3 (%)</label>
									</div>
									<div class="form-floating my-1">
										<input type="text" pattern="^\d*(\.\d{0,2})?$" class="form-control" id="ModalPrecioVenta3S" name="ModalPrecioVenta3S" onchange="MaskNumberMoneda3S(this,this.value);" />
										<label for="ModalPrecioVenta3"><i class="fa fa-credit-card" aria-hidden="true"></i>&nbsp;<?php echo lang('Precio Con Impuesto'); ?> 3(<?php echo $_SESSION["MonedaP"]; ?>)</label>
										<div class='col-12 text-center'><label style="font-size:12px;color:blue;" id='cantcimp2S'></label><span id='spp3S'></span> </div>
									</div>
									<div class="form-floating my-1">
										<input type="number" min='0' max='100' step="0.01" class="form-control" id="Comision3S" name="Comision3S" />
										<label for="ModalPrecioVenta"><i class="fa fa-percent" aria-hidden="true"></i>&nbsp;<?php echo lang('Comisión'); ?> 3</label>
										<div class='col-12 text-center'><label style="font-size:12px;color:blue;" id=''></label>&nbsp;</div>
									</div>
								</div>
								<div class="col-12 col-lg-3">
									<?php if ($_SESSION['userperfil'] <= 2000 || $_SESSION["userperfil"] === "2080" || $_SESSION["userperfil"] === "2060" || $_SESSION["userperfil"] === "2055" || $_SESSION["userperfil"] == "2054" || $_SESSION["userperfil"] == "2053" || $_SESSION["userperfil"] === "2056" || $_SESSION["userperfil"] === "2710" || ($_SESSION["userlogin"] === "DULCE" && $_SESSION["CompanyActual"] === "1125")) { ?>
										<div class="form-floating my-1">
											<input type="text" class="form-control" id="ModalMedida4S" name="ModalMedida4S" onkeyup="buscarunidad(4);" />
											<label><i class="fa fa-bookmark" aria-hidden="true"></i>&nbsp;<?php echo lang('Medida'); ?> 4</label>
											<div id="suggesstion-box44S" class="dropdown-menu" aria-labelledby="dropdownMenuButton"></div>
										</div>
										<div class="form-floating my-1">
											<input type="text" pattern="^\d*(\.\d{0,2})?$" class="form-control" id="ModalCant4S" name="ModalCant4S" onchange="MaskNumberMoneda3S(this,this.value);" onkeypress="return valideKeyS(event);" />
											<label><i class="fa fa-bookmark" aria-hidden="true"></i>&nbsp;<?php echo lang('Cantidad'); ?> 4</label>
										</div>
									<?php } ?>
									<div class="form-floating my-1">
										<input type="text" pattern="^\d*(\.\d{0,2})?$" class="form-control" id="ModalPrecioNeto4S" name="ModalPrecioNeto4S" onchange="MaskNumberMoneda3S(this,this.value);" />
										<label for="ModalPrecioNeto4"><i class="fa fa-credit-card" aria-hidden="true"></i>&nbsp;<?php echo lang('Precio Sin Impuesto'); ?> 4(<?php echo $_SESSION["MonedaP"]; ?>)</label>
										<div class='col-12 text-center'><label style="font-size:12px;color:blue;" id='cantsimp2S'></label><span id='sp4S'></span> </div>
									</div>
									<div class="form-floating my-1">
										<input type="text" pattern="^\d*(\.\d{0,2})?$" class="form-control" id="ModalMargen4S" name="ModalMargen4S" onchange="MaskNumberMoneda3S(this,this.value);" />
										<label for="ModalMargen4"><i class="fa fa-percent" aria-hidden="true"></i>&nbsp;<?php echo lang('Margen'); ?> 4 (%)</label>
									</div>
									<div class="form-floating my-1">
										<input type="text" pattern="^\d*(\.\d{0,2})?$" class="form-control" id="ModalPrecioVenta4S" name="ModalPrecioVenta4S" onchange="MaskNumberMoneda3S(this,this.value);" />
										<label for="ModalPrecioVenta4"><i class="fa fa-credit-card" aria-hidden="true"></i>&nbsp;<?php echo lang('Precio Con Impuesto'); ?> 4(<?php echo $_SESSION["MonedaP"]; ?>)</label>
										<div class='col-12 text-center'><label style="font-size:12px;color:blue;" id='cantcimp4S'></label><span id='spp4S'></span> </div>
									</div>
									<div class="form-floating my-1">
										<input type="number" min='0' max='100' step="0.01" class="form-control" id="Comision4S" name="Comision4S" />
										<label for="ModalPrecioVenta"><i class="fa fa-percent" aria-hidden="true"></i>&nbsp;<?php echo lang('Comisión'); ?> 4</label>
										<div class='col-12 text-center'><label style="font-size:12px;color:blue;" id=''></label>&nbsp;</div>
									</div>
								</div>
							</div>
						</div>
						<span style="display:none" id="cantcimp3S"></span>
						<span style="display:none" id="RevelationsS"></span>
						<input type="hidden" name="formidabcS" id="formidabcS">
						<input type="hidden" id="ModalCodIdBasico02S" name="ModalCodIdBasico02S" />
					</div>
					<div class="tab-pane " id="InventarioS">
						<input type="hidden" id="tabla" name="tabla" value="ProductosP3S" />
						<input type="hidden" id="companyUserS" name="companyUserS" value="<?php echo $_SESSION["CompanyActual"]; ?>" />
						<input type="hidden" id="ModalDescripcion3S" name="ModalDescripcion3S" />
						<input type="hidden" id="ModalCodIdBasico3S" name="ModalCodIdBasico3S" />
						<div class="row ">
							<div class="col-12 col-lg-6 my-1">
								<div class="form-floating">
									<input type="number" class="form-control" id="ModalMinS" name="ModalMinS" />
									<label><i class="fa fa-archive" aria-hidden="true"></i>&nbsp;<?php echo lang('Mínimo'); ?></label>
								</div>
							</div>
							<div class="col-12 col-lg-6 my-1">
								<div class="form-floating">
									<input type="number" class="form-control" id="ModalMaxS" name="ModalMaxS" />
									<label><i class="fa fa-archive" aria-hidden="true"></i>&nbsp;<?php echo lang('Máximo'); ?></label>
								</div>
							</div>
						</div>
						<div class="row" id="ModalHeightModalWeighModalAreatS">
							<div class="col-12 col-lg-3 my-1">
								<div class="col">
									<div class="form-floating">
										<input type="number" autocomplete="off" class="form-control text-end" id="ModalHeightS" name="ModalHeightS" onkeyup="calcArea('S');">
										<label for="ModalHeight"><i class="fa fa-arrows-v"></i> <? echo lang('Alto'); ?></label>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-3 my-1">
								<div class="col">
									<div class="form-floating">
										<input type="number" autocomplete="off" class="form-control text-end" id="ModalWeightS" name="ModalWeightS" onkeyup="calcArea('S');">
										<label for="ModalWeight"><i class="fa fa-arrows-h"></i> <? echo lang('Ancho'); ?></label>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-6 my-1">
								<div class="col">
									<div class="form-floating">
										<input type="number" autocomplete="off" class="form-control text-end" id="ModalAreaS" name="ModalAreaS" disabled="true">
										<label for="ModalArea"><i class="fa fa-arrows-alt"></i> <? echo lang('Superficie por unidad Completa'); ?></label>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12 my-1">
								<div class="input-group">
									<div class="col">
										<div class="form-floating" id="SelectorUbik">
											<select name="ModalUbiProdXS" id="ModalUbiProdXS" class="form-select">
												<?php
												$query = "SELECT IdUbi,Nombre FROM PosUpUbicacion WHERE IdCompany=" . $_SESSION["CompanyActual"] . "";
												if ($result = mysqli_query($conn, $query)) {
													while ($row = mysqli_fetch_assoc($result)) {
												?><option value="<?php echo trim($row['IdUbi']); ?>"><?php echo trim($row['Nombre']); ?></option><?
																																				}
																																				mysqli_free_result($result);
																																			}
																																					?>
											</select>
											<label><i class="fa fa-map-marker"></i> <?php echo lang("Ubicaciones que usan este producto"); ?></label>
										</div>
									</div>
									<button class="btn btn-outline-success" type="button" onclick="AgregarUbi();"><?php echo lang("Añadir"); ?></button>
								</div>
							</div>
							<div class="col-12 my-1">
								<span id="MostrarUbicacionS"></span>
								<span id="jsonUbicacionS" style="display:none;"></span>
							</div>
							<div class="col-12 my-1">
								<div class="input-group">
									<div class="col">
										<div class="form-floating">
											<input type="text" class="form-control" id="ModalEnvaseS" name="ModalEnvaseS" onkeyup="buscarunidad2S(2)" onblur="setTimeout(() => { $('#suggesstion-box2x').hide(); }, 1000);" onkeypress="if(event.keyCode == '13'){ AgregarEtiquetaS(); }" />
											<label><i class="fa fa-bookmark" aria-hidden="true"></i>&nbsp;<?php echo lang('Caracteristicas del Producto'); ?></label>
											<div id="suggesstion-box2x" class="dropdown-menu bg-light"></div>
										</div>
									</div>
									<button class="btn btn-outline-success" type="button" onclick="AgregarEtiquetaS();"><?php echo lang("Añadir"); ?></button>
								</div>
								<div class="text-muted small p-1"><?php echo lang("Separar etiquetas por coma"); ?></div>
							</div>
							<div class="col-12 my-1">
								<div class="form-floating">
									<button type="button" class="btn btn-outline-dark" onclick="buscarunidad2S(1)" onblur="setTimeout(() => { $('#suggesstion-box2q').hide(); }, 1000);"><?php echo lang("Elegir etiquetas mas utilizadas"); ?></button>
									<div id="suggesstion-box2qS" class="dropdown-menu bg-light"></div>
								</div>
							</div>
							<div class="col-12 my-1">
								<span id="MostrarEtiquetasS"></span>
								<span id="jsonEtiquetasS" style="display:none;"></span>
							</div>
							<div class="col-12 col-lg-6 my-1">
								<div class="input-group mb-2 col-lg-4">
									<span id="ResultadoS" name="ResultadoS"></span>
									<span id="abcdfghjqwetS" name="abcdfghjqwetS"></span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-outline-secondary px-1 m-1" id='boton3S' type="button" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?></button>
					<button class="btn btn-outline-primary px-1 m-1" id='boton4S' type="button" onclick="preguardar('S');"><i class="fa fa-save"></i> <?php echo lang('Guardar'); ?></button>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="MostrarSeriales" class="modal fullscreen-modal" tabindex="-1" role="dialog" data-bs-keyboard="false">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?php echo lang("Seriales del producto");  ?>: <span id="serialesspan"></span></h5>
				<div class="card-actions">
					<div class='float-end'>
						<button data-bs-dismiss="modal" class='btn  btn-outline-secondary' type="button"><span class="fa fa-close"></span></button>
					</div>
				</div>
			</div>
			<div class="modal-body">
				<div class="form-group row">
					<span id="Heisenberg"><?php echo lang('Cargando...'); ?></span>
				</div>
			</div>
			<div class="modal-footer">
				<div class="container">
					<div class="float-start">
						<?php if ($_SESSION['MVaria'] == 1) { ?>
							<button class="btn btn-outline-primary px-1 m-1" type="button" onclick='proceso(1)'><i class="fa fa-arrow-right"></i> <?php echo lang('Ingresar'); ?></button>
						<?php } ?>
					</div>

					<div class="float-end">
						<button class="btn btn-outline-secondary px-1 m-1" type="button" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?></button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="MostrarSeriales2" class="modal fullscreen-modal" tabindex="-1" role="dialog" data-bs-keyboard="false">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?php echo lang("Información del Producto");  ?>: <span id="serialesspan2x"></span></h5>
				<div class="card-actions">
					<div class='float-end'>
						<button data-bs-dismiss="modal" class='btn  btn-outline-secondary' type="button"><span class="fa fa-close"></span></button>
					</div>
				</div>
			</div>
			<div class="modal-body tab-content">
				<div class="tab-pane" id="Seriales">
					<div class="form-group row">
						<span id="Heisenberg2"><?php echo lang('Cargando...'); ?></span>
					</div>
					<div class="modal-footer">
						<div class="container">
							<div class="float-start">
								<?php if ($_SESSION['MVaria'] == 1) { ?>
									<button class="btn btn-outline-primary px-1 m-1 " type="button" onclick='proceso(1)'><i class="fa fa-arrow-right"></i> <?php echo lang('Ingresar'); ?></button>
									<?php if ($_SESSION['userperfil'] <= 2000 || $_SESSION["userperfil"] === "2080" || $_SESSION["userperfil"] === "2060" || $_SESSION["userperfil"] === "2055" || $_SESSION["userperfil"] == "2054" || $_SESSION["userperfil"] == "2053" || $_SESSION["userperfil"] === "2056" || $_SESSION["userperfil"] === "2710" || ($_SESSION["userlogin"] === "DULCE" && $_SESSION["CompanyActual"] === "1125")) { ?>
										<button class=" btn btn-outline-dark px-1 m-1" type="button" title="Historial del Producto" onclick="auditoriaS(document.getElementById('serialesspan2').innerHTML)"><span class="fa fa-eye"></span> <?php echo lang("Historial del Producto"); ?></button>
									<?php } ?>
								<?php } ?>
								<button class="btn btn-outline-primary px-1 m-1 " type="button" onclick='ImprimirAllData();'><i class="fa fa-print"></i> <?php echo lang('Imprimir Todos'); ?></button>

							</div>

							<div class="float-end">
								<button class="btn btn-outline-secondary px-1" type="button" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?></button>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="Pedidos">
					<div class="form-group row">
						<div id="Lucille"><?php echo lang('Cargando...'); ?>
							<span id='PagAct2' style='display:none;'>1</span>
						</div>
					</div>
					<div class="modal-footer">
						<button class="btn btn-outline-secondary px-1" type="button" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?></button>
					</div>
					<span style='display:none;' id='thelimite'>10</span>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
include "serialesauto.php";
?>

<div id="apps-auditoriaS" class="modal fullscreen-modal" tabindex="-1" role="dialog" data-bs-keyboard="false">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?php echo lang("Auditoría de seriales del Producto");  ?> </h5>
				<button data-bs-dismiss="modal" class="btn-close" type="button"></button>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table class="table table-hover table-striped nowrap" id="AuditoriaS" cellspacing="0" style="width:100%">
						<thead>
							<tr>
								<th><?php echo lang("Variación"); ?></th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="apps-modal4" class="modal fade" tabindex="-1" role="dialog" data-bs-keyboard="false">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?php echo lang("FOTOGRAFIAS DEL PRODUCTO");  ?> <strong id="algov22"></strong></h5>
				<button data-bs-dismiss="modal" class="btn-close" type="button"></button>
			</div>
			<div class="modal-body">
				<div id="ledner"><?php echo lang('Cargando...'); ?> </div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-outline-secondary px-1 m-1" type="button" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?></button>
			</div>
		</div>
	</div>
</div>

<div id="htmlmodal" class="modal fade " tabindex="-1" role="dialog" data-bs-keyboard="false">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?php echo lang('Información Web'); ?><strong id="algov2"></strong></h5>
				<button data-bs-dismiss="modal" class="btn-close" type="button"></button>
			</div>
			<div class="modal-body">
				<form id="caracteres" method="POST" target="_Blank" action="guardafoto.php" onsubmit="return false">
					<input type="hidden" class="form-control" id="tabla" name="tabla" value="ProductosP1" />
					<input type="hidden" class="form-control" id="companyUserM" name="companyUserM" value="<?php echo $_SESSION["CompanyActual"]; ?>" />
					<div class="row input-group">
						<div class="col-12 col-lg-6">
							<div class="form-floating">
								<input type="text" class="form-control" id="BarraBlack" name="BarraBlack" value="" readonly />
								<label><i class="fa fa-barcode"></i>&nbsp;<?php echo lang('Código de Barras'); ?></label>
							</div>
						</div>
						<div class="col-12 col-lg-6">
							<div class="form-floating">
								<input type="text" class="form-control" id="ComoTeves" name="ComoTeves" value="" readonly />
								<label><i class="fa fa-bars"></i>&nbsp;<?php echo lang('Descripción'); ?></label>
							</div>
						</div>
					</div>


					<div style='display:none' class="col-xs-6">
						<label for="ModalDescripcion">codigo</label>
						<input type="text" class="form-control" id="codiguito" name="codiguito" value="" readonly />
					</div>
					<div style='visibility:hidden' class="col-xs-6">
						<label for="ModalDescripcions">Descripcion</label>
					</div>
					<div class="row">
						<ul class="nav nav-tabs" id="myTab" role="tablist">
							<li class="nav-item" role="presentation">
								<button class="nav-link active" data-bs-toggle="tab" data-bs-target="#uploadTab" type="button" role="tab" aria-controls="contact" aria-selected="false"><?php echo lang('Descripción Larga'); ?></button>
							</li>
							<li class="nav-item" role="presentation">
								<button class="nav-link" data-bs-toggle="tab" data-bs-target="#uploadTab2" type="button" role="tab" aria-controls="contact" aria-selected="false"><?php echo lang('Descripción Corta'); ?></button>
							</li>
						</ul>
						<!-- Tab panes -->
						<div class="tab-content" id="myTabContent">
							<div role="tabpanel" class="tab-pane active" id="uploadTab">
								<div><textarea id="editor" name="editor" rows="40"></textarea></div>
							</div>
							<div role="tabpanel" class="tab-pane" id="uploadTab2">
								<div><textarea id="editor2" name="editor2" rows="40"></textarea></div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button class="btn btn-outline-secondary px-1 m-1" type="button" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?></button>
						<button class="btn btn-outline-primary px-1 m-1" type="button" onclick="runhtml();"><i class="fa fa-save"></i> <?php echo lang('Guardar'); ?></button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div id="apps-modallptm" class="modal fade" tabindex="-1" role="dialog" data-bs-keyboard="false">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?php echo lang('Información de Seriales'); ?><strong id="algov2"></strong></h5>
				<button data-bs-dismiss="modal" class="btn-close" type="button" onclick=' $("#MostrarSeriales2").modal("show");'></button>
			</div>
			<div class="modal-body">
				<form class="fieldset" method="post" id="formdataVariacion" onsubmit="return false">
					<div class="row input-group">
						<input type="hidden" class="form-control" id="tabla" name="tabla" value="ProductosP1" />
						<input type="hidden" class="form-control" name="CompanyActual" value="<?php echo $_SESSION["CompanyActual"]; ?>" />
						<input type="hidden" class="form-control" name="companyUser" value="<?php echo $_SESSION["userCompany"]; ?>" />
						<input type="hidden" class="form-control" name="userlogin" value="<?php echo $_SESSION["userlogin"]; ?>" />
						<input type="hidden" class="form-control" name="userCompany" value="<?php echo $_SESSION["userCompany"]; ?>" />
						<div class="col-12 col-lg-6 p-1">
							<div class="form-floating">
								<input type="text" class="form-control " id="ModalCodIdAmpliado22" name="ModalCodIdAmpliado22" value="" readonly />
								<label><span class="fa fa-barcode"></span>&nbsp;<?php echo lang('Serial'); ?></label>
							</div>
						</div>
						<div class="col-12 col-lg-6 p-1">
							<div class="form-floating">
								<input type="text" class="form-control" id="ModalCodBarra22" name="ModalCodBarra22" value="" readonly />
								<label><i class="fa fa-barcode"></i>&nbsp;<?php echo lang('Código de Barras'); ?></label>
							</div>
						</div>

						<div class="col-12 col-lg-6 p-1">
							<div class="form-floating">
								<input type="text" class="form-control" id="ModalDescripcion22" name="ModalDescripcion2" value="" readonly />
								<label><i class="fa fa-bars" aria-hidden="true"></i>&nbsp;<?php echo lang('Descripción'); ?></label>
							</div>
						</div>
						<div class="col-12 col-lg-6 p-1">
							<div class="form-floating">
								<input type="number" class="form-control" id="Valor" name="Valor" value="" />
								<label><span class="fa fa-barcode"></span>&nbsp;<?php echo lang('Valor'); ?></label>
							</div>
						</div>

						<div class="col-12 col-lg-4 p-1">
							<div class="form-floating">
								<input type="number" class="form-control" id="AltoSerial" name="AltoSerial" value="" onchange="calcArea()" />
								<label><span class="fa fa-barcode"></span>&nbsp;<?php echo lang('Alto'); ?></label>
							</div>
						</div>

						<div class="col-12 col-lg-4 p-1">
							<div class="form-floating">
								<input type="number" class="form-control" id="AnchoSerial" name="AnchoSerial" value="" onchange="calcArea()" />
								<label><span class="fa fa-barcode"></span>&nbsp;<?php echo lang('Ancho'); ?></label>
							</div>
						</div>

						<div class="col-12 col-lg-4 p-1">
							<div class="form-floating">
								<input type="number" class="form-control" id="AreaSerial" name="AreaSerial" value="" disabled />
								<label><span class="fa fa-barcode"></span>&nbsp;<?php echo lang('Area'); ?></label>
							</div>
						</div>

						<input type="hidden" id="AreaSerial2" name="AreaSerial2" />

						<?php
						$query322 = "SELECT IdVarios,ITEM,esserial,pathimg FROM PosUpvarios WHERE TIPOITEM=1001 and IdCompany=" . $_SESSION["CompanyActual"] . " Order by ITEM";
						if ($result322 = mysqli_query($conn, $query322)) {
							$n = 0;
							while ($row322 = mysqli_fetch_assoc($result322)) {
								$npi = $npi + 1;
								$n = $n + 1;
						?>
								<div class=" col-6 col-sm-4 col-md-3 col-lg-3">
									<div class="input-group mb-3">
										<span class="input-group-text "><span class="<?php echo $row322["pathimg"]; ?>"></span>&nbsp;<?php echo $row322["ITEM"]; ?></span>
										<select class="form-select" id="ide<?php echo $n; ?>" name="ide<?php echo $n; ?>" data-placeholder="Choose one..">
											<?php
											$query32 = "select '*','Seleccione' union SELECT a.IdVarios,a.ITEM
                                                            from PosUpvarios a
                                                            inner join (select TIPOITEM,esserial,IdCompany,ITEM FROM PosUpvarios where IdCompany=" . $_SESSION["CompanyActual"] . " and TIPOITEM=1001) c on a.IdCompany=c.IdCompany and a.esserial=c.esserial
                                                            where a.TIPOITEM=1002  and a.IdCompany=" . $_SESSION["CompanyActual"] . " and c.esserial=" . $row322["esserial"] . " ";
											if ($result32 = mysqli_query($conn, $query32)) {
												while ($row32 = mysqli_fetch_assoc($result32)) {
											?>
													<option value="<?php echo $row32["*"]; ?>"><?php echo $row32["Seleccione"]; ?></option>
											<?php
												}
												mysqli_free_result($result32);
											}
											?>
										</select>
									</div>
								</div>
								<div style="display:none" class="col-xs-6">
									<label for="ModalDescripcion">TipoVariacion</label>
									<input type="text" class="form-control" id="Tvaria<?php echo $n; ?>" name="Tvaria<?php echo $n; ?>" value="<?php echo $row322["esserial"]; ?>" />
								</div>
								<div style="display:none" class="col-xs-6">
									<label for="Nombre">Nombre de Variacion</label>
									<input type="text" class="form-control" id="nombre<?php echo $n; ?>" name="nombre<?php echo $n; ?>" value="<?php echo $row322["ITEM"]; ?>" />
								</div>
						<?php
							}
							mysqli_free_result($result322);
						}
						?>

						<div style="display:none" class="col-xs-6">
							<label for="ModalDescripcion">TipoVariacion</label>
							<input type="text" class="form-control" id="TipoVariacion" name="TipoVariacion" value="" readonly />
						</div>
						<div style="display:none" class="col-xs-6">
							<label for="ModalDescripcion">CodIdBasico</label>
							<input type="text" class="form-control" id="CodIdBasico" name="CodIdBasico" value="" readonly />
						</div>
						<div style="display:none" class="col-xs-6">
							<label for="ModalDescripcion">id</label>
							<input type="text" class="form-control" id="id" name="id" value="" readonly />
						</div>
						<div style="display:none" class="col-xs-6">
							<label for="ModalDescripcion">id2</label>
							<input type="text" class="form-control" id="id2" name="id2" value="" readonly />
						</div>
						<div style="display:none" class="col-xs-6">
							<label for="ModalDescripcion">npi</label>
							<button id="npi" name="npi" value="<?php echo  $npi;  ?>"><?php echo $npi; ?></button>
						</div>
					</div>
					<div class="modal-footer">
						<button class="btn btn-outline-secondary px-1 m-1" type="button" data-bs-dismiss="modal" onclick=' $("#MostrarSeriales2").modal("show");'><i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?></button>
						<button class="btn btn-outline-primary px-1 m-1" type="button" onclick="guardar23();"><i class="fa fa-save"></i> <?php echo lang('Guardar'); ?></button>
					</div>
					<span style="display:none" name="devueltachavalesLP" id="devueltachavalesLP"></span>
					<span style="display:none" name="documento" id="documento"></span>
				</form>
			</div>
		</div>
	</div>
</div>

<div id="apps-odolito" class="modal fade " tabindex="-1" role="dialog" data-bs-keyboard="false">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?php echo lang("Editar en Grupo ");  ?><span style="display:none" id="serialesspan2"></span></h5>
				<button data-bs-dismiss="modal" class="btn-close" type="button"></button>
			</div>
			<div class="modal-body tab-content">
				<form class="fieldset" method="post" id="formMultiple" onsubmit="return false">
					<div class="row input-group">
						<input type="hidden" class="form-control" name="tabla" value="ProductosP1" />
						<input type="hidden" class="form-control" name="companyUserM" value="<?php echo $_SESSION["CompanyActual"]; ?>" />

						<input type="hidden" class="form-control" name="CompanyActualM" value="<?php echo $_SESSION["CompanyActual"]; ?>" />
						<input type="hidden" class="form-control" name="userloginM" value="<?php echo $_SESSION["userlogin"]; ?>" />
						<input type="hidden" class="form-control" name="userCompanyM" value="<?php echo $_SESSION["userCompany"]; ?>" />
						<div class="col-12 col-lg-6">
							<div class="form-floating">
								<input type="text" class="form-control" id="ModalCodBarraM" name="ModalCodBarraM" value="" readonly />
								<label for="ModalCodBarra"><i class="fa fa-barcode"></i>&nbsp;<?php echo lang('Código de Barras'); ?></label>
							</div>
						</div>
						<div class="col-12 col-lg-6">
							<div class="form-floating">
								<input type="text" class="form-control" id="ModalDescripcionM" name="ModalDescripcionM" value="" readonly />
								<label><i class="fa fa-bars" aria-hidden="true"></i>&nbsp;<?php echo lang('Descripción'); ?></label>
							</div>
						</div>


						<?php
						$query322 = "SELECT IdVarios,ITEM,esserial,pathimg FROM PosUpvarios WHERE TIPOITEM=1001 and IdCompany=" . $_SESSION["CompanyActual"] . " Order by ITEM";
						if ($result322 = mysqli_query($conn, $query322)) {
							while ($row322 = mysqli_fetch_assoc($result322)) {
								$npiM = $npiM + 1;
								$nM = $nM + 1;
						?>
								<div class=" col-6 col-sm-4 col-md-3 col-lg-3">
									<div class="form-floating">
										<select class="form-select" id="ideM<?php echo $nM; ?>" name="ideM<?php echo $nM; ?>" data-placeholder="Choose one.."><?php
																																								$query32 = "select '*','Seleccione' union SELECT a.IdVarios,a.ITEM
                                            from PosUpvarios a
                                            inner join (select TIPOITEM,esserial,IdCompany,ITEM FROM PosUpvarios where IdCompany=" . $_SESSION["CompanyActual"] . " and TIPOITEM=1001) c on a.IdCompany=c.IdCompany and a.esserial=c.esserial
                                            where a.TIPOITEM=1002  and a.IdCompany=" . $_SESSION["CompanyActual"] . " and c.esserial=" . $row322["esserial"] . " ";
																																								if ($result32 = mysqli_query($conn, $query32)) {
																																									while ($row32 = mysqli_fetch_assoc($result32)) { ?>
													<option value="<?php echo $row32["*"]; ?>"><?php echo $row32["Seleccione"]; ?></option> <?php
																																									}
																																									mysqli_free_result($result32);
																																								} ?>
										</select>
										<label for="OrdenLP"><span class='<?php echo $row322["pathimg"]; ?>'></span>&nbsp;<?php echo $row322["ITEM"]; ?></label>
									</div>
								</div>
								<div style="display:none" class="col-xs-6">
									<label for="ModalDescripcion">TipoVariacion</label>
									<input type="text" class="form-control" id="TvariaM<?php echo $nM; ?>" name="TvariaM<?php echo $nM; ?>" value="<?php echo $row322["esserial"]; ?>" />
								</div>
								<div style="display:none" class="col-xs-6">
									<label for="Nombre">Nombre de Variacion</label>
									<input type="text" class="form-control" id="nombreM<?php echo $nM; ?>" name="nombreM<?php echo $nM; ?>" value="<?php echo $row322["ITEM"]; ?>" />
								</div>
						<?php
							}
							mysqli_free_result($result322);
						}                ?>

						<div style="display:none" class="col-xs-6">
							<label for="ModalDescripcion">TipoVariacion</label>
							<input type="text" class="form-control" id="TipoVariacionM" name="TipoVariacionM" value="" readonly />
						</div>
						<div style="display:none" class="col-xs-6">
							<label for="ModalDescripcion">CodIdBasico</label>
							<input type="text" class="form-control" id="CodIdBasicoM" name="CodIdBasicoM" value="" readonly />
						</div>
						<div style="display:none" class="col-xs-6">
							<label for="ModalDescripcion">id</label>
							<input type="text" class="form-control" id="idM" name="idM" value="" readonly />
						</div>
						<div style="display:none" class="col-xs-6">
							<label for="ModalDescripcion">id2</label>
							<input type="text" class="form-control" id="id2M" name="id2M" value="" readonly />
						</div>
						<div style="display:none" class="col-xs-6">
							<label for="ModalDescripcion">npi</label>
							<button id="npiM" name="npiM" value="<?php echo  $npiM;  ?>"><?php echo $npiM; ?></button>
						</div>
						<div style="display:none" class="col-6">
							<label for="ModalDescripcion">pensamientoteorico2</label>
							<input type="text" class="form-control" id="pensamientoteorico2" name="pensamientoteorico2" value="" readonly />
						</div>
						<div style="display:none" class="col-6">
							<label for="ModalDescripcion">pensamientoteorico2</label>
							<input type="text" class="form-control" id="ListaSeriales2" name="ListaSeriales2" value="" readonly />
						</div>
					</div>
					<div class="row">
						<div class="form-floating">
							<input type="text" class="form-control" id="InsertaSerial" name="InsertaSerial" value="" onchange="serialito()" autocomplete="off" />
							<label><span class='fa fa-edit'></span>&nbsp;<?php echo lang('Serial'); ?></label>
						</div>
					</div>
					<div style=" text-align: left;" class="card">
						<div class="border border-3 border-warning p-2 rounded-2" role="alert" id="errorsobrejson" style="display:none;"></div>
						<div style="  width: 100%; height:275px; overflow: scroll; overflow-x:auto">
							<div id="pensamientoteorico" style="display:none"></div>
							<div id="ListaSeriales">
								<div id="Seriales"></div>
								<div id="numerocontador"></div>
							</div>
							<div id="esd">&nbsp;&nbsp;<?php echo lang('Cantidad de Seriales'); ?>: <span id="elmostradordecontador">0</span></div><br>
						</div>
					</div>
					<span style="display:none" name="devueltachavalesLP" id="devueltachavalesLP"></span>
					<span style="display:none" name="documento" id="documento"></span>
				</form>
			</div>
			<div class="modal-footer">
				<button class="btn btn-outline-secondary px-1 m-1" type="button" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?></button>
				<button class="btn btn-outline-primary px-1 m-1" type="button" onclick="guardar32();"><i class="fa fa-save"></i> <?php echo lang('Guardar'); ?></button>
			</div>
		</div>
	</div>
</div>

<div id="apps-auditoria" class="modal fullscreen-modal" tabindex="-1" role="dialog" data-bs-keyboard="false">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?php echo lang("Auditoría del Producto");  ?> </h5>
				<button data-bs-dismiss="modal" class="btn-close" type="button"></button>
			</div>
			<div class="modal-body">
				<div class="d-flex justify-content-end text-end gap-2" id="spinner_load2">
					<div><strong class="text-primary fs-6"><?php echo lang('Cargando'); ?></strong></div>
					<div class="spinner-grow text-primary fs-6 " role="status" aria-hidden="true" style="width: 1.3rem !important; height: 1.3rem !important;"></div>
				</div>
				<div class="table-responsive">

					<table class="table table-hover table-striped nowrap" id="AuditoriaBr" cellspacing="0" style="width:100%">
						<thead>
							<tr>
								<th><?php echo lang("Información"); ?></th>
								<th><?php echo lang("Datos"); ?></th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="apps-complementos" class="modal fade d-print-none" tabindex="-1" role="dialog">
	<div class="modal-dialog   modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?php echo lang('Complementos'); ?></h5>
				<button data-bs-dismiss="modal" class="btn-close" type="button"></button>
			</div>
			<div class="modal-body">
				<div class="border border-3 border-danger p-2 rounded-2" id="alertaerrorenproducto4" style="display:none;"><strong><i class="fa fa-times-circle text-danger"></i> <?php echo lang('Error al guardar'); ?></strong><br><small><?php echo lang('Se ha producido un error durante el guardado.'); ?></small></div>
				<form class="fieldset" method="post" id="formdata">
					<div class="row input-group ">
						<div class="form-group row">
							<input type="hidden" class="form-control" id="tabla" name="tabla" value="perfiles" />
							<input type="hidden" class="form-control" id="companyUser" name="companyUser" value="<?php echo $_SESSION["CompanyActual"]; ?>" />
							<div class="col-12 col-lg-6">
								<span id='selectt'>
								</span>
							</div>
						</div>
						<input id='option2' name='option2' style='display:none'></input>
						<input id='jcod2o' name='jcod2o' style='display:none'></input>
						<div class="col-xs-6" style='display:none'>
							<label for="ModalValor">Perfil</label>
							<input type="text" class="form-control" id="perf" name="perf" />
						</div>
						<span id='optiones'>
							<input id='jcodo' name='jcodo' style='display:none'></input>
						</span>
					</div>
					<div class="form-group row">
						<div class="modal-footer">
							<button class="btn btn-outline-secondary m-1 px-1" type="button" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?></button>
							<button class="btn btn-outline-primary m-1 px-1" type="button" onclick="guardarcomplementos();"><i class="fa fa-save"></i> <?php echo lang('Guardar'); ?></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div id="modalClose" class="modal fade" tabindex="-1" role="dialog" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header bg-warning text-dark">
				<h5 class="modal-title"><i class="fa fa-exclamation-triangle"></i> <?php echo lang('Cambiar Costo'); ?></h5>
			</div>
			<div class="modal-body">
				<div class="border border-3 border-danger p-2 rounded-2" id="alertaerrorenproducto5" style="display:none;"><strong><i class="fa fa-times-circle text-danger"></i> <?php echo lang('Error al guardar'); ?></strong><br><small><?php echo lang('Se ha producido un error durante el guardado.'); ?></small></div>
				<span id="CodeDel" class="d-none"></span>
				<div class="row float-center text-center">
					<div class="col-12">
						<img src="img/warningtriangle.gif" style="width: 128px;">
					</div>
					<div class="col-12">
						<h3><strong><?php echo lang("¿Esta Seguro?"); ?></strong></h3>
					</div>
					<div class="col-12"><?php echo lang("Hay una diferencia importante mayor a la tolerancia permitida en el sistema entre el costo anterior y el nuevo. Usted esta seguro de aceptar este cambio?"); ?></div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-outline-secondary px-1 m-1" type="button" onclick="closeCost(0)"><i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?></button>
				<button class="btn btn-outline-danger px-1 m-1" type="button" onclick="closeCost(1)"><i class="fa fa-primary"></i> <?php echo lang('Cambiar'); ?></button>
			</div>
		</div>
	</div>
</div>

<div id="apps-delet" class="modal fade" tabindex="-1" role="dialog" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header bg-danger text-light">
				<h5 class="modal-title"><?php echo lang('Borrar Registro'); ?></h5>
				<button data-bs-dismiss="modal" class="btn-close" type="button"></button>
			</div>
			<div class="modal-body">
				<div class="border border-3 border-danger p-2 rounded-2" id="alertaerrorenproducto5" style="display:none;"><strong><i class="fa fa-times-circle text-danger"></i> <?php echo lang('Error al guardar'); ?></strong><br><small><?php echo lang('Se ha producido un error durante el guardado.'); ?></small></div>
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
				<button class="btn btn-outline-secondary px-1 m-1" type="button" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang('Cancelar'); ?></button>
				<button class="btn btn-outline-danger px-1 m-1" type="button" onclick="alertaborrar2();"><i class="fa fa-trash"></i> <?php echo lang('Si, bórralo!'); ?></button>
			</div>
		</div>
	</div>
</div>

<div id="ModalHistoricoSerial" class="modal fade" tabindex="-1" role="dialog" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-xl modal-dialog modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?php echo lang('Histórico de Serial'); ?> </h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body p-1">
				<div class="row">
					<div class="col-12 my-1">
						<div class="form-floating">
							<input type="text" class="form-control" id="historicoSerialInt" onchange="HistoricoSerial();" />
							<label><?php echo lang("Serial"); ?></label>
						</div>
						<div class="invalid-feedback" id="errorhistserial">
							<?php echo lang("El Serial es Inválido o no existe movimiento entre las fechas"); ?>
						</div>
					</div>
					<div class="col-12 col-lg-3 my-1">
						<div class="col">
							<div class="form-floating">
								<select class="form-select" id="SelectorDiaMesHistSer1" onchange="Selectorangodelhis1();">
									<option value="1"><?php echo lang("Del Día"); ?></option>
									<option value="2"><?php echo lang("Del Día Anterior"); ?></option>
									<option value="3"><?php echo lang("Del Mes"); ?></option>
									<option value="4"><?php echo lang("Del Mes Anterior"); ?></option>
									<option value="5"><?php echo lang("Por Rango"); ?></option>
								</select>
								<label><i class="fa fa-bars"></i> <?php echo lang("Rango"); ?></label>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-3 my-1">
						<div class="col">
							<div class="form-floating">
								<input class="form-control" type="DATETIME-LOCAL" id="ModaldesdeHistSer1" onchange="HistoricoSerial();" disabled />
								<label><i class="fa fa-calendar"></i> <?php echo lang("Desde"); ?></label>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-3 my-1">
						<div class="col">
							<div class="form-floating">
								<input class="form-control" type="DATETIME-LOCAL" id="ModalhastaHistSer1" onchange="HistoricoSerial();" disabled />
								<label><i class="fa fa-calendar"></i> <?php echo lang("Hasta"); ?></label>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-3 my-1">
						<div class="col">
							<div class="form-floating">
								<input class="form-control text-end" type="text" id="InventarioInicialHistorial" disabled />
								<label> <?php echo lang("Inventario Inicial"); ?></label>
							</div>
						</div>
					</div>
				</div>
				<div class="table-responsive" id="HistoricoSerialTable">
				</div>
			</div>
			<div class="modal-footer">
				<span class="fs-4 p-1"><?php echo lang("Inventario Final") . ": "; ?> <strong id="InventarioFinalHistorial"></strong></span>
				<button class="btn btn-outline-secondary px-1 m-1" type="button" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?></button>
			</div>
		</div>
	</div>
</div>

<div id="ModalHistoricoSerial2" class="modal fade" tabindex="-1" role="dialog" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-xl modal-dialog modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?php echo lang('Kardex del producto') . ": "; ?><strong id="DescHistSer"></strong> </h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body p-2">
				<input type="hidden" id="CodIdBasicoHistSer2" />
				<div class="row">
					<div class="col-12 col-lg-6 my-1">
						<div class="col">
							<div class="form-floating">
								<select class="form-select" id="SelectorSucursal" onchange="CambiarUbicacion();">
									<option value="*"><?php echo lang("Todos"); ?></option>
									<?
									$SelectorSucursal = "";
									$query = "SELECT IdUbi,Nombre FROM PosUpUbicacion WHERE IdCompany=" . $_SESSION["CompanyActual"] . "";

									if ($result = mysqli_query($conn, $query)) {
										while ($row = mysqli_fetch_assoc($result)) {
											$SelectorSucursal .= "<option value='" . trim($row['IdUbi']) . "'>" . trim($row['Nombre']) . "</option>";
										}
										mysqli_free_result($result);
									}
									echo $SelectorSucursal;
									?>
								</select>
								<label><i class="fa fa-map-marker"></i> <?php echo lang("Ubicación"); ?></label>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-6 my-1">
						<div class="col">
							<div class="form-floating" id="AlmacenEntry">
								<?php echo $response; ?>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-3 my-1">
						<div class="col">
							<div class="form-floating">
								<select class="form-select" id="SelectorDiaMesHistSer2" onchange="Selectorangodelhis2();">
									<option value="1"><?php echo lang("Del Día"); ?></option>
									<option value="2"><?php echo lang("Del Día Anterior"); ?></option>
									<option value="3"><?php echo lang("Del Mes"); ?></option>
									<option value="4"><?php echo lang("Del Mes Anterior"); ?></option>
									<option value="5"><?php echo lang("Por Rango"); ?></option>
								</select>
								<label><i class="fa fa-bars"></i> <?php echo lang("Rango"); ?></label>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-3 my-1">
						<div class="col">
							<div class="form-floating">
								<input class="form-control" type="DATETIME-LOCAL" id="ModaldesdeHistSer2" onchange="HistoricoSerial2();" disabled />
								<label><i class="fa fa-calendar"></i> <?php echo lang("Desde"); ?></label>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-3 my-1">
						<div class="col">
							<div class="form-floating">
								<input class="form-control" type="DATETIME-LOCAL" id="ModalhastaHistSer2" onchange="HistoricoSerial2();" disabled />
								<label><i class="fa fa-calendar"></i> <?php echo lang("Hasta"); ?></label>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-3 my-1">
						<div class="col">
							<div class="form-floating">
								<input class="form-control text-end" type="text" id="InventarioInicialHistorial2" disabled />
								<label> <?php echo lang("Inventario Inicial"); ?></label>
							</div>
						</div>
					</div>
					<div class="table-responsive" id="HistoricoSerialTable2">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<span class="fs-4 p-1"><?php echo lang("Inventario Final") . ": "; ?> <strong id="InventarioFinalHistorial2"></strong></span>
				<button class="btn btn-outline-secondary px-1 m-1" type="button" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?></button>
			</div>
		</div>
	</div>
</div>

<div id="ModalEstadisticaProductoABCV" class="modal fade" tabindex="-1" role="dialog" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-xl modal-dialog modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?php echo lang('Estadística Compra - Venta') . ": "; ?><strong id="EstadistProdDes"></strong> <button class="btn btn-outline-dark px-1" type="button" onclick="ImprimirMirPrimir()"><i class="fa fa-print"></i></button> </h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body p-2">
				<div class="row">
					<div class="col-12">
						<div class="form-floating">
							<select class="form-control " name="MostrarDatosA" id="MostrarDatosA" onchange="ActualizarProductos()">
								<option value="0"><?php echo lang("Por Almacen"); ?></option>
								<option value="1"><?php echo lang("Por Ubicacion"); ?></option>
								<option value="2"><?php echo lang("Por Zona de Atención"); ?></option>
							</select>
							<label for="Mostrar"><?php echo lang("Mostrar"); ?></label>
						</div>
					</div>
					<div class="table-responsive" id="EstCaca">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-outline-secondary px-1 m-1" type="button" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?></button>
			</div>
		</div>
	</div>
</div>

<div id="ModalEstadisticaProducto" class="modal fade" tabindex="-1" role="dialog" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-xl modal-dialog modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bar-chart" viewBox="0 0 16 16">
						<path d="M4 11H2v3h2zm5-4H7v7h2zm5-5v12h-2V2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1z" />
					</svg>
					<?php echo lang('Estadística del producto') . ": "; ?><strong id="DescEstadistica"></strong>
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12 col-lg-4 p-1">
						<div class="col">
							<div class="form-floating">
								<select class="form-select" name="SelectorDiaMesEstadistica" id="SelectorDiaMesEstadistica" onchange="SelectorangodelEstadistica();">
									<option value="1"><?php echo lang("Del Día"); ?></option>
									<option value="2"><?php echo lang("Del Día Anterior"); ?></option>
									<option value="3"><?php echo lang("Del Mes"); ?></option>
									<option value="4"><?php echo lang("Del Mes Anterior"); ?></option>
									<option value="5"><?php echo lang("Por Rango"); ?></option>
								</select>
								<label><i class="fa fa-bars"></i> <?php echo lang("Rango"); ?></label>
							</div>
						</div>
					</div>

					<div class="col-12 col-lg-4 p-1">
						<div class="col">
							<div class="form-floating">
								<input class="form-control" type="DATETIME-LOCAL" name="ModaldesdeEstadistica" id="ModaldesdeEstadistica" onchange="RefreshEstProduco();" disabled />
								<label><i class="fa fa-calendar"></i> <?php echo lang("Desde"); ?></label>
							</div>
						</div>
					</div>

					<div class="col-12 col-lg-4 p-1">
						<div class="col">
							<div class="form-floating">
								<input class="form-control" type="DATETIME-LOCAL" name="ModalhastaEstadistica" id="ModalhastaEstadistica" onchange="RefreshEstProduco();" disabled />
								<label><i class="fa fa-calendar"></i> <?php echo lang("Hasta"); ?></label>
							</div>
						</div>
					</div>
				</div>

				<div class="row">

					<div class="col-5 my-1">
						<div>
							<div class="card">
								<div class="card-body d-flex justify-content-between">
									<div>
										<i class="fa fa-shopping-cart fs-2"></i>
									</div>
									<div>
										<h5 class="card-title fs-4">Cantidad de Compras</h5>
									</div>
								</div>
							</div>
						</div>
						<div class="row" id="CantidadDeCompras">
						</div>
					</div>

					<div class="col-5 my-1">
						<div>
							<div class="card">
								<div class="card-body d-flex justify-content-between">
									<div>
										<i class="fa fa-money fs-2"></i>
									</div>
									<div>
										<div>
											<h5 class="card-title fs-4">Cantidad de Ventas</h5>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row" id="CantidadDeVentas">
						</div>
					</div>
					<div class="col-2 my-1">
						<div class="card">
							<div class="card-body d-flex justify-content-between">
								<div>
									<i class="fa fa-percent fs-2"></i>
								</div>
								<div>
									<div>
										<h5 class="card-title fs-4">Utilidad</h5>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
			<div class="modal-footer">
				<!-- <span class="fs-4 p-1"><?php echo lang("Inventario Final") . ": "; ?> <strong id="InventarioFinalHistorial2"></strong></span>
					<button class="btn btn-outline-secondary px-1 m-1" type="button" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?></button> -->
			</div>
		</div>
	</div>
</div>

<div id="ModalCodigoBarras" class="modal fade" tabindex="-1" role="dialog" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-xl modal-dialog modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?php echo lang('Escanear Codigo de Barras'); ?> </h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="qr-response"></div>
				<div id="qr-reader"></div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-outline-secondary px-1 m-1" type="button" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?></button>
				<button class="btn btn-outline-primary px-1 m-1" id="SendScanCo" type="button" onclick="SendScan();"><i class="fa fa-arrow-right"></i> <?php echo lang('Enviar'); ?></button>
			</div>
		</div>
	</div>
</div>

<div id="modal-marca" class="modal fade" tabindex="-1" role="dialog" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h4><?php echo lang('Agregar Marca'); ?></h4>
				<div class="card-actions">
					<div class='float-end'>
						<button data-bs-dismiss="modal" class="btn btn-outline-secondary" id="boton001" type="button" onclick='$("#apps-modal").modal("show");'><span class="fa fa-close"></span></button>
					</div>
				</div>
			</div>
			<div class="modal-body">
				<div class="border border-3 border-warning p-2 rounded-2" role="alert" id="alertaerrorenmarca" style="display:none;"></div>
				<div class="border border-3 border-danger p-2 rounded-2" id="alertaerrorenmarca3" style="display:none;"><strong><i class="fa fa-times-circle text-danger"></i> <?php echo lang('Error al guardar'); ?></strong><br><small><?php echo lang('Se ha producido un error durante el guardado.'); ?></small></div>
				<div class="row">
					<form class="fieldset" method="post" id="formdataMarca">
						<input type="hidden" class="form-control" name="tabla" value="marcas" />
						<input type="hidden" class="form-control" name="companyUser" value="<?php echo $_SESSION["CompanyActual"]; ?>" />
						<input type="hidden" class="form-control" id="ModalIdMarMarca" name="ModalIdMar" />
						<input type="hidden" class="form-control" id="ModalIdMar2Marca" name="ModalIdMar2" />
						<div class="row">
							<div class="col-12 p-1">
								<div class="col">
									<div class="form-floating">
										<input type="text" class="form-control" id="ModalNombreMarca" name="ModalNombre" onkeypress="return DevolverCaracteres(event)" />
										<label><i class="fa fa-tags"></i> <?php echo lang('Nombre'); ?></label>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-outline-secondary" type="button" id="boton002" data-bs-dismiss="modal" onclick='$("#apps-modal").modal("show");'><?php echo lang('Cerrar'); ?></button>
				<button class="btn btn-outline-primary" type="button" id="boton003" onclick="guardarMarcaApa();"><?php echo lang('Guardar'); ?></button>
			</div>
		</div>
	</div>
</div>

<div id="modal-familia" class="modal fade" tabindex="-1" role="dialog" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?php echo lang('Editar Familia'); ?></h5>
				<button data-bs-dismiss="modal" class="btn-close" type="button" onclick="$('#apps-modal').modal('show');"></button>
			</div>
			<form class="fieldset" method="post" id="formdataFamilia">
				<div class="modal-body">
					<div class="border border-3 border-warning p-2 rounded-2" role="alert" id="alertaerrorenfamilia" style="display:none;"></div>
					<div class="border border-3 border-danger p-2 rounded-2" id="alertaerrorenfamilia3" style="display:none;"><strong><i class="fa fa-times-circle text-danger"></i> <?php echo lang('Error al guardar'); ?></strong><br><small><?php echo lang('Se ha producido un error durante el guardado.'); ?></small></div>
					<input type="hidden" class="form-control" name="tabla" value="familia" />
					<input type="hidden" class="form-control" name="companyUser" value="<?php echo $_SESSION["CompanyActual"]; ?>" />
					<input type="hidden" class="form-control" id="ModalIdFamilia" name="ModalId" />
					<div class="row">
						<div class="col-12 p-1">
							<div class="col">
								<div class="form-floating">
									<input type="text" class="form-control" id="ModalItemFamilia" name="ModalItem" onkeypress="return DevolverCaracteres(event)" />
									<label><i class="fa fa-th-large"></i> <?php echo lang('Nombre'); ?></label>
								</div>
							</div>
						</div>
						<div class="col-12 p-1">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="ModalSerial" id="ModalSerialFamilia" onchange="PermaTrue()">
								<label class="form-check-label" for="ModalSerial">
									<?php echo lang('Esta familia se maneja por serial'); ?>
								</label>
							</div>
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="ordens" id="ordensFamilia">
								<label class="form-check-label" for="ordens">
									<?php echo lang('Esta familia genera orden de producción'); ?>
								</label>
							</div>
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="ModalLote" id="ModalLoteFamilia">
								<label class="form-check-label" for="ModalLote">
									<?php echo lang('Esta Familia se maneja por lotes y fechas de vencimiento'); ?>
								</label>
							</div>
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="vnta" id="vntaFamilia">
								<label class="form-check-label" for="vnta">
									<?php echo lang('Para la venta'); ?>
								</label>
							</div>
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="vntaweb" id="vntawebFamilia">
								<label class="form-check-label" for="vntaweb">
									<?php echo lang('Para la venta de la tienda web'); ?>
								</label>
							</div>
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="compweb" id="compwebFamilia">
								<label class="form-check-label" for="compweb">
									<?php echo lang('Para seleccionar al comprar en la tienda web'); ?>
								</label>
							</div>
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="esmed" id="esmedFamilia">
								<label class="form-check-label" for="esmed">
									<?php echo lang('Para el uso de medida'); ?>
								</label>
							</div>
						</div>
					</div>

					<div class="modal-footer">
						<button class="btn btn-outline-secondary m-1 px-1" type="button" onclick="$('#apps-modal').modal('show');" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?></button>
						<button class="btn btn-outline-primary m-1 px-1" type="button" onclick="guardarFamilia();"><i class="fa fa-save"></i> <?php echo lang('Guardar'); ?></button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<input type="hidden" class="form-control" id="desaud2" name="desaud2" value="" />
<input type="hidden" class="form-control" id="codaud2" name="codaud2" value="" />
<input type="hidden" class="form-control" id="comp" name="comp" value="" />
<input type="hidden" class="form-control" id="codaud" name="codaud" value="" />
<input type="hidden" class="form-control" id="desaud" name="desaud" value="" />
<input style='display:none' id='not' />
<span id="Temporal" style="display:none;"></span>
<span id='Estees' style='display:none'><?php echo $_SESSION['Ec']; ?></span>
<span id='delvar' class='d-none'>0</span>
<span id='codpadel' class='d-none'></span>
<div class="app-ui-mask-modal"></div>

<script src="jsdev/prodyserv.js?v=<? echo random_int(1, 9999999); ?>"></script>
<script>
	let myChart;
	let IdAct = 0;
	let IdActS = 0;
	let CodIdBasicoAct;
	let Idfamilia = 0;
	let IdfamiliaS = 0;
	let EstadisticaProductoAray = {
		CodIdBasico: -1,
		Descripcion: -1,
		pagina: 1,
	};
	let table;
	let Utils2a = {
		Activo: '<?php echo lang("Activo"); ?>',
		Inactivo: '<?php echo lang("Inactivo"); ?>',
		Opcion_Repetida: '<?php echo lang("Opcion Repetida"); ?>',
		Caracteres_Inválidos: '<?php echo lang("Caracteres Inválidos"); ?>',
		SKU_Repetido: '<?php echo lang("S.K.U Repetido"); ?>',
		Código_Repetido: '<?php echo lang("Código Repetido"); ?>',
		Falta_Información: '<?php echo lang("Falta Información"); ?>',
		Agregar_Producto: '<?php echo lang("Agregar Producto"); ?>',
		Agregar_Servicio: '<?php echo lang("Agregar Servicio"); ?>',
		Editar_Producto: '<?php echo lang("Editar Producto"); ?>',
		Editar_Servicio: '<?php echo lang("Editar Servicio"); ?>',
		Agregar_Variacion: '<?php echo lang("Agregar Variacion"); ?>',
		Editar_Variacion: '<?php echo lang("Editar Variacion"); ?>',
		Variación: '<?php echo lang("Variación"); ?>',
		Descripción_de_Variación: '<?php echo lang("Descripción de Variación"); ?>',
		Desglosar_Stock: '<?php echo lang("Desglosar Stock"); ?>',
		Cargando: '<?php echo lang("Cargando"); ?>',
		Etiqueta_Repetido: '<?php echo lang("Etiqueta Repetido"); ?>',
		Seleccione_una_Ubicación: '<?php echo lang("Seleccione una Ubicación"); ?>',
		Etiqueta_en_Blanco: '<?php echo lang("Etiqueta en Blanco"); ?>',
		Desc1: '<?php echo lang("No puede repetir la misma opcion en el modulo"); ?>',
		Desc2: '<?php echo lang("El código de barras, S.K.U o la descripción estan utilizando caracteres no válidos."); ?>',
		Desc3: '<?php echo lang("El código de barras esta utilizando caracteres no válidos."); ?>',
		Desc4: '<?php echo lang("El S.K.U estan utilizando caracteres no válidos."); ?>',
		Desc5: '<?php echo lang("El descripción estan utilizando caracteres no válidos."); ?>',
		Desc6: '<?php echo lang("El código S.K.U no se puede repetir."); ?>',
		Desc7: '<?php echo lang("Este Código se esta utilizando actualmente en otro producto."); ?>',
		Desc8: '<?php echo lang("Por favor inserte el código de barras."); ?>',
		Desc9: '<?php echo lang("Por favor inserte el código S.K.U."); ?>',
		Desc10: '<?php echo lang("Establecer valores para este producto principal"); ?>',
		Desc11: '<?php echo lang("Este producto es una variación del siguiente producto principal"); ?>',
		Desc12: '<?php echo lang("Establecer valores para este producto principal"); ?>',
		Desc13: '<?php echo lang("¿Desea salir?, los cambios no se guardaran"); ?>',
		Desc14: '<?php echo lang("Algunas de las etiquetas ya ha sido agregada con anterioridad."); ?>',
		Desc15: '<?php echo lang("Debe seleccionar una ubicación valida."); ?>',
		Desc16: '<?php echo lang("No puede se puede dejar la etiqueta en blanco."); ?>',
		Desc17: '<?php echo lang("No puede repetir el mismo código en este Producto."); ?>',
		Desc18: '<?php echo lang("Solo se puede inactivar."); ?>',
		Desc19: '<?php echo lang("El Campo de descripción no puede estar vacío."); ?>',
		Desc20: '<?php echo lang("Ingrese la Familia del Producto."); ?>',
		Desc21: '<?php echo lang("Debe indicar el alto de la pieza."); ?>',
		Desc22: '<?php echo lang("El campo es un dato requerido para avanzar debe indicar el alto de la pieza."); ?>',
		Desc23: '<?php echo lang("Debe indicar el ancho de la pieza."); ?>',
		Desc24: '<?php echo lang("El campo es un dato requerido para avanzar debe indicar el ancho de la pieza."); ?>',
		Desc25: '<?php echo lang("Debe haber un área calculada para la pieza."); ?>',
		Desc26: '<?php echo lang("El campo es un dato requerido para avanzar debe haber un área calculada para la pieza."); ?>',
		Desc27: '<?php echo lang("Ingrese la Marca del Producto."); ?>',
		Desc28: '<?php echo lang("El Campo del Costo Bruto no puede estar vacío."); ?>',
		Desc29: '<?php echo lang("El Campo del Margen no puede estar vacío."); ?>',
		Desc30: '<?php echo lang("El Campo del Precio Neto no puede estar vacío."); ?>',
		Desc31: '<?php echo lang("El Campo del Costo Neto no puede estar vacío."); ?>',
		Desc32: '<?php echo lang("El Campo del Precio Bruto no puede estar vacío."); ?>',
		Desc33: '<?php echo lang("Seleccione un Impuestos."); ?>',
		Desc34: '<?php echo lang("El Mínimo No Puede Ser Mayor al Maximo."); ?>',
		Desc35: '<?php echo lang("¿Desea Eliminar Este Serial?"); ?>',
		Desc36: '<?php echo lang("Abrir Comprometido"); ?>',
		Cargando: '<?php echo lang("Cargando"); ?>',
		Num001: {
			title: '<?php echo lang("Precio Invalido"); ?>',
			desc: '<?php echo lang("No está permitido guardar el precio por debajo del costo unitario"); ?>',
		}
	};
	window.addEventListener('beforeprint', () => {
		myChart.resize(600, 600);
	});
	window.addEventListener('afterprint', () => {
		myChart.resize();
	});
</script>