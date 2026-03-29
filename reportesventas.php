<?php
$sql = "SELECT a.* ,b.Descripcion as ModuloName , b.Link as Archivo FROM PosUpOpciones a   
    inner join PosUpModulo b on a.IdModulo=b.IdModulo
    where a.IdModulo='" . $_SESSION["ModuloActual"] . "' and a.Link='" . $_SESSION['opcion'] . "'  limit 1";
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
}
echo $header;

$IdCompanySelect = "";
$query = "SELECT '" . $_SESSION["IdCompanyGrp"] . "' as ID, ' [" . lang('Todas') . "]' as Empresa  union  SELECT Id as ID, comercio as Empresa FROM PosUpCompany where Id in ( " . $__SESSIONPOST["IdCompanyGrp"] . ")  order by Empresa ";
if ($result = mysqli_query($conn, $query)) {
	while ($row = mysqli_fetch_assoc($result)) {
		$IdCompanySelect .= "<option value='" . trim($row['ID']) . "' " . ($row['ID'] == $_SESSION['CompanyActual'] ? 'selected' : '') . ">" . $row['Empresa'] . "</option>";
	}
	mysqli_free_result($result);
}
$OperacionCC = "";
$query = "SELECT Idtipotx,Titulo FROM PosUpTx WHERE Caja = 1 and Idtipotx in (select Idtipotx from PosUpTxC WHERE IdCompany =" . $_SESSION["CompanyActual"] . " group by Idtipotx) order by Titulo asc";
if ($result = mysqli_query($conn, $query)) {
	while ($row = mysqli_fetch_assoc($result)) {
		$OperacionCC .= "<option value='" . $row['Idtipotx'] . "' >" . $row["Titulo"] . "</option>";
	}
	mysqli_free_result($result);
}
$ModalZona2C2 = "";
if ($_SESSION['sucursal'] == '0') {

	$queryUB = "SELECT IdUbi,Nombre FROM PosUpUbicacion WHERE IdCompany=" . $_SESSION["CompanyActual"] . "";
	if ($resultUB = mysqli_query($conn, $queryUB)) {
		while ($rowUB = mysqli_fetch_assoc($resultUB)) {
			$ModalZona2C2 .= "<option value='" . $rowUB['IdUbi'] . "'>" . $rowUB["Nombre"] . "</option>";
		}
		mysqli_free_result($resultUB);
	}
}
$vendedores = "";

$queryE = " select a.Login,a.Nombre as Vendedor
	from PosUpUsers a 
	where a.IdCompany=" . $_SESSION["CompanyActual"] . " 
	AND a.esvendedor = 1
	";
if ($resultE = mysqli_query($conn, $queryE)) {
	while ($rowE = mysqli_fetch_assoc($resultE)) {
		$vendedores .= "<option value='" . $rowE['Login'] . "'>" . $rowE['Vendedor'] . "</option>";
	}
	mysqli_free_result($resulteE);
}
?>
<style>
	.modal {
		overflow-y: auto;
	}
