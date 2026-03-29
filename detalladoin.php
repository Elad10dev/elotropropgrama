<?php

include "ambiente.php";
$conn = ConectarReport();
session_start();
if ($_SESSION['IdiomaActual'] === "") $_SESSION['IdiomaActual'] = $_POST['IdiomaActual'];

$fechaDES = $_POST["DesdeFechaX"];
$fechaHAS = $_POST["FechaHastaX"];
$companygrp = " = " . $_POST["CompanyActual"] . "  ";
if ($_POST['CIdPlan'] == '0000000019') {
	if ($_POST['IdCompanySelect'] == '' or $_POST['IdCompanySelect'] == $_POST["IdCompanyGrp"]) {
		$companygrp = " in (" . $_POST["CompanyActual"] . "," . $_POST["IdCompanyGrp"] . ") ";
	} else {
		$companygrp = " in (" . $_POST["IdCompanySelect"] . ") ";
	}
}
$AlmacenRESX = "";
if ($_POST["AlmacenRESX"] !== "*") {
	$queryAlma = "select IdAlm,Nombre FROM PosUpAlmacen WHERE IdCompany " . $companygrp . " and IdAlm=" . $_POST["AlmacenRESX"] . " ";
	if ($resultqueryAlma = mysqli_query($conn, $queryAlma)) {
		while ($rowqueryAlma = mysqli_fetch_assoc($resultqueryAlma)) {
			$AlmacenRESX .= lang("Almacen") . ":" . $rowqueryAlma["Nombre"];
		}
		mysqli_free_result($result);
	}
}
$Familias2asdX = "";
if ($_POST["Familias2asdX"] !== "*") {
	$queryAlma2 = " SELECT IdVarios,ITEM FROM PosUpvarios WHERE TIPOITEM=2 and IdCompany " . $companygrp . " and IdVarios=" . $_POST["Familias2asdX"] . " ";
	if ($resultqueryAlma2 = mysqli_query($conn, $queryAlma2)) {
		while ($rowqueryAlma2 = mysqli_fetch_assoc($resultqueryAlma2)) {
			$Familias2asdX .= " /" . lang("Familia") . ":" . $rowqueryAlma2["ITEM"];
		}
		mysqli_free_result($result2);
	}
}
$tipoTrans = "";
$detalle = "";

//if ($_POST["CodigoDesdeLPRESX"] !== "" or $_POST["CodigoHastaLPRESX"] !== "") $beetween = "and e.CodIdAmpliado between '" . $_POST["CodigoDesdeLPRESX"] . "' and '" . $_POST["CodigoHastaLPRESX"] . "' ";
if (!empty($_POST["mIdProductos"])) {
	$beetween = " and a.CodIdBasico in ('" . implode("','", $_POST["mIdProductos"]) . "') ";
}

if ($_POST["TransaccionX"] !== '*') $tipoTrans = " and a.Idtipotx = '" . trim($_POST["TransaccionX"]) . "'";

if (!empty($_POST["mIdAlmacen"])) {
	$almceFiltro = " and d.IdAlm in ('" . implode("','", $_POST["mIdAlmacen"]) . "')";
	$almceFiltro2 = " and a.IdAlm in ('" . implode("','", $_POST["mIdAlmacen"]) . "')";
}

