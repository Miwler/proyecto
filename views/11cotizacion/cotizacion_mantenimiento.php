<?php		
	require ROOT_PATH."views/shared/content.php";	
?>	
<?php function fncTitle(){?>
		Registro de Cotizaciones
<?php } ?>
<?php function fncHead(){?>
		<script type="text/javascript" src="include/js/jForm.js"></script>
		<script type="text/javascript" src="include/js/jGrid.js"></script>
                <script type="text/javascript" src="include/js/jDate.js"></script>
		<link rel="stylesheet" type="text/css" href="include/css/grid.css" />
                <link rel="stylesheet" type="text/css" href="include/css/date.css" />
<?php } ?>
<?php function fncMenu(){?>
<?php } ?>
<?php function fncPage(){?>
	
	<form id="frm1" name="frm1" method="post" action="/Cotizacion/ajaxCotizacion_Mantenimiento">
            <div class="divCabecera">
                <div class='divTitulo' style="height:82px!important; ">
                    <img src='/include/img/order-history.png'/>
                    <span>REGISTRO DE COTIZACIONES</span>
                    <div class="ContenedorLeyenda">
                        <div>En proceso</div><div class="divCuadro trEnproceso"></div>
                        <div>Registrado</div><div class="divCuadro trRegistrado"></div>
                        <div>Ganadas</div><div class="divCuadro trGanadas"></div>
                    </div>
                </div>
                
                <div class="btnBuscadorBtn">
                    <ul>
                        <li><input type="radio" name='rbOpcion' value="filtrar" checked="checked">Filtrar</li>
                        <li><input type="radio" name='rbOpcion' value="buscar" >Buscar</li>
                    </ul>
                </div>
                <div class="divBuscador">
                    <table class="tablaFiltrar" style="width:860px;">
                        <tr>
                            <th>Cliente</th>
                            <td style="width:300px;">
                                <select id="selCliente" name="selCliente" style="width:250px;">
                                    <option value="0">Todos</option>
                                     <?php foreach($GLOBALS['dtCliente'] as $item){ ?>
                                    <option value="<?php echo $item['ID']?>"><?php echo FormatTextViewHtml(strtoupper($item['razon_social']));?></option>
                                    <?php }?>

                                </select>
                                
                            </td>
                            <th>Fecha Inicio</th>
                            <td style="width:150px;">
                                <input type="text" id="txtFechaInicio" name="txtFechaInicio" class="date" value="<?php echo date('d/m/Y')?>">
                                <input type="checkbox" id="ckTodos" name="ckTodos" value="1"> Todos
                            </td>
                            <th>Moneda</th>
                            <td>
                                <select id="selMoneda" name="selMoneda">
                                    <option value="0">Todos</option>
                                    <?php foreach($GLOBALS['dtMoneda'] as $item3){ ?>
                                    <option value="<?php echo $item3['ID'];?>"><?php echo FormatTextView($item3['descripcion']);?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Estado</th>
                            <td>
                                <select id="selEstado" name="selEstado">
                                    <option value="0">Todos</option>
                                    <?php foreach($GLOBALS['dtEstado'] as $item2){ ?>
                                    <option value="<?php echo $item2['ID'];?>"><?php echo FormatTextSave($item2['nombre']);?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            
                            <th>Fecha fin</th>
                            <td>
                                 <input type="text" id="txtFechaFin" name="txtFechaFin" class="date" value="<?php echo date('d/m/Y')?>">

                            </td>
                            
                            <th>Mostrar</th>
                            <td>

                                <input id="txtMostrar" name="txtMostrar" type="text"  class="int" value="30" style="width:30px;">

                            </td>

                        </tr>

                    </table>
                    
                    <table class="tablaBuscar" style='width:700px;display:none;'>
                        <th>Periodo</th>
                        <td style="width:250px;"><input type="text" id="txtPeriodo" name="txtPeriodo"></td>
                        <th>N&uacute;mero</th>
                        <td><input type='text' id='txtNumero' name='txtNumero' onchange="fncNumero();" ></td>
                    </table>
                    
                </div>
                <div class="divBuscadorEje">
                     <button id="btnBuscar" name="btnBuscar" type="button" title="Buscar" class="botonVentanas" onclick="f.enviar();" style="width:93px;">
                         <img src="/include/img/boton/find_14x14.png"  /><span id="btnTitulo">Filtrar</span>
                    </button>
                    <button id="btnNuevo" name="btnNuevo" type="button" title="Nuevo" class="botonVentanas" onclick="fncNuevo();">
                        <img src="/include/img/boton/add_16x16.png"  /> Nuevo
                    </button> 
                </div>
            </div>
             
            <table width="1100px">
               

                <tr>
                        <td colspan="8">
                                <div id="divMensaje" class="divMensaje"></div>
                                <div id="div1" class="grid-content"></div> 
                        </td> 
                </tr>
               
            </table>
            <input id="num_page" name="num_page" type="text" value="1" style="display:none;">
            <input id="txtOrden" name="txtOrden" type="text" style="display:none;" >
            <input id="chkOrdenASC" name="chkOrdenASC" type="checkbox"  style="display:none;">
	</form>	
	
	<script type="text/javascript">
		var f=new form('frm1','div1');
		f.terminado = function () {
			var tb = document.getElementById(this.Div.id).getElementsByClassName('grid')[0];
			
			grids = new grid(tb);
			grids.nuevoEvento();
			grids.fncPaginacion(f);			
		}
		f.enviar();
		
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
		
		var fncNuevo1=function(){			
			//window_float_open('/Cotizacion/Cotizacion_Mantenimiento_Nuevo','','',f);
                        $('#iframe2').attr('src','Cotizacion/Cotizacion_Mantenimiento_Nuevo');
                        $('#iframe2').css('display','block');
                        //$('#iframe2').slideUp('slide');
                        $('#frm1').css('display','none');
                        //$('#frm1').slideDown('slide');
                       
		}
		var fncNuevo=function(){			
		window_float_open('/Cotizacion/Cotizacion_Mantenimiento_Nuevo','','',f);    
		}
                var fncMantenimiento=function(){
                    $('#frm1').css('display','block');
                    $('#iframe2').attr('src','');
                    $('#iframe2').css('display','none');
                    f.enviar();
                }
		var fncEditar=function(id){			
                    window_float_open('/Cotizacion/Cotizacion_Mantenimiento_Editar',id,'',f);
                    // $('#iframe2').attr('src','Cotizacion/Cotizacion_Mantenimiento_Editar/'+id);
                    // $('#iframe2').css('display','block')
                     // $('#frm1').css('display','none');
		}
		var fncClonar=function(id){			
                    window_float_open('/Cotizacion/Cotizacion_Mantenimiento_Clonar',id,'',f);
//                    $('#iframe2').attr('src','Cotizacion/Cotizacion_Mantenimiento_Clonar/'+id);
//                    $('#iframe2').css('display','block')
//                     $('#frm1').css('display','none');
		}
		var fncEliminar=function(id){	
                    
			gridEliminar(f,id,'/Cotizacion/ajaxCotizacion_Mantenimiento_Eliminar');
		}
		
		$('#txtBuscar,#txtMostrar,#txtPeriodo,#txtNumero').keypress(function(e){			
			if (e.which==13){
				$('#num_page').val(1);
				f.enviar();
				return false;
			}
		});
                
                function fncNumero(){
                    var numero=$('#txtNumero').val();
                    var nNumero=('0000000'+numero);

                    $('#txtNumero').val(nNumero.substring(nNumero.length-9,nNumero.length));
                }
		$('#txtBuscar').focus();
                $('#ckTodos').click(function(){
                    if($(this).prop('checked')){
                        $('#txtFechaInicio').prop('disabled', true);
                        $('#txtFechaFin').prop('disabled', true);
                    }else {
                        $('#txtFechaInicio').prop('disabled', false);
                        $('#txtFechaFin').prop('disabled', false);
                    }
                });
	</script>
        <iframe id="iframe2" src="" style="width:1100px; height: 700px; display:none; border:none;">
            
        </iframe>
<?php } ?>