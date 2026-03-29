<?php
include "inicializador.php";
include_once "ambiente.php";
$connsultas = ConectarConsultas();

if ($_SESSION["TokenAsociada"] !== "0") {
	$TokenMan = $_SESSION["TokenAsociada"];
} else {
	$TokenMan = $_SESSION["TokenEstacion"];
}
if (trim($_SESSION["TokenSeleccionado"]) === "") $_SESSION["TokenSeleccionado"] = $TokenMan;

$PerfilVentas = explode(",", $_SESSION["PerfilVentas"]) ?? '';
$urls = "";

$urls = "img/usuario.png";

$usernombre = $_SESSION['usernombre'] ?? "";
$userperfilnombre = $_SESSION['userperfilnombre'] ?? "";
$ModuloActual = $_SESSION['ModuloActual'] ?? "";
$opcion = $_SESSION['opcion'] ?? "";
$Company1097 = "";
if (($_SESSION['CompanyActual'] ?? "") === "1097") {
	$Company1097 .= '
	<span style="display:none;">
		<img src="/img/LIT-001.png" alt="a">
		<img src="/img/LIT-002.png" alt="a">
		<img src="/img/LIT-003.png" alt="a">
	</span>';
}
echo $Company1097;

// $alertGo = [];
/*
$CodIdBasico = [];
if ($_SESSION["AlertExistMin"] ?? "0" === "1") {
	$query = "SELECT sum(c.Cant*b.Inventario) as Cant,a.Descripcion,a.min,a.CodIdBasico FROM posupproducto a left join posuptxd c on c.IdCompany = a.IdCompany and c.CodIdBasico = a.CodIdBasico left join posuptx b on b.idtipotx = c.idtipotx where a.IdCompany=" . $_SESSION["CompanyActual"] . " group by a.CodIdBasico,c.IdAlm HAVING Cant <= min";
	if ($result = mysqli_query($connsultas, $query)) {
		while ($row = mysqli_fetch_assoc($result)) {
			// $alertGo[] = [
			// 	"Cant" => $row["Cant"],
			// 	"Descripcion" => $row["Descripcion"],
			// 	"min" => $row["min"],
			// ];
			$CodIdBasico[] = $row["CodIdBasico"];
		}
		mysqli_free_result($result);
	}
}
*/

$conn = conectar2();
$seeTraslate = "0";
$query = "SELECT a.* from PosUpUsers a where a.IdCompany='" . $_SESSION["userCompany"] . "' and a.login='" . $_SESSION["userlogin"] . "'";
//echo $query;
if ($result = mysqli_query($connsultas, $query)) {
	while ($row = mysqli_fetch_assoc($result)) {
		$_SESSION["PerfilVentasUser"] = $row['p0'] . ',' . $row['p1'] . ',' . $row['p2'] . ',' . $row['p3'] . ',' . $row['c0'] . ',' . $row['u1'] . ',' . $row['u2'] . ',' . $row['u3'] . ',' . $row['valiv1'] . ',' . $row['PrecioUnidad'] . ',' . $row['u4'] . ',' . $row['p4'] . ',' . $row['u5'] . ',' . $row['p5'] . ',' . $row['u6'] . ',' . $row['p6'] . ',' . $row['u7'] . ',' . $row['p7'] . ',' . $row['u8'] . ',' . $row['p8'] . ',' . $row['u9'] . ',' . $row['p9'] . ',' . $row['u10'] . ',' . $row['p10'];
		$_SESSION["IdAlmGroup"] = $row["IdAlmGroup"];
		$_SESSION["VerStock"] = $row["VerStock"];
		$seeTraslate = $row["seeTraslate"];
	}
	mysqli_free_result($result);
}

$VersionS = "";
$query = "SELECT VersionS FROM posup ";
if ($result = mysqli_query($conn, $query)) {
	while ($row = mysqli_fetch_assoc($result)) {
		$VersionS = $row["VersionS"];
	}
	mysqli_free_result($result);
}
?>
<!doctype html>
<html lang="es" translate="no" class="h-100">

<head>
	<meta http-equiv="Expires" content="0">
	<meta http-equiv="Last-Modified" content="0">
	<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
	<meta http-equiv="Pragma" content="no-cache">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<title id="Titulodelapagina">PosUp | CONECTA TUS FINANZAS</title>
	<!-- Bootstrap core CSS -->
	<link href="/css/bootstrap.min.css" rel="stylesheet" media="all" />
	<link href="stylesapp.css?v=<? echo random_int(1, 9999999); ?>" rel="stylesheet">
	<link href="stylesprint.css?v=<? echo random_int(1, 9999999); ?>" rel="stylesheet" media="print" />
	<!-- Favicons -->
	<link rel="stylesheet" id="css-ionicons" href="assets/css/ionicons.css" />
	<link rel="stylesheet" href="css/font-awesome.css">
	<!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css"> -->
	<link rel="shortcut icon" href="img/AZUL.png" type="image/x-icon">
	<link rel="icon" href="img/ISO AZUL.svg" sizes="32x32" type="image/png">
	<link rel="apple-touch-icon" href="img/ISO AZUL.svg" sizes="180x180">
	<link rel="icon" href="img/ISO AZUL.svg" sizes="16x16" type="image/png">
	<link rel="icon" href="img/ISO AZUL.svg">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@700&display=swap" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

	<meta name="google" content="notranslate" />

</head>

<style>
	.star-button {
		background-color: #ffcc00;
		border: none;
		border-radius: 50%;
		width: 24px;
		height: 24px;
		display: flex;
		align-items: center;
		justify-content: center;
		cursor: pointer;
		box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
		transition: transform 0.2s ease;
	}

	.star-button:active {
		transform: scale(0.95);
	}

	.star-icon {
		font-size: 12px;
		color: #fff;
		transition: transform 0.3s ease, color 0.3s ease;
	}

	.star-button.active .star-icon {
		animation: pulse 0.5s ease;
		color: #ff8800;
		transform: rotate(0deg) scale(1);
	}

	@keyframes pulse {
		0% {
			transform: scale(1) rotate(0deg);
		}

	}
</style>

