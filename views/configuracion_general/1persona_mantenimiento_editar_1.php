<?php
require ROOT_PATH . "views/shared/content-float.php";
?>	
<?php
function fncTitle() { ?>Editar persona<?php } ?>
<?php
function fncHead() { ?>
<script src="../../include/js/jLista.js" type="text/javascript"></script>



<?php } ?>
<?php
function fncTitleHead() { ?><i class="fa fa-address-book-o" aria-hidden="true"></i> Editar Persona<?php } ?>
<?php
function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>
<?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1) { ?>
<form id="form"  method="POST" action="/Configuracion_General/Persona_Mantenimiento_Editar/<?php echo $GLOBALS['oPersona']->ID?>" style="width:700px;padding-top:15px;margin:0 auto;" onsubmit="return validar();" >
    <div class="panel panel-success">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <div class="panel panel-<?php echo $_SESSION['cabecera'];?>">
                        <div class="panel-heading">Datos personales</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label>Documento: </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <select id="selTipo_Documento" name="selTipo_Documento" class="form-control form-requerido">
                                        <?php foreach($GLOBALS['oPersona']->dtTipo_Documento as $item){ ?>
                                        <option value="<?php echo $item['ID']?>"><?php echo FormatTextView($item['nombre'])?></option>
                                        <?php } ?>
                                    </select>
                                    <script type="text/javascript">
                                        $("#selTipo_Documento").val(<?php echo $GLOBALS['oPersona']->tipo_documento_ID;?>);
                                    </script>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label>Número: </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <input type="text" id="txtNumero" name="txtNumero" maxlength="8"  value="<?php echo $GLOBALS['oPersona']->numero;?>" autocomplete="off" class="form-control form-requerido text-int" > 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label>Apellido Paterno: </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <input type="text" id="txtApellido_Paterno" name="txtApellido_Paterno"  value="<?php echo FormatTextView($GLOBALS['oPersona']->apellido_paterno);?>" autocomplete="off" class="form-control form-requerido text-uppercase" > 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label>Apellido Materno: </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <input type="text" id="txtApellido_Materno" name="txtApellido_Materno" value="<?php echo FormatTextView($GLOBALS['oPersona']->apellido_materno);?>" autocomplete="off" class="form-control form-requerido text-uppercase">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label>Nombres: </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <input type="text" id="txtNombres" name="txtNombres" value="<?php echo FormatTextView($GLOBALS['oPersona']->nombres);?>" autocomplete="off" class="form-control form-requerido text-uppercase">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label>Fecha nacimiento: </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                  <input type='date' id='txtFecha_Nacimiento' name="txtFecha_Nacimiento" class="form-control"  />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label>Sexo: </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <select id="selSexo_ID" name="selSexo_ID" class="form-control form-requerido">
                                        <?php foreach($GLOBALS['oPersona']->dtSexo as $sexo){?>
                                        <option value="<?php echo $sexo['ID']?>"><?php echo FormatTextViewHtml($sexo['nombre']);?></option>
                                        <?php } ?>
                                    </select>
                                    <script type="text/javascript">
                                        $('#selSexo_ID').val(<?php echo $GLOBALS['oPersona']->sexo_ID;?>);
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <div class="panel panel-<?php echo $_SESSION['cabecera'];?>">
                        <div class="panel-heading">
                            Información de contacto
                        </div>
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
                                    <input type="text" id="txtDireccion" name="txtDireccion" value="<?php echo FormatTextView($GLOBALS['oPersona']->direccion);?>" autocomplete="off" class="form-control text-uppercase">
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label>Correo: </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <input type="text" id="txtCorreo" name="txtCorreo" value="<?php echo FormatTextView($GLOBALS['oPersona']->correo);?>" autocomplete="off" class="form-control">
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label>Teléfono: </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <input type="text" id="txtTelefono" name="txtTelefono" value="<?php echo FormatTextView($GLOBALS['oPersona']->telefono);?>" autocomplete="off" class="form-control text-uppercase">
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label>Celular: </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <input type="text" id="txtCelular" name="txtCelular" value="<?php echo FormatTextView($GLOBALS['oPersona']->celular);?>" autocomplete="off" class="form-control int">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
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
        </div>
    </div>
</form>
<?php } ?>
<script type="text/javascript">
   
    var validar=function(){
        var numero=$.trim($('#txtNumero').val());
        var apellido_paterno=$.trim($('#txtApellido_Paterno').val());
        var apellido_materno=$.trim($('#txtApellido_Materno').val());
        var nombres=$.trim($('#txtNombres').val());
        var sexo_ID=$('#selSexo_ID').val();
        if(numero==""){
            mensaje.error("Mensaje de error","Debe registrar un número de documento.",'txtNumero');
            return false;
        }
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
        if(nombres==0){
            mensaje.error("Mensaje de error","Seleccione el sexo.",'selSexo_ID');
            return false;
        }
        
    }
    var fncDepartamento=function(){
        var obj = $('#selDepartamento');
        ajaxSelect('selProvincia', '/Mantenimiento/ajaxSelect_Provincia/' + obj.val(), '',fncProvincia);
    }

    var fncProvincia=function(){
        var obj = $('#selProvincia');
        ajaxSelect('selDistrito', '/Mantenimiento/ajaxSelect_Distrito/' + obj.val(), '',null);
    } 
    $('#selTipo_Documento').change(function(){
        
        var valor=this.value;
        if(valor==1){
            $('#txtNumero').attr('maxlength','8');
           
        }else{
            $('#txtNumero').attr('maxlength','20');
            
        }
    });
</script>
<?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 1) { ?>
    
<script type="text/javascript">
    $(document).ready(function(){
        toastem.success("<?php echo $GLOBALS['mensaje']; ?>");
        setTimeout('window_float_close();', 1000);
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
