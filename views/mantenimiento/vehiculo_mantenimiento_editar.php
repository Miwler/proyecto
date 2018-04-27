<?php
require ROOT_PATH . "views/shared/content-float.php";
?>	
<?php

function fncTitle() { ?>Editar Vehículo<?php } ?>

<?php

function fncHead() { ?>

    
<?php } ?>

<?php

function fncTitleHead() { ?><i class="fa fa-taxi" aria-hidden="true"></i> Editar Vehículo<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>
<?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1) { ?>

<form id="form" method="POST"  action="/Mantenimiento/Vehiculo_Mantenimiento_Editar/<?php echo $GLOBALS['oVehiculo']->ID; ?>" onsubmit="return validar();" >
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
            <label>Placa: </label>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
            <input type="text" id="txtPlaca" name="txtPlaca"  autocomplete="off"  value="<?php echo $GLOBALS['oVehiculo']->placa; ?>" class="form-control form-requerido text-uppercase"/>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
            <label>Marca: </label>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
            <input type="text" id="txtMarca"  name="txtMarca"  autocomplete="off"  value="<?php echo $GLOBALS['oVehiculo']->marca; ?>" class="form-control form-requerido text-uppercase"/>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
            <label>Descripción: </label>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
            <input type="text" id="txtDescripcion" name="txtDescripcion"  autocomplete="off"  value="<?php echo $GLOBALS['oVehiculo']->descripcion; ?>" class="form-control text-uppercase"/>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
            <label>Certificado de inscripción: </label>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
            <input type="text" id="txtCerti_Incripcion" name="txtCerti_Incripcion"  autocomplete="off"  value="<?php echo $GLOBALS['oVehiculo']->certificado_inscripcion; ?>" class="form-control text-uppercase"/>
        </div>
    </div>
   <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <button  id="btnEnviar" name="btnEnviar" class="btn btn-success" >
                <img title="Guardar" alt="" src="/include/img/boton/save_14x14.png">
                Guardar
            </button>
            <button  id="btnCancelar" name="btnCancelar"  class="btn btn-danger" type="button" title="Cancelar" onclick="window_float_close();" >
                <img  alt="" src="/include/img/boton/cancel_14x14.png">
                Cancelar
            </button> 
        </div>
        
    </div>
</form>
    <?php } ?>
<script>
    var validar=function(){
        var placa=$.trim($('#txtPlaca').val());
        var marca=$.trim($('#txtMarca').val());
        if(placa==""){
            mensaje.error("Mensaje de error", "Debe registrar la placa del vehículo.","txtPlaca");
            return false;
        }
        if(marca==""){
            mensaje.error("Mensaje de error", "Debe registrar una marca del vehículo.","txtMarca");
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
            mensaje.error("Mensaje de error","<?php echo $GLOBALS['mensaje']; ?>");
           
        });
        
    </script>
    <?php } ?>
    
    <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == -2) { ?>
    <script type="text/javascript">
        $(document).ready(function () {
            toastem.error('<?php  echo $GLOBALS['mensaje'];?>');
            setTimeout('window_float_save();', 1000);

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
