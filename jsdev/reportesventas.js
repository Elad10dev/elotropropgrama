function changeinput(
  multiple = "0",
  user = "",
  almacen = "",
  estacion = "",
  familia = "",
  ubicacion = "",
  vendedor = "",
) {
  if (user != "") {
    $.ajax({
      type: "POST",
      url: "utilidadess.php",
      data: {
        Accion: "input-user",
        IdInput: user,
        multiple: multiple,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
        NameCompany: document.getElementById("NameCompany").innerHTML,
        PerfilVentas: document.getElementById("PerfilVentas").innerHTML,
        login: document.getElementById("userlogin").innerHTML,
        sucursal: document.getElementById("sucursal").innerHTML,
        userperfil: document.getElementById("userperfil").innerHTML,
        CompanyActual: document.getElementById("CompanyActual").innerHTML,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
      },
    }).done(function (msg) {
      $("#userinput").html(msg);
    });
  }

  if (almacen != "") {
    $.ajax({
      type: "POST",
      url: "utilidadess.php",
      data: {
        Accion: "input-almacen",
        IdInput: almacen,
        multiple: multiple,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
        NameCompany: document.getElementById("NameCompany").innerHTML,
        PerfilVentas: document.getElementById("PerfilVentas").innerHTML,
        login: document.getElementById("userlogin").innerHTML,
        sucursal: document.getElementById("sucursal").innerHTML,
        userperfil: document.getElementById("userperfil").innerHTML,
        CompanyActual: document.getElementById("CompanyActual").innerHTML,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
      },
    }).done(function (msg) {
      $("#almaceninput").html(msg);
    });
  }

  if (familia != "") {
    $.ajax({
      type: "POST",
      url: "utilidadess.php",
      data: {
        Accion: "input-familia",
        IdInput: familia,
        multiple: multiple,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
        NameCompany: document.getElementById("NameCompany").innerHTML,
        PerfilVentas: document.getElementById("PerfilVentas").innerHTML,
        login: document.getElementById("userlogin").innerHTML,
        sucursal: document.getElementById("sucursal").innerHTML,
        userperfil: document.getElementById("userperfil").innerHTML,
        CompanyActual: document.getElementById("CompanyActual").innerHTML,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
      },
    }).done(function (msg) {
      $("#familiainput").html(msg);
    });
  }

  if (estacion != "") {
    $.ajax({
      type: "POST",
      url: "utilidadess.php",
      data: {
        Accion: "input-estacion",
        IdInput: estacion,
        multiple: multiple,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
        NameCompany: document.getElementById("NameCompany").innerHTML,
        PerfilVentas: document.getElementById("PerfilVentas").innerHTML,
        login: document.getElementById("userlogin").innerHTML,
        sucursal: document.getElementById("sucursal").innerHTML,
        userperfil: document.getElementById("userperfil").innerHTML,
        CompanyActual: document.getElementById("CompanyActual").innerHTML,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
      },
    }).done(function (msg) {
      $("#estacioninput").html(msg);
    });
  }

  if (ubicacion != "") {
    $.ajax({
      type: "POST",
      url: "utilidadess.php",
      data: {
        Accion: "input-ubicacion",
        IdInput: ubicacion,
        multiple: multiple,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
        NameCompany: document.getElementById("NameCompany").innerHTML,
        PerfilVentas: document.getElementById("PerfilVentas").innerHTML,
        login: document.getElementById("userlogin").innerHTML,
        sucursal: document.getElementById("sucursal").innerHTML,
        userperfil: document.getElementById("userperfil").innerHTML,
        CompanyActual: document.getElementById("CompanyActual").innerHTML,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
      },
    }).done(function (msg) {
      $("#ubicacioninput").html(msg);
    });
  }

  if (vendedor != "") {
    $.ajax({
      type: "POST",
      url: "utilidadess.php",
      data: {
        Accion: "input-vendedor",
        IdInput: ubicacion,
        multiple: multiple,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
        NameCompany: document.getElementById("NameCompany").innerHTML,
        PerfilVentas: document.getElementById("PerfilVentas").innerHTML,
        login: document.getElementById("userlogin").innerHTML,
        sucursal: document.getElementById("sucursal").innerHTML,
        userperfil: document.getElementById("userperfil").innerHTML,
        CompanyActual: document.getElementById("CompanyActual").innerHTML,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
      },
    }).done(function (msg) {
      $("#vendedorinput").html(msg);
    });
  }
}

function selectidcomp(n) {
  if (n.indexOf(",") == "-1") {
    $(".nfilt").removeClass("d-none");
    $(".filt").val("");
  } else {
    $(".nfilt").addClass("d-none");
    $(".filt").val("");
  }
}

function HabilitarBotones() {
  n = 0;
  while (n < 30) {
    if (n < 10) {
      var button = "button00" + n;
    } else {
      var button = "button0" + n;
    }
    n++;
    $("#" + button).prop("disabled", false);
  }
}

