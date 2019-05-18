<?php
function get_Inventario_Mantenimiento() {
    
    require ROOT_PATH . 'models/producto.php';
   
    require ROOT_PATH . 'models/estado.php';
    global $returnView;
    $returnView = true;
    $dtProducto=producto::getGrid("",-1,-1,"pr.nombre asc");
    $GLOBALS['dtProducto']=$dtProducto;
}
function post_ajaxInventario_Mantenimiento() {
    require ROOT_PATH . 'models/inventario.php';
    require ROOT_PATH . 'models/producto.php';
    require ROOT_PATH . 'controls/funcionController.php';
    $orden=$_POST['orden'];
    $paginaActual = $_POST['num_page'] == 0 ? 1 : $_POST['num_page'];
    $cantidadMostrar = $_POST['txtMostrar'] == '' ? 30 : $_POST['txtMostrar'];
    $campo_orden = $_POST['campo_orden'];

    try {
        $dt =inventario::getProducto($_SESSION['empresa_ID']); 
        
        $array_cabecera=array(
            array("cabecera"=>'N°',"class_alineado"=>'text-center',"campo"=>'ID',"filtro"=>"no"),
            array("cabecera"=>'Código',"class_alineado"=>'text-center',"campo"=>'codigo',"filtro"=>"si"),
            array("cabecera"=>'Producto',"class_alineado"=>'text-left',"campo"=>'nombre',"filtro"=>"si"),
            array("cabecera"=>'Estado',"class_alineado"=>'text-left',"campo"=>'estado',"filtro"=>"si"),
            array("cabecera"=>'UM',"class_alineado"=>'text-left',"campo"=>'unidad_medida',"filtro"=>"si"),
            array("cabecera"=>'Ingresos',"class_alineado"=>'text-center',"campo"=>'ingresos',"filtro"=>"si"),
            array("cabecera"=>'Salidas',"class_alineado"=>'text-center',"campo"=>'salidas',"filtro"=>"si"),
            array("cabecera"=>'Existencia',"class_alineado"=>'text-center',"campo"=>'existencias',"filtro"=>"si"),
            array("cabecera"=>'Opcion',"class_alineado"=>'text-center',"campo"=>'opcion',"filtro"=>"no")
        );
        
        $resultado=generador_tabla($dt,$array_cabecera,$campo_orden,$orden,$cantidadMostrar,$paginaActual); 
    } catch (Exception $ex) {
        log_error(__FILE__, "inventario/post_ajaxInventario_Mantenimiento", $ex->getMessage());
        
    }


    $mensaje = '';
    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
    //$retorn="<h1>Hola</h1>";

    echo json_encode($retornar);
}

function get_Inventario_Mantenimiento_Producto($id){
        require ROOT_PATH.'models/salida.php';
        require ROOT_PATH.'models/ingreso.php';
        require ROOT_PATH.'models/ingreso_detalle.php';
        require ROOT_PATH.'models/inventario.php';
        require ROOT_PATH.'models/producto.php';
        require ROOT_PATH.'models/moneda.php';
        require ROOT_PATH.'models/estado.php';
        require ROOT_PATH.'models/cliente.php';
        require ROOT_PATH.'models/operador.php';
        if(!class_exists('datos_generales'))require ROOT_PATH.'models/datos_generales.php';
        require ROOT_PATH.'models/unidad_medida.php';

        global  $returnView_float;
        $returnView_float=true;
        $oDatos_Generales=datos_generales::getByID(1);
        $oProducto=producto::getByID($id);
        $oUnidad_Medida=unidad_medida::getByID($oProducto->unidad_medida_ID);
        $oProducto->unidad_medida=$oUnidad_Medida->nombre;
        $oInventario=new inventario();
        $dtInventario=inventario::getGrid('producto_ID='.$id,-1,-1,'ID asc');
        $GLOBALS['oInventario']=$oInventario;  
        $GLOBALS['oProducto']=$oProducto;
        $GLOBALS['tabla']=extraerProductoMovimiento($id);
    }
