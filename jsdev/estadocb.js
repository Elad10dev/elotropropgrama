let EliminarIdBarcode;

let avance = false;

let Vueltos = [];

let onlyOne;

let LimitCredit = 0;

let data = [];
let arrayABC = [];
let arrayTable = [];
let IdBarcodeAnticipo;
let IdBarcodePay;

let PagAct = 1;
let PagActTable = 1;
const language =
  "lang/datatables/" +
  document.getElementById("IdiomaActual").innerHTML +
  ".json";

/*
function CambiarPaginaAct(n) {
  PagActTable = n;
  ActualizarTablaTAB();
}
*/

function TipoMonedaRegistroPago() {
  const Factor = document.getElementById("FactorCambioRegistroPago").value;
  let tasa = 1;
  if (+Factor === 2) {
    tasa = parseFloat(FactorCambio["FactorDolarCash"]);
  } else if (+Factor === 3) {
    tasa = parseFloat(FactorCambio["FactorDolarPaypal"]);
  } else if (+Factor === 4) {
    tasa = parseFloat(FactorCambio["FactorDolarZelle"]);
  } else if (+Factor === 5) {
    tasa = parseFloat(FactorCambio["FactorDolar5"]);
  } else if (+Factor === 6) {
    tasa = parseFloat(FactorCambio["FactorDolar6"]);
  } else if (+Factor === 7) {
    tasa = parseFloat(FactorCambio["FactorDolar7"]);
  }

  $("#TasaCambioPagoUnico").prop("disabled", true);
  document.getElementById("TasaCambioPagoUnico").value = tasa.toFixed(2);

  var name = $("#FactorCambioRegistroPago option:selected").text();
  document.getElementById("Logitodemoneda").innerHTML = "(" + name + ")";

  actualizarpago();
}

function ImprimirEstado(IdBarcode = null) {
  const CompanyActual = document.getElementById("CompanyActual").innerHTML;
  const CD = document.getElementById("CD").innerHTML;
  const SimDec = document.getElementById("SimDec").innerHTML;
  const SimMil = document.getElementById("SimMil").innerHTML;
  const IdBen = document.getElementById("Modalrut").value;
  const MostrarTodos = $("#MostrarTodos").prop("checked") ? "1" : "0";
  const Fecha = document.getElementById("fechaktual").innerHTML;
  const MonedaP = document.getElementById("MonedaP").innerHTML;
  const MonedaS = document.getElementById("MonedaS").innerHTML;
  const NameCompanyActual =
    document.getElementById("NameCompanyActual").innerHTML;
  const litfiscal = document.getElementById("litfiscal").innerHTML;
  const direccionActSe = document.getElementById("direccionActSe").innerHTML;
  const IDFiscal = document.getElementById("ruteAcx").innerHTML;
  const LitEfectivo = document.getElementById("LitEfectivo").innerHTML;
  const LitTarjeta = document.getElementById("LitTarjeta").innerHTML;
  const LitCheque = document.getElementById("LitCheque").innerHTML;
  const LitO01 = document.getElementById("LitO01").innerHTML;
  const LitO02 = document.getElementById("LitO02").innerHTML;
  const LitO03 = document.getElementById("LitO03").innerHTML;
  const LitO04 = document.getElementById("LitO04").innerHTML;
  const Monto001 = document.getElementById("Monto001").innerHTML;
  const Monto003 = document.getElementById("Monto003").innerHTML;
  const Monto005 = document.getElementById("Monto005").innerHTML;
  const SaldoPCXXXX = document.getElementById("SaldoPCXXXX").innerHTML;
  const NameBeneficairio =
    document.getElementById("NameBeneficairio").innerHTML;

  // Open the popup window first
  const newWindow = window.open("", "reportWindow", "width=900,height=800");

  // Create form
  const form = document.createElement("form");
  form.method = "POST";
  form.action = "estadoreportebene.php";
  form.target = "reportWindow";

  // Helper to append input fields
  function addField(name, value) {
    const input = document.createElement("input");
    input.type = "hidden";
    input.name = name;
    input.value = value;
    form.appendChild(input);
  }

  addField("CD", CD);
  addField("SimDec", SimDec);
  addField("SimMil", SimMil);
  addField("CompanyActual", CompanyActual);
  addField("IdBen", IdBen);
  addField("MostrarTodos", MostrarTodos);
  addField("Fecha", Fecha);
  addField("MonedaP", MonedaP);
  addField("MonedaS", MonedaS);
  addField("NameCompanyActual", NameCompanyActual);
  addField("litfiscal", litfiscal);
  addField("direccion", direccionActSe);
  addField("IDFiscal", IDFiscal);
  addField("IdBarcode", IdBarcode);
  addField("LitEfectivo", LitEfectivo);
  addField("LitTarjeta", LitTarjeta);
  addField("LitCheque", LitCheque);
  addField("LitO01", LitO01);
  addField("LitO02", LitO02);
  addField("LitO03", LitO03);
  addField("LitO04", LitO04);
  addField("NameBeneficairio", NameBeneficairio);
  addField("Monto001", Monto001);
  addField("Monto003", Monto003);
  addField("Monto005", Monto005);
  addField("SaldoPCXXXX", SaldoPCXXXX);
  document.body.appendChild(form);
  form.submit();
  document.body.removeChild(form);
}

function ActualizarTablaTAB() {
  //const limitReg = 10;
  //const CanPags = Math.ceil(arrayTable.data.length / limitReg);
  let html = "";
  //let pagination = "";
  let i = 0;
  arrayTable.data
    //.slice(limitReg * (PagActTable - 1), limitReg * PagActTable)
    .forEach((e) => {
      i++;
      if (e.span.ItemAct == 1 && e.span.IdtipotxP != 3) {
        html += `
          <tr class='bg-dark text-light'> 
            <td colspan="8">${e.documento2}  </td>
            <td>${e.documento3}</td>
          </tr>
        `;
      }

      html += `
      <tr id='algo${i}' onclick='selecionado(${i},this)'  ${
        e.span.ItemAct != 1 || e.span.IdtipotxP == 3
          ? "style='background-color: white;'"
          : "style='background-color:#cfe2f3 ;'"
      }>
        <td class='text-start'>${e.etiqueta}</td>
        <td class='text-start'>${e.documento}</td>
        <td class='text-center'>${e.extradata}</td>
        <td class='text-center' id='fechatabla${i}'>${e.fechatabla}</td>
        <td class='text-end'>${e.monto}</td>
        <td class='text-end'>${
          e.span.ItemAct != 1 || e.span.IdtipotxP == 3 ? e.contable : ""
        }</td>
        <td class='text-end'>${
          e.span.ItemAct != 1 || e.span.IdtipotxP == 3 ? e.credito : ""
        }</td>
        <td class='text-end'>${e.saldo}</td>
        <td class='text-center'>${e.btn} 

        <span style='display:none;' id='MontoAPagarqk${i}'>${
        e.span.MontoAPagarqk
      }</span>
        <span style='display:none;' id='MontoAPagarqkx${i}'>${
        e.span.MontoAPagarqkx
      }</span>
        <span style='display:none;' id='CreditoTxP${i}'>${
        e.span.CreditoTxP
      }</span>
        <span style='display:none;' id='CreditoTxPx${i}'>${
        e.span.CreditoTxPx
      }</span>
        <span style='display:none;' id='ContadoTxP${i}'>${
        e.span.ContadoTxP
      }</span>
        <span style='display:none;' id='ContadoTxPx${i}'>${
        e.span.ContadoTxPx
      }</span>
        <span style='display:none;' id='ItemAct${i}'>${e.span.ItemAct}</span>
      </td>

      </tr>
  `;
    });

  /*
<span style='display:none;' id='ContadoAct${i}'>${
        e.span.ContadoAct
      }</span>
        <span style='display:none;' id='CreditoAct${i}'>${
        e.span.CreditoAct
      }</span>
        <span style='display:none;' id='TasaAct${i}'>${e.span.TasaAct}</span>
        <span style='display:none;' id='IdtxAct${i}'>${e.span.IdtxAct}</span>
        <span style='display:none;' id='IdtipotxAct${i}'>${
        e.span.IdtipotxAct
      }</span>
        <span style='display:none;' id='IdEstacionAct${i}'>"${
        e.span.IdEstacionAct
      }</span>
        <span style='display:none;' id='RetenidoActualmente${i}'>${
        e.span.RetenidoActualmente
      }</span>
        <span style='display:none;' id='RetenidoActualmente2${i}'>${
        e.span.RetenidoActualmente2
      }</span>
        <span style='display:none;' id='RetenidoActualmente3${i}'>${
        e.span.RetenidoActualmente3
      }</span>
        <span style='display:none;' id='RetencionAct${i}'>${
        e.span.RetencionAct
      }</span>
        <span style='display:none;' id='lastItemA${i}'>${
        e.span.lastItemA
      }</span>

    */
  /*
 for (
    let index =
      PagActTable - 2 > 0
        ? PagActTable - 2
        : PagActTable - 1 > 0
        ? PagActTable - 1
        : PagActTable;
    index <=
    (CanPags > PagActTable + 2 ? PagActTable + 2 : CanPags > 0 ? CanPags : 1);
    index++
  ) {
    pagination += `
      <li class='page-item '>
        <button type='button' onclick='CambiarPaginaAct(${index})' class='page-link ${
      PagActTable == index ? "bg-primary text-light" : ""
    }' >${index}</button>
      </li>
    `;
  }

  $("#PaginationFormCB").html(`
    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-end">
        <li class="page-item ${PagActTable === 1 ? "disabled" : ""}">
          <button type='button' onclick='CambiarPaginaAct(${
            PagActTable - 1
          })' class='page-link' >Anterior</button>
        </li>
        ${pagination}
        <li class="page-item ${PagActTable === CanPags ? "disabled" : ""}">
          <button type='button' onclick='CambiarPaginaAct(${
            PagActTable + 1
          })' class='page-link' >Siguiente</button>
        </li>
      </ul>
    </nav>
  `);
 */
  $("#backreporte2A").html(html);
}

function GuardarBeneficiario() {
  $("#button").prop("disabled", true);
  let valor1;

  if (document.getElementById("IdPaisAct").innerHTML == "CL") {
    if (document.getElementById("ModalRut2").value !== "") {
      valor1 =
        document.getElementById("ModalRut").value +
        "-" +
        document.getElementById("ModalRut2").value;
    } else {
      valor1 = document.getElementById("ModalRut").value;
    }
  } else {
    valor1 = document.getElementById("RutFa").value;
  }
  
  $.ajax({
    type: "POST",
    url: "estadocbseek.php",
    data: {
      Accion: "GuardarBeneficiario",
      TipoBeneficiario: document.getElementById("TipoBeneficiario").value,
      TipoPersona: document.getElementById("TipoPersona").value, // <-- NUEVO: Captura PN o PJ
      Domicilio: document.getElementById("Domicilio").value,     // <-- NUEVO: Captura DOM o NDOM
      GiroFA: document.getElementById("GiroFA").value,
      CiudadFA: document.getElementById("CiudadFA").value,
      DirecionFA: document.getElementById("DirecionFA").value,
      EmailFA: document.getElementById("EmailFA").value,
      TelefonoFA: document.getElementById("TelefonoFA").value,
      anombreFA: document.getElementById("anombreFA").value,
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      IdPais: document.getElementById("IdPaisAct").innerHTML,
      Rut: valor1,
    },
  }).done(function (msg) {
    const array = JSON.parse(msg);

    if (array.status === true) {
      $("#button").prop("disabled", false);
      EnviarBen(valor1, document.getElementById("anombreFA").value);
      document.getElementById("selectbenef").innerHTML = "0";
      $("#modalBenefe").modal("hide");
    } else {
      if (array.msg == 3) {
        alertBootstrap(
          Utils.Num043x.title,
          Utils.Num043x.desc,
          "warning",
          "alertaerrorenproducto2",
          true,
          1,
        );
      } else {
        alertBootstrap(
          Utils.Num043xx.title,
          Utils.Num043xx.desc,
          "warning",
          "alertaerrorenproducto2",
          true,
          1,
        );
      }
      $("#button").prop("disabled", false);
    }
  });
}

function VerificarBeneficiarioExistente(rut_ingresado) {
    if (!rut_ingresado || rut_ingresado.trim() === "") return;

    $.ajax({
        type: "POST",
        url: "estadocbseek.php",
        data: {
            Accion: "VerificarRUT",
            RUT: rut_ingresado,
            CompanyActual: document.getElementById("CompanyActual").innerHTML
        }
    }).done(function (msg) {
        let data = JSON.parse(msg);
        if (data.existe) {
            // Si existe, mostramos la alerta amarilla arriba del formulario
            alertBootstrap(
                "¡Atención! Beneficiario ya registrado",
                "Este identificador fiscal ya le pertenece a: <br><b>" + data.nombre + "</b>",
                "warning",
                "alertaerrorenproducto2", // Este es el div de alertas que ya tienes en el modal
                true,
                1
            );
            
            // Opcional: Vaciar el input para obligarlo a poner uno nuevo
            // $("#RutFa").val(''); 
        }
    });
}

function PagoUnico() {
  //let html = "";
  let pagination = `
      <li class='page-item '>
        <button type='button' onclick='CambiarPagina(${1})' class='page-link bg-primary text-light' >${1}</button>
      </li>
    `;

  $("#PaginationForm").html(`
    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-end">
        <li class="page-item disabled">
          <button type='button' onclick='CambiarPagina(${1})' class='page-link' >Anterior</button>
        </li>
        ${pagination}
        <li class="page-item disabled}">
          <button type='button' onclick='CambiarPagina(${1})' class='page-link' >Siguiente</button>
        </li>
      </ul>
    </nav>
  `);
  ActualizarTablaPagos();
  //$("#PutAplicar").html(html);
  /*
  $.ajax({
    type: "POST",
    url: "estadocbseek.php",
    data: {
      Accion: "RefreshTable",
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      userperfil: document.getElementById("userperfil").innerHTML,
      Fecha: document.getElementById("fechaktual").innerHTML,
      IdBen: document.getElementById("Modalrut").value,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MostrarTodos: $("#MostrarTodos").prop("checked") ? "1" : "0",
      OrderBy: document.getElementById("OrderBy").value,
      SortBy: document.getElementById("SortBy").value,
    },
  }).done(function (msg) {
    arrayABC = JSON.parse(msg);
    $("#TableResponse").show();
    $("#LoadingScreen").hide();

    ActualizarTablaPagos();
  });
  */

  var fecha = new Date();
  var mes = fecha.getMonth() + 1;
  var dia = fecha.getDate();
  var ano = fecha.getFullYear();
  if (dia < 10) {
    dia = "0" + dia;
  }
  if (mes < 10) {
    mes = "0" + mes;
  }

  document.getElementById("TipoPagoPagoUnico").value = 1;
  document.getElementById("FactorCambioPagoUnico").value = 1;
  document.getElementById("ModalMontoPagoUnico").value = 0;
  document.getElementById("ModalMonto2PagoUnico").value = 0;
  document.getElementById("ModalReferenciaPagoUnico").value = "";
  document.getElementById("ObsevacionPagoUnico").value = "";

  document.getElementById("ModalFechaPagoUnico").value =
    ano + "-" + mes + "-" + dia;
  $("#ModalPagoUnico").modal("show");
  TipoPagoAPagoUnico();
  TipoMonedaPagoUnico();
}

function IniEstadocb() {
  const CajaC =
    dataCaja?.find(
      (caja) => caja.token === document.getElementById("tokeninUse").value,
    )?.CajaActual ?? "0";
  if (CajaC == "0") {
    $("#headerprintxd2").html(`
        <div class='btn-group'>
            <button class="btn btn-info fs-6 p-1" type="button" onclick="selectben(0);">
              <i class="fa fa-user fs-3"></i><br> ${Utils.Num004}
            </button>
            <button class="btn btn-danger fs-6 p-1" type="button" onclick="AgregarBeneficiario();">
              <i class="fa fa-users fs-3"></i><br> ${Utils.AgrBene}
            </button>
          </div>
      `);
  } else {
    $("#headerprintxd2").html(
      `
          <div class='btn-group'>
            <button class="btn btn-success fs-6 p-1" type="button" onclick="Enviar(); todos();">
              <i class="fa fa-search fs-3"></i><br> ${Utils.Num003}
            </button>
            <button class="btn btn-info fs-6 p-1" type="button" onclick="selectben(0);">
              <i class="fa fa-user fs-3"></i><br> ${Utils.Num004}
            </button>
            <button class="btn btn-danger fs-6 p-1" type="button" onclick="AgregarBeneficiario();">
              <i class="fa fa-users fs-3"></i><br> ${Utils.AgrBene}
            </button>

          </div>
        `,
    );
  }
  $("#ModaldesdeA").prop("disabled", true);
  $("#ModalhastaA").prop("disabled", true);
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
  document.getElementById("ModaldesdeA").value =
    ano + "-" + mes + "-" + dia + "T" + horai + ":" + mini;
  document.getElementById("ModalhastaA").value =
    ano + "-" + mes + "-" + dia + "T" + horaf + ":" + minf + ":" + segf;
  fechas();

  if (BenePreter !== "") {
    EnviarBen(BenePreter, "");
    $.ajax({
      type: "POST",
      url: "estadocbseek.php",
      data: {
        Accion: "cleanidben",
      },
    }).done(function (msg) {});
  }
}

function CambioUsoToken(token = null) {
  $("input, select").prop("disabled", true);

  $.ajax({
    type: "POST",
    url: "ventaseek.php",
    data: {
      Accion: "71",
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      token: token ?? document.getElementById("tokeninUse").value,
      TokenEstacion: document.getElementById("TokenEstacion").innerHTML,
      userlogin: document.getElementById("userlogin").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      dataCaja: JSON.stringify(dataCaja),
    },
  }).done(function (msg) {
    location.reload();
  });
}

function AñosActuales() {
  let html = ``;
  const Año = new Date().getFullYear() - 1;
  for (let index = Año; index < Año + 4; index++) {
    html += `
			<option value="${index}">${index}</option>
		`;
  }

  document.getElementById("GenTxAño").innerHTML = html;
  document.getElementById("GenTxAño").value = Año + 1;
}

function DeleteAnticipo(IdBarcode) {
  $("#appAntipcipo").modal("hide");
  $("button").prop("disabled", true);
  IdBarcodeAnticipo = IdBarcode;
  $("#DeleteAnticipoModal").modal("show");
  $("button").prop("disabled", false);
}

function DeletePay(Idtx, Idtipotx, IdEstacion, item, Anticipo = false) {
  $("button").prop("disabled", true);
  IdBarcodePay = {
    Idtx: Idtx,
    Idtipotx: Idtipotx,
    IdEstacion: IdEstacion,
    item: item,
    Anticipo: Anticipo,
  };
  $("#DeletePayModal").modal("show");
  $("button").prop("disabled", false);
}

function closeAnticipo() {
  $("#DeleteAnticipoModal").modal("hide");
  const CajaC =
    dataCaja?.find(
      (caja) => caja.token === document.getElementById("tokeninUse").value,
    )?.CajaActual ?? "0";
  var fecha = new Date(document.getElementById("ModaldesdeA").value);
  var fechaa = new Date(document.getElementById("ModalhastaA").value);
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
    url: "estadocbseek.php",
    data: {
      Accion: "3",
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      IdBen: document.getElementById("Modalrut").value,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      userperfil: document.getElementById("userperfil").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      Modaldesde: valor6,
      Modalhasta: valor7,
      CajaC: CajaC,
    },
  }).done(function (msg) {
    $("#backreporte3").html(msg);
  });
  AnticipadosCrud();
  IdBarcodeAnticipo = "";
}

function DeletePago() {
  $("button").prop("disabled", true);
  $.ajax({
    type: "POST",
    url: "estadocbseek.php",
    data: {
      Accion: "DeletePago",
      Idtx: IdBarcodePay.Idtx,
      Idtipotx: IdBarcodePay.Idtipotx,
      IdEstacion: IdBarcodePay.IdEstacion,
      item: IdBarcodePay.item,
      Anticipo: IdBarcodePay.Anticipo,
      userlogin: userlogin,
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
    },
  }).done(function (msg) {
    const array = JSON.parse(msg);
    if (array.status === true) {
      $("#DeletePayModal").modal("hide");
      $("button").prop("disabled", false);
      ActTable();
      IdBarcodePay = "";
    } else {
      alertBootstrap(
        Utils.Danger.title,
        Utils.Danger.desc,
        "danger",
        "alertPago",
        true,
        1,
      );
      $("button").prop("disabled", false);
    }
  });
}

function DeleteAnticipo2() {
  $("button").prop("disabled", true);
  $.ajax({
    type: "POST",
    url: "estadocbseek.php",
    data: {
      Accion: "DeleteAnticipo",
      IdBarcode: IdBarcodeAnticipo,
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
    },
  }).done(function (msg) {
    const array = JSON.parse(msg);
    if (array.status === true) {
      $("#DeleteAnticipoModal").modal("hide");
      const CajaC =
        dataCaja?.find(
          (caja) => caja.token === document.getElementById("tokeninUse").value,
        )?.CajaActual ?? "0";
      var fecha = new Date(document.getElementById("ModaldesdeA").value);
      var fechaa = new Date(document.getElementById("ModalhastaA").value);
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
        url: "estadocbseek.php",
        data: {
          Accion: "3",
          CompanyActual: document.getElementById("CompanyActual").innerHTML,
          IdBen: document.getElementById("Modalrut").value,
          litfiscal: document.getElementById("litfiscal").innerHTML,
          MonedaP: document.getElementById("MonedaP").innerHTML,
          userperfil: document.getElementById("userperfil").innerHTML,
          MonedaS: document.getElementById("MonedaS").innerHTML,
          CD: document.getElementById("CD").innerHTML,
          SimDec: document.getElementById("SimDec").innerHTML,
          SimMil: document.getElementById("SimMil").innerHTML,
          Modaldesde: valor6,
          Modalhasta: valor7,
          CajaC: CajaC,
        },
      }).done(function (msg) {
        $("#backreporte3").html(msg);
      });
      AnticipadosCrud();
      IdBarcodeAnticipo = "";
    } else {
      alertBootstrap(
        Utils.Danger.title,
        Utils.Danger.desc,
        "danger",
        "alertAnticipo",
        true,
        1,
      );
    }
    $("button").prop("disabled", false);
  });
}

function AnticipadosCrud() {
  $("#appAntipcipo").modal("show");
  $("#anticipotablex").DataTable({
    search: {
      search: $(
        `#${"anticipotablex"}_wrapper .dt-layout-row .dt-end .dt-search .dt-input`,
      ).val(),
    },
    responsive: true,
    processing: true,
    serverSide: true,
    language: {
      url: language,
    },
    ajax: {
      type: "POST",
      url: "estadocbseek.php",
      data: {
        Accion: "AnticipadosCrud",
        CompanyActual: document.getElementById("CompanyActual").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        IdBen: document.getElementById("Modalrut").value,
        CompanyActual: document.getElementById("CompanyActual").innerHTML,
      },
    },
    destroy: true,
  });
}

function limpiar() {
  document.getElementById("GexTxIdBen").value = "";
  document.getElementById("GexTxBenName").value = "";
}

function selectben(n) {
  document.getElementById("selectbenef").innerHTML = n;
  if (n == 1) {
    $("#apps-modal5").modal("hide");
  }
  DatatableMultitasking2(`Beneficiario001`, 1, `Beneficiario-Modal`);
}

function AddVuelto() {
  if (parseFloat(document.getElementById("ModalVuelto2").value) > 0) {
    let SumVuelto = 0;
    if (
      Vueltos.filter(
        (vuelto) => vuelto.type === document.getElementById("VueltoPago").value,
      ).length > 0
    ) {
      SumVuelto = Vueltos.find(
        (vuelto) => vuelto.type === document.getElementById("VueltoPago").value,
      ).amount;
      Vueltos = Vueltos.filter(
        (vuelto) => vuelto.type !== document.getElementById("VueltoPago").value,
      );
    }

    Vueltos.push({
      type: document.getElementById("VueltoPago").value,
      amount:
        parseFloat(document.getElementById("ModalVuelto2").value) + SumVuelto,
    });
    ActualizarVuelto();
    let VueltoTotal = 0;
    Vueltos.forEach((vuelto) => {
      VueltoTotal += vuelto.amount;
    });

    document.getElementById("ModalVuelto2").value = parseFloat(
      Number(document.getElementById("ModalVuelto").value) - VueltoTotal,
    ).toFixed(document.getElementById("CD").innerHTML);
    $("#ModalVuelto2").focus().select();
  }
}

function deletepago(id) {
  Vueltos = Vueltos.filter((vuelto) => {
    if (Number(vuelto.type) === Number(id)) return false;
    return true;
  });
  ActualizarVuelto();
  let VueltoTotal = 0;
  Vueltos.forEach((vuelto) => {
    VueltoTotal += vuelto.amount;
  });

  document.getElementById("ModalVuelto2").value = parseFloat(
    Number(document.getElementById("ModalVuelto").value) - VueltoTotal,
  ).toFixed(document.getElementById("CD").innerHTML);
  $("#ModalVuelto2").focus().select();
}

function Totalizarmp4(form) {
  let VueltosTotal = 0;
  Vueltos.forEach((vuelto) => {
    VueltosTotal += vuelto.amount;
  });
  var ModalVuelto = new Number(document.getElementById("ModalVuelto").value);
  var ModalVuelto2 = new Number(document.getElementById("ModalVuelto2").value);

  if (form.id === "ModalVuelto2") {
    if (ModalVuelto2 + VueltosTotal > ModalVuelto) {
      ModalVuelto2 = ModalVuelto - VueltosTotal;
    }
  }
  document.getElementById("ModalVuelto2").value = parseFloat(
    ModalVuelto2,
  ).toFixed(document.getElementById("CD").innerHTML);
}

function ActualizarVuelto() {
  let html = ``;
  Vueltos.forEach((vuelto) => {
    html += `
      <div class="col-12 col-lg-6 p-1">
        <div class="col">
          <div class="form-floating">
            <input class="form-control text-end" style="font-size: 1.5em;" type="text" value="${Formato(
              vuelto.amount,
              document.getElementById("CD").innerHTML,
              document.getElementById("SimDec").innerHTML,
              document.getElementById("SimMil").innerHTML,
            )}" disabled  >
            <label>${Utils.Num402}</label>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-6 p-1">
        <div class="input-group">
          <div class="col">
            <div class="form-floating">
              <select class="form-control" disabled>
                <option value="1" ${vuelto.type === "1" ? "selected" : ""}>
                  ${Utils.LitEfectivo}
                </option>
                <option value="2" ${vuelto.type === "2" ? "selected" : ""}>
                  ${Utils.LitTarjeta}
                </option>
                <option value="3" ${vuelto.type === "3" ? "selected" : ""}>
                  ${Utils.LitCheque}
                </option>
                <option value="4" ${vuelto.type === "4" ? "selected" : ""}>
                  ${Utils.LitO01}
                </option>
                <option value="5" ${vuelto.type === "5" ? "selected" : ""}>
                  ${Utils.LitO02}
                </option>
                <option value="6" ${vuelto.type === "6" ? "selected" : ""}>
                  ${Utils.LitO03}
                </option>
                <option value="7" ${vuelto.type === "7" ? "selected" : ""}>
                  ${Utils.LitO04}
                </option>
              </select>
              <label>${Utils.Num401}</label>
            </div>
          </div>
          <button class="btn btn-outline-danger px-1" onclick="deletepago(${
            vuelto.type
          })"><i class="fa fa-times"></i></button>
        </div>
      </div>
    `;
  });
  $("#VueltosAgregados").html(html);
}

