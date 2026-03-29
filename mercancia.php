<?php
include "ambiente.php";
$conn = ConectarConsultas();
$CompanyData = [];
$sql = "
		select
			checkventanega,
			VisualizaPrecio,
			LitP01,
			LitP02,
			LitP03,
			LitP04,
			LitP05,
			LitP06,
			LitP07,
			LitP08,
			LitP09,
			LitP10,
			LitCosto,
			1 as Tasa1,
			FactorDolarCash as Tasa2,
			FactorDolarPaypal as Tasa3,
			FactorDolarZelle as Tasa4,
			FactorDolar5 as Tasa5,
			FactorDolar6 as Tasa6,
			FactorDolar7 as Tasa7
		from
					PosUpCompany
		where
			Id =" . $_POST["CompanyActual"]  . "
		";
if ($result = mysqli_query($conn, $sql)) {
	while ($row = mysqli_fetch_assoc($result)) {
		$CompanyData = $row;
	}
};

$tsa = $_POST['SelectTasa'];

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
	<title>
		<?php echo lang("Productos"); ?>
	</title>
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
	<button class='ocultoimpresion ' onclick='document.getElementById(`formexcel`).submit()'><img src='/img/excel.png' width='28' height='28'><br>
		<?php echo lang('Productos'); ?>
		<br></button>
	<?php
	if ($_POST["Seriales"] == "on") {
	?>
		<button class='ocultoimpresion ' onclick='document.getElementById(`formexcel2`).submit()'><img src='/img/excel.png' width='28' height='28'><br>
			<?php echo lang('IdAlm S'); ?>
			<br></button>
		<button class='ocultoimpresion ' onclick='document.getElementById(`formexcel3`).submit()'><img src='/img/excel.png' width='28' height='28'><br>
			<?php echo lang('Seriales'); ?>
			<br></button>
	<?php
	}
	?>
	<div class="pagina" style="font-size: 12px;">

		<div class="sup">
			<div style="float:left; width: 23%;">
				<div class="TituloEmpresa" id="Titulo">
					<?php echo $_POST["NameCompany"]; ?>
				</div>
				<div class="Subtituloempresa" id="Ubicacion">
					<?php echo $_POST["direccion"]; ?>
				</div>
				<div class="Subtituloempresa" id="Literal Fiscal">
					<?php echo $_POST["litfiscal"]; ?>-<?php echo $_POST["rute"]; ?>
				</div>
			</div>
			<div style="float:left; width: 54%;">
				<div class="TituloEmpresa" style="float: center; text-align: center;">
					<?php echo lang('Productos'); ?>
				</div>
				<div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
					<?php echo lang('Orden por'); ?>:<?php echo $_POST["Orden"]; ?>
					<?php echo ($_POST["CodigoDesde"] === true ? " / " . lang("Desde el codigo") . ":" . $_POST["CodigoDesde"] : "")  ?>
					<?php echo ($_POST["CodigoHasta"] === true ? lang("al") . " " . $_POST["CodigoHasta"] : "") ?>
				</div>
				<div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
					<?php echo ($_POST["Instancia2NK"] === true ? lang("De la Familia:") . " / " . $_POST["Instancia2NK"] : "") ?>
				</div>
				<div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
					<?php echo ($_POST["Proevedor2"] == true or $_POST["Marca2"] == true or $_POST["Deposito2NK"] == true ? "Con:" : "--------------------"); ?>
					<?php echo ($_POST["Proevedor2"] === true ? "Beneficiario:/" . $_POST["Proevedor2"] : "") ?>
					<?php
					if ($_POST["Marca2"] == true ? " / Marca:" . $_POST["Marca2"] : "") ?>
					<?php
					if ($_POST["Deposito2NK"] == true) {
						echo " / Almacen:" . $_POST["Deposito2NK"];
					}
					?> </div>
				<div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
					<?php
					if ($_POST["Incluirimpuestos"] == "on" or $_POST["Referencia"] == "on" or $_POST["Incluirlotes"] == "on" or $_POST["ExistenciaCero"] == "on" or $_POST["Seriales"] == "on") {
						echo "Incluyendo:";
					} else {
						echo "--------------------";
					}
					?>
					<?php
					if ($_POST["Incluirimpuestos"] == "on") {
						echo " / " . lang("Impuestos") . "";
					}
					?>
					<?php
					if ($_POST["Incluirlotes"] == "on") {
						echo " / " . lang("Lotes") . "";
					}
					?>
					<?php
					if ($_POST["ExistenciaCero"] == "on") {
						echo " / Existencia 0";
					}
					?>
					<?php
					if ($_POST["Referencia"] == "on") {
						echo "/ " . lang("Referencia") . "";
					}
					?>
					<?php
					if ($_POST["Seriales"] == "on") {
						echo " / " . lang("Seriales") . "";
					}
					?>
				</div>
			</div>
			<div style="float:left; width: 23%;">
				<div class="FechaI"><span id="fectx">
						<?php echo $_POST["fectx5"]; ?>
					</span></div><br>
				<div class="FechaI">
					<div class="page"></div>
				</div><br>
				<div type='submit' value='export_data' class="FechaI"><img style="width: 30%;" src="img/AZUL.svg" /></div><br><br>
				<div class="FechaI">-</div>
			</div>
		</div>
		<div style=" width: 100%;">
			<div class="encabezado" style=" width: 100%;">
				<div class="campo" style=" text-align: left; width: 9%; background-color: gray;">
					<?php echo lang('Codigo Barra'); ?>
				</div>

				<div class="campo" style=" text-align: left; width: 9%; background-color: gray;">
					<?php echo lang('Codigo Ampliado'); ?>
				</div>

				<div class="campo" style=" text-align: left; width: 32%; background-color: gray;">
					<?php echo lang('Descripcion'); ?>
				</div>
				<?php
				if ($_POST['cos'] == true) {
				?>
					<div class="campo" style=" text-align: right; width: 7%; background-color: gray;">
						<?php echo lang('Costo unitario'); ?>
					</div>
				<?php
				}
				?>
				<?php
				if ($_POST['mexist'] == true) {
				?>
					<div class="campo" style=" text-align: right; width: 9%; background-color: gray;">
						<?php echo lang('Existencia'); ?> </div>
					<div class="campo" style=" text-align: right; width: 3%; background-color: gray;">
						<?php echo lang('Unidades'); ?> </div>

				<?php
				}
				?>
				<?php
				if ($_POST['cos'] == true and $_POST['mexist'] == true) {
				?>
					<div class="campo" style=" text-align: right; width: 8%; background-color: gray;">
						<?php echo lang('Costo Existencia'); ?> </div>
				<?php
				}
				?>
				<?php
				if ($_POST["Incluirimpuestos"] == "on") {
				?>
					<div class="campo" style=" text-align: right; width: 6%; background-color: gray;">
						<?php echo lang('Precio Venta'); ?> </div>
				<?php
				}
				?>

				<?php
				if ($_POST["Utilidad"] == "on") {
				?>
					<div class="campo" style=" text-align: right; width: 6%; background-color: gray;">
						<?php echo lang('%Util'); ?>
					</div>
				<?php
				}
				?>
			</div>
		</div>



		<?php

		//---------------------------------------------------------------------------------------------------------------------------
		if (!empty($_POST["mIdProevedor"])) {
			$having = "having";
			$Proevedor = "and c.idBen in ('" . implode("','", $_POST["mIdProevedor"]) . "')";
		}
		//---------------------------------------------------------------------------------------------------------------------------
		if (!empty($_POST["mIdAlmacen"])) {
			$having = "having";
			$Deposito0 = " having IdAlm in ('" . implode("','", $_POST["mIdAlmacen"]) . "')";
			$Deposito = " and a.IdAlm in ('" . implode("','", $_POST["mIdAlmacen"]) . "')";
			$Deposito2 = "and b.IdAlm in ('" . implode("','", $_POST["mIdAlmacen"]) . "')";
			$Deposito3 = " and c.IdAlm in ('" . implode("','", $_POST["mIdAlmacen"]) . "')";
		}
		//---------------------------------------------------------------------------------------------------------------------------
		if (!empty($_POST["mIdMarca"])) {
			$having = "having";
			$Marca = "and a.Marca in ('" . implode("','", $_POST["mIdMarca"]) . "')";
		}
		//---------------------------------------------------------------------------------------------------------------------------
		if ($_POST["Orden"] == "Codigo") {
			$Orden = "order by a.CodIdBasico";
		} else if ($_POST["Orden"] == "Descripcion") {
			$Orden = "order by a.Descripcion";
		} else if ($_POST["Orden"] == "Referencia") {
			$Orden = "order by a.CodBarra";
		} else if ($_POST["Orden"] == "Instancia") {
			$Orden = "order by a.Idfamilia";
		} else if ($_POST["Orden"] == "Rentables") {
			$Orden = "order by a.Margen";
		} else if ($_POST["Orden"] == "Costo") {
			$Orden = "order by a.Costo";
		} else if ($_POST["Orden"] == "Precio") {
			$Orden = "order by a.PrecioNeto";
		}

		$Orden .= " " . $_POST["Orientacion"];
		//---------------------------------------------------------------------------------------------------------------------------
		if (!empty($_POST["mIdfamilia"])) {
			$familia = " and a.Idfamilia in ('" . implode("','", $_POST["mIdfamilia"]) . "') ";
		}
		//---------------------------------------------------------------------------------------------------------------------------
		// if ($_POST["CodigoDesde"] == true and $_POST["CodigoHasta"] == true) {
		// 	$beetween = "and a.CodIdAmpliado between '" . $_POST["CodigoDesde"] . "' and '" . $_POST["CodigoHasta"] . "' ";
		// }
		// if ($_POST["CodigoDesde"] == true and $_POST["CodigoHasta"] == false) {
		// 	$beetween = "and a.CodIdAmpliado between '" . $_POST["CodigoDesde"] . "' and '" . $_POST["CodigoDesde"] . "' ";
		// }
		// if ($_POST["CodigoDesde"] == false and $_POST["CodigoHasta"] == true) {
		// 	$beetween = "and a.CodIdAmpliado between '" . $_POST["CodigoHasta"] . "' and '" . $_POST["CodigoHasta"] . "' ";
		// }
		if (!empty($_POST["mIdProductos"])) {
			$beetween = " and a.CodIdBasico in ('" . implode("','", $_POST["mIdProductos"]) . "') ";
		}
		//---------------------------------------------------------------------------------------------------------------------------
		//---------------------------------------------------------------------------------------------------------------------------
		if (!$_POST["ExistenciaCero"] == "on") {
			$ExistenciaCero = " and round(b.cantidad,3)<>0";
		}

		if ($_POST["Incluirlotes"] == "on") {
			$Incluirlotes = " and round(cantidad,3)<>0";
		}


		$fechaA = " where a.IdCompany=" . $_POST["CompanyActual"] . " and a.Fectxclient <= '" . $_POST["FechaHastaproductos"] . " 23:59:59'";
		$fechaC = " where a.IdCompany=" . $_POST["CompanyActual"] . " and c.Fectxclient <= '" . $_POST["FechaHastaproductos"] . " 23:59:59'";
		$fechaAA = " and a.Fectxclient <= '" . $_POST["FechaHastaproductos"] . " 23:59:59'";
		$fechaCA = " and c.Fectxclient <= '" . $_POST["FechaHastaproductos"] . " 23:59:59'";


		$querySA = array();
		$querySA2 = array();
		//---------------------------------------------------------------------------------------------------------------------------
		//---------------------------------------------------------------------------------------------------------------------------
		$query = "SET SESSION group_concat_max_len = 1000000";
		$result = mysqli_query($conn, $query);
		if ($_POST['cos'] == true) {
			$cos = ",round(a.CostoNeto * " . $CompanyData["Tasa$tsa"] . ",2) as Costo";
		}

		if ($_POST['mexist'] == true) {
			$cosexis = ",
                                            round(COALESCE(b.Cantidad,0)*COALESCE(a.CostoNeto * " . $CompanyData["Tasa$tsa"] . ",0),2) as CostoExistencia";
			$exis = ",
                                            round(coalesce(b.Cantidad,0),2) as existencia";
		}
		if ($_POST["Incluirimpuestos"]) {
			$imp = ",
                                            (a.PrecioNeto" . $_POST["SelectPrecio"] . ") * " . $CompanyData["Tasa$tsa"] . " as precio";
		}
		if ($_POST["Utilidad"]) {
			$util = ",
                                            round(coalesce((a.PrecioNeto-a.CostoNeto)/a.PrecioNeto*100,0),2) as Util";
		}
		$qry = "SET SESSION group_concat_max_len = 1000000";
		mysqli_query($conn, $qry);

		$sql = "
		select
			group_concat(Idtipotx) as Idtipotx
		from
			posuptx
		where
			Inventario <> 0
			and CompInv = 0
		";
		$Operainv = "";
		if ($result = mysqli_query($conn, $sql)) {
			while ($row = mysqli_fetch_assoc($result)) {
				$Operainv = $row["Idtipotx"];
			}
		}

		$sql = "
		select
		group_concat(Idtipotx) as Idtipotx
	from
		posuptx
	where
		Inventario = 1
		and CompInv = 0
		";
		$Suminv = "";
		if ($result = mysqli_query($conn, $sql)) {
			while ($row = mysqli_fetch_assoc($result)) {
				$Suminv = $row["Idtipotx"];
			}
		}

		$sql = "
		select
			group_concat(Idtipotx) as Idtipotx
		from
			posuptx
		where
			Inventario = -1
			and CompInv = 0
		";
		$Resinv = "";
		if ($result = mysqli_query($conn, $sql)) {
			while ($row = mysqli_fetch_assoc($result)) {
				$Resinv = $row["Idtipotx"];
			}
		};

		$today = (new DateTime($_POST['FechaHastaproductos']))->format('Y-m-d');
		$LastDayOfMonth = ((new DateTime($_POST['FechaHastaproductos'])))->format('Y-m-t');
		$firstDayOfMonth = ((new DateTime($_POST['FechaHastaproductos'])))->format('Y-m-') . '01';


		$query = "SELECT DISTINCT a.CodIdAmpliado,a.CodIdBasico,a.CodBarra, a.Descripcion as Producto,b.IdAlm,
		GROUP_CONCAT(CONCAT(b.IdAlm, '|', b.Almacen , '|', b.Cantidad)) as Almacen , sum(b.Cantidad) as existencia, a.Medida as unidades,a.factorunit,c.esserial
		" . $cos . "
		" . $imp . "
		" . $cosexis . "
		" . $exis . "
		" . $prec . " " . $util . "
		FROM PosUpProducto a  
		left join (
			select
		bpre.IdCompany,
		bpre.CodIdBasico,
		bpre.IdAlm,
		c.Nombre as Almacen,
		sum(Cantidad) as Cantidad
			from (
				select
					f.IdCompany,
					f.CodIdBasico,
					f.IdAlm as IdAlm,
					sum(f.Cantidad) as Cantidad
				FROM
					posupproductostockmes f
				WHERE
					f.IdCompany =" . $_POST["CompanyActual"] . " and f.Periodo < DATE_FORMAT('" . $firstDayOfMonth . " 00:00:00', '%Y%m') 
					" . (!empty($_POST["mIdAlmacen"]) ? " and f.IdAlm in ('" . implode("','", $_POST["mIdAlmacen"]) . "')" : "") . "
				GROUP BY
					f.IdCompany,
					f.CodIdBasico,
					f.IdAlm
				UNION ALL
				select
					ba.IdCompany,
					ba.CodIdBasico,
					ba.IdAlm as IdAlm,
					sum(ba.Cant * (if(ba.Idtipotx in (" . $Suminv . "),1,0) + if(ba.Idtipotx in (" . $Resinv . "),-1,0))) as Cantidad
				from
					PosUpTxD ba
				where
					ba.IdCompany =" . $_POST["CompanyActual"] . "
					and ba.Fectxclient >= '" . $firstDayOfMonth . " 00:00:00' and ba.Fectxclient < '" . $_POST['FechaHastaproductos'] . " 23:59:59'
					" . (!empty($_POST["mIdAlmacen"]) ? " and ba.IdAlm in ('" . implode("','", $_POST["mIdAlmacen"]) . "')" : "") . " and ba.idtipotx in (" . $Operainv . ") 
				group by
					ba.IdCompany,
					ba.CodIdBasico,
					ba.IdAlm 
			) bpre
			inner join 
			PosUpAlmacen c on
			c.IdCompany = bpre.IdCompany
			and c.IdAlm = bpre.IdAlm
			and c.tipo <> 4
	group by
		IdCompany,
		CodIdBasico,
		IdAlm
		) b on
	a.IdCompany = b.IdCompany
	and a.CodIdBasico = b.CodIdBasico
	left join PosUpvarios c on a.IdCompany = c.IdCompany and a.Idfamilia = c.IdVarios and c.TIPOITEM = 2
	where a.IdCompany=" . $_POST["CompanyActual"] . " 
		and a.EsCompuesto=0  
		" . $beetween . "
		" . $ExistenciaCero . "                                       
		" . $Incluirlotes . "
		" . $Incluirimpuestos . "
		" . $Proevedor . "
		" . $Deposito2 . "
		" . $Marca . "
		" . $familia . "
		GROUP BY
			b.IdCompany,
			b.CodIdBasico
		" . $Orden . "
		" . $limit . "
		";
		if ($result = mysqli_query($conn, $query)) {
			$n = 0;
			$pro = 0;
			while ($row = mysqli_fetch_assoc($result)) {
				$n = $n + 1;
				$n2 = $n2 + 1;
				$pro = $pro + 1;
				$pro2 = $pro2 + 1;
				/*
				$queryB = "SELECT DISTINCT a.CodIdAmpliado,a.CodIdBasico,a.CodBarra, a.Descripcion as Producto,a.CostoNeto as Costo,
                a.PrecioVenta as PrecioVenta,
                round(coalesce(b.cantidad,0),2) as existencia, a.Medida as unidades,
                COALESCE(b.cantidad,0)*COALESCE(a.CostoNeto,0) as CostoExistencia,
                a.PrecioNeto as precio,
                coalesce((a.PrecioNeto-a.CostoNeto)/a.PrecioNeto*100,0) as Util
                FROM PosUpProducto a
                left join (SELECT a.IdCompany,a.IdAlm, b.CodIdBasico,sum(coalesce(a.Cant)*coalesce(d.Inventario)) as Cantidad FROM PosUpTxD a
                inner join PosUpProducto b on a.IdCompany=b.IdCompany and a.CodIdBasico=b.CodIdBasico
                inner join PosUpTx d on a.Idtipotx=d.Idtipotx and d.Inventario <> 0
                where a.IdAlm= " . $Deposito . " " . $fechaAA . "
                group by a.IdCompany,b.CodIdBasico
                ) b on a.IdCompany = b.IdCompany and a.CodIdBasico = b.CodIdBasico
                left join (SELECT a.IdCompany,a.RUT, b.idBen, c.CodIdBasico from PosUpclientes a
                inner join PosUpTxC b on a.IdCompany=b.IdCompany and a.RUT = b.idBen
                inner join PosUpTxD c on b.IdCompany =c.IdCompany and b.Idtipotx = c.Idtipotx and b.Idtx = c.Idtx and b.IdEstacion = c.IdEstacion 
                inner join PosUpTx d on b.Idtipotx = d.Idtipotx and d.Inventario <> 0 
                " . $fechaA . "
                group by a.IdCompany, a.RUT,c.CodIdBasico) c on a.IdCompany = c.IdCompany and a.CodIdBasico = c.CodIdBasico 
                where a.IdCompany=" . $_POST["CompanyActual"] . " and a.CodIdBasico= " . $row["CodIdBasico"] . " and a.EsCompuesto=0  " . $beetween . "
                " . $ExistenciaCero . "                                       
                " . $Incluirlotes . "
                " . $Incluirimpuestos . "
                " . $Proevedor . "
                " . $Deposito . "
                " . $Marca . "
                " . $familia . "
                " . $Orden . "
                " . $limit . "
            ";
			*/
		?>
				<div style="text-align: left; float:left; width: 100%;">
					<div class="campo" style=" text-align: left; width: 9%; ">
						<?php
						if (trim($row['CodBarra']) === "") {
							echo "-";
						} else {
							echo $row['CodBarra'];
						}
						?>
					</div>

					<div class="campo" style=" text-align: left; width: 9%; ">
						<?php
						if (trim($row['CodIdAmpliado']) === "") {
							echo "-";
						} else {
							echo $row['CodIdAmpliado'];
						}
						?>
					</div>
					<div class="campo" style=" text-align: left; width: 32%; ">
						<?php
						if (trim($row['Producto']) === "") {
							echo "-";
						} else {
							echo $row['Producto'];
						}
						?> </div>
					<?php
					if ($_POST['cos'] == true) {
					?>
						<div class="campo" style=" text-align: right; width: 7%; ">
							<?php
							if (trim($row['Costo']) === "") {
								echo "-";
							} else {
								echo number_format($row['Costo'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
							}
							?>
						</div>
					<?php
					}
					?>
					<?php
					if ($_POST['mexist'] == true) {
					?>
						<div class="campo" style=" text-align: right; width: 9%; ">
							<?php
							$exist = floatval($row["existencia"]);
							$factorunit = floatval($row["factorunit"]);
							$existfactor = $exist * $factorunit;
							if (trim($row['existencia']) === "") {
								echo "-";
							} else {
								echo ($factorunit <> 1 ? " " . $factorunit . " x " . getcantformat($exist, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " = " . getcantformat($existfactor, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])  : number_format($exist, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]));
							}
							?>
						</div>
						<div class="campo" style=" text-align: right; width: 3%; ">
							<?php
							if (trim($row['unidades']) === "") {
								echo "-";
							} else {
								echo $row['unidades'];
							}
							?>
						</div>
					<?php
					}
					?>

					<?php
					if ($_POST['cos'] == true and $_POST['mexist'] == true) {
					?>
						<div class="campo" style=" text-align: right; width: 8%; ">
							<?php
							if ($row['CostoExistencia'] == "") {
								echo "-";
							} else {
								echo number_format($row['CostoExistencia'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
							}
							?>
						</div>
					<?php
					}
					?>
					<?php
					if ($_POST["Incluirimpuestos"]) {
					?>
						<div class="campo" style=" text-align: right; width: 6%; ">
							<?php
							if ($row['precio'] == "") {
								echo "-";
							} else {
								echo number_format($row['precio'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
							}
							?>
						</div>
					<?php
					}
					?>
					<?php
					if ($_POST["Utilidad"]) {
					?>
						<div class="campo" style=" text-align: right; width: 6%; ">
							<?php
							if ($row['Util'] == "") {
								echo "-";
							} else {
								echo number_format($row['Util'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]);
							}
							?>
						</div>
					<?php
					}
					?>


				</div>
				<?php

				if ($_POST["Seriales"] == "on" && $row["esserial"] === "1") {
					$Almacenes = explode(",", $row["Almacen"]);
					foreach ($Almacenes as $value) {
						$alm = explode('|', $value);
						if ($alm[2] > 0) {
				?>

							<div class="campo" style=" text-align: left; width: 100%; ">
								<div style="font-weight:bold;"><?php echo $alm[1] . " (" . $alm[2] . ") "; ?></div>
								<div>
									<?php
									$query2 = "SELECT
												bpre.IdCompany,
												bpre.CodIdBasico,
												bpre.IdAlm,
												bpre.Seriales,
												sum(Cantidad) as Cantidad
													from (
														SELECT
															f.IdCompany,
															f.CodIdBasico,
															f.IdAlm as IdAlm,
															f.Seriales as Seriales,
															sum(f.Cantidad) AS Cantidad
														FROM
															posupproductostockmes f
														WHERE
															f.IdCompany =" . $_POST["CompanyActual"] . " and f.Periodo < DATE_FORMAT('" . $firstDayOfMonth . " 00:00:00', '%Y%m') 
															" . (!empty($_POST["mIdAlmacen"]) ? " and f.IdAlm in ('" . implode("','", $_POST["mIdAlmacen"]) . "')" : "") . "
														GROUP BY
															f.IdCompany,
															f.CodIdBasico,
															f.IdAlm,
															f.Seriales
														UNION ALL
														SELECT
															ba.IdCompany,
															ba.CodIdBasico,
															ba.IdAlm as IdAlm,
															ba.Seriales as Seriales,
															sum(ba.Cant * (if(ba.Idtipotx in (" . $Suminv . "),1,0) + if(ba.Idtipotx in (" . $Resinv . "),-1,0))) as Cantidad
														from
															PosUpTxD ba
														where
															ba.IdCompany =" . $_POST["CompanyActual"] . "
															and ba.Fectxclient >= '" . $firstDayOfMonth . " 00:00:00' and ba.Fectxclient < '" . $_POST['FechaHastaproductos'] . " 23:59:59'
															" . (!empty($_POST["mIdAlmacen"]) ? " and ba.IdAlm in ('" . implode("','", $_POST["mIdAlmacen"]) . "')" : "") . " and ba.idtipotx in (" . $Operainv . ") 
														group by
															ba.IdCompany,
															ba.CodIdBasico,
															ba.IdAlm,
															ba.Seriales
													) bpre 
													WHERE IdAlm = '" . $alm[0] . "' AND CodIdBasico = '" . $row["CodIdBasico"] . "'
													group by IdCompany, CodIdBasico, IdAlm, Seriales
													HAVING Cantidad > 0
												";
									if ($result2 = mysqli_query($conn, $query2)) {
										while ($row2 = mysqli_fetch_assoc($result2)) {
											echo " " . $row2["Seriales"];
										}
									}
									?>
								</div>
								<div class="encabezado" style="font-size: 2px;">
									<hr>
								</div>
							</div>

					<?php
						}
					}
				}

				if ($n >= 53) {
					?>


					<div class="encabezado" style="font-size: 2px;">
						<hr>
						<div class="campo" style=" visibility:hidden; text-align: left; width: 8%; background-color: white;">.</div>
						<div class="campo" style=" text-align: left; width: 24%; background-color: white;">
							<?php echo lang("Totales por Pagina Productos/Existencia/CostoExistencia"); ?>
						</div>

						<div class="campo" style=" text-align: left; width: 6%; background-color: white;">
							<?php echo $pro; ?>
						</div>

						<?php
						if ($_POST['cos'] == true and $_POST['mexist'] == true) {
						?>
							<div class="campo" style=" visibility: hidden; text-align: left; width: 18%; background-color: white;">.</div>
						<?php
						} else {
						?>
							<div class="campo" style=" visibility: hidden; text-align: left; width: 11%; background-color: white;">.</div>
						<?php
						}
						?>
						<?php
						if ($_POST['mexist'] == true) {
						?>
							<div class="campo" style="   text-align: right; width:  7%; background-color: white;">
								<?php echo number_format($ExistenciaTotal, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?>
							</div>
							<div class="campo" style=" visibility:hidden;  text-align: right; width: 6%; background-color: white;">
								<?php echo $unidadTotal; ?>
							</div>
						<?php
						}
						?>
						<?php
						if ($_POST['cos'] == true and $_POST['mexist'] == true) {
						?>
							<div class="campo" style="  text-align: right; width: 8%; background-color: white;">
								<?php echo number_format($CostoExistencia, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?>
							</div>
						<?php
						}
						?>
						<div class="campo" style=" visibility: hidden; text-align: right; width: 8%; background-color: white;">
							<?php echo number_format($CostoExistencia, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?>
						</div>
					</div>

					<div class="encabezado" style="font-size: 2px;">
						<hr>
					</div>
					<div class="campo" style=" visibility:hidden; text-align: left; width: 8%; background-color: white;">.</div>
					<div class="campo" style=" text-align: left; width: 24%; background-color: white;">
						<?php echo lang("Totales Acumulados Productos/Existencia/CostoExistencia"); ?>
					</div>

					<div class="campo" style=" text-align: left; width: 6%; background-color: white;">
						<?php echo $pro2; ?>
					</div>


					<?php
					if ($_POST['cos'] == true and $_POST['mexist'] == true) {
					?>
						<div class="campo" style=" visibility: hidden; text-align: left; width: 18%; background-color: white;">.</div>
					<?php
					} else {
					?>
						<div class="campo" style=" visibility: hidden; text-align: left; width: 11%; background-color: white;">.</div>
					<?php
					}
					?>

					<?php
					if ($_POST['mexist'] == true) {
					?>
						<div class="campo" style="   text-align: right; width:  7%; background-color: white;">
							<?php echo number_format($ExistenciaTotal2, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?>
						</div>
						<div class="campo" style=" visibility:hidden;  text-align: right; width: 6%; background-color: white;">.</div>
					<?php
					}
					?>
					<?php
					if ($_POST['cos'] == true and $_POST['mexist'] == true) {
					?>
						<div class="campo" style="  text-align: right; width: 8%; background-color: white;">
							<?php echo number_format($CostoExistencia2, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?>
						</div>
					<?php
					}
					?>
					<div class="campo" style=" visibility: hidden; text-align: right; width: 8%; background-color: white;">
						<?php echo number_format($CostoExistencia2, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?>
					</div>




					<div style="PAGE-BREAK-AFTER: always"></div>
					<div class="campo" style=" visibility: hidden; text-align: right; width: 8%; background-color: white;">
						<?php echo number_format($CostoExistencia2, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?>.</div>
					<div class="sup">
						<div style="float:left; width: 23%;">
							<div class="TituloEmpresa" id="Titulo">
								<?php echo $_POST["NameCompany"]; ?>
							</div>
							<div class="Subtituloempresa" id="Ubicacion">
								<?php echo $_POST["direccion"]; ?>
							</div>
							<div class="Subtituloempresa" id="Literal Fiscal">
								<?php echo $_POST["litfiscal"]; ?>-<?php echo $_POST["rute"]; ?>
							</div>
						</div>
						<div style="float:left; width: 54%;">
							<div class="TituloEmpresa" style="float: center; text-align: center;">
								<?php echo lang('Productos'); ?>
							</div>
							<div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
								<?php echo lang('Orden por'); ?>:<?php echo $_POST["Orden"]; ?>
								<?php
								if ($_POST["CodigoDesde"] == true) {
									echo " / " . lang("Desde el codigo") . ":" . $_POST["CodigoDesde"];
								}
								?>
								<?php
								if ($_POST["CodigoHasta"] == true) {
									echo lang("al") . " " . $_POST["CodigoHasta"];
								}
								?>
							</div>
							<div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
								<?php
								if ($_POST["Instancia2NK"] == true) {
									echo lang("De la Familia:") . " / " . $_POST["Instancia2NK"];
								}
								?>
							</div>
							<div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
								<?php
								if ($_POST["Proevedor2"] == true or $_POST["Marca2"] == true or $_POST["Deposito2NK"] == true) {
									echo "Con:";
								} else {
									echo "--------------------";
								}
								?>
								<?php
								if ($_POST["Proevedor2"] == true) {
									echo "Beneficiario:/" . $_POST["Proevedor2"];
								}
								?>
								<?php
								if ($_POST["Marca2"] == true) {
									echo " / Marca:" . $_POST["Marca2"];
								}
								?>
								<?php
								if ($_POST["Deposito2NK"] == true) {
									echo " / Almacen:" . $_POST["Deposito2NK"];
								}
								?> </div>
							<div class="Subtituloempresa" style="float: center; text-align: center; font-weight: 600; font-size: 12px;">
								<?php
								if ($_POST["Incluirimpuestos"] == "on" or $_POST["Referencia"] == "on" or $_POST["Incluirlotes"] == "on" or $_POST["ExistenciaCero"] == "on" or $_POST["Seriales"] == "on") {
									echo "Incluyendo:";
								} else {
									echo "--------------------";
								}
								?>
								<?php
								if ($_POST["Incluirimpuestos"] == "on") {
									echo " / " . lang("Impuestos") . "";
								}
								?>
								<?php
								if ($_POST["Incluirlotes"] == "on") {
									echo " / " . lang("Lotes") . "";
								}
								?>
								<?php
								if ($_POST["ExistenciaCero"] == "on") {
									echo " / Existencia 0";
								}
								?>
								<?php
								if ($_POST["Referencia"] == "on") {
									echo "/ " . lang("Referencia") . "";
								}
								?>
								<?php
								if ($_POST["Seriales"] == "on") {
									echo " / " . lang("Seriales") . "";
								}
								?>
							</div>
						</div>
						<div style="float:left; width: 23%;">
							<div class="FechaI"><span id="fectx">
									<?php echo $_POST["fectx5"]; ?>
								</span></div><br>
							<div class="FechaI">
								<div class="page"></div>
							</div><br>
							<div type='submit' value='export_data' class="FechaI"><img style="width: 30%;" src="img/AZUL.svg" /></div><br><br>
							<div class="FechaI">-</div>
						</div>
					</div>
					<div style=" width: 100%;">
						<div class="encabezado" style=" width: 100%;">
							<div class="campo" style=" text-align: left; width: 9%; background-color: gray;">
								<?php echo lang('Codigo Barra'); ?>
							</div>

							<div class="campo" style=" text-align: left; width: 9%; background-color: gray;">
								<?php echo lang('Codigo Ampliado'); ?>
							</div>

							<div class="campo" style=" text-align: left; width: 32%; background-color: gray;">
								<?php echo lang('Descripcion'); ?>
							</div>
							<?php
							if ($_POST['cos'] == true) {
							?>
								<div class="campo" style=" text-align: right; width: 7%; background-color: gray;">
									<?php echo lang('Costo unitario'); ?>
								</div>
							<?php
							}
							?>
							<?php
							if ($_POST['mexist'] == true) {
							?>
								<div class="campo" style=" text-align: right; width: 6%; background-color: gray;">
									<?php echo lang('Existencia'); ?> </div>
								<div class="campo" style=" text-align: right; width: 6%; background-color: gray;">
									<?php echo lang('Unidades'); ?> </div>

							<?php
							}
							?>
							<?php
							if ($_POST['cos'] == true and $_POST['mexist'] == true) {
							?>
								<div class="campo" style=" text-align: right; width: 8%; background-color: gray;">
									<?php echo lang('Costo Existencia'); ?> </div>
							<?php
							}
							?>
							<?php
							if ($_POST["Incluirimpuestos"] == "on") {
							?>
								<div class="campo" style=" text-align: right; width: 6%; background-color: gray;">
									<?php echo lang('Precio Venta'); ?> </div>
							<?php
							}
							?>

							<?php
							if ($_POST["Utilidad"] == "on") {
							?>
								<div class="campo" style=" text-align: right; width: 6%; background-color: gray;">
									<?php echo lang('%Util'); ?>
								</div>
							<?php
							}
							?>
						</div>
					</div>
		<?php
					$CostoExistencia = 0;
					$unidadTotal = 0;
					$ExistenciaTotal = 0;
					$n = 0;
					$pro = 0;
				}

				$CostoExistencia = $CostoExistencia + $row["CostoExistencia"]; //c
				$unidadTotal = $unidadTotal + $row["unidad"];
				$ExistenciaTotal = $ExistenciaTotal + $row["existencia"];
				$CostoExistencia2 = $CostoExistencia2 + $row["CostoExistencia"]; //c
				$unidadTotal2 = $unidadTotal2 + $row["unidad"];
				$ExistenciaTotal2 = $ExistenciaTotal2 + $row["existencia"];
			}
			mysqli_free_result($result);
		}
		?>

		<div class="encabezado" style="font-size: 2px;">
			<hr>
			<div class="campo" style=" visibility: hidden; text-align: left; width: 8%; background-color: white;">.</div>
			<div class="campo" style=" text-align: left; width: 24%; background-color: white;">
				<?php echo lang("Totales Productos/Existencia/CostoExistencia"); ?>
			</div>

			<div class="campo" style=" text-align: left; width: 6%; background-color: white;">
				<?php echo $pro; ?>
			</div>
			<?php
			if ($_POST['cos'] == true and $_POST['mexist'] == true) {
			?>
				<div class="campo" style=" visibility: hidden; text-align: left; width: 18%; background-color: white;">.</div>
			<?php
			} else {
			?>
				<div class="campo" style=" visibility: hidden; text-align: left; width: 11%; background-color: white;">.</div>
			<?php
			}
			?>
			<?php
			if ($_POST['mexist'] == true) {
			?>
				<div class="campo" style="   text-align: right; width:  7%; background-color: white;">
					<?php echo number_format($ExistenciaTotal, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?>
				</div>
				<div class="campo" style=" visibility:hidden;  text-align: right; width: 6%; background-color: white;">.</div>
			<?php
			}
			?>

			<?php
			if ($_POST['cos'] == true and $_POST['mexist'] == true) {
			?>
				<div class="campo" style="  text-align: right; width: 8%; background-color: white;">
					<?php echo number_format($CostoExistencia, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?>
				</div>
			<?php
			}
			?>
			<div class="campo" style=" visibility: hidden; text-align: right; width: 8%; background-color: white;">
				<?php echo number_format($CostoExistencia, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?>
			</div>
		</div>
		<div class="encabezado" style="font-size: 2px;">
			<hr>
			<div class="campo" style=" visibility:hidden; text-align: left; width: 8%; background-color: white;">.</div>
			<div class="campo" style=" text-align: left; width: 24%; background-color: white;">
				<?php echo lang("Totales Acumulados Productos/Existencia/CostoExistencia"); ?>
			</div>

			<div class="campo" style=" text-align: left; width: 6%; background-color: white;">
				<?php echo $pro2; ?>
			</div>

			<?php
			if ($_POST['cos'] == true and $_POST['mexist'] == true) {
			?>
				<div class="campo" style=" visibility: hidden; text-align: left; width: 18%; background-color: white;">.</div>
			<?php
			} else {
			?>
				<div class="campo" style=" visibility: hidden; text-align: left; width: 11%; background-color: white;">.</div>
			<?php
			}
			?>
			<?php
			if ($_POST['mexist'] == true) {
			?>
				<div class="campo" style="   text-align: right; width:  7%; background-color: white;">
					<?php echo number_format($ExistenciaTotal2, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?>
				</div>
				<div class="campo" style=" visibility:hidden;  text-align: right; width: 6%; background-color: white;">.</div>
			<?php
			}
			?>
			<?php
			if ($_POST['cos'] == true and $_POST['mexist'] == true) {
			?>
				<div class="campo" style="  text-align: right; width: 8%; background-color: white;">
					<?php echo number_format($CostoExistencia2, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?>
				</div>
			<?php
			}
			?>
			<div class="campo" style=" visibility: hidden; text-align: right; width: 8%; background-color: white;">
				<?php echo number_format($CostoExistencia2, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]); ?>
			</div>
		</div>



	</div>
	</div>

	<form id="formexcel" action="excelv3led.php" method="post">
		<?php
		$compa = $_POST["CompanyActual"];
		$name = "Productos.csv";
		?>
		<input type="hidden" name="registro" id="registro" value="<?php echo $pro2; ?>" />
		<input type="hidden" name="Qry" id="Qry" value="<?php echo $query; ?>" />
		<input type="hidden" name="Name" id="Name" value="<?php echo $name; ?>" />
		<input type="hidden" name="Company" id="Company" value="<?php echo $compa; ?>" />
		<input type="hidden" name="ser" id="ser" value="" />
	</form>
	<form id="formexcel2" action="excelv3led.php" method="post">
		<?php
		?>
		<?php
		$compa = $_POST["CompanyActual"];
		$name = "SerialesEnAlmacenes.csv";
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
		?>
		<?php
		$compa = $_POST["CompanyActual"];
		$name = "Seriales.csv";
		?>
		<input type="hidden" name="registro" id="registro" value="<?php echo $pro2; ?>" />
		<input type="hidden" name="Qry3" id="Qry3" value="<?php $queryA2 = urlencode(serialize($querySA2));
															echo $queryA2;       ?>" />
		<input type="hidden" name="Name" id="Name" value="<?php echo $name; ?>" />
		<input type="hidden" name="Company" id="Company" value="<?php echo $compa; ?>" />
		<input type="hidden" name="ser" id="ser" value="" />
	</form>


	<div style="PAGE-BREAK-AFTER: always; visibility: hidden;"></div>
	<script>
		const totalPages = document.querySelectorAll('.page').length;
		document.documentElement.style.setProperty('--total-pages', totalPages);
	</script>
</body>

</html>