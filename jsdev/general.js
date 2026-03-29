let funcionPendiente = null;

function focusmodalclose(modal, focus) {
  $("#" + modal).modal("hide");
  $("#" + focus).focus();
}

function CerrarTraslado(IdEstacion, Idtipotx, Idtx, IdBarcode) {
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
    },
  }).done(function (msg) {});
}

function ejecutarFuncionPendiente() {
  if (funcionPendiente) {
    $.ajax({
      type: "POST",
      url: "generalseek.php",
      async: false,
      data: {
        Accion: "VerificarFiscal",
        CompanyActual: document.getElementById("CompanyActual").innerHTML,
        token: document.getElementById("tokeninUse").value,
      },
    }).done(function (msg) {
      const arrayx = JSON.parse(msg);

      if (arrayx.msg != 1) {
        return false;
      }

      funcionPendiente();
      funcionPendiente = null;
      $("#impresfiscalapp").modal("hide");
    });
  }
}

async function verificacionFiscal(funcion) {
  const Caja = dataCaja?.find(
    (caja) => caja.token === document.getElementById("tokeninUse").value,
  ) ?? { tipocaja: 0 };

  if (Caja?.tipocaja == 1) {
    funcion();
    return false;
  }

  $.ajax({
    type: "POST",
    url: "generalseek.php",
    async: false,
    data: {
      Accion: "VerificarFiscal",
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      token: document.getElementById("tokeninUse").value,
    },
  }).done(function (msg) {
    const arrayx = JSON.parse(msg);

    if (arrayx.msg != 1) {
      funcionPendiente = funcion;
      const data = codigoFinalizacionMF(arrayx.msg);
      $("#ImpresoraFiscalInfTitle").html(data.title);
      $("#ImpresoraFiscalInfDesc").html(data.desc);
      $("#impresfiscalapp").modal("show");

      // ✅ Guardamos la función pendiente para ejecutarla después

      return false;
    }

    $("#impresfiscalapp").modal("hide");
    funcion();
    funcionPendiente = null; // ✅ Ya se ejecutó, limpiamos la variable
  });
}
function delaydatable(id = "") {
  var container = document.querySelector("#" + id + "_filter");
  var input = container.querySelector(".dataTables_filter label  input");

  const updateDebounceValue = () => {
    var dtable = $("#" + id).DataTable();
    dtable.search($(".dataTables_filter input").val()).draw();
  };

  let debounceTimer;

  const debounce = (callback, time) => {
    window.clearTimeout(debounceTimer);
    debounceTimer = window.setTimeout(callback, time);
  };

  input.addEventListener(
    "input",
    () => {
      debounce(updateDebounceValue, 500);
    },
    false,
  );

  $("#" + id + "_wrapper .dataTables_filter input")
    .unbind() // Unbind previous default bindings
    .bind("input", function (e) {
      // Bind our desired behavior

      return;
    });
}

function sumarDias(fecha, dias) {
  fecha.setUTCDate(fecha.getUTCDate() + dias);
  return fecha;
}

let CodigoDeBarras = "";

function ImprimirCodBarra(CodIdBasico, cod, desc) {
  CodigoDeBarras = {
    CodIdBasico: CodIdBasico,
    cod: cod,
    desc: desc,
  };
  $("#modalPrintCodBarra").modal("show");
}

function PrintCodBarra(form) {
  $("#modalPrintCodBarra").modal("hide");
  $.ajax({
    type: "POST",
    url: "codigobarras.php",
    data: {
      Accion: form,
      cod: CodigoDeBarras.cod,
      des: CodigoDeBarras.desc,
      CodIdBasico: CodigoDeBarras.CodIdBasico,
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      MonedaP: document.getElementById("MonedaP").innerHTML,
      MonedaS: document.getElementById("MonedaS").innerHTML,
    },
  }).done(function (msg) {
    //alert (msg);
    $("#prints").html(msg);
    setTimeout(() => window.print(), 300);
  });
}

function convertdatetime(fecha) {
  var t = fecha.replace("T", " ").split(/[- :]/);

  // Apply each element to the Date function
  var d = new Date(t[0], t[1] - 1, t[2], t[3], t[4], t[5] ?? "00");
  var date = new Date(d);
  var dia = date.getDate();
  var mes = date.getMonth() + 1;

  if (dia < 10) dia = "0" + dia;
  if (mes < 10) mes = "0" + mes;
  return (
    date.getFullYear() +
    "-" +
    mes +
    "-" +
    dia +
    " " +
    date.getHours() +
    ":" +
    date.getMinutes() +
    ":" +
    date.getSeconds()
  );
}

function convertdatetime2(fecha) {
  var t = fecha.split(/[- :]/);

  // Apply each element to the Date function
  var d = new Date(t[0], t[1] - 1, t[2], t[3], t[4], t[5]);
  var date = new Date(d);
  var dia = date.getDate();
  var mes = date.getMonth() + 1;

  if (dia < 10) dia = "0" + dia;
  if (mes < 10) mes = "0" + mes;
  return (
    date.getFullYear() +
    "-" +
    mes +
    "-" +
    dia +
    "T" +
    date.getHours() +
    ":" +
    date.getMinutes() +
    ":" +
    date.getSeconds()
  );
}

function valideKey(evt) {
  var code = evt.which ? evt.which : evt.keyCode;
  if (code == 8 || (code >= 48 && code <= 57) | (code == 13) || code == 46) {
    return true;
  }
  return false;
}

function OnlyNumbers001(event) {
  if (event.charCode >= 48 && event.charCode <= 57) {
    return true;
  } else {
    if (event.charCode == 13 || event.charCode == 46) {
      return true;
    } else {
      return false;
    }
  }
}

function OnlyPhoners(event) {
  if (event.charCode >= 48 && event.charCode <= 57) {
    return true;
  } else {
    return false;
  }
}

function lettersOnly(evt) {
  evt = evt ? evt : event;
  var charCode = evt.charCode
    ? evt.charCode
    : evt.keyCode
    ? evt.keyCode
    : evt.which
    ? evt.which
    : 0;

  if (
    (charCode > 32 && charCode < 65) ||
    (charCode > 90 && charCode < 97) ||
    charCode > 122
  ) {
    return false;
  } else {
    return true;
  }
}

