<html>
<head>
	<title>
		ERP
	</title>
	<base href="<?php echo DOMAIN_BASE."/"; ?>" />
	<meta http-equiv="Content-type" content="text/html charset=utf-8">
        <script src="../../include/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <link href="../../include/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        
	<script type="text/javascript" src="include/js/jquery-2.1.0.min.js"></script>
	<script type="text/javascript" src="include/js/jscript.js"></script>
	<script type="text/javascript" src="include/js/login.js"></script>
	<link rel="stylesheet" type="text/css" href="include/css/estilos.css" />
	<link rel="stylesheet" type="text/css" href="include/css/login.css" />

</head>
<body>
	<div id="lg-container">
		<form id="login" action="" method="post"  onsubmit="return login();">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            
                            <h3><span class="glyphicon glyphicon-user"></span> LOGIN</h3>
                            
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <input id="txtUsuario" name="txtUsuario" class="form-control lg-text" type="text" autocomplete="off" requeried="requeried" placeholder="Usuario" />
                                </div>
                            </div>
                            <div class="row">
                                
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <input id="txtContrasena" name="txtContrasena" class="form-control lg-text" type="password"  requeried="requeried" placeholder="Contraseña" />
                                </div>
                            </div>
                            <?php if($config['login']['captcha-enable']){ ?>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <img class="img-thumbnail" id="imgCaptcha" src='lib/captcha.php' />	
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <input id="captcha" name="captcha" class="form-control lg-text" type="text" autocomplete="off"  placeholder="Captcha" maxlength=5 />
                                </div>
                            </div>
                            <?php }?>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                                    <label id="lg-message" class="p-3 mb-2 bg-danger text-white"></label>
                                            				
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                    
                                    <img id="imgLoading" src="include/img/loader-login.gif" width=100 heigth=100  style="display:none"/>
                                    <button type="button" class="btn btn-primary btn-large" onclick="login();" >Iniciar sessión</button>
                                    <!--<input  id="btnEnviar" name="btnEnviar" type="button" onclick="login();" />	-->					
                                </div>
                                
                            </div>
                        </div>
                    </div>
                 
		</form>	
	</div>
	<script type='text/javascript'>
		$('#txtUsuario').focus();
	</script>
</body>
</html>