<script>
	function modificarMes(fechaOrigen, meses) {
		const fecha = new Date(fechaOrigen); //¡se hace esto para no modificar la fecha original!
		const mes = fecha.getMonth();
		fecha.setMonth(fecha.getMonth() + meses);
		while (fecha.getMonth() === mes) {
			fecha.setDate(fecha.getDate() - 1);
		}
		return fecha;
	}

	function DateConvert(date = new Date()) {
		return `${date.getUTCFullYear()}-${
    date.getUTCMonth() + 1 < 10 ? `0${date.getUTCMonth() + 1}` : date.getUTCMonth() + 1 
  }-${date.getUTCDate() < 10 ? `0${date.getUTCDate()}` : date.getUTCDate()}`;
	}



	let favoritos = JSON.parse('<?php echo $_SESSION["favoritos"] ?? "[]"; ?>');
	const opcionApp = '<?php echo $_SESSION["opcion"] ?? 'dashboard.php'; ?>';
	const ModuloActual = '<?php echo $_SESSION["ModuloActual"] ?? 'dash'; ?>';
	const esDemo = <?php echo $_SESSION["esDemo"] ?? ''; ?>;
	const PeriodoStock = <?php echo $_SESSION["PeriodoStock"] ?? '0'; ?>;
	const diasDEMO = <?php echo $_SESSION["diasDEMO"] ?? '0'; ?>;
	const userCompany = <?php echo $_SESSION["userCompany"] ?? ''; ?>;
	const CompanyActual = <?php echo $_SESSION["CompanyActual"] ?? ''; ?>;
	const TokenEstacion = "<?php echo $_SESSION["TokenEstacion"] ?? ''; ?>";
	const TokenAsociada = "<?php echo $_SESSION["TokenAsociada"] ?? ''; ?>";
	const TokenSeleccionado = "<?php echo $_SESSION["TokenSeleccionado"] ?? ''; ?>";
	const userlogin = "<?php echo $_SESSION["userlogin"] ?? ''; ?>";
	const userperfil = "<?php echo $_SESSION["userperfil"] ?? ''; ?>";
	const MontoMayorMoneda = <?php echo $_SESSION["MontoMayorMoneda"] ?? 0; ?>;
	const MontoMenorMoneda = <?php echo $_SESSION["MontoMenorMoneda"] ?? 0; ?>;
	const cotizadortipo = <?php echo $_SESSION["cotizadortipo"] ?? 0; ?>;
	const NumTxViewVTA = <?php echo $_SESSION["NumTxViewVTA"] ?? 1; ?>;
	const NumTxViewCOM = <?php echo $_SESSION["NumTxViewCOM"] ?? 1; ?>;
	const NumTxViewINV = <?php echo $_SESSION["NumTxViewINV"] ?? 1; ?>;
	const seeTraslate = <?php echo $seeTraslate; ?>;
	const MonedaP = "<?php echo $_SESSION["MonedaP"] ?? ''; ?>";
	// const alertGo = JSON.parse('<?php echo json_encode($alertGo, JSON_UNESCAPED_UNICODE); ?>');
	// const CodIdBasicoGroup = JSON.parse('<?php echo json_encode($CodIdBasico, JSON_UNESCAPED_UNICODE); ?>');
	const TolCosto = <?php echo $_SESSION["TolCosto"]; ?>;
	let ActiveAct = false;
	const today = DateConvert(modificarMes(new Date(), -1)).slice(0, 7).replace("-", "");

	window.addEventListener("load", function(event) {
		VerificarNworNot();
		actualizarTasaBCV();
		// if (alertGo.length > 0 && userperfil <= 2000) {
		// 	alertForMin();
		// }

		if (seeTraslate === 1) {
			CicloBusquedaTraslado();
		}
		if (esDemo === 1 && diasDEMO !== 0) {
			DemosEnd();
		}
		setcolorbg();
		cicloFavoritos();
	}, false);

	function cicloFavoritos() {

		// Si "favoritos" no existe o no es un array, no rompas la app
		if (typeof favoritos === "undefined" || !Array.isArray(favoritos)) {
			return;
		}

		// Si "opcionApp" no existe, evita errores
		var _op = (typeof opcionApp !== "undefined" && opcionApp !== null) ? String(opcionApp) : "";

		const toggle = favoritos.filter(c => String(c.url || "") === _op);

		// Toggle Star (puede que no exista en algunas vistas)
		var starEl = document.getElementById("toggleStarButton");
		if (starEl) {
			if (toggle.length > 0) {
			$("#toggleStarButton").addClass("active");
			starEl.innerHTML = `<img src="/img/favoritos-enabled.png" width="24" />`;
			} else {
			$("#toggleStarButton").removeClass("active");
			starEl.innerHTML = `<img src="/img/favoritos-disabled.png" width="24" />`;
			}
		}

		// Construir HTML de favoritos
		let html = "";

		favoritos.forEach(e => {
			const url = String(e.url || "");
			const img = String(e.img || "");
			const desc = String(e.desc || "");
			const mod = (typeof e.IdModulo !== "undefined" && e.IdModulo !== null) ? String(e.IdModulo) : "";

			html += `
			<li class="dropdown-item ${url === _op ? "active" : ""}">
				<a class="nav-link text-light" aria-current="page" href="app.php?opcion=${url}&m=${mod}">
				<i><img src="/img/${img}" width="18" height="18"></i> ${desc}
				</a>
			</li>
			`;
		});

		// Contenedor (puede no existir en algunas vistas)
		var cont = document.getElementById("cocheteteam");
		if (cont) {
			// usa jQuery si está, si no, directo
			if (window.jQuery) {
			$("#cocheteteam").html(html);
			} else {
			cont.innerHTML = html;
			}
		}
	}


	function toggleStar() {

		// document.getElementById("toggleStarButton").classList.toggle('active');

		const value = !$("#toggleStarButton").hasClass("active");

		$.ajax({
			type: "POST",
			url: "generalseek.php",
			data: {
				Action: "setFavoritos",
				CompanyActual: document.getElementById("CompanyActual").innerHTML,
				opcion: opcionApp,
				userlogin: document.getElementById("userlogin").innerHTML,
				change: value,
				ModuloActual: ModuloActual,
			}
		}).done(function(msg) {
			actualizarFavoritos();
		});
	}

	function actualizarFavoritos() {
		$.ajax({
			type: "POST",
			url: "generalseek.php",
			data: {
				Action: "actualizarFavoritos",
				CompanyActual: document.getElementById("CompanyActual").innerHTML,
				userlogin: document.getElementById("userlogin").innerHTML,
			}
		}).done(function(msg) {
			const array = JSON.parse(msg);

			favoritos = array.msg;

			cicloFavoritos();
		});

	}

	function DemosEnd() {
		$("#Modal-DeCargandoProcess").modal("show");
		$.ajax({
			type: "POST",
			url: "generalseek.php",
			data: {
				Action: "DemosEnd",
				CompanyActual: document.getElementById("CompanyActual").innerHTML,
			}
		}).done(function(msg) {
			const array = JSON.parse(msg);
			if (array.status === true) {
				console.log(1);
			} else {
				console.log(2);
			}
			$("#Modal-DeCargandoProcess").modal("hide");

		});

	}

	function CicloBusquedaTraslado() {
		const fecha = new Date(new Date().getTime() - (7 * 24 * 60 * 60 * 1000));

		let mes = fecha.getMonth() + 1;
		let dia = fecha.getDate();
		let hora = fecha.getHours();
		let min = fecha.getMinutes();
		let seg = fecha.getSeconds();
		if (dia < 10) dia = "0" + dia;
		if (mes < 10) mes = "0" + mes;
		if (hora < 10) hora = "0" + hora;
		if (seg < 10) seg = "0" + seg;

		const date =
			fecha.getFullYear() +
			"-" +
			mes +
			"-" +
			dia +
			" " +
			hora +
			":" +
			min +
			":" +
			seg

		$.ajax({
			type: "POST",
			url: "generalseek.php",
			data: {
				Action: "TrasladosActive",
				CompanyActual: document.getElementById("CompanyActual").innerHTML,
				TokenSeleccionado: TokenSeleccionado,
				date: date,
				userlogin: document.getElementById("userlogin").innerHTML
			}
		}).done(function(msg) {
			const array = JSON.parse(msg);
			if (array.status === true) {
				array.response.forEach(resp => {
					const button = `<button type="button" class="btn btn-dark px-1" data-bs-dismiss="alert" onclick="ImpresionTraslado('${resp.IdEstacion}', '${resp.Idtipotx}', '${resp.Idtx}', '${resp.IdBarcode}');"> <i class="fa fa-print"></i> Ver Impresion </button>`;

					const alertPlaceholder = document.getElementById("NotificacionesPa");
					const wrapper = document.createElement("div");

					wrapper.innerHTML = [
						`<div class='d-flex justify-content-end'>`,
						`<div class="alert border border-3 border-warning p-2 rounded-2 bg-light col-12 col-xl-4" role="alert">`,
						`<div><strong><i class="fa fa-exclamation-triangle text-warning"></i> Ha llegado un traslado a la sede ${button} </strong>
							<button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close" onclick="CerrarTraslado('${resp.IdEstacion}', '${resp.Idtipotx}', '${resp.Idtx}', '${resp.IdBarcode}');"></button>
						</div>`,
						"</div>",
						`</div>`,
					].join("");
					$(wrapper).hide();

					alertPlaceholder.append(wrapper);
					$(wrapper).fadeIn(500);

				});
				setTimeout(() => {
					CicloBusquedaTraslado();
				}, 30000)
			} else {

				setTimeout(() => {
					CicloBusquedaTraslado();
				}, 5000)
			}
		});
	}

	function ImpresionTraslado(IdEstacion, Idtipotx, Idtx, IdBarcode) {
		$.ajax({
			type: "POST",
			url: "generalseek.php",
			data: {
				Action: "TrasladosUpdate",
				CompanyActual: document.getElementById("CompanyActual").innerHTML,
				userlogin: document.getElementById("userlogin").innerHTML,
				IdEstacion: IdEstacion,
				Idtipotx: Idtipotx,
				Idtx: Idtx,
				IdBarcode: IdBarcode,
			}
		}).done(function(msg) {
			const array = JSON.parse(msg);
			if (array.status === true) {
				Impresion(IdEstacion, Idtipotx, Idtx);
			}
		});

	}

	function soporte() {
		$('#apps-soporte').modal('show');
	}

	function validaticket() {
		// Campos de texto
		if ($("#correoticket").val() == "") {
			document.getElementById('elfixed').style.display = "block";
			$("#valida").delay(500).fadeIn("slow");
			document.getElementById('contenido').innerHTML = "<?php echo lang('Correo no Encontrado.'); ?> ";
			setTimeout(() => OcultarNotificacion(), 5000);
			$("#correo").focus();
			return false;
		}
		if ($("#nombre").val() == "") {
			document.getElementById('elfixed').style.display = "block";
			$("#valida").delay(500).fadeIn("slow");
			document.getElementById('contenido').innerHTML = "<?php echo lang('Nombre no Encontrado.'); ?> ";
			setTimeout(() => OcultarNotificacion(), 5000);
			$("#ModalItem").focus();
			return false;
		}
		if ($("#telefonoticket").val() == "") {
			document.getElementById('elfixed').style.display = "block";
			$("#valida").delay(500).fadeIn("slow");
			document.getElementById('contenido').innerHTML = "<?php echo lang('El campo de texto Teléfono no puede estar vacío.'); ?> ";
			setTimeout(() => OcultarNotificacion(), 5000);
			$("#ModalItem").focus();
			return false;
		}
		if ($("#extencionticket").val() == "") {
			document.getElementById('elfixed').style.display = "block";
			$("#valida").delay(500).fadeIn("slow");
			document.getElementById('contenido').innerHTML = "<?php echo lang('El Campo de texto Extención no puede estar vacío.'); ?> ";
			setTimeout(() => OcultarNotificacion(), 5000);
			$("#ModalItem").focus();
			return false;
		}
		if ($("#resumenticket").val() == "") {
			document.getElementById('elfixed').style.display = "block";
			$("#valida").delay(500).fadeIn("slow");
			document.getElementById('contenido').innerHTML = "<?php echo lang('El Campo de texto Resumen no puede estar vacío.'); ?> ";
			setTimeout(() => OcultarNotificacion(), 5000);
			$("#ModalItem").focus();
			return false;
		}
		if ($("#problema").val() == "") {
			document.getElementById('elfixed').style.display = "block";
			$("#valida").delay(500).fadeIn("slow");
			document.getElementById('contenido').innerHTML = "<?php echo lang('El Campo de texto Problema no puede estar vacío.'); ?> ";
			setTimeout(() => OcultarNotificacion(), 5000);
			$("#ModalItem").focus();
			return false;
		}
		return true; // Si todo está correcto
	}

	function gticket() {
		if (validaticket()) {
			var correoticket = document.getElementById('correoticket').value;
			var nombreticket = document.getElementById('nombreticket').value;
			var extencionticket = document.getElementById('extencionticket').value;
			var idcomticket = document.getElementById('idcomticket').value;
			var comercioticket = document.getElementById('comercioticket').value;
			var comercorreoticket = document.getElementById('comercorreoticket').value;
			var resumenticket = document.getElementById('resumenticket').value;
			var telefonoticket = document.getElementById('telefonoticket').value;
			var problematicket = document.getElementById('problematicket').value;
			var formData = new FormData(document.getElementById("formticket"));
			formData.append('file', $('#archivoticket')[0].files[0]);
			formData.append('fecha', GenerarFecha("datetime"));
			$.ajax({
				url: 'generarTicket.php',
				type: 'POST',
				data: formData,
				processData: false, // tell jQuery not to process the data
				contentType: false, // tell jQuery not to set contentType
				success: function(data) {
					if (data != "") {
						//   $("#exito").delay(500).fadeIn("slow");  
						$('#apps-soporte').modal('toggle');
						document.getElementById('ticketnumero').innerHTML = data;
						$('#modal-numticket').modal('show');
					} else {
						//  $("#fracaso").delay(500).fadeIn("slow");
						alert("Error al Enviar el ticket.");
						$('#soportet').prop('disabled', false);
					}
				}
			});
		} else {
			$('#soportet').prop('disabled', false);
		}
	}

	function okticket() {
		location.reload();
	}

	function getVideo(url, go) {
		$('#title-video').html(go);
		$.ajax({
			type: "POST",
			url: "utilidadess.php",
			data: {
				url: url,
				Accion: 'get-video'
			}
		}).done(function(msg) {
			$('#videohtml').html(msg);
			$('#video-modal').modal('show');
		});
	}

	function alertbootstrap2(tittle, content, type, icon, Id, btngo = '') {
		if (Id == 'alertspan') {
			document.getElementById("fixed-sup").style.display = "block";
		}
		if (btngo == 'login') {
			var button = '<button onclick="inicios();" type="button" class="btn btn-outline-caja"><i class="mx-auto bx bx-user fs-4 text-color-caja text-outline-caja"></i></button>';
		}
		if (btngo == '') {
			var button = '';
		}
		$("#" + Id).html('<div class="bg-light alert border  rounded-2 border-3 border-' + type + ' alert-dismissible fade show py-2">' +
			'<div class="d-flex align-items-center">' +
			'<div class="ms-3">' +
			'<h6 class="mb-0 text-' + type + '" ><i class="' + icon + ' text-' + type + ' "></i> <strong>' + tittle + '</strong></h6>' +
			'<div id="content" class="text-' + type + '" >' + content + '</div>' +
			button +
			'</div>' +
			'</div>' +
			'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
			'</div>');
		var element = document.getElementById(Id);

		setTimeout(() => element.scrollIntoView({
			block: "end",
			behavior: "smooth"
		}), 100);

		if (Id == 'alertspan') {
			setTimeout(() => $("#" + Id).html(''), 4500);
			setTimeout(() => document.getElementById("fixed-sup").style.display = "none", 4500);
		}
		setTimeout(() => $("#" + Id).html(''), 30000);
	}

	function kick() {
		///app.php?sesion=0
		window.location = "?sesion=0";
	}

	function funcionaploz() {
		var timeap = '<?php echo $_SESSION["timeaplicadofeclic"]; ?>';
		var constan = '<?php echo $_SESSION['constante']; ?>';
		if (constan != '') {
			if (timeap == 'day') {
				var dias = '<?php echo $_SESSION['DiasAVencer']; ?>';
				if (dias <= 5) {
					if (dias <= 0) {
						$('#modal-vencemiento2').modal('show');
					} else {
						if (constan == 0) {
							var inicio = '<?php echo $_SESSION['ControlInicioSession']; ?>';

							if (inicio == 1) {
								$('#modal-vencemiento').modal('show');
							}
						}

						if (constan == 1) {
							$('#modal-vencemiento').modal('show');
						}
					}
				}
			}

			if (timeap == 'hour') {
				var hour = '<?php echo $_SESSION['DiasAVencer']; ?>';
				if (hour <= 24) {
					if (hour <= 0) {
						$('#modal-vencemiento2').modal('show');
					} else {
						if (constan == 0) {
							var inicio = '<?php echo $_SESSION['ControlInicioSession']; ?>';

							if (inicio == 1) {
								$('#modal-vencemiento').modal('show');
							}
						}

						if (constan == 1) {
							$('#modal-vencemiento').modal('show');
						}
					}
				}
			}

			if (timeap == 'Min') {
				var Min = '<?php echo $_SESSION['DiasAVencer']; ?>';
				if (Min <= 60) {
					if (Min <= 0) {
						$('#modal-vencemiento2').modal('show');
					} else {
						if (constan == 0) {
							var inicio = '<?php echo $_SESSION['ControlInicioSession']; ?>';

							if (inicio == 1) {
								$('#modal-vencemiento').modal('show');
							}
						}

						if (constan == 1) {
							$('#modal-vencemiento').modal('show');
						}
					}
				}
			}

		}
	}

	function setcolorbg() {

		var $bg = $('#bgmenu');
		if (!$bg.length) { 
			// Si no existe bgmenu, no rompas el resto del app
			funcionaploz();
			return;
		}

		var rgb = $bg.css('backgroundColor') || '';
		var colors = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);

		// Si no matchea rgb(...), evita el crash
		if (!colors || colors.length < 4) {
			funcionaploz();
			return;
		}

		var brightness = 2;
		var r = parseInt(colors[1], 10);
		var g = parseInt(colors[2], 10);
		var b = parseInt(colors[3], 10);

		var ir = Math.floor((255 - r) * brightness);
		var ig = Math.floor((255 - g) * brightness);
		var ib = Math.floor((255 - b) * brightness);

		$bg.css('color', 'rgb(' + ir + ',' + ig + ',' + ib + ')');
		funcionaploz();
	}

