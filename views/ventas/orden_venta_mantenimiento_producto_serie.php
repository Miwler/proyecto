<?php		
	require ROOT_PATH."views/shared/content-float-modal-hijo.php";	
?>	
<?php function fncTitle(){?>Registro de Serie<?php } ?>

<?php function fncHead(){?>

	<script type="text/javascript" src="include/js/jForm.js"></script>
        

        <script>
            $(document).ready(function(){
                /*if(typeof($('#txtProducto_ID').val())!="undefined"){
                    fncListaProductosVendidos($('#txtProducto_ID').val());
                }*/
            $('#txtRegSeries').focus();
            });
            
        </script>
	
<?php } ?>

<?php function fncTitleHead(){?>Registro de Serie<?php } ?>

<?php function fncMenu(){?>
<?php } ?>

<?php function fncPage(){?>
    <?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1){ ?>
<form id="frm2"  class="divRegistrarSeries"  method="post" action="/Ventas/Orden_Venta_Mantenimiento_Producto_Serie/<?php echo $GLOBALS['oOrden_Venta_Detalle']->ID;?>" onsubmit="return validar();" class="form-horizontal">
    <div class="panel panel-<?php echo $_SESSION['cabecera'];?>">
        <div class="panel-heading">
            <div class="form-group">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <label>Producto:</label>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <?php echo FormatTextView($GLOBALS['oOrden_Venta_Detalle']->oProducto->nombre);?>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <label>Cantidad:</label>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <?php echo $GLOBALS['oOrden_Venta_Detalle']->cantidad;?>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <label>Ingrese la serie:</label>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <input type="text" id="txtRegSeries" name="txtRegSeries"  autocomplete="off" class="form-control" >
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                    <button id="btnMP" type="button" class="btn btn-success" title="Registrar series" onclick="fncRegistrarSeries($('#txtRegSeries').val());" >
                        <img src="/include/img/boton/serie.png"  />
                    </button>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <div class="ckbox ckbox-theme">
                        <input  type="checkbox" id="ckSecuencia" checked class="seleccionar"  name="ckSecuencia" value="ckSecuencia">
                        <label for="ckSecuencia">Secuencia</label>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <div class="ckbox ckbox-theme">
                        <input  type="checkbox" id="ckDetalle" class="seleccionar" name="ckDetalle" value="ckDetalle">
                        <label for="ckDetalle">Detalle</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 grid_detalle" style="height: 350px;overflow:auto;">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th colspan="2">Action</th>
                                <th style="width:40px">Nro.</th>
                                <?php if($GLOBALS['oOrden_Venta_Detalle']->internos>0){?>
                                <th>Tipo</th>
                                <th>Descripción</th>
                                <?php } ?>
                                <th>Serie</th>
                                <th>Factura V.</th>
                                <th>Gu&iacute;a V.</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=1;?>
                        <?php foreach($GLOBALS['oOrden_Venta_Detalle']->dtInventario as $item){?>
                            <tr class="item-tr">
                                <td>
                                     <a title="Editar"  onclick="fncEditar(<?php echo $item['ID'] ?>);"><img src="/include/img/boton/edit_14x14.png"/> Editar</a>
                                </td>
                                <td>
                                     <a title="Eliminar" onclick="fncEliminar(<?php echo $item['ID'] ?>);"><img src="/include/img/boton/delete_14x14.png" /> Eliminar</a>
                                </td>
                                <td class="tdCenter"><?php echo $i;?></td>
                                <?php if($GLOBALS['oOrden_Venta_Detalle']->internos>0){?>
                                <td><?php echo $item['tipo'];?></td>
                                <td><?php echo FormatTextView($item['producto']);?></td>
                                <?php } ?>
                                <td class="tdLeft"><input type="text" id="<?php echo $item['ID'] ?>" name="<?php echo $item['ID'] ?>" value="<?php echo $item['serie']?>" style="display:none;"><span id="span<?php echo $item['ID'] ?>"><?php echo $item['serie'] ?></span></td>
                                <td class="tdCenter"><?php echo $item['numero_orden_venta']?></td>
                                <td class="tdCenter"><?php echo $item['numero_factura_venta']?></td>

                            </tr>
                        <?php $i++;?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button  id="btnEnviar" name="btnEnviar" class="btn btn-success" title="Guardar">
                        <span class="glyphicon glyphicon-floppy-disk"></span>
                        Guardar
                    </button>
                    <button id="btnRegresar" type="button" title="Cancelar"  class="btn btn-danger" onclick="parent.float_close_modal_hijo();">
                        <span class="glyphicon glyphicon-ban-circle"></span>
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
			
</form>
<script type="text/javascript">


    $("#txtRegSeries").keypress(function(e){
        if(e.which==13){
            fncRegistrarSeries($("#txtRegSeries").val());
        }
    });

    $('.grid_detalle input').keyup(function(){
        $('#span'+this.id).html($(this).val());
    });
     var fncRegistrarSeries=function(serie){
         var valor=$('.seleccionar').val();
         var i=0;
         $('.grid_detalle tr :input').each(function(){
             var serie_reg=this.value;
             if($.trim(serie_reg)!=""){
                if(serie_reg==$.trim(serie)){
                   
                   i++;
                }
             }
             
         });
         if(i==0){
             if(valor=="ckSecuencia"){
                 $('.grid_detalle tr :input').each(function(){
                     if($.trim($(this).val())==''){
                         $(this).val(serie);

                         $('#span'+ this.id).html(serie);
                         $('#txtRegSeries').val('');
                         $('#txtRegSeries').focus();
                         return false;
                     }
                 }); 
             }
          }else {
             mensaje.advertencia("VALIDACIÓN DE SERIE",'Ya existe una serie igual.');
             $('#txtRegSeries').val('');
             $('#txtRegSeries').focus();
             return false;
         }
     }
     var fncEditar=function(id){
         if($('#'+id).is(':visible')){
             $('#'+id).css('display','none');
             $('#span'+id).css('display','block');
         }else {
             $('#'+id).css('display','block');
             $('#span'+id).css('display','none');
             $('#'+id).focus();
         }

     }
     var fncEliminar=function(id){
         $('#'+id).val('');
         $('#span'+id).html('');
     }
     var fncRegresar=function(){
       window_deslizar_save();
     }
    $('#txtRegSeries').change(function(){

        fncRegistrarSeries($('#txtRegSeries').val());
    });

   $('.seleccionar').click(function(index){
      
       if(this.value=='ckSecuencia'){
           $('#ckDetalle').prop('checked',false);
           $.each($('.grid_detalle input[type=text]'),function(){

               $(this).css('display', 'none');
           });
           $('.grid_detalle span').each(function(){
               $(this).css('display', 'block');
           });
       }else {
           $('#ckSecuencia').prop('checked',false);
            $('.grid_detalle input').each(function(){
               $(this).css('display', 'block');
           });
           $('.grid_detalle span').each(function(){
               $(this).css('display', 'none');
             });
       }
   });
   var validar=function(){
        $('#fondo_espera').css('display','block');
    }
 </script>
    <?php } ?>
 


 
    <?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==-1){ ?>
    
        <script type="text/javascript">
            
        $(document).ready(function () {
            
            toastem.error('<?php echo $GLOBALS['mensaje']; ?>');
        });
           
        </script>
    <?php } ?>
    <?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==1){ ?>

    <script type="text/javascript">
    
    $(document).ready(function () {
            
        toastem.success('<?php echo $GLOBALS['mensaje']; ?>');
        setTimeout('parent.windos_float_save_modal_hijo();', 1000);
    });

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
