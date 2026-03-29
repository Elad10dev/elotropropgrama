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
            { extend: 'print', className: 'btn btn-outline-info', text: '<i class="fa fa-print fa-2x"></i>', exportOptions: { columns: [0, 2, 3, 4] }, title: 'Almacenes' },
            { text: '<i class="fa fa-file-excel-o fa-2x"></i>', className: 'btn btn-outline-info', extend: 'excel', exportOptions: { columns: [0, 2, 3, 4] }, title: 'Almacenes' },
            { extend: 'pdf', className: 'btn btn-outline-info', text: '<i class="fa fa-file-pdf-o fa-2x"></i>', exportOptions: { columns: [0, 2, 3, 4] }, title: 'Almacenes' }
        ],
        "aoColumnDefs": [{ "bVisible": false, "aTargets": [2] }],
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "retrieve": true,
        language: { url: language },
        columns: [ null, null, null, null, null ],
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
    if ($("#ModalNombre").val() == "") { alertBootstrap(Num001.title, Num001.desc, 'warning', 'alertaerrorenproducto', true, 1); $("#ModalNombre").focus(); return false; }
    if ($("#ModalTipo").val() == "") { alertBootstrap(Num002.title, Num002.desc, 'warning', 'alertaerrorenproducto', true, 1); $("#ModalTipo").focus(); return false; }
    if (document.getElementById("ModalIdUbi").value.trim() == "") { alertBootstrap(Num003.title, Num003.desc, 'warning', 'alertaerrorenproducto', true, 1); $("#ModalIdUbi").focus(); return false; }
    return true;
}

