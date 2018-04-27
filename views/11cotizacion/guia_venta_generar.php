<?php
require ROOT_PATH . "views/shared/content-float.php";
//require ROOT_PATH . 'views/cotizacion/imprimir.php';
?>	
<?php

function fncTitle() { ?>Modificar Guia<?php } ?>

<?php

function fncHead() { ?>
    <script type="text/javascript" src="include/js/jDate.js"></script>
    <script type="text/javascript" src="include/js/jCboDiv.js"></script>
    <script type="text/javascript" src="include/js/jGrid.js"></script>
    <script type="text/javascript" src="include/js/jForm.js"></script>

    <link href="include/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="include/css/date.css" />
    <link rel="stylesheet" type="text/css" href="include/css/cboDiv.css" />
    <link rel="stylesheet" type="text/css" href="include/css/grid.css" />

<?php } ?>

<?php

function fncTitleHead() { ?>Modificar Guia<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>
<?php

function fncPage() { ?>
    <?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1) { ?>
        <form id="form1" method="POST" action="/Cotizacion/Guia_Venta_Generar/<?php echo $GLOBALS['oCotizacion']->ID; ?>" onsubmit="return validar();">
            <!--formulario datos-->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group"><label>Numero factura:</label></div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group"><input onkeypress="return solonumeros(event)" id="txtNumero_Factura" name="txtNumero_Factura" type="text" autocomplete="off" value="<?php echo $GLOBALS['oGuia']->numero_factura; ?>"/></div>

                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group"><label>Descripción:</label></div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group"><input id="txtDescripcion" name="txtDescripcion" type="text"autocomplete="off" value="<?php echo $GLOBALS['oGuia']->ID; ?>" /></div>

                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group"><label>Dirección:</label></div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group"><input id="txtDireccion" name="txtDireccion" type="text" autocomplete="off" value="<?php echo $GLOBALS['oGuia']->direccion; ?>"/></div>

                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group"><label>Cotización:</label></div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group"><input id="txtCotizacion" name="txtCotizacion" type="text" autocomplete="off" readonly="readonly"  value="<?php echo $GLOBALS['oCotizacion']->ID; ?>"/></div>

                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group"><label>Numero:</label></div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group"><input id="txtNumero" name="txtNumero" type="text" autocomplete="off" readonly="readonly"  value="<?php echo $GLOBALS['oCotizacion']->numero; ?>"/></div>

                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group"><label>Plazo entrega:</label></div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group"><input id="txtPlazo_Entrega" name="txtPlazo_Entrega" type="text" autocomplete="off" value="<?php echo $GLOBALS['oCotizacion']->plazo_entrega; ?>"/></div>

                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group"><label>fecha:</label></div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group"><input id="txtFecha" name="txtFecha" type="text" class="date"  autocomplete="off" value="<?php echo $GLOBALS['oGuia']->fecha; ?>"/></div>

                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group"><label>Vehiculo:</label></div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group " style="height:30px;">
                        <div id="divVehiculo" class="input-content" >                           
                        </div>
                        <script type="text/javascript">
        <?php if ($GLOBALS['oGuia']->vehiculo == 0) { ?>
                                var cboChofer = newCbo('divVehiculo', 'txtVehiculo_ID', '/Cotizacion/ajaxCbo_Vehiculo', 150, true);
        <?php } else { ?>
                                var cboChofer = cargarCbo('divVehiculo', 'txtVehiculo_ID', '/Cotizacion/ajaxCbo_Vehiculo', 150, "", "", true);
        <?php } ?>
                        </script>
                    </div>


                </div>

                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group"><label>Chofer:</label></div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group" style="height:30px;">
                        <div id="divChofer" class="input-content " >                           
                        </div>
                        <script type="text/javascript">
        <?php if ($GLOBALS['oGuia']->chofer == 0) { ?>
                                var cboChofer = newCbo('divChofer', 'txtChofer_ID', '/Cotizacion/ajaxCbo_Chofer', 150, true);
        <?php } else { ?>
                                var cboChofer = cargarCbo('divChofer', 'txtChofer_ID', '/Cotizacion/ajaxCbo_Chofer', 150, <?php echo $GLOBALS['oGuia']->chofer; ?>, "", true);
        <?php } ?>
                        </script>  
                    </div>

                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group"><label>Moneda:</label></div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group">
        <!--                        <input id="txtMoneda" name="txtMoneda" type="text" autocomplete="off" value=""/>-->
                        <select id="cboMoneda" name="cboMoneda" onchange="fncEstado();">
                            <?php foreach ($GLOBALS['dtMoneda'] as $iEstado) { ?>
                                <option value="<?php echo $iEstado['ID']; ?>" <?php
                                if ($iEstado['ID'] == $GLOBALS['oCotizacion']->moneda_ID) {
                                    echo "selected='selected'";
                                };
                                ?>><?php echo FormatTextView($iEstado['descripcion']); ?></option>
                                    <?php } ?>
                        </select>    
                        <script type="text/javascript">
                            $('#cboMoneda').val(<?php echo $GLOBALS['moneda_ID']; ?>);
                        </script>
                    </div>

                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group"><label>Estado:</label></div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group">
        <!--                        <input id="txtEstado" name="txtEstado" type="text" autocomplete="off" value=""/>-->
                        <select id="cboEstado" name="cboEstado" onchange="fncEstado();">
                            <?php foreach ($GLOBALS['dtEstado'] as $iEstado) { ?>
                                <option value="<?php echo $iEstado['ID']; ?>" <?php
                                if ($iEstado['ID'] == $GLOBALS['oCotizacion']->estado_ID) {
                                    echo "selected='selected'";
                                };
                                ?>><?php echo FormatTextView($iEstado['nombre']); ?></option>
                                    <?php } ?>
                        </select>						
                        <script type="text/javascript">
                            $('#cboEstado').val(<?php echo $GLOBALS['estado_ID']; ?>);
                        </script>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group"><label>Rep. cliente:</label></div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group">
                        <input id="txtRep_Cliente" name="txtRep_Cliente" type="text" autocomplete="off" disabled="disabled" value="<?php echo $GLOBALS['oRCliente']->nombre . " " . $GLOBALS['oRCliente']->apellidos; ?>"/>
                        <input id="txtRep_Cliente_ID" name="txtRep_Cliente_ID" type="hidden"value="<?php echo $GLOBALS['oRCliente']->ID; ?>"/> 
                    </div>

                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group"><label>Venta total:</label></div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group"><input id="txtVenta_Total" name="txtVenta_Total" type="text" autocomplete="off" value="<?php echo $GLOBALS['oCotizacion']->precio_venta_neto; ?>"  onkeypress="return numeroDecimal(event, this)"/></div>

                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group"><label>IGV:</label></div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group"><input id="txtIgv" name="txtIgv" type="text" autocomplete="off" value="<?php echo $GLOBALS['oCotizacion']->igv; ?>"  onkeypress="return numeroDecimal(event, this)"/></div>

                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group"><label>Precio venta:</label></div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group"><input id="txtCosto_Venta" name="txtCosto_Venta" type="text" autocomplete="off" value="<?php echo $GLOBALS['oCotizacion']->precio_venta; ?>"  onkeypress="return numeroDecimal(event, this)"/></div>



                </div>

            </div>
            <!--fin formulario datos-->
            <!--            inicio detalle-->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="tool-bar">
                        <button id="btnNuevo" type="button" onclick="fncNuevaMP();">
                            <img src="/include/img/boton/add_16x16.png"  title="Nuevo Materia Prima"/>
                        </button>
                        <button id="btnImporte_Otros" type="button" onclick="fncImporte_Otros();">
                            <img src="/include/img/boton/price_reload_16x16.png"  title="Otros Importes"/>
                        </button>
                        <button id="btnEliminar" type="button" onclick="fncEliminarMP();">
                            <img src="/include/img/boton/delete_16x16.png"  title="Eliminar Detalle"/>
                        </button>
                    </div>
                </div>

                <div class="content-details-1 col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;border: none;">
                    <div  class="content-details-2" style="height:200px;">
                        <table id="tbMP" class="grid" style="width:100%;">
                            <tr>
                                <th style="display:none;">
                                </th>
                                <th style="width:80px;text-align:center;">
                                    Codigo
                                </th>								
                                <th style="text-align:center;">
                                    Descripción
                                </th>												
                                <th style="width:80px;text-align:center;">
                                    Cantidad
                                </th>								
                                <th style="width:80px;text-align:center;">
                                    Precio Unitario
                                </th>
                                <th style="width:80px;text-align:center;">
                                    Precio
                                </th>
                            </tr>
                            <?php
                            foreach ($GLOBALS['oCotizacionDetalle'] as $iDetalle) {
                                ?>
                                <tr class="tr-item">
                                    <td style="display:none;">
                                        <input name="txtProducto_ID[]" value="<?php echo $iDetalle['producto_ID']; ?>" />
                                        <input name="txtDescripcion[]" value="<?php echo $iDetalle['descripcion']; ?>" />
                                        <input name="txtCantidad[]" value="<?php echo $iDetalle['cantidad']; ?>" />
                                        <input name="txtPrecio_venta_unitario[]" value="<?php echo $iDetalle['precio_venta_unitario'];?>" />
                                        <input name="txtPrecio_venta[]" value="<?php echo $iDetalle['precio_venta']; ?>" />
                                    </td>
                                    <td>
                                        <?php echo $iDetalle['producto_ID']; ?>
                                    </td>
                                    <td <?php echo ($iDetalle['producto_ID']) == 0 ? 'contentEditable=true onkeyup="fncDescripcion(this);"' : ''; ?>><?php echo FormatTextViewHTML($iDetalle['descripcion']); ?></td>												
                                    <td contentEditable=true class="decimal" onkeyup="fncCantidad(this);"><?php echo $iDetalle['cantidad']; ?></td>
                                    <td contentEditable=true class="decimal" ><?php echo $iDetalle['precio_venta']; ?></td>
                                    <td contentEditable=true class="decimal" ><?php echo $iDetalle['precio_venta_unitario']; ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>


                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">

                    <div id="divMensaje" class="float-mensaje">        
                        <?php echo $GLOBALS['mensaje']; ?>
                    </div>  
                    <div class="tool-btn" style ="text-align:right;">                            
                        <div class="btn">

                            <button  id="btnEnviar" name="btnEnviar" >
                                <img title="Guardar" alt="" src="/include/img/boton/save_14x14.png">
                                Imprimir
                            </button>
                            <button  id="btnCancelar" name="btnCancelar" type="button" onclick="window_float_close();" >
                                <img title="Guardar" alt="" src="/include/img/boton/cancel_14x14.png">
                                Cancelar
                            </button>                                                          
                        </div>    
                        <div class="btnEnviando" style="display:none;">         
                            <button type="button">
                                <img src="/include/img/boton/boton-loader_14x14.gif" title="Guardando" alt="Guardando" /> Enviando
                            </button>     
                        </div>                                    
                    </div>

                </div>
            </div>
            <!--fin detalle-->
        </form>

        <script type="text/javascript">

            var validar = function () {
                var moneda_ID = $.trim($('#cboMoneda').val());
                var estado_ID = $('#cboEstado').val();
                var vehiculo = $.trim($('#txtVehiculo_ID').val());
                var chofer = $.trim($('#txtChofer_ID').val());
                var fecha = $.trim($('#txtFecha').val());
                var rep_cliente = $('#txtRep_Cliente_ID').val();

                $('#divMensaje').html('');

                if (moneda_ID == 0) {
                    $('#divMensaje').html('Seleccione el tipo de moneda.');
                    $('#cboMoneda').focus();
                    return false;
                }

                if (estado_ID == 0) {
                    $('#divMensaje').html('Seleccione el estado.');
                    $('#cboMoneda').focus();
                    return false;
                }


                if (vehiculo == '') {
                    $('#divMensaje').html('Ingrese el vehiculo.');
                    $('#txtVehiculo_ID').focus();
                    return false;
                }
                if (chofer == '') {
                    $('#divMensaje').html('Ingrese el chofer.');
                    $('#txtChofer_ID').focus();
                    return false;
                }
                // codigo ortega
                if (moneda_ID != 0 && estado_ID != 0 && vehiculo != '' && chofer != '') {

                }



                $('.btn').css('display', 'none');
                $('.btnEnviando').css('display', 'inline-block');
            }
            //funcion para solo numeros
            function numeroDecimal(e, field) {
                key = e.keyCode ? e.keyCode : e.which
                // backspace
                if (key == 8)
                    return true
                // 0-9
                if (key > 47 && key < 58) {
                    if (field.value == "")
                        return true
                    regexp = /.[0-9]{2}$/
                    return !(regexp.test(field.value))
                }
                // .
                if (key == 46) {
                    if (field.value == "")
                        return false
                    regexp = /^[0-9]+$/
                    return regexp.test(field.value)
                }
                // other key
                return false
            }
            //funcion para solo numeros
            function solonumeros(e) {
                tecla = (document.all) ? e.keyCode : e.which;

                //Tecla de retroceso para borrar, siempre la permite
                if (tecla == 8) {
                    return true;
                }

                // Patron de entrada, en este caso solo acepta numeros
                patron = /[0-9]/;
                tecla_final = String.fromCharCode(tecla);
                return patron.test(tecla_final);
            }
            $('#cboComprobante_Tipo').focus();
        </script>
        <form id="form2" style="display:none;" method="POST" action="/Venta/ajaxProducto_Listar">
            <table class="tbForm">		
                <tr> 
                    <td>
                        <div class="tool-bar">
                            Buscar Producto: <input id="txtBuscarP" name="txtBuscarP" type="text" style="width:400px;">
                            <button id="btnMP" type="button" onclick="fMP.enviar();" >
                                <img src="/include/img/boton/find_16x16.png"  title="Buscar Producto"/>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="content-details-1">
                            <div id="divResultadoMP" class="content-details-2" style="width:700px;height:300px;overflow:auto;display:inline-block;" >
                            </div>
                            <input id="num_page" name="num_page" style="display:none;" />
                            <input id="txtOrden" name="txtOrden" style="display:none;" />							
                            <input id="chkOrdenASC" name="chkOrdenASC" type="checkbox" checked style="display:none;">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="tool-btn" style="text-align:right">
                            <button id="btnSeleccionar" type="button" onclick="fncSeleccionar();">
                                <img src="/include/img/boton/select_16x16.png"  title="Guardar"/>
                                Seleccionar
                            </button>
                            <button id="btnRegresar1" type="button" onclick="fncRegresar1();">
                                <img src="/include/img/boton/back_16x16.png"  title="Regresar"/>
                                Regresar
                            </button>
                        </div>
                    </td>
                </tr>
            </table>

        </form>
        <script type="text/javascript">
            var fMP = new form('form2', 'divResultadoMP');
            var grids;

            fMP.terminado = function () {
                var tb = document.getElementById(this.Div.id).getElementsByClassName('grid')[0];

                grids = new grid(tb);
                grids.nuevoEvento();
                grids.fncPaginacion(fMP);
            }

            var fncOrden = function (col) {
                var col_old = $('#txtOrden').val();

                if (col_old == col) {
                    if ($('#chkOrdenASC').is(':checked')) {
                        $('#chkOrdenASC').prop('checked', false);
                    } else {
                        $('#chkOrdenASC').prop('checked', true);
                    }
                } else {
                    $('#txtOrden').val(col);
                    $('#chkOrdenASC').prop('checked', true);
                }
                fMP.enviar();
            }

            fncOrden(1);

            var fncSeleccionar = function () {
                if (grids != undefined) {
                    if (grids.fila_seleccionada != 0) {
                        var tr = grids.tb.rows[grids.fila_seleccionada];
                        trSeleccionado(tr);
                        return;
                    }
                }
                alert('No ha seleccionado ningún registro.');
            }

            var trSeleccionado = function (tr) {
                var tb = document.getElementById('tbMP');
                var index = tb.rows.length;

                var row = tb.insertRow(index);
                row.className = 'tr-item';

                var cell0 = row.insertCell(0);
                cell0.style.display = 'none';

                /*-----------------*/
                var input0 = document.createElement('input');
                input0.name = 'txtVehiculo_ID[]';
                input0.value = tr.cells[0].innerHTML;
                cell0.appendChild(input0);
                var input0 = document.createElement('input');
                input0.name = 'txtChofer_ID[]';
                input0.value = tr.cells[0].innerHTML;
                cell0.appendChild(input0);

                var input1 = document.createElement('input');
                input1.name = 'txtDescripcion[]';
                input1.value = 0;
                cell0.appendChild(input1);

                var input2 = document.createElement('input');
                input2.name = 'txtCantidad[]';
                input2.value = 0;
                cell0.appendChild(input2);

                var input3 = document.createElement('input');
                input3.name = 'txtPrecio_Unitario[]';
                input3.value = 0;
                cell0.appendChild(input3);

                var input4 = document.createElement('input');
                input4.name = 'txtPrecio[]';
                input4.value = '';
                cell0.appendChild(input4);
                /*-----------------*/

                var cell1 = row.insertCell(1);
                cell1.innerHTML = "0";

                var cell2 = row.insertCell(2);
                cell2.innerHTML = tr.cells[1].innerHTML;

                var cell3 = row.insertCell(3);
                cell3.contentEditable = true;
                cell3.innerHTML = 0;
                cell3.onkeyup = function (e) {
                    fncCantidad(this);
                }
                cell3.onfocus = function () {
                    Grid_MP.trSeleccionar(this.parentNode.rowIndex);
                }
                addClassRunTime(cell3, 'decimal');

                var cell4 = row.insertCell(4);
                cell4.contentEditable = true;
                cell4.innerHTML = 0;
                cell4.onkeyup = function (e) {
                    fncPrecio(this);
                }
                cell4.onfocus = function () {
                    Grid_MP.trSeleccionar(this.parentNode.rowIndex);
                }
                addClassRunTime(cell4, 'decimal');

                var cell5 = row.insertCell(5);
                cell5.contentEditable = true;
                cell5.innerHTML = 0;
                cell5.onkeyup = function (e) {
                    fncImporte(this, 'txtImporte');
                }
                cell5.onfocus = function () {
                    Grid_MP.trSeleccionar(this.parentNode.rowIndex);
                }
                addClassRunTime(cell5, 'decimal');

                Grid_MP.nuevoEvento();
                alert();
                cambiarInterfaz('form2', 'form1', false, false, null);
            }

            var fncDescripcion = function (td) {
                var id = Grid_MP.fila_seleccionada - 1;
                var descripcion = HTMLtoValue(td.innerHTML);
                $('input[name="txtDescripcion[]"]')[id].value = descripcion;
            }

            var fncCantidad = function (td) {
                var id = Grid_MP.fila_seleccionada - 1;
                var cantidad = HTMLtoValue(td.innerHTML);

                if (cantidad < 0) {
                    cantidad = 0;
                    td.innerHTML = 0;
                    $('input[name="txtCantidad[]"]')[id].value = 0;
                } else {
                    $('input[name="txtCantidad[]"]')[id].value = cantidad;
                }

                var precio = $('input[name="txtPrecio[]"]')[id].value;

                //Modifico el importe
                var importe = redondear(cantidad * precio, 4);
                $('input[name="txtImporte[]"]')[id].value = importe;
                Grid_MP.tb.rows[Grid_MP.fila_seleccionada].cells[5].innerHTML = importe;
                fncTotal();
            }

            var fncPrecio = function (td) {
                var id = Grid_MP.fila_seleccionada - 1;
                var precio = HTMLtoValue(td.innerHTML);
                var materia_prima_ID = $('input[name="txtMateria_Prima_ID[]"]')[id].value;

                if (materia_prima_ID != 0 && precio < 0) {
                    precio = 0;
                    td.innerHTML = 0;
                    $('input[name="txtPrecio[]"]')[id].value = 0;
                } else {
                    $('input[name="txtPrecio[]"]')[id].value = precio;
                }

                var cantidad = $('input[name="txtCantidad[]"]')[id].value;

                //Modifico el importe
                var importe = redondear(cantidad * precio, 4);
                $('input[name="txtImporte[]"]')[id].value = importe;
                Grid_MP.tb.rows[Grid_MP.fila_seleccionada].cells[5].innerHTML = importe;
                fncTotal();
            }

            var fncImporte = function (td) {
                var id = Grid_MP.fila_seleccionada - 1;
                var importe = HTMLtoValue(td.innerHTML);

                var materia_prima_ID = $('input[name="txtMateria_Prima_ID[]"]')[id].value;

                if (materia_prima_ID != 0 && importe < 0) {
                    importe = 0;
                    td.innerHTML = 0;
                    $('input[name="txtImporte[]"]')[id].value = 0;
                } else {
                    $('input[name="txtImporte[]"]')[id].value = importe;
                }

                var cantidad = $('input[name="txtCantidad[]"]')[id].value;

                //Modifico el precio
                var precio = redondear(importe / cantidad, 4);
                $('input[name="txtPrecio[]"]')[id].value = precio;
                Grid_MP.tb.rows[Grid_MP.fila_seleccionada].cells[4].innerHTML = precio;
                fncTotal();
            }

            //            var fncTotal = function () {
            //                var recargo = 0;
            //                var descuento = 0;
            //                var importe = 0;
            //                var precio = 0;
            //                var total = 0;
            //
            //                $('input[name="txtMateria_Prima_ID[]"]').each(function (key, obj) {
            //                    if (obj.value != 0) {
            //                        importe = importe + redondear($('input[name="txtImporte[]"]')[key].value, 4);
            //                    }
            //
            //                    if (obj.value == 0) {
            //                        var importe2 = redondear($('input[name="txtImporte[]"]')[key].value, 4);
            //
            //                        if (importe2 > 0) {
            //                            recargo = recargo + importe2;
            //                        } else {
            //                            descuento = descuento + importe2;
            //                        }
            //                    }
            //
            //                });
            //

            //                $('#txtRecargo_Total').val(recargo);
            //                $('#txtDescuento_Total').val(descuento);
            //
            //                var subtotal = 0;
            //                var igv = 0;
            //                var total = 0;

            //                var con_igv = $('#chkCon_Igv').is(':checked');
            //
            //                if (con_igv) {
            //                    total = importe + recargo + descuento;
            //                    igv = total * vigv / (1 + vigv);
            //                    subtotal = total - igv;
            //                } else {
            //                    subtotal = importe + recargo + descuento;
            //                    igv = subtotal * vigv, 2;
            //                    total = subtotal + igv;
            //                }
            //
            //
            //                $('#txtSubTotal').val(redondear(subtotal, 4));
            //                $('#txtIgv').val(redondear(igv, 4));
            //                $('#txtTotal').val(redondear(total, 4));
            //            }
            //
            //            fncTotal();
            //
            //            $('#txtBuscarMP').keydown(function (e) {
            //                if (e.which == 13) {
            //                    fMP.enviar();
            //                    return false;
            //                }
            //            });

            var fncRegresar1 = function () {
                cambiarInterfaz('form2', 'form1', true, false, null);
            }

        </script>
        <!--        inicio imprimir-->


    <?php } ?>
    <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 1) { ?>
        <div class="float-mensaje">
            <?php echo $GLOBALS['mensaje']; ?>
        </div>
        <div id="muestra" >
            <!--        primera columna de tablas-->

            <table  style="width: 100%;margin-bottom: 10px;margin-top: 20px;height: 150px;">
                <tr>
                    <td style="width:50%;text-align:center;">
                        <div  style="width:100%;">
                            <img src="include/img/logo.JPG" alt="" style="height: 150px;"/>
                        </div>
                    </td>
                    <td style="width:50%;text-align:center;">
                        <div  style="width:100%;">
                            <table  style="width:100%;">
                                <tr>

                                    <td>
                                        R.U.C : 
                                    </td>								
                                </tr>
                                <tr>
                                    <td >
                                        GUIA DE REMISION REMITENTE
                                    </td>
                                </tr>
                                <tr>
                                    <td >
                                        001-NRO 004733
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>

            <!--       fin primera columna de tablas-->

            <!--       inicio segunda columna de tablas 100%-->
            <div style="margin-left: 20px;margin-right: 20px;margin-bottom: 5px;font-size: 10px;">
                <table  style="width:100%;">
                    <tr >
                        <td style="text-align: right;" rowspan="2"></td>
                        <td style="text-align: left;" rowspan="2"> <?php echo $GLOBALS['oGuia']->fecha; ?> </td>
                        <td style="text-align: right;" rowspan="2"></td>											
                        <td style="text-align: left;" rowspan="2">__/__/____   </td>
                        <td style="text-align: right;" rowspan="2"></td>
                        <td style="text-align: left;" rowspan="2"> <?php echo $GLOBALS['oRc']->nombres; ?> </td>
                        <td style="text-align: right;"></td>
                        <td style="text-align: left;">        </td>
                    </tr>
                    <tr style="border: 1px solid;">

                        <td style="text-align: right;"></td>
                        <td style="text-align: left;">         </td>
                    </tr>
                </table>
            </div>
            <!--       fin segunda columna de tablas 100%-->
            <!--        tercera columna de tablas-->

            <table  style="width: 100%;height: 40px;margin-bottom: 10px;margin-top: 20px;">
                <tr>
                    <td style="width:350px;text-align:center;">
                        <table  style="width:100%;">
                            <tr>
                                <th >
                                    
                                </th>								
                            </tr>
                            <tr>
                                <td style="font-size: 11px;"></td>
                            </tr>
                        </table>
                    </td>
                    <td style="width:350px;text-align:center;">
                        <table  style="width:100%;">
                            <tr>
                                <th  >
                                   
                                </th>								
                            </tr>
                            <tr >
                                <td style="font-size: 11px;"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <!--       fin tercera columna de tablas-->
            <!--       inicio cuarta columna de tablas-->
            <table  style="width: 100%;margin-bottom: 10px;margin-top: 20px;height: 80px;">
                <tr >
                    <td style="width:50%;text-align:center;">
                        <table  style="width:100%;">
                            <tr>
                                <th >
                                   
                                </th>								
                            </tr>
                            <tr >
                                <td style="font-size: 10px;">                             <?php echo $GLOBALS['oCliente']->ruc; ?> </td>
                            </tr>
                            <tr style="font-size: 11px;">
                                <td>R.U.C:   <?php echo $GLOBALS['oCliente']->ruc; ?></td>
                            </tr>

                        </table>
                    </td>
                    <td style="width:50%;text-align:center;">
                        <table  style="width:100%;">
                            <tr>
                                <th  >
                                    
                                </th>								
                            </tr>
                            <tr >
                                <td style="font-size: 11px;"> <?php
                                    echo $GLOBALS['oVehiculo']->placa;
                                    echo " ";
                                    echo $GLOBALS['oVehiculo']->descripcion
                                    ?> </td>
                            </tr>
                            <tr >
                                <td style="font-size: 11px;"> </td>
                            </tr>
                            <tr >
                                <td style="font-size: 11px;"> </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <!--     fin   cuarta columna de tablas-->

            <!--       inicio quinta columna de tablas-->
            <div style="margin-right: 20px;margin-bottom: 5px;">
                <table  style="width:100%;border-spacing:0"  >
                    <tr >
                        <th ></th>
                        <th></th>
                        <th ></th>
                        <th ></th>
                    </tr>
                    <?php
                    foreach ($GLOBALS['dtGv'] as $Detalle) {
                        ?>
                        <tr>
                            <td><?php echo $Detalle['cantidad'] ?></td>
                            <td><?php echo $Detalle['descripcion'] ?></td>
                            <td><?php echo $Detalle['precio_venta_unitario'] ?></td>
                            <td><?php echo $Detalle['precio_venta'] ?></td>
                        </tr>
        <?php }
        ?>
                </table>
            </div>
            <!--     fin   cuarta columna de tablas-->
        </div>



        <!--        codigo ortega div imprimir-->

        <script type="text/javascript">

            $(document).ready(function () {
                // Instrucciones a ejecutar al terminar la carga
                var ficha = document.getElementById('muestra');
                var ventimp = window.open(' ', 'popimpr');
                ventimp.document.write(ficha.innerHTML);
                ventimp.document.close();
                ventimp.print();
                ventimp.close();
            });

            setTimeout('window_float_save();', 1000);
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

    <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == -3) { ?>
        <div style="width:400px;margin:0 auto;">
            <div class="float-mensaje">
                <?php echo $GLOBALS['mensaje']; ?>
            </div>
            <div class="tool-btn" style ="text-align:center;">  
                <button  id="btnCancelar" name="btnCancelar" type="button" onclick="window_float_save();" >
                    <img title="Guardar" src='/include/img/boton/back_16x16.png' />
                    Regresar
                </button>      
            </div>
        </div>
    <?php } ?>
<?php } ?>
