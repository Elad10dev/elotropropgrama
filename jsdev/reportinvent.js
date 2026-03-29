function HabilitarBotones() {
  n = 0;
  while (n < 25) {
    if (n < 10) {
      var button = "button00" + n;
    } else {
      var button = "button0" + n;
    }
    n++;
    $("#" + button).prop("disabled", false);
  }
}
function changeinput(
  multiple = "0",
  user = "",
  almacen = "",
  estacion = "",
  familia = "",
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
      $("#estacion").html(msg);
    });
  }
}

function inventario(n) {
  if (n < 10) {
    var button = "button00" + n;
  } else {
    var button = "button0" + n;
  }

  $("#" + button).prop("disabled", true);
  $.ajax({
    type: "POST",
    url: "appsmodalinventario.php",
    data: {
      Accion: n,
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      PerfilVentas: document.getElementById("PerfilVentas").innerHTML,
      login: document.getElementById("userlogin").innerHTML,
      sucursal: document.getElementById("sucursal").innerHTML,
      userperfil: document.getElementById("userperfil").innerHTML,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
      CD: document.getElementById("CD").innerHTML,
      SimDec: document.getElementById("SimDec").innerHTML,
      SimMil: document.getElementById("SimMil").innerHTML,
    },
  }).done(function (msg) {
    $("#prueba1").html(msg);
    $("#apps-modalz").modal("show");
    $("#" + button).prop("disabled", false);
  });
}

function asd(n) {
  if (n == 1) {
    var colum = [null, null, { orderable: false }];
  }
  if (n == 2) {
    var colum = [null, null, { orderable: false }];
  }
  if (n == 3) {
    var colum = [null, null, { orderable: false }];
  }
  if (n == 4) {
    var colum = [null, null, null, { orderable: false }];
  }
  if (n == 5) {
    var colum = [null, null, null, { orderable: false }];
  }
  if (n == 6) {
    var colum = [null, null, { orderable: false }];
  }

  var language =
    "lang/datatables/" +
    document.getElementById("IdiomaActual").innerHTML +
    ".json";
  $.ajax({
    type: "POST",
    url: "reportinventseek.php",
    data: {
      Accion: "0",
      Ini: "0",
      sucursal: document.getElementById("sucursal").innerHTML,
      Opcion: n,
    },
  }).done(function (msg) {
    $("#Temporal").html(msg);
    document.getElementById("appsmodal99name").innerHTML =
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
        url: "reportinventseek.php",
        data: {
          Accion: "0",
          sucursal: document.getElementById("sucursal").innerHTML,
          Ini: "1",
          Opcion: n,
          CompanyActual: document.getElementById("CompanyActual").innerHTML,
          userperfil: document.getElementById("userperfil").innerHTML,
          CIdPlan: document.getElementById("CIdPlan").innerHTML,
          IdCompanySelect: document.getElementById("IdCompanySelect").value,
          IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        },
      },
      columns: colum,
      destroy: true,
    });
    $("#apps-modalz").modal("hide");
    $("#apps-modal99").modal("show");
  });
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

function ListaLPRESres(n) {
  if (n == 2) {
    var colum = [null, null, { orderable: false }];
  }
  if (n == 3) {
    var colum = [null, null, { orderable: false }];
  }
  if (n == 5) {
    var colum = [null, null, { orderable: false }];
  }

  var language =
    "lang/datatables/" +
    document.getElementById("IdiomaActual").innerHTML +
    ".json";
  $.ajax({
    type: "POST",
    url: "reportinventseek.php",
    data: {
      Accion: "1",
      Ini: "0",
      sucursal: document.getElementById("sucursal").innerHTML,
      Opcion: n,
    },
  }).done(function (msg) {
    $("#Temporal").html(msg);
    document.getElementById("appsmodal129name").innerHTML =
      document.getElementById("Num001").innerHTML;
    document.getElementById("ReposicionTableRep").innerHTML =
      document.getElementById("Num002").innerHTML;
    $("#Temporal").html("");
    $("#ReposicionTableRepDT").DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      language: {
        url: language,
      },
      ajax: {
        type: "POST",
        url: "reportinventseek.php",
        data: {
          Accion: "1",
          sucursal: document.getElementById("sucursal").innerHTML,
          Ini: "1",
          Opcion: n,
          CompanyActual: document.getElementById("CompanyActual").innerHTML,
          userperfil: document.getElementById("userperfil").innerHTML,
          CIdPlan: document.getElementById("CIdPlan").innerHTML,
          IdCompanySelect: document.getElementById("IdCompanySelect").value,
          IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        },
      },
      columns: colum,
      destroy: true,
    });
    $("#apps-modalz").modal("hide");
    $("#apps-modal129").modal("show");
  });
}

/* ===============================================================
   FUNCIÓN: MODO PDF (Abre modal y modifica botón Preliminar)
   =============================================================== */
function inventarioPDF(n) {
    // 1. Recolectar datos
    var datos = {
        Accion: n,
        IdiomaActual: $("#IdiomaActual").html(),
        litfiscal: $("#litfiscal").html(),
        direccion: $("#direccionActSe").html(),
        NameCompany: $("#NameCompany").html(),
        PerfilVentas: $("#PerfilVentas").html(),
        login: $("#userlogin").html(),
        sucursal: $("#sucursal").html(),
        userperfil: $("#userperfil").html(),
        CompanyActual: $("#CompanyActual").html(), // Cambiado a CompanyActual para consistencia
        CIdPlan: $("#CIdPlan").html(),
        IdCompanyGrp: $("#IdCompanyGrp").html(),
        CD: $("#CD").html(),
        SimDec: $("#SimDec").html(),
        SimMil: $("#SimMil").html()
    };

    // 2. Llamar al modal de parámetros
    $.ajax({
        type: "POST",
        url: "appsmodalinventario.php",
        data: datos
    }).done(function (msg) {
        $("#prueba1").html(msg);
        
        var $modal = $("#prueba1");
        var $form = $modal.find("form");
        var $btnPreliminar = $modal.find("button:has(.fa-print)");

        if ($btnPreliminar.length > 0) {
            // Estética del botón para PDF
            $btnPreliminar.removeClass("btn-outline-primary").addClass("btn-danger text-white");
            $btnPreliminar.find("i").removeClass("fa-print").addClass("fa-file-pdf-o");
            $btnPreliminar.html($btnPreliminar.html().replace("Preliminar", " Generar PDF"));

            // Limpiar eventos y asignar nueva lógica de redirección
            $btnPreliminar.removeAttr("onclick").off("click").on("click", function(e) {
                e.preventDefault();
                
                var urlDestino = "";

                // --- MAPEO DINÁMICO DE ARCHIVOS INDEPENDIENTES ---
                switch(parseInt(n)) {
                    case 1:  urlDestino = "reporte_productos_pdf.php"; break;
                    case 2:  urlDestino = "reporte_reposicion_pdf.php"; break;
                    case 3:  urlDestino = "reporte_analisis_productos_pdf.php"; break;
                    case 4:  urlDestino = "reporte_listaprecios_pdf.php"; break;
                    case 5:  urlDestino = "reporte_fisico_pdf.php"; break;
                    case 6:  urlDestino = "reporte_analisisfamilia_pdf.php"; break;
                    case 7:  urlDestino = "reporte_analisis_marca_pdf.php"; break;
                    case 8:  urlDestino = "reporte_operaciones_pdf.php"; break;
                    case 9:  urlDestino = "reporte_historial_seriales_pdf.php"; break;
                    case 10: urlDestino = "reporte_detallado_pdf.php"; break;
                    case 11: urlDestino = "reporte_resumido_pdf.php"; break;
                    case 12: urlDestino = "reporte_fiscal_pdf.php"; break;
                    case 13: urlDestino = "reporte_produccion_pdf.php"; break;
                    case 15: urlDestino = "reporte_listaprecios_avanzado1167_pdf.php"; break;
                    case 16: urlDestino = "reporte_listaprecios_avanzado_pdf.php"; break;
                    case 18: urlDestino = "reporte_listaprecios_avanzado1167_pdf.php"; break;
                    default:
                        alert("Este reporte aún no tiene un archivo PDF independiente asignado.");
                        return;
                }

                // Configurar y enviar formulario
                $form.attr("action", urlDestino);
                $form.attr("target", "_blank");
                $form[0].submit();
            });
        }

        $("#apps-modalz").modal("show");
    });
}

function inventarioExcel(n) {
    // 1. Recolectar datos (Idéntico a tu función original)
    var datos = {
        Accion: n,
        IdiomaActual: $("#IdiomaActual").html(),
        litfiscal: $("#litfiscal").html(),
        direccion: $("#direccionActSe").html(),
        NameCompany: $("#NameCompany").html(),
        PerfilVentas: $("#PerfilVentas").html(),
        login: $("#userlogin").html(),
        sucursal: $("#sucursal").html(),
        userperfil: $("#userperfil").html(),
        CompanyActual: $("#CompanyActual").html(),
        CIdPlan: $("#CIdPlan").html(),
        IdCompanyGrp: $("#IdCompanyGrp").html(),
        CD: $("#CD").html(),
        SimDec: $("#SimDec").html(),
        SimMil: $("#SimMil").html()
    };

    // 2. Llamar al modal de parámetros
    $.ajax({
        type: "POST",
        url: "appsmodalinventario.php",
        data: datos
    }).done(function (msg) {
        $("#prueba1").html(msg);
        
        var $modal = $("#prueba1");
        var $form = $modal.find("form");
        var $btnPreliminar = $modal.find("button:has(.fa-print)");

        if ($btnPreliminar.length > 0) {
            // Estética del botón para EXCEL (Verde)
            $btnPreliminar.removeClass("btn-outline-primary btn-danger").addClass("btn-success text-white");
            $btnPreliminar.find("i").removeClass("fa-print fa-file-pdf-o").addClass("fa-file-excel-o");
            $btnPreliminar.html($btnPreliminar.html().replace("Preliminar", " Generar Excel").replace("Generar PDF", "Generar Excel"));

            // Limpiar eventos y asignar nueva lógica de redirección a archivos Excel
            $btnPreliminar.removeAttr("onclick").off("click").on("click", function(e) {
                e.preventDefault();
                
                var urlDestino = "";

                // --- MAPEO DINÁMICO DE ARCHIVOS EXCEL ---
                switch(parseInt(n)) {
                    case 1:  urlDestino = "reporte_productos_excel.php"; break;
                    case 2:  urlDestino = "reporte_reposicion_excel.php"; break;
                    case 3:  urlDestino = "reporte_analisis_productos_excel.php"; break;
                    case 4:  urlDestino = "reporte_listaprecios_excel.php"; break;
                    case 5:  urlDestino = "reporte_fisico_excel.php"; break;
                    case 6:  urlDestino = "reporte_analisisfamilia_excel.php"; break;
                    case 7:  urlDestino = "reporte_analisis_marca_excel.php"; break;
                    case 8:  urlDestino = "reporte_operaciones_excel.php"; break;
                    case 9:  urlDestino = "reporte_historial_seriales_excel.php"; break;
                    case 10: urlDestino = "reporte_detallado_excel.php"; break;
                    case 11: urlDestino = "reporte_resumido_excel.php"; break;
                    case 12: urlDestino = "reporte_fiscal_excel.php"; break;
                    case 13: urlDestino = "reporte_produccion_excel.php"; break;
                    case 15: urlDestino = "reporte_listaprecios_avanzado1167_excel.php"; break;
                    case 16: urlDestino = "reporte_listaprecios_avanzado_excel.php"; break;
                    case 18: urlDestino = "reporte_listaprecios_avanzado1167_excel.php"; break;
                    default:
                        alert("Este reporte aún no tiene un archivo Excel independiente asignado.");
                        return;
                }

                // Configurar y enviar formulario para descargar Excel
                $form.attr("action", urlDestino);
                $form.attr("target", "_self"); // '_self' es mejor para descargar archivos directamente
                $form[0].submit();
            });
        }

        $("#apps-modalz").modal("show");
    });
}

function AXmodal(n) {
  if (n == 1) {
    var colum = [null, null, { orderable: false }];
  }
  if (n == 2) {
    var colum = [null, null, { orderable: false }];
  }
  if (n == 3) {
    var colum = [null, null, null, { orderable: false }];
  }
  if (n == 4) {
    var colum = [null, null, null, { orderable: false }];
  }

  var language =
    "lang/datatables/" +
    document.getElementById("IdiomaActual").innerHTML +
    ".json";
  $.ajax({
    type: "POST",
    url: "reportinventseek.php",
    data: {
      Accion: "2",
      Ini: "0",
      sucursal: document.getElementById("sucursal").innerHTML,
      Opcion: n,
    },
  }).done(function (msg) {
    $("#Temporal").html(msg);
    document.getElementById("appsmodal149name").innerHTML =
      document.getElementById("Num001").innerHTML;
    document.getElementById("AnalisisTableRep").innerHTML =
      document.getElementById("Num002").innerHTML;
    $("#Temporal").html("");
    $("#AnalisisTableRepDT").DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      language: {
        url: language,
      },
      ajax: {
        type: "POST",
        url: "reportinventseek.php",
        data: {
          Accion: "2",
          sucursal: document.getElementById("sucursal").innerHTML,
          Ini: "1",
          Opcion: n,
          CompanyActual: document.getElementById("CompanyActual").innerHTML,
          userperfil: document.getElementById("userperfil").innerHTML,
          CIdPlan: document.getElementById("CIdPlan").innerHTML,
          IdCompanySelect: document.getElementById("IdCompanySelect").value,
          IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        },
      },
      columns: colum,
      destroy: true,
    });
    $("#apps-modalz").modal("hide");
    $("#apps-modal149").modal("show");
  });
}

function ListaLP(n) {
  if (n == 1) {
    var colum = [null, null, { orderable: false }];
  }
  if (n == 2) {
    var colum = [null, null, { orderable: false }];
  }
  if (n == 3) {
    var colum = [null, null, { orderable: false }];
  }
  if (n == 5) {
    var colum = [null, null, null, { orderable: false }];
  }
  if (n == 6) {
    var colum = [null, null, { orderable: false }];
  }

  var language =
    "lang/datatables/" +
    document.getElementById("IdiomaActual").innerHTML +
    ".json";
  $.ajax({
    type: "POST",
    url: "reportinventseek.php",
    data: {
      Accion: "3",
      Ini: "0",
      sucursal: document.getElementById("sucursal").innerHTML,
      Opcion: n,
    },
  }).done(function (msg) {
    $("#Temporal").html(msg);
    document.getElementById("appsmodal149name").innerHTML =
      document.getElementById("Num001").innerHTML;
    document.getElementById("ListaPrecioTableRep").innerHTML =
      document.getElementById("Num002").innerHTML;
    $("#Temporal").html("");
    $("#ListaPrecioTableRepDT").DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      language: {
        url: language,
      },
      ajax: {
        type: "POST",
        url: "reportinventseek.php",
        data: {
          Accion: "3",
          sucursal: document.getElementById("sucursal").innerHTML,
          Ini: "1",
          Opcion: n,
          CompanyActual: document.getElementById("CompanyActual").innerHTML,
          userperfil: document.getElementById("userperfil").innerHTML,
          CIdPlan: document.getElementById("CIdPlan").innerHTML,
          IdCompanySelect: document.getElementById("IdCompanySelect").value,
          IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        },
      },
      columns: colum,
      destroy: true,
    });
    $("#apps-modalz").modal("hide");
    $("#apps-modal109").modal("show");
  });
}

function AXmodalX(n) {
  if (n == 1) {
    var colum = [null, null, { orderable: false }];
  }
  if (n == 2) {
    var colum = [null, null, { orderable: false }];
  }
  if (n == 3) {
    var colum = [null, null, { orderable: false }];
  }
  if (n == 4) {
    var colum = [null, null, null, { orderable: false }];
  }
  if (n == 5) {
    var colum = [null, null, { orderable: false }];
  }

  var language =
    "lang/datatables/" +
    document.getElementById("IdiomaActual").innerHTML +
    ".json";
  $.ajax({
    type: "POST",
    url: "reportinventseek.php",
    data: {
      Accion: "4",
      Ini: "0",
      sucursal: document.getElementById("sucursal").innerHTML,
      Opcion: n,
    },
  }).done(function (msg) {
    $("#Temporal").html(msg);
    document.getElementById("appsmodal159name").innerHTML =
      document.getElementById("Num001").innerHTML;
    document.getElementById("InventarioFisiTableRep").innerHTML =
      document.getElementById("Num002").innerHTML;
    $("#Temporal").html("");
    $("#InventarioFisiTableRepDT").DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      language: {
        url: language,
      },
      ajax: {
        type: "POST",
        url: "reportinventseek.php",
        data: {
          Accion: "4",
          sucursal: document.getElementById("sucursal").innerHTML,
          Ini: "1",
          Opcion: n,
          CompanyActual: document.getElementById("CompanyActual").innerHTML,
          userperfil: document.getElementById("userperfil").innerHTML,
          CIdPlan: document.getElementById("CIdPlan").innerHTML,
          IdCompanySelect: document.getElementById("IdCompanySelect").value,
          IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        },
      },
      columns: colum,
      destroy: true,
    });
    $("#apps-modalz").modal("hide");
    $("#apps-modal159").modal("show");
  });
}

function AXmodal22(n) {
  if (n == 1) {
    var colum = [null, null, { orderable: false }];
  }
  if (n == 2) {
    var colum = [null, null, { orderable: false }];
  }
  if (n == 3) {
    var colum = [null, null, null, { orderable: false }];
  }
  if (n == 4) {
    var colum = [null, null, null, { orderable: false }];
  }

  var language =
    "lang/datatables/" +
    document.getElementById("IdiomaActual").innerHTML +
    ".json";
  $.ajax({
    type: "POST",
    url: "reportinventseek.php",
    data: {
      Accion: "5",
      Ini: "0",
      sucursal: document.getElementById("sucursal").innerHTML,
      Opcion: n,
    },
  }).done(function (msg) {
    $("#Temporal").html(msg);
    document.getElementById("appsmodal31y2name").innerHTML =
      document.getElementById("Num001").innerHTML;
    document.getElementById("AnalisisdeFamiliaTableRep").innerHTML =
      document.getElementById("Num002").innerHTML;
    $("#Temporal").html("");
    $("#AnalisisdeFamiliaTableRepDT").DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      language: {
        url: language,
      },
      ajax: {
        type: "POST",
        url: "reportinventseek.php",
        data: {
          Accion: "5",
          sucursal: document.getElementById("sucursal").innerHTML,
          Ini: "1",
          Opcion: n,
          CompanyActual: document.getElementById("CompanyActual").innerHTML,
          userperfil: document.getElementById("userperfil").innerHTML,
          CIdPlan: document.getElementById("CIdPlan").innerHTML,
          IdCompanySelect: document.getElementById("IdCompanySelect").value,
          IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        },
      },
      columns: colum,
      destroy: true,
    });
    $("#apps-modalz").modal("hide");
    $("#apps-modal31y2").modal("show");
  });
}

