<html>
<head>
	<title>
		<?php  fncTitle(); ?>
	</title>
	<base href="<?php echo DOMAIN_BASE; ?>">
	
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <script type="text/javascript" src="include/js/jquery-2.1.0.min.js" ></script>
        
      
        <link href="../../include/jquery-ui-1.12.1/jquery-ui.css" rel="stylesheet" type="text/css"/>
        <script src="../../include/jquery-ui-1.12.1/jquery-ui.js" type="text/javascript"></script>
        <link href="../../include/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <script src="../../include/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        
        <script src="../../include/dropzone/dropzone.js" type="text/javascript"></script>
        <link href="../../include/dropzone/dropzone.css" rel="stylesheet" type="text/css"/>
        
        <link href="../../include/css/bootstrap-responsive-tabs.css.css" rel="stylesheet" type="text/css"/>
        <script src="../../include/js/jquery.bootstrap-responsive-tabs.min.js" type="text/javascript"></script>
        <!--<script src="../../include/stacktable/stacktable.js" type="text/javascript"></script>
        
	<link href="../../include/stacktable/stacktable.css" rel="stylesheet" type="text/css"/>-->
        
	
	
        <script src="include/jquery-ui-1.12.0/jquery-ui.js"></script>
        
       
       
	<script type="text/javascript" src="include/js/jscript-float1.js" ></script>
	<script type="text/javascript" src="include/js/jTeclas.js" ></script>
        
	<script type="text/javascript" src="include/js/jCboDiv.js" ></script>
	<script type="text/javascript" src="include/js/jFunc.js" ></script>
        <script type="text/javascript" src="include/js/jControles.js" ></script>
        <script type="text/javascript" src="include/js/toastem.js" ></script>
        <script type="text/javascript" src="include/js/jModal.js"></script>
        <link href="../../include/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        
        <link href="../../include/bootstrap-dialog/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css"/>
        <script src="../../include/bootstrap-dialog/js/bootstrap-dialog.min.js" type="text/javascript"></script>
         <link href="../../include/jquery-ui-1.12.1/jquery-ui.css" rel="stylesheet" type="text/css"/>
        <script src="../../include/js/jMensajes.js" type="text/javascript"></script>
        
        <!--Nuevos style
        
        <link href="../../assets/admin/css/angular-custom.css" rel="stylesheet" type="text/css"/>
        <link href="../../assets/admin/css/components.css" rel="stylesheet" type="text/css"/>
        <link href="../../assets/admin/css/custom.css" rel="stylesheet" type="text/css"/>
        <link href="../../assets/admin/css/layout.css" rel="stylesheet" type="text/css"/>
        <link href="../../assets/admin/css/material-custom.css" rel="stylesheet" type="text/css"/>
        <link href="../../assets/admin/css/plugins.css" rel="stylesheet" type="text/css"/>
        <link href="../../assets/admin/css/reset.css" rel="stylesheet" type="text/css"/>
        <link href="../../assets/admin/css/theme.css" rel="stylesheet" type="text/css"/>
        <link href="../../assets/admin/css/yii-custom.css" rel="stylesheet" type="text/css"/>
   
        <link href="../../assets/global/plugins/bower_components/chosen_v1.2.0/chosen.min.css" rel="stylesheet" type="text/css"/>
        <script src="../../assets/global/plugins/bower_components/chosen_v1.2.0/chosen.jquery.js" type="text/javascript"></script>
        <!---->
                
        
        <link rel="stylesheet" type="text/css" href="include/css/estilos-float.css" />
	<link rel="stylesheet" type="text/css" href="include/css/controles.css" />
	<link rel="stylesheet" type="text/css" href="include/css/cboDiv.css" />
	<link rel="stylesheet" type="text/css" href="include/css/toastem.css" />   
        
	<script type="text/javascript" >
        
        var fParent= parent.fParent;   
           //Bloquear Enter
        function stopRKey(evt) {
            var evt = (evt) ? evt : ((event) ? event : null);
            var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
            if ((evt.keyCode == 13) && (node.type=="text")) {return false;}
        }
        var bd_largo_decimal=<?php echo (defined('bd_largo_decimal')? bd_largo_decimal:0);?>;
        var bd_tipo_calculo_precio="<?php echo (defined('bd_tipo_calculo_precio')? bd_tipo_calculo_precio:0);?>";
       function getParameterByName(name) {
                name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                results = regex.exec(location.search);
                return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
            }
        $(document).ready(function(){
           $("form").each(function(){
              var metodo=$(this).attr("method");
              var action=$.trim($(this).attr("action"));
              if(metodo.toUpperCase()=='POST'&&action!=""){
                  var url_enviar_post=action+'?empresa_ID='+getParameterByName('empresa_ID');
                  $(this).prop('action',url_enviar_post);
              }
          });
        });
        $(function () {
            $('.moneda_redondeo').css('text-align', 'right'); 
            $('.moneda_redondeo').keypress(function (e) {
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
        $('.moneda_redondeo').click(function () {
            $(this).select();
        });    
    });
        document.onkeypress = stopRKey; 
	</script>
        <style>
            .ui-autocomplete {
                max-height: 200px;
                overflow-y: auto;
                /* prevent horizontal scrollbar */
                overflow-x: hidden;
                /* add padding to account for vertical scrollbar */
                padding-right: 20px;
            } 
        </style>
	<?php  fncHead();	?>
</head>
<body style="width:100%;">
    <div id="main">
        <div id ="divHeader">			
            <h1 class="title-principal"><?php  fncTitleHead(); ?></h1>
            <button id="btn-close"  title="Cerrar" onclick="window_float_close();" style="float:right;right:8px;" >
                <img alt="Cerrar" src ="../../include/img/boton/exit_48x48.png" />
            </button>			
        </div>
        <div id="content-float" style="width:100%" class="container">		
            <?php
                fncPage();
            ?>					
        </div>		
    </div>
    
    <div id="windows_float_deslizador"></div>
    <div id="toastem"></div>
    
    <div id="fondo_espera" style="background:#000;opacity:0.7;width:100%;height:100%;z-index: 56;text-align:center;top:0;position:absolute; display:none;" ><img width="80px" src="/include/img/loader-Login.gif"></div>
   
     <div style="display:none" id="dialog-confirm" ></div>
	<div id="script"></div>
       
    <script type="text/javascript">
        var anchoFloat=$('#content-float > form').width();
        var altoFloat=$('#content-float > form').height()+60;
        var anchopestanas=$('#tab').width();
        var altopestanas=$('#tab').height();

        var ocultarClose=function(){
            $('#btn-close').css('display','none');
        }   
        if (screen.width<1024){
        $('form').css('width','100%');
        $(window).on('load', function() {
            $('.responsive-tabs').responsiveTabs({
                accordionOn: ['xs', 'sm'] // xs, sm, md, lg
            });
        });//]]>
        }else if (screen.width<1280){
        //codigo resolución mediana 
        //$('#form').css('min-width','400px');
        }else {

        }
    </script>
</body>
</html>