if (!empty($_POST["mIdfamilia"])) {
	$familia = " and a.Idfamilia in ('" . implode("','", $_POST["mIdfamilia"]) . "') ";
	$familia2 = " and e.Idfamilia in ('" . implode("','", $_POST["mIdfamilia"]) . "') ";
}
if (!empty($_POST["mIdMarca"])) {
	$marca = " and e.Marca in ('" . implode("','", $_POST["mIdMarca"]) . "')";
}
if ($_POST["OrdenRESX"] === "1") $OrdenBy = " Order by a.Fectxclient,d.CodIdBasico ASC";
if ($_POST["OrdenRESX"] === "2") $OrdenBy = " order by a.Fectxclient,d.Descripcion ASC";
$fec1 = $_POST["DesdeFechaX"];
$fec2 = $_POST["FechaHastaX"];
if ($_POST["ProductosInvX"] === "on") $ConInv = " having Cant>0 ";
if (!$_POST["ProductosMovX"] === "on") $ConMov = " and Cant<>0 ";
$n = 0;
// $query = "SELECT DISTINCT e.CodIdAmpliado,e.CodIdBasico,d.Fectxclient, sum(d.Cant*f.Inventario) as Cant,
// 	g.Nombre,e.Descripcion,e.CodBarra
// 	FROM PosUpTxC a 
// 	left join PosUpTxD d on a.IdCompany = d.IdCompany and a.Idtipotx = d.idtipotx and a.Idtx = d.Idtx and a.IdEstacion = d.IdEstacion 
// 	left join PosUpProducto e on a.IdCompany = e.IdCompany and d.CodIdBasico = e.CodIdBasico 
// 	inner Join PosUpTx f on a.Idtipotx=f.Idtipotx 
// 	inner join PosUpAlmacen g on d.IdAlm = g.IdAlm and d.IdCompany = g.IdCompany 
// 	where a.IdCompany " . $companygrp . " and a.Fectxclient between '" . $fec1 . " 00:00:00' and '" . $fec2 . " 23:59:59' 
// 	and e.EsCompuesto=0 and f.Inventario<>0 " . $almceFiltro . " " . $familia2 . $tipoTrans . $ConMov . $beetween . $marca . "  
// 	group by d.CodIdBasico " . $ConInv . " Order by a.Fectxclient,d.CodIdBasico ASC";
$query = "SELECT DISTINCT e.CodIdAmpliado,a.CodIdBasico,a.Fectxclient, sum(a.Cant*f.Inventario) as Cant,e.factorunit,
 	g.Nombre,e.Descripcion,e.CodBarra
 	FROM PosUpTxD a 
 	inner join PosUpTx f on a.Idtipotx=f.Idtipotx 
		left join PosUpProducto e on a.IdCompany = e.IdCompany and a.CodIdBasico = e.CodIdBasico 
	inner join PosUpAlmacen g on g.IdAlm = a.IdAlm and a.IdCompany = g.IdCompany 
	where a.IdCompany " . $companygrp . " and a.Fectxclient between '" . $fec1 . " 00:00:00' and '" . $fec2 . " 23:59:59' 
	and e.EsCompuesto=0 and f.Inventario<>0 " . $almceFiltro2 . " " . $familia2 . $tipoTrans . $ConMov . $beetween . $marca . "  
	group by a.CodIdBasico " . $ConInv . " Order by a.Fectxclient,a.CodIdBasico ASC";