function AXmodal2(n) {
  if (n == 1) {
    var colum = [null, null, { orderable: false }];
  }
  if (n == 2) {
    var colum = [null, null, { orderable: false }];
  }
  if (n == 3) {
    var colum = [null, null, null, { orderable: false }];
  }
  if (n == 4) {
    var colum = [null, null, null, { orderable: false }];
  }

  var language =
    "lang/datatables/" +
    document.getElementById("IdiomaActual").innerHTML +
    ".json";
  $.ajax({
    type: "POST",
    url: "reportinventseek.php",
    data: {
      Accion: "6",
      Ini: "0",
      sucursal: document.getElementById("sucursal").innerHTML,
      Opcion: n,
    },
  }).done(function (msg) {
    $("#Temporal").html(msg);
    document.getElementById("appsmodal30y2name").innerHTML =
      document.getElementById("Num001").innerHTML;
    document.getElementById("AnalisisdeMarcaTableRep").innerHTML =
      document.getElementById("Num002").innerHTML;
    $("#Temporal").html("");
    $("#AnalisisdeMarcaTableRepDT").DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      language: {
        url: language,
      },
      ajax: {
        type: "POST",
        url: "reportinventseek.php",
        data: {
          Accion: "6",
          sucursal: document.getElementById("sucursal").innerHTML,
          Ini: "1",
          Opcion: n,
          CompanyActual: document.getElementById("CompanyActual").innerHTML,
          userperfil: document.getElementById("userperfil").innerHTML,
          CIdPlan: document.getElementById("CIdPlan").innerHTML,
          IdCompanySelect: document.getElementById("IdCompanySelect").value,
          IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        },
      },
      columns: colum,
      destroy: true,
    });
    $("#apps-modalz").modal("hide");
    $("#apps-modal30y2").modal("show");
  });
}

function Seriales2(n) {
  if (n == 1) {
    var colum = [null, null, { orderable: false }];
  }
  if (n == 2) {
    var colum = [null, null, null, { orderable: false }];
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
    url: "reportinventseek.php",
    data: {
      Accion: "7",
      Ini: "0",
      sucursal: document.getElementById("sucursal").innerHTML,
      Opcion: n,
    },
  }).done(function (msg) {
    $("#Temporal").html(msg);
    document.getElementById("appsmodal215name").innerHTML =
      document.getElementById("Num001").innerHTML;
    document.getElementById("OperacionesdeinventarioTableRep").innerHTML =
      document.getElementById("Num002").innerHTML;
    $("#Temporal").html("");
    $("#OperacionesdeinventarioTableRepDT").DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      language: {
        url: language,
      },
      ajax: {
        type: "POST",
        url: "reportinventseek.php",
        data: {
          Accion: "7",
          sucursal: document.getElementById("sucursal").innerHTML,
          Ini: "1",
          Opcion: n,
          CompanyActual: document.getElementById("CompanyActual").innerHTML,
          userperfil: document.getElementById("userperfil").innerHTML,
          CIdPlan: document.getElementById("CIdPlan").innerHTML,
          IdCompanySelect: document.getElementById("IdCompanySelect").value,
          IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        },
      },
      columns: colum,
      destroy: true,
    });
    $("#apps-modalz").modal("hide");
    $("#apps-modal215").modal("show");
  });
}

function Seriales(n) {
  if (n == 1) {
    var colum = [null, null, { orderable: false }];
  }
  if (n == 2) {
    var colum = [null, null, null, { orderable: false }];
  }
  if (n == 3) {
    var colum = [null, null, null, { orderable: false }];
  }

  var language =
    "lang/datatables/" +
    document.getElementById("IdiomaActual").innerHTML +
    ".json";
  $.ajax({
    type: "POST",
    url: "reportinventseek.php",
    data: {
      Accion: "8",
      Ini: "0",
      sucursal: document.getElementById("sucursal").innerHTML,
      Opcion: n,
    },
  }).done(function (msg) {
    $("#Temporal").html(msg);
    document.getElementById("appsmodal139name").innerHTML =
      document.getElementById("Num001").innerHTML;
    document.getElementById("HistoricoSerialesTableRep").innerHTML =
      document.getElementById("Num002").innerHTML;
    $("#Temporal").html("");
    $("#HistoricoSerialesTableRepDT").DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      language: {
        url: language,
      },
      ajax: {
        type: "POST",
        url: "reportinventseek.php",
        data: {
          Accion: "8",
          sucursal: document.getElementById("sucursal").innerHTML,
          Ini: "1",
          Opcion: n,
          CompanyActual: document.getElementById("CompanyActual").innerHTML,
          userperfil: document.getElementById("userperfil").innerHTML,
          CIdPlan: document.getElementById("CIdPlan").innerHTML,
          IdCompanySelect: document.getElementById("IdCompanySelect").value,
          IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        },
      },
      columns: colum,
      destroy: true,
    });
    $("#apps-modalz").modal("hide");
    $("#apps-modal139").modal("show");
  });
}

function ListaLPRESX(n) {
  if (n == 2) {
    var colum = [null, null, { orderable: false }];
  }
  if (n == 3) {
    var colum = [null, null, { orderable: false }];
  }
  if (n == 4) {
    var colum = [null, null, { orderable: false }];
  }

  var language =
    "lang/datatables/" +
    document.getElementById("IdiomaActual").innerHTML +
    ".json";
  $.ajax({
    type: "POST",
    url: "reportinventseek.php",
    data: {
      Accion: "9",
      Ini: "0",
      Opcion: n,
      sucursal: document.getElementById("sucursal").innerHTML,
    },
  }).done(function (msg) {
    $("#Temporal").html(msg);
    document.getElementById("appsmodal189name").innerHTML =
      document.getElementById("Num001").innerHTML;
    document.getElementById("MovDetalladoTableRep").innerHTML =
      document.getElementById("Num002").innerHTML;
    $("#Temporal").html("");
    $("#MovDetalladoTableRepDT").DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      language: {
        url: language,
      },
      ajax: {
        type: "POST",
        url: "reportinventseek.php",
        data: {
          Accion: "9",
          Ini: "1",
          Opcion: n,
          sucursal: document.getElementById("sucursal").innerHTML,
          CompanyActual: document.getElementById("CompanyActual").innerHTML,
          userperfil: document.getElementById("userperfil").innerHTML,
          CIdPlan: document.getElementById("CIdPlan").innerHTML,
          IdCompanySelect: document.getElementById("IdCompanySelect").value,
          IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        },
      },
      columns: colum,
      destroy: true,
    });
    $("#apps-modalz").modal("hide");
    $("#apps-modal189").modal("show");
  });
}

function ListaLPRES(n) {
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
    url: "reportinventseek.php",
    data: {
      Accion: "10",
      Ini: "0",
      Opcion: n,
      sucursal: document.getElementById("sucursal").innerHTML,
    },
  }).done(function (msg) {
    $("#Temporal").html(msg);
    document.getElementById("appsmodal119name").innerHTML =
      document.getElementById("Num001").innerHTML;
    document.getElementById("MovimientoResumidoTableRep").innerHTML =
      document.getElementById("Num002").innerHTML;
    $("#Temporal").html("");
    $("#MovimientoResumidoTableRepDT").DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      language: {
        url: language,
      },
      ajax: {
        type: "POST",
        url: "reportinventseek.php",
        data: {
          Accion: "10",
          Ini: "1",
          Opcion: n,
          sucursal: document.getElementById("sucursal").innerHTML,
          CompanyActual: document.getElementById("CompanyActual").innerHTML,
          userperfil: document.getElementById("userperfil").innerHTML,
          CIdPlan: document.getElementById("CIdPlan").innerHTML,
          IdCompanySelect: document.getElementById("IdCompanySelect").value,
          IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        },
      },
      columns: colum,
      destroy: true,
    });
    $("#apps-modalz").modal("hide");
    $("#apps-modal119").modal("show");
  });
}

function ListaLPRESG(n) {
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
    url: "reportinventseek.php",
    data: {
      Accion: "11",
      Ini: "0",
      Opcion: n,
      sucursal: document.getElementById("sucursal").innerHTML,
    },
  }).done(function (msg) {
    $("#Temporal").html(msg);
    document.getElementById("appsmodal229name").innerHTML =
      document.getElementById("Num001").innerHTML;
    document.getElementById("MovimientoFiscalRep").innerHTML =
      document.getElementById("Num002").innerHTML;
    $("#Temporal").html("");
    $("#MovimientoFiscalRepDT").DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      language: {
        url: language,
      },
      ajax: {
        type: "POST",
        url: "reportinventseek.php",
        data: {
          Accion: "11",
          Ini: "1",
          Opcion: n,
          sucursal: document.getElementById("sucursal").innerHTML,
          CompanyActual: document.getElementById("CompanyActual").innerHTML,
          userperfil: document.getElementById("userperfil").innerHTML,
          CIdPlan: document.getElementById("CIdPlan").innerHTML,
          IdCompanySelect: document.getElementById("IdCompanySelect").value,
          IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        },
      },
      columns: colum,
      destroy: true,
    });
    $("#apps-modalz").modal("hide");
    $("#apps-modal229").modal("show");
  });
}

function ListaLPRESGXQ(n) {
  if (n == 1) {
    var colum = [null, null, { orderable: false }];
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
    url: "reportinventseek.php",
    data: {
      Accion: "12",
      Ini: "0",
      Opcion: n,
      sucursal: document.getElementById("sucursal").innerHTML,
    },
  }).done(function (msg) {
    $("#Temporal").html(msg);
    document.getElementById("appsmodal230name").innerHTML =
      document.getElementById("Num001").innerHTML;
    document.getElementById("AlmacendeVentaRep").innerHTML =
      document.getElementById("Num002").innerHTML;
    $("#Temporal").html("");
    $("#AlmacendeVentaRepDT").DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      language: {
        url: language,
      },
      ajax: {
        type: "POST",
        url: "reportinventseek.php",
        data: {
          Accion: "12",
          Ini: "1",
          Opcion: n,
          sucursal: document.getElementById("sucursal").innerHTML,
          CompanyActual: document.getElementById("CompanyActual").innerHTML,
          userperfil: document.getElementById("userperfil").innerHTML,
          CIdPlan: document.getElementById("CIdPlan").innerHTML,
          IdCompanySelect: document.getElementById("IdCompanySelect").value,
          IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        },
      },
      columns: colum,
      destroy: true,
    });
    $("#apps-modalz").modal("hide");
    $("#apps-modal230").modal("show");
  });
}

