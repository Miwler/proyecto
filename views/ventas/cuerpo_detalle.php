<?php
require ROOT_PATH . "views/shared/content-impresion.php";
?>	
<?php

function fncTitle() { ?><?php } ?>

<?php

function fncHead() { ?>
    <script type="text/javascript" src="include/js/jquery-2.1.0.min.js" ></script>
    <script type="text/javascript" src="include/js/jForm.js"></script>
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
   
        <form id="form" method="POST" style="width: 806px;    margin: 0 auto;"  action="/Ventas/cuerpo_detalle">
           <table style="margin-bottom:30px;">
                <tr>
                    <td>
                       
                    </td>
                </tr>
                <tr>
                    <td>
                        
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="cuerpo">
                            <tr>
                                <th width="85.4px" style='height:23.3px;'><span class="titulo_cuerpo">CANT.</span></th>
                                <th width="524.3px"><span class="titulo_cuerpo">DESCRIPCION</span></th>
                                <th width="81.6px"><span class="titulo_cuerpo">U. MEDIDA</span></th>
                                <th width="110.7px"><span class="titulo_cuerpo">PESO TOTAL</span></th>
                            </tr>
                            <tr>
                                <td style="height:4px;"></td>
                                <td style="height:4px;"></td>
                                <td style="height:4px;"></td>
                                <td style="height:4px;"></td>
                            </tr>
                           
                            <tr style='height: 500.4px;' id="contenedor_productos" >
                                <td colspan="4" id="tdproductos" style="text-align: justify;">
                                    <?php echo $GLOBALS['html'];?>
                                </td>
                            </tr>
                           
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                       
                    </td>

                </tr>
            </table>
        
            <style>
                .titulo_cabecera{
                    font-size:10px;
                    height: 15.5px;
                    text-align: center;
                    background:#A9A9A9;
                }
                .titulo_cabecera span{
                    display:inline-block;
                    vertical-align:middle;
                }
                #cabecer td,#cabecer span{font-size:10px;}
                .contenido_cabecera{
                    font-size:10px;
                }
                .textocabecera span{ font-size:10px;display:inline-block;
                    vertical-align:middle;}
                .info_Guia{
                    
                }
                .info_Guia td{
                    border:1px solid #000;
                    font-size:10px;
                }
                .spantitulo{
                    display: block;
                    
                    text-align: center;
                }
                .titulo_cuerpo{
                    font-size:11px;
                    font-weight: bold;
                    
                }
                .cuerpo th{
                    text-align:center;
                    border:1px solid #000;
                }
                .cuerpo td{
                    border:1px solid #000;
                    font-size:10px;
                    vertical-align:top;
                }
                .pie_guia td{ 
                border:1px solid #000;
                }
                .contenido_pie{
                   
                  
                    
                }
                .titulo_pie{
                    font-weight:bold;
                    
                    background:#A9A9A9;
                    font-size:10px;
                    text-align:center;
                    height: 15.5px;
                    vertical-align: middle;
                    padding-top: 2px;
                }
                .marcar{
                    border:1px solid #000;
                    height:11.7px;
                    width:11.7px;
                    display:block;
                }
                .opciones_marca td{
                    font-size:7px;
                    border:none;
                }
                .contenido_pie span{
                    font-size:10px;
                }
                .separaciones{
                    border:#fff!important;
                }
                .transportista td{
                    border:none;
                    font-size:7px;
                }
            </style>
        </form>
<script>
        $(document).ready(function(){
           
                   //var iframe = document.getElementById('vista');
                    var tabla= document.getElementById('tablaproducto');
                    var nFilas =tabla.rows.length;
                    var alto=tabla.offsetHeight;
                
                    //var contenedor=iframe.contentWindow.document.getElementById('contenedor_productos');
                    var altocontenedor=500;//524
                    var altostd=0;
                    var numero_pagina=0;
                    var nproductoxhoja="";
                    var suma=0;
                    var nproducto=0;
                    var n=0;
                    //var y=0;
                    //alert(nFilas);
                    for (i = 1; i <= nFilas; i++) { 

                        var td=document.getElementById('td'+i);
                        var altotd=td.offsetHeight;

                        altostd=altostd +altotd;
                      // alert(altostd);
                            // 1000>=500
                        if(altostd>=altocontenedor){
                            if(i==nFilas){
                                if(n>0){
                                    nproductoxhoja=nproductoxhoja+n+'/';
                                    numero_pagina=numero_pagina+1;
                                    //nproducto=1;
                                    //n=0;
                                }
                                nproducto=1;
                                nproductoxhoja=nproductoxhoja+nproducto;
                                numero_pagina =numero_pagina + 1;
                               
                            }else {
                                if(n>0){
                                    
                                    nproductoxhoja=nproductoxhoja+n+'/';
                                    numero_pagina=numero_pagina+1;
                                    nproducto=1;
                                    n=1;
                                    altostd=altotd;
                                }else {
                                    nproducto=1;
                                    nproductoxhoja=nproductoxhoja+nproducto+'/';
                                    //numero_pagina =numero_pagina + 1;
                                    altostd=0;
                                }
                                //numero_pagina =numero_pagina + 1;
                            }
                           
                            
                            
                        }else{
                            n=n+1;
                            
                            if(i==nFilas){
                          
                            nproducto=nproducto+1;
                            nproductoxhoja=nproductoxhoja+n;
                            numero_pagina =numero_pagina + 1;
                            }
                        }
                        //nproducto=nproducto+1;
                       
                    }
                    
                   //alert("numeropagin"+numero_pagina);
                    fncGuardarDatos(numero_pagina,nproductoxhoja);
});
 var fncGuardarDatos=function(val1,val2){
       
    seleccionarCk('/Ventas/ajaxOrden_Venta_Grabar/<?php echo $GLOBALS['oOrden_Venta']->ID;?>',val1,val2);
}
</script>
    <?php } ?>
<?php } ?>
