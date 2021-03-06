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
        $dtNumero_Cuenta=numero_cuenta::getGrid("empresa_ID=".$_GET['empresa_ID']." and estado_ID=116");
        switch($case){
            case 1:
                $html='<table class="table table-primary" id="tbnumero_cuenta" cellspacing="0">';
                $html.='<thead><tr>
                            <th class="text-center">Banco</th>
                            <th class="text-center">Número de cuenta</th>
                            <th class="text-center">CCI</th>
                            <th class="text-center">Op</th>
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
                    /*
                    if($value['ID']==1||$value['ID']==2){
                        $checked="checked";
                    }*/
                    if($value['seleccionado']==1){
                       $checked="checked";  
                    }
                    $html.='<tr class="'.$class.'" style="display:'.$style.'">';
                    $html.='<td>'. FormatTextViewHtml($value['abreviatura']).'</td>';
                    $html.='<td>'. $value['numero'].'</td>';
                    $html.='<td>'. $value['cci'].'</td>';
                    $html.='<td class="text-center"><div class="ckbox ckbox-theme"><input type="checkbox" id="cknumero_cuenta'. $value['ID'].'" name="cknumero_cuenta'.$value['ID'].'" '.$checked.' value="'.$value['ID'].'"><label for="cknumero_cuenta'. $value['ID'].'"></label></div></td>';
                    $html.='</tr>';

                }
                $html.='</tbody></table>';
            break;
            case 2:
                
                $html='<table class="table table-hover table-primary" id="tbnumero_cuenta" >';
                $html.='<thead><tr>
                            <th class="text-center">Banco</th>
                            <th class="text-center">Número de cuenta</th>
                            <th class="text-center">CCI</th>
                            <th class="text-center">Op</th>
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
                    $resultado.='<li ><a id="' . $i . '">' . $i . '</a></li>';
                }
            }
            //$resultado.='<div id="' . ($paginaActual < $cantidadPaginas ? $paginaActual + 1 : $paginaActual) . '" class="pagination pagination-next" ><a title="Siguiente">></a></div>';
            //$resultado.='<div id="' . $cantidadPaginas . '" class="pagination pagination-end" ><a title="Último">>></a></div>';

            $resultado.='<li  class="pagination-next"><a id="' . ($paginaActual < $cantidadPaginas ? $paginaActual + 1 : $paginaActual) . '" title="Siguiente">></a></li>';
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
            $oPersona=persona::getByID1($persona_ID);
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
            
            //$dtCategoria=categoria::getGrid("ca.empresa_ID=".$_GET['empresa_ID']." and ca.linea_ID=".$linea_ID,-1,-1,"ca.nombre asc");
            $html="<option value='0'>TODOS</option>";
            $html.= utf8_encode(categoria::getOption($linea_ID,$_GET['empresa_ID']));
            /*foreach($dtCategoria as $item){
                $html.="<option value='".$item['ID']."'>".FormatTextView(strtoupper($item['nombre']))."</option>";
            }*/
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
    function post_ajaxListar_Productos1(){
        require ROOT_PATH . 'models/producto.php';
        $linea_ID=$_POST['id'];
        $categoria_ID=$_POST['id1'];
        $resultado=0;
        $mensaje="";
        $html="";
        try {
            
            $html=producto::getListaProducto($categoria_ID,$linea_ID);
            $resultado=1;
            
        } catch (Exception $ex) {
           $resultado=-1;
           $mensaje=$ex->getMessage();
           
          
        }
        $retornar=Array('resultado'=>$resultado,'html'=> $html,'mensaje'=>$mensaje);
        echo json_encode($retornar);
    }
    function post_ajaxSeleccionar_Producto1(){
        require ROOT_PATH . 'models/producto.php';
        require ROOT_PATH . 'models/categoria.php';
        require ROOT_PATH . 'models/linea.php';
        require ROOT_PATH . 'models/inventario.php';
        require ROOT_PATH . 'models/unidad_medida.php';
        $producto_ID=$_POST['id'];
        $html="";
        $mensaje="";
        $stock=0;
        $categoria_ID=0;
        $linea_ID=0;
        $unidad_medida="";
        $peso=0;
        try {
            $oProducto=producto::getByID($producto_ID);
            
            if($oProducto==null){
                throw new Exception("No existe el producto.");
            }
            $oUnidad_Medida=unidad_medida::getByID($oProducto->unidad_medida_ID);
            $peso=$oProducto->peso;
            $unidad_medida=$oUnidad_Medida->nombre;
            $codigo=$oProducto->codigo;
            $categoria_ID=$oProducto->categoria_ID;
            $oCategoria=categoria::getByID($categoria_ID);
            $linea_ID=$oCategoria->linea_ID;
            $stock=inventario::getStock($producto_ID);
            $dtCategoria=categoria::getGrid("ca.linea_ID=".$linea_ID,-1,-1,"ca.nombre");
            $html="<option value='0'>TODOS</option>";
            foreach($dtCategoria as $item){
                $html.="<option value='".$item['ID']."' ".(($categoria_ID==$item['ID'])?'selected':'').">".utf8_encode($item['nombre'])."</option>";
            }
            $resultado=1;
        } catch (Exception $ex) {
            $resultado=-1;
            $mensaje=$ex->getMessage();
          
        }
        $retornar = Array('resultado'=>$resultado,
            'mensaje' => $mensaje,'stock' => $stock,
            'descripcion'=>$oProducto->descripcion,'codigo'=>$codigo,
             'linea_ID'=>$linea_ID, 'html'=>$html,'unidad_medida'=>$unidad_medida,'peso'=>$peso);
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
                $html.='<span class="media-heading">'.test_input($item['remitente']).'</span>';
                $html.='<span class="media-text">'.test_input($item['mensaje']).'</span>';
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
    function post_ajaxListarPersonas($texto){
       
        require ROOT_PATH.'models/persona.php';
        $buscar=$_POST['buscar'];
        
        try{
             
            $dtPersona=persona::geListaPersonas($buscar);
        }catch(Exception $ex){
            
        }
        
       
        //$retornar=Array('valor1'=>$linea_ID,'valor2'=>$categoria_ID);
        echo json_encode($dtPersona);
    }
    function post_ajaxListarProductos($texto){
        require ROOT_PATH.'models/producto.php';
        $buscar=$_POST['buscar'];
        $linea_ID=$_POST['linea_ID'];
        $categoria_ID=$_POST['categoria_ID'];
        //echo $linea_ID;
        $dtProducto=producto::geLista1($buscar,$linea_ID,$categoria_ID);
       
        //$retornar=Array('valor1'=>$linea_ID,'valor2'=>$categoria_ID);
        echo json_encode($dtProducto);
    }
    function post_ajaxBuscarProductos(){
        require ROOT_PATH.'models/producto.php';
        $codigo=$_POST['id'];
        $producto_ID=0;
        $producto="";
        $resultado=0;
        try{
            $dt=producto::getProducto_Codigo($codigo);
            if(count($dt)>0){
                $producto_ID=$dt[0]['ID'];
                 $producto=$dt[0]['nombre'];
                 $resultado=1;
            }else{
                $resultado=0;
            }
            
        } catch (Exception $ex){
            log_error(__FILE__, "funcionController/post_ajaxBuscarProductos", $ex->getMessage());
            $resultado=-1;
        }
        
       $retornar=Array('resultado'=>$resultado,'producto_ID'=>$producto_ID,'producto'=>$producto);
        echo json_encode($retornar);
    }
    function post_ajaxListarClientes(){
        require ROOT_PATH.'models/cliente.php';
        $buscar=$_POST['buscar'];
        $dtCliente=cliente::geLista($buscar);
       
        //$retornar=Array('valor1'=>$linea_ID,'valor2'=>$categoria_ID);
        echo json_encode($dtCliente);
    }
    function post_ajaxHistorial_Producto(){

        require ROOT_PATH.'models/producto.php';
        $producto_ID=$_POST['id'];
        $filas_compras="";
        $filas_ventas="";
       try{
           $dt=producto::getFilasHistorial($producto_ID);
           $filas_compras=$dt[0]['filas_compras'];
           $filas_ventas=$dt[0]['filas_ventas'];
       }catch(Exception $ex){
       log_error(__FILE__, "funcionController.post_ajaxHistorial_Producto", $ex->getMessage());
        throw new Exception("Ocurrió un error en el sistema");
       }
       
        $retornar=Array('filas_compras'=>$filas_compras,"filas_ventas"=>$filas_ventas);

        echo json_encode($retornar);
    }
    function post_ajaxVerSeparaciones(){

        require ROOT_PATH.'models/producto.php';
        $producto_ID=$_POST['id'];
        $filas="";
       
       try{
           $dt=producto::getFilasSeparaciones($producto_ID);
           $filas=$dt[0]['filas'];
           
       }catch(Exception $ex){
       log_error(__FILE__, "funcionController.post_ajaxVerSeparaciones", $ex->getMessage());
        throw new Exception("Ocurrió un error en el sistema");
       }
       
        $retornar=Array('filas'=>$filas);

        echo json_encode($retornar);
    }
    function post_ajaxOpcionesProvincias(){
        require ROOT_PATH.'models/provincia.php';
        $departamento_ID=$_POST['id'];
        $provincias= (provincia::getOpciones(-1,$departamento_ID));
        $retornar=Array('provincias'=>$provincias);

        echo json_encode($retornar);
    }
    function post_ajaxOpcionesDistritos(){
        require ROOT_PATH.'models/distrito.php';
        $provincia_ID=$_POST['id'];
        $distritos=(distrito::getOpciones(-1,$provincia_ID));
        $retornar=Array('distritos'=>$distritos);

        echo json_encode($retornar);
    }
    function Grilla_Mantenimiento($array_cabecera,$txtOrden,$orden_class,$incluyeOpciones,$dt,$botones,$cantidadMaxima,$cantidadMostrar,$paginaActual){
    $resultado='';
    $resultado = '<table id="websendeos" class="grid table table-hover table-bordered"><thead><tr>';
    
   
    $array_alineado=array();
    $array_campo=array();
    $y=1;
   
    foreach($array_cabecera as $column){
        
       $resultado.='<th class="thOrden text-center" onclick="fncOrden('.$y.');">'.$column['cabecera'].((($txtOrden == $y) ? "<img class='" . $orden_class . "' />" : "")). '</th>';
            array_push($array_alineado,$column['class_alineado']);
            array_push($array_campo,$column['campo']);
            $y++; 
    }
    
    if($incluyeOpciones==1){
         $resultado.='<th></th>';
    }
   
    $resultado.='</tr></thead><tbody>';
    $n=($paginaActual-1)*$cantidadMostrar+1;
    foreach($dt as $valores){
        $resultado.='<tr class="tr-item">';
        
        for($i=0;$i<count($array_campo);$i++){
            if($i==0){
                $resultado.='<td class="'.$array_alineado[$i].'">'.$n.'</td>';
            }else{
            $resultado.='<td class="'.$array_alineado[$i].'">' . (isset($valores[$array_campo[$i]])?$valores[$array_campo[$i]]:"") . '</td>';
            }
          
        }
        $n++;
        if($incluyeOpciones==1){
            $array_botones=array();
           
            foreach($botones as $btn){
                array_push($array_botones,'<a title="'.$btn['titulo'].'" onclick="'.$btn['funcion'].'(' . $valores[$btn['campo']] . ');">'.$btn['imagen'].' '.$btn['nombre'].'</a>');
                
            }
            $resultado.='<td class="text-center" >'.((count($array_botones)>0)?extraerOpcion($array_botones):"")."</td>";
        }
       
        $resultado.='</tr>';
    }
    $colspanFooter=count($array_campo)+1;
    $rows=count($dt);
    $resultado.=paginacion($cantidadMaxima,$cantidadMostrar,$colspanFooter,$paginaActual);
    $resultado.='<tr class="tr-footer"><th colspan=' . $colspanFooter . '>' . $rows . ' de ' . $cantidadMaxima . ' Registros</th></tr>';
    $resultado.='</tbody>';
    $resultado.='</table>';
    return $resultado;
}
function array_orderby()
{
    $args = func_get_args();
    $data = array_shift($args);
    foreach ($args as $n => $field) {
        if (is_string($field)) {
            $tmp = array();
            foreach ($data as $key => $row)
                $tmp[$key] = $row[$field];
            $args[$n] = $tmp;
            }
    }
    $args[] = &$data;
    call_user_func_array('array_multisort', $args);
    return array_pop($args);
}
function generador_tabla($dt,$array_cabecera,$campo_orden,$orden,$cantidadMostrar,$paginaActual){
    
    $cantidadMaxima=COUNT($dt);
    $dt = array_orderby($dt, $campo_orden,(($orden=="ASC")? SORT_ASC:SORT_DESC));
    
    
    
   
    $orden_class = 'imgOrden-desc';
    if ($orden=="ASC") {
        $orden_class = 'imgOrden-asc';
        
    }
    $resultado='';
   
    
    $array_alineado=array();
    $array_campo=array();
    $y=1;
    $r1="";
    $r2="";
    $array_buscar=[];
   
    foreach($array_cabecera as $column){
        $valor1=trim(isset($_POST["buscar_".$column['campo']])?$_POST["buscar_".$column['campo']]:"");
      //echo $valor1;
        if($valor1!=""){
            $buscar_ar=array("cam"=>$column['campo'],"valor"=>$valor1);
            array_push($array_buscar,$buscar_ar);
        }
        if(strtoupper($column['filtro'])=='SI'){
        $r1.='<th style="padding-top:1px;padding-bottom:1px;"><input type="text" autocomplete="off" name="buscar_'.$column['campo'].'" value="'.$valor1.'" style="background:#EEEDED" class="form-control buscadores" onDblClick="this.value=&#39;&#39;"></th>';
        }else{
           $r1.='<th></th>'; 
        }
        $r2.='<th class="thOrden text-center"  onclick="fncOrden(&#39;'.$column['campo'].'&#39;);">'.$column['cabecera'].((($campo_orden == $column['campo']) ? "<img class='" . $orden_class . "' />" : "")). '</th>';
        array_push($array_alineado,$column['class_alineado']);
        array_push($array_campo,$column['campo']);
        $y++;  
    }
  
    $array=[];
    if(count($array_buscar)>0){
        
        foreach($array_buscar as $bu){
            
            $i=0;
            $array_filtrado=[];
            foreach($dt as $col){
                
                if (mb_strpos(strtoupper($col[$bu['cam']]), strtoupper($bu['valor']),0,'auto') !==false){
                    array_push($array_filtrado,$dt[$i]);
                    //print_r($array_filtrado);
                }
                $i++;
            }
            
            $dt=$array_filtrado;
            
        }
            $array=$dt;
      
    }else{
        $array=$dt;
    }
    //$resultado.='<table></table>';
    $cantidadMaxima=count($array);
    $array=array_slice($array,(($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar);
    
    $resultado = '<table id="websendeos" class="grid table table-hover table-bordered table-teal"><thead>';
    $resultado.='<tr>'.$r2.'</tr>';
    $resultado.='<tr class="fila_buscador">'.$r1.'</tr>';
    $resultado.='</thead><tbody>';
    $n=($paginaActual-1)*$cantidadMostrar+1;
    foreach($array as $valores){
        $resultado.='<tr class="tr-item">';
        
        for($i=0;$i<count($array_campo);$i++){
            if($i==0){
                $resultado.='<td class="'.$array_alineado[$i].'">'.$n.'</td>';
            }else{
            $resultado.='<td class="'.$array_alineado[$i].'">' . (isset($valores[$array_campo[$i]])?$valores[$array_campo[$i]]:"") . '</td>';
            }
          
        }
        $n++;
        
       
        $resultado.='</tr>';
    }
    //$cantidadMaxima=count($array);
    $colspanFooter=count($array_campo)+1;
    $rows=count($array);
    $resultado.=paginacion($cantidadMaxima,$cantidadMostrar,$colspanFooter,$paginaActual);
    $resultado.='<tr class="tr-footer"><th colspan=' . $colspanFooter . '>' . $rows . ' de ' . $cantidadMaxima . ' Registros</th></tr>';
    $resultado.='</tbody>';
    $resultado.='</table>';
    return $resultado;
}

?>