<!DOCTYPE html>
<html>
<head>

	 <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>
		<?php  fncTitle(); echo " - SIEM" ?>
	</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<base href="<?php echo DOMAIN_BASE; ?>">
	<link type="image/x-icon" href="<?php echo ruta_archivo?>/imagenes/favicon/<?php echo $_SESSION['favicon'];?>" rel="icon" />


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
        <link href="../../assets/global/plugins/bower_components/chosen_v1.8.7/chosen.min.css" rel="stylesheet" type="text/css"/>
        <script src="../../assets/global/plugins/bower_components/chosen_v1.8.7/chosen.jquery.js" type="text/javascript"></script>
        <link href="../../../assets/global/plugins/bower_components/bootstrap-datepicker-vitalets/css/datepicker.css" rel="stylesheet">
        <link href="../../../assets/global/plugins/bower_components/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet">
	<link href="../../../assets/global/plugins/bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
        <script src="../../../assets/global/plugins/bower_components/bootstrap-datepicker-vitalets/js/bootstrap-datepicker.js"></script>
        <script src="../../../assets/global/plugins/bower_components/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
        <script src="../../../assets/global/plugins/bower_components/moment/min/moment.min.js"></script>
        <script src="../../../assets/global/plugins/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
        <script src="../../assets/global/plugins/bower_components/jquery.inputmask/dist/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
        
        <script src="../../assets/global/plugins/bower_components/blockui/jquery.blockUI.js" type="text/javascript"></script>
         <link href="../../../assets/global/plugins/bower_components/datatables/css/dataTables.bootstrap.css" rel="stylesheet">
        <link href="../../../assets/global/plugins/bower_components/datatables/css/datatables.responsive.css" rel="stylesheet">
        <link href="../../../assets/global/plugins/bower_components/fuelux/dist/css/fuelux.min.css" rel="stylesheet">
        
        <script src="../../../assets/global/plugins/bower_components/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../../../assets/global/plugins/bower_components/datatables/js/dataTables.bootstrap.js"></script>
        <script src="../../../assets/global/plugins/bower_components/datatables/js/datatables.responsive.js"></script>
        <script src="../../../assets/global/plugins/bower_components/fuelux/dist/js/fuelux.min.js"></script>
        

        <script src="../../include/stacktable/stacktable.js" type="text/javascript"></script>
	<link href="../../include/stacktable/stacktable.css" rel="stylesheet" type="text/css"/>
        
        <!--PLUGIN PROPIOS-->
        <script src="include/jquery-ui-1.12.0/jquery-ui.js"></script>

        <link href="../../include/bootstrap-dialog/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css"/>
        <script src="../../include/bootstrap-dialog/js/bootstrap-dialog.min.js" type="text/javascript"></script>
         <link href="../../include/jquery-ui-1.12.1/jquery-ui.css" rel="stylesheet" type="text/css"/>
         <script type="text/javascript" src="include/js/jModal.js"></script>
          <script type="text/javascript" src="include/js/jMensajes.js"></script>
         <script type="text/javascript" src="include/js/toastem.js" ></script>
        <script type="text/javascript" src="include/js/jscript.js" ></script>
        <script type="text/javascript" src="include/js/logincerrar.js" ></script>
        <script src="../../include/js/jNotificacion.js" type="text/javascript"></script>
        <link href="../../include/css/estilos.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="include/css/toastem.css" />   
        <script src="../../include/js/jBotones.js" type="text/javascript"></script>
       <!-- <script src="../../include/jspanel-4.1.2/jspanel.js" type="text/javascript"></script>
        <link href="../../include/jspanel-4.1.2/jspanel.css" rel="stylesheet" type="text/css"/>
        <script src="../../include/jspanel-4.1.2/extensions/modal/jspanel.modal.js" type="text/javascript"></script>
        <script src="../../include/jspanel-4.1.2/extensions/tooltip/jspanel.tooltip.js" type="text/javascript"></script>
        <script src="../../include/jspanel-4.1.2/extensions/hint/jspanel.hint.js" type="text/javascript"></script>
        <script src="../../include/jspanel-4.1.2/extensions/layout/jspanel.layout.js" type="text/javascript"></script>
        <script src="../../include/jspanel-4.1.2/extensions/contextmenu/jspanel.contextmenu.js" type="text/javascript"></script>
        <script src="../../include/jspanel-4.1.2/extensions/dock/jspanel.dock.js" type="text/javascript"></script>
        -->
      <script>
          var bd_largo_decimal=<?php echo (defined('bd_largo_decimal')? bd_largo_decimal:0);?>;
        var bd_tipo_calculo_precio="<?php echo (defined('bd_tipo_calculo_precio')? bd_tipo_calculo_precio:0);?>";
       
        $(function () {
            $('.moneda').keypress(function (e) {
                if (e == null) {    
                    e = window.event;
                }
                var str=$(this).val().split('.');
                if(str.length>1 && str[1].split('').length>=bd_largo_decimal){
                     return false;
                 }

                if(e.which==46){

                    var str=$(this).val().split('.');
                    if(str[0]==''){
                        $(this).val(0);
                    }


                }
                if (e.which != 8 && e.which != 45 && e.which != 0 && e.which != 13 && e.which != 46 && (e.which < 48 || e.which > 57)) {
                    toastem.error('La tecla presionada no está permitida');
                    $(this).focus();
                    return false;
                }

        });
            
    });
    </script>
        
        <?php  fncHead();	?>
