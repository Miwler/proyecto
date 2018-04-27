<?php		
	require ROOT_PATH."views/shared/content.php";	
?>	
<?php function fncTitle(){?>
		Mantenimiento Datos Generales
<?php } ?>
<?php function fncHead(){?>
		<script type="text/javascript" src="include/js/jForm.js"></script>
		
<?php } ?>
<?php function fncMenu(){?>
<?php } ?>
<?php function fncTituloCabecera(){?>
        <i class="fa fa-list-alt" aria-hidden="true"></i> Datos de la empresa publicados en la web
<?php } ?>
<?php function fncPage(){?>
    <form id="frm1" method="post" action="/pagina_web/datos_empresa/<?php echo $_SESSION['empresa_ID'];?>" class="form-horizontal">
    <div class="panel panel-primary">
        
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span class="glyphicon glyphicon-briefcase"></span> 
                            Datos Generales
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <label >
                                    Quienes somos:
                                    </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    <textarea name="txtQuienes_Somos" style="height: 80px;width:100%;"><?php echo FormatTextViewHtml($GLOBALS['oDatos_Generales']->quienes_somos);?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <label >
                                    Misión:
                                    </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    <textarea name="txtMision" style="height: 80px;width:100%;"><?php echo FormatTextViewHtml($GLOBALS['oDatos_Generales']->mision);?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <label >
                                    Visión:
                                    </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    <textarea name="txtVision" style="height: 80px;width:100%;"><?php echo FormatTextViewHtml($GLOBALS['oDatos_Generales']->vision);?></textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span class="glyphicon glyphicon-user"></span> Datos Contacto
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <label>
                                    Persona contacto:
                                    </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    <input type="text" name="txtPersona_Contacto" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->persona_contacto);?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <label>
                                    Cargo:
                                    </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    <input type="text" name="txtCargo_Contacto" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->cargo_contacto);?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <label>
                                    Teléfono:
                                    </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    <input type="text" name="txtTelefono2" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->telefono2);?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <label>
                                    Teléfono:
                                    </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    <input type="text" name="txtTelefono3" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->telefono3);?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <label>
                                    Teléfono:
                                    </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    <input type="text" name="txtTelefono4" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->telefono4);?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <label>
                                    Skype:
                                    </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    <input type="text" name="txtSkype" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->skype);?>">
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>	
        </div>
        <div class="panel-footer">
            <button class="btn btn-primary">
                <img title="Guardar" alt="" src="/include/img/boton/save_14x14.png">
                Guardar
            </button>
        </div>
    </div>
                    
    </form>
    <?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==1){ ?>
        <script type="text/javascript">
            $(document).on('ready',function(){
                toastem.success("<?php echo $GLOBALS['mensaje'];?>");
            });
	</script>
                    
    <?php } ?>
	
	

<?php } ?>