// --- ACTUALIZAR TASA SEGÚN FECHA ---
$(document).on('change', '#GenTxFechO', function() {
    let fechaSeleccionada = $(this).val();
    let idCompany = document.getElementById("CompanyActual").innerHTML;

    if (fechaSeleccionada) {
        $.ajax({
            type: "POST",
            url: "estadocbseek.php",
            data: {
                Accion: "BuscarTasaPorFecha",
                Fecha: fechaSeleccionada,
                CompanyActual: idCompany
            },
            success: function(response) {
                let res = JSON.parse(response);
                if (res.status === true) {
                    // Actualizamos el campo de Tasa Real con el valor traído
                    // Suponiendo que el valor viene en res.tasa
                    $("#GenTxFactorDeCambioActual").val(res.tasa);
                    
                    // Disparamos el recálculo de montos automáticamente
                    if (typeof AjustarCalculoMoneda === 'function') {
                        AjustarCalculoMoneda();
                    }
                }
            }
        });
    }
});

function ProcesarEND() {
    var fecha = new Date();
    var mes = fecha.getMonth() + 1;
    var dia = fecha.getDate();
    var ano = fecha.getFullYear();
    if (dia < 10) {
        dia = "0" + dia;
    }
    if (mes < 10) {
        mes = "0" + mes;
    }
    var fectx = ano + "-" + mes + "-" + dia;

    // ========================================================
    // ¡AQUÍ ESTÁ LA MAGIA! 
    // Obligamos al sistema a usar SIEMPRE la "Tasa Real" 
    // de la cajita de texto con todos sus decimales.
    // ========================================================
    let Tasa = document.getElementById("GenTxFactorDeCambioActual").value;
    if (Tasa) {
        Tasa = Tasa.replace(/,/g, ''); // Quitamos comas por seguridad
    } else {
        Tasa = 1;
    }
    // ========================================================

    if (fectx >= document.getElementById("GenTxFechO").value) {
        if (
            document.getElementById("GenTxFechO").value <=
            document.getElementById("GenTxFechV").value
        ) {
            if (
                document.getElementById("GexTxIdBen").value.trim() !== "" &&
                document.getElementById("GexTxBenName").value.trim() !== ""
            ) {
                if (document.getElementById("GenTxMontoTotal2").value > 0) {
                    $("#apps-modal5").modal("hide");
                    $("#modal-proce").modal("show");
                    
                    $.ajax({
                        type: "POST",
                        url: "estadocbseek.php",
                        data: {
                            Accion: "11",
                            ano: document.getElementById("GenTxAño").value,
                            mes: document.getElementById("GenTxMes").value,
                            numz: document.getElementById("GexTxnumz").value,
                            nroControl: document.getElementById("GexTxnroControl").value,
                            IdAlm: document.getElementById("AlmacenSelect").value,
                            Referencia: document.getElementById("GenTxRefere").value,
                            Tasa: Tasa, // <--- Aquí se envía la Tasa Real a la base de datos
                            CompanyActual: document.getElementById("CompanyActual").innerHTML,
                            userCompany: document.getElementById("userCompany").innerHTML,
                            IdUser: document.getElementById("userlogin").innerHTML,
                            correo: document.getElementById("correorep").innerHTML,
                            IdEstacion: document.getElementById("tokeninUse").value,
                            IdImpuesto: document.getElementById("GenTxImpuestos").value,
                            Exento: document.getElementById("GenTxMontoExe").value,
                            Impuesto: document.getElementById("GenTxMontoImpuesto").value,
                            Imponible: document.getElementById("GenTxMontoImponible").value,
                            DAmpliado: document.getElementById("GexTxObservacion").value,
                            IdBen: document.getElementById("GexTxIdBen").value,
                            Idtipotx: document.getElementById("GenTxIdtipotx").value,
                            TxfecVence: document.getElementById("GenTxFechV").value,
                            Fectxclient: document.getElementById("GenTxFechO").value,
                            MonedaP: document.getElementById("MonedaP").innerHTML,
                            MonedaS: document.getElementById("MonedaS").innerHTML,
                            CD: document.getElementById("CD").innerHTML,
                            SimDec: document.getElementById("SimDec").innerHTML,
                            SimMil: document.getElementById("SimMil").innerHTML,
                        },
                    }).done(function (msg) {
                        $("#modal-proce").modal("hide");
                        $("button").prop("disabled", false);
                        avance = false;
                        if (msg === "0") {
                            alert("error al procesar");
                        } else {
                            ActTable();
                        }
                    });
                } else {
                    alertBootstrap(
                        Utils.Num009.title,
                        Utils.Num009.desc,
                        "warning",
                        "alertaerrorenproducto",
                        true,
                        1,
                    );
                    $("#GenTxMontoExe").focus();
                    $("button").prop("disabled", false);
                    avance = false;
                }
            } else {
                alertBootstrap(
                    Utils.Num008.title,
                    Utils.Num008.desc,
                    "warning",
                    "alertaerrorenproducto",
                    true,
                    1,
                );
                $("#GexTxBenName").focus();
                $("button").prop("disabled", false);
                avance = false;
            }
        } else {
            alertBootstrap(
                Utils.Num007.title,
                Utils.Num007.desc,
                "warning",
                "alertaerrorenproducto",
                true,
                1,
            );
            $("#GenTxFechV").focus();
            $("button").prop("disabled", false);
            avance = false;
        }
    } else {
        alertBootstrap(
            Utils.Num006.title,
            Utils.Num006.desc,
            "warning",
            "alertaerrorenproducto",
            true,
            1,
        );
        $("#GenTxFechO").focus();
        $("button").prop("disabled", false);
        avance = false;
    }
}


// =====================================================================
// FUNCION PARA REIMPRIMIR RETENCION ISLR EN FORMATO PDF CORRECTO (AJAX)
// =====================================================================
window.ReimprimirISLR = function(Idtx, Idtipotx, IdEstacion, Item) {
    let companyElement = document.getElementById("CompanyActual");
    let idCompany = companyElement ? companyElement.innerHTML : "0";

    if(typeof $("#LoadingScreen").show === 'function') $("#LoadingScreen").show();

    $.ajax({
        type: "POST",
        url: "formatoislr.php",
        data: {
            Idtx: Idtx,
            Idtipotx: Idtipotx,
            IdEstacion: IdEstacion,
            Item: Item,
            CompanyActual: idCompany
        },
        success: function(htmlResponse) {
            if(typeof $("#LoadingScreen").hide === 'function') $("#LoadingScreen").hide();
            
            var printWindow = window.open('', '', 'width=900,height=650');
            if(!printWindow) {
                alert("Por favor, permite las ventanas emergentes (pop-ups) en tu navegador para poder imprimir el comprobante.");
                return;
            }
            
            printWindow.document.open();
            printWindow.document.write(htmlResponse);
            printWindow.document.close();
            printWindow.focus();
        },
        error: function() {
            if(typeof $("#LoadingScreen").hide === 'function') $("#LoadingScreen").hide();
            alert("Error al intentar generar el comprobante.");
        }
    });
};

// =====================================================================
// ACTUALIZAR TASA AUTOMÁTICAMENTE AL CAMBIAR FECHA DE TRANSACCIÓN
// =====================================================================
$(document).on('change', '#GenTxFechO', function() {
    let fechaSeleccionada = $(this).val(); 
    let idCompany = document.getElementById("CompanyActual") ? document.getElementById("CompanyActual").innerHTML : "";

    if (fechaSeleccionada && idCompany) {
        $.ajax({
            type: "POST",
            url: "estadocbseek.php",
            data: {
                Accion: "BuscarTasaPorFecha",
                Fecha: fechaSeleccionada,
                CompanyActual: idCompany
            },
            success: function(response) {
                try {
                    let res = JSON.parse(response);
                    if (res.status === true) {
                        // 1. Forzamos a que el selector muestre la nueva tasa (Ej: BCV 427.93)
                        $("#GenTxFactorDCambio option[value!='0'][value!='-1']").first().val(res.tasa).text("BCV (" + res.tasa + ")");
                        
                        // 2. Aplicamos el valor al select si no está en Libre (-1)
                        if ($("#GenTxFactorDCambio").val() !== "0" && $("#GenTxFactorDCambio").val() !== "-1") {
                            $("#GenTxFactorDCambio").val(res.tasa);
                        }
                        
                        // 3. Inyectamos la tasa con los decimales exactos en el campo bloqueado "Tasa Real"
                        $("#GenTxFactorDeCambioActual").val(res.tasa);
                        
                        // 4. Disparamos la conversión matemática para que cambien los Bolívares al instante
                        if (typeof CambioAnbio === 'function') {
                            CambioAnbio(); 
                        }
                    }
                } catch(e) {
                    console.error("Error al parsear tasa: ", e);
                }
            }
        });
    }
});
// =====================================================================
function GenerarTranx() {
    // --- 1. VALIDACIÓN: N° DE TRANSACCIÓN OBLIGATORIO ---
    let numRef = document.getElementById("GenTxRefere").value.trim();
    if (numRef === "") {
        alertBootstrap("Falta Información", "El campo N° de Transacción es obligatorio.", "danger", "alertaerrorenproducto", true, 1);
        document.getElementById("GenTxRefere").focus();
        return; 
    }

    // --- 2. CONVERSIÓN INVERSA CON PRECISIÓN MATEMÁTICA ---
    let modoMoneda = document.getElementById("ModoIngresoMoneda");
    if (modoMoneda && modoMoneda.value === "VES") {
        let factor = parseFloat(document.getElementById("GenTxFactorDeCambioActual").value.replace(/,/g, '')) || 1;
        
        if (factor > 0) {
            let camposAConvertir = [
                "GenTxMontoImponible", 
                "GenTxMontoExe", 
                "GenTxMontoImpuesto", 
                "GenTxSubTotal", 
                "GenTxMontoTotal"
            ];
            
            camposAConvertir.forEach(id => {
                let input = document.getElementById(id);
                if (input) {
                    let valorVES = parseFloat(input.value.replace(/,/g, '')) || 0;
                    
                    // AQUÍ ESTÁ EL CAMBIO: Conservamos 8 decimales en las operaciones
                    // Esto asegura que la regla de "Imponible + Impuesto = Total" cuadre perfectamente
                    input.value = (valorVES / factor).toFixed(8); 
                }
            });

            modoMoneda.value = "USD";
        }
    }

    // --- 3. EJECUCIÓN ORIGINAL NATIVA ---
    if (avance === false) {
        avance = true;
        $("button").prop("disabled", true);

        clearTimeout(onlyOne);

        onlyOne = setTimeout(() => ProcesarEND(), 700);
    }
}




// =====================================================================
// 1. SCRIPT DE LA EMISIÓN Y ETIQUETAS DINÁMICAS (LIMPIO)
// =====================================================================
function CambiarEtiquetaControl() {
    let selector = document.getElementById("GexTxnumz");
    let etiquetaSuperior = document.getElementById("LabelNroControl");

    // Previene errores si la ventana modal aún no se ha abierto
    if (!selector || !etiquetaSuperior) return;

    if (selector.value === "2") {
        // --- CASO: FORMA LIBRE ---
        etiquetaSuperior.innerHTML = "N° Control";
        etiquetaSuperior.style.color = ""; // Regresa al color gris original
        etiquetaSuperior.style.fontWeight = "normal";
    } else {
        // --- CASO: FACTURA FISCAL ---
        etiquetaSuperior.innerHTML = "Serial Fiscal";
        etiquetaSuperior.style.color = "#dc3545"; // Lo pone en ROJO
        etiquetaSuperior.style.fontWeight = "bold"; // Lo pone en Negrita
    }
}

// Escuchador forzado para asegurar que funcione al hacer clic
$(document).on('change', '#GexTxnumz', function() {
    CambiarEtiquetaControl();
});

// Escuchador forzado para asegurar que funcione al hacer clic
$(document).on('change', '#GexTxnumz', function() {
    CambiarEtiquetaControl();
});

// =====================================================================
// 2. LÓGICA MAESTRA PARA INVERTIR CÁLCULO DE MONEDAS
// =====================================================================
// =====================================================================
// 2. LÓGICA MAESTRA PARA INVERTIR CÁLCULO Y SACAR "TASA REAL"
// =====================================================================
function AjustarCalculoMoneda() {
    let modo = document.getElementById("ModoIngresoMoneda") ? document.getElementById("ModoIngresoMoneda").value : "USD";
    let monedaS = document.getElementById("MonedaS") ? document.getElementById("MonedaS").innerHTML : "Bs";
    
    let strImponible = document.getElementById("GenTxMontoImponible").value.replace(/,/g, '');
    let strExento = document.getElementById("GenTxMontoExe").value.replace(/,/g, '');
    
    let imponible = parseFloat(strImponible) || 0;
    let exento = parseFloat(strExento) || 0;
    
    let selectImp = document.getElementById("GenTxImpuestos");
    let idImp = selectImp ? selectImp.value : 0;
    let spanImp = document.getElementById("ValorImpuesto" + idImp);
    let pctImpuesto = spanImp ? (parseFloat(spanImp.innerText) || 0) : 0;

    // Cálculos Nativos (de Bolívares o Dólares según el modo)
    let impuesto = imponible * (pctImpuesto / 100);
    let subTotal = imponible + impuesto;
    let totalBase = subTotal + exento;

    document.getElementById("GenTxMontoImpuesto").value = impuesto.toFixed(2);
    document.getElementById("GenTxSubTotal").value = subTotal.toFixed(2);
    document.getElementById("GenTxMontoTotal").value = totalBase.toFixed(2);

    let labelTotalBase = document.getElementById("LabelTotalBase");
    let labelTotalConv = document.getElementById("LabelTotalConvertido");
    let labelFactor = document.getElementById("LabelFactorCambio");

    let inputTotal2 = document.getElementById("GenTxMontoTotal2");
    let inputFactor = document.getElementById("GenTxFactorDeCambioActual");
    let selectorTasa = document.getElementById("GenTxFactorDCambio");
    
    let tasaSelector = parseFloat(selectorTasa.value);

    if (modo === "USD") {
        // --- MODO NORMAL (DIVISAS) ---
        if (labelTotalBase) labelTotalBase.innerHTML = '<i class="fa fa-money"></i> Total (Divisas)';
        if (labelTotalConv) labelTotalConv.innerHTML = 'Total Convertido (x Tasa) ' + monedaS;
        if (labelFactor) labelFactor.innerHTML = 'Factor de Cambio';

        // Bloqueamos el total convertido porque es solo de lectura
        inputTotal2.readOnly = true;
        
        // Manejo de tasa Libre vs Predefinida
        if (tasaSelector === -1) {
            inputFactor.disabled = false;
        } else {
            inputFactor.disabled = true;
            inputFactor.value = tasaSelector; // Trae todos los decimales del DB
        }

        let factor = parseFloat(inputFactor.value) || 1;
        let totalConvertido = totalBase * factor;
        inputTotal2.value = totalConvertido.toFixed(2);

    } else {
        // --- MODO INVERSO (BOLÍVARES) CON TASA REAL ---
        if (labelTotalBase) labelTotalBase.innerHTML = '<i class="fa fa-money"></i> Total (' + monedaS + ')';
        if (labelTotalConv) labelTotalConv.innerHTML = 'Total Divisas (Editable)';
        if (labelFactor) labelFactor.innerHTML = 'Tasa Real';

        // Permitimos editar las Divisas, pero bloqueamos la Tasa (porque es auto-calculada)
        inputTotal2.readOnly = false; 
        inputFactor.disabled = true; 

        if (tasaSelector === -1) {
            // Si es tasa Libre, esperamos a que el usuario escriba las Divisas manualmente
            let totalDivisas = parseFloat(inputTotal2.value) || 0;
            let tasaReal = totalDivisas > 0 ? (totalBase / totalDivisas) : 1;
            inputFactor.value = tasaReal.toFixed(8);
        } else {
            // Generamos las divisas redondeadas base a la tasa del selector
            let totalDivisas = tasaSelector > 0 ? (totalBase / tasaSelector) : 0;
            inputTotal2.value = totalDivisas.toFixed(2);
            
            // LA MAGIA: Calculamos la "Tasa Real" a partir del Total BCV / Divisas Redondeadas
            let totalDivisasRounded = parseFloat(inputTotal2.value) || 0;
            let tasaReal = totalDivisasRounded > 0 ? (totalBase / totalDivisasRounded) : 1;
            inputFactor.value = tasaReal.toFixed(8);
        }
    }
}

// Nueva función para recalcular la Tasa Real si el usuario modifica los centavos de las divisas manualmente
function RecalcularTasaReal() {
    let modo = document.getElementById("ModoIngresoMoneda") ? document.getElementById("ModoIngresoMoneda").value : "USD";
    if(modo !== "VES") return;

    let totalBase = parseFloat(document.getElementById("GenTxMontoTotal").value.replace(/,/g, '')) || 0;
    let totalDivisas = parseFloat(document.getElementById("GenTxMontoTotal2").value.replace(/,/g, '')) || 0;
    
    let tasaReal = 1;
    if(totalDivisas > 0) {
        tasaReal = totalBase / totalDivisas;
    }
    
    // Inyecta la nueva Tasa Real exacta
    document.getElementById("GenTxFactorDeCambioActual").value = tasaReal.toFixed(8);
}

// Parches para compatibilidad con eventos HTML antiguos de tu sistema (Evitan errores)
function CambioAnbio() { AjustarCalculoMoneda(); }
function FactorDoChange() { AjustarCalculoMoneda(); }
function DoChangeFactor() { AjustarCalculoMoneda(); }
					

function changTipotx() {
  if (
    document.getElementById("GenTxIdtipotx").value == "22" ||
    document.getElementById("GenTxIdtipotx").value == "28"
  ) {
    $("#GenTxMontoImponible").prop("disabled", true).val(0);
    Totalimb();
  } else {
    $("#GenTxMontoImponible").prop("disabled", false);
  }
}

function ModalGeneraTx() {
  var fecha = new Date();
  var mes = fecha.getMonth() + 1;
  var dia = fecha.getDate();
  var ano = fecha.getFullYear();
  document.getElementById("GenTxMes").value = mes;
  if (dia < 10) {
    dia = "0" + dia;
  }
  if (mes < 10) {
    mes = "0" + mes;
  }
  document.getElementById("GenTxFechO").value = ano + "-" + mes + "-" + dia;
  document.getElementById("GenTxFechV").value = ano + "-" + mes + "-" + dia;
  AñosActuales();

  document.getElementById("GenTxMontoTotal").value = 0;
  document.getElementById("GenTxSubTotal").value = 0;
  document.getElementById("GenTxMontoImponible").value = 0;
  document.getElementById("GenTxMontoExe").value = 0;
  document.getElementById("GenTxMontoImpuesto").value = 0;
  if (document.getElementById("Modalrut").value.trim() !== "") {
    document.getElementById("GexTxIdBen").value =
      document.getElementById("Modalrut").value;
    document.getElementById("GexTxBenName").value =
      document.getElementById("Modalnombre").value;
  } else {
    document.getElementById("GexTxIdBen").value = "";
    document.getElementById("GexTxBenName").value = "";
  }
  document.getElementById("GenTxIdtipotx").value = "2";
  document.getElementById("GexTxObservacion").value = "";
  document.getElementById("GexTxnroControl").value = "0";
  document.getElementById("GexTxnumz").value = "0";
  document.getElementById("LimiCreditoA").innerHTML = 0;
  if (Number(document.getElementById("LimiCreditoA").innerHTML) === 0) {
    LimitCredit = "Ilimitado";
    document.getElementById("LimitCreditCar").innerHTML = LimitCredit;
  } else {
    LimitCredit =
      Number(document.getElementById("LimiCreditoA").innerHTML) -
      Number(document.getElementById("CreditoTotalA").innerHTML);
    document.getElementById("LimitCreditCar").innerHTML = Formato(
      LimitCredit,
      document.getElementById("CD").innerHTML,
      document.getElementById("SimDec").innerHTML,
      document.getElementById("SimMil").innerHTML,
    );
  }
  CambioAnbio();
  Totalimb();
  $("#apps-modal5").modal("show");
}

function CreditTrans() {
  if (Number(document.getElementById("LimiCreditoA").innerHTML) === 0) {
    LimitCredit = "Ilimitado";
    document.getElementById("LimitCreditTrans").innerHTML = LimitCredit;
  } else {
    LimitCredit =
      Number(document.getElementById("LimiCreditoA").innerHTML) -
      Number(document.getElementById("CreditoTotalA").innerHTML);
    document.getElementById("LimitCreditTrans").innerHTML = Formato(
      LimitCredit / (1 + Impuesto / 100),
      document.getElementById("CD").innerHTML,
      document.getElementById("SimDec").innerHTML,
      document.getElementById("SimMil").innerHTML,
    );
  }
}

function Recibir4(CodIdBasico, Descripcion) {
  $("#ledner").html("");
  $("#apps-modal4").modal("show");
  document.getElementById("algov22").innerHTML = Descripcion;
  $.ajax({
    type: "POST",
    url: "Flujodedinerorepallseek.php",
    data: {
      Accion: "3",
      userperfil: document.getElementById("userperfil").innerHTML,
      descri: Descripcion,
      Id: CodIdBasico,
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
    },
  }).done(function (msg) {
    $("#ledner").html(msg);
  });
}

function resetfoto(Cod) {
  $.ajax({
    type: "POST",
    url: "Flujodedinerorepallseek.php",
    data: {
      Accion: "3",
      userperfil: document.getElementById("userperfil").innerHTML,
      Id: Cod,
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
    },
  }).done(function (msg) {
    $("#ledner").html(msg);
  });
}

function Enviar() {
  $.ajax({
    type: "POST",
    url: "estadocbseek.php",
    data: { Accion: "1", Ini: "0" },
  }).done(function (msg) {
    $("#DatatablesFD").html(msg);
    var fecha = new Date(document.getElementById("Modaldesde").value);
    var fechaa = new Date(document.getElementById("Modalhasta").value);
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
    $("#estadocbtable").DataTable({
      search: {
        search: $(
          `#${"estadocbtable"}_wrapper .dt-layout-row .dt-end .dt-search .dt-input`,
        ).val(),
      },
      responsive: true,
      processing: true,
      serverSide: true,
      language: {
        url: language,
      },
      ajax: {
        type: "POST",
        url: "estadocbseek.php",
        data: {
          Accion: "1",
          Ini: "1",
          Modalnroid: document.getElementById("Modalnroid").value,
          Modalhasta: valor7,
          Modaldesde: valor6,
          Modalmodalidad: document.getElementById("Modalmodalidad").value,
          Modaltipotrans: document.getElementById("Modaltipotrans").value,
          MonedaP: document.getElementById("MonedaP").innerHTML,
          CompanyActual: document.getElementById("CompanyActual").innerHTML,
          MonedaS: document.getElementById("MonedaS").innerHTML,
          CD: document.getElementById("CD").innerHTML,
          SimDec: document.getElementById("SimDec").innerHTML,
          SimMil: document.getElementById("SimMil").innerHTML,
        },
      },
      columns: [null, null, null, null, null, null, null],
      order: [[0, "asc"]],
    });
  });
  $("#apps-modal").modal("show");
}

function Credito() {
  var a = new Number(0);
  document.getElementById("IdtipotxActual").innerHTML = "25";
  document.getElementById("ModalMonto").value = a.toFixed(
    document.getElementById("CD").innerHTML,
  );
  document.getElementById("ModalMonto2").value = a.toFixed(
    document.getElementById("CD").innerHTML,
  );
  document.getElementById("ModalEA").value = "";
  document.getElementById("ModalReferencia").value = "";
  ati(3);
}

function todos() {
  x(1);
  x(2);
}

function fechas() {
  var fecha = new Date();
  var mes = fecha.getMonth() + 1;
  var dia = fecha.getDate();
  var ano = fecha.getFullYear();
  var h = fecha.getHours();
  var mn = fecha.getMinutes();
  var s = fecha.getSeconds();
  if (dia < 10) {
    dia = "0" + dia;
  }
  if (mes < 10) {
    mes = "0" + mes;
  }
  document.getElementById("Modaldesde").value =
    ano + "-" + mes + "-" + dia + "T00:00";
  document.getElementById("Modalhasta").value =
    ano + "-" + mes + "-" + dia + "T23:59:59";
  document.getElementById("fectx").value =
    dia + "/" + mes + "/" + ano + " " + h + ":" + mn + ":" + s;
  document.getElementById("fechaktual").innerHTML = ano + "-" + mes + "-" + dia;
  document.getElementById("Fechadeltipodpago").value =
    ano + "-" + mes + "-" + dia;
  document.getElementById("ModalFecha").value = ano + "-" + mes + "-" + dia;
  document.getElementById("fechadehoy").value = ano + "," + mes + "," + dia;
}