function post_Ventas_Mantenimiento_Nuevo($id){
    require ROOT_PATH.'models/orden_venta.php';
    require ROOT_PATH.'models/moneda.php';
    require ROOT_PATH.'models/estado.php';
    require ROOT_PATH.'models/cliente.php';
    require ROOT_PATH.'models/representantecliente.php';
    require ROOT_PATH.'models/operador.php';
    if(!class_exists('datos_generales'))require ROOT_PATH.'models/datos_generales.php';
    require ROOT_PATH.'models/forma_pago.php';
    require ROOT_PATH.'models/credito.php';
    require ROOT_PATH.'models/cotizacion.php';
    require ROOT_PATH.'models/numero_cuenta.php';
    require ROOT_PATH.'models/orden_venta_numero_cuenta.php';
    require ROOT_PATH.'models/factura_venta.php';
    global  $returnView_float;
    $returnView_float=true;
    if(isset($_POST['txtCliente_ID'])){
        $Cliente_ID=$_POST['txtCliente_ID'];
    }else{$Cliente_ID=0;}
    $numero_orden_compra=$_POST['txtNumero_Orden_Compra'];
    $representante_cliente_ID=0;
    if(isset($_POST['selRepresentante'])){
        $representante_cliente_ID= $_POST['selRepresentante'];
    }

    $moneda_ID=$_POST['cboMoneda'];
    $tipo_cambio=$_POST['txtTipo_Cambio'];
    $plazo_entrega=$_POST['txtPlazo_Entrega'];
    $forma_pago_ID=$_POST['selForma_Pago'];
    $tiempo_credito=$_POST['selTiempo_Credito'];
    $fecha=$_POST['txtFecha'];
    $operador_ID=$_POST['txtOperador_ID'];
    $lugar_entrega=FormatTextSave($_POST['txtLugar_Entrega']);
    $validez_oferta=$_POST['txtValidez_Oferta'];
    $garantia=  FormatTextSave($_POST['txtGarantia']);
    $observacion=FormatTextSave($_POST['txtObservacion']);
    $ver_adicional=0;
    if(isset($_POST['ckVer_Adicional'])){
        $ver_adicional=$_POST['ckVer_Adicional'];
    }

    $adicional=FormatTextSave($_POST['txtAdicional']);
    try{
        $oDatos_Generales=datos_generales::getByID(1);
        if($id>0){
            $oOrden_Venta=orden_venta::getByID($id);
            $oOrden_Venta->numero_orden_compra=$numero_orden_compra;
            $oOrden_Venta->representante_cliente_ID=$representante_cliente_ID;
            $oOrden_Venta->moneda_ID=$moneda_ID;
            $oOrden_Venta->tipo_cambio=$tipo_cambio;
            $oOrden_Venta->plazo_entrega=$plazo_entrega;
            $oOrden_Venta->forma_pago_ID=$forma_pago_ID;
            $oOrden_Venta->tiempo_credito=$tiempo_credito;
            $oOrden_Venta->fecha=$fecha;
            $oOrden_Venta->lugar_entrega=$lugar_entrega;
            $oOrden_Venta->validez_oferta=$validez_oferta;
            $oOrden_Venta->garantia=$garantia;
            $oOrden_Venta->observacion=$observacion;
            $oOrden_Venta->ver_adicional=$ver_adicional;
            $oOrden_Venta->adicional=$adicional;
            $oOrden_Venta->usuario_mod_id=$_SESSION['usuario_ID'];
             $resultado=1;
             $mensaje="Se guardó correctamente";
            $oOrden_Venta->actualizar();

            if($oOrden_Venta->estado_ID==28){
                $Cliente_ID=$oOrden_Venta->cliente_ID;
                $resultado=3;
            }else if($oOrden_Venta->estado_ID==42){
                $resultado=2;
                $mensaje="No se puede modificar la orden de venta, los comprobantes ya fueron remitidos.";
            }


        }else if($id==0){

            $oOrden_Venta=new orden_venta();
            $oOrden_Venta->cotizacion_ID="null";
            $oOrden_Venta->cliente_ID=$Cliente_ID;
            $oOrden_Venta->representante_cliente_ID=$representante_cliente_ID;
            $oOrden_Venta->operador_ID=$operador_ID;
            $oOrden_Venta->periodo=date("Y");
            $oOrden_Venta->numero=orden_venta::getNumero();
            $numero_ceros=sprintf("%'.07d", $oOrden_Venta->numero);
            $numero_concatenado=$numero_ceros.'-'.$oOrden_Venta->periodo;
            $oOrden_Venta->numero_concatenado=$numero_concatenado;
            $oOrden_Venta->numero_orden_compra=$numero_orden_compra;
            $oOrden_Venta->moneda_ID=$moneda_ID;
            $oOrden_Venta->fecha=$fecha;
            $oOrden_Venta->igv=$oDatos_Generales->vigv;
            $oOrden_Venta->vigv_soles=0;
            $oOrden_Venta->vigv_dolares=0;
            $oOrden_Venta->precio_venta_neto_soles=0;
            $oOrden_Venta->precio_venta_total_soles=0;
            $oOrden_Venta->precio_venta_neto_dolares=0;
            $oOrden_Venta->precio_venta_total_dolares=0;
            $oOrden_Venta->forma_pago_ID=$forma_pago_ID;
            $oOrden_Venta->tiempo_credito=$tiempo_credito;
            $oOrden_Venta->descuento_soles=0;
            $oOrden_Venta->descuento_dolares=0;
            $oOrden_Venta->estado_ID=29;
            $oOrden_Venta->tipo_cambio=$tipo_cambio;
            $oOrden_Venta->plazo_entrega=$plazo_entrega;
            $oOrden_Venta->lugar_entrega=$lugar_entrega;
            $oOrden_Venta->validez_oferta=$validez_oferta;
            $oOrden_Venta->garantia=$garantia;
            $oOrden_Venta->observacion=$observacion;
            $oOrden_Venta->numero_pagina="1";
            $oOrden_Venta->nproducto_pagina="";
            $oOrden_Venta->usuario_id=$_SESSION['usuario_ID'];
            $oOrden_Venta->ver_adicional=$ver_adicional;
            $oOrden_Venta->adicional=$adicional;
            $oOrden_Venta->insertar();

            $mensaje="Se guardó correctamente";
            $resultado=1;
        }
        //insertamos los numero de cuentas
        //limpiamos si existen registros
        $dtOrden_Venta_Numero_Cuenta=orden_venta_numero_cuenta::getGrid('orden_venta_ID='.$oOrden_Venta->ID);
        if(count($dtOrden_Venta_Numero_Cuenta)>0){
            foreach($dtOrden_Venta_Numero_Cuenta as $item){
            $oOrden_Venta_Numero_Cuenta=orden_venta_numero_cuenta::getByID($item['ID']);
            $oOrden_Venta_Numero_Cuenta->usuario_mod_id=$_SESSION['usuario_ID'];
            $oOrden_Venta_Numero_Cuenta->eliminar();
            }
        }
        //ingresamos los valores
        $dtNumero_Cuenta=numero_cuenta::getGrid('moneda_ID='.$oOrden_Venta->moneda_ID);

        foreach($dtNumero_Cuenta as $value){
            if(isset($_POST['cknumero_cuenta'.$value['ID']])){
                $numero_cuenta_ID=$_POST['cknumero_cuenta'.$value['ID']];
                $oOrden_Venta_Numero_Cuenta=new orden_venta_numero_cuenta();
                $oOrden_Venta_Numero_Cuenta->orden_venta_ID=$oOrden_Venta->ID;
                $oOrden_Venta_Numero_Cuenta->numero_cuenta_ID=$numero_cuenta_ID;
                $oOrden_Venta_Numero_Cuenta->usuario_id=$_SESSION['usuario_ID'];
                $oOrden_Venta_Numero_Cuenta->insertar();
               // $checked="checked";
            }
        }

    }

    catch (Exception $ex){
        $resultado=-1;
        $mensaje=$ex->getMessage();

    }
    $dtRepresentanteCliente=representantecliente::getGrid('pr.cliente_ID='.$Cliente_ID);
    $GLOBALS['dtRepresentanteCliente']=$dtRepresentanteCliente;
    $oCliente=cliente::getByID($Cliente_ID);
    $oOperador=operador::getByID($oOrden_Venta->operador_ID);
    $dtForma_Pago=forma_pago::getGrid();
    $dtCredito=credito::getGrid('id<>0');
    $oNumero_Cuenta=numero_cuenta::getByID(1);
    $dtEstado=estado::getGrid('est.tabla="cotizacion"');
   if($oOrden_Venta->cotizacion_ID="NULL"){
       $oCotizacion=new cotizacion();
   }else {
       $oCotizacion=cotizacion::getByID($oOrden_Venta->cotizacion_ID);
   }
    $oFactura_Venta=new factura_venta();       
    $oFactura_Venta->ID=0;
    $GLOBALS['dtNumero_Cuenta']=mostrarNumeroCuentas(2,$oOrden_Venta->moneda_ID,$oOrden_Venta);
    $GLOBALS['oOrden_Venta']=$oOrden_Venta;
    $GLOBALS['oFactura_Venta']=$oFactura_Venta;
    $GLOBALS['oCliente']=$oCliente;
    $GLOBALS['oCotizacion']=$oCotizacion;
    $GLOBALS['dtCredito']=$dtCredito;
    $GLOBALS['oOperador']=$oOperador;
    $GLOBALS['oDatos_Generales']=$oDatos_Generales;
    $GLOBALS['dtForma_Pago']=$dtForma_Pago;
    $GLOBALS['dtEstado']=$dtEstado;
    $GLOBALS['oNumero_Cuenta']=$oNumero_Cuenta;
    $GLOBALS['dtMoneda']=moneda::getGrid('',-1,-1,'ID desc');
    $GLOBALS['resultado']=$resultado;
    $GLOBALS['mensaje']=$mensaje;
}
function extraerProductoMovimiento($producto_ID){
     $resultado="<table class='table table-hover table-bordered table-teal'><thead><tr>";
        $resultado.="<th rowspan='2'>Fecha</th>";
        $resultado.="<th rowspan='2'>Detalle</th>";
        $resultado.="<th colspan='4' class='text-center'>Entradas</th>";
        $resultado.="<th colspan='4' class='text-center'>Salidas</th>";
        $resultado.="<th rowspan='2' class='text-center'>Existencia</th>";
        $resultado.="</tr>";
        $resultado.="<tr>";
        $resultado.="<th>Cantidad</th>";
        $resultado.="<th>Moneda</th>";
        $resultado.="<th>V/Unitario</th>";
        $resultado.="<th>V/Total</th>";
        
        $resultado.="<th>Cantidad</th>";
        $resultado.="<th>Moneda</th>";
        $resultado.="<th>V/Unitario</th>";
        $resultado.="<th>V/Total</th>";
        $resultado.="</tr></head><tbody>";
    try{
        $existencia_cantidad=0;
        
        $resultado.="<td class='center'>01/01/2016</td>";
        $resultado.="<td>Saldo anterior</td>";
        $resultado.="<td></td>";
        $resultado.="<td></td>";
        $resultado.="<td></td>";
        $resultado.="<td></td>";
        $resultado.="<td></td>";
        $resultado.="<td></td>";
        $resultado.="<td></td>";
        $resultado.="<td></td>";
        $resultado.="<td class='text-center'>".$existencia_cantidad."</td>";
        $resultado.="</tr>";
        
        $dtProducto_Movimiento=inventario::getMovimientoProductos($producto_ID);
        
       /* $array=uasort($dtProducto_Movimiento,"cmp");*/
        $total=count($dtProducto_Movimiento);
        $i=0;
        foreach( $dtProducto_Movimiento as $item){
            $i++;
            $resultado.="<td class='center'>".date('d/m/Y',strtotime($item['fecha']))."</td>";
            $resultado.="<td>".$item['movimiento']." con Factura ".$item['serie']."-".$item['numero']."</td>";
            $precio_unitario=$item['precio']+$item['igv']/$item['cantidad'];
            $link_Cantidad='<a class="btn btn-teal" title="Ver series" onclick="fncVerSeries(&#39;'.$item['movimiento'].'&#39;,'.$item['movimiento_ID'].');">'.$item['cantidad'].'</a>';
            if($item['movimiento']=="Ingreso"){
                $resultado.="<td class='text-center'>".$link_Cantidad."</td>";
                $resultado.="<td>".$item['moneda']."</td>";
                $resultado.="<td class='text-right' >".number_format($precio_unitario,2,'.',',')."</td>";
                $resultado.="<td class='text-right' >".number_format($item['total'],2,'.',',')."</td>";
                $resultado.="<td></td>";
                $resultado.="<td></td>";
                $resultado.="<td></td>";
                $resultado.="<td></td>";
                $existencia_cantidad=$existencia_cantidad+$item['cantidad'];
               
            }else {
                
                $resultado.="<td></td>";
                $resultado.="<td></td>";
                $resultado.="<td></td>";
                $resultado.="<td></td>"; 
                $resultado.="<td class='center'>".$link_Cantidad."</td>";
                $resultado.="<td >".FormatTextViewHtml($item['moneda'])."</td>";
                $resultado.="<td class='text-right' >".number_format($precio_unitario,2,'.',',')."</td>";
                $resultado.="<td class='text-right' >".number_format($item['total'],2,'.',',')."</td>";
                $existencia_cantidad=$existencia_cantidad-$item['cantidad'];
            }
            $link_existencia_cantidad=$existencia_cantidad;
            if($i==$total){
                $link_existencia_cantidad='<a class="btn btn-teal" title="Ver series" onclick="fncVerSeries(&#39;Existencia&#39;,'.$item['producto_ID'].');">'.$existencia_cantidad.'</a>';
            }
           
            $resultado.="<td class='text-center'>".$link_existencia_cantidad."</td>";
             $resultado.="</tr>";
             
        }
        
    }catch(Exception $ex){
        $resultado.="<tr><td colspan='16'>";
        $resultado.=$ex->getMessage();				
        $resultado.="</td></tr>";
    }
    $resultado.="</tbody>";
    $resultado.="</table>";
    return $resultado;
}   