function Usar(n, m, numero) {
  if (n == 1) {
    if (m == 1) {
      document.getElementById("InstanciaNK").value = document.getElementById(
        "varios" + numero,
      ).innerHTML;
      document.getElementById("Instancia2NK").value = document.getElementById(
        "itemname" + numero,
      ).innerHTML;
      $("#apps-modal99").modal("hide");
      $("#apps-modalz").modal("show");
    }
    if (m == 2) {
      document.getElementById("CodigoDesde2").value = document.getElementById(
        "Descrip" + numero,
      ).innerHTML;
      document.getElementById("CodigoDesde").value = document.getElementById(
        "CodIdBas" + numero,
      ).innerHTML;
      document.getElementById("CodigoHasta2").value = document.getElementById(
        "Descrip" + numero,
      ).innerHTML;
      document.getElementById("CodigoHasta").value = document.getElementById(
        "CodIdBas" + numero,
      ).innerHTML;
      $("#apps-modal99").modal("hide");
      $("#apps-modalz").modal("show");
    }
    if (m == 3) {
      document.getElementById("CodigoHasta2").value = document.getElementById(
        "Descrip" + numero,
      ).innerHTML;
      document.getElementById("CodigoHasta").value = document.getElementById(
        "CodIdBas" + numero,
      ).innerHTML;
      $("#apps-modal99").modal("hide");
      $("#apps-modalz").modal("show");
    }
    if (m == 4) {
      document.getElementById("Proevedor2").value = document.getElementById(
        "Nomb" + numero,
      ).innerHTML;
      document.getElementById("Proevedor").value = document.getElementById(
        "IdFiscal" + numero,
      ).innerHTML;
      $("#apps-modal99").modal("hide");
      $("#apps-modalz").modal("show");
    }
    if (m == 5) {
      document.getElementById("Deposito2NK").value = document.getElementById(
        "NombD" + numero,
      ).innerHTML;
      document.getElementById("DepositoNK").value = document.getElementById(
        "IdAlma" + numero,
      ).innerHTML;
      $("#apps-modal99").modal("hide");
      $("#apps-modalz").modal("show");
    }
    if (m == 6) {
      document.getElementById("Marca2").value = document.getElementById(
        "NombM" + numero,
      ).innerHTML;
      document.getElementById("Marca").value = document.getElementById(
        "IdM" + numero,
      ).innerHTML;
      $("#apps-modal99").modal("hide");
      $("#apps-modalz").modal("show");
    }
  }
  if (n == 2) {
    if (m == 2) {
      document.getElementById("CodigoDesde2LPRESres").value =
        document.getElementById("Descripres" + numero).innerHTML;
      document.getElementById("CodigoDesdeLPRESres").value =
        document.getElementById("CodIdBasres" + numero).innerHTML;
      document.getElementById("CodigoHasta2LPRESres").value =
        document.getElementById("Descripres" + numero).innerHTML;
      document.getElementById("CodigoHastaLPRESres").value =
        document.getElementById("CodIdBasres" + numero).innerHTML;
      $("#apps-modal129").modal("hide");
      $("#apps-modalz").modal("show");
    }
    if (m == 3) {
      document.getElementById("CodigoHasta2LPRESres").value =
        document.getElementById("Descripres" + numero).innerHTML;
      document.getElementById("CodigoHastaLPRESres").value =
        document.getElementById("CodIdBasres" + numero).innerHTML;
      $("#apps-modal129").modal("hide");
      $("#apps-modalz").modal("show");
    }
    if (m == 5) {
      document.getElementById("MarcaLPUTA2res").value = document.getElementById(
        "NombMLPres" + numero,
      ).innerHTML;
      document.getElementById("MarcaLPUTA1res").value = document.getElementById(
        "IdMLPres" + numero,
      ).innerHTML;
      $("#apps-modal129").modal("hide");
      $("#apps-modalz").modal("show");
    }
  }
  if (n == 3) {
    if (m == 1) {
      document.getElementById("DesdeAX2").value = document.getElementById(
        "Descrip" + numero,
      ).innerHTML;
      document.getElementById("DesdeAX").value = document.getElementById(
        "CodIdBas" + numero,
      ).innerHTML;
      document.getElementById("HastaAX2").value = document.getElementById(
        "Descrip" + numero,
      ).innerHTML;
      document.getElementById("HastaAX").value = document.getElementById(
        "CodIdBas" + numero,
      ).innerHTML;
      $("#apps-modal149").modal("hide");
      $("#apps-modalz").modal("show");
    }
    if (m == 2) {
      document.getElementById("HastaAX2").value = document.getElementById(
        "Descrip" + numero,
      ).innerHTML;
      document.getElementById("HastaAX").value = document.getElementById(
        "CodIdBas" + numero,
      ).innerHTML;
      $("#apps-modal149").modal("hide");
      $("#apps-modalz").modal("show");
    }
    if (m == 3) {
      document.getElementById("BeneficiarioAX2").value =
        document.getElementById("Nomb" + numero).innerHTML;
      document.getElementById("BeneficiarioAX").value = document.getElementById(
        "IdFiscal" + numero,
      ).innerHTML;
      $("#apps-modal149").modal("hide");
      $("#apps-modalz").modal("show");
    }
    if (m == 4) {
      document.getElementById("AlmacenAX2").value = document.getElementById(
        "NombD" + numero,
      ).innerHTML;
      document.getElementById("AlmacenAX").value = document.getElementById(
        "IdAlma" + numero,
      ).innerHTML;
      $("#apps-modal149").modal("hide");
      $("#apps-modalz").modal("show");
    }
  }
  if (n == 4) {
    if (m == 1) {
      document.getElementById("InstanciaLP").value = document.getElementById(
        "varios" + numero,
      ).innerHTML;
      document.getElementById("Instancia2LP").value = document.getElementById(
        "itemname" + numero,
      ).innerHTML;
      $("#apps-modal109").modal("hide");
      $("#apps-modalz").modal("show");
    }
    if (m == 2) {
      document.getElementById("CodigoDesde2LP").value = document.getElementById(
        "Descrip" + numero,
      ).innerHTML;
      document.getElementById("CodigoDesdeLP").value = document.getElementById(
        "CodIdBas" + numero,
      ).innerHTML;
      document.getElementById("CodigoHasta2LP").value = document.getElementById(
        "Descrip" + numero,
      ).innerHTML;
      document.getElementById("CodigoHastaLP").value = document.getElementById(
        "CodIdBas" + numero,
      ).innerHTML;
      $("#apps-modal109").modal("hide");
      $("#apps-modalz").modal("show");
    }
    if (m == 3) {
      document.getElementById("CodigoHasta2LP").value = document.getElementById(
        "Descrip" + numero,
      ).innerHTML;
      document.getElementById("CodigoHastaLP").value = document.getElementById(
        "CodIdBas" + numero,
      ).innerHTML;
      $("#apps-modal109").modal("hide");
      $("#apps-modalz").modal("show");
    }
    if (m == 5) {
      document.getElementById("Deposito2LP").value = document.getElementById(
        "NombD" + numero,
      ).innerHTML;
      document.getElementById("DepositoLP").value = document.getElementById(
        "IdAlma" + numero,
      ).innerHTML;
      $("#apps-modal109").modal("hide");
      $("#apps-modalz").modal("show");
    }
    if (m == 6) {
      document.getElementById("MarcaLPUTA2").value = document.getElementById(
        "NombMLP" + numero,
      ).innerHTML;
      document.getElementById("MarcaLPUTA1").value = document.getElementById(
        "IdMLP" + numero,
      ).innerHTML;
      $("#apps-modal109").modal("hide");
      $("#apps-modalz").modal("show");
    }
  }
  if (n == 5) {
    if (m == 1) {
      document.getElementById("FamiliaXX2").value = document.getElementById(
        "itemnameXX" + numero,
      ).innerHTML;
      document.getElementById("FamiliaXX").value = document.getElementById(
        "variosXX" + numero,
      ).innerHTML;
      $("#apps-modal159").modal("hide");
      $("#apps-modalz").modal("show");
    }
    if (m == 2) {
      document.getElementById("DesdeAXX2").value = document.getElementById(
        "DescripX" + numero,
      ).innerHTML;
      document.getElementById("DesdeAXX").value = document.getElementById(
        "CodIdBasX" + numero,
      ).innerHTML;
      document.getElementById("HastaAXX2").value = document.getElementById(
        "DescripX" + numero,
      ).innerHTML;
      document.getElementById("HastaAXX").value = document.getElementById(
        "CodIdBasX" + numero,
      ).innerHTML;
      $("#apps-modal159").modal("hide");
      $("#apps-modalz").modal("show");
    }
    if (m == 3) {
      document.getElementById("HastaAXX2").value = document.getElementById(
        "DescripX" + numero,
      ).innerHTML;
      document.getElementById("HastaAXX").value = document.getElementById(
        "CodIdBasX" + numero,
      ).innerHTML;
      $("#apps-modal159").modal("hide");
      $("#apps-modalz").modal("show");
    }
    if (m == 4) {
      document.getElementById("AlmacenAXX2").value = document.getElementById(
        "NombDXX" + numero,
      ).innerHTML;
      document.getElementById("AlmacenAXX").value = document.getElementById(
        "IdAlmaXX" + numero,
      ).innerHTML;
      $("#apps-modal159").modal("hide");
      $("#apps-modalz").modal("show");
    }
    if (m == 5) {
      document.getElementById("marAX2").value = document.getElementById(
        "NombMXX" + numero,
      ).innerHTML;
      document.getElementById("marAX").value = document.getElementById(
        "IdMXX" + numero,
      ).innerHTML;
      $("#apps-modal159").modal("hide");
      $("#apps-modalz").modal("show");
    }
  }
  if (n == 6) {
    if (m == 1) {
      document.getElementById("DesdeAX22z22Y").value = document.getElementById(
        "Descrip2" + numero,
      ).innerHTML;
      document.getElementById("DesdeAX2z2Y").value = document.getElementById(
        "CodIdBas2" + numero,
      ).innerHTML;
      document.getElementById("HastaAX22z2Y").value = document.getElementById(
        "Descrip2" + numero,
      ).innerHTML;
      document.getElementById("HastaAX2z2Y").value = document.getElementById(
        "CodIdBas2" + numero,
      ).innerHTML;
      $("#apps-modal31y2").modal("hide");
      $("#apps-modalz").modal("show");
    }
    if (m == 2) {
      document.getElementById("HastaAX22z2Y").value = document.getElementById(
        "Descrip2" + numero,
      ).innerHTML;
      document.getElementById("HastaAX2z2Y").value = document.getElementById(
        "CodIdBas2" + numero,
      ).innerHTML;
      $("#apps-modal31y2").modal("hide");
      $("#apps-modalz").modal("show");
    }
    if (m == 3) {
      document.getElementById("BeneficiarioAX22z2").value =
        document.getElementById("Nomb" + numero).innerHTML;
      document.getElementById("BeneficiarioAX2z2").value =
        document.getElementById("IdFiscal" + numero).innerHTML;
      $("#apps-modal31y2").modal("hide");
      $("#apps-modalz").modal("show");
    }
    if (m == 4) {
      document.getElementById("AlmacenAX22z2").value = document.getElementById(
        "NombD" + numero,
      ).innerHTML;
      document.getElementById("AlmacenAX2z2").value = document.getElementById(
        "IdAlma" + numero,
      ).innerHTML;
      $("#apps-modal31y2").modal("hide");
      $("#apps-modalz").modal("show");
    }
  }
  if (n == 7) {
    if (m == 1) {
      document.getElementById("DesdeAX22z").value = document.getElementById(
        "Descrip" + numero,
      ).innerHTML;
      document.getElementById("DesdeAX2z").value = document.getElementById(
        "CodIdBas" + numero,
      ).innerHTML;
      document.getElementById("HastaAX22z").value = document.getElementById(
        "Descrip" + numero,
      ).innerHTML;
      document.getElementById("HastaAX2z").value = document.getElementById(
        "CodIdBas" + numero,
      ).innerHTML;
      $("#apps-modal30y2").modal("hide");
      $("#apps-modalz").modal("show");
    }
    if (m == 2) {
      document.getElementById("HastaAX22z").value = document.getElementById(
        "Descrip" + numero,
      ).innerHTML;
      document.getElementById("HastaAX2z").value = document.getElementById(
        "CodIdBas" + numero,
      ).innerHTML;
      $("#apps-modal30y2").modal("hide");
      $("#apps-modalz").modal("show");
    }
    if (m == 3) {
      document.getElementById("BeneficiarioAX22z").value =
        document.getElementById("Nomb" + numero).innerHTML;
      document.getElementById("BeneficiarioAX2z").value =
        document.getElementById("IdFiscal" + numero).innerHTML;
      $("#apps-modal30y2").modal("hide");
      $("#apps-modalz").modal("show");
    }
    if (m == 4) {
      document.getElementById("AlmacenAX22z").value = document.getElementById(
        "NombD" + numero,
      ).innerHTML;
      document.getElementById("AlmacenAX2z").value = document.getElementById(
        "IdAlma" + numero,
      ).innerHTML;
      $("#apps-modal30y2").modal("hide");
      $("#apps-modalz").modal("show");
    }
  }
  if (n == 8) {
    if (m == 1) {
      document.getElementById("Producto32").value = document.getElementById(
        "DESSE2" + numero,
      ).innerHTML;
      document.getElementById("Producto22").value = document.getElementById(
        "CODSE2" + numero,
      ).innerHTML;
      $("#apps-modal215").modal("hide");
      $("#apps-modalz").modal("show");
    }
    if (m == 2) {
      document.getElementById("BeneficiarioSE222").value =
        document.getElementById("NombSE2" + numero).innerHTML;
      document.getElementById("BeneficiarioSE22").value =
        document.getElementById("IdFiscalSE2" + numero).innerHTML;
      $("#apps-modal215").modal("hide");
      $("#apps-modalz").modal("show");
    }
    if (m == 3) {
      document.getElementById("Cliente32").value = document.getElementById(
        "NombreLOGIN2" + numero,
      ).innerHTML;
      document.getElementById("Cliente22").value = document.getElementById(
        "login2" + numero,
      ).innerHTML;
      $("#apps-modal215").modal("hide");
      $("#apps-modalz").modal("show");
    }
  }
  if (n == 9) {
    if (m == 1) {
      document.getElementById("Producto3").value = document.getElementById(
        "DESSE" + numero,
      ).innerHTML;
      document.getElementById("Producto2").value = document.getElementById(
        "CODSE" + numero,
      ).innerHTML;
      $("#apps-modal139").modal("hide");
      $("#apps-modalz").modal("show");
    }
    if (m == 2) {
      document.getElementById("BeneficiarioSE2").value =
        document.getElementById("NombSE" + numero).innerHTML;
      document.getElementById("BeneficiarioSE").value = document.getElementById(
        "IdFiscalSE" + numero,
      ).innerHTML;
      $("#apps-modal139").modal("hide");
      $("#apps-modalz").modal("show");
    }
    if (m == 3) {
      document.getElementById("Cliente3").value = document.getElementById(
        "NombSEE" + numero,
      ).innerHTML;
      document.getElementById("Cliente2").value = document.getElementById(
        "IdFiscalSEE" + numero,
      ).innerHTML;
      $("#apps-modal139").modal("hide");
      $("#apps-modalz").modal("show");
    }
  }
  if (n == 10) {
    if (m == 2) {
      document.getElementById("CodigoDesde2LPRESX").value =
        document.getElementById("DescripX" + numero).innerHTML;
      document.getElementById("CodigoDesdeLPRESX").value =
        document.getElementById("CodIdBasX" + numero).innerHTML;
      document.getElementById("CodigoHasta2LPRESX").value =
        document.getElementById("DescripX" + numero).innerHTML;
      document.getElementById("CodigoHastaLPRESX").value =
        document.getElementById("CodIdBasX" + numero).innerHTML;
      $("#apps-modal189").modal("hide");
      $("#apps-modalz").modal("show");
    }
    if (m == 3) {
      document.getElementById("CodigoHasta2LPRESX").value =
        document.getElementById("DescripRESX" + numero).innerHTML;
      document.getElementById("CodigoHastaLPRESX").value =
        document.getElementById("CodIdBasRESX" + numero).innerHTML;
      $("#apps-modal189").modal("hide");
      $("#apps-modalz").modal("show");
    }
    if (m == 4) {
      document.getElementById("MarcaDetal2").value = document.getElementById(
        "NombMLPRESX" + numero,
      ).innerHTML;
      document.getElementById("MarcaDetal").value = document.getElementById(
        "IdMLPRESX" + numero,
      ).innerHTML;
      $("#apps-modal189").modal("hide");
      $("#apps-modalz").modal("show");
    }
  }
  if (n == 11) {
    if (m == 2) {
      document.getElementById("CodigoDesde2LPRES").value =
        document.getElementById("Descrip" + numero).innerHTML;
      document.getElementById("CodigoDesdeLPRES").value =
        document.getElementById("CodIdBas" + numero).innerHTML;
      document.getElementById("CodigoHasta2LPRES").value =
        document.getElementById("Descrip" + numero).innerHTML;
      document.getElementById("CodigoHastaLPRES").value =
        document.getElementById("CodIdBas" + numero).innerHTML;
      $("#apps-modal119").modal("hide");
      $("#apps-modalz").modal("show");
    }
    if (m == 3) {
      document.getElementById("CodigoHasta2LPRES").value =
        document.getElementById("Descrip" + numero).innerHTML;
      document.getElementById("CodigoHastaLPRES").value =
        document.getElementById("CodIdBas" + numero).innerHTML;
      $("#apps-modal119").modal("hide");
      $("#apps-modalz").modal("show");
    }
  }
  if (n == 12) {
    if (m == 2) {
      document.getElementById("CodigoDesde2LPRESG").value =
        document.getElementById("DescripG" + numero).innerHTML;
      document.getElementById("CodigoDesdeLPRESG").value =
        document.getElementById("CodIdBasG" + numero).innerHTML;
      document.getElementById("CodigoHasta2LPRESG").value =
        document.getElementById("DescripG" + numero).innerHTML;
      document.getElementById("CodigoHastaLPRESG").value =
        document.getElementById("CodIdBasG" + numero).innerHTML;
      $("#apps-modal229").modal("hide");
      $("#apps-modalz").modal("show");
    }
    if (m == 3) {
      document.getElementById("CodigoHasta2LPRESG").value =
        document.getElementById("DescripG" + numero).innerHTML;
      document.getElementById("CodigoHastaLPRESG").value =
        document.getElementById("CodIdBasG" + numero).innerHTML;
      $("#apps-modal229").modal("hide");
      $("#apps-modalz").modal("show");
    }
  }
  if (n == 13) {
    if (m == 1) {
      document.getElementById("productoinv2").value = document.getElementById(
        "DescripG" + numero,
      ).innerHTML;
      document.getElementById("productoinv").value = document.getElementById(
        "CodIdBasG" + numero,
      ).innerHTML;
      $("#apps-modal230").modal("hide");
      $("#apps-modalz").modal("show");
    }
    if (m == 2) {
      document.getElementById("marcainv").value = document.getElementById(
        "IdMLPRESX" + numero,
      ).innerHTML;
      document.getElementById("marcainv2").value = document.getElementById(
        "NombMLPRESX" + numero,
      ).innerHTML;
      $("#apps-modal230").modal("hide");
      $("#apps-modalz").modal("show");
    }
  }
}

function familia() {
  var valor3 = document.getElementById("InstanciaNK").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "12",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg !== 0) {
      $("#devueltachavales").html(msg);
      document.getElementById("Instancia2NK").value =
        document.getElementById("Nombreitemxd").innerHTML;
    }
  });
}

function CodigoDes() {
  var valor3 = document.getElementById("CodigoDesde").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "13",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg !== 0) {
      $("#CodigoDesaL").html(msg);
      document.getElementById("CodigoDesde2").value =
        document.getElementById("DesdeNome").innerHTML;
      document.getElementById("CodigoHasta2").value =
        document.getElementById("DesdeNome").innerHTML;
      document.getElementById("CodigoHasta").value =
        document.getElementById("DesdeCod").innerHTML;
    }
  });
}

function CodigoHas() {
  var valor3 = document.getElementById("CodigoHasta").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "14",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg !== 0) {
      $("#CodigoHasaL").html(msg);
      document.getElementById("CodigoHasta2").value =
        document.getElementById("NomeHasta").innerHTML;
    }
  });
}

function Benefe() {
  var valor3 = document.getElementById("Proevedor").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "15",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg !== 0) {
      $("#BenefeL").html(msg);
      document.getElementById("Proevedor2").value =
        document.getElementById("NomeBene").innerHTML;
    }
  });
}

function Alma() {
  var valor3 = document.getElementById("DepositoNK").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "16",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg !== 0) {
      $("#AlmaL").html(msg);
      document.getElementById("Deposito2NK").value =
        document.getElementById("AlmaNome").innerHTML;
    }
  });
}

function Mar(input1, input2) {
  if (input1 != "") {
    var valor3 = document.getElementById(input1).value;
  } else {
    var valor3 = document.getElementById("Marca").value;
  }
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "17",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg !== 0) {
      $("#MarL").html(msg);
      if (input1 != "") {
        document.getElementById(input2).value =
          document.getElementById("MarName").innerHTML;
      } else {
        document.getElementById("Marca2").value =
          document.getElementById("MarName").innerHTML;
      }
    }
  });
}

function CodigoDesAX() {
  var valor3 = document.getElementById("DesdeAX").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "1XAX",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#CodigoDesaAX").html(msg);
      document.getElementById("DesdeAX2").value =
        document.getElementById("DesdeNomeAX").innerHTML;
      document.getElementById("HastaAX2").value =
        document.getElementById("DesdeNomeAX").innerHTML;
      document.getElementById("HastaAX").value =
        document.getElementById("DesdeCodAX").innerHTML;
    }
  });
}

function CodigoHasAX() {
  var valor3 = document.getElementById("HastaAX").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "2XAX",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#CodigoHasaAX").html(msg);
      document.getElementById("HastaAX2").value =
        document.getElementById("NomeHastaAX").innerHTML;
    }
  });
}

function BenefeAX() {
  var valor3 = document.getElementById("BeneficiarioAX").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "3XAX",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#BenefeAX").html(msg);
      document.getElementById("BeneficiarioAX2").value =
        document.getElementById("NomeBeneAX").innerHTML;
    }
  });
}

function AlmaAX() {
  var valor3 = document.getElementById("AlmacenAX").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "4XAX",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#AlmaAX").html(msg);
      document.getElementById("AlmacenAX2").value =
        document.getElementById("AlmaNomeAX").innerHTML;
    }
  });
}

function familiaLP() {
  var valor3 = document.getElementById("InstanciaLP").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "12LP",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#devueltachavalesLP").html(msg);
      document.getElementById("Instancia2LP").value =
        document.getElementById("NombreitemxdLP").innerHTML;
    }
  });
}

function CodigoDesLP() {
  var valor3 = document.getElementById("CodigoDesdeLP").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "13LP",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#CodigoDesaLLP").html(msg);
      document.getElementById("CodigoDesde2LP").value =
        document.getElementById("DesdeNomeLP").innerHTML;
      document.getElementById("CodigoHasta2LP").value =
        document.getElementById("DesdeNomeLP").innerHTML;
      document.getElementById("CodigoHastaLP").value =
        document.getElementById("DesdeCodLP").innerHTML;
    }
  });
}

function CodigoHasLP() {
  var valor3 = document.getElementById("CodigoHastaLP").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "14LP",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#CodigoHasaLLP").html(msg);
      document.getElementById("CodigoHasta2LP").value =
        document.getElementById("NomeHastaLP").innerHTML;
    }
  });
}

function BenefeLP() {
  var valor3 = document.getElementById("ProevedorLP").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "15LP",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#BenefeLLP").html(msg);
      document.getElementById("Proevedor2LP").value =
        document.getElementById("NomeBeneLP").innerHTML;
    }
  });
}

function AlmaLP() {
  var valor3 = document.getElementById("DepositoLP").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "16LP",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#AlmaLLP").html(msg);
      document.getElementById("Deposito2LP").value =
        document.getElementById("AlmaNomeLP").innerHTML;
    }
  });
}

function MarLP() {
  var valor3 = document.getElementById("MarcaLPUTA1").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "17LP",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#MarLLP").html(msg);
      document.getElementById("MarcaLPUTA2").value =
        document.getElementById("MarcaLP").innerHTML;
    }
  });
}

function RefLP() {
  var valor3 = document.getElementById("RefLP1").value;
  if (document.getElementById("RefLP1").value == "") {
    document.getElementById("RefLP2").value = " ";
  }
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "18LP",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#EstaGUEVONA").html(msg);
      document.getElementById("RefLP2").value =
        document.getElementById("refnameLP").innerHTML;
    }
  });
}

function intanciaAXX() {
  var valor3 = document.getElementById("FamiliaXX").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "1VEX",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#devueltachavalesAXX").html(msg);
      document.getElementById("FamiliaXX2").value =
        document.getElementById("NombreitemxdAXX").innerHTML;
    }
  });
}

function CodigoDesAXX() {
  var valor3 = document.getElementById("DesdeAXX").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "2VEX",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#CodigoDesaAXX").html(msg);
      document.getElementById("DesdeAXX2").value =
        document.getElementById("DesdeNomeAXX").innerHTML;
      document.getElementById("HastaAXX2").value =
        document.getElementById("DesdeNomeAXX").innerHTML;
      document.getElementById("HastaAXX").value =
        document.getElementById("DesdeCodAXX").innerHTML;
    }
  });
}

function CodigoHasAXX() {
  var valor3 = document.getElementById("HastaAXX").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "3VEX",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#CodigoHasaAXX").html(msg);
      document.getElementById("HastaAXX2").value =
        document.getElementById("NomeHastaAXX").innerHTML;
    }
  });
}

function AlmaAXX() {
  var valor3 = document.getElementById("AlmacenAXX").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "4VEX",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#AlmaAXX").html(msg);
      document.getElementById("AlmacenAXX2").value =
        document.getElementById("AlmaNomeAXX").innerHTML;
    }
  });
}

function MarcaAXX() {
  var valor3 = document.getElementById("marAX").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "5VEX",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#BenefeAXX").html(msg);
      document.getElementById("marAX2").value =
        document.getElementById("MarNameAXX").innerHTML;
    }
  });
}

function CodigoDesAX2pz2() {
  var valor3 = document.getElementById("DesdeAX2z2Y").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "1XAX22y",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#CodigoDesaAX2z2").html(msg);
      document.getElementById("DesdeAX22z22Y").value =
        document.getElementById("DesdeNomeAXm2").innerHTML;
      document.getElementById("HastaAX22z2Y").value =
        document.getElementById("DesdeNomeAXm2").innerHTML;
      document.getElementById("HastaAX2z2Y").value =
        document.getElementById("DesdeCodAXm2").innerHTML;
    }
  });
}

function CodigoHasAX2pzz2() {
  document.getElementById("HastaAX22z2Y").value = "";
  var valor3 = document.getElementById("HastaAX2z2Y").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "2XAX22",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#CodigoHasaAX2z2").html(msg);
      document.getElementById("HastaAX22z2Y").value =
        document.getElementById("NomeHastaAX2").innerHTML;
    }
  });
}

function BenefeAX22() {
  document.getElementById("BeneficiarioAX22z2").value = "";
  var valor3 = document.getElementById("BeneficiarioAX2z2").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "3XAX22",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#BenefeAX2z2").html(msg);
      document.getElementById("BeneficiarioAX22z2").value =
        document.getElementById("NomeBeneAX2").innerHTML;
    }
  });
}

function AlmaAX22() {
  document.getElementById("AlmacenAX22z2").value = "";
  var valor3 = document.getElementById("AlmacenAX2z2").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "4XAX22",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#AlmaAX2z2").html(msg);
      document.getElementById("AlmacenAX22z2").value =
        document.getElementById("AlmaNomeAX2").innerHTML;
    }
  });
}

function CodigoDesAX2pz() {
  var valor3 = document.getElementById("DesdeAX2z").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "1XAX2",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#CodigoDesaAX2z").html(msg);
      document.getElementById("DesdeAX22z").value =
        document.getElementById("DesdeNomeAXm").innerHTML;
      document.getElementById("HastaAX22z").value =
        document.getElementById("DesdeNomeAXm").innerHTML;
      document.getElementById("HastaAX2z").value =
        document.getElementById("DesdeCodAXm").innerHTML;
    }
  });
}

