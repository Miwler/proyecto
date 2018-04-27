<?php
require ROOT_PATH . "views/shared/content-float.php";
?>	
<?php

function fncTitle() { ?>Nuevo Numero de Cuenta<?php } ?>

<?php

function fncHead() { ?>

    
<?php } ?>

<?php

function fncTitleHead() { ?><i class="fa fa-address-card-o" aria-hidden="true"></i> Nuevo Numero de Cuenta<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>
<?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1) { ?>
<form id="form"  method="POST" action="/Mantenimiento/Numero_Cuenta_Mantenimiento_Nuevo" style="width:600px; padding-top:15px;" onsubmit="return validar();" >
    <div class="row">

    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <label>Banco: </label>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <input type="text" id="txtNombre_Banco" name="txtNombre_Banco" value="<?php echo $GLOBALS['oNumero_Cuenta']->nombre_banco;?>" autocomplete="off" class="form-control form-requerido text-uppercase">
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <label>Numero Cuenta: </label>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <input type="text" id="txtNumero" name="txtNumero" value="<?php echo $GLOBALS['oNumero_Cuenta']->numero;?>" autocomplete="off" class="form-control form-requerido bfh-number int">
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <label>N&uacute;mero Cuenta Interbancaria: </label>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <input type="text" id="txtCci" name="txtCci" value="<?php echo $GLOBALS['oNumero_Cuenta']->cci;?>" autocomplete="off" class="form-control bfh-number int">
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <label>Moneda: </label>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <select id="selMoneda_ID" name="selMoneda_ID" class="form-control form-requerido text-uppercase">
                <?php foreach($GLOBALS['oNumero_Cuenta']->dtMoneda as $item){ ?>
                <option value="<?php echo $item['ID']?>"><?php echo FormatTextView(strtoupper($item['descripcion']));?></option>
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
        var nombre_banco = $.trim($('#txtNombre_Banco').val());
        var numero = $.trim($('#txtNumero').val());
       
        if(nombre_banco==""){
            mensaje.error("Mensaje de error","Debe registrar el nombre del banco",'txtNombre_Banco');
            return false;
        }
        if(numero==""){
            mensaje.error("Mensaje de error","Debe registrar el numero de cuenta",'txtNumero');
            return false;
        }
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