//echo $query;
if ($result = mysqli_query($conn, $query)) {
	while ($row = mysqli_fetch_assoc($result)) {
		$n += 4;
		$invIni = 0;
		$desg = 0;
		$entUni1 = 0;
		$entUni2 = 0;
		$query3 = "SELECT coalesce(sum(d.Cant * f.Inventario),0) as InvInicial,e.CantP1,e.UnidadP1,e.CantP2,e.UnidadP2, e.Medida as medida,e.factorunit from PosUpTxC a 
		left join PosUpUsers b on a.IdUser = b.login and a.IdcompanyUser=b.IdCompany 
		left join PosUpTxD d on a.IdCompany = d.IdCompany and a.Idtipotx = d.idtipotx and a.Idtx = d.Idtx and a.IdEstacion = d.IdEstacion 
		left join PosUpProducto e on a.IdCompany = e.IdCompany and d.CodIdBasico = e.CodIdBasico 
		inner Join PosUpTx f on a.Idtipotx=f.Idtipotx 
		inner join PosUpAlmacen g on d.IdAlm = g.IdAlm and d.IdCompany = g.IdCompany 
		LEFT join PosUpclientes h on a.IdCompany=h.IdCompany and a.IdBen=h.RUT 
		where a.IdCompany " . $companygrp . " and a.Fectxclient <='" . $fec1 . " 00:00:00'
		and e.CodIdBasico='" . $row["CodIdBasico"] . "' and e.EsCompuesto=0 and f.Inventario<>0  " . $almceFiltro . " " . $tipoTrans . " " . $ConMov . "
		group by d.IdCompany ";
		if ($result3 = mysqli_query($conn, $query3)) {
			while ($row3 = mysqli_fetch_assoc($result3)) {
				$invIni = $row3['InvInicial'];
				$medida = $row3['medida'];
				$desg = $row3['CantP1'];
				$desg2 = $row3['UnidadP1'];
				$entUni1 = intval($row3['InvInicial']);
				$entUni2 = round(($row3['InvInicial'] - intval($row3['InvInicial'])) * $row3['CantP1']);
				$efactorunit = $row3["factorunit"];
			}
		}

		// if ($invIni === 0) {
		// 	$query4 = "SELECT coalesce(sum(d.Cant * f.Inventario),0) as InvInicial,e.CantP1,e.UnidadP1,e.CantP2,e.UnidadP2, e.Medida as medida from PosUpTxC a 
		// 	left join PosUpUsers b on a.IdUser = b.login and a.IdcompanyUser=b.IdCompany 
		// 	left join PosUpTxD d on a.IdCompany = d.IdCompany and a.Idtipotx = d.idtipotx and a.Idtx = d.Idtx and a.IdEstacion = d.IdEstacion 
		// 	left join PosUpProducto e on a.IdCompany = e.IdCompany and d.CodIdBasico = e.CodIdBasico 
		// 	inner Join PosUpTx f on a.Idtipotx=f.Idtipotx 
		// 	inner join PosUpAlmacen g on d.IdAlm = g.IdAlm and d.IdCompany = g.IdCompany 
		// 	LEFT join PosUpclientes h on a.IdCompany=h.IdCompany and a.IdBen=h.RUT 
		// 	where a.IdCompany " . $companygrp . " 
		// 	and e.CodIdBasico='" . $row["CodIdBasico"] . "' and e.EsCompuesto=0 and f.Inventario<>0  " . $almceFiltro . " " . $tipoTrans . " " . $ConMov . "
		// 	group by d.IdCompany ";

		// 		if ($result4 = mysqli_query($conn, $query4)) {
		// 			while ($row4 = mysqli_fetch_assoc($result4)) {
		// 				$invIni = 0;
		// 				$medida = $row4['medida'];
		// 				$desg = $row4['CantP1'];
		// 				$desg2 = $row4['UnidadP1'];
		// 				$entUni1 = intval(0);
		// 				$entUni2 = round((0 - intval(0)) * $row4['CantP1']);
		// 			}
		// 			
		// 		}
		// }
		$query2 = "SELECT DISTINCT if(if(a.Idtipotx in (1,2,3,4,5,6,11,12,13,15,21,22,23,24,25,26,31,35,36,37),ee.NumTxViewVTA,if(a.Idtipotx in (7,14,20,27,28),ee.NumTxViewCOM,if(a.Idtipotx in (8,9,10,16,17,18,19,29,30,32,33,34,39),ee.NumTxViewINV,''))) = 0,a.IdtxCompany,if(if(a.Idtipotx in (1,2,3,4,5,6,11,12,13,15,21,22,23,24,25,26,31,35,36,37),ee.NumTxViewVTA,if(a.Idtipotx in (7,14,20,27,28),ee.NumTxViewCOM,if(a.Idtipotx in (8,9,10,16,17,18,19,29,30,32,33,34,39),ee.NumTxViewINV,''))) = 1,a.Idtx,a.Referencia)) as IdtxDef,e.CodBarra,a.Fectxclient as Fectxclient ,f.TitCto as NombreTransaccion, 
		IF(trim(a.Referencia)='',if (a.DTE=0,if (a.IdTxCompany<>0,a.IdTxCompany,a.Idtx),a.DTE),a.Referencia ) as Referencia , a.DTE,
		coalesce(sum(d.Cant * f.Inventario),0) as Movimiento, concat(a.IdBen,'-',h.Nombre) as Beneficiario,e.factorunit,
		e.Descripcion,a.IdUser as Usuario,d.cant,
		e.medida as uniP1,truncate(d.cant,0)* f.Inventario as cuniP1d,e.medida as uniP1d,
		round(e.CantP1 * (d.cant-truncate(d.cant,0)),0)* f.Inventario as cuniP2d,e.UnidadP1 as uniP2d,e.CantP1,a.DAmpliado,
		concat('(',d.IdAlm,')',g.Nombre) as Deposito,d.Seriales 
		from PosUpTxC a left join PosUpUsers b on a.IdUser = b.login and a.IdcompanyUser=b.IdCompany 
		left join PosUpCompany ee on ee.Id=a.IdCompany
		left join PosUpTxD d on a.IdCompany = d.IdCompany and a.Idtipotx = d.idtipotx and a.Idtx = d.Idtx and a.IdEstacion = d.IdEstacion 
		left join PosUpProducto e on a.IdCompany = e.IdCompany and d.CodIdBasico = e.CodIdBasico 
		inner Join PosUpTx f on a.Idtipotx=f.Idtipotx inner join PosUpAlmacen g on d.IdAlm = g.IdAlm and d.IdCompany = g.IdCompany 
		LEFT join PosUpclientes h on a.IdCompany=h.IdCompany and a.IdBen=h.RUT 
		where a.IdCompany " . $companygrp . " and a.Fectxclient between '" . $fec1 . " 00:00:00' and '" . $fec2 . " 23:59:59'
		and e.CodIdBasico='" . $row["CodIdBasico"] . "'
		and e.EsCompuesto=0 and f.Inventario<>0  and Cant<>0  " . $almceFiltro . " " . $tipoTrans . " " . $ConMov . " 
		group by d.Idtipotx,d.Idtx,d.IdEstacion,d.IdCompany,d.IdAlm,d.CodIdBasico 
		Order by a.Fectxclient,d.CodIdBasico,coalesce(sum(d.Cant * f.Inventario),0) ASC";

		$detalle .= "
			<div class='row' style='text-align: left; width: 100%;'>
				<div class='campo' style='text-align: left; width: 42%;'> <strong>" . ($row['CodBarra'] !== "" ? $row['CodBarra'] : "-") . " - " . ($row['Descripcion'] !== "" ? $row['Descripcion'] : "-") . "</strong></div>
				<div class='campo' style='text-align: left; width: 14%;'><strong>(1 " . $medida . " " . ($desg <> $desg2 ? ' = ' . $desg . ' ' . $desg2 : "") . ")</strong></div>
				<div class='campo' style='text-align: right; width: 17.5%'>" . lang("Inventario Inicial") . " " . lang("Al") . " " . $fec1 . " </div>
				<div class='campo' style='text-align: right; width: 10%;'><strong>" . number_format($invIni, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . '</strong> (' . $medida . ')' . "
				" . ($efactorunit <> 1 ? " " . $efactorunit . " x " . getcantformat($invIni, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " = " . getcantformat($invIni * $efactorunit, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $medida : number_format($invIni, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' (' . $medida . ')') . "</div>
				<div class='campo' style='text-align: right; width: 10%;'>" . ($entUni1 !== 0 ? number_format($entUni1, 0, $_POST["SimDec"], $_POST["SimMil"]) : "") . " " . ($medida !== "" and $entUni1 <> 0  ? '(' . substr($medida, 0, 3) . ')' : "") . ($entUni2 <> 0 and $entUni1 <> 0 ? ' y ' : "") . ($entUni2 !== 0 ? number_format($entUni2, 0, $_POST["SimDec"], $_POST["SimMil"]) : "") . ($desg2 !== "" ? '(' . substr($desg2, 0, 3) . ')' : "") . " </div>
			</div>
			<div class='row' style='width: 100%;'> 
				<div class='campo' style='text-align: left; width: 11%; background-color: gray;'>" . lang("Fecha") . "</div>
				<div class='campo' style='text-align: left; width: 8%; background-color: gray;'>" . lang("Tipo") . "</div>
				<div class='campo' style='text-align: left; width: 4%; background-color: gray;'>" . lang("Referencia") . "</div>
				<div class='campo' style='text-align: left; width: 20%; background-color: gray;'>" . lang("Beneficiario") . "</div>
				<div class='campo' style='text-align: left; width: 7%; background-color: gray;'>" . lang("Usuario") . "</div>
				<div class='campo' style='text-align: left; width: 23%; background-color: gray;'>" . lang("Depósito") . "</div>
				<div class='campo' style='text-align: right; width: 10%; background-color: gray;'>" . lang("Movimiento") . "</div>
				<div class='campo' style='text-align: right; width: 10%; background-color: gray;'>" . lang("Desglose") . "</div>
				" . ($_POST["SerialesZZ"] === "on" ? "<div class='campo' style='text-align: right; width: 11%; background-color: gray;'>" . lang("Seriales") . " </div>" : "") . "
			</div>
			<div class='row' style='text-align: left; width: 100%;'>
		";

		if ($result2 = mysqli_query($conn, $query2)) {
			while ($row2 = mysqli_fetch_assoc($result2)) {
				$querySA[] = $row2;
				$n += 1;
				$nt += 1;
				$nt2 += 1;
				$cant = $cant + $row2["Movimiento"];
				$factorunit = $row2["factorunit"];
				$detalle .= "
					<div class='row' style='text-align: left; width: 100%;'>
						<div class='campo' style='text-align: left; width: 11%;'>" . ($row2['Fectxclient'] !== "" ? $row2['Fectxclient'] : "-") . "</div>
						<div class='campo' style='text-align: left; width: 8%;'><strong>" . ($row2['NombreTransaccion'] !== "" ? $row2['NombreTransaccion'] . '-' : "-") . "</strong>  " . ($row2['IdtxDef'] !== "0" ? str_pad($row2['IdtxDef'], 6, "0", STR_PAD_LEFT) : "-") . "</div>
						<div class='campo' style='text-align: left; width: 4%;'>" . ($row2['Referencia'] !== "" ? $row2['Referencia'] : "-") . "</div>
						<div class='campo' style='text-align: left; width: 20%;'>" . ($row2['Beneficiario'] !== "" ? $row2['Beneficiario'] : "-") . " " . ($row2['DAmpliado'] !== "" ? "<br><div style='text-align: left; width: 100%; background-color: gray; font-weight: bold;'>" . ($row2['DAmpliado']) . "</div>" : "") . "</div>
						<div class='campo' style='text-align: left; width: 7%;'>" . ($row2['Usuario'] !== "" ? $row2['Usuario'] : "-") . "</div>
						<div class='campo' style='text-align: left; width: 23%;'>" . ($row2['Deposito'] !== "" ? $row2['Deposito'] : "-") . "</div>
						<div class='campo' style='text-align: right; width: 10%;'>
						" . ($row2["factorunit"] <> 1 ? " " . $row2["factorunit"] . " x " . getcantformat($row2["Movimiento"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " = " . getcantformat($row2["Movimiento"] * $row2["factorunit"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $row2["uniP1d"] : ($row2['Movimiento'] !== "" ? number_format($row2['Movimiento'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : "-") . " " . ($row2['uniP1d'] !== "" ? $row2["uniP1d"] : "-")) . "
						</div>
						<div class='campo' style='text-align: right; width: 10%;'>" . ($row2['cuniP1d'] <> 0 && $row2['cuniP1d'] !== "" ? number_format($row2['cuniP1d'], 0, $_POST["SimDec"], $_POST["SimMil"]) : "-") . " " . ($row2['uniP1d'] !== "" ? '(' . substr($row2['uniP1d'], 0, 3) . ')' : "") . ($row2['cuniP2d'] <> 0 and $row2['cuniP1d'] <> 0 ? ' y ' : "") . " " . ($row2['cuniP2d'] <> 0 && $row2['cuniP2d'] !== "" ? number_format($row2['cuniP2d'], 0, $_POST["SimDec"], $_POST["SimMil"]) : "-") . " " . ($row2['uniP2d'] !== "" ? '(' . substr($row2['uniP2d'], 0, 3) . ')' : "") . "</div>
						" . ($_POST["SerialesZZ"] === "on" ? "<div class='campo' style='text-align: right; width: 11%;'>" . ($row2['Seriales'] !== "" ? $row2['SerialesA'] : "-") . " </div>" : "") . "
						</div>
				";
				$acd = $row2['cuniP2d'];
				if ($n >= 47) {
					$detalle .= "
					<div class='row' style='font-size: 2px; width: 100%;'><hr></div>
					<div style='PAGE-BREAK-AFTER: always'></div>
					<div class='row' style='text-align: left; width: 100%;'>
						<div class='campo' style='visibility:hidden; text-align: right; width: 100%;'></div> 
					</div>  
					<div class='row' style='width: 100%;'>
						<div class='row' style='width: 23%; flex: 0 0 auto;'>
							<div class='TituloEmpresa' id='Titulo'>" . $_POST["NameCompany"] . "</div>
							<div class='Subtituloempresa' id='Ubicacion'>" . $_POST["direccion"] . "</div>
							<div class='Subtituloempresa' id='Literal Fiscal'>" . $_POST["litfiscal"] . "-" . $_POST["rute"] . "</div>
						</div>
						<div class='row' style='width: 53%; flex: 0 0 auto;'>
							<div class='TituloEmpresa' style='text-align: center;'>" . lang("Movimiento de Inventario Detallado") . "</div>
							<div class='Subtituloempresa' style='text-align: center; font-weight: 600;'>" . lang("Orden por") . ":" . ($_POST["OrdenRESX"] === "1" ? lang("CodIdBasico") : ($_POST["OrdenRESX"] === "2" ? lang("Descripcion") : ($_POST["OrdenRESX"] === "3" ? lang("Cantidad de Inventario") : ($_POST["OrdenRESX"] === "4" ? lang("Monto de Inventario") : ($_POST["OrdenRESX"] === "5" ? lang("Mayor Utilidad") : ($_POST["OrdenRESX"] === "6" ? lang("Mayor Venta") : "")))))) . "</div>
							<div class='Subtituloempresa' style='text-align: center; font-weight: 600;'> " . ($_POST["CodigoDesdeLPRESX"] === true ? lang("Desde el Codigo") . ":/" . $_POST["CodigoDesdeLPRESX"] : "") . " " . ($_POST["CodigoHastaLPRESX"] === true ? lang("Hasta al Codigo") . ":/" . $_POST["CodigoHastaLPRESX"] : "") . "</div>
							<div class='Subtituloempresa' style='text-align: center; font-weight: 600;'>" . ($_POST["DesdeFechaX"] === true ? $fechaDES . " // " : "") . " " . ($_POST["FechaHastaX"] === true ? $fechaHAS : "") . "</div>
							<div class='Subtituloempresa' style='text-align: center; font-weight: 600;'>" . ($_POST["Familias2asdX"] !== "*" || $_POST["AlmacenRESX"] !== "*" ? lang("Filtrado por") . ":/" : "--------------------") . $AlmacenRESX . " " . $Familias2asdX . "</div>
							<div class='Subtituloempresa' style='text-align: center; font-weight: 600;'>" . ($_POST["ProductosInvX"] === "on" or $_POST["ProductosMovX"] === "on" ? lang("Incluyendo") . ":" : "--------------------") . " " . ($_POST["ProductosInvX"] === "on" ? " / " . lang("Productos con Inventario") . " " : "") . " " . ($_POST["ProductosMovX"] === true ? "/" . lang("Productos sin Movimiento") : "") . " </div>
						</div>
						<div class='row' style='width: 23%; flex: 0 0 auto;'>
							<div class='FechaI'>
							<div><span id='fectx'>" . $_POST["fectx5"] . "</span></div>
								<div class='page'></div>
							<div><img style='width: 30%;' src='img/AZUL.svg' /></div>
							<div>-</div>
							</div>
						</div>
					</div>

					<div class='row' style='text-align: left; width: 100%;'>
						<div class='campo' style='text-align: left; width: 44%; font-size:13px;'> <strong>" . ($row['CodBarra'] !== "" ? $row['CodBarra'] : "") . " - " . ($row['Descripcion'] !== "" ? $row['Descripcion'] : "") . "</strong></div>
						<div class='campo' style='visibility:hidden; text-align: left; width: 1%; background-color: gray;'>Codigo</div>
						<div class='campo' style='visibility:hidden; text-align: left; width: 1%; background-color: gray;'>Codigo</div>
						<div class='campo' style='visibility:hidden; text-align: left; width: 1%; background-color: gray;'>Codigo</div>
					</div>
					<div class='row' style='width: 100%;'> 
						<div class='campo' style='text-align: left; width: 11%; background-color: gray;'>" . lang("Fecha") . "</div>
						<div class='campo' style='text-align: left; width: 8%; background-color: gray;'>" . lang("Tipo") . "</div>
						<div class='campo' style='text-align: left; width: 4%; background-color: gray;'>" . lang("Referencia") . "</div>
						<div class='campo' style='text-align: left; width: 20%; background-color: gray;'>" . lang("Beneficiario") . "</div>
						<div class='campo' style='text-align: left; width: 7%; background-color: gray;'>" . lang("Usuario") . "</div>
						<div class='campo' style='text-align: left; width: 23%; background-color: gray;'>" . lang("Depósito") . "</div>
						<div class='campo' style='text-align: right; width: 10%; background-color: gray;'>" . lang("Movimiento") . "</div>
						<div class='campo' style='text-align: right; width: 10%; background-color: gray;'>" . lang("Desglose") . "</div>
						" . ($_POST["SerialesZZ"] === "on" ? "<div class='campo' style='text-align: right; width: 11%; background-color: gray;'>" . lang("Seriales") . " </div>" : "") . "
					</div>
					";
					$CostoExistencia = 0;
					$unidadTotal = 0;
					$ExistenciaTotal = 0;
					$n = 0;
					$nt = 0;
				}
				$unidad = $row2["uniP1d"];
			}
			mysqli_free_result($result2);
		}

		$detalle .= "
			<div class='row' style='font-size: 2px; width: 100%;'><hr></div></div>
			<div class='row' style='text-align: left; width: 100%;'>
			<div class='campo' style='visibility:hidden;  text-align: left; width: 42%; font-size:12px;'>.</div>
			<div class='campo' style='visibility:hidden; text-align: left; width: 14%;'>.</div>
			<div class='campo' style='text-align: right; width:  17.5%;'>" . lang("Movimiento Total") . " </div>
			<div class='campo' style='text-align: right; width: 10%; background-color: white;'>
			" . ($factorunit <> 1 ? " " . $factorunit . " x " . getcantformat($cant, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " = " . getcantformat($cant * $factorunit, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $unidad : number_format($cant, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' (' . $unidad . ')') . "
			</div>
		";

		if ($desg === 0) $acd = $desg;

		$entUni1T = intval($cant);
		$entUni2T = round(($cant - intval($cant)) * $desg);
		$finally = $cant + $invIni;
		$detalle .= "
			<div class='campo' style='text-align: right; width: 10%;'>" . ($entUni1T <> 0 && $entUni1T !== "" ? number_format($entUni1T, 0, $_POST["SimDec"], $_POST["SimMil"]) : "-") . " " . ($medida !== "" ? '(' . substr($medida, 0, 3) . ')' : "") . ($entUni2T > 0 and $entUni1T <> 0 ? ' y ' : "") . " " . ($entUni2T <> 0 && $entUni2T !== "" ? number_format($entUni2T, 0, $_POST["SimDec"], $_POST["SimMil"]) : "-") . " " . ($desg2 !== "" ? '(' . substr($desg2, 0, 3) . ')' : "") . "</div>
			</div>
			<div class='row' style='text-align: left; width: 100%; '>
			<div class='campo' style='visibility:hidden;  text-align: left; width: 42%; font-size:12px;'>.</div>
			<div class='campo' style='visibility:hidden; text-align: left; width: 14%;'>.</div>
			<div class='campo' style='text-align: right; width: 17.5%;'>" . lang("Inventario Final") . " " . $acd . ' ' . lang("Al") . ' ' . $fec2 . " </div>
			<div class='campo' style='text-align: right; width: 10%; background-color: white;'>" . ($factorunit <> 1 ? " " . $factorunit . " x " . getcantformat($finally, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " = " . getcantformat($finally * $factorunit, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $unidad : number_format($finally, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' (' . $unidad . ')') . "</div>
			";

		$entUni1f = intval($finally);
		$entUni2f = round(($finally - intval($finally)) * $desg);
		$detalle .= "
			<div class='campo' style='text-align: right; width: 10%;'>" . ($entUni1f <> 0 && $entUni1f !== "" ? number_format($entUni1f, 0, $_POST["SimDec"], $_POST["SimMil"]) : "-") . " " . ($medida !== "" ? '(' . substr($medida, 0, 3) . ')' : "") . ($entUni2f > 0 and $entUni1f <> 0 ? ' y ' : "") . " " . ($entUni2f <> 0 && $entUni2f !== "" ? number_format($entUni2f, 0, $_POST["SimDec"], $_POST["SimMil"]) : "-") . " " . ($desg2 !== "" ? '(' . substr($desg2, 0, 3) . ')' : "") . "</div>
			</div>
			<div class='row' style='text-align: left; width: 100%;'>
			<div class='campo' style='visibility:hidden; text-align: right; width: 100%;'>a</div> 
			</div>
		";
	}
	mysqli_free_result($result);
}
$UltimoRegistro = $row["CodIdBasico"];
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
	<title><?php echo lang("Movimiento de Inventario Detallado"); ?></title>
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
		width: 100%;
	}

	.TituloEmpresa {
		font-weight: 600;
		font-size: 16.4px;
		text-align: left;
		width: 100%;
	}

	.Subtituloempresa {
		font-size: 9.3px;
		text-align: left;
		width: 100%;
	}

	.FechaI {
		font-size: 10px;
		text-align: right;
		width: 100%;
	}

	.page::before {
		counter-increment: page-counter 1;
		font-size: 10px;

		content: "Pagina " counter(page-counter) " de " counter(total-pages);
		align-content: right;
	}

	.campo {
		margin-right: 3px;
		font-size: 11px;
	}

	.registro {
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
		display: block;
		margin-left: 5px;
		margin-right: 5px;
	}

	.TituloR {
		background-color: gray;
	}

	.row {
		display: flex;
		flex-wrap: wrap;

	}
