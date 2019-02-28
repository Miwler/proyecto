<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/*hola miwlerr/ajaxCotizacion_Detalle_Productos
/**de
 * Description of ventasController
 *
 * @author miwler
 */
    //date_default_timezone_set('UTC');
    function get_Index($id){
        global $returnView;
        $returnView=true;
    }
//=============================================================
//INICIO DE COTIZACIONES
//PRUEBA
function get_Cotizacion_Mantenimiento(){
    require ROOT_PATH.'models/cotizacion.php';
    require ROOT_PATH.'models/moneda.php';
    require ROOT_PATH.'models/cliente.php';
    require ROOT_PATH.'models/estado.php';
    global  $returnView;
    $returnView=true;
    $oCotizacion=new cotizacion;
    $dtCliente=cliente::getGrid('',-1,-1,'clt.razon_social ASC');
    $dtMoneda=moneda::getGrid();
    $dtEstado=estado::getGrid('tabla="cotizacion"');
    $GLOBALS['dtCliente']=$dtCliente;
    $GLOBALS['dtMoneda']=$dtMoneda;
    $GLOBALS['dtEstado']=$dtEstado;
    //$GLOBALS['mensaje']='';
}
function post_ajaxCotizacion_Mantenimiento() {
    require ROOT_PATH . 'models/cotizacion.php';
    require ROOT_PATH . 'models/cotizacion_detalle.php';
    require ROOT_PATH . 'models/producto.php';
    require ROOT_PATH . 'models/moneda.php';
    require ROOT_PATH . 'models/estado.php';
    require ROOT_PATH . 'controls/funcionController.php';
    //$buscar = $_POST['txtBuscar'];
    $paginaActual = $_POST['num_page'] == 0 ? 1 : $_POST['num_page'];
    $cantidadMostrar = $_POST['txtMostrar'] == '' ? 30 : $_POST['txtMostrar'];
    $opcion_tipo=$_POST['rbOpcion'];
    $txtOrden = $_POST['txtOrden'];
    $orden_tipo = 'DESC';
    $orden_class = 'imgOrden-desc';
    $cliente_ID=$_POST['selCliente'];
    $estado_ID=$_POST['selEstado'];
    $fecha_inicio=$_POST['txtFechaInicio'];
    $fecha_fin=$_POST['txtFechaFin'];

    $numero=Ltrim($_POST['txtNumero'],'0');
    $periodo=ltrim($_POST['txtPeriodo'],'0');
    $moneda=$_POST['selMoneda'];

    if (isset($_POST['chkOrdenASC'])) {
        $orden_class = 'imgOrden-asc';
        $orden_tipo = 'ASC';
    }
    $todos=0;
    if(isset($_POST['ckTodos'])){
        $todos=$_POST['ckTodos'];
    }
    switch ($txtOrden) {
        case 1:
            $orden = 'co.numero_concatenado ' . $orden_tipo;
            break;
        case 2:
            $orden = 'co.fecha ' . $orden_tipo;
            break;
        case 3:
            $orden = 'cl.razon_social ' . $orden_tipo;
            break;
        case 4:
            $orden = 'co.moneda_ID ' . $orden_tipo;
            break;
        case 5:
            $orden = 'co.precio_venta_total_soles ' . $orden_tipo;
            break;
        case 6:
            $orden = 'co.precio_venta_total_dolares ' . $orden_tipo;
            break;
        case 7:
            $orden = 'es.nombre ' . $orden_tipo;
            break;

        default:
            $orden = 'co.ID ' . $orden_tipo;
            break;
    }
    $filtro="co.empresa_ID=".$_SESSION['empresa_ID'];
    if($opcion_tipo=="buscar"){
        if(trim($periodo)!=""){
            if($filtro!=""){
                $filtro.=" and ";
            }
            $filtro="co.periodo=". $periodo;
        }
        if(trim($numero)!=""){
            if($filtro!=""){
                $filtro.=" and ";
            }
            $filtro="co.numero=".$numero;
        }

    }else {

        if($cliente_ID!=0){
            if($filtro!=""){
                $filtro.=" and ";
            }
        $filtro.="co.cliente_ID=".$cliente_ID ;
        }
        if($estado_ID!=0){
            if($filtro!=""){
                $filtro.=" and ";
            }
            $filtro.="co.estado_ID=".$estado_ID;
        }
        if($todos==0){
            if($fecha_inicio!="" &&$fecha_fin!="" ){
                if($filtro!=""){
                    $filtro.=" and ";
                }
                $filtro.=" co.fecha between '".FormatTextToDate($fecha_inicio,'Y-m-d')."' and '".FormatTextToDate($fecha_fin,'Y-m-d')."'" ;


            }
        }

        if($moneda>0){
            if($filtro!=""){
                $filtro.=" and ";
            }
            $filtro.="co.moneda_ID=".$moneda;
        }
    }

    // $filtro.= 'upper(concat(cl.razon_social," ",cl.ruc)) like "%' . str_replace(' ', '%', strtoupper(FormatTextSave($buscar))) . '%"';

    //---------------------------------------
    $resultado = '<table id="websendeos" class="grid table table-hover table-bordered"><thead><tr>';
    $resultado.='<th class="text-center">N°</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(1);">Número' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(2);">Fecha' . (($txtOrden == 2 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(3);">Cliente' . (($txtOrden == 3 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(4);">Moneda' . (($txtOrden == 4 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(5);">Monto S/.' . (($txtOrden == 5 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(6);">Monto $' . (($txtOrden == 6 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(7);">Estado' . (($txtOrden == 7 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" ">Detalle' . (($txtOrden == 7 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th></th>';
    $resultado.='</tr></thead><tbody>';

    $colspanFooter = 10;
    try {
        $cantidadMaxima = cotizacion::getCount($filtro);
        $dtCotizacion = cotizacion::getGrid1($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
        $rows = count($dtCotizacion);

        $clase="";
        $y=($paginaActual-1)*$cantidadMostrar+1;
        foreach ($dtCotizacion as $item) {

            switch ($item['estado_ID']){
                case 1:
                    //En proceso

                    $clase=" trEnproceso";
                    break;
                case 2://Registrado

                    $clase=" trRegistrado";
                    break;
                case 23://Para revision

                    $clase=" trParaRevision";
                    break;
                case 25://Ganadas

                    $clase=" trGanadas";
                    break;
            }
            $dtCotizacion_Detalle=  cotizacion_detalle::getGrid("cotizacion_ID=".$item['ID'],-1,-1,"ID asc");
            $lista_producto="";
            $i=0;
            
            foreach($dtCotizacion_Detalle as $value){

                if($i==0){
                    $oProducto=producto::getByID($value["producto_ID"]);
                    if($oProducto!=null){
                        $lista_producto=FormatTextView($oProducto->nombre);
                    }else{
                    $lista_producto="";
                    }
                }

                $i++;
            }
            $oMoneda=moneda::getByID($item['moneda_ID']);

            $resultado.='<tr class="tr-item '.$clase.'" >';
            $resultado.='<td class="text-center">' . $y . '</td>';
            $resultado.='<td class="text-center">' . $item['numero_concatenado'] . '</td>';
            $resultado.='<td class="text-center">' . $item['fecha']. '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextView(strtoupper($item['razon_social'])) . '</td>';
            $resultado.='<td class="text-center">' . FormatTextView($item['simbolo']) . '</td>';
            $resultado.='<td class="text-right">' . $item['precio_venta_total_soles'] . '</td>';
            $resultado.='<td class="text-right">' . $item['precio_venta_total_dolares'] . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextView(strtoupper($item['estado'])) . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextView(strtoupper($lista_producto)) . '</td>';
            $botones=array();
            $boton='<a onclick="fncEditar(' . $item['ID'] . ');"><img title="Editar" src="/include/img/boton/edit_14x14.png" />Editar</a>';
            if($item['estado_ID']==25){
                 $boton='<a onclick="fncEditar(' . $item['ID'] . ');"><img title="Editar" width="14px" src="/include/img/boton/preview-16.png" />Ver detalle</a>';
            }
            array_push($botones,$boton);
            array_push($botones,'<a onclick="fncClonar(' . $item['ID'] . ');"><img title="Clonar" src="/include/img/boton/clone16.png" />Clonar</a>');
            if($item['estado_ID']!=25){
                array_push($botones,'<a onclick="fncEliminar(' . $item['ID'] . ');"><img title="Eliminar" src="/include/img/boton/delete_14x14.png" />&nbsp;Eliminar</a>');
            }

            $resultado.='<td class="text-center" >'.extraerOpcion($botones)."</td>";
            $resultado.='</tr>';
            $color="#fff";
            $y++;
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
        require ROOT_PATH.'controls/funcionController.php';
        global  $returnView_float;
        $returnView_float=true;
	//$oCliente=new cliente();
        $oOperador=new operador();
        $oCotizacion=new cotizacion;
        $oCotizacion->moneda_ID=2;
        $oCotizacion->plazo_entrega=2;
        $oCotizacion->validez_oferta="7";
        $oCotizacion->garantia="1 año";
        $oCotizacion->estado_ID=1;
        $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
        $dtForma_Pago=forma_pago::getGrid();
        $dtCredito=credito::getGrid('id<>0');
        $dtEstado=estado::getGrid('est.ID in (1,2)',-1,-1,'orden asc');
        $oCotizacion->observacion=$oDatos_Generales->observacion;
        $oCotizacion->tipo_cambio=$oDatos_Generales->tipo_cambio;
        $oCotizacion->ID=0;
        $GLOBALS['oCliente']=new cliente();
        $GLOBALS['dtCliente']=cliente::getGrid("",-1,-1,"clt.razon_social asc");
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
    require ROOT_PATH.'models/cliente_contacto.php';
    require ROOT_PATH.'models/operador.php';
    require ROOT_PATH.'models/datos_generales.php';
    require ROOT_PATH.'models/forma_pago.php';
    require ROOT_PATH.'models/credito.php';
    require ROOT_PATH.'models/numero_cuenta.php';
    require ROOT_PATH.'models/cotizacion_numero_cuenta.php';
    require ROOT_PATH.'controls/funcionController.php';
    global  $returnView_float;
    $returnView_float=true;
    $cotizacion_ID=$_POST['txtCotizacion_ID'];
    $cliente_ID=$_POST['selCliente'];
    $cliente_contacto_ID=$_POST['selRepresentante'];
    if($cliente_contacto_ID=="--"){
        $cliente_contacto_ID=0;
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
    $tardanza=$_POST['txtTiempo_Avance'];
    $plazo_entrega=$_POST['txtPlazo_Entrega'];
    //$estado_ID=1;
    $tipo_cambio=$_POST['txtTipo_Cambio'];
    $lugar_entrega=$_POST['txtLugar_Entrega'];
    $validez_oferta=$_POST['txtValidez_Oferta'];
    $garantia=$_POST['txtGarantia'];
    $observacion=$_POST['txtObservacion'];
    $estado_ID=$_POST['selEstado'];
    try{
        if($cotizacion_ID==0){
            $oCotizacion=new cotizacion;
        }else {
            $oCotizacion=cotizacion::getByID($cotizacion_ID);
        }

        $oCotizacion->cliente_ID=$cliente_ID;
        $oCotizacion->empresa_ID=$_SESSION['empresa_ID'];
        $oCotizacion->cliente_contacto_ID=$cliente_contacto_ID;
        $oCotizacion->operador_ID=$operador_ID;
        $oCotizacion->periodo=$periodo;
        $oCotizacion->moneda_ID=$moneda_ID;
        $oCotizacion->fecha=$fecha;
        $oCotizacion->forma_pago_ID=$forma_pago_ID;
        $oCotizacion->tiempo_credito=$tiempo_credito;
        $oCotizacion->tardanza=$tardanza;
        $oCotizacion->plazo_entrega=$plazo_entrega;
        $oCotizacion->estado_ID=$estado_ID;
        $oCotizacion->tipo_cambio=$tipo_cambio;
        $oCotizacion->lugar_entrega=$lugar_entrega;
        $oCotizacion->validez_oferta=$validez_oferta;
        $oCotizacion->garantia=$garantia;
        $oCotizacion->observacion=$observacion;

        $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
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
            $mensaje=$oCotizacion->getMessage;
            $resultado=1;
        } else {
            $oCotizacion->usuario_mod_id=$_SESSION['usuario_ID'];
            $oCotizacion->actualizar();
            $oCotizacion->getByID($cotizacion_ID);
            $mensaje=$oCotizacion->getMessage;
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
        $oOperador->nombres_completo="Sin vendedor asignado";

        $oOperador->telefono="--";
        $oOperador->celular="-";


    }else {
        $oOperador=new operador();
        $oOperador=operador::getByID($operador_ID);
    }
    $dtEstado=estado::getGrid('est.ID in (1,2)');
    $dtCliente_Contacto=cliente_contacto::getGrid('clic.cliente_ID='.$cliente_ID);
    $dtNumero_Cuenta=$dtNumero_Cuenta=numero_cuenta::getGrid('moneda_ID='.$oCotizacion->moneda_ID);
    $GLOBALS['dtNumero_Cuenta']=mostrarNumeroCuentas(2,$oCotizacion->moneda_ID,$oCotizacion,null);
    $GLOBALS['oCotizacion']=$oCotizacion;
    $GLOBALS['oCliente']=$oCliente;
    $GLOBALS['dtCliente']=cliente::getGrid("",-1,-1,"clt.razon_social asc");
    $GLOBALS['dtCliente_Contacto']=$dtCliente_Contacto;
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
function post_ajaxCotizacion_Detalle_Cliente(){
    require ROOT_PATH.'models/cliente.php';
    require ROOT_PATH.'models/cliente_contacto.php';
    require ROOT_PATH.'models/forma_pago.php';
    require ROOT_PATH.'models/operador.php';
    require ROOT_PATH.'models/operador_cliente.php';
    require ROOT_PATH.'models/persona.php';
    $cliente_ID=$_POST['id'];
    $operador_ID="";
            $operador="Vendedor no asignado";
            $operador_telefono="--";
            $operador_celular1="--";
    try{
        $oCliente=cliente::getByID($cliente_ID);
        $Telefono=$oCliente->telefono;
        $Direccion=utf8_encode($oCliente->direccion);
        $Tiempo_Credito=utf8_encode($oCliente->tiempo_credito);
        $dtRepresentante=cliente_contacto::getGrid('clic.cliente_ID='.$cliente_ID);
        $ListaRepresentate='';
        if($dtRepresentante != null){
            foreach($dtRepresentante as $irepresentante){
                $ListaRepresentate.='<option value="'.$irepresentante['ID'].'">'.utf8_encode(strtoupper($irepresentante['apellido_paterno']).' '.strtoupper($irepresentante['apellido_materno'])).', '.utf8_encode(strtoupper($irepresentante['nombres'])).'</option>';
            }
        }else{$ListaRepresentate="<option value='0'>--</option>";}
        $forma_pago_ID=$oCliente->forma_pago_ID;

        $oForma_pago=forma_pago::getByID($forma_pago_ID);
        $Forma_pago=$oForma_pago->ID;

        $oOperador_Cliente=operador_cliente::getByOperador($cliente_ID);
        
        if($oOperador_Cliente!=null){
            $operador_ID=$oOperador_Cliente->operador_ID;
            $oOperador=operador::getByID($operador_ID);
            //print_r($oOperador);
            $oPersona=persona::getByID($oOperador->persona_ID);
            $operador=utf8_encode($oPersona->apellido_paterno.' '.$oPersona->apellido_materno.', '.$oPersona->nombres);
            $operador_telefono=$oOperador->telefono;
            $operador_celular1=$oOperador->celular;

        }else{
            $operador_ID="";
            $operador="Vendedor no asignado";
            $operador_telefono="--";
            $operador_celular1="--";
        }
        $resultado=1;
    } catch (Exception $ex) {
        $mensaje=$ex->getMessage();
        $resultado=-1;
        log_error(__FILE__, "salida/post_ajaxCotizacion_Detalle_Cliente", $ex->getMessage());
    }
    if(!isset($mensaje)){
        $mensaje='';
    }

    $retornar=Array('Telefono'=>$Telefono,'Direccion'=>$Direccion,
        'Forma_pago'=>$Forma_pago,'Tiempo_Credito'=>$Tiempo_Credito,'mensaje'=>$mensaje,'lista_representante'=>$ListaRepresentate,'operador_ID'=>$operador_ID,'operador'=>$operador,
        'operador_telefono'=>$operador_telefono,'operador_celular1'=>$operador_celular1,
        'resultado'=>$resultado);
    //$retorn="<h1>Hola</h1>";

    echo json_encode($retornar);
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
    //$dtProducto=producto::getGrid('',-1,-1,"pr.nombre asc");
    $oCotizacion_Detalle=new cotizacion_detalle();
    $oCotizacion_Detalle->ID=0;
    //$oCotizacion_Detalle->descripcion="";
    $oCotizacion_Detalle->categoria_ID=0;
    $oCotizacion_Detalle->linea_ID=0;
    $oCotizacion_Detalle->producto_ID=0;
    $oCotizacion=cotizacion::getByID($id);

    $oCotizacion_Detalle->tipo_ID=1;
    $oCotizacion_Detalle->adicional=0;
    $oCotizacion_Detalle->componente=0;
    $oInventario=new inventario();
    $GLOBALS['linea_ID']=0;
    $GLOBALS['categoria_ID']=0;
    //$GLOBALS['dtProducto']=producto::getGrid("",-1,-1,"pr.nombre asc");
    //$GLOBALS['listaProducto']=producto::getLista("");
    $GLOBALS['dtCategoria']=$dtCategoria;
    $GLOBALS['dtLinea']=$dtLinea;
    //$GLOBALS['dtProducto']=$dtProducto;
    $GLOBALS['oCotizacion_Detalle']=$oCotizacion_Detalle;
    $GLOBALS['oCotizacion']=$oCotizacion;
    $GLOBALS['oInventario']=$oInventario;
    $GLOBALS['oProducto']=new producto();
}
function post_cotizacion_mantenimiento_producto_nuevo($id){
    require ROOT_PATH . 'controls/funcionController.php';
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
    $producto_ID=$_POST['selProducto'];
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
        $tiempo_separacion=$_POST['txtTiempo_Separacion'];
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
        $oCotizacion_Detalle->tipo_ID=$tipo;
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

        $dtCotizacion_Detalle=cotizacion_detalle::getGrid('cotizacion_ID='.$id.' and cotizacion_detalle_ID=0 and tipo_ID in (1,2,5,6)');
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
    //$GLOBALS['listaProducto']=producto::getLista("");
    $GLOBALS['oInventario']=$oInventario;
    $oCotizacion=cotizacion::getByID($id);
    $GLOBALS['oCotizacion']=$oCotizacion;
    $GLOBALS['oCotizacion_Detalle']=$oCotizacion_Detalle;
    $GLOBALS['resultado']=$resultado;
    $GLOBALS['mensaje']=  $mensaje;

}
function post_ajaxActualzarDimension(){
    require ('./controls/cotizacion1_pdfController.php');
    require ROOT_PATH.'models/cotizacion.php';
    require ROOT_PATH.'models/moneda.php';
    require ROOT_PATH.'models/cotizacion_detalle.php';
    require ROOT_PATH.'models/producto.php';
    if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";;
    require ROOT_PATH . 'models/cliente.php';
    require ROOT_PATH . 'include/lib_fecha_texto.php';
    require ROOT_PATH . 'models/cliente_contacto.php';
    require ROOT_PATH . 'models/forma_pago.php';
    require ROOT_PATH . 'models/operador.php';
    require ROOT_PATH . 'models/cotizacion_numero_cuenta.php';
    $id=$_POST['id'];
    $cotizacion_ID=$id;
    $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
    $oCotizacion=cotizacion::getByID($cotizacion_ID);
    $cantidad_detalle=cotizacion_detalle::getCount('cotizacion_ID='.$cotizacion_ID);
    $altura=500;
    if($cantidad_detalle>20){
        $altura=1000;
    }
    $pdf= new PDF1('P','mm',array(200,$altura));
    $pdf->oCotizacion=$oCotizacion;
    $pdf->oDatos_Generales=$oDatos_Generales;
    $pdf->AliasNbPages();
    $pdf->AddPage();
    //$pdf->MultiCell(100,5,'dede',1);
   try{

        $dtCotizacion_Detalle=cotizacion_detalle::getGrid('cotizacion_ID='.$oCotizacion->ID.' and cotizacion_detalle_ID=0',-1,-1,'ID asc');
        $cantidad_total=cotizacion_detalle::getCount('cotizacion_ID='.$oCotizacion->ID.' and cotizacion_detalle_ID=0');
        $pdf->SetY(10);
        $altura_item=array();
        $ubicacion_anterior=10;

        foreach($dtCotizacion_Detalle as $fila ){

            $pdf->SetFont('Arial','B',8);
            $oProducto=producto::getByID($fila['producto_ID']);
            $pdf->SetAligns(array('L'));
            $pdf->SetWidths(array(120));
            $pdf->Row(array(FormatTextView($oProducto->nombre)),5);
            if(trim($fila['descripcion'])!=''){

                $pdf->SetFont('Arial','',6);
                $pdf->MultiCell(120,3,  utf8_encode($fila['descripcion']),0,'J',false);

            }
            //$altura_item['cotizacion_detalle_ID']=$fila['ID'];
            $ubicacionY=$pdf->GetY();
            //$altura_item['ID']=$fila['ID'];
            //$altura_item=array();
            $altura_item[$fila['ID']]=$ubicacionY-$ubicacion_anterior;

            $ubicacion_anterior=$ubicacionY;
            $dtCotizacion_detalle_componente=cotizacion_detalle::getGrid('cotizacion_detalle_ID='.$fila['ID'].' and tipo_ID=3',-1,-1,'tipo_ID asc,ID asc');
            $contador_ver_precio=cotizacion_detalle::getCount('cotizacion_detalle_ID='.$fila['ID'].' and tipo_ID=3 and ver_precio=1');


            if(count($dtCotizacion_detalle_componente)>0){
                $pdf->SetFont('Arial','B',6);
                if($contador_ver_precio==0){
                    $ancho=100;
                    $pdf->Cell(10,5,utf8_decode('#'),0,0,'C',false);
                    $pdf->Cell($ancho,5,utf8_decode('PARTES'),0,0,'C',false);
                    $pdf->Cell(10,5,utf8_decode('CANT'),0,0,'C',false);
                }else {
                    $ancho=70;
                    $pdf->Cell(10,5,utf8_decode('#'),0,0,'C',false);
                    $pdf->Cell($ancho,5,utf8_decode('PARTES'),0,0,'C',false);
                    $pdf->Cell(10,5,utf8_decode('CANT'),0,0,'C',false);
                    $pdf->Cell(15,5,utf8_decode('P/U'),0,0,'R',false);
                    $pdf->Cell(15,5,utf8_decode('TOTAL'),0,0,'R',false);
                }
                $pdf->Ln(4);
                $pdf->SetAligns(array('C','L','C','R','R'));
                $pdf->SetWidths(array(10,$ancho,10,15,15));
                $altura_item_hijo=array();
                foreach($dtCotizacion_detalle_componente as $valor){
                    $pdf->SetFont('Arial','B',6);
                    $oProducto1=producto::getByID($valor['producto_ID']);
                    $precio_unitario1=0;
                    $subtotal1=0;
                    if($valor['ver_precio']==1){

                        if($oCotizacion->moneda_ID==1){
                        $precio_unitario1=number_format($valor['precio_venta_unitario_soles'],2,".",",");
                        $subtotal=number_format($valor['precio_venta_subtotal_soles'],2,".",",");
                        }else {
                            $precio_unitario1=number_format($valor['precio_venta_unitario_dolares'],2,".",",");
                            $subtotal1=number_format($valor['precio_venta_subtotal_dolares'],2,".",",");
                        }
                   }else {
                       $precio_unitario1='';
                       $subtotal1='';
                   }
                   $pdf->SetFont('Arial','B',6);
                   $pdf->Row(array(1, FormatTextView($oProducto1->nombre), $valor['cantidad'], $precio_unitario1,$subtotal1),3);
                    if(trim($valor['descripcion'])!=''){
                        $pdf->SetFont('Arial','',6);
                        $pdf->MultiCell($ancho,3,  utf8_encode($valor['descripcion']),0,'J',false);

                    }
                    $pdf->Ln(1);
                    //$altura_item_hijo['ID']=$valor['ID'];

                    $altura_item[$valor['ID']]=$pdf->GetY()-$ubicacion_anterior;
                   $ubicacion_anterior=$pdf->GetY();
                }


            }
            //Adicionales
            $dtCotizacion_detalle_adicionales=cotizacion_detalle::getGrid('cotizacion_detalle_ID='.$fila['ID'].' and tipo_ID=4',-1,-1,'tipo_ID asc,ID asc');
            $contador_ver_precio=cotizacion_detalle::getCount('cotizacion_detalle_ID='.$fila['ID'].' and tipo_ID=4 and ver_precio=1');


            if(count($dtCotizacion_detalle_adicionales)>0){
                $pdf->SetFont('Arial','B',6);
                if($contador_ver_precio==0){
                    $ancho=100;
                    $pdf->Cell(10,5,utf8_decode('#'),0,0,'C',false);
                    $pdf->Cell($ancho,5,utf8_decode('ADICIONAL'),0,0,'C',false);
                    $pdf->Cell(10,5,utf8_decode('CANT'),0,0,'C',false);
                }else {
                    $ancho=70;
                    $pdf->Cell(10,5,utf8_decode('#'),0,0,'C',false);
                    $pdf->Cell($ancho,5,utf8_decode('ADICIONAL'),0,0,'C',false);
                    $pdf->Cell(10,5,utf8_decode('CANT'),0,0,'C',false);
                    $pdf->Cell(15,5,utf8_decode('P/U'),0,0,'R',false);
                    $pdf->Cell(15,5,utf8_decode('TOTAL'),0,0,'R',false);
                }
                $pdf->Ln(4);
                $pdf->SetAligns(array('C','L','C','R','R'));
                $pdf->SetWidths(array(10,$ancho,10,15,15));
                $altura_item_hijo=array();
                foreach($dtCotizacion_detalle_adicionales as $valor){
                    $pdf->SetFont('Arial','B',6);
                    $oProducto1=producto::getByID($valor['producto_ID']);
                    $precio_unitario1=0;
                    $subtotal1=0;
                    if($valor['ver_precio']==1){

                        if($oCotizacion->moneda_ID==1){
                        $precio_unitario1=number_format($valor['precio_venta_unitario_soles'],2,".",",");
                        $subtotal=number_format($valor['precio_venta_subtotal_soles'],2,".",",");
                        }else {
                            $precio_unitario1=number_format($valor['precio_venta_unitario_dolares'],2,".",",");
                            $subtotal1=number_format($valor['precio_venta_subtotal_dolares'],2,".",",");
                        }
                   }else {
                       $precio_unitario1='';
                       $subtotal1='';
                   }
                   $pdf->SetFont('Arial','B',6);
                   $pdf->Row(array(1, FormatTextView($oProducto1->nombre), $valor['cantidad'], $precio_unitario1,$subtotal1),3);
                    if(trim($valor['descripcion'])!=''){
                        $pdf->SetFont('Arial','',6);
                        $pdf->MultiCell($ancho,3,  utf8_encode($valor['descripcion']),0,'J',false);

                    }
                    $pdf->Ln(1);
                    //$altura_item_hijo['ID']=$valor['ID'];

                    $altura_item[$valor['ID']]=$pdf->GetY()-$ubicacion_anterior;
                   $ubicacion_anterior=$pdf->GetY();
                }


            }

        }

        $alto_total=$pdf->GetY()-10;
        $altura_contenedor_unico=110;
        $altura_contenedor_intermedio=180;
        $altur_contenedor_final=140;
        $altura=0;
        $pagina=1;
        $pagina_detalle=1;
        $orden=1;
        $IDS="";
        $opcion=1;
        $op=0;
        $contador=0;
        while($alto=current($altura_item)){
            $IDS.="/".key($altura_item);
            $oCotizacion_Detalle1=cotizacion_detalle::getByID(key($altura_item));

            $altura=$altura+$alto;
            if($opcion==1){
                if($altura>110){
                    if($pagina==1){
                         $pagina++;
                    }

                    if($altura>140){
                        $opcion++;
                        $pagina_detalle++;
                        $orden=1;
                        $altura=0;
                    }
                }
            }else {
                if($altura>140){
                    if($op!=$pagina){
                       $pagina++;
                       $op=$pagina;
                    }

                    if($altura>170){
                        $op=0;
                        $pagina_detalle++;
                        $orden=1;
                        $altura=0;
                    }

                }
            }


            $oCotizacion_Detalle1->orden_cotizacion=$orden;
            $oCotizacion_Detalle1->pagina_cotizacion=$pagina_detalle;
            $oCotizacion_Detalle1->actualizarDimension();
            $orden=$orden+1;
            $oCotizacion=cotizacion::getByID($oCotizacion_Detalle1->cotizacion_ID);
            $oCotizacion->numero_pagina=$pagina;
            $oCotizacion->actualizar_pagina();
            //$altura="/".$orden;

           next($altura_item);

        }
        $resultado=1;
        $mensaje="";
   } catch(Exception $ex){
       $resultado=-1;
       $mensaje=$ex->getMessage();
       //$pdf->MultiCell(50,5,$ex->getMessage(),1);
   }
   // $pdf->Output('cotizacion_Nro.pdf','D');
    $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);
    echo json_encode($retornar);
}
function separarProductoCotizacion($oCotizacion_Detalle,$producto_ID_old){

        try{

            $cantidades_separados=inventario::getCount('cotizacion_detalle_ID='.$oCotizacion_Detalle->ID);
            $limpiar=0;
            if($oCotizacion_Detalle->tipo_ID==2||$oCotizacion_Detalle->tipo_ID==5){
                $limpiar=1;
            }
            //Eliminamos cantidades separadas
            if(($oCotizacion_Detalle->separacion==0&&$cantidades_separados>0)||$producto_ID_old!=$oCotizacion_Detalle->producto_ID|| $limpiar==1){
                $dtInventario=inventario::getGrid('cotizacion_detalle_ID='.$oCotizacion_Detalle->ID,-1,-1);
                foreach($dtInventario as $item){
                    $oInventario=inventario::getByID($item['ID']);
                    $oInventario->usuario_mod_id=$_SESSION['usuario_ID'];
                    //Devolvemos los productos al estado en stock
                    $oInventario->cotizacion_detalle_ID='NULL';
                    $oInventario->estado_ID=48;
                    $oInventario->actualizar();
                }
                $oCotizacion_Detalle->cantidad_separada=0;
                $oCotizacion_Detalle->usuario_mod_id=$_SESSION['usuario_ID'];
                $oCotizacion_Detalle->actualizar();
            }
            if($oCotizacion_Detalle->separacion==1&&$limpiar==0){
                $exedente=$oCotizacion_Detalle->cantidad-$cantidades_separados;
                $cantidadxseparar=abs($exedente);

                if($exedente>0){
                    //Agregarmos los productos a separar
                    $dtInventario1=inventario::getGrid('producto_ID='.$oCotizacion_Detalle->producto_ID.' and estado_ID=48',0,$exedente,'ID asc');
                    $contador=0;
                    foreach($dtInventario1 as $value){
                        $oInventario1=inventario::getByID($value['ID']);
                        $oInventario1->estado_ID=51;
                        $oInventario1->usuario_mod_id=$_SESSION['usuario_ID'];
                        $oInventario1->cotizacion_detalle_ID=$oCotizacion_Detalle->ID;
                        $oInventario1->actualizar();
                        $contador++;
                    }
                    $oCotizacion_Detalle->cantidad_separada=$oCotizacion_Detalle->cantidad_separada+$contador;
                    $oCotizacion_Detalle->usuario_mod_id=$_SESSION['usuario_ID'];
                    $oCotizacion_Detalle->actualizar();
                }else if($exedente<0){
                    //Liberamos productos que estaban separados
                    $dtInventario2=inventario::getGrid('cotizacion_detalle_ID='.$oCotizacion_Detalle->ID,0,abs($exedente),'ID desc');
                    $contador=0;
                    foreach($dtInventario2 as $value){
                        $oInventario2=inventario::getByID($item['ID']);
                        $oInventario2->usuario_mod_id=$_SESSION['usuario_ID'];
                        //Devolvemos los productos al estado en stock
                        $oInventario2->cotizacion_detalle_ID='NULL';
                        $oInventario2->estado_ID=48;
                        $oInventario2->actualizar();
                        $contador++;
                    }
                    $oCotizacion_Detalle->cantidad_separada=$oCotizacion_Detalle->cantidad_separada-$contador;
                    $oCotizacion_Detalle->usuario_mod_id=$_SESSION['usuario_ID'];
                    $oCotizacion_Detalle->actualizar();
                }
            }



        }catch(Exception $ex){

        }
    }
function eliminarSeparacionesProductoCotizacion($oCotizacion_Detalle){
    if(!class_exists('cotizacion_detalle')){
        require ROOT_PATH.'models/cotizacion_detalle.php';
    }
    if(!class_exists('inventario')){
        require ROOT_PATH.'models/inventario.php';
    }
    try{

        $dtInventario=inventario::getGrid('cotizacion_detalle_ID='.$oCotizacion_Detalle->ID,-1,-1);
            foreach($dtInventario as $item){
                $oInventario=inventario::getByID($item['ID']);
                $oInventario->usuario_mod_id=$_SESSION['usuario_ID'];
                //Devolvemos los productos al estado en stock
                $oInventario->cotizacion_detalle_ID='NULL';
                $oInventario->estado_ID=48;
                $oInventario->actualizar();
            }
            $oCotizacion_Detalle->cantidad_separada=0;
            $oCotizacion_Detalle->usuario_mod_id=$_SESSION['usuario_ID'];
            $oCotizacion_Detalle->actualizar();
        //Eliminamos cantidades separadas
    }catch(Exception $ex){

    }
}
function post_ajaxCotizacion_Mantenimiento_Registro_Componente(){
    require ROOT_PATH.'models/producto.php';
    require ROOT_PATH.'models/cotizacion_detalle.php';
    require ROOT_PATH.'models/cotizacion.php';
    require ROOT_PATH . 'controls/funcionController.php';
    $ID=$_POST['id'];
    $html="<table class='table table-hover table-teal'>";
    $html.="<thead>";
    $html.="<th>Código</th>";
    $html.="<th>Componente</th>";
    $html.="<th>Cantidad</th>";
    $html.="<th>Precio</th>";
    $html.="<th>Sub Total</th>";
    $html.="<th></th>";
    $html.="</thead>";
    $html.="</tr>";
    $oCotizacion_Detalle_Padre=cotizacion_detalle::getByID($ID);
    $oCotizacion=cotizacion::getByID($oCotizacion_Detalle_Padre->cotizacion_ID);
    $html.="<tbody>";
    try{

        $dtCotizacion_Detalle=cotizacion_detalle::getGrid('cotizacion_ID='.$oCotizacion_Detalle_Padre->cotizacion_ID.' and cotizacion_detalle_ID='.$ID.' and tipo_ID=3',-1,-1,'ID asc');
            foreach($dtCotizacion_Detalle as $item){

                if($oCotizacion->moneda_ID==1){
                    //Precio en soles
                    $precio=$item['precio_venta_unitario_soles'];
                    $subtotal=$item['precio_venta_subtotal_soles'];
                }else {
                     //Precio en dolares
                    $precio=$item['precio_venta_unitario_dolares'];
                    $subtotal=$item['precio_venta_subtotal_dolares'];
                }
                $oProducto=producto::getByID($item['producto_ID']);
                $html.="<tr class='item-tr' id='".$item['ID']."'>";
                $html.="<td class='tdCenter'>".  sprintf("%',05d",$item['producto_ID'])."</td>";
                $html.="<td class='tdLeft'>".  FormatTextView(strtoupper($oProducto->nombre))."</td>";
                $html.="<td class='tdCenter'>".$item['cantidad']."</td>";
                $html.="<td class='tdRight'>".number_format($precio,2,'.',',')."</td>";
                $html.="<td class='tdRight'>".number_format($subtotal,2,'.',',')."</td>";
                $botones=array();
                array_push($botones,'<a onclick="fncEditarComponente(' . $item['ID'] . ');" title="Editar Proveedor"><span class="glyphicon glyphicon-pencil"></span>Editar</a>');
                array_push($botones,'<a onclick="modal.confirmacion(&#39;El proceso es irreversible, esta seguro de eliminar el registro.&#39;,&#39;Eliminar Componente&#39;,fncEliminarComponente,&#39;' . $item['ID'] . '&#39;);" title="Eliminar Componente"><span class="glyphicon glyphicon-trash"></span>Eliminar</a>');
                $html.='<td class="tdCenter" >'.extraerOpcion($botones)."</td>";
                $html.="</tr>";
            }

        $resultado=1;
    }
    catch(Exception $ex){
        $resultado=-1;
        $html.="<tr><td colspan='5'>".$ex->getMessage()."</td></tr>";

    }
    $html.="</tbody>";
    $html.="</table>";

    $retornar=Array('html'=>$html,'resultado'=>$resultado);
    echo json_encode($retornar);
}
function get_Cotizacion_Mantenimiento_Registro_Componente_Nuevo($id){
        require ROOT_PATH . 'models/categoria.php';
        require ROOT_PATH . 'models/linea.php';
        require ROOT_PATH . 'models/producto.php';
        require ROOT_PATH . 'models/cotizacion.php';
        require ROOT_PATH . 'models/cotizacion_detalle.php';
        require ROOT_PATH . 'models/inventario.php';
        global  $returnView_float;

        $returnView_float=true;
        $dtCategoria=categoria::getGrid('',-1,-1,'ca.nombre asc');
        $dtLinea=linea::getGrid('',-1,-1,'li.nombre asc');
        //$dtProducto=producto::getGrid('',-1,-1,'pr.nombre asc');
        $oCotizacion_Detalle_Padre=cotizacion_detalle::getByID($id);
        $oCotizacion=cotizacion::getByID($oCotizacion_Detalle_Padre->cotizacion_ID);
        $oCotizacion_Detalle= new cotizacion_detalle();
        //Enviamos como tipo componente interno
        //$oCotizacion_Detalle->tipo=2;
        $oCotizacion_Detalle->ID=0;
        $oCotizacion_Detalle->linea_ID=0;
        $oCotizacion_Detalle->dtLinea=$dtLinea;
        $oCotizacion_Detalle->categoria_ID=0;
        $oCotizacion_Detalle->dtCategoria=$dtCategoria;
        $oCotizacion_Detalle->producto_ID=0;
        $oCotizacion_Detalle->oCotizacion=$oCotizacion;
        $oCotizacion_Detalle->cotizacion_detalle_padre_ID=$id;
        $oCotizacion_Detalle->stock=0;
        $oCotizacion_Detalle->oProducto=new producto();
        //$oCotizacion_Detalle->stock=inventario::getStock($oCotizacion_Detalle_Padre->producto_ID);
        $GLOBALS['oCotizacion_Detalle']=$oCotizacion_Detalle;
        //$GLOBALS['dtProducto']=producto::getGrid("",-1,-1,"pr.nombre asc");

    }
function post_Cotizacion_Mantenimiento_Registro_Componente_Nuevo($id){
    require ROOT_PATH . 'models/categoria.php';
    require ROOT_PATH . 'models/linea.php';
    require ROOT_PATH . 'models/producto.php';
    require ROOT_PATH . 'models/cotizacion_detalle.php';
    require ROOT_PATH . 'models/cotizacion.php';
    require ROOT_PATH . 'models/inventario.php';
    global  $returnView_float;
    $returnView_float=true;
    //El tipo es 3 de un componente
    $tipo=3;//$_POST['rbtipo'];
    $producto_ID=$_POST['selProducto'];
    $descripcion= $_POST['txtDescripcion'];
    $cantidad=$_POST['txtCantidad'];

    if(isset($_POST['cbVer_Precio'])){
         $ver_precio=$_POST['cbVer_Precio'];
    }else {$ver_precio=0;}

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

    }else {$separacion=0;}
    if(isset($_POST['txtTiempo_Separacion'])){
        $tiempo_separacion=$_POST['txtTiempo_Separacion'];
    }else{
        $tiempo_separacion=0;
    }
    try{
        $oCotizacion_Detalle_Padre=cotizacion_detalle::getByID($id);
        $oCotizacion_Detalle=new cotizacion_detalle();
        $oCotizacion_Detalle->producto_ID=$producto_ID;
        $oCotizacion_Detalle->cotizacion_ID=$oCotizacion_Detalle_Padre->cotizacion_ID;
        $oCotizacion_Detalle->descripcion=$descripcion;
        $oCotizacion_Detalle->cantidad=$cantidad;
        $oCotizacion_Detalle->precio_venta_unitario_soles=$PrecioUnitarioSoles;
        $oCotizacion_Detalle->precio_venta_unitario_dolares=$PrecioUnitarioDolares;
        $oCotizacion_Detalle->precio_venta_subtotal_soles=$SubTotalSoles;
        $oCotizacion_Detalle->precio_venta_subtotal_dolares=$SubTotalDolares;
        $oCotizacion_Detalle->igv=$Igv;
        $oCotizacion_Detalle->vigv_soles=$IgvSoles;
        $oCotizacion_Detalle->vigv_dolares=$IgvDolares;
        $oCotizacion_Detalle->precio_venta_soles=$TotalSoles;
        $oCotizacion_Detalle->precio_venta_dolares=$TotalDolares;
        $oCotizacion_Detalle->cotizacion_detalle_ID=$id;
        $oCotizacion_Detalle->estado_id=0;
        $oCotizacion_Detalle->ver_precio=$ver_precio;
        $oCotizacion_Detalle->usuario_id=$_SESSION['usuario_ID'];
        $oCotizacion_Detalle->separacion=$separacion;
        $oCotizacion_Detalle->tiempo_separacion=$tiempo_separacion;
        //$oCotizacion_Detalle->cantidad_separada=0;
        $oCotizacion_Detalle->tipo_ID=$tipo;
        $oCotizacion_Detalle->tipo=$tipo;
        $retorna=$oCotizacion_Detalle->insertar1();
        if($retorna>0){
            $producto_ID_old=$oCotizacion_Detalle->producto_ID;
            /*Actualizamos los costos en la el costo del padre*/
            separarProductoCotizacion($oCotizacion_Detalle,$producto_ID_old);
            //separarProducto($oCotizacion_Detalle,1);
            $oCotizacion_Detalle_Padre=actualizar_costo_cotizacion_detalle_padre($oCotizacion_Detalle_Padre);
            $mensaje=actualizar_costo_cotizacion($oCotizacion_Detalle_Padre);
             $resultado=1;
             $mensaje="Se guardó correctamente";
        }else{
             $resultado=-1;
              $mensaje="No se registró ninguna fila";
        }
        
       


    }catch(Exception $ex){
      $resultado=-1;
      log_error(__FILE__,"salida/post_Cotizacion_Mantenimiento_Registro_Componente_Nuevo",$ex->getMessage());
      $mensaje=utf8_encode(mensaje_error);
    }
    $dtCategoria=categoria::getGrid('',-1,-1,'ca.nombre asc');
    $dtLinea=linea::getGrid('',-1,-1,'li.nombre asc');
    $dtProducto=producto::getGrid('',-1,-1,'pr.nombre asc');
    $oProducto=producto::getByID($producto_ID);
    $stock=inventario::getStock($producto_ID);

    $oCotizacion=cotizacion::getByID($oCotizacion_Detalle_Padre->cotizacion_ID);
    $oCategoria=categoria::getByID($oProducto->categoria_ID);
    $oCotizacion_Detalle->linea_ID=$oCategoria->linea_ID;
    $oCotizacion_Detalle->dtLinea=$dtLinea;
    $oCotizacion_Detalle->categoria_ID=$oProducto->categoria_ID;
    $oCotizacion_Detalle->dtCategoria=$dtCategoria;
    $oCotizacion_Detalle->oCotizacion=$oCotizacion;
    $oCotizacion_Detalle->cotizacion_detalle_padre_ID=$id;
    $oCotizacion_Detalle->stock=$stock;
    $oCotizacion_Detalle->oProducto=$oProducto;
    
    $GLOBALS['oCotizacion_Detalle']=$oCotizacion_Detalle;
    $GLOBALS['resultado']=$resultado;
    $GLOBALS['mensaje']=$mensaje;

}
function post_ajaxValidarCostoCompraMenor(){
        require ROOT_PATH.'models/usuario.php';
        require ROOT_PATH.'models/usuario_empresa.php';
        //require ROOT_PATH.'models/moneda.php';
        $contrasena=$_POST['id'];

        try{
            $verificar=usuario_empresa::getCount('UPPER(u.password) like UPPER("'.$contrasena.'") and ue.perfil_ID in (0,1) and u.estado_ID=45 and ue.estado_ID=86');

            if($verificar>0){
               $resultado=1;

            }else {
                $resultado=0;
            }

           $mensaje="";
        } catch (Exception $ex) {
            $resultado=-1;
            $mensaje=$ex->getMessage();

        }
        $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);
	echo json_encode($retornar);
    }
    /*
function post_ajaxVerSeparaciones(){
    require ROOT_PATH.'models/producto.php';
    require ROOT_PATH.'models/inventario.php';
    require ROOT_PATH.'models/cotizacion_detalle.php';
    require ROOT_PATH.'models/cotizacion.php';
    require ROOT_PATH.'models/operador.php';
    $producto_ID=$_POST['id'];
    $html="<table  class='table table-hover vista-grid'><thead>";
    $html.="<tr><th>N°Cotizaci&oacute;n</th><th>Fecha</th><th>Cant. Comprada</th><th>Cant. Separada</th><th >Responsable</th></tr>";
    $html.="</thead>";
    $html.="<tbody>";
    try{
        $dtInventario=inventario::getGrid('producto_ID='.$producto_ID.' and estado_ID=51');
        $cotizacion_detalle_ID=0;
        if(count($dtInventario)>0){
            foreach($dtInventario as $item){
                if($item['cotizacion_detalle_ID']!="-1"){
                    if($cotizacion_detalle_ID!=$item['cotizacion_detalle_ID']){
                        $cotizacion_detalle_ID=$item['cotizacion_detalle_ID'];
                        $oCotizacion_Detalle=cotizacion_detalle::getByID($item['cotizacion_detalle_ID']);

                        $oCotizacion=cotizacion::getByID($oCotizacion_Detalle->cotizacion_ID);
                        $oOperador=operador::getByID($oCotizacion->usuario_id);
                        $html.="<tr>";
                        $html.="<td style='text-align:center;'>".$oCotizacion->numero_concatenado."</td>";
                        $html.="<td style='text-align:center;'>".$oCotizacion->fecha."</td>";
                        $html.="<td style='text-align:center;'>".$oCotizacion_Detalle->cantidad."</td>";
                        $html.="<td style='text-align:center;'>".$oCotizacion_Detalle->cantidad_separada."</td>";
                        $html.="<td>".$oOperador->nombres." ".$oOperador->apellido_paterno."</td>";
                        $html.="</tr>";
                    }

                }

            }
        }
        $resultado=1;
    }
    catch(Exception $ex){
        $html.="<tr><td>".$ex->getMessage()."</td></tr>";
        $resultado=-1;
    }

    $html.="</tbody>";
    $html.="</table>";
    $retornar=Array('html'=>$html,'resultado'=>$resultado,'producto_ID'=>$producto_ID);
    echo json_encode($retornar);
}*/
function actualizar_costo_cotizacion_detalle_padre($oCotizacion_Detalle_Padre){
    $oCotizacion_Detalle=$oCotizacion_Detalle_Padre;
    try{

    //$PrecioUnitarioSoles1=$oCotizacion_Detalle->precio_venta_unitario_soles;
    //$PrecioUnitarioDolares1=$oCotizacion_Detalle->precio_venta_unitario_dolares;

    $dtCotizacion_Detalle_Hijos=cotizacion_detalle::getGrid('cotizacion_detalle_ID='.$oCotizacion_Detalle->ID.' and tipo_ID in (3,4)',-1,-1);
    $adicional_soles=0;
    $adicional_dolares=0;
    $precio_venta_subtotal_soles_hijo=0;
    $precio_venta_subtotal_dolares_hijo=0;
    foreach($dtCotizacion_Detalle_Hijos as $value){
        switch($value['tipo_ID']){
            case 3:
                $precio_venta_subtotal_soles_hijo=$precio_venta_subtotal_soles_hijo+$value['precio_venta_subtotal_soles'];
                $precio_venta_subtotal_dolares_hijo=$precio_venta_subtotal_dolares_hijo+$value['precio_venta_subtotal_dolares'];

                break;
            case 4:
                $adicional_soles=$adicional_soles+$value['precio_venta_subtotal_soles'];
                $adicional_dolares=$adicional_dolares+$value['precio_venta_subtotal_dolares'];
                break;
        }
    }
    $precio_venta_unitario_soles=0;
    $precio_venta_unitario_dolares=0;
    $precio_venta_subtotal_soles=0;
    $precio_venta_subtotal_dolares=0;
    switch($oCotizacion_Detalle->tipo_ID){
        case 2://Producto con componente
            $precio_venta_unitario_soles=$precio_venta_subtotal_soles_hijo;
            $precio_venta_unitario_dolares=$precio_venta_subtotal_dolares_hijo;
            $precio_venta_subtotal_soles=$precio_venta_unitario_soles*$oCotizacion_Detalle->cantidad;
            $precio_venta_subtotal_dolares=$precio_venta_unitario_dolares*$oCotizacion_Detalle->cantidad;
            break;
        case 5://producto con componente y adicional

                $precio_venta_subtotal_soles=$adicional_soles+$precio_venta_subtotal_soles_hijo*$oCotizacion_Detalle->cantidad;
                $precio_venta_subtotal_dolares=$adicional_dolares+$precio_venta_subtotal_dolares_hijo*$oCotizacion_Detalle->cantidad;
                $precio_venta_unitario_soles=$precio_venta_subtotal_soles/$oCotizacion_Detalle->cantidad;
                $precio_venta_unitario_dolares=$precio_venta_subtotal_dolares/$oCotizacion_Detalle->cantidad;


            break;
        case 6://producto con adicional

                $precio_venta_unitario_soles=$adicional_soles/$oCotizacion_Detalle->cantidad+$oCotizacion_Detalle->precio_venta_unitario_soles;
                $precio_venta_unitario_dolares=$adicional_dolares/$oCotizacion_Detalle->cantidad+$oCotizacion_Detalle->precio_venta_unitario_dolares;
                $precio_venta_subtotal_soles=$precio_venta_unitario_soles*$oCotizacion_Detalle->cantidad;
                $precio_venta_subtotal_dolares=$precio_venta_unitario_dolares*$oCotizacion_Detalle->cantidad;

            break;
    }
    if($oCotizacion_Detalle->tipo_ID!=1){//verificamos que no sea un producto
        $oCotizacion_Detalle->precio_venta_unitario_soles=$precio_venta_unitario_soles;
        $oCotizacion_Detalle->precio_venta_unitario_dolares=$precio_venta_unitario_dolares;
        $oCotizacion_Detalle->precio_venta_subtotal_soles=$precio_venta_subtotal_soles;
        $oCotizacion_Detalle->precio_venta_subtotal_dolares=$precio_venta_subtotal_dolares;

        $oCotizacion_Detalle->precio_venta_soles=$oCotizacion_Detalle->precio_venta_subtotal_soles*(1+$oCotizacion_Detalle->igv);
        $oCotizacion_Detalle->precio_venta_dolares=$oCotizacion_Detalle->precio_venta_subtotal_dolares*(1+$oCotizacion_Detalle->igv);
        $oCotizacion_Detalle->vigv_soles=$oCotizacion_Detalle->precio_venta_subtotal_soles*($oCotizacion_Detalle->igv);
        $oCotizacion_Detalle->vigv_dolares=$oCotizacion_Detalle->precio_venta_subtotal_dolares*($oCotizacion_Detalle->igv);
    }
    $oCotizacion_Detalle->usuario_mod_id=$_SESSION['usuario_ID'];
    $oCotizacion_Detalle->actualizar1();
    switch($oCotizacion_Detalle->tipo_ID){
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

    }catch (Exception $ex){
        log_error(__FILE__,"salida/actualizar_costo_cotizacion_detalle_padre",$ex->getMessage());
        throw  new Exception($ex->getMessage());
        //return $ex;
    }

    return $oCotizacion_Detalle;
}
function actualizar_costo_cotizacion($oCotizacion_Detalle){
    /*Actualizamos los costos en la tabla cotizacion*/
    try{
        $oCotizacion=cotizacion::getByID($oCotizacion_Detalle->cotizacion_ID);
        $precio_venta_neto_soles=0;
        $precio_venta_neto_dolares=0;

        $dtCotizacion_Detalle=cotizacion_detalle::getGrid('cotizacion_ID='.$oCotizacion_Detalle->cotizacion_ID .' and cotizacion_detalle_ID=0 and tipo_ID in (1,2,5,6)',-1,-1);
        foreach($dtCotizacion_Detalle as $item){
            $precio_venta_neto_soles=$precio_venta_neto_soles+$item['precio_venta_subtotal_soles'];
            $precio_venta_neto_dolares=$precio_venta_neto_dolares+$item['precio_venta_subtotal_dolares'];

        }

        $oCotizacion->precio_venta_neto_soles=$precio_venta_neto_soles;
        $oCotizacion->precio_venta_neto_dolares=$precio_venta_neto_dolares;
        $oCotizacion->vigv_soles=$precio_venta_neto_soles*$oCotizacion->igv;
        $oCotizacion->vigv_dolares=$precio_venta_neto_dolares*$oCotizacion->igv;
        $oCotizacion->precio_venta_total_soles=$precio_venta_neto_soles*(1+$oCotizacion->igv);
        $oCotizacion->precio_venta_total_dolares=$precio_venta_neto_dolares*(1+$oCotizacion->igv);
        $oCotizacion->usuario_mod_id=$_SESSION['usuario_ID'];
        $oCotizacion->actualizar1();
    }catch(Exception $ex){
        $oCotizacion->getMessage=$ex->getMessage();
    }

    return $oCotizacion->getMessage;
}
function post_ajaxCotizacion_Mantenimiento_Registro_Adicional(){
    require ROOT_PATH.'models/producto.php';
    require ROOT_PATH.'models/cotizacion_detalle.php';
    require ROOT_PATH.'models/cotizacion.php';
    require ROOT_PATH . 'controls/funcionController.php';
    $ID=$_POST['id'];
    $html="<table class='table table-hover table-teal'>";
    $html.="<thead>";
    $html.="<tr>";
    $html.="<th>Código</th>";
    $html.="<th>Adicional</th>";
    $html.="<th>Cantidad</th>";
    $html.="<th>Precio</th>";
    $html.="<th>Sub Total</th>";
    $html.="<th></th>";
    $html.="</tr>";
    $html.="</thead>";
    $html.="<boody>";
    $oCotizacion_Detalle_Padre=cotizacion_detalle::getByID($ID);
    $oCotizacion=cotizacion::getByID($oCotizacion_Detalle_Padre->cotizacion_ID);

    try{

        $dtCotizacion_Detalle=cotizacion_detalle::getGrid('cotizacion_ID='.$oCotizacion_Detalle_Padre->cotizacion_ID.' and cotizacion_detalle_ID='.$ID.' and tipo_ID=4',-1,-1,'ID asc');
            foreach($dtCotizacion_Detalle as $item){

                if($oCotizacion->moneda_ID==1){
                    //Precio en soles
                    $precio=$item['precio_venta_unitario_soles'];
                    $subtotal=$item['precio_venta_subtotal_soles'];
                }else {
                     //Precio en dolares
                    $precio=$item['precio_venta_unitario_dolares'];
                    $subtotal=$item['precio_venta_subtotal_dolares'];
                }
                $oProducto=producto::getByID($item['producto_ID']);
                $html.="<tr class='item-tr' id='".$item['ID']."'>";
                $html.="<td class='tdCenter'>".  sprintf("%',05d",$item['producto_ID'])."</td>";
                $html.="<td class='tdLeft'>".  FormatTextView(strtoupper($oProducto->nombre))."</td>";
                $html.="<td class='tdCenter'>".$item['cantidad']."</td>";
                $html.="<td class='tdRight'>".number_format($precio,2,'.',',')."</td>";
                $html.="<td class='tdRight'>".number_format($subtotal,2,'.',',')."</td>";
                $botones=array();
                array_push($botones,'<a onclick="fncEditarAdicional(' . $item['ID'] . ');" title="Editar Adicional"><span class="glyphicon glyphicon-pencil"></span>Editar</a>');
                array_push($botones,'<a onclick="modal.confirmacion(&#39;El proceso es irreversible, esta seguro de eliminar el registro.&#39;,&#39;Eliminar Adicional&#39;,fncEliminarAdicional,&#39;' . $item['ID'] . '&#39;);" title="Eliminar Adicional"><span class="glyphicon glyphicon-trash"></span>Eliminar</a>');
                $html.='<td class="tdCenter" >'.extraerOpcion($botones)."</td>";
                $html.="</tr>";
            }


        $resultado=1;
    }
    catch(Exception $ex){
        $resultado=-1;
        $html.="<tr><td colspan='5'>".$ex->getMessage()."</td></tr>";

    }
    $html.="<boody>";
    $html.="</table>";


    $retornar=Array('html'=>$html,'resultado'=>$resultado,);
    echo json_encode($retornar);
}

function post_ajaxCotizacion_Detalle_Obsequios(){
    require ROOT_PATH.'models/cotizacion.php';
    require ROOT_PATH.'models/cotizacion_detalle.php';
    require ROOT_PATH.'models/producto.php';
    require ROOT_PATH.'models/moneda.php';
    require ROOT_PATH.'models/unidad_medida.php';
    require ROOT_PATH . 'controls/funcionController.php';
    $cotizacion_ID=$_POST['id'];
    //---------------------------------------
    $oCotizacion=cotizacion::getByID($cotizacion_ID);
    $oMoneda=moneda::getByID($oCotizacion->moneda_ID);
    $resultado='<table class="table table-hover table-teal">';
    $resultado.='<thead><tr>';
    $resultado.='<th class="text-center">Item </th>';
    $resultado.='<th class="text-center">Producto </th>';
    $resultado.='<th class="text-center">Cantidad </th>';
    $resultado.='<th class="text-center">Opción</th>';
    $resultado.='</tr>';
    $resultado.='</thead>';
    $resultado.='<tbody>';
    try {

        $dtCotizacion_Detalle=cotizacion_detalle::getGrid('cotizacion_ID='.$cotizacion_ID.' and tipo_ID=7',-1,-1,'ID asc');
        $rows=count($dtCotizacion_Detalle);
        $i=1;
        $costo_venta=0;


        foreach($dtCotizacion_Detalle as $item)
        {
            $oProducto=producto::getByID($item['producto_ID']);
            $resultado.='<tr class="item-tr" id="'.$item['ID'].'">';
            $resultado.='<td class="text-center">'.$i.'</td>';
            $resultado.='<td class="tdLeft">'.FormatTextView(strtoupper($oProducto->nombre)).'</td>';
            $resultado.='<td class="text-center">'.$item['cantidad'].'</td>';
            $botones=array();
            array_push($botones,'<a onclick="fncEditarObsequio(' . $item['ID'] . ');" title="Editar Obsequio"><span class="glyphicon glyphicon-pencil"></span>Editar</a>');
            array_push($botones,'<a onclick="modal.confirmacion(&#39;El proceso es irreversible, esta seguro de eliminar el registro.&#39;,&#39;Eliminar Obsequio&#39;,fncEliminarObsequio,&#39;' . $item['ID'] . '&#39;);" title="Eliminar Obsequio"><span class="glyphicon glyphicon-trash"></span>Eliminar</a>');
            $resultado.='<td class="text-center" >'.extraerOpcion($botones)."</td>";
            $resultado.='</tr>';
            $i++;

        }

    }catch(Exception $ex){
            $resultado.='<tr ><td colspan="4">'.$ex->getMessage().'</td></tr>';
    }
    $resultado.='</tbody>';
    $resultado.='</table>';

    $mensaje='';
    $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);
    //$retorn="<h1>Hola</h1>";

    echo json_encode($retornar);
}
function post_ajaxCotizacion_Detalle_Productos(){
    require ROOT_PATH.'models/cotizacion.php';
    require ROOT_PATH.'models/cotizacion_detalle.php';
    require ROOT_PATH.'models/producto.php';
    require ROOT_PATH.'models/moneda.php';
    require ROOT_PATH.'models/unidad_medida.php';
    require ROOT_PATH . 'controls/funcionController.php';
    $cotizacion_ID=$_POST['id'];
    $tardanza=$_POST['id1'];

    //---------------------------------------
    $oCotizacion=cotizacion::getByID($cotizacion_ID);
    $oMoneda=moneda::getByID($oCotizacion->moneda_ID);
    $resultado='<table class="table table-hover table-teal">';
    $resultado.='<thead><tr>';
    $resultado.='<th>Comp. </th>';
    $resultado.='<th>Adic. </th>';
    $resultado.='<th>Item </th>';
    $resultado.='<th>Producto </th>';
    $resultado.='<th>Cantidad </th>';
    $resultado.='<th>Precio</th>';
    $resultado.='<th>Sub Total</th>';
    $resultado.='<th></th>';
    $resultado.='</tr></thead>';
    $resultado.='<tbody>';
    try {

        $oCotizacion->tardanza=$tardanza;
        $oCotizacion->usuario_mod_id=$_SESSION['usuario_ID'];
        $oCotizacion->actualizar();
        $dtCotizacion_Detalle=cotizacion_detalle::getGrid('cotizacion_ID='.$cotizacion_ID. ' and tipo_ID in(1,2,5,6) and cotizacion_detalle_ID=0',-1,-1,'ID asc');
        $rows=count($dtCotizacion_Detalle);
        $i=1;
        $costo_venta=0;

        //print_r($dtCotizacion_Detalle);
        foreach($dtCotizacion_Detalle as $item)
        {
            $cotizacion_detalle_ID=$item['cotizacion_detalle_ID'];
            if($cotizacion_detalle_ID==0){
            $oProducto=producto::getByID($item['producto_ID']);
            if($oCotizacion->moneda_ID==1){
                $costo_venta_unitario_padre=$item['precio_venta_unitario_soles'];
                $precio_venta_subtotal_padre=$item['precio_venta_subtotal_soles'];
            }else {
                $costo_venta_unitario_padre=$item['precio_venta_unitario_dolares'];
                $precio_venta_subtotal_padre=$item['precio_venta_subtotal_dolares'];
            }


                $resultado.='<tr class="item-tr" id="'.$item['ID'].'">';

                //$contar=cotizacion_detalle::getCount('cotizacion_ID='.$cotizacion_ID.' and cotizacion_detalle_ID='.$item['ID'],-1,-1,'tipo asc');

                $array=retornar_valores($item['tipo_ID']);
                $componente="";
                if($array['componente']==1){
                    $componente="<img src='/include/img/boton/check_16x16.png'/>";
                }

                $adicional='';
                if($array['adicional']==1){
                    $adicional="<img src='/include/img/boton/check_16x16.png'/>";
                }

                $resultado.='<td class="tdCenter">'.$componente.'</td>';
                $resultado.='<td class="tdCenter">'.$adicional.'</td>';
                $resultado.='<td class="tdCenter">'.$i.'</td>';
                $resultado.='<td class="tdLeft">'. test_input($oProducto->nombre).'</td>';
                $resultado.='<td class="tdCenter">'.$item['cantidad'].'</td>';
                $resultado.='<td class="tdRight" style="padding-right:8px;">'.number_format($costo_venta_unitario_padre,2,".",",").'</td>';
                $resultado.='<td class="tdRight" style="padding-right:8px;">'.number_format($precio_venta_subtotal_padre,2,".",",").'</td>';
                $botones=array();
                array_push($botones,'<a title="Editar Producto" onclick="fncEditarProducto(' . $item['ID'] . ');" ><span class="glyphicon glyphicon-pencil"></span>Editar</a>');
                array_push($botones,'<a onclick="modal.confirmacion(&#39;El proceso es irreversible, esta seguro de eliminar el registro.&#39;,&#39;Eliminar Producto&#39;,fncEliminarProducto,&#39;' . $item['ID'] . '&#39;);" title="Eliminar Producto"><span class="glyphicon glyphicon-trash"></span>Eliminar</a>');
                $resultado.='<td class="tdCenter" >'.extraerOpcion($botones)."</td>";
                $resultado.='</tr>';
                $i++;

            }
        }

            if($oCotizacion->moneda_ID==1){
                $vigv_t=$oCotizacion->vigv_soles;
                $precio_venta_neto_t=$oCotizacion->precio_venta_neto_soles;
                $precio_venta_total_t=$oCotizacion->precio_venta_total_soles;

            }else {
               $vigv_t=$oCotizacion->vigv_dolares;
                $precio_venta_neto_t=$oCotizacion->precio_venta_neto_dolares;
                $precio_venta_total_t=$oCotizacion->precio_venta_total_dolares;
            }
            $resultado.='<tr><td colspan="7" style="border-bottom:1px solid #000;height:1px;"></td></tr>';
            $resultado.='<tr style="border-bottom:hidden;border-left:hidden;"><td colspan="6" style="text-align:right;font-weight: bold; padding:1px 8px; border:none;">Sub Total '.$oMoneda->simbolo.'</td><td style="padding:1px 8px;" class="tdRight">'.number_format($precio_venta_neto_t,2,".",",").'</td>';
            $resultado.='<tr style="border-bottom:hidden;border-left:hidden;"><td colspan="6" style="text-align:right;font-weight: bold; padding:1px 8px; border:none;">IGV '.$oCotizacion->igv*100 .'%</td><td style="padding:1px 8px;" class="tdRight">'.number_format($vigv_t,2,".",",").'</td>';
            $resultado.='<tr style="border-bottom:hidden;border-left:hidden;"><td colspan="6" style="text-align:right;font-weight: bold; padding:1px 8px; border:none;">Total '.$oMoneda->simbolo.'</td><td style="padding:1px 8px;" class="tdRight">'.number_format($precio_venta_total_t,2,".",",").'</td>';


           }catch(Exception $ex){
            $resultado.='<tr ><td colspan="6">'.$ex->getMessage().'</td></tr>';
    }
    $resultado.='</tbody>';
    $resultado.='</table>';

    $mensaje='';
    $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);
    //$retorn="<h1>Hola</h1>";

    echo json_encode($retornar);
}
function post_ajaxCotizacionLlenarCajas(){
    require ROOT_PATH.'models/producto.php';
    require ROOT_PATH.'models/cotizacion_detalle.php';
    require ROOT_PATH.'models/cotizacion.php';

    $ID=$_POST['id'];
    $oCotizacion_Detalle=cotizacion_detalle::getByID($ID);
    //print_r($oCotizacion_Detalle);
    $oCotizacion=cotizacion::getByID($oCotizacion_Detalle->cotizacion_ID);

    try{
        $precio_venta_subtotal_soles_hijo=0;
        $precio_venta_subtotal_dolares_hijo=0;
        $adicional_soles=0;
        $adicional_dolares=0;

        $dtCotizacion_Detalle=cotizacion_detalle::getGrid('cotizacion_ID='.$oCotizacion_Detalle->cotizacion_ID.' and cotizacion_detalle_ID='.$ID.' and tipo_ID in (3,4)',-1,-1,'ID asc');
        //print_r($dtCotizacion_Detalle);
        foreach($dtCotizacion_Detalle as $item){
            switch($item['tipo_ID']){
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
        switch($oCotizacion_Detalle->tipo_ID){
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
        $precio_venta_subtotal_soles1=$oCotizacion_Detalle->subtotal_soles1;
        $precio_venta_subtotal_soles=$oCotizacion_Detalle->precio_venta_subtotal_soles;
        $precio_venta_unitario_soles=$oCotizacion_Detalle->precio_venta_unitario_soles;
        $vigv_soles=number_format($oCotizacion_Detalle->vigv_soles,2,'.',',');
        $precio_venta_soles=number_format($oCotizacion_Detalle->precio_venta_soles,2,'.',',');
        //print_r($oCotizacion_Detalle);
        $adicional_soles=$oCotizacion_Detalle->adicional_soles;

         //Precio en dolares
        $precio_venta_subtotal_dolares1=$oCotizacion_Detalle->subtotal_dolares1;
        $precio_venta_subtotal_dolares=$oCotizacion_Detalle->precio_venta_subtotal_dolares;
        $precio_venta_unitario_dolares=$oCotizacion_Detalle->precio_venta_unitario_dolares;
        $vigv_dolares=number_format($oCotizacion_Detalle->vigv_dolares,2,'.',',');
        $precio_venta_dolares=number_format($oCotizacion_Detalle->precio_venta_dolares,2,'.',',');
        $adicional_dolares=$oCotizacion_Detalle->adicional_dolares;
        $resultado=1;
        $mensaje='';
    }
    catch(Exception $ex){
        $resultado=-1;
        $mensaje=$ex->getMessage();
    }
    $retornar=Array('mensaje'=>$mensaje,'resultado'=>$resultado,'precio_venta_unitario_soles'=>$precio_venta_unitario_soles,
        'precio_venta_subtotal_soles'=>$precio_venta_subtotal_soles,'vigv_soles'=>$vigv_soles,'precio_venta_soles'=>$precio_venta_soles,
        'precio_venta_unitario_dolares'=>$precio_venta_unitario_dolares,'precio_venta_subtotal_dolares'=>$precio_venta_subtotal_dolares,
        'vigv_dolares'=>$vigv_dolares,'precio_venta_dolares'=>$precio_venta_dolares,'adicional_soles'=>$adicional_soles,
        'adicional_dolares'=>$adicional_dolares,'precio_venta_subtotal_soles1'=>$precio_venta_subtotal_soles1,'precio_venta_subtotal_dolares1'=>$precio_venta_subtotal_dolares1
        );
    echo json_encode($retornar);
}
function llenarValoresCotizacion($oCotizacion_Detalle){
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
            
            $dtCotizacion_Detalle=cotizacion_detalle::getGrid('cotizacion_ID='.$oCotizacion_Detalle->cotizacion_ID.' and cotizacion_detalle_ID='.$oCotizacion_Detalle->ID.' and tipo_ID in (3,4)',-1,-1,'ID asc');
            foreach($dtCotizacion_Detalle as $item){
                switch($item['tipo_ID']){
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
            switch($oCotizacion_Detalle->tipo_ID){
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
    
function get_Cotizacion_Mantenimiento_Registro_Adicional_Nuevo($id){
    require ROOT_PATH . 'models/categoria.php';
    require ROOT_PATH . 'models/linea.php';
    require ROOT_PATH . 'models/producto.php';
    require ROOT_PATH . 'models/cotizacion.php';
    require ROOT_PATH . 'models/cotizacion_detalle.php';
    require ROOT_PATH . 'models/inventario.php';
    global  $returnView_float;

    $returnView_float=true;
    $dtCategoria=categoria::getGrid('',-1,-1,'ca.nombre asc');
    $dtLinea=linea::getGrid('',-1,-1,'li.nombre asc');
    //$dtProducto=producto::getGrid('',-1,-1,'pr.nombre asc');
    $oCotizacion_Detalle_Padre=cotizacion_detalle::getByID($id);
    $oCotizacion=cotizacion::getByID($oCotizacion_Detalle_Padre->cotizacion_ID);
    $oCotizacion_Detalle= new cotizacion_detalle();
    //Enviamos como tipo componente interno
    //$oCotizacion_Detalle->tipo=2;
    $oCotizacion_Detalle->ID=0;
    $oCotizacion_Detalle->linea_ID=0;
    $oCotizacion_Detalle->dtLinea=$dtLinea;
    $oCotizacion_Detalle->categoria_ID=0;
    $oCotizacion_Detalle->dtCategoria=$dtCategoria;
    $oCotizacion_Detalle->producto_ID=0;
    $oCotizacion_Detalle->oCotizacion=$oCotizacion;
    $oCotizacion_Detalle->cotizacion_detalle_padre_ID=$id;
    $oCotizacion_Detalle->stock=0;
    $oCotizacion_Detalle->oProducto=new producto();
    $GLOBALS['oCotizacion']=$oCotizacion;
    //$GLOBALS['dtProducto']=$dtProducto;
    //$oCotizacion_Detalle->stock=inventario::getStock($oCotizacion_Detalle_Padre->producto_ID);
    $GLOBALS['oCotizacion_Detalle']=$oCotizacion_Detalle;

}
function post_Cotizacion_Mantenimiento_Registro_Adicional_Nuevo($id){
    require ROOT_PATH . 'models/categoria.php';
    require ROOT_PATH . 'models/linea.php';
    require ROOT_PATH . 'models/producto.php';
    require ROOT_PATH . 'models/cotizacion_detalle.php';
    require ROOT_PATH . 'models/cotizacion.php';
    require ROOT_PATH . 'models/inventario.php';
    global  $returnView_float;
    $returnView_float=true;
    //El tipo es 4 de un adicional
    $tipo=4;//$_POST['rbtipo'];
    $producto_ID=$_POST['selProducto'];
    $descripcion=  FormatTextSave($_POST['txtDescripcion']);
    $cantidad=$_POST['txtCantidad'];

    if(isset($_POST['cbVer_Precio'])){
         $ver_precio=$_POST['cbVer_Precio'];
    }else {$ver_precio=0;}

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

    }else {$separacion=0;}
    if(isset($_POST['txtTiempo_Separacion'])){
        $tiempo_separacion=$_POST['txtTiempo_Separacion'];
    }else{
        $tiempo_separacion=0;
    }
    try{
        $oCotizacion_Detalle_Padre=cotizacion_detalle::getByID($id);
        $oCotizacion_Detalle=new cotizacion_detalle();
        $oCotizacion_Detalle->producto_ID=$producto_ID;
        $oCotizacion_Detalle->cotizacion_ID=$oCotizacion_Detalle_Padre->cotizacion_ID;
        $oCotizacion_Detalle->descripcion=$descripcion;
        $oCotizacion_Detalle->cantidad=$cantidad;
        $oCotizacion_Detalle->precio_venta_unitario_soles=$PrecioUnitarioSoles;
        $oCotizacion_Detalle->precio_venta_unitario_dolares=$PrecioUnitarioDolares;
        $oCotizacion_Detalle->precio_venta_subtotal_soles=$SubTotalSoles;
        $oCotizacion_Detalle->precio_venta_subtotal_dolares=$SubTotalDolares;
        $oCotizacion_Detalle->igv=$Igv;
        $oCotizacion_Detalle->vigv_soles=$IgvSoles;
        $oCotizacion_Detalle->vigv_dolares=$IgvDolares;
        $oCotizacion_Detalle->precio_venta_soles=$TotalSoles;
        $oCotizacion_Detalle->precio_venta_dolares=$TotalDolares;
        $oCotizacion_Detalle->cotizacion_detalle_ID=$id;
        $oCotizacion_Detalle->estado_id=0;
        $oCotizacion_Detalle->ver_precio=$ver_precio;
        $oCotizacion_Detalle->usuario_id=$_SESSION['usuario_ID'];
        $oCotizacion_Detalle->separacion=$separacion;
        $oCotizacion_Detalle->tiempo_separacion=$tiempo_separacion;
        //$oCotizacion_Detalle->cantidad_separada=0;
        $oCotizacion_Detalle->tipo_ID=$tipo;
        $oCotizacion_Detalle->tipo=$tipo;
        $oCotizacion_Detalle->insertar();

        $producto_ID_old=$oCotizacion_Detalle->producto_ID;
        /*Actualizamos los costos en la el costo del padre*/
        separarProductoCotizacion($oCotizacion_Detalle,$producto_ID_old);
        //separarProducto($oCotizacion_Detalle,1);
        $oCotizacion_Detalle_Padre=actualizar_costo_cotizacion_detalle_padre($oCotizacion_Detalle_Padre);
        $mensaje=actualizar_costo_cotizacion($oCotizacion_Detalle_Padre);
        $resultado=1;


    }catch(Exception $ex){
      $resultado=-1;
      $mensaje=$ex->getMessage();
    }
    $dtCategoria=categoria::getGrid('',-1,-1,'ca.nombre asc');
    $dtLinea=linea::getGrid('',-1,-1,'li.nombre asc');
    //$dtProducto=producto::getGrid('',-1,-1,'pr.nombre asc');
    $oProducto=producto::getByID($producto_ID);
    $stock=inventario::getStock($producto_ID);

    $oCotizacion=cotizacion::getByID($oCotizacion_Detalle_Padre->cotizacion_ID);
    $oCategoria=categoria::getByID($oProducto->categoria_ID);
    $oCotizacion_Detalle->linea_ID=$oCategoria->linea_ID;
    $oCotizacion_Detalle->dtLinea=$dtLinea;
    $oCotizacion_Detalle->categoria_ID=$oProducto->categoria_ID;
    $oCotizacion_Detalle->dtCategoria=$dtCategoria;
    $oCotizacion_Detalle->oCotizacion=$oCotizacion;
    $oCotizacion_Detalle->cotizacion_detalle_padre_ID=$id;
    $oCotizacion_Detalle->stock=$stock;
    $oCotizacion_Detalle->oProducto=$oProducto;
    //$GLOBALS['dtProducto']=$dtProducto;
    $GLOBALS['oCotizacion']=$oCotizacion;
    $GLOBALS['oCotizacion_Detalle']=$oCotizacion_Detalle;
    $GLOBALS['resultado']=$resultado;
    $GLOBALS['mensaje']=$mensaje;

}
function get_Cotizacion_PDF($id){
    require ('./formatos_PDF/cotizacion.php');
    require ROOT_PATH.'models/cotizacion.php';
    require ROOT_PATH.'models/moneda.php';
    require ROOT_PATH.'models/cotizacion_detalle.php';
    require ROOT_PATH.'models/producto.php';
    if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";;
    require ROOT_PATH . 'models/cliente.php';
    require ROOT_PATH . 'include/lib_fecha_texto.php';
    require ROOT_PATH . 'models/cliente_contacto.php';
    require ROOT_PATH . 'models/persona.php';
    require ROOT_PATH . 'models/forma_pago.php';
    require ROOT_PATH . 'models/operador.php';
    require ROOT_PATH . 'models/cotizacion_numero_cuenta.php';
    global $returnView_float;
    $returnView_float=true;
    $oCotizacion=cotizacion::getByID($id);
    $oMoneda=moneda::getByID($oCotizacion->moneda_ID);
    $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
    $oCliente=cliente::getByID($oCotizacion->cliente_ID);
    if($oCotizacion->cliente_contacto_ID!=0){
        $oCliente_Contacto=cliente_contacto::getByID($oCotizacion->cliente_contacto_ID);
        $oRepresentanteCliente=persona::getByID($oCliente_Contacto->persona_ID);
    }else{
        $oRepresentanteCliente=new persona();
    }


    $oForma_Pago=forma_pago::getByID($oCotizacion->forma_pago_ID);
    if($oCotizacion->forma_pago_ID==0){
        $oForma_Pago=new forma_pago();
    }
    if($oForma_Pago==null){

        $oForma_Pago=new forma_pago();
    }
    $oOperador=operador::getByID($oCotizacion->operador_ID);
    if(isset($oOperador)){
         $oEjecutivo=persona::getByID($oOperador->persona_ID);
    }else{
        $oOperador=new operador();
         $oEjecutivo=new persona();
    }
   
    
    
    
    $dtCotizacion_Numero_Cuenta=cotizacion_numero_cuenta::getGrid1('cnc.cotizacion_ID='.$id,-1,-1);
    $pdf= new PDF1('P','mm','A4');
    $pdf->oCotizacion=$oCotizacion;
    $pdf->oDatos_Generales=$oDatos_Generales;
    $pdf->oCliente=$oCliente;
    $pdf->oRepresentanteCliente=$oRepresentanteCliente;
    $pdf->oEjecutivo=$oEjecutivo;
    $pdf->oMoneda=$oMoneda;
    $pdf->oForma_Pago=$oForma_Pago;
    $pdf->oOperador=$oOperador;
    $pdf->dtCotizacion_Numero_Cuenta=$dtCotizacion_Numero_Cuenta;
    $pdf->AliasNbPages();
      //Cargamos los detalles
    $numero=0;
    for($i=1;$i<=$oCotizacion->numero_pagina;$i++){
        $ultima_unicacion_detalle_cotizacion=cotizacion_detalle::maxUbicacion($id);
        $pdf->AddPage();
        if($i==1){
            $pdf->presentacion();
        }


        $dtCotizacion_Detalle=cotizacion_detalle::getGrid('cotizacion_ID='.$oCotizacion->ID.' and pagina_cotizacion='.$i,-1,-1,'pagina_cotizacion asc , orden_cotizacion asc');
        $alto_contenedor=120;
        $posY=80;
        $y=88;
        if($oCotizacion->numero_pagina>1&&$i==1){
            $alto_contenedor=150;

        }
        if($i>1&&($i<=$oCotizacion->numero_pagina-1)){
            $alto_contenedor=190;
            $posY=50;
            $y=58;
        }
        if($oCotizacion->numero_pagina>1&&$i==$oCotizacion->numero_pagina){
            $posY=50;
            $alto_contenedor=150;
             $y=58;
        }
        if($i<=$ultima_unicacion_detalle_cotizacion){
            $pdf->contenedor_detalle($alto_contenedor,$posY);
        }

        $pdf->SetFont('Arial','',9);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetXY(10,$y);
        $item=0;
        $cotizacion_detalle_ID=0;
        $tipo_ID=0;
        $tipo=0;
        foreach ($dtCotizacion_Detalle as $fila){
            $oProducto=producto::getByID($fila['producto_ID']);
            if($fila['tipo_ID']==3||$fila['tipo_ID']==4){
                $item++;
                    $ancho=70;
                    $pdf->SetX(20);
                    $pdf->SetFont('Arial','B',6);
                    if($tipo!=$fila['tipo']){
                        //$cotizacion_detalle_ID=$fila['cotizacion_detalle_ID'];
                        $item=1;
                        $tipo=$fila['tipo'];
                        $pdf->SetTextColor(0);
                        if($fila['tipo']==3){

                            $contador_ver_precio=cotizacion_detalle::getCount('cotizacion_detalle_ID='.$fila['cotizacion_detalle_ID'].' and tipo_ID=3 and ver_precio=1');
                            if($contador_ver_precio==0){
                                $ancho=100;
                                $pdf->Cell(10,5,utf8_decode('#'),0,0,'C',false);
                                $pdf->Cell($ancho,5,utf8_decode('COMPONENTE'),0,0,'C',false);
                                $pdf->Cell(10,5,utf8_decode('CANT'),0,0,'C',false);
                                }else {
                                $ancho=70;
                                $pdf->Cell(10,5,utf8_decode('#'),0,0,'C',false);
                                $pdf->Cell($ancho,5,utf8_decode('COMPONENTE'),0,0,'C',false);
                                $pdf->Cell(10,5,utf8_decode('CANT'),0,0,'C',false);
                                $pdf->Cell(15,5,utf8_decode('P/U'),0,0,'R',false);
                                $pdf->Cell(15,5,utf8_decode('TOTAL'),0,0,'R',false);
                            }
                        }else {

                            $contador_ver_precio=cotizacion_detalle::getCount('cotizacion_detalle_ID='.$fila['cotizacion_detalle_ID'].' and tipo_ID=4 and ver_precio=1');

                            if($contador_ver_precio==0){
                                $ancho=100;

                                $pdf->Cell(10,5,utf8_decode('#'),0,0,'C',false);
                                $pdf->Cell($ancho,5,utf8_decode('ADICIONAL'),0,0,'C',false);
                                $pdf->Cell(10,5,utf8_decode('CANT'),0,0,'C',false);
                            }else {
                                $ancho=70;
                                $pdf->Cell(10,5,utf8_decode('#'),0,0,'C',false);
                                $pdf->Cell($ancho,5,utf8_decode('ADICIONAL'),0,0,'C',false);
                                $pdf->Cell(10,5,utf8_decode('CANT'),0,0,'C',false);
                                $pdf->Cell(15,5,utf8_decode('P/U'),0,0,'R',false);
                                $pdf->Cell(15,5,utf8_decode('TOTAL'),0,0,'R',false);
                            }

                        }


                        $pdf->Ln(4);
                    }else {
                        //$cotizacion_detalle_ID=$fila['cotizacion_detalle_ID'];
                        //$tipo=$fila['tipo'];
                        if($contador_ver_precio==0){
                        $ancho=100;

                        }else {
                            $ancho=70;

                        }
                    }

                    $pdf->SetAligns(array('C','L','C','R','R'));
                    $pdf->SetWidths(array(10,$ancho,10,15,15));
                    $precio_unitario1=0;
                    $subtotal1=0;
                    if($fila['ver_precio']==1){
                        if($oCotizacion->moneda_ID==1){
                        $precio_unitario1=number_format($fila['precio_venta_unitario_soles'],2,".",",");
                        $subtotal=number_format($fila['precio_venta_subtotal_soles'],2,".",",");
                        }else {
                            $precio_unitario1=number_format($fila['precio_venta_unitario_dolares'],2,".",",");
                            $subtotal1=number_format($fila['precio_venta_subtotal_dolares'],2,".",",");
                        }
                    }else {
                        $precio_unitario1='';
                        $subtotal1='';
                    }
                    $pdf->SetX(20);
                    $pdf->SetTextColor(0);
                    $pdf->SetFont('Arial','B',6);
                    $pdf->Row(array($item, strtoupper($oProducto->nombre), $fila['cantidad'], $precio_unitario1,$subtotal1),3);
                    if(trim($fila['descripcion'])!=''){
                        $pdf->SetTextColor(99,98,98);
                        $pdf->SetFont('Arial','',6);

                        $pdf->SetX(30);
                        $pdf->MultiCell($ancho,3,  strtoupper($fila['descripcion']),0,'J',false);

                    }
//Creamos la cabecera para los componentes o adicionales


            }else {
                $cotizacion_detalle_ID=0;
                $item=0;
                $numero++;
                $pdf->SetX(10);
                //$array_cotizacion_detalle=array();
                $pdf->SetWidths(array(10,120,15,20,25));
                $pdf->SetAligns(array('C','L','C','R','R'));

                $precio_unitario=0;
                $subtotal=0;
                if($oCotizacion->moneda_ID==1){
                    $precio_unitario=$fila['precio_venta_unitario_soles'];
                    $subtotal=$fila['precio_venta_subtotal_soles'];
                }else {
                    $precio_unitario=$fila['precio_venta_unitario_dolares'];
                    $subtotal=$fila['precio_venta_subtotal_dolares'];
                }
                $pdf->SetFont('Arial','B',8);
                $pdf->SetTextColor(0);
                $pdf->Row(array($numero, strtoupper($oProducto->nombre), $fila['cantidad'], number_format($precio_unitario,2,".",","),number_format($subtotal,2,".",",")),5);
                //$pdf->SetTextColor(99,98,98);
                if(trim($fila['descripcion'])!=''){
                    $pdf->SetTextColor(99,98,98);
                    $pdf->SetFont('Arial','',6);
                    $pdf->SetX(20);
                    $pdf->MultiCell(120,3,  strtoupper($fila['descripcion']),0,'J',false);

                }

            }

        }

        if($ultima_unicacion_detalle_cotizacion==$i){
            $y_costo=248;
            if($oCotizacion->numero_pagina==$i){
                $y_costo=208;
            }
            $pdf->costo_total($y_costo);

        }
        $y_otro=208;
        if($oCotizacion->numero_pagina>$ultima_unicacion_detalle_cotizacion){
            $y_otro=50;
        }
        if($oCotizacion->numero_pagina==$i){
            $pdf->otros_datos($y_otro);

        }

    }


    //$pdf->Rect(10,88,10,180);
    $pdf->Output('cotizacion_Nro'.sprintf("%'.07d",$oCotizacion->numero).'.pdf','D');

}
function get_Cotizacion_Mantenimiento_Producto_Editar($id){
    require ROOT_PATH . 'models/categoria.php';
    require ROOT_PATH . 'models/linea.php';
    require ROOT_PATH . 'models/producto.php';
    require ROOT_PATH . 'models/cotizacion.php';
    require ROOT_PATH . 'models/cotizacion_detalle.php';
    require ROOT_PATH . 'models/inventario.php';
    require ROOT_PATH . 'controls/funcionController.php';
    global  $returnView_float;

    $returnView_float=true;
    $dtCategoria=categoria::getGrid();
    $dtLinea=linea::getGrid();
    //$dtProducto=producto::getGrid();

    $oCotizacion_Detalle=cotizacion_detalle::getByID($id);

//        $dtCotizacion_Detalle_Hijo=cotizacion_detalle::getGrid('cotizacion_detalle_ID='.$id);
//        $contar=count($dtCotizacion_Detalle_Hijo);
    $oCotizacion=cotizacion::getByID($oCotizacion_Detalle->cotizacion_ID);
    $oInventario=new inventario();
    $stock=$oInventario->getStock($oCotizacion_Detalle->producto_ID);
    $oProducto=producto::getByID($oCotizacion_Detalle->producto_ID);
    $oCategoria=categoria::getByID($oProducto->categoria_ID);
    $oLinea=linea::getByID($oCategoria->linea_ID);
    $oCotizacion_Detalle->oProducto=$oProducto;
    $oInventario->stock=$stock;
    $array=retornar_valores($oCotizacion_Detalle->tipo_ID);
    //print_r($array);
    $oCotizacion_Detalle->componente=$array['componente'];
    $oCotizacion_Detalle->adicional=$array['adicional'];
    $oCotizacion_Detalle=llenarValoresCotizacion($oCotizacion_Detalle);
//        $GLOBALS['totalHijo']=$contar;
    $GLOBALS['dtCategoria']=$dtCategoria;
    $GLOBALS['categoria_ID']=$oCategoria->ID;
    $GLOBALS['dtLinea']=$dtLinea;
    $GLOBALS['linea_ID']=$oLinea->ID;
    //$GLOBALS['dtProducto']=$dtProducto;
    $GLOBALS['oCotizacion_Detalle']=$oCotizacion_Detalle;
    $GLOBALS['oCotizacion']=$oCotizacion;
    $GLOBALS['oInventario']=$oInventario;
    //$GLOBALS['oProducto']=$oProducto;
}

function post_cotizacion_mantenimiento_producto_editar($id){
    require ROOT_PATH . 'models/categoria.php';
    require ROOT_PATH . 'models/linea.php';
    require ROOT_PATH . 'models/producto.php';
    require ROOT_PATH . 'models/cotizacion_detalle.php';
    require ROOT_PATH . 'models/cotizacion.php';
    require ROOT_PATH . 'models/inventario.php';
    require ROOT_PATH . 'controls/funcionController.php';
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
    $producto_ID=$_POST['selProducto'];
    $descripcion=trim($_POST['txtDescripcion']);
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
    if(isset($_POST['txtTiempo_Separacion'])){
        $tiempo_separacion=$_POST['txtTiempo_Separacion'];
    }else {
        $tiempo_separacion=0;
    }

    try{

        $oCotizacion_Detalle=cotizacion_detalle::getByID($id);
        $producto_ID_old=$oCotizacion_Detalle->producto_ID;
        $oCotizacion_Detalle->producto_ID=$producto_ID;
        $oCotizacion_Detalle->descripcion=$descripcion;
        $oCotizacion_Detalle->cantidad=$cantidad;
        $oCotizacion_Detalle->cotizacion_detalle_ID=0;
        $oCotizacion_Detalle->estado_id=0;
        $oCotizacion_Detalle->ver_precio=1;
        $oCotizacion_Detalle->separacion=$separacion;
        $oCotizacion_Detalle->tiempo_separacion=$tiempo_separacion;
        //Tipo 1, es tipo producto detalle;
        $oCotizacion_Detalle->tipo_ID=$tipo;
        $oCotizacion_Detalle->usuario_mod_id=$_SESSION['usuario_ID'];
        $oCotizacion_Detalle->actualizar1();
        //$oCotizacion_Detalle->actualizar();
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
//            }
        separarProductoCotizacion($oCotizacion_Detalle,$producto_ID_old);

        /*Actualizamos los costos en la tabla cotizacion*/

        $dtCotizacion_Detalle=cotizacion_detalle::getGrid('cotizacion_ID='.$oCotizacion_Detalle->cotizacion_ID.' and cotizacion_detalle_ID=0 and tipo_ID in (1,2,5,6)');
        $precio_venta_neto_soles=0;
        $precio_venta_neto_dolares=0;

        foreach($dtCotizacion_Detalle as $item){
            $precio_venta_neto_soles=$precio_venta_neto_soles+$item['precio_venta_subtotal_soles'];
            $precio_venta_neto_dolares=$precio_venta_neto_dolares+$item['precio_venta_subtotal_dolares'];

        }
        $oCotizacion=cotizacion::getByID($oCotizacion_Detalle->cotizacion_ID);
        $oCotizacion->precio_venta_neto_soles=$precio_venta_neto_soles;
        $oCotizacion->precio_venta_neto_dolares=$precio_venta_neto_dolares;
        $oCotizacion->vigv_soles=$precio_venta_neto_soles*($oCotizacion->igv);;
        //$oCotizacion->fecha=FormatTextToDate($oCotizacion->fecha,'d/m/Y');
        $oCotizacion->vigv_dolares=$precio_venta_neto_dolares*($oCotizacion->igv);
        $oCotizacion->precio_venta_total_soles=$precio_venta_neto_soles*(1+$oCotizacion->igv);
        $oCotizacion->precio_venta_total_dolares=$precio_venta_neto_dolares*(1+$oCotizacion->igv);
        $oCotizacion->usuario_mod_id=$_SESSION['usuario_ID'];
        $oCotizacion->actualizar1();

        /*Actualizamos el estado del inventario a separado*/

        $resultado=1;
        $mensaje=$oCotizacion_Detalle->message;

    }catch(Exception $ex){
      $resultado=-1;
      $mensaje=$ex->getMessage();
    }
    $dtCategoria=categoria::getGrid('',-1,-1,'ca.nombre');
    $dtLinea=linea::getGrid('',-1,-1,'li.nombre');
    //$dtProducto=producto::getGrid('',-1,-1,'pr.nombre');
    $oInventario=new inventario();
    $oProducto=producto::getByID($producto_ID);
    $oCotizacion_Detalle->oProducto=$oProducto;
    $oCategoria=categoria::getByID($oProducto->categoria_ID);
    $stock=$oInventario->getStock($producto_ID);
    $oCotizacion_Detalle->adicional=$adicional;
    $oCotizacion_Detalle->componente=$componente;
    $oCotizacion_Detalle=llenarValoresCotizacion($oCotizacion_Detalle);
    $oInventario->stock=$stock;
    $oCotizacion_Detalle->categoria_ID=$oProducto->categoria_ID;
    $oCotizacion_Detalle->linea_ID=$oCategoria->linea_ID;
    $GLOBALS['dtCategoria']=$dtCategoria;
    $GLOBALS['dtLinea']=$dtLinea;
    //$GLOBALS['dtProducto']=$dtProducto;
    $GLOBALS['oInventario']=$oInventario;
//        $oCotizacion=cotizacion::getByID($id);
    $GLOBALS['oCotizacion']=$oCotizacion;
    $GLOBALS['oCotizacion_Detalle']=$oCotizacion_Detalle;
    $GLOBALS['resultado']=$resultado;
    $GLOBALS['mensaje']=  $mensaje;

}
function get_cotizacion_mantenimiento_registro_Componente_editar($id){
    require ROOT_PATH . 'models/categoria.php';
    require ROOT_PATH . 'models/linea.php';
    require ROOT_PATH . 'models/producto.php';
    require ROOT_PATH . 'models/cotizacion.php';
    require ROOT_PATH . 'models/cotizacion_detalle.php';
    require ROOT_PATH . 'models/inventario.php';
    global  $returnView_float;

    $returnView_float=true;
    $dtCategoria=categoria::getGrid('',-1,-1,'ca.nombre asc');
    $dtLinea=linea::getGrid('',-1,-1,'li.nombre asc');
    $dtProducto=producto::getGrid('',-1,-1,'pr.nombre asc');
    $oCotizacion_Detalle=cotizacion_detalle::getByID($id);
    $oCotizacion=cotizacion::getByID($oCotizacion_Detalle->cotizacion_ID);
    $oInventario=new inventario();
    $stock=$oInventario->getStock($oCotizacion_Detalle->producto_ID);

    $oProducto=producto::getByID($oCotizacion_Detalle->producto_ID);
    $oCategoria=categoria::getByID($oProducto->categoria_ID);
    $oLinea=linea::getByID($oCategoria->linea_ID);

    $oCategoria=categoria::getByID($oProducto->categoria_ID);
    $oCotizacion_Detalle->linea_ID=$oCategoria->linea_ID;
    $oCotizacion_Detalle->dtLinea=$dtLinea;
    $oCotizacion_Detalle->categoria_ID=$oProducto->categoria_ID;
    $oCotizacion_Detalle->dtCategoria=$dtCategoria;
    $oCotizacion_Detalle->oCotizacion=$oCotizacion;
    $oCotizacion_Detalle->cotizacion_detalle_padre_ID=$id;
    $oCotizacion_Detalle->stock=$stock;
    $oCotizacion_Detalle->oProducto=$oProducto;
    $GLOBALS['dtProducto']=$dtProducto;
    $GLOBALS['oCotizacion_Detalle']=$oCotizacion_Detalle;
    $GLOBALS['oCotizacion']=$oCotizacion;
    $GLOBALS['oInventario']=$oInventario;
}
function post_cotizacion_mantenimiento_registro_Componente_editar($id){
    require ROOT_PATH . 'models/categoria.php';
    require ROOT_PATH . 'models/linea.php';
    require ROOT_PATH . 'models/producto.php';
    require ROOT_PATH . 'models/cotizacion_detalle.php';
    require ROOT_PATH . 'models/cotizacion.php';
    require ROOT_PATH . 'models/inventario.php';
    global  $returnView_float;
    $returnView_float=true;
    $tipo=3;
    $producto_ID=$_POST['selProducto'];
    $descripcion=  FormatTextSave(strtoupper($_POST['txtDescripcion']));
    $cantidad=$_POST['txtCantidad'];
     if(isset($_POST['cbVer_Precio'])){
         $ver_precio=$_POST['cbVer_Precio'];
    }else {$ver_precio=0;}
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

    }else {$separacion=0;}
    if(isset($_POST['txtTiempo_Separacion'])){
        $tiempo_separacion=$_POST['txtTiempo_Separacion'];
    }else{
        $tiempo_separacion=0;
    }
    $oCotizacion_Detalle=cotizacion_detalle::getByID($id);
    try{
        $producto_ID_old=$oCotizacion_Detalle->producto_ID;
        $oCotizacion_Detalle->producto_ID=$producto_ID;
        $oCotizacion_Detalle->descripcion=$descripcion;
        $oCotizacion_Detalle->cantidad=$cantidad;
        $oCotizacion_Detalle->precio_venta_unitario_soles=$PrecioUnitarioSoles;
        $oCotizacion_Detalle->precio_venta_unitario_dolares=$PrecioUnitarioDolares;
        $oCotizacion_Detalle->precio_venta_subtotal_soles=$SubTotalSoles;
        $oCotizacion_Detalle->precio_venta_subtotal_dolares=$SubTotalDolares;
        $oCotizacion_Detalle->igv=$Igv;
        $oCotizacion_Detalle->vigv_soles=$IgvSoles;
        $oCotizacion_Detalle->vigv_dolares=$IgvDolares;
        $oCotizacion_Detalle->precio_venta_soles=$TotalSoles;
        $oCotizacion_Detalle->precio_venta_dolares=$TotalDolares;
        //$oCotizacion_Detalle->cotizacion_detalle_ID=0;
        //$oCotizacion_Detalle->estado_id=0;
        $oCotizacion_Detalle->ver_precio=$ver_precio;
        $oCotizacion_Detalle->separacion=$separacion;
        $oCotizacion_Detalle->tiempo_separacion=$tiempo_separacion;
        $oCotizacion_Detalle->tipo_ID=$tipo;
        $oCotizacion_Detalle->usuario_mod_id=$_SESSION['usuario_ID'];

        $oCotizacion_Detalle->actualizar();
         //Actualizamos el tipo, solo cuando es componente interno
        separarProductoCotizacion($oCotizacion_Detalle,$producto_ID_old);
        $oCotizacion_Detalle_Padre=cotizacion_detalle::getByID($oCotizacion_Detalle->cotizacion_detalle_ID);
        /*Actualizamos los costos en la el costo del padre*/
        $oCotizacion_Detalle_Padre=actualizar_costo_cotizacion_detalle_padre($oCotizacion_Detalle_Padre);
        $mensaje=actualizar_costo_cotizacion($oCotizacion_Detalle_Padre);

        $resultado=1;


    }catch(Exception $ex){
      $resultado=-1;
      $mensaje=$ex->getMessage();
    }
    $dtCategoria=categoria::getGrid('',-1,-1,'ca.nombre asc');
    $dtLinea=linea::getGrid('',-1,-1,'li.nombre asc');
    $dtProducto=producto::getGrid('',-1,-1,'pr.nombre asc');
    $oInventario=new inventario();
    $oCotizacion=cotizacion::getByID($oCotizacion_Detalle->cotizacion_ID);
    $stock=$oInventario->getStock($producto_ID);
    $oProducto=producto::getByID($producto_ID);
    $oCategoria=categoria::getByID($oProducto->categoria_ID);
    $oCotizacion_Detalle->linea_ID=$oCategoria->linea_ID;
    $oCotizacion_Detalle->dtLinea=$dtLinea;
    $oCotizacion_Detalle->categoria_ID=$oProducto->categoria_ID;
    $oCotizacion_Detalle->dtCategoria=$dtCategoria;
    $oCotizacion_Detalle->oCotizacion=$oCotizacion;

    $oCotizacion_Detalle->stock=$stock;
    $oCotizacion_Detalle->oProducto=$oProducto;

    $GLOBALS['oCotizacion']=$oCotizacion;
    $GLOBALS['dtProducto']=producto::getGrid("",-1,-1,"pr.nombre asc");
    $GLOBALS['oCotizacion_Detalle']=$oCotizacion_Detalle;
    $GLOBALS['resultado']=$resultado;
    $GLOBALS['mensaje']=$mensaje;
}
function post_ajaxCotizacion_Mantenimiento_Registro_Componente_Eliminar(){
    require ROOT_PATH.'models/cotizacion_detalle.php';
    require ROOT_PATH.'models/cotizacion.php';
    require ROOT_PATH.'models/inventario.php';
    $id=$_POST['id'];
    try{
        $oCotizacion_Detalle=cotizacion_detalle::getByID($id);
        $oCotizacion_Detalle->usuario_mod_id=$_SESSION['usuario_ID'];
        limpiar_separaciones($oCotizacion_Detalle);
        if($oCotizacion_Detalle==null){
                throw new Exception('Parece que el registro ya fue eliminado.');
        }

        if ($oCotizacion_Detalle->eliminar()==-1){
                throw new Exception($oCotizacion_Detalle->message);
        }
        $oCotizacion_Detalle_Padre=cotizacion_detalle::getByID($oCotizacion_Detalle->cotizacion_detalle_ID);
        $oCotizacion_Detalle_Padre=actualizar_costo_cotizacion_detalle_padre($oCotizacion_Detalle_Padre);
        actualizar_costo_cotizacion($oCotizacion_Detalle_Padre);

        $resultado=1;
        $mensaje=$oCotizacion_Detalle->message;

    }catch(Exception $ex){
        $resultado=-1;
        $mensaje=$ex->getMessage();

    }

    $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);

    echo json_encode($retornar);
}
function get_cotizacion_mantenimiento_registro_Adicional_editar($id){
    require ROOT_PATH . 'models/categoria.php';
    require ROOT_PATH . 'models/linea.php';
    require ROOT_PATH . 'models/producto.php';
    require ROOT_PATH . 'models/cotizacion.php';
    require ROOT_PATH . 'models/cotizacion_detalle.php';
    require ROOT_PATH . 'models/inventario.php';
    global  $returnView_float;

    $returnView_float=true;
    $dtCategoria=categoria::getGrid('',-1,-1,'ca.nombre asc');
    $dtLinea=linea::getGrid('',-1,-1,'li.nombre asc');
    //$dtProducto=producto::getGrid('',-1,-1,'pr.nombre asc');
    $oCotizacion_Detalle=cotizacion_detalle::getByID($id);
    $oCotizacion=cotizacion::getByID($oCotizacion_Detalle->cotizacion_ID);
    $oInventario=new inventario();
    $stock=$oInventario->getStock($oCotizacion_Detalle->producto_ID);

    $oProducto=producto::getByID($oCotizacion_Detalle->producto_ID);
    $oCategoria=categoria::getByID($oProducto->categoria_ID);
    $oLinea=linea::getByID($oCategoria->linea_ID);

    $oCategoria=categoria::getByID($oProducto->categoria_ID);
    $oCotizacion_Detalle->linea_ID=$oCategoria->linea_ID;
    $oCotizacion_Detalle->dtLinea=$dtLinea;
    $oCotizacion_Detalle->categoria_ID=$oProducto->categoria_ID;
    $oCotizacion_Detalle->dtCategoria=$dtCategoria;
    $oCotizacion_Detalle->oCotizacion=$oCotizacion;
    $oCotizacion_Detalle->cotizacion_detalle_padre_ID=$id;
    $oCotizacion_Detalle->stock=$stock;
    $oCotizacion_Detalle->oProducto=$oProducto;
    //$GLOBALS['dtProducto']=$dtProducto;
    $GLOBALS['oCotizacion_Detalle']=$oCotizacion_Detalle;
    $GLOBALS['oCotizacion']=$oCotizacion;
    $GLOBALS['oInventario']=$oInventario;
}
function post_cotizacion_mantenimiento_registro_Adicional_editar($id){
    require ROOT_PATH . 'models/categoria.php';
    require ROOT_PATH . 'models/linea.php';
    require ROOT_PATH . 'models/producto.php';
    require ROOT_PATH . 'models/cotizacion_detalle.php';
    require ROOT_PATH . 'models/cotizacion.php';
    require ROOT_PATH . 'models/inventario.php';
    global  $returnView_float;
    $returnView_float=true;
    $tipo=4;
    $producto_ID=$_POST['selProducto'];
    $descripcion=  FormatTextSave($_POST['txtDescripcion']);
    $cantidad=$_POST['txtCantidad'];
     if(isset($_POST['cbVer_Precio'])){
         $ver_precio=$_POST['cbVer_Precio'];
    }else {$ver_precio=0;}
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

    }else {$separacion=0;}
    if(isset($_POST['txtTiempo_Separacion'])){
        $tiempo_separacion=$_POST['txtTiempo_Separacion'];
    }else{
        $tiempo_separacion=0;
    }
    $oCotizacion_Detalle=cotizacion_detalle::getByID($id);
    try{
        $producto_ID_old=$oCotizacion_Detalle->producto_ID;
        $oCotizacion_Detalle->producto_ID=$producto_ID;
        $oCotizacion_Detalle->descripcion=$descripcion;
        $oCotizacion_Detalle->cantidad=$cantidad;
        $oCotizacion_Detalle->precio_venta_unitario_soles=$PrecioUnitarioSoles;
        $oCotizacion_Detalle->precio_venta_unitario_dolares=$PrecioUnitarioDolares;
        $oCotizacion_Detalle->precio_venta_subtotal_soles=$SubTotalSoles;
        $oCotizacion_Detalle->precio_venta_subtotal_dolares=$SubTotalDolares;
        $oCotizacion_Detalle->igv=$Igv;
        $oCotizacion_Detalle->vigv_soles=$IgvSoles;
        $oCotizacion_Detalle->vigv_dolares=$IgvDolares;
        $oCotizacion_Detalle->precio_venta_soles=$TotalSoles;
        $oCotizacion_Detalle->precio_venta_dolares=$TotalDolares;
        //$oCotizacion_Detalle->cotizacion_detalle_ID=0;
        //$oCotizacion_Detalle->estado_id=0;

        $oCotizacion_Detalle->ver_precio=$ver_precio;
        $oCotizacion_Detalle->separacion=$separacion;
        $oCotizacion_Detalle->tiempo_separacion=$tiempo_separacion;
        $oCotizacion_Detalle->tipo_ID=$tipo;
        $oCotizacion_Detalle->usuario_mod_id=$_SESSION['usuario_ID'];
        $oCotizacion_Detalle->actualizar();
         //Actualizamos el tipo, solo cuando es componente interno
        separarProductoCotizacion($oCotizacion_Detalle,$producto_ID_old);
        $oCotizacion_Detalle_Padre=cotizacion_detalle::getByID($oCotizacion_Detalle->cotizacion_detalle_ID);
        /*Actualizamos los costos en la el costo del padre*/
        $oCotizacion_Detalle_Padre=actualizar_costo_cotizacion_detalle_padre($oCotizacion_Detalle_Padre);
        $mensaje=actualizar_costo_cotizacion($oCotizacion_Detalle_Padre);

        $resultado=1;


    }catch(Exception $ex){
      $resultado=-1;
      $mensaje=$ex->getMessage();
    }
    $dtCategoria=categoria::getGrid('',-1,-1,'ca.nombre asc');
    $dtLinea=linea::getGrid('',-1,-1,'li.nombre asc');
    //$dtProducto=producto::getGrid('',-1,-1,'pr.nombre asc');
    $oInventario=new inventario();
    $oCotizacion=cotizacion::getByID($oCotizacion_Detalle->cotizacion_ID);
    $stock=$oInventario->getStock($producto_ID);
    $oProducto=producto::getByID($producto_ID);
    $oCategoria=categoria::getByID($oProducto->categoria_ID);
    $oCotizacion_Detalle->linea_ID=$oCategoria->linea_ID;
    $oCotizacion_Detalle->dtLinea=$dtLinea;
    $oCotizacion_Detalle->categoria_ID=$oProducto->categoria_ID;
    $oCotizacion_Detalle->dtCategoria=$dtCategoria;
    $oCotizacion_Detalle->oCotizacion=$oCotizacion;

    $oCotizacion_Detalle->stock=$stock;
    $oCotizacion_Detalle->oProducto=$oProducto;
    $GLOBALS['oCotizacion']=$oCotizacion;
    $GLOBALS['oCotizacion_Detalle']=$oCotizacion_Detalle;
    $GLOBALS['resultado']=$resultado;
    $GLOBALS['mensaje']=$mensaje;
}
function post_ajaxCotizacion_Mantenimiento_Registro_Adicional_Eliminar(){
    require ROOT_PATH.'models/cotizacion_detalle.php';
    require ROOT_PATH.'models/cotizacion.php';
    require ROOT_PATH.'models/inventario.php';
    $id=$_POST['id'];
    try{
        $oCotizacion_Detalle=cotizacion_detalle::getByID($id);
        $oCotizacion_Detalle->usuario_mod_id=$_SESSION['usuario_ID'];
        limpiar_separaciones($oCotizacion_Detalle);
        if($oCotizacion_Detalle==null){
            throw new Exception('Parece que el registro ya fue eliminado.');
        }

        if ($oCotizacion_Detalle->eliminar()==-1){
            throw new Exception($oCotizacion_Detalle->message);
        }
        $oCotizacion_Detalle_Padre=cotizacion_detalle::getByID($oCotizacion_Detalle->cotizacion_detalle_ID);
        $oCotizacion_Detalle_Padre=actualizar_costo_cotizacion_detalle_padre($oCotizacion_Detalle_Padre);
        actualizar_costo_cotizacion($oCotizacion_Detalle_Padre);

        $resultado=1;
        $mensaje=$oCotizacion_Detalle->message;

    }catch(Exception $ex){
        $resultado=-1;
        $mensaje=$ex->getMessage();

    }

    $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);

    echo json_encode($retornar);
}
function limpiar_separaciones($oCotizacion_Detalle){
     $dtInventario=inventario::getGrid('producto_ID='.$oCotizacion_Detalle->producto_ID.' and estado_ID=51 and cotizacion_detalle_ID='.$oCotizacion_Detalle->ID,-1,-1,'ID asc');
    if(count($dtInventario)>0){
        foreach($dtInventario as $item){
            $oInventario=inventario::getByID($item['ID']);
            $oInventario->estado_ID=48;
            $oInventario->cotizacion_detalle_ID="NULL";
            if(!isset($oInventario->ingreso_detalle_ID)){
                $oInventario->ingreso_detalle_ID='NULL';
            }

            if(!isset($oInventario->salida_detalle_ID)){
            $oInventario->salida_detalle_ID='NULL';
            }
            $oInventario->usuario_mod_id=$_SESSION['usuario_ID'];
            $oInventario->actualizar();

        }
            $oCotizacion_Detalle->separacion=0;
            $oCotizacion_Detalle->tiempo_separacion=0;
            $oCotizacion_Detalle->cantidad_separada=0;
            $oCotizacion_Detalle->usuario_mod_id=$_SESSION['usuario_ID'];
            $oCotizacion_Detalle->actualizar();
    }
}
function post_ajaxCotizacion_Detalle_Mantenimiento_Eliminar(){
    require ROOT_PATH.'models/cotizacion_detalle.php';
    require ROOT_PATH.'models/cotizacion.php';
    require ROOT_PATH.'models/inventario.php';
    $id=$_POST['id'];
    try{
        $oCotizacion_Detalle=cotizacion_detalle::getByID($id);
        $Hijos=cotizacion_detalle::getCount('cotizacion_detalle_ID='.$id);
        if($Hijos>0){
            throw new Exception('No se puede eliminar el registro, tiene detalles.');
        }
        $oCotizacion_Detalle->usuario_mod_id=$_SESSION['usuario_ID'];
        if($oCotizacion_Detalle==null){
            throw new Exception('Parece que el registro ya fue eliminado.');
        }
        eliminarSeparacionesProductoCotizacion($oCotizacion_Detalle);

        if ($oCotizacion_Detalle->eliminar()==-1){
             throw new Exception($oCotizacion_Detalle->message);
        }
        /*Actualizamos los costos en la tabla cotizacion*/
        actualizar_costo_cotizacion($oCotizacion_Detalle);
        $resultado=1;
        $mensaje=$oCotizacion_Detalle->message;

    }catch(Exception $ex){
            $resultado=-1;
            $mensaje=$ex->getMessage();

    }

    $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);

    echo json_encode($retornar);
}
function get_cotizacion_mantenimiento_obsequio_nuevo($id){
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
    $oCotizacion=cotizacion::getByID($id);
    $oCotizacion_Detalle=new cotizacion_detalle();
    //$oCotizacion_Detalle->descripcion="";
    $oCotizacion_Detalle->categoria_ID=0;
    $oCotizacion_Detalle->linea_ID=0;
    $oCotizacion_Detalle->producto_ID=0;

    //$oCotizacion->descripcion='';
    $oInventario=new inventario();
    $GLOBALS['linea_ID']=0;
    $GLOBALS['categoria_ID']=0;

    $GLOBALS['dtCategoria']=$dtCategoria;
    $GLOBALS['dtLinea']=$dtLinea;
    $GLOBALS['dtProducto']=$dtProducto;
    $GLOBALS['oCotizacion_Detalle']=$oCotizacion_Detalle;
    $GLOBALS['oCotizacion']=$oCotizacion;
    $GLOBALS['oInventario']=$oInventario;
    $GLOBALS['oProducto']=new producto();
}
function post_cotizacion_mantenimiento_obsequio_nuevo($id){
    require ROOT_PATH . 'models/categoria.php';
    require ROOT_PATH . 'models/linea.php';
    require ROOT_PATH . 'models/producto.php';
    require ROOT_PATH . 'models/cotizacion_detalle.php';
    require ROOT_PATH . 'models/cotizacion.php';
    require ROOT_PATH . 'models/inventario.php';
    global  $returnView_float;
    $returnView_float=true;

    $tipo=7;
    $producto_ID=$_POST['selProducto'];
    $descripcion=FormatTextSave(strtoupper(trim($_POST['txtDescripcion'])));
    $cantidad=$_POST['txtCantidad'];
    $PrecioUnitarioSoles=0;
    $PrecioUnitarioDolares=0;
    $SubTotalSoles=0;
    $SubTotalDolares=0;
    $Igv=0;
    $IgvSoles=0;
    $IgvDolares=0;
    $TotalSoles=0;
    $TotalDolares=0;

    if(isset($_POST['ckSeparacion'])){
        $separacion=$_POST['ckSeparacion'];
    }else {
        $separacion=0;
    }
    if(isset($_POST['txtTiempo_Separacion'])){
        $tiempo_separacion=$_POST['txtTiempo_Separacion'];
    }else {
        $tiempo_separacion=0;
    }

    try{

        $oCotizacion_Detalle=new cotizacion_detalle();
        $oCotizacion_Detalle->producto_ID=$producto_ID;
        $oCotizacion_Detalle->descripcion=$descripcion;
        $oCotizacion_Detalle->cantidad=$cantidad;
        $oCotizacion_Detalle->cotizacion_detalle_ID=0;
        $oCotizacion_Detalle->estado_id=0;
        $oCotizacion_Detalle->ver_precio=0;
        $oCotizacion_Detalle->separacion=$separacion;
        $oCotizacion_Detalle->tiempo_separacion=$tiempo_separacion;
        //$oCotizacion_Detalle->cantidad_separada=$cantidad;
        //Tipo 1, es tipo producto detalle;
        $oCotizacion_Detalle->tipo_ID=$tipo;
        $oCotizacion_Detalle->tipo=$tipo;
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
        $producto_ID_old=$oCotizacion_Detalle->producto_ID;
        separarProductoCotizacion($oCotizacion_Detalle,$producto_ID_old);

        //separarProducto($oCotizacion_Detalle,1);

        /*Actualizamos los costos en la tabla cotizacion*/



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
function get_cotizacion_mantenimiento_obsequio_editar($id){
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
    $oCotizacion_Detalle=cotizacion_detalle::getByID($id);
    $oProducto=producto::getByID($oCotizacion_Detalle->producto_ID);
    $oCotizacion=cotizacion::getByID($oCotizacion_Detalle->cotizacion_ID);
    $oCotizacion_Detalle->oProducto=$oProducto;
    $oInventario=new inventario();
    $stock=$oInventario->getStock($oCotizacion_Detalle->producto_ID);
    $oInventario->stock=$stock;

    $GLOBALS['dtCategoria']=$dtCategoria;
    $GLOBALS['dtLinea']=$dtLinea;
    $GLOBALS['dtProducto']=$dtProducto;
    $GLOBALS['oCotizacion_Detalle']=$oCotizacion_Detalle;
    $GLOBALS['oCotizacion']=$oCotizacion;
    $GLOBALS['oInventario']=$oInventario;
//        $GLOBALS['oProducto']=new producto();
}

function post_cotizacion_mantenimiento_obsequio_editar($id){
    require ROOT_PATH . 'models/categoria.php';
    require ROOT_PATH . 'models/linea.php';
    require ROOT_PATH . 'models/producto.php';
    require ROOT_PATH . 'models/cotizacion_detalle.php';
    require ROOT_PATH . 'models/cotizacion.php';
    require ROOT_PATH . 'models/inventario.php';
    global  $returnView_float;
    $returnView_float=true;

    $tipo=7;
    $producto_ID=$_POST['selProducto'];
    $descripcion=FormatTextSave(strtoupper(trim($_POST['txtDescripcion'])));
    $cantidad=$_POST['txtCantidad'];
    $PrecioUnitarioSoles=0;
    $PrecioUnitarioDolares=0;
    $SubTotalSoles=0;
    $SubTotalDolares=0;
    $Igv=0;
    $IgvSoles=0;
    $IgvDolares=0;
    $TotalSoles=0;
    $TotalDolares=0;

    if(isset($_POST['ckSeparacion'])){
        $separacion=$_POST['ckSeparacion'];
    }else {
        $separacion=0;
    }
    if(isset($_POST['txtTiempo_Separacion'])){
        $tiempo_separacion=$_POST['txtTiempo_Separacion'];
    }else {
        $tiempo_separacion=0;
    }

    try{

    $oCotizacion_Detalle=cotizacion_detalle::getByID($id);
    $producto_ID_old=$oCotizacion_Detalle->producto_ID;
    $oCotizacion_Detalle->producto_ID=$producto_ID;
    $oCotizacion_Detalle->descripcion=$descripcion;
    $oCotizacion_Detalle->cantidad=$cantidad;
    $oCotizacion_Detalle->cotizacion_detalle_ID=0;
    $oCotizacion_Detalle->separacion=$separacion;
    $oCotizacion_Detalle->tiempo_separacion=$tiempo_separacion;
    $oCotizacion_Detalle->cantidad_separada=$cantidad;
    //Tipo 1, es tipo producto detalle;

    $oCotizacion_Detalle->usuario_id=$_SESSION['usuario_ID'];
    $cantidad_no_separado=0;

    $oCotizacion_Detalle->actualizar();
    separarProductoCotizacion($oCotizacion_Detalle,$producto_ID_old);
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
    function get_Cotizacion_Mantenimiento_Editar($id){
            require ROOT_PATH.'models/cotizacion.php';
            require ROOT_PATH.'models/moneda.php';
            require ROOT_PATH.'models/estado.php';
            require ROOT_PATH.'models/cliente.php';
            require ROOT_PATH.'models/cliente_contacto.php';
            require ROOT_PATH.'models/operador.php';
            require ROOT_PATH.'models/datos_generales.php';
            require ROOT_PATH.'models/forma_pago.php';
            require ROOT_PATH.'models/credito.php';
            require ROOT_PATH.'models/numero_cuenta.php';
            require ROOT_PATH.'models/cotizacion_numero_cuenta.php';
            require ROOT_PATH.'controls/funcionController.php';
            global  $returnView_float;
            $returnView_float=true;
            
            $oCotizacion=cotizacion::getByID($id);
            $oCliente=cliente::getByID($oCotizacion->cliente_ID);
            $operador_ID=0;
            if($oCotizacion->operador_ID==null||$oCotizacion->operador_ID==-1){
                $oOperador= new operador();
                $oOperador->nombres="Vendedor";
                $oOperador->apellido_paterno="no asignado";
                $oOperador->telefono="--";
                $oOperador->celular="--";


            }else {
                $oOperador=operador::getByID($oCotizacion->operador_ID);
            }
            if($oCotizacion->estado_ID==25){
                $dtEstado=estado::getGrid('est.ID in (1,2,25)',-1,-1,'est.orden asc');
            }else {
                $dtEstado=estado::getGrid('est.ID in (1,2)',-1,-1,'est.orden asc');
            }
            $dtRepresentanteCliente=  cliente_contacto::getGrid('clic.cliente_ID='. $oCotizacion->cliente_ID);
            $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
            $dtForma_Pago=forma_pago::getGrid();
            $dtCredito=credito::getGrid('id<>0');
            $dtCliente=cliente::getGrid("",-1,-1,"clt.razon_social asc");
            $oNumero_Cuenta=numero_cuenta::getByID(1);
            $GLOBALS['dtNumero_Cuenta']=mostrarNumeroCuentas(2,$oCotizacion->moneda_ID,$oCotizacion,null);
            $GLOBALS['dtRepresentanteCliente']=$dtRepresentanteCliente;
            $GLOBALS['dtCliente']=$dtCliente;
            $GLOBALS['oCliente']=$oCliente;
            $GLOBALS['oCotizacion']=$oCotizacion;
            $GLOBALS['dtCredito']=$dtCredito;
            $GLOBALS['oOperador']=$oOperador;
            $GLOBALS['oDatos_Generales']=$oDatos_Generales;
            $GLOBALS['dtForma_Pago']=$dtForma_Pago;
            $GLOBALS['dtEstado']=$dtEstado;
            $GLOBALS['oNumero_Cuenta']=$oNumero_Cuenta;
            $GLOBALS['dtMoneda']=moneda::getGrid();
            $GLOBALS['mensaje']='';
        }
    function post_Cotizacion_Mantenimiento_Editar($id){
        require ROOT_PATH.'models/cotizacion.php';
        require ROOT_PATH.'models/moneda.php';
        require ROOT_PATH.'models/estado.php';
        require ROOT_PATH.'models/cliente.php';
        require ROOT_PATH.'models/cliente_contacto.php';
        require ROOT_PATH.'models/operador.php';
        require ROOT_PATH.'models/datos_generales.php';
        require ROOT_PATH.'models/forma_pago.php';
        require ROOT_PATH.'models/credito.php';
        require ROOT_PATH.'models/numero_cuenta.php';
        require ROOT_PATH.'models/cotizacion_numero_cuenta.php';
        require ROOT_PATH.'controls/funcionController.php';
            global  $returnView_float;
            $returnView_float=true;
            $cotizacion_ID=$_POST['txtCotizacion_ID'];
            $cliente_ID=$_POST['selCliente'];
            $cliente_contacto_ID=$_POST['selRepresentante'];
            if($cliente_contacto_ID=="--"){
                $cliente_contacto_ID=0;
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
            $tardanza=$_POST['txtTiempo_Avance'];
            $plazo_entrega=$_POST['txtPlazo_Entrega'];
            //$estado_ID=1;
            $tipo_cambio=$_POST['txtTipo_Cambio'];
            $lugar_entrega=$_POST['txtLugar_Entrega'];
            $validez_oferta=$_POST['txtValidez_Oferta'];
            $garantia=$_POST['txtGarantia'];
            $observacion=$_POST['txtObservacion'];
            $estado_ID=$_POST['selEstado'];
            
            try{

                $oCotizacion=cotizacion::getByID($id);
                actualizar_costos_cotizacion_detalle($oCotizacion,$tipo_cambio);
                //$oCotizacionold=$oCotizacion;
                $oCotizacion->cliente_ID=$cliente_ID;
                $oCotizacion->cliente_contacto_ID=$cliente_contacto_ID;
                $oCotizacion->operador_ID=$operador_ID;
                $oCotizacion->periodo=$periodo;
                $oCotizacion->moneda_ID=$moneda_ID;
                $oCotizacion->fecha=$fecha;
                $oCotizacion->forma_pago_ID=$forma_pago_ID;
                $oCotizacion->tiempo_credito=$tiempo_credito;
                $oCotizacion->tardanza=$tardanza;
                $oCotizacion->plazo_entrega=$plazo_entrega;
                $oCotizacion->estado_ID=$estado_ID;
                $oCotizacion->tipo_cambio=$tipo_cambio;
                $oCotizacion->lugar_entrega=$lugar_entrega;
                $oCotizacion->validez_oferta=$validez_oferta;
                $oCotizacion->garantia=$garantia;
                $oCotizacion->observacion=$observacion;
                $oCotizacion->usuario_id=$_SESSION['usuario_ID'];
                $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
                $oCotizacion->igv=$oDatos_Generales->vigv;
                $oCotizacion->usuario_mod_id=$_SESSION['usuario_ID'];
                $oCotizacion->actualizar1();
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
                $dtNumero_Cuenta=numero_cuenta::getGrid('moneda_ID='.$oCotizacion->moneda_ID,-1,1,'ID asc');
                foreach($dtNumero_Cuenta as $value){
                    if(isset($_POST['cknumero_cuenta'.$value['ID']])){
                        $numero_cuenta_ID=$_POST['cknumero_cuenta'.$value['ID']];
                        $oCotizacion_Numero_Cuenta=new cotizacion_numero_cuenta();
                        $oCotizacion_Numero_Cuenta->cotizacion_ID=$oCotizacion->ID;
                        $oCotizacion_Numero_Cuenta->numero_cuenta_ID=$numero_cuenta_ID;
                        $oCotizacion_Numero_Cuenta->usuario_id=$_SESSION['usuario_ID'];
                        $oCotizacion_Numero_Cuenta->insertar();
                        $checked="checked";
                    }

                }
                $mensaje="Se actualizó correctamente";
                $resultado=1;
            }catch(Exception $ex){
                    $resultado=-1;
                    $mensaje=$ex->getMessage();
            }
            $oCliente=cliente::getByID($cliente_ID);
            if($operador_ID=='-1'){
                $oOperador=new operador();
                $oOperador->nombres="Vendedor no";
                $oOperador->apellido_paterno="asignado";
              
                $oOperador->telefono="--";
                $oOperador->celular="-";


            }else {
                $oOperador=operador::getByID($operador_ID);
            }
            //$dtEstado=estado::getGrid('est.tabla="cotizacion"');
            $dtCliente_Contacto=cliente_contacto::getGrid('clic.cliente_ID='.$cliente_ID);

            if($oCotizacion->estado_ID==25){
            $dtEstado=estado::getGrid('est.ID in (1,2,25)',-1,-1,'est.orden asc');
            }else {
                $dtEstado=estado::getGrid('est.ID in (1,2)',-1,-1,'est.orden asc');
            }
            $GLOBALS['dtNumero_Cuenta']=mostrarNumeroCuentas(2,$oCotizacion->moneda_ID,$oCotizacion,null);
            $GLOBALS['oCotizacion']=$oCotizacion;
            $GLOBALS['oCliente']=$oCliente;
            $GLOBALS['dtCliente_Contacto']=$dtCliente_Contacto;
            $GLOBALS['oOperador']=$oOperador;
            $dtCredito=credito::getGrid('id<>0');
            $GLOBALS['dtCredito']=$dtCredito;
            $dtForma_Pago=forma_pago::getGrid();
            $dtCliente=cliente::getGrid("",-1,-1,"clt.razon_social asc");
            $GLOBALS['dtCliente']=$dtCliente;
            $GLOBALS['dtForma_Pago']=$dtForma_Pago;
            $GLOBALS['dtEstado']=$dtEstado;
            $GLOBALS['dtMoneda']=moneda::getGrid();
            
            $GLOBALS['resultado']=$resultado;
            $GLOBALS['mensaje']=$mensaje;
    }
    function actualizar_costos_cotizacion_detalle($oCotizacionold,$tipo_cambio){
        require ROOT_PATH.'models/cotizacion_detalle.php';
        $mensaje='';
        try{
            if($tipo_cambio!=$oCotizacionold->tipo_cambio){
                $dtCotizacion_Detalle=cotizacion_detalle::getGrid('cotizacion_ID='.$oCotizacionold->ID.' and tipo_ID in (1,2,5,6)',-1,-1,'ID asc');
                $sub_total=0;
                foreach($dtCotizacion_Detalle as $item){
                    //Actualizamos sus hijos

                    $precio_venta_unitario=0;


                    $dtCotizacion_Detalle_Hijos=cotizacion_detalle::getGrid('cotizacion_detalle_ID='.$item['ID'],-1,-1,'ID desc');
                    if(count($dtCotizacion_Detalle_Hijos)>0){
                        foreach($dtCotizacion_Detalle_Hijos  as $value){
                            $oCotizacion_Detalle_Hijo=cotizacion_detalle::getByID($value['ID']);

                             if($oCotizacionold->moneda_ID==1){
                                $oCotizacion_Detalle_Hijo->precio_venta_unitario_dolares=number_format($oCotizacion_Detalle_Hijo->precio_venta_unitario_soles/$tipo_cambio,2,'.','');
                                $oCotizacion_Detalle_Hijo->precio_venta_subtotal_dolares=number_format($oCotizacion_Detalle_Hijo->precio_venta_unitario_dolares*$oCotizacion_Detalle_Hijo->cantidad,2,'.','');
                                $oCotizacion_Detalle_Hijo->precio_venta_dolares=number_format($oCotizacion_Detalle_Hijo->precio_venta_subtotal_dolares*($oCotizacionold->igv+1),2,'.','');
                                $oCotizacion_Detalle_Hijo->vigv_dolares=number_format($oCotizacion_Detalle_Hijo->precio_venta_subtotal_dolares*$oCotizacionold->igv,2,'.','');

                                if($value['tipo']==3){
                                //componente
                                    $precio_venta_unitario=$precio_venta_unitario+number_format($oCotizacion_Detalle_Hijo->precio_venta_subtotal_dolares,2,'.','');
                                }else {
                                    //adicional
                                    $precio_venta_unitario=$precio_venta_unitario+number_format($oCotizacion_Detalle_Hijo->precio_venta_subtotal_dolares/$item['cantidad'],2,'.','');
                                }
                            }else {
                                $oCotizacion_Detalle_Hijo->precio_venta_unitario_soles=number_format($oCotizacion_Detalle_Hijo->precio_venta_unitario_dolares*$tipo_cambio,2,'.','');
                                $oCotizacion_Detalle_Hijo->precio_venta_subtotal_soles=number_format($oCotizacion_Detalle_Hijo->precio_venta_unitario_soles*$oCotizacion_Detalle_Hijo->cantidad,2,'.','');
                                $oCotizacion_Detalle_Hijo->precio_venta_soles=number_format($oCotizacion_Detalle_Hijo->precio_venta_subtotal_soles*($oCotizacionold->igv+1),2,'.','');
                                $oCotizacion_Detalle_Hijo->vigv_soles=number_format($oCotizacion_Detalle_Hijo->precio_venta_subtotal_soles*$oCotizacionold->igv,2,'.','');

                                if($value['tipo']==3){
                                //componente
                                    $precio_venta_unitario=$precio_venta_unitario+number_format($oCotizacion_Detalle_Hijo->precio_venta_subtotal_soles,2,'.','');
                                }else {
                                    //adicional
                                    $precio_venta_unitario=$precio_venta_unitario+number_format($oCotizacion_Detalle_Hijo->precio_venta_subtotal_soles/$item['cantidad'],2,'.','');
                                }
                            }

                            $oCotizacion_Detalle_Hijo->usuario_mod_id=$_SESSION['usuario_ID'];
                            $oCotizacion_Detalle_Hijo->actualizar();

                        }
                    }

                    $oCotizacion_Detalle=cotizacion_detalle::getByID($item['ID']);

                    if($oCotizacionold->moneda_ID==1){
                        if($precio_venta_unitario==0){
                            $precio_venta_unitario=$oCotizacion_Detalle->precio_venta_unitario_soles/$tipo_cambio;
                        }
                        $oCotizacion_Detalle->precio_venta_unitario_dolares=number_format($precio_venta_unitario,2,'.','');
                        $oCotizacion_Detalle->precio_venta_subtotal_dolares=number_format($oCotizacion_Detalle->precio_venta_unitario_dolares*$item['cantidad'],2,'.','');
                        $oCotizacion_Detalle->precio_venta_dolares=number_format($oCotizacion_Detalle->precio_venta_subtotal_dolares*(1+$oCotizacionold->igv),2,'.','');
                        $oCotizacion_Detalle->vigv_dolares=number_format($oCotizacion_Detalle->precio_venta_subtotal_dolares*$oCotizacionold->igv,2,'.','');
                        $sub_total=$sub_total+$oCotizacion_Detalle->precio_venta_subtotal_dolares;
                    }else {
                        if($precio_venta_unitario==0){
                            $precio_venta_unitario=$oCotizacion_Detalle->precio_venta_unitario_dolares*$tipo_cambio;
                        }
                        $oCotizacion_Detalle->precio_venta_unitario_soles=number_format($precio_venta_unitario,2,'.','');
                        $oCotizacion_Detalle->precio_venta_subtotal_soles=number_format($oCotizacion_Detalle->precio_venta_unitario_soles*$item['cantidad'],2,'.','');
                        $oCotizacion_Detalle->precio_venta_soles=number_format( $oCotizacion_Detalle->precio_venta_subtotal_soles*(1+$oCotizacionold->igv),2,'.','');
                        $oCotizacion_Detalle->vigv_soles=number_format($oCotizacion_Detalle->precio_venta_subtotal_soles*$oCotizacionold->igv,2,'.','');
                        $sub_total=$sub_total+$oCotizacion_Detalle->precio_venta_subtotal_soles;
                    }
                    $oCotizacion_Detalle->usuario_mod_id=$_SESSION['usuario_ID'];
                    $oCotizacion_Detalle->actualizar();
                }
                //Actualizamos en tipo de cambio en la cotizacion
                if($oCotizacionold->moneda_ID==1){
                    //Actualizamos si la compra fue realizada en soles
                    $oCotizacionold->precio_venta_neto_dolares=number_format($sub_total,2,'.','');
                    $oCotizacionold->vigv_dolares=number_format($oCotizacionold->precio_venta_neto_dolares*$oCotizacionold->igv,2,'.','');

                    $oCotizacionold->precio_venta_total_dolares=number_format($oCotizacionold->precio_venta_neto_dolares*(1+$oCotizacionold->igv),2,'.','');

                }else {
                    $oCotizacionold->precio_venta_neto_soles=number_format($sub_total,2,'.','');
                    $oCotizacionold->vigv_soles=number_format($oCotizacionold->precio_venta_neto_soles*$oCotizacionold->igv,2,'.','');

                    $oCotizacionold->precio_venta_total_soles=number_format($oCotizacionold->precio_venta_neto_soles*(1+$oCotizacionold->igv),2,'.','');
                }
                $oCotizacionold->usuario_mod_id=$_SESSION['usuario_ID'];
                $oCotizacionold->actualizar();
            }

            return $oCotizacionold;
        }catch(Exception $ex){
            return $mensaje->$ex->getMessage();
        }

    }
    function get_Cotizacion_Mantenimiento_Clonar($id){
        require ROOT_PATH.'models/cotizacion.php';
        require ROOT_PATH.'models/cotizacion_detalle.php';
        require ROOT_PATH.'models/moneda.php';
        require ROOT_PATH.'models/estado.php';
        require ROOT_PATH.'models/cliente.php';
        require ROOT_PATH.'models/cliente_contacto.php';
        require ROOT_PATH.'models/operador.php';
        require ROOT_PATH.'models/datos_generales.php';
        require ROOT_PATH.'models/forma_pago.php';
        require ROOT_PATH.'models/credito.php';
        require ROOT_PATH.'models/numero_cuenta.php';
        require ROOT_PATH.'models/cotizacion_numero_cuenta.php';
        require ROOT_PATH.'controls/funcionController.php';
        require ROOT_PATH.'models/persona.php';
        global  $returnView_float;
        $returnView_float=true;
	//Ingresamos los valores
        $oCotizacionModelo=cotizacion::getByID($id);
        $oCotizacion=new cotizacion();
        $oCotizacion->empresa_ID=$_SESSION['empresa_ID'];
        $oCotizacion->cliente_ID=$oCotizacionModelo->cliente_ID;
        $oCotizacion->cliente_contacto_ID=$oCotizacionModelo->cliente_contacto_ID;
        $oCotizacion->operador_ID=$oCotizacionModelo->operador_ID;
        $oCotizacion->periodo=date("Y");
        $oCotizacion->moneda_ID=$oCotizacionModelo->moneda_ID;
        $oCotizacion->fecha=$oCotizacionModelo->fecha;
        $oCotizacion->forma_pago_ID=$oCotizacionModelo->forma_pago_ID;
        $oCotizacion->tiempo_credito=$oCotizacionModelo->tiempo_credito;

        $oCotizacion->tardanza=$oCotizacionModelo->tardanza;
        $oCotizacion->plazo_entrega=$oCotizacionModelo->plazo_entrega;
        $oCotizacion->estado_ID=1;
        $oCotizacion->tipo_cambio=$oCotizacionModelo->tipo_cambio;
        $oCotizacion->lugar_entrega=$oCotizacionModelo->lugar_entrega;
        $oCotizacion->validez_oferta=$oCotizacionModelo->validez_oferta;
        $oCotizacion->garantia=$oCotizacionModelo->garantia;
        $oCotizacion->area_texto=$oCotizacionModelo->area_texto;
        $oCotizacion->observacion=$oCotizacionModelo->observacion;

        $oCotizacion->igv=$oCotizacionModelo->igv;
        $oCotizacion->vigv_soles=$oCotizacionModelo->vigv_soles;
        $oCotizacion->vigv_dolares=$oCotizacionModelo->vigv_dolares;
        $oCotizacion->precio_venta_neto_soles=$oCotizacionModelo->precio_venta_neto_soles;
        $oCotizacion->precio_venta_total_soles=$oCotizacionModelo->precio_venta_total_soles;
        $oCotizacion->precio_venta_neto_dolares=$oCotizacionModelo->precio_venta_neto_dolares;
        $oCotizacion->precio_venta_total_dolares=$oCotizacionModelo->precio_venta_total_dolares;
        $oCotizacion->numero=cotizacion::getNumero();

        $oCotizacion->numero_concatenado= sprintf("%'.07d",$oCotizacion->numero).'-'.$oCotizacion->periodo;
        $oCotizacion->usuario_id=$_SESSION['usuario_ID'];
        $oCotizacion->insertar();
        $oCotizacion->numero_pagina=$oCotizacionModelo->numero_pagina;
        $oCotizacion->actualizar_pagina();
        //Ingresamos los numeros de cuenta
        //=================================
        $dtCotizacion_Numero_Cuenta=cotizacion_numero_cuenta::getGrid('cotizacion_ID='.$oCotizacionModelo->ID);
        foreach($dtCotizacion_Numero_Cuenta as $item){
            $oCotizacion_Numero_Cuenta=new cotizacion_numero_cuenta();
            $oCotizacion_Numero_Cuenta->cotizacion_ID=$oCotizacion->ID;
            $oCotizacion_Numero_Cuenta->numero_cuenta_ID=$item['numero_cuenta_ID'];
            $oCotizacion_Numero_Cuenta->usuario_id=$_SESSION['usuario_ID'];
            $oCotizacion_Numero_Cuenta->insertar();
        }
       //ingresamos los detalles
       //=================================================
        $dtCotizacionDetalle=cotizacion_detalle::getGrid('cotizacion_ID='.$id. ' and cotizacion_detalle_ID=0');
        if(count($dtCotizacionDetalle)>0){
            foreach($dtCotizacionDetalle as $vpadre){
                $oCotizacion_Detalle=new cotizacion_detalle();
                $oCotizacion_Detalle->producto_ID=$vpadre['producto_ID'];

                $oCotizacion_Detalle->cotizacion_ID=$oCotizacion->ID;
                $oCotizacion_Detalle->descripcion=$vpadre['descripcion'];
                $oCotizacion_Detalle->cantidad=$vpadre['cantidad'];
                $oCotizacion_Detalle->precio_venta_unitario_soles=$vpadre['precio_venta_unitario_soles'];
                $oCotizacion_Detalle->precio_venta_subtotal_soles=$vpadre['precio_venta_subtotal_soles'];
                $oCotizacion_Detalle->precio_venta_subtotal_dolares=$vpadre['precio_venta_subtotal_dolares'];
                $oCotizacion_Detalle->precio_venta_unitario_dolares=$vpadre['precio_venta_unitario_dolares'];
                $oCotizacion_Detalle->igv=$vpadre['igv'];
                $oCotizacion_Detalle->vigv_soles=$vpadre['vigv_soles'];
                $oCotizacion_Detalle->vigv_dolares=$vpadre['vigv_dolares'];
                $oCotizacion_Detalle->precio_venta_soles=$vpadre['precio_venta_soles'];
                $oCotizacion_Detalle->precio_venta_dolares=$vpadre['precio_venta_dolares'];
                $oCotizacion_Detalle->cotizacion_detalle_ID=$vpadre['cotizacion_detalle_ID'];
                $oCotizacion_Detalle->estado_id=$vpadre['estado_id'];
                $oCotizacion_Detalle->ver_precio=$vpadre['ver_precio'];
                $oCotizacion_Detalle->separacion=0;
                $oCotizacion_Detalle->tiempo_separacion=0;
                $oCotizacion_Detalle->cantidad_separada=0;
                $oCotizacion_Detalle->tipo_ID=$vpadre['tipo_ID'];
                $oCotizacion_Detalle->tipo=$vpadre['tipo_ID'];
                $array=retornar_valores($oCotizacion_Detalle->tipo_ID);
                $oCotizacion_Detalle->componente=$array['componente'];
                $oCotizacion_Detalle->adicional=$array['adicional'];

                $oCotizacion_Detalle->usuario_id=$_SESSION['usuario_ID'];
                $oCotizacion_Detalle->insertar();

                $oCotizacion_Detalle->pagina_cotizacion=$vpadre['pagina_cotizacion'];
                $oCotizacion_Detalle->orden_cotizacion=$vpadre['orden_cotizacion'];
                $oCotizacion_Detalle->actualizarDimension();
                 //Registramos los componentes internos
                $dtCotizacion_Detalle_Hijo=cotizacion_detalle::getGrid('cotizacion_ID='.$oCotizacionModelo->ID.' and cotizacion_detalle_ID='.$vpadre['ID']);
                if(count($dtCotizacion_Detalle_Hijo)>0){
                    foreach ($dtCotizacion_Detalle_Hijo as $vHijo){
                        $oCotizacion_Detalle_Hijo=new cotizacion_detalle();
                        $oCotizacion_Detalle_Hijo->producto_ID=$vHijo['producto_ID'];

                        $oCotizacion_Detalle_Hijo->cotizacion_ID=$oCotizacion->ID;
                        $oCotizacion_Detalle_Hijo->descripcion=$vHijo['descripcion'];
                        $oCotizacion_Detalle_Hijo->cantidad=$vHijo['cantidad'];
                        $oCotizacion_Detalle_Hijo->precio_venta_unitario_soles=$vHijo['precio_venta_unitario_soles'];
                        $oCotizacion_Detalle_Hijo->precio_venta_subtotal_soles=$vHijo['precio_venta_subtotal_soles'];
                        $oCotizacion_Detalle_Hijo->precio_venta_subtotal_dolares=$vHijo['precio_venta_subtotal_dolares'];
                        $oCotizacion_Detalle_Hijo->precio_venta_unitario_dolares=$vHijo['precio_venta_unitario_dolares'];
                        $oCotizacion_Detalle_Hijo->igv=$vHijo['igv'];
                        $oCotizacion_Detalle_Hijo->vigv_soles=$vHijo['vigv_soles'];
                        $oCotizacion_Detalle_Hijo->vigv_dolares=$vHijo['vigv_dolares'];
                        $oCotizacion_Detalle_Hijo->precio_venta_soles=$vHijo['precio_venta_soles'];
                        $oCotizacion_Detalle_Hijo->precio_venta_dolares=$vHijo['precio_venta_dolares'];
                        $oCotizacion_Detalle_Hijo->cotizacion_detalle_ID=$oCotizacion_Detalle->ID;
                        $oCotizacion_Detalle_Hijo->estado_id=$vHijo['estado_id'];
                        $oCotizacion_Detalle_Hijo->ver_precio=$vHijo['ver_precio'];
                        $oCotizacion_Detalle_Hijo->separacion=0;
                        $oCotizacion_Detalle_Hijo->tiempo_separacion=0;
                        $oCotizacion_Detalle_Hijo->cantidad_separada=0;
                        $oCotizacion_Detalle_Hijo->tipo_ID=$vHijo['tipo'];
                        $oCotizacion_Detalle_Hijo->usuario_id=$_SESSION['usuario_ID'];
                        $oCotizacion_Detalle_Hijo->insertar();
                        $oCotizacion_Detalle_Hijo->orden_cotizacion=$vHijo['orden_cotizacion'];
                        $oCotizacion_Detalle_Hijo->pagina_cotizacion=$vHijo['pagina_cotizacion'];
                        $oCotizacion_Detalle_Hijo->actualizarDimension();
                    }
                }

            }
        }

        $oCliente=cliente::getByID($oCotizacion->cliente_ID);
        $operador_ID=0;
        if($oCotizacion->operador_ID==null){
            $oOperador= new operador();
            $oOperador->nombres="Vendedor";
            $oOperador->apellido_paterno="no asignado";
            $oOperador->direccion="--";
            $oOperador->telefono="--";
            $oOperador->celular="--";
            $oOperador->email="--";

        }else {
            $oOperador=operador::getByID($oCotizacion->operador_ID);
            $oPersona=persona::getByID($oOperador->persona_ID);
            $oOperador->apellido_paterno=$oPersona->apellido_paterno;
            $oOperador->nombres=$oPersona->nombres;
        }
        $dtCliente_Contacto=cliente_contacto::getGrid('clic.cliente_ID='.$oCotizacion->cliente_ID);
        $dtCliente=cliente::getGrid("",-1,-1,"clt.razon_social asc");
        $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
        $dtForma_Pago=forma_pago::getGrid();
        $dtCredito=credito::getGrid('id<>0');
        $oNumero_Cuenta=numero_cuenta::getByID(1);
        $dtEstado=estado::getGrid('est.tabla="cotizacion"');

        $GLOBALS['dtNumero_Cuenta']=mostrarNumeroCuentas(2,$oCotizacion->moneda_ID,$oCotizacion,null);
        $GLOBALS['dtCliente_Contacto']=$dtCliente_Contacto;
        $GLOBALS['oCliente']=$oCliente;
        $GLOBALS['dtCliente']=$dtCliente;
        $GLOBALS['oCotizacion']=$oCotizacion;
        $GLOBALS['dtCredito']=$dtCredito;
        $GLOBALS['oOperador']=$oOperador;
        $GLOBALS['oDatos_Generales']=$oDatos_Generales;
        $GLOBALS['dtForma_Pago']=$dtForma_Pago;
        $GLOBALS['dtEstado']=$dtEstado;
        $GLOBALS['oNumero_Cuenta']=$oNumero_Cuenta;
        $GLOBALS['dtMoneda']=moneda::getGrid();
        $GLOBALS['mensaje']='';
    }
    function post_Cotizacion_Mantenimiento_Clonar($id){
        require ROOT_PATH.'models/cotizacion.php';
        require ROOT_PATH.'models/cotizacion_detalle.php';
        require ROOT_PATH.'models/moneda.php';
        require ROOT_PATH.'models/estado.php';
        require ROOT_PATH.'models/cliente.php';
        require ROOT_PATH.'models/cliente_contacto.php';
        require ROOT_PATH.'models/operador.php';
        require ROOT_PATH.'models/datos_generales.php';
        require ROOT_PATH.'models/forma_pago.php';
        require ROOT_PATH.'models/credito.php';
        require ROOT_PATH.'models/numero_cuenta.php';
        require ROOT_PATH.'models/cotizacion_numero_cuenta.php';
        require ROOT_PATH.'controls/funcionController.php';
        global  $returnView_float;
        $returnView_float=true;

            $cotizacion_ID=$_POST['txtCotizacion_ID'];
            $cliente_ID=$_POST['selCliente'];
            $cliente_contacto_ID=$_POST['selRepresentante'];
            if($cliente_contacto_ID=="--"){
                $cliente_contacto_ID=0;
            }
            $operador_ID=$_POST['txtOperador_ID'];
            if($operador_ID=="-1"){
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
            $tardanza=$_POST['txtTiempo_Avance'];
            $plazo_entrega=$_POST['txtPlazo_Entrega'];
            $estado_ID=1;
            $tipo_cambio=$_POST['txtTipo_Cambio'];
            $lugar_entrega=$_POST['txtLugar_Entrega'];
            $validez_oferta=$_POST['txtValidez_Oferta'];
            $garantia=$_POST['txtGarantia'];
            $observacion= trim($_POST['txtObservacion']);


            try{
                    $oCotizacion=cotizacion::getByID($cotizacion_ID);
                    $oCotizacion->empresa_ID=$_SESSION['empresa_ID'];
                    $oCotizacion->cliente_ID=$cliente_ID;
                    $oCotizacion->cliente_contacto_ID=$cliente_contacto_ID;
                    $oCotizacion->operador_ID=$operador_ID;
                    $oCotizacion->periodo=$periodo;
                    $oCotizacion->moneda_ID=$moneda_ID;
                    $oCotizacion->fecha=$fecha;
                    $oCotizacion->forma_pago_ID=$forma_pago_ID;
                    $oCotizacion->tiempo_credito=$tiempo_credito;
                    //$oCotizacion->numero_cuenta=$numero_cuenta;
                    //$oCotizacion->cuenta_interbancaria=$cuenta_interbancaria;
                    //$oCotizacion->banco=$banco;
                    $oCotizacion->tardanza=$tardanza;
                    $oCotizacion->plazo_entrega=$plazo_entrega;
                    $oCotizacion->estado_ID=$estado_ID;
                    $oCotizacion->tipo_cambio=$tipo_cambio;
                    $oCotizacion->lugar_entrega=$lugar_entrega;
                    $oCotizacion->validez_oferta=$validez_oferta;
                    $oCotizacion->garantia=$garantia;
                    $oCotizacion->observacion=$observacion;
                    $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
                    $oCotizacion->igv=$oDatos_Generales->vigv;
                    $oCotizacion->usuario_mod_id=$_SESSION['usuario_ID'];
                    $oCotizacion->actualizar();
                    $mensaje=$oCotizacion->getMessage;
                    $resultado=1;

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
                        }
                    }

            }catch(Exception $ex){
                    $resultado=-1;
                    $mensaje=$ex->getMessage();
            }
            $oCliente=cliente::getByID($cliente_ID);
            if($operador_ID=='-1'){
                $oOperador=new operador();
                $oOperador->nombre="Vendedor no";
                $oOperador->apellido_paterno="asignado";
                $oOperador->direccion="--";
                $oOperador->telefono="--";
                $oOperador->celular="-";
                $oOperador->mail="--";

            }else {
                $oOperador=operador::getByID($operador_ID);
            }
            $dtEstado=estado::getGrid('est.tabla="cotizacion"');
            $dtCliente_Contacto=cliente_contacto::getGrid('clic.cliente_ID='.$cliente_ID);
            $dtCliente=cliente::getGrid("",-1,-1,"clt.razon_social asc");
            $dtNumero_Cuenta=array();
        for($a=0;$a<2;$a++){
                array_push($dtNumero_Cuenta,"");
            }
            $GLOBALS['dtNumero_Cuenta']=mostrarNumeroCuentas(2,$oCotizacion->moneda_ID,$oCotizacion,null);
            $GLOBALS['oCotizacion']=$oCotizacion;
            $GLOBALS['oCliente']=$oCliente;
            $GLOBALS['dtCliente']=$dtCliente;
            $GLOBALS['dtCliente_Contacto']=$dtCliente_Contacto;
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
    function post_ajaxCotizacion_Mantenimiento_Eliminar($id){
        require ROOT_PATH.'models/cotizacion.php';
        require ROOT_PATH.'models/cotizacion_detalle.php';
        try{
                $oCotizacion=cotizacion::getByID($id);
                $oCotizacion->usuario_mod_id=$_SESSION['usuario_ID'];
                /*Quitamos las separaciones en el inventario*/
                $dtCotizacion_Detalle=cotizacion_detalle::getGrid('cotizacion_ID='.$id);
                if(count($dtCotizacion_Detalle)>0){
                    foreach($dtCotizacion_Detalle as $item){
                        $oCotizacion_Detalle=cotizacion_detalle::getByID($item['ID']);
                        eliminarSeparacionesProductoCotizacion($oCotizacion_Detalle);
                    }
                }
                if($oCotizacion==null){
                        throw new Exception('Parece que el registro ya fue eliminado.');
                }

                if ($oCotizacion->eliminar()==-1){
                        throw new Exception($oCotizacion_Detalle->getMessage);
                }

                $resultado=1;
                $mensaje=$oCotizacion->getMessage;
                $funcion='';
            }catch(Exception $ex){
                $resultado=-1;
                $mensaje=$ex->getMessage();
                $funcion='';
            }

            $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje,'funcion'=>$funcion);

            echo json_encode($retornar);
	}
//FIN DE REGISTRO DE COTIZACIONES
//=======================================================================================
    function get_Orden_Venta_Mantenimiento(){
        require ROOT_PATH.'models/estado.php';
        require ROOT_PATH.'models/moneda.php';
        require ROOT_PATH.'models/salida.php';
        require ROOT_PATH.'models/cliente.php';
        require ROOT_PATH.'models/datos_generales.php';
        
        global $returnView;
        $returnView=true;
        //==============Funciones de pruebas
        $oDatos_generales=datos_generales::getByID1($_SESSION['empresa_ID']);
        
        
        $dtEstado=estado::getGrid('tabla="salida"');
        $dtMoneda=moneda::getGrid();
        $dtCliente=cliente::getGrid("",-1,-1,"clt.razon_social asc");
        
        $GLOBALS['dtEstado']=$dtEstado;
        $GLOBALS['dtMoneda']=$dtMoneda;
        $GLOBALS['dtPerido']=salida::getPeriodos();
        $GLOBALS['dtCliente']=$dtCliente;
        
    }
/*function post_ajaxOrden_Venta_Mantenimiento() {
    require ROOT_PATH . 'models/salida.php';
    require ROOT_PATH . 'models/moneda.php';
    require ROOT_PATH . 'models/estado.php';
    require ROOT_PATH . 'models/factura_venta.php';
    require ROOT_PATH . 'models/guia_venta.php';
    require ROOT_PATH . 'controls/funcionController.php';
    $paginaActual = $_POST['num_page'] == 0 ? 1 : $_POST['num_page'];
    $cantidadMostrar = $_POST['txtMostrar'] == '' ? 30 : $_POST['txtMostrar'];
    $opcion_tipo=$_POST['rbOpcion'];
    $txtOrden = $_POST['txtOrden'];
    $orden_tipo = 'DESC';
    $orden_class = 'imgOrden-desc';
    $cliente_ID=$_POST['selCliente'];
    $estado_ID=$_POST['selEstado'];
    $periodo=$_POST['selPeriodo'];
    $fecha_inicio=$_POST['txtFechaInicio'];
    $fecha_fin=$_POST['txtFechaFin'];
    $numero=Ltrim($_POST['txtNumero'],'0');
    $periodo=ltrim($_POST['txtPeriodo'],'0');
    $moneda=$_POST['selMoneda'];
    $numero_factura=trim($_POST['txtNumero_Factura']);
    if (isset($_POST['chkOrdenASC'])) {
        $orden_class = 'imgOrden-asc';
        $orden_tipo = 'ASC';
    }
    $todos=0;
    if(isset($_POST['ckTodos'])){
        $todos=$_POST['ckTodos'];
    }
    switch ($txtOrden) {
        case 1:
            $orden = 'ov.numero_concatenado ' . $orden_tipo;
            break;
        case 2:
            $orden = 'ov.fecha ' . $orden_tipo;
            break;
        case 3:
            $orden = 'cl.razon_social ' . $orden_tipo;
            break;
        case 4:
            $orden = 'ov.moneda_ID ' . $orden_tipo;
            break;
        case 5:
            $orden = 'ov.precio_venta_total_soles ' . $orden_tipo;
            break;
        case 6:
            $orden = 'ov.precio_venta_total_dolares ' . $orden_tipo;
            break;
        case 7:
            $orden = 'es.nombre ' . $orden_tipo;
            break;

        default:
            $orden = 'ov.ID ' . $orden_tipo;
            break;
    }
    $filtro="";
    if($opcion_tipo=="buscar"){
        if(trim($periodo)!=""){
            $filtro="ov.periodo=". $periodo;
        }
        if(trim($numero)!=""){
            if($filtro!=""){
                $filtro.=" and ";
            }
            $filtro="ov.numero=".$numero;
        }
        if($numero_factura!=""){
            $dtFactura_Venta=factura_venta::getGrid("numero=".$numero_factura);
            $salida_ID="";
            $i=0;
            foreach($dtFactura_Venta as $item){
                if($i==0){
                    $salida_ID=$item['salida_ID'];
                }else {
                    $salida_ID.=",".$item['salida_ID'];
                }
                $i++;
            }
            if($salida_ID!=""){
                if($filtro!=""){
                    $filtro.=" and ";
                }

                $filtro="ov.ID in (".$salida_ID.")";
            }else {
                if($filtro!=""){
                    $filtro.=" and ";
                }

                $filtro="ov.ID =-1 ";
            }

        }
    }else {
        if($cliente_ID!=0){
        $filtro.="ov.cliente_ID=".$cliente_ID ;
        }
        if($estado_ID!=0){
            if($filtro!=""){
                $filtro.=" and ";
            }
            $filtro.="ov.estado_ID=".$estado_ID;
        }
        if($periodo==0){
            if($fecha_inicio!="" &&$fecha_fin!="" ){
                if($filtro!=""){
                    $filtro.=" and ";
                }
                //$filtro.=" ov.fecha between '".FormatTextToDate($fecha_inicio,'Y-m-d')."' and '".FormatTextToDate($fecha_fin,'Y-m-d')."'" ;
                $filtro.=" ov.fecha between '".$fecha_inicio."' and '".$fecha_fin."'" ;
            }
        }else{
            
        }
        
        if($moneda>0){
            if($filtro!=""){
                $filtro.=" and ";
            }
            $filtro.="ov.moneda_ID=".$moneda;
        }
    }

    //$filtro = 'upper(concat(cl.razon_social," ",cl.ruc)) like "%' . str_replace(' ', '%', strtoupper(FormatTextSave($buscar))) . '%"';


    $resultado = '<table id="websendeos" class="grid table table-theme table-middle table-hover table-striped table-bordered table-condensed dt-responsive nowrap"><thead><tr>';
    $resultado.= '<th></th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(1);">Número' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(2);">Fecha' . (($txtOrden == 2 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(3);">Cliente' . (($txtOrden == 3 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(4);">Moneda' . (($txtOrden == 4 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(5);">Monto S/.' . (($txtOrden == 5 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(6);">Monto $' . (($txtOrden == 6 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(7);">Estado' . (($txtOrden == 7 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(7);">PDF' . (($txtOrden == 8 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(7);">XML' . (($txtOrden == 9 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(7);">CDR' . (($txtOrden == 10 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(8);">Estado SUNAT' . (($txtOrden == 11 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th></th>';
    $resultado.='</tr></thead>';
    $resultado.='<tbody>';
    $colspanFooter = 13;
    try {
        $cantidadMaxima = salida::getCount($filtro);
        $dtsalida = salida::getGrid($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
        $rows = count($dtsalida);
        $fila = 0;
        $enviado_por_la_SUNAT = '';
        $aceptada_por_la_SUNAT = '';
        $codigo_SUNAT = '';
        $descripcion_SUNAT = '';
        $otros = '';

        foreach ($dtsalida as $item) {
            $fila = $fila + 1;
            $oMoneda=moneda::getByID($item['moneda_ID']);
            $resultado.='<tr class="tr-item">';
            $impresion='';
            $osalida=salida::getByID($item['ID']);
            if($osalida->impresion==1){
                $impresion='<img width="24px" title="En impresión" src="/include/img/boton/print.png" />';
            }
            $resultado.='<td>'.$impresion.'</td>';
            $resultado.='<td class="tdCenter">' . $item['numero_concatenado'] . '</td>';
            $resultado.='<td class="tdCenter">' . FormatTextViewHtml($item['fecha']) . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextViewHtml($item['razon_social']) . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextViewHtml($oMoneda->descripcion) . '</td>';
            $resultado.='<td class="tdRight">' . $item['precio_venta_total_soles'] . '</td>';
            $resultado.='<td class="tdRight">' . $item['precio_venta_total_dolares'] . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextViewHtml($item['estado']) . '</td>';
            $resultado.='<td class="text-center"><a onclick="fncDOWNLOAD_XML('.$item['factura_venta_ID'].','. "'PDF'" .');"><i class="fa fa-file-pdf-o" style="font-size:30px;color:#e64328"></i></a></td>';
            $resultado.='<td class="text-center"><a onclick="fncDOWNLOAD_XML('.$item['ID'].','. "'XML'" .');"><i class="fa fa-file-code-o" style="font-size:30px;color:#007BE8"></i></a></td>';
            $resultado.='<td class="text-center"><a onclick="fncDOWNLOAD_XML('.$item['ID'].','. "'CDR'" .');"><i class="fa fa-file-text-o" style="font-size:30px;color:#8CC152"></i></a></td>';
            $resultado.='<td class="text-center">';

            if (trim($item['sunat_codigo_estado'])=='-1') {
                $enviado_por_la_SUNAT = '<span class="glyphicon glyphicon-remove"></span>';
                $aceptada_por_la_SUNAT = '<span class="glyphicon glyphicon-remove"></span>';
                $codigo_SUNAT = '';
                $descripcion_SUNAT = '';
                $otros = '';

                $resultado.='<button type="button" class="btn btn-danger btn-sm btn-block" onclick="fnModalPopover();" onmouseover="fnModalPopover()" rel="popover" data-popover-content="#myPopover'.$fila.'"><span class="glyphicon glyphicon-ban-circle"></span> Borrador</button>';
            }elseif (trim($item['sunat_codigo_estado'])=='0') {
                $enviado_por_la_SUNAT = '<i class="fa fa-check"></i>';
                $aceptada_por_la_SUNAT = '<i class="fa fa-check"></i>';
                $codigo_SUNAT = FormatTextViewHtml($item['codigo_estado']);
                $descripcion_SUNAT = FormatTextViewHtml($item['descripcion_estado']);
                $otros = '';
                $resultado.='<button type="button" class="btn btn-success btn-sm btn-block"';
                $resultado.=' onclick="fnModalPopover();" onmouseover="fnModalPopover()" rel="popover" data-popover-content="#myPopover'.$fila.'" ';
                $resultado.='><span class="glyphicon glyphicon-ok"></span> Ok</button>';
            }else {
                $enviado_por_la_SUNAT = '<i class="fa fa-check"></i>';
                $aceptada_por_la_SUNAT = '<span class="glyphicon glyphicon-remove"></span><i class="fa fa-refresh fa-spin"></i>';
                $codigo_SUNAT = FormatTextViewHtml($item['codigo_estado']);
                $descripcion_SUNAT = FormatTextViewHtml($item['descripcion_estado']);
                $otros = '';
                $resultado.='<button type="button" class="btn btn-warning btn-sm btn-block" ';
                $resultado.=' onclick="fnModalPopover();" onmouseover="fnModalPopover()" rel="popover" data-popover-content="#myPopover'.$fila.'"';
                $resultado.='><span class="glyphicon glyphicon-remove"></span><i class="fa fa-refresh fa-spin"></i> Ok</button>';


            }

            $resultado.='
            <div id="myPopover'.$fila.'" class="hide">
            <table class="table">
              <tbody>
              <tr>
                <td class="text-right">Enviada a la SUNAT</td>
                <td>'.$enviado_por_la_SUNAT.'</td>
              </tr>
              <tr>
                <td class="text-right">Aceptada por la SUNAT</td>
                <td>'.$aceptada_por_la_SUNAT.'</td>
              </tr>
              <tr>
                <td class="text-right">Código</td>
                <td>'.$codigo_SUNAT.'</td>
              </tr>
              <tr>
                <td class="text-right">Descripción</td>
                <td>'.$descripcion_SUNAT.'</td>
              </tr>
              <tr>
                <td class="text-right">Otros</td>
                <td>'.$otros.'</td>
              </tr>
              </tbody>
            </table>
            </div>';

            $resultado.='</td>';

            $botones=array();
            if($item['estado_ID']==40||$item['estado_ID']==42){

                $editar='<a onclick="fncVer(' . $item['ID'] . ');"><img title="Ver" src="/include/img/boton/find_14x14.png" />&nbsp;Ver</a>';
                array_push($botones,$editar);

            }else{
                $eliminar='<a onclick="fncEliminar(' . $item['ID'] . ');"><img title="Eliminar" src="/include/img/boton/delete_14x14.png" />&nbsp;Eliminar</a>';
                $editar='<a onclick="fncEditar(' . $item['ID'] . ');"><img title="Editar" src="/include/img/boton/edit_14x14.png" />&nbsp;Editar</a>';

                array_push($botones,$editar);
                array_push($botones,$eliminar);
            }

            $editar='<a onclick="fncSUNAT(' . $item['ID'] . ');"><img title="Ver" src="/include/img/boton/find_14x14.png" />&nbsp;Envia SUNAT</a>';
            array_push($botones,$editar);
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
}*/
function post_ajaxOrden_Venta_Mantenimiento() {
    require ROOT_PATH.'models/salida.php';
    $cliente=$_POST['selCliente'];
    $periodo=$_POST['selPeriodo'];
    $fecha_inicio=FormatTextToDate($_POST['txtFechaInicio'],'Y-m-d');
    $fecha_fin=FormatTextToDate($_POST['txtFechaFin'],'Y-m-d');
    $estado_ID=$_POST['selEstado'];
    $moneda_ID=$_POST['selMoneda'];
    $periodo_texto=(trim($_POST['txtPeriodo'])=="")?0:trim($_POST['txtPeriodo']);
    $numero=(trim($_POST['txtNumero'])=="")?0:trim($_POST['txtNumero']);
    $numero_factura=(trim($_POST['txtNumero_Factura'])=="")?0:trim($_POST['txtNumero_Factura']);
    $opcion=$_POST['rbOpcion'];
    try{
       $dtSalida=salida::getTabla($opcion,$cliente,$periodo,$fecha_inicio,$fecha_fin,$estado_ID,$moneda_ID,$periodo_texto,$numero,$numero_factura,27);
        echo(json_encode($dtSalida, JSON_NUMERIC_CHECK)); 
    }catch(Exception $ex){
        log_error(__FILE__,"salida/post_ajaxOrden_Venta_Mantenimiento",$ex->getMessage());
    }
    
  
}


function post_ajaxOrden_Venta_Mantenimiento_Eliminar($id){
        require ROOT_PATH.'models/salida.php';
        require ROOT_PATH.'models/cotizacion.php';
        require ROOT_PATH.'models/salida_detalle.php';
        try{
                $osalida=salida::getByID($id);
                $osalida->usuario_mod_id=$_SESSION['usuario_ID'];
                if($osalida==null){
                        throw new Exception('Parece que el registro ya fue eliminado.');
                }
                /*Verificamos que no tenga detalle*/
                $dtsalida_Detalle=salida_detalle::getGrid('salida_ID='.$id,-1,-1);
                if(count($dtsalida_Detalle)>0){

                    throw new Exception('No se puede eliminar, tiene detalles.');

                }


                if ($osalida->eliminar()==-1){
                    throw new Exception($oCotizacion_Detalle->message);
                }
            //Liberamos si la orden viene de una cotización
                if($osalida->cotizacion_ID!=-1){
                    $oCotizacion=cotizacion::getByID($osalida->cotizacion_ID);
                    $oCotizacion->usuario_mod_id=$_SESSION['usuario_ID'];
                    $oCotizacion->estado_ID=2;
                    $oCotizacion->actualizar();
                }
                $resultado=1;
                $mensaje=$osalida->getMessage;
                $funcion='';
            }catch(Exception $ex){
                $resultado=-1;
                $mensaje=$ex->getMessage();
                $funcion='';
            }

            $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje,'funcion'=>$funcion);

            echo json_encode($retornar);
	}
    function get_Orden_Venta_Mantenimiento_Nuevo($id){
        require ROOT_PATH.'models/salida.php';
        require ROOT_PATH.'models/moneda.php';
        require ROOT_PATH.'models/estado.php';
        require ROOT_PATH.'models/cliente.php';
        require ROOT_PATH.'models/operador.php';
        require ROOT_PATH.'models/datos_generales.php';
        require ROOT_PATH.'models/forma_pago.php';
        require ROOT_PATH.'models/credito.php';
        require ROOT_PATH.'models/cotizacion.php';
        require ROOT_PATH.'models/numero_cuenta.php';
        require ROOT_PATH.'controls/funcionController.php';
        global  $returnView_float;
        $returnView_float=true;
        $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
        $mensaje="";

        $osalida=new salida();
        $osalida->ID=0;
        $osalida->garantia= "1 año";
        $osalida->validez_oferta=7;
        $osalida->moneda_ID=moneda;
        $osalida->ver_adicional=1;
        $osalida->adicional="Nueva Central Telefónica ".$oDatos_Generales->telefono;
        $osalida->tipo_cambio=$oDatos_Generales->tipo_cambio;
        $osalida->cotizacion_ID=-1;
        $osalida->ver_factura=0;
        $osalida->ver_guia=0;
        $osalida->impresion=0;
        $osalida->forma_pago_ID=0;
        $oCliente=new cliente();
        //$dtCliente=cliente::getGrid("",-1,-1,"clt.razon_social asc");
        $oOperador=new operador();
        $dtForma_Pago=forma_pago::getGrid();
        $dtCredito=credito::getGrid('id<>0');
        $oNumero_Cuenta=numero_cuenta::getByID(1);
        $dtEstado=estado::getGrid('est.tabla="cotizacion"');
        $oCotizacion=new cotizacion();
        $GLOBALS['oOrden_Venta']=$osalida;
        $GLOBALS['oCliente']=$oCliente;
        
        $GLOBALS['dtNumero_Cuenta']=mostrarNumeroCuentas(1,$osalida->moneda_ID,null,null);
        $GLOBALS['dtCredito']=$dtCredito;
        $GLOBALS['oOperador']=$oOperador;
        $GLOBALS['oDatos_Generales']=$oDatos_Generales;
        $GLOBALS['dtForma_Pago']=$dtForma_Pago;
        $GLOBALS['dtEstado']=$dtEstado;
        $GLOBALS['oNumero_Cuenta']=$oNumero_Cuenta;
        $GLOBALS['dtMoneda']=moneda::getGrid();
        $GLOBALS['oCotizacion']=$oCotizacion;

        $GLOBALS['mensaje']=$mensaje;
    }

    function post_Orden_Venta_Mantenimiento_Nuevo(){
        require ROOT_PATH.'models/salida.php';
        require ROOT_PATH.'models/salida_detalle.php';
        require ROOT_PATH.'models/moneda.php';
        require ROOT_PATH.'models/estado.php';
        require ROOT_PATH.'models/cliente.php';
        require ROOT_PATH.'models/cliente_contacto.php';
        require ROOT_PATH.'models/operador.php';
        require ROOT_PATH.'models/datos_generales.php';
        require ROOT_PATH.'models/forma_pago.php';
        require ROOT_PATH.'models/credito.php';
        require ROOT_PATH.'models/cotizacion.php';
        require ROOT_PATH.'models/numero_cuenta.php';
        require ROOT_PATH.'models/salida_numero_cuenta.php';
        require ROOT_PATH.'models/factura_venta.php';
        require ROOT_PATH.'controls/funcionController.php';
        global  $returnView_float;
        $returnView_float=true;
        $id=$_POST['txtID'];
        $cliente_ID=$_POST['selCliente'];
        $numero_orden_compra=$_POST['txtNumero_Orden_Compra'];
        $cliente_contacto_ID=0;
        if(isset($_POST['selRepresentante'])){
            $cliente_contacto_ID= $_POST['selRepresentante'];
        }

        $moneda_ID=$_POST['cboMoneda'];
        $tipo_cambio=$_POST['txtTipo_Cambio'];
        $plazo_entrega=$_POST['txtPlazo_Entrega'];
        $forma_pago_ID=$_POST['selForma_Pago'];
        $tiempo_credito=$_POST['selTiempo_Credito'];
        $fecha=$_POST['txtFecha'];
        $operador_ID=$_POST['txtOperador_ID'];
        $lugar_entrega=$_POST['txtLugar_Entrega'];
        $validez_oferta=$_POST['txtValidez_Oferta'];
        $garantia=  $_POST['txtGarantia'];
        $observacion=$_POST['txtObservacion'];
        $ver_adicional=0;
        if(isset($_POST['ckVer_Adicional'])){
            $ver_adicional=$_POST['ckVer_Adicional'];
        }
        $adicional=$_POST['txtAdicional'];
        try{
            $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
            if($id>0){
                $osalida=salida::getByID($id);
                actualizar_costos_salida_detalle($osalida,$tipo_cambio);
                $osalida->numero_orden_compra=$numero_orden_compra;
                $osalida->cliente_contacto_ID=$cliente_contacto_ID;
                $osalida->moneda_ID=$moneda_ID;
                $osalida->tipo_cambio=$tipo_cambio;
                $osalida->plazo_entrega=$plazo_entrega;
                $osalida->forma_pago_ID=$forma_pago_ID;
                $osalida->tiempo_credito=$tiempo_credito;
                $osalida->fecha=$fecha;
                $osalida->lugar_entrega=$lugar_entrega;
                $osalida->validez_oferta=$validez_oferta;
                $osalida->garantia=$garantia;
                $osalida->observacion=$observacion;
                $osalida->ver_adicional=$ver_adicional;
                $osalida->adicional=$adicional;
                $osalida->usuario_mod_id=$_SESSION['usuario_ID'];

                //$osalida->actualizar();
                $osalida->actualizar_new();

                if($osalida->estado_ID==28){
                    $Cliente_ID=$osalida->cliente_ID;
                    //$resultado=3;
                }else if($osalida->estado_ID==42){
                    //$resultado=2;
                    $mensaje="No se puede modificar la orden de venta, los comprobantes ya fueron remitidos.";
                }

                $resultado=1;
                $mensaje="Se guardó correctamente";
            }else if($id==0){
                $osalida=new salida();
                $osalida->cotizacion_ID="null";
                $osalida->cliente_ID=$cliente_ID;
                $osalida->cliente_contacto_ID=$cliente_contacto_ID;
                $osalida->operador_ID=$operador_ID;
                $osalida->periodo=date("Y");
                $osalida->numero=salida::getNumero();
                $numero_ceros=sprintf("%'.07d", $osalida->numero);
                $numero_concatenado=$numero_ceros.'-'.$osalida->periodo;
                $osalida->numero_concatenado=$numero_concatenado;
                $osalida->numero_orden_compra=$numero_orden_compra;
                $osalida->moneda_ID=$moneda_ID;
                $osalida->fecha=$fecha;
                $osalida->igv=$oDatos_Generales->vigv;
                $osalida->vigv_soles=0;
                $osalida->vigv_dolares=0;
                $osalida->precio_venta_neto_soles=0;
                $osalida->precio_venta_total_soles=0;
                $osalida->precio_venta_neto_dolares=0;
                $osalida->precio_venta_total_dolares=0;
                $osalida->forma_pago_ID=$forma_pago_ID;
                $osalida->tiempo_credito=$tiempo_credito;
                $osalida->descuento_soles=0;
                $osalida->descuento_dolares=0;
                $osalida->estado_ID=29;
                $osalida->tipo_cambio=$tipo_cambio;
                $osalida->plazo_entrega=$plazo_entrega;
                $osalida->lugar_entrega=$lugar_entrega;
                $osalida->validez_oferta=$validez_oferta;
                $osalida->garantia=$garantia;
                $osalida->observacion=$observacion;
                $osalida->numero_pagina="1";
                $osalida->nproducto_pagina="";
                $osalida->usuario_id=$_SESSION['usuario_ID'];
                $osalida->ver_adicional=$ver_adicional;
                $osalida->adicional=$adicional;
                $osalida->tipo_ID=27;
                //$osalida->insertar();
                $osalida->insertar_new();
                $mensaje="Se guardó correctamente";
                $resultado=1;
            }
            //insertamos los numero de cuentas
            //limpiamos si existen registros
            $dtsalida_Numero_Cuenta=salida_numero_cuenta::getGrid('salida_ID='.$osalida->ID);
            if(count($dtsalida_Numero_Cuenta)>0){
                foreach($dtsalida_Numero_Cuenta as $item){
                $osalida_Numero_Cuenta=salida_numero_cuenta::getByID($item['ID']);
                $osalida_Numero_Cuenta->usuario_mod_id=$_SESSION['usuario_ID'];
                $osalida_Numero_Cuenta->eliminar1();
                }
            }
            //ingresamos los valores
            $dtNumero_Cuenta=numero_cuenta::getGrid('moneda_ID='.$osalida->moneda_ID);

            foreach($dtNumero_Cuenta as $value){
                if(isset($_POST['cknumero_cuenta'.$value['ID']])){
                    $numero_cuenta_ID=$_POST['cknumero_cuenta'.$value['ID']];
                    $osalida_Numero_Cuenta=new salida_numero_cuenta();
                    $osalida_Numero_Cuenta->salida_ID=$osalida->ID;
                    $osalida_Numero_Cuenta->numero_cuenta_ID=$numero_cuenta_ID;
                    $osalida_Numero_Cuenta->usuario_id=$_SESSION['usuario_ID'];
                    $osalida_Numero_Cuenta->insertar1();
                   // $checked="checked";
                }
            }

        }

        catch (Exception $ex){
            log_error(__FILE__,"salida/post_Orden_Venta_Mantenimiento_Nuevo",$ex->getMessage());
            $resultado=-1;
            $mensaje=$ex->mensaje_error;

        }
        $contar_hijo=salida_detalle::getCount('salida_ID='.$id);
        if($contar_hijo>0){
            $osalida->ver_factura=1;
            $contador_factura=factura_venta::getCount('salida_ID='.$id.' and estado_ID in (35,41,53,60)');
            if($contador_factura>0){
                $osalida->ver_guia=1;
            }else {
                $osalida->ver_guia=0;
            }

        }else {
            $osalida->ver_factura=0;
            $osalida->ver_guia=0;
        }
        $dtCliente_Contacto=cliente_contacto::getGrid('clic.cliente_ID='.$cliente_ID);
        $GLOBALS['dtCliente_Contacto']=$dtCliente_Contacto;
        $oCliente=cliente::getByID($cliente_ID);
        //$dtCliente=cliente::getGrid("",-1,-1,"clt.razon_social asc");
        $oOperador=operador::getByID($osalida->operador_ID);
        $dtForma_Pago=forma_pago::getGrid();
        $dtCredito=credito::getGrid('id<>0');
        $oNumero_Cuenta=numero_cuenta::getByID(1);
        $dtEstado=estado::getGrid('est.tabla="cotizacion"');
       if($osalida->cotizacion_ID="NULL"){
           $oCotizacion=new cotizacion();
       }else {
           $oCotizacion=cotizacion::getByID($osalida->cotizacion_ID);
       }
        $oFactura_Venta=new factura_venta();
        $oFactura_Venta->ID=0;
        $GLOBALS['dtNumero_Cuenta']=mostrarNumeroCuentas(2,$osalida->moneda_ID,null,$osalida);
        $GLOBALS['oOrden_Venta']=$osalida;
        $GLOBALS['oFactura_Venta']=$oFactura_Venta;
        //$GLOBALS['dtCliente']=$dtCliente;
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
    function get_Orden_Venta_Mantenimiento_Editar($id){
        require ROOT_PATH.'models/salida.php';
        require ROOT_PATH.'models/salida_detalle.php';
        require ROOT_PATH.'models/moneda.php';
        require ROOT_PATH.'models/estado.php';
        require ROOT_PATH.'models/cliente.php';
        require ROOT_PATH.'models/cliente_contacto.php';
        require ROOT_PATH.'models/operador.php';
        require ROOT_PATH.'models/datos_generales.php';
        require ROOT_PATH.'models/forma_pago.php';
        require ROOT_PATH.'models/credito.php';
        require ROOT_PATH.'models/cotizacion.php';
        require ROOT_PATH.'models/numero_cuenta.php';
        require ROOT_PATH.'models/factura_venta.php';
        require ROOT_PATH.'controls/funcionController.php';
        global  $returnView_float;
        $returnView_float=true;
        $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
        $mensaje="";

        $osalida=salida::getByID($id);
        $contar_hijo=salida_detalle::getCount('salida_ID='.$id);
        if($contar_hijo>0){
            $osalida->ver_factura=1;
            $contador_factura=factura_venta::getCount('salida_ID='.$id.' and estado_ID in (35,41,53,60,93,94,95,96)');
            if($contador_factura>0){
                $osalida->ver_guia=1;
            }else {
                $osalida->ver_guia=0;
            }

        }else {
            $osalida->ver_factura=0;
            $osalida->ver_guia=0;
        }

        $oCliente=cliente::getByID($osalida->cliente_ID);
        $oOperador=operador::getByID($osalida->operador_ID);
        $dtForma_Pago=forma_pago::getGrid();
        $dtCredito=credito::getGrid('id<>0');
        $oNumero_Cuenta=numero_cuenta::getByID(1);
        $dtEstado=estado::getGrid('est.tabla="salida"');
        $osalida->dtRepresentante_Cliente=cliente_contacto::getGrid('clic.cliente_ID='.$osalida->cliente_ID,-1,-1,'pe.apellido_paterno asc,pe.apellido_paterno asc, pe.nombres asc');
        $osalida->bloquear_edicion=factura_venta::getCount('salida_ID='.$id.' and estado_ID in (41,93,94)');
        $GLOBALS['oOrden_Venta']=$osalida;
        $dtCliente=cliente::getGrid("",-1,-1,"clt.razon_social asc");
        $GLOBALS['oCliente']=$oCliente;
        $GLOBALS['dtCliente']=$dtCliente;
        $GLOBALS['dtNumero_Cuenta']=mostrarNumeroCuentas(2,$osalida->moneda_ID,null,$osalida);
        $GLOBALS['dtCredito']=$dtCredito;
        $GLOBALS['oOperador']=$oOperador;
        $GLOBALS['oDatos_Generales']=$oDatos_Generales;
        $GLOBALS['dtForma_Pago']=$dtForma_Pago;
        $GLOBALS['dtEstado']=$dtEstado;
        $GLOBALS['oNumero_Cuenta']=$oNumero_Cuenta;
        $GLOBALS['dtMoneda']=moneda::getGrid();


        $GLOBALS['mensaje']=$mensaje;
    }
     function post_Orden_Venta_Mantenimiento_Editar($id){
        require ROOT_PATH.'models/salida.php';
        require ROOT_PATH.'models/salida_detalle.php';
        require ROOT_PATH.'models/moneda.php';
        require ROOT_PATH.'models/estado.php';
        require ROOT_PATH.'models/cliente.php';
        require ROOT_PATH.'models/cliente_contacto.php';
        require ROOT_PATH.'models/operador.php';
        require ROOT_PATH.'models/datos_generales.php';
        require ROOT_PATH.'models/forma_pago.php';
        require ROOT_PATH.'models/credito.php';
        require ROOT_PATH.'models/cotizacion.php';
        require ROOT_PATH.'models/numero_cuenta.php';
        require ROOT_PATH.'models/salida_numero_cuenta.php';
        require ROOT_PATH.'models/factura_venta.php';
        require ROOT_PATH.'controls/funcionController.php';
        global  $returnView_float;
        $returnView_float=true;

        if(isset($_POST['selCliente'])){
            $cliente_ID=$_POST['selCliente'];
        }else{$cliente_ID=0;}
        $numero_orden_compra=$_POST['txtNumero_Orden_Compra'];
        $cliente_contacto_ID=0;
        if(isset($_POST['selRepresentante'])){
            $cliente_contacto_ID= $_POST['selRepresentante'];
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

        $adicional=$_POST['txtAdicional'];
        try{
            $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
            $osalida=salida::getByID($id);
            actualizar_costos_salida_detalle($osalida,$tipo_cambio);
            $osalida->cliente_ID=$cliente_ID;
            $osalida->numero_orden_compra=$numero_orden_compra;
            $osalida->cliente_contacto_ID=$cliente_contacto_ID;
            $osalida->moneda_ID=$moneda_ID;
            $osalida->tipo_cambio=$tipo_cambio;
            $osalida->plazo_entrega=$plazo_entrega;
            $osalida->forma_pago_ID=$forma_pago_ID;
            $osalida->tiempo_credito=$tiempo_credito;
            $osalida->fecha=$fecha;
            $osalida->lugar_entrega=$lugar_entrega;
            $osalida->validez_oferta=$validez_oferta;
            $osalida->garantia=$garantia;
            $osalida->observacion=$observacion;
            $osalida->ver_adicional=$ver_adicional;
            $osalida->adicional=$adicional;
            $osalida->usuario_mod_id=$_SESSION['usuario_ID'];
            if($osalida->estado_ID!=40){
                $osalida->actualizar();
                            //insertamos los numero de cuentas
                    //limpiamos si existen registros
                    $dtsalida_Numero_Cuenta=salida_numero_cuenta::getGrid('salida_ID='.$osalida->ID);
                    if(count($dtsalida_Numero_Cuenta)>0){
                        foreach($dtsalida_Numero_Cuenta as $item){
                        $osalida_Numero_Cuenta=salida_numero_cuenta::getByID($item['ID']);
                        $osalida_Numero_Cuenta->usuario_mod_id=$_SESSION['usuario_ID'];
                        $osalida_Numero_Cuenta->eliminar1();
                        }
                    }
                    //ingresamos los valores
                    $dtNumero_Cuenta=numero_cuenta::getGrid('moneda_ID='.$osalida->moneda_ID);

                    foreach($dtNumero_Cuenta as $value){
                        if(isset($_POST['cknumero_cuenta'.$value['ID']])){
                            $numero_cuenta_ID=$_POST['cknumero_cuenta'.$value['ID']];
                            $osalida_Numero_Cuenta=new salida_numero_cuenta();
                            $osalida_Numero_Cuenta->salida_ID=$osalida->ID;
                            $osalida_Numero_Cuenta->numero_cuenta_ID=$numero_cuenta_ID;
                            $osalida_Numero_Cuenta->usuario_id=$_SESSION['usuario_ID'];
                            $osalida_Numero_Cuenta->insertar1();
                           // $checked="checked";
                        }
                    }
                $resultado=1;
                $mensaje=$osalida->getMessage;
            }else {
                $resultado=-1;
                $mensaje="No se puede modificar la orden de venta, los comprobantes ya fueron remitidos.";
            }



        }

        catch (Exception $ex){
            $resultado=-1;
            $mensaje=utf8_encode(mensaje_error);
            log_error(__FILE__,"salida/post_Orden_Venta_Mantenimiento_Editar",$ex->getMessage());

        }
        $osalida->dtRepresentante_Cliente=cliente_contacto::getGrid('clic.cliente_ID='.$cliente_ID);
        $contar_hijo=salida_detalle::getCount('salida_ID='.$id);
        if($contar_hijo>0){
            $osalida->ver_factura=1;
            $contador_factura=factura_venta::getCount('salida_ID='.$id.' and estado_ID in (35,41,53,60)');
            if($contador_factura>0){
                $osalida->ver_guia=1;
            }else {
                $osalida->ver_guia=0;
            }

        }else {
            $osalida->ver_factura=0;
            $osalida->ver_guia=0;
        }
        $oCliente=cliente::getByID($osalida->cliente_ID);
        $oOperador=operador::getByID($osalida->operador_ID);
        $dtForma_Pago=forma_pago::getGrid();
        $dtCredito=credito::getGrid('id<>0');
        $oNumero_Cuenta=numero_cuenta::getByID(1);
        //$dtEstado=estado::getGrid('est.tabla="salida"');
        if($osalida->cotizacion_ID=="NULL" ||$osalida->cotizacion_ID==-1){
            $oCotizacion=new cotizacion();
        }else {
            $oCotizacion=cotizacion::getByID($osalida->cotizacion_ID);
        }
        $dtCliente=cliente::getGrid("",-1,-1,"clt.razon_social asc");$dtCliente=cliente::getGrid("",-1,-1,"clt.razon_social asc");
        //$oFactura_Venta=new factura_venta();
        //$oFactura_Venta->ID=0;
        $GLOBALS['dtNumero_Cuenta']=mostrarNumeroCuentas(2,$osalida->moneda_ID,null,$osalida);
        $GLOBALS['oOrden_Venta']=$osalida;
        //$GLOBALS['oFactura_Venta']=$oFactura_Venta;
        $GLOBALS['oCliente']=$oCliente;
        $GLOBALS['dtCliente']=$dtCliente;
        $GLOBALS['oCotizacion']=$oCotizacion;
        $GLOBALS['dtCredito']=$dtCredito;
        $GLOBALS['oOperador']=$oOperador;
        $GLOBALS['oDatos_Generales']=$oDatos_Generales;
        $GLOBALS['dtForma_Pago']=$dtForma_Pago;
        //$GLOBALS['dtEstado']=$dtEstado;
        $GLOBALS['oNumero_Cuenta']=$oNumero_Cuenta;
        $GLOBALS['dtMoneda']=moneda::getGrid('',-1,-1,'ID desc');
        $GLOBALS['resultado']=$resultado;
        $GLOBALS['mensaje']=$mensaje;
    }
    function post_ajaxOrden_Venta_Fisico_Detalle_Productos(){
        require ROOT_PATH.'models/salida.php';
        require ROOT_PATH.'models/salida_detalle.php';
        require ROOT_PATH.'models/producto.php';
        require ROOT_PATH.'models/moneda.php';
        require ROOT_PATH.'models/unidad_medida.php';
        require ROOT_PATH.'controls/funcionController.php';
        $salida_ID=$_POST['id'];


        //---------------------------------------
        $osalida=salida::getByID($salida_ID);
        $oMoneda=moneda::getByID($osalida->moneda_ID);
        //$resultado='<div style="height:150px;overflow:overlay;">';
        $resultado='<table id="tbProductos" class="table table-hover table-bordered table-responsive table-teal">';
        $resultado.='<thead><tr>';
        $resultado.='<th class="text-center">#</th>';
        $resultado.='<th class="text-center">Componentes </th>';
        $resultado.='<th class="text-center">Adicionales </th>';
        $resultado.='<th class="text-center">Cantidad </th>';
        $resultado.='<th class="text-center">Producto </th>';
        //$resultado.='<th class="text-center">Pre. Unit.</th>';
        $resultado.='<th class="text-center">Valor Unit.</th>';
        $resultado.='<th class="text-center">V. Venta</th>';
        $resultado.='<th></th>';
        $resultado.='</tr></thead>';
        $resultado.='<tbody>';
        $html="";
        try {
            $filtro='salida_ID='.$salida_ID. ' and tipo_ID in(1,2,5,6) and salida_detalle_ID=0';

            $rows=salida_detalle::getCount($filtro);

            $i=1;
            $costo_venta=0;
            $dtsalida_Detalle=salida_detalle::getGrid($filtro,-1,-1,'ID asc');
            foreach($dtsalida_Detalle as $item)
            {
                $salida_detalle_ID=$item['salida_detalle_ID'];
                if($salida_detalle_ID==0){
                $oProducto=producto::getByID($item['producto_ID']);
                    if($osalida->moneda_ID==1){
                        $costo_venta_unitario_padre=$item['precio_venta_unitario_soles'];
                        $precio_venta_subtotal_padre=$item['precio_venta_subtotal_soles'];
                    }else {
                        $costo_venta_unitario_padre=$item['precio_venta_unitario_dolares'];
                        $precio_venta_subtotal_padre=$item['precio_venta_subtotal_dolares'];
                    }


                    $resultado.='<tr class="item-tr" id="'.$item['ID'].'">';

                    //$contar=cotizacion_detalle::getCount('cotizacion_ID='.$cotizacion_ID.' and cotizacion_detalle_ID='.$item['ID'],-1,-1,'tipo asc');

                    $array=retornar_valores($item['tipo_ID']);
                    $componente="";
                    if($array['componente']==1){
                        $componente="<img src='/include/img/boton/check_16x16.png'/>";
                    }

                    $adicional='';
                    if($array['adicional']==1){
                        $adicional="<img src='/include/img/boton/check_16x16.png'/>";
                    }
                    $resultado.='<td class="text-center">'.$i.'</td>';
                    $resultado.='<td class="text-center">'.$componente.'</td>';
                    $resultado.='<td class="text-center">'.$adicional.'</td>';
                    $resultado.='<td class="text-center">'.$item['cantidad'].'</td>';
                   
                    $resultado.='<td class="tdLeft">'. test_input($oProducto->nombre).'</td>';
                   
                    //$resultado.='<td class="text-right">'.number_format($costo_venta_unitario_padre,2,".",",").'</td>';
                    $resultado.='<td class="text-right">'.number_format($item['valor_unitario'],2,".",",").'</td>';
                    $resultado.='<td class="text-right">'.number_format($precio_venta_subtotal_padre,2,".",",").'</td>';
                    $botones=array();
                    if($osalida->estado_ID==40||$osalida->estado_ID==42){
                        array_push($botones,'<a onclick="fncVerProducto(' . $item['ID'] . ');" title="Ver Producto"><span class="glyphicon glyphicon-pencil"></span>Ver</a>');
                        array_push($botones,'<a onclick="fncSeries(' . $item['ID'] . ');" title="Registrar series" ><span class="glyphicon glyphicon-barcode"></span>Serie</a>');

                    }else{
                        array_push($botones,'<a onclick="fncEditarProducto(' . $item['ID'] . ');"title="Editar Producto"><span class="glyphicon glyphicon-pencil"></span>Editar</a>');
                        array_push($botones,'<a onclick="fncSeries(' . $item['ID'] . ');" title="Registrar series" ><span class="glyphicon glyphicon-barcode"></span>Serie</a>');
                        array_push($botones,'<a onclick="modal.confirmacion(&#39;El proceso es irreversible, esta seguro de eliminar el registro.&#39;,&#39;Eliminar Producto&#39;,fncEliminarProducto,&#39;' . $item['ID'] . '&#39;);" title="Eliminar Producto"><span class="glyphicon glyphicon-trash"></span>Eliminar</a>');

                    }

                    $resultado.='<td class="text-center">'.extraerOpcion($botones)."</td>";
                    $resultado.='</tr>';
                    $i++;

                }
            }

            if($osalida->moneda_ID==1){
                $vigv_t=number_format($osalida->vigv_soles,2,'.',',');
                $precio_venta_neto_t=number_format($osalida->precio_venta_neto_soles,2,'.',',');
                $precio_venta_total_t=number_format($osalida->precio_venta_total_soles,2,'.',',');

            }else {
                $vigv_t=number_format($osalida->vigv_dolares,2,'.',',');
                $precio_venta_neto_t=number_format($osalida->precio_venta_neto_dolares,2,'.',',');
                $precio_venta_total_t=number_format($osalida->precio_venta_total_dolares,2,'.',',');
            }
            $html=mostrar_productos($salida_ID,1);

           }catch(Exception $ex){
            $resultado.='<tr ><td colspan="7">'.$ex->getMessage().'</td></tr>';
        }
        $resultado.='</tbody>';
        $resultado.='<tfooter>';
        
        $resultado.='<tr><th colspan="6" class="text-right">OP. GRAVADA: '.$oMoneda->simbolo.'</th><th id="tdGravada" class="text-right">'.number_format($osalida->gravadas,2,'.',',').'</th><td></td></tr>';
        //$resultado.='<tr><th colspan="6" class="text-right">OP. INAFECTA: '.$oMoneda->simbolo.'</th><th id="tdInafecta" class="text-right">'.number_format($osalida->inafectas,2,'.',',').'</th><td></td></tr>';
        //$resultado.='<tr><th colspan="6" class="text-right">OP. EXONERADA: '.$oMoneda->simbolo.'</th><th id="tdExonerada" class="text-right">'.number_format($osalida->exoneradas,2,'.',',').'</th><td></td></tr>';
        $resultado.='<tr><th colspan="6" class="text-right">TOTAL IGV: '.$oMoneda->simbolo.'</th><th id="tdIgv" class="text-right">'.$vigv_t.'</th><td></td></tr>';
         //$resultado.='<tr><th colspan="6" class="text-right">OP. GRATUITAS: '.$oMoneda->simbolo.'</th><th class="text-right">'.number_format($osalida->gratuitas,2,'.',',').'</th><td></td></tr>';
        $resultado.='<tr><th colspan="6" class="text-right">IMPORTE TOTAL: '.$oMoneda->simbolo.'</th><th id="tdTotal" class="text-right">'.$precio_venta_total_t.'</th><td></td></tr>';
        $resultado.='</tfooter>';
        $resultado.='</table>';
        /*$resultado.='<div class="infoCostos" style="text-align:right;"><b>Sub Total:</b/><div style="width:80px;float: right;padding-right: 20px;">'.$precio_venta_neto_t.'</div></div>';
        $resultado.='<div class="infoCostos" style="text-align:right;"><b>IGV:<b/><div style="width:80px;float: right;padding-right: 20px;">'.$vigv_t.'</div></div>';
        $resultado.='<div class="infoCostos" style="text-align:right;"><b>Total:<b/><div style="width:80px;float: right;padding-right: 20px;">'.$precio_venta_total_t.'</div></div>';
*/
        $retornar=Array('resultado'=>$resultado,'vigv'=>$vigv_t,'subtotal'=>$precio_venta_neto_t,
            'total'=>$precio_venta_total_t,'gravadas'=>$osalida->gravadas,'exoneradas'=>$osalida->exoneradas,
            'inafectas'=>$osalida->inafectas,
            'precio_venta_total_soles'=>$osalida->precio_venta_total_soles,'precio_venta_total_dolares'=>$osalida->precio_venta_total_dolares,
            'vigv_soles'=>$osalida->vigv_soles,'vigv_dolares'=>$osalida->vigv_dolares,'html'=>$html);
        //$retorn="<h1>Hola</h1>";

        echo json_encode($retornar);
    }
    function post_ajaxEstructuraOrden_Venta_Fisico_Detalle(){
        require ROOT_PATH.'models/salida.php';
        require ROOT_PATH.'models/salida_detalle.php';
        require ROOT_PATH.'models/factura_venta.php';
        require ROOT_PATH.'controls/funcionController.php';
        $salida_ID=$_POST['id'];
        $ver_descripcion=$_POST['id1'];

        //---------------------------------------
       
 
        try {
            
            $dtsalida_detalle=salida_detalle::getGridLista("ovd.salida_ID=".$salida_ID. ' and ovd.tipo_ID in (1,2,5,6)');
            factura_venta::actualizar_estructura($salida_ID,$ver_descripcion);
                $html ='<table  id="tablaproducto" cellsspacin="0" cellspadding="0">';
                $i=1;
                foreach ($dtsalida_detalle as $item){

                    $html.='<tr>';
                    $html.='<td id="td'.$i.'" width="85.4px" style="text-align:center; padding-top: 10px; border:none;font-weight: bold;">'. $item['cantidad'].' </td>';
                    $html.='<td width="524.3px" style="padding:0 20px;padding-top: 10px;border:none;"><span style="font-weight: bold;">'. test_input($item['producto']).'</span>';
                    if($ver_descripcion==1){
                        if($item['descripcion']!=""){
                            $html.='<br/><span>'. nl2br($item['descripcion']) .'</span>';
                       }

                    }
                    

                    $dtsalida_detalle_Componente=salida_detalle::getGridLista("ovd.salida_detalle_ID=".$item['ID'].' and ovd.tipo_ID=3');
                    if(count($dtsalida_detalle_Componente)>0){
                        $html.='<br/>';
                        foreach($dtsalida_detalle_Componente as $componente){
                            $html.='<span>'.$componente['producto'].'&nbsp;&nbsp;('.$componente['cantidad'].'&nbsp;'.$componente['unidad_medida'].')</span><br/>';
                        }
                    }
                    $html.='</td>';
                    $html.='<td width="81.6px" style="text-align:center;padding-top: 10px;border:none;font-weight: bold;">'. $item['unidad_medida'].'</td>';
                    $html.='<td width="110.7px" style="text-align:center;padding-top: 10px;border:none;font-weight: bold;">'. $item['peso'] . '</td>';
                    $html.='</tr>';
                    $i=$i+1;
                }

                $html.='</table>';
                $retorna=$html;
            

        }catch(Exception $ex){
            log_error(__FILE__,"salida/post_ajaxEstructuraOrden_Venta_Fisico_Detalle",$ex->getMessage());
            
        }
       

        $retornar=Array('html'=>$html);
        //$retorn="<h1>Hola</h1>";

        echo json_encode($retornar);
    }
    
    function post_ajaxOrden_Venta_Detalle_Productos(){
        require ROOT_PATH.'models/salida.php';
        require ROOT_PATH.'models/salida_detalle.php';
        require ROOT_PATH.'models/producto.php';
        require ROOT_PATH.'models/moneda.php';
        require ROOT_PATH.'models/unidad_medida.php';
        require ROOT_PATH.'controls/funcionController.php';
        $salida_ID=$_POST['id'];

        
        //---------------------------------------
        $osalida=salida::getByID($salida_ID);
        $oMoneda=moneda::getByID($osalida->moneda_ID);
        //$resultado='<div style="height:150px;overflow:overlay;">';
        $resultado='<table id="tbProductos" class="table table-hover table-bordered table-responsive table-teal">';
        $resultado.='<thead><tr>';
        $resultado.='<th class="text-center">#</th>';
        $resultado.='<th class="text-center">Componentes </th>';
        $resultado.='<th class="text-center">Adicionales </th>';
        $resultado.='<th class="text-center">Cantidad </th>';
        $resultado.='<th class="text-center">Producto </th>';
        //$resultado.='<th class="text-center">Pre. Unit.</th>';
        $resultado.='<th class="text-center">Valor Unit.</th>';
        $resultado.='<th class="text-center">V. Venta</th>';
        $resultado.='<th></th>';
        $resultado.='</tr></thead>';
        $resultado.='<tbody>';
        $html="";
        try {
            $filtro='salida_ID='.$salida_ID. ' and tipo_ID in(1,2,5,6) and salida_detalle_ID=0';

            $rows=salida_detalle::getCount($filtro);

            $i=1;
            $costo_venta=0;
            $dtsalida_Detalle=salida_detalle::getGrid($filtro,-1,-1,'ID asc');
            
            foreach($dtsalida_Detalle as $item)
            {
                $salida_detalle_ID=$item['salida_detalle_ID'];
                if($salida_detalle_ID==0){
                $oProducto=producto::getByID($item['producto_ID']);
                    if($osalida->moneda_ID==1){
                        $costo_venta_unitario_padre=$item['precio_venta_unitario_soles'];
                        $precio_venta_subtotal_padre=$item['precio_venta_subtotal_soles'];
                    }else {
                        $costo_venta_unitario_padre=$item['precio_venta_unitario_dolares'];
                        $precio_venta_subtotal_padre=$item['precio_venta_subtotal_dolares'];
                    }


                    $resultado.='<tr class="item-tr" id="'.$item['ID'].'">';

                    //$contar=cotizacion_detalle::getCount('cotizacion_ID='.$cotizacion_ID.' and cotizacion_detalle_ID='.$item['ID'],-1,-1,'tipo asc');

                    $array=retornar_valores($item['tipo_ID']);
                    $componente="";
                    if($array['componente']==1){
                        $componente="<img src='/include/img/boton/check_16x16.png'/>";
                    }

                    $adicional='';
                    if($array['adicional']==1){
                        $adicional="<img src='/include/img/boton/check_16x16.png'/>";
                    }
                    $resultado.='<td class="text-center">'.$i.'</td>';
                    $resultado.='<td class="text-center">'.$componente.'</td>';
                    $resultado.='<td class="text-center">'.$adicional.'</td>';
                    $resultado.='<td class="text-center">'.$item['cantidad'].'</td>';
                    $resultado.='<td class="tdLeft">'.utf8_encode(strtoupper($oProducto->nombre)).'</td>';
                    //$resultado.='<td class="text-right">'.number_format($costo_venta_unitario_padre,2,".",",").'</td>';
                    $resultado.='<td class="text-right">'.number_format($item['valor_unitario'],2,".",",").'</td>';
                    $resultado.='<td class="text-right">'.number_format($precio_venta_subtotal_padre,2,".",",").'</td>';
                    $botones=array();
                    if($osalida->estado_ID==40||$osalida->estado_ID==42){
                        array_push($botones,'<a onclick="fncVerProducto(' . $item['ID'] . ');" ><span class="glyphicon glyphicon-pencil" title="Ver Producto">Ver</a>');
                        array_push($botones,'<a onclick="fncSeries(' . $item['ID'] . ');" title="Registrar series" ><span class="glyphicon glyphicon-barcode"></span>Serie</a>');

                    }else{
                        array_push($botones,'<a onclick="fncEditarProducto(' . $item['ID'] . ');"title="Editar Producto" ><span class="glyphicon glyphicon-pencil"></span>Editar</a>');
                        array_push($botones,'<a onclick="fncSeries(' . $item['ID'] . ');" title="Registrar series" ><span class="glyphicon glyphicon-barcode"></span>Serie</a>');
                        array_push($botones,'<a onclick="modal.confirmacion(&#39;El proceso es irreversible, esta seguro de eliminar el registro.&#39;,&#39;Eliminar Producto&#39;,fncEliminarProducto,&#39;' . $item['ID'] . '&#39;);" title="Eliminar Producto"><span class="glyphicon glyphicon-trash"></span>Eliminar</a>');

                    }

                    $resultado.='<td class="text-center">'.extraerOpcion($botones)."</td>";
                    $resultado.='</tr>';
                    $i++;

                }
            }
           
            if($osalida->moneda_ID==1){
                $vigv_t=number_format($osalida->vigv_soles,2,'.',',');
                $precio_venta_neto_t=number_format($osalida->precio_venta_neto_soles,2,'.',',');
                $precio_venta_total_t=number_format($osalida->precio_venta_total_soles,2,'.',',');

            }else {
                $vigv_t=number_format($osalida->vigv_dolares,2,'.',',');
                $precio_venta_neto_t=number_format($osalida->precio_venta_neto_dolares,2,'.',',');
                $precio_venta_total_t=number_format($osalida->precio_venta_total_dolares,2,'.',',');
            }
            $html=mostrar_productos($salida_ID,1);

           }catch(Exception $ex){
            $resultado.='<tr ><td colspan="7">'.$ex->getMessage().'</td></tr>';
        }
        $resultado.='</tbody>';
        $resultado.='<tfooter>';
        
        $resultado.='<tr><th colspan="6" class="text-right">OP. GRAVADA: '.utf8_encode($oMoneda->simbolo).'</th><th id="tdGravada" class="text-right">'.number_format($osalida->gravadas,2,'.',',').'</th><td></td></tr>';
        $resultado.='<tr><th colspan="6" class="text-right">OP. INAFECTA: '.utf8_encode($oMoneda->simbolo).'</th><th id="tdInafecta" class="text-right">'.number_format($osalida->inafectas,2,'.',',').'</th><td></td></tr>';
        $resultado.='<tr><th colspan="6" class="text-right">OP. EXONERADA: '.utf8_encode($oMoneda->simbolo).'</th><th id="tdExonerada" class="text-right">'.number_format($osalida->exoneradas,2,'.',',').'</th><td></td></tr>';
        $resultado.='<tr><th colspan="6" class="text-right">TOTAL IGV: '.utf8_encode($oMoneda->simbolo).'</th><th id="tdIgv" class="text-right">'.$vigv_t.'</th><td></td></tr>';
         $resultado.='<tr><th colspan="6" class="text-right">OP. GRATUITAS: '.utf8_encode($oMoneda->simbolo).'</th><th class="text-right">'.number_format($osalida->gratuitas,2,'.',',').'</th><td></td></tr>';
        $resultado.='<tr><th colspan="6" class="text-right">IMPORTE TOTAL: '.utf8_encode($oMoneda->simbolo).'</th><th id="tdTotal" class="text-right">'.$precio_venta_total_t.'</th><td></td></tr>';
        $resultado.='</tfooter>';
        $resultado.='</table>';
        /*$resultado.='<div class="infoCostos" style="text-align:right;"><b>Sub Total:</b/><div style="width:80px;float: right;padding-right: 20px;">'.$precio_venta_neto_t.'</div></div>';
        $resultado.='<div class="infoCostos" style="text-align:right;"><b>IGV:<b/><div style="width:80px;float: right;padding-right: 20px;">'.$vigv_t.'</div></div>';
        $resultado.='<div class="infoCostos" style="text-align:right;"><b>Total:<b/><div style="width:80px;float: right;padding-right: 20px;">'.$precio_venta_total_t.'</div></div>';
*/
        $retornar=Array('resultado'=>utf8_encode($resultado),'vigv'=>$vigv_t,'subtotal'=>$precio_venta_neto_t,
            'total'=>$precio_venta_total_t,'gravadas'=>$osalida->gravadas,'exoneradas'=>$osalida->exoneradas,
            'inafectas'=>$osalida->inafectas,
            'precio_venta_total_soles'=>$osalida->precio_venta_total_soles,'precio_venta_total_dolares'=>$osalida->precio_venta_total_dolares,
            'vigv_soles'=>$osalida->vigv_soles,'vigv_dolares'=>$osalida->vigv_dolares,'html'=>$html);
        //$retorn="<h1>Hola</h1>";

        echo json_encode($retornar);
    }
    function post_ajaxOrden_Venta_Detalle_Obsequios(){
        require ROOT_PATH.'models/salida.php';
        require ROOT_PATH.'models/salida_detalle.php';
        require ROOT_PATH.'models/producto.php';
        require ROOT_PATH.'models/moneda.php';
        require ROOT_PATH.'models/unidad_medida.php';
        require ROOT_PATH . 'controls/funcionController.php';
        $salida_ID=$_POST['id'];


        //---------------------------------------
        $osalida=salida::getByID($salida_ID);
        $oMoneda=moneda::getByID($osalida->moneda_ID);

        $resultado='<table id="tbObsequios" class="table table-hover table-bordered table-responsive table-teal">';
        $resultado.='<thead><tr>';
        $resultado.='<th>Item </th>';
        $resultado.='<th>Producto </th>';
        $resultado.='<th>Cantidad </th>';
        $resultado.='<th>Opción</th>';
        $resultado.='</tr>';
        $resultado.='</thead>';
        $resultado.='<tbody>';

        try {
            $filtro='salida_ID='.$salida_ID.' and tipo_ID=7';

            $rows=salida_detalle::getCount($filtro);
            $i=1;
            $costo_venta=0;

            $dtsalida_Detalle=salida_detalle::getGrid($filtro,-1,-1,'ID asc');
            foreach($dtsalida_Detalle as $item)
            {
                $oProducto=producto::getByID($item['producto_ID']);
                $resultado.='<tr class="item-tr" id="'.$item['ID'].'" >';
                $resultado.='<td class="text-center">'.$i.'</td>';
                $resultado.='<td class="tdLeft">'.FormatTextView(strtoupper($oProducto->nombre)).'</td>';
                $resultado.='<td class="text-center">'.$item['cantidad'].'</td>';
                $botones=array();
                array_push($botones,'<a href="javascript:void(0);" onclick="fncEditarObsequio(' . $item['ID'] . ');" title="Editar Obsequio" ><span class="glyphicon glyphicon-pencil"></span>Editar</a>');
                array_push($botones,'<a href="javascript:void(0);" onclick="fncSeries(' . $item['ID'] . ');" title="Registrar serie" ><i class="fa fa-barcode"></i>Reistrar serie</a>');
                array_push($botones,'<a onclick="modal.confirmacion(&#39;El proceso es irreversible, esta seguro de eliminar el registro.&#39;,&#39;Eliminar Obsequio&#39;,fncEliminarObsequio,&#39;' . $item['ID'] . '&#39;);" title="Eliminar Obsequio"><span class="glyphicon glyphicon-trash"></span>Eliminar</a>');
                $resultado.='<td class="text-center" >'.extraerOpcion($botones)."</td>";

                $resultado.='</tr>';
                $i++;

            }

        }catch(Exception $ex){
                $resultado.='<tr ><td colspan="4">'.$ex->getMessage().'</td></tr>';
        }
        $resultado.='</tbody>';
        $resultado.='</table>';

        $mensaje='';
        $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);
        //$retorn="<h1>Hola</h1>";

        echo json_encode($retornar);
    }
    function get_Orden_Venta_Mantenimiento_Importar_Cotizacion($ID){

        require ROOT_PATH.'models/salida.php';
        global  $returnView_float;
        $returnView_float=true;
        $GLOBALS['tipo_ID']=$ID;
    }
function post_ajaxOrden_Venta_Mantenimiento_Importar_Cotizacion() {
    require ROOT_PATH . 'models/cotizacion.php';
    require ROOT_PATH . 'models/moneda.php';
    require ROOT_PATH . 'models/estado.php';
    require ROOT_PATH . 'controls/funcionController.php';
    $buscar = $_POST['txtBuscar'];
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
            $orden = 'co.numero_concatenado ' . $orden_tipo;
            break;
        case 2:
            $orden = 'co.fecha ' . $orden_tipo;
            break;
        case 3:
            $orden = 'cl.razon_social ' . $orden_tipo;
            break;
        case 4:
            $orden = 'co.moneda_ID ' . $orden_tipo;
            break;
        case 5:
            $orden = 'co.precio_venta_total_soles ' . $orden_tipo;
            break;
        case 6:
            $orden = 'co.precio_venta_total_dolares ' . $orden_tipo;
            break;

        default:
            $orden = 'co.ID ' . $orden_tipo;
            break;
    }

    $filtro = 'upper(concat(cl.razon_social," ",cl.ruc)) like "%' . str_replace(' ', '%', strtoupper(FormatTextSave($buscar))) . '%" and co.estado_ID=2';
    if($_POST['txtNumero']>0||trim($_POST['txtNumero'])!=""){
       $filtro=' co.numero='.$_POST['txtNumero'].' and co.estado_ID=2';
    }
    //---------------------------------------
    $resultado = '<table class="grid table table-hover table-bordered table-teal"><tr>';
    $resultado.='<th style="width:90px;"></th>';
    $resultado.='<th  class="thOrden" onclick="fncOrden(1);">Número' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th  class="thOrden" onclick="fncOrden(2);">Fecha' . (($txtOrden == 2 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th  class="thOrden" onclick="fncOrden(3);">Cliente' . (($txtOrden == 3 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th  class="thOrden" onclick="fncOrden(4);">Moneda' . (($txtOrden == 4 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th  class="thOrden" onclick="fncOrden(5);">Monto' . (($txtOrden == 5 ? "<img class=" . $orden_class . " />" : "")) . '</th>';

    $resultado.='</tr>';

    $colspanFooter = 6;
    try {
        $cantidadMaxima = cotizacion::getCount($filtro);
        $dtCotizacion = cotizacion::getGrid($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
        $rows = count($dtCotizacion);

        foreach ($dtCotizacion as $item) {
            $oMoneda=moneda::getByID($item['moneda_ID']);
            $monto=$item['precio_venta_total_soles'];
            if($item['moneda_ID']==2){
                $monto=$item['precio_venta_total_dolares'];
            }
            $resultado.='<tr class="tr-item">';
            $resultado.='<td class="btnAction"><a title="Generar Orden de Venta" class="btn"   onclick="modal.confirmacion(&#39;El proceso será irreversible, desea generar la venta?&#39;,&#39;Generar venta&#39;,fncVender,' . $item['ID'] . ');">Generar</a></td>';
            $resultado.='<td class="tdCenter">' . $item['numero_concatenado'] . '</td>';
            $resultado.='<td class="tdCenter">' . FormatTextViewHtml($item['fecha']) . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextViewHtml($item['razon_social']) . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextViewHtml($oMoneda->simbolo) . '</td>';
            $resultado.='<td class="tdRight">' . $monto . '</td>';

            $resultado.='</tr>';
        }

        $cantidadPaginas = '';
        $resultado.=paginacion($cantidadMaxima,$cantidadMostrar,$colspanFooter,$paginaActual);
        $resultado.='<tr class="tr-footer"><th colspan=' . $colspanFooter . '>' . $rows . ' de ' . $cantidadMaxima . ' Registros</th></tr>';

        } catch (Exception $ex) {
        $resultado.='<tr ><td colspan=' . $colspanFooter . '>' . $ex->getMessage() . '</td></tr>';
    }

    $resultado.='</table>';

    $mensaje = '';
    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
    //$retorn="<h1>Hola</h1>";

    echo json_encode($retornar);
}
    function post_ajaxExtraerCotizacion(){
        require ROOT_PATH.'models/cotizacion.php';
        require ROOT_PATH.'models/cotizacion_detalle.php';
        require ROOT_PATH.'models/salida.php';
        require ROOT_PATH.'models/salida_detalle.php';
        require ROOT_PATH.'models/datos_generales.php';
        require ROOT_PATH.'models/cotizacion_numero_cuenta.php';
        require ROOT_PATH.'models/salida_numero_cuenta.php';
        require ROOT_PATH.'models/producto.php';
         $cotizacion_ID=$_POST['cotizacion_ID'];
         $tipo_ID_venta=$_POST['tipo_ID'];
        try {
            $oCotizacion=cotizacion::getByID($cotizacion_ID);
            $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);

            $numero_cuenta_IDs="";
            $impuestos_tipo_ID=1;
            $tipo_precio_venta_unitario_ID=1;
            //ingresamos los valores en la tabla orden de venta
            if($oCotizacion!=null){
                $osalida=new salida();
                $osalida->tipo_ID=$tipo_ID_venta;
                $osalida->cotizacion_ID=$oCotizacion->ID;
                $osalida->cliente_ID=$oCotizacion->cliente_ID;
                $osalida->cliente_contacto_ID=$oCotizacion->cliente_contacto_ID;
                $osalida->operador_ID=$oCotizacion->operador_ID;
                $osalida->periodo=date("Y");;
                $osalida->numero=salida::getNumero();
                $numero_ceros=sprintf("%'.07d", $osalida->numero);
                $numero_concatenado=$numero_ceros.'-'.$osalida->periodo;
                $osalida->numero_concatenado=$numero_concatenado;
                $osalida->numero_orden_compra="";
                $osalida->moneda_ID=$oCotizacion->moneda_ID;
                $osalida->fecha=date('d/m/Y');
                $osalida->igv=$oCotizacion->igv;
                $osalida->vigv_soles=$oCotizacion->vigv_soles;
                $osalida->vigv_dolares=$oCotizacion->vigv_dolares;
                $osalida->precio_venta_neto_soles=$oCotizacion->precio_venta_neto_soles;
                $osalida->precio_venta_total_soles=$oCotizacion->precio_venta_total_soles;
                $osalida->precio_venta_neto_dolares=$oCotizacion->precio_venta_neto_dolares;
                $osalida->precio_venta_total_dolares=$oCotizacion->precio_venta_total_dolares;
                $osalida->forma_pago_ID=$oCotizacion->forma_pago_ID;
                $osalida->tiempo_credito=$oCotizacion->tiempo_credito;
                $osalida->descuento_soles=0;
                $osalida->descuento_dolares=0;
                $osalida->estado_ID=28;
                $osalida->tipo_cambio=$oCotizacion->tipo_cambio;
                $osalida->plazo_entrega=utf8_decode($oCotizacion->plazo_entrega);
                $osalida->lugar_entrega=$oCotizacion->lugar_entrega;
                $osalida->validez_oferta=$oCotizacion->validez_oferta;
                $osalida->garantia=  utf8_decode($oCotizacion->garantia);
                $osalida->observacion=utf8_decode($oCotizacion->observacion);
                $osalida->numero_pagina=1;
                $osalida->nproducto_pagina="1";
                $osalida->usuario_id=$_SESSION['usuario_ID'];
                $osalida->ver_adicional=1;
                $osalida->adicional="Nueva central telef&oacute;nica ".$oDatos_Generales->telefono;
                
                
                //Registramos los numero de cuentas
                $dtCotizacion_Numero_Cuenta=cotizacion_numero_cuenta::getGrid('cotizacion_ID='.$oCotizacion->ID);
                $cadena_numero_cuenta="";
                $i=0;
                foreach($dtCotizacion_Numero_Cuenta as $valor){
                    if($i==0){
                        $cadena_numero_cuenta=$valor['numero_cuenta_ID'];
                    }else{
                        $cadena_numero_cuenta=$cadena_numero_cuenta.','.$valor['numero_cuenta_ID'];
                    }
                        
                }
                $osalida->cadena_numero_cuenta=$cadena_numero_cuenta;
                $osalida->insertar_new();
            }

            $contar=cotizacion_detalle::getCount('cotizacion_ID='.$cotizacion_ID.' and cotizacion_detalle_ID=0');
            if($contar>0){
                $dtCotizacion_Detalle=cotizacion_detalle::getGrid('cotizacion_ID='.$cotizacion_ID.' and cotizacion_detalle_ID=0');
                foreach($dtCotizacion_Detalle as $item){
                    $oProducto=producto::getByID($item['producto_ID']);
                    $osalida_Detalle=new salida_detalle();
                    $osalida_Detalle->producto_ID=$item['producto_ID'];
                    $osalida_Detalle->observacion='';
                    $osalida_Detalle->salida_ID=$osalida->ID;
                    $osalida_Detalle->descripcion=$item['descripcion'];
                    $osalida_Detalle->cantidad=$item['cantidad'];
                    $osalida_Detalle->precio_venta_unitario_soles=$item['precio_venta_unitario_soles'];
                    $osalida_Detalle->precio_venta_unitario_dolares=$item['precio_venta_unitario_dolares'];
                    $osalida_Detalle->precio_venta_subtotal_soles=$item['precio_venta_subtotal_soles'];
                    $osalida_Detalle->precio_venta_subtotal_dolares=$item['precio_venta_subtotal_dolares'];
                    $osalida_Detalle->precio_venta_soles=$item['precio_venta_soles'];
                    $osalida_Detalle->precio_venta_dolares=$item['precio_venta_dolares'];
                    $osalida_Detalle->igv=$item['igv'];
                    $osalida_Detalle->vigv_soles=$item['vigv_soles'];
                    $osalida_Detalle->vigv_dolares=$item['vigv_dolares'];
                    $osalida_Detalle->salida_detalle_ID=0;
                    $osalida_Detalle->estado_ID=31;
                    $osalida_Detalle->cotizacion_detalle_ID=$item['ID'];
                    $osalida_Detalle->ver_precio=$item['ver_precio'];
                    $osalida_Detalle->usuario_id=$_SESSION['usuario_ID'];
                    $osalida_Detalle->tipo_ID=$item['tipo_ID'];
                    $osalida_Detalle->obsequio=0;
                   
                    $osalida_Detalle->impuestos_tipo_ID=$impuestos_tipo_ID;
                    $osalida_Detalle->tipo_precio_venta_unitario_ID=$tipo_precio_venta_unitario_ID;
                    $osalida_Detalle->peso=$oProducto->peso;
                    $osalida_Detalle->tipo_sistema_calculo_isc_ID=null;
                    $osalida_Detalle->descuento_unitario=0;
                    $osalida_Detalle->pu_incluye_igv=0;
                    $osalida_Detalle->pu_incluye_isc=0;
                    $osalida_Detalle->descuento_porcentaje=0;
                    
                    $osalida_Detalle->isc_porcentaje=0;
                    $osalida_Detalle->isc_valor_referencial=0;
                    $osalida_Detalle->isc_activo=0;
                    $osalida_Detalle->valor_venta_soles=$item['precio_venta_subtotal_soles'];
                    $osalida_Detalle->valor_venta_dolares=$item['precio_venta_subtotal_dolares'];
                    $osalida_Detalle->visc_soles=0;
                    $osalida_Detalle->visc_dolares=0;
                    $osalida_Detalle->descuento_soles=0;
                    $osalida_Detalle->descuento_dolares=0;
                    $osalida_Detalle->descuento=0;
                    $osalida_Detalle->valor_unitario=($osalida->moneda_ID=1)?$item['precio_venta_unitario_soles']:$item['precio_venta_unitario_dolares'];
            
                    $osalida_Detalle->insertar_new();
                    $producto_ID_old=$osalida_Detalle->producto_ID;
                    actualizar_inventario($osalida_Detalle,$producto_ID_old,$_SESSION['usuario_ID'],$_SESSION['empresa_ID']);
                    //Insertamos los componentes

                    $contarHijo=cotizacion_detalle::getCount('cotizacion_detalle_ID='.$item['ID']);
                    if($contarHijo>0){
                        $dtCotizacion_Detalle_Hijos=cotizacion_detalle::getGrid('cotizacion_detalle_ID='.$item['ID'],-1,-1);
                        foreach ($dtCotizacion_Detalle_Hijos as $item1) {
                            $oProducto1=producto::getByID($item1['producto_ID']);
                            $osalida_Detalle_Hijo=new salida_detalle();
                            $osalida_Detalle_Hijo->producto_ID=$item1['producto_ID'];
                            $osalida_Detalle_Hijo->observacion='';
                            $osalida_Detalle_Hijo->salida_ID=$osalida->ID;
                            $osalida_Detalle_Hijo->descripcion=$item1['descripcion'];
                            $osalida_Detalle_Hijo->cantidad=$item1['cantidad'];
                            $osalida_Detalle_Hijo->precio_venta_unitario_soles=$item1['precio_venta_unitario_soles'];
                            $osalida_Detalle_Hijo->precio_venta_unitario_dolares=$item1['precio_venta_unitario_dolares'];
                            $osalida_Detalle_Hijo->precio_venta_subtotal_soles=$item1['precio_venta_subtotal_soles'];
                            $osalida_Detalle_Hijo->precio_venta_subtotal_dolares=$item1['precio_venta_subtotal_dolares'];
                            $osalida_Detalle_Hijo->precio_venta_soles=$item1['precio_venta_soles'];
                            $osalida_Detalle_Hijo->precio_venta_dolares=$item1['precio_venta_dolares'];
                            $osalida_Detalle_Hijo->igv=$item1['igv'];
                            $osalida_Detalle_Hijo->vigv_soles=$item1['vigv_soles'];
                            $osalida_Detalle_Hijo->vigv_dolares=$item1['vigv_dolares'];
                            $osalida_Detalle_Hijo->salida_detalle_ID=$osalida_Detalle->ID;
                            $osalida_Detalle_Hijo->estado_ID=31;
                            $osalida_Detalle_Hijo->cotizacion_detalle_ID=$item1['ID'];
                            $osalida_Detalle_Hijo->ver_precio=$item1['ver_precio'];
                            $osalida_Detalle_Hijo->tipo_ID=$item1['tipo_ID'];
                            $osalida_Detalle_Hijo->obsequio=0;
                            $osalida_Detalle_Hijo->usuario_id=$_SESSION['usuario_ID'];
                            $osalida_Detalle_Hijo->impuestos_tipo_ID=$impuestos_tipo_ID;
                            $osalida_Detalle_Hijo->tipo_precio_venta_unitario_ID=$tipo_precio_venta_unitario_ID;
                            
                            $osalida_Detalle_Hijo->peso=$oProducto1->peso;
                            $osalida_Detalle_Hijo->tipo_sistema_calculo_isc_ID=null;
                            $osalida_Detalle_Hijo->descuento_unitario=0;
                            $osalida_Detalle_Hijo->pu_incluye_igv=0;
                            $osalida_Detalle_Hijo->pu_incluye_isc=0;
                            $osalida_Detalle_Hijo->descuento_porcentaje=0;
                            $osalida_Detalle_Hijo->isc_porcentaje=0;
                            $osalida_Detalle_Hijo->isc_valor_referencial=0;
                            $osalida_Detalle_Hijo->isc_activo=0;
                            $osalida_Detalle_Hijo->valor_venta_soles=$item1['precio_venta_subtotal_soles'];
                            $osalida_Detalle_Hijo->valor_venta_dolares=$item1['precio_venta_subtotal_dolares'];
                            $osalida_Detalle_Hijo->visc_soles=0;
                            $osalida_Detalle_Hijo->visc_dolares=0;
                            $osalida_Detalle_Hijo->descuento_soles=0;
                            $osalida_Detalle_Hijo->descuento_dolares=0;
                            $osalida_Detalle_Hijo->descuento=0;
                            $osalida_Detalle_Hijo->valor_unitario=($osalida->moneda_ID=1)?$item['precio_venta_unitario_soles']:$item['precio_venta_unitario_dolares'];
                            $osalida_Detalle_Hijo->insertar_new();
                            $producto_ID1_old=$osalida_Detalle_Hijo->producto_ID;
                            actualizar_inventario($osalida_Detalle_Hijo,$producto_ID1_old,$_SESSION['usuario_ID'],$_SESSION['empresa_ID']);
                        }
                    }
                }
            }
            $osalida_Detalle->actualizar_costos_padre($osalida_Detalle->salida_ID,$_SESSION['usuario_ID']);
            //actualizamos el estado de la cotizacion a ganada
            $oCotizacion->estado_ID=25;
            $oCotizacion->usuario_mod_id=$_SESSION['usuario_ID'];
            $oCotizacion->actualizar();

           /*Enviamos informacion a la vista orden de compra*/
            $resultado=1;
            $mensaje="Se registró correctamente";
        }catch(Exception $ex){
            $resultado=-1;
            $mensaje=utf8_encode(mensaje_error);
            log_error(__FILE__,"salida/post_ajaxExtraerCotizacion",$ex->getMessage());
        }
        $salida_ID=$osalida->ID;
        $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje,'salida_ID'=>$salida_ID);
        echo json_encode($retornar);
    }
    function post_ajaxMostrarInformacion(){
        require ROOT_PATH.'models/cliente.php';
        require ROOT_PATH.'models/cliente_contacto.php';
        require ROOT_PATH.'models/forma_pago.php';
        require ROOT_PATH.'models/operador.php';
        require ROOT_PATH.'models/operador_cliente.php';
        require ROOT_PATH.'models/persona.php';
        require ROOT_PATH.'models/salida.php';
        require ROOT_PATH.'models/salida_detalle.php';
        require ROOT_PATH.'models/salida_numero_cuenta.php';
        $salida_ID=$_POST['id'];
        $numero_cuenta_IDs="";
        try{
            $osalida=salida::getByID($salida_ID);
            $cotizacion_ID=$osalida->cotizacion_ID;
            $oCliente=cliente::getByID($osalida->cliente_ID);
            $Razon_Social=  utf8_encode($oCliente->razon_social);
            $Ruc=$oCliente->ruc;
            $Telefono=$oCliente->telefono;
            $Direccion=utf8_encode($oCliente->direccion);
            $Tipo_Cambio=$osalida->tipo_cambio;
            $Tiempo_Credito=$osalida->tiempo_credito;
            $moneda_ID=$osalida->moneda_ID;
            $cliente_ID=$osalida->cliente_ID;

            $dtRepresentante=cliente_contacto::getGrid('cliente_ID='.$osalida->cliente_ID);
            $ListaRepresentate='';
            if($dtRepresentante != null){
                foreach($dtRepresentante as $irepresentante){
                    $ListaRepresentate.='<option value="'.$irepresentante['ID'].'">'.FormatTextView($irepresentante['apellido_paterno']).', '.FormatTextView($irepresentante['nombres']).'</option>';
                }
            }else{$ListaRepresentate="<option value='0'>--</option>";}
           // $forma_pago_ID=$oCliente->forma_pago_ID;

           // $oForma_pago=forma_pago::getByID($forma_pago_ID);
            $Forma_pago=$osalida->forma_pago_ID;

            $oOperador_Cliente=operador_cliente::getByOperador($osalida->cliente_ID);
            if($oOperador_Cliente!=null){
                $operador_ID=$oOperador_Cliente->operador_ID;
                $oOperador=operador::getByID($operador_ID);
                $oPersona_Operador=persona::getByID($oOperador->persona_ID);
                $operador=FormatTextView($oPersona_Operador->apellido_paterno.' '.$oPersona_Operador->apellido_materno.', '.$oPersona_Operador->nombres);

                $operador_telefono=$oOperador->telefono;
                $operador_celular=$oOperador->celular;
                $operador_correo=$oOperador->mail;
            }else{
                $operador_ID="";
                $operador="Vendedor no asignado";
                $operador_telefono="--";
                $operador_celular="--";
                $operador_correo="--";
            }

            $salida_ID=$osalida->ID;
            $Plazo_Entrega=$osalida->plazo_entrega;
            $Lugar_Entrega=utf8_encode($osalida->lugar_entrega);
            $Validez_Oferta=$osalida->validez_oferta;
            $Garantia=utf8_encode($osalida->garantia);
            $Observacion= utf8_encode($osalida->observacion);
            $Numero_Concatenado=$osalida->numero_concatenado;
            $dtsalida_Numero_Cuenta=salida_numero_cuenta::getGrid('salida_ID='.$osalida->ID);
            //print_r($dtsalida_Numero_Cuenta);
            $numero_cuenta_IDs='';
            $i=0;
            foreach($dtsalida_Numero_Cuenta as $valor){
                if($i==0){
                    $numero_cuenta_IDs=$valor['numero_cuenta_ID'];
                }else {
                    $numero_cuenta_IDs.=",".$valor['numero_cuenta_ID'];
                }

                $i++;
            }
            $resultado=1;
            $mensaje='';
        }catch(Exception $ex){
            log_error(__FILE__,"salida/post_ajaxMostrarInformacion",$ex->getMessage());
            $resultado=-1;
            $mensaje=mensaje_error;
            $cotizacion_ID='';
            $Telefono="";
            $Direccion="";
            $moneda_ID='';
            $operador_ID="";
            $cliente_ID="";
            $Forma_pago="";
            $Tiempo_Credito="";
            $ListaRepresentate="";
            $operador_ID="";
            $Ruc='';
            $Razon_Social='';
            $operador="Vendedor no asignado";
            $operador_direccion="--";
            $operador_telefono="--";
            $operador_celular="--";
            $operador_correo="--";
            $Plazo_Entrega="";
            $Lugar_Entrega="";
            $Validez_Oferta="";
            $Garantia="";
            $Observacion="";
            $Numero_Concatenado="";
            $salida_ID="";
            $numero_cuenta_IDs="";
            $Tipo_Cambio='';
        }
         $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje,'salida_ID'=>$salida_ID,'cotizacion_ID'=>$cotizacion_ID, 'cliente_ID'=>$cliente_ID,'Ruc'=>$Ruc,'Razon_Social'=>$Razon_Social,'Telefono'=>$Telefono,'Direccion'=>$Direccion,
                    'moneda_ID'=>$moneda_ID,'Forma_pago'=>$Forma_pago,'Tiempo_Credito'=>$Tiempo_Credito,'mensaje'=>$mensaje,'lista_representante'=>$ListaRepresentate,'operador_ID'=>$operador_ID,'operador'=>$operador,
                    'operador_telefono'=>$operador_telefono,'operador_celular'=>$operador_celular,
                    'operador_correo'=>$operador_correo,'Plazo_Entrega'=>$Plazo_Entrega,'Lugar_Entrega'=>$Lugar_Entrega,'Validez_Oferta'=>$Validez_Oferta,
                    'Garantia'=>$Garantia,'Observacion'=>$Observacion,'Numero_Concatenado'=>$Numero_Concatenado,'salida_ID'=>$salida_ID,'numero_cuenta_IDs'=>$numero_cuenta_IDs,'Tipo_Cambio'=>$Tipo_Cambio);
        echo json_encode($retornar);
    }

    function post_ajaxTerminarImpresion(){
        require ROOT_PATH.'models/salida.php';
        $salida_ID=$_POST['id'];
        try{
            $osalida=salida::getByID($salida_ID);
            $osalida->impresion=0;
            $osalida->usuario_mod_id=$_SESSION['usuario_ID'];
            $osalida->actualizarImpresion(0);
            $resultado=1;
            $mensaje="Se liberó la impresora correctamente.";
        }catch(Exception $ex){
            $resultado=-1;
            $mensaje=$ex->getMessage();;
        }
        $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);
        echo json_encode($retornar);
    }
    function IngresarIventario($osalida_Detalle){
        //$filtro='producto_ID='.$osalida_Detalle->producto_ID.' and estado_ID=48';
        $filtro='producto_ID='.$osalida_Detalle->producto_ID.' and estado_ID=48';
        if($osalida_Detalle->cotizacion_detalle_ID!="NULL"){
            $filtro='cotizacion_detalle_ID='. $osalida_Detalle->cotizacion_detalle_ID .' or (producto_ID='.$osalida_Detalle->producto_ID.' and estado_ID=48)';
        }
        $dtInventario=inventario::getGrid($filtro,-1,-1,'ID asc');
        $stock=count($dtInventario);
        if($stock>0){
           $arrayStock=array();
           foreach ($dtInventario as $value1) {
               array_push($arrayStock,$value1['ID']);

           }
        }
        /*Actualizamos los valores en la tabla inventario */
        $cantidad=0;
        if($osalida_Detalle->salida_detalle_ID==0){
            $cantidad=$osalida_Detalle->cantidad;
        }else {
            $salida_detalle_padre=salida_detalle::getByID($osalida_Detalle->salida_detalle_ID);
            $cantidad=$osalida_Detalle->cantidad*$salida_detalle_padre->cantidad;

        }
       for ($i=0; $i<$cantidad; $i++) {

           if(isset($arrayStock[$i])){
               $oInventario=inventario::getByID($arrayStock[$i]);
               $oInventario->estado_ID=49;
               $oInventario->salida_detalle_ID=$osalida_Detalle->ID;
                //if(!isset($oInventario->compra_detalle_ID)){
                //        $oInventario->compra_detalle_ID='NULL';
                //}
                if(!isset($oInventario->cotizacion_detalle_ID)){
                    $oInventario->cotizacion_detalle_ID='NULL';
                }else {
                    $oInventario->cotizacion_detalle_ID=$salida_detalle->cotizacion_detalle_ID;
                }
               actualizarInventario($oInventario);
               $oInventario->usuario_mod_id=$_SESSION['usuario_ID'];
               $oInventario->actualizar();
           }else {
               $oInventario=new inventario();
               $oInventario->producto_ID=$osalida_Detalle->producto_ID;
               $oInventario->ingreso_detalle_ID="NULL";
               $oInventario->salida_detalle_ID=$osalida_Detalle->ID;
               $oInventario->descripcion=$osalida_Detalle->descripcion;
               $oInventario->estado_ID=50;
               $oInventario->utilidad_soles=0;
               $oInventario->utilidad_dolares=0;
               $oInventario->comision_soles=0;
               $oInventario->comision_dolares=0;
               $oInventario->serie="NULL";
               $oInventario->cotizacion_detalle_ID=$osalida_Detalle->cotizacion_detalle_ID;
               $oInventario->usuario_id=$_SESSION['usuario_ID'];
               $oInventario->insertar();
           }

       }
    }
    function post_ajaxVentas_Mantenimiento_Productos($id){
        require ROOT_PATH.'models/salida.php';
        require ROOT_PATH.'models/salida_detalle.php';
        require ROOT_PATH.'models/producto.php';
        require ROOT_PATH.'models/moneda.php';
        $salida_ID=$id;

        //$cotizacion_detalle_ID=$_POST['txtcotizacion_detalle_ID'];

        //---------------------------------------
        $osalida=salida::getByID($id);
        $oMoneda=moneda::getByID($osalida->moneda_ID);
        $resultado='<table class="grid" style="font-size:11px;" width="1050px"><tr>';
        $resultado.='<th style="width:110px;" ></th>';
        $resultado.='<th style="width:30px;">ITEM </th>';
        $resultado.='<th style="width:500px;">PRODUCTO </th>';
        $resultado.='<th style="width:40px;">CANT.</th>';
        $resultado.='<th style="width:80px;">PRECIO UNT '.$oMoneda->simbolo.' </th>';
        $resultado.='<th style="width:80px;">PRECIO TOTAL '.$oMoneda->simbolo.' </th>';

        $resultado.='</tr>';


        try {
            $dtsalida_Detalle=salida_detalle::getGrid('salida_ID='.$salida_ID . ' and salida_Detalle_ID=0 and obsequio=0');
            $rows=count($dtsalida_Detalle);
            $i=1;
            $visualizar="";
            if($osalida->estado_ID==42){
                $visualizar="style='display:none;'";
            }
            foreach($dtsalida_Detalle as $item)
            {

                $oProducto=producto::getByID($item['producto_ID']);
                if($osalida->moneda_ID==1){
                    $costo_venta_unitario_padre=$item['precio_venta_unitario_soles'];
                    $precio_venta_subtotal_padre=$item['precio_venta_subtotal_soles'];
                }else {
                    $costo_venta_unitario_padre=$item['precio_venta_unitario_dolares'];
                    $precio_venta_subtotal_padre=$item['precio_venta_subtotal_dolares'];
                }


                    $resultado.='<tr class="tr-item">';
                    $resultado.='<td class="btnAction"><a '.$visualizar.' onclick="fncComponente('.$item['ID'].');"><img title="Agregar Componente" src="/include/img/boton/add_16x16.png"></img></a>';
                    $resultado.='<a '.$visualizar.' onclick="fncEditar('.$item['ID'].');"><img title="Editar" src="/include/img/boton/edit_16x16.png"></img></a>';
                    $resultado.='<a '.$visualizar.' onclick="fncEliminar('.$item['ID'].');"><img title="Eliminar" src="/include/img/boton/delete_16x16.png"></img></a></td>';
                    $resultado.='<td class="tdCenter">'.$i.'</td>';
                    $resultado.='<td class="tdLeft">'.FormatTextViewHtml($oProducto->nombre);
                    $dtsalida_Detalle_Hijo=salida_detalle::getGrid('salida_ID='.$salida_ID.' and salida_detalle_ID='.$item['ID'].' and obsequio=0' );
                    $contar= count($dtsalida_Detalle_Hijo);
                     if($contar>0){

                             $resultado.='<div class="DivHijos">';
                             $resultado.='<table><tr><th>Componente</th><th>Cantidad</th><th>Precio Unit.</th><th>Sub Total.</th></th><th class="tdCenter">Ver Precio</th><th colspan="2">Opciones</th></tr>';


                                foreach ($dtsalida_Detalle_Hijo as $value) {
                                    $resultado.='<tr>';
                                   $oProductoHijo=producto::getByID($value['producto_ID']);
                                   $resultado.='<td>'.FormatTextViewHtml($oProductoHijo->nombre).'</td>';
                                   $resultado.='<td class="tdCenter">'.FormatTextViewHtml($value['cantidad']).'</td>';

                                     if($osalida->moneda_ID==1){
                                        $costo_venta_unitario=$value['precio_venta_unitario_soles'];
                                        $precio_venta_subtotal=$value['precio_venta_subtotal_soles'];
                                    }else {
                                        $costo_venta_unitario=$value['precio_venta_unitario_dolares'];
                                        $precio_venta_subtotal=$value['precio_venta_subtotal_dolares'];
                                    }
                                     $resultado.='<td class="tdCenter">'.FormatTextViewHtml(number_format($costo_venta_unitario,2,".",",")).'</td>';
                                     $resultado.='<td class="tdCenter">'.formatTextViewHtml(number_format($precio_venta_subtotal,2,".",",")).'</td>';
                                    $ojito='';
                                   if($value['ver_precio']==1){
                                      $ojito='checked';

                                    }
                                    $resultado.='<td class="tdCenter"><input type="checkbox" disabled '.$ojito.' ></td>';
                                    $resultado.='<td><a '.$visualizar.' onclick="fncEditarComponente('.$value['ID'].');"><img title="Editar" width="12px" src="/include/img/boton/edit_16x16.png"></img></a></td>';
                                    $resultado.='<td><a '.$visualizar.' onclick="fncEliminarComponente('.$value['ID'].');"><img title="Eliminar" width="12px" src="/include/img/boton/delete_16x16.png"></img></a></td></tr>';


                                }


                            $resultado.="</table></div>";

                        }
                    $resultado.=  '</td>';
                    $resultado.='<td class="tdCenter">'.FormatTextViewHtml($item['cantidad']).'</td>';
                    $resultado.='<td class="tdRight" style="padding-right:8px;">'.FormatTextViewHtml(number_format($costo_venta_unitario_padre,2,".",",")).'</td>';
                    $resultado.='<td class="tdRight" style="padding-right:8px;">'.FormatTextViewHtml(number_format($precio_venta_subtotal_padre,2,".",",")).'</td>';
                    $resultado.='</tr>';
                    $i++;


            }

                if($osalida->moneda_ID==1){
                    $vigv_t=$osalida->vigv_soles;
                    $precio_venta_neto_t=$osalida->precio_venta_neto_soles;
                    $precio_venta_total_t=$osalida->precio_venta_total_soles;

                }else {
                   $vigv_t=$osalida->vigv_dolares;
                    $precio_venta_neto_t=$osalida->precio_venta_neto_dolares;
                    $precio_venta_total_t=$osalida->precio_venta_total_dolares;
                }
                $resultado.='<tr style="border-bottom:hidden;border-left:hidden;"><td colspan="5" style="text-align:right;font-weight: bold; padding:1px 8px; border:none;">PRECIO VENTA '.$oMoneda->simbolo.'</td><td style="padding:1px 8px;" class="tdRight">'.FormatTextViewHtml(number_format($precio_venta_neto_t,2,".",",")).'</td>';
                $resultado.='<tr style="border-bottom:hidden;border-left:hidden;"><td colspan="5" style="text-align:right;font-weight: bold; padding:1px 8px; border:none;">IGV'.$osalida->igv*100 .'%</td><td style="padding:1px 8px;" class="tdRight">'.FormatTextViewHtml(number_format($vigv_t,2,".",",")).'</td>';
                $resultado.='<tr style="border-bottom:hidden;border-left:hidden;"><td colspan="5" style="text-align:right;font-weight: bold; padding:1px 8px; border:none;">PRECIO TOTAL '.$oMoneda->simbolo.'</td><td style="padding:1px 8px;" class="tdRight">'.number_format($precio_venta_total_t,2,".",",").'</td>';


               }catch(Exception $ex){
                $resultado.='<tr ><td colspan="5">'.$ex->getMessage().'</td></tr>';
        }

        $resultado.='</table>';

        $mensaje='';
        $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);
        //$retorn="<h1>Hola</h1>";

        echo json_encode($retornar);
    }
    function post_ajaxVentas_Mantenimiento_ProductosObsequios($id){
        require ROOT_PATH.'models/salida.php';
        require ROOT_PATH.'models/salida_detalle.php';
        require ROOT_PATH.'models/producto.php';
        require ROOT_PATH.'models/moneda.php';
        $salida_ID=$id;

        //$cotizacion_detalle_ID=$_POST['txtcotizacion_detalle_ID'];

        //---------------------------------------
        $osalida=salida::getByID($id);
        $oMoneda=moneda::getByID($osalida->moneda_ID);
        $resultado='<table class="grid" style="font-size:11px;"><tr>';
        $resultado.='<th style="width:100px;" ></th>';
        $resultado.='<th style="width:30px;">ITEM </th>';
        $resultado.='<th style="width:500px;">PRODUCTO </th>';
        $resultado.='<th style="width:40px;">CANT.</th>';
        //$resultado.='<th style="width:80px;">PRECIO UNT '.$oMoneda->simbolo.' </th>';
        //$resultado.='<th style="width:80px;">PRECIO TOTAL '.$oMoneda->simbolo.' </th>';

        $resultado.='</tr>';


        try {
            $dtsalida_Detalle=salida_detalle::getGrid('salida_ID='.$salida_ID . ' and salida_Detalle_ID=0 and obsequio=1');
            $rows=count($dtsalida_Detalle);
            $i=1;
            $visualizar="";
            if($osalida->estado_ID==42){
                $visualizar="style='display:none;'";
            }
            foreach($dtsalida_Detalle as $item)
            {

                $oProducto=producto::getByID($item['producto_ID']);
                if($osalida->moneda_ID==1){
                    $costo_venta_unitario_padre=$item['precio_venta_unitario_soles'];
                    $precio_venta_subtotal_padre=$item['precio_venta_subtotal_soles'];
                }else {
                    $costo_venta_unitario_padre=$item['precio_venta_unitario_dolares'];
                    $precio_venta_subtotal_padre=$item['precio_venta_subtotal_dolares'];
                }


                    $resultado.='<tr class="tr-item">';
                    $resultado.='<td class="btnAction">';
                    //$resultado.='<td class="btnAction"><a '.$visualizar.' onclick="fncComponente('.$item['ID'].');"><img title="Agregar Componente" src="/include/img/boton/add_16x16.png"></img>&nbsp;Componente</a>';
                    $resultado.='<a '.$visualizar.' onclick="fncEditarObsequios('.$item['ID'].');"><img title="Editar" src="/include/img/boton/edit_16x16.png"></img>&nbsp;Editar</a>';
                    $resultado.='<a '.$visualizar.' onclick="fncEliminarObsequios('.$item['ID'].');"><img title="Eliminar" src="/include/img/boton/delete_16x16.png"></img>&nbsp;Eliminar</a></td>';
                    $resultado.='<td class="tdCenter">'.$i.'</td>';
                    $resultado.='<td class="tdLeft">'.FormatTextViewHtml($oProducto->nombre);
                    $resultado.=  '</td>';
                    $resultado.='<td class="tdCenter">'.FormatTextViewHtml($item['cantidad']).'</td>';
                    //$resultado.='<td class="tdRight" style="padding-right:8px;">'.FormatTextViewHtml(number_format($costo_venta_unitario_padre,2,".",",")).'</td>';
                    //$resultado.='<td class="tdRight" style="padding-right:8px;">'.FormatTextViewHtml(number_format($precio_venta_subtotal_padre,2,".",",")).'</td>';
                    $resultado.='</tr>';
                    $i++;


            }

               /* if($osalida->moneda_ID==1){
                    $vigv_t=$osalida->vigv_soles;
                    $precio_venta_neto_t=$osalida->precio_venta_neto_soles;
                    $precio_venta_total_t=$osalida->precio_venta_total_soles;

                }else {
                   $vigv_t=$osalida->vigv_dolares;
                    $precio_venta_neto_t=$osalida->precio_venta_neto_dolares;
                    $precio_venta_total_t=$osalida->precio_venta_total_dolares;
                }
                $resultado.='<tr style="border-bottom:hidden;border-left:hidden;"><td colspan="5" style="text-align:right;font-weight: bold; padding:1px 8px; border:none;">PRECIO VENTA '.$oMoneda->simbolo.'</td><td style="padding:1px 8px;" class="tdRight">'.FormatTextViewHtml(number_format($precio_venta_neto_t,2,".",",")).'</td>';
                $resultado.='<tr style="border-bottom:hidden;border-left:hidden;"><td colspan="5" style="text-align:right;font-weight: bold; padding:1px 8px; border:none;">IGV'.$osalida->igv*100 .'%</td><td style="padding:1px 8px;" class="tdRight">'.FormatTextViewHtml(number_format($vigv_t,2,".",",")).'</td>';
                $resultado.='<tr style="border-bottom:hidden;border-left:hidden;"><td colspan="5" style="text-align:right;font-weight: bold; padding:1px 8px; border:none;">PRECIO TOTAL '.$oMoneda->simbolo.'</td><td style="padding:1px 8px;" class="tdRight">'.number_format($precio_venta_total_t,2,".",",").'</td>';

*/
               }catch(Exception $ex){
                $resultado.='<tr ><td colspan="5">'.$ex->getMessage().'</td></tr>';
        }

        $resultado.='</table>';

        $mensaje='';
        $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);
        //$retorn="<h1>Hola</h1>";

        echo json_encode($retornar);
    }
    function get_Orden_Venta_Mantenimiento_Producto_Nuevo($id){
        require ROOT_PATH . 'models/categoria.php';
        require ROOT_PATH . 'models/linea.php';
        require ROOT_PATH . 'models/producto.php';
        require ROOT_PATH . 'models/cotizacion.php';
        require ROOT_PATH . 'models/salida_detalle.php';
        require ROOT_PATH . 'models/inventario.php';
        require ROOT_PATH.'models/salida.php';
        require ROOT_PATH.'models/impuestos_tipo.php';
        require ROOT_PATH.'models/tipo_sistema_calculo_isc.php';
        global  $returnView_float;
        $returnView_float=true;
        $osalida=salida::getByID($id);
        $dtCategoria=categoria::getOption(0,$_SESSION['empresa_ID']);
        $dtLinea=linea::getOption($_SESSION['empresa_ID']);
        //$dtProducto=producto::getListaProducto(0,0);
        $dtImpuestos_Tipo=impuestos_tipo::getGrid();
        $osalida_Detalle=new salida_detalle();
        $osalida_Detalle->producto_ID=0;
        $osalida_Detalle->producto="";
        $osalida_Detalle->ID=0;
        $oInventario=new inventario(0);
        $oInventario->stock=0;
        $osalida_Detalle->tipo_ID=1;
        $osalida_Detalle->adicional=0;
        $osalida_Detalle->componente=0;
        $osalida_Detalle->tipo_precio_venta_unitario_ID=0;
        $osalida_Detalle->impuestos_tipo_ID=1;
        $osalida_Detalle->cantidad="";
        $osalida_Detalle->precio_venta_unitario_dolares="";
        $osalida_Detalle->precio_venta_unitario_soles="";
        $OP_tipo_sistema_calculo_isc=tipo_sistema_calculo_isc::getOpciones();
        $GLOBALS['dtImpuestos_Tipo']=$dtImpuestos_Tipo;
        $GLOBALS['OP_tipo_sistema_calculo_isc']=$OP_tipo_sistema_calculo_isc;
        $GLOBALS['dtCategoria']=$dtCategoria;
        $GLOBALS['categoria_ID']=0;
        $GLOBALS['dtLinea']=$dtLinea;
        $GLOBALS['linea_ID']=0;
        //$GLOBALS['dtProducto']=$dtProducto;
        $GLOBALS['oOrden_Venta']=$osalida;
        $GLOBALS['oOrden_Venta_Detalle']=$osalida_Detalle;
        $GLOBALS['oProducto']=new producto();
        $GLOBALS['oInventario']=$oInventario;
    }

    function post_Orden_Venta_Mantenimiento_Producto_Nuevo($id){
        require ROOT_PATH . 'models/categoria.php';
        require ROOT_PATH . 'models/linea.php';
        require ROOT_PATH . 'models/producto.php';
        require ROOT_PATH . 'models/salida_detalle.php';
        require ROOT_PATH . 'models/salida.php';
        require ROOT_PATH . 'models/operador.php';
        require ROOT_PATH . 'models/inventario.php';
        require ROOT_PATH . 'models/ingreso.php';
        require ROOT_PATH . 'models/ingreso_detalle.php';
        require ROOT_PATH . 'controls/funcionController.php';
        require ROOT_PATH.'models/impuestos_tipo.php';
        global  $returnView_float;
        $returnView_float=true;
        $salida_detalle_ID=$_POST['txtID'];
        $componente=0;
        if(isset($_POST['ckComponente'])){
            $componente=$_POST['ckComponente'];
        }
        $adicional=0;
        if(isset($_POST['ckAdicional'])){
            $adicional=$_POST['ckAdicional'];
        }
        $tipo_ID=retornar_tipo($componente,$adicional);
        $producto_ID=$_POST['selProducto'];
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
        $impuestos_tipo_ID=$_POST['selImpuestos_Tipo'];
        $tipo_precio_venta_unitario_ID=1;
        $peso=($_POST['txtPeso']=="")?0:$_POST['txtPeso'];
        $pu_incluye_isc=isset($_POST["ckPUIncluyeIsc"])?1:0;
        $pu_incluye_igv=isset($_POST["ckIncluyeIgv"])?1:0;
        $descuento_porcentaje=($_POST['txtPorcentaje_Descuento']=="")?0:$_POST['txtPorcentaje_Descuento'];
        $descuento_unitario=($_POST['txtUnit_Descuento']=="")?0:$_POST['txtUnit_Descuento'];
        $descuento=($_POST['txtTotal_Descuento']=="")?0:$_POST['txtTotal_Descuento'];
        $isc_activo=isset($_POST["ckIncluyeISC"])?1:0;
        if ($isc_activo==1){
            $tipo_sistema_calculo_isc_ID=isset($_POST["selTipoISC"])?$_POST["selTipoISC"]:'NULL';
        }else{
           $tipo_sistema_calculo_isc_ID="NULL"; 
        }
        
        $isc_porcentaje=(trim($_POST["txtPorcentajeISC"])=="")? 0 : $_POST["txtPorcentajeISC"];
        $isc_valor_referencial=(trim($_POST["txtIscValor_Calculo"])=="")? 0 : $_POST["txtIscValor_Calculo"];
        $visc_soles=($_POST['txtIscSoles']=="")?0:$_POST['txtIscSoles'];
        $visc_dolares=($_POST['txtIscDolares']=="")?0:$_POST['txtIscDolares'];
        $valor_venta_soles=($_POST['txtValorVentaSoles']=="")?0:$_POST['txtValorVentaSoles'];
        $valor_venta_dolares=($_POST['txtValorVentaDolares']=="")?0:$_POST['txtValorVentaDolares'];
        $descuento_soles=($_POST['txtDescuentoSoles']=="")?0:$_POST['txtDescuentoSoles'];        
        $descuento_dolares=($_POST['txtDescuentoDolares']=="")?0:$_POST['txtDescuentoDolares'];  
        $valor_unitario=$_POST['valor_unitario'];
        try{
            $osalida=salida::getByID($id);
            if($salida_detalle_ID==0){
                $osalida_Detalle=new salida_detalle();
                $producto_ID_old=$producto_ID;
            }else {
               $osalida_Detalle=salida_detalle::getByID($salida_detalle_ID);
               $producto_ID_old=$osalida_Detalle->producto_ID;
            }

            $osalida_Detalle->producto_ID=$producto_ID;
            $osalida_Detalle->salida_ID=$id;
            $osalida_Detalle->descripcion=$descripcion;
            $osalida_Detalle->cantidad=$cantidad;
            $osalida_Detalle->precio_venta_unitario_soles=$PrecioUnitarioSoles;
            $osalida_Detalle->precio_venta_unitario_dolares=$PrecioUnitarioDolares;
            $osalida_Detalle->precio_venta_subtotal_soles=$SubTotalSoles;
            $osalida_Detalle->precio_venta_subtotal_dolares=$SubTotalDolares;
            $osalida_Detalle->igv=$Igv;
            $osalida_Detalle->vigv_soles=$IgvSoles;
            $osalida_Detalle->vigv_dolares=$IgvDolares;
            $osalida_Detalle->precio_venta_soles=$TotalSoles;
            $osalida_Detalle->precio_venta_dolares=$TotalDolares;
            $osalida_Detalle->salida_detalle_ID=0;
            //generamos la orden de venta detalle con estado registrado
            $osalida_Detalle->estado_ID=33;
            $osalida_Detalle->cotizacion_detalle_ID='NULL';
            $osalida_Detalle->tipo_ID=$tipo_ID;
            $osalida_Detalle->ver_precio=1;
            $osalida_Detalle->impuestos_tipo_ID=$impuestos_tipo_ID;
            $osalida_Detalle->tipo_precio_venta_unitario_ID=$tipo_precio_venta_unitario_ID;
            $osalida_Detalle->peso=$peso;
            $osalida_Detalle->tipo_sistema_calculo_isc_ID=$tipo_sistema_calculo_isc_ID;
            $osalida_Detalle->descuento_unitario=$descuento_unitario;
            $osalida_Detalle->pu_incluye_igv=$pu_incluye_igv;
            $osalida_Detalle->pu_incluye_isc=$pu_incluye_isc;
            $osalida_Detalle->descuento_porcentaje=$descuento_porcentaje;
            $osalida_Detalle->isc_porcentaje=$isc_porcentaje;
            $osalida_Detalle->isc_valor_referencial=$isc_valor_referencial;
            $osalida_Detalle->isc_activo=$isc_activo;
            $osalida_Detalle->valor_venta_soles=$valor_venta_soles;
            $osalida_Detalle->valor_venta_dolares=$valor_venta_dolares;
            $osalida_Detalle->visc_soles=$visc_soles;
            $osalida_Detalle->visc_dolares=$visc_dolares;
            $osalida_Detalle->descuento_soles=$descuento_soles;
            $osalida_Detalle->descuento_dolares=$descuento_dolares;
            $osalida_Detalle->descuento=$descuento;
            $osalida_Detalle->valor_unitario=$valor_unitario;
            //$osalida_Detalle->obsequio=0;

            if($salida_detalle_ID==0){
                $osalida_Detalle->usuario_id=$_SESSION['usuario_ID'];
                $osalida_Detalle->insertar_new();
            }else{

                $osalida_Detalle->usuario_mod_id=$_SESSION['usuario_ID'];

                $osalida_Detalle->actualizar_new();
            }
            $retorna=inventario::actualizar_inventario($osalida_Detalle->ID,$producto_ID_old,$_SESSION['usuario_ID'],$_SESSION['empresa_ID']);
            //actualizar_inventario($osalida_Detalle,$producto_ID_old);
            /*Actualizamos los costos en la tabla orden de venta */
            $osalida_Detalle->actualizar_costos_padre($osalida_Detalle->salida_ID,$_SESSION['usuario_ID']);
            //actualizar_costos_padre($osalida_Detalle);

            $resultado=1;
            $mensaje="Se guardó correctamente";

        }catch(Exception $ex){
          $resultado=-1;
          $mensaje=$ex->getMessage();
        }
        $dtImpuestos_Tipo=impuestos_tipo::getGrid();
        $osalida_Detalle->stock=inventario::getStock($producto_ID);
        $oProducto=producto::getByID($producto_ID);
        $osalida_Detalle->oProducto=$oProducto;
        $oCategoria=categoria::getByID($oProducto->categoria_ID);
        $oLinea=linea::getByID($oCategoria->linea_ID);
        $dtCategoria=categoria::getGrid();
        $dtLinea=linea::getGrid();
        $dtProducto=producto::getGrid("",-1,-1,"pr.nombre asc");
        $osalida_Detalle->producto=$oProducto->nombre;
        $osalida_Detalle->adicional=$adicional;
        $osalida_Detalle->componente=$componente;
        $GLOBALS['dtImpuestos_Tipo']=$dtImpuestos_Tipo;
        $GLOBALS['dtCategoria']=$dtCategoria;
        $GLOBALS['categoria_ID']=$oCategoria->ID;
        $GLOBALS['dtLinea']=$dtLinea;
        $GLOBALS['linea_ID']=$oLinea->ID;

        $GLOBALS['dtProducto']=$dtProducto;
        $GLOBALS['oOrden_Venta']=$osalida;
        $GLOBALS['oOrden_Venta_Detalle']=$osalida_Detalle;
        $GLOBALS['resultado']=$resultado;
        $GLOBALS['mensaje']=$mensaje;
    }
    
    function actualizar_costos_padre($osalida_Detalle){
        if(!class_exists('salida_detalle')){
            require ROOT_PATH . 'models/salida_detalle.php';
        }
        if(!class_exists('salida')){
            require ROOT_PATH . 'models/salida.php';
        }
        try{
           
            
            $dtsalida_Detalle=salida_detalle::getGrid('salida_ID='.$osalida_Detalle->salida_ID.' and salida_detalle_ID=0 and tipo_ID in (1,2,5,6)');
            $precio_venta_neto_soles=0;
            $precio_venta_neto_dolares=0;
            $anticipos=0;
            $exoneradas=0;
            $inafectas=0;
            $gravadas=0;
            $gratuitas=0;
            
            foreach($dtsalida_Detalle as $item){
                switch($osalida_Detalle->impuestos_tipo_ID){
                    case 1:
                        $precio_venta_neto_soles=$precio_venta_neto_soles+$item['precio_venta_subtotal_soles'];
                        $precio_venta_neto_dolares=$precio_venta_neto_dolares+$item['precio_venta_subtotal_dolares'];
                        //$gravadas=$gravadas+$item['gravadas'];
                        break;

                }
                
            }
            $osalida=salida::getByID($osalida_Detalle->salida_ID);
            $osalida->precio_venta_neto_soles=number_format($precio_venta_neto_soles,2,'.','');
            $osalida->precio_venta_neto_dolares=number_format($precio_venta_neto_dolares,2,'.','');
            $osalida->vigv_soles=  number_format($precio_venta_neto_soles*$osalida->igv,2,'.','');
            $osalida->vigv_dolares=number_format($precio_venta_neto_dolares*$osalida->igv,2,'.','');
            $osalida->precio_venta_total_soles=number_format($precio_venta_neto_soles*(1+$osalida->igv),2,'.','');
            $osalida->precio_venta_total_dolares=number_format($precio_venta_neto_dolares*(1+$osalida->igv),2,'.','');
            $osalida->usuario_mod_id=$_SESSION['usuario_ID'];
            $osalida->actualizar();
        }catch(Exception $ex){

        }
    }
    function actualizar_inventario($osalida_Detalle,$producto_ID_old){
        if(!class_exists('inventario')){
           require ROOT_PATH.'models/inventario.php';
        }
        if(!class_exists('salida')){
           require ROOT_PATH.'models/salida.php';
        }
        if(!class_exists('salida_detalle')){
           require ROOT_PATH.'models/salida_detalle.php';
        }
        try{
            $limpiar=0;
            //no separamos productos con componente internos
            if($osalida_Detalle->tipo_ID==2||$osalida_Detalle->tipo_ID==5){

                $limpiar=1;
                //Actualizamos todos los hijos

            }
            //Eliminamos cantidades separadas
            if($producto_ID_old!=$osalida_Detalle->producto_ID|| $limpiar==1){
                $dtInventario=inventario::getGrid('salida_detalle_ID='.$osalida_Detalle->ID,-1,-1);

                foreach($dtInventario as $item){
                    $oInventario=inventario::getByID($item['ID']);
                    if($item['compra_detalle_ID']=='NULL'){
                        //Si no tiene una compra, se elimina el registro
                         $oInventario->eliminar();

                    }else {
                        //Actualizamos y liberamos el inventario, ponemos para stock
                        $oInventario->usuario_mod_id=$_SESSION['usuario_ID'];
                        $oInventario->salida_detalle_ID='NULL';
                        $oInventario->estado_ID=48;
                        $oInventario->actualizar();
                        actualizarInventarioCostos($oInventario);
                    }
                }

            }
            if($limpiar==0){
                $cantidad_anterior=inventario::getCount('salida_detalle_ID='.$osalida_Detalle->ID);
                if($cantidad_anterior==0){
                    /*Extraemos los productos en stock*/

                    $dtInventario_existencia=inventario::getGrid('producto_ID='.$osalida_Detalle->producto_ID.' and estado_ID=48',-1,-1,'ID asc');
                    $stock=inventario::getCount('producto_ID='.$osalida_Detalle->producto_ID.' and estado_ID=48');
                    if($stock>0){
                       $arrayStock=array();
                       foreach ($dtInventario_existencia as $value1) {
                           array_push($arrayStock,$value1['ID']);

                       }
                    }
                    //verificamos si es un componente
                    $cantidad=$osalida_Detalle->cantidad;
                    if($osalida_Detalle->tipo_ID==3){
                        $osalida_Detalle_Padre=salida_detalle::getByID($osalida_Detalle->salida_detalle_ID);
                        $cantidad=$osalida_Detalle->cantidad*$osalida_Detalle_Padre->cantidad;
                    }
                    //===============================
                    for($i=0;$i<$cantidad;$i++){
                        if(isset($arrayStock[$i])){
                            $oInventario=inventario::getByID($arrayStock[$i]);
                            $oInventario->estado_ID=49;
                            $oInventario->descripcion=$osalida_Detalle->descripcion;
                            $oInventario->salida_detalle_ID=$osalida_Detalle->ID;
                            $oInventario->usuario_mod_id=$_SESSION['usuario_ID'];
                            //$oInventario->utilidad_soles=85;

                            $oInventario->actualizar();
                            actualizarInventarioCostos($oInventario);

                        }else {
                            $oInventario=new inventario();
                            $oInventario->producto_ID=$osalida_Detalle->producto_ID;
                            $oInventario->ingreso_detalle_ID="NULL";
                            $oInventario->salida_detalle_ID=$osalida_Detalle->ID;
                            $oInventario->descripcion=$osalida_Detalle->descripcion;
                            $oInventario->estado_ID=50;
                            $oInventario->utilidad_soles=0;
                            $oInventario->utilidad_dolares=0;
                            $oInventario->comision_soles=0;
                            $oInventario->comision_dolares=0;
                            $oInventario->serie="";
                            $oInventario->cotizacion_detalle_ID="NULL";
                            $oInventario->usuario_id=$_SESSION['usuario_ID'];
                            $oInventario->insertar();
                        }

                    }

                }else {
                    //actualizamos los costos de la tabla inventario
                    //==================================================
                    $dtInventario_Actual=inventario::getGrid('salida_detalle_ID='.$osalida_Detalle->ID,-1,-1);
                    foreach($dtInventario_Actual as $valor){
                        $oInventario_actual=inventario::getByID($valor['ID']);
                        actualizarInventarioCostos($oInventario_actual);
                    }
                    //====================================================
                     //verificamos si es un componente
                    $cantidad=$osalida_Detalle->cantidad;
                    if($osalida_Detalle->tipo_ID==3){
                        $osalida_Detalle_Padre=salida_detalle::getByID($osalida_Detalle->salida_detalle_ID);
                        $cantidad=$osalida_Detalle->cantidad*$osalida_Detalle_Padre->cantidad;
                    }
                    //===============================
                    $exedente=$cantidad-$cantidad_anterior;
                    if($exedente>0){

                        $stock=inventario::getCount('producto_ID='.$osalida_Detalle->producto_ID.' and estado_ID=48');
                        if($stock>0){
                            $dtInventario_existencia=inventario::getGrid('producto_ID='.$osalida_Detalle->producto_ID.' and estado_ID=48',-1,-1,'ID asc');
                            $arrayStock=array();
                            foreach ($dtInventario_existencia as $value1) {
                                array_push($arrayStock,$value1['ID']);
                            }
                        }
                        for($a=0;$a<$exedente;$a++){
                            if(isset($arrayStock[$a])){
                                $oInventario=inventario::getByID($arrayStock[$a]);
                                $oInventario->estado_ID=49;
                                $oInventario->descripcion=$osalida_Detalle->descripcion;
                                $oInventario->salida_detalle_ID=$osalida_Detalle->ID;
                                $oInventario->usuario_mod_id=$_SESSION['usuario_ID'];
                                $oInventario->actualizar();
                                actualizarInventarioCostos($oInventario);
                            }else {
                                $oInventario=new inventario();
                                $oInventario->producto_ID=$osalida_Detalle->producto_ID;
                                $oInventario->ingreso_detalle_ID="NULL";
                                $oInventario->salida_detalle_ID=$osalida_Detalle->ID;
                                $oInventario->descripcion=$osalida_Detalle->descripcion;
                                $oInventario->estado_ID=50;
                                $oInventario->utilidad_soles=0;
                                $oInventario->utilidad_dolares=0;
                                $oInventario->comision_soles=0;
                                $oInventario->comision_dolares=0;
                                $oInventario->serie="";
                                $oInventario->cotizacion_detalle_ID="NULL";
                                $oInventario->usuario_id=$_SESSION['usuario_ID'];
                                $oInventario->insertar();
                            }
                        }
                    }else if($exedente<0) {
                        $dtInventario_sobrantes=inventario::getGrid('salida_detalle_ID='.$osalida_Detalle->ID,0,abs($exedente),'ID desc');
                        foreach($dtInventario_sobrantes as $value){
                            $oInventario=inventario::getByID($value['ID']);
                            if($value['compra_detalle_ID']=='NULL'){
                                //Si no tiene una compra, se elimina el registro
                                 $oInventario->eliminar();

                            }else {
                                //Actualizamos y liberamos el inventario, ponemos para stock
                                $oInventario->usuario_mod_id=$_SESSION['usuario_ID'];
                                $oInventario->salida_detalle_ID='NULL';
                                $oInventario->estado_ID=48;
                                $oInventario->actualizar();
                                actualizarInventarioCostos($oInventario);
                            }
                        }

                    }
                }


            }

        }catch(Exception $ex){

        }
    }
    function actualizar_costo_orden_venta_detalle_padre($osalida_Detalle_Padre){
        if(!class_exists('salida_detalle')){
            require ROOT_PATH . 'models/salida_detalle.php';
        }
         if(!class_exists('salida')){
            require ROOT_PATH . 'models/salida.php';
        }
        $osalida_Detalle=$osalida_Detalle_Padre;
        try{

        //$PrecioUnitarioSoles1=$oCotizacion_Detalle->precio_venta_unitario_soles;
        //$PrecioUnitarioDolares1=$oCotizacion_Detalle->precio_venta_unitario_dolares;
            $oSalida=salida::getByID($osalida_Detalle->salida_ID);
        $dtsalida_Detalle_Hijos=salida_detalle::getGrid('salida_detalle_ID='.$osalida_Detalle->ID.' and tipo_ID in (3,4)',-1,-1);
        $adicional_soles=0;
        $adicional_dolares=0;
        $precio_venta_subtotal_soles_hijo=0;
        $precio_venta_subtotal_dolares_hijo=0;
        
        $suma_valor_unitario=0;
        
        
        foreach($dtsalida_Detalle_Hijos as $value){
            switch($value['tipo_ID']){
                case 3://componente
                    $precio_venta_subtotal_soles_hijo=$precio_venta_subtotal_soles_hijo+$value['precio_venta_subtotal_soles'];
                    $precio_venta_subtotal_dolares_hijo=$precio_venta_subtotal_dolares_hijo+$value['precio_venta_subtotal_dolares'];
                    $suma_valor_unitario=$suma_valor_unitario+($value['valor_unitario']*$value['cantidad']*$osalida_Detalle->cantidad);
                    break;
                case 4://adicional
                    $adicional_soles=$adicional_soles+$value['precio_venta_subtotal_soles'];
                    $adicional_dolares=$adicional_dolares+$value['precio_venta_subtotal_dolares'];
                    $suma_valor_unitario=$suma_valor_unitario+($value['valor_unitario']*$value['cantidad']);
                    break;
            }
            
        }
        $precio_venta_unitario_soles=0;
        $precio_venta_unitario_dolares=0;
        $precio_venta_subtotal_soles=0;
        $precio_venta_subtotal_dolares=0;
        $valor_unitario=0;
       
        switch($osalida_Detalle->tipo_ID){
            case 2://Producto con componente
                $precio_venta_unitario_soles=$precio_venta_subtotal_soles_hijo;
                $precio_venta_unitario_dolares=$precio_venta_subtotal_dolares_hijo;
                $precio_venta_subtotal_soles=$precio_venta_unitario_soles*$osalida_Detalle->cantidad;
                $precio_venta_subtotal_dolares=$precio_venta_unitario_dolares*$osalida_Detalle->cantidad;
                $valor_unitario=round($suma_valor_unitario/$osalida_Detalle->cantidad,2);
                break;
            case 5://producto con componente y adicional

                $precio_venta_subtotal_soles=$adicional_soles+$precio_venta_subtotal_soles_hijo*$osalida_Detalle->cantidad;
                $precio_venta_subtotal_dolares=$adicional_dolares+$precio_venta_subtotal_dolares_hijo*$osalida_Detalle->cantidad;
                $precio_venta_unitario_soles=$precio_venta_subtotal_soles/$osalida_Detalle->cantidad;
                $precio_venta_unitario_dolares=$precio_venta_subtotal_dolares/$osalida_Detalle->cantidad;
                $valor_unitario=round($suma_valor_unitario/$osalida_Detalle->cantidad,2);
                    
                break;
            case 6://producto con adicional

                $precio_venta_unitario_soles=$adicional_soles/$osalida_Detalle->cantidad+$osalida_Detalle->precio_venta_unitario_soles;
                $precio_venta_unitario_dolares=$adicional_dolares/$osalida_Detalle->cantidad+$osalida_Detalle->precio_venta_unitario_dolares;
                $precio_venta_subtotal_soles=$precio_venta_unitario_soles*$osalida_Detalle->cantidad;
                $precio_venta_subtotal_dolares=$precio_venta_unitario_dolares*$osalida_Detalle->cantidad;
                $valor_unitario=round($suma_valor_unitario/$osalida_Detalle->cantidad,2);
                break;
        }
        $valor_venta_soles=0;
        $valor_venta_dolares=0;
        if($osalida_Detalle->tipo_ID!=1){//verificamos que no sea un producto
            $precio_venta_unitario_soles1=0;
            $precio_venta_unitario_dolares1=0;
            $osalida_Detalle->valor_unitario=$valor_unitario;
            if($oSalida->moneda_ID==1){
                $precio_venta_subtotal_soles1=$valor_unitario*$osalida_Detalle->cantidad;
                $precio_venta_subtotal_dolares1=round($precio_venta_subtotal_soles1/$oSalida->tipo_cambio,2);
                
                $precio_venta_unitario_soles1=$valor_unitario*(1+$osalida_Detalle->igv);
                $precio_venta_unitario_dolares1=round($precio_venta_unitario_soles1/$oSalida->tipo_cambio,2);
            
            
            }else{
                $precio_venta_subtotal_dolares1=$valor_unitario*$osalida_Detalle->cantidad;
                
                $precio_venta_subtotal_soles1=round($precio_venta_subtotal_dolares1*$oSalida->tipo_cambio,2);
                
                
                $precio_venta_unitario_dolares1=$valor_unitario*(1+$osalida_Detalle->igv);
                $precio_venta_unitario_soles1=round($precio_venta_unitario_dolares1*$oSalida->tipo_cambio,2);
            }
            
            $osalida_Detalle->precio_venta_unitario_soles=$precio_venta_unitario_soles1;
            $osalida_Detalle->precio_venta_unitario_dolares=$precio_venta_unitario_dolares1;
            $osalida_Detalle->precio_venta_subtotal_soles=$precio_venta_subtotal_soles1;
            $osalida_Detalle->precio_venta_subtotal_dolares=$precio_venta_subtotal_dolares1;
            $osalida_Detalle->descuento_soles=round($precio_venta_subtotal_soles1*$osalida_Detalle->descuento_porcentaje/100,2);
            $osalida_Detalle->descuento_dolares=round($precio_venta_subtotal_dolares1*$osalida_Detalle->descuento_porcentaje/100,2);
            $valor_venta_soles=$osalida_Detalle->precio_venta_subtotal_soles-$osalida_Detalle->descuento_soles;
            $valor_venta_dolares=$osalida_Detalle->precio_venta_subtotal_dolares-$osalida_Detalle->descuento_dolares;
            $osalida_Detalle->valor_venta_dolares=$valor_venta_dolares;
            $osalida_Detalle->valor_venta_soles=$valor_venta_soles;
            
            $osalida_Detalle->precio_venta_soles=round($osalida_Detalle->valor_venta_soles*(1+$osalida_Detalle->igv),2);
            $osalida_Detalle->precio_venta_dolares=round($osalida_Detalle->valor_venta_dolares*(1+$osalida_Detalle->igv),2);
            $osalida_Detalle->vigv_soles=round($osalida_Detalle->valor_venta_soles*($osalida_Detalle->igv),2);
            $osalida_Detalle->vigv_dolares=round($osalida_Detalle->valor_venta_dolares*($osalida_Detalle->igv),2);
            $osalida_Detalle->pu_incluye_igv=1;
           
        }
        $osalida_Detalle->usuario_mod_id=$_SESSION['usuario_ID'];
        $osalida_Detalle->actualizar_new();
        /*switch($osalida_Detalle->tipo_ID){
            case 2://Producto con componente

                $osalida_Detalle->adicional_soles='';
                $osalida_Detalle->adicional_dolares='';
                $osalida_Detalle->subtotal_soles1='';
                $osalida_Detalle->subtotal_dolares1='';
                break;
            case 5://producto con componente y adicional
                $osalida_Detalle->precio_venta_unitario_soles=$precio_venta_subtotal_soles_hijo;
                $osalida_Detalle->precio_venta_unitario_dolares=$precio_venta_subtotal_dolares_hijo;
                $osalida_Detalle->adicional_soles=$adicional_soles;
                $osalida_Detalle->adicional_dolares=$adicional_dolares;
                $osalida_Detalle->subtotal_soles1=$osalida_Detalle->precio_venta_subtotal_soles;
                $osalida_Detalle->subtotal_dolares1=$osalida_Detalle->precio_venta_subtotal_dolares;
                $osalida_Detalle->precio_venta_subtotal_soles=$precio_venta_subtotal_soles_hijo*$osalida_Detalle->cantidad;
                $osalida_Detalle->precio_venta_subtotal_dolares=$precio_venta_subtotal_dolares_hijo*$osalida_Detalle->cantidad;
                break;
            case 6://producto con adicional
                $osalida_Detalle->precio_venta_unitario_soles=($osalida_Detalle->precio_venta_subtotal_soles-$adicional_soles)/$osalida_Detalle->cantidad;
                $osalida_Detalle->precio_venta_unitario_dolares=($osalida_Detalle->precio_venta_subtotal_dolares-$adicional_dolares)/$osalida_Detalle->cantidad;
                $osalida_Detalle->adicional_soles=$adicional_soles;
                $osalida_Detalle->adicional_dolares=$adicional_dolares;
                $osalida_Detalle->subtotal_soles1=$osalida_Detalle->precio_venta_subtotal_soles;
                $osalida_Detalle->subtotal_dolares1=$osalida_Detalle->precio_venta_subtotal_dolares;
                $osalida_Detalle->precio_venta_subtotal_soles=$osalida_Detalle->precio_venta_subtotal_soles-$adicional_soles;
                $osalida_Detalle->precio_venta_subtotal_dolares=$osalida_Detalle->precio_venta_subtotal_dolares-$adicional_dolares;
                break;
        }*/

        }catch (Exception $ex){

            log_error(__FILE__,"salida/actualizar_costo_orden_venta_detalle_padre", $ex->getMessage());
        }

        return $osalida_Detalle;
    }
    function actualizarInventarioCostos($oInventario){
        if(!class_exists('inventario')){
            require ROOT_PATH . 'models/inventario.php';
        }
        if(!class_exists('operador')){
            require ROOT_PATH . 'models/operador.php';
        }
        if(!class_exists('salida')){
            require ROOT_PATH . 'models/salida.php';
        }
        if(!class_exists('ingreso_detalle')){
            require ROOT_PATH . 'models/ingreso_detalle.php';
        }
        if(!class_exists('ingreso')){
            require ROOT_PATH . 'models/ingreso.php';
        }
        //require ROOT_PATH . 'models/inventario.php';
        //
        try{
            if($oInventario->ingreso_detalle_ID!='NULL'){
            $oCompra_Detalle=ingreso_detalle::getByID($oInventario->ingreso_detalle_ID);
            $oCompra=ingreso::getByID($oCompra_Detalle->ingreso_ID);
            if($oInventario->estado_ID==49){
                $precio_compra_soles=0;
                $precio_compra_dolares=0;
                if($oCompra->moneda_ID==1){
                    $precio_compra_soles=number_format($oCompra_Detalle->precio,2,'.','');
                    //number_format($costo_venta_unitario,2,".",",");
                    $precio_compra_dolares=number_format($precio_compra_soles/$oCompra->tipo_cambio,2,'.','');
                }else {
                    $precio_compra_dolares=number_format($oCompra_Detalle->precio,2,'.','');
                    $precio_compra_soles=number_format($precio_compra_dolares*$oCompra->tipo_cambio,2);
                }
                $osalida_Detalle=salida_detalle::getByID($oInventario->salida_detalle_ID);

                $osalida=salida::getByID($osalida_Detalle->salida_ID);
                $oOperador=operador::getByID($osalida->operador_ID);
                $precio_venta_soles=$osalida_Detalle->precio_venta_unitario_soles;
                $precio_venta_dolares=$osalida_Detalle->precio_venta_unitario_dolares;

                if($osalida->moneda_ID==1){
                    //si la venta esta realizada en soles, se guarda la comision en soles
                    $oInventario->utilidad_soles=$precio_venta_soles-$precio_compra_soles;
                    $oInventario->comision_soles=($oInventario->utilidad_soles*$oOperador->comision/100);
                    $oInventario->utilidad_dolares=0;
                    $oInventario->comision_dolares=0;

                }else{
                    $oInventario->utilidad_dolares=$precio_venta_dolares-$precio_compra_dolares;
                    $oInventario->comision_dolares=($oInventario->utilidad_dolares*$oOperador->comision/100);
                    $oInventario->utilidad_soles=0;
                    $oInventario->comision_soles=0;
                }

            }else {
                $oInventario->utilidad_soles=0;
                $oInventario->utilidad_dolares=0;
                $oInventario->comision_soles=0;
                $oInventario->comision_dolares=0;
            }

                $oInventario->usuario_mod_id=$_SESSION['usuario_ID'];
                $oInventario->actualizar();
            }

        }catch(Exception $exs){

        }



    }
    function get_Orden_Venta_Mantenimiento_Obsequio_Nuevo($id){
        require ROOT_PATH . 'models/categoria.php';
        require ROOT_PATH . 'models/linea.php';
        require ROOT_PATH . 'models/producto.php';
        require ROOT_PATH . 'models/cotizacion.php';
        require ROOT_PATH . 'models/salida_detalle.php';
        require ROOT_PATH . 'models/inventario.php';
        require ROOT_PATH.'models/salida.php';
        global  $returnView_float;
        $returnView_float=true;
        $osalida=salida::getByID($id);
        $dtCategoria=categoria::getGrid('',-1,-1,"ca.nombre asc");
        $dtLinea=linea::getGrid('',-1,-1,"li.nombre asc");
        // $dtProducto=producto::getGrid('',-1,-1,"pr.nombre asc");
        $osalida=salida::getByID($id);
        $osalida_Detalle=new salida_detalle();
        $osalida_Detalle->producto_ID=0;
        $osalida_Detalle->ID=0;
        $osalida_Detalle->categoria_ID=0;
        $osalida_Detalle->linea_ID=0;
        $osalida_Detalle->producto_ID=0;
        $osalida_Detalle->stock=0;
        $osalida_Detalle->cantidad="";
        $oInventario=new inventario();
        $GLOBALS['dtCategoria']=$dtCategoria;
        $GLOBALS['categoria_ID']=0;
        $GLOBALS['dtLinea']=$dtLinea;
        $GLOBALS['linea_ID']=0;
        //$GLOBALS['dtProducto']=$dtProducto;
        $GLOBALS['oOrden_Venta']=$osalida;
        $GLOBALS['oInventario']=$oInventario;
        $GLOBALS['oOrden_Venta_Detalle']=$osalida_Detalle;



    }
    function post_Orden_Venta_Mantenimiento_Obsequio_Nuevo($id){
        require ROOT_PATH . 'models/categoria.php';
        require ROOT_PATH . 'models/linea.php';
        require ROOT_PATH . 'models/producto.php';
        require ROOT_PATH . 'models/salida_detalle.php';
        require ROOT_PATH . 'models/salida.php';
       require ROOT_PATH . 'models/inventario.php';
        global  $returnView_float;

        $returnView_float=true;
         $tipo_ID=7;

        $producto_ID=$_POST['selProducto'];
        $descripcion=FormatTextSave(trim($_POST['txtDescripcion']));
        $cantidad=$_POST['txtCantidad'];
        $PrecioUnitarioSoles=0;
        $PrecioUnitarioDolares=0;
        $SubTotalSoles=0;
        $SubTotalDolares=0;
        $Igv=0;
        $IgvSoles=0;
        $IgvDolares=0;
        $TotalSoles=0;
        $TotalDolares=0;
        try{
            $osalida=salida::getByID($id);
            $osalida_Detalle=new salida_detalle();
            $osalida_Detalle->producto_ID=$producto_ID;
            $osalida_Detalle->salida_ID=$id;
            $osalida_Detalle->descripcion=$descripcion;
            $osalida_Detalle->cantidad=$cantidad;
            $osalida_Detalle->precio_venta_unitario_soles=$PrecioUnitarioSoles;
            $osalida_Detalle->precio_venta_unitario_dolares=$PrecioUnitarioDolares;
            $osalida_Detalle->precio_venta_subtotal_soles=$SubTotalSoles;
            $osalida_Detalle->precio_venta_subtotal_dolares=$SubTotalDolares;
            $osalida_Detalle->igv=$Igv;
            $osalida_Detalle->vigv_soles=$IgvSoles;
            $osalida_Detalle->vigv_dolares=$IgvDolares;
            $osalida_Detalle->precio_venta_soles=$TotalSoles;
            $osalida_Detalle->precio_venta_dolares=$TotalDolares;
            $osalida_Detalle->salida_detalle_ID=0;
            $osalida_Detalle->estado_ID=33;
            $osalida_Detalle->cotizacion_detalle_ID='NULL';
            $osalida_Detalle->ver_precio=0;
            $osalida_Detalle->obsequio=1;
            $osalida_Detalle->tipo_ID=$tipo_ID;
            $osalida_Detalle->isc=0;
            $osalida_Detalle->otro_impuesto=0;
            $osalida_Detalle->descuento=0;
            $osalida_Detalle->precio_referencial=0;
            $osalida_Detalle->tipo_precio_venta_unitario_ID=1;
            $osalida_Detalle->impuestos_tipo_ID=1;
            $osalida_Detalle->usuario_id=$_SESSION['usuario_ID'];
            $osalida_Detalle->insertar_new();
            $producto_ID_old=$producto_ID;
            $retorna=inventario::actualizar_inventario($osalida_Detalle->ID,$producto_ID_old,$_SESSION['usuario_ID'],$_SESSION['empresa_ID']);
            //actualizar_inventario($osalida_Detalle,$producto_ID_old);

            $resultado=1;
            $mensaje="Se guardó correctamente";

        }catch(Exception $ex){
          $resultado=-1;
          $mensaje=$ex->getMessage();
        }
        $osalida_Detalle->stock=inventario::getStock($producto_ID);
        $oProducto=producto::getByID($producto_ID);
        $oCategoria=categoria::getByID($oProducto->categoria_ID);
        $oLinea=linea::getByID($oCategoria->linea_ID);
        $dtCategoria=categoria::getGrid('',-1,-1,'ca.nombre');
        $dtLinea=linea::getGrid('',-1,-1,'li.nombre');
       
        $osalida_Detalle->categoria_ID=$oProducto->categoria_ID;
        $osalida_Detalle->linea_ID=$oCategoria->linea_ID;
        //$oInventario->stock=$stock;
        $GLOBALS['dtCategoria']=$dtCategoria;
        $GLOBALS['categoria_ID']=$oCategoria->ID;
        $GLOBALS['dtLinea']=$dtLinea;
        $GLOBALS['linea_ID']=$oLinea->ID;
        

        $GLOBALS['oOrden_Venta']=$osalida;
        $GLOBALS['oOrden_Venta_Detalle']=$osalida_Detalle;
        $GLOBALS['resultado']=$resultado;
        $GLOBALS['mensaje']=$mensaje;
    }

    function get_Orden_Venta_Mantenimiento_Producto_Editar($id){
        require ROOT_PATH . 'models/categoria.php';
        require ROOT_PATH . 'models/linea.php';
        require ROOT_PATH . 'models/producto.php';
        require ROOT_PATH . 'models/salida.php';
        require ROOT_PATH . 'models/factura_venta.php';
        require ROOT_PATH . 'models/salida_detalle.php';
        require ROOT_PATH . 'models/inventario.php';
        require ROOT_PATH . 'controls/funcionController.php';
        require ROOT_PATH . 'models/impuestos_tipo.php';
        require ROOT_PATH . 'models/tipo_sistema_calculo_isc.php';
        
        global  $returnView_float;

        $returnView_float=true;

        $osalida_Detalle=salida_detalle::getByID($id);
        
        $osalida=salida::getByID($osalida_Detalle->salida_ID);
        $bloque_edicion=0;
        $factura_realizadas=factura_venta::getCount('salida_ID='.$osalida_Detalle->salida_ID);
        if($factura_realizadas>0){
            $bloque_edicion=1;
            
        }
        
        if($osalida->estado_ID==40||$osalida->estado_ID==42){
            
            $bloque_edicion=1;
        }
        
        //$osalida_Detalle=llenarValores($osalida_Detalle);
        //print_r($osalida_Detalle);
        $dtsalida_Detalle_Hijo=salida_detalle::getGrid('salida_detalle_ID='.$id);
        $contar=count($dtsalida_Detalle_Hijo);
        
        
        $array=retornar_valores($osalida_Detalle->tipo_ID);
        $osalida_Detalle->componente=$array['componente'];
        $osalida_Detalle->adicional=$array['adicional'];
        $oInventario=new inventario();
        $stock=inventario::getStock($osalida_Detalle->producto_ID);
        $osalida_Detalle->stock=$stock;
       // $dtProducto=producto::getGrid();
        $oProducto=producto::getByID($osalida_Detalle->producto_ID);
        $osalida_Detalle->oProducto=$oProducto;
        $dtCategoria=categoria::getGrid();
        $oCategoria=categoria::getByID($oProducto->categoria_ID);
        $dtLinea=linea::getGrid();
        $oLinea=linea::getByID($oCategoria->linea_ID);
        $dtImpuestos_Tipo=impuestos_tipo::getGrid();
        $osalida_Detalle->bloquear_edicion=$bloque_edicion;
        $OP_tipo_sistema_calculo_isc=tipo_sistema_calculo_isc::getOpciones();
        
        $GLOBALS['OP_tipo_sistema_calculo_isc']=$OP_tipo_sistema_calculo_isc;
        $GLOBALS['dtImpuestos_Tipo']=$dtImpuestos_Tipo;
        $GLOBALS['totalHijo']=$contar;
        $GLOBALS['dtCategoria']=$dtCategoria;
        $GLOBALS['categoria_ID']=$oCategoria->ID;
        $GLOBALS['dtLinea']=$dtLinea;
        $GLOBALS['linea_ID']=$oLinea->ID;
        //$GLOBALS['dtProducto']=$dtProducto;
        $GLOBALS['oOrden_Venta_Detalle']=$osalida_Detalle;
        $GLOBALS['oOrden_Venta']=$osalida;
        $GLOBALS['oInventario']=$oInventario;
    }
    function post_Orden_Venta_Mantenimiento_Producto_Editar($id){
        require ROOT_PATH . 'models/categoria.php';
        require ROOT_PATH . 'models/linea.php';
        require ROOT_PATH . 'models/producto.php';
        require ROOT_PATH . 'models/operador.php';
        require ROOT_PATH . 'models/salida_detalle.php';
        require ROOT_PATH . 'models/salida.php';
        require ROOT_PATH . 'models/inventario.php';
        require ROOT_PATH . 'controls/funcionController.php';
        require ROOT_PATH . 'models/impuestos_tipo.php';
        global  $returnView_float;
        $returnView_float=true;
        $producto_ID=$_POST['selProducto'];
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
        $impuestos_tipo_ID=$_POST['selImpuestos_Tipo'];
        $tipo_precio_venta_unitario_ID=1;
        $peso=($_POST['txtPeso']=="")?0:$_POST['txtPeso'];
        $pu_incluye_isc=isset($_POST["ckPUIncluyeIsc"])?1:0;
        $pu_incluye_igv=isset($_POST["ckIncluyeIgv"])?1:0;
        $descuento_porcentaje=($_POST['txtPorcentaje_Descuento']=="")?0:$_POST['txtPorcentaje_Descuento'];
        $descuento_unitario=($_POST['txtUnit_Descuento']=="")?0:$_POST['txtUnit_Descuento'];
        $descuento=($_POST['txtTotal_Descuento']=="")?0:$_POST['txtTotal_Descuento'];
        $isc_activo=isset($_POST["ckIncluyeISC"])?1:0;
        if ($isc_activo==1){
            $tipo_sistema_calculo_isc_ID=isset($_POST["selTipoISC"])?$_POST["selTipoISC"]:'NULL';
        }else{
           $tipo_sistema_calculo_isc_ID="NULL"; 
        }
        
        $isc_porcentaje=(trim($_POST["txtPorcentajeISC"])=="")? 0 : $_POST["txtPorcentajeISC"];
        $isc_valor_referencial=(trim($_POST["txtIscValor_Calculo"])=="")? 0 : $_POST["txtIscValor_Calculo"];
        $visc_soles=($_POST['txtIscSoles']=="")?0:$_POST['txtIscSoles'];
        $visc_dolares=($_POST['txtIscDolares']=="")?0:$_POST['txtIscDolares'];
        $valor_venta_soles=($_POST['txtValorVentaSoles']=="")?0:$_POST['txtValorVentaSoles'];
        $valor_venta_dolares=($_POST['txtValorVentaDolares']=="")?0:$_POST['txtValorVentaDolares'];
        $descuento_soles=($_POST['txtDescuentoSoles']=="")?0:$_POST['txtDescuentoSoles'];        
        $descuento_dolares=($_POST['txtDescuentoDolares']=="")?0:$_POST['txtDescuentoDolares'];
        $valor_unitario=$_POST['valor_unitario'];
        $componente=0;
        if(isset($_POST['ckComponente'])){
            $componente=$_POST['ckComponente'];
        }
        $adicional=0;
        if(isset($_POST['ckAdicional'])){
            $adicional=$_POST['ckAdicional'];
        }
        $tipo_ID=retornar_tipo($componente,$adicional);
        try{
            $osalida_Detalle=salida_detalle::getByID($id);
            $producto_ID_old=$osalida_Detalle->producto_ID;
            $osalida_Detalle->producto_ID=$producto_ID;
            $osalida_Detalle->descripcion=$descripcion;
            $osalida_Detalle->cantidad=$cantidad;
            $osalida_Detalle->salida_detalle_ID=0;
            $osalida_Detalle->ver_precio=1;
            $osalida_Detalle->usuario_mod_id=$_SESSION['usuario_ID'];
            $osalida_Detalle->tipo=$tipo_ID;
            $osalida_Detalle->tipo_ID=$tipo_ID;
            $osalida_Detalle->tipo_precio_venta_unitario_ID=$tipo_precio_venta_unitario_ID;
            $osalida_Detalle->impuestos_tipo_ID=$impuestos_tipo_ID;
            $osalida_Detalle->descuento=$descuento;
            $osalida_Detalle->peso=$peso;
            $osalida_Detalle->tipo_sistema_calculo_isc_ID=$tipo_sistema_calculo_isc_ID;
            $osalida_Detalle->descuento_unitario=$descuento_unitario;
            $osalida_Detalle->pu_incluye_igv=$pu_incluye_igv;
            $osalida_Detalle->pu_incluye_isc=$pu_incluye_isc;
            $osalida_Detalle->descuento_porcentaje=$descuento_porcentaje;
            $osalida_Detalle->isc_porcentaje=$isc_porcentaje;
            $osalida_Detalle->isc_valor_referencial=$isc_valor_referencial;
            $osalida_Detalle->isc_activo=$isc_activo;
            $osalida_Detalle->valor_venta_soles=$valor_venta_soles;
            $osalida_Detalle->valor_venta_dolares=$valor_venta_dolares;
            $osalida_Detalle->visc_soles=$visc_soles;
            $osalida_Detalle->visc_dolares=$visc_dolares;
            $osalida_Detalle->descuento_soles=$descuento_soles;
            $osalida_Detalle->descuento_dolares=$descuento_dolares;
            

            $osalida_Detalle->precio_venta_unitario_soles=$PrecioUnitarioSoles;
            $osalida_Detalle->precio_venta_unitario_dolares=$PrecioUnitarioDolares;
            $osalida_Detalle->precio_venta_subtotal_soles=$SubTotalSoles;
            $osalida_Detalle->precio_venta_subtotal_dolares=$SubTotalDolares;
            $osalida_Detalle->igv=$Igv;
            $osalida_Detalle->vigv_soles=$IgvSoles;
            $osalida_Detalle->vigv_dolares=$IgvDolares;
            $osalida_Detalle->precio_venta_soles=$TotalSoles;
            $osalida_Detalle->precio_venta_dolares=$TotalDolares;
            $osalida_Detalle->valor_unitario=$valor_unitario;
            $osalida_Detalle->actualizar_new();
            
            
            
           actualizar_costo_orden_venta_detalle_padre($osalida_Detalle);
            if($tipo_ID==2||$tipo_ID==5){
                //Actualizamos a los hijos
                $dtsalida_Detalle_Hijos=salida_detalle::getGrid('salida_detalle_ID='.$osalida_Detalle->ID.' and tipo_ID=3',-1,-1,'ID asc');
                foreach($dtsalida_Detalle_Hijos as $hijos){
                    $osalida_Detalle_Hijos=salida_detalle::getByID($hijos['ID']);
                    $producto_ID_old1=$osalida_Detalle_Hijos->producto_ID;
                    //$retorna=inventario::actualizar_inventario($hijos['ID'],$producto_ID_old1,$_SESSION['usuario_ID'],$_SESSION['empresa_ID']);
                     $retorna=inventario::actualizar_inventario($hijos['ID'],$producto_ID_old1,$_SESSION['usuario_ID'],$_SESSION['empresa_ID']);
                }

            }else {
                $retorna=inventario::actualizar_inventario($osalida_Detalle->ID,$producto_ID_old,$_SESSION['usuario_ID'],$_SESSION['empresa_ID']);
                //actualizar_inventario($osalida_Detalle,$producto_ID_old);
            }
            
            $osalida_Detalle->actualizar_costos_padre($osalida_Detalle->salida_ID,$_SESSION['usuario_ID']);
            //actualizar_costos_padre($osalida_Detalle);
            $resultado=1;
            $mensaje="Se guardó correctamente";

        }catch(Exception $ex){
          $resultado=-1;
          $mensaje=utf8_encode(mensaje_error);
          log_error(__FILE__, "salidaController.post_Orden_Venta_Mantenimiento_Producto_Editar", $ex->getMessage());
        }
        $osalida_Detalle->stock=inventario::getStock($osalida_Detalle->producto_ID);
        
        $oProducto=producto::getByID($osalida_Detalle->producto_ID);
        $dtCategoria=categoria::getGrid();
        $oCategoria=categoria::getByID($oProducto->categoria_ID);
        $dtLinea=linea::getGrid();
        $oLinea=linea::getByID($oCategoria->linea_ID);
        $osalida=salida::getByID($osalida_Detalle->salida_ID);
        $oInventario=new inventario();
        $stock=$oInventario->getStock($producto_ID);
        $oProducto=producto::getByID($osalida_Detalle->producto_ID);
        $osalida_Detalle->oProducto=$oProducto;
        $osalida_Detalle->stock=$stock;
        $array=retornar_valores($osalida_Detalle->tipo_ID);
        $osalida_Detalle->componente=$array['componente'];
        $osalida_Detalle->adicional=$array['adicional'];
        $osalida_Detalle=llenarValores($osalida_Detalle);
        $dtImpuestos_Tipo=impuestos_tipo::getGrid();
        $GLOBALS['dtImpuestos_Tipo']=$dtImpuestos_Tipo;
        $GLOBALS['dtCategoria']=$dtCategoria;
        $GLOBALS['categoria_ID']=$oCategoria->ID;
        $GLOBALS['dtLinea']=$dtLinea;
        $GLOBALS['linea_ID']=$oLinea->ID;
 

        $GLOBALS['oInventario']=$oInventario;
        $GLOBALS['oOrden_Venta']=$osalida;
        $GLOBALS['oOrden_Venta_Detalle']=$osalida_Detalle;
        $GLOBALS['resultado']=$resultado;
        $GLOBALS['mensaje']=$mensaje;
    }

    function get_Orden_Venta_Mantenimiento_Obsequio_Editar($id){
        require ROOT_PATH . 'models/categoria.php';
        require ROOT_PATH . 'models/linea.php';
        require ROOT_PATH . 'models/producto.php';
        require ROOT_PATH . 'models/salida.php';
        require ROOT_PATH . 'models/salida_detalle.php';
        require ROOT_PATH . 'models/inventario.php';
        global  $returnView_float;

        global  $returnView_float;

        $returnView_float=true;
        $dtCategoria=categoria::getGrid('',-1,-1,"ca.nombre asc");

        $dtLinea=linea::getGrid('',-1,-1,"li.nombre asc");
        $dtProducto=producto::getGrid('',-1,-1,"pr.nombre asc");
        $osalida_Detalle=salida_detalle::getByID($id);
        $oProducto=producto::getByID($osalida_Detalle->producto_ID);
        $osalida=salida::getByID($osalida_Detalle->salida_ID);
        $osalida_Detalle->oProducto=$oProducto;
        $oInventario=new inventario();
        $stock=$oInventario->getStock($osalida_Detalle->producto_ID);
        $oInventario->stock=$stock;

        $GLOBALS['dtCategoria']=$dtCategoria;
        $GLOBALS['dtLinea']=$dtLinea;
        $GLOBALS['dtProducto']=$dtProducto;
        $GLOBALS['oOrden_Venta_Detalle']=$osalida_Detalle;
        $GLOBALS['osalida']=$osalida;
        $GLOBALS['oInventario']=$oInventario;
    }
    function post_Orden_Venta_Mantenimiento_Obsequio_Editar($id){
        require ROOT_PATH . 'models/categoria.php';
        require ROOT_PATH . 'models/linea.php';
        require ROOT_PATH . 'models/producto.php';
        require ROOT_PATH . 'models/operador.php';
        require ROOT_PATH . 'models/salida_detalle.php';
        require ROOT_PATH . 'models/salida.php';
        require ROOT_PATH . 'models/inventario.php';
        require ROOT_PATH . 'models/ingreso.php';
        require ROOT_PATH . 'models/ingreso_detalle.php';
        global  $returnView_float;
        $returnView_float=true;
        $tipo=7;
        $producto_ID=$_POST['selProducto'];
        $descripcion=FormatTextSave(trim($_POST['txtDescripcion']));
        $cantidad=$_POST['txtCantidad'];
        $PrecioUnitarioSoles=0;
        $PrecioUnitarioDolares=0;
        $SubTotalSoles=0;
        $SubTotalDolares=0;
        $Igv=0;
        $IgvSoles=0;
        $IgvDolares=0;
        $TotalSoles=0;
        $TotalDolares=0;
        try{

        $osalida_Detalle=salida_detalle::getByID($id);
        $producto_ID_old=$osalida_Detalle->producto_ID;
        $osalida_Detalle->producto_ID=$producto_ID;
        $osalida_Detalle->descripcion=$descripcion;
        $osalida_Detalle->cantidad=$cantidad;
        $osalida_Detalle->salida_detalle_ID=0;
        $osalida_Detalle->usuario_id=$_SESSION['usuario_ID'];
        $osalida_Detalle->actualizar_new();
        
        $retorna=inventario::actualizar_inventario($osalida_Detalle->ID,$producto_ID_old,$_SESSION['usuario_ID'],$_SESSION['empresa_ID']);
        //actualizar_inventario($osalida_Detalle,$producto_ID_old);
        $resultado=1;
        $mensaje=$osalida_Detalle->message;

        }catch(Exception $ex){
            log_error(__FILE__, "salidaController.post_Orden_Venta_Mantenimiento_Obsequio_Editar", $ex->getMessage());
          $resultado=-1;
          $mensaje="Ocurrió un error en el sistema.";
        }
        $dtCategoria=categoria::getGrid('',-1,-1,'ca.nombre');
        $dtLinea=linea::getGrid('',-1,-1,'li.nombre');
        
        $oInventario=new inventario();
        $oProducto=producto::getByID($producto_ID);
        $osalida_Detalle->oProducto=$oProducto;
        $oCategoria=categoria::getByID($oProducto->categoria_ID);
        $stock=$oInventario->getStock($producto_ID);

        $oInventario->stock=$stock;
        $osalida_Detalle->categoria_ID=$oProducto->categoria_ID;
        $osalida_Detalle->linea_ID=$oCategoria->linea_ID;

        $GLOBALS['dtCategoria']=$dtCategoria;
        $GLOBALS['dtLinea']=$dtLinea;
        
        $GLOBALS['oInventario']=$oInventario;

        $GLOBALS['oOrden_Venta_Detalle']=$osalida_Detalle;
        $GLOBALS['resultado']=$resultado;
        $GLOBALS['mensaje']=  $mensaje;
    }


    function post_ajaxRegistrarSeries(){
        require ROOT_PATH . 'models/inventario.php';

        $inventario_ID=$_POST['id'];
        $serie=$_POST['id1'];

        try{
           $cantidad_serie=0;

            $oInventario=inventario::getByID($inventario_ID);
            /*if($oInventario->cotizacion_detalle_ID=null){
                $oInventario->cotizacion_detalle_ID="NULL";
            }
            if(!isset($oInventario->compra_detalle_ID)){
                $oInventario->compra_detalle_ID="NULL";
            }
           */
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
    function post_ajaxSerie_Eliminar($id){
        require ROOT_PATH . 'models/inventario.php';

    try {
        $oInventario= inventario::getByID($id);
        $oInventario->usuario_mod_id = $_SESSION['usuario_ID'];
        if ($oInventario == null) {
            throw new Exception('Parece que el registro ya fue eliminado.');
        }
        /*if(!isset($oInventario->salida_detalle_ID)){
            $oInventario->salida_detalle_ID="NULL";
        }
        if(!isset($oInventario->compra_detalle_ID)){
            $oInventario->compra_detalle_ID="NULL";
        }
         if(!isset($oInventario->cotizacion_detalle_ID)){
            $oInventario->cotizacion_detalle_ID="NULL";
        }*/
        if($oInventario->estado_ID==50){
            $oInventario->serie='NULL';

            $oInventario->actualizar();
        }else if($oInventario->estado_ID==49){
            $oInventario->estado_ID=48;
            $oInventario->salida_detalle_ID='NULL';
            $oInventario->actualizar();
        }
        $resultado = 1;
        $mensaje = $oInventario->message;
        $funcion = '';
    } catch (Exception $ex) {
        $resultado = -1;
        $mensaje = $ex->getMessage();
        $funcion = '';
    }

    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje, 'funcion' => $funcion);

    echo json_encode($retornar);
    }
    function post_ajaxMostrar_Serie() {
    require ROOT_PATH . 'models/compra_detalle.php';
    require ROOT_PATH . 'models/compra.php';
    require ROOT_PATH . 'models/inventario.php';
    //$cantidadMaxima = compra_detalle::getCount($filtro);
        $salida_detalle_ID=$_POST['txtsalida_Detalle_ID'];
        $dtinventario = inventario::getGrid('salida_detalle_ID='.$salida_detalle_ID,-1,-1,'ID asc');
        $resultado = '<table class="grid" id="tbSeries"><tr>';
        $resultado.='<th style="width:80px;"></th>';
        $resultado.='<th style="width:50px;">Nro</th>';
        $resultado.='<th style="width:100px;" >Serie </th>';
        $resultado.='<th style="width:200px;" >Stock/Factura de compra </th>';

        $resultado.='</tr>';
        try {
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
            $resultado.='<td class="btnAction"><a  onclick="fncEliminar(' . $item['ID'] . ');"><img title="Eliminar"  src="/include/img/boton/delete_14x14.png" />&nbsp;Eliminar</a></td>';
            $resultado.='<td class="tdCenter">'.$i.'<input type="checkbox" '.$checked.' name="ck'.$item['ID'].'" value="'.$item['ID'].'"></td>';
            $resultado.='<td class="tdLeft">' . FormatTextViewHtml($serie) . '</td>';
            $numero_factura="";
            $numero_guia="";
            if(isset($item['compra_detalle_ID'])){
                $oCompra_Detalle=compra_detalle::getByID($item['compra_detalle_ID']);
                $oCompra=compra::getByID($oCompra_Detalle->ingreso_ID);
                $numero_factura=  FormatTextViewHtml($oCompra->serie." Nª".sprintf("%'.09d", $oCompra->numero));

                $resultado.='<td class="tdLeft">' . $numero_factura. '</td>';

            }else {
                 $resultado.='<td class="tdLeft" >para stock.</td>';
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
    function post_ajaxExtraerIGV() {
        require ROOT_PATH . 'models/impuestos_tipo.php';
        $moneda_ID=$_POST['moneda_ID'];
        $tipo_cambio=$_POST['tipo_cambio'];
        $impuesto_tipo_ID=$_POST['impuesto_tipo_ID'];
        $monto=$_POST['monto'];
        $igv=$_POST['igv'];
        $mensaje="";
        $resultado_soles=0;
        $resultado_dolares=0;
        try {
        
            $igv= impuestos_tipo::getImpuestoIGV($moneda_ID,$tipo_cambio,$impuesto_tipo_ID,$monto,$igv);
            if(count($igv)>0){
                $resultado_soles=$igv[0]['retornar_soles'];
                $resultado_dolares=$igv[0]['retornar_dolares'];
                $mensaje=utf8_encode($igv[0]['mensaje'])  ;
            }
            
        } catch (Exception $ex) {
            log_error(__FILE__,"salidaController.post_ajaxExtraerIGV",$ex->getMessage());
        }

       

        
        $retornar = Array('resultado_soles' => $resultado_soles,'resultado_dolares'=>$resultado_dolares, 'mensaje' => $mensaje);
        //$retorn="<h1>Hola</h1>";

        echo json_encode($retornar);

    }
   
    function get_Orden_Venta_Mantenimiento_Registro_Componente_Nuevo($id){
        require ROOT_PATH . 'models/categoria.php';
        require ROOT_PATH . 'models/linea.php';
        require ROOT_PATH . 'models/producto.php';
        require ROOT_PATH . 'models/salida.php';
        require ROOT_PATH . 'models/salida_detalle.php';
        require ROOT_PATH . 'models/inventario.php';
        require ROOT_PATH.'models/impuestos_tipo.php';
        global  $returnView_float;

        $returnView_float=true;
        $dtCategoria=categoria::getGrid('',-1,-1,'ca.nombre asc');
        $dtLinea=linea::getGrid('',-1,-1,'li.nombre asc');
        
        $osalida_Detalle_Padre=salida_detalle::getByID($id);
        $osalida=salida::getByID($osalida_Detalle_Padre->salida_ID);
        $osalida_Detalle= new salida_detalle();
        $osalida_Detalle->ID=0;
        
        $osalida_Detalle->linea_ID=0;
        $osalida_Detalle->dtLinea=$dtLinea;
        $osalida_Detalle->categoria_ID=0;
        $osalida_Detalle->dtCategoria=$dtCategoria;
        $dtImpuestos_Tipo=impuestos_tipo::getGrid();
        $osalida_Detalle->oSalida=$osalida;
        $osalida_Detalle->salida_detalle_padre_ID=$id;
        //$osalida_Detalle->verBotonTerminar=0;
        $osalida_Detalle->stock=0;
        $osalida_Detalle->impuestos_tipo_ID=$osalida_Detalle_Padre->impuestos_tipo_ID;
        $osalida_Detalle->cantidad="";
        $osalida_Detalle->precio_venta_unitario_dolares="";
        $osalida_Detalle->precio_venta_unitario_soles="";
        $osalida_Detalle->descuento_porcentaje=$osalida_Detalle_Padre->descuento_porcentaje;
        $GLOBALS['oOrden_Venta_Detalle']=$osalida_Detalle;
        $GLOBALS['oOrden_Venta']=$osalida;
        $GLOBALS['dtImpuestos_Tipo']=$dtImpuestos_Tipo;
        //$GLOBALS['oInventario']=$oInventario;
    }
    function post_Orden_Venta_Mantenimiento_Registro_Componente_Nuevo($id){
        require ROOT_PATH . 'models/categoria.php';
        require ROOT_PATH . 'models/linea.php';
        require ROOT_PATH . 'models/producto.php';
        require ROOT_PATH . 'models/salida_detalle.php';
        require ROOT_PATH . 'models/salida.php';
        require ROOT_PATH . 'models/operador.php';
        require ROOT_PATH . 'models/inventario.php';
        require ROOT_PATH . 'models/ingreso.php';
        require ROOT_PATH.'models/impuestos_tipo.php';
        require ROOT_PATH . 'models/ingreso_detalle.php';
        global  $returnView_float;
        $returnView_float=true;

        $producto_ID=$_POST['selProducto'];
        $descripcion=FormatTextSave($_POST['txtDescripcion']);
        $cantidad=$_POST['txtCantidad'];
        //$inventario_ID=$_POST['txtInventarioID1'];
        if(isset($_POST['cbVer_Precio'])){
             $ver_precio=$_POST['cbVer_Precio'];
        }else {$ver_precio=0;}
        $PrecioUnitarioSoles=$_POST['txtPrecioUnitarioSoles'];
        $PrecioUnitarioDolares=$_POST['txtPrecioUnitarioDolares'];
        $SubTotalSoles=$_POST['txtSubTotalSoles'];
        $SubTotalDolares=$_POST['txtSubTotalDolares'];
        $Igv=$_POST['txtValIgv'];
        $IgvSoles=$_POST['txtIgvSoles'];
        $IgvDolares=$_POST['txtIgvDolares'];
        $TotalSoles=$_POST['txtTotalSoles'];
        $TotalDolares=$_POST['txtTotalDolares'];
        $valor_unitario=$_POST['valor_unitario'];
        $pu_incluye_igv=isset($_POST['ckIncluyeIgv'])?1:0;
        $peso=0;
        $impuestos_tipo_ID=$_POST['selImpuestos_Tipo'];
        //El tipo es 3 de un componente
        $tipo_ID=3;
        try{
            $osalida_Detalle_Padre=salida_detalle::getByID($id);
            $producto_ID_old=$producto_ID;
            $osalida_Detalle=new salida_detalle();
            $osalida_Detalle->producto_ID=$producto_ID;
            $osalida_Detalle->salida_ID=$osalida_Detalle_Padre->salida_ID;
            $osalida_Detalle->descripcion=$descripcion;
            $osalida_Detalle->precio_venta_unitario_soles=$PrecioUnitarioSoles;
            $osalida_Detalle->precio_venta_unitario_dolares=$PrecioUnitarioDolares;
            $osalida_Detalle->precio_venta_subtotal_soles=$SubTotalSoles;
            $osalida_Detalle->precio_venta_subtotal_dolares=$SubTotalDolares;
            $osalida_Detalle->igv=$Igv;
            $osalida_Detalle->vigv_soles=$IgvSoles;
            $osalida_Detalle->vigv_dolares=$IgvDolares;
            $osalida_Detalle->precio_venta_soles=$TotalSoles;
            $osalida_Detalle->precio_venta_dolares=$TotalDolares;
            $osalida_Detalle->salida_detalle_ID=$id;
            $osalida_Detalle->estado_ID=33;
            $osalida_Detalle->cotizacion_detalle_ID=-1;
            $osalida_Detalle->ver_precio=$ver_precio;
            $osalida_Detalle->obsequio=0;
            $osalida_Detalle->tipo_ID=$tipo_ID;
            $osalida_Detalle->usuario_id=$_SESSION['usuario_ID'];
            $osalida_Detalle->cantidad=$cantidad;
            $osalida_Detalle->impuestos_tipo_ID=$impuestos_tipo_ID;
            $osalida_Detalle->tipo_precio_venta_unitario_ID=$osalida_Detalle_Padre->tipo_precio_venta_unitario_ID;
            $osalida_Detalle->valor_unitario=$valor_unitario;
            $osalida_Detalle->pu_incluye_igv=$pu_incluye_igv;
            $osalida_Detalle->peso=$peso; 
            
            $osalida_Detalle->descuento_porcentaje=$osalida_Detalle_Padre->descuento_porcentaje;
             $osalida_Detalle->descuento_soles=round($SubTotalSoles*($osalida_Detalle_Padre->descuento_porcentaje)/100,2);
            $osalida_Detalle->descuento_dolares=round($SubTotalDolares*($osalida_Detalle_Padre->descuento_porcentaje)/100,2);
            $osalida_Detalle->valor_venta_soles=round($SubTotalSoles*(100-$osalida_Detalle_Padre->descuento_porcentaje)/100,2);
            $osalida_Detalle->valor_venta_dolares=round($SubTotalDolares*(100-$osalida_Detalle_Padre->descuento_porcentaje)/100,2);
            
            $osalida_Detalle->insertar_new();
            $osalida_Detalle_Padre=actualizar_costo_Orden_Venta_detalle_padre($osalida_Detalle_Padre);
            $osalida_Detalle->actualizar_costos_padre($osalida_Detalle_Padre->salida_ID,$_SESSION['usuario_ID']);
            //actualizar_costos_padre($osalida_Detalle_Padre);
            $retorna=inventario::actualizar_inventario($osalida_Detalle->ID,$producto_ID_old,$_SESSION['usuario_ID'],$_SESSION['empresa_ID']);
            //actualizar_inventario($osalida_Detalle,$producto_ID_old);
            $resultado=1;
            $mensaje="Se guardó correctamente";

        }catch(Exception $ex){
          $resultado=-1;
          $mensaje=$ex->getMessage();
        }
        $oProducto=producto::getByID($producto_ID);
        $dtCategoria=categoria::getGrid();
        $oCategoria=categoria::getByID($oProducto->categoria_ID);
        $dtLinea=linea::getGrid();
        $oLinea=linea::getByID($oCategoria->linea_ID);
        $dtProducto=producto::getGrid("",-1,-1,"pr.nombre asc");
        $oInventario=new inventario();
        $stock=$oInventario->getStock($producto_ID);
        $osalida=salida::getByID($osalida_Detalle->salida_ID);
        $osalida_Detalle->stock=$stock;

        $osalida_Detalle->linea_ID=$oCategoria->linea_ID;
        $osalida_Detalle->dtLinea=$dtLinea;
        $osalida_Detalle->categoria_ID=$oCategoria->ID;
        $osalida_Detalle->dtCategoria=$dtCategoria;

        $osalida_Detalle->oSalida=$osalida;
        $osalida_Detalle->salida_detalle_padre_ID=$id;
        $dtImpuestos_Tipo=impuestos_tipo::getGrid();
        $GLOBALS['dtProducto']=$dtProducto;
        $GLOBALS['oOrden_Venta_Detalle']=$osalida_Detalle;
        $GLOBALS['dtImpuestos_Tipo']=$dtImpuestos_Tipo;
        $GLOBALS['resultado']=$resultado;
        $GLOBALS['mensaje']=$mensaje;
    }
    function get_Orden_Venta_Mantenimiento_Registro_Componente_Editar($id){
        require ROOT_PATH . 'models/categoria.php';
        require ROOT_PATH . 'models/linea.php';
        require ROOT_PATH . 'models/producto.php';
        require ROOT_PATH . 'models/salida.php';
        require ROOT_PATH . 'models/factura_venta.php';
        require ROOT_PATH . 'models/salida_detalle.php';
        require ROOT_PATH . 'models/inventario.php';
        require ROOT_PATH.'models/impuestos_tipo.php';
        global  $returnView_float;

        $returnView_float=true;
        $dtCategoria=categoria::getGrid();
        $dtCategoria=categoria::getGrid('',-1,-1,'ca.nombre asc');
        $dtLinea=linea::getGrid('',-1,-1,'li.nombre asc');
        
        $osalida_Detalle=salida_detalle::getByID($id);
        $osalida_Detalle->bloquear_edicion=factura_venta::getCount('salida_ID='.$osalida_Detalle->salida_ID.' and estado_ID=41');
        $osalida_Detalle_Padre=salida_detalle::getByID($osalida_Detalle->salida_detalle_ID);
        $osalida=salida::getByID($osalida_Detalle->salida_ID);

        $oInventario=new inventario();

        $osalida_Detalle->stock=$oInventario->getStock($osalida_Detalle->producto_ID);
        $oProducto=producto::getByID($osalida_Detalle->producto_ID);
        $oCategoria=categoria::getByID($oProducto->categoria_ID);
        $oLinea=linea::getByID($oCategoria->linea_ID);

        $oCategoria=categoria::getByID($oProducto->categoria_ID);
        $osalida_Detalle->linea_ID=$oCategoria->linea_ID;
        $osalida_Detalle->dtLinea=$dtLinea;
        $osalida_Detalle->categoria_ID=$oProducto->categoria_ID;
        $osalida_Detalle->dtCategoria=$dtCategoria;
        $osalida_Detalle->oSalida=$osalida;
        $osalida_Detalle->salida_detalle_padre_ID=$id;
        $dtImpuestos_Tipo=impuestos_tipo::getGrid();
        $GLOBALS['dtImpuestos_Tipo']=$dtImpuestos_Tipo;
        $osalida_Detalle->oProducto=$oProducto;
        $GLOBALS['oOrden_Venta_Detalle']=$osalida_Detalle;
        
        $GLOBALS['oOrden_Venta']=$osalida;

    }
    function post_Orden_Venta_Mantenimiento_Registro_Componente_Editar($id){
        require ROOT_PATH . 'models/categoria.php';
        require ROOT_PATH . 'models/linea.php';
        require ROOT_PATH . 'models/producto.php';
        require ROOT_PATH . 'models/salida_detalle.php';
        require ROOT_PATH . 'models/salida.php';
        require ROOT_PATH . 'models/inventario.php';
        require ROOT_PATH.'models/impuestos_tipo.php';
        global  $returnView_float;
        $returnView_float=true;
        $producto_ID=$_POST['selProducto'];
        $descripcion=FormatTextSave($_POST['txtDescripcion']);
        $cantidad=$_POST['txtCantidad'];
         if(isset($_POST['cbVer_Precio'])){
             $ver_precio=$_POST['cbVer_Precio'];
        }else {$ver_precio=0;}
        $PrecioUnitarioSoles=$_POST['txtPrecioUnitarioSoles'];
        $PrecioUnitarioDolares=$_POST['txtPrecioUnitarioDolares'];
        $SubTotalSoles=$_POST['txtSubTotalSoles'];
        $SubTotalDolares=$_POST['txtSubTotalDolares'];
        $Igv=$_POST['txtValIgv'];
        $IgvSoles=$_POST['txtIgvSoles'];
        $IgvDolares=$_POST['txtIgvDolares'];
        $TotalSoles=$_POST['txtTotalSoles'];
        $TotalDolares=$_POST['txtTotalDolares'];
        $valor_unitario=$_POST['valor_unitario'];
        $pu_incluye_igv=isset($_POST['ckIncluyeIgv'])?1:0;
        
        $impuestos_tipo_ID=$_POST['selImpuestos_Tipo'];
        try{
            $osalida_Detalle=salida_detalle::getByID($id);
            $producto_ID_old=$osalida_Detalle->producto_ID;
            $osalida_Detalle_Padre=salida_detalle::getByID($osalida_Detalle->salida_detalle_ID);
            $osalida_Detalle->producto_ID=$producto_ID;
            $osalida_Detalle->descripcion=$descripcion;
            $osalida_Detalle->precio_venta_unitario_soles=$PrecioUnitarioSoles;
            $osalida_Detalle->precio_venta_unitario_dolares=$PrecioUnitarioDolares;
            $osalida_Detalle->precio_venta_subtotal_soles=$SubTotalSoles;
            $osalida_Detalle->precio_venta_subtotal_dolares=$SubTotalDolares;
            $osalida_Detalle->igv=$Igv;
            $osalida_Detalle->vigv_soles=$IgvSoles;
            $osalida_Detalle->vigv_dolares=$IgvDolares;
            $osalida_Detalle->precio_venta_soles=$TotalSoles;
            $osalida_Detalle->precio_venta_dolares=$TotalDolares;
            $osalida_Detalle->ver_precio=$ver_precio;
            $osalida_Detalle->usuario_mod_id=$_SESSION['usuario_ID'];
            $osalida_Detalle->cantidad=$cantidad;
            $osalida_Detalle->impuestos_tipo_ID=$impuestos_tipo_ID;
            $osalida_Detalle->tipo_precio_venta_unitario_ID=$osalida_Detalle_Padre->tipo_precio_venta_unitario_ID;
            $osalida_Detalle->valor_unitario=$valor_unitario;
            $osalida_Detalle->pu_incluye_igv=$pu_incluye_igv;
            $osalida_Detalle->descuento_porcentaje=$osalida_Detalle_Padre->descuento_porcentaje;
            $osalida_Detalle->descuento_soles=round($SubTotalSoles*($osalida_Detalle_Padre->descuento_porcentaje)/100,2);
            $osalida_Detalle->descuento_dolares=round($SubTotalDolares*($osalida_Detalle_Padre->descuento_porcentaje)/100,2);
            $osalida_Detalle->valor_venta_soles=round($SubTotalSoles*(100-$osalida_Detalle_Padre->descuento_porcentaje)/100,2);
            $osalida_Detalle->valor_venta_dolares=round($SubTotalDolares*(100-$osalida_Detalle_Padre->descuento_porcentaje)/100,2);
            $osalida_Detalle->actualizar_new();
            $osalida_Detalle_Padre=actualizar_costo_orden_venta_detalle_padre($osalida_Detalle_Padre);
            $osalida_Detalle->actualizar_costos_padre($osalida_Detalle->salida_ID,$_SESSION['usuario_ID']);
            //actualizar_costos_padre($osalida_Detalle_Padre);
            $retorna=inventario::actualizar_inventario($osalida_Detalle->ID,$producto_ID_old,$_SESSION['usuario_ID'],$_SESSION['empresa_ID']);
            //actualizar_inventario($osalida_Detalle,$producto_ID_old);
            $resultado=1;
            $mensaje="Se guardó correctamente";

        }catch(Exception $ex){
          $resultado=-1;
          $mensaje=$ex->getMessage();
        }
        $osalida=salida::getByID($osalida_Detalle->salida_ID);
        $osalida_Detalle->stock=inventario::getStock($osalida_Detalle->producto_ID);
        
        $oProducto=producto::getByID($osalida_Detalle->producto_ID);
        $dtCategoria=categoria::getGrid('',-1,-1,'ca.nombre asc');
        $oCategoria=categoria::getByID($oProducto->categoria_ID);
        $dtLinea=linea::getGrid('',-1,-1,'li.nombre asc');
        $oLinea=linea::getByID($oCategoria->linea_ID);

        $oInventario=new inventario();
        $osalida_Detalle->stock=$oInventario->getStock($producto_ID);

        $osalida_Detalle->linea_ID=$oCategoria->linea_ID;
        $osalida_Detalle->dtLinea=$dtLinea;
        $osalida_Detalle->categoria_ID=$oProducto->categoria_ID;
        $osalida_Detalle->dtCategoria=$dtCategoria;
        $osalida_Detalle->oSalida=$osalida;
        $osalida_Detalle->salida_detalle_padre_ID=$id;
        $osalida_Detalle->oProducto=$oProducto;
        $dtImpuestos_Tipo=impuestos_tipo::getGrid();
        $GLOBALS['dtImpuestos_Tipo']=$dtImpuestos_Tipo;
        $GLOBALS['oOrden_Venta']=$osalida;
        $GLOBALS['oOrden_Venta_Detalle']=$osalida_Detalle;
        $GLOBALS['resultado']=$resultado;
        $GLOBALS['mensaje']=$mensaje;
    }
    function get_Orden_Venta_Mantenimiento_Registro_Adicional_Nuevo($id){
        require ROOT_PATH . 'models/categoria.php';
        require ROOT_PATH . 'models/linea.php';
        require ROOT_PATH . 'models/producto.php';
        require ROOT_PATH . 'models/salida.php';
        require ROOT_PATH . 'models/salida_detalle.php';
        require ROOT_PATH . 'models/inventario.php';
        require ROOT_PATH.'models/impuestos_tipo.php';
        global  $returnView_float;

        $returnView_float=true;
        $dtCategoria=categoria::getGrid('',-1,-1,'ca.nombre asc');
        $dtLinea=linea::getGrid('',-1,-1,'li.nombre asc');
        $dtProducto=producto::getGrid('',-1,-1,'pr.nombre asc');
        $osalida_Detalle_Padre=salida_detalle::getByID($id);
        $osalida=salida::getByID($osalida_Detalle_Padre->salida_ID);
        $osalida_Detalle= new salida_detalle();
        //Enviamos como tipo componente interno
        //$oCotizacion_Detalle->tipo=2;
        $osalida_Detalle->ID=0;
        $osalida_Detalle->linea_ID=0;
        $osalida_Detalle->dtLinea=$dtLinea;
        $osalida_Detalle->categoria_ID=0;
        $osalida_Detalle->dtCategoria=$dtCategoria;
        $osalida_Detalle->producto_ID=0;
        $osalida_Detalle->oSalida=$osalida;
        $osalida_Detalle->salida_detalle_padre_ID=$id;
        $osalida_Detalle->stock=0;
        $osalida_Detalle->precio_venta_unitario_dolares="";
        $osalida_Detalle->precio_venta_unitario_soles="";
        $osalida_Detalle->cantidad="";
        $osalida_Detalle->descuento_porcentaje=$osalida_Detalle_Padre->descuento_porcentaje;
        $dtImpuestos_Tipo=impuestos_tipo::getGrid();
        $GLOBALS['dtImpuestos_Tipo']=$dtImpuestos_Tipo;
        $GLOBALS['dtProducto']=$dtProducto;
        $GLOBALS['oOrden_Venta_Detalle']=$osalida_Detalle;
        $GLOBALS['oOrden_Venta']=$osalida;

    }
    function post_Orden_Venta_Mantenimiento_Registro_Adicional_Nuevo($id){
        require ROOT_PATH . 'models/categoria.php';
        require ROOT_PATH . 'models/linea.php';
        require ROOT_PATH . 'models/producto.php';
        require ROOT_PATH . 'models/salida_detalle.php';
        require ROOT_PATH . 'models/salida.php';
        require ROOT_PATH . 'models/inventario.php';
        require ROOT_PATH.'models/impuestos_tipo.php';
        global  $returnView_float;
        $returnView_float=true;
        //El tipo es 4 de un adicional
        $tipo_ID=4;//$_POST['rbtipo'];
        $producto_ID=$_POST['selProducto'];
        $descripcion=  FormatTextSave($_POST['txtDescripcion']);
        $cantidad=$_POST['txtCantidad'];

        if(isset($_POST['cbVer_Precio'])){
             $ver_precio=$_POST['cbVer_Precio'];
        }else {$ver_precio=0;}

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

        }else {$separacion=0;}
        if(isset($_POST['txtTiempo_Separacion'])){
            $tiempo_separacion=$_POST['txtTiempo_Separacion'];
        }else{
            $tiempo_separacion=0;
        }
        $valor_unitario=$_POST['valor_unitario'];
        $pu_incluye_igv=isset($_POST['ckIncluyeIgv'])?1:0;
        
        $impuestos_tipo_ID=$_POST['selImpuestos_Tipo'];
        try{
            $producto_ID_old=$producto_ID;
            $osalida_Detalle_Padre=salida_detalle::getByID($id);
            $osalida_Detalle=new salida_detalle();
            $osalida_Detalle->producto_ID=$producto_ID;
            $osalida_Detalle->salida_ID=$osalida_Detalle_Padre->salida_ID;
            $osalida_Detalle->descripcion=$descripcion;
            $osalida_Detalle->cantidad=$cantidad;
            $osalida_Detalle->precio_venta_unitario_soles=$PrecioUnitarioSoles;
            $osalida_Detalle->precio_venta_unitario_dolares=$PrecioUnitarioDolares;
            $osalida_Detalle->precio_venta_subtotal_soles=$SubTotalSoles;
            $osalida_Detalle->precio_venta_subtotal_dolares=$SubTotalDolares;
            $osalida_Detalle->igv=$Igv;
            $osalida_Detalle->vigv_soles=$IgvSoles;
            $osalida_Detalle->vigv_dolares=$IgvDolares;
            $osalida_Detalle->precio_venta_soles=$TotalSoles;
            $osalida_Detalle->precio_venta_dolares=$TotalDolares;
            $osalida_Detalle->salida_detalle_ID=$id;
            $osalida_Detalle->cotizacion_detalle_ID='NULL';
            $osalida_Detalle->estado_ID=33;
            $osalida_Detalle->ver_precio=$ver_precio;
            $osalida_Detalle->usuario_id=$_SESSION['usuario_ID'];
            $osalida_Detalle->impuestos_tipo_ID=$impuestos_tipo_ID;
            //$osalida_Detalle->cantidad_separada=0;
            $osalida_Detalle->tipo_ID=$tipo_ID;
            $osalida_Detalle->tipo_precio_venta_unitario_ID=$osalida_Detalle_Padre->tipo_precio_venta_unitario_ID;
            
             $osalida_Detalle->valor_unitario=$valor_unitario;
            $osalida_Detalle->pu_incluye_igv=$pu_incluye_igv;
            $osalida_Detalle->descuento_porcentaje=$osalida_Detalle_Padre->descuento_porcentaje;
            $osalida_Detalle->descuento_soles=round($SubTotalSoles*($osalida_Detalle_Padre->descuento_porcentaje)/100,2);
            $osalida_Detalle->descuento_dolares=round($SubTotalDolares*($osalida_Detalle_Padre->descuento_porcentaje)/100,2);
            $osalida_Detalle->valor_venta_soles=round($SubTotalSoles*(100-$osalida_Detalle_Padre->descuento_porcentaje)/100,2);
            $osalida_Detalle->valor_venta_dolares=round($SubTotalDolares*(100-$osalida_Detalle_Padre->descuento_porcentaje)/100,2);
            
            
            $osalida_Detalle->insertar_new();

            $producto_ID_old=$osalida_Detalle->producto_ID;
            /*Actualizamos los costos en la el costo del padre*/

            //separarProductoCotizacion($osalida_Detalle,$producto_ID_old);
            //separarProducto($osalida_Detalle,1);
            $osalida_Detalle_Padre=actualizar_costo_orden_venta_detalle_padre($osalida_Detalle_Padre);
            $retorna=inventario::actualizar_inventario($osalida_Detalle->ID,$producto_ID_old,$_SESSION['usuario_ID'],$_SESSION['empresa_ID']);
            //actualizar_inventario($osalida_Detalle,$producto_ID_old);
            $osalida_Detalle->actualizar_costos_padre($osalida_Detalle_Padre->salida_ID,$_SESSION['usuario_ID']);
            //actualizar_costos_padre($osalida_Detalle_Padre);
            $resultado=1;
            $mensaje='Se guardó correctamente';

        }catch(Exception $ex){
          $resultado=-1;
          $mensaje=$ex->getMessage();
        }
        $dtCategoria=categoria::getGrid('',-1,-1,'ca.nombre asc');
        $dtLinea=linea::getGrid('',-1,-1,'li.nombre asc');
       
        $oProducto=producto::getByID($producto_ID);
        $stock=inventario::getStock($producto_ID);

        $osalida=salida::getByID($osalida_Detalle_Padre->salida_ID);
        $oCategoria=categoria::getByID($oProducto->categoria_ID);
        $osalida_Detalle->linea_ID=$oCategoria->linea_ID;
        $osalida_Detalle->dtLinea=$dtLinea;
        $osalida_Detalle->categoria_ID=$oProducto->categoria_ID;
        $osalida_Detalle->dtCategoria=$dtCategoria;
        $osalida_Detalle->oSalida=$osalida;
        $osalida_Detalle->salida_detalle_padre_ID=$id;
        $osalida_Detalle->stock=$stock;
        $osalida_Detalle->oProducto=$oProducto;
        $dtImpuestos_Tipo=impuestos_tipo::getGrid();
        $GLOBALS['dtImpuestos_Tipo']=$dtImpuestos_Tipo;
        $GLOBALS['oOrden_Venta_Detalle']=$osalida_Detalle;
        $GLOBALS['resultado']=$resultado;
        $GLOBALS['mensaje']=$mensaje;

    }
    function get_Orden_Venta_Mantenimiento_Registro_Adicional_Editar($id){
        require ROOT_PATH . 'models/categoria.php';
        require ROOT_PATH . 'models/linea.php';
        require ROOT_PATH . 'models/producto.php';
        require ROOT_PATH . 'models/salida.php';
        require ROOT_PATH . 'models/factura_venta.php';
        require ROOT_PATH . 'models/salida_detalle.php';
        require ROOT_PATH . 'models/inventario.php';
        require ROOT_PATH.'models/impuestos_tipo.php';
        global  $returnView_float;

        $returnView_float=true;
        $dtCategoria=categoria::getGrid('',-1,-1,'ca.nombre asc');
        $dtLinea=linea::getGrid('',-1,-1,'li.nombre asc');
       
        $osalida_Detalle=salida_detalle::getByID($id);
        $osalida_Detalle->bloquear_edicion=factura_venta::getCount('salida_ID='.$osalida_Detalle->salida_ID.' and estado_ID=41');
        $osalida=salida::getByID($osalida_Detalle->salida_ID);
        $oInventario=new inventario();
        $stock=$oInventario->getStock($osalida_Detalle->producto_ID);

        $oProducto=producto::getByID($osalida_Detalle->producto_ID);
        $oCategoria=categoria::getByID($oProducto->categoria_ID);
        $oLinea=linea::getByID($oCategoria->linea_ID);

        $oCategoria=categoria::getByID($oProducto->categoria_ID);
        $osalida_Detalle->linea_ID=$oCategoria->linea_ID;
        $osalida_Detalle->dtLinea=$dtLinea;
        $osalida_Detalle->categoria_ID=$oProducto->categoria_ID;
        $osalida_Detalle->dtCategoria=$dtCategoria;
        $osalida_Detalle->oSalida=$osalida;
        $osalida_Detalle->salida_detalle_padre_ID=$id;
        $osalida_Detalle->stock=$stock;
        $osalida_Detalle->oProducto=$oProducto;
        $dtImpuestos_Tipo=impuestos_tipo::getGrid();
        $GLOBALS['dtImpuestos_Tipo']=$dtImpuestos_Tipo;
        //$GLOBALS['dtProducto']=$dtProducto;
        $GLOBALS['oOrden_Venta_Detalle']=$osalida_Detalle;
        $GLOBALS['oOrden_Venta']=$osalida;

    }
    function post_Orden_Venta_Mantenimiento_Registro_Adicional_Editar($id){
        require ROOT_PATH . 'models/categoria.php';
        require ROOT_PATH . 'models/linea.php';
        require ROOT_PATH . 'models/producto.php';
        require ROOT_PATH . 'models/salida_detalle.php';
        require ROOT_PATH . 'models/salida.php';
        require ROOT_PATH . 'models/inventario.php';
        require ROOT_PATH.'models/impuestos_tipo.php';
        global  $returnView_float;
        $returnView_float=true;
        $tipo_ID=4;
        $producto_ID=$_POST['selProducto'];
        $descripcion=  FormatTextSave($_POST['txtDescripcion']);
        $cantidad=$_POST['txtCantidad'];
         if(isset($_POST['cbVer_Precio'])){
             $ver_precio=$_POST['cbVer_Precio'];
        }else {$ver_precio=0;}
        $PrecioUnitarioSoles=$_POST['txtPrecioUnitarioSoles'];
        $PrecioUnitarioDolares=$_POST['txtPrecioUnitarioDolares'];

        $SubTotalSoles=$_POST['txtSubTotalSoles'];
        $SubTotalDolares=$_POST['txtSubTotalDolares'];
        $Igv=$_POST['txtValIgv'];
        $IgvSoles=$_POST['txtIgvSoles'];
        $IgvDolares=$_POST['txtIgvDolares'];
        $TotalSoles=$_POST['txtTotalSoles'];
        $TotalDolares=$_POST['txtTotalDolares'];
        $valor_unitario=$_POST['valor_unitario'];
        $pu_incluye_igv=isset($_POST['ckIncluyeIgv'])?1:0;
        
        $impuestos_tipo_ID=$_POST['selImpuestos_Tipo'];
        $osalida_Detalle=salida_detalle::getByID($id);
        try{
            $producto_ID_old=$osalida_Detalle->producto_ID;
            $osalida_Detalle_Padre=salida_detalle::getByID($osalida_Detalle->salida_detalle_ID);
            $osalida_Detalle->producto_ID=$producto_ID;
            $osalida_Detalle->descripcion=$descripcion;
            $osalida_Detalle->cantidad=$cantidad;
            $osalida_Detalle->precio_venta_unitario_soles=$PrecioUnitarioSoles;
            $osalida_Detalle->precio_venta_unitario_dolares=$PrecioUnitarioDolares;
            $osalida_Detalle->precio_venta_subtotal_soles=$SubTotalSoles;
            $osalida_Detalle->precio_venta_subtotal_dolares=$SubTotalDolares;
            $osalida_Detalle->igv=$Igv;
            $osalida_Detalle->vigv_soles=$IgvSoles;
            $osalida_Detalle->vigv_dolares=$IgvDolares;
            $osalida_Detalle->precio_venta_soles=$TotalSoles;
            $osalida_Detalle->precio_venta_dolares=$TotalDolares;
            $osalida_Detalle->ver_precio=$ver_precio;
            $osalida_Detalle->tipo_ID=$tipo_ID;
            $osalida_Detalle->valor_unitario=$valor_unitario;
            $osalida_Detalle->pu_incluye_igv=$pu_incluye_igv;
            $osalida_Detalle->descuento_porcentaje=$osalida_Detalle_Padre->descuento_porcentaje;
            $osalida_Detalle->descuento_soles=round($SubTotalSoles*($osalida_Detalle_Padre->descuento_porcentaje)/100,2);
            $osalida_Detalle->descuento_dolares=round($SubTotalDolares*($osalida_Detalle_Padre->descuento_porcentaje)/100,2);
            $osalida_Detalle->valor_venta_soles=round($SubTotalSoles*(100-$osalida_Detalle_Padre->descuento_porcentaje)/100,2);
            $osalida_Detalle->valor_venta_dolares=round($SubTotalDolares*(100-$osalida_Detalle_Padre->descuento_porcentaje)/100,2);
            $osalida_Detalle->usuario_mod_id=$_SESSION['usuario_ID'];
            $osalida_Detalle->actualizar_new();

            $osalida_Detalle_Padre=salida_detalle::getByID($osalida_Detalle->salida_detalle_ID);
            $osalida_Detalle_Padre=actualizar_costo_orden_venta_detalle_padre($osalida_Detalle_Padre);
            $osalida_Detalle->actualizar_costos_padre($osalida_Detalle_Padre->salida_ID,$_SESSION['usuario_ID']);
            //actualizar_costos_padre($osalida_Detalle_Padre);
            
            $retorna=inventario::actualizar_inventario($osalida_Detalle->ID,$producto_ID_old,$_SESSION['usuario_ID'],$_SESSION['empresa_ID']);
            //actualizar_inventario($osalida_Detalle,$producto_ID_old);
            $mensaje='Se actualizó correctamente';
            $resultado=1;
        }catch(Exception $ex){
          $resultado=-1;
          $mensaje=$ex->getMessage();
        }
        $dtCategoria=categoria::getGrid('',-1,-1,'ca.nombre asc');
        $dtLinea=linea::getGrid('',-1,-1,'li.nombre asc');
       
        $oInventario=new inventario();
        $osalida=salida::getByID($osalida_Detalle->salida_ID);
        $stock=$oInventario->getStock($producto_ID);
        $oProducto=producto::getByID($producto_ID);
        $oCategoria=categoria::getByID($oProducto->categoria_ID);
        $osalida_Detalle->linea_ID=$oCategoria->linea_ID;
        $osalida_Detalle->dtLinea=$dtLinea;
        $osalida_Detalle->categoria_ID=$oProducto->categoria_ID;
        $osalida_Detalle->dtCategoria=$dtCategoria;
        $osalida_Detalle->oSalida=$osalida;
        $dtImpuestos_Tipo=impuestos_tipo::getGrid();
        $GLOBALS['dtImpuestos_Tipo']=$dtImpuestos_Tipo;
        $osalida_Detalle->stock=$stock;
        $osalida_Detalle->oProducto=$oProducto;
        $GLOBALS['oOrden_Venta']=$osalida;
        $GLOBALS['oOrden_Venta_Detalle']=$osalida_Detalle;
        $GLOBALS['resultado']=$resultado;
        $GLOBALS['mensaje']=$mensaje;
    }

    function post_ajaxOrden_Venta_Detalle_Mantenimiento_Eliminar(){
        require ROOT_PATH.'models/salida_detalle.php';
        require ROOT_PATH.'models/salida.php';
        $id=$_POST['id'];
        try{
                $osalida_Detalle=salida_detalle::getByID($id);
                $osalida_Detalle->usuario_mod_id=$_SESSION['usuario_ID'];
                if($osalida_Detalle==null){
                    throw new Exception('Parece que el registro ya fue eliminado.');
                }
                //$contador_hijos=salida_detalle::getCount('salida_ID='.$osalida_Detalle->salida_ID.' and tipo in (2,5,6)');
                $mensaje='';
                switch($osalida_Detalle->tipo_ID){
                    case 1:
                        if ($osalida_Detalle->eliminar()==-1){
                        throw new Exception($osalida_Detalle->message);
                        }
                        $mensaje=$osalida_Detalle->message;
                        $resultado=1;
                        break;
                    case 2:
                        $contar_hijo=salida_detalle::getCount("tipo_ID=3 and salida_detalle_ID=".$id);
                        if($contar_hijo==0){
                            if ($osalida_Detalle->eliminar()==-1){
                                throw new Exception($osalida_Detalle->message);
                            }
                            $mensaje=$osalida_Detalle->message;
                             $resultado=1;
                        }else{
                            $mensaje="No se puede eliminar, el producto tiene componentes.";
                            $resultado=-1;
                        }
                        
                        break;
                    case 5:
                        $contar_hijo=salida_detalle::getCount("tipo_ID in (3,4) and salida_detalle_ID=".$id);
                        if($contar_hijo==0){
                            if ($osalida_Detalle->eliminar()==-1){
                                throw new Exception($osalida_Detalle->message);
                            }
                            $mensaje=$osalida_Detalle->message;
                             $resultado=1;
                        }else{
                            $mensaje="No se puede eliminar, el producto tiene componentes y adicionales.";
                            $resultado=-1;
                        }
                        
                        break;
                    case 6:
                        $contar_hijo=salida_detalle::getCount("tipo_ID = 4 and salida_detalle_ID=".$id);
                        if($contar_hijo==0){
                            if ($osalida_Detalle->eliminar()==-1){
                                throw new Exception($osalida_Detalle->message);
                            }
                            $mensaje=$osalida_Detalle->message;
                            $resultado=1;
                        }else{
                            $mensaje="No se puede eliminar, el producto tiene adicionales.";
                            $resultado=-1;
                        }
                        
                        break;
                    case 7:
                       if ($osalida_Detalle->eliminar()==-1){
                        throw new Exception($osalida_Detalle->message);
                        }
                        $mensaje=$osalida_Detalle->message;
                        $resultado=1;
                }
               eliminar_inventario($osalida_Detalle);
               actualizar_costos_padre($osalida_Detalle);

        }catch(Exception $ex){
                $resultado=-1;
                $mensaje=$ex->getMessage();

        }

        $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);

        echo json_encode($retornar);
	}
    function get_Orden_Venta_Mantenimiento_Factura($id){
        require ROOT_PATH . 'models/salida.php';
        require ROOT_PATH . 'models/salida_detalle.php';
        require ROOT_PATH . 'models/producto.php';
        require ROOT_PATH . 'models/factura_venta.php';
        if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";;
        require ROOT_PATH . 'models/moneda.php';

        require ROOT_PATH . 'models/usuario.php';
        require ROOT_PATH . 'models/estado.php';
        require ROOT_PATH . 'models/correlativos.php';
        require ROOT_PATH . 'models/impuestos_tipo.php';
        require ROOT_PATH . 'models/tipo_comprobante.php';
        
        global  $returnView_float;
        $returnView_float=true;
        $salida_ID=$id;
        $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
        $osalida=salida::getByID($salida_ID);
        $dtsalida_Detalle=salida_detalle::getGrid('salida_ID='.$salida_ID . " and salida_detalle_ID=0");
        $listaproducto=mostrar_productos($salida_ID,3);
        $ContarFactura_Venta=factura_venta::getCount('salida_ID='.$id.' and estado_ID in (35,41)');
        //$electronico=factura_venta::getE
        $dtImpuestos_Tipo=impuestos_tipo::getGrid();
        $mensaje="";
        $informacion="";
        
        if($ContarFactura_Venta==0||$osalida->estado_ID==58){
            if($osalida->estado_ID==58){
                $dtFactura_Venta1=factura_venta::getGrid("fv.salida_ID=".$id." and fv.estado_ID=53",-1,-1,"fv.ID desc");
                $correlativos_ID=$dtFactura_Venta1[0]['correlativos_ID'];
                $electronico=correlativos::verificar_electronico($dtFactura_Venta1[0]['correlativos_ID']);
                $numero_temporal=correlativos::getNumero($dtFactura_Venta1[0]['correlativos_ID']);
                $dtComprobantes=tipo_comprobante::getComprobantes(0,'venta',$correlativos_ID,0,"tipo_comprobantes");
            }else{
                $electronico=correlativos::verificar_electronico(correlativos_ID);
                $numero_temporal=correlativos::getNumero(correlativos_ID_fisico);
                $correlativos_ID=correlativos_ID_fisico;
                $dtComprobantes=tipo_comprobante::getComprobantes(0,'venta',correlativos_ID_fisico,0,"tipo_comprobantes");
            }
            
            $oFactura_Venta=new factura_venta();
            $oFactura_Venta->comprobante="factura_venta";
            $dtGridCorrelativo=correlativos::getGridCorrelativos("venta",0);
            $oFactura_Venta->ID=0;
            $oFactura_Venta->fecha_emision=date("d/m/Y");
            $oFactura_Venta->moneda_ID=$osalida->moneda_ID;
            $oFactura_Venta->fecha_vencimiento=date("d/m/Y");
            
            $oFactura_Venta->serie=correlativos::getByID(correlativos_ID_fisico)->serie;
            $oFactura_Venta->numero=$numero_temporal;
            $numero_concatenado=sprintf("%'.07d",$numero_temporal);
            $oFactura_Venta->numero_concatenado=$numero_concatenado;
            //$informacion=extraer_informacion_factura($salida_ID,1);
            $oFactura_Venta->plazo_factura=0;
            $oFactura_Venta->ver_vista_previa=0;
            $oFactura_Venta->ver_imprimir=0;
            $oFactura_Venta->ver_cambios=0;
            $oFactura_Venta->correlativos_ID=$correlativos_ID;
            $oFactura_Venta->impuestos_tipo_ID=1;
            $oFactura_Venta->numero_orden_venta=$osalida->numero_concatenado;
            $oFactura_Venta->numero_orden_compra=$osalida->numero_orden_compra;
            
            $oFactura_Venta->gravadas=$osalida->gravadas;
            $oFactura_Venta->gratuitas=$osalida->gratuitas;
            $oFactura_Venta->inafectas=$osalida->inafectas;
            $oFactura_Venta->exoneradas=$osalida->exoneradas;
            $oFactura_Venta->descuento_global=$osalida->descuento_global;
            $oFactura_Venta->porcentaje_descuento=$osalida->porcentaje_descuento;
            $oFactura_Venta->otros_cargos=$osalida->otros_cargos;
            $oFactura_Venta->monto_total=($osalida->moneda_ID==1)?$osalida->precio_venta_total_soles:$osalida->precio_venta_total_dolares;
            $oFactura_Venta->monto_total_igv=($osalida->moneda_ID==1)?$osalida->vigv_soles:$osalida->vigv_dolares;
            //generamos una factura en estado registrado
            $oEstado=estado::getByID(35);
//$oFactura_Venta->estado_ID=35;
            
            $dtGridCorrelativo=correlativos::getGridCorrelativos("venta",0);
            
        }else {
            $i=0;
            $dtFactura_Venta=factura_venta::getGrid('salida_ID='.$id,-1,-1,'ID asc');
            foreach ($dtFactura_Venta as $value) {
                $factura_ID=$value['ID'];
                /*if($i==0){
                    $factura_ID=$value['ID'];
                }
                $i= $i+1;*/
            }
            $oFactura_Venta=factura_venta::getByID($factura_ID);
           
            $oFactura_Venta->comprobante="factura_venta";
            $dtGridCorrelativo=correlativos::getGridCorrelativos("venta",0);
            $electronico=correlativos::verificar_electronico($oFactura_Venta->correlativos_ID);
            $oEstado=estado::getByID($oFactura_Venta->estado_ID);
             $dtComprobantes=tipo_comprobante::getComprobantes(0,'venta',$oFactura_Venta->correlativos_ID,0,"tipo_comprobantes");
            //$oFactura_Venta->ver_cambios=0;
            switch($oFactura_Venta->estado_ID){
                case 35:
                    //La factura con estado registrado
                    if($electronico==0){
                        $numero_temporal=correlativos::getNumero($oFactura_Venta->correlativos_ID);
                        $numero_concatenado=sprintf("%'.07d",$numero_temporal);
                        $oFactura_Venta->numero_concatenado=$numero_concatenado;
                    }
                    

                    $oFactura_Venta->ver_vista_previa=1;
                    $oFactura_Venta->ver_imprimir=1;
                    break;
                case 41:
                    //Factura emitido
                    $oFactura_Venta->ver_vista_previa=1;
                    $oFactura_Venta->ver_imprimir=1;
                    break;
                case 53:
                    //factura anulado
                    $numero_temporal=correlativos::getNumero($oFactura_Venta->correlativos_ID);
                    $numero_concatenado=sprintf("%'.07d",$numero_temporal);
                    $oFactura_Venta->numero_concatenado=$numero_concatenado;
                    $oFactura_Venta->plazo_factura=0;
                    $oFactura_Venta->fecha_emision=date("d/m/Y");
                    $oFactura_Venta->fecha_vencimiento="";
                    $oFactura_Venta->ver_vista_previa=0;
                    $oFactura_Venta->ver_imprimir=0;
                    break;
                case 93:
                    $oFactura_Venta->ver_vista_previa=1;
                    $oFactura_Venta->ver_imprimir=0;
                    $oFactura_Venta->ver_enviar_SUNAT=1;
                    break;
                case 94:
                    $oFactura_Venta->ver_vista_previa=1;
                    $oFactura_Venta->ver_imprimir=0;
                    $oFactura_Venta->ver_enviar_SUNAT=0;
                    break;
            }
        }
        $oFactura_Venta->estado=$oEstado->nombre;
        $oFactura_Venta->dtSerie=$dtGridCorrelativo;
        //$osalida=salida::getByID($salida_ID);
        $osalida->serie=$oFactura_Venta->serie;
        $oFactura_Venta->dtImpuestos_Tipo=$dtImpuestos_Tipo;
        $GLOBALS['facturas_informacion']=extraer_estructura_facturas($osalida);
        $GLOBALS['electronico']=$electronico;
        $GLOBALS['oFactura_Venta']=$oFactura_Venta;
        $GLOBALS['oOrden_Venta']=$osalida;
        $GLOBALS['listaproducto']=$listaproducto;
        $GLOBALS['mensaje']=$mensaje;
        $GLOBALS['selComprobantes']=$dtComprobantes;

    }

    function post_Orden_Venta_Mantenimiento_Factura($ID){
        require ROOT_PATH . 'models/salida.php';
        require ROOT_PATH . 'models/salida_detalle.php';
        require ROOT_PATH . 'models/producto.php';
        require ROOT_PATH . 'models/factura_venta.php';
        require ROOT_PATH . 'models/factura_venta_detalle.php';
        if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";;
        require ROOT_PATH . 'models/moneda.php';
        require ROOT_PATH . 'models/serie.php';
        require ROOT_PATH . 'models/estado.php';
        require ROOT_PATH . 'models/correlativos.php';
        require ROOT_PATH . 'models/impuestos_tipo.php';
        require ROOT_PATH . 'models/tipo_comprobante.php';
        global  $returnView_float;
        $returnView_float=true;
        $salida_ID=$ID;
        $factura_venta_ID=$_POST['txtID'];
        $opcion=0;
        if(isset($_POST['ckOpcion'])){
            $opcion=$_POST['ckOpcion'];
        }
        $serie=$_POST['txtSerie'];
        $correlativos_ID=$_POST['selSerie'];
        $numero=$_POST['txtNumero'];
        $Fecha_Emision=$_POST['txtFecha_Emision'];
        $Plazo_Factura=$_POST['txtPlazo_Factura'];
        $Fecha_Vencimiento=$_POST['txtFecha_Vencimiento'];
        $Moneda_ID=$_POST['selMoneda'];
        $numero_orden_compra=FormatTextSave($_POST['txtOrden_Compra']);
        $orden_compra= FormatTextSave($_POST['txtOrden_Pedido']);
        $comprobante=$_POST['selTipoComprobante'];
        $impuestos_tipo_ID=$_POST['selImpuestos_Tipo'];
        $porcentaje_descuento=$_POST['txtPorcentaje_Descuento'];
        $anticipos=$_POST['txtAnticipos'];
        $exoneradas=$_POST['txtExoneradas'];
        $inafectas=$_POST['txtInafectas'];
        $gravadas=$_POST['txtGravadas'];
        $monto_total_igv=$_POST['txtTotal_IGV'];
        $gratuitas=$_POST['txtGratuitas'];
        $otros_cargos=$_POST['txtOtros_Cargos'];
        $descuento_global=$_POST['txtDescuento_Global'];
        $monto_total=$_POST['txtMonto_Total'];
        $ver_descripcion=isset($_POST['ckVerDescripcion'])?1:0;
        //$con_guia=$_POST['selGuia_Venta'];
        try{
            /* Extraemos el número*/
            //$oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
            $dtImpuestos_Tipo=impuestos_tipo::getGrid();
            $electronico=0;
            $osalida=salida::getByID($ID);
            $contador_facturas=factura_venta::getCount('salida_ID='.$ID);
            $dtComprobantes=tipo_comprobante::getComprobantes(0,'venta',$correlativos_ID,0,"tipo_comprobantes");
            //Creamos nueva factura para los anulados
            if($contador_facturas==0||$osalida->estado_ID==58){
                $arrayProductoFactura=explode("/",$osalida->nproducto_pagina);
                $n=0;
                
                if($electronico>0){
                  $numero_pagina=1;  
                 
                }else{
                    $numero_pagina=$osalida->numero_pagina;
                   
                }
                
                for ($i=0;$i<$numero_pagina;$i++){
                    $oFactura_Venta=new factura_venta();
                    if($electronico>0){
                        $nproductos_pagina=salida_detalle::getCount("salida_ID=".$ID.' and tipo_ID in (1,2,5,6)');
                    }else{

                        $nproductos_pagina=$arrayProductoFactura[$i];
                    }
                    $oFactura_Venta->salida_ID=$salida_ID;
                    $oFactura_Venta->correlativos_ID=$correlativos_ID;
                    $oFactura_Venta->serie=$serie;
                    $numero_temporal=correlativos::getNumero($correlativos_ID);
                    $numero_concatenado=sprintf("%'.07d",$numero_temporal);
                    $oFactura_Venta->numero=$numero_temporal;
                    $oFactura_Venta->numero_concatenado=$numero_concatenado;
                    $oFactura_Venta->fecha_emision=$Fecha_Emision;
                    $oFactura_Venta->forma_pago_ID=$osalida->forma_pago_ID;
                    $oFactura_Venta->plazo_factura=$Plazo_Factura;
                    $oFactura_Venta->fecha_vencimiento=$Fecha_Vencimiento;
                    //Generamos la factura en estado registrado
                    $oFactura_Venta->impresion=0;
                    $oFactura_Venta->estado_ID=35;
                    $oFactura_Venta->moneda_ID=$Moneda_ID;
                    $oFactura_Venta->numero_orden_compra=$numero_orden_compra;
                    $oFactura_Venta->numero_orden_venta=$orden_compra;
                    $oFactura_Venta->opcion=$opcion;
                    $oFactura_Venta->numero_producto=$nproductos_pagina;
                    $oFactura_Venta->impuestos_tipo_ID=$impuestos_tipo_ID;
                    
                    
                    
                    $oFactura_Venta->otros_cargos=$otros_cargos;
                    //$oFactura_Venta->con_guia=$con_guia;
                    $oFactura_Venta->usuario_id=$_SESSION['usuario_ID'];
                    $oFactura_Venta->gravadas=$gravadas;
                    $oFactura_Venta->gratuitas=$gratuitas;
                    $oFactura_Venta->inafectas=$inafectas;
                    $oFactura_Venta->exoneradas=$exoneradas;
                    $oFactura_Venta->descuento_global=$descuento_global;
                    $oFactura_Venta->porcentaje_descuento=$porcentaje_descuento;
                    $oFactura_Venta->otros_cargos=$otros_cargos;
                    $oFactura_Venta->ver_descripcion=$ver_descripcion;
                    $oFactura_Venta->insertar();
                    
                    /*=====Insertamos la factura_venta_detalle*/
                    $oFactura_Venta_Detalle=new factura_venta_detalle();
                    $oFactura_Venta_Detalle->factura_venta_ID=$oFactura_Venta->ID;
                    $oFactura_Venta_Detalle->usuario_id=$_SESSION['usuario_ID'];
                    $dtsalida_Detalle=salida_detalle::getGridLista("ovd.salida_ID=".$ID. ' and ovd.tipo_ID in (1,2,5,6) ',$n,$nproductos_pagina,"ovd.ID asc");
                    
                    foreach($dtsalida_Detalle as $value){
                        $oFactura_Venta_Detalle->impuestos_tipo_ID=$impuestos_tipo_ID;
                        $oFactura_Venta_Detalle->salida_detalle_ID=$value['ID'];
                        $oFactura_Venta_Detalle->impuestos_tipo_ID=$impuestos_tipo_ID;
                        $oFactura_Venta_Detalle->ver_descripcion=$ver_descripcion;
                        $oFactura_Venta_Detalle->insertar();

                    }
                    //Actualizamos los montos totales
                    actualizarCostosFactura($oFactura_Venta);
                    $n=$n+$nproductos_pagina;
                    $oFactura_Venta->ver_vista_previa=1;
                    $oFactura_Venta->ver_imprimir=1;
                    if($electronico>0){
                        $oFactura_Venta->ver_enviar_SUNAT=1;
                        $oFactura_Venta->ver_imprimir=0;
                        /*=================Actualizamos el correlativo*/
                        $oCorrelativos=correlativos::getByID($correlativos_ID);
                        $oCorrelativos->ultimo_numero=$oCorrelativos->ultimo_numero+1;
                        $oCorrelativos->usuario_mod_id=$_SESSION['usuario_ID'];
                        $oCorrelativos->actualizar();
                        /*=================Actualizamos la factura a generado */
                        $oFactura_Venta->estado_ID=93;
                        $oFactura_Venta->usuario_mod_id=$_SESSION['usuario_ID'];
                        $oFactura_Venta->actualizar();
                        
                        /*=====Actualizamos el estado de la salida al estado facturado=======*/
                        $osalida->estado_ID=40;
                        $osalida->usuario_mod_id=$_SESSION['usuario_ID'];
                        $osalida->actualizar();
                    }else{
                        if($osalida->estado_ID==58){
                            $osalida->estado_ID=30;
                            $osalida->usuario_mod_id=$_SESSION['usuario_ID'];
                            $osalida->actualizar();
                        }
                    }
                   
                }
                
            }else {
                //Si ya existe factura
                $dtFactura_Venta=factura_venta::getGrid('salida_ID='.$ID,-1,-1,'ID asc');
                //var_dump($dtFactura_Venta);
                $n=0;
                if($electronico>0){
                    $numero_pagina=1;  
                    
                }else{
                    $numero_pagina=$osalida->numero_pagina;
                    
                }
                $arrayProductoFactura=explode("/",$osalida->nproducto_pagina);
                for ($i=0;$i<$numero_pagina;$i++){
                    $arrayFactura=array();
                    foreach ($dtFactura_Venta as $item) {
                        array_push($arrayFactura,$item['ID']);
                    }
                    if(isset($arrayFactura[$i])){
                        $factura_venta_ID=$arrayFactura[$i];
                        $oFactura_Venta=factura_venta::getByID($factura_venta_ID);
                        if($electronico>0){
                            
                            $nproducto_pagina=salida_detalle::getcount("salida_ID=".$ID." and tipo_ID in (1,2,5,6)");
                        }else{
                           $nproducto_pagina=$arrayProductoFactura[$i];

                        }
                     
                        if($oFactura_Venta->estado_ID==35){
                            $oFactura_Venta->serie=$serie;
                            $oFactura_Venta->correlativos_ID=$correlativos_ID;
                            $numero_temporal=correlativos::getNumero($correlativos_ID)+$i;
                            $numero_concatenado=sprintf("%'.07d",$numero_temporal);


                            $oFactura_Venta->salida_ID=$salida_ID;
                            $oFactura_Venta->numero=$numero_temporal;
                            $oFactura_Venta->numero_concatenado=$numero_concatenado;
                            $oFactura_Venta->fecha_emision=$Fecha_Emision;
                            $oFactura_Venta->forma_pago_ID=$osalida->forma_pago_ID;
                            $oFactura_Venta->plazo_factura=$Plazo_Factura;
                            $oFactura_Venta->fecha_vencimiento=$Fecha_Vencimiento;
                            //$oFactura_Venta->estado_ID=34;
                            $oFactura_Venta->moneda_ID=$Moneda_ID;
                            $oFactura_Venta->numero_orden_compra=$numero_orden_compra;
                            $oFactura_Venta->numero_orden_venta=$orden_compra;
                            $oFactura_Venta->opcion=$opcion;
                            $oFactura_Venta->numero_producto=$nproducto_pagina;
                            $oFactura_Venta->usuario_mod_id=$_SESSION['usuario_ID'];
                            $oFactura_Venta->ver_descripcion=$ver_descripcion;
                            //$oFactura_Venta->con_guia=$con_guia;

                            $oFactura_Venta->actualizar();

                            /*=====Actualizacion la factura_venta_detalle*/
                            $dtFactura_Venta_Detalle=factura_venta_detalle::getGrid('factura_venta_ID='.$oFactura_Venta->ID);
                            foreach($dtFactura_Venta_Detalle as $valor){
                                $oFactura_Venta_Detalle=factura_venta_detalle::getByID($valor['ID']);
                                $oFactura_Venta_Detalle->usuario_mod_id=$_SESSION['usuario_ID'];
                                $oFactura_Venta_Detalle->eliminar();
                            }
                            $oFactura_Venta_Detalle=new factura_venta_detalle();
                            $oFactura_Venta_Detalle->factura_venta_ID=$factura_venta_ID;
                            $oFactura_Venta_Detalle->usuario_id=$_SESSION['usuario_ID'];
                            $dtsalida_Detalle=salida_detalle::getGridLista("ovd.salida_ID=".$salida_ID. ' and ovd.tipo_ID in (1,2,5,6)',$n,$arrayProductoFactura[$i],"ovd.ID asc");
                            foreach($dtsalida_Detalle as $value){
                                $oFactura_Venta_Detalle->impuestos_tipo_ID=$impuestos_tipo_ID;
                                $oFactura_Venta_Detalle->salida_detalle_ID=$value['ID'];
                                $oFactura_Venta_Detalle->ver_descripcion=$ver_descripcion;
                                $oFactura_Venta_Detalle->insertar();
                            }
                            actualizarCostosFactura($oFactura_Venta);
                            $oFactura_Venta->ver_vista_previa =1;
                            $oFactura_Venta->ver_imprimir=1;
                            if($electronico>0){
                                
                                $oFactura_Venta->ver_imprimir=0;
                                $oFactura_Venta->ver_enviar_SUNAT=1;
                                $oCorrelativos=correlativos::getByID($correlativos_ID);
                                $oCorrelativos->ultimo_numero=$oCorrelativos->ultimo_numero+1;
                                $oCorrelativos->usuario_mod_id=$_SESSION['usuario_ID'];
                                $oCorrelativos->actualizar();
                                //Actualzimos el estado de la factura
                                $oFactura_Venta->estado_ID=93;
                                $oFactura_Venta->usuario_mod_id=$_SESSION['usuario_ID'];
                                $oFactura_Venta->actualizar();
                                $osalida->estado_ID=40;
                                $osalida->usuario_mod_id=$_SESSION['usuario_ID'];
                                $osalida->actualizar();
                            }

                        }
                    }
                    $n=$n+$arrayProductoFactura[$i];
                }
            }
        $resultado=1;
        $mensaje="Se generó correctamente.";
        }catch(Exception $ex){
          $resultado=-1;
          $mensaje=mensaje_error;
          log_error(__FILE__,"salida/post_Orden_Venta_Mantenimiento_Factura",$ex->getMessage());
        }
        $osalida->serie=$serie;
        $GLOBALS['facturas_informacion']=extraer_estructura_facturas($osalida);
        $oEstado=estado::getByID($oFactura_Venta->estado_ID);
        $oFactura_Venta->estado=$oEstado->nombre;
        $oFactura_Venta->dtImpuestos_Tipo=$dtImpuestos_Tipo;
        $dtsalida_Detalle=salida_detalle::getGrid('salida_ID='.$salida_ID . " and salida_detalle_ID=0 and obsequio=0");
        $listaproducto=mostrar_productos($salida_ID,3);
        $oFactura_Venta->comprobante=$comprobante;
        $dtSerie=correlativos::getGridCorrelativos("venta",0);

        $oFactura_Venta->dtSerie=$dtSerie;
        $GLOBALS['oFactura_Venta']=$oFactura_Venta;
        $GLOBALS['oOrden_Venta']=$osalida;
        $GLOBALS['listaproducto']=$listaproducto;
        $GLOBALS['resultado']=$resultado;
        $GLOBALS['mensaje']=$mensaje;
        $GLOBALS['selComprobantes']=$dtComprobantes;
    }
    function post_ajaxQuitarGuia(){
        require ROOT_PATH . 'models/salida.php';
        require ROOT_PATH . 'models/guia_venta.php';
        require ROOT_PATH . 'models/guia_venta_numero.php';
        require ROOT_PATH . 'models/factura_venta.php';
        $salida_ID=$_POST['id'];
        $mensaje="";
        $osalida=salida::getByID($salida_ID);
        $dtFactura_Venta=factura_venta::getGrid('salida_ID='.$salida_ID,-1,-1,'ID asc');
        $factura_venta_IDs="";
        if(count($dtFactura_Venta)>0){
            $i=0;
            foreach($dtFactura_Venta as $item){
                if($i==0){
                    $factura_venta_IDs=$item['ID'];
                }else {
                    $factura_venta_IDs.=','.$item['ID'];
                }

            }
        }
        if($factura_venta_IDs!=""){
            $dtGuia_Venta_Numero=guia_venta_numero::getGrid('factura_venta_ID in ('.$factura_venta_IDs.')',-1,-1,"ID asc");
            if(count($dtGuia_Venta_Numero)>0){
                foreach($dtGuia_Venta_Numero as $value){
                    $oGuia_Venta=guia_venta::getByID($value['guia_venta_ID']);
                    if($oGuia_Venta->estado_ID==38 ||$oGuia_Venta->estado_ID==44||$oGuia_Venta->estado_ID==39 ){
                        $mensaje="No se puede quitar la guía, ha sido emitida.";
                        $resultado=0;
                    }else {
                        $oGuia_Venta_Numero=guia_venta_numero::getByID($value['ID']);
                        $oGuia_Venta_Numero->usuario_mod_id=$_SESSION['usuario_ID'];
                        $oGuia_Venta_Numero->eliminar();
                        $oGuia_Venta->usuario_mod_id=$_SESSION['usuario_ID'];
                        $oGuia_Venta->eliminar();
                        //Liberamos la impresora
                        $osalida->liberarImpresora();
                        $mensaje="Se Quitó la guía y se liberó la impresora.";
                        $resultado=1;
                    }
                }
            }else {
                $osalida->liberarImpresora();
                $mensaje="Se Quitó la guía y se liberó la impresora.";
                $resultado=1;
            }
        }
        $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);
        echo json_encode($retornar);
    }
    function post_ajaxExtraer_Estructura_Facturas(){
        require ROOT_PATH . 'models/salida.php';
        $osalida=salida::getByID($_POST['id']);
        $serie=$_POST['id1'];

        try{
            $osalida->serie=$serie;
            $html=extraer_estructura_facturas($osalida);

        }catch(Exection $ex){
           $html=$ex->getMessage();

        }

        $retornar=Array('html'=>$html);
        echo json_encode($retornar);

    }
    function extraer_estructura_facturas($osalida){
        if(!class_exists('salida_detalle')){
            require ROOT_PATH . 'models/salida_detalle.php';
        }
        if(!class_exists('correlativos')){
            require ROOT_PATH . 'models/correlativos.php';
        }
         if(!class_exists('factura_venta')){
            require ROOT_PATH . 'models/factura_venta.php';
        }
        if(!class_exists('configuracion_empresa')){
            require ROOT_PATH . 'models/configuracion_empresa.php';
        }
        $dtConfiguracion_Empresa=configuracion_empresa::getGrid();
        $html="<table class='table table-bordered table-hover'>";
        $html.="<thead><th>Nro</th><th>Serie</th><th>Nro. Factura</th><th>Items x factura </th><th>Sub Total</th><th>IGV</th><th>Total</th><th>Observación</th></thead>";
        $html.="<tbody>";
        try{
            $contar_factura=factura_venta::getCount("salida_ID=".$osalida->ID);
            $electronico=0;
            $array=explode("/",$osalida->nproducto_pagina);
            if($electronico>0){
                $osalida->numero_pagina=1;
            }
            $emitidos=0;
            if($contar_factura==0){
                $n=0;
                for($i=0;$i<$osalida->numero_pagina;$i++){
                    $valor=$i+1;
                    $serie=$osalida->serie;
                    $observacion="";
                    $html.="<tr>";
                    $html.="<td class='tdCenter'>".$valor."</td>";
                    $html.="<td class='tdCenter'>".$serie."</td>";
                    $html.="<td class='tdCenter'>". sprintf("%'.07d",correlativos::getNumero(correlativos_ID_fisico)+$i)."</td>";
                    $observacion="Sin Generar";
                    $fin=$array[$i];
                    $total_producto=$array[$i];
                    if($electronico>0){
                        $n=-1;
                        $fin=-1;
                    }
                    $dtsalida_Detalle=salida_detalle::getGridLista("ovd.salida_ID=".$osalida->ID. ' and  ovd.tipo_ID in (1,2,5,6)',$n,$fin,"ovd.ID asc");
                    
                    $html.="<td class='tdCenter'>".(($electronico>0)? count($dtsalida_Detalle):$array[$i])."</td>";
                    
                    $subtotal=0;
                    $vigv=0;
                    $total=0;

                    foreach($dtsalida_Detalle as $value){
                        if($osalida->moneda_ID==1){
                            $subtotal=$subtotal+$value['precio_venta_subtotal_soles'];
                            $vigv=$vigv+$value['vigv_soles'];
                            $total=$total+$value['precio_venta_soles'];
                        }else {
                            $subtotal=$subtotal+$value['precio_venta_subtotal_dolares'];
                            $vigv=$vigv+$value['vigv_dolares'];
                            $total=$total+$value['precio_venta_dolares'];
                        }

                    }
                    $html.="<td class='tdCenter'>".number_format($subtotal,2,'.',',')."</td>";
                    $html.="<td class='tdCenter'>".number_format($vigv,2,'.',',')."</td>";
                    $html.="<td class='tdCenter'>".number_format($total,2,'.',',')."</td>";
                    $html.="<td class='tdCenter'>".$observacion."</td>";
                    $html.="</tr>";

                    $n=$n+$array[$i];
                }
            }else {
                $dtFactura_Venta=factura_venta::getGrid('salida_ID='.$osalida->ID.' and estado_ID in (41,53,93,94)');
                
                $num=1;
                
                foreach ($dtFactura_Venta as $item) {
                    $electronico=0;
                    switch($item['estado_ID']){
                        case 53:
                            $html.="<tr>";
                            $html.="<td class='tdCenter'>".$num."</td>";
                            $html.="<td class='tdCenter'>".$item['serie']."</td>";
                            $html.="<td class='tdCenter'>".$item['numero_concatenado']."</td>";
                            $html.="<td class='tdCenter'>".$item['numero_producto']."</td>";
                            $html.="<td class='tdCenter'>".number_format($item['monto_total_neto'],2,'.',',')."</td>";
                            $html.="<td class='tdCenter'>".number_format($item['monto_total_igv'],2,'.',',')."</td>";
                            $html.="<td class='tdCenter'>".number_format($item['monto_total'],2,'.',',')."</td>";
                            $html.="<td class='tdCenter'>Anulado</td>";
                            $html.="</tr>";
                            $num++;
                            break;
                        case 41:
                            $html.="<tr>";
                            $html.="<td class='tdCenter'>".$num."</td>";
                            $html.="<td class='tdCenter'>".$item['serie']."</td>";
                            $html.="<td class='tdCenter'>".$item['numero_concatenado']."</td>";
                            $html.="<td class='tdCenter'>".$item['numero_producto']."</td>";
                            $html.="<td class='tdCenter'>".number_format($item['monto_total_neto'],2,'.',',')."</td>";
                            $html.="<td class='tdCenter'>".number_format($item['monto_total_igv'],2,'.',',')."</td>";
                            $html.="<td class='tdCenter'>".number_format($item['monto_total'],2,'.',',')."</td>";
                            $html.="<td class='tdCenter'>Emitido</td>";
                            $html.="</tr>";
                            $num++;
                            $emitidos++;
                            break;
                        case 93:
                            $html.="<tr>";
                            $html.="<td class='tdCenter'>".$num."</td>";
                            $html.="<td class='tdCenter'>".$item['serie']."</td>";
                            $html.="<td class='tdCenter'>".$item['numero_concatenado']."</td>";
                            $html.="<td class='tdCenter'>".$item['numero_producto']."</td>";
                            $html.="<td class='tdCenter'>".number_format($item['monto_total_neto'],2,'.',',')."</td>";
                            $html.="<td class='tdCenter'>".number_format($item['monto_total_igv'],2,'.',',')."</td>";
                            $html.="<td class='tdCenter'>".number_format($item['monto_total'],2,'.',',')."</td>";
                            $html.="<td class='tdCenter'>Generado electrónico</td>";
                            $html.="</tr>";
                            $num++;
                            $emitidos++;
                            break;
                        case 94:
                            $html.="<tr>";
                            $html.="<td class='tdCenter'>".$num."</td>";
                            $html.="<td class='tdCenter'>".$item['serie']."</td>";
                            $html.="<td class='tdCenter'>".$item['numero_concatenado']."</td>";
                            $html.="<td class='tdCenter'>".$item['numero_producto']."</td>";
                            $html.="<td class='tdCenter'>".number_format($item['monto_total_neto'],2,'.',',')."</td>";
                            $html.="<td class='tdCenter'>".number_format($item['monto_total_igv'],2,'.',',')."</td>";
                            $html.="<td class='tdCenter'>".number_format($item['monto_total'],2,'.',',')."</td>";
                            $html.="<td class='tdCenter'>Emitido SUNAT</td>";
                            $html.="</tr>";
                            $num++;
                            $emitidos++;
                            break;
                        
                    }
                    
                }
                $dtFactura_Venta1=factura_venta::getGrid('salida_ID='.$osalida->ID.' and estado_ID=35');
                $arrayFactura=array();
                foreach($dtFactura_Venta1 as $item1 ){
                     array_push($arrayFactura,$item1['ID']);
                }
                $n=0;
                if($emitidos==0){
                    if($electronico>0){
                        $osalida->numero_pagina=1;
                    }
                    for($i=0;$i<$osalida->numero_pagina;$i++){
                    $valor=$i+1;
                    $observacion="";
                    $serie=$osalida->serie;
                    $numero='';
                    $registro_porgenerar="";
                    if(isset($arrayFactura[$i])){

                        $oFactura_Venta=factura_venta::getByID($arrayFactura[$i]);
                        
                        if($osalida->estado_ID==58){
                            $numero=correlativos::getNumero($oFactura_Venta->correlativos_ID)+$i;
                            $observacion="Por generar x anulación";
                        }else {
                            $serie=$oFactura_Venta->serie;
                            $numero=correlativos::getNumero($oFactura_Venta->correlativos_ID)+$i;
                            $observacion="Generado";

                        }

                    }else {
                        $dtFactura=factura_venta::getGrid("fv.salida_ID=".$osalida->ID,-1,-1,"fv.ID desc");
                        if(count($dtFactura)>0 &&$dtFactura[0]['estado_ID']==53){
                             $numero=correlativos::getNumero($dtFactura[0]['correlativos_ID'])+$i;
                            $oCorrelativos=correlativos::getByID($dtFactura[0]['correlativos_ID']);
                        }else{
                            $numero=correlativos::getNumero(correlativos_ID_fisico)+$i;
                            $oCorrelativos=correlativos::getByID(correlativos_ID_fisico);
                        }
                        
                        $serie=$oCorrelativos->serie;
                        $observacion="Por generar";
                    }
                    $html.="<tr>";
                    $html.="<td class='tdCenter'>".$valor."</td>";
                    $html.="<td class='tdCenter'>".$serie."</td>";
                    $html.="<td class='tdCenter'>". sprintf("%'.07d",$numero)."</td>";
                    $total=$array[$i];
                    if($electronico>0){
                        $n=-1;
                        $total=-1;
                        
                    }
                    $dtsalida_Detalle=salida_detalle::getGridLista("ovd.salida_ID=".$osalida->ID. ' and  ovd.tipo_ID in (1,2,5,6)',$n,$total,"ovd.ID asc");
                    $html.="<td class='tdCenter'>".(($electronico>0)? count($dtsalida_Detalle):$array[$i])."</td>";
                    
                    $subtotal=0;
                    $vigv=0;
                    $total=0;

                    foreach($dtsalida_Detalle as $value){
                        if($osalida->moneda_ID==1){
                            $subtotal=$subtotal+$value['precio_venta_subtotal_soles'];
                            $vigv=$vigv+$value['vigv_soles'];
                            $total=$total+$value['precio_venta_soles'];
                        }else {
                            $subtotal=$subtotal+$value['precio_venta_subtotal_dolares'];
                            $vigv=$vigv+$value['vigv_dolares'];
                            $total=$total+$value['precio_venta_dolares'];
                        }

                    }
                    $html.="<td class='tdCenter'>".number_format($subtotal,2,'.',',')."</td>";
                    $html.="<td class='tdCenter'>".number_format($vigv,2,'.',',')."</td>";
                    $html.="<td class='tdCenter'>".number_format($total,2,'.',',')."</td>";
                    $html.="<td class='tdCenter'>".$observacion."</td>";
                    $html.="</tr>";

                    $n=$n+$array[$i];
                }
                }


            }



        }catch(Exection $ex){
           $html.="<tr><td colspan='7'>".$ex->getMessage()."</td></tr>";
        }
        $html.="</tbody>";
        $html.="</table>";
        return $html;
    }
    function extraer_estructura_guias($osalida){
        if(!class_exists('salida_detalle')){
            require ROOT_PATH . 'models/salida_detalle.php';
        }
        if(!class_exists('correlativos')){
            require ROOT_PATH . 'models/correlativos.php';
        }
        if(!class_exists('guia_venta')){
            require ROOT_PATH . 'models/guia_venta.php';
        }
        if(!class_exists('factura_venta')){
            require ROOT_PATH . 'models/factura_venta.php';
        }
        $html="<table class='table table-hover table-bordered'>";
        $html.="<thead><th>Nro</th><th>Serie</th><th>Nro.Guía</th><th>Factura</th><th>Items x Guia </th><th>Observación</th></tr></thead>";
        $html.="<tbody>";
        $comprobante_tipo_ID=5;
        try{
            $contar_guia=guia_venta::getCount("salida_ID=".$osalida->ID);
            $array=explode("/",$osalida->nproducto_pagina);
            $emitidos=0;
            $anulados=0;
            $dtFactura_Venta=factura_venta::getGrid('salida_ID='.$osalida->ID.' and estado_ID in (35,41,93,94)',-1,-1,'ID asc');
            $array_facturas=array();
            foreach($dtFactura_Venta as $valor){
                array_push($array_facturas,$valor['ID']);
            }
            if($contar_guia==0){
                $n=0;
                for($i=0;$i<$osalida->numero_pagina;$i++){
                    $valor=$i+1;
                    $serie='001';
                    $observacion="";
                    $html.="<tr>";
                    $html.="<td class='tdCenter'>".$valor."</td>";
                    $html.="<td class='tdCenter'>".$serie."</td>";
                    $html.="<td class='tdCenter'>". sprintf("%'.07d",correlativos::getNumero(correlativos_ID_guia_fisico))."</td>";
                    $numero_factura='';
                    if($array_facturas[$i]){
                        $oFactura_Venta=factura_venta::getByID($array_facturas[$i]);
                        $numero_factura=$oFactura_Venta->numero_concatenado;
                    }
                    $html.="<td class='tdCenter'>".$oFactura_Venta->serie.' N° '. $numero_factura."</td>";
                    $observacion="Sin Generar";

                    $html.="<td class='tdCenter'>".$array[$i]."</td>";

                    $html.="<td class='tdCenter'>".$observacion."</td>";
                    $html.="</tr>";

                    $n=$n+$array[$i];
                }
            }else {
                $dtGuia_Venta=guia_venta::getGrid('salida_ID='.$osalida->ID.' and estado_ID in (38,39)');

                $num=1;
                foreach ($dtGuia_Venta as $item) {
                    $oGuia_Venta=guia_venta::getByID($item['ID']);
                    $oFactura_Venta=factura_venta::getByID($item['factura_venta_ID']);
                    $observacion="";
                    if($item['estado_ID']==38){
                       $observacion="Emitido";
                        $emitidos++;

                        $html.="<tr>";
                        $html.="<td class='tdCenter'>".$num."</td>";
                        $html.="<td class='tdCenter'>".$item['serie']."</td>";
                        $html.="<td class='tdCenter'>". sprintf("%'.07d",$item['numero'])."</td>";
                        $html.="<td class='tdCenter'>".$oFactura_Venta->serie.' N° '. $oFactura_Venta->numero_concatenado."</td>";
                        $html.="<td class='tdCenter'>".$item['numero_producto']."</td>";
                        $html.="<td class='tdCenter'>".$observacion."</td>";
                        $html.="</tr>";

                        $num++;
                    }else if($item['estado_ID']==39){
                        $observacion="Anulado";
                        $html.="<tr>";
                        $html.="<td class='tdCenter'>".$num."</td>";
                        $html.="<td class='tdCenter'>".$item['serie']."</td>";
                        $html.="<td class='tdCenter'>". sprintf("%'.07d",$item['numero'])."</td>";
                        $html.="<td class='tdCenter'>".$oFactura_Venta->serie.' N° '. $oFactura_Venta->numero_concatenado."</td>";
                        $html.="<td class='tdCenter'>".$item['numero_producto']."</td>";
                        $html.="<td class='tdCenter'>".$observacion."</td>";
                        $html.="</tr>";
                        $anulados++;

                    }

                }


                if($emitidos==0){
                   if($anulados==0){
                        $dtGuia_Venta1=guia_venta::getGrid('salida_ID='.$osalida->ID.' and estado_ID=37');
                        $arrayGuia=array();
                        foreach($dtGuia_Venta1 as $item1 ){
                            array_push($arrayGuia,$item1['ID']);
                        }
                        $n=0;
                        for($i=0;$i<$osalida->numero_pagina;$i++){
                            $valor=$i+1;
                            $observacion="";
                            $serie=$osalida->serie;
                            $numero='';
                            $numero_factura='';
                            if(isset($arrayGuia[$i])){

                                $oGuia_Venta=guia_venta::getByID($arrayGuia[$i]);
                                $oFactura_Venta=factura_venta::getByID($oGuia_Venta->factura_venta_ID);
                                $serie=$oGuia_Venta->serie;
                                //$numero=correlativos::getByNumero($comprobante_tipo_ID,$serie)+$i;
                                $numero=correlativos::getNumero($oGuia_Venta->correlativos_ID)+$i;
                                $observacion="Generado";


                            }else {

                                $numero=correlativos::getNumero($oFactura_Venta->correlativos_ID);
                                $observacion="Por generar";

                            }
                            if($array_facturas[$i]){
                                $oFactura_Venta=factura_venta::getByID($array_facturas[$i]);
                                $numero_factura=$oFactura_Venta->numero_concatenado;
                            }
                            $html.="<tr>";
                            $html.="<td class='tdCenter'>".$valor."</td>";
                            $html.="<td class='tdCenter'>".$serie."</td>";
                            $html.="<td class='tdCenter'>". sprintf("%'.07d",$numero)."</td>";
                            $html.="<td class='tdCenter'>".$oFactura_Venta->serie.' N° '. $numero_factura."</td>";
                            $html.="<td class='tdCenter'>".$array[$i]."</td>";
                            $html.="<td class='tdCenter'>".$observacion."</td>";
                            $html.="</tr>";

                            $n=$n+$array[$i];
                        }
                   }else {
                       $n=0;
                       $dtGuia_Venta1=guia_venta::getGrid('salida_ID='.$osalida->ID);

                       foreach($dtGuia_Venta1 as $value){
                           $guia_venta_ID=$value['ID'];
                       }
                       if(isset($guia_venta_ID)){
                           $oGuia_venta1=guia_venta::getByID($guia_venta_ID);
                           $oFactura_Venta1=factura_venta::getByID($oGuia_venta1->factura_venta_ID);
                           for($i=0;$i<$osalida->numero_pagina;$i++){
                                $valor=$i+1;
                                $serie=$oGuia_venta1->serie;


                                $html.="<tr>";
                                $html.="<td class='tdCenter'>".$valor."</td>";
                                $html.="<td class='tdCenter'>".$serie."</td>";
                                $html.="<td class='tdCenter'>". sprintf("%'.07d",correlativos::getNumero($oGuia_venta1->correlativos_ID)+$i)."</td>";

                                $html.="<td class='tdCenter'>".$oFactura_Venta->serie.' N° '. $oFactura_Venta->numero_concatenado."</td>";
                                $observacion="Por generar";
                                if($oGuia_venta1->estado_ID==37){
                                   $observacion="Generado";
                                }


                                $html.="<td class='tdCenter'>".$oGuia_venta1->numero_producto."</td>";

                                $html.="<td class='tdCenter'>".$observacion."</td>";
                                $html.="</tr>";

                            }
                       }

                   }

                }
            }

        }catch(Exection $ex){
           $html.="<tr><td colspan='5'>".$ex->getMessage()."</td></tr>";
        }
        $html.="</tbody>";
        $html.="</table>";
        return $html;
    }

    function actualizarCostosFactura($oFactura_Venta){
        $dtFactura_Venta_Detalle=factura_venta_detalle::getGrid1('fvd.factura_venta_ID='.$oFactura_Venta->ID,-1,-1);
        $subtotal=0;
        $vigv=0;
        $total=0;
        foreach($dtFactura_Venta_Detalle as $value){
            if($value['moneda_ID']==1){
                $subtotal=$subtotal+$value['precio_venta_subtotal_soles'];
                $vigv=$vigv+$value['vigv_soles'];
                $total=$total+$value['precio_venta_soles'];
            }else {
                $subtotal=$subtotal+$value['precio_venta_subtotal_dolares'];
                $vigv=$vigv+$value['vigv_dolares'];
                $total=$total+$value['precio_venta_dolares'];
            }

        }

        $oFactura_Venta->monto_total_neto=$subtotal;
        $oFactura_Venta->monto_total_igv=$vigv;
        $oFactura_Venta->monto_total=$total;
        $oFactura_Venta->monto_pendiente=$total;
        $oFactura_Venta->actualizarCostos();
    }
    function get_Orden_Venta_Mantenimiento_Guia($id){
        require ROOT_PATH . 'models/salida.php';
        require ROOT_PATH . 'models/salida_detalle.php';
        require ROOT_PATH . 'models/producto.php';
        require ROOT_PATH . 'models/factura_venta.php';
        require ROOT_PATH . 'models/guia_venta.php';
        if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";;
        require ROOT_PATH . 'models/moneda.php';
        require ROOT_PATH . 'models/usuario.php';
        require ROOT_PATH . 'models/vehiculo.php';
        require ROOT_PATH . 'models/chofer.php';
        require ROOT_PATH . 'models/correlativos.php';
        require ROOT_PATH . 'models/serie.php';
        require ROOT_PATH . 'models/estado.php';
        require ROOT_PATH . 'models/cliente.php';
        global  $returnView_float;
        $returnView_float=true;
        $salida_ID=$id;
        $comprobante_tipo_ID=5;
        $osalida=salida::getByID($salida_ID);

        $listaproducto=mostrar_productos($salida_ID,3);
        $contador_guia=guia_venta::getCount('salida_ID='.$id);
        $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
        $dtFactura_Venta=factura_venta::getGrid('salida_ID='.$id,-1,-1,'ID asc');
        $array_facturas=array();
        foreach($dtFactura_Venta as $valor){
            array_push($array_facturas,$valor['ID']);
        }

        $mensaje="";
        $informacion="";
        if($contador_guia==0){
            $oGuia_Venta=new guia_venta();
            if($array_facturas[0]){
                $oFacutura_Venta=factura_venta::getByID($array_facturas[0]);
                $oGuia_Venta->numero_orden_compra=$oFacutura_Venta->numero_orden_compra;
                $oGuia_Venta->numero_orden_venta=$oFacutura_Venta->numero_orden_venta;
                $oGuia_Venta->ver_descripcion=$oFacutura_Venta->ver_descripcion;
            }
            $osalida->serie='001';
            $oGuia_Venta->ID=0;
            $oGuia_Venta->serie='001';
            $oGuia_Venta->fecha_emision=date("d/m/Y");
            //$oGuia_Venta->moneda_ID=$osalida->moneda_ID;
            $numero_temporal=correlativos::getNumero(correlativos_ID_guia_fisico);
            $oGuia_Venta->numero=$numero_temporal;
            $numero_concatenado=sprintf("%'.07d",$numero_temporal);
            $oGuia_Venta->numero_concatenado=$numero_concatenado;
            $oGuia_Venta->vehiculo_ID=0;
            $oGuia_Venta->chofer_ID=0;
            $oGuia_Venta->empresa_transporte=$oDatos_Generales->razon_social;
            $oGuia_Venta->punto_partida=$oDatos_Generales->direccion;
            $oCliente=cliente::getByID($osalida->cliente_ID);
            $oGuia_Venta->punto_llegada=$oCliente->direccion;
            $oGuia_Venta->ver_vista_previa=0;
            $oGuia_Venta->ver_imprimir=0;
            $oGuia_Venta->correlativos_ID=correlativos_ID_guia_fisico;
            $oEstado=estado::getByID(37);
        }else {

            $dtGuia_Venta=guia_venta::getGrid('salida_ID='.$id,-1,-1,'ID asc');
            foreach ($dtGuia_Venta as $value) {
                $guia_ID=$value['ID'];

            }
            $oGuia_Venta=guia_venta::getByID($guia_ID);
            $oGuia_Venta->ver_descripcion=$dtFactura_Venta[0]['ver_descripcion'];
            $oGuia_Venta->ver_adicional=$dtFactura_Venta[0]['ver_adicional'];
            $oGuia_Venta->ver_componente=$dtFactura_Venta[0]['ver_componente'];
            $oGuia_Venta->ver_serie=$dtFactura_Venta[0]['ver_serie'];
            $oEstado=estado::getByID($oGuia_Venta->estado_ID);
            switch($oGuia_Venta->estado_ID){
                case 37:
                    //Guia registrado
                    $numero_temporal=correlativos::getNumero($oGuia_Venta->correlativos_ID);
                    $numero_concatenado=sprintf("%'.07d",$numero_temporal);
                    $oGuia_Venta->numero_concatenado=$numero_concatenado;

                    $oGuia_Venta->ver_vista_previa=1;
                    $oGuia_Venta->ver_imprimir=1;
                    break;
                case 38:
                    //Guia emitido
                    $oGuia_Venta->ver_vista_previa=1;
                    $oGuia_Venta->ver_imprimir=1;


                    break;
                case 39:
                    //Guia anulado
                    $numero_temporal=correlativos::getNumero($oGuia_Venta->correlativos_ID);
                    $numero_concatenado=sprintf("%'.07d",$numero_temporal);
                    $oGuia_Venta->numero_concatenado=$numero_concatenado;

                    $oGuia_Venta->ver_vista_previa=1;
                    $oGuia_Venta->ver_imprimir=1;
                    break;

            }


        }
        $oGuia_Venta->estado=$oEstado->nombre;
        $oGuia_Venta->dtVehiculo=vehiculo::getGrid('',-1,-1,'descripcion asc');
        $oGuia_Venta->dtChofer=chofer::getGrid('',-1,-1,'pe.apellido_paterno asc, pe.apellido_materno asc, pe.nombres asc');
        $informacion=extraer_estructura_guias($osalida);
       // $dtSerie=serie::getGrid('se.comprobante_tipo_ID=4',-1,-1,'se.nombre');
        $dtSerie=correlativos::getGridCorrelativos("guia_remision", 0);
        $oGuia_Venta->dtSerie=$dtSerie;
        //$osalida=salida::getByID($salida_ID);
        $GLOBALS['facturas_informacion']=$informacion;

        $GLOBALS['oGuia_Venta']=$oGuia_Venta;
        $GLOBALS['oOrden_Venta']=$osalida;
        $GLOBALS['listaproducto']=$listaproducto;


    }
    function post_Orden_Venta_Mantenimiento_Guia($id){
        require ROOT_PATH . 'models/salida.php';
        require ROOT_PATH . 'models/salida_detalle.php';
        require ROOT_PATH . 'models/producto.php';
        require ROOT_PATH . 'models/factura_venta.php';
        require ROOT_PATH . 'models/factura_venta_detalle.php';
        require ROOT_PATH . 'models/guia_venta.php';
        require ROOT_PATH . 'models/guia_venta_detalle.php';
        if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";;
        require ROOT_PATH . 'models/chofer.php';
        require ROOT_PATH . 'models/vehiculo.php';
        require ROOT_PATH . 'models/moneda.php';
        require ROOT_PATH . 'models/estado.php';
        require ROOT_PATH . 'models/correlativos.php';
        require ROOT_PATH . 'models/serie.php';
        global  $returnView_float;
        $returnView_float=true;
        $salida_ID=$id;
        //$ID=$_POST['txtID'];
        //$factura_venta_ID=$_POST['txtFactura_ID'];
        $fecha_emision=$_POST['txtFecha_Emision'];
        $opcion=0;
        if(isset($_POST['ckOpcion'])){
            $opcion=$_POST['ckOpcion'];
        }
        $correlativos_ID=$_POST['selSerie'];
        $numero=$_POST['txtNumero'];
        $fecha_inicio_traslado=$_POST['txtFecha_Inicio_Traslado'];
        $punto_partida= $_POST['txtPunto_Partida'];
        $punto_llegada=$_POST['txtPunto_Llegada'];
        if(isset($_POST['selVehiculo_ID'])){
            $vehiculo_ID=$_POST['selVehiculo_ID'];
        }else {$vehiculo_ID='NULL';}
        if(isset($_POST['selChofer_ID'])){
            $chofer_ID=$_POST['selChofer_ID'];
        }else {
            $chofer_ID="NULL";
        }

        $empresa_transporte=$_POST['txtEmpresa_Transporte'];
        $numero_orden_compra=$_POST['txtOrden_Compra'];
        $numero_orden_venta=$_POST['txtOrden_Pedido'];
        $ver_descripcion=$_POST['ckVerDescripcion'];
        try{

            $comprobante_tipo_ID=5;
            $osalida=salida::getByID($id);

            $contador_factura_emitido=factura_venta::getCount('salida_ID='.$salida_ID.' and estado_ID in (35,41,93,94)');
            if($contador_factura_emitido>0){
                $dtFactura_Venta=factura_venta::getGrid('salida_ID='.$salida_ID.' and estado_ID in (35,41,93,94)',-1,-1,'ID asc');
                $contador_guia=guia_venta::getCount('salida_ID='.$salida_ID.' and estado_ID in(37)');
                $dtGuia_Venta=guia_venta::getGrid('salida_ID='.$salida_ID.' and estado_ID in (37)');
                $array_guia= array();
                foreach($dtGuia_Venta as $item){
                    array_push($array_guia,$item['ID']);
                    
                }
                $i=0;
                foreach($dtFactura_Venta as $value){
                   if($contador_guia>0){
                       $oGuia_Venta=guia_venta::getByID($array_guia[$i]);

                   }else {
                       $oGuia_Venta=new guia_venta();
                   }
                     $i++;
                    $numero=correlativos::getNumero($correlativos_ID);
                    $oCorrelativos=correlativos::getByID($correlativos_ID);
                    $oGuia_Venta->correlativos_ID=$correlativos_ID;
                    $oGuia_Venta->serie=$oCorrelativos->serie;
                    $oGuia_Venta->numero=$numero;
                    $oGuia_Venta->numero_concatenado=sprintf("%'.07d",$numero);
                    $oGuia_Venta->factura_venta_ID=$value['ID'];
                    $oGuia_Venta->salida_ID=$salida_ID;

                    $oGuia_Venta->fecha_emision=$fecha_emision;
                    $oGuia_Venta->numero_orden_venta=$numero_orden_venta;
                    $oGuia_Venta->numero_orden_compra=$numero_orden_compra;
                    $oGuia_Venta->vehiculo_ID=$vehiculo_ID;
                    $oGuia_Venta->chofer_ID=$chofer_ID;
                    /*Se registra en estado registrado temporal*/

                    //$oGuia_Venta->numero_pagina=$numero_pagina;

                    $oGuia_Venta->fecha_inicio_traslado=$fecha_inicio_traslado;
                    $oGuia_Venta->punto_partida=$punto_partida;
                    $oGuia_Venta->punto_llegada=$punto_llegada;
                    $oGuia_Venta->empresa_transporte=$empresa_transporte;
                    $oGuia_Venta->opcion=$opcion;
                    $oGuia_Venta->numero_producto=$value['numero_producto'];
                    $oGuia_Venta->ver_descripcion=$ver_descripcion;
                    if($contador_guia>0){
                        $oGuia_Venta->usuario_mod_id=$_SESSION['usuario_ID'];
                        $oGuia_Venta->actualizar();

                    }else {

                        $oGuia_Venta->estado_ID=37;
                        $oGuia_Venta->usuario_id=$_SESSION['usuario_ID'];
                        $oGuia_Venta->insertar();
                    }


                   //Registramos los detalles


                    $dtGuia_Venta_Detalle=guia_venta_detalle::getGrid('guia_venta_ID='.$oGuia_Venta->ID);
                    foreach($dtGuia_Venta_Detalle as $valor){
                        $oGuia_Venta_Detalle=guia_venta_detalle::getByID($valor['ID']);
                        $oGuia_Venta_Detalle->usuario_mod_id=$_SESSION['usuario_ID'];
                        $oGuia_Venta_Detalle->eliminar();
                    }
                    // Registramos los valores

                    $oGuia_Venta_Detalle=new guia_venta_detalle();
                    $oGuia_Venta_Detalle->guia_venta_ID=$oGuia_Venta->ID;
                    $oGuia_Venta_Detalle->usuario_id=$_SESSION['usuario_ID'];
                    $dtFactua_Venta_Detalle=factura_venta_detalle::getGrid('factura_venta_ID='.$value['ID']);
                    foreach($dtFactua_Venta_Detalle as $valores){
                        $oGuia_Venta_Detalle->salida_detalle_ID=$valores['salida_detalle_ID'];
                        $oGuia_Venta_Detalle->ver_componente=$valores['ver_componente'];
                        $oGuia_Venta_Detalle->ver_descripcion=$valores['ver_descripcion'];
                        $oGuia_Venta_Detalle->ver_adicional=$valores['ver_adicional'];
                        $oGuia_Venta_Detalle->ver_serie=$valores['ver_serie'];
                        $oGuia_Venta_Detalle->insertar();
                    }

                    $oGuia_Venta->ver_imprimir=1;
                    $oGuia_Venta->ver_vista_previa=1;
                }
                $mensaje='Se generó correctamente';
                $resultado=1;
            }else {
                $mensaje='No puedes generar la guía, la factura no ha sido generada';
                $resultado=-1;
            }



        }catch(Exception $ex){
          $resultado=-1;
          $mensaje=$ex->getMessage();
        }
        $oEstado=estado::getByID($oGuia_Venta->estado_ID);

        $oGuia_Venta->estado=$oEstado->nombre;
        $oGuia_Venta->dtVehiculo=vehiculo::getGrid('',-1,-1,'descripcion asc');
        $oGuia_Venta->dtChofer=chofer::getGrid('',-1,-1,'pe.apellido_paterno asc, pe.nombres asc');
        $informacion=extraer_estructura_guias($osalida);
        $dtSerie=correlativos::getGridCorrelativos("guia_remision", 0);
        $oGuia_Venta->dtSerie=$dtSerie;
        $GLOBALS['facturas_informacion']=$informacion;
        $GLOBALS['oGuia_Venta']=$oGuia_Venta;
        $GLOBALS['oOrden_Venta']=$osalida;
        $GLOBALS['listaproducto']=mostrar_productos($salida_ID,3);
        $GLOBALS['mensaje']=$mensaje;
        $GLOBALS['resultado']=$resultado;
    }
   
    function get_Ventas_Mantenimiento_Guia_Vista_Previa($id){
        require ROOT_PATH . 'models/salida.php';
        require ROOT_PATH . 'models/salida_detalle.php';
        require ROOT_PATH . 'models/salida_numero_cuenta.php';
        require ROOT_PATH . 'models/producto.php';
        require ROOT_PATH . 'models/factura_venta.php';
        require ROOT_PATH . 'models/guia_venta_numero.php';
        require ROOT_PATH . 'models/guia_venta.php';
        if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";;
        require ROOT_PATH . 'models/chofer.php';
        require ROOT_PATH . 'models/vehiculo.php';
        require ROOT_PATH . 'models/cliente.php';
        require ROOT_PATH . 'models/inventario.php';
        global  $returnView_float;
        $returnView_float=true;
        $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
        $oGuia_Venta=guia_venta::getByID($id);
        $oFactura_Venta=factura_venta::getByID($oGuia_Venta->factura_venta_ID);
        $osalida=salida::getByID($oFactura_Venta->salida_ID);
        /*mostramos los productos*/
        $dtGuia_Venta_Numero=guia_venta_numero::getGrid('guia_venta_ID='.$oGuia_Venta->ID);
        $html=mostrar_productos($osalida->ID,2);
        $numero=0;
        $array_numero=array();
        foreach($dtGuia_Venta_Numero as $item2){
            $array=array();
            $array['numero']=$item2['numero'];
            $oFactura_Venta1=factura_venta::getByID($item2['factura_venta_ID']);
            $array['numero_factura']=$oFactura_Venta1->numero;
            array_push($array_numero,$array);

        }
        $oCliente=cliente::getByID($osalida->cliente_ID);
        $oVehiculo=vehiculo::getByID($oGuia_Venta->vehiculo_ID);
        if($oGuia_Venta->vehiculo_ID==0){
            $oVehiculo->marca="";
            $oVehiculo->placa="";
        }

        $oChofer=chofer::getByID($oGuia_Venta->chofer_ID);
        if($oGuia_Venta->chofer_ID==0){
            $oChofer->licencia_conducir="";
        }
        $GLOBALS['html']=$html;

        $GLOBALS['oDatos_Generales']=$oDatos_Generales;
        $GLOBALS['oGuia_Venta']=$oGuia_Venta;
        $GLOBALS['osalida']=$osalida;

        $GLOBALS['numeros']= $array_numero;
        //$GLOBALS['numero']=$numero;
        $GLOBALS['oCliente']=$oCliente;
        $GLOBALS['oVehiculo']=$oVehiculo;
        $GLOBALS['oChofer']=$oChofer;
        $GLOBALS['oFactura_Venta']=$oFactura_Venta;

    }
    function get_Orden_Venta_Mantenimiento_Factura_Vista_Previa($id){
        require ROOT_PATH.'models/salida.php';
        require ROOT_PATH.'models/factura_venta.php';
        require ROOT_PATH.'models/correlativos.php';
        global $returnView_float;
        $returnView_float=true;
        $osalida=salida::getByID($id);
        $dtFactura_Venta=factura_venta::getGrid("fv.salida_ID=".$id);
        $electronico=0;
        if(count($dtFactura_Venta)>0){
           $electronico=correlativos::verificar_electronico($dtFactura_Venta[0]['correlativos_ID']);
            $GLOBALS['factura_venta_ID']=$dtFactura_Venta[0]['ID'];
        }
        $GLOBALS['oOrden_Venta']=$osalida;
        $GLOBALS['electronico']=$electronico;
        
    }

    function get_Factura_Vista_Previa($id){

        require ROOT_PATH.'models/salida.php';
        require ROOT_PATH.'models/factura_venta.php';
        require ROOT_PATH.'models/factura_venta_detalle.php';
        require ROOT_PATH.'models/moneda.php';
        require ROOT_PATH.'models/salida_detalle.php';
        require ROOT_PATH.'models/producto.php';
        if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";;
        require ROOT_PATH . 'models/cliente.php';
        require ROOT_PATH . 'include/lib_fecha_texto.php';
        require ROOT_PATH . 'models/cliente_contacto.php';
        require ROOT_PATH . 'models/forma_pago.php';
        require ROOT_PATH . 'models/operador.php';
        require ROOT_PATH . 'models/salida_numero_cuenta.php';
        require ROOT_PATH.'formatos_pdf/factura_venta.php';
        //global $returnView_float;
        $pdf= new PDF3('P','mm',array(216,279));
        try{
            $osalida=salida::getByID($id);
            $oMoneda=moneda::getByID($osalida->moneda_ID);
            $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
            $oCliente=cliente::getByID($osalida->cliente_ID);
            $oCliente_Contacto=  cliente_contacto::getByID($osalida->cliente_contacto_ID);
            $oForma_Pago=forma_pago::getByID($osalida->forma_pago_ID);
            if($osalida->forma_pago_ID==0){
                $oForma_Pago=new forma_pago();
            }
            if($oForma_Pago==null){

                $oForma_Pago=new forma_pago();
            }
            $oOperador=operador::getByID($osalida->operador_ID);
            if($oOperador==null){
                $oOperador=new operador();
            }
            $dtsalida_Numero_Cuenta=salida_numero_cuenta::getGrid1('ovnc.salida_ID='.$id,-1,-1);
            $dtFactura_Venta=factura_venta::getGrid('salida_ID='.$id.' and estado_ID in (35,41,93,94)',-1,-1);

            $pdf->oOrden_Venta=$osalida;
            $pdf->oDatos_Generales=$oDatos_Generales;
            $pdf->oCliente=$oCliente;
            $pdf->oCliente_Contacto=$oCliente_Contacto;
            $pdf->oMoneda=$oMoneda;
            $pdf->oForma_Pago=$oForma_Pago;
            $pdf->oOperador=$oOperador;
            $pdf->dtOrden_Venta_Numero_Cuenta=$dtsalida_Numero_Cuenta;
            foreach($dtFactura_Venta as $item){
                $oFactura_Venta=factura_venta::getByID($item['ID']);
                $pdf->AddPage();
                $pdf->cabecera($oFactura_Venta);
                $pdf->contenedor_detalle(130,$oFactura_Venta);
                $dtFactura_Venta_Detalle1=factura_venta_detalle::getGrid1('fvd.factura_venta_ID='.$item['ID'],-1,-1,'ovd.ID asc');
                $pdf->SetWidths(array(20,120,25,35));
                $pdf->SetAligns(array('C','L','R','R'));
                $pdf->contenido_detalle($dtFactura_Venta_Detalle1);

            }
            

        }catch(Exception $ex){

        }

    $pdf->Output('I','Factura Nro'.sprintf("%'.07d",'5').'.pdf',true);
}
    
    function mesATexto($mes_numero){

          $mes='';
          switch ($mes_numero) {

            case "01":
                $mes="Enero";
              break;
            case "02":
                $mes="Febrero";
              break;
            case "03":
                $mes="Marzo";
              break;
            case "04":
                $mes="Abril";
              break;
            case "05":
                $mes="Mayo";
              break;
            case "06":
                $mes="Junio";
              break;
            case "07":
                $mes="Julio";
              break;
            case "08":
                $mes="Agosto";
              break;
            case "09":
                $mes="Septiembre";
              break;
            case "10":
                $mes="Octubre";
              break;
            case "11":
                $mes="Noviembre";
              break;
            case "12":
                $mes="Diciembre";
              break;

            default:
                $mes='';
              break;
          }

          return $mes;
        }
    function post_ajaxProbar(){
        $salida_ID=$_POST['id'];
        $array=calcular_estructura_guia($salida_ID,1,1,1,1,1);
       // print_r($array);
        $resultado=1;
        $mensaje='';
        
        $retornar=Array('numero_pagina'=>$array['numero_pagina'],'nproductoxhoja'=>$array['nproductoxhoja'],"IDs"=>$array['IDs']);
       
        echo json_encode($retornar); 
    }
    function calcular_estructura_guia($dt){
        //require ROOT_PATH.'formatos_pdf/plantilla_blanco.php';
        if(!class_exists('FPDF'))require('include/fpdf/fpdf.php');
        //require ROOT_PATH.'models/salida_detalle.php';
        $pdf = new FPDF('P','mm',array(216,800));
        
        try{

            $pdf->AddPage(); 
            $pdf->Ln();
            $pdf->SetFont('Arial','B',8);
            $pdf->SetTextColor(255,255,255);
            $pdf->SetFillColor(117,179,114);
            $pdf->Cell(20,7,utf8_decode('CANT.'),1,0,'C',true);
            $pdf->Cell(15,7,utf8_decode('UM'),1,0,'C',true);
            $pdf->Cell(15,7,utf8_decode('CÓD'),1,0,'C',true);
            $pdf->Cell(100,7,utf8_decode('DESCRIPCIÓN'),1,0,'C',true);
            $pdf->Cell(25,7,utf8_decode('P/U'),1,0,'C',true);
            $pdf->Cell(25,7,utf8_decode('IMPORTE'),1,0,'C',true);
            $array_width=array(20,15,15,100,25,25,100);
            $array_align=array('C','C','C','L','R','R','J');
            $pdf->Ln();
            $y=$pdf->GetY();
            $y_inicio=$y;
            $y1=$y;
            $h_contenedor=60;
            
            $x=10;
            //$dt=salida_detalle::getEstructura($salida_ID,$ver_descripcion,$ver_componente,$ver_adicional,$ver_serie,$incluir_obsequios);
            $pdf->SetTextColor(0,0,0);
            $h_actual=0;
            $alto="";
            $alto_acumulado=0;
            $altostd=0;
            $i=1;
            $contador_producto=1;
            $numero_pagina=0;
            $nproductoxhoja="";
            $suma=0;
            $nproducto=0;
            $n=0;
            $nFilas=count($dt);
            $IDs="";
            foreach($dt as $item){
                $y_ini=$pdf->GetY();
                //$h_atual=$pdf->GetY();
                $pdf->SetXY($x,$y);
                $costo_unitario=number_format($item['precio_unitario'],2,'.',',');
                $pdf->SetFont('Arial','B',8);
                $subtotal=number_format($item['sub_total'],2,'.',',');
                $pdf->MultiCell($array_width[0],5,$item["cantidad"],0,$array_align[0],false);
                $x=$x+$array_width[0];
                $pdf->SetXY($x,$y);
                $pdf->MultiCell($array_width[1],5,$item["unidad_medida"],0,$array_align[1],false);
                $x=$x+$array_width[1];
                $pdf->SetXY($x,$y);
                $pdf->MultiCell($array_width[2],5,$item["codigo"],0,$array_align[2],false);
                $x=$x+$array_width[2];
                $pdf->SetXY($x,$y);
                $c=$pdf->getY();
                $pdf->MultiCell($array_width[3],5,$item["producto"],0,$array_align[3],false);
                $d=$pdf->getY();
                $x=$x+$array_width[3];
                $pdf->SetXY($x,$y);
                $pdf->MultiCell($array_width[4],5,$costo_unitario,0,$array_align[4],false);
                $x=$x+$array_width[4];
                $pdf->SetXY($x,$y);
                $pdf->MultiCell($array_width[5],5,$subtotal,0,$array_align[5],false);
                //$x=$x+$array_width[5];
                $y=$y+($d-$c);
                if($item["descripcion"]!=""){
                    $pdf->SetFont('Arial','',6);
                    $pdf->SetXY(60,$y);
                    $pdf->MultiCell($array_width[6],4,$item["descripcion"],0,$array_align[6],false);
                    $y=$pdf->GetY();
                }
                $x=10;
                //$y1=$y;
                $alto_fila=$pdf->GetY()-$y_ini;
                $altostd=$altostd+$alto_fila;
                $h_actual=$h_actual+$y;
                
                
                if($altostd>=$h_contenedor){
                    if($i==0){
                        $IDs=$item['ID'];
                    }else{
                       $IDs.="|".$item['ID']; 
                    }
                    
                    if($i==$nFilas){
                        
                        if($n>0){
                            
                            $nproductoxhoja=$nproductoxhoja.$n.'/';
                            $numero_pagina=$numero_pagina+1;
                            //nproducto=1;
                            //n=0;
                            $IDs.='|';
                        }
                        $nproducto=1;
                        $nproductoxhoja=$nproductoxhoja.$nproducto;
                        $numero_pagina =$numero_pagina + 1;
                        

                    }else {
                        if($n>0){

                            $nproductoxhoja=$nproductoxhoja.$n.'/';
                            $numero_pagina=$numero_pagina+1;
                            $nproducto=1;
                            $n=1;
                            $altostd=$alto_fila;
                           
                        }else {
                            $nproducto=1;
                            $nproductoxhoja=$nproductoxhoja.$nproducto.'/';
                            //numero_pagina =numero_pagina + 1;
                            $altostd=0;
                           
                        }
                        //numero_pagina =numero_pagina + 1;
                    }
                }else{
                    $n=$n+1;
                    if($i==0){
                        $IDs=$item['ID'];
                    }else{
                       $IDs.=",".$item['ID']; 
                    }
                   
                    if($i==$nFilas){
                        $nproducto=$nproducto+1;
                        $nproductoxhoja=$nproductoxhoja.$n;
                        $numero_pagina =$numero_pagina + 1;
                        
                    }
                    
                }
                $i++;
            }
            $IDs=substr($IDs,1);
            $array=array(
                "numero_pagina"=>$numero_pagina,
                "nproductoxhoja"=>$nproductoxhoja,
                "IDs"=>$IDs
                );
            //$pdf->Cell(50,10,$n.'-'.$y.'('.$nproductoxhoja.'-'.$numero_pagina);
            //$ruta=ruta_archivo."/temp/guia_remision/plantilla_".$_SESSION['empresa_ID']."_".rand(1,500).".pdf";
            //$pdf->Output($ruta,'F');
            return $array;
        }catch(Exception $ex){
            log_error(__FILE__, "Saida/calcular_estructura_guia", $ex->getMessage());
        }
    }
    function post_ajaxImprimir_Factura(){
        require ROOT_PATH . 'models/salida.php';
        require ROOT_PATH . 'models/salida_detalle.php';
        require ROOT_PATH . 'models/producto.php';
        require ROOT_PATH . 'models/factura_venta.php';
        require ROOT_PATH . 'models/factura_venta_detalle.php';
        require ROOT_PATH . 'models/cliente.php';
        require ROOT_PATH . 'models/operador.php';
        require ROOT_PATH . 'include/lib_fecha_texto.php';
        require ROOT_PATH . 'models/salida_numero_cuenta.php';
        require ROOT_PATH . 'models/moneda.php';
        require ROOT_PATH . 'models/correlativos.php';
        $salida_ID=$_POST['orden_venta_ID'];
        $correlativos_ID=$_POST['selSerie'];
        $numero_concatenado=$_POST['txtNumero'];
        $numero_registrado=preg_replace('/^0+/', '', $numero_concatenado);
        try{
            $numero_orden_imprimiendo=verificarImpresora($salida_ID);
            $osalida=salida::getByID($salida_ID);
            if($numero_orden_imprimiendo==""){
                $factura_emitidos=0;

                $dtFactura_Venta=factura_venta::getGrid('salida_ID='.$salida_ID.' and estado_ID in (35,41)',-1,-1,'numero asc');
                foreach($dtFactura_Venta as $item){
                    $oFactura_Venta=factura_venta::getByID($item['ID']);
                    $oCliente=cliente::getByID($osalida->cliente_ID);
                    $oOperador=operador::getByID($osalida->operador_ID);
                    if($oFactura_Venta->estado_ID==35||$oFactura_Venta->estado_ID==41){
                       //Actualizamos el número de la factura
                    if($oFactura_Venta->estado_ID==41){
                        $numero=$numero_registrado;
                        
                        $oFactura_Venta->correlativos_ID=$correlativos_ID;
                        
                    }else{
                        $numero=correlativos::getNumero($oFactura_Venta->correlativos_ID);
                        //$numero_concatenado=sprintf("%'.07d",$numero);
                    }   
                    $osalida->serie=$oFactura_Venta->serie;
                    //$numero=correlativos::getByNumero(3,$oFactura_Venta->serie);
                    
                    $oFactura_Venta->numero=$numero;
                    $oFactura_Venta->numero_concatenado=sprintf("%'.07d",$numero);
                    $oFactura_Venta->estado_ID=41;
                    $oFactura_Venta->usuario_mod_id=$_SESSION['usuario_ID'];
                    $oFactura_Venta->actualizar();
                     //Actualizamos el estado de la factura a estado emitido


                    //Actualizamos el correlativo
                    //$oCorrelativos=correlativos::getBySerie(3,$oFactura_Venta->serie);
                    $oCorrelativos=correlativos::getByID($oFactura_Venta->correlativos_ID);
                    $oCorrelativos->ultimo_numero=$numero;
                    $oCorrelativos->usuario_mod_id=$_SESSION['usuario_ID'];
                    $oCorrelativos->actualizar();
                   }/*elseif($oFactura_Venta->estado_ID==41){
                       $factura_emitidos++;
                   }*/
                    //direccion ip local-nombre de impresora

					//===========================================
                    //$handle = printer_open("Factura");
					$handle = printer_open("PDFCreator");
					//$handle = printer_open("TASKalfa 306ci");
					//========
                    /*printer_set_option($handle, PRINTER_PAPER_LENGTH, 200 );
                    printer_set_option($handle, PRINTER_PAPER_WIDTH , 279 );
                    printer_set_option($handle, PRINTER_SCALE , 100 );
                    printer_set_option($handle, PRINTER_TITLE , 'Factura' );*/
                    printer_start_doc($handle, "Factura");
                    printer_start_page($handle);

                    //Estilos para el contenido
                    $font = printer_create_font("Arial",20,10,300,false,false, false,0);
                    $font_negrita=printer_create_font("Arial",20,10,700,false,false, false,0);
                    $font_moneda=printer_create_font("Arial",20,10,700,false,false, false,0);
                    $font_total=printer_create_font("Arial",25,10,700,false,false, false,0);
                    printer_select_font($handle, $font);

                    //Imprimimos la cabecera
                    $array_fecha=explode('/',$oFactura_Venta->fecha_emision);
                    $dia=strtolower($array_fecha[0]);
                    $mes=mesATexto($array_fecha[1]);
                    $anio=strtolower($array_fecha[2]);

                    //Fecha en text
                    printer_draw_text($handle,$dia,80,375);
                    printer_draw_text($handle,$mes,170,375);
                    printer_draw_text($handle,$anio,440,375);
                    printer_draw_text($handle,$oFactura_Venta->fecha_vencimiento,1300,375);
                    //informacio cliente
                    printer_draw_text($handle,$oCliente->razon_social,160,405);
                    printer_draw_text($handle,$oOperador->nombres.' '.$oOperador->apellido_paterno,1250,405);
                    //
                    printer_draw_text($handle,$oCliente->direccion,160,435);
                    printer_draw_text($handle,$oFactura_Venta->numero_orden_venta,1300,435);
                    //====
                    printer_draw_text($handle,$oCliente->ruc,160,465);
                    printer_draw_text($handle,$oCliente->codigo,630,465);
                    printer_draw_text($handle,$oFactura_Venta->numero_orden_compra,1300,465);
                    //Detalle
                    //=============================================================
                    $alto=610;
                    $dtFactura_Venta_Detalle=factura_venta_detalle::getGrid1('fvd.factura_venta_ID='.$item['ID'],-1,-1,'ovd.ID asc');
                    foreach($dtFactura_Venta_Detalle as $item){
                        $costo_unitario=0;
                        $subtotal=0;
                        if($item['moneda_ID']==1){
                               $costo_unitario=number_format($item['precio_venta_unitario_soles'],2,'.',',');
                               $subtotal=number_format($item['precio_venta_subtotal_soles'],2,'.',',');

                        }else {
                               $costo_unitario=number_format($item['precio_venta_unitario_dolares'],2,'.',',');
                               $subtotal=number_format($item['precio_venta_subtotal_dolares'],2,'.',',');
                        }

                        printer_select_font($handle, $font_negrita);
                        printer_draw_text($handle,$item['cantidad'],80,$alto);
                        printer_draw_text($handle,strtoupper($item['producto']),175,$alto);
                        printer_draw_text($handle,$costo_unitario,1150,$alto);
                        printer_draw_text($handle,$subtotal,1350,$alto);
                        printer_select_font($handle, $font);
			if(trim($item['descripcion'])!=''&& $oFactura_Venta->ver_descripcion==1){
                            $alto=$alto+10;
                            //verificamos todos los salto de linea
                            $descripcion_convertido=eregi_replace("[\n|\r|\n\r]","<br />",($item['descripcion']));
                            $array=explode('<br />',$descripcion_convertido);

                            //$descripcion=wordwrap($item['descripcion'],80,"<br />",true);
                            //$array=explode('<br />',eregi_replace("[\n|\r|\n\r]","<br />",$descripcion));
                            $cantidad_maximo=80;
                            if(count($array)>0){
                                for($i=0;$i<count($array);$i++){
                                    if(strlen($array[$i])>$cantidad_maximo){
                                        $descripcion1=wordwrap($array[$i],$cantidad_maximo,"<br />",true);
                                        $array1=explode('<br />',$descripcion1);
                                        for($a=0;$a<count($array1);$a++){
                                            if(isset($array1[$a])){
                                                $alto=$alto+20;
                                                printer_draw_text($handle, $array1[$a],175,$alto);
                                            }

                                        }

                                    }else {
                                        $alto=$alto+10;
                                        printer_draw_text($handle,$array[$i],175,$alto);
                                    }

                                }
                            }else {

                                if(strlen($item['descripcion'])>$cantidad_maximo){

                                    $texo=wordwrap($item['descripcion'],$cantidad_maximo,"<br />",true);
                                    $array=explode('<br />',$texo);
                                    for($a=0;$a<count($array);$a++){
                                        $alto=$alto+20;
                                        printer_draw_text($handle,$array[$a],175,$alto);
                                    }
                                }else {
                                    $alto=$alto+10;
                                    printer_draw_text($handle,$item['descripcion'],175,$alto);
                                }

                            }

                         $alto=$alto+30;
                        }

                        $alto=$alto+30;
                    }
                    //==============================================================
                    //Pie
                    $oMoneda=moneda::getByID($osalida->moneda_ID);
                    $arraymonto_total=explode('.',$oFactura_Venta->monto_total);
                    $decimal="00";
                    if(isset($arraymonto_total[1])){
                        if(strlen($arraymonto_total[1])==1){
                            $decimal=$arraymonto_total[1].'0';
                        }else {
                            $decimal=$arraymonto_total[1];
                        }
                    }
                    $monto_total_texto="   ".numtoletras($oFactura_Venta->monto_total).' CON '.$decimal."/100 ".str_replace("ó","O",strtoupper(FormatTextViewHtml($oMoneda->descripcion))).".";
                    printer_draw_text($handle,$monto_total_texto,80,1680);
                    $dtsalida_Numero_Cuenta=salida_numero_cuenta::getGrid1('ovnc.salida_ID='.$salida_ID,-1,-1);
                    $posicion_cuenta=1770;
                    foreach($dtsalida_Numero_Cuenta as $numero_cuenta){
                        $cuenta=$numero_cuenta['abreviatura'].''.$numero_cuenta['numero'].'  '.$numero_cuenta['cci'];
                        printer_draw_text($handle,$cuenta,40,$posicion_cuenta);
                        $posicion_cuenta=$posicion_cuenta+10;

                    }
                    printer_select_font($handle, $font_total);
                    //igv
                    printer_draw_text($handle,  number_format($osalida->igv*100,0,'.',','),1210,1795);

                   //Costos total
                    $ubicacion=1310;
                    if($oMoneda->ID==2){
                            $ubicacion=1290;
                    }
                    printer_draw_text($handle,  $oMoneda->simbolo,$ubicacion,1750);
                    printer_draw_text($handle,  number_format($oFactura_Venta->monto_total_neto,2,'.',','),1340,1750);
                    printer_draw_text($handle,  $oMoneda->simbolo,$ubicacion,1805);
                    printer_draw_text($handle,  number_format($oFactura_Venta->monto_total_igv,2,'.',','),1340,1805);
                    printer_draw_text($handle, $oMoneda->simbolo,$ubicacion,1855);
                    printer_draw_text($handle,  number_format($oFactura_Venta->monto_total,2,'.',','),1340,1855);
                    printer_delete_font($font_moneda);
                    printer_delete_font($font_negrita);

                    printer_delete_font($font);
                    $return=printer_end_page($handle);
                    printer_end_doc($handle);
                    printer_close($handle);
                   



                }

                $factura_detalle=extraer_estructura_facturas($osalida);
                //Actualizamos el orden de venta
                if($factura_emitidos==0){
                    $osalida->estado_ID=40;
                    $osalida->usuario_mod_id=$_SESSION['usuario_ID'];
                    $osalida->actualizar();
                    $osalida->actualizarImpresion(1);
                }

                $mensaje='La factura se emitió correctamente.';
                $resultado=1;
            }else {
                $factura_detalle=extraer_estructura_facturas($osalida);
                $mensaje='No se puede imprimir, la impresora esta ocupada por la Orden de venta N'.$numero_orden_imprimiendo;
                $resultado=-1;
            }

        }catch(Exception $ex){
             $resultado=-1;
             $mensaje=$ex->getMessage();
        }
        $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje,'facturas_detalle'=>$factura_detalle);

        echo json_encode($retornar);
    }
    function verificarImpresora($salida_ID){
        if(!class_exists('salida')){
            require ROOT_PATH.'models/salida.php';
        }


        $numero_salida="";
        try{
            $dtsalida=salida::getGrid('ov.impresion=1 and ov.ID!='.$salida_ID);
            $numero_salida="";
            foreach($dtsalida as $item){
                $numero_salida=$item['numero_concatenado'];
            }


        }catch(Exception $ex){
           $numero_salida="";

        }
        return $numero_salida;
    }
    function get_Orden_Venta_Mantenimiento_Guia_Vista_Previa($id){
        require ROOT_PATH.'models/salida.php';
        global $returnView_float;
        $returnView_float=true;
        $osalida=salida::getByID($id);
        $GLOBALS['oOrden_Venta']=$osalida;
    }

    function get_Guia_Vista_Previa($id){
        require ROOT_PATH.'formatos_pdf/guia_venta.php';
        require ROOT_PATH.'models/salida.php';
        require ROOT_PATH.'models/factura_venta.php';
        require ROOT_PATH.'models/guia_venta.php';
        require ROOT_PATH.'models/guia_venta_detalle.php';
        require ROOT_PATH.'models/moneda.php';
        require ROOT_PATH.'models/salida_detalle.php';
        require ROOT_PATH.'models/producto.php';
        if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";;
        require ROOT_PATH . 'models/cliente.php';
        require ROOT_PATH . 'include/lib_fecha_texto.php';
        require ROOT_PATH . 'models/cliente_contacto.php';
        require ROOT_PATH . 'models/forma_pago.php';
        require ROOT_PATH . 'models/operador.php';
        require ROOT_PATH . 'models/salida_numero_cuenta.php';
        require ROOT_PATH . 'models/vehiculo.php';
        require ROOT_PATH . 'models/chofer.php';

        //global $returnView_float;
        //$returnView_float=true;
        try{
            $osalida=salida::getByID($id);
            $oMoneda=moneda::getByID($osalida->moneda_ID);


            $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
            $oCliente=cliente::getByID($osalida->cliente_ID);
            $oCliente_Contacto=cliente_contacto::getByID($osalida->cliente_contacto_ID);

            $oForma_Pago=forma_pago::getByID($osalida->forma_pago_ID);
            if($osalida->forma_pago_ID==0){
                $oForma_Pago=new forma_pago();
            }
            if($oForma_Pago==null){

                $oForma_Pago=new forma_pago();
            }
            $oOperador=operador::getByID($osalida->operador_ID);
            if($oOperador==null){
                $oOperador=new operador();
            }

            $dtGuia_Venta=guia_venta::getGrid('salida_ID='.$id.' and estado_ID in (37,38)',-1,-1);
            $pdf= new PDF2('P','mm',array(216,279));
            $pdf->osalida=$osalida;
            $pdf->oDatos_Generales=$oDatos_Generales;
            $pdf->oCliente=$oCliente;
            $pdf->oCliente_Contacto=$oCliente_Contacto;
            $pdf->oMoneda=$oMoneda;
            $pdf->oForma_Pago=$oForma_Pago;
            $pdf->oOperador=$oOperador;
            $oVehiculo=new vehiculo();
            foreach($dtGuia_Venta as $item){

                $oGuia_Venta=guia_venta::getByID($item['ID']);
                $oChofer=chofer::getByID($oGuia_Venta->chofer_ID);
                if($oChofer==null){
                   $oChofer=new chofer();
                }
                $pdf->oChofer=$oChofer;
                //$oVehiculo=vehiculo::getByID($oGuia_Venta->vehiculo_ID);
                if($oGuia_Venta->vehiculo_ID!=null){
                   $oVehiculo=vehiculo::getByID($oGuia_Venta->vehiculo_ID);
                }
                $pdf->oVehiculo=$oVehiculo;
                $pdf->AddPage();


                $pdf->cabecera($oGuia_Venta);
                $pdf->contenedor_detalle(130,$oGuia_Venta);
                $dtGuia_Venta_Detalle1=guia_venta_detalle::getGrid1('gvd.guia_venta_ID='.$item['ID'],-1,-1,'ovd.ID asc');
                $pdf->SetWidths(array(20,120,25,35));
                $pdf->SetAligns(array('C','L','C','C'));
                $pdf->contenido_detalle($dtGuia_Venta_Detalle1);

            }

        }catch(Exception $ex){

        }

        $pdf->Output('I','Guia Nro'.sprintf("%'.07d",'5').'.pdf',true);
    }
    function post_ajaxImprimir_Guia(){
        require ROOT_PATH . 'models/salida.php';
        require ROOT_PATH . 'models/salida_detalle.php';
        require ROOT_PATH . 'models/producto.php';
        require ROOT_PATH . 'models/factura_venta.php';
        require ROOT_PATH . 'models/factura_venta_detalle.php';
        require ROOT_PATH . 'models/guia_venta.php';
        require ROOT_PATH . 'models/guia_venta_detalle.php';
        require ROOT_PATH . 'models/cliente.php';
        require ROOT_PATH . 'models/operador.php';

        require ROOT_PATH . 'models/moneda.php';
        require ROOT_PATH . 'models/correlativos.php';
        require ROOT_PATH . 'models/chofer.php';
        require ROOT_PATH . 'models/vehiculo.php';
        if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";;
        $salida_ID=$_POST['orden_venta_ID'];
        $correlativos_ID=$_POST['selSerie'];
        $numero_concatenado=$_POST['txtNumero'];
        $numero_registrado=preg_replace('/^0+/', '', $numero_concatenado);
        try{
            $guia_emitidos=0;
            $oDatos_Genetales=datos_generales::getByID1($_SESSION['empresa_ID']);
            $osalida=salida::getByID($salida_ID);
            $numero_orden_imprimiendo=verificarImpresora($salida_ID);
            if($numero_orden_imprimiendo==""){
                //$contar_factura_imitida=0;
                $contar_factura_imitida=factura_venta::getCount('salida_ID='.$salida_ID.' and estado_ID in (41,60,93,94)');
                if($contar_factura_imitida>0){
                    $dtGuia_Venta=guia_venta::getGrid1('salida_ID='.$salida_ID.' and estado_ID in (37,38)',-1,-1,'ID asc');
                    foreach($dtGuia_Venta as $valor){
                        $oGuia_Venta=guia_venta::getByID($valor['ID']);
                        $oCliente=cliente::getByID($osalida->cliente_ID);
                        $oOperador=operador::getByID($osalida->operador_ID);
                        $oVehiculo=vehiculo::getByID($oGuia_Venta->vehiculo_ID);
                        if($oVehiculo==null){
                            $oVehiculo=new vehiculo();
                        }
                        $oChofer=chofer::getByID($oGuia_Venta->chofer_ID);
                        if($oChofer==null){
                            $oChofer=new chofer();
                        }
                        $oFactura_Venta=factura_venta::getByID($oGuia_Venta->factura_venta_ID);
                        if($oFactura_Venta==null){
                            $oFactura_Venta=new factura_venta();
                        }
                        
                        if($oGuia_Venta->estado_ID==37||$oGuia_Venta->estado_ID==38){
                           //Actualizamos el número de la guia
                        $serie=$valor['serie'];
                        if($oGuia_Venta->estado_ID==38){
                            $oGuia_Venta->correlativos_ID=$correlativos_ID;
                            $numero=$numero_registrado;
                        }else{
                            $numero=correlativos::getNumero($oGuia_Venta->correlativos_ID);
                            $numero_concatenado=sprintf("%'.07d",$numero);
                        }
                        
                        $oGuia_Venta->numero=$numero;
                        $oGuia_Venta->numero_concatenado=$numero_concatenado;
                        $oGuia_Venta->estado_ID=38;
                        $oGuia_Venta->usuario_mod_id=$_SESSION['usuario_ID'];
                        //$oGuia_Venta->actualizarEstadoandNumero();
                        $oGuia_Venta->actualizar();
                         //Actualizamos el estado de la factura a estado emitido

                       //direccion ip local-nombre de impresora
                        //===========================================
                            //$handle = printer_open("Guia");
                        $handle = printer_open("PDFCreator");
                                                //$handle = printer_open("TASKalfa 306ci");
                                        //========
                        printer_set_option($handle, PRINTER_PAPER_LENGTH, 200 );
                        printer_set_option($handle, PRINTER_PAPER_WIDTH , 279 );
                        printer_set_option($handle, PRINTER_SCALE , 100 );
                        printer_set_option($handle, PRINTER_TITLE , 'Guia' );
                        printer_start_doc($handle, "Guia");
                        printer_start_page($handle);
                        //Estilos para el contenido
                        $font = printer_create_font("Arial",20,10,300,false,false, false,0);
                        $font_negrita=printer_create_font("Arial",20,10,700,false,false, false,0);
                        $font_moneda=printer_create_font("Arial",20,10,700,false,false, false,0);

                        printer_select_font($handle, $font);

                        //Imprimimos la cabecera

                        //fila1
                        printer_draw_text($handle,$oGuia_Venta->fecha_emision,150,375);
                        printer_draw_text($handle,$oGuia_Venta->fecha_inicio_traslado,580,375);
                        printer_draw_text($handle,$oGuia_Venta->numero_orden_venta,1350,345);
                        printer_draw_text($handle,$oGuia_Venta->numero_orden_compra,1350,375);
                        //fila2
                        printer_draw_text($handle,$oGuia_Venta->punto_partida,80,455);
                        printer_draw_text($handle, $oGuia_Venta->punto_llegada,800,455);
                        //DESTINATARIO
                        printer_draw_text($handle,$oCliente->razon_social,255,550);
                        printer_draw_text($handle,$oCliente->ruc,100,610);

                        //DATOS DEL TRANSPORTISTA/CONDUTOR
                        printer_draw_text($handle,$oVehiculo->marca.' - '.$oVehiculo->placa,1100,550);
                        printer_draw_text($handle,$oVehiculo->certificado_inscripcion,1100,580);
                        printer_draw_text($handle,$oChofer->licencia_conducir,1100,610);

                        //Detalle
                        //=============================================================
                        $alto=735;
                        $dtGuia_Venta_Detalle=guia_venta_detalle::getGrid1('gvd.guia_venta_ID='.$valor['ID'],-1,-1,'ovd.ID asc');
                        foreach($dtGuia_Venta_Detalle as $item){

                            printer_select_font($handle, $font_negrita);
                            printer_draw_text($handle,$item['cantidad'],80,$alto);
                            printer_draw_text($handle,strtoupper($item['producto']),185,$alto);
                            printer_draw_text($handle,$item['unidad_medida'],1150,$alto);
                            printer_draw_text($handle,$item['peso'],1350,$alto);
                            printer_select_font($handle, $font);
                            if(trim($item['descripcion'])!=''){
                                $alto=$alto+10;
                                //verificamos todos los salto de linea
                                $descripcion_convertido=eregi_replace("[\n|\r|\n\r]","<br />",$item['descripcion']);
                                $array=explode('<br />',$descripcion_convertido);

                                $cantidad_maximo=80;
                                if(count($array)>0){
                                    for($i=0;$i<count($array);$i++){
                                        if(strlen($array[$i])>$cantidad_maximo){
                                            $descripcion1=wordwrap($array[$i],$cantidad_maximo,"<br />",true);
                                            $array1=explode('<br />',$descripcion1);
                                            for($a=0;$a<count($array1);$a++){
                                                if(isset($array1[$a])){
                                                    $alto=$alto+20;
                                                    printer_draw_text($handle,$array1[$a],185,$alto);
                                                }

                                            }

                                        }else {
                                            $alto=$alto+10;
                                            printer_draw_text($handle,$array[$i],185,$alto);
                                        }

                                    }
                                }else {

                                    if(strlen($item['descripcion'])>$cantidad_maximo){

                                        $texo=wordwrap($item['descripcion'],$cantidad_maximo,"<br />",true);
                                        $array=explode('<br />',$texo);
                                        for($a=0;$a<count($array);$a++){
                                            $alto=$alto+20;
                                            printer_draw_text($handle,$array1[$a],185,$alto);
                                        }
                                    }else {
                                        $alto=$alto+10;
                                        printer_draw_text($handle,$item['descripcion'],185,$alto);
                                    }

                                }

                             $alto=$alto+30;
                            }

                            $alto=$alto+30;
                        }
                        //==============================================================
                        //Pie


                        //TRANSPORTISTA
                        printer_draw_text($handle,$oGuia_Venta->empresa_transporte,150,1703);
                        printer_draw_text($handle,$oDatos_Genetales->ruc,170,1760);
                        //printer_draw_text($handle,$oVehiculo->marca.' - '.$oVehiculo->placa,40,1720);
                       //COMPROBANTE DE PAGO
                        printer_draw_text($handle,'FACTURA  '.$oFactura_Venta->numero_concatenado.'  '.$oFactura_Venta->fecha_emision,120,1870);
                        printer_delete_font($font_moneda);
                        printer_delete_font($font_negrita);

                        printer_delete_font($font);
                        printer_end_page($handle);
                        printer_end_doc($handle);
                        printer_close($handle);
                        //Actualizamos el correlativo
                        //$oCorrelativos=correlativos::getBySerie(4,$serie);
                        $oCorrelativos=correlativos::getByID($oGuia_Venta->correlativos_ID);
                        $oCorrelativos->ultimo_numero=$numero;
                        $oCorrelativos->usuario_mod_id=$_SESSION['usuario_ID'];
                        $oCorrelativos->actualizar();
                       }elseif($oGuia_Venta->estado_ID==38){
                           $guia_emitidos++;
                       }
                       //Actualizamos la OC a impresion
                        $osalida->usuario_mod_id=$_SESSION['usuario_ID'];
                        $osalida->actualizarImpresion(1);


                    }
                    //$guia_detalle="";
                    $guia_detalle=extraer_estructura_guias($osalida);

                    $mensaje='La guía se emitió correctamente.';
                    $resultado=1;
                }else {
                    $guia_detalle=extraer_estructura_guias($osalida);
                    $mensaje='No puede emitir la guia, primero tiene que emitir la factura';
                    $resultado=-1;
                }

            }else {
                $guia_detalle=extraer_estructura_guias($osalida);
                $mensaje='No se puede imprimir, la impresora esta ocupada por la Orden de venta N'.$numero_orden_imprimiendo;
                $resultado=-1;
            }
            
        }catch(Exception $ex){
             $resultado=-1;
             $mensaje=utf8_encode(mensaje_error);
             log_error(__FILE__, "salida/post_ajaxImprimir_Guia", $ex->getMessage());
             $guia_detalle="";
        }
        
        $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje,'guia_detalle'=>$guia_detalle);

        echo json_encode($retornar);
    }
    function imprimir_guia_fisico($valor){
                               //direccion ip local-nombre de impresora
                        //===========================================
                            //$handle = printer_open("Guia");
                        $handle = printer_open("PDFCreator");
                                                //$handle = printer_open("TASKalfa 306ci");
                                        //========
                        printer_set_option($handle, PRINTER_PAPER_LENGTH, 200 );
                        printer_set_option($handle, PRINTER_PAPER_WIDTH , 279 );
                        printer_set_option($handle, PRINTER_SCALE , 100 );
                        printer_set_option($handle, PRINTER_TITLE , 'Guia' );
                        printer_start_doc($handle, "Guia");
                        printer_start_page($handle);
                        //Estilos para el contenido
                        $font = printer_create_font("Arial",20,10,300,false,false, false,0);
                        $font_negrita=printer_create_font("Arial",20,10,700,false,false, false,0);
                        $font_moneda=printer_create_font("Arial",20,10,700,false,false, false,0);

                        printer_select_font($handle, $font);

                        //Imprimimos la cabecera

                        //fila1
                        printer_draw_text($handle,$valor['FechaEmision'],150,375);
                        printer_draw_text($handle,$valor['FechaInicioTraslado'],580,375);
                        printer_draw_text($handle,$valor['numero_orden_compra'],1350,345);
                        printer_draw_text($handle,$valor['numero_orden_venta'],1350,375);
                        //fila2
                        printer_draw_text($handle,$valor['DireccionPartida_DireccionCompleta'],80,455);
                        printer_draw_text($handle,$valor['DireccionLlegada_DireccionCompleta'],800,455);
                        //DESTINATARIO
                        printer_draw_text($handle,$valor['Destinatario_NombreLegal'],255,550);
                        printer_draw_text($handle,$valor['Destinatario_NroDocumento'],100,610);

                        //DATOS DEL TRANSPORTISTA/CONDUTOR
                        printer_draw_text($handle,$valor['placa_vehiculo'],1100,550);
                        printer_draw_text($handle,$valor['certificado_inscripcion'],1100,580);
                        printer_draw_text($handle,$valor['licencia_conducir'],1100,610);

                        //Detalle
                        //=============================================================
                        $alto=735;
                        $dtGuia_Venta_Detalle=guia_venta_detalle::getListaGuia_Venta($valor['ID']);
                        foreach($dtGuia_Venta_Detalle as $item){

                            printer_select_font($handle, $font_negrita);
                            printer_draw_text($handle,$item['Cantidad'],80,$alto);
                            printer_draw_text($handle,strtoupper($item['producto']),185,$alto);
                            printer_draw_text($handle,$item['UnidadMedida'],1150,$alto);
                            printer_draw_text($handle,$item['peso'],1350,$alto);
                            printer_select_font($handle, $font);
                            if(trim($item['Descripcion'])!=''){
                                $alto=$alto+10;
                                //verificamos todos los salto de linea
                                $descripcion_convertido=preg_replace("[\n|\r|\n\r]","<br />",$item['Descripcion']);
                                $array=explode('<br />',$descripcion_convertido);

                                $cantidad_maximo=80;
                                if(count($array)>0){
                                    for($i=0;$i<count($array);$i++){
                                        if(strlen($array[$i])>$cantidad_maximo){
                                            $descripcion1=wordwrap($array[$i],$cantidad_maximo,"<br />",true);
                                            $array1=explode('<br />',$descripcion1);
                                            for($a=0;$a<count($array1);$a++){
                                                if(isset($array1[$a])){
                                                    $alto=$alto+20;
                                                    printer_draw_text($handle,$array1[$a],185,$alto);
                                                }

                                            }

                                        }else {
                                            $alto=$alto+10;
                                            printer_draw_text($handle,$array[$i],185,$alto);
                                        }

                                    }
                                }else {

                                    if(strlen($item['Descripcion'])>$cantidad_maximo){

                                        $texo=wordwrap($item['Descripcion'],$cantidad_maximo,"<br />",true);
                                        $array=explode('<br />',$texo);
                                        for($a=0;$a<count($array);$a++){
                                            $alto=$alto+20;
                                            printer_draw_text($handle,$array1[$a],185,$alto);
                                        }
                                    }else {
                                        $alto=$alto+10;
                                        printer_draw_text($handle,$item['Descripcion'],185,$alto);
                                    }

                                }

                             $alto=$alto+30;
                            }

                            $alto=$alto+30;
                        }
                        //==============================================================
                        //Pie
                        //TRANSPORTISTA
                        printer_draw_text($handle,$valor['razon_transportista'],150,1703);
                        printer_draw_text($handle,$valor['ruc_transportista'],170,1760);
                        //printer_draw_text($handle,$oVehiculo->marca.' - '.$oVehiculo->placa,40,1720);
                       //COMPROBANTE DE PAGO
                        printer_draw_text($handle,'FACTURA  '.$valor['DocumentoRelacionado_NroDocumento'].'  '.$valor['factura_fecha'],120,1870);
                        printer_delete_font($font_moneda);
                        printer_delete_font($font_negrita);

                        printer_delete_font($font);
                        printer_end_page($handle);
                        printer_end_doc($handle);
                        printer_close($handle);
    }
    
    function post_ajaxImprimir_Guia_Venta(){
        require ROOT_PATH . 'models/salida.php';

       require ROOT_PATH . 'models/factura_venta.php';
   
        require ROOT_PATH . 'models/guia_venta.php';
        require ROOT_PATH . 'models/guia_venta_detalle.php';
 
        require ROOT_PATH . 'models/correlativos.php';

        $salida_ID=$_POST['id'];
        $serie="";
        $numero=0;
        $cantidad_pagina=0;
        try{
            $guia_emitidos=0;
            //$oDatos_Genetales=datos_generales::getByID1($_SESSION['empresa_ID']);
            $osalida=salida::getByID($salida_ID);
            $dtSalida=salida::getGrid("ov.impresion=1 and ov.ID<>".$salida_ID);
            $contador_impresora=salida::getCount("ov.impresion=1 and ov.ID<>".$salida_ID);
            if($contador_impresora>0){
                
                throw new Exception('No se puede imprimir, la impresora esta ocupada. Nro de venta: '.$dtSalida[0]['numero_concatenado']);
            }
            $contar_factura_imitida=factura_venta::getCount('salida_ID='.$salida_ID.' and estado_ID in (41,60,93,94)');
            if ($contar_factura_imitida==0){
                throw new Exception('No se puede imprimir, la impresora esta ocupada.');
                
            }
            $dtGuia_Venta=guia_venta::getGridSalida($salida_ID);
                    $i=0;
                    
                    foreach($dtGuia_Venta as $valor){

                        if($valor['estado_ID']==44){
                           //Actualizamos el número de la guia
                        $serie=$valor['serie'];
                        $numero=correlativos::getNumero($valor['correlativos_ID']);
                        $numero=$numero+$i;
                        $oGuia_Venta=guia_venta::getByID($valor['ID']);
                        $oGuia_Venta->numero=$numero;
                        $oGuia_Venta->numero_concatenado=sprintf("%'.07d",$numero);
                        $oGuia_Venta->estado_ID=38;
                        $oGuia_Venta->usuario_mod_id=$_SESSION['usuario_ID'];
                        //$oGuia_Venta->actualizarEstadoandNumero();
                        $oGuia_Venta->actualizar();
                         //Actualizamos el estado de la factura a estado emitido
                        imprimir_guia_fisico($valor);

                        //Actualizamos el correlativo
                        //$oCorrelativos=correlativos::getBySerie(4,$serie);
                        $oCorrelativos=correlativos::getByID($valor['correlativos_ID']);
                        $oCorrelativos->ultimo_numero=$numero;
                        $oCorrelativos->usuario_mod_id=$_SESSION['usuario_ID'];
                        $oCorrelativos->actualizar();
                       }elseif($valor['estado_ID']==38){
                           throw new Exception("La guía ya fue impreso, en caso de algún error anular la guía.");
                           $guia_emitidos++;
                       }
                       //Actualizamos la OC a impresion
                        $osalida->usuario_mod_id=$_SESSION['usuario_ID'];
                        $osalida->actualizarImpresion(1);
                        $cantidad_pagina++;
                    }
                    $mensaje='La guía se emitió correctamente.';
                    $resultado=1;   
            
        }catch(Exception $ex){
             $resultado=-1;
             $mensaje=$ex->getMessage();
             
             //$guia_detalle="";
        }
        
        $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje,'serie'=>$serie,'numero'=>$numero,'cantidad_pagina'=>$cantidad_pagina);

        echo json_encode($retornar);
    }
    function post_ajaxValidarImpresion_Guia_Venta(){
        require ROOT_PATH . 'models/salida.php';
        require ROOT_PATH . 'models/guia_venta.php';
        require ROOT_PATH . 'models/guia_venta_detalle.php';
        require ROOT_PATH . 'models/correlativos.php';
        $estado_impresion=$_POST['selEstadoImpresion'];
        $hoja_defectuosa=$_POST['selEstadoHoja'];
        $numero_hojas_defectuosa=$_POST['txtNumero_Hojas'];
        $nueva_impresion=$_POST['selNuevaImpresion'];
        $salida_ID=$_POST['salida_ID'];
        $resultado=0;
        $numero=0;
        $serie="";
        $cantidad_pagina=0;
        try{
            
            if($estado_impresion==1){
                
                $oSalida=salida::getByID($salida_ID);
                
                
                $oSalida->usuario_mod_id=$_SESSION['usuario_ID'];
                $oSalida->actualizarImpresion(0);
                $resultado=2;
            }else{
                if($hoja_defectuosa==0){//No se dañó la hoja
                   
                    if($nueva_impresion==1){
                        $dtGuia_Venta=guia_venta::getGridSalida($salida_ID);
                        
                        foreach($dtGuia_Venta as $valor){
                            imprimir_guia_fisico($valor);
                        }
                        $resultado=1;
                    }elseif($nueva_impresion==0){
                        $dtGuia_Venta=guia_venta::getGridSalida($salida_ID);
                        $ultimo_numero=0;
                        $y=0;
                        $correlativos_ID=0;
                        foreach($dtGuia_Venta as $valor){
                            $serie=$valor['serie'];
                             $oGuia_Venta=guia_venta::getByID($valor['ID']);
                             $oGuia_Venta->estado_ID=44;
                             $oGuia_Venta->usuario_mod_id=$_SESSION['usuario_ID'];
                             $oGuia_Venta->actualizar();
                             $ultimo_numero=$valor['numero'];
                             $correlativos_ID=$valor['correlativos_ID'];
                             $y++;
                             $cantidad_pagina++;
                            
                        }
                        $ultimo_numero=$ultimo_numero-$y;
                        $numero=$ultimo_numero;
                        $oCorrelativos= correlativos::getByID($correlativos_ID);
                        $oCorrelativos->ultimo_numero=$ultimo_numero;
                        $oCorrelativos->usuario_mod_id=$_SESSION['usuario_ID'];
                        $oCorrelativos->actualizar();
                        $oSalida=salida::getByID($salida_ID);
                        $oSalida->usuario_mod_id=$_SESSION['usuario_ID'];
                        $oSalida->actualizarImpresion(0);
                        $resultado=2;
                    }
                }elseif($hoja_defectuosa==1){//Hoja defectuosa
                    if($nueva_impresion==1){//Imprimir nuevamente
                        
                        $dtGuia_Venta=guia_venta::getGridSalida($salida_ID);
                        //print_r($dtGuia_Venta);
                        $numero=0;
                        $i=0;
                        foreach($dtGuia_Venta as $valor){
                            if($i==0){
                                $numero=$valor['numero'];
                                $serie=$valor['serie'];
                            }
                            $i++;
                            
                        }
                        $numero=$numero+$numero_hojas_defectuosa;
                        //echo $numero;
                        $y=0;
                        foreach($dtGuia_Venta as $valor){
                            
                            
                            imprimir_guia_fisico($valor);
                            $numero=$numero+$y;
                            $oGuia_Venta=guia_venta::getByID($valor['ID']);
                            $oGuia_Venta->numero=$numero;
                            $oGuia_Venta->usuario_mod_id=$_SESSION['usuario_ID'];
                            $oGuia_Venta->actualizar();
                            $oCorrelativos= correlativos::getByID($valor['correlativos_ID']);
                            $oCorrelativos->ultimo_numero=$numero;
                            $oCorrelativos->usuario_mod_id=$_SESSION['usuario_ID'];
                            $oCorrelativos->actualizar();
                            $cantidad_pagina++;
                            $y++;
                        }
                        
                        $resultado=1;
                        
                    }elseif($nueva_impresion==0){
                        $dtGuia_Venta=guia_venta::getGridSalida($salida_ID);
                        $ultimo_numero=0;
                        $i=0;
                        $correlativos_ID=0;
                        foreach($dtGuia_Venta as $valor){
                            $serie=$valor['serie'];
                            $oGuia_Venta=guia_venta::getByID($valor['ID']);
                            $oGuia_Venta->estado_ID=44;
                            $oGuia_Venta->usuario_mod_id=$_SESSION['usuario_ID'];
                            $oGuia_Venta->actualizar();
                            $ultimo_numero=$valor['numero'];
                            $correlativos_ID=$valor['correlativos_ID'];
                            $cantidad_pagina++;
                            $y++;
                            
                        }
                        
                        $hojas_por_eliminar=$numero_hojas_defectuosa-$y;
                        
                        if($hojas_por_eliminar>0){
                            $ultimo_numero=$numero+$hojas_por_eliminar;
                            $oCorrelativos= correlativos::getByID($correlativos_ID);
                            $oCorrelativos->ultimo_numero=$ultimo_numero;
                            $oCorrelativos->usuario_mod_id=$_SESSION['usuario_ID'];
                            $oCorrelativos->actualizar();
                        }
                       
                        $oSalida=salida::getByID($salida_ID);
                        $oSalida->usuario_mod_id=$_SESSION['usuario_ID'];
                        $oSalida->actualizarImpresion(0);
                        $resultado=2;
                    }
                    
                }
            }
        }catch(Exception $ex){
            $resultado=-1;
            log_error(__FILE__, "Salida/post_ajaxValidarImpresion_Guia_Venta", $ex->getMessage());
        }
        $retornar=Array('resultado'=>$resultado,'numero'=>$numero,'serie'=>$serie,'cantidad_pagina'=>$cantidad_pagina);

        echo json_encode($retornar);
    }
    function post_ajaxAnular_Guia(){
        require ROOT_PATH . 'models/salida.php';
        require ROOT_PATH . 'models/guia_venta.php';
        $salida_ID=$_POST['id'];
        try{
            $osalida=salida::getByID($salida_ID);
            $dtGuia_Venta=guia_venta::getGrid('salida_ID='.$salida_ID,-1,-1,'ID asc');
            foreach($dtGuia_Venta as $item){
               $oGuia_Venta=guia_venta::getByID($item['ID']);
               $oGuia_Venta->estado_ID=39;
               $oGuia_Venta->observacion='Guía anulada';
               $oGuia_Venta->usuario_mod_id=$_SESSION['usuario_ID'];
               $oGuia_Venta->actualizarEstado();
            }
            $resultado=1;
            $mensaje="Se anuló correctamente";
            $guia_detalle=extraer_estructura_guias($osalida);

        }catch(Exception $ex){
            $resultado=-1;
            $mensaje=$ex->getMessage();
        }

         $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje,'guia_detalle'=>$guia_detalle);

        echo json_encode($retornar);
    }
    function post_ajaxAnular_Factura(){
        require ROOT_PATH . 'models/salida.php';
        require ROOT_PATH . 'models/factura_venta.php';
        require ROOT_PATH . 'models/operador.php';
        $salida_ID=$_POST['id'];
        try{
            $osalida=salida::getByID($salida_ID);
            $dtFactura_Venta=factura_venta::getGrid('fv.salida_ID='.$salida_ID.' and fv.estado_ID=41',-1,-1,'ID asc');
            $operador_ID=operador::getOperador($_SESSION['usuario_ID']);
            foreach($dtFactura_Venta as $item){
               $oFactura_Venta=factura_venta::getByID($item['ID']);
               $oFactura_Venta->estado_ID=53;
               $oFactura_Venta->observacion='Factura anulada';
               $oFactura_Venta->operador_ID_anulacion=($operador_ID>0)?$operador_ID:0;
               $oFactura_Venta->motivo_anulacion_ID=2;//Error de impresión
               $oFactura_Venta->fecha_anulacion=date('Y-m-d');
               $oFactura_Venta->usuario_mod_id=$_SESSION['usuario_ID'];
               $oFactura_Venta->actualizar();
               //$oFactura_Venta->actualizarEstado();
            }
            $osalida->estado_ID=58;
            $osalida->usuario_mod_id=$_SESSION['usuario_ID'];   
            $osalida->actualizar();
            $resultado=1;
            $mensaje="Se anuló correctamente";
            $factura_detalle=extraer_estructura_facturas($osalida);

        }catch(Exception $ex){
            log_error(__FILE__,"salida/post_ajaxAnular_Factura",$ex->getMessage());
            $resultado=-1;
            $mensaje=$ex->getMessage();
        }

         $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje,'factura_detalle'=>$factura_detalle);

        echo json_encode($retornar);
    }
    function get_Cuerpo_Detalle($id){
        require ROOT_PATH . 'models/salida.php';
        require ROOT_PATH . 'models/salida_detalle.php';
        require ROOT_PATH . 'models/producto.php';
        require ROOT_PATH . 'models/factura_venta.php';
        require ROOT_PATH . 'models/guia_venta_numero.php';
        require ROOT_PATH . 'models/guia_venta.php';
        if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";;
        require ROOT_PATH . 'models/chofer.php';
        require ROOT_PATH . 'models/vehiculo.php';
        require ROOT_PATH . 'models/cliente.php';
        global  $returnView_float;
        $returnView_float=true;
        $osalida=salida::getByID($id);
        $GLOBALS['osalida']=$osalida;
        $html=mostrar_productos($id,1);
        $GLOBALS['html']=$html;
    }
    function mostrar_productos($salida_ID,$tipo){
        if(!class_exists('salida_detalle')){
            require ROOT_PATH . 'models/salida_detalle.php';
        }
        if(!class_exists('salida')){
            require ROOT_PATH . 'models/salida.php';
        }
        if(!class_exists('moneda')){
            require ROOT_PATH . 'models/moneda.php';
        }

        switch ($tipo){
            case 1:
                $dtsalida_detalle=salida_detalle::getGridLista("ovd.salida_ID=".$salida_ID. ' and ovd.tipo_ID in (1,2,5,6)');

                $html ='<table  id="tablaproducto" cellsspacin="0" cellspadding="0">';
                $i=1;
                foreach ($dtsalida_detalle as $item){

                    $html.='<tr>';
                    $html.='<td id="td'.$i.'" width="85.4px" style="text-align:center; padding-top: 10px; border:none;font-weight: bold;">'. $item['cantidad'].' </td>';
                    $html.='<td width="524.3px" style="padding:0 20px;padding-top: 10px;border:none;"><span style="font-weight: bold;">'. test_input($item['producto']).'</span>';
                    if($item['descripcion']!=""){
                         $html.='<br/><span>'. nl2br(utf8_encode($item['descripcion'])) .'</span>';
                    }


                    $dtsalida_detalle_Componente=salida_detalle::getGridLista("ovd.salida_detalle_ID=".$item['ID'].' and ovd.tipo_ID=3');
                    if(count($dtsalida_detalle_Componente)>0){
                        $html.='<br/>';
                        foreach($dtsalida_detalle_Componente as $componente){
                            $html.='<span>'.$componente['producto'].'&nbsp;&nbsp;('.$componente['cantidad'].'&nbsp;'.$componente['unidad_medida'].')</span><br/>';
                        }
                    }
                    $html.='</td>';
                    $html.='<td width="81.6px" style="text-align:center;padding-top: 10px;border:none;font-weight: bold;">'. $item['unidad_medida'].'</td>';
                    $html.='<td width="110.7px" style="text-align:center;padding-top: 10px;border:none;font-weight: bold;">'. $item['peso'] . '</td>';
                    $html.='</tr>';
                    $i=$i+1;
                }

                $html.='</table>';
                $retorna=$html;
                break;
            case 2:
                 $osalida=salida::getByID($salida_ID);

            $array=explode("/",$osalida->nproducto_pagina);
            $n=0;
            $array_html=array();
            for($a=0; $a<$osalida->numero_pagina;$a++){
            $valorfin=$array[$a];

            if($valorfin==""){

                $total_producto=count(salida_detalle::getGridLista("ovd.salida_ID=".$salida_ID. ' and ovd.salida_detalle_ID=0 and ovd.obsequio=0'));
                $valorfin=$total_producto-$n;
            }
            $dtsalida_Detalle=salida_detalle::getGridLista("ovd.salida_ID=".$salida_ID. ' and ovd.salida_detalle_ID=0 and ovd.obsequio=0',$n,$valorfin);
            $n=$n+$valorfin;
            $html ='<table cellsspacin="0" cellspadding="0" id="tablaproducto">';
            $i=1;
            foreach ($dtsalida_Detalle as $item){

                $html.='<tr>';
                $html.='<td id="td'.$i.'" width="85.4px" style="text-align:center; padding-top: 10px; border:none;font-weight: bold;">'. $item['cantidad'].' </td>';
                $html.='<td width="524.3px" style="padding:0 20px;padding-top: 10px;border:none;"><span style="font-weight: bold;display:block;font-size: 14px;">'. FormatTextViewHtml($item['producto']).'</span>';
                if($item['descripcion']!=""){
                     $html.='<br/><span>'. nl2br(FormatTextViewHtml($item['descripcion'])) .'</span>';
                }


                $dtsalida_detalle_Componente=salida_detalle::getGridLista("ovd.salida_detalle_ID=".$item['ID']);

                if(count($dtsalida_detalle_Componente)>0){
                    $html.='<br/>';
                    foreach($dtsalida_detalle_Componente as $componente){
                        $dtInventario=inventario::getGrid('salida_detalle_ID='.$componente['ID'],-1,-1,'serie asc');
                        $series="";
                        if(count($dtInventario)>0){

                            foreach ($dtInventario as $valorInventario){
                                if($valorInventario['serie']!='NULL'){

                                    $series.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Número de Serie: ".$valorInventario['serie']."<br/>";
                                }

                            }
                        }
                        $html.='<span style="font-weight: bold;">'.$componente['producto'].'&nbsp;&nbsp;('.$componente['cantidad'].'&nbsp;'.$componente['unidad_medida'].')</span><br/>';
                        if($series!=""){
                            $html.=$series;
                        }
                    }
                }
                $html.='</td>';
                $html.='<td width="81.6px" style="text-align:center;padding-top: 10px;border:none;font-weight: bold;">'. $item['unidad_medida'].'</td>';
                $html.='<td width="110.7px" style="text-align:center;padding-top: 10px;border:none;font-weight: bold;">'. $item['peso'] . '</td>';
                $html.='</tr>';
                $i=$i+1;
            }

            $html.='</table>';
            array_push($array_html,$html);
            }

            $retorna=$array_html;

                break;
            case 3:
                $osalida=salida::getByID($salida_ID);

                $oMoneda=moneda::getByID($osalida->moneda_ID);
                $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
                $dtsalida_detalle=salida_detalle::getGridLista("ovd.salida_ID=".$salida_ID. ' and ovd.tipo_ID in (1,2,5,6)');

                $html ='<table  class="table table-hover table-bordered"><thead><tr><th>Item</th><th>Produto</th><th>cantidad</th><th class="tdRight">Precio U. ('.$oMoneda->simbolo.')</th><th class="tdRight">Sub Total('.$oMoneda->simbolo.')</th></tr></thead>';

                $i=1;
                $html.="<tbody>";
                foreach ($dtsalida_detalle as $item){

                    $html.='<tr>';
                    $html.='<td class="tdCenter">'.$i.'</td>';
                    $html.='<td class="tdLeft">'. FormatTextViewHtml($item['producto']).'</td>';
                    $html.='<td class="tdCenter">'. $item['cantidad'].' </td>';
                    $precio_unitario=0;
                    $subtotal=0;
                    if($osalida->moneda_ID==1){
                        $precio_unitario=$item['precio_venta_unitario_soles'];
                        $subtotal_unitario=$item['precio_venta_subtotal_soles'];
                    }else{
                        $precio_unitario=$item['precio_venta_unitario_dolares'];
                        $subtotal_unitario=$item['precio_venta_subtotal_dolares'];
                    }
                    $html.='<td class="tdRight">'. $precio_unitario.'</td>';
                    $html.='<td class="tdRight">'. $subtotal_unitario . '</td>';
                    $html.='</tr>';
                    $i=$i+1;
                }
                $subtotal=0;
                $vigv=0;
                $total=0;
                if($osalida->moneda_ID==1){
                    $subtotal=$osalida->precio_venta_neto_soles;
                    $vigv=$osalida->vigv_soles;
                    $total=$osalida->precio_venta_total_soles;
                }else {
                    $subtotal=$osalida->precio_venta_neto_dolares;
                    $vigv=$osalida->vigv_dolares;
                    $total=$osalida->precio_venta_total_dolares;
                }
                $igv=$oDatos_Generales->vigv*100;
                //$html.='<tr><td colspan="3"></td><td>Sub Total '.$oMoneda->simbolo.'</td><td>'.$subtotal.'</td></tr>';
                //$html.='<tr><td colspan="3"></td><td>IGV '.$igv.'% </td><td>'.$vigv.'</td></tr>';
               // $html.='<tr><td colspan="3"></td><td>Total '.$oMoneda->simbolo.'</td><td>'.$total.'</td></tr>';
                $html.="</tbody>";
                $html.='</table>';
                $retorna=$html;
                break;
            case 4:
                $dtsalida_detalle=salida_detalle::getGridLista("ovd.salida_ID=".$salida_ID. ' and ovd.salida_detalle_ID=0 and ovd.obsequio=0');
                $osalida=salida::getByID($salida_ID);
                $oMoneda=moneda::getByID($osalida->moneda_ID);
                $html ='<table cellsspacin="0" cellspadding="0" id="tablaproducto">';
                $i=1;
                foreach ($dtsalida_detalle as $item){

                    $html.='<tr>';
                    $html.='<td id="td'.$i.'" width="85.4px" style="text-align:center; padding-top: 10px; border:none;font-weight: bold;">'. $item['cantidad'].' </td>';
                    $html.='<td width="524.3px" style="padding:0 20px;padding-top: 10px;border:none;"><span style="font-weight: bold;">'. $item['producto'].'</span>';
                    if($item['descripcion']!=""){
                         $html.='<br/><span>'. nl2br(FormatTextViewHtml($item['descripcion'])) .'</span>';
                    }


                    $dtsalida_detalle_Componente=salida_detalle::getGridLista("ovd.salida_detalle_ID=".$item['ID']);
                    if(count($dtsalida_detalle_Componente)>0){
                        $html.='<br/>';
                        foreach($dtsalida_detalle_Componente as $componente){
                            $html.='<span>'.$componente['producto'].'&nbsp;&nbsp;('.$componente['cantidad'].'&nbsp;'.$componente['unidad_medida'].')</span><br/>';
                        }
                    }
                    $html.='</td>';
                    $subtotal=0;
                    $precio_unitario=0;
                    if($osalida->moneda_ID==1){
                        $subtotal=$item['precio_venta_subtotal_soles'];
                        $precio_unitario=$item['precio_venta_unitario_soles'];
                    }else {
                        $subtotal=$item['precio_venta_subtotal_dolares'];
                        $precio_unitario=$item['precio_venta_unitario_dolares'];
                    }
                    $html.='<td width="71.6px" style="text-align:right;padding-top: 10px;border:none;font-weight: bold; padding-right: 10px;">'. $precio_unitario.'</td>';
                    $html.='<td width="100.7px" style="text-align:right;padding-top: 10px;border:none;font-weight: bold; padding-right: 10px;">'. $subtotal . '</td>';
                    $html.='</tr>';
                    $i=$i+1;
                }

                $html.='</table>';
                $retorna=$html;

                break;
            case 5:
                $osalida=salida::getByID($salida_ID);
                $dtFactura_Venta=factura_venta::getGrid('salida_ID='.$salida_ID);
                $arrayHtml=array();
                foreach($dtFactura_Venta as $value){
                    $dtFactura_Venta_Detalle=factura_venta_detalle::getGrid('factura_venta_ID='.$value['ID']);
                    $html ='<table cellsspacin="0" cellspadding="0" id="tablaproducto">';
                    //$dtsalida_detalle=salida_detalle::getGridLista("ovd.salida_ID=".$salida_ID. ' and ovd.salida_detalle_ID=0');
                    $oMoneda=moneda::getByID($osalida->moneda_ID);

                   $i=0;
                    foreach ($dtFactura_Venta_Detalle as $item){
                        $osalida_Detalle=salida_detalle::getByID($item['salida_detalle_ID']);
                        $oProducto=producto::getByID($osalida_Detalle->producto_ID);
                        $html.='<tr>';
                        $html.='<td id="td'.$i.'" width="85.4px" style="text-align:center; padding-top: 10px; border:none;font-weight: bold;">'. $osalida_Detalle->cantidad.' </td>';
                        $html.='<td width="524.3px" style="padding:0 20px;padding-top: 10px;border:none;"><span style="font-weight: bold;">'. FormatTextViewHtml($oProducto->nombre).'</span>';
                        if(trim($osalida_Detalle->descripcion)!=""){
                             $html.='<span style="text-align: justify;">'. nl2br(FormatTextViewHtml($osalida_Detalle->descripcion)) .'</span>';
                        }


                        $dtsalida_detalle_Componente=salida_detalle::getGridLista("ovd.salida_detalle_ID=".$osalida_Detalle->ID . ' and ovd.obsequio=0');
                        if(count($dtsalida_detalle_Componente)>0){
                            $html.='<br/>';
                            foreach($dtsalida_detalle_Componente as $componente){
                                $html.='<span>'.$componente['producto'].'&nbsp;&nbsp;('.$componente['cantidad'].'&nbsp;'.$componente['unidad_medida'].')</span><br/>';
                            }
                        }
                        $html.='</td>';
                        $subtotal=0;
                        $precio_unitario=0;
                        if($osalida->moneda_ID==1){
                            $subtotal=$osalida_Detalle->precio_venta_subtotal_soles;
                            $precio_unitario=$osalida_Detalle->precio_venta_unitario_soles;
                        }else {
                            $subtotal=$osalida_Detalle->precio_venta_subtotal_dolares;
                            $precio_unitario=$osalida_Detalle->precio_venta_unitario_dolares;
                        }
                        $html.='<td width="71.6px" style="text-align:right;padding-top: 10px;border:none;font-weight: bold; padding-right: 10px;">'. $precio_unitario.'</td>';
                        $html.='<td width="100.7px" style="text-align:right;padding-top: 10px;border:none;font-weight: bold; padding-right: 10px;">'. $subtotal . '</td>';
                        $html.='</tr>';
                        $i=$i+1;
                    }

                    $html.='</table>';
                    $arrayHtml[$value['ID']]=$html;

                }

                $retorna=$arrayHtml;

                break;
            case 6:
                $osalida=salida::getByID($salida_ID);
                $dtFactura_Venta=factura_venta::getGrid('salida_ID='.$salida_ID);
                $arrayHtml=array();
                foreach($dtFactura_Venta as $value){
                    $dtFactura_Venta_Detalle=factura_venta_detalle::getGrid('factura_venta_ID='.$value['ID']);
                    $html ='<table cellsspacin="0" cellspadding="0" id="tablaproducto">';
                    //$dtsalida_detalle=salida_detalle::getGridLista("ovd.salida_ID=".$salida_ID. ' and ovd.salida_detalle_ID=0');
                    $oMoneda=moneda::getByID($osalida->moneda_ID);

                   $i=0;
                    foreach ($dtFactura_Venta_Detalle as $item){
                        $osalida_Detalle=salida_detalle::getByID($item['salida_detalle_ID']);
                        $oProducto=producto::getByID($osalida_Detalle->producto_ID);
                        $html.='<tr>';
                        $html.='<td id="td'.$i.'" width="85.4px" style="text-align:center; padding-top: 10px; border:none;font-weight: bold;">'. $osalida_Detalle->cantidad.' </td>';
                        $html.='<td width="524.3px" style="padding:0 20px;padding-top: 10px;border:none;"><span style="font-weight: bold;display:block;font-size: 14px; ">'. FormatTextViewHtml($oProducto->nombre).'</span>';
                        if(trim($osalida_Detalle->descripcion)!=""){
                             $html.='<span style="text-align: justify;">'. nl2br(FormatTextViewHtml($osalida_Detalle->descripcion)) .'</span>';
                        }


                        $dtsalida_detalle_Componente=salida_detalle::getGridLista("ovd.salida_detalle_ID=".$osalida_Detalle->ID . ' and ovd.obsequio=0');
                        if(count($dtsalida_detalle_Componente)>0){
                            $html.='<br/>';
                            foreach($dtsalida_detalle_Componente as $componente){
                                $dtInventario=inventario::getGrid('salida_detalle_ID='.$componente['ID'],-1,-1,'serie asc');
                                $series="";
                                if(count($dtInventario)>0){

                                    foreach ($dtInventario as $valorInventario){
                                        if($valorInventario['serie']!='NULL'){

                                            $series.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Número de Serie: ".$valorInventario['serie']."<br/>";
                                        }

                                    }
                                }
                                $precio='';
                                $subtotal=0;

                                if($componente['ver_precio']==1){
                                    if($osalida->moneda_ID==1){
                                        $subtotal=$componente['precio_venta_subtotal_soles'];

                                    }else {
                                         $subtotal=$componente['precio_venta_subtotal_dolares'];
                                    }

                                    $precio='('.$oMoneda->simbolo.' '.$subtotal.')';
                                }
                                $html.='<span style="font-weight: bold;">'.$componente['producto'].'&nbsp;&nbsp;('.$componente['cantidad'].'&nbsp;'.$componente['unidad_medida'].')'.$precio.'</span><br/>';
                                if($series!=""){
                                    $html.=$series;
                                }
                            }
                        }
                        $html.='</td>';
                        $subtotal=0;
                        $precio_unitario=0;
                        if($osalida->moneda_ID==1){
                            $subtotal=$osalida_Detalle->precio_venta_subtotal_soles;
                            $precio_unitario=$osalida_Detalle->precio_venta_unitario_soles;
                        }else {
                            $subtotal=$osalida_Detalle->precio_venta_subtotal_dolares;
                            $precio_unitario=$osalida_Detalle->precio_venta_unitario_dolares;
                        }
                        $html.='<td width="71.6px" style="text-align:right;padding-top: 10px;border:none;font-weight: bold; padding-right: 10px;">'. $precio_unitario.'</td>';
                        $html.='<td width="100.7px" style="text-align:right;padding-top: 10px;border:none;font-weight: bold; padding-right: 10px;">'. $subtotal . '</td>';
                        $html.='</tr>';
                        $i=$i+1;
                    }

                    $html.='</table>';
                    $arrayHtml[$value['ID']]=$html;

                }

                $retorna=$arrayHtml;

            break;
        }

        return $retorna;

    }

    function post_ajaxOrden_Venta_Grabar(){
        require ROOT_PATH.'models/salida.php';
        $id=$_POST['id'];
        $numero_pagina=$_POST['id1'];
        $nproducto_pagina=$_POST['id2'];

        try{
            $osalida=salida::getByID($id);
            $osalida->numero_pagina=$numero_pagina;
            $osalida->nproducto_pagina=$nproducto_pagina;
            $osalida->usuario_mod_id=$_SESSION['usuario_ID'];
            $osalida->actualizar();
            $resultado=1;
            $mensaje="";
        }catch(Exception $ex){
            $resultado=-1;
            $mensaje=$osalida->message;
        }


        $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);

        echo json_encode($retornar);
    }
    function get_Ventas_Mantenimiento_Guia_Imprimir($id){
        require ROOT_PATH . 'models/salida.php';
        require ROOT_PATH . 'models/salida_detalle.php';
        require ROOT_PATH . 'models/producto.php';
        require ROOT_PATH . 'models/factura_venta.php';
        require ROOT_PATH . 'models/guia_venta_numero.php';
        require ROOT_PATH . 'models/guia_venta.php';
        if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";;
        require ROOT_PATH . 'models/chofer.php';
        require ROOT_PATH . 'models/vehiculo.php';
        require ROOT_PATH . 'models/cliente.php';
        require ROOT_PATH . 'models/inventario.php';
        global  $returnView_float;
        $returnView_float=true;

        $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
        $oGuia_Venta=guia_venta::getByID($id);
        $oGuia_Venta->impresion=1;
        $oGuia_Venta->usuario_mod_id=$_SESSION['usuario_ID'];
        $oGuia_Venta->actualizar();
        /*===========================================================*/
        $oFactura_Venta=factura_venta::getByID($oGuia_Venta->factura_venta_ID);


        $oFactura_Venta1=factura_venta::getByID($oGuia_Venta->factura_venta_ID);
        $osalida=salida::getByID($oFactura_Venta->salida_ID);

        /*Actualizamos el estado de la orden de venta a facturado*/
        $osalida->estado_ID=40;
        $osalida->usuario_mod_id=$_SESSION['usuario_ID'];
        $osalida->actualizar();
        /*=========================================================*/
        $dtsalida_detalle=salida_detalle::getGridLista("ovd.salida_ID=".$osalida->ID);
        $dtGuia_Venta_Numero=guia_venta_numero::getGrid('guia_venta_ID='.$oGuia_Venta->ID);
        /*Actualizamos el numero de la guia que no estem remitidas ni por remitir*/
        if($oGuia_Venta->estado_ID==36||$oGuia_Venta->estado_ID==37){
            foreach($dtGuia_Venta_Numero as $item1){
            $oGuia_Venta_Numero=guia_venta_numero::getByID($item1['ID']);
            $oGuia_Venta_Numero->numero=$oDatos_Generales->correlativo_guia+1;
            $oGuia_Venta_Numero->numero_concatenado=  FormatTextSave(sprintf("%'.03d",$oDatos_Generales->serie_guia).' - N° '.sprintf("%'.07d",$oGuia_Venta_Numero->numero));
            $oGuia_Venta_Numero->usuario_mod_id=$_SESSION['usuario_ID'];
            $oGuia_Venta_Numero->actualizar();
            $oDatos_Generales->correlativo_guia=$oGuia_Venta_Numero->numero;
            $oDatos_Generales->usuario_mod_id=$_SESSION['usuario_ID'];
            $oDatos_Generales->actualizar();
            }
        }

        $dtGuia_Venta_Numero1=guia_venta_numero::getGrid('guia_venta_ID='.$oGuia_Venta->ID);
        $html=mostrar_productos($osalida->ID,2);
        $numero=0;
        $array_numero=array();
        foreach($dtGuia_Venta_Numero1 as $item2){
            $array=array();
            $array['numero']=$item2['numero'];
            $oFactura_Venta1=factura_venta::getByID($item2['factura_venta_ID']);
            $array['numero_factura']=$oFactura_Venta1->numero;
           array_push($array_numero,$array);

        }
        $oCliente=cliente::getByID($osalida->cliente_ID);
        $oVehiculo=vehiculo::getByID($oGuia_Venta->vehiculo_ID);
        if($oGuia_Venta->vehiculo_ID==0){
            $oVehiculo->marca="";
            $oVehiculo->placa="";
        }

        $oChofer=chofer::getByID($oGuia_Venta->chofer_ID);
        if($oGuia_Venta->chofer_ID==0){
            $oChofer->licencia_conducir="";
        }

        $GLOBALS['html']=$html;
        $GLOBALS['osalida']=$osalida;
        $GLOBALS['dtsalida_detalle']=$dtsalida_detalle;
        $GLOBALS['oDatos_Generales']=$oDatos_Generales;
        $GLOBALS['oGuia_Venta']=$oGuia_Venta;

        $GLOBALS['numeros']= $array_numero;
        //$GLOBALS['numero']=$numero;
        $GLOBALS['oCliente']=$oCliente;
        $GLOBALS['oVehiculo']=$oVehiculo;
        $GLOBALS['oChofer']=$oChofer;
        $GLOBALS['oFactura_Venta']=$oFactura_Venta1;

    }
    function get_Ventas_Mantenimiento_Guia_Imprimir_Confirmacion($id){
        require ROOT_PATH . 'models/factura_venta.php';
        require ROOT_PATH . 'models/guia_venta_numero.php';
        require ROOT_PATH . 'models/guia_venta.php';
        require ROOT_PATH . 'models/salida.php';
        global  $returnView_float;
        $returnView_float=true;
        /*$salida_ID=$id;
        $osalida=salida::getByID($salida_ID);
        */
        $oGuia_Venta=guia_venta::getByID($id);
        $dtGuia_Venta_Numero1=guia_venta_numero::getGrid("guia_venta_ID=".$oGuia_Venta->ID);
            $numeros="";
            $numero_principal=1;

            foreach($dtGuia_Venta_Numero1 as $item3) {
                     $numeros.=$item3['numero_concatenado']."\n";
            }
        $oFactura_Venta=factura_venta::getByID($oGuia_Venta->factura_venta_ID);
        $GLOBALS['dtGuia_Venta_Numero']=$dtGuia_Venta_Numero1;
        $GLOBALS['Numeros']=$numeros;
        $GLOBALS['oGuia_Venta']=$oGuia_Venta;
        $GLOBALS['oFactura_Venta']=$oFactura_Venta;

    }
    function post_Ventas_Mantenimiento_Guia_Imprimir_Confirmacion($id){
        require ROOT_PATH . 'models/factura_venta.php';
        require ROOT_PATH . 'models/guia_venta.php';
        require ROOT_PATH . 'models/guia_venta_numero.php';
        require ROOT_PATH . 'models/salida.php';
        if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";;
        global  $returnView_float;
        $returnView_float=true;
        $impresion=$_POST['selImpresion'];
        $observacion=$_POST['txtObservacion'];

        try{
            $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
            $oGuia_Venta=guia_venta::getByID($id);
            $oFactura_Venta=factura_venta::getByID($oGuia_Venta->factura_venta_ID);
            $dtGuia_Venta_Numero=guia_venta_numero::getGrid('guia_venta_ID='.$oGuia_Venta->ID);
            $i=1;
            $secuencia="";
            $numero="";
            foreach($dtGuia_Venta_Numero as $item){

                if($i==1){
                    $numero=sprintf("%'.07d",$item['numero']);
                }
                $secuencia.=$item['numero_concatenado'];
                $i++;
            }

        if($impresion==1){
            /*Actualizamos el estado de la guia de venta a emitido*/
            $oGuia_Venta->estado_ID=38;
            $oGuia_Venta->usuario_mod_id=$_SESSION['usuario_ID'];
            $oGuia_Venta->observacion=$observacion;
            $oGuia_Venta->impresion=0;
            $oGuia_Venta->actualizarEstado();

             /*Actualizamos el estado de la factura de venta a emitido*/
           /* $oFactura_Venta->usuario_mod_id=$_SESSION['usuario_ID'];
            $oFactura_Venta->estado_ID=41;
            $oFactura_Venta->observacion=$observacion;
            $oFactura_Venta->actualizarEstado();

            /*Actualizamos el estado de la orden de venta*/
            $osalida=salida::getByID($oFactura_Venta->salida_ID);
            $osalida->usuario_mod_id=$_SESSION['usuario_ID'];
            $osalida->estado_ID=42;
            $osalida->actualizar();
            $osalida->actualizarImpresion(0);

            $mensaje="Se imprimió correctamente";
        }else if($impresion==2) {
            /*Dejamos los documentos con el estado por remitir*/
            $osalida=salida::getByID($oFactura_Venta->salida_ID);
            $oGuia_Venta->estado_ID=44;
            $oGuia_Venta->usuario_mod_id=$_SESSION['usuario_ID'];
            $oGuia_Venta->observacion=$observacion;
            $oGuia_Venta->actualizarEstado();
            $osalida->actualizarImpresion(1);
             /*Si se activa la opcion de cambiar número*/
            /*Actualizamos el número de la factura*/
            $dtGuia_Venta_Numero1=guia_venta_numero::getGrid('guia_venta_ID='.$oGuia_Venta->ID);
            foreach($dtGuia_Venta_Numero1 as $item){
                if(isset($_POST['ck'.$item['ID']])){
                    $guia_venta_numero_ID=$_POST['ck'.$item['ID']];
                    $numero_guia=$_POST[$guia_venta_numero_ID];
                    $oGuia_Venta_Numero=guia_venta_numero::getByID($guia_venta_numero_ID);
                    $oGuia_Venta_Numero->numero=$numero_guia;
                    $oGuia_Venta_Numero->numero_concatenado=  FormatTextSave(sprintf("%'.03d",$oDatos_Generales->serie_guia)."-N°". sprintf("%'.07d",$numero_guia));
                    $oGuia_Venta_Numero->usuario_mod_id=$_SESSION['usuario_ID'];
                    $oGuia_Venta_Numero->actualizar();
                    /*Actualizamos el correlativo oficial*/

                    $oDatos_Generales->correlativo_guia=$numero_guia;
                    $oDatos_Generales->usuario_mod_id=$_SESSION['usuario_ID'];
                    $oDatos_Generales->actualizar();
                }
            }
                $mensaje="Por favor vuelve a imprimir";
            }
            $resultado=1;
        }catch(Exception $ex){
          $resultado=-1;
          $mensaje=$ex->getMessage();
        }
        $GLOBALS['numero']=$numero;
        $GLOBALS['secuencia']=$secuencia;
        $GLOBALS['oGuia_Venta']=$oGuia_Venta;
        //$GLOBALS['oFactura_Venta']=$oFactura_Venta;
        $GLOBALS['resultado']=$resultado;
        $GLOBALS['mensaje']=$mensaje;
    }
    /*
    function post_ajaxHistorial_Producto(){

        require ROOT_PATH.'models/producto.php';
        require ROOT_PATH.'models/salida.php';
        require ROOT_PATH.'models/salida_detalle.php';
        require ROOT_PATH.'models/ingreso.php';
        require ROOT_PATH.'models/ingreso_detalle.php';
        require ROOT_PATH.'models/moneda.php';
        require ROOT_PATH.'models/proveedor.php';
        require ROOT_PATH.'models/cliente.php';
        //$oGuia_Venta=guia_venta::getByID($id);
        $id=$_POST['id'];

        $html='<div class="row">';
        $html.='<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">';
        $html.='<div class="panel panel-'.$_SESSION['cabecera'].'">';
        $html.='<div class="panel-heading">Compras</div>';
        $html.='<div class="panel-body">';
        $html.="<table class='table table-hover vista-grid'><tr><thead><th>Fecha</th><th>Precio U.</th><th>Cantidad</th><th>Proveedor</th></tr></thead>";
        $html.="<tbody>";
        $i=0;
        $dtCompra_Detalle=ingreso_detalle::getGrid('ccd.producto_ID='.$id,0,20,'co.fecha_emision desc');
        if(count($dtCompra_Detalle)>0){
            foreach($dtCompra_Detalle as $item){
                $oCompra=ingreso::getByID($item['ingreso_ID']);
                $oMoneda=moneda::getByID($oCompra->moneda_ID);
                
                if($oCompra=null){
                    $oCompra=new ingreso();
                    $oMoneda=new moneda();
                }
               
                
                $html.="<tr>";
                $html.="<td>".$oCompra->fecha_emision."</td>";
                $html.="<td style='text-align:right;'>".$oMoneda->simbolo.' '.$item['precio']."</td>";
                $html.="<td style='text-align:center;'>".$item['cantidad']."</td>";
                $oProveedor=proveedor::getByID($oCompra->proveedor_ID);
                $html.="<td>".FormatTextView(strtoupper($oProveedor->razon_social))."</td>";
                $html.="</tr>";
                $i++;
            }
        }
        $html.="</tbody>";
        $html.="</table>";
        $html.='</div>';
        $html.='</div>';
        $html.='</div>';
        $html.='<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">';
         $html.='<div class="panel panel-'.$_SESSION['cabecera'].'">';
        $html.='<div class="panel-heading">Ventas</div>';
        $html.='<div class="panel-body">';
        $html.="<table class='table table-hover vista-grid'><tr><thead><th>Fecha</th><th>Precio U.</th><th>Cantidad</th><th>Cliente</th></tr></thead>";
        $html.="<tbody>";
        $dtsalida_Detalle=salida_detalle::getGridLista('producto_ID='.$id,0,20,'ov.fecha desc');
        foreach($dtsalida_Detalle as $value){
            $osalida=salida::getByID($value['salida_ID']);
            $oMoneda=moneda::getByID($osalida->moneda_ID);
            $html.="<tr>";
            $html.="<td>".$osalida->fecha."</td>";
            $precio_venta_unitario=0;

            if($oMoneda->moneda_ID==1){
                $precio_venta_unitario=$value['precio_venta_unitario_soles'];
            }else {
                $precio_venta_unitario=$value['precio_venta_unitario_dolares'];
            }
            $html.="<td style='text-align:right;'>".$oMoneda->simbolo.' '.$precio_venta_unitario."</td>";
            $html.="<td style='text-align:center;'>".$value['cantidad']."</td>";
            $oCliente=cliente::getByID($osalida->cliente_ID);
            $html.="<td >".FormatTextViewHtml($oCliente->razon_social)."</td>";
            $html.="</tr>";
        }

        $html.="</tbody>";
        $html.="</table>";
        $html.='</div>';
        $html.='</div>';
        $html.='</div>';
        $html.='</div>';
        $retornar=Array('html'=>$html);

        echo json_encode($retornar);
    }*/
    function get_Ventas_Mantenimiento_Factura_Imprimir($id){
        require ROOT_PATH . 'models/salida.php';
        require ROOT_PATH . 'models/salida_detalle.php';
        require ROOT_PATH . 'models/producto.php';
        require ROOT_PATH . 'models/factura_venta.php';
        require ROOT_PATH . 'models/factura_venta_detalle.php';
        require ROOT_PATH . 'models/guia_venta_numero.php';
        require ROOT_PATH . 'models/guia_venta.php';
        if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";;
        require ROOT_PATH . 'models/chofer.php';
        require ROOT_PATH . 'models/vehiculo.php';
        require ROOT_PATH . 'models/cliente.php';
        require ROOT_PATH . 'include/lib_fecha_texto.php';
        require ROOT_PATH . 'models/operador.php';
        require ROOT_PATH . 'models/moneda.php';
        require ROOT_PATH . 'models/numero_cuenta.php';
        require ROOT_PATH . 'models/salida_numero_cuenta.php';
        require ROOT_PATH . 'models/inventario.php';

        global  $returnView_float;
        $returnView_float=true;
        $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
        $salida_ID=$id;

        $osalida=salida::getByID($salida_ID);

        /*Actualizamos el estado de la orden de venta a facturado*/
        $osalida->estado_ID=40;
        $osalida->usuario_mod_id=$_SESSION['usuario_ID'];
        $osalida->impresion=1;
        $osalida->actualizar();
        /*=========================================================*/
        //Actualizamos los números
        $dtFactura_Venta1=factura_venta::getGrid('salida_ID='.$salida_ID);
        foreach($dtFactura_Venta1 as $value1){
            $oFactura_Venta1=factura_venta::getByID($value1['ID']);
            if($value1['estado_ID']==34){
                $oFactura_Venta1->numero=$oDatos_Generales->correlativo_factura+1;
                $oFactura_Venta1->numero_concatenado=sprintf("%'.07d",$oFactura_Venta1->numero);
                $oFactura_Venta1->usuario_mod_id=$_SESSION['usuario_ID'];
                $oFactura_Venta1->impresion=1;
                $oFactura_Venta1->estado_ID=35;
                $oFactura_Venta1->actualizar();
                $oDatos_Generales->correlativo_factura=$oFactura_Venta1->numero;
                $oDatos_Generales->usuario_mod_id=$_SESSION['usuario_ID'];
                $oDatos_Generales->actualizar();
            }
        }


        $dtFactura_Venta=factura_venta::getGrid('salida_ID='.$salida_ID);
        $factura=array();

        foreach($dtFactura_Venta as $value){

            $arrayFactura=array();
            $oFactura_Venta=factura_venta::getByID($value['ID']);

            $fecha=FormatTextToDate($oFactura_Venta->fecha_emision,'d/m/Y');
            $arrayFactura['fecha']=$fecha;
            $arrayFactura['fecha_vencimiento']=FormatTextToDate($oFactura_Venta->fecha_vencimiento,'d/m/Y');
            $arrayFactura['fecha_texto']=explode('de',fechaATexto($fecha));

            $arrayFactura['numero_cuenta']=mostrarNumeroCuentas(3,$osalida->moneda_ID,$osalida);
            $oOperador=operador::getByID($osalida->operador_ID);
            $arrayFactura['operador']=$oOperador->nombres." ".$oOperador->apellido_paterno;

            $dtFactura_Venta_Detalle=factura_venta_detalle::getGrid('factura_venta_ID='.$value['ID']);
            $precio_venta_neto=0;
            $vigv=0;
            $precio_venta_total=0;

            foreach($dtFactura_Venta_Detalle as $item){
                $osalida_Detalle=salida_detalle::getByID($item['salida_detalle_ID']);
                if($osalida->moneda_ID==1){
                    $precio_venta_neto=$precio_venta_neto+$osalida_Detalle->precio_venta_subtotal_soles;
                    $vigv=$vigv+$osalida_Detalle->vigv_soles;
                    $precio_venta_total=$precio_venta_total+$osalida_Detalle->precio_venta_soles;


                } else {
                    $precio_venta_neto=$precio_venta_neto+$osalida_Detalle->precio_venta_subtotal_dolares;
                    $vigv=$vigv+$osalida_Detalle->vigv_dolares;
                    $precio_venta_total=$precio_venta_total+$osalida_Detalle->precio_venta_dolares;

                }

            }
            $arrayFactura['igv']=$osalida->igv;
            $arrayFactura['precio_venta_neto']=number_format($precio_venta_neto,2);
            $arrayFactura['vigv']=number_format($vigv,2);
            $arrayFactura['precio_venta_total']=number_format($precio_venta_total,2);



            $total_facturado=explode(".",$precio_venta_total);
            $oMoneda=moneda::getByID($value['moneda_ID']);
            $decimal="00";
            if(isset($total_facturado[1])){
                if(strlen($total_facturado[1])==1){
                    $decimal=$total_facturado[1].'0';
                }else {
                    $decimal=$total_facturado[1];
                }

            }
            $arrayFactura['precios_texto']="SON ".numtoletras($total_facturado[0])." CON ".$decimal."/100 ".str_replace("ó","O",strtoupper(FormatTextViewHtml($oMoneda->descripcion))).".";
         $factura[$value['ID']]=$arrayFactura;
        }
        $oCliente=cliente::getByID($osalida->cliente_ID);

        //$total_facturado=explode(".",$oFactura_Venta->total);
        //$oFactura_Venta->totaltexto="SON ".numtoletras($total_facturado[0])." CON ".$total_facturado[1]."/100 SOLES.";
        $GLOBALS['osalida']=$osalida;
        $GLOBALS['factura_venta']=$factura;
        $GLOBALS['dtFactura_venta']=$dtFactura_Venta;
        $GLOBALS['html']= mostrar_productos($osalida->ID,6);
        $GLOBALS['oDatos_Generales']=$oDatos_Generales;
        $GLOBALS['oCliente']=$oCliente;
        $GLOBALS['oOperador']=operador::getByID($osalida->operador_ID);

        //$GLOBALS['oFactura_Venta']=$oFactura_Venta;

    }
    function get_Ventas_Mantenimiento_Factura_Imprimir_Confirmacion($id){
        require ROOT_PATH . 'models/factura_venta.php';
        require ROOT_PATH . 'models/salida.php';
        //require ROOT_PATH . 'models/guia_venta_numero.php';
        //require ROOT_PATH . 'models/guia_venta.php';
        global  $returnView_float;
        $returnView_float=true;
        $salida_ID=$id;
        $osalida=salida::getByID($salida_ID);
        $osalida->actualizarImpresion(1);
        $dtFactura_Venta=factura_venta::getGrid('salida_ID='.$salida_ID);
        $html="";
        foreach($dtFactura_Venta as $item){
            $html.=sprintf("%'.07d",$item['numero'])."\n";
        }
        $GLOBALS['dtFactura_Venta']=$dtFactura_Venta;
        $GLOBALS['html']=$html;
        $GLOBALS['osalida']=$osalida;

    }
    function post_Ventas_Mantenimiento_Factura_Imprimir_Confirmacion($id){
        require ROOT_PATH . 'models/factura_venta.php';
        require ROOT_PATH . 'models/guia_venta.php';
        require ROOT_PATH . 'models/salida.php';
        if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";;
        global  $returnView_float;
        $returnView_float=true;
        $impresion=$_POST['selImpresion'];
        $observacion=$_POST['txtObservacion'];

        try{
            $boton_imprimir=1;
            $salida_ID=$id;
            $osalida=salida::getByID($salida_ID);
            $dtFactura_Venta=factura_venta::getGrid('salida_ID='.$salida_ID);
            $valor_impresion=0;
            foreach($dtFactura_Venta as $item){
                $oFactura_Venta=factura_venta::getByID($item['ID']);
                if($impresion==1){
                        $oFactura_Venta->estado_ID=41;
                        if($oFactura_Venta->con_guia==1){
                            $valor_impresion=1;
                        }else {
                          $valor_impresion=0;
                        }

                        $boton_imprimir=0;

                }else {
                    $oFactura_Venta->estado_ID=43;
                    $valor_impresion=1;
                    /*Actualizamos el número de la factura*/
                    if(isset($_POST['ck'.$item['ID']])){
                        $factura_venta_ID=$_POST['ck'.$item['ID']];
                        $numero_factura=$_POST[$factura_venta_ID];
                        $oFactura_Venta1=factura_venta::getByID($factura_venta_ID);
                        $oFactura_Venta1->numero=$numero_factura;
                        $oFactura_Venta1->numero_concatenado=sprintf("%'.07d",$numero_factura);
                        $oFactura_Venta1->usuario_mod_id=$_SESSION['usuario_ID'];
                        $oFactura_Venta1->actualizar();
                        /*Actualizamos el correlativo oficial*/
                        $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
                        $oDatos_Generales->correlativo_factura=$numero_factura;
                        $oDatos_Generales->usuario_mod_id=$_SESSION['usuario_ID'];
                        $oDatos_Generales->actualizar();

                    }

                }
                    $oFactura_Venta->observacion=$observacion;
                    $oFactura_Venta->usuario_mod_id=$_SESSION['usuario_ID'];
                    $oFactura_Venta->actualizarEstado();
                   $osalida->actualizarImpresion($valor_impresion);
            }
            $resultado=1;
            $mensaje="Se imprimió correctamente";
        }catch(Exception $ex){
          $resultado=-1;
          $mensaje=$ex->getMessage();
        }
        $html="";

        foreach($dtFactura_Venta as $item){
            $html.=sprintf("%'.07d",$item['numero'])."\n";
        }
        $GLOBALS['dtFactura_Venta']=$dtFactura_Venta;
        $GLOBALS['html']=$html;
        $GLOBALS['osalida']=$osalida;
        $GLOBALS['boton_imprimir']=$boton_imprimir;
        $GLOBALS['resultado']=$resultado;
        $GLOBALS['mensaje']=$mensaje;
    }
    function post_ajaxVerificar_ImpresionFactura_Venta(){

        require ROOT_PATH.'models/factura_venta.php';
        require ROOT_PATH.'models/operador.php';
        require ROOT_PATH.'models/usuario.php';
        require ROOT_PATH.'models/salida.php';
        //$oGuia_Venta=guia_venta::getByID($id);
        $salida_ID=$_POST['id'];
        $dtFactura_Venta=factura_venta::getGrid('salida_ID<>'.$salida_ID .' and impresion=1');
        $resultado=0;
        $operador="";
        $numero_salida=0;
        if(count($dtFactura_Venta)>0){
            $resultado=0;
            foreach($dtFactura_Venta as $item){
                $oUsuario=usuario::getByID($item['usuario_mod_id']);
                $oOperador=operador::getByID($oUsuario->operador_ID);
                $operador=$oOperador->nombres.' '.$oOperador->apellido_paterno;
            }
        }else{
            $resultado=1;
        }

        $retornar=Array('resultado'=>$resultado,'operador'=>$operador);

        echo json_encode($retornar);
    }
    function post_ajaxVerificar_Impresion(){

        require ROOT_PATH.'models/guia_venta.php';
        require ROOT_PATH.'models/guia_venta_numero.php';
        require ROOT_PATH.'models/factura_venta.php';
        require ROOT_PATH.'models/operador.php';
        require ROOT_PATH.'models/usuario.php';
        require ROOT_PATH.'models/salida.php';

        //$oGuia_Venta=guia_venta::getByID($id);
        $salida_ID=$_POST['id'];
        $osalida=salida::getByID($salida_ID);
        $dtsalida=salida::getGrid('ov.impresion=1 and ov.ID <>'.$salida_ID);
        if(count($dtsalida)>0){
            $resultado=0;
            foreach($dtsalida as $item){
                $osalida_Impresion=salida::getByID($item['ID']);

                $oOperador=operador::getByID($item['usuario_mod_id']);
                $operador=$oOperador->nombres.' '.$oOperador->apellido_paterno;
                $numero=$osalida_Impresion->numero_concatenado   ;
            }
        }else {
            $resultado=1;
            $operador="";
            $numero="";
        }

        $retornar=Array('resultado'=>$resultado,'operador'=>$operador,'numero'=>$numero);

        echo json_encode($retornar);
    }
    function post_ajaxVerificarExistenciaProductos(){
        require ROOT_PATH . 'models/salida.php';
        require ROOT_PATH . 'models/salida_detalle.php';
        $salida_ID=$_POST['id'];

        try{
            if($salida_ID==0){
                $resultado=0;
                $mensaje='No ha registrado datos generales de la orden de venta.';
            }else {
                $dtsalida_Detalle=salida_detalle::getGrid('salida_ID='.$salida_ID.' and salida_detalle_ID=0 and obsequio=0');
                if(count($dtsalida_Detalle)>0){
                    $resultado=1;
                $mensaje='';
                }else {
                    $resultado=0;
                    $mensaje='No ha registrado productos, no puede generar factura, ni guia.';
                }
            }
        }
        catch(Exception $ex){
        $resultado = -1;
        $mensaje = $ex->getMessage();

        }

        $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
        echo json_encode($retornar);
    }
    //nueva funciones
    function post_ajaxOrden_Venta_Mantenimiento_Registro_Componente(){
        require ROOT_PATH.'models/salida_detalle.php';

        $salida_detalle_ID_padre=$_POST['id'];
        $html="";
        
        try{
            $dt=salida_detalle::getFilasComponentes($salida_detalle_ID_padre);
            $html=$dt[0]["filas"];
           
        }
        catch(Exception $ex){
            
            log_error(__FILE__,"salidaController.post_ajaxOrden_Venta_Mantenimiento_Registro_Componente",$ex->getMessage());
            $html.="Ocurrió un error en el sistema";

        }
       

        $retornar=Array('html'=>$html);
        echo json_encode($retornar);
    }
    function post_ajaxOrden_Venta_Mantenimiento_Registro_Adicional(){
        require ROOT_PATH.'models/producto.php';

        require ROOT_PATH.'models/salida_detalle.php';
        require ROOT_PATH.'models/salida.php';

        $salida_detalle_ID_padre=$_POST['id'];
       
        $html="";
        try{
            $dt=salida_detalle::getFilasAdicionales($salida_detalle_ID_padre);
            $html=$dt[0]["filas"];
            
        }
        catch(Exception $ex){
            //$resultado=-1;
            log_error(__FILE__,"salidaController.post_ajaxOrden_Venta_Mantenimiento_Registro_Adicional",$ex->getMessage());
            $html=$ex->getMessage();
        }
        

        $retornar=Array('html'=>$html);
        echo json_encode($retornar);
    }
    function post_ajaxLlenarCajas(){
        require ROOT_PATH.'models/producto.php';
        require ROOT_PATH.'models/salida_detalle.php';
        require ROOT_PATH.'models/salida.php';

        $ID=$_POST['id'];
        $osalida_Detalle=salida_detalle::getByID($ID);
        $osalida=salida::getByID($osalida_Detalle->salida_ID);

        try{
            $precio_venta_subtotal_soles_hijo=0;
            $precio_venta_subtotal_dolares_hijo=0;
            $adicional_soles=0;
            $adicional_dolares=0;

            $dtsalida_Detalle=salida_detalle::getGrid('salida_ID='.$osalida_Detalle->salida_ID.' and salida_detalle_ID='.$ID.' and tipo_ID in (3,4)',-1,-1,'ID asc');
            foreach($dtsalida_Detalle as $item){
                switch($item['tipo_ID']){
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
            switch($osalida_Detalle->tipo_ID){
                case 2://Producto con componente

                    $osalida_Detalle->adicional_soles='';
                    $osalida_Detalle->adicional_dolares='';
                    $osalida_Detalle->subtotal_soles1='';
                    $osalida_Detalle->subtotal_dolares1='';
                    break;
                case 5://producto con componente y adicional
                    $osalida_Detalle->precio_venta_unitario_soles=$precio_venta_subtotal_soles_hijo;
                    $osalida_Detalle->precio_venta_unitario_dolares=$precio_venta_subtotal_dolares_hijo;
                    $osalida_Detalle->adicional_soles=$adicional_soles;
                    $osalida_Detalle->adicional_dolares=$adicional_dolares;
                    $osalida_Detalle->subtotal_soles1=$osalida_Detalle->precio_venta_subtotal_soles;
                    $osalida_Detalle->subtotal_dolares1=$osalida_Detalle->precio_venta_subtotal_dolares;
                    $osalida_Detalle->precio_venta_subtotal_soles=$precio_venta_subtotal_soles_hijo*$osalida_Detalle->cantidad;
                    $osalida_Detalle->precio_venta_subtotal_dolares=$precio_venta_subtotal_dolares_hijo*$osalida_Detalle->cantidad;
                    break;
                case 6://producto con adicional
                    $osalida_Detalle->precio_venta_unitario_soles=($osalida_Detalle->precio_venta_subtotal_soles-$adicional_soles)/$osalida_Detalle->cantidad;
                    $osalida_Detalle->precio_venta_unitario_dolares=($osalida_Detalle->precio_venta_subtotal_dolares-$adicional_dolares)/$osalida_Detalle->cantidad;
                    $osalida_Detalle->adicional_soles=$adicional_soles;
                    $osalida_Detalle->adicional_dolares=$adicional_dolares;
                    $osalida_Detalle->subtotal_soles1=$osalida_Detalle->precio_venta_subtotal_soles;
                    $osalida_Detalle->subtotal_dolares1=$osalida_Detalle->precio_venta_subtotal_dolares;
                    $osalida_Detalle->precio_venta_subtotal_soles=$osalida_Detalle->precio_venta_subtotal_soles-$adicional_soles;
                    $osalida_Detalle->precio_venta_subtotal_dolares=$osalida_Detalle->precio_venta_subtotal_dolares-$adicional_dolares;
                    break;
            }
            $precio_venta_subtotal_soles1=$osalida_Detalle->subtotal_soles1;
            $precio_venta_subtotal_soles=$osalida_Detalle->precio_venta_subtotal_soles;
            $precio_venta_unitario_soles=$osalida_Detalle->precio_venta_unitario_soles;
            $vigv_soles=number_format($osalida_Detalle->vigv_soles,2,'.',',');
            $precio_venta_soles=number_format($osalida_Detalle->precio_venta_soles,2,'.',',');
            $adicional_soles=$osalida_Detalle->adicional_soles;

             //Precio en dolares
            $precio_venta_subtotal_dolares1=$osalida_Detalle->subtotal_dolares1;
            $precio_venta_subtotal_dolares=$osalida_Detalle->precio_venta_subtotal_dolares;
            $precio_venta_unitario_dolares=$osalida_Detalle->precio_venta_unitario_dolares;
            $vigv_dolares=number_format($osalida_Detalle->vigv_dolares,2,'.',',');
            $precio_venta_dolares=number_format($osalida_Detalle->precio_venta_dolares,2,'.',',');
            $adicional_dolares=$osalida_Detalle->adicional_dolares;
            $resultado=1;
            $mensaje='';
        }
        catch(Exception $ex){
            $resultado=-1;
            $mensaje=$ex->getMessage();
        }
        $retornar=Array('mensaje'=>$mensaje,'resultado'=>$resultado,'precio_venta_unitario_soles'=>$precio_venta_unitario_soles,
            'precio_venta_subtotal_soles'=>$precio_venta_subtotal_soles,'vigv_soles'=>$vigv_soles,'precio_venta_soles'=>$precio_venta_soles,
            'precio_venta_unitario_dolares'=>$precio_venta_unitario_dolares,'precio_venta_subtotal_dolares'=>$precio_venta_subtotal_dolares,
            'vigv_dolares'=>$vigv_dolares,'precio_venta_dolares'=>$precio_venta_dolares,'adicional_soles'=>$adicional_soles,
            'adicional_dolares'=>$adicional_dolares,'precio_venta_subtotal_soles1'=>$precio_venta_subtotal_soles1,'precio_venta_subtotal_dolares1'=>$precio_venta_subtotal_dolares1
            );
        echo json_encode($retornar);
    }
    function llenarValores($osalida_Detalle){
        if(!class_exists('producto')){
            require ROOT_PATH.'models/producto.php';
        }
        if(!class_exists('salida_detalle')){
            require ROOT_PATH.'models/salida_detalle.php';
        }
        if(!class_exists('salida')){
            require ROOT_PATH.'models/salida.php';
        }
        try{

            $osalida=salida::getByID($osalida_Detalle->salida_ID);
            $precio_venta_subtotal_soles_hijo=0;
            $precio_venta_subtotal_dolares_hijo=0;
            $adicional_soles=0;
            $adicional_dolares=0;

            $dtsalida_Detalle=salida_detalle::getGrid('salida_ID='.$osalida_Detalle->salida_ID.' and salida_detalle_ID='.$osalida_Detalle->ID.' and tipo_ID in (3,4)',-1,-1,'ID asc');
            foreach($dtsalida_Detalle as $item){
                switch($item['tipo_ID']){
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
            switch($osalida_Detalle->tipo_ID){
                case 2://Producto con componente

                    $osalida_Detalle->adicional_soles='';
                    $osalida_Detalle->adicional_dolares='';
                    $osalida_Detalle->subtotal_soles1='';
                    $osalida_Detalle->subtotal_dolares1='';
                    break;
                case 5://producto con componente y adicional
                    $osalida_Detalle->precio_venta_unitario_soles=$precio_venta_subtotal_soles_hijo;
                    $osalida_Detalle->precio_venta_unitario_dolares=$precio_venta_subtotal_dolares_hijo;
                    $osalida_Detalle->adicional_soles=$adicional_soles;
                    $osalida_Detalle->adicional_dolares=$adicional_dolares;
                    $osalida_Detalle->subtotal_soles1=$osalida_Detalle->precio_venta_subtotal_soles;
                    $osalida_Detalle->subtotal_dolares1=$osalida_Detalle->precio_venta_subtotal_dolares;
                    $osalida_Detalle->precio_venta_subtotal_soles=$precio_venta_subtotal_soles_hijo*$osalida_Detalle->cantidad;
                    $osalida_Detalle->precio_venta_subtotal_dolares=$precio_venta_subtotal_dolares_hijo*$osalida_Detalle->cantidad;
                    break;
                case 6://producto con adicional
                    $osalida_Detalle->precio_venta_unitario_soles=($osalida_Detalle->precio_venta_subtotal_soles-$adicional_soles)/$osalida_Detalle->cantidad;
                    $osalida_Detalle->precio_venta_unitario_dolares=($osalida_Detalle->precio_venta_subtotal_dolares-$adicional_dolares)/$osalida_Detalle->cantidad;
                    $osalida_Detalle->adicional_soles=$adicional_soles;
                    $osalida_Detalle->adicional_dolares=$adicional_dolares;
                    $osalida_Detalle->subtotal_soles1=$osalida_Detalle->precio_venta_subtotal_soles;
                    $osalida_Detalle->subtotal_dolares1=$osalida_Detalle->precio_venta_subtotal_dolares;
                    $osalida_Detalle->precio_venta_subtotal_soles=$osalida_Detalle->precio_venta_subtotal_soles-$adicional_soles;
                    $osalida_Detalle->precio_venta_subtotal_dolares=$osalida_Detalle->precio_venta_subtotal_dolares-$adicional_dolares;
                    break;
            }

        }catch(Exception $ex){

        }
        return $osalida_Detalle;
    }
    function eliminar_inventario($osalida_Detalle){
        if(!class_exists('inventario')){
            require ROOT_PATH.'models/inventario.php';
        }
        if(!class_exists('salida_detalle')){
            require ROOT_PATH.'models/salida_detalle.php';
        }
        if(!class_exists('salida')){
            require ROOT_PATH.'models/salida.php';
        }

        try{
            $dtInventario=inventario::getGrid('salida_detalle_ID='.$osalida_Detalle->ID,-1,-1);

            foreach($dtInventario as $item){
                $oInventario=inventario::getByID($item['ID']);
                if($item['ingreso_detalle_ID']=='NULL'){
                    //Si no tiene una compra, se elimina el registro
                     $oInventario->eliminar();

                }else {
                    //Actualizamos y liberamos el inventario, ponemos para stock
                    $oInventario->usuario_mod_id=$_SESSION['usuario_ID'];
                    $oInventario->salida_detalle_ID='NULL';
                    $oInventario->estado_ID=48;
                    $oInventario->actualizar();
                    actualizarInventarioCostos($oInventario);
                }
            }
        }catch(Exception $ex){

        }
    }
    function post_ajaxOrden_Venta_Mantenimiento_Registro_Componente_Eliminar(){
        require ROOT_PATH.'models/salida_detalle.php';
        require ROOT_PATH.'models/salida.php';
        require ROOT_PATH.'models/inventario.php';
        $id=$_POST['id'];
        try{
            $osalida_Detalle=salida_detalle::getByID($id);
            $osalida_Detalle->usuario_mod_id=$_SESSION['usuario_ID'];

            eliminar_inventario($osalida_Detalle);
            if($osalida_Detalle==null){
                throw new Exception('Parece que el registro ya fue eliminado.');
            }

            if ($osalida_Detalle->eliminar()==-1){
                throw new Exception($osalida_Detalle->message);
            }
            $osalida_Detalle_Padre=salida_detalle::getByID($osalida_Detalle->salida_detalle_ID);
            actualizar_costo_orden_venta_detalle_padre($osalida_Detalle_Padre);
            actualizar_costos_padre($osalida_Detalle);


            $resultado=1;
            $mensaje='Se eliminó correctamente';

        }catch(Exception $ex){
            $resultado=-1;
            $mensaje=$ex->getMessage();

        }

        $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);

        echo json_encode($retornar);
    }
    function post_ajaxOrden_Venta_Mantenimiento_Registro_Adicional_Eliminar(){
        require ROOT_PATH.'models/salida_detalle.php';
        require ROOT_PATH.'models/salida.php';
        require ROOT_PATH.'models/inventario.php';
        $id=$_POST['id'];
        try{
            $osalida_Detalle=salida_detalle::getByID($id);
            $osalida_Detalle->usuario_mod_id=$_SESSION['usuario_ID'];
            eliminar_inventario($osalida_Detalle);
            if($osalida_Detalle==null){
                    throw new Exception('Parece que el registro ya fue eliminado.');
            }

            if ($osalida_Detalle->eliminar()==-1){
                    throw new Exception($oCotizacion_Detalle->message);
            }
             $osalida_Detalle_Padre=salida_detalle::getByID($osalida_Detalle->salida_detalle_ID);
            actualizar_costo_orden_venta_detalle_padre($osalida_Detalle_Padre);
            actualizar_costos_padre($osalida_Detalle);

            $resultado=1;
            $mensaje='Se eliminó correctamente';

        }catch(Exception $ex){
            $resultado=-1;
            $mensaje=$ex->getMessage();

        }

        $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);

        echo json_encode($retornar);
    }
    function get_Orden_Venta_Mantenimiento_Producto_Serie($salida_detalle_ID){
        require ROOT_PATH . 'models/categoria.php';
        require ROOT_PATH . 'models/linea.php';
        require ROOT_PATH . 'models/producto.php';
        require ROOT_PATH . 'models/estado.php';
        require ROOT_PATH . 'models/salida_detalle.php';
        require ROOT_PATH . 'models/salida.php';
        require ROOT_PATH . 'models/inventario.php';
        if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";;

        require ROOT_PATH . 'models/factura_venta.php';
        require ROOT_PATH . 'models/guia_venta.php';
        //require ROOT_PATH . 'models/guia_venta_numero.php';
        global $returnView_float;
        $returnView_float=true;

        $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);

        $osalida_Detalle=salida_detalle::getByID($salida_detalle_ID);
        $osalida_Detalle->oProducto=producto::getByID($osalida_Detalle->producto_ID);
        $dtInventario = inventario::getGridInventario('inv.salida_detalle_ID='.$salida_detalle_ID,-1,-1,'ID asc');
        //$dtInventario = array();
        $internos=0;
        if($osalida_Detalle->tipo_ID==2||$osalida_Detalle->tipo_ID==5||$osalida_Detalle->tipo_ID==6||$osalida_Detalle->tipo_ID==7){
            $dtsalida_Detalle_Hijos=salida_detalle::getGrid('salida_detalle_ID='.$osalida_Detalle->ID,-1,-1,'tipo_ID asc,producto_ID asc');
                foreach($dtsalida_Detalle_Hijos as $item){

                    $dtInventario_hijo=inventario::getGridInventario('inv.salida_detalle_ID='.$item['ID'],-1,-1,'ID asc');
                    $dtInventario=array_merge($dtInventario,$dtInventario_hijo);
                    $internos++;
                }

            }


        $osalida_Detalle->internos=$internos;
        $osalida_Detalle->dtInventario=$dtInventario;
        $GLOBALS['oOrden_Venta_Detalle']=$osalida_Detalle;

    }
    function post_Orden_Venta_Mantenimiento_Producto_Serie($salida_detalle_ID){
        require ROOT_PATH . 'models/categoria.php';
        require ROOT_PATH . 'models/linea.php';
        require ROOT_PATH . 'models/producto.php';
        require ROOT_PATH . 'models/estado.php';
        require ROOT_PATH . 'models/salida_detalle.php';
        require ROOT_PATH . 'models/salida.php';
        require ROOT_PATH . 'models/inventario.php';
        if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";;

        require ROOT_PATH . 'models/factura_venta.php';
        require ROOT_PATH . 'models/guia_venta.php';

        global $returnView_float;
        $returnView_float=true;
        $osalida_Detalle=salida_detalle::getByID($salida_detalle_ID);
        $internos=0;
        try{
            $dtInventario=inventario::getGridInventario('inv.salida_detalle_ID='.$salida_detalle_ID,-1,-1);
            foreach($dtInventario as $item){
                $oInventario=inventario::getByID($item['ID']);
                $oInventario->serie=$_POST[$item['ID']];
                $oInventario->usuario_mod_id=$_SESSION['usuario_ID'];
                $oInventario->actualizar();
            }

            if($osalida_Detalle->tipo_ID==2||$osalida_Detalle->tipo_ID==5||$osalida_Detalle->tipo_ID==6||$osalida_Detalle->tipo_ID==7){
                $dtsalida_Detalle_Hijos=salida_detalle::getGrid('salida_detalle_ID='.$osalida_Detalle->ID,-1,-1,'tipo_ID asc,producto_ID asc');
                foreach($dtsalida_Detalle_Hijos as $item){
                    $dtInventario_hijo=inventario::getGridInventario('inv.salida_detalle_ID='.$item['ID'],-1,-1,'ID asc');
                    foreach($dtInventario_hijo as $value){
                        $oInventario=inventario::getByID($value['ID']);
                        $oInventario->serie=$_POST[$value['ID']];
                        $oInventario->usuario_mod_id=$_SESSION['usuario_ID'];
                        $oInventario->actualizar();
                    }
                    $dtInventario=array_merge($dtInventario,$dtInventario_hijo);
                    $internos++;
                }

            }
            $resultado=1;
            $mensaje="Se actualizó correctamente";
        }catch (Exception $ex){
            $resultado=-1;
            $mensaje=$ex->getMessage();
        }
        $osalida_Detalle=salida_detalle::getByID($salida_detalle_ID);
        $osalida_Detalle->oProducto=producto::getByID($osalida_Detalle->producto_ID);
        ///$dtInventario = inventario::getGridInventario('inv.salida_detalle_ID='.$salida_detalle_ID,-1,-1,'ID asc');
        $osalida_Detalle->internos=$internos;
        $osalida_Detalle->dtInventario=$dtInventario;
        $GLOBALS['resultado']=$resultado;
        $GLOBALS['mensaje']=$mensaje;
        $GLOBALS['osalida_Detalle']=$osalida_Detalle;
    }
    function get_Orden_Venta_Mantenimiento_Producto_Serie_hijo($salida_detalle_ID){
        require ROOT_PATH . 'models/categoria.php';
        require ROOT_PATH . 'models/linea.php';
        require ROOT_PATH . 'models/producto.php';
        require ROOT_PATH . 'models/estado.php';
        require ROOT_PATH . 'models/salida_detalle.php';
        require ROOT_PATH . 'models/salida.php';
        require ROOT_PATH . 'models/inventario.php';
        if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";;

        require ROOT_PATH . 'models/factura_venta.php';
        require ROOT_PATH . 'models/guia_venta.php';

        global $returnView_float;
        $returnView_float=true;

        $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);

        $osalida_Detalle=salida_detalle::getByID($salida_detalle_ID);
        $cantidad=$osalida_Detalle->cantidad;
        if($osalida_Detalle->tipo_ID==3){
            $osalida_Detalle_Padre=salida_detalle::getByID($osalida_Detalle->salida_detalle_ID);
            $cantidad=$cantidad*$osalida_Detalle_Padre->cantidad;

        }
        $osalida_Detalle->cantidad=$cantidad;
        $osalida_Detalle->oProducto=producto::getByID($osalida_Detalle->producto_ID);
        $dtInventario = inventario::getGridInventario('inv.salida_detalle_ID='.$salida_detalle_ID,-1,-1,'ID asc');
        $osalida_Detalle->dtInventario=$dtInventario;
        $GLOBALS['oOrden_Venta_Detalle']=$osalida_Detalle;

    }
    function post_Orden_Venta_Mantenimiento_Producto_Serie_hijo($salida_detalle_ID){
    require ROOT_PATH . 'models/categoria.php';
    require ROOT_PATH . 'models/linea.php';
    require ROOT_PATH . 'models/producto.php';
    require ROOT_PATH . 'models/estado.php';
    require ROOT_PATH . 'models/salida_detalle.php';
    require ROOT_PATH . 'models/salida.php';
    require ROOT_PATH . 'models/inventario.php';
    if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";;

    require ROOT_PATH . 'models/factura_venta.php';
    require ROOT_PATH . 'models/guia_venta.php';

    global $returnView_float;
    $returnView_float=true;
    $osalida_Detalle=salida_detalle::getByID($salida_detalle_ID);
    try{
        $dtInventario=inventario::getGridInventario('inv.salida_detalle_ID='.$salida_detalle_ID,-1,-1);
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
    $osalida_Detalle=salida_detalle::getByID($salida_detalle_ID);
    $osalida_Detalle->oProducto=producto::getByID($osalida_Detalle->producto_ID);
    $dtInventario = inventario::getGridInventario('inv.salida_detalle_ID='.$salida_detalle_ID.' and fv.estado_ID!=53',-1,-1,'ID asc');
    $osalida_Detalle->dtInventario=$dtInventario;
    $GLOBALS['resultado']=$resultado;
    $GLOBALS['mensaje']=$mensaje;
    $GLOBALS['oOrden_Venta_Detalle']=$osalida_Detalle;
}
    function actualizar_costos_salida_detalle($osalida_old,$tipo_cambio){
        if(!class_exists('salida')){
            require ROOT_PATH.'models/salida.php';
        }
        if(!class_exists('salida_detalle')){
            require ROOT_PATH.'models/salida_detalle.php';
        }
         if(!class_exists('inventario')){
            require ROOT_PATH.'models/inventario.php';
        }
        $mensaje='';
        try{
            if($tipo_cambio!=$osalida_old->tipo_cambio){
                $dtsalida_Detalle=salida_detalle::getGrid('salida_ID='.$osalida_old->ID.' and tipo_ID in (1,2,5,6)',-1,-1,'ID asc');
                $sub_total=0;
                foreach($dtsalida_Detalle as $item){
                    //Actualizamos sus hijos
                    $precio_venta_unitario=0;
                    $dtsalida_Detalle_Hijos=salida_detalle::getGrid('salida_detalle_ID='.$item['ID'],-1,-1,'ID desc');
                    if(count($dtsalida_Detalle_Hijos)>0){
                        foreach($dtsalida_Detalle_Hijos  as $value){
                            $osalida_Detalle_Hijo=salida_detalle::getByID($value['ID']);

                             if($osalida_old->moneda_ID==1){
                                $osalida_Detalle_Hijo->precio_venta_unitario_dolares=number_format($osalida_Detalle_Hijo->precio_venta_unitario_soles/$tipo_cambio,2,'.','');
                                $osalida_Detalle_Hijo->precio_venta_subtotal_dolares=number_format($osalida_Detalle_Hijo->precio_venta_unitario_dolares*$osalida_Detalle_Hijo->cantidad,2,'.','');
                                $osalida_Detalle_Hijo->precio_venta_dolares=number_format($osalida_Detalle_Hijo->precio_venta_subtotal_dolares*($osalida_old->igv+1),2,'.','');
                                $osalida_Detalle_Hijo->vigv_dolares=number_format($osalida_Detalle_Hijo->precio_venta_subtotal_dolares*$osalida_old->igv,2,'.','');

                                if($value['tipo']==3){
                                //componente
                                    $precio_venta_unitario=$precio_venta_unitario+number_format($osalida_Detalle_Hijo->precio_venta_subtotal_dolares,2,'.','');
                                }else {
                                    //adicional
                                    $precio_venta_unitario=$precio_venta_unitario+number_format($osalida_Detalle_Hijo->precio_venta_subtotal_dolares/$item['cantidad'],2,'.','');
                                }
                            }else {
                                $osalida_Detalle_Hijo->precio_venta_unitario_soles=number_format($osalida_Detalle_Hijo->precio_venta_unitario_dolares*$tipo_cambio,2,'.','');
                                $osalida_Detalle_Hijo->precio_venta_subtotal_soles=number_format($osalida_Detalle_Hijo->precio_venta_unitario_soles*$osalida_Detalle_Hijo->cantidad,2,'.','');
                                $osalida_Detalle_Hijo->precio_venta_soles=number_format($osalida_Detalle_Hijo->precio_venta_subtotal_soles*($osalida_old->igv+1),2,'.','');
                                $osalida_Detalle_Hijo->vigv_soles=number_format($osalida_Detalle_Hijo->precio_venta_subtotal_soles*$osalida_old->igv,2,'.','');

                                if($value['tipo']==3){
                                //componente
                                    $precio_venta_unitario=$precio_venta_unitario+number_format($osalida_Detalle_Hijo->precio_venta_subtotal_soles,2,'.','');
                                }else {
                                    //adicional
                                    $precio_venta_unitario=$precio_venta_unitario+number_format($osalida_Detalle_Hijo->precio_venta_subtotal_soles/$item['cantidad'],2,'.','');
                                }
                            }

                            $osalida_Detalle_Hijo->usuario_mod_id=$_SESSION['usuario_ID'];
                            $osalida_Detalle_Hijo->actualizar();
                            //Actualizamos los costos en el inventario
                           // ============================================
                            $dtInventario=inventario::getGrid('salida_detalle_ID='.$osalida_Detalle_Hijo->ID,-1,-1);
                            foreach($dtInventario as $valor){
                                $oInventario=inventario::getByID($valor['ID']);
                                actualizarInventarioCostos($oInventario);
                            }
                            // ============================================
                        }
                    }

                    $osalida_Detalle=salida_detalle::getByID($item['ID']);

                    if($osalida_old->moneda_ID==1){
                        if($precio_venta_unitario==0){
                            $precio_venta_unitario=$osalida_Detalle->precio_venta_unitario_soles/$tipo_cambio;
                        }
                        $osalida_Detalle->precio_venta_unitario_dolares=number_format($precio_venta_unitario,2,'.','');
                        $osalida_Detalle->precio_venta_subtotal_dolares=number_format($osalida_Detalle->precio_venta_unitario_dolares*$item['cantidad'],2,'.','');
                        $osalida_Detalle->precio_venta_dolares=number_format($osalida_Detalle->precio_venta_subtotal_dolares*(1+$osalida_old->igv),2,'.','');
                        $osalida_Detalle->vigv_dolares=number_format($osalida_Detalle->precio_venta_subtotal_dolares*$osalida_old->igv,2,'.','');
                        $sub_total=$sub_total+$osalida_Detalle->precio_venta_subtotal_dolares;
                    }else {
                        if($precio_venta_unitario==0){
                            $precio_venta_unitario=$osalida_Detalle->precio_venta_unitario_dolares*$tipo_cambio;
                        }
                        $osalida_Detalle->precio_venta_unitario_soles=number_format($precio_venta_unitario,2,'.','');
                        $osalida_Detalle->precio_venta_subtotal_soles=number_format($osalida_Detalle->precio_venta_unitario_soles*$item['cantidad'],2,'.','');
                        $osalida_Detalle->precio_venta_soles=number_format( $osalida_Detalle->precio_venta_subtotal_soles*(1+$osalida_old->igv),2,'.','');
                        $osalida_Detalle->vigv_soles=number_format($osalida_Detalle->precio_venta_subtotal_soles*$osalida_old->igv,2,'.','');
                        $sub_total=$sub_total+$osalida_Detalle->precio_venta_subtotal_soles;
                    }
                    $osalida_Detalle->usuario_mod_id=$_SESSION['usuario_ID'];
                    $osalida_Detalle->actualizar();
                    //Actualizamos los costos en el inventario
                    // ============================================
                     $dtInventario=inventario::getGrid('salida_detalle_ID='.$osalida_Detalle->ID,-1,-1);
                     foreach($dtInventario as $valor){
                         $oInventario=inventario::getByID($valor['ID']);
                         actualizarInventarioCostos($oInventario);
                     }
                     // ============================================
                }
                //Actualizamos en tipo de cambio en la cotizacion
                if($osalida_old->moneda_ID==1){
                    //Actualizamos si la compra fue realizada en soles
                    $osalida_old->precio_venta_neto_dolares=number_format($sub_total,2,'.','');
                    $osalida_old->vigv_dolares=number_format($osalida_old->precio_venta_neto_dolares*$osalida_old->igv,2,'.','');

                    $osalida_old->precio_venta_total_dolares=number_format($osalida_old->precio_venta_neto_dolares*(1+$osalida_old->igv),2,'.','');

                }else {
                    $osalida_old->precio_venta_neto_soles=number_format($sub_total,2,'.','');
                    $osalida_old->vigv_soles=number_format($osalida_old->precio_venta_neto_soles*$osalida_old->igv,2,'.','');

                    $osalida_old->precio_venta_total_soles=number_format($osalida_old->precio_venta_neto_soles*(1+$osalida_old->igv),2,'.','');
                }
                $osalida_old->usuario_mod_id=$_SESSION['usuario_ID'];
                $osalida_old->actualizar();
            }

            return $osalida_old;
        }catch(Exception $ex){
            return $mensaje->$ex->getMessage();
        }

    }
    /*Cobranza**/
function get_Cobranza_Mantenimiento() {
    require ROOT_PATH . 'models/moneda.php';
    require ROOT_PATH . 'models/cliente.php';
    require ROOT_PATH . 'models/factura_venta.php';
    require ROOT_PATH . 'models/salida.php';
    require ROOT_PATH . 'models/estado.php';
    global $returnView;
    $returnView = true;
    $GLOBALS['dtMoneda']=moneda::getGrid('',-1,-1,'ID desc');
    $dtFactura_Venta=factura_venta::getGrid('estado_ID=41',-1,-1,'fecha_emision desc');
    $cliente_IDs='';
    $a=0;
    $array_periodo=array();
    $periodo='';

    foreach($dtFactura_Venta as $item){

        $osalida=salida::getByID($item['salida_ID']);
        if($a==0){
            $cliente_IDs=$osalida->cliente_ID;

        }else {
            $cliente_IDs.=','.$osalida->cliente_ID;
        }
         if($periodo!=substr($item['fecha_emision'],0,4)){
             array_push($array_periodo,substr($item['fecha_emision'],0,4));
         }
        $periodo=substr($item['fecha_emision'],0,4);
       $a++;
    }
    $dtEstado=estado::getGrid('tabla="factura_venta" and ID in (41,60)');
    $GLOBALS['dtEstado']=$dtEstado;
    $GLOBALS['dtCliente']=cliente::getGrid('clt.ID in ('.$cliente_IDs.')',-1,-1,'clt.razon_social asc');
    $GLOBALS['dtPerido']=$array_periodo;
}
function post_ajaxCobranza_Mantenimiento() {
    require ROOT_PATH . 'models/salida.php';
    require ROOT_PATH . 'models/moneda.php';
    require ROOT_PATH . 'models/estado.php';
    require ROOT_PATH . 'models/factura_venta.php';
    require ROOT_PATH . 'models/guia_venta.php';
    require ROOT_PATH . 'controls/funcionController.php';
    $estado_ID=$_POST['selEstado'];
    $moneda_ID=$_POST['selMoneda'];
    $opcion_tipo=$_POST['rbOpcion'];
    $todo=0;
    if (isset($_POST['ckTodos'])) {
        $todo=1;
    }
    $fecha_inicio=$_POST['txtFechaInicio'];
    $fecha_fin=$_POST['txtFechaFin'];
    $numero=$_POST['txtNumero'];
    $serie=trim($_POST['txtSerie']);
    $cliente_ID=$_POST['selCliente'];
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
            $orden = 'ov.numero ' . $orden_tipo;
            break;
        case 2:
            $orden = 'fv.numero ' . $orden_tipo;
            break;
        case 3:
            $orden = 'fv.fecha_emision ' . $orden_tipo;
            break;
        case 4:
            $orden = 'fv.fecha_vencimiento ' . $orden_tipo;
            break;
        case 5:
            $orden = 'cl.razon_social ' . $orden_tipo;
            break;
        case 6:
            $orden = 'ov.moneda_ID ' . $orden_tipo;
            break;
        case 7:
            $orden = 'fv.monto_total ' . $orden_tipo;
            break;
        case 8:
            $orden = 'fv.monto_pendiente ' . $orden_tipo;
            break;
        case 9:
            $orden = 'fv.pago ' . $orden_tipo;
            break;
        default:
            $orden = 'fv.fecha_emision ' . $orden_tipo;
            break;
    }
    $filtro="fv.estado_ID in (41,60)";
     if($opcion_tipo=="buscar"){
        if($periodo!=0){
            $filtro.=($filtro!='')?" and ":"";
            $fecha_inicio1='01/01/'.$periodo;
            $fecha_fin1='31/12/'.$periodo;
            $filtro.=" fv.fecha_emision between '".FormatTextToDate($fecha_inicio1, 'Y-m-d')."' and '". FormatTextToDate($fecha_fin1, 'Y-m-d'). "'";

        }
        if(ltrim($serie,0)!=''){
            $filtro.=($filtro!='')?" and ":"";

            $filtro.="fv.serie='".$serie."'";
        }
        if(ltrim($numero,0)!=""){
            $filtro.=($filtro!='')?" and ":"";
            $filtro.=" fv.numero=".ltrim($numero,0);
        }
     }else {
        if($cliente_ID!=0){
            $filtro.=($filtro!='')?" and ":"";
            $filtro.="ov.cliente_ID=".$cliente_ID;
        }
        if($estado_ID!=0){
            $filtro.=($filtro!='')?" and ":"";
            $filtro="fv.estado_ID=".$estado_ID ;
        }
        if($todo==0){
            if($fecha_inicio!="" &&$fecha_fin!="" ){
                $filtro.=($filtro!='')?" and ":"";
                $filtro.=" fv.fecha_emision between '".FormatTextToDate($fecha_inicio,'Y-m-d')."' and '". FormatTextToDate($fecha_fin,'Y-m-d'). "'";

            }
        }

        if($moneda_ID!=0){
            $filtro.=($filtro!='')?" and ":"";
            $filtro.="ov.moneda_ID=".$moneda_ID;
        }
     }



    //$filtro = 'upper(concat(cl.razon_social," ",cl.ruc)) like "%' . str_replace(' ', '%', strtoupper(FormatTextSave($buscar))) . '%"';

    //---------------------------------------
    $resultado = '<table class="grid table table-hover table-bordered"><thead><tr>';

    $resultado.='<th class="thOrden" onclick="fncOrden(1);">N° Orden Vta.' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(2);">N° Factura' . (($txtOrden == 2 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(3);">Fecha emisión' .(($txtOrden == 3 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(4);">Fecha vencimiento' . (($txtOrden == 4 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(5);">Cliente' . (($txtOrden == 5 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(6);">Moneda' . (($txtOrden == 6 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(7);">Monto total' . (($txtOrden == 7 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(8);">Pendiente' . (($txtOrden == 8 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th  class="thOrden" onclick="fncOrden(9);">Estado' . (($txtOrden == 9 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th></th>';
    $resultado.='</tr></thead>';
    $resultado.='<tbody>';
    $colspanFooter = 11;
    try {
        $cantidadMaxima = count(factura_venta::getGrid2($filtro,-1,-1));
        $dtsalida = factura_venta::getGrid2($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
        $rows = count($dtsalida);

        foreach ($dtsalida as $item) {
            $oMoneda=moneda::getByID($item['moneda_ID']);
           $oEstado=estado::getByID($item['estado_ID']);
           $texto='Cobrar';
           // $osalida=salida::getByID($item['ID']);

            if($item['estado_ID']==60){
                 $texto='Ver';
            }
           $fecha_emision = date('d/m/Y',strtotime($item['fecha_emision']));
           $fecha_vencimiento=date('d/m/Y',strtotime($item['fecha_vencimiento']));
            $resultado.='<tr class="tr-item">';

            $resultado.='<td class="text-center">' . $item['salida'] . '</td>';
            $resultado.='<td class="text-center">' . $item['numero_concatenado'] . '</td>';
            $resultado.='<td class="text-center">' .$fecha_emision . '</td>';
            $resultado.='<td class="text-center">' . $fecha_vencimiento . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextViewHtml($item['cliente']) . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextViewHtml($oMoneda->descripcion) . '</td>';
            $resultado.='<td class="text-right">' . $item['monto_total'] . '</td>';
            $resultado.='<td class="text-right">' . $item['monto_pendiente'] . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextViewHtml($oEstado->nombre). '</td>';
            $resultado.='<td class="text-left"><a onclick="fncCobrar('. $item['ID'] . ');"><img title="'.$texto.'" style="width:16px;" src="/include/img/boton/dolar.jpg" />'.$texto.'</a></td>';
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

function get_Cobranza_Mantenimiento_Registro($id){
    require ROOT_PATH.'models/salida.php';
    require ROOT_PATH.'models/factura_venta.php';
    require ROOT_PATH.'models/moneda.php';
    global  $returnView_float;
    $returnView_float=true;
    $oFactura_Venta=factura_venta::getByID($id);
    $osalida=salida::getByID($oFactura_Venta->salida_ID);
    $oMoneda=moneda::getByID($osalida->moneda_ID);
    $oFactura_Venta->moneda=  FormatTextViewHtml($oMoneda->descripcion);

    $estado="Pendiente";
    if($oFactura_Venta->pago==1){
        $estado="Cancelado";
    }
    $oFactura_Venta->estado=$estado;
    $GLOBALS['oFactura_Venta']=$oFactura_Venta;
    $GLOBALS['mensaje']='';
}
function post_Cobranza_Mantenimiento_Registro(){
    require ROOT_PATH.'models/salida.php';
    require ROOT_PATH.'models/factura_venta.php';
    require ROOT_PATH.'models/factura_venta_pagos.php';
    require ROOT_PATH.'models/moneda.php';
    require ROOT_PATH.'models/datos_generales.php';
    $id=$_POST['txtFactura_Venta_ID'];
    $fecha_pago=$_POST['txtFecha_Pago'];
    $monto_pagado=$_POST['txtMonto_Pago'];

    $opcion_total=0;
    if(isset($_POST['ckPago_Total'])){
        $opcion_total=$_POST['ckPago_Total'];
    }

    $oFactura_Venta=factura_venta::getByID($id);
    $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
    $osalida=salida::getByID($oFactura_Venta->salida_ID);
    $funcion="";
    if(trim($monto_pagado)!=""){
        $dtFactura_Venta_Pagos1=factura_venta_pagos::getGrid('factura_venta_ID='.$id,-1,-1,'ID asc');
         if($oFactura_Venta->monto_pendiente>0 && $monto_pagado!=0 ){
            $monto_total_pagado=0;
            foreach($dtFactura_Venta_Pagos1 as $item){
                $monto_total_pagado=$monto_total_pagado+$item['monto_pagado'];
            }
                $monto_total_pendiente=$oFactura_Venta->monto_total-($monto_total_pagado+$monto_pagado);
                $monto_neto_pendiente=round($monto_total_pendiente/(1+$oDatos_Generales->vigv),2);
                $monto_igv_pendiente=$monto_total_pendiente-$monto_neto_pendiente;
                $oFactura_Venta->monto_pendiente=$monto_total_pendiente;
                $oFactura_Venta->usuario_mod_id=$_SESSION['usuario_ID'];
                $oFactura_Venta->actualizarMontoPendiente();
                $funcion='<script>fncMontoPendiente("'.$monto_total_pendiente.'");</script>';
                $oMoneda=moneda::getByID($osalida->moneda_ID);
                $oFactura_Venta_Pagos=new factura_venta_pagos();
                $oFactura_Venta_Pagos->factura_venta_ID=$oFactura_Venta->ID;
                $oFactura_Venta_Pagos->fecha_emision=$oFactura_Venta->fecha_emision;
                $oFactura_Venta_Pagos->fecha_pago=$fecha_pago;
                $oFactura_Venta_Pagos->monto_total_neto=$oFactura_Venta->monto_total_neto;
                $oFactura_Venta_Pagos->monto_total_igv=$oFactura_Venta->monto_total_igv;
                $oFactura_Venta_Pagos->monto_total=$oFactura_Venta->monto_total;
                $oFactura_Venta_Pagos->monto_pagado_igv=$monto_pagado*$oDatos_Generales->vigv;
                $oFactura_Venta_Pagos->monto_pagado_detraccion=0;
                $oFactura_Venta_Pagos->monto_pagado_neto=$monto_pagado-($monto_pagado*$oDatos_Generales->vigv);
                $oFactura_Venta_Pagos->monto_pagado=$monto_pagado;
                $oFactura_Venta_Pagos->monto_pendiente_neto=$monto_neto_pendiente;
                $oFactura_Venta_Pagos->monto_pendiente_igv=$monto_igv_pendiente;
                $oFactura_Venta_Pagos->monto_pendiente=$monto_total_pendiente;
                $oFactura_Venta_Pagos->usuario_id=$_SESSION['usuario_ID'];
                $oFactura_Venta_Pagos->insertar();
                if($monto_total_pendiente==0){
                    $oFactura_Venta->estado_ID=60;
                    $oFactura_Venta->pago=1;
                    $oFactura_Venta->actualizarPago();
                }
            }else {
                $oFactura_Venta->estado_ID=60;
                $oFactura_Venta->pago=1;
                $oFactura_Venta->actualizarPago();
            }
    }



    $resultado='<table class="table table-hover table-bordered"><thead><tr>'.
            '<th>Item</th>'.
            '<th>Fecha</th>'.
            '<th>Pago</th>'.
            '<th>Saldo neto</th>'.
            '<th>Saldo IGV</th>'.
            '<th>Saldo Total</th>'.
            '</tr></thead><tbody>';

    $dtFactura_Venta_Pagos=factura_venta_pagos::getGrid('factura_venta_ID='.$id,-1,-1,'ID asc');
    $i=1;
    foreach($dtFactura_Venta_Pagos as $value){
        $fecha=date('d/m/Y',strtotime($value['fecha_pago']));
        $resultado.= '<tr>'.
            '<td>'.$i.'</td>'.
            '<td>'.$fecha.'</td>'.
            '<td>'.$value['monto_pagado'].'</td>'.
            '<td>'.$value['monto_pendiente_neto'].'</td>'.
            '<td>'.$value['monto_pendiente_igv'].'</td>'.
            '<td>'.$value['monto_pendiente'].'</td>'.
            '</tr>';
        $i++;
    }
    $resultado.='</tbody>';
    $resultado.='</table>';

    $mensaje = '';
    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje,'funcion'=>$funcion);
     echo json_encode($retornar);
}
function get_Anulacion_Comprobante_Mantenimiento() {
    require ROOT_PATH . 'models/moneda.php';
    require ROOT_PATH . 'models/cliente.php';
    require ROOT_PATH . 'models/factura_venta.php';
    require ROOT_PATH . 'models/salida.php';
    require ROOT_PATH . 'models/estado.php';
    global $returnView;
    $returnView = true;
    $GLOBALS['dtMoneda']=moneda::getGrid('',-1,-1,'ID desc');
    $dtFactura_Venta=factura_venta::getGrid('estado_ID=41',-1,-1,'fecha_emision desc');
    $cliente_IDs='';
    $a=0;
    $array_periodo=array();
    $periodo='';

    foreach($dtFactura_Venta as $item){

        $osalida=salida::getByID($item['salida_ID']);
        if($a==0){
            $cliente_IDs=$osalida->cliente_ID;

        }else {
            $cliente_IDs.=','.$osalida->cliente_ID;
        }
         if($periodo!=substr($item['fecha_emision'],0,4)){
             array_push($array_periodo,substr($item['fecha_emision'],0,4));
         }
        $periodo=substr($item['fecha_emision'],0,4);
       $a++;
    }
    $dtEstado=estado::getGrid('ID in (41,53,60)');
    $GLOBALS['dtEstado']=$dtEstado;
    $GLOBALS['dtCliente']=cliente::getGrid('clt.ID in ('.$cliente_IDs.')',-1,-1,'clt.razon_social asc');
    $GLOBALS['dtPeriodo']=$array_periodo;
}
function post_ajaxAnulacion_Comprobante_Mantenimiento() {
    require ROOT_PATH . 'models/salida.php';
    require ROOT_PATH . 'models/moneda.php';
    require ROOT_PATH . 'models/estado.php';
    require ROOT_PATH . 'models/factura_venta.php';
    require ROOT_PATH . 'models/guia_venta.php';
    require ROOT_PATH . 'controls/funcionController.php';
    $opcion_tipo=$_POST['rbOpcion'];
    $todos=0;
    if (isset($_POST['ckTodos'])) {
        $todos = 1;

    }
    $estado_ID=$_POST['selEstado'];
    $moneda_ID=$_POST['selMoneda'];
    $fecha_inicio=$_POST['txtFechaInicio'];
    $fecha_fin=$_POST['txtFechaFin'];
    $serie=trim($_POST['txtSerie']);
    $numero=$_POST['txtNumero'];
    $cliente_ID=$_POST['selCliente'];
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
            $orden = 'ov.numero ' . $orden_tipo;
            break;
        case 2:
            $orden = 'fv.numero ' . $orden_tipo;
            break;
        case 3:
            $orden = 'fv.fecha_emision ' . $orden_tipo;
            break;
        case 4:
            $orden = 'fv.fecha_vencimiento ' . $orden_tipo;
            break;
        case 5:
            $orden = 'cl.razon_social ' . $orden_tipo;
            break;
        case 6:
            $orden = 'ov.moneda_ID ' . $orden_tipo;
            break;
        case 7:
            $orden = 'fv.monto_total ' . $orden_tipo;
            break;
        case 8:
            $orden = 'fv.pago ' . $orden_tipo;
            break;
        case 10:
            $orden = 'es.nombre ' . $orden_tipo;
            break;
        default:
            $orden = 'fv.fecha_emision ' . $orden_tipo;
            break;
    }
    $filtro="fv.estado_ID in (41,53,60)";
    if($opcion_tipo=="buscar"){
        if($periodo!=0){
            $filtro.=($filtro!='')? " and ":"";

            $fecha_inicio1='01/01/'.$periodo;
            $fecha_fin1='31/12/'.$periodo;
            $filtro.=" fv.fecha_emision between '".FormatTextToDate($fecha_inicio1, 'Y-m-d')."' and '". FormatTextToDate($fecha_fin1, 'Y-m-d'). "'";

        }
        if(ltrim($serie,0)!=''){
            $filtro.=($filtro!='')? " and ":"";
            $filtro.="fv.serie='".$serie."'";
        }
        if(ltrim($numero,0)!=""){
            $filtro.=($filtro!='')? " and ":"";
            $filtro.=" fv.numero=".ltrim($numero,0);
        }
     }else {
        if($cliente_ID!=0){
            $filtro.=($filtro!='')? " and ":"";
            $filtro.="ov.cliente_ID=".$cliente_ID;
        }
        if($estado_ID!=0){
            $filtro.=($filtro!='')? " and ":"";
            $filtro="fv.estado_ID=".$estado_ID ;
        }
        if($todos==0){
            if($fecha_inicio!="" &&$fecha_fin!="" ){
                $filtro.=($filtro!='')? " and ":"";
                $filtro.=" fv.fecha_emision between '".FormatTextToDate($fecha_inicio, 'Y-m-d')."' and '". FormatTextToDate($fecha_fin, 'Y-m-d'). "'";

            }
        }

        if($moneda_ID!=0){
            $filtro.=($filtro!='')? " and ":"";
            $filtro.="ov.moneda_ID=".$moneda_ID;
        }
     }

    //$filtro = 'upper(concat(cl.razon_social," ",cl.ruc)) like "%' . str_replace(' ', '%', strtoupper(FormatTextSave($buscar))) . '%"';

    //---------------------------------------
    $resultado = '<table class="grid table table-hover table-bordered"><thead><tr>';

    $resultado.='<th class="thOrden" onclick="fncOrden(1);">N° Orden Vta.' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(2);">N° Factura' . (($txtOrden == 2 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(3);">Fecha emisión' .(($txtOrden == 3 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(4);">Fecha vencimiento' . (($txtOrden == 4 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(5);">Cliente' . (($txtOrden == 5 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(6);">Moneda' . (($txtOrden == 6 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(7);">Monto total' . (($txtOrden == 7 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(8);">Monto Pendiente' . (($txtOrden == 8 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    //$resultado.='<th style="width:100px;" class="thOrden" onclick="fncOrden(9);">Pago' . (($txtOrden == 9 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(10);">Estado' . (($txtOrden == 10 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
     $resultado.='<th></th>';
    $resultado.='</tr></thead>';
    $resultado.='<tbody>';
    $colspanFooter = 11;
    try {
        $cantidadMaxima = count(factura_venta::getGrid2($filtro,-1,-1,'fv.ID asc'));
        $dtFactura_Venta = factura_venta::getGrid2($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
        $rows = count($dtFactura_Venta);

        foreach ($dtFactura_Venta as $item) {
            $oMoneda=moneda::getByID($item['moneda_ID']);

            $pago="Pendiente";
            if($item['pago']==1){
                $pago='Cancelado';
            }


           $fecha_emision = date('d/m/Y',strtotime($item['fecha_emision']));
           $fecha_vencimiento=date('d/m/Y',strtotime($item['fecha_vencimiento']));
            $resultado.='<tr class="tr-item">';

            $resultado.='<td class="text-center">' . $item['salida'] . '</td>';
            $resultado.='<td class="text-center">' . $item['numero_concatenado'] . '</td>';
            $resultado.='<td class="text-center">' .$fecha_emision . '</td>';
            $resultado.='<td class="text-center">' . $fecha_vencimiento . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextViewHtml($item['cliente']) . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextViewHtml($oMoneda->descripcion) . '</td>';
            $resultado.='<td class="text-right">' . $item['monto_total'] . '</td>';
            $resultado.='<td class="text-right">' . $item['monto_pendiente'] . '</td>';
            //$resultado.='<td class="tdLeft">' . $pago. '</td>';
            $resultado.='<td class="text-center">' . FormatTextViewHtml($item['estado']). '</td>';
            $boton='<a onclick="fncAnular('. $item['ID'] . ');"><img title="Cobrar"  src="/include/img/boton/cancel_14x14.png" />&nbsp;<span>Anular</span></a>';
            if($item['estado_ID']==53){
                $boton='';
            }
            $resultado.='<td class="btnAction" style="width:90px;">'.$boton.'</td>';
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
    require ROOT_PATH.'models/salida.php';
    require ROOT_PATH.'models/factura_venta.php';
    require ROOT_PATH.'models/operador.php';
    require ROOT_PATH.'models/moneda.php';
    require ROOT_PATH.'models/motivo_anulacion.php';
    global  $returnView_float;
    $returnView_float=true;
    $oFactura_Venta=factura_venta::getByID($id);
    $osalida=salida::getByID($oFactura_Venta->salida_ID);
    $oMoneda=moneda::getByID($osalida->moneda_ID);
    $oFactura_Venta->moneda=  FormatTextViewHtml($oMoneda->descripcion);
    $dtOperador=operador::getGrid('op.cargo_ID in (1,3)',-1,-1);
    $oFactura_Venta->dtOperador=$dtOperador;
    $dtMotivo_Anulacion=motivo_anulacion::getGrid('tabla="factura_venta"',-1,-1,'nombre asc');
    $oFactura_Venta->dtMotivo_Anulacion=$dtMotivo_Anulacion;
    if($oFactura_Venta->estado_ID!=53){
        $oFactura_Venta->fecha_anulacion=date('d/m/Y');
        $oFactura_Venta->motivo_anulacion_ID=0;
        $oFactura_Venta->operador_ID_anulacion=0;
    }
    $estado="Pendiente";
    if($oFactura_Venta->pago==1){
        $estado="Cancelado";
    }

    $oFactura_Venta->estado=$estado;
    $GLOBALS['oFactura_Venta']=$oFactura_Venta;
    $GLOBALS['mensaje']='';
}
function post_Anulacion_Comprobante_Mantenimiento_Registro($id){
    require ROOT_PATH.'models/salida.php';
    require ROOT_PATH.'models/factura_venta.php';
    require ROOT_PATH.'models/operador.php';
    require ROOT_PATH.'models/moneda.php';
    require ROOT_PATH.'models/motivo_anulacion.php';
    global  $returnView_float;
    $returnView_float=true;
    $oFactura_Venta=factura_venta::getByID($id);
    $fecha_anulacion=$_POST['txtFecha_Anulacion'];
    $motivo_anulacion_ID=$_POST['selMotivo_Anulacion_ID'];
    $operador_ID_anulacion=$_POST['seloperador_ID_anulacion'];
    $mensaje="";

    try {
        $oFactura_Venta->fecha_anulacion=$fecha_anulacion;
        $oFactura_Venta->motivo_anulacion_ID=$motivo_anulacion_ID;
        $oFactura_Venta->operador_ID_anulacion=$operador_ID_anulacion;
        $oFactura_Venta->actualizarAnulacion();
        $mensaje="Se anuló correctamente.";
        //Actualizamo el estado de la salida
        $osalida=salida::getByID($oFactura_Venta->salida_ID);
        //Actualizamos a factura anulado
        $estado_ID=58;
        /*if($osalida->cotizacion_ID!=-1){
            $estado_ID=28;
        }*/
        $osalida->estado_ID=$estado_ID;
        $osalida->usuario_mod_id=$_SESSION['usuario_ID'];
        $osalida->actualizar();
        $resultado=1;
    }catch(Exception $ex){
         $mensaje=$ex->getMessage();
        $resultado=-1;

    }

    $osalida=salida::getByID($oFactura_Venta->salida_ID);

    $oMoneda=moneda::getByID($osalida->moneda_ID);
    $oFactura_Venta->moneda=  FormatTextView($oMoneda->descripcion);
    $dtOperador=operador::getGrid('op.cargo_ID in (1,3)',-1,-1);
    $oFactura_Venta->dtOperador=$dtOperador;
    $dtMotivo_Anulacion=motivo_anulacion::getGrid('tabla="factura_venta"',-1,-1,'nombre asc');
    $oFactura_Venta->dtMotivo_Anulacion=$dtMotivo_Anulacion;
    $estado="Pendiente";
    if($oFactura_Venta->pago==1){
        $estado="Cancelado";
    }
    $oFactura_Venta->estado=$estado;
    $GLOBALS['oFactura_Venta']=$oFactura_Venta;
    $GLOBALS['resultado']=$resultado;
    $GLOBALS['mensaje']=$mensaje;
}
function post_ajaxExtraer_Numero_Ultimo() {
    require ROOT_PATH . 'models/correlativos.php';

    $correlativos_ID=$_POST['id'];
    $numero="";
    $serie="";
    try {
       //$numero=sprintf("%'.07d",correlativos::getNumero($correlativos_ID));
        $numero=correlativos::getNumero($correlativos_ID);
       $oCorrelativos=correlativos::getByID($correlativos_ID);
       $serie=$oCorrelativos->serie;
       $resultado=1;
    } catch (Exception $ex) {
        $resultado=-1;
    }
    $retornar = Array('resultado' => $resultado, 'numero' => $numero,"serie"=>$serie);
    echo json_encode($retornar);
}
function post_ajaxExtraerSeries() {
    require ROOT_PATH . 'models/tipo_comprobante.php';

    $tipo_comprobante_ID=$_POST['id'];
    $electronico=$_POST['id1'];
    $html="";
    try {
        $dtSerie=tipo_comprobante::getComprobantes($electronico,"venta",-1,$tipo_comprobante_ID,"series");
        $html=$dtSerie;
        $resultado=1;
    } catch (Exception $ex) {
        $resultado=-1;
    }
    $retornar = Array('resultado' => $resultado, 'html' => $html);
    echo json_encode($retornar);
}
function post_ajaxGuia_Venta_Numero_Ultimo() {
    require ROOT_PATH . 'models/correlativos.php';

    $correlativos_ID=$_POST['id'];
    $numero="";
    try {
       $numero=sprintf("%'.07d",correlativos::getNumero($correlativos_ID));
       $resultado=1;
    } catch (Exception $ex) {
        $resultado=-1;
    }
    $retornar = Array('resultado' => $resultado, 'numero' => $numero);
    echo json_encode($retornar);
}

function post_ajaxEnviarSUNAT1() {

    require ROOT_PATH.'models/factura_venta_sunat.php';
    require ROOT_PATH.'models/salida.php';
    require ROOT_PATH.'models/factura_venta.php';
    require ROOT_PATH.'models/correlativos.php';
    require ROOT_PATH.'include/lib_fecha_texto.php';
    require_once('include/URL_API.php');

    $new = new api_SUNAT();
    $id=$_POST['id'];

    //$oSalida=salida::getByID($id);
  
    try {
        $oFactura_venta=factura_venta::getFactura_SUNAT($id,"cabecera");
        if (count($oFactura_venta)==0) {
            throw new Exception("No existe la factura.");
        }
        $oFactura_Detalle=factura_venta::getFactura_SUNAT($id,"detalle");
        if(count($oFactura_Detalle)==0){
            throw new Exception("La factura no tiene detalles.");
        }

        $DocumentoDetalle = array();
        $Discrepancias = array();
        $DocumentoRelacionado = array();
        $i=0;
        $total_venta=0;
        foreach($oFactura_Detalle as $item){
            $DocumentoDetalle[] = array (
                'Id' => $i+1,
                'Cantidad' => $item['cantidad'],
                'UnidadMedida' => $item['unidad_medida'],
                'CodigoItem' => $item['producto_ID'],
                'Descripcion' => $item['producto_nombre'],
                'PrecioUnitario' =>$item['precio_unitario'],
                'PrecioReferencial' => $item['PrecioReferencial'],
                'TipoPrecio' => $item['tipoprecio'],
                'TipoImpuesto' => $item['tipoimpuesto'],
                'Impuesto' => $item['impuesto'],
                'ImpuestoSelectivo' => $item['ImpuestoSelectivo'],
                'OtroImpuesto' => $item['OtroImpuesto'],
                'Descuento' => $item['Descuento'],
                'PlacaVehiculo' => $item['PlacaVehiculo'],
                'TotalVenta' => $item['totalventa'],
                'Suma' => $item['Suma'],
            );
            
            $i++;
        }
        $total_facturado=explode(".",$oFactura_venta[0]['monto_total']);
        //$oMoneda=moneda::getByID($oFactura_Venta->moneda_ID);
        $decimal="00";
        if(isset($total_facturado[1])){
            if(strlen($total_facturado[1])==1){
                $decimal=$total_facturado[1].'0';
            }else {
                $decimal=$total_facturado[1];
            }

        }
        $total_texto="SON: ".numtoletras($total_facturado[0])." CON ".$decimal."/100 ".str_replace("ó","O",strtoupper(FormatTextView($oFactura_venta[0]['moneda']))).".";
    
        $param_emisor = $new->getParamEmisor($oFactura_venta[0]['empresa_ID']);
        $data = array (
        'IdDocumento' => $oFactura_venta[0]['serie'].'-'.$oFactura_venta[0]['numero_concatenado'],
        'TipoDocumento' =>$oFactura_venta[0]['codigo_documento'],
        'Emisor' => $param_emisor["Emisor"],
        'Receptor' =>  array (
          'NroDocumento' => $oFactura_venta[0]['ruc'],
          'TipoDocumento' => $oFactura_venta[0]['TipoDocumento'],//SOLO FACTURA  06
          'NombreLegal' => $oFactura_venta[0]['cliente'],
        ),
        'FechaEmision' => $oFactura_venta[0]['fecha_emision'],
        'Moneda' => $oFactura_venta[0]['codigo_moneda'],
        'TipoOperacion' => '',
        'Gravadas' => $oFactura_venta[0]['monto_total_neto'],//$oFactura_venta[0]['gravadas']
        'Gratuitas' => $oFactura_venta[0]['gratuitas'],
        'Inafectas' => $oFactura_venta[0]['inafectas'],
        'Exoneradas' => $oFactura_venta[0]['exoneradas'],
        'DescuentoGlobal' => $oFactura_venta[0]['descuento_global'],
        'TotalVenta' => $oFactura_venta[0]['monto_total'],
        'TotalIgv' => $oFactura_venta[0]['monto_total_igv'],
        'TotalIsc' => 0,
        'TotalOtrosTributos' => 0,
        'MontoEnLetras' => $total_texto,
        'PlacaVehiculo' => '',
        'MontoPercepcion' => 0,
        'MontoDetraccion' => $oFactura_venta[0]['monto_detraccion'],
        'TipoDocAnticipo' => '',
        'DocAnticipo' => '',
        'MonedaAnticipo' => '',
        'MontoAnticipo' => 0,
        'CalculoIgv' => $oFactura_venta[0]['CalculoIgv'],
        'CalculoIsc' => $oFactura_venta[0]['CalculoIsc'],
        'CalculoDetraccion' => $oFactura_venta[0]['CalculoDetraccion'],
        'Items' => $DocumentoDetalle,
        );
       
        $carpeta='';
        $metodo = '';
        switch ($data['TipoDocumento']) {
            case '01':
                $metodo = 'GenerarFactura';
                $carpeta="factura";
                break;
            case '03':
                $metodo = 'GenerarFactura';
                $carpeta="boleta";
                break;
            case '07':
                $metodo = 'GenerarNotaCredito';
                break;
            case '08':
                $metodo = 'GenerarNotaDebito';
                break;
            default:
              $metodo = 'GenerarFactura';
              break;
        }
        //echo json_encode($data);
        $FechaRespuesta = strftime( "%Y-%m-%d-%H-%M-%S", time() );
        $resultado_GFactura = $new->sendPostCPE(json_encode($data),$metodo);
        $data_GFactura = json_decode($resultado_GFactura);
        //print_r($resultado_GFactura);
      //{
      //  "TramaXmlSinFirma": "string",
      //  "Exito": true,
      //  "MensajeError": "string",
      //  "Pila": "string"
      //}
      //echo ($resultado_GFactura);
        $array_sunat=array();
      if ($data_GFactura->Exito==true) {

        $firma=array (
            'CertificadoDigital' => $param_emisor["Certificado"],
            'PasswordCertificado' => $param_emisor["PasswordCertificado"],
            'TramaXmlSinFirma' => $data_GFactura->TramaXmlSinFirma,
            'UnSoloNodoExtension' => false,
        );
        //echo $param_emisor["Certificado"];
        
        $resultado_firma = $new->sendPostCPE(json_encode($firma),'Firmar');
        $data_firma = json_decode($resultado_firma);

        //echo json_encode($resultado_firma);
        if ($data_firma->Exito==true) {
          // {
          //   "TramaXmlFirmado": "string",
          //   "ResumenFirma": "string",
          //   "ValorFirma": "string",
          //   "Exito": true,
          //   "MensajeError": "string",
          //   "Pila": "string"
          // }

          $nombreArchivo = $data['Emisor']['NroDocumento'].'-'.$data['TipoDocumento'].'-'.$data['IdDocumento'].'.xml';
          
          $new->EscribirArchivoXML($nombreArchivo,$data_firma->TramaXmlFirmado,$carpeta);
            $enviar_sunat=array (
                'TramaXmlFirmado' => $data_firma->TramaXmlFirmado,
                'Ruc' => $param_emisor["RUC"],
                'UsuarioSol' => $param_emisor["UsuarioSol"],
                'ClaveSol' => $param_emisor["ClaveSol"],
                'IdDocumento' => $data['IdDocumento'],
                'TipoDocumento' => $data['TipoDocumento'],
                'EndPointUrl' => $param_emisor["UrlSunat"],
            );

            //var_dump($enviar_sunat);
          //echo json_encode($enviar_sunat);

          $resultado_sunat = $new->sendPostCPE(json_encode($enviar_sunat),'EnviarDocumento');
          $data_sunat = json_decode($resultado_sunat);

          
          $sunat_respuesta='';
          if ($data_sunat->Exito==true) {
            // echo 'CodigoRespuesta : '.$data_sunat->CodigoRespuesta.'<br>';
            // echo 'MensajeRespuesta : '.$data_sunat->MensajeRespuesta.'<br>';
            // echo 'NombreArchivo : '.$data_sunat->NombreArchivo.'<br>';
            // echo 'TramaZipCdr : '.$data_sunat->TramaZipCdr.'<br>';
                            
            $oFactura_Venta1=factura_venta::getByID($oFactura_venta[0]['ID']);
            $oFactura_Venta1->estado_ID=94;//Estado emitido electronico;
            $oFactura_Venta1->usuario_mod_id=$_SESSION['usuario_ID'];  
            $oFactura_Venta1->actualizar();
            $sunat_respuesta = $data_sunat->MensajeRespuesta;
            if ($data_sunat->CodigoRespuesta==0) {
              $new->EscribirArchivoCDR($data_sunat->NombreArchivo.'.zip',$data_sunat->TramaZipCdr,$carpeta);
              
            }
            $mensaje="El comprobante de venta se envió correctamente a la SUNAT.";
            $resultado=1;
            $array_sunat=json_encode($resultado_sunat);
            //echo json_encode($resultado_sunat);
          }else{
            $mensaje="El comprobante no se envió correctamente, no se creó el archivo CDR.";
            $resultado=-1;
            $array_sunat=json_encode($resultado_sunat);
            $oFactura_Venta1=factura_venta::getByID($oFactura_venta[0]['ID']);
            $oFactura_Venta1->estado_ID=96;//Estado error de envío electronico;
            $oFactura_Venta1->usuario_mod_id=$_SESSION['usuario_ID'];  
            $oFactura_Venta1->actualizar();
          }
          
            $oFactura_Venta_Sunat=new factura_venta_sunat();
            $oFactura_Venta_Sunat->factura_venta_ID=$oFactura_venta[0]['ID'];
            $oFactura_Venta_Sunat->fecha_generacion=$FechaRespuesta;
            $oFactura_Venta_Sunat->fecha_respuesta=$FechaRespuesta;
            $oFactura_Venta_Sunat->hash=$data_firma->ResumenFirma;
            $oFactura_Venta_Sunat->nombre_archivo=$data_sunat->NombreArchivo;
            $oFactura_Venta_Sunat->xml_firmado=$data_firma->TramaXmlFirmado;
            $oFactura_Venta_Sunat->representacion_impresa='';
            $oFactura_Venta_Sunat->estado_envio=1;
            $oFactura_Venta_Sunat->codigo_estado=$data_sunat->CodigoRespuesta;
            $oFactura_Venta_Sunat->descripcion_estado=FormatTextSave($sunat_respuesta);
            $oFactura_Venta_Sunat->cdr_sunat = $data_sunat->TramaZipCdr;
            $oFactura_Venta_Sunat->usuario_id=$_SESSION['usuario_ID'];
            $oFactura_Venta_Sunat->insertar();

        } else {
            $nombreArchivo = $data['Emisor']['NroDocumento'].'-'.$data['TipoDocumento'].'-'.$data['IdDocumento'];
            $oFactura_Venta_Sunat=new factura_venta_sunat();
            $oFactura_Venta_Sunat->factura_venta_ID=$oFactura_venta[0]['ID'];
            $oFactura_Venta_Sunat->fecha_generacion=$FechaRespuesta;
            $oFactura_Venta_Sunat->fecha_respuesta=$FechaRespuesta;
            $oFactura_Venta_Sunat->hash=$data_firma->ResumenFirma;
            $oFactura_Venta_Sunat->nombre_archivo=$nombreArchivo;
            $oFactura_Venta_Sunat->xml_firmado=$data_firma->TramaXmlFirmado;
            $oFactura_Venta_Sunat->representacion_impresa='';
            $oFactura_Venta_Sunat->estado_envio=0;
            $oFactura_Venta_Sunat->codigo_estado="";
            $oFactura_Venta_Sunat->descripcion_estado="Ocurrió un error al firmar la trama xml";
            $oFactura_Venta_Sunat->cdr_sunat="";
            $oFactura_Venta_Sunat->usuario_id=$_SESSION['usuario_ID'];
            $oFactura_Venta_Sunat->insertar();
            $oFactura_Venta1=factura_venta::getByID($oFactura_venta[0]['ID']);
            $oFactura_Venta1->estado_ID=96;//Estado error de envío electronico;
            $oFactura_Venta1->usuario_mod_id=$_SESSION['usuario_ID'];  
            $oFactura_Venta1->actualizar();
          $resultado=-1;
          $mensaje="El comprobante no se envió a la SUNAT, hubo un error al firmar la trama xml.";
          $array_sunat=json_encode($resultado_firma);
        }



      }else {
          $mensaje="El comprobante no se envió a la SUNAT, hubo un error en el servicio";
          $resultado=-1;
        //echo json_encode($resultado_GFactura);
      }

    } catch (Exception $ex) {
        $resultado=-1;
        log_error(__FILE__,"salidaController.post_ajaxEnviarSUNAT",$ex->getMessage());
        $mensaje=$ex->getMessage();

    }

    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje,'array_sunat'=>$array_sunat);
   

    echo json_encode($retornar);
}
function post_ajaxEnviarSUNAT() {

    require ROOT_PATH.'models/factura_venta_sunat.php';
    require ROOT_PATH.'models/salida.php';
    require ROOT_PATH.'models/factura_venta.php';
    require ROOT_PATH.'models/correlativos.php';
    require ROOT_PATH.'include/lib_fecha_texto.php';
    require ROOT_PATH.'include/facturacion_electronica/transaccion_documentos.php';
    require ROOT_PATH.'models/tabla_movimiento.php';
    require ROOT_PATH.'models/guia_venta.php';
    //require_once('include/URL_API.php');

    
    $id=$_POST['id'];
    $transacion = new transaccion_documentos();
    //$oSalida=salida::getByID($id);
  
    try {
        $oFactura_venta=factura_venta::getFactura_SUNAT($id,"cabecera");
        if (count($oFactura_venta)==0) {
            throw new Exception("No existe la factura.");
        }
        $oFactura_Detalle=factura_venta::getFactura_SUNAT($id,"detalle");
        if(count($oFactura_Detalle)==0){
            throw new Exception("La factura no tiene detalles.");
        }
        if($oFactura_venta[0]['con_guia']>0){
            $Guia_emitida=guia_venta::getCount("factura_venta_ID=".$id." and estado_ID in (38,97,98)");
            if($Guia_emitida==0){
                throw new Exception("La factura tiene marcado 'Con guía', debe imprimir la guía antes de enviar la factura a la SUNAT.");
            }
            //$dtGuia_Venta=guia_venta::getGrid("factura_venta_ID=".$id." and estado_ID=38");
        }
        
        
        $DocumentoDetalle = array();
        $Discrepancias = array();
        $getGuia=guia_venta::getGridFactura($id);
        $DocumentoRelacionado = array();
        $DocumentoDespacho=array();
        if(count($getGuia)>0){
           $DocumentoDespacho=array(
               'NroDocumento'=>$getGuia[0]['IdDocumento'],
               'TipoDocumento'=>$getGuia[0]['TipoDocumento']
            ); 
        }
        
        $i=0;
        $total_venta=0;
        foreach($oFactura_Detalle as $item){
            $DocumentoDetalle[] = array (
                'Id' => $i+1,
                'Cantidad' => $item['cantidad'],
                'UnidadMedida' => trim($item['unidad_medida']),
                'CodigoItem' => $item['codigo'],
                'Descripcion' => trim(substr($item['producto_descripcion'],0,250)),
                'ValorUnitario' =>$item['valor_unitario'],
                'PrecioUnitario' =>$item['precio_unitario'],
                'PrecioVentaUnitario' =>$item['precio_venta_unitario'],
                'PrecioReferencial' => $item['PrecioReferencial'],
                'TipoPrecio' => $item['tipoprecio'],
                'TipoImpuesto' => $item['tipoimpuesto'],
                'Impuesto' => $item['impuesto'],
                'ImpuestoSelectivo' => $item['ImpuestoSelectivo'],
                'OtroImpuesto' => $item['OtroImpuesto'],
                'Descuento' => $item['Descuento'],
                'DescuentoFactor' => $item['descuento_factor'],
                'PlacaVehiculo' => $item['PlacaVehiculo'],
                'valor_venta' => $item['valor_venta'],
                'TotalVenta' => $item['total_venta'],
                'SubtotalBase'=>$item['subtotal_base'],
                'MontoBaseSinIGV' => $item['monto_baseSINIGV'],
                'PorcentajeISC' => $item['PorcentajeISC'],
                'codigo_calculo_isc'=>$item['codigo_calculo_isc'],
                'isc_base'=>$item['isc_base'],
                'Suma' => $item['Suma'],
                'tipo_tributo_codigo' => $item['tipo_tributo_codigo'],
                'tipo_tributo_descripcion' =>trim($item['tipo_tributo_descripcion']),
                'codigo_tipo_nombre' => trim($item['codigo_tipo_nombre']),
                'codigo_categoria' => $item['codigo_categoria'],
            );
            
            $i++;
        }
        $total_facturado=explode(".",$oFactura_venta[0]['monto_total']);
        //$oMoneda=moneda::getByID($oFactura_Venta->moneda_ID);
        $decimal="00";
        if(isset($total_facturado[1])){
            if(strlen($total_facturado[1])==1){
                $decimal=$total_facturado[1].'0';
            }else {
                $decimal=$total_facturado[1];
            }

        }
        $total_texto=numtoletras($total_facturado[0])." Y ".$decimal."/100 ";//str_replace("ó","O",strtoupper(FormatTextView($oFactura_venta[0]['moneda']))).".";
        
        $param_emisor = $transacion->getParamEmisor($oFactura_venta[0]['empresa_ID']);
        $data = array (
        'IdDocumento' => $oFactura_venta[0]['serie'].'-'.$oFactura_venta[0]['numero'],
        'TipoDocumento' =>$oFactura_venta[0]['codigo_documento'],
        'Emisor' => $param_emisor["Emisor"],
        'Receptor' =>  array (
          'NroDocumento' => trim($oFactura_venta[0]['ruc']),
          'TipoDocumento' => trim($oFactura_venta[0]['TipoDocumento']),//SOLO FACTURA  06
          'NombreLegal' => trim($oFactura_venta[0]['cliente']),
        ),
        'DocumentoDespacho'=>$DocumentoDespacho,
        'FechaEmision' => $oFactura_venta[0]['fecha_emision'],
        'HoraEmision' =>date("H:i:s"),
        'FechaVencimiento'=> $oFactura_venta[0]['fecha_vencimiento'],
        'Moneda' => $oFactura_venta[0]['codigo_moneda'],
        'TipoOperacion' => '',
        'Gravadas' => $oFactura_venta[0]['monto_total_neto'],//$oFactura_venta[0]['gravadas']
        'Gratuitas' => $oFactura_venta[0]['gratuitas'],
        'GratuitasIGV'=>$oFactura_venta[0]['gratuitas_igv'],   
        'Inafectas' => $oFactura_venta[0]['inafectas'],
        'Exoneradas' => $oFactura_venta[0]['exoneradas'],
        'PorcentajeDescuento' => $oFactura_venta[0]['porcentaje_descuento'],
        'DescuentoGlobal' => $oFactura_venta[0]['descuento_global'],
        'DescuentoTotalItems' => $oFactura_venta[0]['descuento_total_items'],
        'TotalVenta' => $oFactura_venta[0]['monto_total'],
        'TotalIgv' => $oFactura_venta[0]['monto_total_igv'],
        'TotalIsc' => $oFactura_venta[0]['TotalIsc'],
        'isc_base'=> $oFactura_venta[0]['isc_base'],
        'TotalIvap' => 0.00,
        'TotalOtrosCargos' => $oFactura_venta[0]['otros_cargos'],
        'TotalOtrosTributos' =>0,
        'MontoEnLetras' => $total_texto,
        'PlacaVehiculo' => '',
        'MontoPercepcion' => 0,
        'MontoDetraccion' => $oFactura_venta[0]['monto_detraccion'],
        'TipoDocAnticipo' => '',
        'DocAnticipo' => '',
        'MonedaAnticipo' => $oFactura_venta[0]['codigo_moneda'],
        'MontoAnticipo' => 0,
        'CalculoIgv' => $oFactura_venta[0]['CalculoIgv'],
        'porcentajeIgv' => $oFactura_venta[0]['igv'],    
        'CalculoIsc' => $oFactura_venta[0]['CalculoIsc'],
        'CalculoDetraccion' => $oFactura_venta[0]['CalculoDetraccion'],
        'TotalItems'=>$i,
        'Items' => $DocumentoDetalle);
        
        $transacion->array_documento=$data;
        $transacion->documento="factura_venta";
        $ruta=$transacion->generar_xml();
        if($ruta==""){
            throw new Exception("No se creo ningún archivo XML.");
        }
        $ruta_xml_firmado=$transacion->firmar_documento($ruta,"factura");
        
        if($ruta_xml_firmado==""){
            throw new Exception("No existe el certificado");
        }
        //echo $ruta_xml_firmado;
        $transacion->enviar_documento($ruta_xml_firmado,"factura","sendbill");
        $string=file_get_contents($ruta_xml_firmado);
        $trama_firmado=base64_encode($string);
        $estado_envio=0;
        if($transacion->codigo_estado=='0'){
            $oFactura_Venta1=factura_venta::getByID($oFactura_venta[0]['ID']);
            $oFactura_Venta1->estado_ID=94;//Estado emitido electronico;
            $oFactura_Venta1->usuario_mod_id=$_SESSION['usuario_ID'];  
            $oFactura_Venta1->actualizar();
            
            $oTabla_Movimiento=new tabla_movimiento();
            $oTabla_Movimiento->tabla_ID=$oFactura_venta[0]['ID'];
            $oTabla_Movimiento->tabla="factura_venta";
            $oTabla_Movimiento->estado_ID=94;
            $oTabla_Movimiento->fecha=date('Y-m-d H:i:s');
            $oTabla_Movimiento->observacion="Factura electrónica emitido a SUNAT";
            $oTabla_Movimiento->usuario_ID_creacion=$_SESSION['usuario_ID'];
            $oTabla_Movimiento->empresa_ID=$_SESSION['empresa_ID'];
            $oTabla_Movimiento->usuario_id=$_SESSION['usuario_ID'];
            $oTabla_Movimiento->insertar();
            if($transacion->observacion==""){
                $estado_envio=1;
                $resultado=1;
                $mensaje="La factura de venta se envió correctamente"; 
            }else{
                $estado_envio=2;//Envío con observaciones
                $resultado=2;
                $mensaje="<b style='color:red;'>La factura de venta se envió correctamente, pero tiene las siguientes observaciones:</b> <br>".$transacion->observacion; 
            }
            
            $oFactura_Venta_Sunat=new factura_venta_sunat();
            $oFactura_Venta_Sunat->factura_venta_ID=$oFactura_venta[0]['ID'];
            $oFactura_Venta_Sunat->fecha_generacion=date("Y-m-d");
            $oFactura_Venta_Sunat->fecha_respuesta=$transacion->fecha_resultado;
            $oFactura_Venta_Sunat->hash=$transacion->codigo_hash;
            $oFactura_Venta_Sunat->nombre_archivo=$transacion->nombre_documento;
            $oFactura_Venta_Sunat->xml_firmado=$trama_firmado;
            $oFactura_Venta_Sunat->representacion_impresa='';
            $oFactura_Venta_Sunat->estado_envio=$estado_envio;
            $oFactura_Venta_Sunat->codigo_estado=$transacion->codigo_estado;
            $oFactura_Venta_Sunat->descripcion_estado=$transacion->descripcion_estado;
            $oFactura_Venta_Sunat->cdr_sunat = $transacion->cdr_sunat;
            
            $oFactura_Venta_Sunat->observacion=$transacion->observacion;
            $oFactura_Venta_Sunat->usuario_id=$_SESSION['usuario_ID'];
            $oFactura_Venta_Sunat->insertar();
              
        } else{
            $oFactura_Venta_Sunat=new factura_venta_sunat();
            $oFactura_Venta_Sunat->factura_venta_ID=$oFactura_venta[0]['ID'];
            $oFactura_Venta_Sunat->fecha_generacion=date("Y-m-d");
            $oFactura_Venta_Sunat->fecha_respuesta=$transacion->fecha_resultado;
            $oFactura_Venta_Sunat->hash=$transacion->codigo_hash;
            $oFactura_Venta_Sunat->nombre_archivo=$transacion->nombre_documento;
            $oFactura_Venta_Sunat->xml_firmado=$trama_firmado;
            $oFactura_Venta_Sunat->representacion_impresa='';
            $oFactura_Venta_Sunat->estado_envio=$estado_envio;
            $oFactura_Venta_Sunat->codigo_estado=$transacion->codigo_estado;
            $oFactura_Venta_Sunat->descripcion_estado=$transacion->descripcion_estado;
            $oFactura_Venta_Sunat->cdr_sunat = $transacion->cdr_sunat;
            $oFactura_Venta_Sunat->usuario_id=$_SESSION['usuario_ID'];
            $oFactura_Venta_Sunat->insertar();
            $resultado=-1;
            $mensaje="La factura de venta no se envió a la SUNAT.";   
        }
                
       
         
            
        
       
    } catch (Exception $ex) {
        $resultado=-1;
        log_error(__FILE__,"salidaController.post_ajaxEnviarSUNAT",$ex->getMessage());
        $mensaje=$ex->getMessage();

    }

    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
   

    echo json_encode($retornar);
}
function post_ajaxDownloadXML() {

  require ROOT_PATH.'models/factura_venta_sunat.php';
  require_once('include/URL_API.php');

  $id = $_POST['id'];
  $tipo = $_POST['tipo'];

  try {
    $ofactura_venta_sunat = factura_venta_sunat::getGrid2($id);

    
    //var_dump($ofactura_venta_sunat);

    //VALIDAR SI ESISTE
    //var_dump($oFactura_venta);
    //var_dump($oSalida);
    $xml_firmado='';
    $xml_firmado_new = '';
    $nombre_archivo = '';
    if (count($ofactura_venta_sunat)==0) {
      throw new Exception("Falta generar la facura");
    }

    // $nombre_archivo = $ofactura_venta_sunat[0]['nombre_archivo']
    //$xml_firmado = $ofactura_venta_sunat[0]['xml_firmado']
    //var_dump($xml_firmado);
    $nombre_archivo = $ofactura_venta_sunat[0]['nombre_archivo'];
    if ($tipo == 'CDR') {
        $xml_firmado_new = $ofactura_venta_sunat[0]['cdr_sunat'];
      /*$OUTPUT =  ROOT_PATH."files/SUNAT/CDR/".$nombre_archivo.'_NEW.zip';
      file_put_contents($OUTPUT, base64_decode($ofactura_venta_sunat[0]['cdr_sunat']));*/
        $archivo=ruta_archivo."/SUNAT/CDR_DESCARGAR/".$_SESSION['empresa_ID'].'/'.$nombre_archivo.'.zip';
        $OUTPUT =  ROOT_PATH.$archivo;
        file_put_contents($OUTPUT, base64_decode($ofactura_venta_sunat[0]['cdr_sunat']));
        $nombre_archivo=$archivo;
    }
   
    if ($tipo == 'XML') {
        //echo "fff". $ofactura_venta_sunat[0]['xml_firmado'];
      $xml_firmado_new = base64_decode($ofactura_venta_sunat[0]['xml_firmado']);
      //echo $xml_firmado_new;
      $nombre_archivo = $nombre_archivo.'.xml';
    }

    $retornar = Array('tipo' => $tipo,'nombre_archivo' => $nombre_archivo,'xml_firmado' => utf8_encode($xml_firmado_new), 'mensaje' => '', 'exito' => 'true');
    echo json_encode($retornar);

    } catch (Exception $ex) {
        $retornar = Array('mensaje' => $ex->getMessage(), 'exito' => 'false');
        echo json_encode($retornar);
    }

}
function post_ajaxEnviarGuiaSUNAT() {

    //require ROOT_PATH.'models/guia_venta_sunat.php';
    
    require ROOT_PATH.'models/guia_venta.php';
   
    //require ROOT_PATH.'include/lib_fecha_texto.php';
    //require_once('include/URL_API.php');
    require ROOT_PATH.'include/facturacion_electronica/transaccion_documentos.php';
    ///$new = new api_SUNAT();
    $id=$_POST['id'];

    //$oSalida=salida::getByID($id);
    $transacion = new transaccion_documentos();
    try {
        $oGuia_Venta=guia_venta::getGuia_SUNAT($id,"cabecera");
        if (count($oGuia_Venta)==0) {
            throw new Exception("No existe la factura.");
        }
        $oGuia_Venta_Detalle=guia_venta::getGuia_SUNAT($id,"detalle");
        if(count($oGuia_Venta_Detalle)==0){
            throw new Exception("La factura no tiene detalles.");
        }

        $DocumentoDetalle = array();
        $Discrepancias = array();
        $DocumentoRelacionado = array();
      
        foreach($oGuia_Venta_Detalle as $item){
            $DocumentoDetalle[] = array (
                'Correlativo' => $item['Correlativo'],
                'CodigoItem' => $item['CodigoItem'],
                'Descripcion' => "Memoria RAM",
                'UnidadMedida' => $item['UnidadMedida'],
                'Cantidad' => $item['Cantidad'],
                'LineaReferencia' => $item['LineaReferencia']
            ); 
        }
        $data = array (
            'IdDocumento' => $oGuia_Venta[0]['IdDocumento'],
            'FechaEmision' =>$oGuia_Venta[0]['FechaEmision'],
            'HoraEmision' =>date("H:i:s"),
            'TipoDocumento'=>$oGuia_Venta[0]['TipoDocumento'],
            'Observacion'=>$oGuia_Venta[0]['Observacion'],
            'Glosa'=>$oGuia_Venta[0]['Glosa'],
            'Remitente'=>array(
                'NroDocumento'=>$oGuia_Venta[0]['Remitente_NroDocumento'],
                'TipoDocumento'=>$oGuia_Venta[0]['Remitente_TipoDocumento'],
                'NombreLegal'=> utf8_decode($oGuia_Venta[0]['Remitente_NombreLegal']),
                'NombreComercial'=>utf8_decode($oGuia_Venta[0]['Remitente_NombreComercial']),
                'Ubigeo'=>$oGuia_Venta[0]['Remitente_Ubigeo'],
                'Direccion'=>$oGuia_Venta[0]['Remitente_Direccion'],
                'Urbanizacion'=>utf8_decode($oGuia_Venta[0]['Remitente_Urbanizacion']),
                'Departamento'=>$oGuia_Venta[0]['Remitente_Departamento'],
                'Provincia'=>$oGuia_Venta[0]['Remitente_Provincia'],
                'Distrito'=>$oGuia_Venta[0]['Remitente_Distrito']
            ),
            'Destinatario'=>array(
                'NroDocumento'=>$oGuia_Venta[0]['Destinatario_NroDocumento'],
                'TipoDocumento'=>$oGuia_Venta[0]['Destinatario_TipoDocumento'],
                'NombreLegal'=>$oGuia_Venta[0]['Destinatario_NombreLegal'],
                'NombreComercial'=>$oGuia_Venta[0]['Destinatario_NombreComercial'],
                'Ubigeo'=>$oGuia_Venta[0]['Destinatario_Ubigeo'],
                'Direccion'=>$oGuia_Venta[0]['Destinatario_Direccion'],
                'Urbanizacion'=>$oGuia_Venta[0]['Destinatario_Urbanizacion'],
                'Departamento'=>$oGuia_Venta[0]['Destinatario_Departamento'],
                'Provincia'=>$oGuia_Venta[0]['Destinatario_Provincia'],
                'Distrito'=>$oGuia_Venta[0]['Destinatario_Distrito']
            ),
            'Proveedor'=>array(
                'NroDocumento'=>'',
                'TipoDocumento'=>'',
                'NombreLegal'=>''
                
            ),
            'DocumentoReferenciaBaja'=>array(
                'NroDocumento'=>'',
                'TipoDocumento'=>'',
                'Descripcion'=>''
            ),
            'DocumentoRelacionado'=>array(
                'NroDocumento'=>'',
                'TipoDocumento'=>''
            ),           
            'CodigoMotivoTraslado'=>$oGuia_Venta[0]['CodigoMotivoTraslado'],
            'DescripcionMotivo'=>'Venta interna de productos',
            'Transbordo'=>'0',
            'PesoBrutoTotal'=>'1',
            'UnidadMedida'=>'KGM',
            'NroPallets'=>1,
            'ModalidadTraslado'=>$oGuia_Venta[0]['ModalidadTraslado'],
            'FechaInicioTraslado'=>$oGuia_Venta[0]['FechaInicioTraslado'],
            'RucTransportista'=>$oGuia_Venta[0]['RucTransportista'],
            'RazonSocialTransportista'=>$oGuia_Venta[0]['RazonSocialTransportista'],
            'NroPlacaVehiculo'=>'C1Y143',
            'NroDocumentoConductor'=>'4523834',
            'NroPlacaVehiculoSecundario'=>'',
            'DireccionPartida'=>array(
                'Ubigeo'=>$oGuia_Venta[0]['DireccionPartida_Ubigeo'],
                'DireccionCompleta'=>$oGuia_Venta[0]['DireccionPartida_DireccionCompleta']
            ),
            'DireccionLlegada'=>array(
                'Ubigeo'=>$oGuia_Venta[0]['DireccionLlegada_Ubigeo'],
                'DireccionCompleta'=>$oGuia_Venta[0]['DireccionLlegada_DireccionCompleta']
            ),
            'NumeroContenedor'=>$oGuia_Venta[0]['NumeroContenedor'],
            'CodigoPuerto'=>$oGuia_Venta[0]['CodigoPuerto'],
            'DescripcionPuerto'=>'',
            'BienesATransportar'=>$DocumentoDetalle
        );
       
        $transacion->array_documento=$data;
        $transacion->documento="guia_venta";
        $ruta=$transacion->generar_xml();
        $ruta_xml_firmado=$transacion->firmar_documento($ruta,"guiaremision");
        //echo $ruta_xml_firmado;
        $transacion->enviar_documento($ruta_xml_firmado,"guiaremision",'sendbill');
        $resultado=1;
        $mensaje="Se guardó correctamente";
    } catch (Exception $ex) {
        $resultado=-1;
        log_error(__FILE__,"salidaController.post_ajaxEnviarSUNAT",$ex->getMessage());
        $mensaje=$ex->getMessage();

    }

    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
   

    echo json_encode($retornar);
}
function post_ajaxEnviarGuiaSUNAT1() {

    require ROOT_PATH.'models/guia_venta_sunat.php';
    
    require ROOT_PATH.'models/guia_venta.php';
   
    require ROOT_PATH.'include/lib_fecha_texto.php';
    require_once('include/URL_API.php');

    $new = new api_SUNAT();
    $id=$_POST['id'];

    //$oSalida=salida::getByID($id);
  
    try {
        $oGuia_Venta=guia_venta::getGuia_SUNAT($id,"cabecera");
        if (count($oGuia_Venta)==0) {
            throw new Exception("No existe la factura.");
        }
        $oGuia_Venta_Detalle=guia_venta::getGuia_SUNAT($id,"detalle");
        if(count($oGuia_Venta_Detalle)==0){
            throw new Exception("La factura no tiene detalles.");
        }

        $DocumentoDetalle = array();
        $Discrepancias = array();
        $DocumentoRelacionado = array();
      
        foreach($oGuia_Venta_Detalle as $item){
            $DocumentoDetalle[] = array (
                'Correlativo' => $item['Correlativo'],
                'CodigoItem' => $item['CodigoItem'],
                'Descripcion' => $item['Descripcion'],
                'UnidadMedida' => $item['UnidadMedida'],
                'Cantidad' => $item['Cantidad'],
                'LineaReferencia' => $item['LineaReferencia']
            ); 
        }
        $data = array (
            'IdDocumento' => $oGuia_Venta[0]['IdDocumento'],
            'FechaEmision' =>$oGuia_Venta[0]['FechaEmision'],
            'TipoDocumento'=>$oGuia_Venta[0]['TipoDocumento'],
            'Glosa'=>$oGuia_Venta[0]['Glosa'],
            'Remitente'=>array(
                'NroDocumento'=>$oGuia_Venta[0]['Remitente_NroDocumento'],
                'TipoDocumento'=>$oGuia_Venta[0]['Remitente_TipoDocumento'],
                'NombreLegal'=> utf8_decode($oGuia_Venta[0]['Remitente_NombreLegal']),
                'NombreComercial'=>utf8_decode($oGuia_Venta[0]['Remitente_NombreComercial']),
                'Ubigeo'=>$oGuia_Venta[0]['Remitente_Ubigeo'],
                'Direccion'=>$oGuia_Venta[0]['Remitente_Direccion'],
                'Urbanizacion'=>utf8_decode($oGuia_Venta[0]['Remitente_Urbanizacion']),
                'Departamento'=>$oGuia_Venta[0]['Remitente_Departamento'],
                'Provincia'=>$oGuia_Venta[0]['Remitente_Provincia'],
                'Distrito'=>$oGuia_Venta[0]['Remitente_Distrito']
            ),
            'Destinatario'=>array(
                'NroDocumento'=>$oGuia_Venta[0]['Destinatario_NroDocumento'],
                'TipoDocumento'=>$oGuia_Venta[0]['Destinatario_TipoDocumento'],
                'NombreLegal'=>$oGuia_Venta[0]['Destinatario_NombreLegal'],
                'NombreComercial'=>$oGuia_Venta[0]['Destinatario_NombreComercial'],
                'Ubigeo'=>$oGuia_Venta[0]['Destinatario_Ubigeo'],
                'Direccion'=>$oGuia_Venta[0]['Destinatario_Direccion'],
                'Urbanizacion'=>$oGuia_Venta[0]['Destinatario_Urbanizacion'],
                'Departamento'=>$oGuia_Venta[0]['Destinatario_Departamento'],
                'Provincia'=>$oGuia_Venta[0]['Destinatario_Provincia'],
                'Distrito'=>$oGuia_Venta[0]['Destinatario_Distrito']
            ),
            'DocumentoRelacionado'=>array(
                'NroDocumento'=>$oGuia_Venta[0]['DocumentoRelacionado_NroDocumento'],
                'TipoDocumento'=>$oGuia_Venta[0]['DocumentoRelacionado_TipoDocumento']
            ),
            'CodigoMotivoTraslado'=>$oGuia_Venta[0]['CodigoMotivoTraslado'],
            'DescripcionMotivo'=>$oGuia_Venta[0]['DescripcionMotivo'],
            'Transbordo'=>($oGuia_Venta[0]['Transbordo']=="0")? true:false,
            'PesoBrutoTotal'=>$oGuia_Venta[0]['PesoBrutoTotal']."KG",
            'NroPallets'=>$oGuia_Venta[0]['NroPallets'],
            'ModalidadTraslado'=>$oGuia_Venta[0]['ModalidadTraslado'],
            'FechaInicioTraslado'=>$oGuia_Venta[0]['FechaInicioTraslado'],
            'RucTransportista'=>$oGuia_Venta[0]['RucTransportista'],
            'RazonSocialTransportista'=>$oGuia_Venta[0]['RazonSocialTransportista'],
            'NroPlacaVehiculo'=>$oGuia_Venta[0]['NroPlacaVehiculo'],
            'NroDocumentoConductor'=>$oGuia_Venta[0]['NroDocumentoConductor'],
            'DireccionPartida'=>array(
                'Ubigeo'=>$oGuia_Venta[0]['DireccionPartida_Ubigeo'],
                'DireccionCompleta'=>$oGuia_Venta[0]['DireccionPartida_DireccionCompleta']
            ),
            'DireccionLlegada'=>array(
                'Ubigeo'=>$oGuia_Venta[0]['DireccionLlegada_Ubigeo'],
                'DireccionCompleta'=>$oGuia_Venta[0]['DireccionLlegada_DireccionCompleta']
            ),
            'NumeroContenedor'=>$oGuia_Venta[0]['NumeroContenedor'],
            'CodigoPuerto'=>$oGuia_Venta[0]['CodigoPuerto'],
            'BienesATransportar'=>$DocumentoDetalle
        );
        //print_r($data);
        $carpeta='guiaremision';
        $FechaRespuesta = strftime( "%Y-%m-%d-%H-%M-%S", time() );
        echo(json_encode($data));
        $resultado_GFactura = $new->sendPostCPE(json_encode($data),'GenerarGuiaRemision');
        $data_GFactura = json_decode($resultado_GFactura);
        
        //print_r($resultado_GFactura);
      //{
      //  "TramaXmlSinFirma": "string",
      //  "Exito": true,
      //  "MensajeError": "string",
      //  "Pila": "string"
      //}
      //echo ($resultado_GFactura);
        $array_sunat=array();
        $param_emisor = $new->getParamEmisor($oGuia_Venta[0]['empresa_ID']);
       
      if ($data_GFactura->Exito==true) {

        $firma=array (
            'CertificadoDigital' => $param_emisor["Certificado"],
            'PasswordCertificado' => $param_emisor["PasswordCertificado"],
            'TramaXmlSinFirma' => $data_GFactura->TramaXmlSinFirma,
            'UnSoloNodoExtension' => true,
        );
        
        print_r(json_encode($firma));
        $resultado_firma = $new->sendPostCPE(json_encode($firma),'Firmar');
        $data_firma = json_decode($resultado_firma);
         
        //echo json_encode($resultado_firma);
        if ($data_firma->Exito==true) {
          // {
          //   "TramaXmlFirmado": "string",
          //   "ResumenFirma": "string",
          //   "ValorFirma": "string",
          //   "Exito": true,
          //   "MensajeError": "string",
          //   "Pila": "string"
          // }

          $nombreArchivo = $data['Remitente']['NroDocumento'].'-'.$data['TipoDocumento'].'-'.$data['IdDocumento'].'.xml';
          
          $new->EscribirArchivoXML($nombreArchivo,$data_firma->TramaXmlFirmado,$carpeta);
            $enviar_sunat=array (
                'TramaXmlFirmado' => $data_firma->TramaXmlFirmado,
                'Ruc' => $param_emisor["RUC"],
                'UsuarioSol' => $param_emisor["UsuarioSol"],
                'ClaveSol' => $param_emisor["ClaveSol"],
                'IdDocumento' => $data['IdDocumento'],
                'TipoDocumento' => $data['TipoDocumento'],
                'EndPointUrl' => $param_emisor["UrlGuia"],
            );
           //print_r(json_encode($enviar_sunat));
            //var_dump($enviar_sunat);
          //echo json_encode($enviar_sunat);

          $resultado_sunat = $new->sendPostCPE(json_encode($enviar_sunat),'EnviarDocumento');
          $data_sunat = json_decode($resultado_sunat);

          
          $sunat_respuesta='';
          if ($data_sunat->Exito==true) {
            // echo 'CodigoRespuesta : '.$data_sunat->CodigoRespuesta.'<br>';
            // echo 'MensajeRespuesta : '.$data_sunat->MensajeRespuesta.'<br>';
            // echo 'NombreArchivo : '.$data_sunat->NombreArchivo.'<br>';
            // echo 'TramaZipCdr : '.$data_sunat->TramaZipCdr.'<br>';
                            
            $oGuia_Venta1=guia_venta::getByID($id);
            $oGuia_Venta1->estado_ID=98;//Estado emitido electronico;
            $oGuia_Venta1->usuario_mod_id=$_SESSION['usuario_ID'];  
            $oGuia_Venta1->actualizar();
            $sunat_respuesta = $data_sunat->MensajeRespuesta;
            if ($data_sunat->CodigoRespuesta==0) {
              $new->EscribirArchivoCDR($data_sunat->NombreArchivo.'.zip',$data_sunat->TramaZipCdr,$carpeta);
              
            }
            $mensaje="La guía de remisión se envió correctamente a la SUNAT.";
            $resultado=1;
            $array_sunat=json_encode($resultado_sunat);
            //echo json_encode($resultado_sunat);
          }else{
            $mensaje="La guía de remisión no se envió correctamente, no se creó el archivo CDR.";
            $resultado=-1;
            $array_sunat=json_encode($resultado_sunat);
            $oGuia_Venta1=guia_venta::getByID($id);
            $oGuia_Venta1->estado_ID=100;//Estado error de envío electronico;
            $oGuia_Venta1->usuario_mod_id=$_SESSION['usuario_ID'];  
            $oGuia_Venta1->actualizar();
          }
          
            $oGuia_Venta_Sunat=new guia_venta_sunat();
            $oGuia_Venta_Sunat->guia_venta_ID=$id;
            $oGuia_Venta_Sunat->fecha_generacion=$FechaRespuesta;
            $oGuia_Venta_Sunat->fecha_respuesta=$FechaRespuesta;
            $oGuia_Venta_Sunat->hash=$data_firma->ResumenFirma;
            $oGuia_Venta_Sunat->nombre_archivo=$data_sunat->NombreArchivo;
            $oGuia_Venta_Sunat->xml_firmado=$data_firma->TramaXmlFirmado;
            $oGuia_Venta_Sunat->representacion_impresa='';
            $oGuia_Venta_Sunat->estado_envio=1;
            $oGuia_Venta_Sunat->codigo_estado=$data_sunat->CodigoRespuesta;
            $oGuia_Venta_Sunat->descripcion_estado=FormatTextSave($sunat_respuesta);
            $oGuia_Venta_Sunat->cdr_sunat = $data_sunat->TramaZipCdr;
            $oGuia_Venta_Sunat->usuario_id=$_SESSION['usuario_ID'];
            $oGuia_Venta_Sunat->insertar();

        } else {
            $nombreArchivo = $data['Remitente']['NroDocumento'].'-'.$data['TipoDocumento'].'-'.$data['IdDocumento'];
            $oGuia_Venta_Sunat=new guia_venta_sunat();
            $oGuia_Venta_Sunat->guia_venta_ID=$id;
            $oGuia_Venta_Sunat->fecha_generacion=$FechaRespuesta;
            $oGuia_Venta_Sunat->fecha_respuesta=$FechaRespuesta;
            $oGuia_Venta_Sunat->hash=$data_firma->ResumenFirma;
            $oGuia_Venta_Sunat->nombre_archivo=$nombreArchivo;
            $oGuia_Venta_Sunat->xml_firmado=$data_firma->TramaXmlFirmado;
            $oGuia_Venta_Sunat->representacion_impresa='';
            $oGuia_Venta_Sunat->estado_envio=0;
            $oGuia_Venta_Sunat->codigo_estado="";
            $oGuia_Venta_Sunat->descripcion_estado="Ocurrió un error al firmar la trama xml";
            $oGuia_Venta_Sunat->cdr_sunat="";
            $oGuia_Venta_Sunat->usuario_id=$_SESSION['usuario_ID'];
            $oGuia_Venta_Sunat->insertar();
            $oGuia_Venta1=guia_venta::getByID($id);
            $oGuia_Venta1->estado_ID=100;//Estado error de envío electronico;
            $oGuia_Venta1->usuario_mod_id=$_SESSION['usuario_ID'];  
            $oGuia_Venta1->actualizar();
          $resultado=-1;
          $mensaje="La guía de remisión no se envió a la SUNAT, hubo un error al firmar la trama xml.";
          $array_sunat=json_encode($resultado_firma);
        }



      }else {
          $mensaje="El comprobante no se envió a la SUNAT, hubo un error en el servicio";
          $resultado=-1;
        //echo json_encode($resultado_GFactura);
      }

    } catch (Exception $ex) {
        $resultado=-1;
        log_error(__FILE__,"salidaController.post_ajaxEnviarSUNAT",$ex->getMessage());
        $mensaje=$ex->getMessage();
        
        //$retornar = Array('resultado' => '-1', 'mensaje' => $ex->getMessage());
        //echo json_encode($retornar);

        //$resultado.='<tr ><td colspan=' . $colspanFooter . '>' . $ex->getMessage() . '</td></tr>';
    }

    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje,'array_sunat'=>$array_sunat);
   

    echo json_encode($retornar);
}
function post_AjaxMarcarConGuia(){
    require ROOT_PATH.'models/factura_venta.php';
    require ROOT_PATH.'models/guia_venta.php';
    $factura_venta_ID=$_POST['id'];
    $opcion=$_POST['id1'];
    $resultado=0;
    try{
        $guia_impresa=guia_venta::getCount("factura_venta_ID=".$factura_venta_ID." and estado_ID=38");
        if ($guia_impresa>0){
            throw new Exception("No se puede desmarcar, el comprobante tiene su guía de remisión impresa.");
        }
        $oFactura_Venta=factura_venta::getByID($factura_venta_ID);
        if($oFactura_Venta->estado_ID==41||$oFactura_Venta->estado_ID==94||$oFactura_Venta->estado_ID==105){
            throw new Exception("No se puede desmarcar, el comprobante se encuentra emitido.");
        }
        $oFactura_Venta->usuario_mod_id=$_SESSION['usuario_ID'];
        $oFactura_Venta->con_guia=$opcion;
        $resultado=$oFactura_Venta->actualizar();
        $resultado=1;
        if($opcion==1&&$resultado>0){
            $resultado=2;
            $mensaje="Se adicionó la generación de guía para el comprobante, debe agregar una guía";
        }
        if($opcion==0&&$resultado>0){
            $resultado=1;
            $mensaje="Se retiró la generación de guía de remisión.";
        }
    }catch (Exception $ex) {
        $resultado=-1;
        log_error(__FILE__,"salidaController.post_AjaxMarcarConGuia",$ex->getMessage());
        $mensaje=$ex->getMessage();

    }
    
    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
   

    echo json_encode($retornar);
}

function get_Factura_Vista_PreviaPDF($id){

    require ROOT_PATH.'models/factura_venta.php';
    require ROOT_PATH.'models/factura_venta_sunat.php';
    require ROOT_PATH.'formatos_pdf/factura_venta_pdf.php';
    global $returnView_float;
    $returnView_float=true;
    $pdf= new PDF2('P','mm',array(216,279));
    try{
        $dtCabecera=factura_venta::getComprobante_Electronico($id,"cabecera");
        $dtDetalle=factura_venta::getComprobante_Electronico($id,"detalle");
        $numero_cuenta=factura_venta::getComprobante_Electronico($id,"numero_cuenta");


        $pdf->AddPage();
        $pdf->cabecera=$dtCabecera;
        $pdf->numero_cuenta=$numero_cuenta;
        $pdf->cabecera_header();
        /*$pdf->contenedor_detalle(130);

        $pdf->SetWidths(array(20,15,15,100,25,25));
        $pdf->SetAligns(array('C','C','C','L','R','R'));*/
        $pdf->Ln();
            $pdf->SetFont('Arial','B',8);
            $pdf->SetTextColor(255,255,255);
            $pdf->SetFillColor(117,179,114);
            $pdf->Cell(20,7,utf8_decode('CANT.'),1,0,'C',true);
            $pdf->Cell(15,7,utf8_decode('UM'),1,0,'C',true);
            $pdf->Cell(15,7,utf8_decode('CÓD'),1,0,'C',true);
            $pdf->Cell(100,7,utf8_decode('DESCRIPCIÓN'),1,0,'C',true);
            $pdf->Cell(25,7,utf8_decode('P/U'),1,0,'C',true);
            $pdf->Cell(25,7,utf8_decode('IMPORTE'),1,0,'C',true);
            
            $y=87;
            $x=10;
            $array_width=array(20,15,15,100,25,25,100);
            $array_align=array('C','C','C','L','R','R','J');
            $h_atual=$pdf->GetY();
            $pdf->SetTextColor(0,0,0);
            foreach($dtDetalle as $item){
                $longitud=strlen($item["producto"]);
                //$h_atual=$pdf->GetY();
                $pdf->SetXY($x,$y);
                $costo_unitario=number_format($item['precio_unitario'],2,'.',',');
                $pdf->SetFont('Arial','B',8);
                $subtotal=number_format($item['sub_total'],2,'.',',');
                $pdf->MultiCell($array_width[0],5,$item["cantidad"],0,$array_align[0],false);
                $x=$x+$array_width[0];
                $pdf->SetXY($x,$y);
                $pdf->MultiCell($array_width[1],5,$item["medida"],0,$array_align[1],false);
                $x=$x+$array_width[1];
                $pdf->SetXY($x,$y);
                $pdf->MultiCell($array_width[2],5,$item["codigo"],0,$array_align[2],false);
                $x=$x+$array_width[2];
                $pdf->SetXY($x,$y);
                $c=$pdf->getY();
                $pdf->MultiCell($array_width[3],5,$item["producto"],0,$array_align[3],false);
                $d=$pdf->getY();
                $x=$x+$array_width[3];
                $pdf->SetXY($x,$y);
                $pdf->MultiCell($array_width[4],5,$costo_unitario,0,$array_align[4],false);
                $x=$x+$array_width[4];
                $pdf->SetXY($x,$y);
                $pdf->MultiCell($array_width[5],5,$subtotal,0,$array_align[5],false);
                //$x=$x+$array_width[5];
                $y=$y+($d-$c);
                if($item["descripcion"]!=""){
                    $pdf->SetFont('Arial','',6);
                    $pdf->SetXY(60,$y);
                    $pdf->MultiCell($array_width[6],5,substr($item["descripcion"],0,250-$longitud),0,$array_align[6],false);
                    $y=$pdf->GetY();
                }
               
                
                $x=10;
            }
            /*for ($a=0;$a<count($array_width);$a++){
                
                $pdf->Line($x,$h_atual,$x,$y);
                if($a<count($array_width)-1){
                    $x=$x+$array_width[$a];
                }
                
                
            }
            $pdf->Line(10,$y,$x,$y);*/
            
        //$pdf->contenido_detalle($dtDetalle);
            $hash="";
            $dtFv=factura_venta_sunat::getGrid2($id);
            if(count($dtFv)>0){
                $hash=$dtFv[0]['hash'];
            }
            $pdf->hash=$hash;
            $pdf->contenedor_detalle(130);
            $pdf->SetWidths(array(20,15,15,100,25,25));
            $pdf->SetAligns(array('C','C','C','L','R','R'));
    }catch(Exception $ex){
        log_error(__FILE__, "salidaController.get_Factura_Vista_PreviaPDF",$ex);
        $GLOBALS['error']=$ex->getMessage();
    }

    $pdf->Output('D',$dtCabecera[0]['tipo_comprobante'].' Nro'.sprintf($dtCabecera[0]['numero_concatenado']).'.pdf',true);
            //print_r($dtCabecera);
           //$GLOBALS['detalle']=$dtCabecera;
       
    }
//Nota de crédito
//======================================================
function get_Nota_Credito_Mantenimiento(){
    require ROOT_PATH.'models/cliente.php';
    require ROOT_PATH.'models/estado.php';
    require ROOT_PATH.'models/moneda.php';
    global  $returnView;
    $returnView=true;

    $dtCliente=cliente::getGrid('',-1,-1,'clt.razon_social ASC');
    $dtMoneda=moneda::getGrid();
    $dtEstado=estado::getGrid('tabla="comprobante_regula"');
    $GLOBALS['dtCliente']=$dtCliente;
    $GLOBALS['dtMoneda']=$dtMoneda;
    $GLOBALS['dtEstado']=$dtEstado;
    //$GLOBALS['mensaje']='';
}
function post_ajaxNota_Credito_Mantenimiento() {
    require ROOT_PATH . 'models/comprobante_regula.php';
    
    $cliente=$_POST['selCliente'];
    $periodo=$_POST['selPeriodo'];
    $fecha_inicio=FormatTextToDate($_POST['txtFechaInicio'],'Y-m-d');
    $fecha_fin=FormatTextToDate($_POST['txtFechaFin'],'Y-m-d');
    $estado_ID=$_POST['selEstado'];
    $moneda_ID=$_POST['selMoneda'];
    $serie=(trim($_POST['txtSerie'])=="")?0:trim($_POST['txtSerie']);
    $numero=(trim($_POST['txtNumero'])=="")?0:trim($_POST['txtNumero']);
   
    $opcion=$_POST['rbOpcion'];
    try{
         //$dt = comprobante_regula::getTabla($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
       $dt=comprobante_regula::getTabla($opcion,$cliente,$periodo,$fecha_inicio,$fecha_fin,$estado_ID,$moneda_ID,$serie,$numero,'nota_credito');
        echo(json_encode($dt, JSON_NUMERIC_CHECK)); 
    }catch(Exception $ex){
        consolo_log($ex);
    }
    
}
function get_Nota_Credito_Mantenimiento_Nuevo(){
    require ROOT_PATH.'models/tipo.php';
    require ROOT_PATH.'models/moneda.php';
    require ROOT_PATH.'models/correlativos.php';
    require ROOT_PATH.'models/datos_generales.php';
    require ROOT_PATH.'models/comprobante_regula.php';
    global  $returnView_float;
    $returnView_float=true;
    $dtTipo=tipo::getGrid("tabla='nota_credito'",-1,-1,"orden asc");
    $oCorrelativos=correlativos::getByID(correlativos_ID_nota_credito);
    $dtMoneda=moneda::getGrid("",-1,-1,"descripcion asc");
    
    $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
    $oComprobante_Regula=new comprobante_regula();
    $oComprobante_Regula->correlativos_ID=correlativos_ID_nota_credito;
    $oComprobante_Regula->serie=$oCorrelativos->serie;
    $oComprobante_Regula->dtSerie=correlativos::getGridCorrelativos("nota_credito",1);
    $oComprobante_Regula->numero=sprintf("%',06d",$oCorrelativos->ultimo_numero+1);
    $GLOBALS['dtTipo']=$dtTipo;
    $GLOBALS['dtMoneda']=$dtMoneda;

    $GLOBALS['tipo_cambio']=$oDatos_Generales->tipo_cambio;
    $GLOBALS['ob']=$oComprobante_Regula;
    $valor=rand();
    $identificador='dtDetalleNotaCredito'.$valor;
    $GLOBALS['llave']=$identificador;
    $_SESSION[$identificador]=array();
  
}
function post_Nota_Credito_Mantenimiento_Nuevo(){
    require ROOT_PATH.'models/tipo.php';
    require ROOT_PATH.'models/moneda.php';
    require ROOT_PATH.'models/correlativos.php';
    require ROOT_PATH.'models/datos_generales.php';
    require ROOT_PATH.'models/comprobante_regula.php';
    require ROOT_PATH.'models/comprobante_regula_detalle.php';
    require ROOT_PATH.'models/usuario.php';
    require ROOT_PATH.'models/factura_venta.php';
    require ROOT_PATH.'models/factura_venta_detalle.php';
    require ROOT_PATH.'models/salida_detalle.php';
 
    global  $returnView_float;
    $returnView_float=true;
    $documento_relacionado_ID=$_POST['txtFactura_Venta_ID'];
    $identificador=$_POST['llave'];
    $tipo_ID=$_POST['selTipo'];
    $fecha_emision1=$_POST['txtFecha_Emision'];
    $fecha_emision=FormatTextToDate($fecha_emision1,'Y-m-d');
    $fecha_vencimiento1=$_POST['txtFecha_vencimiento'];
    $fecha_vencimiento=FormatTextToDate($fecha_vencimiento1,'Y-m-d');
    $moneda_ID=$_POST['selMoneda'];
    $monto_total_neto=$_POST['txtSubTotal'];
    $monto_total_igv=$_POST['txtIGV'];
    $monto_total=$_POST['txtTotal'];
    $monto_pendiente=0;
    $tipo_cambio=$_POST['txtTipo_Cambio'];
    $correlativos_ID=$_POST['selSerie'];
    $serie=$_POST['txtSerie'];
    $porcentaje_descuento=($_POST['txtPorcentaje']=="")? 0:$_POST['txtPorcentaje'];
    $anticipo=0;
    $exoneradas=0;
    $inafectas=0;
    $gravadas=$monto_total_neto;
    $gratuitas=0;
    $otros_cargos=($_POST['txtOtros_Cargos']=="")? 0:$_POST['txtOtros_Cargos'];
    $descuento_global=($_POST['txtDescuentoTotal']=="")? 0:$_POST['txtDescuentoTotal'];
    $observacion=$_POST['txtObservacion'];
    $monto_detraccion=0;
    $cliente_ID=$_POST['txtCliente_ID'];
    $factura=$_POST['txtFactura'];
    $cliente_descripcion=$_POST['listaCliente'];
    $oComprobante_Regula=new comprobante_regula();
    $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
    try{
        $dt=$_SESSION[$identificador];
        if(count($dt)==0){
            throw new Exception("No se puede generar la nota de crédito, no tiene detalle.");
        }
        $oCorrelativos=correlativos::getByID($correlativos_ID);
        $oComprobante_Regula->documento_relacionado_ID=$documento_relacionado_ID;
        $oComprobante_Regula->cliente_ID=$cliente_ID;
        $oComprobante_Regula->tipo_ID=$tipo_ID;
        $oComprobante_Regula->serie=$oCorrelativos->serie;
        $oComprobante_Regula->numero=$oCorrelativos->ultimo_numero+1;
        $oComprobante_Regula->numero_concatenado= sprintf("%',06d",$oComprobante_Regula->numero);
        $oComprobante_Regula->fecha_emision=$fecha_emision;
        $oComprobante_Regula->fecha_vencimiento=$fecha_vencimiento;
        $oComprobante_Regula->estado_ID=90;//Lo guardamos con el estado borrador
        $oComprobante_Regula->moneda_ID=$moneda_ID;
        $oComprobante_Regula->monto_total_neto=$monto_total_neto;
        $oComprobante_Regula->monto_total_igv=$monto_total_igv;
        $oComprobante_Regula->monto_total=$monto_total;
        $oComprobante_Regula->monto_pendiente=$monto_pendiente;
        $oComprobante_Regula->empresa_ID=$_SESSION['empresa_ID'];
        $oComprobante_Regula->correlativos_ID=$correlativos_ID;
        $oComprobante_Regula->porcentaje_descuento=$porcentaje_descuento;
        $oComprobante_Regula->anticipo=$anticipo;
        $oComprobante_Regula->exoneradas=$exoneradas;
        $oComprobante_Regula->inafectas=$inafectas;
        $oComprobante_Regula->gravadas=$gravadas;
        $oComprobante_Regula->gratuitas=$gratuitas;
        $oComprobante_Regula->otros_cargos=$otros_cargos;
        $oComprobante_Regula->descuento_global=$descuento_global;
        $oComprobante_Regula->monto_detraccion=$monto_detraccion;
        $oComprobante_Regula->observacion=$observacion;
        $oComprobante_Regula->tipo_cambio=$tipo_cambio;
        
        $oComprobante_Regula->usuario_id=$_SESSION['usuario_ID'];
        if($oComprobante_Regula->verificarFactura()==0){
            if($oComprobante_Regula->insertar()>0){
               
                $resultado=1;
                $mensaje=$oComprobante_Regula->getMessage;
                
                //$dt=factura_venta_detalle::getGrid1("fvd.factura_venta_ID=".$documento_relacionado_ID,-1,-1);
                foreach($dt as $valor){
                   
                    $oComprobante_Regula_Detalle=new comprobante_regula_detalle();
                    $oComprobante_Regula_Detalle->producto_ID=$valor['producto_ID'];
                    $oComprobante_Regula_Detalle->comprobante_regula_ID=$oComprobante_Regula->ID;
                    $oComprobante_Regula_Detalle->descripcion=$valor['descripcion'];
                    $oComprobante_Regula_Detalle->cantidad=$valor['cantidad'];
                    $oComprobante_Regula_Detalle->precio_unitario=$valor['precio_unitario'];
                    $oComprobante_Regula_Detalle->subtotal=$valor['subtotal'];
                    $oComprobante_Regula_Detalle->total=$valor['total'];
                    $oComprobante_Regula_Detalle->vigv=$oDatos_Generales->vigv;
                    $oComprobante_Regula_Detalle->igv=$valor['igv'];
                    $oComprobante_Regula_Detalle->factura_venta_detalle_ID=$valor['factura_venta_detalle_ID'];;
                    $oComprobante_Regula_Detalle->tipo_impuestos_ID=$valor['tipo_impuestos_ID'];
                    $oComprobante_Regula_Detalle->usuario_id=$_SESSION['usuario_ID'];
                    $oComprobante_Regula_Detalle->insertar();
                    
                }
            }
            $oCorrelativos=correlativos::getByID($oComprobante_Regula->correlativos_ID);
            $oCorrelativos->ultimo_numero=$oComprobante_Regula->numero;
            $oCorrelativos->usuario_mod_id=$_SESSION['usuario_ID'];
            $oCorrelativos->actualizar();
            //Actualizamos el estado del documento
            $oComprobante_Regula->estado_ID=91;
            $oComprobante_Regula->usuario_mod_id=$_SESSION['usuario_ID'];
            $oComprobante_Regula->actualizar();
            /*$array_resultado_sunat=enviarComprobante_RegulaSUNAT($oComprobante_Regula->ID);
            
            if($array_resultado_sunat['resultado_final']!=1){
                $mensaje=$array_resultado_sunat['mensaje'];
            }*/
        }else{
            throw new Exception("La factura no se encuentra disponible.");
        }
        
    }catch(Exception $ex){
        log_error(__FILE__,"salidaController.post_Nota_Credito_Mantenimiento_Nuevo",$ex->getMessage());
       $mensaje= utf8_encode(mensaje_error);
       $resultado=-1;
    }
    
    
    $dtTipo=tipo::getGrid("tabla='nota_credito'",-1,-1,"orden asc");
    $dtMoneda=moneda::getGrid("",-1,-1,"descripcion asc");
    $oComprobante_Regula->dtSerie=correlativos::getGridCorrelativos("nota_credito",0);
    $oComprobante_Regula->fecha_emision=$fecha_emision1;
    $oComprobante_Regula->fecha_vencimiento=$fecha_vencimiento1;
    $oComprobante_Regula->dtSerie=correlativos::getGridCorrelativos("nota_credito",1);
    $oComprobante_Regula->factura=$factura;
    $oComprobante_Regula->cliente_descripcion=$cliente_descripcion;
    $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
    $GLOBALS['dtTipo']=$dtTipo;
    $GLOBALS['dtMoneda']=$dtMoneda;
    $GLOBALS['llave']=$identificador;
    $GLOBALS['tipo_cambio']=$oDatos_Generales->tipo_cambio;
    $GLOBALS['ob']=$oComprobante_Regula;
    $GLOBALS['resultado']=$resultado;
    $GLOBALS['mensaje']=$mensaje;
    
}
function get_Nota_Credito_Mantenimiento_Editar($id){
    require ROOT_PATH.'models/tipo.php';
    require ROOT_PATH.'models/moneda.php';
    require ROOT_PATH.'models/correlativos.php';
    require ROOT_PATH.'models/datos_generales.php';
    require ROOT_PATH.'models/comprobante_regula.php';
    require ROOT_PATH.'models/comprobante_regula_detalle.php';
    global  $returnView_float;
    $returnView_float=true;
    $dtTipo=tipo::getGrid("tabla='nota_credito'",-1,-1,"orden asc");
    
    $dtMoneda=moneda::getGrid("",-1,-1,"descripcion asc");
    
    $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
    $oComprobante_Regula=comprobante_regula::getByID($id);
    $array_general=array();
    $dt=comprobante_regula_detalle::getGrid($id);
    foreach($dt as $valor){
        $array=array(
            "factura_venta_detalle_ID"=>$valor['factura_venta_detalle_ID'],
            "producto"=>$valor['producto'],
            "producto_ID"=>$valor['producto_ID'],
            "cantidad"=>$valor['cantidad'],
            "precio_unitario"=>$valor['precio_unitario'],
            "subtotal"=>$valor['subtotal'],
            "igv"=>$valor['vigv'],
            "total"=>$valor['total'],
            "tipo_impuestos_ID"=>$valor['tipo_impuestos_ID'],
            "descripcion"=>$valor['descripcion'],
            "accion"=>$valor['accion'],
            "estado_ID"=>$valor['estado_ID']//estado borrador
        ); 
        array_push($array_general,$array);
    }
    $oCorrelativos=correlativos::getByID($oComprobante_Regula->correlativos_ID);
    //$oComprobante_Regula->correlativos_ID=correlativos_ID_nota_credito;
    //$oComprobante_Regula->serie=$oCorrelativos->serie;
    $oComprobante_Regula->dtSerie=correlativos::getGridCorrelativos("nota_credito",1);
    //$oComprobante_Regula->numero=sprintf("%',06d",$oCorrelativos->numero+1);
    $GLOBALS['dtTipo']=$dtTipo;
    $GLOBALS['dtMoneda']=$dtMoneda;

    $GLOBALS['tipo_cambio']=$oDatos_Generales->tipo_cambio;
    $GLOBALS['ob']=$oComprobante_Regula;
    $valor=rand();
    $identificador='dtDetalleNotaCredito'.$valor;
    $GLOBALS['llave']=$identificador;
    $_SESSION[$identificador]=$array_general;
}
function post_Nota_Credito_Mantenimiento_Editar($id){
    require ROOT_PATH.'models/tipo.php';
    require ROOT_PATH.'models/moneda.php';
    require ROOT_PATH.'models/correlativos.php';
    require ROOT_PATH.'models/datos_generales.php';
    require ROOT_PATH.'models/comprobante_regula.php';
    require ROOT_PATH.'models/comprobante_regula_detalle.php';
    require ROOT_PATH.'models/usuario.php';
    require ROOT_PATH.'models/factura_venta.php';
    require ROOT_PATH.'models/factura_venta_detalle.php';
    require ROOT_PATH.'models/salida_detalle.php';
 
    global  $returnView_float;
    $returnView_float=true;
    $identificador=$_POST['llave'];
    $documento_relacionado_ID=$_POST['txtFactura_Venta_ID'];
    $tipo_ID=$_POST['selTipo'];
    $fecha_emision1=$_POST['txtFecha_Emision'];
    $fecha_emision=FormatTextToDate($fecha_emision1,'Y-m-d');
    $fecha_vencimiento1=$_POST['txtFecha_vencimiento'];
    $fecha_vencimiento=FormatTextToDate($fecha_vencimiento1,'Y-m-d');
    $moneda_ID=$_POST['selMoneda'];
    $monto_total_neto=$_POST['txtSubTotal'];
    $monto_total_igv=$_POST['txtIGV'];
    $monto_total=$_POST['txtTotal'];
    $monto_pendiente=0;
    $tipo_cambio=$_POST['txtTipo_Cambio'];
    $correlativos_ID=$_POST['selSerie'];
    $serie=$_POST['txtSerie'];
    $porcentaje_descuento=($_POST['txtPorcentaje']=="")? 0:$_POST['txtPorcentaje'];
    $anticipo=0;
    $exoneradas=0;
    $inafectas=0;
    $gravadas=$monto_total_neto;
    $gratuitas=0;
    $otros_cargos=($_POST['txtOtros_Cargos']=="")? 0:$_POST['txtOtros_Cargos'];
    $descuento_global=($_POST['txtDescuentoTotal']=="")? 0:$_POST['txtDescuentoTotal'];
    $observacion=FormatTextSave($_POST['txtObservacion']);
    $monto_detraccion=0;
    $cliente_ID=$_POST['txtCliente_ID'];
    $opcion=(isset($_POST['ckOpcion']))? 1 : 0;
    $oComprobante_Regula=comprobante_regula::getByID($id);
    try{
        $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
        $oCorrelativos=correlativos::getByID($correlativos_ID);
        $oComprobante_Regula->documento_relacionado_ID=$documento_relacionado_ID;
        $oComprobante_Regula->cliente_ID=$cliente_ID;
        $oComprobante_Regula->tipo_ID=$tipo_ID;
        if($opcion==1){
            $oComprobante_Regula->serie=$oCorrelativos->serie;
            $oComprobante_Regula->numero=$oCorrelativos->ultimo_numero+1;
            $oComprobante_Regula->numero_concatenado= sprintf("%',06d",$oComprobante_Regula->numero);
            $oComprobante_Regula->correlativos_ID=$correlativos_ID;
        }
        $oComprobante_Regula->fecha_emision=$fecha_emision;
        $oComprobante_Regula->fecha_vencimiento=$fecha_vencimiento;
        //$oComprobante_Regula->estado_ID=90;//Lo guardamos con el estado borrador
        $oComprobante_Regula->moneda_ID=$moneda_ID;
        $oComprobante_Regula->monto_total_neto=$monto_total_neto;
        $oComprobante_Regula->monto_total_igv=$monto_total_igv;
        $oComprobante_Regula->monto_total=$monto_total;
        $oComprobante_Regula->monto_pendiente=$monto_pendiente;
        //$oComprobante_Regula->empresa_ID=$_SESSION['empresa_ID'];
        
        $oComprobante_Regula->porcentaje_descuento=$porcentaje_descuento;
        $oComprobante_Regula->anticipo=$anticipo;
        $oComprobante_Regula->exoneradas=$exoneradas;
        $oComprobante_Regula->inafectas=$inafectas;
        $oComprobante_Regula->gravadas=$gravadas;
        $oComprobante_Regula->gratuitas=$gratuitas;
        $oComprobante_Regula->otros_cargos=$otros_cargos;
        $oComprobante_Regula->descuento_global=$descuento_global;
        $oComprobante_Regula->monto_detraccion=$monto_detraccion;
        $oComprobante_Regula->observacion=$observacion;
        $oComprobante_Regula->tipo_cambio=$tipo_cambio;
        
        $oComprobante_Regula->usuario_mod_id=$_SESSION['usuario_ID'];
        if($oComprobante_Regula->verificarFactura()==0){
            if($oComprobante_Regula->actualizar()>0){
                $resultado=1;
                $mensaje=$oComprobante_Regula->getMessage;
                //$dt=factura_venta_detalle::getGrid1("fvd.factura_venta_ID=".$documento_relacionado_ID,-1,-1);
                $dt=$_SESSION[$identificador];
                foreach($dt as $valor){
                    $oComprobante_Regula_Detalle=new comprobante_regula_detalle();
                    $oComprobante_Regula_Detalle->producto_ID=$valor['producto_ID'];
                    $oComprobante_Regula_Detalle->comprobante_regula_ID=$oComprobante_Regula->ID;
                    $oComprobante_Regula_Detalle->descripcion=$valor['descripcion'];
                    $oComprobante_Regula_Detalle->cantidad=$valor['cantidad'];
                    $oComprobante_Regula_Detalle->precio_unitario=$valor['precio_unitario'];
                    $oComprobante_Regula_Detalle->subtotal=$valor['subtotal'];
                    $oComprobante_Regula_Detalle->total=$valor['total'];
                    $oComprobante_Regula_Detalle->vigv=$oDatos_Generales->vigv;
                    $oComprobante_Regula_Detalle->igv=$valor['igv'];
                    $oComprobante_Regula_Detalle->factura_venta_detalle_ID=$valor['factura_venta_detalle_ID'];;
                    $oComprobante_Regula_Detalle->tipo_impuestos_ID=$valor['tipo_impuestos_ID'];
                    if($valor['accion']=="insertar"){
                        $oComprobante_Regula_Detalle->usuario_id=$_SESSION['usuario_ID'];
                        $oComprobante_Regula_Detalle->insertar();
                    }else if($valor['accion']=="actualizar"){
                        $oComprobante_Regula_Detalle->usuario_mod_id=$_SESSION['usuario_ID'];
                        $oComprobante_Regula_Detalle->actualizar();
                    }elseif($valor['accion']=="eliminar"){
                        
                    }
                    
                }
            }
            $oCorrelativos=correlativos::getByID($oComprobante_Regula->correlativos_ID);
            $oCorrelativos->ultimo_numero=$oComprobante_Regula->numero;
            $oCorrelativos->usuario_mod_id=$_SESSION['usuario_ID'];
            $oCorrelativos->actualizar();
            //Actualizamos el estado del documento
            $oComprobante_Regula->estado_ID=91;
            $oComprobante_Regula->usuario_mod_id=$_SESSION['usuario_ID'];
            $oComprobante_Regula->actualizar();
            //$array_resultado_sunat=enviarComprobante_RegulaSUNAT($oComprobante_Regula->ID);
            
           
        }else{
            throw new Exception("La factura no se encuentra disponible.");
        }
        
    }catch(Exception $ex){
       $mensaje= $ex->getMessage();
       $resultado=-1;
    }
    
    
    $dtTipo=tipo::getGrid("tabla='nota_credito'",-1,-1,"orden asc");
    $dtMoneda=moneda::getGrid("",-1,-1,"descripcion asc");
    $oComprobante_Regula->dtSerie=correlativos::getGridCorrelativos("nota_credito");
    $oComprobante_Regula->fecha_emision=$fecha_emision1;
    $oComprobante_Regula->fecha_vencimiento=$fecha_vencimiento1;
    $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
    $GLOBALS['dtTipo']=$dtTipo;
    $GLOBALS['dtMoneda']=$dtMoneda;
    $GLOBALS['llave']=$identificador;
    $GLOBALS['tipo_cambio']=$oDatos_Generales->tipo_cambio;
    $GLOBALS['ob']=$oComprobante_Regula;
    $GLOBALS['resultado']=$resultado;
    $GLOBALS['mensaje']=$mensaje;
    
}
function estructura_tabla_detalle($identificador){
    $html='<table id="tbDetalle" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nro</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio unit.</th>
                        <th>SubTotal</th>
                        <th>Total</th>
                        <th>Opción</th>
                    </tr> 
                </thead>';
    $dt=$_SESSION[$identificador];
    
    $val=1;
    $i=0;
    foreach($dt as $item){
        
        if($item['accion']!="eliminar"){
            $html.='<tr>';
            $html.='<td class="text-center">'.$val.'</td><td>'.FormatTextView($item['producto']).'</td><td class="text-center">'.$item['cantidad'].'</td><td>'.$item['precio_unitario'].'</td><td>'.$item['subtotal'].'</td><td>'.$item['total'].'</td><td class="text-center">'.
                (($item['estado_ID']==92)?'':'<a class="btn btn-danger" title="Eliminar" onclick="fncEliminar('.$i.');"><i class="fa fa-trash"></i></a>').
                '</td></tr>';
            $val++;
        }
        
       
        $i++;
    }
    $html.='<tbody>';
    $html.='</tbody>';
    $html.='</table>';
    return $html;
}

function post_ajaxTablaDetalleComprobanteRegula() {
    
    $identificador=$_POST['id'];
   
   $html=estructura_tabla_detalle($identificador);
    
   
    $retornar = Array('html'=>$html);
    echo json_encode($retornar);
}
function post_ajaxSalirComprobanteRegula() {
    
    $identificador=$_POST['id'];
    unset($identificador);
   
   
    $retornar = Array('resultado'=>1);
    echo json_encode($retornar);
}
function post_ajaxEliminarDetalleComprobanteRegula() {
    
    $i=$_POST['id'];
    $identificador=$_POST['id1'];
   
    $array=$_SESSION[$identificador];
    if($array[$i]["factura_venta_detalle_ID"]==-1){
        unset($array[$i]);
        $_SESSION[$identificador]=$array;
    }else{
        $array_reemplazo=array("accion"=>"eliminar");
        $nuevo_array=array_replace($array[$i],$array_reemplazo);
        $array_general=array($i=>$nuevo_array);
        $_SESSION[$identificador]=array_replace($array,$array_general);
    }
    
    $retornar = Array('resultado'=>1,"mensaje"=>"Se eliminó correctamente");
    echo json_encode($retornar);
}

function get_Nota_Credito_Detalle($id){
    require ROOT_PATH.'models/tipo_impuestos.php';
    global  $returnView_float;
    $llave=$id;
    $returnView_float=true;
    $dtTipo_Impuestos=tipo_impuestos::getGrid();
    $GLOBALS['dtTipo_Impuestos']=$dtTipo_Impuestos;
    $GLOBALS['llave']=$llave;
}
function post_Nota_Credito_Detalle(){
    require ROOT_PATH.'models/comprobante_regula_detalle.php';
    global  $returnView_float;
    $returnView_float=true;
    $obj=new comprobante_regula_detalle();
    $llave=$_POST['llave'];
    $producto_ID=$_POST['txtProducto_ID'];
    $producto= FormatTextSave($_POST['listaProductos']);
    $descripcion=FormatTextSave($_POST['txtDescripcion']);
    $cantidad=$_POST['txtCantidad'];
    $precio_unitario=$_POST['txtValor_Unitario'];
    $subtotal=$_POST['txtSubTotal'];
    $total=$_POST['txtTotal'];
    //$porcentaje_descuento=$_POST['txtDescuento'];
    $tipo_impuestos_ID=$_POST['selTipo_Impuesto'];
    
    $igv=$_POST['txtIGV'];
    //$otros_cargos=$_POST['txtOtros_Cargos'];
    $total=$_POST['txtTotal'];
    
    $obj->producto_ID=$producto_ID;
    $obj->cantidad=$cantidad;
    $obj->precio_unitario=$precio_unitario;
    $obj->subtotal=$subtotal;
    $obj->total=$total;
    $obj->igv=$igv;
    $obj->tipo_impuestos_ID=$tipo_impuestos_ID;
    //$obj->porcentaje_descuento=$porcentaje_descuento;
    //$obj->otros_cargos=$otros_cargos;
    $obj->producto=$producto;
    $array=array(
        "factura_venta_detalle_ID"=>-1,
        "producto"=>$producto,
        "producto_ID"=>$producto_ID,
        "cantidad"=>$cantidad,
        "precio_unitario"=>$precio_unitario,
        "subtotal"=>$subtotal,
        "igv"=>$igv,
        "total"=>$total,
        "tipo_impuestos_ID"=>$tipo_impuestos_ID,
        "descripcion"=>$descripcion,
        "accion"=>"insertar",
        "estado_ID"=>90,//estado borrador
    );
    
    array_push($_SESSION[$llave],$array);

    $GLOBALS['obj']=$obj;
    $GLOBALS['resultado']=1;
    $GLOBALS['mensaje']="Se guardó correctamente";
   
}

function get_Factura_Venta_Emitidas(){
    global $returnView_float;
    $returnView_float=true;
    
}
function post_ajaxFacturas_Emitidas() {
    require ROOT_PATH.'models/factura_venta.php';
    $periodo=$_POST['selPeriodo'];
    $serie=trim($_POST['txtSerie']);
    $numero=(trim($_POST['txtNumero'])=="")?0:trim($_POST['txtNumero']);
    try{
         //$dt = comprobante_regula::getTabla($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
       $dt=factura_venta::getTablaFactura_VentaSNC($periodo,$serie,$numero);
       echo(json_encode($dt, JSON_NUMERIC_CHECK)); 
    }catch(Exception $ex){
        console_log($ex);
    }
    
}

function post_ajaxExtraerInformacionFacturas_Emitidas() {
    require ROOT_PATH.'models/factura_venta.php';
    require ROOT_PATH.'models/factura_venta_detalle.php';
    require ROOT_PATH.'models/salida.php';
    require ROOT_PATH.'models/cliente.php';
    $factura_venta_ID=$_POST['id'];
    $identificador=$_POST['id1'];
    $numero="";
    $moneda_ID=1;
    $cliente="";
    $cliente_ID="";
    $tabla="";
    $subtotal=0;
    $igv=0;
    $total=0;
    
    $resultado=0;
    try{
        $oFactura_Venta=factura_venta::getByID($factura_venta_ID);
        $oSalida=salida::getByID($oFactura_Venta->salida_ID);
        $oCliente=cliente::getByID($oSalida->cliente_ID);
        $numero=$oFactura_Venta->serie."-".$oFactura_Venta->numero_concatenado;
        $moneda_ID=$oFactura_Venta->moneda_ID;
        $cliente=FormatTextView($oCliente->ruc.' '.$oCliente->razon_social);
        $cliente_ID=$oCliente->ID;
        $subtotal=$oFactura_Venta->monto_total_neto;
        $igv=$oFactura_Venta->monto_total_igv;
        $total=$oFactura_Venta->monto_total;
        $dtFactura_Venta_Detalle=factura_venta::getComprobante_Electronico($factura_venta_ID,'detalle');
        $i=0;
        $dt=$_SESSION[$identificador];
        if(count($dt)==0){
            unset($dt);
            $dt=array();
        }
        foreach($dtFactura_Venta_Detalle as $valor){
            $val=$i+1;
            $array=array(
                "factura_venta_detalle_ID"=>$valor['ID'],
                "producto"=>$valor['producto'],
                "producto_ID"=>$valor['producto_ID'],
                "cantidad"=>$valor['cantidad'],
                "precio_unitario"=>$valor['precio_unitario'],
                "subtotal"=>$valor['sub_total'],
                "igv"=>$valor['igv'],
                "total"=>$valor['total'],
                "tipo_impuestos_ID"=>1,
                "descripcion"=>$valor['descripcion'],
                "accion"=>"insertar",
                "estado_ID"=>90,//estado borrador
            );
            array_push($dt,$array);
            //$tabla.='<tr id="tr'.$i.'"><td class="text-center">'.$val.'<input name="txt'.$valor['ID'].'" type="hidden" value="'.$valor['ID'].'"></td><td>'.FormatTextView($valor['producto']).'</td><td class="text-center">'.$valor['cantidad'].'</td><td>'.$valor['precio_unitario'].'</td><td>'.$valor['sub_total'].'</td><td>'.$valor['total'].'</td><td class="text-center"><a class="btn btn-danger" title="Eliminar" onclick="fncEliminar('.$i.');"><i class="fa fa-trash"></i></a></td></tr>';
            $i++;
        }
        $_SESSION[$identificador]=$dt;
        $resultado=1;
    }catch(Exception $ex){
        $resultado=-1;
    }
    
   
    $retornar = Array('resultado'=>$resultado,'numero' => $numero,'moneda_ID'=>$moneda_ID,'cliente'=>$cliente,'cliente_ID'=>$cliente_ID,
        'subtotal'=>$subtotal,'igv'=>$igv,'total'=>$total,'tabla'=>$tabla);
    echo json_encode($retornar);
}
function post_ajaxMostrarDetalleComprobanteRegula() {
    require ROOT_PATH.'models/comprobante_regula.php';
    require ROOT_PATH.'models/comprobante_regula_detalle.php';
    require ROOT_PATH.'models/salida.php';
    require ROOT_PATH.'models/cliente.php';
    $comprobante_regula_ID=$_POST['id'];
    $numero="";
    $tabla="";
    try{
        
        $dt=comprobante_regula_detalle::getGrid($comprobante_regula_ID);
        $i=0;
        foreach($dt as $valor){
            $val=$i+1;
            $tabla.='<tr id="tr'.$i.'"><td class="text-center">'.$val.'</td><td>'.FormatTextView($valor['producto']).'</td><td class="text-center">'.$valor['cantidad'].'</td><td>'.$valor['precio_unitario'].'</td><td>'.$valor['subtotal'].'</td><td>'.$valor['total'].'</td><td class="text-center">'.
            (($valor['estado_ID']==92)?'':'<a class="btn btn-danger" title="Eliminar" onclick="fncEliminar('.$i.');"><i class="fa fa-trash"></i></a>').
            '</td></tr>';
            $i++;
        }
        $resultado=1;
    }catch(Exception $ex){
        $resultado=-1;
    }
    
   
    $retornar = Array('resultado'=>$tabla);
    echo json_encode($retornar);
}

function post_ajaxEnviarNota_CreditoSUNAT() {
    if(!class_exists("comprobante_regula")){
        require ROOT_PATH.'models/comprobante_regula.php';
    }
    $id=$_POST['id'];
    $resultado=0;
    try{
        $array=enviarComprobante_RegulaSUNAT($id);
        
        if($array['resultado_final']==1){
            $resultado=1; 
            $mensaje= $array['mensaje_final'];
        }else{
            throw new exception($array['mensaje_final']);
        }
    }catch(Exception $ex){
        $resultado=-1;
        $mensaje=utf8_encode(mensaje_error);
        log_error(__FILE__,"salidaController.post_ajaxEnviarNota_CreditoSUNAT",$ex->getMessage());
    }
    

    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
    echo json_encode($retornar);
}
function enviarComprobante_RegulaSUNAT($ID){
    //require_once('include/URL_API.php');
    //$new = new api_SUNAT();
    
    if(!class_exists("comprobante_regula")){
        require ROOT_PATH.'models/comprobante_regula.php';
    }
    if(!class_exists("comprobante_regula_detalle")){
        require ROOT_PATH.'models/comprobante_regula_detalle.php';
    }
    
    require ROOT_PATH.'include/lib_fecha_texto.php';
    require ROOT_PATH.'models/comprobante_regula_sunat.php';
    require ROOT_PATH.'include/facturacion_electronica/transaccion_documentos.php';
    $array_resultado=array();
    $mensaje="";
    $resultado=0;
    $transacion = new transaccion_documentos();
    try{
        $oComprobante_Regula=comprobante_regula::getByIDSUNAT($ID);
        $dt=comprobante_regula_detalle::getGrid($ID);
        $DocumentoDetalle = array();
        $Discrepancias = array();
        $DocumentoRelacionado = array();
        $DatoAdicionales=array();
        $i=1;
        
        $Discrepancias[]= array (
            'NroReferencia'=>$oComprobante_Regula->factura,
            'Tipo'=>$oComprobante_Regula->tipo_comprobante_discrepancia,
            'Descripcion'=>utf8_decode($oComprobante_Regula->motivo_descripcion)
                );//utf8_decode($oComprobante_Regula->motivo_descripcion)
        $DatoAdicionales[]=array("Codigo"=>"","Contenido"=>"");
              //'NroReferencia'=>$oComprobante_Regula->factura,'Tipo'=>$oComprobante_Regula->tipo,'Descripcion'=>'Anulación de la operación');//utf8_decode($oComprobante_Regula->motivo_descripcion)
  
        foreach($dt as $valor){
            $DocumentoDetalle[] = array (
                'Id' => $i,
                'Cantidad' =>$valor['cantidad'],
                'UnidadMedida' => $valor['unidad_medida'],
                'CodigoItem' => $valor['codigo_producto'],
                'Descripcion' => $valor['producto'],
                'PrecioUnitario' => $valor['precio_unitario'],
                'PrecioReferencial' =>$valor['precio_unitario_incluyeigv'],
                'TipoPrecio' => '01',
                'TipoImpuesto' =>$valor['tipo_impuesto'], //$valor['tipo_impuesto'],
                'Impuesto' => $valor['impuesto'],
                'ImpuestoSelectivo' => 0,
                'OtroImpuesto' => 0,
                'Descuento' => 0,
                'PlacaVehiculo' => $valor['vehiculo'],
                'TotalVenta' => $valor['subtotal'],
                'Suma' => $valor['total']
              );
            $i++;
        }
        $total_facturado=explode(".",$oComprobante_Regula->monto_total);
        $decimal="00";
        if(isset($total_facturado[1])){
            if(strlen($total_facturado[1])==1){
                $decimal=$total_facturado[1].'0';
            }else {
                $decimal=$total_facturado[1];
            }

        }
        $total_letra="SON ".numtoletras($total_facturado[0])." CON ".$decimal."/100 ".str_replace("ó","O",strtoupper(utf8_encode($oComprobante_Regula->moneda))).".";
        //$param_emisor = $new->getParamEmisor($oComprobante_Regula->empresa_ID);
        $param_emisor = $transacion->getParamEmisor($oComprobante_Regula->empresa_ID);
        $data = array (
        'IdDocumento' =>$oComprobante_Regula->serie.'-'.$oComprobante_Regula->numero,//FC02-1',
        'TipoDocumento' => $oComprobante_Regula->codigo_comprobante,
        'Emisor' => $param_emisor["Emisor"],
        'Receptor' =>  array (
            'NroDocumento' => $oComprobante_Regula->ruc,
            'TipoDocumento' => '6',//RUC
            'NombreLegal' => $oComprobante_Regula->razon_social,
            'NombreComercial'=>$oComprobante_Regula->razon_social,
            'Ubigeo'=>$oComprobante_Regula->ubigeo,
            'Direccion'=>$oComprobante_Regula->direccion_cliente,
            'Urbanizacion'=>$oComprobante_Regula->urbanizacion_cliente,
            'Departamento'=>$oComprobante_Regula->departamento_cliente,
            'Provincia'=>$oComprobante_Regula->provincia_cliente,
            'Distrito'=>$oComprobante_Regula->distrito_cliente
        ),
        'FechaEmision' =>$oComprobante_Regula->fecha_emision,// '2018-06-20',//$oComprobante_Regula->fecha_emision
        'HoraEmision' =>date("H:i:s"),
        'Motivo'=>$oComprobante_Regula->motivo_descripcion,
        'Moneda' => $oComprobante_Regula->codigo_moneda,
        'TipoOperacion' => $oComprobante_Regula->tipo,
        'Gravadas' => $oComprobante_Regula->monto_total_neto,
        'Gratuitas' => $oComprobante_Regula->gratuitas,
        'Inafectas' => $oComprobante_Regula->inafectas,
        'Exoneradas' => $oComprobante_Regula->exoneradas,
        'DescuentoGlobal' => $oComprobante_Regula->descuento_global,
        'Items' => $DocumentoDetalle,   
        'TotalVenta' => $oComprobante_Regula->monto_total,
        'ImporteTotalVenta'=> $oComprobante_Regula->monto_total,
        'TotalIgv' => $oComprobante_Regula->monto_total_igv,
        'TotalIsc' => 0,
        'TotalOtrosTributos' => 0,
        'MontoEnLetras' => $total_letra,
        'PlacaVehiculo' => '',
        'MontoPercepcion' => 0,
        'MontoDetraccion' => $oComprobante_Regula->monto_detraccion,
        'DatoAdicionales'=>$DatoAdicionales,   
        'TipoDocAnticipo' => '',
        'DocAnticipo' => '',
        'MonedaAnticipo' => '',
        'MontoAnticipo' => 0,
        "DatosGuiaTransportista"=>array(
            "DireccionDestino"=>array(
            "NroDocumento"=> "",
            "TipoDocumento"=> "",
            "NombreLegal"=> "",
            "NombreComercial"=> "",
            "Ubigeo"=> "",
            "Direccion"=> "",
            "Urbanizacion"=> "",
            "Departamento"=> "",
            "Provincia"=> "",
            "Distrito"=> ""
            ),
            "DireccionOrigen"=>array(
            "NroDocumento"=> "",
            "TipoDocumento"=> "",
            "NombreLegal"=> "",
            "NombreComercial"=> "",
            "Ubigeo"=> "",
            "Direccion"=> "",
            "Urbanizacion"=> "",
            "Departamento"=> "",
            "Provincia"=> "",
            "Distrito"=> ""
            ),
        "RucTransportista"=> "",
        "TipoDocTransportista"=> "",
        "NombreTransportista"=> "",
        "NroLicenciaConducir"=> "",
        "PlacaVehiculo"=> "",
        "CodigoAutorizacion"=> "",
        "MarcaVehiculo"=> "",
        "ModoTransporte"=> "",
        "UnidadMedida"=> "",
        "PesoBruto"=> 0
      ),
        'Relacionados'=>array('NroDocumento'=>$oComprobante_Regula->factura,'TipoDocumento'=>'01'),
        'OtrosDocumentosRelacionados'=>array('NroDocumento'=>'','TipoDocumento'=>''),
        'Discrepancias'=>$Discrepancias,
        'CalculoIgv' => 18,//$oComprobante_Regula->igv,
        'CalculoIsc' => 0.10,
        'CalculoDetraccion' => 0.04 
      );
        //print_r ($data);
        $transacion->array_documento=$data;
        if($oComprobante_Regula->codigo_comprobante=='07'){
            $transacion->documento="nota_credito";
            $ruta=$transacion->generar_xml();
            $ruta_xml_firmado=$transacion->firmar_documento($ruta,"notacredito");
            //echo $ruta_xml_firmado;
            $transacion->enviar_documento($ruta_xml_firmado,"notacredito");
        }else{
            $transacion->documento="nota_debito";
            $ruta=$transacion->generar_xml();
            $ruta_xml_firmado=$transacion->firmar_documento($ruta,"notadebito");
            //echo $ruta_xml_firmado;
            $transacion->enviar_documento($ruta_xml_firmado,"notadebito");
        }
        
        $oComprobante_Regula->estado_ID=92;//Estado enviado
        $oComprobante_Regula->usuario_mod_id=$_SESSION['usuario_ID'];
        $oComprobante_Regula->actualizar();
            
            
        $resultado=1;
        $mensaje="Se guardó correctamente";
      
      
    } catch (Exception $ex) {
        $mensaje=utf8_encode(mensaje_error);
        $resultado=-1;
        log_error(__FILE__, "salidaController.enviarComprobante_RegulaSUNAT", $ex->getMessage());
    }
    $array_resultado['resultado_final']=$resultado;
    $array_resultado['mensaje_final']=$mensaje;
    return $array_resultado;
    
}
//================================================================
//NOTA DE DEBITO
function get_Nota_Debito_Mantenimiento(){
    require ROOT_PATH.'models/cliente.php';
    require ROOT_PATH.'models/estado.php';
    require ROOT_PATH.'models/moneda.php';
    global  $returnView;
    $returnView=true;

    $dtCliente=cliente::getGrid('',-1,-1,'clt.razon_social ASC');
    $dtMoneda=moneda::getGrid();
    $dtEstado=estado::getGrid('tabla="comprobante_regula"');
    $GLOBALS['dtCliente']=$dtCliente;
    $GLOBALS['dtMoneda']=$dtMoneda;
    $GLOBALS['dtEstado']=$dtEstado;
    //$GLOBALS['mensaje']='';
}
function post_ajaxNota_Debito_Mantenimiento() {
    require ROOT_PATH . 'models/comprobante_regula.php';
    
    $cliente=$_POST['selCliente'];
    $periodo=$_POST['selPeriodo'];
    $fecha_inicio=FormatTextToDate($_POST['txtFechaInicio'],'Y-m-d');
    $fecha_fin=FormatTextToDate($_POST['txtFechaFin'],'Y-m-d');
    $estado_ID=$_POST['selEstado'];
    $moneda_ID=$_POST['selMoneda'];
    $serie=(trim($_POST['txtSerie'])=="")?0:trim($_POST['txtSerie']);
    $numero=(trim($_POST['txtNumero'])=="")?0:trim($_POST['txtNumero']);
   
    $opcion=$_POST['rbOpcion'];
    try{
         //$dt = comprobante_regula::getTabla($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
       $dt=comprobante_regula::getTabla($opcion,$cliente,$periodo,$fecha_inicio,$fecha_fin,$estado_ID,$moneda_ID,$serie,$numero,'nota_debito');
        echo(json_encode($dt, JSON_NUMERIC_CHECK)); 
    }catch(Exception $ex){
        consolo_log($ex);
    }
    
}
function get_Nota_Debito_Mantenimiento_Nuevo(){
    require ROOT_PATH.'models/tipo.php';
    require ROOT_PATH.'models/moneda.php';
    require ROOT_PATH.'models/correlativos.php';
    require ROOT_PATH.'models/datos_generales.php';
    require ROOT_PATH.'models/comprobante_regula.php';
    global  $returnView_float;
    $returnView_float=true;
    $dtTipo=tipo::getGrid("tabla='nota_debito'",-1,-1,"orden asc");
    $oCorrelativos=correlativos::getByID(correlativos_ID_nota_debito);
    $dtMoneda=moneda::getGrid("",-1,-1,"descripcion asc");
    
    $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
    $oComprobante_Regula=new comprobante_regula();
    $oComprobante_Regula->correlativos_ID=correlativos_ID_nota_debito;
    $oComprobante_Regula->serie=$oCorrelativos->serie;
    $oComprobante_Regula->dtSerie=correlativos::getGridCorrelativos("nota_debito",1);
    $oComprobante_Regula->numero_concatenado=sprintf("%',06d",$oCorrelativos->ultimo_numero+1);
    $GLOBALS['dtTipo']=$dtTipo;
    $GLOBALS['dtMoneda']=$dtMoneda;

    $oComprobante_Regula->tipo_cambio=$oDatos_Generales->tipo_cambio;
    $GLOBALS['ob']=$oComprobante_Regula;
    $valor=rand();
    $identificador='dtDetalleNotaDebito'.$valor;
    $GLOBALS['llave']=$identificador;
    $_SESSION[$identificador]=array();
  
}
function post_Nota_Debito_Mantenimiento_Nuevo(){
    require ROOT_PATH.'models/tipo.php';
    require ROOT_PATH.'models/moneda.php';
    require ROOT_PATH.'models/correlativos.php';
    require ROOT_PATH.'models/datos_generales.php';
    require ROOT_PATH.'models/comprobante_regula.php';
    require ROOT_PATH.'models/comprobante_regula_detalle.php';
    require ROOT_PATH.'models/usuario.php';
    require ROOT_PATH.'models/factura_venta.php';
    require ROOT_PATH.'models/factura_venta_detalle.php';
    require ROOT_PATH.'models/salida_detalle.php';
 
    global  $returnView_float;
    $returnView_float=true;
    $documento_relacionado_ID=$_POST['txtFactura_Venta_ID'];
    $identificador=$_POST['llave'];
    $tipo_ID=$_POST['selTipo'];
    $fecha_emision1=$_POST['txtFecha_Emision'];
    $fecha_emision=FormatTextToDate($fecha_emision1,'Y-m-d');
    $fecha_vencimiento1=$_POST['txtFecha_vencimiento'];
    $fecha_vencimiento=FormatTextToDate($fecha_vencimiento1,'Y-m-d');
    $moneda_ID=$_POST['selMoneda'];
    $monto_total_neto=$_POST['txtSubTotal'];
    $monto_total_igv=$_POST['txtIGV'];
    $monto_total=$_POST['txtTotal'];
    $monto_pendiente=0;
    $tipo_cambio=$_POST['txtTipo_Cambio'];
    $correlativos_ID=$_POST['selSerie'];
    $serie=$_POST['txtSerie'];
    $porcentaje_descuento=($_POST['txtPorcentaje']=="")? 0:$_POST['txtPorcentaje'];
    $anticipo=0;
    $exoneradas=0;
    $inafectas=0;
    $gravadas=$monto_total_neto;
    $gratuitas=0;
    $otros_cargos=($_POST['txtOtros_Cargos']=="")? 0:$_POST['txtOtros_Cargos'];
    $descuento_global=($_POST['txtDescuentoTotal']=="")? 0:$_POST['txtDescuentoTotal'];
    $observacion=FormatTextSave($_POST['txtObservacion']);
    $monto_detraccion=0;
    $cliente_ID=$_POST['txtCliente_ID'];
    $factura=$_POST['txtFactura'];
    $cliente_descripcion=$_POST['listaCliente'];
    $oComprobante_Regula=new comprobante_regula();
    $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
    try{
        $dt=$_SESSION[$identificador];
        if(count($dt)==0){
            throw new Exception("No se puede generar la nota de débito, no tiene detalle.");
        }
        $oCorrelativos=correlativos::getByID($correlativos_ID);
        $oComprobante_Regula->documento_relacionado_ID=$documento_relacionado_ID;
        $oComprobante_Regula->cliente_ID=$cliente_ID;
        $oComprobante_Regula->tipo_ID=$tipo_ID;
        $oComprobante_Regula->serie=$oCorrelativos->serie;
        $oComprobante_Regula->numero=$oCorrelativos->ultimo_numero+1;
        $oComprobante_Regula->numero_concatenado= sprintf("%',06d",$oComprobante_Regula->numero);
        $oComprobante_Regula->fecha_emision=$fecha_emision;
        $oComprobante_Regula->fecha_vencimiento=$fecha_vencimiento;
        $oComprobante_Regula->estado_ID=90;//Lo guardamos con el estado borrador
        $oComprobante_Regula->moneda_ID=$moneda_ID;
        $oComprobante_Regula->monto_total_neto=$monto_total_neto;
        $oComprobante_Regula->monto_total_igv=$monto_total_igv;
        $oComprobante_Regula->monto_total=$monto_total;
        $oComprobante_Regula->monto_pendiente=$monto_pendiente;
        $oComprobante_Regula->empresa_ID=$_SESSION['empresa_ID'];
        $oComprobante_Regula->correlativos_ID=$correlativos_ID;
        $oComprobante_Regula->porcentaje_descuento=$porcentaje_descuento;
        $oComprobante_Regula->anticipo=$anticipo;
        $oComprobante_Regula->exoneradas=$exoneradas;
        $oComprobante_Regula->inafectas=$inafectas;
        $oComprobante_Regula->gravadas=$gravadas;
        $oComprobante_Regula->gratuitas=$gratuitas;
        $oComprobante_Regula->otros_cargos=$otros_cargos;
        $oComprobante_Regula->descuento_global=$descuento_global;
        $oComprobante_Regula->monto_detraccion=$monto_detraccion;
        $oComprobante_Regula->observacion=$observacion;
        $oComprobante_Regula->tipo_cambio=$tipo_cambio;
        
        $oComprobante_Regula->usuario_id=$_SESSION['usuario_ID'];
        if($oComprobante_Regula->verificarFactura()==0){
            if($oComprobante_Regula->insertar()>0){
               
                $resultado=1;
                $mensaje=$oComprobante_Regula->getMessage;
                
                //$dt=factura_venta_detalle::getGrid1("fvd.factura_venta_ID=".$documento_relacionado_ID,-1,-1);
                foreach($dt as $valor){
                    $oComprobante_Regula_Detalle=new comprobante_regula_detalle();
                    $oComprobante_Regula_Detalle->producto_ID=$valor['producto_ID'];
                    $oComprobante_Regula_Detalle->comprobante_regula_ID=$oComprobante_Regula->ID;
                    $oComprobante_Regula_Detalle->descripcion=$valor['descripcion'];
                    $oComprobante_Regula_Detalle->cantidad=$valor['cantidad'];
                    $oComprobante_Regula_Detalle->precio_unitario=$valor['precio_unitario'];
                    $oComprobante_Regula_Detalle->subtotal=$valor['subtotal'];
                    $oComprobante_Regula_Detalle->total=$valor['total'];
                    $oComprobante_Regula_Detalle->vigv=$oDatos_Generales->vigv;
                    $oComprobante_Regula_Detalle->igv=$valor['igv'];
                    $oComprobante_Regula_Detalle->factura_venta_detalle_ID=$valor['factura_venta_detalle_ID'];;
                    $oComprobante_Regula_Detalle->tipo_impuestos_ID=$valor['tipo_impuestos_ID'];
                    $oComprobante_Regula_Detalle->usuario_id=$_SESSION['usuario_ID'];
                    $oComprobante_Regula_Detalle->insertar();
                    
                }
            }
            $oCorrelativos=correlativos::getByID($oComprobante_Regula->correlativos_ID);
            $oCorrelativos->ultimo_numero=$oComprobante_Regula->numero;
            $oCorrelativos->usuario_mod_id=$_SESSION['usuario_ID'];
            $oCorrelativos->actualizar();
            //Actualizamos el estado del documento
            $oComprobante_Regula->estado_ID=91;
            $oComprobante_Regula->usuario_mod_id=$_SESSION['usuario_ID'];
            $oComprobante_Regula->actualizar();
          
        }else{
            throw new Exception("La factura no se encuentra disponible.");
        }
        
    }catch(Exception $ex){
       $mensaje= $ex->getMessage();
       $resultado=-1;
    }
    
    
    $dtTipo=tipo::getGrid("tabla='nota_debito'",-1,-1,"orden asc");
    $dtMoneda=moneda::getGrid("",-1,-1,"descripcion asc");
    $oComprobante_Regula->fecha_emision=$fecha_emision1;
    $oComprobante_Regula->fecha_vencimiento=$fecha_vencimiento1;
    $oComprobante_Regula->dtSerie=correlativos::getGridCorrelativos("nota_debito",1);
    $oComprobante_Regula->factura=$factura;
    $oComprobante_Regula->cliente_descripcion=$cliente_descripcion;
    $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
    $GLOBALS['dtTipo']=$dtTipo;
    $GLOBALS['dtMoneda']=$dtMoneda;
    $GLOBALS['llave']=$identificador;
    $GLOBALS['tipo_cambio']=$oDatos_Generales->tipo_cambio;
    $GLOBALS['ob']=$oComprobante_Regula;
    $GLOBALS['resultado']=$resultado;
    $GLOBALS['mensaje']=$mensaje;
    
}
function get_Nota_Debito_Mantenimiento_Editar($id){
    require ROOT_PATH.'models/tipo.php';
    require ROOT_PATH.'models/moneda.php';
    require ROOT_PATH.'models/correlativos.php';
    require ROOT_PATH.'models/datos_generales.php';
    require ROOT_PATH.'models/comprobante_regula.php';
    require ROOT_PATH.'models/comprobante_regula_detalle.php';
    global  $returnView_float;
    $returnView_float=true;
    $dtTipo=tipo::getGrid("tabla='nota_debito'",-1,-1,"orden asc");
    
    $dtMoneda=moneda::getGrid("",-1,-1,"descripcion asc");
    
    $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
    $oComprobante_Regula=comprobante_regula::getByID($id);
    $array_general=array();
    $dt=comprobante_regula_detalle::getGrid($id);
    foreach($dt as $valor){
        $array=array(
            "factura_venta_detalle_ID"=>$valor['factura_venta_detalle_ID'],
            "producto"=>$valor['producto'],
            "producto_ID"=>$valor['producto_ID'],
            "cantidad"=>$valor['cantidad'],
            "precio_unitario"=>$valor['precio_unitario'],
            "subtotal"=>$valor['subtotal'],
            "igv"=>$valor['vigv'],
            "total"=>$valor['total'],
            "tipo_impuestos_ID"=>$valor['tipo_impuestos_ID'],
            "descripcion"=>$valor['descripcion'],
            "accion"=>$valor['accion'],
            "estado_ID"=>$valor['estado_ID']//estado borrador
        ); 
        array_push($array_general,$array);
    }
    $oCorrelativos=correlativos::getByID($oComprobante_Regula->correlativos_ID);

    $oComprobante_Regula->dtSerie=correlativos::getGridCorrelativos("nota_debito",1);
    $GLOBALS['dtTipo']=$dtTipo;
    $GLOBALS['dtMoneda']=$dtMoneda;

    $GLOBALS['tipo_cambio']=$oDatos_Generales->tipo_cambio;
    $GLOBALS['ob']=$oComprobante_Regula;
    $valor=rand();
    $identificador='dtDetalleNotaCredito'.$valor;
    $GLOBALS['llave']=$identificador;
    $_SESSION[$identificador]=$array_general;
}
function post_Nota_Debito_Mantenimiento_Editar($id){
    require ROOT_PATH.'models/tipo.php';
    require ROOT_PATH.'models/moneda.php';
    require ROOT_PATH.'models/correlativos.php';
    require ROOT_PATH.'models/datos_generales.php';
    require ROOT_PATH.'models/comprobante_regula.php';
    require ROOT_PATH.'models/comprobante_regula_detalle.php';
    require ROOT_PATH.'models/usuario.php';
    require ROOT_PATH.'models/factura_venta.php';
    require ROOT_PATH.'models/factura_venta_detalle.php';
    require ROOT_PATH.'models/salida_detalle.php';
 
    global  $returnView_float;
    $returnView_float=true;
    $identificador=$_POST['llave'];
    $documento_relacionado_ID=$_POST['txtFactura_Venta_ID'];
    $tipo_ID=$_POST['selTipo'];
    $factura=$_POST['txtFactura'];
    $fecha_emision1=$_POST['txtFecha_Emision'];
    $fecha_emision=FormatTextToDate($fecha_emision1,'Y-m-d');
    $fecha_vencimiento1=$_POST['txtFecha_vencimiento'];
    $fecha_vencimiento=FormatTextToDate($fecha_vencimiento1,'Y-m-d');
    $moneda_ID=$_POST['selMoneda'];
    $monto_total_neto=$_POST['txtSubTotal'];
    $monto_total_igv=$_POST['txtIGV'];
    $monto_total=$_POST['txtTotal'];
    $monto_pendiente=0;
    $tipo_cambio=$_POST['txtTipo_Cambio'];
    $correlativos_ID=$_POST['selSerie'];
    $serie=$_POST['txtSerie'];
    $porcentaje_descuento=($_POST['txtPorcentaje']=="")? 0:$_POST['txtPorcentaje'];
    $anticipo=0;
    $exoneradas=0;
    $inafectas=0;
    $gravadas=$monto_total_neto;
    $gratuitas=0;
    $otros_cargos=($_POST['txtOtros_Cargos']=="")? 0:$_POST['txtOtros_Cargos'];
    $descuento_global=($_POST['txtDescuentoTotal']=="")? 0:$_POST['txtDescuentoTotal'];
    $observacion=FormatTextSave($_POST['txtObservacion']);
    $monto_detraccion=0;
    $cliente_ID=$_POST['txtCliente_ID'];
    $cliente_descripcion=$_POST['listaCliente'];
    $opcion=(isset($_POST['ckOpcion']))? 1 : 0;
    $oComprobante_Regula=comprobante_regula::getByID($id);
    try{
        $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
        $oCorrelativos=correlativos::getByID($correlativos_ID);
        $oComprobante_Regula->documento_relacionado_ID=$documento_relacionado_ID;
        $oComprobante_Regula->cliente_ID=$cliente_ID;
        $oComprobante_Regula->tipo_ID=$tipo_ID;
        if($opcion==1){
            $oComprobante_Regula->serie=$oCorrelativos->serie;
            $oComprobante_Regula->numero=$oCorrelativos->ultimo_numero+1;
            $oComprobante_Regula->numero_concatenado= sprintf("%',06d",$oComprobante_Regula->numero);
            $oComprobante_Regula->correlativos_ID=$correlativos_ID;
        }
        $oComprobante_Regula->fecha_emision=$fecha_emision;
        $oComprobante_Regula->fecha_vencimiento=$fecha_vencimiento;
        //$oComprobante_Regula->estado_ID=90;//Lo guardamos con el estado borrador
        $oComprobante_Regula->moneda_ID=$moneda_ID;
        $oComprobante_Regula->monto_total_neto=$monto_total_neto;
        $oComprobante_Regula->monto_total_igv=$monto_total_igv;
        $oComprobante_Regula->monto_total=$monto_total;
        $oComprobante_Regula->monto_pendiente=$monto_pendiente;
        //$oComprobante_Regula->empresa_ID=$_SESSION['empresa_ID'];
        $oComprobante_Regula->cliente_descripcion=$cliente_descripcion;
        $oComprobante_Regula->porcentaje_descuento=$porcentaje_descuento;
        $oComprobante_Regula->anticipo=$anticipo;
        $oComprobante_Regula->exoneradas=$exoneradas;
        $oComprobante_Regula->inafectas=$inafectas;
        $oComprobante_Regula->gravadas=$gravadas;
        $oComprobante_Regula->gratuitas=$gratuitas;
        $oComprobante_Regula->otros_cargos=$otros_cargos;
        $oComprobante_Regula->descuento_global=$descuento_global;
        $oComprobante_Regula->monto_detraccion=$monto_detraccion;
        $oComprobante_Regula->observacion=$observacion;
        $oComprobante_Regula->tipo_cambio=$tipo_cambio;
        $oComprobante_Regula->factura=$factura;
        $oComprobante_Regula->usuario_mod_id=$_SESSION['usuario_ID'];
        if($oComprobante_Regula->verificarFactura()==0){
            if($oComprobante_Regula->actualizar()>0){
                $resultado=1;
                $mensaje=$oComprobante_Regula->getMessage;
                //$dt=factura_venta_detalle::getGrid1("fvd.factura_venta_ID=".$documento_relacionado_ID,-1,-1);
                $dt=$_SESSION[$identificador];
                foreach($dt as $valor){
                    $oComprobante_Regula_Detalle=new comprobante_regula_detalle();
                    $oComprobante_Regula_Detalle->producto_ID=$valor['producto_ID'];
                    $oComprobante_Regula_Detalle->comprobante_regula_ID=$oComprobante_Regula->ID;
                    $oComprobante_Regula_Detalle->descripcion=$valor['descripcion'];
                    $oComprobante_Regula_Detalle->cantidad=$valor['cantidad'];
                    $oComprobante_Regula_Detalle->precio_unitario=$valor['precio_unitario'];
                    $oComprobante_Regula_Detalle->subtotal=$valor['subtotal'];
                    $oComprobante_Regula_Detalle->total=$valor['total'];
                    $oComprobante_Regula_Detalle->vigv=$oDatos_Generales->vigv;
                    $oComprobante_Regula_Detalle->igv=$valor['igv'];
                    $oComprobante_Regula_Detalle->factura_venta_detalle_ID=$valor['factura_venta_detalle_ID'];;
                    $oComprobante_Regula_Detalle->tipo_impuestos_ID=$valor['tipo_impuestos_ID'];
                    if($valor['accion']=="insertar"){
                        $oComprobante_Regula_Detalle->usuario_id=$_SESSION['usuario_ID'];
                        $oComprobante_Regula_Detalle->insertar();
                    }else if($valor['accion']=="actualizar"){
                        $oComprobante_Regula_Detalle->usuario_mod_id=$_SESSION['usuario_ID'];
                        $oComprobante_Regula_Detalle->actualizar();
                    }elseif($valor['accion']=="eliminar"){
                        
                    }
                    
                }
            }
            $oCorrelativos=correlativos::getByID($oComprobante_Regula->correlativos_ID);
            $oCorrelativos->ultimo_numero=$oComprobante_Regula->numero;
            $oCorrelativos->usuario_mod_id=$_SESSION['usuario_ID'];
            $oCorrelativos->actualizar();
            //Actualizamos el estado del documento
            $oComprobante_Regula->estado_ID=91;
            $oComprobante_Regula->usuario_mod_id=$_SESSION['usuario_ID'];
            $oComprobante_Regula->actualizar();
            //$array_resultado_sunat=enviarComprobante_RegulaSUNAT($oComprobante_Regula->ID);
            
           
        }else{
            throw new Exception("La factura no se encuentra disponible.");
        }
        
    }catch(Exception $ex){
       $mensaje= $ex->getMessage();
       $resultado=-1;
    }
    
    
    $dtTipo=tipo::getGrid("tabla='nota_credito'",-1,-1,"orden asc");
    $dtMoneda=moneda::getGrid("",-1,-1,"descripcion asc");
    $oComprobante_Regula->dtSerie=correlativos::getGridCorrelativos("nota_debito",1);
    $oComprobante_Regula->fecha_emision=$fecha_emision1;
    $oComprobante_Regula->fecha_vencimiento=$fecha_vencimiento1;
    $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
    $GLOBALS['dtTipo']=$dtTipo;
    $GLOBALS['dtMoneda']=$dtMoneda;
    $GLOBALS['llave']=$identificador;
    $GLOBALS['tipo_cambio']=$oDatos_Generales->tipo_cambio;
    $GLOBALS['ob']=$oComprobante_Regula;
    $GLOBALS['resultado']=$resultado;
    $GLOBALS['mensaje']=$mensaje;
    
}
function get_Nota_Debito_Detalle($id){
    require ROOT_PATH.'models/tipo_impuestos.php';
    global  $returnView_float;
    $llave=$id;
    $returnView_float=true;
    $dtTipo_Impuestos=tipo_impuestos::getGrid();
    $GLOBALS['dtTipo_Impuestos']=$dtTipo_Impuestos;
    $GLOBALS['llave']=$llave;
}
function post_Nota_Debito_Detalle(){
    require ROOT_PATH.'models/comprobante_regula_detalle.php';
    global  $returnView_float;
    $returnView_float=true;
    $obj=new comprobante_regula_detalle();
    $llave=$_POST['llave'];
    $producto_ID=$_POST['txtProducto_ID'];
    $producto= FormatTextSave($_POST['listaProductos']);
    $descripcion=FormatTextSave($_POST['txtDescripcion']);
    $cantidad=$_POST['txtCantidad'];
    $precio_unitario=$_POST['txtValor_Unitario'];
    $subtotal=$_POST['txtSubTotal'];
    $total=$_POST['txtTotal'];
    //$porcentaje_descuento=$_POST['txtDescuento'];
    $tipo_impuestos_ID=$_POST['selTipo_Impuesto'];
    
    $igv=$_POST['txtIGV'];
    //$otros_cargos=$_POST['txtOtros_Cargos'];
    $total=$_POST['txtTotal'];
    
    $obj->producto_ID=$producto_ID;
    $obj->cantidad=$cantidad;
    $obj->precio_unitario=$precio_unitario;
    $obj->subtotal=$subtotal;
    $obj->total=$total;
    $obj->igv=$igv;
    $obj->tipo_impuestos_ID=$tipo_impuestos_ID;
    //$obj->porcentaje_descuento=$porcentaje_descuento;
    //$obj->otros_cargos=$otros_cargos;
    $obj->producto=$producto;
    $array=array(
        "factura_venta_detalle_ID"=>-1,
        "producto"=>$producto,
        "producto_ID"=>$producto_ID,
        "cantidad"=>$cantidad,
        "precio_unitario"=>$precio_unitario,
        "subtotal"=>$subtotal,
        "igv"=>$igv,
        "total"=>$total,
        "tipo_impuestos_ID"=>$tipo_impuestos_ID,
        "descripcion"=>$descripcion,
        "accion"=>"insertar",
        "estado_ID"=>90,//estado borrador
    );
    
    array_push($_SESSION[$llave],$array);

    $GLOBALS['obj']=$obj;
    $GLOBALS['resultado']=1;
    $GLOBALS['mensaje']="Se guardó correctamente";
   
}
function post_ajaxEnviarNota_DebitoSUNAT() {
    if(!class_exists("comprobante_regula")){
        require ROOT_PATH.'models/comprobante_regula.php';
    }
    $id=$_POST['id'];
    $resultado=0;
    try{
        $array=enviarComprobante_RegulaSUNAT($id);
        if($array['resultado_final']==1){
            $resultado=1; 
            $mensaje="La nota de débito se envió a la SUNAT.";
        }else{
            throw new exception($array['mensaje_final']);
        }
    }catch(Exception $ex){
        $resultado=-1;
        $mensaje=$ex->getMessage();
    }
    

    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
    echo json_encode($retornar);
}
function get_Comprobante_regula_Vista_Previa($id){
        require ROOT_PATH.'models/salida.php';
        require ROOT_PATH.'models/comprobante_regula.php';
        require ROOT_PATH.'models/correlativos.php';
        global $returnView_float;
        $returnView_float=true;
        $oComprobante_Regula=comprobante_regula::getByID($id);
        /*$osalida=salida::getByID($id);
        $dtFactura_Venta=factura_venta::getGrid("fv.salida_ID=".$id);
        $electronico=0;pro
        if(count($dtFactura_Venta)>0){
           $electronico=correlativos::verificar_electronico($dtFactura_Venta[0]['correlativos_ID']);
            $GLOBALS['factura_venta_ID']=$dtFactura_Venta[0]['ID'];
        }*/
        $GLOBALS['oComprobante_Regula']=$oComprobante_Regula;
        //$GLOBALS['electronico']=$electronico;
        
    }
    function get_Comprobante_RegulaPDF($id){
        require ROOT_PATH.'models/comprobante_regula.php';
        require ROOT_PATH.'models/comprobante_regula_detalle.php';
        require ROOT_PATH.'formatos_pdf/comprobante_regula.php';
        //global $returnView_float;
        $pdf= new PDF2('P','mm',array(216,279));
        try{
            
            $dtCabecera=comprobante_regula::getGridByID($id);
            $dtDetalle=comprobante_regula_detalle::getGrid($id);
            //$numero_cuenta=factura_venta::getComprobante_Electronico($id,"numero_cuenta");
            $pdf->AddPage();
            $pdf->cabecera=$dtCabecera;
            //$pdf->numero_cuenta=$numero_cuenta;
            $pdf->cabecera_header();
            $pdf->contenedor_detalle(130);
            //$dtFactura_Venta_Detalle1=factura_venta_detalle::getGrid1('fvd.factura_venta_ID='.$item['ID'],-1,-1,'ovd.ID asc');
            $pdf->SetWidths(array(20,15,15,100,25,25));
            $pdf->SetAligns(array('C','C','C','L','R','R'));
            $pdf->contenido_detalle($dtDetalle);

        }catch(Exception $ex){
            $GLOBALS['error']=$ex->getMessage();
        }

    $pdf->Output('I','Factura Nro'.sprintf("%'.07d",'5').'.pdf',true);
}
    //============================================
    //Ventas electrónicas
    function get_Orden_Venta_Electronico_Mantenimiento(){
        require ROOT_PATH.'models/estado.php';
        require ROOT_PATH.'models/moneda.php';
        require ROOT_PATH.'models/salida.php';
        require ROOT_PATH.'models/cliente.php';
        
        global $returnView;
        $returnView=true;
        
        $dtEstado=estado::getGrid('tabla="salida"');
        $dtMoneda=moneda::getGrid();
        $dtCliente=cliente::getGrid("",-1,-1,"clt.razon_social asc");
        
        $GLOBALS['dtEstado']=$dtEstado;
        $GLOBALS['dtMoneda']=$dtMoneda;
        $GLOBALS['dtPerido']=salida::getPeriodos();
        $GLOBALS['dtCliente']=$dtCliente;
        
    }
    function post_ajaxOrden_Venta_Electronico_Mantenimiento() {
        require ROOT_PATH.'models/salida.php';
        $cliente=$_POST['selCliente'];
        $periodo=$_POST['selPeriodo'];
        $fecha_inicio=FormatTextToDate($_POST['txtFechaInicio'],'Y-m-d');
        $fecha_fin=FormatTextToDate($_POST['txtFechaFin'],'Y-m-d');
        $estado_ID=$_POST['selEstado'];
        $moneda_ID=$_POST['selMoneda'];
        $periodo_texto=(trim($_POST['txtPeriodo'])=="")?0:trim($_POST['txtPeriodo']);
        $numero=(trim($_POST['txtNumero'])=="")?0:trim($_POST['txtNumero']);
        $numero_factura=(trim($_POST['txtNumero_Factura'])=="")?0:trim($_POST['txtNumero_Factura']);
        $opcion=$_POST['rbOpcion'];
        try{
            
            
           $dtSalida=salida::getTabla($opcion,$cliente,$periodo,$fecha_inicio,$fecha_fin,$estado_ID,$moneda_ID,$periodo_texto,$numero,$numero_factura,28);
           /*if(count($dtSalida)==0){
              $dtSalida=array();
            }*/
           echo(json_encode($dtSalida, JSON_NUMERIC_CHECK)); 
        }catch(Exception $ex){
            //echo mensaje_error;
            $error=array("error_sistema"=>utf8_encode(mensaje_error));
            echo(json_encode($error));
            log_error(__FILE__, "salidaController.post_ajaxOrden_Venta_Electronico_Mantenimiento", $ex->getMessage());
           
        }
    }
    function get_Orden_Venta_Electronico_Mantenimiento_Nuevo(){
        require ROOT_PATH.'models/salida.php';
        require ROOT_PATH.'models/moneda.php';
        require ROOT_PATH.'models/estado.php';
        require ROOT_PATH.'models/cliente.php';
        require ROOT_PATH.'models/operador.php';
        require ROOT_PATH.'models/datos_generales.php';
        require ROOT_PATH.'models/forma_pago.php';
        require ROOT_PATH.'models/credito.php';
        require ROOT_PATH.'models/cotizacion.php';
        require ROOT_PATH.'models/numero_cuenta.php';
        require ROOT_PATH.'models/factura_venta.php';
        require ROOT_PATH.'controls/funcionController.php';
        global  $returnView_float;
        $returnView_float=true;
        $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
        $mensaje="";
        $factura_venta_ID_emitida=0;
          
        $osalida=new salida();
        $osalida->ID=0;
        $osalida->garantia=  "1 año";
        $osalida->validez_oferta=7;
        $osalida->moneda_ID=2;
        $osalida->ver_adicional=1;
        $osalida->adicional="Nueva Central Telefónica ".$oDatos_Generales->telefono;
        $osalida->tipo_cambio=$oDatos_Generales->tipo_cambio;
        $osalida->cotizacion_ID=-1;
        $osalida->ver_factura=0;
        $osalida->ver_guia=0;
        $osalida->impresion=0;
        $oCliente=new cliente();
        //$dtCliente=cliente::getGrid("",-1,-1,"clt.razon_social asc");
        $oOperador=new operador();
        $dtForma_Pago=forma_pago::getGrid();
        $dtCredito=credito::getGrid('id<>0');
        $oNumero_Cuenta=numero_cuenta::getByID(1);
        $dtEstado=estado::getGrid('est.tabla="cotizacion"');
        $oCotizacion=new cotizacion();
        $GLOBALS['oOrden_Venta']=$osalida;
        $GLOBALS['oCliente']=$oCliente;
        
        $GLOBALS['dtNumero_Cuenta']=mostrarNumeroCuentas(1,$osalida->moneda_ID,null,null);
        $GLOBALS['dtCredito']=$dtCredito;
        $GLOBALS['oOperador']=$oOperador;
        $GLOBALS['oDatos_Generales']=$oDatos_Generales;
        $GLOBALS['dtForma_Pago']=$dtForma_Pago;
        $GLOBALS['dtEstado']=$dtEstado;
        $GLOBALS['oNumero_Cuenta']=$oNumero_Cuenta;
        $GLOBALS['dtMoneda']=moneda::getGrid();
        $GLOBALS['oCotizacion']=$oCotizacion;
        $GLOBALS['factura_venta_ID_emitida']=$factura_venta_ID_emitida;
        $GLOBALS['mensaje']=$mensaje;
    }
    function post_Orden_Venta_Electronico_Mantenimiento_Nuevo(){
        require ROOT_PATH.'models/salida.php';
        require ROOT_PATH.'models/salida_detalle.php';
        require ROOT_PATH.'models/moneda.php';
        require ROOT_PATH.'models/estado.php';
        require ROOT_PATH.'models/cliente.php';
        require ROOT_PATH.'models/cliente_contacto.php';
        require ROOT_PATH.'models/operador.php';
        require ROOT_PATH.'models/datos_generales.php';
        require ROOT_PATH.'models/forma_pago.php';
        require ROOT_PATH.'models/credito.php';
        require ROOT_PATH.'models/cotizacion.php';
        require ROOT_PATH.'models/numero_cuenta.php';
        require ROOT_PATH.'models/salida_numero_cuenta.php';
        require ROOT_PATH.'models/factura_venta.php';
        require ROOT_PATH.'controls/funcionController.php';
        global  $returnView_float;
        $returnView_float=true;
        $id=$_POST['txtID'];
        $cliente_ID=$_POST['selCliente'];
        $numero_orden_compra=$_POST['txtNumero_Orden_Compra'];
        $cliente_contacto_ID=isset($_POST['selRepresentante'])?$_POST['selRepresentante']:0;
        $moneda_ID=$_POST['cboMoneda'];
        $tipo_cambio=$_POST['txtTipo_Cambio'];
        $plazo_entrega=$_POST['txtPlazo_Entrega'];
        $forma_pago_ID=$_POST['selForma_Pago'];
        $tiempo_credito=$_POST['selTiempo_Credito'];
        $fecha=$_POST['txtFecha'];
        $operador_ID=$_POST['txtOperador_ID'];
        $lugar_entrega=$_POST['txtLugar_Entrega'];
        $validez_oferta=$_POST['txtValidez_Oferta'];
        $garantia=  $_POST['txtGarantia'];
        $observacion=$_POST['txtObservacion'];
        $ver_adicional=0;
        if(isset($_POST['ckVer_Adicional'])){
            $ver_adicional=$_POST['ckVer_Adicional'];
        }
        $cadena_numero_cuenta=$_POST['txtCadena_Numero_Cuenta'];
        $adicional=$_POST['txtAdicional'];
        try{
            $factura_venta_ID_emitida=0;
            $dtFactura_Venta=factura_venta::getGrid2("fv.estado_ID=94 and fv.salida_ID=".$id,-1,-1,"fv.ID desc");
            if(count($dtFactura_Venta)>0){
                $factura_venta_ID_emitida=$dtFactura_Venta[0]['ID'];
            } 
            $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
            if($id>0){
                $osalida=salida::getByID($id);
                actualizar_costos_salida_detalle($osalida,$tipo_cambio);
                $osalida->numero_orden_compra=$numero_orden_compra;
                $osalida->cliente_contacto_ID=$cliente_contacto_ID;
                $osalida->moneda_ID=$moneda_ID;
                $osalida->tipo_cambio=$tipo_cambio;
                $osalida->plazo_entrega=$plazo_entrega;
                $osalida->forma_pago_ID=$forma_pago_ID;
                $osalida->tiempo_credito=$tiempo_credito;
                $osalida->fecha=$fecha;
                $osalida->lugar_entrega=$lugar_entrega;
                $osalida->validez_oferta=$validez_oferta;
                $osalida->garantia=$garantia;
                $osalida->observacion=$observacion;
                $osalida->ver_adicional=$ver_adicional;
                $osalida->adicional=$adicional;
                $osalida->usuario_mod_id=$_SESSION['usuario_ID'];

                $osalida->actualizar_new();

                if($osalida->estado_ID==28){
                    $Cliente_ID=$osalida->cliente_ID;
                    //$resultado=3;
                }else if($osalida->estado_ID==42){
                    //$resultado=2;
                    $mensaje="No se puede modificar la orden de venta, los comprobantes ya fueron remitidos.";
                }

                $resultado=1;
                $mensaje="Se guardó correctamente";
            }else if($id==0){
                $osalida=new salida();
                $osalida->cotizacion_ID=-1;
                $osalida->cliente_ID=$cliente_ID;
                $osalida->cliente_contacto_ID=$cliente_contacto_ID;
                $osalida->operador_ID=$operador_ID;
                $osalida->periodo=date("Y");
                $osalida->numero=salida::getNumero();//tipo 28, el tipo de comprobante electrónico.
                $numero_ceros=sprintf("%'.07d", $osalida->numero);
                $numero_concatenado=$numero_ceros.'-'.$osalida->periodo;
                $osalida->numero_concatenado=$numero_concatenado;
                $osalida->numero_orden_compra=$numero_orden_compra;
                $osalida->moneda_ID=$moneda_ID;
                $osalida->fecha=$fecha;
                $osalida->igv=$oDatos_Generales->vigv;
                $osalida->vigv_soles=0;
                $osalida->vigv_dolares=0;
                $osalida->precio_venta_neto_soles=0;
                $osalida->precio_venta_total_soles=0;
                $osalida->precio_venta_neto_dolares=0;
                $osalida->precio_venta_total_dolares=0;
                $osalida->forma_pago_ID=$forma_pago_ID;
                $osalida->tiempo_credito=$tiempo_credito;
                $osalida->descuento_soles=0;
                $osalida->descuento_dolares=0;
                $osalida->estado_ID=29;
                $osalida->tipo_cambio=$tipo_cambio;
                $osalida->plazo_entrega=$plazo_entrega;
                $osalida->lugar_entrega=$lugar_entrega;
                $osalida->validez_oferta=$validez_oferta;
                $osalida->garantia=$garantia;
                $osalida->observacion=$observacion;
                $osalida->numero_pagina="1";
                $osalida->nproducto_pagina="";
                $osalida->usuario_id=$_SESSION['usuario_ID'];
                $osalida->ver_adicional=$ver_adicional;
                $osalida->adicional=$adicional;
                $osalida->tipo_ID=28;
                $osalida->cadena_numero_cuenta=$cadena_numero_cuenta;
                $osalida->insertar_new();
                $mensaje="Se guardó correctamente";
                $resultado=1;
            }
          
        }

        catch (Exception $ex){
            $resultado=-1;
            $mensaje=$ex->getMessage();
        }
        $contar_hijo=salida_detalle::getCount('salida_ID='.$id);
        if($contar_hijo>0){
            $osalida->ver_factura=1;
            $contador_factura=factura_venta::getCount('salida_ID='.$id.' and estado_ID in (35,41,53,60)');
            if($contador_factura>0){
                $osalida->ver_guia=1;
            }else {
                $osalida->ver_guia=0;
            }

        }else {
            $osalida->ver_factura=0;
            $osalida->ver_guia=0;
        }
        $dtCliente_Contacto=cliente_contacto::getGrid('clic.cliente_ID='.$cliente_ID);
        $GLOBALS['dtCliente_Contacto']=$dtCliente_Contacto;
        $oCliente=cliente::getByID($cliente_ID);
        //$dtCliente=cliente::getGrid("",-1,-1,"clt.razon_social asc");
        $oOperador=operador::getByID($osalida->operador_ID);
        $dtForma_Pago=forma_pago::getGrid();
        $dtCredito=credito::getGrid('id<>0');
        $oNumero_Cuenta=numero_cuenta::getByID(1);
        $dtEstado=estado::getGrid('est.tabla="cotizacion"');
        if($osalida->cotizacion_ID=="NULL"){
            $oCotizacion=new cotizacion();
        }else {
            $oCotizacion=cotizacion::getByID($osalida->cotizacion_ID);
        }
        $oFactura_Venta=new factura_venta();
        $oFactura_Venta->ID=0;
        $GLOBALS['dtNumero_Cuenta']=mostrarNumeroCuentas(2,$osalida->moneda_ID,null,$osalida);
        $GLOBALS['oOrden_Venta']=$osalida;
        $GLOBALS['oFactura_Venta']=$oFactura_Venta;
        //$GLOBALS['dtCliente']=$dtCliente;
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
        $GLOBALS['factura_venta_ID_emitida']=$factura_venta_ID_emitida;
    }
    
    function get_Orden_Venta_Electronico_Mantenimiento_Editar($id){
        require ROOT_PATH.'models/salida.php';
        require ROOT_PATH.'models/salida_detalle.php';
        require ROOT_PATH.'models/moneda.php';
        require ROOT_PATH.'models/estado.php';
        require ROOT_PATH.'models/cliente.php';
        require ROOT_PATH.'models/cliente_contacto.php';
        require ROOT_PATH.'models/operador.php';
        require ROOT_PATH.'models/datos_generales.php';
        require ROOT_PATH.'models/forma_pago.php';
        require ROOT_PATH.'models/credito.php';
        require ROOT_PATH.'models/cotizacion.php';
        require ROOT_PATH.'models/numero_cuenta.php';
        require ROOT_PATH.'models/factura_venta.php';
        require ROOT_PATH.'controls/funcionController.php';
        global  $returnView_float;
        $returnView_float=true;
        $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
        $mensaje="";

        $osalida=salida::getByID($id);
        $contar_hijo=salida_detalle::getCount('salida_ID='.$id);
        $factura_venta_ID_emitida=0;
        $dtFactura_Venta=factura_venta::getGrid2("fv.estado_ID=94 and fv.salida_ID=".$id,-1,-1,"fv.ID desc");
        if(count($dtFactura_Venta)>0){
            $factura_venta_ID_emitida=$dtFactura_Venta[0]['ID'];
        }
        /*if($contar_hijo>0){
            $osalida->ver_factura=1;
            $contador_factura=factura_venta::getCount('salida_ID='.$id.' and estado_ID in (35,41,53,60,93,94,95,96)');
            if($contador_factura>0){
                $osalida->ver_guia=1;
            }else {
                $osalida->ver_guia=0;
            }

        }else {
            $osalida->ver_factura=0;
            $osalida->ver_guia=0;
        }*/

        $oCliente=cliente::getByID($osalida->cliente_ID);
        $oOperador=operador::getByID($osalida->operador_ID);
        $dtForma_Pago=forma_pago::getGrid();
        $dtCredito=credito::getGrid('id<>0');
        $oNumero_Cuenta=numero_cuenta::getByID(1);
        $dtEstado=estado::getGrid('est.tabla="salida"');
        $osalida->dtRepresentante_Cliente=cliente_contacto::getGrid('clic.cliente_ID='.$osalida->cliente_ID,-1,-1,'pe.apellido_paterno asc,pe.apellido_paterno asc, pe.nombres asc');
        $osalida->bloquear_edicion=factura_venta::getCount('salida_ID='.$id.' and estado_ID in (41,93,94)');
        $GLOBALS['oOrden_Venta']=$osalida;
        $dtCliente=cliente::getGrid("",-1,-1,"clt.razon_social asc");
        $GLOBALS['oCliente']=$oCliente;
        $GLOBALS['dtCliente']=$dtCliente;
        $GLOBALS['dtNumero_Cuenta']=mostrarNumeroCuentas(2,$osalida->moneda_ID,null,$osalida);
        $GLOBALS['dtCredito']=$dtCredito;
        $GLOBALS['oOperador']=$oOperador;
        $GLOBALS['oDatos_Generales']=$oDatos_Generales;
        $GLOBALS['dtForma_Pago']=$dtForma_Pago;
        $GLOBALS['dtEstado']=$dtEstado;
        $GLOBALS['oNumero_Cuenta']=$oNumero_Cuenta;
        $GLOBALS['dtMoneda']=moneda::getGrid();
        $GLOBALS['factura_venta_ID_emitida']=$factura_venta_ID_emitida;


        $GLOBALS['mensaje']=$mensaje;
    }
    function post_Orden_Venta_Electronico_Mantenimiento_Editar($id){
        require ROOT_PATH.'models/salida.php';
        require ROOT_PATH.'models/salida_detalle.php';
        require ROOT_PATH.'models/moneda.php';
        require ROOT_PATH.'models/estado.php';
        require ROOT_PATH.'models/cliente.php';
        require ROOT_PATH.'models/cliente_contacto.php';
        require ROOT_PATH.'models/operador.php';
        require ROOT_PATH.'models/datos_generales.php';
        require ROOT_PATH.'models/forma_pago.php';
        require ROOT_PATH.'models/credito.php';
        require ROOT_PATH.'models/cotizacion.php';
        require ROOT_PATH.'models/numero_cuenta.php';
        require ROOT_PATH.'models/salida_numero_cuenta.php';
        require ROOT_PATH.'models/factura_venta.php';
        require ROOT_PATH.'controls/funcionController.php';
        global  $returnView_float;
        $returnView_float=true;

        if(isset($_POST['selCliente'])){
            $cliente_ID=$_POST['selCliente'];
        }else{$cliente_ID=0;}
        $numero_orden_compra=$_POST['txtNumero_Orden_Compra'];
        $cliente_contacto_ID=0;
        if(isset($_POST['selRepresentante'])){
            $cliente_contacto_ID= $_POST['selRepresentante'];
        }

        $moneda_ID=$_POST['cboMoneda'];
        $tipo_cambio=$_POST['txtTipo_Cambio'];
        $plazo_entrega=$_POST['txtPlazo_Entrega'];
        $forma_pago_ID=$_POST['selForma_Pago'];
        $tiempo_credito=$_POST['selTiempo_Credito'];
        $fecha=$_POST['txtFecha'];
        $operador_ID=$_POST['txtOperador_ID'];
        $lugar_entrega=$_POST['txtLugar_Entrega'];
        $validez_oferta=$_POST['txtValidez_Oferta'];
        $garantia= $_POST['txtGarantia'];
        $observacion=$_POST['txtObservacion'];
        $gravadas=$_POST['gravadas'];
        
        $inafectas=$_POST['inafectas'];
        $exoneradas=$_POST['exoneradas'];
        $vigv_soles=$_POST['vigv_soles'];
        $vigv_dolares=$_POST['vigv_dolares'];
        $precio_venta_total_soles=$_POST['precio_venta_total_soles'];
        $precio_venta_total_dolares=$_POST['precio_venta_total_dolares'];
        $otros_cargos=$_POST['txtOtros_Cargos'];
        $porcentaje_descuento=$_POST['txtPorcentaje_Descuento'];
        $descuento_global=$_POST['txtDescuento_Global'];
        
        $ver_adicional=0;
        if(isset($_POST['ckVer_Adicional'])){
            $ver_adicional=$_POST['ckVer_Adicional'];
        }
        $cadena_numero_cuenta=$_POST['txtCadena_Numero_Cuenta'];
        $adicional=$_POST['txtAdicional'];
        try{
            $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
            $osalida=salida::getByID($id);
            actualizar_costos_salida_detalle($osalida,$tipo_cambio);
            $osalida->cliente_ID=$cliente_ID;
            $osalida->numero_orden_compra=$numero_orden_compra;
            $osalida->cliente_contacto_ID=$cliente_contacto_ID;
            $osalida->moneda_ID=$moneda_ID;
            $osalida->tipo_cambio=$tipo_cambio;
            $osalida->plazo_entrega=$plazo_entrega;
            $osalida->forma_pago_ID=$forma_pago_ID;
            $osalida->tiempo_credito=$tiempo_credito;
            $osalida->fecha=$fecha;
            $osalida->lugar_entrega=$lugar_entrega;
            $osalida->validez_oferta=$validez_oferta;
            $osalida->garantia=$garantia;
            $osalida->observacion=$observacion;
            $osalida->ver_adicional=$ver_adicional;
            $osalida->adicional=$adicional;
            
            $osalida->cadena_numero_cuenta=$cadena_numero_cuenta;
            $osalida->gravadas=$gravadas;
            $osalida->inafectas=$inafectas;
            $osalida->exoneradas=$exoneradas;
            $osalida->vigv_soles=$vigv_soles;
            $osalida->vigv_dolares=$vigv_dolares;
            $osalida->precio_venta_total_soles=$precio_venta_total_soles;
            $osalida->precio_venta_total_dolares=$precio_venta_total_dolares;
            $osalida->otros_cargos=$otros_cargos;
            $osalida->porcentaje_descuento=$porcentaje_descuento;
            $osalida->descuento_global=$descuento_global;
            
            $osalida->usuario_mod_id=$_SESSION['usuario_ID'];
            if($osalida->estado_ID!=40){
                $osalida->actualizar_new();
                           
                
                $resultado=1;
                $mensaje=$osalida->getMessage;
            }else {
                $resultado=-1;
                $mensaje="No se puede modificar la orden de venta, los comprobantes ya fueron remitidos.";
            }



        }

        catch (Exception $ex){
            $resultado=-1;
            $mensaje="Ocurrió un error en el sistema.";
            log_error(__FILE__,"post_Orden_Venta_Electronico_Mantenimiento_Editar",$ex->getMessage());
        }
        $osalida->dtRepresentante_Cliente=cliente_contacto::getGrid('clic.cliente_ID='.$cliente_ID);
        $contar_hijo=salida_detalle::getCount('salida_ID='.$id);
        if($contar_hijo>0){
            $osalida->ver_factura=1;
            $contador_factura=factura_venta::getCount('salida_ID='.$id.' and estado_ID in (35,41,53,60)');
            if($contador_factura>0){
                $osalida->ver_guia=1;
            }else {
                $osalida->ver_guia=0;
            }

        }else {
            $osalida->ver_factura=0;
            $osalida->ver_guia=0;
        }
       $dtFactura_Venta=factura_venta::getGrid2("fv.estado_ID=94 and fv.salida_ID=".$id,-1,-1,"fv.ID desc");
        if(count($dtFactura_Venta)>0){
            $factura_venta_ID_emitida=$dtFactura_Venta[0]['ID'];
        }
        $oCliente=cliente::getByID($osalida->cliente_ID);
        $oOperador=operador::getByID($osalida->operador_ID);
        $dtForma_Pago=forma_pago::getGrid();
        $dtCredito=credito::getGrid('id<>0');
        $oNumero_Cuenta=numero_cuenta::getByID(1);
        //$dtEstado=estado::getGrid('est.tabla="salida"');
        if($osalida->cotizacion_ID=="NULL" ||$osalida->cotizacion_ID==-1){
            $oCotizacion=new cotizacion();
        }else {
            $oCotizacion=cotizacion::getByID($osalida->cotizacion_ID);
        }
        $dtCliente=cliente::getGrid("",-1,-1,"clt.razon_social asc");$dtCliente=cliente::getGrid("",-1,-1,"clt.razon_social asc");
        //$oFactura_Venta=new factura_venta();
        //$oFactura_Venta->ID=0;
        $GLOBALS['dtNumero_Cuenta']=mostrarNumeroCuentas(2,$osalida->moneda_ID,null,$osalida);
        $GLOBALS['oOrden_Venta']=$osalida;
        //$GLOBALS['oFactura_Venta']=$oFactura_Venta;
        $GLOBALS['oCliente']=$oCliente;
        $GLOBALS['dtCliente']=$dtCliente;
        $GLOBALS['oCotizacion']=$oCotizacion;
        $GLOBALS['dtCredito']=$dtCredito;
        $GLOBALS['oOperador']=$oOperador;
        $GLOBALS['oDatos_Generales']=$oDatos_Generales;
        $GLOBALS['dtForma_Pago']=$dtForma_Pago;
        //$GLOBALS['dtEstado']=$dtEstado;
        $GLOBALS['oNumero_Cuenta']=$oNumero_Cuenta;
        $GLOBALS['dtMoneda']=moneda::getGrid('',-1,-1,'ID desc');
        $GLOBALS['factura_venta_ID_emitida']=$factura_venta_ID_emitida;
        $GLOBALS['resultado']=$resultado;
        $GLOBALS['mensaje']=$mensaje;
    }
    function get_Orden_Venta_Electronico_Mantenimiento_Comprobante_Nuevo($id){
        require ROOT_PATH . 'models/salida.php';
        require ROOT_PATH . 'models/salida_detalle.php';
        require ROOT_PATH . 'models/factura_venta.php';
        require ROOT_PATH . 'models/correlativos.php';
        require ROOT_PATH . 'models/impuestos_tipo.php';
        require ROOT_PATH . 'models/moneda.php';
        require ROOT_PATH . 'models/tipo_comprobante.php';
        
        global  $returnView_float;
        $returnView_float=true;
        $oSalida=salida::getByID($id);
        
        //$salida_ID=814;
        //echo $id;
        $listaproducto="";
        $oFactura_Venta=new factura_venta();
        try{
            $contar_producto=salida_detalle::getCount("salida_ID=".$id." and tipo_ID in (1,2,5,6)");
            if($contar_producto==0){
                $GLOBALS["resultado"]=-2;
                $GLOBALS["mensaje"]="No ha registrado ningún producto.";
                throw new Exception("No ha registrado ningún producto.");
            }
            $Facturas_Generadas=factura_venta::getCount("salida_ID=".$id." and estado_ID not in(95,107) and ID in (select max(ID) from factura_venta where salida_ID=".$id."))");
            
            if($Facturas_Generadas>0){
                $GLOBALS["resultado"]=-2;
                $GLOBALS["mensaje"]="La venta ya tiene una factura generada.";
                throw new Exception("La venta ya tiene una factura generada.");
            }
            $oFactura_Venta->comprobante="factura_venta";
            $dtImpuestos_Tipo=impuestos_tipo::getGrid();
            
            $oFactura_Venta->fecha_emision=date("d/m/Y");
            $oFactura_Venta->fecha_vencimiento=date("d/m/Y");
            $oFactura_Venta->moneda_ID=$oSalida->moneda_ID;
            $numero_temporal=correlativos::getNumero(correlativos_ID);
            
            $oFactura_Venta->numero=$numero_temporal;
            $numero_concatenado=sprintf("%'.07d",$numero_temporal);
            $oFactura_Venta->numero_concatenado=$numero_concatenado;
           
            $oFactura_Venta->dtImpuestos_Tipo=$dtImpuestos_Tipo;
            $oFactura_Venta->correlativos_ID=correlativos_ID;
            $oFactura_Venta->numero_orden_venta=$oSalida->numero_concatenado;
            $oFactura_Venta->numero_orden_compra=$oSalida->numero_orden_compra;
            $oFactura_Venta->gravadas=$oSalida->gravadas;
            $oFactura_Venta->anticipos=$oSalida->anticipos;
            $oFactura_Venta->gratuitas=$oSalida->gratuitas;
            $oFactura_Venta->inafectas=$oSalida->inafectas;
            $oFactura_Venta->exoneradas=$oSalida->exoneradas;
            $oFactura_Venta->descuento_total_items=($oSalida->moneda_ID==1)?$oSalida->descuento_item_soles:$oSalida->descuento_item_dolares;
            $oFactura_Venta->descuento_global=$oSalida->descuento_global;
            $oFactura_Venta->porcentaje_descuento=$oSalida->porcentaje_descuento;
            $oFactura_Venta->otros_cargos=$oSalida->otros_cargos;
            $oFactura_Venta->monto_total=($oSalida->moneda_ID==1)?$oSalida->precio_venta_total_soles:$oSalida->precio_venta_total_dolares;
            $oFactura_Venta->monto_total_igv=($oSalida->moneda_ID==1)?$oSalida->vigv_soles:$oSalida->vigv_dolares;
            
            $dtMoneda=moneda::getGrid();
            $oFactura_Venta->dtMoneda=$dtMoneda;
            $oFactura_Venta->dtTipo_Comprobante=tipo_comprobante::getComprobantes(1, "venta", correlativos_ID,0,"tipo_comprobantes");
            $oFactura_Venta->dtSerie=tipo_comprobante::getComprobantes(1, "venta", correlativos_ID,0,"series");
            
        //$listaproducto=salida_detalle::getFilasDetalleComprobante(814);
        }catch(Exception $ex){
            
            log_error(__FILE__,"salidaController.get_Orden_Venta_Electronico_Mantenimiento_Comprobante_Nuevo",$ex->getMessage());
        }
        
        
        $GLOBALS['oFactura_Venta']=$oFactura_Venta;
        //$GLOBALS['listaproducto']=$listaproducto;
        $GLOBALS['oOrden_Venta']=$oSalida;
    }

    function post_Orden_Venta_Electronico_Mantenimiento_Comprobante_Nuevo($id){
        require ROOT_PATH . 'models/salida.php';
        //require ROOT_PATH . 'models/salida_detalle.php';
        require ROOT_PATH . 'models/factura_venta.php';
        require ROOT_PATH . 'models/correlativos.php';
        require ROOT_PATH . 'models/impuestos_tipo.php';
        require ROOT_PATH . 'models/moneda.php';
        require ROOT_PATH . 'models/tabla_movimiento.php';
        require ROOT_PATH . 'models/factura_venta_detalle.php';
        require ROOT_PATH . 'models/tipo_comprobante.php';
        
        global  $returnView_float;
        $returnView_float=true;
        $salida_ID=$id;
        $comprobante=$_POST['selTipoComprobante'];
        $opcion=0;
        if(isset($_POST['ckOpcion'])){
            $opcion=$_POST['ckOpcion'];
        }
        
        $correlativos_ID=$_POST['selSerie'];
        $Fecha_Emision=$_POST['txtFecha_Emision'];
        $Plazo_Factura=$_POST['txtPlazo_Factura'];
        $Fecha_Vencimiento=$_POST['txtFecha_Vencimiento'];
        $moneda_ID=$_POST['selMoneda'];
        $numero_orden_compra=$_POST['txtNumero_Orden_Compra'];
        $numero_orden_venta= $_POST['txtNumero_Orden_Venta'];
        //$impuestos_tipo_ID=$_POST['selImpuestos_Tipo'];
        $ver_descripcion=(isset($_POST['ckver_descripcion']))?1:0;
        $ver_componente=(isset($_POST['ckver_componente']))?1:0;
        $ver_adicional=(isset($_POST['ckver_descripcion']))?1:0;
        $ver_serie=(isset($_POST['ckver_serie']))?1:0;
        $incluir_obsequios=(isset($_POST['ckincluir_obsequios']))?1:0;
        $porcentaje_descuento=$_POST['txtPorcentaje_Descuento'];
        $anticipos=$_POST['txtAnticipos'];
        $exoneradas=$_POST['txtExoneradas'];
        $inafectas=$_POST['txtInafectas'];
        $gravadas=$_POST['txtGravadas'];
        $monto_total_igv=$_POST['txtTotal_IGV'];
        $gratuitas=$_POST['txtGratuitas'];
        $otros_cargos=$_POST['txtOtros_Cargos'];
        $descuento_total_items=$_POST['txtDescuento_Total_Items'];
        $descuento_global=$_POST['txtDescuento_Global'];
        $monto_total=$_POST['txtMonto_Total'];
        $estado_ID=isset($_POST['ckGenerar'])?93:35;
        $con_guia=isset($_POST['ckCon_Guia'])?1:0;
        $observacion=$_POST['txtObservacion'];
        $oFactura_Venta=new factura_venta();
        try{
            $oCorrelativos=correlativos::getByID($correlativos_ID);
            $numero=correlativos::getNumero($correlativos_ID);
            $oSalida=salida::getByID($salida_ID);
            $oFactura_Venta->salida_ID=$salida_ID;
            $oFactura_Venta->serie=$oCorrelativos->serie;
            $oFactura_Venta->numero=$numero;
            $numero_concatenado=sprintf("%'.07d",$numero);
            $oFactura_Venta->numero_concatenado=$numero_concatenado;
            $oFactura_Venta->fecha_emision=$Fecha_Emision;
            $oFactura_Venta->forma_pago_ID=$oSalida->forma_pago_ID;
            $oFactura_Venta->plazo_factura=$Plazo_Factura;
            $oFactura_Venta->fecha_vencimiento=$Fecha_Vencimiento;
            //Generamos la factura en estado registrado
            $oFactura_Venta->con_guia=$con_guia;
            $oFactura_Venta->estado_ID=$estado_ID;//Estado Registrado
            $oFactura_Venta->observacion=$observacion;
            $oFactura_Venta->moneda_ID=$moneda_ID;
            $oFactura_Venta->numero_orden_venta=$numero_orden_venta;
            $oFactura_Venta->numero_orden_compra=$numero_orden_compra;
            $oFactura_Venta->monto_total_neto=$gravadas-$descuento_global;
            $oFactura_Venta->monto_total_igv=$monto_total_igv;
            $oFactura_Venta->monto_total=$monto_total;
            //$oFactura_Venta->impuestos_tipo_ID=$impuestos_tipo_ID;
            $oFactura_Venta->correlativos_ID=$correlativos_ID;
            $oFactura_Venta->gravadas=$gravadas;
            $oFactura_Venta->anticipos=$anticipos;
            $oFactura_Venta->gratuitas=$gratuitas;
            $oFactura_Venta->inafectas=$inafectas;
            $oFactura_Venta->exoneradas=$exoneradas;
            $oFactura_Venta->descuento_total_items=$descuento_total_items;
            $oFactura_Venta->descuento_global=$descuento_global;
            $oFactura_Venta->porcentaje_descuento=$porcentaje_descuento;
            $oFactura_Venta->otros_cargos=$otros_cargos;
            $oFactura_Venta->ver_descripcion=$ver_descripcion;
            $oFactura_Venta->ver_componente=$ver_componente;
            $oFactura_Venta->ver_adicional=$ver_adicional;
            $oFactura_Venta->ver_serie=$ver_serie;
            $oFactura_Venta->incluir_obsequios=$incluir_obsequios;
            $oFactura_Venta->usuario_id=$_SESSION['usuario_ID'];
            
            $ID=$oFactura_Venta->insertar();
            if($ID>0){
                $oTabla_Movimiento=new tabla_movimiento();
                $oTabla_Movimiento->tabla_ID=$ID;
                $oTabla_Movimiento->tabla="factura_venta";
                $oTabla_Movimiento->estado_ID=$estado_ID;
                $oTabla_Movimiento->fecha=date('Y-m-d H:i:s');
                $oTabla_Movimiento->observacion="Factura electrónica.";
                $oTabla_Movimiento->usuario_ID_creacion=$_SESSION['usuario_ID'];
                $oTabla_Movimiento->empresa_ID=$_SESSION['empresa_ID'];
                $oTabla_Movimiento->usuario_id=$_SESSION['usuario_ID'];
                $oTabla_Movimiento->insertar();
                //Insertamos los detalles de la factura
                $oFactura_Venta_Detalle=new factura_venta_detalle();
                $oFactura_Venta_Detalle->factura_venta_ID=$ID;
                $oFactura_Venta_Detalle->salida_ID=$salida_ID;
                $oFactura_Venta_Detalle->ver_descripcion=$ver_descripcion;
                $oFactura_Venta_Detalle->ver_componente=$ver_componente;
                $oFactura_Venta_Detalle->ver_adicional=$ver_adicional;
                $oFactura_Venta_Detalle->ver_serie=$ver_serie;
                $oFactura_Venta_Detalle->incluir_obsequios=$incluir_obsequios;
                $oFactura_Venta_Detalle->usuario_id=$_SESSION['usuario_ID'];
                $oFactura_Venta_Detalle->insertar_todos();
                /*if($oFactura_Venta->estado_ID==93){
                    //$oCorrelativos=correlativos::getByID($correlativos_ID);
                    $oCorrelativos->ultimo_numero=$numero;
                    $oCorrelativos->usuario_mod_id=$_SESSION['usuario_ID'];
                    $oCorrelativos->actualizar();
                }*/
            }
             $dtMoneda=moneda::getGrid();
            $oFactura_Venta->dtMoneda=$dtMoneda;
            $oFactura_Venta->dtTipo_Comprobante=tipo_comprobante::getComprobantes(1, "venta", $oFactura_Venta->correlativos_ID,0,"tipo_comprobantes");
            $oFactura_Venta->dtSerie=tipo_comprobante::getComprobantes(1, "venta", $oFactura_Venta->correlativos_ID,0,"series");
            
            //Creamos nueva factura para los anulados
            $mensaje=$oFactura_Venta->getMessage;
            $resultado=1;
        }catch(Exception $ex){
          $resultado=-1;
          $mensaje="Ocurrió un error en el sistema";
          log_error(__FILE__, "salidaController.post_Orden_Venta_Electronico_Mantenimiento_Comprobante", $ex->getMessage());
        }
        $GLOBALS['oFactura_Venta']=$oFactura_Venta;
        $GLOBALS['oOrden_Venta']=$oSalida;
        $GLOBALS['resultado']=$resultado;
        $GLOBALS['mensaje']=$mensaje;
    }
    function post_ajaxCargarDetalle_Comprobante(){
        require ROOT_PATH.'models/salida_detalle.php';
        $salida_ID=$_POST['txtSalida_ID'];
        $ver_descripcion=$_POST['ver_descripcion'];
        $ver_componente=$_POST['ver_componente'];
        $ver_adicional=$_POST['ver_adicional'];
        $ver_serie=$_POST['ver_serie'];
        $incluir_obsequios=$_POST['incluir_obsequios'];
        $html="";

        try{
            $dt= salida_detalle::getFilasDetalleComprobante($salida_ID,$ver_descripcion,$ver_componente,$ver_adicional,$ver_serie,$incluir_obsequios);
            $html=saltoLineHtml(utf8_encode($dt[0]["filas"]));
      
        }
        catch(Exception $ex){
            
            log_error(__FILE__,"salidaController.post_ajaxCargarDetalle_Comprobante",$ex->getMessage());
            $html.="Ocurrió un error en el sistema";

        }
        $retornar=Array('html'=>$html);
        echo json_encode($retornar);
        
        
       
    }
    function post_ajaxVistaPrevia_Comprobante_Electronico(){
         require ROOT_PATH.'models/factura_venta.php';
        require ROOT_PATH.'formatos_pdf/factura_venta_pdf_vistaprevia.php';
        
        $id=$_POST['txtSalida_ID'];
        
        $comprobante=$_POST['selTipoComprobante'];
        $serie=$_POST['serie'];
        $numero=$_POST['txtNumero'];
        $fecha_emision=$_POST['txtFecha_Emision'];
        $fecha_vencimiento=$_POST['txtFecha_Vencimiento'];
        $numero_orden_venta=$_POST['txtNumero_Orden_Venta'];
        $numero_orden_compra=$_POST['txtNumero_Orden_Compra'];
        $ver_descripcion=(isset($_POST['ckver_descripcion']))? 1:0;
        $ver_componente=(isset($_POST['ckver_componente']))? 1:0;
        $ver_adicional=(isset($_POST['ckver_descripcion']))? 1:0;
        $ver_serie=(isset($_POST['ckver_serie']))? $_POST['ckver_serie']:0;
        $incluir_obsequios=(isset($_POST['ckincluir_obsequios']))? $_POST['ckincluir_obsequios']:0;
        $igv=$_POST['txtTotal_IGV'];
        $subtotal=$_POST['txtGravadas'];
        $total=$_POST['txtMonto_Total'];
        $ruta="";
        try{
            $array=array(
                "isalida_ID"=>$id,
                "comprobante"=>$comprobante,
                "iserie"=>$serie,
                "inumero"=>$numero,
                "ifecha_emision"=>$fecha_emision,
                "ifecha_vencimiento"=>$fecha_vencimiento,
                "inumero_orden_venta"=>$numero_orden_venta,
                "inumero_orden_compra"=>$numero_orden_compra,
                "iver_descripcion"=>$ver_descripcion,
                "iver_componente"=>$ver_componente,
                "iver_adicional"=>$ver_adicional,
                "iver_serie"=>$ver_serie,
                "iincluir_obsequios"=>$incluir_obsequios,
                "iigv"=>$igv,
                "isubtotal"=>$subtotal,
                "itotal"=>$total
            );
           
            $pdf= new PDF2('P','mm',array(216,279));
            
            $dtCabecera=factura_venta::getComprobante_Vista_Previa(array_merge($array,array("opcion"=>"cabecera")));
            $dtDetalle=factura_venta::getComprobante_Vista_Previa(array_merge($array,array("opcion"=>"detalle")));
            $numero_cuenta=factura_venta::getComprobante_Electronico($id,"numero_cuenta");


            $pdf->AddPage();
            $pdf->cabecera=$dtCabecera;
            $pdf->numero_cuenta=$numero_cuenta;
            $pdf->cabecera_header();
            $pdf->Ln();
            $pdf->SetFont('Arial','B',8);
            $pdf->SetTextColor(255,255,255);
            $pdf->SetFillColor(117,179,114);
            $pdf->Cell(20,7,utf8_decode('CANT.'),1,0,'C',true);
            $pdf->Cell(15,7,utf8_decode('UM'),1,0,'C',true);
            $pdf->Cell(15,7,utf8_decode('CÓD'),1,0,'C',true);
            $pdf->Cell(100,7,utf8_decode('DESCRIPCIÓN'),1,0,'C',true);
            $pdf->Cell(25,7,utf8_decode('P/U'),1,0,'C',true);
            $pdf->Cell(25,7,utf8_decode('IMPORTE'),1,0,'C',true);
            
            $y=87;
            $x=10;
            $array_width=array(20,15,15,100,25,25,100);
            $array_align=array('C','C','C','L','R','R','J');
            $h_atual=$pdf->GetY();
            $pdf->SetTextColor(0,0,0);
            foreach($dtDetalle as $item){
                $longitud=strlen($item["producto"]);
                //$h_atual=$pdf->GetY();
                $pdf->SetXY($x,$y);
                $costo_unitario=number_format($item['precio_unitario'],2,'.',',');
                $pdf->SetFont('Arial','B',8);
                $subtotal=number_format($item['sub_total'],2,'.',',');
                $pdf->MultiCell($array_width[0],5,$item["cantidad"],0,$array_align[0],false);
                $x=$x+$array_width[0];
                $pdf->SetXY($x,$y);
                $pdf->MultiCell($array_width[1],5,$item["medida"],0,$array_align[1],false);
                $x=$x+$array_width[1];
                $pdf->SetXY($x,$y);
                $pdf->MultiCell($array_width[2],5,$item["codigo"],0,$array_align[2],false);
                $x=$x+$array_width[2];
                $pdf->SetXY($x,$y);
                $c=$pdf->getY();
                $pdf->MultiCell($array_width[3],5,$item["producto"],0,$array_align[3],false);
                $d=$pdf->getY();
                $x=$x+$array_width[3];
                $pdf->SetXY($x,$y);
                $pdf->MultiCell($array_width[4],5,$costo_unitario,0,$array_align[4],false);
                $x=$x+$array_width[4];
                $pdf->SetXY($x,$y);
                $pdf->MultiCell($array_width[5],5,$subtotal,0,$array_align[5],false);
                //$x=$x+$array_width[5];
                $y=$y+($d-$c);
                if($item["descripcion"]!=""){
                    $pdf->SetFont('Arial','',6);
                    $pdf->SetXY(60,$y);
                    $pdf->MultiCell($array_width[6],5,substr($item["descripcion"],0,250-$longitud),0,$array_align[6],false);
                    $y=$pdf->GetY();
                }
               
                
                $x=10;
            }
            for ($a=0;$a<count($array_width);$a++){
                
                $pdf->Line($x,$h_atual,$x,$y);
                if($a<count($array_width)-1){
                    $x=$x+$array_width[$a];
                }
                
                
            }
            $pdf->Line(10,$y,$x,$y);
            
            $pdf->contenedor_detalle(130);
            //$dtFactura_Venta_Detalle1=factura_venta_detalle::getGrid1('fvd.factura_venta_ID='.$item['ID'],-1,-1,'ovd.ID asc');
            $pdf->SetWidths(array(20,15,15,100,25,25));
            $pdf->SetAligns(array('C','C','C','L','R','R'));
            //$pdf->contenido_detalle($dtDetalle);

            $ruta=ruta_archivo."/temp/comprobante/factura_".$_SESSION['empresa_ID']."_".rand(1,500).".pdf";
            $pdf->Output($ruta,'F');
        }catch(Exception $ex){
            $GLOBALS['error']=$ex->getMessage();
        }
       
        $retornar=Array('ruta'=>$ruta);
        echo json_encode($retornar);
   
    }
    function post_ajaxFilasComprobantes_Ventas(){
        require ROOT_PATH.'models/factura_venta.php';

        $salida_ID=$_POST['salida_ID'];
        $html="";
        $ver_boton_agregar=0;
        $bloquear_edicion=0;
        try{
            $dt=factura_venta::getFilasComprobantes($salida_ID);
            if(count($dt)>0){
                 $html=utf8_encode($dt[0]["filas"]);
                 $ver_boton_agregar=$dt[0]["ver_boton_agregar"];
                 $bloquear_edicion=$dt[0]["bloquear_edicion"];
            }
           
           
        }
        catch(Exception $ex){
            
            log_error(__FILE__,"salidaController.post_ajaxFilasComprobantes_Ventas",$ex->getMessage());
            $html=utf8_encode(mensaje_error);

        }
       

        $retornar=Array('html'=>$html,'ver_boton_agregar'=>$ver_boton_agregar,'bloquear_edicion'=>$bloquear_edicion);
        echo json_encode($retornar);
    }
    function post_ajaxOrden_Venta_Electronico_Mantenimiento_Comprobante_Eliminar(){
        require ROOT_PATH.'models/factura_venta.php';
        $ID=$_POST['id'];
        $resultado=0;
        $mensaje="";
        try{
            $oFactura_Venta=factura_venta::getByID($ID);
            if(!isset($oFactura_Venta)){
                throw new Exception("No existe el comprobante.");
            }
            $oFactura_Venta->usuario_mod_id=$_SESSION['usuario_ID'];
            $verificar=$oFactura_Venta->eliminar();
            if($verificar==-2){
               $resultado=-1;
               $mensaje="No se puede eliminar el comprobante.";
            }
            $mensaje="Se eliminarion ".$verificar." registros.";
            $resultado=1;
        }catch(Exception $ex){
            $resultado=-1;
            $mensaje= utf8_encode(mensaje_error);
            log_error(__FILE__, "salidaController/post_ajaxOrden_Venta_Electronico_Mantenimiento_Eliminar", $ex->getMessage());
        }
        $retornar=array("resultado"=>$resultado,"mensaje"=>$mensaje);
        echo json_encode($retornar);
    }
    
    function post_ajaxFilasGuias_Ventas(){
        require ROOT_PATH.'models/guia_venta.php';

        $salida_ID=$_POST['salida_ID'];
        $html="";
        $ver_boton_agregar=0;
        $bloquear_edicion=0;
        $boton_imprimir="";
        try{
            $dt=guia_venta::getFilasGuias($salida_ID);
            if(count($dt)>0){
                $html=utf8_encode($dt[0]["filas"]);
                $ver_boton_agregar=$dt[0]["ver_boton_agregar"];
                $bloquear_edicion=$dt[0]["bloquear_edicion"];
                $boton_imprimir=utf8_encode($dt[0]["boton_imprimir"]);
            }
           
           
        }
        catch(Exception $ex){
            
            log_error(__FILE__,"salidaController.post_ajaxFilasGuias_Ventas",$ex->getMessage());
            $html=utf8_encode(mensaje_error);

        }
       

        $retornar=Array('html'=>$html,'ver_boton_agregar'=>$ver_boton_agregar,'bloquear_edicion'=>$bloquear_edicion,'boton_imprimir'=>$boton_imprimir);
        echo json_encode($retornar);
    }
    function post_ajaxCargarDetalle_Guia_Venta(){
        require ROOT_PATH.'models/salida_detalle.php';
        $salida_ID=$_POST['txtSalida_ID'];
        $ver_descripcion=$_POST['ver_descripcion'];
        $ver_componente=$_POST['ver_componente'];
        $ver_adicional=$_POST['ver_adicional'];
        $ver_serie=$_POST['ver_serie'];
        $incluir_obsequios=$_POST['incluir_obsequios'];
        $html="";

        try{
            $dt= salida_detalle::getFilasDetalleGuia($salida_ID,$ver_descripcion,$ver_componente,$ver_adicional,$ver_serie,$incluir_obsequios);
            $html=saltoLineHtml(utf8_encode($dt[0]["filas"]));
      
        }
        catch(Exception $ex){
            
            log_error(__FILE__,"salidaController.post_ajaxCargarDetalle_Comprobante",$ex->getMessage());
            $html.="Ocurrió un error en el sistema";

        }
        $retornar=Array('html'=>$html);
        echo json_encode($retornar);
        
        
       
    }
    function post_ajaxVistaPrevia_Guia_Electronico(){
        require ROOT_PATH.'models/factura_venta.php';
        require ROOT_PATH.'models/guia_venta.php';
        require ROOT_PATH.'formatos_pdf/guia_venta_pdf_vistaprevia.php';
        require ROOT_PATH.'models/salida_detalle.php';
        
        $id=$_POST['txtSalida_ID'];
        //$id=909;
        $serie=$_POST['serie'];
        $numero=$_POST['txtNumero'];
        $fecha_emision=$_POST['txtFecha_Emision'];
        $electronico=$_POST['selTipoDocumento'];
        $numero_orden_venta=$_POST['txtNumero_Orden_Venta'];
        $numero_orden_compra=$_POST['txtNumero_Orden_Compra'];
        $ver_descripcion=(isset($_POST['ckver_descripcion']))? 1:0;
        $ver_componente=(isset($_POST['ckver_componente']))? 1:0;
        $ver_adicional=(isset($_POST['ckver_descripcion']))? 1:0;
        $ver_serie=(isset($_POST['ckver_serie']))? $_POST['ckver_serie']:0;
        $incluir_obsequios=(isset($_POST['ckincluir_obsequios']))? $_POST['ckincluir_obsequios']:0;
        $fecha_inicio_traslado=$_POST['txtFecha_Inicio_Traslado'];
        $distrito_ID_partida=$_POST["selDistrito_Partida"];
        $punto_partida=$_POST["txtPunto_Partida"];
        $distrito_ID_llegada=$_POST["selDistrito_LLegada"];
        $punto_llegada=$_POST["txtPunto_Llegada"];
        $motivo_traslado_ID=$_POST["selMotivo_Traslado"];
        $descripcion_motivo=$_POST["txtDescripcion_Motivo"];
        $modalidad_traslado_ID=$_POST["selModalidad_Traslado"];
        $vehiculo_ID=$_POST["selVehiculo_ID"];
        $chofer_ID=$_POST["selChofer_ID"];
        $ruc_empresa_transporte=$_POST["txtRuc_Empresa_Transporte"];
        $empresa_transporte=$_POST["txtEmpresa_Transporte"];
        $placa_vehiculo=$_POST["txtPlaca_Vehiculo"];
        $documento_conductor=$_POST["txtDNI_Conductor"];
        $ruta="";
        try{
            $array=array(
                "isalida_ID"=>$id,
                "iserie"=>$serie,
                "inumero"=>$numero,
                "ifecha_emision"=>$fecha_emision,
                "inumero_orden_venta"=>$numero_orden_venta,
                "inumero_orden_compra"=>$numero_orden_compra,
                "iver_descripcion"=>$ver_descripcion,
                "iver_componente"=>$ver_componente,
                "iver_adicional"=>$ver_adicional,
                "iver_serie"=>$ver_serie,
                "iincluir_obsequios"=>$incluir_obsequios,
                "ifecha_inicio_traslado"=>$fecha_inicio_traslado,
                "distrito_ID_partida"=>$distrito_ID_partida,
                "punto_partida"=>$punto_partida,
                "distrito_ID_llegada"=>$distrito_ID_llegada,
                "punto_llegada"=>$punto_llegada,
                "motivo_traslado_ID"=>$motivo_traslado_ID,
                "descripcion_motivo"=>$descripcion_motivo,
                "modalidad_traslado_ID"=>$modalidad_traslado_ID,
                "ivehiculo_ID"=>$vehiculo_ID,
                "ichofer_ID"=>$chofer_ID,
                "ruc_empresa_transporte"=>$ruc_empresa_transporte,
                "empresa_transporte"=>$empresa_transporte,
                "placa_vehiculo"=>$placa_vehiculo,
                "documento_conductor"=>$documento_conductor,
                "ielectronico"=>$electronico
            );
           
            $pdf= new PDF2('P','mm',array(216,279));
            $dtCabecera=guia_venta::getVista_Previa(array_merge($array,array("opcion"=>"cabecera")));
            $numero_pagina=1; 
            $nproductoxhoja="";
            $IDs="";
            
            if($electronico==1){
                
                $dtDetalle=guia_venta::getVista_Previa(array_merge($array,array("opcion"=>"detalle")));
            }else{
                
                $dtDetalle=salida_detalle::getEstructura($id,$ver_descripcion,$ver_componente,$ver_adicional,$ver_serie,$incluir_obsequios);
                $array=calcular_estructura_guia($dtDetalle);
                $numero_pagina=$array['numero_pagina'];
                $nproductoxhoja=$array['nproductoxhoja'];
                $lista_IDs=$array['IDs'];
               
                
            }
            
            //$numero_cuenta=factura_venta::getComprobante_Electronico($id,"numero_cuenta");
            $inicio=0;
            for($i=0;$i<$numero_pagina;$i++){
                $numero=$numero+$i;
                $pdf->AddPage();
                $pdf->cabecera=$dtCabecera;
                $pdf->numero=$numero;
                $pdf->electronico=$electronico;
                //$pdf->numero_cuenta=$numero_cuenta;
                $pdf->cabecera_header();
                $pdf->contenedor_detalle(130);
                $pdf->SetWidths(array(20,120,25,35));
                $pdf->SetAligns(array('C','L','C','C'));
                
                if($electronico==1){
                     $pdf->contenido_detalle($dtDetalle);
                }else{
                    $cantidad=explode("/",$nproductoxhoja);
                    
                    $new_array=array_slice($dtDetalle,$inicio,$cantidad[$i]);
                    $pdf->contenido_detalle($new_array);
                    $inicio=$inicio+$cantidad[$i];
                    
                }
               
            }
            
            /*$pdf->Ln();
            $pdf->SetFont('Arial','B',8);
            $pdf->SetTextColor(255,255,255);
            $pdf->SetFillColor(117,179,114);
            $pdf->Cell(20,7,utf8_decode('CANT.'),1,0,'C',true);
            $pdf->Cell(15,7,utf8_decode('UM'),1,0,'C',true);
            $pdf->Cell(15,7,utf8_decode('CÓD'),1,0,'C',true);
            $pdf->Cell(100,7,utf8_decode('DESCRIPCIÓN'),1,0,'C',true);
            $pdf->Cell(25,7,utf8_decode('P/U'),1,0,'C',true);
            $pdf->Cell(25,7,utf8_decode('IMPORTE'),1,0,'C',true);
            
            $y=87;
            $x=10;
            $array_width=array(20,15,15,100,25,25,100);
            $array_align=array('C','C','C','L','R','R','J');
            $h_atual=$pdf->GetY();
            $pdf->SetTextColor(0,0,0);
            /*foreach($dtDetalle as $item){
                //$h_atual=$pdf->GetY();
                $pdf->SetXY($x,$y);
                $costo_unitario=number_format($item['precio_unitario'],2,'.',',');
                $pdf->SetFont('Arial','B',8);
                $subtotal=number_format($item['sub_total'],2,'.',',');
                $pdf->MultiCell($array_width[0],5,$item["cantidad"],0,$array_align[0],false);
                $x=$x+$array_width[0];
                $pdf->SetXY($x,$y);
                $pdf->MultiCell($array_width[1],5,$item["medida"],0,$array_align[1],false);
                $x=$x+$array_width[1];
                $pdf->SetXY($x,$y);
                $pdf->MultiCell($array_width[2],5,$item["codigo"],0,$array_align[2],false);
                $x=$x+$array_width[2];
                $pdf->SetXY($x,$y);
                $c=$pdf->getY();
                $pdf->MultiCell($array_width[3],5,$item["producto"],0,$array_align[3],false);
                $d=$pdf->getY();
                $x=$x+$array_width[3];
                $pdf->SetXY($x,$y);
                $pdf->MultiCell($array_width[4],5,$costo_unitario,0,$array_align[4],false);
                $x=$x+$array_width[4];
                $pdf->SetXY($x,$y);
                $pdf->MultiCell($array_width[5],5,$subtotal,0,$array_align[5],false);
                //$x=$x+$array_width[5];
                $y=$y+($d-$c);
                if($item["descripcion"]!=""){
                    $pdf->SetFont('Arial','',6);
                    $pdf->SetXY(60,$y);
                    $pdf->MultiCell($array_width[6],5,$item["descripcion"],0,$array_align[6],false);
                    $y=$pdf->GetY();
                }
               
                
                $x=10;
            }
            for ($a=0;$a<count($array_width);$a++){
                
                $pdf->Line($x,$h_atual,$x,$y);
                if($a<count($array_width)-1){
                    $x=$x+$array_width[$a];
                }
                
                
            }*/
            //$pdf->Line(10,$y,$x,$y);
            
            //$pdf->contenedor_detalle(130);
            //$dtFactura_Venta_Detalle1=factura_venta_detalle::getGrid1('fvd.factura_venta_ID='.$item['ID'],-1,-1,'ovd.ID asc');
            //$pdf->SetWidths(array(20,15,15,100,25,25));
            //$pdf->SetAligns(array('C','C','C','L','R','R'));
            //$pdf->contenido_detalle($dtDetalle);

            $ruta=ruta_archivo."/temp/guia_remision/guia_remision_".$_SESSION['empresa_ID']."_".rand(1,500).".pdf";
            $pdf->Output($ruta,'F');
        }catch(Exception $ex){
            $GLOBALS['error']=$ex->getMessage();
        }
       
        $retornar=Array('ruta'=>$ruta);
        echo json_encode($retornar);
   
    }
    function post_ajaxCargarSerieGuia() {
        require ROOT_PATH.'models/correlativos.php';
        $electronico=$_POST['id'];
       
        
        $resultado=0;
        try{
            $dt=correlativos::getGridCorrelativos("guia_remision",$electronico);
            $option="";
            foreach($dt as $inumero){
               $option.="<option value='".$inumero['ID']."'>" .$inumero['serie']."</option>";
            }
            $resultado=1;
        }catch(Exception $ex){
            $resultado=-1;
            $mensaje=utf8_encode(mensaje_error);
            log_error(__FILE__,"Salida/post_ajaxCargarSerieGuia",$ex->getMessage());
        }


        $retornar = Array('resultado' => $resultado, 'options' => $option);
        echo json_encode($retornar);
    }
    function get_Orden_Venta_Electronico_Mantenimiento_Comprobante_Editar($id){
        require ROOT_PATH . 'models/salida.php';
        require ROOT_PATH . 'models/salida_detalle.php';
        require ROOT_PATH . 'models/factura_venta.php';
        require ROOT_PATH . 'models/correlativos.php';
        require ROOT_PATH . 'models/impuestos_tipo.php';
        require ROOT_PATH . 'models/moneda.php';
        require ROOT_PATH . 'models/tipo_comprobante.php';
        global  $returnView_float;
        $returnView_float=true;
        
        //echo $id;
        $listaproducto="";
        $oFactura_Venta=factura_venta::getByID($id);
        try{
            
            $oSalida=salida::getByID($oFactura_Venta->salida_ID);
            $oFactura_Venta->dtTipo_Comprobante=tipo_comprobante::getComprobantes(1, "venta", $oFactura_Venta->correlativos_ID,0,"tipo_comprobantes");
            $oFactura_Venta->dtSerie=tipo_comprobante::getComprobantes(1, "venta", $oFactura_Venta->correlativos_ID,0,"series");
            $dtMoneda=moneda::getGrid();
            $dtImpuestos_Tipo=impuestos_tipo::getGrid();
            $oFactura_Venta->dtImpuestos_Tipo=$dtImpuestos_Tipo;
            $oFactura_Venta->dtMoneda=$dtMoneda;
        //$listaproducto=salida_detalle::getFilasDetalleComprobante(814);
        }catch(Exception $ex){
            
            log_error(__FILE__,"salidaController.get_Orden_Venta_Electronico_Mantenimiento_Comprobante_Nuevo",$ex->getMessage());
        }
        
        
        $GLOBALS['oFactura_Venta']=$oFactura_Venta;
        //$GLOBALS['listaproducto']=$listaproducto;
        $GLOBALS['oOrden_Venta']=$oSalida;
    }
    function post_Orden_Venta_Electronico_Mantenimiento_Comprobante_Editar($id){
        require ROOT_PATH . 'models/salida.php';
        //require ROOT_PATH . 'models/salida_detalle.php';
        require ROOT_PATH . 'models/factura_venta.php';
        require ROOT_PATH . 'models/correlativos.php';
        require ROOT_PATH . 'models/impuestos_tipo.php';
        require ROOT_PATH . 'models/estado.php';
        require ROOT_PATH . 'models/tabla_movimiento.php';
        require ROOT_PATH . 'models/factura_venta_detalle.php';
        require ROOT_PATH . 'models/tipo_comprobante.php';
        global  $returnView_float;
        $returnView_float=true;
        
        $comprobante=$_POST['selTipoComprobante'];
        $opcion=0;
        if(isset($_POST['ckOpcion'])){
            $opcion=$_POST['ckOpcion'];
        }
        
        $correlativos_ID=$_POST['selSerie'];
        $Fecha_Emision=$_POST['txtFecha_Emision'];
        $Plazo_Factura=$_POST['txtPlazo_Factura'];
        $Fecha_Vencimiento=$_POST['txtFecha_Vencimiento'];
        $moneda_ID=$_POST['selMoneda'];
        $numero_orden_compra=FormatTextSave($_POST['txtNumero_Orden_Compra']);
        $numero_orden_venta= FormatTextSave($_POST['txtNumero_Orden_Venta']);
        ///$impuestos_tipo_ID=$_POST['selImpuestos_Tipo'];
        $ver_descripcion=(isset($_POST['ckver_descripcion']))?1:0;
        $ver_componente=(isset($_POST['ckver_componente']))?1:0;
        $ver_adicional=(isset($_POST['ckver_adicional']))?1:0;
        $ver_serie=(isset($_POST['ckver_serie']))?1:0;
        $incluir_obsequios=(isset($_POST['ckincluir_obsequios']))?1:0;
        $porcentaje_descuento=$_POST['txtPorcentaje_Descuento'];
        $anticipos=$_POST['txtAnticipos'];
        $exoneradas=$_POST['txtExoneradas'];
        $inafectas=$_POST['txtInafectas'];
        $gravadas=$_POST['txtGravadas'];
        $monto_total_igv=$_POST['txtTotal_IGV'];
        $gratuitas=$_POST['txtGratuitas'];
        $otros_cargos=$_POST['txtOtros_Cargos'];
        $descuento_global=$_POST['txtDescuento_Global'];
        $monto_total=$_POST['txtMonto_Total'];
        $estado_ID=isset($_POST['ckGenerar'])?93:35;
        try{
            $oFactura_Venta=factura_venta::getByID($id);
            if($oFactura_Venta->estado_ID==93){
                $GLOBALS["resultado"]=-2;
                $GLOBALS["mensaje"]="La factura ya se encuentra generado, si desea modificar debe anular el número.";
                throw new Exception("La factura ya se encuentra emitido, si desea modificar debe anular el número.");
            }
            $oSalida=salida::getByID($oFactura_Venta->salida_ID);
            if($oFactura_Venta->estado_ID==35){
                $numero=correlativos::getNumero($correlativos_ID);
                $oCorrelativos=correlativos::getByID($correlativos_ID);
                $oFactura_Venta->serie=$oCorrelativos->serie;
                $oFactura_Venta->numero=$numero;
                $numero_concatenado=sprintf("%'.07d",$numero);
                $oFactura_Venta->numero_concatenado=$numero_concatenado;
            }
            $oFactura_Venta->estado_ID=$estado_ID;
            $oFactura_Venta->fecha_emision=$Fecha_Emision;
            $oFactura_Venta->forma_pago_ID=$oSalida->forma_pago_ID;
            $oFactura_Venta->plazo_factura=$Plazo_Factura;
            $oFactura_Venta->fecha_vencimiento=$Fecha_Vencimiento;
            //Generamos la factura en estado registrado
            
            //$oFactura_Venta->estado_ID=93;//Estado generado
            $oFactura_Venta->observacion='';
            $oFactura_Venta->moneda_ID=$moneda_ID;
            $oFactura_Venta->numero_orden_venta=$numero_orden_venta;
            $oFactura_Venta->numero_orden_compra=$numero_orden_compra;
            $oFactura_Venta->monto_total_neto=$gravadas;
            $oFactura_Venta->monto_total_igv=$monto_total_igv;
            $oFactura_Venta->monto_total=$monto_total;
            //$oFactura_Venta->impuestos_tipo_ID=$impuestos_tipo_ID;
            $oFactura_Venta->correlativos_ID=$correlativos_ID;
            $oFactura_Venta->gravadas=$gravadas;
            $oFactura_Venta->anticipos=$anticipos;
            $oFactura_Venta->gratuitas=$gratuitas;
            $oFactura_Venta->inafectas=$inafectas;
            $oFactura_Venta->exoneradas=$exoneradas;
            $oFactura_Venta->descuento_global=$descuento_global;
            $oFactura_Venta->porcentaje_descuento=$porcentaje_descuento;
            $oFactura_Venta->otros_cargos=$otros_cargos;
            $oFactura_Venta->ver_descripcion=$ver_descripcion;
            $oFactura_Venta->ver_componente=$ver_componente;
            $oFactura_Venta->ver_adicional=$ver_adicional;
            $oFactura_Venta->ver_serie=$ver_serie;
            $oFactura_Venta->incluir_obsequios=$incluir_obsequios;
            $oFactura_Venta->usuario_mod_id=$_SESSION['usuario_ID'];
            $retornar=$oFactura_Venta->actualizar();
            if($retornar>0){
                $oTabla_Movimiento=new tabla_movimiento();
                $oTabla_Movimiento->tabla_ID=$ID;
                $oTabla_Movimiento->tabla="factura_venta";
                $oTabla_Movimiento->estado_ID=$estado_ID;
                $oTabla_Movimiento->fecha=date('Y-m-d H:i:s');
                $oTabla_Movimiento->observacion="Factura electrónica.";
                $oTabla_Movimiento->usuario_ID_creacion=$_SESSION['usuario_ID'];
                $oTabla_Movimiento->empresa_ID=$_SESSION['empresa_ID'];
                $oTabla_Movimiento->usuario_id=$_SESSION['usuario_ID'];
                $oTabla_Movimiento->insertar();
                //Insertamos los detalles de la factura
                $oFactura_Venta_Detalle=new factura_venta_detalle();
                $oFactura_Venta_Detalle->factura_venta_ID=$ID;
                $oFactura_Venta_Detalle->salida_ID=$salida_ID;
                $oFactura_Venta_Detalle->impuestos_tipo_ID=$impuestos_tipo_ID;
                $oFactura_Venta_Detalle->ver_descripcion=$ver_descripcion;
                $oFactura_Venta_Detalle->ver_componente=$ver_componente;
                $oFactura_Venta_Detalle->ver_adicional=$ver_adicional;
                $oFactura_Venta_Detalle->ver_serie=$ver_serie;
                $oFactura_Venta_Detalle->incluir_obsequios=$incluir_obsequios;
                $oFactura_Venta_Detalle->usuario_id=$_SESSION['usuario_ID'];
                $oFactura_Venta_Detalle->insertar_todos();
                /*if($oFactura_Venta->estado_ID==93){
                    //$oCorrelativos=correlativos::getByID($correlativos_ID);
                    $oCorrelativos->ultimo_numero=$numero;
                    $oCorrelativos->usuario_mod_id=$_SESSION['usuario_ID'];
                    $oCorrelativos->actualizar();
                }*/
            }
            
            
            $oFactura_Venta->dtTipo_Comprobante=tipo_comprobante::getComprobantes(1, "venta", $oFactura_Venta->correlativos_ID,0,"tipo_comprobantes");
            $oFactura_Venta->dtSerie=tipo_comprobante::getComprobantes(1, "venta", $oFactura_Venta->correlativos_ID,0,"series");
            
            $mensaje=$oFactura_Venta->getMessage;
            $resultado=1;
        }catch(Exception $ex){
          $resultado=-1;
          $mensaje="Ocurrió un error en el sistema";
          log_error(__FILE__, "salidaController.post_Orden_Venta_Electronico_Mantenimiento_Comprobante", $ex->getMessage());
        }
        $GLOBALS['oFactura_Venta']=$oFactura_Venta;
        $GLOBALS['oOrden_Venta']=$oSalida;
        $GLOBALS['resultado']=$resultado;
        $GLOBALS['mensaje']=$mensaje;
    }
    function get_Orden_Venta_Electronico_Mantenimiento_Guia_Nuevo($id){
        
        require ROOT_PATH . 'models/factura_venta.php';
        require ROOT_PATH . 'models/guia_venta.php';
        require ROOT_PATH . 'models/moneda.php';
        require ROOT_PATH . 'models/vehiculo.php';
        require ROOT_PATH . 'models/chofer.php';
        require ROOT_PATH . 'models/correlativos.php';
        require ROOT_PATH . 'models/cliente.php';
        require ROOT_PATH . 'models/salida.php';
        require ROOT_PATH . 'models/departamento.php';
        require ROOT_PATH . 'models/provincia.php';
        require ROOT_PATH . 'models/distrito.php';
        require ROOT_PATH . 'models/motivo_traslado.php';
        require ROOT_PATH . 'models/modalidad_traslado.php';
        require ROOT_PATH . 'models/tipo_comprobante.php';
        require ROOT_PATH . 'models/salida_detalle.php';
        global  $returnView_float;
        $returnView_float=true;
        $salida_ID=$id;
        $comprobante_tipo_ID=5;
        $oGuia_Venta=new guia_venta();
        try{
            $osalida=salida::getByID($salida_ID);
            $contar_producto=salida_detalle::getCount("salida_ID=".$id." and tipo_ID in (1,2,5,6)");
            if($contar_producto==0){
                $GLOBALS['resultado']=-2;
                $GLOBALS['mensaje']="No se ha registrado ningún producto";
                throw new Exception("No se ha registrado ningún producto");
            }
            
            $dtFactura_Venta=factura_venta::getGrid('salida_ID='.$id.' and estado_ID in (93) and con_guia=1',-1,-1,'ID asc');//Sola facturas generadas
            if(count($dtFactura_Venta)==0){
                
                $GLOBALS['resultado']=-2;
                $GLOBALS['mensaje']="No ha generado la factura o no marcó la opción con guía.";
                throw new Exception("No ha generado la factura o no marcó la opción con guía.");
            }
            $oGuia_Venta->factura_venta_ID=$dtFactura_Venta[0]['ID'];
            $oGuia_Venta->dtFactura_Venta=$dtFactura_Venta;
            $oGuia_Venta->numero_orden_compra=$osalida->numero_orden_compra;
            $oGuia_Venta->numero_orden_venta=$osalida->numero_concatenado;
            $oGuia_Venta->dtVehiculo=vehiculo::getGrid('',-1,-1,'descripcion asc');
            $oGuia_Venta->dtChofer=chofer::getGrid('',-1,-1,'pe.apellido_paterno asc, pe.apellido_materno asc, pe.nombres asc');
            $dtPartida=distrito::getUbigeo(0,$_SESSION['empresa_ID'],-1);
            $oGuia_Venta->dtDepartamento=departamento::getOpciones($dtPartida[0]["departamento_ID"]);
            $oGuia_Venta->dtProvincia=provincia::getOpciones($dtPartida[0]["provincia_ID"],$dtPartida[0]["departamento_ID"]);
            $oGuia_Venta->dtDistrito=distrito::getOpciones($dtPartida[0]["ID"],$dtPartida[0]["provincia_ID"]); 
            $oGuia_Venta->punto_partida=$dtPartida[0]["direccion"];
            $oGuia_Venta->dtMotivo_Traslado=motivo_traslado::getGrid("ID in (1,2)");
            $oGuia_Venta->dtModalidad_Traslado=modalidad_traslado::getGrid();
            
            
            $dtLlegada=distrito::getUbigeo(0,-1,$osalida->cliente_ID);
            $oGuia_Venta->dtDepartamento_llegada=departamento::getOpciones($dtLlegada[0]["departamento_ID"]);
            $oGuia_Venta->dtProvincia_llegada=provincia::getOpciones($dtLlegada[0]["provincia_ID"],$dtLlegada[0]["departamento_ID"]);
            $oGuia_Venta->dtDistrito_llegada=distrito::getOpciones($dtLlegada[0]["ID"],$dtLlegada[0]["provincia_ID"]); 
            $oGuia_Venta->punto_llegada=$dtLlegada[0]["direccion"];
            $oCorrelativos=correlativos::getByID(correlativos_ID_guia_remision);
            $electronico=$oCorrelativos->electronico;
            $oGuia_Venta->dtSerie=tipo_comprobante::getComprobantes($electronico, "guia_remision", correlativos_ID_guia_remision,0,"series");
            $numero=correlativos::getNumero(correlativos_ID_guia_remision);
            $oGuia_Venta->numero_concatenado=sprintf("%'.07d",$numero);
            
            
            $oGuia_Venta->tipo_documento=$electronico;
//$oGuia_Venta->dtSerie=$dtSerie;
        }catch(Exception $ex){
            log_error(__FILE__, "salidaController.get_Orden_Venta_Electronico_Mantenimiento_Guia_Nuevo", $ex->getMessage());
        }
        $GLOBALS['oGuia_Venta']=$oGuia_Venta;
        $GLOBALS['oOrden_Venta']=$osalida;
    }
    function post_Orden_Venta_Electronico_Mantenimiento_Guia_Nuevo($id){
        require ROOT_PATH . 'models/factura_venta.php';
        require ROOT_PATH . 'models/guia_venta.php';
        require ROOT_PATH . 'models/moneda.php';
        require ROOT_PATH . 'models/vehiculo.php';
        require ROOT_PATH . 'models/chofer.php';
        require ROOT_PATH . 'models/correlativos.php';
        require ROOT_PATH . 'models/cliente.php';
        require ROOT_PATH . 'models/salida.php';
        require ROOT_PATH . 'models/departamento.php';
        require ROOT_PATH . 'models/provincia.php';
        require ROOT_PATH . 'models/distrito.php';
        require ROOT_PATH . 'models/motivo_traslado.php';
        require ROOT_PATH . 'models/modalidad_traslado.php';
        require ROOT_PATH . 'models/tipo_comprobante.php';
        require ROOT_PATH . 'models/salida_detalle.php';
        
        global  $returnView_float;
        $returnView_float=true;
        $salida_ID=$id;
        //$ID=$_POST['txtID'];
        //$factura_venta_ID=$_POST['txtFactura_ID'];
        $tipo_documento=$_POST['selTipoDocumento'];//0 es un doc físico, 1 es electrónico
        $opcion=0;
        if(isset($_POST['ckOpcion'])){
            $opcion=$_POST['ckOpcion'];
        }
        $correlativos_ID=$_POST['selSerie'];
        $factura_venta_ID=$_POST['selFactura'];
        $fecha_emision=$_POST['txtFecha_Emision'];
        $peso_bruto_total=$_POST['txtPeso_Bruto_Total'];
        $numero_orden_compra=$_POST['txtNumero_Orden_Compra'];
        $numero_orden_venta=$_POST['txtNumero_Orden_Venta'];
        $observacion=$_POST['txtObservacion'];
        $ver_descripcion=(isset($_POST['ckver_descripcion']))?1:0;
        $ver_componente=(isset($_POST['ckver_componente']))?1:0;
        $ver_adicional=(isset($_POST['ckver_adicional']))?1:0;
        $ver_serie=(isset($_POST['ckver_serie']))?1:0;
        $incluir_obsequios=(isset($_POST['ckincluir_obsequios']))?1:0;
        if($tipo_documento==1){
            $estado_ID=(isset($_POST['ckGenerar']))?97:37;//Estado Generado y el estado registrado
        }else{
            $estado_ID=(isset($_POST['ckGenerar']))?44:37;//Estado Por remitir y el estado Registrado
        }
        
       
        $fecha_inicio_traslado=$_POST['txtFecha_Inicio_Traslado'];
        $distrito_ID_partida=$_POST['selDistrito_Partida'];
        $punto_partida=  $_POST['txtPunto_Partida'];
        $distrito_ID_llegada=$_POST['selDistrito_LLegada'];
        $punto_llegada=$_POST['txtPunto_Llegada'];
        $motivo_traslado_ID=$_POST['selMotivo_Traslado'];
        $descripcion_motivo=$_POST['txtDescripcion_Motivo'];
        $modalidad_traslado_ID=$_POST['selModalidad_Traslado'];
        $vehiculo_ID=$_POST['selVehiculo_ID'];
        $chofer_ID=$_POST['selChofer_ID'];
        $ruc_transportista=$_POST['txtRuc_Empresa_Transporte'];
        
        $razon_social_transportista=$_POST['txtEmpresa_Transporte'];
        $nro_placa_vehiculo=$_POST['txtPlaca_Vehiculo'];
        $nro_documento_conductor=$_POST['txtDNI_Conductor'];
        $imprimir=0;
        try{
            $numero_pagina=1;
            $nproductoxhoja="";
            $IDs="";
            $dt=salida_detalle::getEstructura($salida_ID,$ver_descripcion,$ver_componente,$ver_adicional,$ver_serie,$incluir_obsequios);
            if($tipo_documento==0){
                //Documento físico
                $array=calcular_estructura_guia($dt);
                $numero_pagina=$array['numero_pagina'];
                $nproductoxhoja=$array['nproductoxhoja'];
                $lista_IDs=$array['IDs'];
            }else{
                
                $y=0;
                foreach($dt as $ID){
                    if($y==0){
                        $IDs=$ID['ID'];
                    }else{
                       $IDs=",".$ID['ID']; 
                    }
                    
                           $y++;
                }
                
            }
            for($i=0;$i<$numero_pagina;$i++){
                $oSalida=salida::getByID($id);
                $oCorrelativos=correlativos::getByID($correlativos_ID);
                $numero= correlativos::getNumero($correlativos_ID);
                $numero=$numero+$i;
                $oGuia_Venta=new guia_venta();
                $oGuia_Venta->factura_venta_ID=$factura_venta_ID;
                $oGuia_Venta->serie=$oCorrelativos->serie;
                $oGuia_Venta->numero=$numero;
                $oGuia_Venta->numero_concatenado=sprintf("%'.07d", $numero);
                $oGuia_Venta->fecha_emision=$fecha_emision;
                $oGuia_Venta->numero_orden_compra=$numero_orden_compra;
                $oGuia_Venta->numero_orden_venta=$numero_orden_venta;
                $oGuia_Venta->vehiculo_ID=$vehiculo_ID;
                $oGuia_Venta->chofer_ID=$chofer_ID;
                $oGuia_Venta->estado_ID=$estado_ID;
                $oGuia_Venta->observacion=$observacion;
                $oGuia_Venta->fecha_inicio_traslado=$fecha_inicio_traslado;
                $oGuia_Venta->punto_partida=$punto_partida;
                $oGuia_Venta->punto_llegada=$punto_llegada;
                $oGuia_Venta->empresa_transporte=$razon_social_transportista;
                $oGuia_Venta->salida_ID=$id;
                $oGuia_Venta->correlativos_ID=$correlativos_ID;
                $oGuia_Venta->ver_descripcion=$ver_descripcion;
                $oGuia_Venta->ver_componente=$ver_componente;
                $oGuia_Venta->ver_adicional=$ver_adicional;
                $oGuia_Venta->ver_serie=$ver_serie;
                $oGuia_Venta->incluir_obsequios=$incluir_obsequios;
                $oGuia_Venta->motivo_traslado_ID=$motivo_traslado_ID;
                $oGuia_Venta->descripcion_motivo=$descripcion_motivo;
                $oGuia_Venta->transbordo=false;
                $oGuia_Venta->peso_bruto_total=$peso_bruto_total;
                $oGuia_Venta->modalidad_traslado_ID=$modalidad_traslado_ID;
                $oGuia_Venta->ruc_transportista=$ruc_transportista;
                $oGuia_Venta->razon_social_transportista=$razon_social_transportista;
                $oGuia_Venta->nro_placa_vehiculo=$nro_placa_vehiculo;
                $oGuia_Venta->nro_documento_conductor=$nro_documento_conductor;
                $oGuia_Venta->distrito_ID_partida=$distrito_ID_partida;
                $oGuia_Venta->distrito_ID_llegada=$distrito_ID_llegada;
                $oGuia_Venta->numero_pagina=$i+1;
                
                $numero_producto=0;
                if($tipo_documento==1){
                    //Electrónico
                    $numero_producto=count($dt);
                    $salida_detalle_IDs=$IDs;
                }else{
                    $porcion=explode("/",$nproductoxhoja);
                    $lista_ID=explode("|",$lista_IDs);
                    if(isset($lista_ID)){
                        $salida_detalle_IDs=$lista_ID[$i];
                    }else{
                     $salida_detalle_IDs=$lista_IDs;
                    }
                    
                    
                    $numero_producto=$porcion[$i];
                }
                $oGuia_Venta->salida_detalle_IDs=$salida_detalle_IDs;
                $oGuia_Venta->numero_producto=$numero_producto;
                $ID=$oGuia_Venta->insertar();
            }
            
            $oGuia_Venta->tipo_documento=$tipo_documento;
            $mensaje=$oGuia_Venta->getMessage;
            $resultado=1;
            $oFactura_Venta=factura_venta::getByID($factura_venta_ID);
            if($estado_ID=97 &&($oFactura_Venta->estado_ID=93||$oFactura_Venta->estado_ID=94)){
                $imprimir=1;
            }
            $oGuia_Venta->dtVehiculo=vehiculo::getGrid('',-1,-1,'descripcion asc');
            $oGuia_Venta->dtChofer=chofer::getGrid('',-1,-1,'pe.apellido_paterno asc, pe.apellido_materno asc, pe.nombres asc');
            $dtPartida=distrito::getUbigeo(0,$_SESSION['empresa_ID'],-1);
            $oGuia_Venta->dtDepartamento=departamento::getOpciones($dtPartida[0]["departamento_ID"]);
            $oGuia_Venta->dtProvincia=provincia::getOpciones($dtPartida[0]["provincia_ID"],$dtPartida[0]["departamento_ID"]);
            $oGuia_Venta->dtDistrito=distrito::getOpciones($dtPartida[0]["ID"],$dtPartida[0]["provincia_ID"]); 
            $oGuia_Venta->punto_partida=$dtPartida[0]["direccion"];
            $oGuia_Venta->dtMotivo_Traslado=motivo_traslado::getGrid("ID in (1,2)");
            $oGuia_Venta->dtModalidad_Traslado=modalidad_traslado::getGrid();
            
            $dtFactura_Venta=factura_venta::getGrid('salida_ID='.$id,-1,-1,'ID asc');
            $oGuia_Venta->dtFactura_Venta=$dtFactura_Venta;
            $dtLlegada=distrito::getUbigeo(0,-1,$oSalida->cliente_ID);
            $oGuia_Venta->dtDepartamento_llegada=departamento::getOpciones($dtLlegada[0]["departamento_ID"]);
            $oGuia_Venta->dtProvincia_llegada=provincia::getOpciones($dtLlegada[0]["provincia_ID"],$dtLlegada[0]["departamento_ID"]);
            $oGuia_Venta->dtDistrito_llegada=distrito::getOpciones($dtLlegada[0]["ID"],$dtLlegada[0]["provincia_ID"]); 
            $oGuia_Venta->punto_llegada=$dtLlegada[0]["direccion"];
            $oGuia_Venta->dtSerie=tipo_comprobante::getComprobantes($tipo_documento, "guia_remision", $correlativos_ID,0,"series");        
            
        }catch(Exception $ex){
          $resultado=-1;
          $mensaje=$ex->getMessage();
        }
       
        $oGuia_Venta->ver_imprimir=$imprimir;
        $GLOBALS['oGuia_Venta']=$oGuia_Venta;
        $GLOBALS['oOrden_Venta']=$oSalida;
        $GLOBALS['mensaje']=$mensaje;
        $GLOBALS['resultado']=$resultado;
    }
    
    function get_Orden_Venta_Electronico_Mantenimiento_Guia_Editar($id){
        
        require ROOT_PATH . 'models/factura_venta.php';
        require ROOT_PATH . 'models/guia_venta.php';
        require ROOT_PATH . 'models/moneda.php';
        require ROOT_PATH . 'models/vehiculo.php';
        require ROOT_PATH . 'models/chofer.php';
        require ROOT_PATH . 'models/correlativos.php';
        require ROOT_PATH . 'models/cliente.php';
        require ROOT_PATH . 'models/salida.php';
        require ROOT_PATH . 'models/departamento.php';
        require ROOT_PATH . 'models/provincia.php';
        require ROOT_PATH . 'models/distrito.php';
        require ROOT_PATH . 'models/motivo_traslado.php';
        require ROOT_PATH . 'models/modalidad_traslado.php';
        require ROOT_PATH . 'models/tipo_comprobante.php';
        require ROOT_PATH . 'models/salida_detalle.php';
        global  $returnView_float;
        $returnView_float=true;
       
        $comprobante_tipo_ID=5;
        
        try{
            $oGuia_Venta=guia_venta::getByID($id);
            $salida_ID=$oGuia_Venta->salida_ID;
            $osalida=salida::getByID($salida_ID);
            $contar_producto=salida_detalle::getCount("salida_ID=".$id." and tipo_ID in (1,2,5,6)");
            if($contar_producto==0){
                $GLOBALS['resultado']=-2;
                $GLOBALS['mensaje']="No se ha registrado ningún producto";
                throw new Exception("No se ha registrado ningún producto");
            }
            
            $dtFactura_Venta=factura_venta::getGrid('salida_ID='.$salida_ID,-1,-1,'ID asc');
            $oGuia_Venta->dtFactura_Venta=$dtFactura_Venta;
            
            $oGuia_Venta->dtVehiculo=vehiculo::getGrid('',-1,-1,'descripcion asc');
            $oGuia_Venta->dtChofer=chofer::getGrid('',-1,-1,'pe.apellido_paterno asc, pe.apellido_materno asc, pe.nombres asc');
            $dtPartida=distrito::getUbigeo($oGuia_Venta->distrito_ID_partida,-1,-1);
            $oGuia_Venta->dtDepartamento=departamento::getOpciones($dtPartida[0]["departamento_ID"]);
            $oGuia_Venta->dtProvincia=provincia::getOpciones($dtPartida[0]["provincia_ID"],$dtPartida[0]["departamento_ID"]);
            $oGuia_Venta->dtDistrito=distrito::getOpciones($dtPartida[0]["ID"],$dtPartida[0]["provincia_ID"]); 
  
            $oGuia_Venta->dtMotivo_Traslado=motivo_traslado::getGrid("ID in (1,2)");
            $oGuia_Venta->dtModalidad_Traslado=modalidad_traslado::getGrid();
            
            
            $dtLlegada=distrito::getUbigeo($oGuia_Venta->distrito_ID_llegada,-1,-1);
            $oGuia_Venta->dtDepartamento_llegada=departamento::getOpciones($dtLlegada[0]["departamento_ID"]);
            $oGuia_Venta->dtProvincia_llegada=provincia::getOpciones($dtLlegada[0]["provincia_ID"],$dtLlegada[0]["departamento_ID"]);
            $oGuia_Venta->dtDistrito_llegada=distrito::getOpciones($dtLlegada[0]["ID"],$dtLlegada[0]["provincia_ID"]); 
            $oCorrelativos=correlativos::getByID($oGuia_Venta->correlativos_ID);
            $electronico=$oCorrelativos->electronico;
            $oGuia_Venta->dtSerie=tipo_comprobante::getComprobantes($electronico, "guia_remision", correlativos_ID_guia_remision,0,"series");
            if($oGuia_Venta->estado_ID==36||$oGuia_Venta->estado_ID==37){
                $numero=correlativos::getNumero(correlativos_ID_guia_remision);
                $oGuia_Venta->numero_concatenado=sprintf("%'.07d",$numero);
            }
           
            
            
            $oGuia_Venta->tipo_documento=$electronico;
//$oGuia_Venta->dtSerie=$dtSerie;
        }catch(Exception $ex){
            log_error(__FILE__, "salidaController.get_Orden_Venta_Electronico_Mantenimiento_Guia_Nuevo", $ex->getMessage());
        }
        $GLOBALS['oGuia_Venta']=$oGuia_Venta;
        $GLOBALS['oOrden_Venta']=$osalida;
    }
    function post_Orden_Venta_Electronico_Mantenimiento_Guia_Editar($id){
        require ROOT_PATH . 'models/factura_venta.php';
        require ROOT_PATH . 'models/guia_venta.php';
        require ROOT_PATH . 'models/moneda.php';
        require ROOT_PATH . 'models/vehiculo.php';
        require ROOT_PATH . 'models/chofer.php';
        require ROOT_PATH . 'models/correlativos.php';
        require ROOT_PATH . 'models/cliente.php';
        require ROOT_PATH . 'models/salida.php';
        require ROOT_PATH . 'models/departamento.php';
        require ROOT_PATH . 'models/provincia.php';
        require ROOT_PATH . 'models/distrito.php';
        require ROOT_PATH . 'models/motivo_traslado.php';
        require ROOT_PATH . 'models/modalidad_traslado.php';
        require ROOT_PATH . 'models/tipo_comprobante.php';
        require ROOT_PATH . 'models/salida_detalle.php';
        global  $returnView_float;
        $returnView_float=true;
        $salida_ID=$id;
        //$ID=$_POST['txtID'];
        //$factura_venta_ID=$_POST['txtFactura_ID'];
        
        $opcion=0;
        $tipo_documento=$_POST['selTipoDocumento'];//0 es un doc físico, 1 es electrónico
        if(isset($_POST['ckOpcion'])){
            $opcion=$_POST['ckOpcion'];
        }
        $correlativos_ID=$_POST['selSerie'];
        $factura_venta_ID=$_POST['selFactura'];
        $fecha_emision=$_POST['txtFecha_Emision'];
        $peso_bruto_total=$_POST['txtPeso_Bruto_Total'];
        $numero_orden_compra=$_POST['txtNumero_Orden_Compra'];
        $numero_orden_venta=$_POST['txtNumero_Orden_Venta'];
        $observacion=$_POST['txtObservacion'];
        $ver_descripcion=(isset($_POST['ckver_descripcion']))?1:0;
        $ver_componente=(isset($_POST['ckver_componente']))?1:0;
        $ver_adicional=(isset($_POST['ckver_adicional']))?1:0;
        $ver_serie=(isset($_POST['ckver_serie']))?1:0;
        $incluir_obsequios=(isset($_POST['ckincluir_obsequios']))?1:0;
        
        if($tipo_documento==1){
            $estado_ID=(isset($_POST['ckGenerar']))?97:37;//Estado Generado y el estado registrado
        }else{
            $estado_ID=(isset($_POST['ckGenerar']))?44:37;//Estado Por remitir y el estado Registrado
        }
        
        $fecha_inicio_traslado=$_POST['txtFecha_Inicio_Traslado'];
        $distrito_ID_partida=$_POST['selDistrito_Partida'];
        $punto_partida=  $_POST['txtPunto_Partida'];
        $distrito_ID_llegada=$_POST['selDistrito_LLegada'];
        $punto_llegada=$_POST['txtPunto_Llegada'];
        $motivo_traslado_ID=$_POST['selMotivo_Traslado'];
        $descripcion_motivo=$_POST['txtDescripcion_Motivo'];
        $modalidad_traslado_ID=$_POST['selModalidad_Traslado'];
        $vehiculo_ID=$_POST['selVehiculo_ID'];
        $chofer_ID=$_POST['selChofer_ID'];
        $ruc_transportista=$_POST['txtRuc_Empresa_Transporte'];
        
        $razon_social_transportista=$_POST['txtEmpresa_Transporte'];
        $nro_placa_vehiculo=$_POST['txtPlaca_Vehiculo'];
        $nro_documento_conductor=$_POST['txtDNI_Conductor'];
        try{
            $numero_pagina=1;
            $nproductoxhoja="";
            $IDs="";
            
            $oGuia_Venta1=guia_venta::getByID($id);
            $salida_ID=$oGuia_Venta1->salida_ID;
            $dt=salida_detalle::getEstructura($salida_ID,$ver_descripcion,$ver_componente,$ver_adicional,$ver_serie,$incluir_obsequios);
            if(!isset($oGuia_Venta1)){
                throw new Exception("No existe el registro.");
            }
            if(count($dt)==0){
                throw new Exception("La venta no tiene registrado detalles.");
            }
           
            $oSalida=salida::getByID($salida_ID);
            if($tipo_documento==0){
                //Documento físico
                $array=calcular_estructura_guia($dt);
                $numero_pagina=$array['numero_pagina'];
                $nproductoxhoja=$array['nproductoxhoja'];
                $lista_IDs=$array['IDs'];
            }else{
                
                $y=0;
                foreach($dt as $ID){
                    if($y==0){
                        $IDs=$ID['ID'];
                    }else{
                       $IDs=",".$ID['ID']; 
                    }
                    
                           $y++;
                }
                
            }
            
            $array_guia_existentes=guia_venta::getGrid('salida_ID='.$salida_ID.' and estado_ID in (36,37)');
            //print_r($array_guia_existentes);
            for($i=0;$i<$numero_pagina;$i++){
                $guia=$array_guia_existentes[$i];
                if (isset($guia)){
                    $oGuia_Venta=guia_venta::getByID($guia['ID']);
                    if($oGuia_Venta->estado_ID==36||$oGuia_Venta->estado_ID==37){
                        $oCorrelativos=correlativos::getByID($correlativos_ID);
                        $numero= correlativos::getNumero($correlativos_ID);
                        $oGuia_Venta->serie=$oCorrelativos->serie;
                        $oGuia_Venta->numero=$numero;
                        $oGuia_Venta->numero_concatenado=sprintf("%'.07d", $numero);
                    }
                }else{
                    $oGuia_Venta=new guia_venta();
                    $oCorrelativos=correlativos::getByID($correlativos_ID);
                    $numero= correlativos::getNumero($correlativos_ID);
                    $oGuia_Venta->serie=$oCorrelativos->serie;
                    $oGuia_Venta->numero=$numero;
                    $oGuia_Venta->numero_concatenado=sprintf("%'.07d", $numero);
                }
                
                $oGuia_Venta->tipo_documento=$tipo_documento;
                $oGuia_Venta->factura_venta_ID=$factura_venta_ID;
                $oGuia_Venta->fecha_emision=$fecha_emision;
                $oGuia_Venta->numero_orden_compra=$numero_orden_compra;
                $oGuia_Venta->numero_orden_venta=$numero_orden_venta;
                $oGuia_Venta->vehiculo_ID=$vehiculo_ID;
                $oGuia_Venta->chofer_ID=$chofer_ID;
                $oGuia_Venta->estado_ID=$estado_ID;
                $oGuia_Venta->observacion=$observacion;
                $oGuia_Venta->fecha_inicio_traslado=$fecha_inicio_traslado;
                $oGuia_Venta->punto_partida=$punto_partida;
                $oGuia_Venta->punto_llegada=$punto_llegada;
                $oGuia_Venta->empresa_transporte=$razon_social_transportista;
                $oGuia_Venta->salida_ID=$salida_ID;
                $oGuia_Venta->correlativos_ID=$correlativos_ID;
                $oGuia_Venta->ver_descripcion=$ver_descripcion;
                $oGuia_Venta->ver_componente=$ver_componente;
                $oGuia_Venta->ver_adicional=$ver_adicional;
                $oGuia_Venta->ver_serie=$ver_serie;
                $oGuia_Venta->incluir_obsequios=$incluir_obsequios;
                $oGuia_Venta->motivo_traslado_ID=$motivo_traslado_ID;
                $oGuia_Venta->descripcion_motivo=$descripcion_motivo;
                $oGuia_Venta->peso_bruto_total=$peso_bruto_total;
                $oGuia_Venta->modalidad_traslado_ID=$modalidad_traslado_ID;
                $oGuia_Venta->ruc_transportista=$ruc_transportista;
                $oGuia_Venta->razon_social_transportista=$razon_social_transportista;
                $oGuia_Venta->nro_placa_vehiculo=$nro_placa_vehiculo;
                $oGuia_Venta->nro_documento_conductor=$nro_documento_conductor;
                $oGuia_Venta->distrito_ID_partida=$distrito_ID_partida;
                $oGuia_Venta->distrito_ID_llegada=$distrito_ID_llegada;
                if (isset($guia)){
                    $contador=$oGuia_Venta->actualizar();
                }else{
                    $contador=$oGuia_Venta->insertar();
                }
                
            }
            
            
            
            
            $mensaje=$oGuia_Venta->getMessage;
            $resultado=1;
            $oGuia_Venta->dtVehiculo=vehiculo::getGrid('',-1,-1,'descripcion asc');
            $oGuia_Venta->dtChofer=chofer::getGrid('',-1,-1,'pe.apellido_paterno asc, pe.apellido_materno asc, pe.nombres asc');
            $dtPartida=distrito::getUbigeo($distrito_ID_partida,-1,-1);
            $oGuia_Venta->dtDepartamento=departamento::getOpciones($dtPartida[0]["departamento_ID"]);
            $oGuia_Venta->dtProvincia=provincia::getOpciones($dtPartida[0]["provincia_ID"],$dtPartida[0]["departamento_ID"]);
            $oGuia_Venta->dtDistrito=distrito::getOpciones($dtPartida[0]["ID"],$dtPartida[0]["provincia_ID"]); 

            $oGuia_Venta->dtMotivo_Traslado=motivo_traslado::getGrid("ID in (1,2)");
            $oGuia_Venta->dtModalidad_Traslado=modalidad_traslado::getGrid();
            
            $dtFactura_Venta=factura_venta::getGrid('salida_ID='.$salida_ID,-1,-1,'ID asc');
            $oGuia_Venta->dtFactura_Venta=$dtFactura_Venta;
            $dtLlegada=distrito::getUbigeo($distrito_ID_llegada,-1,-1);
            $oGuia_Venta->dtDepartamento_llegada=departamento::getOpciones($dtLlegada[0]["departamento_ID"]);
            $oGuia_Venta->dtProvincia_llegada=provincia::getOpciones($dtLlegada[0]["provincia_ID"],$dtLlegada[0]["departamento_ID"]);
            $oGuia_Venta->dtDistrito_llegada=distrito::getOpciones($dtLlegada[0]["ID"],$dtLlegada[0]["provincia_ID"]); 

            $oGuia_Venta->dtSerie=tipo_comprobante::getComprobantes($tipo_documento, "guia_remision", $oGuia_Venta->correlativos_ID,0,"series");        
            
        }catch(Exception $ex){
          $resultado=-1;
          $mensaje=$ex->getMessage();
        }
       

        $GLOBALS['oGuia_Venta']=$oGuia_Venta;
        $GLOBALS['oOrden_Venta']=$oSalida;
        $GLOBALS['mensaje']=$mensaje;
        $GLOBALS['resultado']=$resultado;
    }
    function post_ajaxOrden_Venta_Electronico_Mantenimiento_Guia_Eliminar(){
        require ROOT_PATH.'models/guia_venta.php';
        $resultado=0;
        $mensaje="";
        try{
            $oGuia_Venta=guia_venta::getByID($ID);
            if(!isset($oGuia_Venta)){
                throw new Exception("No existe el registro.");
            }
            $oGuia_Venta->usuario_mod_id=$_SESSION['usuario_ID'];
            $validar=$oGuia_Venta->eliminar();
            if($oGuia_Venta->eliminar()==-2) {
                $resultado=-2;
                $mensaje="No se puede eliminar tiene registros.";
            }else{
                $resultado=1;
                $mensaje="Se eliminó correctamente.";
            }
        }catch(Exception $ex){
            $resultado=-1;
            $mensaje=utf8_encode(mensaje_error);
            log_error(__FILE__, "salidaController.post_ajaxOrden_Venta_Electronico_Mantenimiento_Guia_Eliminar", $ex->getMessage());
        }
        $retornar=array("resultado"=>$resultado,"mensaje"=>$mensaje);
        echo json_encode($retornar);
    }
    function get_Resumen_Diario_Mantenimiento(){
        require ROOT_PATH.'models/estado.php';
        require ROOT_PATH.'models/moneda.php';
        require ROOT_PATH.'models/salida.php';
        require ROOT_PATH.'models/cliente.php';
        
        global $returnView;
        $returnView=true;
        
        $dtEstado=estado::getGrid('tabla="salida"');
        $dtMoneda=moneda::getGrid();
        $dtCliente=cliente::getGrid("",-1,-1,"clt.razon_social asc");
        
        $GLOBALS['dtEstado']=$dtEstado;
        $GLOBALS['dtMoneda']=$dtMoneda;
        $GLOBALS['dtPerido']=salida::getPeriodos();
        $GLOBALS['dtCliente']=$dtCliente;
        
    }
    function post_ajaxResumen_Diario_Mantenimiento() {
        require ROOT_PATH.'models/resumen_diario.php';
        
        try{
            
            
           $dt=resumen_diario::getTabla();
           /*if(count($dtSalida)==0){
              $dtSalida=array();
            }*/
           echo(json_encode($dt, JSON_NUMERIC_CHECK)); 
        }catch(Exception $ex){
            //echo mensaje_error;
            $error=array("error_sistema"=>utf8_encode(mensaje_error));
            echo(json_encode($error));
            log_error(__FILE__, "salidaController.post_ajaxResumen_Diario_Mantenimiento", $ex->getMessage());
           
        }
    }
    function get_Resumen_Diario_Mantenimiento_Nuevo(){
        require ROOT_PATH . 'models/tipo.php';
        require ROOT_PATH . 'models/resumen_diario.php';
        global  $returnView_float;
        $returnView_float=true;
        
        try{
            $oResumen_Diario=new resumen_diario();
           
            $dtTipo=tipo::getGrid("tabla='resumen_diario'");
            $oResumen_Diario->dtTipo=$dtTipo;
            $oResumen_Diario->FechaEmision=date('d/m/Y');
            $oResumen_Diario->FechaReferencia=date('d/m/Y');
            $GLOBALS['oResumen_Diario']=$oResumen_Diario;
        //$listaproducto=salida_detalle::getFilasDetalleComprobante(814);
        }catch(Exception $ex){
            $GLOBALS['resultado']=-1;
            $GLOBALS['mensaje']=utf8_encode(mensaje_error);
            log_error(__FILE__,"salidaController.get_Orden_Venta_Electronico_Mantenimiento_Comprobante_Nuevo",$ex->getMessage());
        }
        
        
    }
    function post_Resumen_Diario_Mantenimiento_Nuevo(){
        require ROOT_PATH . 'models/tipo.php';
        require ROOT_PATH . 'models/resumen_diario.php';
        global  $returnView_float;
        $returnView_float=true;
        $FechaEmision=$_POST['txtFechaEmision'];
        $FechaReferencia=$_POST['txtFechaReferencia'];
        $tipo_ID=$_POST['selTipo'];
        $estado_ID=(isset($_POST['ckGenerar']))?102:101;
        $documentos_IDs=$_POST['documentos_IDs'];
        try{
            $oResumen_Diario=new resumen_diario();
            $oResumen_Diario->FechaEmision=$FechaEmision;
            $oResumen_Diario->FechaReferencia=$FechaReferencia;
            $oResumen_Diario->tipo_ID=$tipo_ID;
            $oResumen_Diario->estado_ID=$estado_ID;
            $oResumen_Diario->usuario_id=$_SESSION['usuario_ID'];
            $oResumen_Diario->documentos_IDs=$documentos_IDs;
            $ID=$oResumen_Diario->insertar();
            if($ID>0){
               $dt= EnviarResumenSUNAT($ID);
               //print_r($dt);
               if(count($dt)>0){
                   if($dt["resultado"]=="1"){
                    $GLOBALS['resultado']=1;
                    $GLOBALS['mensaje']="El resumen se envió corretamente.";
                   }else{
                       $GLOBALS['resultado']=2;
                        $GLOBALS['mensaje']="Hubo un error en el envío del resumen diario.";
                   }
               }
                
            }else{
                $GLOBALS['resultado']=2;
                $GLOBALS['mensaje']="Hubo un error en el envío del resumen diario.";
            }
            
        //$listaproducto=salida_detalle::getFilasDetalleComprobante(814);
        }catch(Exception $ex){
            $GLOBALS['resultado']=-1;
            $GLOBALS['mensaje']=utf8_encode(mensaje_error);
            log_error(__FILE__,"salidaController.get_Orden_Venta_Electronico_Mantenimiento_Comprobante_Nuevo",$ex->getMessage());
        }
        $dtTipo=tipo::getGrid("tabla='resumen_diario'");
            $oResumen_Diario->dtTipo=$dtTipo;
            $GLOBALS['oResumen_Diario']=$oResumen_Diario;
        
    }
    function post_ajaxCargarFilarDocumetos(){
        require ROOT_PATH . 'models/resumen_diario.php';
        $tipo_ID=$_POST['selTipo'];
        //$fecha_emision= FormatTextToDate($_POST['txtFechaReferencia'], 'Y-m-d');
        $fecha_emision= FormatTextToDate($_POST['txtFechaReferencia'], 'Y-m-d');
        $filas="";
        
        $resultado=0;
        try{
            $filas=utf8_encode(resumen_diario::getFilasDocumentos($tipo_ID,$fecha_emision));
            $resultado=1;
        }catch(Exception $ex){
            $resultado=-1;
            $filas=mensaje_error;
            log_error(__FILE__, "salidaController.post_ajaxCargarFilarDocumetos", $ex->getMessage());
        }
        
        $retornar=array("resultado"=>$resultado,"filas"=>$filas);
        echo(json_encode($retornar));
        
    }
    
    function EnviarResumenSUNAT($ID) {
        if (!class_exists("resumen_diario")){
            require ROOT_PATH.'models/resumen_diario.php';       
        }
        require ROOT_PATH.'models/resumen_diario_documentos.php';
        require ROOT_PATH.'models/resumen_diario_sunat.php';
        require_once('include/URL_API.php');
        $new = new api_SUNAT();
        try {
           
        $oResumen_Diario=resumen_diario::getByID($ID);
        
        if (!isset($oResumen_Diario)) {
            throw new Exception("No existe el resumen.");
        }
        $dt=resumen_diario_documentos::getGrid("resumen_diario_ID=".$ID);
        
        if(count($dt)==0){
            throw new Exception("El resumen no tiene comprobantes registrados.");
        }

        $DocumentoDetalle = array();
         $param_emisor = $new->getParamEmisor($oResumen_Diario->empresa_ID);
       
        foreach($dt as $item){
            $DocumentoDetalle[] = array (
                "IdDocumento"=> $item['IdDocumento'],
                "TipoDocumentoReceptor"=> $item['TipoDocumentoReceptor'],
                "NroDocumentoReceptor"=> $item['NroDocumentoReceptor'],
                "CodigoEstadoItem"=> $item['CodigoEstadoItem'],
                "DocumentoRelacionado"=> $item['DocumentoRelacionado'],
                "TipoDocumentoRelacionado"=> $item['TipoDocumentoRelacionado'],
                "CorrelativoInicio"=> $item['CorrelativoInicio'],
                "CorrelativoFin"=> $item['CorrelativoFin'],
                "Moneda"=> $item['Moneda'],
                "TotalVenta"=> $item['TotalVenta'],
                "TotalDescuentos"=> $item['TotalDescuentos'],
                "TotalIgv"=> $item['TotalIgv'],
                "TotalIsc"=> $item['TotalIsc'],
                "TotalOtrosImpuestos"=> $item['TotalOtrosImpuestos'],
                "Gravadas"=> $item['Gravadas'],
                "Exoneradas"=> $item['Exoneradas'],
                "Inafectas"=> $item['Inafectas'],
                "Exportacion"=> $item['Exportacion'],
                "Gratuitas"=> $item['Gratuitas'],
                "Id"=> $item['identificador'],
                "TipoDocumento"=> $item['TipoDocumento'],
                "Serie"=> $item['Serie']
            ); 
        }
        $data = array (
            'Resumenes'=>$DocumentoDetalle,
            "IdDocumento"=>$oResumen_Diario->IdDocumento,
            "FechaEmision"=>$oResumen_Diario->FechaEmision,
            "FechaReferencia"=>$oResumen_Diario->FechaReferencia,
            "Emisor"=>$param_emisor['Emisor']
        );
       print_r(json_encode($data));
        $carpeta="resumen_diario";
        $FechaRespuesta = strftime( "%Y-%m-%d-%H-%M-%S", time());
        
        $resultado_GResumen = $new->sendPostCPE(json_encode($data),'GenerarResumenDiario/v2');
        $data_GResumen = json_decode($resultado_GResumen);
        $array_sunat=array();
      if ($data_GResumen->Exito==true) {

        $firma=array (
            'CertificadoDigital' => $param_emisor["Certificado"],
            'PasswordCertificado' => $param_emisor["PasswordCertificado"],
            'TramaXmlSinFirma' => $data_GResumen->TramaXmlSinFirma,
            'UnSoloNodoExtension' => true,
        );
        
        $resultado_firma = $new->sendPostCPE(json_encode($firma),'Firmar');
        $data_firma = json_decode($resultado_firma);
        if ($data_firma->Exito==true) {
           
          $nombreArchivo = $data['IdDocumento'].'.xml';
          
          $new->EscribirArchivoXML($nombreArchivo,$data_firma->TramaXmlFirmado,$carpeta);
            $enviar_sunat=array (
                'TramaXmlFirmado' => $data_firma->TramaXmlFirmado,
                'Ruc' => $param_emisor["RUC"],
                'UsuarioSol' => $param_emisor["UsuarioSol"],
                'ClaveSol' => $param_emisor["ClaveSol"],
                'IdDocumento' => $data['IdDocumento'],
                'TipoDocumento' => "03",
                'EndPointUrl' => $param_emisor["UrlSunat"],
            );
            //print_r(json_encode($enviar_sunat));
          $data_sunat = $new->sendPostCPE(json_encode($enviar_sunat),'EnviarResumen');
          //print_r(json_encode($data_sunat));
          $data_sunat = json_decode($data_sunat);
          
          $sunat_respuesta='';
          if ($data_sunat->Exito==true) {

            $oResumen_Diario->estado_ID=103;//Estado emitido electronico;
            $oResumen_Diario->usuario_mod_id=$_SESSION['usuario_ID'];  
            $oResumen_Diario->actualizar();
            $sunat_respuesta = "";
            $new->EscribirArchivoCDR($data_sunat->NombreArchivo.'.zip',$data_firma->TramaXmlFirmado,$carpeta);
            $mensaje="El resumen diario se envió correctamente a la SUNAT.";
            $resultado=1;
            $array_sunat=json_encode($data_sunat);
            //echo json_encode($resultado_sunat);
          }else{
            $mensaje="El resumen no se envió correctamente, no se creó el archivo CDR.";
            $resultado=-1;
            $array_sunat=json_encode($data_sunat);
            
            $oResumen_Diario->estado_ID=104;//Estado error de envío electronico;
            $oResumen_Diario->usuario_mod_id=$_SESSION['usuario_ID'];  
            $oResumen_Diario->actualizar();
          }
          
            $oResumen_Diario_Sunat=new resumen_diario_sunat();
            $oResumen_Diario_Sunat->resumen_diario_ID=$ID;
            $oResumen_Diario_Sunat->fecha_generacion=$FechaRespuesta;
            $oResumen_Diario_Sunat->fecha_respuesta=$FechaRespuesta;
            $oResumen_Diario_Sunat->hash=$data_firma->ResumenFirma;
            $oResumen_Diario_Sunat->nombre_archivo=$data_sunat->NombreArchivo;
            $oResumen_Diario_Sunat->xml_firmado=$data_firma->TramaXmlFirmado;
            $oResumen_Diario_Sunat->representacion_impresa='';
            $oResumen_Diario_Sunat->estado_envio=1;
            $oResumen_Diario_Sunat->codigo_estado="";
            $oResumen_Diario_Sunat->descripcion_estado=FormatTextSave($sunat_respuesta);
            $oResumen_Diario_Sunat->cdr_sunat = "";
            $oResumen_Diario_Sunat->NroTicket=$data_sunat->NroTicket;
            $oResumen_Diario_Sunat->usuario_id=$_SESSION['usuario_ID'];
            $oResumen_Diario_Sunat->insertar();

        } else {
            $nombreArchivo = $data['IdDocumento'];
            $oResumen_Diario_Sunat=new resumen_diario_sunat();
            $oResumen_Diario_Sunat->resumen_diario_ID=$ID;
            $oResumen_Diario_Sunat->fecha_generacion=$FechaRespuesta;
            $oResumen_Diario_Sunat->fecha_respuesta=$FechaRespuesta;
            $oResumen_Diario_Sunat->hash=$data_firma->ResumenFirma;
            $oResumen_Diario_Sunat->nombre_archivo=$nombreArchivo;
            $oResumen_Diario_Sunat->xml_firmado=$data_firma->TramaXmlFirmado;
            $oResumen_Diario_Sunat->representacion_impresa='';
            $oResumen_Diario_Sunat->estado_envio=0;
            $oResumen_Diario_Sunat->codigo_estado="";
            $oResumen_Diario_Sunat->descripcion_estado="Ocurrió un error al firmar la trama xml";
            $oResumen_Diario_Sunat->cdr_sunat="";
            $oResumen_Diario_Sunat->usuario_id=$_SESSION['usuario_ID'];
            $oResumen_Diario_Sunat->insertar();
            $oResumen_Diario->estado_ID=104;//Estado error de envío electronico;
            $oResumen_Diario->usuario_mod_id=$_SESSION['usuario_ID'];  
            $oResumen_Diario->actualizar();
          $resultado=-1;
          $mensaje="El resumen no se envió a la SUNAT, hubo un error al firmar la trama xml.";
          $array_sunat=json_encode($resultado_firma);
        }

      }else {
          $mensaje="El resumen no se envió a la SUNAT, hubo un error en el servicio";
          $resultado=-1;
      }

    } catch (Exception $ex) {
        $resultado=-1;
        log_error(__FILE__,"salidaController.EnviarResumenSUNAT",$ex->getMessage());
        $mensaje=$ex->getMessage();

    }
    
    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje,'array_sunat'=>$array_sunat);
   return $retornar;

    //echo json_encode($retornar);
}

//Comunicación de baja de comprobante
    function get_Comunicacion_Baja_Mantenimiento() {
        global $returnView;
        $returnView = true;
    }
    function post_ajaxComunicacion_Baja_Mantenimiento() {
        require ROOT_PATH . 'models/comunicacion_baja.php';
        require ROOT_PATH . 'controls/funcionController.php';
        $buscar = trim($_POST['txtBuscar']);
        $tipo_comprobante_ID=$_POST['selTipoComprobante'];
        $paginaActual = $_POST['num_page'] == 0 ? 1 : $_POST['num_page'];
        $cantidadMostrar = ($_POST['txtMostrar'] == ''||$_POST['txtMostrar'] ==0) ? 30 : $_POST['txtMostrar'];
        $txtOrden = $_POST['txtOrden'];
        $orden_tipo = 'DESC';
        $orden_class = 'imgOrden-desc';
        if (isset($_POST['chkOrdenASC'])) {
            $orden_class = 'imgOrden-asc';
            $orden_tipo = 'ASC';
        }
        switch ($txtOrden) {
            
            case 1:
                 $orden = 'cb.IdDocumento ' . $orden_tipo;
                break;
            case 2:
                $orden = 'cb.FechaEmision ' . $orden_tipo;

                break;
            case 3:
                $orden = 'cb.FechaReferencia ' . $orden_tipo;
                break;
            case 4:
                $orden = 'cbc.Correlativo ' . $orden_tipo;
                    break;
            case 5:
                $orden = 'cb.MotivoBaja ' . $orden_tipo;
                    break;
            case 6:
                $orden = 'es.nombre ' . $orden_tipo;
                    break;
            default:
            $orden = 'ID ' . $orden_tipo;
            break;
        }
       /* if(trim($codigo)!=""){
            $filtro= "empresa_ID=".$_SESSION['empresa_ID']. " and ID=".$codigo;
        }else{
           $filtro = 'empresa_ID='.$_SESSION['empresa_ID'].' and upper(concat(placa," ",marca)) like "%' . str_replace(' ', '%', strtoupper(FormatTextSave($buscar))) . '%"';
        }*/
        $filtro="";
        //---------------------------------------					 
        $resultado = '<table id="websendeos" class="grid table table-hover table-teal table-bordered"><thead><tr>';
        $resultado.='<th class="text-center">N°</th>';
        $resultado.='<th  class="thOrden" onclick="fncOrden(1);">Identificador' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
        $resultado.='<th  class="thOrden" onclick="fncOrden(2);">Fecha emisión' . (($txtOrden == 2 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
        $resultado.='<th  class="thOrden" onclick="fncOrden(3);">Fecha Comprobante' . (($txtOrden == 3 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
        $resultado.='<th  class="thOrden" onclick="fncOrden(4);">Comprobante' . (($txtOrden == 4 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
        $resultado.='<th  class="thOrden" onclick="fncOrden(5);">Motivo' . (($txtOrden == 5 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
        $resultado.='<th  class="thOrden" onclick="fncOrden(6);">Estado' . (($txtOrden == 6 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
        $resultado.='<th>Opción</th>';
        $resultado.='</tr></thead>';
        $resultado.='<tbody>';
        $colspanFooter = 8;
        try {
            $cantidadMaxima = comunicacion_baja::getCount($filtro);
            $dt = comunicacion_baja::getGrid($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
            $rows = count($dt);
            $i=($paginaActual-1)*$cantidadMostrar+1;
            foreach ($dt as $item) {

                $resultado.='<tr class="tr-item">';
                $resultado.='<td class="text-center">'.$i.'</td>';
                $resultado.='<td class="text-center">' . $item['IdDocumento']  . '</td>';
                $resultado.='<td class="text-center">' . $item['FechaEmision'] . '</td>';
                $resultado.='<td class="text-center">' . $item['FechaReferencia'] . '</td>';
                $resultado.='<td class="text-center">' . $item['documento'] . '</td>';
                $resultado.='<td class="text-center">' . $item['MotivoBaja'] . '</td>';
                $resultado.='<td class="tdLeft">' . $item['estado'] . '</td>';
                $botones=array();
               // array_push($botones,'<a onclick="fncEditar(' . $item['ID'] . ');" title="Editar baja"><span class="glyphicon glyphicon-pencil"></span> Editar</a>');	
                if($item['estado_ID']==109||$item['estado_ID']==111){
                    array_push($botones,'<a onclick="modal.confirmacion(&#39;El proceso es irreversible, esta seguro de enviar la comunicación de baja a la SUNAT.&#39;,&#39;SUNAT&#39;,fncEnviarSUNAT,&#39;' . $item['ID'] . '&#39;);" title="Enviar comunicación de baja a la SUNAT"><i class="fa fa-arrow-right"></i>Enviar SUNAT</a>');
                }
               array_push($botones,'<a onclick="modal.confirmacion(&#39;El proceso es irreversible, esta seguro de eliminar el registro.&#39;,&#39;Eliminar Baja&#39;,fncEliminar,&#39;' . $item['ID'] . '&#39;);" title="Eliminar Documento de baja"><span class="glyphicon glyphicon-trash"></span>Eliminar</a>');
                
                $resultado.='<td class="btnAction" >'.(($item['estado_ID']!=110)?extraerOpcion($botones):"")."</td>";
                $resultado.='</tr>';
                $i++;
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
    function get_Comunicacion_Baja_Mantenimiento_Nuevo() {
        require ROOT_PATH . 'models/comunicacion_baja.php';
        require ROOT_PATH . 'models/estado.php';
        global $returnView_float;
        $returnView_float = true;
        $oComunicacion_Baja = new comunicacion_baja();
        $dtEstado=estado::getGrid("est.tabla='comunicacion_baja'",-1,-1,"est.orden asc");
        $oComunicacion_Baja->ID=0;
        $oComunicacion_Baja->dtEstado=$dtEstado;
        $GLOBALS['oComunicacion_Baja'] = $oComunicacion_Baja;
        

    }

    function post_Comunicacion_Baja_Mantenimiento_Nuevo() {
        require ROOT_PATH . 'models/comunicacion_baja.php';
        global $returnView_float;
        $returnView_float = true;
        $ID=$_POST['ID'];
        $FechaEmision=$_POST['txtFechaEmision'];
        $FechaReferencia=$_POST['txtFechaReferencia'];
        $motivo=$_POST['txtMotivo'];
        $generar=1;
        $estado_ID=($generar==0)? 108:109;
        $documentos_IDs=$_POST['documentos_IDs'];
        $oComunicacion_Baja = new comunicacion_baja();
        $mensaje="";
        $retorna=0;
        try {
            $oComunicacion_Baja->FechaEmision=$FechaEmision;
            $oComunicacion_Baja->FechaReferencia=$FechaReferencia;
            $oComunicacion_Baja->estado_ID=$estado_ID;
            $oComunicacion_Baja->MotivoBaja=$motivo;
            $oComunicacion_Baja->documentos=$documentos_IDs;
            $oComunicacion_Baja->usuario_id=$_SESSION['usuario_ID'];
            $retorna=$oComunicacion_Baja->insertar();
            $mensaje="Se guardó correctamente";
            
            if ($retorna<=0) {
                throw new Exception("Ocurrió un error al retornar los registros.");
            }
            $oComunicacion_Baja1=comunicacion_baja::getByID($retorna);
            $resultado = 1;
            $mensaje = $mensaje;
            
        } catch (Exception $ex) {
            $resultado = -1;
            $mensaje = utf8_encode(mensaje_error);
            log_error(__FILE__, "post_Comunicacion_Baja_Mantenimiento_Nuevo", $ex->getMessage());
        }
        
        $GLOBALS['oComunicacion_Baja'] = $oComunicacion_Baja1;
        $GLOBALS['resultado']=$resultado;
        $GLOBALS['mensaje']=$mensaje;
    }

    function post_ajaxCargarFilarDocumetosBjas(){
            require ROOT_PATH . 'models/comunicacion_baja.php';
            $facturas=(isset($_POST['ckFacturas']))? 1:0;
            $nota_credito=(isset($_POST['ckNota_Credito']))? 1:0;
            $nota_debito=(isset($_POST['ckNota_Debito']))? 1:0;
            
            $ID=$_POST['ID'];
            $filas="";

            $resultado=0;
            try{
                $filas=utf8_encode(comunicacion_baja::getFilasDocumentos($facturas,$nota_credito,$nota_debito,$ID));
                $resultado=1;
            }catch(Exception $ex){
                $resultado=-1;
                $filas=mensaje_error;
                log_error(__FILE__, "salidaController.post_ajaxCargarFilarDocumetosBjas", $ex->getMessage());
            }

            $retornar=array("resultado"=>$resultado,"filas"=>$filas);
            echo(json_encode($retornar));

        }

    function post_ajaxEnviarComunicacionSUNAT() {
        require ROOT_PATH.'models/comunicacion_baja.php';
        require ROOT_PATH.'models/comunicacion_baja_documentos.php';
        require ROOT_PATH.'models/comunicacion_baja_sunat.php';
        require ROOT_PATH.'include/facturacion_electronica/transaccion_documentos.php';
        require ROOT_PATH.'models/factura_venta.php';
        require ROOT_PATH.'models/tabla_movimiento.php';
        $id=$_POST['id'];
        $transacion = new transaccion_documentos();
        try {
            $oComunicacion_Baja=comunicacion_baja::getByID($id);
            if (!isset($oComunicacion_Baja)) {
                throw new Exception("No existe la comunicación de baja.");
            }
            if($oComunicacion_Baja->estado_ID==110){
                throw new Exception("La comunicación de baja ya fue enviado anteriormente.");
            }
            if($oComunicacion_Baja->estado_ID==108){
                throw new Exception("La comunicación de baja debe ser generado antes de enviarlo a la SUNAT.");
            }
            $dt=comunicacion_baja_documentos::getGrid("comunicacion_baja_ID=".$id);
            if(count($dt)==0){
                throw new Exception("La comunicación de baja no tiene documentos registrados.");
            }
            $bajas=array();
            $i=1;
            foreach($dt as $doc){
                $bajas[]=array(
                    'Correlativo'=>$doc['Correlativo'],
                    'MotivoBaja'=>$oComunicacion_Baja->MotivoBaja,
                    'Id'=>$i,
                    'TipoDocumento'=>$doc['TipoDocumento'],
                    'Serie'=>$doc['Serie']
                );
                $i++;
            }
            $param_emisor = $transacion->getParamEmisor($_SESSION['empresa_ID']);
            $data=array(
                'Bajas'=>$bajas,
                'IdDocumento'=>$oComunicacion_Baja->IdDocumento,
                'FechaEmision'=>FormatTextToDate($oComunicacion_Baja->FechaEmision,'Y-m-d'),
                'FechaReferencia'=>FormatTextToDate($oComunicacion_Baja->FechaReferencia,'Y-m-d'),
                'Emisor'=>$param_emisor['Emisor']

            );
        $fecha_generacion=date('Y-m-d H:m:s');
        $transacion->array_documento=$data;
        $transacion->documento="comunicacion_baja";
        $ruta=$transacion->generar_xml();
        $ruta_xml_firmado=$transacion->firmar_documento($ruta,"comunicacion_baja");
        //echo $ruta_xml_firmado;
        $ticket=$transacion->enviar_documento($ruta_xml_firmado,"comunicacion_baja","sendSummary");
        if(isset($ticket)&&$ticket!=""){
            $oComunicacion_Baja_Sunat=new comunicacion_baja_sunat();
            $oComunicacion_Baja_Sunat->comunicacion_baja_ID=$oComunicacion_Baja->ID;
            $oComunicacion_Baja_Sunat->fecha_generacion=$fecha_generacion;
            $oComunicacion_Baja_Sunat->fecha_respuesta=date('Y-m-d H:m:s');
            $oComunicacion_Baja_Sunat->nombre_archivo=$ruta;
            $oComunicacion_Baja_Sunat->descripcion_resultado="Se envió correctamente";
            $oComunicacion_Baja_Sunat->xml_firmado="";
            $oComunicacion_Baja_Sunat->ticket=$ticket;
            $oComunicacion_Baja_Sunat->usuario_id=$_SESSION['usuario_ID'];
            $oComunicacion_Baja_Sunat->insertar();
            
            foreach($dt as $item){
                if($item['tabla']=='factura_venta'){
                    $oFactura_Venta1=factura_venta::getByID($item['documento_ID']);
                    $oFactura_Venta1->estado_ID=107;//Estado dado de baja;
                    $oFactura_Venta1->usuario_mod_id=$_SESSION['usuario_ID'];  
                    $oFactura_Venta1->actualizar();
                    $oTabla_Movimiento=new tabla_movimiento();
                    $oTabla_Movimiento->tabla_ID=$item['documento_ID'];
                    $oTabla_Movimiento->tabla=$item['tabla'];
                    $oTabla_Movimiento->estado_ID=107;
                    $oTabla_Movimiento->fecha=date('Y-m-d H:i:s');
                    $oTabla_Movimiento->observacion="Factura electrónica dado de baja a SUNAT";
                    $oTabla_Movimiento->usuario_ID_creacion=$_SESSION['usuario_ID'];
                    $oTabla_Movimiento->empresa_ID=$_SESSION['empresa_ID'];
                    $oTabla_Movimiento->usuario_id=$_SESSION['usuario_ID'];
                    $oTabla_Movimiento->insertar();
                    
                    $oComunicacion_Baja->estado_ID=110;//Emitido a SUNAT
                    $oComunicacion_Baja->usuario_mod_id=$_SESSION['usuario_ID'];
                    $oComunicacion_Baja->actualizar();
                }
                if($item['tabla']=='comprobante_regula'){
                    $oComprobante_Regula=comprobante_regula::getByID($item['documento_ID']);
                    $oComprobante_Regula->estado_ID=112;//Estado dado de baja;
                    $oComprobante_Regula->usuario_mod_id=$_SESSION['usuario_ID'];  
                    $oComprobante_Regula->actualizar();

                }

            }
            $resultado=1;
            $mensaje="Se dió de baja correctamente";
        }else{
            $oComunicacion_Baja_Sunat=new comunicacion_baja_sunat();
            $oComunicacion_Baja_Sunat->comunicacion_baja_ID=$oComunicacion_Baja->ID;
            $oComunicacion_Baja_Sunat->fecha_generacion=$fecha_generacion;
            $oComunicacion_Baja_Sunat->fecha_respuesta=date('Y-m-d H:m:s');
            $oComunicacion_Baja_Sunat->nombre_archivo=$ruta;
            $oComunicacion_Baja_Sunat->descripcion_resultado="Ocurrió un error al enviar la comunicación de baja";
            $oComunicacion_Baja_Sunat->xml_firmado="";
            $oComunicacion_Baja_Sunat->ticket="";
            $oComunicacion_Baja_Sunat->usuario_id=$_SESSION['usuario_ID'];
            $oComunicacion_Baja_Sunat->insertar();
            $resultado=-1;
            $mensaje="No se envió la comunicación a la SUNAT.";
        }
        

        } catch (Exception $ex) {
            $resultado=-1;
            log_error(__FILE__,"salidaController.post_ajaxEnviarSUNAT",$ex->getMessage());
            $mensaje=$ex->getMessage();

        }

    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
    echo json_encode($retornar);
}
    function post_ajaxComunicacion_Baja_Mantenimiento_Eliminar($id){
        require ROOT_PATH.'models/comunicacion_baja.php';
        try{
           $obj=comunicacion_baja::getByID($id); 
           if(!isset($obj)){
               throw new Exception("No existe la comunicación de baja.");
           }
           $obj->usuario_mod_id=$_SESSION['usuario_ID'];
           if($obj->eliminar()==0){
               throw new Exception("No se eliminó ningún registro");
           }
           $resultado=1;
           $mensaje="Se eliminó correctamente";
        }catch(Exception $ex){
            $resultado=-1;
            $mensaje=$ex->getMessage();
            log_error(__FILE__,"salidaController.post_ajaxComunicacion_Baja_Mantenimiento_Eliminar",$ex->getMessage());
        }
        $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
        echo json_encode($retornar);
    }
