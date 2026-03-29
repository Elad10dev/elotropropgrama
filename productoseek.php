<?php
function record_sort($records, $field, $reverse = false)
{
	$hash = array();
	foreach ($records as $record) {
		$hash[$record[$field]] = $record;
	}
	($reverse) ? krsort($hash) : ksort($hash);
	$records = array();
	foreach ($hash as $record) {
		$records[] = $record;
	}
	return $records;
}


function ProductoTable($conn, $post, $request)
{
	$IdCompany = $post["IdCompany"];

	$VisualExist = "";

	$CompanyData = [];
	$sql = "
	select
			d.VisualizaPrecio,d.LitP01,d.LitP02,d.LitP03,d.LitP04,d.LitP05,d.LitP06,d.LitP07,d.LitP08,
	d.LitP09,d.LitP10,d.LitCosto
		from
			PosUpCompany d
		where
		d.Id=" . $IdCompany  . "
	";
	if ($result = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$CompanyData = $row;
		}
	};


	$wFor = "";
	$HavingData = "";
	$IdAlmGroup = explode(",", $post["IdAlmGroup"]);

	if ($post["SoloExistencia"] === "on") {


		$HavingData = " HAVING existotal > 0";
	}
	if (trim($post["VerStock"]) === "1" && $post["sucursal"] !== "0") {
		$wFor = " and alm.IdUbi = " . $post["sucursal"] . " " . (!empty($IdAlmGroup) && trim(implode("','", $IdAlmGroup)) !== "" ? " or dt.IdAlm in ('" . implode("','", $IdAlmGroup) . "')" : "");
	} else if (trim($post["VerStock"]) === "3") {
		$wFor = " and dt.IdAlm in ('" . implode("','", $IdAlmGroup) . "')";
	} else if (trim($post["VerStock"]) === "2") {
		$wFor = " and dt.IdAlm = " . $post["IdAlmVtaSeleccionada"] . " " . (!empty($IdAlmGroup) && trim(implode("','", $IdAlmGroup)) !== "" ? " or dt.IdAlm in ('" . implode("','", $IdAlmGroup) . "')" : "");
	} else if (intval($post["VerStock"]) >= 100) {
		$wFor = " and alm.IdAtt = " . (intval($post["VerStock"]) / 100) . " " . (!empty($IdAlmGroup) && trim(implode("','", $IdAlmGroup)) !== "" ? " or dt.IdAlm in ('" . implode("','", $IdAlmGroup) . "')" : "");
	}

	$PerfilVentas = explode(",", $post["PerfilVentas"]);
	$p1 = $PerfilVentas[1];
	$p2 = $PerfilVentas[2];
	$p3 = $PerfilVentas[3];
	$p4 = $PerfilVentas[10];
	$p5 = $PerfilVentas[13];
	$p6 = $PerfilVentas[15];
	$p7 = $PerfilVentas[17];
	$p8 = $PerfilVentas[19];
	$p9 = $PerfilVentas[21];
	$p10 = $PerfilVentas[23];

	$search = " and a.EsCompuesto=" . $post['EsonoES'] . "";

	if (!empty($post["EnvioMarca"])) $search .= " and a.Marca " . ($post["NotIncludeMarcas"] === "true" ? "not" : "") . " in ('" . implode("','", $post['EnvioMarca']) . "')";
	if (!empty($post["EnvioFamilia"])) $search .= " and a.IdFamilia " . ($post["NotIncludeFamilia"] === "true" ? "not" : "") . " in ('" . implode("','", $post['EnvioFamilia']) . "')";

	if ($post['Estado'] <> '*') $search .= " and a.Estado='" . $post['Estado'] . "'";

	if ($post['Peso'] <> '*') $search .= " and a.PorKilo='" . $post['Peso'] . "'";


	$col = "";

	if ($post["OrderBy"] === "Nombre") {
		$col = "a.Descripcion";
	} else if ($post["OrderBy"] === "CodBar") {
		$col = "a.CodBarra";
	} else if ($post["OrderBy"] === "CodIdAmpliado") {
		$col = "a.CodIdAmpliado";
	} else if ($post["OrderBy"] === "CodBasico" && $post["SoloExistencia"] === "on") {
		$col = "dt.CodIdBasico";
	} else if ($post["OrderBy"] === "CodBasico") {
		$col = "a.CodIdBasico";
	}

	$almacenes = [];
	if ($post["SoloExistencia"] === "on") {
		$buscar = "";

		if (!empty($post["EnvioAlmacen"])) {
			$buscar .= " and IdAlm " . ($post["NotIncludeAlmacen"] === "true" ? "not" : "") . " in ('" . implode("','", $post["EnvioAlmacen"]) . "')";
		}

		if (!empty($post["EnvioUbicacion"])) {
			$buscar .= " and IdUbi " . ($post["NotIncludeUbicacion"] === "true" ? "not" : "") . " in ('" . implode("','", $post['EnvioUbicacion']) . "')";
		}

		if (!empty($post["EnvioZonaAtencion"])) {
			$buscar .= " and IdAtt " . ($post["NotIncludeZonaAtencion"] === "true" ? "not" : "") . " in ('" . implode("','", $post["EnvioZonaAtencion"]) . "')";
		}

		$sqlA = "
				select
					IdAlm
				from
					posupalmacen
				where
					idcompany = " . $post["IdCompany"] . " 
					" . $buscar . "
				";
		if ($result = mysqli_query($conn, $sqlA)) {
			while ($row = mysqli_fetch_assoc($result)) {
				$almacenes[] = $row["IdAlm"];
			}
		}
	} else {
	}
	$sql2A = "SELECT count(a.IdCompany) as counta FROM PosUpProducto a WHERE a.IdCompany=" . $IdCompany . "  " . $search . " ";
	$query = mysqli_query($conn, $sql2A);
	while ($row = mysqli_fetch_array($query)) {
		$totalData = $row["counta"];
	}

	$VisualExist = "";

	$qry = "SET SESSION group_concat_max_len = 1000000";
	mysqli_query($conn, $qry);
	if ($post["SoloExistencia"] === "on") {

		if ($post['VisualExist'] === '0') {
			$VisualExist = "	
				select dt.CodIdBasico, GROUP_CONCAT(CONCAT(dt.IdAlm,'|',alm.Nombre,'|',dt.qty_on_hand,'|',alm.IdUbi,'|',alm.IdAtt,'|',dt.reserved_qty,'|',dt.incoming_qty) SEPARATOR ';;') as Almcacen,a.*,
				g.ITEM as ImpuestoName,(g.VALOR*100) as ImpuestoPorcentaje,b.nombre as Marcaxd,c.esmedida,c.ITEM as Familia,c.esserial,c.eslote,
			sum(dt.qty_on_hand) as existotal,coalesce(f.DescripcionLarga,'') as DL,	f.DescripcionCorta as DC
				FROM
					inv_existencias  as dt
					left join PosUpProducto a on a.IdCompany = " . $IdCompany . " 
					and a.CodIdBasico = dt.CodIdBasico 
					left join PosUpc_marcas b on b.IdCompany = " . $IdCompany . " 
					and b.idmarca = a.Marca 
					left join PosUpvarios c on c.IdCompany = " . $IdCompany . " 
					and c.IdVarios = a.Idfamilia 
					and c.TIPOITEM = 2
					left join  PosUpProductoWeb f on a.IdCompany=f.IdCompany  and a.CodIdBasico=f.CodIdBasico 
					left join PosUpvarios g on g.IdCompany = " . $IdCompany . " 
					and g.IdVarios = a.Impuesto 
					and g.TIPOITEM = 0
					left join PosUpAlmacen alm on alm.IdCompany = " . $IdCompany . " 
					and alm.IdAlm = dt.IdAlm
			";
		} else if ($post['VisualExist'] === '1') {
			$VisualExist = "	
				select dt.CodIdBasico, GROUP_CONCAT(CONCAT(alm.IdUbi,'|',ubi.Nombre,'|',dt.qty_on_hand,'|',alm.IdUbi,'|',alm.IdAtt,'|',dt.reserved_qty,'|',dt.incoming_qty) SEPARATOR ';;') as Almcacen,a.*,
				g.ITEM as ImpuestoName,(g.VALOR*100) as ImpuestoPorcentaje,b.nombre as Marcaxd,c.esmedida,c.ITEM as Familia,c.esserial,c.eslote,
				sum(dt.qty_on_hand) as existotal,coalesce(f.DescripcionLarga,'') as DL,	f.DescripcionCorta as DC
				FROM
					inv_existencias  as dt
					left join PosUpProducto a on a.IdCompany = " . $IdCompany . " 
					and a.CodIdBasico = dt.CodIdBasico 
					left join PosUpc_marcas b on b.IdCompany = " . $IdCompany . " 
					and b.idmarca = a.Marca 
					left join PosUpvarios c on c.IdCompany = " . $IdCompany . " 
					and c.IdVarios = a.Idfamilia 
					and c.TIPOITEM = 2
					left join  PosUpProductoWeb f on a.IdCompany=f.IdCompany  and a.CodIdBasico=f.CodIdBasico
					left join PosUpvarios g on g.IdCompany = " . $IdCompany . " 
					and g.IdVarios = a.Impuesto 
					and g.TIPOITEM = 0
					left join PosUpAlmacen alm on alm.IdCompany = " . $IdCompany . " 
					and alm.IdAlm = dt.IdAlm
					left JOIN PosUpUbicacion ubi on ubi.idCompany = " . $IdCompany . "
					and ubi.IdUbi = alm.IdUbi
			";
		} else if ($post['VisualExist'] === '2') {
			$VisualExist = "	
				select dt.CodIdBasico, GROUP_CONCAT(CONCAT(alm.IdAtt,'|',att.Nombre,'|',dt.qty_on_hand,'|',alm.IdUbi,'|',alm.IdAtt,'|',dt.reserved_qty,'|',dt.incoming_qty) SEPARATOR ';;') as Almcacen,a.*,
				g.ITEM as ImpuestoName,(g.VALOR*100) as ImpuestoPorcentaje,b.nombre as Marcaxd,c.esmedida,c.ITEM as Familia,c.esserial,c.eslote,
					sum(dt.qty_on_hand) as existotal,coalesce(f.DescripcionLarga,'') as DL,	f.DescripcionCorta as DC
				FROM
					inv_existencias  as dt
					left join PosUpProducto a on a.IdCompany = " . $IdCompany . " 
					and a.CodIdBasico = dt.CodIdBasico 
					left join PosUpc_marcas b on b.IdCompany = " . $IdCompany . " 
					and b.idmarca = a.Marca 
					left join PosUpvarios c on c.IdCompany = " . $IdCompany . " 
					and c.IdVarios = a.Idfamilia 
					and c.TIPOITEM = 2
					left join  PosUpProductoWeb f on a.IdCompany=f.IdCompany  and a.CodIdBasico=f.CodIdBasico
					left join PosUpvarios g on g.IdCompany = " . $IdCompany . " 
					and g.IdVarios = a.Impuesto 
					and g.TIPOITEM = 0
					left join PosUpAlmacen alm on alm.IdCompany = " . $IdCompany . " 
					and alm.IdAlm = dt.IdAlm
					left join posupzonaatt att on att.IdCompany = " . $IdCompany . " 
					and att.IdAtt = alm.IdAtt
			";
		}
		$sql2 =   "
					" . $VisualExist . "
					where dt.IdCompany = " . $IdCompany . " 
					" . (count($almacenes) > 0 ? " AND dt.IdAlm in (" . implode(",", $almacenes) . ")" : "") . "
					" . $search . "
				";
	} else {
		$VisualExist = "	
				select  a.*,
				g.ITEM as ImpuestoName,(g.VALOR*100) as ImpuestoPorcentaje,b.nombre as Marcaxd,c.esmedida,c.ITEM as Familia,c.esserial,c.eslote,coalesce(f.DescripcionLarga,'') as DL,	f.DescripcionCorta as DC
				from PosUpProducto a
					left join PosUpc_marcas b on b.IdCompany = " . $IdCompany . " 
					and b.idmarca = a.Marca 
					left join PosUpvarios c on c.IdCompany = " . $IdCompany . " 
					and c.IdVarios = a.Idfamilia 
					and c.TIPOITEM = 2
					left join  PosUpProductoWeb f on a.IdCompany=f.IdCompany  and a.CodIdBasico=f.CodIdBasico
					left join PosUpvarios g on g.IdCompany = " . $IdCompany . " 
					and g.IdVarios = a.Impuesto 
					and g.TIPOITEM = 0
			";
		$sql2 =   "
					" . $VisualExist . "
					where a.IdCompany = " . $IdCompany . " 
					" . $search . "
				";
	}


	if (!empty($request['search']['value'])) {
		$sql2 .= " AND (a.Descripcion like '%" . $request['search']['value'] . "%' 
		OR a.CodIdAmpliado like '%" . $request['search']['value'] . "%'
		OR a.Envase like '%" . $request['search']['value'] . "%'
		OR ((replace(a.CodBarra,' ','')  like '%|" . $request['search']['value'] . "|%' 
		OR replace(a.CodBarra,' ','') = '" . $request['search']['value'] . "' 
		OR replace(a.CodBarra,' ','')  like '" . $request['search']['value'] . "|%' 
		OR replace(a.CodBarra,' ','')  like '%|" . $request['search']['value'] . "')))";
	}

	if ($post["SoloExistencia"] === "on") {

		$sql2 .= $wFor . " group by dt.CodIdBasico " . $HavingData;
	}

	$query = mysqli_query($conn, $sql2);
	$totalFilter = mysqli_num_rows($query);

	$sql2 .= " ORDER BY " . $col . "   " . $post["SortBy"] . "";

	$sql2 .= " LIMIT " .
		$request['start'] . "  ," . $request['length'] . "  ";

	$query = mysqli_query($conn, $sql2);
	$data = array();

	$n = 0;
	while ($row = mysqli_fetch_array($query)) {
		$exisTx = 0;
		$n = $n + 1;
		$images = '';
		$subdata = array();
		$productos = "productos";
		$directorio_escaneado = scandir("Comercio/" . $IdCompany . "/" . $productos . "");
		$hhh = 0;
		foreach ($directorio_escaneado as $item) {
			if ($item != '.' and $item != '..') {
				$nnn = preg_split('/_/', $item);
				$Mbooking_number = trim($row["CodIdBasico"]);
				if ($nnn[0] == $Mbooking_number) {
					$hhh += 1;
					$images .= '<div class="carousel-item ' . ($hhh == 1 ? "active" : "") . '" style="width:115px;">
							<img src="/Comercio/' . $IdCompany . '/' . $productos . '/' . $item . '" class="d-block w-100" alt="...">
							</div>';
				}
			}
		}


		$images = '<div id="carouselExampleControls' . $n . '" class="carousel slide" data-bs-ride="carousel" style="width:115px;">
				<div class="carousel-inner">
				' . ($images === "" ? '<div class="carousel-item active" style="width:115px;">
				<img src="../img/no-photo-available2.png" class="d-block w-100" alt="...">
			</div>' : $images)  . '
				
			</div>
			<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls' . $n . '" data-bs-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"><i class="fa fa-arrow-left"></i></span>
				<span class="visually-hidden">Previous</span>
			</button>
			<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls' . $n . '" data-bs-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"><i class="fa fa-arrow-right"></i></span>
				<span class="visually-hidden">Next</span>
			</button>
			</div><span class="badge bg-warning text-dark">' . $hhh . ' <i class="fa fa-image"></i></span>
		';




		$alm = [];

		$sql3 = "SELECT *
				from PosUpTxD
				where IdCompany = " . $IdCompany . " 
				AND CodIdBasico = '" . $row["CodIdBasico"] . "'
				limit 1
			";
		if ($result3 = mysqli_query($conn, $sql3)) {
			while ($row3 = mysqli_fetch_assoc($result3)) {
				$exisTx = 1;
			}
			mysqli_free_result($result3);
		}


		if ($post["SoloExistencia"] === "on") {
			$almacenes = explode(";;", $row["Almcacen"]);
		} else {
			$almacenes = [];
			if ($post['VisualExist'] === '0') {
				$VisualExistA = "	
					select dt.CodIdBasico, GROUP_CONCAT(CONCAT(dt.IdAlm,'|',alm.Nombre,'|',dt.qty_on_hand,'|',alm.IdUbi,'|',alm.IdAtt,'|',dt.reserved_qty,'|',dt.incoming_qty) SEPARATOR ';;') as Almcacen
					FROM
					inv_existencias  as dt
						left join PosUpAlmacen alm on alm.IdCompany = " . $IdCompany . " 
						and alm.IdAlm = dt.IdAlm
						WHERE dt.CodIdBasico = '" . $row["CodIdBasico"] . "'
						AND dt.IdCompany = '" . $IdCompany . "'
						GROUP BY dt.CodIdBasico
				";
			} else if ($post['VisualExist'] === '1') {
				$VisualExistA = "	
					select dt.CodIdBasico, GROUP_CONCAT(CONCAT(alm.IdUbi,'|',ubi.Nombre,'|',dt.qty_on_hand,'|',alm.IdUbi,'|',alm.IdAtt,'|',dt.reserved_qty,'|',dt.incoming_qty) SEPARATOR ';;') as Almcacen
					FROM
					inv_existencias  as dt
						left join PosUpAlmacen alm on alm.IdCompany = " . $IdCompany . " 
						and alm.IdAlm = dt.IdAlm
						left JOIN PosUpUbicacion ubi on ubi.idCompany = " . $IdCompany . "
						and ubi.IdUbi = alm.IdUbi
						WHERE dt.CodIdBasico = '" . $row["CodIdBasico"] . "'
						AND dt.IdCompany = '" . $IdCompany . "'
						GROUP BY dt.CodIdBasico
				";
			} else if ($post['VisualExist'] === '2') {
				$VisualExistA = "	
					select dt.CodIdBasico, GROUP_CONCAT(CONCAT(alm.IdAtt,'|',att.Nombre,'|',dt.qty_on_hand,'|',alm.IdUbi,'|',alm.IdAtt,'|',dt.reserved_qty,'|',dt.incoming_qty) SEPARATOR ';;') as Almcacen
					FROM
					inv_existencias  as dt
						left join PosUpAlmacen alm on alm.IdCompany = " . $IdCompany . " 
						and alm.IdAlm = dt.IdAlm
						left join posupzonaatt att on att.IdCompany = " . $IdCompany . " 
						and att.IdAtt = alm.IdAtt
						WHERE dt.CodIdBasico = '" . $row["CodIdBasico"] . "'
						AND dt.IdCompany = '" . $IdCompany . "'
						GROUP BY dt.CodIdBasico
				";
			}
			$result2 = mysqli_query($conn, $VisualExistA);
			while ($row2 = mysqli_fetch_array($result2)) {
				$almacenes = explode(";;", $row2["Almcacen"]);
			}
		}
		if ($almacenes) {
			foreach ($almacenes as $almacen) {
				$almacenx = explode("|", $almacen);
				if ($almacenx) {
					$alm[$almacenx[0]] = [
						"IdAlm" => $almacenx[0],
						"Nombre" => $almacenx[1],
						"Cant" => $almacenx[2] + $alm[$almacenx[0]]["Cant"] ?? 0,
						"IdUbi" => $almacenx[3],
						"IdAtt" => $almacenx[4],
						"Ped" => $almacenx[5] + $alm[$almacenx[0]]["Ped"] ?? 0,
						"Order" => $almacenx[6] + $alm[$almacenx[0]]["Order"] ?? 0,
					];
				}
			}
		}


		$var = "";
		$elimin = "";

		if ($post["userperfil"] <= 2000 || $post["userperfil"] == "2055" || $post["userperfil"] == "2054" || $post["userperfil"] == "2053" || ($post["userlogin"] === "DULCE" && $post["IdCompany"] === "1125")) {
			if ($exisTx == 0) {
				$elimin = "<button class='btn btn-outline-danger p-1 m-1' type='button' data-toggle='tooltip' title='" . lang("Eliminar Registro") . "' id='eliminar1' onclick='alertaborrar(" . $n . ");'><span class='fa fa-trash'></span></button>";
			}
			$price = "<button class='btn btn-outline-success p-1 m-1' type='button' data-toggle='tooltip' title='" . lang("Costos de Productos") . "' id='editar21' onclick='recibir2(" . $n . ",`" . $var . "`);'><span class='fa fa-money'></span></button>";
			$aud = "<button class=' btn btn-outline-dark  p-1 m-1' type='button' title='" . lang("Historial del Producto") . "' onclick='auditoria(" . $n . ",`" . $var . "`)'><span class='fa fa-eye'></span></button>";
		}

		if ($IdCompany == 0 and $row['Idfamilia'] == '7') {
			$comp = "<button class=' btn btn-outline-success' type='button' title='" . lang("Configuración de Planes") . "' onclick='complementos(" . $n . ",`" . $var . "`)'><span class='fa fa-th-list'></span></button>";
		}

		if ($post['EsonoES'] == 0) {
			$inv = "<button class='btn btn-outline-secondary p-1 m-1' type='button' data-toggle='tooltip' title='" . lang("Inventario") . "' id='editar31' onclick='recibir3(" . $n . ",`" . $var . "`);'><span class='fa fa-dropbox'></span></button>";
			if (($row["esserial"] == 1)) {
				$inv .= "<button class='btn btn-outline-dark p-1 m-1' type='button' data-toggle='tooltip' title='" . lang("Generar Seriales") . "' id='editar31' onclick='OpenModalAuto(`" . $row["CodIdBasico"] . "`);'><span class='fa fa-barcode'></span></button>";
			}
		}


		$comision = $row["Comision"] * 100;
		$comision2 = $row["Comision2"] * 100;
		$comision3 = $row["Comision3"] * 100;
		$comision4 = $row["Comision4"] * 100;
		$comision5 = $row["Comision5"] * 100;
		$comision6 = $row["Comision6"] * 100;
		$comision7 = $row["Comision7"] * 100;
		$comision8 = $row["Comision8"] * 100;
		$comision9 = $row["Comision9"] * 100;
		$comision10 = $row["Comision10"] * 100;

		$Medida = $row["Medida"];
		$UnidadP1 = $row["UnidadP1"];
		$UnidadP2 = $row["UnidadP2"];
		$UnidadP4 = $row["UnidadP4"];
		$UnidadP5 = $row["UnidadP5"];
		$UnidadP6 = $row["UnidadP6"];
		$UnidadP7 = $row["UnidadP7"];
		$UnidadP8 = $row["UnidadP8"];
		$UnidadP9 = $row["UnidadP9"];
		$UnidadP10 = $row["UnidadP10"];

		if ($Medida <> '') {
			$Medida = "<span class='badge bg-success text-white'>" . $row["Medida"] . "</span>";
		}

		if ($UnidadP1 <> '') {
			$UnidadP1 = "<span class='badge bg-success text-white'>" . $row["UnidadP1"] . ($row["CantP1"] == 1 ? "" : " (" . $row["CantP1"] . ")") . "</span>";
		}

		if ($UnidadP2 <> '') {
			$UnidadP2 = "<span class='badge bg-success text-white'>" . $row["UnidadP2"] . ($row["CantP2"] == 1 ? "" : " (" . $row["CantP2"] . ")") . "</span>";
		}

		if ($UnidadP4 <> '') {
			$UnidadP4 = "<span class='badge bg-success text-white'>" . $row["UnidadP4"] . ($row["CantP4"] == 1 ? "" : " (" . $row["CantP4"] . ")") . "</span>";
		}

		if ($UnidadP5 <> '') {
			$UnidadP5 = "<span class='badge bg-success text-white'>" . $row["UnidadP5"] . ($row["CantP5"] == 1 ? "" : " (" . $row["CantP5"] . ")") . "</span>";
		}

		if ($UnidadP6 <> '') {
			$UnidadP6 = "<span class='badge bg-success text-white'>" . $row["UnidadP6"] . ($row["CantP6"] == 1 ? "" : " (" . $row["CantP6"] . ")") . "</span>";
		}

		if ($UnidadP7 <> '') {
			$UnidadP7 = "<span class='badge bg-success text-white'>" . $row["UnidadP7"] . ($row["CantP7"] == 1 ? "" : " (" . $row["CantP7"] . ")") . "</span>";
		}

		if ($UnidadP8 <> '') {
			$UnidadP8 = "<span class='badge bg-success text-white'>" . $row["UnidadP8"] . ($row["CantP8"] == 1 ? "" : " (" . $row["CantP8"] . ")") . "</span>";
		}

		if ($UnidadP9 <> '') {
			$UnidadP9 = "<span class='badge bg-success text-white'>" . $row["UnidadP9"] . ($row["CantP9"] == 1 ? "" : " (" . $row["CantP9"] . ")") . "</span>";
		}

		if ($UnidadP10 <> '') {
			$UnidadP10 = "<span class='badge bg-success text-white'>" . $row["UnidadP10"] . ($row["CantP10"] == 1 ? "" : " (" . $row["CantP10"] . ")") . "</span>";
		}
		$varprod = '';
		$textVariation = "";

		if (($row['CodIdBasico'] == $row['CodIdBasicoPadre'] or $row['CodIdBasicoPadre'] == '') and trim($row['VariationsTypes']) <> '') {
			$textVariation = "<span class='badge bg-info text-light' >" . lang('Tiene variaciones') . "</span>";
		}

		$vartypes = $row['VariationsTypes'];
		$Textvar = $row['Textvar'];
		$explode = explode(',', $vartypes);
		$Textvar = explode('|', $Textvar);
		$z = 0;
		$variations = '';
		foreach ($explode as $types) {
			if (trim($types) <> '') {
				if (trim($Textvar[$z]) <> '') {
					$variations .= "<span class='badge bg-success text-light'>$types</span> <span class='badge bg-light text-dark'>" . $Textvar[$z] . "</span> ";
				}
				$z = $z + 1;
			}
		}

		if ($variations <> '') {
			$variations = "<br>" . $variations;
		}

		if ($textVariation <> '') {
			$textVariation = "<br>" . $textVariation;
		}


		$var = '';

		if (($row['CodIdBasico'] == $row['CodIdBasicoPadre'] or $row['CodIdBasicoPadre'] == '')) {

			$sql = "SELECT a.*    FROM PosUpProducto a  
							where a.IdCompany=" . $IdCompany . " and CodIdBasicoPadre='" . $row['CodIdBasico'] . "'   and CodIdBasico<>'" . $row['CodIdBasicoPadre'] . "' limit 1";
			$nrow = 0;

			if ($result3 = mysqli_query($conn, $sql)) {
				while ($row3 = mysqli_fetch_assoc($result3)) {
					$nrow = $nrow + 1;
				}
			}


			if ($nrow >= 1) {
				$var = "0";
			} else {
				$var = "1";
			}
		} else {
			$var = '2';
		}


		if ($row['CodIdBasico'] <> $row['CodIdBasicoPadre'] and trim($row['CodIdBasicoPadre']) <> '') {
			$var = '2';

			$sql = "SELECT a.*    FROM PosUpProducto a  
							where a.IdCompany=" . $IdCompany . " and  CodIdBasico='" . $row['CodIdBasicoPadre'] . "' limit 1 ";

			if ($result3 = mysqli_query($conn, $sql)) {
				while ($row3 = mysqli_fetch_assoc($result3)) {
					$textVariation = "<span class='badge bg-info text-light' >" . lang('Variaciones de') . ":</span> <span class='badge bg-success text-light' id='SkuFa" . $n . "' >" . $row3['CodIdAmpliado'] . "</span> <span class='badge bg-light text-dark' id='TitFa" . $n . "' >" . $row3['Descripcion'] . "</span> ";
				}
			}
		}

		$Hashtags = "";
		$array = explode("|", $row["Envase"]);
		foreach ($array as $key => $val) {
			if (trim($val) <> "") {
				$Hashtags .= "<span class='badge bg-light text-dark p-1 m-1'><i class='fa fa-tag'></i> " . $val . "</span>";
			}
		}

		if (trim($Hashtags) <> "") {
			$Hashtags = "<br>" . $Hashtags;
		}

		if ($row['FamiliaPadre'] <> '') {
			$familia = "" . $row['FamiliaPadre'] . " / " . $row['Familia'];
		} else {
			$familia = $row['Familia'];
		}

		$PosStock = "";
		$Cantotal = 0;
		$ExisComp = 0;
		$OrdComp = 0;
		if ($row["EsCompuesto"] <> 9) {
			if ($alm) {
				foreach ($alm as $almacen) {
					$ExisComp += $almacen["Ped"];
					$OrdComp += $almacen["Order"];
					if (
						(trim($post["VerStock"]) === "0")
						|| (trim($post["VerStock"]) === "1" && ($almacen["IdUbi"] === $post["sucursal"] || $post["sucursal"] === "0"))
						|| (trim($post["VerStock"]) === "2" && $almacen["IdAlm"] === $post["IdAlmVtaSeleccionada"])
						|| intval($post["VerStock"]) >= 100 && intval($almacen["IdAtt"]) === (intval($post["VerStock"]) / 100)
						|| in_array(trim($almacen["IdAlm"]), $IdAlmGroup)
					) {
						if (round($almacen["Cant"], $post["CD"]) > 0) {

							$show = "";

							if ($row["factorunit"] <> 1 && $row["factorunit"] <> 0) {
								$show = $row["factorunit"] . " x " . getcantformat($almacen["Cant"], $post["CD"], $post["SimDec"], $post["SimMil"]) . " = " . getcantformat($almacen["Cant"] * $row["factorunit"], $post["CD"], $post["SimDec"], $post["SimMil"])  . " " . $row["Medida"];
							} else if ($row["FactorAlter"] <> 1) {
								$show = getcantformat($almacen["Cant"], $post["CD"], $post["SimDec"], $post["SimMil"])  . " " . $row["Medida"] . " = " . getcantformat($almacen["Cant"] * $row["FactorAlter"], $post["CD"], $post["SimDec"], $post["SimMil"]) . " " . $row['UnidadAlter'];
							} else {
								$show = getcantformat($almacen["Cant"], $post["CD"], $post["SimDec"], $post["SimMil"])  . " " . $row["Medida"];
							}


							if ($almacen["IdAlm"] == $post["IdAlmVta"]) {
								$PosStock .= "
									<div class='d-flex align-items-center gap-2 mb-1 text-wrap'>
										<span class='badge bg-light text-dark'>" . $almacen["Nombre"] . "</span> 
										<span class='badge bg-success text-light'>" . $show . " <i class='fa fa-check'></i></span> 
										" . ($post["userperfil"] <= 2000 ? "<span class='badge bg-info text-dark'>" . number_format(($row['CostoNeto'] * $almacen["Cant"]), $post["CD"], $post["SimDec"], $post["SimMil"]) . " " . $post["MonedaP"] . "</span>" : "") . "
									</div>
								";
							} else {
								$PosStock .= "
									<div class='d-flex align-items-center gap-2 mb-1 text-wrap'>
										<span class='badge bg-light text-dark'>" . $almacen["Nombre"] . "</span> 
										<span class='badge bg-warning text-dark'>" . $show . "</span> 
										" . ($post["userperfil"] <= 2000 ? "<span class='badge bg-info text-dark'>" . number_format(($row['CostoNeto'] * $almacen["Cant"]), $post["CD"], $post["SimDec"], $post["SimMil"]) . " " . $post["MonedaP"] . "</span>" : "") . "
									</div>
								";
							}

							$Cantotal += round($almacen["Cant"], 3);
						}
					}
				}
			}
			$show = "";

			if ($row["factorunit"] <> 1 && $row["factorunit"] <> 0) {
				$show = $row["factorunit"] . " x " . getcantformat($Cantotal, $post["CD"], $post["SimDec"], $post["SimMil"]) . " = " . getcantformat($Cantotal * $row["factorunit"], $post["CD"], $post["SimDec"], $post["SimMil"])  . " " . $row["Medida"];
			} else if ($row["FactorAlter"] <> 1) {
				$show = getcantformat($Cantotal, $post["CD"], $post["SimDec"], $post["SimMil"])  . " " . $row["Medida"] . " = " . getcantformat($Cantotal * $row["FactorAlter"], $post["CD"], $post["SimDec"], $post["SimMil"]) . " " . $row['UnidadAlter'];
			} else {
				$show = getcantformat($Cantotal, $post["CD"], $post["SimDec"], $post["SimMil"])  . " " . $row["Medida"];
			}

			if ($Cantotal == 0) {
				$PosStock = "<span class='badge bg-danger text-light'>" . lang("Agotada") . "</span></br>";
			} else {
				$PosStock .= "<div class='d-flex align-items-center gap-2 mb-1 text-wrap'><span class='badge bg-success text-light'>" . lang("Total Stock") . "</span> <span class='badge bg-warning text-dark'>" . $show . " </span>  " . ($post["userperfil"] <= 2000 ? "<span class='badge bg-info text-dark'>" . number_format(($row['CostoNeto'] * $Cantotal), $post["CD"], $post["SimDec"], $post["SimMil"]) . " " . $post["MonedaP"] . "</span>" : "") . "</div>";
			}
			if ($ExisComp <> 0) {
				$PosStock .= "<div><span class='badge bg-danger text-light'>" . lang('Pedidos') . ' / ' . lang("Clientes") . '</span> <span class="badge bg-warning text-dark">' . getcantformat(abs($ExisComp), $post["CD"], $post["SimDec"], $post["SimMil"]) . " " . $row["Medida"] . "</span></strong></div>";
			}
			if ($OrdComp <> 0) {
				$PosStock .= "<div><span class='badge bg-info text-dark'>" . lang('OC') . ' / ' . lang("Proveedor") . '</span> <span class="badge bg-warning text-dark">' . getcantformat($OrdComp, $post["CD"], $post["SimDec"], $post["SimMil"]) . " " . $row["Medida"] . "</span></strong></div>";
			}
			if ($row["esserial"] == 1) {
				$PosStock .= "<div><button class='btn btn-outline-success p-1 mt-1' type='button ' onclick='abrir123435(" . $n . ")'><i class='fa fa-barcode'></i> " . ucwords(strtolower(lang("Ver Seriales"))) . "</button></div>";
			}
			if ($row["eslote"] == 1) {
				$PosStock .= "<div><button class='btn btn-outline-success p-1 mt-1' type='button ' onclick='abrirLotes(" . $n . ")'><i class='fa fa-calendar-check-o'></i> " . ucwords(strtolower(lang("Ver Lotes"))) . "</button></div>";
			}
		} else {
			$PosStock = "<span class='badge bg-success'>" . lang("No Usa Existencia") . "</span></br>";
		}


		$subdata[] = "
					<span style='display:none' class='d-none' id='CostoPorcentaje" . $n . "'>" . trim($row['CostoPorcentaje']) . "</span>
					<span style='display:none' class='d-none' id='porcentual" . $n . "'>" . trim($row['porcentual']) . "</span>
					<span style='display:none' class='d-none' id='descripcion" . $n . "'>" . trim($row['Descripcion']) . "</span>
					<span style='display:none' class='d-none' id='codidbasico1" . $n . "'>" . trim($row['CodIdBasico']) . "</span> 
					<span style='display:none' class='d-none' id='codidampliado" . $n . "'>" . trim($row['CodIdAmpliado']) . "</span>
					<span style='display:none' class='d-none' id='CantotalA" . $n . "'>" . $Cantotal . "</span>

					<span style='display:none' class='d-none' id='larga". $n . "'>". trim($row['DL']) . "</span> 
					<span style='display:none' class='d-none' id='corta". $n . "'>" . trim($row['DC']) . "</span> 
					
					<span style='display:none' class='d-none' id='codbarra" . $n . "'>" . trim($row['CodBarra']) . "</span>
					<span style='display:none' class='d-none' id='medida" . $n . "'>" . trim($row['Medida']) . "</span> 
					<span style='display:none' class='d-none' id='impuesto" . $n . "'>" . trim($row['Impuesto']) . "</span>
					<span style='display:none' class='d-none' id='costo" . $n . "'>" . trim($row['Costo']) . "</span>
					<span style='display:none' class='d-none' id='margen1" . $n . "'>" . trim($row['Margen']) . "</span> 
					<span style='display:none' class='d-none' id='precioventa" . $n . "'>" . number_format(trim($row['PrecioVenta']), $post["CD"], $post["SimDec"], $post["SimMil"]) . "</span>
					<span style='display:none' class='d-none' id='preciodeventa2" . $n . "'>" . trim($row['PrecioVenta']) . "</span>
					<span style='display:none' class='d-none' id='costoneto" . $n . "'>" . trim($row['CostoNeto']) . "</span>
					<span style='display:none' class='d-none' id='precioneto1" . $n . "'>" . trim($row['PrecioNeto']) . "</span> 
					<span style='display:none' class='d-none' id='estado" . $n . "'>" . trim($row['Estado']) . "</span>
					<span style='display:none' class='d-none' id='rutultimoproveedor" . $n . "'>" . trim($row['RutUltimoProveedor']) . "</span>
					<span style='display:none' class='d-none' id='envase" . $n . "'>" . trim($row['Envase']) . "</span> 
					<span style='display:none' class='d-none' id='idfamilia" . $n . "'>" . trim($row['Idfamilia']) . "</span>
					<span style='display:none' class='d-none' id='IdFamiliaAdds" . $n . "'>" . trim($row['IdFamiliaAdds']) . "</span>
					<span style='display:none' class='d-none' id='NOmarca" . $n . "'>" . trim($row['Marcaxd']) . "</span>
					<span style='display:none' class='d-none' id='NOfamilia" . $n . "'>" . trim($row['Familia']) . "</span>
					<span style='display:none' class='d-none' id='marca" . $n . "'>" . trim($row['Marca']) . "</span>

					<span style='display:none' class='d-none' id='onvar" . $n . "'>" . trim($row['OnVariacion']) . "</span>
					<span style='display:none' class='d-none' id='codpad" . $n . "'>" . trim($row['CodIdBasicoPadre']) . "</span>

					<span style='display:none' class='d-none' id='despadr" . $n . "'>" . trim($row['DescriPadre']) . "</span>
					<span style='display:none' class='d-none' id='codampare" . $n . "'>" . trim($row['CodIdAmpPadre']) . "</span> 

					<span style='display:none' class='d-none' id='grpv" . $n . "'>" . trim($row['Groupvar']) . "</span>
					<span style='display:none' class='d-none' id='txtv" . $n . "'>" . trim($row['Textvar']) . "</span>


					<span style='display:none' class='d-none' id='min" . $n . "'>" . trim($row['Min']) . "</span> 
					<span style='display:none' class='d-none' id='max" . $n . "'>" . trim($row['Max']) . "</span>
					<span style='display:none' class='d-none' id='exis" . $n . "'>" . trim($row['Exis']) . "</span>
					<span style='display:none' class='d-none' id='porkilo" . $n . "'>" . trim($row['PorKilo']) . "</span> 
					<span style='display:none' class='d-none' id='escompuesto" . $n . "'>" . trim($row['EsCompuesto']) . "</span>
					<span style='display:none' class='d-none' id='bodega" . $n . "'>" . trim($row['bodega']) . "</span>
					<span style='display:none' class='d-none' id='sala" . $n . "'>" . trim($row['sala']) . "</span>
					<span style='display:none' class='d-none' id='Margen200" . $n . "'>" . trim($row['Margen2']) . "</span>
					<span style='display:none' class='d-none' id='PrecioVenta2" . $n . "'>" . trim($row['PrecioVenta2']) . "</span>
					<span style='display:none' class='d-none' id='PrecioNeto2" . $n . "'>" . trim($row['PrecioNeto2']) . "</span>
					<span style='display:none' class='d-none' id='Margen4" . $n . "'>" . trim($row['Margen4']) . "</span>
					<span style='display:none' class='d-none' id='Margen5" . $n . "'>" . trim($row['Margen5']) . "</span>
					<span style='display:none' class='d-none' id='Margen6" . $n . "'>" . trim($row['Margen6']) . "</span>
					<span style='display:none' class='d-none' id='Margen7" . $n . "'>" . trim($row['Margen7']) . "</span>
					<span style='display:none' class='d-none' id='Margen8" . $n . "'>" . trim($row['Margen8']) . "</span>
					<span style='display:none' class='d-none' id='Margen9" . $n . "'>" . trim($row['Margen9']) . "</span>
					<span style='display:none' class='d-none' id='Margen10" . $n . "'>" . trim($row['Margen10']) . "</span>

					<span style='display:none' class='d-none' id='PrecioVenta4" . $n . "'>" . trim($row['PrecioVenta4']) . "</span>
					<span style='display:none' class='d-none' id='PrecioNeto4" . $n . "'>" . trim($row['PrecioNeto4']) . "</span>

					<span style='display:none' class='d-none' id='PrecioVenta5" . $n . "'>" . trim($row['PrecioVenta5']) . "</span>
					<span style='display:none' class='d-none' id='PrecioNeto5" . $n . "'>" . trim($row['PrecioNeto5']) . "</span>

					
					<span style='display:none' class='d-none' id='PrecioVenta6" . $n . "'>" . trim($row['PrecioVenta6']) . "</span>
					<span style='display:none' class='d-none' id='PrecioNeto6" . $n . "'>" . trim($row['PrecioNeto6']) . "</span>

					<span style='display:none' class='d-none' id='PrecioVenta7" . $n . "'>" . trim($row['PrecioVenta7']) . "</span>
					<span style='display:none' class='d-none' id='PrecioNeto7" . $n . "'>" . trim($row['PrecioNeto7']) . "</span>

					<span style='display:none' class='d-none' id='PrecioVenta8" . $n . "'>" . trim($row['PrecioVenta8']) . "</span>
					<span style='display:none' class='d-none' id='PrecioNeto8" . $n . "'>" . trim($row['PrecioNeto8']) . "</span>

					<span style='display:none' class='d-none' id='PrecioVenta9" . $n . "'>" . trim($row['PrecioVenta9']) . "</span>
					<span style='display:none' class='d-none' id='PrecioNeto9" . $n . "'>" . trim($row['PrecioNeto9']) . "</span>

					<span style='display:none' class='d-none' id='PrecioVenta10" . $n . "'>" . trim($row['PrecioVenta10']) . "</span>
					<span style='display:none' class='d-none' id='PrecioNeto10" . $n . "'>" . trim($row['PrecioNeto10']) . "</span>

					<span style='display:none' class='d-none' id='CantP4x" . $n . "'>" . trim($row['CantP4']) . "</span>
					<span style='display:none' class='d-none' id='UnidadP4x" . $n . "'>" . trim($row['UnidadP4']) . "</span>

					<span style='display:none' class='d-none' id='CantP5x" . $n . "'>" . trim($row['CantP5']) . "</span>
					<span style='display:none' class='d-none' id='UnidadP5x" . $n . "'>" . trim($row['UnidadP5']) . "</span>
					<span style='display:none' class='d-none' id='CantP6x" . $n . "'>" . trim($row['CantP6']) . "</span>
					<span style='display:none' class='d-none' id='UnidadP6x" . $n . "'>" . trim($row['UnidadP6']) . "</span>
					<span style='display:none' class='d-none' id='CantP7x" . $n . "'>" . trim($row['CantP7']) . "</span>
					<span style='display:none' class='d-none' id='UnidadP7x" . $n . "'>" . trim($row['UnidadP7']) . "</span>
					<span style='display:none' class='d-none' id='CantP8x" . $n . "'>" . trim($row['CantP8']) . "</span>
					<span style='display:none' class='d-none' id='UnidadP8x" . $n . "'>" . trim($row['UnidadP8']) . "</span>
					<span style='display:none' class='d-none' id='CantP9x" . $n . "'>" . trim($row['CantP9']) . "</span>
					<span style='display:none' class='d-none' id='UnidadP9x" . $n . "'>" . trim($row['UnidadP9']) . "</span>
					<span style='display:none' class='d-none' id='CantP10x" . $n . "'>" . trim($row['CantP10']) . "</span>
					<span style='display:none' class='d-none' id='UnidadP10x" . $n . "'>" . trim($row['UnidadP10']) . "</span>

					<span style='display:none' class='d-none' id='Margen3" . $n . "'>" . trim($row['Margen3']) . "</span>
					<span style='display:none' class='d-none' id='PrecioVenta3" . $n . "'>" . trim($row['PrecioVenta3']) . "</span>
					<span style='display:none' class='d-none' id='PrecioNeto3" . $n . "'>" . trim($row['PrecioNeto3']) . "</span>
					<span style='display:none' class='d-none' id='CantP1x" . $n . "'>" . trim($row['CantP1']) . "</span>
					<span style='display:none' class='d-none' id='UnidadP1x" . $n . "'>" . trim($row['UnidadP1']) . "</span>
					<span style='display:none' class='d-none' id='CantP2" . $n . "'>" . trim($row['CantP2']) . "</span>
					<span style='display:none' class='d-none' id='UnidadP2x" . $n . "'>" . trim($row['UnidadP2']) . "</span>
					<span style='display:none' class='d-none' id='comple" . $n . "'>" . trim($row['Complementos']) . "</span>
					<span style='display:none' class='d-none' id='FactorAlter" . $n . "'>" .  ((($row["FactorAlter"]))) . "</span>
					<span style='display:none' class='d-none' id='UnidadAlter" . $n . "'>" . trim($row['UnidadAlter']) . "</span>
					<span style='display:none' class='d-none' id='ubicacionesper" . $n . "'>" . trim($row['ubicacionesper']) . "</span>
					<span style='display:none' class='d-none' id='enviableABCC" . $n . "'>" . trim($row['enviable']) . "</span>
					<span style='display:none' class='d-none' id='pesoActual" . $n . "'>" . trim($row['peso']) . "</span>
					<span style='display:none' class='d-none' id='FinanciableAct" . $n . "'>" . trim($row['Financiable']) . "</span>
					<span style='display:none' id='CodIdBasicoMasterYI" . $n . "'>" . $row["CodIdBasico"] . "</span>
					
					<span style='display:none' id='factorunit" . $n . "'>" . $row["factorunit"] . "</span>
					<span style='display:none' id='ancho" . $n . "'>" . $row["ancho"] . "</span>
					<span style='display:none' id='alto" . $n . "'>" . $row["alto"] . "</span>
					<span style='display:none' id='com" . $n . "'>" . $comision . "</span>
					<span style='display:none' id='comd" . $n . "'>" . $comision2 . "</span>
					<span style='display:none' id='comt" . $n . "'>" . $comision3 . "</span>
					<span style='display:none' id='comcua" . $n . "'>" . $comision4 . "</span>
					<span style='display:none' id='com5" . $n . "'>" . $comision5 . "</span>
					<span style='display:none' id='com6" . $n . "'>" . $comision6 . "</span>
					<span style='display:none' id='com7" . $n . "'>" . $comision7 . "</span>
					<span style='display:none' id='com8" . $n . "'>" . $comision8 . "</span>
					<span style='display:none' id='com9" . $n . "'>" . $comision9 . "</span>
					<span style='display:none' id='com10" . $n . "'>" . $comision10 . "</span>
					<span style='display:none' id='jsonfactor" . $n . "'>" . trim($row["jsonfactor"]) . "</span>
				
					<div class='d-flex text-start'>
						<div class='d-none d-sm-block'>
							<div class='p-1'>" . $images . "</div>
						</div>
						<div class='text-wrap p-1'>
							<div class='p-1 text-center d-block d-sm-none'>" . (trim($images) == "<div class='p-1'><img src='../img/no-photo-available2.png' alt='' width='100' srcset=''></div>" ? ' ' : ' ' . $images . '') . "</div>
							" . (trim($images) == "<div class='p-1'><img src='../img/no-photo-available2.png' alt='' width='100' srcset=''></div>" ? '' : '<br>') . "
							<strong>" . $row["Descripcion"] . "</strong>  " . $textVariation . $variations . "  </br>
							<span class='badge bg-light text-dark'>" . lang("SKU") . ": " . $row["CodIdAmpliado"] . '</span> <span class="badge bg-light text-dark text-wrap" style="overflow-wrap: break-word;max-width: 250px;">' . lang("BarCode") . ': <span class="fa fa-barcode"></span> ' . $row["CodBarra"] . '</span> <span class="badge bg-light text-dark">' . lang("ID") . ': ' . $row["CodIdBasico"] . ' </span></br>' .
			' <span class="badge bg-primary text-light">' . $row["Marcaxd"] . '</span>' .
			' <span class="badge bg-info text-dark">' . $familia . '</span> ' .
			($row["PorKilo"] == 1 ? ' <span class="badge bg-success text-light">' . lang("POR PESO") . '</span>' : '') .
			' <span class="badge bg-danger text-light">' . $row["ImpuestoName"] . ' (' . $row["ImpuestoPorcentaje"] . '%)</span> ' .
			($row["Estado"] == 1 ? ' <span class="badge bg-success text-light"><span class="fa fa-arrow-up"></span> ' . lang("ACTIVO") . '</span>' : ' <span class="badge bg-danger text-light"><span class="fa fa-arrow-down"></span> ' . lang("INACTIVO") . '</span>') .
			($row["esserial"] == 1 ? ' <span class="badge bg-warning text-dark"><span class="fa fa-barcode"></span> ' . lang("SERIAL") . '</span>' : '') .
			($row["eslote"] == 1 ? ' <span class="badge bg-warning text-dark"><span class="fa fa-calendar-check-o"></span> Lotes y Vencimiento</span>' : '') .
			($row["EsCompuesto"] == 0 ? ' <span class="badge bg-success text-light"><span class="fa fa-dropbox"></span> ' . lang("PRODUCTO") . '</span>' : ($row["EsCompuesto"] == 9 ? ' <span class="badge bg-success text-light"> ' . lang("SERVICIO") . '</span>' : ' <span class="badge bg-danger text-light"> ' . lang("COMBO - SET - PACK") . '</span>')) . $Hashtags . "
							" . ($row["esmedida"] == 1 ?
				'<span class="badge bg-warning text-dark me-1">' . $row["alto"] . " x " . $row["ancho"] . ' </span>' .
				'<span class="badge bg-warning text-dark me-1"> 1 = ' . ($row["factorunit"]) . ' ' . $row["Medida"] . '</span>' : "") . "
						</div>
					</div>
					<div class='d-flex justify-content-center text-wrap '>
					" . ($post["userperfil"] !== "3100" ? "
					<button class='btn btn-outline-info p-1 m-1' type='button' data-toggle='tooltip' title='" . lang("Información de Productos") . "' id='editar1' onclick='recibir(" . $n . ",`" . $var . "`);''><span class='fa fa-info-circle'></span></button>
					" . $comp . "
					" . $price . " 
					" . $inv . "
					" . $elimin . " 
					<button class='btn btn-outline-warning p-1 m-1' type='button' title='" . lang("Imagen del Producto") . "' id='editar31' onclick='recibir4(" . $n . ");'><span class='fa fa-image'></span></button>
					" . $varprod . "
					<button class=' btn btn-outline-primary  p-1 m-1' type='button' title='" . lang("Información Web") . "'  onclick='html(" . $n . ")'><span class='fa fa-globe'></span></button>
					" . $aud . "
					" : "") . "
						
					</div>";



		$buttons = "";

		if (($post["userperfil"] <= 2000 || $post["userperfil"] == "2055" || $post["userperfil"] == "2054" || $post["userperfil"] == "2053" || $post["userperfil"] === "2400" || $post["userperfil"] === "2410"  || ($post["userlogin"] === "CAJACHICA" && $post["IdCompany"] === "1069")) && $row["EsCompuesto"] == 0) {
			$buttons .= '<button class="btn btn-outline-dark p-1  mt-1" type="button" title="' . lang('Kardex') . '" onclick="HistoricoSerial2(`' . $row["CodIdBasico"] . '`,`' . $row["Descripcion"] . '`)"> <i class="fa fa-eye"></i> ' . lang("Kardex") . '</button>';
		}
		if ($post["userperfil"] <= 2000  && $row["EsCompuesto"] == 0) {
			$buttons .= '<button class="btn btn-outline-success p-1 mt-1" type="button" title="' . lang('Estadistica') . '" onclick="EstadisticaProductos(`' . $row["CodIdBasico"] . '`,`' . $row["Descripcion"] . '`)">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bar-chart" viewBox="0 0 16 16">
					<path d="M4 11H2v3h2zm5-4H7v7h2zm5-5v12h-2V2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1z"/>
				</svg> 
				' . lang("Estadística") . '</button>';
		}
		$subdata[] = $PosStock . $buttons;

		$PosPVP = "";
		$Margen01 = "";
		$Margen02 = "";
		$Margen03 = "";
		$Margen04 = "";
		$Margen05 = "";
		$Margen06 = "";
		$Margen07 = "";
		$Margen08 = "";
		$Margen09 = "";
		$Margen10 = "";
		// || $post["userperfil"] == "2055" || $post["userperfil"] == "2054" || $post["userperfil"] == "2053"
		if ($post["userperfil"] <= 2000) {
			if ($row["porcentual"] === "0") {
				$PosPVP = "<span class='badge bg-light text-dark'>" . (trim($CompanyData["LitCosto"]) !== "" ? $CompanyData["LitCosto"] : lang("Costo")) . "</span> <span class='badge bg-warning text-dark'>" . number_format(($CompanyData["VisualizaPrecio"] !== "1" ? $row['Costo'] : $row["CostoNeto"]), $post["CD"], $post["SimDec"], $post["SimMil"]) . " " . $post["MonedaP"] . "</span>  " . $Medida . " " . ($row["esmedida"] == 1 ? " <span class='badge bg-warning text-dark me-1'>x " . $row["factorunit"] . " = " . ROUND($row["factorunit"] * $row['Costo'], $post["CD"]) . "</span> " : "") . "</br>";
			} else {
				$PosPVP = "<span class='badge bg-light text-dark'>" . (trim($CompanyData["LitCosto"]) !== "" ? $CompanyData["LitCosto"] : lang("Costo")) . "</span> <span class='badge bg-warning text-dark'>" . number_format($row['CostoPorcentaje'], $post["CD"], $post["SimDec"], $post["SimMil"]) . " %</span>  " . $Medida . "</br>";
			}
			$Margen01 = "<span class='badge bg-dark text-light'>" . number_format($row['Margen'], $post["CD"], $post["SimDec"], $post["SimMil"]) . "%</span>";
			$Margen02 = "<span class='badge bg-dark text-light'>" . number_format($row['Margen2'], $post["CD"], $post["SimDec"], $post["SimMil"]) . "%</span>";
			$Margen03 = "<span class='badge bg-dark text-light'>" . number_format($row['Margen3'], $post["CD"], $post["SimDec"], $post["SimMil"]) . "%</span>";
			$Margen04 = "<span class='badge bg-dark text-light'>" . number_format($row['Margen4'], $post["CD"], $post["SimDec"], $post["SimMil"]) . "%</span>";
			$Margen05 = "<span class='badge bg-dark text-light'>" . number_format($row['Margen5'], $post["CD"], $post["SimDec"], $post["SimMil"]) . "%</span>";
			$Margen06 = "<span class='badge bg-dark text-light'>" . number_format($row['Margen6'], $post["CD"], $post["SimDec"], $post["SimMil"]) . "%</span>";
			$Margen07 = "<span class='badge bg-dark text-light'>" . number_format($row['Margen7'], $post["CD"], $post["SimDec"], $post["SimMil"]) . "%</span>";
			$Margen08 = "<span class='badge bg-dark text-light'>" . number_format($row['Margen8'], $post["CD"], $post["SimDec"], $post["SimMil"]) . "%</span>";
			$Margen09 = "<span class='badge bg-dark text-light'>" . number_format($row['Margen9'], $post["CD"], $post["SimDec"], $post["SimMil"]) . "%</span>";
			$Margen10 = "<span class='badge bg-dark text-light'>" . number_format($row['Margen10'], $post["CD"], $post["SimDec"], $post["SimMil"]) . "%</span>";
		}

		if ($p1 == 1 && $row['PrecioNeto'] > 0) $PosPVP .= "<div><span class='badge bg-light text-dark'> " . (trim($CompanyData["LitP01"]) !== "" ? $CompanyData["LitP01"] : lang("Precio") . " 1") . " </span> " . $Margen01 . " <span class='badge bg-warning text-dark'>" . number_format(($CompanyData["VisualizaPrecio"] !== "1" ? $row['PrecioVenta'] : $row['PrecioNeto']), $post["CD"], $post["SimDec"], $post["SimMil"]) . " " . $post["MonedaP"] . "</span> " . $Medida . " " . ($row["esmedida"] == 1 ? " <span class='badge bg-warning text-dark me-1'>x " . $row["factorunit"] . " = " . ROUND($row["factorunit"] * (($CompanyData["VisualizaPrecio"] !== "1" ? $row['PrecioVenta'] : $row['PrecioNeto'])), $post["CD"]) . "</span> " : "") . "</br>";

		if ($p2 == 1 && $row['PrecioNeto2'] > 0) $PosPVP .= "<div><span class='badge bg-light text-dark'> " . (trim($CompanyData["LitP02"]) !== "" ? $CompanyData["LitP02"] : lang("Precio") . " 2") . " </span> " . $Margen02 . " <span class='badge bg-warning text-dark'>" . number_format(($CompanyData["VisualizaPrecio"] !== "1" ? $row['PrecioVenta2'] : $row['PrecioNeto2']) / ($row["CantP1"] <> 0 ? $row["CantP1"] : 1), $post["CD"], $post["SimDec"], $post["SimMil"]) . " " . $post["MonedaP"] . "</span> " . $UnidadP1 . " " . ($row["esmedida"] == 1 ? " <span class='badge bg-warning text-dark  me-1'>x " . $row["factorunit"] . " = " . ROUND($row["factorunit"] * (($CompanyData["VisualizaPrecio"] !== "1" ? $row['PrecioVenta2'] : $row['PrecioNeto2']) / $row["CantP1"]), $post["CD"]) . "</span> " : "") . "</div>";

		if ($p3 == 1 && $row['PrecioNeto3'] > 0) $PosPVP .= "<div><span class='badge bg-light text-dark'> " . (trim($CompanyData["LitP03"]) !== "" ? $CompanyData["LitP03"] : lang("Precio") . " 3") . " </span> " . $Margen03 . " <span class='badge bg-warning text-dark'>" . number_format(($CompanyData["VisualizaPrecio"] !== "1" ? $row['PrecioVenta3'] : $row['PrecioNeto3']) / ($row["CantP2"] <> 0 ? $row["CantP2"] : 1), $post["CD"], $post["SimDec"], $post["SimMil"]) . " " . $post["MonedaP"] . "</span> " . $UnidadP2 . " " . ($row["esmedida"] == 1 ? " <span class='badge bg-warning text-dark  me-1'>x " . $row["factorunit"] . " = " . ROUND($row["factorunit"] * (($CompanyData["VisualizaPrecio"] !== "1" ? $row['PrecioVenta3'] : $row['PrecioNeto3']) / $row["CantP2"]), $post["CD"]) . "</span> " : "") . "</div>";

		if ($p4 == 1 && $row['PrecioNeto4'] > 0) $PosPVP .= "<div><span class='badge bg-light text-dark'> " . (trim($CompanyData["LitP04"]) !== "" ? $CompanyData["LitP04"] : lang("Precio") . " 4") . " </span> " . $Margen04 . " <span class='badge bg-warning text-dark'>" . number_format(($CompanyData["VisualizaPrecio"] !== "1" ? $row['PrecioVenta4'] : $row['PrecioNeto4']) / ($row["CantP4"] <> 0 ? $row["CantP4"] : 1), $post["CD"], $post["SimDec"], $post["SimMil"]) . " " . $post["MonedaP"] . "</span> " . $UnidadP4 . " " . ($row["esmedida"] == 1 ? " <span class='badge bg-warning text-dark  me-1'>x " . $row["factorunit"] . " = " . ROUND($row["factorunit"] * (($CompanyData["VisualizaPrecio"] !== "1" ? $row['PrecioVenta4'] : $row['PrecioNeto4']) / $row["CantP4"]), $post["CD"]) . "</span> " : "") . "</div>";

		if ($p5 == 1 && $row['PrecioNeto5'] > 0) $PosPVP .= "<div><span class='badge bg-light text-dark'> " . (trim($CompanyData["LitP05"]) !== "" ? $CompanyData["LitP05"] : lang("Precio") . " 5") . " </span> " . $Margen05 . " <span class='badge bg-warning text-dark'>" . number_format(($CompanyData["VisualizaPrecio"] !== "1" ? $row['PrecioVenta5'] : $row['PrecioNeto5']) / ($row["CantP5"] <> 0 ? $row["CantP5"] : 1), $post["CD"], $post["SimDec"], $post["SimMil"]) . " " . $post["MonedaP"] . "</span> " . $UnidadP5 . " " . ($row["esmedida"] == 1 ? " <span class='badge bg-warning text-dark  me-1'>x " . $row["factorunit"] . " = " . ROUND($row["factorunit"] * (($CompanyData["VisualizaPrecio"] !== "1" ? $row['PrecioVenta5'] : $row['PrecioNeto5']) / $row["CantP5"]), $post["CD"]) . "</span> " : "") . "</div>";

		if ($p6 == 1  && $row['PrecioNeto6'] > 0) $PosPVP .= "<div><span class='badge bg-light text-dark'> " . (trim($CompanyData["LitP06"]) !== "" ? $CompanyData["LitP06"] : lang("Precio") . " 6") . " </span> " . $Margen06 . " <span class='badge bg-warning text-dark'>" . number_format(($CompanyData["VisualizaPrecio"] !== "1" ? $row['PrecioVenta6'] : $row['PrecioNeto6']) / ($row["CantP6"] <> 0 ? $row["CantP6"] : 1), $post["CD"], $post["SimDec"], $post["SimMil"]) . " " . $post["MonedaP"] . "</span> " . $UnidadP6 . " " . ($row["esmedida"] == 1 ? " <span class='badge bg-warning text-dark  me-1'>x " . $row["factorunit"] . " = " . ROUND($row["factorunit"] * (($CompanyData["VisualizaPrecio"] !== "1" ? $row['PrecioVenta6'] : $row['PrecioNeto6']) / $row["CantP6"]), $post["CD"]) . "</span> " : "") . "</div>";

		if ($p7 == 1  && $row['PrecioNeto7'] > 0) $PosPVP .= "<div><span class='badge bg-light text-dark'> " . (trim($CompanyData["LitP07"]) !== "" ? $CompanyData["LitP07"] : lang("Precio") . " 7") . " </span> " . $Margen07 . " <span class='badge bg-warning text-dark'>" . number_format(($CompanyData["VisualizaPrecio"] !== "1" ? $row['PrecioVenta7'] : $row['PrecioNeto7']) / ($row["CantP7"] <> 0 ? $row["CantP7"] : 1), $post["CD"], $post["SimDec"], $post["SimMil"]) . " " . $post["MonedaP"] . "</span> " . $UnidadP7 . " " . ($row["esmedida"] == 1 ? " <span class='badge bg-warning text-dark  me-1'>x " . $row["factorunit"] . " = " . ROUND($row["factorunit"] * (($CompanyData["VisualizaPrecio"] !== "1" ? $row['PrecioVenta7'] : $row['PrecioNeto7']) / $row["CantP7"]), $post["CD"]) . "</span> " : "") . "</div>";

		if ($p8 == 1  && $row['PrecioNeto8'] > 0) $PosPVP .= "<div><span class='badge bg-light text-dark'> " . (trim($CompanyData["LitP08"]) !== "" ? $CompanyData["LitP08"] : lang("Precio") . " 8") . " </span> " . $Margen08 . " <span class='badge bg-warning text-dark'>" . number_format(($CompanyData["VisualizaPrecio"] !== "1" ? $row['PrecioVenta8'] : $row['PrecioNeto8']) / ($row["CantP8"] <> 0 ? $row["CantP8"] : 1), $post["CD"], $post["SimDec"], $post["SimMil"]) . " " . $post["MonedaP"] . "</span> " . $UnidadP8 . " " . ($row["esmedida"] == 1 ? " <span class='badge bg-warning text-dark  me-1'>x " . $row["factorunit"] . " = " . ROUND($row["factorunit"] * (($CompanyData["VisualizaPrecio"] !== "1" ? $row['PrecioVenta8'] : $row['PrecioNeto8']) / $row["CantP8"]), $post["CD"]) . "</span> " : "") . "</div>";

		if ($p9 == 1  && $row['PrecioNeto9'] > 0) $PosPVP .= "<div><span class='badge bg-light text-dark'> " . (trim($CompanyData["LitP09"]) !== "" ? $CompanyData["LitP09"] : lang("Precio") . " 9") . " </span> " . $Margen09 . " <span class='badge bg-warning text-dark'>" . number_format(($CompanyData["VisualizaPrecio"] !== "1" ? $row['PrecioVenta9'] : $row['PrecioNeto9']) / ($row["CantP9"] <> 0 ? $row["CantP9"] : 1), $post["CD"], $post["SimDec"], $post["SimMil"]) . " " . $post["MonedaP"] . "</span> " . $UnidadP9 . " " . ($row["esmedida"] == 1 ? " <span class='badge bg-warning text-dark  me-1'>x " . $row["factorunit"] . " = " . ROUND($row["factorunit"] * (($CompanyData["VisualizaPrecio"] !== "1" ? $row['PrecioVenta9'] : $row['PrecioNeto9']) / $row["CantP9"]), $post["CD"]) . "</span> " : "") . "</div>";

		if ($p10 == 1  && $row['PrecioNeto10'] > 0) $PosPVP .= "<div><span class='badge bg-light text-dark'> " . (trim($CompanyData["LitP10"]) !== "" ? $CompanyData["LitP10"] : lang("Precio") . " 10") . " </span> " . $Margen10 . " <span class='badge bg-warning text-dark'>" . number_format(($CompanyData["VisualizaPrecio"] !== "1" ? $row['PrecioVenta10'] : $row['PrecioNeto10']) / ($row["CantP10"] <> 0 ? $row["CantP10"] : 1), $post["CD"], $post["SimDec"], $post["SimMil"]) . " " . $post["MonedaP"] . "</span> " . $UnidadP10 . " " . ($row["esmedida"] == 1 ? " <span class='badge bg-warning text-dark  me-1'>x " . $row["factorunit"] . " = " . ROUND($row["factorunit"] * (($CompanyData["VisualizaPrecio"] !== "1" ? $row['PrecioVenta10'] : $row['PrecioNeto10']) / $row["CantP10"]), $post["CD"]) . "</span> " : "") . "</div>";

		$subdata[] = $PosPVP;
		$data[] = $subdata;
	}

	$json_data = array(
		"draw"              =>  intval($request['draw']),
		"recordsTotal"      =>  intval($totalData),
		"recordsFiltered"   =>  intval($totalFilter),
		"data"              =>  $data,
		"sql2" => $sql2,
		"sqlA" => $sqlA,
	);

	return json_encode($json_data);
}