function ActTable() {
  const CajaC =
    dataCaja?.find(
      (caja) => caja.token === document.getElementById("tokeninUse").value,
    )?.CajaActual ?? "0";
  var fecha = new Date(document.getElementById("ModaldesdeA").value);
  var fechaa = new Date(document.getElementById("ModalhastaA").value);
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
  $("#TableResponse").hide();
  $("#LoadingScreen").show();
  $("#backreporte2").html(CargandoHTML);
  $("#backreporte2AB").hide();

  if (document.getElementById("Modalrut").value.trim() !== "") {
    if (CajaC == "0") {
      $("#headerprintxd2").html(
        `
          <div class="btn-group">
            <button class="btn btn-primary fs-6 p-1" type="button" onclick="ModalGeneraTx();">
              <i class="fa fa-exchange fs-3"></i><br> ${Utils.Num038}
            </button>
            <button class="btn btn-success fs-6 p-1" type="button" onclick="Enviar(); todos();">
              <i class="fa fa-search fs-3"></i><br> ${Utils.Num003}
            </button>
            <button class="btn btn-info fs-6 p-1" type="button" onclick="selectben(0);">
              <i class="fa fa-user fs-3"></i><br> ${Utils.Num004}
            </button>
            <button class="btn btn-danger fs-6 p-1" type="button" onclick="AgregarBeneficiario();">
              <i class="fa fa-users fs-3"></i><br> ${Utils.AgrBene}
            </button>
            <button class="btn btn-secondary fs-6 p-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#demo">
              <i class="fa fa-filter fs-3"></i> <br> ${Utils.Filtros}
            </button>
  
            <button class="btn btn-light fs-6 p-1" type="button" onclick="ImprimirEstado();">
              <i class="fa fa-print fs-3"></i> <br> ${Utils.Imprimir}
            </button>
   
          </div>

          `,

        //         <button class="btn btn-dark fs-6 p-1" type="button" onclick="PagoUnico();">
        //   <i class="fa fa-dollar fs-3"></i> <br> ${Utils.Pago}
        // </button>
      );
    } else {
      $("#headerprintxd2").html(
        `
          <div class="btn-group">
            <button class="btn btn-primary fs-6 p-1" type="button" onclick="ModalGeneraTx();">
              <i class="fa fa-exchange fs-3"></i><br> ${Utils.Num038}
            </button>
            <button class="btn btn-success fs-6 p-1" type="button" onclick="Enviar(); todos();">
              <i class="fa fa-search fs-3"></i><br> ${Utils.Num003}
            </button>
            <button class="btn btn-info fs-6 p-1" type="button" onclick="selectben(0);">
              <i class="fa fa-user fs-3"></i><br> ${Utils.Num004}
            </button>
            <button class="btn btn-warning fs-6 p-1" type="button" onclick="Credito();">
              <i class="fa fa-money fs-3"></i><br>  ${Utils.Num005}
            </button>
            <button class="btn btn-danger fs-6 p-1" type="button" onclick="AgregarBeneficiario();">
              <i class="fa fa-users fs-3"></i><br> ${Utils.AgrBene}
            </button>
            <button class="btn btn-secondary fs-6 p-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#demo">
              <i class="fa fa-filter fs-3"></i> <br> ${Utils.Filtros}
            </button>
  
            <button class="btn btn-light fs-6 p-1" type="button" onclick="ImprimirEstado();">
              <i class="fa fa-print fs-3"></i> <br> ${Utils.Imprimir}
            </button>
            <button class="btn btn-dark fs-6 p-1" type="button" onclick="PagoUnico();">
              <i class="fa fa-dollar fs-3"></i> <br> ${Utils.Pago}
            </button>
   
   
          </div>

          `,

        //         <button class="btn btn-dark fs-6 p-1" type="button" onclick="PagoUnico();">
        //   <i class="fa fa-dollar fs-3"></i> <br> ${Utils.Pago}
        // </button>
      );
    }
    if (document.getElementById("userperfil").innerHTML <= 2000 || verTx == 1) {
      $("#CheckCK").show();
    } else {
      $("#CheckCK").hide();
    }
  } else if (CajaC == "0") {
    $("#headerprintxd2").html(`
          <div class='btn-group'>
            <button class="btn btn-info fs-6 p-1" type="button" onclick="selectben(0);">
              <i class="fa fa-user fs-3"></i><br> ${Utils.Num004}
            </button>
            <button class="btn btn-danger fs-6 p-1" type="button" onclick="AgregarBeneficiario();">
              <i class="fa fa-users fs-3"></i><br> ${Utils.AgrBene}
            </button>
            </div>
        `);
  } else {
    $("#headerprintxd2").html(
      `
            <div class='btn-group'>
            <button class="btn btn-success fs-6 p-1" type="button" onclick="Enviar(); todos();">
              <i class="fa fa-search fs-3"></i><br> ${Utils.Num003}
            </button>
            <button class="btn btn-info fs-6 p-1" type="button" onclick="selectben(0);">
              <i class="fa fa-user fs-3"></i><br> ${Utils.Num004}
            </button>
            <button class="btn btn-warning fs-6 p-1" type="button" onclick="Credito();">
              <i class="fa fa-money fs-3"></i><br>  ${Utils.Num005}
            </button>
            <button class="btn btn-danger fs-6 p-1" type="button" onclick="AgregarBeneficiario();">
              <i class="fa fa-users fs-3"></i><br> ${Utils.AgrBene}
            </button>
            </div>
          `,
    );
  }

  $.ajax({
    type: "POST",
    url: "estadocbseek.php",
    data: {
      Accion: "3",
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      IdBen: document.getElementById("Modalrut").value,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      userperfil: document.getElementById("userperfil").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      Modaldesde: valor6,
      Modalhasta: valor7,
      CajaC: CajaC,
    },
  }).done(function (msg) {
    $("#backreporte3").html(msg);
    $.ajax({
      type: "POST",
      url: "estadocbseek.php",
      data: {
        Accion: "2",
        CompanyActual: document.getElementById("CompanyActual").innerHTML,
        userperfil: document.getElementById("userperfil").innerHTML,
        Fecha: document.getElementById("fechaktual").innerHTML,
        IdBen: document.getElementById("Modalrut").value,
        litfiscal: document.getElementById("litfiscal").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        MonedaS: document.getElementById("MonedaS").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        IdBen: document.getElementById("Modalrut").value,
        MostrarTodos: $("#MostrarTodos").prop("checked") ? "1" : "0",
        OrderBy: document.getElementById("OrderBy").value,
        SortBy: document.getElementById("SortBy").value,
        Modaldesde: valor6,
        Modalhasta: valor7,
        CajaC: CajaC,
        LitEfectivo: document.getElementById("LitEfectivo").innerHTML,
        LitTarjeta: document.getElementById("LitTarjeta").innerHTML,
        LitCheque: document.getElementById("LitCheque").innerHTML,
        LitO01: document.getElementById("LitO01").innerHTML,
        LitO02: document.getElementById("LitO02").innerHTML,
        LitO03: document.getElementById("LitO03").innerHTML,
        LitO04: document.getElementById("LitO04").innerHTML,
      },
    }).done(function (msg) {
      $("#backreporte2").html("");
      $("#backreporte2AB").show();
      arrayTable = JSON.parse(msg);

      arrayABC = arrayTable.array;
      $("#TableResponse").show();
      $("#LoadingScreen").hide();

      document.getElementById("SaldoPCXXXX").innerHTML = ` (${
        document.getElementById("MonedaP").innerHTML
      }) ${Formato(
        arrayTable.general.SaldoDadoVencido,
        document.getElementById("CD").innerHTML,
        document.getElementById("SimDec").innerHTML,
        document.getElementById("SimMil").innerHTML,
      )}`;
      document.getElementById("Monto001").innerHTML = ` (${
        document.getElementById("MonedaP").innerHTML
      }) ${Formato(
        arrayTable.general.MontoTotalA,
        document.getElementById("CD").innerHTML,
        document.getElementById("SimDec").innerHTML,
        document.getElementById("SimMil").innerHTML,
      )}`;
      document.getElementById("Monto003").innerHTML = ` (${
        document.getElementById("MonedaP").innerHTML
      }) ${Formato(
        arrayTable.general.ContadoTotalA,
        document.getElementById("CD").innerHTML,
        document.getElementById("SimDec").innerHTML,
        document.getElementById("SimMil").innerHTML,
      )}`;
      document.getElementById("Monto005").innerHTML = ` (${
        document.getElementById("MonedaP").innerHTML
      }) ${Formato(
        arrayTable.general.CreditoTotalA,
        document.getElementById("CD").innerHTML,
        document.getElementById("SimDec").innerHTML,
        document.getElementById("SimMil").innerHTML,
      )}`;
      document.getElementById("Monto007").innerHTML = ` (${
        document.getElementById("MonedaP").innerHTML
      }) ${Formato(
        arrayTable.general.SaldoTotal,
        document.getElementById("CD").innerHTML,
        document.getElementById("SimDec").innerHTML,
        document.getElementById("SimMil").innerHTML,
      )}`;
      ActualizarTablaPagos();
      ActualizarTablaTAB();
    });
  });
}

function AgregarBeneficiario() {
  $("#modalBenefe").modal("show");
}

function ChangeRutFun(T) {
  var M = 0,
    S = 1;
  for (; T; T = Math.floor(T / 10)) S = (S + (T % 10) * (9 - (M++ % 6))) % 11;
  document.getElementById("ModalRut2").value = S ? S - 1 : "K";
}

function buscarunidad(n) {
  if (n == 1) {
    $.ajax({
      type: "POST",
      url: "ventaseek.php",
      data: {
        Accion: "21",
        EleccionEc: document.getElementById("EleccionEc").innerHTML,
        keyword: $("#anombreFA").val(),
        IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
        CompanyActual: document.getElementById("CompanyActual").innerHTML,
      },
      beforeSend: function () {
        $("#anombreFA").css(
          "background",
          "#FFF url('/img/procesando.gif') no-repeat 165px",
        );
      },
      success: function (data) {
        if ($("#anombreFA").is(":focus")) {
          $("#suggesstion-box").show();
          $("#suggesstion-box").html(data);
        } else {
          $("#suggesstion-box").hide();
        }
        $("#anombreFA").css("background", "#FFF");
      },
    });
  }
  if (n == 2) {
    if (document.getElementById("IdPaisAct").innerHTML == "CL") {
      if (document.getElementById("ModalRut2").value !== "") {
        var valor =
          document.getElementById("ModalRut").value +
          "-" +
          document.getElementById("ModalRut2").value;
      } else {
        var valor = document.getElementById("ModalRut").value;
      }
      var var2 = "ModalRut";
    } else {
      var valor = document.getElementById("RutFa").value;
      var var2 = "RutFa";
    }
    $.ajax({
      type: "POST",
      url: "ventaseek.php",
      data: {
        Accion: "22",
        EleccionEc: document.getElementById("EleccionEc").innerHTML,
        keyword: valor,
        CompanyActual: document.getElementById("CompanyActual").innerHTML,
      },
      beforeSend: function () {},
      success: function (data) {
        if ($("#" + var2).is(":focus")) {
          $("#suggesstion-box2").show();
          $("#suggesstion-box2").html(data);
        } else {
          $("#suggesstion-box2").hide();
        }
      },
    });
  }
  if (n == 4) {
    $.ajax({
      type: "POST",
      url: "ventaseek.php",
      data: {
        Accion: "24",
        EleccionEc: document.getElementById("EleccionEc").innerHTML,
        keyword: $("#GiroFA").val(),
        CompanyActual: document.getElementById("CompanyActual").innerHTML,
      },
      beforeSend: function () {
        $("#GiroFA").css(
          "background",
          "#FFF url('/img/procesando.gif') no-repeat 165px",
        );
      },
      success: function (data) {
        if ($("#GiroFA").is(":focus")) {
          $("#suggesstion-box4").show();
          $("#suggesstion-box4").html(data);
        } else {
          $("#suggesstion-box4").hide();
        }
        $("#GiroFA").css("background", "#FFF");
      },
    });
  }
}

function byebyemen(n) {
  if (n == 1) {
    $("#suggesstion-box2").hide();
    $("#suggesstion-box3").hide();
    $("#suggesstion-box4").hide();
    if ($("#suggesstion-box").hide()) {
      $("#suggesstion-box").show();
    }
  }
  if (n == 2) {
    $("#suggesstion-box").hide();
    $("#suggesstion-box3").hide();
    $("#suggesstion-box4").hide();
    if ($("#suggesstion-box2").hide()) {
      $("#suggesstion-box2").show();
    }
  }
  if (n == 3) {
    $("#suggesstion-box").hide();
    $("#suggesstion-box4").hide();
    $("#suggesstion-box2").hide();
    if ($("#suggesstion-box3").hide()) {
      $("#suggesstion-box3").show();
    }
  }
  if (n == 4) {
    $("#suggesstion-box").hide();
    $("#suggesstion-box2").hide();
    $("#suggesstion-box3").hide();
    if ($("#suggesstion-box4").hide()) {
      $("#suggesstion-box4").show();
    }
  }
  if (n == 5) {
    $("#suggesstion-box").hide();
    $("#suggesstion-box2").hide();
    $("#suggesstion-box4").hide();
    $("#suggesstion-box3").hide();
  }
  if (n == 6) {
    $("#suggesstion-box6").hide();
    $("#suggesstion-box7").hide();
    $("#suggesstion-box8").hide();
    if ($("#suggesstion-box5").hide()) {
      $("#suggesstion-box5").show();
    }
  }
  if (n == 7) {
    $("#suggesstion-box5").hide();
    $("#suggesstion-box7").hide();
    $("#suggesstion-box8").hide();
    if ($("#suggesstion-box6").hide()) {
      $("#suggesstion-box6").show();
    }
  }
  if (n == 8) {
    $("#suggesstion-box5").hide();
    $("#suggesstion-box6").hide();
    $("#suggesstion-box8").hide();
    if ($("#suggesstion-box7").hide()) {
      $("#suggesstion-box7").show();
    }
  }
  if (n == 9) {
    $("#suggesstion-box5").hide();
    $("#suggesstion-box6").hide();
    $("#suggesstion-box7").hide();
    if ($("#suggesstion-box8").hide()) {
      $("#suggesstion-box8").show();
    }
  }
  if (n == 10) {
    $("#suggesstion-box5").hide();
    $("#suggesstion-box6").hide();
    $("#suggesstion-box7").hide();
    $("#suggesstion-box8").hide();
  }
}

function BuscarBef(n, event) {
  var keycode = event.keyCode;
  if (keycode == "13") {
    if (n == 1) {
      if (document.getElementById("IdPaisAct").innerHTML == "CL") {
        var valor2 =
          document.getElementById("ModalRut").value +
          "-" +
          document.getElementById("ModalRut2").value.toUpperCase();
      } else {
        var valor2 = document.getElementById("RutFa").value;
      }
      $.ajax({
        type: "POST",
        url: "ventaseek.php",
        data: {
          Accion: "55",
          Opcion: n,
          RutFa: valor2,
          EleccionEc: document.getElementById("EleccionEc").innerHTML,
          IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
          CompanyActual: document.getElementById("CompanyActual").innerHTML,
        },
      }).done(function (msg) {
        $("#Temporal").html(msg);
        if (msg == "2") {
          ReBuscarBef(1);
        } else {
          $("#suggesstion-box2").hide();
          autocompletar(2, document.getElementById("RuTRenvio").innerHTML);
        }
        $("#Temporal").html("");
      });
    }
    if (n == 2) {
      var valor2 = document.getElementById("anombreFA").value;
      $.ajax({
        type: "POST",
        url: "ventaseek.php",
        data: {
          Accion: "55",
          Opcion: n,
          anombreFA: valor2,
          EleccionEc: document.getElementById("EleccionEc").innerHTML,
          IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
          CompanyActual: document.getElementById("CompanyActual").innerHTML,
        },
      }).done(function (msg) {
        $("#Temporal").html(msg);
        if (msg == "2") {
          ReBuscarBef(2);
        } else {
          $("#suggesstion-box").hide();
          autocompletar(
            1,
            document.getElementById("anombreFARenvio").innerHTML,
          );
        }
        $("#Temporal").html("");
      });
    }
  }
}

function ReBuscarBef(n) {
  if (n == 1) {
    $("#BotonBef001").prop("disabled", true);
    $("#modalBenefe").modal("hide");
    selectben(2);
    $("#BotonBef001").prop("disabled", false);
    $("#suggesstion-box2").hide();
    var table = $("#example2").DataTable();
    if (document.getElementById("IdPaisAct").innerHTML == "CL") {
      var valor2 =
        document.getElementById("ModalRut").value +
        "-" +
        document.getElementById("ModalRut2").value.toUpperCase();
    } else {
      var valor2 = document.getElementById("RutFa").value;
    }
    $("div.dataTables_filter input", table.table().container()).val(valor2);
    $("div.dataTables_filter input", table.table().container()).focus();
    table.search(valor2).draw();
  }
  if (n == 2) {
    $("#BotonBef002").prop("disabled", true);
    $("#modalBenefe").modal("hide");
    selectben(2);
    $("#BotonBef002").prop("disabled", false);
    $("#suggesstion-box").hide();
    var table = $("#example2").DataTable();
    $("div.dataTables_filter input", table.table().container()).val(
      document.getElementById("anombreFA").value,
    );
    $("div.dataTables_filter input", table.table().container()).focus();
    table.search(document.getElementById("anombreFA").value).draw();
  }
  if (n == 4) {
    $("#BotonBef004").prop("disabled", true);
    $("#modalBenefe").modal("hide");
    $("#Giro-Modal").modal("show");
    $("#BotonBef004").prop("disabled", false);
    $("#suggesstion-box4").hide();
    var table = $("#example4").DataTable();
    $("div.dataTables_filter input", table.table().container()).val(
      document.getElementById("GiroFA").value,
    );
    $("div.dataTables_filter input", table.table().container()).focus();
    table.search(document.getElementById("GiroFA").value).draw();
  }
}

function Abrir(n) {
  if (n == 1) {
    $("#apps-modal").modal("show");
    var table = $("#example").DataTable();
    $("div.dataTables_filter input", table.table().container()).focus();
  }
  if (n == 2) {
    var table = $("#example5").DataTable();
    $("#apps-modal2").modal("show");
    $("div.dataTables_filter input", table.table().container()).focus();
  }
  if (n == 3) {
    $("#boton17").prop("disabled", true);
    $("#boton18").prop("disabled", true);
    $("#boton19").prop("disabled", true);
    $("#boton20").prop("disabled", true);
    $("#boton21").prop("disabled", true);
    $("#modalBenefe").modal("hide");
    selectben(2);
    var table = $("#example2").DataTable();
    $("div.dataTables_filter input", table.table().container()).focus();
    $("#boton17").prop("disabled", false);
    $("#boton18").prop("disabled", false);
    $("#boton19").prop("disabled", false);
    $("#boton20").prop("disabled", false);
    $("#boton21").prop("disabled", false);
  }
  if (n == 4) {
    $("#modalBenefe").modal("hide");
    $("#Comuna-Modal").modal("show");
    var table = $("#example3").DataTable();
    $("div.dataTables_filter input", table.table().container()).focus();
  }
  if (n == 5) {
    $("#modalBenefe").modal("hide");
    $("#Giro-Modal").modal("show");
    var table = $("#example4").DataTable();
    $("div.dataTables_filter input", table.table().container()).focus();
  }
  if (n == 6) {
    $.ajax({
      type: "POST",
      url: "ventaseek.php",
      data: {
        Accion: "58",
        EleccionEc: document.getElementById("EleccionEc").innerHTML,
        IdUser: document.getElementById("userlogin").innerHTML,
        IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
        CompanyActual: document.getElementById("CompanyActual").innerHTML,
      },
    }).done(function (msg) {
      if (msg == 0) {
        document.getElementById("Login").focus();
        $("#modal-descuento").modal("show");
      } else {
        $("#Temporal").html("");
        $("#iwded").html(msg);
        $("#MostrarLogin").val($("#loginactual").html());
        $("#MostrarNombre").val($("#nombreactual").html());
        var a1 = new Number(document.getElementById("jsubtotalx4").innerHTML);
        var a2 = new Number(document.getElementById("jcosto2").innerHTML);
        console.log(a2);
        var a3 = new Number(0);
        $("#ventaparadcto").val(
          a1.toFixed(document.getElementById("CD").innerHTML),
        );
        $("#ventaDescuento").val(
          a1.toFixed(document.getElementById("CD").innerHTML),
        );
        $("#Costoparadcto").val(
          a2.toFixed(document.getElementById("CD").innerHTML),
        );
        if (document.getElementById("Costoparadcto").value > 0) {
          var wbe = new Number(document.getElementById("Costoparadcto").value);
        } else {
          var wbe = new Number(1);
        }
        var a =
          ((Number(document.getElementById("ventaparadcto").value) -
            Number(document.getElementById("Costoparadcto").value)) *
            100) /
          wbe;
        var b =
          Number(document.getElementById("ventaparadcto").value) -
          Number(document.getElementById("Costoparadcto").value);

        if (b < 0) {
          $("#Div1").addClass("d-none");
          $("#Div2").addClass("d-none");
          $("#Div3").removeClass("d-none");
        } else {
          $("#Div1").addClass("d-none");
          $("#Div2").removeClass("d-none");
          $("#Div3").addClass("d-none");
          $("#margenparadcto").val(a.toFixed(2));
          $("#Dctoporcentaje2").val(a.toFixed(2));
          $("#Utilidadparadcto").val(
            b.toFixed(document.getElementById("CD").innerHTML),
          );
          $("#DctoMonto2").val(
            b.toFixed(document.getElementById("CD").innerHTML),
          );
          $("#DctoMonto").val(
            a3.toFixed(document.getElementById("CD").innerHTML),
          );
          $("#Dctoporcentaje").val(a3.toFixed(2));
          PorcentajeGeneral = a3;
          var Porcentaje = new Number(
            document.getElementById("jporcedescuentox2").innerHTML,
          );
          document.getElementById("Dctoporcentaje").value = Porcentaje.toFixed(
            document.getElementById("CD").innerHTML,
          );
          PorcentajeGeneral = Porcentaje;

          DescuentoOpcio(
            document.getElementById("Dctoporcentaje"),
            document.getElementById("Dctoporcentaje").value,
          );
        }

        $("#modal-descuento").modal("show");
      }
    });
  }
}

function closeBeneficiario() {
  if (document.getElementById("IdPaisAct").innerHTML == "CL") {
    document.getElementById("ModalRut2").value = "";
    document.getElementById("ModalRut").value = "";
  } else {
    document.getElementById("RutFa").value = "";
  }
  document.getElementById("TipoBeneficiario").value = "";
  document.getElementById("GiroFA").value = "";
  document.getElementById("CiudadFA").value = "";
  document.getElementById("DirecionFA").value = "";
  document.getElementById("EmailFA").value = "";
  document.getElementById("TelefonoFA").value = "";
  document.getElementById("anombreFA").value = "";

  $("#modalBenefe").modal("show");
}

function EnviarBen(rut, nombre) {
  if (document.getElementById("selectbenef").innerHTML == "0") {
    document.getElementById("Modalrut").value = rut;
    document.getElementById("Modalnombre").value = nombre;
    document.getElementById("goodbye").innerHTML = "";
    $("#Beneficiario-Modal").modal("hide");
    ActTable();
  } else if (document.getElementById("selectbenef").innerHTML == "1") {
    document.getElementById("Modalrut").value = rut;
    document.getElementById("Modalnombre").value = nombre;
    document.getElementById("goodbye").innerHTML = "";
    $("#Beneficiario-Modal").modal("hide");
    ActTable();
  }
}

function Editar(rut, nombre) {
  document.getElementById("Modalrut").value = rut;
  document.getElementById("Modalnombre").value = nombre;
  ActTable();
  $("#apps-modal").modal("hide");
  document.getElementById("goodbye").innerHTML = "";
}