function venta(n) {
  if (n < 10) {
    var button = "button00" + n;
  } else {
    var button = "button0" + n;
  }
  $("#" + button).prop("disabled", true);
  $.ajax({
    type: "POST",
    url: "appsmodalventas.php",
    data: {
      Accion: "p" + n,
      login: document.getElementById("userlogin").innerHTML,
      sucursal: document.getElementById("sucursal").innerHTML,
      userperfil: document.getElementById("userperfil").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
      Company: document.getElementById("CompanyActual").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      LitEfectivo: document.getElementById("LitEfectivo").innerHTML,
      LitCheque: document.getElementById("LitCheque").innerHTML,
      LitO01: document.getElementById("LitO01").innerHTML,
      LitO02: document.getElementById("LitO02").innerHTML,
      LitO03: document.getElementById("LitO03").innerHTML,
      LitO04: document.getElementById("LitO04").innerHTML,
      NumTxViewVTA: document.getElementById("NumTxViewVTA").innerHTML,
      NumTxViewCOM: document.getElementById("NumTxViewCOM").innerHTML,
      NumTxViewINV: document.getElementById("NumTxViewINV").innerHTML,
      LitTarjeta: document.getElementById("LitTarjeta").innerHTML,
      userperfil: document.getElementById("userperfil").innerHTML,
      IdPais: document.getElementById("IdPaisAct").innerHTML,
    },
  }).done(function (msg) {
    $("#prueba1").html(msg);
    $("#apps-modalz").modal("show");
    $("#" + button).prop("disabled", false);
  });
}

function Seriales22(n) {
  if (n == 1) {
    var colum = [null, null, null, { orderable: false }];
  }

  var language =
    "lang/datatables/" +
    document.getElementById("IdiomaActual").innerHTML +
    ".json";
  $.ajax({
    type: "POST",
    url: "reportesventasseek.php",
    data: {
      Accion: "0",
      Ini: "0",
      sucursal: document.getElementById("sucursal").innerHTML,
      Opcion: n,
    },
  }).done(function (msg) {
    $("#Temporal").html(msg);
    document.getElementById("appsmodal1y22name").innerHTML =
      document.getElementById("Num001").innerHTML;
    document.getElementById("ProductoTableRep").innerHTML =
      document.getElementById("Num002").innerHTML;
    $("#Temporal").html("");
    $("#ProductoTableRepDT").DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      language: {
        url: language,
      },
      ajax: {
        type: "POST",
        url: "reportesventasseek.php",
        data: {
          Accion: "0",
          Ini: "1",
          Opcion: n,
          sucursal: document.getElementById("sucursal").innerHTML,
          CIdPlan: document.getElementById("CIdPlan").innerHTML,
          IdCompanySelect: document.getElementById("IdCompanySelect").value,
          IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
          CompanyActual: document.getElementById("CompanyActual").innerHTML,
          userperfil: document.getElementById("userperfil").innerHTML,
        },
      },
      columns: colum,
      destroy: true,
    });
    $("#apps-modalz").modal("hide");
    $("#apps-modal1y22").modal("show");
  });
}

function ClienteModal(n) {
  if (n == 1) {
    var colum = [null, null, null, { orderable: false }];
  }
  if (n == 2) {
    var colum = [null, null, { orderable: false }];
  }

  var language =
    "lang/datatables/" +
    document.getElementById("IdiomaActual").innerHTML +
    ".json";
  $.ajax({
    type: "POST",
    url: "reportesventasseek.php",
    data: {
      Accion: "1",
      Ini: "0",
      sucursal: document.getElementById("sucursal").innerHTML,
      Opcion: n,
    },
  }).done(function (msg) {
    $("#Temporal").html(msg);
    document.getElementById("appsmodal4y2name").innerHTML =
      document.getElementById("Num001").innerHTML;
    document.getElementById("CierredecajaTablaRep").innerHTML =
      document.getElementById("Num002").innerHTML;
    $("#Temporal").html("");
    $("#CierredecajaTablaRepDT").DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      language: {
        url: language,
      },
      ajax: {
        type: "POST",
        url: "reportesventasseek.php",
        data: {
          Accion: "1",
          Ini: "1",
          Opcion: n,
          sucursal: document.getElementById("sucursal").innerHTML,
          CIdPlan: document.getElementById("CIdPlan").innerHTML,
          IdCompanySelect: document.getElementById("IdCompanySelect").value,
          IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
          CompanyActual: document.getElementById("CompanyActual").innerHTML,
          userperfil: document.getElementById("userperfil").innerHTML,
        },
      },
      columns: colum,
      destroy: true,
    });
    $("#apps-modalz").modal("hide");
    $("#apps-modal4y2").modal("show");
  });
}