function randomColor()
{
	$str = "#";
	for ($i = 0; $i < 6; $i++) {
		$randNum = rand(0, 15);
		switch ($randNum) {
			case 10:
				$randNum = "A";
				break;
			case 11:
				$randNum = "B";
				break;
			case 12:
				$randNum = "C";
				break;
			case 13:
				$randNum = "D";
				break;
			case 14:
				$randNum = "E";
				break;
			case 15:
				$randNum = "F";
				break;
		}
		$str .= $randNum;
	}
	return $str;
}

function mostrarExistencias($conn, $post)
{
	$IdCompany = $post["CompanyActual"];

	$sql2 = "";

	if ($post['VisualExist'] === '0') {

		$sql2 = "
				select dt.CodIdBasico, dt.IdAlm,alm.IdUbi,alm.nombre as Almacen,sum(dt.qty_on_hand) as Cantidad,alm.IdAtt, prod.CostoNeto, prod.FactorAlter, prod.UnidadAlter, prod.factorunit, prod.Medida,
				g.esserial,g.eslote,coalesce(f.DescripcionLarga,'') as DL, '' as DescriPadre, '' as CodIdAmpPadre,
							f.DescripcionCorta as DC
				from
	inv_existencias as dt
					inner join PosUpAlmacen alm on alm.IdCompany=dt.IdCompany and alm.IdAlm=dt.IdAlm and alm.tipo <> 4 
					inner join PosUpProducto prod on prod.IdCompany = dt.IdCompany and prod.CodIdBasico = dt.CodIdBasico
					left join  PosUpProductoWeb f on a.IdCompany=f.IdCompany  and a.CodIdBasico=f.CodIdBasico 
					left join PosUpvarios g on g.IdCompany = prod.IdCompany and g.IdVarios = prod.Idfamilia and g.TIPOITEM = 2
					group by dt.IdCompany, dt.CodIdBasico, dt.IdAlm
			";
	} else if ($post['VisualExist'] === '1') {


		$sql2 = " select dt.CodIdBasico, dt.IdAlm,alm.IdUbi,ubix.nombre as Almacen,sum(dt.qty_on_hand) as Cantidad,alm.IdAtt, prod.CostoNeto, prod.FactorAlter, prod.UnidadAlter, prod.factorunit, prod.Medida,
				g.esserial,g.eslote,coalesce(f.DescripcionLarga,'') as DL, '' as DescriPadre, '' as CodIdAmpPadre,
							f.DescripcionCorta as DC
	from
	inv_existencias as dt
				inner join PosUpAlmacen alm on alm.IdCompany=dt.IdCompany and alm.IdAlm=dt.IdAlm and alm.tipo <> 4 
				inner join posupubicacion ubix on alm.IdCompany=ubix.IdCompany and alm.IdUbi=ubix.IdUbi 
				inner join PosUpProducto prod on prod.IdCompany = dt.IdCompany and prod.CodIdBasico = dt.CodIdBasico
				left join  PosUpProductoWeb f on a.IdCompany=f.IdCompany  and a.CodIdBasico=f.CodIdBasico 
				left join PosUpvarios g on g.IdCompany = prod.IdCompany and g.IdVarios = prod.Idfamilia and g.TIPOITEM = 2
				group by dt.IdCompany, dt.CodIdBasico, alm.IdUbi

		";
	} else if ($post['VisualExist'] === '2') {

		$sql2 = "
			select dt.CodIdBasico, dt.IdAlm,alm.IdUbi,att.nombre as Almacen,sum(dt.qty_on_hand) as Cantidad,alm.IdAtt, prod.CostoNeto, prod.FactorAlter, prod.UnidadAlter, prod.factorunit, prod.Medida,
				g.esserial,g.eslote
from
	inv_existencias as dt
				inner join PosUpAlmacen alm on alm.IdCompany=dt.IdCompany and alm.IdAlm=dt.IdAlm and alm.tipo <> 4 
				inner join posupzonaatt att on att.IdCompany=alm.IdCompany and att.IdAtt = alm.IdAtt
				inner join PosUpProducto prod on prod.IdCompany = dt.IdCompany and prod.CodIdBasico = dt.CodIdBasico
				left join PosUpvarios g on g.IdCompany = prod.IdCompany and g.IdVarios = prod.Idfamilia and g.TIPOITEM = 2
				group by dt.IdCompany, dt.CodIdBasico, alm.IdAtt
	
			";
	}


	$query = mysqli_query($conn, $sql2);

	$ExisComp = 0;
	$OrdComp = 0;
	$PosStock = "";

	$IdAlmGroup = [];
	if (trim($_POST["IdAlmGroup"]) !== "") {
		$IdAlmGroup = explode(",", trim($_POST["IdAlmGroup"]));
	}
	$show = "";
	$Cantotal = 0;
	$CostoNeto = 0;
	$esserial = 0;
	$FactorAlter = 1;
	$factorunit = 1;
	$UnidadAlter = "";
	$Medida = "";
	while ($row = mysqli_fetch_array($query)) {
		$esserial = $row["esserial"];
		$CostoNeto = $row["CostoNeto"];
		$FactorAlter = $row["FactorAlter"];
		$factorunit = $row["factorunit"];
		$UnidadAlter = $row["UnidadAlter"];
		$Medida = $row["Medida"];

		if (
			(trim($post["VerStock"]) === "0")
			|| (trim($post["VerStock"]) === "1" && ($row["IdUbi"] === $post["sucursal"] || $post["sucursal"] === "0"))
			|| (trim($post["VerStock"]) === "2" && $row["IdAlm"] === $post["IdAlmVtaSeleccionada"])
			|| intval($post["VerStock"]) >= 100 && intval($row["IdAtt"]) === (intval($post["VerStock"]) / 100)
			|| in_array(trim($row["IdAlm"]), $IdAlmGroup)
		) {
			if (round($row["Cantidad"], $post["CD"]) > 0) {

				$show = "";

				if ($row["factorunit"] <> 1 && $row["factorunit"] <> 0) {
					$show = $row["factorunit"] . " x " . getcantformat($row["Cantidad"], $post["CD"], $post["SimDec"], $post["SimMil"]) . " = " . getcantformat($row["Cantidad"] * $row["factorunit"], $post["CD"], $post["SimDec"], $post["SimMil"])  . " " . $row["Medida"];
				} else if ($row["FactorAlter"] <> 1) {
					$show = getcantformat($row["Cantidad"], $post["CD"], $post["SimDec"], $post["SimMil"])  . " " . $row["Medida"] . " = " . getcantformat($row["Cantidad"] * $row["FactorAlter"], $post["CD"], $post["SimDec"], $post["SimMil"]) . " " . $row['UnidadAlter'];
				} else {
					$show = getcantformat($row["Cantidad"], $post["CD"], $post["SimDec"], $post["SimMil"])  . " " . $row["Medida"];
				}


				if ($row["IdAlm"] == $post["IdAlmVta"]) {
					$PosStock .= "
						<div class='d-flex align-items-center gap-2 mb-1 text-wrap'>
							<span class='badge bg-light text-dark'>" . $row["Almacen"] . "</span> 
							<span class='badge bg-success text-light'>" . $show . " <i class='fa fa-check'></i></span> 
							" . ($post["userperfil"] <= 2000 ? "<span class='badge bg-info text-dark'>" . number_format(($row['CostoNeto'] * $row["Cantidad"]), $post["CD"], $post["SimDec"], $post["SimMil"]) . " " . $post["MonedaP"] . "</span>" : "") . "
						</div>
					";
				} else {
					$PosStock .= "
						<div class='d-flex align-items-center gap-2 mb-1 text-wrap'>
							<span class='badge bg-light text-dark'>" . $row["Almacen"] . "</span> 
							<span class='badge bg-warning text-dark'>" . $show . "</span> 
							" . ($post["userperfil"] <= 2000 ? "<span class='badge bg-info text-dark'>" . number_format(($row['CostoNeto'] * $row["Cantidad"]), $post["CD"], $post["SimDec"], $post["SimMil"]) . " " . $post["MonedaP"] . "</span>" : "") . "
						</div>
					";
				}

				$Cantotal += round($row["Cantidad"], 3);
			}
		}
	}

	$show = "";

	if ($factorunit <> 1 && $factorunit <> 0) {
		$show = $factorunit . " x " . getcantformat($Cantotal, $post["CD"], $post["SimDec"], $post["SimMil"]) . " = " . getcantformat($Cantotal * $factorunit, $post["CD"], $post["SimDec"], $post["SimMil"])  . " " . $Medida;
	} else if ($FactorAlter <> 1) {
		$show = getcantformat($Cantotal, $post["CD"], $post["SimDec"], $post["SimMil"])  . " " . $Medida . " = " . getcantformat($Cantotal * $FactorAlter, $post["CD"], $post["SimDec"], $post["SimMil"]) . " " . $UnidadAlter;
	} else {
		$show = getcantformat($Cantotal, $post["CD"], $post["SimDec"], $post["SimMil"])  . " " . $Medida;
	}

	if ($Cantotal == 0) {
		$PosStock = "<span class='badge bg-danger text-light'>" . lang("Agotada") . "</span></br>";
	} else {
		$PosStock .= "<div class='d-flex align-items-center gap-2 mb-1 text-wrap'><span class='badge bg-success text-light'>" . lang("Total Stock") . "</span> <span class='badge bg-warning text-dark'>" . $show . " </span>  " . ($post["userperfil"] <= 2000 ? "<span class='badge bg-info text-dark'>" . number_format(($CostoNeto * $Cantotal), $post["CD"], $post["SimDec"], $post["SimMil"]) . " " . $post["MonedaP"] . "</span>" : "") . "</div>";
	}


	$sql2 =   "
			SELECT a.IdCompany, a.CodIdBasico,sum(if(d.CompInv =-1,a.Cant,0)) as ExisComp,sum(if(d.CompInv=1,a.Cant,0)) as OrdComp
			from PosUpTxD a
			inner join PosUpTx d on d.Idtipotx=a.Idtipotx and d.CompInv <> 0
			where a.IdCompany=" . $IdCompany . "  and a.CodIdBasico = '" . $post["CodIdBasico"] . "'
			group by a.IdCompany,a.CodIdBasico
		";
	$query = mysqli_query($conn, $sql2);
	while ($row = mysqli_fetch_array($query)) {
		$ExisComp += $row["ExisComp"];
		$OrdComp += $row["OrdComp"];
	}

	if ($ExisComp <> 0) {
		$PosStock .= "<div><span class='badge bg-danger text-light'>" . lang('Pedidos') . ' / ' . lang("Clientes") . '</span> <span class="badge bg-warning text-dark">' . getcantformat(abs($ExisComp), $post["CD"], $post["SimDec"], $post["SimMil"]) . " " . $Medida . "</span></strong></div>";
	}

	if ($OrdComp <> 0) {
		$PosStock .= "<div><span class='badge bg-info text-dark'>" . lang('OC') . ' / ' . lang("Proveedor") . '</span> <span class="badge bg-warning text-dark">' . getcantformat($OrdComp, $post["CD"], $post["SimDec"], $post["SimMil"]) . " " . $Medida . "</span></strong></div>";
	}
	if ($esserial == 1) {
		//$PosStock .= "<div><button class='btn btn-outline-success p-1 mt-1' type='button ' onclick='abrir123435(" . $post["n"] . ")'><i class='fa fa-barcode'></i> " . ucwords(strtolower(lang("Ver Seriales"))) . "</button></div>";
	}
	return $PosStock;
}

