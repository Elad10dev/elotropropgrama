<?php
    $IdPais=$_SESSION['IdPais'];
?>
<style>

            @media screen and (max-width: 400px) {
                .text-check {
                    font-size: 0.84em  !important;
                }
            }
.modal{
overflow-y: auto;
}
</style>
<span id='Estees' style='display:none'><?php echo $_SESSION['Ec']; ?></span>

<div class="fixed-top " id='elfixed' style='display:none; padding-top:50px;  z-index:10000;'>
    <div class="col-12 col-sm-6 col-md-5 col-lg-4 col-xl-3 float-end">
        <div id="valida" class="alert alert-danger" role="alert" style="display:none;">
            <span id='contenido'> </span>
        </div>
    </div>
</div>
<header id ="header">
    <div class="container">
        <div class="row">
        
        <div class="col-md-8">
            <?php if($_SESSION['Ec']==0){ ?>
                <h1><i><img src="/img/beneficiarios.png" width="20" height="20"></i> <?php echo lang('Beneficiarios'); ?> </h1>
            <?php } ?>
            <?php if($_SESSION['Ec']==1){ ?>
                <h1><i><img src="/img/beneficiarios.png" width="20" height="20"></i> <?php echo lang('Terceros'); ?> </h1>
            <?php } ?>
        </div>
        <div class="col-md-4"><small><?php echo lang('Cadenas que contienen información acerca del entorno para el sistema y el usuario que ha iniciado sesión en ese momento'); ?></small></div>
        
        </div>
        
    </div>
</header>  


<nav aria-label="breadcrumb">
    <div class="container">
        <ol class="breadcrumb">
            <?php if($_SESSION['Ec']==0){ ?>
                <li class="breadcrumb-item " ><a href="app.php?opcion=configurador.php"><?php echo lang('Configurador'); ?></a></li>
                <li class="breadcrumb-item " ><a href="app.php?opcion=tablasnew.php"><?php echo lang('Tablas'); ?></a></li>
                <li class="breadcrumb-item active" ><?php echo lang('Beneficiarios'); ?></li>
            <?php } ?>
            <?php if($_SESSION['Ec']==1){ ?>
                <li class="breadcrumb-item " ><a href="app.php?opcion=dashboard.php"><?php echo lang('Escritorio'); ?></a></li>
                <li class="breadcrumb-item " ><a href="app.php?opcion=empresasdecontabilidad.php"><?php echo lang('Empresas'); ?></a></li>
                <li class="breadcrumb-item " ><a href="app.php?opcion=configuracioncrud.php&P1=<?php echo $_SESSION['CTBIdCompany']; ?>&P2=<?php echo $_SESSION['CTBIdEmpresa']; ?>&P3=<?php echo $_SESSION['CTBOrigen']; ?>&P4=<?php echo $_SESSION['CTBlitfiscal']; ?>&P5=<?php echo $_SESSION['CTBidfiscal']; ?>&P6=<?php echo $_SESSION['CTBcomercio']; ?>"><?php echo $_SESSION['CTBcomercio']; ?></a></li>
                <li class="breadcrumb-item " ><a href="app.php?opcion=tablacontabilidad.php&P7=<?php echo $_SESSION['CTBPeriodo']; ?>&P8=<?php echo $_SESSION['CTBPeriodoNom']; ?>"><?php echo $_SESSION['CTBPeriodoNom']; ?></li></a>
                <li class="breadcrumb-item active" ><?php echo lang('Terceros'); ?></li>
            <?php } ?>
            
        </ol>
    </div>
</nav>

