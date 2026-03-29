
function Pagineo(n) {
	MuestraProd();
}

function verialm() {
	$.ajax({
		type: "POST",
		url: "almacenseek.php",
		data: { go: 'verif-alm', company: document.getElementById("CompanyActual").innerHTML }
	}).done(function (msg) {
		document.getElementById('VerifAlm').innerHTML = msg;
	});
}

function MuestraProd() {
	$('#ServerSideTable').DataTable().clear().destroy();
	var language = "lang/datatables/" + document.getElementById("IdiomaActual").innerHTML + '.json';
	MOSTRAR = $('#ServerSideTable').DataTable({
		dom: 'Blfrtip',
		buttons: [
			{
				extend: 'print',
				className: 'btn btn-outline-info ',
				text: '<i class="fa fa-print fa-2x"></i>',
				exportOptions: { columns: [0, 2, 3, 4] },
				title: '<?php echo lang("Almacenes") ?>'
			},
			{
				text: '<i class="fa fa-file-excel-o fa-2x"></i>',
				className: 'btn btn-outline-info ',
				extend: 'excel',
				exportOptions: { columns: [0, 2, 3, 4] },
				title: '<?php echo lang("Almacenes") ?>'
			},
			{
				extend: 'pdf',
				className: 'btn btn-outline-info ',
				text: '<i class="fa fa-file-pdf-o fa-2x"></i>',
				exportOptions: { columns: [0, 2, 3, 4] },
				title: '<?php echo lang("Almacenes") ?>'
			}
		],
		"aoColumnDefs": [{ "bVisible": false, "aTargets": [2] }],
		"responsive": true,
		"processing": true,
		"serverSide": true,
		"retrieve": true,
		language: {
			url: language
		},
		columns: [
			null,
			null,
			null,
			null,
			null,
		],
		"ajax": {
			"url": "almacenseek.php",
			"method": 'POST',
			"data": { go: 'datatable', IdCompany: document.getElementById("CompanyActual").innerHTML, userperfil: document.getElementById("userperfil").innerHTML, CD: document.getElementById("CD").innerHTML, SimDec: document.getElementById("SimDec").innerHTML, SimMil: document.getElementById("SimMil").innerHTML, EsonoES: document.getElementById("EleccionEc").innerHTML }
		},
		"destroy": true
	});
	setTimeout(() => $('div.dataTables_filter input').focus(), 500);
	verialm();
}

function validaForm() {
	if ($("#ModalNombre").val() == "") {
		alertBootstrap(Num001.title, Num001.desc, 'warning', 'alertaerrorenproducto', true, 1);
		$('button, input, select, textarea').prop('disabled', false);

		$("#ModalNombre").focus();
		return false;
	}
	if ($("#ModalTipo").val() == "") {
		alertBootstrap(Num002.title, Num002.desc, 'warning', 'alertaerrorenproducto', true, 1);
		$('button, input, select, textarea').prop('disabled', false);

		$("#ModalTipo").focus();
		return false;
	}
	if (document.getElementById("ModalIdUbi").value.trim() == "") {
		alertBootstrap(Num003.title, Num003.desc, 'warning', 'alertaerrorenproducto', true, 1);
		$('button, input, select, textarea').prop('disabled', false);

		$("#ModalIdUbi").focus();
		return false;
	}

	return true;
}

