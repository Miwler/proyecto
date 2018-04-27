<?php
require ROOT_PATH . "views/shared/content-impresion.php";
?>	
<?php

function fncTitle() { ?>Guia de Remision<?php } ?>

<?php

function fncHead() { ?>
    <link rel="stylesheet" type="text/css" href="include/css/cbo.css" />
    <link href="include/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<?php } ?>

<?php

function fncTitleHead() { ?>Vista previa Guia de Remision<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>
    <?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1) { ?>
   
        <form id="form" method="POST" style="width: 700px;    margin: 0 auto;"  action="/Cotizacion/cuerpo_detalle">
            
        <?php echo $GLOBALS['cuerpoHTML']; ?>
                
           
        </form>
<style type="text/css">
    @font-face
        {
           font-family: "calibri";
           src: url("include/font/calibri.ttf");
           src: url("include/font/calibri..eot?#amocristalab") format("embedded-opentype"),
                url("fuentefancy.woff") format("woff"),
                url("fuentefancy.ttf") format("truetype"),
                url("fuentefancy.svg#IDdelafuente") format("svg");
        }
        span{font-family: sans-serif;
        display:block;font-weight: normal;}
        .condiciones{
            font-size:10px;
            padding-left: 4px;
        }
        .presentacion{
            font-size:10px;
        }
        .presentacion_contenido{
            display:inline-block;
        }
        th{
           background: #99d959; 
           font-family: calibri;
           font-size:14px;
           padding: 5px 0;
        }
        .tablacontenido{
            border-collapse:collapse;
        }
       .tablacontenido th{
            border:1px solid #000;
        }
        .tablacontenido td{
            border:1px solid #000;
        }
        .tablacontenido span{
            font-size: 12px; 
            font-weight: bold; 
            padding-left: 4px;
        }
        .producto{
           text-transform:uppercase;
           font-size:12px;
           font-weight: bold;
           color:#413F3F;
        }
        td.celda{
            
            vertical-align:top;
        }
        .descripcion{
            font-weight: normal !important;
            font-size: 12px!important;
            text-align: left;
        }
        .contacto{
            font-size:10px;
            display:inline-block;
        }
    </style>
    <?php } ?>
<?php } ?>