<div  class="container" style='padding-bottom:78px;'>
        <div class="btn-group ">
            <form style="display:none" id="formexcel" action="excelv3.php" method="post">
                <?php
                $abc = $_POST["litfiscal"]; 
                $q="SELECT RUT as $abc, CodIntDeudor as Codigo_Interno, codBarra as Codigo_De_Barras,Nombre,Fono as Telefono,Direccion,TipoCredito as Monto_Maximo_de_Crédito,Comuna,Giro as Giro_Comercial FROM PosUpclientes WHERE IdCompany=".$_POST["Company"].$search;
                ?>
                <?php
                    if($_SESSION['Ec']==0){
                        $name = "Beneficiarios.csv";
                    }
                    if($_SESSION['Ec']==1){
                        $name = "Terceros.csv";
                    }
                ?>
                <input type="hidden" name="Qry" id="Qry" value="<?php echo $q; ?>"/>
                <input type="hidden" name="Name" id="Name" value="<?php echo $name; ?>"/>
                <input type="hidden" name="ser" id="ser" value=""/>
            </form>
        </div>

        <div class="row input-group">
            <div class="col-12 mb-2">
                <div class="form-floating">
                    <input class="form-control" type="search" id="search-prod" name="search-prod" placeholder="" value="" onkeyup="Pagineo(1);"/>
                    <label ><span class="fa fa-search"></span>&nbsp;<?php echo lang('Buscar:'); ?></label>
                </div>
            </div>
        </div>
    <spam id="resultadobusca">
        <input type="hidden" name="Limit" id='Limit' value='10'>
        <span id='PagAct' style='display:none;'>1</span>
        <span id='Rpa' style='display:none;'>10</span>
    </spam>
</div>

