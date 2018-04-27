<?php		
	require ROOT_PATH."views/shared/content-float.php";	
?>	
<?php function fncTitle(){?>
		Nuevo Empresa
<?php } ?>
<?php function fncHead(){?>
    <script type="text/javascript" src="include/js/jForm.js"></script>
 
<?php } ?>
                
<?php
    function fncTitleHead() { ?>
    <span class="glyphicon glyphicon-briefcase"></span> Nueva Empresa
<?php } ?>                
                
<?php function fncMenu(){?>
<?php } ?>
<?php function fncPage(){?>
    <?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1){ ?> 
    <div class="panel panel-success">
        <form id="frm1" name="frm1" method="post" enctype="multipart/form-data" action="/Configuracion_General/Empresa_Mantenimiento_Nuevo" onsubmit="return validar();">
            <div class="panel-body">
            <center>
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab1">I</a></li>
                    <li><a data-toggle="tab" href="#tab2">II</a></li>
                    <li><a data-toggle="tab" href="#tab3">III</a></li>
                    <li><a data-toggle="tab" href="#tab4">IV</a></li>
                    <li><a data-toggle="tab" href="#tab5">V</a></li>
                    <li><a data-toggle="tab" href="#tab6">VI</a></li>
                    <li><a data-toggle="tab" href="#tab7">VII</a></li>
                    
                </ul>
                <div class="tab-content" style="height: 500px;overflow: auto;">
                    <div id="tab1" class="tab-pane fade in active">
                        <h3>CONFIGURACIÓN</h3>
                        <div class="row">
                            <div class="col-xs-3 col-md-3 col-sm-3 col-lg-3 text-right">
                                <label>Nombre:</label>
                            </div>
                            <div class="col-xs-9 col-md-9 col-sm-9 col-lg-9">
                                <input type="text" id="txtNombre" name="txtNombre" autocomplete="off" class="form-control form-requerido" value="<?php echo $GLOBALS['oEmpresa']->nombre;?>" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3 col-md-3 col-sm-3 col-lg-3 text-right">
                                <label>Ruta:</label>
                            </div>
                            <div class="col-xs-9 col-md-9 col-sm-9 col-lg-9">
                                <input type="text" id="txtRuta" name="txtRuta" autocomplete="off" class="form-control form-requerido" value="<?php echo $GLOBALS['oEmpresa']->ruta;?>" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3 text-right">
                                <label>Logo: </label>
                            </div>
                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-9">
                                <img id="imagen_previa" src="<?php echo $GLOBALS['oEmpresa']->ruta;?>/imagenes/logo/<?php echo $GLOBALS['oDatos_Generales']->logo_extension;?>" style="height: 80px">
                                <input type="file" name="logo" id="logo" onchange="fileValidation();">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3 text-right">
                                <label>Favicon: </label>
                            </div>
                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-9">
                                <img id="imagen_previaicono" src="<?php echo $GLOBALS['oEmpresa']->ruta;?>/imagenes/favicon/<?php echo $GLOBALS['oDatos_Generales']->favicon;?>" style="height: 40px">
                                <input type="file" name="icono" id="icono" onchange="fileValidationIcono();">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3 text-right">
                                <label>Imagen botón principal: </label>
                            </div>
                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-9">
                                <img id="imagen_previaiImagen" src="<?php echo $GLOBALS['oEmpresa']->ruta;?>/imagenes/imagen/<?php echo $GLOBALS['oDatos_Generales']->imagen;?>" style="height: 40px">
                                <input type="file" name="imagen" id="imagen" onchange="fileValidationImagen();">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3 col-md-3 col-sm-3 col-lg-3 text-right">
                                <label>Estilo fondo tabs:</label>
                            </div>
                            <div class="col-xs-9 col-md-9 col-sm-9 col-lg-9">
                                <select id="selStilo_fondo_tabs" name="selStilo_fondo_tabs" class="form-control form-requerido">
                                    <option value="">--Seleccionar--</option>
                                    <option value="primary">primary</option>
                                    <option value="secondary">secondary</option>
                                    <option value="success">success</option>
                                    <option value="danger">danger</option>
                                    <option value="warning">warning</option>
                                    <option value="info">info</option>
                                </select>
                                <script>
                                $('#selStilo_fondo_tabs').val("<?php echo $GLOBALS['oEmpresa']->stilo_fondo_tabs;?>");
                                </script>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3 col-md-3 col-sm-3 col-lg-3 text-right">
                                <label>Estilo fondo boton:</label>
                            </div>
                            <div class="col-xs-9 col-md-9 col-sm-9 col-lg-9">
                                <select id="selStilo_fondo_boton" name="selStilo_fondo_boton" class="form-control form-requerido">
                                    <option value="">--Seleccionar--</option>
                                    <option value="primary">primary</option>
                                    <option value="secondary">secondary</option>
                                    <option value="success">success</option>
                                    <option value="danger">danger</option>
                                    <option value="warning">warning</option>
                                    <option value="info">info</option>
                                </select>
                                <script>
                                $('#selStilo_fondo_boton').val("<?php echo $GLOBALS['oEmpresa']->stilo_fondo_boton;?>");
                                </script>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3 col-md-3 col-sm-3 col-lg-3 text-right">
                                <label>Estilo fondo cabecera:</label>
                            </div>
                            <div class="col-xs-9 col-md-9 col-sm-9 col-lg-9">
                                <select id="selStilo_fondo_cabecera" name="selStilo_fondo_cabecera" class="form-control form-requerido">
                                    <option value="">--Seleccionar--</option>
                                    <option value="primary">primary</option>
                                    <option value="secondary">secondary</option>
                                    <option value="success">success</option>
                                    <option value="danger">danger</option>
                                    <option value="warning">warning</option>
                                    <option value="info">info</option>
                                </select>
                                <script>
                                $('#seltStilo_fondo_cabecera').val("<?php echo $GLOBALS['oEmpresa']->stilo_fondo_cabecera;?>");
                                </script>

                            </div>
                        </div>
                    </div>
                    <div id="tab2" class="tab-pane fade">
                        <h3>INFORMACIÓN DE LA EMPRESA</h3>
                        <div class="row">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3 text-right">
                                <label>Nombre corto: </label>
                            </div>
                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-9 ">
                                <input type="text" id="txtAlias" name="txtAlias" value="<?php echo $GLOBALS['oDatos_Generales']->alias;?>" class="form-control form-requerido text-uppercase">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3 text-right">
                                <label>Departamento: </label>
                            </div>
                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-9">
                                <select id="selDepartamento" name="selDepartamento" class="form-control" onchange="fncDepartamento();">
                                    <?php foreach($GLOBALS['dtDepatamento'] as $departamento){ ?>
                                    <option value="<?php echo $departamento['ID']?>"><?php echo FormatTextView($departamento['nombre'])?></option>
                                    <?php } ?>
                                </select>
                                <script type="text/javascript">
                                    $('#selDepartamento').val('<?php echo $GLOBALS['oDatos_Generales']->departamento_ID?>');
                                </script>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3 text-right">
                                <label>Provincia: </label>
                            </div>
                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-9">
                                <select id="selProvincia" name="selProvincia" class="form-control">
                                    <?php foreach($GLOBALS['dtProvincia'] as $provincia){ ?>
                                    <option value="<?php echo $provincia['ID']?>"><?php echo FormatTextView($provincia['nombre'])?></option>
                                    <?php } ?>
                                </select>
                                <script type="text/javascript">
                                    $('#selProvincia').val('<?php echo $GLOBALS['oDatos_Generales']->provincia_ID?>');
                                </script>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3 text-right">
                                <label>Distrito: </label>
                            </div>
                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-9">
                                <select id="selDistrito" name="selDistrito" class="form-control">
                                     <?php foreach($GLOBALS['dtDistrito'] as $distrito){ ?>
                                    <option value="<?php echo $distrito['ID']?>"><?php echo FormatTextView($distrito['nombre'])?></option>
                                    <?php } ?>
                                </select>
                                <script type="text/javascript">
                                    $('#selDistrito').val('<?php echo $GLOBALS['oDatos_Generales']->distrito_ID?>');
                                </script>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3 text-right">
                                <label>Dirección: </label>
                            </div>
                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-9">
                                <input type="text" id="txtDireccion" name="txtDireccion" value="<?php echo $GLOBALS['oDatos_Generales']->direccion;?>" class="form-control form-requerido text-uppercase">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3 text-right">
                                <label>Observación: </label>
                            </div>
                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-9">
                                <textarea id="txtObservacion" name="txtObservacion" class="form-control"><?php echo FormatTextView($GLOBALS['oDatos_Generales']->observacion);?></textarea>

                            </div>
                        </div>
                    </div>
                    <div id="tab3" class="tab-pane fade">
                        <h3>INFORMACIÓN SUNAT</h3>
                        <div class="row">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3 text-right">
                                <label>Razon social: </label>
                            </div>
                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-9">
                                <input type="text" id="txtRazon_Social" name="txtRazon_Social" autocomplete="off"  value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->razon_social);?>" class="form-control form-requerido text-uppercase">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3 text-right">
                                <label>R.U.C.: </label>
                            </div>
                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-9">
                                <input type="text" id="txtRuc" name="txtRuc" maxlength="11" autocomplete="off" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->ruc);?>" class="form-control form-requerido text-uppercase int">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3 text-right">
                                <label>Dirección fiscal: </label>
                            </div>
                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-9">
                                <input type="text" id="txtDireccion_Fiscal" name="txtDireccion_Fiscal" value="<?php echo $GLOBALS['oDatos_Generales']->direccion_fiscal;?>" class="form-control form-requerido text-uppercase">
                            </div>
                        </div>
                    </div>
                    
                    <div id="tab4" class="tab-pane fade">
                        <h3>INFORMACIÓN MONETARIA</h3>
                        <div class="row">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3 text-right">
                                <label>Tipo de cambio: </label>
                            </div>
                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-9">
                                <input type="text" id="txtTipo_Cambio" name="txtTipo_Cambio" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->tipo_cambio);?>" class="form-control decimal">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3 text-right">
                                <label>I.G.V: </label>
                            </div>
                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-9">
                                <input type="text" id="txtVigv" name="txtVigv" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->vigv);?>" class="form-control decimal">
                            </div>
                        </div>
                    </div>
                    <div id="tab5" class="tab-pane fade">
                        <h3>INFORMACIÓN CONTACTOS</h3>
                        <div class="row">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3 text-right">
                                <label>Página web: </label>
                            </div>
                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-9">
                                <input type="text" id="txtPagina_Web" name="txtPagina_Web" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->pagina_web);?>" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3 text-right">
                                <label>Correos: </label>
                            </div>
                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-9">
                                <input type="text" id="txtCorreo" name="txtCorreo" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->mail_principal);?>" class="form-control">
                            </div>
                        </div>
                       
                        <div class="row">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3 text-right">
                                <label>Telefonos: </label>
                            </div>
                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-9">
                                <input type="text" id="txtTelefono" name="txtTelefono" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->telefono);?>" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3 text-right">
                                <label>Celulares: </label>
                            </div>
                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-9">
                                <input type="text" id="txtCelular" name="txtCelular" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->rpc);?>" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3 text-right">
                                <label>Persona Contacto: </label>
                            </div>
                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-9">
                                <input type="text" id="txtPersona_Contacto" name="txtPersona_Contacto" class="form-control" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->persona_contacto);?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3 text-right">
                                <label>Cargo: </label>
                            </div>
                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-9">
                                <input type="text" id="txtCargo_Contacto" name="txtCargo_Contacto" class="form-control" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->cargo_contacto);?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3 text-right">
                                <label>Skype:</label>
                            </div>
                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-9">
                                <input type="text" id="txtSkype" name="txtSkype" class="form-control" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->skype);?>">
                            </div>
                        </div>
                    </div>
                    <div id="tab6" class="tab-pane fade">
                        <h3>INFORMACIÓN PARA LA WEB</h3>
                        <div class="row">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3 text-right">
                                <label>Sitio web: </label>
                            </div>
                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-9">
                                <input type="text" id="txtSitio_Web" name="txtSitio_Web" class="form-control" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->sitio_web);?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3 text-right">
                                <label>Quienes somos: </label>
                            </div>
                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-9">
                                <textarea id="txtQuienes_Somos" name="txtQuienes_Somos" class="form-control"><?php echo FormatTextView($GLOBALS['oDatos_Generales']->quienes_somos);?></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3 text-right">
                                <label>Misión: </label>
                            </div>
                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-9">
                                <textarea id="txtMision" name="txtMision" class="form-control"><?php echo FormatTextView($GLOBALS['oDatos_Generales']->mision);?></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3 text-right">
                                <label>Visión: </label>
                            </div>
                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-9">
                                <textarea id="txtVision" name="txtVision" class="form-control"><?php echo FormatTextView($GLOBALS['oDatos_Generales']->vision);?></textarea>
                            </div>
                        </div>
                        
  
                        
                    </div>
                    <div id="tab7" class="tab-pane fade">
                        <h3>CONFIGURACIÓN DE ENVÍO DE CORREOS</h3>
                        <div class="row">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3 text-right">
                                <label>Cuenta de correo: </label>
                            </div>
                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-9">
                                <input type="text" id="txtMail_Webmaster" name="txtMail_Webmaster" class="form-control" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->mail_webmaster);?>">
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3 text-right">
                                <label>Contraseña: </label>
                            </div>
                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-9">
                                <input type="text" id="txtPassword_Webmaster" name="txtPassword_Webmaster" class="form-control" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->password_webmaster);?>" >   
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3 text-right">
                                <label>Servidor SMTP: </label>
                            </div>
                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-9">
                                <input type="text" id="txtServidorSMTP" name="txtServidorSMTP" class="form-control" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->servidorSMTP);?>" >   
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3 text-right">
                                <label>Puerto SMTP: </label>
                            </div>
                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-9">
                                <input type="text" id="txtPuertoSMTP" name="txtPuertoSMTP" class="form-control" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->puertoSMTP);?>" > 
                            </div>
                        </div>
                    </div>
                </div>
                
            
            </center>
                
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <button  id="btnEnviar" name="btnEnviar" class="btn btn-success">
                            <img title="Guardar" alt="" src="/include/img/boton/save_14x14.png">
                            Guardar
                        </button>
                        <button  id="btnCancelar" name="btnCancelar" type="button" title="Salir" onclick="window_float_close();" class="btn btn-danger">
                            <img  alt="" src="/include/img/boton/cancel_14x14.png">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </form>	
       
    </div>
    <script type="text/javascript">
    
     var validar=function(){
        
        var nombre=$.trim($("#txtNombre").val());
        var ruta=$.trim($("#txtRuta").val());
        var stilo_fondo_tabs=$("#selStilo_fondo_tabs").val();
        var stilo_fondo_boton=$("#selStilo_fondo_boton").val();
        var stilo_fondo_cabecera=$("#seltStilo_fondo_cabecera").val();
        if(nombre==""){
            toastem.error("Debe registrar el nombre de la empresa.");
            $('.nav-tabs a[href="#tab1"]').tab('show');
            $("#txtNombre").focus();
            return false;
        }
        if(ruta==""){
            toastem.error("Debe registrar el url.");
            $("#txtURL").focus();
            $('.nav-tabs a[href="#tab1"]').tab('show');
            return false;
        }
        if(stilo_fondo_tabs==""){
            toastem.error("Debe seleccionar un estilo para los tabs.");
            $('.nav-tabs a[href="#tab1"]').tab('show');
            $("#selStilo_fondo_tabs").focus();
            return false;
        }
        if(stilo_fondo_boton==""){
            toastem.error("Debe seleccionar un estilo para los botones.");
            $('.nav-tabs a[href="#tab1"]').tab('show');
            $("#selStilo_fondo_boton").focus();
            return false;
        }
        if(stilo_fondo_cabecera==""){
            toastem.error("Debe seleccionar un estilo para las cabeceras.");
            $('.nav-tabs a[href="#tab1"]').tab('show');
            $("#selStilo_fondo_cabecera").focus();
            return false;
        }
        
        var nombre_corto=$.trim($("#txtAlias").val());
        var direccion=$.trim($("#txtDireccion").val());
        
        if(nombre_corto==""){
            toastem.error("Debe registrar un nombre corto de la empresa.");
            $('.nav-tabs a[href="#tab2"]').tab('show');
            $("#txtAlias").focus();
            return false;
        }
        
        if(direccion==""){
            toastem.error("Debe registrar una dirección de la empresa.");
            $('.nav-tabs a[href="#tab2"]').tab('show');
            $("#txtAlias").focus();
            return false;
        }
        var razon_social=$.trim($("#txtRazon_Social").val());
        var ruc=$.trim($("#txtRuc").val());
        var direccion_fiscal=$.trim($("#txtDireccion_Fiscal").val());
        if(razon_social==""){
            toastem.error("Debe registrar una razón social de la empresa.");
            $('.nav-tabs a[href="#tab3"]').tab('show');
            $("#txtRazon_Social").focus();
            return false;
        }
        if(ruc==""){
            toastem.error("Debe registrar el ruc de la empresa.");
            $('.nav-tabs a[href="#tab3"]').tab('show');
            $("#txtRuc").focus();
            return false;
        }
        if(ruc.length<=10){
            toastem.error("Ingrese un ruc válido.");
            $('.nav-tabs a[href="#tab3"]').tab('show');
            $("#txtRuc").focus();
            return false;
        }
        if(direccion_fiscal==""){
            toastem.error("Debe registrar la dirección fiscal de la empresa.");
            $('.nav-tabs a[href="#tab3"]').tab('show');
            $("#txtDireccion_Fiscal").focus();
            return false;
        }
        
     }
     function fileValidation() {
            var fileInput = document.getElementById('logo');
            var filePath = fileInput.value;
            var allowedExtensions = /(.jpg)$/i;
            if(!allowedExtensions.exec(filePath)){
                mensaje.error('Mensaje de error','Solo se aceptan imagenes .jpg');
                fileInput.value = '';
                return false;
            }else{
                //Image preview
                if (fileInput.files && fileInput.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagen_previa').attr("src",e.target.result);
                        //document.getElementById('imagePreview').innerHTML = '<img src="'+e.target.result+'" width="250" height="90" class="thumbnail"/>';
                    };
                    reader.readAsDataURL(fileInput.files[0]);
                }
            }

        }
        function fileValidationIcono() {
            var fileInput = document.getElementById('icono');
            var filePath = fileInput.value;
            var allowedExtensions = /(.ico)$/i;
            if(!allowedExtensions.exec(filePath)){
                mensaje.error('Mensaje de error','Solo se aceptan imagenes .ico.');
                fileInput.value = '';
                return false;
            }else{
                //Image preview
                if (fileInput.files && fileInput.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagen_previaicono').attr("src",e.target.result);
                        //document.getElementById('imagePreview').innerHTML = '<img src="'+e.target.result+'" width="250" height="90" class="thumbnail"/>';
                    };
                    reader.readAsDataURL(fileInput.files[0]);
                }
            }

        }
        function fileValidationImagen() {
            var fileInput = document.getElementById('imagen');
            var filePath = fileInput.value;
            var allowedExtensions = /(.jpg|.jpeg|.png|.gif)$/i;
            if(!allowedExtensions.exec(filePath)){
                mensaje.error('Mensaje de error','Solo se aceptan imagenes .ico.');
                fileInput.value = '';
                return false;
            }else{
                //Image preview
                if (fileInput.files && fileInput.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagen_previaiImagen').attr("src",e.target.result);
                        //document.getElementById('imagePreview').innerHTML = '<img src="'+e.target.result+'" width="250" height="90" class="thumbnail"/>';
                    };
                    reader.readAsDataURL(fileInput.files[0]);
                }
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
    </script>
    <?php } ?>  
    <?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==1){ ?>
    
    <script type="text/javascript">
       $(document).ready(function(){
           toastem.success("<?php  echo $GLOBALS['mensaje']; ?>");
           setTimeout('window_float_save();', 1000);
       });

    </script>
    <?php } ?>
    <?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==-1){ ?>
    
    <script type="text/javascript">
       $(document).ready(function(){
           toastem.error("<?php  echo $GLOBALS['mensaje']; ?>");
           
       });

    </script>
    <?php } ?>
   <?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==0){ ?>
        <div class="float-mensaje">
             <?php  echo $GLOBALS['mensaje']; ?>
        </div>
        <div class="group-btn">
            <input type="button" onclick ="redireccionar_parent('/');" value ="Iniciar Sesión"/>
        </div>
    <?php } ?>
        
<?php } ?>