const alertBootstrap = (
  title = "",
  message = "",
  type = "success",
  placeholder = "liveAlert",
  autohide = true,
  screen = 0,
  addbutton = 1,
) => {
  const alertPlaceholder = document.getElementById(placeholder);
  const wrapper = document.createElement("div");

  wrapper.innerHTML = [
    `<div class='d-flex justify-content-end'>`,
    `<div class="alert border border-3 border-${type} p-2 rounded-2 bg-light col-12 ${
      screen === 0 ? "col-xl-4" : screen === 1 ? "col-xl-12" : ""
    }" role="alert">`,
    `<div><strong><i class="fa ${
      type === "success"
        ? "fa-check-circle"
        : type === "warning"
        ? "fa-exclamation-triangle"
        : type === "danger"
        ? "fa fa-times-circle"
        : type === "info"
        ? "fa fa-info-circle"
        : ""
    } text-${type}"></i> ${title} </strong> ${
      addbutton === 1
        ? '<button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>'
        : ""
    }</div>`,
    `<div><small class="text-dark">${message}</small></div>`,
    "</div>",
    `</div>`,
  ].join("");
  $(wrapper).hide();

  alertPlaceholder.append(wrapper);
  $(wrapper).fadeIn(500);
  if (autohide) {
    setTimeout(() => {
      $(wrapper).fadeOut(500);
    }, 4000);
  }
};

function OcultarNotificacion2() {
  $("#alertaerrorenfactor").hide();
  $("#alertapendiente2").hide();
  $("#alertaCT").hide();
  $("#fracasosCT").hide();
  $("#exitoCT").hide();
  $("#exitoCostos").hide();
  $("#fracasosCostos").hide();
  $("#alertacostos").hide();
  $("#alertapendiente4").hide();
  $("#fracasosDDT").hide();
  $("#exitoDDT").hide();
  $("#alertapendiente").hide();
  $("#fracasoCuentas").hide();
  $("#exitoCuentas").hide();
  $("#alertacuentas").hide();
  $("#exitoConfiguracion").hide();
  $("#fracasoConfiguracion").hide();
  $("#exitoTerceros").hide();
  $("#fracasosTerceros").hide();
  $("#alertaterceros").hide();
  $("#validadanger").delay(100).fadeOut("slow");
  $("#validainfo").delay(100).fadeOut("slow");
  $("#validawarning").delay(100).fadeOut("slow");
  $("#validasuccess").delay(100).fadeOut("slow");
  $("#elfixed").delay(100).fadeOut("slow");
  $("#elfixed2").delay(100).fadeOut("slow");
  $("#maintop").delay(100).fadeOut("slow");
  $("#exito").delay(100).fadeOut("slow");
  $("#fracaso").delay(100).fadeOut("slow");
  $("#alertaerrorenproducto").delay(100).fadeOut("slow");
  $("#alertaerrorenproducto2").delay(100).fadeOut("slow");
  $("#alertaerrorenproducto3").delay(100).fadeOut("slow");
  $("#alertaerrorenproducto4").delay(100).fadeOut("slow");
  $("#alertaerrorenproducto5").delay(100).fadeOut("slow");
  $("#alertaerrorenproducto6").delay(100).fadeOut("slow");
  $("#alertaerrorenproducto7").delay(100).fadeOut("slow");
  $("#alertaerrorenproducto8").delay(100).fadeOut("slow");
  $("#alertaerrorenproducto9").delay(100).fadeOut("slow");
  $("#alertaerrorenproducto10").delay(100).fadeOut("slow");
  $("#ErrorBrutalTerminal").delay(100).fadeOut("slow");
  $("#errorsobrejson").delay(100).fadeOut("slow");
  $("#errorsobrejson2").delay(100).fadeOut("slow");
  $("#ERRORALM").delay(100).fadeOut("slow");
  $("#errorsobrejson3").delay(100).fadeOut("slow");
  $("#errorlogin2").delay(100).fadeOut("slow");
  $("#errorlogin3").delay(100).fadeOut("slow");
  $("#BeneError").delay(100).fadeOut("slow");
  $("#ProDERROR").delay(100).fadeOut("slow");
  $("#errorservicio").delay(100).fadeOut("slow");
  $("#ProDERROR2").delay(100).fadeOut("slow");
  $("#AlertaProbol").delay(100).fadeOut("slow");
  $("#errorlogin").delay(100).fadeOut("slow");
  $("#exitoEmpresas").hide();
  $("#loading").hide();
  $("#fracasoTerceros").hide();
  $("#fracaso").hide();
  $("#valida").hide();
}

function DevolverCaracteres(e) {
  tecla = document.all ? e.keyCode : e.which;
  if (
    tecla == 8 ||
    tecla == 32 ||
    tecla == 241 ||
    tecla == 209 ||
    tecla == 180 ||
    tecla == 225 ||
    tecla == 233 ||
    tecla == 237 ||
    tecla == 243 ||
    tecla == 250 ||
    tecla == 205 ||
    tecla == 193 ||
    tecla == 201 ||
    tecla == 211 ||
    tecla == 218
  ) {
    return true;
  }
  patron = /[A-Za-z0-9]/;
  tecla_final = String.fromCharCode(tecla);
  return patron.test(tecla_final);
}

function GenerarFecha(date = "date") {
  var fecha = new Date();
  if (date === "date") {
    var mes = fecha.getMonth() + 1;
    var dia = fecha.getDate();
    if (dia < 10) dia = "0" + dia;
    if (mes < 10) mes = "0" + mes;

    return fecha.getFullYear() + "-" + mes + "-" + dia;
  }

  if (date === "datetime") {
    var mes = fecha.getMonth() + 1;
    var dia = fecha.getDate();
    var hora = fecha.getHours();
    var min = fecha.getMinutes();
    var seg = fecha.getSeconds();
    if (dia < 10) dia = "0" + dia;
    if (mes < 10) mes = "0" + mes;
    if (hora < 10) hora = "0" + hora;
    if (seg < 10) seg = "0" + seg;

    return (
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
    );
  }

  if (date === "datetimeinput") {
    var mes = fecha.getMonth() + 1;
    var dia = fecha.getDate();
    var hora = fecha.getHours();
    var min = fecha.getMinutes();
    var seg = fecha.getSeconds();
    if (dia < 10) dia = "0" + dia;
    if (mes < 10) mes = "0" + mes;
    if (hora < 10) hora = "0" + hora;
    if (min < 10) min = "0" + min;
    if (seg < 10) seg = "0" + seg;

    return (
      fecha.getFullYear() +
      "-" +
      mes +
      "-" +
      dia +
      "T" +
      hora +
      ":" +
      min +
      ":" +
      seg
    );
  }
}