<div id="apps-modal" class="modal fade" tabindex="1" role="dialog" style="">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4>
                    <?php
                        if($_SESSION['Ec']==0){
                            echo lang('Editar Beneficiario'); 
                        }
                        if($_SESSION['Ec']==1){
                            echo lang('Editar Tercero'); 
                        }
                    ?>
                </h4>
                <div class="card-actions">
                    <div class='float-end'>
                        <button data-bs-dismiss="modal" class='btn  btn-primary' type="button"><span class="fa fa-close"></span></button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                 <form class="fieldset" method="post" id="formdata">
                        <span id='pospucio' style='display:none;'><?php echo $IdPais; ?></span>
                        <div class="form-group row">

                        
                            <input type="hidden" class="form-control" id="tabla" name="tabla" value="beneficiarios" />
                            <input type="hidden" class="form-control" id="companyUser" name="companyUser" value="<?php echo $_SESSION["CompanyActual"];?>" />
                            <input type="hidden" class="form-control" id="edit" name="edit" value="" />
                            <input type="hidden" class="form-control" id="new" name="new" value="" />
                            <span id='usuario' style='display:none;'><?php echo $usuario; ?></span>
                            
                            <div class="row input-group text-check" > 
                                <div class="col-6 col-md-6 col-lg-3 text-left" >
                                        <input type="checkbox" name="ModalCli" id="ModalCli"></input>
                                        <label  class="text-responsive" ><?php echo lang('Es'); ?>&nbsp;<?php echo lang('Cliente'); ?></label>
                                </div>

                                <div class="col-6 col-md-6 col-lg-3 text-left" >
                                        <input type="checkbox" name="ModalProv" id="ModalProv"></input>
                                        <label  class="text-responsive" ><?php echo lang('Es'); ?>&nbsp;<?php echo lang('Proveedor'); ?></label>
                                </div> 

                                <div class="col-6 col-md-6 col-lg-3 text-left" >
                                        <input type="checkbox" name="ModalTrab" id="ModalTrab"></input>
                                        <label  class="text-responsive"><?php echo lang('Es'); ?>&nbsp;<?php echo lang('Trabajador'); ?></label>
                                </div> 

                                <div class="col-6 col-md-6 col-lg-3 text-left" >
                                        <input type="checkbox" name="ModalOtro" id="ModalOtro"></input>
                                        <label  class="text-responsive"><?php echo lang('Es'); ?>&nbsp;<?php echo lang('Otro'); ?></label>
                                </div> 

                                <div class="col-xs-12 col-md-6 col-lg-3 text-left">
 

                                </div> 

                            </div> 
                                <div class="col-xs-12 col-md-12 col-lg-12 text-left" style='visibility:hidden'>
                                        <label  class="text-responsive" >Estado</label>
                                </div> 

                            <div class="row input-group text-check" >
                                <div class="col-12 col-lg-6">

                                    <?php if($IdPais=='CL'){ ?> 
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="ModalRut" name="ModalRut" onchange='dgv(this.value)' />
                                            <input type="text" class="form-control" id="ModalRut2" name="ModalRut2" readonly/>
                                            <label ><span  class="fa fa-university" ></span>&nbsp;<?php echo lang('RUT'); ?></label>
                                        </div>
                                    <?php }else{ ?> 
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="ModalRif" name="ModalRif" />
                                            <label ><span  class="fa fa-university" ></span>&nbsp;<?php echo $_SESSION["litfiscal"]; ?></label>
                                        </div>
                                    <?php } ?> 
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="ModalNombre" name="ModalNombre" />
                                        <label ><span  class="fa fa-university" ></span>&nbsp;<?php echo lang('Razón Social'); ?></label>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-6">


                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="ModalCodb" name="ModalCodb" />
                                        <label ><span  class="fa fa-barcode" ></span>&nbsp;<?php echo lang('Codigo de Barras'); ?></label>
                                    </div>
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="ModalEmailCorreo" name="ModalEmailCorreo" />
                                        <label ><span  class="fa fa-envelope" ></span>&nbsp;<?php echo lang('Email'); ?></label>
                                    </div>


                                </div>

                                <div class="col-12 col-lg-6">

                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="ModalCid" name="ModalCid" />
                                        <label ><span  class="fa fa-info-circle" ></span>&nbsp;<?php echo lang('Código Interno'); ?></label>
                                    </div>
                                    
                                    <div class="input-group   col-lg-4" >
                                        <label  class="text-responsive" >&nbsp;</label>
                                    </div> 
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="ModalTelf" name="ModalTelf" />
                                        <label ><span  class="fa fa-phone" ></span>&nbsp;<?php echo lang('Teléfono'); ?></label>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="ModalDir" name="ModalDir" />
                                        <label ><span  class="fa fa-map-marker" ></span>&nbsp;<?php echo lang('Dirección'); ?></label>
                                    </div>
                                    <div class="input-group   col-lg-4" >
                                        <label  class="text-responsive" ><input type="checkbox" id="ModalEdoc" name="ModalEdoc"></input>&nbsp;<?php echo lang('Crédito'); ?>&nbsp;<?php echo lang('Permitido'); ?></label>
                                    </div> 

                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="ModalTipoc" name="ModalTipoc" />
                                        <label ><span  class="fa fa-usd" ></span>&nbsp;<?php echo lang('Crédito Máximo'); ?></label>
                                    </div> 
                                </div>

                                <div class="col-12 col-lg-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="ModalGiro" name="ModalGiro"/>
                                        <label ><span  class="fa fa-tag" ></span>&nbsp;<?php echo lang('Giro'); ?></label>
                                    </div>
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="ModalCiudad" name="ModalCiudad"/>
                                        <label ><span  class="fa fa-map-marker" ></span>&nbsp;<?php echo lang('Ciudad'); ?></label>
                                    </div>
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="ModalCom" name="ModalCom" onclick="comuna()" readonly/>
                                        <label ><span  class="fa fa-map-marker" ></span>&nbsp;<?php echo lang('Comuna'); ?></label>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-6">

                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="ModalPro" name="ModalPro" onclick="comuna()" readonly/>
                                        <label ><span  class="fa fa-map-marker" ></span>&nbsp;<?php echo lang('Provincia'); ?></label>
                                    </div>
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="ModalReg" name="ModalReg" onclick="comuna()"  readonly/>
                                        <label ><span  class="fa fa-map-marker" ></span>&nbsp;<?php echo lang('Region'); ?></label>
                                    </div>
                                    <div class="my-2 py-2 col-lg-4 ps-2 " >
                                        <label  class="text-center text-responsive" ><?php echo lang('Estado'); ?></label>
                                        <input type="checkbox" name="ModalEdo" id="ModalEdo"></input>
                                    </div> 
                                </div>  
                                <div class="col-12 col-lg-6" style='display:none'>

                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="latitud" name="latitud"  readonly/>
                                        <label ><span  class="fa fa-globe" ></span>&nbsp;<?php echo lang('Latitud'); ?></label>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-6" style='display:none' >
                                    <div class="input-group mb-2 col-md-4" >
                                        <input type="text" class="form-control" id="longitud" name="longitud"   readonly/>
                                        <label ><span  class="fa fa-globe" ></span>&nbsp;<?php echo lang('Longitud'); ?></label>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-md-3 col-lg-1 ">
                                    <label style="display:none" for="ModalDeudamb">Deuda Max Boleta</label>
                                    <input style="display:none" type="number" class="form-control" id="ModalDeudamb" name="ModalDeudamb"/>
                                </div>

                                <div class="col-xs-6 col-md-3 col-lg-1 ">
                                    <label style="display:none" for="ModalDeudaml">Deuda Max Libreta</label>
                                    <input style="display:none" type="number" class="form-control" id="ModalDeudaml" name="ModalDeudaml"/>
                                </div>

                                <div class="col-xs-1">
                                    <label style="display:none" for="ModalFechap1">Fecha de Pago 1</label>
                                    <input style="display:none" type="number" class="form-control" id="ModalFechap1" name="ModalFechap1"/>
                                </div>

                                <div class="col-xs-1">
                                    <label style="display:none"for="ModalFechap2">Fecha de Pago 2</label>
                                    <input style="display:none"type="text" class="form-control" id="ModalFechap2" name="ModalFechap2"/>
                                </div>

                                <div class="col-xs-1">
                                    <label style="display:none" for="ModalNroc">Nro Corr</label>
                                    <input style="display:none" type="text" class="form-control" id="ModalNroc" name="ModalNroc"/>
                                </div>

                                <div class="col-xs-1">
                                    <label style="display:none" for="ModalCredf">Credito Factura</label>
                                    <input style="display:none" type="number" class="form-control" id="ModalCredf" name="ModalCredf"/>
                                </div>
                                    
                                <div class="col-xs-1">
                                    <label style="display:none" for="ModalCredu">Credito Usado</label>
                                    <input style="display:none" type="number" class="form-control" id="ModalCredu" name="ModalCredu"/>
                                </div> 
                            </div>

                        </div>



                        <div class="modal-footer">
                            <button class="btn  btn-primary" type="button" id='JoseMadero1' data-bs-dismiss="modal"><?php echo lang('Cerrar'); ?></button>
                            <button class="btn  btn-success" type="button" id='JoseMadero2' onclick="guardar();"><?php echo lang('Guardar'); ?> </button>
                        </div>
                </form>
                 <script>
                        jQuery(document).ready(function(){
                            // Listen for the input event.
                            jQuery("#ModalRut").on('input', function (evt) {
                                // Allow only numbers.
                                jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
                            });
                        });

                        var input=  document.getElementById('ModalRut');
                        input.addEventListener('input',function(){
                        if (this.value.length > 8) 
                            this.value = this.value.slice(0,8); 
                        })
                        function dgv(T){  
                            var M=0,S=1;
                            for(;T;T=Math.floor(T/10))
                            S=(S+T%10*(9-M++%6))%11;
                            //return S?S-1:'k';
                            
                            document.getElementById('ModalRut2').value = S?S-1:'k';
                        }  
                </script>
            </div>
        </div>
    </div>
