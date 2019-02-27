<?php

    function get_Index($id){
        global $returnView;
        $returnView=true;
    }
    /*======================Compras =================*/
    function get_Compra_Mantenimiento(){
        require ROOT_PATH . 'models/proveedor.php';
        //require ROOT_PATH . 'models/comprobante_tipo.php';
        require ROOT_PATH . 'models/estado.php';
        require ROOT_PATH . 'models/moneda.php';
        
        global $returnView;
        $returnView=true;
        $dtProveedor=proveedor::getGrid('ID<>0',-1,-1,"razon_social asc");
        //$dtComprobante_Tipo=comprobante_tipo::getGrid('ID<>0');
        $dtEstado=estado::getGrid('tabla="ingreso" and ID in (9,11)');
        $dtMoneda=moneda::getGrid();
        $GLOBALS['dtProveedor']=$dtProveedor;
        //$GLOBALS['dtComprobante_Tipo']=$dtComprobante_Tipo;
        $GLOBALS['dtEstado']=$dtEstado;
        $GLOBALS['dtMoneda']=$dtMoneda;
    }
    
   
    
function post_ajaxCompra_Mantenimiento() {
    require ROOT_PATH . 'models/ingreso.php';
    require ROOT_PATH . 'controls/funcionController.php';
    //$buscar = $_POST['txtBuscar'];
    $opcion_tipo=$_POST['rbOpcion'];
    $paginaActual = $_POST['num_page'] == 0 ? 1 : $_POST['num_page'];
    $cantidadMostrar = $_POST['txtMostrar'] == '' ? 30 : $_POST['txtMostrar'];
    $txtOrden = $_POST['txtOrden'];
    $orden_tipo = 'DESC';
    $orden_class = 'imgOrden-desc';
    if (isset($_POST['chkOrdenASC'])) {
        $orden_class = 'imgOrden-asc';
        $orden_tipo = 'ASC';
    }
    switch ($txtOrden) {
        case 1:
            $orden = 'co.codigo ' . $orden_tipo;
            break;
        case 2:
            $orden = 'co.serie ' . $orden_tipo;
            break;
        case 3:
            $orden = 'co.numero ' . $orden_tipo;
            
            break;
       
        case 4:
           
            $orden = 'co.numero_guia ' . $orden_tipo;
            break;
        case 5:
            $orden = 'pr.razon_social ' . $orden_tipo;
            //
            
            break;
        case 6:
             $orden = 'co.fecha_emision ' . $orden_tipo;
          
            
            break;
        case 7:
            
            $orden = 'mo.descripcion ' . $orden_tipo;
            break;
        case 8:
            $orden = 'co.total ' . $orden_tipo;
            break;
        case 9:
            $orden = 'est.nombre ' . $orden_tipo;
            
            break;
        default:
            $orden = 'co.ID ' . $orden_tipo;
            break;
    }
    $filtro="co.tipo_movimiento_ID=1";
    if($opcion_tipo=="buscar"){
        
        
        $serie=trim($_POST['txtSerie']);
        if(ltrim($serie,0)!=''){
            if($filtro!=''){
                $filtro.=' and ';
            }
            $filtro='co.serie="'.$serie.'"';
        }
        $numero=trim($_POST['txtNumero']);
        if(ltrim($numero,0)!=''){
            if($filtro!=''){
                $filtro.=' and ';
            }
            $filtro.='co.numero="'.ltrim($numero,0).'"';
        }
        
        $codigo=trim($_POST['txtCodigo']);
        if(ltrim($codigo,0)!=''&&$codigo!=0){
            if($filtro!=''){
                $filtro.=' and ';
            }
            $filtro='co.codigo='.$codigo.'';
        }
    }else {
        $proveedor_ID=$_POST['selProveedor'];
        $estado_ID=$_POST['selEstado'];
        $fecha_inicio=$_POST['txtFechaInicio'];
        $fecha_fin=$_POST['txtFechaFin'];
        $moneda_ID=$_POST['selMoneda'];
        
        $todos=(isset($_POST['ckTodos']))? 1 : 0;
        if($proveedor_ID!=0){
            if($filtro!=''){
                $filtro.=' and ';
            }
            $filtro.="co.proveedor_ID=".$proveedor_ID;
        }
         if($estado_ID!=0){

            $filtro.=((trim($filtro)!="")?" and ":""). "co.estado_ID=".$estado_ID;
        }
        if($moneda_ID!=0){
            $filtro.=((trim($filtro)!="")?" and ":"")."co.moneda_ID=".$moneda_ID;
        }
        if($todos==0){
            if($fecha_inicio!="" &&$fecha_fin!="" ){

                $filtro.=((trim($filtro)!="")?" and ":"")." co.fecha_emision between '".FormatTextToDate($fecha_inicio, "Y-m-d")."' and '". FormatTextToDate($fecha_fin,"Y-m-d"). "'";
            }
        }
        
    }
    
    //$filtro = 'upper(pr.razon_social) like "%' . str_replace(' ', '%', strtoupper(FormatTextSave($buscar))) . '%"';

    //---------------------------------------					 
    $resultado = '<table id="websendeos" class="grid table table-hover table-teal table-bordered"><thead><tr>';
    $resultado.='<th class="thOrden">#</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(1);">Código' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(2);">Serie' . (($txtOrden == 2 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(3);">Número' . (($txtOrden == 3 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(4);">Nro guía' . (($txtOrden == 4 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(5);">Proveedor' . (($txtOrden == 5 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(6);">Fecha Emisión' . (($txtOrden == 6 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(7);">Moneda' . (($txtOrden == 7 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(8);">Total' . (($txtOrden == 8 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(9);">Estado' . (($txtOrden == 9 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th></th>';
    $resultado.='</tr></thead>';
    $resultado.='<tbody>';
    $colspanFooter = 11;
    try {
        $cantidadMaxima = ingreso::getCount($filtro);
        $dtCompra = ingreso::getGrid($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
        $rows = count($dtCompra);
         $i=(($paginaActual-1) * $cantidadMostrar)+1;
         //$i=1;
        foreach ($dtCompra as $item) {
            
            $resultado.='<tr class="tr-item">';
            $resultado.='<td class="text-center">'.$i.'</td>';
            $resultado.='<td class="text-center">' . sprintf("%'.07d",$item['codigo']). '</td>';
            $resultado.='<td class="text-center">' . $item['serie'] . '</td>';
            $resultado.='<td class="text-center">' . sprintf("%'.09d",$item['numero']) . '</td>';
            $resultado.='<td class="tdLeft">' . $item['numero_guia'] . '</td>';
            $resultado.='<td class="tdLeft">' . utf8_encode(strtoupper($item['proveedor'])) . '</td>';
            $resultado.='<td class="text-center">' . date("d/m/Y",strtotime($item['fecha_emision'])) . '</td>';
            $resultado.='<td class="tdLeft">' . utf8_encode($item['moneda']) . '</td>';
            $resultado.='<td class="tdLeft">' . number_format($item['total'],2,'.',',') . '</td>';
            $resultado.='<td class="tdLeft">' . utf8_encode($item['estado']) . '</td>';
            $botones=array();
            
          
            if($item['estado_ID']==11){
                array_push($botones,'<a onclick="fncVerDetalle(' . $item['ID'] . ');" title=""><img src="/include/img/boton/find_14x14.png" /> Ver</a>');
                

            }else{
                array_push($botones,'<a onclick="fncEditar(' . $item['ID'] . ');" title="Editar" ><img src="/include/img/boton/edit_14x14.png" /> Editar</a>');
                //array_push($botones,'<a onclick="fncEliminar(' . $item['ID'] . ');" title="Eliminar" ><img src="/include/img/boton/delete_14x14.png" /> Eliminar</a>');
                array_push($botones,'<a onclick="modal.confirmacion(&#39;El proceso es irreversible, esta seguro de eliminar el registro.&#39;,&#39;Eliminar&#39;,fncEliminar,&#39;' . $item['ID'] . '&#39;);" title="Eliminar compra"><img src="/include/img/boton/delete_14x14.png" /> Eliminar</a>');
            }
            
            $resultado.='<td class="btnAction">'.extraerOpcion($botones).'</td>';
            $resultado.='</tr>';
            $i=$i+1;
        }

        $cantidadPaginas = '';
        $resultado.=paginacion($cantidadMaxima,$cantidadMostrar,$colspanFooter,$paginaActual);
        $resultado.='<tr class="tr-footer"><th colspan=' . $colspanFooter . '>' . $rows . ' de ' . $cantidadMaxima . ' Registros</th></tr>';
    } catch (Exception $ex) {
        $resultado.='<tr ><td colspan=' . $colspanFooter . '>' . $ex->getMessage() . '</td></tr>';
    }
    $resultado.='</tbody>';
    $resultado.='</table>';

    $mensaje = '';
    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
    //$retorn="<h1>Hola</h1>";

    echo json_encode($retornar);
}

function get_Compra_Mantenimiento_Nuevo(){
    require ROOT_PATH.'models/ingreso.php';
    
    require ROOT_PATH.'models/estado.php';
    require ROOT_PATH.'models/moneda.php';
    require ROOT_PATH.'models/tipo_comprobante.php';
    require ROOT_PATH.'models/forma_pago.php';
    if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";
    require ROOT_PATH.'models/proveedor.php';
    global $returnView_float;
    $returnView_float=true;
    //$Configuracion_Empresa=configuracion_empresa::getGrid("empresa_ID=".$_SESSION['empresa_ID']);
    $oDatos_generales=datos_generales::getByID1($_SESSION['empresa_ID']);
    $oCompra = new ingreso();
    $oCompra->oEstado=estado::getByID(estado_compra);
    $oCompra->dtEstado=estado::getGrid("est.ID in (".estado_compra.")",-1,-1);
    $oCompra->dtMoneda=moneda::getGrid('',-1,-1,'ID desc');
    //$dtTipo_Comprobante=tipo_comprobante_empresa::getGrid('accion="compra"');
    $dtTipo_Comprobante=tipo_comprobante::getComprobantes(0,"compra",0,compra_tipo_comprobante_ID,"tipo_comprobantes_sinserie");
    $dtProveedor=proveedor::getGrid("prv.empresa_ID=".$_SESSION['empresa_ID'],-1,-1,"prv.razon_social asc");
    $oCompra->moneda_ID=moneda;
    $oCompra->dtTipo_Comprobante=$dtTipo_Comprobante;
    $oCompra->tipo_comprobante_ID=compra_tipo_comprobante_ID;
    $oCompra->dtProveedor=$dtProveedor;
    $oCompra->ID=0;
    $oCompra->orden_ingreso_ID=0;
    $oCompra->numero_orden_ingreso='';
    $oCompra->tipo_cambio=$oDatos_generales->tipo_cambio;
    //$oCompra->dtForma_Pago=forma_pago::getGrid('ID>0',-1,-1,'ID asc');
    $oCompra->vigv=$oDatos_generales->vigv;
    $GLOBALS['oCompra']=$oCompra;
 
    
}
function post_Compra_Mantenimiento_Nuevo(){
   
    require ROOT_PATH.'models/ingreso.php';
    require ROOT_PATH.'models/orden_ingreso.php';
   
    require ROOT_PATH.'models/estado.php';
    require ROOT_PATH.'models/moneda.php';
    require ROOT_PATH.'models/forma_pago.php';
    require ROOT_PATH.'models/proveedor.php';

    require ROOT_PATH.'models/tipo_comprobante_empresa.php';

     if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";
    global $returnView_float;
    $returnView_float=true;
    $ID=$_POST['txtID'];
    $orden_compra_ID=$_POST['txtOrden_Compra_ID'];
    $tipo_comprobante_ID=$_POST['cboComprobante_Tipo'];
    $serie=$_POST['txtSerie'];
    $numero=$_POST['txtNumero_Factura'];
    //$forma_pago_ID=$_POST['selForma_Pago'];
    $fecha_emision=$_POST['txtFecha_Emision'];
    $fecha_vencimiento=$_POST['txtFecha_Vencimiento'];
    $proveedor_ID=$_POST['selProveedor'];
    $numero_guia=$_POST['txtNumero_Guia'];
    $vigv=$_POST['txtVigv']/100;
    $moneda_ID=$_POST['cboMoneda'];
    $tipo_cambio=$_POST['txtTipo_Cambio'];
    $descripcion=  $_POST['txtComentario'];
    //$Configuracion_Empresa=configuracion_empresa::getGrid("empresa_ID=".$_SESSION['empresa_ID']);
    
    try{
        if($ID==0){
             $oCompra=new ingreso();
        }else {
            $oCompra=ingreso::getByID($ID);
            if($oCompra==null){
                $GLOBALS['resultado'] = -2;
                $GLOBALS['mensaje'] = "La compra ha sido eliminado por otro usuario";
                return;
            }
            $moneda_ID_old=$oCompra->moneda_ID;
        }
        if($orden_compra_ID!=0){
            $oCompra->orden_ingreso_ID=$orden_compra_ID;
        }
        $oCompra->tipo_comprobante_ID=$tipo_comprobante_ID;
        $oCompra->serie=$serie;
        $oCompra->numero=ltrim($numero,0);
        $oCompra->fecha_emision=$fecha_emision;
        $oCompra->fecha_vencimiento=$fecha_vencimiento;
        $oCompra->proveedor_ID=$proveedor_ID;
        $oCompra->numero_guia=$numero_guia;
        $oCompra->vigv=$vigv;
        $oCompra->moneda_ID=$moneda_ID;
        //$oCompra->forma_pago_ID=$forma_pago_ID;
        $oCompra->tipo_cambio=$tipo_cambio;
        $oCompra->descripcion=$descripcion;
        //Ponemos estado en pendiente
        $oCompra->estado_ID=9;
        $oCompra->con_igv=1;
        
        if($oCompra->verificarDuplicado()>0){
                throw new Exception($oCompra->message);
        }
        if($ID==0){
            $oCompra->tipo_movimiento_ID=1;
            $oCompra->descuento=0;
            $oCompra->recargo=0;
            $oCompra->subtotal=0;
            $oCompra->total=0;
            $oCompra->periodo=date('Y');
            $oCompra->monto_pendiente=0;
            $oCompra->usuario_id=$_SESSION['usuario_ID'];
            $oCompra->insertar1();
            $oCompra->orden_ingreso_ID='-1';
        }else {
            $oCompra->usuario_mod_id=$_SESSION['usuario_ID'];
            $oCompra->actualizar();
            actualizar_costo_compra_detalle($oCompra,$moneda_ID_old);
        }
        actualizar_costo_compra($oCompra);
       $numero_orden_compra='';
       if($oCompra->orden_ingreso_ID!='-1'){
           $oOrden_Compra=orden_ingreso::getByID($oCompra->orden_ingreso_ID);
           $numero_orden_compra=sprintf("%'.07d",$oOrden_Compra->numero_orden);
       }
       $oCompra->numero_orden_ingreso=$numero_orden_compra;
       $GLOBALS['resultado']=1;
       $GLOBALS['mensaje'] =$oCompra->message;

    }catch(Exception $ex){
        $GLOBALS['resultado'] = -1;
        $GLOBALS['mensaje'] = $ex->getMessage();
    }
    $oCompra->dtForma_Pago=forma_pago::getGrid('ID>0',-1,-1,'ID asc');
    $oProveedor=proveedor::getByID($oCompra->proveedor_ID);
    $dtProveedor=proveedor::getGrid("prv.empresa_ID=".$_SESSION['empresa_ID'],-1,-1,"prv.razon_social asc");
    $oCompra->oProveedor=$oProveedor;
    $oCompra->dtProveedor=$dtProveedor;
    $oDatos_generales=datos_generales::getByID1($_SESSION['empresa_ID']);
    $oCompra->dtMoneda=moneda::getGrid();
    $dtFormaPago=forma_pago::getGrid();
    $dtTipo_Comprobante=tipo_comprobante_empresa::getGrid('tce.accion="compra"');
    $oCompra->dtTipo_Comprobante=$dtTipo_Comprobante;
    $oCompra->oEstado=estado::getByID($oCompra->estado_ID);
    $oCompra->numero=sprintf("%'.09d",$oCompra->numero);
    $GLOBALS['oCompra']=$oCompra;

}
function get_compra_mantenimiento_buscar_orden(){
    require ROOT_PATH.'models/orden_ingreso.php';
    require ROOT_PATH.'models/estado.php';
    require ROOT_PATH.'models/moneda.php';
    require ROOT_PATH.'models/comprobante_tipo.php';
    require ROOT_PATH.'models/forma_pago.php';
     if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";
    global $returnView_float;
    $returnView_float=true;
    $dtOrden_Compra=orden_ingreso::getGrid('oc.empresa_ID='.$_SESSION['empresa_ID'].' and oc.estado_ID=56',-1,-1,'oc.numero_orden desc');
    
    $GLOBALS['dtOrden_Compra']=$dtOrden_Compra;
 
}
function get_Compra_Mantenimiento_Nuevo_Producto($compra_ID){
    require ROOT_PATH . 'models/categoria.php';
    require ROOT_PATH . 'models/linea.php';
    require ROOT_PATH . 'models/producto.php';
    require ROOT_PATH . 'models/estado.php';
    require ROOT_PATH . 'models/ingreso_detalle.php';
    require ROOT_PATH . 'models/ingreso.php';
    require ROOT_PATH . 'models/inventario.php';
    if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";;
    require ROOT_PATH . 'models/salida.php';
    require ROOT_PATH . 'models/salida_detalle.php';
    require ROOT_PATH . 'models/factura_venta.php';
    require ROOT_PATH . 'models/guia_venta.php';
    //require ROOT_PATH . 'models/guia_venta_numero.php';
    require ROOT_PATH . 'models/moneda.php';
        global $returnView_float;
        $returnView_float=true; 
        $oCategoria=new categoria();
        $oLinea=new linea();
        $oEstado=new estado();
        $oProducto=new producto();
        $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
        $dtCategoria=$oCategoria->getGrid('',-1,-1,'ca.nombre asc');
        $dtLinea=$oLinea->getGrid('',-1,-1,'li.nombre asc');
        
        //$oInventario=new inventario();
        //$oInventario->ID=0;
        //$dtEstado=$oEstado->getGrid('tabla="producto"',-1,-1,'orden');
        $dtProducto=$oProducto->getGrid('',-1,-1,'pr.nombre asc');
        $oCompra=ingreso::getByID($compra_ID);
        $oCompra_detalle=new ingreso_detalle();
        $oCompra_detalle->dtProducto=producto::getGrid("",-1,-1,"pr.nombre asc");
        $oCompra_detalle->ID=0;
        $oCompra_detalle->destino=1;
        $oCompra_detalle->vigv=$oCompra->vigv;
        $oCompra_detalle->oMoneda=moneda::getByID($oCompra->moneda_ID);
        $GLOBALS['fecha']=$oCompra->fecha_emision;
        $oCompra_detalle->stock=0;
        $oCompra_detalle->oProducto=new producto();
        $GLOBALS['compra_ID']=$compra_ID;
        $GLOBALS['dtCategoria']=$dtCategoria;
        $GLOBALS['categoria_ID']=0;
        $GLOBALS['dtLinea']=$dtLinea;
        $GLOBALS['linea_ID']=0;
       
        //$GLOBALS['dtEstado']=$dtEstado;
        //$GLOBALS['dtProducto']=$dtProducto;
        $GLOBALS['oCompra_Detalle']=$oCompra_detalle;
        
    }
function post_Compra_Mantenimiento_Nuevo_Producto($ID){
    require ROOT_PATH . 'models/categoria.php';
    require ROOT_PATH . 'models/linea.php';
    require ROOT_PATH . 'models/producto.php';
    require ROOT_PATH . 'models/estado.php';
    require ROOT_PATH . 'models/ingreso_detalle.php';
    require ROOT_PATH . 'models/ingreso.php';
    require ROOT_PATH . 'models/inventario.php';
    require ROOT_PATH . 'models/factura_venta.php';
    require ROOT_PATH . 'models/salida.php';
    require ROOT_PATH . 'models/salida_detalle.php';
    require ROOT_PATH . 'models/moneda.php';
    require ROOT_PATH . 'models/guia_venta.php';
    require ROOT_PATH . 'models/operador.php';
    global $returnView_float;
    $returnView_float=true;
    //$ID=$_POST['txtID'];
    //$inventario_ID=$_POST['txtInventarioID1'];
    $compra_ID=$ID;
    $linea_ID=$_POST['selLinea'];
    $categoria_ID=$_POST['selCategoria'];
    $producto_ID=$_POST['selProducto'];
    $descripcion=  $_POST['txtDescripcion'];
    $cantidad=$_POST['txtCantidad'];
    $precio=$_POST['txtPrecioUnitario'];
    $subtotal=$_POST['txtSubTotal'];
    $igv=$_POST['txtIgv'];
    $total=$_POST['txtTotal'];
    $destino=$_POST['rbDestino'];
    //$fecha_emision=$_POST['txtfechaEmision'];
    try{
        $oCompra=ingreso::getByID($ID);
        $oCompra_detalle=new ingreso_detalle();
       
        $oCompra_detalle->producto_ID=$producto_ID;
        $oCompra_detalle->ingreso_ID=$ID;
       
        $oCompra_detalle->descripcion=$descripcion;
        $oCompra_detalle->cantidad=$cantidad;
        $oCompra_detalle->precio=$precio;
        $oCompra_detalle->subtotal=$subtotal;
        $oCompra_detalle->igv=$igv;
        $oCompra_detalle->total=$total;
        $oCompra_detalle->destino=$destino;
        $oCompra_detalle->usuario_id=$_SESSION['usuario_ID'];
        $oCompra_detalle->insertar1();
        
        actualizar_costo_compra($oCompra);
        if($destino==1){
            for($y=0; $y<$cantidad; $y++){
                $oInventario=new inventario();
                $oInventario->producto_ID=$producto_ID;
                $oInventario->ingreso_detalle_ID=$oCompra_detalle->ID;
                //$oInventario->salida_detalle_ID='NULL';
                //$oInventario->cotizacion_detalle_ID='NULL';
                $oInventario->descripcion=$descripcion;
                $oInventario->usuario_id=$_SESSION['usuario_ID'];
                $oInventario->estado_ID=48;
                $oInventario->utilidad_soles=0;
                $oInventario->utilidad_dolares=0;
                $oInventario->comision_soles=0;
                $oInventario->comision_dolares=0;
                $oInventario->serie="";
                $oInventario->insertar();
                $mensaje=$oInventario->getMessage;
            }

        }else {
            $cantidad_total=$cantidad;
            $contador=0;
            $dtInventario_salida=inventario::getsalida_detalle($producto_ID,$oCompra_detalle->ID);
            foreach($dtInventario_salida as $item){
                $salida_detalle_ID=$item['salida_detalle_ID'];
                $osalida_detalle=salida_detalle::getByID($salida_detalle_ID);
               if($osalida_detalle!=null){
                    if(isset($_POST[$item['salida_detalle_ID']])){
                    $cantidad1=$item['cantidad'];
                    $IDs=explode("|", $_POST[$item['salida_detalle_ID']]);
                        for($b=0;$b<count($IDs);$b++){
                            $oInventario=inventario::getByID($IDs[$b]);
                            $oInventario->ingreso_detalle_ID=$oCompra_detalle->ID;
                            $oInventario->descripcion=$oCompra_detalle->descripcion;
                            $oInventario->estado_ID=49;
                            $oInventario->usuario_mod_id=$_SESSION['usuario_ID'];
                            $oInventario->actualizar();
                            $mensaje=$oInventario->getMessage;
                            actualizarInventario($oInventario);
                            //$cantidad_total=$cantidad_total-1;
                            $contador++;
                        }  
                    }
               } 
            }
            $cantidad_faltante=$cantidad_total-$contador; 
            if($cantidad_faltante>0){
                for($a=0; $a<$cantidad_faltante; $a++){    
                    if($cantidad_total>$contador){
                        $oInventario=new inventario();
                        $oInventario->producto_ID=$producto_ID;
                        $oInventario->ingreso_detalle_ID=$oCompra_detalle->ID;
                        $oInventario->cotizacion_detalle_ID='NULL';
                        $oInventario->salida_detalle_ID='NULL';
                        $oInventario->descripcion=$descripcion;
                        $oInventario->usuario_id=$_SESSION['usuario_ID'];
                        $oInventario->estado_ID=48;
                        $oInventario->utilidad_soles=0;
                        $oInventario->utilidad_dolares=0;
                        $oInventario->comision_soles=0;
                        $oInventario->comision_dolares=0;
                        $oInventario->serie="NULL";
                        $oInventario->insertar();
                        $mensaje=$oInventario->getMessage;
                        //$cantidad_total=$cantidad_total-1;
                        $contador++;
                    }
                }

            }


        }
        //$oCompra=ingreso::getByID($compra_ID);
        $GLOBALS['resultado'] = 1;
        $GLOBALS['mensaje'] = $mensaje; 
    } catch (Exception $ex) {
        $GLOBALS['resultado'] = -1;
        $GLOBALS['mensaje'] = $ex->getMessage(); 
    }
    $oCompra=ingreso::getByID($compra_ID);
    $oCompra_detalle->vigv=$oCompra->vigv;
    $dtLinea=linea::getGrid('',-1,-1,'li.nombre asc');
    if($linea_ID!=0){
        $dtCategoria=categoria::getGrid('ca.linea_ID='.$linea_ID,-1,-1,'li.nombre asc');
    }else{
        $dtCategoria=categoria::getGrid('',-1,-1,'li.nombre asc');

    }
    if($categoria_ID!=0){
        $dtProducto=producto::getGrid('pr.categoria_ID='.$categoria_ID,-1,-1,'pr.nombre asc');
    }else{
        $dtProducto=producto::getGrid('',-1,-1,'pr.nombre');

    }
    $oCompra_detalle->oMoneda=moneda::getByID($oCompra->moneda_ID);
    $oCompra_detalle->dtProducto=producto::getGrid("",-1,-1,"pr.nombre asc");
    $oCompra_detalle->oProducto=producto::getByID($oCompra_detalle->producto_ID);
    $oCompra_detalle->stock=inventario::getStock($oCompra_detalle->producto_ID);
    $GLOBALS['dtLinea']=$dtLinea;
    $GLOBALS['dtCategoria']=$dtCategoria;
    $GLOBALS['linea_ID']=$linea_ID;
    $GLOBALS['categoria_ID']=$categoria_ID;
    $GLOBALS['dtProducto']=$dtProducto;
    //$GLOBALS['fecha']=$oCompra->fecha_emision;
    //$GLOBALS['oInventario']=$oInventario;
    $GLOBALS['oCompra_Detalle']=$oCompra_detalle;
    $GLOBALS['compra_ID']=$compra_ID;
}
function post_ajaxCompra_Mantenimiento_Producto_Eliminar(){
        require ROOT_PATH . 'models/ingreso.php';
        require ROOT_PATH . 'models/ingreso_detalle.php';
        require ROOT_PATH . 'models/inventario.php';
        require ROOT_PATH . 'models/inventario_detalle.php';
        require ROOT_PATH . 'models/cotizacion_detalle.php';
        require ROOT_PATH . 'models/cotizacion.php';
        try{
            $id=$_POST['id'];
            $oCompra_Detalle=ingreso_detalle::getByID($id);
            $compra_ID=$oCompra_Detalle->ingreso_ID;
            $oCompra_Detalle->usuario_mod_id=$_SESSION['usuario_ID'];
            if($oCompra_Detalle==null){
                throw new Exception('Parece que el registro ya fue eliminado.');
            }
            //verificamos que registros del inventario no se encuentren separados
            $dtInventariov=inventario::getGrid('ingreso_detalle_ID='.$oCompra_Detalle->ID.' and estado_ID=51',-1,-1);
            if(count($dtInventariov)>0){
                $numero_cotizacion='';
                $numero_cotizacion_con="";
                foreach($dtInventariov as $valor){
                    $oCotizacion_Detalle=cotizacion_detalle::getByID($valor['cotizacion_detalle_ID']);
                    $oCotizacion=cotizacion::getByID($oCotizacion_Detalle->cotizacion_ID);
                    if($numero_cotizacion!=$oCotizacion->numero_concatenado){
                        $numero_cotizacion_con.=$oCotizacion->numero_concatenado.'|';
                        $numero_cotizacion=$oCotizacion->numero_concatenado;
                    }
                }
                throw new Exception('El detalle de esta compra se encuentra separado en la cotización Nª: '.$numero_cotizacion_con);
            }
                
            
            $varEliminar=$oCompra_Detalle->eliminar();
            if($varEliminar==-1){
                throw new Exception($oCompra_Detalle->message);
            } else {
                //Eliminamos las cantidades ingresadas en la tabla inventario
                $dtInventario=inventario::getGrid('ingreso_detalle_ID='.$id,-1,-1,'ID asc');
                if(count($dtInventario)>0){
                    foreach($dtInventario as $valor){
                        $oInventario2=inventario::getByID($valor['ID']);
                        switch ($oInventario2->estado_ID){
                            case 48:
                                $oInventario2->eliminar(); 
                                break;
                            case 49:
                                 /*if(!isset($oInventario2->cotizacion_detalle_ID)){
                                    $oInventario2->cotizacion_detalle_ID='NULL'; 
                                  }*/
                                  $oInventario2->ingreso_detalle_ID=null;
                                  $oInventario2->estado_ID=50;
                                  $oInventario2->utilidad_soles=0;
                                  $oInventario2->utilidad_dolares=0;
                                  $oInventario2->comision_soles=0;
                                  $oInventario2->comision_dolares=0;
                                  $oInventario2->usuario_mod_id=$_SESSION['usuario_ID'];
                                  $oInventario2->actualizar();
                                break;
                           
                            
                        }
                            
                       
                        $mensaje="Se eliminó correctamente.";
                    }
                    $resultado=1;
                }else {
                    $mensaje="Se eliminó correctamente.";
                    $resultado=1;
                }
                
            }
            $contar_detalle=ingreso_detalle::getCount('ccd.ingreso_ID='.$compra_ID);
            $oCompra=ingreso::getByID($oCompra_Detalle->ingreso_ID);
            actualizar_costo_compra($oCompra);
            
            $funcion ='<script>fncOcultarAction();</script>';
        } catch (Exception $ex) {
            $resultado=-1;
            $mensaje=$ex->getMessage();
            $funcion='';
        }
     $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje, 'funcion' => $funcion);

    echo json_encode($retornar);
}

function get_Compra_Mantenimiento_Producto_Serie($compra_detalle_ID){
    require ROOT_PATH . 'models/categoria.php';
    require ROOT_PATH . 'models/linea.php';
    require ROOT_PATH . 'models/producto.php';
    require ROOT_PATH . 'models/estado.php';
    require ROOT_PATH . 'models/ingreso_detalle.php';
    require ROOT_PATH . 'models/ingreso.php';
    require ROOT_PATH . 'models/inventario.php';
    if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";;

    require ROOT_PATH . 'models/factura_venta.php';
    require ROOT_PATH . 'models/guia_venta.php';
   
        global $returnView_float;
        $returnView_float=true; 
        
        $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
      
        $oCompra_Detalle=ingreso_detalle::getByID($compra_detalle_ID);
        $oCompra_Detalle->oProducto=producto::getByID($oCompra_Detalle->producto_ID);
        $dtInventario = inventario::getGridInventario('inv.ingreso_detalle_ID='.$compra_detalle_ID,-1,-1,'ID asc');
        $oCompra_Detalle->dtInventario=$dtInventario;
        $GLOBALS['oCompra_Detalle']=$oCompra_Detalle;
       
    }
function post_Compra_Mantenimiento_Producto_Serie($compra_detalle_ID){
    require ROOT_PATH . 'models/categoria.php';
    require ROOT_PATH . 'models/linea.php';
    require ROOT_PATH . 'models/producto.php';
    require ROOT_PATH . 'models/estado.php';
    require ROOT_PATH . 'models/ingreso_detalle.php';
    require ROOT_PATH . 'models/ingreso.php';
    require ROOT_PATH . 'models/inventario.php';
    if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";;

    require ROOT_PATH . 'models/factura_venta.php';
    require ROOT_PATH . 'models/guia_venta.php';
    
    global $returnView_float;
    $returnView_float=true;
    $oCompra_Detalle=ingreso_detalle::getByID($compra_detalle_ID);
    try{
        $dtInventario=inventario::getGridInventario('inv.ingreso_detalle_ID='.$compra_detalle_ID,-1,-1);
        foreach($dtInventario as $item){
            $oInventario=inventario::getByID($item['ID']);
            $oInventario->serie=$_POST[$item['ID']];
            $oInventario->usuario_mod_id=$_SESSION['usuario_ID'];
            $oInventario->actualizar();
        }
        $resultado=1;
        $mensaje="Se actualizó correctamente";
    }catch (Exception $ex){
        $resultado=-1;
        $mensaje=$ex->getMessage();
    }
    $oCompra_Detalle=ingreso_detalle::getByID($compra_detalle_ID);
    $oCompra_Detalle->oProducto=producto::getByID($oCompra_Detalle->producto_ID);
    $dtInventario = inventario::getGridInventario('inv.ingreso_detalle_ID='.$compra_detalle_ID,-1,-1,'ID asc');
    $oCompra_Detalle->dtInventario=$dtInventario;
    $GLOBALS['resultado']=$resultado;
    $GLOBALS['mensaje']=$mensaje;
    $GLOBALS['oCompra_Detalle']=$oCompra_Detalle;
}   
function actualizarInventario($oInventario1){
    //require ROOT_PATH . 'models/operador.php';
    $oCompra_Detalle=ingreso_detalle::getByID($oInventario1->ingreso_detalle_ID);
    $oCompra=ingreso::getByID($oCompra_Detalle->ingreso_ID);
    $precio_compra_soles=0;
    $precio_compra_dolares=0;
    if($oCompra->moneda_ID==1){
        $precio_compra_soles=$oCompra_Detalle->precio;
        //number_format($costo_venta_unitario,2,".",",");
        $precio_compra_dolares=round($precio_compra_soles/$oCompra->tipo_cambio,2);
    }else {
        $precio_compra_dolares=$oCompra_Detalle->precio;
        $precio_compra_soles=round($precio_compra_dolares*$oCompra->tipo_cambio,2);
    }
    $osalida_detalle=salida_detalle::getByID($oInventario1->salida_detalle_ID);
    $osalida=salida::getByID($osalida_detalle->salida_ID);
    $oOperador=operador::getByID($osalida->operador_ID);
    $precio_venta_soles=$osalida_detalle->precio_venta_unitario_soles;
    $precio_venta_dolares=$osalida_detalle->precio_venta_unitario_dolares;
    if($osalida->moneda_ID==1){
        //Si es una venta en soles sacamos la utilidad en esta moneda
        $oInventario1->utilidad_soles=$precio_venta_soles-$precio_compra_soles;
        $oInventario1->comision_soles=$oInventario1->utilidad_soles*$oOperador->comision;
        $oInventario1->utilidad_dolares=0;
        $oInventario1->comision_dolares=0;
    }else{
        $oInventario1->utilidad_soles=0;
        $oInventario1->comision_soles=0;
        $oInventario1->utilidad_dolares=$precio_venta_dolares-$precio_compra_dolares;
        $oInventario1->comision_dolares=$oInventario1->utilidad_dolares*$oOperador->comision;
    }
    
    
    
    $oInventario1->usuario_mod_id=$_SESSION['usuario_ID'];
    $oInventario1->actualizar();

}
function post_ajaxProductos_Vendidos(){
    require ROOT_PATH . 'models/inventario.php';
    require ROOT_PATH . 'models/salida.php';
    require ROOT_PATH . 'models/factura_venta.php';
    require ROOT_PATH . 'models/guia_venta.php';
    require ROOT_PATH . 'models/salida_detalle.php';
    $producto_ID=$_POST['id'];
    $compra_detalle_ID=$_POST['id1'];
    $html="";
    try{
       $dtInventario_salida=inventario::getsalida_detalle($producto_ID,$compra_detalle_ID);
        $html="<table  class=' table table-hover table-bordered table-teal' id='tableDestino'>";
        $html.="<thead>";
        $html.=" <tr>
                    <th>Cant V.</th>
                    <th>Cant C.</th>
                    <th>N° Orden Venta </th>
                    <th>Fecha</th>
                    <th>Factura</th>
                    <th>Gu&iacute;a</th>
                    <th>Sel.</th>
                </tr>";
        $html.="</thead>";
        $html.="<tbody>";
        foreach($dtInventario_salida as $item){
            $cantidad_comprada=count(inventario::getGrid('salida_detalle_ID='.$compra_detalle_ID.' and producto_ID='.$producto_ID.' and salida_detalle_ID='.$item['salida_detalle_ID']));
            $osalida_detalle=salida_detalle::getByID($item['salida_detalle_ID']);
           if($osalida_detalle!=null){
                $osalida=salida::getByID($osalida_detalle->salida_ID);
                $html.="<tr>";
                $html.="<td class='tdCenter'>".$item['cantidad']."</td>";
                $html.="<td class='tdCenter'>".$cantidad_comprada."</td>";
                $html.="<td class='tdCenter'>".$osalida->numero_concatenado."</td>";
                $fecha="";
                $numero_factura="";
                $numero_guia="";
                $dtFactura_Venta=factura_venta::getGrid('salida_ID='.$osalida_detalle->salida_ID);
                if(count($dtFactura_Venta)>0){
                    $i=0;
                    foreach($dtFactura_Venta as $value){
                       $fecha= $value['fecha_emision'];
                       if($i==0){
                           $numero_factura.=$value['numero_concatenado'];
                       }else {
                           $numero_factura.="|".$value['numero_concatenado'];
                       }

                       $i++;
                    }
                }
            $dtGuia_Venta=guia_venta::getGrid('salida_ID='.$osalida_detalle->salida_ID);
                       $a=0;
                       $guia="";
                       if(count($dtGuia_Venta)>0){
                           foreach($dtGuia_Venta as $value1){
                               $guia=  FormatTextViewHtml($value1['numero_concatenado']);
                                if($a==0){
                                   $numero_guia.=$guia;
                               }else {
                                   $numero_guia.="|".$guia;
                               }
                               
                            $a++;
                            }
                       }

                     
                $html.="<td class='text-center'>".$fecha."</td>";  
                $html.="<td class='text-center'>".$numero_factura."</td>";
                $html.="<td class='text-center'>".$numero_guia."</td>";
                $html.="<td class='text-center'><div class='ckbox ckbox-teal'><input type='checkbox' disabled='disabled' id='ck".$item['salida_detalle_ID']."' name='".$item['salida_detalle_ID']."' value='".$item['IDs']."'><label for=id='ck".$item['salida_detalle_ID']."'></label></div></td>"; 
                $html.="</tr>";

            }

       }
    }
    catch(Exception $ex){
        log_error(__FILE__, "ingresoController", $ex->getMessage());
    $html.="<tr><td>".$ex->getMessage()."</td></tr>";

    }
    $html.="</tbody>";
    $html.="</table>";
    //$funcion="<script>desactivarDocumentos($('input[name=rbDestino]').val());</script>";
    
    $retornar = Array('html'=>$html);
    echo json_encode($retornar);
}
function actualizar_costo_compra_detalle($oCompra,$moneda_ID){
    require ROOT_PATH . 'models/ingreso_detalle.php';
    try {
        if($oCompra->moneda_ID!=$moneda_ID){
        $dtCompra_detalle=ingreso_detalle::getGrid('ccd.ingreso_ID='.$oCompra->ID,-1,-1);
        
        foreach($dtCompra_detalle as $item){
            
            $oCompra_Detalle=ingreso_detalle::getByID($item['codigo']);
                $precio=0;
                if($oCompra->moneda_ID==1){
                    $precio=round($item['precio']*$oCompra->tipo_cambio,2);
                }else {
                    $precio=round($item['precio']/$oCompra->tipo_cambio,2);
                }
                $oCompra_Detalle->precio=$precio;
                $subtotal=$precio*$oCompra_Detalle->cantidad;
                $oCompra_Detalle->subtotal=$subtotal;
                $oCompra_Detalle->igv=round($subtotal*$oCompra->vigv,2);
                $oCompra_Detalle->total=round($subtotal*(1+$oCompra->vigv),2);
                $oCompra_Detalle->usuario_mod_id=$_SESSION['usuario_ID'];
                $oCompra_Detalle->actualizar();
            }
        }
    }catch(Exception $ex) {
        
    }
  
}
function actualizar_costo_compra($oCompra){
    if(!class_exists('ingreso_detalle')){
        require ROOT_PATH . 'models/ingreso_detalle.php';
    }
    try {
        $total_old=$oCompra->total;
        $dtCompra_detalle=ingreso_detalle::getGrid('ccd.ingreso_ID='.$oCompra->ID,-1,-1);
        $subtotal=0;
        foreach($dtCompra_detalle as $item){
            $subtotal=$subtotal+$item['subtotal'];
        }
        $oCompra->subtotal=round($subtotal,2);
        $oCompra->igv=round($subtotal*$oCompra->vigv,2);
        $oCompra->total=round(($subtotal*(1+$oCompra->vigv)),2);
        if($total_old!=$oCompra->total){
            $diferencia=$oCompra->total-$total_old;
            $oCompra->monto_pendiente=$oCompra->monto_pendiente+$diferencia;
        }
        $oCompra->usuario_mod_id=$_SESSION['usuario_ID'];
        $oCompra->actualizar();
    }catch(Exception $ex) {
         throw new Exception($ex->getMessage());
    }
}

function get_Compra_Mantenimiento_Editar_Producto($id){
    require ROOT_PATH . 'models/categoria.php';
    require ROOT_PATH . 'models/linea.php';
    require ROOT_PATH . 'models/producto.php';
    require ROOT_PATH . 'models/estado.php';
    require ROOT_PATH . 'models/ingreso_detalle.php';
    require ROOT_PATH . 'models/ingreso.php';
    require ROOT_PATH . 'models/inventario.php';
    require ROOT_PATH . 'models/moneda.php';
        global $returnView_float;
        $returnView_float=true; 
        $oCompra_Detalle=ingreso_detalle::getByID($id);
        $oCompra=ingreso::getByID($oCompra_Detalle->ingreso_ID);
        $oProducto=producto::getByID($oCompra_Detalle->producto_ID);
        $oCategoria=categoria::getByID($oProducto->categoria_ID);
        $oLinea= linea::getByID($oCategoria->linea_ID);
        $oEstado=new estado();
       
        $dtCategoria=$oCategoria->getGrid('',-1,-1,'ca.nombre asc');
        $dtLinea=$oLinea->getGrid('',-1,-1,'li.nombre asc');
        
        $dtProducto=$oProducto->getGrid('',-1,-1,'pr.nombre asc');
        //$oCompra->dtProducto=$dtProducto;
       // $oCompra=ingreso::getByID($oCompra_Detalle->salida_ID);
        $oCompra_Detalle->oMoneda=moneda::getByID($oCompra->moneda_ID);
        $oCompra_Detalle->stock=inventario::getStock($oCompra_Detalle->producto_ID);
        $oCompra_Detalle->oProducto=$oProducto;
        $oCompra_Detalle->vigv=$oCompra->vigv;
        //$GLOBALS['fecha']=$oCompra->fecha_emision;
        //$GLOBALS['compra_ID']=$oCompra_Detalle->salida_ID;
        
        $GLOBALS['dtCategoria']=$dtCategoria;
        $GLOBALS['categoria_ID']=$oCategoria->ID;
        $GLOBALS['dtLinea']=$dtLinea;
        $GLOBALS['linea_ID']=$oLinea->ID;
        //$GLOBALS['dtEstado']=$dtEstado;
        $GLOBALS['oCompra']=$oCompra;
        $GLOBALS['dtProducto']=$dtProducto;
        $GLOBALS['oCompra_Detalle']=$oCompra_Detalle;
      
    }
function post_Compra_Mantenimiento_Editar_Producto($id){
    require ROOT_PATH . 'models/categoria.php';
    require ROOT_PATH . 'models/linea.php';
    require ROOT_PATH . 'models/producto.php';
    require ROOT_PATH . 'models/estado.php';
    require ROOT_PATH . 'models/ingreso_detalle.php';
    require ROOT_PATH . 'models/ingreso.php';
    require ROOT_PATH . 'models/inventario.php';
    require ROOT_PATH . 'models/factura_venta.php';
    require ROOT_PATH . 'models/salida.php';
    require ROOT_PATH . 'models/salida_detalle.php';
    
    require ROOT_PATH . 'models/guia_venta.php';
    require ROOT_PATH . 'models/operador.php';
    require ROOT_PATH . 'models/cotizacion.php';
    require ROOT_PATH . 'models/cotizacion_detalle.php';
    global $returnView_float;
    $returnView_float=true;

    //$compra_ID=$_POST['txtCompraID'];
    //$inventario_ID=$_POST['txtInventarioID1'];
    $linea_ID=$_POST['selLinea'];
    $categoria_ID=$_POST['selCategoria'];
    $producto_ID=$_POST['selProducto'];
    $descripcion=$_POST['txtDescripcion'];
    $cantidad=$_POST['txtCantidad'];
    $precio=$_POST['txtPrecioUnitario'];
    $subtotal=$_POST['txtSubTotal'];
    $igv=$_POST['txtIgv'];
    $total=$_POST['txtTotal'];
    $destino=$_POST['rbDestino'];
    //$fecha_emision=$_POST['txtfechaEmision'];
    $oCompra_Detalle=ingreso_detalle::getByID($id);
    try{

        //$oCompra_detalle=new ingreso_detalle();

        $oCompra_Detalle->producto_ID=$producto_ID;
        $oCompra_Detalle->descripcion=$descripcion;
        $oCompra_Detalle->cantidad=$cantidad;
        $oCompra_Detalle->precio=$precio;
        $oCompra_Detalle->subtotal=$subtotal;
        $oCompra_Detalle->igv=$igv;
        $oCompra_Detalle->total=$total;
        $oCompra_Detalle->destino=$destino;
        $oCompra_Detalle->usuario_mod_id=$_SESSION['usuario_ID'];
        

        //Registramos los valores en la tabla inventario
        //Limpiamos los registros
       $dtInventariov=inventario::getGrid('ingreso_detalle_ID='.$oCompra_Detalle->ID.' and estado_ID=51');
        if(count($dtInventariov)>0){
            $numero_cotizacion='';
            $numero_cotizacion_con="";
            foreach($dtInventariov as $Inventario){
                $oCotizacion_Detalle=cotizacion_detalle::getByID($Inventario['cotizacion_detalle_ID']);
                $oCotizacion=cotizacion::getByID($oCotizacion_Detalle->cotizacion_ID);
                if($numero_cotizacion!=$oCotizacion->numero_concatenado){
                    $numero_cotizacion_con.=$oCotizacion->numero_concatenado.'|';
                    $numero_cotizacion=$oCotizacion->numero_concatenado;
                }
            }
            throw new Exception('El detalle de esta compra se encuentra separado en la cotización:'.$numero_cotizacion_con);
        }
        $oCompra_Detalle->actualizar();
        $oCompra=ingreso::getByID($oCompra_Detalle->ingreso_ID);
        actualizar_costo_compra($oCompra);
            if($destino==1){
                //Se va para el stock
                $dtInventarioExistente=inventario::getGrid('ingreso_detalle_ID='.$id,-1,-1,'ID asc');
                $contarExistente=count($dtInventarioExistente);
                $contador=$cantidad-$contarExistente;
                
                if($contador==0){
                    foreach($dtInventarioExistente as $item){
                        $oInventario=inventario::getByID($item['ID']);
                        $oInventario->descripcion=$descripcion;
                        $oInventario->utilidad_soles=0;
                        $oInventario->utilidad_dolares=0;
                        $oInventario->comision_soles=0;
                        $oInventario->comision_dolares=0;
                        $oInventario->estado_ID=48;
                        $oInventario->salida_detalle_ID='NULL';
                        $oInventario->usuario_mod_id=$_SESSION['usuario_ID'];
                        $oInventario->actualizar();
                    }
                }else if($contador>0) {
                    
                    foreach($dtInventarioExistente as $item){
                        $oInventario=inventario::getByID($item['ID']);
                        $oInventario->descripcion=$descripcion;
                        $oInventario->utilidad_soles=0;
                        $oInventario->utilidad_dolares=0;
                        $oInventario->comision_soles=0;
                        $oInventario->comision_dolares=0;
                        $oInventario->salida_detalle_ID='NULL';
                        $oInventario->estado_ID=48;
                        $oInventario->usuario_mod_id=$_SESSION['usuario_ID'];
                        $oInventario->actualizar();
                    }
                //Agregarmos lo faltante
                    for($i=0;$i<$contador;$i++){
                        $oInventario=new inventario();
                        $oInventario->producto_ID=$producto_ID;
                        $oInventario->ingreso_detalle_ID=$oCompra_Detalle->ID;
                        $oInventario->salida_detalle_ID='NULL';
                        $oInventario->cotizacion_detalle_ID='NULL';
                        $oInventario->descripcion=$descripcion;
                        $oInventario->usuario_id=$_SESSION['usuario_ID'];
                        $oInventario->estado_ID=48;
                        $oInventario->utilidad_soles=0;
                        $oInventario->utilidad_dolares=0;
                        $oInventario->comision_soles=0;
                        $oInventario->comision_dolares=0;
                        $oInventario->serie="";
                        $oInventario->insertar();
                    }   
                }else {
                    $cont=1;
                    foreach($dtInventarioExistente as $item){
                        $oInventario=inventario::getByID($item['ID']);
                        $oInventario->descripcion=$descripcion;
                        $oInventario->utilidad_soles=0;
                        $oInventario->utilidad_dolares=0;
                        $oInventario->comision_soles=0;
                        $oInventario->comision_dolares=0;
                        $oInventario->salida_detalle_ID='NULL';
                        $oInventario->estado_ID=48;
                        $oInventario->usuario_mod_id=$_SESSION['usuario_ID'];
                        $oInventario->actualizar();
                        if($cont>$cantidad){
                            $oInventario->eliminar();
                        }
                        $cont++;
                    }
                    
                }
             
                
            }else {
                $cantidad_total=$cantidad;
                $contador=0;
                
                    
                    $dtInventario_salida=inventario::getsalida_detalle($producto_ID,$oCompra_Detalle->ID);
                    
                    foreach($dtInventario_salida as $item){
                        $salida_detalle_ID=$item['salida_detalle_ID'];
                        $osalida_detalle=salida_detalle::getByID($salida_detalle_ID);
                       if($osalida_detalle!=null){
                        if(isset($_POST[$item['salida_detalle_ID']])){
                           
                            $cantidad1=$item['cantidad'];
                            $IDs=explode("|", $_POST[$item['salida_detalle_ID']]);
                            for($b=0;$b<count($IDs);$b++){
                               
                                    
                                    $oInventario=inventario::getByID($IDs[$b]);
                                    /*if(!isset($item['cotizacion_detalle_ID'])){
                                        $oInventario->cotizacion_detalle_ID='NULL';
                                    }*/
                                    
                                    $oInventario->ingreso_detalle_ID=$oCompra_Detalle->ID;
                                    $oInventario->descripcion=$oCompra_Detalle->descripcion;
                                    $oInventario->estado_ID=49;
                                    $oInventario->usuario_mod_id=$_SESSION['usuario_ID'];
                                    $oInventario->actualizar();
                                    $mensaje=$oInventario->message;
                                    actualizarInventario($oInventario);
                                    //$cantidad_total=$cantidad_total-1;
                                    $contador++;
                              
                               
                            }  
                        
                        }
                      
                       } 
                    }
                $cantidad_faltante=$cantidad_total-$contador; 
                if($cantidad_faltante>0){
                    for($a=0; $a<$cantidad_faltante; $a++){    
                        if($cantidad_total>$contador){
                            $oInventario=new inventario();
                            $oInventario->producto_ID=$producto_ID;
                            $oInventario->ingreso_detalle_ID=$oCompra_Detalle->ID;
                            $oInventario->cotizacion_detalle_ID='NULL';
                            $oInventario->salida_detalle_ID='NULL';
                            $oInventario->descripcion=$descripcion;
                            $oInventario->usuario_id=$_SESSION['usuario_ID'];
                            $oInventario->estado_ID=48;
                            $oInventario->utilidad_soles=0;
                            $oInventario->utilidad_dolares=0;
                            $oInventario->comision_soles=0;
                            $oInventario->comision_dolares=0;
                            $oInventario->serie="NULL";
                            $oInventario->insertar();
                            $mensaje=$oInventario->message;
                            //$cantidad_total=$cantidad_total-1;
                            $contador++;
                        }
                    }

                }
               
               
            }        
                
       
        //$oCompra=ingreso::getByID($oCompra_Detalle1->compra_ID);
        $GLOBALS['resultado'] = 1;
        $GLOBALS['mensaje'] = 'Se actualizó correctamente'; 
    } catch (Exception $ex) {
        $GLOBALS['resultado'] = -1;
        $GLOBALS['mensaje'] = $ex->getMessage(); 
    }

    $dtLinea=linea::getGrid('',-1,-1,'li.nombre asc');
    if($linea_ID!=0){
        $dtCategoria=categoria::getGrid('ca.linea_ID='.$linea_ID,-1,-1,'ca.nombre asc');
    }else{
        $dtCategoria=categoria::getGrid('',-1,-1,'ca.nombre asc');

    }
    if($categoria_ID!=0){
        $dtProducto=producto::getGrid('pr.categoria_ID='.$categoria_ID,-1,-1,'pr.nombre asc');
    }else{
        $dtProducto=producto::getGrid('',-1,-1,'pr.nombre asc');

    }

    $GLOBALS['dtLinea']=$dtLinea;
    $GLOBALS['dtCategoria']=$dtCategoria;
    $GLOBALS['linea_ID']=$linea_ID;
    $GLOBALS['categoria_ID']=$categoria_ID;
    $GLOBALS['dtProducto']=$dtProducto;
    $GLOBALS['oCompra']=$oCompra;
    $GLOBALS['oInventario']=$oInventario;
    $GLOBALS['oCompra_Detalle']=$oCompra_Detalle;
    //$GLOBALS['compra_ID']=$oCompra_Detalle1->compra_ID;
}

function post_ajaxCompra_Mantenimiento_Eliminar() {
    require ROOT_PATH . 'models/ingreso.php';
    require ROOT_PATH . 'models/ingreso_detalle.php';
    $id=$_POST['id'];
    try {
        $oCompra = ingreso::getByID($id);
        $oCompra->usuario_mod_id = $_SESSION['usuario_ID'];
        if ($oCompra == null) {
            throw new Exception('Parece que el registro ya fue eliminado.');
        }
        $dtCompra_detalle=ingreso_detalle::getGrid('ingreso_ID='.$oCompra->ID,-1,-1);
        if(count($dtCompra_detalle)>0){
            throw new Exception("No se puede eliminar la compra, tiene detalle registrado, elimine los detalles.");
        }
        if ($oCompra->eliminar() == -1) {
            throw new Exception($oProveedor->message);
        }

        $resultado = 1;
        $mensaje = $oCompra->message;
      
    } catch (Exception $ex) {
        $resultado = -1;
        $mensaje = $ex->getMessage();
      
    }

    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);

    echo json_encode($retornar);
}

function post_ajaxRegistrarSeries(){
    require ROOT_PATH . 'models/inventario.php';

    $inventario_ID=$_POST['id'];
    $serie=$_POST['id1'];

    try{
       $cantidad_serie=0;

        $oInventario=inventario::getByID($inventario_ID);
        /*if(!isset($oInventario->cotizacion_detalle_ID)||$oInventario->cotizacion_detalle_ID!="NULL"){
            $oInventario->cotizacion_detalle_ID='NULL';
        }

        if(!isset( $oInventario->salida_detalle_ID) || $oInventario->salida_detalle_ID != "NULL" ){
            $oInventario->salida_detalle_ID="NULL";
        }*/

        $oInventario->serie=$serie;
        $oInventario->usuario_mod_id=$_SESSION['usuario_ID'];
        $oInventario->actualizar();
        $mensaje=$oInventario->message;
        $resultado =1;
    }
    catch(Exception $ex){
    $resultado = -1;
    $mensaje = $ex->getMessage();

    }

    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
    echo json_encode($retornar);
}
function post_ajaxMostrar_Serie() {

require ROOT_PATH . 'models/ingreso_detalle.php';
require ROOT_PATH . 'models/ingreso.php';
require ROOT_PATH . 'models/inventario.php';
require ROOT_PATH . 'models/salida.php';
require ROOT_PATH . 'models/salida_detalle.php';
require ROOT_PATH . 'models/factura_venta.php';
require ROOT_PATH . 'models/guia_venta_numero.php';
$resultado = '<table class="grid" id="tbSeries"><tr>';
$resultado.='<th style="width:50px;">Nro</th>';
$resultado.='<th style="width:160px;" >Serie </th>';
$resultado.='<th style="width:130px;" >Factura V. </th>';
$resultado.='<th style="width:130px;" >Gu&iacute;a V. </th>';
$resultado.='</tr>';
$compra_detalle_ID=$_POST['txtCompra_Detalle_ID'];



try {
    //$cantidadMaxima = ingreso_detalle::getCount($filtro);
    $dtinventario = inventario::getGrid('ingreso_detalle_ID='.$compra_detalle_ID,-1,-1,'ID asc');

    $i=1;
    foreach ($dtinventario as $item) {
        if($item['serie']=="NULL"){
            $serie="Por registrar serie";
            $checked="checked";
            $mostrarEliminar="display:none;";
        }else {
             $serie=$item['serie'];
             $checked="";
             $mostrarEliminar="display:inline;";
        }
        $resultado.='<tr class="tr-item">';
        $resultado.='<td class="tdCenter">'.$i.'<input type="checkbox" '.$checked.' name="ck'.$item['ID'].'" value="'.$item['ID'].'"></td>';
        $resultado.='<td class="tdLeft">' . FormatTextViewHtml($serie) . '</td>';
        $numero_factura="";
        $numero_guia="";
        if(isset($item['salida_detalle_ID'])){
            $osalida_detalle=salida_detalle::getByID($item['salida_detalle_ID']);
            $dtFactura_Venta=factura_venta::getGrid('salida_ID='.$osalida_detalle->salida_ID);
            $b=0;
            foreach($dtFactura_Venta as $item){
                if($b==0){
                    $numero_factura= FormatTextViewHtml($item['numero_concatenado']);
                }else { 
                    $numero_factura.="|".FormatTextViewHtml($item['numero_concatenado']);

                }
                $b++;
                $dtGuia_Venta_Numero=guia_venta_numero::getGrid('factura_venta_ID='.$item['ID']);
                if(count($dtGuia_Venta_Numero)>0){
                    $a=0;
                    foreach($dtGuia_Venta_Numero as $value){
                        if($a==0){$numero_guia=FormatTextViewHtml($value['numero_concatenado']);}
                        else {$numero_guia.="|".FormatTextViewHtml($value['numero_concatenado']);}
                       $a++; 
                    }
                }

            }
            $resultado.='<td class="tdLeft">' . $numero_factura. '</td>';
            $resultado.='<td class="tdLeft">' . $numero_guia . '</td>';
        }else {
             $resultado.='<td class="tdLeft" colspan="2">para stock.</td>';
        }


        $resultado.='</tr>';
        $i=$i+1;
    }


} catch (Exception $ex) {
    $resultado.='<tr ><td colspan="3">' . $ex->getMessage() . '</td></tr>';
}

$resultado.='</table>';

$mensaje = '';
$retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
//$retorn="<h1>Hola</h1>";

echo json_encode($retornar);
}



function get_Compra_Mantenimiento_Editar($id){
    require ROOT_PATH.'models/tipo_comprobante.php';
    require ROOT_PATH.'models/orden_ingreso.php';
    require ROOT_PATH.'models/ingreso.php';
    require ROOT_PATH.'models/estado.php';
    require ROOT_PATH.'models/moneda.php';
    require ROOT_PATH.'models/forma_pago.php';
    
    require ROOT_PATH.'models/proveedor.php';
    require ROOT_PATH.'models/ingreso_detalle.php';
    require ROOT_PATH.'models/producto.php';
    require ROOT_PATH.'models/inventario.php';
    require ROOT_PATH.'models/inventario_detalle.php';
     if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";
    global $returnView_float;
    $returnView_float=true;

    $oDatos_generales=datos_generales::getByID1($_SESSION['empresa_ID']);
    $oCompra=ingreso::getByID($id);
    if($oCompra==null){
        $GLOBALS['resultado'] = -2;
        $GLOBALS['mensaje'] = "La compra ha sido eliminado por otro usuario";
        return;
    }
    $numero_orden_compra='';
    if($oCompra->orden_ingreso_ID!=-1){
        $oOrden_Compra=orden_ingreso::getByID($oCompra->orden_ingreso_ID);
        $numero_orden_compra=sprintf("%'.07d",$oOrden_Compra->numero_orden);
       
    }
    $oCompra->numero_orden_ingreso=$numero_orden_compra;
    $dtEstado=estado::getGrid('est.ID in (9,10,11)');
    $oProveedor=proveedor::getByID($oCompra->proveedor_ID); 
    $dtMoneda=moneda::getGrid();

//    $dtComprobante_tipo=comprobante_tipo::getGrid('ct.en_compra=1');
    $dtTipo_Comprobante=tipo_comprobante::getComprobantes(0,"compra",0,$oCompra->tipo_comprobante_ID,"tipo_comprobantes_sinserie");
    $oCompra->oEstado=estado::getByID($oCompra->estado_ID);
    $oCompra->dtMoneda=$dtMoneda;
    //$GLOBALS['dtMoneda']=$dtMoneda;
    $oCompra->oProveedor=proveedor::getByID($oCompra->proveedor_ID);   
//    $oCompra->dtComprobante_Tipo=$dtComprobante_tipo;
    $oCompra->dtTipo_Comprobante=$dtTipo_Comprobante;
    $dtProveedor=proveedor::getGrid("prv.empresa_ID=".$_SESSION['empresa_ID']);
    $oCompra->dtProveedor=$dtProveedor;
    $GLOBALS['oCompra']=$oCompra;

    $GLOBALS['tipo_cambio']=$oDatos_generales->tipo_cambio;
    $GLOBALS['vigv']=$oDatos_generales->vigv;
    $GLOBALS['con_igv']=1;
//    $GLOBALS['dtComprobante_tipo']=$dtComprobante_tipo;
    $GLOBALS['dtEstado']=$dtEstado;
//        $GLOBALS['mensaje']='';
    //$GLOBALS['mensaje1']='Inicio';

}
function post_Compra_Mantenimiento_Editar($id){
    require ROOT_PATH.'models/ingreso.php';
    require ROOT_PATH.'models/orden_ingreso.php';
    require ROOT_PATH.'models/tipo_comprobante.php';
    require ROOT_PATH.'models/estado.php';
    require ROOT_PATH.'models/moneda.php';
    require ROOT_PATH.'models/forma_pago.php';
    require ROOT_PATH.'models/proveedor.php';

    if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";
    global $returnView_float;
    $returnView_float=true;
    $tipo_comprobante_ID=$_POST['cboComprobante_Tipo'];
    $serie=$_POST['txtSerie'];
    $numero=$_POST['txtNumero_Factura'];
    $tipo_cambio=$_POST['txtTipo_Cambio'];
    $estado_ID=$_POST['cboEstado'];
    $fecha_emision=$_POST['txtFecha_Emision'];       
    $numero_guia=$_POST['txtNumero_Guia'];
    $moneda_ID=$_POST['cboMoneda'];
    $fecha_vencimiento=$_POST['txtFecha_Vencimiento'];
    $proveedor_ID=$_POST['selProveedor'];
    $con_igv=1;
    $descripcion= $_POST['txtComentario'];
    if(isset($_POST['chkCon_Igv'])){
            $con_igv=1;
    }
    $vigv=$_POST['txtVigv']/100;
    $oCompra=ingreso::getByID($id);
    if($oCompra==null){
        $GLOBALS['resultado'] = -2;
        $GLOBALS['mensaje'] = "La compra ha sido eliminado por otro usuario";
        return;
    }
    try{
        $moneda_ID_old=$oCompra->moneda_ID;
        $oCompra->tipo_comprobante_ID=$tipo_comprobante_ID;
        $oCompra->serie=$serie;
        $oCompra->numero=$numero;
        $oCompra->numero_guia=$numero_guia;
        $oCompra->tipo_cambio=$tipo_cambio;
        $oCompra->estado_ID=$estado_ID;
        $oCompra->fecha_emision=$fecha_emision;
        $oCompra->fecha_vencimiento= $fecha_vencimiento;
        $oCompra->proveedor_ID=$proveedor_ID;
        $oCompra->vigv=$vigv;
        $oCompra->con_igv=$con_igv;
        $oCompra->descripcion=$descripcion;
        $oCompra->moneda_ID=$moneda_ID;
        $oCompra->periodo=date("Y",strtotime($fecha_emision));
        $oCompra->usuario_mod_id=$_SESSION['usuario_ID'];

        if($oCompra->verificarDuplicado()>0){
                throw new Exception($oCompra->message);
        }

       $oCompra->actualizar();
       actualizar_costo_compra_detalle($oCompra,$moneda_ID_old);
       actualizar_costo_compra($oCompra);
       $GLOBALS['resultado']=1;
       $GLOBALS['mensaje'] =$oCompra->message;

    $numero_orden_compra='';
    if($oCompra->orden_ingreso_ID!='-1'){
        $oOrden_Compra=orden_ingreso::getByID($oCompra->orden_ingreso_ID);
        $numero_orden_compra=sprintf("%'.07d",$oOrden_Compra->numero_orden);
    }
    $oCompra->numero_orden_ingreso=$numero_orden_compra;    
    }catch(Exception $ex){
        $GLOBALS['resultado'] = -1;
        $GLOBALS['mensaje'] = $ex->getMessage();
    }
    $oCompra->oProveedor=proveedor::getByID($oCompra->proveedor_ID);
    $dtProveedor=proveedor::getGrid("prv.empresa_ID=".$_SESSION['empresa_ID']);
    $oCompra->dtProveedor=$dtProveedor;
    
    $oDatos_generales=datos_generales::getByID1($_SESSION['empresa_ID']);
    $dtMoneda=moneda::getGrid();
    $oCompra->dtMoneda=$dtMoneda;
    $dtTipo_Comprobante=tipo_comprobante::getComprobantes(0,"compra",0,$oCompra->tipo_comprobante_ID,"tipo_comprobantes_sinserie");

    $dtEstado=estado::getGrid('est.ID in (9,10)');
    
    $oCompra->dtTipo_Comprobante=$dtTipo_Comprobante;
    //$GLOBALS['dtMoneda']=$dtMoneda;   
    $GLOBALS['tipo_cambio']=$oDatos_generales->tipo_cambio;
    //$GLOBALS['oProveedor']=$oProveedor;
    $GLOBALS['con_igv']=1;

    $GLOBALS['dtEstado']=$dtEstado;
    $GLOBALS['oCompra']=$oCompra;

}


function get_Compra_Mantenimiento_Ver_Detalle($id){
 require ROOT_PATH.'models/comprobante_tipo.php';
 require ROOT_PATH.'models/ingreso.php';
 require ROOT_PATH.'models/estado.php';
 require ROOT_PATH.'models/moneda.php';
 require ROOT_PATH.'models/forma_pago.php';
 
 require ROOT_PATH.'models/proveedor.php';
 require ROOT_PATH.'models/ingreso_detalle.php';
 require ROOT_PATH.'models/producto.php';
 require ROOT_PATH.'models/inventario.php';
 require ROOT_PATH.'models/inventario_detalle.php';
 if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";
 global $returnView_float;
 $returnView_float=true;

 $oDatos_generales=datos_generales::getByID1($_SESSION['empresa_ID']);
 $oCompra=ingreso::getByID($id);
 $oEstado=estado::getByID($oCompra->estado_ID);
 $oProveedor=proveedor::getByID($oCompra->proveedor_ID); 
 $dtMoneda=moneda::getGrid();
 $dtComprobante_tipo=comprobante_tipo::getGrid('ct.en_compra=1');           

 $GLOBALS['dtMoneda']=$dtMoneda;

 $GLOBALS['oCompra']=$oCompra;
 $GLOBALS['oProveedor']=$oProveedor;
 $GLOBALS['tipo_cambio']=$oDatos_generales->tipo_cambio;
 $GLOBALS['vigv']=$oDatos_generales->vigv;
 $GLOBALS['con_igv']=1;
 $GLOBALS['dtComprobante_tipo']=$dtComprobante_tipo;
 $GLOBALS['dtEstado']=$oEstado;
 $GLOBALS['mensaje']='';

}
function post_Compra_Mantenimiento_Ver_Detalle($id){
require ROOT_PATH.'models/ingreso.php';
require ROOT_PATH.'models/comprobante_tipo.php';
require ROOT_PATH.'models/estado.php';
require ROOT_PATH.'models/moneda.php';
require ROOT_PATH.'models/forma_pago.php';
require ROOT_PATH.'models/proveedor.php';

 if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";
global $returnView_float;
$returnView_float=true;
$comprobante_tipo_ID=$_POST['cboComprobante_Tipo'];
$serie=$_POST['txtSerie'];
$numero=$_POST['txtNumero_Factura'];
$tipo_cambio=$_POST['txtTipo_Cambio'];
$estado_ID=$_POST['txtEstado_ID'];
$fecha_emision=$_POST['txtFecha_Emision'];

$numero_guia=$_POST['txtNumero_Guia'];
$moneda_ID=$_POST['cboMoneda'];
$fecha_vencimiento=null;

if($estado_ID==9){
        $fecha_vencimiento=$_POST['txtFecha_Vencimiento'];
}

$proveedor_ID=$_POST['txtProveedor_ID'];
$con_igv=0;

if(isset($_POST['chkCon_Igv'])){
        $con_igv=1;
}
$vigv=$_POST['txtVigv'];
$oCompra=ingreso::getByID($id);
try{
    $oCompra->comprobante_tipo_ID=$comprobante_tipo_ID;
    $oCompra->serie=$serie;
    $oCompra->numero=$numero;
    $oCompra->numero_guia=$numero_guia;
    $oCompra->tipo_cambio=$tipo_cambio;
    $oCompra->estado_ID=$estado_ID;
    $oCompra->fecha_emision=$fecha_emision;
    $oCompra->fecha_vencimiento=$fecha_vencimiento;
    $oCompra->proveedor_ID=$proveedor_ID;
    $oCompra->vigv=$vigv;
    $oCompra->con_igv=$con_igv;
    $oCompra->moneda_ID=$moneda_ID;
    $oCompra->periodo=date("Y",strtotime($fecha_emision));
    $oCompra->usuario_mod_id=$_SESSION['usuario_ID'];

    if($oCompra->verificarDuplicado()>0){
            throw new Exception($oCompra->message);
    }

   $oCompra->actualizar();
   $GLOBALS['resultado']=1;
   $GLOBALS['mensaje'] ="Se guardó correctamente";


}catch(Exception $ex){
    $GLOBALS['resultado'] = -1;
    $GLOBALS['mensaje'] = $ex->getMessage();
}
$oProveedor=proveedor::getByID($oCompra->proveedor_ID);
$oDatos_generales=datos_generales::getByID1($_SESSION['empresa_ID']);
$dtMoneda=moneda::getGrid();
$dtComprobante_tipo=comprobante_tipo::getGrid('ct.en_compra=1');
$oEstado=estado::getByID($oCompra->estado_ID);

$GLOBALS['dtMoneda']=$dtMoneda;      
$GLOBALS['tipo_cambio']=$oDatos_generales->tipo_cambio;
$GLOBALS['oProveedor']=$oProveedor;
$GLOBALS['con_igv']=1;
$GLOBALS['dtComprobante_tipo']=$dtComprobante_tipo;
$GLOBALS['dtEstado']=$oEstado;
$GLOBALS['oCompra']=$oCompra;
$GLOBALS['mensaje']='';

}
function post_ajaxProducto_Listar(){
            require ROOT_PATH.'models/producto.php';

            $Buscar=$_POST['txtBuscarMP'];
            $paginaActual=$_POST['num_page']==0?1:$_POST['num_page'];
            $cantidadMostrar=30;
            $txtOrden=$_POST['txtOrden'];
            $orden_tipo='DESC';
            $orden_class='imgOrden-desc';

            if(isset($_POST['chkOrdenASC']))
            {
                    $orden_class='imgOrden-asc';
                    $orden_tipo='ASC';
            }


            switch($txtOrden){
                    case 1:
                            $orden='pr.nombre '.$orden_tipo;
                    break;
                    case 2:
                            $orden='ca.nombre '.$orden_tipo;
                    break;
                    case 3:
                            $orden='es.ID '.$orden_tipo;
                    break;
                    default:
                            $orden='pr.ID '.$orden_tipo;
                    break;
            }


            $filtro='pr.ID<>0 and upper(concat(pr.nombre," ",ca.nombre)) like "%'.str_replace(' ','%',strtoupper(FormatTextSave($Buscar))).'%"';

            //---------------------------------------					 
            $resultado='<table class="grid"><tr>';		
            $resultado.='<th style="display:none;" ></th>';			
            $resultado.='<th style="width:130px;" class="thOrden" onclick="fncOrden(1);">Código'.(($txtOrden==1?"<img class=".$orden_class." />":"")).'</th>';
            $resultado.='<th style="width:300px;" class="thOrden" onclick="fncOrden(2);">Producto'.(($txtOrden==2?"<img class=".$orden_class." />":"")).'</th>';		
            $resultado.='<th style="width:100px;" class="thOrden" onclick="fncOrden(3);">Categoría'.(($txtOrden==3?"<img class=".$orden_class." />":"")).'</th>';	
            $resultado.='<th style="width:100px;" class="thOrden" onclick="fncOrden(4);">Estado'.(($txtOrden==3?"<img class=".$orden_class." />":"")).'</th>';
            $resultado.='</tr>';

            $colspanFooter=4;
            try {
                    $cantidadMaxima=producto::getCount($filtro);			
                    $dtProducto=producto::getGrid($filtro,(($paginaActual*$cantidadMostrar)-($cantidadMostrar)),$cantidadMostrar,$orden);								
                    $rows=count($dtProducto);		

                    foreach($dtProducto as $item)
                    {
                            $resultado.='<tr class="tr-item" ondblclick="trSeleccionado(this)">';
                            $resultado.='<td style="display:none;">'.$item['ID'].'</td>';
                            $resultado.='<td class="tdLeft">'.FormatTextViewHtml($item['ID']).'</td>';
                            $resultado.='<td class="tdLeft">'.FormatTextViewHtml($item['producto']).'</td>';
                            $resultado.='<td class="tdLeft">'.FormatTextViewHtml($item['categoria']).'</td>';
                            $resultado.='<td class="tdLeft">'.FormatTextViewHtml($item['estado']).'</td>';

                            $resultado.='</tr>';
                    }

                    $cantidadPaginas='';


                    if ($cantidadMaxima>$cantidadMostrar&&$cantidadMaxima>0){

                            $resultado.='<tr><td id="tdPagination" colspan='.$colspanFooter.' >';
                            $decimal=fmod($cantidadMaxima,$cantidadMostrar);

                            if($decimal>0){
                                    $cantidadPaginas=intval($cantidadMaxima/$cantidadMostrar)+1;
                            }else{
                                    $cantidadPaginas=intval($cantidadMaxima/$cantidadMostrar);
                            }

                            $Bloque=(intval($paginaActual/10)+1)*10; //Sólo mostrará las 10 primeras páginas
                            $paginaInicio=1;
                            $paginaFin=$Bloque;

                            if($paginaActual>=10){
                                    $paginaInicio=$Bloque-10;
                            }

                            if($paginaFin>$cantidadPaginas){
                                    $paginaFin=$cantidadPaginas;
                            }

                            $resultado.='<div  id=1 class="pagination pagination-ini" ><a title="Primero"><<</a></div>';
                            $resultado.='<div id="'.($paginaActual>1?$paginaActual-1:$paginaActual).'" class="pagination pagination-prev" ><a title="Anterior"><</a></div>';

                            for($i=$paginaInicio;$i<=$paginaFin;$i++){
                                    if($i==$paginaActual){
                                            $resultado.='<div class="pagination">'.$i.'</div>';
                                    }else{
                                            $resultado.='<div id="'.$i.'" class="pagination"><a>'.$i.'</a></div>';
                                    }				
                            }

                            $resultado.='<div id="'.($paginaActual<$cantidadPaginas?$paginaActual+1:$paginaActual).'" class="pagination pagination-next" ><a title="Siguiente">></a></div>';
                            $resultado.='<div id="'.$cantidadPaginas.'" class="pagination pagination-end" ><a title="Último">>></a></div>';

                            $resultado.='</td></tr>';
                    }

                    $resultado.='<tr class="tr-footer"><th colspan='.$colspanFooter.'>'.$rows.' de '.$cantidadMaxima.' Registros</th></tr>';
            }catch(Exception $ex){
                    $resultado.='<tr ><td colspan='.$colspanFooter.'>'.$ex->getMessage().'</td></tr>';
            }

            $resultado.='</table>';

            $mensaje='';
            $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);

            echo json_encode($retornar);
    }
  
function post_ajaxCompra_Mantenimiento_Detalle() {
    require ROOT_PATH . 'models/ingreso.php';
    require ROOT_PATH . 'models/ingreso_detalle.php';
    require ROOT_PATH . 'models/producto.php';
    require ROOT_PATH . 'models/estado.php';
    if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";;
    $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
   
    $compra_ID=$_POST['id'];
    
    $orden_tipo = 'ASC';
    
    $orden_class = 'imgOrden-desc';
    $txtOrden = $_POST['id1'];
    if ($_POST['id2']=="DESC") {
        $orden_class = 'imgOrden-asc';
        $orden_tipo = 'DESC';
    }
    switch ($txtOrden) {
        case 0:
            $orden = 'ccd.ID ' . $orden_tipo;
            break;
        case 1:
            $orden = 'pro.nombre ' . $orden_tipo;
            break;
        case 2:
            $orden = 'ccd.descripcion ' . $orden_tipo;
            break;
        case 3:
            $orden = 'ccd.cantidad ' . $orden_tipo;
            break;
        case 4:
            $orden = 'ccd.precio ' . $orden_tipo;
            break;
        case 5:
            $orden = 'ccd.subtotal ' . $orden_tipo;
            break;
       
        default:
            $orden = 'ccd.ID ' . $orden_tipo;
            break;
    }			 
    $resultado = '<table class="table table-hover table-bordered table-teal"><thead><tr>';
    $resultado.='<th class="text-center" onclick="fncOrden(0);">Nro</th>';
    $resultado.='<th class="text-center" onclick="fncOrden(1);">Producto' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    //$resultado.='<th class="thOrden" onclick="fncOrden(2);">Descripcion' . (($txtOrden == 2 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="text-center" onclick="fncOrden(3);">Cantidad' . (($txtOrden == 3 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="text-center" onclick="fncOrden(4);">Precio' . (($txtOrden == 4 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="text-center" onclick="fncOrden(5);">Sub Total' . (($txtOrden == 5 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th></th>';
    $footer=6;        
   
    
    $resultado.='</tr></thead>';
    $filtro="ccd.ingreso_ID=".$compra_ID;
    $resultado.='<tbody>';
    try {
        //$cantidadMaxima = ingreso_detalle::getCount($filtro);
        $oCompra=ingreso::getByID($compra_ID);
        $dtCompra = ingreso_detalle::getGrid($filtro, '-1', '-1',$orden);
        $rows = count($dtCompra);
        $i=1;
        $igv=0;
        $subtotal=0;
        $total=0;
        foreach ($dtCompra as $item) {
            
           
            $resultado.='<tr class="item-tr" id="'.$item['codigo'].'" >';
            $resultado.='<td class="tdCenter" style="width:20px;">'.$i.'</td>';
            $resultado.='<td class="tdLeft">' . FormatTextViewHtml($item['producto']) . '</td>';
           
            $resultado.='<td class="tdCenter">' . $item['cantidad'] . '</td>';
            $resultado.='<td class="tdRight">' . number_format($item['precio'],2,'.',',') . '</td>';
            $resultado.='<td class="tdRight">' . number_format($item['subtotal'],2,'.',',') . '</td>';
            $botones=array();
            array_push($botones,'<a class="btn-view" title="Editar producto" onclick="fncEditar('.$item['codigo'].');" ><span class="glyphicon glyphicon-pencil"></span> Editar</a>');
            array_push($botones,'<a class="btn-view" title="Registrar serie" onclick="fncSeries('.$item['codigo'].');" ><span class="glyphicon glyphicon-barcode"></span> Serie</a>');
            if($oCompra->estado_ID==9){
                array_push($botones,'<a  class="btn-view" onclick="modal.confirmacion(&#39;El proceso es irreversible, esta seguro de eliminar el registro.&#39;,&#39;Eliminar producto&#39;,fncEliminar,&#39;' . $item['codigo'] . '&#39;);" title="Eliminar producto"><span class="glyphicon glyphicon-trash"></span> Eliminar</a>');
           
            }
             $resultado.='<td class="text-center" >'.extraerOpcion($botones)."</td>";
            $resultado.='</tr>';
            $i=$i+1;
            $igv=$igv+$item['igv'];
            $subtotal=$subtotal+$item['subtotal'];
        }
        
        $mensaje=1;
    } catch (Exception $ex) {
        $resultado.='<tr ><td colspan="6">' . $ex->getMessage() . '</td></tr>';
        $mensaje=-1;
    }
    $resultado.='<tbody>';
    $resultado.='</table>';
    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje,'subtotal'=>number_format($oCompra->subtotal,2,'.',','),'igv'=>number_format($oCompra->igv,2,'.',','),'total'=>number_format($oCompra->total,2,'.',','));
    echo json_encode($retornar);
    }

function post_ajaxSerie_Eliminar($id){
    require ROOT_PATH . 'models/inventario_detalle.php';

try {
    $oInventario_Detalle = inventario_detalle::getByID($id);
    $oInventario_Detalle->usuario_mod_id = $_SESSION['usuario_ID'];
    if ($oInventario_Detalle == null) {
        throw new Exception('Parece que el registro ya fue eliminado.');
    }

    if ($oInventario_Detalle->eliminar() == -1) {
        throw new Exception($oInventario_Detalle->message);
    }

    $resultado = 1;
    $mensaje = $oInventario_Detalle->message;
    $funcion = '';
} catch (Exception $ex) {
    $resultado = -1;
    $mensaje = $ex->getMessage();
    $funcion = '';
}

$retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje, 'funcion' => $funcion);

echo json_encode($retornar);
}
function post_ajaxMostrar_Guia(){

    require ROOT_PATH . 'models/inventario.php';
    require ROOT_PATH . 'models/guia_venta.php';
    $producto_ID=$_POST['ID'];
    $resultado = '<table class="grid"><tr>';
    $resultado.='<th style="width:50px;">Nro</th>';
    $resultado.='<th style="width:50px;" >Serie </th>';
    $resultado.='<th></th>';

    $resultado.='</tr>';
    $filtro="inventario_ID=".$inventarioID;

    try {
        //$cantidadMaxima = ingreso_detalle::getCount($filtro);
        $dtinventario_detalle = inventario_detalle::getGrid($filtro, '-1', '-1');

        $i=1;
        foreach ($dtinventario_detalle as $item) {

            $resultado.='<tr class="tr-item">';
            $resultado.='<td class="tdCenter">'.$i.'</td>';
            $resultado.='<td class="tdLeft">' . FormatTextViewHtml($item['serie']) . '</td>';
            $resultado.='<td class="btnAction"><img title="Eliminar" src="/include/img/boton/delete_14x14.png" />&nbsp;<a onclick="fncEliminar(' . $item['ID'] . ');">Eliminar</a></td>';

            $resultado.='</tr>';
            $i=$i+1;
        }


    } catch (Exception $ex) {
        $resultado.='<tr ><td colspan="3">' . $ex->getMessage() . '</td></tr>';
    }

    $resultado.='</table>';

    $mensaje = '';
    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
    //$retorn="<h1>Hola</h1>";

    echo json_encode($retornar);
}

