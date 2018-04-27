<?php
/*Vista de proveedores*/

    function get_Index($id){
        global $returnView;
        $returnView=true;
    }
    
    function get_Cotizacion_Mantenimiento_Nuevo(){
        require ROOT_PATH.'models/cotizacion.php';
        require ROOT_PATH.'models/moneda.php';
        require ROOT_PATH.'models/estado.php';
        require ROOT_PATH.'models/cliente.php';
        require ROOT_PATH.'models/operador.php';
        require ROOT_PATH.'models/datos_generales.php';
        require ROOT_PATH.'models/forma_pago.php';
        require ROOT_PATH.'models/credito.php';
        require ROOT_PATH.'models/numero_cuenta.php';
        global  $returnView_float;
        $returnView_float=true;
	$oCliente=new cliente();
        $oOperador=new operador();
        $oCotizacion=new cotizacion;
        $oCotizacion->moneda_ID=2;
        $oCotizacion->plazo_entrega=2;
        $oCotizacion->validez_oferta="7";
        $oCotizacion->garantia=FormatTextSave("1 año");
        $oCotizacion->estado_ID=1;
        $oDatos_Generales=datos_generales::getByID(1);
        $dtForma_Pago=forma_pago::getGrid();
        $dtCredito=credito::getGrid('id<>0');
        $dtEstado=estado::getGrid('est.ID in (1,2)',-1,-1,'orden asc');
        $oCotizacion->observacion=$oDatos_Generales->observacion;
        $oCotizacion->tipo_cambio=$oDatos_Generales->tipo_cambio;
        $oCotizacion->ID=0;
        $GLOBALS['oCliente']=$oCliente;
        $GLOBALS['oCotizacion']=$oCotizacion;
        $GLOBALS['dtCredito']=$dtCredito;
        $GLOBALS['oOperador']=$oOperador;
        $GLOBALS['oDatos_Generales']=$oDatos_Generales;
        $GLOBALS['dtForma_Pago']=$dtForma_Pago;
        $GLOBALS['dtEstado']=$dtEstado;
       
        $GLOBALS['dtNumero_Cuenta']=mostrarNumeroCuentas(1,2,null,null);
        $GLOBALS['dtMoneda']=moneda::getGrid('',-1,-1,'ID desc');
        $GLOBALS['mensaje']='';
    }
    function post_Cotizacion_Mantenimiento_Nuevo(){
        require ROOT_PATH.'models/cotizacion.php';
        require ROOT_PATH.'models/moneda.php';
        require ROOT_PATH.'models/estado.php';
        require ROOT_PATH.'models/cliente.php';
        require ROOT_PATH.'models/representantecliente.php';
        require ROOT_PATH.'models/operador.php';
        require ROOT_PATH.'models/datos_generales.php';
        require ROOT_PATH.'models/forma_pago.php';
        require ROOT_PATH.'models/credito.php';
        require ROOT_PATH.'models/numero_cuenta.php';
        require ROOT_PATH.'models/cotizacion_numero_cuenta.php';
            global  $returnView_float;
            $returnView_float=true;

            $cotizacion_ID=$_POST['txtCotizacion_ID'];
            $cliente_ID=$_POST['txtCliente_ID'];
            $representante_cliente_ID=$_POST['selRepresentante'];
            if($representante_cliente_ID=="--"){
              $representante_cliente_ID=0;  
            }
            $operador_ID=$_POST['txtOperador_ID'];
            if($operador_ID==""){
              $operador_ID='-1';  
            }
            
            $periodo=date("Y");
            $moneda_ID=$_POST['cboMoneda'];
            $fecha=$_POST['txtFecha'];
            $forma_pago_ID=$_POST['selForma_Pago'];
            $tiempo_credito=$_POST['selTiempo_Credito'];
            $numero_cuenta="";
            $cuenta_interbancaria="";
            $banco=  "";
            $numero_cuenta1="";
            $cuenta_interbancaria1="";
            $banco1= "";
            $tardanza=$_POST['txtTiempo_Avance'];
            $plazo_entrega=$_POST['txtPlazo_Entrega'];
            //$estado_ID=1;
            $tipo_cambio=$_POST['txtTipo_Cambio'];
            $lugar_entrega=FormatTextSave($_POST['txtLugar_Entrega']);
            $validez_oferta=$_POST['txtValidez_Oferta'];
            $garantia=FormatTextSave($_POST['txtGarantia']);
            $observacion=FormatTextSave($_POST['txtObservacion']);
            $estado_ID=$_POST['selEstado'];

            try{
                    if($cotizacion_ID==0){
                        $oCotizacion=new cotizacion;
                    }else {
                        $oCotizacion=cotizacion::getByID($cotizacion_ID);
                    }
                    
                    $oCotizacion->cliente_ID=$cliente_ID;
                    $oCotizacion->representante_cliente_ID=$representante_cliente_ID;
                    $oCotizacion->operador_ID=$operador_ID;
                    $oCotizacion->periodo=$periodo;
                    $oCotizacion->moneda_ID=$moneda_ID;
                    $oCotizacion->fecha=$fecha;
                    $oCotizacion->forma_pago_ID=$forma_pago_ID;
                    $oCotizacion->tiempo_credito=$tiempo_credito;
                    $oCotizacion->numero_cuenta=$numero_cuenta;
                    $oCotizacion->cuenta_interbancaria=$cuenta_interbancaria;
                    $oCotizacion->banco=$banco;
                    $oCotizacion->numero_cuenta1=$numero_cuenta1;
                    $oCotizacion->cuenta_interbancaria1=$cuenta_interbancaria1;
                    $oCotizacion->banco1=$banco1;
                    $oCotizacion->tardanza=$tardanza;
                    $oCotizacion->plazo_entrega=$plazo_entrega;
                    $oCotizacion->estado_ID=$estado_ID;
                    $oCotizacion->tipo_cambio=$tipo_cambio;
                    $oCotizacion->lugar_entrega=$lugar_entrega;
                    $oCotizacion->validez_oferta=$validez_oferta;
                    $oCotizacion->garantia=$garantia;
                    $oCotizacion->observacion=$observacion;
                    
                    $oDatos_Generales=datos_generales::getByID(1);
                                       
                    
                         
                    $numero_concatenado="";
                    if($cotizacion_ID==0){
                        $oCotizacion->usuario_id=$_SESSION['usuario_ID'];
                        $oCotizacion->igv=$oDatos_Generales->vigv;
                        $oCotizacion->vigv_soles=0;
                        $oCotizacion->vigv_dolares=0;
                        $oCotizacion->precio_venta_neto_soles=0;
                        $oCotizacion->precio_venta_total_soles=0;
                        $oCotizacion->precio_venta_neto_dolares=0;
                        $oCotizacion->precio_venta_total_dolares=0;
                        $numero=cotizacion::getNumero();
                        $oCotizacion->numero=$numero;
                        $numero_ceros=sprintf("%'.07d", $numero);
                        $numero_concatenado=$numero_ceros.'-'.$periodo;
                        $oCotizacion->numero_concatenado=$numero_concatenado;
                        $oCotizacion->insertar();
                        $cotizacion_ID=$oCotizacion->ID;
                        $mensaje=$oCotizacion->message;
                        $resultado=1;
                    } else {
                        $oCotizacion->usuario_mod_id=$_SESSION['usuario_ID'];
                        $oCotizacion->actualizar();
                        $oCotizacion->getByID($cotizacion_ID);
                     
                        $mensaje=$oCotizacion->message;
                        $resultado=1;
                    }
                    //insertamos los numero de cuentas
                    //limpiamos si existen registros
                    $dtCotizacion_Numero_Cuenta=cotizacion_numero_cuenta::getGrid('cotizacion_ID='.$oCotizacion->ID);
                    if(count($dtCotizacion_Numero_Cuenta)>0){
                        foreach($dtCotizacion_Numero_Cuenta as $item){
                        $oCotizacion_Numero_Cuenta=cotizacion_numero_cuenta::getByID($item['ID']);
                        $oCotizacion_Numero_Cuenta->usuario_mod_id=$_SESSION['usuario_ID'];
                        $oCotizacion_Numero_Cuenta->eliminar();
                        }
                    }
                    //ingresamos los valores
                    $dtNumero_Cuenta=numero_cuenta::getGrid('moneda_ID='.$oCotizacion->moneda_ID);
                    
                    foreach($dtNumero_Cuenta as $value){
                        if(isset($_POST['cknumero_cuenta'.$value['ID']])){
                            $numero_cuenta_ID=$_POST['cknumero_cuenta'.$value['ID']];
                            $oCotizacion_Numero_Cuenta=new cotizacion_numero_cuenta();
                            $oCotizacion_Numero_Cuenta->cotizacion_ID=$oCotizacion->ID;
                            $oCotizacion_Numero_Cuenta->numero_cuenta_ID=$numero_cuenta_ID;
                            $oCotizacion_Numero_Cuenta->usuario_id=$_SESSION['usuario_ID'];
                            $oCotizacion_Numero_Cuenta->insertar();
                           // $checked="checked";
                        }
                    }
                        
                    
            }catch(Exception $ex){
                    $resultado=-1;
                    $mensaje=$ex->getMessage();
            }
            $oCliente=cliente::getByID($cliente_ID);
            if($operador_ID=='-1'){
                $oOperador=new operador();
                $oOperador->nombres="Vendedor no";
                $oOperador->apellido_paterno="asignado";
                $oOperador->direccion="--";
                $oOperador->telefono="--";
                $oOperador->rpc="-";
                $oOperador->rpm="--";
                 
            }else {
                $oOperador=operador::getByID($operador_ID);
            }
            $dtEstado=estado::getGrid('est.ID in (1,2)');
            $dtRepresentanteCliente=representantecliente::getGrid('pr.cliente_ID='.$cliente_ID);
            $dtNumero_Cuenta=$dtNumero_Cuenta=numero_cuenta::getGrid('moneda_ID='.$oCotizacion->moneda_ID);
            
           
            $GLOBALS['dtNumero_Cuenta']=mostrarNumeroCuentas(2,$oCotizacion->moneda_ID,$oCotizacion,null);
            $GLOBALS['oCotizacion']=$oCotizacion;
            $GLOBALS['oCliente']=$oCliente;
            $GLOBALS['dtRepresentanteCliente']=$dtRepresentanteCliente;
            $GLOBALS['oOperador']=$oOperador;
            $dtCredito=credito::getGrid('id<>0');
            $GLOBALS['dtCredito']=$dtCredito; 
            $dtForma_Pago=forma_pago::getGrid();
            $GLOBALS['dtForma_Pago']=$dtForma_Pago;
            $GLOBALS['dtEstado']=$dtEstado;
            $GLOBALS['dtMoneda']=moneda::getGrid();
            $GLOBALS['resultado']=$resultado;
            $GLOBALS['mensaje']=$mensaje;
    }
    function mostrarNumeroCuentas($case,$moneda_ID,$oCotizacion,$oOrden_Venta){
        $dtNumero_Cuenta=numero_cuenta::getGrid();
        switch($case){
            case 1:
                $html='<table class="grid_detalle" id="tbnumero_cuenta" width="590px" cellspacing="0">';
                $html.='<tr >
                            <th>Banco</th>
                            <th>Número de cuenta</th>
                            <th>CCI</th>
                            <th>Op</th>
                        </tr>';

                foreach($dtNumero_Cuenta as $value){
                    $class="cssDolares";
                    if($value['moneda_ID']==1){
                        $class="cssSoles";
                    }
                    $style="none;";
                    if($value['moneda_ID']==$moneda_ID){
                        $style="";
                    }
                    $checked=""; 
                    if($value['ID']==1||$value['ID']==2){
                        $checked="checked";
                    }
                    
                    $html.='<tr class="'.$class.'" style="display:'.$style.'">';
                    $html.='<td>'. FormatTextViewHtml($value['abreviatura']).'</td>';
                    $html.='<td>'. $value['numero'].'</td>';
                    $html.='<td>'. $value['cci'].'</td>';
                    $html.='<td style="text-align: center;"><input type="checkbox" id="cknumero_cuenta'. $value['ID'].'" name="cknumero_cuenta'.$value['ID'].'" '.$checked.' value="'.$value['ID'].'"></td>';
                    $html.='</tr>';

                }
                $html.='</table>';
            break;
            case 2:
                
                $html='<table class="grid_detalle" id="tbnumero_cuenta" width="590px">';
                $html.='<tr>
                            <th>Banco</th>
                            <th>Número de cuenta</th>
                            <th>CCI</th>
                            <th>Op</th>
                        </tr>';
                foreach($dtNumero_Cuenta as $value){
                    $class="cssDolares";
                    if($value['moneda_ID']==1){
                        $class="cssSoles";
                    }
                    $style="none;";
                    if($value['moneda_ID']==$moneda_ID){
                        $style="";
                    }
                    $checked="";
                    $html.='<tr class="'.$class.'" style="display:'.$style.'">';
                    $html.='<td>'. FormatTextViewHtml($value['abreviatura']).'</td>';
                    $html.='<td>'. $value['numero'].'</td>';
                    $html.='<td>'. $value['cci'].'</td>';
                    $dtCotizacion_Numero_Cuenta=cotizacion_numero_cuenta::getGrid('cotizacion_ID='.$oCotizacion->ID);
                    foreach($dtCotizacion_Numero_Cuenta as $item){
                        if($item['numero_cuenta_ID']==$value['ID']){
                            $checked="checked";
                        }
                    }

                    $html.='<td style="text-align: center;"><input type="checkbox" '.$checked.' id="cknumero_cuenta'. $value['ID'].'" name="cknumero_cuenta'.$value['ID'].'" value="'.$value['ID'].'"></td>';
                    $html.='</tr>';

                }
                $html.='</table>';
            break;
        }
        
       
        return $html;
    }
    
    
    
    
    function get_cotizacion_mantenimiento_producto_nuevo($id){
        require ROOT_PATH . 'models/categoria.php';
        require ROOT_PATH . 'models/linea.php';
        require ROOT_PATH . 'models/producto.php';
        require ROOT_PATH . 'models/cotizacion.php';
        require ROOT_PATH . 'models/cotizacion_detalle.php';
        require ROOT_PATH . 'models/inventario.php';
        global  $returnView_float;
        
        $returnView_float=true;  
        $dtCategoria=categoria::getGrid('',-1,-1,"ca.nombre asc");
        
        $dtLinea=linea::getGrid('',-1,-1,"li.nombre asc");
        $dtProducto=producto::getGrid('',-1,-1,"pr.nombre asc");
        $oCotizacion_Detalle=new cotizacion_detalle();
        $oCotizacion_Detalle->ID=0;
        //$oCotizacion_Detalle->descripcion="";
        $oCotizacion_Detalle->categoria_ID=0;
        $oCotizacion_Detalle->linea_ID=0;
        $oCotizacion_Detalle->producto_ID=0;
        $oCotizacion=cotizacion::getByID($id);
        $oCotizacion->descripcion='';
        $oCotizacion_Detalle->tipo=1;
        $oCotizacion_Detalle->adicional=0;
        $oCotizacion_Detalle->componente=0;
        $oInventario=new inventario();
        $GLOBALS['linea_ID']=0;
        $GLOBALS['categoria_ID']=0;
        
        $GLOBALS['dtCategoria']=$dtCategoria;
        $GLOBALS['dtLinea']=$dtLinea;
        //$GLOBALS['dtProducto']=$dtProducto;
        $GLOBALS['oCotizacion_Detalle']=$oCotizacion_Detalle;
        $GLOBALS['oCotizacion']=$oCotizacion;
        $GLOBALS['oInventario']=$oInventario;
        $GLOBALS['oProducto']=new producto();
    }
    function post_cotizacion_mantenimiento_producto_nuevo($id){
        require ROOT_PATH . 'models/categoria.php';
        require ROOT_PATH . 'models/linea.php';
        require ROOT_PATH . 'models/producto.php';
        require ROOT_PATH . 'models/cotizacion_detalle.php';
        require ROOT_PATH . 'models/cotizacion.php';
        require ROOT_PATH . 'models/inventario.php';
        global  $returnView_float;
        $returnView_float=true;
        $cotizacion_detalle_ID=$_POST['txtcotizacion_detalle_ID'];//si es mayor que cero solo actualiza
        $componente=0;
        if(isset($_POST['ckComponente'])){
            $componente=$_POST['ckComponente'];
        }
        $adicional=0;
        if(isset($_POST['ckAdicional'])){
            $adicional=$_POST['ckAdicional'];
        }
        $tipo=retornar_tipo($componente,$adicional);
        $producto_ID=$_POST['txtProducto_ID'];
        $descripcion=FormatTextSave(trim($_POST['txtDescripcion']));
        $cantidad=$_POST['txtCantidad'];
        $PrecioUnitarioSoles=$_POST['txtPrecioUnitarioSoles'];
        $PrecioUnitarioDolares=$_POST['txtPrecioUnitarioDolares'];
        $SubTotalSoles=$_POST['txtSubTotalSoles'];
        $SubTotalDolares=$_POST['txtSubTotalDolares'];
        $Igv=$_POST['txtValIgv'];
        $IgvSoles=$_POST['txtIgvSoles'];
        $IgvDolares=$_POST['txtIgvDolares'];
        $TotalSoles=$_POST['txtTotalSoles'];
        $TotalDolares=$_POST['txtTotalDolares'];
        
        if(isset($_POST['ckSeparacion'])){
            $separacion=$_POST['ckSeparacion'];
        }else {
            $separacion=0;
        }
       
        
        if(isset($_POST['ckSeparacion'])){
            $tiempo_separacion=$_POST['ckSeparacion'];
        }else {
            $tiempo_separacion=0;
        }
        
        try{
            if($cotizacion_detalle_ID==0){
                $oCotizacion_Detalle=new cotizacion_detalle();
                $producto_ID_old=$producto_ID;
            }else {
                $oCotizacion_Detalle=cotizacion_detalle::getByID($cotizacion_detalle_ID);
                $producto_ID_old=$oCotizacion_Detalle->producto_ID;
            }
            
            $oCotizacion_Detalle->producto_ID=$producto_ID;
            
            $oCotizacion_Detalle->descripcion=$descripcion;
            $oCotizacion_Detalle->cantidad=$cantidad;
            
            $oCotizacion_Detalle->cotizacion_detalle_ID=0;
            $oCotizacion_Detalle->estado_id=0;
            $oCotizacion_Detalle->ver_precio=1;
            $oCotizacion_Detalle->separacion=$separacion;
            $oCotizacion_Detalle->tiempo_separacion=$tiempo_separacion;
            //$oCotizacion_Detalle->cantidad_separada=$cantidad;
            //Tipo 1, es tipo producto detalle;
            $oCotizacion_Detalle->tipo=$tipo;
            if($cotizacion_detalle_ID==0){
                $oCotizacion_Detalle->cotizacion_ID=$id;
                $oCotizacion_Detalle->precio_venta_unitario_soles=$PrecioUnitarioSoles;
                $oCotizacion_Detalle->precio_venta_unitario_dolares=$PrecioUnitarioDolares;
                $oCotizacion_Detalle->precio_venta_subtotal_soles=$SubTotalSoles;
                $oCotizacion_Detalle->precio_venta_subtotal_dolares=$SubTotalDolares;
                $oCotizacion_Detalle->igv=$Igv;
                $oCotizacion_Detalle->vigv_soles=$IgvSoles;
                $oCotizacion_Detalle->vigv_dolares=$IgvDolares;
                $oCotizacion_Detalle->precio_venta_soles=$TotalSoles;
                $oCotizacion_Detalle->precio_venta_dolares=$TotalDolares;
                $oCotizacion_Detalle->usuario_id=$_SESSION['usuario_ID'];
                $cantidad_no_separado=0;
                $oCotizacion_Detalle->subtotal_soles1='';
                $oCotizacion_Detalle->subtotal_dolares1='';
                $oCotizacion_Detalle->adicional_soles='';
                $oCotizacion_Detalle->adicional_dolares='';
                $oCotizacion_Detalle->insertar();
                
            }else {
               
                $oCotizacion_Detalle->usuario_mod_id=$_SESSION['usuario_ID'];
                $oCotizacion_Detalle->actualizar();
                $oCotizacion_Detalle->precio_venta_unitario_soles=$PrecioUnitarioSoles;
                $oCotizacion_Detalle->precio_venta_unitario_dolares=$PrecioUnitarioDolares;
                $oCotizacion_Detalle->precio_venta_subtotal_soles=$SubTotalSoles;
                $oCotizacion_Detalle->precio_venta_subtotal_dolares=$SubTotalDolares;
                $oCotizacion_Detalle->igv=$Igv;
                $oCotizacion_Detalle->vigv_soles=$IgvSoles;
                $oCotizacion_Detalle->vigv_dolares=$IgvDolares;
                $oCotizacion_Detalle->precio_venta_soles=$TotalSoles;
                $oCotizacion_Detalle->precio_venta_dolares=$TotalDolares;
                $oCotizacion_Detalle=actualizar_costo_cotizacion_detalle_padre($oCotizacion_Detalle);
            }
            separarProductoCotizacion($oCotizacion_Detalle,$producto_ID_old);
            
            /*Actualizamos los costos en la tabla cotizacion*/

            $dtCotizacion_Detalle=cotizacion_detalle::getGrid('cotizacion_ID='.$id.' and cotizacion_detalle_ID=0 and tipo in (1,2,5,6)');
            $precio_venta_neto_soles=0;
            $precio_venta_neto_dolares=0;
            
            foreach($dtCotizacion_Detalle as $item){
                $precio_venta_neto_soles=$precio_venta_neto_soles+$item['precio_venta_subtotal_soles'];
                $precio_venta_neto_dolares=$precio_venta_neto_dolares+$item['precio_venta_subtotal_dolares'];
               
            }
            $oCotizacion=cotizacion::getByID($id);
            $oCotizacion->precio_venta_neto_soles=$precio_venta_neto_soles;
            $oCotizacion->precio_venta_neto_dolares=$precio_venta_neto_dolares;
            $oCotizacion->vigv_soles=$precio_venta_neto_soles*($oCotizacion->igv);; 
            //$oCotizacion->fecha=FormatTextToDate($oCotizacion->fecha,'d/m/Y');
            $oCotizacion->vigv_dolares=$precio_venta_neto_dolares*($oCotizacion->igv);
            $oCotizacion->precio_venta_total_soles=$precio_venta_neto_soles*(1+$oCotizacion->igv);
            $oCotizacion->precio_venta_total_dolares=$precio_venta_neto_dolares*(1+$oCotizacion->igv);
            $oCotizacion->usuario_mod_id=$_SESSION['usuario_ID'];
            $oCotizacion->actualizar();
        
            /*Actualizamos el estado del inventario a separado*/

            $resultado=1;
            $mensaje=$oCotizacion_Detalle->message;

        }catch(Exception $ex){
          $resultado=-1;
          $mensaje=$ex->getMessage();
        }
        $dtCategoria=categoria::getGrid('',-1,-1,'ca.nombre');
        $dtLinea=linea::getGrid('',-1,-1,'li.nombre');
        $dtProducto=producto::getGrid('',-1,-1,'pr.nombre');
        $oInventario=new inventario();
        $oProducto=producto::getByID($producto_ID);
        $oCotizacion_Detalle->oProducto=$oProducto;
        $oCategoria=categoria::getByID($oProducto->categoria_ID);
        $stock=$oInventario->getStock($producto_ID);
        $oCotizacion_Detalle->adicional=$adicional;
        $oCotizacion_Detalle->componente=$componente;
        $oInventario->stock=$stock;
        $oCotizacion_Detalle->categoria_ID=$oProducto->categoria_ID;
        $oCotizacion_Detalle->linea_ID=$oCategoria->linea_ID;
        $GLOBALS['dtCategoria']=$dtCategoria;
        $GLOBALS['dtLinea']=$dtLinea;
        $GLOBALS['dtProducto']=$dtProducto;
        $GLOBALS['oInventario']=$oInventario;
        $oCotizacion=cotizacion::getByID($id);
        $GLOBALS['oCotizacion']=$oCotizacion;
        $GLOBALS['oCotizacion_Detalle']=$oCotizacion_Detalle;
        $GLOBALS['resultado']=$resultado;
        $GLOBALS['mensaje']=  $mensaje;
        
    }
    
    function retornar_tipo($componente, $adicional){
        
        $tipo=1;
        switch([$componente,$adicional]){
            case ['0','0']:
                $tipo=1;
                break;
            case ['1','0']:
                $tipo=2;
                break;
            case ['1','1']:
                $tipo=5;
                break;
            case ['0','1']:
                $tipo=6;
                break;
        }
        return $tipo;
    }
    /*function retornar_valores($tipo){
        $array=array("componente"=>'0','adicional'=>'0');
         switch($tipo){
            case 2:
                $array=array("componente"=>'1','adicional'=>'0');post_ajaxLlenarCajas
                break;
            case 5:
                $array=array("componente"=>'1','adicional'=>'1');
                break;
            case 6:
                $array=array("componente"=>'0','adicional'=>'1');
                break;
            
        }
        return $array;
    }*/
    
    
    
    
    function llenarValores($oCotizacion_Detalle){
        if(!class_exists('producto')){
            require ROOT_PATH.'models/producto.php';
        }
        if(!class_exists('cotizacion_detalle')){
            require ROOT_PATH.'models/cotizacion_detalle.php';
        }
        if(!class_exists('cotizacion')){
            require ROOT_PATH.'models/cotizacion.php';
        }
        try{
            //$oCotizacion_Detalle=cotizacion_detalle::getByID($ID);
            $oCotizacion=cotizacion::getByID($oCotizacion_Detalle->cotizacion_ID);
            $precio_venta_subtotal_soles_hijo=0;
            $precio_venta_subtotal_dolares_hijo=0;
            $adicional_soles=0;
            $adicional_dolares=0;
            
            $dtCotizacion_Detalle=cotizacion_detalle::getGrid('cotizacion_ID='.$oCotizacion_Detalle->cotizacion_ID.' and cotizacion_detalle_ID='.$oCotizacion_Detalle->ID.' and tipo in (3,4)',-1,-1,'ID asc');
            foreach($dtCotizacion_Detalle as $item){
                switch($item['tipo']){
                    case 3://componente
                        $precio_venta_subtotal_soles_hijo=$precio_venta_subtotal_soles_hijo+$item['precio_venta_subtotal_soles'];
                        $precio_venta_subtotal_dolares_hijo=$precio_venta_subtotal_dolares_hijo+$item['precio_venta_subtotal_dolares'];
                        break;
                    case 4://adicional
                        $adicional_soles=$adicional_soles+$item['precio_venta_subtotal_soles'];
                        $adicional_dolares=$adicional_dolares+$item['precio_venta_subtotal_dolares'];
                        break;
                }
            }
            switch($oCotizacion_Detalle->tipo){
                case 2://Producto con componente

                    $oCotizacion_Detalle->adicional_soles='';
                    $oCotizacion_Detalle->adicional_dolares='';
                    $oCotizacion_Detalle->subtotal_soles1='';
                    $oCotizacion_Detalle->subtotal_dolares1='';
                    break;
                case 5://producto con componente y adicional
                    $oCotizacion_Detalle->precio_venta_unitario_soles=$precio_venta_subtotal_soles_hijo;
                    $oCotizacion_Detalle->precio_venta_unitario_dolares=$precio_venta_subtotal_dolares_hijo;
                    $oCotizacion_Detalle->adicional_soles=$adicional_soles;
                    $oCotizacion_Detalle->adicional_dolares=$adicional_dolares;
                    $oCotizacion_Detalle->subtotal_soles1=$oCotizacion_Detalle->precio_venta_subtotal_soles;
                    $oCotizacion_Detalle->subtotal_dolares1=$oCotizacion_Detalle->precio_venta_subtotal_dolares;
                    $oCotizacion_Detalle->precio_venta_subtotal_soles=$precio_venta_subtotal_soles_hijo*$oCotizacion_Detalle->cantidad;
                    $oCotizacion_Detalle->precio_venta_subtotal_dolares=$precio_venta_subtotal_dolares_hijo*$oCotizacion_Detalle->cantidad;
                    break;
                case 6://producto con adicional
                    $oCotizacion_Detalle->precio_venta_unitario_soles=($oCotizacion_Detalle->precio_venta_subtotal_soles-$adicional_soles)/$oCotizacion_Detalle->cantidad;
                    $oCotizacion_Detalle->precio_venta_unitario_dolares=($oCotizacion_Detalle->precio_venta_subtotal_dolares-$adicional_dolares)/$oCotizacion_Detalle->cantidad;
                    $oCotizacion_Detalle->adicional_soles=$adicional_soles;
                    $oCotizacion_Detalle->adicional_dolares=$adicional_dolares;
                    $oCotizacion_Detalle->subtotal_soles1=$oCotizacion_Detalle->precio_venta_subtotal_soles;
                    $oCotizacion_Detalle->subtotal_dolares1=$oCotizacion_Detalle->precio_venta_subtotal_dolares;
                    $oCotizacion_Detalle->precio_venta_subtotal_soles=$oCotizacion_Detalle->precio_venta_subtotal_soles-$adicional_soles;
                    $oCotizacion_Detalle->precio_venta_subtotal_dolares=$oCotizacion_Detalle->precio_venta_subtotal_dolares-$adicional_dolares;
                    break;
            }
            /*$precio_venta_subtotal_soles1=$oCotizacion_Detalle->subtotal_soles1;
            $precio_venta_subtotal_soles=$oCotizacion_Detalle->precio_venta_subtotal_soles;
            $precio_venta_unitario_soles=$oCotizacion_Detalle->precio_venta_unitario_soles;
            $vigv_soles=number_format($oCotizacion_Detalle->vigv_soles,2,'.',',');
            $precio_venta_soles=number_format($oCotizacion_Detalle->precio_venta_soles,2,'.',','); 
            $adicional_soles=$oCotizacion_Detalle->adicional_soles;
           
             //Precio en dolares
            $precio_venta_subtotal_dolares1=$oCotizacion_Detalle->subtotal_dolares1;
            $precio_venta_subtotal_dolares=$oCotizacion_Detalle->precio_venta_subtotal_dolares;
            $precio_venta_unitario_dolares=$oCotizacion_Detalle->precio_venta_unitario_dolares;
            $vigv_dolares=number_format($oCotizacion_Detalle->vigv_dolares,2,'.',','); 
            $precio_venta_dolares=number_format($oCotizacion_Detalle->precio_venta_dolares,2,'.',','); 
            $adicional_dolares=$oCotizacion_Detalle->adicional_dolares;*/
            
        }catch(Exception $ex){
            
        }
        return $oCotizacion_Detalle;
    }
    
    
    

    
    
    

    
    
    
    
    function post_ajaxCbo_Producto(){
		require ROOT_PATH.'models/producto.php';
		$buscar=$_POST['txtBuscar'];
		$filtro='upper(pr.nombre) like "%'.strtoupper(FormatTextSave($buscar)).'%"';
		$dtProducto=producto::getGrid($filtro);
				
		$i=1;
		$resultado='<ul class="cbo-ul">';
		if(count($dtProducto)>0){			
			foreach($dtProducto as $iProducto){
				$resultado.='<li id="li_'.$i.'"><span id="'.$iProducto['ID'].'" title="'.FormatTextViewHtml($iProducto['producto']).'">'.FormatTextViewHtml($iProducto['producto']).'</span></li>';
				$i++;
			}
		}
		$resultado.='</ul>';
		
		$mensaje='';
		$retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);
		echo json_encode($retornar);
	}
    
   
    function post_Cotizacion_Producto(){
		require ROOT_PATH.'models/cotizacion.php';
                require ROOT_PATH.'models/cotizacion_detalle.php';
		$cotizacion_ID=$_POST['txtID'];
                $producto_ID=$_POST['txtProducto_ID'];
                $descripcion=$_POST['txtDescripcion'];
		$cantidad=$_POST['txtCantidad'];
                
                $precio_venta_unitario=$_POST['txtPrecioUnitVenta'];
                $precio_venta=$_POST['txtPrecioVenta'];
                if(isset($_POST['ckbVerPrecio'])){
                    
                    $ver_precio=1;
                } else{
                     $ver_precio=0;
                }
               
               
                
                $cotizacion_detalle_ID=$_POST['txtcotizacion_detalle_ID'];
                
          
		//---------------------------------------					 
		
		
		try {
                $oCotizacion_Detalle=new cotizacion_detalle();
		$oCotizacion_Detalle->cotizacion_ID=$cotizacion_ID;
                $oCotizacion_Detalle->producto_ID=$producto_ID;
                $oCotizacion_Detalle->descripcion=$descripcion;
                $oCotizacion_Detalle->observacion="";
                $oCotizacion_Detalle->cantidad=$cantidad;
                $oCotizacion_Detalle->precio_venta_unitario=$precio_venta_unitario;
                $oCotizacion_Detalle->precio_venta=$precio_venta;
                $oCotizacion_Detalle->cotizacion_detalle_ID=$cotizacion_detalle_ID;
                $oCotizacion_Detalle->ver_precio=$ver_precio;
                $oCotizacion_Detalle->estado_id=1;
                $oCotizacion_Detalle->usuario_id=$_SESSION['usuario_ID'];
                $flag=$oCotizacion_Detalle->insertar();	
                //$cotizacion_detalle_ID=$oCotizacion_Detalle->ID;
                $resultado=1;
                $mensaje="Se ha guardó correctamente"; 
               
                
			
		}catch(Exception $ex){
			$resultado=-1;
                        $mensaje="No se ha guardado";
		}
		
		$retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje,'cotizacion_ID'=>$cotizacion_ID);
                //$retorn="<h1>Hola</h1>";
                
		echo json_encode($retornar);
	}
   
    function post_ajaxCotizacion_Producto(){
		require ROOT_PATH.'models/cotizacion.php';
                require ROOT_PATH.'models/cotizacion_detalle.php';
                require ROOT_PATH.'models/producto.php';
		$cotizacion_ID=$_POST['ID'];
                //$cotizacion_detalle_ID=$_POST['txtcotizacion_detalle_ID'];
              
		//---------------------------------------					 
		$resultado='<table class="table table-bordered" style="font-size:11px;"><tr>';	
                $resultado.='<th style="width:100px;"></th>';
		$resultado.='<th style="width:40px;">ITEM </th>';			
		$resultado.='<th style="width:400px;">DESCRIPCION </th>';
		$resultado.='<th style="width:30px;">CANTIDAD </th>';
                $resultado.='<th style="width:20px;">PRECIO UNT. </th>';
                $resultado.='<th style="width:30px;">PRECIO T.. </th>';

		$resultado.='</tr>';
		
		
		try {
						
			$dtCotizacion_Detalle=cotizacion_detalle::getGrid('cotizacion_ID='.$cotizacion_ID);								
			$rows=count($dtCotizacion_Detalle);		
			$i=1;
                        $costo_venta=0;
                        
                       
			foreach($dtCotizacion_Detalle as $item)
			{ 
                            $cotizacion_detalle_ID=$item['cotizacion_detalle_ID'];
                            if($cotizacion_detalle_ID==0){
                            $oProducto=producto::getByID($item['producto_ID']);
                            $costo_venta_unitario_padre=$item['precio_venta_unitario'];
                            $costo_venta_padre=$item['precio_venta'];
				$resultado.='<tr class="tr-item">';
                                $resultado.='<td class="btnAction"><a onclick="fncEliminar('.$item['ID'].');">Eliminar</a>&nbsp;&nbsp;<a data-target="#ModalProducto" data-toggle="modal" onclick="ingresarHijo('.$item['ID'].');">Componentes</a></td>';
				 $resultado.='<td class="tdCenter">'.$i.'</td>';
				$resultado.='<td class="tdLeft">'.FormatTextViewHtml($oProducto->nombre).':'.FormatTextViewHtml($item['descripcion']);
                                $dtCotizacion_Detalle_Hijo=cotizacion_detalle::getGrid('cotizacion_ID='.$cotizacion_ID.' and cotizacion_detalle_ID='.$item['ID'] );
                                $contar= count($dtCotizacion_Detalle_Hijo);
                                 if($contar>0){
                                       
                                         $resultado.='<div class="DivHijos">';
                                         $costo_venta_hijo=0;
                                            foreach ($dtCotizacion_Detalle_Hijo as $value) {
                                               $oProductoHijo=producto::getByID($value['producto_ID']);
                                               $resultado.='<span>'.FormatTextViewHtml($value['cantidad']).'-'.FormatTextViewHtml($oProductoHijo->nombre).': '.FormatTextViewHtml($value['descripcion']).' ';
                                                    if($value['ver_precio']==1){
                                                        $resultado.=FormatTextViewHtml(number_format($value['precio_venta_unitario'],2,".",",")).' -- '.formatTextViewHtml(number_format($value['precio_venta'],2,".",","));
                                                    }
                                                $resultado.='&nbsp;&nbsp;&nbsp;<a onclick="fncEliminar('.$value['ID'].');">Eliminar</a></span>';
                                               $costo_venta_hijo=$costo_venta_hijo+$value['precio_venta'];
                                            }

                                        $resultado.="</div>";
                                        $costo_venta_unitario_padre=$costo_venta_hijo;
                                        $costo_venta_padre=$costo_venta_hijo*$item['cantidad'];
                                        $oCotizacion_Detalle=new cotizacion_detalle();
                                        $oCotizacion_Detalle->ID=$cotizacion_detalle_ID;
                                        $oCotizacion_Detalle->precio_venta_unitario=$costo_venta_unitario_padre;
                                        $oCotizacion_Detalle->precio_venta=$costo_venta_padre;
                                        $oCotizacion_Detalle->usuario_mod_id=$_SESSION['usuario_ID'];
                                        $oCotizacion_Detalle->actualizarCosto();

                                    }
                                $resultado.=  '</td>';                    
				$resultado.='<td class="tdLeft">'.FormatTextViewHtml($item['cantidad']).'</td>';
                                $resultado.='<td class="tdLeft">'.FormatTextViewHtml(number_format($costo_venta_unitario_padre,2,".",",")).'</td>';
                                $resultado.='<td class="tdLeft">'.FormatTextViewHtml(number_format($costo_venta_padre,2,".",",")).'</td>';
                                $resultado.='</tr>';
                                $i++;
                                $costo_venta=$costo_venta+$costo_venta_padre;
                            }
                        }
                            $igv=0.18*$costo_venta;
                            $costo_total=1.18*$costo_venta;
                            //Guardamos los cotos totales en la tabla cotizacion
                            $oCotizacion=new cotizacion();
                            $oCotizacion->ID=$cotizacion_ID;
                            $oCotizacion->precio_venta_neto=$costo_venta;
                            $oCotizacion->igv=$igv;
                            $oCotizacion->precio_venta=$costo_total;
                            $oCotizacion->usuario_mod_id=$_SESSION['usuario_ID'];
                            $oCotizacion->actualizarCosto();
                            $resultado.='<tr style="border-bottom:hidden;border-left:hidden;"><td colspan="5" style="text-align:right;font-weight: bold; padding:1px 8px;">COSTO VENTA</td><td style="padding:1px 8px;">'.FormatTextViewHtml(number_format($costo_venta,2,".",",")).'<input id="txtValorSubTotal" name="txtValorSubTotal" style="display:none;" value="'.FormatTextViewHtml($costo_venta).'"></td>';
                            $resultado.='<tr style="border-bottom:hidden;border-left:hidden;"><td colspan="5" style="text-align:right;font-weight: bold; padding:1px 8px;">IGV</td><td style="padding:1px 8px;">'.FormatTextViewHtml(number_format($igv,2,".",",")).'<input id="txtIgvTotal" name="txtIgvSubTotal" style="display:none;"  value="'.FormatTextViewHtml($igv).'"></td>';
                            $resultado.='<tr style="border-bottom:hidden;border-left:hidden;"><td colspan="5" style="text-align:right;font-weight: bold; padding:1px 8px;">COSTO TOTAL VENTA</td><td style="padding:1px 8px;">'.number_format($costo_total,2,".",",").'<input id="txtVentaTotal" name="txtVentaTotal" style="display:none;" value="'.FormatTextViewHtml($costo_total).'"></td>';

                        
                       }catch(Exception $ex){
			$resultado.='<tr ><td colspan=6>'.$ex->getMessage().'</td></tr>';
		}
		
		$resultado.='</table>';
		
		$mensaje='';
		$retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);
                //$retorn="<h1>Hola</h1>";
                
		echo json_encode($retornar);
	}
    function post_ajaxCotizacion_CambiarEstado(){
        require ROOT_PATH.'models/cotizacion.php';
        require ROOT_PATH.'models/cotizacion_detalle.php';
         $valores=explode('-',$_POST['id']);
         $cotizacion_ID=$valores[0];
         $estado_ID=$valores[1];
         
        try {
             $oCotizacion=cotizacion::getByID($cotizacion_ID);
            switch($estado_ID){
                case 2:
                    $dtCotizacion_Detalle=cotizacion_detalle::getGrid('cotizacion_ID='.$cotizacion_ID);
                    $contar=count($dtCotizacion_Detalle);
                    if($contar>0){
                    $oCotizacion->estado_ID=$estado_ID;
                    $oCotizacion->usuario_mod_id=$_SESSION['usuario_ID'];
                    $oCotizacion->actualizar();
                    $resultado="1";
                    $mensaje=$oCotizacion->message;
                    }else {
                    $resultado="0";
                    $mensaje="Debe agregar un producto como mínimo";
                    }
                    
                    break;
            }
           
            
            
        }catch(Exception $ex){
         $resultado='-1';
         $mensaje=$ex->getMessage();
        }
        $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);
        echo json_encode($retornar);
    }
    
    
    function post_ajaxCotizacion_Numero_Cuenta(){
        require ROOT_PATH.'models/numero_cuenta.php';
        //require ROOT_PATH.'models/moneda.php';
        $moneda_ID=$_POST['id'];
        
        try{
            $dtNumero_cuenta=numero_cuenta::getGrid('moneda_ID='.$moneda_ID,-1,-1,'ID desc');
            $array=array();
            foreach($dtNumero_cuenta as $item){
                $arreglo=array();
                $arreglo['numero']=$item['numero'];
                $arreglo['cci']=$item['cci'];
                $arreglo['banco']=FormatTextViewHtml($item['nombre_banco']);
             array_push($array,$arreglo);   
            }
           
        } catch (Exception $ex) {
            $mensaje=$ex->getMessage();
            
        }
        	
        if(!isset($mensaje)){
            $mensaje='';
        }
        if(!isset($numero)){
            $numero="--";
        }
        if(!isset($cci)){
            $cci="--";
        }
        if(!isset($banco)){
            $banco="--";
        }
        

        $retornar=Array('lista'=>$array,'mensaje'=>$mensaje);

                //$retorn="<h1>Hola</h1>";
                
		echo json_encode($retornar);
    }
    
    
    function post_ajaxActualizar_Cotizacion_Detalle_Ck(){
        
        require ROOT_PATH.'models/cotizacion_detalle.php';
       
        
        $oCotizacion_Detalle=new cotizacion_detalle;
       
        $cotizacion_detalle_ID=$_POST['cotizacion_detalle_ID'];
        $ver_precio=$_POST['ver_precio'];
        
        try{
            
            
            $oCotizacion_Detalle->ID=$cotizacion_detalle_ID;
            $oCotizacion_Detalle->ver_precio=$ver_precio;
            $oCotizacion_Detalle->usuario_mod_id=$_SESSION['usuario_ID'];
            $oCotizacion_Detalle->actualizarCk();
            
            $mensaje="Se guardó correctamente";
            $resultado=1;
            
        } catch (Exception $ex) {
            $GLOBALS['resultado']=-1;
            $resultado=-1;
            $mensaje=$ex->getMessage();
        }
        if(!isset($mensaje)){
            $mensaje="No hya accion";
        }
        if(!isset($resultado)){
            $resultado=0;
        }
      
        
	$retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);
		echo json_encode($retornar);
    }
    
    function get_Cuerpo_Detalle($id){
        require ROOT_PATH . 'models/producto.php';
        require ROOT_PATH . 'models/cotizacion.php';
        require ROOT_PATH . 'models/cotizacion_detalle.php';
       require ROOT_PATH . 'models/moneda.php';
        global  $returnView_float;
        $returnView_float=true; 
        $cotizacion_ID=$id;
        $oCotizacion=cotizacion::getByID($cotizacion_ID);
        $oMoneda=moneda::getByID($oCotizacion->moneda_ID);
        $sub_total=0;
        $vigv=0;
        $precio_total=0;
        
        if($oCotizacion->forma_pago_ID==1){
            $sub_total=$oCotizacion->precio_venta_neto_soles;
            $vigv=$oCotizacion->vigv_soles;
            $precio_total=$oCotizacion->precio_venta_total_soles;
        }else if($oCotizacion->forma_pago_ID==2){
            $sub_total=$oCotizacion->precio_venta_neto_dolares;
            $vigv=$oCotizacion->vigv_dolares;
            $precio_total=$oCotizacion->precio_venta_total_dolares;
        }
        $cuerpoHTML='<table width="700px" cellpadding=0 cellspacing=0 class="tablacontenido"   >
                <tr>
                    <th width="40px" >Item</th>
                    <th width="430px">Descripción</td>
                    <th width="85px">Prec. Unit. '.$oMoneda->simbolo.'</th>
                    <th width="60px">Cantidad</th>
                    <th width="85px">Total '.$oMoneda->simbolo.'</th>
                </tr>';
        $dtCotizacion_Detalle=  cotizacion_detalle::getGrid('cotizacion_ID='.$cotizacion_ID.' and cotizacion_detalle_ID=0');
        $contar=count($dtCotizacion_Detalle);
        $cuerpoHTML.='<tr id="contenedor_productos" ><td colspan="5" id="tdproductos">';
        $cuerpoHTML.='<table cellsspacin="0" cellspadding="0" id="tablaproducto">';
        if($contar>0){
            $contador=1;
            
            foreach ($dtCotizacion_Detalle as $value) {
                if($oCotizacion->moneda_ID==1){
                    $precio_unitario=$value['precio_venta_unitario_soles'];
                    $precio_subtotal=$value['precio_venta_subtotal_soles'];
                }else if($oCotizacion->moneda_ID==2){
                    $precio_unitario=$value['precio_venta_unitario_dolares'];
                    $precio_subtotal=$value['precio_venta_subtotal_dolares'];
                }

                $oProducto=producto::getByID($value['producto_ID']);
                $cuerpoHTML.='<tr>
                            <td id="td'.$contador.'" width="40px" class="celda" style="border:none; border-left:1px solid #000;" >
                            <div class="celda1"> <span class="producto">'.$contador.'</span></div>
                            </td>
                            <td width="430px" class="celda" style="border:none; border-left:1px solid #000;">
                            <span class="producto" style="padding-bottom:5px;">'.$oProducto->nombre.'</span>';
                            if(trim($value['descripcion'])!=""){
                               $cuerpoHTML.='<span class="descripcion" style="font-style:normal;font-size:9px;padding-bottom:5px; color:#413F3F;">'.
                                            FormatTextViewHtml($value['descripcion']).'</span>'; 
                            }

                        $dtCotizacion_Detalle_Hijo=cotizacion_detalle::getGrid('cotizacion_detalle_ID='.$value['ID']);
                        $contar_hijo=count($dtCotizacion_Detalle_Hijo);
                        if($contar_hijo>0){
                            $contador_hijo=1;
                            $cuerpoHTML.='<span style="padding-bottom:10px;"><table width="430px" cellpadding=0 cellspacing=0 style="font-size:10px; border:none;">';
                            foreach ($dtCotizacion_Detalle_Hijo as $item) {
                                $cuerpoHTML.='<tr>';
                                if($oCotizacion->moneda_ID==1){
                                    $precio_unitario_hijo=$item['precio_venta_unitario_soles'];
                                    $precio_subtotal_hijo=$item['precio_venta_subtotal_soles'];
                                }else if($oCotizacion->moneda_ID==2){
                                    $precio_unitario_hijo=$item['precio_venta_unitario_dolares'];
                                    $precio_subtotal_hijo=$item['precio_venta_subtotal_dolares'];
                                }
                                 $oProducto_Hijo=producto::getByID($item['producto_ID']);
                                 $cuerpoHTML.='<td width="20px" style="font-size:9px; border:none; vertical-align:top; text-align:center;  color:#413F3F;">'.$contador_hijo.'</td>';
                                 $cuerpoHTML.='<td width="340px" style="font-size:9px; border:none; vertical-align:top; text-align:justify; color:#413F3F;">'.$oProducto_Hijo->nombre.'</td>';
                                 $cuerpoHTML.='<td width="20px" style="font-size:9px; border:none; vertical-align:top; text-align:right; color:#413F3F;">'.$item['cantidad'].'</td>';
                                 $cuerpoHTML.='<td width="50px" style="font-size:9px; border:none; vertical-align:top;text-align:right; color:#413F3F;">'.$oMoneda->simbolo.' '.$precio_subtotal_hijo.'</td>';
                                 $cuerpoHTML.='</tr>';
                            $contador_hijo=$contador_hijo+1;
                            }
                            $cuerpoHTML.='</table></span>';
                        }



          $cuerpoHTML.='</td>
                        <td width="85px" class="celda" style="border:none; border-left:1px solid #000;">
                            <span class="producto" style="text-align:right; padding-right:4px;">'.$precio_unitario.'</span>
                        </td>
                        <td width="60px" class="celda" style="border:none; border-left:1px solid #000;">
                            <span class="producto" style="text-align:center;">'.$value['cantidad'].'</span>
                        </td>
                        <td width="85px" class="celda" style="border:none; border-left:1px solid #000;border-right:1px solid #000;">
                            <span class="producto" style="text-align:right;padding-right:4px;">'.$precio_subtotal.'</span>
                        </td>

                        </td>
                    </tr>';
              $contador=$contador+1; 

            }
            
           $cuerpoHTML.='</table>';
           $cuerpoHTML.='</td></tr>';
        } 
    $cuerpoHTML.='<tr>
                <td colspan="2" rowspan="3" style="border-left: 1px solid #fff; border-bottom: 1px solid #fff;"></td>
                <td rowspan="3" style="height:60px; color:413F3F;">
                    <span style="color:413F3F;">Precio</span>
                    <span >Expresado en:</span> 
                    <span>'.$oMoneda->simbolo.'</span>
                </td>
                <td><span style="color:413F3F;">Sub-Total</span></td>
                <td><span style="text-align:right; padding-right:4px; color:413F3F;">'.$sub_total.'</span></td>
            </tr>
            <tr>
                <td><span>IGV.</span></td>
                <td><span style="text-align:right; padding-right:4px; color:413F3F;">'.$vigv.'</span></td>
            </tr>
            <tr>
                <td><span>Total</span></td>
                <td><span style="text-align:right; padding-right:4px; color:413F3F;">'.$precio_total.'</span></td>
            </tr>
        </table>';
        
        
        $GLOBALS['cuerpoHTML']=$cuerpoHTML;
    }
