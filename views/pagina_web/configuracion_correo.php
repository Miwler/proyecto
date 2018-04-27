<?php		
	require ROOT_PATH."views/shared/content.php";	
?>	
<?php function fncTitle(){?>
		Configuración de correo
<?php } ?>
<?php function fncHead(){?>
        <script type="text/javascript" src="include/js/jForm.js"></script>
		
<?php } ?>
<?php function fncMenu(){?>
<?php } ?>
<?php function fncTituloCabecera(){?>
        <i class="fa fa-envelope" aria-hidden="true"></i> Configuración del envío de correos
<?php } ?>
<?php function fncPage(){?>
    <form id="frm1" method="post" action="/pagina_web/configuracion_correo/<?php echo $_SESSION['empresa_ID'];?>" class="form-horizontal">
    <div class="panel panel-primary">
        
        <div class="panel-body">
            <div class="form-group">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <label >
                Cuenta:
                </label>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <input type="text" name="txtMail_Webmaster" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->mail_webmaster);?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label >
                    Password:
                    </label>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <input type="password" name="txtPassword_Webmaster" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->password_webmaster);?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label >
                    Servidor SMTP:
                    </label>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <input type="text" name="txtServidorSMTP" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->servidorSMTP);?>">
                    
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label >
                    Puerto SMTP:
                    </label>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <input type="text" name="txtPuertoSMTP" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->puertoSMTP);?>">
                </div>
            </div>
            
        </div>
        <div class="panel-footer">
            <button class="btn btn-success">
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