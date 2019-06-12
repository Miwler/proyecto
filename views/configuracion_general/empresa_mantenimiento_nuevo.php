<?php		
	require ROOT_PATH."views/shared/content-view.php";	
?>	
<?php function fncTitle(){?>
		Nuevo Empresa
<?php } ?>
<?php function fncHead(){?>
    <script type="text/javascript" src="include/js/jForm.js"></script>
 
<?php } ?>
                
<?php
    function fncTitleHead() { ?>
    <i class="fa fa-industry"></i>Nueva Empresa
   
<?php } ?>                
                
<?php function fncMenu(){?>
<?php } ?>
<?php function fncPage(){?>
    <?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1){ ?> 
    <form id="frm1"  method="post" enctype="multipart/form-data" action="/Configuracion_General/Empresa_Mantenimiento_Nuevo" onsubmit="return validar();" class="tab-content form-horizontal form-bordered">
        <div class="panel panel-tab rounded shadow">
        <div class="panel-heading no-padding">
            <ul class="nav nav-tabs nav-pills">
                <li class="active">
                    <a href="#tab1-1" data-toggle="tab">
                        <i class="fa fa-file-text-o"></i>
                        <div>
                            <span class="text-strong">Paso 1</span>
                            <span>Datos generales</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#tab1-2" data-toggle="tab">
                        <i class="fa fa-cogs"></i>
                        <div>
                            <span class="text-strong">Paso 2</span>
                            <span>Configuración</span>
                        </div>
                    </a>
                </li>
                
            </ul>
            <div class="pull-right">
                <button  id="btnEnviar" name="btnEnviar" class="btn btn-success">
                    <img title="Guardar" alt="" src="/include/img/boton/save_14x14.png">
                    Guardar
                </button>
                <button  id="btnCancelar" name="btnCancelar" type="button" title="Salir" onclick="parent.window_close_view();" class="btn btn-danger">
                    <img  alt="" src="/include/img/boton/cancel_14x14.png">
                    Cancelar
                </button>
            </div>
        </div>
        <div class="panel-body">
            <div class="tab-content form-horizontal form-bordered">
            
                <input type="hidden" id="lista_modulos" name="lista_modulos">
                <input type="hidden" id="lista_reportes" name="lista_reportes">
                
                <div class="tab-pane fade in active inner-all" id="tab1-1">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group form-group-divider">
                                <div class="form-inner">
                                    <h4 class="no-margin">Información</h4>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Nombre:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                      <input type="text" id="txtNombre" name="txtNombre" autocomplete="off" class="form-control form-requerido" value="<?php echo $GLOBALS['oEmpresa']->nombre;?>" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Nombre corto:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" id="txtAlias" name="txtAlias" autocomplete="off" value="<?php echo $GLOBALS['oDatos_Generales']->alias;?>" class="form-control form-requerido">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Departamento:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <select id="selDepartamento" name="selDepartamento" class="form-control" onchange="fncDepartamento();">
                                        <?php foreach($GLOBALS['dtDepartamento'] as $departamento){ ?>
                                        <option value="<?php echo $departamento['ID']?>"><?php echo FormatTextView($departamento['nombre'])?></option>
                                        <?php } ?>
                                    </select>
                                    <script type="text/javascript">
                                        $('#selDepartamento').val('<?php echo $GLOBALS['oDatos_Generales']->departamento_ID?>');
                                    </script>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Provincia:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
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
                            <div class="form-group">
                                <label class="control-label col-sm-4">Distrito:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
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
                            <div class="form-group">
                                <label class="control-label col-sm-4">Dirección:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                      <input type="text" id="txtDireccion" name="txtDireccion" autocomplete="off" value="<?php echo $GLOBALS['oDatos_Generales']->direccion;?>" class="form-control form-requerido">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Observación:</label>
                                <div class="col-sm-8">
                                    <textarea id="txtObservacion" name="txtObservacion" class="form-control" style="height: 40px;overflow:auto;resize: none;"><?php echo FormatTextView($GLOBALS['oDatos_Generales']->observacion);?></textarea>
                                </div>
                            </div>
                           
                            <div class="form-group form-group-divider">
                                <div class="form-inner">
                                    <h4 class="no-margin">Información para SUNAT</h4>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Razon social:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                      <input type="text" id="txtRazon_Social" autocomplete="off" name="txtRazon_Social" autocomplete="off"  value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->razon_social);?>" class="form-control form-requerido">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-sm-4">R.U.C.:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                       <input type="text" id="txtRuc" name="txtRuc" autocomplete="off" maxlength="11" autocomplete="off" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->ruc);?>" class="form-control form-requerido int">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Dirección fiscal:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                     <input type="text" id="txtDireccion_Fiscal" autocomplete="off" name="txtDireccion_Fiscal" value="<?php echo $GLOBALS['oDatos_Generales']->direccion_fiscal;?>" class="form-control form-requerido">
                                </div>
                            </div>
                            <div class="form-group form-group-divider">
                                <div class="form-inner">
                                    <h4 class="no-margin">Moneda</h4>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Tipo de cambio:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                     <input type="text" id="txtTipo_Cambio" name="txtTipo_Cambio" autocomplete="off" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->tipo_cambio);?>" class="form-control decimal">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">I.G.V:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                     <input type="text" id="txtVigv" name="txtVigv" autocomplete="off" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->vigv);?>" class="form-control decimal">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group form-group-divider">
                                <div class="form-inner">
                                    <h4 class="no-margin">Información Institucional</h4>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Sitio web:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" id="txtSitio_Web" name="txtSitio_Web" autocomplete="off" class="form-control" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->sitio_web);?>">
                                    <small class="form-text text-muted">Link del sistema.</small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Página web:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                   <input type="text" id="txtPagina_Web" name="txtPagina_Web" autocomplete="off" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->pagina_web);?>" class="form-control">
                                   <small class="form-text text-muted">Link de la página web de la empresa.</small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Quienes somos:</label>
                                <div class="col-sm-8">
                                    <textarea id="txtQuienes_Somos" name="txtQuienes_Somos"  class="form-control" style="height: 100px;overflow:auto;resize:none"><?php echo FormatTextView($GLOBALS['oDatos_Generales']->quienes_somos);?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Misión:</label>
                                <div class="col-sm-8">
                                    <textarea id="txtMision" name="txtMision" class="form-control" style="height: 100px;overflow:auto;resize:none"><?php echo FormatTextView($GLOBALS['oDatos_Generales']->mision);?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Visión:</label>
                                <div class="col-sm-8">
                                    <textarea id="txtVision" name="txtVision" class="form-control" style="height: 100px;overflow:auto;resize:none"><?php echo FormatTextView($GLOBALS['oDatos_Generales']->vision);?></textarea>
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                    
                </div>
                <div class="tab-pane fade inner-all" id="tab1-2">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group form-group-divider">
                                <div class="form-inner">
                                    <h4 class="no-margin">Información</h4>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Logo principal para el sitio:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <img id="imagen_previaiImagen" src="<?php echo ruta_archivo;?>/imagenes/imagen/<?php echo $GLOBALS['oDatos_Generales']->imagen;?>" style="height: 80px">
                                <input type="file" name="imagen" id="imagen" onchange="fileValidationImagen();">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Favicon:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <img id="imagen_previaicono" src="<?php echo ruta_archivo;?>/imagenes/favicon/<?php echo $GLOBALS['oDatos_Generales']->favicon;?>" style="height: 40px">
                                <input type="file" name="icono" id="icono" onchange="fileValidationIcono();">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-sm-4">Logo para los documentos:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <img id="imagen_previa" src="<?php echo ruta_archivo;?>/imagenes/logo/<?php echo $GLOBALS['oDatos_Generales']->logo_extension;?>" style="height: 80px">
                                <input type="file" name="logo" id="logo" onchange="fileValidation();">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Class ícono:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="txtClassIcono" name="txtClassIcono" autocomplete="off">
                                    <small class="form-text text-muted">Clase de la etiqueta i.<code><i class="dede"></i> </code></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Estilos tabs:</label>
                                <div class="col-sm-8">
                                    <input type="text" id="selStilo_fondo_tabs" name="selStilo_fondo_tabs" class="form-control" disabled value="<?php echo $GLOBALS['oEmpresa']->stilo_fondo_tabs;?>">
                                    <div id="paleta" class="sidebar-themes navbar-color">
                                        <a class="bg-dark border" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Dark"><span class="hide">dark</span></a>
                                        <a class="bg-primary" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Primary"><span class="hide">primary</span></a>
                                        <a class="bg-success" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Success"><span class="hide">success</span></a>
                                        <a class="bg-info" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Info"><span class="hide">info</span></a>
                                        <a class="bg-warning" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Warning"><span class="hide">warning</span></a>
                                        <a class="bg-danger" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Danger"><span class="hide">danger</span></a>
                                        <a class="bg-facebook" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Danger"><span class="hide">danger</span></a>
                                        <a class="bg-googleplus" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Danger"><span class="hide">danger</span></a>
                                        <a class="bg-bitbucket" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Danger"><span class="hide">danger</span></a>
                                        <a class="bg-youtube" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Danger"><span class="hide">danger</span></a>
                                        <a class="bg-dribbble" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Danger"><span class="hide">danger</span></a>
                                        <a class="bg-soundcloud" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Danger"><span class="hide">danger</span></a>

                                    </div>
                                </div>
                                
                                <script>
                                    $("#paleta a").click(function(){
                                        var estilo=$(this).attr("class")
                                        $("#selStilo_fondo_tabs").val(estilo);
                                    });
                                </script>
                              
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Estilo fondo de botones:</label>
                                <div class="col-sm-8">
                                    <input type="text" id="selStilo_fondo_boton" name="selStilo_fondo_boton" class="form-control" disabled value="<?php echo $GLOBALS['oEmpresa']->stilo_fondo_boton;?>">
                                    <div id="paleta1" class="sidebar-themes navbar-color">
                                        <a class="bg-dark border" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Dark"><span class="hide">dark</span></a>
                                        <a class="bg-primary" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Primary"><span class="hide">primary</span></a>
                                        <a class="bg-success" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Success"><span class="hide">success</span></a>
                                        <a class="bg-info" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Info"><span class="hide">info</span></a>
                                        <a class="bg-warning" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Warning"><span class="hide">warning</span></a>
                                        <a class="bg-danger" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Danger"><span class="hide">danger</span></a>
                                        <a class="bg-facebook" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Danger"><span class="hide">danger</span></a>
                                        <a class="bg-googleplus" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Danger"><span class="hide">danger</span></a>
                                        <a class="bg-bitbucket" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Danger"><span class="hide">danger</span></a>
                                        <a class="bg-youtube" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Danger"><span class="hide">danger</span></a>
                                        <a class="bg-dribbble" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Danger"><span class="hide">danger</span></a>
                                        <a class="bg-soundcloud" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Danger"><span class="hide">danger</span></a>

                                    </div>
                                </div>
                                <script>
                                    $("#paleta1 a").click(function(){
                                        var estilo=$(this).attr("class")
                                        $("#selStilo_fondo_boton").val(estilo);
                                    });
                                </script>
                                
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-sm-4">Estilo fondo cabecera:</label>
                                <div class="col-sm-8">
                                    <input type="text" id="selStilo_fondo_cabecera"  name="selStilo_fondo_cabecera" disabled class="form-control" value="<?php echo $GLOBALS['oEmpresa']->stilo_fondo_cabecera;?>">
                                    <div id="paleta2" class="sidebar-themes navbar-color">
                                        <a class="bg-dark border" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Dark"><span class="hide">dark</span></a>
                                        <a class="bg-primary" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Primary"><span class="hide">primary</span></a>
                                        <a class="bg-success" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Success"><span class="hide">success</span></a>
                                        <a class="bg-info" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Info"><span class="hide">info</span></a>
                                        <a class="bg-warning" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Warning"><span class="hide">warning</span></a>
                                        <a class="bg-danger" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Danger"><span class="hide">danger</span></a>
                                        <a class="bg-facebook" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Danger"><span class="hide">danger</span></a>
                                        <a class="bg-googleplus" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Danger"><span class="hide">danger</span></a>
                                        <a class="bg-bitbucket" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Danger"><span class="hide">danger</span></a>
                                        <a class="bg-youtube" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Danger"><span class="hide">danger</span></a>
                                        <a class="bg-dribbble" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Danger"><span class="hide">danger</span></a>
                                        <a class="bg-soundcloud" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Danger"><span class="hide">danger</span></a>

                                    </div>
                                </div>
                                <script>
                                    $("#paleta2 a").click(function(){
                                        var estilo=$(this).attr("class")
                                        $("#selStilo_fondo_cabecera").val(estilo);
                                    });
                                </script>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Color de Documentos PDF:</label>
                                <div class="col-sm-8">
                                    
                                    <input name="color_documentos" type="color" id="colcolor_documentosor" value="<?php echo$GLOBALS['oEmpresa']->color_documentos;?>" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group form-group-divider">
                                <div class="form-inner">
                                    <h4 class="no-margin">Configuración de envío de correo</h4>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Cuenta de correo:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" id="txtMail_Webmaster" name="txtMail_Webmaster" autocomplete="off" class="form-control" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->mail_webmaster);?>">
                                
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Contraseña:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" id="txtPassword_Webmaster" name="txtPassword_Webmaster" autocomplete="off" class="form-control" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->password_webmaster);?>" >   
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Servidor SMTP:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" id="txtServidorSMTP" name="txtServidorSMTP" autocomplete="off" class="form-control" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->servidorSMTP);?>" >   
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Puerto SMTP:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" id="txtPuertoSMTP" name="txtPuertoSMTP" autocomplete="off" class="form-control" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->puertoSMTP);?>" > 
                                </div>
                            </div>
                            <div class="form-group form-group-divider">
                                <div class="form-inner">
                                    <h4 class="no-margin">Módulos</h4>
                                </div>
                            </div>
                            <div class="form-group">
                                
                                <div class="col-sm-12">
                                    <ul class="list-group" id="divModulos">
                                        <?php foreach($GLOBALS['dtModulo'] as $modulo){?>
                                        <li class="list-group-item">
                                            <div class="ckbox ckbox-teal">
                                                <input id="<?php echo $modulo['ID']?>" type="checkbox">
                                                <label for="<?php echo $modulo['ID']?>"><?php echo $modulo['nombre']?></label>
                                            </div>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group form-group-divider">
                                <div class="form-inner">
                                    <h4 class="no-margin">Configuración general</h4>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Moneda por defecto:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <select id="SelMoneda" name="SelMoneda" class="form-control">
                                        <option id="0">Seleccione</option>
                                        <?php foreach($GLOBALS['dtMoneda'] as $moneda){?>
                                        <option value="<?php echo $moneda['ID']?>"><?php echo ($moneda['descripcion'])?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Periodo inicio:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <input type="number" id="txtPeriodo" name="txtPeriodo" autocomplete="off" min="1000" class="form-control" autocomplete="off" value="<?php echo $GLOBALS['oDatos_Generales']->periodo_defecto;?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Estado de compra por defecto:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <select id="SelEstadoCompra" name="SelEstadoCompra" class="form-control">
                                        <option id="0">Seleccione</option>
                                        <?php foreach($GLOBALS['dtEstadoCompra'] as $moneda){?>
                                        <option value="<?php echo $moneda['ID']?>"><?php echo ($moneda['nombre'])?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            
                            
                            <div class="form-group">
                                <label class="control-label col-sm-4">Comprobante por defecto compra:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <select id="SelComprobanteCompra" name="SelComprobanteCompra" class="form-control">
                                        <option id="0">Seleccione</option>
                                        <?php foreach($GLOBALS['dtTipo_Comprobante_Compra'] as $moneda){?>
                                        <option value="<?php echo $moneda['ID']?>"><?php echo ($moneda['nombre'])?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Link de consulta para el comprobante electronico:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" id="txtLink_Comprobante_Electronico" name="txtLink_Comprobante_Electronico" autocomplete="off" class="form-control" autocomplete="off" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Departamento por defecto:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <select id="selDepartamento1" name="selDepartamento1" class="form-control" onchange="fncDepartamento1();">
                                        <option id="0">Seleccione</option>
                                        <?php foreach($GLOBALS['dtDepartamento'] as $departamento){?>
                                        <option value="<?php echo $departamento['ID']?>"><?php echo ($departamento['nombre'])?></option>
                                        <?php } ?>
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Provincia por defecto:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <select id="selProvincia1" name="selProvincia1" class="form-control" onchange="fncProvincia1();">
                                        <option id="0">Seleccione</option>
                                        
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Distrito por defecto:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <select id="selDistrito1" name="selDistrito1" class="form-control" >
                                        <option id="0">Seleccione</option>
                                       
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Etiqueta de los correo:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" id="txtOpcionesCorreo" name="txtOpcionesCorreo" autocomplete="off"  class="form-control" autocomplete="off" value="<?php echo $GLOBALS['oDatos_Generales']->etiquetas_correo;?>" >
                                    <small class="form-text text-muted">Cada etiqueta de correo lo separamos con "|".</small>    
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-sm-4">Etiquetas para celulares:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" id="txtOpcionesCelular" name="txtOpcionesCelular"  autocomplete="off" class="form-control" autocomplete="off" value="<?php echo $GLOBALS['oDatos_Generales']->etiquetas_celulares;?>"  >
                                    <small class="form-text text-muted">Cada etiqueta de celular lo separamos con "|".</small>    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Precion incluyen IGV:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <select id="selIncluyeIgv" name="selIncluyeIgv" class="form-control">
                                        <option value="1">SI</option>
                                        <option value="0">NO</option>
                                    </select>
                                    <small class="form-text text-muted">Valor por defecto si incluye IGV</small>    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Web servis Beta para Guías SUNAT:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" id="txtWebServisGuiaBeta" name="txtWebServisGuiaBeta" autocomplete="off" class="form-control" autocomplete="off" value="<?php echo $GLOBALS['oDatos_Generales']->beta_ws_guia;?>" >
                                    <small class="form-text text-muted">webservis beta para el envío de guías electrónica.</small>    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Web servis Beta para Factura SUNAT:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" id="txtWebServisFacturaBeta" name="txtWebServisFacturaBeta" autocomplete="off"  class="form-control" autocomplete="off" value="<?php echo $GLOBALS['oDatos_Generales']->beta_ws_factura;?>">
                                    <small class="form-text text-muted">webservis beta para el envío de factura electrónica.</small>    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Web servis Produccion para Guías SUNAT:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" id="txtWebServisGuiaProd" name="txtWebServisGuiaProd" autocomplete="off"  class="form-control" autocomplete="off" value="<?php echo $GLOBALS['oDatos_Generales']->prod_ws_guia;?>">
                                    <small class="form-text text-muted">webservis producción para el envío de Guías electrónica.</small>    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Web servis Produccion para factura SUNAT:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" id="txtWebServisFacturaProd" name="txtWebServisFacturaProd" autocomplete="off" class="form-control" autocomplete="off" value="<?php echo $GLOBALS['oDatos_Generales']->prod_ws_factura;?>">
                                    <small class="form-text text-muted">webservis producción para el envío de facturas electrónica.</small>    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Largo decimal precios unitarios:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <select id="selBd_Largo_Decimal" name="selBd_Largo_Decimal" class="form-control">
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                    <script>
                                        $("#selBd_Largo_Decimal").val("<?php echo $GLOBALS['oEmpresa']->bd_largo_decimal;?>");
                                    </script>
                                    <small class="form-text text-muted">Registre el largo de decimal de los precios y costos unitarios de las ventas.</small>    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Fecha inicio para reportes:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" id="txtFecha_Inicio_Reporte" name="txtFecha_Inicio_Reporte" class="form-control date-range-picker-single" value="<?php echo $GLOBALS['oEmpresa']->fecha_view;?>">
                                    
                                    <small class="form-text text-muted">Registre la fecha para inicio de los reportes.</small>    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Seleccion de webservis SUNAT:<span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <select id="SelWebServis" name="SelWebServis" class="form-control">
                                       
                                        <option value="beta">Beta</option>
                                        <option value="produccion">Producción</option>
                                    </select>
                                    <small class="form-text text-muted">Seleccionamos beta para realizar pruebas de envío o producción cuando ya este revisado.</small>    
                                </div>
                            </div>
                            
                            <div class="form-group form-group-divider">
                                <div class="form-inner">
                                    <h4 class="no-margin">Asignar Reportes</h4>
                                </div>
                            </div>
                            <div class="form-group">
                                
                                <div class="col-sm-12" id="divReportes">
                                    <?php echo $GLOBALS['lista_reportes'];?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>
    </form>
    
   
    <script type="text/javascript">
    
     var validar=function(){
        
        var nombre=$.trim($("#txtNombre").val());
        var nombre_corto=$.trim($("#txtAlias").val());
        var departamento_ID=$("#selDepartamento").val();
        var provincia_ID=$("#selProvincia").val();
        var distrito_ID=$("#selDistrito").val();
        
        var direccion=$.trim($("#txtDireccion").val());
        
        
        var razon_social=$.trim($("#txtRazon_Social").val());
        var ruc=$.trim($("#txtRuc").val());
        var direccion_fiscal=$.trim($("#txtDireccion_Fiscal").val());
        
        var tipo_cambio=$.trim($("#txtTipo_Cambio").val());
        var igv=$.trim($("#txtVigv").val());
        var sitio_web=$.trim($("#txtSitio_Web").val());
        var pagina_web=$.trim($("#txtPagina_Web").val());
        var clase_icono=$.trim($("#txtClassIcono").val());
        var stilo_fondo_tabs=$("#selStilo_fondo_tabs").val();
        var stilo_fondo_boton=$("#selStilo_fondo_boton").val();
        var stilo_fondo_cabecera=$("#seltStilo_fondo_cabecera").val();
        
        var cuenta_correo=$.trim($("#txtMail_Webmaster").val());
       
        var contrasena=$.trim($("#txtPassword_Webmaster").val());
        var servior_smtp=$.trim($("#txtServidorSMTP").val());
        var puerto_smtp=$.trim($("#txtPuertoSMTP").val());
        var moneda=$("#SelMoneda").val();
        var periodo=$("#txtPeriodo").val();
        var estado_compra=$("#SelEstadoCompra").val();
        var comprobante_compra_defecto=$("#SelComprobanteCompra").val();
        var link_facturacion_electronica=$.trim($("#txtLink_Comprobante_Electronico").val());
        var departamento_ID_defecto=$("#selDepartamento1").val();
        var provincia_ID_defecto=$("#selProvincia1").val();
        var distrito_ID_defecto=$("#selDistrito1").val();
        var etiqueta_correo=$.trim($("#txtOpcionesCorreo").val());
        var etiqueta_celular=$.trim($("#txtOpcionesCelular").val());
        var wb_guia_beta=$.trim($("#txtWebServisGuiaBeta").val());
        var wb_factura_beta=$.trim($("#txtWebServisFacturaBeta").val());
        var wb_guia_pro=$.trim($("#txtWebServisGuiaProd").val());
        var wb_factura_prod=$.trim($("#txtWebServisFacturaProd").val());
        
        if(nombre==""){
            mensaje.error("Validacion de datos","Debe registrar el nombre de la empresa.","txtNombre");
            $('.nav-tabs a[href="#tab1-1"]').tab('show');
            
            return false;
        }
        if(nombre_corto==""){
            mensaje.error("Validacion de datos","Debe registrar un nombre corto.","txtAlias");
            $('.nav-tabs a[href="#tab1-1"]').tab('show');
            
            return false;
        }
        if(departamento_ID=="0"){
            mensaje.error("Validacion de datos","Debe registrar una dirección.","selDepartamento");
            $('.nav-tabs a[href="#tab1-1"]').tab('show');
           
            return false;
        }
        if(provincia_ID=="0"){
            mensaje.error("Validacion de datos","Debe registrar una provincia.","selProvincia");
            $('.nav-tabs a[href="#tab1-1"]').tab('show');
           
            return false;
        }
        if(distrito_ID=="0"){
            mensaje.error("Validacion de datos","Debe registrar un distrito.","selDistrito");
            $('.nav-tabs a[href="#tab1-1"]').tab('show');
            
            return false;
        }
        if(direccion==""){
            mensaje.error("Validacion de datos","Debe registrar una dirección de la empresa.","txtDireccion");
            $('.nav-tabs a[href="#tab1-1"]').tab('show');
           
            return false;
        }
        if(razon_social==""){
            mensaje.error("Validacion de datos","Debe registrar una razón social de la empresa.","txtRazon_Social");
            $('.nav-tabs a[href="#tab1-1"]').tab('show');
           
            return false;
        }
        if(ruc==""){
            mensaje.error("Validacion de datos","Debe registrar el ruc de la empresa.","txtRuc");
            $('.nav-tabs a[href="#tab1-1"]').tab('show');
           
            return false;
        }
        if(ruc.length<=10){
            mensaje.error("Validacion de datos","Ingrese un ruc válido.","txtRuc");
            $('.nav-tabs a[href="#tab1-1"]').tab('show');
           
            return false;
        }
        if(direccion_fiscal==""){
            mensaje.error("Validacion de datos","Debe registrar la dirección fiscal de la empresa.","txtDireccion_Fiscal");
            $('.nav-tabs a[href="#tab1-1"]').tab('show');
            
            return false;
        }
        if(tipo_cambio==""){
            mensaje.error("Validacion de datos","Debe registrar un tipo de cambio.","txtTipo_Cambio");
            $('.nav-tabs a[href="#tab1-1"]').tab('show');
            
            return false;
        }
        if(igv==""){
            mensaje.error("Validacion de datos","Debe registrar el igv.","txtVigv");
            $('.nav-tabs a[href="#tab1-1"]').tab('show');
            
            return false;
        }
        if(sitio_web==""){
            mensaje.error("Validacion de datos","Debe registrar un sitio web.","txtSitio_Web");
            $('.nav-tabs a[href="#tab1-1"]').tab('show');
           
            return false;
        }
        if(pagina_web==""){
            mensaje.error("Validacion de datos","Debe registrar la página web.","txtPagina_Web");
            $('.nav-tabs a[href="#tab1-1"]').tab('show');
            
            return false;
        }
        if(clase_icono==""){
            mensaje.error("Validacion de datos","Debe registrar la clase del icono.","txtClassIcono");
            $('.nav-tabs a[href="#tab1-1"]').tab('show');
            
            return false;
        }
        if(stilo_fondo_tabs==""){
            mensaje.error("Validacion de datos","Debe seleccionar un estilo para los tabs.","selStilo_fondo_tabs");
            $('.nav-tabs a[href="#tab1-2"]').tab('show');
            
            return false;
        }
        if(stilo_fondo_boton==""){
            mensaje.error("Validacion de datos","Debe seleccionar un estilo para los botones.","selStilo_fondo_boton");
            $('.nav-tabs a[href="#tab1-2"]').tab('show');
           
            return false;
        }
        if(stilo_fondo_cabecera==""){
            mensaje.error("Validacion de datos","Debe seleccionar un estilo para las cabeceras.","selStilo_fondo_cabecera");
            $('.nav-tabs a[href="#tab1-2"]').tab('show');
            
            return false;
        }
        
        if(cuenta_correo==""){
            mensaje.error("Validacion de datos","Debe registrar una cuenta de correo para el envío de correo.","txtMail_Webmaster");
            $('.nav-tabs a[href="#tab1-2"]').tab('show');
            
            return false;
        }
        if(contrasena==""){
            mensaje.error("Validacion de datos","Debe registrar la contraseña del correo para el envío de correo.","txtPassword_Webmaster");
            $('.nav-tabs a[href="#tab1-2"]').tab('show');
            
            return false;
        }
       if(servior_smtp==""){
            mensaje.error("Validacion de datos","Debe registrar el servidor SMTP del correo para el envío de correo.","txtServidorSMTP");
            $('.nav-tabs a[href="#tab1-2"]').tab('show');
            
            return false;
        }
        if(puerto_smtp==""){
            mensaje.error("Validacion de datos","Debe registrar el puerto SMTP del correo para el envío de correo.","txtPuertoSMTP");
            $('.nav-tabs a[href="#tab1-2"]').tab('show');
            
            return false;
        }
        if(moneda=="0"){
            mensaje.error("Validacion de datos","Debe registrar una moneda por defecto.","SelMoneda");
            $('.nav-tabs a[href="#tab1-2"]').tab('show');
            
            return false;
        }
        if(periodo==""){
            mensaje.error("Validacion de datos","Debe registrar el periodo de inicio.","txtPeriodo");
            $('.nav-tabs a[href="#tab1-2"]').tab('show');
            
            return false;
        }
        if(estado_compra=="0"){
            mensaje.error("Validacion de datos","Debe seleccionar un estado de compra por defecto.","SelEstadoCompra");
            $('.nav-tabs a[href="#tab1-2"]').tab('show');
            
            return false;
        }
        if(comprobante_compra_defecto=="0"){
            mensaje.error("Validacion de datos","Debe seleccionar un comprobante de compra por defecto.","SelComprobanteCompra");
            $('.nav-tabs a[href="#tab1-2"]').tab('show');
            
            return false;
        }
        if(link_facturacion_electronica==""){
            mensaje.error("Validacion de datos","Debe un link para las consultas de la facturación electrónica.","txtLink_Comprobante_Electronico");
            $('.nav-tabs a[href="#tab1-2"]').tab('show');
            
            return false;
        }
        if(departamento_ID_defecto=="0"){
            mensaje.error("Validacion de datos","Debe un seleccionar un departamento por defecto.","selDepartamento1");
            $('.nav-tabs a[href="#tab1-2"]').tab('show');
            
            return false;
        }
        if(provincia_ID_defecto=="0"){
            mensaje.error("Validacion de datos","Debe un seleccionar una provincia por defecto.","selProvincia1");
            $('.nav-tabs a[href="#tab1-2"]').tab('show');
            
            return false;
        }
        if(distrito_ID_defecto=="0"){
            mensaje.error("Validacion de datos","Debe un seleccionar un distrito por defecto.","selProvincia1");
            $('.nav-tabs a[href="#tab1-2"]').tab('show');
            
            return false;
        }
        if(etiqueta_correo==""){
            mensaje.error("Validacion de datos","Debe un registrar las etiquetas de los correos.","txtOpcionesCorreo");
            $('.nav-tabs a[href="#tab1-2"]').tab('show');
            
            return false;
        }
        if(etiqueta_celular==""){
            mensaje.error("Validacion de datos","Debe un registrar las etiquetas de los celulares.","txtOpcionesCelular");
            $('.nav-tabs a[href="#tab1-2"]').tab('show');
            
            return false;
        }
        if(wb_guia_beta==""){
            mensaje.error("Validacion de datos","Debe un registrar la web servis de la guia beta.","txtWebServisGuiaBeta");
            $('.nav-tabs a[href="#tab1-2"]').tab('show');
            
            return false;
        }
        
        if(wb_factura_beta==""){
            mensaje.error("Validacion de datos","Debe un registrar la web servis de la factura beta.","txtWebServisFacturaBeta");
            $('.nav-tabs a[href="#tab1-2"]').tab('show');
            
            return false;
        }
        if(wb_guia_pro==""){
            mensaje.error("Validacion de datos","Debe un registrar la web servis de la guia producción.","txtWebServisGuiaProd");
            $('.nav-tabs a[href="#tab1-2"]').tab('show');
            
            return false;
        }
        if(wb_factura_prod==""){
            mensaje.error("Validacion de datos","Debe un registrar la web servis de la factura producción.","txtWebServisFacturaProd");
            $('.nav-tabs a[href="#tab1-2"]').tab('show');
            
            return false;
        }
        var lista_modulos="";
        var i=0;
        $("#divModulos :input:checkbox:checked").each(function(){
            if(i==0){
                lista_modulos=this.id;
            }else{
                lista_modulos=lista_modulos+','+this.id;
            }
            i++;
        });
        if(lista_modulos==""){
            mensaje.error("Validación de datos","Debe seleccionar un módulo.");
            $('.nav-tabs a[href="#tab1-2"]').tab('show');
            return false;
        }
        
        var lista_reportes="";
        var y=0;
        $("#divReportes :input:checkbox:checked").each(function(){
            if(y==0){
                lista_reportes=$(this).attr("name");
            }else{
                lista_reportes=lista_reportes+','+$(this).attr("name");
            }
            y++;
        });
        
        $("#lista_reportes").val(lista_reportes);
        
        $("#lista_modulos").val(lista_modulos);
        $("#selStilo_fondo_tabs").prop("disabled",false);
        $("#selStilo_fondo_boton").prop("disabled",false);
        $("#selStilo_fondo_cabecera").prop("disabled",false);
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
        var fncDepartamento1=function(){
            var obj = $('#selDepartamento1');
            ajaxSelect('selProvincia1', '/Mantenimiento/ajaxSelect_Provincia/' + obj.val(), '',fncProvincia1);
        }
        var fncProvincia=function(){
            var obj = $('#selProvincia');
            ajaxSelect('selDistrito', '/Mantenimiento/ajaxSelect_Distrito/' + obj.val(), '',null);
        }
        var fncProvincia1=function(){
            var obj = $('#selProvincia1');
            ajaxSelect('selDistrito1', '/Mantenimiento/ajaxSelect_Distrito/' + obj.val(), '',null);
        }
    </script>
    <?php } ?>  
    <?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==1){ ?>
    
    <script type="text/javascript">
       $(document).ready(function(){
           toastem.success("<?php  echo $GLOBALS['mensaje']; ?>");
           setTimeout('parent.window_save_view();', 1000);
       });

    </script>
    <?php } ?>
    <?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==-1){ ?>
    
    <script type="text/javascript">
       $(document).ready(function(){
           mensaje.error("Ocurrió un error","<?php  echo $GLOBALS['mensaje']; ?>");
           
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