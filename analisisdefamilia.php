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
	<title><?php echo lang("Análisis de Familia"); ?></title>
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
	<button class='ocultoimpresion ' onclick='document.getElementById(`formexcel`).submit()'><img src='/img/excel.png' width='28' height='28'><br>InvetarioF<br></button>
	<div class="pagina" style="font-size: 12px;">
		<div class="sup">
			<div style="float:left; width: 23%;">
				<div class="TituloEmpresa" id="Titulo"><?php echo $_POST["NameCompany"]; ?></div>
				<div class="Subtituloempresa" id="Ubicacion"><?php echo $_POST["direccion"]; ?></div>
				<div class="Subtituloempresa" id="Literal Fiscal"><?php echo $_POST["litfiscal"]; ?>-<?php echo $_POST["rute"]; ?></div>
			</div>
			<div style="float:left; width: 53%;">
				<div class="TituloEmpresa" style="float: center; text-align: center;"><?php echo lang("Análisis de Familia"); ?></div>
				<div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php echo lang("Orden por"); ?>:<?php echo $_POST["OrdenA222"]; ?></div>
				<div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php if ($_POST["DesdeAX2z2Y"] == true) {
																																echo "Familia:" . $_POST["DesdeAX22z22Y"];
																															} ?> <?php if ($_POST["HastaAX2z2Y"] == true) {
																																		echo lang("Familia") . ": " . $_POST["HastaAX22z2Y"];
																																	} ?></div>
				<div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php if ($_POST["BeneficiarioAX2z2"] == true or $_POST["AlmacenAX2z2"] == true) {
																																echo lang("Con") . ":";
																															} else {
																																echo "--------------------";
																															} ?><?php if ($_POST["BeneficiarioAX2z2"] == true) {
																																	echo lang("Beneficiario") . ": " . $_POST["BeneficiarioAX22z2"];
																																} ?> <?php if ($_POST["AlmacenAX2z2"] == true) {
																																			echo "  " . lang("Almacén") . ":" . $_POST["AlmacenAX22z2"];
																																		} ?> </div>
				<div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php echo lang("Fecha") . ":" . $_POST["FECHAX2z2nj"] . " " . lang("hasta") . "  " . $_POST["FECHAX22z2njz"]; ?></div>
			</div>
			<div style="float:left; width: 23%;">
				<div class="FechaI"><span id="fectx"><?php echo $_POST["fectx5"]; ?></span></div><br>
				<div class="FechaI">
					<div class="page"></div>
				</div><br>
				<div class="FechaI"><img style="width: 30%;" src="img/AZUL.svg" /></div><br><br>
				<div class="FechaI">-</div>
			</div>
		</div>
		<div class="encabezado">
			<div class="campo" style=" text-align: left; width: 30%; background-color: gray;"><?php echo lang("Descripción"); ?></div>

			<div class="campo" style=" text-align: right; width: 10%; background-color: gray;"><?php echo lang("Unidades"); ?></div>

			<div class="campo" style=" text-align: right; width: 10%; background-color: gray;"><?php echo lang("Montos Ventas"); ?></div>

			<div class="campo" style=" text-align: right; width: 10%; background-color: gray;"><?php echo lang("Monto Utilidad"); ?> </div>




			<?php
			//echo $_POST["CompanyActual"];
			// $query = "SELECT a.IdAlm as IdAlm, a.Nombre as Nombre, a.Tipo as Tipo, a.IdUbi as IdUbi, b.Nombre as Ubicacion FROM PosUpAlmacen a INNER JOIN PosUpUbicacion b on a.IdUbi = b.IdUbi and a.idCompany= b.idCompany where a.IdCompany=".$_POST["CompanyActual"]."".$search;
			//  $query = "SELECT IdAlm,Nombre as PosUpAlmacen,sum(coalesce(a.Cant)*coalesce(d.Inventario)) as Cantidad FROM PosUpTxD a inner join PosUpProducto b on a.IdCompany=b.IdCompany and a.CodIdBasico=b.CodIdBasico inner join PosUpAlmacen c on a.IdCompany=c.IdCompany and a.IdAlm=c.IdAlm inner join PosUpTx d on a.Idtipotx=d.Idtipotx where a.IdCompany=".$_POST["Company"];                         //echo $query;
			//$query = "SELECT c.idalm,c.nombre as Almacen,sum(coalesce(a.Cant)*coalesce(d.Inventario)) as Cantidad, b.bodega,e.nombre as Proevedor,b.Marca FROM PosUpTxD a inner join PosUpProducto b on a.IdCompany=b.IdCompany and a.CodIdBasico=b.CodIdBasico inner join PosUpAlmacen c on a.IdCompany=c.IdCompany and a.IdAlm=c.IdAlm inner join PosUpTx d on a.Idtipotx=d.Idtipotx inner join PosUpproveedor e on a.IdCompany=e.IdCompany where a.IdCompany=133;";
			// $query = "SELECT  c.idalm,c.nombre as Almacen,a.Descripción as Descripción, b.bodega,e.nombre,b.Marca,a.Seriales,b.PrecioVenta as PrecioActual,b.Exis as Existencia,a.Referencia,b.CodIdBasico as Codigo  FROM PosUpTxD a inner join PosUpProducto b on a.IdCompany=b.IdCompany and a.CodIdBasico=b.CodIdBasico inner join PosUpAlmacen c on a.IdCompany=c.IdCompany and a.IdAlm=c.IdAlm inner join PosUpTx d on a.Idtipotx=d.Idtipotx inner join PosUpproveedor e on a.IdCompany=e.IdCompany where a.IdCompany=133 limit 10;";
			//--------------------------------------------------------------------------------------------------------------------------------
			/*       if ($_POST["Instancia"]=="on"){
                                         $likeIF="like";  
                                       $Instancia= $likeIF . $_POST["Instancia"];      }        // Buscador
*/
			//--------------------------------------------------------------------------------------------------------------------------------
			$fechaA = $_POST["FECHAX22z2"];

			$fechaB = $_POST["FECHAX22z2"];

			//---------------------------------------------------------------------------------------------------------------------------
			//---------------------------------------------------------------------------------------------------------------------------
			// if ($_POST["BeneficiarioAX2z2"] == true) {
			// 	$having = "having";
			// 	$Proevedor = "and b.idBen= '" . $_POST["BeneficiarioAX2z2"] . "'";
			// }

			if (!empty($_POST["mIdProevedor"])) {
				$having = "having";
				$Proevedor = "and b.idBen in ('" . implode("','", $_POST["mIdProevedor"]) . "')";
			}


			//---------------------------------------------------------------------------------------------------------------------------
			// if ($_POST["AlmacenAX2z2"] == true) {
			// 	$Deposito = "and c.IdAlm=" .  $_POST["AlmacenAX2z2"];
			// }   

			if (!empty($_POST["mIdAlmacen"])) {
				$Deposito = " and c.IdAlm in ('" . implode("','", $_POST["mIdAlmacen"]) . "')";
			}
			// Buscador
			//---------------------------------------------------------------------------------------------------------------------------

			if (trim($_POST["OrdenA222"]) == "Ventas") {
				$Orden = "order by Monto desc";
			}
			if (trim($_POST["OrdenA222"]) == "Cantidad") {
				$Orden = "order by Cantidad desc";
			}
			if (trim($_POST["OrdenA222"]) == "Utilidad") {
				$Orden = "order by util desc";
			}
			//---------------------------------------------------------------------------------------------------------------------------
			//---------------------------------------------------------------------------------------------------------------------------
			// if ($_POST["DesdeAX2z2Y"] == true and $_POST["HastaAX2z2Y"] == true) {
			// 	$beetween = "and g.Idvarios  between '" . $_POST["DesdeAX2z2Y"] . "' and '" . $_POST["HastaAX2z2Y"] . "' ";
			// }
			// if ($_POST["DesdeAX2z2Y"] == true and $_POST["HastaAX2z2Y"] == false) {
			// 	$beetween = "and g.Idvarios between '" . $_POST["DesdeAX2z2Y"] . "' and '" . $_POST["DesdeAX2z2Y"] . "' ";
			// }
			// if ($_POST["DesdeAX2z2Y"] == false and $_POST["HastaAX2z2Y"] == true) {
			// 	$beetween = "and g.Idvarios between '" . $_POST["HastaAX2z2Y"] . "' and '" . $_POST["HastaAX2z2Y"] . "' ";
			// }


			if (!empty($_POST["mIdfamilia"])) {
				$beetween = " and g.Idvarios in ('" . implode("','", $_POST["mIdfamilia"]) . "') ";
			}
			//---------------------------------------------------------------------------------------------------------------------------
			//---------------------------------------------------------------------------------------------------------------------------
			$limit = " limit " . $_POST["cant2232"];
			$fechaA = $_POST["FECHAX2z2nj"];

			$fechaB = $_POST["FECHAX22z2njz"];
			//---------------------------------------------------------------------------------------------------------------------------
			//---------------------------------------------------------------------------------------------------------------------------
			if ($_POST['sucursal'] == '0') {
				$query = "SELECT DISTINCT g.ITEM as Familia,g.IdVarios as IdFamilia,
				abs(sum(c.Cant*d.inventario)) as Cantidad,
				round(sum(c.Total*d.caja),2) as Monto,
				round(sum(c.Costo*d.caja),2) as Costo,
				round(sum(c.Margen*d.caja),2) as margen,
				round(sum(c.Total*d.caja),2)-round(sum(c.Costo*d.caja),2) as util
				FROM PosUpProducto a 
				inner join PosUpTxC b on a.IdCompany = b.IdCompany 
				inner join PosUpTxD c on a.CodIdBasico=c.CodIdBasico AND a.IdCompany=c.IdCompany and b.Idtx=c.Idtx and b.Idtipotx=c.Idtipotx and b.IdEstacion = c.IdEstacion 
				inner join PosUpTx d on b.Idtipotx = d.Idtipotx and d.Inventario <> 0 and d.Idtipotx in (1,2,15,23) left join PosUpclientes e on a.IdCompany = e.IdCompany and b.IdBen = e.RUT 
				inner join PosUpAlmacen f on c.IdCompany = f.IdCompany and c.IdAlm = f.IdAlm 
				inner join PosUpvarios g on g.IdCompany = a.IdCompany and a.Idfamilia = g.IdVarios and g.TIPOITEM =2
				where a.IdCompany " . $companygrp . " and b.Fectxclient BETWEEN '" . $fechaA . " 00:00:00' and '" . $fechaB . " 23:59:59' 
				and d.caja<>0
				" . $beetween . "
				" . $Proevedor . "
				" . $Deposito . "
				group by a.Idfamilia 
				" . $Orden . "
				" . $limit . "                                         
				";
			} else {
				$query = "SELECT DISTINCT g.ITEM as Familia,g.IdVarios as IdFamilia,
				abs(sum(c.Cant*d.inventario)) as Cantidad,
				round(sum(c.Total*d.caja),2) as Monto,
				round(sum(c.Costo*d.caja),2) as Costo,
				round(sum(c.Margen*d.caja),2) as margen,
				round(sum(c.Total*d.caja),2)-round(sum(c.Costo*d.caja),2) as util
				FROM PosUpProducto a 
				inner join PosUpTxC b on a.IdCompany = b.IdCompany 
				inner join PosUpTxD c on a.CodIdBasico=c.CodIdBasico AND a.IdCompany=c.IdCompany and b.Idtx=c.Idtx and b.Idtipotx=c.Idtipotx and b.IdEstacion = c.IdEstacion 
				inner join PosUpTx d on b.Idtipotx = d.Idtipotx and d.Inventario <> 0 and d.Idtipotx in (1,2,15,23) left join PosUpclientes e on a.IdCompany = e.IdCompany and b.IdBen = e.RUT 
				inner join PosUpAlmacen f on c.IdCompany = f.IdCompany and c.IdAlm = f.IdAlm 
				inner join PosUpUbicacion z on f.IdCompany=z.IdCompany and f.IdUbi=z.IdUbi
				inner join PosUpvarios g on g.IdCompany = a.IdCompany and a.Idfamilia = g.IdVarios and g.TIPOITEM =2
				where  z.IdUbi=" . $_POST['sucursal'] . " and a.IdCompany " . $companygrp . " and b.Fectxclient BETWEEN '" . $fechaA . " 00:00:00' and '" . $fechaB . " 23:59:59' 
				and d.caja<>0
				" . $beetween . "
				" . $Proevedor . "
				" . $Deposito . "
				group by a.Idfamilia 
				" . $Orden . "
				" . $limit . "                                         
				";
			}


			//BUCLE 1      

			if ($result = mysqli_query($conn, $query)) {
				$n = 0;
				/* obtener array asociativo */
				while ($row = mysqli_fetch_assoc($result)) {
					$n = $n + 1;  ?>
					<div style="text-align: left; float:left; width: 100%;">
						<div style="text-align: left; float:left; width: 100%;">
							<div class="campo" style=" text-align: left; width: 30%; "><?php if ($row['Familia'] == "") {
																							echo "-";
																						} else {
																							echo $row['Familia'];
																						} ?> </div>
							<div class="campo" style=" text-align: right; width: 10%; "><?php if ($row['Cantidad'] == "") {
																							echo "-";
																						} else {
																							echo number_format($row['Cantidad'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
																						} ?></div>
							<div class="campo" style=" text-align: right; width: 10%; "><?php if ($row['Monto'] == "") {
																							echo "-";
																						} else {
																							echo number_format($row['Monto'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
																						} ?></div>
							<div class="campo" style=" text-align: right; width: 10%; "><?php if ($row['util'] == "") {
																							echo "-";
																						} else {
																							echo number_format($row['util'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
																						} ?></div>
						</div>
						<?php

						if ($n == 50) {
						?>
							<div class="encabezado" style="visibility:hidden;  font-size: 2px;">
								<hr>
							</div>
							<div class="campo" style="visibility:hidden;  text-align: left; width: 30%; background-color: white;"><?php echo lang("Total Familias"); ?></div>

							<div class="campo" style=" text-align: right; width: 10%; ">____________</div>

							<div class="campo" style=" text-align: right; width: 10%; ">__________________</div>

							<div class="campo" style=" text-align: right; width: 10%; ">__________________</div>
							<div class="encabezado" style="visibility:hidden; font-size: 2px;">
								<hr>
							</div>
							<div class="campo" style=" text-align: left; width: 30%; background-color: white;"><?php echo lang("Total Familias"); ?></div>
							<!--   ordenado      <div class="campo" style="  text-align: right; width:  4%; background-color: white;"></div>-->
							<!--   Totales   -->

							<div class="campo" style=" text-align: right; width: 10%; "><?php echo number_format($totaluni, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></div>

							<div class="campo" style=" text-align: right; width: 10%; "><?php echo number_format($totalMonto, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></div>

							<div class="campo" style=" text-align: right; width: 10%; "><?php echo number_format($totalutil, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></div>

							<div style="PAGE-BREAK-AFTER: always"></div>
							<div class="sup">
								<div class="sup">
									<div style="float:left; width: 23%;">
										<div class="TituloEmpresa" id="Titulo"><?php echo $_POST["NameCompany"]; ?></div>
										<div class="Subtituloempresa" id="Ubicacion"><?php echo $_POST["direccion"]; ?></div>
										<div class="Subtituloempresa" id="Literal Fiscal"><?php echo $_POST["litfiscal"]; ?>-<?php echo $_POST["rute"]; ?></div>
									</div>
									<div style="float:left; width: 53%;">
										<div class="TituloEmpresa" style="float: center; text-align: center;"><?php echo lang("Análisis de Familia"); ?></div>
										<div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php echo lang("Orden por"); ?>:<?php echo $_POST["OrdenA222"]; ?></div>
										<div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php if ($_POST["DesdeAX2z2Y"] == true) {
																																						echo "Familia:" . $_POST["DesdeAX22z22Y"];
																																					} ?> <?php if ($_POST["HastaAX2z2Y"] == true) {
																																								echo lang("Familia") . ": " . $_POST["HastaAX22z2Y"];
																																							} ?></div>
										<div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php if ($_POST["BeneficiarioAX2z2"] == true or $_POST["AlmacenAX2z2"] == true) {
																																						echo lang("Con") . ":";
																																					} else {
																																						echo "--------------------";
																																					} ?><?php if ($_POST["BeneficiarioAX2z2"] == true) {
																																							echo lang("Beneficiario") . ": " . $_POST["BeneficiarioAX22z2"];
																																						} ?> <?php if ($_POST["AlmacenAX2z2"] == true) {
																																									echo "  " . lang("Almacén") . ":" . $_POST["AlmacenAX22z2"];
																																								} ?> </div>
										<div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php echo lang("Fecha") . ":" . $_POST["FECHAX2z2nj"] . " " . lang("hasta") . "  " . $_POST["FECHAX22z2njz"]; ?></div>
									</div>
									<div style="float:left; width: 23%;">
										<div class="FechaI"><span id="fectx"><?php echo $_POST["fectx5"]; ?></span></div><br>
										<div class="FechaI">
											<div class="page"></div>
										</div><br>
										<div class="FechaI"><img style="width: 30%;" src="img/AZUL.svg" /></div><br><br>
										<div class="FechaI">-</div>
									</div>
								</div>

								<div class="encabezado">
									<div class="campo" style=" text-align: left; width: 30%; background-color: gray;"><?php echo lang("Descripción"); ?></div>
									<div class="campo" style=" text-align: right; width: 10%; background-color: gray;"><?php echo lang("Unidades"); ?></div>
									<div class="campo" style=" text-align: right; width: 10%; background-color: gray;"><?php echo lang("Montos Ventas"); ?></div>
									<div class="campo" style=" text-align: right; width: 10%; background-color: gray;"><?php echo lang("Monto Utilidad"); ?> </div>
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
				}


					?>
					<div class="encabezado" style="visibility:hidden;  font-size: 2px;">
						<hr>
					</div>
					<div class="campo" style="visibility:hidden;  text-align: left; width: 30%; background-color: white;"><?php echo lang("Total Familias"); ?></div>
					<div class="campo" style=" text-align: right; width: 10%; ">____________</div>
					<div class="campo" style=" text-align: right; width: 10%; ">__________________</div>
					<div class="campo" style=" text-align: right; width: 10%; ">__________________</div>
					<div class="encabezado" style="visibility:hidden; font-size: 2px;">
						<hr>
					</div>
					<div class="campo" style=" text-align: left; width: 30%; background-color: white;"><?php echo lang("Total Familias"); ?></div>
					<div class="campo" style=" text-align: right; width: 10%; "><?php echo number_format($totaluni, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></div>
					<div class="campo" style=" text-align: right; width: 10%; "><?php echo number_format($totalMonto, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></div>
					<div class="campo" style=" text-align: right; width: 10%; "><?php echo number_format($totalutil, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?></div>
							</div>
					</div>
					<div style="PAGE-BREAK-AFTER: always; visibility: hidden;">a</div>
					<form id="formexcel" action="excelnew.php" method="post">
						<?php
						$compa = $_POST["CompanyActual"];
						$name = lang("AnálisisFamilia");
						?>
						<input type="hidden" name="Query" id="Query" value="<?php echo $query; ?>" />
						<input type="hidden" name="Name" id="Name" value="<?php echo $name; ?>" />
						<input type="hidden" name="SimDec" id="SimDec" value="<?php echo $_POST['SimDec']; ?>" />
						<input type="hidden" name="SimMil" id="SimMil" value="<?php echo $_POST['SimMil']; ?>" />
						<input type="hidden" name="CD" id="CD" value="<?php echo $_POST['CD']; ?>" />
						<input type="hidden" name="CompanyActual" id="CompanyActual" value="<?php echo $_POST['CompanyActual']; ?>" />
						<input type="hidden" name="vas" id="vas" value="AnalisisFamil" />
					</form>
					<form id="formexceel" action="excelv3led.php" method="post">
						<?php
						$compa = $_POST["CompanyActual"];
						$name = lang("AnálisisFamilia") . ".csv";
						?>
						<input type="hidden" name="registro" id="registro" value="<?php echo $pro2; ?>" />
						<input type="hidden" name="Qry" id="Qry" value="<?php echo $query; ?>" />
						<input type="hidden" name="Name" id="Name" value="<?php echo $name; ?>" />
						<input type="hidden" name="Company" id="Company" value="<?php echo $compa; ?>" />
						<input type="hidden" name="ser" id="ser" value="" />
					</form>
</body>
<script>
	const totalPages = document.querySelectorAll('.page').length;
	document.documentElement.style.setProperty('--total-pages', totalPages);
</script>

</html>