//inicio  venta
//llama la interfaz donde mostrara los datos traidos de cotizacion
function get_Guia_Venta_Generar($id) {
    require ROOT_PATH . 'models/cotizacion.php';
    require ROOT_PATH . 'models/cotizacion_detalle.php';
    require ROOT_PATH . 'models/guia.php';
    require ROOT_PATH . 'models/representantecliente.php';
    require ROOT_PATH . 'models/estado.php';
    require ROOT_PATH . 'models/moneda.php';

    global $returnView_float;
    $returnView_float = true;

    $oGuia = new guia();

    $oCotizacion = cotizacion::getByID($id);
    $oCotizacionDetalle = cotizacion_detalle::getGridByCotizacion($oCotizacion->ID);
    $oRCliente = representantecliente::getByIDCliente($oCotizacion->cliente_ID);
    $dtMoneda = moneda::getGrid('');
    $dtEstado = estado::getGrid('');
    if ($oCotizacionDetalle == null) {
        $GLOBALS['resultado'] = -3;
        $GLOBALS['mensaje'] = 'Parecer que el registro ya fue eliminado.';
        return;
    }
    if ($oCotizacion == null) {
        $GLOBALS['resultado'] = -3;
        $GLOBALS['mensaje'] = 'Parecer que el registro ya fue eliminado.';
        return;
    }

    if ($oGuia == null) {
        $GLOBALS['resultado'] = -3;
        $GLOBALS['mensaje'] = 'Parecer que el registro ya fue eliminado.';
        return;
    }
    if ($oRCliente == null) {
        $GLOBALS['resultado'] = -3;
        $GLOBALS['mensaje'] = 'Parecer que el registro ya fue eliminado.';
        return;
    }

    try {


        $GLOBALS['oGuia'] = $oGuia;
        $GLOBALS['oCotizacion'] = $oCotizacion;
        $GLOBALS['oCotizacionDetalle'] = $oCotizacionDetalle;
        $GLOBALS['oRCliente'] = $oRCliente;

        $GLOBALS['dtMoneda'] = $dtMoneda;
        $GLOBALS['dtEstado'] = $dtEstado;
        $GLOBALS['mensaje'] = '';
    } catch (Exception $ex) {
        $GLOBALS['mensaje'] = $ex->getMessage();
    }
}