function ati(n) {
  document.getElementById("resultestadocb020").innerHTML = "";
  document.getElementById("FactorDCambio").value = 0;
  var ContadoActual = new Number(
    document.getElementById("ContadoActual").innerHTML,
  );
  var CreditoActual = new Number(
    document.getElementById("CreditoActual").innerHTML,
  );
  var RetencionActual = new Number(
    document.getElementById("RetencionActual").innerHTML,
  );
  var fecha = new Date();
  var mes = fecha.getMonth() + 1;
  var dia = fecha.getDate();
  var ano = fecha.getFullYear();
  if (dia < 10) {
    dia = "0" + dia;
  }
  if (mes < 10) {
    mes = "0" + mes;
  }
  document.getElementById("ModalFecha").value = ano + "-" + mes + "-" + dia;
  document.getElementById("Fechadeltipodpago").value =
    ano + "-" + mes + "-" + dia;
  if (n == 1) {
    document.getElementById("Modalrut").value = "";
    document.getElementById("Modalnombre").value = "";
    document.getElementById("backreporte2").innerHTML =
      $("#backreporte2").html(CargandoHTML);
    document.getElementById("backreporte3").innerHTML = "";
    document.getElementById("LimitCreditCar").innerHTML = "";
  }
  if (n == 2) {
    document.getElementById("LimitCreditCar").innerHTML = "";
    if (document.getElementById("Modalrut").value !== "") {
      $.ajax({
        type: "POST",
        url: "estadocbseek.php",
        data: {
          Accion: "9",
          CompanyActual: document.getElementById("CompanyActual").innerHTML,
          IdBen: document.getElementById("Modalrut").value,
          litfiscal: document.getElementById("litfiscal").innerHTML,
          MonedaP: document.getElementById("MonedaP").innerHTML,
          MonedaS: document.getElementById("MonedaS").innerHTML,
          CD: document.getElementById("CD").innerHTML,
          SimDec: document.getElementById("SimDec").innerHTML,
          SimMil: document.getElementById("SimMil").innerHTML,
        },
      }).done(function (msg) {
        if (msg == 0) {
          document.getElementById("resultestadocb019").innerHTML = Utils.Num031;
          $("#ModoAnticipo").hide();
          $("#CompraAnticipo").prop("checked", false);
          $("#VentaAnticipo").prop("checked", true);

          document.getElementById("palostiposdepago").innerHTML = `
            <div class="col">
              <div class="form-floating">
                <select name="TipodPagoPah" id="TipodPagoPah" class="form-select" onchange="changeornot();">
          ${
            Utils.LitEfectivo.trim() !== ""
              ? `<option value="1">${Utils.LitEfectivo}</option>`
              : ``
          }
          ${
            Utils.LitTarjeta.trim() !== ""
              ? `<option value="2">${Utils.LitTarjeta}</option>`
              : ``
          }
          ${
            Utils.LitCheque.trim() !== ""
              ? `<option value="3">${Utils.LitCheque}</option>`
              : ``
          }
          ${
            Utils.LitO01.trim() !== ""
              ? `<option value="4">${Utils.LitO01}</option>`
              : ``
          }
          ${
            Utils.LitO02.trim() !== ""
              ? `<option value="5">${Utils.LitO02}</option>`
              : ``
          }
          ${
            Utils.LitO03.trim() !== ""
              ? `<option value="6">${Utils.LitO03}</option>`
              : ``
          }
          ${
            Utils.LitO04.trim() !== ""
              ? `<option value="7">${Utils.LitO04}</option>`
              : ``
          }
                </select>
                <label>${Utils.Num400}</label>
              </div>
            </div>
          `;
          document.getElementById("decisions").innerHTML = "3";
          document.getElementById("FactorDCambio").value = 0;
          document.getElementById("ModalMonto2").value = 0;
          document.getElementById("ModalMonto").value =
            parseFloat(CreditoActual).toFixed(2);
          TipoMonedaChangin();
          changeornot();
          $("#realmenteimporta").show();
          $("#apps-modal2").modal("show");
        }
        if (msg == 1) {
          $("#modal-a").modal("show");
        }
      });
    } else {
      $("#elfixed").show();
      $("#validainfo").delay(100).fadeIn("slow");
      setTimeout(() => OcultarNotificacion2(), 5000);
    }
  }
  if (n == 3) {
    document.getElementById("LimitCreditCar").innerHTML = "";
    if (document.getElementById("Modalrut").value !== "") {
      document.getElementById("resultestadocb019").innerHTML = Utils.Num032;
      $("#ModoAnticipo").show();
      $("#CompraAnticipo").prop("checked", false);
      $("#VentaAnticipo").prop("checked", true);
      document.getElementById("palostiposdepago").innerHTML = `
        <div class="col">
          <div class="form-floating">
            <select name="TipodPagoPah" id="TipodPagoPah" class="form-select" onchange="changeornot();">
          ${
            Utils.LitEfectivo.trim() !== ""
              ? `<option value="1">${Utils.LitEfectivo}</option>`
              : ``
          }
          ${
            Utils.LitTarjeta.trim() !== ""
              ? `<option value="2">${Utils.LitTarjeta}</option>`
              : ``
          }
          ${
            Utils.LitCheque.trim() !== ""
              ? `<option value="3">${Utils.LitCheque}</option>`
              : ``
          }
          ${
            Utils.LitO01.trim() !== ""
              ? `<option value="4">${Utils.LitO01}</option>`
              : ``
          }
          ${
            Utils.LitO02.trim() !== ""
              ? `<option value="5">${Utils.LitO02}</option>`
              : ``
          }
          ${
            Utils.LitO03.trim() !== ""
              ? `<option value="6">${Utils.LitO03}</option>`
              : ``
          }
          ${
            Utils.LitO04.trim() !== ""
              ? `<option value="7">${Utils.LitO04}</option>`
              : ``
          }
            </select>
              <label>${Utils.Num400}</label>
          </div>
        </div>
      `;
      document.getElementById("decisions").innerHTML = "5";
      document.getElementById("FactorDCambio").value = document.getElementById(
        "FactorDeCambioActual",
      ).value;
      document.getElementById("ModalMonto2").value = 0;
      document.getElementById("ModalMonto").value = 0;
      document.getElementById("SaldoActual").value = Formato(
        0,
        document.getElementById("CD").innerHTML,
        document.getElementById("SimDec").innerHTML,
        document.getElementById("SimMil").innerHTML,
      );
      document.getElementById("SaldoActual2").value = Formato(
        0,
        document.getElementById("CD").innerHTML,
        document.getElementById("SimDec").innerHTML,
        document.getElementById("SimMil").innerHTML,
      );
      document.getElementById("FactorDCambio").options.selectedIndex = 1;
      TipoMonedaChangin();
      changeornot();
      $("#realmenteimporta").hide();
      $("#apps-modal2").modal("show");
    } else {
      $("#elfixed").show();
      $("#validainfo").delay(100).fadeIn("slow");
      setTimeout(() => OcultarNotificacion2(), 5000);
    }
  }
  if (n == 4) {
    document.getElementById("LimitCreditCar").innerHTML = "";
    if (document.getElementById("Modalrut").value !== "") {
      document.getElementById("resultestadocb019").innerHTML = Utils.Num033;
      $("#ModoAnticipo").hide();
      $("#CompraAnticipo").prop("checked", false);
      $("#VentaAnticipo").prop("checked", true);
      document.getElementById("palostiposdepago").innerHTML = `
        <div class="col">
          <div class="form-floating">
            <select name="TipodPagoPah" id="TipodPagoPah" class="form-select" disabled>
              <option value="10">${Utils.Retencion}</option>
            </select>
            <label>${Utils.Num400}</label>
          </div>
        </div>
      `;
      document.getElementById("decisions").innerHTML = "2";
      document.getElementById("FactorDCambio").value = 0;
      document.getElementById("ModalMonto2").value = 0;
      document.getElementById("ModalMonto").value = CreditoActual + 1;
      TipoMonedaChangin();
      changeornot();
      $("#realmenteimporta").show();
      $("#apps-modal2").modal("show");
    } else {
      $("#elfixed").show();
      $("#validainfo").delay(100).fadeIn("slow");
      setTimeout(() => OcultarNotificacion2(), 5000);
    }
  }
  if (n == 5) {
    if (document.getElementById("Modalrut").value !== "") {
      document.getElementById("resultestadocb019").innerHTML = Utils.Num034;
      $("#ModoAnticipo").hide();
      $("#CompraAnticipo").prop("checked", false);
      $("#VentaAnticipo").prop("checked", true);
      document.getElementById("palostiposdepago").innerHTML = `
            <div class="col">
              <div class="form-floating">
                <select name="TipodPagoPah" id="TipodPagoPah" class="form-select" disabled>
                  <option value="9">${Utils.Credito}</option>
                </select>
                  <label>${Utils.Num400}</label>
              </div>
            </div>
          `;
      document.getElementById("decisions").innerHTML = "1";
      document.getElementById("FactorDCambio").value = 0;
      document.getElementById("ModalMonto2").value = 0;
      document.getElementById("ModalMonto").value = ContadoActual;
      TipoMonedaChangin();
      changeornot();
      $("#realmenteimporta").show();
      $("#apps-modal2").modal("show");
    } else {
      $("#elfixed").show();
      $("#validainfo").delay(100).fadeIn("slow");
      setTimeout(() => OcultarNotificacion2(), 5000);
    }
  }
  if (n == 6) {
    document.getElementById("LimitCreditCar").innerHTML = "";
    if (document.getElementById("Modalrut").value !== "") {
      document.getElementById("resultestadocb019").innerHTML = Utils.Num030;
      $("#ModoAnticipo").hide();
      $("#CompraAnticipo").prop("checked", false);
      $("#VentaAnticipo").prop("checked", true);
      document.getElementById("palostiposdepago").innerHTML = `
            <div class="col">
              <div class="form-floating">
                <select name="TipodPagoPah" id="TipodPagoPah" class="form-select" onchange="changeornot();">
          ${
            Utils.LitEfectivo.trim() !== ""
              ? `<option value="1">${Utils.LitEfectivo}</option>`
              : ``
          }
          ${
            Utils.LitTarjeta.trim() !== ""
              ? `<option value="2">${Utils.LitTarjeta}</option>`
              : ``
          }
          ${
            Utils.LitCheque.trim() !== ""
              ? `<option value="3">${Utils.LitCheque}</option>`
              : ``
          }
          ${
            Utils.LitO01.trim() !== ""
              ? `<option value="4">${Utils.LitO01}</option>`
              : ``
          }
          ${
            Utils.LitO02.trim() !== ""
              ? `<option value="5">${Utils.LitO02}</option>`
              : ``
          }
          ${
            Utils.LitO03.trim() !== ""
              ? `<option value="6">${Utils.LitO03}</option>`
              : ``
          }
          ${
            Utils.LitO04.trim() !== ""
              ? `<option value="7">${Utils.LitO04}</option>`
              : ``
          }
                </select>
                  <label>${Utils.Num400}</label>
              </div>
            </div>
          `;
      document.getElementById("decisions").innerHTML = "6";
      $("#Temporal").html("");
      document.getElementById("FactorDCambio").value = 0;
      document.getElementById("ModalMonto2").value = 0;
      document.getElementById("ModalMonto").value = RetencionActual.toFixed(
        document.getElementById("CD").innerHTML,
      );
      TipoMonedaChangin();
      changeornot();
      $("#realmenteimporta").show();
      $("#apps-modal2").modal("show");
    } else {
      $("#elfixed").show();
      $("#validainfo").delay(100).fadeIn("slow");
      setTimeout(() => OcultarNotificacion2(), 5000);
    }
  }
  if (n == 7) {
    document.getElementById("LimitCreditCar").innerHTML = "";
    if (document.getElementById("Modalrut").value !== "") {
      document.getElementById("palostiposdepago").innerHTML = `
            <div class="col">
              <div class="form-floating">
                <select name="TipodPagoPah" id="TipodPagoPah" class="form-select" disabled>
                  <option value="8">${Utils.Anticipo}</option>
                </select>
                  <label>${Utils.Num400}</label>
              </div>
            </div>
          `;
      document.getElementById("resultestadocb019").innerHTML = Utils.Num025;
      $("#ModoAnticipo").hide();
      $("#CompraAnticipo").prop("checked", false);
      $("#VentaAnticipo").prop("checked", true);
      document.getElementById("decisions").innerHTML = "4";
      document.getElementById("resultestadocb020").innerHTML = ` - ${
        Utils.Num024
      }: ${document.getElementById("ContadoActual2").innerHTML}`;
      document.getElementById("FactorDCambio").value = 0;
      document.getElementById("ModalMonto2").value = 0;
      document.getElementById("ModalMonto").value = CreditoActual + 1;
      TipoMonedaChangin();
      changeornot();
      $("#realmenteimporta").show();
      $("#apps-modal3").modal("hide");
      $("#apps-modal2").modal("show");
      $("#Temporal").html("");
    } else {
      $("#elfixed").show();
      $("#validainfo").delay(100).fadeIn("slow");
      setTimeout(() => OcultarNotificacion2(), 5000);
    }
  }
}

function x(n) {
  if (n == 1) {
    var fecha = new Date(document.getElementById("Modaldesde").value);
    var mes = fecha.getMonth() + 1;
    var dia = fecha.getDate();
    var ano = fecha.getFullYear();
    var horai = fecha.getHours();
    var segi = fecha.getSeconds();
    var mini = fecha.getMinutes();
    if (dia < 10) {
      dia = "0" + dia;
    }
    if (mes < 10) {
      mes = "0" + mes;
    }
    document.getElementById("ModalDesded").value =
      ano + "-" + mes + "-" + dia + " " + horai + ":" + mini + ":" + segi;
  }
  if (n == 2) {
    var fechaa = new Date(document.getElementById("Modalhasta").value);
    var mesa = fechaa.getMonth() + 1;
    var diaa = fechaa.getDate();
    var anoa = fechaa.getFullYear();
    var horaf = fechaa.getHours();
    var segf = fechaa.getSeconds();
    var minf = fechaa.getMinutes();
    if (diaa < 10) {
      diaa = "0" + diaa;
    }
    if (mesa < 10) {
      mesa = "0" + mesa;
    }
    document.getElementById("ModalHastah").value =
      anoa + "-" + mesa + "-" + diaa + " " + horaf + ":" + minf + ":" + segf;
  }
}

function MaskNambar(form, n) {
  var a = new Number(n);
  if (isNaN(a)) {
    a = new Number("0");
    form.value = a.toFixed(document.getElementById("CD").innerHTML);
  } else {
    form.value = a.toFixed(document.getElementById("CD").innerHTML);
  }

  if (form.id === "GenTxMontoImponible") {
    var Exento = new Number(document.getElementById("GenTxMontoExe").value);
    var ImpuestoId = document.getElementById("GenTxImpuestos").value;
    var Impuesto = new Number(
      document.getElementById("ValorImpuesto" + ImpuestoId).innerHTML,
    );
    var Imponible = new Number(form.value);
    var total = (LimitCredit - Exento) / (1 + Impuesto / 100);
    if (LimitCredit !== "Ilimitado") {
      if (Imponible > total || Imponible < 0) {
        Imponible = total;
      }
    }
    document.getElementById("GenTxMontoImponible").value = Imponible;
  }

  if (form.id === "GenTxMontoExe") {
    var Exento = new Number(form.value);
    var ImpuestoId = document.getElementById("GenTxImpuestos").value;
    var Impuesto = new Number(
      document.getElementById("ValorImpuesto" + ImpuestoId).innerHTML,
    );
    var Imponible = new Number(
      document.getElementById("GenTxMontoImponible").value,
    );
    var total = LimitCredit - Imponible * (1 + Impuesto / 100);
    if (LimitCredit !== "Ilimitado") {
      if (Exento > total || Exento < 0) {
        Exento = total;
      }
    }
    document.getElementById("GenTxMontoExe").value = Exento;
  }

  Totalimb();
}

function CambioAnbio() {
  var Uno = new Number(1);
  var tasaVal = document.getElementById("GenTxFactorDCambio").value;

  if (tasaVal !== "-1") {
    // AQUÍ ESTÁ EL CAMBIO: Ya no usamos .toFixed(), le pasamos la tasa original completa
    document.getElementById("GenTxFactorDeCambioActual").value = tasaVal;
    
    $("#GenTxFactorDeCambioActual,#GenTxMontoTotal2").prop("disabled", true);
    Totalimb();
  } else {
    $("#GenTxFactorDeCambioActual,#GenTxMontoTotal2").prop("disabled", false);
    document.getElementById("GenTxFactorDeCambioActual").value = Uno;
    Totalimb();
  }
  
  // Forzamos el recálculo inteligente por si el usuario ya había escrito montos
  if (typeof AjustarCalculoMoneda === "function") {
      AjustarCalculoMoneda();
  }
}

function FactorDoChange() {
  var tasa = new Number(
    document.getElementById("GenTxFactorDeCambioActual").value,
  );
  if (tasa <= 0) {
    document.getElementById("GenTxFactorDeCambioActual").value =
      Number(1).toFixed(2);
  }
  Totalimb();
}

function DoChangeFactor() {
  var Total = new Number(document.getElementById("GenTxMontoTotal").value);
  var TotalTasa = new Number(document.getElementById("GenTxMontoTotal2").value);
  var tasa = TotalTasa / Total;
  document.getElementById("GenTxFactorDeCambioActual").value =
    Number(tasa).toFixed(8);
  Totalimb();
}

function Totalimb() {
  var ImpuestoId = document.getElementById("GenTxImpuestos").value;
  var Impuesto = new Number(
    document.getElementById("ValorImpuesto" + ImpuestoId).innerHTML,
  );
  var Exento = new Number(document.getElementById("GenTxMontoExe").value);
  var Imponible = new Number(
    document.getElementById("GenTxMontoImponible").value,
  );
  var MontoImpuesto = new Number(
    document.getElementById("GenTxMontoImpuesto").value,
  );
  var SubTotal = new Number(document.getElementById("GenTxSubTotal").value);
  var Total = new Number(document.getElementById("GenTxMontoTotal").value);
  var Tasa = new Number(
    document.getElementById("GenTxFactorDeCambioActual").value,
  );
  if (Impuesto == 0) {
    MontoImpuesto = 0;
  } else {
    MontoImpuesto = Imponible * (Impuesto / 100);
  }

  SubTotal = Imponible + MontoImpuesto;
  Total = SubTotal + Exento;
  var Totalcontasa = Number(Total).toFixed(2) * Number(Tasa);

  document.getElementById("GenTxMontoTotal").value = Total.toFixed(
    document.getElementById("CD").innerHTML,
  );
  document.getElementById("GenTxSubTotal").value = SubTotal.toFixed(
    document.getElementById("CD").innerHTML,
  );
  document.getElementById("GenTxMontoImponible").value = Imponible.toFixed(
    document.getElementById("CD").innerHTML,
  );
  document.getElementById("GenTxMontoExe").value = Exento.toFixed(
    document.getElementById("CD").innerHTML,
  );
  document.getElementById("GenTxMontoImpuesto").value = MontoImpuesto.toFixed(
    document.getElementById("CD").innerHTML,
  );
  document.getElementById("GenTxMontoTotal2").value = Totalcontasa.toFixed(
    document.getElementById("CD").innerHTML,
  );

  CalcularRestante();
}

function CalcularRestante() {
  var Imponible = new Number(
    document.getElementById("GenTxMontoImponible").value,
  );
  var Exento = new Number(document.getElementById("GenTxMontoExe").value);
  var ImpuestoId = document.getElementById("GenTxImpuestos").value;
  var Impuesto = new Number(
    document.getElementById("ValorImpuesto" + ImpuestoId).innerHTML,
  );

  if (LimitCredit !== "Ilimitado") {
    document.getElementById("LimitCreditTrans").innerHTML = Formato(
      (LimitCredit - Exento) / (1 + Impuesto / 100),
      document.getElementById("CD").innerHTML,
      document.getElementById("SimDec").innerHTML,
      document.getElementById("SimMil").innerHTML,
    );
    document.getElementById("LimitCreditTrans2").innerHTML = Formato(
      LimitCredit - (Imponible * (1 + Impuesto / 100) + Exento),
      document.getElementById("CD").innerHTML,
      document.getElementById("SimDec").innerHTML,
      document.getElementById("SimMil").innerHTML,
    );
  }
}

function selecionado(numero, form) {
  let Monto = new Number(
    document.getElementById("MontoAPagarqk" + numero).innerHTML,
  );
  let Monto2 = new Number(
    document.getElementById("MontoAPagarqkx" + numero).innerHTML,
  );
  let CreditoTxP = new Number(
    document.getElementById("CreditoTxP" + numero).innerHTML,
  );
  let ContadoTxP = new Number(
    document.getElementById("ContadoTxP" + numero).innerHTML,
  );
  let CreditoTxP2 = new Number(
    document.getElementById("CreditoTxPx" + numero).innerHTML,
  );
  let ContadoTxP2 = new Number(
    document.getElementById("ContadoTxPx" + numero).innerHTML,
  );
  let Saldo = new Number(ContadoTxP - CreditoTxP);
  let Saldo2 = new Number(ContadoTxP2 - CreditoTxP2);
  $("#algo" + numero).addClass("bg-primary text-white");

  if (document.getElementById("goodbye").innerHTML !== "") {
    $("#" + document.getElementById("goodbye").innerHTML).removeClass(
      "bg-primary text-white",
    );
  }
  if ("algo" + numero == document.getElementById("goodbye").innerHTML) {
    $("#divmayor").removeClass("d-none").addClass("d-none");
    document.getElementById("goodbye").innerHTML = "";
  } else {
    $("#divmayor").removeClass("d-none");
    document.getElementById("goodbye").innerHTML = form.id;
    if (Math.round(Monto, 2) == Math.round(Monto2, 2)) {
      document.getElementById("MontoPC").innerHTML =
        " (" +
        document.getElementById("MonedaP").innerHTML +
        ") " +
        Formato(
          Monto,
          document.getElementById("CD").innerHTML,
          document.getElementById("SimDec").innerHTML,
          document.getElementById("SimMil").innerHTML,
        );
      document.getElementById("MontoPC2").innerHTML = "";
    } else {
      document.getElementById("MontoPC").innerHTML =
        " (" +
        document.getElementById("MonedaP").innerHTML +
        ") " +
        Formato(
          Monto,
          document.getElementById("CD").innerHTML,
          document.getElementById("SimDec").innerHTML,
          document.getElementById("SimMil").innerHTML,
        );
      document.getElementById("MontoPC2").innerHTML =
        " (" +
        document.getElementById("MonedaS").innerHTML +
        ") " +
        Formato(
          Monto2,
          document.getElementById("CD").innerHTML,
          document.getElementById("SimDec").innerHTML,
          document.getElementById("SimMil").innerHTML,
        );
    }
    if (Math.round(ContadoTxP, 2) == Math.round(ContadoTxP2, 2)) {
      document.getElementById("DebitoPC").innerHTML =
        " (" +
        document.getElementById("MonedaP").innerHTML +
        ") " +
        Formato(
          ContadoTxP,
          document.getElementById("CD").innerHTML,
          document.getElementById("SimDec").innerHTML,
          document.getElementById("SimMil").innerHTML,
        );
      document.getElementById("DebitoPC2").innerHTML = "";
    } else {
      document.getElementById("DebitoPC").innerHTML =
        " (" +
        document.getElementById("MonedaP").innerHTML +
        ") " +
        Formato(
          ContadoTxP,
          document.getElementById("CD").innerHTML,
          document.getElementById("SimDec").innerHTML,
          document.getElementById("SimMil").innerHTML,
        );
      document.getElementById("DebitoPC2").innerHTML =
        " (" +
        document.getElementById("MonedaS").innerHTML +
        ") " +
        Formato(
          ContadoTxP2,
          document.getElementById("CD").innerHTML,
          document.getElementById("SimDec").innerHTML,
          document.getElementById("SimMil").innerHTML,
        );
    }
    if (Math.round(CreditoTxP, 2) == Math.round(CreditoTxP2, 2)) {
      document.getElementById("CreditoPC").innerHTML =
        " (" +
        document.getElementById("MonedaP").innerHTML +
        ") " +
        Formato(
          CreditoTxP,
          document.getElementById("CD").innerHTML,
          document.getElementById("SimDec").innerHTML,
          document.getElementById("SimMil").innerHTML,
        );
      document.getElementById("CreditoPC2").innerHTML = "";
    } else {
      document.getElementById("CreditoPC").innerHTML =
        " (" +
        document.getElementById("MonedaP").innerHTML +
        ") " +
        Formato(
          CreditoTxP,
          document.getElementById("CD").innerHTML,
          document.getElementById("SimDec").innerHTML,
          document.getElementById("SimMil").innerHTML,
        );
      document.getElementById("CreditoPC2").innerHTML =
        " (" +
        document.getElementById("MonedaS").innerHTML +
        ") " +
        Formato(
          CreditoTxP2,
          document.getElementById("CD").innerHTML,
          document.getElementById("SimDec").innerHTML,
          document.getElementById("SimMil").innerHTML,
        );
    }
    if (Math.round(Saldo, 2) == Math.round(Saldo2, 2)) {
      document.getElementById("SaldoPC").innerHTML =
        " (" +
        document.getElementById("MonedaP").innerHTML +
        ") " +
        Formato(
          Saldo,
          document.getElementById("CD").innerHTML,
          document.getElementById("SimDec").innerHTML,
          document.getElementById("SimMil").innerHTML,
        );
      document.getElementById("SaldoPC2").innerHTML = "";
    } else {
      document.getElementById("SaldoPC").innerHTML =
        " (" +
        document.getElementById("MonedaP").innerHTML +
        ") " +
        Formato(
          Saldo,
          document.getElementById("CD").innerHTML,
          document.getElementById("SimDec").innerHTML,
          document.getElementById("SimMil").innerHTML,
        );
      document.getElementById("SaldoPC2").innerHTML =
        " (" +
        document.getElementById("MonedaS").innerHTML +
        ") " +
        Formato(
          Saldo2,
          document.getElementById("CD").innerHTML,
          document.getElementById("SimDec").innerHTML,
          document.getElementById("SimMil").innerHTML,
        );
    }
    document.getElementById("EmisionPC").innerHTML = document.getElementById(
      "fechatabla" + numero,
    ).innerHTML;
  }
}

function OpenUp(Tx, TipoTx, Estacion, item) {
  document.getElementById("A001").value = Estacion;
  document.getElementById("A002").value = Tx;
  document.getElementById("A003").value = TipoTx;
  document.getElementById("A004").value = item;
  $("#modal-fabo").modal("show");
}

function ImpresionEstadocb(n) {
  var valor1 = document.getElementById("A001").value;
  var valor2 = document.getElementById("A002").value;
  var valor3 = document.getElementById("A003").value;
  var valor4 = document.getElementById("A004").value;
  if (n == 1) {
    $.ajax({
      type: "POST",
      url: "formatodeimpresion.php",
      data: {
        CompanyActual: document.getElementById("CompanyActual").innerHTML,
        Item: valor4,
        Idtipotx: valor3,
        Idtx: valor2,
        IdEstacion: valor1,
        Moneda: "1",
        MonedaP: document.getElementById("MonedaP").innerHTML,
        MonedaS: document.getElementById("MonedaS").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
      },
    }).done(function (msg) {
      $("#prints").html(msg);
      if (msg !== "") {
        $("#modal-fabo").modal("hide");
        window.print();
      }
    });
  }
  if (n == 2) {
    $.ajax({
      type: "POST",
      url: "formatodeimpresion.php",
      data: {
        CompanyActual: document.getElementById("CompanyActual").innerHTML,
        Item: valor4,
        Idtipotx: valor3,
        Idtx: valor2,
        IdEstacion: valor1,
        Moneda: "2",
        MonedaP: document.getElementById("MonedaP").innerHTML,
        MonedaS: document.getElementById("MonedaS").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
      },
    }).done(function (msg) {
      $("#prints").html(msg);
      if (msg !== "") {
        $("#modal-fabo").modal("hide");
        window.print();
      }
    });
  }
  if (n == 3) {
    $.ajax({
      type: "POST",
      url: "formatodeimpresion.php",
      data: {
        CompanyActual: document.getElementById("CompanyActual").innerHTML,
        Item: valor4,
        Idtipotx: valor3,
        Idtx: valor2,
        IdEstacion: valor1,
        Moneda: "3",
        MonedaP: document.getElementById("MonedaP").innerHTML,
        MonedaS: document.getElementById("MonedaS").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
      },
    }).done(function (msg) {
      $("#prints").html(msg);
      if (msg !== "") {
        $("#modal-fabo").modal("hide");
        window.print();
      }
    });
  }
  if (n == 4) {
    $.ajax({
      type: "POST",
      url: "formatodeimpresion.php",
      data: {
        CompanyActual: document.getElementById("CompanyActual").innerHTML,
        Item: valor4,
        Idtipotx: valor3,
        Idtx: valor2,
        IdEstacion: valor1,
        Moneda: "4",
        MonedaP: document.getElementById("MonedaP").innerHTML,
        MonedaS: document.getElementById("MonedaS").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
      },
    }).done(function (msg) {
      $("#prints").html(msg);
      if (msg !== "") {
        $("#modal-fabo").modal("hide");
        window.print();
      }
    });
  }
  if (n == 5) {
    $.ajax({
      type: "POST",
      url: "formatodeimpresion.php",
      data: {
        CompanyActual: document.getElementById("CompanyActual").innerHTML,
        Item: valor4,
        Idtipotx: valor3,
        Idtx: valor2,
        IdEstacion: valor1,
        Moneda: "5",
        MonedaP: document.getElementById("MonedaP").innerHTML,
        MonedaS: document.getElementById("MonedaS").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
      },
    }).done(function (msg) {
      $("#prints").html(msg);
      if (msg !== "") {
        $("#modal-fabo").modal("hide");
        window.print();
      }
    });
  }
  if (n == 6) {
    $.ajax({
      type: "POST",
      url: "formatodeimpresion.php",
      data: {
        CompanyActual: document.getElementById("CompanyActual").innerHTML,
        Item: valor4,
        Idtipotx: valor3,
        Idtx: valor2,
        IdEstacion: valor1,
        Moneda: "6",
        MonedaP: document.getElementById("MonedaP").innerHTML,
        MonedaS: document.getElementById("MonedaS").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
      },
    }).done(function (msg) {
      $("#prints").html(msg);
      if (msg !== "") {
        $("#modal-fabo").modal("hide");
        window.print();
      }
    });
  }
}

function ColocarRetencion() {
  if (document.getElementById("RetencionOfTable").value == "0") {
    $("#MontoRetencion").prop("disabled", false);
    $("#PorceRetencion").prop("disabled", false);
    document.getElementById("codigodelimpuestopa").value = 0;
  } else {
    $("#MontoRetencion").prop("disabled", true);
    $("#PorceRetencion").prop("disabled", true);
    var numero = document.getElementById("RetencionOfTable").value;
    var Porcentaje = new Number(
      document.getElementById("Porcentaje" + numero).innerHTML,
    );
    document.getElementById("codigodelimpuestopa").value =
      document.getElementById("IdVarios" + numero).innerHTML;
    document.getElementById("PorceRetencion").value = Porcentaje.toFixed(
      document.getElementById("CD").innerHTML,
    );

    Totalizar(document.getElementById("PorceRetencion"));
  }
}

function Totalizar(form) {
  var Monto = new Number(document.getElementById("MontoRetencion").value);
  var Porcentaje = new Number(document.getElementById("PorceRetencion").value);
  var Impuesto = new Number(document.getElementById("ImpuActTxCAct").value);
  var Actual = new Number(document.getElementById("RetenidoActual").value);
  var Total = new Number(0);
  var RetenidoActual = new Number(0);
  var CreditoActual = new Number(
    document.getElementById("CreditoActual").innerHTML,
  );
  RetenidoActual = Impuesto - Actual;
  if (CreditoActual < RetenidoActual) {
    Total = CreditoActual;
  } else {
    if (CreditoActual > RetenidoActual) {
      Total = RetenidoActual;
    }
  }
  if (Total < 0) {
    Total = 0;
  }
  if (form.id == "MontoRetencion") {
    if (Monto > 0) {
      Porcentaje = (Monto / Total) * 100;
    } else {
      Monto = 0;
      Porcentaje = 0;
    }
    if (Monto > Total) {
      Monto = Total;
      Porcentaje = 100;
    }
  }
  if (form.id == "PorceRetencion") {
    if (Porcentaje > 0) {
      Monto = Total * (Porcentaje / 100);
    } else {
      Monto = 0;
      Porcentaje = 0;
    }
    if (Porcentaje > 100) {
      Monto = Total;
      Porcentaje = 100;
    }
  }
  document.getElementById("MontoRetencion").value = (Impuesto * Porcentaje ).toFixed(
    document.getElementById("CD").innerHTML,
  );
  document.getElementById("PorceRetencion").value = Porcentaje.toFixed(
    document.getElementById("CD").innerHTML,
  );
}