function otrocoso(n) {
  if (n == 1) {
    var colum = [null, null, null, { orderable: false }];
  }
  var language =
    "lang/datatables/" +
    document.getElementById("IdiomaActual").innerHTML +
    ".json";
  $.ajax({
    type: "POST",
    url: "reportesventasseek.php",
    data: {
      Accion: "2",
      Ini: "0",
      sucursal: document.getElementById("sucursal").innerHTML,
      Opcion: n,
    },
  }).done(function (msg) {
    $("#Temporal").html(msg);
    document.getElementById("appsmodal1y22xname").innerHTML =
      document.getElementById("Num001").innerHTML;
    document.getElementById("ListadodeCuentasporCobrarTableRep").innerHTML =
      document.getElementById("Num002").innerHTML;
    $("#Temporal").html("");
    $("#ListadodeCuentasporCobrarTableRepDT").DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      language: {
        url: language,
      },
      ajax: {
        type: "POST",
        url: "reportesventasseek.php",
        data: {
          Accion: "2",
          Ini: "1",
          Opcion: n,
          sucursal: document.getElementById("sucursal").innerHTML,
          CIdPlan: document.getElementById("CIdPlan").innerHTML,
          IdCompanySelect: document.getElementById("IdCompanySelect").value,
          IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
          CompanyActual: document.getElementById("CompanyActual").innerHTML,
          userperfil: document.getElementById("userperfil").innerHTML,
        },
      },
      columns: colum,
      destroy: true,
    });
    $("#apps-modalz").modal("hide");
    $("#apps-modal1y22x").modal("show");
  });
}

function otrocosoa(n) {
  if (n == 1) {
    var colum = [null, null, { orderable: false }];
  }
  if (n == 2) {
    var colum = [null, null, { orderable: false }];
  }
  if (n == 3) {
    var colum = [null, null, { orderable: false }];
  }
  var language =
    "lang/datatables/" +
    document.getElementById("IdiomaActual").innerHTML +
    ".json";
  $.ajax({
    type: "POST",
    url: "reportesventasseek.php",
    data: {
      Accion: "3",
      Ini: "0",
      sucursal: document.getElementById("sucursal").innerHTML,
      Opcion: n,
    },
  }).done(function (msg) {
    $("#Temporal").html(msg);
    document.getElementById("appsmodal1y22xxname").innerHTML =
      document.getElementById("Num001").innerHTML;
    document.getElementById("ProdddCuntCobrarTablaRep").innerHTML =
      document.getElementById("Num002").innerHTML;
    $("#Temporal").html("");
    $("#ProdddCuntCobrarTablaRepDT").DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      language: {
        url: language,
      },
      ajax: {
        type: "POST",
        url: "reportesventasseek.php",
        data: {
          Accion: "3",
          Ini: "1",
          Opcion: n,
          sucursal: document.getElementById("sucursal").innerHTML,
          CIdPlan: document.getElementById("CIdPlan").innerHTML,
          IdCompanySelect: document.getElementById("IdCompanySelect").value,
          IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
          CompanyActual: document.getElementById("CompanyActual").innerHTML,
          userperfil: document.getElementById("userperfil").innerHTML,
        },
      },
      columns: colum,
      destroy: true,
    });
    $("#apps-modalz").modal("hide");
    $("#apps-modal1y22xx").modal("show");
  });
}

function Usar(n, m, numero) {
  if (n == 1) {
    if (m == 1) {
      document.getElementById("BeneficiarioSE223").value =
        document.getElementById("rutc2" + numero).innerHTML;
      document.getElementById("BeneficiarioSE2223").value =
        document.getElementById("nombrec2" + numero).innerHTML;
      $("#apps-modal1y22").modal("hide");
      $("#apps-modalz").modal("show");
    }
  }
  if (n == 2) {
    if (m == 1) {
      document.getElementById("ClienteC").value = document.getElementById(
        "rutc" + numero,
      ).innerHTML;
      document.getElementById("ClienteC2").value = document.getElementById(
        "nombrec" + numero,
      ).innerHTML;
      $("#apps-modal4y2").modal("hide");
      $("#apps-modalz").modal("show");
    }
    if (m == 2) {
      document.getElementById("VendedorC").value = document.getElementById(
        "login" + numero,
      ).innerHTML;
      document.getElementById("VendedorC2").value = document.getElementById(
        "NombreLOGIN" + numero,
      ).innerHTML;
      $("#apps-modal4y2").modal("hide");
      $("#apps-modalz").modal("show");
    }
  }
  if (n == 3) {
    if (m == 1) {
      document.getElementById("Beneficiario").value = document.getElementById(
        "IdFiscal" + numero,
      ).innerHTML;
      document.getElementById("Beneficiario2").value = document.getElementById(
        "Nomb" + numero,
      ).innerHTML;
      $("#apps-modal1y22x").modal("hide");
      $("#apps-modalz").modal("show");
    }
  }
  if (n == 4) {
    if (m == 1) {
      document.getElementById("Producto").value = document.getElementById(
        "CodIdBas" + numero,
      ).innerHTML;
      document.getElementById("Producto2").value = document.getElementById(
        "Descrip" + numero,
      ).innerHTML;
      document.getElementById("Producto3").value = document.getElementById(
        "CodIdBas" + numero,
      ).innerHTML;
      //document.getElementById("Producto4").value = document.getElementById("Descrip"+numero).innerHTML;
      $("#apps-modal1y22xx").modal("hide");
      $("#apps-modalz").modal("show");
    }
    if (m == 2) {
      document.getElementById("Producto").value = document.getElementById(
        "CodIdBas" + numero,
      ).innerHTML;
      document.getElementById("Producto2").value = document.getElementById(
        "Descrip" + numero,
      ).innerHTML;
      document.getElementById("Producto3").value = document.getElementById(
        "CodIdBas" + numero,
      ).innerHTML;
      document.getElementById("Producto4").value = document.getElementById(
        "Descrip" + numero,
      ).innerHTML;
      $("#apps-modal1y22xx").modal("hide");
      $("#apps-modalz").modal("show");
    }
    if (m == 3) {
      document.getElementById("Producto3").value = document.getElementById(
        "CodIdBas" + numero,
      ).innerHTML;
      document.getElementById("Producto4").value = document.getElementById(
        "Descrip" + numero,
      ).innerHTML;
      $("#apps-modal1y22xx").modal("hide");
      $("#apps-modalz").modal("show");
    }
  }
}

