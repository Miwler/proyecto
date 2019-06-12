<html>
<head>
	<!--<title>
		
	</title>-->
	<base href="<?php echo DOMAIN_BASE; ?>">
	
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <script type="text/javascript" src="include/js/jquery-2.1.0.min.js" ></script>
        <link href="../../include/jquery-ui-1.12.1/jquery-ui.css" rel="stylesheet" type="text/css"/>
        <script src="../../include/jquery-ui-1.12.1/jquery-ui.js" type="text/javascript"></script>
        <link href="../../include/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <script src="../../include/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        
        <script src="../../include/dropzone/dropzone.js" type="text/javascript"></script>
        <link href="../../include/dropzone/dropzone.css" rel="stylesheet" type="text/css"/>
        
	<link rel="stylesheet" type="text/css" href="include/css/estilos-float.css" />
	<link rel="stylesheet" type="text/css" href="include/css/controles.css" />
	<script src="include/jquery-ui-1.12.0/jquery-ui.js"></script>
        <link href="../../include/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        
        <link href="../../include/bootstrap-dialog/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css"/>
        <script src="../../include/bootstrap-dialog/js/bootstrap-dialog.min.js" type="text/javascript"></script>
        <link href="../../include/jquery-ui-1.12.1/jquery-ui.css" rel="stylesheet" type="text/css"/>
	
	
     
        
        <script src="include/js/jMensajes.js"></script>
       
	<script type="text/javascript" src="include/js/jscript-float1.js" ></script>
	<script type="text/javascript" src="include/js/jTeclas.js" ></script>
        
	
	<script type="text/javascript" src="include/js/jFunc.js" ></script>
         <script type="text/javascript" src="include/js/jControles.js" ></script>
        <script type="text/javascript" src="include/js/toastem.js" ></script>
        <script type="text/javascript" src="include/js/jModal.js"></script>
       <link href="../../include/css/toastem.css" rel="stylesheet" type="text/css"/>
	<script type="text/javascript" >		
        var fParent2= parent.fParent2;   
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
	</script>
	<?php  fncHead();	?>
</head>
<body>
	<div id="main">
            <h1 class="titulo_Formulario">
                <?php  fncTitleHead(); ?>
            </h1>
		
		<div id="content-float" style="width:100%">		
			<?php
				fncPage();
			?>					
			
		</div>		
	</div>
   
    <div id="windows_float_deslizador_hijo"></div>
    <div id="toastem"></div>
    <div id="fondo_espera" style="background:#000;opacity:0.7;width:100%;height:100%;z-index: 56;text-align:center;top:0;position:absolute; display:none;" ><img width="80px" src="/include/img/loader-Login.gif"></div>
   
	<div id="script"></div>
        <div id="dialog-confirm"></div>
        <script type="text/javascript">
            var anchoFloat=window.parent.parent.document.getElementById('iwindow-float1').style.width;
            var altoFloat=window.parent.parent.document.getElementById('iwindow-float1').style.height;
            //var anchopestanas=$('#tab').width();
           // var altopestanas=$('#tab').height()+50;
            $('body').width(anchoFloat);
            $('body').height(altoFloat);
            
               /*if(anchopestanas!=null){
                  
                    $('body').width(anchopestanas);
               }
               if(altopestanas!=null){
                  
                    var altoTabs=altopestanas;
                    $('body').height(altoFloat);
               }
            /*$('body').width(100%);
            $('body').height(100%);*/
            
        </script>
</body>
</html>