function GenerarCodigo() {
  if (document.getElementById("CodigoActualizable").value.trim() == "") {
    $.ajax({
      type: "POST",
      url: "estadocbseek.php",
      data: {
        Accion: "4",
        Fecha: document.getElementById("FechaRetencion").value,
        CompanyActual: document.getElementById("CompanyActual").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        MonedaS: document.getElementById("MonedaS").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
      },
    }).done(function (msg) {
      $("#CodigoActualizable").val(msg);
    });
  }
}

function Retenciones(Idtx, Idtipotx, IdEstacion, Retenido, Credito) {
  document.getElementById("resultestadocb019").innerHTML = Utils.Num033;
  $("#ModoAnticipo").hide();
  $("#CompraAnticipo").prop("checked", false);
  $("#VentaAnticipo").prop("checked", true);
  document.getElementById("decisions").innerHTML = "2";
  document.getElementById("IdtxActual").innerHTML = Idtx;
  document.getElementById("IdtipotxActual").innerHTML = Idtipotx;
  document.getElementById("IdEstacionActual").innerHTML = IdEstacion;
  document.getElementById("RetenidoActual").value = Retenido;
  document.getElementById("CreditoActual").innerHTML = Credito;
  $.ajax({
    type: "POST",
    url: "estadocbseek.php",
    data: {
      Accion: "5",
      CreditoActual: document.getElementById("CreditoActual").innerHTML,
      RetenidoActual: document.getElementById("RetenidoActual").value,
      Idtx: Idtx,
      Idtipotx: Idtipotx,
      IdEstacion: IdEstacion,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
    },
  }).done(function (msg) {
    $("#Temporal").html(msg);
    document.getElementById("FechaRetencion").value =
      document.getElementById("FectxActTxC").innerHTML;
    document.getElementById("Totalenmonedauno").value =
      document.getElementById("totalTxC").innerHTML;
    document.getElementById("Totalenmonedados").value =
      document.getElementById("totaltasaTxC").innerHTML;
    document.getElementById("Totalenmonedatres").value =
      document.getElementById("tasaTxC").innerHTML;
      //document.getElementById("Totalenmonedacuatro").value =
     // document.getElementById("RetenidoActualTXCDUD").innerHTML; 
       document.getElementById("Totalenmonedacuatro").value =
      document.getElementById("totaltasaTxC").innerHTML;
    document.getElementById("BaseImponibleActualizable").value = Formato(
      document.getElementById("ImpoActTxC").innerHTML,
      document.getElementById("CD").innerHTML,
      document.getElementById("SimDec").innerHTML,
      document.getElementById("SimMil").innerHTML,
    );
    document.getElementById("TotalImpuestoActualizable").value = Formato(
      document.getElementById("ImpuActTxC").innerHTML,
      document.getElementById("CD").innerHTML,
      document.getElementById("SimDec").innerHTML,
      document.getElementById("SimMil").innerHTML,
    );
    document.getElementById("ImpoActTxCAct").value =
      document.getElementById("ImpoActTxC").innerHTML;
    document.getElementById("ImpuActTxCAct").value =
      document.getElementById("ImpuActTxC").innerHTML;
    document.getElementById("SDCFActualizable").value = Formato(
      0,
      document.getElementById("CD").innerHTML,
      document.getElementById("SimDec").innerHTML,
      document.getElementById("SimMil").innerHTML,
    );
    document.getElementById("CodigoActualizable").value = "";
    document.getElementById("RetencionOfTable").value = "0";
    GenerarCodigo();
    //alert(document.getElementById("MontoRetencion").innerHTML);
    Totalizar(document.getElementById("MontoRetencion"));
    $("#apps-modal2x").modal("show");
    $("#MontoRetencion").prop("disabled", false);
    $("#PorceRetencion").prop("disabled", false);
    $("#Temporal").html("");
  });
}

function ColocarRetencion2() {
  if (document.getElementById("RetencionOfTable2").value == "0") {
    $("#CodigoDlaRetencion").prop("disabled", true).val("");
    $("#CodigoLiteralRetencion").prop("disabled", true).val("");
    $("#CodigodelseniatReten").prop("disabled", true).val("");
    $("#DescripcionDelServicio").prop("disabled", true).val("");
    $("#Descripcionnormalreten").prop("disabled", true).val("");
    $("#Sustraendoinretencio").prop("disabled", true).val("");
    $("#BaseOfImponibleReten").prop("disabled", true).val("");
    $("#PorcentaofRetencionPlz").prop("disabled", true).val("");
    $("#MontoRetenidoporm").prop("disabled", true).val("");
  } else {
    $("#CodigoDlaRetencion").prop("disabled", false);
    $("#CodigoLiteralRetencion").prop("disabled", false);
    $("#CodigodelseniatReten").prop("disabled", false);
    $("#DescripcionDelServicio").prop("disabled", false);
    $("#Descripcionnormalreten").prop("disabled", false);
    $("#Sustraendoinretencio").prop("disabled", false);
    $("#BaseOfImponibleReten").prop("disabled", false);
    $("#PorcentaofRetencionPlz").prop("disabled", false);
    $("#MontoRetenidoporm").prop("disabled", true);
    var numero = document.getElementById("RetencionOfTable2").value;
    document.getElementById("CodigoDlaRetencion").value =
      document.getElementById("NumLit" + numero).innerHTML;
    var miCadena = document.getElementById("NumLit" + numero).innerHTML;
    var divisiones = miCadena.split(".");
    var Porcentaje = new Number(
      document.getElementById("PNRETAR" + numero).innerHTML,
    );
    Porcentaje = Porcentaje * 100;
    document.getElementById("CodigoLiteralRetencion").value = divisiones[1];
    document.getElementById("Descripcionnormalreten").value =
      document.getElementById("Nombre" + numero).innerHTML;
    document.getElementById("Sustraendoinretencio").value =
      document.getElementById("PNRESUST" + numero).innerHTML;
    document.getElementById("BaseOfImponibleReten").value =
      document.getElementById("TotalofBaseImponible").value;
    document.getElementById("PorcentaofRetencionPlz").value =
      Porcentaje.toFixed(2);
    Totalizar2(document.getElementById("BaseOfImponibleReten"));
  }
}

function Totalizar2(form) {
  var TotalImponible = new Number(
    document.getElementById("TotalofBaseImponible").value,
  );
  var Imponible = new Number(
    document.getElementById("BaseOfImponibleReten").value,
  );
  var Sustraccion = new Number(
    document.getElementById("Sustraendoinretencio").value,
  );
  var Porcentaje = new Number(
    document.getElementById("PorcentaofRetencionPlz").value,
  );
  Porcentaje = Porcentaje / 100;
  var Retenido = new Number(0);
  if (form.id == "TotalofBaseImponible") {
    if (Imponible > TotalImponible) {
      Imponible = TotalImponible;
    }
    Retenido = Imponible * Porcentaje - Sustraccion;
  }
  if (form.id == "BaseOfImponibleReten") {
    if (Imponible > TotalImponible) {
      Imponible = TotalImponible;
    }
    Retenido = Imponible * Porcentaje - Sustraccion;
  }
  if (form.id == "PorcentaofRetencionPlz") {
    Retenido = Imponible * Porcentaje - Sustraccion;
  }
  if (form.id == "Sustraendoinretencio") {
    Retenido = Imponible * Porcentaje - Sustraccion;
  }
  if (Retenido < 0) {
    Retenido = 0;
  }
  Porcentaje = Porcentaje * 100;
  document.getElementById("TotalofBaseImponible").value =
    TotalImponible.toFixed(document.getElementById("CD").innerHTML);
  document.getElementById("BaseOfImponibleReten").value = Imponible.toFixed(
    document.getElementById("CD").innerHTML,
  );
  document.getElementById("Sustraendoinretencio").value = Sustraccion.toFixed(
    document.getElementById("CD").innerHTML,
  );
  document.getElementById("PorcentaofRetencionPlz").value = Porcentaje.toFixed(
    document.getElementById("CD").innerHTML,
  );
  document.getElementById("MontoRetenidoporm").value = Retenido.toFixed(
    document.getElementById("CD").innerHTML,
  );
}

function GenerarCodigo2() {
  if (document.getElementById("NumbaOfRetencion").value.trim() == "") {
    $.ajax({
      type: "POST",
      url: "estadocbseek.php",
      data: {
        Accion: "6",
        Fecha: document.getElementById("FechaRetencion2").value,
        CompanyActual: document.getElementById("CompanyActual").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        MonedaS: document.getElementById("MonedaS").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
      },
    }).done(function (msg) {
      $("#NumbaOfRetencion").val(msg);
    });
  }
}

function RetencionesISLRnew(Idtx, Idtipotx, IdEstacion, Retenido, Credito) {
    // 1. Extraemos el ID de la compañía de forma segura para evitar que el JS se "rompa"
    let companyElement = document.getElementById("CompanyActual");
    let idCompany = companyElement ? companyElement.innerHTML : "0";

    // 2. Calculamos la fecha de hoy automáticamente (en vez de dejarla hardcodeada)
    let hoy = new Date();
    let dd = String(hoy.getDate()).padStart(2, '0');
    let mm = String(hoy.getMonth() + 1).padStart(2, '0');
    let yyyy = hoy.getFullYear();
    let fechaHoy = yyyy + '-' + mm + '-' + dd;

    // 3. Llamamos al archivo PHP que genera el diseño visual
    $.ajax({
        type: "POST",
        url: "retension_islr.php",
        data: {
            IdTx: Idtx,
            IdTipoTx: Idtipotx,
            IdEstacion: IdEstacion,
            IdCompany: idCompany,
            FechaRet: fechaHoy
            // Ya no enviamos NumLit para que el PHP seleccione el primero por defecto
        },
        beforeSend: function() {
            // Opcional: Ponemos un mensaje de carga por si el internet está lento
            $("#frameRetISLR").html('<div class="p-4 text-center"><i class="fa fa-spinner fa-spin fs-2"></i> Cargando módulo...</div>');
            $("#modalRetISLR").modal("show");
        }
    }).done(function (msg) {
        // 4. Inyectamos el diseño en el modal
        $("#frameRetISLR").html(msg);
    }).fail(function() {
        // 5. Si el archivo no existe o hay error de red, avisamos
        $("#frameRetISLR").html('<div class="alert alert-danger m-3">Error de conexión al cargar la retención.</div>');
    });
}

function Retenciones2(Idtx, Idtipotx, IdEstacion, Retenido, Credito) {
  document.getElementById("resultestadocb019").innerHTML = Utils.Num035;
  $("#ModoAnticipo").hide();
  $("#CompraAnticipo").prop("checked", false);
  $("#VentaAnticipo").prop("checked", true);
  document.getElementById("decisions").innerHTML = "9";
  document.getElementById("IdtxActual").innerHTML = Idtx;
  document.getElementById("IdtipotxActual").innerHTML = Idtipotx;
  document.getElementById("IdEstacionActual").innerHTML = IdEstacion;
  document.getElementById("RetenidoActual2").value = Retenido;
  document.getElementById("CreditoActual").innerHTML = Credito;
  $.ajax({
    type: "POST",
    url: "estadocbseek.php",
    data: {
      Accion: "7",
      RetenidoActual: document.getElementById("RetenidoActual2").value,
      Idtx: Idtx,
      Idtipotx: Idtipotx,
      IdEstacion: IdEstacion,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
    },
  }).done(function (msg) {
    $("#Temporal").html(msg);
    document.getElementById("RetencionOfTable2").value = "0";
    var Imponible = new Number(
      document.getElementById("ImpoActTxC2").innerHTML,
    );
    var SinC = new Number(0);
    document.getElementById("FechaRetencion2").value =
      document.getElementById("FectxActTxC2").innerHTML;
    document.getElementById("TotalofBaseImponible").value = Imponible.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("TotalOfMenSDCF").value = SinC.toFixed(
      document.getElementById("CD").innerHTML,
    );
    $("#MontoRetencion2").prop("disabled", false);
    $("#PorceRetencion2").prop("disabled", false);
    ColocarRetencion2();
    document.getElementById("NumbaOfRetencion").value = "";
    GenerarCodigo2();
    $("#apps-modal2c").modal("show");
    $("#Temporal").html("");
  });
}

function MuestraProd3() {
  $("#boton004").prop("disabled", true);
  $("#boton005").prop("disabled", true);
  $("#boton006").prop("disabled", true);
  $.ajax({
    type: "POST",
    url: "estadocbseek.php",
    data: {
      Accion: "8",
      Ini: "0",
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      Idtipotx: document.getElementById("IdtipotxActual").innerHTML,
    },
  }).done(function (msg) {
    $("#Anticiposxd").html(msg);
    $("#AnticipoSelecTable").DataTable({
      search: {
        search: $(
          `#${"AnticipoSelecTable"}_wrapper .dt-layout-row .dt-end .dt-search .dt-input`,
        ).val(),
      },
      responsive: true,
      processing: true,
      serverSide: true,
      language: {
        url: language,
      },
      ajax: {
        type: "POST",
        url: "estadocbseek.php",
        data: {
          Accion: "8",
          Ini: "1",
          IdBen: document.getElementById("Modalrut").value,
          CompanyActual: document.getElementById("CompanyActual").innerHTML,
          MonedaP: document.getElementById("MonedaP").innerHTML,
          MonedaS: document.getElementById("MonedaS").innerHTML,
          CD: document.getElementById("CD").innerHTML,
          SimDec: document.getElementById("SimDec").innerHTML,
          SimMil: document.getElementById("SimMil").innerHTML,
          Idtipotx: document.getElementById("IdtipotxActual").innerHTML,
        },
      },
      columns: [null, null, null, null, null, { orderable: false }],
      order: [[0, "asc"]],
    });
  });
  $("#apps-modal3").modal("show");
  $("#boton004").prop("disabled", false);
  $("#boton005").prop("disabled", false);
  $("#boton006").prop("disabled", false);
}

function changeornot() {
  if (
    document.getElementById("TipodPagoPah").value == 1 ||
    document.getElementById("TipodPagoPah").value == 9
  ) {
    $("#Bancodeltipo").prop("disabled", true).val(0);
    $("#Referenciadeltipo").prop("disabled", true).val("");
  } else if (document.getElementById("TipodPagoPah").value == 4) {
    $("#Bancodeltipo").prop("disabled", true);
    $("#Referenciadeltipo").prop("disabled", true).val("");
  } else {
    $("#Bancodeltipo").prop("disabled", false);
    $("#Referenciadeltipo").prop("disabled", false);
  }
  Totalizarmp3(document.getElementById("ModalMonto"));
}

function Asignreferencia() {
  if (document.getElementById("TipodPagoPah").value == 4) {
    let name = "";
    if (
      document.getElementById("FactorDCambio").value === "0" ||
      document.getElementById("FactorDCambio").value === "-1"
    ) {
      name = FactorCambio.MonedaS;
    } else {
      name = $("#FactorDCambio option:selected").text();
    }
    document.getElementById("Referenciadeltipo").value =
      document.getElementById("ModalMonto").value +
      "|" +
      name +
      "|" +
      Number(document.getElementById("FactorDeCambioActual").value).toFixed(2);
  }
}

function autoFixed(form) {
  const value = !isNaN(parseFloat(form.value)) ? parseFloat(form.value) : 0;

  form.value = new Number(value).toFixed(
    document.getElementById("CD").innerHTML,
  );
  return;
}

function tdoccentonce() {
  if (document.getElementById("spago").value == "1") {
    $("#ModalReferenciaRegPag").prop("disabled", true).val("");
    $("#BancodelDocumento").prop("disabled", true).val(0);
    $("#tpags").prop("disabled", false);
    $("#divisiainf").hide();
    const tasa = new Number(document.getElementById("tasaactual").innerHTML);

    let totalpagar = new Number(
      document.getElementById("CreditoActual").innerHTML,
    );
    let totalpago = 0;
    if (json.length > 0) {
      Object.keys(json).forEach(function (c) {
        if (json[c].IdPago === 4) {
          totalpago += Number(json[c].MontoDiviso * tasa);
        } else {
          totalpago += Number(json[c].Monto);
        }
      });
    }

    var faltante = new Number(totalpagar - totalpago);
    document.getElementById("tpags").value = faltante.toFixed(
      document.getElementById("CD").innerHTML,
    );
  } else if (document.getElementById("spago").value == "4") {
    FactorMoneda(5);
    $("#divisiainf").show();
    $("#ModalReferenciaRegPag").prop("disabled", true);
    $("#tpags").prop("disabled", true).val(0);
    FactorMoneda(4);
    $("#BancodelDocumento").prop("disabled", false);
  } else {
    $("#divisiainf").hide();
    $("#ModalReferenciaRegPag").prop("disabled", false).val("");
    $("#tpags").prop("disabled", false);
    $("#BancodelDocumento").prop("disabled", false);
  }
}

function FactorMoneda(n) {
  // var name = Moendas.find(
  //   (mon) =>
  //     mon.id === parseInt(document.getElementById("TasadelaTransaccion").value),
  // ).name;
  let name = $("#TipoDivisaFA2 option:selected").text();
  if (name === "Tasa de las Transacciones") {
    name = FactorCambio.MonedaS;
  }
  var value = Moendas.find(
    (mon) =>
      mon.id === parseInt(document.getElementById("TipoDivisaFA2").value),
  ).value;
  const tasa = new Number(document.getElementById("tasaactual").innerHTML);

  if (parseInt(document.getElementById("TipoDivisaFA2").value) === 1) {
    value = tasa;
  }

  // document.getElementById("TipoDivisaFA2Factor21x").innerHTML = name;

  let totalpagar = new Number(
    document.getElementById("CreditoActual").innerHTML,
  );
  let totalpago = 0;
  if (json.length > 0) {
    Object.keys(json).forEach(function (c) {
      if (json[c].IdPago === 4) {
        totalpago += Number(json[c].MontoDiviso * tasa);
      } else {
        totalpago += Number(json[c].Monto);
      }
    });
  }

  if (tasa > 1) {
    totalpagar = totalpagar * tasa;
  }
  var Divisa = new Number(value);
  var Total = new Number(totalpagar - totalpago);
  var Monto = new Number(document.getElementById("MontoDivisa").value);
  var Calculo3 = new Number(0);
  var Calculo = Monto * Divisa;
  var Calculo2 = Total - Calculo;
  var Calculo4 = Total / Divisa;
  var Calculo5 = Math.abs(Calculo4 - Monto);
  var MontoDivisa = Total / Divisa;
  document.getElementById("TipoDivisaFA2Factor22x").innerHTML = name;
  document.getElementById("TipoDivisaFA2Factor22").innerHTML = Divisa.toFixed(
    document.getElementById("CD").innerHTML,
  );

  if (n == 1) {
    document.getElementById("TipoDivisaFA2Factor").value = Divisa.toFixed(
      document.getElementById("CD").innerHTML,
    );
    FactorMoneda(2);
  }
  if (n == 2) {
    document.getElementById("TipoDivisaFA2Factor2").value = Calculo.toFixed(
      document.getElementById("CD").innerHTML,
    );
    $("#MostrarDivisaVuelto").hide();
    $("#Botondivisa001").show();
    FactorMoneda(4);
  }
  if (n == 4) {
    if (document.getElementById("spago").value == 4) {
      if (Calculo2 < 0) {
        Calculo3 = Total / Monto;
        document.getElementById("ModalReferenciaRegPag").value =
          Monto.toFixed(document.getElementById("CD").innerHTML) +
          "|" +
          name +
          "|" +
          Divisa.toFixed(document.getElementById("CD").innerHTML);
        document.getElementById("tpags").value = Calculo.toFixed(
          document.getElementById("CD").innerHTML,
        );
      } else {
        document.getElementById("ModalReferenciaRegPag").value =
          Monto.toFixed(document.getElementById("CD").innerHTML) +
          "|" +
          name +
          "|" +
          Divisa.toFixed(document.getElementById("CD").innerHTML);
        document.getElementById("tpags").value = Calculo.toFixed(
          document.getElementById("CD").innerHTML,
        );
      }
    }
  }
  if (n == 5) {
    document.getElementById("MontoDivisa").value = MontoDivisa.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("tpags").value = Calculo3.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalReferenciaRegPag").value = "";
    FactorMoneda(2);
  }
  if (n === 6) {
    var a = Monto - Calculo5;
    var b = a * Divisa;
    document.getElementById("tpags").value = b.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalReferenciaRegPag").value =
      Monto.toFixed(document.getElementById("CD").innerHTML) +
      "|" +
      name +
      "|" +
      Divisa.toFixed(document.getElementById("CD").innerHTML) +
      "|" +
      Calculo5.toFixed(document.getElementById("CD").innerHTML);
  }
  if (n === 7) {
    var a = new Number(Monto * Divisa);
    var b = new Number(Total - a);
    document.getElementById("tpags").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("TipoDivisaFA2Factor2").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("ModalReferenciaRegPag").value =
      Monto.toFixed(document.getElementById("CD").innerHTML) +
      "|" +
      name +
      "|" +
      Divisa.toFixed(document.getElementById("CD").innerHTML);
  }
  if (n === 8) {
    var a = Total / Divisa;
    var b = a * Divisa;
    document.getElementById("MontoDivisa").value = a.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("TipoDivisaFA2Factor2").value = b.toFixed(
      document.getElementById("CD").innerHTML,
    );
    document.getElementById("tpags").value = b.toFixed(
      document.getElementById("CD").innerHTML,
    );

    document.getElementById("ModalReferenciaRegPag").value =
      a.toFixed(document.getElementById("CD").innerHTML) +
      "|" +
      name +
      "|" +
      Divisa.toFixed(document.getElementById("CD").innerHTML);
  }
}

function TipoMonedaAbono() {
  var Uno = new Number(1);
  var Moneda = new Number(document.getElementById("FactorDCambio").value);
  if (document.getElementById("tasaactual").innerHTML.trim() === "")
    document.getElementById("tasaactual").innerHTML = 1;
  var Tasa = new Number(document.getElementById("tasaactual").innerHTML);

  var CreditoActual = new Number(
    document.getElementById("CreditoActual").innerHTML,
  );
  var Total = new Number(0);
  var Tza = new Number(document.getElementById("FactorDeCambioActual").value);
  if (Moneda == 0) {
    if (Tasa > 1) {
      document.getElementById("FactorDeCambioActual").value = Tasa.toFixed(
        document.getElementById("CD").innerHTML,
      );
      $("#FactorDeCambioActual").prop("disabled", true);
      $("#ModalMonto2").prop("disabled", true);
      var name = "Act";
      document.getElementById("Logitodemoneda2x").innerHTML = "(" + name + ")";
      Total = CreditoActual * Tasa;
      document.getElementById("SaldoRegPago").value = Formato(
        Total,
        document.getElementById("CD").innerHTML,
        document.getElementById("SimDec").innerHTML,
        document.getElementById("SimMil").innerHTML,
      );
      document.getElementById("SaldoRegPago2").value = Formato(
        CreditoActual,
        document.getElementById("CD").innerHTML,
        document.getElementById("SimDec").innerHTML,
        document.getElementById("SimMil").innerHTML,
      );
      document.getElementById("tpag").value = Formato(
        CreditoActual,
        document.getElementById("CD").innerHTML,
        document.getElementById("SimDec").innerHTML,
        document.getElementById("SimMil").innerHTML,
      );
      $("#tpags").val(
        CreditoActual.toFixed(document.getElementById("CD").innerHTML),
      );
    } else {
      var name = "Act";
      document.getElementById("Logitodemoneda2x").innerHTML = "(" + name + ")";
      document.getElementById("FactorDeCambioActual").value = Uno.toFixed(
        document.getElementById("CD").innerHTML,
      );
      $("#FactorDeCambioActual").prop("disabled", true);
      $("#ModalMonto2").prop("disabled", true);

      Total = CreditoActual;
      document.getElementById("SaldoRegPago").value = Formato(
        Total,
        document.getElementById("CD").innerHTML,
        document.getElementById("SimDec").innerHTML,
        document.getElementById("SimMil").innerHTML,
      );
      document.getElementById("SaldoRegPago2").value = Formato(
        CreditoActual,
        document.getElementById("CD").innerHTML,
        document.getElementById("SimDec").innerHTML,
        document.getElementById("SimMil").innerHTML,
      );
      document.getElementById("tpag").value = Formato(
        CreditoActual,
        document.getElementById("CD").innerHTML,
        document.getElementById("SimDec").innerHTML,
        document.getElementById("SimMil").innerHTML,
      );
      $("#tpags").val(
        CreditoActual.toFixed(document.getElementById("CD").innerHTML),
      );
    }
  } else {
    if (Moneda == "-1") {
      var name = $("#FactorDCambio option:selected").text();
      document.getElementById("Logitodemoneda2x").innerHTML = "(" + name + ")";

      if (Tza <= 0) Tza = 1;

      document.getElementById("FactorDeCambioActual").value = Tza.toFixed(
        document.getElementById("CD").innerHTML,
      );
      $("#FactorDeCambioActual").prop("disabled", false);
    } else {
      var name = $("#FactorDCambio option:selected").text();
      document.getElementById("Logitodemoneda2x").innerHTML = "(" + name + ")";
      $("#FactorDeCambioActual").prop("disabled", true);
      $("#ModalMonto2").prop("disabled", true);
      document.getElementById("FactorDeCambioActual").value = Moneda.toFixed(
        document.getElementById("CD").innerHTML,
      );
      Total = CreditoActual * Moneda;
      document.getElementById("SaldoRegPago").value = Formato(
        Total,
        document.getElementById("CD").innerHTML,
        document.getElementById("SimDec").innerHTML,
        document.getElementById("SimMil").innerHTML,
      );
      document.getElementById("SaldoRegPago2").value = Formato(
        CreditoActual,
        document.getElementById("CD").innerHTML,
        document.getElementById("SimDec").innerHTML,
        document.getElementById("SimMil").innerHTML,
      );
      document.getElementById("tpag").value = Formato(
        CreditoActual,
        document.getElementById("CD").innerHTML,
        document.getElementById("SimDec").innerHTML,
        document.getElementById("SimMil").innerHTML,
      );
      $("#tpags").val(
        CreditoActual.toFixed(document.getElementById("CD").innerHTML),
      );
    }
  }
  actualizarpago();
}

