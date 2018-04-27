<?php
require ROOT_PATH . "views/shared/content-float.php";
?>	
<?php

function fncTitle() { ?>Nuevo Operador<?php } ?>

<?php

function fncHead() { ?>
    <script type="text/javascript" src="include/js/jGrid.js"></script>
    <link rel="stylesheet" type="text/css" href="include/css/grid.css" />
    <script type="text/javascript" src="include/js/jForm.js"></script>
    <script src="../../include/js/jDate.js" type="text/javascript"></script>
    <link href="../../include/css/date.css" rel="stylesheet" type="text/css"/>
<?php } ?>

<?php

function fncTitleHead() { ?>Nuevo Operador<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>
    <?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1) { ?>
<form id="form" method="POST" style="width:800px;"  action="/Mantenimiento/Operador_Mantenimiento_Nuevo" onsubmit="return validar();">
        <div class="panel panel-info">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <label>Persona:</label>&nbsp;&nbsp;&nbsp;<a class="btn btn-success" title="Agregar persona nueva" onclick="fncAgregar_Persona();"><img src="/include/img/boton/add_user-20.png"></a>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                        <input type="text" id="txtPersona_ID" class="form-control form-requerido" >
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <label>Teléfono:</label>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                        <input id="txtTelefono" name="txtTelefono" type="text" autocomplete="off" value="<?php echo $GLOBALS['oOperador']->telefono; ?>" class="form-control"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <label>Celular:</label>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                        <input id="txtCelular" name="txtCelular" type="text" autocomplete="off" value="<?php echo $GLOBALS['oOperador']->celular; ?>" class="form-control"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <label>Correo:</label>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                        <input id="txtMail"  name="txtMail" type="email" autocomplete="off" value="<?php echo $GLOBALS['oOperador']->mail; ?>" class="form-control"/>
                    </div>
                </div>
                
                <div class="row">
                   
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <label>Fecha Contrato:</label>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                        <input id="txtFecha_Contrato" name="txtFecha_Contrato" type="text" class="date form-control" autocomplete="off" value="<?php echo $GLOBALS['oOperador']->fecha_contrato; ?>"/>
                    </div>
                </div>
                <div class="row">
                    
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <label>Comision:</label>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                        <input id="txtComision" name="txtComision" type="text" autocomplete="off" value="<?php echo $GLOBALS['oOperador']->comision; ?>" placeholder="%" class="decimal form-control"/>
                    </div>
                </div>
                <div class="row">
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
            <div class="panel-footer">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <button  id="btnEnviar" name="btnEnviar" class="btn btn-success">
                            <img title="Guardar" alt="" src="/include/img/boton/save_14x14.png">
                            Guardar
                        </button>
                        <button  id="btnCancelar" name="btnCancelar" type="button" title="Salir" onclick="window_float_close();" class="btn btn-danger">
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
    var cboPersona = newCbo('divPersona', 'txtPersona_ID', '/funcion/ajaxCbo_Persona', true);
    cboPersona.seleccionado=function(){
            var id=$('#sendtxtPersona_ID').val();
            mostrar_informacion_persona(id);
        }
    
    var validar=function(){
        var persona_ID=$.trim($("#sendtxtPersona_ID").val());
        
        if(persona_ID==""){
            toastem.error("Debe seleccionar una persona.");
            return false;
        }
    }
    var fncAgregar_Persona=function(){
        window_float_deslizar('form','/Mantenimiento/Persona_Mantenimiento_Nuevo','','');
    } 
    var mostrar_informacion_persona=function(id){
        cargarValores('/Funcion/ajaxExtraerInformacionPersona',id,function(resultado){
            $('#txtTelefono').val(resultado.oPersona.telefono);
            $('#txtCelular').val(resultado.oPersona.celular);
            $('#txtMail').val(resultado.oPersona.correo);
            
        });
    }
    var fncCargarPersona=function(id,nombres){
        cboPersona.seleccionar(id, nombres);
        mostrar_informacion_persona(id);
    }
</script>
    <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 1) { ?>
       
        <script type="text/javascript">
            $(document).ready(function(){
                toastem.success(" <?php echo $GLOBALS['mensaje']; ?>");
                
                setTimeout('window_float_save();', 1000);
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