</style>
<span id="product-enter" class='d-none'></span>
<div class="container" id='option' style='padding-bottom:78px;'>
	<div class="row">
		<?php
		if ($_GET && isset($_GET["g"]) &&  $_GET['g'] == 1) {
		?>
			<div class="card border-light mb-2 col-md-4  ">
				<div class="card-body">
					<h2><img src="/img/informez.png"></h2>
					<h4><?php echo lang('Transacciones de Ventas de Productos'); ?> <button type="button" id="button019" onclick="venta(19)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
				</div>
			</div>
			<?php
		}
		if ($_SESSION['CIdPlan'] == '0000000015') { // multicanal

			if ($_SESSION["userperfil"] == 2070 && $_SESSION['CompanyActual'] !== "1168") {
			?>
				<div class="card border-light mb-2 col-md-4">
					<div class="card-body">
						<h2><img src="/img/documentosemitidos.png"> </h2>
						<h4><?php echo lang('Listado de Cuentas por Cobrar'); ?></h4>

						<button class="btn btn-outline-primary p-1 m-1" data-bs-toggle="modal" data-bs-target="#filtroListadoCuentasCobrar">
							<i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?>
						</button>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4 " style="display: none;">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Listado de Cuentas por Cobrar'); ?> <button type="button" id="button015" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4  ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Listado de Cuentas por Cobrar a Clientes'); ?> <button type="button" id="button014" onclick="venta(14)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
			<?php
			} else if ($_SESSION["userperfil"] == 2100) {
			?>
				<div class="card border-light mb-2 col-md-4  ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Transacciones de Ventas'); ?> <button type="button" id="button001" onclick="venta(1)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4  " style="display: none;">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Cierre de Caja'); ?> <button type="button" id="button002" onclick="venta(2)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4  ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Listado de Cuentas por Cobrar'); ?> <button type="button" id="button015" onclick="venta(15)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
			<?php
			} else if ($_SESSION["userperfil"] <= 2000 or $_SESSION["userperfil"] == 2056 || $_SESSION["userperfil"] == "2054" || $_SESSION["userperfil"] == "2053" or ($_SESSION["userperfil"] == 2700) or ($_SESSION["userperfil"] == 2710) or ($_SESSION["userperfil"] == 2060) or ($_SESSION["userperfil"] == 2050)) {
			?>
				<div class="card border-light mb-2 col-md-4  ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Listado de Comisiones por Cobro'); ?> <button type="button" id="button020" onclick="venta(20)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4  ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Listado de Cobranza'); ?> <button type="button" id="button022" onclick="venta(22)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4  ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Listado de Comisiones por Ventas'); ?> <button type="button" id="button021" onclick="venta(21)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4  ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Resumen Diario de transacciones de  Boletas - Facturas'); ?> <button type="button" id="button018" onclick="venta(18)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4  ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Transacciones de Ventas'); ?> <button type="button" id="button001" onclick="venta(1)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4  " style="display:none;">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Cierre de Caja (Sistema Anterior)'); ?> <button type="button" id="button004" onclick="venta(4)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<?php
				if ($_SESSION['IdPais'] == 'CL') {
				?>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Resumen de Facturación Electrónica'); ?> <button type="button" id="button013" onclick="venta(13)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				}
				?>

				<!-- <div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Libro de Ventas'); ?> <button type="button" id="button011" onclick="venta(11)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div> -->
				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Libro de Ventas (Impresora Fiscal)'); ?> <button type="button" id="button024" onclick="venta(24)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Libro de Ventas (Forma Libre)'); ?> <button type="button" id="button025" onclick="venta(25)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4 " style="display: none;">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Cierre de Caja'); ?> <button type="button" id="button002" onclick="venta(2)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4 " style="display: none;">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Cierre de Ventas Diario'); ?> <button type="button" id="button005" onclick="venta(5)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4  ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Listado de Cuentas por Cobrar'); ?> <button type="button" id="button015" onclick="venta(15)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4  ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Análisis de Vencimiento'); ?> <button type="button" id="button016" onclick="venta(16)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4  ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Listado de Cuentas por Cobrar a Clientes'); ?> <button type="button" id="button014" onclick="venta(14)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4  ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Transacciones de Ventas por Clientes'); ?> <button type="button" id="button017" onclick="venta(17)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4  ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Ventas por Producto y Servicio'); ?> <button type="button" id="button023" onclick="venta(23)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4  ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Resumen y Detalle de Caja'); ?> <button type="button" id="button027" onclick="venta(27)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div style='display:none' class="col-xs-6">
					<div class="card">
						<div style='visibility:hidden' class="card-header bg-light bg-inverse">
							<h4>Transacciones Procesadas</h4>
							<ul class="card-actions">
								<li>
									<button style='display:none' class="fa fa-search" data-toggle="modal" id="button006" onclick="venta(6)" type="button"></button>
								</li>
							</ul>
						</div>
						<div class="card-block">
							<p></strong></p>
							<p></p>
							<p></p>
							<p></p>
							<p></p>
						</div>
					</div>
				</div>
				<div style='display:none' class="col-xs-6">
					<div class="card">
						<div class="card-header bg-light bg-inverse">
							<h4>Relacion de Ventas de Crédito</h4>
							<ul class="card-actions">
								<li>
									<button style='display:none' class="fa fa-search" data-toggle="modal" id="button008" onclick="venta(8)" type="button"></button>
								</li>
							</ul>
						</div>
						<div class="card-block">
							<p></strong></p>
							<p></p>
							<p></p>
							<p></p>
							<p></p>
						</div>
					</div>
				</div>
				<div style='display:none' class="col-xs-6">
					<div class="card">
						<div class="card-header bg-light bg-inverse">
							<h4>Transacciones de Ventas por Ubicacion</h4>
							<ul class="card-actions">
								<li>
									<button style='display:none' class="fa fa-search" data-toggle="modal" id="button009" onclick="venta(9)" type="button"></button>
								</li>
							</ul>
						</div>
						<div class="card-block">
							<p></strong></p>
							<p></p>
							<p></p>
							<p></p>
							<p></p>
						</div>
					</div>
				</div>
				<div style='display:none' class="col-xs-6">
					<div class="card">
						<div class="card-header bg-light bg-inverse">
							<h4>Relacion de Ventas</h4>
							<ul class="card-actions">
								<li>
									<button style='display:none' class="fa fa-search" data-toggle="modal" id="button007" onclick="venta(7)" type="button"></button>
								</li>
							</ul>
						</div>
						<div class="card-block">
							<p></strong></p>
							<p></p>
							<p></p>
							<p></p>
							<p></p>
						</div>
					</div>
				</div>
			<?php
			} else if ($_SESSION["userperfil"] == 2055) {
			?>
				<div class="card border-light mb-2 col-md-4  ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Listado de Comisiones por Cobro'); ?> <button type="button" id="button020" onclick="venta(20)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4  ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Listado de Cobranza'); ?> <button type="button" id="button022" onclick="venta(22)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4  ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Listado de Comisiones por Ventas'); ?> <button type="button" id="button021" onclick="venta(21)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4  ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Resumen Diario de transacciones de  Boletas - Facturas'); ?> <button type="button" id="button018" onclick="venta(18)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4  " style="display:none;">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Cierre de Caja (Sistema Anterior)'); ?> <button type="button" id="button004" onclick="venta(4)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<?php
				if ($_SESSION['IdPais'] == 'CL') {
				?>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Resumen de Facturación Electrónica'); ?> <button type="button" id="button013" onclick="venta(13)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				}
				?>
				<!-- <div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Libro de Ventas'); ?> <button type="button" id="button011" onclick="venta(11)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div> -->
				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Libro de Ventas (Impresora Fiscal)'); ?> <button type="button" id="button024" onclick="venta(24)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Libro de Ventas (Forma Libre)'); ?> <button type="button" id="button025" onclick="venta(25)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4 " style="display: none;">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Cierre de Caja'); ?> <button type="button" id="button002" onclick="venta(2)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4 " style="display: none;">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Cierre de Ventas Diario'); ?> <button type="button" id="button005" onclick="venta(5)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4  ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Listado de Cuentas por Cobrar'); ?> <button type="button" id="button015" onclick="venta(15)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4  ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Análisis de Vencimiento'); ?> <button type="button" id="button016" onclick="venta(16)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4  ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Listado de Cuentas por Cobrar a Clientes'); ?> <button type="button" id="button014" onclick="venta(14)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4  ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Transacciones de Ventas por Clientes'); ?> <button type="button" id="button017" onclick="venta(17)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4  ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Ventas por Producto y Servicio'); ?> <button type="button" id="button023" onclick="venta(23)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
			<?php
			}
			if ($_SESSION['CompanyActual'] === "157") {
			?>

				<div class="card border-light mb-2 col-md-4  ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Reporte A'); ?> <button type="button" id="button026" onclick="venta(26)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
			<?
			}
			?>
		<?php
		} else if ($_SESSION['CIdPlan'] == '0000000017') { // multicanal
		?>
			<div class="row">
				<?php
				if ($_SESSION["userperfil"] == 2070) {
				?>
					<div class="card border-light mb-2 col-md-4  " style="display: none;">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Cierre de Caja'); ?> <button type="button" id="button002" onclick="venta(2)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				} else if ($_SESSION["userperfil"] == 2100) {
				?>
					<div class="card border-light mb-2 col-md-4  " style="display: none;">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Cierre de Caja'); ?> <button type="button" id="button002" onclick="venta(2)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<?php
				} else if ($_SESSION["userperfil"] <= 2000 or $_SESSION["userperfil"] == 2056 || $_SESSION["userperfil"] == "2054" || $_SESSION["userperfil"] == "2053" or ($_SESSION["userperfil"] == 2700) or ($_SESSION["userperfil"] == 2710)   or ($_SESSION["userperfil"] == 2060) or ($_SESSION["userperfil"] == 2050)) {
					if ($_GET['g'] == 1) {
					?>
						<div class="card border-light mb-2 col-md-4  ">
							<div class="card-body">
								<h2><img src="/img/informez.png"></h2>
								<h4><?php echo lang('Transacciones de Ventas de Productos'); ?> <button type="button" id="button019" onclick="venta(19)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
							</div>
						</div>
					<?php
					}
					if ($_SESSION['IdPais'] == 'CL') {
					?>
						<div class="card border-light mb-2 col-md-4 ">
							<div class="card-body">
								<h2><img src="/img/informez.png"></h2>
								<h4><?php echo lang('Resumen de Facturación Electrónica'); ?> <button type="button" id="button013" onclick="venta(13)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
							</div>
						</div>
					<?php
					}
					?>

					<!-- <div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Libro de Ventas'); ?> <button type="button" id="button011" onclick="venta(11)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div> -->
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Libro de Ventas (Impresora Fiscal)'); ?> <button type="button" id="button024" onclick="venta(24)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Libro de Ventas (Forma Libre)'); ?> <button type="button" id="button025" onclick="venta(25)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 " style="display: none;">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Cierre de Caja'); ?> <button type="button" id="button002" onclick="venta(2)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Ventas por Producto y Servicio'); ?> <button type="button" id="button023" onclick="venta(23)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				} else if ($_SESSION["userperfil"] == 2055) {
				?>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Listado de Comisiones por Cobro'); ?> <button type="button" id="button020" onclick="venta(20)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Listado de Cobranza'); ?> <button type="button" id="button022" onclick="venta(22)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Listado de Comisiones por Ventas'); ?> <button type="button" id="button021" onclick="venta(21)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Resumen Diario de transacciones de  Boletas - Facturas'); ?> <button type="button" id="button018" onclick="venta(18)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  " style="display:none;">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Cierre de Caja (Sistema Anterior)'); ?> <button type="button" id="button004" onclick="venta(4)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<?php
					if ($_SESSION['IdPais'] == 'CL') {
					?>
						<div class="card border-light mb-2 col-md-4 ">
							<div class="card-body">
								<h2><img src="/img/informez.png"></h2>
								<h4><?php echo lang('Resumen de Facturación Electrónica'); ?> <button type="button" id="button013" onclick="venta(13)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
							</div>
						</div>
					<?php
					}
					?>

					<!-- <div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Libro de Ventas'); ?> <button type="button" id="button011" onclick="venta(11)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div> -->
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Libro de Ventas (Impresora Fiscal)'); ?> <button type="button" id="button024" onclick="venta(24)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Libro de Ventas (Forma Libre)'); ?> <button type="button" id="button025" onclick="venta(25)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 " style="display: none;">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Cierre de Caja'); ?> <button type="button" id="button002" onclick="venta(2)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 " style="display: none;">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Cierre de Ventas Diario'); ?> <button type="button" id="button005" onclick="venta(5)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Listado de Cuentas por Cobrar'); ?> <button type="button" id="button015" onclick="venta(15)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Análisis de Vencimiento'); ?> <button type="button" id="button016" onclick="venta(16)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Listado de Cuentas por Cobrar a Clientes'); ?> <button type="button" id="button014" onclick="venta(14)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Transacciones de Ventas por Clientes'); ?> <button type="button" id="button017" onclick="venta(17)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Ventas por Producto y Servicio'); ?> <button type="button" id="button023" onclick="venta(23)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				}

				if ($_SESSION['CompanyActual'] === "157") {
				?>

					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Reporte A'); ?> <button type="button" id="button026" onclick="venta(26)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?
				}
				?>
			</div>
		<?php
		} else  if ($_SESSION['CIdPlan'] == '0000000018') { // multicanal
		?>
			<div class="row">
				<?php
				if ($_SESSION["userperfil"] == 2070 && $_SESSION['CompanyActual'] !== "1168") {
				?>
					<div class="card border-light mb-2 col-md-4  " style="display: none;">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Cierre de Caja'); ?> <button type="button" id="button002" onclick="venta(2)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Listado de Cuentas por Cobrar'); ?> <button type="button" id="button015" onclick="venta(15)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Listado de Cuentas por Cobrar a Clientes'); ?> <button type="button" id="button014" onclick="venta(14)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				} else if ($_SESSION["userperfil"] == 2100) {
				?>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Transacciones de Ventas'); ?> <button type="button" id="button001" onclick="venta(1)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  " style="display: none;">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Cierre de Caja'); ?> <button type="button" id="button002" onclick="venta(2)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Listado de Cuentas por Cobrar'); ?> <button type="button" id="button015" onclick="venta(15)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				} else if ($_SESSION["userperfil"] <= 2000 or $_SESSION["userperfil"] == 2056 || $_SESSION["userperfil"] == "2054" || $_SESSION["userperfil"] == "2053" or ($_SESSION["userperfil"] == 2700) or ($_SESSION["userperfil"] == 2710) or ($_SESSION["userperfil"] == 2060)  or ($_SESSION["userperfil"] == 2050)) {
				?>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Resumen Diario de transacciones de  Boletas - Facturas'); ?> <button type="button" id="button018" onclick="venta(18)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Transacciones de Ventas'); ?> <button type="button" id="button001" onclick="venta(1)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  " style="display:none;">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Cierre de Caja (Sistema Anterior)'); ?> <button type="button" id="button004" onclick="venta(4)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<?php
					if ($_SESSION['IdPais'] == 'CL') {
					?>
						<div class="card border-light mb-2 col-md-4 ">
							<div class="card-body">
								<h2><img src="/img/informez.png"></h2>
								<h4><?php echo lang('Resumen de Facturación Electrónica'); ?> <button type="button" id="button013" onclick="venta(13)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
							</div>
						</div>
					<?php
					}
					?>

					<!-- <div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Libro de Ventas'); ?> <button type="button" id="button011" onclick="venta(11)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div> -->
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Libro de Ventas (Impresora Fiscal)'); ?> <button type="button" id="button024" onclick="venta(24)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Libro de Ventas (Forma Libre)'); ?> <button type="button" id="button025" onclick="venta(25)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 " style="display: none;">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Cierre de Caja'); ?> <button type="button" id="button002" onclick="venta(2)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 " style="display: none;">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Cierre de Ventas Diario'); ?> <button type="button" id="button005" onclick="venta(5)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Listado de Cuentas por Cobrar'); ?> <button type="button" id="button015" onclick="venta(15)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Análisis de Vencimiento'); ?> <button type="button" id="button016" onclick="venta(16)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Listado de Cuentas por Cobrar a Clientes'); ?> <button type="button" id="button014" onclick="venta(14)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Transacciones de Ventas por Clientes'); ?> <button type="button" id="button017" onclick="venta(17)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Ventas por Producto y Servicio'); ?> <button type="button" id="button023" onclick="venta(23)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div style='display:none' class="col-xs-6">
						<div class="card">
							<div style='visibility:hidden' class="card-header bg-light bg-inverse">
								<h4>Transacciones Procesadas</h4>
								<ul class="card-actions">
									<li>
										<button style='display:none' class="fa fa-search" data-toggle="modal" id="button006" onclick="venta(6)" type="button"></button>
									</li>
								</ul>
							</div>
							<div class="card-block">
								<p></strong></p>
								<p></p>
								<p></p>
								<p></p>
								<p></p>
							</div>
						</div>
					</div>
					<div style='display:none' class="col-xs-6">
						<div class="card">
							<div class="card-header bg-light bg-inverse">
								<h4>Relacion de Ventas de Crédito</h4>
								<ul class="card-actions">
									<li>
										<button style='display:none' class="fa fa-search" data-toggle="modal" id="button008" onclick="venta(8)" type="button"></button>
									</li>
								</ul>
							</div>
							<div class="card-block">
								<p></strong></p>
								<p></p>
								<p></p>
								<p></p>
								<p></p>
							</div>
						</div>
					</div>
					<div style='display:none' class="col-xs-6">
						<div class="card">
							<div class="card-header bg-light bg-inverse">
								<h4>Transacciones de Ventas por Ubicacion</h4>
								<ul class="card-actions">
									<li>
										<button style='display:none' class="fa fa-search" data-toggle="modal" id="button009" onclick="venta(9)" type="button"></button>
									</li>
								</ul>
							</div>
							<div class="card-block">
								<p></strong></p>
								<p></p>
								<p></p>
								<p></p>
								<p></p>
							</div>
						</div>
					</div>
					<div style='display:none' class="col-xs-6">
						<div class="card">
							<div class="card-header bg-light bg-inverse">
								<h4>Relacion de Ventas</h4>
								<ul class="card-actions">
									<li>
										<button style='display:none' class="fa fa-search" data-toggle="modal" id="button007" onclick="venta(7)" type="button"></button>
									</li>
								</ul>
							</div>
							<div class="card-block">
								<p></strong></p>
								<p></p>
								<p></p>
								<p></p>
								<p></p>
							</div>
						</div>
					</div>
				<?php

				} else if ($_SESSION["userperfil"] == 2055) {
				?>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Listado de Comisiones por Cobro'); ?> <button type="button" id="button020" onclick="venta(20)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Listado de Cobranza'); ?> <button type="button" id="button022" onclick="venta(22)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Listado de Comisiones por Ventas'); ?> <button type="button" id="button021" onclick="venta(21)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Resumen Diario de transacciones de  Boletas - Facturas'); ?> <button type="button" id="button018" onclick="venta(18)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  " style="display:none;">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Cierre de Caja (Sistema Anterior)'); ?> <button type="button" id="button004" onclick="venta(4)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<?php
					if ($_SESSION['IdPais'] == 'CL') {
					?>
						<div class="card border-light mb-2 col-md-4 ">
							<div class="card-body">
								<h2><img src="/img/informez.png"></h2>
								<h4><?php echo lang('Resumen de Facturación Electrónica'); ?> <button type="button" id="button013" onclick="venta(13)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
							</div>
						</div>
					<?php
					}
					?>

					<!-- <div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Libro de Ventas'); ?> <button type="button" id="button011" onclick="venta(11)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div> -->
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Libro de Ventas (Impresora Fiscal)'); ?> <button type="button" id="button024" onclick="venta(24)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Libro de Ventas (Forma Libre)'); ?> <button type="button" id="button025" onclick="venta(25)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 " style="display: none;">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Cierre de Caja'); ?> <button type="button" id="button002" onclick="venta(2)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 " style="display: none;">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Cierre de Ventas Diario'); ?> <button type="button" id="button005" onclick="venta(5)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Listado de Cuentas por Cobrar'); ?> <button type="button" id="button015" onclick="venta(15)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Análisis de Vencimiento'); ?> <button type="button" id="button016" onclick="venta(16)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Listado de Cuentas por Cobrar a Clientes'); ?> <button type="button" id="button014" onclick="venta(14)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Transacciones de Ventas por Clientes'); ?> <button type="button" id="button017" onclick="venta(17)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Ventas por Producto y Servicio'); ?> <button type="button" id="button023" onclick="venta(23)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				}

				if ($_SESSION['CompanyActual'] === "157") {
				?>

					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Reporte A'); ?> <button type="button" id="button026" onclick="venta(26)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?
				}
				?>
			</div>
		<?php
		} else { // multicanal
		?>
			<div class="row">
				<?php
				if ($_SESSION["userperfil"] == 2070 && $_SESSION['CompanyActual'] !== "1168") {
				?>
					<div class="card border-light mb-2 col-md-4  " style="display: none;">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Cierre de Caja'); ?> <button type="button" id="button002" onclick="venta(2)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Listado de Cuentas por Cobrar'); ?> <button type="button" id="button015" onclick="venta(15)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Listado de Cuentas por Cobrar a Clientes'); ?> <button type="button" id="button014" onclick="venta(14)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				} else if ($_SESSION["userperfil"] == 2100) {
				?>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Transacciones de Ventas'); ?> <button type="button" id="button001" onclick="venta(1)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  " style="display: none;">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Cierre de Caja'); ?> <button type="button" id="button002" onclick="venta(2)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Listado de Cuentas por Cobrar'); ?> <button type="button" id="button015" onclick="venta(15)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				} else if ($_SESSION["userperfil"] <= 2000 or $_SESSION["userperfil"] == 2056 || $_SESSION["userperfil"] == "2054" || $_SESSION["userperfil"] == "2053" or ($_SESSION["userperfil"] == 2700) or ($_SESSION["userperfil"] == 2710) or ($_SESSION["userperfil"] == 2060) or ($_SESSION["userperfil"] == 2050)) {
				?>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Listado de Comisiones por Cobro'); ?> <button type="button" id="button020" onclick="venta(20)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Listado de Cobranza'); ?> <button type="button" id="button022" onclick="venta(22)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Listado de Comisiones por Ventas'); ?> <button type="button" id="button021" onclick="venta(21)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Resumen Diario de transacciones de  Boletas - Facturas'); ?> <button type="button" id="button018" onclick="venta(18)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Transacciones de Ventas'); ?> <button type="button" id="button001" onclick="venta(1)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  " style="display:none;">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Cierre de Caja (Sistema Anterior)'); ?> <button type="button" id="button004" onclick="venta(4)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<?php
					if ($_SESSION['IdPais'] == 'CL') {
					?>
						<div class="card border-light mb-2 col-md-4 ">
							<div class="card-body">
								<h2><img src="/img/informez.png"></h2>
								<h4><?php echo lang('Resumen de Facturación Electrónica'); ?> <button type="button" id="button013" onclick="venta(13)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
							</div>
						</div>
					<?php
					}
					?>

					<!-- <div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Libro de Ventas'); ?> <button type="button" id="button011" onclick="venta(11)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div> -->
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Libro de Ventas (Impresora Fiscal)'); ?> <button type="button" id="button024" onclick="venta(24)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Libro de Ventas (Forma Libre)'); ?> <button type="button" id="button025" onclick="venta(25)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 " style="display: none;">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Cierre de Caja'); ?> <button type="button" id="button002" onclick="venta(2)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 " style="display: none;">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Cierre de Ventas Diario'); ?> <button type="button" id="button005" onclick="venta(5)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Listado de Cuentas por Cobrar'); ?> <button type="button" id="button015" onclick="venta(15)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Análisis de Vencimiento'); ?> <button type="button" id="button016" onclick="venta(16)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Listado de Cuentas por Cobrar a Clientes'); ?> <button type="button" id="button014" onclick="venta(14)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Transacciones de Ventas por Clientes'); ?> <button type="button" id="button017" onclick="venta(17)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Ventas por Producto y Servicio'); ?> <button type="button" id="button023" onclick="venta(23)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div style='display:none' class="col-xs-6">
						<div class="card">
							<div style='visibility:hidden' class="card-header bg-light bg-inverse">
								<h4>Transacciones Procesadas</h4>
								<ul class="card-actions">
									<li>
										<button style='display:none' class="fa fa-search" data-toggle="modal" id="button006" onclick="venta(6)" type="button"></button>
									</li>
								</ul>
							</div>
							<div class="card-block">
								<p></strong></p>
								<p></p>
								<p></p>
								<p></p>
								<p></p>
							</div>
						</div>
					</div>
					<div style='display:none' class="col-xs-6">
						<div class="card">
							<div class="card-header bg-light bg-inverse">
								<h4>Relacion de Ventas de Crédito</h4>
								<ul class="card-actions">
									<li>
										<button style='display:none' class="fa fa-search" data-toggle="modal" id="button008" onclick="venta(8)" type="button"></button>
									</li>
								</ul>
							</div>
							<div class="card-block">
								<p></strong></p>
								<p></p>
								<p></p>
								<p></p>
								<p></p>
							</div>
						</div>
					</div>
					<div style='display:none' class="col-xs-6">
						<div class="card">
							<div class="card-header bg-light bg-inverse">
								<h4>Transacciones de Ventas por Ubicacion</h4>
								<ul class="card-actions">
									<li>
										<button style='display:none' class="fa fa-search" data-toggle="modal" id="button009" onclick="venta(9)" type="button"></button>
									</li>
								</ul>
							</div>
							<div class="card-block">
								<p></strong></p>
								<p></p>
								<p></p>
								<p></p>
								<p></p>
							</div>
						</div>
					</div>
					<div style='display:none' class="col-xs-6">
						<div class="card">
							<div class="card-header bg-light bg-inverse">
								<h4>Relacion de Ventas</h4>
								<ul class="card-actions">
									<li>
										<button style='display:none' class="fa fa-search" data-toggle="modal" id="button007" onclick="venta(7)" type="button"></button>
									</li>
								</ul>
							</div>
							<div class="card-block">
								<p></strong></p>
								<p></p>
								<p></p>
								<p></p>
								<p></p>
							</div>
						</div>
					</div>
				<?php
				} else if ($_SESSION["userperfil"] == 2055) {
				?>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Listado de Comisiones por Cobro'); ?> <button type="button" id="button020" onclick="venta(20)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Listado de Cobranza'); ?> <button type="button" id="button022" onclick="venta(22)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Listado de Comisiones por Ventas'); ?> <button type="button" id="button021" onclick="venta(21)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Resumen Diario de transacciones de  Boletas - Facturas'); ?> <button type="button" id="button018" onclick="venta(18)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  " style="display:none;">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Cierre de Caja (Sistema Anterior)'); ?> <button type="button" id="button004" onclick="venta(4)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<?php
					if ($_SESSION['IdPais'] == 'CL') {
					?>
						<div class="card border-light mb-2 col-md-4 ">
							<div class="card-body">
								<h2><img src="/img/informez.png"></h2>
								<h4><?php echo lang('Resumen de Facturación Electrónica'); ?> <button type="button" id="button013" onclick="venta(13)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
							</div>
						</div>
					<?php
					}
					?>

					<!-- <div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></h2>
						<h4><?php echo lang('Libro de Ventas'); ?> <button type="button" id="button011" onclick="venta(11)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div> -->
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Libro de Ventas (Impresora Fiscal)'); ?> <button type="button" id="button024" onclick="venta(24)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Libro de Ventas (Forma Libre)'); ?> <button type="button" id="button025" onclick="venta(25)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 " style="display: none;">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Cierre de Caja'); ?> <button type="button" id="button002" onclick="venta(2)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 " style="display: none;">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Cierre de Ventas Diario'); ?> <button type="button" id="button005" onclick="venta(5)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Listado de Cuentas por Cobrar'); ?> <button type="button" id="button015" onclick="venta(15)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Análisis de Vencimiento'); ?> <button type="button" id="button016" onclick="venta(16)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Listado de Cuentas por Cobrar a Clientes'); ?> <button type="button" id="button014" onclick="venta(14)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Transacciones de Ventas por Clientes'); ?> <button type="button" id="button017" onclick="venta(17)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Ventas por Producto y Servicio'); ?> <button type="button" id="button023" onclick="venta(23)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				}
				if ($_SESSION['CompanyActual'] === "157") {
				?>

					<div class="card border-light mb-2 col-md-4  ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></h2>
							<h4><?php echo lang('Reporte A'); ?> <button type="button" id="button026" onclick="venta(26)" class="btn btn-outline-primary m-1 p-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?
				}
				?>
			</div>
		<?php
		}
		?>
	</div>
