<?php		
	require ROOT_PATH."views/shared/content-float-modal-hijo.php";	
?>	
<?php function fncTitle(){?>IMPORTAR COTIZACIONES<?php } ?>

<?php function fncHead(){?>

	<script type="text/javascript" src="include/js/jForm.js"></script>

        <script type="text/javascript" src="include/js/jGrid.js"></script>

        <script>
            $(document).ready(function(){
                /*if(typeof($('#txtProducto_ID').val())!="undefined"){
                    fncListaProductosVendidos($('#txtProducto_ID').val());
                }*/
            $('#txtRegSeries').focus();
            });
            
        </script>
	
<?php } ?>

<?php function fncTitleHead(){?>IMPORTAR COTIZACIONES<?php } ?>

<?php function fncMenu(){?>
<?php } ?>

<?php function fncPage(){?>

 
 <form id="frm2"  class="divRegistrarSeries" method="post" action="/Ventas/ajaxOrden_Venta_Mantenimiento_Importar_Cotizacion" class="form-horizontal">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <div class="col-md-1 col-lg-1 col-xs-1 col-md-1">
                    <label>Cliente:</label>
                </div>
                <div class="col-md-3 col-lg-3 col-xs-3 col-md-3">
                    <input type='text' id="txtBuscar" name="txtBuscar"  class="form-control" placeholder="Ingrese la razon social del cliente">
                </div>
                <div class="col-md-2 col-lg-2 col-xs-2 col-md-2">
                    <label>N&uacute;mero::</label>
                </div>
                <div class="col-md-2 col-lg-2 col-xs-2 col-md-2">
                    <input type='text' id='txtNumero' name='txtNumero' class='int form-control'>
                </div>
                <div class="col-md-1 col-lg-1 col-xs-1 col-md-1">
                    <label>Mostrar::</label>
                </div>
                <div class="col-md-1 col-lg-1 col-xs-1 col-md-1">
                    <input id="txtMostrar" name="txtMostrar" type="text"  class="int form-control" value="30" >
                </div>
                <div class="col-md-2 col-lg-2 col-xs-2 col-md-2">
                    <button id="btnBuscar" name="btnBuscar" type="button" title="Buscar" class="btn btn-primary" onclick="fmC.enviar();">
                        <span class="glyphicon glyphicon-search"></span>Buscar
                    </button>
                </div>
            </div>
            <div class="form-group">
                <div id="divCotizaciones" class="col-md-12 col-lg-12 col-xs-12 col-md-12" style='height: 460px; overflow:auto;'>

                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-xs-12 col-md-12">
                    <button id="btnRegresar" type="button" title="Cancelar"  class="btn btn-danger" onclick="fncRegresar();">
                        <span class="glyphicon glyphicon-ban-circle"></span>
                        Cancelar
                    </button>
                </div>
            </div>
         </div>
    </div>
    
    <input id="num_page" name="num_page" type="text" value="1" style="display: none;" >
    <input id="txtOrden" name="txtOrden" type="text" style="display: none;" >
    <input id="chkOrdenASC" name="chkOrdenASC" type="checkbox" style="display: none;" >
</form>
   <script type="text/javascript">


    var fmC=new form('frm2','divCotizaciones');
        var grids;

        fmC.terminado=function(){
            var tb = document.getElementById(this.Div.id).getElementsByClassName('grid')[0];

            grids = new grid(tb);
            grids.nuevoEvento();
            
            grids.fncPaginacion1(fmC);
            
        }

        var fncOrden=function(col){
                var col_old=$('#txtOrden').val();

                if(col_old==col){
                        if($('#chkOrdenASC').is(':checked')){
                                $('#chkOrdenASC').prop('checked',false);
                        }else{
                                $('#chkOrdenASC').prop('checked',true);
                        }
                }else{
                        $('#txtOrden').val(col);
                        $('#chkOrdenASC').prop('checked',true);
                }
                fmC.enviar();
        }
        fmC.enviar();
    $('#txtBuscar,#txtMostrar,#txtNumero').keypress(function(e){

    if (e.which==13){
            $('#num_page').val(1);
            fmC.enviar();
            return false;
    }
    });	  
    var fncRegresar=function(){
        parent.float_close_modal_hijo();
    }
    var fncVender=function(id){
        //alert(id);
        $('#divCotizaciones').html('<div style="background:#000;opacity:0.7;width:100%;height:100%;text-align:center;" ><img width="100px" src="/include/img/loader-Login.gif"></div>');
        cargarValores('/Ventas/ajaxExtraerCotizacion',id,function(Result){
          
          if(Result.resultado==1){
              toastem.info('La importación se realizó correctamete.');
             
              setTimeout('parent.windos_float_save_modal_hijo('+Result.orden_venta_ID+');', 1000);
          }else {
              
                mensaje.error("OCURRIÓ UN ERROR",Result.mensaje);
                fmC.enviar();
          }
       });


    }

    </script>
 
    <?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==-1){ ?>
    <div id="divMensaje"></div>
        <script type="text/javascript">
            
        $('#divMensaje').html(' <?php  echo $GLOBALS['mensaje']; ?>');
           
        </script>
    <?php } ?>
    <?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==1){ ?>

    <script type="text/javascript">
    
    $(document).ready(function () {
            
        toastem.success('<?php echo $GLOBALS['mensaje']; ?>');
    });
    //$('#btnRegresar img').attr('src','/include/img/boton/salir1_48x48.png');
    setTimeout('window_deslizar_save();', 1000);
    </script>
    <?php } ?>

   <?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==0){ ?>
        <div class="float-mensaje">
             <?php  echo $GLOBALS['mensaje']; ?>
        </div>
        <div class="group-btn">
            <input type="button" onclick ="redireccionar_parent('/');" value ="Iniciar Sesión"/>
        </div>
    <?php } ?>    
<?php } ?>