function EnviarCorreoCod() {
  $("#Div001").hide();
  $("#Div002").show();
  // re = /^([\da-z_\.-]+)@([\da-z\.-]+)\.([a-z\.]{1,6})$/;
  // if (!re.exec(document.getElementById("InsertarCorreo").value)) {
  //   $("#Div002").hide();
  //   $("#Div003").show();
  //   setTimeout(() => $("#Div003").hide(), 3000);
  //   setTimeout(() => $("#Div001").show(), 3100);
  //   setTimeout(() => document.getElementById("InsertarCorreo").select(), 3300);
  //   return false;
  // }
  $.ajax({
    type: "POST",
    url: "generalseek.php",
    data: {
      Accion: "5",
      CorreoEnviar: document.getElementById("InsertarCorreo").value,
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      Idtipotx: document.getElementById("Idtipotx").value,
      IdEstacion: document.getElementById("IdEstacion").value,
    },
  }).done(function (msg) {
    if (msg == 1) {
      $("#Div002").hide();
      $("#Div005").show();
      setTimeout(() => $("#Div005").hide(), 3000);
      setTimeout(() => $("#Div001").show(), 3100);
      document.getElementById("boton8").focus();
      return true;
    }
    $("#Div002").hide();
    $("#Div004").show();
    setTimeout(() => $("#Div004").hide(), 3000);
    setTimeout(() => $("#Div001").show(), 3100);
    setTimeout(() => document.getElementById("InsertarCorreo").select(), 3300);
    return false;
  });
}

function EnviarCorreoCod2() {
  $("#Div001").hide();
  $("#Div002").show();
  // re = /^([\da-z_\.-]+)@([\da-z\.-]+)\.([a-z\.]{1,6})$/;
  // if (!re.exec(document.getElementById("InsertarCorreo").value)) {
  //   $("#Div002").hide();
  //   $("#Div003").show();
  //   setTimeout(() => $("#Div003").hide(), 3000);
  //   setTimeout(() => $("#Div001").show(), 3100);
  //   setTimeout(() => document.getElementById("InsertarCorreo").select(), 3300);
  //   return false;
  // }

  $.ajax({
    type: "POST",
    url: "generalseek.php",
    data: {
      Accion: "6",
      CorreoEnviar: document.getElementById("InsertarCorreo").value,
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      Idtipotx: document.getElementById("IdtipotxAct").innerHTML,
      IdEstacion: document.getElementById("IdEstacionAct").innerHTML,
      Idtx: document.getElementById("IdtxAct").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 1) {
      $("#Div002").hide();
      $("#Div005").show();
      setTimeout(() => $("#Div005").hide(), 3000);
      setTimeout(() => $("#Div001").show(), 3100);
      document.getElementById("boton8").focus();
      return true;
    }
    $("#Div002").hide();
    $("#Div004").show();
    setTimeout(() => $("#Div004").hide(), 3000);
    setTimeout(() => $("#Div001").show(), 3100);
    setTimeout(() => document.getElementById("InsertarCorreo").select(), 3300);
    return false;
  });
}

function Actualizar() {
  if (document.getElementById("part2").innerHTML !== "") {
    var part2 = document.getElementById("part2").innerHTML;
  } else {
    var part2 = 0;
  }
  $.ajax({
    type: "POST",
    url: "tablacontabilidadseek.php",
    data: {
      Accion: "8",
      CTBPeriodo: document.getElementById("CTBPeriodo").innerHTML,
      CTBIdEmpresa: document.getElementById("CTBIdEmpresa").innerHTML,
      CTBOrigen: document.getElementById("CTBOrigen").innerHTML,
      CompanyActual: document.getElementById("CTBIdCompany").innerHTML,
      part2: part2,
    },
  }).done(function (msg) {
    $("#Temporal03").html(msg);
    if (document.getElementById("idcentroEnvio").innerHTML !== "") {
      $("#porsia").removeClass("quitar");
      $("#porsia2").removeClass("quitar");
    } else {
      $("#porsia").addClass("quitar");
      $("#porsia2").addClass("quitar");
    }
  });
}

function Formato(number, decimals, dec_point, thousands_sep) {
  number = (number + "").replace(/[^0-9+\-Ee.]/g, "");
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = typeof thousands_sep === "undefined" ? "," : thousands_sep,
    dec = typeof dec_point === "undefined" ? "." : dec_point,
    s = "",
    toFixedFix = function (n, prec) {
      var k = Math.pow(10, prec);
      return "" + Math.round(n * k) / k;
    };
  s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || "").length < prec) {
    s[1] = s[1] || "";
    s[1] += new Array(prec - s[1].length + 1).join("0");
  }
  return s.join(dec);
}

function IniSSO() {
  var Tiempo = 7000000;
  setTimeout(() => SSO(), Tiempo);
  $.ajax({
    type: "POST",
    url: "generalseek.php",
    data: { Accion: "0", Ini: "0" },
  }).done(function (msg) {
    $("#TemporalGneral").html(msg);
    document.getElementById("resultgeneral001").innerHTML =
      document.getElementById("NumG002").innerHTML;
    document.getElementById("resultgeneral005").innerHTML =
      document.getElementById("NumG003").innerHTML;
    document.getElementById("resultgeneral002").innerHTML =
      document.getElementById("NumG004").innerHTML;
    document.getElementById("resultgeneral003").innerHTML =
      document.getElementById("NumG005").innerHTML;
    document.getElementById("resultgeneral004").innerHTML =
      document.getElementById("NumG006").innerHTML;
    document.getElementById("resultgeneral007").innerHTML =
      document.getElementById("NumG007").innerHTML;
    $("#TemporalGneral").html("");
  });
}

function eliminaridioma(base, n) {
  $("#botoneliminar" + n).prop("disabled", true);
  $.ajax({
    type: "POST",
    url: "generalseek.php",
    data: { Accion: "3", Opcion: "5", Ini: "1", BaseInputIdi: base },
  }).done(function (msg) {
    if (msg == 1) {
      $("#maintop").show();
      $("#exito").delay(100).fadeIn("slow");
      setTimeout(() => OcultarNotificacion2(), 5000);
      CargarDataLang();
      $("#modal-idijsonnw").modal("hide");
      $("#modal-idijson").modal("show");
    } else {
      $("#maintop").show();
      $("#fracaso").delay(100).fadeIn("slow");
      setTimeout(() => OcultarNotificacion2(), 5000);
    }
  });
}

var cronometro;

function SSO() {
  if (document.getElementById("validadorreload").innerHTML == 0) {
    $("#modal-BadEnding").modal("show");
    var minutoxx = 1;
    var segundoxx = 1;
    cronometro = window.setInterval(function () {
      if (segundoxx == 0 && minutoxx == 0) {
        SSOClose();
      } else {
        if (segundoxx == 0 && minutoxx > 0) {
          segundoxx = 60;
          minutoxx = minutoxx - 1;
        }
        segundoxx = segundoxx - 1;
        if (segundoxx > 9) {
          document.getElementById("resultgeneral006").innerHTML =
            minutoxx + ":" + segundoxx;
        } else {
          document.getElementById("resultgeneral006").innerHTML =
            minutoxx + ":0" + segundoxx;
        }
      }
    }, 1000);
  } else {
    $.ajax({
      type: "POST",
      url: "generalseek.php",
      data: { Accion: "2-2" },
    }).done(function (msg) {
      clearInterval(cronometro);
      IniSSO();
    });
  }
}