function post_ajaxMostrar_Stock(){

    require ROOT_PATH . 'models/inventario.php';
    require ROOT_PATH . 'models/linea.php';
    require ROOT_PATH . 'models/categoria.php';

    $producto_ID=$_POST['ID'];
  try {

    $resultado=inventario::getStock($producto_ID);
    $resultado1=linea::getByID2($producto_ID);
    $categoria_ID=categoria::getByID2($producto_ID);
    $mensaje='';
    $funcion="<script type='text/javascript'> ajaxSelect('selCategoria', '/Compra/ajaxSelect_Categoria/' + ".$resultado1.", '',null); document.getElementById('txtp').value ='".$categoria_ID."' ;</script>";

    } catch (Exception $ex) {
        $resultado=-1;
         $mensaje="Ocurrió un error";
         $funcion="";
    }

    $retornar = Array('resultado' => $resultado, 'funcion' => $funcion,'resultado1' => $resultado1,'mensaje' => $mensaje);
    //$retorn="<h1>Hola</h1>";

    echo json_encode($retornar);
}
function post_ajaxSeleccionar_Producto(){

    require ROOT_PATH . 'models/inventario.php';
    require ROOT_PATH . 'models/producto.php';
    require ROOT_PATH . 'models/linea.php';
    require ROOT_PATH . 'models/categoria.php';

    $producto_ID=$_POST['id'];
  try {

    $stock=inventario::getStock($producto_ID);
    $oProducto=producto::getByID($producto_ID);
    $oCategoria=categoria::getByID($oProducto->categoria_ID);
    $oLinea=linea::getByID($oCategoria->linea_ID);
    $descripcion=FormatTextView($oProducto->descripcion);
    $resultado=1;
    $mensaje='';

    } catch (Exception $ex) {
        $resultado=-1;
        $mensaje=$ex->getMessage();

    }
    $retornar = Array('resultado'=>$resultado,'stock' => $stock,'producto_ID' => $oProducto->ID,'categoria_ID' => $oCategoria->ID,'linea_ID'=>$oLinea->ID,'descripcion'=>$descripcion);
    //$retorn="<h1>Hola</h1>";

    echo json_encode($retornar);
}
function post_ajaxPrecio_ingreso(){

    require ROOT_PATH . 'models/ingreso.php';
    require ROOT_PATH . 'models/ingreso_detalle.php';
    require ROOT_PATH . 'models/producto.php';
    $producto_ID=$_POST['id'];
    try {
        $dtPrecio_Compra_Detalle=ingreso_detalle::getGridPrecioIngreso($producto_ID);
        if(count($dtPrecio_Compra_Detalle)>0){

            foreach($dtPrecio_Compra_Detalle as $item){
               $precio_compra_soles=$item['precio_soles'];
               $precio_compra_dolares=$item['precio_dolares'];
            }
        }else{
            $oProducto=producto::getByID($producto_ID);
            $precio_compra_soles=$oProducto->precio_inicial_soles;
            $precio_compra_dolares=$oProducto->precio_inicial_dolares;
        }
        $resultado=1;
        $mensaje='';
      } catch (Exception $ex) {
          $resultado=-1;
          $mensaje=$ex->getMessage();
          $precio_compra_soles=0;
          $precio_compra_dolares=0;
      }

      $retornar = Array('resultado'=>$resultado,'mensaje' => $mensaje, 'precio_compra_soles' => $precio_compra_soles,'precio_compra_dolares' => $precio_compra_dolares,'producto_ID'=>$producto_ID);
      //$retorn="<h1>Hola</h1>";

      echo json_encode($retornar);
}
function post_ajaxSelect_Producto($Categoria_ID){
    require ROOT_PATH.'models/producto.php';
    if($Categoria_ID==0){
        $linea_ID=$_POST['txtBuscar'];
        if($linea_ID==0){
            $dtProducto=producto::getGrid();
        }else{$dtProducto=producto::getGrid('li.ID='.$linea_ID,-1,-1,'pr.nombre asc');}


    } else{
        $dtProducto=producto::getGrid('pr.categoria_ID='.$Categoria_ID,-1,-1,'pr.nombre asc');
    } 
    $resultado='';
    $contar=count($dtProducto);
    if($contar>0){
        $resultado.='<option value="0">TODOS</option>';
        foreach($dtProducto as $iProducto){

            $resultado.='<option value="'.$iProducto['ID'].'">'.FormatTextView($iProducto['producto']).'</option>';
        }
    } else {
        $resultado.='<option value="-1">Sin Producto</option>';
    }



    $mensaje='';
    $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);

    echo json_encode($retornar);
}
function post_ajaxSelect_Categoria($Linea_ID){
    require ROOT_PATH.'models/categoria.php';


        $resultado='';


        if($Linea_ID==0){
            $dtCategoria=categoria::getGrid();
        }else{
            $dtCategoria=categoria::getGrid('ca.linea_ID='.$Linea_ID);
        }

        $contar=count($dtCategoria);

        if($contar>0){
            $resultado.='<option value="0">TODOS</option>';
            foreach($dtCategoria as $iCategoria){
                    $resultado.='<option value="'.$iCategoria['ID'].'">'.FormatTextView($iCategoria['nombre']).'</option>';
            } 
        } else{
             $resultado.='<option value="-1">Sin Categor&iacute;a</option>';
        }

        $mensaje='';




    $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);

    echo json_encode($retornar);
}
function post_ajaxSelect_inventario($inventario_ID){
    require ROOT_PATH.'models/inventario.php';
    try{
    $oInventario=inventario::getByID($inventario_ID);
    $dtGuiasFaltante=inventario::getGuiaFaltanteSeries($oInventario->producto_ID); 

    $contar=count($dtGuiasFaltante);

    $resultado='<option value="0">Seleccione</option>';
    $resultado.='<option value="-1">A stock</option>';
    if($contar>0){

        foreach($dtGuiasFaltante as $iGuiasFaltante){
            $fecha=$iGuiasFaltante['fecha'];
            //$cantidad_restante=$iGuiasFaltante['cantidad_salida']-
            $resultado.='<option value="'.$iGuiasFaltante['ID'].'">'.$fecha.' N°: ' .FormatTextView(sprintf("%'.07d", $iGuiasFaltante['numero']).' Cantidad:'.$iGuiasFaltante['cantidad_salida']).'</option>';
        } 

    } else{
         $resultado.='<option value="-1">Sin Guia faltante</option>';
    }
    $mensaje='';
    }catch (Exception $ex){
        $resultado="error aqui";
        $mensaje=$ex->getMessage();
    }

    $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);

    echo json_encode($retornar);
}
function get_Pagos_Mantenimiento() {
    require ROOT_PATH . 'models/moneda.php';
    require ROOT_PATH . 'models/proveedor.php';
    require ROOT_PATH . 'models/ingreso.php';
    require ROOT_PATH . 'models/estado.php';
    global $returnView;
    $returnView = true;
    $GLOBALS['dtMoneda']=moneda::getGrid('',-1,-1,'ID desc');
    $dtCompra=ingreso::getGrid('',-1,-1,'co.fecha_emision desc');
    $proveedor_IDs='';
    $a=0;
    $array_periodo=array();
    $periodo='';
    
    foreach($dtCompra as $item){
       
        //$osalida=salida::getByID($item['salida_ID']);
        if($a==0){
            $proveedor_IDs=$item['proveedor_ID'];
            
        }else {
            $proveedor_IDs.=','.$item['proveedor_ID'];
        }
         if($periodo!=substr($item['fecha_emision'],0,4)){
             array_push($array_periodo,substr($item['fecha_emision'],0,4));
         }
        $periodo=substr($item['fecha_emision'],0,4);
       $a++;
    }
    if($proveedor_IDs!=""){
        $GLOBALS['dtProveedor']=proveedor::getGrid('prv.empresa_ID='.$_SESSION['empresa_ID'].' and prv.ID in ('.$proveedor_IDs.')',-1,-1,'prv.razon_social asc');
    }else{
            $GLOBALS['dtProveedor']=array();
    }    
    $GLOBALS['dtPerido']=$array_periodo;
    $GLOBALS['dtEstado']=estado::getGrid('est.tabla="ingreso"',-1,-1,'est.nombre asc');
}
function post_ajaxPagos_Mantenimiento() {
    require ROOT_PATH . 'models/ingreso.php';
    require ROOT_PATH . 'models/moneda.php';
    require ROOT_PATH . 'models/estado.php';
    require ROOT_PATH . 'models/ingreso_pagos.php';
    require ROOT_PATH . 'controls/funcionController.php';
    $estado_ID=$_POST['selEstado'];
    $moneda_ID=$_POST['selMoneda'];
    $opcion_tipo=$_POST['rbOpcion'];
    $fecha_inicio=$_POST['txtFechaInicio'];
    $fecha_fin=$_POST['txtFechaFin'];
    $serie=trim($_POST['txtSerie']);
    $numero=trim($_POST['txtNumero']);
    $proveedor_ID=$_POST['selProveedor'];
    $todos=(isset($_POST['ckTodos']))?1:0;
    
    $periodo=$_POST['selPeriodo'];
    $paginaActual = $_POST['num_page'] == 0 ? 1 : $_POST['num_page'];
    $cantidadMostrar = $_POST['txtMostrar'] == '' ? 30 : $_POST['txtMostrar'];
    $txtOrden = $_POST['txtOrden'];
    $orden_tipo = 'DESC';
    $orden_class = 'imgOrden-desc';
    if (isset($_POST['chkOrdenASC'])) {
        $orden_class = 'imgOrden-asc';
        $orden_tipo = 'ASC';
    }
    switch ($txtOrden) {
        case 1:
            $orden = 'co.codigo ' . $orden_tipo;
            break;
        case 2:
            $orden = 'co.serie ' . $orden_tipo;
            break;
        case 3:
            $orden = 'co.numero ' . $orden_tipo;
            break;
        case 4:
            $orden = 'co.fecha_emision ' . $orden_tipo;
            break;
        case 5:
            $orden = 'co.fecha_vencimiento ' . $orden_tipo;
            break;
        case 6:
            $orden = 'pr.razon_social ' . $orden_tipo;
            break;
        case 7:
            $orden = 'mo.descripcion ' . $orden_tipo;
            break;
        case 8:
            $orden = 'co.total ' . $orden_tipo;
            break;
        case 9:
            $orden = 'co.monto_pendiente ' . $orden_tipo;
            break;
        case 10:
            $orden = 'est.nombre ' . $orden_tipo;
            break;        
        default:
            $orden = 'co.ID ' . $orden_tipo;
            break;
    }
    $filtro="co.total>0 and co.estado_ID!=10 and co.numero>0";
    if($opcion_tipo=="buscar"){
        if($periodo!=0){
            $filtro.=" and co.periodo=".$periodo;
        }
        if(ltrim($serie,0)!=''){
            $filtro.=" and co.serie='".$serie."'";
        }
        if(ltrim($numero,0)!=""){
        $filtro.=" and co.numero=".ltrim($numero,0);
        }
    }else {
        if($proveedor_ID!=0){
           $filtro.=" and co.proveedor_ID=".$proveedor_ID;
        }
        if($estado_ID!=0){
            $filtro.=" and co.estado_ID=".$estado_ID ;
        }
        if($todos==0){
            if($fecha_inicio!="__/__/____" &&$fecha_fin!="__/__/____" ){
        
                $filtro.=" and  co.fecha_emision between '".FormatTextToDate($fecha_inicio, "Y-m-d")."' and '". FormatTextToDate($fecha_fin, "Y-m-d")."'";
            }
        }
        
        if($moneda_ID!=0){
       
            $filtro.=" and co.moneda_ID=".$moneda_ID;
        }
    }
  			 
    $resultado = '<table id="websendeos" class="grid table table-hover table-bordered"><thead><tr>';
    $resultado.='<th class="thOrden">#</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(1);">Cod Compra' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(2);">Serie' . (($txtOrden == 2 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(3);">Número' . (($txtOrden == 3 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(4);">Fecha Emisión' . (($txtOrden == 4 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(5);">Fecha Vencimiento' . (($txtOrden == 5 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(6);">Proveedor' . (($txtOrden == 6 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(7);">Moneda' . (($txtOrden == 7 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(8);">Total' . (($txtOrden == 8 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(9);">Pendiente' . (($txtOrden == 9 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(10);">Pago' . (($txtOrden == 10 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th></th>';
    $resultado.='</tr></thead>';
    $resultado.='<tbody>';
    $colspanFooter = 12;
    try {
        $cantidadMaxima = ingreso::getCount($filtro);
        $dtCompra = ingreso::getGrid($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
        $rows = count($dtCompra);
         
        $i=($paginaActual-1)*$cantidadMostrar+1;
        foreach ($dtCompra as $item) {
            //$oMoneda=moneda::getByID($item['moneda_ID']);
            $resultado.='<tr class="tr-item">';
           
            $texto='Pagar';
           // $osalida=salida::getByID($item['ID']);
            
            if($item['estado_ID']==11){
                  $texto='Ver pagos';
            }
            
            
            $resultado.='<td class="text-center">'. $i.'</td>';
            $i++;
            $resultado.='<td class="text-center">' .sprintf("%'.05d",$item['codigo']) . '</td>';
            $resultado.='<td class="text-center">' .sprintf("%'.03d",$item['serie']) . '</td>';
            $resultado.='<td class="tdLeft">' .sprintf("%'.09d",$item['numero']) . '</td>';
            
            $resultado.='<td class="text-center">' . date("d/m/Y",strtotime($item['fecha_emision'])) . '</td>';
            $resultado.='<td class="text-center">' . date("d/m/Y",strtotime($item['fecha_vencimiento'])) . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextView($item['proveedor']) . '</td>';
            $resultado.='<td class="text-right">' . FormatTextView($item['simbolo']) . '</td>';
            $resultado.='<td class="text-right">' . number_format($item['total'],2,'.',','). '</td>';
            $resultado.='<td class="text-right">' . number_format($item['monto_pendiente'],2,'.',','). '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextViewHtml($item['estado']) . '</td>';
            $botones=array();
            $boton='<a onclick="fncPagar(' . $item['ID'] . ');" title="'.$texto.'"><span class="glyphicon glyphicon-usd"></span>'.$texto.'</a>';
            array_push($botones,$boton);
            
            $resultado.='<td class="btnAction" >'.extraerOpcion($botones)."</td>";
            $resultado.='</tr>';
        }
        $cantidadPaginas = '';
        $resultado.=paginacion($cantidadMaxima,$cantidadMostrar,$colspanFooter,$paginaActual);
        $resultado.='<tr class="tr-footer"><th colspan=' . $colspanFooter . '>' . $rows . ' de ' . $cantidadMaxima . ' Registros</th></tr>';
        
    } catch (Exception $ex) {
        $resultado.='<tr ><td colspan=' . $colspanFooter . '>' . $ex->getMessage() . '</td></tr>';
    }
    $resultado.='</tbody>';
    $resultado.='</table>';

    $mensaje = '';
    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
    //$retorn="<h1>Hola</h1>";

    echo json_encode($retornar);
}
function get_Pagos_Mantenimiento_Registro($id){
    require ROOT_PATH.'models/ingreso.php';
    require ROOT_PATH.'models/moneda.php';
    require ROOT_PATH.'models/estado.php';
    global  $returnView_float;
    $returnView_float=true;
    $oCompra=ingreso::getByID($id);
    
    $oMoneda=moneda::getByID($oCompra->moneda_ID);
    $oCompra->moneda= $oMoneda->descripcion;
    $oEstado=estado::getByID($oCompra->estado_ID);
    $oCompra->estado=$oEstado->nombre;
    $GLOBALS['oCompra']=$oCompra;
    $GLOBALS['mensaje']='';
}
function post_ajaxGrabarPagos_Mantenimiento_Registro(){
    require ROOT_PATH.'models/ingreso.php';
    require ROOT_PATH.'models/ingreso_pagos.php';
     if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";
     require ROOT_PATH.'models/moneda.php';
    $compra_ID=$_POST['txtCompra_ID'];
    
    if(!isset($_POST['txtFecha_Pago'])){
        $fecha_pago='';
    }else {
        $fecha_pago=$_POST['txtFecha_Pago'];
    }
    if(!isset($_POST['txtMonto_Pago'])){
        $monto_pagado=0;
    }else {
        $monto_pagado=str_replace(',','',$_POST['txtMonto_Pago']);
    }
    $opcion_total=0;
    if(isset($_POST['ckPago_Total'])){
        $opcion_total=$_POST['ckPago_Total'];
    }
    $bloquear=0;
    $resultado=0;
    $mensaje="";
    $monto_pendiente=0;
    try{
        $oCompra=ingreso::getByID($compra_ID);
        $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
        if(trim($monto_pagado)==""){
            throw new Exception("Debe registrar un monto.");
        }
        $dtCompra_Pagos1=ingreso_pagos::getGrid('ingreso_ID='.$compra_ID,-1,-1,'fecha asc, fdc asc');
           
        if($oCompra->monto_pendiente>0 && $monto_pagado!=0 ){
                $monto_total_pagado=0;
            foreach($dtCompra_Pagos1 as $item){
                $monto_total_pagado=$monto_total_pagado+$item['monto_pagado'];
            }
                $monto_total_pendiente=$oCompra->total- ($monto_total_pagado+$monto_pagado);
                //$monto_neto_pendiente=round($monto_total_pendiente/(1+$oDatos_Generales->vigv),2);
                //$monto_igv_pendiente=$monto_total_pendiente-$monto_neto_pendiente;
                $oCompra->monto_pendiente=$monto_total_pendiente;
                $oCompra->usuario_mod_id=$_SESSION['usuario_ID'];
                $oCompra->actualizarMontoPendiente();
                $monto_pendiente=number_format($monto_total_pendiente,2,'.',',');
                
                $oMoneda=moneda::getByID($oCompra->moneda_ID);
                $oCompra_Pagos=new ingreso_pagos();
                $oCompra_Pagos->ingreso_ID=$oCompra->ID;
                $oCompra_Pagos->fecha=$fecha_pago;
                $oCompra_Pagos->monto_pagado=$monto_pagado;
                $oCompra_Pagos->monto_pendiente=$monto_total_pendiente;
                $oCompra_Pagos->usuario_id=$_SESSION['usuario_ID'];
                $oCompra_Pagos->insertar();
                //Actualizamos el estado a cancelado
                if($monto_total_pendiente==0){
                    $oCompra->estado_ID=11;
                    $oCompra->actualizarEstado();
                }
            }else {
            $oCompra->estado_ID=11;
            $bloquear=1;
            $oCompra->actualizarEstado();
        }
        $resultado=1;
        $mensaje="El pago se registró correctamente.";
    }catch(Exception $ex){
        $resultado=-1;
        $mensaje=$ex->getMessage();
    }
    
    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje,'bloquear'=>$bloquear,'monto_pendiente'=>$monto_pendiente);
    //$retorn="<h1>Hola</h1>";

    echo json_encode($retornar);
    
}

function post_ajaxPagos_Mantenimiento_Registro(){
    require ROOT_PATH.'models/ingreso.php';
    require ROOT_PATH.'models/ingreso_pagos.php';
 
    require ROOT_PATH . 'controls/funcionController.php';
    $compra_ID=$_POST['id'];
    $resultado='<table class="table table-hover table-bordered table-teal"><thead><tr>'.
            '<th class="text-center;">Item</th>'.
            '<th class="text-center;">Fecha</th>'.
            '<th class="text-center;">Pago</th>'.
            '<th class="text-center;">Saldo Total</th>'.
            '<th class="text-center;"></th>'.
            '</tr></thead><tbody>';
    try{
        
        $dtCompra_Pagos=ingreso_pagos::getGrid('ingreso_ID='.$compra_ID,-1,-1,'ID asc');
        $i=1;
        foreach($dtCompra_Pagos as $value){
            $fecha=date('d/m/Y',strtotime($value['fecha']));
            $resultado.= '<tr class="item-tr" id="'.$value['ID'].'" >'.
                '<td class="text-center">'.$i.'</td>'.
                '<td class="text-center">'.$fecha.'</td>'.
                '<td class="text-right">'.number_format($value['monto_pagado'],2,'.',',').'</td>'.
                '<td class="text-right">'.number_format($value['monto_pendiente'],2,'.',',').'</td>';
                $botones=array();
                array_push($botones,'<a onclick="modal.confirmacion(&#39;El proceso es irreversible, esta seguro de eliminar el registro.&#39;,&#39;Eliminar pago&#39;,fncEliminar,&#39;' . $value['ID'] . '&#39;);" title="Eliminar Pago"><span class="glyphicon glyphicon-trash"></span>Eliminar</a>');
            $resultado.='<td class="text-center" >'.extraerOpcion($botones)."</td>";   
            $resultado.='</tr>';
            $i++;
        }
    }catch(Exception $ex){
        $resultado.='<tr><td colspan="5"></td>'.$ex->getMessage().'</tr>';
    }
    $resultado.='</tbody>';
    $resultado.='</table>';
    
   
    $retornar = Array('resultado' => $resultado);
    echo json_encode($retornar);
}
function post_ajaxMantenimiento_Registro_Eliminar(){
 
    require ROOT_PATH . 'models/ingreso.php';
    require ROOT_PATH . 'models/ingreso_pagos.php';
        $compra_pagos_ID=$_POST['id'];
        $monto_pendiente="";
        try{

            $oCompra_Pagos=ingreso_pagos::getByID($compra_pagos_ID);
            if($oCompra_Pagos==null){
                $resultado=-1;
                $mensaje="El registro ya fue eliminado";
            }else {
                    $oCompra_Pagos->usuario_mod_id=$_SESSION['usuario_ID'];
                if($oCompra_Pagos->eliminar()==1){
                    $oCompra=ingreso::getByID($oCompra_Pagos->ingreso_ID);
                    $oCompra->monto_pendiente=$oCompra->monto_pendiente+$oCompra_Pagos->monto_pagado;
                    //Cambiamos el estado a pendiente
                    $oCompra->estado_ID=9;
                    $oCompra->usuario_mod_id=$_SESSION['usuario_ID'];
                    $oCompra->actualizar();
                    //Actualizamos los montos pendientes
                    $dtCompra_Pagos_despues=ingreso_pagos::getGrid('ingreso_ID='.$oCompra->ID .' and monto_pendiente <'.$oCompra_Pagos->monto_pendiente,-1,-1,'fecha asc, fdc asc');
                    foreach($dtCompra_Pagos_despues as $item){
                        $oCompra_Pagos1=ingreso_pagos::getByID($item['ID']);
                       // date("d/m/Y",strtotime($item['fecha_emision']))
                        $oCompra_Pagos1->fecha= date("d/m/Y",strtotime($oCompra_Pagos1->fecha));
                        $oCompra_Pagos1->monto_pendiente=$oCompra_Pagos1->monto_pendiente+$oCompra_Pagos->monto_pagado;
                        $oCompra_Pagos1->usuario_mod_id=$_SESSION['usuario_ID'];
                        $oCompra_Pagos1->actualizar();
                        
                    }
                }
                
                $mensaje=$oCompra_Pagos->message;
                $resultado=1;
                $monto_pendiente=number_format($oCompra->monto_pendiente,2,'.',',');
            }
            
        } catch (Exception $ex) {
            $resultado=-1;
            $mensaje=$ex->getMessage();
            $monto_pendiente='';
        }
     $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje, 'monto_pendiente' => $monto_pendiente);

    echo json_encode($retornar);
}
//----------------------------------Orden de Compra--------------------------------//
    //----------------------------------//---------------------------------------------//
    
    
    
function get_Orden_Compra_Mantenimiento(){
    require ROOT_PATH . 'models/proveedor.php';
    require ROOT_PATH . 'models/estado.php';
    require ROOT_PATH . 'models/moneda.php';

    global $returnView;
    $returnView=true;
    $dtProveedor=proveedor::getGrid('ID<>0',-1,-1,"razon_social asc");
    $dtEstado=estado::getGrid('tabla="orden_ingreso" and ID in (55,56)');
    $dtMoneda=moneda::getGrid();
   
   
    $GLOBALS['dtProveedor']=$dtProveedor;
    $GLOBALS['dtEstado']=$dtEstado;
    $GLOBALS['dtMoneda']=$dtMoneda;
    
    
}
function post_ajaxOrden_Compra_Mantenimiento1() {
    require ROOT_PATH . 'models/orden_ingreso.php';
    
    $dt=orden_ingreso::getGrid("",-1,-1,"oc.ID desc");

    
    //$retorn="<h1>Hola</h1>";

    echo json_encode($dt);
}

    
function post_ajaxOrden_Compra_Mantenimiento() {
    require ROOT_PATH . 'models/orden_ingreso.php';
    require ROOT_PATH . 'controls/funcionController.php';
    //$buscar = $_POST['txtBuscar'];
    $opcion_tipo=$_POST['rbOpcion'];
    $paginaActual = $_POST['num_page'] == 0 ? 1 : $_POST['num_page'];
    $cantidadMostrar = $_POST['txtMostrar'] == '' ? 30 : $_POST['txtMostrar'];
    $txtOrden = $_POST['txtOrden'];
    $orden_tipo = 'DESC';
    $orden_class = 'imgOrden-desc';
    if (isset($_POST['chkOrdenASC'])) {
        $orden_class = 'imgOrden-asc';
        $orden_tipo = 'ASC';
    }
    switch ($txtOrden) {
        case 1:
            $orden = 'oc.numero_orden ' . $orden_tipo;
            break;
        case 2:
            $orden = 'prv.razon_social ' . $orden_tipo;
            break;
        
        case 3:
            $orden = 'es.nombre ' . $orden_tipo;
            break;
        case 4:
            $orden = 'oc.fecha ' . $orden_tipo;
            break;
        case 5:
            $orden = 'mo.descripcion ' . $orden_tipo;
            break;
        case 6:
            $orden = 'oc.total ' . $orden_tipo;
            break;
        default:
            $orden = 'oc.ID ' . $orden_tipo;
            break;
    }
    
    
    $filtro="";
    if($opcion_tipo=='buscar'){
        $numero=trim($_POST['txtNumero']);
        if(trim($numero)!=""){
            $filtro= "oc.numero_orden=".$numero;
        }
       
    } else{
        $proveedor_ID=$_POST['selProveedor'];
        $estado_ID=$_POST['selEstado'];
        $fecha_inicio=$_POST['txtFechaInicio'];
        $fecha_fin=$_POST['txtFechaFin'];
        $moneda_ID=$_POST['selMoneda'];
        $todos=(isset($_POST['ckTodos']))? 1 : 0;
        if($proveedor_ID!=0){
            $filtro.="oc.proveedor_ID=".$proveedor_ID;
        }
         if($estado_ID!=0){

            $filtro.=((trim($filtro)!="")?" and ":""). "oc.estado_ID=".$estado_ID;
        }
        if($moneda_ID!=0){
            $filtro.=((trim($filtro)!="")?" and ":"")."oc.moneda_ID=".$moneda_ID;
        }
        if($todos==0){
            if($fecha_inicio!="" &&$fecha_fin!="" ){

                $filtro.=((trim($filtro)!="")?" and ":"")." oc.fecha between '".FormatTextToDate($fecha_inicio,'Y-m-d')."' and '". FormatTextToDate($fecha_fin,'Y-m-d'). "'";
            }
        }
    }
    
    //$filtro = 'upper(pr.razon_social) like "%' . str_replace(' ', '%', strtoupper(FormatTextSave($buscar))) . '%"';

    //---------------------------------------					 
    $resultado = '<table id="websendeos" class="grid table table-hover table-bordered"><theader><tr>';
    $resultado.='<th class="text-center">#</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(1);">NUM. ORD.' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(2);">PROVEEDOR' . (($txtOrden == 2 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(3);">ESTADO' . (($txtOrden == 3 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(4);">FECHA' . (($txtOrden == 4 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(5);">MONEDA' . (($txtOrden == 5 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(6);">TOTAL' . (($txtOrden == 6 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th></th>';
    $resultado.='</tr></theader>';
    $resultado.='<tbody>';
    $colspanFooter = 8;
    try {
        $cantidadMaxima = orden_ingreso::getCount($filtro);
        $dtOrden_Compra = orden_ingreso::getGrid1($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
        $rows = count($dtOrden_Compra);
        $i=(($paginaActual-1) * $cantidadMostrar)+1;
        
        foreach ($dtOrden_Compra as $item) {
            $resultado.='<tr class="tr-item">';
            $resultado.='<td class="text-center">'.$i.'</td>';
            $resultado.='<td class="text-center">' . sprintf("%',05d",$item['numero_orden']) . '</td>';
            $resultado.='<td class="tdLeft">' . strtoupper($item['proveedor']) . '</td>';           
            $resultado.='<td class="tdLeft">' . $item['estado'] . '</td>';
            $resultado.='<td class="text-center">' . date("d/m/Y",strtotime($item['fecha'])) . '</td>';
            $resultado.='<td class="text-right">' . $item['simbolo'] . '</td>';
            $resultado.='<td class="text-right">' . number_format($item['total'],2,'.',',') . '</td>';
            $i++;
            $botones=array();
            if($item['estado_ID']==59){
                array_push($botones,'<a class="btn-view" onclick="fncVerDetalle(' . $item['ID'] . ');" title=""><img src="/include/img/boton/find_14x14.png" />Ver</a>');
            }else{
                array_push($botones,'<a class="btn-view" onclick="fncEditar(' . $item['ID'] . ');" title="Editar" ><img src="/include/img/boton/edit_14x14.png" />Editar</a>');
                //array_push($botones,'<a onclick="fncEliminar(' . $item['ID'] . ');" title="Eliminar" ><img src="/include/img/boton/delete_14x14.png" /> Eliminar</a>');
                array_push($botones,'<a class="btn-view" onclick="modal.confirmacion(&#39;El proceso es irreversible, esta seguro de eliminar el registro.&#39;,&#39;Eliminar&#39;,fncEliminar,&#39;' . $item['ID'] . '&#39;);" title="Eliminar compra"><img src="/include/img/boton/delete_14x14.png" /> Eliminar</a>');
            }
            
            $resultado.='<td class="btnAction">'.extraerOpcion($botones).'</td>';
            $resultado.='</tr>';
            
        }

        $cantidadPaginas = '';
        $resultado.=paginacion($cantidadMaxima,$cantidadMostrar,$colspanFooter,$paginaActual);
        $resultado.='<tr class="tr-footer"><th colspan=' . $colspanFooter . '>' . $rows . ' de ' . $cantidadMaxima . ' Registros</th></tr>';

    } catch (Exception $ex) {
        $resultado.='<tr ><td colspan=' . $colspanFooter . '>' . $ex->getMessage() . '</td></tr>';
    }
    $resultado.='</tbody>';
    $resultado.='</table>';

    $mensaje = '';
    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
    //$retorn="<h1>Hola</h1>";

    echo json_encode($retornar);
}

function get_orden_compra_mantenimiento_nuevo_producto($orden_compra_ID){
    require ROOT_PATH . 'models/categoria.php';
    require ROOT_PATH . 'models/linea.php';
    require ROOT_PATH . 'models/producto.php';
    require ROOT_PATH . 'models/estado.php';
    require ROOT_PATH . 'models/orden_ingreso_detalle.php';
    require ROOT_PATH . 'models/orden_ingreso.php';
    require ROOT_PATH . 'models/moneda.php';
    if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";;

        global $returnView_float;
        $returnView_float=true; 
        $oCategoria=new categoria();
        $oLinea=new linea();
        $oEstado=new estado();
        $oProducto=new producto();
        $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
        $dtCategoria=$oCategoria->getGrid("ca.empresa_ID=".$_SESSION['empresa_ID'],-1,-1,"ca.nombre asc");
        $dtLinea=$oLinea->getGrid("li.empresa_ID=".$_SESSION['empresa_ID'],-1,-1,"li.nombre asc");
        
        $dtProducto=$oProducto->getGrid("pr.empresa_ID=".$_SESSION['empresa_ID'],-1,-1,"pr.nombre asc");
        $oOrden_Compra=orden_ingreso::getByID($orden_compra_ID);
        $oOrden_compra_detalle=new orden_ingreso_detalle();
        
        $oOrden_compra_detalle->descripcion=  FormatTextSave('');
        $oOrden_compra_detalle->ID=0;
        $oOrden_compra_detalle->vigv=$oOrden_Compra->vigv;
        $oOrden_compra_detalle->oMoneda=moneda::getByID($oOrden_Compra->moneda_ID);
        
        $GLOBALS['fecha']=$oOrden_Compra->fecha;
        $GLOBALS['orden_compra_ID']=$orden_compra_ID;
        $GLOBALS['dtCategoria']=$dtCategoria;
        $GLOBALS['categoria_ID']=0;
        $GLOBALS['dtLinea']=$dtLinea;
        $GLOBALS['linea_ID']=0;
       
        $GLOBALS['dtProducto']=$dtProducto;
        $GLOBALS['oOrden_Compra_detalle']=$oOrden_compra_detalle;              
        $GLOBALS['oProducto']=new producto();
//        $GLOBALS['mensaje'] ="";
    } 
    
function post_orden_compra_mantenimiento_nuevo_producto($orden_compra_ID){
        require ROOT_PATH . 'models/categoria.php';
        require ROOT_PATH . 'models/linea.php';
        require ROOT_PATH . 'models/producto.php';
        require ROOT_PATH . 'models/estado.php';
        require ROOT_PATH . 'models/orden_ingreso_detalle.php';
        require ROOT_PATH . 'models/orden_ingreso.php';
        require ROOT_PATH . 'models/moneda.php';
        global $returnView_float;
        $returnView_float=true;
        $ID=$_POST['txtID'];
        $linea_ID=$_POST['selLinea'];
        $categoria_ID=$_POST['selCategoria'];
        $producto_ID=$_POST['selProducto'];
        $descripcion= $_POST['txtDescripcion'];
        $cantidad=$_POST['txtCantidad'];
        $precio=$_POST['txtPrecioUnitario'];
        $subtotal=$_POST['txtSubTotal'];
        $igv=$_POST['txtIgv'];
        $total=$_POST['txtTotal'];
        
        try{
            
         
            $oOrden_compra_detalle=new orden_ingreso_detalle();
            
            $oOrden_compra_detalle->orden_ingreso_ID=$orden_compra_ID;
            $oOrden_compra_detalle->producto_ID=$producto_ID;
            $oOrden_compra_detalle->descripcion=$descripcion;
            $oOrden_compra_detalle->cantidad=$cantidad;
            $oOrden_compra_detalle->precio=$precio;
            $oOrden_compra_detalle->subtotal=$subtotal;
            $oOrden_compra_detalle->igv=$igv;
            $oOrden_compra_detalle->total=$total;
            $oOrden_compra_detalle->usuario_id=$_SESSION['usuario_ID'];
            
          $oOrden_compra_detalle->insertar1();

            $resultado=1;
            $mensaje=$oOrden_compra_detalle->getMessage;
        } catch (Exception $ex) {
            $resultado=-1;
            $mensaje=$ex->getMessage();
        }
        $oOrden_Compra=orden_ingreso::getByID($orden_compra_ID);
        $oOrden_compra_detalle->vigv=$oOrden_Compra->vigv;
        $dtLinea=linea::getGrid();
        if($linea_ID!=0){
            $dtCategoria=categoria::getGrid('ca.linea_ID='.$linea_ID);
        }else{
            $dtCategoria=categoria::getGrid();
            
        }
        if($categoria_ID!=0){
            $dtProducto=producto::getGrid('pr.categoria_ID='.$categoria_ID);
        }else{
            $dtProducto=producto::getGrid();
            
        }
        $oOrden_compra_detalle->oMoneda=moneda::getByID($oOrden_Compra->moneda_ID);
        $oProducto=producto::getByID($producto_ID);
        
        $GLOBALS['dtLinea']=$dtLinea;
        $GLOBALS['dtCategoria']=$dtCategoria;
        $GLOBALS['linea_ID']=$linea_ID;
        $GLOBALS['categoria_ID']=$categoria_ID;
        $GLOBALS['dtProducto']=$dtProducto;
        $GLOBALS['oProducto']=$oProducto;
        $GLOBALS['oOrden_Compra_detalle']=$oOrden_compra_detalle;
        $GLOBALS['resultado']=$resultado;
        $GLOBALS['mensaje']=$mensaje;
        
    }

/*====Nuevos codigo de orden de compra*/
function get_Orden_Compra_Mantenimiento_Nuevo(){
    require ROOT_PATH.'models/orden_ingreso.php';
    require ROOT_PATH.'models/estado.php';
    require ROOT_PATH.'models/moneda.php';
    require ROOT_PATH.'models/proveedor.php';
    
    require ROOT_PATH.'models/datos_generales.php';
    
    global $returnView_float;
    $returnView_float=true;
    $oOrden_Compra = new orden_ingreso();
    
    $oDatos_generales=datos_generales::getByID1($_SESSION['empresa_ID']);
    $dtEstado=estado::getGrid('est.ID in (55,56) and est.tabla="orden_ingreso"');
    $dtMoneda=moneda::getGrid('',-1,-1,'ID desc');
    $oOrden_Compra->dtMoneda=$dtMoneda;
    $oOrden_Compra->dtEstado=$dtEstado;
    $oOrden_Compra->moneda_ID=$_SESSION['moneda'];
    $oOrden_Compra->estado_ID=55;
    $oOrden_Compra->dtProveedor=proveedor::getGrid("ID<>0 and empresa_ID=".$_SESSION['empresa_ID'],-1,-1,"razon_social");
    $oOrden_Compra->fecha=date('d/m/Y');
    $oOrden_Compra->ID=0;
    //$oOrden_Compra->comentario='';
    $oOrden_Compra->vigv=round($oDatos_generales->vigv,2);
    $oOrden_Compra->tipo_cambio=$oDatos_generales->tipo_cambio;
    $GLOBALS['oOrden_Compra']=$oOrden_Compra;

}
function post_Orden_Compra_Mantenimiento_Nuevo(){
    require ROOT_PATH.'models/orden_ingreso.php';
    require ROOT_PATH.'models/orden_ingreso_detalle.php';
    require ROOT_PATH.'models/estado.php';
    require ROOT_PATH.'models/moneda.php';
    require ROOT_PATH.'models/proveedor.php';
    if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";
    global $returnView_float;
    $returnView_float=true;
    $orden_compra_ID=$_POST['txtOrden_Compra_ID'];
    $tipo_cambio=$_POST['txtTipo_Cambio'];
    $estado_ID=$_POST['selEstado'];
    $fecha=$_POST['txtFecha'];  
   // $numero_orden=$_POST['txtNumero_Orden'];
    $proveedor_ID=$_POST['selProveedor'];
    $moneda_ID=$_POST['selMoneda'];
    $vigv=$_POST['txtVigv'];
    $comentario=  $_POST['txtComentario'];
    
    if($orden_compra_ID=='0'){
        $oOrden_Compra = new orden_ingreso();
        $oOrden_Compra->ID=0;
    }else {
        $oOrden_Compra=orden_ingreso::getByID($orden_compra_ID);
        if($oOrden_Compra==null){
            $GLOBALS['resultado']=-2;
            $GLOBALS['mensaje'] ="La orden de compra ha sido eliminado por otro usuario.";
            return;
        }
    }
    try{
        //$oOrden_Compra->numero_orden=$numero_orden;
        $oOrden_Compra->tipo_orden_ID=1;//Ingresamos el tipo orden de compra
        $oOrden_Compra->estado_ID=$estado_ID;
        $oOrden_Compra->fecha=$fecha;
        $oOrden_Compra->proveedor_ID=$proveedor_ID;
        $oOrden_Compra->tipo_cambio=$tipo_cambio;
        $oOrden_Compra->moneda_ID=$moneda_ID;
        $oOrden_Compra->subtotal=0;
        $oOrden_Compra->vigv=$vigv;
        $oOrden_Compra->comentario=$comentario;
        $oOrden_Compra->usuario_id=$_SESSION['usuario_ID'];
        $oOrden_Compra->comentario=$comentario;
        /*if($oOrden_Compra->verificarDuplicado()>0){
                throw new Exception($oOrden_Compra->getMessage);
        }*/
        if($oOrden_Compra->ID==0){
            $oOrden_Compra->total=0;
            $oOrden_Compra->insertar1();
        }else {
            $oOrden_Compra->usuario_mod_id=$_SESSION['usuario_ID'];
            $oOrden_Compra->actualizar1();
        }
       $GLOBALS['resultado']=1;
       $GLOBALS['mensaje'] =$oOrden_Compra->getMessage;
    }catch(Exception $ex){
        $GLOBALS['resultado'] = -1;
        $GLOBALS['mensaje'] = $ex->getMessage();
    }
    $oOrden_Compra->dtProveedor=proveedor::getGrid("ID<>0 and empresa_ID=".$_SESSION['empresa_ID'],-1,-1,"razon_social");
    $oDatos_generales=datos_generales::getByID1($_SESSION['empresa_ID']);
    $dtMoneda=moneda::getGrid();
    $dtEstado=estado::getGrid('est.ID in (55,56) and est.tabla="orden_ingreso"');
    $oOrden_Compra->dtEstado=$dtEstado;
    $oOrden_Compra->dtMoneda=$dtMoneda;
    
    
    $GLOBALS['oOrden_Compra']=$oOrden_Compra;

}
function get_Orden_Compra_Mantenimiento_Editar($id){
    require ROOT_PATH.'models/orden_ingreso.php';
    require ROOT_PATH.'models/estado.php';
    require ROOT_PATH.'models/moneda.php';
    require ROOT_PATH.'models/proveedor.php';
     if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";
    global $returnView_float;
    $returnView_float=true;
    
    $oDatos_generales=datos_generales::getByID1($_SESSION['empresa_ID']);
    $dtEstado=estado::getGrid('est.ID in (55,56) and est.tabla="orden_ingreso"');
    $dtMoneda=moneda::getGrid('',-1,-1,'ID desc');

    $oOrden_Compra = orden_ingreso::getByID($id);
    if($oOrden_Compra==null){
        $GLOBALS['resultado'] = -2;
        $GLOBALS['mensaje'] = "La orden de compra ha sido eliminado por otro usuario.";
        return;
    }
    $oOrden_Compra->oEstado=estado::getByID($oOrden_Compra->estado_ID);
    $dtProveedor=proveedor::getGrid("prv.empresa_ID=".$_SESSION['empresa_ID'],-1,-1,"prv.razon_social");
    $oProveedor=proveedor::getByID($oOrden_Compra->proveedor_ID);
    $oOrden_Compra->vigv=round($oOrden_Compra->vigv,2);
    $oOrden_Compra->oProveedor=$oProveedor;
     $oOrden_Compra->dtProveedor=$dtProveedor;
    $oOrden_Compra->dtEstado=$dtEstado;
    $oOrden_Compra->dtMoneda=$dtMoneda;
    //$oOrden_Compra->tipo_cambio=$oDatos_generales->tipo_cambio;
    $GLOBALS['oOrden_Compra']=$oOrden_Compra;


}
function post_Orden_Compra_Mantenimiento_Editar(){
    require ROOT_PATH.'models/orden_ingreso.php';
    require ROOT_PATH.'models/orden_ingreso_detalle.php';
    require ROOT_PATH.'models/estado.php';
    require ROOT_PATH.'models/moneda.php';
    require ROOT_PATH.'models/proveedor.php';

     if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";
    global $returnView_float;
    $returnView_float=true;
    $orden_compra_ID=$_POST['txtOrden_Compra_ID'];
    $tipo_cambio=$_POST['txtTipo_Cambio'];
    $estado_ID=$_POST['selEstado'];
    $fecha=$_POST['txtFecha'];  
   // $numero_orden=$_POST['txtNumero_Orden'];
    $proveedor_ID=$_POST['selProveedor'];
    $moneda_ID=$_POST['selMoneda'];
    $vigv=$_POST['txtVigv'];
    $comentario=  $_POST['txtComentario'];
   
    $oOrden_Compra=orden_ingreso::getByID($orden_compra_ID);
    if($oOrden_Compra==null){
        $GLOBALS['resultado'] = -2;
        $GLOBALS['mensaje'] = "La orden de compra ha sido eliminado por otro usuario";
        return;
    }
    //if($GLOBALS['resultado']!=-2){
    try{

    //$oOrden_Compra->numero_orden=$numero_orden;
    $oOrden_Compra->estado_ID=$estado_ID;
    $oOrden_Compra->fecha=$fecha;
    $oOrden_Compra->proveedor_ID=$proveedor_ID;
    $oOrden_Compra->tipo_cambio=$tipo_cambio;
    $oOrden_Compra->moneda_ID=$moneda_ID;
    $oOrden_Compra->subtotal=0;
    $oOrden_Compra->vigv=$vigv;
    $oOrden_Compra->total=0;
    $oOrden_Compra->comentario=$comentario;

    $oOrden_Compra->usuario_id=$_SESSION['usuario_ID'];
    $oOrden_Compra->usuario_mod_id=$_SESSION['usuario_ID'];
    $oOrden_Compra->actualizar1();


   $GLOBALS['resultado']=1;
   $GLOBALS['mensaje'] =$oOrden_Compra->getMessage;


    }catch(Exception $ex){
        $GLOBALS['resultado'] = -1;
        $GLOBALS['mensaje'] = $ex->getMessage();
    } 
    
    
    $oProveedor=proveedor::getByID($oOrden_Compra->proveedor_ID);
    $dtProveedor=proveedor::getGrid("prv.empresa_ID=".$_SESSION['empresa_ID'],-1,-1,"prv.razon_social");
    $oDatos_generales=datos_generales::getByID1($_SESSION['empresa_ID']);
    $dtMoneda=moneda::getGrid();
    $dtEstado=estado::getGrid('est.ID in (55,56) and est.tabla="orden_ingreso"');

   
    $oOrden_Compra->dtProveedor=$dtProveedor;
    $oOrden_Compra->vigv=round($oOrden_Compra->vigv,2);
    $oOrden_Compra->oProveedor=$oProveedor;
    $oOrden_Compra->dtEstado=$dtEstado;
    $oOrden_Compra->dtMoneda=$dtMoneda;
    $GLOBALS['oOrden_Compra']=$oOrden_Compra;
    
    

}
function post_ajaxOrden_Compra_Mantenimiento_Eliminar() {
    require ROOT_PATH . 'models/orden_ingreso.php';
    require ROOT_PATH . 'models/orden_ingreso_detalle.php';
    $id=$_POST['id'];
    try {
        $oOrden_Compra = orden_ingreso::getByID($id);
        $oOrden_Compra->usuario_mod_id = $_SESSION['usuario_ID'];
        if ($oOrden_Compra == null) {
            throw new Exception('Parece que el registro ya fue eliminado.');
        }
        $dtOrden_compra_detalle=orden_ingreso_detalle::getGrid('orden_ingreso_ID='.$oOrden_Compra->ID,-1,-1);
        if(count($dtOrden_compra_detalle)>0){
            throw new Exception("No se puede eliminar la orden de compra, elimine los detalles.");
        }
        if ($oOrden_Compra->eliminar() == -1) {
            throw new Exception($oOrden_Compra->getMessage);
        }

        $resultado = 1;
        $mensaje = $oOrden_Compra->getMessage;
        $funcion = '';
    } catch (Exception $ex) {
        $resultado = -1;
        $mensaje = $ex->getMessage();
        $funcion = '';
    }

    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje, 'funcion' => $funcion);

    echo json_encode($retornar);
}
function post_ajaxOrden_Compra_Mantenimiento_Producto(){
    require ROOT_PATH . 'models/orden_ingreso.php';
    require ROOT_PATH . 'models/orden_ingreso_detalle.php';
    require ROOT_PATH . 'models/producto.php';
    require ROOT_PATH . 'models/estado.php';
     if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";
    require ROOT_PATH . 'controls/funcionController.php';
    $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
    $orden_compra_ID=$_POST['id'];
    $resultado='<div class="" >';
    $resultado.= '<table id="tabla-producto" class="table table-striped table-teal table-bordered"><thead><tr>';
    $resultado.='<th class="text-center">Nro</th>';
    $resultado.='<th class="text-center">Producto</th>';
    //$resultado.='<th class="thOrden" >Descripcion</th>';
    $resultado.='<th class="text-center" >Cantidad</th>';
    $resultado.='<th class="text-center" >Precio</th>';
    $resultado.='<th class="text-center" >Sub Total</th>';
    $resultado.='<th></th>';
             
    $resultado.='</tr>';
    $resultado.= '</thead>';
    $footer=6;
    $filtro="ocd.orden_ingreso_ID=".$orden_compra_ID;
    $resultado.= '<tbody>';
    $oOrden_Compra=orden_ingreso::getByID($orden_compra_ID);
    try {
        $orden="ocd.ID asc";
        //$cantidadMaxima = orden_ingreso_detalle::getCount($filtro);
        $dtOrden_Compra_Detalle = orden_ingreso_detalle::getGrid($filtro, -1, -1,$orden);
        $rows = orden_ingreso_detalle::getCount($filtro);
        $i=1;
        $igv=0;
        $subtotal=0;
        $total=0;
        foreach ($dtOrden_Compra_Detalle as $item) {
            
            $resultado.='<tr class="item-tr" >';
            $resultado.='<td class="text-center">'.$i.'</td>';
            $resultado.='<td class="tdLeft">' . FormatTextView($item['producto']) . '</td>';
            //$resultado.='<td class="tdLeft">' . FormatTextViewHtml($item['descripcion']) . '</td>';
            $resultado.='<td class="text-center">' . ($item['cantidad']) . '</td>';
            $resultado.='<td class="text-right">' . number_format($item['precio'],2,".",",") . '</td>';
            $resultado.='<td class="text-right">' . number_format($item['subtotal'],2,".",",") . '</td>';
            $botones=array();
            $boton='<a onclick="fncEditar(' . $item['ID'] . ');" class="btn-view"><img title="Editar" src="/include/img/boton/edit_14x14.png" />Editar</a>';
            array_push($botones,$boton);
            if($oOrden_Compra->estado_ID==55){
                 array_push($botones,'<a class="btn-view" onclick="modal.confirmacion(&#39;El proceso es irreversible, esta seguro de eliminar el registro.&#39;,&#39;Eliminar&#39;,fncEliminar,&#39;' . $item['ID'] . '&#39;);" title="Eliminar"><span class="glyphicon glyphicon-trash">Eliminar</a>');
            }
           
            $resultado.='<td class="text-center" >'.extraerOpcion($botones)."</td>";
            $resultado.='</tr>';
            $i=$i+1;
            $igv=$igv+$item['igv'];
            $subtotal=$subtotal+floatval($item['subtotal']);
        }
        $total=$igv+$subtotal;
        $vigv=$oOrden_Compra->vigv*100;
        
        //$oOrden_Compra->ID=$orden_compra_ID;
        $oOrden_Compra->subtotal=$subtotal;
        $oOrden_Compra->igv=$igv;
        $oOrden_Compra->total=$total;
        $oOrden_Compra->usuario_mod_id=$_SESSION['usuario_ID'];
        $oOrden_Compra->actualizar1();
        $mensaje=1;
        
    } catch (Exception $ex) {
        $resultado.='<tr ><td colspan="6">' . $ex->getMessage() . '</td></tr>';
        $mensaje=-1;
    }
    $resultado.= '</tbody>';
    $resultado.='</table>';
    $resultado.='</div>';
    
    $retornar = Array('resultado' => $resultado,'mensaje'=>$mensaje,'subtotal'=>number_format($subtotal,2,'.',','),'igv'=>number_format($igv,2,'.',','),'total'=>number_format($total,2,'.',','));
    echo json_encode($retornar);
}
function get_Orden_Compra_Mantenimiento_Editar_Producto($id){
    require ROOT_PATH . 'models/categoria.php';
    require ROOT_PATH . 'models/linea.php';
    require ROOT_PATH . 'models/producto.php';
    require ROOT_PATH . 'models/estado.php';
    require ROOT_PATH . 'models/orden_ingreso_detalle.php';
    require ROOT_PATH . 'models/orden_ingreso.php';
    require ROOT_PATH . 'models/moneda.php';
    require ROOT_PATH . 'models/inventario.php';
        global $returnView_float;
        $returnView_float=true; 
        
        $oOrden_compra_detalle=orden_ingreso_detalle::getByID($id);
        $oOrden_Compra=orden_ingreso::getByID($oOrden_compra_detalle->orden_ingreso_ID);
        $oProducto=producto::getByID($oOrden_compra_detalle->producto_ID);
        $oCategoria=categoria::getByID($oProducto->categoria_ID);
        $oLinea= linea::getByID($oCategoria->linea_ID);
        $oEstado=new estado();
       
        $dtCategoria=$oCategoria->getGrid("ca.linea_ID=".$oCategoria->linea_ID,-1,-1,"ca.nombre asc");
        $dtLinea=$oLinea->getGrid();
        
        $dtProducto=$oProducto->getGrid("pr.categoria_ID=".$oProducto->categoria_ID,-1,-1,"pr.nombre asc");
        
        $oOrden_compra_detalle->oMoneda=moneda::getByID($oOrden_Compra->moneda_ID);
//       $oOrden_compra_detalle->oProducto=producto::getByID($oOrden_compra_detalle->producto_ID);
        $oOrden_compra_detalle->oProducto=$oProducto;
        $oOrden_compra_detalle->vigv=$oOrden_Compra->vigv;
        $oOrden_compra_detalle->stock=inventario::getStock($oOrden_compra_detalle->producto_ID);
        $GLOBALS['dtCategoria']=$dtCategoria;
        $GLOBALS['categoria_ID']=$oCategoria->ID;
        $GLOBALS['dtLinea']=$dtLinea;
        $GLOBALS['linea_ID']=$oLinea->ID;
        $GLOBALS['dtProducto']=$dtProducto;
        $GLOBALS['oOrden_Compra']=$oOrden_Compra;
        $GLOBALS['oOrden_Compra_detalle']=$oOrden_compra_detalle;
       
       // $GLOBALS['mensaje'] ="";
    }

function post_Orden_Compra_Mantenimiento_Editar_Producto($id){
    require ROOT_PATH . 'models/categoria.php';
    require ROOT_PATH . 'models/linea.php';
    require ROOT_PATH . 'models/producto.php';
    require ROOT_PATH . 'models/estado.php';
    require ROOT_PATH . 'models/orden_ingreso_detalle.php';
    require ROOT_PATH . 'models/orden_ingreso.php';
    require ROOT_PATH . 'models/inventario.php';
    global $returnView_float;
    $returnView_float=true;

    $linea_ID=$_POST['selLinea'];
    $categoria_ID=$_POST['selCategoria'];
    $producto_ID=$_POST['selProducto'];
    $descripcion=$_POST['txtDescripcion'];
    $cantidad=$_POST['txtCantidad'];
    $precio=$_POST['txtPrecioUnitario'];
    $subtotal=$_POST['txtSubTotal'];
    $igv=$_POST['txtIgv'];
    $total=$_POST['txtTotal'];
   
    $oOrden_compra_detalle=orden_ingreso_detalle::getByID($id);
    try{
        $oOrden_compra_detalle->producto_ID=$producto_ID;
        $oOrden_compra_detalle->descripcion=$descripcion;
        $oOrden_compra_detalle->cantidad=$cantidad;
        $oOrden_compra_detalle->precio=$precio;
        $oOrden_compra_detalle->subtotal=$subtotal;
        $oOrden_compra_detalle->igv=$igv;
        $oOrden_compra_detalle->total=$total;
        $oOrden_compra_detalle->usuario_mod_id=$_SESSION['usuario_ID'];
        $oOrden_compra_detalle->actualizar1();
        $resultado=1;
        $mensaje=$oOrden_compra_detalle->getMessage;
    } catch (Exception $ex) {
        $resultado=-1;
        log_error(__FILE__,"ingreso/post_Orden_Compra_Mantenimiento_Editar_Producto",$ex->getMessage());
        $mensaje= utf8_encode(mensaje_error);
    }
    $dtLinea=linea::getGrid();
    if($linea_ID!=0){
        $dtCategoria=categoria::getGrid('ca.linea_ID='.$linea_ID);
    }else{
        $dtCategoria=categoria::getGrid();

    }
    if($categoria_ID!=0){
        $dtProducto=producto::getGrid('pr.categoria_ID='.$categoria_ID);
    }else{
        $dtProducto=producto::getGrid();

    }
    $oOrden_compra_detalle->stock=inventario::getStock($oOrden_compra_detalle->producto_ID);
    $oOrden_compra_detalle->oProducto=producto::getByID($oOrden_compra_detalle->producto_ID);
    $GLOBALS['dtLinea']=$dtLinea;
    $GLOBALS['dtCategoria']=$dtCategoria;
    $GLOBALS['linea_ID']=$linea_ID;
    $GLOBALS['categoria_ID']=$categoria_ID;
    $GLOBALS['dtProducto']=$dtProducto;
    $GLOBALS['oOrden_Compra_detalle']=$oOrden_compra_detalle;
    $GLOBALS['resultado']=$resultado;
    $GLOBALS['mensaje']=$mensaje;

}
function post_ajaxOrden_Compra_Mantenimiento_Producto_Eliminar()
    {
        require ROOT_PATH . 'models/orden_ingreso_detalle.php';
        require ROOT_PATH . 'models/orden_ingreso.php';

        try{
            $id=$_POST['id'];
            $oOrden_Compra_Detalle=orden_ingreso_detalle::getByID($id);
            $oOrden_Compra_Detalle->usuario_mod_id=$_SESSION['usuario_ID'];
            
            if($oOrden_Compra_Detalle==null){
                throw new Exception('Parece que el registro ya fue eliminado.');
            }
            $oOrden_Compra=orden_ingreso::getByID($oOrden_Compra_Detalle->orden_ingreso_ID);
            if($oOrden_Compra==null){
                throw new Exception('La orden de compra ha sido eliminado por otro usuario.');
            }
            $varEliminar=$oOrden_Compra_Detalle->eliminar();
            if($varEliminar==-1){
                throw new Exception($oOrden_Compra_Detalle->message);
            } 
            $funcion = '';
            $resultado=1;
            $mensaje = 'Se eliminó corectamente.';
            
        } catch (Exception $ex) {
            $resultado=-1;
            $mensaje=$ex->getMessage();
            $funcion='';
        }
     $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje, 'funcion' => $funcion);

    echo json_encode($retornar);
    }
function get_Orden_Compra_PDF($id){
    require ('./formatos_pdf/orden_compra.php');
    require ROOT_PATH.'models/orden_ingreso.php';
    require ROOT_PATH.'models/moneda.php';
    require ROOT_PATH.'models/orden_ingreso_detalle.php';
     if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";
    require ROOT_PATH . 'models/proveedor.php';
    global $returnView_float;
    $returnView_float=true;
    $oOrden_Compra=orden_ingreso::getByID($id);
    $oMoneda=moneda::getByID($oOrden_Compra->moneda_ID);
    $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
    $oProveedor=proveedor::getByID($oOrden_Compra->proveedor_ID);
    if($oProveedor==null){
        $oProveedor=new proveedor();
    }
    $dtOrden_Compra_Detalle=orden_ingreso_detalle::getGrid('ocd.orden_ingreso_ID='.$id);
    $pdf= new PDF('P','mm','A4');
    $pdf->oDatos_Generales=$oDatos_Generales;
    $pdf->oOrden_Compra=$oOrden_Compra;
    $pdf->oProveedor=$oProveedor;
    $header=array('Columna 1','Columna 2','Columna 3','Columna 4');
    $pdf->AddPage();
    
    //Creamos el encabezado del detalle
    
    $pdf->SetXY(10,90);
    $pdf->SetFont('Arial','B',10);
    $pdf->SetTextColor(255,255,255);
    $pdf->SetFillColor(117,179,114);
    $pdf->Cell(20,7,utf8_decode('COD'),1,0,'C',true);
    $pdf->Cell(100,7,utf8_decode('DESCRIPCIÓN'),1,0,'C',true);
    $pdf->Cell(15,7,utf8_decode('CANT'),1,0,'C',true);
    $pdf->Cell(25,7,utf8_decode('P/U'),1,0,'C',true);
    $pdf->Cell(30,7,utf8_decode('TOTAL'),1,0,'C',true);
    $pdf->Ln();
    // cuerpo del detalle
    $pdf->Cell(20,120,'',1,0,'C');
    $pdf->Cell(100,120,'',1,0,'C');
    $pdf->Cell(15,120,'',1,0,'C');
    $pdf->Cell(25,120,'',1,0,'C');
    $pdf->Cell(30,120,'',1,0,'C');
    $pdf->Ln();
    // Costos totales
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','B',8);
    $pdf->SetX(145);
    $pdf->Cell(25,7,'SUB TOTAL',0,0,'L');
    $pdf->Cell(30,7,$oMoneda->simbolo.' '.number_format($oOrden_Compra->subtotal,2,".",','),1,0,'R');
    $pdf->Ln();
    $pdf->SetX(145);
    $pdf->Cell(25,7,'IGV '.($oOrden_Compra->vigv*100).'%',0,0,'L');
    $pdf->Cell(30,7,$oMoneda->simbolo.' '.number_format($oOrden_Compra->igv,2,".",','),1,0,'R');
    $pdf->Ln();
    $pdf->SetX(145);
    $pdf->Cell(25,7,'TOTAL',0,0,'L');
    $pdf->Cell(30,7,$oMoneda->simbolo.' '.number_format($oOrden_Compra->total,2,".",','),1,0,'R');
    
    //Comentario o instrucctivo
    $pdf->SetXY(10,220);
    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(255,255,255);
    $pdf->SetFillColor(117,179,114);
    $pdf->Cell(120,5,'Comentarios o instrucciones especiales ',1,2,'C',true);
    $pdf->SetTextColor(0);
    $pdf->SetFont('Arial','',8);
    $pdf->Rect(10,225,120,20);
    $pdf->MultiCell(120,5, utf8_decode($oOrden_Compra->comentario),0,'J');
    $pdf->Ln(20);
    //Firmas
    $pdf->Line(75,265,135,265);
    $pdf->SetTextColor(0);
    $pdf->SetXY(75,265);
    $pdf->Cell(60,5,'GERENTE GENERAL',0,2,'C',false);
    $pdf->Cell(60,5,'Juan Gonzales ',0,2,'C',false);
    //Detalle de compra_detalle
    
    $pdf->SetFont('Arial','',9);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetXY(10,98);
    
    $pdf->SetWidths(array(20,100,15,25,30));
    $pdf->SetAligns(array('C','L','C','R','R'));
    $alto=0;
    foreach ($dtOrden_Compra_Detalle as $fila){
        $pdf->SetFont('Arial','',9);
        if($alto>110){
            $pdf->AddPage();
            $pdf->SetXY(10,90);
            $pdf->SetFont('Arial','B',10);
            $pdf->SetTextColor(255,255,255);
            $pdf->SetFillColor(117,179,114);
            $pdf->Cell(20,7,utf8_decode('COD'),1,0,'C',true);
            $pdf->Cell(100,7,utf8_decode('DESCRIPCIÓN'),1,0,'C',true);
            $pdf->Cell(15,7,utf8_decode('CANT'),1,0,'C',true);
            $pdf->Cell(25,7,utf8_decode('P/U'),1,0,'C',true);
            $pdf->Cell(30,7,utf8_decode('TOTAL'),1,0,'C',true);
            $pdf->Ln();
            // cuerpo del detalle
            $pdf->Cell(20,120,'',1,0,'C');
            $pdf->Cell(100,120,'',1,0,'C');
            $pdf->Cell(15,120,'',1,0,'C');
            $pdf->Cell(25,120,'',1,0,'C');
            $pdf->Cell(30,120,'',1,0,'C');
            $pdf->Ln();
        }
        $alto=$alto+$pdf->Row(array(sprintf("%'.05d",$fila['ID']), utf8_decode($fila['producto']), $fila['cantidad'], number_format($fila['precio'],2,".",","),number_format($fila['subtotal'],2,".",",")),5);
    }
    
    
    $pdf->Output('orden_compra_Nro'.sprintf("%'.07d",$oOrden_Compra->numero_orden).'.pdf','D');
    
   // $GLOBALS['documento']=$pdf->Output("new.pdf",'S');
    
    $GLOBALS['oOrden_Compra']=$oOrden_Compra;
}

function post_ajaxComprar_Orden(){
    require ROOT_PATH.'models/producto.php';
    require ROOT_PATH.'models/orden_ingreso.php';
    require ROOT_PATH.'models/orden_ingreso_detalle.php';
    require ROOT_PATH.'models/ingreso.php';
    require ROOT_PATH.'models/ingreso_detalle.php';
    require ROOT_PATH.'models/inventario.php';
    $orden_compra_ID=$_POST['id'];
    $compra_ID=0;
    try{
        $oOrden_Compra=orden_ingreso::getByID($orden_compra_ID);
        $oCompra=new ingreso();
        $oCompra->tipo_movimiento_ID=1;//Tipo movimiento compra
        $oCompra->tipo_comprobante_ID=1;
        $oCompra->serie='';
        $oCompra->numero=0;
        $oCompra->proveedor_ID=$oOrden_Compra->proveedor_ID;
        $oCompra->fecha_emision=date('d/m/Y');
        $oCompra->tipo_cambio=$oOrden_Compra->tipo_cambio;
        $oCompra->vigv=$oOrden_Compra->vigv;
        $oCompra->con_igv=1;
        $oCompra->estado_ID=9;//Estado pendiente
        $oCompra->forma_pago_ID=1;
        $oCompra->descuento=0;
        $oCompra->recargo=0;
        $oCompra->subtotal=$oOrden_Compra->subtotal;
        $oCompra->igv=$oOrden_Compra->igv;
        $oCompra->total=$oOrden_Compra->total;
        $oCompra->usuario_id=$_SESSION['usuario_ID'];
        $oCompra->numero_guia='';
        $oCompra->moneda_ID=$oOrden_Compra->moneda_ID;
        $oCompra->orden_ingreso_ID=$oOrden_Compra->ID;
        $oCompra->periodo=date('Y');
        $oCompra->descripcion=$oOrden_Compra->comentario;
        $oCompra->monto_pendiente=$oOrden_Compra->total;
        $oCompra->insertar();
        $compra_ID=$oCompra->ID;
        //Actualizamos el estado de la orden de compra
        $oOrden_Compra->estado_ID=59;
        $oOrden_Compra->usuario_mod_id=$_SESSION['usuario_ID'];
        $oOrden_Compra->actualizar(); 
        
        //Agregamos los detalles
        $dtOrden_Compra_Detalle=orden_ingreso_detalle::getGrid("ocd.orden_ingreso_ID=".$orden_compra_ID);
        foreach($dtOrden_Compra_Detalle as $item){
            $oCompra_Detalle=new ingreso_detalle();
            $oCompra_Detalle->ingreso_ID=$oCompra->ID;
            $oCompra_Detalle->producto_ID=$item['producto_ID'];
            $oCompra_Detalle->descripcion=  FormatTextSave($item['descripcion']);
            $oCompra_Detalle->cantidad=$item['cantidad'];
            $oCompra_Detalle->precio=$item['precio'];
            $oCompra_Detalle->subtotal=$item['subtotal'];
            $oCompra_Detalle->igv=$item['igv'];
            $oCompra_Detalle->total=$item['total'];
            $oCompra_Detalle->usuario_id=$_SESSION['usuario_ID'];
            //Enviamos todos los detalles para stock
            $oCompra_Detalle->destino=1;
            $oCompra_Detalle->insertar();
            //registramos en la tabla inventario
            for ($i=0;$i<$item['cantidad'];$i++){
                $oInventario=new inventario();
                $oInventario->ingreso_detalle_ID=$oCompra_Detalle->ID;
                $oInventario->descripcion=  FormatTextSave($oCompra_Detalle->descripcion);
                $oInventario->producto_ID=$oCompra_Detalle->producto_ID;
                //se pone estado stock
                $oInventario->estado_ID=48;
                $oInventario->usuario_id=$_SESSION['usuario_ID'];
                $oInventario->insertar();
            }
        }
        $resultado=1;
        $mensaje="La orden de compra de generó correctamente. ";
        //$mensaje=$oCompra->message;
    }catch(Exception $ex){
        $mensaje=$ex->getMessage();
        $resultado=-1;
    }
   
    $retornar=Array('resultado'=>$resultado,'compra_ID'=>$compra_ID,'mensaje'=>$mensaje);
    echo json_encode($retornar);
}
function post_ajaxCargarCompra(){
    require ROOT_PATH.'models/producto.php';
    require ROOT_PATH.'models/orden_ingreso.php';
    require ROOT_PATH.'models/ingreso.php';
    require ROOT_PATH.'models/proveedor.php';
    $compra_ID=$_POST['id'];
    $numero=0;
    $numero_orden=0;
    $proveedor_ID=0;
    $proveedor='';
    $estado_ID=0;
    $igv=0;
    $moneda_ID=0;
    $tipo_cambio=0;
    
    try{
        $oCompra=ingreso::getByID($compra_ID);
        $numero=sprintf("%'.07d",$compra_ID);
        $oOrden_Compra=orden_ingreso::getByID($oCompra->orden_ingreso_ID);
        $numero_orden=  sprintf("%'.07d",$oOrden_Compra->numero_orden);
        $proveedor_ID=$oCompra->proveedor_ID;
        $oProveedor=proveedor::getByID($proveedor_ID);
        $proveedor=$oProveedor->ruc.'-'.FormatTextView($oProveedor->razon_social);
        $estado_ID=$oCompra->estado_ID;
        $vigv=$oCompra->vigv*100;
        $moneda_ID=$oCompra->moneda_ID;
        $tipo_cambio=$oCompra->tipo_cambio;
        $mensaje='';
        $resultado=1;
    }catch(Exception $ex){
        $mensaje=$ex->getMessage();
        $resultado=-1;
    }
   
    $retornar=Array('compra_ID'=>$compra_ID,'numero'=>$numero,'numero_orden'=>$numero_orden,'proveedor_ID'=>$proveedor_ID,'proveedor'=>$proveedor,'estado_ID'=>$estado_ID,'vigv'=>$vigv,'moneda_ID'=>$moneda_ID,
        'tipo_cambio'=>$tipo_cambio,'resultado'=>$resultado,'mensaje'=>$mensaje);
    echo json_encode($retornar);
}




//--------------------------------------------- inicio de anulacion de comprobantes de compras-----------------------------------------------------------
//-------------------------------------------------------------------------------------------------------------------------------------------------------





function get_Anulacion_Comprobante_Mantenimiento() {
    require ROOT_PATH . 'models/moneda.php';
    require ROOT_PATH . 'models/proveedor.php';
    require ROOT_PATH . 'models/ingreso.php';
    require ROOT_PATH . 'models/orden_ingreso.php';
    require ROOT_PATH . 'models/inventario.php';
    global $returnView;
    $returnView = true;
    $GLOBALS['dtMoneda']=moneda::getGrid('',-1,-1,'ID desc');
    $dtCompra=ingreso::getGrid('',-1,-1,'co.fecha_emision desc');
    $proveedor_IDs='';
    $a=0;
    $array_periodo=array();
    $periodo='';
    
    foreach($dtCompra as $item){
       
//        $oOrden_Compra=orden_ingreso::getByID($item['salida_ID']);
        if($a==0){
//            $proveedor_IDs=$oOrden_Compra->cliente_ID;
            $proveedor_IDs=$item['proveedor_ID'];
            
        }else {
//            $proveedor_IDs.=','.$oOrden_Compra->cliente_ID;
            $proveedor_IDs.=','.$item['proveedor_ID'];
        }
         if($periodo!=substr($item['fecha_emision'],0,4)){
             array_push($array_periodo,substr($item['fecha_emision'],0,4));
         }
        $periodo=substr($item['fecha_emision'],0,4);
       $a++;
    }
    $GLOBALS['dtProveedor']=proveedor::getGrid("prv.empresa_ID=".$_SESSION['empresa_ID']." and prv.ID in (".$proveedor_IDs.")",-1,-1,"prv.razon_social asc");
    $GLOBALS['dtPeriodo']=$array_periodo;
}
function post_ajaxAnulacion_Comprobante_Mantenimiento() {
    require ROOT_PATH . 'models/orden_ingreso.php';
    require ROOT_PATH . 'models/moneda.php';
    require ROOT_PATH . 'models/estado.php';
    require ROOT_PATH . 'models/ingreso.php';
    require ROOT_PATH . 'models/inventario.php';
    require ROOT_PATH . 'controls/funcionController.php';
//    require ROOT_PATH . 'models/guia_venta.php';
//    $estado_ID=$_POST['selEstado'];
    $moneda_ID=$_POST['selMoneda'];
    $opcion_tipo=$_POST['rbOpcion'];
    $fecha_inicio=$_POST['txtFechaInicio'];
    $fecha_fin=$_POST['txtFechaFin'];
    $serie=trim($_POST['txtSerie']);
    $numero=$_POST['txtNumero'];
    $proveedor_ID=$_POST['selProveedor'];
    $periodo=$_POST['selPeriodo'];
    $paginaActual = $_POST['num_page'] == 0 ? 1 : $_POST['num_page'];
    $cantidadMostrar = $_POST['txtMostrar'] == '' ? 30 : $_POST['txtMostrar'];
    $txtOrden = $_POST['txtOrden'];
    $orden_tipo = 'DESC';
    $orden_class = 'imgOrden-desc';
    if (isset($_POST['chkOrdenASC'])) {
        $orden_class = 'imgOrden-asc';
        $orden_tipo = 'ASC';
    }
    switch ($txtOrden) {
        case 1:
            $orden = 'co.codigo ' . $orden_tipo;
            break;
        case 2:
            $orden = 'co.serie ' . $orden_tipo;
            break;
        case 3:
            $orden = 'co.numero ' . $orden_tipo;
            break;
        case 4:
            $orden = 'co.fecha_emision ' . $orden_tipo;
            break;
        case 5:
            $orden = 'co.fecha_vencimiento ' . $orden_tipo;
            break;
        case 6:
            $orden = 'prv.razon_social ' . $orden_tipo;
            break;
        case 7:
            $orden = 'co.moneda_ID ' . $orden_tipo;
            break;
        case 8:
            $orden = 'co.total ' . $orden_tipo;
            break;
        case 9:
            $orden = 'co.monto_pendiente ' . $orden_tipo;
            break;
        case 10:
            $orden = 'es.nombre ' . $orden_tipo;
            break;
        default:
            $orden = 'co.fecha_emision ' . $orden_tipo;
            break;
    }
    $filtro="co.estado_ID = 11 and co.total>0";
    if($opcion_tipo=="buscar"){
        if($periodo!=0){
            $filtro.=" and co.periodo=".$periodo;
        }
        if(ltrim($serie,0)!=''){
            $filtro.=" and co.serie='".$serie."'";
        }
        if(ltrim($numero,0)!=""){
        $filtro.=" and co.numero=".ltrim($numero,0);
        }
    }else{
        $todos=(isset($_POST['ckTodos']))? 1:0;
        if($proveedor_ID!=0){
            $filtro.=" and co.proveedor_ID=".$proveedor_ID;
        }
        if($todos==0){
            if($fecha_inicio!="" &&$fecha_fin!="" ){
        
                $filtro.=" and  co.fecha_emision between '".$fecha_inicio."' and '". $fecha_fin."'";
            }
        }
        
        if($moneda_ID!=0){
       
         $filtro.=" and co.moneda_ID=".$moneda_ID;
        }
    }
   
    
//    if($numero!=""){
//        $filtro="co.numero=".$numero;
//    }

    //---------------------------------------					 
    $resultado = '<table id="websendeos" class="grid table table-hover table-bordered"><thead><tr>';
    $resultado.='<th>N°</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(1);">Cod. Compra' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(2);">Serie' . (($txtOrden == 2 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(3);">Numero' . (($txtOrden == 3 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(4);">Fecha emisión' .(($txtOrden == 4 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(5);">Fecha vencimiento' . (($txtOrden == 5 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(6);">Proveedor' . (($txtOrden == 6 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(7);">Moneda' . (($txtOrden == 7 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(8);">Monto total' . (($txtOrden == 8 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(9);">Monto Pendiente' . (($txtOrden == 9 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
//    $resultado.='<th style="width:100px;" class="thOrden" onclick="fncOrden(8);">Pago' . (($txtOrden == 8 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(10);">Estado' . (($txtOrden == 10 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th></th>';
    $resultado.='</tr></thead>';
    $resultado.='<tbody>';
    $colspanFooter = 12;
    try {
        $cantidadMaxima = count(ingreso::getGrid($filtro,-1,-1,'co.ID asc'));
        $dtCompra = ingreso::getGrid($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
        $rows = count($dtCompra);
        
            
        $i=($paginaActual-1)*$cantidadMostrar+1;
        foreach ($dtCompra as $item) {
            $oMoneda=moneda::getByID($item['moneda_ID']);
            
  
            $fecha_emision = date('d/m/Y',strtotime($item['fecha_emision']));
            $fecha_vencimiento=date('d/m/Y',strtotime($item['fecha_vencimiento']));
            $resultado.='<tr class="tr-item">';
            $resultado.='<td class="text-center">' .$i . '</td>';
            $resultado.='<td class="text-center">' .sprintf("%'.05d",$item['codigo']) . '</td>';
            $resultado.='<td class="text-center">' .sprintf("%'.03d",$item['serie']) . '</td>';
            $resultado.='<td class="text-center">' . $item['numero'] . '</td>';
            $resultado.='<td class="text-center">' .$fecha_emision . '</td>';
            $resultado.='<td class="text-center">' . $fecha_vencimiento . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextViewHtml($item['proveedor']) . '</td>';
            $resultado.='<td class="text-right">' . FormatTextViewHtml($item['simbolo']) . '</td>';
            $resultado.='<td class="text-right">' . $item['total'] . '</td>';
            $resultado.='<td class="text-right">' . $item['monto_pendiente'] . '</td>';

            $resultado.='<td class="tdLeft">' . FormatTextViewHtml($item['estado']). '</td>';
           $i++;
            $dtInventario=inventario::getGridComprobarVenta('co.ID='.$item['ID']);  
            $botones=array();
            if(count($dtInventario)>0){
                $editar='<a onclick="fncVendido(' . $item['ID'] . ');" title="Vendido"><span class="glyphicon glyphicon-off" style="color:red;"></span>&nbsp;Anular</a>';
                array_push($botones,$editar);

            }else{
                $editar='<a onclick="fncAnular(' . $item['ID'] . ');" title="No Vendido"><span class="glyphicon glyphicon-off"></span>&nbsp;Anular</a>';
                array_push($botones,$editar);  
            }
            
            $resultado.='<td class="btnAction" >'.extraerOpcion($botones)."</td>";
            $resultado.='</tr>';
        }
        $cantidadPaginas = '';
        $resultado.=paginacion($cantidadMaxima,$cantidadMostrar,$colspanFooter,$paginaActual);
        $resultado.='<tr class="tr-footer"><th colspan=' . $colspanFooter . '>' . $rows . ' de ' . $cantidadMaxima . ' Registros</th></tr>';
        } catch (Exception $ex) {
        $resultado.='<tr ><td colspan=' . $colspanFooter . '>' . $ex->getMessage() . '</td></tr>';
    }
    $resultado.='</tbody>';
    $resultado.='</table>';

    $mensaje = '';
    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
    //$retorn="<h1>Hola</h1>";

    echo json_encode($retornar);
}
function get_Anulacion_Comprobante_Mantenimiento_Registro($id){
    require ROOT_PATH.'models/orden_ingreso.php';
    require ROOT_PATH.'models/ingreso.php';
    require ROOT_PATH.'models/operador.php';
    require ROOT_PATH.'models/moneda.php';
    require ROOT_PATH.'models/motivo_anulacion.php';
    require ROOT_PATH.'models/ingreso_detalle.php';
    require ROOT_PATH.'models/inventario.php';
    require ROOT_PATH.'models/ingreso_pagos.php';
    global  $returnView_float;
    $returnView_float=true;
    $oCompra=ingreso::getByID($id);
    $oMoneda=moneda::getByID($oCompra->moneda_ID);
    $oCompra->moneda= $oMoneda->descripcion;
    $dtOperador=operador::getGrid('op.cargo_ID in (1,3)',-1,-1);
    $oCompra->dtOperador=$dtOperador;
    $dtMotivo_Anulacion=motivo_anulacion::getGrid('tabla="ingreso"',-1,-1,'nombre asc');
    $oCompra->dtMotivo_Anulacion=$dtMotivo_Anulacion;
    if($oCompra->estado_ID==11){
        $oCompra->fecha_anulacion=date('d/m/Y');
        $oCompra->motivo_anulacion_ID=0;
        $oCompra->operador_ID_anulacion=0;
    }

    $GLOBALS['oCompra']=$oCompra;
//    $GLOBALS['mensaje']='';
}
function post_Anulacion_Comprobante_Mantenimiento_Registro($id){
    require ROOT_PATH.'models/inventario.php';
    require ROOT_PATH.'models/orden_ingreso.php';
    require ROOT_PATH.'models/ingreso.php';
    require ROOT_PATH.'models/ingreso_detalle.php';
    require ROOT_PATH.'models/operador.php';
    require ROOT_PATH.'models/moneda.php';
    require ROOT_PATH.'models/motivo_anulacion.php';
    require ROOT_PATH.'models/ingreso_pagos.php';
    global  $returnView_float;
    $returnView_float=true;

    $oCompra=ingreso::getByID($id);
    $fecha_anulacion=$_POST['txtFecha_Anulacion'];
    $motivo_anulacion_ID=$_POST['selMotivo_Anulacion_ID'];
    $operador_ID_anulacion=$_POST['seloperador_ID_anulacion'];
//    $mensaje="";
   
    try {
        $oCompra->fecha_anulacion=$fecha_anulacion;
        $oCompra->motivo_anulacion_ID=$motivo_anulacion_ID;
        $oCompra->operador_ID_anulacion=$operador_ID_anulacion;
        $oCompra->actualizarAnulacion();
//        $mensaje=$oCompra->message;
        
        $dtCompra_Pagos = ingreso_pagos::getGrid('ingreso_ID='.$oCompra->ID);
            if(count($dtCompra_Pagos)>0){
            foreach($dtCompra_Pagos as $value){

                $oCompra_Pagos=ingreso_pagos::getByID($value['ID']);           
                $oCompra_Pagos->usuario_mod_id=$_SESSION['usuario_ID'];
                $oCompra_Pagos->eliminar();
            
            }

        }
        
           $GLOBALS['resultado']=1;
           $GLOBALS['mensaje']=$oCompra->message;
//        $resultado=1;
    }catch(Exception $ex){
        $GLOBALS['resultado'] = -1;
        $GLOBALS['mensaje'] = $ex->getMessage();
        
    }

   
    $oMoneda=moneda::getByID($oCompra->moneda_ID);
    $oCompra->moneda=  FormatTextViewHtml($oMoneda->descripcion);
    $dtOperador=operador::getGrid('op.cargo_ID in (1,3)',-1,-1);
    $oCompra->dtOperador=$dtOperador;
    $dtMotivo_Anulacion=motivo_anulacion::getGrid('tabla="ingreso"',-1,-1,'nombre asc');
    $oCompra->dtMotivo_Anulacion=$dtMotivo_Anulacion;

    $GLOBALS['oFactura_Venta']=$oCompra;
//    $GLOBALS['resultado']=$resultado;
//    $GLOBALS['mensaje']=$mensaje;
}