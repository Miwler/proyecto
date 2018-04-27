<html>
<head>
	<title>
		SIEM
	</title>
	<base href="<?php echo DOMAIN_BASE."/"; ?>" />
	<meta http-equiv="Content-type" content="text/html charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
           <!-- START @FONT STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700" rel="stylesheet">
        <!--/ END FONT STYLES -->

        <!-- START @GLOBAL MANDATORY STYLES -->
        <link href="../../assets/global/plugins/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!--/ END GLOBAL MANDATORY STYLES -->

        <!-- START @PAGE LEVEL STYLES -->
        <link href="../assets/global/plugins/bower_components/fontawesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="../assets/global/plugins/bower_components/animate.css/animate.min.css" rel="stylesheet">
        <!--/ END PAGE LEVEL STYLES -->

        <!-- START @THEME STYLES -->
        <link href="../../assets/admin/css/reset.css" rel="stylesheet">
        <link href="../../assets/admin/css/layout.css" rel="stylesheet">
        <link href="../../assets/admin/css/components.css" rel="stylesheet">
        <link href="../../assets/admin/css/plugins.css" rel="stylesheet">
        <link href="../../assets/admin/css/themes/default.theme.css" rel="stylesheet" id="theme">
        <link href="../../assets/admin/css/pages/sign-type-2.css" rel="stylesheet">
        <link href="../../assets/admin/css/custom.css" rel="stylesheet">
        <!--/ END THEME STYLES -->
        <!-- START @CORE PLUGINS -->
        <script src="../../../assets/global/plugins/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="../../../assets/global/plugins/bower_components/jquery-cookie/jquery.cookie.js"></script>
        <script src="../../../assets/global/plugins/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="../../../assets/global/plugins/bower_components/jquery-easing-original/jquery.easing.1.3.min.js"></script>
        <script src="../../../assets/global/plugins/bower_components/ionsound/js/ion.sound.min.js"></script>
        <script src="../../../assets/global/plugins/bower_components/retina.js/dist/retina.min.js"></script>
        <!--/ END CORE PLUGINS -->

        <!-- START @PAGE LEVEL PLUGINS -->
        <script src="../../../assets/global/plugins/bower_components/jquery-validation/dist/jquery.validate.min.js"></script>
        <script src="../../../assets/global/plugins/bower_components/jquery-backstretch/jquery.backstretch.min.js"></script>
        <!--/ END PAGE LEVEL PLUGINS -->

        <!-- START @PAGE LEVEL SCRIPTS -->
        <script src="../../assets/admin/js/pages/blankon.sign.js"></script>
        <script src="../../assets/admin/js/pages/project-management/blankon.project.management.sign.js"></script>
        <!--/ END PAGE LEVEL SCRIPTS -->
        
	<!--<link rel="stylesheet" type="text/css" href="include/css/estilos.css" />
	<link rel="stylesheet" type="text/css" href="include/css/login.css" />-->
        
        <script type="text/javascript" src="include/js/jscript.js"></script>
	<script type="text/javascript" src="include/js/login.js"></script>

</head>
<body style='background:url("../include/img/background.jpg");'>
    <!--<div id="lg-container">-->
    <div id='sign-wrapper'>
        <!--<div class="brand">
                <img src="http://img.djavaui.com/?create=220x100,81B71A?f=ffffff" alt="brand logo"/>
        </div>-->
         <form id="login" action="" method="post"  onsubmit="return login();" class="sign-in form-horizontal shadow no-overflow">
            <div class="sign-header">
                <div class="form-group">
                    <div class="sign-text">
                        <span>LOGIN SIEM</span>
                    </div>
                </div><!-- /.form-group -->
            </div><!-- /.sign-header -->
            <div class="sign-body">
                <div class="form-group">
                    <div class="input-group input-group-lg rounded no-overflow">
                        
                        <input type="text" class="form-control input-sm" placeholder="Usuario" name="txtUsuario" id="txtUsuario" autocomplete="off" requeried="requeried">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    </div>
                </div><!-- /.form-group -->
                <div class="form-group">
                    <div class="input-group input-group-lg rounded no-overflow">
                        <input name="txtContrasena" id='txtContrasena' type="password" class="form-control input-sm" requeried="requeried" autocomplete='off' placeholder="Contraseña">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    </div>
                </div>
                <?php if($config['login']['captcha-enable']){ ?>
                <div class="form-group">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <img class="img-thumbnail" id="imgCaptcha" src='lib/captcha.php' />	
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <input id="captcha" name="captcha" class="form-control lg-text" type="text" autocomplete="off"  placeholder="Captcha" maxlength=5 />
                    </div>
                </div>
                <?php }?><!-- /.form-group -->
            </div><!-- /.sign-body -->
            <div class="sign-footer">
                <div class="form-group">
                    <!--<div class="row">
                        <div class="col-xs-6">
                            <div class="ckbox ckbox-theme">
                                <input id="rememberme" type="checkbox">
                                <label for="rememberme" class="rounded">Remember me</label>
                            </div>
                        </div>
                        <div class="col-xs-6 text-right">
                            <a href="lost-password.html" title="lost password">Lost password?</a>
                        </div>
                    </div>-->
                    <div class='col-md-12'>
                        <label id="lg-message" class="p-3 mb-2 text-white"></label>
                    </div>
                </div><!-- /.form-group -->
                <div class="form-group">
                    <button type="button" class="btn btn-theme btn-lg btn-block no-margin rounded" id="login-btn" onclick="login();">Acceso</button>
                </div><!-- /.form-group -->
            </div><!-- /.sign-footer -->
           

        </form>	
    </div>
       
    <!--</div>-->
	<script type='text/javascript'>
		$('#txtUsuario').focus();
	</script>
         <!-- START GOOGLE ANALYTICS -->
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-55892530-1', 'auto');
            ga('send', 'pageview');

        </script>
        <!--/ END GOOGLE ANALYTICS -->
</body>
</html>