function guardar() {
    $('button, input, select, textarea').prop('disabled', true);
    
    if (validaForm()) {
        document.getElementById("loading").style.display = "flex";
        
        // LEEMOS LAS CAJAS DE FORMA BLINDADA CON JQUERY
        var valISLR = $("#FormaISLR").val() || "";
        var valRETIVA = $("#FormaRETIVA").val() || "";
        
        // CHIVATO PARA LA CONSOLA (F12)
        console.log("== INTENTO DE GUARDADO ==");
        console.log("Texto FormaISLR enviado:", valISLR);
        console.log("Texto FormaRETIVA enviado:", valRETIVA);

        const dataPayload = {
            tabla: "almacen",
            companyUser: $("#CompanyActual").text(),
            ModalIdAlm: $("#ModalIdAlm").val(),
            ModalIdAlm2: $("#ModalIdAlm2").val(),
            ModalNombre: $("#ModalNombre").val(),
            ModalTipo: $("#ModalTipo").val(),
            ModalIdUbi: $("#ModalIdUbi").val(),
            ImpFac: $("#ImpFac").val(),
            FormaFac: $("#FormaFac").val(),
            impBoleta: $("#impBoleta").val(),
            FormaBol: $("#FormaBol").val(),
            ImpGuia: $("#ImpGuia").val(),
            FormaGuia: $("#FormaGuia").val(),
            ImpNotaEnt: $("#ImpNotaEnt").val(),
            FormaNote: $("#FormaNote").val(),
            ImpMovInventario: $("#ImpMovInventario").val(),
            FormaMovi: $("#FormaMovi").val(),
            FormPedid: $("#FormPedid").val(),
            FormPresu: $("#FormPresu").val(),
            FormOC: $("#FormOC").val(),
            ModalCodigoContable: $("#ModalCodigoContable").val(),
            ModalAtencion: $("#ModalAtencion").val(),
            CasheAliado: $("#CasheAliado").val(),
            CasheApikey: $("#CasheApikey").val(),
            CasheaPrecio: $("#CasheaPrecio").val(),
            
            // CAMPOS NUEVOS
            FormaISLR: valISLR,
            FormaRETIVA: valRETIVA
        };

        $.ajax({
            type: "POST",
            url: "almacenseek.php",
            data: dataPayload
        }).done(function (res) {
            document.getElementById("loading").style.display = "none";
            
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

    } else {
        $('button, input, select, textarea').prop('disabled', false);
    }
}

function recibir(numero) {
    if (numero > 0) {
        document.getElementById("titlemodal").innerHTML = "<i class='fa fa-edit'></i> Editar Almacén";
        
        // LEEMOS DEL HTML OCULTO Y PONEMOS EN LAS CAJAS DE TEXTO
        $("#ModalTipo").val( $("#tipo2" + numero).text() );
        $("#ModalIdAlm").prop("readOnly", true).val( $("#IdAlm" + numero).text() );
        $("#ModalNombre").val( $("#nom" + numero).text() );
        $("#ImpFac").val( $("#ImpFa" + numero).text() );
        $("#impBoleta").val( $("#impBolet" + numero).text() );
        $("#ImpGuia").val( $("#ImpGui" + numero).text() );
        $("#ImpNotaEnt").val( $("#ImpNotaEn" + numero).text() );
        $("#ImpMovInventario").val( $("#ImpMovInventari" + numero).text() );
        $("#FormPedid").val( $("#FormPedido" + numero).text() );
        $("#FormPresu").val( $("#FormPresup" + numero).text() );
        $("#FormaFac").val( $("#ImpFa2" + numero).text() );
        $("#FormaBol").val( $("#impBolet2" + numero).text() );
        $("#FormaGuia").val( $("#ImpGui2" + numero).text() );
        $("#FormaNote").val( $("#ImpNotaEn2" + numero).text() );
        $("#FormaMovi").val( $("#ImpMovInventari2" + numero).text() );
        $("#ModalIdUbi").val( $("#IdUbi" + numero).text() );
        $("#FormOC").val( $("#FormOC" + numero).text() );
        $("#ModalCodigoContable").val( $("#codigocontable" + numero).text() );
        $("#ModalAtencion").val( $("#IdAttA" + numero).text() );
        $("#CasheAliado").val( $("#Cashea_AliadoName" + numero).text() );
        $("#CasheApikey").val( $("#Cashea_APIKEY" + numero).text() );
        $("#CasheaPrecio").val( $("#Cashea_Precio" + numero).text() );

        // LECTURA SEGURA ISLR
        var spanISLR = document.getElementById("FormaISLR" + numero);
        var spanRETIVA = document.getElementById("FormaRETIVA" + numero);
        
        $("#FormaISLR").val( spanISLR ? spanISLR.innerHTML.trim() : "" );
        $("#FormaRETIVA").val( spanRETIVA ? spanRETIVA.innerHTML.trim() : "" );

        $('#apps-modal').modal('show');
    } else {
        document.getElementById("titlemodal").innerHTML = "<i class='fa fa-plus'></i> Guardar Almacén";
        
        // VACIADO LIMPIO PARA REGISTRO NUEVO
        $("#ModalIdAlm").prop("readOnly", true).val("");
        $("#ModalNombre").val("");
        $('#ModalIdUbi > option[value="1"]').prop('selected', true);
        $("#ModalTipo").prop("readOnly", false).val("0");
        $("#ImpFac, #impBoleta, #ImpGuia, #ImpNotaEnt, #ImpMovInventario, #ModalAtencion").val("0");
        $("#FormPresu, #FormPedid, #FormaFac, #FormaBol, #FormaGuia, #FormaNote, #FormaMovi, #FormOC, #ModalCodigoContable, #CasheAliado, #CasheApikey").val("");
        $("#CasheaPrecio").val("1");
        
        // VACIADO DE ISLR
        $("#FormaISLR").val("");
        $("#FormaRETIVA").val("");

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
    
    $("#ModalIdAlm").val("");
    $("#ModalIdAlm2").val( $("#IdAlm" + numero).text() );
    $("#ModalTipo").val( $("#tipo2" + numero).text() );
    $("#ModalNombre").val( $("#nom" + numero).text() );
    $("#ModalIdUbi").val( $("#IdUbi" + numero).text() );
    $("#ImpFac").val( $("#ImpFa" + numero).text() );
    $("#impBoleta").val( $("#impBolet" + numero).text() );
    $("#ImpGuia").val( $("#ImpGui" + numero).text() );
    $("#ImpNotaEnt").val( $("#ImpNotaEn" + numero).text() );
    $("#ImpMovInventario").val( $("#ImpMovInventari" + numero).text() );
    $("#FormaFac").val( $("#ImpFa2" + numero).text() );
    $("#FormaBol").val( $("#impBolet2" + numero).text() );
    $("#FormaGuia").val( $("#ImpGui2" + numero).text() );
    $("#FormaNote").val( $("#ImpNotaEn2" + numero).text() );
    $("#FormaMovi").val( $("#ImpMovInventari2" + numero).text() );
    $("#FormPedid").val( $("#FormPedido" + numero).text() );
    $("#FormPresu").val( $("#FormPresup" + numero).text() );
    $("#FormOC").val( $("#FormOC" + numero).text() );
    $("#ModalCodigoContable").val( $("#codigocontable" + numero).text() );
    $("#ModalAtencion").val( $("#IdAttA" + numero).text() );
    $("#CasheAliado").val( $("#Cashea_AliadoName" + numero).text() );
    $("#CasheApikey").val( $("#Cashea_APIKEY" + numero).text() );
    $("#CasheaPrecio").val( $("#Cashea_Precio" + numero).text() );

    // COPIAR ISLR Y RETIVA
    var spanISLR = document.getElementById("FormaISLR" + numero);
    var spanRETIVA = document.getElementById("FormaRETIVA" + numero);
    $("#FormaISLR").val( spanISLR ? spanISLR.innerHTML.trim() : "" );
    $("#FormaRETIVA").val( spanRETIVA ? spanRETIVA.innerHTML.trim() : "" );

    guardar();
}