function guardar() {
	$('button, input, select, textarea').prop('disabled', true);
	if (validaForm()) {
		document.getElementById("loading").style.display = "flex";
		$.ajax({
			type: "POST",
			url: "almacenseek.php",
			data: {tabla : "almacen",companyUser:document.getElementById("CompanyActual").innerHTML,ModalIdAlm:document.getElementById( "ModalIdAlm" ).value,ModalIdAlm2:document.getElementById( "ModalIdAlm2" ).value,ModalNombre:document.getElementById( "ModalNombre" ).value,ModalTipo:document.getElementById( "ModalTipo" ).value,ModalIdUbi:document.getElementById( "ModalIdUbi" ).value,ImpFac:document.getElementById( "ImpFac" ).value,FormaFac:document.getElementById( "FormaFac" ).value,impBoleta:document.getElementById( "impBoleta" ).value,FormaBol:document.getElementById( "FormaBol" ).value,ImpGuia:document.getElementById( "ImpGuia" ).value,FormaGuia:document.getElementById( "FormaGuia" ).value,ImpNotaEnt:document.getElementById( "ImpNotaEnt" ).value,FormaNote:document.getElementById( "FormaNote" ).value,ImpMovInventario:document.getElementById( "ImpMovInventario" ).value,FormaMovi:document.getElementById( "FormaMovi" ).value,FormPedid:document.getElementById( "FormPedid" ).value,FormPresu:document.getElementById( "FormPresu" ).value,FormOC:document.getElementById( "FormOC" ).value }
		}).done(function (res) {
			document.getElementById("loading").style.display = "none";
			console.log(res);
			if (res == "1") {
				alertBootstrap(Success.title, Success.desc, 'success', 'alertaerrorenproducto2', true, 1);
				$('#apps-modal').modal('hide');
				$("#apps-copiar").modal("hide");
				$('button, input, select, textarea').prop('disabled', false);
				var table = $('#ServerSideTable').DataTable();
				table.ajax.reload(null, false);
				return verialm();
			}
			$('button, input, select, textarea').prop('disabled', false);
			return alertBootstrap(Danger.title, Danger.desc, 'danger', 'alertaerrorenproducto', true, 1);
	});

	}
}

function recibir(numero) {
		if (numero > 0) {
			document.getElementById("titlemodal").innerHTML = "<i class='fa fa-edit'></i> " + Num004.title;
			document.getElementById("ModalTipo").value = document.getElementById("tipo2" + numero).innerHTML;
			document.getElementById("ModalIdAlm").readOnly = true
			valor = document.getElementById("IdAlm" + numero);
			document.getElementById("ModalIdAlm").value = valor.innerHTML;
			valor = document.getElementById("nom" + numero);
			document.getElementById("ModalNombre").value = valor.innerHTML;

			document.getElementById("ImpFac").value = document.getElementById("ImpFa" + numero).innerHTML;
			document.getElementById("impBoleta").value = document.getElementById("impBolet" + numero).innerHTML;
			document.getElementById("ImpGuia").value = document.getElementById("ImpGui" + numero).innerHTML;
			document.getElementById("ImpNotaEnt").value = document.getElementById("ImpNotaEn" + numero).innerHTML;
			document.getElementById("ImpMovInventario").value = document.getElementById("ImpMovInventari" + numero).innerHTML;

			document.getElementById("FormPedid").value = document.getElementById("FormPedido" + numero).innerHTML;
			document.getElementById("FormPresu").value = document.getElementById("FormPresup" + numero).innerHTML;

			document.getElementById("FormaFac").value = document.getElementById("ImpFa2" + numero).innerHTML;
			document.getElementById("FormaBol").value = document.getElementById("impBolet2" + numero).innerHTML;
			document.getElementById("FormaGuia").value = document.getElementById("ImpGui2" + numero).innerHTML;
			document.getElementById("FormaNote").value = document.getElementById("ImpNotaEn2" + numero).innerHTML;
			document.getElementById("FormaMovi").value = document.getElementById("ImpMovInventari2" + numero).innerHTML;
			document.getElementById("ModalIdUbi").value = document.getElementById("IdUbi" + numero).innerHTML;
			document.getElementById("FormOC").value = document.getElementById("FormOC" + numero).innerHTML;
			$('#apps-modal').modal('show');
		} else {
			document.getElementById("titlemodal").innerHTML = "<i class='fa fa-plus'></i> " + Num005.title;
			document.getElementById("ModalIdAlm").readOnly = true
			document.getElementById("ModalIdAlm").focus();
			document.getElementById("ModalIdAlm").value = "";
			document.getElementById("ModalNombre").value = "";
			$('#ModalIdUbi > option[value="1"]').attr('selected', 'selected');
			document.getElementById("ModalTipo").readOnly = false
			document.getElementById("ModalTipo").focus();
			document.getElementById("ModalTipo").value = "0";

			document.getElementById("ImpFac").value = "0";
			document.getElementById("impBoleta").value = "0";
			document.getElementById("ImpGuia").value = "0";
			document.getElementById("ImpNotaEnt").value = "0";
			document.getElementById("ImpMovInventario").value = "0";
			document.getElementById("FormPresu").value = "";

			document.getElementById("FormPedid").value = "";
			document.getElementById("FormaFac").value = "";
			document.getElementById("FormaBol").value = "";
			document.getElementById("FormaGuia").value = "";
			document.getElementById("FormaNote").value = "";
			document.getElementById("FormaMovi").value = "";

			$('#apps-modal').modal('show');
		}
}