</div>
<div class="modal fade" id="filtroListadoCuentasCobrar" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="filtroModalLabel">Parámetros del Reporte</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
			</div>
			<div class="modal-body">
				<input type="hidden" name="CompanyActual" value="<?php echo $_POST['Company']; ?>" />
				<input type="hidden" name="IdCompanyGrp" value="<?php echo $_POST['IdCompanyGrp']; ?>" />
				<input type="hidden" name="CIdPlan" value="<?php echo $_POST['CIdPlan']; ?>" />
				<input type="hidden" name="sucursalm" value="<?php echo $_POST['sucursal']; ?>" />
				<span style="display:none" id="devueltachavalesSEasd"></span>
				<span style="display:none" id="CodigoDesaSasdaE"></span>
				<span style="display:none" id="CodigoHasaasdasSE"></span>
				<span style="display:none" id="BenefeasdSE"></span>
				<span style="display:none" id="asdss"></span>
				<input type="hidden" class="form-control filt" id="companyUser" name="companyUser" value="<?php echo $_POST["Company"]; ?>" />
				<input class="form-control filt" type="hidden" id="Tittle" name="Tittle" value="Listado de Comisiones por Cobro" />

				<div class="mb-2 <?php echo $notemp; ?>">
					<label for="IdCompanySelect" class="form-label">Usuario:</label>
					<select class="form-control <?php echo $notemprise; ?>" id="IdCompanySelect" name="IdCompanySelect" style="width:100%;" onchange='selectidcomp(document.getElementById("IdCompanySelect").value); changeinput("0","","","","","ubic"); changeinput("0","","","","","","vendedores");'>
						<?php
						echo $IdCompanySelect;
						?>
					</select>
				</div>
				<div class="mb-2">
					<label for="desde" class="form-label">Desde:</label>
					<input type="datetime-local" id="fech2" class="form-control">
				</div>
				<div class="mb-2">
					<label for="hasta" class="form-label">Hasta:</label>
					<input type="datetime-local" id="fech3" class="form-control">
				</div>

				<div class="mb-2">
					<label for="ModalTipo22" class="form-label">Operación:</label>
					<select class="form-control" id="ModalTipo22" name="ModalTipo22[]" style="width:100%;" multiple>
						<?php
						echo $OperacionCC;
						?>
					</select>
				</div>

				<div class="mb-2  <?php echo $notfil; ?> nfilt" <?php echo ($_POST['sucursal'] <> "0" ? 'display:none;' : ''); ?>>
					<label for="ubic" class="form-label">Ubicaciones:</label>
					<select class="form-control" id="ubic" name="ubic[]" style="width:100%;" multiple>
						<?php
						echo $ModalZona2C2;
						?>
					</select>
				</div>

				<div class="mb-2  <?php echo $notfil; ?> nfilt">
					<label for="vendedores" class="form-label">Vendedores:</label>
					<select class="form-control" id="vendedores" name="vendedores[]" style="width:100%;" multiple>
						<?php
						echo $vendedores;
						?>
					</select>
				</div> <?php if ($_POST["userperfil"] <= 2000 or $_SESSION["userperfil"] == "2055"  or $_POST["userperfil"] == 2700 or $_POST["userperfil"] == 2710) { ?>
					<div class="text-right">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" id="dpag" name="dpag">
							<label class="form-check-label" for="dpag">
								<?php echo lang('Desglosar Pagos'); ?>
							</label>
						</div>
					</div>
				<?php } ?>
				<div class="text-right">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" id="cms" name="cms" checked>
						<label class="form-check-label" for="cms">
							<?php echo lang('Mostrar Comisión'); ?>
						</label>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" onclick="ListadoCuentasCobrar()" class="btn btn-outline-primary p-1 m-1">
					<i class="fa fa-arrow-right"> </i> <?php echo lang('Generar Reporte'); ?>
				</button>
			</div>
		</div>
	</div>