function EstadisticaProductox($conn, $post)
{
	if ($post["MostrarDatosA"] === "0") {
		$sql = "
		select
	coalesce(b.CodIdBasico, '') as CodIdBasico,
	coalesce(b.idalm, a.IdAlm) as idalm,
	coalesce(b.Almacen, a.Nombre) as Almacen,
	coalesce(b.CantVtas, 0) as CantVtas,
	coalesce(b.Stock, 0) as Stock,
	coalesce(b.DiastockCero, 0) as DiastockCero,
	coalesce(b.dias, 0) as dias,
	coalesce(b.promvdiario, 0) as promvdiario
from
	PosUpAlmacen a
left join (
	select
		a.CodIdBasico,
		a.idalm,
		c.nombre as Almacen,
		sum(a.Cant * d.caja) as CantVtas,
		coalesce(i.Cantidad, 0) as Stock,
		truncate(coalesce(i.Cantidad, 0)/ round(sum(a.Cant * d.caja)/(datediff(max(a.Fectxclient), min(a.Fectxclient))+ 1), 2), 0) as DiastockCero,
		datediff(max(a.Fectxclient), min(a.Fectxclient))+ 1 as dias,
		round(sum(a.Cant * d.caja)/(datediff(max(a.Fectxclient), min(a.Fectxclient))+ 1), 2) as promvdiario
	from
		PosUpTxD a
	inner join PosUpAlmacen c on
		a.IdCompany = c.IdCompany
		and a.IdAlm = c.IdAlm
		and c.tipo <> 4
	inner join PosUpTx d on
		a.Idtipotx = d.Idtipotx
		and d.Idtipotx in (1, 2, 3, 15, 22)
	left join (
		select
			a.CodIdBasico,
			a.idalm,
			c.nombre as Almacen,
			sum(a.Cant * d.Inventario) as Cantidad,
			sum(if(d.CompInv =-1, a.Cant * d.Inventario, 0)) as ExisComp,
			sum(if(d.CompInv = 1, a.Cant, 0)) as OrdComp
		from
			PosUpTxD a
		left join PosUpAlmacen c on
			a.IdCompany = c.IdCompany
			and a.IdAlm = c.IdAlm
			and c.tipo <> 4
		left join PosUpTx d on
			a.Idtipotx = d.Idtipotx
			and (d.Inventario <> 0)
		where
			a.IdCompany = " . $post["CompanyActual"] . "
			and a.CodIdBasico = '" . $post["CodIdBasico"] . "'
		group by
			a.IdCompany,
			a.CodIdBasico,
			a.IdAlm ) i on
		a.CodIdBasico = i.codidbasico
		and a.IdAlm = i.idalm
	where
		a.IdCompany = " . $post["CompanyActual"] . "
		and a.CodIdBasico = '" . $post["CodIdBasico"] . "'
		and a.Fectxclient >= DATE_SUB(now(), interval 30 day)
	group by
		a.IdCompany,
		a.CodIdBasico,
		a.IdAlm
union all
	select
		a.CodIdBasico,
		a.idalm,
		c.nombre as Almacen,
		0 as CantVtas,
		sum(a.Cant * d.Inventario) as Stock,
		0 as DiastockCero,
		0 as dias,
		0 as promvdiario
	from
		PosUpTxD a
	left join PosUpAlmacen c on
		a.IdCompany = c.IdCompany
		and a.IdAlm = c.IdAlm
		and c.tipo <> 4
	left join PosUpTx d on
		a.Idtipotx = d.Idtipotx
		and (d.Inventario <> 0)
	where
			a.IdCompany = " . $post["CompanyActual"] . "
			and a.CodIdBasico = '" . $post["CodIdBasico"] . "'
		and a.idalm not in (
		select
			a.idalm
		from
			PosUpTxD a
		inner join PosUpAlmacen c on
			a.IdCompany = c.IdCompany
			and a.IdAlm = c.IdAlm
			and c.tipo <> 4
		inner join PosUpTx d on
			a.Idtipotx = d.Idtipotx
			and d.Idtipotx in (1, 2, 3, 15, 22)
		where
						a.IdCompany = " . $post["CompanyActual"] . "
						and a.CodIdBasico = '" . $post["CodIdBasico"] . "'
			and a.Fectxclient >= DATE_SUB(now(), interval 30 day)
		group by
			a.IdCompany,
			a.CodIdBasico,
			a.IdAlm )
	group by
		a.IdCompany,
		a.CodIdBasico,
		a.IdAlm
	order by
		Almacen ) as b on
	a.idalm = b.idalm
where
	a.IdCompany = " . $post["CompanyActual"];
	} else if ($post["MostrarDatosA"] === "1") {
		$sql = "
		select
	coalesce(b.CodIdBasico, '') as CodIdBasico,
	coalesce(b.IdUbi, a.IdUbi) as idalm,
	coalesce(b.Almacen, a.Nombre) as Almacen,
	coalesce(b.CantVtas, 0) as CantVtas,
	coalesce(b.Stock, 0) as Stock,
	coalesce(b.DiastockCero, 0) as DiastockCero,
	coalesce(b.dias, 0) as dias,
	coalesce(b.promvdiario, 0) as promvdiario
from
	PosUpUbicacion a
left join (
	select
		a.CodIdBasico,
		x.IdUbi,
		x.nombre as Almacen,
		sum(a.Cant * d.caja) as CantVtas,
		coalesce(i.Cantidad, 0) as Stock,
		truncate(coalesce(i.Cantidad, 0)/ round(sum(a.Cant * d.caja)/(datediff(max(a.Fectxclient), min(a.Fectxclient))+ 1), 2), 0) as DiastockCero,
		datediff(max(a.Fectxclient), min(a.Fectxclient))+ 1 as dias,
		round(sum(a.Cant * d.caja)/(datediff(max(a.Fectxclient), min(a.Fectxclient))+ 1), 2) as promvdiario
	from
		PosUpTxD a
	inner join PosUpAlmacen c on
		c.IdCompany = a.IdCompany
		and c.IdAlm = a.IdAlm
		and c.tipo <> 4
	inner join PosUpUbicacion x on
		x.IdCompany = c.IdCompany
		and x.IdUbi = c.IdUbi
	inner join PosUpTx d on
		a.Idtipotx = d.Idtipotx
		and d.Idtipotx in (1, 2, 3, 15, 22)
	left join (
		select
			a.CodIdBasico,
			x.IdUbi,
			x.nombre as Almacen,
			sum(a.Cant * d.Inventario) as Cantidad,
			sum(if(d.CompInv =-1, a.Cant * d.Inventario, 0)) as ExisComp,
			sum(if(d.CompInv = 1, a.Cant, 0)) as OrdComp
		from
			PosUpTxD a
		inner join PosUpAlmacen c on
			c.IdCompany = a.IdCompany
			and c.IdAlm = a.IdAlm
			and c.tipo <> 4
		inner join PosUpUbicacion x on
			x.IdCompany = c.IdCompany
			and x.IdUbi = c.IdUbi
		left join PosUpTx d on
			a.Idtipotx = d.Idtipotx
			and (d.Inventario <> 0)
		where
						a.IdCompany = " . $post["CompanyActual"] . "
						and a.CodIdBasico = '" . $post["CodIdBasico"] . "'
		group by
			a.IdCompany,
			a.CodIdBasico,
			x.IdUbi ) i on
		a.CodIdBasico = i.CodIdBasico
		and x.IdUbi = i.IdUbi
	where
						a.IdCompany = " . $post["CompanyActual"] . "
						and a.CodIdBasico = '" . $post["CodIdBasico"] . "'
		and a.Fectxclient >= DATE_SUB(now(), interval 30 day)
	group by
		a.IdCompany,
		a.CodIdBasico,
		x.IdUbi
union all
	select
		a.CodIdBasico,
			x.IdUbi,
			x.nombre as Almacen,
		0 as CantVtas,
		sum(a.Cant * d.Inventario) as Stock,
		0 as DiastockCero,
		0 as dias,
		0 as promvdiario
	from
		PosUpTxD a
	inner join PosUpAlmacen c on
			c.IdCompany = a.IdCompany
		and c.IdAlm = a.IdAlm
		and c.tipo <> 4
	inner join PosUpUbicacion x on
			x.IdCompany = c.IdCompany
		and x.IdUbi = c.IdUbi
	left join PosUpTx d on
		a.Idtipotx = d.Idtipotx
		and (d.Inventario <> 0)
	where
						a.IdCompany = " . $post["CompanyActual"] . "
						and a.CodIdBasico = '" . $post["CodIdBasico"] . "'
		and c.IdUbi not in (
		select
			c.IdUbi
		from
			PosUpTxD a
		inner join PosUpAlmacen c on
			c.IdCompany = a.IdCompany
			and c.IdAlm = a.IdAlm
			and c.tipo <> 4
		inner join PosUpTx d on
			a.Idtipotx = d.Idtipotx
			and d.Idtipotx in (1, 2, 3, 15, 22)
		where
						a.IdCompany = " . $post["CompanyActual"] . "
						and a.CodIdBasico = '" . $post["CodIdBasico"] . "'
			and a.Fectxclient >= DATE_SUB(now(), interval 30 day)
		group by
			a.IdCompany,
			a.CodIdBasico,
			c.IdUbi )
	group by
		a.IdCompany,
		a.CodIdBasico,
		x.IdUbi
	order by
		Almacen ) as b on
	a.IdUbi = b.IdUbi
where
	a.IdCompany = " . $post["CompanyActual"];
	} else if ($post["MostrarDatosA"] === "2") {
		$sql = "select
	coalesce(b.CodIdBasico, '') as CodIdBasico,
	coalesce(b.IdAtt, a.IdAtt) as idalm,
	coalesce(b.Almacen, a.Nombre) as Almacen,
	coalesce(b.CantVtas, 0) as CantVtas,
	coalesce(b.Stock, 0) as Stock,
	coalesce(b.DiastockCero, 0) as DiastockCero,
	coalesce(b.dias, 0) as dias,
	coalesce(b.promvdiario, 0) as promvdiario
from
	posupzonaatt a
left join (
	select
		a.CodIdBasico,
		x.IdAtt,
		x.nombre as Almacen,
		sum(a.Cant * d.caja) as CantVtas,
		coalesce(i.Cantidad, 0) as Stock,
		truncate(coalesce(i.Cantidad, 0)/ round(sum(a.Cant * d.caja)/(datediff(max(a.Fectxclient), min(a.Fectxclient))+ 1), 2), 0) as DiastockCero,
		datediff(max(a.Fectxclient), min(a.Fectxclient))+ 1 as dias,
		round(sum(a.Cant * d.caja)/(datediff(max(a.Fectxclient), min(a.Fectxclient))+ 1), 2) as promvdiario
	from
		PosUpTxD a
	inner join PosUpAlmacen c on
		c.IdCompany = a.IdCompany
		and c.IdAlm = a.IdAlm
		and c.tipo <> 4
	inner join posupzonaatt x on
		x.IdCompany = c.IdCompany
		and x.IdAtt = c.IdAtt
	inner join PosUpTx d on
		a.Idtipotx = d.Idtipotx
		and d.Idtipotx in (1, 2, 3, 15, 22)
	left join (
		select
			a.CodIdBasico,
			x.IdAtt,
			x.nombre as Almacen,
			sum(a.Cant * d.Inventario) as Cantidad,
			sum(if(d.CompInv =-1, a.Cant * d.Inventario, 0)) as ExisComp,
			sum(if(d.CompInv = 1, a.Cant, 0)) as OrdComp
		from
			PosUpTxD a
	inner join PosUpAlmacen c on
		c.IdCompany = a.IdCompany
		and c.IdAlm = a.IdAlm
		and c.tipo <> 4
	inner join posupzonaatt x on
		x.IdCompany = c.IdCompany
		and x.IdAtt = c.IdAtt
		left join PosUpTx d on
			a.Idtipotx = d.Idtipotx
			and (d.Inventario <> 0)
		where
						a.IdCompany = " . $post["CompanyActual"] . "
						and a.CodIdBasico = '" . $post["CodIdBasico"] . "'
		group by
			a.IdCompany,
			a.CodIdBasico,
			x.IdAtt ) i on
		a.CodIdBasico = i.CodIdBasico
		and x.IdAtt = i.IdAtt
	where
						a.IdCompany = " . $post["CompanyActual"] . "
						and a.CodIdBasico = '" . $post["CodIdBasico"] . "'
		and a.Fectxclient >= DATE_SUB(now(), interval 30 day)
	group by
		a.IdCompany,
		a.CodIdBasico,
		x.IdAtt
union all
	select
		a.CodIdBasico,
			x.IdAtt,
			x.nombre as Almacen,
		0 as CantVtas,
		sum(a.Cant * d.Inventario) as Stock,
		0 as DiastockCero,
		0 as dias,
		0 as promvdiario
	from
		PosUpTxD a
	inner join PosUpAlmacen c on
		c.IdCompany = a.IdCompany
		and c.IdAlm = a.IdAlm
		and c.tipo <> 4
	inner join posupzonaatt x on
		x.IdCompany = c.IdCompany
		and x.IdAtt = c.IdAtt
	left join PosUpTx d on
		a.Idtipotx = d.Idtipotx
		and (d.Inventario <> 0)
	where
						a.IdCompany = " . $post["CompanyActual"] . "
						and a.CodIdBasico = '" . $post["CodIdBasico"] . "'
		and c.IdAtt not in (
		select
			c.IdAtt
		from
			PosUpTxD a
	inner join PosUpAlmacen c on
		c.IdCompany = a.IdCompany
		and c.IdAlm = a.IdAlm
		and c.tipo <> 4
		inner join PosUpTx d on
			a.Idtipotx = d.Idtipotx
			and d.Idtipotx in (1, 2, 3, 15, 22)
		where
						a.IdCompany = " . $post["CompanyActual"] . "
						and a.CodIdBasico = '" . $post["CodIdBasico"] . "'
			and a.Fectxclient >= DATE_SUB(now(), interval 30 day)
		group by
			a.IdCompany,
			a.CodIdBasico,
			c.IdAtt )
	group by
		a.IdCompany,
		a.CodIdBasico,
		x.IdAtt
	order by
		Almacen ) as b on
	a.IdAtt = b.IdAtt
where
						a.IdCompany = " . $post["CompanyActual"] . "
	";
	}
	$tbody = "";
	$Stock = 0;
	$promvdiario = 0;
	$CantVtas = 0;
	$DiastockCero = 0;
	if ($result = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$Stock += $row['Stock'];
			$promvdiario += $row['promvdiario'];
			$CantVtas += $row['CantVtas'];
			$DiastockCero += $row['DiastockCero'];
			$b = (ROUND(((7 * ($row['CantVtas']/30)) - $row['Stock']), 0) > 0 ? ROUND(((7 * ($row['CantVtas']/30)) - $row['Stock']), 0) : 0);
			$b15 = (ROUND(((15 * ($row['CantVtas']/30)) - $row['Stock']), 0) > 0 ? ROUND(((7 * ($row['CantVtas']/30)) - $row['Stock']), 0) : 0);
			$b30 = (ROUND(((30 * ($row['CantVtas']/30)) - $row['Stock']), 0) > 0 ? ROUND(((7 * ($row['CantVtas']/30)) - $row['Stock']), 0) : 0);
			$b60 = (ROUND(((60 * ($row['CantVtas']/30)) - $row['Stock']), 0) > 0 ? ROUND(((7 * ($row['CantVtas']/30)) - $row['Stock']), 0) : 0);
			$b90 = (ROUND(((90 * ($row['CantVtas']/30)) - $row['Stock']), 0) > 0 ? ROUND(((7 * ($row['CantVtas']/30)) - $row['Stock']), 0) : 0);
			$b120 = (ROUND(((120 * ($row['CantVtas']/30)) - $row['Stock']), 0) > 0 ? ROUND(((7 * ($row['CantVtas']/30)) - $row['Stock']), 0) : 0);
			$tbody .= "
					<tr>
						<td>" . $row['Almacen'] . "</td>
						<td class='text-end'>" . getcantformat(($row['Stock']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . "</td>
						<td class='text-end'>" . number_format(($row['CantVtas']/30), 2, $_POST["SimDec"], $_POST["SimMil"]) . "</td>
						<td class='text-end'>" . getcantformat(($row['CantVtas']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . "</td>
						<td class='text-end'>" . getcantformat(($row['CantVtas']>0 ? ($row['Stock']/($row['CantVtas']/30)) :0), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " <i class='fa fa-flag' style='" . (ROUND($row['DiastockCero']) <= 0 ? "color:red;" : (ROUND($row['DiastockCero']) > 0 && ROUND($row['DiastockCero']) <= ($b) ? "color:orange;" : "color:green;")) . "'></i></td>
						<td class='text-end'>" . getcantformat(($b), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]). "</td>
					</tr>
				";
		}
	}

	$a = (ROUND(((7 * $promvdiario) - $Stock), 0) > 0 ? ROUND(((7 * $promvdiario) - $Stock), 0) : 0);
	$tbody2 = "";
	$CostoNeto = 0;
	$n = 0;
	$dias_despacho = 0;

	$sql2 = "select a.IdBen,b.Nombre,DATE_FORMAT(a.Fectxclient,'%d/%m/%Y') as Fecha,DATE_FORMAT(coalesce(d.Fectxclient,a.Fectxclient),'%d/%m/%Y') as FechaOC,
		DATEDIFF(DATE_FORMAT(coalesce(d.Fectxclient,a.Fectxclient),'%Y-%m-%d'),DATE_FORMAT(a.Fectxclient,'%Y-%m-%d')) as dias_despacho,
		a.IdBarcode,sum(c.Cant) as Cant,c.Costo,c.MontoImpuesto,(c.Costo-c.MontoImpuesto) as CostoBruto 
		from posuptxc a
		inner join posupclientes b on a.IdBen = b.RUT and a.IdCompany = b.IdCompany
		inner join posuptxd c on c.Idtx = a.Idtx and c.Idtipotx = a.Idtipotx and c.IdEstacion = a.IdEstacion and c.IdCompany = a.IdCompany 
		left join posuptxc d on d.Idtx = a.IdtxPadre and d.Idtipotx = a.IdtipotxPadre and d.IdEstacion = a.IdEstacionPadre and d.IdCompany = a.IdCompany 
		where a.Idtipotx in (7,28) and a.IdCompany=" . $post["CompanyActual"] . " and c.CodIdBasico = '" . $post["CodIdBasico"] . "'
		group by a.IdBarcode
		order by Fecha asc
				";
	if ($result = mysqli_query($conn, $sql2)) {
		while ($row = mysqli_fetch_assoc($result)) {
			if ($n === 0) {
				$CostoNeto = $row['Costo'];
			}

			$dias_despacho += $row["dias_despacho"];
			$n++;
			$tbody2 .= "
					<tr>
						<td>" . $row['Fecha'] . "</td>
						<td>" . $row['FechaOC'] . "</td>
						<td>" . $row['Nombre'] . "</td>
						<td class='text-end'>" . $row['dias_despacho'] . "</td>
						<td class='text-end'>" . getcantformat(($row['Cant']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . "</td>
						<td class='text-end'>" . number_format(($row['CostoBruto']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $post["MonedaP"] . "</td>
						<td class='text-end'>" . number_format(($row['Costo']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $post["MonedaP"] . "</td>
					</tr>
				";



			$Color1 = randomColor();
			$LabelsGeneral1[] = $row["Fecha"];
			$DataGeneral1[] = $row["Costo"];

			$Color2 = randomColor();
			$Color3 = randomColor();
			$Color4 = randomColor();
			$LabelsGeneral2[] = $row["Fecha"];
			$DataGeneral2[] = $row["Cant"];
		}
	}
	//$c = 0;
	$c = (($dias_despacho / $n) * $promvdiario);
	$c = is_nan($c) ? 0 : $c;
	$d = $c + $a;
	$d = is_nan($d) ? 0 : $d;
	$atot = (ROUND(((7 * $CantVtas/30) - $Stock), 0) > 0 ? ROUND(((7 * $CantVtas/30) - $Stock), 0) : 0);
	$b15 = (ROUND(((15 * $CantVtas/30) - $Stock), 0) > 0 ? ROUND(((15 * $CantVtas/30) - $Stock), 0) : 0);
	$b30 = (ROUND(((30 * $CantVtas/30) - $Stock), 0) > 0 ? ROUND(((30 * $CantVtas/30) - $Stock), 0) : 0);
	$b60 = (ROUND(((60 * $CantVtas/30) - $Stock), 0) > 0 ? ROUND(((60 * $CantVtas/30) - $Stock), 0) : 0);
	$b90 = (ROUND(((90 * $CantVtas/30) - $Stock), 0) > 0 ? ROUND(((90 * $CantVtas/30) - $Stock), 0) : 0);
	$b120 = (ROUND(((120 * $CantVtas/30) - $Stock), 0) > 0 ? ROUND(((120 * $CantVtas/30) - $Stock), 0) : 0);

	return  '
			<table class="table table-hover table-striped nowrap" >
				<thead>
					<tr>
						<th>' . lang("Almacén") . '</th>
						<th class="text-end">' . lang("Stock Actual") . '</th>
						<th class="text-end">' . lang("Promedio Ventas x Dia") . '</th>
						<th class="text-end">' . lang("Cantidad de ventas en los ultimos 30 dias") . '</th>
						<th class="text-end">' . lang("Dias para stock cero") . '</th>
						<th class="text-end">' . lang("Reposición de stock sugerida para 7 dias") . '</th>
					</tr>
				</thead>
				<tbody>
					' . $tbody . '
				</tbody>
				<tfoot>
					<tr>
						<td>' . lang("Total") . ' </td>
						<td class="text-end">' . getcantformat(($Stock), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . '</td>
						<td class="text-end">' . number_format(($CantVtas/30), 2, $_POST["SimDec"], $_POST["SimMil"]) . '</td>
						<td class="text-end">' . getcantformat(($CantVtas), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . '</td>
						<td class="text-end">' . getcantformat($CantVtas === 0 ? 0 : ROUND($Stock / ($CantVtas/30), 0), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . " <i class='fa fa-flag' style='" . (ROUND($Stock / $promvdiario) <= 0 ? "color:red;" : (ROUND($Stock / $promvdiario) > 0 && ROUND($Stock / $promvdiario) <= $a ? "color:orange;" : "color:green;")) . "'></i>" . '</td>
						<td></td>
					</tr>
					<tr>
						<td class="text-end" colspan="6">Reposición a 7 días --> <span class="badge bg-light text-dark p-1 m-1"><i class="fa fa-check"></i>' . getcantformat(($atot), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])  ."</span></br>"
						."Reposición a 15 días --> <span class='badge bg-light text-dark p-1 m-1'><i class='fa fa-check'></i>". getcantformat(($b15), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) ."</span></br>"
						."Reposición a 30 días --> <span class='badge bg-light text-dark p-1 m-1'><i class='fa fa-check'></i>". getcantformat(($b30), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) ."</span></br>"
						."Reposición a 60 días --> <span class='badge bg-light text-dark p-1 m-1'><i class='fa fa-check'></i>". getcantformat(($b60), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) ."</span></br>"
						."Reposición a 90 días --> <span class='badge bg-light text-dark p-1 m-1'><i class='fa fa-check'></i>". getcantformat(($b90), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) ."</span></br>"
						."Reposición a 120 días --> <span class='badge bg-light text-dark p-1 m-1'><i class='fa fa-check'></i>". getcantformat(($b120), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) .'</span></td>
						
					</tr>
				</tfoot>
			</table>
			<div class="d-flex gap-2">
				<div class="col-12 col-lg-12 ">
					<div class="table-responsive">
					<table class="table table-hover table-striped nowrap" style="width:100%;" >
					<thead>
						<tr>
							<th>' . lang("Fecha") . '</th>
							<th>' . lang("FechaOC") . '</th>
							<th>' . lang("Beneficiario") . '</th>
							<th class="text-end">' . lang("Dias Despacho") . '</th>
							<th class="text-end">' . lang("Cantidad Comprada") . '</th>
							<th class="text-end">' . lang("Costo Sin Impuesto") . '</th>
							<th class="text-end">' . lang("Costo Con Impuesto") . '</th>
						</tr>
					</thead>
					<tbody>
						' . $tbody2 . '
					</tbody>
				
				</table>
					</div>
				</div>
				
			</div>
			<div class="row">
			' . "
			<div class='col-12 col-lg-8' >
				<canvas id='ChartGastos' class='grid' '></canvas>
				<script>
				var width, height, gradient;
					function getGradient(ctx, chartArea) {
					const chartWidth = chartArea.right - chartArea.left;
					const chartHeight = chartArea.bottom - chartArea.top;
					if (!gradient || width !== chartWidth || height !== chartHeight) {
						// Create the gradient because this is either the first render
						// or the size of the chart has changed
						width = chartWidth;
						height = chartHeight;
						gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
						gradient.addColorStop(0, '" . $Color2 . "');
						gradient.addColorStop(0.5, '" . $Color3 . "');
						gradient.addColorStop(1, '" . $Color4 . "');
					}

					return gradient;
					}
					var ctx2 = document.getElementById('ChartGastos').getContext('2d');
					myChart = new Chart(ctx2, {
						aspectRatio: 1,
						responsive: true,
						type: 'bar',
						data: {
							labels: " . json_encode($LabelsGeneral1) . ",
							datasets: [
								{
									label: '" . lang("Costos con impuesto") . "',
									data: " . json_encode($DataGeneral1) . ",
									borderColor: '" . $Color1 . "',
								  backgroundColor: '" . $Color1 . "',
								  pointStyle: 'circle',
									pointRadius: 10,
									order: 1,
									pointHoverRadius: 15
								},
								{
								  label: '" . lang("Cantidades") . "',
								  data: " . json_encode($DataGeneral2) . ",
								  borderColor: function(context) {
									const chart = context.chart;
									const {ctx, chartArea} = chart;
							
									if (!chartArea) {
									  // This case happens on initial chart load
									  return;
									}
									return getGradient(ctx, chartArea);
								  },
								  pointStyle: 'circle',
								  pointRadius: 10,
								  pointHoverRadius: 15,
									type: 'line',
									order: 0
								},
							]
						},
						options: {
							scales: {
								yAxes: [{
									ticks: {
										beginAtZero: true,
										callback: function(value, index, values) {
											return Formato(value, '" . $post["CD"] . "', '" . $post["SimDec"] . "', '" . $post["SimMil"] . "');
										},
										min: 0,
									}
								}]
							}
						}
	
					});
				</script>
			</div>
		" . '
		<div class="col-12 col-lg-4">
			<div class="bg-light text-dark fw-bold w-100 align-items-center px-2 py-2 border-2 border-dark mb-2" style="border-radius: 0.5rem;">
				<div class=" d-flex justify-content-center ">
						<i class="fa fa-lightbulb-o" style="color:yellow; font-size:64px;" aria-hidden="true"></i>
				</div>
				<div class="text-center">
					' . lang("Compras sugerida si el despacho es inmediato") . '
				</div>
					<div class="text-center">
					' . ($a) . ' x ' . number_format(($CostoNeto), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $post["MonedaP"] . ' = ' . number_format(($CostoNeto * $a), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $post["MonedaP"] . '
				</div>
			</div>
			<div class="bg-light text-dark fw-bold w-100 align-items-center px-2 py-2 border-2 border-dark" style="border-radius: 0.5rem;">
				<div class=" d-flex justify-content-center ">
						<i class="fa fa-lightbulb-o" style="color:yellow; font-size:64px;" aria-hidden="true"></i>
				</div>
				<div class="text-center">
					' . lang("Compras sugerida con tiempo de despacho") . '
				</div>
					<div class="text-center">
					' . (ROUND($d, 2)) . ' x ' . number_format(($CostoNeto), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $post["MonedaP"] . ' = ' . number_format(($CostoNeto * (ROUND($d, 2))), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $post["MonedaP"] . '
				</div>
			</div>
			
		</div>
			</div>
		';
	// <th>' . lang("Existencia") . '</th>
	// 				
	// 				
	// 				

	// <td>" . $row['CantVtas'] . " <div></div></td>
	// <td>" . $row["DiastockCero"] . "</td>
	// <td>" . $row["dias"] . "</td>
	// <td>" . $row["promvdiario"] . "</td>
}