//codigo oretgea -generar guia y cambiar estado aprobado en cotizacion
function post_Guia_Venta_Generar() {
    require ROOT_PATH . 'models/guia.php';
    require ROOT_PATH . 'models/producto.php';
    require ROOT_PATH . 'models/detalle_guia_venta.php';
    require ROOT_PATH . 'models/cotizacion.php';



    require ROOT_PATH . 'models/vehiculo.php';
    require ROOT_PATH . 'models/representantecliente.php';
    require ROOT_PATH . 'models/cliente.php';


    global $returnView_float;
    $returnView_float = true;

    $descripcion = $_POST['txtDescripcion'];
    $direccion = $_POST['txtDireccion'];
    $cotizacion = $_POST['txtCotizacion'];
    $numero = $_POST['txtNumero'];
    $rep_cliente = $_POST['txtRep_Cliente_ID'];
    $plazo_entrega = $_POST['txtPlazo_Entrega'];
    $fecha = $_POST['txtFecha'];
    $vehiculo = $_POST['txtVehiculo_ID'];
    $chofer = $_POST['txtChofer_ID'];
    $moneda = $_POST['cboMoneda'];
    $estado = $_POST['cboEstado'];
    $numero_factura = $_POST['txtNumero_Factura'];
    $venta_total = $_POST['txtVenta_Total'];
    $igv = $_POST['txtIgv'];
    $costo_venta = $_POST['txtCosto_Venta'];

    $oGuia = new guia();
    $oCotizacion = new cotizacion();
    try {
        $oGuia->descripcion = $descripcion;
        $oGuia->direccion = $direccion;
        $oGuia->cotizacion = $cotizacion;
        $oGuia->numero = $numero;
        $oGuia->rep_cliente = $rep_cliente;
        $oGuia->plazo_entrega = $plazo_entrega;
        $oGuia->fecha = $fecha;
        $oGuia->vehiculo = $vehiculo;
        $oGuia->chofer = $chofer;
        $oGuia->moneda = $moneda;
        $oGuia->estado = $estado;
        $oGuia->numero_factura = $numero_factura;
        $oGuia->venta_total = $venta_total;
        $oGuia->igv = $igv;
        $oGuia->costo_venta = $costo_venta;

        $oGuia->usuario_id = $_SESSION['usuario_ID'];
        $oGuia->fdc = "now()";
        $oGuia->del = "0";
        $oGuia->fdm = "";
        $oGuia->usuario_mod_id = $_SESSION['usuario_ID'];

        if ($oGuia->verificarDuplicado() > 0) {
            throw new Exception($oCompra_comprobante->message);
        }

        $oGuia->insertar();
        $oCotizacion->aprobarCotizacion($cotizacion);

        //--------------------Inserto el detalle del comprobante-----			

        if (isset($_POST['txtProducto_ID'])) {
            $producto_array = $_POST['txtProducto_ID'];
            $cantidad_array = $_POST['txtCantidad'];
            $precio_venta_array = $_POST['txtPrecio_venta'];
            $precio_venta_unitario_array = $_POST['txtPrecio_venta_unitario'];
            $descripcion_array = $_POST['txtDescripcion'];

            $i = 0;

            foreach ($producto_array as $item) {
                $producto_ID = $item;
                $descripcion = $descripcion_array[$i];
                $cantidad = $cantidad_array[$i];
                $precio_venta = $precio_venta_array[$i];
                $precio_venta_unitario = $precio_venta_unitario_array[$i];
                $oDetalle_guia_venta = new detalle_guia_venta();
                //$oDetalle_guia_venta->ID = $item['ID'];
                $oDetalle_guia_venta->cantidad = $cantidad;
                $oDetalle_guia_venta->descripcion = $descripcion;
                //$oDetalle_guia_venta->detalle_guia_venta_ID = $item['detalle_guia_venta_ID'];
                $oDetalle_guia_venta->fdc = $oGuia->fecha;
                $oDetalle_guia_venta->guia_venta_ID = $oGuia->ID;;
                $oDetalle_guia_venta->precio_venta = $precio_venta;
                $oDetalle_guia_venta->precio_venta_unitario = $precio_venta_unitario;
                $oDetalle_guia_venta->producto_ID = $producto_ID;
                $oDetalle_guia_venta->usuario_id = $oGuia->usuario_id;

                $oDetalle_guia_venta->insertar();

                $i = $i + 1;
            }
        }
//para imprimir los datos
        $dtGv = detalle_guia_venta::getGrid($oGuia->ID);
        $oGuia = guia::getByID($oGuia->ID);
        $oVehiculo = vehiculo::getByID($oGuia->vehiculo);
        $oRc = representantecliente::getByID($oGuia->rep_cliente);echo "----".$oRc->cliente;
        $ocliente = cliente::getByID($oRc->cliente);

        $GLOBALS['dtGv'] = $dtGv;
        $GLOBALS['oGuia'] = $oGuia;
        $GLOBALS['oVehiculo'] = $oVehiculo;
        $GLOBALS['oRc'] = $oRc;
        $GLOBALS['oCliente'] = $ocliente;
        $GLOBALS['resultado'] = 1;
        
        $GLOBALS['mensaje'] = $oGuia->message;
    } catch (Exception $ex) {
//        if (isset($_POST['txtProducto_ID'])) {
//            $producto_array = $_POST['txtProducto_ID'];
//            $cantidad_array = $_POST['txtCantidad'];
//            $precio_venta_array = $_POST['txtPrecio_venta'];
//            $precio_venta_unitario_array = $_POST['txtPrecio_venta_unitario'];
//            $descripcion_array = $_POST['txtDescripcion'];
//
//            $i = 0;
//
//            foreach ($materia_prima_array as $item) {
//                $materia_prima_ID = $item;
//                $codigo = '';
//                $descripcion = $descripcion_array[$i];
//
//                if ($materia_prima_ID != 0) {
//                    $oMateria_Prima = materia_prima::getByID($materia_prima_ID);
//                    $codigo = $oMateria_Prima->codigo;
//                    $descripcion = $oMateria_Prima->nombre;
//                }
//
//                $cantidad = $cantidad_array[$i];
//
//               
//
//                $row = array(
//                    "materia_prima_ID" => $materia_prima_ID,
//                    "codigo" => $codigo,
//                    "cantidad" => $cantidad,
//                    "descripcion" => $descripcion,
//                    "precio" => $precio,
//                    "importe" => $importe,
//                    "precioIGV" => $precioIGV,
//                    "importeIGV" => $importeIGV
//                );
//
//                $dtCompra_Comprobante_Detalle[] = $row;
//                $i = $i + 1;
//            }
//        }
//        $GLOBALS['dtCompra_Comprobante_Detalle'] = $dtCompra_Comprobante_Detalle;
        $GLOBALS['resultado'] = -1;
        $GLOBALS['mensaje'] = $oGuia->message;
    }

//    $oDatos_generales = datos_generales::getByID(0);
//    $dtComprobante_tipo = comprobante_tipo::getGrid('ct.en_compra=1');
//    $dtEstado = estado::getGrid('est.ID<>4 and est.tabla="compra_comprobante"');
//    $oProveedor = proveedor::getByID($oCompra_comprobante->proveedor_ID);
//    $oEmpresa = empresa::getByID($oProveedor->empresa_ID);
//
//    $GLOBALS['proveedor_razon_social'] = $oEmpresa->razon_social;
//    $GLOBALS['comprobante_tipo_ID'] = $oCompra_comprobante->comprobante_tipo_ID;
//    $GLOBALS['estado_ID'] = $oCompra_comprobante->estado_ID;
//    $GLOBALS['oCompra_comprobante'] = $oCompra_comprobante;
//    $GLOBALS['tipo_cambio'] = $oDatos_generales->tipo_cambio;
//    $GLOBALS['vigv'] = $oDatos_generales->vigv;
//    $GLOBALS['dtComprobante_tipo'] = $dtComprobante_tipo;
//    $GLOBALS['dtEstado'] = $dtEstado;
}