function CodigoHasAX2pzz() {
  var valor3 = document.getElementById("HastaAX2z").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "2XAX2",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#CodigoHasaAX2z").html(msg);
      document.getElementById("HastaAX22z").value =
        document.getElementById("NomeHastaAX").innerHTML;
    }
  });
}

function BenefeAX2() {
  var valor3 = document.getElementById("BeneficiarioAX2z").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "3XAX2",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#BenefeAX2z").html(msg);
      document.getElementById("BeneficiarioAX22z").value =
        document.getElementById("NomeBeneAX").innerHTML;
    }
  });
}

function AlmaAX2() {
  var valor3 = document.getElementById("AlmacenAX2z").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "4XAX2",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#AlmaAX2z").html(msg);
      document.getElementById("AlmacenAX22z").value =
        document.getElementById("AlmaNomeAX").innerHTML;
    }
  });
}

function PagineoSE2(n) {
  document.getElementById("PagActSE2").innerHTML = n;
  MuestraSeriales2();
}

function MuestraSeriales2() {
  var valor = document.getElementById("PagActSE2").innerHTML;
  var valor2 = document.getElementById("RpaSE2").innerHTML;
  var valor3 = document.getElementById("search-prodSE2").value;
  var valor4 = document.getElementById("LimitSE2").value;
  if (document.getElementById("OrganizadorSE2").value == "1") {
    $.ajax({
      type: "POST",
      url: "dataseekled.php",
      data: {
        IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
        litfiscal: document.getElementById("litfiscal").innerHTML,
        direccion: document.getElementById("direccionActSe").innerHTML,
        NameCompany: document.getElementById("NameCompany").innerHTML,
        Accion: "1SE23",
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        sucursal: document.getElementById("sucursal").innerHTML,
        Search: valor3,
        Company: document.getElementById("CompanyActual").innerHTML,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobuscaSE2").html(msg);
    });
  }
  if (document.getElementById("OrganizadorSE2").value == "2") {
    $.ajax({
      type: "POST",
      url: "dataseekled.php",
      data: {
        IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
        litfiscal: document.getElementById("litfiscal").innerHTML,
        direccion: document.getElementById("direccionActSe").innerHTML,
        NameCompany: document.getElementById("NameCompany").innerHTML,
        Accion: "2SE2",
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        sucursal: document.getElementById("sucursal").innerHTML,
        Search: valor3,
        Company: document.getElementById("CompanyActual").innerHTML,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobuscaSE2").html(msg);
    });
  }
  if (document.getElementById("OrganizadorSE2").value == "3") {
    $.ajax({
      type: "POST",
      url: "dataseekled.php",
      data: {
        IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
        litfiscal: document.getElementById("litfiscal").innerHTML,
        direccion: document.getElementById("direccionActSe").innerHTML,
        NameCompany: document.getElementById("NameCompany").innerHTML,
        Accion: "3SE2",
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        sucursal: document.getElementById("sucursal").innerHTML,
        Search: valor3,
        Company: document.getElementById("CompanyActual").innerHTML,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobuscaSE2").html(msg);
    });
  }
}

function insertarcodigodesdeSE2(numero) {
  document.getElementById("CODSE2" + numero).innerHTML;
  document.getElementById("DESSE2" + numero).innerHTML;
  document.getElementById("Producto32").value = document.getElementById(
    "DESSE2" + numero,
  ).innerHTML;
  document.getElementById("Producto22").value = document.getElementById(
    "CODSE2" + numero,
  ).innerHTML;
}

function InsertaproevedorSE2(numero) {
  document.getElementById("NombSE2" + numero).innerHTML;
  document.getElementById("IdFiscalSE2" + numero).innerHTML;
  document.getElementById("BeneficiarioSE222").value = document.getElementById(
    "NombSE2" + numero,
  ).innerHTML;
  document.getElementById("BeneficiarioSE22").value = document.getElementById(
    "IdFiscalSE2" + numero,
  ).innerHTML;
}

function InsertaCLIENTESE22(numero) {
  document.getElementById("login2" + numero).innerHTML;
  document.getElementById("NombreLOGIN2" + numero).innerHTML;
  document.getElementById("Cliente32").value = document.getElementById(
    "NombreLOGIN2" + numero,
  ).innerHTML;
  document.getElementById("Cliente22").value = document.getElementById(
    "login2" + numero,
  ).innerHTML;
}

function Producto2() {
  var valor3 = document.getElementById("Producto22").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "EnProd2",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#devueltachavalesSE2").html(msg);
      document.getElementById("Producto32").value =
        document.getElementById("DesdeNomeSE2").innerHTML;
    }
  });
}

function BenefeSE2() {
  var valor3 = document.getElementById("BeneficiarioSE22").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "Seben2",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#BenefeSE2").html(msg);
      document.getElementById("BeneficiarioSE222").value =
        document.getElementById("NomeBeneSEpe2").innerHTML;
    }
  });
}

function vendedor() {
  var valor3 = document.getElementById("Cliente22").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "SeCIEN2",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#AlmaSE2").html(msg);
      document.getElementById("Cliente32").value =
        document.getElementById("NomeBeneSEas2").innerHTML;
    }
  });
}

function PagineoSE(n) {
  document.getElementById("PagActSE").innerHTML = n;
  MuestraSeriales();
}

function MuestraSeriales() {
  var valor = document.getElementById("PagActSE").innerHTML;
  var valor2 = document.getElementById("RpaSE").innerHTML;
  var valor3 = document.getElementById("search-prodSE").value;
  var valor4 = document.getElementById("LimitSE").value;
  if (document.getElementById("OrganizadorSE").value == "1") {
    $.ajax({
      type: "POST",
      url: "dataseekled.php",
      data: {
        IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
        litfiscal: document.getElementById("litfiscal").innerHTML,
        direccion: document.getElementById("direccionActSe").innerHTML,
        NameCompany: document.getElementById("NameCompany").innerHTML,
        Accion: "1SE",
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        sucursal: document.getElementById("sucursal").innerHTML,
        Search: valor3,
        Company: document.getElementById("CompanyActual").innerHTML,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobuscaSE").html(msg);
    });
  }
  if (document.getElementById("OrganizadorSE").value == "2") {
    $.ajax({
      type: "POST",
      url: "dataseekled.php",
      data: {
        IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
        litfiscal: document.getElementById("litfiscal").innerHTML,
        direccion: document.getElementById("direccionActSe").innerHTML,
        NameCompany: document.getElementById("NameCompany").innerHTML,
        Accion: "2SE",
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        sucursal: document.getElementById("sucursal").innerHTML,
        Search: valor3,
        Company: document.getElementById("CompanyActual").innerHTML,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobuscaSE").html(msg);
    });
  }
  if (document.getElementById("OrganizadorSE").value == "3") {
    $.ajax({
      type: "POST",
      url: "dataseekled.php",
      data: {
        IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
        litfiscal: document.getElementById("litfiscal").innerHTML,
        direccion: document.getElementById("direccionActSe").innerHTML,
        NameCompany: document.getElementById("NameCompany").innerHTML,
        Accion: "3SE",
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        sucursal: document.getElementById("sucursal").innerHTML,
        Search: valor3,
        Company: document.getElementById("CompanyActual").innerHTML,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobuscaSE").html(msg);
    });
  }
}

function insertarcodigodesdeSE(numero) {
  document.getElementById("CODSE" + numero).innerHTML;
  document.getElementById("DESSE" + numero).innerHTML;
  document.getElementById("Producto3").value = document.getElementById(
    "DESSE" + numero,
  ).innerHTML;
  document.getElementById("Producto2").value = document.getElementById(
    "CODSE" + numero,
  ).innerHTML;
}

function InsertaproevedorSE(numero) {
  document.getElementById("NombSE" + numero).innerHTML;
  document.getElementById("IdFiscalSE" + numero).innerHTML;
  document.getElementById("BeneficiarioSE2").value = document.getElementById(
    "NombSE" + numero,
  ).innerHTML;
  document.getElementById("BeneficiarioSE").value = document.getElementById(
    "IdFiscalSE" + numero,
  ).innerHTML;
}

function InsertaCLIENTESE(numero) {
  document.getElementById("NombSEE" + numero).innerHTML;
  document.getElementById("IdFiscalSEE" + numero).innerHTML;
  document.getElementById("Cliente3").value = document.getElementById(
    "NombSEE" + numero,
  ).innerHTML;
  document.getElementById("Cliente2").value = document.getElementById(
    "IdFiscalSEE" + numero,
  ).innerHTML;
}

function Producto() {
  var valor3 = document.getElementById("Producto2").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "EnProd",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#devueltachavalesSE").html(msg);
      document.getElementById("Producto3").value =
        document.getElementById("DesdeNomeSE").innerHTML;
    }
  });
}

function BenefeSE() {
  var valor3 = document.getElementById("BeneficiarioSE").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "Seben",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#BenefeSE").html(msg);
      document.getElementById("BeneficiarioSE2").value =
        document.getElementById("NomeBeneSEpe").innerHTML;
    }
  });
}

function Clientado() {
  var valor3 = document.getElementById("Cliente2").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "SeCIEN",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#BenefeLLPRES").html(msg);
      document.getElementById("Cliente3").value =
        document.getElementById("NomeBeneSEas").innerHTML;
    }
  });
}

function PagineoLPRESX(n) {
  document.getElementById("PagActLPRESX").innerHTML = n;
  MuestraProdLPRESX();
}

function MuestraProdLPRESX() {
  var valor = document.getElementById("PagActLPRESX").innerHTML;
  var valor2 = document.getElementById("RpaLPRESX").innerHTML;
  var valor3 = document.getElementById("search-prodLPRESX").value;
  var valor4 = document.getElementById("LimitLPRESX").value;
  if (document.getElementById("OrganizadorLPRESX").value == "1") {
    $.ajax({
      type: "POST",
      url: "dataseekled.php",
      data: {
        IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
        litfiscal: document.getElementById("litfiscal").innerHTML,
        direccion: document.getElementById("direccionActSe").innerHTML,
        NameCompany: document.getElementById("NameCompany").innerHTML,
        Accion: "0LPRESX",
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        sucursal: document.getElementById("sucursal").innerHTML,
        Search: valor3,
        Company: document.getElementById("CompanyActual").innerHTML,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobuscaLPRESX").html(msg);
    });
  }
  if (document.getElementById("OrganizadorLPRESX").value == "2") {
    $.ajax({
      type: "POST",
      url: "dataseekled.php",
      data: {
        IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
        litfiscal: document.getElementById("litfiscal").innerHTML,
        direccion: document.getElementById("direccionActSe").innerHTML,
        NameCompany: document.getElementById("NameCompany").innerHTML,
        Accion: "2LPRESX",
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        sucursal: document.getElementById("sucursal").innerHTML,
        Search: valor3,
        Company: document.getElementById("CompanyActual").innerHTML,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobuscaLPRESX").html(msg);
    });
  }
  if (document.getElementById("OrganizadorLPRESX").value == "3") {
    $.ajax({
      type: "POST",
      url: "dataseekled.php",
      data: {
        IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
        litfiscal: document.getElementById("litfiscal").innerHTML,
        direccion: document.getElementById("direccionActSe").innerHTML,
        NameCompany: document.getElementById("NameCompany").innerHTML,
        Accion: "3LPRESX",
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        sucursal: document.getElementById("sucursal").innerHTML,
        Search: valor3,
        Company: document.getElementById("CompanyActual").innerHTML,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobuscaLPRESX").html(msg);
    });
  }
  if (document.getElementById("OrganizadorLPRESX").value == "4") {
    $.ajax({
      type: "POST",
      url: "dataseekled.php",
      data: {
        IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
        litfiscal: document.getElementById("litfiscal").innerHTML,
        direccion: document.getElementById("direccionActSe").innerHTML,
        NameCompany: document.getElementById("NameCompany").innerHTML,
        Accion: "4LPRESX",
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        sucursal: document.getElementById("sucursal").innerHTML,
        Search: valor3,
        Company: document.getElementById("CompanyActual").innerHTML,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobuscaLPRESX").html(msg);
    });
  }
  if (document.getElementById("OrganizadorLPRESX").value == "5") {
    $.ajax({
      type: "POST",
      url: "dataseekled.php",
      data: {
        IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
        litfiscal: document.getElementById("litfiscal").innerHTML,
        direccion: document.getElementById("direccionActSe").innerHTML,
        NameCompany: document.getElementById("NameCompany").innerHTML,
        Accion: "5LPRESX",
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        sucursal: document.getElementById("sucursal").innerHTML,
        Search: valor3,
        Company: document.getElementById("CompanyActual").innerHTML,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobuscaLPRESX").html(msg);
    });
  }
}

function tomartintanciaLPRESX(numero) {
  document.getElementById("varios" + numero).innerHTML;
  document.getElementById("itemname" + numero).innerHTML;
  document.getElementById("InstanciaLPRESX").value = document.getElementById(
    "variosX" + numero,
  ).innerHTML;
  document.getElementById("Instancia2LPRESX").value = document.getElementById(
    "itemnameX" + numero,
  ).innerHTML;
}

function insertarcodigodesdeLPRESX(numero) {
  document.getElementById("CodIdBasX" + numero).innerHTML;
  document.getElementById("DescripX" + numero).innerHTML;
  document.getElementById("CodigoDesde2LPRESX").value = document.getElementById(
    "DescripX" + numero,
  ).innerHTML;
  document.getElementById("CodigoDesdeLPRESX").value = document.getElementById(
    "CodIdBasX" + numero,
  ).innerHTML;
  document.getElementById("CodigoHasta2LPRESX").value = document.getElementById(
    "DescripX" + numero,
  ).innerHTML;
  document.getElementById("CodigoHastaLPRESX").value = document.getElementById(
    "CodIdBasX" + numero,
  ).innerHTML;
}

function InsertacodigohastaLPRESX(numero) {
  document.getElementById("CodIdBasRESX" + numero).innerHTML;
  document.getElementById("DescripRESX" + numero).innerHTML;
  document.getElementById("CodigoHasta2LPRESX").value = document.getElementById(
    "DescripRESX" + numero,
  ).innerHTML;
  document.getElementById("CodigoHastaLPRESX").value = document.getElementById(
    "CodIdBasRESX" + numero,
  ).innerHTML;
}

function insertaMarcaLPRESX(numero) {
  document.getElementById("NombMLPRESX" + numero).innerHTML;
  document.getElementById("IdMLPRESX" + numero).innerHTML;
  document.getElementById("MarcaDetal2").value = document.getElementById(
    "NombMLPRESX" + numero,
  ).innerHTML;
  document.getElementById("MarcaDetal").value = document.getElementById(
    "IdMLPRESX" + numero,
  ).innerHTML;
}

function InsertadepositoLPRESX(numero) {
  document.getElementById("NombDX" + numero).innerHTML;
  document.getElementById("IdAlmaX" + numero).innerHTML;
  document.getElementById("Deposito2LPRESX").value = document.getElementById(
    "NombDX" + numero,
  ).innerHTML;
  document.getElementById("DepositoLPRESX").value = document.getElementById(
    "IdAlmaX" + numero,
  ).innerHTML;
}

function familiaLPRESX() {
  var valor3 = document.getElementById("InstanciaLPRESX").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "12LPRESX",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#devueltachavalesLPRESX").html(msg);
      document.getElementById("Instancia2LPRESX").value =
        document.getElementById("Nombreitemxdres").innerHTML;
    }
  });
}

function CodigoDesLPRESX() {
  var valor3 = document.getElementById("CodigoDesdeLPRESX").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "13LPRESX",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#CodigoDesaLLPRESX").html(msg);
      document.getElementById("CodigoDesde2LPRESX").value =
        document.getElementById("DesdeNomeRESX").innerHTML;
      document.getElementById("CodigoHasta2LPRESX").value =
        document.getElementById("DesdeNomeRESX").innerHTML;
      document.getElementById("CodigoHastaLPRESX").value =
        document.getElementById("DesdeCodRESX").innerHTML;
    }
  });
}

function CodigoHasLPRESX() {
  var valor3 = document.getElementById("CodigoHastaLPRESX").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "14LPRESX",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#CodigoHasaLLPRESX").html(msg);
      document.getElementById("CodigoHasta2LPRESX").value =
        document.getElementById("NomeHastaRESX").innerHTML;
    }
  });
}

function MarcaEnterita() {
  var valor3 = document.getElementById("MarcaDetal").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "17LPREXMARCA",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#BenefeLLPRESX").html(msg);
      document.getElementById("MarcaDetal2").value =
        document.getElementById("MarName").innerHTML;
    }
  });
}

function AlmaLPRESX() {
  var valor3 = document.getElementById("DepositoLPRESX").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "16LPRESX",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#AlmaLLPRESX").html(msg);
      document.getElementById("Deposito2LPRESX").value =
        document.getElementById("AlmaNomeRESX").innerHTML;
    }
  });
}

function PagineoLPRES(n) {
  document.getElementById("PagActLPRES").innerHTML = n;
  MuestraProdLPRES();
}