function MarcaTable($conn, $post)
{
	$response = [];
	$sql = "SELECT idmarca,nombre FROM posupc_marcas where IdCompany=" . $post['CompanyActual'] . " ";
	if ($result = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_array($result)) {
			$response[] = [
				"idmarca" => $row["idmarca"],
				"nombre" => $row["nombre"],
			];
		}
	}

	return json_encode($response, JSON_UNESCAPED_UNICODE);
}

function FamiliaTable($conn, $post)
{
	$response = [];
	$sql = "SELECT IdVarios,ITEM,VALOR,esserial,eslote,generaorden,IdVariosPadre,ventaweb,IdPadre,compweb,factorarea,esmedida FROM posupvarios where IdCompany=" . $post['CompanyActual'] . " AND TIPOITEM = 2 ";
	if ($result = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_array($result)) {
			$response[] = [
				"IdVarios" => $row["IdVarios"],
				"ITEM" => $row["ITEM"],
				"VALOR" => $row["VALOR"],
				"esserial" => $row["esserial"],
				"eslote" => $row["eslote"],
				"generaorden" => $row["generaorden"],
				"IdVariosPadre" => $row["IdVariosPadre"],
				"ventaweb" => $row["ventaweb"],
				"IdPadre" => $row["IdPadre"],
				"compweb" => $row["compweb"],
				"factorarea" => $row["factorarea"],
				"esmedida" => $row["esmedida"],
			];
		}
	}

	return json_encode($response, JSON_UNESCAPED_UNICODE);
}

if (isset($_POST['Accion']) && $_POST['Accion'] === "mostrarExistencias") {
	include "ambienteconsultas.php";
	$conn = Conectar();
	echo mostrarExistencias($conn, $_POST);
}

if (isset($_POST['Accion']) && $_POST['Accion'] === "EstadisticaProductox") {
	include "ambienteconsultas.php";
	$conn = Conectar();
	echo EstadisticaProductox($conn, $_POST);
}

if (isset($_POST['Accion']) && $_POST['Accion'] === "0") {
	include "ambienteconsultas.php";
	$conn = Conectar();
	echo ProductoTable($conn, $_POST, $_REQUEST);
}

if (isset($_POST['Accion']) && $_POST['Accion'] === "Marca") {
	include "ambienteconsultas.php";
	$conn = Conectar();
	echo MarcaTable($conn, $_POST);
}

if (isset($_POST['Accion']) && $_POST['Accion'] === "Familia") {
	include "ambienteconsultas.php";
	$conn = Conectar();
	echo FamiliaTable($conn, $_POST);
}

if (isset($_POST['Accion']) && $_POST['Accion'] === "elifactores") {
	if (trim($_POST['jsonfactor']) == "") {
		echo "";
	} else {
		$a = json_decode(trim($_POST['jsonfactor']), true);
		$g = 0;
		foreach ($a as $value) {
			$g += 1;
			if ($_POST["n"] !== trim($g)) {
				$n[] = array(
					"Cantidad" => $value['Cantidad'],
					"Factor" => $value['Factor']
				);
			}
		}
	}
	$n = record_sort($n, "Cantidad");
	echo json_encode($n, JSON_UNESCAPED_UNICODE);
}

if (isset($_POST['Accion']) && $_POST['Accion'] === "verfactores") {
	include "ambienteconsultas.php";
	if (trim($_POST['jsonfactor']) === "") {
?>
		<span class="badge bg-light text-dark p-1 m-1"><i class="fa fa-times-circle"></i> <? echo lang("Sin factores"); ?></span>
		<?
	} else {
		$a = json_decode($_POST['jsonfactor'], true);
		$nn = 0;
		foreach ($a as $value) {
			$nn += 1;
		?>
			<span class="badge bg-success text-light p-1 me-0">
				<= <? echo $value['Cantidad']; ?> <i class="fa fa-percent"></i> <? echo $value['Factor']; ?>
			</span><button class="btn btn-outline-danger p-0 m-0" style="font-size:small;height:auto" onclick="elifactores(<? echo $nn; ?>);"> <i class="fa fa-trash" style="font-size:small"></i> </button>
		<?
		}
	}
}

if (isset($_POST['Accion']) && $_POST['Accion'] == "agrfac") {
	if (trim($_POST['jsonfactor']) == "") {
		$n[] = array(
			"Cantidad" => $_POST['cantidad'],
			"Factor" => $_POST['factor']
		);
	} else {
		$a = json_decode(trim($_POST['jsonfactor']), true);
		$g = 0;
		foreach ($a as $value) {
			if ($value["Cantidad"] == $_POST['cantidad']) {
				$g = 1;
				$n[] = array(
					"Cantidad" => $_POST['cantidad'],
					"Factor" => $_POST['factor']
				);
			} else {
				$n[] = array(
					"Cantidad" => $value['Cantidad'],
					"Factor" => $value['Factor']
				);
			}
		}
		if ($g == 0) {
			$n[] = array(
				"Cantidad" => $_POST['cantidad'],
				"Factor" => $_POST['factor']
			);
		}
	}
	$n = record_sort($n, "Cantidad");
	echo json_encode($n, JSON_UNESCAPED_UNICODE);
}

if (isset($_POST['Accion']) && $_POST['Accion'] == "1") {
	include "ambienteconsultas.php";
	$con = conectar();
	$conn = conectar();
	$request = $_REQUEST;
	$seach = "";
	if ($_POST['EsCompuesto'] == 0) {
		$tabla = 'Productos';
	}
	if ($_POST['EsCompuesto'] == 9) {
		$tabla = 'Servicios';
	}
	$sql = "SELECT a.*,d.LitP01,d.LitP02,d.LitP03,d.LitP04,d.LitP05,d.LitP06,d.LitP07,d.LitP08,d.LitP09,d.LitP10,d.LitCosto FROM PosUpAuditoria a
	left join PosUpCompany d on d.Id=" . $_POST['CompanyActual'] . "
	where IdCompany=" . $_POST['CompanyActual'] . " and Tabla='" . $tabla . "' and IdReg='" . $_POST['CodIdBasico'] . "'";
	$query = mysqli_query($conn, $sql);
	$totalData = mysqli_num_rows($query);

	$totalFilter = $totalData;
	if (!empty($request['search']['value'])) {
		$sql .= " AND concat(IdReg,LoginUser,Tipo,fecha) Like '%" . $request['search']['value'] . "%' ";
	}

	$query = mysqli_query($conn, $sql);
	$totalData = mysqli_num_rows($query);

	$sql .= " ORDER BY fecha desc LIMIT " . $request['start'] . "  ," . $request['length'] . "  ";

	$query = mysqli_query($conn, $sql);

	$data = array();
	while ($row = mysqli_fetch_array($query)) {
		$array2 = json_decode($row['Data'], true);
		$tipo = explode("-", $row["Tipo"]);
		foreach ($array2 as $array) {
			$query2 = "SELECT nombre FROM PosUpc_marcas where IdCompany=" . $_POST['CompanyActual'] . " and idmarca='" . $array["Marca"] . "'";
			if ($result2 = mysqli_query($conn, $query2)) {
				while ($row2 = mysqli_fetch_array($result2)) {
					$Marca = $row2["nombre"];
				}
			}
			$query2 = "SELECT Nombre FROM posupusers where IdCompany=" . $_POST['CompanyActual'] . " and Login='" . $row['LoginUser'] . "' ";
			if ($result2 = mysqli_query($conn, $query2)) {
				while ($row2 = mysqli_fetch_array($result2)) {
					$Usuario = $row2["Nombre"];
				}
			}
			$query2 = "SELECT esserial FROM PosUpvarios where IdCompany=" . $_POST['CompanyActual'] . " and Login='" . $array["Idfamilia"] . "' and TIPOITEM=2";
			if ($result2 = mysqli_query($conn, $query2)) {
				while ($row2 = mysqli_fetch_array($result2)) {
					$esserial = $row2["esserial"];
				}
			}
			$query2 = "SELECT VALOR,ITEM FROM PosUpvarios where IdCompany=" . $_POST['CompanyActual'] . " and IdVarios='" . $array["Impuesto"] . "' and TIPOITEM=0";
			if ($result2 = mysqli_query($conn, $query2)) {
				while ($row2 = mysqli_fetch_array($result2)) {
					$VALOR = $row2["VALOR"];
					$ITEM = $row2["ITEM"];
				}
			}

			if ($esserial == "1") {
				$SERIAL = '<span class="badge bg-warning text-dark"><span class="fa fa-barcode"></span> ' . lang("SERIAL") . '</span> ';
			} else {
				$SERIAL = "";
			}
			if ($array["Estado"] == "1") {
				$Estado = lang("ACTIVO");
			} else {
				$Estado = lang("INACTIVO");
			}
			if ($array["EsCompuesto"] == "0") {
				$ESCOMPUESTO = '<span class="badge bg-success text-light"><span class="fa fa-dropbox"></span> ' . lang("PRODUCTO") . '</span>';
			} else {
				$ESCOMPUESTO = '<span class="badge bg-success text-light"><span class="fa fa-dropbox"></span> ' . lang("SERVICIO") . '</span>';
			}

			if ($array["PorKilo"] == "1") {
				$PorKilo = '<span class="badge bg-success text-light">' . lang("POR PESO") . '</span>';
			} else {
				$PorKilo = "";
			}

			if (isset($tipo[1])) {
				$IdEstacion = "";
				$Idtipotx = "";
				$Idtx = "";
				$query2x = "SELECT IdEstacion, Idtipotx, Idtx from PosUpTxC where IdBarcode='" . $tipo[1] . "'";
				if ($result2x = mysqli_query($conn, $query2x)) {
					while ($row2x = mysqli_fetch_assoc($result2x)) {
						$IdEstacion = $row2x['IdEstacion'];
						$Idtipotx = $row2x['Idtipotx'];
						$Idtx = $row2x['Idtx'];
					}
					mysqli_free_result($result);
				}
			}

			$subdata = array();
			$subdata[] = '
					<div class="d-flex justify-content-start">
						<div class="p-1"><strong>' . $array["Descripcion"] . '</strong><br>
						<span class="badge bg-light text-dark">' . lang("SKU") . ': ' . $array["CodIdAmpliado"] . '</span> 
						<span class="badge bg-light text-dark text-wrap">' . lang("BarCode") . ': <span class="fa fa-barcode"></span> ' . $array["CodBarra"] . ' </span> 
						<span class="badge bg-light text-dark">' . lang("ID") . ':  ' . $array["CodIdBasico"] . ' </span><br> 
						<span class="badge bg-primary text-light">' . $Marca . '</span> 
						<span class="badge bg-success text-light"><span class="fa fa-arrow-up"></span> ' . $Estado . '</span> 
						' . $SERIAL . '
						' . $ESCOMPUESTO . '
						' . $PorKilo . '
						' . (isset($tipo[1]) ? "<button class='btn btn-outline-dark p-1' type='button' title='" . lang("Vista Previa") . "' onclick='Impresion(`" . $IdEstacion . "`,`" . $Idtipotx . "`,`" . $Idtx . "`,`1`,`1`)'> <i class='fa fa-print'></i></button>" : "") . '
						<br>
						<span class="badge bg-light text-dark">' . lang("Usuario") . ": " . $Usuario . '</span>
						<br>
						<span class="badge bg-light text-dark">' . lang("Tipo") . ": " . $row['Tipo'] . '</span>
						<br>
						<span class="badge bg-light text-dark">' . lang("Fecha") . ": " . $row['fecha'] . '</span>
					</div>
				</div>
				';
			$subdata[] = '
					<span class="badge bg-light text-dark">' . lang("Impuesto") . '</span> 
					<span class="badge bg-warning text-dark">' . number_format($VALOR * 100, 0, $_POST["SimDec"], $_POST["SimMil"]) . ' % </span> 
					<span class="badge bg-warning text-dark">' . number_format($VALOR, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $_POST["MonedaP"] . ' </span> 
					<span class="badge bg-success text-white">' . $ITEM . '</span>
					<br>

					<span class="badge bg-light text-dark">' . (trim($row["LitCosto"]) !== "" ? $row["LitCosto"] : lang("Costo"))  . '</span> 
					<span class="badge bg-warning text-dark">' . number_format($array["CostoNeto"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $_POST["MonedaP"] . ' </span> 
					<span class="badge bg-warning text-dark">' . number_format($array["Costo"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $_POST["MonedaP"] . ' </span> 
					<br>
					
					<span class="badge bg-light text-dark">' . (trim($row["LitP01"]) !== "" ? $row["LitP01"] : lang("Precio") . " 1") . '</span> 
					<span class="badge bg-warning text-dark">' . number_format($array["PrecioNeto"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $_POST["MonedaP"] . ' </span> 
					<span class="badge bg-warning text-dark">' . number_format($array["Margen"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' % </span> 
					<span class="badge bg-warning text-dark">' . number_format($array["PrecioVenta"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $_POST["MonedaP"] . ' </span> 
					<span class="badge bg-success text-white">' . $array["Medida"] . ' (1) </span>
					<span class="badge bg-info text-dark">' . number_format($array["Comision"], 2, $_POST["SimDec"], $_POST["SimMil"]) . ' % </span>
					<br>
					
					<span class="badge bg-light text-dark">' . (trim($row["LitP02"]) !== "" ? $row["LitP02"] : lang("Precio") . " 2") . '</span> 
					<span class="badge bg-warning text-dark">' . number_format($array["PrecioNeto2"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $_POST["MonedaP"] . ' </span> 
					<span class="badge bg-warning text-dark">' . number_format($array["Margen2"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' % </span> 
					<span class="badge bg-warning text-dark">' . number_format($array["PrecioVenta2"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $_POST["MonedaP"] . ' </span> 
					<span class="badge bg-success text-white">' . $array["UnidadP1"] . ' (' . $array["CantP1"] . ') </span>
					<span class="badge bg-info text-dark">' . number_format($array["Comision2"], 2, $_POST["SimDec"], $_POST["SimMil"]) . ' % </span>
					<br>
					
					<span class="badge bg-light text-dark">' . (trim($row["LitP03"]) !== "" ? $row["LitP03"] : lang("Precio") . " 3") . '</span> 
					<span class="badge bg-warning text-dark">' . number_format($array["PrecioNeto3"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $_POST["MonedaP"] . ' </span> 
					<span class="badge bg-warning text-dark">' . number_format($array["Margen3"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' % </span> 
					<span class="badge bg-warning text-dark">' . number_format($array["PrecioVenta3"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $_POST["MonedaP"] . ' </span> 
					<span class="badge bg-success text-white">' . $array["UnidadP2"] . ' (' . $array["CantP2"] . ') </span>
					<span class="badge bg-info text-dark">' . number_format($array["Comision3"], 2, $_POST["SimDec"], $_POST["SimMil"]) . ' % </span>
					<br>
					
					<span class="badge bg-light text-dark">' . (trim($row["LitP04"]) !== "" ? $row["LitP04"] : lang("Precio") . " 4") . '</span> 
					<span class="badge bg-warning text-dark">' . number_format($array["PrecioNeto4"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $_POST["MonedaP"] . ' </span> 
					<span class="badge bg-warning text-dark">' . number_format($array["Margen4"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' % </span> 
					<span class="badge bg-warning text-dark">' . number_format($array["PrecioVenta4"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $_POST["MonedaP"] . ' </span> 
					<span class="badge bg-success text-white">' . $array["UnidadP4"] . ' (' . $array["CantP4"] . ') </span>
					<span class="badge bg-info text-dark">' . number_format($array["Comision4"], 2, $_POST["SimDec"], $_POST["SimMil"]) . ' % </span>
					<br>
					
					<span class="badge bg-light text-dark">' . (trim($row["LitP05"]) !== "" ? $row["LitP05"] : lang("Precio") . " 5") . '</span> 
					<span class="badge bg-warning text-dark">' . number_format($array["PrecioNeto5"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $_POST["MonedaP"] . ' </span> 
					<span class="badge bg-warning text-dark">' . number_format($array["Margen5"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' % </span> 
					<span class="badge bg-warning text-dark">' . number_format($array["PrecioVenta5"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $_POST["MonedaP"] . ' </span> 
					<span class="badge bg-success text-white">' . $array["UnidadP5"] . ' (' . $array["CantP5"] . ') </span>
					<span class="badge bg-info text-dark">' . number_format($array["Comision5"], 2, $_POST["SimDec"], $_POST["SimMil"]) . ' % </span>
					<br>
					<span class="badge bg-light text-dark">' . (trim($row["LitP06"]) !== "" ? $row["LitP06"] : lang("Precio") . " 6") . '</span> 
					<span class="badge bg-warning text-dark">' . number_format($array["PrecioNeto6"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $_POST["MonedaP"] . ' </span> 
					<span class="badge bg-warning text-dark">' . number_format($array["Margen6"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' % </span> 
					<span class="badge bg-warning text-dark">' . number_format($array["PrecioVenta6"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $_POST["MonedaP"] . ' </span> 
					<span class="badge bg-success text-white">' . $array["UnidadP6"] . ' (' . $array["CantP6"] . ') </span>	
					<span class="badge bg-info text-dark">' . number_format($array["Comision6"], 2, $_POST["SimDec"], $_POST["SimMil"]) . ' % </span>
					<br>
					<span class="badge bg-light text-dark">' . (trim($row["LitP07"]) !== "" ? $row["LitP07"] : lang("Precio") . " 7") . '</span> 
					<span class="badge bg-warning text-dark">' . number_format($array["PrecioNeto7"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $_POST["MonedaP"] . ' </span> 
					<span class="badge bg-warning text-dark">' . number_format($array["Margen7"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' % </span> 
					<span class="badge bg-warning text-dark">' . number_format($array["PrecioVenta7"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $_POST["MonedaP"] . ' </span> 
					<span class="badge bg-success text-white">' . $array["UnidadP7"] . ' (' . $array["CantP7"] . ') </span>	
					<span class="badge bg-info text-dark">' . number_format($array["Comision7"], 2, $_POST["SimDec"], $_POST["SimMil"]) . ' % </span>
					<br>
					<span class="badge bg-light text-dark">' . (trim($row["LitP08"]) !== "" ? $row["LitP08"] : lang("Precio") . " 8") . '</span> 
					<span class="badge bg-warning text-dark">' . number_format($array["PrecioNeto8"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $_POST["MonedaP"] . ' </span> 
					<span class="badge bg-warning text-dark">' . number_format($array["Margen8"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' % </span> 
					<span class="badge bg-warning text-dark">' . number_format($array["PrecioVenta8"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $_POST["MonedaP"] . ' </span> 
					<span class="badge bg-success text-white">' . $array["UnidadP8"] . ' (' . $array["CantP8"] . ') </span>
					<span class="badge bg-info text-dark">' . number_format($array["Comision8"], 2, $_POST["SimDec"], $_POST["SimMil"]) . ' % </span>
					<br>
					<span class="badge bg-light text-dark">' . (trim($row["LitP09"]) !== "" ? $row["LitP09"] : lang("Precio") . " 9") . '</span> 
					<span class="badge bg-warning text-dark">' . number_format($array["PrecioNeto9"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $_POST["MonedaP"] . ' </span> 
					<span class="badge bg-warning text-dark">' . number_format($array["Margen9"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' % </span> 
					<span class="badge bg-warning text-dark">' . number_format($array["PrecioVenta9"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $_POST["MonedaP"] . ' </span> 
					<span class="badge bg-success text-white">' . $array["UnidadP9"] . ' (' . $array["CantP9"] . ') </span>
					<span class="badge bg-info text-dark">' . number_format($array["Comision9"], 2, $_POST["SimDec"], $_POST["SimMil"]) . ' % </span>
					<br>
					<span class="badge bg-light text-dark">' . (trim($row["LitP10"]) !== "" ? $row["LitP10"] : lang("Precio") . " 10") . '</span> 
					<span class="badge bg-warning text-dark">' . number_format($array["PrecioNeto10"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $_POST["MonedaP"] . ' </span> 
					<span class="badge bg-warning text-dark">' . number_format($array["Margen10"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' % </span> 
					<span class="badge bg-warning text-dark">' . number_format($array["PrecioVenta10"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $_POST["MonedaP"] . ' </span> 
					<span class="badge bg-success text-white">' . $array["UnidadP10"] . ' (' . $array["CantP10"] . ') </span>
					<span class="badge bg-info text-dark">' . number_format($array["Comision10"], 2, $_POST["SimDec"], $_POST["SimMil"]) . ' % </span>
				';
			$data[] = $subdata;
		}
	}

	$json_data = array(
		"draw"              =>  intval($request['draw']),
		"recordsTotal"      =>  intval($totalFilter),
		"recordsFiltered"   =>  intval($totalData),
		"data"              =>  $data
	);

	echo json_encode($json_data);
}

if (isset($_POST['Accion']) && $_POST['Accion'] == "2") {
	$Error = 0;
	if (trim($_POST["ModalEnvase"]) <> "") {
		$array = explode("|", trim($_POST["jsonEtiquetas"]));
		$array2 = explode(",", trim($_POST["ModalEnvase"]));
		$n = 0;
		foreach ($array as $key => $val) {
			foreach ($array2 as $key2 => $val2) {
				if (trim($val) <> "") {
					if (trim($val2) <> "") {
						$n++;
						if (strtoupper(trim($val2)) == strtoupper(trim($val))) {
							$Error = 1;
						}
					}
				}
			}
		}
		if ($n == 0) {
			$m = 0;
			foreach ($array2 as $key2 => $val2) {
				if (trim($val2) <> "") {
					if ($m == 0) {
						$json = $val2;
					} else {
						$json = $val2 . "|" . $json;
					}
					$m++;
				}
			}
		} else {
			foreach ($array2 as $key2 => $val2) {
				if (trim($val2) <> "") {
					$json = $val2;
				}
			}
		}

		if (trim($_POST["jsonEtiquetas"]) <> "") {
			$json = trim($_POST["jsonEtiquetas"]) . "|" . $json;
		}
	} else {
		$Error = 2;
	}

	if ($Error <> 0) {
		echo $Error;
	} else {
		?>
		<span id="Numx001"><?php echo $json; ?></span>
		<?php
	}
}

if (isset($_POST['Accion']) && $_POST['Accion'] == "3") {
	$array = explode("|", $_POST["jsonEtiquetas"]);
	foreach ($array as $key => $val) {
		if (trim($val) <> "") {
		?>
			<span class="badge bg-light text-dark"><button class="btn btn-light" onclick="EliminarEtiqueta('<?php echo trim($val); ?>')"><i class="fa fa-close"></i></button> <?php echo $val; ?></span>
	<?php
		}
	}
}

if (isset($_POST['Accion']) && $_POST['Accion'] == "4") {
	$array = explode("|", trim($_POST["jsonEtiquetas"]));
	$array2 = "";
	$n = 0;
	foreach ($array as $key => $val) {
		if (trim($val) <> "") {
			if (strtoupper(trim($_POST["ModalEnvase"])) <> strtoupper(trim($val))) {
				$n++;
				if ($n == 1) {
					$array2 = trim($val);
				} else {
					$array2 = $array2 . "|" . trim($val);
				}
			}
		}
	}
	if ($n > 0) {
		echo $array2;
	} else {
		echo "";
	}
}