//codigo ortega
function post_ajaxCbo_Vehiculo() {
    require ROOT_PATH . 'models/vehiculo.php';
    $dtVehiculo = vehiculo::getGrid('');

    $i = 1;
    $resultado = '<ul class="cbo-ul">';
    if (count($dtVehiculo) > 0) {
        foreach ($dtVehiculo as $ivehiculo) {
            $resultado.='<li id="li_' . $i . '"><span id="' . $ivehiculo['ID'] . '" title="' . FormatTextViewHtml($ivehiculo['descripcion']) . '">' . FormatTextViewHtml($ivehiculo['descripcion']) . '</span></li>';
            $i++;
        }
    }
    $resultado.='</ul>';

    $mensaje = '';
    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
    echo json_encode($retornar);
}

//codigo ortega
function post_ajaxCbo_Chofer() {
    require ROOT_PATH . 'models/chofer.php';
    $dtChofer = chofer::getGrid('');

    $i = 1;
    $resultado = '<ul class="cbo-ul">';
    if (count($dtChofer) > 0) {
        foreach ($dtChofer as $ichofer) {
            $resultado.='<li id="li_' . $i . '"><span id="' . $ichofer['ID'] . '" title="' . FormatTextViewHtml($ichofer['nombres']) . "  " . FormatTextViewHtml($ichofer['apellidos']) . '">a</span></li>';
            $i++;
        }
    }
    $resultado.='</ul>';

    $mensaje = '';
    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
    echo json_encode($retornar);
}