function TipoMonedaChangin() {
  $("#FactorDeCambioActual").prop("disabled", true);
  var Moneda = new Number(document.getElementById("FactorDCambio").value);
  if (document.getElementById("tasaactual").innerHTML.trim() === "")
    document.getElementById("tasaactual").innerHTML = 1;
  var Tasa = new Number(document.getElementById("tasaactual").innerHTML);
  var ContadoActual = new Number(
    document.getElementById("ContadoActual").innerHTML,
  );
  var CreditoActual = new Number(
    document.getElementById("CreditoActual").innerHTML,
  );
  var Uno = new Number(1);
  var Total = new Number(0);
  var Tza = new Number(document.getElementById("FactorDeCambioActual").value);
  if (Moneda == 0) {
    if (Tasa > 1) {
      document.getElementById("FactorDeCambioActual").value = Tasa.toFixed(
        document.getElementById("CD").innerHTML,
      );
      $("#FactorDeCambioActual").prop("disabled", true);
      $("#ModalMonto2").prop("disabled", true);
      var name = "Act";
      document.getElementById("Logitodemoneda").innerHTML = "(" + name + ")";
      document.getElementById("Logitodemoneda2").innerHTML = "(" + name + ")";
      document.getElementById("Logitodemoneda3").innerHTML = "(" + name + ")";
      if (
        document.getElementById("decisions").innerHTML == "1" ||
        document.getElementById("decisions").innerHTML == "2"
      ) {
        Total = ContadoActual * Tasa;
        document.getElementById("SaldoActual").value = Formato(
          Total,
          document.getElementById("CD").innerHTML,
          document.getElementById("SimDec").innerHTML,
          document.getElementById("SimMil").innerHTML,
        );
        document.getElementById("SaldoActual2").value = Formato(
          ContadoActual,
          document.getElementById("CD").innerHTML,
          document.getElementById("SimDec").innerHTML,
          document.getElementById("SimMil").innerHTML,
        );
      }
      if (
        document.getElementById("decisions").innerHTML == "3" ||
        document.getElementById("decisions").innerHTML == "2"
      ) {
        Total = CreditoActual * Tasa;
        document.getElementById("SaldoActual").value = Formato(
          Total,
          document.getElementById("CD").innerHTML,
          document.getElementById("SimDec").innerHTML,
          document.getElementById("SimMil").innerHTML,
        );
        document.getElementById("SaldoActual2").value = Formato(
          CreditoActual,
          document.getElementById("CD").innerHTML,
          document.getElementById("SimDec").innerHTML,
          document.getElementById("SimMil").innerHTML,
        );
      }
    } else {
      var name = "Act";
      document.getElementById("Logitodemoneda").innerHTML = "(" + name + ")";
      document.getElementById("Logitodemoneda2").innerHTML = "(" + name + ")";
      document.getElementById("Logitodemoneda3").innerHTML = "(" + name + ")";
      document.getElementById("FactorDeCambioActual").value = Uno.toFixed(
        document.getElementById("CD").innerHTML,
      );
      $("#FactorDeCambioActual").prop("disabled", true);
      $("#ModalMonto2").prop("disabled", true);
      if (document.getElementById("decisions").innerHTML == "1") {
        Total = ContadoActual * Uno;
        document.getElementById("SaldoActual").value = Formato(
          Total,
          document.getElementById("CD").innerHTML,
          document.getElementById("SimDec").innerHTML,
          document.getElementById("SimMil").innerHTML,
        );
        document.getElementById("SaldoActual2").value = Formato(
          ContadoActual,
          document.getElementById("CD").innerHTML,
          document.getElementById("SimDec").innerHTML,
          document.getElementById("SimMil").innerHTML,
        );
      }
      if (
        document.getElementById("decisions").innerHTML == "3" ||
        document.getElementById("decisions").innerHTML == "2"
      ) {
        Total = CreditoActual * Uno;
        document.getElementById("SaldoActual").value = Formato(
          Total,
          document.getElementById("CD").innerHTML,
          document.getElementById("SimDec").innerHTML,
          document.getElementById("SimMil").innerHTML,
        );
        document.getElementById("SaldoActual2").value = Formato(
          CreditoActual,
          document.getElementById("CD").innerHTML,
          document.getElementById("SimDec").innerHTML,
          document.getElementById("SimMil").innerHTML,
        );
      }
    }
  } else {
    if (Moneda == "-1") {
      var name = $("#FactorDCambio option:selected").text();
      document.getElementById("Logitodemoneda").innerHTML = "(" + name + ")";
      document.getElementById("Logitodemoneda2").innerHTML = "(" + name + ")";
      document.getElementById("Logitodemoneda3").innerHTML = "(" + name + ")";

      if (Tza <= 0) Tza = 1;

      document.getElementById("FactorDeCambioActual").value = Tza.toFixed(
        document.getElementById("CD").innerHTML,
      );
      $("#FactorDeCambioActual").prop("disabled", false);
      if (
        document.getElementById("decisions").innerHTML == "2" ||
        document.getElementById("decisions").innerHTML == "4" ||
        document.getElementById("decisions").innerHTML == "1" ||
        document.getElementById("decisions").innerHTML == "5" ||
        document.getElementById("decisions").innerHTML == "3"
      ) {
        $("#ModalMonto2").prop("disabled", false);
      } else {
        $("#ModalMonto2").prop("disabled", true);
      }
    } else {
      var name = $("#FactorDCambio option:selected").text();
      document.getElementById("Logitodemoneda").innerHTML = "(" + name + ")";
      document.getElementById("Logitodemoneda2").innerHTML = "(" + name + ")";
      document.getElementById("Logitodemoneda3").innerHTML = "(" + name + ")";
      $("#FactorDeCambioActual").prop("disabled", true);
      $("#ModalMonto2").prop("disabled", true);
      document.getElementById("FactorDeCambioActual").value = Moneda.toFixed(
        document.getElementById("CD").innerHTML,
      );
      if (document.getElementById("decisions").innerHTML == "1") {
        Total = ContadoActual * Moneda;
        document.getElementById("SaldoActual").value = Formato(
          Total,
          document.getElementById("CD").innerHTML,
          document.getElementById("SimDec").innerHTML,
          document.getElementById("SimMil").innerHTML,
        );
        document.getElementById("SaldoActual2").value = Formato(
          ContadoActual,
          document.getElementById("CD").innerHTML,
          document.getElementById("SimDec").innerHTML,
          document.getElementById("SimMil").innerHTML,
        );
      }
      if (
        document.getElementById("decisions").innerHTML == "3" ||
        document.getElementById("decisions").innerHTML == "2"
      ) {
        Total = CreditoActual * Moneda;
        document.getElementById("SaldoActual").value = Formato(
          Total,
          document.getElementById("CD").innerHTML,
          document.getElementById("SimDec").innerHTML,
          document.getElementById("SimMil").innerHTML,
        );
        document.getElementById("SaldoActual2").value = Formato(
          CreditoActual,
          document.getElementById("CD").innerHTML,
          document.getElementById("SimDec").innerHTML,
          document.getElementById("SimMil").innerHTML,
        );
      }
    }
  }
  Totalizarmp3(document.getElementById("ModalMonto"));
}

function TipoMonedaPagoUnico() {
  const Factor = document.getElementById("FactorCambioPagoUnico").value;
  let tasa = 1;
  if (+Factor === 2) {
    tasa = parseFloat(FactorCambio["FactorDolarCash"]);
  } else if (+Factor === 3) {
    tasa = parseFloat(FactorCambio["FactorDolarPaypal"]);
  } else if (+Factor === 4) {
    tasa = parseFloat(FactorCambio["FactorDolarZelle"]);
  } else if (+Factor === 5) {
    tasa = parseFloat(FactorCambio["FactorDolar5"]);
  } else if (+Factor === 6) {
    tasa = parseFloat(FactorCambio["FactorDolar6"]);
  } else if (+Factor === 7) {
    tasa = parseFloat(FactorCambio["FactorDolar7"]);
  }

  $("#TasaCambioPagoUnico").prop("disabled", true);
  document.getElementById("TasaCambioPagoUnico").value = tasa.toFixed(2);

  var name = $("#FactorCambioPagoUnico option:selected").text();
  document.getElementById("Logitodemoneda").innerHTML = "(" + name + ")";
  TotalizarPagoUnico(document.getElementById("ModalMontoPagoUnico"));
}

function TotalizarPagoUnico(form) {
  const Tasa = Number(document.getElementById("TasaCambioPagoUnico").value);
  let Monto = Number(document.getElementById("ModalMontoPagoUnico").value);
  let Monto2 = Number(document.getElementById("ModalMonto2PagoUnico").value);
  Monto = !isNaN(Monto) ? Monto : 0;
  Monto = Monto > 0 ? Monto : 0;

  Monto2 = !isNaN(Monto2) ? Monto2 : 0;
  Monto2 = Monto2 > 0 ? Monto2 : 0;

  if (form.id === "ModalMontoPagoUnico") {
    Monto2 = Monto * Tasa;
  }

  if (form.id === "ModalMonto2PagoUnico") {
    Monto = Monto2 / Tasa;
  }

  document.getElementById("ModalMontoPagoUnico").value = Monto.toFixed(2);
  document.getElementById("ModalMonto2PagoUnico").value = Monto2.toFixed(2);
  ActualizarTablaPagos();
}

function ActualizarTablaPagos() {
  let Monto = Number(document.getElementById("ModalMontoPagoUnico").value);

  let Debito = 0;
  PagAct = 1;
  data = [];
  if (arrayABC.length > 0) {
    arrayABC.forEach((e) => {
      Debito = 0;
      if (Monto > e.Credito2) {
        Debito = e.Credito2;
        Monto = Monto - e.Credito2;
      } else if (Monto > 0) {
        Debito = Monto;
        Monto = 0;
      }

      if (Debito > 0) {
        data.push({
          Debito: Debito,
          Credito2: e.Credito2,
          Fecha: e.Fecha,
          Titulo: e.Titulo,
          Idtx: e.Idtx,
          Cred: `${new Number(e.Credito2).toFixed(2)} ${
            document.getElementById("MonedaP").innerHTML
          }`,
          Deb: `${new Number(Debito).toFixed(2)} ${
            document.getElementById("MonedaP").innerHTML
          }`,
          anticipo: false,
          IdBarcode: e.IdBarcode,
          IdtxF: e.IdtxF,
          Idtipotx: e.Idtipotx,
          IdEstacion: e.IdEstacion,
          tasa: e.tasa,
        });
        /*
        html += `
        <tr ${
          Debito >= e.Credito2
            ? `class="bg-success text-light"`
            : Debito > 0
            ? `class="bg-warning text-dark"`
            : `class="bg-danger text-light"`
        }>
          <td>${e.Fecha}</td>
          <td>${e.Titulo}</td>
          <td>${e.Idtx}</td>
          <td>${new Number(e.Credito2).toFixed(2)} ${
          document.getElementById("MonedaP").innerHTML
        }</td>
          <td>${new Number(Debito).toFixed(2)}  ${
          document.getElementById("MonedaP").innerHTML
        }</td>
        </tr>
      `;
      */
      }
    });
  }

  if (Monto > 0) {
    /*
      html += `
        <tr class="bg-success text-light">
          <td colspan="3">Monto Sobrante que pasara a anticipo</td>
          <td>0</td>
          <td>${new Number(Monto).toFixed(2)}  ${
        document.getElementById("MonedaP").innerHTML
      }</td>
        </tr>
      `;
      */

    data.push({
      Debito: Monto,
      Credito2: 0,
      Fecha: "",
      Titulo: "",
      Idtx: "",
      Cred: `${new Number(0).toFixed(2)} ${
        document.getElementById("MonedaP").innerHTML
      }`,
      Deb: `${new Number(Monto).toFixed(2)} ${
        document.getElementById("MonedaP").innerHTML
      }`,
      anticipo: true,
    });
  }

  ActualizarTabla();
  setTimeout(() => {
    $("#ModalMontoPagoUnico").focus();
  }, 200);
}

function ActualizarTabla() {
  let html = "";
  let pagination = "";
  let CanPags = 1;
  if (data.length > 0) {
    const limitReg = 10;
    CanPags = Math.ceil(data.length / limitReg);
    data.slice(limitReg * (PagAct - 1), limitReg * PagAct).forEach((e) => {
      if (e.anticipo) {
        html += `
        <tr class="bg-success text-light">
          <td colspan="3">Monto Sobrante que pasara a anticipo</td>
          <td>${e.Cred}</td>
          <td>${e.Deb}</td>
        </tr>
      `;
      } else {
        html += `
    <tr ${
      e.Debito >= e.Credito2
        ? `class="bg-success text-light"`
        : e.Debito > 0
        ? `class="bg-warning text-dark"`
        : `class="bg-danger text-light"`
    }>
      <td>${e.Fecha}</td>
      <td>${e.Titulo}</td>
      <td>${e.Idtx}</td>
      <td>${e.Cred}</td>
      <td>${e.Deb}</td>
    </tr>

  `;
      }
    });
  }

  for (
    let index =
      PagAct - 2 > 0 ? PagAct - 2 : PagAct - 1 > 0 ? PagAct - 1 : PagAct;
    index <= (CanPags > PagAct + 2 ? PagAct + 2 : CanPags > 0 ? CanPags : 1);
    index++
  ) {
    pagination += `
      <li class='page-item '>
        <button type='button' onclick='CambiarPagina(${index})' class='page-link ${
      PagAct == index ? "bg-primary text-light" : ""
    }' >${index}</button>
      </li>
    `;
  }

  $("#PaginationForm").html(`
    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-end">
        <li class="page-item ${PagAct === 1 ? "disabled" : ""}">
          <button type='button' onclick='CambiarPagina(${
            PagAct - 1
          })' class='page-link' >Anterior</button>
        </li>
        ${pagination}
        <li class="page-item ${PagAct === CanPags ? "disabled" : ""}">
          <button type='button' onclick='CambiarPagina(${
            PagAct + 1
          })' class='page-link' >Siguiente</button>
        </li>
      </ul>
    </nav>
  `);
  $("#PutAplicar").html(html);
}

function CambiarPagina(n) {
  PagAct = n;
  ActualizarTabla();
}

function PagoEnviarDatos() {
  $("button").prop("disabled", true);
  const CajaC =
    dataCaja?.find(
      (caja) => caja.token === document.getElementById("tokeninUse").value,
    )?.CajaActual ?? "0";

  var fecha = new Date();
  var hora = fecha.getHours();
  var min = fecha.getMinutes();
  var seg = fecha.getSeconds();

  let name = $("#FactorCambioPagoUnico option:selected").text();
  if (name === "Tasa de las Transacciones") {
    name = FactorCambio.MonedaS;
  }

  if (data.length > 0) {
    $("#ModalPagoUnico").modal("hide");
    $("#modal-proce").modal("show");
    $.ajax({
      type: "POST",
      url: "estadocbhandler.php",
      data: {
        tabla: "PagoUnico",
        Monto: Number(document.getElementById("ModalMontoPagoUnico").value),
        CompanyActual: document.getElementById("CompanyActual").innerHTML,
        IdBen: document.getElementById("Modalrut").value,
        data: data,
        tasa: document.getElementById("TasaCambioPagoUnico").value,
        Fecha:
          document.getElementById("ModalFechaPagoUnico").value +
          " " +
          hora +
          ":" +
          min +
          ":" +
          seg,
        Referencia: document.getElementById("ModalReferenciaPagoUnico").value,
        TipoPago: document.getElementById("TipoPagoPagoUnico").value,
        CajaActual: CajaC,
        IdEstacion2: document.getElementById("tokeninUse").value,
        IdUser: document.getElementById("userlogin").innerHTML,
        Banco: document.getElementById("BancoPagoUnico").value,
        correo: document.getElementById("correorep").innerHTML,
        dampliado: document.getElementById("ObsevacionPagoUnico").value,
        FactorCambio: document.getElementById("FactorCambioPagoUnico").value,
        FactorDolarCash: parseFloat(FactorCambio["FactorDolarCash"]),
        OrderBy: document.getElementById("OrderBy").value,
        SortBy: document.getElementById("SortBy").value,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        tasaText: name,
      },
    }).done(function (msg) {
      const array = JSON.parse(msg);
      $("button").prop("disabled", false);
      if (array.status === true) {
        $("#modal-proce").modal("hide");
        ActTable();
      } else {
        alert("Error");
      }
    });
  } else {
    $("button").prop("disabled", false);
  }
}

function TipoPagoAPagoUnico() {
  const tipo = document.getElementById("TipoPagoPagoUnico").value;

  if (+tipo === 1) {
    $("#ModalReferenciaPagoUnico").val("");
    $("#ModalReferenciaPagoUnico").prop("disabled", true);
    $("#BancoPagoUnico").val(0);
    $("#BancoPagoUnico").prop("disabled", true);
    $("#ModalMontoPagoUnico").focus();
    return;
  }
  if (+tipo === 4) {
    $("#ModalReferenciaPagoUnico").val("");
    $("#ModalReferenciaPagoUnico").prop("disabled", true);
    $("#BancoPagoUnico").val(0);
    $("#BancoPagoUnico").prop("disabled", false);
    $("#ModalMontoPagoUnico").focus();
    return;
  }
  $("#ModalReferenciaPagoUnico").prop("disabled", false);
  $("#BancoPagoUnico").prop("disabled", false);
  $("#ModalMontoPagoUnico").focus();
  return;
}

function Totalizarmp3(form) {
  var RetencionActual = new Number(
    document.getElementById("RetencionActual").innerHTML,
  );
  var ModalMonto2 = new Number(document.getElementById("ModalMonto2").value);
  var ModalMonto = new Number(document.getElementById("ModalMonto").value);
  var FactorDeCambioActual = new Number(
    document.getElementById("FactorDeCambioActual").value,
  );
  var Total = new Number(0);
  var ContadoActual = new Number(
    document.getElementById("ContadoActual").innerHTML,
  );
  var CreditoActual = new Number(
    document.getElementById("CreditoActual").innerHTML,
  );
  var ContadoActual2 = new Number(
    document.getElementById("ContadoActual2").innerHTML,
  );
  let vuelto = 0;

  $("#Div004V").hide();
  document.getElementById("ModalVuelto").value = new Number(0).toFixed(2);
  Vueltos = [];
  ActualizarVuelto();
  document.getElementById("ModalVuelto2").value = 0;
  document.getElementById("VueltoPago").value = "1";

  // var CreditoActual2 = new Number(
  //   document.getElementById("CreditoActual2").innerHTML,
  // );
  // var RetencionActual2 = new Number(
  //   document.getElementById("RetencionActual2").innerHTML,
  // );
  if (document.getElementById("decisions").innerHTML == "5") {
    if (form.id == "ModalMonto" || form.id == "FactorDeCambioActual") {
      ModalMonto2 = ModalMonto * FactorDeCambioActual;
      document.getElementById("ModalMonto2").value = ModalMonto2.toFixed(
        document.getElementById("CD").innerHTML,
      );
      document.getElementById("FactorDeCambioActual").value =
        FactorDeCambioActual.toFixed(document.getElementById("CD").innerHTML);
    }
    if (form.id == "ModalMonto2") {
      ModalMonto = ModalMonto2 / FactorDeCambioActual;
      document.getElementById("ModalMonto").value = ModalMonto.toFixed(
        document.getElementById("CD").innerHTML,
      );
    }
  }
  if (document.getElementById("decisions").innerHTML == "4") {
    if (form.id == "ModalMonto" || form.id == "FactorDeCambioActual") {
      if (ContadoActual2 >= CreditoActual) {
        if (ModalMonto > CreditoActual || ModalMonto < 0) {
          ModalMonto = CreditoActual;
        }
      }
      if (ContadoActual2 <= CreditoActual) {
        if (ModalMonto > ContadoActual2 || ModalMonto < 0) {
          ModalMonto = ContadoActual2;
        }
      }
      ModalMonto2 = ModalMonto * FactorDeCambioActual;
      document.getElementById("ModalMonto2").value = ModalMonto2.toFixed(
        document.getElementById("CD").innerHTML,
      );
      document.getElementById("FactorDeCambioActual").value =
        FactorDeCambioActual.toFixed(document.getElementById("CD").innerHTML);
      Total = CreditoActual * FactorDeCambioActual;
      document.getElementById("SaldoActual").value = Formato(
        Total,
        document.getElementById("CD").innerHTML,
        document.getElementById("SimDec").innerHTML,
        document.getElementById("SimMil").innerHTML,
      );
      document.getElementById("SaldoActual2").value = Formato(
        CreditoActual,
        document.getElementById("CD").innerHTML,
        document.getElementById("SimDec").innerHTML,
        document.getElementById("SimMil").innerHTML,
      );
    }
    if (form.id == "ModalMonto2") {
      ModalMonto = ModalMonto2 / FactorDeCambioActual;
      if (ContadoActual2 > CreditoActual) {
        if (ModalMonto > CreditoActual || ModalMonto < 0) {
          ModalMonto = CreditoActual;
        }
      }
      if (ContadoActual2 < CreditoActual) {
        if (ModalMonto > ContadoActual2 || ModalMonto < 0) {
          ModalMonto = ContadoActual2;
        }
      }
      ModalMonto2 = ModalMonto * FactorDeCambioActual;
      document.getElementById("ModalMonto").value = ModalMonto.toFixed(
        document.getElementById("CD").innerHTML,
      );
      document.getElementById("ModalMonto2").value = ModalMonto2.toFixed(
        document.getElementById("CD").innerHTML,
      );
    }
  }
  if (document.getElementById("decisions").innerHTML == "6") {
    CreditoActual = CreditoActual + RetencionActual;
    if (ModalMonto > CreditoActual || ModalMonto < 0) {
      ModalMonto = CreditoActual;
    }
    ModalMonto2 = ModalMonto * FactorDeCambioActual;
    document.getElementById("ModalMonto2").value = ModalMonto2.toFixed(
      document.getElementById("CD").innerHTML,
    );
  }
  if (
    document.getElementById("decisions").innerHTML == "3" ||
    document.getElementById("decisions").innerHTML == "2"
  ) {
    if (form.id == "ModalMonto" || form.id == "FactorDeCambioActual") {
      if (ModalMonto > CreditoActual || ModalMonto < 0) {
        if (ModalMonto > CreditoActual) {
          vuelto = ModalMonto - CreditoActual;
          ModalMonto = CreditoActual;
          document.getElementById("ModalVuelto").value = vuelto.toFixed(2);
          Vueltos = [];
          ActualizarVuelto();
          document.getElementById("ModalVuelto2").value = vuelto.toFixed(2);
          $("#Div004V").show();
        }
      }
      ModalMonto2 = ModalMonto * FactorDeCambioActual;
      document.getElementById("ModalMonto2").value = ModalMonto2.toFixed(
        document.getElementById("CD").innerHTML,
      );
      Total = CreditoActual * FactorDeCambioActual;
      document.getElementById("SaldoActual").value = Formato(
        Total,
        document.getElementById("CD").innerHTML,
        document.getElementById("SimDec").innerHTML,
        document.getElementById("SimMil").innerHTML,
      );
      document.getElementById("SaldoActual2").value = Formato(
        CreditoActual,
        document.getElementById("CD").innerHTML,
        document.getElementById("SimDec").innerHTML,
        document.getElementById("SimMil").innerHTML,
      );
    }
    if (form.id == "ModalMonto2") {
      ModalMonto = ModalMonto2 / FactorDeCambioActual;
      if (ModalMonto > CreditoActual || ModalMonto < 0) {
        ModalMonto = CreditoActual;
      }
      ModalMonto2 = ModalMonto * FactorDeCambioActual;
      document.getElementById("ModalMonto").value = ModalMonto.toFixed(
        document.getElementById("CD").innerHTML,
      );
      document.getElementById("ModalMonto2").value = ModalMonto2.toFixed(
        document.getElementById("CD").innerHTML,
      );
    }
  }
  if (document.getElementById("decisions").innerHTML == "1") {
    if (form.id == "ModalMonto" || form.id == "FactorDeCambioActual") {
      if (LimitCredit !== "Ilimitado") {
        if (ModalMonto > LimitCredit || ModalMonto < 0) {
          ModalMonto = LimitCredit;
        }
      }

      ModalMonto2 = ModalMonto * FactorDeCambioActual;
      Total = ContadoActual * FactorDeCambioActual;
      document.getElementById("ModalMonto2").value = ModalMonto2.toFixed(
        document.getElementById("CD").innerHTML,
      );
      document.getElementById("FactorDeCambioActual").value =
        FactorDeCambioActual.toFixed(document.getElementById("CD").innerHTML);
      document.getElementById("SaldoActual").value = Formato(
        Total,
        document.getElementById("CD").innerHTML,
        document.getElementById("SimDec").innerHTML,
        document.getElementById("SimMil").innerHTML,
      );
      document.getElementById("SaldoActual2").value = Formato(
        ContadoActual,
        document.getElementById("CD").innerHTML,
        document.getElementById("SimDec").innerHTML,
        document.getElementById("SimMil").innerHTML,
      );
    }
    if (form.id == "ModalMonto2") {
      ModalMonto = ModalMonto2 / FactorDeCambioActual;
      if (LimitCredit !== "Ilimitado") {
        if (ModalMonto > LimitCredit || ModalMonto < 0) {
          ModalMonto = LimitCredit;
        }
      }
      ModalMonto2 = ModalMonto * FactorDeCambioActual;

      document.getElementById("ModalMonto").value = ModalMonto.toFixed(
        document.getElementById("CD").innerHTML,
      );
      document.getElementById("ModalMonto2").value = ModalMonto2.toFixed(
        document.getElementById("CD").innerHTML,
      );
    }
  }
  document.getElementById("ModalMonto").value = ModalMonto.toFixed(
    document.getElementById("CD").innerHTML,
  );
  Asignreferencia();
}
function UtiAnt() {
  $("#registrarPago").modal("show");
}
/*
function UtiAnt() {
  $("#boton004").prop("disabled", true);
  $("#boton005").prop("disabled", true);
  $("#boton006").prop("disabled", true);
  var CreditoActual = new Number(
    document.getElementById("CreditoActual").innerHTML,
  );

  document.getElementById("resultestadocb019").innerHTML = Utils.Num031;
  document.getElementById("palostiposdepago").innerHTML = `
    <div class="col">
      <div class="form-floating">
        <select name="TipodPagoPah" id="TipodPagoPah" class="form-select" onchange="changeornot();">
          ${
            Utils.LitEfectivo.trim() !== ""
              ? `<option value="1">${Utils.LitEfectivo}</option>`
              : ``
          }
          ${
            Utils.LitTarjeta.trim() !== ""
              ? `<option value="2">${Utils.LitTarjeta}</option>`
              : ``
          }
          ${
            Utils.LitCheque.trim() !== ""
              ? `<option value="3">${Utils.LitCheque}</option>`
              : ``
          }
          ${
            Utils.LitO01.trim() !== ""
              ? `<option value="4">${Utils.LitO01}</option>`
              : ``
          }
          ${
            Utils.LitO02.trim() !== ""
              ? `<option value="5">${Utils.LitO02}</option>`
              : ``
          }
          ${
            Utils.LitO03.trim() !== ""
              ? `<option value="6">${Utils.LitO03}</option>`
              : ``
          }
          ${
            Utils.LitO04.trim() !== ""
              ? `<option value="7">${Utils.LitO04}</option>`
              : ``
          }
        </select>
          <label>${Utils.Num400}</label>
      </div>
    </div>
  `;
  document.getElementById("decisions").innerHTML = "3";
  document.getElementById("FactorDCambio").value = 0;
  document.getElementById("ModalMonto2").value = 0;
  document.getElementById("ModalMonto").value = CreditoActual + 1;
  TipoMonedaChangin();
  changeornot();
  $("#realmenteimporta").show();
  $("#apps-modal2").modal("show");
  $("#boton004").prop("disabled", false);
  $("#boton005").prop("disabled", false);
  $("#boton006").prop("disabled", false);
}
*/

