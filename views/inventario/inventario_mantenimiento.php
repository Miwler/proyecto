<?php		
	require ROOT_PATH."views/shared/content.php";	
?>	
<?php function fncTitle(){?>
		Inventario de Productos
<?php } ?>
<?php function fncHead(){?>
         <script type="text/javascript" src="include/js/jForm.js"></script>
        <script type="text/javascript" src="include/js/jGrid.js"></script>

        <link rel="stylesheet" type="text/css" href="include/css/grid.css" />
                
<?php } ?>
<?php function fncTituloCabecera(){?>
        <i class="fa fa-cube"></i>Inventario de Productos
        <div class="pull-right">
            <a onclick="f.enviar();" class="btn btn-success btn-add-skills" >Actualizar &nbsp;<i class="fa fa-refresh"></i></a>
            <a onclick="fncNuevo();" class="btn btn-primary btn-add-skills" >Nuevo &nbsp;<i class="fa fa-plus"></i></a>
         </div>
<?php } ?>
<?php function fncMenu(){?>
<?php } ?>
<?php function fncPage(){?>

    <form id="frm1" name="frm1" method="post" action="/Inventario/ajaxInventario_Mantenimiento" class="form-horizontal">
        <div class="panel panel-tab panel-tab-double shadow">
        <div class="panel-heading no-padding">
            <ul class="nav nav-tabs">
                
                <li class="active nav-border nav-border-top-primary"><a href="#vista_buscar" data-toggle="tab"><i class="fa fa-search-plus" aria-hidden="true"></i> <div><span class="text-strong">Búsqueda</span></div></a></li>
               
            </ul>
            <div class="pull-right">
                <input id="txtMostrar" name="txtMostrar" type="number"  value="30"   class="form-control int text-center" autocomplete="off" >

            </div>
            
            
        </div>
        <div class="panel-body"> 
            <div class="tab-content">
                <div class="tab-pane in active" id="vista_buscar">
                    <div class="row">
                        <div class="col-md-3 col-lg-3 col-sm-3 col-xs-3">
                            <div class="form-group">
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right">
                                     <label>Código: </label>
                                </div>
                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                    <input type="number" id="txtCodigo" name="txtCodigo" class="form-control int"  autocomplete="off">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right">
                                     <label>Producto: </label>
                                </div>
                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                     <select id="selProveedor" name="selProducto" class="chosen-select">
                                        <option value="0">-TODOS-</option>
                                        <?php foreach($GLOBALS['dtProducto'] as $iProducto){?>
                                        <option value="<?php echo $iProducto['ID']?>"><?php echo FormatTextView(strtoupper($iProducto['producto']));?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                        </div>
                       
                    </div>

                </div>
            </div>
            <div class="row">
                <div id="div1" class="col-md-12 col-lg-12 col-sm-12 col-xs-12"></div>
            </div>
            <input id="num_page" name="num_page" type="text" value="1" style="display:none;">
            <input id="txtOrden" name="txtOrden" type="text" value="0" style="display:none;">
            <input id="chkOrdenASC" name="chkOrdenASC" type="checkbox"  style="display:none;">
               
           
        </div>
    </div> 

       
    </form>	
	
	<script type="text/javascript">
		var f=new form('frm1','div1');
		f.terminado = function () {
			var tb = document.getElementById(this.Div.id).getElementsByClassName('grid')[0];
			
			grids = new grid(tb);
			grids.nuevoEvento();
			grids.fncPaginacion(f);	
                        $('[data-toggle="tooltip"]').tooltip(); 
                        $('#websendeos').stacktable();
		}
		f.enviar();
		var fncCargaValores=function(){
                    f.enviar();
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
			
			f.enviar();
		}
		

		var fncInventarioKardex=function(id){
                   window_float_open_modal('REGISTRAR NUEVA COMPRA','/Inventario/inventario_mantenimiento_producto',id,'',f,900,550);
                   
		}
		
		
		
		$('#txtBuscar,#txtMostrar').keypress(function(e){			
			if (e.which==13){
				$('#num_page').val(1);
				f.enviar();
				return false;
			}
		});
		
		$('#txtBuscar').focus();
	</script>

<?php } ?>