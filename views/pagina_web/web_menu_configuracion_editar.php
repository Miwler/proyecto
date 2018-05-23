<?php
require ROOT_PATH . "views/shared/content-float-modal.php";

?>	
<?php

function fncTitle() { ?>Editar Menú<?php } ?>

<?php

function fncHead() { ?>
    
   <!--<script src="../../fileinput/js/fileinput.js" type="text/javascript"></script>
    <link href="../../fileinput/css/fileinput.css" rel="stylesheet" type="text/css"/>-->
    <script src="../../include/js/jForm.js" type="text/javascript"></script>

    
<?php } ?>

<?php

function fncTitleHead() { ?>Editar menú<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>

<?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1|| $GLOBALS['resultado'] == 1) { ?>
    <form id="form"  method="POST" style="overflow:auto;"  action="/Pagina_Web/Web_Menu_Configuracion_Editar/<?php echo $GLOBALS['oWeb_Menu']->ID;?>" class="form-horizontal" onsubmit="return validar();">
        <div class="panel panel-info">
            <div class="panel-body">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#datos_generales">Datos generales</a></li>
                    <li><a data-toggle="tab" href="#lista">Lista menú</a></li>
                    <li class="text-right">
                        <button type="button" class="btn btn-success" title="Agregar Menús" onclick="fncAgregarLista();"><span class="glyphicon glyphicon-plus"></span>Agregar menú</button>
                    </li>
                </ul>
                <div class="tab-content" style="padding-top:10px;">
                    <div id="datos_generales" class="tab-pane fade in active">
                        <div class="form-group">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <label>Nombre</label>
                                <input type="hidden" id="txtID" name="txtID" value="<?php echo $GLOBALS['oWeb_Menu']->ID;?>">
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <input type="text" id="txtNombre" name="txtNombre" autocomplete="off" class="form-control form-requerido" value="<?php echo FormatTextView($GLOBALS['oWeb_Menu']->nombre);?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <label>Tipo</label>

                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <select id="selTipo" name="selTipo" class="form-control form-requerido">
                                    <option value="0">-Seleccionar-</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                </select>
                                <script type="text/javascript">
                                    $("#selTipo").val(<?php echo $GLOBALS['oWeb_Menu']->tipo;?>);
                                </script>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <label>Descripción</label>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <textarea id="txtDescripcion" name="txtDescripcion" class="form-control" style="height: 50px;"><?php echo FormatTextViewHtml($GLOBALS['oWeb_Menu']->descripcion);?></textarea>

                            </div>
                        </div>
                    </div>
                    <div id="lista" class="tab-pane fade">
                        <div class="row">
                            <div id="divLista" class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="height: 170px;overflow:auto;">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <button  id="btnEnviar" name="btnEnviar" class="btn btn-success" title="Guardar" >
                            <img  alt="" src="/include/img/boton/save_14x14.png">
                        Guardar
                        </button>
                        &nbsp;
                         <button  id="btnCancelar" name="btnCancelar" class="btn btn-danger" title="Guardar" type="button" onclick="window_float_close();" >
                            <img  alt="" src="/include/img/boton/cancel_14x14.png">
                        Cerrar
                        </button>
                    </div> 
                </div>
                 
            </div>
        </div>
        
        
  
    </form>
<script type="text/javascript">
    $(document).ready(function(){
        fncCargarLista();
    });
    var validar=function(){
        var nombre=$.trim($('#txtNombre').val());
        var tipo=$('#selTipo').val();
        
        if(nombre==""){
            toastem.error("Tiene que registrar un nombre.");
            $('#txtNombre').focus();
            return false;
        }
        if(tipo==0){
            toastem.error("Tiene que seleccionar un tipo.");
            $('#selTipo').focus();
            return false;
        }
    }
    var fncCargarLista=function(){
        var web_menu_ID=$("#txtID").val();
        cargarValores("/pagina_web/ajaxWeb_Menu_Lista",web_menu_ID,function(resultado){
            
            $("#divLista").html(resultado.resultado);
        });
    }
    var fncAgregarLista=function(){
        var web_menu_ID=$("#txtID").val();
        window_float_deslizar('form','pagina_web/web_menu_lista_configuracion_nuevo',web_menu_ID,'',fncCargarLista);
    }
    var fncEditar=function(id){
        
        window_float_deslizar('form','pagina_web/web_menu_lista_configuracion_editar',id,'',fncCargarLista);
    }
</script>
<?php } ?>

    <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 1) { ?>
       
        <script type="text/javascript">
            $(document).on('ready',function(){
                toastem.success('<?php echo $GLOBALS['mensaje'];?>');
                $('.nav-tabs a[href="#lista"]').tab('show');
            });
            //setTimeout('window_float_save();', 1000);
        </script>
    <?php } ?>
 <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == -1) { ?>
       
        <script type="text/javascript">

            $(document).on('ready',function(){
                toastem.error('<?php echo $GLOBALS['mensaje'];?>');
            });
        </script>
    <?php } ?>
    <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == -2) { ?>
       
        <script type="text/javascript">
            $(document).on('ready',function(){
                toastem.error('<?php echo $GLOBALS['mensaje'];?>');
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