</div>

<script>

    window.onload = function(){
        MuestraProd();
}

    function Pagineo(n){
        document.getElementById("ser").value=" and CONCAT(RUT,CodIntDeudor,codBarra,Nombre) like '%"+document.getElementById("search-prod").value+"%'"; 
        document.getElementById("PagAct").innerHTML=n;  
        MuestraProd();
    }
    function MuestraProd(){
        var valor = document.getElementById("PagAct").innerHTML;
        var valor2 = document.getElementById("Rpa").innerHTML;
        var valor3 = document.getElementById("search-prod").value;
        var valor4 = document.getElementById("Limit").value;
            $.ajax({
            type: "POST",
            url: "Dataseek1.php",
            data:{Accion:'8',normal:'1',litfiscal:'<?php echo $_SESSION["litfiscal"];?>', userperfil: '<?php echo $_SESSION["userperfil"] ?>',Limite:valor4,Search:valor3,Company:<?php echo $_SESSION["CompanyActual"]; ?>,CD:<?php echo $_SESSION["CD"]; ?>,SimDec:'<?php echo $_SESSION["SimDec"]; ?>',SimMil:'<?php echo $_SESSION["SimMil"]; ?>',MonedaP:'<?php echo $_SESSION["MonedaP"];?>',PagAct:valor,Rpa:valor2}
            }).done(function(msg){
                document.getElementById("loading").style.display = "none";

            $("#resultadobusca").html(msg);  

            });

            $('#exito').hide(); 
            $('#fracaso').hide(); 
            document.getElementById("search-prod").focus(); 

    }

    function OcultarNotificacion(){
        $('#exito').hide();
        $('#fracaso').hide(); 
        $('#valida').hide(); 
        document.getElementById('elfixed').style.display="none";
        document.getElementById("loading").style.display = "none";
        document.getElementById('maintop').style.display="none";
    }

    function validaForm(){
        // Campos de texto
        // alert(2);
        if($("#ModalRif").val() == ""){
            document.getElementById('contenido').innerHTML="<?php echo lang('El campo Id Tributario Fiscal no puede estar vacío.'); ?>";
            $("#ModalRif").focus();
            return false;
        }
        if($("#ModalNombre").val() == ""){
            document.getElementById('contenido').innerHTML="<?php echo lang('El campo Razón Social no puede estar vacío.'); ?>";
            $("#ModalNombre").focus();
            return false;
        }
        
        if($("#ModalCli").prop('checked') == false && $("#ModalProv").prop('checked') == false && $("#ModalTrab").prop('checked') == false && $("#ModalOtro").prop('checked') == false) {
            document.getElementById('contenido').innerHTML="<?php echo lang('Debe elegir que tipo de beneficiarios es'); ?>";
            return false;
        }

        return true;
    }
    
        
    function guardar(){
        $('#JoseMadero1').prop('disabled', true);
        $('#JoseMadero2').prop('disabled', true);
        if(validaForm()){  
            document.getElementById("loading").style.display = "flex";
            $.post("DataHandlerc.php",$("#formdata").serialize(),function(res){
                if(res == 1){
                    $("#exito").delay(500).fadeIn("slow");  
                    document.getElementById('maintop').style.display="block";
                    setTimeout(() => OcultarNotificacion(), 4000);
                    Pagineo(document.getElementById("PagAct").innerHTML);
                    $('#apps-modal').modal('toggle');
                    $('#JoseMadero1').prop('disabled', false);
                    $('#JoseMadero2').prop('disabled', false); 
                } else {
                    if(res.trim() == 3){
                        $('#apps-modal').modal('show');
                        document.getElementById('contenido').innerHTML="<?php echo lang('IDENTIFICACION FISCAL EXISTENTE INTENTE DE NUEVO'); ?>";
                        $('#JoseMadero1').prop('disabled', false);
                        document.getElementById('elfixed').style.display="block";
                        $("#valida").delay(200).fadeIn("slow");  
                        setTimeout(() => OcultarNotificacion(), 5000);
                        $('#JoseMadero2').prop('disabled', false); 
                    } else {
                        document.getElementById('maintop').style.display="block";
                        $("#fracaso").delay(500).fadeIn("slow"); 
                        setTimeout(() => OcultarNotificacion(), 4000);
                        $('#JoseMadero1').prop('disabled', false);
                        $('#JoseMadero2').prop('disabled', false); 
                    }
                }
            });
        }  else {
        document.getElementById('elfixed').style.display="block";
        $("#valida").delay(200).fadeIn("slow");  
        setTimeout(() => OcultarNotificacion(), 5000);
            $('#JoseMadero1').prop('disabled', false);
            $('#JoseMadero2').prop('disabled', false);
        }  
    }

    function recibir(numero){
        $('#apps-modal').modal('show'); 
        $('#exito').hide(); 
        $('#fracaso').hide();
        
        //alert(numero);
        if (numero > 0) {
            
            document.getElementById("new").value="1";
            if(document.getElementById('pospucio').innerHTML == 'CL'){
                var cadena = document.getElementById("rif"+numero).innerHTML;
                document.getElementById("ModalRut").readOnly = true
                document.getElementById("ModalRut2").readOnly = true
                document.getElementById('ModalRut').value = cadena.split("-",1);
                document.getElementById('ModalRut2').value = cadena.substr(-1);
            }else{
                document.getElementById("ModalRif").readOnly = true
                valor = document.getElementById("rif"+numero);
                document.getElementById("ModalRif").value=valor.innerHTML;
            }
            
            valor = document.getElementById("cid"+numero);
            document.getElementById("ModalCid").value=valor.innerHTML;
            valor = document.getElementById("codb"+numero);
            document.getElementById("ModalCodb").value=valor.innerHTML;
            valor = document.getElementById("nom"+numero);
            document.getElementById("ModalNombre").value=valor.innerHTML;
            valor = document.getElementById("telf"+numero);
            document.getElementById("ModalTelf").value=valor.innerHTML;
            valor = document.getElementById("dir"+numero);
            document.getElementById("ModalDir").value=valor.innerHTML;
            valor = document.getElementById("tipoc"+numero);
            document.getElementById("ModalTipoc").value=valor.innerHTML;

            
            document.getElementById("latitud").value=document.getElementById("lat"+numero).innerHTML;
            document.getElementById("longitud").value=document.getElementById("lon"+numero).innerHTML;



            valor = document.getElementById("deudamb"+numero);
            document.getElementById("ModalDeudamb").value=valor.innerHTML;                    
            valor = document.getElementById("deudaml"+numero);
            document.getElementById("ModalDeudaml").value=valor.innerHTML;
            valor = document.getElementById("fechap1"+numero);
            document.getElementById("ModalFechap1").value=valor.innerHTML;
            valor = document.getElementById("fechap2"+numero);
            document.getElementById("ModalFechap2").value=valor.innerHTML;
            valor = document.getElementById("nroc"+numero);
            document.getElementById("ModalNroc").value=valor.innerHTML;
            valor = document.getElementById("com"+numero);
            document.getElementById("ModalCom").value=valor.innerHTML;
            valor = document.getElementById("giro"+numero);
            document.getElementById("ModalGiro").value=valor.innerHTML;
            valor = document.getElementById("credf"+numero);
            document.getElementById("ModalCredf").value=valor.innerHTML;
            valor = document.getElementById("credu"+numero);
            document.getElementById("ModalCredu").value=valor.innerHTML;

            valor = document.getElementById("email"+numero);
            document.getElementById("ModalEmailCorreo").value=valor.innerHTML;
            document.getElementById("ModalPro").value=document.getElementById("provinciaS"+numero).innerHTML;
            document.getElementById("ModalReg").value=document.getElementById("regionS"+numero).innerHTML;

            valor = document.getElementById("edoc"+numero).innerHTML;
            if (valor==="1"){
                $('#ModalEdoc').prop('checked', true);
            }else{
                $('#ModalEdoc').prop('checked', false); 
            }
            valor = document.getElementById("edo"+numero).innerHTML;
            if (valor==="1"){
                $('#ModalEdo').prop('checked', true);
            }else{
                $('#ModalEdo').prop('checked', false);    
            }

            valor = document.getElementById("cli"+numero).innerHTML;
            if (valor==="1"){
                $('#ModalCli').prop('checked', true);
            }else{
                $('#ModalCli').prop('checked', false);    
            }

            valor = document.getElementById("prov"+numero).innerHTML;
            if (valor==="1"){
                $('#ModalProv').prop('checked', true);
            }else{
                $('#ModalProv').prop('checked', false);    
            }

            valor = document.getElementById("trab"+numero).innerHTML;
            if (valor==="1"){
                $('#ModalTrab').prop('checked', true);
            }else{
                $('#ModalTrab').prop('checked', false);    
            }

            valor = document.getElementById("otro"+numero).innerHTML;
            if (valor==="1"){
                $('#ModalOtro').prop('checked', true);
            }else{
                $('#ModalOtro').prop('checked', false);    
            }

            valor = document.getElementById("ciudadxd"+numero);
            document.getElementById("ModalCiudad").value=valor.innerHTML;
        } else {
            posicion();
            if(document.getElementById("latitud").value==''){
                document.getElementById("latitud").value='0';
            }
            if(document.getElementById("longitud").value==''){
                document.getElementById("longitud").value='0';

            }
            document.getElementById("new").value="0";
            if(document.getElementById('pospucio').innerHTML == 'CL'){
                document.getElementById("ModalRut").readOnly = false;
                document.getElementById("ModalRut2").readOnly = true;
                document.getElementById('ModalRut').value = '';
                document.getElementById('ModalRut2').value = '';
            }else{
                document.getElementById("ModalRif").readOnly = false
                document.getElementById("ModalRif").value="";
            }
            document.getElementById("ModalCid").value="";
            document.getElementById("ModalCodb").value="";
            document.getElementById("ModalNombre").value="";
            document.getElementById("ModalTelf").value="";
            document.getElementById("ModalDir").value="";
            document.getElementById("ModalTipoc").value="0";
            document.getElementById("ModalEmailCorreo").value="";
            
            $('#ModalEdoc').prop('checked', false);

            document.getElementById("ModalDeudamb").value="0";
            document.getElementById("ModalDeudaml").value="0";
            document.getElementById("ModalFechap1").value="0";
            document.getElementById("ModalFechap2").value="";
            document.getElementById("ModalNroc").value="";
            document.getElementById("ModalCom").value="";
            document.getElementById("ModalGiro").value="";
            document.getElementById("ModalCredf").value="0";
            document.getElementById("ModalCredu").value="0";
            document.getElementById("ModalPro").value='';
            document.getElementById("ModalReg").value='';
            document.getElementById("ModalCiudad").value='';
            
            $('#ModalEdo').prop('checked', true);
            $('#ModalCli').prop('checked', false);
            $('#ModalProv').prop('checked', false);
            $('#ModalTrab').prop('checked', false);
            $('#ModalOtro').prop('checked', false);
        
        }
    } 
            
    function alertaborrar(numero){
        var mensaje;
        var opcion = confirm("<?php echo lang('¿DESEA BORRAR?'); ?>");
        var valor = document.getElementById("rif"+numero);
        var valor2 = document.getElementById("Compa"+numero).value;
        
        //alert(valor.innerHTML);
        //alert(valor2);
        if (opcion == true) {
            document.getElementById("loading").style.display = "flex";
            $.ajax({
                type: "POST",
                url: "DataHandlerc.php",
                data:{borrar: "1", ModalRif: valor.innerHTML, companyUser: valor2,tabla:"beneficiarios"}
            }).done(function(msg){
                //alert(msg);
                if (msg == 1) {
                    document.getElementById('maintop').style.display="block";
                    $("#exito").delay(500).fadeIn("slow");  
                    setTimeout(() => OcultarNotificacion(), 3000);
                    Pagineo(document.getElementById("PagAct").innerHTML);
                
                }else{
                    document.getElementById('maintop').style.display="block";
                    $("#fracaso").delay(500).fadeIn("slow");
                    setTimeout(() => OcultarNotificacion(), 3000);
                    // alert(msg);
                }
            });
        }
        document.getElementById("ejemplo").innerHTML = mensaje;
    }

    function comuna(){

        $('#apps-modal2y2').modal('show');
        MuestraProd3();

    }
     //   $("#toolsapp").html("</button><button type='submit' value='export_data' onclick='document.getElementById(`formexcel`).submit()' class='botonproceso'><img src='/img/excel.png' width='32' height='32' ><br>Exportar</button>");
       // $("#TituloHeaderA").html("<img src='/img/beneficiarios.png' width='16' height='16'/> MODULO DE BENEFICIARIOS ");



















