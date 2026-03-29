function validaForm() {
  if ($("#ModalRif").val() == "") {
    alertBootstrap(
      Utils.Num001.title,
      Utils.Num001.desc,
      "warning",
      "alertaerrorenproducto",
      true,
      1,
    );
    $("#ModalRif").focus();
    return false;
  }

  if ($("#ModalNombre").val() == "") {
    alertBootstrap(
      Utils.Num002.title,
      Utils.Num002.desc,
      "warning",
      "alertaerrorenproducto",
      true,
      1,
    );
    $("#ModalNombre").focus();
    return false;
  }

  if ($("#ModalCid").val() == "") {
    alertBootstrap(
      Utils.Num006.title,
      Utils.Num006.desc,
      "warning",
      "alertaerrorenproducto",
      true,
      1,
    );
    $("#ModalCid").focus();
    return false;
  }

  if ($("#ModalTelf").val() == "") {
    alertBootstrap(
      Utils.Num007.title,
      Utils.Num007.desc,
      "warning",
      "alertaerrorenproducto",
      true,
      1,
    );
    $("#ModalTelf").focus();
    return false;
  }

  if ($("#ModalNombre").val() == "") {
    alertBootstrap(
      Utils.Num002.title,
      Utils.Num002.desc,
      "warning",
      "alertaerrorenproducto",
      true,
      1,
    );
    $("#ModalNombre").focus();
    return false;
  }

  if (
    $("#ModalCli").prop("checked") == false &&
    $("#ModalProv").prop("checked") == false &&
    $("#ModalTrab").prop("checked") == false &&
    $("#ModalOtro").prop("checked") == false
  ) {
    alertBootstrap(
      Utils.Num003.title,
      Utils.Num003.desc,
      "warning",
      "alertaerrorenproducto",
      true,
      1,
    );

    return false;
  }

  return true;
}

function guardar() {
  $("button").prop("disabled", true);
  if (validaForm()) {
    $.post(
      "beneficiariosnewseek.php",
      $("#formdata").serialize(),
      function (res) {
        if (res == 1) {
          alertBootstrap(
            Utils.Success.title,
            Utils.Success.desc,
            "warning",
            "alertaerrorenproducto2",
            true,
            1,
          );
          CargarDatatable();
          $("#apps-modal").modal("hide");
          $("button").prop("disabled", false);
        } else if (res.trim() == 3) {
          $("#loading").hide();
          alertBootstrap(
            Utils.Num004.title,
            Utils.Num004.desc,
            "warning",
            "alertaerrorenproducto",
            true,
            1,
          );
          $("#ModalRif").focus();
          $("button").prop("disabled", false);
        } else {
          alertBootstrap(
            Utils.Num008.title,
            Utils.Num008.desc,
            "warning",
            "alertaerrorenproducto",
            true,
            1,
          );
          $("button").prop("disabled", false);
        }
      },
    );
  } else {
    $("button").prop("disabled", false);
  }
}

