<?php

include "ambiente.php";
$conn = ConectarConsultas();
session_start();

if ($_SESSION['IdiomaActual'] == '') {
	$_SESSION['IdiomaActual'] = $_POST['IdiomaActual'];
}

if ($_POST['CIdPlan'] == '0000000019') {
	if ($_POST['IdCompanySelect'] == '' or $_POST['IdCompanySelect'] == $_POST["IdCompanyGrp"]) {
		$companygrp = " in (" . $_POST["CompanyActual"] . "," . $_POST["IdCompanyGrp"] . ") ";
	} else {
		$companygrp = " in (" . $_POST["IdCompanySelect"] . ") ";
	}
} else {
	$companygrp = " = " . $_POST["CompanyActual"] . "  ";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Expires" content="0">
	<meta http-equiv="Last-Modified" content="0">
	<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
	<meta http-equiv="Pragma" content="no-cache">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
	<meta name="generator" content="Hugo 0.82.0">
	<title><?php echo lang("Análisis de Productos"); ?></title>
	<!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css"> -->
	<link rel="shortcut icon" href="img/AZUL.png" type="image/x-icon">
	<link rel="icon" href="img/ISO AZUL.svg" sizes="32x32" type="image/png">
	<link rel="apple-touch-icon" href="img/ISO AZUL.svg" sizes="180x180">
	<link rel="icon" href="img/ISO AZUL.svg" sizes="16x16" type="image/png">
	<link rel="icon" href="img/ISO AZUL.svg">
</head>
<style>
	@media print {
		.ocultoimpresion {
			display: none !important;
		}

		@page {
			margin: 0;
			size: A4 landscape;
		}

		.saltopagina {
			display: block;
			page-break-before: always;
		}

	}

	:root {
		--total-pages: 0;
	}

	.page {}

	body {
		counter-reset: page-counter 0 total-pages var(--total-pages);
		font-family: Tahoma, Verdana, Segoe, sans-serif;
		line-height: 1;
		margin: 5mm 5mm 5mm 5mm;
	}

	.pagina {}

	.sup {
		float: left;
		width: 100%;
	}

	.TituloEmpresa {
		font-weight: 600;
		font-size: 16.4px;
		text-align: left;
	}

	.Subtituloempresa {
		font-size: 9.3px;
		text-align: left;
	}

	.FechaI {
		font-size: 10px;
		text-align: right;
		float: right;

	}

	.page::before {
		counter-increment: page-counter 1;
		font-size: 10px;


		content: "Pagina " counter(page-counter) " de " counter(total-pages);
		align-content: right;
	}

	.encabezado {
		margin-top: 5px;
		float: left;
		width: 100%;
		padding: 0 2px 0 0;
		margin-right: 1%;
		text-align: left;
		background-color: white;
		font-size: 10px;
	}

	.campo {
		float: left;
		margin-right: 3px;
		font-size: 11px;

	}

	.registro {
		float: left;
		width: 100%;
		padding: 0 2px 0 0;
		margin-right: 1%;
		text-align: left;
		background-color: white;
	}

	.secciones {
		width: 80%;
		font-size: 11px;
		text-align: center;
		margin-left: 16%;
		background-color: black;
	}

	.rsecciones {
		width: 34%;
		float: left;
	}

	.TodosLosRecuadros {
		width: 100%;
		background-color: black;
		font-family: Tahoma, Verdana, Segoe, sans-serif;
		font-size: 10px;
		text-align: right
	}

	.Recuadros {
		width: 10%;
		float: left;
		display: block;
		margin-left: 5px;
		margin-right: 5px;
	}

	.TituloR {
		background-color: gray;
	}

	.pie {}
</style>

<body>
	<button type='submit' class='ocultoimpresion ' onclick='window.print();'><img src='/img/pdf.png' width='28' height='28'><br>PDF</button>
	<button class='ocultoimpresion ' onclick='document.getElementById(`formexcel`).submit()'><img src='/img/excel.png' width='28' height='28'><br>AnálisisP<br></button>
	<div class="pagina" style="font-size: 12px;">
		<div class="sup">
			<div style="float:left; width: 23%;">
				<div class="TituloEmpresa" id="Titulo"><?php echo $_POST["NameCompany"]; ?></div>
				<div class="Subtituloempresa" id="Ubicacion"><?php echo $_POST["direccion"]; ?></div>
				<div class="Subtituloempresa" id="Literal Fiscal"><?php echo $_POST["litfiscal"]; ?>-<?php echo $_POST["rute"]; ?></div>
			</div>
			<div style="float:left; width: 53%;">
				<div class="TituloEmpresa" style="float: center; text-align: center;"><?php echo lang("Análisis de Productos"); ?></div>
				<div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php echo lang("Orden por"); ?>:<?php echo $_POST["OrdenAX222"]; ?> <?php if ($_POST["DesdeAX"] == true) {
																																																		echo " " . lang("Desde el codigo") . ":" . $_POST["DesdeAX"];
																																																	} ?> <?php if ($_POST["HastaAX"] == true) {
																																																				echo lang("al") . " " . $_POST["HastaAX"];
																																																			} ?></div>
				<div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php if ($_POST["BeneficiarioAX"] == true or $_POST["AlmacenAX"] == true) {
																																echo "Con:";
																															} else {
																																echo "--------------------";
																															} ?><?php if ($_POST["BeneficiarioAX"] == true) {
																																	echo lang("Beneficiario") . ": " . $_POST["BeneficiarioAX2"];
																																} ?> <?php if ($_POST["AlmacenAX"] == true) {
																																			echo " " . lang("Almacen") . ":" . $_POST["AlmacenAX2"];
																																		} ?> </div>
				<div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php echo lang("Fecha") . ": " . $_POST["FECHAX"] . " " . lang("hasta") . "  " . $_POST["FECHAX2"]; ?></div>
			</div>
			<div style="float:left; width: 23%;">
				<div class="FechaI"><span id="fectx"><?php echo $_POST["fectx5"]; ?></span></div><br>
				<div class="FechaI">
					<div class="page"></div>
				</div><br>
				<div class="FechaI"><img style="width: 30%;" src="img/AZUL.svg" /></div><br><br>
				<div class="FechaI">https://PosUp.cl Email: info@posup.cl</div>
			</div>
		</div>
		<div class="encabezado">
			<div class="campo" style=" text-align: left; width: 16%; background-color: gray;"><?php echo lang("Código"); ?></div>
			<div class="campo" style=" text-align: left; width: 24%; background-color: gray;"><?php echo lang("Descripción"); ?></div>
			<div class="campo" style=" text-align: right; width: 6%; background-color: gray;"><?php echo lang("Unidades"); ?></div>
			<div class="campo" style=" text-align: right; width: 9%; background-color: gray;"><?php echo lang("Montos Ventas"); ?></div>
			<div class="campo" style=" text-align: right; width: 9%; background-color: gray;"><?php echo lang("Monto Utilidad"); ?> </div>
		</div>
		<?php
		$fechaA = $_POST["FECHAX"];
		$fechaB = $_POST["FECHAX2"];
		if (!empty($_POST["mIdProevedor"])) {
			$having = "having";
			$Proevedor = "and b.idBen in ('" . implode("','", $_POST["mIdProevedor"]) . "')";
		}

		if (!empty($_POST["mIdAlmacen"])) {
			$having = "having";
			$Deposito = " and c.IdAlm in ('" . implode("','", $_POST["mIdAlmacen"]) . "')";
		}

		if ($_POST["OrdenAX222"] == "Ventas") {
			$Orden = "order by Monto desc";
		}
		if ($_POST["OrdenAX222"] == "Cantidad") {
			$Orden = "order by Cantidad desc";
		}
		if ($_POST["OrdenAX222"] == "Utilidad") {
			$Orden = "order by util desc";
		}

		// if ($_POST["DesdeAX"] == true and $_POST["HastaAX"] == true) {
		// 	$beetween = "and a.CodBarra between '" . $_POST["DesdeAX"] . "' and '" . $_POST["HastaAX"] . "' ";
		// }
		// if ($_POST["DesdeAX"] == true and $_POST["HastaAX"] == false) {
		// 	$beetween = "and a.CodBarra between '" . $_POST["DesdeAX"] . "' and '" . $_POST["DesdeAX"] . "' ";
		// }
		// if ($_POST["DesdeAX"] == false and $_POST["HastaAX"] == true) {
		// 	$beetween = "and a.CodBarra between '" . $_POST["HastaAX"] . "' and '" . $_POST["CodigoHasta"] . "' ";
		// }

		$beetween = "";
		if (!empty($_POST["mIdProductos"])) {
			$beetween .= " and a.CodIdBasico in ('" . implode("','", $_POST["mIdProductos"]) . "') ";
		}

		if (!empty($_POST["mIdMarca"])) {
			$beetween .= " and a.Marca in ('" . implode("','", $_POST["mIdMarca"]) . "') ";
		}

		if (!empty($_POST["mIdfamilia"])) {
			$beetween .= " and a.Idfamilia in ('" . implode("','", $_POST["mIdfamilia"]) . "') ";
		}


		if (trim($_POST["cant"]) <> '') {
			$cantli = " limit " . $_POST["cant"];
			$limit = "limit " . $_POST["cant"];
		}

		$fechaA = $_POST["FECHAX"];
		$fechaB = $_POST["FECHAX2"];
		$costo = "round(round(sum(c.Costo*c.Cant*d.caja),2),2) as Costo,";
		$margen = "round(round(sum(c.Margen*c.Cant*d.caja),2),2) as Margen,";
		if ($_POST['sucursal'] == '0') {

			$query = "SELECT DISTINCT a.CodBarra,a.CodIdAmpliado,a.Descripcion,
			abs(sum(c.Cant*d.inventario)) as Cantidad,
			round(sum(c.Total*d.caja),2) as Monto,
			round(sum(c.Costo*d.caja),2) as Costo,
			round(sum(c.Margen*d.caja),2) as margen,
			round(sum(c.Total*d.caja),2)-round(sum(c.Costo*d.caja),2) as util
            FROM PosUpProducto a 
            inner join PosUpTxC b on a.IdCompany = b.IdCompany 
            inner join PosUpTxD c on a.CodIdBasico=c.CodIdBasico AND a.IdCompany=c.IdCompany and b.Idtx=c.Idtx and b.Idtipotx=c.Idtipotx and b.IdEstacion = c.IdEstacion 
            inner join PosUpTx d on b.Idtipotx = d.Idtipotx and d.Inventario <> 0 and d.Idtipotx in (1,2,15,23) 
            left join PosUpclientes e on a.IdCompany = e.IdCompany and b.IdBen = e.RUT 
            inner join PosUpAlmacen f on c.IdCompany = f.IdCompany and c.IdAlm = f.IdAlm 
            where a.IdCompany " . $companygrp . " and b.Fectxclient BETWEEN '" .  $fechaA . " 00:00:00' and '" . $fechaB . " 23:59:59' 
            and a.EsCompuesto=0  and d.caja<>0
            " . $beetween . "
            " . $Proevedor . "
            " . $Deposito . "
            group by a.CodIdBasico
            " . $Orden . "
            " . $limit . "                                         
            ";
		} else {


			$query = "SELECT DISTINCT a.CodBarra,a.CodIdAmpliado,a.Descripcion,
			abs(sum(c.Cant*d.inventario)) as Cantidad,
			round(sum(c.Total*d.caja),2) as Monto,
			round(sum(c.Costo*d.caja),2) as Costo,
			round(sum(c.Margen*d.caja),2) as margen,
			round(sum(c.Total*d.caja),2)-round(sum(c.Costo*d.caja),2) as util
            FROM PosUpProducto a 
            inner join PosUpTxC b on a.IdCompany = b.IdCompany 
            inner join PosUpTxD c on a.CodIdBasico=c.CodIdBasico AND a.IdCompany=c.IdCompany and b.Idtx=c.Idtx and b.Idtipotx=c.Idtipotx and b.IdEstacion = c.IdEstacion 
            inner join PosUpTx d on b.Idtipotx = d.Idtipotx and d.Inventario <> 0 and d.Idtipotx in (1,2,15,23) 
            left join PosUpclientes e on a.IdCompany = e.IdCompany and b.IdBen = e.RUT 
            inner join PosUpAlmacen f on c.IdCompany = f.IdCompany and c.IdAlm = f.IdAlm 
            inner join PosUpUbicacion z on f.IdCompany=z.IdCompany and f.IdUbi=z.IdUbi
            where a.IdCompany " . $companygrp . "  and z.IdUbi=" . $_POST['sucursal'] . " and b.Fectxclient BETWEEN '" .  $fechaA . " 00:00:00' and '" . $fechaB . " 23:59:59' 
            and a.EsCompuesto=0  and d.caja<>0
            " . $beetween . "
            " . $Proevedor . "
            " . $Deposito . "
            group by a.CodIdBasico
            " . $Orden . "
            " . $limit . "                                         
            ";
		}
		// echo $query;





		//BUCLE 1      


		if ($result = mysqli_query($conn, $query)) {
			$n = 0;
			/* obtener array asociativo */
			while ($row = mysqli_fetch_assoc($result)) {
				$n = $n + 1; ?>
				<div style="text-align: left; float:left; width: 100%;">
					<div style="text-align: left; float:left; width: 100%;">

						<div class="campo" style=" text-align: left; width: 16%; "><?php if ($row['CodIdAmpliado'] == "") {
																						echo "-";
																					} else {
																						echo $row['CodIdAmpliado'];
																					} ?></div>


						<div class="campo" style=" text-align: left; width: 24%; "><?php if ($row['Descripcion'] == "") {
																						echo "-";
																					} else {
																						echo $row['Descripcion'];
																					} ?> </div>
						<div class="campo" style=" text-align: right; width: 6%; "><?php if ($row['Cantidad'] == "") {
																						echo "-";
																					} else {
																						echo number_format($row['Cantidad'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
																					} ?></div>
						<div class="campo" style=" text-align: right; width: 9%; "><?php if ($row['Monto'] == "") {
																						echo "-";
																					} else {
																						echo number_format($row['Monto'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
																					} ?></div>
						<div class="campo" style=" text-align: right; width: 9%; "><?php if ($row['util'] == "") {
																						echo "-";
																					} else {
																						echo number_format($row['util'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
																					} ?></div>

					</div>
					<?php if ($n == 50) {   ?>
						<div class="encabezado" style="visibility:hidden;  font-size: 2px;">
							<hr>
						</div>
						<div class="campo" style="visibility:hidden;  text-align: left; width: 18%; background-color: white;">Total Productos</div>
						<div class="campo" style="visibility:hidden; text-align: left; width: 16%; background-color: gray;">Codigo</div>
						<div class="campo" style="visibility:hidden; text-align: left; width: 6%; background-color: gray;">Nº</div>
						<div class="campo" style=" text-align: right; width: 6%; ">____________</div>
						<div class="campo" style=" text-align: right; width: 9%; ">__________________</div>
						<div class="campo" style=" text-align: right; width: 9%; ">__________________</div>
						<div class="encabezado" style="visibility:hidden; font-size: 2px;">
							<hr>
						</div>
						<div class="campo" style=" text-align: left; width: 18%; background-color: white;"><?php echo lang("Total Productos"); ?></div>
						<div class="campo" style="visibility:hidden; text-align: left; width: 16%; background-color: gray;">Codigo</div>
						<div class="campo" style="visibility:hidden; text-align: left; width: 6%; background-color: gray;">Nº</div>

						<div class="campo" style=" text-align: right; width: 6%; "><?php echo number_format($totaluni, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></div>

						<div class="campo" style=" text-align: right; width: 9%; "><?php echo number_format($totalMonto, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></div>

						<div class="campo" style=" text-align: right; width: 9%; "><?php echo number_format($totalutil, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></div>

						<div style="PAGE-BREAK-AFTER: always"></div>
						<div class="sup">
							<div style="float:left; width: 23%;">
								<div class="TituloEmpresa" id="Titulo"><?php echo $_POST["NameCompany"]; ?></div>
								<div class="Subtituloempresa" id="Ubicacion"><?php echo $_POST["direccion"]; ?></div>
								<div class="Subtituloempresa" id="Literal Fiscal"><?php echo $_POST["litfiscal"]; ?>-<?php echo $_POST["rute"]; ?></div>
							</div>

							<div style="float:left; width: 53%;">
								<div class="TituloEmpresa" style="float: center; text-align: center;"><?php echo lang("Análisis de Productos"); ?></div>
								<div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php echo lang("Orden por"); ?>:<?php echo $_POST["OrdenAX222"]; ?> <?php if ($_POST["DesdeAX"] == true) {
																																																						echo " " . lang("Desde el codigo") . ":" . $_POST["DesdeAX"];
																																																					} ?> <?php if ($_POST["HastaAX"] == true) {
																																																								echo lang("al") . " " . $_POST["HastaAX"];
																																																							} ?></div>
								<div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php if ($_POST["BeneficiarioAX"] == true or $_POST["AlmacenAX"] == true) {
																																				echo "Con:";
																																			} else {
																																				echo "--------------------";
																																			} ?><?php if ($_POST["BeneficiarioAX"] == true) {
																																					echo lang("Beneficiario") . ": " . $_POST["BeneficiarioAX2"];
																																				} ?> <?php if ($_POST["AlmacenAX"] == true) {
																																							echo " " . lang("Almacen") . ":" . $_POST["AlmacenAX2"];
																																						} ?> </div>
								<div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php echo lang("Fecha") . ": " . $_POST["FECHAX"] . " " . lang("hasta") . "  " . $_POST["FECHAX2"]; ?></div>
							</div>

							<div style="float:left; width: 23%;">
								<div class="FechaI"><span id="fectx"><?php echo $_POST["fectx5"]; ?></span></div><br>
								<div class="FechaI">
									<div class="page"></div>
								</div><br>
								<div class="FechaI"><img style="width: 30%;" src="img/AZUL.svg" /></div><br><br>
								<div class="FechaI">https://PosUp.cl Email: info@posup.cl</div>
							</div>
						</div>


						<div class="encabezado">

							<div class="campo" style=" text-align: left; width: 16%; background-color: gray;"><?php echo lang("Código"); ?></div>
							<div class="campo" style=" text-align: left; width: 24%; background-color: gray;"><?php echo lang("Descripción"); ?></div>

							<div class="campo" style=" text-align: right; width: 6%; background-color: gray;"><?php echo lang("Unidades"); ?></div>

							<div class="campo" style=" text-align: right; width: 9%; background-color: gray;"><?php echo lang("Montos Ventas"); ?></div>

							<div class="campo" style=" text-align: right; width: 9%; background-color: gray;"><?php echo lang("Monto Utilida"); ?>d </div>
							<div class="campo" style=" text-align: right; width: 12%; background-color: gray;">.</div>

						</div>
			<?php
						$CostoExistencia = 0;
						$unidadTotal = 0;
						$ExistenciaTotal = 0;
						$n = 0;
					}
					$totaluni = $totaluni + $row["Cantidad"]; //c
					$totalMonto = $totalMonto + $row["Monto"];
					$totalutil = $totalutil + $row["util"];
				}
				mysqli_free_result($result);
			} ?>
			<div class="encabezado" style="visibility:hidden;  font-size: 2px;">
				<hr>
			</div>
			<div class="campo" style="visibility:hidden;  text-align: left; width: 18%; background-color: white;">Total Productos</div>
			<div class="campo" style="visibility:hidden; text-align: left; width: 16%; background-color: gray;">Codigo</div>
			<div class="campo" style="visibility:hidden; text-align: left; width: 6%; background-color: gray;">Nº</div>

			<div class="campo" style=" text-align: right; width: 6%; ">____________</div>

			<div class="campo" style=" text-align: right; width: 9%; ">__________________</div>

			<div class="campo" style=" text-align: right; width: 9%; ">__________________</div>
			<div class="encabezado" style="visibility:hidden; font-size: 2px;">
				<hr>
			</div>
			<div class="campo" style=" text-align: left; width: 18%; background-color: white;"><?php echo lang("Total Productos"); ?></div>
			<!--   ordenado      <div class="campo" style="  text-align: right; width:  4%; background-color: white;"></div>-->
			<!--   Totales   -->
			<div class="campo" style="visibility:hidden; text-align: left; width: 16%; background-color: gray;">Codigo</div>
			<div class="campo" style="visibility:hidden; text-align: left; width: 6%; background-color: gray;">Nº</div>

			<div class="campo" style=" text-align: right; width: 6%; "><?php echo number_format($totaluni, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></div>

			<div class="campo" style=" text-align: right; width: 9%; "><?php echo number_format($totalMonto, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></div>

			<div class="campo" style=" text-align: right; width: 9%; "><?php echo number_format($totalutil, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></div>

				</div>
				<div style="PAGE-BREAK-AFTER: always; visibility: hidden;">a</div>

				<form id="formexceel" action="excelv3led.php" method="post">
					<?php
					$compa = $_POST["CompanyActual"];
					$name = lang("AnálisisProducto") . ".csv";
					?>

					<input type="hidden" name="registro" id="registro" value="<?php echo $pro2; ?>" />
					<input type="hidden" name="Qry" id="Qry" value="<?php echo $query; ?>" />
					<input type="hidden" name="Name" id="Name" value="<?php echo $name; ?>" />
					<input type="hidden" name="Company" id="Company" value="<?php echo $compa; ?>" />
					<input type="hidden" name="ser" id="ser" value="" />
				</form>

				<form id="formexcel" action="excelnew.php" method="post">
					<?php
					$compa = $_POST["CompanyActual"];
					$name = lang("AnálisisProducto");
					?>
					<input type="hidden" name="Query" id="Query" value="<?php echo $query; ?>" />
					<input type="hidden" name="Name" id="Name" value="<?php echo $name; ?>" />
					<input type="hidden" name="SimDec" id="SimDec" value="<?php echo $_POST['SimDec']; ?>" />
					<input type="hidden" name="SimMil" id="SimMil" value="<?php echo $_POST['SimMil']; ?>" />
					<input type="hidden" name="CD" id="CD" value="<?php echo $_POST['CD']; ?>" />
					<input type="hidden" name="CompanyActual" id="CompanyActual" value="<?php echo $_POST['CompanyActual']; ?>" />
					<input type="hidden" name="vas" id="vas" value="AnalisisProd" />
				</form>

</body>
<script>
	const totalPages = document.querySelectorAll('.page').length;
	document.documentElement.style.setProperty('--total-pages', totalPages);
</script>

</html>