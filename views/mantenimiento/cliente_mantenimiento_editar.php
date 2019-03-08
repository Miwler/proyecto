<?php
require ROOT_PATH . "views/shared/content-float-modal.php";
?>	
<?php

function fncTitle() { ?> Editar Cliente<?php } ?>

<?php

function fncHead() { ?>

    <script type="text/javascript" src="include/js/jForm.js"></script>
    
<?php } ?>

<?php

function fncTitleHead() { ?>Editar Cliente<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>
<?php if (!isset($GLOBALS['resultado'])|| $GLOBALS['resultado'] == -1) { ?>
<form id="form1" method="POST" action="/Mantenimiento/Cliente_Mantenimiento_Editar/<?php echo $GLOBALS['oCliente']->ID;?>" class="form-horizontal" onsubmit="return validar();">
    <div class="form-body" style="height: 450px;overflow: auto;">
        <ul class="nav nav-tabs">
        <li class="active"><a href="#cliente" data-toggle="tab"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Empresa</a></li>
        <li><a href="#cliente_contacto" data-toggle="tab"><i class="fa fa-users" aria-hidden="true"></i> Persona contacto</a></li>
        <li><a href="#ejecutivo" data-toggle="tab"><i class="fa fa-users" aria-hidden="true"></i> Ejecutivo</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade in active" id="cliente">
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
                                  <input  type="text"  id="txtRuc" name="txtRuc" autocomplete="off" maxlength="11" minlength="11"   onkeyup="MostrarLista(this.id,'divRuc');" value="<?php echo $GLOBALS['oCliente']->ruc; ?>" class="form-control form-requerido text-int"/>
                                  <div id="divRuc" class="divBuscador"></div>
                              </div>
                          </div>
                          <div class="form-group">
                              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                  <label>Razon Social: </label>
                              </div>
                              <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                  <input type="text"  id="txtRazon_Social" name="txtRazon_Social" autocomplete="off" value="<?php echo $GLOBALS['oCliente']->razon_social; ?>" onkeyup="MostrarLista(this.id,'divRazonSocial');" class="form-control form-requerido "/>
                                  <div id="divRazonSocial" class="divBuscador"></div>
                              </div>
                          </div>
                          <div class="form-group">
                              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                  <label>Dirección fiscal: </label>
                              </div>
                              <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                  <input type="text"  id="txtDireccion_Fiscal" name="txtDireccion_Fiscal" autocomplete="off" value="<?php echo $GLOBALS['oCliente']->direccion_fiscal; ?>"  class="form-control "/>
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
                                    <input type="text"  id="txtNombre_Comercial" name="txtNombre_Comercial" autocomplete="off" value="<?php echo $GLOBALS['oCliente']->nombre_comercial; ?>"  class="form-control "/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label>Estado: </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <select id="selEstado" name="selEstado" class="form-control form-requerido">
                                        <?php foreach($GLOBALS['oCliente']->dtEstado as $valor){ ?>
                                        <option value="<?php echo $valor['ID'];?>"><?php echo $valor['nombre'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label>Teléfono: </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <input type="text"  id="txtTelefono" name="txtTelefono" autocomplete="off" value="<?php echo $GLOBALS['oCliente']->telefono; ?>"  class="form-control int-text"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label>Celular: </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <input type="text"  id="txtCelular" name="txtCelular" autocomplete="off" value="<?php echo $GLOBALS['oCliente']->celular; ?>"  class="form-control int"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label>Correo: </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <input type="text"  id="txtCorreo" name="txtCorreo" autocomplete="off" value="<?php echo $GLOBALS['oCliente']->correo; ?>"  class="form-control"/>
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
                                    <?php foreach($GLOBALS['oCliente']->dtDepartamento as $iDepartamento){
                                        echo '<option value="'.$iDepartamento['ID'].'">'.$iDepartamento['nombre'].'</option>';
                                    } ?>
                                    </select>
                                    <script type="text/javascript">
                                        $('#selDepartamento').val(<?php echo $GLOBALS['oCliente']->departamento_ID; ?>);
                                    </script>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label>Provincia: </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <select id="selProvincia" name="selProvincia" class="form-control" onchange="fncProvincia();">
                                        <?php foreach($GLOBALS['oCliente']->dtProvincia as $provincia){?>
                                        <option value="<?php echo $provincia['ID']; ?>"><?php echo $provincia['nombre'];?></option>
                                        <?php } ?>
                                    </select>
                                    <script type="text/javascript">
                                        $('#selProvincia').val(<?php echo $GLOBALS['oCliente']->provincia_ID; ?>);
                                    </script>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label>Distrito: </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <select id="selDistrito" name="selDistrito" class="form-control">
                                        <?php foreach($GLOBALS['oCliente']->dtDistrito as $distrito){?>
                                        <option value="<?php echo $distrito['ID']; ?>"><?php echo $distrito['nombre'];?></option>
                                        <?php } ?>
                                    </select>
                                    <script type="text/javascript">
                                        $('#selDistrito').val(<?php echo $GLOBALS['oCliente']->distrito_ID; ?>);
                                    </script>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label>Dirección: </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                     <input type="text"  id="txtDireccion" name="txtDireccion" autocomplete="off" value="<?php echo $GLOBALS['oCliente']->direccion; ?>" class="form-control "/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Datos de económicos</div>
                        <div class="panel-body">
                             <div class="form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label>Forma de pago: </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <select id="selForma_Pago" name="selForma_Pago" class="form-control ">
                                        <?php foreach($GLOBALS['oCliente']->dtForma_Pago as $item){?>
                                        <option value="<?php echo $item['ID']?>"><?php echo $item['nombre'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label>Tiempo crédito: </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <input type="number"  id="txtTiempo_Credito" name="txtTiempo_Credito" autocomplete="off" value="<?php echo $GLOBALS['oCliente']->tiempo_credito; ?>" class="form-control int"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label>Descuento: </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <input type="text"  id="txtDescuento" name="txtDescuento" autocomplete="off" value="<?php echo $GLOBALS['oCliente']->descuento; ?>"  class="form-control decimal"/>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Datos para devolución</div>
                        <div class="panel-body">
                             <div class="form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label>Banco: </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <input type="text"  id="txtBanco" name="txtBanco" autocomplete="off" value="<?php echo $GLOBALS['oCliente']->banco; ?>"  class="form-control "/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label>Nro. Cuenta (S/.): </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <input type="text"  id="txtNumero_Cuenta_Soles" name="txtNumero_Cuenta_Soles" autocomplete="off" value="<?php echo $GLOBALS['oCliente']->numero_cuenta_soles; ?>" class="form-control int-text"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label>Nro. Cuenta(US$): </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <input type="text"  id="txtNumero_Cuenta_Dolares" name="txtNumero_Cuenta_Dolares" autocomplete="off" value="<?php echo $GLOBALS['oCliente']->numero_cuenta_dolares; ?>"  class="form-control int-text"/>
                                </div>
                            </div>

                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="cliente_contacto">
             <div class="panel panel-default">
                <div class="panel-heading">Persona contacto</div>
                <div class="panel-body" id="divFormulario">
                    <div class="form-group">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <input id="txtID" name="txtID" value="0" style="display:none;">
                            <input id="txtcliente_ID" name="txtcliente_ID" value="<?php echo $GLOBALS['oCliente']->ID;?>" style="display:none;">
                            <label>Persona: </label>&nbsp;&nbsp;&nbsp;<a class="btn btn-success" title="Agregar persona nueva" onclick="fncAgregar_Persona();"><img src="/include/img/boton/add_user-20.png"></a>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                            <input type="hidden" id="txtPersona_ID" name="txtPersona_ID">
                            <input type="text" id="listaPersonas" class="form-control form-requerido">
                            <script type="text/javascript">
                                $(document).ready(function(){
                                        lista('/funcion/ajaxListarPersonas','listaPersonas','txtPersona_ID',mostrar_informacion_persona);
                                    });
                            </script>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <label>Cargo: </label>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                            <input type="text" id="txtCargo" name="txtCargo" autocomplete="off" class="form-control ">
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <label>Teléfono: </label>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                            <input type="text" id="txtTelefono1" name="txtTelefono1" autocomplete="off" class="form-control int-text">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <label>Celular: </label>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                            <input type="text" id="txtCelular1" name="txtCelular1" autocomplete="off" class="form-control ">
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
                                <?php foreach($GLOBALS['oCliente_Contacto']->dtEstado as $cliente_contacto){?>
                                <option value="<?php echo $cliente_contacto['ID']?>"><?php echo $cliente_contacto['nombre'];?></option>
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
                                <div class="panel-body" id="divContenedor" style="height: 250px;overflow:auto;">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="ejecutivo">
            <div class="form-group">
                <label class="control-label col-sm-4">Ejecutivo de venta:</label>
                <div class="col-sm-8">
                    <select id="selOperador" name="selOperador" class="form-control chosen-select mb-15" >
                        <option value="0">--Ninguno-</option>
                        <?php foreach($GLOBALS['dtOperador'] as $operador) {?>
                        <option value="<?php echo $operador['ID']?>"><?php echo $operador['apellido_paterno']." ".$operador['apellido_materno']." ".$operador['nombres']?></option>
                        <?php }?>
                    </select>
                    <script>
                    $("#selOperador").val(<?php echo $GLOBALS['oCliente']->operador_ID;?>);
                    </script>
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
                Salir
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
       
        parent.window_float_open_modal_hijo('REGISTRAR NUEVO PERSONA','/Mantenimiento/Persona_Mantenimiento_Nuevo_otro','','',fncCargarPersona,800,500);
             
        //window_float_deslizar('form','/Mantenimiento/Persona_Mantenimiento_Nuevo','','');
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
            //$('#txtCargo').val(resultado.oPersona.cargo);
            $('#txtTelefono1').val(resultado.oPersona.telefono);
            $('#txtCelular1').val(resultado.oPersona.celular);
            $('#txtCorreo1').val(resultado.oPersona.correo);
            
            $('#btnAccion').prop('disabled', false);
            $('#btnCancelar').prop('disabled', false);
            
        });
    }

    
    var MostrarLista=function(buscador,contenedorLista){
         var valor_buscar=$('#'+buscador).val();
        if(contenedorLista=='divRuc'){
           
            cboMostrarTexto('/Mantenimiento/ajaxCbo_ClienteRuc',valor_buscar,contenedorLista);
        }else {
             
            cboMostrarTexto('/Mantenimiento/ajaxCbo_ClienteRazonSocial',valor_buscar,contenedorLista);
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
    var fncSeleccionar=function(id){
        $('#txtIDRepresentante').val(id);
        $('.grid tr').removeClass('trSelecionado');
        $('#'+id).addClass('trSelecionado');
        $('#btnEditar').css('display','inline');
        $('#btnEliminar').css('display','inline');
        //alert(id);
    }
    var mostrar_lista_contacto=function(){
        var cliente_ID=<?php echo $GLOBALS['oCliente']->ID?>;
        cargarValores('Mantenimiento/ajaxMostar_Lista_Contacto_Cliente',cliente_ID,function(resultado){
            $('#divContenedor').html(resultado.resultado)
        });
    }
    var fncEditar=function(id){
        var persona =$('#'+id).find('td')[0].innerHTML;
        var persona_ID=$('#txt'+id).val();
        
        var cargo=$('#'+id).find('td')[1].innerHTML;
        var telefono=$('#'+id).find('td')[2].innerHTML;
        var celular=$('#'+id).find('td')[3].innerHTML;
        var correo=$('#'+id).find('td')[4].innerHTML;
        var estado_ID=$('#est'+id).val();
        //alert(celular);
        
        $('#txtID').val(id);
        $('#txtCargo').val(cargo);
        $('#txtTelefono1').val(telefono);
        $('#txtCelular1').val(celular);
        $('#txtCorreo1').val(correo);
        $('#selEstado1').val(estado_ID);
        $("#txtPersona_ID").val(persona_ID);
        $('#listaPersonas').val(persona);
        
        //cboPersona.seleccionar1(persona_ID, persona)
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
             if(correo!="" && !validarEmail(correo)){
                mensaje.error("Mensaje de error","No es un correo valido.",'txtCorreo1');
             }
             else{
                enviarFormulario('Mantenimiento/ajaxAccionCliente_Contacto','divFormulario',function(resultado){
                    if(resultado.resultado==1){
                        toastem.success(resultado.mensaje);
                        mostrar_lista_contacto();
                        limpiar();
                    }else{
                        mensaje.error("Mensaje de error", resultado.mensaje);
                    }
                });
            }  
        }  
    }
    var validar_formulario=function(){
        alert('nova');
        var correo=$('#txtCorreo1').val();
        if (!validarEmail(correo))
        {
            mensaje.error("Mensaje de error","No es un correo valido.",'txtCorreo1');
           return false;
        }
        return true;
    }
    var fncCancelar=function(){
        limpiar();
    }
    var limpiar=function(){
        $('#btnAccion').prop('disabled', true);
        $('#btnAccion').html('<span class="glyphicon glyphicon-plus"></span>');
        
        $('#btnAccion').attr('title', 'Agregar persona contacto');
        $("#sendtxtPersona_ID").val('0');
       
        /*if(typeof(cboPersona)=="undefined"){
            var cboPersona = newCbo('divPersona', 'txtPersona_ID', '/funcion/ajaxCbo_Persona', true);
        }*/
        $('#listaPersonas').val('');
        $('#txtPersona_ID').val('');
        $('#txtID').val('0');
        $('#txtCargo').val('');
        $('#txtTelefono1').val('');
        $('#txtCelular1').val('');
        $('#txtCorreo1').val('');
        $('#selEstado1').val(72);
    }
    
    var fncEliminar=function(id){
       
        cargarValores('/Mantenimiento/ajaxCliente_Mantenimiento_Contacto_Eliminar',id,function(resultado){
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
    
     <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == -2) { ?>
    <script type="text/javascript">
        $(document).ready(function () {
            toastem.error("<?php echo $GLOBALS['mensaje'];?>")
            setTimeout('window_float_save_modal();', 1000);

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
