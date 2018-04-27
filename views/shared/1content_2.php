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
<body class="page-sound page-header-fixed page-sidebar-fixed page-footer-fixed">
    <section id="wrapper">
        <header>
            <div class="header-left">
                
            </div>
            <div class="header-left">
                
            </div>
        </header>
        <aside id="sidebar-left" class="sidebar-circle">
            
        </aside>
        <section id="page-content">
            <div class="header-content">
                
            </div>
            <div class="body-content animated fadeIn">
                <?php						
                    fncPage();
                ?>
            </div>
        </section>
    </section>
    <div>
        
    </div>
    <div id="contenedor_pantalla" class="container" style="width:100%;padding:0;">
        <div id="pantalla" class="pantalla">
            <div id="main" style="height: 100%;">	
                <div class="cuerpo_principal">
                    <div id="divContent" style="height:500px;">
                                    <!--Pághina-->
                        <div id="divContent-page">
                                
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