function post_ajaxCbo_Cliente1() {
    require ROOT_PATH . 'models/cliente.php';
    $dtCliente = cliente::getGrid();

    $i = 1;
    $resultado = '<ul class="cbo-ul">';
    if (count($dtCliente) > 0) {
        foreach ($dtCliente as $iCliente) {
            $resultado.='<li id="li_' . $i . '"><span id="' . $iCliente['ID'] . '" title="' . FormatTextViewHtml($iCliente['razon_social']) . '">' . FormatTextViewHtml($iCliente['razon_social']) . '</span></li>';
            $i++;
        }
    }
    $resultado.='</ul>';

    $mensaje = '';
    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
    echo json_encode($retornar);
}

function post_ajaxCbo_Cliente(){
    require ROOT_PATH.'models/cliente.php';
    require ROOT_PATH.'models/operador_cliente.php';
    $buscar=trim($_POST['txtBuscar']);
    $filtro='';
    if($buscar!=""){
        $filtro="upper(concat(clt.ruc,'',clt.razon_social)) like '%".strtoupper(FormatTextSave($buscar))."%'";
    
    }
     $dtCliente=cliente::getGrid($filtro,0,20,"clt.razon_social asc");
     
     $i=1;
     $resultado='<ul id="detalle" class="cbo-ul">';
     if(count($dtCliente)>0){			
        foreach($dtCliente as $iCliente){
            $dtOperador_Cliente=operador_cliente::getGrid('cliente_ID='.$iCliente['ID']);
            if(count($dtOperador_Cliente)>0){
                 $resultado.='<li id="li_'.$i.'"><span style="display:block;" onclick="fncCargaValores('.$iCliente['ID'].');" id="'.$iCliente['ID'].'" title="'.$iCliente['ruc'].'">'.$iCliente['ruc'].'-'.FormatTextViewHtml(strtoupper($iCliente['razon_social'])).'</span></li>';
            $i++;
            }
           
        }
     }
     $resultado.='</ul>';

     $mensaje='';
     $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);
     echo json_encode($retornar);
   }