function recibir(numero) {
  $("#apps-modal").modal("show");
  if (numero > 0) {
    document.getElementById("new").value = "1";
    if (document.getElementById("IdPaisAct").innerHTML == "CL") {
      var cadena = document.getElementById("rif" + numero).innerHTML;
      document.getElementById("ModalRut").readOnly = true;
      document.getElementById("ModalRut2").readOnly = true;
      document.getElementById("ModalRut").value = cadena.split("-", 1);
      document.getElementById("ModalRut2").value = cadena.substr(-1);
    } else {
      document.getElementById("ModalRif").readOnly = true;
      valor = document.getElementById("rif" + numero);
      document.getElementById("ModalRif").value = valor.innerHTML;
    }

    valor = document.getElementById("cid" + numero);
    document.getElementById("ModalCid").value = valor.innerHTML;
    valor = document.getElementById("codb" + numero);
    document.getElementById("ModalCodb").value = valor.innerHTML;
    valor = document.getElementById("nom" + numero);
    document.getElementById("ModalNombre").value = valor.innerHTML;
    valor = document.getElementById("telf" + numero);
    document.getElementById("ModalTelf").value = valor.innerHTML;
    valor = document.getElementById("dir" + numero);
    document.getElementById("ModalDir").value = valor.innerHTML;
    valor = document.getElementById("tipoc" + numero);
    document.getElementById("ModalTipoc").value = valor.innerHTML;

    document.getElementById("latitud").value = document.getElementById(
      "lat" + numero,
    ).innerHTML;
    document.getElementById("longitud").value = document.getElementById(
      "lon" + numero,
    ).innerHTML;

    valor = document.getElementById("deudamb" + numero);
    document.getElementById("ModalDeudamb").value = valor.innerHTML;
    valor = document.getElementById("deudaml" + numero);
    document.getElementById("ModalDeudaml").value = valor.innerHTML;
    valor = document.getElementById("fechap1" + numero);
    document.getElementById("ModalFechap1").value = valor.innerHTML;
    valor = document.getElementById("fechap2" + numero);
    document.getElementById("ModalFechap2").value = valor.innerHTML;
    valor = document.getElementById("nroc" + numero);
    document.getElementById("ModalNroc").value = valor.innerHTML;
    valor = document.getElementById("com" + numero);
    document.getElementById("ModalCom").value = valor.innerHTML;
    valor = document.getElementById("giro" + numero);
    document.getElementById("ModalGiro").value = valor.innerHTML;
    valor = document.getElementById("credf" + numero);
    document.getElementById("ModalCredf").value = valor.innerHTML;
    valor = document.getElementById("credu" + numero);
    document.getElementById("ModalCredu").value = valor.innerHTML;

    valor = document.getElementById("email" + numero);
    document.getElementById("ModalEmailCorreo").value = valor.innerHTML;
    document.getElementById("ModalPro").value = document.getElementById(
      "provinciaS" + numero,
    ).innerHTML;
    document.getElementById("ModalReg").value = document.getElementById(
      "regionS" + numero,
    ).innerHTML;
    document.getElementById("TipoBeneficiario").value = document.getElementById(
      "TipoBenef" + numero,
    ).innerHTML;

    valor = document.getElementById("edoc" + numero).innerHTML;
    if (valor === "1") {
      $("#ModalEdoc").prop("checked", true);
    } else {
      $("#ModalEdoc").prop("checked", false);
    }
    valor = document.getElementById("edo" + numero).innerHTML;
    if (valor === "1") {
      $("#ModalEdo").prop("checked", true);
    } else {
      $("#ModalEdo").prop("checked", false);
    }

    valor = document.getElementById("cli" + numero).innerHTML;
    if (valor === "1") {
      $("#ModalCli").prop("checked", true);
    } else {
      $("#ModalCli").prop("checked", false);
    }

    valor = document.getElementById("prov" + numero).innerHTML;
    if (valor === "1") {
      $("#ModalProv").prop("checked", true);
    } else {
      $("#ModalProv").prop("checked", false);
    }

    valor = document.getElementById("trab" + numero).innerHTML;
    if (valor === "1") {
      $("#ModalTrab").prop("checked", true);
    } else {
      $("#ModalTrab").prop("checked", false);
    }

    valor = document.getElementById("otro" + numero).innerHTML;
    if (valor === "1") {
      $("#ModalOtro").prop("checked", true);
    } else {
      $("#ModalOtro").prop("checked", false);
    }

    valor = document.getElementById("esservidor" + numero).innerHTML;
    if (valor === "1") {
      $("#ModalServicio").prop("checked", true);
    } else {
      $("#ModalServicio").prop("checked", false);
    }

    valor = document.getElementById("ciudadxd" + numero);
    document.getElementById("ModalCiudad").value = valor.innerHTML;
  } else {
    OcultarNotificacion2();
    posicion();
    document.getElementById("new").value = "0";
    if (document.getElementById("IdPaisAct").innerHTML == "CL") {
      document.getElementById("ModalRut").readOnly = false;
      document.getElementById("ModalRut2").readOnly = true;
      document.getElementById("ModalRut").value = "";
      document.getElementById("ModalRut2").value = "";
    } else {
      document.getElementById("ModalRif").readOnly = false;
      document.getElementById("ModalRif").value = "";
    }
    document.getElementById("ModalCid").value = "";
    document.getElementById("ModalCodb").value = "";
    document.getElementById("ModalNombre").value = "";
    document.getElementById("ModalTelf").value = "";
    document.getElementById("ModalDir").value = "";
    document.getElementById("ModalTipoc").value = "0";
    document.getElementById("ModalEmailCorreo").value = "";

    if (EstadoCredito === "0") {
      $("#ModalEdoc").prop("checked", false);
    } else {
      $("#ModalEdoc").prop("checked", true);
    }

    document.getElementById("ModalDeudamb").value = "0";
    document.getElementById("ModalDeudaml").value = "0";
    document.getElementById("ModalFechap1").value = "0";
    document.getElementById("ModalFechap2").value = "";
    document.getElementById("ModalNroc").value = "";
    document.getElementById("ModalCom").value = "";
    document.getElementById("ModalGiro").value = "";
    document.getElementById("ModalCredf").value = "0";
    document.getElementById("ModalCredu").value = "0";
    document.getElementById("ModalPro").value = "";
    document.getElementById("ModalReg").value = "";
    document.getElementById("ModalCiudad").value = "";

    document.getElementById("TipoBeneficiario").value = "0";
    $("#ModalEdo").prop("checked", true);
    $("#ModalCli").prop("checked", false);
    $("#ModalProv").prop("checked", false);
    $("#ModalTrab").prop("checked", false);
    $("#ModalOtro").prop("checked", false);
    $("#ModalServicio").prop("checked", false);
  }
}

