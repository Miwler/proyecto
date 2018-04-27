<!DOCTYPE html>
<html>
<head>
    
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        
	<title>
		<?php  fncTitle(); echo " - SIEM" ?>
	</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<base href="<?php echo DOMAIN_BASE; ?>">
	<link type="image/x-icon" href="files/imagenes/favicon/<?php echo $_SESSION['favicon'];?>" rel="icon" /> 
	

        <!-- START @FONT STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700" rel="stylesheet">
        <link href="http://fonts.googleapis.com/css?family=Oswald:700,400" rel="stylesheet">
        <!--/ END FONT STYLES -->

        <!-- START @GLOBAL MANDATORY STYLES -->
        <link href="../../assets/global/plugins/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!--/ END GLOBAL MANDATORY STYLES -->

        <!-- START @PAGE LEVEL STYLES -->
        <link href="../../assets/global/plugins/bower_components/fontawesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="../../assets/global/plugins/bower_components/animate.css/animate.min.css" rel="stylesheet">
        <!--/ END PAGE LEVEL STYLES -->

        <!-- START @THEME STYLES -->
        <link href="../../assets/admin/css/reset.css" rel="stylesheet">
        <link href="../../assets/admin/css/layout.css" rel="stylesheet">
        <link href="../../assets/admin/css/components.css" rel="stylesheet">
        <link href="../../assets/admin/css/plugins.css" rel="stylesheet">
        <link href="../../assets/admin/css/themes/default.theme.css" rel="stylesheet" id="theme">
        <link href="../../assets/admin/css/custom.css" rel="stylesheet">
        <!--/ END THEME STYLES -->
         <!-- START @CORE PLUGINS -->
        <script src="../../assets/global/plugins/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="../../assets/global/plugins/bower_components/jquery-cookie/jquery.cookie.js"></script>
        <script src="../../assets/global/plugins/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="../../assets/global/plugins/bower_components/typehead.js/dist/handlebars.js"></script>
        <script src="../../assets/global/plugins/bower_components/typehead.js/dist/typeahead.bundle.min.js"></script>
        <script src="../../assets/global/plugins/bower_components/jquery-nicescroll/jquery.nicescroll.min.js"></script>
        <script src="../../assets/global/plugins/bower_components/jquery.sparkline.min/index.js"></script>
        <script src="../../assets/global/plugins/bower_components/jquery-easing-original/jquery.easing.1.3.min.js"></script>
        <script src="../../assets/global/plugins/bower_components/ionsound/js/ion.sound.min.js"></script>
        <script src="../../assets/global/plugins/bower_components/bootbox/bootbox.js"></script>
        <script src="../../assets/global/plugins/bower_components/retina.js/dist/retina.min.js"></script>
        <!--/ END CORE PLUGINS -->
        <!--PLUGIN PERSONALIZADOS-->
        <link href="../../assets/global/plugins/bower_components/chosen_v1.2.0/chosen.min.css" rel="stylesheet" type="text/css"/>
        <script src="../../assets/global/plugins/bower_components/chosen_v1.2.0/chosen.jquery.js" type="text/javascript"></script>
        <link href="../../../assets/global/plugins/bower_components/bootstrap-datepicker-vitalets/css/datepicker.css" rel="stylesheet">
        <link href="../../../assets/global/plugins/bower_components/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet">
	<link href="../../../assets/global/plugins/bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
        <script src="../../../assets/global/plugins/bower_components/bootstrap-datepicker-vitalets/js/bootstrap-datepicker.js"></script>
        <script src="../../../assets/global/plugins/bower_components/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
        <script src="../../../assets/global/plugins/bower_components/moment/min/moment.min.js"></script>
        <script src="../../../assets/global/plugins/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
        <script src="../../assets/global/plugins/bower_components/jquery.inputmask/dist/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
        
        <script src="../../include/stacktable/stacktable.js" type="text/javascript"></script>
	<link href="../../include/stacktable/stacktable.css" rel="stylesheet" type="text/css"/>
        <!--PLUGIN PROPIOS-->
        <script type="text/javascript" src="include/js/jscript.js" ></script>  
        <script type="text/javascript" src="include/js/logincerrar.js" ></script>
        <?php  fncHead();	?>
