<?php
require ROOT_PATH . "views/shared/content-float-modal.php";
?>	
<?php

function fncTitle() { ?>Nuevo Chofer<?php } ?>

<?php

function fncHead() { ?>
<script type="text/javascript" src="include/js/jForm.js"></script>
    
<?php } ?>

<?php

function fncTitleHead() { ?><i class="fa fa-address-card-o" aria-hidden="true"></i> Nuevo Chofer<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>
<?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1) { ?>
<form id="form"  method="POST" action="/Mantenimiento/Chofer_Mantenimiento_Nuevo" onsubmit="return validar();" >
    <div class="panel panel-tab rounded shadow">
        <div class="panel-body no-padding rounded-bottom">
            <div class="tab-content form-horizontal">
                <div id="divDatos" class="tab-pane fade in active inner-all">
    <div class="form-group">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <label>Persona: </label>&nbsp;&nbsp;&nbsp;<a class="btn btn-success" title="Agregar persona nueva" onclick="fncAgregar_Persona();"><img src="/include/img/boton/add_user-20.png"></a>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <input type="hidden" id="txtPersona_ID" name="txtPersona_ID" class="form-control form-requerido" >
            <input type="text" id="listaPersonas" name="listaPersonas" class="form-control">
            <script>
            $(document).ready(function(){
                lista('/funcion/ajaxListarPersonas','listaPersonas','txtPersona_ID',mostrar_informacion_persona);
            });
            </script>
        </div>

    </div>
    <div class="form-group">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <label>Licencia conducir: </label>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <input type="text" id="txtLicencia_Conducir" name="txtLicencia_Conducir" value="<?php echo $GLOBALS['oChofer']->licencia_conducir;?>" autocomplete="off" class="form-control form-requerido">
        </div>
    </div>
    <div class="form-group">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <label>Celular: </label>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <input type="text" id="txtCelular" name="txtCelular" value="<?php echo $GLOBALS['oChofer']->celular;?>" autocomplete="off" class="form-control bfh-number int">
        </div>
    </div>
    <div class="form-group">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <label>Estado: </label>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <select id="selEstado_ID" name="selEstado_ID" class="form-control form-requerido">
                <?php foreach($GLOBALS['oChofer']->dtEstado as $item){ ?>
                <option value="<?php echo $item['ID']?>"><?php echo strtoupper($item['nombre']);?></option>
                <?php } ?>
            </select>

        </div>
    </div>
        </div>
            </div>
        </div>
        <div class="panel-footer">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <button  id="btnEnviar" name="btnEnviar" class="btn btn-success" title="Guardar">
                <img alt="" width="16" src="/include/img/boton/save_48x48.png">
                Guardar
            </button>
            <button  id="btnCancelar" name="btnCancelar"  class="btn btn-danger" type="button" title="Salir" onclick="salir();" >
                <img  alt="" src="/include/img/boton/cancel_14x14.png">
                Cancelar
            </button>  
        </div>
    </div>
        </div>
    </div>
</form>
<?php } ?>
<script type="text/javascript">
    var validar=function(){
        var persona_ID=$.trim($("#txtPersona_ID").val());
        var licencia_conducir=$.trim($('#txtLicencia_Conducir').val());
        
        if(persona_ID=="" || persona_ID == '0'){
            mensaje.error("Mensaje de error","Debe seleccionar una persona",'txtPersona_ID');
            return false;
        }
       
        if(typeof($('#sendtxtPersona_ID'))=="undefined"){
            mensaje.error("Mensaje de error","Debe seleccionar una persona",'txtPersona_ID');
            return false;
        }
        if(licencia_conducir==""){
            mensaje.error("Mensaje de error","Debe registrar el número de licencia de conducir",'txtLicencia_Conducir');
            return false;
        
        }
    }
    var fncAgregar_Persona=function(){
       parent.window_float_open_modal_hijo('REGISTRAR NUEVO PERSONA','/Mantenimiento/Persona_Mantenimiento_Nuevo_Otro','','',fncCargarPersona,800,500);
        
    } 
    var fncCargarPersona=function(id){
       cargarValores('/Funcion/ajaxExtraerInformacionPersona',id,function(resultado){
            $('#txtPersona_ID').val(id);
            $('#listaPersonas').val(resultado.oPersona.apellido_paterno+' '+resultado.oPersona.apellido_materno+' '+resultado.oPersona.nombres);
            mostrar_informacion_persona(id);
        }); 
    }
    
    var mostrar_informacion_persona=function(id){
        cargarValores('/Funcion/ajaxExtraerInformacionPersona',id,function(resultado){
            $('#txtCelular').val(resultado.oPersona.celular);
        });
    }
    
    var salir=function(){
        window_float_close_modal();
    }
    
</script>
<?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 1) { ?>
    
    <script type="text/javascript">
        $(document).ready(function(){
            toastem.success("<?php echo $GLOBALS['mensaje']; ?>");
            setTimeout('window_float_save_modal();', 1000);
        });       
       
       
    </script>
<?php } ?>
<?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == -1) { ?>
    
    <script type="text/javascript">
        $(document).ready(function(){
            toastem.error("<?php echo $GLOBALS['mensaje']; ?>");
        });       
       
       
    </script>
<?php } ?>
<?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 0) { ?>
    <div class="float-mensaje">
        <?php echo $GLOBALS['mensaje']; ?>
    </div>
    <div class="group-btn">
        <input type="button" onclick ="redireccionar_parent('/');" value ="Iniciar Sesión"/>
    </div>
<?php } ?>
<?php } ?>