function TomarComoPago(Idtx, Idtipotx, IdEstacion, Contado, MontoPagar) {
  var a = new Number(0);
  document.getElementById("IdtxActual2").innerHTML = Idtx;
  document.getElementById("IdtipotxActual2").innerHTML = Idtipotx;
  document.getElementById("IdEstacionActual2").innerHTML = IdEstacion;
  document.getElementById("ContadoActual2").innerHTML = Contado - MontoPagar;
  document.getElementById("CreditoActual2").innerHTML = MontoPagar;
  document.getElementById("ModalMonto").value = a.toFixed(
    document.getElementById("CD").innerHTML,
  );
  document.getElementById("ModalMonto2").value = a.toFixed(
    document.getElementById("CD").innerHTML,
  );
  document.getElementById("ModalEA").value = "";
  document.getElementById("ModalReferencia").value = "";
  $("#ModoAnticipo").hide();
  $("#CompraAnticipo").prop("checked", false);
  $("#VentaAnticipo").prop("checked", true);
  ati(7);
}
/*
function Abonos(Idtx, Idtipotx, IdEstacion, Contado, Credito, Tasa) {
  var a = new Number(0);
  document.getElementById("IdtxActual").innerHTML = Idtx;
  document.getElementById("IdtipotxActual").innerHTML = Idtipotx;
  document.getElementById("IdEstacionActual").innerHTML = IdEstacion;
  document.getElementById("ContadoActual").innerHTML = Contado;
  document.getElementById("CreditoActual").innerHTML = Credito;
  document.getElementById("tasaactual").innerHTML = Tasa;
  document.getElementById("ModalMonto").value = a.toFixed(
    document.getElementById("CD").innerHTML,
  );
  document.getElementById("ModalMonto2").value = a.toFixed(
    document.getElementById("CD").innerHTML,
  );
  document.getElementById("ModalEA").value = "";
  document.getElementById("ModalReferencia").value = "";
  ati(2);
}
*/
function Abonos(Idtx, Idtipotx, IdEstacion, Contado, Credito, Tasa) {
  document.getElementById("IdtxActual").innerHTML = Idtx;
  document.getElementById("IdtipotxActual").innerHTML = Idtipotx;
  document.getElementById("IdEstacionActual").innerHTML = IdEstacion;
  document.getElementById("ContadoActual").innerHTML = Contado;
  document.getElementById("CreditoActual").innerHTML = Credito;
  document.getElementById("tasaactual").innerHTML = Tasa;

  document.getElementById("ModalMonto").value = new Number(0).toFixed(
    document.getElementById("CD").innerHTML,
  );
  document.getElementById("ModalMonto2").value = new Number(0).toFixed(
    document.getElementById("CD").innerHTML,
  );
  document.getElementById("json").value = "[]";
  document.getElementById("ModalEARegPag").value = "";
  document.getElementById("spago").value = "1";
  document.getElementById("VueltopagoABC").value = "1";
  document.getElementById("ModalReferenciaRegPag").value = "";
  document.getElementById("BancodelDocumento").value = "0";
  document.getElementById("LimitCreditCar").innerHTML = "";

  var fecha = new Date();
  var mes = fecha.getMonth() + 1;
  var dia = fecha.getDate();
  var ano = fecha.getFullYear();
  if (dia < 10) {
    dia = "0" + dia;
  }
  if (mes < 10) {
    mes = "0" + mes;
  }

  document.getElementById("ModalFechaRegPag").value =
    ano + "-" + mes + "-" + dia;

  TipoMonedaAbono();

  $.ajax({
    type: "POST",
    url: "estadocbseek.php",
    data: {
      Accion: "9",
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      IdBen: document.getElementById("Modalrut").value,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      Idtipotx: Idtipotx,
      MonedaS: document.getElementById("MonedaS").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 1) {
      var a = new Number(0);
      document.getElementById("ModalMonto").value = a.toFixed(
        document.getElementById("CD").innerHTML,
      );
      document.getElementById("ModalMonto2").value = a.toFixed(
        document.getElementById("CD").innerHTML,
      );
      document.getElementById("ModalEA").value = "";
      document.getElementById("ModalReferencia").value = "";
      document.getElementById("LimitCreditCar").innerHTML = "";
      $("#modal-a").modal("show");
    } else {
      $("#registrarPago").modal("show");
    }
  });
}

// --- FUNCIÓN SENIOR UX PARA AUTO-REFRESCADO ---
window.refrescarTablaPosUp = function() {
    // Cierre rápido y limpio de cualquier modal abierto
    $('.modal.show').modal('hide');
    
    // Llamamos a tu función principal que recarga los cuadros y la tabla
    if (typeof ActTable === 'function') {
        ActTable();
    } else {
        location.reload(); // Fallback por si la función no existe
    }
};
// ----------------------------------------------------

function addpago() {
  const tpags = new Number(document.getElementById("tpags").value);

  if (tpags <= 0) return;

  let json = JSON.parse(document.getElementById("json").value);
  const spago = document.getElementById("spago").value;
  const vueltotype = document.getElementById("VueltopagoABC").value;
  const text = $("#spago option:selected").text();
  const referencia = document.getElementById("ModalReferenciaRegPag").value;
  const banco = document.getElementById("BancodelDocumento").value;
  const vueltoText = $("#VueltopagoABC option:selected").text();
  let tasa = 1;
  if (document.getElementById("FactorCambioRegistroPago").value == "1") {
    tasa = new Number(document.getElementById("tasaactual").innerHTML);
  } else if (document.getElementById("FactorCambioRegistroPago").value == "2") {
    tasa = parseFloat(FactorCambio["FactorDolarCash"]);
  } else if (document.getElementById("FactorCambioRegistroPago").value == "3") {
    tasa = parseFloat(FactorCambio["FactorDolarPaypal"]);
  } else if (document.getElementById("FactorCambioRegistroPago").value == "4") {
    tasa = parseFloat(FactorCambio["FactorDolarZelle"]);
  } else if (document.getElementById("FactorCambioRegistroPago").value == "5") {
    tasa = parseFloat(FactorCambio["FactorDolar5"]);
  } else if (document.getElementById("FactorCambioRegistroPago").value == "6") {
    tasa = parseFloat(FactorCambio["FactorDolar6"]);
  } else if (document.getElementById("FactorCambioRegistroPago").value == "7") {
    tasa = parseFloat(FactorCambio["FactorDolar7"]);
  }
  let MontoAct = 0;
  let vuelto = 0;
  let totalpagar = new Number(
    document.getElementById("CreditoActual").innerHTML,
  );

  if (tasa > 1) {
    totalpagar = totalpagar * tasa;
  }

  if (spago == 9) {
    const VueltoCash = (tpags * -1) / tasa;

    json.push({
      IdPago: vueltotype,
      Pago: `${vueltoText} (Vuelto/Cambio)`,
      Monto: tpags * -1,
      Referencia:
        tasa > 1 && vueltotype == 4
          ? `${VueltoCash.toFixed(document.getElementById("CD").innerHTML)}|${
              FactorCambio.MonedaS
            }|${new Number(
              document.getElementById("tasaactual").innerHTML,
            ).toFixed(document.getElementById("CD").innerHTML)}`
          : ``,
      Banco: 0,
      tasa: tasa,
    });
    document.getElementById("json").value = JSON.stringify(json);
    document.getElementById("spago").value = "1";
    document.getElementById("VueltopagoABC").value = "1";
    document.getElementById("ModalReferenciaRegPag").value = "";
    document.getElementById("BancodelDocumento").value = "0";
    document.getElementById("TipoDivisaFA2").value = "1";
    tdoccentonce();
    actualizarpago();
    return;
  }

  Object.keys(json).forEach(function (c) {
    if (json[c].IdPago === 4) {
      MontoAct += Number(json[c].MontoDiviso * tasa);
    } else {
      MontoAct += Number(json[c].Monto);
    }
  });

  if (spago == 4) {
    let tasaDivisa = Moendas.find(
      (mon) =>
        mon.id === parseInt(document.getElementById("TipoDivisaFA2").value),
    ).value;

    if (parseInt(document.getElementById("TipoDivisaFA2").value) === 1)
      tasaDivisa = tasa;

    const montoTasa = (tpags / tasaDivisa) * tasa;

    vuelto =
      parseFloat(MontoAct.toFixed(2)) +
      parseFloat(montoTasa.toFixed(2)) -
      parseFloat(totalpagar.toFixed(2));

    json.push({
      IdPago: spago,
      Pago: text,
      Monto: tpags,
      MontoDiviso: tpags / tasaDivisa,
      Referencia: referencia,
      Banco: banco,
      tasa: tasaDivisa,
    });
  } else {
    vuelto =
      parseFloat(MontoAct.toFixed(2)) +
      parseFloat(tpags.toFixed(2)) -
      parseFloat(totalpagar.toFixed(2));

    json.push({
      IdPago: spago,
      Pago: text,
      Monto: tpags,
      Referencia: referencia,
      Banco: banco,
      tasa: tasa,
    });
  }
  if (vuelto > 0) {
    const VueltoCash = (vuelto * -1) / tasa;

    json.push({
      IdPago: vueltotype,
      Pago: `${vueltoText} (Vuelto/Cambio)`,
      Monto: vuelto * -1,
      MontoDiviso: VueltoCash * -1,
      Referencia:
        tasa > 1 && vueltotype == 4
          ? `${VueltoCash.toFixed(document.getElementById("CD").innerHTML)}|${
              FactorCambio.MonedaS
            }|${new Number(
              document.getElementById("tasaactual").innerHTML,
            ).toFixed(document.getElementById("CD").innerHTML)}`
          : ``,
      Banco: 0,
      tasa: tasa,
    });
  }
  document.getElementById("json").value = JSON.stringify(json);
  document.getElementById("spago").value = "1";
  document.getElementById("VueltopagoABC").value = "1";
  document.getElementById("ModalReferenciaRegPag").value = "";
  document.getElementById("BancodelDocumento").value = "0";
  document.getElementById("TipoDivisaFA2").value = "1";
  tdoccentonce();
  actualizarpago();
}
function deletepago(key) {
  const json = JSON.parse(document.getElementById("json").value);
  const json2 = [];
  let m = 0;
  if (json.length > 0) {
    Object.keys(json).forEach(function (c) {
      m++;
      if (m !== key) {
        json2.push(json[c]);
      }
    });
  }
  document.getElementById("json").value = JSON.stringify(json2);
  actualizarpago();
}

function actualizarpago() {
  const json = JSON.parse(document.getElementById("json").value);
  let totalpagar = new Number(
    document.getElementById("CreditoActual").innerHTML,
  );
  let moneda = document.getElementById("MonedaP").innerHTML;
  let tasa = 1;
  if (document.getElementById("FactorCambioRegistroPago").value == "1") {
    tasa = new Number(document.getElementById("tasaactual").innerHTML);
    if (tasa > 1) {
      moneda = document.getElementById("MonedaS").innerHTML;
      totalpagar = totalpagar * tasa;
    }
  } else if (document.getElementById("FactorCambioRegistroPago").value == "2") {
    tasa = parseFloat(FactorCambio["FactorDolarCash"]);
    if (tasa > 1) {
      moneda = $("#FactorCambioRegistroPago option:selected").text();
      totalpagar = totalpagar * tasa;
    }
  } else if (document.getElementById("FactorCambioRegistroPago").value == "3") {
    tasa = parseFloat(FactorCambio["FactorDolarPaypal"]);
    if (tasa > 1) {
      moneda = $("#FactorCambioRegistroPago option:selected").text();
      totalpagar = totalpagar * tasa;
    }
  } else if (document.getElementById("FactorCambioRegistroPago").value == "4") {
    tasa = parseFloat(FactorCambio["FactorDolarZelle"]);
    if (tasa > 1) {
      moneda = $("#FactorCambioRegistroPago option:selected").text();
      totalpagar = totalpagar * tasa;
    }
  } else if (document.getElementById("FactorCambioRegistroPago").value == "5") {
    tasa = parseFloat(FactorCambio["FactorDolar5"]);
    if (tasa > 1) {
      moneda = $("#FactorCambioRegistroPago option:selected").text();
      totalpagar = totalpagar * tasa;
    }
  } else if (document.getElementById("FactorCambioRegistroPago").value == "6") {
    tasa = parseFloat(FactorCambio["FactorDolar6"]);
    if (tasa > 1) {
      moneda = $("#FactorCambioRegistroPago option:selected").text();
      totalpagar = totalpagar * tasa;
    }
  } else if (document.getElementById("FactorCambioRegistroPago").value == "7") {
    tasa = parseFloat(FactorCambio["FactorDolar7"]);
    if (tasa > 1) {
      moneda = $("#FactorCambioRegistroPago option:selected").text();
      totalpagar = totalpagar * tasa;
    }
  }
  const CD = new Number(document.getElementById("CD").innerHTML);
  const SimDec = document.getElementById("SimDec").innerHTML;
  const SimMil = document.getElementById("SimMil").innerHTML;
  let totalpago = new Number(0);
  let efectivo = new Number(0);
  let divisa = new Number(0);
  let credito = new Number(0);
  let vueltoTotal = new Number(0);
  let vuelto = "";

  let m = 0;

  let html = "";
  if (json.length > 0) {
    Object.keys(json).forEach(function (c) {
      let arrayGenerico = [];
      m++;
      if (json[c].IdPago == "4") {
        totalpago += parseFloat(
          parseFloat(json[c].MontoDiviso * tasa).toFixed(2),
        );
      } else {
        totalpago += json[c].Monto;
      }
      if (json[c].IdPago == "1") {
        efectivo = json[c].Monto;
      } else if (json[c].IdPago == "4") {
        divisa += json[c].Monto;
        arrayGenerico = json[c].Referencia.split("|");
        if (arrayGenerico[3]) {
          vuelto = "Vuelto de : " + arrayGenerico[3];
        }
      } else if (json[c].IdPago == "8") {
        credito += json[c].Monto;
      }
      html += `
    <div class='col-12 text-start btn-light align-middle'>
      <div class='d-flex gap-2'>
      ${
        json[c].IdPago == "4"
          ? `
        <div>
          <div> ${json[c].Pago} : ${Formato(
              arrayGenerico[0],
              CD,
              SimDec,
              SimMil,
            )} ${arrayGenerico[1]} ${vuelto} </div>
          <div>(${Formato(json[c].Monto, CD, SimDec, SimMil)} ${moneda} (${
              arrayGenerico[1]
            })) / (${Formato(
              json[c].MontoDiviso * tasa,
              CD,
              SimDec,
              SimMil,
            )} ${moneda}) </div>
        </div>
        `
          : `
          <div>
            ${json[c].Pago}: ${Formato(
              json[c].Monto,
              CD,
              SimDec,
              SimMil,
            )} ${moneda} ${vuelto} 
          </div>
        `
      }
        <span onclick='deletepago(${m});' style='font-size:24px;' type='button' class='float-end fa fa-close align-middle'><span>
      </div>
    </div>
  `;
    });
  }

  faltante = new Number(totalpagar - totalpago);
  vueltoTotal = new Number(totalpagar - efectivo);
  vueltoTotal = new Number(vueltoTotal - (totalpago - efectivo));
  if (vueltoTotal >= 0) {
    vueltoTotal = 0;
  } else {
    totalpago = totalpago + vueltoTotal;
  }

  const totalpayCredito = totalpago - credito;

  if (credito > 0) {
    html += `
      <div class='col-12 text-start btn-warning' id='Mtocredito'>
        Total en Crédito : ${Formato(credito, CD, SimDec, SimMil)} ${moneda}
      </div>
    `;
  }

  html += `
    <div class="col-12 text-start btn-success">
      ${
        totalpayCredito < 0
          ? `
        <div>(Vuelto/Cambio) Pendiente: ${Formato(
          totalpayCredito * -1,
          CD,
          SimDec,
          SimMil,
        )} ${moneda}</div>

        <div>Total Documento Pendiente: ${Formato(
          (credito + totalpayCredito) * -1,
          CD,
          SimDec,
          SimMil,
        )} ${moneda}</div>
      `
          : `
        <div>Total Pagado: ${Formato(
          totalpayCredito,
          CD,
          SimDec,
          SimMil,
        )} ${moneda}</div>
      `
      }
    </div>
  `;

  if (faltante.toFixed(document.getElementById("CD").innerHTML) > 0) {
    html += `
      <div class='col-12 text-start btn-danger' id='faltantepagovisual'>
        Faltante: ${Formato(faltante, CD, SimDec, SimMil)} ${moneda}
      </div>
    `;
  }

  $("#pagos").html(html);

  if (faltante.toFixed(document.getElementById("CD").innerHTML) > 0) {
    document.getElementById("tpags").value = faltante.toFixed(
      document.getElementById("CD").innerHTML,
    );
  } else {
    document.getElementById("tpags").value = new Number(0).toFixed(
      document.getElementById("CD").innerHTML,
    );
  }
  document.getElementById("tpag").value = totalpagar.toFixed(
    document.getElementById("CD").innerHTML,
  );
}

function Creditos2(Idtx, Idtipotx, IdEstacion, Contado, Credito, Tasa) {
  var a = new Number(0);
  document.getElementById("IdtxActual").innerHTML = Idtx;
  document.getElementById("IdtipotxActual").innerHTML = Idtipotx;
  document.getElementById("IdEstacionActual").innerHTML = IdEstacion;
  if (Contado < 0) {
    Contado = 0;
  }
  document.getElementById("ContadoActual").innerHTML = Contado;
  document.getElementById("CreditoActual").innerHTML = Credito;

  if (Number(document.getElementById("LimiCreditoA").innerHTML) === 0) {
    LimitCredit = "Ilimitado";
    document.getElementById("LimitCreditCar").innerHTML = LimitCredit;
  } else {
    LimitCredit =
      Number(document.getElementById("LimiCreditoA").innerHTML) -
      Number(document.getElementById("CreditoTotalA").innerHTML);
    document.getElementById("LimitCreditCar").innerHTML = Formato(
      LimitCredit,
      document.getElementById("CD").innerHTML,
      document.getElementById("SimDec").innerHTML,
      document.getElementById("SimMil").innerHTML,
    );
  }

  document.getElementById("tasaactual").innerHTML = Tasa;
  document.getElementById("ModalMonto").value = a.toFixed(
    document.getElementById("CD").innerHTML,
  );
  document.getElementById("ModalMonto2").value = a.toFixed(
    document.getElementById("CD").innerHTML,
  );
  document.getElementById("ModalEA").value = "";
  document.getElementById("ModalReferencia").value = "";
  ati(5);
}

function Eliminar(Idtx, Idtipotx, IdEstacion, Item) {
  document.getElementById("resultestadocb019").innerHTML = Utils.Num036;
  $("#ModoAnticipo").hide();
  $("#CompraAnticipo").prop("checked", false);
  $("#VentaAnticipo").prop("checked", true);
  document.getElementById("decisions").innerHTML = "7";
  document.getElementById("IdtxActual").innerHTML = Idtx;
  document.getElementById("IdtipotxActual").innerHTML = Idtipotx;
  document.getElementById("IdEstacionActual").innerHTML = IdEstacion;
  document.getElementById("ItemActual").innerHTML = Item;
  $("#modal-a2").modal("show");
}

function EliminarTX(IdBarcode, tipo) {
  EliminarIdBarcode = IdBarcode;
  document.getElementById("desckk").innerHTML = tipo;
  $("#modalaxx").modal("show");
}

function ProcessDelete() {
  $("#modalaxx").modal("hide");
  if (EliminarIdBarcode !== -1) {
    $.ajax({
      type: "POST",
      url: "estadocbseek.php",
      data: { Accion: "EliminarTx", IdBarcode: EliminarIdBarcode },
    }).done(function (msg) {
      console.log(msg);
      EliminarIdBarcode = -1;
      ActTable();
    });
  }
}

function EliminarAnticipo(Idtx, Idtipotx, IdEstacion, Item) {
  document.getElementById("resultestadocb019").innerHTML = Utils.Num037;
  $("#ModoAnticipo").hide();
  $("#CompraAnticipo").prop("checked", false);
  $("#VentaAnticipo").prop("checked", true);
  document.getElementById("decisions").innerHTML = "8";
  document.getElementById("IdtxActual").innerHTML = Idtx;
  document.getElementById("IdtipotxActual").innerHTML = Idtipotx;
  document.getElementById("IdEstacionActual").innerHTML = IdEstacion;
  document.getElementById("ItemActual").innerHTML = Item;
  $("#modal-a2").modal("show");
}

function Editar2(
  Idtx,
  Idtipotx,
  IdEstacion,
  Contado,
  Credito,
  MontoPagar,
  Retenciones,
  Item,
) {
  var a = new Number(0);
  document.getElementById("IdtxActual").innerHTML = Idtx;
  document.getElementById("IdtipotxActual").innerHTML = Idtipotx;
  document.getElementById("IdEstacionActual").innerHTML = IdEstacion;
  document.getElementById("ContadoActual").innerHTML = Contado;
  document.getElementById("CreditoActual").innerHTML = Credito;
  document.getElementById("RetencionActual").innerHTML = Retenciones;
  document.getElementById("ItemActual").innerHTML = Item;
  document.getElementById("ModalMonto").value = a.toFixed(
    document.getElementById("CD").innerHTML,
  );
  document.getElementById("ModalMonto2").value = a.toFixed(
    document.getElementById("CD").innerHTML,
  );
  document.getElementById("ModalEA").value = "";
  document.getElementById("ModalReferencia").value = "";
  $.ajax({
    type: "POST",
    url: "estadocbseek.php",
    data: {
      Accion: "10",
      Editar: "SI",
      Idtx: document.getElementById("IdtxActual").innerHTML,
      Idtipotx: document.getElementById("IdtipotxActual").innerHTML,
      IdEstacion: document.getElementById("IdEstacionActual").innerHTML,
      Item: document.getElementById("ItemActual").innerHTML,
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
    },
  }).done(function (msg) {
    $("#Temporal").html(msg);
    document.getElementById("ModalReferencia").value =
      document.getElementById("Referenciactual").innerHTML;
    document.getElementById("ModalEA").value =
      document.getElementById("Dampliadoactual").innerHTML;
    $("#Temporal").html("");
  });
  ati(6);
}

function proceso(n) {
  if (n == 0) {
    if (document.getElementById("ObligarUsoDeBanco").innerHTML == 0) {
      proceso(1);
    } else {
      if (
        document.getElementById("TipodPagoPah").value > 1 &&
        document.getElementById("TipodPagoPah").value < 9
      ) {
        if (document.getElementById("Bancodeltipo").value !== "0") {
          proceso(1);
        } else {
          alertBootstrap(
            lang.num039.title,
            lang.num039.desc,
            "warning",
            "alertaerror",
            true,
            1,
          );
        }
      } else {
        proceso(1);
      }
    }
  }
  if (n == 1) {
    if (
      document.getElementById("ModalFecha").value !== "" ||
      document.getElementById("ModalFecha").value >
        document.getElementById("fechadehoy").value
    ) {
      if (
        document.getElementById("Fechadeltipodpago").value !== "" ||
        document.getElementById("Fechadeltipodpago").value >
          document.getElementById("fechadehoy").value
      ) {
        if (document.getElementById("ModalMonto").value > 0) {
          if (document.getElementById("ModalVuelto").value > 0) {
            let SumVuelto = 0;
            Vueltos.forEach((vuelto) => {
              SumVuelto += vuelto.amount;
            });

            if (
              SumVuelto >= Number(document.getElementById("ModalVuelto").value)
            ) {
              Procesar(4);
            } else {
              alertBootstrap(
                Utils.Num043.title,
                Utils.Num043.desc,
                "warning",
                "alertaerror",
                true,
                1,
              );
            }
          } else {
            Procesar(4);
          }
        } else {
          alertBootstrap(
            Utils.Num040.title,
            Utils.Num040.desc,
            "warning",
            "alertaerror",
            true,
            1,
          );
        }
      } else {
        alertBootstrap(
          Utils.Num041.title,
          Utils.Num041.desc,
          "warning",
          "alertaerror",
          true,
          1,
        );
      }
    } else {
      alertBootstrap(
        Utils.Num041.title,
        Utils.Num041.desc,
        "warning",
        "alertaerror",
        true,
        1,
      );
    }
  }
  if (n == 2) {
    $("#botonretencion1").prop("disabled", true);
    $("#botonretencion2").prop("disabled", true);
    var Retencion = new Number(document.getElementById("MontoRetencion").value);
    if (
      Retencion > 0 &&
      document.getElementById("CodigoActualizable").value.trim() !== "" &&
      document.getElementById("FechaRetencion").value.trim() !== ""
    ) {
      Procesar(4);
    }
    $("#botonretencion1").prop("disabled", false);
    $("#botonretencion2").prop("disabled", false);
  }
  if (n == 3) {
    $("#botonretencion3").prop("disabled", true);
    $("#botonretencion4").prop("disabled", true);
    var Retencion = new Number(
      document.getElementById("MontoRetenidoporm").value,
    );
    var Credito = new Number(
      document.getElementById("CreditoActual").innerHTML,
    );
    if (Credito < 0) {
      Credito = 0;
    }
    if (
      Retencion > 0 &&
      document.getElementById("NumbaOfRetencion").value.trim() !== "" &&
      document.getElementById("FechaRetencion2").value.trim() !== ""
    ) {
      if (Retencion > Credito) {
        alertBootstrap(
          Utils.Num042.title,
          `${Utils.Num042.desc} : ${Credito.toFixed(
            document.getElementById("CD").innerHTML,
          )}`,
          "warning",
          "alertaerror",
          true,
          1,
        );
      } else {
        Procesar(4);
      }
    }
    $("#botonretencion3").prop("disabled", false);
    $("#botonretencion4").prop("disabled", false);
  }
}

function procesoRegistroPago(n) {
  if (n == 0) {
    if (document.getElementById("ObligarUsoDeBanco").innerHTML == 0) {
      procesoRegistroPago(1);
      return;
    }

    if (
      document.getElementById("TipodPagoPah").value > 1 &&
      document.getElementById("TipodPagoPah").value < 9
    ) {
      if (document.getElementById("Bancodeltipo").value !== "0") {
        procesoRegistroPago(1);
        return;
      }
      alertBootstrap(
        lang.num039.title,
        lang.num039.desc,
        "warning",
        "alertaerror",
        true,
        1,
      );
      return;
    }
    procesoRegistroPago(1);

    return;
  }
  if (n == 1) {
    if (
      document.getElementById("ModalFechaRegPag").value === "" ||
      document.getElementById("ModalFechaRegPag").value <=
        document.getElementById("fechadehoy").value
    ) {
      alertBootstrap(
        Utils.Num041.title,
        Utils.Num041.desc,
        "warning",
        "alertaerror",
        true,
        1,
      );
      return;
    }

    procesoRegistroPago(2);
    return;
  }

  if (n == 2) {
    $("#registrarPago").modal("hide");

    var fecha = new Date();
    document.getElementById("Fectxclient").value =
      document.getElementById("ModalFechaRegPag").value +
      " " +
      fecha.getHours() +
      ":" +
      fecha.getMinutes() +
      ":" +
      fecha.getSeconds();

    const CajaC =
      dataCaja?.find(
        (caja) => caja.token === document.getElementById("tokeninUse").value,
      )?.CajaActual ?? "0";
    $("#modal-proce").modal("show");
    $.ajax({
      type: "POST",
      url: "estadocbhandler.php",
      data: {
        tabla: "registrarPago",
        dampliado: document.getElementById("ModalEARegPag").value,
        Fectxclient: document.getElementById("Fectxclient").value,
        json: document.getElementById("json").value,
        IdCompanyUser: document.getElementById("userCompany").innerHTML,
        tasa: document.getElementById("tasaactual").innerHTML,
        Idtx2: document.getElementById("IdtxActual2").innerHTML,
        Idtipotx2: document.getElementById("IdtipotxActual2").innerHTML,
        IdEstacion3: document.getElementById("IdEstacionActual2").innerHTML,
        correo: document.getElementById("correorep").innerHTML,
        Token: document.getElementById("tokeninUse").value,
        IdUser: document.getElementById("userlogin").innerHTML,
        IdCompanyActual: document.getElementById("userCompany").innerHTML,
        Idtipotx: document.getElementById("IdtipotxActual").innerHTML,
        Idtx: document.getElementById("IdtxActual").innerHTML,
        IdEstacion: document.getElementById("IdEstacionActual").innerHTML,
        IdBen: document.getElementById("Modalrut").value,
        CompanyActual: document.getElementById("CompanyActual").innerHTML,
        CajaActual: CajaC,
        IdEstacion2: document.getElementById("tokeninUse").value,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        MonedaS: document.getElementById("MonedaS").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
      },
    }).done(function (msg) {
      const array = JSON.parse(msg);
      if (array.status === true) {
        $("#modal-proce").modal("hide");
        ActTable();
      } else {
        alert("error al guardar");
        $("#modal-proce").modal("hide");
      }
    });
  }
}