</div>
<div class="modal" id="apps-modalz" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-fullscreen-lg-down">
		<div class="modal-content ">
			<div class="modal-content" style='height:auto !important;'>
				<span id="prueba1">
				</span>
			</div>
		</div>
	</div>
</div>
<div class="modal" id="apps-modalz2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-fullscreen-sm-down">
		<div class="modal-content">
			<div class="modal-header">

				<button data-bs-dismiss="modal" class="btn-close" type="button"></button>
			</div>
			<div class="modal-body">
				<div class="row input-group">
					<div class="col-12 ">
						<div class="input-group col-md-4">
							<span class="input-group-text "><span class="fa fa-search"></span>&nbsp;<?php echo lang('Buscar'); ?>:</span>
							<input class="form-control" type="search" id="search-prod" name="search-prod" onkeyup="Pagineo(1);" />
						</div>
					</div>
				</div>
				<span id="resultadobusca">
					<spam style="visibility:hidden" id="PagAct">1</spam>
					<span style="visibility:hidden" id="Rpa">1</span>
					<input style="visibility:hidden" type="text" name="Limit" id="Limit" value="10">
				</span>
				<input style="visibility:hidden" type="text" name="Organizador" id="Organizador">
			</div>
		</div>
	</div>
</div>
<div class="modal" id="apps-modal2y2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-fullscreen-sm-down">
		<div class="modal-content">
			<div class="modal-header">
				<div class="card-actions">
					<div class='float-end'>
						<button data-bs-dismiss="modal" class='btn btn-outlaine-secondary' type="button"><span class="fa fa-close"></span></button>
					</div>
				</div>
			</div>
			<div class="modal-body">
				<div class="row input-group">
					<div class="col-12 ">
						<div class="input-group col-md-4">
							<span class="input-group-text "><span class="fa fa-search"></span>&nbsp;<?php echo lang('Buscar'); ?>:</span>
							<input class="form-control" type="search" id="search-prodCCD" name="search-prodCCD" onkeyup="PagineoCCD(1);" />
						</div>
					</div>
				</div>
				<span id="resultadobuscaCCD">
					<spam style="visibility:hidden" id="PagActCCD">1</spam>
					<span style="visibility:hidden" id="RpaCCD">1</span>
					<input style="visibility:hidden" type="text" name="LimitCCD" id="LimitCCD" value="10">
				</span>
				<input style="visibility:hidden" type="text" name="OrganizadorCCD" id="OrganizadorCCD">
			</div>
		</div>
	</div>