function alertaborrar(numero) {
  document.getElementById("CodeDel").innerHTML = numero;
  document.getElementById("desckk").innerHTML = document.getElementById(
    "nossm" + numero,
  ).innerHTML;
  $("#apps-delet").modal("show");
}

function alertaborrar2() {
  document.getElementById("loading").style.display = "flex";
  var numero = document.getElementById("CodeDel").innerHTML;
  $.ajax({
    type: "POST",
    url: "beneficiariosnewseek.php",
    data: {
      borrar: "1",
      ModalRif: document.getElementById("rif" + numero).innerHTML,
      companyUser: document.getElementById("CompanyActual").innerHTML,
      tabla: "beneficiarios",
    },
  }).done(function (msg) {
    if (msg == 1) {
      alertBootstrap(
        Utils.Success.title,
        Utils.Success.desc,
        "success",
        "alertaerrorenproducto2",
        true,
        1,
      );
      CargarDatatable();
      $("#apps-delet").modal("hide");
    } else {
      alertBootstrap(
        Utils.Danger.title,
        Utils.Danger.desc,
        "danger",
        "alertaerrorenproducto3",
        true,
        1,
      );
    }
  });
}

function comuna() {
  $("#apps-modal").modal("hide");
  $("#apps-modal2y2").modal("show");
  CargarDatatableAB2();
}

function enviar3(numero) {
  document.getElementById("ModalCom").value = document.getElementById(
    "comuna_nombre" + numero,
  ).innerHTML;
  document.getElementById("ModalPro").value = document.getElementById(
    "provincia_nombre" + numero,
  ).innerHTML;
  document.getElementById("ModalReg").value = document.getElementById(
    "region" + numero,
  ).innerHTML;
  $("#apps-modal2y2").modal("hide");
  $("#apps-modal").modal("show");
}