function VerSeries($tipo,$codigo){
    require ROOT_PATH.'models/inventario.php';
    //$tipo=$_POST['id'];
    //$codigo=$_POST['id1'];
    //$tipo="compra";
    //$codigo=$_POST['id1'];
    $filtro='';
    
    $resultado='<table class="table table-bordered table-hover">';
    $resultado.='<thead>';
    $resultado.='<tr>';
    $resultado.='<th>Nro</th>';
    $resultado.='<th>N&uacute;mero Serie</th>';
    $resultado.='</tr>';
    $resultado.='</thead>';
    $resultado.='<tbody>';
    try{
        
        if ($tipo=="Ingreso"){
            $filtro="ingreso_detalle_ID=".$codigo;
        }else if($tipo=="Salida") {
             $filtro="salida_detalle_ID=".$codigo;
        }else {
            $filtro='producto_ID='.$codigo.' and estado_ID=48';
        }
       
        $dtInventario=inventario::getGrid($filtro,-1,-1,'ID asc');
        $i=1;
        foreach($dtInventario as $item){
            $serie='';
            if($item['serie']!='NULL'){
                $serie=$item['serie'];
            }
            $resultado.='<tr>';
            $resultado.='<td class="center">'.$i.'</td>';
            $resultado.='<td class="left" style="padding-left:5px;">'.$serie.'</td>';
            $resultado.='</tr>';
            $i++;
        }
    } catch (Exception $ex) {
        $resultado.='<tr><td colspan="2">'.$ex->getMessage().'</td></tr>';
    }
    $resultado.='</tbody>';
    $resultado.='</table>';
    return $resultado;
    /*$retornar=Array('resultado'=>$resultado);
    echo json_encode($retornar);*/
}
function get_Inventario_Mantenimiento_Serie($id){
    global  $returnView_float;
    $returnView_float=true;
    $tipo=$_GET['tipo'];
    $GLOBALS['table']=VerSeries($tipo,$id);
}