function slect() {
  if ($("#impfis").is(":checked")) {
    $.ajax({
      type: "POST",
      url: "appsmodalventas.php",
      data: {
        Accion: "selectfis",
        sucursal: document.getElementById("sucursal").innerHTML,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        Company: document.getElementById("CompanyActual").innerHTML,
      },
    }).done(function (msg) {
      $("#selectfis").html(msg);
    });
  } else {
    $("#selectfis").html("");
  }
}

function submodals(n) {
  if (n == 1) {
    document.getElementById("Organizador").value = "1";
    document.getElementById("PagAct").innerHTML = "1";
    $("#apps-modalz2").modal("show");
    modals();
  }
  if (n == 2) {
    document.getElementById("Organizador").value = "2";
    document.getElementById("PagAct").innerHTML = "1";
    $("#apps-modalz2").modal("show");
    modals();
  }
  if (n == 3) {
    document.getElementById("Organizador").value = "3";
    document.getElementById("PagAct").innerHTML = "1";
    $("#apps-modalz2").modal("show");
    modals();
  }
  if (n == 4) {
    document.getElementById("Organizador").value = "4";
    document.getElementById("PagAct").innerHTML = "1";
    $("#apps-modalz2").modal("show");
    modals();
  }
  if (n == 5) {
    document.getElementById("Organizador").value = "5";
    document.getElementById("PagAct").innerHTML = "1";
    $("#apps-modalz2").modal("show");
    modals();
  }
  if (n == 6) {
    document.getElementById("Organizador").value = "6";
    document.getElementById("PagAct").innerHTML = "1";
    $("#apps-modalz2").modal("show");
    modals();
  }
  if (n == 7) {
    document.getElementById("Organizador").value = "7";
    document.getElementById("PagAct").innerHTML = "1";
    $("#apps-modalz2").modal("show");
    modals();
  }
  if (n == 8) {
    document.getElementById("Organizador").value = "8";
    document.getElementById("PagAct").innerHTML = "1";
    $("#apps-modalz2").modal("show");
    modals();
  }
  if (n == 9) {
    document.getElementById("Organizador").value = "9";
    document.getElementById("PagAct").innerHTML = "1";
    $("#apps-modalz2").modal("show");
    modals();
  }
  if (n == 10) {
    document.getElementById("Organizador").value = "10";
    document.getElementById("PagAct").innerHTML = "1";
    $("#apps-modalz2").modal("show");
    modals();
  }
}

function Pagineo(n) {
  document.getElementById("PagAct").innerHTML = n;
  $("#apps-modalz2").modal("show");
  modals();
}

