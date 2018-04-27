<!DOCTYPE html>
<html>
<head>
    
	<meta name="viewport" content="width=device-width" />
        
	<title>
		<?php  fncTitle(); echo " - SGL" ?>
	</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<base href="<?php echo DOMAIN_BASE; ?>">
	<link type="image/x-icon" href="files/imagenes/favicon/<?php echo $_SESSION['favicon'];?>" rel="icon" /> 
	<!--<link rel="stylesheet" type="text/css" href="include/css/controles.css" />-->
	<link rel="stylesheet" type="text/css" href="include/css/menu.css" />
        <link rel="stylesheet" type="text/css" href="include/css/font-awesome.css" />
	<link rel="stylesheet" type="text/css" href="include/css/print.css" media="print" />
	<link rel="stylesheet" type="text/css" href="include/css/toastem.css" />
	<script type="text/javascript" src="include/js/jquery-2.1.0.min.js" ></script>
	<script type="text/javascript" src="include/js/jTeclas.js" ></script>
	<script type="text/javascript" src="include/js/jscript.js" ></script>
	<script type="text/javascript" src="include/js/logincerrar.js" ></script>
	<!--<script type="text/javascript" src="include/js/jMenu.js" ></script>-->
        <script type="text/javascript" src="include/js/functionmenu.js" ></script>
        <script type="text/javascript" src="include/js/jMenu.js" ></script>
	<script type="text/javascript" src="include/js/jFunc.js" ></script>
        <!--<script type="text/javascript" src="include/js/jControles.js" ></script>-->
        <script type="text/javascript" src="include/js/toastem.js" ></script>
        <script src="../../include/jquery-ui-1.12.1/jquery-ui.js" type="text/javascript"></script>
        <script src="../../include/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <link href="../../include/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <script src="../../include/stacktable/stacktable.js" type="text/javascript"></script>
	<link href="../../include/stacktable/stacktable.css" rel="stylesheet" type="text/css"/>
        <link href="../../include/bootstrap-dialog/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css"/>
        <script src="../../include/bootstrap-dialog/js/bootstrap-dialog.min.js" type="text/javascript"></script>
        
        <link href="../../include/css/bootstrap-responsive-tabs.css.css" rel="stylesheet" type="text/css"/>
       
        <script src="../../include/js/jquery.bootstrap-responsive-tabs.min.js" type="text/javascript"></script>
        <link href="../../include/jquery-ui-1.12.1/jquery-ui.css" rel="stylesheet" type="text/css"/>
        <script src="../../include/js/jMensajes.js" type="text/javascript"></script>
        <script type="text/javascript" src="include/js/jModal.js"></script>
         <!--<script src="include/js/jquery-ui-1.12.1/jquery-ui.js"></script>-->
        <link href="../../include/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        
        <!--Nuevos style-->
        <link href="../../assets/admin/css/angular-custom.css" rel="stylesheet" type="text/css"/>
        <link href="../../assets/admin/css/components.css" rel="stylesheet" type="text/css"/>
        <link href="../../assets/admin/css/custom.css" rel="stylesheet" type="text/css"/>
        <link href="../../assets/admin/css/layout.css" rel="stylesheet" type="text/css"/>
        <link href="../../assets/admin/css/material-custom.css" rel="stylesheet" type="text/css"/>
        <link href="../../assets/admin/css/plugins.css" rel="stylesheet" type="text/css"/>
        <link href="../../assets/admin/css/reset.css" rel="stylesheet" type="text/css"/>
        <link href="../../assets/admin/css/theme.css" rel="stylesheet" type="text/css"/>
        <link href="../../assets/admin/css/yii-custom.css" rel="stylesheet" type="text/css"/>
       
          <!--Componentes personalizados-->    
        <link href="../../assets/global/plugins/bower_components/chosen_v1.2.0/chosen.min.css" rel="stylesheet" type="text/css"/>
        <script src="../../assets/global/plugins/bower_components/chosen_v1.2.0/chosen.jquery.js" type="text/javascript"></script>
        
        <link href="../../../assets/global/plugins/bower_components/fontawesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="../../../assets/global/plugins/bower_components/animate.css/animate.min.css" rel="stylesheet">
        <link href="../../../assets/global/plugins/bower_components/bootstrap-datepicker-vitalets/css/datepicker.css" rel="stylesheet">
        <link href="../../../assets/global/plugins/bower_components/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet">
        <link href="../../../assets/global/plugins/bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
        <script src="../../../assets/global/plugins/bower_components/bootstrap-datepicker-vitalets/js/bootstrap-datepicker.js"></script>
        <script src="../../../assets/global/plugins/bower_components/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
        <script src="../../../assets/global/plugins/bower_components/moment/min/moment.min.js"></script>
        <script src="../../../assets/global/plugins/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
        <script src="../../assets/global/plugins/bower_components/jquery.inputmask/dist/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
  
        
        <!---->
         <link rel="stylesheet" type="text/css" href="include/css/estilos.css" />
         
        <script type='text/javascript'>//<![CDATA[
        $(window).on('load', function() {
            $('.responsive-tabs').responsiveTabs({
                accordionOn: ['xs', 'sm'] // xs, sm, md, lg
            });
            
            
        });//]]> 
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
        </script>
	<?php  fncHead();	?>
