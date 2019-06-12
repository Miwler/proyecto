<?php		
	require ROOT_PATH."views/shared/content.php";	
?>	
<?php function fncTitle(){?>
		Asignar Operador a las ventas
<?php } ?>
<?php function fncHead(){?>
         <script type="text/javascript" src="include/js/jForm.js"></script>
        <script type="text/javascript" src="include/js/jGrid.js"></script>

        <link rel="stylesheet" type="text/css" href="include/css/grid.css" />
                
<?php } ?>
<?php function fncTituloCabecera(){?>
        <i class="fa fa-cube"></i>Asignar Operador a las ventas
        <div class="pull-right">
            <a onclick="f.enviar();" class="btn btn-success btn-add-skills" >Actualizar &nbsp;<i class="fa fa-refresh"></i></a>
            <a onclick="fncNuevo();" class="btn btn-primary btn-add-skills" >Nuevo &nbsp;<i class="fa fa-plus"></i></a>
         </div>
<?php } ?>
<?php function fncMenu(){?>
<?php } ?>
<?php function fncPage(){?>

    <form id="frm1" name="frm1" method="post" action="/Salida/ajaxOrden_Venta_Mantenimiento_Asignar" class="form-horizontal">
        <input type="hidden" id="txtsalida_ID" value="0" >
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
                    

                </div>
            </div>
            <div class="row">
                <div id="div1" class="col-md-12 col-lg-12 col-sm-12 col-xs-12"></div>
            </div>
            <input id="num_page" name="num_page" type="hidden" value="1" style="display:none;">
            <input id="campo_orden" name="campo_orden" type="hidden" value="ID" style="display:none;">
            <input id="orden" name="orden" type="hidden" value="DESC"  style="display:none;">
               
           
        </div>
    </div> 

       
    </form>	
	
	<script type="text/javascript">
  
            function fnLimpiar(obj){
                $(obj).val('');
            }
            function Actualizar_Operador(operador_ID){
                var obj=new Object();
                var salida_ID=$("#txtsalida_ID").val();
                if(salida_ID<=0){
                     toastem.error("No seleccionó ninguna salida");
                     return false;
                }
                obj['operador_ID']=operador_ID;
                obj['salida_ID']=salida_ID;
                enviarAjaxParse('Salida/ajaxActualizarOperador','frm1',obj,function(resul){
                    if(resul.resultado==1){
                        toastem.success("Se actualizó correctamente");
                    }else{
                         toastem.error("Ocurrió un error");
                    }
                });
            }
            function fnsSelecciona(salida_ID){
                $("#txtsalida_ID").val(salida_ID);
            }
		var f=new form('frm1','div1');
		f.terminado = function () {
			var tb = document.getElementById(this.Div.id).getElementsByClassName('grid')[0];
			
			grids = new grid(tb);
			grids.nuevoEvento();
			grids.fncPaginacion(f);	
                        $('[data-toggle="tooltip"]').tooltip(); 
                        $('#websendeos').stacktable();
                        $('.buscadores').keypress(function(e){			
			if (e.which==13){
				$('#num_page').val(1);
				f.enviar();
				return false;
			}
                    });
                    
                    $( ".seleccionar_operador").autocomplete({
                    
                        source: <?php echo $GLOBALS['dtOperador'];?>,
                        minLength: 2,
                        select: function( event, ui ) {
                            Actualizar_Operador(ui.item.val);
                            //console.log(ui.item.val);
                            //console.log(ui.item.label);
                          //log( "Selected: " + ui.item.value + " aka " + ui.item.id );
                        }
                    });
		}
		f.enviar();
		var fncCargaValores=function(){
                    f.enviar();
                }
                
		var fncOrden=function(col){
                    
			var col_old=$('#campo_orden').val();
			
			if(col_old==col){
                            if($("#orden").val()=='ASC'){
                                $("#orden").val('DESC');
                            }else{
                                $("#orden").val('ASC');
                            }
				
			}else{
                            $('#campo_orden').val(col)
                            $("#orden").val('ASC');
				
			}		
			
			f.enviar();
		}
		

		var fncInventarioKardex=function(id){
                   window_float_open_modal('REGISTRAR NUEVA COMPRA','/Inventario/inventario_mantenimiento_producto',id,'',f,900,550);
                   
		}
		
		
		
		$('.buscadores,#txtBuscar,#txtMostrar').keypress(function(e){			
			if (e.which==13){
				$('#num_page').val(1);
				f.enviar();
				return false;
			}
		});
		
		$('#txtBuscar').focus();
	</script>

<?php } ?>