function MuestraProdLPRES() {
  var valor = document.getElementById("PagActLPRES").innerHTML;
  var valor2 = document.getElementById("RpaLPRES").innerHTML;
  var valor3 = document.getElementById("search-prodLPRES").value;
  var valor4 = document.getElementById("LimitLPRES").value;
  if (document.getElementById("OrganizadorLPRES").value == "1") {
    $.ajax({
      type: "POST",
      url: "dataseekled.php",
      data: {
        IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
        litfiscal: document.getElementById("litfiscal").innerHTML,
        direccion: document.getElementById("direccionActSe").innerHTML,
        NameCompany: document.getElementById("NameCompany").innerHTML,
        Accion: "0LPRES",
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        sucursal: document.getElementById("sucursal").innerHTML,
        Search: valor3,
        Company: document.getElementById("CompanyActual").innerHTML,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobuscaLPRES").html(msg);
    });
  }
  if (document.getElementById("OrganizadorLPRES").value == "2") {
    $.ajax({
      type: "POST",
      url: "dataseekled.php",
      data: {
        IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
        litfiscal: document.getElementById("litfiscal").innerHTML,
        direccion: document.getElementById("direccionActSe").innerHTML,
        NameCompany: document.getElementById("NameCompany").innerHTML,
        Accion: "2LPRES",
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        sucursal: document.getElementById("sucursal").innerHTML,
        Search: valor3,
        Company: document.getElementById("CompanyActual").innerHTML,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobuscaLPRES").html(msg);
    });
  }
  if (document.getElementById("OrganizadorLPRES").value == "3") {
    $.ajax({
      type: "POST",
      url: "dataseekled.php",
      data: {
        IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
        litfiscal: document.getElementById("litfiscal").innerHTML,
        direccion: document.getElementById("direccionActSe").innerHTML,
        NameCompany: document.getElementById("NameCompany").innerHTML,
        Accion: "3LPRES",
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        sucursal: document.getElementById("sucursal").innerHTML,
        Search: valor3,
        Company: document.getElementById("CompanyActual").innerHTML,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobuscaLPRES").html(msg);
    });
  }
  if (document.getElementById("OrganizadorLPRES").value == "4") {
    $.ajax({
      type: "POST",
      url: "dataseekled.php",
      data: {
        IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
        litfiscal: document.getElementById("litfiscal").innerHTML,
        direccion: document.getElementById("direccionActSe").innerHTML,
        NameCompany: document.getElementById("NameCompany").innerHTML,
        Accion: "4LPRES",
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        sucursal: document.getElementById("sucursal").innerHTML,
        Search: valor3,
        Company: document.getElementById("CompanyActual").innerHTML,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobuscaLPRES").html(msg);
    });
  }
  if (document.getElementById("OrganizadorLPRES").value == "5") {
    $.ajax({
      type: "POST",
      url: "dataseekled.php",
      data: {
        IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
        litfiscal: document.getElementById("litfiscal").innerHTML,
        direccion: document.getElementById("direccionActSe").innerHTML,
        NameCompany: document.getElementById("NameCompany").innerHTML,
        Accion: "5LPRES",
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        sucursal: document.getElementById("sucursal").innerHTML,
        Search: valor3,
        Company: document.getElementById("CompanyActual").innerHTML,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobuscaLPRES").html(msg);
    });
  }
}

function tomartintanciaLPRES(numero) {
  document.getElementById("varios" + numero).innerHTML;
  document.getElementById("itemname" + numero).innerHTML;
  document.getElementById("InstanciaLPRES").value = document.getElementById(
    "varios" + numero,
  ).innerHTML;
  document.getElementById("Instancia2LPRES").value = document.getElementById(
    "itemname" + numero,
  ).innerHTML;
}

function insertarcodigodesdeLPRES(numero) {
  document.getElementById("CodIdBas" + numero).innerHTML;
  document.getElementById("Descrip" + numero).innerHTML;
  document.getElementById("CodigoDesde2LPRES").value = document.getElementById(
    "Descrip" + numero,
  ).innerHTML;
  document.getElementById("CodigoDesdeLPRES").value = document.getElementById(
    "CodIdBas" + numero,
  ).innerHTML;
  document.getElementById("CodigoHasta2LPRES").value = document.getElementById(
    "Descrip" + numero,
  ).innerHTML;
  document.getElementById("CodigoHastaLPRES").value = document.getElementById(
    "CodIdBas" + numero,
  ).innerHTML;
}

function InsertacodigohastaLPRES(numero) {
  document.getElementById("CodIdBasRES" + numero).innerHTML;
  document.getElementById("DescripRES" + numero).innerHTML;
  document.getElementById("CodigoHasta2LPRES").value = document.getElementById(
    "DescripRES" + numero,
  ).innerHTML;
  document.getElementById("CodigoHastaLPRES").value = document.getElementById(
    "CodIdBasRES" + numero,
  ).innerHTML;
}

function InsertaproevedorLPRES(numero) {
  document.getElementById("Nomb" + numero).innerHTML;
  document.getElementById("IdFiscal" + numero).innerHTML;
  document.getElementById("Proevedor2LPRES").value = document.getElementById(
    "Nomb" + numero,
  ).innerHTML;
  document.getElementById("ProevedorLPRES").value = document.getElementById(
    "IdFiscal" + numero,
  ).innerHTML;
}

function InsertadepositoLPRES(numero) {
  document.getElementById("NombD" + numero).innerHTML;
  document.getElementById("IdAlma" + numero).innerHTML;
  document.getElementById("Deposito2LPRES").value = document.getElementById(
    "NombD" + numero,
  ).innerHTML;
  document.getElementById("DepositoLPRES").value = document.getElementById(
    "IdAlma" + numero,
  ).innerHTML;
}

function familiaLPRES() {
  var valor3 = document.getElementById("InstanciaLPRES").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "12LPRES",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#devueltachavalesLPRES").html(msg);
      document.getElementById("Instancia2LPRES").value =
        document.getElementById("Nombreitemxdres").innerHTML;
    }
  });
}

function CodigoDesLPRES() {
  var valor3 = document.getElementById("CodigoDesdeLPRES").value;
  document.getElementById("CodigoHastaLPRES").value = valor3;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "13LPRES",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#CodigoDesaLLPRES").html(msg);
      document.getElementById("CodigoDesde2LPRES").value =
        document.getElementById("DesdeNomeRES").innerHTML;
      document.getElementById("CodigoHasta2LPRES").value =
        document.getElementById("DesdeNomeRES").innerHTML;
    }
  });
}

function CodigoHasLPRES() {
  var valor3 = document.getElementById("CodigoHastaLPRES").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "14LPRES",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#CodigoHasaLLPRES").html(msg);
      document.getElementById("CodigoHasta2LPRES").value =
        document.getElementById("NomeHastaRES").innerHTML;
    }
  });
}

function BenefeLPRES() {
  var valor3 = document.getElementById("ProevedorLPRES").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "15LPRES",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#BenefeLLPRES").html(msg);
      document.getElementById("Proevedor2LPRES").value =
        document.getElementById("NomeBeneRES").innerHTML;
    }
  });
}

function AlmaLPRES() {
  var valor3 = document.getElementById("DepositoLPRES").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "16LPRES",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#AlmaLLPRES").html(msg);
      document.getElementById("Deposito2LPRES").value =
        document.getElementById("AlmaNomeRES").innerHTML;
    }
  });
}

function PagineoLPRESG(n) {
  document.getElementById("PagActLPRESG").innerHTML = n;
  MuestraProdLPRESG();
}

function MuestraProdLPRESG() {
  var valor = document.getElementById("PagActLPRESG").innerHTML;
  var valor2 = document.getElementById("RpaLPRESG").innerHTML;
  var valor3 = document.getElementById("search-prodLPRESG").value;
  var valor4 = document.getElementById("LimitLPRESG").value;
  if (document.getElementById("OrganizadorLPRESG").value == "1") {
    $.ajax({
      type: "POST",
      url: "dataseekled.php",
      data: {
        IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
        litfiscal: document.getElementById("litfiscal").innerHTML,
        direccion: document.getElementById("direccionActSe").innerHTML,
        NameCompany: document.getElementById("NameCompany").innerHTML,
        Accion: "0LPRESG",
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        sucursal: document.getElementById("sucursal").innerHTML,
        Search: valor3,
        Company: document.getElementById("CompanyActual").innerHTML,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobuscaLPRESG").html(msg);
    });
  }
  if (document.getElementById("OrganizadorLPRESG").value == "2") {
    $.ajax({
      type: "POST",
      url: "dataseekled.php",
      data: {
        IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
        litfiscal: document.getElementById("litfiscal").innerHTML,
        direccion: document.getElementById("direccionActSe").innerHTML,
        NameCompany: document.getElementById("NameCompany").innerHTML,
        Accion: "2LPRESGZ",
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        sucursal: document.getElementById("sucursal").innerHTML,
        Search: valor3,
        Company: document.getElementById("CompanyActual").innerHTML,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobuscaLPRESG").html(msg);
    });
  }
  if (document.getElementById("OrganizadorLPRESG").value == "3") {
    $.ajax({
      type: "POST",
      url: "dataseekled.php",
      data: {
        IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
        litfiscal: document.getElementById("litfiscal").innerHTML,
        direccion: document.getElementById("direccionActSe").innerHTML,
        NameCompany: document.getElementById("NameCompany").innerHTML,
        Accion: "3LPRESG",
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        sucursal: document.getElementById("sucursal").innerHTML,
        Search: valor3,
        Company: document.getElementById("CompanyActual").innerHTML,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobuscaLPRESG").html(msg);
    });
  }
  if (document.getElementById("OrganizadorLPRESG").value == "4") {
    $.ajax({
      type: "POST",
      url: "dataseekled.php",
      data: {
        IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
        litfiscal: document.getElementById("litfiscal").innerHTML,
        direccion: document.getElementById("direccionActSe").innerHTML,
        NameCompany: document.getElementById("NameCompany").innerHTML,
        Accion: "4LPRESG",
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        sucursal: document.getElementById("sucursal").innerHTML,
        Search: valor3,
        Company: document.getElementById("CompanyActual").innerHTML,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobuscaLPRESG").html(msg);
    });
  }
  if (document.getElementById("OrganizadorLPRESG").value == "5") {
    $.ajax({
      type: "POST",
      url: "dataseekled.php",
      data: {
        IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
        litfiscal: document.getElementById("litfiscal").innerHTML,
        direccion: document.getElementById("direccionActSe").innerHTML,
        NameCompany: document.getElementById("NameCompany").innerHTML,
        Accion: "5LPRESG",
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        sucursal: document.getElementById("sucursal").innerHTML,
        Search: valor3,
        Company: document.getElementById("CompanyActual").innerHTML,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobuscaLPRESG").html(msg);
    });
  }
}

function insertarcodigodesdeLPRESG(numero) {
  document.getElementById("CodIdBasG" + numero).innerHTML;
  document.getElementById("DescripG" + numero).innerHTML;
  document.getElementById("CodigoDesde2LPRESG").value = document.getElementById(
    "DescripG" + numero,
  ).innerHTML;
  document.getElementById("CodigoDesdeLPRESG").value = document.getElementById(
    "CodIdBasG" + numero,
  ).innerHTML;
  document.getElementById("CodigoHasta2LPRESG").value = document.getElementById(
    "DescripG" + numero,
  ).innerHTML;
  document.getElementById("CodigoHastaLPRESG").value = document.getElementById(
    "CodIdBasG" + numero,
  ).innerHTML;
}

function InsertacodigohastaLPRESG(numero) {
  document.getElementById("CodIdBasRESG" + numero).innerHTML;
  document.getElementById("DescripRESG" + numero).innerHTML;
  document.getElementById("CodigoHasta2LPRESG").value = document.getElementById(
    "DescripRESG" + numero,
  ).innerHTML;
  document.getElementById("CodigoHastaLPRESG").value = document.getElementById(
    "CodIdBasRESG" + numero,
  ).innerHTML;
}

function InsertaproevedorLPRESG(numero) {
  document.getElementById("NombG" + numero).innerHTML;
  document.getElementById("IdFiscalG" + numero).innerHTML;
  document.getElementById("BeneficiarioG2").value = document.getElementById(
    "NombG" + numero,
  ).innerHTML;
  document.getElementById("BeneficiarioG").value = document.getElementById(
    "IdFiscalG" + numero,
  ).innerHTML;
}

function insertaMarcaLPRESresG(numero) {
  document.getElementById("NombMLPresG" + numero).innerHTML;
  document.getElementById("IdMLPresG" + numero).innerHTML;
  document.getElementById("MarcaG2").value = document.getElementById(
    "NombMLPresG" + numero,
  ).innerHTML;
  document.getElementById("MarcaG").value = document.getElementById(
    "IdMLPresG" + numero,
  ).innerHTML;
}

function familiaLPRESG() {
  var valor3 = document.getElementById("InstanciaLPRESG").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "12LPRES",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#devueltachavalesLPRESG").html(msg);
      document.getElementById("Instancia2LPRESG").value =
        document.getElementById("Nombreitemxdres").innerHTML;
    }
  });
}

function CodigoDesLPRESG(input1, input2) {
  if (input1 != "") {
    var valor3 = document.getElementById(input1).value;
    document.getElementById(input1).value = valor3;
  } else {
    var valor3 = document.getElementById("CodigoDesdeLPRESG").value;
    document.getElementById("CodigoHastaLPRESG").value = valor3;
  }
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "13LPRES",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#CodigoDesaLLPRESG").html(msg);
      if (input1 != "") {
        document.getElementById(input2).value =
          document.getElementById("DesdeNomeRES").innerHTML;
      } else {
        document.getElementById("CodigoDesde2LPRESG").value =
          document.getElementById("DesdeNomeRES").innerHTML;
      }
    }
  });
}

function CodigoHasLPRESG() {
  var valor3 = document.getElementById("CodigoHastaLPRESG").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "14LPRES",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#CodigoHasaLLPRESG").html(msg);
      document.getElementById("CodigoHasta2LPRESG").value =
        document.getElementById("NomeHastaRES").innerHTML;
    }
  });
}

function BenefeLPRESG() {
  var valor3 = document.getElementById("ProevedorLPRESG").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "15LPRES",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#BenefeLLPRESG").html(msg);
      document.getElementById("Proevedor2LPRESG").value =
        document.getElementById("NomeBeneRES").innerHTML;
    }
  });
}

function MarcapresG() {
  var valor3 = document.getElementById("MarcaG").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "16LPRES",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#AlmaLLPRESG").html(msg);
      document.getElementById("MarcaG2").value =
        document.getElementById("AlmaNomeRES").innerHTML;
    }
  });
}

function closemodal(parametro) {
  $("#" + parametro).modal("hide");
}

function PagineoLPRESres(n) {
  document.getElementById("PagActLPRESres").innerHTML = n;
  MuestraProdLPRESres();
}

function MuestraProdLPRESres() {
  var valor = document.getElementById("PagActLPRESres").innerHTML;
  var valor2 = document.getElementById("RpaLPRESres").innerHTML;
  var valor3 = document.getElementById("search-prodLPRESres").value;
  var valor4 = document.getElementById("LimitLPRESres").value;
  if (document.getElementById("OrganizadorLPRESres").value == "2") {
    $.ajax({
      type: "POST",
      url: "dataseekled.php",
      data: {
        IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
        litfiscal: document.getElementById("litfiscal").innerHTML,
        direccion: document.getElementById("direccionActSe").innerHTML,
        NameCompany: document.getElementById("NameCompany").innerHTML,
        Accion: "2LPRESres",
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        sucursal: document.getElementById("sucursal").innerHTML,
        Search: valor3,
        Company: document.getElementById("CompanyActual").innerHTML,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobuscaLPRESres").html(msg);
    });
  }
  if (document.getElementById("OrganizadorLPRESres").value == "3") {
    $.ajax({
      type: "POST",
      url: "dataseekled.php",
      data: {
        IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
        litfiscal: document.getElementById("litfiscal").innerHTML,
        direccion: document.getElementById("direccionActSe").innerHTML,
        NameCompany: document.getElementById("NameCompany").innerHTML,
        Accion: "3LPRESres",
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        sucursal: document.getElementById("sucursal").innerHTML,
        Search: valor3,
        Company: document.getElementById("CompanyActual").innerHTML,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobuscaLPRESres").html(msg);
    });
  }

  if (document.getElementById("OrganizadorLPRESres").value == "5") {
    $.ajax({
      type: "POST",
      url: "dataseekled.php",
      data: {
        IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
        litfiscal: document.getElementById("litfiscal").innerHTML,
        direccion: document.getElementById("direccionActSe").innerHTML,
        NameCompany: document.getElementById("NameCompany").innerHTML,
        Accion: "5LPRESres",
        userperfil: document.getElementById("userperfil").innerHTML,
        Limite: valor4,
        sucursal: document.getElementById("sucursal").innerHTML,
        Search: valor3,
        Company: document.getElementById("CompanyActual").innerHTML,
        CIdPlan: document.getElementById("CIdPlan").innerHTML,
        IdCompanySelect: document.getElementById("IdCompanySelect").value,
        IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
        CD: document.getElementById("CD").innerHTML,
        SimDec: document.getElementById("SimDec").innerHTML,
        SimMil: document.getElementById("SimMil").innerHTML,
        MonedaP: document.getElementById("MonedaP").innerHTML,
        PagAct: valor,
        Rpa: valor2,
      },
    }).done(function (msg) {
      $("#resultadobuscaLPRESres").html(msg);
    });
  }
}

function insertarcodigodesdeLPRESres(numero) {
  document.getElementById("CodIdBasres" + numero).innerHTML;
  document.getElementById("Descripres" + numero).innerHTML;
  document.getElementById("CodigoDesde2LPRESres").value =
    document.getElementById("Descripres" + numero).innerHTML;
  document.getElementById("CodigoDesdeLPRESres").value =
    document.getElementById("CodIdBasres" + numero).innerHTML;
  document.getElementById("CodigoHasta2LPRESres").value =
    document.getElementById("Descripres" + numero).innerHTML;
  document.getElementById("CodigoHastaLPRESres").value =
    document.getElementById("CodIdBasres" + numero).innerHTML;
}

function InsertacodigohastaLPRESres(numero) {
  document.getElementById("CodIdBasRESres" + numero).innerHTML;
  document.getElementById("DescripRESres" + numero).innerHTML;
  document.getElementById("CodigoHasta2LPRESres").value =
    document.getElementById("DescripRESres" + numero).innerHTML;
  document.getElementById("CodigoHastaLPRESres").value =
    document.getElementById("CodIdBasRESres" + numero).innerHTML;
}

function insertaMarcaLPRESres(numero) {
  document.getElementById("IdMLPres" + numero).innerHTML;
  document.getElementById("NombMLPres" + numero).innerHTML;
  document.getElementById("MarcaLPUTA2res").value = document.getElementById(
    "NombMLPres" + numero,
  ).innerHTML;
  document.getElementById("MarcaLPUTA1res").value = document.getElementById(
    "IdMLPres" + numero,
  ).innerHTML;
}

function marcaploz() {
  var valor3 = document.getElementById("MarcaLPUTA1res").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "15LPRESres",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#devueltachavalesLPRESres").html(msg);
      document.getElementById("MarcaLPUTA2res").value =
        document.getElementById("MarNameres").innerHTML;
    }
  });
}

function CodigoDesLPRESres() {
  var valor3 = document.getElementById("CodigoDesdeLPRESres").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "13LPRESres",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#CodigoDesaLLPRESres").html(msg);
      document.getElementById("CodigoDesde2LPRESres").value =
        document.getElementById("DesdeNomeRESres").innerHTML;
      document.getElementById("CodigoHasta2LPRESres").value =
        document.getElementById("DesdeNomeRESres").innerHTML;
      document.getElementById("CodigoHastaLPRESres").value =
        document.getElementById("DesdeCodRESres").innerHTML;
    }
  });
}

function CodigoHasLPRESres() {
  var valor3 = document.getElementById("CodigoHastaLPRESres").value;
  $.ajax({
    type: "POST",
    url: "dataseekled.php",
    data: {
      IdiomaActual: document.getElementById("IdiomaActual").innerHTML,
      litfiscal: document.getElementById("litfiscal").innerHTML,
      direccion: document.getElementById("direccionActSe").innerHTML,
      NameCompany: document.getElementById("NameCompany").innerHTML,
      Accion: "14LPRESres",
      sucursal: document.getElementById("sucursal").innerHTML,
      Search: valor3,
      Company: document.getElementById("CompanyActual").innerHTML,
      CIdPlan: document.getElementById("CIdPlan").innerHTML,
      IdCompanySelect: document.getElementById("IdCompanySelect").value,
      IdCompanyGrp: document.getElementById("IdCompanyGrp").innerHTML,
    },
  }).done(function (msg) {
    if (msg == 0) {
    } else {
      $("#CodigoHasaLLPRESres").html(msg);
      document.getElementById("CodigoHasta2LPRESres").value =
        document.getElementById("NomeHastaRESres").innerHTML;
    }
  });
}

