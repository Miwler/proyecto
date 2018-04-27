<?php		
	require ROOT_PATH."views/shared/content.php";	
?>	
<?php function fncTitle(){?>
		Información para Representante Cliente
<?php } ?>
<?php function fncHead(){?>
		<script type="text/javascript" src="include/js/jForm.js"></script>
		<script type="text/javascript" src="include/js/jGrid.js"></script>
               <script type="text/javascript" src="include/js/jCboDiv.js"></script> 
                <link rel="stylesheet" type="text/css" href="include/css/grid.css" />
<?php } ?>
<?php function fncMenu(){?>
<?php } ?>
<?php function fncPage(){?>
	<h1 class="title-principal">
		Mantenimiento de Representante Cliente
	</h1>
	<div class="tab" id="tab" style="width: 1100px;">
        <div id="pestanas" class="cabecera-taps" style="margin:0;width: 1096px;">
            <button id="pestana1" class="botonTabs activetabs" onclick="mostrarForm('pestana1');" >CLIENTES</button>
            <button id="pestana2" class="botonTabs"  onclick="mostrarForm('pestana2');"  >PERSONA CONTACTO</button>
            
	</div>
	<div id="contenidopestanas"  class="cuerpo-taps" style="margin:0; padding:0 10px;">
            <div id="cpestana1" style="display:block;" class="cpestana">
                <h2 style="margin:0; padding:10px 0;">Registro de Clientes </h2>
                <form id="frm2" name="frm2" method="post" action="/Mantenimiento/ajaxCliente_Mantenimiento">

                        <div class="tool">
                        <input type="text" id="txtBuscar2" name="txtBuscar2" style="width:400px;" placeholder="Buscar por ruc o razon social">
                        <button id="btnBuscar2" name="btnBuscar2" class="botonVentanas" type="button" title="Buscar" onclick="f2.enviar();">
                                <img src="/include/img/boton/find_14x14.png"  />Buscar
                        </button>
                        <button id="btnNuevo2" name="btnNuevo2" type="button" class="botonVentanas" title="Nuevo" onclick="fncNuevo2();">
                                <img src="/include/img/boton/new_14x14.png" /> Nuevo
                        </button>
                        <div style="float:right;">
                                Registros a mostrar: <input id="txtMostrar2" name="txtMostrar2" type="text"  class="int" value="30" style="width:30px;">
                        </div>
                        </div>

                        <div id="divMensaje2" class="divMensaje"></div>
                        <div id="divc2" class="grid-content"></div>

                        <input id="num_page2" name="num_page2" type="text" value="1" style="display:none;">
                        <input id="txtOrden2" name="txtOrden2" type="text" value="1" style="display:none;">
                        <input id="chkOrdenASC2" name="chkOrdenASC2" type="checkbox" checked style="display:none;">
                </form>	
			
	<script type="text/javascript">
        var f2=new form('frm2','divc2');
        f2.terminado = function () {

                var tb = document.getElementById(this.Div.id).getElementsByClassName('grid')[0];

                grids = new grid(tb);
                grids.nuevoEvento();
                grids.fncPaginacion(f2);			
        }
        f2.enviar();

        var fncOrden2=function(col){

                var col_old=$('#txtOrden2').val();

                if(col_old==col){
                        if($('#chkOrdenASC2').is(':checked')){
                                $('#chkOrdenASC2').prop('checked',false);
                        }else{
                                $('#chkOrdenASC2').prop('checked',true);
                        }
                }else{
                        $('#txtOrden2').val(col);
                        $('#chkOrdenASC2').prop('checked',true);
                }		

                f2.enviar();
        }

        var fncNuevo2=function(){
            
                window_float_open('/Mantenimiento/Cliente_mantenimiento_Nuevo','','',f2);
        }

        var fncEditar2=function(id){			
                window_float_open('/Mantenimiento/Cliente_mantenimiento_Editar',id,'',f2);
        }

        var fncEliminar2=function(id){			
                gridEliminar(f2,id,'/Mantenimiento/ajaxCliente_mantenimiento_Eliminar','divMensaje2');
        }

        $('#txtBuscar2,#txtMostrar2').keypress(function(e){

                if (e.which==13){
                        $('#num_page2').val(1);
                        f2.enviar();
                        return false;
                }
        });

    $('#txtBuscar2').focus();
	</script>
			
			
		</div>

            <div id="cpestana2" style="display:none;" class="cpestana">
                <h2 style="margin:0; padding:10px 0;">Registro de Representante Cliente</h2>
                    <form id="frm1" name="frm1" method="post" action="/Mantenimiento/ajaxRepresentanteCliente_Mantenimiento">

                            <div class="tool" >
                                <table style="width: 1076px;">
                                    <tr>
                                        <td>Cliente</td>
                                        <td>Representante</td>                                  
                                    <!--<td>PRODUCTO</td>
                                        <td>EATADO</td>-->
                                        <td>Buscar</td>
                                        <td></td>

                                    </tr>
                                    <tr>
                                        <td id="tdCliente">
                                          <select id="selCliente" name="selCliente" onchange="fncCliente();">
                                            <option value="0">TODOS</option>
                                            <?php foreach($GLOBALS['dtCliente'] as $iCliente){ ?>
                                                    <option value="<?php echo $iCliente['ID']; ?>"><?php echo FormatTextView($iCliente['razon_social']); ?></option>
                                            <?php } ?>

                                         </select>
                                        </td>

                                        <td id="tdRepresentanteCliente">
                                           <select id="selRepresentanteCliente" name="selRepresentanteCliente" onchange="f.enviar();">
                                            <option value="0" selected>TODOS</option>
                                            <?php foreach($GLOBALS['dtRepresentanteCliente'] as $iRepresentanteCliente){ ?>
                                                    <option value="<?php echo $iRepresentanteCliente['ID']; ?>"><?php echo FormatTextView($iRepresentanteCliente['nombres']); ?></option>
                                            <?php } ?>

                                          </select>    
                                        </td>

                                        <td>
                                            <input type="text" id="txtBuscar"  name="txtBuscar" style="width:300px;" placeholder="Nombres, apellidos o DNI">
                                            <button id="btnBuscar" name="btnBuscar" type="button" class="botonVentanas" title="Buscar" onclick="f.enviar();">
                                                    <img src="/include/img/boton/find_14x14.png"  />Buscar
                                            </button> 
                                           <button id="btnNuevo" name="btnNuevo" type="button" class="botonVentanas" title="Nuevo" onclick="fncNuevo();" >
                                                <img src="/include/img/boton/new_14x14.png" />Nuevo
                                            </button>
                                        </td>

                                        <td style="text-align:right;">
                                            <div style="float:right;">
                                                Registros a mostrar: 
                                                <input id="txtMostrar" name="txtMostrar" type="text"  class="int" value="30" style="width:30px;" >   
                                            </div>
                                         </td>

                                    </tr>
                                </table>

                            </div>

                            <div id="divMensaje1" class="divMensaje"></div>
                            <div id="divc1" class="grid-content"></div>

                            <input id="num_page" name="num_page" type="text" value="1" style="display:none;">
                            <input id="txtOrden" name="txtOrden" type="text" value="1" style="display:none;">
                            <input id="chkOrdenASC" name="chkOrdenASC" type="checkbox" checked style="display:none;">
                    </form>	
                            <script type="text/javascript">
                            var f=new form('frm1','divc1');
                            f.terminado = function () {

                                    var tb = document.getElementById(this.Div.id).getElementsByClassName('grid')[0];

                                    grids = new grid(tb);
                                    grids.nuevoEvento();
                                    grids.fncPaginacion(f);			
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

                            var fncNuevo=function(){
                                    var cliente_ID=$('#selCliente').val();
                                    window_float_open('/Mantenimiento/RepresentanteCliente_mantenimiento_Nuevo',cliente_ID,'',f);
                            }

                            var fncEditar=function(id){			
                                    window_float_open('/Mantenimiento/RepresentanteCliente_mantenimiento_Editar',id,'',f);
                            }

                            var fncEliminar=function(id){			
                                    gridEliminar(f,id,'/Mantenimiento/ajaxRepresentanteCliente_mantenimiento_Eliminar','divMensaje1');
                            }

                            $('#txtBuscar,#txtMostrar').keypress(function(e){

                                    if (e.which==13){
                                            $('#num_page').val(1);
                                            f.enviar();
                                            return false;
                                    }
                            });

                    // var fncLinea=function(){
                        // //alert('ded');
                        // var obj = $('#selLinea');

                        // ajaxSelect('tdCategoria', '/Mantenimiento/ajaxSelect_Categoria/' + obj.val(), '',fncCategoria);
                        // //f.enviar();
                    // }

                    var fncCliente=function(){
                            var obj = $('#selCliente');
                            var valorobjeto=obj.val();
                            if(valorobjeto==-1){
                               $('#tdRepresentanteCliente').html('<select id="selRepresentanteCliente" name="selRepresentanteCliente"><option value="-1">Sin Representante Cliente</option></select>')
                            } else{
                                 ajaxSelect('tdRepresentanteCliente', '/Mantenimiento/ajaxSelect_RepresentanteCliente/' + obj.val(), '',null);
                            }
                            //alert(obj.val());
                            //ajaxSelect('tdProducto', '/Mantenimiento/ajaxSelect_Producto/' + obj.val(), '',null);
                           f.enviar();
                    }
            $('#txtBuscar').focus();
            </script>
            </div>

		


		
	</div>
	
        </div>
	<script type="text/javascript">
        function mostrarForm(valor){
            //alert(Valor);
            if(valor=="pestana1"){
                f2.enviar();
                    $('#pestana2').removeClass('activetabs');
                    $('#pestana1').addClass('activetabs');
                    $('#cpestana1').show();
                    $('#cpestana2').hide();
                    
                    valor="";
            } else if(valor=="pestana2"){
                    f.enviar();
                    $('#pestana1').removeClass('activetabs');
                    $('#pestana2').addClass('activetabs');
                  
                   
                    $('#cpestana2').show();
                    $('#cpestana1').hide();
                    

            } 
               
	}
	
	
	</script>	
<?php } ?>