</div>
<div class="modal" id="apps-modal4y2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-fullscreen-sm-down">
		<div class="modal-content">
			<div class="modal-header">
				<h4 id="appsmodal4y2name"><?php echo lang("Tabla"); ?></h4>
				<div class="card-actions">
					<div class='float-end'>
						<button onclick='closemodal("apps-modal4y2"); $("#apps-modalz").modal("show");' class='btn btn-outline-secondary' type="button"><span class="fa fa-close"></span></button>
					</div>
				</div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="table-responsive" id="CierredecajaTablaRep">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal" id="apps-modal5y2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-fullscreen-sm-down">
		<div class="modal-content">
			<div class="modal-header">

				<button data-bs-dismiss="modal" class="btn-close" type="button"></button>
			</div>
			<div class="modal-body">
				<div class="row input-group">
					<div class="col-12 ">
						<div class="input-group col-md-4">
							<span class="input-group-text "><span class="fa fa-search"></span>&nbsp;<?php echo lang('Buscar'); ?>:</span>
							<input class="form-control" type="search" id="search-prodCCD2" name="search-prodCCD2" onkeyup="PagineoCCD2(1);" />
						</div>
					</div>
				</div>
				<span id="resultadobuscaCCD2">
					<spam style="visibility:hidden" id="PagActCCD2">1</spam>
					<span style="visibility:hidden" id="RpaCCD2">1</span>
					<input style="visibility:hidden" type="text" name="LimitCCD2" id="LimitCCD2" value="10">
				</span>
				<input style="visibility:hidden" type="text" name="OrganizadorCCD2" id="OrganizadorCCD2">
			</div>
		</div>
	</div>