/*

 
function Pagineo(n){
		document.getElementById("PagAct").innerHTML = n; 
		MuestraProd();
}

function MuestraProd(){
		var valor = document.getElementById("PagAct").innerHTML;
		var valor2 = document.getElementById("Rpa").innerHTML;
		var valor3 = document.getElementById("search-prod").value;
		var valor4 = document.getElementById("Limit").value;
		if(document.getElementById("Organizador").value == "1"){ 
				$.ajax({
				type: "POST",
				url: "dataseekled.php",
				data:{IdiomaActual:document.getElementById( "IdiomaActual" ).innerHTML,litfiscal: document.getElementById( "litfiscal" ).innerHTML,direccion: document.getElementById( "direccionActSe" ).innerHTML,NameCompany: document.getElementById( "NameCompany" ).innerHTML,Accion:"0",sucursal: document.getElementById( "sucursal" ).innerHTML,userperfil: document.getElementById( "userperfil" ).innerHTML,Limite:valor4,sucursal: document.getElementById( "sucursal" ).innerHTML,Search:valor3,Company:document.getElementById( "CompanyActual" ).innerHTML,CIdPlan:document.getElementById( "CIdPlan" ).innerHTML,IdCompanySelect:document.getElementById( "IdCompanySelect" ).value,IdCompanyGrp:document.getElementById( "IdCompanyGrp" ).innerHTML,CD:document.getElementById( "CD" ).innerHTML,SimDec:document.getElementById( "SimDec" ).innerHTML,SimMil:document.getElementById( "SimMil" ).innerHTML,MonedaP:document.getElementById( "MonedaP" ).innerHTML,PagAct:valor,Rpa:valor2}
				}).done(function(msg){
						$("#resultadobusca").html(msg);  
				});
		}
		if(document.getElementById("Organizador").value == "2"){
				$.ajax({
				type: "POST",
				url: "dataseekled.php",
				data:{IdiomaActual:document.getElementById( "IdiomaActual" ).innerHTML,litfiscal: document.getElementById( "litfiscal" ).innerHTML,direccion: document.getElementById( "direccionActSe" ).innerHTML,NameCompany: document.getElementById( "NameCompany" ).innerHTML,Accion:"2",sucursal: document.getElementById( "sucursal" ).innerHTML,userperfil: document.getElementById( "userperfil" ).innerHTML,Limite:valor4,sucursal: document.getElementById( "sucursal" ).innerHTML,Search:valor3,Company:document.getElementById( "CompanyActual" ).innerHTML,CIdPlan:document.getElementById( "CIdPlan" ).innerHTML,IdCompanySelect:document.getElementById( "IdCompanySelect" ).value,IdCompanyGrp:document.getElementById( "IdCompanyGrp" ).innerHTML,CD:document.getElementById( "CD" ).innerHTML,SimDec:document.getElementById( "SimDec" ).innerHTML,SimMil:document.getElementById( "SimMil" ).innerHTML,MonedaP:document.getElementById( "MonedaP" ).innerHTML,PagAct:valor,Rpa:valor2}
				}).done(function(msg){
						$("#resultadobusca").html(msg);   
				});
		}
		if(document.getElementById("Organizador").value == "3"){
				$.ajax({
				type: "POST",
				url: "dataseekled.php",
				data:{IdiomaActual:document.getElementById( "IdiomaActual" ).innerHTML,litfiscal: document.getElementById( "litfiscal" ).innerHTML,direccion: document.getElementById( "direccionActSe" ).innerHTML,NameCompany: document.getElementById( "NameCompany" ).innerHTML,Accion:"3",sucursal: document.getElementById( "sucursal" ).innerHTML,userperfil: document.getElementById( "userperfil" ).innerHTML,Limite:valor4,sucursal: document.getElementById( "sucursal" ).innerHTML,Search:valor3,Company:document.getElementById( "CompanyActual" ).innerHTML,CIdPlan:document.getElementById( "CIdPlan" ).innerHTML,IdCompanySelect:document.getElementById( "IdCompanySelect" ).value,IdCompanyGrp:document.getElementById( "IdCompanyGrp" ).innerHTML,CD:document.getElementById( "CD" ).innerHTML,SimDec:document.getElementById( "SimDec" ).innerHTML,SimMil:document.getElementById( "SimMil" ).innerHTML,MonedaP:document.getElementById( "MonedaP" ).innerHTML,PagAct:valor,Rpa:valor2}
				}).done(function(msg){
						$("#resultadobusca").html(msg);   
				});
		}
		if(document.getElementById("Organizador").value == "4"){
				$.ajax({
				type: "POST",
				url: "dataseekled.php",
				data:{IdiomaActual:document.getElementById( "IdiomaActual" ).innerHTML,litfiscal: document.getElementById( "litfiscal" ).innerHTML,direccion: document.getElementById( "direccionActSe" ).innerHTML,NameCompany: document.getElementById( "NameCompany" ).innerHTML,Accion:"4",sucursal: document.getElementById( "sucursal" ).innerHTML,userperfil: document.getElementById( "userperfil" ).innerHTML,Limite:valor4,sucursal: document.getElementById( "sucursal" ).innerHTML,Search:valor3,Company:document.getElementById( "CompanyActual" ).innerHTML,CIdPlan:document.getElementById( "CIdPlan" ).innerHTML,IdCompanySelect:document.getElementById( "IdCompanySelect" ).value,IdCompanyGrp:document.getElementById( "IdCompanyGrp" ).innerHTML,CD:document.getElementById( "CD" ).innerHTML,SimDec:document.getElementById( "SimDec" ).innerHTML,SimMil:document.getElementById( "SimMil" ).innerHTML,MonedaP:document.getElementById( "MonedaP" ).innerHTML,PagAct:valor,Rpa:valor2}
				}).done(function(msg){
						$("#resultadobusca").html(msg);   
				});
		}
		if(document.getElementById("Organizador").value == "5"){
				$.ajax({
				type: "POST",
				url: "dataseekled.php",
				data:{IdiomaActual:document.getElementById( "IdiomaActual" ).innerHTML,litfiscal: document.getElementById( "litfiscal" ).innerHTML,direccion: document.getElementById( "direccionActSe" ).innerHTML,NameCompany: document.getElementById( "NameCompany" ).innerHTML,Accion:"5",sucursal: document.getElementById( "sucursal" ).innerHTML,userperfil: document.getElementById( "userperfil" ).innerHTML,Limite:valor4,sucursal: document.getElementById( "sucursal" ).innerHTML,Search:valor3,Company:document.getElementById( "CompanyActual" ).innerHTML,CIdPlan:document.getElementById( "CIdPlan" ).innerHTML,IdCompanySelect:document.getElementById( "IdCompanySelect" ).value,IdCompanyGrp:document.getElementById( "IdCompanyGrp" ).innerHTML,CD:document.getElementById( "CD" ).innerHTML,SimDec:document.getElementById( "SimDec" ).innerHTML,SimMil:document.getElementById( "SimMil" ).innerHTML,MonedaP:document.getElementById( "MonedaP" ).innerHTML,PagAct:valor,Rpa:valor2}
				}).done(function(msg){
						$("#resultadobusca").html(msg);   
				});
		}
		if(document.getElementById("Organizador").value == "6"){
				$.ajax({
				type: "POST",
				url: "dataseekled.php",
				data:{IdiomaActual:document.getElementById( "IdiomaActual" ).innerHTML,litfiscal: document.getElementById( "litfiscal" ).innerHTML,direccion: document.getElementById( "direccionActSe" ).innerHTML,NameCompany: document.getElementById( "NameCompany" ).innerHTML,Accion:"6",sucursal: document.getElementById( "sucursal" ).innerHTML,userperfil: document.getElementById( "userperfil" ).innerHTML,Limite:valor4,sucursal: document.getElementById( "sucursal" ).innerHTML,Search:valor3,Company:document.getElementById( "CompanyActual" ).innerHTML,CIdPlan:document.getElementById( "CIdPlan" ).innerHTML,IdCompanySelect:document.getElementById( "IdCompanySelect" ).value,IdCompanyGrp:document.getElementById( "IdCompanyGrp" ).innerHTML,CD:document.getElementById( "CD" ).innerHTML,SimDec:document.getElementById( "SimDec" ).innerHTML,SimMil:document.getElementById( "SimMil" ).innerHTML,MonedaP:document.getElementById( "MonedaP" ).innerHTML,PagAct:valor,Rpa:valor2}
				}).done(function(msg){
						$("#resultadobusca").html(msg);   
				});
		}
}

function PagineoAX(n){
		document.getElementById("PagActAX").innerHTML = n; 
		Analisis();
}

function Analisis(){
		var valor = document.getElementById("PagActAX").innerHTML;
		var valor2 = document.getElementById("RpaAX").innerHTML;
		var valor3 = document.getElementById("search-prodAX").value;
		var valor4 = document.getElementById("LimitAX").value;
		if(document.getElementById("OrganizadorAX").value == "1"){
				$.ajax({
				type: "POST",
				url: "dataseekled.php",
				data:{IdiomaActual:document.getElementById( "IdiomaActual" ).innerHTML,litfiscal: document.getElementById( "litfiscal" ).innerHTML,direccion: document.getElementById( "direccionActSe" ).innerHTML,NameCompany: document.getElementById( "NameCompany" ).innerHTML,Accion:"1AX",userperfil: document.getElementById( "userperfil" ).innerHTML,Limite:valor4,sucursal: document.getElementById( "sucursal" ).innerHTML,Search:valor3,Company:document.getElementById( "CompanyActual" ).innerHTML,CIdPlan:document.getElementById( "CIdPlan" ).innerHTML,IdCompanySelect:document.getElementById( "IdCompanySelect" ).value,IdCompanyGrp:document.getElementById( "IdCompanyGrp" ).innerHTML,CD:document.getElementById( "CD" ).innerHTML,SimDec:document.getElementById( "SimDec" ).innerHTML,SimMil:document.getElementById( "SimMil" ).innerHTML,MonedaP:document.getElementById( "MonedaP" ).innerHTML,PagAct:valor,Rpa:valor2}
				}).done(function(msg){
						$("#resultadobuscaAX").html(msg);  
				});
		}
		if(document.getElementById("OrganizadorAX").value == "2"){
				$.ajax({
				type: "POST",
				url: "dataseekled.php",
				data:{IdiomaActual:document.getElementById( "IdiomaActual" ).innerHTML,litfiscal: document.getElementById( "litfiscal" ).innerHTML,direccion: document.getElementById( "direccionActSe" ).innerHTML,NameCompany: document.getElementById( "NameCompany" ).innerHTML,Accion:"2AX",userperfil: document.getElementById( "userperfil" ).innerHTML,Limite:valor4,sucursal: document.getElementById( "sucursal" ).innerHTML,Search:valor3,Company:document.getElementById( "CompanyActual" ).innerHTML,CIdPlan:document.getElementById( "CIdPlan" ).innerHTML,IdCompanySelect:document.getElementById( "IdCompanySelect" ).value,IdCompanyGrp:document.getElementById( "IdCompanyGrp" ).innerHTML,CD:document.getElementById( "CD" ).innerHTML,SimDec:document.getElementById( "SimDec" ).innerHTML,SimMil:document.getElementById( "SimMil" ).innerHTML,MonedaP:document.getElementById( "MonedaP" ).innerHTML,PagAct:valor,Rpa:valor2}
				}).done(function(msg){
						$("#resultadobuscaAX").html(msg);  
				});
		}
		if(document.getElementById("OrganizadorAX").value == "3"){
				$.ajax({
				type: "POST",
				url: "dataseekled.php",
				data:{IdiomaActual:document.getElementById( "IdiomaActual" ).innerHTML,litfiscal: document.getElementById( "litfiscal" ).innerHTML,direccion: document.getElementById( "direccionActSe" ).innerHTML,NameCompany: document.getElementById( "NameCompany" ).innerHTML,Accion:"3AX",userperfil: document.getElementById( "userperfil" ).innerHTML,Limite:valor4,sucursal: document.getElementById( "sucursal" ).innerHTML,Search:valor3,Company:document.getElementById( "CompanyActual" ).innerHTML,CIdPlan:document.getElementById( "CIdPlan" ).innerHTML,IdCompanySelect:document.getElementById( "IdCompanySelect" ).value,IdCompanyGrp:document.getElementById( "IdCompanyGrp" ).innerHTML,CD:document.getElementById( "CD" ).innerHTML,SimDec:document.getElementById( "SimDec" ).innerHTML,SimMil:document.getElementById( "SimMil" ).innerHTML,MonedaP:document.getElementById( "MonedaP" ).innerHTML,PagAct:valor,Rpa:valor2}
				}).done(function(msg){
						$("#resultadobuscaAX").html(msg);  
				});
		}
		if(document.getElementById("OrganizadorAX").value == "4"){
				$.ajax({
				type: "POST",
				url: "dataseekled.php",
				data:{IdiomaActual:document.getElementById( "IdiomaActual" ).innerHTML,litfiscal: document.getElementById( "litfiscal" ).innerHTML,direccion: document.getElementById( "direccionActSe" ).innerHTML,NameCompany: document.getElementById( "NameCompany" ).innerHTML,Accion:"4AX",userperfil: document.getElementById( "userperfil" ).innerHTML,Limite:valor4,sucursal: document.getElementById( "sucursal" ).innerHTML,Search:valor3,Company:document.getElementById( "CompanyActual" ).innerHTML,CIdPlan:document.getElementById( "CIdPlan" ).innerHTML,IdCompanySelect:document.getElementById( "IdCompanySelect" ).value,IdCompanyGrp:document.getElementById( "IdCompanyGrp" ).innerHTML,CD:document.getElementById( "CD" ).innerHTML,SimDec:document.getElementById( "SimDec" ).innerHTML,SimMil:document.getElementById( "SimMil" ).innerHTML,MonedaP:document.getElementById( "MonedaP" ).innerHTML,PagAct:valor,Rpa:valor2}
				}).done(function(msg){
						$("#resultadobuscaAX").html(msg);  
				});
		}
		if(document.getElementById("OrganizadorAX").value == "5"){
				$.ajax({
				type: "POST",
				url: "dataseekled.php",
				data:{IdiomaActual:document.getElementById( "IdiomaActual" ).innerHTML,litfiscal: document.getElementById( "litfiscal" ).innerHTML,direccion: document.getElementById( "direccionActSe" ).innerHTML,NameCompany: document.getElementById( "NameCompany" ).innerHTML,Accion:"5AX",userperfil: document.getElementById( "userperfil" ).innerHTML,Limite:valor4,sucursal: document.getElementById( "sucursal" ).innerHTML,Search:valor3,Company:document.getElementById( "CompanyActual" ).innerHTML,CIdPlan:document.getElementById( "CIdPlan" ).innerHTML,IdCompanySelect:document.getElementById( "IdCompanySelect" ).value,IdCompanyGrp:document.getElementById( "IdCompanyGrp" ).innerHTML,CD:document.getElementById( "CD" ).innerHTML,SimDec:document.getElementById( "SimDec" ).innerHTML,SimMil:document.getElementById( "SimMil" ).innerHTML,MonedaP:document.getElementById( "MonedaP" ).innerHTML,PagAct:valor,Rpa:valor2}
				}).done(function(msg){
						$("#resultadobuscaAX").html(msg);  
				});
		}

}

function PagineoLP(n){
		document.getElementById("PagActLP").innerHTML = n; 
		MuestraProdLP();
}

function MuestraProdLP(){
		var valor = document.getElementById("PagActLP").innerHTML;
		var valor2 = document.getElementById("RpaLP").innerHTML;
		var valor3 = document.getElementById("search-prodLP").value;
		var valor4 = document.getElementById("LimitLP").value;
		if(document.getElementById("OrganizadorLP").value == "1"){
				$.ajax({
				type: "POST",
				url: "dataseekled.php",
				data:{IdiomaActual:document.getElementById( "IdiomaActual" ).innerHTML,litfiscal: document.getElementById( "litfiscal" ).innerHTML,direccion: document.getElementById( "direccionActSe" ).innerHTML,NameCompany: document.getElementById( "NameCompany" ).innerHTML,Accion:"0LP",userperfil: document.getElementById( "userperfil" ).innerHTML,Limite:valor4,sucursal: document.getElementById( "sucursal" ).innerHTML,Search:valor3,Company:document.getElementById( "CompanyActual" ).innerHTML,CIdPlan:document.getElementById( "CIdPlan" ).innerHTML,IdCompanySelect:document.getElementById( "IdCompanySelect" ).value,IdCompanyGrp:document.getElementById( "IdCompanyGrp" ).innerHTML,CD:document.getElementById( "CD" ).innerHTML,SimDec:document.getElementById( "SimDec" ).innerHTML,SimMil:document.getElementById( "SimMil" ).innerHTML,MonedaP:document.getElementById( "MonedaP" ).innerHTML,PagAct:valor,Rpa:valor2}
				}).done(function(msg){
						$("#resultadobuscaLP").html(msg);  
				});
		}
		if(document.getElementById("OrganizadorLP").value == "2"){
				$.ajax({
				type: "POST",
				url: "dataseekled.php",
				data:{IdiomaActual:document.getElementById( "IdiomaActual" ).innerHTML,litfiscal: document.getElementById( "litfiscal" ).innerHTML,direccion: document.getElementById( "direccionActSe" ).innerHTML,NameCompany: document.getElementById( "NameCompany" ).innerHTML,Accion:"2LP",userperfil: document.getElementById( "userperfil" ).innerHTML,Limite:valor4,sucursal: document.getElementById( "sucursal" ).innerHTML,Search:valor3,Company:document.getElementById( "CompanyActual" ).innerHTML,CIdPlan:document.getElementById( "CIdPlan" ).innerHTML,IdCompanySelect:document.getElementById( "IdCompanySelect" ).value,IdCompanyGrp:document.getElementById( "IdCompanyGrp" ).innerHTML,CD:document.getElementById( "CD" ).innerHTML,SimDec:document.getElementById( "SimDec" ).innerHTML,SimMil:document.getElementById( "SimMil" ).innerHTML,MonedaP:document.getElementById( "MonedaP" ).innerHTML,PagAct:valor,Rpa:valor2}
				}).done(function(msg){
						$("#resultadobuscaLP").html(msg);  
				});
		}
		if(document.getElementById("OrganizadorLP").value == "3"){
				$.ajax({
				type: "POST",
				url: "dataseekled.php",
				data:{IdiomaActual:document.getElementById( "IdiomaActual" ).innerHTML,litfiscal: document.getElementById( "litfiscal" ).innerHTML,direccion: document.getElementById( "direccionActSe" ).innerHTML,NameCompany: document.getElementById( "NameCompany" ).innerHTML,Accion:"3LP",sucursal: document.getElementById( "sucursal" ).innerHTML,userperfil: document.getElementById( "userperfil" ).innerHTML,Limite:valor4,sucursal: document.getElementById( "sucursal" ).innerHTML,Search:valor3,Company:document.getElementById( "CompanyActual" ).innerHTML,CIdPlan:document.getElementById( "CIdPlan" ).innerHTML,IdCompanySelect:document.getElementById( "IdCompanySelect" ).value,IdCompanyGrp:document.getElementById( "IdCompanyGrp" ).innerHTML,CD:document.getElementById( "CD" ).innerHTML,SimDec:document.getElementById( "SimDec" ).innerHTML,SimMil:document.getElementById( "SimMil" ).innerHTML,MonedaP:document.getElementById( "MonedaP" ).innerHTML,PagAct:valor,Rpa:valor2}
				}).done(function(msg){
						$("#resultadobuscaLP").html(msg);  
				});
		}
		if(document.getElementById("OrganizadorLP").value == "4"){
				$.ajax({
				type: "POST",
				url: "dataseekled.php",
				data:{IdiomaActual:document.getElementById( "IdiomaActual" ).innerHTML,litfiscal: document.getElementById( "litfiscal" ).innerHTML,direccion: document.getElementById( "direccionActSe" ).innerHTML,NameCompany: document.getElementById( "NameCompany" ).innerHTML,Accion:"4LP",userperfil: document.getElementById( "userperfil" ).innerHTML,Limite:valor4,sucursal: document.getElementById( "sucursal" ).innerHTML,Search:valor3,Company:document.getElementById( "CompanyActual" ).innerHTML,CIdPlan:document.getElementById( "CIdPlan" ).innerHTML,IdCompanySelect:document.getElementById( "IdCompanySelect" ).value,IdCompanyGrp:document.getElementById( "IdCompanyGrp" ).innerHTML,CD:document.getElementById( "CD" ).innerHTML,SimDec:document.getElementById( "SimDec" ).innerHTML,SimMil:document.getElementById( "SimMil" ).innerHTML,MonedaP:document.getElementById( "MonedaP" ).innerHTML,PagAct:valor,Rpa:valor2}
				}).done(function(msg){
						$("#resultadobuscaLP").html(msg);  
				});
		}
		if(document.getElementById("OrganizadorLP").value == "5"){
				$.ajax({
				type: "POST",
				url: "dataseekled.php",
				data:{IdiomaActual:document.getElementById( "IdiomaActual" ).innerHTML,litfiscal: document.getElementById( "litfiscal" ).innerHTML,direccion: document.getElementById( "direccionActSe" ).innerHTML,NameCompany: document.getElementById( "NameCompany" ).innerHTML,Accion:"5LP",sucursal: document.getElementById( "sucursal" ).innerHTML,userperfil: document.getElementById( "userperfil" ).innerHTML,Limite:valor4,sucursal: document.getElementById( "sucursal" ).innerHTML,Search:valor3,Company:document.getElementById( "CompanyActual" ).innerHTML,CIdPlan:document.getElementById( "CIdPlan" ).innerHTML,IdCompanySelect:document.getElementById( "IdCompanySelect" ).value,IdCompanyGrp:document.getElementById( "IdCompanyGrp" ).innerHTML,CD:document.getElementById( "CD" ).innerHTML,SimDec:document.getElementById( "SimDec" ).innerHTML,SimMil:document.getElementById( "SimMil" ).innerHTML,MonedaP:document.getElementById( "MonedaP" ).innerHTML,PagAct:valor,Rpa:valor2}
				}).done(function(msg){
						$("#resultadobuscaLP").html(msg);  
				});
		}
		if(document.getElementById("OrganizadorLP").value == "6"){
				$.ajax({
				type: "POST",
				url: "dataseekled.php",
				data:{IdiomaActual:document.getElementById( "IdiomaActual" ).innerHTML,litfiscal: document.getElementById( "litfiscal" ).innerHTML,direccion: document.getElementById( "direccionActSe" ).innerHTML,NameCompany: document.getElementById( "NameCompany" ).innerHTML,Accion:"6LP",sucursal: document.getElementById( "sucursal" ).innerHTML,userperfil: document.getElementById( "userperfil" ).innerHTML,Limite:valor4,sucursal: document.getElementById( "sucursal" ).innerHTML,Search:valor3,Company:document.getElementById( "CompanyActual" ).innerHTML,CIdPlan:document.getElementById( "CIdPlan" ).innerHTML,IdCompanySelect:document.getElementById( "IdCompanySelect" ).value,IdCompanyGrp:document.getElementById( "IdCompanyGrp" ).innerHTML,CD:document.getElementById( "CD" ).innerHTML,SimDec:document.getElementById( "SimDec" ).innerHTML,SimMil:document.getElementById( "SimMil" ).innerHTML,MonedaP:document.getElementById( "MonedaP" ).innerHTML,PagAct:valor,Rpa:valor2}
				}).done(function(msg){
						$("#resultadobuscaLP").html(msg);  
				});
		}
		if(document.getElementById("OrganizadorLP").value == "7"){
				$.ajax({
				type: "POST",
				url: "dataseekled.php",
				data:{IdiomaActual:document.getElementById( "IdiomaActual" ).innerHTML,litfiscal: document.getElementById( "litfiscal" ).innerHTML,direccion: document.getElementById( "direccionActSe" ).innerHTML,NameCompany: document.getElementById( "NameCompany" ).innerHTML,Accion:"7LP",userperfil: document.getElementById( "userperfil" ).innerHTML,Limite:valor4,sucursal: document.getElementById( "sucursal" ).innerHTML,Search:valor3,Company:document.getElementById( "CompanyActual" ).innerHTML,CIdPlan:document.getElementById( "CIdPlan" ).innerHTML,IdCompanySelect:document.getElementById( "IdCompanySelect" ).value,IdCompanyGrp:document.getElementById( "IdCompanyGrp" ).innerHTML,CD:document.getElementById( "CD" ).innerHTML,SimDec:document.getElementById( "SimDec" ).innerHTML,SimMil:document.getElementById( "SimMil" ).innerHTML,MonedaP:document.getElementById( "MonedaP" ).innerHTML,PagAct:valor,Rpa:valor2}
				}).done(function(msg){
						$("#resultadobuscaLP").html(msg);  
				});
		}
}
function PagineoAXX(n){
		document.getElementById("PagActAXX").innerHTML = n; 
		inventarioF();
}

function inventarioF(){
		var valor = document.getElementById("PagActAXX").innerHTML;
		var valor2 = document.getElementById("RpaAXX").innerHTML;
		var valor3 = document.getElementById("search-prodAXX").value;
		var valor4 = document.getElementById("LimitAXX").value;
		if(document.getElementById("OrganizadorAXX").value == "1"){
				$.ajax({
				type: "POST",
				url: "dataseekled.php",
				data:{IdiomaActual:document.getElementById( "IdiomaActual" ).innerHTML,litfiscal: document.getElementById( "litfiscal" ).innerHTML,direccion: document.getElementById( "direccionActSe" ).innerHTML,NameCompany: document.getElementById( "NameCompany" ).innerHTML,Accion:"1VE",userperfil: document.getElementById( "userperfil" ).innerHTML,Limite:valor4,sucursal: document.getElementById( "sucursal" ).innerHTML,Search:valor3,Company:document.getElementById( "CompanyActual" ).innerHTML,CIdPlan:document.getElementById( "CIdPlan" ).innerHTML,IdCompanySelect:document.getElementById( "IdCompanySelect" ).value,IdCompanyGrp:document.getElementById( "IdCompanyGrp" ).innerHTML,CD:document.getElementById( "CD" ).innerHTML,SimDec:document.getElementById( "SimDec" ).innerHTML,SimMil:document.getElementById( "SimMil" ).innerHTML,MonedaP:document.getElementById( "MonedaP" ).innerHTML,PagAct:valor,Rpa:valor2}
				}).done(function(msg){
						$("#resultadobuscaAXX").html(msg);  
				});
		}
		if(document.getElementById("OrganizadorAXX").value == "2"){
				$.ajax({
				type: "POST",
				url: "dataseekled.php",
				data:{IdiomaActual:document.getElementById( "IdiomaActual" ).innerHTML,litfiscal: document.getElementById( "litfiscal" ).innerHTML,direccion: document.getElementById( "direccionActSe" ).innerHTML,NameCompany: document.getElementById( "NameCompany" ).innerHTML,Accion:"2VE",userperfil: document.getElementById( "userperfil" ).innerHTML,Limite:valor4,sucursal: document.getElementById( "sucursal" ).innerHTML,Search:valor3,Company:document.getElementById( "CompanyActual" ).innerHTML,CIdPlan:document.getElementById( "CIdPlan" ).innerHTML,IdCompanySelect:document.getElementById( "IdCompanySelect" ).value,IdCompanyGrp:document.getElementById( "IdCompanyGrp" ).innerHTML,CD:document.getElementById( "CD" ).innerHTML,SimDec:document.getElementById( "SimDec" ).innerHTML,SimMil:document.getElementById( "SimMil" ).innerHTML,MonedaP:document.getElementById( "MonedaP" ).innerHTML,PagAct:valor,Rpa:valor2}
				}).done(function(msg){
						$("#resultadobuscaAXX").html(msg);  
				});
		}
		if(document.getElementById("OrganizadorAXX").value == "3"){
				$.ajax({
				type: "POST",
				url: "dataseekled.php",
				data:{IdiomaActual:document.getElementById( "IdiomaActual" ).innerHTML,litfiscal: document.getElementById( "litfiscal" ).innerHTML,direccion: document.getElementById( "direccionActSe" ).innerHTML,NameCompany: document.getElementById( "NameCompany" ).innerHTML,Accion:"3VE",userperfil: document.getElementById( "userperfil" ).innerHTML,Limite:valor4,sucursal: document.getElementById( "sucursal" ).innerHTML,Search:valor3,Company:document.getElementById( "CompanyActual" ).innerHTML,CIdPlan:document.getElementById( "CIdPlan" ).innerHTML,IdCompanySelect:document.getElementById( "IdCompanySelect" ).value,IdCompanyGrp:document.getElementById( "IdCompanyGrp" ).innerHTML,CD:document.getElementById( "CD" ).innerHTML,SimDec:document.getElementById( "SimDec" ).innerHTML,SimMil:document.getElementById( "SimMil" ).innerHTML,MonedaP:document.getElementById( "MonedaP" ).innerHTML,PagAct:valor,Rpa:valor2}
				}).done(function(msg){
						$("#resultadobuscaAXX").html(msg);  
				});
		}
		if(document.getElementById("OrganizadorAXX").value == "4"){
				$.ajax({
				type: "POST",
				url: "dataseekled.php",
				data:{IdiomaActual:document.getElementById( "IdiomaActual" ).innerHTML,litfiscal: document.getElementById( "litfiscal" ).innerHTML,direccion: document.getElementById( "direccionActSe" ).innerHTML,NameCompany: document.getElementById( "NameCompany" ).innerHTML,Accion:"4VE",userperfil: document.getElementById( "userperfil" ).innerHTML,Limite:valor4,sucursal: document.getElementById( "sucursal" ).innerHTML,Search:valor3,Company:document.getElementById( "CompanyActual" ).innerHTML,CIdPlan:document.getElementById( "CIdPlan" ).innerHTML,IdCompanySelect:document.getElementById( "IdCompanySelect" ).value,IdCompanyGrp:document.getElementById( "IdCompanyGrp" ).innerHTML,CD:document.getElementById( "CD" ).innerHTML,SimDec:document.getElementById( "SimDec" ).innerHTML,SimMil:document.getElementById( "SimMil" ).innerHTML,MonedaP:document.getElementById( "MonedaP" ).innerHTML,PagAct:valor,Rpa:valor2}
				}).done(function(msg){
						$("#resultadobuscaAXX").html(msg);  
				});
		}
		if(document.getElementById("OrganizadorAXX").value == "5"){
				$.ajax({
				type: "POST",
				url: "dataseekled.php",
				data:{IdiomaActual:document.getElementById( "IdiomaActual" ).innerHTML,litfiscal: document.getElementById( "litfiscal" ).innerHTML,direccion: document.getElementById( "direccionActSe" ).innerHTML,NameCompany: document.getElementById( "NameCompany" ).innerHTML,Accion:"5VE",userperfil: document.getElementById( "userperfil" ).innerHTML,Limite:valor4,sucursal: document.getElementById( "sucursal" ).innerHTML,Search:valor3,Company:document.getElementById( "CompanyActual" ).innerHTML,CIdPlan:document.getElementById( "CIdPlan" ).innerHTML,IdCompanySelect:document.getElementById( "IdCompanySelect" ).value,IdCompanyGrp:document.getElementById( "IdCompanyGrp" ).innerHTML,CD:document.getElementById( "CD" ).innerHTML,SimDec:document.getElementById( "SimDec" ).innerHTML,SimMil:document.getElementById( "SimMil" ).innerHTML,MonedaP:document.getElementById( "MonedaP" ).innerHTML,PagAct:valor,Rpa:valor2}
				}).done(function(msg){
						$("#resultadobuscaAXX").html(msg);  
				});
		}

}

 
function PagineoAX22(n){
		document.getElementById("PagActAX22").innerHTML = n; 
		Analisis22();
}

function Analisis22(){
		var valor = document.getElementById("PagActAX22").innerHTML;
		var valor2 = document.getElementById("RpaAX22").innerHTML;
		var valor3 = document.getElementById("search-prodAX22").value;
		var valor4 = document.getElementById("LimitAX22").value;
		if(document.getElementById("OrganizadorAX22").value == "1"){
				$.ajax({
				type: "POST",
				url: "dataseekled.php",
				data:{IdiomaActual:document.getElementById( "IdiomaActual" ).innerHTML,litfiscal: document.getElementById( "litfiscal" ).innerHTML,direccion: document.getElementById( "direccionActSe" ).innerHTML,NameCompany: document.getElementById( "NameCompany" ).innerHTML,Accion:"1AX22",userperfil: document.getElementById( "userperfil" ).innerHTML,Limite:valor4,sucursal: document.getElementById( "sucursal" ).innerHTML,Search:valor3,Company:document.getElementById( "CompanyActual" ).innerHTML,CIdPlan:document.getElementById( "CIdPlan" ).innerHTML,IdCompanySelect:document.getElementById( "IdCompanySelect" ).value,IdCompanyGrp:document.getElementById( "IdCompanyGrp" ).innerHTML,CD:document.getElementById( "CD" ).innerHTML,SimDec:document.getElementById( "SimDec" ).innerHTML,SimMil:document.getElementById( "SimMil" ).innerHTML,MonedaP:document.getElementById( "MonedaP" ).innerHTML,PagAct:valor,Rpa:valor2}
				}).done(function(msg){
						$("#resultadobuscaAX22").html(msg);  
				});
		}
		if(document.getElementById("OrganizadorAX22").value == "2"){
				$.ajax({
				type: "POST",
				url: "dataseekled.php",
				data:{IdiomaActual:document.getElementById( "IdiomaActual" ).innerHTML,litfiscal: document.getElementById( "litfiscal" ).innerHTML,direccion: document.getElementById( "direccionActSe" ).innerHTML,NameCompany: document.getElementById( "NameCompany" ).innerHTML,Accion:"2AX22",userperfil: document.getElementById( "userperfil" ).innerHTML,Limite:valor4,sucursal: document.getElementById( "sucursal" ).innerHTML,Search:valor3,Company:document.getElementById( "CompanyActual" ).innerHTML,CIdPlan:document.getElementById( "CIdPlan" ).innerHTML,IdCompanySelect:document.getElementById( "IdCompanySelect" ).value,IdCompanyGrp:document.getElementById( "IdCompanyGrp" ).innerHTML,CD:document.getElementById( "CD" ).innerHTML,SimDec:document.getElementById( "SimDec" ).innerHTML,SimMil:document.getElementById( "SimMil" ).innerHTML,MonedaP:document.getElementById( "MonedaP" ).innerHTML,PagAct:valor,Rpa:valor2}
				}).done(function(msg){
						$("#resultadobuscaAX22").html(msg);  
				});
		}
		if(document.getElementById("OrganizadorAX22").value == "3"){
				$.ajax({
				type: "POST",
				url: "dataseekled.php",
				data:{IdiomaActual:document.getElementById( "IdiomaActual" ).innerHTML,litfiscal: document.getElementById( "litfiscal" ).innerHTML,direccion: document.getElementById( "direccionActSe" ).innerHTML,NameCompany: document.getElementById( "NameCompany" ).innerHTML,Accion:"3AX22",userperfil: document.getElementById( "userperfil" ).innerHTML,Limite:valor4,sucursal: document.getElementById( "sucursal" ).innerHTML,Search:valor3,Company:document.getElementById( "CompanyActual" ).innerHTML,CIdPlan:document.getElementById( "CIdPlan" ).innerHTML,IdCompanySelect:document.getElementById( "IdCompanySelect" ).value,IdCompanyGrp:document.getElementById( "IdCompanyGrp" ).innerHTML,CD:document.getElementById( "CD" ).innerHTML,SimDec:document.getElementById( "SimDec" ).innerHTML,SimMil:document.getElementById( "SimMil" ).innerHTML,MonedaP:document.getElementById( "MonedaP" ).innerHTML,PagAct:valor,Rpa:valor2}
				}).done(function(msg){
						$("#resultadobuscaAX22").html(msg);  
				});
		}
		if(document.getElementById("OrganizadorAX22").value == "4"){
				$.ajax({
				type: "POST",
				url: "dataseekled.php",
				data:{IdiomaActual:document.getElementById( "IdiomaActual" ).innerHTML,litfiscal: document.getElementById( "litfiscal" ).innerHTML,direccion: document.getElementById( "direccionActSe" ).innerHTML,NameCompany: document.getElementById( "NameCompany" ).innerHTML,Accion:"4AX22",userperfil: document.getElementById( "userperfil" ).innerHTML,Limite:valor4,sucursal: document.getElementById( "sucursal" ).innerHTML,Search:valor3,Company:document.getElementById( "CompanyActual" ).innerHTML,CIdPlan:document.getElementById( "CIdPlan" ).innerHTML,IdCompanySelect:document.getElementById( "IdCompanySelect" ).value,IdCompanyGrp:document.getElementById( "IdCompanyGrp" ).innerHTML,CD:document.getElementById( "CD" ).innerHTML,SimDec:document.getElementById( "SimDec" ).innerHTML,SimMil:document.getElementById( "SimMil" ).innerHTML,MonedaP:document.getElementById( "MonedaP" ).innerHTML,PagAct:valor,Rpa:valor2}
				}).done(function(msg){
						$("#resultadobuscaAX22").html(msg);  
				});
		}  
}
 
function PagineoAX2(n){
		document.getElementById("PagActAX2").innerHTML = n; 
		Analisis2();
}

function Analisis2(){
		var valor = document.getElementById("PagActAX2").innerHTML;
		var valor2 = document.getElementById("RpaAX2").innerHTML;
		var valor3 = document.getElementById("search-prodAX2").value;
		var valor4 = document.getElementById("LimitAX2").value;
		if(document.getElementById("OrganizadorAX2").value == "1"){
				$.ajax({
				type: "POST",
				url: "dataseekled.php",
				data:{IdiomaActual:document.getElementById( "IdiomaActual" ).innerHTML,litfiscal: document.getElementById( "litfiscal" ).innerHTML,direccion: document.getElementById( "direccionActSe" ).innerHTML,NameCompany: document.getElementById( "NameCompany" ).innerHTML,Accion:"1AX2",userperfil: document.getElementById( "userperfil" ).innerHTML,Limite:valor4,sucursal: document.getElementById( "sucursal" ).innerHTML,Search:valor3,Company:document.getElementById( "CompanyActual" ).innerHTML,CIdPlan:document.getElementById( "CIdPlan" ).innerHTML,IdCompanySelect:document.getElementById( "IdCompanySelect" ).value,IdCompanyGrp:document.getElementById( "IdCompanyGrp" ).innerHTML,CD:document.getElementById( "CD" ).innerHTML,SimDec:document.getElementById( "SimDec" ).innerHTML,SimMil:document.getElementById( "SimMil" ).innerHTML,MonedaP:document.getElementById( "MonedaP" ).innerHTML,PagAct:valor,Rpa:valor2}
				}).done(function(msg){
						$("#resultadobuscaAX2").html(msg);  
				});
		}
		if(document.getElementById("OrganizadorAX2").value == "2"){
				$.ajax({
				type: "POST",
				url: "dataseekled.php",
				data:{IdiomaActual:document.getElementById( "IdiomaActual" ).innerHTML,litfiscal: document.getElementById( "litfiscal" ).innerHTML,direccion: document.getElementById( "direccionActSe" ).innerHTML,NameCompany: document.getElementById( "NameCompany" ).innerHTML,Accion:"2AX2",userperfil: document.getElementById( "userperfil" ).innerHTML,Limite:valor4,sucursal: document.getElementById( "sucursal" ).innerHTML,Search:valor3,Company:document.getElementById( "CompanyActual" ).innerHTML,CIdPlan:document.getElementById( "CIdPlan" ).innerHTML,IdCompanySelect:document.getElementById( "IdCompanySelect" ).value,IdCompanyGrp:document.getElementById( "IdCompanyGrp" ).innerHTML,CD:document.getElementById( "CD" ).innerHTML,SimDec:document.getElementById( "SimDec" ).innerHTML,SimMil:document.getElementById( "SimMil" ).innerHTML,MonedaP:document.getElementById( "MonedaP" ).innerHTML,PagAct:valor,Rpa:valor2}
				}).done(function(msg){
						$("#resultadobuscaAX2").html(msg);  
				});
		}
		if(document.getElementById("OrganizadorAX2").value == "3"){
				$.ajax({
				type: "POST",
				url: "dataseekled.php",
				data:{IdiomaActual:document.getElementById( "IdiomaActual" ).innerHTML,litfiscal: document.getElementById( "litfiscal" ).innerHTML,direccion: document.getElementById( "direccionActSe" ).innerHTML,NameCompany: document.getElementById( "NameCompany" ).innerHTML,Accion:"3AX2",userperfil: document.getElementById( "userperfil" ).innerHTML,Limite:valor4,sucursal: document.getElementById( "sucursal" ).innerHTML,Search:valor3,Company:document.getElementById( "CompanyActual" ).innerHTML,CIdPlan:document.getElementById( "CIdPlan" ).innerHTML,IdCompanySelect:document.getElementById( "IdCompanySelect" ).value,IdCompanyGrp:document.getElementById( "IdCompanyGrp" ).innerHTML,CD:document.getElementById( "CD" ).innerHTML,SimDec:document.getElementById( "SimDec" ).innerHTML,SimMil:document.getElementById( "SimMil" ).innerHTML,MonedaP:document.getElementById( "MonedaP" ).innerHTML,PagAct:valor,Rpa:valor2}
				}).done(function(msg){
						$("#resultadobuscaAX2").html(msg);  
				});
		}
		if(document.getElementById("OrganizadorAX2").value == "4"){
				$.ajax({
				type: "POST",
				url: "dataseekled.php",
				data:{IdiomaActual:document.getElementById( "IdiomaActual" ).innerHTML,litfiscal: document.getElementById( "litfiscal" ).innerHTML,direccion: document.getElementById( "direccionActSe" ).innerHTML,NameCompany: document.getElementById( "NameCompany" ).innerHTML,Accion:"4AX2",userperfil: document.getElementById( "userperfil" ).innerHTML,Limite:valor4,sucursal: document.getElementById( "sucursal" ).innerHTML,Search:valor3,Company:document.getElementById( "CompanyActual" ).innerHTML,CIdPlan:document.getElementById( "CIdPlan" ).innerHTML,IdCompanySelect:document.getElementById( "IdCompanySelect" ).value,IdCompanyGrp:document.getElementById( "IdCompanyGrp" ).innerHTML,CD:document.getElementById( "CD" ).innerHTML,SimDec:document.getElementById( "SimDec" ).innerHTML,SimMil:document.getElementById( "SimMil" ).innerHTML,MonedaP:document.getElementById( "MonedaP" ).innerHTML,PagAct:valor,Rpa:valor2}
				}).done(function(msg){
						$("#resultadobuscaAX2").html(msg);  
				});
		}
		if(document.getElementById("OrganizadorAX2").value == "5"){
				$.ajax({
				type: "POST",
				url: "dataseekled.php",
				data:{IdiomaActual:document.getElementById( "IdiomaActual" ).innerHTML,litfiscal: document.getElementById( "litfiscal" ).innerHTML,direccion: document.getElementById( "direccionActSe" ).innerHTML,NameCompany: document.getElementById( "NameCompany" ).innerHTML,Accion:"5AX2",userperfil: document.getElementById( "userperfil" ).innerHTML,Limite:valor4,sucursal: document.getElementById( "sucursal" ).innerHTML,Search:valor3,Company:document.getElementById( "CompanyActual" ).innerHTML,CIdPlan:document.getElementById( "CIdPlan" ).innerHTML,IdCompanySelect:document.getElementById( "IdCompanySelect" ).value,IdCompanyGrp:document.getElementById( "IdCompanyGrp" ).innerHTML,CD:document.getElementById( "CD" ).innerHTML,SimDec:document.getElementById( "SimDec" ).innerHTML,SimMil:document.getElementById( "SimMil" ).innerHTML,MonedaP:document.getElementById( "MonedaP" ).innerHTML,PagAct:valor,Rpa:valor2}
				}).done(function(msg){
						$("#resultadobuscaAX2").html(msg);  
				});
		}
}
*/