function Procesar(opcion) {
  if (opcion === 4) {
    if (
      document.getElementById("decisions").innerHTML == "7" ||
      document.getElementById("decisions").innerHTML == "8"
    ) {
      $("button").prop("disabled", true);
      $("#modal-a2").modal("hide");
      $("button").prop("disabled", false);
    } else if (document.getElementById("decisions").innerHTML == "2") {
      $("#apps-modal2x").modal("hide");
    } else if (document.getElementById("decisions").innerHTML == "9") {
      $("#apps-modal2c").modal("hide");
    } else {
      $("#apps-modal2").modal("hide");
    }
    if (document.getElementById("decisions").innerHTML == "2") {
      document.getElementById("Contado").value =
        document.getElementById("MontoRetencion").value;
      document.getElementById("Credito").value = 0;
      document.getElementById("Efectivo").value = 0;
      document.getElementById("Vuelto").value = 0;
      document.getElementById("Tarjeta").value = 0;
      document.getElementById("TarjetaD").value = "";
      document.getElementById("Cheque").value = 0;
      document.getElementById("ChequeD").value = "";
      document.getElementById("Tipo01").value = 0;
      document.getElementById("Tipo01D").value = "";
      document.getElementById("Tipo02").value = 0;
      document.getElementById("Tipo02D").value = "";
      document.getElementById("Tipo03").value = 0;
      document.getElementById("Tipo03D").value = "";
      document.getElementById("Tipo04").value = 0;
      document.getElementById("Tipo04D").value = "";
      document.getElementById("Retencion").value =
        document.getElementById("MontoRetencion").value;
      document.getElementById("Anticipo").value = 0;
      document.getElementById("AnticipoD").value = "";
      document.getElementById("TarjetaB").value = 0;
      document.getElementById("ChequeB").value = 0;
      document.getElementById("Tipo01B").value = 0;
      document.getElementById("Tipo02B").value = 0;
      document.getElementById("Tipo03B").value = 0;
      document.getElementById("Tipo04B").value = 0;
      document.getElementById("AnticipoB").value = 0;
      document.getElementById("MontoPagar").value =
        document.getElementById("MontoRetencion").value;
      document.getElementById("ModalReferencia").value =
        document.getElementById("CodigoActualizable").value;
      var fecha = new Date();
      document.getElementById("Fectxclient").value =
        document.getElementById("FechaRetencion").value +
        " " +
        fecha.getHours() +
        ":" +
        fecha.getMinutes() +
        ":" +
        fecha.getSeconds();
      document.getElementById("Fectxclient2").value =
        document.getElementById("FechaRetencion").value +
        " " +
        fecha.getHours() +
        ":" +
        fecha.getMinutes() +
        ":" +
        fecha.getSeconds();
      document.getElementById("numret").value = document.getElementById(
        "codigodelimpuestopa",
      ).value;
    } else {
      if (document.getElementById("decisions").innerHTML == "9") {
        document.getElementById("Contado").value =
          document.getElementById("MontoRetenidoporm").value;
        document.getElementById("Credito").value = 0;
        document.getElementById("Efectivo").value = 0;
        document.getElementById("Vuelto").value = 0;
        document.getElementById("Tarjeta").value = 0;
        document.getElementById("TarjetaD").value = "";
        document.getElementById("Cheque").value = 0;
        document.getElementById("ChequeD").value = "";
        document.getElementById("Tipo01").value = 0;
        document.getElementById("Tipo01D").value = "";
        document.getElementById("Tipo02").value = 0;
        document.getElementById("Tipo02D").value = "";
        document.getElementById("Tipo03").value = 0;
        document.getElementById("Tipo03D").value = "";
        document.getElementById("Tipo04").value = 0;
        document.getElementById("Tipo04D").value = "";
        document.getElementById("Retencion").value =
          document.getElementById("MontoRetenidoporm").value;
        document.getElementById("Anticipo").value = 0;
        document.getElementById("AnticipoD").value = "";
        document.getElementById("TarjetaB").value = 0;
        document.getElementById("ChequeB").value = 0;
        document.getElementById("Tipo01B").value = 0;
        document.getElementById("Tipo02B").value = 0;
        document.getElementById("Tipo03B").value = 0;
        document.getElementById("Tipo04B").value = 0;
        document.getElementById("AnticipoB").value = 0;
        document.getElementById("MontoPagar").value =
          document.getElementById("MontoRetenidoporm").value;
        document.getElementById("ModalReferencia").value =
          document.getElementById("NumbaOfRetencion").value;
        var fecha = new Date();
        document.getElementById("Fectxclient").value =
          document.getElementById("FechaRetencion2").value +
          " " +
          fecha.getHours() +
          ":" +
          fecha.getMinutes() +
          ":" +
          fecha.getSeconds();
        document.getElementById("Fectxclient2").value =
          document.getElementById("FechaRetencion2").value +
          " " +
          fecha.getHours() +
          ":" +
          fecha.getMinutes() +
          ":" +
          fecha.getSeconds();
        document.getElementById("numret").value =
          document.getElementById("CodigoDlaRetencion").value;
      } else {
        if (document.getElementById("TipodPagoPah").value == "1") {
          document.getElementById("Contado").value =
            document.getElementById("ModalMonto2").value;
          document.getElementById("Credito").value = 0;
          document.getElementById("Efectivo").value =
            document.getElementById("ModalMonto2").value;
          document.getElementById("Vuelto").value = 0;
          document.getElementById("Tarjeta").value = 0;
          document.getElementById("TarjetaD").value = "";
          document.getElementById("Cheque").value = 0;
          document.getElementById("ChequeD").value = "";
          document.getElementById("Tipo01").value = 0;
          document.getElementById("Tipo01D").value = "";
          document.getElementById("Tipo02").value = 0;
          document.getElementById("Tipo02D").value = "";
          document.getElementById("Tipo03").value = 0;
          document.getElementById("Tipo03D").value = "";
          document.getElementById("Tipo04").value = 0;
          document.getElementById("Tipo04D").value = "";
          document.getElementById("Retencion").value = 0;
          document.getElementById("Anticipo").value = 0;
          document.getElementById("AnticipoD").value = "";
          document.getElementById("TarjetaB").value = 0;
          document.getElementById("ChequeB").value = 0;
          document.getElementById("Tipo01B").value = 0;
          document.getElementById("Tipo02B").value = 0;
          document.getElementById("Tipo03B").value = 0;
          document.getElementById("Tipo04B").value = 0;
          document.getElementById("AnticipoB").value = 0;
        }

        if (document.getElementById("TipodPagoPah").value == "2") {
          document.getElementById("Contado").value =
            document.getElementById("ModalMonto2").value;
          document.getElementById("Credito").value = 0;
          document.getElementById("Efectivo").value = 0;
          document.getElementById("Vuelto").value = 0;
          document.getElementById("Tarjeta").value =
            document.getElementById("ModalMonto2").value;
          document.getElementById("TarjetaD").value =
            document.getElementById("Referenciadeltipo").value;
          document.getElementById("Cheque").value = 0;
          document.getElementById("ChequeD").value = "";
          document.getElementById("Tipo01").value = 0;
          document.getElementById("Tipo01D").value = "";
          document.getElementById("Tipo02").value = 0;
          document.getElementById("Tipo02D").value = "";
          document.getElementById("Tipo03").value = 0;
          document.getElementById("Tipo03D").value = "";
          document.getElementById("Tipo04").value = 0;
          document.getElementById("Tipo04D").value = "";
          document.getElementById("Retencion").value = 0;
          document.getElementById("Anticipo").value = 0;
          document.getElementById("AnticipoD").value = "";
          document.getElementById("TarjetaB").value =
            document.getElementById("Bancodeltipo").value;
          document.getElementById("ChequeB").value = 0;
          document.getElementById("Tipo01B").value = 0;
          document.getElementById("Tipo02B").value = 0;
          document.getElementById("Tipo03B").value = 0;
          document.getElementById("Tipo04B").value = 0;
          document.getElementById("AnticipoB").value = 0;
        }

        if (document.getElementById("TipodPagoPah").value == "3") {
          document.getElementById("Contado").value =
            document.getElementById("ModalMonto2").value;
          document.getElementById("Credito").value = 0;
          document.getElementById("Efectivo").value = 0;
          document.getElementById("Vuelto").value = 0;
          document.getElementById("Tarjeta").value = 0;
          document.getElementById("TarjetaD").value = "";
          document.getElementById("Cheque").value =
            document.getElementById("ModalMonto2").value;
          document.getElementById("ChequeD").value =
            document.getElementById("Referenciadeltipo").value;
          document.getElementById("Tipo01").value = 0;
          document.getElementById("Tipo01D").value = "";
          document.getElementById("Tipo02").value = 0;
          document.getElementById("Tipo02D").value = "";
          document.getElementById("Tipo03").value = 0;
          document.getElementById("Tipo03D").value = "";
          document.getElementById("Tipo04").value = 0;
          document.getElementById("Tipo04D").value = "";
          document.getElementById("Retencion").value = 0;
          document.getElementById("Anticipo").value = 0;
          document.getElementById("AnticipoD").value = "";
          document.getElementById("TarjetaB").value = 0;
          document.getElementById("ChequeB").value =
            document.getElementById("Bancodeltipo").value;
          document.getElementById("Tipo01B").value = 0;
          document.getElementById("Tipo02B").value = 0;
          document.getElementById("Tipo03B").value = 0;
          document.getElementById("Tipo04B").value = 0;
          document.getElementById("AnticipoB").value = 0;
        }
        if (document.getElementById("TipodPagoPah").value == "4") {
          document.getElementById("Contado").value =
            document.getElementById("ModalMonto2").value;
          document.getElementById("Credito").value = 0;
          document.getElementById("Efectivo").value = 0;
          document.getElementById("Vuelto").value = 0;
          document.getElementById("Tarjeta").value = 0;
          document.getElementById("TarjetaD").value = "";
          document.getElementById("Cheque").value = 0;
          document.getElementById("ChequeD").value = "";
          document.getElementById("Tipo01").value =
            document.getElementById("ModalMonto2").value;
          document.getElementById("Tipo01D").value =
            document.getElementById("Referenciadeltipo").value;
          document.getElementById("Tipo02").value = 0;
          document.getElementById("Tipo02D").value = "";
          document.getElementById("Tipo03").value = 0;
          document.getElementById("Tipo03D").value = "";
          document.getElementById("Tipo04").value = 0;
          document.getElementById("Tipo04D").value = "";
          document.getElementById("Retencion").value = 0;
          document.getElementById("Anticipo").value = 0;
          document.getElementById("AnticipoD").value = "";
          document.getElementById("TarjetaB").value = 0;
          document.getElementById("ChequeB").value = 0;
          document.getElementById("Tipo01B").value =
            document.getElementById("Bancodeltipo").value;
          document.getElementById("Tipo02B").value = 0;
          document.getElementById("Tipo03B").value = 0;
          document.getElementById("Tipo04B").value = 0;
          document.getElementById("AnticipoB").value = 0;
        }
        if (document.getElementById("TipodPagoPah").value == "5") {
          document.getElementById("Contado").value =
            document.getElementById("ModalMonto2").value;
          document.getElementById("Credito").value = 0;
          document.getElementById("Efectivo").value = 0;
          document.getElementById("Vuelto").value = 0;
          document.getElementById("Tarjeta").value = 0;
          document.getElementById("TarjetaD").value = "";
          document.getElementById("Cheque").value = 0;
          document.getElementById("ChequeD").value = "";
          document.getElementById("Tipo01").value = 0;
          document.getElementById("Tipo01D").value = "";
          document.getElementById("Tipo02").value =
            document.getElementById("ModalMonto2").value;
          document.getElementById("Tipo02D").value =
            document.getElementById("Referenciadeltipo").value;
          document.getElementById("Tipo03").value = 0;
          document.getElementById("Tipo03D").value = "";
          document.getElementById("Tipo04").value = 0;
          document.getElementById("Tipo04D").value = "";
          document.getElementById("Retencion").value = 0;
          document.getElementById("Anticipo").value = 0;
          document.getElementById("AnticipoD").value = "";
          document.getElementById("TarjetaB").value = 0;
          document.getElementById("ChequeB").value = 0;
          document.getElementById("Tipo01B").value = 0;
          document.getElementById("Tipo02B").value =
            document.getElementById("Bancodeltipo").value;
          document.getElementById("Tipo03B").value = 0;
          document.getElementById("Tipo04B").value = 0;
          document.getElementById("AnticipoB").value = 0;
        }
        if (document.getElementById("TipodPagoPah").value == "6") {
          document.getElementById("Contado").value =
            document.getElementById("ModalMonto2").value;
          document.getElementById("Credito").value = 0;
          document.getElementById("Efectivo").value = 0;
          document.getElementById("Vuelto").value = 0;
          document.getElementById("Tarjeta").value = 0;
          document.getElementById("TarjetaD").value = "";
          document.getElementById("Cheque").value = 0;
          document.getElementById("ChequeD").value = "";
          document.getElementById("Tipo01").value = 0;
          document.getElementById("Tipo01D").value = "";
          document.getElementById("Tipo02").value = 0;
          document.getElementById("Tipo02D").value = "";
          document.getElementById("Tipo03").value =
            document.getElementById("ModalMonto2").value;
          document.getElementById("Tipo03D").value =
            document.getElementById("Referenciadeltipo").value;
          document.getElementById("Tipo04").value = 0;
          document.getElementById("Tipo04D").value = "";
          document.getElementById("Retencion").value = 0;
          document.getElementById("Anticipo").value = 0;
          document.getElementById("AnticipoD").value = "";
          document.getElementById("TarjetaB").value = 0;
          document.getElementById("ChequeB").value = 0;
          document.getElementById("Tipo01B").value = 0;
          document.getElementById("Tipo02B").value = 0;
          document.getElementById("Tipo03B").value =
            document.getElementById("Bancodeltipo").value;
          document.getElementById("Tipo04B").value = 0;
          document.getElementById("AnticipoB").value = 0;
        }
        if (document.getElementById("TipodPagoPah").value == "7") {
          document.getElementById("Contado").value =
            document.getElementById("ModalMonto2").value;
          document.getElementById("Credito").value = 0;
          document.getElementById("Efectivo").value = 0;
          document.getElementById("Vuelto").value = 0;
          document.getElementById("Tarjeta").value = 0;
          document.getElementById("TarjetaD").value = "";
          document.getElementById("Cheque").value = 0;
          document.getElementById("ChequeD").value = "";
          document.getElementById("Tipo01").value = 0;
          document.getElementById("Tipo01D").value = "";
          document.getElementById("Tipo02").value = 0;
          document.getElementById("Tipo02D").value = "";
          document.getElementById("Tipo03").value = 0;
          document.getElementById("Tipo03D").value = "";
          document.getElementById("Tipo04").value =
            document.getElementById("ModalMonto2").value;
          document.getElementById("Tipo04D").value =
            document.getElementById("Referenciadeltipo").value;
          document.getElementById("Retencion").value = 0;
          document.getElementById("Anticipo").value = 0;
          document.getElementById("AnticipoD").value = "";
          document.getElementById("TarjetaB").value = 0;
          document.getElementById("ChequeB").value = 0;
          document.getElementById("Tipo01B").value = 0;
          document.getElementById("Tipo02B").value = 0;
          document.getElementById("Tipo03B").value = 0;
          document.getElementById("Tipo04B").value =
            document.getElementById("Bancodeltipo").value;
          document.getElementById("AnticipoB").value = 0;
        }
        if (document.getElementById("TipodPagoPah").value == "8") {
          document.getElementById("Contado").value =
            document.getElementById("ModalMonto2").value;
          document.getElementById("Credito").value = 0;
          document.getElementById("Efectivo").value = 0;
          document.getElementById("Vuelto").value = 0;
          document.getElementById("Tarjeta").value = 0;
          document.getElementById("TarjetaD").value = "";
          document.getElementById("Cheque").value = 0;
          document.getElementById("ChequeD").value = "";
          document.getElementById("Tipo01").value = 0;
          document.getElementById("Tipo01D").value = "";
          document.getElementById("Tipo02").value = 0;
          document.getElementById("Tipo02D").value = "";
          document.getElementById("Tipo03").value = 0;
          document.getElementById("Tipo03D").value = "";
          document.getElementById("Tipo04").value = 0;
          document.getElementById("Tipo04D").value = "";
          document.getElementById("Retencion").value = 0;
          document.getElementById("Anticipo").value =
            document.getElementById("ModalMonto2").value;
          document.getElementById("AnticipoD").value =
            document.getElementById("Referenciadeltipo").value;
          document.getElementById("TarjetaB").value = 0;
          document.getElementById("ChequeB").value = 0;
          document.getElementById("Tipo01B").value = 0;
          document.getElementById("Tipo02B").value = 0;
          document.getElementById("Tipo03B").value = 0;
          document.getElementById("Tipo04B").value = 0;
          document.getElementById("AnticipoB").value =
            document.getElementById("Bancodeltipo").value;
        }
        if (document.getElementById("TipodPagoPah").value == "9") {
          document.getElementById("Contado").value = 0;
          document.getElementById("Credito").value =
            document.getElementById("ModalMonto2").value;
          document.getElementById("Efectivo").value = 0;
          document.getElementById("Vuelto").value = 0;
          document.getElementById("Tarjeta").value = 0;
          document.getElementById("TarjetaD").value = "";
          document.getElementById("Cheque").value = 0;
          document.getElementById("ChequeD").value = "";
          document.getElementById("Tipo01").value = 0;
          document.getElementById("Tipo01D").value = "";
          document.getElementById("Tipo02").value = 0;
          document.getElementById("Tipo02D").value = "";
          document.getElementById("Tipo03").value = 0;
          document.getElementById("Tipo03D").value = "";
          document.getElementById("Tipo04").value = 0;
          document.getElementById("Tipo04D").value = "";
          document.getElementById("Retencion").value = 0;
          document.getElementById("Anticipo").value = 0;
          document.getElementById("AnticipoD").value = "";
          document.getElementById("TarjetaB").value = 0;
          document.getElementById("ChequeB").value = 0;
          document.getElementById("Tipo01B").value = 0;
          document.getElementById("Tipo02B").value = 0;
          document.getElementById("Tipo03B").value = 0;
          document.getElementById("Tipo04B").value = 0;
          document.getElementById("AnticipoB").value = 0;
        }
        document.getElementById("MontoPagar").value =
          document.getElementById("ModalMonto").value;
        var fecha = new Date();
        document.getElementById("Fectxclient").value =
          document.getElementById("ModalFecha").value +
          " " +
          fecha.getHours() +
          ":" +
          fecha.getMinutes() +
          ":" +
          fecha.getSeconds();
        document.getElementById("Fectxclient2").value =
          document.getElementById("Fechadeltipodpago").value +
          " " +
          fecha.getHours() +
          ":" +
          fecha.getMinutes() +
          ":" +
          fecha.getSeconds();
      }
    }
    $("#modal-proce").modal("show");
    const CajaC =
      dataCaja?.find(
        (caja) => caja.token === document.getElementById("tokeninUse").value,
      )?.CajaActual ?? "0";
    var valor = document.getElementById("tokeninUse").value;
    var valor2 = document.getElementById("userlogin").innerHTML;
    var valor3 = document.getElementById("userCompany").innerHTML;
    $.ajax({
      type: "POST",
      url: "estadocbhandler.php",
      data: {
        tabla: "estadocb",
        numret: document.getElementById("numret").value,
        IdCompanyUser: valor3,
        Retencion: document.getElementById("Retencion").value,
        Fectxclient2: document.getElementById("Fectxclient2").value,
        MontoPagar: document.getElementById("MontoPagar").value,
        Contado: document.getElementById("Contado").value,
        Credito: document.getElementById("Credito").value,
        Efectivo: document.getElementById("Efectivo").value,
        Vuelto: document.getElementById("Vuelto").value,
        Tarjeta: document.getElementById("Tarjeta").value,
        TarjetaD: document.getElementById("TarjetaD").value,
        Cheque: document.getElementById("Cheque").value,
        ChequeD: document.getElementById("ChequeD").value,
        Tipo01: document.getElementById("Tipo01").value,
        Tipo01D: document.getElementById("Tipo01D").value,
        Tipo02: document.getElementById("Tipo02").value,
        Tipo02D: document.getElementById("Tipo02D").value,
        Tipo03: document.getElementById("Tipo03").value,
        Tipo03D: document.getElementById("Tipo03D").value,
        Tipo04: document.getElementById("Tipo04").value,
        Tipo04D: document.getElementById("Tipo04D").value,
        Anticipos: document.getElementById("Anticipo").value,
        AnticipoCompra: $("#CompraAnticipo").prop("checked"),
        AnticiposRefe: document.getElementById("AnticipoD").value,
        TarjetaB: document.getElementById("TarjetaB").value,
        ChequeB: document.getElementById("ChequeB").value,
        Tipo01B: document.getElementById("Tipo01B").value,
        Tipo02B: document.getElementById("Tipo02B").value,
        Tipo03B: document.getElementById("Tipo03B").value,
        Tipo04B: document.getElementById("Tipo04B").value,
        AnticiposBanco: document.getElementById("AnticipoB").value,
        FactorDCambio: document.getElementById("FactorDeCambioActual").value,
        Idtx2: document.getElementById("IdtxActual2").innerHTML,
        Idtipotx2: document.getElementById("IdtipotxActual2").innerHTML,
        IdEstacion3: document.getElementById("IdEstacionActual2").innerHTML,
        Contado2: document.getElementById("ContadoActual2").innerHTML,
        Credito2: document.getElementById("CreditoActual2").innerHTML,
        Retencion2: document.getElementById("RetencionActual2").innerHTML,
        Item: document.getElementById("ItemActual").innerHTML,
        decisions: document.getElementById("decisions").innerHTML,
        Referencia: document.getElementById("ModalReferencia").value,
        correo: document.getElementById("correorep").innerHTML,
        Token: valor,
        IdUser: valor2,
        IdCompanyActual: valor3,
        Idtipotx: document.getElementById("IdtipotxActual").innerHTML,
        Idtx: document.getElementById("IdtxActual").innerHTML,
        IdEstacion: document.getElementById("IdEstacionActual").innerHTML,
        Fectxclient: document.getElementById("Fectxclient").value,
        IdBen: document.getElementById("Modalrut").value,
        CompanyActual: document.getElementById("CompanyActual").innerHTML,
        CajaActual: CajaC,
        IdEstacion2: document.getElementById("tokeninUse").value,
        dampliado: document.getElementById("ModalEA").value,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        MonedaS: document.getElementById("MonedaS").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        ModalVuelto: document.getElementById("ModalVuelto").value,
        Vueltos: Vueltos,
      },
    }).done(function (msg) {
      $("#Temporal").html(msg);
      if (msg.trim() == 1) {
        $("#modal-proce").modal("hide");
        ActTable();
      } else {
        alert("error al guardar");
        $("#modal-proce").modal("hide");
      }
      $("#boton1").prop("disabled", false);
      $("#boton2").prop("disabled", false);
    });
  }
}

function Selectorangodel() {
  if (document.getElementById("SelectorDiaMes").value == "1") {
    $("#ModaldesdeA").prop("disabled", true);
    $("#ModalhastaA").prop("disabled", true);
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
    document.getElementById("ModaldesdeA").value =
      ano + "-" + mes + "-" + dia + "T" + horai + ":" + mini;
    document.getElementById("ModalhastaA").value =
      ano + "-" + mes + "-" + dia + "T" + horaf + ":" + minf + ":" + segf;
    ActTable();
  }
  if (document.getElementById("SelectorDiaMes").value == "2") {
    $("#Modaldesde").prop("disabled", true);
    $("#Modalhasta").prop("disabled", true);
    var fecha = sumarDias(new Date(), -1);
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
    document.getElementById("Modaldesde").value =
      ano + "-" + mes + "-" + dia + "T" + horai + ":" + mini;
    document.getElementById("Modalhasta").value =
      ano + "-" + mes + "-" + dia + "T" + horaf + ":" + minf + ":" + segf;
    ActTable();
  }

  if (document.getElementById("SelectorDiaMes").value == "3") {
    $("#ModaldesdeA").prop("disabled", true);
    $("#ModalhastaA").prop("disabled", true);
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
    document.getElementById("ModaldesdeA").value =
      ano + "-" + mes + "-" + "01" + "T" + horai + ":" + mini;
    document.getElementById("ModalhastaA").value =
      ano + "-" + mes + "-" + lastDay + "T" + horaf + ":" + minf + ":" + segf;
    ActTable();
  }

  if (document.getElementById("SelectorDiaMes").value == "4") {
    $("#ModaldesdeA").prop("disabled", true);
    $("#ModalhastaA").prop("disabled", true);
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
    document.getElementById("ModaldesdeA").value =
      ano + "-" + mes + "-" + "01" + "T" + horai + ":" + mini;
    document.getElementById("ModalhastaA").value =
      ano + "-" + mes + "-" + lastDay + "T" + horaf + ":" + minf + ":" + segf;
    ActTable();
  }

  if (document.getElementById("SelectorDiaMes").value == "5") {
    $("#ModaldesdeA").prop("disabled", false);
    $("#ModalhastaA").prop("disabled", false);
    fechas();
    ActTable();
  }

  // --- FUNCIÓN SENIOR UX PARA AUTO-REFRESCADO ---
window.refrescarTablaPosUp = function() {
    // Cierre rápido y limpio de cualquier modal abierto
    $('.modal.show').modal('hide');
    
    // Llamamos a tu función principal que recarga los cuadros y la tabla
    if (typeof ActTable === 'function') {
        ActTable();
    } else {
        location.reload(); // Fallback por si la función no existe
    }
};
// ----------------------------------------------------
}