function get_Vista_Cotizacion($id){
    require ROOT_PATH . 'models/producto.php';
    require ROOT_PATH . 'models/cotizacion.php';
    require ROOT_PATH . 'models/cotizacion_detalle.php';
   require ROOT_PATH . 'models/moneda.php';
    global  $returnView_float;
}
function get_Cotizacion_Quitar_Reservas(){
    require ROOT_PATH.'models/inventario.php';

    global  $returnView_float;
    $returnView_float=true;
   
    //$GLOBALS['mensaje']='';
}
function post_ajaxListar_Producto(){
    require ROOT_PATH.'models/producto.php';
    $linea_ID=$_POST['id'];
    $categoria_ID=$_POST['id1'];
    $buscar=$_POST['id2'];
    $filtro='';
    if($linea_ID!='0'){
        $filtro='li.ID='.$linea_ID;
    }
    if($categoria_ID!='0'){
        $filtro='pr.categoria_ID='.$categoria_ID;
    }
    if(trim($buscar)!=""){
        if($filtro!=''){
            $filtro.=' and ';
        }
        $filtro.='upper(pr.nombre) like "%'.strtoupper(FormatTextSave($buscar)).'%"';
    }
    $dtProducto=producto::getGrid($filtro);

    $i=1;
    $resultado='<ul class="cbo-ul">';
    if(count($dtProducto)>0){			
        foreach($dtProducto as $iProducto){
                $resultado.='<li id="li_'.$i.'" onclick="subirValorCaja(&#39;'.FormatTextViewHtml($iProducto['producto']).'&#39;,'.$iProducto['ID'].');"><span id="'.$iProducto['ID'].'" title="'.FormatTextViewHtml($iProducto['producto']).'">'.FormatTextViewHtml($iProducto['producto']).'</span></li>';
                $i++;
        }
    }
    $resultado.='</ul>';

    $mensaje='';
    $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);
    echo json_encode($retornar);
}
//post_ajaxActualzarDimension



