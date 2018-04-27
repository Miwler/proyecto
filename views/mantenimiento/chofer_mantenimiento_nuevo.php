<?php
require ROOT_PATH . "views/shared/content-float.php";
?>	
<?php

function fncTitle() { ?>Nuevo Chofer<?php } ?>

<?php

function fncHead() { ?>

    
<?php } ?>

<?php

function fncTitleHead() { ?><i class="fa fa-address-card-o" aria-hidden="true"></i> Nuevo Chofer<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>
<?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1) { ?>
<form id="form"  method="POST" action="/Mantenimiento/Chofer_Mantenimiento_Nuevo" style="width:600px; padding-top:15px;" onsubmit="return validar();" >
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <label>Persona: </label>&nbsp;&nbsp;&nbsp;<a class="btn btn-success" title="Agregar persona nueva" onclick="fncAgregar_Persona();"><img src="/include/img/boton/add_user-20.png"></a>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <input type="text" id="txtPersona_ID" class="form-control form-requerido">
            <script type="text/javascript">
                var cboPersona = newCbo('divPersona', 'txtPersona_ID', '/funcion/ajaxCbo_Persona', true);
            </script>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <label>Licencia conducir: </label>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <input type="text" id="txtLicencia_Conducir" name="txtLicencia_Conducir" value="<?php echo $GLOBALS['oChofer']->licencia_conducir;?>" autocomplete="off" class="form-control form-requerido text-uppercase">
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <label>Celular: </label>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <input type="text" id="txtCelular" name="txtCelular" value="<?php echo $GLOBALS['oChofer']->celular;?>" autocomplete="off" class="form-control bfh-number int">
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <label>Estado: </label>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <select id="selEstado_ID" name="selEstado_ID" class="form-control form-requerido text-uppercase">
                <?php foreach($GLOBALS['oChofer']->dtEstado as $item){ ?>
                <option value="<?php echo $item['ID']?>"><?php echo FormatTextView(strtoupper($item['nombre']));?></option>
                <?php } ?>
            </select>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <button  id="btnEnviar" name="btnEnviar" class="btn btn-success" >
                <img title="Guardar" alt="" src="/include/img/boton/save_14x14.png">
                Guardar
            </button>
            <button  id="btnCancelar" name="btnCancelar" class="btn btn-danger" type="button" onclick="window_float_close();" >
                <img title="Guardar" alt="" src="/include/img/boton/cancel_14x14.png">
                Cancelar
            </button>   
        </div>
    </div>
</form>
<?php } ?>
<script type="text/javascript">
    var validar=function(){
        var licencia_conducir=$.trim($('#txtLicencia_Conducir').val());
       
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
        window_float_deslizar('form','/Mantenimiento/Persona_Mantenimiento_Nuevo','','');
    } 
    var fncCargarPersona=function(id,nombres){
        cboPersona.seleccionar(id, nombres);
    }
    
</script>
<?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 1) { ?>
    
    <script type="text/javascript">
        $(document).ready(function(){
            toastem.success("<?php echo $GLOBALS['mensaje']; ?>");
            setTimeout('window_float_save();', 1000);
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