if (isset($_POST['Accion']) && $_POST['Accion'] == "5") {
	include "ambienteconsultas.php";
	$con = conectar();
	$conn = conectar();
	$PosStock = "";
	$Cantotal = 0;
	$q = "SELECT c.idalm,c.nombre as Almacen,sum(coalesce(a.Cant)*coalesce(d.Inventario)) as Cantidad,b.factorunit,b.Medida FROM PosUpTxD a inner join PosUpProducto b on a.IdCompany=b.IdCompany and a.CodIdBasico=b.CodIdBasico inner join PosUpAlmacen c on a.IdCompany=c.IdCompany and a.IdAlm=c.IdAlm inner join PosUpTx d on a.Idtipotx=d.Idtipotx where a.IdCompany=" . $_POST["IdCompany"] . " and b.CodIdBasico='" . $_POST["CodIdBasico"] . "' and c.tipo <> 4 group by b.CodIdBasico,c.IdAlm";
	if ($r = mysqli_query($con, $q)) {
		while ($rw = mysqli_fetch_assoc($r)) {
			if (round($rw['Cantidad'], 3) <> 0) {
				$PosStock .= "<span class='badge bg-light text-dark'>" . $rw['Almacen'] . "</span> <span class='badge bg-warning text-dark'>" . ($rw["factorunit"] <> 1 && $rw["factorunit"] <> 0 ? " " . $rw["factorunit"] . " x " . getcantformat($rw["Cantidad"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " = " . getcantformat($rw["Cantidad"] * $rw["factorunit"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) : getcantformat($rw["Cantidad"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"])) . " " . $rw["Medida"] . "</span></Br>";
			}
		}
		mysqli_free_result($r);
	}

	$PosStock .= "
			<div id='MostrarDProd" . $_POST["CodIdBasico"] . "'>
			<button onclick='desglosarPA(`" . $_POST["CodIdBasico"] . "`,`" . $_POST["IdCompany"] . "`)' type='button' class='btn btn-outline-dark px-1'><i class='fa fa-bomb'></i> " . lang("Abrir Comprometido") . "</button>
			</div>
		";

	$PosStock .= "<button onclick='desglosarC(`" . $_POST["CodIdBasico"] . "`,`" . $_POST["IdCompany"] . "`)' type='button' class='btn btn-outline-dark px-1'><i class='fa fa-bomb'></i> " . lang("Cerrar Desglose") . "</button>";

	echo $PosStock;
}

if (isset($_POST['Accion']) && $_POST['Accion'] === "SeeProductionAlm") {
	include "ambienteconsultas.php";
	$conn = Conectar();
	echo SeeProductionAlm($conn, $_POST);
}

function SeeProductionAlm($conn, $post)
{

	$PosStock = "";
	$q = "SELECT c.idalm,c.nombre as Almacen,sum(coalesce(a.Cant)*coalesce(d.Inventario)) as Cantidad,b.factorunit,b.Medida FROM PosUpTxD a inner join PosUpProducto b on a.IdCompany=b.IdCompany and a.CodIdBasico=b.CodIdBasico inner join PosUpAlmacen c on a.IdCompany=c.IdCompany and a.IdAlm=c.IdAlm inner join PosUpTx d on a.Idtipotx=d.Idtipotx where a.IdCompany=" . $post["CompanyActual"] . " and b.CodIdBasico='" . $post["CodIdBasico"] . "' and c.tipo = 4 group by b.CodIdBasico,c.IdAlm";
	if ($r = mysqli_query($conn, $q)) {
		while ($rw = mysqli_fetch_assoc($r)) {
			if (round($rw['Cantidad'], 3) <> 0) {
				$PosStock .= "<span class='badge bg-light text-dark'>" . $rw['Almacen'] . "</span> <span class='badge bg-warning text-dark'>" . ($rw["factorunit"] <> 1 && $rw["factorunit"] <> 0 ? " " . $rw["factorunit"] . " x " . getcantformat($rw["Cantidad"], $post["CD"], $post["SimDec"], $post["SimMil"]) . " = " . getcantformat($rw["Cantidad"] * $rw["factorunit"], $post["CD"], $post["SimDec"], $post["SimMil"]) : getcantformat($rw["Cantidad"], $post["CD"], $post["SimDec"], $post["SimMil"])) . " " . $rw["Medida"] . "</span></Br>";
			}
		}
		mysqli_free_result($r);
	}
	$PosStock .= "<button onclick='desglosarPC(`" . $post["CodIdBasico"] . "`,`" . $post["CompanyActual"] . "`)' type='button' class='btn btn-outline-dark px-1'><i class='fa fa-bomb'></i> " . lang("Cerrar Comprometido") . "</button>";

	return $PosStock;
}

if (isset($_POST['Accion']) && $_POST['Accion'] == "6") {
	include "ambienteconsultas.php";
	$con = conectar();
	$conn = conectar();
	$array = explode("|", $_POST["jsonEtiquetas"]);
	$buscar = "";
	?>
	<span id="Numed001">
		<?php
		foreach ($array as $key => $val) {
			if (trim($val) <> "") {
				$buscar .= " and IdUbi <> '" . $val . "'";
				$query = "SELECT IdUbi,Nombre FROM PosUpUbicacion WHERE IdCompany=" . $_POST["CompanyActual"] . " and IdUbi='" . $val . "'";
				if ($result = mysqli_query($conn, $query)) {
					while ($row = mysqli_fetch_assoc($result)) {
						$Nombre = $row["Nombre"];
					}
				}
		?>
				<span class="badge bg-light text-dark"><button class="btn btn-light" onclick="EliminarUbicak('<?php echo trim($val); ?>')"><i class="fa fa-close"></i></button> <?php echo $Nombre; ?></span>
		<?php
			}
		}
		?>
	</span>
	<span id="Numed002">
		<select name="ModalUbiProdX" id="ModalUbiProdX" class="form-select">
			<?php
			$query = "SELECT IdUbi,Nombre FROM PosUpUbicacion WHERE IdCompany=" . $_POST["CompanyActual"] . " " . $buscar;
			if ($result = mysqli_query($conn, $query)) {
				while ($row = mysqli_fetch_assoc($result)) {
			?><option value="<?php echo trim($row['IdUbi']); ?>"><?php echo trim($row['Nombre']); ?></option><?
																											}
																										}
																												?>
		</select>
		<label><?php echo lang("Ubicaciones que usan este producto"); ?></label>
	</span>
	<?php
}

if (isset($_POST['go']) && $_POST['go'] == 'products-tags') {
	include "ambienteconsultas.php";
	$con = conectar();
	$conn = conectar();
	$sql = "SELECT VariationsTypes,Textvar FROM PosUpProducto where CodIdBasico='" . $_POST['Id'] . "' and IdCompany='" . $_POST['CompanyActual'] . "'";
	if ($result = mysqli_query($con, $sql)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$vartypes = $row['VariationsTypes'];
			$Textvar = $row['Textvar'];
		}
	}
	$explode = explode(',', $vartypes);
	$Textvar2 = $Textvar;
	$Textvar = explode('|', $Textvar);
	$z = 0;
	if ($_POST['idhtml'] <> '') {
		$s = "S";
		$s2 = "S-";
	}
	foreach ($explode as $types) {
		if (trim($types) <> '') {
			$c = $c + 1;
	?>
			<div class="col-12 col-md-4  col-lg-3">
				<label class="form-label"><?php if ($_POST['not'] == '1') { ?><span type="button" id="d-<?php echo $c; ?>" onclick="deltag('<?php echo $types; ?>');" class="fa fa-times-circle"></span><?php } ?><?php echo $types; ?></label>
				<input class="form-control" id="<?php echo $s2; ?><?php echo $c; ?>" value="<?php echo $Textvar[$z]; ?>">
			</div>
	<?php
			$z = $z + 1;
		}
	}
	?>

	<?php if ($c > 0) { ?>
		<?php if ($_POST['not'] == '2') { ?> <?php } else { ?>
			<div class="col-12 col-md-4  col-lg-3">
				<label class="form-label col-12" style="visibility:hidden;">.</label>
				<button type='button' onclick='addd();' class="btn h-50 btn-outline-success btn-sm"> <i class='fa fa-plus'></i> Add Product with variation</button>
			</div><?php } ?>
	<?php } ?>

	<input id="tagsinput<?php echo $s; ?>" class="d-none" value="<?php echo $vartypes; ?>" />
	<input id="tagsinputtext<?php echo $s; ?>" class="d-none" value="<?php echo $Textvar2; ?>" />
	<input id="cont<?php echo $s; ?>" class="d-none" value="<?php echo $c; ?>" />
	<?php

}

if (isset($_POST['go']) && $_POST['go'] == 'products-tags-del') {

	$explode = explode(',', $_POST['tagsinput']);
	$extext = explode('|', $_POST['tagsinputtext']);
	$z = 0;
	foreach ($explode as $types) {
		$n = $n + 1;
		if ($n > 1) {
			$coma = ",";
		}

		if ($types == $_POST['tag']) {
			$n = $n - 1;
		} else {
			$c = $c + 1;
			$extext[$z];

			if ($c > 1) {
				$pp = "|";
			}
	?>
			<div class="col-12 col-md-4  col-lg-3">
				<label class="form-label"> <span id="d-<?php echo $c; ?>" type="button" onclick="deltag('<?php echo $types; ?>');" class="fa fa-times-circle"></span> <?php echo $types; ?></label>
				<input class="form-control" id="<?php echo $c; ?>" value="<?php echo $extext[$z]; ?>">
			</div>
	<?php
			$newtypes = $newtypes . $coma . $types;
			$newtext = $newtext . $pp . $extext[$z];
		}
		$z = $z + 1;
	}
	?>
	<?php if ($n > 0) { ?>
		<div class="col-12 col-md-4  col-lg-3">
			<label class="form-label col-12" style="visibility:hidden;">.</label>
			<button type='button' onclick='addd();' class="btn h-50 btn-outline-success btn-sm"> <i class='fa fa-plus'></i> Add Product with variation</button>
		</div>
	<?php } ?>

	<input id="tagsinput" class="d-none" value="<?php echo $newtypes; ?>" />
	<input id="cont" class="d-none" value="<?php echo $c; ?>" />
	<input id="tagsinputtext" class="d-none" value="<?php echo $newtext; ?>" />

	<?php
}

if (isset($_POST['go']) && $_POST['go'] == 'products-tags-add') {

	$explode = explode(',', $_POST['tagsinput']);
	$explode2 = explode(',', $_POST['tagsadd']);
	$explode3 = explode('|', $_POST['tagsinputtext']);
	$z = 0;
	$y = 0;
	$c = 0;



	foreach ($explode2 as $types2) {
		if (trim($types2) <> '') {
			$n = $n + 1;

			if ($n > 1) {
				$coma = ",";
				$newtext .= '| ';
			} else {
				$newtext .= ' ';
			}

			$c = $c + 1;

	?>
			<div class="col-12 col-md-4  col-lg-3">
				<label class="form-label"> <span type="button" id="d-<?php echo $c; ?>" onclick="deltag('<?php echo $types2; ?>');" class="fa fa-times-circle"></span> <?php echo $types2; ?></label>
				<input class="form-control" id="<?php echo $c; ?>" value="">
			</div>
		<?php

			$newtypes = $newtypes . $coma . $types2;



			$z = $z + 1;
		}
	}


	foreach ($explode as $types) {
		if (trim($types) <> '') {


			$c = $c + 1;
		?>
			<div class="col-12 col-md-4  col-lg-3">
				<label class="form-label"> <span type="button" id="d-<?php echo $c; ?>" onclick="deltag('<?php echo $types; ?>');" class="fa fa-times-circle"></span> <?php echo $types; ?></label>
				<input class="form-control" id="<?php echo $c; ?>" value="<?php echo $explode3[$y]; ?>">
			</div>
	<?php
			$y = $y + 1;
		}
	}



	if ($_POST['tagsinput'] == '') {
		$tags = $_POST['tagsinput'];
	} else {
		$tags = "," . $_POST['tagsinput'];
	}


	if ($_POST['tagsinputtext'] == '') {
		$tags2 = $_POST['tagsinputtext'];
	} else {
		$tags2 = "|" . $_POST['tagsinputtext'];
	}



	?>

	<div class="col-12 col-md-4  col-lg-3">
		<label class="form-label col-12" style="visibility:hidden;">.</label>
		<button type='button' onclick='addd();' class="btn h-50 btn-outline-success btn-sm"> <i class='fa fa-plus'></i> Add Product with variation</button>
	</div>
	<input id="tagsinput" class="d-none" value="<?php echo $newtypes . $tags; ?>" />
	<input id="cont" class="d-none" value="<?php echo $c; ?>" />
	<input id="tagsinputtext" class="d-none" value="<?php echo $newtext . $tags2; ?>" />

	<?php
}

if (isset($_POST['go']) && $_POST['go'] == 'products-tags-views') {

	$explode = explode(',', $_POST['tagsinput']);
	$extext = explode('|', $_POST['tagsinputtext']);
	$z = 0;
	foreach ($explode as $types) {
		if (trim($types) <> '') {
			$n = $n + 1;
			if ($n > 1) {
				$coma = ",";
			}

			$c = $c + 1;
			$extext[$z];

			if ($c > 1) {
				$pp = "|";
			}
	?>
			<div class="col-12 col-md-4  col-lg-3">
				<label class="form-label"><?php echo $types; ?></label>
				<input class="form-control" id="S-<?php echo $c; ?>" value="<?php // echo $extext[$z]; 
																			?>">
			</div>
	<?php
			$newtypes = $newtypes . $coma . $types;
			$newtext = $newtext . $pp . $extext[$z];

			$z = $z + 1;
		}
	}
	?>
	<input id="tagsinputS" class="d-none" value="<?php echo $newtypes; ?>" />
	<input id="contS" class="d-none" value="<?php echo $c; ?>" />
	<input id="tagsinputtextS" class="d-none" value="<?php echo $newtext; ?>" />

	<?php
}

if (isset($_POST['go']) && $_POST['go'] == 'varia-verif') {

	include "ambienteconsultas.php";
	$con = conectar();
	$conn = conectar();

	$sql = "SELECT a.*    FROM PosUpProducto a   where a.CodIdBasicoPadre='" . $_POST['Idh'] . "'   and a.CodIdBasico<>'" . $_POST['Idh'] . "'";
	$nrow = 0;

	if ($result3 = mysqli_query($con, $sql)) {
		while ($row3 = mysqli_fetch_assoc($result3)) {
			$nrow = $nrow + 1;
		}
	}


	if ($nrow >= 1) {
		echo "0";
	} else {
		echo "1";
	}
}

if (isset($_POST['go']) && $_POST['go'] == "table-products2") {

	include "ambienteconsultas.php";
	$con = conectar();
	$conn = conectar();
	$request = $_REQUEST;

	$sql = "SELECT a.*,b.nombre as Marcaxd,c.ITEM as Familia, c.esserial,coalesce(f.DescripcionLarga,'') as DL, '' as DescriPadre, '' as CodIdAmpPadre,
							coalesce(f.DescripcionCorta,'') as DC  FROM PosUpProducto a 
							inner join PosUpc_marcas b on a.IdCompany = b.IdCompany and a.Marca = b.idmarca 
							inner join PosUpvarios c on a.IdCompany = c.IdCompany and a.Idfamilia = c.IdVarios and c.TIPOITEM = 2
							left join  PosUpProductoWeb f on a.IdCompany=f.IdCompany  and a.CodIdBasico=f.CodIdBasico 
							where a.IdCompany=" . $IdCompany . " and a.EsCompuesto=" . $_POST['EsonoES'] . "  and a.CodIdBasicoPadre='" . $_POST['CodIdBasicoPadre'] . "' and a.CodIdBasico<>'" . $_POST['CodIdBasicoPadre'] . "' ";



	$query = mysqli_query($con, $sql);

	$totalData = mysqli_num_rows($query);

	$totalFilter = $totalData;

	//Search
	//$sql ="SELECT Descripcion,CodBarra,Medida,Idfamilia,Marca,Estado,PrecioVenta,CodIdAmpliado,CodIdBasico FROM PosUpProducto WHERE IdCompany=150";
	//if(!empty($request['search']['value'])){
	//    $sql.=" AND (Descripcion Like '%".$request['search']['value']."%' ";
	//    $sql.=" OR CodBarra Like '%".$request['search']['value']."%' ";
	//   $sql.=" OR Medida Like '%".$request['search']['value']."%' )";
	//}
	$query = mysqli_query($con, $sql);
	$totalData = mysqli_num_rows($query);

	//Order
	$sql .= " ORDER BY a.CodIdBasicoPadre,a.CodIdBasico   " . $request['order'][0]['dir'] . "  LIMIT " .
		$request['start'] . "  ," . $request['length'] . "  ";

	$query = mysqli_query($con, $sql);

	$data = array();

	while ($row = mysqli_fetch_array($query)) {
		$n = $n + 1;
		$images = '';
		$subdata = array();
		$comercio = $IdCompany;
		$productos = "productos";
		$directorio_escaneado = scandir("Comercio/" . $comercio . "/" . $productos . "");
		foreach ($directorio_escaneado as $item) {
			if ($item != '.' and $item != '..') {
				$nnn = preg_split('/_/', $item);
				$Mbooking_number = trim($row["CodIdBasico"]);
				if ($nnn[0] == $Mbooking_number) {
					$images = $images . "<div><img src='/Comercio/$comercio/$productos/$item' width='100'></div>";
				}
			}
		}
		$images = '';
		if ($images == '') {
			$images = "<div class='p-1'><img src='../img/no-photo-available2.png' alt='' width='100' srcset=''></div>";
		}
		$m = 0;
		$sqlp = "SELECT * FROM PosUpTxD where IdCompany=" . $IdCompany . " and CodIdBasico='" . $row["CodIdBasico"] . "'  limit 2";
		if ($result2 = mysqli_query($conn, $sqlp)) {
			while ($row2 = mysqli_fetch_assoc($result2)) {
				$m = $m + 1;
			}
			mysqli_free_result($result2);
		}
		if ($_POST["userperfil"] <= 2000 || $post["userperfil"] == "2055" || $post["userperfil"] == "2054" || $post["userperfil"] == "2053") {
			if ($m == 0) {
				$elimin = "<button class='btn btn-outline-danger p-1 m-1' type='button' data-toggle='tooltip' title='" . lang("Eliminar Registro") . "' id='eliminar1' onclick='alertaborrar(" . $n . ",`" . $row["CodIdBasico"] . "`,`" . $row["Descripcion"] . "`,`" . $row["CodIdBasicoPadre"] . "`);'><span class='fa fa-trash'></span></button>";
			}
			$price = "<button class='btn btn-outline-success p-1 m-1' type='button' data-toggle='tooltip' title='" . lang("Costos de Productos") . "' id='editar21' onclick='recibir2(" . $n . ",`" . $var . "`);'><span class='fa fa-money'></span></button>";
		}
		$comision = $row["Comision"] * 100;
		$comision2 = $row["Comision2"] * 100;
		$comision3 = $row["Comision3"] * 100;

		$Medida = '';
		$Medida = $row["Medida"];
		$UnidadP1 = $row["UnidadP1"];
		$UnidadP2 = $row["UnidadP2"];
		$UnidadP4 = $row["UnidadP4"];

		if ($Medida <> '') {
			$Medida = "<span class='badge bg-success text-white'>" . $row["Medida"] . "</span>";
		}

		if ($UnidadP1 <> '') {
			$UnidadP1 = "<span class='badge bg-success text-white'>" . $row["UnidadP1"] . "</span>";
		}

		if ($UnidadP2 <> '') {
			$UnidadP2 = "<span class='badge bg-success text-white'>" . $row["UnidadP2"] . "</span>";
		}

		if ($UnidadP4 <> '') {
			$UnidadP4 = "<span class='badge bg-success text-white'>" . $row["UnidadP4"] . "</span>";
		}

		if (trim($row['CodIdBasicoPadre']) == trim($row['CodIdBasico'])) {
			//	$varprod="<button class='btn btn-outline-success p-1 m-1' type='button' data-toggle='tooltip' title='Agregar Variación' id='editar1' onclick='varproduct(".$n.");''><span class='fa fa-plus'></span></button>";
		} else {
			$varprod = '';
		}


		if (($row['CodIdBasico'] == $row['CodIdBasicoPadre'] or $row['CodIdBasicoPadre'] == '') and trim($row['VariationsTypes']) <> '') {
			$textVariation = "<span class='badge bg-info text-light' >Has Varations</span>";
		} else {
			$textVariation = "";
		}
		$vartypes = $row['VariationsTypes'];
		$Textvar = $row['Textvar'];
		$explode = explode(',', $vartypes);
		$Textvar = explode('|', $Textvar);
		$z = 0;
		$variations = '';
		foreach ($explode as $types) {
			if (trim($types) <> '') {
				if (trim($Textvar[$z]) <> '') {
					$variations .= "<span class='badge bg-success text-light'>$types</span> <span class='badge bg-light text-dark'>" . $Textvar[$z] . "</span> ";
				}
				$z = $z + 1;
			}
		}

		if ($variations <> '') {
			$variations = "<br>" . $variations;
		}

		if ($textVariation <> '') {
			$textVariation = "<br>" . $textVariation;
		}


		$var = '';

		if (($row['CodIdBasico'] == $row['CodIdBasicoPadre'] or $row['CodIdBasicoPadre'] == '') and trim($row['VariationsTypes']) <> '') {

			$sql = "SELECT a.*    FROM PosUpProducto a  
										where a.IdCompany=" . $IdCompany . " and CodIdBasicoPadre='" . $row['CodIdBasicoPadre'] . "'   and CodIdBasico<>'" . $row['CodIdBasicoPadre'] . "'";
			$nrow = 0;

			if ($result3 = mysqli_query($con, $sql)) {
				while ($row3 = mysqli_fetch_assoc($result3)) {
					$nrow = $nrow + 1;
				}
			}



			if ($nrow >= 1) {
				$var = "0";
			} else {
				$var = "1";
			}
		} else {
			$var = '2';
		}


		if ($row['CodIdBasico'] <> $row['CodIdBasicoPadre'] and trim($row['CodIdBasicoPadre']) <> '') {

			$sql = "SELECT a.*    FROM PosUpProducto a  
										where a.IdCompany=" . $IdCompany . " and  CodIdBasico='" . $row['CodIdBasicoPadre'] . "'  ";

			if ($result3 = mysqli_query($con, $sql)) {
				while ($row3 = mysqli_fetch_assoc($result3)) {
					$textVariation = "<span class='badge bg-info text-light' >" . lang('Variaciones de') . ":</span> <span class='badge bg-success text-light' id='SkuFaSS" . $n . "' >" . $row3['CodIdAmpliado'] . "</span> <span class='badge bg-light text-dark' id='TitFaSS" . $n . "' >" . $row3['Descripcion'] . "</span> ";
				}
			}
		} else {
		}





		if (trim($row['CodIdBasicoPadre']) <> '') {
			$varia = ' <span class="badge bg-success text-light">' . lang('Variación') . ': </span> ';
		} else {
			$varia = ' ';
		}

		if (trim($row['Textvar']) <> '') {
			$TextVar = '<span class="badge bg-light text-dark">' . trim($row['Textvar']) . '</span>';
		} else {
			$TextVar = '';
		}

		if (trim($row['Groupvar']) <> '') {
			$Groupvar = '<span class="badge bg-light text-dark">' . trim($row['Groupvar']) . '</span>';
		} else {
			$Groupvar = '';
		}

		$subdata[] = "
								<span style='display:none' class='d-none' id='descripcionSS" . $n . "'>" . trim($row['Descripcion']) . "</span>
								<span style='display:none' class='d-none' id='codidbasico1SS" . $n . "'>" . trim($row['CodIdBasico']) . "</span> 
								<span style='display:none' class='d-none' id='codidampliadoSS" . $n . "'>" . trim($row['CodIdAmpliado']) . "</span>
					<span style='display:none' class='d-none' id='larga". $n . "'>" . trim($row['DL']) . "</span> 
					<span style='display:none' class='d-none' id='corta". $n . "'>" . trim($row['DC']) . "</span> 
								<span style='display:none' class='d-none' ><input class='d-none'  id='largvva" . $n . "' value='" . trim($row['DL']) . "'/></span> 
								<span style='display:none' class='d-none' ><input class='d-none'  id='cortvva" . $n . "' value='" . trim($row['DC']) . "'/><</span> 

								<span style='display:none' class='d-none' id='codbarraSS" . $n . "'>" . trim($row['CodBarra']) . "</span>
								<span style='display:none' class='d-none' id='medidaSS" . $n . "'>" . trim($row['Medida']) . "</span> 
								<span style='display:none' class='d-none' id='impuestoSS" . $n . "'>" . trim($row['Impuesto']) . "</span>
								<span style='display:none' class='d-none' id='costoSS" . $n . "'>" . trim($row['Costo']) . "</span>
								<span style='display:none' class='d-none' id='margen1SS" . $n . "'>" . trim($row['Margen']) . "</span> 
								<span style='display:none' class='d-none' id='precioventaSS" . $n . "'>" . number_format(trim($row['PrecioVenta']), $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . "</span>
								<span style='display:none' class='d-none' id='preciodeventa2SS" . $n . "'>" . trim($row['PrecioVenta']) . "</span>
								<span style='display:none' class='d-none' id='costonetoSS" . $n . "'>" . trim($row['CostoNeto']) . "</span>
								<span style='display:none' class='d-none' id='precioneto1SS" . $n . "'>" . trim($row['PrecioNeto']) . "</span> 
								<span style='display:none' class='d-none' id='estadoSS" . $n . "'>" . trim($row['Estado']) . "</span>
								<span style='display:none' class='d-none' id='rutultimoproveedorSS" . $n . "'>" . trim($row['RutUltimoProveedor']) . "</span>
								<span style='display:none' class='d-none' id='envaseSS" . $n . "'>" . trim($row['Envase']) . "</span> 
								<span style='display:none' class='d-none' id='idfamiliaSS" . $n . "'>" . trim($row['Idfamilia']) . "</span>
								<span style='display:none' class='d-none' id='IdFamiliaAdds" . $n . "'>" . trim($row['IdFamiliaAdds']) . "</span>
								<span style='display:none' class='d-none' id='NOmarcaSS" . $n . "'>" . trim($row['Marcaxd']) . "</span>
								<span style='display:none' class='d-none' id='NOfamiliaSS" . $n . "'>" . trim($row['Familia']) . "</span>
								<span style='display:none' class='d-none' id='marcaSS" . $n . "'>" . trim($row['Marca']) . "</span>

								<span style='display:none' class='d-none' id='onvarSS" . $n . "'>" . trim($row['OnVariacion']) . "</span>
								<span style='display:none' class='d-none' id='codpadSS" . $n . "'>" . trim($row['CodIdBasicoPadre']) . "</span>

								<span style='display:none' class='d-none' id='despadrSS" . $n . "'>" . trim($row['DescriPadre']) . "</span>
								<span style='display:none' class='d-none' id='codampareSS" . $n . "'>" . trim($row['CodIdAmpPadre']) . "</span> 

								<span style='display:none' class='d-none' id='grpvSS" . $n . "'>" . trim($row['Groupvar']) . "</span>
								<span style='display:none' class='d-none' id='txtvSS" . $n . "'>" . trim($row['Textvar']) . "</span>


								<span style='display:none' class='d-none' id='minSS" . $n . "'>" . trim($row['Min']) . "</span> 
								<span style='display:none' class='d-none' id='maxSS" . $n . "'>" . trim($row['Max']) . "</span>
								<span style='display:none' class='d-none' id='exisSS" . $n . "'>" . trim($row['Exis']) . "</span>
								<span style='display:none' class='d-none' id='porkiloSS" . $n . "'>" . trim($row['PorKilo']) . "</span> 
								<span style='display:none' class='d-none' id='escompuestoSS" . $n . "'>" . trim($row['EsCompuesto']) . "</span>
								<span style='display:none' class='d-none' id='bodegaSS" . $n . "'>" . trim($row['bodega']) . "</span>
								<span style='display:none' class='d-none' id='salaSS" . $n . "'>" . trim($row['sala']) . "</span>
								<span style='display:none' class='d-none' id='Margen200SS" . $n . "'>" . trim($row['Margen2']) . "</span>
								<span style='display:none' class='d-none' id='PrecioVenta2SS" . $n . "'>" . trim($row['PrecioVenta2']) . "</span>
								<span style='display:none' class='d-none' id='PrecioNeto2SS" . $n . "'>" . trim($row['PrecioNeto2']) . "</span>
								<span style='display:none' class='d-none' id='Margen3SS" . $n . "'>" . trim($row['Margen3']) . "</span>
								<span style='display:none' class='d-none' id='PrecioVenta3SS" . $n . "'>" . trim($row['PrecioVenta3']) . "</span>
								<span style='display:none' class='d-none' id='PrecioNeto3SS" . $n . "'>" . trim($row['PrecioNeto3']) . "</span>
								<span style='display:none' class='d-none' id='Margen4SS" . $n . "'>" . trim($row['Margen4']) . "</span>
								<span style='display:none' class='d-none' id='PrecioVenta4SS" . $n . "'>" . trim($row['PrecioVenta4']) . "</span>
								<span style='display:none' class='d-none' id='PrecioNeto4SS" . $n . "'>" . trim($row['PrecioNeto4']) . "</span>
								<span style='display:none' class='d-none' id='CantP1xSS" . $n . "'>" . trim($row['CantP1']) . "</span>
								<span style='display:none' class='d-none' id='UnidadP1xSS" . $n . "'>" . trim($row['UnidadP1']) . "</span>
								<span style='display:none' class='d-none' id='CantP2SS" . $n . "'>" . trim($row['CantP2']) . "</span>
								<span style='display:none' class='d-none' id='CantP4SS" . $n . "'>" . trim($row['CantP4']) . "</span>
								<span style='display:none' class='d-none' id='UnidadP2xSS" . $n . "'>" . trim($row['UnidadP2']) . "</span>
								<span style='display:none' class='d-none' id='UnidadP4xSS" . $n . "'>" . trim($row['UnidadP4']) . "</span>
								<span style='display:none' class='d-none' id='compleSS" . $n . "'>" . trim($row['Complementos']) . "</span>
								<span style='display:none' id='CodIdBasicoMasterYISS" . $n . "'>" . $row["CodIdBasico"] . "</span>

								
								<span style='display:none' id='factorunitxSS" . $n . "'>" . $row["factorunit"] . "</span>
								<span style='display:none' id='anchoxSS" . $n . "'>" . $row["ancho"] . "</span>
								<span style='display:none' id='altoxSS" . $n . "'>" . $row["alto"] . "</span>
								<span style='display:none' id='comSS" . $n . "'>" . $comision . "</span>
								<span style='display:none' id='comdSS" . $n . "'>" . $comision2 . "</span>
								<span style='display:none' id='comtSS" . $n . "'>" . $comision3 . "</span>
								<span style='display:none' id='comcuaSS" . $n . "'>" . $comision4 . "</span>
								<span style='display:none' id='jsonfactor" . $n . "'>" . trim($row["jsonfactor"]) . "</span>
							
								<div class='d-flex text-start'>
									<div class='d-none d-sm-block'>
										<div class='p-1'>" . $images . "</div>
									</div>
									<div class='text-wrap p-1'>
										<div class='p-1 text-center d-block d-sm-none'>" . (trim($images) == "<div class='p-1'><img src='../img/no-photo-available2.png' alt='' width='100' srcset=''></div>" ? ' ' : ' ' . $images . '') . "</div>
										" . (trim($images) == "<div class='p-1'><img src='../img/no-photo-available2.png' alt='' width='100' srcset=''></div>" ? '' : '<br>') . "
										<strong>" . $row["Descripcion"] . "</strong>  " . $textVariation . $variations . "  </br>
										<span class='badge bg-light text-dark'>" . lang("SKU") . ": " . $row["CodIdAmpliado"] . '</span> <span class="badge bg-light text-dark text-wrap">' . lang("BarCode") . ': <span class="fa fa-barcode"></span> ' . $row["CodBarra"] . '</span> <span class="badge bg-light text-dark">' . lang("ID") . ': ' . $row["CodIdBasico"] . ' </span></br>' .
			' <span class="badge bg-primary text-light">' . $row["Marcaxd"] . '</span>' .
			' <span class="badge bg-info text-dark">' . $row["Familia"] . '</span> ' .
			($row["PorKilo"] == 1 ? ' <span class="badge bg-success text-light">' . lang("POR PESO") . '</span>' : '') .
			($row["Estado"] == 1 ? ' <span class="badge bg-success text-light"><span class="fa fa-arrow-up"></span> ' . lang("ACTIVO") . '</span>' : ' <span class="badge bg-danger text-light"><span class="fa fa-arrow-down"></span> ' . lang("INACTIVO") . '</span>') .
			($row["esserial"] == 1 ? ' <span class="badge bg-warning text-dark"><span class="fa fa-barcode"></span> ' . lang("SERIAL") . '</span>' : '') .
			($row["eslote"] == 1 ? ' <span class="badge bg-warning text-dark"><span class="fa fa-calendar-check-o"></span> Lotes y Vencimiento</span>' : '') .
			($row["EsCompuesto"] == 0 ? ' <span class="badge bg-success text-light"><span class="fa fa-dropbox"></span> ' . lang("PRODUCTO") . '</span>' : ($row["EsCompuesto"] == 9 ? ' <span class="badge bg-success text-light"> ' . lang("SERVICIO") . '</span>' : ' <span class="badge bg-danger text-light"> ' . lang("COMBO - SET - PACK") . '</span>')) . "
									</div>
								</div>
								<div class='d-flex justify-content-center text-wrap '>
									<button class='btn btn-outline-info p-1 m-1' type='button' data-toggle='tooltip' title='" . lang("Información de Productos") . "' id='editar1' onclick='varinfo(" . $n . ",`" . $var . "`);''><span class='fa fa-info-circle'></span></button>
									" . $elimin . "
									<button class='btn btn-outline-warning p-1 m-1' type='button' title='" . lang("Imagen del Producto") . "' id='editar31' onclick='fotovar(`" . $row["CodIdBasico"] . "`,`" . $row["Descripcion"] . "`,`" . $row["CodIdAmpliado"] . "`);'><span class='fa fa-image'></span></button>
									" . $varprod . "
									" . $aud . "
								</div>";



		$PosPVP = "<span class='badge bg-light text-dark'>" . lang("Precio") . " 1</span> <span class='badge bg-warning text-dark'>" . number_format($row['PrecioVenta'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $_POST["MonedaP"] . "</span> " . $Medida . "</br>";
		$PosPVP .= "<span class='badge bg-light text-dark'>" . lang("Precio") . " 2</span> <span class='badge bg-warning text-dark'>" . number_format($row['PrecioVenta2'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $_POST["MonedaP"] . "</span> " . $UnidadP1 . "</br>";
		$PosPVP .= "<span class='badge bg-light text-dark'>" . lang("Precio") . " 3</span> <span class='badge bg-warning text-dark'>" . number_format($row['PrecioVenta3'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $_POST["MonedaP"] . "</span> " . $UnidadP2 . "</br>";
		$PosPVP .= "<span class='badge bg-light text-dark'>" . lang("Precio") . " 4</span> <span class='badge bg-warning text-dark'>" . number_format($row['PrecioVenta4'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $_POST["MonedaP"] . "</span> " . $UnidadP4 . "";
		$subdata[] = $PosPVP; //salary
		//$subdata[]='<button type="button" id="getEdit" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal" data-id="'.$row[0].'"><i class="ion-edit"></i></button>
		//            <button type="button" id="getEdit" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal" data-id="'.$row[0].'"><i class="ion-android-delete"></i></button>';
		$data[] = $subdata;
	}
	$json_data = array(
		"draw"              =>  intval($request['draw']),
		"recordsTotal"      =>  intval($totalData),
		"recordsFiltered"   =>  intval($totalFilter),
		"data"              =>  $data
	);

	echo json_encode($json_data);
}

if (isset($_POST['Accion']) && $_POST['Accion'] == "updatevar-product") {

	include "ambiente.php";
	$con = conectar();
	$conn = conectar();
	$sql = "UPDATE   PosUpProducto set TextVar='" . $_POST['TextVar'] . "' , VariationsTypes='" . $_POST['VariationsTypes'] . "' where CodIdBasico='" . trim($_POST["Id"]) . "' and IdCompany=" . trim($_POST["CompanyActual"]);
	$stmt = mysqli_query($conn, $sql);
}

if (isset($_POST['Accion']) && $_POST['Accion'] === "HistoricoSerial") {

	include "ambienteconsultas.php";
	$con = conectar();
	$conn = conectar();
	$Betweenserial = "and c.Seriales = '" . $_POST["Serial"] . "'";
	// || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053"
	if ($_POST['userperfil'] <= 2000) {
		$monto = ",round(b.Total*d.Inventario,2) as Monto";
	}

	$qry = "SET SESSION group_concat_max_len = 1000000";
	$result = mysqli_query($conn, $qry);
	$InventarioInicial = 0;
	$InventarioFinal = 0;
	$sql2 = "SELECT DISTINCT sum(c.Cant*d.Inventario) as cant 
						FROM PosUpProducto a 
						inner join PosUpTxC b on a.IdCompany = b.IdCompany 
						inner join PosUpTxD c on a.CodIdBasico=c.CodIdBasico AND a.IdCompany=c.IdCompany and b.Idtx=c.Idtx and b.Idtipotx=c.Idtipotx and b.IdEstacion = c.IdEstacion 
						inner join PosUpTx d on b.Idtipotx = d.Idtipotx and d.Inventario <> 0  
						left join PosUpclientes e on a.IdCompany = e.IdCompany and b.IdBen = e.RUT 
						inner join PosUpAlmacen f on c.IdCompany = f.IdCompany and c.IdAlm = f.IdAlm 
						where a.IdCompany=" . $_POST["CompanyActual"] . " and a.EsCompuesto=0 
						" . $Betweenserial . " and b.Fectxclient < '" . $_POST["Desde"] . "' order by b.Fectxclient asc
						";
	$result = mysqli_query($conn, $sql2);

	while ($row = mysqli_fetch_assoc($result)) {
		$InventarioInicial += $row["cant"];
		$InventarioFinal += $row["cant"];
	}

	$sql = "SELECT DISTINCT b.Idtipotx,b.IdtipotxPadre,b.IdtxPadre,b.IdEstacionPadre,a.CodBarra,a.CodIdBasico,a.CodIdAmpliado, a.Descripcion,c.Seriales,
						DATE_FORMAT(b.Fectxclient,'%d/%m/%Y %h:%i:%s %p') as Fectxclient,  
						d.TitCto as Titulo ,
						if(if(b.Idtipotx in (1,2,3,4,5,6,11,12,13,15,21,22,23,24,25,26,31,35,36,37),ee.NumTxViewVTA,if(b.Idtipotx in (7,14,20,27,28),ee.NumTxViewCOM,if(b.Idtipotx in (8,9,10,16,17,18,19,29,30,32,33,34,39),ee.NumTxViewINV,''))) = 0,b.IdtxCompany,if(if(b.Idtipotx in (1,2,3,4,5,6,11,12,13,15,21,22,23,24,25,26,31,35,36,37),ee.NumTxViewVTA,if(b.Idtipotx in (7,14,20,27,28),ee.NumTxViewCOM,if(b.Idtipotx in (8,9,10,16,17,18,19,29,30,32,33,34,39),ee.NumTxViewINV,''))) = 1,b.Idtx,b.Referencia)) as IdtxDef,
						b.IdUser  as Usuario,CONCAT(e.RUT,' ',e.Nombre) as beneficiario,
						concat('(',c.IdAlm,') ',f.Nombre) as Almacen , 
						b.DTE,
						c.Cant*d.Inventario as cant " . $monto . "
						FROM PosUpProducto a 
						inner join PosUpTxC b on a.IdCompany = b.IdCompany 
						inner join PosUpTxD c on a.CodIdBasico=c.CodIdBasico AND a.IdCompany=c.IdCompany and b.Idtx=c.Idtx and b.Idtipotx=c.Idtipotx and b.IdEstacion = c.IdEstacion 
						inner join PosUpTx d on b.Idtipotx = d.Idtipotx and d.Inventario <> 0  
						left join PosUpclientes e on a.IdCompany = e.IdCompany and b.IdBen = e.RUT 
						inner join PosUpAlmacen f on c.IdCompany = f.IdCompany and c.IdAlm = f.IdAlm 
						left join PosUpCompany ee on ee.Id=a.IdCompany
						where a.IdCompany=" . $_POST["CompanyActual"] . " and a.EsCompuesto=0 and c.Seriales <> ''
						" . $Betweenserial . "  and b.Fectxclient >= '" . $_POST["Desde"] . "' and b.Fectxclient <= '" . $_POST["Hasta"] . "'  order by b.Fectxclient asc, c.Cant asc
						";

	$tbody = '
						<table class="table table-hover table-striped nowrap" >
							<thead>
								<tr>
									<th>' . lang("Fecha") . '</th>
									<th>' . lang("Operación") . '</th>
									<th>' . lang("Cliente o Proveedor") . '</th>
									<th>' . lang("Depósito") . '</th>
									<th>' . lang("Cantidad") . '</th>
								</tr>
							</thead>
							<tbody>
						';
	$n = 0;
	$span = "";

	if ($result = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$InventarioFinal += $row["cant"];
			$n++;
			if ($row['DTE'] == 0) {
				$Tx = str_pad($row['IdtxDef'], 6, "0", STR_PAD_LEFT) . '</span>';
			} else {
				$Tx = str_pad($row['DTE'], 6, "0", STR_PAD_LEFT) . '</span>';
			}
			$tbody .= "<tr>";
			$tbody .= "<td>" . $row['Fectxclient'] . " <div><span class='badge bg-primary text-light'><i class='fa fa-user'></i> " . $row['Usuario'] . "</span></div></td>";
			$tbody .= "<td>" . $row['Titulo'] . "-" . $Tx . " <div><span class='badge bg-warning text-dark text-wrap' style='max-width:1500px;'>" . $row["Seriales"] . "</span></td>";
			$tbody .= "<td>" . $row['beneficiario'] . "<br>(" . $row["CodIdAmpliado"] . ") " . $row["Descripcion"] . "</td>";
			$tbody .= "<td>" . $row['Almacen'] . "</td>";
			$tbody .= "<td>" . number_format($row['cant'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . "</td>";
			$tbody .= "</tr>";
		}
	}
	$span .= "<span style='display:none;' id='allreghistoricoserial'>" . $n . "</span>";
	$span .= "<span style='display:none;' id='InvFinHisSer'>" . $InventarioFinal . "</span>";
	$span .= "<span style='display:none;' id='InvIniHisSer'>" . $InventarioInicial . "</span>";
	$tbody .= " </tbody> </table>" . $span;
	echo $tbody;
}

if (isset($_POST['Accion']) && $_POST['Accion'] === "HistoricoSerial2") {

	include "ambienteconsultas.php";
	$con = conectar();
	$conn = conectar();
	$Betweenserial = "and a.CodIdBasico = '" . $_POST["CodIdBasicoHistSer"] . "'";
	// || $_POST["userperfil"] == "2055" || $_POST["userperfil"] == "2054" || $_POST["userperfil"] == "2053"
	if ($_POST['userperfil'] <= 2000) {
		$monto = ",round(b.Total*d.Inventario,2) as Monto";
	}
	$search = "";
	$search .= ($_POST["IdUbi"] !== "*" ? " and h.IdUbi=" . $_POST["IdUbi"] : "");
	$search .= ($_POST["IdAlm"] !== "*" ? " and h.IdAlm=" . $_POST["IdAlm"] : "");

	$qry = "SET SESSION group_concat_max_len = 1000000";
	$result = mysqli_query($conn, $qry);
	$InventarioInicial = 0;
	$InventarioFinal = 0;
	$sql = "SELECT DISTINCT sum(c.Cant*d.Inventario) as cant 
			FROM PosUpProducto a 
			inner join PosUpTxC b on a.IdCompany = b.IdCompany 
			inner join PosUpTxD c on a.CodIdBasico=c.CodIdBasico AND a.IdCompany=c.IdCompany and b.Idtx=c.Idtx and b.Idtipotx=c.Idtipotx and b.IdEstacion = c.IdEstacion 
			inner join PosUpTx d on b.Idtipotx = d.Idtipotx and d.Inventario <> 0  
			left join PosUpclientes e on a.IdCompany = e.IdCompany and b.IdBen = e.RUT 
		left join PosUpAlmacen f on b.IdCompany = f.IdCompany and b.IdAlmO = f.IdAlm 
		left join PosUpAlmacen g on b.IdCompany = g.IdCompany and b.IdAlmD = g.IdAlm 
		left join PosUpAlmacen h on c.IdCompany = h.IdCompany and c.IdAlm = h.IdAlm 
			where a.IdCompany=" . $_POST["CompanyActual"] . " and a.EsCompuesto=0 
			" . $Betweenserial . " and b.Fectxclient < '" . $_POST["Desde"] . "' " . $search . " order by b.Fectxclient asc, sum(c.Cant*d.Inventario) asc
		";
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($result)) {
		$InventarioInicial += $row["cant"];
		$InventarioFinal += $row["cant"];
	}
	$sql = "SELECT DISTINCT if(if(b.Idtipotx in (1,2,3,4,5,6,11,12,13,15,21,22,23,24,25,26,31,35,36,37),ee.NumTxViewVTA,if(b.Idtipotx in (7,14,20,27,28),ee.NumTxViewCOM,if(b.Idtipotx in (8,9,10,16,17,18,19,29,30,32,33,34,39),ee.NumTxViewINV,''))) = 0,b.IdtxCompany,if(if(b.Idtipotx in (1,2,3,4,5,6,11,12,13,15,21,22,23,24,25,26,31,35,36,37),ee.NumTxViewVTA,if(b.Idtipotx in (7,14,20,27,28),ee.NumTxViewCOM,if(b.Idtipotx in (8,9,10,16,17,18,19,29,30,32,33,34,39),ee.NumTxViewINV,''))) = 1,b.Idtx,b.Referencia)) as IdtxDef,b.Idtipotx,b.IdtipotxPadre,b.DAmpliado,b.Referencia,b.Motivo,b.IdtxPadre,b.IdEstacionPadre,a.CodBarra,a.CodIdBasico,a.CodIdAmpliado, a.Descripcion,GROUP_CONCAT(DISTINCT c.Seriales ORDER BY c.Seriales ASC SEPARATOR ' ') as Seriales,
		DATE_FORMAT(b.Fectxclient,'%d/%m/%Y %h:%i:%s %p') as Fectxclient,  concat(d.TitCto,'-') as Titulo ,b.IdUser  as Usuario,CONCAT(e.RUT,' ',e.Nombre) as beneficiario,
		concat('(',c.IdAlm,') ',h.Nombre) as Almacen ,g.Nombre as AlmacenDestino,f.Nombre as AlmacenOrigen,b.IdAlmO,b.IdAlmD,a.Medida,
		sum(c.Cant*d.Inventario) as cant " . $monto . ",b.IdEstacion,b.Idtipotx,b.Idtx
		FROM PosUpProducto a 
		inner join PosUpTxC b on a.IdCompany = b.IdCompany 
		inner join PosUpTxD c on a.CodIdBasico=c.CodIdBasico AND a.IdCompany=c.IdCompany and b.Idtx=c.Idtx and b.Idtipotx=c.Idtipotx and b.IdEstacion = c.IdEstacion 
		inner join PosUpTx d on b.Idtipotx = d.Idtipotx and d.Inventario <> 0  
		left join PosUpclientes e on a.IdCompany = e.IdCompany and b.IdBen = e.RUT 
		left join PosUpAlmacen f on b.IdCompany = f.IdCompany and b.IdAlmO = f.IdAlm 
		left join PosUpAlmacen g on b.IdCompany = g.IdCompany and b.IdAlmD = g.IdAlm 
		left join PosUpAlmacen h on c.IdCompany = h.IdCompany and c.IdAlm = h.IdAlm 
		left join PosUpCompany ee on ee.Id=a.IdCompany
		where a.IdCompany=" . $_POST["CompanyActual"] . " and a.EsCompuesto=0 
		" . $Betweenserial . " and b.Fectxclient >= '" . $_POST["Desde"] . "' and b.Fectxclient <= '" . $_POST["Hasta"] . "' " . $search . " group by c.IdCompany,c.Idtx,c.Idtipotx,c.IdEstacion,c.IdAlm,c.CodIdBasico order by b.Fectxclient asc, sum(c.Cant*d.Inventario) asc
		";


	$n = 0;
	$span = "";
	$Medida = "";
	if ($result = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$Medida = $row["Medida"];
			$InventarioFinal += $row["cant"];
			$n++;
			$tbody .= "
					<tr>
						<td>" . $row['Titulo'] . $row["IdtxDef"] . " <button class='btn btn-outline-dark  p-1' type='button' title='" . lang("Vista Previa") . "' onclick='Impresion(`" . $row['IdEstacion'] . "`,`" . $row['Idtipotx'] . "`,`" . $row['Idtx'] . "`,`1`,`1`)'> <i class='fa fa-print'></i></button></td>
						<td>" . $row['Fectxclient'] . "</td>
						<td>" . $row['beneficiario'] . "</td>
						<td><span class='badge bg-info text-dark'>" . (($row["IdAlmD"] === "0" or $row["IdAlmO"] === "0" or $row["IdAlmO"] === $row["IdAlmD"]) ? $row["Almacen"] : $row["AlmacenOrigen"] . " <i class='fa fa-arrow-right'></i> " . $row["AlmacenDestino"]) . "</span></td>
						<td class=' text-end'><div class='fw-bold text-end' style='font-size: 18px;'>" . getcantformat($row['cant'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . "</div></td>
					</tr>
					<tr class='pb-0 pt-0'>
						<td class='pb-0 pt-0'><span class='badge bg-primary text-light'><i class='fa fa-user'></i> " . $row['Usuario'] . "</span> </td>
						<td class='pb-0 pt-0' colspan='4'>" . ($row["DAmpliado"] !== "" ? "<span class='badge bg-light text-dark'>" . $row["DAmpliado"] . "</span>" : "") . " " . ($row["Referencia"] !== "" ? "<span class='badge bg-light text-dark'>" . $row["Referencia"] . "</span>" : "") . " " . ($row["Motivo"] !== "" ? "<span class='badge bg-light text-dark'>" . $row["Motivo"] . "</span>" : "") . "</td>
					</tr>
				";
			if (trim($row["Seriales"]) !== "") {
				$tbody .= "<tr class='pb-0 pt-0'>";
				$tbody .= "<td class='pb-0 pt-0' colspan='5'><div><span class='badge bg-warning text-dark text-wrap' style='max-width:1500px;'>" . $row["Seriales"] . "</span></div></td>";
				$tbody .= "</tr>";
			}
		}
	}
	$tabla = '
			<table class="table table-hover table-striped nowrap" >
				<thead>
					<tr>
						<th>' . lang("Operación") . '</th>
						<th>' . lang("Fecha") . '</th>
						<th>' . lang("Beneficiario") . '</th>
						<th>' . lang("Almacén") . '</th>
						<th class="text-end align-items-center">' . lang("Cantidad") . ' <span class="badge bg-success text-light">' . $Medida . '</span></th>
					</tr>
				</thead>
				<tbody>
					' . $tbody . '
				</tbody> 
				' . "
					<span style='display:none;' id='allreghistoricoserial2'>" . $n . "</span>
					<span style='display:none;' id='InvFinHisSer2'>" . getcantformat(ROUND($InventarioFinal, 3), 3, $_POST["SimDec"], $_POST["SimMil"]) . "</span>
					<span style='display:none;' id='InvIniHisSer2'>" . getcantformat(ROUND($InventarioInicial, 3), 3, $_POST["SimDec"], $_POST["SimMil"])  . "</span>
				" . '
			</table>
			' . $span;
	echo $tabla;
}

if ($_POST["Action"] === "SubirExcel") {
	include("ambiente.php");
	$conn = conectar();
	if ($_POST["Option"] === "1") {
		if (isset($_FILES['Archivosubir']) && isset($_POST['CompanyActual']) && trim($_POST['CompanyActual']) !== "" && trim($_POST['EsCompuesto']) !== "") {
			$response = json_decode(ExcelToJson($_FILES['Archivosubir'], $_POST["CompanyActual"], $_POST["EsCompuesto"]), true);
			if ($response["status"] === 1) {

				$query = "SELECT CodIdBasico,CodIdAmpliado,CodBarra FROM PosUpProducto WHERE IdCompany=" . $_POST["CompanyActual"];
				$CodIdAmpliado = array();
				$CodBarra = array();
				if ($result = mysqli_query($conn, $query)) {
					while ($row = mysqli_fetch_array($result)) {
						$CodIdAmpliado[$row["CodIdAmpliado"]] = $row["CodIdBasico"];
						$CodBarra[$row["CodBarra"]] = $row["CodIdBasico"];
					}
				}
				$mostrar = "";
				foreach ($response['data'] as $value) {
					$Color = "";
					if (trim($CodIdAmpliado[$value["CodIdAmpliado"]]) !== "") $Color = "text-light bg-danger";
					if (trim($CodBarra[$value["CodBarra"]]) !== "") $Color = "text-light bg-danger";

					$imagen = "../img/no-photo-available2.png";
					if (trim($value["Imagen"]) !== "") $imagen = $value["Imagen"];

					$mostrar .= "
										<div class='text-start border-top border-1 border-start border-end " . $Color . "'>
											<div class='row'>
												<div class='col-9'>
													<div class='d-none d-sm-block'>
														<div class='p-1'>
															<div class='p-1'>
																<img src='" . $imagen . "' alt='' width='100' srcset=''>
															</div>
														</div>
													</div>
													<div class='text-wrap p-1'>
														<div class='p-1 text-center d-block d-sm-none'>
															<div class='p-1'>
																<img src='" . $imagen . "' alt='' width='100' srcset=''>
															</div>
														</div>
														<div>
															<strong>" . $value["Descripcion"] . "</strong>
														</div>
														<div>
															<span class='badge bg-light text-dark'>" . lang("SKU") . ": " . $value["CodIdAmpliado"] . "</span>
															<span class='badge bg-light text-dark'>" . lang("BarCode") . ": <i class='fa fa-barcode'></i> " . $value["CodBarra"] . "</span>
														</div>
														<span class='badge bg-primary text-light'>" . $value["Marca"] . "</span>
														<span class='badge bg-info text-dark'>" . $value["Idfamilia"] . "</span>
														<span class='badge bg-danger text-light'>" . $value["NombreImpuesto"] . " (" . $value["ValorImpuesto"] . "%)</span>
														" . ($value["PorKilo"] == 1 ? " <span class='badge bg-success text-light'>" . lang("POR PESO") . "</span>" : "") . "
														" . ($_POST["EsCompuesto"] == "0" ? "<span class='badge bg-success text-light'><span class='fa fa-dropbox'></span> " . lang("PRODUCTO") . "</span>" : ($_POST["EsCompuesto"] == "9" ? "<span class='badge bg-success text-light'> " . lang("Servicio") . "</span>" : "")) . "
													</div>
												</div>
												<div class='col-3'>
													<div><span class='badge bg-light text-dark'>" . lang("Costo") . "</span> <span class='badge bg-warning text-dark'>" . number_format($value['Costo'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $_POST["MonedaP"] . "</span> <span class='badge bg-success text-light'>" . $value["Medida"] . " (1)</span></div>
													<div><span class='badge bg-light text-dark'>" . lang("Precio") . " 1</span> <span class='badge bg-warning text-dark'>" . number_format($value['Precio'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $_POST["MonedaP"] . "</span> <span class='badge bg-success text-light'>" . $value["Medida"] . " (1)</span></div>
													<div><span class='badge bg-light text-dark'>" . lang("Precio") . " 2</span> <span class='badge bg-warning text-dark'>" . number_format($value['Precio2'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $_POST["MonedaP"] . "</span> <span class='badge bg-success text-light'>" . $value["UnidadP1"] . " (" . $value["CantP1"] . ")</span></div>
													<div><span class='badge bg-light text-dark'>" . lang("Precio") . " 3</span> <span class='badge bg-warning text-dark'>" . number_format($value['Precio3'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $_POST["MonedaP"] . "</span> <span class='badge bg-success text-light'>" . $value["UnidadP2"] . " (" . $value["CantP2"] . ")</span></div>
													<div><span class='badge bg-light text-dark'>" . lang("Precio") . " 4</span> <span class='badge bg-warning text-dark'>" . number_format($value['Precio4'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . $_POST["MonedaP"] . "</span> <span class='badge bg-success text-light'>" . $value["UnidadP3"] . " (" . $value["CantP3"] . ")</span></div>
												</div>
											</div>
										</div>";
				}
				$response = array(
					"status" => 1,
					"msg" => "",
					"data" => $mostrar,
					"json" => $response['data'],
				);
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
			} else {
				echo json_encode($response, JSON_UNESCAPED_UNICODE);
			}
		} else {
			echo ":(";
		}
	}

	if ($_POST["Option"] === "2") {
		$EstructuraError = array(
			"status" => -1,
			"data" => "",
			"msg" => "",
		);
		$IdCompany = $_POST["CompanyActual"];
		$query = "SELECT CodIdBasico,CodIdAmpliado,CodBarra FROM PosUpProducto WHERE IdCompany=" . $IdCompany;
		$CodIdAmpliado = array();
		$CodBarra = array();
		if ($result = mysqli_query($conn, $query)) {
			while ($row = mysqli_fetch_array($result)) {
				$CodIdAmpliado[$row["CodIdAmpliado"]] = $row["CodIdBasico"];
				$CodBarra[$row["CodBarra"]] = $row["CodIdBasico"];
			}
		}
		$response = json_decode(ProductosForJson($_POST["DataUp"], $_POST["CompanyActual"], $_POST["EsCompuesto"]), true);
		if ($response["status"] === 1) {
			if ($_POST["EsCompuesto"] == "9") {
				foreach (json_decode($_POST["DataUp"], true) as $value) {
					if (trim($CodIdAmpliado[$value["CodIdAmpliado"]]) == "" && trim($CodBarra[$value["CodBarra"]]) == "") {
						$CodIdBasico = "";
						$sql = "SELECT CodIdBasico FROM PosUpProducto WHERE IdCompany =" . $IdCompany . " and CodIdAmpliado = '" . $value["CodIdAmpliado"] . "'";
						if ($result = mysqli_query($conn, $sql)) {
							while ($row = mysqli_fetch_array($result)) {
								$CodIdBasico = $row["CodIdBasico"];
							}
						}
						if ($CodIdBasico !== "") {
							if (!file_exists('Comercio/' . $IdCompany . '/productos/')) mkdir('Comercio/' . $IdCompany . '/productos/', 0777, true);
							$img = file_get_contents($value["Imagen"]);
							$extension = pathinfo($value["Imagen"], PATHINFO_EXTENSION);
							$data2 = base64_encode($img);
							$data = base64_decode($data2);
							$nuevo_fichero = 'Comercio/' . $IdCompany . '/productos/' . $CodIdBasico . "_" . time() . '.' . $extension;
							$response = file_put_contents($nuevo_fichero, $data);
						}
					}
				}
				$EstructuraError["status"] = 1;
				$EstructuraError["msg"] = lang("Se han creado los productos");
				echo json_encode($EstructuraError, JSON_UNESCAPED_UNICODE);
			}
			if ($_POST["EsCompuesto"] == "0") {

				$token['Token'] = sha1($_POST['correo']);
				$ttx = "numcar";
				$query = "SELECT max(IdTxCompany)+1 as newIdtx from PosUpTxC where IdCompany = '" . $IdCompany . "' and idtipotx='" . $datos['Idtipotx'] . "'";
				if ($result = mysqli_query($conn, $query)) {
					while ($row = mysqli_fetch_assoc($result)) {
						$newIdtx = $row['newIdtx'];
					}
					mysqli_free_result($result);
				}
				if (trim($newIdtx) == "") {
					$newIdtx = 1;
				}

				$conn->autocommit(FALSE);
				$statementI = "insert into PosUpTxD (IdCompany, Idtipotx, Idtx, IdEstacion, Item, Fectxserver, Fectxclient, Costo, Precio, Dcto, Cant, Total, Margen, CodIdBasico, Descripcion,IdAlm,Impuesto,MontoImpuesto,Referencia,Seriales,IdCompanyUser,TxfecVence,tasa,fraccion,precioactual,Medida) values ";
				$it = 0;
				$Costo = 0;
				$Imponible = 0;
				$Exento = 0;
				$Impuesto = 0;
				$datos["Idtipotx"] = 18;
				$datos["IdEstacion"] = $_POST["TokenEstacion"];
				$datos["Fectxclient"] = $_POST["Fectxclient"];
				$datos["IdAlm"] = $_POST["IdAlm"];
				foreach (json_decode($_POST["DataUp"], true) as $value) {
					if (trim($CodIdAmpliado[$value["CodIdAmpliado"]]) == "" && trim($CodBarra[$value["CodBarra"]]) == "") {
						$CodIdBasico = "";
						$sql = "SELECT CodIdBasico FROM PosUpProducto WHERE IdCompany =" . $IdCompany . " and CodIdAmpliado = '" . $value["CodIdAmpliado"] . "'";
						if ($result = mysqli_query($conn, $sql)) {
							while ($row = mysqli_fetch_array($result)) {
								$CodIdBasico = $row["CodIdBasico"];
							}
						}
						$sql = "SELECT IdVarios FROM PosUpvarios WHERE IdCompany =" . $IdCompany . " and TIPOITEM = 0 and VALOR = '" . ($value["ValorImpuesto"] / 100) . "' and ITEM ='" . $value["NombreImpuesto"] . "'";
						if ($result = mysqli_query($conn, $sql)) {
							while ($row = mysqli_fetch_array($result)) {
								$Impuesto = $row["IdVarios"];
							}
						}
						if ($CodIdBasico !== "") {
							if (!file_exists('/Comercio/' . $IdCompany . '/productos/')) mkdir('Comercio/' . $IdCompany . '/productos/', 0777, true);
							if (trim($value["Imagen"]) !== "") {
								$img = file_get_contents($value["Imagen"]);
								$extension = pathinfo($value["Imagen"], PATHINFO_EXTENSION);
								$data2 = base64_encode($img);
								$data = base64_decode($data2);
								$nuevo_fichero = 'Comercio/' . $IdCompany . '/productos/' . $CodIdBasico . "_" . time() . '.' . $extension;
								$response = file_put_contents($nuevo_fichero, $data);
							}

							if ($value["Existencia"] > 0) {
								$ImpuestoCal = ($value["ValorImpuesto"] / 100);
								$CostoConImpuesto = $value["Costo"];

								if ($CostoConImpuesto > 0) {
									$CostoSinImpuesto = $CostoConImpuesto / (1 + $ImpuestoCal);
								} else {
									$CostoSinImpuesto = 0;
								}

								$PrecioConImpuesto = $value["Precio"];
								if ($PrecioConImpuesto > 0) {
									$PrecioSinImpuesto = $PrecioConImpuesto / (1 + $ImpuestoCal);
								} else {
									$PrecioSinImpuesto = 0;
								}

								if ($CostoSinImpuesto > 0) {
									$Margen = (($PrecioSinImpuesto - $CostoSinImpuesto) * 100) / $CostoSinImpuesto;
								} else {
									$Margen = 0;
								}
								if ($value["ValorImpuesto"] > 0) {
									$MontoImpuesto = (($PrecioConImpuesto * $value["Existencia"]) - ($PrecioSinImpuesto * $value["Existencia"]));
									$Imponible += ($PrecioSinImpuesto * $value["Existencia"]);
									$Impuesto += $MontoImpuesto;
								} else {
									$MontoImpuesto = 0;
									$Exento += ($PrecioConImpuesto * $value["Existencia"]);
								}
								$Total = ($PrecioConImpuesto * $value["Existencia"]);
								$it = $it + 1;
								$DescripcionOn = mysqli_real_escape_string($conn, $value['Descripcion']);
								$Costo += $value["Costo"];
								$statement = $statementI . "((SELECT Id FROM PosUpCompany where token='" . $token['Token'] . "'),'" . $datos['Idtipotx'] . "',(SELECT " . $ttx . "+1 FROM PosUpCompanyEstacion where token='" . $datos['IdEstacion'] . "'),'" . $datos['IdEstacion'] . "'," . $it . ",now(),'" . $datos['Fectxclient'] . "','" . $value['Costo'] . "','" . $value["Precio"] . "','0','" . $value['Existencia'] . "','" . $Total . "','" . $Margen . "','" . $CodIdBasico . "','" . $DescripcionOn . "','" . $datos['IdAlm'] . "','" . $Impuesto . "','" . $MontoImpuesto . "','','','" . $IdCompany . "','" . $datos['Fectxclient'] . "','" . $_POST["FactorDolarCash"] . "',1,'1','" . $value['Medida'] . "')";
								$resultado3 =  mysqli_query($conn, trim($statement)); // or die(mysql_error());
							}
						}
					}
				}
				if ($it > 0) {
					$statement = "insert into PosUpTxC (IdCompany, Idtipotx, Idtx, Fectxserver, Fectxclient,  IdUser, IdUserAutDcto, SubTotal, Dcto, Total, Costo, Margen, DctoAplicado, MargenDcto, Items, IdEstacion, Contado, Credito, Cobrado,IdCompanyUserAutDcto, IdCompanyUser,IdtipotxPadre, IdtxPadre, IdEstacionPadre,IdAlmO,IdAlmD,motivo,DAmpliado,IdBen,Referencia,excento,imponible,impuesto,totalimp,numctrol,TxfecVence,tasa,IdTxCompany,UserVendedor) values ((SELECT Id FROM PosUpCompany where token='" . $token['Token'] . "'),'" . $datos['Idtipotx'] . "',(SELECT " . $ttx . "+1 FROM PosUpCompanyEstacion where token='" . $datos['IdEstacion'] . "'),now(),'" . $datos['Fectxclient'] . "','" . $_POST['userlogin'] . "','','" . ($Imponible + $Exento + $Impuesto) . "',0,'" . ($Imponible + $Exento + $Impuesto) . "','" . $Costo . "','0','0','0','" . $it . "','" . $datos['IdEstacion'] . "',0,0,0,'','" . $IdCompany . "',0,0,0,'" . $datos['IdAlm'] . "','" . $datos['IdAlm'] . "','','','','','" . $Exento . "','" . $Imponible . "','" . $Impuesto . "','" . ($Imponible + $Impuesto) . "','0','" . $datos['Fectxclient'] . "','" . $_POST["FactorDolarCash"] . "','" . $newIdtx . "',0)";
					$resultado1 =  mysqli_query($conn, $statement); //or die(mysql_error());

					$statement = "update PosUpCompanyEstacion set " . $ttx . "=" . $ttx . "+1 where token='" . $datos['IdEstacion'] . "'";
					$resultado2 = mysqli_query($conn, $statement); // or die(mysql_error());
					if ($resultado1 and $resultado3 and $resultado2) {
						$conn->commit();
						$EstructuraError["status"] = 1;
						$EstructuraError["msg"] = lang("Se han creado los productos");
						echo json_encode($EstructuraError, JSON_UNESCAPED_UNICODE);
					} else {
						$conn->rollback();
						$EstructuraError["status"] = 1;
						$EstructuraError["msg"] = lang("Se han creado los productos");
						echo json_encode($EstructuraError, JSON_UNESCAPED_UNICODE);
					}
				} else {

					$conn->commit();
					$EstructuraError["status"] = 1;
					$EstructuraError["msg"] = lang("Se han creado los productos");
					echo json_encode($EstructuraError, JSON_UNESCAPED_UNICODE);
				}
			}
		} else {
			echo json_encode($response, JSON_UNESCAPED_UNICODE);
		}
	}
}

if (isset($_POST['Almacen']) && $_POST['Almacen'] == "4") {
	include "ambienteconsultas.php";
	$con = conectar();
	$conn = conectar();
	$GroupSerial = "";
	$src = "";
	if ($IdUbi <> 0) {
		$scanpath = scandir("Comercio/" . $_POST["CompanyActual"] . "/sucursal");
		foreach ($scanpath as $item) {
			if ($item != '.' and $item != '..') {
				$file_name = explode(".", $item);
				$Mbooking_number = "sucursal" . $IdUbi;
				if ($file_name[0] == $Mbooking_number) {
					$src = "Comercio/" . $_POST["CompanyActual"] . "/sucursal" . "/" . $item;
				}
			}
		}
	}
	if (trim($src) == "") {
		$directorio_escaneado = scandir("Comercio/" . $_POST["CompanyActual"] . "/entorno");
		foreach ($directorio_escaneado as $item) {
			if ($item != '.' and $item != '..') {
				$nnn = preg_split('/_/', $item);
				$Mbooking_number = "Logotipo";
				if ($nnn[0] == $Mbooking_number) {
					$src = "Comercio/" . $_POST["CompanyActual"] . "/entorno" . "/" . $item;
				}
			}
		}
	}
	if (trim($src) == "") {
		$src = "img/ISO_AMARILLO.svg";
	}
	include "barcode/vendor/autoload.php";
	$IdAlmGroup = [];
	if (trim($_POST["IdAlmGroup"]) !== "") {
		$IdAlmGroup = explode(",", trim($_POST["IdAlmGroup"]));
	}

	if (trim($_POST["VerStock"]) === "0") {
		$HavingData = "HAVING Cantidad > 0";
	} else if (trim($_POST["VerStock"]) === "1" && $_POST["sucursal"] !== "0") {
		$HavingData = " HAVING Cantidad > 0 AND c.IdUbi = " . $_POST["sucursal"] . " " . (!empty($IdAlmGroup) ? " or c.IdAlm in ('" . implode("','", $IdAlmGroup) . "')" : "");
	} else if (trim($_POST["VerStock"]) === "3") {
		$HavingData = " HAVING Cantidad > 0 AND c.IdAlm in ('" . implode("','", $IdAlmGroup) . "')";
	} else if (trim($_POST["VerStock"]) === "2") {
		$HavingData = " HAVING Cantidad > 0 AND c.IdAlm = " . $_POST["IdAlmVtaSeleccionada"] . " " . (!empty($IdAlmGroup) ? " or c.IdAlm in ('" . implode("','", $IdAlmGroup) . "')" : "");
	} else if (intval($_POST["VerStock"]) >= 100) {
		$HavingData = " HAVING Cantidad > 0 AND c.IdAtt = " . (intval($_POST["VerStock"]) / 100) . " " . (!empty($IdAlmGroup) ? " or c.IdAlm in ('" . implode("','", $IdAlmGroup) . "')" : "");
	}


	$query3 = "select
	c.nombre as Almacen,
	c.IdAlm,
	round(sum(coalesce(a.Cant)* coalesce(d.Inventario)), 3) as Cantidad,
	c.IdAtt,
	c.IdUbi 
	from
		PosUpTxD a
	inner join PosUpProducto b on
		a.IdCompany = b.IdCompany
		and a.CodIdBasico = b.CodIdBasico
	inner join PosUpAlmacen c on
		a.IdCompany = c.IdCompany
		and a.IdAlm = c.IdAlm
	inner join PosUpTx d on
		a.Idtipotx = d.Idtipotx
	where
		a.IdCompany = " . $_POST["CompanyActual"] . " 
		and b.CodIdBasico = " . $_POST["Id"] . " 
		and a.seriales <> '' 
	group by 
		b.CodIdBasico,
		c.IdAlm 
	" . $HavingData;
	$response = "";
	$n = 0;
	$n2 = 0;
	if ($result3 = mysqli_query($conn, $query3)) {
		while ($row3 = mysqli_fetch_assoc($result3)) {
			$response .= "
					<div class='col-12 fw-bold'>" . $row3["Almacen"] . " <span class='badge bg-success text-light'>" . getcantformat($row3["Cantidad"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . "</span> </div>
					<div class='row'>
				";
			$query2 = "select c.nombre as Almacen,a.seriales,round(sum(coalesce(a.Cant)*coalesce(d.Inventario)),3) as Cantidad,e.IDVariacion,e.VALOR,e.pathimg as icono
				,b.CodIdAmpliado,b.descripcion,b.Medida,COALESCE(x.valor1,b.alto) as valor1,COALESCE(x.valor2,b.ancho) as valor2,COALESCE(x.valor3,b.factorunit) as valor3,cxd.Comercio
				from PosUpTxD a 
				left join PosUpProducto b on a.IdCompany=b.IdCompany and a.CodIdBasico=b.CodIdBasico 
				left join PosUpAlmacen c on a.IdCompany=c.IdCompany and a.IdAlm=c.IdAlm 
				left join PosUpTx d on a.Idtipotx=d.Idtipotx 
				left join posupproductoserial x on a.IdCompany=x.idcompany and a.CodIdBasico=x.CodIdBasico and a.seriales=x.seriales 
	LEFT JOIN PosUpCompany cxd on cxd.Id = a.IdCompany
				left join  ( select  e.Serial,e.IdCompany,e.IDVariacion,e.VALOR,f.pathimg FROM PosUpProductoVar e
				left join PosUpvarios f on e.IdCompany=f.IdCompany and e.TipoVariacion=f.esserial  and TIPOITEM=1001
				where e.IdCompany = " . $_POST["CompanyActual"] . ") e ON a.IdCompany=e.IdCompany and a.Seriales=e.Serial
				where a.IdCompany = " . $_POST["CompanyActual"] . " and b.CodIdBasico ='" . $_POST["Id"] . "' and c.IdAlm = " . $row3["IdAlm"] . " and a.seriales <> '' group by b.CodIdBasico,a.seriales,c.IdAlm HAVING Cantidad>0";
			if ($result2 = mysqli_query($conn, $query2)) {
				while ($row2 = mysqli_fetch_assoc($result2)) {
					$n = $n + 1;
					$n3 = $n3 + 1;
					if ($_POST["CompanyActual"] == "1094") {
						$ImprimirDecidible = "";
						$barcode = new \Com\Tecnick\Barcode\Barcode();
						$bobj = $barcode->getBarcodeObj(
							"C39",
							$row2["seriales"],
							-2,
							-100,
							'black',
							array(0, 0, 0, 0)
						);
						$imageData = $bobj->getPngData();
						$IMGH = base64_encode($imageData);
						$name = "CodigoAutoSerial" . $row2["seriales"];
						$name2 = "SerialAutoSerial" . $row2["seriales"];
						$name3 = "ButtonSerialAutoSerial" . $row2["seriales"];
						$name4 = "ButtonSerialAutoSerialx" . $row2["seriales"];
						$Imprimible = "
							<div style='width:8.7cm; height:1in;'>
								<div style='width:30%; float:left; padding-right: 0.2cm; padding-left: 0.2cm;'>
									<img src='" . $src . "'  style='width:100%;' >
								</div>
								<div style='width:70%; float:left; padding-right: 0.2cm; line-height: 1.2;'>
									<div style='width:100%; font-size: 15px;'><strong>" . $row2["descripcion"] . "</strong></div>
									<div style='width:100%; font-size: 13px;'>
										<span ><strong>" . $row2["CodIdAmpliado"] . "</strong></span>
										<span style='text-align:right; '>" . $row2["valor1"] . " x " . $row2["valor2"] . " = " . $row2["valor3"] . " " . $row2['Medida'] . "</span>
									</div>
									<div style='width: 100%;  font-size: 13px;'>
										<img  style='width:100%;height:0.8cm;  padding-right:2px;' class='img-fluid text-center' src='data:image/png;base64," . $IMGH . "'  alt='Alternative Text'> <br> 
									</div>
									<div style='width: 100%; text-align: center;  font-size: 13px;' id='" . $name2 . "'>
										" . $row2["seriales"] . "
									</div>
								</div>
							</div>
							";
						$ImprimirDecidible .= "<span style='display:none;'><div style='width:100%; float:left;'><div id='" . $name . "' style='padding: 1px 1px 1px 3px; width:10cm; height:2cm; '>" . $Imprimible . "</div></div></span>";
						$GroupSerial .= "<span ><div style='width:100%; float:left;'><div style='padding: 1px 1px 1px 3px; width:10cm; height:2cm; '>" . $Imprimible . "</div></div></span>";
						echo $ImprimirDecidible;
					} else 	if ($_POST["CompanyActual"] == "1181" || $_POST["CompanyActual"] == "133") {
						$ImprimirDecidible = "";
						$barcode = new \Com\Tecnick\Barcode\Barcode();
						$bobj = $barcode->getBarcodeObj(
							"C39",
							$row2["seriales"],
							-2,
							-80,
							'black',
							array(0, 0, 0, 0)
						);
						$imageData = $bobj->getPngData();
						$IMGH = base64_encode($imageData);
						$name = "CodigoAutoSerial" . $row2["seriales"];
						$name2 = "SerialAutoSerial" . $row2["seriales"];
						$name3 = "ButtonSerialAutoSerial" . $row2["seriales"];
						$name4 = "ButtonSerialAutoSerialx" . $row2["seriales"];
						$Imprimible = "
							<div id='" . $name . "'  style='display:none;'>
								<div style='width:60%; line-height: 15.1px;'>
									<div style='font-size: 12px; width:100%; text-align:center;'><strong>" . $row2["Comercio"] . "</strong></div>
									<div><img style='width:100%;  ' class='img-fluid text-center' src='data:image/png;base64," . $IMGH . "'  alt='Alternative Text'/></div>
									<div style='font-size: 14px; width:100%; text-align:center' id='" . $name2 . "'>
										" . $row2["seriales"] . "
									</div>
									<div style='font-size: 20px; width:100%; text-align:center'><strong>" . $row2["descripcion"] . "</strong></div>
								</div>
							</div>
						";

						$ImprimirDecidible .= $Imprimible;
						$GroupSerial .= "<span ><div style='width:100%; float:left;'><div style='padding: 1px 1px 1px 3px; width:10cm; height:2cm; '>" . $Imprimible . "</div></div></span>";
						echo $ImprimirDecidible;
					}
					$pathim = "";
					$query222 = "SELECT f.ITEM,e.VALOR,f.pathimg,c.nombre as Almacen,a.seriales,e.IdVariacion , g.ITEM,g.IdVarios,g.pathimg as icono ,g.esserial as serialito
						from PosUpTxD a 
						inner join PosUpProducto b on a.IdCompany=b.IdCompany and a.CodIdBasico=b.CodIdBasico 
						inner join PosUpAlmacen c on a.IdCompany=c.IdCompany and a.IdAlm=c.IdAlm 
						inner join PosUpTx d on a.Idtipotx=d.Idtipotx 
						inner join PosUpProductoVar e on a.IdCompany=e.IdCompany and a.CodIdBasico = e.CodIdBasico and a.seriales=e.Serial 
						inner join PosUpvarios f on a.IdCompany=f.IdCompany and f.IdVarios=e.IDVariacion and f.TIPOITEM=1002 
						LEFT join PosUpvarios g on f.IdCompany=g.IdCompany and f.esserial=g.esserial and g.TIPOITEM=1001 
						where a.IdCompany =" . $_POST["CompanyActual"] . " and a.CodIdBasico = '" . $_POST["Id"] . "' 
						and a.IdAlm = " . $row3["IdAlm"] . " and a.seriales = '" . $row2["seriales"] . "' 
						group by a.CodIdBasico,a.seriales,e.TipoVariacion Order by g.ITEM ";

					if ($result222 = mysqli_query($conn, $query222)) {

						while ($row222 = mysqli_fetch_assoc($result222)) {
							$pathim .= "<i style='color:" . $row222["pathimg"] . "' class='" . $row222["icono"] . " fa-1x' name='busca'> </i>";
						}
						mysqli_free_result($result222);
					}

					$loginseri = "";


					$query22 = "SELECT f.ITEM,e.VALOR,f.pathimg,c.nombre as Almacen,a.seriales,e.IdVariacion , g.ITEM,g.IdVarios,g.pathimg as icono ,g.esserial as serialito
						from PosUpTxD a 
						inner join PosUpProducto b on a.IdCompany=b.IdCompany and a.CodIdBasico=b.CodIdBasico 
						inner join PosUpAlmacen c on a.IdCompany=c.IdCompany and a.IdAlm=c.IdAlm 
						inner join PosUpTx d on a.Idtipotx=d.Idtipotx 
						inner join PosUpProductoVar e on a.IdCompany=e.IdCompany and a.CodIdBasico = e.CodIdBasico and a.seriales=e.Serial 
						inner join PosUpvarios f on a.IdCompany=f.IdCompany and f.IdVarios=e.IDVariacion and f.TIPOITEM=1002 
						LEFT join PosUpvarios g on f.IdCompany=g.IdCompany and f.esserial=g.esserial and g.TIPOITEM=1001 
						where a.IdCompany =" . $_POST["CompanyActual"] . " and a.CodIdBasico = '" . $_POST["Id"] . "' 
						and a.IdAlm = " . $row3["IdAlm"] . " and a.seriales = '" . $row2["seriales"] . "' 
						group by a.CodIdBasico,a.seriales,e.TipoVariacion Order by g.ITEM ";
					if ($result22 = mysqli_query($conn, $query22)) {

						while ($row22 = mysqli_fetch_assoc($result22)) {
							$n2 = $n2 + 1;
							$loginseri .= "

									<span name='login" . $n2 . "' value='" . $row22["IdVariacion"] . "'>" . $row22["IdVariacion"] . "</span>
									<span name='serialito" . $n2 . "' value='" . $row22["serialito"] . "'>" . $row22["serialito"] . "</span>
								";
						}
						mysqli_free_result($result22);
					}



					$response .= '
						<div class="col-6 col-lg-4">
							<div>
								<button class="btn btn-outline-dark p-1" data-bs-dismiss="modal" title="' . lang('Histórico de Serial') . '" onclick="BuscarHistorico(`' . $row2['seriales'] . '`)"><i class="fa fa-eye"></i>	</button>
								<button class="btn btn-outline-dark p-1" type="button" id="' . $name3 . '" title="' . lang("Imprimir") . '" onclick="ImprimirAutoSerial(`' . $row2["seriales"] . '`,`' . $name2 . '`)"> <i class="fa fa-print"></i> </button>
								<span type="button" style="display:none" class="col-xs-3 text-left " id="sr' . $n . '" name="busca" >' . $row2["seriales"] . '</span>
								<button class="btn btn-outline-warning p-1 m-1" type="button" title="' . lang("Imagen del Producto") . '" onclick="recibir6(`' . $row2["seriales"] . '`,`' . $_POST["Id"] . '`);"><span class="fa fa-image"></span></button>
								' . ($_POST['permiso'] == 1 ? '<button class="btn btn-outline-secondary fa fa-edit fa-1x p-1" name="busca" value="" onclick="modalvaria(' . $n . ')"></button>' : '') . '
								' . $row2["seriales"] . ' 		
								<button type="button" style="display:none; font-weight: bold;" class="col-xs-3 text-left" id="id' . $n . '" name="busca" onclick="modalvaria(' . $n . ')">' . ($row2["IdVariacion"] == '' ? '0' : $row2["IdVariacion"]) . '</button>
								<button type="button" style="display:none; font-weight: bold;" class="col-xs-3 text-left" id="descriptura' . $n . '" name="busca" value="" onclick="modalvaria(' . $n . ')">' . ($row2["ITEM"] == '' ? '' : $row2["ITEM"]) . '	</button>
								<button type="button" style="display:none; font-weight: bold;" class="col-xs-3 text-left" id="valorado' . $n . '" name="valorado" value="' . $row2["VALOR"] . '" onclick="modalvaria(' . $n . ')"> ' . $row2["VALOR"] . ' </button>
								' . $pathim . '
							</div>
							<div>
								' . ($_POST["CompanyActual"] === "1094" ? '(' . $row2["valor1"] . " x " . $row2["valor2"] . " = " . $row2["valor3"] . " " . $row2['Medida'] . ')' : '') . '
							</div>
							<div class="user-panel main' . $n . '" style="display:none;">
								' . $loginseri . '
							</div>

							<button type="button" style="display:none; font-weight: bold;" id="contador' . $n . '" name="contador" value="' . $n2 . '"> ' . $n2 . ' </button>
							<span style="display:none" id="AltoDatax' . $n . '">' . $row2["valor1"] . '</span>
							<span style="display:none" id="AnchoDatax' . $n . '">' . $row2["valor2"] . '</span>
							<span style="display:none" id="AreaDatax' . $n . '">' . $row2["valor3"] . '</span>
						</div>
						';



					$n2 = 0;
				}
				mysqli_free_result($result2);
			}
			$response .= "</div><div id='ImprimirTodoList' style='display:none;'>" . $GroupSerial . "</div>";
		}
	}
	echo $response;
}
if (isset($_POST['Almacen']) && $_POST['Almacen'] == "4x4") {
	include "ambienteconsultas.php";
	$conn = conectar();

	$sql = 'SELECT p.nombre as Almacen,sum(il.qty_on_hand) totalStockAlmacen,GROUP_CONCAT(concat(lote,",",vence,",",il.qty_on_hand) ' . "SEPARATOR ';'" . ') as detail FROM posup.inv_lotes AS il
inner join posupalmacen p on p.IdCompany = il.idcompany and p.IdAlm = il.idalmacen 
WHERE il.idcompany = ' . $_POST["CompanyActual"] . ' and il.idproducto = ' . $_POST["CodIdBasico"] . '
and il.qty_on_hand > 0
group by il.idcompany,il.idalmacen
			';

	if ($result = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($result)) {
			echo "	<div class='col-12 fw-bold'>" . $row["Almacen"] . " <span class='badge bg-warning text-dark'>" . getcantformat($row["totalStockAlmacen"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $_POST["Medida"] . '' . "</span> </div>
					<div class='row'>
					";
			$lotes = explode(";", $row["detail"]);
			foreach ($lotes as $lote) {
				$lot = explode(",", $lote);
				$loteN = $lot[0];
				$vence = $lot[1];
				$qty_on_hand = $lot[2];

				echo '
			<div class="col-12">
							<div>
								<span class="badge bg-primary text-light">' . $loteN . ' / ' . $vence . '</span>
								<span class="badge bg-warning text-dark">' . getcantformat($qty_on_hand, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . ' ' . $_POST["Medida"] . '</span>
							</div>

						</div>';
			}
		}
		// <span class="badge bg-danger text-light">' . $row['unit_cost'] * $row["qty"] . ' </span>
	}
}


if (isset($_POST['Accion']) && $_POST['Accion'] === "CambiarUbicacion") {
	include "ambienteconsultas.php";
	$con = conectar();
	$conn = conectar();
	echo CambiarUbicacion($conn, $_POST);
}

if (isset($_POST['Accion']) && $_POST['Accion'] === "EstadisticaProducto") {
	include "ambienteconsultas.php";
	$con = conectar();
	$conn = conectar();
	echo EstadisticaProducto($conn, $_POST);
}

function EstadisticaProducto($conn, $post)
{

	$search = "";

	$search .= " and a.Fectxclient >= '" . $post["Desde"] . "'";
	$search .= " and a.Fectxclient < '" . $post["Hasta"] . "'";

	$sql = "SELECT sum(a.Cant * b.Inventario) as Cant, if(if(c.Idtipotx in (1,2,3,4,5,6,11,12,13,15,21,22,23,24,25,26,31,35,36,37),ee.NumTxViewVTA,if(c.Idtipotx in (7,14,20,27,28),ee.NumTxViewCOM,if(c.Idtipotx in (8,9,10,16,17,18,19,29,30,32,33,34,39),ee.NumTxViewINV,''))) = 0,c.IdtxCompany,if(if(c.Idtipotx in (1,2,3,4,5,6,11,12,13,15,21,22,23,24,25,26,31,35,36,37),ee.NumTxViewVTA,if(c.Idtipotx in (7,14,20,27,28),ee.NumTxViewCOM,if(a.Idtipotx in (8,9,10,16,17,18,19,29,30,32,33,34,39),ee.NumTxViewINV,''))) = 1,c.Idtx,c.Referencia)) as IdtxDef,e.etiqueta,d.Nombre as Cliente,c.Total,DATE_FORMAT(a.Fectxclient,'%d/%m/%Y %h:%i:%s %p') as Fecha,c.Referencia,a.Medida
			from PosUpTxD a
			left join PosUpTx b on b.Idtipotx = a.Idtipotx
			left join PosUpTxC c on c.Idtipotx = a.Idtipotx and c.Idtx = a.Idtx and c.IdEstacion = a.IdEstacion and c.IdCompany = a.IdCompany
			left join PosUpclientes d on c.IdBen = d.rut and c.Idcompany=d.Idcompany 
			left join PosUpCompanyEstacion e on a.IdEstacion=e.token and a.IdCompany=e.IdCompany 
			left join PosUpCompany ee on ee.Id=a.IdCompany
			where a.IdCompany=" . $post["CompanyActual"] . " and a.CodIdBasico = '" . $post["CodIdBasico"] . "' and a.Idtipotx in (7) " . $search . "
			GROUP BY a.Idtipotx,a.Idtx,a.IdEstacion,a.IdCompany
			ORDER BY a.Fectxclient desc";
	$buy = [];
	if ($result = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$buy[] = $row;
		}
	}

	$sql = "SELECT sum(a.Cant * b.Inventario) as Cant, if(if(c.Idtipotx in (1,2,3,4,5,6,11,12,13,15,21,22,23,24,25,26,31,35,36,37),ee.NumTxViewVTA,if(c.Idtipotx in (7,14,20,27,28),ee.NumTxViewCOM,if(c.Idtipotx in (8,9,10,16,17,18,19,29,30,32,33,34,39),ee.NumTxViewINV,''))) = 0,c.IdtxCompany,if(if(c.Idtipotx in (1,2,3,4,5,6,11,12,13,15,21,22,23,24,25,26,31,35,36,37),ee.NumTxViewVTA,if(c.Idtipotx in (7,14,20,27,28),ee.NumTxViewCOM,if(a.Idtipotx in (8,9,10,16,17,18,19,29,30,32,33,34,39),ee.NumTxViewINV,''))) = 1,c.Idtx,c.Referencia)) as IdtxDef,e.etiqueta,d.Nombre as Cliente,c.Total,DATE_FORMAT(a.Fectxclient,'%d/%m/%Y %h:%i:%s %p') as Fecha,c.Referencia,a.Medida
			from PosUpTxD a
			left join PosUpTx b on b.Idtipotx = a.Idtipotx
			left join PosUpTxC c on c.Idtipotx = a.Idtipotx and c.Idtx = a.Idtx and c.IdEstacion = a.IdEstacion and c.IdCompany = a.IdCompany
			left join PosUpclientes d on c.IdBen = d.rut and c.Idcompany=d.Idcompany 
			left join PosUpCompanyEstacion e on a.IdEstacion=e.token and a.IdCompany=e.IdCompany 
			left join PosUpCompany ee on ee.Id=a.IdCompany
			where a.IdCompany=" . $post["CompanyActual"] . " and a.CodIdBasico = '" . $post["CodIdBasico"] . "' and a.Idtipotx in (1,2) " . $search . "
			GROUP BY a.Idtipotx,a.Idtx,a.IdEstacion,a.IdCompany
			ORDER BY a.Fectxclient desc";
	$sell = [];
	if ($result = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$sell[] = $row;
		}
	}
	//$CanPags = (intval($cantReg / 6) + ((($cantReg / 6) - intval($cantReg / 6)) > 0 ? 1 : 0) <= 0 ? 1 : intval($cantReg / 6) + ((($cantReg / 6) - intval($cantReg / 6)) > 0 ? 1 : 0));

	return json_encode([
		"sell" => $sell,
		"buy" => $buy,
	], JSON_UNESCAPED_UNICODE);
}

function CambiarUbicacion($conn, $post)
{

	$search = "";
	$search .= ($post["IdUbi"] !== "*" ? " and IdUbi=" . $post["IdUbi"] : "");

	$SelectorAlmacen = "";
	$query = "SELECT IdAlm,Nombre FROM PosUpAlmacen WHERE IdCompany=" . $post["CompanyActual"] . $search;

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
				<label><i class='fa fa-archive'></i> " . lang("Almacen") . "</label>
			";
	return $response;
}

function ExcelToJson($File, $IdCompany, $EsCompuesto)
{
	$EstructuraError = array(
		"status" => -1,
		"data" => "",
		"msg" => "",
	);


	$path = "Comercio/" . $IdCompany . "/temp";
	if (!file_exists($path)) {
		mkdir($path, 0777, true);
	}
	if (file_exists($path . "/" . $File['name'])) {
		unlink($path . "/" . $File['name']);
	}
	if (move_uploaded_file($File['tmp_name'], $path . "/" . $File['name'])) {
		require_once 'PHPExcel/Classes/PHPExcel.php';
		$inputFileType = PHPExcel_IOFactory::identify($path . "/" . $File['name']);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objPHPExcel = $objReader->load($path . "/" . $File['name']);
		$sheet = $objPHPExcel->getSheet(0);
		$highestRow = $sheet->getHighestRow();
		//$highestColumn = $sheet->getHighestColumn();
		$rawdata = array();
		for ($row = 2; $row <= $highestRow; $row++) {
			if ($sheet->getCell("A" . $row)->getFormattedValue() <> "") {
				$CodBarra = $sheet->getCell("A" . $row)->getFormattedValue();
				$CodIdAmpliado = $sheet->getCell("B" . $row)->getFormattedValue();
				$Descripcion = $sheet->getCell("C" . $row)->getFormattedValue();
				$Medida = $sheet->getCell("D" . $row)->getFormattedValue();
				$NombreImpuesto = $sheet->getCell("E" . $row)->getFormattedValue();
				$ValorImpuesto = $sheet->getCell("F" . $row)->getFormattedValue();
				$Costo = $sheet->getCell("G" . $row)->getFormattedValue();
				$Precio = $sheet->getCell("H" . $row)->getFormattedValue();
				$Idfamilia = $sheet->getCell("I" . $row)->getFormattedValue();
				$Marca = $sheet->getCell("J" . $row)->getFormattedValue();
				$PorKilo = $sheet->getCell("K" . $row)->getFormattedValue();
				$Imagen = $sheet->getCell("L" . $row)->getFormattedValue();
				$Precio2 = $sheet->getCell("M" . $row)->getFormattedValue();
				$Precio3 = $sheet->getCell("N" . $row)->getFormattedValue();
				$Precio4 = $sheet->getCell("O" . $row)->getFormattedValue();
				$UnidadP1 = $sheet->getCell("P" . $row)->getFormattedValue();
				$CantP1 = $sheet->getCell("Q" . $row)->getFormattedValue();
				$UnidadP2 = $sheet->getCell("R" . $row)->getFormattedValue();
				$CantP2 = $sheet->getCell("S" . $row)->getFormattedValue();
				$UnidadP3 = $sheet->getCell("T" . $row)->getFormattedValue();
				$CantP3 = $sheet->getCell("U" . $row)->getFormattedValue();
				$Existencia = $sheet->getCell("V" . $row)->getFormattedValue();

				$ValorImpuesto = intval($ValorImpuesto);
				$Costo = doubleval($Costo);
				$Precio = doubleval($Precio);
				$Precio2 = doubleval($Precio2);
				$Precio3 = doubleval($Precio3);
				$Precio4 = doubleval($Precio4);
				$CantP1 = intval($CantP1);
				$CantP2 = intval($CantP2);
				$CantP3 = intval($CantP3);
				$Existencia = doubleval($Existencia);
				if ($EsCompuesto == "9") $Existencia = 0;


				if ($CodBarra == "") {
					$EstructuraError["msg"] = lang("La columna") . " A " . lang("Linea") . " " . $row . " " . lang("No detecta los datos del campo de") . " " . lang("Código de Barras");
					$EstructuraError["status"] = 0;
					break;
				}
				if (!is_string($CodBarra)) {
					$EstructuraError["msg"] = lang("La columna") . " A " . lang("Linea") . " " . $row . " " . lang("detecta que no es tipo alfanumerico") . " " . lang("Código de Barras");
					$EstructuraError["status"] = 0;
					break;
				}
				if (strlen($CodBarra) > 500) {
					$EstructuraError["msg"] = lang("La columna") . " A " . lang("Linea") . " " . $row . " " . lang("detecta que supera la cantidad maxima de") . " 500 " . lang("caracteres") . " " . lang("Código de Barras");
					$EstructuraError["status"] = 0;
					break;
				}

				if ($CodIdAmpliado == "") {
					$EstructuraError["msg"] = lang("La columna") . " B " . lang("Linea") . " " . $row . " " . lang("No detecta los datos del campo de") . " " . lang("SKU");
					$EstructuraError["status"] = 0;
					break;
				}

				if (!is_string($CodIdAmpliado)) {
					$EstructuraError["msg"] = lang("La columna") . " B " . lang("Linea") . " " . $row . " " . lang("detecta que no es tipo alfanumerico") . " " . lang("SKU");
					$EstructuraError["status"] = 0;
					break;
				}

				if (strlen($CodIdAmpliado) > 100) {
					$EstructuraError["msg"] = lang("La columna") . " B " . lang("Linea") . " " . $row . " " . lang("detecta que supera la cantidad maxima de") . " 100 " . lang("caracteres") . " " . lang("SKU");
					$EstructuraError["status"] = 0;
					break;
				}

				if ($Descripcion == "") {
					$EstructuraError["msg"] = lang("La columna") . " C " . lang("Linea") . " " . $row . " " . lang("No detecta los datos del campo de") . " " . lang("Descripción");
					$EstructuraError["status"] = 0;
					break;
				}

				if (!is_string($Descripcion)) {
					$EstructuraError["msg"] = lang("La columna") . " C " . lang("Linea") . " " . $row . " " . lang("detecta que no es tipo alfanumerico") . " " . lang("Descripción");
					$EstructuraError["status"] = 0;
					break;
				}

				if (strlen($Descripcion) > 200) {
					$EstructuraError["msg"] = lang("La columna") . " C " . lang("Linea") . " " . $row . " " . lang("detecta que supera la cantidad maxima de") . " 200 " . lang("caracteres") . " " . lang("Descripción");
					$EstructuraError["status"] = 0;
					break;
				}

				if ($Medida == "") {
					$EstructuraError["msg"] = lang("La columna") . " D " . lang("Linea") . " " . $row . " " . lang("No detecta los datos del campo de") . " " . lang("Medida");
					$EstructuraError["status"] = 0;
					break;
				}

				if (!is_string($Medida)) {
					$EstructuraError["msg"] = lang("La columna") . " D " . lang("Linea") . " " . $row . " " . lang("detecta que no es tipo alfanumerico") . " " . lang("Medida");
					$EstructuraError["status"] = 0;
					break;
				}

				if (strlen($Medida) > 10) {
					$EstructuraError["msg"] = lang("La columna") . " D " . lang("Linea") . " " . $row . " " . lang("detecta que supera la cantidad maxima de") . " 10 " . lang("caracteres") . " " . lang("Medida");
					$EstructuraError["status"] = 0;
					break;
				}

				if ($NombreImpuesto == "") {
					$EstructuraError["msg"] = lang("La columna") . " E " . lang("Linea") . " " . $row . " " . lang("No detecta los datos del campo de") . " " . lang("Nombre del Impuesto");
					$EstructuraError["status"] = 0;
					break;
				}

				if (!is_string($NombreImpuesto)) {
					$EstructuraError["msg"] = lang("La columna") . " E " . lang("Linea") . " " . $row . " " . lang("detecta que no es tipo alfanumerico") . " " . lang("Nombre del Impuesto");
					$EstructuraError["status"] = 0;
					break;
				}

				if (strlen($NombreImpuesto) > 100) {
					$EstructuraError["msg"] = lang("La columna") . " E " . lang("Linea") . " " . $row . " " . lang("detecta que supera la cantidad maxima de") . " 100 " . lang("caracteres") . " " . lang("Nombre del Impuesto");
					$EstructuraError["status"] = 0;
					break;
				}

				if ($ValorImpuesto == "") {
					$ValorImpuesto = 0;
					/*
							$EstructuraError["msg"] = lang("La columna") . " F " . lang("Linea") . " " . $row . " " . lang("No detecta los datos del campo de") . " " . lang("Porcentaje del Impuesto");
							$EstructuraError["status"] = 0;
							break;
						*/
				}

				if (!is_numeric($ValorImpuesto)) {
					$EstructuraError["msg"] = lang("La columna") . " F " . lang("Linea") . " " . $row . " " . lang("detecta que no es tipo numerico") . " " . lang("Porcentaje del Impuesto") . " " . $ValorImpuesto;
					$EstructuraError["status"] = 0;
					break;
				}

				if ($Costo == "") {
					$Costo = 0;
					/*
							$EstructuraError["msg"] = lang("La columna") . " G " . lang("Linea") . " " . $row . " " . lang("No detecta los datos del campo de") . " " . lang("Costo");
							$EstructuraError["status"] = 0;
							break;
						*/
				}

				if (!is_numeric($Costo)) {
					$EstructuraError["msg"] = lang("La columna") . " G " . lang("Linea") . " " . $row . " " . lang("detecta que no es tipo numerico") . " " . lang("Costo");
					$EstructuraError["status"] = 0;
					break;
				}

				if ($Precio == "") {
					$Precio = 0;
					/*
							$EstructuraError["msg"] = lang("La columna") . " H " . lang("Linea") . " " . $row . " " . lang("No detecta los datos del campo de") . " " . lang("Precio");
							$EstructuraError["status"] = 0;
							break;
						*/
				}

				if (!is_numeric($Precio)) {
					$EstructuraError["msg"] = lang("La columna") . " H " . lang("Linea") . " " . $row . " " . lang("detecta que no es tipo numerico") . " " . lang("Precio");
					$EstructuraError["status"] = 0;
					break;
				}

				if ($Idfamilia == "") {
					$EstructuraError["msg"] = lang("La columna") . " I " . lang("Linea") . " " . $row . " " . lang("No detecta los datos del campo de") . " " . lang("Familia");
					$EstructuraError["status"] = 0;
					break;
				}

				if (!is_string($Idfamilia)) {
					$EstructuraError["msg"] = lang("La columna") . " I " . lang("Linea") . " " . $row . " " . lang("detecta que no es tipo alfanumerico") . " " . lang("Idfamilia");
					$EstructuraError["status"] = 0;
					break;
				}

				if (strlen($Idfamilia) > 100) {
					$EstructuraError["msg"] = lang("La columna") . " I " . lang("Linea") . " " . $row . " " . lang("detecta que supera la cantidad maxima de") . " 100 " . lang("caracteres") . " " . lang("Idfamilia");
					$EstructuraError["status"] = 0;
					break;
				}

				if ($Marca == "") {
					$EstructuraError["msg"] = lang("La columna") . " J " . lang("Linea") . " " . $row . " " . lang("No detecta los datos del campo de") . " " . lang("Marca");
					$EstructuraError["status"] = 0;
					break;
				}

				if (!is_string($Marca)) {
					$EstructuraError["msg"] = lang("La columna") . " J " . lang("Linea") . " " . $row . " " . lang("detecta que no es tipo alfanumerico") . " " . lang("Marca");
					$EstructuraError["status"] = 0;
					break;
				}

				if (strlen($Marca) > 100) {
					$EstructuraError["msg"] = lang("La columna") . " J " . lang("Linea") . " " . $row . " " . lang("detecta que supera la cantidad maxima de") . " 100 " . lang("caracteres") . " " . lang("Marca");
					$EstructuraError["status"] = 0;
					break;
				}

				if ($PorKilo == "") {
					$EstructuraError["msg"] = lang("La columna") . " K " . lang("Linea") . " " . $row . " " . lang("No detecta los datos del campo de") . " " . lang("PorKilo");
					$EstructuraError["status"] = 0;
					break;
				}

				if ($PorKilo === 1 or $PorKilo === 0) {
					$EstructuraError["msg"] = lang("La columna") . " K " . lang("Linea") . " " . $row . " " . lang("Debe ser solo 1 o 0") . " " . lang("PorKilo");
					$EstructuraError["status"] = 0;
					break;
				}

				if ($Precio2 == "") {
					$Precio2 = 0;
				}

				if (!is_numeric($Precio2)) {
					$EstructuraError["msg"] = lang("La columna") . " M " . lang("Linea") . " " . $row . " " . lang("detecta que no es tipo numerico") . " " . lang("Precio") . " 2";
					$EstructuraError["status"] = 0;
					break;
				}

				if ($Precio3 == "") {
					$Precio3 = 0;
				}

				if (!is_numeric($Precio3)) {
					$EstructuraError["msg"] = lang("La columna") . " N " . lang("Linea") . " " . $row . " " . lang("detecta que no es tipo numerico") . " " . lang("Precio") . " 3";
					$EstructuraError["status"] = 0;
					break;
				}

				if ($Precio4 == "") {
					$Precio4 = 0;
				}

				if (!is_numeric($Precio4)) {
					$EstructuraError["msg"] = lang("La columna") . " O " . lang("Linea") . " " . $row . " " . lang("detecta que no es tipo numerico") . " " . lang("Precio") . " 4";
					$EstructuraError["status"] = 0;
					break;
				}

				if ($CantP1 == "") {
					$CantP1 = 0;
				}

				if (!is_numeric($CantP1)) {
					$EstructuraError["msg"] = lang("La columna") . " Q " . lang("Linea") . " " . $row . " " . lang("detecta que no es tipo numerico") . " " . lang("Cantidad de la Medida") . " 2";
					$EstructuraError["status"] = 0;
					break;
				}

				if ($CantP1 <= 0) {
					$EstructuraError["msg"] = lang("La columna") . " Q " . lang("Linea") . " " . $row . " " . lang("el numero tiene que ser mayor a cero") . " (0) " . lang("Cantidad de la Medida") . " 2";
					$EstructuraError["status"] = 0;
					break;
				}

				if ($CantP2 == "") {
					$CantP2 = 0;
				}

				if (!is_numeric($CantP2)) {
					$EstructuraError["msg"] = lang("La columna") . " S " . lang("Linea") . " " . $row . " " . lang("detecta que no es tipo numerico") . " " . lang("Cantidad de la Medida") . " 3";
					$EstructuraError["status"] = 0;
					break;
				}

				if ($CantP2 <= 0) {
					$EstructuraError["msg"] = lang("La columna") . " S " . lang("Linea") . " " . $row . " " . lang("el numero tiene que ser mayor a cero") . " (0) " . lang("Cantidad de la Medida") . " 3";
					$EstructuraError["status"] = 0;
					break;
				}

				if ($CantP3 == "") {
					$CantP3 = 0;
				}

				if (!is_numeric($CantP3)) {
					$EstructuraError["msg"] = lang("La columna") . " U " . lang("Linea") . " " . $row . " " . lang("detecta que no es tipo numerico") . " " . lang("Cantidad de la Medida") . " 4";
					$EstructuraError["status"] = 0;
					break;
				}

				if ($CantP3 <= 0) {
					$EstructuraError["msg"] = lang("La columna") . " U " . lang("Linea") . " " . $row . " " . lang("el numero tiene que ser mayor a cero") . " (0) " . lang("Cantidad de la Medida") . " 4";
					$EstructuraError["status"] = 0;
					break;
				}
				if ($EsCompuesto == "0") {
					if ($Existencia == "") {
						$Existencia = 0;
						/*
								$EstructuraError["msg"] = lang("La columna") . " V " . lang("Linea") . " " . $row . " " . lang("No detecta los datos del campo de") . " " . lang("Existencia Actual");
								$EstructuraError["status"] = 0;
								break;
							*/
					}

					if (!is_numeric($Existencia)) {

						$EstructuraError["msg"] = lang("La columna") . " V " . lang("Linea") . " " . $row . " " . lang("detecta que no es tipo numerico") . " " . lang("Existencia Actual");
						break;
					}

					if ($Existencia < 0) {
						$EstructuraError["msg"] = lang("La columna") . " V " . lang("Linea") . " " . $row . " " . lang("monto de inventario no puede ser negativo") . " " . lang("Existencia Actual");
						$EstructuraError["status"] = 0;
						break;
					}
				}

				$rawdata[] = array(
					"Imagen" => $Imagen,
					"CodBarra" => trim($CodBarra),
					"CodIdAmpliado" => trim($CodIdAmpliado),
					"Descripcion" => trim($Descripcion),
					"Medida" => trim($Medida),
					"NombreImpuesto" => trim($NombreImpuesto),
					"ValorImpuesto" => doubleval($ValorImpuesto),
					"Costo" => doubleval($Costo),
					"Precio" => doubleval($Precio),
					"Precio2" => doubleval($Precio2),
					"Precio3" => doubleval($Precio3),
					"Precio4" => doubleval($Precio4),
					"Idfamilia" => trim($Idfamilia),
					"Marca" => trim($Marca),
					"PorKilo" => doubleval($PorKilo),
					"UnidadP1" => trim($UnidadP1),
					"CantP1" => doubleval($CantP1),
					"UnidadP2" => trim($UnidadP2),
					"CantP2" => doubleval($CantP2),
					"UnidadP3" => trim($UnidadP3),
					"CantP3" => doubleval($CantP3),
					"Existencia" => doubleval($Existencia),
				);
			}
		}
		if ($EstructuraError["status"] === -1) {
			if ($rawdata) {
				$EstructuraError["status"] = 1;
				$EstructuraError["data"] = $rawdata;
				return json_encode($EstructuraError, JSON_UNESCAPED_UNICODE);
			}
			$EstructuraError["status"] = 0;
			$EstructuraError["msg"] = lang("No tiene datos el archivo excel");
			return json_encode($EstructuraError, JSON_UNESCAPED_UNICODE);
		}
		return json_encode($EstructuraError, JSON_UNESCAPED_UNICODE);
	}
}

function ProductosForJson($json, $IdCompany, $EsCompuesto)
{
	$conn = conectar();
	$data = json_decode($json, true);
	$EstructuraError = array(
		"status" => -1,
		"data" => "",
		"msg" => "",
	);

	$query = "SELECT CodIdBasico,CodIdAmpliado,CodBarra FROM PosUpProducto WHERE IdCompany=" . $IdCompany;
	$CodIdAmpliado = array();
	$CodBarra = array();
	if ($result = mysqli_query($conn, $query)) {
		while ($row = mysqli_fetch_array($result)) {
			$CodIdAmpliado[$row["CodIdAmpliado"]] = $row["CodIdBasico"];
			$CodBarra[$row["CodBarra"]] = $row["CodIdBasico"];
		}
	}
	$conn->autocommit(FALSE);
	foreach ($data as $value) {
		if (trim($CodIdAmpliado[$value["CodIdAmpliado"]]) == "" && trim($CodBarra[$value["CodBarra"]]) == "") {
			$sql = "SELECT IdVarios FROM PosUpvarios WHERE IdCompany =" . $IdCompany . " and TIPOITEM = 0 and VALOR = '" . ($value["ValorImpuesto"] / 100) . "' and ITEM ='" . $value["NombreImpuesto"] . "'";
			if ($result = mysqli_query($conn, $sql)) {
				$totalData = mysqli_num_rows($result);
			}
			$Impuesto = "";
			if ($totalData === 0) {
				$sql = "insert into PosUpvarios (IdCompany,IdVarios,TIPOITEM,ITEM,VALOR,pathimg,esserial,eslote) (select " . $IdCompany . ",COALESCE(max(IdVarios),0)+1 as IdVarios,0,'" . $value["NombreImpuesto"] . "'," . ($value["ValorImpuesto"] / 100) . ",'NULL',0,0 from PosUpvarios where IdCompany = " . $IdCompany . "  and TIPOITEM=0 )";
				$result = mysqli_query($conn, $sql);
				if ($result === true) {
					$sql = "SELECT IdVarios FROM PosUpvarios WHERE IdCompany =" . $IdCompany . " and TIPOITEM = 0 and VALOR = '" . ($value["ValorImpuesto"] / 100) . "' and ITEM ='" . $value["NombreImpuesto"] . "'";
					if ($result = mysqli_query($conn, $sql)) {
						while ($row = mysqli_fetch_array($result)) {
							$Impuesto = $row["IdVarios"];
						}
					}
				} else {
					$EstructuraError["status"] = 0;
					$EstructuraError["msg"] = lang("Error al crear el impuesto") . " " . $value["NombreImpuesto"] . " %" . $value["ValorImpuesto"] . "%";
					break;
				}
			}
			if ($totalData > 0) {
				while ($row = mysqli_fetch_array($result)) {
					$Impuesto = $row["IdVarios"];
				}
			}

			$Marca = "";
			$sql = "SELECT idmarca FROM PosUpc_marcas WHERE IdCompany =" . $IdCompany . " and nombre = '" . trim($value["Marca"]) . "'";
			if ($result = mysqli_query($conn, $sql)) {
				$totalData = mysqli_num_rows($result);
			}
			if ($totalData === 0) {
				$sql = "insert into PosUpc_marcas (IdCompany,idmarca,nombre,idfabricante) (select " . $IdCompany . ",COALESCE(max(idmarca),0)+1 as idmarca,'" . trim($value["Marca"]) . "',0 from PosUpc_marcas where IdCompany = " . $IdCompany . ")";
				$result = mysqli_query($conn, $sql);
				if ($result === true) {
					$sql = "SELECT idmarca FROM PosUpc_marcas WHERE IdCompany =" . $IdCompany . " and nombre = '" . trim($value["Marca"]) . "'";
					if ($result = mysqli_query($conn, $sql)) {
						while ($row = mysqli_fetch_array($result)) {
							$Marca = $row["idmarca"];
						}
					}
				} else {
					$EstructuraError["status"] = 0;
					$EstructuraError["msg"] = lang("Error al crear la marca") . " " . $value["Marca"];
					break;
				}
			}
			if ($totalData > 0) {
				while ($row = mysqli_fetch_array($result)) {
					$Marca = $row["idmarca"];
				}
			}

			$sql = "SELECT IdVarios FROM PosUpvarios WHERE IdCompany =" . $IdCompany . " and TIPOITEM = 2 and ITEM = '" . $value["Idfamilia"] . "'";
			if ($result = mysqli_query($conn, $sql)) {
				$totalData = mysqli_num_rows($result);
			}

			if ($totalData == 0) {
				$sql = "insert into PosUpvarios (venta,generaorden,IdCompany,IdVarios,TIPOITEM,ITEM,VALOR,pathimg,esserial,eslote,ventaweb,compweb) (select 0,0," . $IdCompany . ",COALESCE(max(IdVarios),0)+1 as IdVarios,2,'" . $value["Idfamilia"] . "',0,'NULL',0,0,0,0 from PosUpvarios where IdCompany = " . $IdCompany . " and TIPOITEM=2 )";
				$result = mysqli_query($conn, $sql);
				if ($result === true) {
					$sql = "SELECT IdVarios FROM PosUpvarios WHERE IdCompany =" . $IdCompany . " and TIPOITEM = 2 and ITEM = '" . $value["Idfamilia"] . "'";
					if ($result = mysqli_query($conn, $sql)) {
						while ($row = mysqli_fetch_array($result)) {
							$Familia = $row["IdVarios"];
						}
					}
				} else {
					$EstructuraError["status"] = 0;
					$EstructuraError["msg"] = lang("Error al crear la familia") . " " . $value["Idfamilia"];
					break;
				}
			}
			if ($totalData > 0) {
				while ($row = mysqli_fetch_array($result)) {
					$Familia = $row["IdVarios"];
				}
			}

			$ImpuestoCal = ($value["ValorImpuesto"] / 100);
			$CostoConImpuesto = $value["Costo"];

			if ($CostoConImpuesto > 0) {
				$CostoSinImpuesto = $CostoConImpuesto / (1 + $ImpuestoCal);
			} else {
				$CostoSinImpuesto = 0;
			}

			$PrecioConImpuesto = $value["Precio"];
			if ($PrecioConImpuesto > 0) {
				$PrecioSinImpuesto = $PrecioConImpuesto / (1 + $ImpuestoCal);
			} else {
				$PrecioSinImpuesto = 0;
			}

			$PrecioConImpuesto2 = $value["Precio2"];
			if ($PrecioConImpuesto2 > 0) {
				$PrecioSinImpuesto2 = $PrecioConImpuesto2 / (1 + $ImpuestoCal);
			} else {
				$PrecioSinImpuesto2 = 0;
			}

			$PrecioConImpuesto3 = $value["Precio3"];
			if ($PrecioConImpuesto3 > 0) {
				$PrecioSinImpuesto3 = $PrecioConImpuesto3 / (1 + $ImpuestoCal);
			} else {
				$PrecioSinImpuesto3 = 0;
			}

			$PrecioConImpuesto4 = $value["Precio4"];
			if ($PrecioConImpuesto4 > 0) {
				$PrecioSinImpuesto4 = $PrecioConImpuesto4 / (1 + $ImpuestoCal);
			} else {
				$PrecioSinImpuesto4 = 0;
			}

			if ($CostoSinImpuesto > 0) {
				$Margen = (($PrecioSinImpuesto - $CostoSinImpuesto) * 100) / $CostoSinImpuesto;
				$Margen2 = (($PrecioSinImpuesto2 - $CostoSinImpuesto) * 100) / $CostoSinImpuesto;
				$Margen3 = (($PrecioSinImpuesto3 - $CostoSinImpuesto) * 100) / $CostoSinImpuesto;
				$Margen4 = (($PrecioSinImpuesto4 - $CostoSinImpuesto) * 100) / $CostoSinImpuesto;
			} else {
				$Margen = 0;
				$Margen2 = 0;
				$Margen3 = 0;
				$Margen4 = 0;
			}

			if ($Impuesto !== "" && $Familia !== "" && $Marca !== "") {
				$sql = "insert into PosUpProducto (IdCompany,CodBarra,CodIdBasico,CodIdAmpliado,Descripcion,Medida,Impuesto,Costo,Margen,PrecioVenta,CostoNeto,PrecioNeto,Estado,RutUltimoProveedor,Envase,Idfamilia,Marca,Min,Max,Exis,PorKilo,EsCompuesto,Margen2,PrecioVenta2,PrecioNeto2,Margen3,PrecioVenta3,PrecioNeto3,Margen4,PrecioVenta4,PrecioNeto4,CantP1,UnidadP1,CantP2,UnidadP2,CantP4,UnidadP4)  (select  " . $IdCompany . ",'" . $value["CodBarra"] . "',LPAD(CAST(COALESCE(max(CodIdBasico+1),0) as CHAR), 10, '0') as CodIdBasico,'" . $value["CodIdAmpliado"] . "','" . mysqli_real_escape_string($conn, $value["Descripcion"]) . "','" . $value["Medida"] . "','" . $Impuesto . "'," . $CostoConImpuesto . "," . $Margen . "," . $PrecioConImpuesto . "," . $CostoSinImpuesto . "," . $PrecioSinImpuesto . ",1,0,'','" . $Familia . "','" . $Marca . "',0,0,0,'" . $value["PorKilo"] . "','" . $EsCompuesto . "'," . $Margen2 . "," . $PrecioConImpuesto2 . "," . $PrecioSinImpuesto2 . "," . $Margen3 . "," . $PrecioConImpuesto3 . "," . $PrecioSinImpuesto3 . "," . $Margen4 . "," . $PrecioConImpuesto4 . "," . $PrecioSinImpuesto4 . "," . $value["CantP1"] . ",'" . $value["UnidadP1"] . "'," . $value["CantP2"] . ",'" . $value["UnidadP2"] . "'," . $value["CantP3"] . ",'" . $value["UnidadP3"] . "' from PosUpProducto where IdCompany=" . trim($IdCompany) . ")";
				$result = mysqli_query($conn, $sql);
				if ($result === false) {
					$EstructuraError["status"] = 0;
					$EstructuraError["msg"] = lang("Error al crear el producto") . " " . $value["Descripcion"];
					break;
				}
			}
		}
	}
	if ($EstructuraError["status"] === -1) {
		$conn->commit();
		$EstructuraError["status"] = 1;
		$EstructuraError["msg"] = lang("Se han creado los productos");
		return json_encode($EstructuraError, JSON_UNESCAPED_UNICODE);
	}
	$conn->rollback();
	return json_encode($EstructuraError, JSON_UNESCAPED_UNICODE);
}

if (isset($_POST['Accion']) && $_POST['Accion'] == 'ValidarBarra') {

	include "ambienteconsultas.php";
	$conn = conectar();


	$g = json_decode($_POST["Barra"], true);
	foreach ($g as $clave => $valor) {

		$query = "SELECT  '" . trim($valor['CodBarra']) . "' AS Cod, CodIdBasico,CodBarra  from PosUpProducto where IdCompany = " . $_POST['CompanyActual'] . " and  (CodBarra like '%|" . trim($valor['CodBarra']) . "|%' or CodBarra like '" . trim($valor['CodBarra']) . "|%' or CodBarra like '%|" . trim($valor['CodBarra']) . "' or CodBarra = '" . trim($valor['CodBarra']) . "') and CodIdBasico<>'" . trim($_POST['CodIdBasico']) . "'  ";
		$codbarraepet = '';
		$lit = 0;
		if ($result3 = mysqli_query($conn, $query)) {
			while ($row3 = mysqli_fetch_assoc($result3)) {
				$barras = explode("|", $row3['CodBarra']);
				if ($row3['CodIdBasico'] <> '') {
					foreach ($barras as $val) {

						if (trim($val) == trim($valor['CodBarra'])) {
							$lit = $lit + 1;
							if ($lit == 1) {
								$codbarraepet = trim(str_replace('|', '', trim($val))) . '';
							} else {
								$codbarraepet =  trim(str_replace('|', '', trim($val))) . ' , ' . $codbarraepet;
							}
						}
					}
				}
			}
		}
	}
	// if ($codbarraepet !== "") echo $query;
	echo $codbarraepet;
}



if (isset($_POST['Necesito']) && $_POST['Necesito'] == "Respuestas") {
	$findme1   = '*';/* */
	$findme2   = '-';/* */
	$findme3   = '+';/* */
	$findme5   = '=';/* */
	$findme6   = '+';/* */
	$findme7   = '_';/* */
	$findme10  = ";";/* */
	$findme11  = "?";/* */
	$findme16  = "(";/* */
	$findme17  = ")";/* */
	$findme18  = "<";/* */
	$findme19  = ">";/* */
	$findme21  = "`";/* */
	$findme23  = "@";/* */
	$findme24  = "#";/* */
	$findme25  = "$";/* */
	$findme26  = "%";/* */
	$findme0   = '/'; //
	$findme4   = '|'; //
	$findme8   = '"'; //
	$findme9   = "'"; //
	$findme12  = "}"; //
	$findme13  = "{"; //
	$findme14  = "["; //
	$findme15  = "]"; //
	$findme20  = "~"; //
	$findme22  = "!"; //
	$findme27  = "^"; //
	$findme28  = "&"; //
	$findme291  = "\\";
	$findme29  = substr($findme291, 0, 1);
	$findme30  = "´";
	$findme31 = "°"; //
	$sql = "SELECT CodIdAmpliado,CodIdBasico FROM PosUpProducto WHERE IdCompany='" . trim($_POST['CompanyActual']) . "' and CodIdAmpliado = '" . trim($_POST['SKU']) . "'";
	$CodIdAmpliado = '';
	$CodIdBasico1 = '';
	if ($result = mysqli_query($conn, $sql)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$CodIdAmpliado = $row['CodIdAmpliado'];
			$CodIdBasico1 = $row['CodIdBasico'];
		}
	}
	$CodBarra = '';
	$CodIdBasico2 = '';
	if (isset($_POST["CodBarra"])) {
		$sql = "SELECT CodBarra,CodIdBasico FROM PosUpProducto WHERE IdCompany='" . trim($_POST['CompanyActual']) . "' and CodBarra = '" . trim($_POST['CodBarra']) . "'";
		if ($result = mysqli_query($conn, $sql)) {
			while ($row = mysqli_fetch_assoc($result)) {
				$CodBarra = $row['CodBarra'];
				$CodIdBasico2 = $row['CodIdBasico'];
			}
		}
	}
	if ((trim($CodIdAmpliado) == '') or (trim($CodIdBasico1) == trim($_POST['CodIdBasico']))) {
		if ((trim($CodBarra) == '') or (trim($CodIdBasico2) == trim($_POST['CodIdBasico']))) {

			echo 1;
		} else {
			echo 2;
		}
	} else {
		echo 0;
	}
}
if (isset($_POST['Almacen']) && $_POST['Almacen'] == "3") {
	$conn = conectar();
	$query = "select c.nombre as Almacen,a.seriales,round(sum(coalesce(a.Cant)*coalesce(d.Inventario)),3) as Cantidad  from PosUpTxD a inner join PosUpProducto b on a.IdCompany=b.IdCompany and a.CodIdBasico=b.CodIdBasico inner join PosUpAlmacen c on a.IdCompany=c.IdCompany and a.IdAlm=c.IdAlm inner join PosUpTx d on a.Idtipotx=d.Idtipotx where a.IdCompany = " . $_POST["CompanyActual"] . " and b.CodIdBasico = " . $_POST["Id"] . " and a.Seriales != '' group by b.CodIdBasico,a.seriales,c.IdAlm HAVING Cantidad>0";

	//echo $query;
	if ($result = mysqli_query($conn, $query)) {
		$CodIdBasico = "";
		$Descripcion = "";
		$Seriales = "";
		while ($row = mysqli_fetch_assoc($result)) {
			$CodIdBasico = $row["CodIdBasico"];
			$Descripcion = $row["Descripcion"];
			$Seriales = $row["Seriales"];
		}
		mysqli_free_result($result);
	}
	if ($Seriales !== "") {
	?>
		<button class="btn btn-outline-success" type="button" onclick="abrir12343()">VER SERIALES</button>
		<span id="Serialesequisde" name="Serialesequisde" style="display:none"><?php echo $Seriales; ?></span>
		<?php
	}
}



if (isset($_POST['Accion']) && $_POST['Accion'] == "Stock") {
	$conn = conectar();


	$query2 = "SELECT c.Nombre as Almacen,sum(coalesce(a.Cant)*coalesce(d.Inventario)) as Cantidad FROM PosUpTxD a inner join PosUpProducto b on a.IdCompany=b.IdCompany and a.CodIdBasico=b.CodIdBasico inner join PosUpAlmacen c on a.IdCompany=c.IdCompany and a.IdAlm=c.IdAlm inner join PosUpTx d on a.Idtipotx=d.Idtipotx where a.IdCompany=" . $_POST["companyUser"] . " and b.CodIdBasico='" . $_POST["ModalCodIdBasico"] . "'  group by b.CodIdBasico,c.IdAlm";

	$mtotal = 0;
	//echo $query2;
	if ($result2 = mysqli_query($conn, $query2)) {
		$n2 = 1;


		while ($row2 = mysqli_fetch_assoc($result2)) {
			if ($n2 > 1) {
				echo "</br>";
			}


			$mtotal = $mtotal + $row2['Cantidad'];

			echo trim($row2["Almacen"]) . ": " . getcantformat($row2["Cantidad"], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . trim($_POST["ModalMedida"]);
			$n2 = $n2 + 1;
		?>

	<?php
		}
		echo '<br> Existencia Total: ' . getcantformat($mtotal, $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . " " . trim($_POST["ModalMedida"]);

		mysqli_free_result($result2);
	}
	$query2 = "SELECT sum(a.Cant) as Cantidad FROM PosUpTxD a inner join PosUpProducto b on a.IdCompany=b.IdCompany and a.CodIdBasico=b.CodIdBasico inner join PosUpAlmacen c on a.IdCompany=c.IdCompany and a.IdAlm=c.IdAlm inner join PosUpTx d on a.Idtipotx=d.Idtipotx where a.IdCompany=" . $_POST["companyUser"] . " and b.CodIdBasico='" . $_POST["ModalCodIdBasico"] . "'  and a.idtipotx=14";
	//echo $query2;
	if ($result2 = mysqli_query($conn, $query2)) {
		while ($row2 = mysqli_fetch_assoc($result2)) {
			echo '<br> Total Pedidos: ' . getcantformat($row2["Cantidad"], 3, $_POST["SimDec"], $_POST["SimMil"]) . " " . trim($_POST["ModalMedida"]);
		}
		mysqli_free_result($result2);
	}
}
if (isset($_POST['Almacen']) && $_POST['Almacen'] == "8") {
	$query3 = "SELECT COUNT(DISTINCT a.Idtx) as cant FROM PosUpTxD a inner join PosUpTx b on b.Idtipotx=a.Idtipotx WHERE a.IdCompany='" . trim($_POST['CompanyActual']) . "' and a.Idtipotx=14 and a.CodIdBasico='" . trim($_POST['Id']) . "' group by a.fectxclient";
	//echo $query3;
	$cantReg = 0;
	if ($result3 = mysqli_query($conn, $query3)) {
		while ($row3 = mysqli_fetch_assoc($result3)) {
			$cantReg = $cantReg + $row3['cant'];
		}
	}
	$sql = "SELECT sum(a.cant) as Cant,b.Titulo as Transaccion,a.idtipotx,DATE_FORMAT(a.Fectxclient,'%d/%m/%Y %h:%i:%s %p') as Fecha,a.Referencia FROM PosUpTxD a inner join PosUpTx b on b.Idtipotx=a.Idtipotx WHERE a.IdCompany='" . trim($_POST['CompanyActual']) . "' and a.Idtipotx=14 and a.CodIdBasico='" . trim($_POST['Id']) . "' group by a.fectxclient limit " . (($_POST["PagAct"] - 1) * ($_POST["Limite"])) . "," . $_POST["Limite"];
	?>
	<div class="row input-group">
		<div class="col-12  ">
			<nav class='float-end'>
				<ul class="pagination">
					<?php if ($_POST["PagAct"] == 1) { ?>

					<?php } else { ?>
						<li class="page-item">
							<a class="page-link" href="javascript:Pagineo2(1)"><span class="fa fa-angle-double-left"></span></a>
						</li>
						<li class="page-item">
							<a class="page-link" href="javascript:Pagineo2(<?php echo $_POST["PagAct"] - 1; ?>)"><span class="fa fa-angle-left"></span></a>
						</li>
					<?php } ?>
					<?php
					$CanPags = intval($cantReg / $_POST["Limite"]) + ((($cantReg / $_POST["Limite"]) - intval($cantReg / $_POST["Limite"])) > 0 ? 1 : 0);
					$j = 0;
					for ($i = $_POST["PagAct"]; $i <= $CanPags; $i++) {
						$j++;
						if ($j <= 5) {
					?><li class="page-item <?php echo ($_POST["PagAct"] == $i ? "active" : ""); ?>">
								<a class="page-link" href="javascript:Pagineo2(<?php echo $i; ?>)"><?php echo $i; ?></a>
							</li><?php
								}
							}
									?>
					<?php if ($_POST["PagAct"] == $CanPags  or $cantReg == 0) { ?>

					<?php } else { ?>
						<li class="page-item">
							<a class="page-link" href="javascript:Pagineo2(<?php echo $_POST["PagAct"] + 1; ?>)"><span class="fa fa-angle-right"></span></a>
						</li>
						<li class="page-item">
							<a class="page-link" href="javascript:Pagineo2(<?php echo $CanPags; ?>)"><span class="fa fa-angle-double-right "></span></a>
						</li>
					<?php } ?>
				</ul>
			</nav>
		</div>
	</div>
	<table class="table table-striped table-hover">
		<thead class="table-light">
			<tr>
				<th class="text-left  ">Transaccion</th>
				<th class="text-left  ">Fecha</th>
				<th class="text-left  d-none d-sm-table-cell">Referencia</th>
				<th class="text-left  ">Cantidad</th>
			</tr>
		</thead>
		<tbody>

			<?php
			//echo $sql;
			$Referencia = '';
			$Cant = 0;
			if ($result = mysqli_query($conn, $sql)) {
				while ($row = mysqli_fetch_assoc($result)) {
					$Cant = $Cant + $row['Cant'];
					if ($row['Referencia'] == '') {
						$Referencia = '-';
					} else {
						$Referencia = $row['Referencia'];
					}
					echo '<tr>' . '<td class="text-left  text-responsive2" >' . $row['Transaccion'] . '</td>' . '<td class="text-left  text-responsive2" >' . $row['Fecha'] . '</td>' . '<td class="text-left  d-none d-sm-table-cell">' . $Referencia . '</td>' . '<td class="text-right  text-responsive2">' . getcantformat($row['Cant'], $_POST["CD"], $_POST["SimDec"], $_POST["SimMil"]) . '</td>' . '</tr>';
				}
			}
			echo '<tr>' . '<td class="text-left  text-responsive2" >' . '-' . '</td class="text-left  text-responsive2" >' . '<td class="text-left  d-none d-sm-table-cell ">' . '-' . '</td>' . '<td class="text-left  ">' . 'TOTALES:' . '</td class="text-left  text-responsive2">' . '<td class="text-right  text-responsive2">' . $Cant . '</td>' . '</tr>';
			echo '</tbody>' . '</table>';
			?>
			<div class="row input-group">
				<div class="col-12  col-sm-7 col-md-8 col-lg-9">

					<?php echo lang('Visualizando'); ?>: <spam id="Rpa"><?php echo $_POST["Limite"]; ?></spam> <?php echo lang('Registro(s) por página'); ?> /
					<spam id="CanRegs">
						<?php
						echo $cantReg;
						?>
					</spam><?php echo lang('Registro(s)'); ?> /
					<?php echo lang('Página'); ?> <spam id="PagAct2"><?php echo $_POST["PagAct"]; ?></spam> <?php echo lang('de'); ?> <spam id="CanPags"><?php echo $CanPags; ?></spam>


				</div>

				<div class="col-12  col-sm-5 col-md-4 col-lg-3">
					<nav class='float-end'>
						<ul class="pagination">
							<?php
							if ($_POST["PagAct"] == 1) {
							?>

							<?php
							} else {
							?>
								<li class="page-item">
									<a class="page-link" href="javascript:Pagineo2(1)"><span class="fa fa-angle-double-left"></span></a>
								</li>
								<li class="page-item">
									<a class="page-link" href="javascript:Pagineo2(<?php echo $_POST["PagAct"] - 1; ?>)"><span class="fa fa-angle-left"></span></a>
								</li>
							<?php
							}
							?>
							<?php
							$CanPags = intval($cantReg / $_POST["Limite"]) + ((($cantReg / $_POST["Limite"]) - intval($cantReg / $_POST["Limite"])) > 0 ? 1 : 0);
							$j = 0;
							for ($i = $_POST["PagAct"]; $i <= $CanPags; $i++) {
								$j++;
								if ($j <= 5) {
							?>
									<li class="page-item <?php echo ($_POST["PagAct"] == $i ? "active" : ""); ?>">
										<a class="page-link" href="javascript:Pagineo2(<?php echo $i; ?>)"><?php echo $i; ?></a>
									</li>
							<?php
								}
							}

							?>
							<?php
							if ($_POST["PagAct"] == $CanPags or $cantReg == 0) {
							?>

							<?php
							} else {
							?>
								<li class="page-item">
									<a class="page-link" href="javascript:Pagineo2(<?php echo $_POST["PagAct"] + 1; ?>)"><span class="fa fa-angle-right"></span></a>
								</li>
								<li class="page-item">
									<a class="page-link" href="javascript:Pagineo2(<?php echo $CanPags; ?>)"><span class="fa fa-angle-double-right "></span></a>
								</li>
							<?php
							}
							?>
						</ul>
					</nav>
				</div>

			</div>
		</tbody>
	</table>
	<?php
}
if (isset($_POST['Accion']) && $_POST['Accion'] == "6") {
	$conexion = conectar();
	$sql = " select UPPER(a.Medida) as label from PosUpProducto a WHERE IdCompany=" . trim($_POST["Company"]) . " and Medida LIKE '%" . $_POST["keyword"] . "%' group by a.Medida HAVING label <> ''";
	$result = mysqli_query($conexion, $sql);
	if (!empty($result)) {

		foreach ($result as $lista) {
	?>
			<option class="col-12 g-0 btn bg-light" style="text-align: left;" onClick="selectlist('<?php echo $lista["label"]; ?>');"><?php echo $lista["label"]; ?></option>
			<?php
		}
	}
}
if (isset($_POST['AC']) && $_POST['AC'] == "1") {
	$conexion = conectar();
	$sql = " select UPPER(a.Envase) as label from PosUpProducto a WHERE IdCompany=" . trim($_POST["Company"]) . " and Envase LIKE '%" . $_POST["keyword"] . "%' group by a.Envase HAVING label <> '' order by a.CodIdBasico desc";
	$result = mysqli_query($conexion, $sql);
	$n = 0;
	while ($row = mysqli_fetch_assoc($result)) {
		if ($n < 11) {
			$result2 = explode('|', $row["label"]);
			foreach ($result2 as $lista) {
				if (trim($lista) <> "") {
					$n++
			?>
					<div><button type="button" class="dropdown-item" onclick="selectlist2('<?php echo $lista; ?>');"><?php echo $lista; ?></button></div>
<?php
				}
			}
		}
	}
}


if (isset($_POST['Accion']) && $_POST['Accion'] == 'SKU-VERIF') {

	$query3 = "SELECT COUNT(DISTINCT a.CodIdBasico) as cant FROM PosUpProducto a  
    WHERE a.IdCompany=" . $_POST["company"];
	if ($result3 = mysqli_query($conn, $query3)) {
		while ($row3 = mysqli_fetch_assoc($result3)) {
			$cantSKU = $row3['cant'];
		}
	}

	$sqlcompany = "SELECT * FROM PosUpCompany where Id='" . $_POST['company'] . "'";
	if ($params = mysqli_query($conn, $sqlcompany)) {
		while ($pam = mysqli_fetch_assoc($params)) {
			$CantSKUL = $pam['CantSKU'];
		}
		mysqli_free_result($params);
	}
	if ($cantSKU < $CantSKUL or $CantSKUL == 0) {
		echo '1';
	} else {

		echo '0';
	}
}
