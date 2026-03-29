<?php

include "ambiente.php";
$conn = ConectarConsultas();
session_start();

$fechaDES = $_POST["DesdeFechaG"];
$fechaHAS = $_POST["FechaHastaG"];

if ($_SESSION['IdiomaActual'] == '') {
	$_SESSION['IdiomaActual'] = $_POST['IdiomaActual'];
}
$AlmacenCop = "";
if ($_POST["Almacen234G"] === true) {
	$array2 = $_POST["Almacen234G"];
	$AlmacenCop = "Almacen:";
	foreach ($array2 as $array2) {
		$query123 = "Select IdAlm,Nombre from PosUpAlmacen where IdCompany=" . $_POST["CompanyActual"] . " and IdAlm=" . $array2;
		if ($result123 = mysqli_query($conn, $query123)) {
			while ($row123 = mysqli_fetch_assoc($result123)) {
				$AlmacenCop .= " " . $row123["Nombre"];
			}
			mysqli_free_result($result123);
		}
	}
}
$Familias2asdG = "";
if ($_POST["Familias2asdG"] !== "*") {
	$queryAlma2 = " SELECT IdVarios,ITEM FROM PosUpvarios WHERE TIPOITEM=2 and IdCompany=" . $_POST["CompanyActual"] . " and IdVarios=" . $_POST["Familias2asd"] . " ";
	if ($resultqueryAlma2 = mysqli_query($conn, $queryAlma2)) {
		while ($rowqueryAlma2 = mysqli_fetch_assoc($resultqueryAlma2)) {
			$Familias2asdG .= " " . lang("Familia") . ": " . $rowqueryAlma2["ITEM"];
		}
		mysqli_free_result($resultqueryAlma2);
	}
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
	<title><?php echo lang("Movimiento Fiscal"); ?></title>
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

	body {
		counter-reset: page-counter 0 total-pages var(--total-pages);
		font-family: Tahoma, Verdana, Segoe, sans-serif;
		line-height: 1;
		margin: 5mm 5mm 5mm 5mm;
	}

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
</style>

<body>
	<button type='submit' class='ocultoimpresion ' onclick='window.print();'><img src='/img/pdf.png' width='28' height='28'><br>PDF</button>
	<button class='ocultoimpresion ' onclick='document.getElementById(`formexcel`).submit()'><img src='/img/excel.png' width='28' height='28'><br><?php echo lang("Movimiento Fiscal"); ?><br></button>
	<?php if ($_POST["SerialesG"] == "on") { ?>
		<button class='ocultoimpresion ' onclick='document.getElementById(`formexcel2`).submit()'><img src='/img/excel.png' width='28' height='28'><br><?php echo lang("IdAlm S"); ?><br></button>
		<button class='ocultoimpresion ' onclick='document.getElementById(`formexcel3`).submit()'><img src='/img/excel.png' width='28' height='28'><br><?php echo lang("Seriales"); ?><br></button>
	<?php } ?>
	<div class="pagina" style="font-size: 12px;">
		<div class="sup">
			<div style="float:left; width: 23%;">
				<div class="TituloEmpresa" id="Titulo"><?php echo $_POST["NameCompany"]; ?></div>
				<div class="Subtituloempresa" id="Ubicacion"><?php echo $_POST["direccion"]; ?></div>
				<div class="Subtituloempresa" id="Literal Fiscal"><?php echo $_POST["litfiscal"]; ?>-<?php echo $_POST["rute"]; ?></div>
			</div>
			<div style="float:left; width: 53%;">
				<div class="TituloEmpresa" style="float: center; text-align: center;"><?php echo lang("Movimiento Fiscal"); ?></div>
				<div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php echo ($_POST["Almacen234G"] === false ? "--------------------" : $AlmacenCop); ?>
				</div>
				<div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
					<?php echo lang("Orden por"); ?>: <?php echo ($_POST["OrdenRESG"] == "1" ? lang("Codigo") : "") . ($_POST["OrdenRESG"] == "2" ? lang("Descripcion") : "") . ($_POST["OrdenRESG"] == "3" ? lang("Cantidad de Inventario") : "") . ($_POST["OrdenRESG"] == "4" ? lang("Monto de Inventario") : "") . ($_POST["OrdenRESG"] == "5" ? lang("Mayor Utilidad") : "") . ($_POST["OrdenRESG"] == "6" ? lang("Mayor Venta") : "");                       ?>
				</div>
				<div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php echo ($_POST["CodigoDesdeLPRES"] === true ? lang("Desde el Codigo") . ":" . $_POST["CodigoDesdeLPRES"] : "") . " " . ($_POST["CodigoHastaLPRES"] === true ? lang("al") . " " . $_POST["CodigoHastaLPRES"] : ""); ?></div>
				<div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php echo ($_POST["DesdeFechaG"] === true ? $fechaDES . " " . lang("hasta") : "") . " " . ($_POST["FechaHastaG"] === true ? $fechaHAS : ""); ?></div>
				<div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php echo ($_POST["Familias2asd"] === "*" ? "--------------------" : "") . " " . $Familias2asdG; ?> </div>

				<div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php if ($_POST["ProductosInv"] == "on" or $_POST["ProductosMov"] == "on") {
																																echo "" . lang("Incluyendo") . ":";
																															} else {
																																echo "--------------------";
																															} ?> <?php if ($_POST["ProductosInv"] == "on") {
																																		echo "  " . lang("Productos con Inventario") . " ";
																																	}
																																	if ($_POST["ProductosMov"]) {
																																		echo " " . lang("Productos con Movimiento") . "";
																																	} ?> </div>

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
		<div class="encabezado" style=""><strong>
				<div class="campo" style="visibility:hidden; text-align: left; width: 3%; background-color: gray;">Descripcion</div>
				<div class="campo" style="visibility:hidden; text-align: left; width: 32%; background-color: gray;">Descripcion</div>
				<div class="campo" style=" text-align: center; width: 18%; background-color: gray;"><?php echo lang("Existencia Inicial"); ?></div>
				<div class="campo" style=" text-align: center; width: 10%; background-color: gray;"><?php echo lang("Entradas"); ?></div>
				<div class="campo" style=" text-align: center; width: 10%; background-color: gray;"><?php echo lang("Salidas"); ?></div>


				<div class="campo" style=" text-align: center; width: 18%; background-color: gray;"><?php echo lang("Existencia Final"); ?></div>

		</div></strong>
		<div class="encabezado" style="">
			<div class="campo" style="visibility:hidden; text-align: left; width: 2%; background-color: gray;"><?php echo lang("Descripción"); ?></div>
			<div class="campo" style=" text-align: left; width: 8%; background-color: gray;"><?php echo lang("Código"); ?> </div>
			<div class="campo" style=" text-align: left; width: 25%; background-color: gray;"><?php echo lang("Descripción"); ?></div>
			<div class="campo" style=" text-align: right; width: 5%; background-color: gray;"><?php echo lang("Cantidad"); ?></div>
			<div class="campo" style=" text-align: right; width: 6%; background-color: gray;"><?php echo lang("Costo UNIT"); ?></div>
			<div class="campo" style=" text-align: right; width: 6%; background-color: gray;"><?php echo lang("Mto.Total"); ?></div>
			<div class="campo" style=" text-align: right; width: 5%; background-color: gray;"><?php echo lang("Cantidad"); ?> </div>
			<div class="campo" style=" text-align: right; width: 5%; background-color: gray;"><?php echo lang("Monto $"); ?> </div>
			<div class="campo" style=" text-align: right; width: 5%; background-color: gray;"><?php echo lang("Cantidad"); ?> </div>
			<div class="campo" style=" text-align: right; width: 5%; background-color: gray;"><?php echo lang("Monto"); ?> $ </div>
			<div class="campo" style=" text-align: right; width: 5%; background-color: gray;"><?php echo lang("Cantidad"); ?> </div>
			<div class="campo" style=" text-align: right; width: 6%; background-color: gray;"><?php echo lang("Costo Unit"); ?> </div>
			<div class="campo" style=" text-align: right; width: 6%; background-color: gray;"><?php echo lang("Mto.Total"); ?> </div>
		</div>
		<?php
		// if ($_POST["CodigoDesdeLPRESG"] == true and $_POST["CodigoHastaLPRESG"] == true) {
		// 	$beetween = "and a.CodBarra between '" . $_POST["CodigoDesdeLPRESG"] . "' and '" . $_POST["CodigoHastaLPRESG"] . "' ";
		// }
		// if ($_POST["CodigoDesdeLPRESG"] == true and $_POST["CodigoHastaLPRESG"] == false) {
		// 	$beetween = "and a.CodBarra ='" . $_POST["CodigoDesdeLPRESG"] . "' ";
		// }
		// if ($_POST["CodigoDesdeLPRESG"] == false and $_POST["CodigoHastaLPRESG"] == true) {
		// 	$beetween = "and a.CodBarra ='" . $_POST["CodigoHastaLPRESG"] . "' ";
		// }
		if (!empty($_POST["mIdProductos"])) {
			$beetween = " and a.CodIdBasico in ('" . implode("','", $_POST["mIdProductos"]) . "') ";
		}
		if ($_POST["ProductosInvG"] == "on") {  /// producstos con inventario lalsad
			$ConInv = "and round(coalesce(b.cantidad,0),2)+round(coalesce(c.cantidad,0),2)>0";
		}
		if ($_POST["ProductosMovG"] == "on") {
			$ConMov = " AND round(coalesce(c.Ccompras,0),2) <>0 AND round(coalesce(c.Ctraslados,0),2)+coalesce(c.cboletas,0)+coalesce(c.cfacturas,0)+round(coalesce(c.CTomas,0),2)+round(coalesce(c.Cajustes,0),2)+round(coalesce(c.cdevolucion,0),2) <> 0";
		}


		// if ($_POST["Almacen234G"] == true) {
		// 	$array2 = $_POST["Almacen234G"];
		// 	$p11 = "(";
		// 	$p22 = ")";
		// 	$Alma = "and ba.IdAlm in ";
		// 	$nor2 = 0;
		// 	foreach ($array2 as $array2) {
		// 		//echo $array2;

		// 		$query322 = "Select IdAlm,Nombre from PosUpAlmacen where IdCompany=" . $_POST["CompanyActual"] . "
		//     and IdAlm=" . $array2 . "
		//     ";
		// 		if ($result322 = mysqli_query($conn, $query322)) {
		// 			while ($row322 = mysqli_fetch_assoc($result322)) {
		// 				$nor2 = $nor2 + 1;
		// 				if ($nor2 <= 1) {
		// 					$Almacen23 =  $row322["IdAlm"];
		// 				}
		// 				if ($nor2 > 1) {
		// 					$coma = ",";
		// 					$Almacen23 =   $Almacen23 .  $coma . $row322["IdAlm"];
		// 				}
		// 			}
		// 			mysqli_free_result($result322);
		// 		}
		// 	}
		// }


		if (!empty($_POST["mIdAlmacen"])) {
			$Almacen23 = " and ba.IdAlm in ('" . implode("','", $_POST["mIdAlmacen"]) . "')";
		}



		if ($_POST["OrdenRESG"] == TRUE) {
			if ($_POST["OrdenRESG"] == "1") {
				$OrdenBy = " order by a.CodIdBasico";
			}
			if ($_POST["OrdenRESG"] == "2") {
				$OrdenBy = " order by a.Descripcion";
			}
			if ($_POST["OrdenRESG"] == "3") {
				$OrdenBy = " order by coalesce(b.cantidad,0)+coalesce(c.cantidad,0) asc";
			}
		}
		$sucursal = "";
		if ($_POST['sucursal'] !== '0') $sucursal = " and f.IdUbi=" . $_POST['sucursal'];
		$query = "SET SESSION group_concat_max_len = 1000000";
		$result = mysqli_query($conn, $query);
		$query = "SELECT a.CodBarra, a.Descripcion,
			round(coalesce(b.cantidad,0),2) as InventarioInicial,
			round(a.Costo,2) as Costo,
			coalesce(b.cantidad,0)*a.Costo as MtoTotal,
			round(coalesce(c.cEntrada,0),2) as Entrada, 
			round(coalesce(c.cEntrada,0)*a.Costo,2) as Montoentrada,
			round(coalesce(c.cSalida,0),2) as Salida,
			round(coalesce(c.cSalida,0)*a.Costo,2) as Montosalida,
			round(coalesce(b.cantidad,0),2)+round(coalesce(c.cantidad,0),2) as InventarioFinal,
			round(a.Costo,2) as CostoFinal,
			round(((round(coalesce(b.cantidad,0),2)+round(coalesce(c.cantidad,0),2)))*round(a.Costo,2),2) as MtoFinal
			FROM PosUpProducto a 
			left join (select ba.IdCompany, ba.CodIdBasico, 
			sum(ba.Cant*bb.Inventario) as cantidad, ba.IdAlm as idal,bb.Idtipotx as tipotrans 
			from PosUpTxD ba 
			inner join PosUpAlmacen f on ba.IdCompany = f.IdCompany and ba.IdAlm = f.IdAlm 
			inner join PosUpUbicacion z on f.IdCompany=z.IdCompany and f.IdUbi=z.IdUbi
			inner join PosUpTx bb on ba.Idtipotx = bb.Idtipotx  
			where  ba.IdCompany=" . $_POST["CompanyActual"] . " and ba.Fectxclient < '" . $fechaDES . " 00:00:00' " . $Almacen23 . $sucursal . " 
			GROUP by ba.IdCompany,ba.CodIdBasico) b on
			a.IdCompany = b.IdCompany and a.CodIdBasico = b.CodIdBasico 
			left join (select ba.IdCompany, ba.CodIdBasico,
			sum(if(ba.Idtipotx in (7,18,3,28,30) or (ba.Idtipotx in (8,10,9,17) and ba.Cant > 0),ba.Cant*bb.Inventario,0)) as cEntrada, 
			sum(if(ba.Idtipotx in (1,2,11,15,19,21,22,27,31,35,38) or (ba.Idtipotx in (8,10,9,17) and ba.Cant < 0),ba.Cant*bb.Inventario,0)) as cSalida, 
			sum(ba.Cant*bb.Inventario) as cantidad from PosUpTxD ba
			inner join PosUpAlmacen f on ba.IdCompany = f.IdCompany and ba.IdAlm = f.IdAlm 
			inner join PosUpUbicacion z on f.IdCompany=z.IdCompany and f.IdUbi=z.IdUbi
			inner join PosUpTx bb on ba.Idtipotx = bb.Idtipotx 
			where  ba.IdCompany=" . $_POST["CompanyActual"] . " and ba.Fectxclient BETWEEN '" . $fechaDES . " 00:00:00' and '" . $fechaHAS . " 23:59:59' " . $Almacen23 . $sucursal . "  
			GROUP by ba.IdCompany,ba.CodIdBasico ) c on a.IdCompany = c.IdCompany and a.CodIdBasico = c.CodIdBasico
			where  a.IdCompany=" . $_POST["CompanyActual"] . " AND a.EsCompuesto=0
							" . $beetween . "
					" . $familia . "
					" . $ConInv . "
					" . $ConMov . "
					" . $OrdenBy . "
			";


		if ($result = mysqli_query($conn, $query)) {
			$n = 0;
			/* obtener array asociativo */
			while ($row = mysqli_fetch_assoc($result)) {
				$n = $n + 1;
				$nt = $nt + 1;
				$nt2 = $nt2 + 1;
				$montoinicial = $montoinicial + $row["MtoTotal"];
				$montoentradas = $montoentradas + $row["Montoentrada"];
				$montosalidas = $montosalidas + $row["Montosalida"];
				$montotfinal = $montotfinal + $row["MtoFinal"];
				$montoinicial2 = $montoinicial2 + $row["MtoTotal"];
				$montoentradas2 = $montoentradas2 + $row["Montoentrada"];
				$montosalidas2 = $montosalidas2 + $row["Montosalida"];
				$montotfinal2 = $montotfinal2 + $row["MtoFinal"];             ?>
				<div style="text-align: left; float:left; width: 100%;">
					<div class="campo" style="visibility:hidden; text-align: left; width: 2%; background-color: gray;">Descripcion</div>
					<div class="campo" style=" text-align: left; width: 8%; "><?php if ($row['CodBarra'] == "") {
																					echo "-";
																				} else {
																					echo $row['CodBarra'];
																				} ?></div>
					<div class="campo" style=" text-align: left; width: 25%; "><?php if ($row['Descripcion'] == "") {
																					echo "-";
																				} else {
																					echo $row['Descripcion'];
																				} ?></div>
					<div class="campo" style=" text-align: right; width: 5%; "><?php if ($row['InventarioInicial'] == "") {
																					echo "-";
																				} else {
																					echo number_format($row['InventarioInicial'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
																				} ?></div>
					<div class="campo" style=" text-align: right; width: 6%; "><?php if ($row['Costo'] == "") {
																					echo "-";
																				} else {
																					echo number_format($row['Costo'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
																				} ?></div>
					<div class="campo" style=" text-align: right; width: 6%; "><?php if ($row['MtoTotal'] == "") {
																					echo "-";
																				} else {
																					echo number_format($row['MtoTotal'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
																				} ?></div>
					<div class="campo" style=" text-align: right; width: 5%; "><?php if ($row['Entrada'] == "") {
																					echo "-";
																				} else {
																					echo number_format($row['Entrada'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
																				} ?></div>
					<div class="campo" style=" text-align: right; width: 5%; "><?php if ($row['Montoentrada'] == "") {
																					echo "-";
																				} else {
																					echo number_format($row['Montoentrada'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
																				} ?></div>
					<div class="campo" style=" text-align: right; width: 5%; "><?php if ($row['Salida'] == "") {
																					echo "-";
																				} else {
																					echo number_format($row["Salida"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
																				} ?></div>
					<div class="campo" style=" text-align: right; width: 5%; "><?php if ($row['Montosalida'] == "") {
																					echo "-";
																				} else {
																					echo number_format($row['Montosalida'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
																				} ?></div>
					<div class="campo" style=" text-align: right; width: 5%; "><?php if ($row['InventarioFinal'] == "") {
																					echo "-";
																				} else {
																					echo number_format($row['InventarioFinal'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
																				} ?></div>
					<div class="campo" style=" text-align: right; width: 6%; "><?php if ($row['CostoFinal'] == "") {
																					echo "-";
																				} else {
																					echo number_format($row['CostoFinal'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
																				} ?></div>
					<div class="campo" style=" text-align: right; width: 6%; "><?php if ($row['MtoFinal'] == "") {
																					echo "-";
																				} else {
																					echo number_format($row['MtoFinal'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
																				} ?></div>
				</div> <?php
						if ($_POST["SerialesG"] == "on") {
							$queryS = "select IdAlm,Almacen,count(Seriales) as Cantidad from (select c.IdAlm,c.Nombre as Almacen,a.seriales from PosUpTxD a 
    inner join PosUpProducto b on a.IdCompany=b.IdCompany and a.CodIdBasico=b.CodIdBasico 
    inner join PosUpAlmacen c on a.IdCompany=c.IdCompany and a.IdAlm=c.IdAlm 
    inner join PosUpTx d on a.Idtipotx=d.Idtipotx 
    where a.IdCompany=" . $_POST["CompanyActual"] .  " and b.CodBarra = '" . $row["CodBarra"] . "'  group by b.CodIdBasico,c.IdAlm,a.seriales 
    HAVING round(sum(coalesce(a.Cant)*coalesce(d.Inventario)),3)>0 and coalesce(a.seriales,-1) >-1 and a.seriales<>'') a
    group by IdAlm ";
							//   echo $row['CodIdBasico'];
							//   echo $b;    
							// echo $queryS;    
							//BUCLE 1,2
							if ($resultS = mysqli_query($conn, $queryS)) {
								while ($rowS = mysqli_fetch_assoc($resultS)) {
									if ($rowS == TRUE) {
										$n = $n + 2;
						?>
								<div style="text-align: left; float:left; width: 100%;">
									<div class="campo" style="visibility:hidden; text-align: left; width: 2%; background-color: gray;">Seriales</div>
									<div class="campo" style=" text-align: left; width: 81%; background-color: gray;"><?php echo lang("Seriales"); ?></div>
								</div>
								<?php
										if ($resultS = mysqli_query($conn, $queryS)) {
								?>
									<?php
											while ($rowS = mysqli_fetch_assoc($resultS)) {
												$querySA[] = $rowS;
												$n = $n + 1;
												$a = $rowS["Almacen"] . " (" . $rowS["Cantidad"] . ")"; ?>
										<div style="text-align: left; float:left; width: 100%;">
											<div class="campo" style="visibility:hidden; text-align: left; width: 2%; background-color: gray;">Seriales</div>
											<div class="campo" style=" text-align: left; width: 81%; "><strong> <?php echo $a; ?> </strong></div>
										</div>
										<?php
												$queryS2 =
													"select b.CodBarra,c.IdAlm as IdAlmacen,c.Nombre as Almacen,a.seriales as Seriales FROM PosUpTxD a 
                        inner join PosUpProducto b on a.IdCompany=b.IdCompany and a.CodIdBasico=b.CodIdBasico 
                        inner join PosUpAlmacen c on a.IdCompany=c.IdCompany and a.IdAlm=c.IdAlm 
                        inner join PosUpTx d on a.Idtipotx=d.Idtipotx 
                        where a.IdCompany= " . $_POST["CompanyActual"]  . " and b.CodBarra = '" . $row["CodBarra"] . "' and c.IdAlm=" . $rowS["IdAlm"] . " group by b.CodIdBasico,c.IdAlm,a.seriales 
                        HAVING round(sum(coalesce(a.Cant)*coalesce(d.Inventario)),3)>0 and coalesce(a.seriales,-1) >-1 and a.seriales<>''";

												if ($resultS2 = mysqli_query($conn, $queryS2)) {
													$a = "  ";
													while ($rowS2 = mysqli_fetch_assoc($resultS2)) {
														$querySA2[] = $rowS2;
														$o = $o + 1;
														$a =  $a . $rowS2["Seriales"] . "  ";
														if ($o > 13) {
										?>
													<div style="text-align: left; float:left; width: 100%;">
														<div class="campo" style=" visibility:hidden; text-align: left; width: 2%; background-color: gray;">Seriales</div>
														<div class="campo" style=" text-align: left; width: 97%; "><?php echo $a; ?></div>
													</div><?php
															$n = $n + 1;
															$a = "  ";
															//echo $a."-"; echo $o; 
															$o = 0;
														}
														//$n=$n+1;
													}
													if ($o >= 1) {
														$n = $n + 1;
														$o = 0;
															?>
												<div style="text-align: left; float:left; width: 100%;">
													<div class="campo" style="visibility:hidden; text-align: left; width: 2%; background-color: gray;">Seriales</div>
													<div class="campo" style=" text-align: left; width: 97%; "> <?php echo $a; ?> </div>
												</div> <?php
														$a = "  ";
													}
													mysqli_free_result($resultS2);
												}
											}
											mysqli_free_result($resultS);
										}
										// BUCLE 1,3 

									}
														?><div class="encabezado" style="font-size: 2px;">
								<hr>
							</div><?php
								}
							}
							mysqli_free_result($resultS);
						}

						$unidadTotal = $unidadTotal + $row["unidad"];
						$ExistenciaTotal = $ExistenciaTotal + $row["Cantidad"];
						if ($n == 57) { ?>
					<div class="encabezado" style="font-size: 2px;">
						<hr>
					</div>
					<div style="text-align: left; float:left; width: 100%;">
						<div class="campo" style="visibility:hidden; text-align: left; width: 2%; background-color: gray;">Descripcion</div>
						<div class="campo" style="visibility:hidden; text-align : left; width: 8%; ">a<?php if ($row['CodBarra'] == "") {
																											echo "-";
																										} else {
																											echo $row['CodBarra'];
																										} ?></div>
						<div class="campo" style=" text-align: left; width: 25%; "><?php echo lang("Totales por Pagina"); ?></div>
						<div class="campo" style="visibility:hidden; text-align: left; width: 5%; ">a</div>
						<div class="campo" style="visibility:hidden; text-align: left; width: 6%; ">a</div>
						<div class="campo" style=" text-align: right; width: 6%; "><?php echo number_format($montoinicial, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>
						<div class="campo" style="visibility:hidden; text-align: right; width: 5%; ">a<?php if ($row['Ventas'] == "") {
																											echo "-";
																										} else {
																											echo number_format($row["Ventas"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
																										} ?></div>
						<div class="campo" style=" text-align: right; width: 5%; "><?php echo number_format($montoentradas, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>
						<div class="campo" style="visibility:hidden; text-align: right; width: 5%; ">a<?php if ($row['Ccompras'] == "") {
																											echo "-";
																										} else {
																											echo number_format($row['Ccompras'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
																										} ?></div>
						<div class="campo" style=" text-align: right; width: 5%; "><?php echo number_format($montosalidas, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>
						<div class="campo" style="visibility:hidden; text-align: right; width: 5%; ">a<?php if ($row['Ctraslados'] == "") {
																											echo "-";
																										} else {
																											echo number_format($row['Ctraslados'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
																										} ?></div>
						<div class="campo" style="visibility:hidden; text-align: right; width: 6%; ">a<?php echo number_format($Costfinal, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>

						<div class="campo" style=" text-align: right; width: 6%; "><?php echo number_format($montotfinal, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>
					</div>

					<div class="encabezado" style="font-size: 2px;">
						<hr>
					</div>
					<div style="text-align: left; float:left; width: 100%;">
						<div class="campo" style="visibility:hidden; text-align: left; width: 2%; background-color: gray;">Descripcion</div>
						<div class="campo" style="visibility:hidden; text-align: left; width: 8%; "><?php if ($row['CodBarra'] == "") {
																										echo "-";
																									} else {
																										echo $row['CodBarra'];
																									} ?></div>
						<div class="campo" style=" text-align: left; width: 25%; "><?php echo lang("Totales Acumulados"); ?></div>
						<div class="campo" style="visibility:hidden; text-align: left; width: 5%; "><?php if ($row['CodIdBasico'] == "") {
																										echo "-";
																									} else {
																										echo $row['CodIdBasico'];
																									} ?></div>
						<div class="campo" style="visibility:hidden; text-align: left; width: 6%; "><?php if ($row['CodIdAmpliado'] == "") {
																										echo "-";
																									} else {
																										echo $row['CodIdAmpliado'];
																									} ?></div>
						<div class="campo" style=" text-align: right; width: 6%; "><?php echo number_format($montoinicial2, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>
						<div class="campo" style="visibility:hidden; text-align: right; width: 5%; ">a<?php if ($row['Ventas'] == "") {
																											echo "-";
																										} else {
																											echo number_format($row["Ventas"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
																										} ?></div>
						<div class="campo" style=" text-align: right; width: 5%; "><?php echo number_format($montoentradas2, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>
						<div class="campo" style="visibility:hidden; text-align: right; width: 5%; ">a<?php if ($row['Ccompras'] == "") {
																											echo "-";
																										} else {
																											echo number_format($row['Ccompras'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
																										} ?></div>
						<div class="campo" style=" text-align: right; width: 5%; "><?php echo number_format($montosalidas2, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>
						<div class="campo" style="visibility:hidden; text-align: right; width: 5%; ">a<?php if ($row['Ctraslados'] == "") {
																											echo "-";
																										} else {
																											echo number_format($row['Ctraslados'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
																										} ?></div>
						<div class="campo" style="visibility:hidden; text-align: right; width: 6%; ">a<?php echo number_format($Costfinal2, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>

						<div class="campo" style=" text-align: right; width: 6%; "><?php echo number_format($montotfinal2, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>
					</div>

					<div class="encabezado" style="font-size: 2px;">
						<hr>
					</div>
					<div class="campo" style=" text-align: left; width: 24%; background-color: white;"><?php echo lang("Totales Registros"); ?></div>
					<div class="campo" style=" text-align: left; width: 15%; background-color: white;"><?php echo lang("Registro por Pagina") . "=" . $nt2 ?></div>
					<div class="campo" style=" text-align: left; width: 15%; background-color: white;"><?php echo lang("Registro Total acumulado") . "=" . $nt ?></div>

					<div style="PAGE-BREAK-AFTER: always"></div>
					<div class="sup">
						<div style="float:left; width: 23%;">
							<div class="TituloEmpresa" id="Titulo"><?php echo $_POST["NameCompany"]; ?></div>
							<div class="Subtituloempresa" id="Ubicacion"><?php echo $_POST["direccion"]; ?></div>
							<div class="Subtituloempresa" id="Literal Fiscal"><?php echo $_POST["litfiscal"]; ?>-<?php echo $_POST["rute"]; ?></div>
						</div>
						<div style="float:left; width: 53%;">
							<div class="TituloEmpresa" style="float: center; text-align: center;"><?php echo lang("Movimiento Fiscal"); ?></div>
							<div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php
																																		if ($_POST["Almacen234G"] == FALSE) {
																																			echo "--------------------";
																																		}
																																		if ($_POST["Almacen234G"] == true) {
																																			echo "Almacen:";
																																			$array2 = $_POST["Almacen234G"];
																																			foreach ($array2 as $array2) {
																																				$query123 = "Select IdAlm,Nombre from PosUpAlmacen where IdCompany=" . $_POST["CompanyActual"] . "
                                        and IdAlm=" . $array2 . "
                                        ";

																																				if ($result123 = mysqli_query($conn, $query123)) {
																																					while ($row123 = mysqli_fetch_assoc($result123)) {
																																						echo "   " . $row123["Nombre"];
																																					}
																																					mysqli_free_result($result123);
																																				}
																																			}
																																		} ?>
							</div>


							<div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
								<?php echo lang("Orden por"); ?>: <?php
																	if ($_POST["OrdenRESG"] == "1") {
																		echo lang("Codigo");
																	}
																	if ($_POST["OrdenRESG"] == "2") {
																		echo lang("Descripcion");
																	}
																	if ($_POST["OrdenRESG"] == "3") {
																		echo lang("Cantidad de Inventario");
																	}
																	if ($_POST["OrdenRESG"] == "4") {
																		echo lang("Monto de Inventario");
																	}
																	if ($_POST["OrdenRESG"] == "5") {
																		echo lang("Mayor Utilidad");
																	}
																	if ($_POST["OrdenRESG"] == "6") {
																		echo lang("Mayor Venta");
																	}                               ?>
							</div>
							<div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php if ($_POST["CodigoDesdeLPRES"] == true) {
																																			echo lang("Desde el Codigo") . ":" . $_POST["CodigoDesdeLPRES"];
																																		} ?> <?php if ($_POST["CodigoHastaLPRES"] == true) {
																																					echo " " . lang("al") . " " . $_POST["CodigoHastaLPRES"];
																																				} ?></div>
							<div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php
																																		if ($_POST["DesdeFechaG"] == true) {
																																			echo $fechaDES . " " . lang("hasta") . " " . "";
																																		}
																																		if ($_POST["FechaHastaG"] == true) {
																																			echo $fechaHAS;
																																		}
																																		?></div>
							<div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php if ($_POST["Familias2asd"] == "*") {
																																			echo "--------------------";
																																		} else {
																																			echo "";
																																		} ?><?php
																																			?><?php if ($_POST["Familias2asdG"] == "*") {
																																				} else {
																																					$queryAlma2 = " SELECT IdVarios,ITEM FROM PosUpvarios WHERE TIPOITEM=2 and IdCompany=" . $_POST["CompanyActual"] . " and IdVarios=" . $_POST["Familias2asd"] . " ";
																																					if ($resultqueryAlma2 = mysqli_query($conn, $queryAlma2)) {
																																						while ($rowqueryAlma2 = mysqli_fetch_assoc($resultqueryAlma2)) {
																																							echo " " . lang("Familia") . ": " . $rowqueryAlma2["ITEM"];
																																						}
																																						mysqli_free_result($resultqueryAlma2);
																																					}
																																				} ?> </div>

							<div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;"><?php if ($_POST["ProductosInv"] == "on" or $_POST["ProductosMov"] == "on") {
																																			echo "" . lang("Incluyendo") . ":";
																																		} else {
																																			echo "--------------------";
																																		} ?> <?php if ($_POST["ProductosInv"] == "on") {
																																					echo "  " . lang("Productos con Inventario") . " ";
																																				}
																																				if ($_POST["ProductosMov"]) {
																																					echo " " . lang("Productos con Movimiento") . "";
																																				} ?> </div>

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
					<div class="encabezado" style=""><strong>
							<div class="campo" style="visibility:hidden; text-align: left; width: 3%; background-color: gray;">Descripcion</div>
							<div class="campo" style="visibility:hidden; text-align: left; width: 32%; background-color: gray;">Descripcion</div>
							<div class="campo" style=" text-align: center; width: 18%; background-color: gray;"><?php echo lang("Existencia Inicial"); ?></div>
							<div class="campo" style=" text-align: center; width: 10%; background-color: gray;"><?php echo lang("Entradas"); ?></div>
							<div class="campo" style=" text-align: center; width: 10%; background-color: gray;"><?php echo lang("Salidas"); ?></div>


							<div class="campo" style=" text-align: center; width: 18%; background-color: gray;"><?php echo lang("Existencia Final"); ?></div>

					</div></strong>
					<div class="encabezado" style="">
						<div class="campo" style="visibility:hidden; text-align: left; width: 2%; background-color: gray;"><?php echo lang("Descripción"); ?></div>
						<div class="campo" style=" text-align: left; width: 8%; background-color: gray;"><?php echo lang("Código"); ?> </div>
						<div class="campo" style=" text-align: left; width: 25%; background-color: gray;"><?php echo lang("Descripción"); ?></div>
						<div class="campo" style=" text-align: right; width: 5%; background-color: gray;"><?php echo lang("Cantidad"); ?></div>
						<div class="campo" style=" text-align: right; width: 6%; background-color: gray;"><?php echo lang("Costo UNIT"); ?></div>
						<div class="campo" style=" text-align: right; width: 6%; background-color: gray;"><?php echo lang("Mto.Total"); ?></div>
						<div class="campo" style=" text-align: right; width: 5%; background-color: gray;"><?php echo lang("Cantidad"); ?> </div>
						<div class="campo" style=" text-align: right; width: 5%; background-color: gray;"><?php echo lang("Monto $"); ?> </div>
						<div class="campo" style=" text-align: right; width: 5%; background-color: gray;"><?php echo lang("Cantidad"); ?> </div>
						<div class="campo" style=" text-align: right; width: 5%; background-color: gray;"><?php echo lang("Monto"); ?> $ </div>
						<div class="campo" style=" text-align: right; width: 5%; background-color: gray;"><?php echo lang("Cantidad"); ?> </div>
						<div class="campo" style=" text-align: right; width: 6%; background-color: gray;"><?php echo lang("Costo Unit"); ?> </div>
						<div class="campo" style=" text-align: right; width: 6%; background-color: gray;"><?php echo lang("Mto.Total"); ?> </div>
					</div>
		<?php
							$CostoExistencia = 0;
							$unidadTotal = 0;
							$ExistenciaTotal = 0;
							$n = 0;
							$nt2 = 0;
							$montoinicial = 0;
							$montoentradas = 0;
							$montosalidas = 0;
							$montotfinal = 0;
						}
					}
					mysqli_free_result($result);
				} ?>

		<div class="encabezado" style="font-size: 2px;">
			<hr>
		</div>
		<div style="text-align: left; float:left; width: 100%;">
			<div class="campo" style="visibility:hidden; text-align: left; width: 2%; background-color: gray;">Descripcion</div>
			<div class="campo" style="visibility:hidden; text-align : left; width: 8%; ">a<?php if ($row['CodBarra'] == "") {
																								echo "-";
																							} else {
																								echo $row['CodBarra'];
																							} ?></div>
			<div class="campo" style=" text-align: left; width: 25%; "><?php echo lang("Totales por Pagina"); ?></div>
			<div class="campo" style="visibility:hidden; text-align: left; width: 5%; ">a</div>
			<div class="campo" style="visibility:hidden; text-align: left; width: 6%; ">a</div>
			<div class="campo" style=" text-align: right; width: 6%; "><?php echo number_format($montoinicial, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>
			<div class="campo" style="visibility:hidden; text-align: right; width: 5%; ">a<?php if ($row['Ventas'] == "") {
																								echo "-";
																							} else {
																								echo number_format($row["Ventas"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
																							} ?></div>
			<div class="campo" style=" text-align: right; width: 5%; "><?php echo number_format($montoentradas, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>
			<div class="campo" style="visibility:hidden; text-align: right; width: 5%; ">a<?php if ($row['Ccompras'] == "") {
																								echo "-";
																							} else {
																								echo number_format($row['Ccompras'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
																							} ?></div>
			<div class="campo" style=" text-align: right; width: 5%; "><?php echo number_format($montosalidas, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>
			<div class="campo" style="visibility:hidden; text-align: right; width: 5%; ">a<?php if ($row['Ctraslados'] == "") {
																								echo "-";
																							} else {
																								echo number_format($row['Ctraslados'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
																							} ?></div>
			<div class="campo" style="visibility:hidden; text-align: right; width: 6%; ">a<?php echo number_format($Costfinal, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>

			<div class="campo" style=" text-align: right; width: 6%; "><?php echo number_format($montotfinal, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>
		</div>

		<div class="encabezado" style="font-size: 2px;">
			<hr>
		</div>
		<div style="text-align: left; float:left; width: 100%;">
			<div class="campo" style="visibility:hidden; text-align: left; width: 2%; background-color: gray;">Descripcion</div>
			<div class="campo" style="visibility:hidden; text-align: left; width: 8%; "><?php if ($row['CodBarra'] == "") {
																							echo "-";
																						} else {
																							echo $row['CodBarra'];
																						} ?></div>
			<div class="campo" style=" text-align: left; width: 25%; "><?php echo lang("Totales Acumulados"); ?></div>
			<div class="campo" style="visibility:hidden; text-align: left; width: 5%; "><?php if ($row['CodIdBasico'] == "") {
																							echo "-";
																						} else {
																							echo $row['CodIdBasico'];
																						} ?></div>
			<div class="campo" style="visibility:hidden; text-align: left; width: 6%; "><?php if ($row['CodIdAmpliado'] == "") {
																							echo "-";
																						} else {
																							echo $row['CodIdAmpliado'];
																						} ?></div>
			<div class="campo" style=" text-align: right; width: 6%; "><?php echo number_format($montoinicial2, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>
			<div class="campo" style="visibility:hidden; text-align: right; width: 5%; ">a<?php if ($row['Ventas'] == "") {
																								echo "-";
																							} else {
																								echo number_format($row["Ventas"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
																							} ?></div>
			<div class="campo" style=" text-align: right; width: 5%; "><?php echo number_format($montoentradas2, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>
			<div class="campo" style="visibility:hidden; text-align: right; width: 5%; ">a<?php if ($row['Ccompras'] == "") {
																								echo "-";
																							} else {
																								echo number_format($row['Ccompras'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
																							} ?></div>
			<div class="campo" style=" text-align: right; width: 5%; "><?php echo number_format($montosalidas2, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>
			<div class="campo" style="visibility:hidden; text-align: right; width: 5%; ">a<?php if ($row['Ctraslados'] == "") {
																								echo "-";
																							} else {
																								echo number_format($row['Ctraslados'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
																							} ?></div>
			<div class="campo" style="visibility:hidden; text-align: right; width: 6%; ">a<?php echo number_format($Costfinal2, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>

			<div class="campo" style=" text-align: right; width: 6%; "><?php echo number_format($montotfinal2, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);  ?></div>
		</div>

		<div class="encabezado" style="font-size: 2px;">
			<hr>
			<div class="campo" style=" text-align: left; width: 24%; background-color: white;"><?php echo lang("Totales Registros"); ?></div>
			<div class="campo" style=" text-align: left; width: 15%; background-color: white;"><?php echo lang("Registro por Pagina") . "=" . $nt2 ?></div>
			<div class="campo" style=" text-align: left; width: 15%; background-color: white;"><?php echo lang("Registro Total acumulado") . "=" . $nt ?></div>
		</div>
	</div>
	<div style="PAGE-BREAK-AFTER: always; visibility: hidden;">a</div>

	<form id="formexcel" action="excelv3led.php" method="post">
		<?php
		$compa = $_POST["CompanyActual"];
		$name = lang("Fiscal") . ".csv";
		?>
		<input type="hidden" name="registro" id="registro" value="<?php echo $pro2; ?>" />
		<input type="hidden" name="Qry" id="Qry" value="<?php echo $query; ?>" />
		<input type="hidden" name="Name" id="Name" value="<?php echo $name; ?>" />
		<input type="hidden" name="Company" id="Company" value="<?php echo $compa; ?>" />
		<input type="hidden" name="ser" id="ser" value="" />
	</form>
	<form id="formexcel2" action="excelv3led.php" method="post">
		<?php
		$compa = $_POST["CompanyActual"];
		$name = "SerialesEnAlmacenesFiscal.csv";
		?>
		<input type="hidden" name="registro" id="registro" value="<?php echo $pro2; ?>" />
		<input type="hidden" name="Qry2" id="Qry2" value="<?php $queryA = urlencode(serialize($querySA));
															echo $queryA        ?>" />
		<input type="hidden" name="Name" id="Name" value="<?php echo $name; ?>" />
		<input type="hidden" name="Company" id="Company" value="<?php echo $compa; ?>" />
		<input type="hidden" name="ser" id="ser" value="" />
	</form>

	<form id="formexcel3" action="excelv3led.php" method="post">
		<?php
		$compa = $_POST["CompanyActual"];
		$name = "SerialesFiscal.csv";
		?>
		<input type="hidden" name="registro" id="registro" value="<?php echo $pro2; ?>" />
		<input type="hidden" name="Qry3" id="Qry3" value="<?php $queryA2 = urlencode(serialize($querySA2));
															echo $queryA2;       ?>" />
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