function alertaborrar(numero) {
	document.getElementById("CodeDel").innerHTML = numero;
	document.getElementById("desckk").innerHTML = document.getElementById("nom" + numero).innerHTML;
	$("#apps-delet").modal("show");
}

function alertaborrar2() {
	$('button, input, select, textarea').prop('disabled', true);
	document.getElementById("loading").style.display = "flex";
		var numero = document.getElementById("CodeDel").innerHTML;

		$.ajax({
			type: "POST",
			url: "almacenseek.php",
			data: { borrar: "1", ModalIdAlm: document.getElementById("IdAlm" + numero).innerHTML, companyUser: document.getElementById("CompanyActual").innerHTML, tabla: "almacen" }
		}).done(function (msg) {
			$('button, input, select, textarea').prop('disabled', false);
			document.getElementById("loading").style.display = "none";
			if (msg === "1") {
				alertBootstrap(Success.title, Success.desc, 'success', 'alertaerrorenproducto2', true, 1);

				var table = $('#ServerSideTable').DataTable();
				table.ajax.reload(null, false);
				verialm();
				$("#apps-delet").modal("hide");
			}
			if (msg === "0") return alertBootstrap(Danger.title, Danger.desc, 'danger', 'alertaerrorenproducto5', true, 1);
			
			if (msg === "-0") return alertBootstrap(Num006.title, Num006.desc, 'warning', 'alertaerrorenproducto5', true, 1);
		});
}

function agregaralm(){
	if(document.getElementById( "VerifAlm" ).innerHTML==1){
		return recibir(0);
	}
	return alertBootstrap(Num007.title, Num007.desc, 'warning', 'alertaerrorenproducto2', true, 1);
}

function ClonarReg(numero) {
	document.getElementById("CodeDelCopiar").innerHTML = numero;
	document.getElementById("descopiar").innerHTML = document.getElementById("nom" + numero).innerHTML;
	$("#apps-copiar").modal("show");
}

function ClonarReg2() {
	var numero = document.getElementById("CodeDelCopiar").innerHTML;
	document.getElementById("ModalIdAlm").value = "";
	document.getElementById("ModalTipo").value = document.getElementById("tipo2" + numero).innerHTML;
	document.getElementById("ModalIdAlm2").value = document.getElementById("IdAlm" + numero).innerHTML;
	document.getElementById("ModalNombre").value = document.getElementById("nom" + numero).innerHTML;
	document.getElementById("ImpFac").value = document.getElementById("ImpFa" + numero).innerHTML;
	document.getElementById("impBoleta").value = document.getElementById("impBolet" + numero).innerHTML;
	document.getElementById("ImpGuia").value = document.getElementById("ImpGui" + numero).innerHTML;
	document.getElementById("ImpNotaEnt").value = document.getElementById("ImpNotaEn" + numero).innerHTML;
	document.getElementById("ImpMovInventario").value = document.getElementById("ImpMovInventari" + numero).innerHTML;
	document.getElementById("FormPedid").value = document.getElementById("FormPedido" + numero).innerHTML;
	document.getElementById("FormaFac").value = document.getElementById("ImpFa2" + numero).innerHTML;
	document.getElementById("FormaBol").value = document.getElementById("impBolet2" + numero).innerHTML;
	document.getElementById("FormaGuia").value = document.getElementById("ImpGui2" + numero).innerHTML;
	document.getElementById("FormaNote").value = document.getElementById("ImpNotaEn2" + numero).innerHTML;
	document.getElementById("FormaMovi").value = document.getElementById("ImpMovInventari2" + numero).innerHTML;
	document.getElementById("ModalIdUbi").value = document.getElementById("IdUbi" + numero).innerHTML;
	document.getElementById("FormPresu").value = document.getElementById("FormPresup" + numero).innerHTML;
	guardar();
}