<?php	
    function post_ajaxListar_Producto(){
        require ROOT_PATH.'models/producto.php';
        $linea_ID=0;
        if(isset($_POST['selLinea'])){
             $linea_ID=$_POST['selLinea'];
        }
        $categoria_ID=0;
       if(isset($_POST['selCategoria'])){
           $categoria_ID=$_POST['selCategoria'];
       }
        
        $buscar=$_POST['txtBuscar'];
        $inicio=-1;
        $fin=-1;
        if(isset($_POST['IntCantidad'])&&$_POST['IntCantidad']>0){
            $inicio=0;
            $fin=$_POST['IntCantidad'];
        }
        
        $funcion='';
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
            $filtro.='upper(concat(pr.ID," ",pr.nombre)) like "%'.strtoupper(FormatTextSave($buscar)).'%"';
        }
        $dtProducto=producto::getGrid($filtro,$inicio,$fin,'pr.nombre asc');

        $i=1;
        $resultado='<ul class="list-group cbo-ul lista_click">';
        if(count($dtProducto)>0){			
            foreach($dtProducto as $iProducto){
                $resultado.='<li id="li_'.$i.'" class="list-group-item" ><span id="'.$iProducto['ID'].'" title="'.FormatTextViewHtml($iProducto['producto']).'">'.FormatTextViewHtml(sprintf("%'.05d",$iProducto['ID']).'-'.$iProducto['producto']).'</span></li>';
                $i++;
            }
        }
        $resultado.='</ul>';

        $mensaje='';

        $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje,'funcion'=>$funcion);
        echo json_encode($retornar);
}
    function post_ajaxListar_Producto_Listar(){
        require ROOT_PATH.'models/producto.php';
        require ROOT_PATH.'models/categoria.php';
        $producto_ID=$_POST['codigo'];
        $oProducto=producto::getByID($producto_ID);
        $categoria_ID=$oProducto->categoria_ID;
        $oCategoria=categoria::getByID($categoria_ID);
        $linea_ID=$oCategoria->linea_ID;
        $retornar=Array('valor1'=>$linea_ID,'valor2'=>$categoria_ID);
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
     
    $resultado='<ul id="detalle" class="list-group cbo-ul lista_click">';
    $i=1;
    if(count($dtCliente)>0){			
       foreach($dtCliente as $iCliente){

        $resultado.='<li id="li_'.$i.'" class="list-group-item lista_click"><span  id="'.$iCliente['ID'].'" title="'.$iCliente['ruc'].'" class="lista_click">'.$iCliente['ruc'].'-'.FormatTextViewHtml(strtoupper($iCliente['razon_social'])).'</span></li>';
        $i++;
       }
    }

     $resultado.='</ul>';

     $mensaje='';
     $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);
     echo json_encode($retornar);
   }
    function post_ajaxCbo_Cliente1(){
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
                 $resultado.='<li id="li_'.$i.'"><span  id="'.$iCliente['ID'].'" title="'.$iCliente['ruc'].'">'.$iCliente['ruc'].'-'.FormatTextViewHtml(strtoupper($iCliente['razon_social'])).'</span></li>';
            $i++;
            }
           
        }
     }
     $resultado.='</ul>';

     $mensaje='';
     $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);
     echo json_encode($retornar);
   }
    function mostrarNumeroCuentas($case,$moneda_ID,$oCotizacion,$oOrden_Venta){
        if(!class_exists('salida_numero_cuenta')){
           require ROOT_PATH.'models/salida_numero_cuenta.php'; 
        }
         if(!class_exists('cotizacion_numero_cuenta')){
           require ROOT_PATH.'models/cotizacion_numero_cuenta.php'; 
        }
        $dtNumero_Cuenta=numero_cuenta::getGrid();
        switch($case){
            case 1:
                $html='<table class="table table-default" id="tbnumero_cuenta" cellspacing="0">';
                $html.='<thead><tr>
                            <th>Banco</th>
                            <th>Número de cuenta</th>
                            <th>CCI</th>
                            <th>Op</th>
                        </tr></thead><tbody>';

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
                    $html.='<td style="text-align: center;"><div class="ckbox ckbox-theme"><input type="checkbox" id="cknumero_cuenta'. $value['ID'].'" name="cknumero_cuenta'.$value['ID'].'" '.$checked.' value="'.$value['ID'].'"><label for="cknumero_cuenta'. $value['ID'].'"></label></div></td>';
                    $html.='</tr>';

                }
                $html.='</tbody></table>';
            break;
            case 2:
                
                $html='<table class="table table-hover" id="tbnumero_cuenta" >';
                $html.='<thead><tr>
                            <th>Banco</th>
                            <th>Número de cuenta</th>
                            <th>CCI</th>
                            <th>Op</th>
                        </tr></thead> <tbody>';
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
                    if($oCotizacion!=null){
                        $dtCotizacion_Numero_Cuenta=cotizacion_numero_cuenta::getGrid('cotizacion_ID='.$oCotizacion->ID);
                        foreach($dtCotizacion_Numero_Cuenta as $item){
                            if($item['numero_cuenta_ID']==$value['ID']){
                                $checked="checked";
                            }
                        }
                    }
                    if($oOrden_Venta!=null){
                        $dtOrden_Venta_Numero_Cuenta=salida_numero_cuenta::getGrid('salida_ID='.$oOrden_Venta->ID);
                        foreach($dtOrden_Venta_Numero_Cuenta as $item){
                            if($item['numero_cuenta_ID']==$value['ID']){
                                $checked="checked";
                            }
                        }
                    }    

                    $html.='<td class="text-center"><div class="ckbox ckbox-theme"><input type="checkbox" '.$checked.' id="cknumero_cuenta'. $value['ID'].'" name="cknumero_cuenta'.$value['ID'].'" value="'.$value['ID'].'"><label for="cknumero_cuenta'. $value['ID'].'"></label></td>';
                    $html.='</tr>';

                }
                
                $html.='</tbody></table>';
            break;
        }
        return $html;
    }
    function retornar_tipo($componente, $adicional){
        
        $tipo_ID=1;
        switch([$componente,$adicional]){
            case ['0','0']:
                $tipo_ID=1;
                break;
            case ['1','0']:
                $tipo_ID=2;
                break;
            case ['1','1']:
                $tipo_ID=5;
                break;
            case ['0','1']:
                $tipo_ID=6;
                break;
        }
        return $tipo_ID;
    }
    function retornar_valores($tipo){
        $array=array("componente"=>'0','adicional'=>'0');
         switch($tipo){
            case 2:
                $array=array("componente"=>'1','adicional'=>'0');
                break;
            case 5:
                $array=array("componente"=>'1','adicional'=>'1');
                break;
            case 6:
                $array=array("componente"=>'0','adicional'=>'1');
                break;
            
        }
        return $array;
    }
    function getUltimoDiaMes($elAnio,$elMes) {
        return date("d",(mktime(0,0,0,$elMes+1,1,$elAnio)-1));
    }
    function getNombreMes($mesNumero){
        $mes="";
        $mesNumero=Ltrim($mesNumero,0);
        switch($mesNumero){
            case 1:
                $mes="Enero";
                break;
            case 2:
                $mes="Febrero";
                break;
            case 3:
                $mes="Marzo";
                break;
            case 4:
                $mes="Abril";
                break;
            case 5:
                $mes="Mayo";
                break;
            case 6:
                $mes="Junio";
                break;
            case 7:
                $mes="Julio";
                break;
            case 8:
                $mes="Agosto";
                break;
            case 9:
                $mes="Setiembre";
                break;
            case 10:
                $mes="Octubre";
                break;
            case 11:
                $mes="Noviembre";
                break;
            case 12:
                $mes="Diciembre";
                break;
        }
        return $mes;
    }
    function getMeses($inicio,$fin){
        $array_meses=array();
        for($i=$inicio;$i<=$fin;$i++){
            $array_mes=array("valor"=>$i,"nombre"=>getNombreMes($i));
            array_push($array_meses,$array_mes);
        }
        return $array_meses;
    }
    function getPeriodos($inicio,$fin){
        $array_periodos=array();
        for($i=$inicio;$i<=$fin;$i++){
            $array_periodo=array("valor"=>$i,"nombre"=>$i);
            array_push($array_periodos,$array_periodo);
        }
        return $array_periodos;
    }
    function getDiasMes($inicio,$mes,$periodo){
        $fecha="01-".$mes.'-'.$periodo;
        $dias_mes=date("t",strtotime( $fecha ));
        $array_dias=array();
        for($i=$inicio;$i<=$dias_mes;$i++){
            $array_dia=array("valor"=>$i,"nombre"=>$i);
            array_push($array_dias,$array_dia);
        }
        
        
        return $array_dias;
    }
    function paginacion($cantidadMaxima,$cantidadMostrar,$colspanFooter,$paginaActual){
    $resultado="";
    if ($cantidadMaxima > $cantidadMostrar && $cantidadMaxima > 0) {

            $resultado.='<tr><td id="tdPagination" colspan=' . $colspanFooter . ' >';
            $decimal = fmod($cantidadMaxima, $cantidadMostrar);

            if ($decimal > 0) {
                $cantidadPaginas = intval($cantidadMaxima / $cantidadMostrar) + 1;
            } else {
                $cantidadPaginas = intval($cantidadMaxima / $cantidadMostrar);
            }

            $Bloque = (intval($paginaActual / 10) + 1) * 10; //Sólo mostrará las 10 primeras páginas
            $paginaInicio = 1;
            $paginaFin = $Bloque;

            if ($paginaActual >= 10) {
                $paginaInicio = $Bloque - 10;
            }

            if ($paginaFin > $cantidadPaginas) {
                $paginaFin = $cantidadPaginas;
            }
            $resultado.='<ul class="pagination">';
            $resultado.='<li>';
            $resultado.='<a id="1" class="pagination-ini">&laquo;</a>';
            $resultado.='</li>';
            //$resultado.='<div  id=1 class="pagination pagination-ini" ><a title="Primero"><<</a></div>';
            //$resultado.='<div id="' . ($paginaActual > 1 ? $paginaActual - 1 : $paginaActual) . '" class="pagination pagination-prev" ><a title="Anterior"><</a></div>';
            $resultado.='<li  class="pagination-prev" ><a id="' . ($paginaActual > 1 ? $paginaActual - 1 : $paginaActual) . '" title="Anterior"><</a></li>';
            for ($i = $paginaInicio; $i <= $paginaFin; $i++) {
                if ($i == $paginaActual) {
                   // $resultado.='<div class="pagination">' . $i . '</div>';
                    $resultado.='<li class="active"><a>' . $i . '<span class="sr-only">"Actual"</span></a></li>';
                } else {
                   // $resultado.='<div id="' . $i . '" class="pagination"><a>' . $i . '</a></div>';
                    $resultado.='<li ><a id="' . $i . '" >' . $i . '</a></li>';
                }
            }
            //$resultado.='<div id="' . ($paginaActual < $cantidadPaginas ? $paginaActual + 1 : $paginaActual) . '" class="pagination pagination-next" ><a title="Siguiente">></a></div>';
            //$resultado.='<div id="' . $cantidadPaginas . '" class="pagination pagination-end" ><a title="Último">>></a></div>';

            $resultado.='<li  class="pagination-next" ><a id="' . ($paginaActual < $cantidadPaginas ? $paginaActual + 1 : $paginaActual) . '" title="Siguiente">></a></li>';
            $resultado.='<li  class="pagination-end" ><a id="' . $cantidadPaginas . '" title="Último">>></a></li>';
            $resultado.='</ul>';
            $resultado.='</td></tr>';
        }
        return $resultado;
}
    function post_ajaxGetArchivo(){
        $directorio = $_SERVER['DOCUMENT_ROOT'].'/files/imagenes/banner/';
        $gestor_dir = opendir($directorio);
        $archivos = '';
        while (false !== ($nombre_fichero = readdir($gestor_dir))) {
            $ficheros[] = $nombre_fichero;

            $rutaArchivo = DOMAIN_BASE.'/files/imagenes/banner/'.$nombre_fichero;
            $archivos .='<br><a target="_blank" href="'.$rutaArchivo.'" >'.$nombre_fichero.'</a>';

        }
        $resultado=1;

        $retornar = Array('resultado' => $resultado, 'archivos' => $archivos);
            //$retorn="<h1>Hola</h1>";

        echo json_encode($retornar);
    }
    function post_ajaxMain(){
        $dir_subida = $_SERVER['DOCUMENT_ROOT'].'/files/imagenes/banner/';
        $fichero_subido = $dir_subida . basename($_FILES['archivoDesarrolloHidrocalido']['name']);

        echo '<pre>';
        if (move_uploaded_file($_FILES['archivo']['tmp_name'], $fichero_subido)) {
            echo "El fichero es válido y se subió con éxito.\n".$_POST['parametro1'];
        } else {
            echo "¡Posible ataque de subida de ficheros!\n";
        }
        echo 'Más información de depuración:';
        print_r($_FILES);
        print "</pre>";
    }
    function post_ajaxCbo_Persona(){
        require ROOT_PATH.'models/persona.php';

        $buscar=trim($_POST['txtBuscar']);
        $filtro='';
        if($buscar!=""){
            $filtro="upper(concat(apellido_paterno,'',apellido_materno,'',nombres)) like '%".strtoupper(FormatTextSave($buscar))."%'";

        }
         $dtPersona=persona::getGrid($filtro,0,20,"apellido_paterno asc,apellido_materno asc, nombres asc");

         $resultado='<ul id="detalle" class="list-group cbo-ul">';
         $i=0;
         if(count($dtPersona)>0){			
            foreach($dtPersona as $iPersona){
               
                $resultado.='<li id="li_'.$i.'" class="list-group-item"><span  id="'.$iPersona['ID'].'" title="'.$iPersona['datos'].'">'.strtoupper($iPersona['datos']).'</span></li>';
                $i++;
            }
         }
         $resultado.='</ul>';
        $mensaje="";
         $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);
         echo json_encode($retornar);
   }
   
   
       function post_ajaxOption_Persona(){
        require ROOT_PATH.'models/persona.php';

        $id=$_POST['id'];
        try{
            $dtPersona=persona::getGrid('',-1,-1,"apellido_paterno asc,apellido_materno asc, nombres asc");
            $html="<option value='0'>--SELECCIONAR--</option>";
            foreach($dtPersona as $item){
                $html.="<option value='".$item['ID']."'>".FormatTextView(strtoupper($item['apellido_paterno']. ' '. $item['apellido_materno']. ' ' . $item['nombres']))."</option>";
            }
            $mensaje="";
            $resultado=1;
        }  catch (Exception $ex){
            $resultado=-1;
            $mensaje=$ex->getMessage();
        }
        
        $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje,'html'=>$html);
        echo json_encode($retornar);
   }
   
   
    function post_ajaxExtraerInformacionPersona(){
        require ROOT_PATH.'models/persona.php';
        $persona_ID=$_POST['id'];
        try {
            $oPersona=persona::getByID($persona_ID);
            $mesanje="";
        }catch(Exception $ex){
            $mesanje=$ex->getMessage();
        }
        
        $retornar=Array('oPersona'=>$oPersona,'mensaje'=>$mesanje);
        echo json_encode($retornar);
   }
    function post_ajaxSeleccionarMenu(){
        require ROOT_PATH.'models/producto.php';
        require ROOT_PATH.'models/categoria.php';
        $menu_ID=$_POST['id'];
        $_SESSION['menu_ID']=$menu_ID;
       
        $retornar=Array('resultado'=>$menu_ID);
        echo json_encode($retornar);
    }
    function post_ajaxCbo_Proveedor(){
        require ROOT_PATH.'models/proveedor.php';
    
        $buscar=trim($_POST['txtBuscar']);
        $filtro='';
        if($buscar!=""){
            $filtro="upper(concat(prv.ruc,'',prv.razon_social)) like '%".strtoupper(FormatTextSave($buscar))."%'";

        }
        $dtProveedor=proveedor::getGrid($filtro,0,20,"prv.razon_social asc");

        $resultado='<ul id="detalle" class="list-group cbo-ul lista_click">';
        $i=1;
        if(count($dtProveedor)>0){			
           foreach($dtProveedor as $iProveedor){

            $resultado.='<li id="li_'.$i.'" class="list-group-item lista_click"><span  id="'.$iProveedor['ID'].'" title="'.$iProveedor['ruc'].'" class="lista_click">'.$iProveedor['ruc'].'-'.FormatTextViewHtml(strtoupper($iProveedor['razon_social'])).'</span></li>';
            $i++;
           }
        }

         $resultado.='</ul>';

         $mensaje='';
         $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);
         echo json_encode($retornar);
   }
    function post_ajaxOption_Proveedor(){
        require ROOT_PATH.'models/proveedor.php';
    
        $buscar=trim($_POST['txtBuscar']);
        $filtro='';
        if($buscar!=""){
            $filtro="upper(concat(prv.ruc,'',prv.razon_social)) like '%".strtoupper(FormatTextSave($buscar))."%'";

        }
        $dtProveedor=proveedor::getGrid($filtro,0,20,"prv.razon_social asc");

        $resultado='<ul id="detalle" class="list-group cbo-ul lista_click">';
        $i=1;
        if(count($dtProveedor)>0){			
           foreach($dtProveedor as $iProveedor){

            $resultado.='<li id="li_'.$i.'" class="list-group-item lista_click"><span  id="'.$iProveedor['ID'].'" title="'.$iProveedor['ruc'].'" class="lista_click">'.$iProveedor['ruc'].'-'.FormatTextViewHtml(strtoupper($iProveedor['razon_social'])).'</span></li>';
            $i++;
           }
        }

         $resultado.='</ul>';

         $mensaje='';
         $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);
         echo json_encode($retornar);
   }
   function post_ajaxListar_Categorias(){
        require ROOT_PATH.'models/categoria.php';
       
        $linea_ID=$_POST['id'];
        $html="<option value='-1'>Ningún valor</option>";
        try{
            $dtCategoria=categoria::getGrid("ca.empresa_ID=".$_SESSION['empresa_ID']." and ca.linea_ID=".$linea_ID,-1,-1,"ca.nombre asc");
            $html="<option value='0'>--SELECCIONAR--</option>";
            foreach($dtCategoria as $item){
                $html.="<option value='".$item['ID']."'>".FormatTextView(strtoupper($item['nombre']))."</option>";
            }
            $mensaje="";
            $resultado=1;
        }  catch (Exception $ex){
            $resultado=-1;
            $mensaje=$ex->getMessage();
        }
        
        $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje,'html'=>$html);
        echo json_encode($retornar);
}
    function post_ajaxListar_Productos(){
        require ROOT_PATH . 'models/producto.php';
        $linea_ID=$_POST['id'];
        $categoria_ID=$_POST['id1'];
        $html="";
        $mensaje="";
        try {
            $filtro="";
            if($linea_ID!=""&&$linea_ID!=0){
               $filtro.=(($filtro!="")?" and ":"")."ca.linea_ID=".$linea_ID; 
            }
            if($categoria_ID!=""&&$categoria_ID!=0){
                
                $filtro.=(($filtro!="")?" and ":"")."pr.categoria_ID=".$categoria_ID;
            }
  
            $dtProducto=producto::getGrid($filtro,-1,-1,"pr.nombre asc");
            $html="<option value='0'>--SELECCIONAR--</option>";
            foreach($dtProducto as $item){
                $html.="<option value='".$item['ID']."'>".sprintf("%'.07d",$item['ID'])." - ".FormatTextView(strtoupper($item['producto']))."</option>";
            }
            $resultado=1;
        } catch (Exception $ex) {
            $resultado=-1;
            $mensaje=$ex->getMessage();
          
        }
        $retornar = Array('resultado'=>$resultado,'mensaje' => $mensaje,'html' => $html);
        //$retorn="<h1>Hola</h1>";

        echo json_encode($retornar);
    }
    function post_ajaxSeleccionar_Producto1(){
        require ROOT_PATH . 'models/producto.php';
        require ROOT_PATH . 'models/inventario.php';
        
        $producto_ID=$_POST['id'];
        $html="";
        $mensaje="";
        $stock=0;
        
        try {
            $oProducto=producto::getByID($producto_ID);
            if($oProducto==null){
                throw new Exception("No existe el producto");
            }
            $stock=inventario::getStock($producto_ID);
            
            $resultado=1;
        } catch (Exception $ex) {
            $resultado=-1;
            $mensaje=$ex->getMessage();
          
        }
        $retornar = Array('resultado'=>$resultado,'mensaje' => $mensaje,'stock' => $stock,'descripcion'=>FormatTextView($oProducto->descripcion));
        //$retorn="<h1>Hola</h1>";

        echo json_encode($retornar);
    }
     function post_ajaxExtraer_Notificacion(){
        require ROOT_PATH . 'models/web_chat_session.php';
        require ROOT_PATH . 'models/web_chat_session_mensaje.php';
        $contador=0;
        $html="";
        try {
           $dtChatSinleer=web_chat_session_mensaje::getGridChat("wm.estado_ID=88 and  ws.usuario_receptor_ID=".$_SESSION['usuario_ID'],"wm.web_chat_session_ID",-1,-1,"wm.ID desc");
           $contador=count($dtChatSinleer);
           foreach($dtChatSinleer as $item){
                $html.='<a href="message-detail.html" class="media">';
                $html.='<div class="pull-left"><img src="'.((trim($item['foto'])=="")?'../../include/img/usuario/user-secret-32.png':'../../files/foto_usuario/'.trim($item['foto'])).'" class="media-object img-circle" alt="John Kribo"/></div>';
                $html.='<div class="media-body">';
                $html.='<span class="media-heading">'.FormatTextView($item['remitente']).'</span>';
                $html.='<span class="media-text">'.FormatTextView($item['mensaje']).'</span>';
                $html.='<span class="media-meta"><i class="fa fa-reply"></i></span>';
                $html.='<span class="media-meta"><i class="fa fa-paperclip"></i></span>';
                $html.='<span class="media-meta pull-right">'.$item['fdc'].'</span>';
                $html.='</div>';
                $html.='</a>';
           }
           $html.=' <a href="#" class="media indicator inline">
                                                <span class="spinner">Load more messages...</span>
                                            </a>';
           
        } catch (Exception $ex) {
            $html.=$ex->getMessage();
            
          
        }
        $retornar = Array('contador'=>$contador,'html' => $html);
        

        echo json_encode($retornar);
    }
?>