function getaltoCelda($pdf,$y){
    //$y1=$pdf->GetY();
    $pdf->Ln(0);
    //$pdf->Cell(5,5,'',1,2);
    $y2=$pdf->GetY();
    $alto=$y2-$y;
    //$pdf->Write(1,$y);
    //$pdf->Write(1,$y2);
    return $alto;
}
function cotizacion_detalle($pdf,$oCotizacion,$h){
    
    $pdf->SetFont('Arial','',9);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetXY(10,88);
    $array=array();
    $alto_total=0;
    $numero_paginas_adicionar=0;
    $numero=1;
    $crear_pagina=0;
    $crear_contenedor_adicional=0;
    //Declaramos un array para guardar
    
    $dtCotizacion_Detalle=cotizacion_detalle::getGrid('cotizacion_ID='.$oCotizacion->ID.' and cotizacion_detalle_ID=0',-1,-1,'ID asc');
    $cantidad_total=cotizacion_detalle::getCount('cotizacion_ID='.$oCotizacion->ID.' and cotizacion_detalle_ID=0');
    $array_cotizacion_detalles=array();
    foreach ($dtCotizacion_Detalle as $fila){
        $pdf->SetX(10);
        $array_cotizacion_detalle=array();
        $pdf->SetWidths(array(10,120,15,20,25));
        $pdf->SetAligns(array('C','L','C','R','R'));
        $oProducto=producto::getByID($fila['producto_ID']);
        $precio_unitario=0;
        $subtotal=0;
        if($oCotizacion->moneda_ID==1){
            $precio_unitario=$fila['precio_venta_unitario_soles'];
            $subtotal=$fila['precio_venta_subtotal_soles'];
        }else {
            $precio_unitario=$fila['precio_venta_unitario_dolares'];
            $subtotal=$fila['precio_venta_subtotal_dolares'];
        }

    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(0);
    
    $alto=$pdf->Row(array($numero, FormatTextView($oProducto->nombre), $fila['cantidad'], number_format($precio_unitario,2,".",","),number_format($subtotal,2,".",",")),5);
    $alto_total=$alto_total+$alto;
    $yini=$pdf->GetY();
    
    //$pdf->Write(2,$alto);
    //Verificamos si tiene comentario
    $pdf->SetTextColor(99,98,98);
    $alto_descripcion=0;
    if(trim($fila['descripcion'])!=''){
        //$pdf->Ln(1);
        //$pdf->SetFillColor(255,255,255);
        $pdf->SetFont('Arial','',6);
        
        $pdf->SetX(20);
        $pdf->MultiCell(120,3,  utf8_encode($fila['descripcion']),0,'J',false);
        $alto_descripcion=getaltoCelda($pdf,$yini);
    }
    $alto_total=$alto_total+$alto_descripcion;
    //$pdf->Write(2,$alto_descripcion);
//Verificamos si el producto tiene componentes
    $dtCotizacion_detalle_componente=cotizacion_detalle::getGrid('cotizacion_detalle_ID='.$fila['ID'].' and tipo=3',-1,-1,'tipo asc,ID asc');
    $contador_ver_precio=cotizacion_detalle::getCount('cotizacion_detalle_ID='.$fila['ID'].' and tipo=3 and ver_precio=1');    
    
    if(count($dtCotizacion_detalle_componente)>0){
        if($alto_total>180){
        $alto_total=0;
        $pdf->contenedor_detalle(210,50);
        $pdf->AddPage();
        $pdf->SetXY(20,60);
        }
            $pdf->SetX(20);
            $pdf->SetFont('Arial','B',6);
            $ancho=70;
            if($contador_ver_precio==0){
                $ancho=100;
                $pdf->Cell(10,5,utf8_decode('#'),0,0,'C',false);
                $pdf->Cell($ancho,5,utf8_decode('PARTES'),0,0,'C',false);
                $pdf->Cell(10,5,utf8_decode('CANT'),0,0,'C',false);
            }else {
                $pdf->Cell(10,5,utf8_decode('#'),0,0,'C',false);
                $pdf->Cell($ancho,5,utf8_decode('PARTES'),0,0,'C',false);
                $pdf->Cell(10,5,utf8_decode('CANT'),0,0,'C',false);
                $pdf->Cell(15,5,utf8_decode('P/U'),0,0,'R',false);
                $pdf->Cell(15,5,utf8_decode('TOTAL'),0,0,'R',false);
            }
            $alto_total=$alto_total+5;
            
            $pdf->Ln(4);
            $item=1;
            $pdf->SetAligns(array('C','L','C','R','R'));
            $pdf->SetWidths(array(10,$ancho,10,15,15));
            foreach($dtCotizacion_detalle_componente as $value){
                $pdf->SetFont('Arial','B',6);
                $pdf->SetX(20);
                $oProducto1=producto::getByID($value['producto_ID']);
                    $precio_unitario1=0;
                    $subtotal1=0;
                    if($value['ver_precio']==1){
                        if($oCotizacion->moneda_ID==1){
                        $precio_unitario1=number_format($value['precio_venta_unitario_soles'],2,".",",");
                        $subtotal=number_format($value['precio_venta_subtotal_soles'],2,".",",");
                        }else {
                            $precio_unitario1=number_format($value['precio_venta_unitario_dolares'],2,".",",");
                            $subtotal1=number_format($value['precio_venta_subtotal_dolares'],2,".",",");
                        }
                    }else {
                        $precio_unitario1='';
                        $subtotal1='';
                    }
                    if($alto_total>180){
                        $alto_total=0;
                        $pdf->contenedor_detalle(210,50);
                        $pdf->AddPage();
                        $pdf->SetXY(20,57);
                    }
                    
                    $pdf->SetTextColor(99,98,98);
                    $pdf->SetFont('Arial','B',6);
                    $alto_total=$alto_total+$pdf->Row(array($item, FormatTextView($oProducto1->nombre), $value['cantidad'], $precio_unitario1,$subtotal1),3);
                    
                    $yini1=$pdf->GetY();
                    if(trim($value['descripcion'])!=''){
                        $pdf->SetFont('Arial','',6);
                        //$pdf->Ln(2);
                        $pdf->SetX(30);
                        $pdf->MultiCell($ancho,3,  utf8_encode($value['descripcion']),0,'J',false);
                        
                        $alto_total=$alto_total+getaltoCelda($pdf,$yini1);
                    }
                    
                    $pdf->Ln(1);
                    $alto_total=$alto_total+1;
                $item++;
                } 
                $pdf->Ln(2);
                $alto_total=$alto_total+2;
               
        }
       
    
        if($alto_total>150){
            
           
            //$pdf->WriteHTML('Page 2');
            if($crear_pagina==0){
                $pdf->contenedor_detalle(170,80);
                $pdf->AddPage();
                $pdf->SetXY(10,57);
                $alto_total=0;
                 $crear_contenedor_adicional++;
            }else  {
                //$pdf->Write(2,$numero);
                if($alto_total>180){
                    
                    $pdf->contenedor_detalle(210,50);
                    //$pdf->costo_total($alto_total+57);
                    $pdf->AddPage();
                    
                    $pdf->SetXY(10,57);
                    $alto_total=0;
                    $crear_contenedor_adicional++;
                }else if($numero==$cantidad_total){
                    $pdf->contenedor_detalle($alto_total,50);
                    $pdf->costo_total($alto_total+57);
                    $crear_contenedor_adicional++;
                }
                
                //$pdf->costo_total($alto_total);
            }
            //$pdf->contenedor_detalle(80,50);
            
            $crear_pagina++;
        }else if($numero==$cantidad_total){
            if($crear_pagina>0){
                $pdf->contenedor_detalle($alto_total,50);
                $pdf->costo_total($alto_total+57);
            }else {
                //$pdf->SetXY();
                $pdf->contenedor_detalle(120,80);
                //$pdf->costo_total(122);
            }
            
            //$crear_contenedor_adicional++;
        }
        $numero++;
    }
    if($alto_total>120 && $crear_pagina==0){
        $numero_paginas_adicionar++;      
    }
    //$pdf->Write(2,$alto_total);
    $array['alto_total']=$alto_total;
    $array['numero_paginas_adicionar']=$numero_paginas_adicionar;
    $array['crear_contenedor_adicional']=$crear_contenedor_adicional;
    return $array;
}
function post_ajaxPrinter(){
    $html = FormatTextViewHtml('<h1>".Test de Impresión de Tickets."</h1>');

//$html = 'HOLA MUNDO';

$printer='PDFCreator';

$enlace=printer_open($printer);

printer_write($enlace, $html);

printer_close($enlace);
    /*$handle = printer_open("PDFCreator"); 
    printer_start_doc($handle, "My Document"); 
    printer_start_page($handle); 

    $font = printer_create_font("Arial",72,48,400,false,false, false,0); 
    printer_select_font($handle, $font); 
    printer_draw_text($handle, "<h1>Hola</h1>", 10, 10); 
    printer_delete_font($font); 

    printer_end_page($handle); 
    printer_end_doc($handle); 
    printer_close($handle); 
/*
    $printer = "PDFCreator";
    //phpinfo();
    $handle = printer_open($printer);
    printer_set_option($handle, PRINTER_MODE, "raw");
    printer_set_option($handle, PRINTER_PAPER_FORMAT, PRINTER_FORMAT_A4);
    $output = "Print Contents";
    printer_write($handle,$output);
    printer_close($handle);*/
}