</script>

<div class="app-ui-mask-modal"></div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRK6GynrUmaQmP2uwp90hzKNXOPpjk-mY&callback=initMap&callback=initMap&libraries=&v=weekly" async ></script>


<script>
      // Note: This example requires that you consent to location sharing when
      // prompted by your browser. If you see the error "The Geolocation service
      // failed.", it means you probably did not give permission for the browser to
      // locate you.
      let map;
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
                : "Error: Your browser doesn't support geolocation."
            );
            infoWindow.open(map);
    }


    function posicion(){
    
        infoWindow = new google.maps.InfoWindow();

          // Try HTML5 geolocation.  
          if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
              (position) => {
                const pos = {
                  lat: position.coords.latitude,
                  lng: position.coords.longitude,
                };
                infoWindow.setPosition(pos);
                map.setCenter(pos);



                // zona de script 
                document.getElementById("latitud").value= position.coords.latitude;
                document.getElementById("longitud").value= position.coords.longitude;



                //------------------------------------------



              },
              () => {
                handleLocationError(true, infoWindow, map.getCenter());
              }
            );



          } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, infoWindow, map.getCenter());
          }
    }

    

</script>
    <div id="map" style='display:none'></div>


















<div id="apps-modal2y2" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!--Apps card -->
            <div class="modal-header">
                    <h4><?php echo lang('Comuna'); ?></h4>
                    <div class="card-actions">
                        <div class='float-end'>
                            <button data-bs-dismiss="modal" class='btn  btn-primary' type="button"><i class="fa fa-close"></i></button>
                        </div>
                    </div>
            </div>

                <div class="card">
                        <form class="navbar-form navbar-right app-search-form" role="search" action="/app.php" method="post">
                            <div class="row input-group">
                                    <div class="col-12 col-md-6">
                                        <div class="input-group mb-2 col-md-4" >
                                            <label ><span class="fa fa-search"></span>&nbsp;<?php echo lang('Buscar:'); ?></span>
                                            <input class="form-control" type="search" id="search-prodD" name="search-prodD" placeholder="" value="" onkeyup="PagineoD(1);"/>
                                        </div>
                                    </div>
                                </div>
                        </form>
                        <span id="resultadobuscaD">
                            <spam style="visibility:hidden" id="PagActD">1</spam>
                            <span style="visibility:hidden" id="RpaD">1</span>
                            <input style="visibility:hidden" type="text" name="LimitD" id="LimitD" value="10">
                        </span>
                        <input style="visibility:hidden" type="text" name="OrganizadorD" id="OrganizadorD">
                </div>

            <!-- END Apps card -->
        </div>
    </div>