</div>
<div class="modal" id="apps-modal1y22" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-fullscreen-sm-down">
		<div class="modal-content">
			<div class="modal-header">
				<h4 id="appsmodal1y22name"><?php echo lang("Tabla"); ?></h4>
				<div class="card-actions">
					<div class='float-end'>
						<button onclick='closemodal("apps-modal1y22"); $("#apps-modalz").modal("show");' class='btn btn-outline-secondary' type="button"><span class="fa fa-close"></span></button>
					</div>
				</div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="table-responsive" id="ProductoTableRep">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal" id="apps-modal1y22x" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-fullscreen-sm-down">
		<div class="modal-content">
			<div class="modal-header">
				<h4 id="appsmodal1y22xname"><?php echo lang("Tabla"); ?></h4>
				<div class="card-actions">
					<div class='float-end'>
						<button onclick='closemodal("apps-modal1y22x"); $("#apps-modalz").modal("show");' class='btn btn-outline-secondary' type="button"><span class="fa fa-close"></span></button>
					</div>
				</div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="table-responsive" id="ListadodeCuentasporCobrarTableRep">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal" id="apps-modal1y22xx" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-fullscreen-sm-down">
		<div class="modal-content">
			<div class="modal-header">
				<h4 id="appsmodal1y22xxname"><?php echo lang("Tabla"); ?></h4>
				<div class="card-actions">
					<div class='float-end'>
						<button onclick='closemodal("apps-modal1y22xx"); $("#apps-modalz").modal("show");' class='btn btn-outline-secondary' type="button"><span class="fa fa-close"></span></button>
					</div>
				</div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="table-responsive" id="ProdddCuntCobrarTablaRep">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<span id="Temporal" class="d-none"></span>
<script src="jsdev/reportesventas.js?v=<? echo random_int(1, 9999999); ?>"></script>
<script>
	window.onload = function() {
		HabilitarBotones();
	}
</script>