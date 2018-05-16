<?php
require ROOT_PATH . "views/shared/content-float-modal.php";
?>	
<?php

function fncTitle() { ?>Nuevo Proveedor<?php } ?>

<?php

function fncHead() { ?>
   

    <script type="text/javascript" src="include/js/jForm.js"></script>
  
<?php } ?>

<?php

function fncTitleHead() { ?>Nuevo Proveedor<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>
<?php if (!isset($GLOBALS['resultado'])|| $GLOBALS['resultado'] == -1) { ?>
<form id="form1" method="POST" action="/Mantenimiento/Proveedor_Mantenimiento_Nuevo"  onsubmit="return validar();" class="form-horizontal">
    <div class="form-body" style="height: 450px;overflow: auto;">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#proveedor" data-toggle="tab"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Empresa</a></li>
            <li><a href="#proveedor_contacto" data-toggle="tab"><i class="fa fa-users" aria-hidden="true"></i> Persona contacto</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade in active" id="proveedor">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                          <div class="panel panel-default">
                            <div class="panel-heading">Información SUNAT</div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label>RUC: </label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <input  type="text"  id="txtRuc" name="txtRuc" autocomplete="off" maxlength="11" minlength="11"   onkeyup="MostrarLista(this.id,'divRuc');" value="<?php echo $GLOBALS['oProveedor']->ruc; ?>" class="form-control form-requerido int"/>
                                        <div id="divRuc" class="divBuscador"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label>Razon Social: </label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <input type="text"  id="txtRazon_Social" name="txtRazon_Social" autocomplete="off" value="<?php echo FormatTextView($GLOBALS['oProveedor']->razon_social); ?>" onkeyup="MostrarLista(this.id,'divRazonSocial');" class="form-control form-requerido text-uppercase"/>
                                        <div id="divRazonSocial" class="divBuscador"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label>Dirección fiscal: </label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <input type="text"  id="txtDireccion_Fiscal" name="txtDireccion_Fiscal" autocomplete="off" value="<?php echo FormatTextView($GLOBALS['oProveedor']->direccion_fiscal); ?>"  class="form-control text-uppercase"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">Datos de contacto</div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label>Nombre comercial: </label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <input type="text"  id="txtNombre_Comercial" name="txtNombre_Comercial" autocomplete="off" value="<?php echo FormatTextView($GLOBALS['oProveedor']->nombre_comercial); ?>"  class="form-control text-uppercase"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label>Teléfono: </label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <input type="text"  id="txtTelefono" name="txtTelefono" autocomplete="off" value="<?php echo FormatTextView($GLOBALS['oProveedor']->telefono); ?>"  class="form-control int-text"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label>Celular: </label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <input type="text"  id="txtCelular" name="txtCelular" autocomplete="off" value="<?php echo FormatTextView($GLOBALS['oProveedor']->celular); ?>"  class="form-control int"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label>Fax: </label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <input type="text"  id="txtFax" name="txtFax" autocomplete="off" value="<?php echo FormatTextView($GLOBALS['oProveedor']->fax); ?>"  class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label>Correo: </label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <input type="text"  id="txtCorreo" name="txtCorreo" autocomplete="off" value="<?php echo FormatTextView($GLOBALS['oProveedor']->correo); ?>"  class="form-control"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">Ubicación</div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label>Departamento: </label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <select id="selDepartamento" name="selDepartamento" class="form-control" onchange="fncDepartamento();">
                                        <?php foreach($GLOBALS['oProveedor']->dtDepartamento as $iDepartamento){
                                            echo '<option value="'.$iDepartamento['ID'].'">'.$iDepartamento['nombre'].'</option>';
                                        } ?>
                                        </select>
                                        <script type="text/javascript">
                                            $('#selDepartamento').val(<?php echo $GLOBALS['oProveedor']->departamento_ID; ?>);
                                        </script>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label>Provincia: </label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <select id="selProvincia" name="selProvincia" class="form-control" onchange="fncProvincia();">
                                            <?php foreach($GLOBALS['oProveedor']->dtProvincia as $provincia){?>
                                            <option value="<?php echo $provincia['ID']; ?>"><?php echo FormatTextView(strtoupper($provincia['nombre']))?></option>
                                            <?php } ?>
                                        </select>
                                        <script type="text/javascript">
                                            $('#selProvincia').val(<?php echo $GLOBALS['oProveedor']->provincia_ID; ?>);
                                        </script>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label>Distrito: </label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <select id="selDistrito" name="selDistrito" class="form-control">
                                            <?php foreach($GLOBALS['oProveedor']->dtDistrito as $distrito){?>
                                            <option value="<?php echo $distrito['ID']; ?>"><?php echo FormatTextView(strtoupper($distrito['nombre']))?></option>
                                            <?php } ?>
                                        </select>
                                        <script type="text/javascript">
                                            $('#selDistrito').val(<?php echo $GLOBALS['oProveedor']->distrito_ID; ?>);
                                        </script>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label>Dirección: </label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                         <input type="text"  id="txtDireccion" name="txtDireccion" autocomplete="off" value="<?php echo FormatTextView($GLOBALS['oProveedor']->direccion); ?>" class="form-control text-uppercase"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">Datos de Pagos</div>
                            <div class="panel-body">
                                 <div class="form-group">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label>Banco: </label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <input type="text"  id="txtBanco" name="txtBanco" autocomplete="off" value="<?php echo FormatTextView($GLOBALS['oProveedor']->banco); ?>"  class="form-control text-uppercase"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label>Nro. Cuenta (S/.): </label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <input type="text"  id="txtNumero_Cuenta_Soles" name="txtNumero_Cuenta_Soles" autocomplete="off" value="<?php echo FormatTextView($GLOBALS['oProveedor']->numero_cuenta_soles); ?>" class="form-control int-text"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label>Nro. Cuenta(US$): </label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <input type="text"  id="txtNumero_Cuenta_Dolares" name="txtNumero_Cuenta_Dolares" autocomplete="off" value="<?php echo FormatTextView($GLOBALS['oProveedor']->numero_cuenta_dolares); ?>"  class="form-control int-text"/>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">Otros datos</div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label>Parne: </label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <input type="text"  id="txtParne" name="txtParne" autocomplete="off" value="<?php echo FormatTextView($GLOBALS['oProveedor']->parne); ?>"  class="form-control text-uppercase"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label>Estado: </label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <select id="selEstado" name="selEstado" class="form-control form-requerido">
                                            <?php foreach($GLOBALS['oProveedor']->dtEstado as $valor){ ?>
                                            <option value="<?php echo $valor['ID'];?>"><?php echo FormatTextView(strtoupper($valor['nombre']));?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="proveedor_contacto">
                 <div class="panel panel-default">
                    <div class="panel-heading">Persona contacto</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <label>Persona: </label>&nbsp;&nbsp;&nbsp;<a class="btn btn-success" title="Agregar persona nueva" onclick="fncAgregar_Persona();"><img src="/include/img/boton/add_user-20.png"></a>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <input type="hidden" id="txtPersona_ID" name="txtPersona_ID">
                                <input type="text" id="listaPersonas" class="form-control form-requerido">
                                <script>
                                    $(document).ready(function(){
                                        lista('/funcion/ajaxListarPersonas','listaPersonas','txtPersona_ID',mostrar_informacion_persona);
                                    });
                                    
                                </script>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <label>Teléfono: </label>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <input type="text" id="txtTelefono1" name="txtTelefono1" autocomplete="off" class="form-control text-uppercase int-text">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <label>Celular: </label>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <input type="text" id="txtCelular1" name="txtCelular1" autocomplete="off" class="form-control text-uppercase int-text">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <label>Correo: </label>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <input type="text" id="txtCorreo1" name="txtCorreo1" autocomplete="off" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <label>Estado: </label>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <select id="selEstado1" name="selEstado1" class="form-control">
                                    <?php foreach($GLOBALS['oProveedor_Contacto']->dtEstado as $proveedor_contacto){?>
                                    <option value="<?php echo $proveedor_contacto['ID']?>"><?php echo FormatTextView(strtoupper($proveedor_contacto['nombre']));?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-footer">
        <div class="pull-left">
            <button  id="btnEnviar" name="btnEnviar" class="btn btn-success" >
                <span class="glyphicon glyphicon-floppy-disk"></span>
                Guardar
            </button>
            <button  id="btnCancelar" name="btnCancelar" class="btn btn-warning" type="button" onclick="window_float_close_modal();" >
                <span class="glyphicon glyphicon-arrow-left"></span>
                Cerrar
            </button> 
        </div>
        <div class="clerafix"></div>
    </div>
   

</form>
<style>
    .divBuscador{
    position:absolute!important;
    z-index: 10;background:#7FFFD4;
}
</style>
<script type="text/javascript">
    $('.nav-tabs a').on('shown.bs.tab', function(event){
        var x = $(event.target).text();         // active tab
        var y = $(event.relatedTarget).text();  // previous tab
        /*$('#divPersona').remove();
        if(typeof(cboPersona)=="undefined"){
            var cboPersona = newCbo('divPersona', 'txtPersona_ID', '/funcion/ajaxCbo_Persona', true);
        } 
        cboPersona.seleccionado=function(){
            var id=$('#sendtxtPersona_ID').val();
            mostrar_informacion_persona(id);
        }*/
    });
    var fncDepartamento=function(){
        var obj = $('#selDepartamento');
        ajaxSelect('selProvincia', '/Mantenimiento/ajaxSelect_Provincia/' + obj.val(), '',fncProvincia);
    }

    var fncProvincia=function(){
        var obj = $('#selProvincia');
        ajaxSelect('selDistrito', '/Mantenimiento/ajaxSelect_Distrito/' + obj.val(), '',null);
    }
    var fncAgregar_Persona=function(){
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
            $('#txtDireccion1').val(resultado.oPersona.direccion);
            $('#txtTelefono1').val(resultado.oPersona.telefono);
            $('#txtCelular1').val(resultado.oPersona.celular);
            $('#txtCorreo1').val(resultado.oPersona.correo);
            
        });
    }

    
    var MostrarLista=function(buscador,contenedorLista){
         var valor_buscar=$('#'+buscador).val();
        if(contenedorLista=='divRuc'){
           
            cboMostrarTexto('/Mantenimiento/ajaxCbo_ProveedorRuc',valor_buscar,contenedorLista);
        }else {
             
            cboMostrarTexto('/Mantenimiento/ajaxCbo_ProveedorRazonSocial',valor_buscar,contenedorLista);
        }
        
       
                
    }
    var subirValorCaja=function(valor,tipo){
        if(tipo==1){
            $('#txtRuc').val(valor);
            $('#divRuc').html('');
        }else {
            $('#txtRazon_Social').val(valor);
            $('#divRazonSocial').html('');
        }
      
    }
    var validar = function () {

        var ruc = $.trim($('#txtRuc').val());
        var razon_social = $.trim($('#txtRazon_Social').val());
        var correo=$.trim($('#txtCorreo').val());
        var correo1=$.trim($('#txtCorreo1').val());
        if (ruc=="") {
            mensaje.error("Mensaje de error","Debe ingresar un ruc válido","txtRuc");
            mover_scroll_inicio();
            return false;
        }
        if (ruc.length<11) {
            mensaje.error("Mensaje de error","El ruc no es válido.","txtRuc");
            mover_scroll_inicio();
            return false;
        }
        if (razon_social=="") {
            mensaje.error("Mensaje de error","Registre una razon social","txtRazon_Social");
            mover_scroll_inicio();
            return false;
        }
        if(correo!=""){
            if (!validarEmail(correo))
            {
                mensaje.error("Mensaje de error","No es un correo valido.este de mi",'txtCorreo'); 
                mover_scroll_inicio();
                return false;
            }
        }
        if(correo1!=""){
            if (!validarEmail(correo1))
            {
                mensaje.error("Mensaje de error","No es un correo valido.",'txtCorreo1'); 
                mover_scroll_inicio();
                return false;
            }
        }

    }
    var fncSeleccionar=function(id){
        $('#txtIDRepresentante').val(id);
        $('.grid tr').removeClass('trSelecionado');
        $('#'+id).addClass('trSelecionado');
        $('#btnEditar').css('display','inline');
        $('#btnEliminar').css('display','inline');
        //alert(id);
    }
    
    

    </script>   


    <?php } ?>


    
    <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 1) { ?>
        
        <script type="text/javascript">
            $(document).ready(function(){
                toastem.success("<?php echo $GLOBALS['mensaje'];?>");
                setTimeout('window_float_save_modal();', 1000);
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
