<?php
require ROOT_PATH . "views/shared/content-float.php";

?>	
<?php

function fncTitle() { ?>Ubicación de Banner<?php } ?>

<?php

function fncHead() { ?>
    
   <!--<script src="../../fileinput/js/fileinput.js" type="text/javascript"></script>
    <link href="../../fileinput/css/fileinput.css" rel="stylesheet" type="text/css"/>-->
    <script src="../../include/js/jForm.js" type="text/javascript"></script>
    <script src="../../include/jquery.tablesorter.pager.js" type="text/javascript"></script>
    
<?php } ?>
    
<?php

function fncTitleHead() { ?><span class="glyphicon glyphicon-align-left"></span> Ubicación del Banner<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>

<?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1) { ?>
    
    <form id="form"  method="POST" style="width:600px;padding:10px; overflow:auto;"   >    
        <div class="panel panel-default" style="margin:0 auto;">
            <div class="panel-heading" id="divForm">
                <div class="row">
                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                        <input id="txtWeb_Banner_ID" name="txtWeb_Banner_ID" value="<?php echo $GLOBALS['oWeb_Banner']->ID;?>" style="display:none;" >
                        <input type="text" id="txtRuta" name="txtRuta" autocomplete="off" class="form-control" style="width:200px;"placeholder="Ruta" > 
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                        <select id="selTipo" name="selTipo" class="form-control" class="form-control" style="width:80px;">
                            <option value="-1">-Seleccionar-</option>
                            <option value="header">Header</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                        <input type="number" id="txtOrden" name="txtOrden" placeholder="Orden" autocomplete="off" class="form-control" value="0" style="width:50px;">
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                        <button  type="button" id="btnEnviar" name="btnEnviar" class="btn btn-success" title="Agregar" onclick="fncAgregar();" >
                            <span class="glyphicon glyphicon-plus"></span> Agregar                
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div id="divContenedor" style="height: 300px;overflow: auto;"> </div>
            </div>
        </div>
        
    </form>
    
<?php } ?>
<script type="text/javascript">
    
    
    var limpiar=function(){
        $('#txtRuta').val('');
        $('#selTipo').val('-1');
        $('#txtOrden').val('0');
    }
    var cargarUbicacion=function(){
        var web_banner_ID=$.trim($('#txtWeb_Banner_ID').val());
        if(web_banner_ID!=""){
            cargarValores('pagina_web/ajaxWeb_Banner_Ubicacion',web_banner_ID,function(resultado){
                $('#divContenedor').html(resultado.resultado);
            });
        }
        
    }
    var fncEliminar=function(id){
        cargarValores('pagina_web/ajaxDeleteWeb_Banner_Ubicacion',id,function(resultado){
            if(resultado.resultado==1){
                cargarUbicacion();
                toastem.info(resultado.mensaje);
            }else{
                toastem.error(resultado.mensaje);
            }
        });
    }
    var fncAgregar=function(){
        if($.trim($('#txtRuta').val())==""){
            toastem.error("Tiene que registrar una ruta.");
            $('#txtRuta').focus();
            return false;
        }
        if($('#selTipo').val()=="-1"){
            toastem.error("Tiene que seleccionar un tipo.");
            $('#selTipo').focus();
            return false;
        }
        var web_banner_ID=$.trim($('#txtWeb_Banner_ID').val());
        if(web_banner_ID!=""){
            cargarFormularios('pagina_web/ajaxInsertWeb_Banner_Ubicacion','divForm',null,function(resultado){
                if(resultado.resultado==1){
                    limpiar();
                    cargarUbicacion();
                    toastem.success(resultado.mensaje);
                }else{
                    toastem.error(resultado.mensaje);
                }
            });
        }else{toastem.error("No existe el código del banner");}
       
    }
    $(document).on('ready',function(){
        cargarUbicacion();
    });
</script>
    <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 1) { ?>
       
        <script type="text/javascript">
            $(document).on('ready',function(){
                toastem.success('<?php echo $GLOBALS['mensaje'];?>');
            });
            setTimeout('window_float_save();', 1000);
        </script>
    <?php } ?>
 <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == -1) { ?>
        <div class="float-mensaje">
            <?php echo $GLOBALS['mensaje']; ?>
        </div>
        <script type="text/javascript">

            $(document).on('ready',function(){
                toastem.error('<?php echo $GLOBALS['mensaje'];?>');
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