</head>
<body>
    <div>
        <header>
            <nav class="navbar navbar-inverse menu_header" role="navigation" style="margin-bottom: 0;">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu_prin"
                            data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Desplegar navegación</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div id="menu_prin" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav menu_item">
                        <?php if(!isset($_SESSION['empresa_ID'])){?>
                        <li>SISTEMA INTEGRADO DE VENTAS</li>
      
                        <?php } else{?>
                        <li>
                            <a id="btn_verempresas" onclick="fncVerEmpresas();"><?php echo FormatTextView(strtoupper($_SESSION['empresa']));?></a>
                            <?php if(isset($_SESSION['dtUsuario_Empresa']) && count($_SESSION['dtUsuario_Empresa'])>1){?>
                            <div id="menu-empresas" class="p-3 mb-2 bg-danger text-white" style="width: 79px; position: absolute; top: 50px; left: 0px; opacity: 1;z-index:3; display:none; " class="active">
                                <div style="text-align: center;"><b>Empresas</b></div>
                                <ul>
                                    <?php foreach($_SESSION['dtUsuario_Empresa'] as $usuario_empresa){?>
                                    <li><a href="home/empresas_modulos/<?php echo $usuario_empresa['ID'];?>">
                                            <span><?php echo FormatTextView($usuario_empresa['nombre']);?></span>
                                        </a>
                                    </li>
                                    <?php } ?>  
                                </ul>
                            </div>
                            <?php } ?>
                        </li>
                        <?php } ?>
                        
                        <?php if(isset($_SESSION['modulo_ID'])){?>
                        <!--<li><a href="home/empresa_modulos/<?php echo $_SESSION['empresa_ID'];?>" title="Inicio"><span class="glyphicon glyphicon-home"></span> Inicio</a></li>-->
                        <li><a href="home/main/<?php echo $_SESSION['modulo_ID'];?>" title="Inicio"><span class="glyphicon glyphicon-home"></span> Inicio</a></li>
                        <li class="menu_info"><div class="circulo_menu" style="background:<?php echo $_SESSION['color'];?>;"></div><span><?php echo FormatTextView($_SESSION['modulo'])?></span></li>
                        <li class="cont_modulos">
                            <a id="btn_vermodulo" class="dropdown-button active" title="Ver todos los módulos" onclick="fncVerModalModulos();">...</a>
                            <div id="menu-modulos" style="width: 79px; position: absolute; top: 0px; left: 0px; opacity: 1; display:none;" class="active">
                                <div style="text-align: center;"><b>Módulos</b></div>
                                <ul>
                                    <?php foreach($_SESSION['dtModulo_Empresa'] as $modulos){?>
                                    <li><a href="home/main/<?php echo $modulos['modulo_ID'];?>"><div class="circulo_modulo" style="background:<?php echo $modulos['color'];?>;"></div>
                                            <span><?php echo FormatTextView($modulos['nombre_corto']);?></span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                   
                                </ul>
                            </div>
                        </li>
                        <?php } ?>
                    </ul>
                  
                    <ul class="nav navbar-nav navbar-right">
                        <li><a id="foto_perfil_24x24"><span class="glyphicon glyphicon-user">
                        </span> <?php echo $_SESSION['usuario_nombre'];?></a>

                      </li>
                    </ul>
                </div>
             
                <div id="divUsuarioAccion" class="right" style="display:none;background:#e0e0e0;width:350px;right:0;position:absolute;padding:15px 0;z-index: 100;">             
                    <img id="foto_perfil_128x128" alt="foto_perfil" src ="include/img/usuario/user-default.png" width="50" height="50" style="float:left;margin:0 10px;" />

                    <div id="divUsuariobottom">
                        <button id="btnEdit" name="btnEdit" type="button" onclick="window_float_open('/Mantenimiento/Usuario_mantenimiento_Actualizar','<?php echo $_SESSION['usuario_ID'];?>','',null,this);" class="btn btn-lg btn-info" >
                                   Editar
                        </button>&nbsp;&nbsp;&nbsp;
                        <button id="btnLogout" name="btnLogout" type="button" onclick="fncLogout();"class="btn btn-lg btn-danger">
                               Cerrar sesión
                        </button>
                    </div>

                </div> 
            </nav>
            
            <aside id="sidebar-left" class="sidebar-circle">

                <!-- Start left navigation - profile shortcut -->
                <div class="sidebar-content">
                    <div class="media">
                        <a class="pull-left has-notif avatar" href="page-profile.html">
                            <img src="http://img.djavaui.com/?create=50x50,4888E1?f=ffffff" alt="admin">
                            <i class="online"></i>
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading">Hello, <span>Lee</span></h4>
                            <small>Web Designer</small>
                        </div>
                    </div>
                </div><!-- /.sidebar-content -->
                <!--/ End left navigation -  profile shortcut -->

                <!-- Start left navigation - menu -->
                <ul class="sidebar-menu" tabindex="0" style="height: 96px; overflow: hidden; outline: none;">

                    <!-- Start navigation - dashboard -->
                    <li>
                        <a href="dashboard.html">
                            <span class="icon"><i class="fa fa-home"></i></span>
                            <span class="text">Dashboard</span>
                        </a>
                    </li>
                    <!--/ End navigation - dashboard -->

                    <!-- Start category admin -->
                    <li class="sidebar-category">
                        <span>ADMIN AREA</span>
                        <span class="pull-right"><i class="fa fa-server"></i></span>
                    </li>
                    <!--/ End category admin -->

                    <!-- Start navigation - admin system -->
                    <li class="submenu active">
                        <a href="javascript:void(0);">
                            <span class="icon"><i class="fa fa-user"></i></span>
                            <span class="text">Admin System</span>
                            <span class="arrow"></span>
                            <span class="selected"></span>
                        </a>
                        <ul>
                            <li class="active"><a href="admin-system-quick-access.html">Quick Access</a></li>
                            <li><a href="admin-system-company-structure.html">Company Structure</a></li>
                            <li><a href="admin-system-job-detail-setup.html">Job Details Setup</a></li>
                            <li><a href="admin-system-qualification-setup.html">Qualifications Setup</a></li>
                            <li><a href="admin-system-projects-clients-setup.html">Projects/Clients Setup</a></li>
                            <li><a href="admin-system-company-loans.html">Company Loans</a></li>
                        </ul>
                    </li>
                    <!--/ End navigation - admin system -->

                    <!-- Start navigation - admin reports -->
                    <li>
                        <a href="admin-system-reports.html">
                            <span class="icon"><i class="fa fa-file"></i></span>
                            <span class="text">Admin Reports</span>
                        </a>
                    </li>
                    <!--/ End navigation - admin reports -->

                    <!-- Start category hr structure -->
                    <li class="sidebar-category">
                        <span>HR STRUCTURE</span>
                        <span class="pull-right"><i class="fa fa-users"></i></span>
                    </li>
                    <!--/ End category hr structure -->

                    <!-- Start navigation - employees -->
                    <li class="submenu">
                        <a href="javascript:void(0);">
                            <span class="icon"><i class="fa fa-user"></i></span>
                            <span class="text">Employees</span>
                            <span class="arrow"></span>
                        </a>
                        <ul>
                            <li><a href="hr-structure-employee-list.html">Employee List</a></li>
                            <li><a href="hr-structure-monitor-attendance.html">Monitor Attendance</a></li>
                        </ul>
                    </li>
                    <!--/ End navigation - employees -->

                    <!-- Start navigation - finance -->
                    <li class="submenu">
                        <a href="javascript:void(0);">
                            <span class="icon"><i class="fa fa-money"></i></span>
                            <span class="text">Finance</span>
                            <span class="arrow"></span>
                        </a>
                        <ul>
                            <li><a href="hr-structure-finance-salary.html">Salary</a></li>
                            <li><a href="hr-structure-finance-loans.html">Loans</a></li>
                        </ul>
                    </li>
                    <!--/ End navigation - finance -->

                    <!-- Start navigation - time management -->
                    <li class="submenu">
                        <a href="javascript:void(0);">
                            <span class="icon"><i class="fa fa-clock-o"></i></span>
                            <span class="text">Time Management</span>
                            <span class="arrow"></span>
                        </a>
                        <ul>
                            <li><a href="hr-structure-time-management-projects.html">Projects</a></li>
                            <li><a href="hr-structure-time-management-attendance.html">Attendance</a></li>
                            <li><a href="hr-structure-time-management-time-sheets.html">Time Sheets</a></li>
                        </ul>
                    </li>
                    <!--/ End navigation - time management -->

                    <!-- Start navigation - travel management -->
                    <li>
                        <a href="hr-structure-travel-management.html">
                            <span class="icon"><i class="fa fa-plane"></i></span>
                            <span class="text">Travel Management</span>
                        </a>
                    </li>
                    <!--/ End navigation - travel management -->

                    <!-- Start category additional option -->
                    <li class="sidebar-category">
                        <span>ADDITIONAL OPTION</span>
                        <span class="pull-right"><i class="fa fa-plus"></i></span>
                    </li>
                    <!--/ End category additional option -->

                    <!-- Start navigation - subordinates -->
                    <li>
                        <a href="additional-option-subordinates.html">
                            <span class="icon"><i class="fa fa-support"></i></span>
                            <span class="text">Subordinates</span>
                        </a>
                    </li>
                    <!--/ End navigation - subordinates -->

                    <!-- Start navigation - system -->
                    <li class="submenu">
                        <a href="javascript:void(0);">
                            <span class="icon"><i class="fa fa-cogs"></i></span>
                            <span class="text">System</span>
                            <span class="arrow"></span>
                        </a>
                        <ul>
                            <li><a href="additional-option-system-general.html">General</a></li>
                            <li><a href="additional-option-system-users.html">Users</a></li>
                            <li><a href="additional-option-system-manage-modules.html">Manage Modules</a></li>
                            <li><a href="additional-option-system-manage-permissions.html">Manage Permissions</a></li>
                            <li><a href="additional-option-system-manage-metadata.html">Manage Metadata</a></li>
                        </ul>
                    </li>
                    <!--/ End navigation - system -->

                </ul><!-- /.sidebar-menu -->
                <!--/ End left navigation - menu -->

                <!-- Start left navigation - footer -->
                <div class="sidebar-footer hidden-xs hidden-sm hidden-md">
                    <a id="setting" class="pull-left" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-title="Setting" data-original-title="" title=""><i class="fa fa-cog"></i></a>
                    <a id="fullscreen" class="pull-left" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-title="Fullscreen" data-original-title="" title=""><i class="fa fa-desktop"></i></a>
                    <a id="lock-screen" data-url="lock-screen.html" class="pull-left" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-title="Lock Screen" data-original-title="" title=""><i class="fa fa-lock"></i></a>
                    <a id="logout" data-url="index.html" class="pull-left" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-title="Logout" data-original-title="" title=""><i class="fa fa-power-off"></i></a>
                </div><!-- /.sidebar-footer -->
                <!--/ End left navigation - footer -->

            <!--<div id="ascrail2000" class="nicescroll-rails" style="width: 10px; z-index: 200; cursor: default; position: absolute; top: 85.9896px; left: 0px; height: 97px; opacity: 0;"><div style="position: relative; top: 0px; float: right; width: 10px; height: 467px; background-color: rgb(66, 66, 66); border: 0px; background-clip: padding-box; border-radius: 5px;"></div></div><div id="ascrail2000-hr" class="nicescroll-rails" style="height: 10px; z-index: 200; top: 172.99px; left: 0px; position: absolute; cursor: default; opacity: 0; display: none; width: 210px;"><div style="position: absolute; top: 0px; height: 10px; width: 220px; background-color: rgb(66, 66, 66); border: 0px; background-clip: padding-box; border-radius: 5px; left: 10px;"></div></div></aside>-->
            <?php if(isset($_SESSION['modulo_ID'])){?>
            
            <ul id="menu_principal" class="nav nav-tabs" style="background-color:<?php echo $_SESSION['color']?>" >
                <?php
                    require ROOT_PATH."/lib/menu.php";				
                ?>
            </ul>
            <?php } ?>
        </header>
    </div>
    <div id="contenedor_pantalla" class="container" style="width:100%;padding:0;">
        <div id="pantalla" class="pantalla">
            <div id="main" style="height: 100%;">	
                <div class="cuerpo_principal">
                    <div id="divContent" style="height:500px;">
                                    <!--Pághina-->
                        <div id="divContent-page">
                                <?php						
                                    fncPage();
                                ?>
                        </div>		
                    </div>
                </div>    
            </div> 
        </div>
	  
    </div>
     <div style="display:none" id="dialog-confirm" ></div>
    <footer class="bg-faded" style="background: #000;position:fixed;bottom:0;width:100%;z-index:4;">
    <!--Copyright-->
        <div class="bg-inverse text-white footer-copyright">
            <div style="color:#fff;text-align: center;">
                © <?php echo date("Y")?> Copyright:Soluciones Informáticas M&M S.R.L.  página web:<a href="http://www.simm.com.pe" style="color:#fff;"> www.simm.com.pe</a>

            </div>
        </div>
    <!--/.Copyright-->

    </footer>
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
    <div id="float_modal" class="modal fade modal-success" data-backdrop="static" data-keyboard="false" role="dialog">
        <div class="modal-dialog">

           <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" onclick="float_close_modal();">&times;</button>
                  <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">

                </div>

            </div>

        </div>
   </div>
  
   <div id="float_modal_hijo" class="modal fade modal-info" data-backdrop="static"  data-keyboard="false" role="dialog">
        <div class="modal-dialog">

           <!-- Modal content-->
           <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" onclick="float_close_modal_hijo();">&times;</button>
                  <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">

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
    <script type="text/javascript">
    /*$("#float_modal").on('hidden.bs.modal',function(){
        //$("#float_modal .modal-body").html("");
    });
    $("#float_modal_hijo").on('hidden.bs.modal',function(){
        $("#float_modal").modal("show");
    });
    $("#float_modal_hijo_hijo").on('hidden.bs.modal',function(){
        $("#float_modal_hijo").modal("show");
    });*/
    $('.nav-tabs a').click(function(){
        $(this).tab('show');
        
    })
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

</body>
</html>