function ReloadSSO() {
  clearInterval(cronometro);
  $("#modal-BadEnding").modal("hide");
  IniSSO();
  ReloadSSO2();
}

function ReloadSSO2() {
  $.ajax({
    type: "POST",
    url: "/datahandlers/datahandlerlogin.php",
    data: {
      dirigido: "reload-session",
      login: document.getElementById("userlogin").innerHTML,
      Company: document.getElementById("CompanyActual").innerHTML,
      userperfil: document.getElementById("userperfil").innerHTML,
      tokenestacion: document.getElementById("TokenEstacion").innerHTML,
      lenguaje: document.getElementById("IdiomaActual").innerHTML,
    },
  }).done(function (msg) {});
}

function SSOClose() {
  clearInterval(cronometro);
  $("#modal-BadEnding").modal("hide");
  $.ajax({
    type: "POST",
    url: "generalseek.php",
    data: { Accion: "2" },
  }).done(function (msg) {
    $.ajax({
      type: "POST",
      url: "generalseek.php",
      data: { Accion: "0", Ini: "0" },
    }).done(function (msg2) {
      $("#TemporalGneral").html(msg2);
      document.getElementById("validadanger").innerHTML =
        document.getElementById("NumG001").innerHTML;
      $("#elfixed2").show();
      $("#validadanger").delay(100).fadeIn("slow");
      setTimeout(() => location.reload(), 2000);
      $("#TemporalGneral").html("");
    });
  });
}

function ActualizarJLang(n) {
  $("#botonactualizar01").prop("disabled", true);
  $("#botonactualizar02").prop("disabled", true);
  $("#botonactualizar03").prop("disabled", true);
  if (n == 4) {
    $.ajax({
      type: "POST",
      url: "generalseek.php",
      data: { Accion: "3", Opcion: "2" },
    }).done(function (msg) {
      if (msg == 1) {
      } else {
        $("#botonactualizar02").prop("disabled", false);
      }
      $("#botonactualizar01").prop("disabled", false);
      $("#botonactualizar03").prop("disabled", false);
    });
    CargarDataLang();
  } else {
    if (n == 0) {
      var nameles01 = "NumG008";
      var nameles02 = "NumG009";
    }
    if (n == 1) {
      var nameles01 = "NumG010";
      var nameles02 = "NumG011";
    }
    $.ajax({
      type: "POST",
      url: "generalseek.php",
      data: { Accion: "0", Ini: "0" },
    }).done(function (msg2) {
      $.ajax({
        type: "POST",
        url: "generalseek.php",
        data: { Accion: "3", Opcion: n },
      }).done(function (msg) {
        $("#TemporalGneral").html(msg2);
        if (msg == 1) {
          $("#maintop").show();
          $("#exito").delay(100).fadeIn("slow");
          setTimeout(() => OcultarNotificacion2(), 5000);
        } else {
          $("#maintop").show();
          $("#fracaso").delay(100).fadeIn("slow");
          setTimeout(() => OcultarNotificacion2(), 5000);
        }
        $.ajax({
          type: "POST",
          url: "generalseek.php",
          data: { Accion: "3", Opcion: "2" },
        }).done(function (msg) {
          if (msg == 1) {
          } else {
            $("#botonactualizar02").prop("disabled", false);
          }
          $("#botonactualizar01").prop("disabled", false);
          $("#botonactualizar03").prop("disabled", false);
        });
        $("#TemporalGneral").html("");
      });
    });
  }
}

function Iniambiente() {
  $("#botonactualizar01").prop("disabled", true);
  $("#botonactualizar02").prop("disabled", true);
  $("#botonactualizar03").prop("disabled", true);
  $.ajax({
    type: "POST",
    url: "generalseek.php",
    data: { Accion: "0", Ini: "0" },
  }).done(function (msg2) {
    $("#TemporalGneral").html(msg2);
    document.getElementById("resultidiom001").innerHTML =
      document.getElementById("NumG012").innerHTML;
    document.getElementById("resultidiom003").innerHTML =
      document.getElementById("NumG012").innerHTML;
    document.getElementById("resultidiom004").innerHTML =
      document.getElementById("NumG013").innerHTML;
    document.getElementById("resultidiom005").innerHTML =
      document.getElementById("NumG014").innerHTML;
    document.getElementById("resultidiom006").innerHTML =
      document.getElementById("NumG015").innerHTML;
    document.getElementById("resultidiom007").innerHTML =
      document.getElementById("NumG016").innerHTML;
    document.getElementById("resultidiom008").innerHTML =
      document.getElementById("NumG017").innerHTML;
    document.getElementById("resultidiom009").innerHTML =
      document.getElementById("NumG018").innerHTML;
    document.getElementById("resultidiom010").innerHTML =
      document.getElementById("NumG019").innerHTML;
    document.getElementById("resultidiom011").innerHTML =
      document.getElementById("NumG020").innerHTML;
    document.getElementById("resultidiom012").innerHTML =
      document.getElementById("NumG021").innerHTML;
    document.getElementById("resultidiom013").innerHTML =
      document.getElementById("NumG022").innerHTML;
    document.getElementById("resultidiom014").innerHTML =
      document.getElementById("NumG023").innerHTML;
    $.ajax({
      type: "POST",
      url: "generalseek.php",
      data: { Accion: "3", Opcion: "2" },
    }).done(function (msg) {
      if (msg == 1) {
      } else {
        $("#botonactualizar02").prop("disabled", false);
      }
      $("#botonactualizar01").prop("disabled", false);
      $("#botonactualizar03").prop("disabled", false);
    });
  });
}

function guardaridioma() {
  $.ajax({
    type: "POST",
    url: "generalseek.php",
    data: {
      Accion: "3",
      Opcion: "5",
      Ini: "0",
      BaseInputIdi: document.getElementById("BaseInputIdi").value,
      FRFRInputIdi: document.getElementById("FRFRInputIdi").value,
      DEDEInputIdi: document.getElementById("DEDEInputIdi").value,
      PTBRInputIdi: document.getElementById("PTBRInputIdi").value,
      ESUSInputIdi: document.getElementById("ESUSInputIdi").value,
      ENUSInputIdi: document.getElementById("ENUSInputIdi").value,
      ESHNInputIdi: document.getElementById("ESHNInputIdi").value,
      ESCLInputIdi: document.getElementById("ESCLInputIdi").value,
      ESVEInputIdi: document.getElementById("ESVEInputIdi").value,
    },
  }).done(function (msg) {
    if (msg == 1) {
      $("#maintop").show();
      $("#exito").delay(100).fadeIn("slow");
      setTimeout(() => OcultarNotificacion2(), 5000);
      CargarDataLang();
      $("#modal-idijsonnw").modal("hide");
      $("#modal-idijson").modal("show");
    } else {
      $("#maintop").show();
      $("#fracaso").delay(100).fadeIn("slow");
      setTimeout(() => OcultarNotificacion2(), 5000);
    }
  });
}