</style>

<body>
	<button type='submit' class='ocultoimpresion ' onclick='window.print();'><img src='/img/pdf.png' width='28' height='28'><br>PDF</button>
	<button class='ocultoimpresion ' onclick='document.getElementById(`formexcel2`).submit()'><img src='/img/excel.png' width='28' height='28'><br><?php echo lang("Detallado"); ?><br></button>
	<div class="pagina" style="font-size: 12px !important;">
		<div class="row" style='width: 100%;'>
			<div class="row" style="width: 23%; flex: 0 0 auto;">
				<div class="TituloEmpresa" id="Titulo"><?php echo $_POST["NameCompany"]; ?></div>
				<div class="Subtituloempresa" id="Ubicacion"><?php echo $_POST["direccion"]; ?></div>
				<div class="Subtituloempresa" id="Literal Fiscal"><?php echo $_POST["litfiscal"]; ?>-<?php echo $_POST["rute"]; ?></div>
			</div>
			<div class="row" style="width: 53%; flex: 0 0 auto;">
				<div class="TituloEmpresa" style="text-align: center;"><?php echo lang("Movimiento de Inventario Detallado"); ?></div>
				<div class="Subtituloempresa" style="text-align: center; font-weight: 600;"><?php echo lang("Orden por") . ":" . ($_POST["OrdenRESX"] === "1" ? lang("CodIdBasico") : ($_POST["OrdenRESX"] === "2" ? lang("Descripcion") : ($_POST["OrdenRESX"] === "3" ? lang("Cantidad de Inventario") : ($_POST["OrdenRESX"] === "4" ? lang("Monto de Inventario") : ($_POST["OrdenRESX"] === "5" ? lang("Mayor Utilidad") : ($_POST["OrdenRESX"] === "6" ? lang("Mayor Venta") : "")))))); ?></div>
				<div class="Subtituloempresa" style="text-align: center; font-weight: 600;"> <?php echo ($_POST["CodigoDesdeLPRESX"] === true ? lang("Desde el Codigo") . ":/" . $_POST["CodigoDesdeLPRESX"] : "") . " " . ($_POST["CodigoHastaLPRESX"] === true ? lang("Hasta al Codigo") . ":/" . $_POST["CodigoHastaLPRESX"] : ""); ?></div>
				<div class="Subtituloempresa" style="text-align: center; font-weight: 600;"><?php echo ($_POST["DesdeFechaX"] === true ? $fechaDES . " // " : "") . " " . ($_POST["FechaHastaX"] === true ? $fechaHAS : ""); ?></div>
				<div class="Subtituloempresa" style="text-align: center; font-weight: 600;"><?php echo ($_POST["Familias2asdX"] !== "*" || $_POST["AlmacenRESX"] !== "*" ? lang("Filtrado por") . ":/" : "--------------------") . $AlmacenRESX . " " . $Familias2asdX; ?></div>
				<div class="Subtituloempresa" style="text-align: center; font-weight: 600;"><?php echo ($_POST["ProductosInvX"] === "on" or $_POST["ProductosMovX"] === "on" ? lang("Incluyendo") . ":" : "--------------------") . " " . ($_POST["ProductosInvX"] === "on" ? " / " . lang("Productos con Inventario") . " " : "") . " " . ($_POST["ProductosMovX"] === true ? "/" . lang("Productos sin Movimiento") : ""); ?> </div>
			</div>
			<div class="row" style="width: 23%; flex: 0 0 auto;">
				<div class="FechaI">
					<div><span id="fectx"><?php echo $_POST["fectx5"]; ?></span></div>
					<div class="page"></div>
					<div><img style="width: 30%;" src="img/AZUL.svg" /></div>
					<div>-</div>
				</div>
			</div>
		</div>
		<?php echo $detalle; ?>
		<div class="row" style="font-size: 2px; width: 100%;">
			<hr>
			<div class="campo" style=" visibility: hidden; text-align: left; width: 9%; background-color: white;">Troductos</div>
			<div class="campo" style=" text-align: right; width: 24%; background-color: white;"><?php echo lang("Registros por Pagina"); ?></div>
			<div class="campo" style=" text-align: left; width: 6%; background-color: white;"><?php echo $nt ?></div>
			<div class="campo" style=" text-align: right; width: 24%; background-color: white;"><?php echo lang("Registros Acumulados"); ?></div>
			<div class="campo" style=" text-align: left; width: 6%; background-color: white;"><?php echo $nt2 ?></div>
		</div>
	</div>

	<form id="formexcel2" action="excelnew.php" method="post">
		<?php
		$compa = $_POST["CompanyActual"];
		$name = lang("MovimientoDetallado");
		$queryz = "SELECT DISTINCT e.CodBarra,a.Fectxclient as Fectxclient ,f.TitCto as NombreTransaccion, 
        IF(trim(a.Referencia)='',if (a.DTE=0,if (a.IdTxCompany<>0,a.IdTxCompany,a.Idtx),a.DTE),a.Referencia ) as Referencia , 
        coalesce(sum(d.Cant * f.Inventario),0) as Movimiento, concat(a.IdBen,'-',h.Nombre) as Beneficiario, 
        e.Descripcion,a.IdUser as Usuario,d.cant,
        e.medida as uniP1,truncate(d.cant,0)* f.Inventario as cuniP1d,e.medida as uniP1d,
        round(e.CantP1 * (d.cant-truncate(d.cant,0)),0)* f.Inventario as cuniP2d,e.UnidadP1 as uniP2d,e.CantP1,
        concat('(',d.IdAlm,')',g.Nombre) as Deposito,d.Seriales 
        from PosUpTxC a left join PosUpUsers b on a.IdUser = b.login and a.IdcompanyUser=b.IdCompany 
        left join PosUpTxD d on a.IdCompany = d.IdCompany and a.Idtipotx = d.idtipotx and a.Idtx = d.Idtx and a.IdEstacion = d.IdEstacion 
        left join PosUpProducto e on a.IdCompany = e.IdCompany and d.CodIdBasico = e.CodIdBasico 
        inner Join PosUpTx f on a.Idtipotx=f.Idtipotx inner join PosUpAlmacen g on d.IdAlm = g.IdAlm and d.IdCompany = g.IdCompany 
        LEFT join PosUpclientes h on a.IdCompany=h.IdCompany and a.IdBen=h.RUT 
        where a.IdCompany " . $companygrp . " and   a.Fectxclient between '" . $fec1 . " 00:00:00' and '" . $fec2 . " 23:59:59'
        and e.CodIdBasico='%%'
        and e.EsCompuesto=0 and f.Inventario<>0  and Cant<>0  " . $almceFiltro . " " . $tipoTrans . " " . $ConMov . "
        group by d.Idtipotx,d.Idtx,d.IdEstacion,d.IdCompany,d.IdAlm,d.CodIdBasico 
        Order by a.Fectxclient,d.CodIdBasico,coalesce(sum(d.Cant * f.Inventario),0) ASC";  ?>
		<input type="hidden" name="Query" id="Query" value="<?php echo $query; ?>" />
		<input type="hidden" name="Query2" id="Query2" value="<?php echo $queryz; ?>" />
		<input type="hidden" name="Name" id="Name" value="<?php echo $name; ?>" />
		<input type="hidden" name="Company" id="Company" value="<?php echo $compa; ?>" />
		<input type="hidden" name="SerialesZZ" id="SerialesZZ" value="<?php echo $_POST['SerialesZZ']; ?>" />
		<input type="hidden" name="vas" id="vas" value="detalladoin" />
		<input type="hidden" name="CD" id="CD" value="<?php echo $_POST["CD"]; ?>" />
		<input type="hidden" name="SimDec" id="SimDec" value="<?php echo $_POST["SimDec"]; ?>" />
		<input type="hidden" name="SimMil" id="SimMil" value="<?php echo $_POST["SimMil"]; ?>" />
	</form>
</body>
<script>
	const totalPages = document.querySelectorAll('.page').length;
	document.documentElement.style.setProperty('--total-pages', totalPages);
</script>

</html>