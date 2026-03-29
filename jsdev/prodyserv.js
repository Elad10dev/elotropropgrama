let responseHtml5 = "";

function HistoricoEventosCriticos() {
  // Create form
  const form = document.createElement("form");
  form.method = "POST";
  form.action = "excelnew.php";

  // Helper to append input fields
  function addField(name, value) {
    const input = document.createElement("input");
    input.type = "hidden";
    input.name = name;
    input.value = value;
    form.appendChild(input);
  }

  const familia = $("#EnvioFamilia").val();
  const marca = $("#EnvioMarca").val();
  const almacen = $("#EnvioAlmacen").val();
  const ubicacion = $("#EnvioUbicacion").val();
  const zonatencion = $("#EnvioZonaAtencion").val();
  const NotIncludeFamilia =
    document.getElementById("NotIncludeFamilia").checked;
  const Peso = document.getElementById("EnvioPeso").checked;
  const Estado = document.getElementById("EnvioEstado").checked;
  const CompanyActual = document.getElementById("CompanyActual").innerHTML;
  const CD = document.getElementById("CD").innerHTML;
  const SimDec = document.getElementById("SimDec").innerHTML;
  const SimMil = document.getElementById("SimMil").innerHTML;
  const Buscador = $(
    "#ServerSideTable_wrapper .dt-layout-row .dt-end .dt-search .dt-input",
  ).val();
  const NotIncludeAlmacen =
    document.getElementById("NotIncludeAlmacen").checked;
  const NotIncludeUbicacion = document.getElementById(
    "NotIncludeUbicacion",
  ).checked;
  const NotIncludeZonaAtencion = document.getElementById(
    "NotIncludeZonaAtencion",
  ).checked;

  addField("familia", familia);
  addField("marca", marca);
  addField("almacen", almacen);
  addField("ubicacion", ubicacion);
  addField("zonatencion", zonatencion);
  addField("NotIncludeFamilia", NotIncludeFamilia);
  addField("Peso", Peso);
  addField("Estado", Estado);
  addField("CompanyActual", CompanyActual);
  addField("CD", CD);
  addField("SimDec", SimDec);
  addField("SimMil", SimMil);
  addField("Buscador", Buscador);
  addField("NotIncludeAlmacen", NotIncludeAlmacen);
  addField("NotIncludeUbicacion", NotIncludeUbicacion);
  addField("NotIncludeZonaAtencion", NotIncludeZonaAtencion);
  addField("CompanyActual", CompanyActual);

  document.body.appendChild(form);

  form.submit();
  document.body.removeChild(form);
}

function OpenModalScan() {
  $("#SendScanCo").hide();
  $("#ModalCodigoBarras").modal("show");
  Escanear();
}

function onScanSuccess(decodedText, decodedResult) {
  $("#SendScanCo").show();
  document.getElementById("qr-response").innerHTML = decodedText;
  responseHtml5 = decodedText;
}

function Escanear() {
  const html5QrcodeScanner = new Html5QrcodeScanner("qr-reader", {
    fps: 10,
    qrbox: {
      width: 200,
      height: 200,
    },
  });
  html5QrcodeScanner.render(onScanSuccess);
}

function TipoCostoChange() {
  if (document.getElementById("userperfil").innerHTML === "2056") {
    $(
      "#ModalCostoPercent,#ModalCostoNeto,#ModalCostos,#CostoTitle03,#CostoTitle02,#CostoTitle01",
    ).hide();
    return;
  }

  if (document.getElementById("ModalTipOCosto").value === "0") {
    $("#ModalCostoPercent").hide();
    $("#CostoTitle03").hide();
    $("#ModalCostoNeto,#ModalCostos,#CostoTitle02,#CostoTitle01").show();
    $(
      "#ModalPrecioNeto, #ModalPrecioNeto2, #ModalPrecioNeto3, #ModalPrecioNeto4, #ModalPrecioNeto5, #ModalPrecioNeto6, #ModalPrecioNeto7, #ModalPrecioNeto8, #ModalPrecioNeto9, #ModalPrecioNeto10, #ModalMargen, #ModalMargen2, #ModalMargen3, #ModalMargen4, #ModalMargen5, #ModalMargen6, #ModalMargen7, #ModalMargen8, #ModalMargen9, #ModalMargen10, #ModalPrecioVenta, #ModalPrecioVenta2, #ModalPrecioVenta3, #ModalPrecioVenta4, #ModalPrecioVenta5, #ModalPrecioVenta6, #ModalPrecioVenta7, #ModalPrecioVenta8, #ModalPrecioVenta9, #ModalPrecioVenta10",
    ).prop("disabled", false);
    if (IdAct > 0) {
      document.getElementById("ModalPrecioNeto").value =
        document.getElementById("precioneto1" + IdAct).innerHTML;
      document.getElementById("ModalPrecioVenta").value =
        document.getElementById("preciodeventa2" + IdAct).innerHTML;

      document.getElementById("ModalPrecioVenta2").value =
        document.getElementById("PrecioVenta2" + IdAct).innerHTML;
      document.getElementById("ModalPrecioNeto2").value =
        document.getElementById("PrecioNeto2" + IdAct).innerHTML;

      document.getElementById("ModalPrecioVenta3").value =
        document.getElementById("PrecioVenta3" + IdAct).innerHTML;
      document.getElementById("ModalPrecioNeto3").value =
        document.getElementById("PrecioNeto3" + IdAct).innerHTML;

      document.getElementById("ModalPrecioVenta4").value =
        document.getElementById("PrecioVenta4" + IdAct).innerHTML;
      document.getElementById("ModalPrecioNeto4").value =
        document.getElementById("PrecioNeto4" + IdAct).innerHTML;

      document.getElementById("ModalPrecioVenta5").value =
        document.getElementById("PrecioVenta5" + IdAct).innerHTML;
      document.getElementById("ModalPrecioNeto5").value =
        document.getElementById("PrecioNeto5" + IdAct).innerHTML;

      document.getElementById("ModalPrecioVenta6").value =
        document.getElementById("PrecioVenta6" + IdAct).innerHTML;
      document.getElementById("ModalPrecioNeto6").value =
        document.getElementById("PrecioNeto6" + IdAct).innerHTML;

      document.getElementById("ModalPrecioVenta7").value =
        document.getElementById("PrecioVenta7" + IdAct).innerHTML;
      document.getElementById("ModalPrecioNeto7").value =
        document.getElementById("PrecioNeto7" + IdAct).innerHTML;

      document.getElementById("ModalPrecioVenta8").value =
        document.getElementById("PrecioVenta8" + IdAct).innerHTML;
      document.getElementById("ModalPrecioNeto8").value =
        document.getElementById("PrecioNeto8" + IdAct).innerHTML;

      document.getElementById("ModalPrecioVenta9").value =
        document.getElementById("PrecioVenta9" + IdAct).innerHTML;
      document.getElementById("ModalPrecioNeto9").value =
        document.getElementById("PrecioNeto9" + IdAct).innerHTML;

      document.getElementById("ModalPrecioVenta10").value =
        document.getElementById("PrecioVenta10" + IdAct).innerHTML;
      document.getElementById("ModalPrecioNeto10").value =
        document.getElementById("PrecioNeto10" + IdAct).innerHTML;

      document.getElementById("ModalMargen").value = document.getElementById(
        "margen1" + IdAct,
      ).innerHTML;
      document.getElementById("ModalMargen2").value = document.getElementById(
        "Margen200" + IdAct,
      ).innerHTML;
      document.getElementById("ModalMargen3").value = document.getElementById(
        "Margen3" + IdAct,
      ).innerHTML;
      document.getElementById("ModalMargen4").value = document.getElementById(
        "Margen4" + IdAct,
      ).innerHTML;

      document.getElementById("ModalMargen5").value = document.getElementById(
        "Margen5" + IdAct,
      ).innerHTML;

      document.getElementById("ModalMargen6").value = document.getElementById(
        "Margen6" + IdAct,
      ).innerHTML;

      document.getElementById("ModalMargen7").value = document.getElementById(
        "Margen7" + IdAct,
      ).innerHTML;

      document.getElementById("ModalMargen8").value = document.getElementById(
        "Margen8" + IdAct,
      ).innerHTML;

      document.getElementById("ModalMargen9").value = document.getElementById(
        "Margen9" + IdAct,
      ).innerHTML;

      document.getElementById("ModalMargen10").value = document.getElementById(
        "Margen10" + IdAct,
      ).innerHTML;

      document.getElementById("ModalCostos").value = document.getElementById(
        "costoneto" + IdAct,
      ).innerHTML;
      document.getElementById("ModalCostoNeto").value = document.getElementById(
        "costo" + IdAct,
      ).innerHTML;
    } else {
      $(
        "#ModalPrecioNeto, #ModalPrecioNeto2, #ModalPrecioNeto3, #ModalPrecioNeto4, #ModalPrecioNeto5, #ModalPrecioNeto6, #ModalPrecioNeto7, #ModalPrecioNeto8, #ModalPrecioNeto9, #ModalPrecioNeto10",
      ).val($("#ModalCostos").val());
      $(
        "#ModalMargen, #ModalMargen2, #ModalMargen3, #ModalMargen4, #ModalMargen5, #ModalMargen6, #ModalMargen7, #ModalMargen8, #ModalMargen9, #ModalMargen10",
      ).val(0);
      $(
        "#ModalPrecioVenta, #ModalPrecioVenta2, #ModalPrecioVenta3, #ModalPrecioVenta4, #ModalPrecioVenta5, #ModalPrecioVenta6, #ModalPrecioVenta7, #ModalPrecioVenta8, #ModalPrecioVenta9, #ModalPrecioVenta10",
      ).val($("#ModalCostoNeto").val());
    }
  } else if (document.getElementById("ModalTipOCosto").value === "1") {
    if (IdAct > 0) {
      document.getElementById("ModalCostoPercent").value =
        document.getElementById("CostoPorcentaje" + IdAct).innerHTML;
    } else {
      document.getElementById("ModalCostoPercent").value = 100;
    }
    const ImpuestoACT = new Number(
      document.getElementById(
        "ValordelImpuesto" + document.getElementById("ModalImpuestos").value,
      ).innerHTML,
    );

    $("#ModalCostoPercent,#CostoTitle03").show();
    $("#ModalCostoNeto,#ModalCostos,#CostoTitle02,#CostoTitle01").hide();
    $(
      "#ModalPrecioNeto, #ModalPrecioNeto2, #ModalPrecioNeto3, #ModalPrecioNeto4, #ModalPrecioNeto5, #ModalPrecioNeto6, #ModalPrecioNeto7, #ModalPrecioNeto8, #ModalPrecioNeto9, #ModalPrecioNeto10, #ModalMargen, #ModalMargen2, #ModalMargen3, #ModalMargen4, #ModalMargen5, #ModalMargen6, #ModalMargen7, #ModalMargen8, #ModalMargen9, #ModalMargen10, #ModalPrecioVenta, #ModalPrecioVenta2, #ModalPrecioVenta3, #ModalPrecioVenta4, #ModalPrecioVenta5, #ModalPrecioVenta6, #ModalPrecioVenta7, #ModalPrecioVenta8, #ModalPrecioVenta9, #ModalPrecioVenta10",
    ).prop("disabled", true);

    $(
      "#ModalPrecioNeto, #ModalPrecioNeto2, #ModalPrecioNeto3, #ModalPrecioNeto4, #ModalPrecioNeto5, #ModalPrecioNeto6, #ModalPrecioNeto7, #ModalPrecioNeto8, #ModalPrecioNeto9, #ModalPrecioNeto10",
    ).val((1 / (1 + ImpuestoACT / 100)).toFixed(2));
    $(
      "#ModalMargen, #ModalMargen2, #ModalMargen3, #ModalMargen4, #ModalMargen5, #ModalMargen6, #ModalMargen7, #ModalMargen8, #ModalMargen9, #ModalMargen10",
    ).val(0);
    $(
      "#ModalPrecioVenta, #ModalPrecioVenta2, #ModalPrecioVenta3, #ModalPrecioVenta4, #ModalPrecioVenta5, #ModalPrecioVenta6, #ModalPrecioVenta7, #ModalPrecioVenta8, #ModalPrecioVenta9, #ModalPrecioVenta10",
    ).val(1);
  }
}

function SendScan() {
  $("#ServerSideTable_search").val(responseHtml5);
  $("#ServerSideTable").DataTable().ajax.reload(null, false);
}

function calcArea(go = "") {
  if (isNaN(document.getElementById("ModalHeight" + go).value))
    document.getElementById("ModalHeight" + go).value = 0;
  if (isNaN(document.getElementById("ModalWeight" + go).value))
    document.getElementById("ModalWeight").value = 0;
  document.getElementById("ModalArea" + go).value =
    Math.round(
      document.getElementById("ModalHeight" + go).value *
        document.getElementById("ModalWeight" + go).value *
        0.00694444 *
        100,
    ) / 100;
}

function ChangeWidthHeight() {
  Idfamilia = document.getElementById("ModalIdfamilia").value;
  if (
    document.getElementById("ModalIdfamiliaSpan" + Idfamilia).innerHTML == 1
  ) {
    $("#ModalHeightModalWeighModalAreat").show();
    document.getElementById("ModalArea").value =
      IdAct === 0 ? 1 : document.getElementById("factorunit" + IdAct).innerHTML;
    document.getElementById("ModalWeight").value =
      IdAct === 0 ? 0 : document.getElementById("ancho" + IdAct).innerHTML;
    document.getElementById("ModalHeight").value =
      IdAct === 0 ? 0 : document.getElementById("alto" + IdAct).innerHTML;
    return;
  }
  $("#ModalHeightModalWeighModalAreat").hide();
  document.getElementById("ModalArea").value =
    IdAct === 0 ? 1 : document.getElementById("factorunit" + IdAct).innerHTML;
  document.getElementById("ModalWeight").value =
    IdAct === 0 ? 0 : document.getElementById("ancho" + IdAct).innerHTML;
  document.getElementById("ModalHeight").value =
    IdAct === 0 ? 0 : document.getElementById("alto" + IdAct).innerHTML;
  return;
}

function ChangeWidthHeightS() {
  IdfamiliaS = document.getElementById("ModalIdfamiliaS").value;
  if (
    document.getElementById("ModalIdfamiliaSSpan" + IdfamiliaS).innerHTML == 1
  ) {
    $("#ModalHeightModalWeighModalAreatS").show();
    document.getElementById("ModalAreaS").value =
      IdActS === 0
        ? 1
        : document.getElementById("factorunitxSS" + IdActS).innerHTML;
    document.getElementById("ModalWeightS").value =
      IdActS === 0 ? 0 : document.getElementById("anchoxSS" + IdActS).innerHTML;
    document.getElementById("ModalHeightS").value =
      IdActS === 0 ? 0 : document.getElementById("altoxSS" + IdActS).innerHTML;
    return;
  }
  $("#ModalHeightModalWeighModalAreatS").hide();
  document.getElementById("ModalAreaS").value =
    IdActS === 0
      ? 1
      : document.getElementById("factorunitxSS" + IdActS).innerHTML;
  document.getElementById("ModalWeightS").value =
    IdActS === 0 ? 0 : document.getElementById("anchoxSS" + IdActS).innerHTML;
  document.getElementById("ModalHeightS").value =
    IdActS === 0 ? 0 : document.getElementById("altoxSS" + IdActS).innerHTML;
  return;
}

function ChangeEstado() {
  if ($("#ModalEstado").prop("checked")) {
    document.getElementById("EstadoEstado").innerHTML = Utils2a.Activo;
  } else {
    document.getElementById("EstadoEstado").innerHTML = Utils2a.Inactivo;
  }
}

function auditoria(numero) {
  document.getElementById("codaud").value = document.getElementById(
    "CodIdBasicoMasterYI" + numero,
  ).innerHTML;
  document.getElementById("desaud").value = document.getElementById(
    "descripcion" + numero,
  ).innerHTML;
  ViewAuditoria();
}

function PagineoAud(n) {
  document.getElementById("PagActAud").innerHTML = n;
  ViewAuditoria();
}

function ViewAuditoria() {
  var CodIdBasico = document.getElementById("codaud").value;

  $("#AuditoriaBr")
    .on("search.dt", function (e, settings, processing) {
      $("#spinner_load2").removeClass("d-none");
      $(
        "#AuditoriaBr_wrapper .dt-layout-row .dt-end .dt-search .dt-input",
      ).focus();
    })
    .DataTable({
      search: {
        search: $(
          `#${"AuditoriaBr"}_wrapper .dt-layout-row .dt-end .dt-search .dt-input`,
        ).val(),
      },
      drawCallback: function () {
        $(
          "#AuditoriaBr_wrapper .dt-layout-row .dt-end .dt-search .dt-input",
        ).focus();
        $("#spinner_load2").addClass("d-none");
      },
      searchDelay: 800,
      responsive: true,
      processing: true,
      serverSide: true,
      ordering: false,
      language: {
        url: `lang/datatables/${
          document.getElementById("IdiomaActual").innerHTML
        }.json`,
      },
      ajax: {
        type: "POST",
        url: "productoseek.php",
        data: {
          Accion: "1",
          CompanyActual: document.getElementById("CompanyActual").innerHTML,
          EsCompuesto: document.getElementById("EleccionEc").innerHTML,
          CD: document.getElementById("CD").innerHTML,
          SimDec: document.getElementById("SimDec").innerHTML,
          SimMil: document.getElementById("SimMil").innerHTML,
          MonedaP: document.getElementById("MonedaP").innerHTML,
          MonedaS: document.getElementById("MonedaS").innerHTML,
          PerfilVentas: document.getElementById("PerfilVentas").innerHTML,
          CodIdBasico: CodIdBasico,
        },
      },
      destroy: true,
    });
  setTimeout(() => {
    $(
      "#AuditoriaBr_wrapper .dt-layout-row .dt-end .dt-search .dt-input",
    ).focus();
    $("#spinner_load2").addClass("d-none");
  }, 800);
  $("#apps-auditoria").modal("show");
}

function optionss() {
  if (document.getElementById("optioness").value == "0") {
  } else {
    var e = document.getElementById("optioness");
    var textoption = e.options[e.selectedIndex].text;
    var cod = document.getElementById("optioness").value;
    var json = document.getElementById("jcodo").value;
    $.ajax({
      type: "POST",
      url: "utilidadess.php",
      data: {
        cod: cod,
        json: json,
        nombre: textoption,
        Company: document.getElementById("CompanyActual").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        MonedaS: document.getElementById("MonedaS").innerHTML,
        Accion: "Cod-complemento",
      },
    }).done(function (msg) {
      if (msg == 1) {
        document.getElementById(
          "alertaerrorenproducto",
        ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Opcion_Repetida}</strong><br><small>${Utils2a.Desc1}</small>`;
        $("#alertaerrorenproducto").delay(100).fadeIn("slow");
        setTimeout(() => OcultarNotificacion2(), 5000);
        document.getElementById("ModalCodBarra").value = "";
      } else {
        $("#optiones").html(msg);
        $(".selectmodullo option[value='" + cod + "']").remove();
        document.getElementById("jcod2o").value =
          document.getElementById("jcodo").value;
      }
    });
  }
}

function deleteoptions(cod, text) {
  var json = document.getElementById("jcodo").value;
  $.ajax({
    type: "POST",
    url: "utilidadess.php",
    data: {
      code: cod,
      json: json,
      Company: document.getElementById("CompanyActual").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
      Accion: "eliminarcod-complemento",
    },
  }).done(function (msg) {
    $("#optiones").html(msg);
    $("#optioness").append(
      "<option value='" + cod + "' >" + text + "</option>",
    );

    document.getElementById("jcod2o").value =
      document.getElementById("jcodo").value;
  });
}

function complementos(numero) {
  document.getElementById("codaud2").value = document.getElementById(
    "CodIdBasicoMasterYI" + numero,
  ).innerHTML;
  document.getElementById("desaud2").value = document.getElementById(
    "descripcion" + numero,
  ).innerHTML;
  document.getElementById("comp").value = document.getElementById(
    "comple" + numero,
  ).innerHTML;
  viewcomplementos();
}

function viewcomplementos() {
  var CodIdBasico = document.getElementById("codaud2").value;
  var Descripcion = document.getElementById("desaud2").value;
  $.ajax({
    type: "POST",
    url: "utilidadess.php",
    data: {
      Accion: "complementos-select",
      Descripcion: Descripcion,
      CodIdBasico: CodIdBasico,
      userperfil: document.getElementById("userperfil").innerHTML,
      Company: document.getElementById("CompanyActual").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    $("#selectt").html(msg);
  });
  $.ajax({
    type: "POST",
    url: "utilidadess.php",
    data: {
      Accion: "complementos-productos",
      Descripcion: Descripcion,
      CodIdBasico: CodIdBasico,
      userperfil: document.getElementById("userperfil").innerHTML,
      Company: document.getElementById("CompanyActual").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    $("#optiones").html(msg);
    document.getElementById("jcod2o").value =
      document.getElementById("jcodo").value;
  });
  $("#apps-complementos").modal("show");
}

function guardarcomplementos() {
  var CodIdBasico = document.getElementById("codaud2").value;
  var Descripcion = document.getElementById("desaud2").value;
  var json = document.getElementById("jcod2o").value;
  $.ajax({
    type: "POST",
    url: "handlerutilidades.php",
    data: {
      go: "complementos",
      json: json,
      Descripcion: Descripcion,
      CodIdBasico: CodIdBasico,
      userperfil: document.getElementById("userperfil").innerHTML,
      Company: document.getElementById("CompanyActual").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    if (msg == "1") {
      $("#apps-complementos").modal("hide");
      $("#alertaerrorenproducto2").delay(500).fadeIn("slow");
      setTimeout(() => OcultarNotificacion2(), 4000);
    } else {
      $("#alertaerrorenproducto4").delay(500).fadeIn("slow");
      setTimeout(() => OcultarNotificacion2(), 4000);
    }
  });
}

function SoloExistenciaProd() {
  if (document.getElementById("SoloExistencia").checked) {
    $("#MostrarFiltros").show();
  } else {
    $("#MostrarFiltros").hide();
  }

  MuestraProd();
}

window.onload = function () {
  $("#EnvioFamilia").select2({
    dropdownParent: $("#demo"),
  });
  $("#EnvioMarca").select2({
    dropdownParent: $("#demo"),
  });
  $("#EnvioAlmacen").select2({
    dropdownParent: $("#demo"),
  });
  $("#EnvioUbicacion").select2({
    dropdownParent: $("#demo"),
  });
  $("#EnvioZonaAtencion").select2({
    dropdownParent: $("#demo"),
  });
  MuestraProd();
};
let editor;
/*
document
  .getElementById("ServerSideTable_lengthx")
  .addEventListener("change", function () {
    table.page
      .len(Number(document.getElementById("ServerSideTable_lengthx").value))
      .draw();
    //MuestraProd();
  });
  */
//  plugins: [ HtmlEmbed, ... ],
// toolbar: [ 'htmlEmbed', ... ],
ClassicEditor.create(document.querySelector("#editor"))
  .then((newEditor) => {
    editor = newEditor;
  })
  .catch((error) => {
    console.error(error);
  });
let editor2;
ClassicEditor.create(document.querySelector("#editor2"))
  .then((newEditor2) => {
    editor2 = newEditor2;
  })
  .catch((error) => {
    console.error(error);
  });

function preguardar(go = "") {
  if (
    document.getElementById("jcod" + go).value == "" &&
    document.getElementById("jcod" + go).value == "[]"
  ) {
    if (document.getElementById("ModalCodBarra" + go).value == "") {
      barraCod(document.getElementById("ModalCodIdAmpliado" + go).value);
    } else {
      barraCod(document.getElementById("ModalCodBarra" + go).value);
    }
  }
  $("button").prop("disabled", true);
  if (document.getElementById("ModalCodIdAmpliado" + go).value.trim() === "") {
    document.getElementById(
      "alertaerrorenproducto" + go,
    ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-info-circle text-warning"></i> ${Utils2a.Falta_Información}</strong><br><small>${Utils2a.Desc9}</small>`;
    $("#alertaerrorenproducto" + go)
      .delay(100)
      .fadeIn("slow");
    setTimeout(() => OcultarNotificacion2(go), 5000);
    $("button").prop("disabled", false);
    $("#Costos2" + go).removeClass("active");
    $("#Costos" + go).removeClass("show active");
    $("#Inventario2" + go).removeClass("active");
    $("#Inventario" + go).removeClass("show active");
    $("#Informacion2" + go).addClass("active");
    $("#Informacion" + go).addClass("show active");
    $("#ModalCodIdAmpliado" + go).focus();
    return;
  }
  if (
    document.getElementById("jcod" + go).value === "" ||
    document.getElementById("jcod" + go).value === "[]"
  ) {
    document.getElementById(
      "alertaerrorenproducto" + go,
    ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-info-circle text-warning"></i> ${Utils2a.Falta_Información}</strong><br><small>${Utils2a.Desc8}</small>`;
    $("#alertaerrorenproducto" + go)
      .delay(100)
      .fadeIn("slow");
    setTimeout(() => OcultarNotificacion2(go), 5000);
    $("button").prop("disabled", false);
    $("#Costos2" + go).removeClass("active");
    $("#Costos" + go).removeClass("show active");
    $("#Inventario2" + go).removeClass("active");
    $("#Inventario" + go).removeClass("show active");
    $("#Informacion2" + go).addClass("active");
    $("#Informacion" + go).addClass("show active");
    $("#ModalCodBarra" + go).focus();

    return;
  }

  setTimeout(() => {
    $("button").prop("disabled", false);
  }, 5000);
  $.ajax({
    type: "POST",
    url: "utilidadess.php",
    data: {
      Accion: "ValidarBarra",
      Barra: document.getElementById("jcod" + go).value,
      CodIdBasico: document.getElementById("ModalCodIdBasico" + go).value,
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    if (msg == "") {
      $.ajax({
        type: "POST",
        url: "dataseeks/Dataseek2r.php",
        data: {
          Necesito: "Respuestas",
          Descripcion: document.getElementById("ModalDescripcion" + go).value,
          CodIdBasico: document.getElementById("ModalCodIdBasico" + go).value,
          SKU: document.getElementById("ModalCodIdAmpliado" + go).value,
          CodBarra: document.getElementById("ModalCodBarra" + go).value,
          CompanyActual: document.getElementById("CompanyActual").innerHTML,
          CD: document.getElementById("CD").innerHTML,
          SimDec: document.getElementById("SimDec").innerHTML,
          SimMil: document.getElementById("SimMil").innerHTML,
          MonedaP: document.getElementById("MonedaP").innerHTML,
          MonedaS: document.getElementById("MonedaS").innerHTML,
        },
      }).done(function (msg) {
        if (msg == 1 || msg == 2) {
          guardar(go);
        }
        if (msg == 3) {
          document.getElementById(
            "alertaerrorenproducto" + go,
          ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Caracteres_Inválidos}</strong><br><small> ${Utils2a.Desc2}</small>`;
          $("#alertaerrorenproducto" + go)
            .delay(100)
            .fadeIn("slow");
          setTimeout(() => OcultarNotificacion2(go), 5000);
          $("button").prop("disabled", false);
        }
        if (msg == 4) {
          document.getElementById(
            "alertaerrorenproducto" + go,
          ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Caracteres_Inválidos}</strong><br><small>${Utils2a.Desc3}</small>`;
          $("#alertaerrorenproducto" + go)
            .delay(100)
            .fadeIn("slow");
          setTimeout(() => OcultarNotificacion2(go), 5000);
          $("button").prop("disabled", false);
          $("#Costos2" + go).removeClass("active");
          $("#Costos" + go).removeClass("show active");
          $("#Inventario2" + go).removeClass("active");
          $("#Inventario" + go).removeClass("show active");
          $("#Variaciones2" + go).removeClass("active");
          $("#Variaciones" + go).removeClass("active");

          $("#Informacion2" + go).addClass("active");
          $("#Informacion" + go).addClass("show active");
          $("#ModalCodBarra" + go).focus();
        }
        if (msg == 5) {
          document.getElementById(
            "alertaerrorenproducto" + go,
          ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Caracteres_Inválidos}</strong><br><small>${Utils2a.Desc4}</small>`;
          $("#alertaerrorenproducto" + go)
            .delay(100)
            .fadeIn("slow");
          setTimeout(() => OcultarNotificacion2(go), 5000);
          $("button").prop("disabled", false);
          $("#Costos2" + go).removeClass("active");
          $("#Costos" + go).removeClass("show active");
          $("#Variaciones2" + go).removeClass("active");
          $("#Variaciones" + go).removeClass("active");
          $("#Inventario2" + go).removeClass("active");
          $("#Inventario" + go).removeClass("show active");
          $("#Informacion2" + go).addClass("active");
          $("#Informacion" + go).addClass("show active");
          $("#ModalCodIdAmpliado").focus();
        }
        if (msg == 6) {
          document.getElementById(
            "alertaerrorenproducto" + go,
          ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Caracteres_Inválidos}</strong><br><small>${Utils2a.Desc5}</small>`;
          $("#alertaerrorenproducto" + go)
            .delay(100)
            .fadeIn("slow");
          setTimeout(() => OcultarNotificacion2(go), 5000);
          $("button").prop("disabled", false);
          $("#Costos2" + go).removeClass("active");
          $("#Costos" + go).removeClass("show active");
          $("#Variaciones2" + go).removeClass("active");
          $("#Variaciones" + go).removeClass("active");
          $("#Inventario2" + go).removeClass("active");
          $("#Inventario" + go).removeClass("show active");
          $("#Informacion2" + go).addClass("active");
          $("#Informacion" + go).addClass("show active");
          $("#ModalDescripcion").focus();
        }
        if (msg == 0) {
          document.getElementById(
            "alertaerrorenproducto" + go,
          ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.SKU_Repetido}</strong><br><small>${Utils2a.Desc6}</small>`;
          $("#alertaerrorenproducto" + go)
            .delay(100)
            .fadeIn("slow");
          setTimeout(() => OcultarNotificacion2(go), 5000);
          $("button").prop("disabled", false);
          $("#Costos2").removeClass("active");
          $("#Costos").removeClass("show active");
          $("#Variaciones2" + go).removeClass("active");
          $("#Variaciones" + go).removeClass("active");
          $("#Inventario2" + go).removeClass("active");
          $("#Inventario" + go).removeClass("show active");
          $("#Informacion2" + go).addClass("active");
          $("#Informacion" + go).addClass("show active");
          $("#ModalCodIdAmpliado").focus();
        }
      });
    } else {
      document.getElementById(
        "alertaerrorenproducto" + go,
      ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Código_Repetido}</strong><br><small>${Utils2a.Desc7}:<strong> ${msg} </strong></small>`;
      $("#alertaerrorenproducto" + go)
        .delay(100)
        .fadeIn("slow");
      setTimeout(() => OcultarNotificacion2(go), 5000);
      $("button").prop("disabled", false);
      document.getElementById("ModalCodBarra" + go).value = "";
      $("#Costos2" + go).removeClass("active");
      $("#Costos" + go).removeClass("show active");
      $("#Variaciones2" + go).removeClass("active");
      $("#Variaciones" + go).removeClass("active");
      $("#Inventario2" + go).removeClass("active");
      $("#Inventario" + go).removeClass("show active");
      $("#Informacion2" + go).addClass("active");
      $("#Informacion" + go).addClass("show active");
      $("#ModalCodBarra" + go).focus();
    }
  });
}

// function preguardar(go = "") {
//   if (
//     document.getElementById("jcod" + go).value == "" &&
//     document.getElementById("jcod" + go).value == "[]"
//   ) {
//     if (document.getElementById("ModalCodBarra" + go).value == "") {
//       barraCod(document.getElementById("ModalCodIdAmpliado" + go).value);
//     } else {
//       barraCod(document.getElementById("ModalCodBarra" + go).value);
//     }
//   }

//   $("button").prop("disabled", true);
//   if (document.getElementById("ModalCodIdAmpliado" + go).value.trim() !== "") {
//     if (
//       document.getElementById("jcod" + go).value !== "" &&
//       document.getElementById("jcod" + go).value !== "[]"
//     ) {
//       $.ajax({
//         type: "POST",
//         url: "utilidadess.php",
//         data: {
//           Accion: "ValidarBarra",
//           Barra: document.getElementById("jcod" + go).value,
//           CodIdBasico: document.getElementById("ModalCodIdBasico" + go).value,
//           CompanyActual: document.getElementById("CompanyActual").innerHTML,
//           CD: document.getElementById("CD").innerHTML,
//           SimDec: document.getElementById("SimDec").innerHTML,
//           SimMil: document.getElementById("SimMil").innerHTML,
//           MonedaP: document.getElementById("MonedaP").innerHTML,
//           MonedaS: document.getElementById("MonedaS").innerHTML,
//         },
//       }).done(function (msg) {
//         if (msg == "") {
//           $.ajax({
//             type: "POST",
//             url: "dataseeks/Dataseek2r.php",
//             data: {
//               Necesito: "Respuestas",
//               Descripcion: document.getElementById("ModalDescripcion" + go)
//                 .value,
//               CodIdBasico: document.getElementById("ModalCodIdBasico" + go)
//                 .value,
//               SKU: document.getElementById("ModalCodIdAmpliado" + go).value,
//               CodBarra: document.getElementById("ModalCodBarra" + go).value,
//               CompanyActual: document.getElementById("CompanyActual").innerHTML,
//               CD: document.getElementById("CD").innerHTML,
//               SimDec: document.getElementById("SimDec").innerHTML,
//               SimMil: document.getElementById("SimMil").innerHTML,
//               MonedaP: document.getElementById("MonedaP").innerHTML,
//               MonedaS: document.getElementById("MonedaS").innerHTML,
//             },
//           }).done(function (msg) {
//             if (msg == 1 || msg == 2) {
//               guardar(go);
//             }
//             if (msg == 3) {
//               document.getElementById(
//                 "alertaerrorenproducto" + go,
//               ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Caracteres_Inválidos}</strong><br><small> ${Utils2a.Desc2}</small>`;
//               $("#alertaerrorenproducto" + go)
//                 .delay(100)
//                 .fadeIn("slow");
//               setTimeout(() => OcultarNotificacion2(go), 5000);
//               $("button").prop("disabled", false);
//             }
//             if (msg == 4) {
//               document.getElementById(
//                 "alertaerrorenproducto" + go,
//               ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Caracteres_Inválidos}</strong><br><small>${Utils2a.Desc3}</small>`;
//               $("#alertaerrorenproducto" + go)
//                 .delay(100)
//                 .fadeIn("slow");
//               setTimeout(() => OcultarNotificacion2(go), 5000);
//               $("button").prop("disabled", false);
//               $("#Costos2" + go).removeClass("active");
//               $("#Costos" + go).removeClass("show active");
//               $("#Inventario2" + go).removeClass("active");
//               $("#Inventario" + go).removeClass("show active");
//               $("#Variaciones2" + go).removeClass("active");
//               $("#Variaciones" + go).removeClass("active");

//               $("#Informacion2" + go).addClass("active");
//               $("#Informacion" + go).addClass("show active");
//               $("#ModalCodBarra" + go).focus();
//             }
//             if (msg == 5) {
//               document.getElementById(
//                 "alertaerrorenproducto" + go,
//               ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Caracteres_Inválidos}</strong><br><small>${Utils2a.Desc4}</small>`;
//               $("#alertaerrorenproducto" + go)
//                 .delay(100)
//                 .fadeIn("slow");
//               setTimeout(() => OcultarNotificacion2(go), 5000);
//               $("button").prop("disabled", false);
//               $("#Costos2" + go).removeClass("active");
//               $("#Costos" + go).removeClass("show active");
//               $("#Variaciones2" + go).removeClass("active");
//               $("#Variaciones" + go).removeClass("active");
//               $("#Inventario2" + go).removeClass("active");
//               $("#Inventario" + go).removeClass("show active");
//               $("#Informacion2" + go).addClass("active");
//               $("#Informacion" + go).addClass("show active");
//               $("#ModalCodIdAmpliado").focus();
//             }
//             if (msg == 6) {
//               document.getElementById(
//                 "alertaerrorenproducto" + go,
//               ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Caracteres_Inválidos}</strong><br><small>${Utils2a.Desc5}</small>`;
//               $("#alertaerrorenproducto" + go)
//                 .delay(100)
//                 .fadeIn("slow");
//               setTimeout(() => OcultarNotificacion2(go), 5000);
//               $("button").prop("disabled", false);
//               $("#Costos2" + go).removeClass("active");
//               $("#Costos" + go).removeClass("show active");
//               $("#Variaciones2" + go).removeClass("active");
//               $("#Variaciones" + go).removeClass("active");
//               $("#Inventario2" + go).removeClass("active");
//               $("#Inventario" + go).removeClass("show active");
//               $("#Informacion2" + go).addClass("active");
//               $("#Informacion" + go).addClass("show active");
//               $("#ModalDescripcion").focus();
//             }
//             if (msg == 0) {
//               document.getElementById(
//                 "alertaerrorenproducto" + go,
//               ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.SKU_Repetido}</strong><br><small>${Utils2a.Desc6}</small>`;
//               $("#alertaerrorenproducto" + go)
//                 .delay(100)
//                 .fadeIn("slow");
//               setTimeout(() => OcultarNotificacion2(go), 5000);
//               $("button").prop("disabled", false);
//               $("#Costos2").removeClass("active");
//               $("#Costos").removeClass("show active");
//               $("#Variaciones2" + go).removeClass("active");
//               $("#Variaciones" + go).removeClass("active");
//               $("#Inventario2" + go).removeClass("active");
//               $("#Inventario" + go).removeClass("show active");
//               $("#Informacion2" + go).addClass("active");
//               $("#Informacion" + go).addClass("show active");
//               $("#ModalCodIdAmpliado").focus();
//             }
//           });
//         } else {
//           document.getElementById(
//             "alertaerrorenproducto" + go,
//           ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Código_Repetido}</strong><br><small>${Utils2a.Desc7}:<strong> ${msg} </strong></small>`;
//           $("#alertaerrorenproducto" + go)
//             .delay(100)
//             .fadeIn("slow");
//           setTimeout(() => OcultarNotificacion2(go), 5000);
//           $("button").prop("disabled", false);
//           document.getElementById("ModalCodBarra" + go).value = "";
//           $("#Costos2" + go).removeClass("active");
//           $("#Costos" + go).removeClass("show active");
//           $("#Variaciones2" + go).removeClass("active");
//           $("#Variaciones" + go).removeClass("active");
//           $("#Inventario2" + go).removeClass("active");
//           $("#Inventario" + go).removeClass("show active");
//           $("#Informacion2" + go).addClass("active");
//           $("#Informacion" + go).addClass("show active");
//           $("#ModalCodBarra" + go).focus();
//         }
//       });
//     } else {
//       document.getElementById(
//         "alertaerrorenproducto" + go,
//       ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-info-circle text-warning"></i> ${Utils2a.Falta_Información}</strong><br><small>${Utils2a.Desc8}</small>`;
//       $("#alertaerrorenproducto" + go)
//         .delay(100)
//         .fadeIn("slow");
//       setTimeout(() => OcultarNotificacion2(go), 5000);
//       $("button").prop("disabled", false);
//       $("#Costos2" + go).removeClass("active");
//       $("#Costos" + go).removeClass("show active");
//       $("#Inventario2" + go).removeClass("active");
//       $("#Inventario" + go).removeClass("show active");
//       $("#Informacion2" + go).addClass("active");
//       $("#Informacion" + go).addClass("show active");
//       $("#ModalCodBarra" + go).focus();
//     }
//   } else {
//     document.getElementById(
//       "alertaerrorenproducto" + go,
//     ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-info-circle text-warning"></i> ${Utils2a.Falta_Información}</strong><br><small>${Utils2a.Desc9}</small>`;
//     $("#alertaerrorenproducto" + go)
//       .delay(100)
//       .fadeIn("slow");
//     setTimeout(() => OcultarNotificacion2(go), 5000);
//     $("button").prop("disabled", false);
//     $("#Costos2" + go).removeClass("active");
//     $("#Costos" + go).removeClass("show active");
//     $("#Inventario2" + go).removeClass("active");
//     $("#Inventario" + go).removeClass("show active");
//     $("#Informacion2" + go).addClass("active");
//     $("#Informacion" + go).addClass("show active");
//     $("#ModalCodIdAmpliado" + go).focus();
//   }
// }

function abrir12343() {
  EnvioI();
  $("#apps-modal3").modal("toggle");
  $("#MostrarSeriales").modal("show");
}

function abrir123435(numero) {
  document.getElementById("ModalCodBarra22").value = document.getElementById(
    "codidampliado" + numero,
  ).innerHTML;
  document.getElementById("ModalDescripcion22").value = document.getElementById(
    "descripcion" + numero,
  ).innerHTML;
  document.getElementById("serialesspan2").innerHTML = document.getElementById(
    "CodIdBasicoMasterYI" + numero,
  ).innerHTML;
  EnvioIE();
  document.getElementById("serialesspan2x").innerHTML =
    document.getElementById("codidampliado" + numero).innerHTML +
    " - " +
    document.getElementById("descripcion" + numero).innerHTML;
  document.getElementById("CodIdBasico").value = document.getElementById(
    "CodIdBasicoMasterYI" + numero,
  ).innerHTML;
  document.getElementById("CodIdBasicoM").value = document.getElementById(
    "CodIdBasicoMasterYI" + numero,
  ).innerHTML;
  document.getElementById("ModalDescripcionM").value = document.getElementById(
    "descripcion" + numero,
  ).innerHTML;
  document.getElementById("ModalCodBarraM").value = document.getElementById(
    "codidampliado" + numero,
  ).innerHTML;
  $("#Pedidos").removeClass("active");
  $("#Pedidos2").removeClass("active");
  $("#Seriales").addClass("active");
  $("#Seriales2").addClass("active");
  EnvioIE();
  EnvioI2();
  reset();
  $("#MostrarSeriales2").modal("show");
}

function varproduct(numero) {
  document.getElementById("barrascod").innerHTML =
    "<input id='jcod' name='jcod' style='display:none'></input>";
  document.getElementById("titlemodal").innerHTML =
    document.getElementById("EleccionEc").innerHTML === "0"
      ? Utils2a.Agregar_Producto
      : Utils2a.Agregar_Servicio;
  document.getElementById("checkvar").innerHTML =
    '<input type="checkbox" class="d-none" id="OnVariacion" name="OnVariacion">';
  document.getElementById("variac").innerHTML = `
	<div class="form-floating my-1">
		<input type="text"  class="form-control" id="Groupvar" name="Groupvar" value="" />
		<label><span class="fa fa-bars" ></span>&nbsp;${Utils2a.Variación}</label>
	</div>
`;
  document.getElementById("variac2").innerHTML = `
	<div class="form-floating my-1">
		<input type="text"  class="form-control" id="TextVar" name="TextVar" value="" />
		<label><span  class="fa fa-bars" ></span>&nbsp; ${Utils2a.Descripción_de_Variación}</label>
	</div>
`;

  $("#Informacion").addClass("active");
  $("#Informacion2").addClass("active");
  $("#apps-modal").modal("show");
  $("#Costos").removeClass("active");
  $("#Costos2").removeClass("active");
  $("#Inventario").removeClass("active");
  $("#Inventario2").removeClass("active");
  document.getElementById("ModalDescripcion").readOnly = true;
  if (numero > 0) {
    valor = document.getElementById("porkilo" + numero).innerHTML;
    if (document.getElementById("Estees").innerHTML == "0") {
      if (valor === "1") {
        $("#ModalPorKilo").prop("checked", true);
      } else {
        $("#ModalPorKilo").prop("checked", false);
      }
    }
    valor = document.getElementById("estado" + numero).innerHTML;
    if (valor === "1") {
      $("#ModalEstado").prop("checked", true);
    } else {
      $("#ModalEstado").prop("checked", false);
    }
    ChangeEstado();
    document.getElementById("Comision").value = document.getElementById(
      "com" + numero,
    ).innerHTML;
    document.getElementById("Comision2").value = document.getElementById(
      "comd" + numero,
    ).innerHTML;
    document.getElementById("Comision3").value = document.getElementById(
      "comt" + numero,
    ).innerHTML;
    document.getElementById("Comision4").value = document.getElementById(
      "comcua" + numero,
    ).innerHTML;
    document.getElementById("Comision5").value = document.getElementById(
      "com5" + numero,
    ).innerHTML;
    document.getElementById("Comision6").value = document.getElementById(
      "com6" + numero,
    ).innerHTML;
    document.getElementById("Comision7").value = document.getElementById(
      "com7" + numero,
    ).innerHTML;
    document.getElementById("Comision8").value = document.getElementById(
      "com8" + numero,
    ).innerHTML;
    document.getElementById("Comision9").value = document.getElementById(
      "com9" + numero,
    ).innerHTML;
    document.getElementById("Comision10").value = document.getElementById(
      "com10" + numero,
    ).innerHTML;

    document.getElementById("ModalCodIdAmpliado").value =
      document.getElementById("codidampliado" + numero).innerHTML;
    document.getElementById("ModalDescripcion").value = document.getElementById(
      "descripcion" + numero,
    ).innerHTML;
    document.getElementById("ModalFactorAltValue").value =
      document.getElementById("FactorAlter" + numero).innerHTML;
    document.getElementById("ModalFactorAltName").value =
      document.getElementById("UnidadAlter" + numero).innerHTML;
    document.getElementById("ModalMedida").value = document.getElementById(
      "medida" + numero,
    ).innerHTML;
    document.getElementById("ModalMedidas").value = document.getElementById(
      "medida" + numero,
    ).innerHTML;
    document.getElementById("ModalMargen2").value = document.getElementById(
      "Margen200" + numero,
    ).innerHTML;
    document.getElementById("ModalPrecioVenta2").value =
      document.getElementById("PrecioVenta2" + numero).innerHTML;
    document.getElementById("ModalPrecioNeto2").value = document.getElementById(
      "PrecioNeto2" + numero,
    ).innerHTML;
    document.getElementById("ModalMargen3").value = document.getElementById(
      "Margen3" + numero,
    ).innerHTML;
    document.getElementById("ModalPrecioVenta3").value =
      document.getElementById("PrecioVenta3" + numero).innerHTML;
    document.getElementById("ModalPrecioNeto3").value = document.getElementById(
      "PrecioNeto3" + numero,
    ).innerHTML;

    document.getElementById("ModalMargen4").value = document.getElementById(
      "Margen4" + numero,
    ).innerHTML;
    document.getElementById("ModalPrecioVenta4").value =
      document.getElementById("PrecioVenta4" + numero).innerHTML;
    document.getElementById("ModalPrecioNeto4").value = document.getElementById(
      "PrecioNeto4" + numero,
    ).innerHTML;

    document.getElementById("ModalMargen5").value = document.getElementById(
      "Margen5" + numero,
    ).innerHTML;
    document.getElementById("ModalPrecioVenta5").value =
      document.getElementById("PrecioVenta5" + numero).innerHTML;
    document.getElementById("ModalPrecioNeto5").value = document.getElementById(
      "PrecioNeto5" + numero,
    ).innerHTML;

    document.getElementById("ModalMargen6").value = document.getElementById(
      "Margen6" + numero,
    ).innerHTML;
    document.getElementById("ModalPrecioVenta6").value =
      document.getElementById("PrecioVenta6" + numero).innerHTML;
    document.getElementById("ModalPrecioNeto6").value = document.getElementById(
      "PrecioNeto6" + numero,
    ).innerHTML;

    document.getElementById("ModalMargen7").value = document.getElementById(
      "Margen7" + numero,
    ).innerHTML;
    document.getElementById("ModalPrecioVenta7").value =
      document.getElementById("PrecioVenta7" + numero).innerHTML;
    document.getElementById("ModalPrecioNeto7").value = document.getElementById(
      "PrecioNeto7" + numero,
    ).innerHTML;

    document.getElementById("ModalMargen8").value = document.getElementById(
      "Margen8" + numero,
    ).innerHTML;
    document.getElementById("ModalPrecioVenta8").value =
      document.getElementById("PrecioVenta8" + numero).innerHTML;
    document.getElementById("ModalPrecioNeto8").value = document.getElementById(
      "PrecioNeto8" + numero,
    ).innerHTML;

    document.getElementById("ModalMargen9").value = document.getElementById(
      "Margen9" + numero,
    ).innerHTML;
    document.getElementById("ModalPrecioVenta9").value =
      document.getElementById("PrecioVenta9" + numero).innerHTML;
    document.getElementById("ModalPrecioNeto9").value = document.getElementById(
      "PrecioNeto9" + numero,
    ).innerHTML;

    document.getElementById("ModalMargen10").value = document.getElementById(
      "Margen10" + numero,
    ).innerHTML;
    document.getElementById("ModalPrecioVenta10").value =
      document.getElementById("PrecioVenta10" + numero).innerHTML;
    document.getElementById("ModalPrecioNeto10").value =
      document.getElementById("PrecioNeto10" + numero).innerHTML;

    document.getElementById("ModalCodIdBasico02").value =
      document.getElementById("codidbasico1" + numero).innerHTML;
    document.getElementById("ModalCostos").value = document.getElementById(
      "costoneto" + numero,
    ).innerHTML;
    document.getElementById("ModalMargen").value = document.getElementById(
      "margen1" + numero,
    ).innerHTML;
    document.getElementById("ModalDescripcion2").value =
      document.getElementById("descripcion" + numero).innerHTML;
    document.getElementById("ModalCostoNeto").value = document.getElementById(
      "costo" + numero,
    ).innerHTML;
    document.getElementById("ModalPrecioNeto").value = document.getElementById(
      "precioneto1" + numero,
    ).innerHTML;
    document.getElementById("ModalPrecioVenta").value = document.getElementById(
      "preciodeventa2" + numero,
    ).innerHTML;
    document.getElementById("ModalCodIdBasico3").value =
      document.getElementById("codidbasico1" + numero).innerHTML;
    document.getElementById("serialesspan").innerHTML =
      document.getElementById("ModalCodIdBasico3").value;
    document.getElementById("ModalEnvase").value = document.getElementById(
      "envase" + numero,
    ).innerHTML;
    document.getElementById("ModalDescripcion3").value =
      document.getElementById("descripcion" + numero).innerHTML;
    document.getElementById("ModalMin").value = document.getElementById(
      "min" + numero,
    ).innerHTML;
    document.getElementById("ModalMax").value = document.getElementById(
      "max" + numero,
    ).innerHTML;
    document.getElementById("ModalCodIdBasico3").value = "";
    document.getElementById("ModalCodIdBasico").value = "";
    document.getElementById("ModalCodIdBasicoPadre").value =
      document.getElementById("codidbasico1" + numero).innerHTML;
    document.getElementById("ModalDescripcion3").readOnly = true;
    document.getElementById("ModalCodIdBasico3").readOnly = true;
    document.getElementById("ModalCodIdBasico").readOnly = true;
    document.getElementById("ModalCodIdAmpliado").readOnly = false;
    document.getElementById("ModalMarca").value = document.getElementById(
      "marca" + numero,
    ).innerHTML;
    document.getElementById("ModalIdfamilia").value = document.getElementById(
      "idfamilia" + numero,
    ).innerHTML;
    document.getElementById("ModalImpuestos").value = document.getElementById(
      "impuesto" + numero,
    ).innerHTML;
    document.getElementById("jsonfactor").innerHTML = document.getElementById(
      "jsonfactor" + numero,
    ).innerHTML;
    verfactores();
    document.getElementById("ModalMedida2").value = document.getElementById(
      "UnidadP1x" + numero,
    ).innerHTML;
    document.getElementById("ModalCant2").value = document.getElementById(
      "CantP1x" + numero,
    ).innerHTML;
    document.getElementById("ModalMedida3").value = document.getElementById(
      "UnidadP2x" + numero,
    ).innerHTML;
    document.getElementById("ModalCant3").value = document.getElementById(
      "CantP2" + numero,
    ).innerHTML;
    document.getElementById("ModalMedida4").value = document.getElementById(
      "UnidadP4x" + numero,
    ).innerHTML;
    document.getElementById("ModalCant4").value = document.getElementById(
      "CantP4x" + numero,
    ).innerHTML;

    document.getElementById("ModalMedida5").value = document.getElementById(
      "UnidadP5x" + numero,
    ).innerHTML;
    document.getElementById("ModalCant5").value = document.getElementById(
      "CantP5x" + numero,
    ).innerHTML;
    document.getElementById("ModalMedida6").value = document.getElementById(
      "UnidadP6x" + numero,
    ).innerHTML;
    document.getElementById("ModalCant6").value = document.getElementById(
      "CantP6x" + numero,
    ).innerHTML;
    document.getElementById("ModalMedida7").value = document.getElementById(
      "UnidadP7x" + numero,
    ).innerHTML;
    document.getElementById("ModalCant7").value = document.getElementById(
      "CantP7x" + numero,
    ).innerHTML;
    document.getElementById("ModalMedida8").value = document.getElementById(
      "UnidadP8x" + numero,
    ).innerHTML;
    document.getElementById("ModalCant8").value = document.getElementById(
      "CantP8x" + numero,
    ).innerHTML;
    document.getElementById("ModalMedida9").value = document.getElementById(
      "UnidadP9x" + numero,
    ).innerHTML;
    document.getElementById("ModalCant9").value = document.getElementById(
      "CantP9x" + numero,
    ).innerHTML;
    document.getElementById("ModalMedida10").value = document.getElementById(
      "UnidadP10x" + numero,
    ).innerHTML;
    document.getElementById("ModalCant10").value = document.getElementById(
      "CantP10x" + numero,
    ).innerHTML;

    if (
      document.getElementById("CantP1x" + numero).innerHTML == "" ||
      document.getElementById("CantP1x" + numero).innerHTML == "0"
    ) {
      document.getElementById("ModalCant2").value = "1";
    }
    if (
      document.getElementById("CantP2" + numero).innerHTML == "" ||
      document.getElementById("CantP2" + numero).innerHTML == "0"
    ) {
      document.getElementById("ModalCant3").value = "1";
    }
    if (
      document.getElementById("CantP4x" + numero).innerHTML == "" ||
      document.getElementById("CantP4x" + numero).innerHTML == "0"
    ) {
      document.getElementById("ModalCant4").value = "1";
    }
    if (
      document.getElementById("CantP5x" + numero).innerHTML == "" ||
      document.getElementById("CantP5x" + numero).innerHTML == "0"
    )
      document.getElementById("ModalCant5").value = "1";

    if (
      document.getElementById("CantP6x" + numero).innerHTML == "" ||
      document.getElementById("CantP6x" + numero).innerHTML == "0"
    )
      document.getElementById("ModalCant6").value = "1";

    if (
      document.getElementById("CantP7x" + numero).innerHTML == "" ||
      document.getElementById("CantP7x" + numero).innerHTML == "0"
    )
      document.getElementById("ModalCant7").value = "1";

    if (
      document.getElementById("CantP8x" + numero).innerHTML == "" ||
      document.getElementById("CantP8x" + numero).innerHTML == "0"
    )
      document.getElementById("ModalCant8").value = "1";

    if (
      document.getElementById("CantP9x" + numero).innerHTML == "" ||
      document.getElementById("CantP9x" + numero).innerHTML == "0"
    )
      document.getElementById("ModalCant9").value = "1";

    if (
      document.getElementById("CantP10x" + numero).innerHTML == "" ||
      document.getElementById("CantP10x" + numero).innerHTML == "0"
    )
      document.getElementById("ModalCant10").value = "1";

    $.ajax({
      type: "POST",
      url: "dataseeks/Dataseek2r.php",
      data: {
        Almacen: "3",
        Id: document.getElementById("ModalCodIdBasico3").value,
        CompanyActual: document.getElementById("CompanyActual").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        MonedaS: document.getElementById("MonedaS").innerHTML,
      },
    }).done(function (msg) {
      $("#abcdfghjqwet").html(msg);
    });
    $.ajax({
      type: "POST",
      url: "DataHandler1.php",
      data: {
        Accion: "Stock",
        ModalCodIdBasico: document.getElementById("codidbasico1" + numero)
          .innerHTML,
        companyUser: document.getElementById("com" + numero).value,
        ModalMedida: document.getElementById("medida" + numero).innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        MonedaS: document.getElementById("MonedaS").innerHTML,
      },
    }).done(function (msg) {
      $("#Resultado").html(msg);
    });

    var NewMargen = new Number(document.getElementById("ModalMargen").value);
    var NewCostoNeto = new Number(
      document.getElementById("ModalCostoNeto").value,
    );
    var NewPrecioBruto = new Number(
      document.getElementById("ModalPrecioNeto").value,
    );
    var NewCostoBruto = new Number(
      document.getElementById("ModalCostos").value,
    );
    var NewPrecioNeto = new Number(
      document.getElementById("ModalPrecioVenta").value,
    );
    var NewPrecioBruto2 = new Number(
      document.getElementById("ModalPrecioNeto2").value,
    );
    var NewPrecioNeto2 = new Number(
      document.getElementById("ModalPrecioVenta2").value,
    );
    var NewMargen2 = new Number(document.getElementById("ModalMargen2").value);
    var NewPrecioBruto3 = new Number(
      document.getElementById("ModalPrecioNeto3").value,
    );
    var NewPrecioNeto3 = new Number(
      document.getElementById("ModalPrecioVenta3").value,
    );
    var NewMargen3 = new Number(document.getElementById("ModalMargen3").value);

    var NewPrecioBruto4 = new Number(
      document.getElementById("ModalPrecioNeto4").value,
    );
    var NewPrecioNeto4 = new Number(
      document.getElementById("ModalPrecioVenta4").value,
    );
    var NewMargen4 = new Number(document.getElementById("ModalMargen4").value);

    var NewPrecioBruto5 = new Number(
      document.getElementById("ModalPrecioNeto5").value,
    );
    var NewPrecioNeto5 = new Number(
      document.getElementById("ModalPrecioVenta5").value,
    );
    var NewMargen5 = new Number(document.getElementById("ModalMargen5").value);

    var NewPrecioBruto6 = new Number(
      document.getElementById("ModalPrecioNeto6").value,
    );
    var NewPrecioNeto6 = new Number(
      document.getElementById("ModalPrecioVenta6").value,
    );
    var NewMargen6 = new Number(document.getElementById("ModalMargen6").value);

    var NewPrecioBruto7 = new Number(
      document.getElementById("ModalPrecioNeto7").value,
    );
    var NewPrecioNeto7 = new Number(
      document.getElementById("ModalPrecioVenta7").value,
    );
    var NewMargen7 = new Number(document.getElementById("ModalMargen7").value);

    var NewPrecioBruto8 = new Number(
      document.getElementById("ModalPrecioNeto8").value,
    );
    var NewPrecioNeto8 = new Number(
      document.getElementById("ModalPrecioVenta8").value,
    );
    var NewMargen8 = new Number(document.getElementById("ModalMargen8").value);

    var NewPrecioBruto9 = new Number(
      document.getElementById("ModalPrecioNeto9").value,
    );
    var NewPrecioNeto9 = new Number(
      document.getElementById("ModalPrecioVenta9").value,
    );
    var NewMargen9 = new Number(document.getElementById("ModalMargen9").value);

    var NewPrecioBruto10 = new Number(
      document.getElementById("ModalPrecioNeto10").value,
    );
    var NewPrecioNeto10 = new Number(
      document.getElementById("ModalPrecioVenta10").value,
    );
    var NewMargen10 = new Number(
      document.getElementById("ModalMargen10").value,
    );

    var ModalCant2 = new Number(document.getElementById("ModalCant2").value);
    var ModalCant3 = new Number(document.getElementById("ModalCant3").value);
    var ModalCant4 = new Number(document.getElementById("ModalCant4").value);
    var ModalCant5 = new Number(document.getElementById("ModalCant5").value);
    var ModalCant6 = new Number(document.getElementById("ModalCant6").value);
    var ModalCant7 = new Number(document.getElementById("ModalCant7").value);
    var ModalCant8 = new Number(document.getElementById("ModalCant8").value);
    var ModalCant9 = new Number(document.getElementById("ModalCant9").value);
    var ModalCant10 = new Number(document.getElementById("ModalCant10").value);

    document.getElementById("ModalCostos").value = NewCostoBruto.toFixed(2);
    document.getElementById("ModalCostoNeto").value = NewCostoNeto.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalMargen").value = NewMargen.toFixed(2);
    document.getElementById("ModalPrecioNeto").value =
      NewPrecioBruto.toFixed(2);
    document.getElementById("ModalPrecioVenta").value = NewPrecioNeto.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalMargen2").value = NewMargen2.toFixed(2);
    document.getElementById("ModalPrecioNeto2").value =
      NewPrecioBruto2.toFixed(2);
    document.getElementById("ModalPrecioVenta2").value = NewPrecioNeto2.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalMargen3").value = NewMargen3.toFixed(2);
    document.getElementById("ModalPrecioNeto3").value =
      NewPrecioBruto3.toFixed(2);
    document.getElementById("ModalPrecioVenta3").value = NewPrecioNeto3.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen4").value = NewMargen4.toFixed(2);
    document.getElementById("ModalPrecioNeto4").value =
      NewPrecioBruto4.toFixed(2);
    document.getElementById("ModalPrecioVenta4").value = NewPrecioNeto4.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen5").value = NewMargen5.toFixed(2);
    document.getElementById("ModalPrecioNeto5").value =
      NewPrecioBruto5.toFixed(2);
    document.getElementById("ModalPrecioVenta5").value = NewPrecioNeto5.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen6").value = NewMargen6.toFixed(2);
    document.getElementById("ModalPrecioNeto6").value =
      NewPrecioBruto6.toFixed(2);
    document.getElementById("ModalPrecioVenta6").value = NewPrecioNeto6.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen7").value = NewMargen7.toFixed(2);
    document.getElementById("ModalPrecioNeto7").value =
      NewPrecioBruto7.toFixed(2);
    document.getElementById("ModalPrecioVenta7").value = NewPrecioNeto7.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen8").value = NewMargen8.toFixed(2);
    document.getElementById("ModalPrecioNeto8").value =
      NewPrecioBruto8.toFixed(2);
    document.getElementById("ModalPrecioVenta8").value = NewPrecioNeto8.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen9").value = NewMargen9.toFixed(2);
    document.getElementById("ModalPrecioNeto9").value =
      NewPrecioBruto9.toFixed(2);
    document.getElementById("ModalPrecioVenta9").value = NewPrecioNeto9.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen10").value = NewMargen10.toFixed(2);
    document.getElementById("ModalPrecioNeto10").value =
      NewPrecioBruto10.toFixed(2);
    document.getElementById("ModalPrecioVenta10").value =
      NewPrecioNeto10.toFixed(document.getElementById("CD").innerHTML);

    if (
      document.getElementById("CantP1x" + numero).innerHTML == "" ||
      document.getElementById("CantP1x" + numero).innerHTML == "0"
    ) {
      document.getElementById("ModalCant2").value = "1";
    }
    if (
      document.getElementById("CantP2" + numero).innerHTML == "" ||
      document.getElementById("CantP2" + numero).innerHTML == "0"
    ) {
      document.getElementById("ModalCant3").value = "1";
    }
    if (
      document.getElementById("CantP4x" + numero).innerHTML == "" ||
      document.getElementById("CantP4x" + numero).innerHTML == "0"
    )
      document.getElementById("ModalCant4").value = "1";
    if (
      document.getElementById("CantP5x" + numero).innerHTML == "" ||
      document.getElementById("CantP5x" + numero).innerHTML == "0"
    )
      document.getElementById("ModalCant5").value = "1";

    if (
      document.getElementById("CantP6x" + numero).innerHTML == "" ||
      document.getElementById("CantP6x" + numero).innerHTML == "0"
    )
      document.getElementById("ModalCant6").value = "1";

    if (
      document.getElementById("CantP7x" + numero).innerHTML == "" ||
      document.getElementById("CantP7x" + numero).innerHTML == "0"
    )
      document.getElementById("ModalCant7").value = "1";

    if (
      document.getElementById("CantP8x" + numero).innerHTML == "" ||
      document.getElementById("CantP8x" + numero).innerHTML == "0"
    )
      document.getElementById("ModalCant8").value = "1";

    if (
      document.getElementById("CantP9x" + numero).innerHTML == "" ||
      document.getElementById("CantP9x" + numero).innerHTML == "0"
    )
      document.getElementById("ModalCant9").value = "1";

    if (
      document.getElementById("CantP10x" + numero).innerHTML == "" ||
      document.getElementById("CantP10x" + numero).innerHTML == "0"
    )
      document.getElementById("ModalCant10").value = "1";

    document.getElementById("ModalCant2").value = ModalCant2;
    document.getElementById("ModalCant3").value = ModalCant3;
    document.getElementById("ModalCant4").value = ModalCant4;
    document.getElementById("ModalCant5").value = ModalCant5;
    document.getElementById("ModalCant6").value = ModalCant6;
    document.getElementById("ModalCant7").value = ModalCant7;
    document.getElementById("ModalCant8").value = ModalCant8;
    document.getElementById("ModalCant9").value = ModalCant9;
    document.getElementById("ModalCant10").value = ModalCant10;

    if (
      document.getElementById("ModalCant2").value > 1 &&
      NewPrecioBruto2 > 0
    ) {
      document.getElementById("cantsimp").innerHTML =
        (NewPrecioBruto2.toFixed(2) / ModalCant2).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida2").value;
      document.getElementById("cantcimp").innerHTML =
        (NewPrecioNeto2.toFixed(2) / ModalCant2).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida2").value;
    } else {
      document.getElementById("cantsimp").innerHTML = "";
      document.getElementById("cantcimp").innerHTML = "";
    }
    if (
      document.getElementById("ModalCant3").value > 1 &&
      NewPrecioBruto3 > 0
    ) {
      document.getElementById("cantsimp2").innerHTML =
        (NewPrecioBruto3.toFixed(2) / ModalCant3).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida3").value;
      document.getElementById("cantcimp2").innerHTML =
        (NewPrecioNeto3.toFixed(2) / ModalCant3).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida3").value;
    } else {
      document.getElementById("cantsimp2").innerHTML = "";
      document.getElementById("cantcimp2").innerHTML = "";
    }
    if (
      document.getElementById("ModalCant4").value > 1 &&
      NewPrecioBruto4 > 0
    ) {
      document.getElementById("cantsimp4").innerHTML =
        (NewPrecioBruto4.toFixed(2) / ModalCant4).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida4").value;
      document.getElementById("cantcimp4").innerHTML =
        (NewPrecioNeto4.toFixed(2) / ModalCant4).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida4").value;
    } else {
      document.getElementById("cantsimp4").innerHTML = "";
      document.getElementById("cantcimp4").innerHTML = "";
    }
    if (
      document.getElementById("ModalCant5").value > 1 &&
      NewPrecioBruto5 > 0
    ) {
      document.getElementById("cantsimp5").innerHTML =
        (NewPrecioBruto5.toFixed(2) / ModalCant5).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida5").value;
      document.getElementById("cantcimp5").innerHTML =
        (NewPrecioNeto5.toFixed(2) / ModalCant5).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida5").value;
    } else {
      document.getElementById("cantsimp5").innerHTML = "";
      document.getElementById("cantcimp5").innerHTML = "";
    }

    if (
      document.getElementById("ModalCant6").value > 1 &&
      NewPrecioBruto6 > 0
    ) {
      document.getElementById("cantsimp6").innerHTML =
        (NewPrecioBruto6.toFixed(2) / ModalCant6).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida6").value;
      document.getElementById("cantcimp6").innerHTML =
        (NewPrecioNeto6.toFixed(2) / ModalCant6).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida6").value;
    } else {
      document.getElementById("cantsimp6").innerHTML = "";
      document.getElementById("cantcimp6").innerHTML = "";
    }

    if (
      document.getElementById("ModalCant7").value > 1 &&
      NewPrecioBruto7 > 0
    ) {
      document.getElementById("cantsimp7").innerHTML =
        (NewPrecioBruto7.toFixed(2) / ModalCant7).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida7").value;
      document.getElementById("cantcimp7").innerHTML =
        (NewPrecioNeto7.toFixed(2) / ModalCant7).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida7").value;
    } else {
      document.getElementById("cantsimp7").innerHTML = "";
      document.getElementById("cantcimp7").innerHTML = "";
    }

    if (
      document.getElementById("ModalCant8").value > 1 &&
      NewPrecioBruto8 > 0
    ) {
      document.getElementById("cantsimp8").innerHTML =
        (NewPrecioBruto8.toFixed(2) / ModalCant8).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida8").value;
      document.getElementById("cantcimp8").innerHTML =
        (NewPrecioNeto8.toFixed(2) / ModalCant8).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida8").value;
    } else {
      document.getElementById("cantsimp8").innerHTML = "";
      document.getElementById("cantcimp8").innerHTML = "";
    }

    if (
      document.getElementById("ModalCant9").value > 1 &&
      NewPrecioBruto9 > 0
    ) {
      document.getElementById("cantsimp9").innerHTML =
        (NewPrecioBruto9.toFixed(2) / ModalCant9).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida9").value;
      document.getElementById("cantcimp9").innerHTML =
        (NewPrecioNeto9.toFixed(2) / ModalCant9).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida9").value;
    } else {
      document.getElementById("cantsimp9").innerHTML = "";
      document.getElementById("cantcimp9").innerHTML = "";
    }

    if (
      document.getElementById("ModalCant10").value > 1 &&
      NewPrecioBruto10 > 0
    ) {
      document.getElementById("cantsimp10").innerHTML =
        (NewPrecioBruto10.toFixed(2) / ModalCant10).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida10").value;
      document.getElementById("cantcimp10").innerHTML =
        (NewPrecioNeto10.toFixed(2) / ModalCant10).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida10").value;
    } else {
      document.getElementById("cantsimp10").innerHTML = "";
      document.getElementById("cantcimp10").innerHTML = "";
    }

    DeshabilitarButtond(1);
  } else {
    $("#suggesstion-box").hide();
    document.getElementById("cantsimp").innerHTML = "";
    document.getElementById("cantcimp").innerHTML = "";
    document.getElementById("cantsimp2").innerHTML = "";
    document.getElementById("cantcimp2").innerHTML = "";
    document.getElementById("cantsimp4").innerHTML = "";
    document.getElementById("cantcimp4").innerHTML = "";
    document.getElementById("cantsimp5").innerHTML = "";
    document.getElementById("cantcimp5").innerHTML = "";
    document.getElementById("cantsimp6").innerHTML = "";
    document.getElementById("cantcimp6").innerHTML = "";
    document.getElementById("cantsimp7").innerHTML = "";
    document.getElementById("cantcimp7").innerHTML = "";
    document.getElementById("cantsimp8").innerHTML = "";
    document.getElementById("cantcimp8").innerHTML = "";
    document.getElementById("cantsimp9").innerHTML = "";
    document.getElementById("cantcimp9").innerHTML = "";
    document.getElementById("cantsimp10").innerHTML = "";
    document.getElementById("cantcimp10").innerHTML = "";

    document.getElementById("Comision").value = "0";
    document.getElementById("Comision2").value = "0";
    document.getElementById("Comision3").value = "0";
    document.getElementById("Comision4").value = "0";
    document.getElementById("Comision5").value = "0";
    document.getElementById("Comision6").value = "0";
    document.getElementById("Comision7").value = "0";
    document.getElementById("Comision8").value = "0";
    document.getElementById("Comision9").value = "0";
    document.getElementById("Comision10").value = "0";

    var a = new Number(0);
    document.getElementById("ModalIdfamilia").value =
      document.getElementById("RegUnoFamilia").innerHTML;
    document.getElementById("ModalImpuestos").value =
      document.getElementById("RegUnoImpuesto").innerHTML;
    document.getElementById("ModalCodIdBasico3").readOnly = true;
    document.getElementById("ModalCodIdAmpliado").readOnly = false;
    document.getElementById("ModalCodIdBasico").readOnly = true;
    document.getElementById("ModalDescripcion3").readOnly = true;
    document.getElementById("Resultado").innerHTML = "";
    document.getElementById("abcdfghjqwet").innerHTML = "";
    document.getElementById("ModalCodIdBasico").value = "";
    document.getElementById("ModalCodIdAmpliado").value = "";
    document.getElementById("ModalMedida").value = "";
    document.getElementById("ModalMarca").value =
      document.getElementById("RegUnoMarca").innerHTML;
    document.getElementById("ModalCodBarra").value = "";
    document.getElementById("ModalDescripcion").value = "";
    document.getElementById("ModalFactorAltValue").value = 1;
    document.getElementById("ModalFactorAltName").value = "";

    document.getElementById("ModalMargen2").value = a.toFixed(2);
    document.getElementById("ModalPrecioVenta2").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalPrecioNeto2").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalMargen3").value = a.toFixed(2);
    document.getElementById("ModalPrecioVenta3").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalPrecioNeto3").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalMargen4").value = a.toFixed(2);
    document.getElementById("ModalPrecioVenta4").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalPrecioNeto4").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen5").value = a.toFixed(2);
    document.getElementById("ModalPrecioVenta5").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalPrecioNeto5").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen6").value = a.toFixed(2);
    document.getElementById("ModalPrecioVenta6").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalPrecioNeto6").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen7").value = a.toFixed(2);
    document.getElementById("ModalPrecioVenta7").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalPrecioNeto7").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen8").value = a.toFixed(2);
    document.getElementById("ModalPrecioVenta8").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalPrecioNeto8").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen9").value = a.toFixed(2);
    document.getElementById("ModalPrecioVenta9").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalPrecioNeto9").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen10").value = a.toFixed(2);
    document.getElementById("ModalPrecioVenta10").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalPrecioNeto10").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalCodIdBasico02").value = "";
    document.getElementById("ModalCostos").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalMargen").value = a.toFixed(2);
    document.getElementById("ModalDescripcion2").value = "";
    document.getElementById("ModalCostoNeto").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalPrecioNeto").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalPrecioVenta").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalCodIdBasico3").value = "";
    document.getElementById("ModalEnvase").value = "";
    document.getElementById("ModalDescripcion3").value = "";
    document.getElementById("ModalMin").value = 0;
    document.getElementById("ModalMax").value = 0;
    document.getElementById("ModalMedidas").value = "";
    document.getElementById("ModalMedida2").value = "";
    document.getElementById("ModalCant2").value = "1";
    document.getElementById("ModalMedida3").value = "";
    document.getElementById("ModalCant3").value = "1";
    document.getElementById("ModalMedida4").value = "";
    document.getElementById("ModalCant4").value = "1";
    document.getElementById("ModalMedida5").value = "";
    document.getElementById("ModalCant5").value = "1";
    document.getElementById("ModalMedida6").value = "";
    document.getElementById("ModalCant6").value = "1";
    document.getElementById("ModalMedida7").value = "";
    document.getElementById("ModalCant7").value = "1";
    document.getElementById("ModalMedida8").value = "";
    document.getElementById("ModalCant8").value = "1";
    document.getElementById("ModalMedida9").value = "";
    document.getElementById("ModalCant9").value = "1";
    document.getElementById("ModalMedida10").value = "";
    document.getElementById("ModalCant10").value = "1";
    document.getElementById("barrascod").innerHTML =
      "<input id='jcod' name='jcod' style='display:none'></input>";
    $("#ModalPorKilo").prop("checked", false);
    $("#ModalEstado").prop("checked", true);
    ChangeEstado();
    DeshabilitarButtond(1);
  }
}

function mostrarExistencias(n) {
  $("#MostrarExistenciasButtonxa" + n).prop("disabled", true);
  const CodIdBasico = document.getElementById("codidbasico1" + n).innerHTML;
  $.ajax({
    type: "POST",
    url: "productoseek.php",
    data: {
      Accion: "mostrarExistencias",
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      CodIdBasico: CodIdBasico,
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      userlogin: document.getElementById("userlogin").innerHTML,
      userperfil: document.getElementById("userperfil").innerHTML,
      EnvioFamilia: $("#EnvioFamilia").val(),
      EnvioMarca: $("#EnvioMarca").val(),
      EnvioAlmacen: $("#EnvioAlmacen").val(),
      EnvioUbicacion: $("#EnvioUbicacion").val(),
      EnvioZonaAtencion: $("#EnvioZonaAtencion").val(),
      FechaActual: GenerarFecha(),
      OrderBy: document.getElementById("OrderBy").value,
      SortBy: document.getElementById("SortBy").value,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      IdAlmGroup: document.getElementById("IdAlmGroup").innerHTML,
      EsonoES: document.getElementById("EleccionEc").innerHTML,
      AlmacenesAtt: document.getElementById("AlmacenesAtt").innerHTML,
      IdAlmVtaSeleccionada: document.getElementById("IdAlmVtaSeleccionada")
        .innerHTML,
      IdAlmVta: document.getElementById("IdAlmVta").innerHTML,
      VerStock: document.getElementById("VerStock").innerHTML,
      jsonpedido: document.getElementById("jsonpedido").innerHTML,
      VisualExist: document.getElementById("VisualExist").value,
      PerfilVentas: document.getElementById("PerfilVentas").innerHTML,
      sucursal: document.getElementById("sucursal").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      NotIncludeFamilia: document.getElementById("NotIncludeFamilia").checked,
      NotIncludeMarcas: document.getElementById("NotIncludeMarcas").checked,
      NotIncludeAlmacen: document.getElementById("NotIncludeAlmacen").checked,
      NotIncludeUbicacion: document.getElementById("NotIncludeUbicacion")
        .checked,
      NotIncludeZonaAtencion: document.getElementById("NotIncludeZonaAtencion")
        .checked,
      n: n,
    },
  }).done(function (msg) {
    $("#MostrarExistenciasButton" + n).html(msg);
  });
}

function desglosarA(CodIdBasico, IdCompany) {
  $.ajax({
    type: "POST",
    url: "productoseek.php",
    data: {
      Accion: "5",
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      CodIdBasico: CodIdBasico,
      IdCompany: IdCompany,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    $("#Explosion" + CodIdBasico).html(msg);
  });
}

function desglosarC(CodIdBasico, IdCompany) {
  document.getElementById(
    "Explosion" + CodIdBasico,
  ).innerHTML = `<button onclick="desglosarA('${CodIdBasico}','${IdCompany}')" type='button' class='btn btn-outline-dark px-1 m-1'><i class='fa fa-bomb'></i> ${Utils2a.Desglosar_Stock}</button>`;
}

function desglosarPA(CodIdBasico, IdCompany) {
  $.ajax({
    type: "POST",
    url: "productoseek.php",
    data: {
      Accion: "SeeProductionAlm",
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      CodIdBasico: CodIdBasico,
      CompanyActual: IdCompany,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    $("#MostrarDProd" + CodIdBasico).html(msg);
  });
}

function desglosarPC(CodIdBasico, IdCompany) {
  document.getElementById(
    "MostrarDProd" + CodIdBasico,
  ).innerHTML = `<button onclick="desglosarPA('${CodIdBasico}','${IdCompany}')" type='button' class='btn btn-outline-dark px-1 m-1'><i class='fa fa-bomb'></i> ${Utils2a.Desc36}</button>`;
}

function guardar(go = "", reload = "1") {
  if (validaForm(go)) {
    if (document.getElementById("Estees").innerHTML == "9") {
      var valor2 = "";
    } else {
      if ($("#ModalPorKilo" + go).prop("checked")) {
        var valor2 = "on";
      } else {
        var valor2 = "";
      }
    }

    if ($("#ModalEstado" + go).prop("checked")) {
      var valor1 = "on";
    } else {
      var valor1 = "";
    }
    var Comision = document.getElementById("Comision" + go).value;
    var Comision2 = document.getElementById("Comision2" + go).value;
    var Comision3 = document.getElementById("Comision3" + go).value;
    var Comision4 = document.getElementById("Comision4" + go).value;
    var Comision5 = document.getElementById("Comision5" + go).value;
    var Comision6 = document.getElementById("Comision6" + go).value;
    var Comision7 = document.getElementById("Comision7" + go).value;
    var Comision8 = document.getElementById("Comision8" + go).value;
    var Comision9 = document.getElementById("Comision9" + go).value;
    var Comision10 = document.getElementById("Comision10" + go).value;

    var ModalCodIdBasicoPadre = document.getElementById(
      "ModalCodIdBasicoPadre" + go,
    ).value;

    if (go != "") {
      updatevarpadre(ModalCodIdBasicoPadre);
    }
    // fijarpos
    var ModalMedida = document.getElementById("ModalMedidas" + go).value;
    // var ModalMedidas=document.getElementById("ModalMedida").value;
    if (go == "S") {
      var goguion = "S-";
    } else {
      var goguion = "";
    }
    var n = document.getElementById("cont" + go).value;
    var datainputs = "";
    let x = 0;
    while (n > x) {
      x++;
      if (x > 1) {
        var pp = "|";
      } else {
        var pp = "";
      }
      datainputs = datainputs + pp + document.getElementById(goguion + x).value;
    }
    var VariationsTypes = document.getElementById("tagsinput" + go).value;
    var TextVar = datainputs;

    var json = document.getElementById("jcod" + go).value;
    var login = document.getElementById("userlogin").innerHTML;
    var userCompany = document.getElementById("userCompany").innerHTML;

    $.ajax({
      type: "POST",
      url: "DataHandler1.php",
      data: {
        tabla: "ProductosyServicios",
        VariationsTypes: VariationsTypes,
        ModalCodIdBasicoPadre: ModalCodIdBasicoPadre,
        TextVar: TextVar,
        ModalMedida: ModalMedida,
        Comision: Comision,
        Comision2: Comision2,
        Comision3: Comision3,
        Comision4: Comision4,
        Comision5: Comision5,
        Comision6: Comision6,
        Comision7: Comision7,
        Comision8: Comision8,
        Comision9: Comision9,
        Comision10: Comision10,
        userCompany: userCompany,
        login: login,
        json: json,
        ModalCant10: document.getElementById("ModalCant10" + go).value,
        ModalCant9: document.getElementById("ModalCant9" + go).value,
        ModalCant8: document.getElementById("ModalCant8" + go).value,
        ModalCant7: document.getElementById("ModalCant7" + go).value,
        ModalCant6: document.getElementById("ModalCant6" + go).value,
        ModalCant5: document.getElementById("ModalCant5" + go).value,
        ModalCant4: document.getElementById("ModalCant4" + go).value,
        ModalCant3: document.getElementById("ModalCant3" + go).value,
        ModalCant2: document.getElementById("ModalCant2" + go).value,
        ModalMedida10: document.getElementById("ModalMedida10" + go).value,
        ModalMedida9: document.getElementById("ModalMedida9" + go).value,
        ModalMedida8: document.getElementById("ModalMedida8" + go).value,
        ModalMedida7: document.getElementById("ModalMedida7" + go).value,
        ModalMedida6: document.getElementById("ModalMedida6" + go).value,
        ModalMedida5: document.getElementById("ModalMedida5" + go).value,
        ModalMedida4: document.getElementById("ModalMedida4" + go).value,
        ModalMedida3: document.getElementById("ModalMedida3" + go).value,
        ModalMedida2: document.getElementById("ModalMedida2" + go).value,
        ModalPorKilo: valor2,
        ModalPrecioVenta10: document.getElementById("ModalPrecioVenta10" + go)
          .value,
        ModalPrecioVenta9: document.getElementById("ModalPrecioVenta9" + go)
          .value,
        ModalPrecioVenta8: document.getElementById("ModalPrecioVenta8" + go)
          .value,
        ModalPrecioVenta7: document.getElementById("ModalPrecioVenta7" + go)
          .value,
        ModalPrecioVenta6: document.getElementById("ModalPrecioVenta6" + go)
          .value,
        ModalPrecioVenta5: document.getElementById("ModalPrecioVenta5" + go)
          .value,
        ModalPrecioVenta4: document.getElementById("ModalPrecioVenta4" + go)
          .value,
        ModalPrecioVenta3: document.getElementById("ModalPrecioVenta3" + go)
          .value,
        ModalPrecioVenta2: document.getElementById("ModalPrecioVenta2" + go)
          .value,
        ModalPrecioNeto10: document.getElementById("ModalPrecioNeto10" + go)
          .value,
        ModalPrecioNeto9: document.getElementById("ModalPrecioNeto9" + go)
          .value,
        ModalPrecioNeto8: document.getElementById("ModalPrecioNeto8" + go)
          .value,
        ModalPrecioNeto7: document.getElementById("ModalPrecioNeto7" + go)
          .value,
        ModalPrecioNeto6: document.getElementById("ModalPrecioNeto6" + go)
          .value,
        ModalPrecioNeto5: document.getElementById("ModalPrecioNeto5" + go)
          .value,
        ModalPrecioNeto4: document.getElementById("ModalPrecioNeto4" + go)
          .value,
        ModalPrecioNeto3: document.getElementById("ModalPrecioNeto3" + go)
          .value,
        ModalPrecioNeto2: document.getElementById("ModalPrecioNeto2" + go)
          .value,
        ModalMargen10: document.getElementById("ModalMargen10" + go).value,
        ModalMargen9: document.getElementById("ModalMargen9" + go).value,
        ModalMargen8: document.getElementById("ModalMargen8" + go).value,
        ModalMargen7: document.getElementById("ModalMargen7" + go).value,
        ModalMargen6: document.getElementById("ModalMargen6" + go).value,
        ModalMargen5: document.getElementById("ModalMargen5" + go).value,
        ModalMargen4: document.getElementById("ModalMargen4" + go).value,
        ModalMargen3: document.getElementById("ModalMargen3" + go).value,
        ModalMargen2: document.getElementById("ModalMargen2" + go).value,
        ModalMax: document.getElementById("ModalMax" + go).value,
        ModalMin: document.getElementById("ModalMin" + go).value,
        ModalMarca: document.getElementById("ModalMarca" + go).value,
        ModalIdfamilia: document.getElementById("ModalIdfamilia" + go).value,
        mIdfamilia: document.getElementById("mRegUnoFamilia").innerHTML,
        ModalEnvase: document.getElementById("jsonEtiquetas" + go).innerHTML,
        ModalUbicacion: document.getElementById("jsonUbicacion" + go).innerHTML,
        ModalEstado: valor1,
        ModalPrecioNeto: document.getElementById("ModalPrecioNeto" + go).value,
        ModalCostos: document.getElementById("ModalCostos" + go).value,
        ModalPrecioVenta: document.getElementById("ModalPrecioVenta" + go)
          .value,
        ModalMargen: document.getElementById("ModalMargen" + go).value,
        ModalCostoNeto: document.getElementById("ModalCostoNeto" + go).value,
        jsonfactor: document.getElementById("jsonfactor").innerHTML,
        ModalImpuestos: document.getElementById("ModalImpuestos" + go).value,
        ModalMedida: document.getElementById("ModalMedida" + go).value,
        ModalDescripcion: document.getElementById("ModalDescripcion" + go)
          .value,
        ModalFactorAltValue: document.getElementById("ModalFactorAltValue" + go)
          .value,
        ModalFactorAltName: document.getElementById("ModalFactorAltName" + go)
          .value,
        ModalCodIdAmpliado: document.getElementById("ModalCodIdAmpliado" + go)
          .value,
        ModalCodIdBasico: document.getElementById("ModalCodIdBasico" + go)
          .value,
        ModalCodBarra: document.getElementById("ModalCodBarra" + go).value,
        ModalHeight: document.getElementById("ModalHeight" + go).value,
        ModalWeight: document.getElementById("ModalWeight" + go).value,
        ModalArea: document.getElementById("ModalArea" + go).value,
        ModalCostoPercent: document.getElementById("ModalCostoPercent").value,
        ModalTipOCosto: document.getElementById("ModalTipOCosto").value,
        companyUser: document.getElementById("CompanyActual").innerHTML,
        EsCompuesto: document.getElementById("EleccionEc").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        MonedaS: document.getElementById("MonedaS").innerHTML,
      },
    }).done(function (msg) {
      $("button").prop("disabled", false);
      //alert(msg);
      if (msg == 1) {
        if (go == "") {
          //
          $("#apps-modal").modal("hide");
          $("#ServerSideTable").DataTable().ajax.reload(null, false);

          //   var table = $('#data-table-product2').DataTable();
          //   table.ajax.reload();
        } else {
          $("#apps-modal" + go).modal("toggle");
          $("#ServerSideTable").DataTable().ajax.reload(null, false);

          // loadtable2(ModalCodIdBasicoPadre)
          var tablex = $("#data-table-product2").DataTable();
          tablex.ajax.reload(null, false);
          $("#visibleVar").addClass("d-none");
          $("#visibleVar2").removeClass("d-none");
          $("#datatableproduct2").removeClass("d-none");
          document.getElementById("not").value = "0";
          document.getElementById("contentsetvar").innerHTML = Utils2a.Desc10;
        }
        $("#alertaerrorenproducto2").delay(500).fadeIn("slow");
        setTimeout(() => OcultarNotificacion2(), 4000);
      } else {
        $("#alertaerrorenproducto3").delay(500).fadeIn("slow");
        setTimeout(() => OcultarNotificacion2(), 4000);
      }
    });
  } else {
    $("button").prop("disabled", false);
  }
}

function updatevarpadre(CodIdBasicoPadre) {
  var n = document.getElementById("cont").value;
  var datainputs = "";
  let x = 0;
  while (n > x) {
    x++;
    if (x > 1) {
      var pp = "|";
    } else {
      var pp = "";
    }
    datainputs = datainputs + pp + document.getElementById(x).value;
  }
  var VariationsTypes = document.getElementById("tagsinput").value;
  var TextVar = datainputs;
  $.ajax({
    type: "POST",
    url: "productoseek.php",
    data: {
      Accion: "updatevar-product",
      TextVar: TextVar,
      VariationsTypes: VariationsTypes,
      Id: CodIdBasicoPadre,
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    viewtags(CodIdBasicoPadre, "", "2");
  });
}

function checkedvaria() {
  document.getElementById("checkvar").innerHTML;
  if ($("#OnVariacion").prop("checked") == true) {
    $("#variac").removeClass("d-none");
    $("#variac2").removeClass("d-none");
  } else {
    $("#variac").addClass("d-none");
    $("#variac2").addClass("d-none");
  }
}

function xd(numero, onvar = 1) {
  IdAct = numero;

  if (numero > 0) {
    $("#checkvar").removeClass("d-none");
    $("#ModalCodIdBasicoPadre").val($("#codpad" + numero).html());
    if (onvar == "1") {
      go = "S";
    } else {
      go = "";
    }
    $("#Variaciones2" + go).removeClass("active");
    $("#Variaciones" + go).removeClass("active");
    $("#Information").addClass("active");
    $("#Information2").addClass("active");
    if (onvar == "2") {
      loadtable2(document.getElementById("codidbasico1" + numero).innerHTML);
      $("#visibleVar").addClass("d-none");
      $("#visibleVar2").removeClass("d-none");
      $("#datatableproduct2").addClass("d-none");
      document.getElementById("not").value = "2";
      document.getElementById("contentsetvar").innerHTML =
        `${Utils2a.Desc11}: <span class="badge bg-success text-light" >` +
        $("#SkuFa" + numero).val() +
        `</span>  <span class="badge bg-light text-dark" >` +
        $("#TitFa" + numero).val() +
        `</span>`;
    }
    if (onvar == 0 || onvar == "") {
      loadtable2(document.getElementById("codidbasico1" + numero).innerHTML);
      $("#visibleVar").addClass("d-none");
      $("#visibleVar2").removeClass("d-none");
      $("#datatableproduct2").removeClass("d-none");
      document.getElementById("not").value = "0";
      document.getElementById("contentsetvar").innerHTML = Utils2a.Desc12;
    }
    if (onvar == 1) {
      loadtable2(document.getElementById("codidbasico1" + numero).innerHTML);
      $("#visibleVar").removeClass("d-none");
      $("#visibleVar2").addClass("d-none");
      $("#datatableproduct2").addClass("d-none");
      document.getElementById("not").value = "1";
      document.getElementById("contentsetvar").innerHTML = Utils2a.Desc12;
    }
    $("#labvaria").addClass("d-none");
    document.getElementById("titlemodal").innerHTML =
      document.getElementById("EleccionEc").innerHTML === "0"
        ? Utils2a.Editar_Producto
        : Utils2a.Editar_Servicio;

    valor = document.getElementById("porkilo" + numero).innerHTML;
    if (document.getElementById("Estees").innerHTML == "0") {
      if (valor === "1") {
        $("#ModalPorKilo").prop("checked", true);
      } else {
        $("#ModalPorKilo").prop("checked", false);
      }
    }
    valor = document.getElementById("estado" + numero).innerHTML;
    if (valor === "1") {
      $("#ModalEstado").prop("checked", true);
    } else {
      $("#ModalEstado").prop("checked", false);
    }
    ChangeEstado();
    viewtags(document.getElementById("codidbasico1" + numero).innerHTML);
    CodIdBasicoAct = document.getElementById("codidbasico1" + numero).innerHTML;
    document.getElementById("Comision").value = document.getElementById(
      "com" + numero,
    ).innerHTML;
    document.getElementById("Comision2").value = document.getElementById(
      "comd" + numero,
    ).innerHTML;
    document.getElementById("Comision3").value = document.getElementById(
      "comt" + numero,
    ).innerHTML;
    document.getElementById("Comision4").value = document.getElementById(
      "comcua" + numero,
    ).innerHTML;
    document.getElementById("Comision5").value = document.getElementById(
      "com5" + numero,
    ).innerHTML;
    document.getElementById("Comision6").value = document.getElementById(
      "com6" + numero,
    ).innerHTML;
    document.getElementById("Comision7").value = document.getElementById(
      "com7" + numero,
    ).innerHTML;
    document.getElementById("Comision8").value = document.getElementById(
      "com8" + numero,
    ).innerHTML;
    document.getElementById("Comision9").value = document.getElementById(
      "com9" + numero,
    ).innerHTML;
    document.getElementById("Comision10").value = document.getElementById(
      "com10" + numero,
    ).innerHTML;
    document.getElementById("ModalCodIdAmpliado").value =
      document.getElementById("codidampliado" + numero).innerHTML;
    document.getElementById("ModalDescripcion").value = document.getElementById(
      "descripcion" + numero,
    ).innerHTML;
    document.getElementById("ModalFactorAltValue").value =
      document.getElementById("FactorAlter" + numero).innerHTML;
    document.getElementById("ModalFactorAltName").value =
      document.getElementById("UnidadAlter" + numero).innerHTML;
    document.getElementById("ModalMedida").value = document.getElementById(
      "medida" + numero,
    ).innerHTML;
    document.getElementById("ModalMedidas").value = document.getElementById(
      "medida" + numero,
    ).innerHTML;
    document.getElementById("ModalMargen2").value = document.getElementById(
      "Margen200" + numero,
    ).innerHTML;
    document.getElementById("ModalPrecioVenta2").value =
      document.getElementById("PrecioVenta2" + numero).innerHTML;
    document.getElementById("ModalPrecioNeto2").value = document.getElementById(
      "PrecioNeto2" + numero,
    ).innerHTML;
    document.getElementById("ModalMargen3").value = document.getElementById(
      "Margen3" + numero,
    ).innerHTML;
    document.getElementById("ModalPrecioVenta3").value =
      document.getElementById("PrecioVenta3" + numero).innerHTML;

    document.getElementById("ModalTipOCosto").value = document.getElementById(
      "porcentual" + numero,
    ).innerHTML;
    document.getElementById("ModalCostoPercent").value =
      document.getElementById("CostoPorcentaje" + numero).innerHTML;
    TipoCostoChange();

    if (Number(document.getElementById("CantotalA" + numero).innerHTML) > 0) {
      $("#ModalNoEstado").show();
      $("#ModalEstadoact").hide();
    } else {
      $("#ModalNoEstado").hide();
      $("#ModalEstadoact").show();
    }
    document.getElementById("ModalPrecioNeto3").value = document.getElementById(
      "PrecioNeto3" + numero,
    ).innerHTML;
    document.getElementById("ModalMargen4").value = document.getElementById(
      "Margen4" + numero,
    ).innerHTML;
    document.getElementById("ModalPrecioVenta4").value =
      document.getElementById("PrecioVenta4" + numero).innerHTML;
    document.getElementById("ModalPrecioNeto4").value = document.getElementById(
      "PrecioNeto4" + numero,
    ).innerHTML;

    document.getElementById("ModalMargen5").value = document.getElementById(
      "Margen5" + numero,
    ).innerHTML;
    document.getElementById("ModalPrecioVenta5").value =
      document.getElementById("PrecioVenta5" + numero).innerHTML;
    document.getElementById("ModalPrecioNeto5").value = document.getElementById(
      "PrecioNeto5" + numero,
    ).innerHTML;

    document.getElementById("ModalMargen6").value = document.getElementById(
      "Margen6" + numero,
    ).innerHTML;
    document.getElementById("ModalPrecioVenta6").value =
      document.getElementById("PrecioVenta6" + numero).innerHTML;
    document.getElementById("ModalPrecioNeto6").value = document.getElementById(
      "PrecioNeto6" + numero,
    ).innerHTML;

    document.getElementById("ModalMargen7").value = document.getElementById(
      "Margen7" + numero,
    ).innerHTML;
    document.getElementById("ModalPrecioVenta7").value =
      document.getElementById("PrecioVenta7" + numero).innerHTML;
    document.getElementById("ModalPrecioNeto7").value = document.getElementById(
      "PrecioNeto7" + numero,
    ).innerHTML;

    document.getElementById("ModalMargen8").value = document.getElementById(
      "Margen8" + numero,
    ).innerHTML;
    document.getElementById("ModalPrecioVenta8").value =
      document.getElementById("PrecioVenta8" + numero).innerHTML;
    document.getElementById("ModalPrecioNeto8").value = document.getElementById(
      "PrecioNeto8" + numero,
    ).innerHTML;

    document.getElementById("ModalMargen9").value = document.getElementById(
      "Margen9" + numero,
    ).innerHTML;
    document.getElementById("ModalPrecioVenta9").value =
      document.getElementById("PrecioVenta9" + numero).innerHTML;
    document.getElementById("ModalPrecioNeto9").value = document.getElementById(
      "PrecioNeto9" + numero,
    ).innerHTML;

    document.getElementById("ModalMargen10").value = document.getElementById(
      "Margen10" + numero,
    ).innerHTML;
    document.getElementById("ModalPrecioVenta10").value =
      document.getElementById("PrecioVenta10" + numero).innerHTML;
    document.getElementById("ModalPrecioNeto10").value =
      document.getElementById("PrecioNeto10" + numero).innerHTML;

    document.getElementById("ModalCodIdBasico02").value =
      document.getElementById("codidbasico1" + numero).innerHTML;
    document.getElementById("ModalCostos").value = document.getElementById(
      "costoneto" + numero,
    ).innerHTML;
    document.getElementById("ModalMargen").value = document.getElementById(
      "margen1" + numero,
    ).innerHTML;
    document.getElementById("ModalDescripcion2").value =
      document.getElementById("descripcion" + numero).innerHTML;
    document.getElementById("ModalCostoNeto").value = document.getElementById(
      "costo" + numero,
    ).innerHTML;
    document.getElementById("ModalPrecioNeto").value = document.getElementById(
      "precioneto1" + numero,
    ).innerHTML;
    document.getElementById("ModalPrecioVenta").value = document.getElementById(
      "preciodeventa2" + numero,
    ).innerHTML;
    document.getElementById("ModalCodIdBasico3").value =
      document.getElementById("codidbasico1" + numero).innerHTML;
    document.getElementById("serialesspan").innerHTML =
      document.getElementById("ModalCodIdBasico3").value;
    document.getElementById("jsonEtiquetas").innerHTML =
      document.getElementById("envase" + numero).innerHTML;
    document.getElementById("ModalEnvase").value = "";
    Actualizar();
    document.getElementById("jsonUbicacion").innerHTML =
      document.getElementById("ubicacionesper" + numero).innerHTML;
    document.getElementById("ModalUbiProdX").value = "";
    Actualizar2();
    document.getElementById("ModalDescripcion3").value =
      document.getElementById("descripcion" + numero).innerHTML;
    document.getElementById("ModalMin").value = document.getElementById(
      "min" + numero,
    ).innerHTML;
    document.getElementById("ModalMax").value = document.getElementById(
      "max" + numero,
    ).innerHTML;
    document.getElementById("ModalCodIdBasico3").value =
      document.getElementById("codidbasico1" + numero).innerHTML;
    document.getElementById("ModalCodIdBasico").value = document.getElementById(
      "codidbasico1" + numero,
    ).innerHTML;
    document.getElementById("ModalDescripcion3").readOnly = true;
    document.getElementById("ModalCodIdBasico3").readOnly = true;
    document.getElementById("ModalCodIdBasico").readOnly = true;
    document.getElementById("ModalCodIdAmpliado").readOnly = false;
    document.getElementById("ModalMarca").value = document.getElementById(
      "marca" + numero,
    ).innerHTML;
    document.getElementById("ModalIdfamilia").value = document.getElementById(
      "idfamilia" + numero,
    ).innerHTML;
    ChangeWidthHeight();
    document.getElementById("ModalArea").value = document.getElementById(
      "factorunit" + numero,
    ).innerHTML;
    document.getElementById("ModalWeight").value = document.getElementById(
      "ancho" + numero,
    ).innerHTML;
    document.getElementById("ModalHeight").value = document.getElementById(
      "alto" + numero,
    ).innerHTML;
    //alert(document.getElementById("IdFamiliaAdds"+numero).innerHTML);
    document.getElementById("mRegUnoFamilia").innerHTML =
      document.getElementById("IdFamiliaAdds" + numero).innerHTML;
    var data = document.getElementById("IdFamiliaAdds" + numero).innerHTML;
    var arr = JSON.parse("[" + data + "]");
    //$('#mIdfamilia').val()=arr;
    $("#mIdfamilia").val(arr);
    $("#mIdfamilia").trigger("change");
    //$('#mRegUnoFamilia').html(values.toString());

    document.getElementById("ModalImpuestos").value = document.getElementById(
      "impuesto" + numero,
    ).innerHTML;
    document.getElementById("jsonfactor").innerHTML = document.getElementById(
      "jsonfactor" + numero,
    ).innerHTML;
    verfactores();
    document.getElementById("ModalCant2").value = document.getElementById(
      "CantP1x" + numero,
    ).innerHTML;
    document.getElementById("ModalCant3").value = document.getElementById(
      "CantP2" + numero,
    ).innerHTML;
    document.getElementById("ModalCant4").value = document.getElementById(
      "CantP4x" + numero,
    ).innerHTML;
    document.getElementById("ModalCant5").value = document.getElementById(
      "CantP5x" + numero,
    ).innerHTML;
    document.getElementById("ModalCant6").value = document.getElementById(
      "CantP6x" + numero,
    ).innerHTML;
    document.getElementById("ModalCant7").value = document.getElementById(
      "CantP7x" + numero,
    ).innerHTML;
    document.getElementById("ModalCant8").value = document.getElementById(
      "CantP8x" + numero,
    ).innerHTML;
    document.getElementById("ModalCant9").value = document.getElementById(
      "CantP9x" + numero,
    ).innerHTML;
    document.getElementById("ModalCant10").value = document.getElementById(
      "CantP10x" + numero,
    ).innerHTML;

    document.getElementById("ModalMedida2").value = document.getElementById(
      "UnidadP1x" + numero,
    ).innerHTML;
    document.getElementById("ModalMedida3").value = document.getElementById(
      "UnidadP2x" + numero,
    ).innerHTML;
    document.getElementById("ModalMedida4").value = document.getElementById(
      "UnidadP4x" + numero,
    ).innerHTML;
    document.getElementById("ModalMedida5").value = document.getElementById(
      "UnidadP5x" + numero,
    ).innerHTML;
    document.getElementById("ModalMedida6").value = document.getElementById(
      "UnidadP6x" + numero,
    ).innerHTML;
    document.getElementById("ModalMedida7").value = document.getElementById(
      "UnidadP7x" + numero,
    ).innerHTML;
    document.getElementById("ModalMedida8").value = document.getElementById(
      "UnidadP8x" + numero,
    ).innerHTML;
    document.getElementById("ModalMedida9").value = document.getElementById(
      "UnidadP9x" + numero,
    ).innerHTML;
    document.getElementById("ModalMedida10").value = document.getElementById(
      "UnidadP10x" + numero,
    ).innerHTML;

    if (
      document.getElementById("CantP1x" + numero).innerHTML == "" ||
      document.getElementById("CantP1x" + numero).innerHTML == "0"
    ) {
      document.getElementById("ModalCant2").value = "1";
    }
    if (
      document.getElementById("CantP2" + numero).innerHTML == "" ||
      document.getElementById("CantP2" + numero).innerHTML == "0"
    ) {
      document.getElementById("ModalCant3").value = "1";
    }
    if (
      document.getElementById("CantP4x" + numero).innerHTML == "" ||
      document.getElementById("CantP4x" + numero).innerHTML == "0"
    ) {
      document.getElementById("ModalCant4").value = "1";
    }
    if (
      document.getElementById("CantP5x" + numero).innerHTML == "" ||
      document.getElementById("CantP5x" + numero).innerHTML == "0"
    )
      document.getElementById("ModalCant5").value = "1";

    if (
      document.getElementById("CantP6x" + numero).innerHTML == "" ||
      document.getElementById("CantP6x" + numero).innerHTML == "0"
    )
      document.getElementById("ModalCant6").value = "1";

    if (
      document.getElementById("CantP7x" + numero).innerHTML == "" ||
      document.getElementById("CantP7x" + numero).innerHTML == "0"
    )
      document.getElementById("ModalCant7").value = "1";

    if (
      document.getElementById("CantP8x" + numero).innerHTML == "" ||
      document.getElementById("CantP8x" + numero).innerHTML == "0"
    )
      document.getElementById("ModalCant8").value = "1";

    if (
      document.getElementById("CantP9x" + numero).innerHTML == "" ||
      document.getElementById("CantP9x" + numero).innerHTML == "0"
    )
      document.getElementById("ModalCant9").value = "1";

    if (
      document.getElementById("CantP10x" + numero).innerHTML == "" ||
      document.getElementById("CantP10x" + numero).innerHTML == "0"
    )
      document.getElementById("ModalCant10").value = "1";

    var codbarra = document.getElementById("codbarra" + numero).innerHTML;
    var descripc = document.getElementById("descripcion" + numero).innerHTML;
    $.ajax({
      type: "POST",
      url: "utilidadess.php",
      data: {
        cod: codbarra,
        des: descripc,
        CodIdBasico: CodIdBasicoAct,
        Company: document.getElementById("CompanyActual").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        MonedaS: document.getElementById("MonedaS").innerHTML,
        //param: 'S',
        Accion: "generarcodbarra",
      },
    }).done(function (msg) {
      document.getElementById("barrascod").innerHTML = msg;
    });

    $.ajax({
      type: "POST",
      url: "dataseeks/Dataseek2r.php",
      data: {
        Almacen: "3",
        Id: document.getElementById("ModalCodIdBasico3").value,
        CompanyActual: document.getElementById("CompanyActual").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        MonedaS: document.getElementById("MonedaS").innerHTML,
      },
    }).done(function (msg) {
      $("#abcdfghjqwet").html(msg);
    });
    $.ajax({
      type: "POST",
      url: "DataHandler1.php",
      data: {
        Accion: "Stock",
        ModalCodIdBasico: document.getElementById("codidbasico1" + numero)
          .innerHTML,
        companyUser: document.getElementById("com" + numero).value,
        ModalMedida: document.getElementById("medida" + numero).innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        MonedaS: document.getElementById("MonedaS").innerHTML,
      },
    }).done(function (msg) {
      $("#Resultado").html(msg);
    });

    var NewMargen = new Number(document.getElementById("ModalMargen").value);
    var NewCostoNeto = new Number(
      document.getElementById("ModalCostoNeto").value,
    );
    var NewPrecioBruto = new Number(
      document.getElementById("ModalPrecioNeto").value,
    );
    var NewCostoBruto = new Number(
      document.getElementById("ModalCostos").value,
    );
    var NewPrecioNeto = new Number(
      document.getElementById("ModalPrecioVenta").value,
    );
    var NewPrecioBruto2 = new Number(
      document.getElementById("ModalPrecioNeto2").value,
    );
    var NewPrecioNeto2 = new Number(
      document.getElementById("ModalPrecioVenta2").value,
    );
    var NewMargen2 = new Number(document.getElementById("ModalMargen2").value);
    var NewPrecioBruto3 = new Number(
      document.getElementById("ModalPrecioNeto3").value,
    );
    var NewPrecioNeto3 = new Number(
      document.getElementById("ModalPrecioVenta3").value,
    );
    var NewMargen3 = new Number(document.getElementById("ModalMargen3").value);

    var NewPrecioBruto4 = new Number(
      document.getElementById("ModalPrecioNeto4").value,
    );
    var NewPrecioNeto4 = new Number(
      document.getElementById("ModalPrecioVenta4").value,
    );
    var NewMargen4 = new Number(document.getElementById("ModalMargen4").value);

    var NewPrecioBruto5 = new Number(
      document.getElementById("ModalPrecioNeto5").value,
    );
    var NewPrecioNeto5 = new Number(
      document.getElementById("ModalPrecioVenta5").value,
    );
    var NewMargen5 = new Number(document.getElementById("ModalMargen5").value);

    var NewPrecioBruto6 = new Number(
      document.getElementById("ModalPrecioNeto6").value,
    );
    var NewPrecioNeto6 = new Number(
      document.getElementById("ModalPrecioVenta6").value,
    );
    var NewMargen6 = new Number(document.getElementById("ModalMargen6").value);

    var NewPrecioBruto7 = new Number(
      document.getElementById("ModalPrecioNeto7").value,
    );
    var NewPrecioNeto7 = new Number(
      document.getElementById("ModalPrecioVenta7").value,
    );
    var NewMargen7 = new Number(document.getElementById("ModalMargen7").value);

    var NewPrecioBruto8 = new Number(
      document.getElementById("ModalPrecioNeto8").value,
    );
    var NewPrecioNeto8 = new Number(
      document.getElementById("ModalPrecioVenta8").value,
    );
    var NewMargen8 = new Number(document.getElementById("ModalMargen8").value);

    var NewPrecioBruto9 = new Number(
      document.getElementById("ModalPrecioNeto9").value,
    );
    var NewPrecioNeto9 = new Number(
      document.getElementById("ModalPrecioVenta9").value,
    );
    var NewMargen9 = new Number(document.getElementById("ModalMargen9").value);

    var NewPrecioBruto10 = new Number(
      document.getElementById("ModalPrecioNeto10").value,
    );
    var NewPrecioNeto10 = new Number(
      document.getElementById("ModalPrecioVenta10").value,
    );
    var NewMargen10 = new Number(
      document.getElementById("ModalMargen10").value,
    );

    var ModalCant2 = new Number(document.getElementById("ModalCant2").value);
    var ModalCant3 = new Number(document.getElementById("ModalCant3").value);
    var ModalCant4 = new Number(document.getElementById("ModalCant4").value);
    var ModalCant5 = new Number(document.getElementById("ModalCant5").value);
    var ModalCant6 = new Number(document.getElementById("ModalCant6").value);
    var ModalCant7 = new Number(document.getElementById("ModalCant7").value);
    var ModalCant8 = new Number(document.getElementById("ModalCant8").value);
    var ModalCant9 = new Number(document.getElementById("ModalCant9").value);
    var ModalCant10 = new Number(document.getElementById("ModalCant10").value);

    document.getElementById("ModalCostos").value = NewCostoBruto.toFixed(2);
    document.getElementById("ModalCostoNeto").value = NewCostoNeto.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalMargen").value = NewMargen.toFixed(2);
    document.getElementById("ModalPrecioNeto").value =
      NewPrecioBruto.toFixed(2);
    document.getElementById("ModalPrecioVenta").value = NewPrecioNeto.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalMargen2").value = NewMargen2.toFixed(2);
    document.getElementById("ModalPrecioNeto2").value =
      NewPrecioBruto2.toFixed(2);
    document.getElementById("ModalPrecioVenta2").value = NewPrecioNeto2.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalMargen3").value = NewMargen3.toFixed(2);
    document.getElementById("ModalPrecioNeto3").value =
      NewPrecioBruto3.toFixed(2);
    document.getElementById("ModalPrecioVenta3").value = NewPrecioNeto3.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen4").value = NewMargen4.toFixed(2);
    document.getElementById("ModalPrecioNeto4").value =
      NewPrecioBruto4.toFixed(2);
    document.getElementById("ModalPrecioVenta4").value = NewPrecioNeto4.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen5").value = NewMargen5.toFixed(2);
    document.getElementById("ModalPrecioNeto5").value =
      NewPrecioBruto5.toFixed(2);
    document.getElementById("ModalPrecioVenta5").value = NewPrecioNeto5.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen6").value = NewMargen6.toFixed(2);
    document.getElementById("ModalPrecioNeto6").value =
      NewPrecioBruto6.toFixed(2);
    document.getElementById("ModalPrecioVenta6").value = NewPrecioNeto6.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen7").value = NewMargen7.toFixed(2);
    document.getElementById("ModalPrecioNeto7").value =
      NewPrecioBruto7.toFixed(2);
    document.getElementById("ModalPrecioVenta7").value = NewPrecioNeto7.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen8").value = NewMargen8.toFixed(2);
    document.getElementById("ModalPrecioNeto8").value =
      NewPrecioBruto8.toFixed(2);
    document.getElementById("ModalPrecioVenta8").value = NewPrecioNeto8.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen9").value = NewMargen9.toFixed(2);
    document.getElementById("ModalPrecioNeto9").value =
      NewPrecioBruto9.toFixed(2);
    document.getElementById("ModalPrecioVenta9").value = NewPrecioNeto9.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen10").value = NewMargen10.toFixed(2);
    document.getElementById("ModalPrecioNeto10").value =
      NewPrecioBruto10.toFixed(2);
    document.getElementById("ModalPrecioVenta10").value =
      NewPrecioNeto10.toFixed(document.getElementById("CD").innerHTML);

    if (
      document.getElementById("CantP1x" + numero).innerHTML == "" ||
      document.getElementById("CantP1x" + numero).innerHTML == "0"
    )
      document.getElementById("ModalCant2").value = "1";

    if (
      document.getElementById("CantP2" + numero).innerHTML == "" ||
      document.getElementById("CantP2" + numero).innerHTML == "0"
    )
      document.getElementById("ModalCant3").value = "1";

    if (
      document.getElementById("CantP4x" + numero).innerHTML == "" ||
      document.getElementById("CantP4x" + numero).innerHTML == "0"
    )
      document.getElementById("ModalCant4").value = "1";

    if (
      document.getElementById("CantP5x" + numero).innerHTML == "" ||
      document.getElementById("CantP5x" + numero).innerHTML == "0"
    )
      document.getElementById("ModalCant5").value = "1";

    if (
      document.getElementById("CantP6x" + numero).innerHTML == "" ||
      document.getElementById("CantP6x" + numero).innerHTML == "0"
    )
      document.getElementById("ModalCant6").value = "1";

    if (
      document.getElementById("CantP7x" + numero).innerHTML == "" ||
      document.getElementById("CantP7x" + numero).innerHTML == "0"
    )
      document.getElementById("ModalCant7").value = "1";

    if (
      document.getElementById("CantP8x" + numero).innerHTML == "" ||
      document.getElementById("CantP8x" + numero).innerHTML == "0"
    )
      document.getElementById("ModalCant8").value = "1";

    if (
      document.getElementById("CantP9x" + numero).innerHTML == "" ||
      document.getElementById("CantP9x" + numero).innerHTML == "0"
    )
      document.getElementById("ModalCant9").value = "1";

    if (
      document.getElementById("CantP10x" + numero).innerHTML == "" ||
      document.getElementById("CantP10x" + numero).innerHTML == "0"
    )
      document.getElementById("ModalCant10").value = "1";

    document.getElementById("ModalCant2").value = ModalCant2;
    document.getElementById("ModalCant3").value = ModalCant3;
    document.getElementById("ModalCant4").value = ModalCant4;
    document.getElementById("ModalCant5").value = ModalCant5;
    document.getElementById("ModalCant6").value = ModalCant6;
    document.getElementById("ModalCant7").value = ModalCant7;
    document.getElementById("ModalCant8").value = ModalCant8;
    document.getElementById("ModalCant9").value = ModalCant9;
    document.getElementById("ModalCant10").value = ModalCant10;

    if (
      document.getElementById("ModalCant2").value > 1 &&
      NewPrecioBruto2 > 0
    ) {
      document.getElementById("cantsimp").innerHTML =
        (NewPrecioBruto2.toFixed(2) / ModalCant2).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida2").value;
      document.getElementById("cantcimp").innerHTML =
        (NewPrecioNeto2.toFixed(2) / ModalCant2).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida2").value;
    }

    if (
      document.getElementById("ModalCant3").value > 1 &&
      NewPrecioBruto3 > 0
    ) {
      document.getElementById("cantsimp2").innerHTML =
        (NewPrecioBruto3.toFixed(2) / ModalCant3).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida3").value;
      document.getElementById("cantcimp2").innerHTML =
        (NewPrecioNeto3.toFixed(2) / ModalCant3).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida3").value;
    }

    if (
      document.getElementById("ModalCant4").value > 1 &&
      NewPrecioBruto4 > 0
    ) {
      document.getElementById("cantsimp4").innerHTML =
        (NewPrecioBruto4.toFixed(2) / ModalCant4).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida4").value;
      document.getElementById("cantcimp4").innerHTML =
        (NewPrecioNeto4.toFixed(2) / ModalCant4).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida4").value;
    }

    if (
      document.getElementById("ModalCant5").value > 1 &&
      NewPrecioBruto5 > 0
    ) {
      document.getElementById("cantsimp5").innerHTML =
        (NewPrecioBruto5.toFixed(2) / ModalCant5).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida5").value;
      document.getElementById("cantcimp5").innerHTML =
        (NewPrecioNeto5.toFixed(2) / ModalCant5).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida5").value;
    }

    if (
      document.getElementById("ModalCant6").value > 1 &&
      NewPrecioBruto6 > 0
    ) {
      document.getElementById("cantsimp6").innerHTML =
        (NewPrecioBruto6.toFixed(2) / ModalCant6).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida6").value;
      document.getElementById("cantcimp6").innerHTML =
        (NewPrecioNeto6.toFixed(2) / ModalCant6).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida6").value;
    }

    if (
      document.getElementById("ModalCant7").value > 1 &&
      NewPrecioBruto7 > 0
    ) {
      document.getElementById("cantsimp7").innerHTML =
        (NewPrecioBruto7.toFixed(2) / ModalCant7).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida7").value;
      document.getElementById("cantcimp7").innerHTML =
        (NewPrecioNeto7.toFixed(2) / ModalCant7).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida7").value;
    }

    if (
      document.getElementById("ModalCant8").value > 1 &&
      NewPrecioBruto8 > 0
    ) {
      document.getElementById("cantsimp8").innerHTML =
        (NewPrecioBruto8.toFixed(2) / ModalCant8).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida8").value;
      document.getElementById("cantcimp8").innerHTML =
        (NewPrecioNeto8.toFixed(2) / ModalCant8).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida8").value;
    }

    if (
      document.getElementById("ModalCant9").value > 1 &&
      NewPrecioBruto9 > 0
    ) {
      document.getElementById("cantsimp9").innerHTML =
        (NewPrecioBruto9.toFixed(2) / ModalCant9).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida9").value;
      document.getElementById("cantcimp9").innerHTML =
        (NewPrecioNeto9.toFixed(2) / ModalCant9).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida9").value;
    }

    if (
      document.getElementById("ModalCant10").value > 1 &&
      NewPrecioBruto10 > 0
    ) {
      document.getElementById("cantsimp10").innerHTML =
        (NewPrecioBruto10.toFixed(2) / ModalCant10).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida10").value;
      document.getElementById("cantcimp10").innerHTML =
        (NewPrecioNeto10.toFixed(2) / ModalCant10).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida10").value;
    }

    DeshabilitarButtond(1);
  } else {
    $("#ModalNoEstado").hide();
    $("#ModalEstadoact").show();
    CodIdBasicoAct = 0;

    document.getElementById("ModalTipOCosto").value = 0;
    document.getElementById("ModalCostoPercent").value = 0;
    TipoCostoChange();

    document.getElementById("titlemodal").innerHTML =
      document.getElementById("EleccionEc").innerHTML === "0"
        ? Utils2a.Agregar_Producto
        : Utils2a.Agregar_Servicio;
    $("#suggesstion-box").hide();
    $("#OnVariacion").prop("checked", false);
    $("#variac").addClass("d-none");
    $("#variac2").addClass("d-none");
    $("#checkvar").addClass("d-none");
    document.getElementById("cantsimp").innerHTML = "";
    document.getElementById("cantcimp").innerHTML = "";
    document.getElementById("cantsimp2").innerHTML = "";
    document.getElementById("cantcimp2").innerHTML = "";
    document.getElementById("cantsimp4").innerHTML = "";
    document.getElementById("cantcimp4").innerHTML = "";
    document.getElementById("cantsimp5").innerHTML = "";
    document.getElementById("cantcimp5").innerHTML = "";
    document.getElementById("cantsimp6").innerHTML = "";
    document.getElementById("cantcimp6").innerHTML = "";
    document.getElementById("cantsimp7").innerHTML = "";
    document.getElementById("cantcimp7").innerHTML = "";
    document.getElementById("cantsimp8").innerHTML = "";
    document.getElementById("cantcimp8").innerHTML = "";
    document.getElementById("cantsimp9").innerHTML = "";
    document.getElementById("cantcimp9").innerHTML = "";
    document.getElementById("cantsimp10").innerHTML = "";
    document.getElementById("cantcimp10").innerHTML = "";
    document.getElementById("Comision").value = "0";
    document.getElementById("Comision2").value = "0";
    document.getElementById("Comision3").value = "0";
    document.getElementById("Comision4").value = "0";
    document.getElementById("Comision5").value = "0";
    document.getElementById("Comision6").value = "0";
    document.getElementById("Comision7").value = "0";
    document.getElementById("Comision8").value = "0";
    document.getElementById("Comision9").value = "0";
    document.getElementById("Comision10").value = "0";

    var a = new Number(0);
    document.getElementById("ModalIdfamilia").value =
      document.getElementById("RegUnoFamilia").innerHTML;
    document.getElementById("ModalImpuestos").value =
      document.getElementById("RegUnoImpuesto").innerHTML;
    document.getElementById("ModalCodIdBasico3").readOnly = true;
    document.getElementById("ModalCodIdAmpliado").readOnly = false;
    document.getElementById("ModalCodIdBasico").readOnly = true;
    document.getElementById("ModalDescripcion3").readOnly = true;
    document.getElementById("Resultado").innerHTML = "";
    document.getElementById("abcdfghjqwet").innerHTML = "";
    document.getElementById("ModalCodIdBasico").value = "";
    document.getElementById("ModalCodIdAmpliado").value = "";
    document.getElementById("ModalMedida").value = "";
    document.getElementById("ModalMarca").value =
      document.getElementById("RegUnoMarca").innerHTML;
    document.getElementById("ModalCodBarra").value = "";
    document.getElementById("ModalDescripcion").value = "";
    document.getElementById("ModalFactorAltValue").value = 1;
    document.getElementById("ModalFactorAltName").value = "";
    document.getElementById("ModalMargen2").value = a.toFixed(2);
    document.getElementById("ModalPrecioVenta2").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalPrecioNeto2").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalMargen3").value = a.toFixed(2);
    document.getElementById("ModalPrecioVenta3").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalPrecioNeto3").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalMargen4").value = a.toFixed(2);
    document.getElementById("ModalPrecioVenta4").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalPrecioNeto4").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen5").value = a.toFixed(2);
    document.getElementById("ModalPrecioVenta5").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalPrecioNeto5").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen6").value = a.toFixed(2);
    document.getElementById("ModalPrecioVenta6").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalPrecioNeto6").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen7").value = a.toFixed(2);
    document.getElementById("ModalPrecioVenta7").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalPrecioNeto7").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen8").value = a.toFixed(2);
    document.getElementById("ModalPrecioVenta8").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalPrecioNeto8").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen9").value = a.toFixed(2);
    document.getElementById("ModalPrecioVenta9").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalPrecioNeto9").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen10").value = a.toFixed(2);
    document.getElementById("ModalPrecioVenta10").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalPrecioNeto10").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalCodIdBasico02").value = "";
    document.getElementById("ModalCostos").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen").value = a.toFixed(2);
    document.getElementById("ModalDescripcion2").value = "";
    document.getElementById("ModalCostoNeto").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalPrecioNeto").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalPrecioVenta").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalCodIdBasico3").value = "";
    document.getElementById("jsonEtiquetas").innerHTML = "";
    document.getElementById("ModalEnvase").value = "";
    Actualizar();
    document.getElementById("ModalDescripcion3").value = "";
    document.getElementById("ModalMin").value = 0;
    document.getElementById("ModalMax").value = 0;
    document.getElementById("ModalMedidas").value = "";
    document.getElementById("ModalMedida2").value = "";
    document.getElementById("ModalCant2").value = "1";
    document.getElementById("ModalMedida3").value = "";
    document.getElementById("ModalCant3").value = "1";
    document.getElementById("ModalMedida4").value = "";
    document.getElementById("ModalCant4").value = "1";
    document.getElementById("ModalMedida5").value = "";
    document.getElementById("ModalCant5").value = "1";
    document.getElementById("ModalMedida6").value = "";
    document.getElementById("ModalCant6").value = "1";
    document.getElementById("ModalMedida7").value = "";
    document.getElementById("ModalCant7").value = "1";
    document.getElementById("ModalMedida8").value = "";
    document.getElementById("ModalCant8").value = "1";
    document.getElementById("ModalMedida9").value = "";
    document.getElementById("ModalCant9").value = "1";
    document.getElementById("ModalMedida10").value = "";
    document.getElementById("ModalCant10").value = "1";
    document.getElementById("barrascod").innerHTML =
      "<input id='jcod' name='jcod' style='display:none'></input>";
    $("#ModalPorKilo").prop("checked", false);
    $("#ModalEstado").prop("checked", true);
    ChangeEstado();
    document.getElementById("ModalArea").value = 1;
    document.getElementById("ModalWeight").value = 0;
    document.getElementById("ModalHeight").value = 0;
    ChangeWidthHeight();
    DeshabilitarButtond(1);
  }
}

function puesnosecierra() {
  if (document.getElementById("ModalCodIdBasico").value.trim() == "") {
    if (
      document.getElementById("Comision").value == "0" &&
      document.getElementById("Comision2").value == "0" &&
      document.getElementById("Comision3").value == "0" &&
      document.getElementById("Comision4").value == "0" &&
      document.getElementById("Comision5").value == "0" &&
      document.getElementById("Comision6").value == "0" &&
      document.getElementById("Comision7").value == "0" &&
      document.getElementById("Comision8").value == "0" &&
      document.getElementById("Comision9").value == "0" &&
      document.getElementById("Comision10").value == "0" &&
      document.getElementById("ModalIdfamilia").value ==
        document.getElementById("RegUnoFamilia").innerHTML &&
      document.getElementById("ModalImpuestos").value ==
        document.getElementById("RegUnoImpuesto").innerHTML &&
      document.getElementById("ModalMarca").value ==
        document.getElementById("RegUnoMarca").innerHTML &&
      document.getElementById("Resultado").innerHTML == "" &&
      document.getElementById("abcdfghjqwet").innerHTML == "" &&
      document.getElementById("jsonEtiquetas").innerHTML == "" &&
      document.getElementById("ModalCodIdBasico").value == "" &&
      document.getElementById("ModalCodIdAmpliado").value == "" &&
      document.getElementById("ModalCodBarra").value == "" &&
      document.getElementById("ModalDescripcion").value == "" &&
      document.getElementById("ModalMargen2").value > 0 &&
      document.getElementById("ModalPrecioVenta2").value > 0 &&
      document.getElementById("ModalPrecioNeto2").value > 0 &&
      document.getElementById("ModalMargen3").value > 0 &&
      document.getElementById("ModalPrecioVenta3").value > 0 &&
      document.getElementById("ModalPrecioNeto3").value > 0 &&
      document.getElementById("ModalMargen4").value > 0 &&
      document.getElementById("ModalPrecioVenta4").value > 0 &&
      document.getElementById("ModalPrecioNeto4").value > 0 &&
      document.getElementById("ModalMargen5").value > 0 &&
      document.getElementById("ModalPrecioVenta5").value > 0 &&
      document.getElementById("ModalPrecioNeto5").value > 0 &&
      document.getElementById("ModalMargen6").value > 0 &&
      document.getElementById("ModalPrecioVenta6").value > 0 &&
      document.getElementById("ModalPrecioNeto6").value > 0 &&
      document.getElementById("ModalMargen7").value > 0 &&
      document.getElementById("ModalPrecioVenta7").value > 0 &&
      document.getElementById("ModalPrecioNeto7").value > 0 &&
      document.getElementById("ModalMargen8").value > 0 &&
      document.getElementById("ModalPrecioVenta8").value > 0 &&
      document.getElementById("ModalPrecioNeto8").value > 0 &&
      document.getElementById("ModalMargen9").value > 0 &&
      document.getElementById("ModalPrecioVenta9").value > 0 &&
      document.getElementById("ModalPrecioNeto9").value > 0 &&
      document.getElementById("ModalMargen10").value > 0 &&
      document.getElementById("ModalPrecioVenta10").value > 0 &&
      document.getElementById("ModalPrecioNeto10").value > 0 &&
      document.getElementById("ModalCostos").value > 0 &&
      document.getElementById("ModalMargen").value > 0 &&
      document.getElementById("ModalCostoNeto").value > 0 &&
      document.getElementById("ModalPrecioNeto").value > 0 &&
      document.getElementById("ModalPrecioVenta").value > 0 &&
      document.getElementById("ModalCodIdBasico02").value == "" &&
      document.getElementById("ModalDescripcion2").value == "" &&
      document.getElementById("ModalCodIdBasico3").value == "" &&
      document.getElementById("ModalEnvase").value == "" &&
      document.getElementById("ModalDescripcion3").value == "" &&
      document.getElementById("ModalMedidas").value == "" &&
      document.getElementById("ModalMedida2").value == "" &&
      document.getElementById("ModalMedida3").value == "" &&
      document.getElementById("ModalMedida4").value == "" &&
      document.getElementById("ModalMedida5").value == "" &&
      document.getElementById("ModalMedida6").value == "" &&
      document.getElementById("ModalMedida7").value == "" &&
      document.getElementById("ModalMedida8").value == "" &&
      document.getElementById("ModalMedida9").value == "" &&
      document.getElementById("ModalMedida10").value == "" &&
      document.getElementById("ModalMin").value == "0" &&
      document.getElementById("ModalMax").value == "0" &&
      document.getElementById("ModalCant2").value == "1" &&
      document.getElementById("ModalCant3").value == "1" &&
      document.getElementById("ModalCant4").value == "1" &&
      document.getElementById("ModalCant5").value == "1" &&
      document.getElementById("ModalCant6").value == "1" &&
      document.getElementById("ModalCant7").value == "1" &&
      document.getElementById("ModalCant8").value == "1" &&
      document.getElementById("ModalCant9").value == "1" &&
      document.getElementById("ModalCant10").value == "1"
    ) {
      $("#apps-modal").modal("hide");
    } else {
      var opcion = confirm(Utils2a.Desc13);
      if (opcion === true) {
        $("#apps-modal").modal("hide");
      }
    }
  } else {
    $("#apps-modal").modal("hide");
  }
}

function addd() {
  $("#apps-modalS").modal("show");
  document.getElementById("titlemodalS").innerHTML = Utils2a.Agregar_Variacion;
  $("#suggesstion-boxS").hide();
  document.getElementById("cantsimpS").innerHTML =
    document.getElementById("cantsimp").innerHTML;
  document.getElementById("cantcimpS").innerHTML =
    document.getElementById("cantcimp").innerHTML;
  document.getElementById("cantsimp2S").innerHTML =
    document.getElementById("cantsimp2").innerHTML;
  document.getElementById("cantcimp2S").innerHTML =
    document.getElementById("cantcimp2").innerHTML;
  document.getElementById("cantsimp4S").innerHTML =
    document.getElementById("cantsimp4").innerHTML;
  document.getElementById("cantcimp4S").innerHTML =
    document.getElementById("cantcimp4").innerHTML;
  document.getElementById("ComisionS").value =
    document.getElementById("Comision").value;
  document.getElementById("Comision2S").value =
    document.getElementById("Comision2").value;
  document.getElementById("Comision3S").value =
    document.getElementById("Comision3").value;
  document.getElementById("Comision4S").value =
    document.getElementById("Comision4").value;
  document.getElementById("Comision5S").value =
    document.getElementById("Comision5").value;
  document.getElementById("Comision6S").value =
    document.getElementById("Comision6").value;
  document.getElementById("Comision7S").value =
    document.getElementById("Comision7").value;
  document.getElementById("Comision8S").value =
    document.getElementById("Comision8").value;
  document.getElementById("Comision9S").value =
    document.getElementById("Comision9").value;
  document.getElementById("Comision10S").value =
    document.getElementById("Comision10").value;
  var a = new Number(0);
  document.getElementById("ModalImpuestosS").value =
    document.getElementById("ModalImpuestos").value;
  document.getElementById("ModalCodIdBasico3S").readOnly = true;
  document.getElementById("ModalCodIdAmpliadoS").readOnly = false;
  document.getElementById("ModalCodIdBasicoS").readOnly = true;
  document.getElementById("ModalDescripcion3S").readOnly = true;
  document.getElementById("ResultadoS").innerHTML =
    document.getElementById("Resultado").innerHTML;
  document.getElementById("abcdfghjqwetS").innerHTML =
    document.getElementById("abcdfghjqwet").innerHTML;
  document.getElementById("ModalCodIdBasicoS").value = "";
  document.getElementById("ModalCodIdBasicoPadreS").value =
    document.getElementById("ModalCodIdBasico").value;
  document.getElementById("ModalCodIdAmpliadoS").value =
    document.getElementById("ModalCodIdAmpliado").value;
  document.getElementById("ModalCodBarraS").value =
    document.getElementById("ModalCodIdAmpliado").value;
  document.getElementById("ModalMedidaS").value =
    document.getElementById("ModalMedida").value;
  document.getElementById("ModalMarcaS").value =
    document.getElementById("ModalMarca").value;
  document.getElementById("ModalIdfamiliaS").value =
    document.getElementById("ModalIdfamilia").value;
  ChangeWidthHeight();
  document.getElementById("ModalAreaS").value =
    document.getElementById("ModalArea").value;
  document.getElementById("ModalWeightS").value =
    document.getElementById("ModalWeight").value;
  document.getElementById("ModalHeightS").value =
    document.getElementById("ModalHeight").value;
  document.getElementById("ModalDescripcionS").value =
    document.getElementById("ModalDescripcion").value;
  document.getElementById("ModalFactorAltValueS").value =
    document.getElementById("ModalFactorAltValue").value;
  document.getElementById("ModalFactorAltNameS").value =
    document.getElementById("ModalFactorAltName").value;

  document.getElementById("ModalMargen2S").value =
    document.getElementById("ModalMargen2").value;
  document.getElementById("ModalPrecioVenta2S").value =
    document.getElementById("ModalPrecioVenta2").value;
  document.getElementById("ModalPrecioNeto2S").value =
    document.getElementById("ModalPrecioNeto2").value;
  document.getElementById("ModalMargen3S").value =
    document.getElementById("ModalMargen3").value;
  document.getElementById("ModalPrecioVenta3S").value =
    document.getElementById("ModalPrecioVenta3").value;
  document.getElementById("ModalPrecioNeto3S").value =
    document.getElementById("ModalPrecioNeto3").value;
  document.getElementById("ModalMargen4S").value =
    document.getElementById("ModalMargen4").value;
  document.getElementById("ModalPrecioVenta4S").value =
    document.getElementById("ModalPrecioVenta4").value;
  document.getElementById("ModalPrecioNeto4S").value =
    document.getElementById("ModalPrecioNeto4").value;

  document.getElementById("ModalMargen5S").value =
    document.getElementById("ModalMargen5").value;
  document.getElementById("ModalPrecioVenta5S").value =
    document.getElementById("ModalPrecioVenta5").value;
  document.getElementById("ModalPrecioNeto5S").value =
    document.getElementById("ModalPrecioNeto5").value;

  document.getElementById("ModalMargen6S").value =
    document.getElementById("ModalMargen6").value;
  document.getElementById("ModalPrecioVenta6S").value =
    document.getElementById("ModalPrecioVenta6").value;
  document.getElementById("ModalPrecioNeto6S").value =
    document.getElementById("ModalPrecioNeto6").value;

  document.getElementById("ModalMargen7S").value =
    document.getElementById("ModalMargen7").value;
  document.getElementById("ModalPrecioVenta7S").value =
    document.getElementById("ModalPrecioVenta7").value;
  document.getElementById("ModalPrecioNeto7S").value =
    document.getElementById("ModalPrecioNeto7").value;

  document.getElementById("ModalMargen8S").value =
    document.getElementById("ModalMargen8").value;
  document.getElementById("ModalPrecioVenta8S").value =
    document.getElementById("ModalPrecioVenta8").value;
  document.getElementById("ModalPrecioNeto8S").value =
    document.getElementById("ModalPrecioNeto8").value;

  document.getElementById("ModalMargen9S").value =
    document.getElementById("ModalMargen9").value;
  document.getElementById("ModalPrecioVenta9S").value =
    document.getElementById("ModalPrecioVenta9").value;
  document.getElementById("ModalPrecioNeto9S").value =
    document.getElementById("ModalPrecioNeto9").value;

  document.getElementById("ModalMargen10S").value =
    document.getElementById("ModalMargen10").value;
  document.getElementById("ModalPrecioVenta10S").value =
    document.getElementById("ModalPrecioVenta10").value;
  document.getElementById("ModalPrecioNeto10S").value =
    document.getElementById("ModalPrecioNeto10").value;

  document.getElementById("ModalCodIdBasico02S").value =
    document.getElementById("ModalCodIdBasico02").value;
  document.getElementById("ModalCostosS").value =
    document.getElementById("ModalCostos").value;
  document.getElementById("ModalMargenS").value =
    document.getElementById("ModalMargen").value;
  document.getElementById("ModalDescripcion2S").value =
    document.getElementById("ModalDescripcion2").value;
  document.getElementById("ModalCostoNetoS").value =
    document.getElementById("ModalCostoNeto").value;
  document.getElementById("ModalPrecioNetoS").value =
    document.getElementById("ModalPrecioNeto").value;
  document.getElementById("ModalPrecioVentaS").value =
    document.getElementById("ModalPrecioVenta").value;
  document.getElementById("ModalCodIdBasico3S").value =
    document.getElementById("ModalCodIdBasico3").value;
  document.getElementById("jsonEtiquetasS").innerHTML =
    document.getElementById("jsonEtiquetas").innerHTML;
  document.getElementById("ModalEnvaseS").value =
    document.getElementById("ModalEnvase").value;
  Actualizar();
  document.getElementById("ModalDescripcion3S").value =
    document.getElementById("ModalDescripcion3").value;
  document.getElementById("ModalMinS").value =
    document.getElementById("ModalMin").value;
  document.getElementById("ModalMaxS").value =
    document.getElementById("ModalMax").value;
  document.getElementById("ModalMedidasS").value =
    document.getElementById("ModalMedidas").value;
  document.getElementById("ModalMedida2S").value =
    document.getElementById("ModalMedida2").value;
  document.getElementById("ModalCant2S").value =
    document.getElementById("ModalCant2").value;
  document.getElementById("spp3S").innerHTML = "";
  document.getElementById("ModalMedida3S").value =
    document.getElementById("ModalMedida3").value;
  document.getElementById("ModalMedida4S").value =
    document.getElementById("ModalMedida4").value;

  document.getElementById("ModalMedida5S").value =
    document.getElementById("ModalMedida5").value;

  document.getElementById("ModalMedida6S").value =
    document.getElementById("ModalMedida6").value;

  document.getElementById("ModalMedida7S").value =
    document.getElementById("ModalMedida7").value;

  document.getElementById("ModalMedida8S").value =
    document.getElementById("ModalMedida8").value;

  document.getElementById("ModalMedida9S").value =
    document.getElementById("ModalMedida9").value;

  document.getElementById("ModalMedida10S").value =
    document.getElementById("ModalMedida10").value;

  document.getElementById("ModalCant3S").value =
    document.getElementById("ModalCant3").value;
  document.getElementById("ModalCant4S").value =
    document.getElementById("ModalCant4").value;

  document.getElementById("ModalCant5S").value =
    document.getElementById("ModalCant5").value;
  document.getElementById("ModalCant6S").value =
    document.getElementById("ModalCant6").value;
  document.getElementById("ModalCant7S").value =
    document.getElementById("ModalCant7").value;
  document.getElementById("ModalCant8S").value =
    document.getElementById("ModalCant8").value;
  document.getElementById("ModalCant9S").value =
    document.getElementById("ModalCant9").value;

  document.getElementById("ModalCant10S").value =
    document.getElementById("ModalCant10").value;

  document.getElementById("barrascodS").innerHTML =
    "<input id='jcodS' name='jcodS' style='display:none'></input>";
  $("#ModalPorKiloS").prop("checked", false);
  $("#ModalEstadoS").prop("checked", true);
  // ChangeEstado();
  viewtags2();
  traetec(1, "S");
  traetec(2, "S");
  setTimeout(() => sugerircoddelay(), 3000);

  //  DeshabilitarButtond(1);
}

function sugerircoddelay() {
  setTimeout(
    () => barraCodS(document.getElementById("ModalCodBarraS").value, "S"),
    500,
  );
}

function EnvioI2() {
  document.getElementById("Heisenberg2").innerHTML = Utils2a.Cargando;
  $.ajax({
    type: "POST",
    url: "productoseek.php",
    data: {
      Almacen: "4",
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      permiso: document.getElementById("MVaria").innerHTML,
      Id: document.getElementById("serialesspan2").innerHTML,
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      userperfil: document.getElementById("userperfil").innerHTML,
      IdAlmGroup: document.getElementById("IdAlmGroup").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      AlmacenesAtt: document.getElementById("AlmacenesAtt").innerHTML,
      IdAlmVtaSeleccionada: document.getElementById("IdAlmVtaSeleccionada")
        .innerHTML,
      IdAlmVta: document.getElementById("IdAlmVta").innerHTML,
      VerStock: document.getElementById("VerStock").innerHTML,
      VisualExist: document.getElementById("VisualExist").value,
      PerfilVentas: document.getElementById("PerfilVentas").innerHTML,
      sucursal: document.getElementById("sucursal").innerHTML,
    },
  }).done(function (msg) {
    $("#Heisenberg2").html(msg);
  });
}

function Pagineo2(n) {
  document.getElementById("PagAct2").innerHTML = n;
  EnvioIE();
}

function EnvioIE() {
  $.ajax({
    type: "POST",
    url: "dataseeks/Dataseek2r.php",
    data: {
      Almacen: "8",
      permiso: document.getElementById("MVaria").innerHTML,
      Id: document.getElementById("serialesspan2").innerHTML,
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      PagAct: document.getElementById("PagAct2").innerHTML,
      Limite: document.getElementById("thelimite").innerHTML,
    },
  }).done(function (msg) {
    //alert(msg);
    $("#Lucille").html(msg);
  });
}

function AgregarUbi() {
  $.ajax({
    type: "POST",
    url: "productoseek.php",
    data: {
      Accion: "2",
      ModalEnvase: document.getElementById("ModalUbiProdX").value,
      jsonEtiquetas: document.getElementById("jsonUbicacion").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    if (msg.trim() == "1") {
      document.getElementById(
        "alertaerrorenproducto",
      ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Etiqueta_Repetido}</strong><br><small>${Utils2a.Desc14}</small>`;
      $("#alertaerrorenproducto").delay(100).fadeIn("slow");
      setTimeout(() => OcultarNotificacion2(), 5000);
      $("#ModalUbiProdX").focus();
    } else {
      if (msg.trim() == "2") {
        document.getElementById(
          "alertaerrorenproducto",
        ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Seleccione_una_Ubicación}</strong><br><small>${Utils2a.Desc15}</small>`;
        $("#alertaerrorenproducto").delay(100).fadeIn("slow");
        setTimeout(() => OcultarNotificacion2(), 5000);
        $("#ModalUbiProdX").focus();
      } else {
        $("#Temporal").html(msg);
        document.getElementById("jsonUbicacion").innerHTML =
          document.getElementById("Numx001").innerHTML;
        $("#suggesstion-box2x").hide();
        $("#suggesstion-box2q").hide();
        Actualizar2();
      }
    }
  });
}

function Actualizar2() {
  $.ajax({
    type: "POST",
    url: "productoseek.php",
    data: {
      Accion: "6",
      jsonEtiquetas: document.getElementById("jsonUbicacion").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    $("#Temporal").html(msg);
    document.getElementById("MostrarUbicacion").innerHTML =
      document.getElementById("Numed001").innerHTML;
    document.getElementById("SelectorUbik").innerHTML =
      document.getElementById("Numed002").innerHTML;
  });
}

function AgregarEtiqueta() {
  $.ajax({
    type: "POST",
    url: "productoseek.php",
    data: {
      Accion: "2",
      ModalEnvase: document.getElementById("ModalEnvase").value,
      jsonEtiquetas: document.getElementById("jsonEtiquetas").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    if (document.getElementById("CompanyActual").innerHTML == "138") {
      alert(msg);
    }
    if (msg.trim() == "1") {
      document.getElementById("alertaerrorenproducto").innerHTML =
        '<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Etiqueta_Repetido}</strong><br><small>${Utils2a.Desc14}</small>';
      $("#alertaerrorenproducto").delay(100).fadeIn("slow");
      setTimeout(() => OcultarNotificacion2(), 5000);
      $("#ModalEnvase").focus();
    } else {
      if (msg.trim() == "2") {
        document.getElementById("alertaerrorenproducto").innerHTML =
          '<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Etiqueta_en_Blanco}</strong><br><small>${Utils2a.Desc16}</small>';
        $("#alertaerrorenproducto").delay(100).fadeIn("slow");
        setTimeout(() => OcultarNotificacion2(), 5000);
        $("#ModalEnvase").focus();
      } else {
        $("#Temporal").html(msg);
        document.getElementById("jsonEtiquetas").innerHTML =
          document.getElementById("Numx001").innerHTML;
        $("#ModalEnvase").blur().val("");
        $("#suggesstion-box2x").hide();
        $("#suggesstion-box2q").hide();
        Actualizar();
      }
    }
  });
}

function Actualizar() {
  $.ajax({
    type: "POST",
    url: "productoseek.php",
    data: {
      Accion: "3",
      jsonEtiquetas: document.getElementById("jsonEtiquetas").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    $("#MostrarEtiquetas").html(msg);
    $("#ModalEnvase").focus();
    $("#suggesstion-box2x").hide();
    $("#suggesstion-box2q").hide();
  });
}

function EliminarEtiqueta(Envase) {
  $.ajax({
    type: "POST",
    url: "productoseek.php",
    data: {
      Accion: "4",
      ModalEnvase: Envase,
      jsonEtiquetas: document.getElementById("jsonEtiquetas").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    $("#jsonEtiquetas").html(msg);
    $("#suggesstion-box2x").hide();
    $("#suggesstion-box2q").hide();
    Actualizar();
  });
}

function EliminarUbicak(Envase) {
  $.ajax({
    type: "POST",
    url: "productoseek.php",
    data: {
      Accion: "4",
      ModalEnvase: Envase,
      jsonEtiquetas: document.getElementById("jsonUbicacion").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    $("#jsonUbicacion").html(msg);
    Actualizar2();
  });
}

let avance = false;

let onlyOne;

let DataUp = {};

function EnvioFinal() {
  var fecha = new Date();
  var ano = fecha.getFullYear();
  var mes = fecha.getMonth() + 1;
  var dia = fecha.getDate();
  var hora = fecha.getHours();
  var min = fecha.getMinutes();
  var seg = fecha.getSeconds();
  var Fectxclient =
    ano + "-" + mes + "-" + dia + " " + hora + ":" + min + ":" + seg;
  if (
    document.getElementById("AlmacenesExcel").value !== "*" ||
    document.getElementById("EleccionEc").innerHTML == "9"
  ) {
    $("#resujltado").hide();
    $("#CargandoSubirProd").show();
    $("#Archivosubir").upload(
      "productoseek.php",
      {
        Action: "SubirExcel",
        Option: "2",
        CompanyActual: document.getElementById("CompanyActual").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        TokenEstacion: document.getElementById("TokenEstacion").innerHTML,
        correo: document.getElementById("correorep").innerHTML,
        FactorDolarCash: document.getElementById("FactorDolarCash").innerHTML,
        IdAlm: document.getElementById("AlmacenesExcel").value,
        userlogin: document.getElementById("userlogin").innerHTML,
        EsCompuesto: document.getElementById("EleccionEc").innerHTML,
        Fectxclient: Fectxclient,
        DataUp: JSON.stringify(DataUp),
      },
      function (array) {
        DataUp = {};
        if (array.status === 1) {
          $("#alertasubirexcel3").fadeIn(500);
          setTimeout(() => $("#alertasubirexcel3").fadeOut(1000), 5000);
          $("#CargandoSubirProd").hide();
        }
        if (array.status === 0) {
          $("#alertasubirexcel2").html(array.msg);
          $("#alertasubirexcel").fadeIn(500);
          setTimeout(() => $("#alertasubirexcel").fadeOut(1000), 5000);
        }
        $("#ButtonSubirExcel").prop("disabled", false);
        $("#Archivosubir").prop("disabled", false);
        avance = false;
      },
    );
  } else {
    $("#ButtonSubirExcel").prop("disabled", false);
    $("#Archivosubir").prop("disabled", false);
    avance = false;
  }
}

function onLoadingExcel() {
  if ($("#Archivosubir")[0].files.length !== 0) {
    $("#ButtonSubirExcel3").hide();
    $("#Archivosubir").prop("disabled", true);
    if (document.getElementById("EleccionEc").innerHTML == "0") {
      $("#AlmacenesExcel").hide();
    }
    $("#resujltado").hide();
    $("#CargandoSubirProd").show();
    DataUp = {};
    $("#Archivosubir").upload(
      "productoseek.php",
      {
        Action: "SubirExcel",
        Option: "1",
        EsCompuesto: document.getElementById("EleccionEc").innerHTML,
        CompanyActual: document.getElementById("CompanyActual").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
      },
      function (array) {
        if (array.status === 1) {
          $("#Archivosubir").prop("disabled", false);
          $("#CargandoSubirProd").hide();
          $("#resujltado").show();
          $("#resujltado").html(array.data);
          DataUp = array.json;
          if (document.getElementById("EleccionEc").innerHTML == "0") {
            $("#AlmacenesExcel").show();
          }
          $("#ButtonSubirExcel").show();
        }
        if (array.status === 0) {
          $("#Archivosubir").prop("disabled", false);
          $("#CargandoSubirProd").hide();
          $("#ButtonSubirExcel").show();
          $("#alertasubirexcel2").html(array.msg);
          $("#alertasubirexcel").fadeIn(500);
          setTimeout(() => $("#alertasubirexcel").fadeOut(1000), 5000);
          if (document.getElementById("EleccionEc").innerHTML == "0") {
            $("#AlmacenesExcel").hide();
          }
          $("#ButtonSubirExcel").hide();
        }
      },
    );
  } else {
    document.getElementById("AlmacenesExcel").value = "*";
    $("#resujltado").html("");
    $("#ButtonSubirExcel").hide();
    $("#ButtonSubirExcel3").show();
    if (document.getElementById("EleccionEc").innerHTML == "0") {
      $("#AlmacenesExcel").hide();
    }
  }
}

function SaveProdExcel() {
  if (avance === false) {
    avance = true;
    $("#ButtonSubirExcel").prop("disabled", true);
    $("#Archivosubir").prop("disabled", true);

    clearTimeout(onlyOne);

    onlyOne = setTimeout(() => EnvioFinal(), 700);
  }
}

function stringfam() {
  var values = $("#mIdfamilia").val();
  $("#mRegUnoFamilia").html(values.toString());
}
$(document).ready(function () {
  $("#mIdfamilia").select2({
    dropdownParent: $("#apps-modal"),
  });
});

function DeshabilitarButtond(n) {
  if (n == 1) {
    if (document.getElementById("ModalCodBarra").value.trim() !== "") {
      $("#ModalButtonCodBar").prop("disabled", false);
    } else {
      $("#ModalButtonCodBar").prop("disabled", true);
    }
  }
}

function impcod(cod) {
  const Company = document.getElementById("CompanyActual").innerHTML;
  if (["1140", "1197"].includes(Company)) {
    ImprimirCodBarra(
      document.getElementById("ModalCodIdBasico").value,
      cod,
      document.getElementById("ModalDescripcion").value,
    );
    return;
  }
  $.ajax({
    type: "POST",
    url: "utilidadess.php",
    data: {
      cod: cod,
      des: document.getElementById("ModalDescripcion").value,
      ModalCodIdAmpliado: document.getElementById("ModalCodIdAmpliado").value,
      Company: document.getElementById("CompanyActual").innerHTML,
      Accion: "impcodbarra",
      Logo: document.getElementById("LogotipoSpan").innerHTML,
      ImpCBDesc: document.getElementById("ImpCBDescSpan").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    if (msg != "") {
      document.getElementById("prints").innerHTML = msg;
      if (msg !== "") {
        setTimeout(() => window.print(), 500);
      }
    }
  });
}

function barraCod(cod) {
  var json = document.getElementById("jcod").value;
  var des = document.getElementById("ModalDescripcion").value;
  // const Company = document.getElementById("CompanyActual").innerHTML;
  // if (["1140", "1197"].includes(Company)) {
  //   ImprimirCodBarra(
  //     document.getElementById("ModalCodIdBasico").value,
  //     cod,
  //     des,
  //   );
  //   return;
  // }

  if (cod.trim() !== "") {
    $.ajax({
      type: "POST",
      url: "utilidadess.php",
      data: {
        cod: cod,
        json: json,
        des: des,
        CodIdBasico: CodIdBasicoAct,
        Company: document.getElementById("CompanyActual").innerHTML,
        Accion: "Codsbarra",
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        MonedaS: document.getElementById("MonedaS").innerHTML,
      },
    }).done(function (msg) {
      if (msg == 1) {
        document.getElementById(
          "alertaerrorenproducto",
        ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Código_Repetido}</strong><br><small>${Utils2a.Desc17}</small>`;
        $("#alertaerrorenproducto").delay(100).fadeIn("slow");
        setTimeout(() => OcultarNotificacion2(), 5000);
        document.getElementById("ModalCodBarra").value = "";
        $("#Costos2").removeClass("active");
        $("#Costos").removeClass("show active");
        $("#Inventario2").removeClass("active");
        $("#Inventario").removeClass("show active");
        $("#Informacion2").addClass("active");
        $("#Informacion").addClass("show active");
        $("#ModalCodBarra").focus();
      } else {
        document.getElementById("barrascod").innerHTML = msg;
        document.getElementById("ModalCodBarra").value = "";
        document.getElementById("jcod2").value =
          document.getElementById("jcod").value;
      }
    });
  }
}

function elminares(cod) {
  var json = document.getElementById("jcod").value;
  $.ajax({
    type: "POST",
    url: "utilidadess.php",
    data: {
      code: cod,
      json: json,
      des: document.getElementById("ModalDescripcion").value,
      Company: document.getElementById("CompanyActual").innerHTML,
      Accion: "eliminarcod",
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    document.getElementById("barrascod").innerHTML = msg;
    document.getElementById("jcod2").value =
      document.getElementById("jcod").value;
    $("#ModalCodBarra").focus();
  });
}

function verifvar(Id) {
  $.ajax({
    type: "POST",
    url: "productoseek.php",
    data: {
      go: "varia-verif",
      Idh: Id,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 1) {
      $("#visibleVar").removeClass("d-none");
      $("#visibleVar2").addClass("d-none");
      $("#datatableproduct2").addClass("d-none");
      document.getElementById("not").value = "1";
      viewtags(Id);
    } else {
      $("#datatableproduct2").removeClass("d-none");
      $("#visibleVar").addClass("d-none");
      $("#visibleVar2").removeClass("d-none");
      document.getElementById("not").value = "0";
      viewtags(Id);
    }
  });
}

function addtag() {
  var Id = document.getElementById("ModalCodIdBasico").value;
  var tagsadd = document.getElementById("tags").value;
  var tagsinputtext = document.getElementById("tagsinputtext").value;
  $.ajax({
    type: "POST",
    url: "productoseek.php",
    data: {
      go: "products-tags-add",
      tagsinputtext: tagsinputtext,
      tagsadd: tagsadd,
      tagsinput: document.getElementById("tagsinput").value,
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    $("#tagsview").html(msg);
    document.getElementById("tags").value = "";
    $("#tags").focus();
  });
}

function viewtags(Id, idhtml = "", not = "") {
  if (not == "2") {
    var not = "2";
  } else {
    var not = document.getElementById("not").value;
  }
  $.ajax({
    type: "POST",
    url: "productoseek.php",
    data: {
      go: "products-tags",
      not: not,
      Id: Id,
      idhtml: idhtml,
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    $("#tagsview" + idhtml).html(msg);
  });
}

function deltag(del) {
  var tagsinputtext = document.getElementById("tagsinputtext").value;
  $.ajax({
    type: "POST",
    url: "productoseek.php",
    data: {
      go: "products-tags-del",
      tagsinputtext: tagsinputtext,
      tagsinput: document.getElementById("tagsinput").value,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
      tag: del,
    },
  }).done(function (msg) {
    $("#tagsview").html(msg);
  });
}

function verfactores() {
  $.ajax({
    type: "POST",
    url: "productoseek.php",
    data: {
      Accion: "verfactores",
      jsonfactor: document.getElementById("jsonfactor").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    document.getElementById("visfactor").innerHTML = msg;
  });
}

function agrfac() {
  $.ajax({
    type: "POST",
    url: "productoseek.php",
    data: {
      Accion: "agrfac",
      jsonfactor: document.getElementById("jsonfactor").innerHTML,
      cantidad: document.getElementById("ModalCantxfactor").value,
      factor: document.getElementById("Modalfactor").value,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    document.getElementById("jsonfactor").innerHTML = msg;
    verfactores();
  });
}

function elifactores(n) {
  $.ajax({
    type: "POST",
    url: "productoseek.php",
    data: {
      Accion: "elifactores",
      jsonfactor: document.getElementById("jsonfactor").innerHTML,
      n: n,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    document.getElementById("jsonfactor").innerHTML = msg;
    verfactores();
  });
}

function valideKey(evt) {
  var code = evt.which ? evt.which : evt.keyCode;
  if (code == 8) {
    return true;
  } else {
    if (code >= 48 && code <= 57) {
      return true;
    } else {
      if (code == 13 || code == 46) {
        return true;
      } else {
        return false;
      }
    }
  }
}

function MaskNumberMoneda3(form, n) {
  Totalizarmp3(form);
}

function Totalizarmp3(form) {
  if (form.id === "ModalFactorAltValue") {
    const val = new Number(
      document.getElementById("ModalFactorAltValue").value,
    );

    if (val < 1) {
      document.getElementById("ModalFactorAltValue").value = 1;
    }
    return;
  }

  const ModalCostoPercent = new Number(
    document.getElementById("ModalCostoPercent").value,
  );

  if (form.id === "ModalCostoPercent") {
    if (ModalCostoPercent < 0) {
      document.getElementById("ModalCostoPercent").value = 0;
    } else if (ModalCostoPercent > 100) {
      document.getElementById("ModalCostoPercent").value = 100;
    }
    return;
  }

  if (document.getElementById("RecalPrice").innerHTML === "2") {
    var totot = new Number(0);
    var Impuesto = new Number(document.getElementById("ModalImpuestos").value);
    var NewMargen = new Number(document.getElementById("ModalMargen").value);
    var NewCostoNeto = new Number(
      document.getElementById("ModalCostoNeto").value,
    );
    var NewPrecioBruto = new Number(
      document.getElementById("ModalPrecioNeto").value,
    );
    var NewCostoBruto = new Number(
      document.getElementById("ModalCostos").value,
    );
    var NewPrecioNeto = new Number(
      document.getElementById("ModalPrecioVenta").value,
    );
    var NewPrecioBruto2 = new Number(
      document.getElementById("ModalPrecioNeto2").value,
    );
    var NewPrecioNeto2 = new Number(
      document.getElementById("ModalPrecioVenta2").value,
    );
    var NewMargen2 = new Number(document.getElementById("ModalMargen2").value);
    var NewPrecioBruto3 = new Number(
      document.getElementById("ModalPrecioNeto3").value,
    );
    var NewPrecioNeto3 = new Number(
      document.getElementById("ModalPrecioVenta3").value,
    );
    var NewMargen3 = new Number(document.getElementById("ModalMargen3").value);
    var NewPrecioBruto4 = new Number(
      document.getElementById("ModalPrecioNeto4").value,
    );
    var NewPrecioNeto4 = new Number(
      document.getElementById("ModalPrecioVenta4").value,
    );
    var NewMargen4 = new Number(document.getElementById("ModalMargen4").value);

    var NewPrecioBruto5 = new Number(
      document.getElementById("ModalPrecioNeto5").value,
    );
    var NewPrecioNeto5 = new Number(
      document.getElementById("ModalPrecioVenta5").value,
    );
    var NewMargen5 = new Number(document.getElementById("ModalMargen5").value);

    var NewPrecioBruto6 = new Number(
      document.getElementById("ModalPrecioNeto6").value,
    );
    var NewPrecioNeto6 = new Number(
      document.getElementById("ModalPrecioVenta6").value,
    );
    var NewMargen6 = new Number(document.getElementById("ModalMargen6").value);

    var NewPrecioBruto7 = new Number(
      document.getElementById("ModalPrecioNeto7").value,
    );
    var NewPrecioNeto7 = new Number(
      document.getElementById("ModalPrecioVenta7").value,
    );
    var NewMargen7 = new Number(document.getElementById("ModalMargen7").value);

    var NewPrecioBruto8 = new Number(
      document.getElementById("ModalPrecioNeto8").value,
    );
    var NewPrecioNeto8 = new Number(
      document.getElementById("ModalPrecioVenta8").value,
    );
    var NewMargen8 = new Number(document.getElementById("ModalMargen8").value);

    var NewPrecioBruto9 = new Number(
      document.getElementById("ModalPrecioNeto9").value,
    );
    var NewPrecioNeto9 = new Number(
      document.getElementById("ModalPrecioVenta9").value,
    );
    var NewMargen9 = new Number(document.getElementById("ModalMargen9").value);

    var NewPrecioBruto10 = new Number(
      document.getElementById("ModalPrecioNeto10").value,
    );
    var NewPrecioNeto10 = new Number(
      document.getElementById("ModalPrecioVenta10").value,
    );
    var NewMargen10 = new Number(
      document.getElementById("ModalMargen10").value,
    );

    var ModalCant2 = new Number(document.getElementById("ModalCant2").value);
    var ModalCant3 = new Number(document.getElementById("ModalCant3").value);
    var ModalCant4 = new Number(document.getElementById("ModalCant4").value);
    var ModalCant5 = new Number(document.getElementById("ModalCant5").value);
    var ModalCant6 = new Number(document.getElementById("ModalCant6").value);
    var ModalCant7 = new Number(document.getElementById("ModalCant7").value);
    var ModalCant8 = new Number(document.getElementById("ModalCant8").value);
    var ModalCant9 = new Number(document.getElementById("ModalCant9").value);
    var ModalCant10 = new Number(document.getElementById("ModalCant10").value);
    var ImpuestoACT = new Number(
      document.getElementById("ValordelImpuesto" + Impuesto).innerHTML,
    );
    var cad = new Number(document.getElementById("CD").innerHTML);
    if (cad > 0) {
      if (form.id == "ModalCant2") {
        if (ModalCant2 < 1 || ModalCant2 == "") ModalCant2 = 1;
      }
      if (form.id == "ModalCant3") {
        if (ModalCant3 < 1 || ModalCant3 == "") ModalCant3 = 1;
      }
      if (form.id == "ModalCant4") {
        if (ModalCant4 < 1 || ModalCant4 == "") ModalCant4 = 1;
      }
      if (form.id == "ModalCant5") {
        if (ModalCant5 < 1 || ModalCant5 == "") ModalCant5 = 1;
      }
      if (form.id == "ModalCant6") {
        if (ModalCant6 < 1 || ModalCant6 == "") ModalCant6 = 1;
      }
      if (form.id == "ModalCant7") {
        if (ModalCant7 < 1 || ModalCant7 == "") ModalCant7 = 1;
      }
      if (form.id == "ModalCant8") {
        if (ModalCant8 < 1 || ModalCant8 == "") ModalCant8 = 1;
      }
      if (form.id == "ModalCant9") {
        if (ModalCant9 < 1 || ModalCant9 == "") ModalCant9 = 1;
      }
      if (form.id == "ModalCant10") {
        if (ModalCant10 < 1 || ModalCant10 == "") ModalCant10 = 1;
      }
      if (form.id == "ModalImpuestos") {
        NewCostoNeto = NewCostoBruto * (1 + ImpuestoACT / 100);
        NewPrecioNeto = NewPrecioBruto * (1 + ImpuestoACT / 100);
        NewPrecioNeto2 = NewPrecioBruto2 * (1 + ImpuestoACT / 100);
        NewPrecioNeto3 = NewPrecioBruto3 * (1 + ImpuestoACT / 100);
        NewPrecioNeto4 = NewPrecioBruto4 * (1 + ImpuestoACT / 100);
        NewPrecioNeto5 = NewPrecioBruto5 * (1 + ImpuestoACT / 100);
        NewPrecioNeto6 = NewPrecioBruto6 * (1 + ImpuestoACT / 100);
        NewPrecioNeto7 = NewPrecioBruto7 * (1 + ImpuestoACT / 100);
        NewPrecioNeto8 = NewPrecioBruto8 * (1 + ImpuestoACT / 100);
        NewPrecioNeto9 = NewPrecioBruto9 * (1 + ImpuestoACT / 100);
        NewPrecioNeto10 = NewPrecioBruto10 * (1 + ImpuestoACT / 100);
      }
      if (form.id == "ModalCostoNeto") {
        if (NewCostoNeto == "" || NewCostoNeto == 0) NewCostoBruto = 0;

        if (NewCostoNeto > 0) {
          NewCostoBruto = NewCostoNeto / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen = 0;
            NewMargen2 = 0;
            NewMargen3 = 0;
            NewMargen4 = 0;
            NewMargen5 = 0;
            NewMargen6 = 0;
            NewMargen7 = 0;
            NewMargen8 = 0;
            NewMargen9 = 0;
            NewMargen10 = 0;
          } else {
            NewMargen = 0;
            NewMargen2 = 0;
            NewMargen3 = 0;
            NewMargen4 = 0;
            NewMargen5 = 0;
            NewMargen6 = 0;
            NewMargen7 = 0;
            NewMargen8 = 0;
            NewMargen9 = 0;
            NewMargen10 = 0;
            NewPrecioBruto = (NewCostoBruto * NewMargen) / 100 + NewCostoBruto;
            NewPrecioNeto = NewPrecioBruto * (1 + ImpuestoACT / 100);
            if (
              NewPrecioBruto > 0 ||
              NewPrecioBruto < 0 ||
              NewPrecioBruto == ""
            )
              NewMargen =
                ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;

            if (
              NewPrecioBruto2 > 0 ||
              NewPrecioBruto2 < 0 ||
              NewPrecioBruto2 == ""
            )
              NewMargen2 =
                ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;

            if (
              NewPrecioBruto3 > 0 ||
              NewPrecioBruto3 < 0 ||
              NewPrecioBruto3 == ""
            )
              NewMargen3 =
                ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;

            if (
              NewPrecioBruto4 > 0 ||
              NewPrecioBruto4 < 0 ||
              NewPrecioBruto4 == ""
            )
              NewMargen4 =
                ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;

            if (
              NewPrecioBruto5 > 0 ||
              NewPrecioBruto5 < 0 ||
              NewPrecioBruto5 == ""
            )
              NewMargen5 =
                ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;

            if (
              NewPrecioBruto6 > 0 ||
              NewPrecioBruto6 < 0 ||
              NewPrecioBruto6 == ""
            )
              NewMargen6 =
                ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;

            if (
              NewPrecioBruto7 > 0 ||
              NewPrecioBruto7 < 0 ||
              NewPrecioBruto7 == ""
            )
              NewMargen7 =
                ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;

            if (
              NewPrecioBruto8 > 0 ||
              NewPrecioBruto8 < 0 ||
              NewPrecioBruto8 == ""
            )
              NewMargen8 =
                ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;

            if (
              NewPrecioBruto9 > 0 ||
              NewPrecioBruto9 < 0 ||
              NewPrecioBruto9 == ""
            )
              NewMargen9 =
                ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;

            if (
              NewPrecioBruto10 > 0 ||
              NewPrecioBruto10 < 0 ||
              NewPrecioBruto10 == ""
            )
              NewMargen10 =
                ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewCostoNeto < 0) NewCostoNeto = 0;
      }
      if (form.id == "ModalCostos") {
        if (ModalCostos == "") {
          NewCostoBruto = 0;
          NewCostoNeto = 0;
        }
        if (NewCostoBruto == 0) {
          NewCostoNeto = 0;
        }
        if (NewCostoBruto > 0) {
          NewCostoNeto = NewCostoBruto * (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen = 0;
            NewMargen2 = 0;
            NewMargen3 = 0;
            NewMargen4 = 0;
            NewMargen5 = 0;
            NewMargen6 = 0;
            NewMargen7 = 0;
            NewMargen8 = 0;
            NewMargen9 = 0;
            NewMargen10 = 0;
          } else {
            NewMargen = 0;
            NewMargen2 = 0;
            NewMargen3 = 0;
            NewMargen4 = 0;
            NewMargen5 = 0;
            NewMargen6 = 0;
            NewMargen7 = 0;
            NewMargen8 = 0;
            NewMargen9 = 0;
            NewMargen10 = 0;

            if (
              NewPrecioBruto > 0 ||
              NewPrecioBruto < 0 ||
              NewPrecioBruto == ""
            )
              NewMargen =
                ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;

            if (
              NewPrecioBruto2 > 0 ||
              NewPrecioBruto2 < 0 ||
              NewPrecioBruto2 == ""
            )
              NewMargen2 =
                ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;

            if (
              NewPrecioBruto3 > 0 ||
              NewPrecioBruto3 < 0 ||
              NewPrecioBruto3 == ""
            )
              NewMargen3 =
                ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;

            if (
              NewPrecioBruto4 > 0 ||
              NewPrecioBruto4 < 0 ||
              NewPrecioBruto4 == ""
            )
              NewMargen4 =
                ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;

            if (
              NewPrecioBruto5 > 0 ||
              NewPrecioBruto5 < 0 ||
              NewPrecioBruto5 == ""
            )
              NewMargen5 =
                ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;

            if (
              NewPrecioBruto6 > 0 ||
              NewPrecioBruto6 < 0 ||
              NewPrecioBruto6 == ""
            )
              NewMargen6 =
                ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;

            if (
              NewPrecioBruto7 > 0 ||
              NewPrecioBruto7 < 0 ||
              NewPrecioBruto7 == ""
            )
              NewMargen7 =
                ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;

            if (
              NewPrecioBruto8 > 0 ||
              NewPrecioBruto8 < 0 ||
              NewPrecioBruto8 == ""
            )
              NewMargen8 =
                ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;

            if (
              NewPrecioBruto9 > 0 ||
              NewPrecioBruto9 < 0 ||
              NewPrecioBruto9 == ""
            )
              NewMargen9 =
                ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;

            if (
              NewPrecioBruto10 > 0 ||
              NewPrecioBruto10 < 0 ||
              NewPrecioBruto10 == ""
            )
              NewMargen10 =
                ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewCostoBruto < 0) {
          NewCostoNeto = 0;
          NewCostoBruto = 0;
        }
      }
      if (form.id == "ModalMargen") {
        if (NewMargen == 0) {
          NewPrecioBruto = NewCostoBruto;
          NewPrecioNeto = NewPrecioBruto * (1 + ImpuestoACT / 100);
        }
        if (NewMargen == "") {
          NewPrecioNeto = NewPrecioBruto * (1 + ImpuestoACT / 100);
        }
        if (NewMargen !== 0) {
          NewPrecioBruto = (NewCostoBruto * NewMargen) / 100 + NewCostoBruto;
          NewPrecioNeto = NewPrecioBruto * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto") {
        if (NewPrecioBruto == "") {
          NewPrecioNeto = 0;
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto == 0) {
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto = 0;
        }
        if (NewPrecioBruto > 0) {
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto = NewPrecioBruto * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto < 0) {
          NewPrecioBruto = 0;
        }
      }
      if (form.id == "ModalPrecioVenta") {
        if (NewPrecioNeto == "") {
          NewPrecioBruto = 0;
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto == 0) {
          NewPrecioBruto = 0;
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto > 0) {
          NewPrecioBruto = NewPrecioNeto / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto < 0) {
          NewPrecioNeto = 0;
        }
      }
      if (form.id == "ModalMargen2") {
        if (NewMargen2 == 0) {
          NewPrecioBruto2 = NewCostoBruto;
          NewPrecioNeto2 = NewPrecioBruto2 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen2 == "") {
          NewPrecioNeto2 = NewPrecioBruto2 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen2 !== 0) {
          NewPrecioBruto2 = (NewCostoBruto * NewMargen2) / 100 + NewCostoBruto;
          NewPrecioNeto2 = NewPrecioBruto2 * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto2") {
        if (NewPrecioBruto2 == "") {
          NewPrecioNeto2 = 0;
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto2 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto2 = 0;
        }
        if (NewPrecioBruto2 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto2 = NewPrecioBruto2 * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto2 < 0) {
          NewPrecioBruto2 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta2") {
        if (NewPrecioNeto2 == "") {
          NewPrecioBruto2 = 0;
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto2 == 0) {
          NewPrecioBruto2 = 0;
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto2 > 0) {
          NewPrecioBruto2 = NewPrecioNeto2 / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto2 < 0) {
          NewPrecioNeto2 = 0;
        }
      }
      if (form.id == "ModalMargen3") {
        if (NewMargen3 == 0) {
          NewPrecioBruto3 = NewCostoBruto;
          NewPrecioNeto3 = NewPrecioBruto3 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen3 == "") {
          NewPrecioNeto3 = NewPrecioBruto3 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen3 !== 0) {
          NewPrecioBruto3 = (NewCostoBruto * NewMargen3) / 100 + NewCostoBruto;
          NewPrecioNeto3 = NewPrecioBruto3 * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto3") {
        if (NewPrecioBruto3 == "") {
          NewPrecioNeto3 = 0;
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto3 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto3 = 0;
        }
        if (NewPrecioBruto3 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto3 = NewPrecioBruto3 * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto3 < 0) {
          NewPrecioBruto3 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta3") {
        if (NewPrecioNeto3 == "") {
          NewPrecioBruto3 = 0;
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto3 == 0) {
          NewPrecioBruto3 = 0;
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto3 > 0) {
          NewPrecioBruto3 = NewPrecioNeto3 / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto3 < 0) {
          NewPrecioNeto3 = 0;
        }
      }

      if (form.id == "ModalMargen4") {
        if (NewMargen4 == 0) {
          NewPrecioBruto4 = NewCostoBruto;
          NewPrecioNeto4 = NewPrecioBruto4 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen4 == "") {
          NewPrecioNeto4 = NewPrecioBruto4 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen4 !== 0) {
          NewPrecioBruto4 = (NewCostoBruto * NewMargen4) / 100 + NewCostoBruto;
          NewPrecioNeto4 = NewPrecioBruto4 * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto4") {
        if (NewPrecioBruto4 == "") {
          NewPrecioNeto4 = 0;
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto4 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto4 = 0;
        }
        if (NewPrecioBruto4 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto4 = NewPrecioBruto4 * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto4 < 0) {
          NewPrecioBruto4 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta4") {
        if (NewPrecioNeto4 == "") {
          NewPrecioBruto4 = 0;
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto4 == 0) {
          NewPrecioBruto4 = 0;
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto4 > 0) {
          NewPrecioBruto4 = NewPrecioNeto4 / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto4 < 0) {
          NewPrecioNeto4 = 0;
        }
      }

      if (form.id == "ModalMargen5") {
        if (NewMargen5 == 0) {
          NewPrecioBruto5 = NewCostoBruto;
          NewPrecioNeto5 = NewPrecioBruto5 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen5 == "") {
          NewPrecioNeto5 = NewPrecioBruto5 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen5 !== 0) {
          NewPrecioBruto5 = (NewCostoBruto * NewMargen5) / 100 + NewCostoBruto;
          NewPrecioNeto5 = NewPrecioBruto5 * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto5") {
        if (NewPrecioBruto5 == "") {
          NewPrecioNeto5 = 0;
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto5 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto5 = 0;
        }
        if (NewPrecioBruto5 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto5 = NewPrecioBruto5 * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto5 < 0) {
          NewPrecioBruto5 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta5") {
        if (NewPrecioNeto5 == "") {
          NewPrecioBruto5 = 0;
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto5 == 0) {
          NewPrecioBruto5 = 0;
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto5 > 0) {
          NewPrecioBruto5 = NewPrecioNeto5 / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto5 < 0) {
          NewPrecioNeto5 = 0;
        }
      }

      if (form.id == "ModalMargen6") {
        if (NewMargen6 == 0) {
          NewPrecioBruto6 = NewCostoBruto;
          NewPrecioNeto6 = NewPrecioBruto6 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen6 == "") {
          NewPrecioNeto6 = NewPrecioBruto6 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen6 !== 0) {
          NewPrecioBruto6 = (NewCostoBruto * NewMargen6) / 100 + NewCostoBruto;
          NewPrecioNeto6 = NewPrecioBruto6 * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto6") {
        if (NewPrecioBruto6 == "") {
          NewPrecioNeto6 = 0;
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto6 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto6 = 0;
        }
        if (NewPrecioBruto6 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto6 = NewPrecioBruto6 * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto6 < 0) {
          NewPrecioBruto6 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta6") {
        if (NewPrecioNeto6 == "") {
          NewPrecioBruto6 = 0;
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto6 == 0) {
          NewPrecioBruto6 = 0;
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto6 > 0) {
          NewPrecioBruto6 = NewPrecioNeto6 / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto6 < 0) {
          NewPrecioNeto6 = 0;
        }
      }

      if (form.id == "ModalMargen7") {
        if (NewMargen7 == 0) {
          NewPrecioBruto7 = NewCostoBruto;
          NewPrecioNeto7 = NewPrecioBruto7 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen7 == "") {
          NewPrecioNeto7 = NewPrecioBruto7 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen7 !== 0) {
          NewPrecioBruto7 = (NewCostoBruto * NewMargen7) / 100 + NewCostoBruto;
          NewPrecioNeto7 = NewPrecioBruto7 * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto7") {
        if (NewPrecioBruto7 == "") {
          NewPrecioNeto7 = 0;
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto7 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto7 = 0;
        }
        if (NewPrecioBruto7 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto7 = NewPrecioBruto7 * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto7 < 0) {
          NewPrecioBruto7 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta7") {
        if (NewPrecioNeto7 == "") {
          NewPrecioBruto7 = 0;
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto7 == 0) {
          NewPrecioBruto7 = 0;
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto7 > 0) {
          NewPrecioBruto7 = NewPrecioNeto7 / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto7 < 0) {
          NewPrecioNeto7 = 0;
        }
      }

      if (form.id == "ModalMargen8") {
        if (NewMargen8 == 0) {
          NewPrecioBruto8 = NewCostoBruto;
          NewPrecioNeto8 = NewPrecioBruto8 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen8 == "") {
          NewPrecioNeto8 = NewPrecioBruto8 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen8 !== 0) {
          NewPrecioBruto8 = (NewCostoBruto * NewMargen8) / 100 + NewCostoBruto;
          NewPrecioNeto8 = NewPrecioBruto8 * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto8") {
        if (NewPrecioBruto8 == "") {
          NewPrecioNeto8 = 0;
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto8 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto8 = 0;
        }
        if (NewPrecioBruto8 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto8 = NewPrecioBruto8 * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto8 < 0) {
          NewPrecioBruto8 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta8") {
        if (NewPrecioNeto8 == "") {
          NewPrecioBruto8 = 0;
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto8 == 0) {
          NewPrecioBruto8 = 0;
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto8 > 0) {
          NewPrecioBruto8 = NewPrecioNeto8 / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto8 < 0) {
          NewPrecioNeto8 = 0;
        }
      }

      if (form.id == "ModalMargen9") {
        if (NewMargen9 == 0) {
          NewPrecioBruto9 = NewCostoBruto;
          NewPrecioNeto9 = NewPrecioBruto9 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen9 == "") {
          NewPrecioNeto9 = NewPrecioBruto9 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen9 !== 0) {
          NewPrecioBruto9 = (NewCostoBruto * NewMargen9) / 100 + NewCostoBruto;
          NewPrecioNeto9 = NewPrecioBruto9 * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto9") {
        if (NewPrecioBruto9 == "") {
          NewPrecioNeto9 = 0;
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto9 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto9 = 0;
        }
        if (NewPrecioBruto9 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto9 = NewPrecioBruto9 * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto9 < 0) {
          NewPrecioBruto9 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta9") {
        if (NewPrecioNeto9 == "") {
          NewPrecioBruto9 = 0;
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto9 == 0) {
          NewPrecioBruto9 = 0;
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto9 > 0) {
          NewPrecioBruto9 = NewPrecioNeto9 / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto9 < 0) {
          NewPrecioNeto9 = 0;
        }
      }

      if (form.id == "ModalMargen10") {
        if (NewMargen10 == 0) {
          NewPrecioBruto10 = NewCostoBruto;
          NewPrecioNeto10 = NewPrecioBruto10 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen10 == "") {
          NewPrecioNeto10 = NewPrecioBruto10 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen10 !== 0) {
          NewPrecioBruto10 =
            (NewCostoBruto * NewMargen10) / 100 + NewCostoBruto;
          NewPrecioNeto10 = NewPrecioBruto10 * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto10") {
        if (NewPrecioBruto10 == "") {
          NewPrecioNeto10 = 0;
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto10 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto10 = 0;
        }
        if (NewPrecioBruto10 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto10 = NewPrecioBruto10 * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto10 < 0) {
          NewPrecioBruto10 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta10") {
        if (NewPrecioNeto10 == "") {
          NewPrecioBruto10 = 0;
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto10 == 0) {
          NewPrecioBruto10 = 0;
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto10 > 0) {
          NewPrecioBruto10 = NewPrecioNeto10 / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto10 < 0) {
          NewPrecioNeto10 = 0;
        }
      }
    } else {
      if (form.id == "ModalCant2") {
        if (ModalCant2 < 1 || ModalCant2 == "") ModalCant2 = 1;
      }
      if (form.id == "ModalCant3") {
        if (ModalCant3 < 1 || ModalCant3 == "") ModalCant3 = 1;
      }
      if (form.id == "ModalCant4") {
        if (ModalCant4 < 1 || ModalCant4 == "") ModalCant4 = 1;
      }
      if (form.id == "ModalCant5") {
        if (ModalCant5 < 1 || ModalCant5 == "") ModalCant5 = 1;
      }
      if (form.id == "ModalCant6") {
        if (ModalCant6 < 1 || ModalCant6 == "") ModalCant6 = 1;
      }
      if (form.id == "ModalCant7") {
        if (ModalCant7 < 1 || ModalCant7 == "") ModalCant7 = 1;
      }
      if (form.id == "ModalCant8") {
        if (ModalCant8 < 1 || ModalCant8 == "") ModalCant8 = 1;
      }
      if (form.id == "ModalCant9") {
        if (ModalCant9 < 1 || ModalCant9 == "") ModalCant9 = 1;
      }
      if (form.id == "ModalCant10") {
        if (ModalCant10 < 1 || ModalCant10 == "") ModalCant10 = 1;
      }
      if (form.id == "ModalImpuestos") {
        totot = Math.round(NewCostoBruto * 1 * (1 + ImpuestoACT / 100));
        NewCostoNeto = totot / 1;
        totot = Math.round(NewPrecioBruto * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto = totot / 1;
        totot = Math.round(NewPrecioBruto2 * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto2 = totot / 1;
        totot = Math.round(NewPrecioBruto3 * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto3 = totot / 1;
        totot = Math.round(NewPrecioBruto4 * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto4 = totot / 1;
        totot = Math.round(NewPrecioBruto5 * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto5 = totot / 1;
        totot = Math.round(NewPrecioBruto6 * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto6 = totot / 1;
        totot = Math.round(NewPrecioBruto7 * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto7 = totot / 1;
        totot = Math.round(NewPrecioBruto8 * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto8 = totot / 1;
        totot = Math.round(NewPrecioBruto9 * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto9 = totot / 1;
        totot = Math.round(NewPrecioBruto10 * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto10 = totot / 1;
      }
      if (form.id == "ModalCostoNeto") {
        if (NewCostoNeto == "") {
          NewCostoBruto = 0;
        }
        if (NewCostoNeto == 0) {
          NewCostoBruto = 0;
        }
        if (NewCostoNeto > 0) {
          totot = NewCostoNeto * 1;
          NewCostoBruto = Math.round(totot / (1 + ImpuestoACT / 100));
          if (NewCostoBruto == 0) {
            NewMargen = 0;
            NewMargen2 = 0;
            NewMargen3 = 0;
            NewMargen4 = 0;
            NewMargen5 = 0;
            NewMargen6 = 0;
            NewMargen7 = 0;
            NewMargen8 = 0;
            NewMargen9 = 0;
            NewMargen10 = 0;
          } else {
            NewMargen = 0;
            NewMargen2 = 0;
            NewMargen3 = 0;
            NewMargen4 = 0;
            NewMargen5 = 0;
            NewMargen6 = 0;
            NewMargen7 = 0;
            NewMargen8 = 0;
            NewMargen9 = 0;
            NewMargen10 = 0;

            if (
              NewPrecioBruto > 0 ||
              NewPrecioBruto < 0 ||
              NewPrecioBruto == ""
            )
              NewMargen =
                ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;

            if (
              NewPrecioBruto2 > 0 ||
              NewPrecioBruto2 < 0 ||
              NewPrecioBruto2 == ""
            )
              NewMargen2 =
                ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;

            if (
              NewPrecioBruto3 > 0 ||
              NewPrecioBruto3 < 0 ||
              NewPrecioBruto3 == ""
            )
              NewMargen3 =
                ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;

            if (
              NewPrecioBruto4 > 0 ||
              NewPrecioBruto4 < 0 ||
              NewPrecioBruto4 == ""
            )
              NewMargen4 =
                ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;

            if (
              NewPrecioBruto5 > 0 ||
              NewPrecioBruto5 < 0 ||
              NewPrecioBruto5 == ""
            )
              NewMargen5 =
                ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;

            if (
              NewPrecioBruto6 > 0 ||
              NewPrecioBruto6 < 0 ||
              NewPrecioBruto6 == ""
            )
              NewMargen6 =
                ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;

            if (
              NewPrecioBruto7 > 0 ||
              NewPrecioBruto7 < 0 ||
              NewPrecioBruto7 == ""
            )
              NewMargen7 =
                ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;

            if (
              NewPrecioBruto8 > 0 ||
              NewPrecioBruto8 < 0 ||
              NewPrecioBruto8 == ""
            )
              NewMargen8 =
                ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;

            if (
              NewPrecioBruto9 > 0 ||
              NewPrecioBruto9 < 0 ||
              NewPrecioBruto9 == ""
            )
              NewMargen9 =
                ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;

            if (
              NewPrecioBruto10 > 0 ||
              NewPrecioBruto10 < 0 ||
              NewPrecioBruto10 == ""
            )
              NewMargen10 =
                ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewCostoNeto < 0) {
          NewCostoNeto = 0;
        }
      }
      if (form.id == "ModalCostos") {
        if (ModalCostos == "") {
          NewCostoBruto = 0;
          NewCostoNeto = 0;
        }
        if (NewCostoBruto == 0) {
          NewCostoNeto = 0;
        }
        if (NewCostoBruto > 0) {
          totot = Math.round(NewCostoBruto * 1 * (1 + ImpuestoACT / 100));
          NewCostoNeto = totot / 1;
          if (NewCostoBruto == 0) {
            NewMargen = 0;
            NewMargen2 = 0;
            NewMargen3 = 0;
            NewMargen4 = 0;
            NewMargen5 = 0;
            NewMargen6 = 0;
            NewMargen7 = 0;
            NewMargen8 = 0;
            NewMargen9 = 0;
            NewMargen10 = 0;
          } else {
            NewMargen = 0;
            NewMargen2 = 0;
            NewMargen3 = 0;
            NewMargen4 = 0;
            NewMargen5 = 0;
            NewMargen6 = 0;
            NewMargen7 = 0;
            NewMargen8 = 0;
            NewMargen9 = 0;
            NewMargen10 = 0;

            if (
              NewPrecioBruto > 0 ||
              NewPrecioBruto < 0 ||
              NewPrecioBruto == ""
            )
              NewMargen =
                ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;

            if (
              NewPrecioBruto2 > 0 ||
              NewPrecioBruto2 < 0 ||
              NewPrecioBruto2 == ""
            )
              NewMargen2 =
                ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;

            if (
              NewPrecioBruto3 > 0 ||
              NewPrecioBruto3 < 0 ||
              NewPrecioBruto3 == ""
            )
              NewMargen3 =
                ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;

            if (
              NewPrecioBruto4 > 0 ||
              NewPrecioBruto4 < 0 ||
              NewPrecioBruto4 == ""
            )
              NewMargen4 =
                ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;

            if (
              NewPrecioBruto5 > 0 ||
              NewPrecioBruto5 < 0 ||
              NewPrecioBruto5 == ""
            )
              NewMargen5 =
                ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;

            if (
              NewPrecioBruto6 > 0 ||
              NewPrecioBruto6 < 0 ||
              NewPrecioBruto6 == ""
            )
              NewMargen6 =
                ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;

            if (
              NewPrecioBruto7 > 0 ||
              NewPrecioBruto7 < 0 ||
              NewPrecioBruto7 == ""
            )
              NewMargen7 =
                ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;

            if (
              NewPrecioBruto8 > 0 ||
              NewPrecioBruto8 < 0 ||
              NewPrecioBruto8 == ""
            )
              NewMargen8 =
                ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;

            if (
              NewPrecioBruto9 > 0 ||
              NewPrecioBruto9 < 0 ||
              NewPrecioBruto9 == ""
            )
              NewMargen9 =
                ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;

            if (
              NewPrecioBruto10 > 0 ||
              NewPrecioBruto10 < 0 ||
              NewPrecioBruto10 == ""
            )
              NewMargen10 =
                ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewCostoBruto < 0) {
          NewCostoNeto = 0;
          NewCostoBruto = 0;
        }
      }
      if (form.id == "ModalMargen") {
        if (NewMargen == 0) {
          NewPrecioBruto = NewCostoBruto;
          NewPrecioNeto = Math.round(NewPrecioBruto * (1 + ImpuestoACT / 100));
        }
        if (NewMargen == "") {
          NewPrecioNeto = Math.round(NewPrecioBruto * (1 + ImpuestoACT / 100));
        }
        if (NewMargen !== 0) {
          NewPrecioBruto = (NewCostoBruto * NewMargen) / 100 + NewCostoBruto;
          NewPrecioNeto = Math.round(NewPrecioBruto * (1 + ImpuestoACT / 100));
        }
      }
      if (form.id == "ModalPrecioNeto") {
        if (NewPrecioBruto == "") {
          NewPrecioNeto = 0;
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto == 0) {
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto = 0;
        }
        if (NewPrecioBruto > 0) {
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto = totot / 1;
        }
        if (NewPrecioBruto < 0) {
          NewPrecioBruto = 0;
        }
      }
      if (form.id == "ModalPrecioVenta") {
        if (NewPrecioNeto == "") {
          NewPrecioBruto = 0;
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto == 0) {
          NewPrecioBruto = 0;
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto > 0) {
          NewPrecioBruto = Math.round(
            (NewPrecioNeto * 1) / (1 + ImpuestoACT / 100),
          );
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto < 0) {
          NewPrecioNeto = 0;
        }
      }
      if (form.id == "ModalMargen2") {
        if (NewMargen2 == 0) {
          NewPrecioBruto2 = NewCostoBruto;
          NewPrecioNeto2 = Math.round(
            NewPrecioBruto2 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen2 == "") {
          NewPrecioNeto2 = Math.round(
            NewPrecioBruto2 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen2 !== 0) {
          NewPrecioBruto2 = (NewCostoBruto * NewMargen2) / 100 + NewCostoBruto;
          NewPrecioNeto2 = Math.round(
            NewPrecioBruto2 * (1 + ImpuestoACT / 100),
          );
        }
      }
      if (form.id == "ModalPrecioNeto2") {
        if (NewPrecioBruto2 == "") {
          NewPrecioNeto2 = 0;
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto2 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto2 = 0;
        }
        if (NewPrecioBruto2 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto2 * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto2 = totot / 1;
        }
        if (NewPrecioBruto2 < 0) {
          NewPrecioBruto2 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta2") {
        if (NewPrecioNeto2 == "") {
          NewPrecioBruto2 = 0;
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto2 == 0) {
          NewPrecioBruto2 = 0;
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto2 > 0) {
          NewPrecioBruto2 = Math.round(
            (NewPrecioNeto2 * 1) / (1 + ImpuestoACT / 100),
          );
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto2 < 0) {
          NewPrecioNeto2 = 0;
        }
      }
      if (form.id == "ModalMargen3") {
        if (NewMargen3 == 0) {
          NewPrecioBruto3 = NewCostoBruto;
          NewPrecioNeto3 = Math.round(
            NewPrecioBruto3 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen3 == "") {
          NewPrecioNeto3 = Math.round(
            NewPrecioBruto3 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen3 !== 0) {
          NewPrecioBruto3 = (NewCostoBruto * NewMargen3) / 100 + NewCostoBruto;
          NewPrecioNeto3 = Math.round(
            NewPrecioBruto3 * (1 + ImpuestoACT / 100),
          );
        }
      }
      if (form.id == "ModalPrecioNeto3") {
        if (NewPrecioBruto3 == "") {
          NewPrecioNeto3 = 0;
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto3 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto3 = 0;
        }
        if (NewPrecioBruto3 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto3 * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto3 = totot / 1;
        }
        if (NewPrecioBruto3 < 0) {
          NewPrecioBruto3 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta3") {
        if (NewPrecioNeto3 == "") {
          NewPrecioBruto3 = 0;
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto3 == 0) {
          NewPrecioBruto3 = 0;
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto3 > 0) {
          totot = Math.round(NewPrecioNeto3 * 1);
          NewPrecioBruto3 = totot / (1 + ImpuestoACT / 100) / 1;
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto3 < 0) {
          NewPrecioNeto3 = 0;
        }
      }

      if (form.id == "ModalMargen4") {
        if (NewMargen4 == 0) {
          NewPrecioBruto4 = NewCostoBruto;
          NewPrecioNeto4 = Math.round(
            NewPrecioBruto4 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen4 == "") {
          NewPrecioNeto4 = Math.round(
            NewPrecioBruto4 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen4 !== 0) {
          NewPrecioBruto4 = (NewCostoBruto * NewMargen4) / 100 + NewCostoBruto;
          NewPrecioNeto4 = Math.round(
            NewPrecioBruto4 * (1 + ImpuestoACT / 100),
          );
        }
      }
      if (form.id == "ModalPrecioNeto4") {
        if (NewPrecioBruto4 == "") {
          NewPrecioNeto4 = 0;
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto4 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto4 = 0;
        }
        if (NewPrecioBruto4 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto4 * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto4 = totot / 1;
        }
        if (NewPrecioBruto4 < 0) {
          NewPrecioBruto4 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta4") {
        if (NewPrecioNeto4 == "") {
          NewPrecioBruto4 = 0;
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto4 == 0) {
          NewPrecioBruto4 = 0;
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto4 > 0) {
          totot = Math.round(NewPrecioNeto4 * 1);
          NewPrecioBruto4 = totot / (1 + ImpuestoACT / 100) / 1;
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto4 < 0) {
          NewPrecioNeto4 = 0;
        }
      }

      if (form.id == "ModalMargen5") {
        if (NewMargen5 == 0) {
          NewPrecioBruto5 = NewCostoBruto;
          NewPrecioNeto5 = Math.round(
            NewPrecioBruto5 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen5 == "") {
          NewPrecioNeto5 = Math.round(
            NewPrecioBruto5 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen5 !== 0) {
          NewPrecioBruto5 = (NewCostoBruto * NewMargen5) / 100 + NewCostoBruto;
          NewPrecioNeto5 = Math.round(
            NewPrecioBruto5 * (1 + ImpuestoACT / 100),
          );
        }
      }
      if (form.id == "ModalPrecioNeto5") {
        if (NewPrecioBruto5 == "") {
          NewPrecioNeto5 = 0;
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto5 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto5 = 0;
        }
        if (NewPrecioBruto5 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto5 * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto5 = totot / 1;
        }
        if (NewPrecioBruto5 < 0) {
          NewPrecioBruto5 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta5") {
        if (NewPrecioNeto5 == "") {
          NewPrecioBruto5 = 0;
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto5 == 0) {
          NewPrecioBruto5 = 0;
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto5 > 0) {
          totot = Math.round(NewPrecioNeto5 * 1);
          NewPrecioBruto5 = totot / (1 + ImpuestoACT / 100) / 1;
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto5 < 0) {
          NewPrecioNeto5 = 0;
        }
      }

      if (form.id == "ModalMargen6") {
        if (NewMargen6 == 0) {
          NewPrecioBruto6 = NewCostoBruto;
          NewPrecioNeto6 = Math.round(
            NewPrecioBruto6 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen6 == "") {
          NewPrecioNeto6 = Math.round(
            NewPrecioBruto6 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen6 !== 0) {
          NewPrecioBruto6 = (NewCostoBruto * NewMargen6) / 100 + NewCostoBruto;
          NewPrecioNeto6 = Math.round(
            NewPrecioBruto6 * (1 + ImpuestoACT / 100),
          );
        }
      }
      if (form.id == "ModalPrecioNeto6") {
        if (NewPrecioBruto6 == "") {
          NewPrecioNeto6 = 0;
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto6 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto6 = 0;
        }
        if (NewPrecioBruto6 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto6 * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto6 = totot / 1;
        }
        if (NewPrecioBruto6 < 0) {
          NewPrecioBruto6 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta6") {
        if (NewPrecioNeto6 == "") {
          NewPrecioBruto6 = 0;
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto6 == 0) {
          NewPrecioBruto6 = 0;
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto6 > 0) {
          totot = Math.round(NewPrecioNeto6 * 1);
          NewPrecioBruto6 = totot / (1 + ImpuestoACT / 100) / 1;
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto6 < 0) {
          NewPrecioNeto6 = 0;
        }
      }

      if (form.id == "ModalMargen7") {
        if (NewMargen7 == 0) {
          NewPrecioBruto7 = NewCostoBruto;
          NewPrecioNeto7 = Math.round(
            NewPrecioBruto7 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen7 == "") {
          NewPrecioNeto7 = Math.round(
            NewPrecioBruto7 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen7 !== 0) {
          NewPrecioBruto7 = (NewCostoBruto * NewMargen7) / 100 + NewCostoBruto;
          NewPrecioNeto7 = Math.round(
            NewPrecioBruto7 * (1 + ImpuestoACT / 100),
          );
        }
      }
      if (form.id == "ModalPrecioNeto7") {
        if (NewPrecioBruto7 == "") {
          NewPrecioNeto7 = 0;
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto7 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto7 = 0;
        }
        if (NewPrecioBruto7 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto7 * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto7 = totot / 1;
        }
        if (NewPrecioBruto7 < 0) {
          NewPrecioBruto7 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta7") {
        if (NewPrecioNeto7 == "") {
          NewPrecioBruto7 = 0;
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto7 == 0) {
          NewPrecioBruto7 = 0;
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto7 > 0) {
          totot = Math.round(NewPrecioNeto7 * 1);
          NewPrecioBruto7 = totot / (1 + ImpuestoACT / 100) / 1;
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto7 < 0) {
          NewPrecioNeto7 = 0;
        }
      }

      if (form.id == "ModalMargen8") {
        if (NewMargen8 == 0) {
          NewPrecioBruto8 = NewCostoBruto;
          NewPrecioNeto8 = Math.round(
            NewPrecioBruto8 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen8 == "") {
          NewPrecioNeto8 = Math.round(
            NewPrecioBruto8 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen8 !== 0) {
          NewPrecioBruto8 = (NewCostoBruto * NewMargen8) / 100 + NewCostoBruto;
          NewPrecioNeto8 = Math.round(
            NewPrecioBruto8 * (1 + ImpuestoACT / 100),
          );
        }
      }
      if (form.id == "ModalPrecioNeto8") {
        if (NewPrecioBruto8 == "") {
          NewPrecioNeto8 = 0;
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto8 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto8 = 0;
        }
        if (NewPrecioBruto8 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto8 * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto8 = totot / 1;
        }
        if (NewPrecioBruto8 < 0) {
          NewPrecioBruto8 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta8") {
        if (NewPrecioNeto8 == "") {
          NewPrecioBruto8 = 0;
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto8 == 0) {
          NewPrecioBruto8 = 0;
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto8 > 0) {
          totot = Math.round(NewPrecioNeto8 * 1);
          NewPrecioBruto8 = totot / (1 + ImpuestoACT / 100) / 1;
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto8 < 0) {
          NewPrecioNeto8 = 0;
        }
      }

      if (form.id == "ModalMargen9") {
        if (NewMargen9 == 0) {
          NewPrecioBruto9 = NewCostoBruto;
          NewPrecioNeto9 = Math.round(
            NewPrecioBruto9 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen9 == "") {
          NewPrecioNeto9 = Math.round(
            NewPrecioBruto9 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen9 !== 0) {
          NewPrecioBruto9 = (NewCostoBruto * NewMargen9) / 100 + NewCostoBruto;
          NewPrecioNeto9 = Math.round(
            NewPrecioBruto9 * (1 + ImpuestoACT / 100),
          );
        }
      }
      if (form.id == "ModalPrecioNeto9") {
        if (NewPrecioBruto9 == "") {
          NewPrecioNeto9 = 0;
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto9 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto9 = 0;
        }
        if (NewPrecioBruto9 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto9 * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto9 = totot / 1;
        }
        if (NewPrecioBruto9 < 0) {
          NewPrecioBruto9 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta9") {
        if (NewPrecioNeto9 == "") {
          NewPrecioBruto9 = 0;
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto9 == 0) {
          NewPrecioBruto9 = 0;
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto9 > 0) {
          totot = Math.round(NewPrecioNeto9 * 1);
          NewPrecioBruto9 = totot / (1 + ImpuestoACT / 100) / 1;
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto9 < 0) {
          NewPrecioNeto9 = 0;
        }
      }

      if (form.id == "ModalMargen10") {
        if (NewMargen10 == 0) {
          NewPrecioBruto10 = NewCostoBruto;
          NewPrecioNeto10 = Math.round(
            NewPrecioBruto10 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen10 == "") {
          NewPrecioNeto10 = Math.round(
            NewPrecioBruto10 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen10 !== 0) {
          NewPrecioBruto10 =
            (NewCostoBruto * NewMargen10) / 100 + NewCostoBruto;
          NewPrecioNeto10 = Math.round(
            NewPrecioBruto10 * (1 + ImpuestoACT / 100),
          );
        }
      }
      if (form.id == "ModalPrecioNeto10") {
        if (NewPrecioBruto10 == "") {
          NewPrecioNeto10 = 0;
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto10 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto10 = 0;
        }
        if (NewPrecioBruto10 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto10 * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto10 = totot / 1;
        }
        if (NewPrecioBruto10 < 0) {
          NewPrecioBruto10 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta10") {
        if (NewPrecioNeto10 == "") {
          NewPrecioBruto10 = 0;
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto10 == 0) {
          NewPrecioBruto10 = 0;
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto10 > 0) {
          totot = Math.round(NewPrecioNeto10 * 1);
          NewPrecioBruto10 = totot / (1 + ImpuestoACT / 100) / 1;
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto10 < 0) {
          NewPrecioNeto10 = 0;
        }
      }
    }
    document.getElementById("ModalCostos").value = NewCostoBruto.toFixed(2);
    document.getElementById("ModalCostoNeto").value = NewCostoNeto.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalMargen").value = NewMargen.toFixed(2);
    document.getElementById("ModalPrecioNeto").value =
      NewPrecioBruto.toFixed(2);
    document.getElementById("ModalPrecioVenta").value = NewPrecioNeto.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalMargen2").value = NewMargen2.toFixed(2);
    document.getElementById("ModalPrecioNeto2").value =
      NewPrecioBruto2.toFixed(2);
    document.getElementById("ModalPrecioVenta2").value = NewPrecioNeto2.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalCant2").value = ModalCant2;
    document.getElementById("ModalMargen3").value = NewMargen3.toFixed(2);
    document.getElementById("ModalPrecioNeto3").value =
      NewPrecioBruto3.toFixed(2);
    document.getElementById("ModalPrecioVenta3").value = NewPrecioNeto3.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalCant3").value = ModalCant3;

    document.getElementById("ModalMargen4").value = NewMargen4.toFixed(2);
    document.getElementById("ModalPrecioNeto4").value =
      NewPrecioBruto4.toFixed(2);
    document.getElementById("ModalPrecioVenta4").value = NewPrecioNeto4.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen5").value = NewMargen5.toFixed(2);
    document.getElementById("ModalPrecioNeto5").value =
      NewPrecioBruto5.toFixed(2);
    document.getElementById("ModalPrecioVenta5").value = NewPrecioNeto5.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen6").value = NewMargen6.toFixed(2);
    document.getElementById("ModalPrecioNeto6").value =
      NewPrecioBruto6.toFixed(2);
    document.getElementById("ModalPrecioVenta6").value = NewPrecioNeto6.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen7").value = NewMargen7.toFixed(2);
    document.getElementById("ModalPrecioNeto7").value =
      NewPrecioBruto7.toFixed(2);
    document.getElementById("ModalPrecioVenta7").value = NewPrecioNeto7.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen8").value = NewMargen8.toFixed(2);
    document.getElementById("ModalPrecioNeto8").value =
      NewPrecioBruto8.toFixed(2);
    document.getElementById("ModalPrecioVenta8").value = NewPrecioNeto8.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen9").value = NewMargen9.toFixed(2);
    document.getElementById("ModalPrecioNeto9").value =
      NewPrecioBruto9.toFixed(2);
    document.getElementById("ModalPrecioVenta9").value = NewPrecioNeto9.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen10").value = NewMargen10.toFixed(2);
    document.getElementById("ModalPrecioNeto10").value =
      NewPrecioBruto10.toFixed(2);
    document.getElementById("ModalPrecioVenta10").value =
      NewPrecioNeto10.toFixed(document.getElementById("CD").innerHTML);

    document.getElementById("ModalCant2").value = ModalCant2;
    document.getElementById("ModalCant3").value = ModalCant3;
    document.getElementById("ModalCant4").value = ModalCant4;
    document.getElementById("ModalCant5").value = ModalCant5;
    document.getElementById("ModalCant6").value = ModalCant6;
    document.getElementById("ModalCant7").value = ModalCant7;
    document.getElementById("ModalCant8").value = ModalCant8;
    document.getElementById("ModalCant9").value = ModalCant9;
    document.getElementById("ModalCant10").value = ModalCant10;
    if (ModalCant2 > 1 && NewPrecioBruto2 > 0) {
      document.getElementById("cantsimp").innerHTML =
        (NewPrecioBruto2.toFixed(2) / ModalCant2).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida2").value;
      document.getElementById("cantcimp").innerHTML =
        (NewPrecioNeto2.toFixed(2) / ModalCant2).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida2").value;
    } else {
      document.getElementById("cantsimp").innerHTML = "";
      document.getElementById("cantcimp").innerHTML = "";
    }
    if (ModalCant3 > 1 && NewPrecioBruto3 > 0) {
      document.getElementById("cantsimp2").innerHTML =
        (NewPrecioBruto3.toFixed(2) / ModalCant3).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida3").value;
      document.getElementById("cantcimp2").innerHTML =
        (NewPrecioNeto3.toFixed(2) / ModalCant3).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida3").value;
    } else {
      document.getElementById("cantsimp2").innerHTML = "";
      document.getElementById("cantcimp2").innerHTML = "";
    }
    if (ModalCant4 > 1 && NewPrecioBruto4 > 0) {
      document.getElementById("cantsimp4").innerHTML =
        (NewPrecioBruto4.toFixed(2) / ModalCant4).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida4").value;
      document.getElementById("cantcimp4").innerHTML =
        (NewPrecioNeto4.toFixed(2) / ModalCant4).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida4").value;
    } else {
      document.getElementById("cantsimp4").innerHTML = "";
      document.getElementById("cantcimp4").innerHTML = "";
    }

    if (ModalCant5 > 1 && NewPrecioBruto5 > 0) {
      document.getElementById("cantsimp5").innerHTML =
        (NewPrecioBruto5.toFixed(2) / ModalCant5).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida5").value;
      document.getElementById("cantcimp5").innerHTML =
        (NewPrecioNeto5.toFixed(2) / ModalCant5).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida5").value;
    } else {
      document.getElementById("cantsimp5").innerHTML = "";
      document.getElementById("cantcimp5").innerHTML = "";
    }

    if (ModalCant6 > 1 && NewPrecioBruto6 > 0) {
      document.getElementById("cantsimp6").innerHTML =
        (NewPrecioBruto6.toFixed(2) / ModalCant6).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida6").value;
      document.getElementById("cantcimp6").innerHTML =
        (NewPrecioNeto6.toFixed(2) / ModalCant6).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida6").value;
    } else {
      document.getElementById("cantsimp6").innerHTML = "";
      document.getElementById("cantcimp6").innerHTML = "";
    }

    if (ModalCant7 > 1 && NewPrecioBruto7 > 0) {
      document.getElementById("cantsimp7").innerHTML =
        (NewPrecioBruto7.toFixed(2) / ModalCant7).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida7").value;
      document.getElementById("cantcimp7").innerHTML =
        (NewPrecioNeto7.toFixed(2) / ModalCant7).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida7").value;
    } else {
      document.getElementById("cantsimp7").innerHTML = "";
      document.getElementById("cantcimp7").innerHTML = "";
    }

    if (ModalCant8 > 1 && NewPrecioBruto8 > 0) {
      document.getElementById("cantsimp8").innerHTML =
        (NewPrecioBruto8.toFixed(2) / ModalCant8).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida8").value;
      document.getElementById("cantcimp8").innerHTML =
        (NewPrecioNeto8.toFixed(2) / ModalCant8).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida8").value;
    } else {
      document.getElementById("cantsimp8").innerHTML = "";
      document.getElementById("cantcimp8").innerHTML = "";
    }

    if (ModalCant9 > 1 && NewPrecioBruto9 > 0) {
      document.getElementById("cantsimp9").innerHTML =
        (NewPrecioBruto9.toFixed(2) / ModalCant9).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida9").value;
      document.getElementById("cantcimp9").innerHTML =
        (NewPrecioNeto9.toFixed(2) / ModalCant9).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida9").value;
    } else {
      document.getElementById("cantsimp9").innerHTML = "";
      document.getElementById("cantcimp9").innerHTML = "";
    }

    if (ModalCant10 > 1 && NewPrecioBruto10 > 0) {
      document.getElementById("cantsimp10").innerHTML =
        (NewPrecioBruto10.toFixed(2) / ModalCant10).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida10").value;
      document.getElementById("cantcimp10").innerHTML =
        (NewPrecioNeto10.toFixed(2) / ModalCant10).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida10").value;
    } else {
      document.getElementById("cantsimp10").innerHTML = "";
      document.getElementById("cantcimp10").innerHTML = "";
    }
  } else {
    var totot = new Number(0);
    var Impuesto = new Number(document.getElementById("ModalImpuestos").value);
    var NewMargen = new Number(document.getElementById("ModalMargen").value);
    var NewCostoNeto = new Number(
      document.getElementById("ModalCostoNeto").value,
    );
    var NewPrecioBruto = new Number(
      document.getElementById("ModalPrecioNeto").value,
    );
    var NewCostoBruto = new Number(
      document.getElementById("ModalCostos").value,
    );
    var NewPrecioNeto = new Number(
      document.getElementById("ModalPrecioVenta").value,
    );
    var NewPrecioBruto2 = new Number(
      document.getElementById("ModalPrecioNeto2").value,
    );
    var NewPrecioNeto2 = new Number(
      document.getElementById("ModalPrecioVenta2").value,
    );
    var NewMargen2 = new Number(document.getElementById("ModalMargen2").value);
    var NewPrecioBruto3 = new Number(
      document.getElementById("ModalPrecioNeto3").value,
    );
    var NewPrecioNeto3 = new Number(
      document.getElementById("ModalPrecioVenta3").value,
    );
    var NewMargen3 = new Number(document.getElementById("ModalMargen3").value);
    var NewPrecioBruto4 = new Number(
      document.getElementById("ModalPrecioNeto4").value,
    );
    var NewPrecioNeto4 = new Number(
      document.getElementById("ModalPrecioVenta4").value,
    );
    var NewMargen4 = new Number(document.getElementById("ModalMargen4").value);

    var NewPrecioBruto5 = new Number(
      document.getElementById("ModalPrecioNeto5").value,
    );
    var NewPrecioNeto5 = new Number(
      document.getElementById("ModalPrecioVenta5").value,
    );
    var NewMargen5 = new Number(document.getElementById("ModalMargen5").value);

    var NewPrecioBruto6 = new Number(
      document.getElementById("ModalPrecioNeto6").value,
    );
    var NewPrecioNeto6 = new Number(
      document.getElementById("ModalPrecioVenta6").value,
    );
    var NewMargen6 = new Number(document.getElementById("ModalMargen6").value);

    var NewPrecioBruto7 = new Number(
      document.getElementById("ModalPrecioNeto7").value,
    );
    var NewPrecioNeto7 = new Number(
      document.getElementById("ModalPrecioVenta7").value,
    );
    var NewMargen7 = new Number(document.getElementById("ModalMargen7").value);

    var NewPrecioBruto8 = new Number(
      document.getElementById("ModalPrecioNeto8").value,
    );
    var NewPrecioNeto8 = new Number(
      document.getElementById("ModalPrecioVenta8").value,
    );
    var NewMargen8 = new Number(document.getElementById("ModalMargen8").value);

    var NewPrecioBruto9 = new Number(
      document.getElementById("ModalPrecioNeto9").value,
    );
    var NewPrecioNeto9 = new Number(
      document.getElementById("ModalPrecioVenta9").value,
    );
    var NewMargen9 = new Number(document.getElementById("ModalMargen9").value);

    var NewPrecioBruto10 = new Number(
      document.getElementById("ModalPrecioNeto10").value,
    );
    var NewPrecioNeto10 = new Number(
      document.getElementById("ModalPrecioVenta10").value,
    );
    var NewMargen10 = new Number(
      document.getElementById("ModalMargen10").value,
    );

    var ModalCant2 = new Number(document.getElementById("ModalCant2").value);
    var ModalCant3 = new Number(document.getElementById("ModalCant3").value);
    var ModalCant4 = new Number(document.getElementById("ModalCant4").value);
    var ModalCant5 = new Number(document.getElementById("ModalCant5").value);
    var ModalCant6 = new Number(document.getElementById("ModalCant6").value);
    var ModalCant7 = new Number(document.getElementById("ModalCant7").value);
    var ModalCant8 = new Number(document.getElementById("ModalCant8").value);
    var ModalCant9 = new Number(document.getElementById("ModalCant9").value);
    var ModalCant10 = new Number(document.getElementById("ModalCant10").value);
    var ImpuestoACT = new Number(
      document.getElementById("ValordelImpuesto" + Impuesto).innerHTML,
    );
    var cad = new Number(document.getElementById("CD").innerHTML);
    if (cad > 0) {
      if (form.id == "ModalCant2") {
        if (ModalCant2 < 1 || ModalCant2 == "") ModalCant2 = 1;
      }
      if (form.id == "ModalCant3") {
        if (ModalCant3 < 1 || ModalCant3 == "") ModalCant3 = 1;
      }
      if (form.id == "ModalCant4") {
        if (ModalCant4 < 1 || ModalCant4 == "") ModalCant4 = 1;
      }
      if (form.id == "ModalCant5") {
        if (ModalCant5 < 1 || ModalCant5 == "") ModalCant5 = 1;
      }
      if (form.id == "ModalCant6") {
        if (ModalCant6 < 1 || ModalCant6 == "") ModalCant6 = 1;
      }
      if (form.id == "ModalCant7") {
        if (ModalCant7 < 1 || ModalCant7 == "") ModalCant7 = 1;
      }
      if (form.id == "ModalCant8") {
        if (ModalCant8 < 1 || ModalCant8 == "") ModalCant8 = 1;
      }
      if (form.id == "ModalCant9") {
        if (ModalCant9 < 1 || ModalCant9 == "") ModalCant9 = 1;
      }
      if (form.id == "ModalCant10") {
        if (ModalCant10 < 1 || ModalCant10 == "") ModalCant10 = 1;
      }
      if (form.id == "ModalImpuestos") {
        NewCostoNeto = NewCostoBruto * (1 + ImpuestoACT / 100);
        NewPrecioNeto = NewPrecioBruto * (1 + ImpuestoACT / 100);
        NewPrecioNeto2 = NewPrecioBruto2 * (1 + ImpuestoACT / 100);
        NewPrecioNeto3 = NewPrecioBruto3 * (1 + ImpuestoACT / 100);
        NewPrecioNeto4 = NewPrecioBruto4 * (1 + ImpuestoACT / 100);
        NewPrecioNeto5 = NewPrecioBruto5 * (1 + ImpuestoACT / 100);
        NewPrecioNeto6 = NewPrecioBruto6 * (1 + ImpuestoACT / 100);
        NewPrecioNeto7 = NewPrecioBruto7 * (1 + ImpuestoACT / 100);
        NewPrecioNeto8 = NewPrecioBruto8 * (1 + ImpuestoACT / 100);
        NewPrecioNeto9 = NewPrecioBruto9 * (1 + ImpuestoACT / 100);
        NewPrecioNeto10 = NewPrecioBruto10 * (1 + ImpuestoACT / 100);
      }
      if (form.id == "ModalCostoNeto") {
        if (NewCostoNeto == "") {
          NewCostoBruto = 0;
        }
        if (NewCostoNeto == 0) {
          NewCostoBruto = 0;
        }
        if (NewCostoNeto > 0) {
          NewCostoBruto = NewCostoNeto / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen = 0;
            NewMargen2 = 0;
            NewMargen3 = 0;
            NewMargen4 = 0;
            NewMargen5 = 0;
            NewMargen6 = 0;
            NewMargen7 = 0;
            NewMargen8 = 0;
            NewMargen9 = 0;
            NewMargen10 = 0;
          } else {
            NewPrecioBruto = (NewCostoBruto * NewMargen) / 100 + NewCostoBruto;
            NewPrecioNeto = NewPrecioBruto * (1 + ImpuestoACT / 100);
            if (NewMargen2 > 0) {
              NewPrecioBruto2 =
                (NewCostoBruto * NewMargen2) / 100 + NewCostoBruto;
              NewPrecioNeto2 = NewPrecioBruto2 * (1 + ImpuestoACT / 100);
            }
            if (NewMargen3 > 0) {
              NewPrecioBruto3 =
                (NewCostoBruto * NewMargen3) / 100 + NewCostoBruto;
              NewPrecioNeto3 = NewPrecioBruto3 * (1 + ImpuestoACT / 100);
            }
            if (NewMargen4 > 0) {
              NewPrecioBruto4 =
                (NewCostoBruto * NewMargen4) / 100 + NewCostoBruto;
              NewPrecioNeto4 = NewPrecioBruto4 * (1 + ImpuestoACT / 100);
            }
            if (NewMargen5 > 0) {
              NewPrecioBruto5 =
                (NewCostoBruto * NewMargen5) / 100 + NewCostoBruto;
              NewPrecioNeto5 = NewPrecioBruto5 * (1 + ImpuestoACT / 100);
            }
            if (NewMargen6 > 0) {
              NewPrecioBruto6 =
                (NewCostoBruto * NewMargen6) / 100 + NewCostoBruto;
              NewPrecioNeto6 = NewPrecioBruto6 * (1 + ImpuestoACT / 100);
            }
            if (NewMargen7 > 0) {
              NewPrecioBruto7 =
                (NewCostoBruto * NewMargen7) / 100 + NewCostoBruto;
              NewPrecioNeto7 = NewPrecioBruto7 * (1 + ImpuestoACT / 100);
            }
            if (NewMargen8 > 0) {
              NewPrecioBruto8 =
                (NewCostoBruto * NewMargen8) / 100 + NewCostoBruto;
              NewPrecioNeto8 = NewPrecioBruto8 * (1 + ImpuestoACT / 100);
            }
            if (NewMargen9 > 0) {
              NewPrecioBruto9 =
                (NewCostoBruto * NewMargen9) / 100 + NewCostoBruto;
              NewPrecioNeto9 = NewPrecioBruto9 * (1 + ImpuestoACT / 100);
            }
            if (NewMargen10 > 0) {
              NewPrecioBruto10 =
                (NewCostoBruto * NewMargen10) / 100 + NewCostoBruto;
              NewPrecioNeto10 = NewPrecioBruto10 * (1 + ImpuestoACT / 100);
            }
          }
        }
        if (NewCostoNeto < 0) {
          NewCostoNeto = 0;
        }
      }
      if (form.id == "ModalCostos") {
        if (ModalCostos == "") {
          NewCostoBruto = 0;
          NewCostoNeto = 0;
        }
        if (NewCostoBruto == 0) {
          NewCostoNeto = 0;
        }
        if (NewCostoBruto > 0) {
          NewCostoNeto = NewCostoBruto * (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen = 0;
            NewMargen2 = 0;
            NewMargen3 = 0;
            NewMargen4 = 0;
            NewMargen5 = 0;
            NewMargen6 = 0;
            NewMargen7 = 0;
            NewMargen8 = 0;
            NewMargen9 = 0;
            NewMargen10 = 0;
          } else {
            //    NewMargen = (NewPrecioBruto - NewCostoBruto) * 100 / NewCostoBruto;
            //    NewMargen2 = (NewPrecioBruto - NewCostoBruto) * 100 / NewCostoBruto;
            //W    NewMargen3 = (NewPrecioBruto - NewCostoBruto) * 100 / NewCostoBruto;
            // NewPrecioBruto = NewCostoBruto * NewMargen / 100 + NewCostoBruto;
            // NewPrecioNeto = NewPrecioBruto * (1 + ImpuestoACT / 100);
            if (NewMargen == 0) {
              NewPrecioBruto = NewCostoBruto;
              NewPrecioNeto = NewPrecioBruto * (1 + ImpuestoACT / 100);
            }
            if (NewMargen == "") {
              NewPrecioNeto = NewPrecioBruto * (1 + ImpuestoACT / 100);
            }
            if (NewMargen !== 0) {
              NewPrecioBruto =
                (NewCostoBruto * NewMargen) / 100 + NewCostoBruto;
              NewPrecioNeto = NewPrecioBruto * (1 + ImpuestoACT / 100);
            }

            if (NewMargen2 > 0) {
              if (NewMargen2 == 0) {
                NewPrecioBruto2 = NewCostoBruto;
                NewPrecioNeto2 = NewPrecioBruto2 * (1 + ImpuestoACT / 100);
              }
              if (NewMargen2 == "") {
                NewPrecioNeto2 = NewPrecioBruto2 * (1 + ImpuestoACT / 100);
              }
              if (NewMargen2 !== 0) {
                NewPrecioBruto2 =
                  (NewCostoBruto * NewMargen2) / 100 + NewCostoBruto;
                NewPrecioNeto2 = NewPrecioBruto2 * (1 + ImpuestoACT / 100);
              }
            }
            if (NewMargen3 > 0) {
              if (NewMargen3 == 0) {
                NewPrecioBruto3 = NewCostoBruto;
                NewPrecioNeto3 = NewPrecioBruto3 * (1 + ImpuestoACT / 100);
              }
              if (NewMargen3 == "") {
                NewPrecioNeto3 = NewPrecioBruto3 * (1 + ImpuestoACT / 100);
              }
              if (NewMargen3 !== 0) {
                NewPrecioBruto3 =
                  (NewCostoBruto * NewMargen3) / 100 + NewCostoBruto;
                NewPrecioNeto3 = NewPrecioBruto3 * (1 + ImpuestoACT / 100);
              }
            }
            if (NewMargen4 > 0) {
              if (NewMargen4 == 0) {
                NewPrecioBruto4 = NewCostoBruto;
                NewPrecioNeto4 = NewPrecioBruto4 * (1 + ImpuestoACT / 100);
              }
              if (NewMargen4 == "") {
                NewPrecioNeto4 = NewPrecioBruto4 * (1 + ImpuestoACT / 100);
              }
              if (NewMargen4 !== 0) {
                NewPrecioBruto4 =
                  (NewCostoBruto * NewMargen4) / 100 + NewCostoBruto;
                NewPrecioNeto4 = NewPrecioBruto4 * (1 + ImpuestoACT / 100);
              }
            }
            if (NewMargen5 > 0) {
              if (NewMargen5 == 0) {
                NewPrecioBruto5 = NewCostoBruto;
                NewPrecioNeto5 = NewPrecioBruto5 * (1 + ImpuestoACT / 100);
              }
              if (NewMargen5 == "") {
                NewPrecioNeto5 = NewPrecioBruto5 * (1 + ImpuestoACT / 100);
              }
              if (NewMargen5 !== 0) {
                NewPrecioBruto5 =
                  (NewCostoBruto * NewMargen5) / 100 + NewCostoBruto;
                NewPrecioNeto5 = NewPrecioBruto5 * (1 + ImpuestoACT / 100);
              }
            }
            if (NewMargen6 > 0) {
              if (NewMargen6 == 0) {
                NewPrecioBruto6 = NewCostoBruto;
                NewPrecioNeto6 = NewPrecioBruto6 * (1 + ImpuestoACT / 100);
              }
              if (NewMargen6 == "") {
                NewPrecioNeto6 = NewPrecioBruto6 * (1 + ImpuestoACT / 100);
              }
              if (NewMargen6 !== 0) {
                NewPrecioBruto6 =
                  (NewCostoBruto * NewMargen6) / 100 + NewCostoBruto;
                NewPrecioNeto6 = NewPrecioBruto6 * (1 + ImpuestoACT / 100);
              }
            }
            if (NewMargen7 > 0) {
              if (NewMargen7 == 0) {
                NewPrecioBruto7 = NewCostoBruto;
                NewPrecioNeto7 = NewPrecioBruto7 * (1 + ImpuestoACT / 100);
              }
              if (NewMargen7 == "") {
                NewPrecioNeto7 = NewPrecioBruto7 * (1 + ImpuestoACT / 100);
              }
              if (NewMargen7 !== 0) {
                NewPrecioBruto7 =
                  (NewCostoBruto * NewMargen7) / 100 + NewCostoBruto;
                NewPrecioNeto7 = NewPrecioBruto7 * (1 + ImpuestoACT / 100);
              }
              if (NewMargen8 > 0) {
                if (NewMargen8 == 0) {
                  NewPrecioBruto8 = NewCostoBruto;
                  NewPrecioNeto8 = NewPrecioBruto8 * (1 + ImpuestoACT / 100);
                }
                if (NewMargen8 == "") {
                  NewPrecioNeto8 = NewPrecioBruto8 * (1 + ImpuestoACT / 100);
                }
                if (NewMargen8 !== 0) {
                  NewPrecioBruto8 =
                    (NewCostoBruto * NewMargen8) / 100 + NewCostoBruto;
                  NewPrecioNeto8 = NewPrecioBruto8 * (1 + ImpuestoACT / 100);
                }
              }
              if (NewMargen9 > 0) {
                if (NewMargen9 == 0) {
                  NewPrecioBruto9 = NewCostoBruto;
                  NewPrecioNeto9 = NewPrecioBruto9 * (1 + ImpuestoACT / 100);
                }
                if (NewMargen9 == "") {
                  NewPrecioNeto9 = NewPrecioBruto9 * (1 + ImpuestoACT / 100);
                }
                if (NewMargen9 !== 0) {
                  NewPrecioBruto9 =
                    (NewCostoBruto * NewMargen9) / 100 + NewCostoBruto;
                  NewPrecioNeto9 = NewPrecioBruto9 * (1 + ImpuestoACT / 100);
                }
              }
              if (NewMargen10 > 0) {
                if (NewMargen10 == 0) {
                  NewPrecioBruto10 = NewCostoBruto;
                  NewPrecioNeto10 = NewPrecioBruto10 * (1 + ImpuestoACT / 100);
                }
                if (NewMargen10 == "") {
                  NewPrecioNeto10 = NewPrecioBruto10 * (1 + ImpuestoACT / 100);
                }
                if (NewMargen10 !== 0) {
                  NewPrecioBruto10 =
                    (NewCostoBruto * NewMargen10) / 100 + NewCostoBruto;
                  NewPrecioNeto10 = NewPrecioBruto10 * (1 + ImpuestoACT / 100);
                }
              }
            }
          }
        }
        if (NewCostoBruto < 0) {
          NewCostoNeto = 0;
          NewCostoBruto = 0;
        }
      }
      if (form.id == "ModalMargen") {
        if (NewMargen == 0) {
          NewPrecioBruto = NewCostoBruto;
          NewPrecioNeto = NewPrecioBruto * (1 + ImpuestoACT / 100);
        }
        if (NewMargen == "") {
          NewPrecioNeto = NewPrecioBruto * (1 + ImpuestoACT / 100);
        }
        if (NewMargen !== 0) {
          NewPrecioBruto = (NewCostoBruto * NewMargen) / 100 + NewCostoBruto;
          NewPrecioNeto = NewPrecioBruto * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto") {
        if (NewPrecioBruto == "") {
          NewPrecioNeto = 0;
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto == 0) {
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto = 0;
        }
        if (NewPrecioBruto > 0) {
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto = NewPrecioBruto * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto < 0) {
          NewPrecioBruto = 0;
        }
      }
      if (form.id == "ModalPrecioVenta") {
        if (NewPrecioNeto == "") {
          NewPrecioBruto = 0;
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto == 0) {
          NewPrecioBruto = 0;
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto > 0) {
          NewPrecioBruto = NewPrecioNeto / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto < 0) {
          NewPrecioNeto = 0;
        }
      }
      if (form.id == "ModalMargen2") {
        if (NewMargen2 == 0) {
          NewPrecioBruto2 = NewCostoBruto;
          NewPrecioNeto2 = NewPrecioBruto2 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen2 == "") {
          NewPrecioNeto2 = NewPrecioBruto2 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen2 !== 0) {
          NewPrecioBruto2 = (NewCostoBruto * NewMargen2) / 100 + NewCostoBruto;
          NewPrecioNeto2 = NewPrecioBruto2 * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto2") {
        if (NewPrecioBruto2 == "") {
          NewPrecioNeto2 = 0;
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto2 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto2 = 0;
        }
        if (NewPrecioBruto2 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto2 = NewPrecioBruto2 * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto2 < 0) {
          NewPrecioBruto2 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta2") {
        if (NewPrecioNeto2 == "") {
          NewPrecioBruto2 = 0;
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto2 == 0) {
          NewPrecioBruto2 = 0;
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto2 > 0) {
          NewPrecioBruto2 = NewPrecioNeto2 / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto2 < 0) {
          NewPrecioNeto2 = 0;
        }
      }
      if (form.id == "ModalMargen3") {
        if (NewMargen3 == 0) {
          NewPrecioBruto3 = NewCostoBruto;
          NewPrecioNeto3 = NewPrecioBruto3 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen3 == "") {
          NewPrecioNeto3 = NewPrecioBruto3 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen3 !== 0) {
          NewPrecioBruto3 = (NewCostoBruto * NewMargen3) / 100 + NewCostoBruto;
          NewPrecioNeto3 = NewPrecioBruto3 * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto3") {
        if (NewPrecioBruto3 == "") {
          NewPrecioNeto3 = 0;
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto3 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto3 = 0;
        }
        if (NewPrecioBruto3 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto3 = NewPrecioBruto3 * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto3 < 0) {
          NewPrecioBruto3 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta3") {
        if (NewPrecioNeto3 == "") {
          NewPrecioBruto3 = 0;
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto3 == 0) {
          NewPrecioBruto3 = 0;
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto3 > 0) {
          NewPrecioBruto3 = NewPrecioNeto3 / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto3 < 0) {
          NewPrecioNeto3 = 0;
        }
      }

      if (form.id == "ModalMargen4") {
        if (NewMargen4 == 0) {
          NewPrecioBruto4 = NewCostoBruto;
          NewPrecioNeto4 = NewPrecioBruto4 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen4 == "") {
          NewPrecioNeto4 = NewPrecioBruto4 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen4 !== 0) {
          NewPrecioBruto4 = (NewCostoBruto * NewMargen4) / 100 + NewCostoBruto;
          NewPrecioNeto4 = NewPrecioBruto4 * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto4") {
        if (NewPrecioBruto4 == "") {
          NewPrecioNeto4 = 0;
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto4 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto4 = 0;
        }
        if (NewPrecioBruto4 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto4 = NewPrecioBruto4 * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto4 < 0) {
          NewPrecioBruto4 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta4") {
        if (NewPrecioNeto4 == "") {
          NewPrecioBruto4 = 0;
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto4 == 0) {
          NewPrecioBruto4 = 0;
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto4 > 0) {
          NewPrecioBruto4 = NewPrecioNeto4 / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto4 < 0) {
          NewPrecioNeto4 = 0;
        }
      }

      if (form.id == "ModalMargen5") {
        if (NewMargen5 == 0) {
          NewPrecioBruto5 = NewCostoBruto;
          NewPrecioNeto5 = NewPrecioBruto5 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen5 == "") {
          NewPrecioNeto5 = NewPrecioBruto5 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen5 !== 0) {
          NewPrecioBruto5 = (NewCostoBruto * NewMargen5) / 100 + NewCostoBruto;
          NewPrecioNeto5 = NewPrecioBruto5 * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto5") {
        if (NewPrecioBruto5 == "") {
          NewPrecioNeto5 = 0;
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto5 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto5 = 0;
        }
        if (NewPrecioBruto5 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto5 = NewPrecioBruto5 * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto5 < 0) {
          NewPrecioBruto5 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta5") {
        if (NewPrecioNeto5 == "") {
          NewPrecioBruto5 = 0;
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto5 == 0) {
          NewPrecioBruto5 = 0;
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto5 > 0) {
          NewPrecioBruto5 = NewPrecioNeto5 / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto5 < 0) {
          NewPrecioNeto5 = 0;
        }
      }

      if (form.id == "ModalMargen6") {
        if (NewMargen6 == 0) {
          NewPrecioBruto6 = NewCostoBruto;
          NewPrecioNeto6 = NewPrecioBruto6 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen6 == "") {
          NewPrecioNeto6 = NewPrecioBruto6 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen6 !== 0) {
          NewPrecioBruto6 = (NewCostoBruto * NewMargen6) / 100 + NewCostoBruto;
          NewPrecioNeto6 = NewPrecioBruto6 * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto6") {
        if (NewPrecioBruto6 == "") {
          NewPrecioNeto6 = 0;
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto6 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto6 = 0;
        }
        if (NewPrecioBruto6 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto6 = NewPrecioBruto6 * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto6 < 0) {
          NewPrecioBruto6 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta6") {
        if (NewPrecioNeto6 == "") {
          NewPrecioBruto6 = 0;
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto6 == 0) {
          NewPrecioBruto6 = 0;
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto6 > 0) {
          NewPrecioBruto6 = NewPrecioNeto6 / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto6 < 0) {
          NewPrecioNeto6 = 0;
        }
      }

      if (form.id == "ModalMargen7") {
        if (NewMargen7 == 0) {
          NewPrecioBruto7 = NewCostoBruto;
          NewPrecioNeto7 = NewPrecioBruto7 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen7 == "") {
          NewPrecioNeto7 = NewPrecioBruto7 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen7 !== 0) {
          NewPrecioBruto7 = (NewCostoBruto * NewMargen7) / 100 + NewCostoBruto;
          NewPrecioNeto7 = NewPrecioBruto7 * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto7") {
        if (NewPrecioBruto7 == "") {
          NewPrecioNeto7 = 0;
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto7 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto7 = 0;
        }
        if (NewPrecioBruto7 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto7 = NewPrecioBruto7 * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto7 < 0) {
          NewPrecioBruto7 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta7") {
        if (NewPrecioNeto7 == "") {
          NewPrecioBruto7 = 0;
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto7 == 0) {
          NewPrecioBruto7 = 0;
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto7 > 0) {
          NewPrecioBruto7 = NewPrecioNeto7 / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto7 < 0) {
          NewPrecioNeto7 = 0;
        }
      }

      if (form.id == "ModalMargen8") {
        if (NewMargen8 == 0) {
          NewPrecioBruto8 = NewCostoBruto;
          NewPrecioNeto8 = NewPrecioBruto8 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen8 == "") {
          NewPrecioNeto8 = NewPrecioBruto8 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen8 !== 0) {
          NewPrecioBruto8 = (NewCostoBruto * NewMargen8) / 100 + NewCostoBruto;
          NewPrecioNeto8 = NewPrecioBruto8 * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto8") {
        if (NewPrecioBruto8 == "") {
          NewPrecioNeto8 = 0;
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto8 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto8 = 0;
        }
        if (NewPrecioBruto8 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto8 = NewPrecioBruto8 * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto8 < 0) {
          NewPrecioBruto8 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta8") {
        if (NewPrecioNeto8 == "") {
          NewPrecioBruto8 = 0;
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto8 == 0) {
          NewPrecioBruto8 = 0;
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto8 > 0) {
          NewPrecioBruto8 = NewPrecioNeto8 / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto8 < 0) {
          NewPrecioNeto8 = 0;
        }
      }

      if (form.id == "ModalMargen9") {
        if (NewMargen9 == 0) {
          NewPrecioBruto9 = NewCostoBruto;
          NewPrecioNeto9 = NewPrecioBruto9 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen9 == "") {
          NewPrecioNeto9 = NewPrecioBruto9 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen9 !== 0) {
          NewPrecioBruto9 = (NewCostoBruto * NewMargen9) / 100 + NewCostoBruto;
          NewPrecioNeto9 = NewPrecioBruto9 * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto9") {
        if (NewPrecioBruto9 == "") {
          NewPrecioNeto9 = 0;
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto9 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto9 = 0;
        }
        if (NewPrecioBruto9 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto9 = NewPrecioBruto9 * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto9 < 0) {
          NewPrecioBruto9 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta9") {
        if (NewPrecioNeto9 == "") {
          NewPrecioBruto9 = 0;
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto9 == 0) {
          NewPrecioBruto9 = 0;
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto9 > 0) {
          NewPrecioBruto9 = NewPrecioNeto9 / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto9 < 0) {
          NewPrecioNeto9 = 0;
        }
      }

      if (form.id == "ModalMargen10") {
        if (NewMargen10 == 0) {
          NewPrecioBruto10 = NewCostoBruto;
          NewPrecioNeto10 = NewPrecioBruto10 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen10 == "") {
          NewPrecioNeto10 = NewPrecioBruto10 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen10 !== 0) {
          NewPrecioBruto10 =
            (NewCostoBruto * NewMargen10) / 100 + NewCostoBruto;
          NewPrecioNeto10 = NewPrecioBruto10 * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto10") {
        if (NewPrecioBruto10 == "") {
          NewPrecioNeto10 = 0;
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto10 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto10 = 0;
        }
        if (NewPrecioBruto10 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto10 = NewPrecioBruto10 * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto10 < 0) {
          NewPrecioBruto10 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta10") {
        if (NewPrecioNeto10 == "") {
          NewPrecioBruto10 = 0;
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto10 == 0) {
          NewPrecioBruto10 = 0;
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto10 > 0) {
          NewPrecioBruto10 = NewPrecioNeto10 / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto10 < 0) {
          NewPrecioNeto10 = 0;
        }
      }
    } else {
      if (form.id == "ModalCant2") {
        if (ModalCant2 < 1 || ModalCant2 == "") ModalCant2 = 1;
      }
      if (form.id == "ModalCant3") {
        if (ModalCant3 < 1 || ModalCant3 == "") ModalCant3 = 1;
      }
      if (form.id == "ModalCant4") {
        if (ModalCant4 < 1 || ModalCant4 == "") ModalCant4 = 1;
      }
      if (form.id == "ModalCant5") {
        if (ModalCant5 < 1 || ModalCant5 == "") ModalCant5 = 1;
      }
      if (form.id == "ModalCant6") {
        if (ModalCant6 < 1 || ModalCant6 == "") ModalCant6 = 1;
      }
      if (form.id == "ModalCant7") {
        if (ModalCant7 < 1 || ModalCant7 == "") ModalCant7 = 1;
      }
      if (form.id == "ModalCant8") {
        if (ModalCant8 < 1 || ModalCant8 == "") ModalCant8 = 1;
      }
      if (form.id == "ModalCant9") {
        if (ModalCant9 < 1 || ModalCant9 == "") ModalCant9 = 1;
      }
      if (form.id == "ModalCant10") {
        if (ModalCant10 < 1 || ModalCant10 == "") ModalCant10 = 1;
      }
      if (form.id == "ModalImpuestos") {
        totot = Math.round(NewCostoBruto * 1 * (1 + ImpuestoACT / 100));
        NewCostoNeto = totot / 1;
        totot = Math.round(NewPrecioBruto * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto = totot / 1;
        totot = Math.round(NewPrecioBruto2 * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto2 = totot / 1;
        totot = Math.round(NewPrecioBruto3 * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto3 = totot / 1;
        totot = Math.round(NewPrecioBruto4 * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto4 = totot / 1;
        totot = Math.round(NewPrecioBruto5 * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto5 = totot / 1;
        totot = Math.round(NewPrecioBruto6 * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto6 = totot / 1;
        totot = Math.round(NewPrecioBruto7 * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto7 = totot / 1;
        totot = Math.round(NewPrecioBruto8 * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto8 = totot / 1;
        totot = Math.round(NewPrecioBruto9 * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto9 = totot / 1;
        totot = Math.round(NewPrecioBruto10 * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto10 = totot / 1;
      }
      if (form.id == "ModalCostoNeto") {
        if (NewCostoNeto == "") {
          NewCostoBruto = 0;
        }
        if (NewCostoNeto == 0) {
          NewCostoBruto = 0;
        }
        if (NewCostoNeto > 0) {
          totot = NewCostoNeto * 1;
          NewCostoBruto = Math.round(totot / (1 + ImpuestoACT / 100));
          if (NewCostoBruto == 0) {
            NewMargen = 0;
            NewMargen2 = 0;
            NewMargen3 = 0;
            NewMargen4 = 0;
            NewMargen5 = 0;
            NewMargen6 = 0;
            NewMargen7 = 0;
            NewMargen8 = 0;
            NewMargen9 = 0;
            NewMargen10 = 0;
          } else {
            // NewMargen = (NewPrecioBruto - NewCostoBruto) * 100 / NewCostoBruto;
            //  NewMargen2 = (NewPrecioBruto - NewCostoBruto) * 100 / NewCostoBruto;
            //  NewMargen3 = (NewPrecioBruto - NewCostoBruto) * 100 / NewCostoBruto;
            NewPrecioBruto = (NewCostoBruto * NewMargen) / 100 + NewCostoBruto;
            NewPrecioNeto = Math.round(
              NewPrecioBruto * (1 + ImpuestoACT / 100),
            );
            if (NewMargen2 > 0) {
              NewPrecioBruto2 =
                (NewCostoBruto * NewMargen2) / 100 + NewCostoBruto;
              NewPrecioNeto2 = Math.round(
                NewPrecioBruto2 * (1 + ImpuestoACT / 100),
              );
            }
            if (NewMargen3 > 0) {
              NewPrecioBruto3 =
                (NewCostoBruto * NewMargen3) / 100 + NewCostoBruto;
              NewPrecioNeto3 = Math.round(
                NewPrecioBruto3 * (1 + ImpuestoACT / 100),
              );
            }
            if (NewMargen4 > 0) {
              NewPrecioBruto4 =
                (NewCostoBruto * NewMargen4) / 100 + NewCostoBruto;
              NewPrecioNeto4 = Math.round(
                NewPrecioBruto4 * (1 + ImpuestoACT / 100),
              );
            }

            if (NewMargen5 > 0) {
              NewPrecioBruto5 =
                (NewCostoBruto * NewMargen5) / 100 + NewCostoBruto;
              NewPrecioNeto5 = Math.round(
                NewPrecioBruto5 * (1 + ImpuestoACT / 100),
              );
            }

            if (NewMargen6 > 0) {
              NewPrecioBruto6 =
                (NewCostoBruto * NewMargen6) / 100 + NewCostoBruto;
              NewPrecioNeto6 = Math.round(
                NewPrecioBruto6 * (1 + ImpuestoACT / 100),
              );
            }

            if (NewMargen7 > 0) {
              NewPrecioBruto7 =
                (NewCostoBruto * NewMargen7) / 100 + NewCostoBruto;
              NewPrecioNeto7 = Math.round(
                NewPrecioBruto7 * (1 + ImpuestoACT / 100),
              );
            }

            if (NewMargen8 > 0) {
              NewPrecioBruto8 =
                (NewCostoBruto * NewMargen8) / 100 + NewCostoBruto;
              NewPrecioNeto8 = Math.round(
                NewPrecioBruto8 * (1 + ImpuestoACT / 100),
              );
            }

            if (NewMargen9 > 0) {
              NewPrecioBruto9 =
                (NewCostoBruto * NewMargen9) / 100 + NewCostoBruto;
              NewPrecioNeto9 = Math.round(
                NewPrecioBruto9 * (1 + ImpuestoACT / 100),
              );
            }

            if (NewMargen10 > 0) {
              NewPrecioBruto10 =
                (NewCostoBruto * NewMargen10) / 100 + NewCostoBruto;
              NewPrecioNeto10 = Math.round(
                NewPrecioBruto10 * (1 + ImpuestoACT / 100),
              );
            }
          }
        }
        if (NewCostoNeto < 0) {
          NewCostoNeto = 0;
        }
      }
      if (form.id == "ModalCostos") {
        if (ModalCostos == "") {
          NewCostoBruto = 0;
          NewCostoNeto = 0;
        }
        if (NewCostoBruto == 0) {
          NewCostoNeto = 0;
        }
        if (NewCostoBruto > 0) {
          totot = Math.round(NewCostoBruto * 1 * (1 + ImpuestoACT / 100));
          NewCostoNeto = totot / 1;
          if (NewCostoBruto == 0) {
            NewMargen = 0;
            NewMargen2 = 0;
            NewMargen3 = 0;
            NewMargen4 = 0;
            NewMargen5 = 0;
            NewMargen6 = 0;
            NewMargen7 = 0;
            NewMargen8 = 0;
            NewMargen9 = 0;
            NewMargen10 = 0;
          } else {
            //NewMargen = (NewPrecioBruto - NewCostoBruto) * 100 / NewCostoBruto;
            //NewMargen2 = (NewPrecioBruto - NewCostoBruto) * 100 / NewCostoBruto;
            //NewMargen3 = (NewPrecioBruto - NewCostoBruto) * 100 / NewCostoBruto;
            NewPrecioBruto = (NewCostoBruto * NewMargen) / 100 + NewCostoBruto;
            NewPrecioNeto = Math.round(
              NewPrecioBruto * (1 + ImpuestoACT / 100),
            );
            if (NewMargen2 > 0) {
              NewPrecioBruto2 =
                (NewCostoBruto * NewMargen2) / 100 + NewCostoBruto;
              NewPrecioNeto2 = Math.round(
                NewPrecioBruto2 * (1 + ImpuestoACT / 100),
              );
            }
            if (NewMargen3 > 0) {
              NewPrecioBruto3 =
                (NewCostoBruto * NewMargen3) / 100 + NewCostoBruto;
              NewPrecioNeto3 = Math.round(
                NewPrecioBruto3 * (1 + ImpuestoACT / 100),
              );
            }
            if (NewMargen4 > 0) {
              NewPrecioBruto4 =
                (NewCostoBruto * NewMargen4) / 100 + NewCostoBruto;
              NewPrecioNeto4 = Math.round(
                NewPrecioBruto4 * (1 + ImpuestoACT / 100),
              );
            }
            if (NewMargen5 > 0) {
              NewPrecioBruto5 =
                (NewCostoBruto * NewMargen5) / 100 + NewCostoBruto;
              NewPrecioNeto5 = Math.round(
                NewPrecioBruto5 * (1 + ImpuestoACT / 100),
              );
            }
            if (NewMargen6 > 0) {
              NewPrecioBruto6 =
                (NewCostoBruto * NewMargen6) / 100 + NewCostoBruto;
              NewPrecioNeto6 = Math.round(
                NewPrecioBruto6 * (1 + ImpuestoACT / 100),
              );
            }
            if (NewMargen7 > 0) {
              NewPrecioBruto7 =
                (NewCostoBruto * NewMargen7) / 100 + NewCostoBruto;
              NewPrecioNeto7 = Math.round(
                NewPrecioBruto7 * (1 + ImpuestoACT / 100),
              );
            }
            if (NewMargen8 > 0) {
              NewPrecioBruto8 =
                (NewCostoBruto * NewMargen8) / 100 + NewCostoBruto;
              NewPrecioNeto8 = Math.round(
                NewPrecioBruto8 * (1 + ImpuestoACT / 100),
              );
            }
            if (NewMargen9 > 0) {
              NewPrecioBruto9 =
                (NewCostoBruto * NewMargen9) / 100 + NewCostoBruto;
              NewPrecioNeto9 = Math.round(
                NewPrecioBruto9 * (1 + ImpuestoACT / 100),
              );
            }
            if (NewMargen10 > 0) {
              NewPrecioBruto10 =
                (NewCostoBruto * NewMargen10) / 100 + NewCostoBruto;
              NewPrecioNeto10 = Math.round(
                NewPrecioBruto10 * (1 + ImpuestoACT / 100),
              );
            }
          }
        }
        if (NewCostoBruto < 0) {
          NewCostoNeto = 0;
          NewCostoBruto = 0;
        }
      }
      if (form.id == "ModalMargen") {
        if (NewMargen == 0) {
          NewPrecioBruto = NewCostoBruto;
          NewPrecioNeto = Math.round(NewPrecioBruto * (1 + ImpuestoACT / 100));
        }
        if (NewMargen == "") {
          NewPrecioNeto = Math.round(NewPrecioBruto * (1 + ImpuestoACT / 100));
        }
        if (NewMargen !== 0) {
          NewPrecioBruto = (NewCostoBruto * NewMargen) / 100 + NewCostoBruto;
          NewPrecioNeto = Math.round(NewPrecioBruto * (1 + ImpuestoACT / 100));
        }
      }
      if (form.id == "ModalPrecioNeto") {
        if (NewPrecioBruto == "") {
          NewPrecioNeto = 0;
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto == 0) {
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto = 0;
        }
        if (NewPrecioBruto > 0) {
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto = totot / 1;
        }
        if (NewPrecioBruto < 0) {
          NewPrecioBruto = 0;
        }
      }
      if (form.id == "ModalPrecioVenta") {
        if (NewPrecioNeto == "") {
          NewPrecioBruto = 0;
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto == 0) {
          NewPrecioBruto = 0;
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto > 0) {
          NewPrecioBruto = Math.round(
            (NewPrecioNeto * 1) / (1 + ImpuestoACT / 100),
          );
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto < 0) {
          NewPrecioNeto = 0;
        }
      }
      if (form.id == "ModalMargen2") {
        if (NewMargen2 == 0) {
          NewPrecioBruto2 = NewCostoBruto;
          NewPrecioNeto2 = Math.round(
            NewPrecioBruto2 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen2 == "") {
          NewPrecioNeto2 = Math.round(
            NewPrecioBruto2 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen2 !== 0) {
          NewPrecioBruto2 = (NewCostoBruto * NewMargen2) / 100 + NewCostoBruto;
          NewPrecioNeto2 = Math.round(
            NewPrecioBruto2 * (1 + ImpuestoACT / 100),
          );
        }
      }
      if (form.id == "ModalPrecioNeto2") {
        if (NewPrecioBruto2 == "") {
          NewPrecioNeto2 = 0;
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto2 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto2 = 0;
        }
        if (NewPrecioBruto2 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto2 * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto2 = totot / 1;
        }
        if (NewPrecioBruto2 < 0) {
          NewPrecioBruto2 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta2") {
        if (NewPrecioNeto2 == "") {
          NewPrecioBruto2 = 0;
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto2 == 0) {
          NewPrecioBruto2 = 0;
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto2 > 0) {
          NewPrecioBruto2 = Math.round(
            (NewPrecioNeto2 * 1) / (1 + ImpuestoACT / 100),
          );
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto2 < 0) {
          NewPrecioNeto2 = 0;
        }
      }
      if (form.id == "ModalMargen3") {
        if (NewMargen3 == 0) {
          NewPrecioBruto3 = NewCostoBruto;
          NewPrecioNeto3 = Math.round(
            NewPrecioBruto3 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen3 == "") {
          NewPrecioNeto3 = Math.round(
            NewPrecioBruto3 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen3 !== 0) {
          NewPrecioBruto3 = (NewCostoBruto * NewMargen3) / 100 + NewCostoBruto;
          NewPrecioNeto3 = Math.round(
            NewPrecioBruto3 * (1 + ImpuestoACT / 100),
          );
        }
      }
      if (form.id == "ModalPrecioNeto3") {
        if (NewPrecioBruto3 == "") {
          NewPrecioNeto3 = 0;
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto3 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto3 = 0;
        }
        if (NewPrecioBruto3 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto3 * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto3 = totot / 1;
        }
        if (NewPrecioBruto3 < 0) {
          NewPrecioBruto3 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta3") {
        if (NewPrecioNeto3 == "") {
          NewPrecioBruto3 = 0;
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto3 == 0) {
          NewPrecioBruto3 = 0;
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto3 > 0) {
          totot = Math.round(NewPrecioNeto3 * 1);
          NewPrecioBruto3 = totot / (1 + ImpuestoACT / 100) / 1;
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto3 < 0) {
          NewPrecioNeto3 = 0;
        }
      }

      if (form.id == "ModalMargen4") {
        if (NewMargen4 == 0) {
          NewPrecioBruto4 = NewCostoBruto;
          NewPrecioNeto4 = Math.round(
            NewPrecioBruto4 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen4 == "") {
          NewPrecioNeto4 = Math.round(
            NewPrecioBruto4 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen4 !== 0) {
          NewPrecioBruto4 = (NewCostoBruto * NewMargen4) / 100 + NewCostoBruto;
          NewPrecioNeto4 = Math.round(
            NewPrecioBruto4 * (1 + ImpuestoACT / 100),
          );
        }
      }
      if (form.id == "ModalPrecioNeto4") {
        if (NewPrecioBruto4 == "") {
          NewPrecioNeto4 = 0;
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto4 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto4 = 0;
        }
        if (NewPrecioBruto4 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto4 * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto4 = totot / 1;
        }
        if (NewPrecioBruto4 < 0) {
          NewPrecioBruto4 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta4") {
        if (NewPrecioNeto4 == "") {
          NewPrecioBruto4 = 0;
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto4 == 0) {
          NewPrecioBruto4 = 0;
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto4 > 0) {
          totot = Math.round(NewPrecioNeto4 * 1);
          NewPrecioBruto4 = totot / (1 + ImpuestoACT / 100) / 1;
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto4 < 0) {
          NewPrecioNeto4 = 0;
        }
      }

      if (form.id == "ModalMargen5") {
        if (NewMargen5 == 0) {
          NewPrecioBruto5 = NewCostoBruto;
          NewPrecioNeto5 = Math.round(
            NewPrecioBruto5 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen5 == "") {
          NewPrecioNeto5 = Math.round(
            NewPrecioBruto5 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen5 !== 0) {
          NewPrecioBruto5 = (NewCostoBruto * NewMargen5) / 100 + NewCostoBruto;
          NewPrecioNeto5 = Math.round(
            NewPrecioBruto5 * (1 + ImpuestoACT / 100),
          );
        }
      }
      if (form.id == "ModalPrecioNeto5") {
        if (NewPrecioBruto5 == "") {
          NewPrecioNeto5 = 0;
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto5 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto5 = 0;
        }
        if (NewPrecioBruto5 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto5 * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto5 = totot / 1;
        }
        if (NewPrecioBruto5 < 0) {
          NewPrecioBruto5 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta5") {
        if (NewPrecioNeto5 == "") {
          NewPrecioBruto5 = 0;
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto5 == 0) {
          NewPrecioBruto5 = 0;
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto5 > 0) {
          totot = Math.round(NewPrecioNeto5 * 1);
          NewPrecioBruto5 = totot / (1 + ImpuestoACT / 100) / 1;
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto5 < 0) {
          NewPrecioNeto5 = 0;
        }
      }

      if (form.id == "ModalMargen6") {
        if (NewMargen6 == 0) {
          NewPrecioBruto6 = NewCostoBruto;
          NewPrecioNeto6 = Math.round(
            NewPrecioBruto6 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen6 == "") {
          NewPrecioNeto6 = Math.round(
            NewPrecioBruto6 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen6 !== 0) {
          NewPrecioBruto6 = (NewCostoBruto * NewMargen6) / 100 + NewCostoBruto;
          NewPrecioNeto6 = Math.round(
            NewPrecioBruto6 * (1 + ImpuestoACT / 100),
          );
        }
      }
      if (form.id == "ModalPrecioNeto6") {
        if (NewPrecioBruto6 == "") {
          NewPrecioNeto6 = 0;
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto6 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto6 = 0;
        }
        if (NewPrecioBruto6 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto6 * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto6 = totot / 1;
        }
        if (NewPrecioBruto6 < 0) {
          NewPrecioBruto6 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta6") {
        if (NewPrecioNeto6 == "") {
          NewPrecioBruto6 = 0;
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto6 == 0) {
          NewPrecioBruto6 = 0;
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto6 > 0) {
          totot = Math.round(NewPrecioNeto6 * 1);
          NewPrecioBruto6 = totot / (1 + ImpuestoACT / 100) / 1;
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto6 < 0) {
          NewPrecioNeto6 = 0;
        }
      }

      if (form.id == "ModalMargen7") {
        if (NewMargen7 == 0) {
          NewPrecioBruto7 = NewCostoBruto;
          NewPrecioNeto7 = Math.round(
            NewPrecioBruto7 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen7 == "") {
          NewPrecioNeto7 = Math.round(
            NewPrecioBruto7 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen7 !== 0) {
          NewPrecioBruto7 = (NewCostoBruto * NewMargen7) / 100 + NewCostoBruto;
          NewPrecioNeto7 = Math.round(
            NewPrecioBruto7 * (1 + ImpuestoACT / 100),
          );
        }
      }
      if (form.id == "ModalPrecioNeto7") {
        if (NewPrecioBruto7 == "") {
          NewPrecioNeto7 = 0;
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto7 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto7 = 0;
        }
        if (NewPrecioBruto7 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto7 * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto7 = totot / 1;
        }
        if (NewPrecioBruto7 < 0) {
          NewPrecioBruto7 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta7") {
        if (NewPrecioNeto7 == "") {
          NewPrecioBruto7 = 0;
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto7 == 0) {
          NewPrecioBruto7 = 0;
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto7 > 0) {
          totot = Math.round(NewPrecioNeto7 * 1);
          NewPrecioBruto7 = totot / (1 + ImpuestoACT / 100) / 1;
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto7 < 0) {
          NewPrecioNeto7 = 0;
        }
      }

      if (form.id == "ModalMargen8") {
        if (NewMargen8 == 0) {
          NewPrecioBruto8 = NewCostoBruto;
          NewPrecioNeto8 = Math.round(
            NewPrecioBruto8 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen8 == "") {
          NewPrecioNeto8 = Math.round(
            NewPrecioBruto8 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen8 !== 0) {
          NewPrecioBruto8 = (NewCostoBruto * NewMargen8) / 100 + NewCostoBruto;
          NewPrecioNeto8 = Math.round(
            NewPrecioBruto8 * (1 + ImpuestoACT / 100),
          );
        }
      }
      if (form.id == "ModalPrecioNeto8") {
        if (NewPrecioBruto8 == "") {
          NewPrecioNeto8 = 0;
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto8 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto8 = 0;
        }
        if (NewPrecioBruto8 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto8 * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto8 = totot / 1;
        }
        if (NewPrecioBruto8 < 0) {
          NewPrecioBruto8 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta8") {
        if (NewPrecioNeto8 == "") {
          NewPrecioBruto8 = 0;
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto8 == 0) {
          NewPrecioBruto8 = 0;
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto8 > 0) {
          totot = Math.round(NewPrecioNeto8 * 1);
          NewPrecioBruto8 = totot / (1 + ImpuestoACT / 100) / 1;
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto8 < 0) {
          NewPrecioNeto8 = 0;
        }
      }

      if (form.id == "ModalMargen9") {
        if (NewMargen9 == 0) {
          NewPrecioBruto9 = NewCostoBruto;
          NewPrecioNeto9 = Math.round(
            NewPrecioBruto9 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen9 == "") {
          NewPrecioNeto9 = Math.round(
            NewPrecioBruto9 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen9 !== 0) {
          NewPrecioBruto9 = (NewCostoBruto * NewMargen9) / 100 + NewCostoBruto;
          NewPrecioNeto9 = Math.round(
            NewPrecioBruto9 * (1 + ImpuestoACT / 100),
          );
        }
      }
      if (form.id == "ModalPrecioNeto9") {
        if (NewPrecioBruto9 == "") {
          NewPrecioNeto9 = 0;
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto9 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto9 = 0;
        }
        if (NewPrecioBruto9 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto9 * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto9 = totot / 1;
        }
        if (NewPrecioBruto9 < 0) {
          NewPrecioBruto9 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta9") {
        if (NewPrecioNeto9 == "") {
          NewPrecioBruto9 = 0;
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto9 == 0) {
          NewPrecioBruto9 = 0;
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto9 > 0) {
          totot = Math.round(NewPrecioNeto9 * 1);
          NewPrecioBruto9 = totot / (1 + ImpuestoACT / 100) / 1;
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto9 < 0) {
          NewPrecioNeto9 = 0;
        }
      }

      if (form.id == "ModalMargen10") {
        if (NewMargen10 == 0) {
          NewPrecioBruto10 = NewCostoBruto;
          NewPrecioNeto10 = Math.round(
            NewPrecioBruto10 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen10 == "") {
          NewPrecioNeto10 = Math.round(
            NewPrecioBruto10 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen10 !== 0) {
          NewPrecioBruto10 =
            (NewCostoBruto * NewMargen10) / 100 + NewCostoBruto;
          NewPrecioNeto10 = Math.round(
            NewPrecioBruto10 * (1 + ImpuestoACT / 100),
          );
        }
      }
      if (form.id == "ModalPrecioNeto10") {
        if (NewPrecioBruto10 == "") {
          NewPrecioNeto10 = 0;
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto10 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto10 = 0;
        }
        if (NewPrecioBruto10 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto10 * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto10 = totot / 1;
        }
        if (NewPrecioBruto10 < 0) {
          NewPrecioBruto10 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta10") {
        if (NewPrecioNeto10 == "") {
          NewPrecioBruto10 = 0;
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto10 == 0) {
          NewPrecioBruto10 = 0;
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto10 > 0) {
          totot = Math.round(NewPrecioNeto10 * 1);
          NewPrecioBruto10 = totot / (1 + ImpuestoACT / 100) / 1;
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto10 < 0) {
          NewPrecioNeto10 = 0;
        }
      }
    }
    document.getElementById("ModalCostos").value = NewCostoBruto.toFixed(2);
    document.getElementById("ModalCostoNeto").value = NewCostoNeto.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalMargen").value = NewMargen.toFixed(2);
    document.getElementById("ModalPrecioNeto").value =
      NewPrecioBruto.toFixed(2);
    document.getElementById("ModalPrecioVenta").value = NewPrecioNeto.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalMargen2").value = NewMargen2.toFixed(2);
    document.getElementById("ModalPrecioNeto2").value =
      NewPrecioBruto2.toFixed(2);
    document.getElementById("ModalPrecioVenta2").value = NewPrecioNeto2.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalCant2").value = ModalCant2;
    document.getElementById("ModalMargen3").value = NewMargen3.toFixed(2);
    document.getElementById("ModalPrecioNeto3").value =
      NewPrecioBruto3.toFixed(2);
    document.getElementById("ModalPrecioVenta3").value = NewPrecioNeto3.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalCant3").value = ModalCant3;
    document.getElementById("ModalMargen4").value = NewMargen4.toFixed(2);
    document.getElementById("ModalPrecioNeto4").value =
      NewPrecioBruto4.toFixed(2);
    document.getElementById("ModalPrecioVenta4").value = NewPrecioNeto4.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen5").value = NewMargen5.toFixed(2);
    document.getElementById("ModalPrecioNeto5").value =
      NewPrecioBruto5.toFixed(2);
    document.getElementById("ModalPrecioVenta5").value = NewPrecioNeto5.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen6").value = NewMargen6.toFixed(2);
    document.getElementById("ModalPrecioNeto6").value =
      NewPrecioBruto6.toFixed(2);
    document.getElementById("ModalPrecioVenta6").value = NewPrecioNeto6.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen7").value = NewMargen7.toFixed(2);
    document.getElementById("ModalPrecioNeto7").value =
      NewPrecioBruto7.toFixed(2);
    document.getElementById("ModalPrecioVenta7").value = NewPrecioNeto7.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen8").value = NewMargen8.toFixed(2);
    document.getElementById("ModalPrecioNeto8").value =
      NewPrecioBruto8.toFixed(2);
    document.getElementById("ModalPrecioVenta8").value = NewPrecioNeto8.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen9").value = NewMargen9.toFixed(2);
    document.getElementById("ModalPrecioNeto9").value =
      NewPrecioBruto9.toFixed(2);
    document.getElementById("ModalPrecioVenta9").value = NewPrecioNeto9.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalMargen10").value = NewMargen10.toFixed(2);
    document.getElementById("ModalPrecioNeto10").value =
      NewPrecioBruto10.toFixed(2);
    document.getElementById("ModalPrecioVenta10").value =
      NewPrecioNeto10.toFixed(document.getElementById("CD").innerHTML);

    document.getElementById("ModalCant2").value = ModalCant2;
    document.getElementById("ModalCant3").value = ModalCant3;
    document.getElementById("ModalCant4").value = ModalCant4;
    document.getElementById("ModalCant5").value = ModalCant5;
    document.getElementById("ModalCant6").value = ModalCant6;
    document.getElementById("ModalCant7").value = ModalCant7;
    document.getElementById("ModalCant8").value = ModalCant8;
    document.getElementById("ModalCant9").value = ModalCant9;
    document.getElementById("ModalCant10").value = ModalCant10;
    if (ModalCant2 > 1 && NewPrecioBruto2 > 0) {
      document.getElementById("cantsimp").innerHTML =
        (NewPrecioBruto2.toFixed(2) / ModalCant2).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida2").value;
      document.getElementById("cantcimp").innerHTML =
        (NewPrecioNeto2.toFixed(2) / ModalCant2).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida2").value;
    }
    if (ModalCant3 > 1 && NewPrecioBruto3 > 0) {
      document.getElementById("cantsimp2").innerHTML =
        (NewPrecioBruto3.toFixed(2) / ModalCant3).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida3").value;
      document.getElementById("cantcimp2").innerHTML =
        (NewPrecioNeto3.toFixed(2) / ModalCant3).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida3").value;
    }
    if (ModalCant4 > 1 && NewPrecioBruto4 > 0) {
      document.getElementById("cantsimp4").innerHTML =
        (NewPrecioBruto4.toFixed(2) / ModalCant4).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida4").value;
      document.getElementById("cantcimp4").innerHTML =
        (NewPrecioNeto4.toFixed(2) / ModalCant4).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida4").value;
    }
    if (ModalCant5 > 1 && NewPrecioBruto5 > 0) {
      document.getElementById("cantsimp5").innerHTML =
        (NewPrecioBruto5.toFixed(2) / ModalCant5).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida5").value;
      document.getElementById("cantcimp5").innerHTML =
        (NewPrecioNeto5.toFixed(2) / ModalCant5).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida5").value;
    }

    if (ModalCant6 > 1 && NewPrecioBruto6 > 0) {
      document.getElementById("cantsimp6").innerHTML =
        (NewPrecioBruto6.toFixed(2) / ModalCant6).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida6").value;
      document.getElementById("cantcimp6").innerHTML =
        (NewPrecioNeto6.toFixed(2) / ModalCant6).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida6").value;
    }

    if (ModalCant7 > 1 && NewPrecioBruto7 > 0) {
      document.getElementById("cantsimp7").innerHTML =
        (NewPrecioBruto7.toFixed(2) / ModalCant7).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida7").value;
      document.getElementById("cantcimp7").innerHTML =
        (NewPrecioNeto7.toFixed(2) / ModalCant7).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida7").value;
    }

    if (ModalCant8 > 1 && NewPrecioBruto8 > 0) {
      document.getElementById("cantsimp8").innerHTML =
        (NewPrecioBruto8.toFixed(2) / ModalCant8).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida8").value;
      document.getElementById("cantcimp8").innerHTML =
        (NewPrecioNeto8.toFixed(2) / ModalCant8).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida8").value;
    }

    if (ModalCant9 > 1 && NewPrecioBruto9 > 0) {
      document.getElementById("cantsimp9").innerHTML =
        (NewPrecioBruto9.toFixed(2) / ModalCant9).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida9").value;
      document.getElementById("cantcimp9").innerHTML =
        (NewPrecioNeto9.toFixed(2) / ModalCant9).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida9").value;
    }

    if (ModalCant10 > 1 && NewPrecioBruto10 > 0) {
      document.getElementById("cantsimp10").innerHTML =
        (NewPrecioBruto10.toFixed(2) / ModalCant10).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida10").value;
      document.getElementById("cantcimp10").innerHTML =
        (NewPrecioNeto10.toFixed(2) / ModalCant10).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida10").value;
    }
  }

  if (
    (form.id === "ModalCostoNeto" || form.id === "ModalCostos") &&
    (Number(document.getElementById("ModalCostoNeto").value) > 0 ||
      Number(document.getElementById("ModalCostos").value) > 0)
  ) {
    const PT = Math.abs(
      ((Number(document.getElementById("costoneto" + IdAct).innerHTML) -
        Number(document.getElementById("ModalCostos").value)) /
        Number(document.getElementById("costoneto" + IdAct).innerHTML)) *
        100,
    );
    if (PT > TolCosto) {
      $("#apps-modal").modal("hide");
      $("#modalClose").modal("show");
    }
  }
}

function DeshabilitarButtondS(n) {
  if (n == 1) {
    if (document.getElementById("ModalCodBarraS").value.trim() !== "") {
      $("#ModalButtonCodBarS").prop("disabled", false);
    } else {
      $("#ModalButtonCodBarS").prop("disabled", true);
    }
  }
}

function traetec(n, tip = "") {
  if (n == 1) {
    var cod = document.getElementById("ModalCodIdAmpliado" + tip).value;
  }
  if (n == 2) {
    var cod = document.getElementById("ModalCodBarra" + tip).value;
  }
  $.ajax({
    type: "POST",
    url: "utilidadess.php",
    data: {
      cod: cod,
      Company: document.getElementById("CompanyActual").innerHTML,
      Accion: "sugerircod2",
      modo: n,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    if (msg != "") {
      if (n == 1) {
        document.getElementById("ModalCodIdAmpliado" + tip).value = msg;
      }
      if (n == 2) {
        document.getElementById("ModalCodBarra" + tip).value = msg;
        if (tip == "") {
          DeshabilitarButtond(1);
        } else {
          DeshabilitarButtondS(1);
        }
      }
    } else {
      if (n == 1) {
        document.getElementById("ModalCodIdAmpliado" + tip).value =
          document.getElementById("ModalCodIdAmpliado" + tip).value + "1";
      }
      if (n == 2) {
        document.getElementById("ModalCodBarra" + tip).value =
          document.getElementById("ModalCodBarra" + tip).value + "1";
        if (tip == "") {
          DeshabilitarButtond(1);
        } else {
          DeshabilitarButtondS(1);
        }
      }
    }
  });
}

function barraCodS(cod, typ) {
  var json = document.getElementById("jcodS").value;
  var des = document.getElementById("ModalDescripcionS").value;
  if (cod.trim() !== "") {
    $.ajax({
      type: "POST",
      url: "utilidadess.php",
      data: {
        cod: cod,
        json: json,
        des: des,
        typ: typ,
        Company: document.getElementById("CompanyActual").innerHTML,
        Accion: "Codsbarra",
      },
    }).done(function (msg) {
      if (msg == 1) {
        document.getElementById(
          "alertaerrorenproductoS",
        ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Código_Repetido}</strong><br><small>${Utils2a.Desc17}</small>`;
        $("#alertaerrorenproductoS").delay(100).fadeIn("slow");
        setTimeout(() => OcultarNotificacion2(), 5000);
        document.getElementById("ModalCodBarraS").value = "";
        $("#Costos2S").removeClass("active");
        $("#CostosS").removeClass("show active");
        $("#Inventario2S").removeClass("active");
        $("#InventarioS").removeClass("show active");
        $("#VariacionesS").removeClass("show active");
        $("#Variaciones2S").removeClass("show active");
        $("#Informacion2S").addClass("active");
        $("#InformacionS").addClass("show active");
        $("#ModalCodBarraS").focus();
      } else {
        document.getElementById("barrascodS").innerHTML = msg;
        document.getElementById("ModalCodBarraS").value = "";
        document.getElementById("jcod2S").value =
          document.getElementById("jcodS").value;
      }
    });
  }
}

function elminaresS(cod) {
  var json = document.getElementById("jcodS").value;
  $.ajax({
    type: "POST",
    url: "utilidadess.php",
    data: {
      code: cod,
      json: json,
      des: document.getElementById("ModalDescripcionS").value,
      typ: "S",
      Company: document.getElementById("CompanyActual").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
      Accion: "eliminarcod",
    },
  }).done(function (msg) {
    document.getElementById("barrascodS").innerHTML = msg;
    document.getElementById("jcod2S").value =
      document.getElementById("jcodS").value;
    $("#ModalCodBarraS").focus();
  });
}

function viewtags2() {
  var tagsinputtext = document.getElementById("tagsinputtext").value;
  $.ajax({
    type: "POST",
    url: "productoseek.php",
    data: {
      go: "products-tags-views",
      tagsinputtext: tagsinputtext,
      tagsinput: document.getElementById("tagsinput").value,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    $("#tagsview2").html(msg);
  });
}

function valideKeyS(evt) {
  var code = evt.which ? evt.which : evt.keyCode;
  if (code == 8) {
    return true;
  } else {
    if (code >= 48 && code <= 57) {
      return true;
    } else {
      if (code == 13 || code == 46) {
        return true;
      } else {
        return false;
      }
    }
  }
}

function MaskNumberMoneda3S(form, n) {
  Totalizarmp3S(form);
}

function Totalizarmp3S(form) {
  if (document.getElementById("RecalPrice").innerHTML === "2") {
    var totot = new Number(0);
    var Impuesto = new Number(document.getElementById("ModalImpuestosS").value);
    var NewMargen = new Number(document.getElementById("ModalMargenS").value);
    var NewCostoNeto = new Number(
      document.getElementById("ModalCostoNetoS").value,
    );
    var NewPrecioBruto = new Number(
      document.getElementById("ModalPrecioNetoS").value,
    );
    var NewCostoBruto = new Number(
      document.getElementById("ModalCostosS").value,
    );
    var NewPrecioNeto = new Number(
      document.getElementById("ModalPrecioVentaS").value,
    );
    var NewPrecioBruto2 = new Number(
      document.getElementById("ModalPrecioNeto2S").value,
    );
    var NewPrecioNeto2 = new Number(
      document.getElementById("ModalPrecioVenta2S").value,
    );
    var NewMargen2 = new Number(document.getElementById("ModalMargen2S").value);
    var NewPrecioBruto3 = new Number(
      document.getElementById("ModalPrecioNeto3S").value,
    );
    var NewPrecioNeto3 = new Number(
      document.getElementById("ModalPrecioVenta3S").value,
    );
    var NewMargen3 = new Number(document.getElementById("ModalMargen3S").value);

    var NewPrecioBruto4 = new Number(
      document.getElementById("ModalPrecioNeto4S").value,
    );
    var NewPrecioNeto4 = new Number(
      document.getElementById("ModalPrecioVenta4S").value,
    );
    var NewMargen4 = new Number(document.getElementById("ModalMargen4S").value);

    var NewPrecioBruto5 = new Number(
      document.getElementById("ModalPrecioNeto5S").value,
    );
    var NewPrecioNeto5 = new Number(
      document.getElementById("ModalPrecioVenta5S").value,
    );
    var NewMargen5 = new Number(document.getElementById("ModalMargen5S").value);

    var NewPrecioBruto6 = new Number(
      document.getElementById("ModalPrecioNeto6S").value,
    );
    var NewPrecioNeto6 = new Number(
      document.getElementById("ModalPrecioVenta6S").value,
    );
    var NewMargen6 = new Number(document.getElementById("ModalMargen6S").value);

    var NewPrecioBruto7 = new Number(
      document.getElementById("ModalPrecioNeto7S").value,
    );
    var NewPrecioNeto7 = new Number(
      document.getElementById("ModalPrecioVenta7S").value,
    );
    var NewMargen7 = new Number(document.getElementById("ModalMargen7S").value);

    var NewPrecioBruto8 = new Number(
      document.getElementById("ModalPrecioNeto8S").value,
    );
    var NewPrecioNeto8 = new Number(
      document.getElementById("ModalPrecioVenta8S").value,
    );
    var NewMargen8 = new Number(document.getElementById("ModalMargen8S").value);

    var NewPrecioBruto9 = new Number(
      document.getElementById("ModalPrecioNeto9S").value,
    );
    var NewPrecioNeto9 = new Number(
      document.getElementById("ModalPrecioVenta9S").value,
    );
    var NewMargen9 = new Number(document.getElementById("ModalMargen9S").value);

    var NewPrecioBruto10 = new Number(
      document.getElementById("ModalPrecioNeto10S").value,
    );
    var NewPrecioNeto10 = new Number(
      document.getElementById("ModalPrecioVenta10S").value,
    );
    var NewMargen10 = new Number(
      document.getElementById("ModalMargen10S").value,
    );

    var ModalCant2 = new Number(document.getElementById("ModalCant2S").value);
    var ModalCant3 = new Number(document.getElementById("ModalCant3S").value);
    var ModalCant4 = new Number(document.getElementById("ModalCant4S").value);
    var ModalCant5 = new Number(document.getElementById("ModalCant5S").value);
    var ModalCant6 = new Number(document.getElementById("ModalCant6S").value);
    var ModalCant7 = new Number(document.getElementById("ModalCant7S").value);
    var ModalCant8 = new Number(document.getElementById("ModalCant8S").value);
    var ModalCant9 = new Number(document.getElementById("ModalCant9S").value);
    var ModalCant10 = new Number(document.getElementById("ModalCant10S").value);
    var ImpuestoACT = new Number(
      document.getElementById("ValordelImpuestoS" + Impuesto).innerHTML,
    );
    var cad = new Number(document.getElementById("CD").innerHTML);
    if (cad > 0) {
      if (form.id == "ModalCant2S") {
        if (ModalCant2 < 1) {
          ModalCant2 = 1;
        }
        if (ModalCant2 == "") {
          ModalCant2 = 1;
        }
      }
      if (form.id == "ModalCant3S") {
        if (ModalCant3 < 1) {
          ModalCant3 = 1;
        }
        if (ModalCant3 == "") {
          ModalCant3 = 1;
        }
      }
      if (form.id == "ModalCant4S") {
        if (ModalCant4 < 1) {
          ModalCant4 = 1;
        }
        if (ModalCant4 == "") {
          ModalCant4 = 1;
        }
      }
      if (form.id == "ModalCant5S") {
        if (ModalCant5 < 1 || ModalCant5 == "") ModalCant5 = 1;
      }
      if (form.id == "ModalCant6S") {
        if (ModalCant6 < 1 || ModalCant6 == "") ModalCant6 = 1;
      }
      if (form.id == "ModalCant7S") {
        if (ModalCant7 < 1 || ModalCant7 == "") ModalCant7 = 1;
      }
      if (form.id == "ModalCant8S") {
        if (ModalCant8 < 1 || ModalCant8 == "") ModalCant8 = 1;
      }
      if (form.id == "ModalCant9S") {
        if (ModalCant9 < 1 || ModalCant9 == "") ModalCant9 = 1;
      }
      if (form.id == "ModalCant10S") {
        if (ModalCant10 < 1 || ModalCant10 == "") ModalCant10 = 1;
      }
      if (form.id == "ModalImpuestosS") {
        NewCostoNeto = NewCostoBruto * (1 + ImpuestoACT / 100);
        NewPrecioNeto = NewPrecioBruto * (1 + ImpuestoACT / 100);
        NewPrecioNeto2 = NewPrecioBruto2 * (1 + ImpuestoACT / 100);
        NewPrecioNeto3 = NewPrecioBruto3 * (1 + ImpuestoACT / 100);
        NewPrecioNeto4 = NewPrecioBruto4 * (1 + ImpuestoACT / 100);
        NewPrecioNeto5 = NewPrecioBruto5 * (1 + ImpuestoACT / 100);
        NewPrecioNeto6 = NewPrecioBruto6 * (1 + ImpuestoACT / 100);
        NewPrecioNeto7 = NewPrecioBruto7 * (1 + ImpuestoACT / 100);
        NewPrecioNeto8 = NewPrecioBruto8 * (1 + ImpuestoACT / 100);
        NewPrecioNeto9 = NewPrecioBruto9 * (1 + ImpuestoACT / 100);
        NewPrecioNeto10 = NewPrecioBruto10 * (1 + ImpuestoACT / 100);
      }
      if (form.id == "ModalCostoNetoS") {
        if (NewCostoNeto == "") {
          NewCostoBruto = 0;
        }
        if (NewCostoNeto == 0) {
          NewCostoBruto = 0;
        }
        if (NewCostoNeto > 0) {
          NewCostoBruto = NewCostoNeto / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen = 0;
            NewMargen2 = 0;
            NewMargen3 = 0;
            NewMargen4 = 0;
            NewMargen5 = 0;
            NewMargen6 = 0;
            NewMargen7 = 0;
            NewMargen8 = 0;
            NewMargen9 = 0;
            NewMargen10 = 0;
          } else {
            NewMargen = 0;
            NewMargen2 = 0;
            NewMargen3 = 0;
            NewMargen4 = 0;
            NewMargen5 = 0;
            NewMargen6 = 0;
            NewMargen7 = 0;
            NewMargen8 = 0;
            NewMargen9 = 0;
            NewMargen10 = 0;

            NewPrecioBruto = (NewCostoBruto * NewMargen) / 100 + NewCostoBruto;
            NewPrecioNeto = NewPrecioBruto * (1 + ImpuestoACT / 100);
            if (NewPrecioBruto == "") {
              NewMargen =
                ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
            }
            if (NewPrecioBruto > 0 || NewPrecioBruto < 0) {
              NewMargen =
                ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
            }
            if (NewPrecioBruto2 == "") {
              NewMargen2 =
                ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
            }
            if (NewPrecioBruto2 > 0 || NewPrecioBruto2 < 0) {
              NewMargen2 =
                ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
            }
            if (NewPrecioBruto3 == "") {
              NewMargen3 =
                ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
            }
            if (NewPrecioBruto3 > 0 || NewPrecioBruto3 < 0) {
              NewMargen3 =
                ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
            }

            if (
              NewPrecioBruto4 > 0 ||
              NewPrecioBruto4 < 0 ||
              NewPrecioBruto4 === ""
            ) {
              NewMargen4 =
                ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
            }
            if (
              NewPrecioBruto5 > 0 ||
              NewPrecioBruto5 < 0 ||
              NewPrecioBruto5 === ""
            ) {
              NewMargen5 =
                ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
            }
            if (
              NewPrecioBruto6 > 0 ||
              NewPrecioBruto6 < 0 ||
              NewPrecioBruto6 === ""
            ) {
              NewMargen6 =
                ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
            }
            if (
              NewPrecioBruto7 > 0 ||
              NewPrecioBruto7 < 0 ||
              NewPrecioBruto7 === ""
            ) {
              NewMargen7 =
                ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
            }
            if (
              NewPrecioBruto8 > 0 ||
              NewPrecioBruto8 < 0 ||
              NewPrecioBruto8 === ""
            ) {
              NewMargen8 =
                ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
            }
            if (
              NewPrecioBruto9 > 0 ||
              NewPrecioBruto9 < 0 ||
              NewPrecioBruto9 === ""
            ) {
              NewMargen9 =
                ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
            }
            if (
              NewPrecioBruto10 > 0 ||
              NewPrecioBruto10 < 0 ||
              NewPrecioBruto10 === ""
            ) {
              NewMargen10 =
                ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
            }
          }
        }
        if (NewCostoNeto < 0) {
          NewCostoNeto = 0;
        }
      }
      if (form.id == "ModalCostosS") {
        if (ModalCostos == "") {
          NewCostoBruto = 0;
          NewCostoNeto = 0;
        }
        if (NewCostoBruto == 0) {
          NewCostoNeto = 0;
        }
        if (NewCostoBruto > 0) {
          NewCostoNeto = NewCostoBruto * (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen = 0;
            NewMargen2 = 0;
            NewMargen3 = 0;
            NewMargen4 = 0;
          } else {
            NewMargen = 0;
            NewMargen2 = 0;
            NewMargen3 = 0;
            NewMargen4 = 0;
            if (NewPrecioBruto == "") {
              NewMargen =
                ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
            }
            if (NewPrecioBruto > 0 || NewPrecioBruto < 0) {
              NewMargen =
                ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
            }
            if (NewPrecioBruto2 == "") {
              NewMargen2 =
                ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
            }
            if (NewPrecioBruto2 > 0 || NewPrecioBruto2 < 0) {
              NewMargen2 =
                ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
            }
            if (NewPrecioBruto3 == "") {
              NewMargen3 =
                ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
            }
            if (NewPrecioBruto3 > 0 || NewPrecioBruto3 < 0) {
              NewMargen3 =
                ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
            }
            if (NewPrecioBruto4 == "") {
              NewMargen4 =
                ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
            }
            if (NewPrecioBruto4 > 0 || NewPrecioBruto4 < 0) {
              NewMargen4 =
                ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
            }
          }
        }
        if (NewCostoBruto < 0) {
          NewCostoNeto = 0;
          NewCostoBruto = 0;
        }
      }
      if (form.id == "ModalMargenS") {
        if (NewMargen == 0) {
          NewPrecioBruto = NewCostoBruto;
          NewPrecioNeto = NewPrecioBruto * (1 + ImpuestoACT / 100);
        }
        if (NewMargen == "") {
          NewPrecioNeto = NewPrecioBruto * (1 + ImpuestoACT / 100);
        }
        if (NewMargen !== 0) {
          NewPrecioBruto = (NewCostoBruto * NewMargen) / 100 + NewCostoBruto;
          NewPrecioNeto = NewPrecioBruto * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNetoS") {
        if (NewPrecioBruto == "") {
          NewPrecioNeto = 0;
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto == 0) {
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto = 0;
        }
        if (NewPrecioBruto > 0) {
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto = NewPrecioBruto * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto < 0) {
          NewPrecioBruto = 0;
        }
      }
      if (form.id == "ModalPrecioVentaS") {
        if (NewPrecioNeto == "") {
          NewPrecioBruto = 0;
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto == 0) {
          NewPrecioBruto = 0;
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto > 0) {
          NewPrecioBruto = NewPrecioNeto / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto < 0) {
          NewPrecioNeto = 0;
        }
      }
      if (form.id == "ModalMargen2S") {
        if (NewMargen2 == 0) {
          NewPrecioBruto2 = NewCostoBruto;
          NewPrecioNeto2 = NewPrecioBruto2 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen2 == "") {
          NewPrecioNeto2 = NewPrecioBruto2 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen2 !== 0) {
          NewPrecioBruto2 = (NewCostoBruto * NewMargen2) / 100 + NewCostoBruto;
          NewPrecioNeto2 = NewPrecioBruto2 * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto2S") {
        if (NewPrecioBruto2 == "") {
          NewPrecioNeto2 = 0;
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto2 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto2 = 0;
        }
        if (NewPrecioBruto2 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto2 = NewPrecioBruto2 * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto2 < 0) {
          NewPrecioBruto2 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta2S") {
        if (NewPrecioNeto2 == "") {
          NewPrecioBruto2 = 0;
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto2 == 0) {
          NewPrecioBruto2 = 0;
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto2 > 0) {
          NewPrecioBruto2 = NewPrecioNeto2 / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto2 < 0) {
          NewPrecioNeto2 = 0;
        }
      }
      if (form.id == "ModalMargen3S") {
        if (NewMargen3 == 0) {
          NewPrecioBruto3 = NewCostoBruto;
          NewPrecioNeto3 = NewPrecioBruto3 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen3 == "") {
          NewPrecioNeto3 = NewPrecioBruto3 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen3 !== 0) {
          NewPrecioBruto3 = (NewCostoBruto * NewMargen3) / 100 + NewCostoBruto;
          NewPrecioNeto3 = NewPrecioBruto3 * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto3S") {
        if (NewPrecioBruto3 == "") {
          NewPrecioNeto3 = 0;
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto3 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto3 = 0;
        }
        if (NewPrecioBruto3 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto3 = NewPrecioBruto3 * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto3 < 0) {
          NewPrecioBruto3 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta3S") {
        if (NewPrecioNeto3 == "") {
          NewPrecioBruto3 = 0;
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto3 == 0) {
          NewPrecioBruto3 = 0;
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto3 > 0) {
          NewPrecioBruto3 = NewPrecioNeto3 / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto3 < 0) {
          NewPrecioNeto3 = 0;
        }
      }

      if (form.id == "ModalMargen4S") {
        if (NewMargen4 == 0) {
          NewPrecioBruto4 = NewCostoBruto;
          NewPrecioNeto4 = NewPrecioBruto4 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen4 == "") {
          NewPrecioNeto4 = NewPrecioBruto4 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen4 !== 0) {
          NewPrecioBruto4 = (NewCostoBruto * NewMargen4) / 100 + NewCostoBruto;
          NewPrecioNeto4 = NewPrecioBruto4 * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto4S") {
        if (NewPrecioBruto4 == "") {
          NewPrecioNeto4 = 0;
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto4 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto4 = 0;
        }
        if (NewPrecioBruto4 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto4 = NewPrecioBruto4 * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto4 < 0) {
          NewPrecioBruto4 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta4S") {
        if (NewPrecioNeto4 == "") {
          NewPrecioBruto4 = 0;
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto4 == 0) {
          NewPrecioBruto4 = 0;
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto4 > 0) {
          NewPrecioBruto4 = NewPrecioNeto4 / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto4 < 0) {
          NewPrecioNeto4 = 0;
        }
      }

      if (form.id == "ModalMargen5S") {
        if (NewMargen5 == 0) {
          NewPrecioBruto5 = NewCostoBruto;
          NewPrecioNeto5 = NewPrecioBruto5 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen5 == "") {
          NewPrecioNeto5 = NewPrecioBruto5 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen5 !== 0) {
          NewPrecioBruto5 = (NewCostoBruto * NewMargen5) / 100 + NewCostoBruto;
          NewPrecioNeto5 = NewPrecioBruto5 * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto5S") {
        if (NewPrecioBruto5 == "") {
          NewPrecioNeto5 = 0;
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto5 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto5 = 0;
        }
        if (NewPrecioBruto5 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto5 = NewPrecioBruto5 * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto5 < 0) {
          NewPrecioBruto5 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta5S") {
        if (NewPrecioNeto5 == "") {
          NewPrecioBruto5 = 0;
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto5 == 0) {
          NewPrecioBruto5 = 0;
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto5 > 0) {
          NewPrecioBruto5 = NewPrecioNeto5 / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto5 < 0) {
          NewPrecioNeto5 = 0;
        }
      }

      if (form.id == "ModalMargen6S") {
        if (NewMargen6 == 0) {
          NewPrecioBruto6 = NewCostoBruto;
          NewPrecioNeto6 = NewPrecioBruto6 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen6 == "") {
          NewPrecioNeto6 = NewPrecioBruto6 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen6 !== 0) {
          NewPrecioBruto6 = (NewCostoBruto * NewMargen6) / 100 + NewCostoBruto;
          NewPrecioNeto6 = NewPrecioBruto6 * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto6S") {
        if (NewPrecioBruto6 == "") {
          NewPrecioNeto6 = 0;
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto6 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto6 = 0;
        }
        if (NewPrecioBruto6 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto6 = NewPrecioBruto6 * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto6 < 0) {
          NewPrecioBruto6 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta6S") {
        if (NewPrecioNeto6 == "") {
          NewPrecioBruto6 = 0;
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto6 == 0) {
          NewPrecioBruto6 = 0;
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto6 > 0) {
          NewPrecioBruto6 = NewPrecioNeto6 / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto6 < 0) {
          NewPrecioNeto6 = 0;
        }
      }

      if (form.id == "ModalMargen7S") {
        if (NewMargen7 == 0) {
          NewPrecioBruto7 = NewCostoBruto;
          NewPrecioNeto7 = NewPrecioBruto7 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen7 == "") {
          NewPrecioNeto7 = NewPrecioBruto7 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen7 !== 0) {
          NewPrecioBruto7 = (NewCostoBruto * NewMargen7) / 100 + NewCostoBruto;
          NewPrecioNeto7 = NewPrecioBruto7 * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto7S") {
        if (NewPrecioBruto7 == "") {
          NewPrecioNeto7 = 0;
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto7 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto7 = 0;
        }
        if (NewPrecioBruto7 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto7 = NewPrecioBruto7 * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto7 < 0) {
          NewPrecioBruto7 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta7S") {
        if (NewPrecioNeto7 == "") {
          NewPrecioBruto7 = 0;
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto7 == 0) {
          NewPrecioBruto7 = 0;
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto7 > 0) {
          NewPrecioBruto7 = NewPrecioNeto7 / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto7 < 0) {
          NewPrecioNeto7 = 0;
        }
      }

      if (form.id == "ModalMargen8S") {
        if (NewMargen8 == 0) {
          NewPrecioBruto8 = NewCostoBruto;
          NewPrecioNeto8 = NewPrecioBruto8 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen8 == "") {
          NewPrecioNeto8 = NewPrecioBruto8 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen8 !== 0) {
          NewPrecioBruto8 = (NewCostoBruto * NewMargen8) / 100 + NewCostoBruto;
          NewPrecioNeto8 = NewPrecioBruto8 * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto8S") {
        if (NewPrecioBruto8 == "") {
          NewPrecioNeto8 = 0;
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto8 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto8 = 0;
        }
        if (NewPrecioBruto8 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto8 = NewPrecioBruto8 * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto8 < 0) {
          NewPrecioBruto8 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta8S") {
        if (NewPrecioNeto8 == "") {
          NewPrecioBruto8 = 0;
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto8 == 0) {
          NewPrecioBruto8 = 0;
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto8 > 0) {
          NewPrecioBruto8 = NewPrecioNeto8 / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto8 < 0) {
          NewPrecioNeto8 = 0;
        }
      }

      if (form.id == "ModalMargen9S") {
        if (NewMargen9 == 0) {
          NewPrecioBruto9 = NewCostoBruto;
          NewPrecioNeto9 = NewPrecioBruto9 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen9 == "") {
          NewPrecioNeto9 = NewPrecioBruto9 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen9 !== 0) {
          NewPrecioBruto9 = (NewCostoBruto * NewMargen9) / 100 + NewCostoBruto;
          NewPrecioNeto9 = NewPrecioBruto9 * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto9S") {
        if (NewPrecioBruto9 == "") {
          NewPrecioNeto9 = 0;
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto9 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto9 = 0;
        }
        if (NewPrecioBruto9 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto9 = NewPrecioBruto9 * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto9 < 0) {
          NewPrecioBruto9 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta9S") {
        if (NewPrecioNeto9 == "") {
          NewPrecioBruto9 = 0;
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto9 == 0) {
          NewPrecioBruto9 = 0;
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto9 > 0) {
          NewPrecioBruto9 = NewPrecioNeto9 / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto9 < 0) {
          NewPrecioNeto9 = 0;
        }
      }

      if (form.id == "ModalMargen10S") {
        if (NewMargen10 == 0) {
          NewPrecioBruto10 = NewCostoBruto;
          NewPrecioNeto10 = NewPrecioBruto10 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen10 == "") {
          NewPrecioNeto10 = NewPrecioBruto10 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen10 !== 0) {
          NewPrecioBruto10 =
            (NewCostoBruto * NewMargen10) / 100 + NewCostoBruto;
          NewPrecioNeto10 = NewPrecioBruto10 * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto10S") {
        if (NewPrecioBruto10 == "") {
          NewPrecioNeto10 = 0;
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto10 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto10 = 0;
        }
        if (NewPrecioBruto10 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto10 = NewPrecioBruto10 * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto10 < 0) {
          NewPrecioBruto10 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta10S") {
        if (NewPrecioNeto10 == "") {
          NewPrecioBruto10 = 0;
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto10 == 0) {
          NewPrecioBruto10 = 0;
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto10 > 0) {
          NewPrecioBruto10 = NewPrecioNeto10 / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto10 < 0) {
          NewPrecioNeto10 = 0;
        }
      }
    } else {
      if (form.id == "ModalCant2S") {
        if (ModalCant2 < 1) {
          ModalCant2 = 1;
        }
        if (ModalCant2 == "") {
          ModalCant2 = 1;
        }
      }
      if (form.id == "ModalCant3S") {
        if (ModalCant3 < 1) {
          ModalCant3 = 1;
        }
        if (ModalCant3 == "") {
          ModalCant3 = 1;
        }
      }
      if (form.id == "ModalCant4S") {
        if (ModalCant4 < 1) {
          ModalCant4 = 1;
        }
        if (ModalCant4 == "") {
          ModalCant4 = 1;
        }
      }
      if (form.id == "ModalCant5S") {
        if (ModalCant5 < 1 || ModalCant5 == "") ModalCant5 = 1;
      }
      if (form.id == "ModalCant6S") {
        if (ModalCant6 < 1 || ModalCant6 == "") ModalCant6 = 1;
      }
      if (form.id == "ModalCant7S") {
        if (ModalCant7 < 1 || ModalCant7 == "") ModalCant7 = 1;
      }
      if (form.id == "ModalCant8S") {
        if (ModalCant8 < 1 || ModalCant8 == "") ModalCant8 = 1;
      }
      if (form.id == "ModalCant9S") {
        if (ModalCant9 < 1 || ModalCant9 == "") ModalCant9 = 1;
      }
      if (form.id == "ModalCant10S") {
        if (ModalCant10 < 1 || ModalCant10 == "") ModalCant10 = 1;
      }
      if (form.id == "ModalImpuestosS") {
        totot = Math.round(NewCostoBruto * 1 * (1 + ImpuestoACT / 100));
        NewCostoNeto = totot / 1;
        totot = Math.round(NewPrecioBruto * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto = totot / 1;
        totot = Math.round(NewPrecioBruto2 * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto2 = totot / 1;
        totot = Math.round(NewPrecioBruto3 * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto3 = totot / 1;
        totot = Math.round(NewPrecioBruto4 * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto4 = totot / 1;
        totot = Math.round(NewPrecioBruto5 * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto5 = totot / 1;
        totot = Math.round(NewPrecioBruto6 * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto6 = totot / 1;
        totot = Math.round(NewPrecioBruto7 * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto7 = totot / 1;
        totot = Math.round(NewPrecioBruto8 * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto8 = totot / 1;
        totot = Math.round(NewPrecioBruto9 * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto9 = totot / 1;
        totot = Math.round(NewPrecioBruto10 * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto10 = totot / 1;
      }
      if (form.id == "ModalCostoNetoS") {
        if (NewCostoNeto == "") {
          NewCostoBruto = 0;
        }
        if (NewCostoNeto == 0) {
          NewCostoBruto = 0;
        }
        if (NewCostoNeto > 0) {
          totot = NewCostoNeto * 1;
          NewCostoBruto = Math.round(totot / (1 + ImpuestoACT / 100));
          if (NewCostoBruto == 0) {
            NewMargen = 0;
            NewMargen2 = 0;
            NewMargen3 = 0;
            NewMargen4 = 0;
            NewMargen5 = 0;
            NewMargen6 = 0;
            NewMargen7 = 0;
            NewMargen8 = 0;
            NewMargen9 = 0;
            NewMargen10 = 0;
          } else {
            if (NewPrecioBruto == "") {
              NewMargen =
                ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
            }
            if (NewPrecioBruto > 0 || NewPrecioBruto < 0) {
              NewMargen =
                ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
            }
            if (NewPrecioBruto2 == "") {
              NewMargen2 =
                ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
            }
            if (NewPrecioBruto2 > 0 || NewPrecioBruto2 < 0) {
              NewMargen2 =
                ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
            }
            if (NewPrecioBruto3 == "") {
              NewMargen3 =
                ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
            }
            if (NewPrecioBruto3 > 0 || NewPrecioBruto3 < 0) {
              NewMargen3 =
                ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
            }
            if (NewPrecioBruto4 == "") {
              NewMargen4 =
                ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
            }
            if (NewPrecioBruto4 > 0 || NewPrecioBruto4 < 0) {
              NewMargen4 =
                ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
            }

            if (
              NewPrecioBruto5 > 0 ||
              NewPrecioBruto5 < 0 ||
              NewPrecioBruto5 === ""
            ) {
              NewMargen5 =
                ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
            }
            if (
              NewPrecioBruto6 > 0 ||
              NewPrecioBruto6 < 0 ||
              NewPrecioBruto6 === ""
            ) {
              NewMargen6 =
                ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
            }
            if (
              NewPrecioBruto7 > 0 ||
              NewPrecioBruto7 < 0 ||
              NewPrecioBruto7 === ""
            ) {
              NewMargen7 =
                ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
            }
            if (
              NewPrecioBruto8 > 0 ||
              NewPrecioBruto8 < 0 ||
              NewPrecioBruto8 === ""
            ) {
              NewMargen8 =
                ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
            }
            if (
              NewPrecioBruto9 > 0 ||
              NewPrecioBruto9 < 0 ||
              NewPrecioBruto9 === ""
            ) {
              NewMargen9 =
                ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
            }
            if (
              NewPrecioBruto10 > 0 ||
              NewPrecioBruto10 < 0 ||
              NewPrecioBruto10 === ""
            ) {
              NewMargen10 =
                ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
            }
          }
        }
        if (NewCostoNeto < 0) {
          NewCostoNeto = 0;
        }
      }
      if (form.id == "ModalCostosS") {
        if (ModalCostos == "") {
          NewCostoBruto = 0;
          NewCostoNeto = 0;
        }
        if (NewCostoBruto == 0) {
          NewCostoNeto = 0;
        }
        if (NewCostoBruto > 0) {
          totot = Math.round(NewCostoBruto * 1 * (1 + ImpuestoACT / 100));
          NewCostoNeto = totot / 1;
          if (NewCostoBruto == 0) {
            NewMargen = 0;
            NewMargen2 = 0;
            NewMargen3 = 0;
            NewMargen4 = 0;
          } else {
            if (NewPrecioBruto == "") {
              NewMargen =
                ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
            }
            if (NewPrecioBruto > 0 || NewPrecioBruto < 0) {
              NewMargen =
                ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
            }
            if (NewPrecioBruto2 == "") {
              NewMargen2 =
                ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
            }
            if (NewPrecioBruto2 > 0 || NewPrecioBruto2 < 0) {
              NewMargen2 =
                ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
            }
            if (NewPrecioBruto3 == "") {
              NewMargen3 =
                ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
            }
            if (NewPrecioBruto3 > 0 || NewPrecioBruto3 < 0) {
              NewMargen3 =
                ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
            }
            if (NewPrecioBruto4 == "") {
              NewMargen4 =
                ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
            }
            if (NewPrecioBruto4 > 0 || NewPrecioBruto4 < 0) {
              NewMargen4 =
                ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
            }
          }
        }
        if (NewCostoBruto < 0) {
          NewCostoNeto = 0;
          NewCostoBruto = 0;
        }
      }
      if (form.id == "ModalMargenS") {
        if (NewMargen == 0) {
          NewPrecioBruto = NewCostoBruto;
          NewPrecioNeto = Math.round(NewPrecioBruto * (1 + ImpuestoACT / 100));
        }
        if (NewMargen == "") {
          NewPrecioNeto = Math.round(NewPrecioBruto * (1 + ImpuestoACT / 100));
        }
        if (NewMargen !== 0) {
          NewPrecioBruto = (NewCostoBruto * NewMargen) / 100 + NewCostoBruto;
          NewPrecioNeto = Math.round(NewPrecioBruto * (1 + ImpuestoACT / 100));
        }
      }
      if (form.id == "ModalPrecioNetoS") {
        if (NewPrecioBruto == "") {
          NewPrecioNeto = 0;
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto == 0) {
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto = 0;
        }
        if (NewPrecioBruto > 0) {
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto = totot / 1;
        }
        if (NewPrecioBruto < 0) {
          NewPrecioBruto = 0;
        }
      }
      if (form.id == "ModalPrecioVentaS") {
        if (NewPrecioNeto == "") {
          NewPrecioBruto = 0;
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto == 0) {
          NewPrecioBruto = 0;
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto > 0) {
          NewPrecioBruto = Math.round(
            (NewPrecioNeto * 1) / (1 + ImpuestoACT / 100),
          );
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto < 0) {
          NewPrecioNeto = 0;
        }
      }
      if (form.id == "ModalMargen2S") {
        if (NewMargen2 == 0) {
          NewPrecioBruto2 = NewCostoBruto;
          NewPrecioNeto2 = Math.round(
            NewPrecioBruto2 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen2 == "") {
          NewPrecioNeto2 = Math.round(
            NewPrecioBruto2 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen2 !== 0) {
          NewPrecioBruto2 = (NewCostoBruto * NewMargen2) / 100 + NewCostoBruto;
          NewPrecioNeto2 = Math.round(
            NewPrecioBruto2 * (1 + ImpuestoACT / 100),
          );
        }
      }
      if (form.id == "ModalPrecioNeto2S") {
        if (NewPrecioBruto2 == "") {
          NewPrecioNeto2 = 0;
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto2 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto2 = 0;
        }
        if (NewPrecioBruto2 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto2 * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto2 = totot / 1;
        }
        if (NewPrecioBruto2 < 0) {
          NewPrecioBruto2 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta2S") {
        if (NewPrecioNeto2 == "") {
          NewPrecioBruto2 = 0;
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto2 == 0) {
          NewPrecioBruto2 = 0;
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto2 > 0) {
          NewPrecioBruto2 = Math.round(
            (NewPrecioNeto2 * 1) / (1 + ImpuestoACT / 100),
          );
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto2 < 0) {
          NewPrecioNeto2 = 0;
        }
      }
      if (form.id == "ModalMargen3S") {
        if (NewMargen3 == 0) {
          NewPrecioBruto3 = NewCostoBruto;
          NewPrecioNeto3 = Math.round(
            NewPrecioBruto3 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen3 == "") {
          NewPrecioNeto3 = Math.round(
            NewPrecioBruto3 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen3 !== 0) {
          NewPrecioBruto3 = (NewCostoBruto * NewMargen3) / 100 + NewCostoBruto;
          NewPrecioNeto3 = Math.round(
            NewPrecioBruto3 * (1 + ImpuestoACT / 100),
          );
        }
      }
      if (form.id == "ModalPrecioNeto3S") {
        if (NewPrecioBruto3 == "") {
          NewPrecioNeto3 = 0;
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto3 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto3 = 0;
        }
        if (NewPrecioBruto3 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto3 * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto3 = totot / 1;
        }
        if (NewPrecioBruto3 < 0) {
          NewPrecioBruto3 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta3S") {
        if (NewPrecioNeto3 == "") {
          NewPrecioBruto3 = 0;
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto3 == 0) {
          NewPrecioBruto3 = 0;
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto3 > 0) {
          totot = Math.round(NewPrecioNeto3 * 1);
          NewPrecioBruto3 = totot / (1 + ImpuestoACT / 100) / 1;
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto3 < 0) {
          NewPrecioNeto3 = 0;
        }
      }
      if (form.id == "ModalMargen4S") {
        if (NewMargen4 == 0) {
          NewPrecioBruto4 = NewCostoBruto;
          NewPrecioNeto4 = Math.round(
            NewPrecioBruto4 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen4 == "") {
          NewPrecioNeto4 = Math.round(
            NewPrecioBruto4 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen4 !== 0) {
          NewPrecioBruto4 = (NewCostoBruto * NewMargen4) / 100 + NewCostoBruto;
          NewPrecioNeto4 = Math.round(
            NewPrecioBruto4 * (1 + ImpuestoACT / 100),
          );
        }
      }
      if (form.id == "ModalPrecioNeto4S") {
        if (NewPrecioBruto4 == "") {
          NewPrecioNeto4 = 0;
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto4 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto4 = 0;
        }
        if (NewPrecioBruto4 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto4 * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto4 = totot / 1;
        }
        if (NewPrecioBruto4 < 0) {
          NewPrecioBruto4 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta4S") {
        if (NewPrecioNeto4 == "") {
          NewPrecioBruto4 = 0;
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto4 == 0) {
          NewPrecioBruto4 = 0;
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto4 > 0) {
          totot = Math.round(NewPrecioNeto4 * 1);
          NewPrecioBruto4 = totot / (1 + ImpuestoACT / 100) / 1;
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto4 < 0) {
          NewPrecioNeto4 = 0;
        }
      }

      if (form.id == "ModalMargen5S") {
        if (NewMargen5 == 0) {
          NewPrecioBruto5 = NewCostoBruto;
          NewPrecioNeto5 = Math.round(
            NewPrecioBruto5 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen5 == "") {
          NewPrecioNeto5 = Math.round(
            NewPrecioBruto5 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen5 !== 0) {
          NewPrecioBruto5 = (NewCostoBruto * NewMargen5) / 100 + NewCostoBruto;
          NewPrecioNeto5 = Math.round(
            NewPrecioBruto5 * (1 + ImpuestoACT / 100),
          );
        }
      }
      if (form.id == "ModalPrecioNeto5S") {
        if (NewPrecioBruto5 == "") {
          NewPrecioNeto5 = 0;
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto5 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto5 = 0;
        }
        if (NewPrecioBruto5 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto5 * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto5 = totot / 1;
        }
        if (NewPrecioBruto5 < 0) {
          NewPrecioBruto5 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta5S") {
        if (NewPrecioNeto5 == "") {
          NewPrecioBruto5 = 0;
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto5 == 0) {
          NewPrecioBruto5 = 0;
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto5 > 0) {
          totot = Math.round(NewPrecioNeto5 * 1);
          NewPrecioBruto5 = totot / (1 + ImpuestoACT / 100) / 1;
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto5 < 0) {
          NewPrecioNeto5 = 0;
        }
      }
      if (form.id == "ModalMargen6S") {
        if (NewMargen6 == 0) {
          NewPrecioBruto6 = NewCostoBruto;
          NewPrecioNeto6 = Math.round(
            NewPrecioBruto6 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen6 == "") {
          NewPrecioNeto6 = Math.round(
            NewPrecioBruto6 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen6 !== 0) {
          NewPrecioBruto6 = (NewCostoBruto * NewMargen6) / 100 + NewCostoBruto;
          NewPrecioNeto6 = Math.round(
            NewPrecioBruto6 * (1 + ImpuestoACT / 100),
          );
        }
      }
      if (form.id == "ModalPrecioNeto6S") {
        if (NewPrecioBruto6 == "") {
          NewPrecioNeto6 = 0;
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto6 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto6 = 0;
        }
        if (NewPrecioBruto6 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto6 * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto6 = totot / 1;
        }
        if (NewPrecioBruto6 < 0) {
          NewPrecioBruto6 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta6S") {
        if (NewPrecioNeto6 == "") {
          NewPrecioBruto6 = 0;
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto6 == 0) {
          NewPrecioBruto6 = 0;
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto6 > 0) {
          totot = Math.round(NewPrecioNeto6 * 1);
          NewPrecioBruto6 = totot / (1 + ImpuestoACT / 100) / 1;
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto6 < 0) {
          NewPrecioNeto6 = 0;
        }
      }
      if (form.id == "ModalMargen7S") {
        if (NewMargen7 == 0) {
          NewPrecioBruto7 = NewCostoBruto;
          NewPrecioNeto7 = Math.round(
            NewPrecioBruto7 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen7 == "") {
          NewPrecioNeto7 = Math.round(
            NewPrecioBruto7 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen7 !== 0) {
          NewPrecioBruto7 = (NewCostoBruto * NewMargen7) / 100 + NewCostoBruto;
          NewPrecioNeto7 = Math.round(
            NewPrecioBruto7 * (1 + ImpuestoACT / 100),
          );
        }
      }
      if (form.id == "ModalPrecioNeto7S") {
        if (NewPrecioBruto7 == "") {
          NewPrecioNeto7 = 0;
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto7 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto7 = 0;
        }
        if (NewPrecioBruto7 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto7 * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto7 = totot / 1;
        }
        if (NewPrecioBruto7 < 0) {
          NewPrecioBruto7 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta7S") {
        if (NewPrecioNeto7 == "") {
          NewPrecioBruto7 = 0;
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto7 == 0) {
          NewPrecioBruto7 = 0;
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto7 > 0) {
          totot = Math.round(NewPrecioNeto7 * 1);
          NewPrecioBruto7 = totot / (1 + ImpuestoACT / 100) / 1;
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto7 < 0) {
          NewPrecioNeto7 = 0;
        }
      }
      if (form.id == "ModalMargen8S") {
        if (NewMargen8 == 0) {
          NewPrecioBruto8 = NewCostoBruto;
          NewPrecioNeto8 = Math.round(
            NewPrecioBruto8 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen8 == "") {
          NewPrecioNeto8 = Math.round(
            NewPrecioBruto8 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen8 !== 0) {
          NewPrecioBruto8 = (NewCostoBruto * NewMargen8) / 100 + NewCostoBruto;
          NewPrecioNeto8 = Math.round(
            NewPrecioBruto8 * (1 + ImpuestoACT / 100),
          );
        }
      }
      if (form.id == "ModalPrecioNeto8S") {
        if (NewPrecioBruto8 == "") {
          NewPrecioNeto8 = 0;
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto8 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto8 = 0;
        }
        if (NewPrecioBruto8 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto8 * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto8 = totot / 1;
        }
        if (NewPrecioBruto8 < 0) {
          NewPrecioBruto8 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta8S") {
        if (NewPrecioNeto8 == "") {
          NewPrecioBruto8 = 0;
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto8 == 0) {
          NewPrecioBruto8 = 0;
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto8 > 0) {
          totot = Math.round(NewPrecioNeto8 * 1);
          NewPrecioBruto8 = totot / (1 + ImpuestoACT / 100) / 1;
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto8 < 0) {
          NewPrecioNeto8 = 0;
        }
      }
      if (form.id == "ModalMargen9S") {
        if (NewMargen9 == 0) {
          NewPrecioBruto9 = NewCostoBruto;
          NewPrecioNeto9 = Math.round(
            NewPrecioBruto9 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen9 == "") {
          NewPrecioNeto9 = Math.round(
            NewPrecioBruto9 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen9 !== 0) {
          NewPrecioBruto9 = (NewCostoBruto * NewMargen9) / 100 + NewCostoBruto;
          NewPrecioNeto9 = Math.round(
            NewPrecioBruto9 * (1 + ImpuestoACT / 100),
          );
        }
      }
      if (form.id == "ModalPrecioNeto9S") {
        if (NewPrecioBruto9 == "") {
          NewPrecioNeto9 = 0;
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto9 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto9 = 0;
        }
        if (NewPrecioBruto9 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto9 * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto9 = totot / 1;
        }
        if (NewPrecioBruto9 < 0) {
          NewPrecioBruto9 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta9S") {
        if (NewPrecioNeto9 == "") {
          NewPrecioBruto9 = 0;
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto9 == 0) {
          NewPrecioBruto9 = 0;
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto9 > 0) {
          totot = Math.round(NewPrecioNeto9 * 1);
          NewPrecioBruto9 = totot / (1 + ImpuestoACT / 100) / 1;
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto9 < 0) {
          NewPrecioNeto9 = 0;
        }
      }
      if (form.id == "ModalMargen10S") {
        if (NewMargen10 == 0) {
          NewPrecioBruto10 = NewCostoBruto;
          NewPrecioNeto10 = Math.round(
            NewPrecioBruto10 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen10 == "") {
          NewPrecioNeto10 = Math.round(
            NewPrecioBruto10 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen10 !== 0) {
          NewPrecioBruto10 =
            (NewCostoBruto * NewMargen10) / 100 + NewCostoBruto;
          NewPrecioNeto10 = Math.round(
            NewPrecioBruto10 * (1 + ImpuestoACT / 100),
          );
        }
      }
      if (form.id == "ModalPrecioNeto10S") {
        if (NewPrecioBruto10 == "") {
          NewPrecioNeto10 = 0;
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto10 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto10 = 0;
        }
        if (NewPrecioBruto10 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto10 * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto10 = totot / 1;
        }
        if (NewPrecioBruto10 < 0) {
          NewPrecioBruto10 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta10S") {
        if (NewPrecioNeto10 == "") {
          NewPrecioBruto10 = 0;
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto10 == 0) {
          NewPrecioBruto10 = 0;
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto10 > 0) {
          totot = Math.round(NewPrecioNeto10 * 1);
          NewPrecioBruto10 = totot / (1 + ImpuestoACT / 100) / 1;
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto10 < 0) {
          NewPrecioNeto10 = 0;
        }
      }
    }
    document.getElementById("ModalCostosS").value = NewCostoBruto.toFixed(2);
    document.getElementById("ModalCostoNetoS").value = NewCostoNeto.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalMargenS").value = NewMargen.toFixed(2);
    document.getElementById("ModalPrecioNetoS").value =
      NewPrecioBruto.toFixed(2);
    document.getElementById("ModalPrecioVentaS").value = NewPrecioNeto.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalMargen2S").value = NewMargen2.toFixed(2);
    document.getElementById("ModalPrecioNeto2S").value =
      NewPrecioBruto2.toFixed(2);
    document.getElementById("ModalPrecioVenta2S").value =
      NewPrecioNeto2.toFixed(document.getElementById("CD").innerHTML);
    document.getElementById("ModalMargen3S").value = NewMargen3.toFixed(2);
    document.getElementById("ModalPrecioNeto3S").value =
      NewPrecioBruto3.toFixed(2);
    document.getElementById("ModalPrecioVenta3S").value =
      NewPrecioNeto3.toFixed(document.getElementById("CD").innerHTML);
    document.getElementById("ModalMargen4S").value = NewMargen4.toFixed(2);
    document.getElementById("ModalPrecioNeto4S").value =
      NewPrecioBruto4.toFixed(2);
    document.getElementById("ModalPrecioVenta4S").value =
      NewPrecioNeto4.toFixed(document.getElementById("CD").innerHTML);

    document.getElementById("ModalMargen5S").value = NewMargen5.toFixed(2);
    document.getElementById("ModalPrecioNeto5S").value =
      NewPrecioBruto5.toFixed(2);
    document.getElementById("ModalPrecioVenta5S").value =
      NewPrecioNeto5.toFixed(document.getElementById("CD").innerHTML);

    document.getElementById("ModalMargen6S").value = NewMargen6.toFixed(2);
    document.getElementById("ModalPrecioNeto6S").value =
      NewPrecioBruto6.toFixed(2);
    document.getElementById("ModalPrecioVenta6S").value =
      NewPrecioNeto6.toFixed(document.getElementById("CD").innerHTML);

    document.getElementById("ModalMargen7S").value = NewMargen7.toFixed(2);
    document.getElementById("ModalPrecioNeto7S").value =
      NewPrecioBruto7.toFixed(2);
    document.getElementById("ModalPrecioVenta7S").value =
      NewPrecioNeto7.toFixed(document.getElementById("CD").innerHTML);

    document.getElementById("ModalMargen8S").value = NewMargen8.toFixed(2);
    document.getElementById("ModalPrecioNeto8S").value =
      NewPrecioBruto8.toFixed(2);
    document.getElementById("ModalPrecioVenta8S").value =
      NewPrecioNeto8.toFixed(document.getElementById("CD").innerHTML);

    document.getElementById("ModalMargen9S").value = NewMargen9.toFixed(2);
    document.getElementById("ModalPrecioNeto9S").value =
      NewPrecioBruto9.toFixed(2);
    document.getElementById("ModalPrecioVenta9S").value =
      NewPrecioNeto9.toFixed(document.getElementById("CD").innerHTML);

    document.getElementById("ModalMargen10S").value = NewMargen10.toFixed(2);
    document.getElementById("ModalPrecioNeto10S").value =
      NewPrecioBruto10.toFixed(2);
    document.getElementById("ModalPrecioVenta10S").value =
      NewPrecioNeto10.toFixed(document.getElementById("CD").innerHTML);

    document.getElementById("ModalCant2S").value = ModalCant2;
    document.getElementById("ModalCant3S").value = ModalCant3;
    document.getElementById("ModalCant4S").value = ModalCant4;
    document.getElementById("ModalCant5S").value = ModalCant5;
    document.getElementById("ModalCant6S").value = ModalCant6;
    document.getElementById("ModalCant7S").value = ModalCant7;
    document.getElementById("ModalCant8S").value = ModalCant8;
    document.getElementById("ModalCant9S").value = ModalCant9;
    document.getElementById("ModalCant10S").value = ModalCant10;
    if (ModalCant2 > 1 && NewPrecioBruto2 > 0) {
      document.getElementById("cantsimpS").innerHTML =
        (NewPrecioBruto2.toFixed(2) / ModalCant2).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida2S").value;
      document.getElementById("cantcimpS").innerHTML =
        (NewPrecioNeto2.toFixed(2) / ModalCant2).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida2S").value;
    }
    if (ModalCant3 > 1 && NewPrecioBruto3 > 0) {
      document.getElementById("cantsimp2S").innerHTML =
        (NewPrecioBruto3.toFixed(2) / ModalCant3).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida3S").value;
      document.getElementById("cantcimp2S").innerHTML =
        (NewPrecioNeto3.toFixed(2) / ModalCant3).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida3S").value;
    }
    if (ModalCant4 > 1 && NewPrecioBruto4 > 0) {
      document.getElementById("cantsimp4S").innerHTML =
        (NewPrecioBruto4.toFixed(2) / ModalCant4).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida4S").value;
      document.getElementById("cantcimp4S").innerHTML =
        (NewPrecioNeto4.toFixed(2) / ModalCant4).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida4S").value;
    }
    if (ModalCant5 > 1 && NewPrecioBruto5 > 0) {
      document.getElementById("cantsimp5S").innerHTML =
        (NewPrecioBruto5.toFixed(2) / ModalCant5).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida5S").value;
      document.getElementById("cantcimp5S").innerHTML =
        (NewPrecioNeto5.toFixed(2) / ModalCant5).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida5S").value;
    }
    if (ModalCant6 > 1 && NewPrecioBruto6 > 0) {
      document.getElementById("cantsimp6S").innerHTML =
        (NewPrecioBruto6.toFixed(2) / ModalCant6).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida6S").value;
      document.getElementById("cantcimp6S").innerHTML =
        (NewPrecioNeto6.toFixed(2) / ModalCant6).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida6S").value;
    }
    if (ModalCant7 > 1 && NewPrecioBruto7 > 0) {
      document.getElementById("cantsimp7S").innerHTML =
        (NewPrecioBruto7.toFixed(2) / ModalCant7).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida7S").value;
      document.getElementById("cantcimp7S").innerHTML =
        (NewPrecioNeto7.toFixed(2) / ModalCant7).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida7S").value;
    }
    if (ModalCant8 > 1 && NewPrecioBruto8 > 0) {
      document.getElementById("cantsimp8S").innerHTML =
        (NewPrecioBruto8.toFixed(2) / ModalCant8).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida8S").value;
      document.getElementById("cantcimp8S").innerHTML =
        (NewPrecioNeto8.toFixed(2) / ModalCant8).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida8S").value;
    }
    if (ModalCant9 > 1 && NewPrecioBruto9 > 0) {
      document.getElementById("cantsimp9S").innerHTML =
        (NewPrecioBruto9.toFixed(2) / ModalCant9).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida9S").value;
      document.getElementById("cantcimp9S").innerHTML =
        (NewPrecioNeto9.toFixed(2) / ModalCant9).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida9S").value;
    }
    if (ModalCant10 > 1 && NewPrecioBruto10 > 0) {
      document.getElementById("cantsimp10S").innerHTML =
        (NewPrecioBruto10.toFixed(2) / ModalCant10).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida10S").value;
      document.getElementById("cantcimp10S").innerHTML =
        (NewPrecioNeto10.toFixed(2) / ModalCant10).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida10S").value;
    }
  } else {
    var totot = new Number(0);
    var Impuesto = new Number(document.getElementById("ModalImpuestosS").value);
    var NewMargen = new Number(document.getElementById("ModalMargenS").value);
    var NewCostoNeto = new Number(
      document.getElementById("ModalCostoNetoS").value,
    );
    var NewPrecioBruto = new Number(
      document.getElementById("ModalPrecioNetoS").value,
    );
    var NewCostoBruto = new Number(
      document.getElementById("ModalCostosS").value,
    );
    var NewPrecioNeto = new Number(
      document.getElementById("ModalPrecioVentaS").value,
    );
    var NewPrecioBruto2 = new Number(
      document.getElementById("ModalPrecioNeto2S").value,
    );
    var NewPrecioNeto2 = new Number(
      document.getElementById("ModalPrecioVenta2S").value,
    );
    var NewMargen2 = new Number(document.getElementById("ModalMargen2S").value);
    var NewPrecioBruto3 = new Number(
      document.getElementById("ModalPrecioNeto3S").value,
    );
    var NewPrecioNeto3 = new Number(
      document.getElementById("ModalPrecioVenta3S").value,
    );
    var NewMargen3 = new Number(document.getElementById("ModalMargen3S").value);
    var NewPrecioBruto4 = new Number(
      document.getElementById("ModalPrecioNeto4S").value,
    );
    var NewPrecioNeto4 = new Number(
      document.getElementById("ModalPrecioVenta4S").value,
    );
    var NewMargen4 = new Number(document.getElementById("ModalMargen4S").value);

    var NewPrecioBruto5 = new Number(
      document.getElementById("ModalPrecioNeto5S").value,
    );
    var NewPrecioNeto5 = new Number(
      document.getElementById("ModalPrecioVenta5S").value,
    );
    var NewMargen5 = new Number(document.getElementById("ModalMargen5S").value);
    var NewPrecioBruto6 = new Number(
      document.getElementById("ModalPrecioNeto6S").value,
    );
    var NewPrecioNeto6 = new Number(
      document.getElementById("ModalPrecioVenta6S").value,
    );
    var NewMargen6 = new Number(document.getElementById("ModalMargen6S").value);
    var NewPrecioBruto7 = new Number(
      document.getElementById("ModalPrecioNeto7S").value,
    );
    var NewPrecioNeto7 = new Number(
      document.getElementById("ModalPrecioVenta7S").value,
    );
    var NewMargen7 = new Number(document.getElementById("ModalMargen7S").value);
    var NewPrecioBruto8 = new Number(
      document.getElementById("ModalPrecioNeto8S").value,
    );
    var NewPrecioNeto8 = new Number(
      document.getElementById("ModalPrecioVenta8S").value,
    );
    var NewMargen8 = new Number(document.getElementById("ModalMargen8S").value);
    var NewPrecioBruto9 = new Number(
      document.getElementById("ModalPrecioNeto9S").value,
    );
    var NewPrecioNeto9 = new Number(
      document.getElementById("ModalPrecioVenta9S").value,
    );
    var NewMargen9 = new Number(document.getElementById("ModalMargen9S").value);

    var NewPrecioBruto10 = new Number(
      document.getElementById("ModalPrecioNeto10S").value,
    );
    var NewPrecioNeto10 = new Number(
      document.getElementById("ModalPrecioVenta10S").value,
    );
    var NewMargen10 = new Number(
      document.getElementById("ModalMargen10S").value,
    );

    var ModalCant2 = new Number(document.getElementById("ModalCant2S").value);
    var ModalCant3 = new Number(document.getElementById("ModalCant3S").value);
    var ModalCant4 = new Number(document.getElementById("ModalCant4S").value);
    var ModalCant5 = new Number(document.getElementById("ModalCant5S").value);
    var ModalCant6 = new Number(document.getElementById("ModalCant6S").value);
    var ModalCant7 = new Number(document.getElementById("ModalCant7S").value);
    var ModalCant8 = new Number(document.getElementById("ModalCant8S").value);
    var ModalCant9 = new Number(document.getElementById("ModalCant9S").value);
    var ModalCant10 = new Number(document.getElementById("ModalCant10S").value);
    var ImpuestoACT = new Number(
      document.getElementById("ValordelImpuesto" + Impuesto).innerHTML,
    );
    var cad = new Number(document.getElementById("CD").innerHTML);
    if (cad > 0) {
      if (form.id == "ModalCant2S") {
        if (ModalCant2 < 1) {
          ModalCant2 = 1;
        }
        if (ModalCant2 == "") {
          ModalCant2 = 1;
        }
      }
      if (form.id == "ModalCant3S") {
        if (ModalCant3 < 1) {
          ModalCant3 = 1;
        }
        if (ModalCant3 == "") {
          ModalCant3 = 1;
        }
      }
      if (form.id == "ModalCant4S") {
        if (ModalCant4 < 1) {
          ModalCant4 = 1;
        }
        if (ModalCant4 == "") {
          ModalCant4 = 1;
        }
      }
      if (form.id == "ModalCant5S") {
        if (ModalCant5 < 1 || ModalCant5 == "") ModalCant5 = 1;
      }
      if (form.id == "ModalCant6S") {
        if (ModalCant6 < 1 || ModalCant6 == "") ModalCant6 = 1;
      }
      if (form.id == "ModalCant7S") {
        if (ModalCant7 < 1 || ModalCant7 == "") ModalCant7 = 1;
      }
      if (form.id == "ModalCant8S") {
        if (ModalCant8 < 1 || ModalCant8 == "") ModalCant8 = 1;
      }
      if (form.id == "ModalCant9S") {
        if (ModalCant9 < 1 || ModalCant9 == "") ModalCant9 = 1;
      }
      if (form.id == "ModalCant10S") {
        if (ModalCant10 < 1 || ModalCant10 == "") ModalCant10 = 1;
      }
      if (form.id == "ModalImpuestosS") {
        NewCostoNeto = NewCostoBruto * (1 + ImpuestoACT / 100);
        NewPrecioNeto = NewPrecioBruto * (1 + ImpuestoACT / 100);
        NewPrecioNeto2 = NewPrecioBruto2 * (1 + ImpuestoACT / 100);
        NewPrecioNeto3 = NewPrecioBruto3 * (1 + ImpuestoACT / 100);
        NewPrecioNeto4 = NewPrecioBruto4 * (1 + ImpuestoACT / 100);
        NewPrecioNeto5 = NewPrecioBruto5 * (1 + ImpuestoACT / 100);
        NewPrecioNeto6 = NewPrecioBruto6 * (1 + ImpuestoACT / 100);
        NewPrecioNeto7 = NewPrecioBruto7 * (1 + ImpuestoACT / 100);
        NewPrecioNeto8 = NewPrecioBruto8 * (1 + ImpuestoACT / 100);
        NewPrecioNeto9 = NewPrecioBruto9 * (1 + ImpuestoACT / 100);
        NewPrecioNeto10 = NewPrecioBruto10 * (1 + ImpuestoACT / 100);
      }
      if (form.id == "ModalCostoNetoS") {
        if (NewCostoNeto == "") {
          NewCostoBruto = 0;
        }
        if (NewCostoNeto == 0) {
          NewCostoBruto = 0;
        }
        if (NewCostoNeto > 0) {
          NewCostoBruto = NewCostoNeto / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen = 0;
            NewMargen2 = 0;
            NewMargen3 = 0;
            NewMargen4 = 0;
          } else {
            NewPrecioBruto = (NewCostoBruto * NewMargen) / 100 + NewCostoBruto;
            NewPrecioNeto = NewPrecioBruto * (1 + ImpuestoACT / 100);
            if (NewMargen2 > 0) {
              NewPrecioBruto2 =
                (NewCostoBruto * NewMargen2) / 100 + NewCostoBruto;
              NewPrecioNeto2 = NewPrecioBruto2 * (1 + ImpuestoACT / 100);
            }
            if (NewMargen3 > 0) {
              NewPrecioBruto3 =
                (NewCostoBruto * NewMargen3) / 100 + NewCostoBruto;
              NewPrecioNeto3 = NewPrecioBruto3 * (1 + ImpuestoACT / 100);
            }
            if (NewMargen4 > 0) {
              NewPrecioBruto4 =
                (NewCostoBruto * NewMargen4) / 100 + NewCostoBruto;
              NewPrecioNeto4 = NewPrecioBruto4 * (1 + ImpuestoACT / 100);
            }
          }
        }
        if (NewCostoNeto < 0) {
          NewCostoNeto = 0;
        }
      }
      if (form.id == "ModalCostosS") {
        if (ModalCostos == "") {
          NewCostoBruto = 0;
          NewCostoNeto = 0;
        }
        if (NewCostoBruto == 0) {
          NewCostoNeto = 0;
        }
        if (NewCostoBruto > 0) {
          NewCostoNeto = NewCostoBruto * (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen = 0;
            NewMargen2 = 0;
            NewMargen3 = 0;
            NewMargen4 = 0;
          } else {
            if (NewMargen == 0) {
              NewPrecioBruto = NewCostoBruto;
              NewPrecioNeto = NewPrecioBruto * (1 + ImpuestoACT / 100);
            }
            if (NewMargen == "") {
              NewPrecioNeto = NewPrecioBruto * (1 + ImpuestoACT / 100);
            }
            if (NewMargen !== 0) {
              NewPrecioBruto =
                (NewCostoBruto * NewMargen) / 100 + NewCostoBruto;
              NewPrecioNeto = NewPrecioBruto * (1 + ImpuestoACT / 100);
            }

            if (NewMargen2 > 0) {
              if (NewMargen2 == 0) {
                NewPrecioBruto2 = NewCostoBruto;
                NewPrecioNeto2 = NewPrecioBruto2 * (1 + ImpuestoACT / 100);
              }
              if (NewMargen2 == "") {
                NewPrecioNeto2 = NewPrecioBruto2 * (1 + ImpuestoACT / 100);
              }
              if (NewMargen2 !== 0) {
                NewPrecioBruto2 =
                  (NewCostoBruto * NewMargen2) / 100 + NewCostoBruto;
                NewPrecioNeto2 = NewPrecioBruto2 * (1 + ImpuestoACT / 100);
              }
            }
            if (NewMargen3 > 0) {
              if (NewMargen3 == 0) {
                NewPrecioBruto3 = NewCostoBruto;
                NewPrecioNeto3 = NewPrecioBruto3 * (1 + ImpuestoACT / 100);
              }
              if (NewMargen3 == "") {
                NewPrecioNeto3 = NewPrecioBruto3 * (1 + ImpuestoACT / 100);
              }
              if (NewMargen3 !== 0) {
                NewPrecioBruto3 =
                  (NewCostoBruto * NewMargen3) / 100 + NewCostoBruto;
                NewPrecioNeto3 = NewPrecioBruto3 * (1 + ImpuestoACT / 100);
              }
            }
            if (NewMargen4 > 0) {
              if (NewMargen4 == 0) {
                NewPrecioBruto4 = NewCostoBruto;
                NewPrecioNeto4 = NewPrecioBruto4 * (1 + ImpuestoACT / 100);
              }
              if (NewMargen4 == "") {
                NewPrecioNeto4 = NewPrecioBruto4 * (1 + ImpuestoACT / 100);
              }
              if (NewMargen4 !== 0) {
                NewPrecioBruto4 =
                  (NewCostoBruto * NewMargen4) / 100 + NewCostoBruto;
                NewPrecioNeto4 = NewPrecioBruto4 * (1 + ImpuestoACT / 100);
              }
            }
          }
        }
        if (NewCostoBruto < 0) {
          NewCostoNeto = 0;
          NewCostoBruto = 0;
        }
      }
      if (form.id == "ModalMargenS") {
        if (NewMargen == 0) {
          NewPrecioBruto = NewCostoBruto;
          NewPrecioNeto = NewPrecioBruto * (1 + ImpuestoACT / 100);
        }
        if (NewMargen == "") {
          NewPrecioNeto = NewPrecioBruto * (1 + ImpuestoACT / 100);
        }
        if (NewMargen !== 0) {
          NewPrecioBruto = (NewCostoBruto * NewMargen) / 100 + NewCostoBruto;
          NewPrecioNeto = NewPrecioBruto * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNetoS") {
        if (NewPrecioBruto == "") {
          NewPrecioNeto = 0;
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto == 0) {
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto = 0;
        }
        if (NewPrecioBruto > 0) {
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto = NewPrecioBruto * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto < 0) {
          NewPrecioBruto = 0;
        }
      }
      if (form.id == "ModalPrecioVentaS") {
        if (NewPrecioNeto == "") {
          NewPrecioBruto = 0;
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto == 0) {
          NewPrecioBruto = 0;
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto > 0) {
          NewPrecioBruto = NewPrecioNeto / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto < 0) {
          NewPrecioNeto = 0;
        }
      }
      if (form.id == "ModalMargen2S") {
        if (NewMargen2 == 0) {
          NewPrecioBruto2 = NewCostoBruto;
          NewPrecioNeto2 = NewPrecioBruto2 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen2 == "") {
          NewPrecioNeto2 = NewPrecioBruto2 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen2 !== 0) {
          NewPrecioBruto2 = (NewCostoBruto * NewMargen2) / 100 + NewCostoBruto;
          NewPrecioNeto2 = NewPrecioBruto2 * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto2S") {
        if (NewPrecioBruto2 == "") {
          NewPrecioNeto2 = 0;
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto2 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto2 = 0;
        }
        if (NewPrecioBruto2 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto2 = NewPrecioBruto2 * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto2 < 0) {
          NewPrecioBruto2 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta2S") {
        if (NewPrecioNeto2 == "") {
          NewPrecioBruto2 = 0;
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto2 == 0) {
          NewPrecioBruto2 = 0;
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto2 > 0) {
          NewPrecioBruto2 = NewPrecioNeto2 / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto2 < 0) {
          NewPrecioNeto2 = 0;
        }
      }
      if (form.id == "ModalMargen3S") {
        if (NewMargen3 == 0) {
          NewPrecioBruto3 = NewCostoBruto;
          NewPrecioNeto3 = NewPrecioBruto3 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen3 == "") {
          NewPrecioNeto3 = NewPrecioBruto3 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen3 !== 0) {
          NewPrecioBruto3 = (NewCostoBruto * NewMargen3) / 100 + NewCostoBruto;
          NewPrecioNeto3 = NewPrecioBruto3 * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto3S") {
        if (NewPrecioBruto3 == "") {
          NewPrecioNeto3 = 0;
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto3 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto3 = 0;
        }
        if (NewPrecioBruto3 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto3 = NewPrecioBruto3 * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto3 < 0) {
          NewPrecioBruto3 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta3S") {
        if (NewPrecioNeto3 == "") {
          NewPrecioBruto3 = 0;
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto3 == 0) {
          NewPrecioBruto3 = 0;
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto3 > 0) {
          NewPrecioBruto3 = NewPrecioNeto3 / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto3 < 0) {
          NewPrecioNeto3 = 0;
        }
      }

      if (form.id == "ModalMargen4S") {
        if (NewMargen4 == 0) {
          NewPrecioBruto4 = NewCostoBruto;
          NewPrecioNeto4 = NewPrecioBruto4 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen4 == "") {
          NewPrecioNeto4 = NewPrecioBruto4 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen4 !== 0) {
          NewPrecioBruto4 = (NewCostoBruto * NewMargen4) / 100 + NewCostoBruto;
          NewPrecioNeto4 = NewPrecioBruto4 * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto4S") {
        if (NewPrecioBruto4 == "") {
          NewPrecioNeto4 = 0;
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto4 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto4 = 0;
        }
        if (NewPrecioBruto4 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto4 = NewPrecioBruto4 * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto4 < 0) {
          NewPrecioBruto4 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta4S") {
        if (NewPrecioNeto4 == "") {
          NewPrecioBruto4 = 0;
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto4 == 0) {
          NewPrecioBruto4 = 0;
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto4 > 0) {
          NewPrecioBruto4 = NewPrecioNeto4 / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto4 < 0) {
          NewPrecioNeto4 = 0;
        }
      }

      if (form.id == "ModalMargen5S") {
        if (NewMargen5 == 0) {
          NewPrecioBruto5 = NewCostoBruto;
          NewPrecioNeto5 = NewPrecioBruto5 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen5 == "") {
          NewPrecioNeto5 = NewPrecioBruto5 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen5 !== 0) {
          NewPrecioBruto5 = (NewCostoBruto * NewMargen5) / 100 + NewCostoBruto;
          NewPrecioNeto5 = NewPrecioBruto5 * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto5S") {
        if (NewPrecioBruto5 == "") {
          NewPrecioNeto5 = 0;
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto5 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto5 = 0;
        }
        if (NewPrecioBruto5 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto5 = NewPrecioBruto5 * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto5 < 0) {
          NewPrecioBruto5 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta5S") {
        if (NewPrecioNeto5 == "") {
          NewPrecioBruto5 = 0;
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto5 == 0) {
          NewPrecioBruto5 = 0;
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto5 > 0) {
          NewPrecioBruto5 = NewPrecioNeto5 / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto5 < 0) {
          NewPrecioNeto5 = 0;
        }
      }

      if (form.id == "ModalMargen6S") {
        if (NewMargen6 == 0) {
          NewPrecioBruto6 = NewCostoBruto;
          NewPrecioNeto6 = NewPrecioBruto6 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen6 == "") {
          NewPrecioNeto6 = NewPrecioBruto6 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen6 !== 0) {
          NewPrecioBruto6 = (NewCostoBruto * NewMargen6) / 100 + NewCostoBruto;
          NewPrecioNeto6 = NewPrecioBruto6 * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto6S") {
        if (NewPrecioBruto6 == "") {
          NewPrecioNeto6 = 0;
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto6 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto6 = 0;
        }
        if (NewPrecioBruto6 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto6 = NewPrecioBruto6 * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto6 < 0) {
          NewPrecioBruto6 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta6S") {
        if (NewPrecioNeto6 == "") {
          NewPrecioBruto6 = 0;
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto6 == 0) {
          NewPrecioBruto6 = 0;
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto6 > 0) {
          NewPrecioBruto6 = NewPrecioNeto6 / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto6 < 0) {
          NewPrecioNeto6 = 0;
        }
      }

      if (form.id == "ModalMargen7S") {
        if (NewMargen7 == 0) {
          NewPrecioBruto7 = NewCostoBruto;
          NewPrecioNeto7 = NewPrecioBruto7 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen7 == "") {
          NewPrecioNeto7 = NewPrecioBruto7 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen7 !== 0) {
          NewPrecioBruto7 = (NewCostoBruto * NewMargen7) / 100 + NewCostoBruto;
          NewPrecioNeto7 = NewPrecioBruto7 * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto7S") {
        if (NewPrecioBruto7 == "") {
          NewPrecioNeto7 = 0;
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto7 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto7 = 0;
        }
        if (NewPrecioBruto7 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto7 = NewPrecioBruto7 * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto7 < 0) {
          NewPrecioBruto7 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta7S") {
        if (NewPrecioNeto7 == "") {
          NewPrecioBruto7 = 0;
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto7 == 0) {
          NewPrecioBruto7 = 0;
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto7 > 0) {
          NewPrecioBruto7 = NewPrecioNeto7 / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto7 < 0) {
          NewPrecioNeto7 = 0;
        }
      }

      if (form.id == "ModalMargen8S") {
        if (NewMargen8 == 0) {
          NewPrecioBruto8 = NewCostoBruto;
          NewPrecioNeto8 = NewPrecioBruto8 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen8 == "") {
          NewPrecioNeto8 = NewPrecioBruto8 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen8 !== 0) {
          NewPrecioBruto8 = (NewCostoBruto * NewMargen8) / 100 + NewCostoBruto;
          NewPrecioNeto8 = NewPrecioBruto8 * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto8S") {
        if (NewPrecioBruto8 == "") {
          NewPrecioNeto8 = 0;
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto8 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto8 = 0;
        }
        if (NewPrecioBruto8 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto8 = NewPrecioBruto8 * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto8 < 0) {
          NewPrecioBruto8 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta8S") {
        if (NewPrecioNeto8 == "") {
          NewPrecioBruto8 = 0;
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto8 == 0) {
          NewPrecioBruto8 = 0;
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto8 > 0) {
          NewPrecioBruto8 = NewPrecioNeto8 / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto8 < 0) {
          NewPrecioNeto8 = 0;
        }
      }

      if (form.id == "ModalMargen9S") {
        if (NewMargen9 == 0) {
          NewPrecioBruto9 = NewCostoBruto;
          NewPrecioNeto9 = NewPrecioBruto9 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen9 == "") {
          NewPrecioNeto9 = NewPrecioBruto9 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen9 !== 0) {
          NewPrecioBruto9 = (NewCostoBruto * NewMargen9) / 100 + NewCostoBruto;
          NewPrecioNeto9 = NewPrecioBruto9 * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto9S") {
        if (NewPrecioBruto9 == "") {
          NewPrecioNeto9 = 0;
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto9 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto9 = 0;
        }
        if (NewPrecioBruto9 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto9 = NewPrecioBruto9 * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto9 < 0) {
          NewPrecioBruto9 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta9S") {
        if (NewPrecioNeto9 == "") {
          NewPrecioBruto9 = 0;
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto9 == 0) {
          NewPrecioBruto9 = 0;
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto9 > 0) {
          NewPrecioBruto9 = NewPrecioNeto9 / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto9 < 0) {
          NewPrecioNeto9 = 0;
        }
      }

      if (form.id == "ModalMargen10S") {
        if (NewMargen10 == 0) {
          NewPrecioBruto10 = NewCostoBruto;
          NewPrecioNeto10 = NewPrecioBruto10 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen10 == "") {
          NewPrecioNeto10 = NewPrecioBruto10 * (1 + ImpuestoACT / 100);
        }
        if (NewMargen10 !== 0) {
          NewPrecioBruto10 =
            (NewCostoBruto * NewMargen10) / 100 + NewCostoBruto;
          NewPrecioNeto10 = NewPrecioBruto10 * (1 + ImpuestoACT / 100);
        }
      }
      if (form.id == "ModalPrecioNeto10S") {
        if (NewPrecioBruto10 == "") {
          NewPrecioNeto10 = 0;
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto10 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto10 = 0;
        }
        if (NewPrecioBruto10 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto10 = NewPrecioBruto10 * (1 + ImpuestoACT / 100);
        }
        if (NewPrecioBruto10 < 0) {
          NewPrecioBruto10 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta10S") {
        if (NewPrecioNeto10 == "") {
          NewPrecioBruto10 = 0;
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto10 == 0) {
          NewPrecioBruto10 = 0;
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto10 > 0) {
          NewPrecioBruto10 = NewPrecioNeto10 / (1 + ImpuestoACT / 100);
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto10 < 0) {
          NewPrecioNeto10 = 0;
        }
      }
    } else {
      if (form.id == "ModalCant2S") {
        if (ModalCant2 < 1) {
          ModalCant2 = 1;
        }
        if (ModalCant2 == "") {
          ModalCant2 = 1;
        }
      }
      if (form.id == "ModalCant3S") {
        if (ModalCant3 < 1) {
          ModalCant3 = 1;
        }
        if (ModalCant3 == "") {
          ModalCant3 = 1;
        }
      }
      if (form.id == "ModalCant4S") {
        if (ModalCant4 < 1) {
          ModalCant4 = 1;
        }
        if (ModalCant4 == "") {
          ModalCant4 = 1;
        }
      }
      if (form.id == "ModalCant5S") {
        if (ModalCant5 < 1 || ModalCant5 == "") ModalCant5 = 1;
      }
      if (form.id == "ModalCant6S") {
        if (ModalCant6 < 1 || ModalCant6 == "") ModalCant6 = 1;
      }
      if (form.id == "ModalCant7S") {
        if (ModalCant7 < 1 || ModalCant7 == "") ModalCant7 = 1;
      }
      if (form.id == "ModalCant8S") {
        if (ModalCant8 < 1 || ModalCant8 == "") ModalCant8 = 1;
      }
      if (form.id == "ModalCant9S") {
        if (ModalCant9 < 1 || ModalCant9 == "") ModalCant9 = 1;
      }
      if (form.id == "ModalCant10S") {
        if (ModalCant10 < 1 || ModalCant10 == "") ModalCant10 = 1;
      }
      if (form.id == "ModalImpuestosS") {
        totot = Math.round(NewCostoBruto * 1 * (1 + ImpuestoACT / 100));
        NewCostoNeto = totot / 1;
        totot = Math.round(NewPrecioBruto * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto = totot / 1;
        totot = Math.round(NewPrecioBruto2 * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto2 = totot / 1;
        totot = Math.round(NewPrecioBruto3 * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto3 = totot / 1;
        totot = Math.round(NewPrecioBruto4 * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto4 = totot / 1;
        totot = Math.round(NewPrecioBruto5 * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto5 = totot / 1;
        totot = Math.round(NewPrecioBruto6 * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto6 = totot / 1;
        totot = Math.round(NewPrecioBruto7 * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto7 = totot / 1;
        totot = Math.round(NewPrecioBruto8 * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto8 = totot / 1;
        totot = Math.round(NewPrecioBruto9 * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto9 = totot / 1;
        totot = Math.round(NewPrecioBruto10 * 1 * (1 + ImpuestoACT / 100));
        NewPrecioNeto10 = totot / 1;
      }
      if (form.id == "ModalCostoNetoS") {
        if (NewCostoNeto == "") {
          NewCostoBruto = 0;
        }
        if (NewCostoNeto == 0) {
          NewCostoBruto = 0;
        }
        if (NewCostoNeto > 0) {
          totot = NewCostoNeto * 1;
          NewCostoBruto = Math.round(totot / (1 + ImpuestoACT / 100));
          if (NewCostoBruto == 0) {
            NewMargen = 0;
            NewMargen2 = 0;
            NewMargen3 = 0;
            NewMargen4 = 0;
          } else {
            NewPrecioBruto = (NewCostoBruto * NewMargen) / 100 + NewCostoBruto;
            NewPrecioNeto = Math.round(
              NewPrecioBruto * (1 + ImpuestoACT / 100),
            );
            if (NewMargen2 > 0) {
              NewPrecioBruto2 =
                (NewCostoBruto * NewMargen2) / 100 + NewCostoBruto;
              NewPrecioNeto2 = Math.round(
                NewPrecioBruto2 * (1 + ImpuestoACT / 100),
              );
            }
            if (NewMargen3 > 0) {
              NewPrecioBruto3 =
                (NewCostoBruto * NewMargen3) / 100 + NewCostoBruto;
              NewPrecioNeto3 = Math.round(
                NewPrecioBruto3 * (1 + ImpuestoACT / 100),
              );
            }
            if (NewMargen4 > 0) {
              NewPrecioBruto4 =
                (NewCostoBruto * NewMargen4) / 100 + NewCostoBruto;
              NewPrecioNeto4 = Math.round(
                NewPrecioBruto4 * (1 + ImpuestoACT / 100),
              );
            }
          }
        }
        if (NewCostoNeto < 0) {
          NewCostoNeto = 0;
        }
      }
      if (form.id == "ModalCostosS") {
        if (ModalCostos == "") {
          NewCostoBruto = 0;
          NewCostoNeto = 0;
        }
        if (NewCostoBruto == 0) {
          NewCostoNeto = 0;
        }
        if (NewCostoBruto > 0) {
          totot = Math.round(NewCostoBruto * 1 * (1 + ImpuestoACT / 100));
          NewCostoNeto = totot / 1;
          if (NewCostoBruto == 0) {
            NewMargen = 0;
            NewMargen2 = 0;
            NewMargen3 = 0;
            NewMargen4 = 0;
          } else {
            NewPrecioBruto = (NewCostoBruto * NewMargen) / 100 + NewCostoBruto;
            NewPrecioNeto = Math.round(
              NewPrecioBruto * (1 + ImpuestoACT / 100),
            );
            if (NewMargen2 > 0) {
              NewPrecioBruto2 =
                (NewCostoBruto * NewMargen2) / 100 + NewCostoBruto;
              NewPrecioNeto2 = Math.round(
                NewPrecioBruto2 * (1 + ImpuestoACT / 100),
              );
            }
            if (NewMargen3 > 0) {
              NewPrecioBruto3 =
                (NewCostoBruto * NewMargen3) / 100 + NewCostoBruto;
              NewPrecioNeto3 = Math.round(
                NewPrecioBruto3 * (1 + ImpuestoACT / 100),
              );
            }
            if (NewMargen4 > 0) {
              NewPrecioBruto4 =
                (NewCostoBruto * NewMargen4) / 100 + NewCostoBruto;
              NewPrecioNeto4 = Math.round(
                NewPrecioBruto4 * (1 + ImpuestoACT / 100),
              );
            }
          }
        }
        if (NewCostoBruto < 0) {
          NewCostoNeto = 0;
          NewCostoBruto = 0;
        }
      }
      if (form.id == "ModalMargenS") {
        if (NewMargen == 0) {
          NewPrecioBruto = NewCostoBruto;
          NewPrecioNeto = Math.round(NewPrecioBruto * (1 + ImpuestoACT / 100));
        }
        if (NewMargen == "") {
          NewPrecioNeto = Math.round(NewPrecioBruto * (1 + ImpuestoACT / 100));
        }
        if (NewMargen !== 0) {
          NewPrecioBruto = (NewCostoBruto * NewMargen) / 100 + NewCostoBruto;
          NewPrecioNeto = Math.round(NewPrecioBruto * (1 + ImpuestoACT / 100));
        }
      }
      if (form.id == "ModalPrecioNetoS") {
        if (NewPrecioBruto == "") {
          NewPrecioNeto = 0;
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto == 0) {
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto = 0;
        }
        if (NewPrecioBruto > 0) {
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto = totot / 1;
        }
        if (NewPrecioBruto < 0) {
          NewPrecioBruto = 0;
        }
      }
      if (form.id == "ModalPrecioVentaS") {
        if (NewPrecioNeto == "") {
          NewPrecioBruto = 0;
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto == 0) {
          NewPrecioBruto = 0;
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto > 0) {
          NewPrecioBruto = Math.round(
            (NewPrecioNeto * 1) / (1 + ImpuestoACT / 100),
          );
          if (NewCostoBruto == 0) {
            NewMargen = 0;
          } else {
            NewMargen =
              ((NewPrecioBruto - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto < 0) {
          NewPrecioNeto = 0;
        }
      }
      if (form.id == "ModalMargen2S") {
        if (NewMargen2 == 0) {
          NewPrecioBruto2 = NewCostoBruto;
          NewPrecioNeto2 = Math.round(
            NewPrecioBruto2 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen2 == "") {
          NewPrecioNeto2 = Math.round(
            NewPrecioBruto2 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen2 !== 0) {
          NewPrecioBruto2 = (NewCostoBruto * NewMargen2) / 100 + NewCostoBruto;
          NewPrecioNeto2 = Math.round(
            NewPrecioBruto2 * (1 + ImpuestoACT / 100),
          );
        }
      }
      if (form.id == "ModalPrecioNeto2S") {
        if (NewPrecioBruto2 == "") {
          NewPrecioNeto2 = 0;
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto2 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto2 = 0;
        }
        if (NewPrecioBruto2 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto2 * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto2 = totot / 1;
        }
        if (NewPrecioBruto2 < 0) {
          NewPrecioBruto2 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta2S") {
        if (NewPrecioNeto2 == "") {
          NewPrecioBruto2 = 0;
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto2 == 0) {
          NewPrecioBruto2 = 0;
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto2 > 0) {
          NewPrecioBruto2 = Math.round(
            (NewPrecioNeto2 * 1) / (1 + ImpuestoACT / 100),
          );
          if (NewCostoBruto == 0) {
            NewMargen2 = 0;
          } else {
            NewMargen2 =
              ((NewPrecioBruto2 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto2 < 0) {
          NewPrecioNeto2 = 0;
        }
      }
      if (form.id == "ModalMargen3S") {
        if (NewMargen3 == 0) {
          NewPrecioBruto3 = NewCostoBruto;
          NewPrecioNeto3 = Math.round(
            NewPrecioBruto3 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen3 == "") {
          NewPrecioNeto3 = Math.round(
            NewPrecioBruto3 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen3 !== 0) {
          NewPrecioBruto3 = (NewCostoBruto * NewMargen3) / 100 + NewCostoBruto;
          NewPrecioNeto3 = Math.round(
            NewPrecioBruto3 * (1 + ImpuestoACT / 100),
          );
        }
      }
      if (form.id == "ModalPrecioNeto3S") {
        if (NewPrecioBruto3 == "") {
          NewPrecioNeto3 = 0;
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto3 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto3 = 0;
        }
        if (NewPrecioBruto3 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto3 * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto3 = totot / 1;
        }
        if (NewPrecioBruto3 < 0) {
          NewPrecioBruto3 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta3S") {
        if (NewPrecioNeto3 == "") {
          NewPrecioBruto3 = 0;
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto3 == 0) {
          NewPrecioBruto3 = 0;
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto3 > 0) {
          totot = Math.round(NewPrecioNeto3 * 1);
          NewPrecioBruto3 = totot / (1 + ImpuestoACT / 100) / 1;
          if (NewCostoBruto == 0) {
            NewMargen3 = 0;
          } else {
            NewMargen3 =
              ((NewPrecioBruto3 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto3 < 0) {
          NewPrecioNeto3 = 0;
        }
      }

      if (form.id == "ModalMargen4S") {
        if (NewMargen4 == 0) {
          NewPrecioBruto4 = NewCostoBruto;
          NewPrecioNeto4 = Math.round(
            NewPrecioBruto4 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen4 == "") {
          NewPrecioNeto4 = Math.round(
            NewPrecioBruto4 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen4 !== 0) {
          NewPrecioBruto4 = (NewCostoBruto * NewMargen4) / 100 + NewCostoBruto;
          NewPrecioNeto4 = Math.round(
            NewPrecioBruto4 * (1 + ImpuestoACT / 100),
          );
        }
      }
      if (form.id == "ModalPrecioNeto4S") {
        if (NewPrecioBruto4 == "") {
          NewPrecioNeto4 = 0;
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto4 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto4 = 0;
        }
        if (NewPrecioBruto4 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto4 * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto4 = totot / 1;
        }
        if (NewPrecioBruto4 < 0) {
          NewPrecioBruto4 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta4S") {
        if (NewPrecioNeto4 == "") {
          NewPrecioBruto4 = 0;
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto4 == 0) {
          NewPrecioBruto4 = 0;
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto4 > 0) {
          totot = Math.round(NewPrecioNeto4 * 1);
          NewPrecioBruto4 = totot / (1 + ImpuestoACT / 100) / 1;
          if (NewCostoBruto == 0) {
            NewMargen4 = 0;
          } else {
            NewMargen4 =
              ((NewPrecioBruto4 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto4 < 0) {
          NewPrecioNeto4 = 0;
        }
      }

      if (form.id == "ModalMargen5S") {
        if (NewMargen5 == 0) {
          NewPrecioBruto5 = NewCostoBruto;
          NewPrecioNeto5 = Math.round(
            NewPrecioBruto5 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen5 == "") {
          NewPrecioNeto5 = Math.round(
            NewPrecioBruto5 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen5 !== 0) {
          NewPrecioBruto5 = (NewCostoBruto * NewMargen5) / 100 + NewCostoBruto;
          NewPrecioNeto5 = Math.round(
            NewPrecioBruto5 * (1 + ImpuestoACT / 100),
          );
        }
      }
      if (form.id == "ModalPrecioNeto5S") {
        if (NewPrecioBruto5 == "") {
          NewPrecioNeto5 = 0;
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto5 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto5 = 0;
        }
        if (NewPrecioBruto5 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto5 * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto5 = totot / 1;
        }
        if (NewPrecioBruto5 < 0) {
          NewPrecioBruto5 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta5S") {
        if (NewPrecioNeto5 == "") {
          NewPrecioBruto5 = 0;
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto5 == 0) {
          NewPrecioBruto5 = 0;
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto5 > 0) {
          totot = Math.round(NewPrecioNeto5 * 1);
          NewPrecioBruto5 = totot / (1 + ImpuestoACT / 100) / 1;
          if (NewCostoBruto == 0) {
            NewMargen5 = 0;
          } else {
            NewMargen5 =
              ((NewPrecioBruto5 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto5 < 0) {
          NewPrecioNeto5 = 0;
        }
      }

      if (form.id == "ModalMargen6S") {
        if (NewMargen6 == 0) {
          NewPrecioBruto6 = NewCostoBruto;
          NewPrecioNeto6 = Math.round(
            NewPrecioBruto6 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen6 == "") {
          NewPrecioNeto6 = Math.round(
            NewPrecioBruto6 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen6 !== 0) {
          NewPrecioBruto6 = (NewCostoBruto * NewMargen6) / 100 + NewCostoBruto;
          NewPrecioNeto6 = Math.round(
            NewPrecioBruto6 * (1 + ImpuestoACT / 100),
          );
        }
      }
      if (form.id == "ModalPrecioNeto6S") {
        if (NewPrecioBruto6 == "") {
          NewPrecioNeto6 = 0;
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto6 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto6 = 0;
        }
        if (NewPrecioBruto6 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto6 * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto6 = totot / 1;
        }
        if (NewPrecioBruto6 < 0) {
          NewPrecioBruto6 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta6S") {
        if (NewPrecioNeto6 == "") {
          NewPrecioBruto6 = 0;
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto6 == 0) {
          NewPrecioBruto6 = 0;
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto6 > 0) {
          totot = Math.round(NewPrecioNeto6 * 1);
          NewPrecioBruto6 = totot / (1 + ImpuestoACT / 100) / 1;
          if (NewCostoBruto == 0) {
            NewMargen6 = 0;
          } else {
            NewMargen6 =
              ((NewPrecioBruto6 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto6 < 0) {
          NewPrecioNeto6 = 0;
        }
      }

      if (form.id == "ModalMargen7S") {
        if (NewMargen7 == 0) {
          NewPrecioBruto7 = NewCostoBruto;
          NewPrecioNeto7 = Math.round(
            NewPrecioBruto7 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen7 == "") {
          NewPrecioNeto7 = Math.round(
            NewPrecioBruto7 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen7 !== 0) {
          NewPrecioBruto7 = (NewCostoBruto * NewMargen7) / 100 + NewCostoBruto;
          NewPrecioNeto7 = Math.round(
            NewPrecioBruto7 * (1 + ImpuestoACT / 100),
          );
        }
      }
      if (form.id == "ModalPrecioNeto7S") {
        if (NewPrecioBruto7 == "") {
          NewPrecioNeto7 = 0;
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto7 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto7 = 0;
        }
        if (NewPrecioBruto7 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto7 * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto7 = totot / 1;
        }
        if (NewPrecioBruto7 < 0) {
          NewPrecioBruto7 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta7S") {
        if (NewPrecioNeto7 == "") {
          NewPrecioBruto7 = 0;
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto7 == 0) {
          NewPrecioBruto7 = 0;
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto7 > 0) {
          totot = Math.round(NewPrecioNeto7 * 1);
          NewPrecioBruto7 = totot / (1 + ImpuestoACT / 100) / 1;
          if (NewCostoBruto == 0) {
            NewMargen7 = 0;
          } else {
            NewMargen7 =
              ((NewPrecioBruto7 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto7 < 0) {
          NewPrecioNeto7 = 0;
        }
      }

      if (form.id == "ModalMargen8S") {
        if (NewMargen8 == 0) {
          NewPrecioBruto8 = NewCostoBruto;
          NewPrecioNeto8 = Math.round(
            NewPrecioBruto8 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen8 == "") {
          NewPrecioNeto8 = Math.round(
            NewPrecioBruto8 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen8 !== 0) {
          NewPrecioBruto8 = (NewCostoBruto * NewMargen8) / 100 + NewCostoBruto;
          NewPrecioNeto8 = Math.round(
            NewPrecioBruto8 * (1 + ImpuestoACT / 100),
          );
        }
      }
      if (form.id == "ModalPrecioNeto8S") {
        if (NewPrecioBruto8 == "") {
          NewPrecioNeto8 = 0;
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto8 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto8 = 0;
        }
        if (NewPrecioBruto8 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto8 * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto8 = totot / 1;
        }
        if (NewPrecioBruto8 < 0) {
          NewPrecioBruto8 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta8S") {
        if (NewPrecioNeto8 == "") {
          NewPrecioBruto8 = 0;
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto8 == 0) {
          NewPrecioBruto8 = 0;
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto8 > 0) {
          totot = Math.round(NewPrecioNeto8 * 1);
          NewPrecioBruto8 = totot / (1 + ImpuestoACT / 100) / 1;
          if (NewCostoBruto == 0) {
            NewMargen8 = 0;
          } else {
            NewMargen8 =
              ((NewPrecioBruto8 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto8 < 0) {
          NewPrecioNeto8 = 0;
        }
      }

      if (form.id == "ModalMargen9S") {
        if (NewMargen9 == 0) {
          NewPrecioBruto9 = NewCostoBruto;
          NewPrecioNeto9 = Math.round(
            NewPrecioBruto9 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen9 == "") {
          NewPrecioNeto9 = Math.round(
            NewPrecioBruto9 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen9 !== 0) {
          NewPrecioBruto9 = (NewCostoBruto * NewMargen9) / 100 + NewCostoBruto;
          NewPrecioNeto9 = Math.round(
            NewPrecioBruto9 * (1 + ImpuestoACT / 100),
          );
        }
      }
      if (form.id == "ModalPrecioNeto9S") {
        if (NewPrecioBruto9 == "") {
          NewPrecioNeto9 = 0;
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto9 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto9 = 0;
        }
        if (NewPrecioBruto9 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto9 * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto9 = totot / 1;
        }
        if (NewPrecioBruto9 < 0) {
          NewPrecioBruto9 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta9S") {
        if (NewPrecioNeto9 == "") {
          NewPrecioBruto9 = 0;
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto9 == 0) {
          NewPrecioBruto9 = 0;
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto9 > 0) {
          totot = Math.round(NewPrecioNeto9 * 1);
          NewPrecioBruto9 = totot / (1 + ImpuestoACT / 100) / 1;
          if (NewCostoBruto == 0) {
            NewMargen9 = 0;
          } else {
            NewMargen9 =
              ((NewPrecioBruto9 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto9 < 0) {
          NewPrecioNeto9 = 0;
        }
      }

      if (form.id == "ModalMargen10S") {
        if (NewMargen10 == 0) {
          NewPrecioBruto10 = NewCostoBruto;
          NewPrecioNeto10 = Math.round(
            NewPrecioBruto10 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen10 == "") {
          NewPrecioNeto10 = Math.round(
            NewPrecioBruto10 * (1 + ImpuestoACT / 100),
          );
        }
        if (NewMargen10 !== 0) {
          NewPrecioBruto10 =
            (NewCostoBruto * NewMargen10) / 100 + NewCostoBruto;
          NewPrecioNeto10 = Math.round(
            NewPrecioBruto10 * (1 + ImpuestoACT / 100),
          );
        }
      }
      if (form.id == "ModalPrecioNeto10S") {
        if (NewPrecioBruto10 == "") {
          NewPrecioNeto10 = 0;
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioBruto10 == 0) {
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          NewPrecioNeto10 = 0;
        }
        if (NewPrecioBruto10 > 0) {
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
          totot = Math.round(NewPrecioBruto10 * 1 * (1 + ImpuestoACT / 100));
          NewPrecioNeto10 = totot / 1;
        }
        if (NewPrecioBruto10 < 0) {
          NewPrecioBruto10 = 0;
        }
      }
      if (form.id == "ModalPrecioVenta10S") {
        if (NewPrecioNeto10 == "") {
          NewPrecioBruto10 = 0;
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto10 == 0) {
          NewPrecioBruto10 = 0;
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto10 > 0) {
          totot = Math.round(NewPrecioNeto10 * 1);
          NewPrecioBruto10 = totot / (1 + ImpuestoACT / 100) / 1;
          if (NewCostoBruto == 0) {
            NewMargen10 = 0;
          } else {
            NewMargen10 =
              ((NewPrecioBruto10 - NewCostoBruto) * 100) / NewCostoBruto;
          }
        }
        if (NewPrecioNeto10 < 0) {
          NewPrecioNeto10 = 0;
        }
      }
    }
    document.getElementById("ModalCostosS").value = NewCostoBruto.toFixed(2);
    document.getElementById("ModalCostoNetoS").value = NewCostoNeto.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalMargenS").value = NewMargen.toFixed(2);
    document.getElementById("ModalPrecioNetoS").value =
      NewPrecioBruto.toFixed(2);
    document.getElementById("ModalPrecioVentaS").value = NewPrecioNeto.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalMargen2S").value = NewMargen2.toFixed(2);
    document.getElementById("ModalPrecioNeto2S").value =
      NewPrecioBruto2.toFixed(2);
    document.getElementById("ModalPrecioVenta2S").value =
      NewPrecioNeto2.toFixed(document.getElementById("CD").innerHTML);
    document.getElementById("ModalMargen3S").value = NewMargen3.toFixed(2);
    document.getElementById("ModalPrecioNeto3S").value =
      NewPrecioBruto3.toFixed(2);
    document.getElementById("ModalPrecioVenta3S").value =
      NewPrecioNeto3.toFixed(document.getElementById("CD").innerHTML);
    document.getElementById("ModalMargen4S").value = NewMargen4.toFixed(2);
    document.getElementById("ModalPrecioNeto4S").value =
      NewPrecioBruto4.toFixed(2);
    document.getElementById("ModalPrecioVenta4S").value =
      NewPrecioNeto4.toFixed(document.getElementById("CD").innerHTML);

    document.getElementById("ModalMargen5S").value = NewMargen5.toFixed(2);
    document.getElementById("ModalPrecioNeto5S").value =
      NewPrecioBruto5.toFixed(2);
    document.getElementById("ModalPrecioVenta5S").value =
      NewPrecioNeto5.toFixed(document.getElementById("CD").innerHTML);

    document.getElementById("ModalMargen6S").value = NewMargen6.toFixed(2);
    document.getElementById("ModalPrecioNeto6S").value =
      NewPrecioBruto6.toFixed(2);
    document.getElementById("ModalPrecioVenta6S").value =
      NewPrecioNeto6.toFixed(document.getElementById("CD").innerHTML);

    document.getElementById("ModalMargen7S").value = NewMargen7.toFixed(2);
    document.getElementById("ModalPrecioNeto7S").value =
      NewPrecioBruto7.toFixed(2);
    document.getElementById("ModalPrecioVenta7S").value =
      NewPrecioNeto7.toFixed(document.getElementById("CD").innerHTML);

    document.getElementById("ModalMargen8S").value = NewMargen8.toFixed(2);
    document.getElementById("ModalPrecioNeto8S").value =
      NewPrecioBruto8.toFixed(2);
    document.getElementById("ModalPrecioVenta8S").value =
      NewPrecioNeto8.toFixed(document.getElementById("CD").innerHTML);

    document.getElementById("ModalMargen9S").value = NewMargen9.toFixed(2);
    document.getElementById("ModalPrecioNeto9S").value =
      NewPrecioBruto9.toFixed(2);
    document.getElementById("ModalPrecioVenta9S").value =
      NewPrecioNeto9.toFixed(document.getElementById("CD").innerHTML);

    document.getElementById("ModalMargen10S").value = NewMargen10.toFixed(2);
    document.getElementById("ModalPrecioNeto10S").value =
      NewPrecioBruto10.toFixed(2);
    document.getElementById("ModalPrecioVenta10S").value =
      NewPrecioNeto10.toFixed(document.getElementById("CD").innerHTML);

    document.getElementById("ModalCant2S").value = ModalCant2;
    document.getElementById("ModalCant3S").value = ModalCant3;
    document.getElementById("ModalCant4S").value = ModalCant4;
    document.getElementById("ModalCant5S").value = ModalCant5;
    document.getElementById("ModalCant6S").value = ModalCant6;
    document.getElementById("ModalCant7S").value = ModalCant7;
    document.getElementById("ModalCant8S").value = ModalCant8;
    document.getElementById("ModalCant9S").value = ModalCant9;
    document.getElementById("ModalCant10S").value = ModalCant10;

    if (ModalCant2 > 1 && NewPrecioBruto2 > 0) {
      document.getElementById("cantsimpS").innerHTML =
        (NewPrecioBruto2.toFixed(2) / ModalCant2).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida2").value;
      document.getElementById("cantcimpS").innerHTML =
        (NewPrecioNeto2.toFixed(2) / ModalCant2).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida2").value;
    }

    if (ModalCant3 > 1 && NewPrecioBruto3 > 0) {
      document.getElementById("cantsimp2S").innerHTML =
        (NewPrecioBruto3.toFixed(2) / ModalCant3).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida3").value;
      document.getElementById("cantcimp2S").innerHTML =
        (NewPrecioNeto3.toFixed(2) / ModalCant3).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida3").value;
    }
    if (ModalCant4 > 1 && NewPrecioBruto4 > 0) {
      document.getElementById("cantsimp4S").innerHTML =
        (NewPrecioBruto4.toFixed(2) / ModalCant4).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida4").value;
      document.getElementById("cantcimp4S").innerHTML =
        (NewPrecioNeto4.toFixed(2) / ModalCant4).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida4").value;
    }
    if (ModalCant5 > 1 && NewPrecioBruto5 > 0) {
      document.getElementById("cantsimp5S").innerHTML =
        (NewPrecioBruto5.toFixed(2) / ModalCant5).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida5").value;
      document.getElementById("cantcimp5S").innerHTML =
        (NewPrecioNeto5.toFixed(2) / ModalCant5).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida5").value;
    }
    if (ModalCant6 > 1 && NewPrecioBruto6 > 0) {
      document.getElementById("cantsimp6S").innerHTML =
        (NewPrecioBruto6.toFixed(2) / ModalCant6).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida6").value;
      document.getElementById("cantcimp6S").innerHTML =
        (NewPrecioNeto6.toFixed(2) / ModalCant6).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida6").value;
    }
    if (ModalCant7 > 1 && NewPrecioBruto7 > 0) {
      document.getElementById("cantsimp7S").innerHTML =
        (NewPrecioBruto7.toFixed(2) / ModalCant7).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida7").value;
      document.getElementById("cantcimp7S").innerHTML =
        (NewPrecioNeto7.toFixed(2) / ModalCant7).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida7").value;
    }
    if (ModalCant8 > 1 && NewPrecioBruto8 > 0) {
      document.getElementById("cantsimp8S").innerHTML =
        (NewPrecioBruto8.toFixed(2) / ModalCant8).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida8").value;
      document.getElementById("cantcimp8S").innerHTML =
        (NewPrecioNeto8.toFixed(2) / ModalCant8).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida8").value;
    }
    if (ModalCant9 > 1 && NewPrecioBruto9 > 0) {
      document.getElementById("cantsimp9S").innerHTML =
        (NewPrecioBruto9.toFixed(2) / ModalCant9).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida9").value;
      document.getElementById("cantcimp9S").innerHTML =
        (NewPrecioNeto9.toFixed(2) / ModalCant9).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida9").value;
    }
    if (ModalCant10 > 1 && NewPrecioBruto10 > 0) {
      document.getElementById("cantsimp10S").innerHTML =
        (NewPrecioBruto10.toFixed(2) / ModalCant10).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida10").value;
      document.getElementById("cantcimp10S").innerHTML =
        (NewPrecioNeto10.toFixed(2) / ModalCant10).toFixed(3) +
        " x " +
        document.getElementById("ModalMedida10").value;
    }
  }
}

function AgregarUbiS() {
  $.ajax({
    type: "POST",
    url: "productoseek.php",
    data: {
      Accion: "2",
      ModalEnvase: document.getElementById("ModalUbiProdX").value,
      jsonEtiquetas: document.getElementById("jsonUbicacion").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    $("#jsonUbicacion").html(msg);
    Actualizar2S();
  });
}

function Actualizar2S() {
  $.ajax({
    type: "POST",
    url: "productoseek.php",
    data: {
      Accion: "6",
      jsonEtiquetas: document.getElementById("jsonUbicacion").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    $("#MostrarUbicacion").html(msg);
  });
}

function AgregarEtiquetaS() {
  $.ajax({
    type: "POST",
    url: "productoseek.php",
    data: {
      Accion: "2",
      ModalEnvase: document.getElementById("ModalEnvase").value,
      jsonEtiquetas: document.getElementById("jsonEtiquetas").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    if (document.getElementById("CompanyActual").innerHTML == "138") {
      alert(msg);
    }
    if (msg.trim() == "1") {
      document.getElementById(
        "alertaerrorenproducto",
      ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Etiqueta_Repetido}</strong><br><small>${Utils2a.Desc14}</small>`;
      $("#alertaerrorenproducto").delay(100).fadeIn("slow");
      setTimeout(() => OcultarNotificacion2(), 5000);
      $("#ModalEnvase").focus();
    } else {
      if (msg.trim() == "2") {
        document.getElementById(
          "alertaerrorenproducto",
        ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Etiqueta_en_Blanco}</strong><br><small>${Utils2a.Desc16}</small>`;
        $("#alertaerrorenproducto").delay(100).fadeIn("slow");
        setTimeout(() => OcultarNotificacion2(), 5000);
        $("#ModalEnvase").focus();
      } else {
        $("#jsonEtiquetas").html(msg);
        $("#ModalEnvase").blur().val("");
        $("#suggesstion-box2x").hide();
        $("#suggesstion-box2q").hide();
        Actualizar();
      }
    }
  });
}

function Actualizar() {
  $.ajax({
    type: "POST",
    url: "productoseek.php",
    data: {
      Accion: "3",
      jsonEtiquetas: document.getElementById("jsonEtiquetas").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    $("#MostrarEtiquetas").html(msg);
    $("#ModalEnvase").focus();
    $("#suggesstion-box2x").hide();
    $("#suggesstion-box2q").hide();
  });
}

function EliminarEtiqueta(Envase) {
  $.ajax({
    type: "POST",
    url: "productoseek.php",
    data: {
      Accion: "4",
      ModalEnvase: Envase,
      jsonEtiquetas: document.getElementById("jsonEtiquetas").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    $("#jsonEtiquetas").html(msg);
    $("#suggesstion-box2x").hide();
    $("#suggesstion-box2q").hide();
    Actualizar();
  });
}

function EnvioI() {
  document.getElementById("Heisenberg").innerHTML = Utils2a.Cargando;
  $.ajax({
    type: "POST",
    url: "productoseek.php",
    data: {
      Almacen: "4",
      permiso: document.getElementById("MVaria").innerHTML,
      Id: document.getElementById("serialesspan").innerHTML,
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
      userperfil: document.getElementById("userperfil").innerHTML,
      IdAlmGroup: document.getElementById("IdAlmGroup").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      AlmacenesAtt: document.getElementById("AlmacenesAtt").innerHTML,
      IdAlmVtaSeleccionada: document.getElementById("IdAlmVtaSeleccionada")
        .innerHTML,
      IdAlmVta: document.getElementById("IdAlmVta").innerHTML,
      VerStock: document.getElementById("VerStock").innerHTML,
      VisualExist: document.getElementById("VisualExist").value,
      PerfilVentas: document.getElementById("PerfilVentas").innerHTML,
      sucursal: document.getElementById("sucursal").innerHTML,
    },
  }).done(function (msg) {
    //alert(msg);
    $("#Heisenberg").html(msg);
  });
}

function auditoriaS(codbasic) {
  $("#apps-auditoriaS").modal("show");
  $("#AuditoriaS").DataTable().clear().destroy();

  $("#AuditoriaS").DataTable().clear().destroy();
  DATATABLESERIALES = $("#AuditoriaS").DataTable({
    search: {
      search: $(
        `#${"AuditoriaS"}_wrapper .dt-layout-row .dt-end .dt-search .dt-input`,
      ).val(),
    },
    responsive: true,
    processing: true,
    serverSide: true,
    retrieve: true,
    language: {
      url: `lang/datatables/${
        document.getElementById("IdiomaActual").innerHTML
      }.json`,
    },
    ajax: {
      type: "POST",
      url: "utilidadess.php",
      data: {
        Accion: "auditoria-seriales",
        CodIdBasico: codbasic,
        CompanyActual: document.getElementById("CompanyActual").innerHTML,
        userperfil: document.getElementById("userperfil").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        MonedaS: document.getElementById("MonedaS").innerHTML,
        PerfilVentas: document.getElementById("PerfilVentas").innerHTML,
      },
    },
    destroy: true,
  });
  setTimeout(() => $("div.dataTables_filter input").focus(), 500);
}

function Selectorangodelhis1() {
  if (document.getElementById("SelectorDiaMesHistSer1").value == "1") {
    $("#ModaldesdeHistSer1").prop("disabled", true);
    $("#ModalhastaHistSer1").prop("disabled", true);
    var fecha = new Date();
    var mes = fecha.getMonth() + 1;
    var dia = fecha.getDate();
    var ano = fecha.getFullYear();
    var horai = "00";
    var horaf = "23";
    var minf = "59";
    var mini = "00";
    var segf = "59";
    if (dia < 10) {
      dia = "0" + dia;
    }
    if (mes < 10) {
      mes = "0" + mes;
    }
    document.getElementById("ModaldesdeHistSer1").value =
      ano + "-" + mes + "-" + dia + "T" + horai + ":" + mini;
    document.getElementById("ModalhastaHistSer1").value =
      ano + "-" + mes + "-" + dia + "T" + horaf + ":" + minf + ":" + segf;
    HistoricoSerial();
  }
  if (document.getElementById("SelectorDiaMesHistSer1").value == "2") {
    $("#ModaldesdeHistSer1").prop("disabled", true);
    $("#ModalhastaHistSer1").prop("disabled", true);
    var fecha = new Date();
    var mes = fecha.getMonth() + 1;
    var dia = fecha.getDate() - 1;
    if (dia > fecha.getDate()) {
      mes = fecha.getMonth();
    }
    var ano = fecha.getFullYear();
    var horai = "00";
    var horaf = "23";
    var minf = "59";
    var mini = "00";
    var segf = "59";
    if (dia < 10) {
      dia = "0" + dia;
    }
    if (mes < 10) {
      mes = "0" + mes;
    }
    document.getElementById("ModaldesdeHistSer1").value =
      ano + "-" + mes + "-" + dia + "T" + horai + ":" + mini;
    document.getElementById("ModalhastaHistSer1").value =
      ano + "-" + mes + "-" + dia + "T" + horaf + ":" + minf + ":" + segf;
    HistoricoSerial();
  }
  if (document.getElementById("SelectorDiaMesHistSer1").value == "3") {
    $("#ModaldesdeHistSer1").prop("disabled", true);
    $("#ModalhastaHistSer1").prop("disabled", true);
    var fecha = new Date();
    var mes = fecha.getMonth() + 1;
    var ano = fecha.getFullYear();
    var dia = fecha.getDate();
    var horai = "00";
    var horaf = "23";
    var minf = "59";
    var mini = "00";
    var segf = "59";
    if (mes < 10) {
      mes = "0" + mes;
    }
    var lastDay = new Date(
      fecha.getFullYear(),
      fecha.getMonth() + 1,
      0,
    ).getDate();
    document.getElementById("ModaldesdeHistSer1").value =
      ano + "-" + mes + "-" + "01" + "T" + horai + ":" + mini;
    document.getElementById("ModalhastaHistSer1").value =
      ano + "-" + mes + "-" + lastDay + "T" + horaf + ":" + minf + ":" + segf;
    HistoricoSerial();
  }
  if (document.getElementById("SelectorDiaMesHistSer1").value == "4") {
    $("#ModaldesdeHistSer1").prop("disabled", true);
    $("#ModalhastaHistSer1").prop("disabled", true);
    var fecha = new Date(new Date().setMonth(new Date().getMonth() - 1));
    var mes = fecha.getMonth() + 1;
    var ano = fecha.getFullYear();
    var horai = "00";
    var horaf = "23";
    var minf = "59";
    var mini = "00";
    var segf = "59";
    var lastDay = new Date(
      fecha.getFullYear(),
      fecha.getMonth() + 1,
      0,
    ).getDate();
    if (mes < 10) {
      mes = "0" + mes;
    }
    document.getElementById("ModaldesdeHistSer1").value =
      ano + "-" + mes + "-" + "01" + "T" + horai + ":" + mini;
    document.getElementById("ModalhastaHistSer1").value =
      ano + "-" + mes + "-" + lastDay + "T" + horaf + ":" + minf + ":" + segf;
    HistoricoSerial();
  }
  if (document.getElementById("SelectorDiaMesHistSer1").value == "5") {
    $("#ModaldesdeHistSer1").prop("disabled", false);
    $("#ModalhastaHistSer1").prop("disabled", false);
    var fecha = new Date();
    var mes = fecha.getMonth() + 1;
    var dia = fecha.getDate();
    var ano = fecha.getFullYear();
    var horai = "00";
    var horaf = "23";
    var minf = "59";
    var mini = "00";
    var segf = "59";
    if (dia < 10) {
      dia = "0" + dia;
    }
    if (mes < 10) {
      mes = "0" + mes;
    }
    document.getElementById("ModaldesdeHistSer1").value =
      ano + "-" + mes + "-" + dia + "T" + horai + ":" + mini;
    document.getElementById("ModalhastaHistSer1").value =
      ano + "-" + mes + "-" + dia + "T" + horaf + ":" + minf + ":" + segf;
    HistoricoSerial();
  }
}

function BuscarHistorico(Serial) {
  document.getElementById("historicoSerialInt").value = Serial;
  document.getElementById("SelectorDiaMesHistSer1").value = 1;
  Selectorangodelhis1();
  $("#ModalHistoricoSerial").modal("show");
}

function HistoricoSerial(n = 1) {
  if (n === 0) {
    document.getElementById("SelectorDiaMesHistSer1").value = 1;
    Selectorangodelhis1();
  }
  var fecha = new Date(document.getElementById("ModaldesdeHistSer1").value);
  var fechaa = new Date(document.getElementById("ModalhastaHistSer1").value);
  var mes = fecha.getMonth() + 1;
  var dia = fecha.getDate();
  var mess = fechaa.getMonth() + 1;
  var diaa = fechaa.getDate();
  var hora = fecha.getHours();
  var horaa = fechaa.getHours();
  var min = fecha.getMinutes();
  var minn = fechaa.getMinutes();
  var seg = fecha.getSeconds();
  var segg = fechaa.getSeconds();
  if (dia < 10) {
    dia = "0" + dia;
  }
  if (mes < 10) {
    mes = "0" + mes;
  }
  if (diaa < 10) {
    diaa = "0" + diaa;
  }
  if (mess < 10) {
    mess = "0" + mess;
  }
  var valor6 =
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
    seg;
  var valor7 =
    fechaa.getFullYear() +
    "-" +
    mess +
    "-" +
    diaa +
    " " +
    horaa +
    ":" +
    minn +
    ":" +
    segg;
  $.ajax({
    type: "POST",
    url: "productoseek.php",
    data: {
      Accion: "HistoricoSerial",
      Desde: valor6,
      Hasta: valor7,
      Serial: document.getElementById("historicoSerialInt").value,
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    $("#HistoricoSerialTable").html(msg);
    var count = document.getElementById("allreghistoricoserial").innerHTML;
    var count2 = document.getElementById("InvIniHisSer").innerHTML;
    if (
      count + count2 > 0 ||
      document.getElementById("historicoSerialInt").value == ""
    ) {
      $("#errorhistserial").hide();
    } else {
      $("#errorhistserial").show();
    }
    $("#InventarioFinalHistorial").html($("#InvFinHisSer").html());
    $("#InventarioInicialHistorial").val($("#InvIniHisSer").html());
  });
}

function Selectorangodelhis2() {
  if (document.getElementById("SelectorDiaMesHistSer2").value == "1") {
    $("#ModaldesdeHistSer2").prop("disabled", true);
    $("#ModalhastaHistSer2").prop("disabled", true);
    var fecha = new Date();
    var mes = fecha.getMonth() + 1;
    var dia = fecha.getDate();
    var ano = fecha.getFullYear();
    var horai = "00";
    var horaf = "23";
    var minf = "59";
    var mini = "00";
    var segf = "59";
    if (dia < 10) {
      dia = "0" + dia;
    }
    if (mes < 10) {
      mes = "0" + mes;
    }
    document.getElementById("ModaldesdeHistSer2").value =
      ano + "-" + mes + "-" + dia + "T" + horai + ":" + mini;
    document.getElementById("ModalhastaHistSer2").value =
      ano + "-" + mes + "-" + dia + "T" + horaf + ":" + minf + ":" + segf;
    HistoricoSerial2();
  }
  if (document.getElementById("SelectorDiaMesHistSer2").value == "2") {
    $("#ModaldesdeHistSer2").prop("disabled", true);
    $("#ModalhastaHistSer2").prop("disabled", true);
    var fecha = new Date();
    var mes = fecha.getMonth() + 1;
    var dia = fecha.getDate() - 1;
    if (dia > fecha.getDate()) {
      mes = fecha.getMonth();
    }
    var ano = fecha.getFullYear();
    var horai = "00";
    var horaf = "23";
    var minf = "59";
    var mini = "00";
    var segf = "59";
    if (dia < 10) {
      dia = "0" + dia;
    }
    if (mes < 10) {
      mes = "0" + mes;
    }
    document.getElementById("ModaldesdeHistSer2").value =
      ano + "-" + mes + "-" + dia + "T" + horai + ":" + mini;
    document.getElementById("ModalhastaHistSer2").value =
      ano + "-" + mes + "-" + dia + "T" + horaf + ":" + minf + ":" + segf;
    HistoricoSerial2();
  }
  if (document.getElementById("SelectorDiaMesHistSer2").value == "3") {
    $("#ModaldesdeHistSer2").prop("disabled", true);
    $("#ModalhastaHistSer2").prop("disabled", true);
    var fecha = new Date();
    var mes = fecha.getMonth() + 1;
    var ano = fecha.getFullYear();
    var dia = fecha.getDate();
    var horai = "00";
    var horaf = "23";
    var minf = "59";
    var mini = "00";
    var segf = "59";
    if (mes < 10) {
      mes = "0" + mes;
    }
    var lastDay = new Date(
      fecha.getFullYear(),
      fecha.getMonth() + 1,
      0,
    ).getDate();
    document.getElementById("ModaldesdeHistSer2").value =
      ano + "-" + mes + "-" + "01" + "T" + horai + ":" + mini;
    document.getElementById("ModalhastaHistSer2").value =
      ano + "-" + mes + "-" + lastDay + "T" + horaf + ":" + minf + ":" + segf;
    HistoricoSerial2();
  }
  if (document.getElementById("SelectorDiaMesHistSer2").value == "4") {
    $("#ModaldesdeHistSer2").prop("disabled", true);
    $("#ModalhastaHistSer2").prop("disabled", true);

    var fecha = new Date(new Date().setMonth(new Date().getMonth() - 1));
    var mes = fecha.getMonth() + 1;
    var ano = fecha.getFullYear();
    var horai = "00";
    var horaf = "23";
    var minf = "59";
    var mini = "00";
    var segf = "59";
    var lastDay = new Date(
      fecha.getFullYear(),
      fecha.getMonth() + 1,
      0,
    ).getDate();
    if (mes < 10) {
      mes = "0" + mes;
    }
    document.getElementById("ModaldesdeHistSer2").value =
      ano + "-" + mes + "-" + "01" + "T" + horai + ":" + mini;
    document.getElementById("ModalhastaHistSer2").value =
      ano + "-" + mes + "-" + lastDay + "T" + horaf + ":" + minf + ":" + segf;
    HistoricoSerial2();
  }
  if (document.getElementById("SelectorDiaMesHistSer2").value == "5") {
    $("#ModaldesdeHistSer2").prop("disabled", false);
    $("#ModalhastaHistSer2").prop("disabled", false);
    var fecha = new Date();
    var mes = fecha.getMonth() + 1;
    var dia = fecha.getDate();
    var ano = fecha.getFullYear();
    var horai = "00";
    var horaf = "23";
    var minf = "59";
    var mini = "00";
    var segf = "59";
    if (dia < 10) {
      dia = "0" + dia;
    }
    if (mes < 10) {
      mes = "0" + mes;
    }
    document.getElementById("ModaldesdeHistSer2").value =
      ano + "-" + mes + "-" + dia + "T" + horai + ":" + mini;
    document.getElementById("ModalhastaHistSer2").value =
      ano + "-" + mes + "-" + dia + "T" + horaf + ":" + minf + ":" + segf;
    HistoricoSerial2();
  }
}

function HistoricoSerial2(CodIdBasico = "*", Descripcion = "*") {
  if (CodIdBasico === "*") {
    CodIdBasico = document.getElementById("CodIdBasicoHistSer2").value;
  } else {
    document.getElementById("SelectorDiaMesHistSer2").value = 1;
    Selectorangodelhis2();
    document.getElementById("CodIdBasicoHistSer2").value = CodIdBasico;
    $("#HistoricoSerialTable2").html("");
    $("#InventarioFinalHistorial2").html(0);
    $("#InventarioInicialHistorial2").val(0);
  }
  var fecha = new Date(document.getElementById("ModaldesdeHistSer2").value);
  var fechaa = new Date(document.getElementById("ModalhastaHistSer2").value);
  var mes = fecha.getMonth() + 1;
  var dia = fecha.getDate();
  var mess = fechaa.getMonth() + 1;
  var diaa = fechaa.getDate();
  var hora = fecha.getHours();
  var horaa = fechaa.getHours();
  var min = fecha.getMinutes();
  var minn = fechaa.getMinutes();
  var seg = fecha.getSeconds();
  var segg = fechaa.getSeconds();
  if (dia < 10) {
    dia = "0" + dia;
  }
  if (mes < 10) {
    mes = "0" + mes;
  }
  if (diaa < 10) {
    diaa = "0" + diaa;
  }
  if (mess < 10) {
    mess = "0" + mess;
  }
  var valor6 =
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
    seg;
  var valor7 =
    fechaa.getFullYear() +
    "-" +
    mess +
    "-" +
    diaa +
    " " +
    horaa +
    ":" +
    minn +
    ":" +
    segg;
  if (Descripcion !== "*")
    document.getElementById("DescHistSer").innerHTML = Descripcion;
  $.ajax({
    type: "POST",
    url: "productoseek.php",
    data: {
      Accion: "HistoricoSerial2",
      CodIdBasicoHistSer: CodIdBasico,
      Desde: valor6,
      Hasta: valor7,
      IdUbi: document.getElementById("SelectorSucursal").value,
      IdAlm: document.getElementById("SelectorAlmacen").value,
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    $("#HistoricoSerialTable2").html(msg);
    $("#InventarioFinalHistorial2").html($("#InvFinHisSer2").html());
    $("#InventarioInicialHistorial2").val($("#InvIniHisSer2").html());
    $("#ModalHistoricoSerial2").modal("show");
  });
}

function EstadisticaProducto(CodIdBasico, Descripcion) {
  EstadisticaProductoAray.CodIdBasico = CodIdBasico;
  EstadisticaProductoAray.Descripcion = Descripcion;
  EstadisticaProductoAray.pagina = 1;
  document.getElementById("DescEstadistica").innerHTML = Descripcion;
  document.getElementById("SelectorDiaMesEstadistica").value = "1";

  document.getElementById("CantidadDeCompras").innerHTML = "";
  document.getElementById("CantidadDeVentas").innerHTML = "";
  SelectorangodelEstadistica();
  $("#ModalEstadisticaProducto").modal("show");
}

function RefreshEstProduco() {
  var fecha = new Date(document.getElementById("ModaldesdeEstadistica").value);
  var fechaa = new Date(document.getElementById("ModalhastaEstadistica").value);
  var mes = fecha.getMonth() + 1;
  var dia = fecha.getDate();
  var mess = fechaa.getMonth() + 1;
  var diaa = fechaa.getDate();
  var hora = fecha.getHours();
  var horaa = fechaa.getHours();
  var min = fecha.getMinutes();
  var minn = fechaa.getMinutes();
  var seg = fecha.getSeconds();
  var segg = fechaa.getSeconds();
  if (dia < 10) dia = "0" + dia;
  if (mes < 10) mes = "0" + mes;
  if (diaa < 10) diaa = "0" + diaa;
  if (mess < 10) mess = "0" + mess;
  var valor6 =
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
    seg;
  var valor7 =
    fechaa.getFullYear() +
    "-" +
    mess +
    "-" +
    diaa +
    " " +
    horaa +
    ":" +
    minn +
    ":" +
    segg;
  $.ajax({
    type: "POST",
    url: "productoseek.php",
    async: false,
    data: {
      Accion: "EstadisticaProducto",
      CodIdBasico: EstadisticaProductoAray.CodIdBasico,
      pagina: EstadisticaProductoAray.pagina,
      Desde: valor6,
      Hasta: valor7,
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    const array = JSON.parse(msg);

    let CantidadDeCompras = ``;
    let CantidadDeVentas = ``;

    array.buy.forEach((comp) => {
      CantidadDeCompras += `
				<div>
					<div class="card">
						<div class="card-body">
							<div class=" d-flex justify-content-between">
								<div><span class="badge bg-success"><i class="fa fa-calendar"></i> ${comp.Fecha}</span></div>
								<div><span class="badge bg-light text-dark"><i class="fa fa-hashtag"></i> ${comp.Referencia}</span></div>
							</div>
							<div class=" d-flex justify-content-between">
								<div><span class="badge bg-info"><i class="fa fa-box"></i> ${comp.etiqueta} - ${comp.IdtxDef}</span></div>
								<div><span class="badge bg-primary"><i class="fa fa-user"></i> ${comp.Cliente}</span></div>
							</div>
							<div class=" d-flex justify-content-between">
								<div>${comp.Cant} ${comp.Medida}</div>
								<div>${comp.Total} ${MonedaP}</div>
							</div>
						</div>
					</div>
				</div>
			`;
    });

    array.sell.forEach((comp) => {
      CantidadDeVentas += `
				<div>
					<div class="card">
						<div class="card-body">
							<div class=" d-flex justify-content-between">
								<div><span class="badge bg-success"><i class="fa fa-calendar"></i> ${comp.Fecha}</span></div>
								<div><span class="badge bg-light text-dark"><i class="fa fa-hashtag"></i> ${comp.Referencia}</span></div>
							</div>
							<div class=" d-flex justify-content-between">
								<div><span class="badge bg-info"><i class="fa fa-box"></i> ${comp.etiqueta} - ${comp.IdtxDef}</span></div>
								<div><span class="badge bg-primary"><i class="fa fa-user"></i> ${comp.Cliente}</span></div>
							</div>
							<div class=" d-flex justify-content-between">
								<div>${comp.Cant} ${comp.Medida}</div>
								<div>${comp.Total} ${MonedaP}</div>
							</div>
						</div>
					</div>
				</div>
			`;
    });

    document.getElementById("CantidadDeCompras").innerHTML = CantidadDeCompras;
    document.getElementById("CantidadDeVentas").innerHTML = CantidadDeVentas;
  });
}

function SelectorangodelEstadistica() {
  if (document.getElementById("SelectorDiaMesEstadistica").value === "1") {
    $("#ModaldesdeEstadistica").prop("disabled", true);
    $("#ModalhastaEstadistica").prop("disabled", true);
    var fecha = new Date();
    var mes = fecha.getMonth() + 1;
    var dia = fecha.getDate();
    var ano = fecha.getFullYear();
    if (dia < 10) dia = "0" + dia;
    if (mes < 10) mes = "0" + mes;

    document.getElementById("ModaldesdeEstadistica").value =
      ano + "-" + mes + "-" + dia + "T00:00:00";
    document.getElementById("ModalhastaEstadistica").value =
      ano + "-" + mes + "-" + dia + "T23:59:59";
  }

  if (document.getElementById("SelectorDiaMesEstadistica").value === "2") {
    $("#ModaldesdeEstadistica").prop("disabled", true);
    $("#ModalhastaEstadistica").prop("disabled", true);
    var fecha = new Date();
    var mes = fecha.getMonth() + 1;
    var dia = fecha.getDate() - 1;
    if (dia > fecha.getDate()) mes = fecha.getMonth();
    var ano = fecha.getFullYear();
    if (dia < 10) dia = "0" + dia;
    if (mes < 10) mes = "0" + mes;

    document.getElementById("ModaldesdeEstadistica").value =
      ano + "-" + mes + "-" + dia + "T00:00:00";
    document.getElementById("ModalhastaEstadistica").value =
      ano + "-" + mes + "-" + dia + "T23:59:59";
  }

  if (document.getElementById("SelectorDiaMesEstadistica").value === "3") {
    $("#ModaldesdeEstadistica").prop("disabled", true);
    $("#ModalhastaEstadistica").prop("disabled", true);
    var fecha = new Date();
    var mes = fecha.getMonth() + 1;
    var ano = fecha.getFullYear();
    var dia = fecha.getDate();
    if (mes < 10) mes = "0" + mes;
    var lastDay = new Date(
      fecha.getFullYear(),
      fecha.getMonth() + 1,
      0,
    ).getDate();

    document.getElementById("ModaldesdeEstadistica").value =
      ano + "-" + mes + "-01T00:00:00";
    document.getElementById("ModalhastaEstadistica").value =
      ano + "-" + mes + "-" + lastDay + "T23:59:59";
  }

  if (document.getElementById("SelectorDiaMesEstadistica").value === "4") {
    $("#ModaldesdeEstadistica").prop("disabled", true);
    $("#ModalhastaEstadistica").prop("disabled", true);
    var fecha = new Date(new Date().setMonth(new Date().getMonth() - 1));
    var mes = fecha.getMonth() + 1;
    var ano = fecha.getFullYear();
    var lastDay = new Date(
      fecha.getFullYear(),
      fecha.getMonth() + 1,
      0,
    ).getDate();
    if (mes < 10) mes = "0" + mes;

    document.getElementById("ModaldesdeEstadistica").value =
      ano + "-" + mes + "-01T00:00:00";
    document.getElementById("ModalhastaEstadistica").value =
      ano + "-" + mes + "-" + lastDay + "T23:59:59";
  }

  if (document.getElementById("SelectorDiaMesEstadistica").value === "5") {
    $("#ModaldesdeEstadistica").prop("disabled", false);
    $("#ModalhastaEstadistica").prop("disabled", false);
  }
  RefreshEstProduco();
}

function CambiarUbicacion() {
  $.ajax({
    type: "POST",
    url: "productoseek.php",
    async: false,
    data: {
      Accion: "CambiarUbicacion",
      IdUbi: document.getElementById("SelectorSucursal").value,
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
    },
  }).done(function (msg) {
    $("#AlmacenEntry").html(msg);
  });
  HistoricoSerial2();
}

function alertaborrar(numero, coddel = "", descp = "", codpad = "") {
  if (coddel == "") {
    document.getElementById("CodeDel").innerHTML = numero;
    document.getElementById("desckk").innerHTML = document.getElementById(
      "descripcion" + numero,
    ).innerHTML;
    document.getElementById("delvar").innerHTML = "0";
    document.getElementById("codpadel").innerHTML = "";
  } else {
    document.getElementById("CodeDel").innerHTML = coddel;
    document.getElementById("desckk").innerHTML = descp;
    document.getElementById("delvar").innerHTML = "1";
    document.getElementById("codpadel").innerHTML = codpad;
  }
  $("#apps-delet").modal("show");
}

function alertaborrar2() {
  if (document.getElementById("Estees").innerHTML == 0) {
    var valor3 = "ProductosP1";
  }
  if (document.getElementById("Estees").innerHTML == 9) {
    var valor3 = "ServiciosP1";
  }
  document.getElementById("loading").style.display = "flex";
  var numero = document.getElementById("CodeDel").innerHTML;
  if (document.getElementById("delvar").innerHTML == "1") {
    var delcod = document.getElementById("CodeDel").innerHTML;
  } else {
    var delcod = document.getElementById("codidbasico1" + numero).innerHTML;
  }
  $.ajax({
    type: "POST",
    url: "DataHandler1.php",
    data: {
      borrar: "1",
      ModalCodIdBasico: delcod,
      companyUser: document.getElementById("CompanyActual").innerHTML,
      tabla: valor3,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    if (msg === "1") {
      $("#alertaerrorenproducto2").delay(500).fadeIn("slow");
      setTimeout(() => OcultarNotificacion2(), 4000);
      $("#apps-delet").modal("hide");
      if (document.getElementById("delvar").innerHTML == "1") {
        var tablex = $("#data-table-product2").DataTable();
        tablex.ajax.reload();
        verifvar(document.getElementById("codpadel").innerHTML);
      }
      $("#ServerSideTable").DataTable().ajax.reload(null, false);
    }
    if (msg === "0") {
      document.getElementById("maintop").style.display = "block";
      $("#alertaerrorenproducto5").delay(500).fadeIn("slow");
      setTimeout(() => OcultarNotificacion2(), 3000);
    }
    if (msg === "-0") {
      document.getElementById("elfixed").style.display = "block";
      $("#valida").delay(500).fadeIn("slow");
      document.getElementById("contenido").innerHTML = Utils2a.Desc18;
      setTimeout(() => OcultarNotificacion(), 3000);
    }
  });
}

function buscarunidad() {
  //alert($("#search-box").val());
  $.ajax({
    type: "POST",
    url: "dataseeks/Dataseek2r.php",
    data: {
      keyword: $("#ModalMedida").val(),
      Company: document.getElementById("CompanyActual").innerHTML,
      Accion: "6",
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
    beforeSend: function () {
      $("#ModalMedida").css(
        "background",
        "#FFF url('/img/procesando.gif') no-repeat 165px",
      );
    },
    success: function (data) {
      if (data != "") {
        $("#suggesstion-box").show();
        $("#suggesstion-box").html(data);
      }
      $("#ModalMedida").css("background", "#FFF");
    },
  });
}

function buscarunidad2() {
  //alert($("#search-box").val());
  $.ajax({
    type: "POST",
    url: "dataseeks/Dataseek2r.php",
    data: {
      keyword: $("#ModalEnvase").val(),
      Company: document.getElementById("CompanyActual").innerHTML,
      AC: "1",
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
    beforeSend: function () {
      $("#ModalEnvase").css(
        "background",
        "#FFF url('/img/procesando.gif') no-repeat 165px",
      );
    },
    success: function (data) {
      if (data != "") {
        $("#suggesstion-box2q").show();
        $("#suggesstion-box2q").html(data);
      }
      $("#ModalEnvase").css("background", "#FFF");
    },
  });
}

function selectlist(val) {
  $("#ModalMedida").val(val);
  $("#suggesstion-box").hide();
}

function selectlist2(val) {
  $("#ModalEnvase").val(val);
  $("#suggesstion-box2q").hide();
}

function validaFormMarca() {
  if ($("#ModalNombre").val() == "") {
    document.getElementById("alertaerrorenmarca").innerHTML =
      document.getElementById("Num001").innerHTML;
    $("#alertaerrorenmarca").delay(100).fadeIn("slow");
    setTimeout(() => OcultarNotificacion2(), 5000);
    $("#ModalNombre").focus();
    return false;
  }
  return true;
}

function AddMarca() {
  document.getElementById("ModalIdMarMarca").value = "";
  document.getElementById("ModalIdMar2Marca").value = "";
  document.getElementById("ModalNombreMarca").value = "";
  $("#apps-modal").modal("hide");
  $("#modal-marca").modal("show");
}

function guardarMarcaApa() {
  $.ajax({
    type: "POST",
    url: "marcasnewseek.php",
    data: {
      Accion: "1",
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    $("#Temporal").html(msg);
    if (validaFormMarca()) {
      $.post(
        "marcasnewseek.php",
        $("#formdataMarca").serialize(),
        function (res) {
          document.getElementById("loading").style.display = "flex";
          if (res === "1") {
            setTimeout(() => OcultarNotificacion2(), 4000);
            $("#apps-modal").modal("show");
            $("#modal-marca").modal("hide");
            ActualizarMarca();
          } else if (res === "2") {
            document.getElementById("alertaerrorenmarca").innerHTML =
              document.getElementById("Num002").innerHTML;
            $("#alertaerrorenmarca").delay(100).fadeIn("slow");
            setTimeout(() => {
              OcultarNotificacion2();
              $("#alertaerrorenmarca").hide();
            }, 5000);
            $("#ModalNombre").focus();
            $("#Temporal").html("");
          } else {
            $("#alertaerrorenmarca3").delay(500).fadeIn("slow");
            setTimeout(() => {
              $("#alertaerrorenmarca3").hide();
              OcultarNotificacion2();
            }, 4000);
          }
        },
      );
    }
  });
}

function ActualizarMarca() {
  $.ajax({
    type: "POST",
    url: "productoseek.php",
    data: {
      Accion: "Marca",
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    const array = JSON.parse(msg);
    let html = ``;
    let n = 0;
    let firstMarca = 0;
    const NameMarca = document.getElementById("ModalNombreMarca").value;
    array.forEach((marca) => {
      html += `<option value="${marca.idmarca}" ${
        NameMarca === marca.nombre ? "selected" : ""
      }>${marca.nombre}</option>`;
      if (n === 0) firstMarca = marca.idmarca;
      n++;
    });
    $("#ReloadMarcaSend").html(`
      <select id="ModalMarca" name="ModalMarca" class="form-select">
        ${html}
      </select>
      <span id="RegUnoMarca" style="display:none;">${firstMarca}</span>
      <label><i class="fa fa-tags"></i>&nbsp;Marcas</label>
    `);
  });
}

function AddFamilia() {
  document.getElementById("ModalIdFamilia").value = "";
  document.getElementById("ModalItemFamilia").value = "";
  $(
    "#ModalSerialFamilia, #ordensFamilia, #ModalLoteFamilia, #vntaFamilia, #vntawebFamilia, #compwebFamilia, #esmedFamilia",
  ).prop("checked", false);
  $("#apps-modal").modal("hide");
  $("#modal-familia").modal("show");
}

function validaFormFamilia() {
  if ($("#ModalItemFamilia").val() == "") {
    document.getElementById("alertaerrorenfamilia").innerHTML =
      document.getElementById("Num001").innerHTML;
    $("#alertaerrorenfamilia").delay(100).fadeIn("slow");
    setTimeout(() => OcultarNotificacion2(), 5000);
    $("#ModalItemFamilia").focus();
    $("#Temporal").html("");
    return false;
  }
  return true;
}

function guardarFamilia() {
  $.ajax({
    type: "POST",
    url: "familiasnewseek.php",
    data: {
      Accion: "1",
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    $("#Temporal").html(msg);
    if (validaFormFamilia()) {
      document.getElementById("loading").style.display = "flex";
      $.post(
        "familiasnewseek.php",
        $("#formdataFamilia").serialize(),
        function (res) {
          if (res === "1") {
            $("#alertaerrorenfamilia2").delay(500).fadeIn("slow");
            setTimeout(() => {
              $("#alertaerrorenfamilia").hide();
              OcultarNotificacion2();
            }, 4000);
            ActualizarFamilia();
            $("#modal-familia").modal("hide");
            $("#apps-modal").modal("show");
          } else if (res === "2") {
            document.getElementById("alertaerrorenfamilia").innerHTML =
              document.getElementById("Num002").innerHTML;
            $("#alertaerrorenfamilia").delay(100).fadeIn("slow");
            setTimeout(() => {
              $("#alertaerrorenfamilia").hide();
              OcultarNotificacion2();
            }, 5000);
            $("#ModalItemFamilia").focus();
            $("#Temporal").html("");
          } else {
            $("#alertaerrorenfamilia3").delay(500).fadeIn("slow");
            setTimeout(() => {
              $("#alertaerrorenfamilia3").hide();
              OcultarNotificacion2();
            }, 4000);
          }
        },
      );
    }
  });
}

function ActualizarFamilia() {
  $.ajax({
    type: "POST",
    url: "productoseek.php",
    data: {
      Accion: "Familia",
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
    },
  }).done(function (msg) {
    const array = JSON.parse(msg);
    let html = ``;
    let n = 0;
    let firstFamilia = 0;
    const NameFamilia = document.getElementById("ModalItemFamilia").value;
    array.forEach((familia) => {
      html += `<option value="${familia.IdVarios}" ${
        NameFamilia === familia.ITEM ? "selected" : ""
      }>${familia.ITEM}</option>`;
      if (n === 0) firstFamilia = familia.IdVarios;
      n++;
    });
    $("#ReloadFamiliaSend").html(`
      <select id="ModalIdfamilia" name="ModalIdfamilia" class="form-select" onchange="ChangeWidthHeight();">
        ${html}
      </select>
      <span id="RegUnoMarca" style="display:none;">${firstFamilia}</span>
      <label><i class="fa fa-tags"></i>&nbsp;Familia</label>
    `);
  });
}

function MuestraProd() {
  if ($("#SoloExistencia").prop("checked")) {
    var SoloExistencia = "on";
  } else {
    var SoloExistencia = "";
  }
  var aoColumnDefs = "";
  if (document.getElementById("EleccionEc").innerHTML == "9") {
    aoColumnDefs = [
      {
        bVisible: true,
        aTargets: [1],
      },
    ];
  }

  var table = $("#ServerSideTable")
    .on("search.dt", function (e, settings, processing) {
      $("#spinner_load").removeClass("d-none");
      $(
        "#ServerSideTable_wrapper .dt-layout-row .dt-end .dt-search .dt-input",
      ).focus();
    })
    .DataTable({
      search: {
        search: $(
          `#${"ServerSideTable"}_wrapper .dt-layout-row .dt-end .dt-search .dt-input`,
        ).val(),
      },
      drawCallback: function () {
        $(
          "#ServerSideTable_wrapper .dt-layout-row .dt-end .dt-search .dt-input",
        ).focus();
        $("#spinner_load").addClass("d-none");
      },
      lengthMenu: [
        10,
        50,
        100,
        300,
        {
          label: "*",
          value: -1,
        },
      ],
      searchDelay: 800,
      responsive: false,
      processing: true,
      serverSide: true,
      aoColumnDefs: aoColumnDefs,
      ordering: false,
      language: {
        url: `lang/datatables/${
          document.getElementById("IdiomaActual").innerHTML
        }.json`,
      },
      ajax: {
        type: "POST",
        url: "productoseek.php",
        data: {
          Accion: "0",
          IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
          Peso: document.getElementById("EnvioPeso").value,
          Estado: document.getElementById("EnvioEstado").value,
          userlogin: document.getElementById("userlogin").innerHTML,
          IdCompany: document.getElementById("CompanyActual").innerHTML,
          userperfil: document.getElementById("userperfil").innerHTML,
          EnvioFamilia: $("#EnvioFamilia").val(),
          EnvioMarca: $("#EnvioMarca").val(),
          EnvioAlmacen: $("#EnvioAlmacen").val(),
          EnvioUbicacion: $("#EnvioUbicacion").val(),
          EnvioZonaAtencion: $("#EnvioZonaAtencion").val(),
          FechaActual: GenerarFecha(),
          OrderBy: document.getElementById("OrderBy").value,
          SortBy: document.getElementById("SortBy").value,
          CD: document.getElementById("CD").innerHTML,
          SimDec: document.getElementById("SimDec").innerHTML,
          SimMil: document.getElementById("SimMil").innerHTML,
          IdAlmGroup: document.getElementById("IdAlmGroup").innerHTML,
          EsonoES: document.getElementById("EleccionEc").innerHTML,
          SoloExistencia: SoloExistencia,
          AlmacenesAtt: document.getElementById("AlmacenesAtt").innerHTML,
          IdAlmVtaSeleccionada: document.getElementById("IdAlmVtaSeleccionada")
            .innerHTML,
          IdAlmVta: document.getElementById("IdAlmVta").innerHTML,
          VerStock: document.getElementById("VerStock").innerHTML,
          jsonpedido: document.getElementById("jsonpedido").innerHTML,
          VisualExist: document.getElementById("VisualExist").value,
          PerfilVentas: document.getElementById("PerfilVentas").innerHTML,
          sucursal: document.getElementById("sucursal").innerHTML,
          MonedaP: document.getElementById("MonedaP").innerHTML,
          NotIncludeFamilia:
            document.getElementById("NotIncludeFamilia").checked,
          NotIncludeMarcas: document.getElementById("NotIncludeMarcas").checked,
          NotIncludeAlmacen:
            document.getElementById("NotIncludeAlmacen").checked,
          NotIncludeUbicacion: document.getElementById("NotIncludeUbicacion")
            .checked,
          NotIncludeZonaAtencion: document.getElementById(
            "NotIncludeZonaAtencion",
          ).checked,
        },
      },
      destroy: true,
    });
  setTimeout(() => {
    $(
      "#ServerSideTable_wrapper .dt-layout-row .dt-end .dt-search .dt-input",
    ).focus();
    $("#spinner_load").addClass("d-none");
  }, 800);
  verifsku();
  CantMaxStock();
}

function CantMaxStock() {
  $.ajax({
    type: "POST",
    url: "visualizadorStockseek.php",
    data: {
      Accion: "CantMaxStock",
      EnvioFamilia: $("#EnvioFamilia").val(),
      EnvioMarca: $("#EnvioMarca").val(),
      EnvioAlmacen: $("#EnvioAlmacen").val(),
      EnvioUbicacion: $("#EnvioUbicacion").val(),
      EnvioZonaAtencion: $("#EnvioZonaAtencion").val(),
      NotIncludeFamilia: document.getElementById("NotIncludeFamilia").checked,
      NotIncludeMarcas: document.getElementById("NotIncludeMarcas").checked,
      Peso: document.getElementById("EnvioPeso").value,
      Estado: document.getElementById("EnvioEstado").value,
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      Buscador: $(
        "#ServerSideTable_wrapper .dt-layout-row .dt-end .dt-search .dt-input",
      ).val(),
      EleccionEc: document.getElementById("EleccionEc").innerHTML,
      NotIncludeAlmacen: document.getElementById("NotIncludeAlmacen").checked,
      NotIncludeUbicacion: document.getElementById("NotIncludeUbicacion")
        .checked,
      NotIncludeZonaAtencion: document.getElementById("NotIncludeZonaAtencion")
        .checked,
    },
  }).done(function (msg) {
    const array = JSON.parse(msg);

    const val =
      Number(document.getElementById("userperfil").innerHTML) <= 2000
        ? `<br><span class="badge bg-info text-dark fw-bold" style="font-size: 0.6rem !important;">${
            array.val
          } ${document.getElementById("MonedaP").innerHTML}</span>`
        : ``;

    $("#CantMaxStockAV").html(`${array.cant}${val}`);
  });
}

// $("#ServerSideTable_search")
//   .off()
//   .on("keyup change", function (e) {
//     if (e.keyCode == 13 || this.value == "" || this.value.length > 3) {
//       table.search(this.value).draw();
//       CantMaxStock();
//     }
//   });
/*
$("#ServerSideTable_search").keyup(function () {
  // Obtener el valor actual del campo de entrada
  var valorInput = $(this).val();
  // Verificar si se ha escrito al menos una letra
  if (valorInput.length > 0) {
    // Enviar la solicitud después de escribir la última letra (esperar 500ms después de la última pulsación de tecla)
    setTimeout(() => {
      table.search(this.value).draw();
      CantMaxStock();
    }, 500);
  } else {
    // Limpiar el resultado si el campo de entrada está vacío
    console.log("vacio");
  }
});
*/

function beforePrintHandler() {
  for (let id in Chart.instances) {
    Chart.instances[id].resize();
  }
}

let Estadistica = "";

function EstadisticaProductos(CodIdBasico, Descripcion) {
  Estadistica = CodIdBasico;
  document.getElementById("EstadistProdDes").innerHTML = Descripcion;
  ActualizarProductos();
  $("#ModalEstadisticaProductoABCV").modal("show");
}

function ImprimirMirPrimir() {
  myChart.resize();
  $("#prints").html(document.getElementById("EstCaca").innerHTML);
  window.print();
}

function ActualizarProductos() {
  $.ajax({
    type: "POST",
    url: "productoseek.php",
    data: {
      Accion: "EstadisticaProductox",
      CodIdBasico: Estadistica,
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
      MostrarDatosA: document.getElementById("MostrarDatosA").value,
    },
  }).done(function (msg) {
    $("#EstCaca").html(msg);
  });
}

function loadtable2(Id) {
  $("#data-table-product2").DataTable().clear().destroy();
  if (document.getElementById("EleccionEc").innerHTML == "9") {
    MOSTRAR = $("#data-table-product2").DataTable({
      search: {
        search: $(
          `#${"data-table-product2"}_wrapper .dt-layout-row .dt-end .dt-search .dt-input`,
        ).val(),
      },
      responsive: true,
      processing: true,
      serverSide: true,
      retrieve: true,
      bFilter: false,
      bLengthChange: false,
      aoColumnDefs: [
        {
          bVisible: false,
          aTargets: [1],
        },
      ],
      language: {
        url: `lang/datatables/${
          document.getElementById("IdiomaActual").innerHTML
        }.json`,
      },
      ajax: {
        type: "POST",
        url: "productoseek.php",
        data: {
          CodIdBasicoPadre: Id,
          IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
          go: "table-products2",
          Peso: document.getElementById("EnvioPeso").value,
          Estado: document.getElementById("EnvioEstado").value,
          IdCompany: document.getElementById("CompanyActual").innerHTML,
          userperfil: document.getElementById("userperfil").innerHTML,
          CD: document.getElementById("CD").innerHTML,
          SimDec: document.getElementById("SimDec").innerHTML,
          SimMil: document.getElementById("SimMil").innerHTML,
          MonedaP: document.getElementById("MonedaP").innerHTML,
          MonedaS: document.getElementById("MonedaS").innerHTML,
          EsonoES: document.getElementById("EleccionEc").innerHTML,
          PerfilVentas: document.getElementById("PerfilVentas").innerHTML,
        },
      },
      aoColumnDefs: [
        {
          sClass: "text-start",
          aTargets: [0],
        },
        {
          sClass: "text-center",
          aTargets: [1],
        },
      ],
      columns: [
        {
          orderable: false,
        },
        {
          orderable: false,
        },
      ],
      destroy: true,
    });
  } else {
    MOSTRAR = $("#data-table-product2").DataTable({
      search: {
        search: $(
          `#${"data-table-product2"}_wrapper .dt-layout-row .dt-end .dt-search .dt-input`,
        ).val(),
      },
      responsive: true,
      processing: true,
      serverSide: true,
      retrieve: true,
      bFilter: false,
      bLengthChange: false,
      language: {
        url: `lang/datatables/${
          document.getElementById("IdiomaActual").innerHTML
        }.json`,
      },
      ajax: {
        type: "POST",
        url: "productoseek.php",
        data: {
          CodIdBasicoPadre: Id,
          go: "table-products2",
          Peso: document.getElementById("EnvioPeso").value,
          Estado: document.getElementById("EnvioEstado").value,
          IdCompany: document.getElementById("CompanyActual").innerHTML,
          userperfil: document.getElementById("userperfil").innerHTML,
          EsonoES: document.getElementById("EleccionEc").innerHTML,
          CD: document.getElementById("CD").innerHTML,
          SimDec: document.getElementById("SimDec").innerHTML,
          SimMil: document.getElementById("SimMil").innerHTML,
          MonedaP: document.getElementById("MonedaP").innerHTML,
          MonedaS: document.getElementById("MonedaS").innerHTML,
          PerfilVentas: document.getElementById("PerfilVentas").innerHTML,
        },
      },
      aoColumnDefs: [
        {
          sClass: "text-start",
          aTargets: [0],
        },
        {
          sClass: "text-center",
          aTargets: [1],
        },
      ],
      columns: [
        {
          orderable: false,
        },
        {
          orderable: false,
        },
      ],
      destroy: true,
    });
  }
}

function verifsku() {
  $.ajax({
    type: "POST",
    url: "dataseeks/Dataseek2r.php",
    data: {
      Accion: "SKU-VERIF",
      company: document.getElementById("CompanyActual").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    if (msg == "1") {
      var element = document.getElementById("btn-agg");
      element.classList.remove("d-none");
    } else {
      var element = document.getElementById("btn-agg");
      element.classList.add("d-none");
    }
  });
}

function validaForm(go) {
  if ($("#ModalDescripcion" + go).val() == "") {
    document.getElementById(
      "alertaerrorenproducto" + go,
    ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Falta_Información}</strong><br><small>${Utils2a.Desc19}</small>`;
    $("#alertaerrorenproducto" + go)
      .delay(100)
      .fadeIn("slow");
    setTimeout(() => OcultarNotificacion2(go), 5000);
    $("#Costos2" + go).removeClass("active");
    $("#Costos" + go).removeClass("show active");
    $("#Inventario2" + go).removeClass("active");
    $("#Inventario" + go).removeClass("show active");
    $("#Informacion2" + go).addClass("active");
    $("#Informacion" + go).addClass("show active");
    $("#ModalDescripcion" + go).focus();
    return false;
  }
  if (document.getElementById("ModalIdfamilia" + go).innerHTML.trim() == "") {
    document.getElementById(
      "alertaerrorenproducto" + go,
    ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Falta_Información}</strong><br><small>${Utils2a.Desc20}</small>`;
    $("#alertaerrorenproducto" + go)
      .delay(100)
      .fadeIn("slow");
    setTimeout(() => OcultarNotificacion2(), 5000);
    $("#Costos2" + go).removeClass("active");
    $("#Costos" + go).removeClass("show active");
    $("#Inventario2" + go).removeClass("active");
    $("#Inventario" + go).removeClass("show active");
    $("#Informacion2" + go).addClass("active");
    $("#Informacion" + go).addClass("show active");
    $("#ModalIdfamilia" + go).focus();
    return false;
  }
  if (
    (isNaN(document.getElementById("ModalHeight" + go).value) ||
      document.getElementById("ModalHeight" + go).value <= 0) &&
    document.getElementById(
      "ModalIdfamilia" + go + "Span" + (go === "S" ? IdfamiliaS : Idfamilia),
    ).innerHTML == 1
  ) {
    document.getElementById(
      "alertaerrorenproducto" + go,
    ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Desc21}</strong><br><small>${Utils2a.Desc22}</small>`;
    $("#alertaerrorenproducto" + go)
      .delay(100)
      .fadeIn("slow");
    setTimeout(() => OcultarNotificacion2(), 5000);
    $("#Costos2" + go).removeClass("active");
    $("#Costos" + go).removeClass("show active");
    $("#Inventario2" + go).addClass("active");
    $("#Inventario" + go).addClass("show active");
    $("#Informacion2" + go).removeClass("active");
    $("#Informacion" + go).removeClass("show active");
    $("#ModalHeight" + go).focus();
    return false;
  }
  if (
    (isNaN(document.getElementById("ModalWeight" + go).value) ||
      document.getElementById("ModalWeight" + go).value <= 0) &&
    document.getElementById(
      "ModalIdfamilia" + go + "Span" + (go === "S" ? IdfamiliaS : Idfamilia),
    ).innerHTML == 1
  ) {
    document.getElementById(
      "alertaerrorenproducto" + go,
    ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Desc23}</strong><br><small>${Utils2a.Desc24}</small>`;
    $("#alertaerrorenproducto" + go)
      .delay(100)
      .fadeIn("slow");
    setTimeout(() => OcultarNotificacion2(), 5000);
    $("#Costos2" + go).removeClass("active");
    $("#Costos" + go).removeClass("show active");
    $("#Inventario2" + go).addClass("active");
    $("#Inventario" + go).addClass("show active");
    $("#Informacion2" + go).removeClass("active");
    $("#Informacion" + go).removeClass("show active");
    $("#ModalWeight" + go).focus();
    return false;
  }
  if (
    (isNaN(document.getElementById("ModalArea" + go).value) ||
      document.getElementById("ModalArea" + go).value <= 0) &&
    document.getElementById(
      "ModalIdfamilia" + go + "Span" + (go === "S" ? IdfamiliaS : Idfamilia),
    ).innerHTML == 1
  ) {
    document.getElementById(
      "alertaerrorenproducto" + go,
    ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Desc25}</strong><br><small>${Utils2a.Desc26}</small>`;
    $("#alertaerrorenproducto" + go)
      .delay(100)
      .fadeIn("slow");
    setTimeout(() => OcultarNotificacion2(), 5000);
    $("#Costos2" + go).removeClass("active");
    $("#Costos" + go).removeClass("show active");
    $("#Inventario2" + go).addClass("active");
    $("#Inventario" + go).addClass("show active");
    $("#Informacion2" + go).removeClass("active");
    $("#Informacion" + go).removeClass("show active");
    $("#ModalArea" + go).focus();
    return false;
  }
  if (document.getElementById("ModalMarca" + go).innerHTML.trim() == "") {
    document.getElementById(
      "alertaerrorenproducto" + go,
    ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Falta_Información}</strong><br><small>${Utils2a.Desc27}</small>`;
    $("#alertaerrorenproducto" + go)
      .delay(100)
      .fadeIn("slow");
    setTimeout(() => OcultarNotificacion2(), 5000);
    $("#Costos2" + go).removeClass("active");
    $("#Costos" + go).removeClass("show active");
    $("#Inventario2" + go).removeClass("active");
    $("#Inventario" + go).removeClass("show active");
    $("#Informacion2" + go).addClass("active");
    $("#Informacion" + go).addClass("show active");
    $("#ModalMarca" + go).focus();
    return false;
  }
  if ($("#ModalCostos" + go).val() == "") {
    document.getElementById(
      "alertaerrorenproducto" + go,
    ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Falta_Información}</strong><br><small>${Utils2a.Desc28}</small>`;
    $("#alertaerrorenproducto" + go)
      .delay(100)
      .fadeIn("slow");
    setTimeout(() => OcultarNotificacion2(), 5000);
    $("#Informacion2" + go).removeClass("active");
    $("#Informacion" + go).removeClass("show active");
    $("#Inventario2" + go).removeClass("active");
    $("#Inventario" + go).removeClass("show active");
    $("#Costos2" + go).addClass("active");
    $("#Costos" + go).addClass("show active");
    $("#ModalCostos" + go).focus();
    return false;
  }
  if ($("#ModalMargen" + go).val() == "") {
    document.getElementById(
      "alertaerrorenproducto" + go,
    ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Falta_Información}</strong><br><small>${Utils2a.Desc29}</small>`;
    $("#alertaerrorenproducto").delay(100).fadeIn("slow");
    setTimeout(() => OcultarNotificacion2(), 5000);
    $("#Informacion2" + go).removeClass("active");
    $("#Informacion" + go).removeClass("show active");
    $("#Inventario2" + go).removeClass("active");
    $("#Inventario" + go).removeClass("show active");
    $("#Costos2" + go).addClass("active");
    $("#Costos" + go).addClass("show active");
    $("#ModalMargen" + go).focus();
    return false;
  }
  if ($("#ModalPrecioVenta" + go).val() == "") {
    document.getElementById(
      "alertaerrorenproducto" + go,
    ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Falta_Información}</strong><br><small>${Utils2a.Desc30}</small>`;
    $("#alertaerrorenproducto" + go)
      .delay(100)
      .fadeIn("slow");
    setTimeout(() => OcultarNotificacion2(go), 5000);
    $("#Informacion2" + go).removeClass("active");
    $("#Informacion" + go).removeClass("show active");
    $("#Inventario2" + go).removeClass("active");
    $("#Inventario" + go).removeClass("show active");
    $("#Costos2" + go).addClass("active");
    $("#Costos" + go).addClass("show active");
    $("#ModalPrecioVenta" + go).focus();
    return false;
  }
  if ($("#ModalCostoNeto" + go).val() == "") {
    document.getElementById(
      "alertaerrorenproducto" + go,
    ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Falta_Información}</strong><br><small>${Utils2a.Desc31}</small>`;
    $("#alertaerrorenproducto" + go)
      .delay(100)
      .fadeIn("slow");
    setTimeout(() => OcultarNotificacion2(go), 5000);
    $("#Informacion2" + go).removeClass("active");
    $("#Informacion" + go).removeClass("show active");
    $("#Inventario2" + go).removeClass("active");
    $("#Inventario" + go).removeClass("show active");
    $("#Costos2" + go).addClass("active");
    $("#Costos" + go).addClass("show active");
    $("#ModalCostoNeto" + go).focus();
    return false;
  }
  if ($("#ModalPrecioNeto" + go).val() == "") {
    document.getElementById(
      "alertaerrorenproducto" + go,
    ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Falta_Información}</strong><br><small>${Utils2a.Desc32}</small>`;
    $("#alertaerrorenproducto" + go)
      .delay(100)
      .fadeIn("slow");
    setTimeout(() => OcultarNotificacion2(), 5000);
    $("#Informacion2" + go).removeClass("active");
    $("#Informacion" + go).removeClass("show active");
    $("#Inventario2" + go).removeClass("active");
    $("#Inventario" + go).removeClass("show active");
    $("#Costos2" + go).addClass("active");
    $("#Costos" + go).addClass("show active");
    $("#ModalPrecioNeto" + go).focus();
    return false;
  }
  if (
    Number(document.getElementById("ModalPrecioNeto" + go).value) <
      Number(document.getElementById("ModalCostos" + go).value) &&
    Number(document.getElementById("ModalPrecioNeto" + go).value) !== 0
  ) {
    document.getElementById(
      "alertaerrorenproducto" + go,
    ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Num001.title}</strong><br><small>${Utils2a.Num001.desc}</small>`;
    $("#alertaerrorenproducto" + go)
      .delay(100)
      .fadeIn("slow");
    setTimeout(() => OcultarNotificacion2(), 5000);
    $("#Informacion2" + go).removeClass("active");
    $("#Informacion" + go).removeClass("show active");
    $("#Inventario2" + go).removeClass("active");
    $("#Inventario" + go).removeClass("show active");
    $("#Costos2" + go).addClass("active");
    $("#Costos" + go).addClass("show active");
    $("#ModalPrecioNeto" + go).focus();
    return false;
  }
  if (
    Number(document.getElementById("ModalPrecioNeto2" + go).value) <
      Number(document.getElementById("ModalCostos" + go).value) &&
    Number(document.getElementById("ModalPrecioNeto2" + go).value) !== 0
  ) {
    document.getElementById(
      "alertaerrorenproducto" + go,
    ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Num001.title}</strong><br><small>${Utils2a.Num001.desc}</small>`;
    $("#alertaerrorenproducto" + go)
      .delay(100)
      .fadeIn("slow");
    setTimeout(() => OcultarNotificacion2(), 5000);
    $("#Informacion2" + go).removeClass("active");
    $("#Informacion" + go).removeClass("show active");
    $("#Inventario2" + go).removeClass("active");
    $("#Inventario" + go).removeClass("show active");
    $("#Costos2" + go).addClass("active");
    $("#Costos" + go).addClass("show active");
    $("#ModalPrecioNeto2" + go).focus();
    return false;
  }
  if (
    Number(document.getElementById("ModalPrecioNeto3" + go).value) <
      Number(document.getElementById("ModalCostos" + go).value) &&
    Number(document.getElementById("ModalPrecioNeto3" + go).value) !== 0
  ) {
    document.getElementById(
      "alertaerrorenproducto" + go,
    ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Num001.title}</strong><br><small>${Utils2a.Num001.desc}</small>`;
    $("#alertaerrorenproducto" + go)
      .delay(100)
      .fadeIn("slow");
    setTimeout(() => OcultarNotificacion2(), 5000);
    $("#Informacion2" + go).removeClass("active");
    $("#Informacion" + go).removeClass("show active");
    $("#Inventario2" + go).removeClass("active");
    $("#Inventario" + go).removeClass("show active");
    $("#Costos2" + go).addClass("active");
    $("#Costos" + go).addClass("show active");
    $("#ModalPrecioNeto3" + go).focus();
    return false;
  }
  if (
    Number(document.getElementById("ModalPrecioNeto4" + go).value) <
      Number(document.getElementById("ModalCostos" + go).value) &&
    Number(document.getElementById("ModalPrecioNeto4" + go).value) !== 0
  ) {
    document.getElementById(
      "alertaerrorenproducto" + go,
    ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Num001.title}</strong><br><small>${Utils2a.Num001.desc}</small>`;
    $("#alertaerrorenproducto" + go)
      .delay(100)
      .fadeIn("slow");
    setTimeout(() => OcultarNotificacion2(), 5000);
    $("#Informacion2" + go).removeClass("active");
    $("#Informacion" + go).removeClass("show active");
    $("#Inventario2" + go).removeClass("active");
    $("#Inventario" + go).removeClass("show active");
    $("#Costos2" + go).addClass("active");
    $("#Costos" + go).addClass("show active");
    $("#ModalPrecioNeto4" + go).focus();
    return false;
  }
  if (
    Number(document.getElementById("ModalPrecioNeto5" + go).value) <
      Number(document.getElementById("ModalCostos" + go).value) &&
    Number(document.getElementById("ModalPrecioNeto5" + go).value) !== 0
  ) {
    document.getElementById(
      "alertaerrorenproducto" + go,
    ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Num001.title}</strong><br><small>${Utils2a.Num001.desc}</small>`;
    $("#alertaerrorenproducto" + go)
      .delay(100)
      .fadeIn("slow");
    setTimeout(() => OcultarNotificacion2(), 5000);
    $("#Informacion2" + go).removeClass("active");
    $("#Informacion" + go).removeClass("show active");
    $("#Inventario2" + go).removeClass("active");
    $("#Inventario" + go).removeClass("show active");
    $("#Costos2" + go).addClass("active");
    $("#Costos" + go).addClass("show active");
    $("#ModalPrecioNeto5" + go).focus();
    return false;
  }
  if (
    Number(document.getElementById("ModalPrecioNeto6" + go).value) <
      Number(document.getElementById("ModalCostos" + go).value) &&
    Number(document.getElementById("ModalPrecioNeto6" + go).value) !== 0
  ) {
    document.getElementById(
      "alertaerrorenproducto" + go,
    ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Num001.title}</strong><br><small>${Utils2a.Num001.desc}</small>`;
    $("#alertaerrorenproducto" + go)
      .delay(100)
      .fadeIn("slow");
    setTimeout(() => OcultarNotificacion2(), 5000);
    $("#Informacion2" + go).removeClass("active");
    $("#Informacion" + go).removeClass("show active");
    $("#Inventario2" + go).removeClass("active");
    $("#Inventario" + go).removeClass("show active");
    $("#Costos2" + go).addClass("active");
    $("#Costos" + go).addClass("show active");
    $("#ModalPrecioNeto6" + go).focus();
    return false;
  }
  if (
    Number(document.getElementById("ModalPrecioNeto7" + go).value) <
      Number(document.getElementById("ModalCostos" + go).value) &&
    Number(document.getElementById("ModalPrecioNeto7" + go).value) !== 0
  ) {
    document.getElementById(
      "alertaerrorenproducto" + go,
    ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Num001.title}</strong><br><small>${Utils2a.Num001.desc}</small>`;
    $("#alertaerrorenproducto" + go)
      .delay(100)
      .fadeIn("slow");
    setTimeout(() => OcultarNotificacion2(), 5000);
    $("#Informacion2" + go).removeClass("active");
    $("#Informacion" + go).removeClass("show active");
    $("#Inventario2" + go).removeClass("active");
    $("#Inventario" + go).removeClass("show active");
    $("#Costos2" + go).addClass("active");
    $("#Costos" + go).addClass("show active");
    $("#ModalPrecioNeto7" + go).focus();
    return false;
  }
  if (
    Number(document.getElementById("ModalPrecioNeto8" + go).value) <
      Number(document.getElementById("ModalCostos" + go).value) &&
    Number(document.getElementById("ModalPrecioNeto8" + go).value) !== 0
  ) {
    document.getElementById(
      "alertaerrorenproducto" + go,
    ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Num001.title}</strong><br><small>${Utils2a.Num001.desc}</small>`;
    $("#alertaerrorenproducto" + go)
      .delay(100)
      .fadeIn("slow");
    setTimeout(() => OcultarNotificacion2(), 5000);
    $("#Informacion2" + go).removeClass("active");
    $("#Informacion" + go).removeClass("show active");
    $("#Inventario2" + go).removeClass("active");
    $("#Inventario" + go).removeClass("show active");
    $("#Costos2" + go).addClass("active");
    $("#Costos" + go).addClass("show active");
    $("#ModalPrecioNeto8" + go).focus();
    return false;
  }
  if (
    Number(document.getElementById("ModalPrecioNeto9" + go).value) <
      Number(document.getElementById("ModalCostos" + go).value) &&
    Number(document.getElementById("ModalPrecioNeto9" + go).value) !== 0
  ) {
    document.getElementById(
      "alertaerrorenproducto" + go,
    ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Num001.title}</strong><br><small>${Utils2a.Num001.desc}</small>`;
    $("#alertaerrorenproducto" + go)
      .delay(100)
      .fadeIn("slow");
    setTimeout(() => OcultarNotificacion2(), 5000);
    $("#Informacion2" + go).removeClass("active");
    $("#Informacion" + go).removeClass("show active");
    $("#Inventario2" + go).removeClass("active");
    $("#Inventario" + go).removeClass("show active");
    $("#Costos2" + go).addClass("active");
    $("#Costos" + go).addClass("show active");
    $("#ModalPrecioNeto9" + go).focus();
    return false;
  }
  if (
    Number(document.getElementById("ModalPrecioNeto10" + go).value) <
      Number(document.getElementById("ModalCostos" + go).value) &&
    Number(document.getElementById("ModalPrecioNeto10" + go).value) !== 0
  ) {
    document.getElementById(
      "alertaerrorenproducto" + go,
    ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Num001.title}</strong><br><small>${Utils2a.Num001.desc}</small>`;
    $("#alertaerrorenproducto" + go)
      .delay(100)
      .fadeIn("slow");
    setTimeout(() => OcultarNotificacion2(), 5000);
    $("#Informacion2" + go).removeClass("active");
    $("#Informacion" + go).removeClass("show active");
    $("#Inventario2" + go).removeClass("active");
    $("#Inventario" + go).removeClass("show active");
    $("#Costos2" + go).addClass("active");
    $("#Costos" + go).addClass("show active");
    $("#ModalPrecioNeto10" + go).focus();
    return false;
  }

  if (document.getElementById("ModalImpuestos" + go).innerHTML.trim() == "") {
    document.getElementById(
      "alertaerrorenproducto" + go,
    ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Falta_Información}</strong><br><small>${Utils2a.Desc33}</small>`;
    $("#alertaerrorenproducto" + go)
      .delay(100)
      .fadeIn("slow");
    setTimeout(() => OcultarNotificacion2(go), 5000);
    $("#Informacion2" + go).removeClass("active");
    $("#Informacion" + go).removeClass("show active");
    $("#Inventario2" + go).removeClass("active");
    $("#Inventario" + go).removeClass("show active");
    $("#Costos2" + go).addClass("active");
    $("#Costos" + go).addClass("show active");
    $("#ModalImpuestos" + go).focus();
    return false;
  }
  if (
    Number(document.getElementById("ModalMin" + go).value) >
    Number(document.getElementById("ModalMax" + go).value)
  ) {
    document.getElementById(
      "alertaerrorenproducto" + go,
    ).innerHTML = `<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(1)" aria-label="Close"><span class="fa fa-close"></span></button></div></div><strong><i class="fa fa-exclamation-triangle text-warning"></i> ${Utils2a.Falta_Información}</strong><br><small>${Utils2a.Desc34}</small>`;
    $("#alertaerrorenproducto" + go)
      .delay(100)
      .fadeIn("slow");
    setTimeout(() => OcultarNotificacion2(), 5000);
    $("#Informacion2" + go).removeClass("active");
    $("#Informacion" + go).removeClass("show active");
    $("#Costos2" + go).removeClass("active");
    $("#Costos" + go).removeClass("show active");
    $("#Inventario2" + go).addClass("active");
    $("#Inventario" + go).addClass("show active");
    $("#ModalMin" + go).focus();
    return false;
  }
  return true;
}

function CerrarNotificacion(n) {
  if (n == 1) {
    $("#alertaerrorenproducto").hide();
  }
  if (n == 2) {
    $("#errorsobrejson").hide();
  }
}

function recibir(n, onvar) {
  $("#Informacion").addClass("active");
  $("#Informacion2").addClass("active");
  $("#apps-modal").modal("show");
  $("#Costos").removeClass("active");
  $("#Costos2").removeClass("active");
  $("#Inventario").removeClass("active");
  $("#Inventario2").removeClass("active");
  $("#Variaciones").removeClass("active");
  $("#Variaciones2").removeClass("active");
  xd(n, onvar);
}

function recibirvar(n, onvar) {
  $("#Informacion").addClass("active");
  $("#Informacion2").addClass("active");
  $("#apps-modal").modal("show");
  $("#Costos").removeClass("active");
  $("#Costos2").removeClass("active");
  $("#Inventario").removeClass("active");
  $("#Inventario2").removeClass("active");
  $("#Variaciones").removeClass("active");
  $("#Variaciones2").removeClass("active");
  varinfo(n, onvar);
}

function varinfo(numero, onvar = 1) {
  IdActS = numero;

  $("#Variaciones2S").removeClass("active");
  $("#VariacionesS").removeClass("active");
  $("#Information").addClass("active");
  $("#Information2").addClass("active");

  $("#apps-modalS").modal("show");
  document.getElementById("titlemodalS").innerHTML = Utils2a.Agregar_Variacion;

  $("#suggesstion-boxS").hide();
  $("#ModalCodIdBasicoPadreS").val($("#codpadSS" + numero).html());
  document.getElementById("titlemodal").innerHTML = Utils2a.Editar_Variacion;

  valor = document.getElementById("porkilo" + numero).innerHTML;
  if (document.getElementById("Estees").innerHTML == "0") {
    if (valor === "1") {
      $("#ModalPorKilo").prop("checked", true);
    } else {
      $("#ModalPorKilo").prop("checked", false);
    }
  }
  valor = document.getElementById("estado" + numero).innerHTML;
  if (valor === "1") {
    $("#ModalEstado").prop("checked", true);
  } else {
    $("#ModalEstado").prop("checked", false);
  }
  viewtags(
    document.getElementById("codidbasico1SS" + numero).innerHTML,
    "2",
    "2",
  );
  document.getElementById("ComisionS").value = document.getElementById(
    "comSS" + numero,
  ).innerHTML;
  document.getElementById("Comision2S").value = document.getElementById(
    "comdSS" + numero,
  ).innerHTML;
  document.getElementById("Comision3S").value = document.getElementById(
    "comtSS" + numero,
  ).innerHTML;
  document.getElementById("Comision4S").value = document.getElementById(
    "comcuaSS" + numero,
  ).innerHTML;
  document.getElementById("Comision5S").value = document.getElementById(
    "com5SS" + numero,
  ).innerHTML;
  document.getElementById("Comision6S").value = document.getElementById(
    "com6SS" + numero,
  ).innerHTML;
  document.getElementById("Comision7S").value = document.getElementById(
    "com7SS" + numero,
  ).innerHTML;
  document.getElementById("Comision8S").value = document.getElementById(
    "com8SS" + numero,
  ).innerHTML;
  document.getElementById("Comision9S").value = document.getElementById(
    "com9SS" + numero,
  ).innerHTML;
  document.getElementById("Comision10S").value = document.getElementById(
    "com10SS" + numero,
  ).innerHTML;
  document.getElementById("ModalCodIdAmpliadoS").value =
    document.getElementById("codidampliadoSS" + numero).innerHTML;
  document.getElementById("ModalDescripcionS").value = document.getElementById(
    "descripcionSS" + numero,
  ).innerHTML;
  document.getElementById("ModalMedidaS").value = document.getElementById(
    "medidaSS" + numero,
  ).innerHTML;
  document.getElementById("ModalMedidasS").value = document.getElementById(
    "medidaSS" + numero,
  ).innerHTML;
  document.getElementById("ModalMargen2S").value = document.getElementById(
    "Margen200SS" + numero,
  ).innerHTML;
  document.getElementById("ModalPrecioVenta2S").value = document.getElementById(
    "PrecioVenta2SS" + numero,
  ).innerHTML;
  document.getElementById("ModalPrecioNeto2S").value = document.getElementById(
    "PrecioNeto2SS" + numero,
  ).innerHTML;
  document.getElementById("ModalMargen3S").value = document.getElementById(
    "Margen3SS" + numero,
  ).innerHTML;
  document.getElementById("ModalPrecioVenta3S").value = document.getElementById(
    "PrecioVenta3SS" + numero,
  ).innerHTML;
  document.getElementById("ModalPrecioNeto3S").value = document.getElementById(
    "PrecioNeto3SS" + numero,
  ).innerHTML;
  document.getElementById("ModalMargen4S").value = document.getElementById(
    "Margen4SS" + numero,
  ).innerHTML;
  document.getElementById("ModalPrecioVenta4S").value = document.getElementById(
    "PrecioVenta4SS" + numero,
  ).innerHTML;
  document.getElementById("ModalPrecioNeto4S").value = document.getElementById(
    "PrecioNeto4SS" + numero,
  ).innerHTML;

  document.getElementById("ModalMargen5S").value = document.getElementById(
    "Margen5SS" + numero,
  ).innerHTML;
  document.getElementById("ModalPrecioVenta5S").value = document.getElementById(
    "PrecioVenta5SS" + numero,
  ).innerHTML;
  document.getElementById("ModalPrecioNeto5S").value = document.getElementById(
    "PrecioNeto5SS" + numero,
  ).innerHTML;

  document.getElementById("ModalMargen6S").value = document.getElementById(
    "Margen6SS" + numero,
  ).innerHTML;
  document.getElementById("ModalPrecioVenta6S").value = document.getElementById(
    "PrecioVenta6SS" + numero,
  ).innerHTML;
  document.getElementById("ModalPrecioNeto6S").value = document.getElementById(
    "PrecioNeto6SS" + numero,
  ).innerHTML;

  document.getElementById("ModalMargen7S").value = document.getElementById(
    "Margen7SS" + numero,
  ).innerHTML;
  document.getElementById("ModalPrecioVenta7S").value = document.getElementById(
    "PrecioVenta7SS" + numero,
  ).innerHTML;
  document.getElementById("ModalPrecioNeto7S").value = document.getElementById(
    "PrecioNeto7SS" + numero,
  ).innerHTML;

  document.getElementById("ModalMargen8S").value = document.getElementById(
    "Margen8SS" + numero,
  ).innerHTML;
  document.getElementById("ModalPrecioVenta8S").value = document.getElementById(
    "PrecioVenta8SS" + numero,
  ).innerHTML;
  document.getElementById("ModalPrecioNeto8S").value = document.getElementById(
    "PrecioNeto8SS" + numero,
  ).innerHTML;

  document.getElementById("ModalMargen9S").value = document.getElementById(
    "Margen9SS" + numero,
  ).innerHTML;
  document.getElementById("ModalPrecioVenta9S").value = document.getElementById(
    "PrecioVenta9SS" + numero,
  ).innerHTML;
  document.getElementById("ModalPrecioNeto9S").value = document.getElementById(
    "PrecioNeto9SS" + numero,
  ).innerHTML;

  document.getElementById("ModalMargen10S").value = document.getElementById(
    "Margen10SS" + numero,
  ).innerHTML;
  document.getElementById("ModalPrecioVenta10S").value =
    document.getElementById("PrecioVenta10SS" + numero).innerHTML;
  document.getElementById("ModalPrecioNeto10S").value = document.getElementById(
    "PrecioNeto10SS" + numero,
  ).innerHTML;

  document.getElementById("ModalCodIdBasico02S").value =
    document.getElementById("codidbasico1SS" + numero).innerHTML;
  document.getElementById("ModalCostosS").value = document.getElementById(
    "costonetoSS" + numero,
  ).innerHTML;
  document.getElementById("ModalMargenS").value = document.getElementById(
    "margen1SS" + numero,
  ).innerHTML;
  document.getElementById("ModalDescripcion2S").value = document.getElementById(
    "descripcionSS" + numero,
  ).innerHTML;
  document.getElementById("ModalCostoNetoS").value = document.getElementById(
    "costoSS" + numero,
  ).innerHTML;
  document.getElementById("ModalPrecioNetoS").value = document.getElementById(
    "precioneto1SS" + numero,
  ).innerHTML;
  document.getElementById("ModalPrecioVentaS").value = document.getElementById(
    "preciodeventa2SS" + numero,
  ).innerHTML;
  document.getElementById("ModalCodIdBasico3S").value = document.getElementById(
    "codidbasico1SS" + numero,
  ).innerHTML;
  // document.getElementById("serialesspan").innerHTML = document.getElementById("ModalCodIdBasico3S").value;
  document.getElementById("jsonEtiquetasS").innerHTML = document.getElementById(
    "envaseSS" + numero,
  ).innerHTML;
  document.getElementById("ModalEnvaseS").value = "";
  Actualizar("S");
  document.getElementById("ModalDescripcion3S").value = document.getElementById(
    "descripcionSS" + numero,
  ).innerHTML;
  document.getElementById("ModalMinS").value = document.getElementById(
    "minSS" + numero,
  ).innerHTML;
  document.getElementById("ModalMaxS").value = document.getElementById(
    "maxSS" + numero,
  ).innerHTML;
  document.getElementById("ModalCodIdBasico3S").value = document.getElementById(
    "codidbasico1SS" + numero,
  ).innerHTML;
  document.getElementById("ModalCodIdBasicoS").value = document.getElementById(
    "codidbasico1SS" + numero,
  ).innerHTML;
  document.getElementById("ModalDescripcion3S").readOnly = true;
  document.getElementById("ModalCodIdBasico3S").readOnly = true;
  document.getElementById("ModalCodIdBasicoS").readOnly = true;
  document.getElementById("ModalCodIdAmpliadoS").readOnly = false;
  document.getElementById("ModalMarcaS").value = document.getElementById(
    "marcaSS" + numero,
  ).innerHTML;
  document.getElementById("ModalIdfamiliaS").value = document.getElementById(
    "idfamiliaSS" + numero,
  ).innerHTML;
  document.getElementById("ModalImpuestosS").value = document.getElementById(
    "impuestoSS" + numero,
  ).innerHTML;

  ChangeWidthHeightS();
  document.getElementById("ModalAreaS").value = document.getElementById(
    "factorunitxSS" + numero,
  ).innerHTML;
  document.getElementById("ModalWeightS").value = document.getElementById(
    "anchoxSS" + numero,
  ).innerHTML;
  document.getElementById("ModalHeightS").value = document.getElementById(
    "altoxSS" + numero,
  ).innerHTML;
  document.getElementById("ModalMedida2S").value = document.getElementById(
    "UnidadP1xSS" + numero,
  ).innerHTML;
  document.getElementById("ModalCant2S").value = document.getElementById(
    "CantP1xSS" + numero,
  ).innerHTML;
  document.getElementById("ModalMedida3S").value = document.getElementById(
    "UnidadP2xSS" + numero,
  ).innerHTML;
  document.getElementById("ModalCant3S").value = document.getElementById(
    "CantP2SS" + numero,
  ).innerHTML;
  document.getElementById("ModalMedida4S").value = document.getElementById(
    "UnidadP4xSS" + numero,
  ).innerHTML;
  document.getElementById("ModalCant4S").value = document.getElementById(
    "CantP4SS" + numero,
  ).innerHTML;

  document.getElementById("ModalMedida5S").value = document.getElementById(
    "UnidadP5xSS" + numero,
  ).innerHTML;
  document.getElementById("ModalCant5S").value = document.getElementById(
    "CantP5SS" + numero,
  ).innerHTML;

  document.getElementById("ModalMedida6S").value = document.getElementById(
    "UnidadP6xSS" + numero,
  ).innerHTML;
  document.getElementById("ModalCant6S").value = document.getElementById(
    "CantP6SS" + numero,
  ).innerHTML;

  document.getElementById("ModalMedida7S").value = document.getElementById(
    "UnidadP7xSS" + numero,
  ).innerHTML;
  document.getElementById("ModalCant7S").value = document.getElementById(
    "CantP7SS" + numero,
  ).innerHTML;

  document.getElementById("ModalMedida8S").value = document.getElementById(
    "UnidadP8xSS" + numero,
  ).innerHTML;
  document.getElementById("ModalCant8S").value = document.getElementById(
    "CantP8SS" + numero,
  ).innerHTML;

  document.getElementById("ModalMedida9S").value = document.getElementById(
    "UnidadP9xSS" + numero,
  ).innerHTML;
  document.getElementById("ModalCant9S").value = document.getElementById(
    "CantP9SS" + numero,
  ).innerHTML;

  document.getElementById("ModalMedida10S").value = document.getElementById(
    "UnidadP10xSS" + numero,
  ).innerHTML;
  document.getElementById("ModalCant10S").value = document.getElementById(
    "CantP10SS" + numero,
  ).innerHTML;

  if (
    document.getElementById("CantP1xSS" + numero).innerHTML == "" ||
    document.getElementById("CantP1xSS" + numero).innerHTML == "0"
  ) {
    document.getElementById("ModalCant2S").value = "1";
  }
  if (
    document.getElementById("CantP2SS" + numero).innerHTML == "" ||
    document.getElementById("CantP2SS" + numero).innerHTML == "0"
  ) {
    document.getElementById("ModalCant3S").value = "1";
  }
  if (
    document.getElementById("CantP4SS" + numero).innerHTML == "" ||
    document.getElementById("CantP4SS" + numero).innerHTML == "0"
  ) {
    document.getElementById("ModalCant4S").value = "1";
  }
  if (
    document.getElementById("CantP5SS" + numero).innerHTML == "" ||
    document.getElementById("CantP5SS" + numero).innerHTML == "0"
  ) {
    document.getElementById("ModalCant5S").value = "1";
  }
  if (
    document.getElementById("CantP6SS" + numero).innerHTML == "" ||
    document.getElementById("CantP6SS" + numero).innerHTML == "0"
  ) {
    document.getElementById("ModalCant6S").value = "1";
  }
  if (
    document.getElementById("CantP7SS" + numero).innerHTML == "" ||
    document.getElementById("CantP7SS" + numero).innerHTML == "0"
  ) {
    document.getElementById("ModalCant7S").value = "1";
  }
  if (
    document.getElementById("CantP8SS" + numero).innerHTML == "" ||
    document.getElementById("CantP8SS" + numero).innerHTML == "0"
  ) {
    document.getElementById("ModalCant8S").value = "1";
  }
  if (
    document.getElementById("CantP9SS" + numero).innerHTML == "" ||
    document.getElementById("CantP9SS" + numero).innerHTML == "0"
  ) {
    document.getElementById("ModalCant9S").value = "1";
  }
  if (
    document.getElementById("CantP10SS" + numero).innerHTML == "" ||
    document.getElementById("CantP10SS" + numero).innerHTML == "0"
  ) {
    document.getElementById("ModalCant10S").value = "1";
  }

  var codbarra = document.getElementById("codbarraSS" + numero).innerHTML;
  var descripc = document.getElementById("descripcionSS" + numero).innerHTML;
  $.ajax({
    type: "POST",
    url: "utilidadess.php",
    data: {
      cod: codbarra,
      des: descripc,
      Company: document.getElementById("CompanyActual").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
      CodIdBasico: CodIdBasicoAct,
      param: "S",
      Accion: "generarcodbarra",
    },
  }).done(function (msg) {
    document.getElementById("barrascodS").innerHTML = msg;
  });

  $.ajax({
    type: "POST",
    url: "dataseeks/Dataseek2r.php",
    data: {
      Almacen: "3",
      Id: document.getElementById("ModalCodIdBasico3S").value,
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    $("#abcdfghjqwetS").html(msg);
  });
  $.ajax({
    type: "POST",
    url: "DataHandler1.php",
    data: {
      Accion: "Stock",
      ModalCodIdBasico: document.getElementById("codidbasico1SS" + numero)
        .innerHTML,
      companyUser: document.getElementById("comSS" + numero).value,
      ModalMedida: document.getElementById("medidaSS" + numero).innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    $("#ResultadoS").html(msg);
  });

  var NewMargen = new Number(document.getElementById("ModalMargenS").value);
  var NewCostoNeto = new Number(
    document.getElementById("ModalCostoNetoS").value,
  );
  var NewPrecioBruto = new Number(
    document.getElementById("ModalPrecioNetoS").value,
  );
  var NewCostoBruto = new Number(document.getElementById("ModalCostosS").value);
  var NewPrecioNeto = new Number(
    document.getElementById("ModalPrecioVentaS").value,
  );
  var NewPrecioBruto2 = new Number(
    document.getElementById("ModalPrecioNeto2S").value,
  );
  var NewPrecioNeto2 = new Number(
    document.getElementById("ModalPrecioVenta2S").value,
  );
  var NewMargen2 = new Number(document.getElementById("ModalMargen2S").value);
  var NewPrecioBruto3 = new Number(
    document.getElementById("ModalPrecioNeto3S").value,
  );
  var NewPrecioNeto3 = new Number(
    document.getElementById("ModalPrecioVenta3S").value,
  );
  var NewMargen3 = new Number(document.getElementById("ModalMargen3S").value);
  var NewPrecioBruto4 = new Number(
    document.getElementById("ModalPrecioNeto4S").value,
  );
  var NewPrecioNeto4 = new Number(
    document.getElementById("ModalPrecioVenta4S").value,
  );
  var NewMargen4 = new Number(document.getElementById("ModalMargen4S").value);

  var NewPrecioBruto5 = new Number(
    document.getElementById("ModalPrecioNeto5S").value,
  );
  var NewPrecioNeto5 = new Number(
    document.getElementById("ModalPrecioVenta5S").value,
  );
  var NewMargen5 = new Number(document.getElementById("ModalMargen5S").value);
  var NewPrecioBruto6 = new Number(
    document.getElementById("ModalPrecioNeto6S").value,
  );
  var NewPrecioNeto6 = new Number(
    document.getElementById("ModalPrecioVenta6S").value,
  );
  var NewMargen6 = new Number(document.getElementById("ModalMargen6S").value);
  var NewPrecioBruto7 = new Number(
    document.getElementById("ModalPrecioNeto7S").value,
  );
  var NewPrecioNeto7 = new Number(
    document.getElementById("ModalPrecioVenta7S").value,
  );
  var NewMargen7 = new Number(document.getElementById("ModalMargen7S").value);
  var NewPrecioBruto8 = new Number(
    document.getElementById("ModalPrecioNeto8S").value,
  );
  var NewPrecioNeto8 = new Number(
    document.getElementById("ModalPrecioVenta8S").value,
  );
  var NewMargen8 = new Number(document.getElementById("ModalMargen8S").value);
  var NewPrecioBruto9 = new Number(
    document.getElementById("ModalPrecioNeto9S").value,
  );
  var NewPrecioNeto9 = new Number(
    document.getElementById("ModalPrecioVenta9S").value,
  );
  var NewMargen9 = new Number(document.getElementById("ModalMargen9S").value);
  var NewPrecioBruto10 = new Number(
    document.getElementById("ModalPrecioNeto10S").value,
  );
  var NewPrecioNeto10 = new Number(
    document.getElementById("ModalPrecioVenta10S").value,
  );
  var NewMargen10 = new Number(document.getElementById("ModalMargen10S").value);

  var ModalCant2 = new Number(document.getElementById("ModalCant2S").value);
  var ModalCant3 = new Number(document.getElementById("ModalCant3S").value);
  var ModalCant4 = new Number(document.getElementById("ModalCant4S").value);
  var ModalCant5 = new Number(document.getElementById("ModalCant5S").value);
  var ModalCant6 = new Number(document.getElementById("ModalCant6S").value);
  var ModalCant7 = new Number(document.getElementById("ModalCant7S").value);
  var ModalCant8 = new Number(document.getElementById("ModalCant8S").value);
  var ModalCant9 = new Number(document.getElementById("ModalCant9S").value);
  var ModalCant10 = new Number(document.getElementById("ModalCant10S").value);
  document.getElementById("ModalCostosS").value = NewCostoBruto.toFixed(2);
  document.getElementById("ModalCostoNetoS").value = NewCostoNeto.toFixed(
    document.getElementById("CD").innerHTML,
  );
  document.getElementById("ModalMargenS").value = NewMargen.toFixed(2);
  document.getElementById("ModalPrecioNetoS").value = NewPrecioBruto.toFixed(2);
  document.getElementById("ModalPrecioVentaS").value = NewPrecioNeto.toFixed(
    document.getElementById("CD").innerHTML,
  );
  document.getElementById("ModalMargen2S").value = NewMargen2.toFixed(2);
  document.getElementById("ModalPrecioNeto2S").value =
    NewPrecioBruto2.toFixed(2);
  document.getElementById("ModalPrecioVenta2S").value = NewPrecioNeto2.toFixed(
    document.getElementById("CD").innerHTML,
  );
  document.getElementById("ModalMargen3S").value = NewMargen3.toFixed(2);
  document.getElementById("ModalPrecioNeto3S").value =
    NewPrecioBruto3.toFixed(2);
  document.getElementById("ModalPrecioVenta3S").value = NewPrecioNeto3.toFixed(
    document.getElementById("CD").innerHTML,
  );
  document.getElementById("ModalMargen4S").value = NewMargen4.toFixed(2);
  document.getElementById("ModalPrecioNeto4S").value =
    NewPrecioBruto4.toFixed(2);
  document.getElementById("ModalPrecioVenta4S").value = NewPrecioNeto4.toFixed(
    document.getElementById("CD").innerHTML,
  );
  document.getElementById("ModalMargen5S").value = NewMargen5.toFixed(2);
  document.getElementById("ModalPrecioNeto5S").value =
    NewPrecioBruto5.toFixed(2);
  document.getElementById("ModalPrecioVenta5S").value = NewPrecioNeto5.toFixed(
    document.getElementById("CD").innerHTML,
  );
  document.getElementById("ModalMargen6S").value = NewMargen6.toFixed(2);
  document.getElementById("ModalPrecioNeto6S").value =
    NewPrecioBruto6.toFixed(2);
  document.getElementById("ModalPrecioVenta6S").value = NewPrecioNeto6.toFixed(
    document.getElementById("CD").innerHTML,
  );
  document.getElementById("ModalMargen7S").value = NewMargen7.toFixed(2);
  document.getElementById("ModalPrecioNeto7S").value =
    NewPrecioBruto7.toFixed(2);
  document.getElementById("ModalPrecioVenta7S").value = NewPrecioNeto7.toFixed(
    document.getElementById("CD").innerHTML,
  );
  document.getElementById("ModalMargen8S").value = NewMargen8.toFixed(2);
  document.getElementById("ModalPrecioNeto8S").value =
    NewPrecioBruto8.toFixed(2);
  document.getElementById("ModalPrecioVenta8S").value = NewPrecioNeto8.toFixed(
    document.getElementById("CD").innerHTML,
  );
  document.getElementById("ModalMargen9S").value = NewMargen9.toFixed(2);
  document.getElementById("ModalPrecioNeto9S").value =
    NewPrecioBruto9.toFixed(2);
  document.getElementById("ModalPrecioVenta9S").value = NewPrecioNeto9.toFixed(
    document.getElementById("CD").innerHTML,
  );
  document.getElementById("ModalMargen10S").value = NewMargen10.toFixed(2);
  document.getElementById("ModalPrecioNeto10S").value =
    NewPrecioBruto10.toFixed(2);
  document.getElementById("ModalPrecioVenta10S").value =
    NewPrecioNeto10.toFixed(document.getElementById("CD").innerHTML);

  if (
    document.getElementById("CantP1xSS" + numero).innerHTML == "" ||
    document.getElementById("CantP1xSS" + numero).innerHTML == "0"
  ) {
    document.getElementById("ModalCant2S").value = "1";
  }
  if (
    document.getElementById("CantP2SS" + numero).innerHTML == "" ||
    document.getElementById("CantP2SS" + numero).innerHTML == "0"
  ) {
    document.getElementById("ModalCant3S").value = "1";
  }
  if (
    document.getElementById("CantP4SS" + numero).innerHTML == "" ||
    document.getElementById("CantP4SS" + numero).innerHTML == "0"
  ) {
    document.getElementById("ModalCant4S").value = "1";
  }
  if (
    document.getElementById("CantP5SS" + numero).innerHTML == "" ||
    document.getElementById("CantP5SS" + numero).innerHTML == "0"
  ) {
    document.getElementById("ModalCant5S").value = "1";
  }
  if (
    document.getElementById("CantP6SS" + numero).innerHTML == "" ||
    document.getElementById("CantP6SS" + numero).innerHTML == "0"
  ) {
    document.getElementById("ModalCant6S").value = "1";
  }
  if (
    document.getElementById("CantP7SS" + numero).innerHTML == "" ||
    document.getElementById("CantP7SS" + numero).innerHTML == "0"
  ) {
    document.getElementById("ModalCant7S").value = "1";
  }
  if (
    document.getElementById("CantP8SS" + numero).innerHTML == "" ||
    document.getElementById("CantP8SS" + numero).innerHTML == "0"
  ) {
    document.getElementById("ModalCant8S").value = "1";
  }
  if (
    document.getElementById("CantP9SS" + numero).innerHTML == "" ||
    document.getElementById("CantP9SS" + numero).innerHTML == "0"
  ) {
    document.getElementById("ModalCant9S").value = "1";
  }
  if (
    document.getElementById("CantP10SS" + numero).innerHTML == "" ||
    document.getElementById("CantP10SS" + numero).innerHTML == "0"
  ) {
    document.getElementById("ModalCant10S").value = "1";
  }

  document.getElementById("ModalCant2S").value = ModalCant2;
  document.getElementById("ModalCant3S").value = ModalCant3;
  document.getElementById("ModalCant4S").value = ModalCant4;
  document.getElementById("ModalCant5S").value = ModalCant5;
  document.getElementById("ModalCant6S").value = ModalCant6;
  document.getElementById("ModalCant7S").value = ModalCant7;
  document.getElementById("ModalCant8S").value = ModalCant8;
  document.getElementById("ModalCant9S").value = ModalCant9;
  document.getElementById("ModalCant10S").value = ModalCant10;

  if (document.getElementById("ModalCant2S").value > 1 && NewPrecioBruto2 > 0) {
    document.getElementById("cantsimpS").innerHTML =
      (NewPrecioBruto2.toFixed(2) / ModalCant2).toFixed(3) +
      " x " +
      document.getElementById("ModalMedida2S").value;
    document.getElementById("cantcimpS").innerHTML =
      (NewPrecioNeto2.toFixed(2) / ModalCant2).toFixed(3) +
      " x " +
      document.getElementById("ModalMedida2S").value;
  } else {
    document.getElementById("cantsimpS").innerHTML = "";
    document.getElementById("cantcimpS").innerHTML = "";
  }
  if (document.getElementById("ModalCant3S").value > 1 && NewPrecioBruto3 > 0) {
    document.getElementById("cantsimp2S").innerHTML =
      (NewPrecioBruto3.toFixed(2) / ModalCant3).toFixed(3) +
      " x " +
      document.getElementById("ModalMedida3S").value;
    document.getElementById("cantcimp2S").innerHTML =
      (NewPrecioNeto3.toFixed(2) / ModalCant3).toFixed(3) +
      " x " +
      document.getElementById("ModalMedida3S").value;
  } else {
    document.getElementById("cantsimp2S").innerHTML = "";
    document.getElementById("cantcimp2S").innerHTML = "";
  }
  if (document.getElementById("ModalCant4S").value > 1 && NewPrecioBruto4 > 0) {
    document.getElementById("cantsimp4S").innerHTML =
      (NewPrecioBruto4.toFixed(2) / ModalCant4).toFixed(3) +
      " x " +
      document.getElementById("ModalMedida4S").value;
    document.getElementById("cantcimp4S").innerHTML =
      (NewPrecioNeto4.toFixed(2) / ModalCant4).toFixed(3) +
      " x " +
      document.getElementById("ModalMedida4S").value;
  } else {
    document.getElementById("cantsimp4S").innerHTML = "";
    document.getElementById("cantcimp4S").innerHTML = "";
  }
  if (document.getElementById("ModalCant5S").value > 1 && NewPrecioBruto5 > 0) {
    document.getElementById("cantsimp5S").innerHTML =
      (NewPrecioBruto5.toFixed(2) / ModalCant5).toFixed(3) +
      " x " +
      document.getElementById("ModalMedida5S").value;
    document.getElementById("cantcimp5S").innerHTML =
      (NewPrecioNeto5.toFixed(2) / ModalCant5).toFixed(3) +
      " x " +
      document.getElementById("ModalMedida5S").value;
  } else {
    document.getElementById("cantsimp5S").innerHTML = "";
    document.getElementById("cantcimp5S").innerHTML = "";
  }
  if (document.getElementById("ModalCant6S").value > 1 && NewPrecioBruto6 > 0) {
    document.getElementById("cantsimp6S").innerHTML =
      (NewPrecioBruto6.toFixed(2) / ModalCant6).toFixed(3) +
      " x " +
      document.getElementById("ModalMedida6S").value;
    document.getElementById("cantcimp6S").innerHTML =
      (NewPrecioNeto6.toFixed(2) / ModalCant6).toFixed(3) +
      " x " +
      document.getElementById("ModalMedida6S").value;
  } else {
    document.getElementById("cantsimp6S").innerHTML = "";
    document.getElementById("cantcimp6S").innerHTML = "";
  }
  if (document.getElementById("ModalCant7S").value > 1 && NewPrecioBruto7 > 0) {
    document.getElementById("cantsimp7S").innerHTML =
      (NewPrecioBruto7.toFixed(2) / ModalCant7).toFixed(3) +
      " x " +
      document.getElementById("ModalMedida7S").value;
    document.getElementById("cantcimp7S").innerHTML =
      (NewPrecioNeto7.toFixed(2) / ModalCant7).toFixed(3) +
      " x " +
      document.getElementById("ModalMedida7S").value;
  } else {
    document.getElementById("cantsimp7S").innerHTML = "";
    document.getElementById("cantcimp7S").innerHTML = "";
  }
  if (document.getElementById("ModalCant8S").value > 1 && NewPrecioBruto8 > 0) {
    document.getElementById("cantsimp8S").innerHTML =
      (NewPrecioBruto8.toFixed(2) / ModalCant8).toFixed(3) +
      " x " +
      document.getElementById("ModalMedida8S").value;
    document.getElementById("cantcimp8S").innerHTML =
      (NewPrecioNeto8.toFixed(2) / ModalCant8).toFixed(3) +
      " x " +
      document.getElementById("ModalMedida8S").value;
  } else {
    document.getElementById("cantsimp8S").innerHTML = "";
    document.getElementById("cantcimp8S").innerHTML = "";
  }
  if (document.getElementById("ModalCant9S").value > 1 && NewPrecioBruto9 > 0) {
    document.getElementById("cantsimp9S").innerHTML =
      (NewPrecioBruto9.toFixed(2) / ModalCant9).toFixed(3) +
      " x " +
      document.getElementById("ModalMedida9S").value;
    document.getElementById("cantcimp9S").innerHTML =
      (NewPrecioNeto9.toFixed(2) / ModalCant9).toFixed(3) +
      " x " +
      document.getElementById("ModalMedida9S").value;
  } else {
    document.getElementById("cantsimp9S").innerHTML = "";
    document.getElementById("cantcimp9S").innerHTML = "";
  }
  if (
    document.getElementById("ModalCant10S").value > 1 &&
    NewPrecioBruto10 > 0
  ) {
    document.getElementById("cantsimp10S").innerHTML =
      (NewPrecioBruto10.toFixed(2) / ModalCant10).toFixed(3) +
      " x " +
      document.getElementById("ModalMedida10S").value;
    document.getElementById("cantcimp10S").innerHTML =
      (NewPrecioNeto10.toFixed(2) / ModalCant10).toFixed(3) +
      " x " +
      document.getElementById("ModalMedida10S").value;
  } else {
    document.getElementById("cantsimp10S").innerHTML = "";
    document.getElementById("cantcimp10S").innerHTML = "";
  }
  //DeshabilitarButtond(1,'S');
  $("#apps-modalS").modal("show");
}

function recibir2(n, onvar) {
  $("#Costos").addClass("active");
  $("#Costos2").addClass("active");
  $("#apps-modal").modal("show");
  $("#Informacion").removeClass("active");
  $("#Informacion2").removeClass("active");
  $("#Variaciones").removeClass("active");
  $("#Variaciones2").removeClass("active");
  $("#Inventario").removeClass("active");
  $("#Inventario2").removeClass("active");
  xd(n, onvar);
}

function recibir3(n, onvar) {
  $("#Inventario").addClass("active");
  $("#Inventario2").addClass("active");
  $("#apps-modal").modal("show");
  $("#Informacion").removeClass("active");
  $("#Informacion2").removeClass("active");
  $("#Costos").removeClass("active");
  $("#Costos2").removeClass("active");
  $("#Variaciones").removeClass("active");
  $("#Variaciones2").removeClass("active");
  xd(n, onvar);
}

function recibir4(numero) {
  $("#apps-modal4").modal("show");
  document.getElementById("algov22").innerHTML = document.getElementById(
    "descripcion" + numero,
  ).innerHTML;

  var CodIdBasico = document.getElementById("codidbasico1" + numero).innerHTML;
  var descrip = document.getElementById("descripcion" + numero).innerHTML;
  var codbarra = document.getElementById("codidampliado" + numero).innerHTML;
  $.ajax({
    type: "POST",
    url: "saveimage.php",
    data: {
      Accion: "Productos",
      userperfil: document.getElementById("userperfil").innerHTML,
      numerot: numero,
      barra: codbarra,
      descri: descrip,
      Id: CodIdBasico,
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    $("#ledner").html(msg);
  });
}

function resetfoto(numero) {
  var CodIdBasico = document.getElementById("codidbasico1" + numero).innerHTML;
  var descrip = document.getElementById("descripcion" + numero).innerHTML;
  var codbarra = document.getElementById("codidampliado" + numero).innerHTML;
  $.ajax({
    type: "POST",
    url: "saveimage.php",
    data: {
      Accion: "Productos",
      userperfil: document.getElementById("userperfil").innerHTML,
      numerot: numero,
      barra: codbarra,
      descri: descrip,
      Id: CodIdBasico,
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    $("#ledner").html(msg);
    $("#ServerSideTable").DataTable().ajax.reload(null, false);
  });
}

function recibir6(serial, codbasico) {
  $("#apps-modal4").modal("show");
  var Id = serial + "-" + codbasico;
  resetfoto6(Id);
}

function resetfoto6(Id) {
  $.ajax({
    type: "POST",
    url: "saveimage.php",
    data: {
      Accion: "Seriales",
      userperfil: document.getElementById("userperfil").innerHTML,
      Id: Id,
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    $("#ledner").html(msg);
  });
}

function fotovar(CodIdBasico, Descrip, codbarra) {
  $("#apps-modal4").modal("show");
  document.getElementById("algov22").innerHTML = Descrip;

  var CodIdBasico = CodIdBasico;
  var descrip = Descrip;
  var codbarra = codbarra;
  var numero = "'" + CodIdBasico + "','" + Descrip + "','" + codbarra + "'";
  var texto = "productos";
  $.ajax({
    type: "POST",
    url: "fotoslimpproductos.php",
    data: {
      Accion: "subir",
      userperfil: document.getElementById("userperfil").innerHTML,
      var: "1",
      numerot: numero,
      texto: texto,
      barra: codbarra,
      descri: descrip,
      Id: CodIdBasico,
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    //alert(msg);
    $("#ledner").html(msg);
  });
}

function resetfotovar(CodIdBasico, Descrip, codbarra) {
  var CodIdBasico = CodIdBasico;
  var descrip = Descrip;
  var codbarra = codbarra;
  var numero = "'" + CodIdBasico + "','" + Descrip + "','" + codbarra + "'";
  var texto = "productos";
  $.ajax({
    type: "POST",
    url: "fotoslimpproductos.php",
    data: {
      Accion: "subir",
      userperfil: document.getElementById("userperfil").innerHTML,
      texto: texto,
      numerot: numero,
      barra: codbarra,
      descri: descrip,
      Id: CodIdBasico,
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    //alert(msg);
    $("#ledner").html(msg);
    $("#ServerSideTable").DataTable().ajax.reload(null, false);
    //  var table = $('#data-table-product2').DataTable();
    //  table.ajax.reload();
    //
  });
}

function recibir5(n) {
  $("#Pedidos").addClass("active");
  $("#Pedidos2").addClass("active");
  $("#Seriales").removeClass("active");
  $("#Seriales2").removeClass("active");
  document.getElementById("serialesspan2").innerHTML = document.getElementById(
    "CodIdBasicoMasterYI" + numero,
  ).innerHTML;
  EnvioIE();
  document.getElementById("serialesspan2x").innerHTML =
    document.getElementById("codidampliado" + n).innerHTML +
    " - " +
    document.getElementById("descripcion" + n).innerHTML;
  EnvioI2();
  $("#MostrarSeriales2").modal("show");
}

function OcultarNotificacion() {
  $("#exito").hide();
  $("#fracaso").hide();
  $("#valida").hide();
  document.getElementById("loading").style.display = "none";
  document.getElementById("elfixed").style.display = "none";
  document.getElementById("maintop").style.display = "none";
}

function html(numero) {
  $("#htmlmodal").modal("show");
  document.getElementById("BarraBlack").value = document.getElementById(
    "codidampliado" + numero,
  ).innerHTML;
  document.getElementById("ComoTeves").value = document.getElementById(
    "descripcion" + numero,
  ).innerHTML;
  document.getElementById("codiguito").value = document.getElementById(
    "CodIdBasicoMasterYI" + numero,
  ).innerHTML;
  //alert(document.getElementById("larga" + numero).innerHTML);
  editor.setData(document.getElementById("larga" + numero).innerHTML);
  editor2.setData(document.getElementById("corta" + numero).innerHTML);
}

function runhtml() {
  document.getElementById("loading").style.display = "flex";
  const txtbig = editor.getData();
  const txtsmall = editor2.getData();
  var codigoo = document.getElementById("codiguito").value;
  var codbarra = document.getElementById("BarraBlack").value;
  
  $.ajax({
    type: "POST",
    url: "guardohtml.php",
    data: {
      largaml: txtbig,
      cortaml: txtsmall,
      sku: codbarra,
      codigo: codigoo,
      company: document.getElementById("CompanyActual").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    if (msg == "1") {
      $("#ServerSideTable").DataTable().ajax.reload(null, false);
      $("#alertaerrorenproducto2").delay(500).fadeIn("slow");
      setTimeout(() => OcultarNotificacion2(), 4000);
      $("#htmlmodal").modal("hide");
    } else {
      document.getElementById("maintop").style.display = "block";
      setTimeout(() => OcultarNotificacion(), 4000);
      $("#fracaso").delay(500).fadeIn("slow");
    }
  });
}

function calcArea() {
  if (isNaN(document.getElementById("AltoSerial").value)) {
    document.getElementById("AltoSerial").value = 0;
  }
  if (isNaN(document.getElementById("AnchoSerial").value)) {
    document.getElementById("AnchoSerial").value = 0;
  }
  document.getElementById("AreaSerial").value =
    Math.round(
      document.getElementById("AltoSerial").value *
        document.getElementById("AnchoSerial").value *
        0.00694444 *
        100,
    ) / 100;
  document.getElementById("AreaSerial2").value =
    Math.round(
      document.getElementById("AltoSerial").value *
        document.getElementById("AnchoSerial").value *
        0.00694444 *
        100,
    ) / 100;
}

function modalvaria(numero) {
  document.getElementById("ModalCodIdAmpliado22").value =
    document.getElementById("sr" + numero).innerText;
  document.getElementById("Valor").value = document.getElementById(
    "valorado" + numero,
  ).value;
  var c = document.getElementById("contador" + numero).value;

  //<div class="user-panel main"><input name="login" value="prueba" /></input> </div>
  document.getElementById("AltoSerial").value = document.getElementById(
    "AltoDatax" + numero,
  ).innerHTML;
  document.getElementById("AnchoSerial").value = document.getElementById(
    "AnchoDatax" + numero,
  ).innerHTML;
  document.getElementById("AreaSerial").value = document.getElementById(
    "AreaDatax" + numero,
  ).innerHTML;
  document.getElementById("AreaSerial2").value = document.getElementById(
    "AreaDatax" + numero,
  ).innerHTML;

  $("#MostrarSeriales2").modal("hide");
  $("#apps-modallptm").modal("show");
  if (c > 0) {
    var n = document.getElementById("npi").value;
    let x = 0;
    let o = 0;
    let p = 1;
    while (n > x) {
      x++;
      var validacion2 = document.querySelector(
        "div.user-panel.main" + numero + " span[name='serialito" + p + "']",
      );
      var sete = validacion2.innerText;
      var page = document.getElementById("Tvaria" + x).value;
      if (page == sete) {
        o++;
        var el = document.querySelector(
          "div.user-panel.main" + numero + " span[name='login" + o + "']",
        );
        var id = el.innerText;
        document.querySelector("#ide" + x).value = id;
        p++;
      } else {
        document.querySelector("#ide" + x).value = "*";
      }
    }
  } else {
    let y = 0;
    let z = document.getElementById("npi").innerHTML;
    while (z > y) {
      y++;
      document.querySelector("#ide" + y).value = "*";
    }
  }
}

function proceso(n) {
  $("#apps-odolito").modal("show");
}

function serialito() {
  var InsertarSerial = document.getElementById("InsertaSerial").value;
  var jabc = document.getElementById("pensamientoteorico").innerHTML;
  var codigop = document.getElementById("CodIdBasicoM").value;
  $.ajax({
    type: "POST",
    url: "dataseeks/dataseekvar.php",
    data: {
      Accion: "95",
      Serial: InsertarSerial,
      JS: jabc,
      company: document.getElementById("CompanyActual").innerHTML,
      codigo: codigop,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    //alert(msg);
    if (msg == "0") {
      jabc = document.getElementById("pensamientoteorico").innerHTML;
      $.ajax({
        type: "POST",
        url: "dataseeks/dataseekvar.php",
        data: {
          Accion: "94",
          Serial: InsertarSerial,
          JS: jabc,
          CD: document.getElementById("CD").innerHTML,
          SimDec: document.getElementById("SimDec").innerHTML,
          SimMil: document.getElementById("SimMil").innerHTML,
          MonedaP: document.getElementById("MonedaP").innerHTML,
          MonedaS: document.getElementById("MonedaS").innerHTML,
        },
      }).done(function (msg) {
        $("#pensamientoteorico").html(msg);
        document.getElementById("pensamientoteorico2").value =
          document.getElementById("pensamientoteorico").innerHTML;
        //alert(msg)
        $.ajax({
          type: "POST",
          url: "dataseeks/dataseekvar.php",
          data: {
            Accion: "96",
            JS: document.getElementById("pensamientoteorico").innerHTML,
          },
        }).done(function (msg) {
          //alert(msg)
          $("#ListaSeriales").html(msg);
          document.getElementById("ListaSeriales2").innerHTML = msg;
          var numerocontadorxd = new Number(
            document.getElementById("numerocontador").innerHTML,
          );
          var numerocontador =
            document.getElementById("numerocontador").innerHTML;
          document.getElementById("numerocontador").innerHTML =
            numerocontadorxd;
          document.getElementById("elmostradordecontador").innerHTML =
            document.getElementById("numerocontador").innerHTML;
          document.getElementById("InsertaSerial").value = "";
        });
      });
    } else {
      document.getElementById("errorsobrejson").innerHTML =
        '<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(2)" aria-label="Close"><span class="fa fa-close"></span></button></div></div>' +
        msg;
      $("#errorsobrejson").delay(100).fadeIn("slow");
      setTimeout(() => OcultarNotificacion2(), 5000);
    }
  });
}

function EliJson(numero) {
  var opcion = confirm(Utils2a.Desc35);
  if (opcion == true) {
    var InsertarSerial = numero;
    var jabc = document.getElementById("pensamientoteorico").innerHTML;
    $.ajax({
      type: "POST",
      url: "dataseeks/dataseekvar.php",
      data: {
        Accion: "97",
        Serial: InsertarSerial,
        JS: jabc,
      },
    }).done(function (msg) {
      //alert(msg)
      $("#pensamientoteorico").html(msg);
      var jabcd = document.getElementById("pensamientoteorico").innerHTML;
      $.ajax({
        type: "POST",
        url: "dataseeks/dataseekvar.php",
        data: {
          Accion: "96",
          JS: jabcd,
        },
      }).done(function (msg) {
        //alert(msg)
        $("#ListaSeriales").html(msg);
        var numerocontadorxd = new Number(
          document.getElementById("numerocontador").innerHTML,
        );
        var numerocontador =
          document.getElementById("numerocontador").innerHTML;
        document.getElementById("numerocontador").innerHTML = numerocontadorxd;
        document.getElementById("elmostradordecontador").innerHTML =
          document.getElementById("numerocontador").innerHTML;
      });
    });
  }
}

function guardar32() {
  document.getElementById("loading").style.display = "flex";
  $.post(
    "datahandlers/datahandlervariacionesmultiple.php",
    $("#formMultiple").serialize(),
    function (res) {
      //$("#apps-modal").fadeOut("slow");   // Hacemos desaparecer el div "formulario" con un efecto fadeOut lento.
      //alert(res);
      if (res === "1") {
        $("#alertaerrorenproducto2").delay(500).fadeIn("slow");
        setTimeout(() => OcultarNotificacion2(), 4000);
        $("#ServerSideTable").DataTable().ajax.reload(null, false);
        $("#apps-odolito").modal("hide");
        EnvioI2();
        reset();
      } else {
        //alert(res);
        document.getElementById("maintop").style.display = "block";
        setTimeout(() => OcultarNotificacion(), 4000);
        $("#fracaso").delay(500).fadeIn("slow"); // Si no, lo mismo, pero haremos aparecer el div "fracaso"
      }
    },
  );
}

function reset() {
  let y = 0;
  let z = document.getElementById("npiM").innerHTML;
  while (z > y) {
    y++;
    document.querySelector("#ideM" + y).value = "*";
  }
  document.getElementById("elmostradordecontador").innerHTML = "0";
  var InsertarSerial = "";
  var jabc = document.getElementById("pensamientoteorico").innerHTML;
  $.ajax({
    type: "POST",
    url: "dataseeks/dataseek1led.php",
    data: {
      Accion: "97",
      Serial: InsertarSerial,
      JS: jabc,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    //alert(msg)
    $("#pensamientoteorico").html(msg);
    var jabcd = document.getElementById("pensamientoteorico").innerHTML;
    $.ajax({
      type: "POST",
      url: "dataseeks/dataseek1led.php",
      data: {
        Accion: "96",
        JS: jabcd,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        MonedaS: document.getElementById("MonedaS").innerHTML,
      },
    }).done(function (msg) {
      //alert(msg)
      $("#ListaSeriales").html(msg);
    });
  });
}

/*
ST",
		url: "guardohtml.php",
		data: {
			largaml: txtbig,
			cortaml: txtsmall,
			sku: codbarra,
			codigo: codigoo,
			company: document.getElementById("CompanyActual").innerHTML
		}
	}).done(function (msg) {
		if (msg == '1') {
			MuestraProd();
			$("#alertaerrorenproducto2").delay(500).fadeIn("slow");
			setTimeout(() => OcultarNotificacion2(), 4000);
			$('#htmlmodal').modal('hide');
		} else {
			document.getElementById('maintop').style.display = "block";
			setTimeout(() => OcultarNotificacion(), 4000);
			$("#fracaso").delay(500).fadeIn("slow");
		}
	});
}
*/

function guardar23() {
  //botón de enviar.
  //alert(2);
  document.getElementById("loading").style.display = "flex";
  $.post(
    "datahandlers/DataHandlervariacionesfinal.php",
    $("#formdataVariacion").serialize(),
    function (res) {
      //$("#apps-modal").fadeOut("slow");   // Hacemos desaparecer el div "formulario" con un efecto fadeOut lento.
      //alert(res);
      if (res === "1") {
        $("#alertaerrorenproducto2").delay(500).fadeIn("slow");
        setTimeout(() => OcultarNotificacion2(), 4000);
        //$("#ServerSideTable").DataTable().ajax.reload(null, false);
        $("#apps-modallptm").modal("hide");
        $("#MostrarSeriales2").modal("show");
        EnvioI2();
      } else {
        //alert(res);
        document.getElementById("maintop").style.display = "block";
        $("#fracaso").delay(500).fadeIn("slow"); // Si no, lo mismo, pero haremos aparecer el div "fracaso"
        setTimeout(() => OcultarNotificacion(), 4000);
      }
    },
  );
}

function proceso(n) {
  $("#apps-odolito").modal("show");
}

function serialito() {
  var InsertarSerial = document.getElementById("InsertaSerial").value;
  var jabc = document.getElementById("pensamientoteorico").innerHTML;
  var codigop = document.getElementById("CodIdBasicoM").value;
  $.ajax({
    type: "POST",
    url: "dataseeks/dataseekvar.php",
    data: {
      Accion: "95",
      Serial: InsertarSerial,
      JS: jabc,
      company: document.getElementById("CompanyActual").innerHTML,
      codigo: codigop,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    //alert(msg);
    if (msg == "0") {
      jabc = document.getElementById("pensamientoteorico").innerHTML;
      $.ajax({
        type: "POST",
        url: "dataseeks/dataseekvar.php",
        data: {
          Accion: "94",
          Serial: InsertarSerial,
          JS: jabc,
          CD: document.getElementById("CD").innerHTML,
          SimDec: document.getElementById("SimDec").innerHTML,
          SimMil: document.getElementById("SimMil").innerHTML,
          MonedaP: document.getElementById("MonedaP").innerHTML,
          MonedaS: document.getElementById("MonedaS").innerHTML,
        },
      }).done(function (msg) {
        $("#pensamientoteorico").html(msg);
        document.getElementById("pensamientoteorico2").value =
          document.getElementById("pensamientoteorico").innerHTML;
        //alert(msg)
        $.ajax({
          type: "POST",
          url: "dataseeks/dataseekvar.php",
          data: {
            Accion: "96",
            JS: document.getElementById("pensamientoteorico").innerHTML,
            CD: document.getElementById("CD").innerHTML,
            SimDec: document.getElementById("SimDec").innerHTML,
            SimMil: document.getElementById("SimMil").innerHTML,
            MonedaP: document.getElementById("MonedaP").innerHTML,
            MonedaS: document.getElementById("MonedaS").innerHTML,
          },
        }).done(function (msg) {
          //alert(msg)
          $("#ListaSeriales").html(msg);
          document.getElementById("ListaSeriales2").innerHTML = msg;
          var numerocontadorxd = new Number(
            document.getElementById("numerocontador").innerHTML,
          );
          var numerocontador =
            document.getElementById("numerocontador").innerHTML;
          document.getElementById("numerocontador").innerHTML =
            numerocontadorxd;
          document.getElementById("elmostradordecontador").innerHTML =
            document.getElementById("numerocontador").innerHTML;
          document.getElementById("InsertaSerial").value = "";
        });
      });
    } else {
      document.getElementById("errorsobrejson").innerHTML =
        '<div class="card-actions"><div class="float-end"><button type="button" class="btn btn-outline-warning" onclick="CerrarNotificacion(2)" aria-label="Close"><span class="fa fa-close"></span></button></div></div>' +
        msg;
      $("#errorsobrejson").delay(100).fadeIn("slow");
      setTimeout(() => OcultarNotificacion2(), 5000);
    }
  });
}

function EliJson(numero) {
  var opcion = confirm(Utils2a.Desc35);
  if (opcion == true) {
    var InsertarSerial = numero;
    var jabc = document.getElementById("pensamientoteorico").innerHTML;
    $.ajax({
      type: "POST",
      url: "dataseeks/dataseekvar.php",
      data: {
        Accion: "97",
        Serial: InsertarSerial,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        MonedaS: document.getElementById("MonedaS").innerHTML,
        JS: jabc,
      },
    }).done(function (msg) {
      //alert(msg)
      $("#pensamientoteorico").html(msg);
      var jabcd = document.getElementById("pensamientoteorico").innerHTML;
      $.ajax({
        type: "POST",
        url: "dataseeks/dataseekvar.php",
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        MonedaS: document.getElementById("MonedaS").innerHTML,
        data: {
          Accion: "96",
          JS: jabcd,
        },
      }).done(function (msg) {
        //alert(msg)
        $("#ListaSeriales").html(msg);
        var numerocontadorxd = new Number(
          document.getElementById("numerocontador").innerHTML,
        );
        var numerocontador =
          document.getElementById("numerocontador").innerHTML;
        document.getElementById("numerocontador").innerHTML = numerocontadorxd;
        document.getElementById("elmostradordecontador").innerHTML =
          document.getElementById("numerocontador").innerHTML;
      });
    });
  }
}

function guardar32() {
  document.getElementById("loading").style.display = "flex";
  $.post(
    "datahandlers/datahandlervariacionesmultiple.php",
    $("#formMultiple").serialize(),
    function (res) {
      //$("#apps-modal").fadeOut("slow");   // Hacemos desaparecer el div "formulario" con un efecto fadeOut lento.
      //alert(res);
      if (res === "1") {
        $("#alertaerrorenproducto2").delay(500).fadeIn("slow");
        setTimeout(() => OcultarNotificacion2(), 4000);
        $("#ServerSideTable").DataTable().ajax.reload(null, false);
        $("#apps-odolito").modal("hide");
        EnvioI2();
        reset();
      } else {
        //alert(res);
        document.getElementById("maintop").style.display = "block";
        setTimeout(() => OcultarNotificacion(), 4000);
        $("#fracaso").delay(500).fadeIn("slow"); // Si no, lo mismo, pero haremos aparecer el div "fracaso"
      }
    },
  );
}

function closeCost(option) {
  if (option !== 1) {
    document.getElementById("ModalCostoNeto").value = document.getElementById(
      "costo" + IdAct,
    ).innerHTML;
    document.getElementById("ModalCostos").value = document.getElementById(
      "costoneto" + IdAct,
    ).innerHTML;
  }
  $("#modalClose").modal("hide");
  $("#apps-modal").modal("show");
}

let IdProd;

function reset() {
  let y = 0;
  let z = document.getElementById("npiM").innerHTML;
  while (z > y) {
    y++;
    document.querySelector("#ideM" + y).value = "*";
  }
  document.getElementById("elmostradordecontador").innerHTML = "0";
  var InsertarSerial = "";
  var jabc = document.getElementById("pensamientoteorico").innerHTML;
  $.ajax({
    type: "POST",
    url: "dataseeks/dataseek1led.php",
    data: {
      Accion: "97",
      Serial: InsertarSerial,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
      JS: jabc,
    },
  }).done(function (msg) {
    //alert(msg)
    $("#pensamientoteorico").html(msg);
    var jabcd = document.getElementById("pensamientoteorico").innerHTML;
    $.ajax({
      type: "POST",
      url: "dataseeks/dataseek1led.php",
      data: {
        Accion: "96",
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        MonedaS: document.getElementById("MonedaS").innerHTML,
        JS: jabcd,
      },
    }).done(function (msg) {
      //alert(msg)
      $("#ListaSeriales").html(msg);
    });
  });
}