</head>
<body class="page-sound page-header-fixed page-sidebar-fixed page-footer-fixed" style='background:url("../include/img/background1.jpg") repeat-x;'>
      <!-- START @WRAPPER -->
        <section id="wrapper">

            <!-- START @HEADER -->
            <header id="header">
                <!-- Start header right -->
                <div class="">
                    <!-- Start navbar toolbar -->
                    <div class="navbar navbar-toolbar" style="background:none;">
                        <!-- Start right navigation -->
                        <ul class="nav navbar-nav navbar-right"><!-- /.nav navbar-nav navbar-right -->

                            <!-- Start messages -->
                            <li class="dropdown navbar-message">

                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope-o"></i><span class="count label label-danger rounded" id="contenedorContador"></span></a>
                                <!-- Start dropdown menu -->
                                <div class="dropdown-menu animated flipInX" style="min-height: 300px;">
                                    <div class="dropdown-header">
                                        <span class="title">Messages <strong id="stronContador">...</strong></span>
                                        <span class="option text-right"><a href="#">+ New message</a></span>
                                    </div>
                                    <div class="dropdown-body" style="height: 225px;">

                                       
                                        <!-- Start message list -->
                                        <div class="media-list niceScroll"  id="contenedorNotificacion">

                                        </div>
                                        <!--/ End message list -->

                                    </div>
                                    <div class="dropdown-footer">
                                        <a href="message-detail.html">See All</a>
                                    </div>
                                </div>
                                <!--/ End dropdown menu -->

                            </li><!-- /.dropdown navbar-message -->
                            <!--/ End messages -->

                            <!-- Start notifications -->
                            <li class="dropdown navbar-notification">

                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell-o"></i><span class="count label label-danger rounded">6</span></a>

                                <!-- Start dropdown menu -->
                                <div class="dropdown-menu animated flipInX">
                                    <div class="dropdown-header">
                                        <span class="title">Notifications <strong>(10)</strong></span>
                                        <span class="option text-right"><a href="#"><i class="fa fa-cog"></i> Setting</a></span>
                                    </div>
                                    <div class="dropdown-body niceScroll">

                                        <!-- Start notification list -->
                                        <div class="media-list small">

                                            <a href="#" class="media">
                                                <div class="media-object pull-left"><i class="fa fa-share-alt fg-info"></i></div>
                                                <div class="media-body">
                                                    <span class="media-text"><strong>Dolanan Remi : </strong><strong>Chris Job,</strong><strong>Denny Puk</strong> and <strong>Joko Fernandes</strong> sent you <strong>5 free energy boosts and other request</strong></span>
                                                    <!-- Start meta icon -->
                                                    <span class="media-meta">3 minutes</span>
                                                    <!--/ End meta icon -->
                                                </div><!-- /.media-body -->
                                            </a><!-- /.media -->

                                            <a href="#" class="media">
                                                <div class="media-object pull-left"><i class="fa fa-cogs fg-success"></i></div>
                                                <div class="media-body">
                                                    <span class="media-text">Your sistem is updated</span>
                                                    <!-- Start meta icon -->
                                                    <span class="media-meta">5 minutes</span>
                                                    <!--/ End meta icon -->
                                                </div><!-- /.media-body -->
                                            </a><!-- /.media -->

                                            <a href="#" class="media">
                                                <div class="media-object pull-left"><i class="fa fa-ban fg-danger"></i></div>
                                                <div class="media-body">
                                                    <span class="media-text">3 Member is BANNED</span>
                                                    <!-- Start meta icon -->
                                                    <span class="media-meta">5 minutes</span>
                                                    <!--/ End meta icon -->
                                                </div><!-- /.media-body -->
                                            </a><!-- /.media -->

                                            <a href="#" class="media">
                                                <div class="media-object pull-left"><img class="img-circle" src="http://img.djavaui.com/?create=30x30,4888E1?f=ffffff" alt=""/></div>
                                                <div class="media-body">
                                                    <span class="media-text">daddy updated profile just now</span>
                                                    <!-- Start meta icon -->
                                                    <span class="media-meta">45 minutes</span>
                                                    <!--/ End meta icon -->
                                                </div><!-- /.media-body -->
                                            </a><!-- /.media -->

                                            <a href="#" class="media">
                                                <div class="media-object pull-left"><i class="fa fa-user fg-info"></i></div>
                                                <div class="media-body">
                                                    <span class="media-text">Change your user profile</span>
                                                    <!-- Start meta icon -->
                                                    <span class="media-meta">1 days</span>
                                                    <!--/ End meta icon -->
                                                </div><!-- /.media-body -->
                                            </a><!-- /.media -->

                                            <a href="#" class="media">
                                                <div class="media-object pull-left"><i class="fa fa-book fg-info"></i></div>
                                                <div class="media-body">
                                                    <span class="media-text">Added new article</span>
                                                    <!-- Start meta icon -->
                                                    <span class="media-meta">1 days</span>
                                                    <!--/ End meta icon -->
                                                </div><!-- /.media-body -->
                                            </a><!-- /.media -->

                                            <!-- Start notification indicator -->
                                            <a href="#" class="media indicator inline">
                                                <span class="spinner">Load more notifications...</span>
                                            </a>
                                            <!--/ End notification indicator -->

                                        </div>
                                        <!--/ End notification list -->

                                    </div>
                                    <div class="dropdown-footer">
                                        <a href="#">See All</a>
                                    </div>
                                </div>
                                <!--/ End dropdown menu -->

                            </li><!-- /.dropdown navbar-notification -->
                            <!--/ End notifications -->

                            <!-- Start profile -->
                            <li class="dropdown navbar-profile">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="meta">
                                    <span class="avatar">
                                        <?php if(isset($_SESSION['foto'])&&$_SESSION['foto']!=""){?>
                                        <img src="http://img.djavaui.com/?create=35x35,4888E1?f=ffffff" class="img-circle" alt="admin">
                                        <?php }else{ ?>
                                        <img src="../../include/img/usuario/user-default.png" class="img-circle" alt="" style="width: 35px;height: 35px;">
                                        <?php }?>
                                        </span>
                                    <span class="text hidden-xs hidden-sm text-muted"><?php echo $_SESSION['usuario_nombre']?></span>
                                    <span class="caret"></span>
                                </span>
                                </a>
                                <!-- Start dropdown menu -->
                                <ul class="dropdown-menu animated flipInX">
                                    <li class="dropdown-header">Cuenta</li>
                                    <li><a href="page-profile.html"><i class="fa fa-user"></i>Ver perfil</a></li>
                                    <li><a href="javascript:void(0)" onclick="fncLogout();"><i class="fa fa-sign-out" ></i>Logout</a></li>
                                </ul>
                                <!--/ End dropdown menu -->
                            </li><!-- /.dropdown navbar-profile -->
                            <!--/ End profile -->

                            <!-- Start settings -->
                            
                            <!--<li class="navbar-setting pull-right">
                                <a href="javascript:void(0);"><i class="fa fa-cog fa-spin"></i></a>
                            </li><!-- /.navbar-setting pull-right -->
                            <!--/ End settings -->

                        </ul>
                        <!--/ End right navigation -->

                    </div><!-- /.navbar-toolbar -->
                    <!--/ End navbar toolbar -->
                </div><!-- /.header-right -->
                <!--/ End header left -->

            </header> <!-- /#header -->
            <!--/ END HEADER -->

            <!--

            <section id="page-content1">

                <!-- Start page header -->
                <div class="header-content" style="background: none;">
                    <h2 class="text-white"><?php fncTituloCabecera();?></h2>
                    <div class="breadcrumb-wrapper hidden-xs">
                        <!--<span class="label">You are here:</span>
                        <!--<ol class="breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                <a href="dashboard.html">HR Dashboard</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="admin-system-quick-access.html">Admin System</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li class="active">Quick Access</li>
                        </ol>-->
                       
                    </div>
                </div><!-- /.header-content -->
                <!--/ End page header -->

                <!-- Start body content -->
                <div class="body-content animated fadeIn" style="background:none;">

                   <?php						
                            fncPage();
                        ?>

                </div><!-- /.body-content -->
                <!--/ End body content -->

                <!-- Start footer content -->
                <footer class="footer-content" style="bottom:0;position: fixed;width: 100%;">
                     © <?php echo date("Y")?> - <span id="copyright-year"></span> &copy; Soluciones Informáticas M&M S.R.L. Creado por <a href="http://www.simm.com.pe"> www.simm.com.pe</a>, Perú
                    <span class="pull-right">0.01 GB(0%) of 15 GB used</span>
                </footer><!-- /.footer-content -->
                <!--/ End footer content -->

            </section><!-- /#page-content -->
            <!--/ END PAGE CONTENT -->

       

       

    
    <script type="text/javascript">
    $(document).ready(function(){
            $('.chosen-select').chosen();
            $('.date-range-picker-single').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    locale: {
                    format: 'DD/MM/YYYY'
                }
                },
                function(start, end, label) {
                    var years = moment().diff(start, 'years');
                    //alert("You are " + years + " years old.");
                    //start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                });
                $(":input").inputmask();
        });
    /*$('.nav-tabs a').click(function(){
        $(this).tab('show');
        
    })*/
        var fncVerModalModulos=function(){
            $("#menu-modulos").show("fast");
        }
        var fncVerEmpresas=function(){
            $("#menu-empresas").show("fast");
        }                 
        $(document).ready(function() {
            
            
                
                
            $(document).click(function(e){
                if(e.target.id!='menu-modulos' && e.target.id!="btn_vermodulo"){
                    $("#menu-modulos").hide("fast");
                }
                if(e.target.id!='menu-empresas' && e.target.id!="btn_verempresas"){
                    $("#menu-empresas").hide("fast");
                }
            });
            <?php if(isset($_SESSION['tabs'])){?>
            $("div.bhoechie-tab-menu>div.list-group-<?php echo $_SESSION['tabs'];?>>a").click(function(e) {
               
                e.preventDefault();
                $(this).siblings('a.active').removeClass("active");
                $(this).addClass("active");
                var index = $(this).index();
                $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
                $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
            });
            <?php } ?>
        });
        $('.dropdown-toggle').dropdown();
        $("#menu_principal li a").click(function(){
            var menu_ID=this.id;
             $.ajax({
                type: "post",
                url: "Funcion/ajaxSeleccionarMenu",
                data: {
                    id: menu_ID
                },
                datatype: "json",
                success: function (respuesta) {
                    //alert(respuesta);
                    var respuesta = $.parseJSON(respuesta);
                    //resultado(respuesta);

                }
                
            });
            
        });
        </script>
   <!-- START JAVASCRIPT SECTION (Load javascripts at bottom to reduce load time) -->
       

        <!-- START @PAGE LEVEL PLUGINS -->
        <script src="../../assets/global/plugins/bower_components/bootstrap-session-timeout/dist/bootstrap-session-timeout.min.js"></script>
        <!--/ END PAGE LEVEL PLUGINS -->

        <!-- START @PAGE LEVEL SCRIPTS -->
        <script src="../../assets/admin/js/apps.js"></script>
        <script src="../../assets/admin/js/demo.js"></script>
        <!--/ END PAGE LEVEL SCRIPTS -->
        <!--/ END JAVASCRIPT SECTION -->
</body>
</html>