function CargarDatatable() {
  var language =
    "lang/datatables/" +
    document.getElementById("IdiomaActual").innerHTML +
    ".json";
  $("#DatatableConPro")
    .on("search.dt", function () {
      $(
        "#DatatableConPro_wrapper .dt-layout-row .dt-end .dt-search .dt-input",
      ).focus();
      $("#spinner_load_DatatableConPro").removeClass("d-none");
    })
    .DataTable({
      search: {
        search: $(
          `#${"DatatableConPro"}_wrapper .dt-layout-row .dt-end .dt-search .dt-input`,
        ).val(),
      },
      drawCallback: function () {
        $(
          "#DatatableConPro_wrapper .dt-layout-row .dt-end .dt-search .dt-input",
        ).focus();
        $("#spinner_load_DatatableConPro").addClass("d-none");
      },
      searchDelay: 800,
      responsive: true,
      processing: true,
      serverSide: true,
      ordering: false,
      language: {
        url: language,
      },
      ajax: {
        type: "POST",
        url: "beneficiariosnewseek.php",
        data: {
          Accion: "0",
          CompanyActual: document.getElementById("CompanyActual").innerHTML,
          userperfil: document.getElementById("userperfil").innerHTML,
        },
      },
      columns: [null, null, null, null, null, null],
      destroy: true,
    });
  setTimeout(() => {
    $(
      "#DatatableConPro_wrapper .dt-layout-row .dt-end .dt-search .dt-input",
    ).focus();
    $("#spinner_load_DatatableConPro").addClass("d-none");
  }, 800);
}

function CargarDatatableAB2() {
  var language =
    "lang/datatables/" +
    document.getElementById("IdiomaActual").innerHTML +
    ".json";
  $("#DatatableConCOM")
    .on("search.dt", function () {
      $(
        "#DatatableConCOM_wrapper .dt-layout-row .dt-end .dt-search .dt-input",
      ).focus();
      $("#spinner_load_DatatableConCOM").removeClass("d-none");
    })
    .DataTable({
      search: {
        search: $(
          `#${"DatatableConCOM"}_wrapper .dt-layout-row .dt-end .dt-search .dt-input`,
        ).val(),
      },
      drawCallback: function () {
        $(
          "#DatatableConCOM_wrapper .dt-layout-row .dt-end .dt-search .dt-input",
        ).focus();
        $("#spinner_load_DatatableConCOM").addClass("d-none");
      },
      searchDelay: 800,
      responsive: true,
      processing: true,
      serverSide: true,
      ordering: false,
      language: {
        url: language,
      },
      ajax: {
        type: "POST",
        url: "beneficiariosnewseek.php",
        data: {
          Accion: "2",
          CompanyActual: document.getElementById("CompanyActual").innerHTML,
          userperfil: document.getElementById("userperfil").innerHTML,
          IdPais: document.getElementById("IdPaisAct").innerHTML,
        },
      },
      columns: [null, null],
      destroy: true,
    });
  setTimeout(() => {
    $(
      "#DatatableConCOM_wrapper .dt-layout-row .dt-end .dt-search .dt-input",
    ).focus();
    $("#spinner_load_DatatableConCOM").addClass("d-none");
  }, 800);
}

function initMap() {
  map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: -34.397, lng: 150.644 },
    zoom: 6,
  });
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
  infoWindow.setPosition(pos);
  infoWindow.setContent(
    browserHasGeolocation
      ? "Error: The Geolocation service failed."
      : "Error: Your browser doesn't support geolocation.",
  );
  infoWindow.open(map);
}
let map;
function posicion() {
  infoWindow = new google.maps.InfoWindow();
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        const pos = {
          lat: position.coords.latitude,
          lng: position.coords.longitude,
        };
        infoWindow.setPosition(pos);
        map.setCenter(pos);
        document.getElementById("latitud").value = position.coords.latitude;
        document.getElementById("longitud").value = position.coords.longitude;
      },
      () => {
        handleLocationError(true, infoWindow, map.getCenter());
      },
    );
  } else {
    handleLocationError(false, infoWindow, map.getCenter());
  }
}
