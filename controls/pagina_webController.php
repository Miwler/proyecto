<?php	
    function get_Index($id){
        
        global $returnView;
        $returnView=true;
       
        
    }
   
    function get_Datos_Empresa(){
        if(!class_exists('datos_generales')){
            require ROOT_PATH . 'models/datos_generales.php';
        }
        
        global $returnView;
        $returnView=true;
        
        if(isset($_SESSION['empresa_ID'])){
            $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
        }else{
            $oDatos_Generales=new datos_generales();
        }
        
       $GLOBALS['oDatos_Generales']=$oDatos_Generales;
    }
    function post_Datos_Empresa($id){
        if(!class_exists('datos_generales')){
            require ROOT_PATH . 'models/datos_generales.php';
        }
        global $returnView;
        $returnView=true;
        $oDatos_Generales=datos_generales::getByID1($id);
        $quienes_somos=  FormatTextSave($_POST['txtQuienes_Somos']);
        $mision=FormatTextSave($_POST['txtMision']);
        $vision=FormatTextSave($_POST['txtVision']);
        $persona_contacto=FormatTextSave($_POST['txtPersona_Contacto']);
        $cargo_contacto=FormatTextSave($_POST['txtCargo_Contacto']);
        $telefono2=FormatTextSave($_POST['txtTelefono2']);
        $telefono3=FormatTextSave($_POST['txtTelefono3']);
        $telefono4=FormatTextSave($_POST['txtTelefono4']);
        $skype=FormatTextSave($_POST['txtSkype']);
        try{
            $oDatos_Generales->quienes_somos=$quienes_somos;
            $oDatos_Generales->mision=$mision;
            $oDatos_Generales->vision=$vision;
            $oDatos_Generales->persona_contacto=$persona_contacto;
            $oDatos_Generales->cargo_contacto=$cargo_contacto;
            $oDatos_Generales->telefono2=$telefono2;
            $oDatos_Generales->telefono3=$telefono3;
            $oDatos_Generales->telefono4=$telefono4;
            $oDatos_Generales->skype=$skype;
            $oDatos_Generales->actualizar_datos_empresa();
            $resultado=1;
            $mensaje=$oDatos_Generales->message;
        }catch (Exception $ex) {
            $resultado=-1;
            $mensaje=$ex->getMessage();
        }
        
        
       $GLOBALS['oDatos_Generales']=$oDatos_Generales;
       $GLOBALS['resultado']=$resultado;
       $GLOBALS['mensaje']=$mensaje;
    }
    function get_Configuracion_Correo($id){
        if(!class_exists('datos_generales')){
            require ROOT_PATH . 'models/datos_generales.php';
        }
        
        global $returnView;
        $returnView=true;
        
        if(isset($_SESSION['empresa_ID'])){
            $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
        }else{
            $oDatos_Generales=new datos_generales();
        }
        
       $GLOBALS['oDatos_Generales']=$oDatos_Generales;
    }
    function post_Configuracion_Correo($id){
        if(!class_exists('datos_generales')){
            require ROOT_PATH . 'models/datos_generales.php';
        }
        global $returnView;
        $returnView=true;
        $oDatos_Generales=datos_generales::getByID1($id);
        $mail_webmaster=FormatTextSave($_POST['txtMail_Webmaster']);
        $password_webmaster=FormatTextSave($_POST['txtPassword_Webmaster']);
        $servidorSMTP=FormatTextSave($_POST['txtServidorSMTP']);
        $puertoSMTP=FormatTextSave($_POST['txtPuertoSMTP']);
        
        try{
            $oDatos_Generales->mail_webmaster=$mail_webmaster;
            $oDatos_Generales->password_webmaster=$password_webmaster;
            $oDatos_Generales->servidorSMTP=$servidorSMTP;
            $oDatos_Generales->puertoSMTP=$puertoSMTP;
            
            $oDatos_Generales->actualizar_correoSMTP();
            $resultado=1;
            $mensaje=$oDatos_Generales->message;
        }catch (Exception $ex) {
            $resultado=-1;
            $mensaje=$ex->getMessage();
        }
       $GLOBALS['oDatos_Generales']=$oDatos_Generales;
       $GLOBALS['resultado']=$resultado;
       $GLOBALS['mensaje']=$mensaje;
    }
    function get_Web_Banner_Configuracion(){
       
        global $returnView;
        $returnView=true;
   
    }
    function post_ajaxWeb_Banner_Configuracion() {
        require ROOT_PATH . 'models/web_banner.php';
        require ROOT_PATH . 'controls/funcionController.php';
        $buscar = trim($_POST['txtBuscar']);
        
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
                $orden = 'nombre ' . $orden_tipo;
                break;
            case 2:
                $orden = 'descripcion ' . $orden_tipo;
                break;
            default:
                $orden = 'ID ' . $orden_tipo;
                break;
        }
         $filtro='empresa_ID='.$_SESSION['empresa_ID'];
       
        if($buscar!=''){
            
            $filtro.= " and  upper(nombre) like '%" . str_replace(' ', '%', strtoupper(FormatTextSave($buscar))) . "%'";
        }


        //---------------------------------------					 
        $resultado = '<table id="websendeos" class="grid table table-hover" ><tr>';
        $resultado.='<th> Acción</th>';
        $resultado.='<th  class="thOrden" onclick="fncOrden(1);">Nombre' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
        $resultado.='<th  class="thOrden" onclick="fncOrden(2);">Descripción' . (($txtOrden == 2 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
        $resultado.='</tr>';

        $colspanFooter = 4;
        try {
            $cantidadMaxima = web_banner::getCount($filtro);
            $dtWeb_Banner = web_banner::getGrid($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
            $rows = count($dtWeb_Banner);

            foreach ($dtWeb_Banner as $item) {
                
                /*tr-item*/
                $resultado.='<tr id="'.$item['ID'].'" class="tr-item">';
                $resultado.='<td class="btnAction" style="width:450px;">'
                        . '<a onclick="fncEditar(&#39;' . $item['ID'] . '&#39;);"class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Editar banner" ><span class="glyphicon glyphicon-pencil"> Editar</a>'
                        . '<a onclick="fncImagen(&#39;' . $item['ID'] . '&#39;);" class="btn btn-info" data-toggle="tooltip" data-placement="right" title="Subir imagenes del banner."><span class="glyphicon glyphicon-picture"> Imagen</span></a>'
                        . '<a onclick="fncUbicacion(&#39;' . $item['ID'] . '&#39;);" class="btn btn-info" data-toggle="tooltip" data-placement="right" title="Registrar ubicación"><span class="glyphicon glyphicon-align-left"> Ubicación</span></a>'
                        . '<a onclick="modal.confirmacion(&#39;El proceso es irreversible, esta seguro de eliminar el registro.&#39;,&#39;Eliminar Banner&#39;,fncEliminar,&#39;' . $item['ID'] . '&#39;);" class="btn btn-danger" data-toggle="tooltip" data-placement="right" title="Eliminar banner" ><span class="glyphicon glyphicon-trash"> Eliminar</a></td>';
                $resultado.='<td>' . FormatTextViewHtml($item['nombre']) . '</td>';
                $resultado.='<td>' . FormatTextView($item['descripcion']). '</td>';
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
    
    function get_Web_Banner_Configuracion_Nuevo() {
      
        require ROOT_PATH . 'models/web_banner.php';
        global $returnView_float;
        $returnView_float = true;
        $oWeb_Banner=new web_banner();
        $GLOBALS['oWeb_Banner']=$oWeb_Banner;
    }
    function post_Web_Banner_Configuracion_Nuevo() {
      
        require ROOT_PATH . 'models/web_banner.php';
        require ROOT_PATH . 'models/web_banner_imagen.php';
        global $returnView_float;
        $returnView_float = true;
        $nombre=  FormatTextSave($_POST['txtNombre']);
        $descripcion=  FormatTextSave($_POST['txtDescripcion']);
        try{
            $oWeb_Banner=new web_banner();
            $oWeb_Banner->nombre=$nombre;
            $oWeb_Banner->descripcion=$descripcion;
            $oWeb_Banner->empresa_ID=$_SESSION['empresa_ID'];
            $oWeb_Banner->usuario_id=$_SESSION['usuario_ID'];
            $oWeb_Banner->insertar();
           
            $resultado=1;
            $mensaje=$oWeb_Banner->getMessage;
        }catch(Exception $ex){
            $resultado=-1;
            $mensaje=$ex->getMessage();
        }
        
        $GLOBALS['oWeb_Banner']=$oWeb_Banner;
        $GLOBALS['resultado']=$resultado;
        $GLOBALS['mensaje']=$mensaje;
    }
    function get_Web_Banner_Configuracion_Editar($id) {
      
        require ROOT_PATH . 'models/web_banner.php';
        global $returnView_float;
        $returnView_float = true;
        $oWeb_Banner=web_banner::getByID($id);;
        $GLOBALS['oWeb_Banner']=$oWeb_Banner;
    }
    function post_Web_Banner_Configuracion_Editar($id) {

       require ROOT_PATH . 'models/web_banner.php';
       require ROOT_PATH . 'models/web_banner_imagen.php';
       global $returnView_float;
       $returnView_float = true;
       $nombre=  FormatTextSave($_POST['txtNombre']);
       $descripcion=  FormatTextSave($_POST['txtDescripcion']);
       try{
           $oWeb_Banner=web_banner::getByID($id);
           $oWeb_Banner->nombre=$nombre;
           $oWeb_Banner->descripcion=$descripcion;
           $oWeb_Banner->usuario_mod_id=$_SESSION['usuario_ID'];
           $oWeb_Banner->actualizar();

           $resultado=1;
           $mensaje=$oWeb_Banner->getMessage;
       }catch(Exception $ex){
           $resultado=-1;
           $mensaje=$ex->getMessage();
       }

       $GLOBALS['oWeb_Banner']=$oWeb_Banner;
       $GLOBALS['resultado']=$resultado;
       $GLOBALS['mensaje']=$mensaje;
   }
    function post_ajaxWeb_Banner_Configuracion_Eliminar() {
        require ROOT_PATH . 'models/web_banner.php';
        require ROOT_PATH . 'controls/funcionController.php';
        $ID=$_POST['id'];
        try {
           $oWeb_Banner=web_banner::getByID($ID);
           $oWeb_Banner->usuario_mod_id=$_SESSION['usuario_ID'];
           $oWeb_Banner->eliminar();
           $resultado=1;
           $mensaje=$oWeb_Banner->getMessage;
        } catch (Exception $ex) {
            $resultado=-1;
            $mensaje=$ex->getMessage();
        }
        $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
        echo json_encode($retornar);
    }
    function get_Web_Banner_Configuracion_Imagen($id) {
        require ROOT_PATH . 'models/web_banner.php';
        require ROOT_PATH . 'models/web_banner_imagen.php';
        require ROOT_PATH . 'models/estado.php';
        global $returnView_float;
        $returnView_float = true;
        $oWeb_Banner=web_banner::getByID($id);
        $dtEstado=estado::getGrid("est.tabla='web_banner_imagen'",-1,-1,"est.orden asc");
        $GLOBALS['dtEstado']=$dtEstado;
        $GLOBALS['oWeb_Banner']=$oWeb_Banner;
    }
    
    function post_ajaxWeb_Banner_Configuracion_Imagen(){
        require ROOT_PATH . 'models/web_banner_imagen.php';
        require ROOT_PATH . 'models/estado.php';
        $ID=$_POST['id'];
        
        $dtWeb_Banner_Imagen=web_banner_imagen::getGrid("web_banner_ID=".$ID,-1,-1,'orden asc');
        $html="";
        foreach($dtWeb_Banner_Imagen as $item){
            $oEstado=estado::getByID($item['estado_ID']);
            $texto=($item['estado_ID']==63)?'<span class="glyphicon glyphicon-ban-circle"></span> Desactivar':'<span class="glyphicon glyphicon-ok-circle"></span> Activar';
            $html.="<div class='row'><div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>";
            $html.='<div class="thumbnail">';
            $html.='<div class="row">';
            $html.='<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">';
            $html.='<h4>Estado: '.FormatTextView($oEstado->nombre).'</h4>';
            $html.='</div>';
            $html.='<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">';
            $html.='<a class="btn btn-info" data-toggle="tooltip" data-placement="right" title="Editar imagen" onclick="fncEditar(&#39;'.$item['ID'].'&#39;);"><span class="glyphicon glyphicon-pencil"></span> Editar</a>&nbsp;&nbsp;&nbsp;';
            $html.='<a class="btn btn-warning"   title="Desactivar imagen" onclick="fncDesactivar(&#39;'.$item['ID'].'&#39;);">'.$texto.'</a>&nbsp;&nbsp;&nbsp;';
             $html.='<a class="btn btn-danger"   title="Eliminar imagen" onclick="modal.confirmacion(&#39;¿Esta seguro de eliminar la imagen?&#39;,&#39;Eliminar imagen&#39;,fncEliminar,&#39;'.$item['ID'].'&#39;);"><span class="glyphicon glyphicon-trash"></span> Eliminar</a>';
            $html.='</div>';
            $html.='</div>';
            $html.='<img src="../../files/imagenes/banner/'.$item['ruta'].'" class="img-thumbnail"  alt="...">';
            $html.='<div class="caption">';
            $html.=(trim($item['nombre'])!="")?'<h4 style="margin: 5px 0;">'.FormatTextView($item['nombre']).'</h4>':"";
            $html.=(trim($item['titulo'])!="")?'<h4>'.FormatTextView($item['titulo']).'</h4>':"";
            
            $html.=(trim($item['resumen'])!="")?'<p>'.FormatTextView($item['resumen']).'</p>':'';
            $html.=(trim($item['ruta_ver_mas'])!="")?'<a href="'.$item['ruta_ver_mas'].'">Ver más</a>':'';
            $html.="</div>";
            $html.="</div>";
            $html.="</div></div>";
        }
        
        $resultado=1;

        $retornar = Array('resultado' => $resultado, 'html' => $html);
            //$retorn="<h1>Hola</h1>";

        echo json_encode($retornar);
    }
    function post_ajaxInsertWeb_Banner_Configuracion_Imagen(){
        require ROOT_PATH . 'models/web_banner_imagen.php';
        $web_banner_ID=$_POST['txtWeb_Banner_ID'];
        $nombre=FormatTextSave($_POST['txtNombre']);
        $titulo=FormatTextSave($_POST['txtTitulo']);
        $resumen=FormatTextSave($_POST['txtResumen']);
        $ruta_ver_mas=FormatTextSave($_POST['txtRuta_Ver_Mas']);
        $estado_ID=$_POST['selEstado_ID'];
        $orden=$_POST['txtOrden'];
        
        try{
            $oWeb_Banner_Imagen= new web_banner_imagen();
            $oWeb_Banner_Imagen->web_banner_ID=$web_banner_ID;
            $oWeb_Banner_Imagen->nombre=$nombre;
            $oWeb_Banner_Imagen->titulo=$titulo;
            $oWeb_Banner_Imagen->resumen=$resumen;
            $oWeb_Banner_Imagen->orden=$orden;
            $oWeb_Banner_Imagen->ruta_ver_mas=$ruta_ver_mas;
            $oWeb_Banner_Imagen->ruta="";
            $oWeb_Banner_Imagen->estado_ID=$estado_ID;//Estado activo
            $oWeb_Banner_Imagen->usuario_id=$_SESSION['usuario_ID'];
            $oWeb_Banner_Imagen->insertar();
            $resultado=1;
            $mensaje=$oWeb_Banner_Imagen->getMessage;
            //Subimos el archivo.
            $dir_subida = $_SERVER['DOCUMENT_ROOT'].'/files/imagenes/banner/';
            $nombre_temporal=explode('.',basename($_FILES['archivo']['name']));
            //$extension=$nombre_temporal[1];
            $extension=(strtoupper($nombre_temporal[1])=="JPG"||strtoupper($nombre_temporal[1])=="png"||strtoupper($nombre_temporal[1])=="gif")?$nombre_temporal[1]:"JPG";
            $nombre2=$oWeb_Banner_Imagen->ID.'.'.$extension;
            $fichero_subido = $dir_subida .basename($nombre2);
            //$nombre_archivo=$oWeb_Banner_Imagen->ID.".".$fichero_subido[1];
            if (move_uploaded_file($_FILES['archivo']['tmp_name'], $fichero_subido)) {
                $oWeb_Banner_Imagen->ruta=$nombre2;
                $oWeb_Banner_Imagen->usuario_mod_id=$_SESSION['usuario_ID'];
                $oWeb_Banner_Imagen->actualizar();
                
            }else{$mensaje="Se guardó la información, pero no se subió la imagen.";}
        }catch(Exception $ex){
            $resultado=-1;
            $mensaje=$ex->getMessage();
        }
        
        $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
        echo json_encode($retornar);
         //print_r($_FILES);
    }
    function post_ajaxElminarWeb_Banner_Imagen(){
        require ROOT_PATH . 'models/web_banner_imagen.php';
        $ID=$_POST['id'];
        try{
            $oWeb_Banner_Imagen=web_banner_imagen::getByID($ID);
            if(!isset($oWeb_Banner_Imagen)){
                $resultado=-1;
                $mensaje="No existe el registro.";
            }else{
                $oWeb_Banner_Imagen->usuario_mod_id=$_SESSION['usuario_ID'];
                $oWeb_Banner_Imagen->eliminar();
                
                $resultado=1;
                $mensaje=$oWeb_Banner_Imagen->getMessage;
                if(trim($oWeb_Banner_Imagen->ruta)!=""){
                    $fichero = $_SERVER['DOCUMENT_ROOT'].'/files/imagenes/banner/'.$oWeb_Banner_Imagen->ruta;
                    if(!unlink($fichero)){
                        $mensaje="No existe la imagen.";
                    }
                }
                
            }
        }catch(Exception $ex){
            $resultado=-1;
            $mensaje=$ex->getMessage();
        }

        $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
        echo json_encode($retornar);
    }
    function post_ajaxDesactivarWeb_Banner_Imagen(){
        require ROOT_PATH . 'models/web_banner_imagen.php';
        $ID=$_POST['id'];
        try{
            $oWeb_Banner_Imagen=web_banner_imagen::getByID($ID);
            if(!isset($oWeb_Banner_Imagen)){
                $resultado=-1;
                $mensaje="No existe el registro.";
            }else{
                $oWeb_Banner_Imagen->usuario_mod_id=$_SESSION['usuario_ID'];
                $estado_ID=($oWeb_Banner_Imagen->estado_ID==63)?64:63;
                $oWeb_Banner_Imagen->estado_ID=$estado_ID;//Estado inactivo
                $oWeb_Banner_Imagen->actualizar();
                
                $resultado=1;
                $mensaje=$oWeb_Banner_Imagen->getMessage;  
            }
        }catch(Exception $ex){
            $resultado=-1;
            $mensaje=$ex->getMessage();
        }

        $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
        echo json_encode($retornar);
    }
    function post_ajaxExtraerInfoWeb_Banner_Imagen(){
        require ROOT_PATH . 'models/web_banner_imagen.php';
        $ID=$_POST['id'];
        try{
            $oWeb_Banner_Imagen=web_banner_imagen::getByID($ID);
            
        }catch(Exception $ex){
            $resultado=-1;
            $mensaje=$ex->getMessage();
        }

        //$retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje,  'oWeb_Banner_Imagen'=>$oWeb_Banner_Imagen );
        echo json_encode($oWeb_Banner_Imagen);
    }
    function post_ajaxUpdateWeb_Banner_Configuracion_Imagen(){
        require ROOT_PATH . 'models/web_banner_imagen.php';
        $ID=$_POST['txtID'];
        $nombre=FormatTextSave($_POST['txtNombre']);
        $titulo=FormatTextSave($_POST['txtTitulo']);
        $resumen=FormatTextSave($_POST['txtResumen']);
        $ruta_ver_mas=FormatTextSave($_POST['txtRuta_Ver_Mas']);
        $orden=$_POST['txtOrden'];
        $estado_ID=$_POST['selEstado_ID'];
       
        
        try{
            if($ID!=""){
                $oWeb_Banner_Imagen= web_banner_imagen::getByID($ID);
            
                $oWeb_Banner_Imagen->nombre=$nombre;
                $oWeb_Banner_Imagen->titulo=$titulo;
                $oWeb_Banner_Imagen->resumen=$resumen;
                $oWeb_Banner_Imagen->orden=$orden;
                $oWeb_Banner_Imagen->ruta_ver_mas=$ruta_ver_mas;
                $oWeb_Banner_Imagen->estado_ID=$estado_ID;//Estado activo
                $oWeb_Banner_Imagen->usuario_mod_id=$_SESSION['usuario_ID'];
                $oWeb_Banner_Imagen->actualizar();
                $resultado=1;
                $mensaje=$oWeb_Banner_Imagen->getMessage;
            }else{
                $resultado=-1;
                $mensaje="No seleccionó ningún banner.";
            }
            
        }catch(Exception $ex){
            $resultado=-1;
            $mensaje=$ex->getMessage();
        }
        
        $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
        echo json_encode($retornar);
         //print_r($_FILES);
    }
    function get_Web_Banner_Configuracion_Ubicacion($id) {
      
        require ROOT_PATH . 'models/web_banner.php';
        require ROOT_PATH . 'models/web_banner_ubicacion.php';
        global $returnView_float;
        $returnView_float = true;
        $oWeb_Banner=web_banner::getByID($id);
        $GLOBALS['oWeb_Banner']=$oWeb_Banner;
       
    }
    function post_ajaxWeb_Banner_Ubicacion() {
        require ROOT_PATH . 'models/web_banner_ubicacion.php';
        
        $ID=$_POST['id'];
        $filtro='web_banner_ID='.$ID;
       
        
        //---------------------------------------	
        $resultado='<div class="table-responsive">';
        $resultado.= '<table id="mi-tabla" class="table table-condensed tablesorter"><tr>';
        $resultado.='<th class="text-center">Nro</th>';
        $resultado.='<th style="width:280px;">Ruta</th>';
        $resultado.='<th class="text-center">Tipo</th>';
        $resultado.='<th class="text-center">Orden</th>';
        $resultado.='<th class="text-center">Acción</th>';
        $resultado.='</tr>';

        $colspanFooter = 5;
        try {
            $cantidadMaxima = web_banner_ubicacion::getCount($filtro);
            $dtWeb_Banner = web_banner_ubicacion::getGrid($filtro,-1, -1, "ID asc");
            $rows = count($dtWeb_Banner);
            $i=1;
            foreach ($dtWeb_Banner as $item) {
                $resultado.='<tr>';
                $resultado.='<td class="text-center">'.$i.'</td>';
                $resultado.='<td>' . htmlspecialchars($item['ruta']) . '</td>';
                $resultado.='<td class="text-center">' . htmlspecialchars($item['tipo']). '</td>';
                $resultado.='<td class="text-center">' . $item['orden']. '</td>';
                $resultado.='<td class="text-center"><a title="Eliminar ubicación" onclick="modal.confirmacion(&#39;El proceso es irreversible, esta seguro de eliminar la ubicación.&#39;,&#39;Eliminar Ubicación&#39;,fncEliminar,&#39;' . $item['ID'] . '&#39;);" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-trash"></span></a></td>';
                $resultado.='</tr>';
                $i++;
            }
            
            
        } catch (Exception $ex) {
            $resultado.='<tr ><td colspan=' . $colspanFooter . '>' . $ex->getMessage() . '</td></tr>';
        }

        $resultado.='</table>';
        $resultado.='</div">';
        $retornar = Array('resultado' => $resultado);
        //$retorn="<h1>Hola</h1>";

        echo json_encode($retornar);
    }
    function post_ajaxInsertWeb_Banner_Ubicacion(){
        require ROOT_PATH . 'models/web_banner_ubicacion.php';
        $web_banner_ID=$_POST['txtWeb_Banner_ID'];
        $ruta=FormatTextSave($_POST['txtRuta']);
        $tipo=$_POST['selTipo'];
        $orden=$_POST['txtOrden'];
        
        
        try{
            if(web_banner_ubicacion::getCount("ruta='".$ruta."' and web_banner_ID=".$web_banner_ID)>0){
                $resultado=-1;
                $mensaje="ya existe un registro con la misma ruta.";
            }else{
            $oWeb_Banner_Imagen_Ubicacion= new web_banner_ubicacion();
            $oWeb_Banner_Imagen_Ubicacion->web_banner_ID=$web_banner_ID;
            $oWeb_Banner_Imagen_Ubicacion->ruta=$ruta;
            $oWeb_Banner_Imagen_Ubicacion->tipo=$tipo;
            $oWeb_Banner_Imagen_Ubicacion->efecto="";
            $oWeb_Banner_Imagen_Ubicacion->medida_imagen="";
            $oWeb_Banner_Imagen_Ubicacion->orden=$orden;
            $oWeb_Banner_Imagen_Ubicacion->titulo_encabezado="";
            $oWeb_Banner_Imagen_Ubicacion->usuario_id=$_SESSION['usuario_ID'];
            $oWeb_Banner_Imagen_Ubicacion->insertar();
            $resultado=1;
            $mensaje=$oWeb_Banner_Imagen_Ubicacion->getMessage;
            }
           
        }catch(Exception $ex){
            $resultado=-1;
            $mensaje=$ex->getMessage();
        }
        
        $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
        echo json_encode($retornar);
        
    }
    function post_ajaxDeleteWeb_Banner_Ubicacion(){
        require ROOT_PATH . 'models/web_banner_ubicacion.php';
        $ID=$_POST['id'];
        
        try{
            $oWeb_Banner_Imagen_Ubicacion=web_banner_ubicacion::getByID($ID);
            if($oWeb_Banner_Imagen_Ubicacion==null){
                $resultado=-1;
                $mensaje="ya no existe la ubicación.";
            }else{
            
            $oWeb_Banner_Imagen_Ubicacion->usuario_mod_id=$_SESSION['usuario_ID'];
            $oWeb_Banner_Imagen_Ubicacion->eliminar();
            $resultado=1;
            $mensaje=$oWeb_Banner_Imagen_Ubicacion->getMessage;
            }
           
        }catch(Exception $ex){
            $resultado=-1;
            $mensaje=$ex->getMessage();
        }
        
        $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
        echo json_encode($retornar);
        
    }
    
    //Marca
    function get_Marca_Configuracion(){
        global $returnView;
        $returnView=true;
   
    }
    function post_ajaxMarca_Configuracion() {
        require ROOT_PATH . 'models/marca.php';
        require ROOT_PATH . 'controls/funcionController.php';
        $buscar = trim($_POST['txtBuscar']);
        
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
                $orden = 'nombre ' . $orden_tipo;
                break;
            case 2:
                $orden = 'imagen ' . $orden_tipo;
                break;
            case 3:
                $orden = 'url ' . $orden_tipo;
                break;
            case 4:
                $orden = 'orden ' . $orden_tipo;
                break;
            default:
                $orden = 'ID  ' . $orden_tipo;
                break;
        }
         $filtro='empresa_ID='.$_SESSION['empresa_ID'];
       
        if($buscar!=''){
            
            $filtro= " and  upper(nombre) like '%" . str_replace(' ', '%', strtoupper(FormatTextSave($buscar))) . "%'";
        }


        //---------------------------------------					 
        $resultado = '<table id="websendeos" class="grid table table-hover" ><tr>';
        $resultado.='<th> Acción</th>';
        $resultado.='<th  class="thOrden" onclick="fncOrden(1);">Nombre' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
        $resultado.='<th  class="thOrden" onclick="fncOrden(2);">Imagen' . (($txtOrden == 2 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
        $resultado.='<th  class="thOrden" onclick="fncOrden(3);">Url' . (($txtOrden == 3 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
        $resultado.='<th  class="thOrden" onclick="fncOrden(4);">Orden' . (($txtOrden == 4 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
        $resultado.='</tr>';

        $colspanFooter = 5;
        try {
            $cantidadMaxima = marca::getCount($filtro);
            $dtMarca = marca::getGrid($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
            $rows = count($dtMarca);

            foreach ($dtMarca as $item) {
                
                /*tr-item*/
                $resultado.='<tr class="tr-item">';
                $resultado.='<td class="btnAction" style="width:250px;">'
                        . '<a onclick="fncEditar(&#39;' . $item['ID'] . '&#39;);"class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Editar marca" ><span class="glyphicon glyphicon-pencil"> Editar</a>'
                        . '<a onclick="modal.confirmacion(&#39;El proceso es irreversible, esta seguro de eliminar el registro.&#39;,&#39;Eliminar Banner&#39;,fncEliminar,&#39;' . $item['ID'] . '&#39;);"class="btn btn-danger" data-toggle="tooltip" data-placement="right" title="Eliminar marca" ><span class="glyphicon glyphicon-trash"> Eliminar</a></td>';
                $resultado.='<td>' . FormatTextViewHtml($item['nombre']) . '</td>';
                $resultado.='<td class="text-center"><img src="../../files/imagenes/marca/'.$item['imagen'].'" alt="No existe" class="img-thumbnail" width="80" height="40"/></td>';
                $resultado.='<td>' . $item['url'] . '</td>';
                $resultado.='<td class="text-center">' . $item['orden'] . '</td>';
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
    function get_Marca_Configuracion_Nuevo() {
      
        require ROOT_PATH . 'models/marca.php';
        global $returnView_float;
        $returnView_float = true;
        $oMarca=new marca();
        $GLOBALS['oMarca']=$oMarca;
    }
    function post_Marca_Configuracion_Nuevo() {
      
        require ROOT_PATH . 'models/marca.php';
        
        global $returnView_float;
        $returnView_float = true;
        $nombre=  FormatTextSave($_POST['txtNombre']);
        $url=  FormatTextSave($_POST['txtUrl']);
        $orden=  $_POST['txtOrden'];
        try{
            $oMarca=new marca();
            $oMarca->nombre=$nombre;
            $oMarca->url=$url;
            $oMarca->imagen="";
            $oMarca->orden=$orden;
            $oMarca->empresa_ID=$_SESSION['empresa_ID'];
            $oMarca->usuario_id=$_SESSION['usuario_ID'];
            $oMarca->insertar();
            
            $dir_subida = $_SERVER['DOCUMENT_ROOT'].'/files/imagenes/marca/';
            $nombre_temporal=explode('.',basename($_FILES['imagen']['name']));
            //$extension=$nombre_temporal[1];
            $extension=(strtoupper($nombre_temporal[1])=="JPG"||strtoupper($nombre_temporal[1])=="png"||strtoupper($nombre_temporal[1])=="gif")?$nombre_temporal[1]:"JPG";
            $nombre2=$oMarca->ID.'.'.$extension;
            $fichero_subido = $dir_subida .basename($nombre2);
            //$nombre_archivo=$oWeb_Banner_Imagen->ID.".".$fichero_subido[1];
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $fichero_subido)) {
                $oMarca->imagen=$nombre2;
                $oMarca->usuario_mod_id=$_SESSION['usuario_ID'];
                $oMarca->actualizar();
                $mensaje=$oMarca->getMessage;
            }else{$mensaje="Se guardó la información, pero no se subió la imagen.";}
            $resultado=1;
            
        }catch(Exception $ex){
            $resultado=-1;
            $mensaje=$ex->getMessage();
        }
        
        $GLOBALS['oMarca']=$oMarca;
        $GLOBALS['resultado']=$resultado;
        $GLOBALS['mensaje']=$mensaje;
    }
    function get_Marca_Configuracion_Editar($id) {
      
        require ROOT_PATH . 'models/marca.php';
        global $returnView_float;
        $returnView_float = true;
        $oMarca=marca::getByID($id);
        $GLOBALS['oMarca']=$oMarca;
    }
    function post_Marca_Configuracion_Editar($id) {
      
        require ROOT_PATH . 'models/marca.php';
        
        global $returnView_float;
        
        $returnView_float = true;
        $nombre=  FormatTextSave($_POST['txtNombre']);
        $url=  FormatTextSave($_POST['txtUrl']);
        $orden=  $_POST['txtOrden'];
        try{
            $oMarca=marca::getByID($id);
            $oMarca->nombre=$nombre;
            $oMarca->url=$url;
            
            $oMarca->orden=$orden;
            $oMarca->usuario_mod_id=$_SESSION['usuario_ID'];
            $oMarca->actualizar();
            $mensaje=$oMarca->getMessage;
            if($_FILES['imagen']['name']!=""){
                $dir_subida = $_SERVER['DOCUMENT_ROOT'].'/files/imagenes/marca/';
                $nombre_temporal=explode('.',basename($_FILES['imagen']['name']));
                //$extension=$nombre_temporal[1];
                $extension=(strtoupper($nombre_temporal[1])=="JPG"||strtoupper($nombre_temporal[1])=="png"||strtoupper($nombre_temporal[1])=="gif")?$nombre_temporal[1]:"JPG";
                $nombre2=$oMarca->ID.'.'.$extension;
                $fichero_subido = $dir_subida .basename($nombre2);
                //$nombre_archivo=$oWeb_Banner_Imagen->ID.".".$fichero_subido[1];
                if(file_exists($fichero_subido)){
                    unlink($fichero_subido);
                }
                
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $fichero_subido)) {
                    $oMarca->imagen=$nombre2;
                    $oMarca->usuario_mod_id=$_SESSION['usuario_ID'];
                    $oMarca->actualizar();
                    $mensaje=$oMarca->getMessage;
                }else{$mensaje="Se guardó la información, pero no se subió la imagen.";}
               
            }
            $resultado=1;
            
        }catch(Exception $ex){
            $resultado=-1;
            $mensaje=$ex->getMessage();
        }
        
        $GLOBALS['oMarca']=$oMarca;
        $GLOBALS['resultado']=$resultado;
        $GLOBALS['mensaje']=$mensaje;
    }
    function post_ajaxDeleteMarca(){
        require ROOT_PATH . 'models/marca.php';
        $ID=$_POST['id'];
        
        try{
            $oMarca=marca::getByID($ID);
            if($oMarca==null){
                $resultado=-1;
                $mensaje="ya no existe la ubicación.";
            }else{
                $oMarca->usuario_mod_id=$_SESSION['usuario_ID'];
                $oMarca->eliminar();
                $resultado=1;
                $mensaje=$oMarca->getMessage;
                if(trim($oMarca->imagen)!=""){
                    $dir_subida = $_SERVER['DOCUMENT_ROOT'].'/files/imagenes/marca/';
                    $fichero_subido = $dir_subida .basename($oMarca->imagen);
                    if(file_exists($fichero_subido)){
                        unlink($fichero_subido);
                    }
                }
                
            }
           
        }catch(Exception $ex){
            $resultado=-1;
            $mensaje=$ex->getMessage();
        }
        
        $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
        echo json_encode($retornar);
        
    }
    //Mensaje
    function get_Mensaje_Configuracion(){
        global $returnView;
        $returnView=true;
   
    }
    function post_ajaxMensaje_Configuracion() {
        require ROOT_PATH . 'models/mensaje.php';
        require ROOT_PATH . 'models/usuario.php';
        require ROOT_PATH . 'controls/funcionController.php';
        $buscar = trim($_POST['txtBuscar']);
        
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
            case 0:
                $orden = 'remitente_ID ' .  $orden_tipo;
                break;
            case 1:
                $orden = 'ID ' . "desc";
                break;
            case 2:
                $orden = 'nombre ' . $orden_tipo;
                break;
            case 3:
                $orden = 'email ' . $orden_tipo;
                break;
            case 4:
                $orden = 'asunto ' . $orden_tipo;
                break;
            case 5:
                $orden = 'mensaje ' . $orden_tipo;
                break;
            case 6:
                $orden = 'archivo ' . $orden_tipo;
                break;
            
            default:
                $orden = 'ID  ' . $orden_tipo;
                break;
        }
        $filtro='empresa_ID='.$_SESSION['empresa_ID'];
       
        if($buscar!=''){
            
            $filtro.= " and upper(nombre) like '%" . str_replace(' ', '%', strtoupper(FormatTextSave($buscar))) . "%'";
        }


        //---------------------------------------					 
        $resultado = '<table id="websendeos" class="grid table table-hover" ><tr>';
        $resultado.='<th> Acción</th>';
        $resultado.='<th  style="display:none;" class="thOrden" onclick="fncOrden(1);">ID' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
        $resultado.='<th  class="thOrden" onclick="fncOrden(0);">Usuario' . (($txtOrden == 0 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
        $resultado.='<th  class="thOrden" onclick="fncOrden(2);">Nombre' . (($txtOrden == 2 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
        $resultado.='<th  class="thOrden" onclick="fncOrden(3);">Email' . (($txtOrden == 3 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
        $resultado.='<th  class="thOrden" onclick="fncOrden(4);">Asunto' . (($txtOrden == 4 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
        $resultado.='<th  class="thOrden" onclick="fncOrden(5);">Mensaje' . (($txtOrden == 5 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
        $resultado.='<th  class="thOrden" onclick="fncOrden(6);">Archivo' . (($txtOrden == 6 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
        $resultado.='</tr>';

        $colspanFooter = 8;
        try {
            $cantidadMaxima = mensaje::getCount($filtro);
            $dtMensaje= mensaje::getGrid($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
            $rows = count($dtMensaje);

            foreach ($dtMensaje as $item) {
                $remitente=($item['remitente_ID']==-1)?"Anonimo":usuario::getByID($item['remitente_ID'])->nombre;
                $archivo=(trim($item['archivo'])!="")?"<a href='../../files/archivos/mensajes/".$item['archivo']."' target='_blank'>".$item['nombre_archivo']."</a>":"";
                
                $resultado.='<tr class="tr-item">';
                $resultado.='<td class="btnAction" style="min-width:100px;">'
                        . '<a onclick="fncEditar(&#39;' . $item['ID'] . '&#39;);"class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Ver detalle" ><span class="glyphicon glyphicon-search"> Ver</a>'
                       .'</td>';
                $resultado.='<td style="display:none;">' .$item['ID'] . '</td>';
                $resultado.='<td>' .FormatTextView($remitente) . '</td>';
                $resultado.='<td>' .FormatTextView($item['nombre']) . '</td>';
                $resultado.='<td>' .FormatTextView($item['email']) . '</td>';
                $resultado.='<td>' .FormatTextView($item['asunto']) . '</td>';
                $resultado.='<td>' .str_replace("--n","<br/>",FormatTextView($item['mensaje'])) . '</td>';
                $resultado.='<td>' .$archivo. '</td>';
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
   
    function get_Mensaje_Configuracion_Editar($id) {
      
        require ROOT_PATH . 'models/mensaje.php';
        require ROOT_PATH . 'models/usuario.php';
        global $returnView_float;
        $returnView_float = true;
        $oMensaje=mensaje::getByID($id);
        $remitente=($oMensaje->remitente_ID==-1)?"Anonimo":usuario::getByID($item['remitente_ID'])->nombre;
        $oMensaje->remitente=$remitente;
        $GLOBALS['oMensaje']=$oMensaje;
    }
    function get_Web_Chat_Session_Configuracion(){
        global $returnView;
        $returnView=true;
   
    }
    function post_ajaxWeb_Chat_Session_Configuracion() {
        require ROOT_PATH . 'models/web_chat_session.php';
        require ROOT_PATH . 'models/usuario.php';
        require ROOT_PATH . 'models/estado.php';
        require ROOT_PATH . 'controls/funcionController.php';
        $buscar = trim($_POST['txtBuscar']);
        
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
                $orden = 'ID ' . "desc";
                break;
            case 2:
                $orden = 'nombre_visitante ' . $orden_tipo;
                break;
            case 3:
                $orden = 'email_visitante ' . $orden_tipo;
                break;
            case 4:
                $orden = 'usuario_remitente_ID ' . $orden_tipo;
                break;
            case 5:
                $orden = 'usuario_receptor_ID ' . $orden_tipo;
                break;
            case 6:
                $orden = 'fecha ' . $orden_tipo;
                break;
            case 7:
                $orden = 'estado_ID ' . $orden_tipo;
                break;
            
            default:
                $orden = 'ID  ' . $orden_tipo;
                break;
        }
        $filtro='empresa_ID='.$_SESSION['empresa_ID'];
       
        if($buscar!=''){
            
            $filtro.= " and upper(nombre_visitante) like '%" . str_replace(' ', '%', strtoupper(FormatTextSave($buscar))) . "%'";
        }


        //---------------------------------------					 
        $resultado = '<table id="websendeos" class="grid table table-hover" ><tr>';
        $resultado.='<th> Acción</th>';
        $resultado.='<th  style="display:none;" class="thOrden" onclick="fncOrden(1);">ID' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
        $resultado.='<th  class="thOrden" onclick="fncOrden(2);">Visitante' . (($txtOrden == 2 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
        $resultado.='<th  class="thOrden" onclick="fncOrden(3);">Email Visita.' . (($txtOrden == 3 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
        $resultado.='<th  class="thOrden" onclick="fncOrden(4);">Usuario Re.' . (($txtOrden == 4 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
        $resultado.='<th  class="thOrden" onclick="fncOrden(5);">Usuario aten.' . (($txtOrden == 5 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
        $resultado.='<th  class="thOrden" onclick="fncOrden(6);">Fecha' . (($txtOrden == 6 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
        $resultado.='<th  class="thOrden" onclick="fncOrden(7);">Estado' . (($txtOrden == 7 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
        $resultado.='</tr>';

        $colspanFooter = 8;
        try {
            $cantidadMaxima = web_chat_session::getCount($filtro);
            $dtWeb_Chat_Session= web_chat_session::getGrid($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
            $rows = count($dtWeb_Chat_Session);

            foreach ($dtWeb_Chat_Session as $item) {
                $remitente=($item['usuario_remitente_ID']==-1)?"Anonimo":usuario::getByID($item['remitente_ID'])->nombre;
                $receptor=($item['usuario_receptor_ID']==-1)?"Ninguno":usuario::getByID($item['usuario_receptor_ID'])->nombre;
                $estado=estado::getByID($item['estado_ID'])->nombre;
                $titulo=($item['estado_ID']==65)?"Chatear":(($item['estado_ID']==66)?"Ocupado":"Ver chat");
                $resultado.='<tr class="tr-item">';
                $resultado.='<td class="btnAction" style="min-width:100px;">'
                        . '<a onclick="fncEditar(&#39;' . $item['ID'] . '&#39;);"class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="'.$titulo.'" ><span class="glyphicon glyphicon-comment"> '.$titulo.'</a>'
                        .'</td>';
                $resultado.='<td style="display:none;">' .$item['ID'] . '</td>';
                $resultado.='<td>' .FormatTextView($item['nombre_visitante']) . '</td>';
                $resultado.='<td>' .FormatTextView($item['email_visitante']) . '</td>';
                $resultado.='<td>' .FormatTextView($remitente) . '</td>';
                $resultado.='<td>' .FormatTextView($receptor) . '</td>';
                $resultado.='<td>' .$item['fecha'] . '</td>';
                $resultado.='<td>' .FormatTextView($estado) . '</td>';
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
   
    function get_Web_Chat_Session_Configuracion_Editar($id) {
      
        require ROOT_PATH . 'models/web_chat_session.php';
        require ROOT_PATH . 'models/web_chat_session_mensaje.php';
        require ROOT_PATH . 'models/usuario.php';
        require ROOT_PATH . 'models/operador.php';
        global $returnView_float;
        $returnView_float = true;
        $oWeb_chat_Session=web_chat_session::getByID($id);
        $oOperador=operador::getByID(usuario::getByID($_SESSION['usuario_ID'])->operador_ID);
        $oWeb_chat_Session->usuario_receptor_ID=$_SESSION['usuario_ID'];
        $usuario_receptor=$oOperador->nombres.' '.$oOperador->apellido_paterno;
        $oWeb_chat_Session->usuario_receptor=$usuario_receptor;
        $dtWeb_Chat_Session_Mensaje=web_chat_session_mensaje::getGrid("web_chat_session_ID=".$id);
        $oWeb_chat_Session->estado_ID=66;
        $oWeb_chat_Session->usuario_mod_id=$_SESSION['usuario_ID'];
        $oWeb_chat_Session->actualizar();
        $GLOBALS['oWeb_chat_Session']=$oWeb_chat_Session;
        $GLOBALS['dtWeb_Chat_Session_Mensaje']=$dtWeb_Chat_Session_Mensaje;
    }
    function post_ajaxEnviarChat(){
            require ROOT_PATH . 'models/web_chat_session.php';
            require ROOT_PATH . 'models/web_chat_session_mensaje.php';
            $usuario_ID_chat=-1;
            $web_chat_session_ID=$_POST['txtWeb_Chat_Session_ID'];
            $texto=FormatTextSave($_POST['texto']);
            $ruta_archivo="";
            
            $resultado=0;
            $mensaje="";
            try{
                $oWeb_Chat_Session_Mensaje=new web_chat_session_mensaje();
                $oWeb_Chat_Session_Mensaje->web_chat_session_ID=$web_chat_session_ID;
                $oWeb_Chat_Session_Mensaje->usuario_ID_chat=$_SESSION['usuario_ID'];
                $oWeb_Chat_Session_Mensaje->mensaje=$texto;
                $oWeb_Chat_Session_Mensaje->ruta_archivo=$ruta_archivo;
                $oWeb_Chat_Session_Mensaje->usuario_id=$_SESSION['usuario_ID'];
                $oWeb_Chat_Session_Mensaje->insertar();
                $resultado=1;
                $mensaje=FormatTextView($oWeb_Chat_Session_Mensaje->getMessage);
            }catch(Exception $ex){
                $resultado=-1;
                $mensaje=$ex->getMessage();
            }
            $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
  
            echo json_encode($retornar);
        }
    function post_ajaxMostrarChat(){
        require ROOT_PATH . 'models/web_chat_session.php';
        require ROOT_PATH . 'models/web_chat_session_mensaje.php';
        require ROOT_PATH . 'models/operador.php';
        require ROOT_PATH . 'models/usuario.php';
        $web_chat_session_ID=$_POST['id'];
        $resultado=0;
        $mensaje="";
        try{
            $oWeb_Chat_Session=web_chat_session::getByID($web_chat_session_ID);
            $usuario_receptor="Atendiendo";
            if($oWeb_Chat_Session->usuario_receptor_ID!=-1){
                $oOperador=operador::getByID(usuario::getByID($oWeb_Chat_Session->usuario_receptor_ID)->operador_ID);
                $usuario_receptor=  FormatTextView($oOperador->nombres." ".$oOperador->apellido_paterno);
            }
            
            $dtWebChatMensaje=web_chat_session_mensaje::getGrid("web_chat_session_ID=".$web_chat_session_ID,-1,-1,"fdc asc");
            $html="<p class='text_chat_operador'><span class='glyphicon glyphicon-headphones'></span> Espere un momento por favor, en breve un ejecutivo lo atenderá</p>";
            foreach($dtWebChatMensaje as $item){
                if($oWeb_Chat_Session->usuario_remitente_ID==$item['usuario_ID_chat']){
                    $html.="<p class='text_chat_invitado'><span class='usuario_chat'>".$oWeb_Chat_Session->nombre_visitante.": </span>";
                    $html.=str_replace("--n","<br/>",FormatTextViewHtml($item['mensaje']));
                }else if($oWeb_Chat_Session->usuario_receptor_ID==$item['usuario_ID_chat']){
                    $html.="<p class='text_chat_operador'><span class='usuario_chat'>".$usuario_receptor.": </span>";
                    $html.=str_replace("--n","<br/>",FormatTextViewHtml($item['mensaje']));
                }
                $html.="<br/><span class='fecha'>".$item['fdc']."</span>";
                $html.="</p>";

            }

            $mensaje=FormatTextView($oWeb_Chat_Session->getMessage);
        }catch(Exception $ex){

            $html=$ex->getMessage();
        }
        $retornar = Array('resultado' => $html);

        echo json_encode($retornar);
    }
    function post_ajaxLogout(){
        require ROOT_PATH . 'models/web_chat_session.php';
        $web_chat_session_ID=$_POST['id'];
        try{
            $oWeb_Chat_Session=web_chat_session::getByID($web_chat_session_ID);
            $oWeb_Chat_Session->estado_ID=67;
            $oWeb_Chat_Session->usuario_mod_id=$_SESSION['usuario_ID'];
            $oWeb_Chat_Session->actualizar();
            $resultado=1;
            $mensaje="Finalizó la sessión del chat.";
        }catch(Exception $ex){
            $resultado=-1;
            $mensaje=$ex->getMessage();
        }
        

        $retornar = Array('resultado' => $resultado,'mensaje'=>$mensaje);

        echo json_encode($retornar);
    }
    function get_Web_Menu_Configuracion(){
       
        global $returnView;
        $returnView=true;
   
    }
    function post_ajaxWeb_Menu_Configuracion() {
        require ROOT_PATH . 'models/web_menu.php';
        
        require ROOT_PATH . 'controls/funcionController.php';
        $buscar = trim($_POST['txtBuscar']);
        
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
                $orden = 'ID ' . $orden_tipo;
                break;
            case 2:
                $orden = 'nombre ' . $orden_tipo;
                break;
            case 3:
                $orden = 'tipo ' . $orden_tipo;
                break;
            case 4:
                $orden = 'descripcion ' . $orden_tipo;
                break;
            default:
                $orden = 'ID ' . $orden_tipo;
                break;
        }
        $filtro='empresa_ID='.$_SESSION['empresa_ID'];
       
        if($buscar!=''){
            
            $filtro.= " and  upper(nombre) like '%" . str_replace(' ', '%', strtoupper(FormatTextSave($buscar))) . "%'";
        }


        //---------------------------------------					 
        $resultado = '<table id="websendeos" class="grid table table-hover" ><tr>';
        $resultado.='<th  class="thOrden" onclick="fncOrden(1);">Código' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
        $resultado.='<th  class="thOrden" onclick="fncOrden(2);">Nombre' . (($txtOrden == 2 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
        $resultado.='<th  class="thOrden" onclick="fncOrden(3);">Tipo' . (($txtOrden == 3 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
        $resultado.='<th  class="thOrden" onclick="fncOrden(4);">Descripción' . (($txtOrden == 4 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
        $resultado.='<th> Acción</th>';
        $resultado.='</tr>';

        $colspanFooter = 5;
        try {
            $cantidadMaxima = web_menu::getCount($filtro);
            $dtWeb_Banner = web_menu::getGrid($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
            $rows = count($dtWeb_Banner);

            foreach ($dtWeb_Banner as $item) {
                
                /*tr-item*/
                $resultado.='<tr id="'.$item['ID'].'" class="tr-item">';
                $resultado.='<td class="tdCenter">' . $item['ID'] . '</td>';
                $resultado.='<td>' . FormatTextView($item['nombre']). '</td>';
                $resultado.='<td class="tdCenter">' . $item['tipo']. '</td>';
                $resultado.='<td>' . FormatTextView($item['descripcion']). '</td>';
                $botones=array();
                array_push($botones,'<a onclick="fncEditar(' . $item['ID'] . ');" ><span class="glyphicon glyphicon-pencil" title="Editar">Editar</a>');
                array_push($botones,'<a onclick="fncLista(' . $item['ID'] . ');" ><span class="glyphicon glyphicon-align-left" title="Lista">Lista</a>');
                array_push($botones,'<a onclick="modal.confirmacion(&#39;El proceso es irreversible, esta seguro de eliminar el registro.&#39;,&#39;Eliminar&#39;,fncEliminar,&#39;' . $item['ID'] . '&#39;);" title="Eliminar"><span class="glyphicon glyphicon-trash">Eliminar</a>');
                $resultado.='<td class="btnaction tdCenter" >'.extraerOpcion($botones)."</td>";
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
    function get_Web_Menu_Configuracion_Nuevo(){
        require ROOT_PATH . 'models/web_menu.php';
        global  $returnView_float;
        $returnView_float=true;
        $oWeb_Menu=new web_menu();
        $GLOBALS['oWeb_Menu']=$oWeb_Menu;
    }
    function post_Web_Menu_Configuracion_Nuevo(){
        require ROOT_PATH . 'models/web_menu.php';
        global  $returnView_float;
        $returnView_float=true;
        $ID=$_POST['txtID'];
        $nombre=FormatTextSave($_POST['txtNombre']);
        $tipo=$_POST['selTipo'];
        $descripcion=FormatTextSave($_POST['txtDescripcion']);
        if($ID==0){
            $oWeb_Menu=new web_menu();
        }else{
            $oWeb_Menu=web_menu::getByID($ID);
            if($oWeb_Menu==null){
                $GLOBALS['resultado']=-2;
                $GLOBALS['mensaje']="El menú ha sido eliminado por otro usuario.";
                return;
            }
        }
        $mensaje="";
        $resultado=0;
        try{
            $oWeb_Menu->nombre=$nombre;
            $oWeb_Menu->tipo=$tipo;
            $oWeb_Menu->empresa_ID=$_SESSION['empresa_ID'];
            $oWeb_Menu->descripcion=$descripcion;
            if($ID==0){
                $oWeb_Menu->usuario_id=$_SESSION['usuario_ID'];
                $oWeb_Menu->insertar();
                $mensaje=$oWeb_Menu->getMessage;
            }else{
                $oWeb_Menu->usuario_mod_id=$_SESSION['usuario_ID'];
                $oWeb_Menu->actualizar();
                $mensaje=$oWeb_Menu->getMessage;
            }
            $resultado=1;
        }  catch (Exception $ex){
            $resultado=-1;
            $mensaje=$ex->getMessage();
        }
        
        $GLOBALS['oWeb_Menu']=$oWeb_Menu;
        $GLOBALS['resultado']=$resultado;
        $GLOBALS['mensaje']=$mensaje;
    }
    function post_ajaxWeb_Menu_Lista() {
        require ROOT_PATH . 'models/web_menu_lista.php';
        require ROOT_PATH . 'controls/funcionController.php';
        $web_menu_ID=$_POST['id'];
        $filtro='web_menu_ID='.$web_menu_ID;
        //---------------------------------------					 
        $resultado = '<table class="table table-hover table-bordered" ><thead><tr>';
        $resultado.='<th>Código</th>';
        $resultado.='<th>Padre</th>';
        $resultado.='<th>Nombre</th>';
        $resultado.='<th>Ruta</th>';
        $resultado.='<th>Orden</th>';
        $resultado.='<th>Tabla</th>';
        $resultado.='<th> Acción</th>';
        $resultado.='</tr></thead>';
        $resultado.='<tbody>';
        $colspanFooter = 7;
        try {
            
            $dtWeb_Menu_Lista = web_menu_lista::getGrid($filtro, -1,-1,"orden");
           
            foreach ($dtWeb_Menu_Lista as $item) {
                
                /*tr-item*/
                $resultado.='<tr>';
                $resultado.='<td class="tdCenter">' . $item['ID'] . '</td>';
                $resultado.='<td class="tdCenter">' . $item['web_menu_lista_ID'] . '</td>';
                $resultado.='<td>' . FormatTextView($item['nombre']). '</td>';
                $resultado.='<td>' . FormatTextView($item['ruta']). '</td>';
                $resultado.='<td class="tdCenter">' . $item['orden'] . '</td>';
                $resultado.='<td class="tdLeft">' . FormatTextView($item['tabla']).'</td>';
                $botones=array();
                array_push($botones,'<a onclick="fncEditar(' . $item['ID'] . ');" ><span class="glyphicon glyphicon-pencil" title="Editar">Editar</a>');
                array_push($botones,'<a onclick="modal.confirmacion(&#39;El proceso es irreversible, esta seguro de eliminar el registro.&#39;,&#39;Eliminar&#39;,fncEliminar,&#39;' . $item['ID'] . '&#39;);" title="Eliminar"><span class="glyphicon glyphicon-trash">Eliminar</a>');
                $resultado.='<td class="btnaction tdCenter" >'.extraerOpcion($botones)."</td>";
                $resultado.='</tr>';
            }

        } catch (Exception $ex) {
            $resultado.='<tr ><td colspan=' . $colspanFooter . '>' . $ex->getMessage() . '</td></tr>';
        }
        $resultado.='</tbody>';
        $resultado.='</table>';

        $mensaje = '';
        $retornar = Array('resultado' => $resultado);
        //$retorn="<h1>Hola</h1>";

        echo json_encode($retornar);
    }
    function get_Web_Menu_Lista_Configuracion_Nuevo($ID){
        require ROOT_PATH . 'models/web_menu_lista.php';
        require ROOT_PATH . 'models/web_menu.php';
        global  $returnView_float;
        $returnView_float=true;
        $oWeb_Menu=web_menu::getByID($ID);
        if($oWeb_Menu==null){
            $GLOBALS['resultado']=-2;
            $GLOBALS['mensaje']="El menú ha sido eliminado.";
            return;
        }
        $oWeb_Menu_Lista=new web_menu_lista();
        $dtWeb_Menu_Lista_Padre=web_menu_lista::getGrid("",-1,-1,"orden asc");
        $oWeb_Menu_Lista->web_menu_ID=$ID;
        $oWeb_Menu_Lista->dtWeb_Menu_Lista_Padre=$dtWeb_Menu_Lista_Padre;
        $GLOBALS['oWeb_Menu_Lista']=$oWeb_Menu_Lista;
        
    }
    function post_Web_Menu_Lista_Configuracion_Nuevo($ID){
        require ROOT_PATH . 'models/web_menu_lista.php';
        require ROOT_PATH . 'models/web_menu.php';
        global  $returnView_float;
        $returnView_float=true;
        $oWeb_Menu=web_menu::getByID($ID);
        if($oWeb_Menu==null){
            $GLOBALS['resultado']=-2;
            $GLOBALS['mensaje']="El menú ha sido eliminado.";
            return;
        }
        $nombre=FormatTextSave($_POST['txtNombre']);
        $ruta=FormatTextSave($_POST['txtRuta']);
        $web_menu_lista_ID=$_POST['selWeb_Menu_Lista'];
        $orden=$_POST['txtOrden'];
        $tabla=FormatTextSave($_POST['txtTabla']);
        $oWeb_Menu_Lista=new web_menu_lista();
        try{
            $oWeb_Menu_Lista->nombre=$nombre;
            $oWeb_Menu_Lista->web_menu_ID=$ID;
            $oWeb_Menu_Lista->ruta=$ruta;
            $oWeb_Menu_Lista->web_menu_lista_ID=$web_menu_lista_ID;
            $oWeb_Menu_Lista->orden=$orden;
            $oWeb_Menu_Lista->tabla=$tabla;
            $oWeb_Menu_Lista->usuario_id=$_SESSION['usuario_ID'];
            $oWeb_Menu_Lista->insertar();
            $resultado=1;
            $mensaje=$oWeb_Menu_Lista->getMessage;
        }catch(Exception $ex){
            $resultado=-1;
            $mensaje=$ex->getMessage();
        }
        
        $dtWeb_Menu_Lista_Padre=web_menu_lista::getGrid("",-1,-1,"orden asc");
        //$oWeb_Menu_Lista->web_menu_ID=$ID;
        $oWeb_Menu_Lista->dtWeb_Menu_Lista_Padre=$dtWeb_Menu_Lista_Padre;
        $GLOBALS['oWeb_Menu_Lista']=$oWeb_Menu_Lista;
        $GLOBALS['resultado']=$resultado;
        $GLOBALS['mensaje']=$mensaje;
    }
    function get_Web_Menu_Lista_Configuracion_Editar($ID){
        require ROOT_PATH . 'models/web_menu_lista.php';
        require ROOT_PATH . 'models/web_menu.php';
        global  $returnView_float;
        $returnView_float=true;
        $oWeb_Menu_Lista=web_menu_lista::getByID($ID);
        if($oWeb_Menu_Lista==null){
            $GLOBALS['resultado']=-2;
            $GLOBALS['mensaje']="El menú ha sido eliminado.";
            return;
        }
        $oWeb_Menu=web_menu::getByID($oWeb_Menu_Lista->web_menu_ID);
        if($oWeb_Menu==null){
            $GLOBALS['resultado']=-2;
            $GLOBALS['mensaje']="El menú ha sido eliminado.";
            return;
        }
        
        $dtWeb_Menu_Lista_Padre=web_menu_lista::getGrid("",-1,-1,"orden asc");
        
        $oWeb_Menu_Lista->dtWeb_Menu_Lista_Padre=$dtWeb_Menu_Lista_Padre;
        $GLOBALS['oWeb_Menu_Lista']=$oWeb_Menu_Lista;
        
    }
    function post_Web_Menu_Lista_Configuracion_Editar($ID){
        require ROOT_PATH . 'models/web_menu_lista.php';
        require ROOT_PATH . 'models/web_menu.php';
        global  $returnView_float;
        $returnView_float=true;
        $nombre=FormatTextSave(trim($_POST['txtNombre']));
        $ruta=FormatTextSave(trim($_POST['txtRuta']));
        $web_menu_lista_ID=$_POST['selWeb_Menu_Lista'];
        $orden=$_POST['txtOrden'];
        $tabla=FormatTextSave(trim($_POST['txtTabla']));
        $oWeb_Menu_Lista=web_menu_lista::getByID($ID);
        if($oWeb_Menu_Lista==null){
            $GLOBALS['resultado']=-2;
            $GLOBALS['mensaje']="El menú ha sido eliminado.";
            return;
        }
        $oWeb_Menu=web_menu::getByID($oWeb_Menu_Lista->web_menu_ID);
        if($oWeb_Menu==null){
            $GLOBALS['resultado']=-2;
            $GLOBALS['mensaje']="El menú ha sido eliminado.";
            return;
        }
        
        $oWeb_Menu_Lista=web_menu_lista::getByID($ID);
        try{
            $oWeb_Menu_Lista->nombre=$nombre;
            $oWeb_Menu_Lista->web_menu_ID=$ID;
            $oWeb_Menu_Lista->ruta=$ruta;
            $oWeb_Menu_Lista->web_menu_lista_ID=$web_menu_lista_ID;
            $oWeb_Menu_Lista->orden=$orden;
            $oWeb_Menu_Lista->tabla=$tabla;
            $oWeb_Menu_Lista->usuario_mod_id=$_SESSION['usuario_ID'];
            $oWeb_Menu_Lista->actualizar();
            $resultado=1;
            $mensaje=$oWeb_Menu_Lista->getMessage;
        }catch(Exception $ex){
            $resultado=-1;
            $mensaje=$ex->getMessage();
        }
        
        $dtWeb_Menu_Lista_Padre=web_menu_lista::getGrid("",-1,-1,"orden asc");
        //$oWeb_Menu_Lista->web_menu_ID=$ID;
        $oWeb_Menu_Lista->dtWeb_Menu_Lista_Padre=$dtWeb_Menu_Lista_Padre;
        $GLOBALS['oWeb_Menu_Lista']=$oWeb_Menu_Lista;
        $GLOBALS['resultado']=$resultado;
        $GLOBALS['mensaje']=$mensaje;
    }
    function get_Web_Menu_Configuracion_Editar($ID){
        require ROOT_PATH . 'models/web_menu.php';
        global  $returnView_float;
        $returnView_float=true;
        $oWeb_Menu=web_menu::getByID($ID);
        if($oWeb_Menu==null){
            $GLOBALS['resultado']=-2;
            $GLOBALS['mensaje']="El menú ha sido eliminado.";
            return;
        }
        $GLOBALS['oWeb_Menu']=$oWeb_Menu;
    }
    function post_Web_Menu_Configuracion_Editar($ID){
        require ROOT_PATH . 'models/web_menu.php';
        global  $returnView_float;
        $returnView_float=true;
        $nombre=FormatTextSave(trim($_POST['txtNombre']));
        $tipo=$_POST['selTipo'];
        $descripcion=FormatTextSave(trim($_POST['txtDescripcion']));
        $oWeb_Menu=web_menu::getByID($ID);
        if($oWeb_Menu==null){
            $GLOBALS['resultado']=-2;
            $GLOBALS['mensaje']="El menú ha sido eliminado por otro usuario.";
            return;
        }
        $mensaje="";
        $resultado=0;
        try{
            $oWeb_Menu->nombre=$nombre;
            $oWeb_Menu->tipo=$tipo;
            $oWeb_Menu->empresa_ID=$_SESSION['empresa_ID'];
            $oWeb_Menu->descripcion=$descripcion;
            $oWeb_Menu->usuario_mod_id=$_SESSION['usuario_ID'];
            $oWeb_Menu->actualizar();
            $mensaje=$oWeb_Menu->getMessage;
            $resultado=1;
        }  catch (Exception $ex){
            $resultado=-1;
            $mensaje=$ex->getMessage();
        }
        
        $GLOBALS['oWeb_Menu']=$oWeb_Menu;
        $GLOBALS['resultado']=$resultado;
        $GLOBALS['mensaje']=$mensaje;
    }
?>