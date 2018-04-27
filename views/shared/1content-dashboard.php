<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width" />
        
	<title>
		<?php  fncTitle(); echo " - SGL" ?>
	</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<base href="<?php echo DOMAIN_BASE; ?>">
	<link type="image/x-icon" href="include/img/empresa/1.png" rel="icon" /> 

	<link rel="stylesheet" type="text/css" href="include/css/estilos.css" />
	<link rel="stylesheet" type="text/css" href="include/css/controles.css" />
	<link rel="stylesheet" type="text/css" href="include/css/menu.css" />
        <link rel="stylesheet" type="text/css" href="include/css/font-awesome.css" />


	<script type="text/javascript" src="include/js/jquery-2.1.0.min.js" ></script>
	<script type="text/javascript" src="include/js/jTeclas.js" ></script>
	<script type="text/javascript" src="include/js/jscript.js" ></script>
	<script type="text/javascript" src="include/js/logincerrar.js" ></script>
	<!--<script type="text/javascript" src="include/js/jMenu.js" ></script>-->
        <script type="text/javascript" src="include/js/functionmenu.js" ></script>
        <script type="text/javascript" src="include/js/jMenu.js" ></script>
        
        <script type="text/javascript" src="include/chart/Chart.bundle.js" ></script>
        <script type="text/javascript" src="include/chart/utils.js" ></script>
        <script type="text/javascript" src="include/js/jcuadros.js" ></script>
        
       
         <script src="include/js/jquery-ui-1.12.1/jquery-ui.js"></script>
	<?php  fncHead();	?>
    <style>
    canvas {
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
    }
    </style>
</head>
<body>
   
    <div id="contenedor_pantalla" class="contenedor_pantalla">
      <div id="pantalla" class="pantalla">
       <!-- Menu Contextual-->
     <div id="menu_mouse_right" style="display:block;">
        <ul id="ulMenu_contextual">            
        </ul>
     </div>
	<!-------->
	
	
	<div id="main">	
            <header>
                <div class="inner relative">
                    <a id="menu-toggle" class="button dark" href="#"><i class="icon-reorder"></i></a>
                    <div class="contenedor_cabmenu" style="background: #FFF;">
                        <div id ="divHeader">
                            <img src="include/img/logo.jpg" width="150px"/>
                                <?php
                                        require ROOT_PATH."/lib/header.php";				
                                ?>	
                        </div>
                    </div>
                    <div class="contenedor_menu">
                        <nav id="navigation" class="inner relative" >
                            <div id="divMenu" >
                                    <?php
                                            require ROOT_PATH."/lib/menu.php";				
                                    ?>			
                                    <div class="clear"></div>
                            </div>               
                        </nav>
                    </div>
                </div>
            </header>
            <div class="cuerpo_principal">
		<div id="divContent" style="height:500px;">
				<!--Pághina-->
			<div id="divContent-page">
                           <script>
                           var color = Chart.helpers.color;
                           </script>
				<?php						
					fncPage();
				?>
			</div>		
		</div>
            </div>    
	</div> 
    </div>
	  
    </div>
   
    <div id="contenedoFotter" class="contenedoFotter">
       <div id="divFooter">&copy; copyrigth<div id="createdBy">Created by <a href="http://www.simm.com.pe" target="_blank">Soluciones Informáticas M&M</a></div></div>

    </div>
    <div id="toastem"></div>
    <div id="script"></div>
</body>
</html>