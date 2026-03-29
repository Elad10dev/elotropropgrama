<style>
	.modal {
		overflow-y: auto;
	}
</style>

<?php

$valid = $_SESSION['CompanyActual'] === "1168" && ($_SESSION["userperfil"] <= 2000 or $_SESSION["userlogin"] === "MANRIQUE");

$valid2 = $_SESSION['CompanyActual'] === "1168" && ($_SESSION["userperfil"] == 2070);

$conn = conectar();
$sql = "SELECT a.* ,b.Descripcion as ModuloName , b.Link as Archivo FROM PosUpOpciones a inner join PosUpModulo b on a.IdModulo=b.IdModulo where a.IdModulo='" . $_SESSION["ModuloActual"] . "' and a.Link='" . $_SESSION['opcion'] . "'  limit 1";

if ($resu = mysqli_query($conn, $sql)) {
	while ($rw = mysqli_fetch_assoc($resu)) {
		$nameopcion = str_replace('2', '', str_replace(' R', '', str_replace(' -S', '', $rw['Descripcion'])));
		$namemodulo = str_replace('2', '', str_replace(' R', '', str_replace(' -S', '', $rw['ModuloName'])));
		$archimodulo = $rw['Archivo'];
?>


		<header id="header">
			<div class="container">
				<div class="row">
					<div class="col-md-8">
						<h1><i><img src="/img/<?php echo $rw['Img']; ?>" width="20" height="20"></i> <?php echo lang(str_replace('2', '', str_replace(' R', '', str_replace(' -S', '', $rw['Descripcion'])))); ?> </h1>
					</div>
					<div class="col-md-4 row ">
						<div class="col-11">
							<small><?php echo lang($rw['ExplicacionOpcion']); ?></small>
						</div>
						<div class="col-1">
							<?php if ($rw['LinkVideo'] <> '') { ?>
								<span type='button' class='btn btn-outline-primary' onclick="getVideo(`<?php echo $rw['LinkVideo']; ?>`,`<?php echo lang(str_replace('2', '', str_replace(' R', '', str_replace(' -S', '', $rw['Descripcion'])))); ?>`)"> <img src="/img/video.png" width="36" height="36"> </span>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</header>
<?php }
	mysqli_free_result($resu);
}


?>

<?php $frame = $_GET['frame'] ?? '';
if ($frame == '1') { // multicanal 
?>
<?php } else { ?>
	<nav aria-label="breadcrumb">
		<div class="container">
			<ol class="breadcrumb">
				<li class="breadcrumb-item "> <a href='/app.php?opcion=inventario.php'><?php echo lang('Inventario'); ?> </a></li>
				<li class="breadcrumb-item active"><?php echo lang('Reportes de Inventario'); ?></li>
			</ol>
		</div>
	</nav>
<?php }   ?>



<div class="container" id='option' style='padding-bottom:78px;'>
	<?php

	if (($valid2)) {
	?>

		<div class="card border-light mb-2 col-md-4 ">
			<div class="card-body">
				<h2><img src="/img/informez.png"></span></h2>
				<h4><?php echo lang('Inventario Físico'); ?> <button type="button" id="button005" onclick='inventario(5);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
			</div>
		</div>
	<?php
	}

	if ($_SESSION['CIdPlan'] == '0000000015') { // multicanal 
	?>
		<div class="row">
			<?php


			if ($_SESSION["userperfil"] <= 2000 or $_SESSION["userperfil"] == 2060 or $_SESSION["userperfil"] == "2055"  or ($_SESSION["userperfil"] == 2600) or ($_SESSION["userperfil"] == 2350) or ($_SESSION["userperfil"] == 2700) or ($_SESSION["userperfil"] == 2710)) {
			?>
				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Productos'); ?> <button type="button" id="button001" onclick='inventario(1)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Reposición de Inventario'); ?> <button type="button" id="button002" onclick='inventario(2)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Analisis de Productos'); ?> <button type="button" id="button003" onclick='inventario(3)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<?php
				if ($_SESSION['CompanyActual'] !== "1168" || ($valid)) {
				?>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios'); ?> <button type="button" id="button004" onclick='inventario(4)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div><?php
						}
							?>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Inventario Físico'); ?> <button type="button" id="button005" onclick='inventario(5);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<?php
				if ($_SESSION['CompanyActual'] === "1167" || ($valid)  || $_SESSION['CompanyActual'] === "1174" || $_SESSION['CompanyActual'] === "1181") {
				?>


					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 2'); ?> <button type="button" id="button015" onclick='inventario(15)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 3'); ?> <button type="button" id="button016" onclick='inventario(16)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 4'); ?> <button type="button" id="button018" onclick='inventario(18)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				}
				?>

				<div class="col-6" style="display:none">
					<div class="card">
						<div class="card-header bg-light bg-inverse">
							<h4>Promedio Anual de Compra/Venta</h4>
							<ul class="card-actions">
								<li>
									<button class="fa fa-search" style="visibility:hidden" data-toggle="modal" data-target="#apps-modal10" type="button"></button>
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

				<div class="col-6" style="display:none">
					<div class="card">
						<div class="card-header bg-light bg-inverse">
							<h4>Costo de Productos Importados</h4>
							<ul class="card-actions">
								<li>
									<button class="fa fa-search" style="visibility:hidden" data-toggle="modal" data-target="#apps-modal10" type="button"></button>
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

				<div class="col-6" style="display:none">
					<div class="card">
						<div class="card-header bg-light bg-inverse">
							<h4>Analisis de Compra</h4>
							<ul class="card-actions">
								<li>
									<button class="fa fa-search" style="visibility:hidden" data-toggle="modal" data-target="#apps-modal10" type="button"></button>
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

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Análisis de Familia'); ?> <button type="button" id="button006" onclick='inventario(6);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Análisis de Marca'); ?> <button type="button" id="button007" onclick='inventario(7);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Operaciones de inventario'); ?> <button type="button" id="button008" onclick='inventario(8);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Histórico de Seriales'); ?> <button type="button" id="button009" onclick='inventario(9);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 " style="display:none">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Estadística'); ?> <button type="button" data-bs-toggle="modal" data-bs-target="#apps-modal10" class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Movimiento Detallado'); ?> <button type="button" id="button010" onclick='inventario(10);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Movimiento Resumido'); ?> <button type="button" id="button011" onclick='inventario(11);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Movimiento Fiscal'); ?> <button type="button" id="button012" onclick='inventario(12);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Producción por Almacén de Venta'); ?> <button type="button" id="button013" onclick='inventario(13);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
			<?php
			}
			if ($_SESSION["userperfil"] == "2054" || $_SESSION["userperfil"] == "2053") {
			?>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Reposición de Inventario'); ?> <button type="button" id="button002" onclick='inventario(2)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Analisis de Productos'); ?> <button type="button" id="button003" onclick='inventario(3)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Inventario Físico'); ?> <button type="button" id="button005" onclick='inventario(5);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<?php
				if ($_SESSION['CompanyActual'] === "1167" || $_SESSION['CompanyActual'] === "1168" || $_SESSION['CompanyActual'] === "1174" || $_SESSION['CompanyActual'] === "1181") {
				?>


					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 2'); ?> <button type="button" id="button015" onclick='inventario(15)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 3'); ?> <button type="button" id="button016" onclick='inventario(16)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 4'); ?> <button type="button" id="button018" onclick='inventario(18)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				}
				?>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Análisis de Familia'); ?> <button type="button" id="button006" onclick='inventario(6);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Análisis de Marca'); ?> <button type="button" id="button007" onclick='inventario(7);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Histórico de Seriales'); ?> <button type="button" id="button009" onclick='inventario(9);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>


				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Movimiento Detallado'); ?> <button type="button" id="button010" onclick='inventario(10);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Movimiento Resumido'); ?> <button type="button" id="button011" onclick='inventario(11);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Movimiento Fiscal'); ?> <button type="button" id="button012" onclick='inventario(12);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Producción por Almacén de Venta'); ?> <button type="button" id="button013" onclick='inventario(13);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
			<?php
			}

			if ($_SESSION["userperfil"] == 2070 && $_SESSION['CompanyActual'] !== "1168") {
			?>

				<?php
				if ($_SESSION['CompanyActual'] !== "1168" || ($valid)) {
				?>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios'); ?> <button type="button" id="button004" onclick='inventario(4)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div><?php
						}
							?>
				<?php
				if ($_SESSION['CompanyActual'] === "1167" || $_SESSION['CompanyActual'] === "1174" || $_SESSION['CompanyActual'] === "1181") {
				?>


					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 2'); ?> <button type="button" id="button015" onclick='inventario(15)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 3'); ?> <button type="button" id="button016" onclick='inventario(16)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 4'); ?> <button type="button" id="button018" onclick='inventario(18)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				}
				?>
			<?php
			}

			if ($_SESSION["userperfil"] == 2100) {
			?>

				<?php
				if ($_SESSION['CompanyActual'] !== "1168" || ($valid)) {
				?>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios'); ?> <button type="button" id="button004" onclick='inventario(4)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div><?php
						}
							?>
				<?php
				if ($_SESSION['CompanyActual'] === "1167" || $_SESSION['CompanyActual'] === "1168" || $_SESSION['CompanyActual'] === "1174" || $_SESSION['CompanyActual'] === "1181") {
				?>


					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 2'); ?> <button type="button" id="button015" onclick='inventario(15)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 3'); ?> <button type="button" id="button016" onclick='inventario(16)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 4'); ?> <button type="button" id="button018" onclick='inventario(18)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				}
				?>
			<?php
			}

			if ($_SESSION["userperfil"] == 2400 || $_SESSION["userperfil"] == 2410) {
			?>
				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Productos'); ?><button type="button" id="button001" onclick='inventario(1);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Reposición de Inventario'); ?> <button type="button" id="button002" onclick='inventario(2);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<?php
				if ($_SESSION['CompanyActual'] !== "1168" || ($valid)) {
				?>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios'); ?> <button type="button" id="button004" onclick='inventario(4)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div><?php
						}
							?>
				<?php
				if ($_SESSION['CompanyActual'] === "1167" || $_SESSION['CompanyActual'] === "1168" || $_SESSION['CompanyActual'] === "1174" || $_SESSION['CompanyActual'] === "1181") {
				?>


					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 2'); ?> <button type="button" id="button015" onclick='inventario(15)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 3'); ?> <button type="button" id="button016" onclick='inventario(16)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 4'); ?> <button type="button" id="button018" onclick='inventario(18)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				}
				?>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Operaciones de inventario'); ?> <button type="button" id="button008" onclick='inventario(8);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Histórico de Seriales'); ?> <button type="button" id="button009" onclick='inventario(9);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Movimiento Detallado'); ?> <button type="button" id="button010" onclick='inventario(10);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Movimiento Resumido'); ?> <button type="button" id="button011" onclick='inventario(11);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Inventario Físico'); ?> <button type="button" id="button005" onclick='inventario(5);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
			<?php
			}

			if ($_SESSION["userperfil"] == 2470) {
			?>

				<?php
				if ($_SESSION['CompanyActual'] !== "1168" || ($valid)) {
				?>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios'); ?> <button type="button" id="button004" onclick='inventario(4)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div><?php
						}
							?>
				<?php
				if ($_SESSION['CompanyActual'] === "1167" || $_SESSION['CompanyActual'] === "1168" || $_SESSION['CompanyActual'] === "1174" || $_SESSION['CompanyActual'] === "1181") {
				?>


					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 2'); ?> <button type="button" id="button015" onclick='inventario(15)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 3'); ?> <button type="button" id="button016" onclick='inventario(16)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 4'); ?> <button type="button" id="button018" onclick='inventario(18)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				}
				?>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Movimiento Detallado'); ?> <button type="button" id="button010" onclick='inventario(10);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
			<?php
			}

			if ($_SESSION["userperfil"] == 2500) {
			?>

				<?php
				if ($_SESSION['CompanyActual'] !== "1168" || ($valid)) {
				?>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios'); ?> <button type="button" id="button004" onclick='inventario(4)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div><?php
						}
							?>
				<?php
				if ($_SESSION['CompanyActual'] === "1167" || $_SESSION['CompanyActual'] === "1168" || $_SESSION['CompanyActual'] === "1174" || $_SESSION['CompanyActual'] === "1181") {
				?>


					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 2'); ?> <button type="button" id="button015" onclick='inventario(15)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 3'); ?> <button type="button" id="button016" onclick='inventario(16)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 4'); ?> <button type="button" id="button018" onclick='inventario(18)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				}
				?>
			<?php
			}
			?>
		</div>
	<?php
	} else  if ($_SESSION['CIdPlan'] == '0000000017') { // stocker 
	?>
		<div class="row">
			<?php
			if ($_SESSION["userperfil"] <= 2000 or $_SESSION["userperfil"] == 2060 or $_SESSION["userperfil"] == "2055"  or ($_SESSION["userperfil"] == 2600) or ($_SESSION["userperfil"] == 2350) or ($_SESSION["userperfil"] == 2700) or ($_SESSION["userperfil"] == 2710)) {
			?>
				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Productos'); ?>  <button type="button" id="button001" onclick='inventario(1)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<?php
				if ($_SESSION['CompanyActual'] !== "1168" || ($valid)) {
				?>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios'); ?> <button type="button" id="button004" onclick='inventario(4)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div><?php
						}
							?>
				<?php
				if ($_SESSION['CompanyActual'] === "1167" || ($valid)  || $_SESSION['CompanyActual'] === "1174" || $_SESSION['CompanyActual'] === "1181") {
				?>


					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 2'); ?> <button type="button" id="button015" onclick='inventario(15)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 3'); ?> <button type="button" id="button016" onclick='inventario(16)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 4'); ?> <button type="button" id="button018" onclick='inventario(18)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				}
				?>


				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Operaciones de inventario'); ?> <button type="button" id="button008" onclick='inventario(8);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Movimiento Detallado'); ?> <button type="button" id="button010" onclick='inventario(10);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Movimiento Resumido'); ?> <button type="button" id="button011" onclick='inventario(11);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Movimiento Fiscal'); ?> <button type="button" id="button012" onclick='inventario(12);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
			<?php
			}
			if ($_SESSION["userperfil"] == "2054" || $_SESSION["userperfil"] == "2053") {
			?>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Reposición de Inventario'); ?> <button type="button" id="button002" onclick='inventario(2)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Analisis de Productos'); ?> <button type="button" id="button003" onclick='inventario(3)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Inventario Físico'); ?> <button type="button" id="button005" onclick='inventario(5);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<?php
				if ($_SESSION['CompanyActual'] === "1167" || $_SESSION['CompanyActual'] === "1168" || $_SESSION['CompanyActual'] === "1174" || $_SESSION['CompanyActual'] === "1181") {
				?>


					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 2'); ?> <button type="button" id="button015" onclick='inventario(15)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 3'); ?> <button type="button" id="button016" onclick='inventario(16)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 4'); ?> <button type="button" id="button018" onclick='inventario(18)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				}
				?>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Análisis de Familia'); ?> <button type="button" id="button006" onclick='inventario(6);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Análisis de Marca'); ?> <button type="button" id="button007" onclick='inventario(7);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Histórico de Seriales'); ?> <button type="button" id="button009" onclick='inventario(9);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>


				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Movimiento Detallado'); ?> <button type="button" id="button010" onclick='inventario(10);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Movimiento Resumido'); ?> <button type="button" id="button011" onclick='inventario(11);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Movimiento Fiscal'); ?> <button type="button" id="button012" onclick='inventario(12);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Producción por Almacén de Venta'); ?> <button type="button" id="button013" onclick='inventario(13);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
			<?php
			}
			if ($_SESSION["userperfil"] == 2070 && $_SESSION['CompanyActual'] !== "1168") {
			?>

				<?php
				if ($_SESSION['CompanyActual'] !== "1168" || ($valid)) {
				?>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios'); ?> <button type="button" id="button004" onclick='inventario(4)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div><?php
						}
							?>
				<?php
				if ($_SESSION['CompanyActual'] === "1167"  || $_SESSION['CompanyActual'] === "1174" || $_SESSION['CompanyActual'] === "1181") {
				?>


					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 2'); ?> <button type="button" id="button015" onclick='inventario(15)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 3'); ?> <button type="button" id="button016" onclick='inventario(16)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 4'); ?> <button type="button" id="button018" onclick='inventario(18)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				}
				?>
			<?php
			}
			if ($_SESSION["userperfil"] == 2100) {
			?>

				<?php
				if ($_SESSION['CompanyActual'] !== "1168" || ($valid)) {
				?>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios'); ?> <button type="button" id="button004" onclick='inventario(4)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div><?php
						}
							?>
				<?php
				if ($_SESSION['CompanyActual'] === "1167" || $_SESSION['CompanyActual'] === "1168" || $_SESSION['CompanyActual'] === "1174" || $_SESSION['CompanyActual'] === "1181") {
				?>


					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 2'); ?> <button type="button" id="button015" onclick='inventario(15)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 3'); ?> <button type="button" id="button016" onclick='inventario(16)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 4'); ?> <button type="button" id="button018" onclick='inventario(18)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				}
				?>

			<?php
			}
			if ($_SESSION["userperfil"] == 2400 || $_SESSION["userperfil"] == 2410) {
			?>
				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Productos'); ?> <button type="button" id="button001" onclick='inventario(1);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Reposición de Inventario'); ?> <button type="button" id="button002" onclick='inventario(2);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>


				<?php
				if ($_SESSION['CompanyActual'] !== "1168" || ($valid)) {
				?>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios'); ?> <button type="button" id="button004" onclick='inventario(4)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div><?php
						}
							?>
				<?php
				if ($_SESSION['CompanyActual'] === "1167" || $_SESSION['CompanyActual'] === "1168" || $_SESSION['CompanyActual'] === "1174" || $_SESSION['CompanyActual'] === "1181") {
				?>


					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 2'); ?> <button type="button" id="button015" onclick='inventario(15)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 3'); ?> <button type="button" id="button016" onclick='inventario(16)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 4'); ?> <button type="button" id="button018" onclick='inventario(18)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				}
				?>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Operaciones de inventario'); ?> <button type="button" id="button008" onclick='inventario(8);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Histórico de Seriales'); ?> <button type="button" id="button009" onclick='inventario(9);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Movimiento Detallado'); ?> <button type="button" id="button010" onclick='inventario(10);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Movimiento Resumido'); ?> <button type="button" id="button011" onclick='inventario(11);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Inventario Físico'); ?> <button type="button" id="button005" onclick='inventario(5);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
			<?php
			}
			if ($_SESSION["userperfil"] == 2470) {
			?>

				<?php
				if ($_SESSION['CompanyActual'] !== "1168" || ($valid)) {
				?>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios'); ?> <button type="button" id="button004" onclick='inventario(4)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div><?php
						}
							?>
				<?php
				if ($_SESSION['CompanyActual'] === "1167" || $_SESSION['CompanyActual'] === "1168" || $_SESSION['CompanyActual'] === "1174" || $_SESSION['CompanyActual'] === "1181") {
				?>


					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 2'); ?> <button type="button" id="button015" onclick='inventario(15)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 3'); ?> <button type="button" id="button016" onclick='inventario(16)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 4'); ?> <button type="button" id="button018" onclick='inventario(18)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				}
				?>
				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Movimiento Detallado'); ?> <button type="button" id="button010" onclick='inventario(10);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
			<?php
			}
			if ($_SESSION["userperfil"] == 2500) {
			?>

				<?php
				if ($_SESSION['CompanyActual'] !== "1168" || ($valid)) {
				?>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios'); ?> <button type="button" id="button004" onclick='inventario(4)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div><?php
						}
							?>
				<?php
				if ($_SESSION['CompanyActual'] === "1167" || $_SESSION['CompanyActual'] === "1168" || $_SESSION['CompanyActual'] === "1174" || $_SESSION['CompanyActual'] === "1181") {
				?>


					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 2'); ?> <button type="button" id="button015" onclick='inventario(15)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 3'); ?> <button type="button" id="button016" onclick='inventario(16)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 4'); ?> <button type="button" id="button018" onclick='inventario(18)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				}
				?>

			<?php
			}
			?>
		</div>
	<?php
	} else if ($_SESSION['CIdPlan'] == '0000000018') { // restaurant
	?>
		<div class="row">
			<?php
			if ($_SESSION["userperfil"] <= 2000 || $_SESSION["userperfil"] === "2055") {
			?>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Recetas'); ?> <button type="button" id="button017" onclick='inventario(17);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
			<?php
			}
			if ($_SESSION["userperfil"] <= 2000 or $_SESSION["userperfil"] == 2060 or $_SESSION["userperfil"] == "2055"  or ($_SESSION["userperfil"] == 2600) or ($_SESSION["userperfil"] == 2350) or ($_SESSION["userperfil"] == 2700) or ($_SESSION["userperfil"] == 2710)) {
			?>
				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Productos'); ?> <button type="button" id="button001" onclick='inventario(1)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Reposición de Inventario'); ?> <button type="button" id="button002" onclick='inventario(2)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Analisis de Productos'); ?> <button type="button" id="button003" onclick='inventario(3)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>


				<?php
				if ($_SESSION['CompanyActual'] !== "1168" || ($valid)) {
				?>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios'); ?> <button type="button" id="button004" onclick='inventario(4)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div><?php
						}
							?>
				<?php
				if ($_SESSION['CompanyActual'] === "1167" || ($valid)  || $_SESSION['CompanyActual'] === "1174" || $_SESSION['CompanyActual'] === "1181") {
				?>


					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 2'); ?> <button type="button" id="button015" onclick='inventario(15)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 3'); ?> <button type="button" id="button016" onclick='inventario(16)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 4'); ?> <button type="button" id="button018" onclick='inventario(18)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				}
				?>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Inventario Físico'); ?> <button type="button" id="button005" onclick='inventario(5);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="col-6" style="display:none">
					<div class="card">
						<div class="card-header bg-light bg-inverse">
							<h4>Promedio Anual de Compra/Venta</h4>
							<ul class="card-actions">
								<li>
									<button class="fa fa-search" style="visibility:hidden" data-toggle="modal" data-target="#apps-modal10" type="button"></button>
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

				<div class="col-6" style="display:none">
					<div class="card">
						<div class="card-header bg-light bg-inverse">
							<h4>Costo de Productos Importados</h4>
							<ul class="card-actions">
								<li>
									<button class="fa fa-search" style="visibility:hidden" data-toggle="modal" data-target="#apps-modal10" type="button"></button>
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

				<div class="col-6" style="display:none">
					<div class="card">
						<div class="card-header bg-light bg-inverse">
							<h4>Analisis de Compra</h4>
							<ul class="card-actions">
								<li>
									<button class="fa fa-search" style="visibility:hidden" data-toggle="modal" data-target="#apps-modal10" type="button"></button>
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

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Análisis de Familia'); ?> <button type="button" id="button006" onclick='inventario(6);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Análisis de Marca'); ?> <button type="button" id="button007" onclick='inventario(7);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Operaciones de inventario'); ?> <button type="button" id="button008" onclick='inventario(8);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Histórico de Seriales'); ?> <button type="button" id="button009" onclick='inventario(9);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 " style="display:none">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Estadística'); ?> <button type="button" data-bs-toggle="modal" data-bs-target="#apps-modal10" class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Movimiento Detallado'); ?> <button type="button" id="button010" onclick='inventario(10);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Movimiento Resumido'); ?> <button type="button" id="button011" onclick='inventario(11);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Movimiento Fiscal'); ?> <button type="button" id="button012" onclick='inventario(12);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Producción por Almacén de Venta'); ?> <button type="button" id="button013" onclick='inventario(13);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
			<?php
			}
			if ($_SESSION["userperfil"] == "2054" || $_SESSION["userperfil"] == "2053") {
			?>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Reposición de Inventario'); ?> <button type="button" id="button002" onclick='inventario(2)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Analisis de Productos'); ?> <button type="button" id="button003" onclick='inventario(3)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Inventario Físico'); ?> <button type="button" id="button005" onclick='inventario(5);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<?php
				if ($_SESSION['CompanyActual'] === "1167" || $_SESSION['CompanyActual'] === "1168" || $_SESSION['CompanyActual'] === "1174" || $_SESSION['CompanyActual'] === "1181") {
				?>


					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 2'); ?> <button type="button" id="button015" onclick='inventario(15)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 3'); ?> <button type="button" id="button016" onclick='inventario(16)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 4'); ?> <button type="button" id="button018" onclick='inventario(18)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				}
				?>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Análisis de Familia'); ?> <button type="button" id="button006" onclick='inventario(6);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Análisis de Marca'); ?> <button type="button" id="button007" onclick='inventario(7);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Histórico de Seriales'); ?> <button type="button" id="button009" onclick='inventario(9);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>


				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Movimiento Detallado'); ?> <button type="button" id="button010" onclick='inventario(10);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Movimiento Resumido'); ?> <button type="button" id="button011" onclick='inventario(11);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Movimiento Fiscal'); ?> <button type="button" id="button012" onclick='inventario(12);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Producción por Almacén de Venta'); ?> <button type="button" id="button013" onclick='inventario(13);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
			<?php
			}
			if ($_SESSION["userperfil"] == 2070 && $_SESSION['CompanyActual'] !== "1168") {
			?>

				<?php
				if ($_SESSION['CompanyActual'] !== "1168" || ($valid)) {
				?>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios'); ?> <button type="button" id="button004" onclick='inventario(4)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div><?php
						}
							?>
				<?php
				if ($_SESSION['CompanyActual'] === "1167"  || $_SESSION['CompanyActual'] === "1174" || $_SESSION['CompanyActual'] === "1181") {
				?>


					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 2'); ?> <button type="button" id="button015" onclick='inventario(15)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 3'); ?> <button type="button" id="button016" onclick='inventario(16)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 4'); ?> <button type="button" id="button018" onclick='inventario(18)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				}
				?>
			<?php
			}
			if ($_SESSION["userperfil"] == 2100) {
			?>

				<?php
				if ($_SESSION['CompanyActual'] !== "1168" || ($valid)) {
				?>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios'); ?> <button type="button" id="button004" onclick='inventario(4)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div><?php
						}
							?>
				<?php
				if ($_SESSION['CompanyActual'] === "1167" || $_SESSION['CompanyActual'] === "1168" || $_SESSION['CompanyActual'] === "1174" || $_SESSION['CompanyActual'] === "1181") {
				?>


					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 2'); ?> <button type="button" id="button015" onclick='inventario(15)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 3'); ?> <button type="button" id="button016" onclick='inventario(16)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 4'); ?> <button type="button" id="button018" onclick='inventario(18)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				}
				?>

			<?php
			}
			if ($_SESSION["userperfil"] == 2400 || $_SESSION["userperfil"] == 2410) {
			?>
				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Productos'); ?> <button type="button" id="button001" onclick='inventario(1);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Reposición de Inventario'); ?> <button type="button" id="button002" onclick='inventario(2);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<?php
				if ($_SESSION['CompanyActual'] !== "1168" || ($valid)) {
				?>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios'); ?> <button type="button" id="button004" onclick='inventario(4)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div><?php
						}
							?>
				<?php
				if ($_SESSION['CompanyActual'] === "1167" || $_SESSION['CompanyActual'] === "1168" || $_SESSION['CompanyActual'] === "1174" || $_SESSION['CompanyActual'] === "1181") {
				?>


					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 2'); ?> <button type="button" id="button015" onclick='inventario(15)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 3'); ?> <button type="button" id="button016" onclick='inventario(16)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 4'); ?> <button type="button" id="button018" onclick='inventario(18)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				}
				?>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Operaciones de inventario'); ?> <button type="button" id="button008" onclick='inventario(8);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Histórico de Seriales'); ?> <button type="button" id="button009" onclick='inventario(9);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Movimiento Detallado'); ?> <button type="button" id="button010" onclick='inventario(10);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Movimiento Resumido'); ?> <button type="button" id="button011" onclick='inventario(11);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Inventario Físico'); ?> <button type="button" id="button005" onclick='inventario(5);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
			<?php
			}
			if ($_SESSION["userperfil"] == 2470) {
			?>

				<?php
				if ($_SESSION['CompanyActual'] !== "1168" || ($valid)) {
				?>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios'); ?> <button type="button" id="button004" onclick='inventario(4)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div><?php
						}
							?>
				<?php
				if ($_SESSION['CompanyActual'] === "1167" || $_SESSION['CompanyActual'] === "1168" || $_SESSION['CompanyActual'] === "1174" || $_SESSION['CompanyActual'] === "1181") {
				?>


					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 2'); ?> <button type="button" id="button015" onclick='inventario(15)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 3'); ?> <button type="button" id="button016" onclick='inventario(16)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 4'); ?> <button type="button" id="button018" onclick='inventario(18)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				}
				?>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Movimiento Detallado'); ?> <button type="button" id="button010" onclick='inventario(10);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
			<?php
			}
			if ($_SESSION["userperfil"] == 2500) {
			?>

				<?php
				if ($_SESSION['CompanyActual'] !== "1168" || ($valid)) {
				?>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios'); ?> <button type="button" id="button004" onclick='inventario(4)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div><?php
						}
							?>
				<?php
				if ($_SESSION['CompanyActual'] === "1167" || $_SESSION['CompanyActual'] === "1168" || $_SESSION['CompanyActual'] === "1174" || $_SESSION['CompanyActual'] === "1181") {
				?>


					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 2'); ?> <button type="button" id="button015" onclick='inventario(15)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 3'); ?> <button type="button" id="button016" onclick='inventario(16)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 4'); ?> <button type="button" id="button018" onclick='inventario(18)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				}
				?>
			<?php
			}
			if ($_SESSION["userperfil"] == 2405) {
			?>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Inventario Físico'); ?> <button type="button" id="button005" onclick='inventario(5);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>


				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Reposición de Inventario'); ?> <button type="button" id="button002" onclick='inventario(2)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

			<?php
			}
			?>


		</div>
	<?php
	} else {
	?>
		<div class="row">
			<?php
			if ($_SESSION["userperfil"] <= 2000 or $_SESSION["userperfil"] == 2060 or $_SESSION["userperfil"] == "2055"  or ($_SESSION["userperfil"] == 2600) or ($_SESSION["userperfil"] == 2350) or ($_SESSION["userperfil"] == 2700) or ($_SESSION["userperfil"] == 2710)) {
			?>
				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Productos'); ?> 22<button type="button" id="button001" onclick='inventario(1)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Reposición de Inventario'); ?> <button type="button" id="button002" onclick='inventario(2)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Analisis de Productos'); ?> <button type="button" id="button003" onclick='inventario(3)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>


				<?php
				if ($_SESSION['CompanyActual'] !== "1168" || ($valid)) {
				?>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios'); ?> <button type="button" id="button004" onclick='inventario(4)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div><?php
						}
							?>
				<?php
				if ($_SESSION['CompanyActual'] === "1167" || ($valid) || $_SESSION['CompanyActual'] === "1174" || $_SESSION['CompanyActual'] === "1181") {
				?>


					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 2'); ?> <button type="button" id="button015" onclick='inventario(15)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 3'); ?> <button type="button" id="button016" onclick='inventario(16)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 4'); ?> <button type="button" id="button018" onclick='inventario(18)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				}
				?>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Inventario Físico'); ?> <button type="button" id="button005" onclick='inventario(5);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="col-6" style="display:none">
					<div class="card">
						<div class="card-header bg-light bg-inverse">
							<h4>Promedio Anual de Compra/Venta</h4>
							<ul class="card-actions">
								<li>
									<button class="fa fa-search" style="visibility:hidden" data-toggle="modal" data-target="#apps-modal10" type="button"></button>
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

				<div class="col-6" style="display:none">
					<div class="card">
						<div class="card-header bg-light bg-inverse">
							<h4>Costo de Productos Importados</h4>
							<ul class="card-actions">
								<li>
									<button class="fa fa-search" style="visibility:hidden" data-toggle="modal" data-target="#apps-modal10" type="button"></button>
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

				<div class="col-6" style="display:none">
					<div class="card">
						<div class="card-header bg-light bg-inverse">
							<h4>Analisis de Compra</h4>
							<ul class="card-actions">
								<li>
									<button class="fa fa-search" style="visibility:hidden" data-toggle="modal" data-target="#apps-modal10" type="button"></button>
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

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Análisis de Familia'); ?> <button type="button" id="button006" onclick='inventario(6);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Análisis de Marca'); ?> <button type="button" id="button007" onclick='inventario(7);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Operaciones de inventario'); ?> <button type="button" id="button008" onclick='inventario(8);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Histórico de Seriales'); ?> <button type="button" id="button009" onclick='inventario(9);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 " style="display:none">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Estadística'); ?> <button type="button" data-bs-toggle="modal" data-bs-target="#apps-modal10" class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Movimiento Detallado'); ?> <button type="button" id="button010" onclick='inventario(10);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Movimiento Resumido'); ?> <button type="button" id="button011" onclick='inventario(11);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Movimiento Fiscal'); ?> <button type="button" id="button012" onclick='inventario(12);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Producción por Almacén de Venta'); ?> <button type="button" id="button013" onclick='inventario(13);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

			<?php
			}
			if ($_SESSION["userperfil"] == "2054" || $_SESSION["userperfil"] == "2053") {
			?>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Reposición de Inventario'); ?> <button type="button" id="button002" onclick='inventario(2)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Analisis de Productos'); ?> <button type="button" id="button003" onclick='inventario(3)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Inventario Físico'); ?> <button type="button" id="button005" onclick='inventario(5);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<?php
				if ($_SESSION['CompanyActual'] === "1167" || $_SESSION['CompanyActual'] === "1168" || $_SESSION['CompanyActual'] === "1174" || $_SESSION['CompanyActual'] === "1181") {
				?>


					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 2'); ?> <button type="button" id="button015" onclick='inventario(15)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 3'); ?> <button type="button" id="button016" onclick='inventario(16)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 4'); ?> <button type="button" id="button018" onclick='inventario(18)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				}
				?>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Análisis de Familia'); ?> <button type="button" id="button006" onclick='inventario(6);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Análisis de Marca'); ?> <button type="button" id="button007" onclick='inventario(7);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Histórico de Seriales'); ?> <button type="button" id="button009" onclick='inventario(9);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>


				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Movimiento Detallado'); ?> <button type="button" id="button010" onclick='inventario(10);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Movimiento Resumido'); ?> <button type="button" id="button011" onclick='inventario(11);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Movimiento Fiscal'); ?> <button type="button" id="button012" onclick='inventario(12);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Producción por Almacén de Venta'); ?> <button type="button" id="button013" onclick='inventario(13);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
			<?php
			}
			if ($_SESSION["userperfil"] == 2070 && $_SESSION['CompanyActual'] !== "1168") {
			?>

				<?php
				if ($_SESSION['CompanyActual'] !== "1168" || ($valid)) {
				?>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios'); ?> <button type="button" id="button004" onclick='inventario(4)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div><?php
						}
							?>
				<?php
				if ($_SESSION['CompanyActual'] === "1167"  || $_SESSION['CompanyActual'] === "1174" || $_SESSION['CompanyActual'] === "1181") {
				?>


					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 2'); ?> <button type="button" id="button015" onclick='inventario(15)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 3'); ?> <button type="button" id="button016" onclick='inventario(16)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 4'); ?> <button type="button" id="button018" onclick='inventario(18)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				}
				?>

			<?php
			}
			if ($_SESSION["userperfil"] == 2100) {
			?>

				<?php
				if ($_SESSION['CompanyActual'] !== "1168" || ($valid)) {
				?>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios'); ?> <button type="button" id="button004" onclick='inventario(4)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div><?php
						}
							?>
				<?php
				if ($_SESSION['CompanyActual'] === "1167" || $_SESSION['CompanyActual'] === "1168" || $_SESSION['CompanyActual'] === "1174" || $_SESSION['CompanyActual'] === "1181") {
				?>


					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 2'); ?> <button type="button" id="button015" onclick='inventario(15)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 3'); ?> <button type="button" id="button016" onclick='inventario(16)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 4'); ?> <button type="button" id="button018" onclick='inventario(18)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				}
				?>
			<?php
			}
			if ($_SESSION["userperfil"] == 2400 || $_SESSION["userperfil"] == 2410) {
			?>
				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Productos'); ?> <button type="button" id="button001" onclick='inventario(1);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Reposición de Inventario'); ?> <button type="button" id="button002" onclick='inventario(2);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>


				<?php
				if ($_SESSION['CompanyActual'] !== "1168" || ($valid)) {
				?>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios'); ?> <button type="button" id="button004" onclick='inventario(4)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div><?php
						}
							?>
				<?php
				if ($_SESSION['CompanyActual'] === "1167" || $_SESSION['CompanyActual'] === "1168" || $_SESSION['CompanyActual'] === "1174" || $_SESSION['CompanyActual'] === "1181") {
				?>


					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 2'); ?> <button type="button" id="button015" onclick='inventario(15)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 3'); ?> <button type="button" id="button016" onclick='inventario(16)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 4'); ?> <button type="button" id="button018" onclick='inventario(18)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				}
				?>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Operaciones de inventario'); ?> <button type="button" id="button008" onclick='inventario(8);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Histórico de Seriales'); ?> <button type="button" id="button009" onclick='inventario(9);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Inventario Físico'); ?> <button type="button" id="button005" onclick='inventario(5);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Inventario Físico'); ?> <button type="button" id="button005" onclick='inventario(5);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>
			<?php
			}
			if ($_SESSION["userperfil"] == 2470) {
			?>

				<?php
				if ($_SESSION['CompanyActual'] !== "1168" || ($valid)) {
				?>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios'); ?> <button type="button" id="button004" onclick='inventario(4)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div><?php
						}
							?>
				<?php
				if ($_SESSION['CompanyActual'] === "1167" || $_SESSION['CompanyActual'] === "1168" || $_SESSION['CompanyActual'] === "1174" || $_SESSION['CompanyActual'] === "1181") {
				?>


					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 2'); ?> <button type="button" id="button015" onclick='inventario(15)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 3'); ?> <button type="button" id="button016" onclick='inventario(16)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 4'); ?> <button type="button" id="button018" onclick='inventario(18)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				}
				?>

				<div class="card border-light mb-2 col-md-4 ">
					<div class="card-body">
						<h2><img src="/img/informez.png"></span></h2>
						<h4><?php echo lang('Movimiento Detallado'); ?> <button type="button" id="button010" onclick='inventario(10);' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
					</div>
				</div>

			<?php
			}
			if ($_SESSION["userperfil"] == 2500) {
			?>

				<?php
				if ($_SESSION['CompanyActual'] !== "1168" || ($valid)) {
				?>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios'); ?> <button type="button" id="button004" onclick='inventario(4)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div><?php
						}
							?>
				<?php
				if ($_SESSION['CompanyActual'] === "1167" || $_SESSION['CompanyActual'] === "1168" || $_SESSION['CompanyActual'] === "1174" || $_SESSION['CompanyActual'] === "1181") {
				?>


					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 2'); ?> <button type="button" id="button015" onclick='inventario(15)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 3'); ?> <button type="button" id="button016" onclick='inventario(16)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
					<div class="card border-light mb-2 col-md-4 ">
						<div class="card-body">
							<h2><img src="/img/informez.png"></span></h2>
							<h4><?php echo lang('Lista de Precios 4'); ?> <button type="button" id="button018" onclick='inventario(18)' class="btn btn-outline-primary p-1 m-1" disabled> <i class="fa fa-arrow-right"> </i> <?php echo lang('Usar'); ?></button></h4>
						</div>
					</div>
				<?php
				}
				?>

			<?php
			}
			?>
		</div>
	<?php
	}
	?>
</div>

<div class="modal" id="apps-modalz" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<span id="prueba1"></span>
		</div>
	</div>
</div>

<div class="modal" id="apps-modal99" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-fullscreen-sm-down">
		<div class="modal-content">
			<div class="modal-header">
				<h4 id="appsmodal99name"><?php echo lang("Tabla"); ?></h4>
				<div class="card-actions">
					<div class='float-end'>
						<button onclick='closemodal("apps-modal99"); $("#apps-modalz").modal("show");' class='btn btn-outline-secondary' type="button"><span class="fa fa-close"></span></button>
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

<div class="modal" id="apps-modal129" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-fullscreen-sm-down">
		<div class="modal-content">
			<div class="card m-b-0">
				<div class="modal-header">
					<h4 id="appsmodal129name"><?php echo lang("Tabla"); ?></h4>
					<div class="card-actions">
						<div class='float-end'>
							<button onclick='closemodal("apps-modal129"); $("#apps-modalz").modal("show");' class='btn btn-outline-secondary' type="button"><span class="fa fa-close"></span></button>
						</div>
					</div>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="table-responsive" id="ReposicionTableRep">

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="apps-modal149" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-fullscreen-sm-down">
		<div class="modal-content">
			<div class="modal-header">
				<h4 id="appsmodal149name"><?php echo lang("Tabla"); ?></h4>
				<div class="card-actions">
					<div class='float-end'>
						<button onclick='closemodal("apps-modal149"); $("#apps-modalz").modal("show");' class='btn btn-outline-secondary' type="button"><span class="fa fa-close"></span></button>
					</div>
				</div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="table-responsive" id="AnalisisTableRep">

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="apps-modal109" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-fullscreen-sm-down">
		<div class="modal-content">
			<div class="modal-header">
				<h4 id="appsmodal109name"><?php echo lang("Tabla"); ?></h4>
				<div class="card-actions">
					<div class='float-end'>
						<button onclick='closemodal("apps-modal109"); $("#apps-modalz").modal("show");' class='btn btn-outline-secondary' type="button"><span class="fa fa-close"></span></button>
					</div>
				</div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="table-responsive" id="ListaPrecioTableRep">

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="apps-modal159" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-fullscreen-sm-down">
		<div class="modal-content">
			<div class="modal-header">
				<h4 id="appsmodal159name"><?php echo lang("Tabla"); ?></h4>
				<div class="card-actions">
					<div class='float-end'>
						<button onclick='closemodal("apps-modal159"); $("#apps-modalz").modal("show");' class='btn btn-outline-secondary' type="button"><span class="fa fa-close"></span></button>
					</div>
				</div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="table-responsive" id="InventarioFisiTableRep">

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="apps-modal31y2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-fullscreen-sm-down">
		<div class="modal-content">
			<div class="card m-b-0">
				<div class="modal-header">
					<h4 id="appsmodal31y2name"><?php echo lang("Tabla"); ?></h4>
					<div class="card-actions">
						<div class='float-end'>
							<button onclick='closemodal("apps-modal31y2"); $("#apps-modalz").modal("show");' class='btn btn-outline-secondary' type="button"><span class="fa fa-close"></span></button>
						</div>
					</div>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="table-responsive" id="AnalisisdeFamiliaTableRep">

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="apps-modal30y2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-fullscreen-sm-down">
		<div class="modal-content">
			<div class="modal-header">
				<h4 id="appsmodal30y2name"><?php echo lang("Tabla"); ?></h4>
				<div class="card-actions">
					<div class='float-end'>
						<button onclick='closemodal("apps-modal30y2"); $("#apps-modalz").modal("show");' class='btn btn-outline-secondary' type="button"><span class="fa fa-close"></span></button>
					</div>
				</div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="table-responsive" id="AnalisisdeMarcaTableRep">

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="apps-modal215" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-fullscreen-sm-down">
		<div class="modal-content">
			<div class="modal-header">
				<h4 id="appsmodal215name"><?php echo lang("Tabla"); ?></h4>
				<div class="card-actions">
					<div class='float-end'>
						<button onclick='closemodal("apps-modal215"); $("#apps-modalz").modal("show");' class='btn btn-outline-secondary' type="button"><span class="fa fa-close"></span></button>
					</div>
				</div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="table-responsive" id="OperacionesdeinventarioTableRep">

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="apps-modal139" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-fullscreen-sm-down">
		<div class="modal-content">
			<div class="modal-header">
				<h4 id="appsmodal139name"><?php echo lang("Tabla"); ?></h4>
				<div class="card-actions">
					<div class='float-end'>
						<button onclick='closemodal("apps-modal139"); $("#apps-modalz").modal("show");' class='btn btn-outline-secondary' type="button"><span class="fa fa-close"></span></button>
					</div>
				</div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="table-responsive" id="HistoricoSerialesTableRep">

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="apps-modal189" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-fullscreen-sm-down">
		<div class="modal-content">
			<div class="modal-header">
				<h4 id="appsmodal189name"><?php echo lang("Tabla"); ?></h4>
				<div class="card-actions">
					<div class='float-end'>
						<button onclick='closemodal("apps-modal189"); $("#apps-modalz").modal("show");' class='btn btn-outline-secondary' type="button"><span class="fa fa-close"></span></button>
					</div>
				</div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="table-responsive" id="MovDetalladoTableRep">

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="apps-modal119" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-fullscreen-sm-down">
		<div class="modal-content">
			<div class="modal-header">
				<h4 id="appsmodal119name"><?php echo lang("Tabla"); ?></h4>
				<div class="card-actions">
					<div class='float-end'>
						<button onclick='closemodal("apps-modal119"); $("#apps-modalz").modal("show");' class='btn btn-outline-secondary' type="button"><span class="fa fa-close"></span></button>
					</div>
				</div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="table-responsive" id="MovimientoResumidoTableRep">

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="apps-modal229" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-fullscreen-sm-down">
		<div class="modal-content">
			<div class="modal-header">
				<h4 id="appsmodal229name"><?php echo lang("Tabla"); ?></h4>
				<div class="card-actions">
					<div class='float-end'>
						<button onclick='closemodal("apps-modal229"); $("#apps-modalz").modal("show");' class='btn btn-outline-secondary' type="button"><span class="fa fa-close"></span></button>
					</div>
				</div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="table-responsive" id="MovimientoFiscalRep">

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="apps-modal230" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-fullscreen-sm-down">
		<div class="modal-content">
			<div class="modal-header">
				<h4 id="appsmodal230name"><?php echo lang("Tabla"); ?></h4>
				<div class="card-actions">
					<div class='float-end'>
						<button onclick='closemodal("apps-modal230"); $("#apps-modalz").modal("show");' class='btn btn-outline-secondary' type="button"><span class="fa fa-close"></span></button>
					</div>
				</div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="table-responsive" id="AlmacendeVentaRep">

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<span id="Temporal" class="d-none"></span>

<script src="jsdev/reportinvent.js?v=<? echo random_int(1, 9999999); ?>"></script>
<script>
	window.onload = function() {
		HabilitarBotones();
	}
</script>