</script>


<body id="body-main" style="background-color:#FFFFF7; height: 100% !important;">
	<div class='d-none d-print-block p-0 m-0' style="height: 100% !important;" id="prints"></div>
	<span class='d-print-none '>
		<div class="fixed-top d-print-none" id='maintop' style='padding-top:50px; z-index:10000; display:none'>
			<div class="col-12 col-sm-4 float-end">
				<div id="exito" class="alert alert-success" role="alert" style="display:none; ">
					<strong><i class="fa fa-check-circle"></i> <?php echo lang('Guardado con exito'); ?></strong><br><?php echo lang('Tu informacion ha sido guardada correctamente.'); ?>
				</div>
			</div>
			<div class="col-12 col-sm-4 float-end">
				<div id="fracaso" class="alert alert-danger" role="alert" style="display:none; ">
					<strong><i class="fa fa-times-circle"></i> <?php echo lang('Error al guardar'); ?></strong><br><?php echo lang('Se ha producido un error durante el guardado.'); ?>
				</div>
			</div>
		</div>


		<div id='loading' class='app-ui-mask-modal d-print-none' style='background: rgba(0, 0, 0, 0.28); width:100%; height:100%; z-index:10001; display: none; position: fixed;  left: 0;align-items: center;justify-content: center; '>
			<div class="text-center">
				<div class="spinner-border" role="status">
					<span class="visually-hidden">Loading...</span>
				</div>
			</div>
		</div>

		<!-- <div id='header-menu' class="fixed-top d-print-none"> -->
		<div id='header-menu' class=" d-print-none">
			<nav class="navbar navbar-expand-lg d-flex justify-content-between">
				<div class="container-fluid">
					<!--<a class="navbar-brand fw-bold" href="app.php?opcion=dashboard.php&m=dash">-->
					<div>
						<div><i><img src="/img/BLANCO.svg" width="100px" /></i></div>
						<div class="text-center"><small class="text-light">Ver. <?php echo $VersionS; ?> </small></div>
					</div>
					<!--</a>-->

					<input style='display:none' type="text" class="form-control" id="mobil" name="mobil" value='0' />
					<div class="collapse navbar-collapse">
						<ul class="navbar-nav me-auto mb-2 mb-lg-0">
							<?php
							$n = "nav-item d-flex";
							include "menu.php";
							?>
						</ul>
					</div>
					<div class="btn-group dropdown">
						<button type="button" class="btn btn-standar dropdown-toggle text-light" data-bs-toggle="dropdown" aria-expanded="false">
							<img src="<?php echo $urls; ?>" alt="mdo" style="max-width:1rem;" class="rounded-circle">

							<span style="font-size:0.8rem;font-weight: 600;letter-spacing: 0.6px;"><?php echo " " . $usernombre . " <br class='d-sm-block d-md-none'> <span style='font-size:0.8rem;font-weight: 600;letter-spacing: 0.6px;' class='badge bg-success m-1' >" . $userperfilnombre . "</badge> "; ?></span>
						</button>
						<ul class="dropdown-menu">
							<li><a class="dropdown-item text-light <? echo ($opcion == 'perfiluser.php' or 'perfiluser' == $ModuloActual ? 'active' : ''); ?>" href="app.php?opcion=perfiluser.php&m=perfiluser"><i><img src="/img/profile.png" style="max-width:1rem;"></i> <?php echo lang('Perfil'); ?></a></li>
							<li><a class="dropdown-item text-light" onclick='soporte();'><i><img src="img/ticket.png" style="max-width:1rem;" /></i> <?php echo lang('Ticket') ?></a></li>
							<li>
								<hr class="dropdown-divider">
							</li>
							<!-- <li><a class="dropdown-item text-light" href="/"><button onclick="soporte();" class="btn-flotante pull-right"><img src="soportetecnico.png" width="100" height="40"></button></li>
                                <li><hr class="dropdown-divider"></li> -->
							<li><a class="dropdown-item text-light" href="/logout.php"><i><img src="/img/logout.png" style="max-width:1rem;"></i> <?php echo lang('Desconectar'); ?></a></li>
						</ul>
					</div>
				</div>
			</nav>
		</div>
		<span class="d-none" id="NameCompanyActual" name="NameCompanyActual"><?php echo $_SESSION["NameCompanyActual"] ?? ''; ?></span>
		<span class="d-none" id="IdCompanyGrp" name="IdCompanyGrp"><?php echo $_SESSION["IdCompanyGrp"] ?? ''; ?></span>
		<span class="d-none" id="MontoMayorMoneda" name="MontoMayorMoneda"><?php echo $_SESSION["MontoMayorMoneda"] ?? 0; ?></span>
		<span class="d-none" id="MontoMenorMoneda" name="MontoMenorMoneda"><?php echo $_SESSION["MontoMenorMoneda"] ?? 0; ?></span>
		<span class="d-none" id="PermiteCredito" name="PermiteCredito"><?php echo $_SESSION["PermiteCredito"] ?? ''; ?></span>
		<span class="d-none" id="CIdPlan" name="CIdPlan"><?php echo $_SESSION["CIdPlan"] ?? ''; ?></span>
		<span class="d-none" id="IdUbicVta" name="IdUbicVta"><?php echo $_SESSION["IdUbicVta"] ?? ''; ?></span>
		<span class="d-none" id="RecalPrice" name="RecalPrice"><?php echo $_SESSION["RecalPrice"] ?? ''; ?></span>
		<span class="d-none" id="MonedaP" name="MonedaP"><?php echo $_SESSION["MonedaP"] ?? ''; ?></span>
		<span class="d-none" id="LitPrincipalEfectivo" name="LitPrincipalEfectivo"><?php echo $_SESSION["LitPrincipalEfectivo"] ?? ''; ?></span>
		<span class="d-none" id="SimMil" name="SimMil"><?php echo $_SESSION["SimMil"] ?? ''; ?></span>
		<span class="d-none" id="SimDec" name="SimDec"><?php echo $_SESSION["SimDec"] ?? ''; ?></span>
		<span class="d-none" id="CD" name="CD"><?php echo $_SESSION["CD"] ?? ''; ?></span>
		<span class="d-none" id="CTBIdCompany" name="CD"><?php echo $_SESSION["CTBIdCompany"] ?? ''; ?></span>
		<span class="d-none" id="userperfil" name="userperfil"><?php echo $_SESSION["userperfil"] ?? ''; ?></span>
		<span class="d-none" id="litfiscal" name="litfiscal"><?php echo $_SESSION["litfiscal"] ?? ''; ?></span>
		<span class="d-none" id="CTBlitfiscal" name="CTBlitfiscal"><?php echo $_SESSION["CTBlitfiscal"] ?? ''; ?></span>
		<span class="d-none" id="CTBPeriodo" name="CTBPeriodo"><?php echo $_SESSION["CTBPeriodo"] ?? ''; ?></span>
		<span class="d-none" id="CTBOrigen" name="CTBOrigen"><?php echo $_SESSION["CTBOrigen"] ?? ''; ?></span>
		<span class="d-none" id="CTBIdEmpresa" name="CTBIdEmpresa"><?php echo $_SESSION["CTBIdEmpresa"] ?? ''; ?></span>
		<span class="d-none" id="CTBcomercio" name="CTBcomercio"><?php echo $_SESSION["CTBcomercio"] ?? ''; ?></span>
		<span class="d-none" id="CTBidfiscal" name="CTBidfiscal"><?php echo $_SESSION["CTBidfiscal"] ?? ''; ?></span>
		<span class="d-none" id="ruteAcx" name="ruteAcx"><?php echo $_SESSION["rute"] ?? ''; ?></span>
		<span class="d-none" id="CompanyActual" name="CompanyActual"><?php echo $_SESSION["CompanyActual"] ?? ''; ?></span>
		<span class="d-none" id="TokenEstacion" name="TokenEstacion"><?php echo $_SESSION["TokenEstacion"] ?? ''; ?></span>
		<span class="d-none" id="TokenAsociada" name="TokenAsociada"><?php echo $_SESSION["TokenAsociada"] ?? ''; ?></span>
		<span class="d-none" id="PVenderMenorCosto" name="PVenderMenorCosto"><?php echo $_SESSION["PerVenderMenorCosto"] ?? ''; ?></span>
		<span class="d-none" id="TokenSeleccionado" name="TokenSeleccionado"><?php echo $_SESSION["TokenSeleccionado"] ?? ''; ?></span>
		<span class="d-none" id="VisualizaPrecioAct" name="VisualizaPrecioAct"><?php echo $_SESSION["VisualizaPrecio"] ?? ''; ?></span>
		<span class="d-none" id="direccionActSe" name="direccionActSe"><?php echo $_SESSION["direccion"]; ?></span>
		<span class="d-none" id="NameCompany" name="NameCompany"><?php echo $_SESSION["NameCompany"] ?? ''; ?></span>
		<span class="d-none" id="FactorDolarCash" name="FactorDolarCash"><?php echo $_SESSION["FactorDolarCash"] ?? ''; ?></span>
		<span class="d-none" id="MonedaS" name="MonedaS"><?php echo $_SESSION["MonedaS"] ?? ''; ?></span>
		<span class="d-none" id="correorep" name="correorep"><?php echo $_SESSION["correorep"] ?? ''; ?></span>
		<span class="d-none" id="IdAlmVta" name="IdAlmVta"><?php echo $_SESSION["IdAlmVta"]  ?? ''; ?></span>
		<span class="d-none" id="IdAlmGroup" name="IdAlmGroup"><?php echo $_SESSION["IdAlmGroup"]  ?? ''; ?></span>
		<span class="d-none" id="VerStock" name="VerStock"><?php echo $_SESSION["VerStock"]  ?? ''; ?></span>
		<span class="d-none" id="IdAlmVtaSeleccionada" name="IdAlmVtaSeleccionada"><?php echo $_SESSION["IdAlmVtaSeleccionada"]  ?? ''; ?></span>
		<span class="d-none" id="AlmacenP" name="AlmacenP"><?php echo $_SESSION["AlmacenP"]  ?? ''; ?></span>
		<span class="d-none" id="ventactualAct" name="ventactualAct"><?php echo $_SESSION['ventactual']  ?? ''; ?></span>
		<span class="d-none" id="CajaActual" name="CajaActual"><?php echo $_SESSION["CajaActual"]  ?? ''; ?></span>
		<span class="d-none" id="IdPaisAct" name="IdPaisAct"><?php echo $_SESSION['IdPais']  ?? ''; ?></span>
		<span class="d-none" id="userlogin" name="userlogin"><?php echo $_SESSION["userlogin"]  ?? ''; ?></span>
		<span class="d-none" id="userCompany" name="userCompany"><?php echo $_SESSION["userCompany"]  ?? ''; ?></span>
		<span class="d-none" id="LitEfectivo" name="LitEfectivo"><?php echo $_SESSION["LitEfectivo"]  ?? ''; ?></span>
		<span class="d-none" id="LitTarjeta" name="LitTarjeta"><?php echo $_SESSION["LitTarjeta"]  ?? ''; ?></span>
		<span class="d-none" id="LitCheque" name="LitCheque"><?php echo $_SESSION["LitCheque"]  ?? ''; ?></span>
		<span class="d-none" id="usernombre" name="usernombre"><?php echo $_SESSION["usernombre"]  ?? ''; ?></span>
		<span class="d-none" id="LogotipoSpan" name="LogotipoSpan"><?php echo $_SESSION["Logotipo"]  ?? ''; ?></span>
		<span class="d-none" id="ImpCBDescSpan" name="ImpCBDescSpan"><?php echo $_SESSION["ImpCBDesc"]  ?? ''; ?></span>
		<span class="d-none" id="LitO01" name="LitO01"><?php echo $_SESSION["LitO01"]  ?? ''; ?></span>
		<span class="d-none" id="LitO02" name="LitO02"><?php echo $_SESSION["LitO02"]  ?? ''; ?></span>
		<span class="d-none" id="LitO03" name="LitO03"><?php echo $_SESSION["LitO03"]  ?? ''; ?></span>
		<span class="d-none" id="LitO04" name="LitO04"><?php echo $_SESSION["LitO04"]  ?? ''; ?></span>
		<span class="d-none" id="CheckVenta" name="CheckVenta"><?php echo $_SESSION["CheckVenta"]  ?? ''; ?></span>
		<span class="d-none" id="PerfilVentas" name="PerfilVentas"><?php echo $_SESSION["PerfilVentas"]  ?? ''; ?></span>
		<span class="d-none" id="EleccionEc" name="EleccionEc"><?php echo $_SESSION["Ec"]  ?? ''; ?></span>
		<span class="d-none" id="sucursal" name="sucursal"><?php echo $_SESSION["sucursal"] ?? ''; ?></span>
		<span class="d-none" id="ObligarUsoDeBanco" name='ObligarUsoDeBanco'><?php echo $_SESSION["Obgbanco"]  ?? ''; ?></span>
		<span class="d-none" id="IdiomaActual" name='IdiomaActual'><?php echo $_SESSION["IdiomaActual"] ?? ''; ?></span>
		<span class="d-none" id="NumTxViewVTA" name='NumTxViewVTA'><?php echo $_SESSION["NumTxViewVTA"] ?? 1; ?></span>
		<span class="d-none" id="NumTxViewCOM" name='NumTxViewCOM'><?php echo $_SESSION["NumTxViewCOM"] ?? 1; ?></span>
		<span class="d-none" id="NumTxViewINV" name='NumTxViewINV'><?php echo $_SESSION["NumTxViewINV"] ?? 1; ?></span>
		<span class="d-none" id="p0" name="p0"><?php echo $PerfilVentas[0] ?? ''; ?></span>
		<span class="d-none" id="p1" name="p1"><?php echo $PerfilVentas[1] ?? ''; ?></span>
		<span class="d-none" id="p2" name="p2"><?php echo $PerfilVentas[2] ?? ''; ?></span>
		<span class="d-none" id="p3" name="p3"><?php echo $PerfilVentas[3] ?? ''; ?></span>
		<span class="d-none" id="c0" name="c0"><?php echo $PerfilVentas[4] ?? ''; ?></span>
		<span class="d-none" id="u1" name="u1"><?php echo $PerfilVentas[5] ?? ''; ?></span>
		<span class="d-none" id="u2" name="u2"><?php echo $PerfilVentas[6] ?? ''; ?></span>
		<span class="d-none" id="u3" name="u3"><?php echo $PerfilVentas[7] ?? ''; ?></span>
		<span class="d-none" id="u4" name="u4"><?php echo $PerfilVentas[9] ?? ''; ?></span>
		<span class="d-none" id="p4" name="p4"><?php echo $PerfilVentas[10] ?? ''; ?></span>
		<span class="d-none" id="u5" name="u5"><?php echo $PerfilVentas[12] ?? ''; ?></span>
		<span class="d-none" id="p5" name="p5"><?php echo $PerfilVentas[13] ?? ''; ?></span>
		<span class="d-none" id="u6" name="u6"><?php echo $PerfilVentas[14] ?? ''; ?></span>
		<span class="d-none" id="p6" name="p6"><?php echo $PerfilVentas[15] ?? ''; ?></span>
		<span class="d-none" id="u7" name="u7"><?php echo $PerfilVentas[16] ?? ''; ?></span>
		<span class="d-none" id="p7" name="p7"><?php echo $PerfilVentas[17] ?? ''; ?></span>
		<span class="d-none" id="u8" name="u8"><?php echo $PerfilVentas[18] ?? ''; ?></span>
		<span class="d-none" id="p8" name="p8"><?php echo $PerfilVentas[19] ?? ''; ?></span>
		<span class="d-none" id="u9" name="u9"><?php echo $PerfilVentas[20] ?? ''; ?></span>
		<span class="d-none" id="p9" name="p9"><?php echo $PerfilVentas[21] ?? ''; ?></span>
		<span class="d-none" id="u10" name="u10"><?php echo $PerfilVentas[22] ?? ''; ?></span>
		<span class="d-none" id="p10" name="p10"><?php echo $PerfilVentas[23] ?? ''; ?></span>
		<span class="d-none" id="Tasa" name='Tasa'><?php echo $_SESSION["Tasa"]  ?? ''; ?></span>
		<span class="d-none" id="MVaria" name='MVaria'><?php echo $_SESSION["MVaria"]  ?? ''; ?></span>
		<span class="d-none" id="ImpFacBol" name='ImpFacBol'><?php echo $_SESSION["ImpFacBol"]  ?? ''; ?></span>
		<span class="d-none" id="ImpEstacionS" name="ImpEstacionS"><?php echo $_SESSION["ImpEstacion"] ?? ''; ?></span>
		<span class="d-none" id="AlmacenesAtt" name="AlmacenesAtt"><?php echo $_SESSION["AlmacenesAtt"] ?? '0'; ?></span>
		<span class="d-none" id="IdAttx" name="IdAttx"><?php echo $_SESSION["IdAtt"] ?? '0'; ?></span>
		<span class="d-none" id="DateFormat" name="DateFormat"><?php echo $_SESSION["DateFormat"] ?? ''; ?></span>
		<span class="d-none" id="HourFormat" name="HourFormat"><?php echo $_SESSION["HourFormat"] ?? ''; ?></span>
		<span class="d-none" id="TemporalFactura" name="TemporalFactura"><?php echo $_SESSION["TemporalFactura"] ?? ''; ?></span>
		<span class="d-none" id="UnidosoDesunidos" name="UnidosoDesunidos"><?php echo $PerfilVentas[8]; ?></span>
		<span class="d-none" id="IdEstacionEnviabl" name="IdEstacionEnviabl"><?php echo "(" . $_SESSION["CompanyActual"] . ")" . "(" . $_SESSION["userCompany"] . ")" . "(" . $_SESSION["userlogin"] . ")"; ?></span>
		<span class="d-none" id="decisions" name="decisions">0</span>
		<span class="d-none" id="ValNewCompany" name="ValNewCompany"><?php echo $_SESSION["Preguntar"]  ?? ''; ?></span>
		<span class="d-none" id="FechaActualAPP" name="FechaActualAPP"><?php echo $_SESSION["fechaActual"]  ?? ''; ?></span>
		<span class="d-none" id="CodContable" name="CodContable"><?php echo $_SESSION["CodContable"]  ?? ''; ?></span>
		<span class="d-none" id="Account" name="Account"><?php echo $_SESSION["Account"]  ?? ''; ?></span>
		<span class="d-none" id="Account_Number" name="Account_Number"><?php echo $_SESSION["Account_Number"]  ?? ''; ?></span>
		<span class="d-none" id="Id_Accountxaq2" name="Id_Accountxaq2"><?php echo $_SESSION["Id_Account"]  ?? ''; ?></span>

		<?php
		$conn = conectar2();
		//Cargando VARIABLES DE Nivel USUARIO
		$query = "SELECT a.* from PosUpUsersNivel a where a.Id='" . $_SESSION["userperfil"] . "'";
		//echo $query;
		if ($result = mysqli_query($connsultas, $query)) {
			while ($row = mysqli_fetch_assoc($result)) {
				$_SESSION["PerfilVentasNivel"] = $row['p0'] . ',' . $row['p1'] . ',' . $row['p2'] . ',' . $row['p3'] . ',' . $row['c0'] . ',' . $row['u1'] . ',' . $row['u2'] . ',' . $row['u3'] . ',' . $row['PrecioUnidad'] . ',' . $row['u4'] . ',' . $row['p4'] . ',' . $row['u5'] . ',' . $row['p5'] . ',' . $row['u6'] . ',' . $row['p6'] . ',' . $row['u7'] . ',' . $row['p7'] . ',' . $row['u8'] . ',' . $row['p8'] . ',' . $row['u9'] . ',' . $row['p9'] . ',' . $row['u10'] . ',' . $row['p10'];
			}
			mysqli_free_result($result);
		}
		$Compani = 0;
		$query = "SELECT * from PosUpWebConfig where IdCompany='" . $_SESSION["CompanyActual"] . "'";
		if ($result = mysqli_query($connsultas, $query)) {
			while ($row = mysqli_fetch_assoc($result)) {
				$Compani = 1;
			}
			mysqli_free_result($result);
		}
		if ($Compani == 0) {
			$sql = "insert into PosUpWebConfig (IdCompany, IdUbi) values (" . $_SESSION['CompanyActual'] . ",'0')";
			$stmt = mysqli_query($conn, $sql);
			mysqli_free_result($stmt);
		}

		//Cargando VARIABLES DE USUARIO
		$query = "SELECT a.*
		from PosUpCompanyEstacion a 
		where a.token='" . $_SESSION["TokenSeleccionado"] . "'";
		if ($result = mysqli_query($connsultas, $query)) {
			while ($row = mysqli_fetch_assoc($result)) {
				$_SESSION["CajaActual"] = $row["CajaActual"];
				$_SESSION["CajaNombre"] = $row["etiqueta"];
				$_SESSION["tipoestacion"] = $row["tipoestacion"];
				$_SESSION["AlmacenesAtt"] = $row["IdAtt"];
				$PerfilVentasComercio = array();
				$PerfilVentasNivel = array();
				$PerfilVentasUser = array();
				$_SESSION["PerfilVentasEstacion"] = $row['p0'] . ',' . $row['p1'] . ',' . $row['p2'] . ',' . $row['p3'] . ',' . $row['c0'] . ',' . $row['u1'] . ',' . $row['u2'] . ',' . $row['u3'] . ',' . $row['valiv1'] . ',' . $row['PrecioUnidad'] . ',' . $row['u4'] . ',' . $row['p4'] . ',' . $row['u5'] . ',' . $row['p5'] . ',' . $row['u6'] . ',' . $row['p6'] . ',' . $row['u7'] . ',' . $row['p7'] . ',' . $row['u8'] . ',' . $row['p8'] . ',' . $row['u9'] . ',' . $row['p9'] . ',' . $row['u10'] . ',' . $row['p10'];

				$PerfilVentasComercio = explode(",", $_SESSION["PerfilVentasComercio"]);
				$PerfilVentasNivel = explode(",", $_SESSION["PerfilVentasNivel"]);
				$PerfilVentasUser = explode(",", $_SESSION["PerfilVentasUser"]);
				$PerfilVentasEstacion = explode(",", $_SESSION["PerfilVentasEstacion"]);


				$PerfilVentas = ($PerfilVentasComercio[0] = '1' ? $PerfilVentasNivel[0] : $PerfilVentasComercio[0]) . "," .
					($PerfilVentasComercio[1] = '1' ? $PerfilVentasNivel[1] : $PerfilVentasComercio[1]) . "," .
					($PerfilVentasComercio[2] = '1' ? $PerfilVentasNivel[2] : $PerfilVentasComercio[2]) . "," .
					($PerfilVentasComercio[3] = '1' ? $PerfilVentasNivel[3] : $PerfilVentasComercio[3]) . "," .
					($PerfilVentasComercio[4] = '1' ? $PerfilVentasNivel[4] : $PerfilVentasComercio[4]) . "," .
					($PerfilVentasComercio[5] = '1' ? $PerfilVentasNivel[5] : $PerfilVentasComercio[5]) . "," .
					($PerfilVentasComercio[6] = '1' ? $PerfilVentasNivel[6] : $PerfilVentasComercio[6]) . "," .
					($PerfilVentasComercio[7] = '1' ? $PerfilVentasNivel[7] : $PerfilVentasComercio[7]) . "," .
					($PerfilVentasComercio[8] = '1' ? $PerfilVentasNivel[8] : $PerfilVentasComercio[8]) . "," .
					($PerfilVentasComercio[9] = '1' ? $PerfilVentasNivel[9] : $PerfilVentasComercio[9]) . "," .
					($PerfilVentasComercio[10] = '1' ? $PerfilVentasNivel[10] : $PerfilVentasComercio[10]) . ',P,' .
					($PerfilVentasComercio[11] = '1' ? $PerfilVentasNivel[11] : $PerfilVentasComercio[11]) . "," .
					($PerfilVentasComercio[12] = '1' ? $PerfilVentasNivel[12] : $PerfilVentasComercio[12]) . "," .
					($PerfilVentasComercio[13] = '1' ? $PerfilVentasNivel[13] : $PerfilVentasComercio[13]) . "," .
					($PerfilVentasComercio[14] = '1' ? $PerfilVentasNivel[14] : $PerfilVentasComercio[14]) . "," .
					($PerfilVentasComercio[15] = '1' ? $PerfilVentasNivel[15] : $PerfilVentasComercio[15]) . "," .
					($PerfilVentasComercio[16] = '1' ? $PerfilVentasNivel[16] : $PerfilVentasComercio[16]) . "," .
					($PerfilVentasComercio[17] = '1' ? $PerfilVentasNivel[17] : $PerfilVentasComercio[17]) . "," .
					($PerfilVentasComercio[18] = '1' ? $PerfilVentasNivel[18] : $PerfilVentasComercio[18]) . "," .
					($PerfilVentasComercio[19] = '1' ? $PerfilVentasNivel[19] : $PerfilVentasComercio[19]) . "," .
					($PerfilVentasComercio[20] = '1' ? $PerfilVentasNivel[20] : $PerfilVentasComercio[20]) . "," .
					($PerfilVentasComercio[21] = '1' ? $PerfilVentasNivel[21] : $PerfilVentasComercio[21]) . "," .
					($PerfilVentasComercio[22] = '1' ? $PerfilVentasNivel[22] : $PerfilVentasComercio[22]);


				if ($PerfilVentasUser[8] == '1') {
					$PerfilVentas = ($PerfilVentasComercio[0] = '1' ? $PerfilVentasUser[0] : $PerfilVentasComercio[0]) . "," .
						($PerfilVentasComercio[1] = '1' ? $PerfilVentasUser[1] : $PerfilVentasComercio[1]) . "," .
						($PerfilVentasComercio[2] = '1' ? $PerfilVentasUser[2] : $PerfilVentasComercio[2]) . "," .
						($PerfilVentasComercio[3] = '1' ? $PerfilVentasUser[3] : $PerfilVentasComercio[3]) . "," .
						($PerfilVentasComercio[4] = '1' ? $PerfilVentasUser[4] : $PerfilVentasComercio[4]) . "," .
						($PerfilVentasComercio[5] = '1' ? $PerfilVentasUser[5] : $PerfilVentasComercio[5]) . "," .
						($PerfilVentasComercio[6] = '1' ? $PerfilVentasUser[6] : $PerfilVentasComercio[6]) . "," .
						($PerfilVentasComercio[7] = '1' ? $PerfilVentasUser[7] : $PerfilVentasComercio[7]) . "," .
						($PerfilVentasComercio[8] = '1' ? $PerfilVentasUser[9] : $PerfilVentasComercio[8]) . "," .
						($PerfilVentasComercio[9] = '1' ? $PerfilVentasUser[10] : $PerfilVentasComercio[9]) . "," .
						($PerfilVentasComercio[10] = '1' ? $PerfilVentasUser[11] : $PerfilVentasComercio[10]) . ',U,' .
						($PerfilVentasComercio[11] = '1' ? $PerfilVentasUser[12] : $PerfilVentasComercio[11]) . "," .
						($PerfilVentasComercio[12] = '1' ? $PerfilVentasUser[13] : $PerfilVentasComercio[12]) . "," .
						($PerfilVentasComercio[13] = '1' ? $PerfilVentasUser[14] : $PerfilVentasComercio[13]) . "," .
						($PerfilVentasComercio[14] = '1' ? $PerfilVentasUser[15] : $PerfilVentasComercio[14]) . "," .
						($PerfilVentasComercio[15] = '1' ? $PerfilVentasUser[16] : $PerfilVentasComercio[15]) . "," .
						($PerfilVentasComercio[16] = '1' ? $PerfilVentasUser[17] : $PerfilVentasComercio[16]) . "," .
						($PerfilVentasComercio[17] = '1' ? $PerfilVentasUser[18] : $PerfilVentasComercio[17]) . "," .
						($PerfilVentasComercio[18] = '1' ? $PerfilVentasUser[19] : $PerfilVentasComercio[18]) . "," .
						($PerfilVentasComercio[19] = '1' ? $PerfilVentasUser[20] : $PerfilVentasComercio[19]) . "," .
						($PerfilVentasComercio[20] = '1' ? $PerfilVentasUser[21] : $PerfilVentasComercio[20]) . "," .
						($PerfilVentasComercio[21] = '1' ? $PerfilVentasUser[22] : $PerfilVentasComercio[21]) . "," .
						($PerfilVentasComercio[22] = '1' ? $PerfilVentasUser[23] : $PerfilVentasComercio[22]);
				}
				if ($PerfilVentasEstacion[8] == '1') {
					$PerfilVentas =
						($PerfilVentasComercio[0] = '1' ? $PerfilVentasEstacion[0] : $PerfilVentasComercio[0]) . "," .
						($PerfilVentasComercio[1] = '1' ? $PerfilVentasEstacion[1] : $PerfilVentasComercio[1]) . "," .
						($PerfilVentasComercio[2] = '1' ? $PerfilVentasEstacion[2] : $PerfilVentasComercio[2]) . "," .
						($PerfilVentasComercio[3] = '1' ? $PerfilVentasEstacion[3] : $PerfilVentasComercio[3]) . "," .
						($PerfilVentasComercio[4] = '1' ? $PerfilVentasEstacion[4] : $PerfilVentasComercio[4]) . "," .
						($PerfilVentasComercio[5] = '1' ? $PerfilVentasEstacion[5] : $PerfilVentasComercio[5]) . "," .
						($PerfilVentasComercio[6] = '1' ? $PerfilVentasEstacion[6] : $PerfilVentasComercio[6]) . "," .
						($PerfilVentasComercio[7] = '1' ? $PerfilVentasEstacion[7] : $PerfilVentasComercio[7]) . "," .
						($PerfilVentasComercio[8] = '1' ? $PerfilVentasEstacion[9] : $PerfilVentasComercio[8]) . "," .
						($PerfilVentasComercio[9] = '1' ? $PerfilVentasEstacion[10] : $PerfilVentasComercio[9]) . "," .
						($PerfilVentasComercio[10] = '1' ? $PerfilVentasEstacion[11] : $PerfilVentasComercio[10]) . ',E,' .
						($PerfilVentasComercio[11] = '1' ? $PerfilVentasEstacion[12] : $PerfilVentasComercio[11]) . "," .
						($PerfilVentasComercio[12] = '1' ? $PerfilVentasEstacion[13] : $PerfilVentasComercio[12]) . "," .
						($PerfilVentasComercio[13] = '1' ? $PerfilVentasEstacion[14] : $PerfilVentasComercio[13]) . "," .
						($PerfilVentasComercio[14] = '1' ? $PerfilVentasEstacion[15] : $PerfilVentasComercio[14]) . "," .
						($PerfilVentasComercio[15] = '1' ? $PerfilVentasEstacion[16] : $PerfilVentasComercio[15]) . "," .
						($PerfilVentasComercio[16] = '1' ? $PerfilVentasEstacion[17] : $PerfilVentasComercio[16]) . "," .
						($PerfilVentasComercio[17] = '1' ? $PerfilVentasEstacion[18] : $PerfilVentasComercio[17]) . "," .
						($PerfilVentasComercio[18] = '1' ? $PerfilVentasEstacion[19] : $PerfilVentasComercio[18]) . "," .
						($PerfilVentasComercio[19] = '1' ? $PerfilVentasEstacion[20] : $PerfilVentasComercio[19]) . "," .
						($PerfilVentasComercio[20] = '1' ? $PerfilVentasEstacion[21] : $PerfilVentasComercio[20]) . "," .
						($PerfilVentasComercio[21] = '1' ? $PerfilVentasEstacion[22] : $PerfilVentasComercio[21]) . "," .
						($PerfilVentasComercio[22] = '1' ? $PerfilVentasEstacion[23] : $PerfilVentasComercio[22]);
				}
				//echo 'Perfil Final: '.$PerfilVentas.'</br>';
				$_SESSION["PerfilVentas"] = $PerfilVentas;
				$PerfilVentas = explode(",", $_SESSION["PerfilVentas"]) ?? '';

				if ($row["CajaActual"] == 0) {
					$Kinofkin = "(" . $PerfilVentas[11] . ") " . lang('CAJA CERRADA');
				} else {
					$Kinofkin = "(" . $PerfilVentas[11] . ") " . lang("CAJA ABIERTA No.") . $row["CajaActual"];
				}
			}
			mysqli_free_result($result);
		}
		?>
		<span class="d-none" id="part2" name="part2"><?php echo $_SESSION['CTBIdComprobante']; ?></span>
		<span class="d-none" id="CajaMostrar" name="CajaMostrar"><?php echo $Kinofkin; ?></span>
		<span class="d-none" id="validadorreload" name="validadorreload">0</span>
		<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
		<script src="jsdev/upload.js"></script>
		<script src="jsdev/slimscriptled.js"></script>
		<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.2/chart.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0/chartjs-plugin-datalabels.min.js"></script>


		<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.min.js"></script>
		<script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js'></script> -->
		<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->





		<!-- 		
            <link href="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.0.1/b-3.0.0/b-colvis-3.0.0/b-html5-3.0.0/b-print-3.0.0/datatables.min.css" rel="stylesheet">
		    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
		    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
		    <script src="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.0.1/b-3.0.0/b-colvis-3.0.0/b-html5-3.0.0/b-print-3.0.0/datatables.min.js"></script>
        -->
		<!-- Datatables -->
		<!-- CSS -->
		<link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.dataTables.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap5.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.0/css/buttons.dataTables.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.dataTables.min.css">
		<!-- JS -->
		<script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
		<script src="https://cdn.datatables.net/2.0.1/js/dataTables.min.js"></script>
		<!-- Buttons -->
		<script type="text/javascript" src="https://cdn.datatables.net/buttons/3.0.0/js/dataTables.buttons.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.html5.min.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.print.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.min.js"></script>


		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>

		<script src="
		https://cdn.jsdelivr.net/npm/offline-js@0.7.19/offline.min.js
		"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
		<!-- <script src="https://cdn.posuphost.net/index.js"></script> -->
		<script src="jsdev/general.js?v=<? echo random_int(1, 9999999); ?>"></script>

		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css" />

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.css" integrity="sha512-C7hOmCgGzihKXzyPU/z4nv97W0d9bv4ALuuEbSf6hm93myico9qa0hv4dODThvCsqQUmKmLcJmlpRmCaApr83g==" crossorigin="anonymous" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w==" crossorigin="anonymous" />
		<!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />


		<link rel="stylesheet" href="/css/slim.css">

		<link href="
		https://cdn.jsdelivr.net/npm/offline-js@0.7.19/themes/offline-theme-chrome.min.css
		" rel="stylesheet">
	</span>
	<!-- <section id='opcion-menu' class="main d-print-none" style="height: 100% !important;"> -->
	<section id='opcion-menu' class="d-print-none" style="height: 100% !important;">
		<div class="fixed-top " id='elfixed2' style='padding-top:50px;  z-index:10000; display:none;'>
			<div class="col-12 col-sm-6 col-md-5 col-lg-4 col-xl-3 float-end">
				<div id="validadanger" class="alert alert-danger" role="alert" style="display:none;">
					<span id="alertadanger"> </span>
				</div>
				<div id="validainfo" class="alert alert-info" role="alert" style="display:none;">
					<span id="alertainfo"></span>
				</div>
				<div id="validawarning" class="alert alert-warning" role="alert" style="display:none;">
				</div>
				<div id="validasuccess" class="alert alert-success" role="alert" style="display:none;">
					<span id="alertsuccess"></span>
				</div>
			</div>
		</div>
		<div class="fixed-top d-print-none" style="margin-top:50px; z-index:10000; display:none;" id="liveAlert"></div>

		<div id="NotificacionesPa" class="fixed-top " style='margin-top:50px; z-index:10000; '>
		</div>
		<?php
			$inc = $_SESSION["opcion"] ?? "";

			if ($inc === "") {
				include "dashboard.php";
			} else {

				// Normaliza a ruta local (misma carpeta de app.php)
				$try1 = __DIR__ . "/" . $inc;
				$try2 = $inc; // por si ya viene con ruta

				if (is_file($try1)) {
					include $try1;
				} elseif (is_file($try2)) {
					include $try2;
				} else {
					echo "<div class='container mt-3'>
							<div class='alert alert-danger'>
								<b>No se pudo incluir el módulo.</b><br>
								SESSION opcion: <code>" . htmlspecialchars($inc) . "</code><br>
								Probado: <code>" . htmlspecialchars($try1) . "</code><br>
								Probado: <code>" . htmlspecialchars($try2) . "</code><br>
								<hr>
								<b>Solución:</b> Llamar a Soporte <code>?opcion=</code>.
							</div>
						</div>";
				}
			}



		?>

	</section>
	<div id='footer-menu' class='d-print-none'>
		<footer id='bgmenu' style='background-color:<?php echo $bgcolor; ?>' class="footer fixed-bottom p-2 d-flex justify-content-between d-print-none">
			<div class='row' style="width: 85%; float:left; margin-left: 20px; padding: 1px;">
				<?php
				$url = "";
				if (trim($_SESSION["sucursal"]) <> "0") {
					$scanpath = scandir("Comercio/" . $_SESSION["CompanyActual"] . "/sucursal");
					if ($scanpath) {
						foreach ($scanpath as $item) {
							if ($item != '.' and $item != '..') {
								$file_name = explode(".", $item);
								$Mbooking_number = "sucursal" . $_SESSION["sucursal"];
								if ($file_name[0] == $Mbooking_number) {
									$url = "../Comercio/" . $_SESSION["CompanyActual"] . "/sucursal" . "/" . $item;
								}
							}
						}
					}
				}
				if (trim($url) == "") {
					$directorio_escaneado = scandir("Comercio/" . $_SESSION["CompanyActual"] . "/entorno");
					if ($directorio_escaneado) {
						foreach ($directorio_escaneado as $item) {
							if ($item != '.' and $item != '..') {
								$nnn = preg_split('/_/', $item);
								$Mbooking_number = "Logotipo";
								if ($nnn[0] == $Mbooking_number) {
									$_SESSION["Logotipo"] = "$item";
									$url = "../Comercio/" . $_SESSION["CompanyActual"] . "/entorno" . "/" . $item;
								}
							}
						}
					}
				}
				?>
				<div class='col-3 col-sm-2 col-md-1'>
					<?php
					$comercio = $_SESSION["CompanyActual"];
					$item = trim($_SESSION["Logotipo"]);
					$productos = "entorno";
					if ($url !== "") {

						echo "<img src='" . $url . "' width='48' height='48' >";
					} else if ($_SESSION["CompanyActual"] == 0) {
						echo "<img src='/img/ISO_AMARILLO.svg' width='32' height='48' >";
					} else {
						echo "<img src='/img/ISO_AMARILLO.svg' width='48' height='48' >";
					}

					function limitstringbr($cadena, $limite, $sufijo)
					{
						// Si la longitud es mayor que el límite...
						if (strlen($cadena) > $limite) {
							// Entonces corta la cadena y ponle el sufijo
							return substr($cadena, 0, $limite) . $sufijo . substr($cadena, $limite, strlen($cadena) - $limite);
						}

						// Si no, entonces devuelve la cadena normal
						return $cadena;
					}
					?>
				</div>
				<div class='col-9 col-sm-10 col-md-11'>
					<?
					if (trim($_SESSION["sucursal"]) <> "0") {
						$array = [];
						$queryss = "SELECT Nombre, Descripcion,	Telefono, Correo, IdenFiscal from posupubicacion where IdUbi='" . $_SESSION["sucursal"] . "' and IdCompany=" . $_SESSION["CompanyActual"];
						if ($resultss = mysqli_query($connsultas, $queryss)) {
							while ($rowss = mysqli_fetch_assoc($resultss)) {
								$array = [
									"Nombre" => $rowss["Nombre"],
									"Descripcion" => $rowss["Descripcion"],
									"Telefono" => $rowss["Telefono"],
									"Correo" => $rowss["Correo"],
									"IdenFiscal" => $rowss["IdenFiscal"],
								];
							}
							mysqli_free_result($resultss);
						}
					?>
						<span class="badge bg-light text-dark me-1"> <?php echo limitstringbr("" . $array["Nombre"] . "", 18, '<br class="d-block d-sm-none">') . " (" . $_SESSION['CompanyActual'] . ")"; ?> <img src="/img/<?php echo $_SESSION["IdPais"] ?>.png" width="16" height="16" /> </span>
						<br>

					<?php

					} else {
					?>
						<span class="badge bg-light text-dark me-1"> <?php echo limitstringbr("" . $_SESSION["NameCompanyActual"] . "", 18, '<br class="d-block d-sm-none">') . " (" . $_SESSION['CompanyActual'] . ")"; ?> <img src="/img/<?php echo $_SESSION["IdPais"] ?>.png" width="16" height="16" /> </span>
						<br>
					<?php
					}
					if ($_SESSION["userperfil"] <= 2000) {
						$sql = "SELECT * FROM PosUpProducto where IdCompany=0  and EsCompuesto=0  and CodIdBasico='" . $_SESSION["CIdPlan"] . "'";
						$resultp = mysqli_query($connsultas, $sql);
						$rowp = mysqli_fetch_assoc($resultp);
						mysqli_free_result($resultp);
					?>
						<span style="font-size:10px;" class="badge bg-success me-1"><?php echo $rowp['Descripcion']; ?> </span>
						<span style="font-size:10px;" class="badge bg-success me-1"><?php $date = date_create($_SESSION["feclic"]);
																					echo date_format($date, "d-m-y"); ?> </span>
						<span style="font-size:10px;" class="badge bg-danger me-1"><?php echo $_SESSION["DiasAVencer2"] . ' ' . lang('días'); ?> </span>

					<?
					} else {
					?>
						<span class="badge bg-light text-dark me-1"> <?php echo $_SESSION["litfiscal"] . ": " . (trim($_SESSION["sucursal"]) === "0" ? $_SESSION["IDFiscal"] : $array["IdenFiscal"]); ?> </span>

					<?
					}
					$ds = $_SESSION["userperfil"] === "4000" ? "display:none;" : "";
					?>
				</div>
			</div>
			<div class="btn-group dropup align-items-center gap-3" style="<?php echo $ds; ?>">
				<button id="toggleStarButton" class="btn" onclick="toggleStar()">
				</button>
				<button type="button" class="btn btn-standar dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
					<img src="/img/cohete.png" width="24">
				</button>
				<ul class="dropdown-menu" id="cocheteteam">
					<?php
					// $n = "dropdown-item";
					// include "useapp.php";
					?>
				</ul>
				<button type="button" class="btn btn-standar dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
					<img src="/img/menuprincipal.png" width="24">
				</button>
				<ul class="dropdown-menu">
					<?php
					$n = "dropdown-item";
					include "menu.php";
					?>
				</ul>
			</div>
		</footer>
	</div>
	<?php
	if ($_SESSION["timeaplicadofeclic"] == 'day') {
		if ($_SESSION["DiasAVencer"] <= 1) {
			$timepreci = lang("Día");
		} else {
			$timepreci = lang("Días");
		}
	}
	if ($_SESSION["timeaplicadofeclic"] == 'hour') {
		if ($_SESSION["DiasAVencer"] <= 1) {
			$timepreci = lang("Hora");
		} else {
			$timepreci = lang("Horas");
		}
	}
	if ($_SESSION["timeaplicadofeclic"] == 'Min') {
		if ($_SESSION["DiasAVencer"] <= 1) {
			$timepreci = lang("Minuto");
		} else {
			$timepreci = lang("Minutos");
		}
	}

	?>

	<div class="modal" id="Modal-DeCargandoProcess" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<img src="/img/procesando.gif" width="128" height="128" />
					<h4><?php echo Lang('Se Esta Cargando Un Proceso'); ?></h4>
					<br>
				</div>
			</div>
		</div>
	</div>
	<div id="modalStockMinimo" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?php echo lang('Productos con Existencia Baja'); ?></h5>
					<button data-bs-dismiss="modal" class="btn-close" type="button"></button>
				</div>
				<div class="modal-body">
					<div class="table-responsive">
						<table class="table table-hover table-striped nowrap" id="StockMinimotable" cellspacing="0" style="width:100%">
							<thead>
								<tr>
									<th><?php echo lang("Datos"); ?></th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-outline-secondary" data-bs-dismiss="modal" type="button"><i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?></button>
				</div>
			</div>
		</div>
	</div>
	<div id="modal-vencemiento" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-header">
					<h4 id='tittle'><?php echo lang('Su licencia esta por expirar'); ?></h4>
					<div class="card-actions">
						<div class='float-end'>
							<button data-bs-dismiss="modal" class='btn  btn-primary' type="button"><span class="fa fa-close"></span></button>
						</div>
					</div>
				</div>
				<div class="modal-body">
					<p><?php echo lang('Estimado usuario su licencia vencera en'); ?> <span style='color:red;'><?php echo  $_SESSION["DiasAVencer"]; ?> <?php echo lang($timepreci); ?> </span>, <?php echo lang(' para renovar su licencia o recibir información al respecto 
                        puede comunicarse a traves de'); ?>:
					</p>
					<a href="https://api.whatsapp.com/send?phone=<?php echo $_SESSION["AsesorWhatsapp"]; ?>&text=Hola%20Soy%20<?php echo $_SESSION['usernombre'] ?>,%20usuario%20de%20la%20empresa%20<?php echo $_SESSION['CompanyActual'] ?>%20<?php echo $_SESSION['NameCompany'] ?>,%20nuestra%20licencia%20esta%20por%20expirar%20el%20día%20<?php $date = date_create($_SESSION['feclic']);
																																																																																					echo date_format($date, "Y/m/d"); ?>,%20solo%20nos%20quedan%20<?php echo $_SESSION['DiasAVencer'] ?>%20días,%20Puede%20enviarme%20informacion%20del%20proceso%20de%20renovación"><i style='color:green' class="fa fa-whatsapp fa-2x"></i>Comuniquese con su Asesor Comercial</a>
					<div class="modal-footer">
						<button class="btn btn-outline-success" data-bs-dismiss="modal" type="button" id='boton2'><?php echo lang('Ok'); ?></button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="modal-vencemiento2" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-header">
					<h4 id='tittle'><?php echo lang('Su licencia ha expirado'); ?></h4>
					<div class="card-actions">
						<div class='float-end'>
							<button data-bs-dismiss="modal" class='btn  btn-primary' type="button"><span class="fa fa-close"></span></button>
						</div>
					</div>
				</div>
				<div class="modal-body">
					<p><?php echo lang('Estimado usuario, lamentamos informale que su licencia ha vencido el dia'); ?> <span style='color:red;'><?php $date = date_create($_SESSION['feclic']);
																																				echo date_format($date, "Y/m/d"); ?></span>,<?php echo lang(' para renovar su licencia o recibir información al respecto 
                        puede comunicarse a traves de'); ?> :
					</p>
					<a href="https://api.whatsapp.com/send?phone=<?php echo $_SESSION["AsesorWhatsapp"]; ?>&text=Hola%20Soy%20<?php echo $_SESSION['usernombre'] ?>,%20usuario%20de%20la%20empresa%20<?php echo $_SESSION['CompanyActual'] ?>%20<?php echo $_SESSION['NameCompany'] ?>,%20nuestra%20licencia%20esta%20por%20expirar%20el%20día%20<?php $date = date_create($_SESSION['feclic']);
																																																																																					echo date_format($date, "Y/m/d"); ?>,%20solo%20nos%20quedan%20<?php echo $_SESSION['DiasAVencer'] ?>%20días,%20Puede%20enviarme%20informacion%20del%20proceso%20de%20renovación"><i style='color:green' class="fa fa-whatsapp fa-2x"></i><?php echo lang('Comuniquese con su Asesor Comercial'); ?></a>
					<div class="modal-footer">
						<button class="btn btn-success" onclick='kick();' type="button" id='boton2'><?php echo lang('Ok'); ?></button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="apps-soporte" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-header bg-primary text-light">
					<h5 class="modal-title"> <img src="/img/BLANCO.svg" style='max-width:100px;' /> <?php echo lang('Soporte Tecnico'); ?></h5>
					<button data-bs-dismiss="modal" class="btn-close" type="button"></button>
				</div>
				<div class="modal-body">
					<form action="generarTicket.php" id='formticket' method="post" enctype="multipart/form-data">
						<div class="row">
							<div class="col-12 col-md-6 mb-1">
								<input class='form-control' value="<?php echo $_SESSION['userCorreo']; ?>" type="hidden" name="correoticket" id="correoticket" />
								<input class='form-control' value="<?php echo $_SESSION['userlogin']; ?>" type="hidden" name="userticket" />
								<input class='form-control' value="<?php echo $_SESSION['userCompany']; ?>" type="hidden" name="userCompanyticket" />
							</div>
							<div class="col-12 col-md-6 mb-1">
								<input class='form-control' value="<?php echo $_SESSION['usernombre']; ?>" type="hidden" name="nombreticket" id="nombreticket" />
							</div>
							<div class="col-12 col-md-6 mb-1">
								<input class='form-control' value="<?php echo $_SESSION['CompanyActual']; ?>" type="hidden" name="extencionticket" id="extencionticket" />
							</div>

							<div class="col-12 col-md-6 mb-1">
								<input class='form-control' type="hidden" value="<?php echo $_SESSION['CompanyActual']; ?>" name="idcomticket" id="idcomticket" />
							</div>

							<div class="col-12 col-md-6 mb-1">
								<input class='form-control' type="hidden" value="<?php echo $_SESSION['NameCompanyActual']; ?>" name="comercioticket" id="comercioticket" />
							</div>

							<div class="col-12 col-md-6 mb-1">
								<input class='form-control' type="hidden" value="<?php echo $_SESSION['correorep']; ?>" name="comercorreoticket" id="comercorreoticket" />
							</div>
							<div class="col-12 mb-1 ">
								<h4><?php echo lang('Datos del ticket'); ?></h4>
							</div>
							<div class="col-12 col-md-6 mb-1">
								<div class="form-floating">
									<input class='form-control' type="text" name="resumenticket" id="resumenticket" maxlength="60" />
									<label><?php echo lang('Resumen del problema'); ?>:</label>
								</div>
							</div>
							<div class="col-12 col-md-6 mb-1">
								<div class="form-floating">
									<input class='form-control' type="text" name="telefonoticket" id="telefonoticket" maxlength="20" />
									<label><?php echo lang('Teléfono'); ?>:</label>
								</div>
							</div>
							<div class="col-12 mb-1">
								<div class="form-floating">
									<textarea name="problematicket" id="problematicket" style='height:150px' cols="7" rows="6" class='form-control'></textarea>
									<label><?php echo lang('Detalles del problema'); ?>:</label>
								</div>
							</div>
							<div class="col-12 mb-1 d-none">
								<label for="archivoticket" class="form-label "><?php echo lang('Subir archivos'); ?> (<?php echo lang('puede hacer múltiples selecciones'); ?>):</label>
								<input class="form-control " type="file" name="archivoticket" id="archivoticket" multiple>
							</div>
							<input type="hidden" name="sitioticket" id="sitioticket" value="posup.app" />

						</div>
						<div class="modal-footer">
							<button class="btn btn-outline-secondary px-1 m-1" type="button" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang('Cerrar'); ?></button>
							<button class="btn btn-outline-primary px-1 m-1" type="button" id='soportet' onclick="gticket();"><i class="ion-checkmark"></i> <?php echo lang('Generar ticket'); ?></button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div id="modal-numticket" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-header">
					<h4 id='tittle'><img src="/img/procesar.png" width="32" height="32" /> <?php echo lang('Ticket Generado'); ?></h4>
					<div class="card-actions">
						<div class='float-end'>
							<button data-bs-dismiss="modal" class='btn  btn-primary' type="button"><span class="fa fa-close"></span></button>
						</div>
					</div>
				</div>
				<div class="modal-body">
					<h4><?php echo lang('El número de su Ticket es'); ?> <span id='ticketnumero' name='ticketnumero'><span></h4>
				</div>
				<div class="modal-footer">
					<button class="btn btn-success btn-app" id='boton8' type="button" onclick="okticket(1)"><i class="ion-checkmark"></i><?php echo lang('OK'); ?></button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal" id="modal-BadEnding" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h4><img src="/img/stop.png" width="32" height="32" /><span id="resultgeneral001"></span></h4>
				</div>
				<div class="modal-body">
					<h5 id="resultgeneral002"></h5><br>
					<h5 id="resultgeneral005"></h5>
					<h5 id="resultgeneral006">1:00</h5>
				</div>
				<div class="modal-footer">
					<a id="botongeneral001" class="btn btn-danger" href="/"><span id="resultgeneral003"></span></a>
					<button id="botongeneral002" class="btn btn-success" onclick="ReloadSSO();" type="button"><span id="resultgeneral004"></span></button>
				</div>
			</div>
		</div>
		<span id="TemporalGneral" class="d-none"></span>
	</div>
	<div class="modal" id="modal-offline" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<img src="/img/procesando.gif" width="128" height="128" />
					<h4 id="resultgeneral007"></h4>
					<br>
					<span id="errorprocesando"></span>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="video-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="title-video"></h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="vh-custom " id='videohtml'></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<div id="modalPrint" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?php echo lang("Seleccionar Formato"); ?></h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="row p-0 m-0" id="ListFormatPrint">

					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-secondary px-1" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang("Cerrar"); ?></button>
				</div>
			</div>
		</div>
	</div>
	<div id="modalPrintCodBarra" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?php echo lang("Seleccionar Formato"); ?></h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="row p-0 m-0">

						<div class="col-12 p-0 m-0">
							<button class="btn btn-outline-primary p-1 m-1 col-12 " type="button" onclick="PrintCodBarra('single')"><i class="fa fa-print"></i> <?php echo lang("Solo Codigo de Barras"); ?></button>
							<button class="btn btn-outline-primary p-1 m-1 col-12 " type="button" onclick="PrintCodBarra('singlewdesc')"><i class="fa fa-print"></i> <?php echo lang("Codigo de Barras y Descripcion"); ?></button>
							<button class="btn btn-outline-primary p-1 m-1 col-12 " type="button" onclick="PrintCodBarra('singlewdescwlog')"><i class="fa fa-print"></i> <?php echo lang("Codigo de Barras, Descripcion y Logo"); ?></button>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-secondary px-1" data-bs-dismiss="modal"><i class="fa fa-times"></i> <?php echo lang("Cerrar"); ?></button>
				</div>
			</div>
		</div>
	</div>
</body>

</html>

<?php
//include "IniPosupComp.php"; 
//include "generarvdauto.php"; 
?>