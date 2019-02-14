<?php
require ROOT_PATH . "views/shared/content-float-modal.php";
?>	
<?php

function fncTitle() { ?>Editar Operador<?php } ?>

<?php

function fncHead() { ?>

    <script type="text/javascript" src="include/js/jForm.js"></script>
    <script type="text/javascript" src="include/js/jTeclas.js"></script>
   
    
<?php } ?>

<?php

function fncTitleHead() { ?>Editar Operador<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>
    <?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1) { ?>
<form id="form" method="POST"  action="/Mantenimiento/Operador_Mantenimiento_Editar/<?php echo $GLOBALS['oOperador']->ID;?>" class="form-horizontal" onsubmit="return validar();">
    <div class="form-body">
        <div class="form-group">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <label>Persona:</label>&nbsp;&nbsp;&nbsp;<a class="btn btn-success" title="Agregar persona nueva" onclick="fncAgregar_Persona();"><img src="/include/img/boton/add_user-20.png"></a>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <input type="hidden" id="txtPersona_ID" name="txtPersona_ID" class="form-control form-requerido" value="<?php echo $GLOBALS['oOperador']->persona_ID;?>">
                <input type="text" id="listaPersonas" name="listaPersonas" class="form-control" value="<?php echo $GLOBALS['oOperador']->nombres_completo;?>">
                <script>
                $(document).ready(function(){
                    lista('/funcion/ajaxListarPersonas','listaPersonas','txtPersona_ID',mostrar_informacion_persona);
                });
                </script>
            </div>
        </div>
        <div class="form-group">

            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <label>Fecha Contrato:</label>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <input id="txtFecha_Contrato" name="txtFecha_Contrato" type="text" class="date-range-picker-single form-control" autocomplete="off" value="<?php echo $GLOBALS['oOperador']->fecha_contrato; ?>"/>

            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <label>Teléfono:</label>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <input id="txtTelefono" name="txtTelefono" type="text" autocomplete="off" value="<?php echo $GLOBALS['oOperador']->telefono; ?>" class="form-control"/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <label>Celular:</label>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <input id="txtCelular" name="txtCelular" type="text" autocomplete="off" value="<?php echo $GLOBALS['oOperador']->celular; ?>" class="form-control"/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <label>Correo:</label>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <input id="txtMail"  name="txtMail" type="email" autocomplete="off" value="<?php echo $GLOBALS['oOperador']->mail; ?>" class="form-control"/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <label>Comision:</label>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <input id="txtComision" name="txtComision" type="text" autocomplete="off" value="<?php echo $GLOBALS['oOperador']->comision; ?>" placeholder="%" class="decimal form-control"/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <label>Cargo:</label>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <select name="selCargo" id="selCargo" class="form-control form-requerido">
                <?php foreach ($GLOBALS['oOperador']->dtCargo as $valor) {?>
                    <option value="<?php echo $valor['ID'] ?>"> <?php echo $valor['nombre'] ?></option>
                <?php } ?>
                </select>

            </div>
        </div>
    </div>
    <div class="form-footer">
        <div class="pull-left">
            <button  id="btnEnviar" name="btnEnviar" class="btn btn-success">
                <img title="Guardar" alt="" src="/include/img/boton/save_14x14.png">
                Guardar
            </button>
            <button  id="btnCancelar" name="btnCancelar" type="button" onclick="window_float_close_modal();" class="btn btn-danger">
                <img title="Guardar" alt="" src="/include/img/boton/cancel_14x14.png">
                Cancelar
            </button>
        </div>
        <div class="clearfix"></div>
    </div>
    
</form>
    <?php } ?>
<script type="text/javascript">
    
    $(document).ready(function(){
        $("#selCargo").val("<?php echo $GLOBALS['oOperador']->cargo_ID;?>");
    });
    
    var validar=function(){
        var persona_ID=$.trim($("#txtPersona_ID").val());
        var fecha_contrato = $.trim($("#txtFecha_Contrato").val());
        if(validarFecha(fecha_contrato)==false){
            mensaje.error("Mensaje de error","Debe ingresar una fecha válida","txtFecha_Contrato");
            mover_scroll_inicio();
            return false;
            } 
        
//        if(fecha_contrato==null || fecha_contrato=="____/__/__"){
//            mensaje.error("Mensaje de error","Debe ingresar una fecha válida","txtFecha_Contrato");
//            mover_scroll_inicio();
//            return false;
//        }
        
        if(persona_ID=="" || persona_ID == '0'){
            toastem.error("Debe seleccionar una persona.");
            return false;
        }
    }
    var fncAgregar_Persona=function(){
//        window_float_deslizar('form','/Mantenimiento/Persona_Mantenimiento_Nuevo','','');
          parent.window_float_open_modal_hijo('REGISTRAR NUEVO PERSONA','/Mantenimiento/Persona_Mantenimiento_Nuevo','','',fncCargarPersona,800,500);
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
            $('#txtTelefono').val(resultado.oPersona.telefono);
            $('#txtCelular').val(resultado.oPersona.celular);
            $('#txtMail').val(resultado.oPersona.correo);
            
        });
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
                toastem.error(" <?php echo $GLOBALS['mensaje']; ?>");
            });
            
        </script>
    <?php } ?>
    <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 0) { ?>
        <script>
        $(document).ready(function(){
            toastem.info(" <?php echo $GLOBALS['mensaje']; ?>");
        });
        </script>
        
        <div class="group-btn">
            <input type="button" onclick ="redireccionar_parent('/');" value ="Iniciar Sesión"/>
        </div>
    <?php } ?>
<?php } ?>
