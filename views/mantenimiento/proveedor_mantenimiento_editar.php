<?php
require ROOT_PATH . "views/shared/content-float-modal.php";
?>	
<?php

function fncTitle() { ?>Editar Proveedor<?php } ?>

<?php

function fncHead() { ?>
 
    <script type="text/javascript" src="include/js/jForm.js"></script>
  
<?php } ?>

<?php

function fncTitleHead() { ?>Editar Proveedor<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>
<?php if (!isset($GLOBALS['resultado'])|| $GLOBALS['resultado'] == -1) { ?>
<form id="form1" method="POST" action="/Mantenimiento/Proveedor_Mantenimiento_Editar/<?php echo $GLOBALS['oProveedor']->ID?>" class="form-horizontal" onsubmit="return validar();">
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
                <div class="panel-body" id="divFormulario">
                    <div class="form-group">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <input id="txtID" name="txtID" value="0" style="display:none;">
                            <input id="txtproveedor_ID" name="txtproveedor_ID" value="<?php echo $GLOBALS['oProveedor']->ID;?>" style="display:none;">
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
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button type="button" id="btnAccion" onclick="fncAccion();" title="Agregar persona contacto" class="btn btn-success" disabled><span class="glyphicon glyphicon-plus"></span></button>&nbsp;&nbsp;&nbsp;
                            <button type="button" id="btnCancelar" onclick="fncCancelar();" title="Cancelar" disabled class="btn btn-danger"><span class="glyphicon glyphicon-ban-circle"></span></button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Lista de persona contacto
                                </div>
                                <div class="panel-body" id="divContenedor">
                                    
                                </div>
                            </div>
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
        <div class="clearfix"></div>
    </div>


</form>
<script type="text/javascript">
    
    $('.nav-tabs a').on('shown.bs.tab', function(event){
        var x = $(event.target).text();         // active tab
        var y = $(event.relatedTarget).text();  // previous tab
       
        mostrar_lista_contacto();
    });
    /*cboPersona.seleccionado=function(){
        var id=$('#sendtxtPersona_ID').val();
        mostrar_informacion_persona(id);
        $('#btnAccion').prop('disabled', false);
        $('#btnCancelar').prop('disabled', false);
    }
    cboPersona.eliminado=function(){
        var ID=$('#txtID').val();
        if(ID==0){
           //limpiar(); 
        }
    }*/
    var fncDepartamento=function(){
        var obj = $('#selDepartamento');
        ajaxSelect('selProvincia', '/Mantenimiento/ajaxSelect_Provincia/' + obj.val(), '',fncProvincia);
    }
    
    var fncProvincia=function(){
        var obj = $('#selProvincia');
        ajaxSelect('selDistrito', '/Mantenimiento/ajaxSelect_Distrito/' + obj.val(), '',null);
    }
    var fncAgregar_Persona=function(){
        window_float_deslizar('form','/Mantenimiento/Persona_Mantenimiento_Nuevo','','');
    } 
   /* var fncCargarPersona=function(id,nombres){
        cboPersona.seleccionar(id, nombres);
        
    }*/

    var mostrar_informacion_persona=function(id){
        cargarValores('/Funcion/ajaxExtraerInformacionPersona',id,function(resultado){
            
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
                mensaje.error("Mensaje de error","No es un correo valido.",'txtCorreo'); 
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
    
    
    var mostrar_lista_contacto=function(){
        var proveedor_ID=<?php echo $GLOBALS['oProveedor']->ID?>;
        cargarValores('Mantenimiento/ajaxMostar_Lista_Contacto',proveedor_ID,function(resultado){
            $('#divContenedor').html(resultado.resultado)
        });
    }
    var fncEditar=function(id){
        var persona =$('#'+id).find('td')[0].innerHTML;
        var persona_ID=$('#txt'+id).val();
        var telefono=$('#'+id).find('td')[1].innerHTML;
        var celular=$('#'+id).find('td')[2].innerHTML;
        var correo=$('#'+id).find('td')[3].innerHTML;
        var estado_ID=$('#est'+id).val();
        
        $('#txtID').val(id);
        $('#txtTelefono1').val(telefono);
        $('#txtCelular1').val(celular);
        $('#txtCorreo1').val(correo);
        $('#selEstado1').val(estado_ID);
        $("#txtPersona_ID").val(persona_ID);
        $("#listaPersonas").val(persona);
        //cboPersona.seleccionar1(persona_ID, persona);
        $('#btnAccion').html('<span class="glyphicon glyphicon-floppy-disk"></span>');
        $('#btnAccion').prop('disabled', false);
        $('#btnAccion').attr('title', 'Grabar');
        mover_scroll_inicio();
        
    }
    var fncAccion=function(){
        if(typeof($('#sendtxtPersona_ID'))=="undefined"){
            mensaje.error("Mensaje de error","Debe seleccionar una persona.","txtPersona_ID");
        }else{
            var correo=$('#txtCorreo1').val();
            if (!validarEmail(correo) && correo!=""){
                 mensaje.error("Mensaje de error","Debe registrar un correo válido",'txtCorreo1');
            }else{
                enviarFormulario('Mantenimiento/ajaxAccionProveedor_Contacto','divFormulario',function(resultado){
                if(resultado.resultado==1){
                    toastem.success(resultado.mensaje);
                    mostrar_lista_contacto();
                    limpiar();
                }else{
                    mensaje.error("Mensaje de error", resultado.mensaje,"");
                }
            });
            }

        }
        
        
    }
    var fncCancelar=function(){
        limpiar();
    }
    var limpiar=function(){
        $('#btnAccion').prop('disabled', true);
        $('#btnAccion').html('<span class="glyphicon glyphicon-plus"></span>');
        
        $('#btnAccion').attr('title', 'Agregar persona contacto');
        $("#sendtxtPersona_ID").val('0');
       
        
        $('#txtPersona_ID').val('');
        $('#txtID').val('0');
        
        $('#txtTelefono1').val('');
        $('#txtCelular1').val('');
        $('#txtCorreo1').val('');
        $('#selEstado1').val(70);
    }
    var fncEliminar=function(id){
       
        cargarValores('/Mantenimiento/ajaxProveedor_Mantenimiento_Contacto_Eliminar',id,function(resultado){
            if(resultado.resultado==1){
                mostrar_lista_contacto();
                toastem.info(resultado.mensaje);
            }else {
                toastem.error(resultado.mensaje);
            }
            
            
        });
    }
    
    </script>   
    <style type="text/css">
        #divContenedor td{
            font-size:10px;
        }
    </style>

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