function modals() {
  var valor = document.getElementById("PagAct").innerHTML;
  var valor2 = document.getElementById("Rpa").innerHTML;
  var valor3 = document.getElementById("search-prod").value;
  var valor4 = document.getElementById("Limit").value;
  if (document.getElementById("Organizador").value == "1") {
    $.ajax({
      type: "POST",
      url: "ViewVentas.php",
      data: {
        Accion: "a1",
        sucursal: document.getElementById("sucursal").innerHTML,
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        Search: valor3,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        Company: document.getElementById("CompanyActual").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobusca").html(msg);
    });
  }
  if (document.getElementById("Organizador").value == "2") {
    $.ajax({
      type: "POST",
      url: "ViewVentas.php",
      data: {
        Accion: "a2",
        sucursal: document.getElementById("sucursal").innerHTML,
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        Search: valor3,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        Company: document.getElementById("CompanyActual").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobusca").html(msg);
    });
  }

  if (document.getElementById("Organizador").value == "3") {
    $.ajax({
      type: "POST",
      url: "filtrossubmodals.php",
      data: {
        Accion: "a3",
        sucursal: document.getElementById("sucursal").innerHTML,
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        Search: valor3,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        Company: document.getElementById("CompanyActual").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobusca").html(msg);
    });
  }

  if (document.getElementById("Organizador").value == "4") {
    $.ajax({
      type: "POST",
      url: "filtrossubmodals.php",
      data: {
        Accion: "a3-4",
        sucursal: document.getElementById("sucursal").innerHTML,
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        Search: valor3,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        Company: document.getElementById("CompanyActual").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobusca").html(msg);
    });
  }

  if (document.getElementById("Organizador").value == "5") {
    $.ajax({
      type: "POST",
      url: "ViewVentas.php",
      data: {
        Accion: "a5",
        sucursal: document.getElementById("sucursal").innerHTML,
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        Search: valor3,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        Company: document.getElementById("CompanyActual").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobusca").html(msg);
    });
  }

  if (document.getElementById("Organizador").value == "6") {
    $.ajax({
      type: "POST",
      url: "ViewVentas.php",
      data: {
        Accion: "a6",
        sucursal: document.getElementById("sucursal").innerHTML,
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        Search: valor3,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        Company: document.getElementById("CompanyActual").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobusca").html(msg);
    });
  }

  if (document.getElementById("Organizador").value == "7") {
    $.ajax({
      type: "POST",
      url: "ViewVentas.php",
      data: {
        Accion: "a7",
        sucursal: document.getElementById("sucursal").innerHTML,
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        Search: valor3,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        Company: document.getElementById("CompanyActual").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobusca").html(msg);
      $("#apps-modalz2").modal("show");
    });
  }

  if (document.getElementById("Organizador").value == "8") {
    $.ajax({
      type: "POST",
      url: "ViewVentas.php",
      data: {
        Accion: "a8",
        sucursal: document.getElementById("sucursal").innerHTML,
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        Search: valor3,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        Company: document.getElementById("CompanyActual").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobusca").html(msg);
    });
  }

  if (document.getElementById("Organizador").value == "9") {
    $.ajax({
      type: "POST",
      url: "ViewVentas.php",
      data: {
        Accion: "a9",
        sucursal: document.getElementById("sucursal").innerHTML,
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        Search: valor3,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        Company: document.getElementById("CompanyActual").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobusca").html(msg);
    });
  }

  if (document.getElementById("Organizador").value == "10") {
    $.ajax({
      type: "POST",
      url: "ViewVentas.php",
      data: {
        Accion: "a10",
        sucursal: document.getElementById("sucursal").innerHTML,
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        Search: valor3,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        Company: document.getElementById("CompanyActual").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobusca").html(msg);
    });
  }
}

function ProductoInserte(numero, input) {
  document.getElementById("CodIdBas" + numero).innerHTML;
  document.getElementById("Descrip" + numero).innerHTML;
  if (input == 3) {
    document.getElementById("Producto").value = document.getElementById(
      "CodIdBas" + numero,
    ).innerHTML;
    document.getElementById("Producto2").value = document.getElementById(
      "Descrip" + numero,
    ).innerHTML;
    document.getElementById("Producto3").value = document.getElementById(
      "CodBasic" + numero,
    ).innerHTML;
    document.getElementById("Producto4").value = document.getElementById(
      "Descrip" + numero,
    ).innerHTML;
  }
  if (input == 4) {
    document.getElementById("Producto3").value = document.getElementById(
      "CodIdBas" + numero,
    ).innerHTML;
    document.getElementById("Producto4").value = document.getElementById(
      "Descrip" + numero,
    ).innerHTML;
  }
}

function BeneficiarioInserte(numero) {
  document.getElementById("Beneficiario").value = document.getElementById(
    "IdFiscal" + numero,
  ).innerHTML;
  document.getElementById("Beneficiario2").value = document.getElementById(
    "Nomb" + numero,
  ).innerHTML;
}

function ProductoEnter() {
  var valor3 = document.getElementById("Producto").value;
  $.ajax({
    type: "POST",
    url: "filtrossubmodals.php",
    data: {
      Accion: "a3e",
      Search: valor3,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
      Company: document.getElementById("CompanyActual").innerHTML,
    },
  }).done(function (msg) {
    $("#product-enter").html(msg);
    if (msg == 0) {
      document.getElementById("Producto2").value = "";
    } else {
      $("#origin").html(msg);
      if (document.getElementById("CodIdBasicoE").innerHTML != "") {
        document.getElementById("Producto").value =
          document.getElementById("CodIdBasicoE").innerHTML;
      }
      document.getElementById("Producto2").value =
        document.getElementById("DescripcionE").innerHTML;
      document.getElementById("Producto3").value =
        document.getElementById("CodIdBasicoE2").innerHTML;
    }
  });
}

function ClienteInsertex(numero) {
  document.getElementById("Cliente").value = document.getElementById(
    "rutc" + numero,
  ).innerHTML;
  document.getElementById("Cliente2").value = document.getElementById(
    "nombrec" + numero,
  ).innerHTML;
}

function VendedorInsertex(numero) {
  document.getElementById("Vendedor").value = document.getElementById(
    "login" + numero,
  ).innerHTML;
  document.getElementById("Vendedor2").value = document.getElementById(
    "NombreLOGIN" + numero,
  ).innerHTML;
}

function ClienteModalD(n) {
  if (n == 1) {
    document.getElementById("OrganizadorCCD").value = "1";
    document.getElementById("PagActCCD").innerHTML = "1";
    $("#apps-modal2y2").modal("show");
    MuestraElBetaD();
  }
  if (n == 2) {
    document.getElementById("OrganizadorCCD").value = "2";
    document.getElementById("PagActCCD").innerHTML = "1";
    $("#apps-modal2y2").modal("show");
    MuestraElBetaD();
  }
}

function PagineoCCD(n) {
  document.getElementById("PagActCCD").innerHTML = n;
  MuestraElBetaD();
}

function MuestraElBetaD() {
  var valor = document.getElementById("PagActCCD").innerHTML;
  var valor2 = document.getElementById("RpaCCD").innerHTML;
  var valor3 = document.getElementById("search-prodCCD").value;
  var valor4 = document.getElementById("LimitCCD").value;
  if (document.getElementById("OrganizadorCCD").value == "1") {
    $.ajax({
      type: "POST",
      url: "dataseekreportesventas.php",
      data: {
        Accion: "1CCD",
        sucursal: document.getElementById("sucursal").innerHTML,
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        Search: valor3,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        Company: document.getElementById("CompanyActual").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobuscaCCD").html(msg);
    });
  }
  if (document.getElementById("OrganizadorCCD").value == "2") {
    $.ajax({
      type: "POST",
      url: "dataseekreportesventas.php",
      data: {
        Accion: "2CCopD",
        sucursal: document.getElementById("sucursal").innerHTML,
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        Search: valor3,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        Company: document.getElementById("CompanyActual").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobuscaCCD").html(msg);
    });
  }
}

function ClienteInserteD(numero) {
  document.getElementById("ClienteCD").value = document.getElementById(
    "rutc" + numero,
  ).innerHTML;
  document.getElementById("ClienteC2D").value = document.getElementById(
    "nombrec" + numero,
  ).innerHTML;
}

function ClienteInserte2D(numero) {
  document.getElementById("VendedorCD").value = document.getElementById(
    "login" + numero,
  ).innerHTML;
  document.getElementById("VendedorC2D").value = document.getElementById(
    "NombreLOGIN" + numero,
  ).innerHTML;
}

function ClienteENTERD2() {
  var valor3 = document.getElementById("ClienteCD").value;
  $.ajax({
    type: "POST",
    url: "dataseekreportesventas.php",
    data: {
      Accion: "1CCED",
      Search: valor3,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
      Company: document.getElementById("CompanyActual").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#ClienteInserteD").html(msg);
      document.getElementById("ClienteC2D").value =
        document.getElementById("NombreCC").innerHTML;
    }
  });
}

function VendedorENTERD2() {
  var valor3 = document.getElementById("VendedorCD").value;
  $.ajax({
    type: "POST",
    url: "dataseekreportesventas.php",
    data: {
      Accion: "2CCED",
      Search: valor3,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
      Company: document.getElementById("CompanyActual").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#ClienteInserte2D").html(msg);
      document.getElementById("VendedorC2D").value =
        document.getElementById("NombreVE").innerHTML;
    }
  });
}

function PagineoCC(n) {
  document.getElementById("PagActCC").innerHTML = n;
  MuestraElBeta();
}

function MuestraElBeta() {
  var valor = document.getElementById("PagActCC").innerHTML;
  var valor2 = document.getElementById("RpaCC").innerHTML;
  var valor3 = document.getElementById("search-prodCC").value;
  var valor4 = document.getElementById("LimitCC").value;
  if (document.getElementById("OrganizadorCC").value == "1") {
    $.ajax({
      type: "POST",
      url: "dataseekreportesventas.php",
      data: {
        Accion: "1CC",
        sucursal: document.getElementById("sucursal").innerHTML,
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        Search: valor3,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        Company: document.getElementById("CompanyActual").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobuscaCC").html(msg);
    });
  }
  if (document.getElementById("OrganizadorCC").value == "2") {
    $.ajax({
      type: "POST",
      url: "dataseekreportesventas.php",
      data: {
        Accion: "2CCop",
        sucursal: document.getElementById("sucursal").innerHTML,
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        Search: valor3,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        Company: document.getElementById("CompanyActual").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobuscaCC").html(msg);
    });
  }
}

function ClienteInserte(numero) {
  document.getElementById("ClienteC").value = document.getElementById(
    "rutc" + numero,
  ).innerHTML;
  document.getElementById("ClienteC2").value = document.getElementById(
    "nombrec" + numero,
  ).innerHTML;
}

function ClienteInserte2(numero) {
  document.getElementById("VendedorC").value = document.getElementById(
    "login" + numero,
  ).innerHTML;
  document.getElementById("VendedorC2").value = document.getElementById(
    "NombreLOGIN" + numero,
  ).innerHTML;
}

function ClienteENTER() {
  var valor3 = document.getElementById("ClienteC").value;
  $.ajax({
    type: "POST",
    url: "dataseekreportesventas.php",
    data: {
      Accion: "1CCE",
      Search: valor3,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
      Company: document.getElementById("CompanyActual").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#ClienteInserte").html(msg);
      document.getElementById("ClienteC2").value =
        document.getElementById("NombreCC").innerHTML;
    }
  });
}

function VendedorENTER() {
  var valor3 = document.getElementById("VendedorC").value;
  $.ajax({
    type: "POST",
    url: "dataseekreportesventas.php",
    data: {
      Accion: "2CCE",
      Search: valor3,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
      Company: document.getElementById("CompanyActual").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#ClienteInserte2").html(msg);
      document.getElementById("VendedorC2").value =
        document.getElementById("NombreVE").innerHTML;
    }
  });
}

function ClienteModalD2(n) {
  if (n == 1) {
    document.getElementById("OrganizadorCCD2").value = "1";
    document.getElementById("PagActCCD2").innerHTML = "1";
    $("#apps-modal5y2").modal("show");
    MuestraElBetaD2();
  }
  if (n == 2) {
    document.getElementById("OrganizadorCCD2").value = "2";
    document.getElementById("PagActCCD2").innerHTML = "1";
    $("#apps-modal5y2").modal("show");
    MuestraElBetaD2();
  }
}

function PagineoCCD2(n) {
  document.getElementById("PagActCCD2").innerHTML = n;
  MuestraElBetaD2();
}

function MuestraElBetaD2() {
  var valor = document.getElementById("PagActCCD2").innerHTML;
  var valor2 = document.getElementById("RpaCCD2").innerHTML;
  var valor3 = document.getElementById("search-prodCCD2").value;
  var valor4 = document.getElementById("LimitCCD2").value;
  if (document.getElementById("OrganizadorCCD2").value == "1") {
    $.ajax({
      type: "POST",
      url: "dataseekreportesventas.php",
      data: {
        Accion: "1CCD2",
        sucursal: document.getElementById("sucursal").innerHTML,
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        Search: valor3,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        Company: document.getElementById("CompanyActual").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobuscaCCD2").html(msg);
    });
  }
  if (document.getElementById("OrganizadorCCD2").value == "2") {
    $.ajax({
      type: "POST",
      url: "dataseekreportesventas.php",
      data: {
        Accion: "2CCopD2",
        sucursal: document.getElementById("sucursal").innerHTML,
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        Search: valor3,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        Company: document.getElementById("CompanyActual").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobuscaCCD2").html(msg);
    });
  }
}

function ClienteInserteD2(numero) {
  document.getElementById("ClienteCD2").value = document.getElementById(
    "rutc" + numero,
  ).innerHTML;
  document.getElementById("ClienteC2D2").value = document.getElementById(
    "nombrec" + numero,
  ).innerHTML;
}

function ClienteInserte2D2(numero) {
  document.getElementById("VendedorCD2").value = document.getElementById(
    "login" + numero,
  ).innerHTML;
  document.getElementById("VendedorC2D2").value = document.getElementById(
    "NombreLOGIN" + numero,
  ).innerHTML;
}

function ClienteENTERD23() {
  var valor3 = document.getElementById("ClienteCD2").value;
  $.ajax({
    type: "POST",
    url: "dataseekreportesventas.php",
    data: {
      Accion: "1CCED2",
      Search: valor3,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
      Company: document.getElementById("CompanyActual").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#ClienteInserteD23").html(msg);
      document.getElementById("ClienteC2D2").value =
        document.getElementById("NombreCC").innerHTML;
    }
  });
}

function VendedorENTERD23() {
  var valor3 = document.getElementById("VendedorCD2").value;
  $.ajax({
    type: "POST",
    url: "dataseekreportesventas.php",
    data: {
      Accion: "2CCED2",
      Search: valor3,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
      Company: document.getElementById("CompanyActual").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#ClienteInserte2D2").html(msg);
      document.getElementById("VendedorC2D2").value =
        document.getElementById("NombreVE").innerHTML;
    }
  });
}

function closemodal(parametro) {
  $("#" + parametro).modal("hide");
}

function PagineoCC22(n) {
  document.getElementById("PagActCC22").innerHTML = n;
  MuestraElBeta22();
}

function MuestraElBeta22() {
  var valor = document.getElementById("PagActCC22").innerHTML;
  var valor2 = document.getElementById("RpaCC22").innerHTML;
  var valor3 = document.getElementById("search-prodCC22").value;
  var valor4 = document.getElementById("LimitCC22").value;
  if (document.getElementById("OrganizadorCC22").value == "1") {
    $.ajax({
      type: "POST",
      url: "dataseekreportesventas.php",
      data: {
        Accion: "1CC22",
        sucursal: document.getElementById("sucursal").innerHTML,
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        Search: valor3,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        Company: document.getElementById("CompanyActual").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobuscaCC23").html(msg);
    });
  }
  if (document.getElementById("OrganizadorCC22").value == "2") {
    $.ajax({
      type: "POST",
      url: "dataseekreportesventas.php",
      data: {
        Accion: "2CC22",
        sucursal: document.getElementById("sucursal").innerHTML,
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        Search: valor3,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        Company: document.getElementById("CompanyActual").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobuscaCC23").html(msg);
    });
  }
}

function BenefeSE22(numero) {
  document.getElementById("BeneficiarioSE223").value = document.getElementById(
    "rutc2" + numero,
  ).innerHTML;
  document.getElementById("BeneficiarioSE2223").value = document.getElementById(
    "nombrec2" + numero,
  ).innerHTML;
  $("#apps-modal1y22").modal("hide");
}

function Vendedor2(numero) {
  document.getElementById("VendedorC2").value = document.getElementById(
    "login" + numero,
  ).innerHTML;
  document.getElementById("VendedorC22").value = document.getElementById(
    "NombreLOGIN" + numero,
  ).innerHTML;
}

function BenefeSnter22() {
  document.getElementById("BeneficiarioSE2223").value = "";
  var valor3 = document.getElementById("BeneficiarioSE223").value;
  $.ajax({
    type: "POST",
    url: "dataseekreportesventas.php",
    data: {
      Accion: "1CCE22b",
      Search: valor3,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
      Company: document.getElementById("CompanyActual").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#BenefeasdSE").html(msg);
      document.getElementById("BeneficiarioSE2223").value =
        document.getElementById("NombreCC2").innerHTML;
    }
  });
}

function VendedorENTER2() {
  var valor3 = document.getElementById("VendedorC2").value;
  $.ajax({
    type: "POST",
    url: "dataseekreportesventas.php",
    data: {
      Accion: "2CCE",
      Search: valor3,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
      Company: document.getElementById("CompanyActual").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#ClienteInserte22").html(msg);
      document.getElementById("VendedorC22").value =
        document.getElementById("NombreVE").innerHTML;
    }
  });
}

/*

function venta3(){
  $.ajax({
  type: "POST",
  url: "appsmodalventas.php",
  data:{Accion:"p3",login:document.getElementById( "userlogin" ).innerHTML,sucursal: document.getElementById( "sucursal" ).innerHTML,userperfil: document.getElementById( "userperfil" ).innerHTML,CIdPlan:document.getElementById( "CIdPlan" ).innerHTML,IdCompanySelect:document.getElementById( "IdCompanySelect" ).value,IdCompanyGrp:document.getElementById( "IdCompanyGrp" ).innerHTML,Company:document.getElementById( "CompanyActual" ).innerHTML}
  }).done(function(msg){
      $("#prueba1").html(msg);

      $('#apps-modalz').modal('show'); 
  });
}

function venta10(){
  $.ajax({
  type: "POST",
  url: "appsmodalventas.php",
  data:{Accion:"p10",login:document.getElementById( "userlogin" ).innerHTML,sucursal: document.getElementById( "sucursal" ).innerHTML,userperfil: document.getElementById( "userperfil" ).innerHTML,CIdPlan:document.getElementById( "CIdPlan" ).innerHTML,IdCompanySelect:document.getElementById( "IdCompanySelect" ).value,IdCompanyGrp:document.getElementById( "IdCompanyGrp" ).innerHTML,Company:document.getElementById( "CompanyActual" ).innerHTML}
  }).done(function(msg){
      $("#prueba1").html(msg);

      $('#apps-modalz').modal('show'); 
  });
}


function venta12(){
  $.ajax({
  type: "POST",
  url: "appsmodalventas.php",
  data:{Accion:"p12",login:document.getElementById( "userlogin" ).innerHTML,sucursal: document.getElementById( "sucursal" ).innerHTML,userperfil: document.getElementById( "userperfil" ).innerHTML,CIdPlan:document.getElementById( "CIdPlan" ).innerHTML,IdCompanySelect:document.getElementById( "IdCompanySelect" ).value,IdCompanyGrp:document.getElementById( "IdCompanyGrp" ).innerHTML,Company:document.getElementById( "CompanyActual" ).innerHTML}
  }).done(function(msg){
      $("#prueba1").html(msg);

      $('#apps-modalz').modal('show'); 
  });
}
*/