/*

	function tomartintancia(numero){
			document.getElementById("varios"+numero).innerHTML;
			document.getElementById("itemname"+numero).innerHTML;
			document.getElementById("InstanciaNK").value = document.getElementById("varios"+numero).innerHTML;
			document.getElementById("Instancia2NK").value = document.getElementById("itemname"+numero).innerHTML;
	}

	function insertarcodigodesde(numero){
			document.getElementById("CodIdBas"+numero).innerHTML;
			document.getElementById("Descrip"+numero).innerHTML;
			document.getElementById("CodigoDesde2").value = document.getElementById("Descrip"+numero).innerHTML;
			document.getElementById("CodigoDesde").value = document.getElementById("CodIdBas"+numero).innerHTML;
			document.getElementById("CodigoHasta2").value = document.getElementById("Descrip"+numero).innerHTML;
			document.getElementById("CodigoHasta").value = document.getElementById("CodIdBas"+numero).innerHTML;
	}

	function Insertacodigohasta(numero){
			document.getElementById("CodIdBas"+numero).innerHTML;
			document.getElementById("Descrip"+numero).innerHTML;
			document.getElementById("CodigoHasta2").value = document.getElementById("Descrip"+numero).innerHTML;
			document.getElementById("CodigoHasta").value = document.getElementById("CodIdBas"+numero).innerHTML;
	}

	function Insertaproevedor(numero){
			document.getElementById("Nomb"+numero).innerHTML;
			document.getElementById("IdFiscal"+numero).innerHTML;
			document.getElementById("Proevedor2").value = document.getElementById("Nomb"+numero).innerHTML;
			document.getElementById("Proevedor").value = document.getElementById("IdFiscal"+numero).innerHTML;
	}

	function Insertadeposito(numero){
			document.getElementById("NombD"+numero).innerHTML;
			document.getElementById("IdAlma"+numero).innerHTML;
			document.getElementById("Deposito2NK").value = document.getElementById("NombD"+numero).innerHTML;
			document.getElementById("DepositoNK").value = document.getElementById("IdAlma"+numero).innerHTML;
	}

	function insertaMarca(numero){
			document.getElementById("IdM"+numero).innerHTML;
			document.getElementById("NombM"+numero).innerHTML;
			document.getElementById("Marca2").value = document.getElementById("NombM"+numero).innerHTML;
			document.getElementById("Marca").value = document.getElementById("IdM"+numero).innerHTML;
	}
  

	function insertarcodigodesdeAX(numero){
			document.getElementById("CodIdBas"+numero).innerHTML;
			document.getElementById("Descrip"+numero).innerHTML;
			document.getElementById("DesdeAX2").value = document.getElementById("Descrip"+numero).innerHTML;
			document.getElementById("DesdeAX").value = document.getElementById("CodIdBas"+numero).innerHTML;
			document.getElementById("HastaAX2").value = document.getElementById("Descrip"+numero).innerHTML;
			document.getElementById("HastaAX").value = document.getElementById("CodIdBas"+numero).innerHTML;
	}

	function InsertacodigohastaAX(numero){
			document.getElementById("CodIdBas"+numero).innerHTML;
			document.getElementById("Descrip"+numero).innerHTML;
			document.getElementById("HastaAX2").value = document.getElementById("Descrip"+numero).innerHTML;
			document.getElementById("HastaAX").value = document.getElementById("CodIdBas"+numero).innerHTML;
	}

	function InsertaproevedorAX(numero){
			document.getElementById("Nomb"+numero).innerHTML;
			document.getElementById("IdFiscal"+numero).innerHTML;
			document.getElementById("BeneficiarioAX2").value = document.getElementById("Nomb"+numero).innerHTML;
			document.getElementById("BeneficiarioAX").value = document.getElementById("IdFiscal"+numero).innerHTML;
	}

	function InsertadepositoAX(numero){
			document.getElementById("NombD"+numero).innerHTML;
			document.getElementById("IdAlma"+numero).innerHTML;
			document.getElementById("AlmacenAX2").value = document.getElementById("NombD"+numero).innerHTML;
			document.getElementById("AlmacenAX").value = document.getElementById("IdAlma"+numero).innerHTML;
	}

	function Cantidad(numero){
			document.getElementById("NombD"+numero).innerHTML;
			document.getElementById("IdAlma"+numero).innerHTML;
			document.getElementById("Deposito2NK").value = document.getElementById("NombD"+numero).innerHTML;
			document.getElementById("DepositoNK").value = document.getElementById("IdAlma"+numero).innerHTML;
	}
	function tomartintanciaLP(numero){
			document.getElementById("varios"+numero).innerHTML;
			document.getElementById("itemname"+numero).innerHTML;
			document.getElementById("InstanciaLP").value = document.getElementById("varios"+numero).innerHTML;
			document.getElementById("Instancia2LP").value = document.getElementById("itemname"+numero).innerHTML;
	}

	function insertarcodigodesdeLP(numero){
			document.getElementById("CodIdBas"+numero).innerHTML;
			document.getElementById("Descrip"+numero).innerHTML;
			document.getElementById("CodigoDesde2LP").value = document.getElementById("Descrip"+numero).innerHTML;
			document.getElementById("CodigoDesdeLP").value = document.getElementById("CodIdBas"+numero).innerHTML;
			document.getElementById("CodigoHasta2LP").value = document.getElementById("Descrip"+numero).innerHTML;
			document.getElementById("CodigoHastaLP").value = document.getElementById("CodIdBas"+numero).innerHTML;
	}

	function InsertacodigohastaLP(numero){
			document.getElementById("CodIdBas"+numero).innerHTML;
			document.getElementById("Descrip"+numero).innerHTML;
			document.getElementById("CodigoHasta2LP").value = document.getElementById("Descrip"+numero).innerHTML;
			document.getElementById("CodigoHastaLP").value = document.getElementById("CodIdBas"+numero).innerHTML;
	}

	function InsertaproevedorLP(numero){
			document.getElementById("Nomb"+numero).innerHTML;
			document.getElementById("IdFiscal"+numero).innerHTML;
			document.getElementById("Proevedor2LP").value = document.getElementById("Nomb"+numero).innerHTML;
			document.getElementById("ProevedorLP").value = document.getElementById("IdFiscal"+numero).innerHTML;
	}

	function InsertadepositoLP(numero){
			document.getElementById("NombD"+numero).innerHTML;
			document.getElementById("IdAlma"+numero).innerHTML;
			document.getElementById("Deposito2LP").value = document.getElementById("NombD"+numero).innerHTML;
			document.getElementById("DepositoLP").value = document.getElementById("IdAlma"+numero).innerHTML;
	}

	function insertaMarcaLP(numero){
			document.getElementById("IdMLP"+numero).innerHTML;
			document.getElementById("NombMLP"+numero).innerHTML;
			document.getElementById("MarcaLPUTA2").value = document.getElementById("NombMLP"+numero).innerHTML;
			document.getElementById("MarcaLPUTA1").value = document.getElementById("IdMLP"+numero).innerHTML;
	}

	function insertaRefLP(numero){
			document.getElementById("ReferenciaLP"+numero).innerHTML;
			document.getElementById("DescripcionReferenciaLP"+numero).innerHTML;
			document.getElementById("RefLP1").value = document.getElementById("ReferenciaLP"+numero).innerHTML;
			document.getElementById("RefLP2").value = document.getElementById("DescripcionReferenciaLP"+numero).innerHTML;
	}

	function FamiliaXX(numero){
			document.getElementById("itemnameXX"+numero).innerHTML;
			document.getElementById("variosXX"+numero).innerHTML;
			document.getElementById("FamiliaXX2").value = document.getElementById("itemnameXX"+numero).innerHTML;
			document.getElementById("FamiliaXX").value = document.getElementById("variosXX"+numero).innerHTML;
	}

	function insertarcodigodesdeXX(numero){
			document.getElementById("CodIdBasX"+numero).innerHTML;
			document.getElementById("DescripX"+numero).innerHTML;
			document.getElementById("DesdeAXX2").value = document.getElementById("DescripX"+numero).innerHTML;
			document.getElementById("DesdeAXX").value = document.getElementById("CodIdBasX"+numero).innerHTML;
			document.getElementById("HastaAXX2").value = document.getElementById("DescripX"+numero).innerHTML;
			document.getElementById("HastaAXX").value = document.getElementById("CodIdBasX"+numero).innerHTML;
	}

	function InsertacodigohastaXX(numero){
			document.getElementById("CodIdBasXAA"+numero).innerHTML;
			document.getElementById("DescripXAA"+numero).innerHTML;
			document.getElementById("HastaAXX2").value = document.getElementById("DescripXAA"+numero).innerHTML;
			document.getElementById("HastaAXX").value = document.getElementById("CodIdBasXAA"+numero).innerHTML;
	}

	function InsertadepositoXX(numero){
			document.getElementById("NombDXX"+numero).innerHTML;
			document.getElementById("IdAlmaXX"+numero).innerHTML;
			document.getElementById("AlmacenAXX2").value = document.getElementById("NombDXX"+numero).innerHTML;
			document.getElementById("AlmacenAXX").value = document.getElementById("IdAlmaXX"+numero).innerHTML;
	}

	function insertaMarcaXX(numero){
			document.getElementById("NombMXX"+numero).innerHTML;
			document.getElementById("IdMXX"+numero).innerHTML;
			document.getElementById("marAX2").value = document.getElementById("NombMXX"+numero).innerHTML;
			document.getElementById("marAX").value = document.getElementById("IdMXX"+numero).innerHTML;
	}

  
	function insertarcodigodesdeAX22Z(numero){
			document.getElementById("CodIdBas2"+numero).innerHTML;
			document.getElementById("Descrip2"+numero).innerHTML;
			document.getElementById("DesdeAX22z22Y").value = document.getElementById("Descrip2"+numero).innerHTML;
			document.getElementById("DesdeAX2z2Y").value = document.getElementById("CodIdBas2"+numero).innerHTML;
			document.getElementById("HastaAX22z2Y").value = document.getElementById("Descrip2"+numero).innerHTML;
			document.getElementById("HastaAX2z2Y").value = document.getElementById("CodIdBas2"+numero).innerHTML;
	}

	function InsertacodigohastaAX22(numero){
			document.getElementById("CodIdBas"+numero).innerHTML;
			document.getElementById("Descrip"+numero).innerHTML;
			document.getElementById("HastaAX22z2Y").value = document.getElementById("Descrip"+numero).innerHTML;
			document.getElementById("HastaAX2z2Y").value = document.getElementById("CodIdBas"+numero).innerHTML;
	}

	function InsertaproevedorAX22(numero){
			document.getElementById("Nomb"+numero).innerHTML;
			document.getElementById("IdFiscal"+numero).innerHTML;
			document.getElementById("BeneficiarioAX22z2").value = document.getElementById("Nomb"+numero).innerHTML;
			document.getElementById("BeneficiarioAX2z2").value = document.getElementById("IdFiscal"+numero).innerHTML;
	}

	function InsertadepositoAX22(numero){
			document.getElementById("NombD"+numero).innerHTML;
			document.getElementById("IdAlma"+numero).innerHTML;
			document.getElementById("AlmacenAX22z2").value = document.getElementById("NombD"+numero).innerHTML;
			document.getElementById("AlmacenAX2z2").value = document.getElementById("IdAlma"+numero).innerHTML;
	}

	function Cantidad(numero){
			document.getElementById("NombD"+numero).innerHTML;
			document.getElementById("IdAlma"+numero).innerHTML;
			document.getElementById("Deposito2NK2").value = document.getElementById("NombD"+numero).innerHTML;
			document.getElementById("DepositoNK2").value = document.getElementById("IdAlma"+numero).innerHTML;
	}

	function insertarcodigodesdeAX2(numero){
			document.getElementById("CodIdBas"+numero).innerHTML;
			document.getElementById("Descrip"+numero).innerHTML;
			document.getElementById("DesdeAX22z").value = document.getElementById("Descrip"+numero).innerHTML;
			document.getElementById("DesdeAX2z").value = document.getElementById("CodIdBas"+numero).innerHTML;
			document.getElementById("HastaAX22z").value = document.getElementById("Descrip"+numero).innerHTML;
			document.getElementById("HastaAX2z").value = document.getElementById("CodIdBas"+numero).innerHTML;
	}

	function InsertacodigohastaAX2(numero){
			document.getElementById("CodIdBas"+numero).innerHTML;
			document.getElementById("Descrip"+numero).innerHTML;
			document.getElementById("HastaAX22z").value = document.getElementById("Descrip"+numero).innerHTML;
			document.getElementById("HastaAX2z").value = document.getElementById("CodIdBas"+numero).innerHTML;
	}

	function InsertaproevedorAX2(numero){
			document.getElementById("Nomb"+numero).innerHTML;
			document.getElementById("IdFiscal"+numero).innerHTML;
			document.getElementById("BeneficiarioAX22z").value = document.getElementById("Nomb"+numero).innerHTML;
			document.getElementById("BeneficiarioAX2z").value = document.getElementById("IdFiscal"+numero).innerHTML;
	}

	function InsertadepositoAX2(numero){
			document.getElementById("NombD"+numero).innerHTML;
			document.getElementById("IdAlma"+numero).innerHTML;
			document.getElementById("AlmacenAX22z").value = document.getElementById("NombD"+numero).innerHTML;
			document.getElementById("AlmacenAX2z").value = document.getElementById("IdAlma"+numero).innerHTML;
	}

	function Cantidad(numero){
			document.getElementById("NombD"+numero).innerHTML;
			document.getElementById("IdAlma"+numero).innerHTML;
			document.getElementById("Deposito2NK2").value = document.getElementById("NombD"+numero).innerHTML;
			document.getElementById("DepositoNK2").value = document.getElementById("IdAlma"+numero).innerHTML;
	}
*/