</head>
<body class="page-sound page-header-fixed page-sidebar-fixed page-footer-fixed" >
      <!-- START @WRAPPER -->
        <section id="wrapper">

            <!-- START @HEADER -->
            <header id="header">

                <!-- Start header left -->
                <div class="header-left">
                    <!-- Start offcanvas left: This menu will take position at the top of template header (mobile only). Make sure that only #header have the `position: relative`, or it may cause unwanted behavior -->
                    <div class="navbar-minimize-mobile left">
                        <i class="fa fa-bars"></i>
                    </div>
                    <!--/ End offcanvas left -->

                    <!-- Start navbar header -->
                    <div class="navbar-header">

                        <!-- Start brand -->
                        <a class="navbar-brand" href="#">
                            <?php if(isset($_SESSION['empresa_ID'])&&$_SESSION['empresa_ID']!=1){?>
                            <img class="logo" src="<?php echo logo;?>" style="max-height: 50px;"/>
                            <?php }else{?>
                            <img src="../../include/img/logo/1.png" alt="" style="max-height: 50px;"/>

                           <?php } ?>
                        </a><!-- /.navbar-brand -->
                        <!--/ End brand -->

                    </div><!-- /.navbar-header -->
                    <!--/ End navbar header -->

                    <!-- Start offcanvas right: This menu will take position at the top of template header (mobile only). Make sure that only #header have the `position: relative`, or it may cause unwanted behavior -->
                    <!--<div class="navbar-minimize-mobile right">
                        <i class="fa fa-cog"></i>
                    </div>
                    <!--/ End offcanvas right -->

                    <div class="clearfix"></div>
                </div><!-- /.header-left -->
                <!--/ End header left -->

                <!-- Start header right -->
                <div class="header-right">
                    <!-- Start navbar toolbar -->
                    <div class="navbar navbar-toolbar <?php echo $_COOKIE["stilo_fondo_cabecera"]?>">

                        <!-- Start left navigation -->
                        <ul class="nav navbar-nav navbar-left">

                            <!-- Start sidebar shrink -->
                            <li class="navbar-minimize">
                                <a href="javascript:void(0);" title="Minimize sidebar">
                                    <i class="fa fa-bars"></i>
                                </a>
                            </li>
                            <!--/ End sidebar shrink -->

                            <!-- Start form search -->
                            <li class="cont_modulos">
                                <!-- Just view on mobile screen-->
                                <a id="btn_vermodulo" class="dropdown-button active" title="Ver todos los módulos" onclick="fncVerModalModulos();">...</a>
                                <div id="menu-modulos" style="width: 79px; position: absolute; top: 0px; left: 0px; opacity: 1; display:none;" class="active">
                                    <div style="text-align: center;"><b>Empresas</b></div>
                                    <ul>
                                        <?php foreach($_SESSION['dtEmpresa'] as $iempresa){?>
                                         <li><a href="home/main/<?php echo $iempresa['ID']?>"><div class="circulo_modulo <?php echo $iempresa['stilo_fondo_tabs'];?>" ></div>
                                                <span><?php echo strtoupper($iempresa['nombre']);?></span>
                                            </a>
                                        </li>
                                        <?php } ?>

                                    </ul>
                                </div>
                            </li>
                            <!--/ End form search -->

                        </ul><!-- /.nav navbar-nav navbar-left -->
                        <!--/ End left navigation -->

                        <!-- Start right navigation -->
                        <ul class="nav navbar-nav navbar-right"><!-- /.nav navbar-nav navbar-right -->

                            <!-- Start messages -->
                            <li class="dropdown navbar-message">

                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope-o"></i><span class="count label label-danger rounded" id="contenedorContador"></span></a>

                                <!-- Start dropdown menu -->
                                <div class="dropdown-menu animated flipInX" style="min-height: 300px;">
                                    <div class="dropdown-header">
                                        <span class="title">Messages <strong id="stronContador"></strong></span>
                                        <span class="option text-right"><a href="#">+ New message</a></span>
                                    </div>
                                    <div class="dropdown-body" style="height: 225px;">

                                        <!-- Start message search -->

                                        <!--/ End message search -->

                                        <!-- Start message list -->
                                        <div class="media-list niceScroll" id="contenedorNotificacion">


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



                        </ul>
                        <!--/ End right navigation -->

                    </div><!-- /.navbar-toolbar -->
                    <!--/ End navbar toolbar -->
                </div><!-- /.header-right -->
                <!--/ End header left -->

            </header> <!-- /#header -->
            <!--/ END HEADER -->

            <!--

            START @SIDEBAR LEFT
            |=========================================================================================================================|
            |  TABLE OF CONTENTS (Apply to sidebar left class)                                                                        |
            |=========================================================================================================================|
            |  01. sidebar-box               |  Variant style sidebar left with box icon                                              |
            |  02. sidebar-rounded           |  Variant style sidebar left with rounded icon                                          |
            |  03. sidebar-circle            |  Variant style sidebar left with circle icon                                           |
            |=========================================================================================================================|

            -->
            <aside id="sidebar-left" class="sidebar-circle">

                <!-- Start left navigation - profile shortcut -->

                <!--/ End left navigation -  profile shortcut -->

                <!-- Start left navigation - menu -->
                <ul class="sidebar-menu" tabindex="0" style="height: 542px; overflow: hidden; outline: none;">
                    <li class="sidebar-category">
                        <span><?php echo $_SESSION['empresa']?></span>
                        <span class="pull-right"><i class="<?php echo $_SESSION['icono']?>"></i></span>
                    </li>
                    
                    <?php
                       require ROOT_PATH."/lib/menu.php";
                    ?>
                </ul>
               
               <!-- /.sidebar-menu -->
                <!--/ End left navigation - menu -->

                <!-- Start left navigation - footer -->
                <div class="sidebar-footer hidden-xs hidden-sm hidden-md">
                    <a id="fullscreen" class="pull-left" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-title="Fullscreen"><i class="fa fa-desktop"></i></a>
                    <a id="logout" data-url="" class="pull-left" onclick="fncLogout();" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-title="Logout"><i class="fa fa-power-off"></i></a>
                </div><!-- /.sidebar-footer -->
                <!--/ End left navigation - footer -->

            </aside><!-- /#sidebar-left -->
            <!--/ END SIDEBAR LEFT -->

            <!-- START @PAGE CONTENT -->
            <section id="page-content">
            <div id="cuerpo_principal">
                <!-- Start page header -->
                <div class="header-content">
                    <h2><?php fncTituloCabecera();?></h2>
                    <div id="divArbol" class="breadcrumb-wrapper hidden-xs"></div>
                </div><!-- /.header-content -->
                <!--/ End page header -->

                <!-- Start body content -->
                <div class="body-content animated fadeIn">

                   <?php
                        fncPage();
                    ?>

                </div><!-- /.body-content -->
            </div>
                <!--/ End body content -->
            <div id="divContenedorDIV"  class="embed-responsive embed-responsive-16by9 box effect2"  style="display:none;">
            </div>
                <!-- Start footer content -->
                <footer class="footer-content">
                     © <?php echo date("Y")?> - <span id="copyright-year"></span> &copy; Soluciones Informáticas M&M S.R.L. Creado por <a href="http://www.simm.com.pe"> www.simm.com.pe</a>, Perú
                    <span class="pull-right">0.01 GB(0%) of 15 GB used</span>
                </footer><!-- /.footer-content -->
                <!--/ End footer content -->

            </section><!-- /#page-content -->
            <!--/ END PAGE CONTENT -->



        </section><!-- /#wrapper -->
        <!--/ END WRAPPER -->

        <!-- START @BACK TOP -->
        <div id="back-top" class="animated pulse circle">
            <i class="fa fa-angle-up"></i>
        </div><!-- /#back-top -->
        <!--/ END BACK TOP -->

        <!-- START @ADDITIONAL ELEMENT -->
        <div class="modal modal-success fade" id="modal-dashboard-ecommerce" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Features E-Commerce</h4>
                    </div>
                    <div class="modal-body">
                        <div class="media">
                            <div class="media-left" style="padding-right: 20px;">
                                <a href="#">
                                    <img class="media-object" src="../../../img/admin-special/ecommerce/mascot/mascot-welcome.png" alt="...">
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">This is summary features on e-commerce</h4>
                                <ul class="list-unstyled">
                                    <li>
                                        <div class="media mb-5">
                                            <div class="media-left">
                                                <i class="fa fa-check-circle-o fg-success"></i>
                                            </div>
                                            <div class="media-body">
                                                Dashboard design with overview count product, progress chart and widget timeline notifications order activity.
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="media mb-5">
                                            <div class="media-left">
                                                <i class="fa fa-check-circle-o fg-success"></i>
                                            </div>
                                            <div class="media-body">
                                                Complete product catalog managemen such as product list with datatable, add product form, categories, tags and attributes product.
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="media mb-5">
                                            <div class="media-left">
                                                <i class="fa fa-check-circle-o fg-success"></i>
                                            </div>
                                            <div class="media-body">
                                                Complete orders & customers managemen such as order/customer list, add customer and support ticket customers.
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="media mb-5">
                                            <div class="media-left">
                                                <i class="fa fa-check-circle-o fg-success"></i>
                                            </div>
                                            <div class="media-body">
                                                There are additional option for demo system store management such as tax, shipping and payment.
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <hr/>
                        <div class="alert alert-info no-margin">
                            This is just demo for design e-commerce administrator, nothing data store to database just static HTML. All link is work, this is real demo e-commerce system app :D
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ END ADDITIONAL ELEMENT -->

    <div style="display:none" id="dialog-confirm" ></div>
    <div id="divContent-float"  style="display:none;">
            <div id="loading-float" style="width:100%;text-align:center;" >
                <div style="margin:0 auto;">
                    <img title="Cargando" alt="Cargando" src="include/img/loading_bar.gif"/>
                    <img class="boton" title="Cerrar" alt="Cerrar" style="width:15px;height:15px;" src="include/img/boton/close_delete-16.png" onclick="window_float_close();" />
                </div>

            </div>
            <div id="window-float"  style="display:none;"> </div>
    </div>
    <!-- Modal -->

    <div id="toastem"></div>
   <div id="fondo_espera" style="background:#000;opacity:0.7;width:100%;height:100%;z-index: 56;text-align:center;top:0;position:absolute; display:none;" ><img width="80px" src="/include/img/loader-Login.gif"></div>
    
   <div id="float_modal" class="modal fade modal-success bs-example-modal-table in" tabindex="-1" aria-hidden="true" data-backdrop="static" data-keyboard="false" role="dialog">
        <div class="modal-dialog modal-lg">

           <!-- Modal content-->
            <div class="modal-content" style="heigth:100%;">
                <div class="modal-header">
                  <button type="button" class="close" onclick="float_close_modal();">&times;</button>
                  <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body embed-responsive-16by9">

                </div>

            </div>

        </div>
   </div>

   <div id="float_modal_hijo" class="modal fade modal-info bs-example-modal-table in" tabindex="-1" aria-hidden="true" data-backdrop="static"  data-keyboard="false" role="dialog">
        <div class="modal-dialog modal-lg">
           <!-- Modal content-->
           <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" onclick="float_close_modal_hijo();">&times;</button>
                  <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body embed-responsive-16by9">

                </div>
           </div>
        </div>
   </div>
   <div id="float_modal_hijo_hijo" class="modal fade modal-primary" data-backdrop="static"  data-keyboard="false" role="dialog">
        <div class="modal-dialog">
           <!-- Modal content-->
           <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" onclick="float_close_modal_hijo_hijo();">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">

                </div>
           </div>
        </div>
   </div>
   
   <div id="Modal_Registro_Informacion" class="modal fade modal-teal bs-example-modal-table in" tabindex="-1" aria-hidden="true" data-backdrop="static" data-keyboard="false" role="dialog">
        <div class="modal-dialog" style="heigth:100%;">
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" onclick="close_registro_informacion();">&times;</button>
                  <h4 id="Registro_Informacion_Title" class="modal-title" >Registro de información</h4>
                </div>
                <div  class="modal-body embed-responsive-16by9 form-horizontal">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="fncAgregarInformacionGrilla();">Agregar</button>
                    <button type="button" class="btn btn-danger" onclick="close_registro_informacion();">Cerrar</button>
                    <div class="clearfix"></div>
                </div>
            </div>
            
        </div>
   </div>
   <div id="contenedorUL" style="position:absolute;display:none;" class="btn-group open">
         <ul id="contenedor_anticlick" class="dropdown-menu" style="display: block;">
         
        </ul>
     </div>
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
            /*$("#float_modal_hijo_hijo").draggable({
                handle: ".modal-header"
            });
            $("#float_modal_hijo").draggable({
                handle: ".modal-header"
            });
            $("#float_modal").draggable({
                handle: ".modal-header"
            });   */
						

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
        
  

    $('#btn-getstarted-1').on('click', function () {
        jsPanel.create({
            theme:       'primary',
            headerTitle: 'my panel #1',
            position:    'center-top 0 58',
            contentSize: '450 250',
            content:     '<p>Example panel ...</p>',
            callback: function () {
                this.content.style.padding = '20px';
            },
            onbeforeclose: function () {
                return confirm('Do you really want to close the panel?');
            }
        })
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
<style>
    .submenu .text,.sidebar-category{
        font-size:15px;
    }
    .cont_modulos:hover{
        cursor:pointer;
    }
    #menu-modulos{
    position: absolute;
    z-index: 1;
    top: 10px !important;
    left: 5px;
    width: 360px !important;
    padding: 10px;
    background: white;
    color: #808080;
    box-shadow: 0 2px 4px -1px rgba(0,0,0,.2), 0 4px 5px 0 rgba(0,0,0,.14), 0 1px 10px 0 rgba(0,0,0,.12);
    }
    #menu-modulos ul>li>a{
    display: inline-block !important;
    text-align: center;
    color: #808080;
    width: 100%;
    vertical-align: middle;
    padding: 10px 5px;
    border-radius: 4px;
    -webkit-transition: box-shadow .4s cubic-bezier(.25,.8,.25,1),background-color .4s cubic-bezier(.25,.8,.25,1);
    transition: box-shadow .4s cubic-bezier(.25,.8,.25,1),background-color .4s cubic-bezier(.25,.8,.25,1);
    transition-property: box-shadow, background-color;
    transition-duration: 0.4s, 0.4s;
    transition-timing-function: cubic-bezier(0.25, 0.8, 0.25, 1), cubic-bezier(0.25, 0.8, 0.25, 1);
    transition-delay: initial, initial;
    text-decoration: none!important;
    }
    #menu-modulos span{
        color:#636E7B!important;
    }
    #menu-modulos ul{
        margin-left: 0;
    }
    #menu-modulos ul>li>a:hover{

        border:1px #808080 solid;
        cursor:pointer;
    }
    #menu-modulos li a{
        text-decoration:none !important;
    }
    #menu-modulos ul>li{
        float: left;
        width: 120px;
        height: 80px;
        margin: 5px;
        text-decoration:none;
        list-style-type:none;
        }
    .circulo_modulo{

        height: 25px;width:25px; border-radius: 50%;margin-right:5px;margin:auto;

    }
    .circulo_menu{
        height: 18px;width:18px; border-radius: 50%;float:left;margin-right:5px;margin-right: 5px;
    }
    .panel-tab .panel-heading>ul li a{
        padding: 4px!important;
    }
    .panel-tab .panel-heading>ul li a i{
        height: 25px;
        font-size:20px;
    }
</style>

</body>
</html>
