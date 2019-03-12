<?php
require ROOT_PATH . "views/shared/content-float.php";
?>	
<?php

function fncTitle() { ?>Editar Persona<?php } ?>

<?php

function fncHead() { ?>
    <script type="text/javascript" src="include/js/jGrid.js"></script>
    <link rel="stylesheet" type="text/css" href="include/css/grid.css" />
    <script type="text/javascript" src="include/js/jForm.js"></script>
  
<?php } ?>

<?php

function fncTitleHead() { ?>Editar Persona<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>
<?php if (!isset($GLOBALS['resultado'])|| $GLOBALS['resultado'] == -1) { ?>
<form id="form1" method="POST" action="/Configuracion_General/Persona_Mantenimiento_Editar/<?php echo $GLOBALS['oPersona']->ID?>" style="width:920px; height: 550px;" onsubmit="return validar();">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#datos" data-toggle="tab"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Datos</a></li>
        
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade in active" id="datos">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">

                    <div class="panel panel-default">
                        <div class="panel-heading">Datos de contacto</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label>Apellido Paterno: </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <input type="text"  id="txtApellido_Paterno" name="txtApellido_Paterno" autocomplete="off" value="<?php echo FormatTextView($GLOBALS['oPersona']->apellido_paterno); ?>"  class="form-control form-requerido text-uppercase"/>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label>Apellido Materno: </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <input type="text"  id="txtApellido_Materno" name="txtApellido_Materno" autocomplete="off" value="<?php echo FormatTextView($GLOBALS['oPersona']->apellido_materno); ?>"  class="form-control form-requerido text-uppercase"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label>Nombres: </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <input type="text"  id="txtNombres" name="txtNombres" autocomplete="off" value="<?php echo FormatTextView($GLOBALS['oPersona']->nombres); ?>"  class="form-control form-requerido text-uppercase"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label>Fecha Nacimiento: </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <input type="date"  id="txtFecha_Nacimiento" name="txtFecha_Nacimiento" value="<?php echo $GLOBALS['oPersona']->fecha_nacimiento; ?>" class="form-control"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label>Sexo: </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <select id="selSexo_ID" name="selSexo_ID" class="form-control form-requerido">
                                        <option value="0">SELECCIONAR</option>
                                        <?php foreach($GLOBALS['oPersona']->dtSexo as $sexo){?>
                                        <option value="<?php echo $sexo['ID']?>"><?php echo $sexo['nombre'];?></option>
                                        <?php } ?>
                                    </select>
                                    <script type="text/javascript">
                                        $('#selSexo_ID').val(<?php echo $GLOBALS['oPersona']->sexo_ID;?>);
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    
                    <div class="panel panel-default">
                        <div class="panel-heading">Informacion Personal</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label>Correo: </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <input type="text"  id="txtCorreo" name="txtCorreo" autocomplete="off" value="<?php echo FormatTextView($GLOBALS['oPersona']->correo); ?>"  class="form-control"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label>Telefono: </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <input type="text"  id="txtTelefono" name="txtTelefono" autocomplete="off" value="<?php echo FormatTextView($GLOBALS['oPersona']->telefono); ?>"  class="form-control int-text"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label>Celular: </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <input type="text"  id="txtCelular" name="txtCelular" autocomplete="off" value="<?php echo FormatTextView($GLOBALS['oPersona']->celular); ?>"  class="form-control int"/>
                                </div>
                            </div>
                        </div>
                    </div>
                                                         
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">                   
                    <div class="panel panel-default">
                        <div class="panel-heading">Documentos</div>
                        <div class="panel-body">
                    <?php foreach($GLOBALS['dtTipo_Documento'] as $tipo_documento){?>
						<div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label><?php echo $tipo_documento['nombre']?>: </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                     <input type="text"  id="txt<?php $tipo_documento['ID']?>" name="txt<?php $tipo_documento['ID']?>"  autocomplete="off"  class="form-control text-uppercase"/>
                                </div>
                            </div>
					<?php }?>
                            
                        </div>
                    </div>                   
                    
                    <div class="panel panel-default">
                        <div class="panel-heading">Ubicación</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label>Departamento: </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <select id="selDepartamento" name="selDepartamento" class="form-control" onchange="fncDepartamento();">
                                    <?php foreach($GLOBALS['oPersona']->dtDepartamento as $iDepartamento){
                                        echo '<option value="'.$iDepartamento['ID'].'">'.$iDepartamento['nombre'].'</option>';
                                    } ?>
                                    </select>
                                    <script type="text/javascript">
                                        $('#selDepartamento').val(<?php echo $GLOBALS['oPersona']->departamento_ID; ?>);
                                    </script>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label>Provincia: </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <select id="selProvincia" name="selProvincia" class="form-control" onchange="fncProvincia();">
                                        <?php foreach($GLOBALS['oPersona']->dtProvincia as $provincia){?>
                                        <option value="<?php echo $provincia['ID']; ?>"><?php echo FormatTextView(strtoupper($provincia['nombre']))?></option>
                                        <?php } ?>
                                    </select>
                                    <script type="text/javascript">
                                        $('#selProvincia').val(<?php echo $GLOBALS['oPersona']->provincia_ID; ?>);
                                    </script>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label>Distrito: </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <select id="selDistrito" name="selDistrito" class="form-control">
                                        <?php foreach($GLOBALS['oPersona']->dtDistrito as $distrito){?>
                                        <option value="<?php echo $distrito['ID']; ?>"><?php echo FormatTextView(strtoupper($distrito['nombre']))?></option>
                                        <?php } ?>
                                    </select>
                                    <script type="text/javascript">
                                        $('#selDistrito').val(<?php echo $GLOBALS['oPersona']->distrito_ID; ?>);
                                    </script>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label>Dirección: </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                     <input type="text"  id="txtDireccion" name="txtDireccion" autocomplete="off" value="<?php echo FormatTextView($GLOBALS['oPersona']->direccion); ?>" class="form-control text-uppercase"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <button  id="btnEnviar" name="btnEnviar" class="btn btn-success" >
                <span class="glyphicon glyphicon-floppy-disk"></span>
                Guardar
            </button>
            <button  id="btnCancelar" name="btnCancelar" class="btn btn-warning" type="button" onclick="window_float_close();" >
                <span class="glyphicon glyphicon-arrow-left"></span>
                Salir
            </button>   
        </div>
    </div>

</form>
<script type="text/javascript">
    var fncDepartamento=function(){
        var obj = $('#selDepartamento');
        ajaxSelect('selProvincia', '/Mantenimiento/ajaxSelect_Provincia/' + obj.val(), '',fncProvincia);
    }

    var fncProvincia=function(){
        var obj = $('#selProvincia');
        ajaxSelect('selDistrito', '/Mantenimiento/ajaxSelect_Distrito/' + obj.val(), '',null);
    }


    var validar=function(){
//        var numero=$.trim($('#txtNumero').val());
        var apellido_paterno=$.trim($('#txtApellido_Paterno').val());
        var apellido_materno=$.trim($('#txtApellido_Materno').val());
        var nombres=$.trim($('#txtNombres').val());
        var sexo_ID=$('#selSexo_ID').val();
//        if(numero==""){
//            mensaje.error("Mensaje de error","Debe registrar un número de documento.",'txtNumero');
//            return false;
//        }
        if(apellido_paterno==""){
            mensaje.error("Mensaje de error","Debe registrar el apellido paterno.",'txtApellido_Paterno');
            return false;
        }
        if(apellido_materno==""){
            mensaje.error("Mensaje de error","Debe registrar el apellido materno.",'txtApellido_Materno');
            return false;
        }
        if(nombres==""){
            mensaje.error("Mensaje de error","Debe registrar los nombres.",'txtNombres');
            return false;
        }
        if(sexo_ID==0){
            mensaje.error("Mensaje de error","Seleccione el sexo.",'selSexo_ID');
            return false;
        }
        
    }

    </script>   


    <?php } ?>


    
    <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 1) { ?>
        
        <script type="text/javascript">
            $(document).ready(function(){
                toastem.success("<?php echo $GLOBALS['mensaje'];?>");
                setTimeout('window_float_save();', 1000);
            });
           
        </script>
    <?php } ?>
    <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == -1) { ?>
        
        <script type="text/javascript">
            $(document).ready(function(){
                mensaje.error('Mensaje de error',"<?php echo $GLOBALS['mensaje'];?>");
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