</div>



<script>
                        function enviar3(numero){
                            document.getElementById("ModalCom").value = document.getElementById("comuna_nombre"+numero).innerHTML;
                            document.getElementById("ModalPro").value = document.getElementById("provincia"+numero).innerHTML;
                            document.getElementById("ModalReg").value = document.getElementById("region"+numero).innerHTML;
                        }

                        function PagineoD(n){
                            document.getElementById("PagActD").innerHTML=n;
                            MuestraProd3();
                        }
                        function MuestraProd3(n) {
                            var valor = document.getElementById("PagActD");
                            var valor2 = document.getElementById("RpaD");
                            var valor3 = document.getElementById("search-prodD").value;
                            var valor4 = document.getElementById("LimitD").value;

                            $.ajax({
                            type: "POST",
                            url: "dataseeks/Dataseek2r.php",
                            data:{search:'ComunaFA',PaisId: '<?php echo $_SESSION["IdPais"]; ?>',userperfil: '<?php $_SESSION["userperfil"] ?>',Limite:valor4,Search:valor3,Company:<?php echo $_SESSION["CompanyActual"]; ?>,CD:<?php echo $_SESSION["CD"]; ?>,SimDec:'<?php echo $_SESSION["SimDec"]; ?>',SimMil:'<?php echo $_SESSION["SimMil"]; ?>',MonedaP:'<?php echo $_SESSION["MonedaP"];?>',PagAct:valor.innerHTML,Rpa:valor2.innerHTML}
                            }).done(function(msg){
                                $("#resultadobuscaD").html(msg);  
                                if(n==0){
                                    document.getElementById("search-co").value = document.getElementById("ComunaFA").value;
                                    document.getElementById("search-co").focus(); 
                                }
                            });

                            $('#exito').hide(); 
                            $('#fracaso').hide(); 
                            document.getElementById("search-co").focus(); 
                        }
</script>