function CargarDataLang() {
  $("#resultidiom002").html("");
  $.ajax({
    type: "POST",
    url: "generalseek.php",
    data: { Accion: "3", Opcion: "2" },
  }).done(function (msg) {
    if (msg == 1) {
      var colum = [null, null, null, null, null, null, null, null, null];
      var searching = true;
    } else {
      var colum = [
        { orderable: false },
        { orderable: false },
        { orderable: false },
        { orderable: false },
        { orderable: false },
        { orderable: false },
        { orderable: false },
        { orderable: false },
        { orderable: false },
      ];
      var searching = false;
    }
    var language =
      "lang/datatables/" +
      document.getElementById("IdiomaActual").innerHTML +
      ".json";
    var colum = [null, null, null, null, null, null, null, null, null];
    var searching = true;
    $.ajax({
      type: "POST",
      url: "generalseek.php",
      data: {
        Accion: "3",
        Opcion: "4",
        Ini: "0",
        litfiscal: document.getElementById("litfiscal").innerHTML,
      },
    }).done(function (msg) {
      $("#resultidiom002").html(msg);
      $("#LanguageTable").DataTable({
        search: {
          search: $(
            `#${"LanguageTable"}_wrapper .dt-layout-row .dt-end .dt-search .dt-input`,
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
          url: "generalseek.php",
          data: {
            Accion: "3",
            Opcion: "4",
            Ini: "1",
            CompanyActual: document.getElementById("CompanyActual").innerHTML,
          },
        },
        columns: colum,
        searching: searching,
      });
      $("#modal-idijson").modal("show");
    });
  });
}

function editaridioma(Base, esve, escl, eshn, enus, esus, ptbr, dede, frfr) {
  $("#modal-idijson").modal("hide");
  $("#modal-idijsonnw").modal("show");
  document.getElementById("BaseInputIdi").value = Base;
  document.getElementById("ESVEInputIdi").value = esve;
  document.getElementById("ESCLInputIdi").value = escl;
  document.getElementById("ESHNInputIdi").value = eshn;
  document.getElementById("ENUSInputIdi").value = enus;
  document.getElementById("ESUSInputIdi").value = esus;
  document.getElementById("PTBRInputIdi").value = ptbr;
  document.getElementById("DEDEInputIdi").value = dede;
  document.getElementById("FRFRInputIdi").value = frfr;
}

function Impresion(IdEstacion, TipoTx, Tx, reload = "1", reimpresion = "") {
  var delay = 500;

  $.ajax({
    type: "POST",
    url: "generalseek.php",
    data: {
      Action: "form",
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      Idtipotx: TipoTx,
      IdEstacion: IdEstacion,
      Idtx: Tx !== "" ? Tx : null,
    },
  }).done(function (msg) {
    const array = JSON.parse(msg);
    if (array.status === false) {
      if (Tx !== "") {
        $.ajax({
          type: "POST",
          url: "facturatrasla2.php",
          data: {
            reimpresion: reimpresion,
            IdEstacion: IdEstacion,
            IdEstaciond: IdEstacion,
            Idtipotx: TipoTx,
            Idtipotxd: TipoTx,
            Idtx: Tx,
            Idtxd: Tx,
            NameCompany: document.getElementById("NameCompany").innerHTML,
            IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
            CompanyActual: document.getElementById("CompanyActual").innerHTML,
            userlogin: document.getElementById("userlogin").innerHTML,
            CD: document.getElementById("CD").innerHTML,
            SimDec: document.getElementById("SimDec").innerHTML,
            SimMil: document.getElementById("SimMil").innerHTML,
            MonedaP: document.getElementById("MonedaP").innerHTML,
            TemporalFactura:
              document.getElementById("TemporalFactura").innerHTML,
            IdAlmVta: document.getElementById("IdAlmVta").innerHTML,
          },
        }).done(function (msg) {
          //alert (msg);
          $("#prints").html(msg);
          if (msg !== "") {
            setTimeout(() => DAG(), delay);
          } else {
            $.ajax({
              type: "POST",
              url: "generalseek.php",
              data: { Accion: "0", Ini: "1" },
            }).done(function (msg) {
              $("#TemporalGneral").html(msg);
              document.getElementById("validawarning").innerHTML =
                document.getElementById("NumBaGeneral001").innerHTML;
              $("#elfixed2").show();
              $("#validawarning").delay(100).fadeIn("slow");
              setTimeout(() => OcultarNotificacion2(), 5000);
              $("#TemporalGneral").html("");
            });
          }
        });
      } else {
        $.ajax({
          type: "POST",
          url: "facturatrasla2.php",
          data: {
            CompanyActual: document.getElementById("CompanyActual").innerHTML,
            NameCompany: document.getElementById("NameCompany").innerHTML,
            IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
            userlogin: document.getElementById("userlogin").innerHTML,
            IdEstacion: IdEstacion,
            IdEstaciond: IdEstacion,
            Idtipotx: TipoTx,
            Idtipotxd: TipoTx,
            CD: document.getElementById("CD").innerHTML,
            SimDec: document.getElementById("SimDec").innerHTML,
            SimMil: document.getElementById("SimMil").innerHTML,
            MonedaP: document.getElementById("MonedaP").innerHTML,
            TemporalFactura:
              document.getElementById("TemporalFactura").innerHTML,
            IdAlmVta: document.getElementById("IdAlmVta").innerHTML,
          },
        }).done(function (msg) {
          $("#prints").html(msg);
          if (msg !== "") {
            if (reload == "1") {
              setTimeout(() => ImpAct(), delay);
            } else {
              setTimeout(() => DAG(), delay);
            }
          } else {
            $.ajax({
              type: "POST",
              url: "generalseek.php",
              data: { Accion: "0", Ini: "1" },
            }).done(function (msg) {
              $("#TemporalGneral").html(msg);
              document.getElementById("validawarning").innerHTML =
                document.getElementById("NumBaGeneral001").innerHTML;
              $("#elfixed2").show();
              $("#validawarning").delay(100).fadeIn("slow");
              setTimeout(() => OcultarNotificacion2(), 5000);
              $("#TemporalGneral").html("");
            });
          }
        });
      }
    } else {
      $("#modalPrint").modal("show");

      const html = array.response.map((key) => {
        return `
        <div class="col-12 p-0 m-0">
          <button class="btn btn-outline-primary p-1 m-1 col-12 " type="button" onclick="ImprimirFormato('${IdEstacion}', ${TipoTx}, ${Tx}, '${key}')" ><i class="fa fa-print"></i> ${
          key.split(".")[0]
        }</button>
        </div>
        `;
      });
      $("#ListFormatPrint").html(html);
    }
  });
}

function ImprimirFormato(IdEstacion, Idtipotx, Idtx, Format) {
  $.ajax({
    type: "POST",
    url: "generalseek.php",
    data: {
      Action: "ImprimirFormato",
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      IdEstacion: IdEstacion,
      Idtipotx: Idtipotx,
      Idtx: Idtx,
      Format: Format,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
    },
  }).done(function (msg) {
    $("#modalPrint").modal("hide");
    $("#prints").html(msg);
    setTimeout(() => DAG(), 500);
  });
}

function DAG() {
  window.print();
  document.getElementById("Titulodelapagina").innerHTML = "BlackbuckPOS";
}

function ImpAct() {
  window.print();
  document.getElementById("Titulodelapagina").innerHTML = "BlackbuckPOS";
}

function ImpresionElec(IdEstacion, Idtipotx, reload = true) {
  $.ajax({
    type: "POST",
    url: "facturatrasla3.php",
    data: {
      CompanyUserd: document.getElementById("CompanyActual").innerHTML,
      Idtipotx: Idtipotx,
      IdEstacion: IdEstacion,
      Fecha: document.getElementById("Fectxclient").value,
      User: document.getElementById("IdUser").value,
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
    },
  }).done(function (msg) {
    $("#prints").html(msg);
    if (msg !== "") {
      if (reload === true) {
        setTimeout(() => ImpAct(), 500);
      } else {
        setTimeout(() => DAG(), 500);
      }
    } else {
      $.ajax({
        type: "POST",
        url: "generalseek.php",
        data: { Accion: "0", Ini: "1" },
      }).done(function (msg) {
        $("#TemporalGneral").html(msg);
        document.getElementById("validawarning").innerHTML =
          document.getElementById("NumBaGeneral001").innerHTML;
        $("#elfixed2").show();
        $("#validawarning").delay(100).fadeIn("slow");
        setTimeout(() => OcultarNotificacion2(), 5000);
        $("#TemporalGneral").html("");
      });
    }
  });
}

function ImpresionElecxq(Fe, Dte, Idtipotxd, IdEstaciond) {
  $.ajax({
    type: "POST",
    url: "facturatrasla3.php",
    data: {
      FE: Fe,
      DTE: Dte,
      Idtipotx: Idtipotxd,
      IdEstacion: IdEstaciond,
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
    },
  }).done(function (msg) {
    $("#prints").html(msg);
    if (msg !== "") {
      setTimeout(() => DAG(), 500);
    } else {
      $.ajax({
        type: "POST",
        url: "generalseek.php",
        data: { Accion: "0", Ini: "1" },
      }).done(function (msg) {
        $("#TemporalGneral").html(msg);
        document.getElementById("validawarning").innerHTML =
          document.getElementById("NumBaGeneral001").innerHTML;
        $("#elfixed2").show();
        $("#validawarning").delay(100).fadeIn("slow");
        setTimeout(() => OcultarNotificacion2(), 5000);
        $("#TemporalGneral").html("");
      });
    }
  });
}

function TraerCostos(CodIdBasico, Paso, Opcion) {
  $.ajax({
    type: "POST",
    url: "generalseek.php",
    data: {
      Accion: "4",
      CodIdBasico: CodIdBasico,
      Paso: Paso,
      Opcion: Opcion,
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
    },
  }).done(function (msg) {
    $("#TemporalGneral").html(msg);
    $("#TemporalGneral").html("");
  });
}

function ImpresionOp3(
  IdEstacion,
  TipoTx,
  Tx,
  Usuario,
  Estacion,
  Fectxclient,
  IdBen,
  NombreBen,
  NoTX,
) {
  //Transacciones
  var IdEstacion = IdEstacion;
  var IdTx = Tx;
  var IdTipotx = TipoTx;
  var Usario = Usuario;
  var Estacion = Estacion;
  var Fechadd = Fectxclient;
  var IdBendd = IdBen;
  var NombreBendd = NombreBen;
  var NoTX = NoTX;
  $.ajax({
    type: "POST",
    url: "facturatrasla2.php",
    data: {
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      CompanyUserd: document.getElementById("CompanyActual").innerHTML,
      tipoimp: "barra",
      Idtipotxd: IdTipotx,
      Idtxd: IdTx,
      IdEstaciond: IdEstacion,
      Usuario: Usario,
      Estacion: Estacion,
      Tx: NoTX,
      Fechadd: Fechadd,
      IdBendd: IdBendd,
      NombreBendd: NombreBendd,
      Traslados: "Si",
    },
  }).done(function (msg) {
    $("#prints").html(msg);
    if (msg !== "") {
      setTimeout(function () {
        App.initHelper("print-page");
      }, 500);
    } else {
      $.ajax({
        type: "POST",
        url: "generalseek.php",
        data: { Accion: "0", Ini: "1" },
      }).done(function (msg) {
        $("#TemporalGneral").html(msg);
        document.getElementById("validawarning").innerHTML =
          document.getElementById("NumBaGeneral001").innerHTML;
        $("#elfixed2").show();
        $("#validawarning").delay(100).fadeIn("slow");
        setTimeout(() => OcultarNotificacion2(), 5000);
        $("#TemporalGneral").html("");
      });
    }
  });
}

function ImpresionOp4(Tx, TipoTx, Estacion, item) {
  //EstadoCB
  var valor1 = Estacion;
  var valor2 = Tx;
  var valor3 = TipoTx;
  var valor4 = item;
  if (valor4 > 1) {
    $.ajax({
      type: "POST",
      url: "formatodeimpresion.php",
      data: {
        CompanyActual: document.getElementById("CompanyActual").innerHTML,
        Item: valor4,
        Idtipotx: valor3,
        Idtx: valor2,
        IdEstacion: valor1,
        Moneda: "0",
      },
    }).done(function (msg) {
      $("#prints").html(msg);
      if (msg !== "") {
        setTimeout(() => DAG(), 500);
      } else {
        $.ajax({
          type: "POST",
          url: "generalseek.php",
          data: { Accion: "0", Ini: "1" },
        }).done(function (msg) {
          $("#TemporalGneral").html(msg);
          document.getElementById("validawarning").innerHTML =
            document.getElementById("NumBaGeneral006").innerHTML;
          $("#elfixed2").show();
          $("#validawarning").delay(100).fadeIn("slow");
          setTimeout(() => OcultarNotificacion2(), 5000);
          $("#TemporalGneral").html("");
        });
      }
    });
  } else {
    $.ajax({
      type: "POST",
      url: "Facturafdd.php",
      data: {
        CompanyActual: document.getElementById("CompanyActual").innerHTML,
        Idtipotxd: valor3,
        Idtxd: valor2,
        IdEstaciond: valor1,
      },
    }).done(function (msg) {
      $("#prints").html(msg);
      if (msg !== "") {
        setTimeout(() => DAG(), 500);
      } else {
        $.ajax({
          type: "POST",
          url: "generalseek.php",
          data: { Accion: "0", Ini: "1" },
        }).done(function (msg) {
          $("#TemporalGneral").html(msg);
          document.getElementById("validawarning").innerHTML =
            document.getElementById("NumBaGeneral001").innerHTML;
          $("#elfixed2").show();
          $("#validawarning").delay(100).fadeIn("slow");
          setTimeout(() => OcultarNotificacion2(), 5000);
          $("#TemporalGneral").html("");
        });
      }
    });
  }
}

function LetsStockMonth() {
  $("#Modal-DeCargandoProcess").modal("show");
  $.ajax({
    type: "POST",
    url: "generalseek.php",
    data: {
      Action: "LetsStockMonth",
      today: DateConvert(modificarMes(new Date(), -1))
        .slice(0, 7)
        .replace("-", ""),
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
    },
  }).done(function (msg) {
    const array = JSON.parse(msg);
    if (array.status === true) {
      console.log(1);
    } else {
      console.log(2);
    }
    $("#Modal-DeCargandoProcess").modal("hide");
  });
}
function codigoFinalizacionMF(code) {
  if (code == "0") {
    return {
      title: "Impresora Desconectada",
      desc: "Tiene que volver a reconectar la impresora para continuar",
    };
  }
  return {
    title: "",
    desc: "",
  };
}

async function VerificarFiscal(html, token) {
  await $.ajax({
    type: "POST",
    url: "generalseek.php",
    async: false,
    data: {
      Accion: "VerificarFiscal",
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      token: token,
    },
  }).done(function (msg) {
    const array = JSON.parse(msg);

    if (array.msg == 1) {
      return true;
    }

    alertBootstrap(
      "a",
      "b",
      "warning",
      html,

      true,
      1,
    );
    return false;
  });
}

function ImpresionOp5(Tx, TipoTx, Estacion, item) {
  $.ajax({
    type: "POST",
    url: "formatoisrl.php",
    data: {
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
      Item: item,
      Idtipotx: TipoTx,
      Idtx: Tx,
      IdEstacion: Estacion,
    },
  }).done(function (msg) {
    $("#prints").html(msg);
    if (msg !== "") {
      setTimeout(() => DAG(), 500);
    } else {
      $.ajax({
        type: "POST",
        url: "generalseek.php",
        data: { Accion: "0", Ini: "1" },
      }).done(function (msg) {
        $("#TemporalGneral").html(msg);
        document.getElementById("validawarning").innerHTML =
          document.getElementById("NumBaGeneral006").innerHTML;
        $("#elfixed2").show();
        $("#validawarning").delay(100).fadeIn("slow");
        setTimeout(() => OcultarNotificacion2(), 5000);
        $("#TemporalGneral").html("");
      });
    }
  });
}

function VerificarNworNot() {
  if (document.getElementById("ValNewCompany").innerHTML == "0") {
    $.ajax({
      type: "POST",
      url: "generalseek.php",
      data: {
        Accion: "7",
        CompanyActual: document.getElementById("CompanyActual").innerHTML,
      },
    }).done(function (msg) {
      if (msg == 1) {
        $.ajax({
          type: "POST",
          url: "generalseek.php",
          data: {
            Accion: "9",
            CompanyActual: document.getElementById("CompanyActual").innerHTML,
          },
        }).done(function (msg) {
          $("#OpcionResultado000").html(msg);
          document.getElementById("ModalIdcubicacion").value = "";
          document.getElementById("ModalNombrecubicacion").value = "";
          document.getElementById("ModalDescripcioncubicacion").value = "";

          document.getElementById("Modalampcubicacion").value = "0";
          document.getElementById("Modaltelfcubicacion").value = "";
          document.getElementById("Modalcorreocubicacion").value = "";
          document.getElementById("Modalidenfiscubicacion").value = "";

          document.getElementById("ModalLoginCUsuario").value = "";
          document.getElementById("ModalNombreCUsuario").value = "";
          document.getElementById("ModalCorreoCUsuario").value = "";
          $('#ModalNivelCUsuario > option[value = "1"]').attr(
            "selected",
            "selected",
          );
          document.getElementById("ModalPassCUsuario").value = "";
          document.getElementById("Modalvtapor2CUsuario").value = "0";
          document.getElementById("Modalcbrpor2CUsuario").value = "0";
          $("#cbox1CUsuario").prop("checked", true);
          $("#cbox2CUsuario").prop("checked", true);
          $("#cbox3CUsuario").prop("checked", true);
          $("#cbox4CUsuario").prop("checked", true);
          $("#cbox5CUsuario").prop("checked", true);
          $("#cbox6CUsuario").prop("checked", false);
          $("#AutorizaVarnCUsuario").prop("checked", false);
          document.getElementById("ModalSucursalCUsuario").value =
            document.getElementById("sucursal").innerHTML;

          document.getElementById("Resultadocproductoyservicio").innerHTML = "";
          document.getElementById("ModalIdAlmcalmacen").value = "";
          document.getElementById("ModalNombrecalmacen").value = "";
          document.getElementById("ModalTipocalmacen").value = "0";
          document.getElementById("ImpFaccalmacen").value = "0";
          document.getElementById("impBoletacalmacen").value = "0";
          document.getElementById("ImpGuiacalmacen").value = "0";
          document.getElementById("ImpNotaEntcalmacen").value = "0";
          document.getElementById("ImpMovInventariocalmacen").value = "0";
          document.getElementById("FormaFaccalmacen").value = "";
          document.getElementById("FormaBolcalmacen").value = "";
          document.getElementById("FormaGuiacalmacen").value = "";
          document.getElementById("FormaNotecalmacen").value = "";
          document.getElementById("FormaMovicalmacen").value = "";
          document.getElementById("FormPedidcalmacen").value = "";

          document.getElementById("ModalIdMarcmarca").value = "";
          document.getElementById("ModalNombrecmarca").value = "";

          document.getElementById("ModalIdcfamilia").value = "";
          document.getElementById("ModalItemcfamilia").value = "";
          $("#ordens").prop("checked", false);
          $("#ModalSerial").prop("checked", false);
          $("#ModalLote").prop("checked", false);
          $("#vnta").prop("checked", false);

          document.getElementById("ModalIdcimpuesto").value = "";
          document.getElementById("ModalItemcimpuesto").value = "";
          document.getElementById("ModalValorcimpuesto").value = "";

          document.getElementById("sugcodcproductoyservicio").innerHTML = "";
          document.getElementById("sp1cproductoyservicio").innerHTML = "";
          document.getElementById("sp2cproductoyservicio").innerHTML = "";
          document.getElementById("sp3cproductoyservicio").innerHTML = "";

          document.getElementById("spp1cproductoyservicio").innerHTML = "";
          document.getElementById("spp2cproductoyservicio").innerHTML = "";
          document.getElementById("spp3cproductoyservicio").innerHTML = "";

          document.getElementById("cantcimpcproductoyservicio").innerHTML = "";
          document.getElementById("cantcimpcproductoyservicio").innerHTML = "";

          document.getElementById("cantcimpcproductoyservicio2").innerHTML = "";
          document.getElementById("cantcimpcproductoyservicio2").innerHTML = "";

          var a = new Number(0);
          document.getElementById("Comisioncproductoyservicio").value = "0";
          document.getElementById("Comision2cproductoyservicio").value = "0";
          document.getElementById("Comision3cproductoyservicio").value = "0";

          document.getElementById("ModalImpuestoscproductoyservicio").value =
            "1";
          document.getElementById("abcdfghjqwetcproductoyservicio").innerHTML =
            "";
          document.getElementById("ModalCodIdBasicocproductoyservicio").value =
            "";
          document.getElementById(
            "ModalCodIdAmpliadocproductoyservicio",
          ).value = "";
          document.getElementById("ModalMedidascproductoyservicio").value = "";
          document.getElementById("ModalCodBarracproductoyservicio").value = "";
          document.getElementById("ModalDescripcioncproductoyservicio").value =
            "";
          document.getElementById("ModalMargen2cproductoyservicio").value =
            a.toFixed(2);
          document.getElementById("ModalPrecioVenta2cproductoyservicio").value =
            a.toFixed(document.getElementById("CD").innerHTML);
          document.getElementById("ModalPrecioNeto2cproductoyservicio").value =
            a.toFixed(document.getElementById("CD").innerHTML);
          document.getElementById("ModalMargen3cproductoyservicio").value =
            a.toFixed(2);
          document.getElementById("ModalPrecioVenta3cproductoyservicio").value =
            a.toFixed(document.getElementById("CD").innerHTML);
          document.getElementById("ModalPrecioNeto3cproductoyservicio").value =
            a.toFixed(document.getElementById("CD").innerHTML);
          document.getElementById("ModalCostoscproductoyservicio").value =
            a.toFixed(document.getElementById("CD").innerHTML);
          document.getElementById("ModalMargencproductoyservicio").value =
            a.toFixed(2);
          document.getElementById("ModalCostoNetocproductoyservicio").value =
            a.toFixed(document.getElementById("CD").innerHTML);
          document.getElementById("ModalPrecioNetocproductoyservicio").value =
            a.toFixed(document.getElementById("CD").innerHTML);
          document.getElementById("ModalPrecioVentacproductoyservicio").value =
            a.toFixed(document.getElementById("CD").innerHTML);
          document.getElementById("ModalEnvasecproductoyservicio").value = "";
          document.getElementById("ModalMincproductoyservicio").value = 0;
          document.getElementById("ModalMaxcproductoyservicio").value = 0;

          document.getElementById("ModalMedida2cproductoyservicio").value = "";
          document.getElementById("ModalCant2cproductoyservicio").value = "1";
          document.getElementById("ModalMedida3cproductoyservicio").value = "";
          document.getElementById("ModalCant3cproductoyservicio").value = "1";

          $("#ModalPorKilocproductoyservicio").prop("checked", false);
          $("#ModalEstadocproductoyservicio").prop("checked", true);
          IniPosUpCom();
          $("#modal-companynew").modal("show");
        });
      }
    });
  }
}

function NoVerificarNuncamas() {
  $.ajax({
    type: "POST",
    url: "generalseek.php",
    data: {
      Accion: "8",
      CompanyActual: document.getElementById("CompanyActual").innerHTML,
    },
  }).done(function (msg) {});
}

Offline.options = {
  checkOnLoad: false,
};

Offline.on("up", function () {
  window.location.reload();
  $("#modal-offline").modal("hide");
});

Offline.on("down", function () {
  window.location.reload();
  $("#modal-offline").modal("show");
});

function buscarif() {
  //verifico que tenga una forma similar al rif
  var regEsRif = new RegExp("^([VEJPG]{1})([0-9]{9})$");
  if (regEsRif.test($("#RutFa").val())) {
    consultarif($("#RutFa").val());
  } else {
    //si no lo es verifico si se parece a una cedula
    var regEsCedula = new RegExp("^([0-9]{8})$");
    if (regEsCedula.test($("#RutFa").val())) {
      var documento = $("#RutFa").val();
      //Se obtiene el digito verificador para hacer una búsqueda de un rif que comience por V
      var stDigito = digitoVerificador(documento, "V");
      consultarif("V" + documento + stDigito);
    } else console.log("Verifique el Rif Suministrado");
  }
}

function consultarif(rif) {
  var data = {};
  data.rif = rif;
  //se usa corsproxy para que salte la restriccion de dominios cruzados
  $.get(
    "https://declaraciones.seniat.gob.ve/getContribuyente/getrif",
    data,
    function (xml) {
      var datosrif = $.xml2json(xml);
      console.log(datosrif);
      // var stDatos = "<div><strong>Rif:</strong>" + rif + "</div>";
      // stDatos += "<div><strong>Nombre:</strong>" + datosrif.Nombre + "</div>";
      // stDatos +=
      //   "<div><strong>Agente de Retencion:</strong>" +
      //   datosrif.AgenteRetencionIVA +
      //   "</div>";
      // stDatos +=
      //   "<div><strong>Tasa de Retencion:</strong>" + datosrif.Tasa + "</div>";
      // stDatos +=
      //   "<div><strong>Contribuyente Ordinario de IVA:</strong>" +
      //   datosrif.ContribuyenteIVA +
      //   "</div>";
      // $("#datos").html(stDatos);
    },
  )
    .fail(function () {
      console.log("Error en el Rif Buscado");
    })
    .load(function () {
      // $("#datos").html("<h1>Buscando</h1>");
    });
}

function digitoVerificador(documento, caracter) {
  var arrnumeros = [];
  var digitoEspecial;
  var resultado;
  arrnumeros[7] = parseInt(documento[7]) * 2;
  arrnumeros[6] = parseInt(documento[6]) * 3;
  arrnumeros[5] = parseInt(documento[5]) * 4;
  arrnumeros[4] = parseInt(documento[4]) * 5;
  arrnumeros[3] = parseInt(documento[3]) * 6;
  arrnumeros[2] = parseInt(documento[2]) * 7;
  arrnumeros[1] = parseInt(documento[1]) * 2;
  arrnumeros[0] = parseInt(documento[0]) * 3;
  var suma = 0;
  for (var i = 0; i < arrnumeros.length; i++) {
    suma += arrnumeros[i];
  }
  if (caracter == "V") {
    digitoEspecial = 1;
    suma += 4;
  }
  resultado = 11 - (suma % 11);
  return resultado;
}
