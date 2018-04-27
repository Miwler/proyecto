<?php
require ROOT_PATH . "views/shared/content-float.php";
?>	
<?php

function fncTitle() { ?>Nuevo Producto<?php } ?>

<?php

function fncHead() { ?>


<?php } ?>

<?php

function fncTitleHead() { ?><i class="fa fa-shopping-cart" aria-hidden="true"></i> Nuevo Producto<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php function fncPage() { ?>
<?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1) { ?>
<div class="container">
    <form id="form" method="POST" style="width: 600px;"  action="/Mantenimiento/Producto_Mantenimiento_Nuevo" enctype="multipart/form-data"  onsubmit="return validar();">
        <div class="panel panel-<?php echo $_SESSION['cabecera'];?>">
            <div class="panel-heading">
                <h4>Información General</h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3">
                        <label>Línea: </label>
                    </div>
                    <div id="tdLinea" class="col-md-9 col-sm-9 col-lg-9 col-xs-9">
                        <select id="selLinea" name="selLinea" onchange="fncLinea();" class="form-control form-requerido">
                            <option value="0">SELECCIONAR</option>
                            <?php foreach($GLOBALS['dtLinea'] as $iLinea){ ?>
                                    <option value="<?php echo $iLinea['ID']; ?>"><?php echo FormatTextView($iLinea['nombre']); ?></option>
                            <?php } ?>

                        </select>

                        <script type="text/javascript">
                            $('#selLinea').val(<?php echo $GLOBALS['linea_ID'];?>);
                         </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3">
                        <label>Categoría: </label>
                    </div>
                    <div id="tdCategoria" class="col-md-9 col-sm-9 col-lg-9 col-xs-9">
                        <select id="selCategoria" name="selCategoria" required  class="form-control form-requerido">
                            <option value="0" >--</option>
                            <?php if (isset($GLOBALS['dtCategoria'])){?>
                            <?php foreach($GLOBALS['dtCategoria'] as $iCategoria){ ?>
                                      <option value="<?php echo $iCategoria['ID']; ?>"><?php echo FormatTextView($iCategoria['nombre']); ?></option>
                              <?php } ?>
                            <?php } ?>
                        </select>

                        <script type="text/javascript">
                           $('#selCategoria').val(<?php echo $GLOBALS['categoria_ID'];?>);
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3">
                        <label>Nombre: </label>
                    </div>
                    <div class="col-md-9 col-sm-9 col-lg-9 col-xs-9">
                        <input id="txtNombre" name="txtNombre"  onkeyup="MostrarLista(this.id,'divProducto');" type="text"  autocomplete="off" value="<?php echo FormatTextView($GLOBALS['oProducto']->nombre); ?>" class="form-control text-uppercase form-requerido" />
                        <div id="divProducto" style="position:absolute;width:350px;z-index: 10;top:35;"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3">
                        <label>Descripción: </label>
                    </div>
                    <div  class="col-md-9 col-sm-9 col-lg-9 col-xs-9">
                        <textarea id="txtDescripcion" name="txtDescripcion" style="height:60px;" class="form-control text-uppercase"/><?php echo FormatTextView($GLOBALS['oProducto']->descripcion);?></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3">
                        <label>Precio inicial: </label>
                    </div>
                    <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3">
                       <select id="selMoneda_ID" name="selMoneda_ID"  class="form-control" onchange='fncTipo_Cambio(this.value);'>
                            <?php foreach($GLOBALS['oProducto']->dtMoneda as $item){?>
                            <option value="<?php echo $item['ID']?>"><?php echo FormatTextView(strtoupper($item['descripcion']));?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3">
                        <label>Valor de cambio:</label>

                    </div>
                    <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3">

                        <input type="text" id="txtTipo_Cambio" name="txtTipo_Cambio" value="<?php echo $GLOBALS['oProducto']->tipo_cambio;?>" autocomplete="off" class="form-control" style="width:50px;" onchange="calcularTipoCambio('3');">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3">
                        <label>US$: </label>
                    </div>
                    <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3">
                       <input type="text" id="txtPrecio_Inicial_Dolares" name="txtPrecio_Inicial_Dolares" class="decimal form-control form-requerido" autocomplete="off"  placeholder="U$S."  value="<?php echo $GLOBALS['oProducto']->precio_inicial_dolares;?>" onchange="calcularTipoCambio('2');">
                    </div>
                    <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3">
                        <label>S/.: </label>
                    </div>
                    <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3">
                       <input type="text" id="txtPrecio_Inicial_soles" name="txtPrecio_Inicial_soles" class="decimal form-control form-requerido" autocomplete="off"   placeholder="S/." disabled value="<?php echo $GLOBALS['oProducto']->precio_inicial_soles;?>" onchange="calcularTipoCambio('1');">
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3">
                        <label>Unidad de medida: </label>
                    </div>
                    <div class="col-md-9 col-sm-9 col-lg-9 col-xs-9">
                       <select id="selUnidad_Medida" name="selUnidad_Medida" class="form-control form-requerido">
                            <option value="0">--</option>
                            <?php foreach($GLOBALS['dtUnidad_Medida'] as $item){ ?>
                            <option value="<?php echo $item['ID']?>"><?php echo FormatTextView(strtoupper($item['nombre']))?></option>
                            <?php } ?>
                        </select>

                         <script>
                            $('#selUnidad_Medida').val(<?php echo $GLOBALS['oProducto']->unidad_medida_ID;?>);
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3">
                        <label>Marca: </label>
                    </div>
                    <div class="col-md-9 col-sm-9 col-lg-9 col-xs-9">
                       <input id="txtMarca" name="txtMarca" type="text" autocomplete="off" value="<?php echo $GLOBALS['oProducto']->marca; ?>" class="form-control text-uppercase"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3">
                        <label>Modelo: </label>
                    </div>
                    <div class="col-md-9 col-sm-9 col-lg-9 col-xs-9">
                       <input id="txtModelo" name="txtModelo" type="text" autocomplete="off" value="<?php echo $GLOBALS['oProducto']->modelo; ?>" class="form-control text-uppercase"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3">
                        <label>Color: </label>
                    </div>
                    <div class="col-md-9 col-sm-9 col-lg-9 col-xs-9">
                      <input id="txtColor" name="txtColor" type="text" autocomplete="off"  value="<?php echo $GLOBALS['oProducto']->color; ?>" class="form-control text-uppercase"/>        
                    </div>
                </div>

            </div>
        </div>
        <div class="panel panel-<?php echo $_SESSION['cabecera'];?>">
            <div class="panel-heading">
                <h4>Información para la web</h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3">
                        <label>Habilitar: </label>
                    </div>
                    <div class="col-md-9 col-sm-9 col-lg-9 col-xs-9">
                        <input type="checkbox" id="ckVer_Web" name="ckVer_Web" value="1" >
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3">
                        <label>Características: </label>
                    </div>
                    <div class="col-md-9 col-sm-9 col-lg-9 col-xs-9">
                        <textarea id="txtCaracteristicas"  name="txtCaracteristicas" class="form-control text-uppercase"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3">
                        <label>Especificaciones: </label>
                    </div>
                    <div  class="col-md-9 col-sm-9 col-lg-9 col-xs-9">
                        <textarea id="txtEspecificaciones"  name="txtEspecificaciones" class="form-control text-uppercase"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                <button  id="btnEnviar" name="btnEnviar" title="Guardar" class="btn btn-success">
                <img  alt=""  src="/include/img/boton/save_14x14.png" >
                Guardar
                </button>&nbsp;
                <button type="button" title="Cancelar" id="btnCancelar" name="btnCancelar" class="btn btn-danger"  onclick="window_float_close();" >
                    <img  alt="" src="/include/img/boton/cancel_14x14.png">
                    Cancelar
                </button> 
            </div>
            
        </div>
    </form>
</div>
       
    <?php } ?>
  <script>
        //ingreso de datos obligatorios
        var validar = function () {
            $('#txtPrecio_Inicial_soles').removeAttr('disabled');
            $('#txtPrecio_Inicial_Dolares').removeAttr('disabled');
            var nombre = $.trim($('#txtNombre').val());
            var descripcion = $.trim($('#txtDescripcion').val());
            var linea = $('#selLinea').val();
            var categoria = $('#selCategoria').val();
            var unidad_medida=$('#selUnidad_Medida').val();
            if (linea=="0") {
                mensaje.error('Mensaje de error','Seleccione una línea.','selLinea');
               
                return false;
            }
            if (categoria=="0") {
                mensaje.error('Mensaje de error','Seleccione una categoria.','selCategoria');
                
                return false;
            }
            if (nombre=="") {
                mensaje.error('Mensaje de error','Ingrese un nombre válido.','txtNombre');
                
                return false;
            }
            
            if(unidad_medida==0){
                $('#divMensaje').html('Seleccione unidad de medida.');
                $('#selUnidad_Medida').focus();
                return false;
            }

        }
        var fncLinea=function(){
        var obj = $('#selLinea');
        ajaxSelect('selCategoria', '/Mantenimiento/ajaxSelect_Categoria1/' + obj.val(), '',null);  
    }
    var MostrarLista=function(buscador,contenedorLista){
        var valor_buscar=$('#'+buscador).val();
        cboMostrarTexto('/Mantenimiento/ajaxCbo_Producto',valor_buscar,contenedorLista);

    }
    var subirValorCaja=function(valor){
        $('#txtNombre').val(valor);
        $('#divProducto').html('');
    }
        function calcularTipoCambio(tipo){
// alert(tipo);
        var tipo_cambio=$('#txtTipo_Cambio').val();
        switch(tipo){
            case '3':
                 var valorSoles=$('#txtPrecio_Inicial_soles').val();

                if(valorSoles!=""){
                    var valorDolares=redondear(parseFloat(valorSoles)/tipo_cambio,2);
                    $('#txtPrecio_Inicial_Dolares').val(valorDolares);
                }
                break;
            case '1':
                var valorSoles=$('#txtPrecio_Inicial_soles').val();
                var valorDolares=redondear(parseFloat(valorSoles)/tipo_cambio,2);
                $('#txtPrecio_Inicial_Dolares').val(valorDolares);
                break;
            case '2':
                var valorDolares=$('#txtPrecio_Inicial_Dolares').val();
                var valorSoles=redondear(parseFloat(valorDolares)*tipo_cambio,2);
                $('#txtPrecio_Inicial_soles').val(valorSoles);
                break;
        }
    }
    var fncTipo_Cambio=function(valor){
       //alert(valor);
        if(valor==1){
            $('#txtPrecio_Inicial_soles').removeAttr('disabled');
            $('#txtPrecio_Inicial_Dolares').attr('disabled','disabled');
        } else {
            $('#txtPrecio_Inicial_soles').attr('disabled','disabled');
            $('#txtPrecio_Inicial_Dolares').removeAttr('disabled');
        }
        
    }
    </script>
    <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 1) { ?>
       
        <script type="text/javascript">
            $(document).ready(function(){
                toastem.success("<?php echo $GLOBALS['mensaje']; ?>"); 
                setTimeout('window_float_save();', 1000);
            });
                 
            
        </script>
    <?php } ?>

    <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 0) { ?>
        <div class="float-mensaje">
            <?php echo $GLOBALS['mensaje']; ?>
        </div>
        <div class="group-btn">
            <input type="button" onclick ="redireccionar_parent('/');" value ="Iniciar Sesión"/>
        </div>
    <?php } ?>
    
    <?php if(isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == -1){?>
    <script type="text/javascript">
        $('#selLinea').val('<?php echo $GLOBALS['linea_ID'];?>');
		var html=""
		
    <?php foreach($GLOBALS['dtCategoria'] as $iCategoria){ ?>
		$('#selCategoria').append('<option value="<?php echo $iCategoria['ID'];?>"><?php echo $iCategoria['nombre'];?> </option>');
    <?php } ?>
    
       
        $('#selCategoria').val('<?php echo $GLOBALS['categoria_ID'];?>');
        $(document).ready(function(){
            toastem.error("<?php echo $GLOBALS['mensaje']; ?>"); 
           
        });                
    </script>   

    <?php }?>
	 
        
<?php } ?>
