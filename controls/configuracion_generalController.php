<?php

/* Vista de proveedores */

function get_Index($id) {
    global $returnView;
    $returnView = true;
}
function get_Usuario_Mantenimiento(){
    require ROOT_PATH.'models/usuario.php';
    require ROOT_PATH.'models/estado.php';
    require ROOT_PATH.'models/perfil.php';
    global $returnView;
    $returnView = true;
    $oUsuario=new usuario();
    $oUsuario->dtEstado=estado::getGrid("est.tabla='usuario'",-1,-1,"est.orden asc");
    $oUsuario->dtPerfil=perfil::getGrid("",-1,-1,"nombre asc");
    $GLOBALS['oUsuario']=$oUsuario;
    //$GLOBALS['mensaje']='';
}
function post_ajaxUsuario_Mantenimiento() {
    require ROOT_PATH . 'models/usuario.php';
    require ROOT_PATH . 'models/perfil.php';
    require ROOT_PATH . 'models/estado.php';
    require ROOT_PATH . 'controls/funcionController.php';
    $buscar = $_POST['txtBuscar'];
    $paginaActual = $_POST['num_page'] == 0 ? 1 : $_POST['num_page'];
    $cantidadMostrar = $_POST['txtMostrar'] == '' ? 30 : $_POST['txtMostrar'];
    $opcion_tipo=$_POST['rbOpcion'];
    $txtOrden = $_POST['txtOrden'];
    $orden_tipo = 'DESC';
    $orden_class = 'imgOrden-desc';
    $estado_ID=$_POST['selEstado'];
    $perfil_ID=$_POST['selPerfil'];
    
    if (isset($_POST['chkOrdenASC'])) {
        $orden_class = 'imgOrden-asc';
        $orden_tipo = 'ASC';
    }
    
    switch ($txtOrden) {
        case 1:
            $orden = 'pe.apellido_paterno ' . $orden_tipo;
            break;
        case 2:
            $orden = 'pe.apellido_materno ' . $orden_tipo;
            break;
        case 3:
            $orden = 'pe.nombres ' . $orden_tipo;
            break;
        case 4:
            $orden = 'u.nombre ' . $orden_tipo;
            break;
        case 5:
            $orden = 'u.contraseña ' . $orden_tipo;
            break;
        case 6:
            $orden = 'per.nombre ' . $orden_tipo;
            break;
        case 7:
            $orden = 'es.nombre ' . $orden_tipo;
            break;
        
        default:
            $orden = 'u.ID  desc';
            break;
    }
    $filtro="";
    if($opcion_tipo=="buscar"){
        if(trim($buscar)!=""){
            $filtro="upper(concat(pe.apellido_paterno,' ',pe.apellido_materno,' ',pe.nombres)) like upper('%". $buscar."%')";
        }   
    }else {
       
        if($estado_ID!=0){
            if($filtro!=""){
                $filtro.=" and ";
            }
            $filtro.="u.estado_ID=".$estado_ID;
        }
        
        /*if($perfil_ID!=0){
            if($filtro!=""){
                $filtro.=" and ";
            }
            $filtro.="u.perfil_ID=".$perfil_ID;
        }*/

       
    }

    // $filtro.= 'upper(concat(cl.razon_social," ",cl.ruc)) like "%' . str_replace(' ', '%', strtoupper(FormatTextSave($buscar))) . '%"';

    //---------------------------------------					 
    $resultado = '<table id="websendeos" class="grid table table-hover table-bordered table-teal"><thead><tr>';
    $resultado.='<th class="thOrden" onclick="fncOrden(0);">ID</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(1);">Apellido paterno' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(2);">Apellido materno' . (($txtOrden == 2 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(3);">Nombres' . (($txtOrden == 3 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(4);">Usuario' . (($txtOrden == 4 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(5);">Contraseña.' . (($txtOrden == 5 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(6);">Perfil' . (($txtOrden == 6 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(7);">Estado' . (($txtOrden == 7 ? "<img class=" . $orden_class . " />" : "")) . '</th>';

    $resultado.='<th></th>';
    $resultado.='</tr></thead>';
    $resultado.='<tbody>';
    $colspanFooter = 9;
    try {
        $cantidadMaxima = usuario::getCount($filtro);
       
        $dtUsuario = usuario::getGrid($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
        $rows = count($dtUsuario);
        
       $i=1;
       //print_r($dtUsuario);
        foreach ($dtUsuario as $item) {
            
            $resultado.='<tr class="tr-item" >';
            $resultado.='<td>'.$i.'</td>';
            $resultado.='<td class="tdLeft">' . utf8_encode(strtoupper($item['apellido_paterno'])) . '</td>';
            $resultado.='<td class="tdLeft">' . utf8_encode(strtoupper($item['apellido_materno'])). '</td>';
            $resultado.='<td class="tdLeft">' . utf8_encode(strtoupper($item['nombres'])) . '</td>';
            $resultado.='<td class="tdLeft">' . utf8_encode(strtoupper($item['usuario'])) . '</td>';
            $resultado.='<td class="tdLeft">' . utf8_encode(strtoupper($item['password'])). '</td>';
            $resultado.='<td class="tdLeft"></td>';
            $resultado.='<td class="tdLeft">' . utf8_encode(strtoupper($item['estado'])) . '</td>';
            $botones=array();
            if($item['ID']>0){
                $boton='<a onclick="fncEditar(' . $item['ID'] . ');" title="Editar"><span class="glyphicon glyphicon-pencil"></span> Editar</a>';
                array_push($botones,$boton);
                array_push($botones,'<a onclick="fncMenu(' . $item['ID'] . ');" title="Asignar menu"><span class="glyphicon glyphicon-align-left"></span>Asignar Menu</a>');
                array_push($botones,'<a onclick="fncReporte(' . $item['ID'] . ');" title="Asignar reporte"><i class="fa fa-file-pdf-o"></i> Asignar Reporte</a>');
                
                array_push($botones,'<a onclick="fncPerfil(' . $item['ID'] . ');" title="Asignar perfil"><i class="fa fa-users"></i>Asignar Perfil</a>');
                array_push($botones,'<a onclick="fncEliminar(' . $item['ID'] . ');" title="Eliminar usuario"><span class="glyphicon glyphicon-trash"></span>&nbsp;Eliminar</a>');

            }
            
            $resultado.='<td class="btnAction" >'.extraerOpcion($botones)."</td>";
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
function get_Usuario_Mantenimiento_Nuevo() {
    require ROOT_PATH . 'models/usuario.php';
    //require ROOT_PATH . 'models/perfil.php';
    require ROOT_PATH . 'models/operador.php';
    require ROOT_PATH . 'models/estado.php';
    require ROOT_PATH . 'models/persona.php';
    require ROOT_PATH . 'models/empresa.php';
   
    global $returnView_float;
    $returnView_float = true;
    $oUsuario = new usuario();
    $oUsuario->foto="user-default.png";
    $dtPersona=persona::getGrid("",-1,-1,"apellido_paterno,apellido_materno,nombres");
    $dtEstado=estado::getGrid('est.tabla="usuario"');
    //$dtPerfil = perfil::getGrid("",-1,-1,"nombre asc");
    $dtEmpresa=empresa::getGrid("",-1,-1,"nombre asc");
    $oUsuario->dtEstado=$dtEstado;
    //$oUsuario->dtPerfil=$dtPerfil;
    $oUsuario->dtEmpresa=$dtEmpresa;
    $GLOBALS['dtPersona'] = $dtPersona;
    $GLOBALS['oUsuario'] = $oUsuario;
  
}

//graba los datos que se recuperan por el metodo post en nuevo usuario
function post_Usuario_Mantenimiento_Nuevo() {
    require ROOT_PATH . 'models/usuario.php';
    require ROOT_PATH . 'models/perfil.php';
    require ROOT_PATH . 'models/estado.php';
    //require ROOT_PATH . 'models/configuracion.php';
    require ROOT_PATH . 'models/persona.php';
    global $returnView_float;
    $returnView_float = true;
    $persona_ID = $_POST['selPersona'];
    $nombre = FormatTextSave($_POST['txtNombre']);
    $password =FormatTextSave($_POST['txtPassword']);
    //$perfil_ID = $_POST['selPerfil'];
    $estado_ID = $_POST['selEstado'];
    $correo=$_POST['txtCorreo'];
    //$foto=$_POST['foto'];
//    $usuario_ID = $_POST['txtUsuario_ID']; 
    $oUsuario = new usuario(); 
    try {  
        $dtConfiguracion=configuracion::getGrid();
        $oUsuario->persona_ID = $persona_ID;
        $oUsuario->nombre = $nombre;
        $oUsuario->password = $password;
        //$oUsuario->perfil_ID = $perfil_ID;
        $oUsuario->estado_ID = $estado_ID;
        $oUsuario->correo=$correo;
        $oUsuario->usuario_id = $_SESSION['usuario_ID'];
        if ($oUsuario->verificarDuplicado() > 0) {
            throw new Exception($oUsuario->getMessage);
        }
        $oUsuario->insertar();
       $mensaje="Se gardó correctamente.";
       $resultado=1;
        if($_FILES['foto']['tmp_name']!=""){
                $dir_subida = ruta_guardar_archivos.'/imagenes/foto_usuario/';
                if(!file_exists($dir_subida)){
                    $mensaje="No existe la ruta,".$dir_subida.", por favor verificar en la configuración.";
                    $resultado=-1;
                }else{
                    $nombre_temporal=explode('.',basename($_FILES['foto']['name']));
                    $extension=(strtoupper($nombre_temporal[1])=="JPG"||strtoupper($nombre_temporal[1])=="png"||strtoupper($nombre_temporal[1])=="gif")?$nombre_temporal[1]:"JPG";
                    $nombre1=$oUsuario->ID.'.'.$extension;
                    $fichero_subido = $dir_subida .basename($nombre1);
                    
                    $array_dimension=explode("x", dimension_imagen_perfil);
                   
                    $lienzo=imagecreatetruecolor($array_dimension[0],$array_dimension[1]); 
                    $rtOriginal=$_FILES['foto']['tmp_name'];
                    
                    if($_FILES['foto']['type']=='image/jpeg'){
                    $original = imagecreatefromjpeg($rtOriginal);
                    }
                    else if($_FILES['foto']['type']=='image/png'){
                    $original = imagecreatefrompng($rtOriginal);
                    }
                    else if($_FILES['foto']['type']=='image/gif'){
                    $original = imagecreatefromgif($rtOriginal);
                    }
                    list($ancho,$alto)=getimagesize($rtOriginal);
                    imagecopyresampled($lienzo,$original,0,0,0,0,$array_dimension[0], $array_dimension[1],$ancho,$alto);
                    if($_FILES['foto']['type']=='image/jpeg'){
                        imagejpeg($lienzo,$fichero_subido);
                        }
                    else if($_FILES['foto']['type']=='image/png'){
                        imagepng($lienzo,$fichero_subido);
                    }
                    else if($_FILES['foto']['type']=='image/gif'){
                        imagegif($lienzo,$fichero_subido);
                    }
                    $oUsuario->foto=$nombre1;
                    $oUsuario->usuario_mod_id=$_SESSION['usuario_ID'];
                    $oUsuario->actualizar();    
                    /*if (move_uploaded_file($_FILES['foto']['tmp_name'], $fichero_subido)) {
                        $rtOriginal=$_FILES['foto']['tmp_name'];
                        

                        

                    
                        $oUsuario->foto=$nombre1;
                        $oUsuario->usuario_mod_id=$_SESSION['usuario_ID'];
                        $oUsuario->actualizar();
                        
                    }else{$mensaje="Se guardó la información, pero no se subió el logo.";}*/
                }
                
            
        }
        
        
    } catch (Exception $ex) {
        $resultado=-1;
        $mensaje=mensaje_error;
       log_error(__FILE__,"COnfiguracion_General/post_Usuario_Mantenimiento_Nuevo",$ex->getMessage());
        
    }
    $dtPersona=persona::getGrid("",-1,-1,"apellido_paterno,apellido_materno,nombres");
    $dtEstado=estado::getGrid('est.tabla="usuario"');
    $dtPerfil = perfil::getGrid("",-1,-1,"nombre asc");
    $oUsuario->dtEstado=$dtEstado;
    $oUsuario->dtPerfil=$dtPerfil;
    $GLOBALS['dtPersona'] = $dtPersona;
    $GLOBALS['oUsuario'] = $oUsuario;
    $GLOBALS['resultado'] = $resultado;
    $GLOBALS['mensaje'] = $mensaje;
}

//muestra la ventana editar proveedor
function get_Usuario_Mantenimiento_Editar($id) {
    require ROOT_PATH . 'models/usuario.php';
    require ROOT_PATH . 'models/estado.php';
    
    require ROOT_PATH . 'models/persona.php';    
    global $returnView_float;
    $returnView_float = true;

    try{
        $oUsuario = usuario::getByID($id);
        $oPersona=persona::getByID($oUsuario->persona_ID);
        $oUsuario->oPersona=$oPersona;
       if ($oUsuario == null) {
           throw new Exception('Parecer que el registro ya fue eliminado.');
     
        } 
    }catch(Exception $ex){
        $GLOBALS['mensaje']=$ex->getMessage();
        $GLOBALS['resultado']=-1;
    }
    $dtPersona=persona::getGrid("",-1,-1,"apellido_paterno,apellido_materno,nombres");
    $dtEstado=estado::getGrid('est.tabla="usuario"');
    //$dtPerfil = perfil::getGrid("",-1,-1,"nombre asc");
    $oUsuario->dtEstado=$dtEstado;
    //$oUsuario->dtPerfil=$dtPerfil;
    $GLOBALS['dtPersona'] = $dtPersona;
    $GLOBALS['oUsuario'] = $oUsuario;
}

//graba los datos que se recuperan por el metodo post en editar proveedor
function post_Usuario_Mantenimiento_Editar($id) {
    require ROOT_PATH . 'models/usuario.php';
    require ROOT_PATH . 'models/estado.php';
    require ROOT_PATH . 'models/perfil.php';
    require ROOT_PATH . 'models/persona.php';
    global $returnView_float;
    $returnView_float = true;
    $oUsuario = usuario::getByID($id);
    if ($oUsuario == null) {
        throw  new Exception('Parecer que el registro ya fue eliminado.');
       
    }
    $persona_ID = $_POST['selPersona'];
    $nombre = FormatTextSave($_POST['txtNombre']);
    $password =FormatTextSave($_POST['txtPassword']);
    //$perfil_ID = $_POST['selPerfil'];
    $estado_ID = $_POST['selEstado'];
    $correo=$_POST['txtCorreo'];
    try {
        $oUsuario->persona_ID = $persona_ID;
        $oUsuario->nombre = $nombre;
        $oUsuario->password = $password;
        //$oUsuario->perfil_ID = $perfil_ID;
        $oUsuario->estado_ID = $estado_ID;
        $oUsuario->correo=$correo;
        $oUsuario->usuario_mod_id = $_SESSION['usuario_ID'];
        if ($oUsuario->verificarDuplicado() > 0) {
            throw new Exception($oUsuario->getMessage);
        }
        if($_FILES['foto']['tmp_name']!=""){
                $dir_subida = $dtConfiguracion[5]['valores'].'/imagenes/foto_usuario/';
                $nombre_temporal=explode('.',basename($_FILES['foto']['name']));
                $extension=(strtoupper($nombre_temporal[1])=="JPG"||strtoupper($nombre_temporal[1])=="png"||strtoupper($nombre_temporal[1])=="gif")?$nombre_temporal[1]:"JPG";
                $nombre1=$oUsuario->ID.'.'.$extension;
                $fichero_subido = $dir_subida .basename($nombre1);
                
                if (move_uploaded_file($_FILES['foto']['tmp_name'], $fichero_subido)) {
                   
                    $oUsuario->foto=$nombre1;
        
                }else{$mensaje="Se guardó la información, pero no se subió el logo.";}
        }
        $oUsuario->actualizar();
    
        $GLOBALS['resultado'] = 1;
        $GLOBALS['mensaje'] = $oUsuario->getMessage;
    } catch (Exception $ex) {
        $GLOBALS['resultado'] = -1;
        $GLOBALS['mensaje'] = $ex->getMessage();
    }
    $dtEstado=estado::getGrid('est.tabla="usuario"');
    $dtPerfil = perfil::getGrid("",-1,-1,"nombre asc");
    $oUsuario->dtEstado=$dtEstado;
    $oUsuario->dtPerfil=$dtPerfil;
    $GLOBALS['oUsuario'] = $oUsuario;
}
function get_Usuario_Mantenimiento_Menu($id) {
    require ROOT_PATH . 'models/usuario.php';
    require ROOT_PATH . 'models/persona.php';   
    require ROOT_PATH . 'models/menu.php';
    require ROOT_PATH . 'models/empresa.php';
    require ROOT_PATH . 'models/modulo_empresa.php';
    
    global $returnView_float;
    $returnView_float = true;
    $oUsuario = usuario::getByID($id);
    try{
        
        $oPersona=persona::getByID($oUsuario->persona_ID);
        
        $oUsuario->oPersona=$oPersona;
        if ($oUsuario == null) {
           throw new Exception('Parecer que el registro ya fue eliminado.');
     
        } 
        $dtEmpresa=empresa::getGrid("",-1,-1,"nombre asc");
        $oUsuario->dtEmpresa=$dtEmpresa;
        if(count($dtEmpresa)>0){
           $oUsuario->dtModulo=modulo_empresa::getGrid("moe.empresa_ID=".$dtEmpresa[0]['ID'],-1,-1,"mo.nombre asc");
        }
    }catch(Exception $ex){
        $GLOBALS['mensaje']=$ex->getMessage();
        $GLOBALS['resultado']=-1;
    }

    $GLOBALS['oUsuario'] = $oUsuario;
}
function post_Usuario_Mantenimiento_Menu($id) {
    require ROOT_PATH . 'models/usuario.php';
    require ROOT_PATH . 'models/persona.php';   
    require ROOT_PATH . 'models/menu.php';
    require ROOT_PATH . 'models/menu_usuario.php';
    require ROOT_PATH . 'models/empresa.php';
    require ROOT_PATH . 'models/modulo_empresa.php';
    
    global $returnView_float;
    $returnView_float = true;
    $empresa_ID=$_POST['selEmpresa'];
    $modulo_ID=$_POST['selModulo'];
    try{
        $oUsuario = usuario::getByID($id);
        
        if ($oUsuario == null) {
           throw new Exception('Parecer que el registro ya fue eliminado.');
     
        }
        if($modulo_ID>0){
            $dtMenu=menu::getGrid("mn.modulo_ID=".$modulo_ID,-1,-1,"mn.nombre asc");
            foreach($dtMenu as $item){
                if(isset($_POST[$item['ID']])){
                    $menu_ID=$item['ID'];
                    $contar=menu_usuario::getCount("menu_ID=".$menu_ID." and usuario_ID=".$id);
                    if($contar==0){
                        $oMenu_Usuario=new menu_usuario();
                        $oMenu_Usuario->menu_ID=$menu_ID;
                        $oMenu_Usuario->usuario_ID=$id;
                        $oMenu_Usuario->usuario_id_creacion=$_SESSION['usuario_ID'];
						$oMenu_Usuario->empresa_ID=empresa_ID;
                        $oMenu_Usuario->insertar();
                    }

                }else{
                    $contar=menu_usuario::getCount("menu_ID=".$item['ID']." and usuario_ID=".$id." and empresa_ID=".$empresa_ID);
                    if($contar>0){
                        $oMenu_Usuario=new menu_usuario();
                        $oMenu_Usuario->usuario_mod_id=$_SESSION['usuario_ID'];
                        $oMenu_Usuario->usuario_ID=$id;
                        $oMenu_Usuario->menu_ID=$item['ID'];
                        $oMenu_Usuario->eliminar();
                    }
                }

            }
         
        }
        
        
        $GLOBALS['resultado']=1;
        $GLOBALS['mensaje']="Se guardó correctamente.";
    }catch(Exception $ex){
        $GLOBALS['mensaje']=$ex->getMessage();
        $GLOBALS['resultado']=-1;
    }
    $dtEmpresa=empresa::getGrid("",-1,-1,"nombre asc");
    $oUsuario->dtEmpresa=$dtEmpresa;
    if(count($dtEmpresa)>0){
       $oUsuario->dtModulo=modulo_empresa::getGrid("moe.empresa_ID=".$dtEmpresa[0]['ID'],-1,-1,"mo.nombre asc");
    }
    $GLOBALS['oUsuario'] = $oUsuario;
}
function get_Usuario_Mantenimiento_Reporte($id) {
    require ROOT_PATH . 'models/usuario.php';
    require ROOT_PATH . 'models/persona.php';   
    require ROOT_PATH . 'models/menu.php';
    require ROOT_PATH . 'models/empresa.php';
    require ROOT_PATH . 'models/modulo_empresa.php';
    require ROOT_PATH . 'models/reportes_empresa.php';
    global $returnView_float;
    $returnView_float = true;
    $oUsuario = usuario::getByID($id);
    try{
        
        $oPersona=persona::getByID($oUsuario->persona_ID);
        
        $oUsuario->oPersona=$oPersona;
        if ($oUsuario == null) {
           throw new Exception('Parecer que el registro ya fue eliminado.');
     
        } 
        
        $dtEmpresa=empresa::getGrid("ID<>1",-1,-1,"nombre asc");
        
        $oUsuario->dtEmpresa=$dtEmpresa;
        
    }catch(Exception $ex){
        $GLOBALS['mensaje']=$ex->getMessage();
        $GLOBALS['resultado']=-1;
    }

    $GLOBALS['oUsuario'] = $oUsuario;
}
function post_ajaxGrabarMenu_Usuario(){
    require ROOT_PATH . 'models/menu_usuario.php';
    $lista_menu=$_POST['lista_menu'];
    $usuario_ID=$_POST['usuario_ID'];
    $modulo_ID=$_POST['modulo_ID'];
	$empresa_ID=$_POST['selEmpresa'];
    try{
        $retorna=menu_usuario::registrar($usuario_ID,$lista_menu,$modulo_ID,$empresa_ID);
        $resultado=1;
        $mensaje="Se registró correctamente";
    }catch(Exception $ex){
        $resultado=-1;
        $mensaje=mensaje_error;
    }
    $retornar = Array('resultado' => $resultado,"mensaje"=>$mensaje);
    echo json_encode($retornar);
    
}
function post_ajaxGrabarReportes_Usuario(){
    require ROOT_PATH . 'models/reportes_empresa_usuario.php';
    $lista_reportes=$_POST['lista_reportes'];
    $usuario_ID=$_POST['usuario_ID'];
    
    try{
        $retorna=reportes_empresa_usuario::registrar($usuario_ID,$lista_reportes);
        $resultado=1;
        $mensaje="Se registró correctamente";
    }catch(Exception $ex){
        $resultado=-1;
        $mensaje=mensaje_error;
    }
    $retornar = Array('resultado' => $resultado,"mensaje"=>$mensaje);
    echo json_encode($retornar);
    
}
function get_Usuario_Mantenimiento_Perfil($id) {
    require ROOT_PATH . 'models/perfil.php';
    require ROOT_PATH . 'models/empresa.php';
    require ROOT_PATH . 'models/usuario.php';
    global $returnView_float;
    $returnView_float = true;
    $oUsuario = usuario::getByID($id);
    
    try{
       
        $dtEmpresa=empresa::getGrid("",-1,-1,"nombre asc");
        $html="<table class='table table-hover table-bordered'><tr><thead>";
        $html.="<th><b>Empresa</b></th>";
        foreach($dtEmpresa as $item){
            $html.="<th>".FormatTextView($item['nombre'])."</th>";
        }
        $html.="</tr></thead>";
        $html.="<tbody>";
        $dtPerfil=perfil::getGrid("",-1,-1,"p.nombre asc");
        $i=0;
        foreach($dtPerfil as $iperfil){
            $html.="<tr>";
            if($i==0){
                $html.="<td rowspan='5' style='vertical-align: middle;'><b>Perfiles</b></td>";
            }
            
            foreach($dtEmpresa as $iempresa){
                $html.="<td><div class='ckbox ckbox-theme'><input type='checkbox' id='".$iperfil['ID']."-".$iempresa['ID']."'><label for='".$iperfil['ID']."-".$iempresa['ID']."'>".FormatTextView($iperfil['nombre'])."</label></div></td>";
            }
            $html.="</tr>";
            $i++;
        }
        
        $html.="</tbody>";
        $html.="</table>";
        $GLOBALS['table']=$html;
    }catch(Exception $ex){
        $GLOBALS['mensaje']=$ex->getMessage();
        $GLOBALS['resultado']=-1;
    }

    $GLOBALS['oUsuario'] = $oUsuario;
}
function post_Usuario_Mantenimiento_Perfil($id) {
    require ROOT_PATH . 'models/usuario.php';
    require ROOT_PATH . 'models/persona.php';   
    require ROOT_PATH . 'models/menu.php';
    require ROOT_PATH . 'models/menu_usuario.php';
    require ROOT_PATH . 'models/empresa.php';
    require ROOT_PATH . 'models/modulo_empresa.php';
    
    global $returnView_float;
    $returnView_float = true;
    $empresa_ID=$_POST['selEmpresa'];
    $modulo_ID=$_POST['selModulo'];
    try{
        $oUsuario = usuario::getByID($id);
        
        if ($oUsuario == null) {
           throw new Exception('Parecer que el registro ya fue eliminado.');
     
        }
        if($modulo_ID>0){
            $dtMenu=menu::getGrid("mn.modulo_ID=".$modulo_ID,-1,-1,"mn.nombre asc");
            foreach($dtMenu as $item){
                if(isset($_POST[$item['ID']])){
                    $menu_ID=$item['ID'];
                    $contar=menu_usuario::getCount("menu_ID=".$menu_ID." and usuario_ID=".$id);
                    if($contar==0){
                        $oMenu_Usuario=new menu_usuario();
                        $oMenu_Usuario->menu_ID=$menu_ID;
                        $oMenu_Usuario->usuario_ID=$id;
                        $oMenu_Usuario->usuario_id_creacion=$_SESSION['usuario_ID'];
                        $oMenu_Usuario->insertar();
                    }

                }else{
                    $contar=menu_usuario::getCount("menu_ID=".$item['ID']." and usuario_ID=".$id);
                    if($contar>0){
                        $oMenu_Usuario=new menu_usuario();
                        $oMenu_Usuario->usuario_mod_id=$_SESSION['usuario_ID'];
                        $oMenu_Usuario->usuario_ID=$id;
                        $oMenu_Usuario->menu_ID=$item['ID'];
                        $oMenu_Usuario->eliminar();
                    }
                }

            }
         
        }
        
        
        $GLOBALS['resultado']=1;
        $GLOBALS['mensaje']="Se guardó correctamente.";
    }catch(Exception $ex){
        $GLOBALS['mensaje']=$ex->getMessage();
        $GLOBALS['resultado']=-1;
    }
    $dtEmpresa=empresa::getGrid("",-1,-1,"nombre asc");
    $oUsuario->dtEmpresa=$dtEmpresa;
    if(count($dtEmpresa)>0){
       $oUsuario->dtModulo=modulo_empresa::getGrid("moe.empresa_ID=".$dtEmpresa[0]['ID'],-1,-1,"mo.nombre asc");
    }
    $GLOBALS['oUsuario'] = $oUsuario;
}
function post_ajaxExtraer_Menu_Modulo(){
    require ROOT_PATH . 'models/menu.php';
    //require ROOT_PATH . 'models/menu_usuario.php';
    //require ROOT_PATH . 'models/modulo.php';
    $usuario_ID=$_POST['usuario_ID'];
    $modulo_ID=$_POST['modulo_ID'];
	$empresa_ID=$_POST['selEmpresa'];
    $html="";
    try {
        /*$dtMenu=menu::getGrid("mn.modulo_ID=".$modulo_ID,-1,-1,"mn.nombre asc");
        if(count($dtMenu)>0){
            foreach($dtMenu as $item){
                $registrado=menu_usuario::getCount("usuario_ID=".$usuario_ID." and menu_ID=".$item['ID']);
                $html.="<div class='row'>"; 
                $html.="<div class='col-xs-9'><div class='ckbox ckbox-theme'><input type='checkbox' id='".$item['ID']."' name='".$item['ID']."' ".(($registrado>0)? 'checked':'')."/><label for='".$item['ID']."'>".utf8_encode($item['nombre'])."</label></div></div>"; 
                $html.="</div>"; 
            }
        }else{
            $html.="No tiene menú";
        }
        */
        
        $html=menu::getListaMenuModulo($modulo_ID,$usuario_ID,$empresa_ID);
    }catch (Exception $ex) {
        log_error(__FILE__,"configuracion_generaleController/post_ajaxExtraer_Menu_Modulo",$ex->getMessage());
        $html.=utf8_encode(mensaje_error);
    }
    
    $retornar = Array('html' => $html);
    echo json_encode($retornar);
}
function post_ajaxExtraer_Reportes_Empresa(){
    require ROOT_PATH . 'models/reportes_empresa.php';
   
    $usuario_ID=$_POST['id'];
    $empresa_ID=$_POST['id1'];
    $html="";
    try {
        $html=reportes_empresa::getLista_Reportes($empresa_ID,$usuario_ID);
        
       
    }catch (Exception $ex) {
        log_error(__FILE__,"configuracion_generaleController/post_ajaxExtraer_Reportes_Empresa",$ex->getMessage());
        $html=(mensaje_error);
    }
    
    $retornar = Array('html' => $html);
    echo json_encode($retornar);
}
function post_ajaxExtraer_Menu_Modulo1(){
    require ROOT_PATH . 'models/menu.php';
    require ROOT_PATH . 'models/modulo.php';
    $modulo_ID=$_POST['id'];
    
    $html="";
    try {
        $dtMenu=menu::getGrid("mn.modulo_ID=".$modulo_ID,-1,-1,"mn.nombre asc");
        $html.="<option value='0'>Ninguno</option>"; 
        if(count($dtMenu)>0){
            foreach($dtMenu as $item){
                $html.="<option value='".$item['ID']."'>"; 
                $html.=FormatTextView($item['nombre']);
                $html.="</option>"; 
            }
        }
        
    }catch (Exception $ex) {
        $html.=$ex->getMessage();
    }
    
    $retornar = Array('html' => $html);
    echo json_encode($retornar);
}
function post_ajaxUsuario_Mantenimiento_Eliminar($id) {
    require ROOT_PATH . 'models/proveedor.php';

    try {
        $oProveedor = proveedor::getByID($id);
        $oProveedor->usuario_mod_id = $_SESSION['usuario_ID'];
        if ($oProveedor == null) {
            throw new Exception('Parece que el registro ya fue eliminado.');
        }

        if ($oProveedor->eliminar() == -1) {
            throw new Exception($oProveedor->message);
        }

        $resultado = 1;
        $mensaje = $oProveedor->message;
        $funcion = '';
    } catch (Exception $ex) {
        $resultado = -1;
        $mensaje = $ex->getMessage();
        $funcion = '';
    }

    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje, 'funcion' => $funcion);

    echo json_encode($retornar);
}
function post_ajaxExtraerModuloEmpresa() {
    require ROOT_PATH . 'models/modulo_empresa.php';
    $empresa_ID=$_POST['id'];
    $html="<option value='0'>Ninguno</option>";
    try {
        $dtModulo=modulo_empresa::getGrid("moe.empresa_ID=".$empresa_ID,-1,-1,"mo.nombre asc");
        
        foreach($dtModulo as $item){
            $html.="<option value='".$item['modulo_ID']."'>".($item['nombre'])."</option>";
        }
    } catch (Exception $ex) {
        log_error(__FILE__, "configuracion_general/post_ajaxExtraerModuloEmpresa", $ex->getMessage());
        $html.="<option value='0'>".$ex->getMessage()."</option>";  
    }

    $retornar = Array('html' => $html);

    echo json_encode($retornar);
}
function get_Modulo_Mantenimiento(){
    require ROOT_PATH.'models/usuario.php';
    require ROOT_PATH.'models/estado.php';
    require ROOT_PATH.'models/perfil.php';
    global  $returnView_float;
    $returnView_float=true;
    $oUsuario=new usuario();
    $oUsuario->dtEstado=estado::getGrid("est.tabla='usuario'",-1,-1,"est.orden asc");
    $oUsuario->dtPerfil=perfil::getGrid("",-1,-1,"nombre asc");
    $GLOBALS['oUsuario']=$oUsuario;
    //$GLOBALS['mensaje']='';
}
function post_ajaxModulo_Mantenimiento() {
    require ROOT_PATH . 'models/usuario.php';
    require ROOT_PATH . 'models/perfil.php';
    require ROOT_PATH . 'models/estado.php';
    require ROOT_PATH . 'controls/funcionController.php';
    $buscar = $_POST['txtBuscar'];
    $paginaActual = $_POST['num_page'] == 0 ? 1 : $_POST['num_page'];
    $cantidadMostrar = $_POST['txtMostrar'] == '' ? 30 : $_POST['txtMostrar'];
    $opcion_tipo=$_POST['rbOpcion'];
    $txtOrden = $_POST['txtOrden'];
    $orden_tipo = 'DESC';
    $orden_class = 'imgOrden-desc';
    $estado_ID=$_POST['selEstado'];
    $perfil_ID=$_POST['selPerfil'];
    
    if (isset($_POST['chkOrdenASC'])) {
        $orden_class = 'imgOrden-asc';
        $orden_tipo = 'ASC';
    }
    
    switch ($txtOrden) {
        case 1:
            $orden = 'pe.apellido_paterno ' . $orden_tipo;
            break;
        case 2:
            $orden = 'pe.apellido_materno ' . $orden_tipo;
            break;
        case 3:
            $orden = 'pe.nombres ' . $orden_tipo;
            break;
        case 4:
            $orden = 'u.nombre ' . $orden_tipo;
            break;
        case 5:
            $orden = 'u.contraseña ' . $orden_tipo;
            break;
        case 6:
            $orden = 'per.nombre ' . $orden_tipo;
            break;
        case 7:
            $orden = 'es.nombre ' . $orden_tipo;
            break;
        
        default:
            $orden = 'u.ID ' . $orden_tipo;
            break;
    }
    $filtro="";
    if($opcion_tipo=="buscar"){
        if(trim($buscar)!=""){
            $filtro="upper(concat(pe.apellido_paterno,' ',pe.apellido_materno,' ',pe.nombres)) like upper('%". $buscar."%')";
        }   
    }else {
       
        if($estado_ID!=0){
            if($filtro!=""){
                $filtro.=" and ";
            }
            $filtro.="u.estado_ID=".$estado_ID;
        }
        
        if($perfil_ID!=0){
            if($filtro!=""){
                $filtro.=" and ";
            }
            $filtro.="u.perfil_ID=".$perfil_ID;
        }

       
    }

    // $filtro.= 'upper(concat(cl.razon_social," ",cl.ruc)) like "%' . str_replace(' ', '%', strtoupper(FormatTextSave($buscar))) . '%"';

    //---------------------------------------					 
    $resultado = '<table id="websendeos" class="grid table table-hover"><thead><tr>';
    $resultado.='<th class="thOrden" onclick="fncOrden(1);">Apellido paterno' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(2);">Apellido materno' . (($txtOrden == 2 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(3);">Nombres' . (($txtOrden == 3 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(4);">Usuario' . (($txtOrden == 4 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(5);">Contraseña.' . (($txtOrden == 5 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(6);">Perfil' . (($txtOrden == 6 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(7);">Estado' . (($txtOrden == 7 ? "<img class=" . $orden_class . " />" : "")) . '</th>';

    $resultado.='<th></th>';
    $resultado.='</tr></thead>';
    $resultado.='<tbody>';
    $colspanFooter = 8;
    try {
        $cantidadMaxima = usuario::getCount($filtro);
        $dtUsuario = usuario::getGrid($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
        $rows = count($dtUsuario);
        
       
        foreach ($dtUsuario as $item) {
 
            $resultado.='<tr class="tr-item" >';
            $resultado.='<td class="tdLeft">' . FormatTextView(strtoupper($item['apellido_paterno'])) . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextView(strtoupper($item['apellido_materno'])). '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextView(strtoupper($item['nombres'])) . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextView(strtoupper($item['usuario'])) . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextView(strtoupper($item['password'])). '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextView(strtoupper($item['perfil'])) . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextView(strtoupper($item['estado'])) . '</td>';
            $botones=array();
            if($item['ID']>0){
                $boton='<a onclick="fncEditar(' . $item['ID'] . ');" title="Editar"><span class="glyphicon glyphicon-pencil"></span> Editar</a>';
                array_push($botones,$boton);
                array_push($botones,'<a onclick="fncMenu(' . $item['ID'] . ');" title="Asignar menu"><span class="glyphicon glyphicon-align-left"></span> Menu</a>');
                array_push($botones,'<a onclick="fncEliminar(' . $item['ID'] . ');" title="Eliminar usuario"><span class="glyphicon glyphicon-trash"></span>&nbsp;Eliminar</a>');

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
function get_Menu_Mantenimiento(){
    require ROOT_PATH.'models/modulo.php';
    global $returnView;
    $returnView = true;
    $dtModulo=modulo::getGrid("",-1,-1,"m.nombre asc");
    $GLOBALS['dtModulo']=$dtModulo; 
}
function post_ajaxMenu_Mantenimiento() {
    if(!class_exists('menu')){
        require ROOT_PATH.'models/menu.php';
    }
    require ROOT_PATH . 'controls/funcionController.php';
    $buscar = $_POST['txtBuscar'];
    $paginaActual = $_POST['num_page'] == 0 ? 1 : $_POST['num_page'];
    $cantidadMostrar = $_POST['txtMostrar'] == '' ? 30 : $_POST['txtMostrar'];
    $opcion_tipo=$_POST['rbOpcion'];
    $txtOrden = $_POST['txtOrden'];
    $orden_tipo = 'DESC';
    $orden_class = 'imgOrden-desc';
    $modulo_ID=$_POST['selModulo'];
    
    if (isset($_POST['chkOrdenASC'])) {
        $orden_class = 'imgOrden-asc';
        $orden_tipo = 'ASC';
    }
    
    switch ($txtOrden) {
        case 1:
            $orden = 'mn.ID ' . $orden_tipo;
            break;
        case 2:
            $orden = 'mn.nombre ' . $orden_tipo;
            break;
        case 3:
            $orden = 'mn.url ' . $orden_tipo;
            break;
        case 4:
            $orden = 'm.nombre ' . $orden_tipo;
            break;
        default:
            $orden = 'mn.ID ' . $orden_tipo;
            break;
    }
    $filtro="";
    if($opcion_tipo=="buscar"){
        if(trim($buscar)!=""){
            $filtro="upper(mn.nombre) like upper('%". $buscar."%')";
        }   
    }else {
       
        if($modulo_ID!=0){
            if($filtro!=""){
                $filtro.=" and ";
            }
            $filtro.="mn.modulo_ID=".$modulo_ID;
        }
    }

    // $filtro.= 'upper(concat(cl.razon_social," ",cl.ruc)) like "%' . str_replace(' ', '%', strtoupper(FormatTextSave($buscar))) . '%"';

    //---------------------------------------					 
    $resultado = '<table id="websendeos" class="grid table table-hover table-teal table-bordered"><thead><tr>';
    $resultado.='<th class="thOrden" onclick="fncOrden(1);">Código' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(2);">Nombre' . (($txtOrden == 2 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(3);">Url' . (($txtOrden == 3 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(4);">Módulo' . (($txtOrden == 4 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th></th>';
    $resultado.='</tr></thead>';
    $resultado.='<tbody>';
    $colspanFooter = 5;
    try {
        $cantidadMaxima = menu::getCount($filtro);
        $dtUsuario = menu::getGrid($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
        $rows = count($dtUsuario);
        
       
        foreach ($dtUsuario as $item) {
 
            $resultado.='<tr class="tr-item" >';
            $resultado.='<td class="text-center">' . $item['ID'] . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextView($item['nombre']) . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextView($item['url']). '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextView($item['modulo']) . '</td>';
            $botones=array();
            if($item['ID']>0){
                $boton='<a onclick="fncEditar(' . $item['ID'] . ');" title="Editar"><span class="glyphicon glyphicon-pencil"></span> Editar</a>';
                array_push($botones,$boton);
                //array_push($botones,'<a onclick="fncMenu(' . $item['ID'] . ');" title="Asignar menu"><span class="glyphicon glyphicon-align-left"></span> Menu</a>');
                array_push($botones,'<a onclick="modal.confirmacion(&#39;El proceso es irreversible, esta seguro de eliminar el registro.&#39;,&#39;Eliminar Componente&#39;,fncEliminar,&#39;' . $item['ID'] . '&#39;);" title="Eliminar"><span class="glyphicon glyphicon-trash">Eliminar</a>');
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
function get_Menu_Mantenimiento_Nuevo() {
    require ROOT_PATH . 'models/menu.php';
    require ROOT_PATH . 'models/modulo.php';
    
    global $returnView_float;
    $returnView_float = true;
    $oMenu = new menu();
   
    $dtModulo=modulo::getGrid('',-1,-1,"m.nombre asc");
    $oMenu->dtModulo=$dtModulo;
    
    $GLOBALS['oMenu'] = $oMenu;
  
}
function post_Menu_Mantenimiento_Nuevo() {
    require ROOT_PATH . 'models/menu.php';
    require ROOT_PATH . 'models/modulo.php';
    require ROOT_PATH . 'models/menu_usuario.php';
    global $returnView_float;
    $returnView_float = true;
    
    $nombre = FormatTextSave($_POST['txtNombre']);
    $url =FormatTextSave($_POST['txtURL']);
    $modulo_ID = $_POST['selModulo'];
    $menu_padre_ID = $_POST['selMenu_Padre'];
    $orden = $_POST['txtOrden'];
    $descripcion = FormatTextSave($_POST['txtDescripcion']);
//    $usuario_ID = $_POST['txtUsuario_ID']; 
    $oMenu = new menu(); 
    try {  
        
        $oMenu->nombre = $nombre;
        $oMenu->url = $url;
        $oMenu->menu_ID = $menu_padre_ID;
        $oMenu->modulo_ID = $modulo_ID;
        $oMenu->descripcion = $descripcion;
        $oMenu->orden = $orden;
        $oMenu->url = $url;
        $oMenu->usuario_id = $_SESSION['usuario_ID'];
        if ($oMenu->verificarDuplicado() > 0) {
            throw new Exception($oMenu->getMessage);
        }
        $oMenu->insertar();
        //asignamos el menu al usuario admin
        $oMenu_Usuario=new menu_usuario();
        $oMenu_Usuario->usuario_ID=0;
        $oMenu_Usuario->menu_ID=$oMenu->ID;
        $oMenu_Usuario->usuario_id_creacion=$_SESSION['usuario_ID'];
        $oMenu_Usuario->insertar();
        $GLOBALS['resultado'] = 1;
        $GLOBALS['mensaje'] = $oMenu->getMessage;
    } catch (Exception $ex) {
        $GLOBALS['resultado'] = -1;
        $GLOBALS['mensaje'] = $ex->getMessage();
    }

    $dtModulo=modulo::getGrid('',-1,-1,"m.nombre asc");
    $oMenu->dtModulo=$dtModulo;
    
    $GLOBALS['oMenu'] = $oMenu;
}
function get_Menu_Mantenimiento_Editar($id) {
    require ROOT_PATH . 'models/menu.php';
    require ROOT_PATH . 'models/modulo.php';
    
    global $returnView_float;
    $returnView_float = true;
    $oMenu = menu::getByID($id);
   
    $dtModulo=modulo::getGrid('',-1,-1,"m.nombre asc");
    $oMenu->dtModulo=$dtModulo;
    $oMenu->dtMenu_Padre=menu::getGrid("mn.modulo_ID=".$oMenu->modulo_ID);
    
    $GLOBALS['oMenu'] = $oMenu;
  
}
function post_Menu_Mantenimiento_Editar($id) {
    require ROOT_PATH . 'models/menu.php';
    require ROOT_PATH . 'models/modulo.php';
    global $returnView_float;
    $returnView_float = true;
    
    $nombre = FormatTextSave($_POST['txtNombre']);
    $url =FormatTextSave($_POST['txtURL']);
    $modulo_ID = $_POST['selModulo'];
    $menu_padre_ID = $_POST['selMenu_Padre'];
    $orden = $_POST['txtOrden'];
    $descripcion = FormatTextSave($_POST['txtDescripcion']);
//    $usuario_ID = $_POST['txtUsuario_ID']; 
    $oMenu = menu::getByID($id); 
    try {  
        
        $oMenu->nombre = $nombre;
        $oMenu->url = $url;
        $oMenu->menu_ID = $menu_padre_ID;
        $oMenu->modulo_ID = $modulo_ID;
        $oMenu->descripcion = $descripcion;
        $oMenu->orden = $orden;
        $oMenu->url = $url;
        $oMenu->usuario_mod_id = $_SESSION['usuario_ID'];
        if ($oMenu->verificarDuplicado() > 0) {
            throw new Exception($oMenu->getMessage);
        }
        $oMenu->actualizar();
    
        $GLOBALS['resultado'] = 1;
        $GLOBALS['mensaje'] = $oMenu->getMessage;
    } catch (Exception $ex) {
        $GLOBALS['resultado'] = -1;
        $GLOBALS['mensaje'] = $ex->getMessage();
    }

    $dtModulo=modulo::getGrid('',-1,-1,"m.nombre asc");
    $oMenu->dtModulo=$dtModulo;
    $oMenu->dtMenu_Padre=menu::getGrid("mn.modulo_ID=".$oMenu->modulo_ID);
    $GLOBALS['oMenu'] = $oMenu;
}
function post_ajaxMenu_Mantenimiento_Eliminar($id) {
    require ROOT_PATH . 'models/menu.php';

    try {
        $oMenu = menu::getByID($id);
        $oMenu->usuario_mod_id = $_SESSION['usuario_ID'];
        if ($oMenu == null) {
            throw new Exception('Parece que el registro ya fue eliminado.');
        }
        if ($oMenu->eliminar() == -1) {
            throw new Exception($oMenu->getMessage);
        }
        $resultado = 1;
        $mensaje = $oMenu->getMessage;
        $funcion = '';
    } catch (Exception $ex) {
        $resultado = -1;
        $mensaje = $ex->getMessage();
        $funcion = '';
    }

    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje, 'funcion' => $funcion);

    echo json_encode($retornar);
}

//empresa
function get_Empresa_Mantenimiento(){

    global $returnView;
    $returnView = true;
    
}
function post_ajaxEmpresa_Mantenimiento() {
    if(!class_exists('empresa')){
        require ROOT_PATH.'models/empresa.php';
    }
    require ROOT_PATH . 'controls/funcionController.php';
    $buscar = $_POST['txtBuscar'];
    $paginaActual = $_POST['num_page'] == 0 ? 1 : $_POST['num_page'];
    $cantidadMostrar = $_POST['txtMostrar'] == '' ? 30 : $_POST['txtMostrar'];
    $opcion_tipo=$_POST['rbOpcion'];
    $txtOrden = $_POST['txtOrden'];
    $orden_tipo = 'DESC';
    $orden_class = 'imgOrden-desc';
    
    if (isset($_POST['chkOrdenASC'])) {
        $orden_class = 'imgOrden-asc';
        $orden_tipo = 'ASC';
    }
    
    switch ($txtOrden) {
        case 1:
            $orden = 'em.ID ' . $orden_tipo;
            break;
        case 2:
            $orden = 'em.nombre ' . $orden_tipo;
            break;
        case 3:
            $orden = 'dg.ruc ' . $orden_tipo;
            break;
        case 4:
            $orden = 'em.ruta ' . $orden_tipo;
            break;
        case 5:
            $orden = 'dg.direccion ' . $orden_tipo;
            break;
        default:
            $orden = 'em.ID ' . $orden_tipo;
            break;
    }
    $filtro="";
    if(trim($buscar)!=""){
        $filtro="upper(nombre) like upper('%". $buscar."%')";
    }
    

    // $filtro.= 'upper(concat(cl.razon_social," ",cl.ruc)) like "%' . str_replace(' ', '%', strtoupper(FormatTextSave($buscar))) . '%"';

    //---------------------------------------					 
    $resultado = '<table id="websendeos" class="grid table table-hover"><thead><tr>';
    $resultado.='<th class="thOrden" onclick="fncOrden(1);">Código' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(2);">Nombre' . (($txtOrden == 2 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(3);">Ruc' . (($txtOrden == 3 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(4);">Ruta' . (($txtOrden == 4 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(5);">Dirección' . (($txtOrden == 5 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    
    $resultado.='<th></th>';
    $resultado.='</tr></thead>';
    $resultado.='<tbody>';
    $colspanFooter = 6;
    try {
        $cantidadMaxima = empresa::getCount1($filtro);
        $dtEmpresa = empresa::getGrid1($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
        $rows = count($dtEmpresa);
        foreach ($dtEmpresa as $item) {
 
            $resultado.='<tr class="tr-item" >';
            $resultado.='<td class="tdLeft">' . $item['ID'] . '</td>';
            $resultado.='<td class="tdLeft">' . utf8_encode($item['nombre']) . '</td>';
            $resultado.='<td class="tdLeft">' . utf8_encode($item['ruc']) . '</td>';
            $resultado.='<td class="tdLeft">' . utf8_encode($item['ruta']) . '</td>';
            $resultado.='<td class="tdLeft">' . utf8_encode($item['direccion']) . '</td>';
            $botones=array();
            if($item['ID']>0){
                $boton='<a onclick="fncEditar(' . $item['ID'] . ');" title="Editar"><span class="glyphicon glyphicon-pencil"></span> Editar</a>';
                array_push($botones,$boton);
                array_push($botones,'<a onclick="fncModulos(' . $item['ID'] . ');" title="Módulos"><span class="glyphicon glyphicon-align-justify"></span> Módulos</a>');
                //array_push($botones,'<a onclick="fncMenu(' . $item['ID'] . ');" title="Asignar menu"><span class="glyphicon glyphicon-align-left"></span> Menu</a>');
                array_push($botones,'<a onclick="modal.confirmacion(&#39;El proceso es irreversible, esta seguro de eliminar el registro.&#39;,&#39;Eliminar&#39;,fncEliminar,&#39;' . $item['ID'] . '&#39;);" title="Eliminar"><span class="glyphicon glyphicon-trash">Eliminar</a>');
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
function get_Empresa_Mantenimiento_Nuevo() {
    require ROOT_PATH . 'models/empresa.php';
    if(!class_exists('datos_generales'))require ROOT_PATH.'models/datos_generales.php';
    require ROOT_PATH . 'models/distrito.php';
    require ROOT_PATH . 'models/provincia.php';
    require ROOT_PATH . 'models/departamento.php';
    require ROOT_PATH . 'models/moneda.php';
    require ROOT_PATH . 'models/estado.php';
    require ROOT_PATH . 'models/tipo_comprobante.php';
    require ROOT_PATH . 'models/reportes.php';
    require ROOT_PATH . 'models/modulo.php';
    global $returnView_float;
    $returnView_float = true;
    $oEmpresa = new empresa();
    
    $oEmpresa->stilo_fondo_tabs="";
    $oEmpresa->stilo_fondo_boton="";
    $oEmpresa->stilo_fondo_cabecera="";
    $oEmpresa->color_documentos='#848484';
    $oEmpresa->ruta=ruta_archivo;
    $GLOBALS['oEmpresa'] = $oEmpresa;
    $oDatos_Generales=new datos_generales();
    //Valores por defecto
    $dtMoneda=moneda::getGrid("",-1,-1,"descripcion asc");
    $dtEstadoCompra=estado::getGrid("tabla='ingreso'",-1,-1,"orden asc");
    $dtTipo_Comprobante_Compra=tipo_comprobante::getGrid("ID in(1,3)",-1,-1,"nombre asc");
    $dtModulo=modulo::getGrid("ID not in(select modulo_ID from modulo_empresa where del=0 and empresa_ID=1)",-1,-1,"nombre asc");
    $lista_reportes=reportes::getLista(0);
    $oDatos_Generales->distrito_ID=distrito_default;//Seleccionamos Lima
    $oDistrito=distrito::getByID(distrito_default);
    $oProvincia=provincia::getByID($oDistrito->provincia_ID);
    $dtDepartamento=departamento::getGrid("",-1,-1,"d.nombre asc");
    $dtProvincia=provincia::getGrid("pv.departamento_ID=".$oProvincia->departamento_ID,-1,-1,"pv.nombre asc");
    $dtDistrito=distrito::getGrid("dt.provincia_ID=".$oDistrito->provincia_ID,-1,-1,"dt.nombre asc");
    $oDatos_Generales->departamento_ID=$oProvincia->departamento_ID;
    $oDatos_Generales->provincia_ID=$oDistrito->provincia_ID;
    $oDatos_Generales->favicon="default.ico";
    $oDatos_Generales->logo_extension="default.jpg";
    $oDatos_Generales->imagen="default.jpg";
    $oDatos_Generales->tipo_cambio=tipo_cambio_default;//Tipo de cambio por defecto;
    $oDatos_Generales->vigv=igv_default;
    $oDatos_Generales->periodo_defecto=date('Y');
    $oDatos_Generales->etiquetas_correo='Correo principal|Correo de información|Correo de venta';
    $oDatos_Generales->etiquetas_celulares=' Celular1|Celular2|Celular3';
    $oDatos_Generales->beta_ws_guia='https://e-beta.sunat.gob.pe/ol-ti-itemision-guia-gem-beta/billService';
    $oDatos_Generales->beta_ws_factura='https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService';
    $oDatos_Generales->prod_ws_guia='https://e-guiaremision.sunat.gob.pe/ol-ti-itemision-guia-gem/billService';
    $oDatos_Generales->prod_ws_factura='https://e-factura.sunat.gob.pe/ol-ti-itcpfegem/billService';
    $GLOBALS['oDatos_Generales']=$oDatos_Generales;
    $GLOBALS['dtDepartamento']=$dtDepartamento;
    $GLOBALS['dtProvincia']=$dtProvincia;
    $GLOBALS['dtDistrito']=$dtDistrito;
    $GLOBALS['dtMoneda']=$dtMoneda;
    $GLOBALS['dtEstadoCompra']=$dtEstadoCompra;
    $GLOBALS['dtTipo_Comprobante_Compra']=$dtTipo_Comprobante_Compra;
    $GLOBALS['dtModulo']=$dtModulo;
    $GLOBALS['lista_reportes']=$lista_reportes;
    
    
  
}
function post_Empresa_Mantenimiento_Nuevo() {
    require ROOT_PATH . 'models/empresa.php';
    if(!class_exists('datos_generales'))require ROOT_PATH.'models/datos_generales.php';
    require ROOT_PATH . 'models/distrito.php';
    require ROOT_PATH . 'models/provincia.php';
    require ROOT_PATH . 'models/departamento.php';
    
    require ROOT_PATH . 'models/moneda.php';
    require ROOT_PATH . 'models/estado.php';
    require ROOT_PATH . 'models/tipo_comprobante.php';
    
    require ROOT_PATH . 'models/modulo.php';
    require ROOT_PATH . 'models/reportes.php';
    global $returnView_float;
    $returnView_float = true;
    $dtConfiguracion=configuracion::getGrid();
    $nombre = FormatTextSave($_POST['txtNombre']);
    //$ruta = FormatTextSave($_POST['txtRuta']);
    $stilo_fondo_tabs=$_POST['selStilo_fondo_tabs'];
    $stilo_fondo_boton=$_POST['selStilo_fondo_boton'];
    $stilo_fondo_cabecera=$_POST['selStilo_fondo_cabecera'];
    $color_documentos=$_POST['color_documentos'];
    $clase_icono=$_POST['txtClassIcono'];
    //Valores por defecto
    $dtMoneda=moneda::getGrid("",-1,-1,"descripcion asc");
    $dtEstadoCompra=estado::getGrid("tabla='ingreso'",-1,-1,"orden asc");
    $dtTipo_Comprobante_Compra=tipo_comprobante::getGrid("ID in(1,3)",-1,-1,"nombre asc");
    $dtModulo=modulo::getGrid("ID<>1",-1,-1,"nombre asc");
    
    //Datos generales
    $nombre_corto=($_POST['txtAlias']);
    $distrito_ID=  $_POST['selDistrito'];
    $direccion=  test_input($_POST['txtDireccion']);
    $observacion=  ($_POST['txtObservacion']);
    
    $razon_social=  ($_POST['txtRazon_Social']);
    $ruc=  ($_POST['txtRuc']);
    $direccion_fiscal=  ($_POST['txtDireccion_Fiscal']);
    
    $tipo_cambio=$_POST['txtTipo_Cambio'];
    $vigv=$_POST['txtVigv'];
    
    $pagina_web=  ($_POST['txtPagina_Web']);
    $correo="";
    $telefono="";
    $celular= "";
    $persona_contacto="";
    $cargo_contacto="";
    
    $sitio_web=($_POST['txtSitio_Web']);
    $quienes_somos=($_POST['txtQuienes_Somos']);
    $mision=($_POST['txtMision']);
    $vision=($_POST['txtVision']);
    $skype="";
    
    $mail_webmaster=($_POST['txtMail_Webmaster']);
    $password_webmaster=($_POST['txtPassword_Webmaster']);
    $servidorSMTP=($_POST['txtServidorSMTP']);
    $puertoSMTP=($_POST['txtPuertoSMTP']);
    
    //Configuracion default
    $moneda=$_POST['SelMoneda'];
    $periodo_inicio=$_POST['txtPeriodo'];
    $estado_compra=$_POST['SelEstadoCompra'];
    $compra_tipo_comprobante_ID=$_POST['SelComprobanteCompra'];
    $link_comprobante_electronico=$_POST['txtLink_Comprobante_Electronico'];
    $departamento_ID_default=$_POST['selDepartamento1'];
    $provincia_ID_default=$_POST['selProvincia1'];
    $distrito_ID_default=$_POST['selDistrito1'];
    $configuracion_correo_empresa=$_POST['txtOpcionesCorreo'];
    $configuracion_celular_empresa=$_POST['txtOpcionesCelular'];
    $beta_ws_guia=$_POST['txtWebServisGuiaBeta'];
    $beta_ws_factura=$_POST['txtWebServisFacturaBeta'];
    $precio_incluye_igv=$_POST['selIncluyeIgv'];
    $produccion_ws_guia=$_POST['txtWebServisGuiaProd'];
    $produccion_ws_factura=$_POST['txtWebServisFacturaProd'];
    
    
    $conexion_ws_sunat=$_POST['SelWebServis'];
    
    $lista_modulo=$_POST['lista_modulos'];
    $lista_reportes=$_POST['lista_reportes'];
    $oEmpresa = new empresa(); 
    $oDatos_Generales=new datos_generales();
    try {  
        
        $oEmpresa->nombre = $nombre;
        $oEmpresa->stilo_fondo_tabs = $stilo_fondo_tabs;
        $oEmpresa->stilo_fondo_boton = $stilo_fondo_boton;
        $oEmpresa->stilo_fondo_cabecera = $stilo_fondo_cabecera;
        $oEmpresa->ruta=ruta_archivo;
        $oEmpresa->icono=$clase_icono;
        $oEmpresa->usuario_id = $_SESSION['usuario_ID'];
        $oEmpresa->moneda=$moneda;
        $oEmpresa->periodo_inicio=$periodo_inicio;
        $oEmpresa->estado_compra=$estado_compra;
        $oEmpresa->compra_tipo_comprobante_ID=$compra_tipo_comprobante_ID;
        
        $oEmpresa->link_comprobante_electronico=$link_comprobante_electronico;
        $oEmpresa->departamento_ID_default=$departamento_ID_default;
        $oEmpresa->provincia_ID_default=$provincia_ID_default;
        $oEmpresa->distrito_ID_default=$distrito_ID_default;
        $oEmpresa->configuracion_correo_empresa=$configuracion_correo_empresa;
        $oEmpresa->configuracion_celular_empresa=$configuracion_celular_empresa;
        $oEmpresa->beta_ws_guia=$beta_ws_guia;
        $oEmpresa->beta_ws_factura=$beta_ws_factura;
        $oEmpresa->produccion_ws_factura=$produccion_ws_factura;
        $oEmpresa->produccion_ws_guia=$produccion_ws_guia;
        $oEmpresa->conexion_ws_sunat=$conexion_ws_sunat;
        $oEmpresa->lista_modulo=$lista_modulo;
        $oEmpresa->lista_reportes=$lista_reportes;
        $oEmpresa->color_documentos=$color_documentos;
        $oEmpresa->precio_incluye_igv=$precio_incluye_igv;
        $oEmpresa->insertar();
        $lista_reportes1=reportes::getLista($oEmpresa->ID);
        if($oEmpresa->ID>0){
            crear_ficheros_empresa($oEmpresa->ID);
            //agregamos los valores de datos generales
            $oDatos_Generales->empresa_ID=$oEmpresa->ID;
            $oDatos_Generales->ruc=$ruc;
            $oDatos_Generales->razon_social=$razon_social;
            $oDatos_Generales->alias=$nombre_corto;
            $oDatos_Generales->direccion=$direccion;
            $oDatos_Generales->direccion_fiscal=$direccion_fiscal;
            $oDatos_Generales->distrito_ID=$distrito_ID;
            $oDatos_Generales->favicon="default.ico";
            $oDatos_Generales->logo_extension="default.jpg";
            $oDatos_Generales->imagen="default.jpg";    
            $oDatos_Generales->correo=$correo;
            $oDatos_Generales->pagina_web=$pagina_web;
            $oDatos_Generales->telefono=$telefono;
            $oDatos_Generales->celular=$celular;      
            $oDatos_Generales->tipo_cambio=$tipo_cambio;
            $oDatos_Generales->vigv=$vigv;
            $oDatos_Generales->observacion=$observacion;
            $oDatos_Generales->quienes_somos=$quienes_somos;
            $oDatos_Generales->mision=$mision;
            $oDatos_Generales->vision=$vision;
            $oDatos_Generales->skype=$skype;
            $oDatos_Generales->persona_contacto=$persona_contacto;
            $oDatos_Generales->cargo_contacto=$cargo_contacto;
            $oDatos_Generales->mail_webmaster=$mail_webmaster;
            $oDatos_Generales->password_webmaster=$password_webmaster;
            $oDatos_Generales->servidorSMTP=$servidorSMTP;
            $oDatos_Generales->puertoSMTP=$puertoSMTP;
            $oDatos_Generales->sitio_web=$sitio_web;
            $oDatos_Generales->usuario_id=$_SESSION['usuario_ID'];
            $oDatos_Generales->insertar();
            if($oDatos_Generales->ID>0){
                if($_FILES['imagen']['tmp_name']!=""){
                    $dir_subida = ruta_guardar_archivos.'/imagenes/logo/';
                    $nombre_temporal=explode('.',basename($_FILES['logo']['name']));
                    $extension=(strtoupper($nombre_temporal[1])=="JPG")?$nombre_temporal[1]:"JPG";
                    $nombre1=$oEmpresa->ID.'.'.$extension;
                    $fichero_subido = $dir_subida .basename($nombre1);

                    if (move_uploaded_file($_FILES['logo']['tmp_name'], $fichero_subido)) {

                        $oDatos_Generales->imagen=$nombre1;

                    }else{$mensaje="Se guardó la información, pero no se subió el logo.";}
                }
                if($_FILES['icono']['tmp_name']!=""){
                    $dir_subida = ruta_guardar_archivos.'/imagenes/favicon/';
                    $nombre_temporal=explode('.',basename($_FILES['icono']['name']));

                    $extension=$nombre_temporal[1];
                    $nombre2=$oEmpresa->ID.'.'.$extension;
                    $fichero_subido = $dir_subida .basename($nombre2);

                    if (move_uploaded_file($_FILES['icono']['tmp_name'], $fichero_subido)) {
                        $oDatos_Generales->favicon=$nombre2;
                    }else{$mensaje="Se guardó la información, pero no se subió el icono.";}
                }  
                if($_FILES['logo']['tmp_name']!=""){
                        $dir_subida = ruta_guardar_archivos.'/files/imagenes/logo_comprobantes/';
                        //$dir_subida = $_SERVER['DOCUMENT_ROOT'].'/imagenes/imagen/';
                        $nombre_temporal=explode('.',basename($_FILES['logo']['name']));

                        $extension=(strtoupper($nombre_temporal[1])=="JPG")?$nombre_temporal[1]:"JPG";
                        $nombre3=$oEmpresa->ID.'.'.$extension;
                        $fichero_subido = $dir_subida .basename($nombre3);

                        if (move_uploaded_file($_FILES['logo']['tmp_name'], $fichero_subido)) {
                           $oDatos_Generales->logo_extension=$nombre3;
                        }else{$mensaje="Se guardó la información, pero no se subió la imagen.";}
                }
                $oDatos_Generales->usuario_mod_id=$_SESSION["usuario_ID"];
                $oDatos_Generales->actualizar();
                $resultado=1;
                $mensaje=$oEmpresa->getMessage;
            }else{
                $resultado=-1;
                $mensaje="Se creó la empresa, pero no se crearon los datos generales";
            }
            
            
            
        }else{
            $resultado=-1;
            $mensaje="No se creó la empresa";
        }
        
    } catch (Exception $ex) {
        $resultado=-1;
        $mensaje= mensaje_error;
        log_error(__FILE__, "Configuracion_GeneralController/", $ex->getMessage());
        
    }
    
    
    $oDistrito=distrito::getByID($oDatos_Generales->distrito_ID);
    $oProvincia=provincia::getByID($oDistrito->provincia_ID);
    $dtDepartamento=departamento::getGrid("",-1,-1,"d.nombre asc");
    $dtProvincia=provincia::getGrid("pv.departamento_ID=".$oProvincia->departamento_ID,-1,-1,"pv.nombre asc");
    $dtDistrito=distrito::getGrid("dt.provincia_ID=".$oDistrito->provincia_ID,-1,-1,"dt.nombre asc");
    $oDatos_Generales->departamento_ID=$oProvincia->departamento_ID;
    $oDatos_Generales->provincia_ID=$oDistrito->provincia_ID;

    $GLOBALS['oDatos_Generales']=$oDatos_Generales;
    $GLOBALS['dtDepatamento']=$dtDepartamento;
    $GLOBALS['dtProvincia']=$dtProvincia;
    $GLOBALS['dtDistrito']=$dtDistrito;
    $GLOBALS['oEmpresa'] = $oEmpresa;
    $GLOBALS['dtMoneda']=$dtMoneda;
    $GLOBALS['dtEstadoCompra']=$dtEstadoCompra;
    $GLOBALS['dtTipo_Comprobante_Compra']=$dtTipo_Comprobante_Compra;
    $GLOBALS['dtModulo']=$dtModulo;
    $GLOBALS['lista_reportes']=$lista_reportes1;
    $GLOBALS['resultado']=$resultado;
    $GLOBALS['mensaje']=$mensaje;
}
function crear_ficheros_empresa($empresa_ID){
    if (!file_exists(ruta_archivo."/")){
         mkdir(ruta_archivo."/");
    }
    $ruta_sunat=ruta_archivo."/SUNAT/";
    if (!file_exists($ruta_sunat)){
         mkdir($ruta_sunat);
    }
    $ruta_sunat=ruta_archivo."/SUNAT/CDR/";
    if (!file_exists($ruta_sunat)){
         mkdir($ruta_sunat);
    }
    $ruta_sunat=ruta_archivo."/SUNAT/CDR/".$empresa_ID."/";
    if (!file_exists($ruta_sunat)){
         mkdir($ruta_sunat);
    }
    $carpetas_sunat=array("boleta","comunicacion_baja","factura","guiaremision","notacredito","notadebito","resumen_diario");
    foreach($carpetas_sunat as &$nombre){
        $ruta_sunat=ruta_archivo."/SUNAT/CDR/".$empresa_ID."/".$nombre."/";
        if (!file_exists($ruta_sunat)){
            mkdir($ruta_sunat);
        }
    }
    $ruta_sunat=ruta_archivo."/SUNAT/XML/";
    if (!file_exists($ruta_sunat)){
         mkdir($ruta_sunat);
    }
    $ruta_sunat=ruta_archivo."/SUNAT/XML/".$empresa_ID."/";
    if (!file_exists($ruta_sunat)){
         mkdir($ruta_sunat);
    }
    foreach($carpetas_sunat as &$nombre){
            $ruta_sunat=ruta_archivo."/SUNAT/XML/".$empresa_ID."/".$nombre."/";
        if (!file_exists($ruta_sunat)){
            mkdir($ruta_sunat);
        }
    }
    $ruta_sunat=ruta_archivo."/SUNAT/CDR_DESCARGAR/";
    if (!file_exists($ruta_sunat)){
         mkdir($ruta_sunat);
    }
    $ruta_sunat=ruta_archivo."/SUNAT/CDR_DESCARGAR/".$empresa_ID."/";
    if (!file_exists($ruta_sunat)){
         mkdir($ruta_sunat);
    }
    $ruta_sunat=ruta_archivo."/SUNAT/CDR_consulta/";
    if (!file_exists($ruta_sunat)){
         mkdir($ruta_sunat);
    }
    $ruta_sunat=ruta_archivo."/SUNAT/CDR_consulta/".$empresa_ID."/";
    if (!file_exists($ruta_sunat)){
         mkdir($ruta_sunat);
    }
    $ruta_sunat=ruta_archivo."/SUNAT/CERTIFICADO/";
    if (!file_exists($ruta_sunat)){
         mkdir($ruta_sunat);
    }
    $ruta_sunat=ruta_archivo."/SUNAT/CERTIFICADO/".$empresa_ID."/";
    if (!file_exists($ruta_sunat)){
         mkdir($ruta_sunat);
    }
    $ruta_sunat=ruta_archivo."/SUNAT/XML_SINFIRMAR/";
    if (!file_exists($ruta_sunat)){
         mkdir($ruta_sunat);
    }
    $ruta_sunat=ruta_archivo."/SUNAT/XML_SINFIRMAR/".$empresa_ID."/";
    if (!file_exists($ruta_sunat)){
         mkdir($ruta_sunat);
    }
    $ruta_sunat=ruta_archivo."/SUNAT/ZIP_ENVIADOS/";
    if (!file_exists($ruta_sunat)){
         mkdir($ruta_sunat);
    }
    $ruta_sunat=ruta_archivo."/SUNAT/ZIP_ENVIADOS/".$empresa_ID."/";
    if (!file_exists($ruta_sunat)){
         mkdir($ruta_sunat);
    }
    $ruta_sunat=ruta_archivo."/archivos/";
    if (!file_exists($ruta_sunat)){
         mkdir($ruta_sunat);
    }
    $ruta_sunat=ruta_archivo."/archivos/mensajes/";
    if (!file_exists($ruta_sunat)){
         mkdir($ruta_sunat);
    }
    $ruta_sunat=ruta_archivo."/imagenes/";
    if (!file_exists($ruta_sunat)){
         mkdir($ruta_sunat);
    }
    $ruta_sunat=ruta_archivo."/imagenes/banner/";
    if (!file_exists($ruta_sunat)){
         mkdir($ruta_sunat);
    }
    $ruta_sunat=ruta_archivo."/imagenes/categoria/";
    if (!file_exists($ruta_sunat)){
         mkdir($ruta_sunat);
    }
    $ruta_sunat=ruta_archivo."/imagenes/empresa/";
    if (!file_exists($ruta_sunat)){
         mkdir($ruta_sunat);
    }
    $ruta_sunat=ruta_archivo."/imagenes/favicon/";
    if (!file_exists($ruta_sunat)){
         mkdir($ruta_sunat);
    }
    $ruta_sunat=ruta_archivo."/imagenes/foto_usuario/";
    if (!file_exists($ruta_sunat)){
         mkdir($ruta_sunat);
    }
    $ruta_sunat=ruta_archivo."/imagenes/imagen/";
    if (!file_exists($ruta_sunat)){
         mkdir($ruta_sunat);
    }
    $ruta_sunat=ruta_archivo."/imagenes/linea/";
    if (!file_exists($ruta_sunat)){
         mkdir($ruta_sunat);
    }
    $ruta_sunat=ruta_archivo."/imagenes/logo/";
    if (!file_exists($ruta_sunat)){
         mkdir($ruta_sunat);
    }
    $ruta_sunat=ruta_archivo."/imagenes/logo_comprobantes/";
    if (!file_exists($ruta_sunat)){
         mkdir($ruta_sunat);
    }
    $ruta_sunat=ruta_archivo."/imagenes/marca/";
    if (!file_exists($ruta_sunat)){
         mkdir($ruta_sunat);
    }
    $ruta_sunat=ruta_archivo."/imagenes/producto/";
    if (!file_exists($ruta_sunat)){
         mkdir($ruta_sunat);
    }
    $ruta_sunat=ruta_archivo."/imagenes/producto_imagen/";
    if (!file_exists($ruta_sunat)){
         mkdir($ruta_sunat);
    }
    $ruta_sunat=ruta_archivo."/temp/";
    if (!file_exists($ruta_sunat)){
         mkdir($ruta_sunat);
    }
    $ruta_sunat=ruta_archivo."/temp/comprobante/";
    if (!file_exists($ruta_sunat)){
         mkdir($ruta_sunat);
    }
    $ruta_sunat=ruta_archivo."/temp/guia_remision/";
    if (!file_exists($ruta_sunat)){
         mkdir($ruta_sunat);
    }
    $ruta_sunat=ruta_archivo."/temp/pdf/";
    if (!file_exists($ruta_sunat)){
         mkdir($ruta_sunat);
    }
}
function get_Empresa_Mantenimiento_Editar($ID) {
    require ROOT_PATH . 'models/empresa.php';
    if(!class_exists('datos_generales'))require ROOT_PATH.'models/datos_generales.php';
    require ROOT_PATH . 'models/distrito.php';
    require ROOT_PATH . 'models/provincia.php';
    require ROOT_PATH . 'models/departamento.php';
    require ROOT_PATH . 'models/moneda.php';
    require ROOT_PATH . 'models/estado.php';
    require ROOT_PATH . 'models/tipo_comprobante.php';
    
    require ROOT_PATH . 'models/modulo.php';
    require ROOT_PATH . 'models/reportes.php';
    global $returnView_float;
    $returnView_float = true;
    $oEmpresa = empresa::getByID($ID);
    
    $oEmpresa->getConfiguracion();
    $GLOBALS['oEmpresa'] = $oEmpresa;
    $oDatos_Generales=datos_generales::getByID1($ID);
    //Valores por defecto
    
    $dtMoneda=moneda::getGrid("",-1,-1,"descripcion asc");
    $dtEstadoCompra=estado::getGrid("tabla='ingreso'",-1,-1,"orden asc");
    $dtTipo_Comprobante_Compra=tipo_comprobante::getGrid("ID in(1,3)",-1,-1,"nombre asc");
    $dtModulo=modulo::getGrid("ID not in(select modulo_ID from modulo_empresa where del=0 and empresa_ID=1)",-1,-1,"nombre asc");
    $lista_reportes=reportes::getLista($oEmpresa->ID);
    //$oDatos_Generales->distrito_ID=distrito_default;//Seleccionamos Lima
    $oDistrito=distrito::getByID($oDatos_Generales->distrito_ID);
    $oProvincia=provincia::getByID($oDistrito->provincia_ID);
    $dtDepartamento=departamento::getGrid("",-1,-1,"d.nombre asc");
    $dtProvincia=provincia::getGrid("pv.departamento_ID=".$oProvincia->departamento_ID,-1,-1,"pv.nombre asc");
    $dtDistrito=distrito::getGrid("dt.provincia_ID=".$oDistrito->provincia_ID,-1,-1,"dt.nombre asc");
    $oDatos_Generales->departamento_ID=$oProvincia->departamento_ID;
    $oDatos_Generales->provincia_ID=$oDistrito->provincia_ID;
    $oDatos_Generales->favicon="default.ico";
    $oDatos_Generales->logo_extension="default.jpg";
    $oDatos_Generales->imagen="default.jpg";
    //$oDatos_Generales->tipo_cambio=tipo_cambio_default;//Tipo de cambio por defecto;
    //$oDatos_Generales->vigv=igv_default;
    $oDatos_Generales->periodo_defecto=date('Y');
    $oDatos_Generales->etiquetas_correo='Correo principal|Correo de información|Correo de venta';
    $oDatos_Generales->etiquetas_celulares=' Celular1|Celular2|Celular3';
    $oDatos_Generales->beta_ws_guia='https://e-beta.sunat.gob.pe/ol-ti-itemision-guia-gem-beta/billService';
    $oDatos_Generales->beta_ws_factura='https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService';
    $oDatos_Generales->prod_ws_guia='https://e-guiaremision.sunat.gob.pe/ol-ti-itemision-guia-gem/billService';
    $oDatos_Generales->prod_ws_factura='https://e-factura.sunat.gob.pe/ol-ti-itcpfegem/billService';
    $GLOBALS['oDatos_Generales']=$oDatos_Generales;
    $GLOBALS['dtDepartamento']=$dtDepartamento;
    $GLOBALS['dtProvincia']=$dtProvincia;
    $GLOBALS['dtDistrito']=$dtDistrito;
    $GLOBALS['dtMoneda']=$dtMoneda;
    $GLOBALS['dtEstadoCompra']=$dtEstadoCompra;
    $GLOBALS['dtTipo_Comprobante_Compra']=$dtTipo_Comprobante_Compra;
    $GLOBALS['dtModulo']=$dtModulo;
    
    $GLOBALS['lista_reportes']=$lista_reportes;
  
}
/*function get_Empresa_Mantenimiento_Editar($id) {
    require ROOT_PATH . 'models/empresa.php';
    require ROOT_PATH . 'models/datos_generales.php';
    require ROOT_PATH . 'models/distrito.php';
    require ROOT_PATH . 'models/provincia.php';
    require ROOT_PATH . 'models/departamento.php';
    require ROOT_PATH . 'models/configuracion.php';
    global $returnView_float;
    $returnView_float = true;
    $oEmpresa = empresa::getByID($id);
    $dtConfiguracion=configuracion::getGrid();
   
    $GLOBALS['oEmpresa'] = $oEmpresa;
    $oDatos_Generales=datos_generales::getByID1($oEmpresa->ID);
    $oDistrito=distrito::getByID( $oDatos_Generales->distrito_ID);
    $oProvincia=provincia::getByID($oDistrito->provincia_ID);
    $dtDepartamento=departamento::getGrid("",-1,-1,"d.nombre asc");
    $dtProvincia=provincia::getGrid("pv.departamento_ID=".$oProvincia->departamento_ID,-1,-1,"pv.nombre asc");
    $dtDistrito=distrito::getGrid("dt.provincia_ID=".$oDistrito->provincia_ID,-1,-1,"dt.nombre asc");
    $oDatos_Generales->departamento_ID=$oProvincia->departamento_ID;
    $oDatos_Generales->provincia_ID=$oDistrito->provincia_ID;
   
    $GLOBALS['oDatos_Generales']=$oDatos_Generales;
    $GLOBALS['dtDepatamento']=$dtDepartamento;
    $GLOBALS['dtProvincia']=$dtProvincia;
    $GLOBALS['dtDistrito']=$dtDistrito;
  
}

function post_Empresa_Mantenimiento_Editar($id) {
    require ROOT_PATH . 'models/empresa.php';
    require ROOT_PATH . 'models/datos_generales.php';
    require ROOT_PATH . 'models/distrito.php';
    require ROOT_PATH . 'models/provincia.php';
    require ROOT_PATH . 'models/departamento.php';
    require ROOT_PATH . 'models/configuracion.php';
    global $returnView_float;
    $returnView_float = true;
    $dtConfiguracion=configuracion::getGrid();
    $nombre = FormatTextSave($_POST['txtNombre']);
    $ruta = FormatTextSave($_POST['txtRuta']);
    $stilo_fondo_tabs=$_POST['selStilo_fondo_tabs'];
    $stilo_fondo_boton=$_POST['selStilo_fondo_boton'];
    $stilo_fondo_cabecera=$_POST['selStilo_fondo_cabecera'];
    
    //Datos generales
    $nombre_corto=FormatTextSave($_POST['txtAlias']);
    $distrito_ID=  $_POST['selDistrito'];
    $direccion=  test_input($_POST['txtDireccion']);
    $observacion=  FormatTextSave($_POST['txtObservacion']);
    
    $razon_social=  FormatTextSave($_POST['txtRazon_Social']);
    $ruc=  FormatTextSave($_POST['txtRuc']);
    $direccion_fiscal=  FormatTextSave($_POST['txtDireccion_Fiscal']);
    
    $tipo_cambio=$_POST['txtTipo_Cambio'];
    $vigv=$_POST['txtVigv'];
    
    $pagina_web=  FormatTextSave($_POST['txtPagina_Web']);
    $correo=FormatTextSave($_POST['txtCorreo']);
    $telefono=  FormatTextSave($_POST['txtTelefono']);
    $celular=  FormatTextSave($_POST['txtCelular']);
    $persona_contacto=FormatTextSave($_POST['txtPersona_Contacto']);
    $cargo_contacto=FormatTextSave($_POST['txtCargo_Contacto']);
    
    $sitio_web=FormatTextSave($_POST['txtSitio_Web']);
    $quienes_somos=FormatTextSave($_POST['txtQuienes_Somos']);
    $mision=FormatTextSave($_POST['txtMision']);
    $vision=FormatTextSave($_POST['txtVision']);
    $skype=FormatTextSave($_POST['txtSkype']);
    
    $mail_webmaster=FormatTextSave($_POST['txtMail_Webmaster']);
    $password_webmaster=FormatTextSave($_POST['txtPassword_Webmaster']);
    $servidorSMTP=FormatTextSave($_POST['txtServidorSMTP']);
    $puertoSMTP=FormatTextSave($_POST['txtPuertoSMTP']);
    
    $oEmpresa = empresa::getByID($id); 
    $oDatos_Generales=datos_generales::getByID1($id);
    try {  
        
        $oEmpresa->nombre = $nombre;
        $oEmpresa->stilo_fondo_tabs = $stilo_fondo_tabs;
        $oEmpresa->stilo_fondo_boton = $stilo_fondo_boton;
        $oEmpresa->stilo_fondo_cabecera = $stilo_fondo_cabecera;
        $oEmpresa->ruta=$ruta;
        $oEmpresa->usuario_mod_id = $_SESSION['usuario_ID'];
        
        $oEmpresa->actualizar();
        //agregamos los valores de datos generales
        
        if($_FILES['imagen']['tmp_name']!=""){
                $dir_subida = $dtConfiguracion[5]['valores'].'/imagenes/logo/';
                $nombre_temporal=explode('.',basename($_FILES['logo']['name']));
                $extension=(strtoupper($nombre_temporal[1])=="JPG")?$nombre_temporal[1]:"JPG";
                $nombre1=$oDatos_Generales->ID.'.'.$extension;
                $fichero_subido = $dir_subida .basename($nombre1);
                
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $fichero_subido)) {
                   
                    $oDatos_Generales->logo_extension=$nombre1;
        
                }else{$mensaje="Se guardó la información, pero no se subió el logo.";}
        }
        if($_FILES['icono']['tmp_name']!=""){
            $dir_subida = $dtConfiguracion[5]['valores'].'/imagenes/favicon/';
            $nombre_temporal=explode('.',basename($_FILES['icono']['name']));

            $extension=$nombre_temporal[1];
            $nombre2=$oDatos_Generales->ID.'.'.$extension;
            $fichero_subido = $dir_subida .basename($nombre2);

            if (move_uploaded_file($_FILES['icono']['tmp_name'], $fichero_subido)) {
                $oDatos_Generales->favicon=$nombre2;
            }else{$mensaje="Se guardó la información, pero no se subió el icono.";}
        }  
        if($_FILES['imagen']['tmp_name']!=""){
                //$dir_subida = $_SERVER['DOCUMENT_ROOT'].'/files/imagenes/logo/';
                $dir_subida = $_SERVER['DOCUMENT_ROOT'].'/imagenes/imagen/';
                $nombre_temporal=explode('.',basename($_FILES['imagen']['name']));
                
                $extension=(strtoupper($nombre_temporal[1])=="JPG"||strtoupper($nombre_temporal[1])=="png"||strtoupper($nombre_temporal[1])=="gif")?$nombre_temporal[1]:"JPG";
                $nombre3=$oDatos_Generales->ID.'.'.$extension;
                $fichero_subido = $dir_subida .basename($nombre3);
                
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $fichero_subido)) {
                   $oDatos_Generales->imagen=$nombre3;
                }else{$mensaje="Se guardó la información, pero no se subió la imagen.";}
        }
        $oDatos_Generales->empresa_ID=$oEmpresa->ID;
        $oDatos_Generales->ruc=$ruc;
        $oDatos_Generales->razon_social=$razon_social;
        $oDatos_Generales->alias=$nombre_corto;
        $oDatos_Generales->direccion=$direccion;
        $oDatos_Generales->direccion_fiscal=$direccion_fiscal;
        $oDatos_Generales->distrito_ID=$distrito_ID;
        $oDatos_Generales->correo=$correo;
        $oDatos_Generales->pagina_web=$pagina_web;
        $oDatos_Generales->telefono=$telefono;
        $oDatos_Generales->celular=$celular;      
        $oDatos_Generales->tipo_cambio=$tipo_cambio;
        $oDatos_Generales->vigv=$vigv;
        $oDatos_Generales->observacion=$observacion;
        $oDatos_Generales->quienes_somos=$quienes_somos;
        $oDatos_Generales->mision=$mision;
        $oDatos_Generales->vision=$vision;
        $oDatos_Generales->skype=$skype;
        $oDatos_Generales->persona_contacto=$persona_contacto;
        $oDatos_Generales->cargo_contacto=$cargo_contacto;
        $oDatos_Generales->mail_webmaster=$mail_webmaster;
        $oDatos_Generales->password_webmaster=$password_webmaster;
        $oDatos_Generales->servidorSMTP=$servidorSMTP;
        $oDatos_Generales->puertoSMTP=$puertoSMTP;
        $oDatos_Generales->sitio_web=$sitio_web;
        $oDatos_Generales->usuario_mod_id=$_SESSION["usuario_ID"];
        $oDatos_Generales->actualizar();
        $GLOBALS['resultado'] = 1;
        $GLOBALS['mensaje'] = $oEmpresa->getMessage;
    } catch (Exception $ex) {
        $GLOBALS['resultado'] = -1;
        $GLOBALS['mensaje'] = $ex->getMessage();
    }
    
    $oDatos_Generales->distrito_ID=$dtConfiguracion[1]["valores"];//Seleccionamos Lima
    $oDistrito=distrito::getByID($oDatos_Generales->distrito_ID);
    $oProvincia=provincia::getByID($oDistrito->provincia_ID);
    $dtDepartamento=departamento::getGrid("",-1,-1,"d.nombre asc");
    $dtProvincia=provincia::getGrid("pv.departamento_ID=".$oProvincia->departamento_ID,-1,-1,"pv.nombre asc");
    $dtDistrito=distrito::getGrid("dt.provincia_ID=".$oDistrito->provincia_ID,-1,-1,"dt.nombre asc");
    $oDatos_Generales->departamento_ID=$oProvincia->departamento_ID;
    $oDatos_Generales->provincia_ID=$oDistrito->provincia_ID;

    $GLOBALS['oDatos_Generales']=$oDatos_Generales;
    $GLOBALS['dtDepatamento']=$dtDepartamento;
    $GLOBALS['dtProvincia']=$dtProvincia;
    $GLOBALS['dtDistrito']=$dtDistrito;
    $GLOBALS['oEmpresa'] = $oEmpresa;
}*/
function post_ajaxEmpresa_Mantenimiento_Eliminar($id) {
    require ROOT_PATH . 'models/empresa.php';
    if(!class_exists('datos_generales'))require ROOT_PATH.'models/datos_generales.php';
    try {
        $oEmpresa = empresa::getByID($id);
        $oEmpresa->usuario_mod_id = $_SESSION['usuario_ID'];
        if ($oEmpresa == null) {
            throw new Exception('Parece que el registro ya fue eliminado.');
        }
        $oDatos_Generales=datos_generales::getByID1($id);
        if(isset($oDatos_Generales)){
            $oDatos_Generales->usuario_mod_id=$_SESSION['usuario_ID'];
            $oDatos_Generales->eliminar();
        }
        if ($oEmpresa->eliminar() == -1) {
            throw new Exception($oEmpresa->getMessage);
        }
        $resultado = 1;
        $mensaje = $oEmpresa->getMessage;
        $funcion = '';
    } catch (Exception $ex) {
        $resultado = -1;
        $mensaje = $ex->getMessage();
        $funcion = '';
    }

    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje, 'funcion' => $funcion);

    echo json_encode($retornar);
}
function get_Empresa_Mantenimiento_Modulo($id) {
    require ROOT_PATH . 'models/empresa.php';
    if(!class_exists('datos_generales'))require ROOT_PATH.'models/datos_generales.php';
    global $returnView_float;
    $returnView_float = true;
    $oEmpresa = empresa::getByID($id);
    $GLOBALS['oEmpresa'] = $oEmpresa;
    $oDatos_Generales=datos_generales::getByID1($oEmpresa->ID);
    $GLOBALS['oDatos_Generales']=$oDatos_Generales;
}

function post_ajaxModulos() {
    require ROOT_PATH . 'models/empresa.php';
    require ROOT_PATH . 'models/modulo.php';
    $empresa_ID=$_POST['id'];
    $resultado="";
    try {
        
        $dtModulo=modulo::getModulosLibres($empresa_ID);
        foreach($dtModulo as $item){
            $resultado.="<div class='col-md-12 col-sm-12 col-xs-12 col-lg-12 border border-success'><input type='checkbox' id='".$item['ID']."'> ".FormatTextView($item['nombre'])."</div>";
        }
        
    } catch (Exception $ex) {
        $resultado = $ex->getMessage();
        
    }

    $retornar = Array('resultado' => $resultado);

    echo json_encode($retornar);
}
function post_ajaxModulosAsignados() {
    require ROOT_PATH . 'models/empresa.php';
    require ROOT_PATH . 'models/modulo_empresa.php';
    $empresa_ID=$_POST['id'];
    $resultado="";
    try {
        $dtModulo_Empresa=modulo_empresa::getGrid("moe.empresa_ID=".$empresa_ID);
       
        foreach($dtModulo_Empresa as $item){
            $resultado.="<div class='col-md-12 col-sm-12 col-xs-12 col-lg-12 border border-success'><input type='checkbox' id='".$item['ID']."'> ".FormatTextView($item['nombre'])."</div>";
        }
        
    } catch (Exception $ex) {
        $resultado = $ex->getMessage();
        
    }

    $retornar = Array('resultado' => $resultado);

    echo json_encode($retornar);
}
function post_ajaxAsignarModulosEmpresa() {
    require ROOT_PATH . 'models/modulo_empresa.php';
    
    $empresa_ID=$_POST['id'];
    $modulos_IDs=explode("-",$_POST['id1']);
    $resultado=0;
    $mensaje="";
    try {
        if(count($modulos_IDs)>0){
            for($i=0;$i<count($modulos_IDs);$i++){
                $oModulo_Empresa=new modulo_empresa();
                $oModulo_Empresa->modulo_ID=$modulos_IDs[$i];
                $oModulo_Empresa->empresa_ID=$empresa_ID;
                $oModulo_Empresa->usuario_id=$_SESSION['usuario_ID'];
                $oModulo_Empresa->insertar();
            }
        }else{
            $oModulo_Empresa=new modulo_empresa();
            $oModulo_Empresa->modulo_ID=$_POST['id1'];
            $oModulo_Empresa->empresa_ID=$empresa_ID;
            $oModulo_Empresa->usuario_id=$_SESSION['usuario_ID'];
            $oModulo_Empresa->insertar();
        }
        $resultado=1;
        $mensaje="Se guardó correctamente.";
    } catch (Exception $ex) {
        $resultado=-1;
        $mensaje = $ex->getMessage();
        
    }

    $retornar = Array('resultado' => $resultado,"mensaje"=>$mensaje);

    echo json_encode($retornar);
}
function post_ajaxQuitarModulosEmpresa() {
    require ROOT_PATH . 'models/modulo_empresa.php';
    $IDs=explode("-",$_POST['id']);
    $resultado=0;
    $mensaje="";
    try {
        if(count($IDs)>0){
            for($i=0;$i<count($IDs);$i++){
                $oModulo_Empresa=modulo_empresa::getByID($IDs[$i]);
                $oModulo_Empresa->usuario_mod_id=$_SESSION['usuario_ID'];
                $oModulo_Empresa->eliminar();
            }
        }else{
            
            
            $$oModulo_Empresa=modulo_empresa::getByID($_POST['id']);
            $oModulo_Empresa->usuario_mod_id=$_SESSION['usuario_ID'];
            $oModulo_Empresa->eliminar();
        }
        $resultado=1;
        $mensaje="Se eliminó correctamente.";
    } catch (Exception $ex) {
        $resultado=-1;
        $mensaje = $ex->getMessage();
        
    }

    $retornar = Array('resultado' => $resultado,"mensaje"=>$mensaje);

    echo json_encode($retornar);
}





////---------------------------mantenimiento persona-----------------------------------------
////-----------------------------------------------------------------------------------------




function get_Persona_Mantenimiento(){
    require ROOT_PATH . 'models/tipo_documento.php';
    global $returnView;
    $returnView = true;
    $dtTipo_Documento=tipo_documento::getGrid("ID in (1,2,3,4)",-1,-1,"abreviatura asc");
    $GLOBALS['dtTipo_Documento']=$dtTipo_Documento;
}
/*
function post_ajaxPersona_Mantenimiento() {
    require ROOT_PATH . 'models/persona.php';
    require ROOT_PATH . 'models/persona_documento.php';
    require ROOT_PATH . 'models/tipo_documento.php';
    require ROOT_PATH . 'models/departamento.php';
    require ROOT_PATH . 'models/sexo.php';
    require ROOT_PATH . 'controls/funcionController.php';

    $buscar = FormatTextSave($_POST['txtBuscar']);
    $numero = FormatTextSave($_POST['txtNumero']);
    $paginaActual = $_POST['num_page'] == 0 ? 1 : $_POST['num_page'];
    $cantidadMostrar = ($_POST['txtMostrar'] == ''||$_POST['txtMostrar']==0)? 30 : $_POST['txtMostrar'];
    $txtOrden = $_POST['txtOrden'];
    $orden_tipo = 'DESC';
    $orden_class = 'imgOrden-desc';

    if (isset($_POST['chkOrdenASC'])) {
        $orden_class = 'imgOrden-asc';
        $orden_tipo = 'ASC';
    }
    
    switch ($txtOrden) {
         case 1:
            $orden = 'pdc.numero ' . $orden_tipo;
            break;
        case 2:
            $orden = 'pe.apellido_paterno ' . $orden_tipo;
            break;
        case 3:
            $orden = 'pe.apellido_materno ' . $orden_tipo;
            break;
        case 4:
            $orden = 'pe.nombres ' . $orden_tipo;
            break;
        case 5:
            $orden = 'pe.direccion' . $orden_tipo;
            break;
        case 6:
            $orden = 'pe.telefono ' . $orden_tipo;
            break;
        case 7:
            $orden = 'pe.correo ' . $orden_tipo;
            break;
        
        default:
            $orden = 'pe.ID ' . $orden_tipo;
            break;
    }

    if($numero!=""){
        $filtro="pdc.numero=".$numero;
    }else{
        $filtro = 'upper(concat(pe.apellido_paterno," ",pe.apellido_materno,"",pe.nombres)) like "%' . str_replace(' ', '%', strtoupper(FormatTextSave($buscar))) . '%"';

    }


    //---------------------------------------					 
    $resultado = '<table id="websendeos" class="grid table table-hover"><thead><tr>';
    $resultado.='<th class="thOrden" onclick="fncOrden(1);">N.- Documento' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(2);">Apellido paterno' . (($txtOrden == 2 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(3);">Apellido materno' . (($txtOrden == 3 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(4);">Nombres' . (($txtOrden == 4 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(5);">Direccion' . (($txtOrden == 5 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(6);">Telefono.' . (($txtOrden == 6 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(7);">Correo' . (($txtOrden == 7 ? "<img class=" . $orden_class . " />" : "")) . '</th>';

    $resultado.='<th></th>';
    $resultado.='</tr></thead>';
    $resultado.='<tbody>';
    $colspanFooter = 8;
    try {
        $cantidadMaxima = persona::getCount_PersonaDocumento($filtro);
        $dtPersona = persona::getGrid_PersonaDocumento($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
        $rows = count($dtPersona);
        
       
        foreach ($dtPersona as $item) {
 
            $resultado.='<tr class="tr-item" >';
            $resultado.='<td class="tdLeft">' . FormatTextView(strtoupper($item['numero'])) . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextView(strtoupper($item['apellido_paterno'])) . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextView(strtoupper($item['apellido_materno'])). '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextView(strtoupper($item['nombres'])) . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextView(strtoupper($item['direccion'])) . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextView(strtoupper($item['telefono'])). '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextView(strtoupper($item['correo'])) . '</td>';
            $botones=array();
            array_push($botones,'<a onclick="fncEditar(' . $item['ID'] . ');" ><span class="glyphicon glyphicon-pencil" title="Editar Persona">Editar</a>');
            array_push($botones,'<a onclick="modal.confirmacion(&#39;El proceso es irreversible, esta seguro de eliminar el registro.&#39;,&#39;Eliminar Persona&#39;,fncEliminar,&#39;' . $item['ID'] . '&#39;);" title="Eliminar Persona"><span class="glyphicon glyphicon-trash">Eliminar</a>');
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
function get_Persona_Mantenimiento_Nuevo() {
    require ROOT_PATH . 'models/persona.php';
    require ROOT_PATH . 'models/persona_documento.php';
    require ROOT_PATH . 'models/tipo_documento.php';
    require ROOT_PATH . 'models/sexo.php';
    require ROOT_PATH . 'models/departamento.php';
    require ROOT_PATH . 'models/provincia.php';
    require ROOT_PATH . 'models/distrito.php';
    global $returnView_float;
    $returnView_float = true;
    $oPersona=new persona();
    
    
    $oPersona->dtDepartamento=departamento::getGrid("",-1,-1,"nombre asc");
    $oPersona->dtProvincia=provincia::getGrid("departamento_ID=15",-1,-1,"nombre asc");
    $oPersona->dtDistrito=distrito::getGrid("provincia_ID=129",-1,-1,"nombre asc");
    
    $oPersona->dtSexo= sexo::getGrid("",-1,-1,"nombre asc");
    $dtTipo_Documento=tipo_documento::getGrid("",-1,1,"ID asc");
    $oPersona->departamento_ID=15;
    $oPersona->provincia_ID=129;
    $oPersona->distrito_ID=1261;
    
    $oPersona_Documento = new persona_documento();
            
    $GLOBALS['oPersona'] = $oPersona;
    $GLOBALS['dtTipo_Documento'] = $dtTipo_Documento;
    $GLOBALS['oPersona_Documento']=$oPersona_Documento;
  
}

//graba los datos que se recuperan por el metodo post en nuevo persona
function post_Persona_Mantenimiento_Nuevo() {
    require ROOT_PATH . 'models/persona.php';
    require ROOT_PATH . 'models/persona_documento.php';
    require ROOT_PATH . 'models/tipo_documento.php';
    require ROOT_PATH . 'models/departamento.php';
    require ROOT_PATH . 'models/provincia.php';
    require ROOT_PATH . 'models/distrito.php';
    require ROOT_PATH . 'models/sexo.php';
    global $returnView_float;
    $returnView_float = true;

    $apellido_paterno=  FormatTextSave(strtoupper($_POST['txtApellido_Paterno']));
    $apellido_materno=  FormatTextSave(strtoupper($_POST['txtApellido_Materno']));
    $nombres=  FormatTextSave(strtoupper($_POST['txtNombres']));
    $fecha_nacimiento=$_POST['txtFecha_Nacimiento'];
    $sexo_ID=$_POST['selSexo_ID'];
    $departamento_ID=$_POST['selDepartamento'];
    $provincia_ID=$_POST['selProvincia'];
    $distrito_ID=$_POST['selDistrito'];
    $direccion=FormatTextSave(strtoupper($_POST['txtDireccion']));
    $correo=FormatTextSave($_POST['txtCorreo']);
    $telefono=FormatTextSave($_POST['txtTelefono']);
    $celular=FormatTextSave($_POST['txtCelular']);
    
    
    
    $oPersona = new persona();
    $oPersona_Documento=new persona_documento();
    try {
        $oPersona->apellido_paterno=$apellido_paterno;
        $oPersona->apellido_materno=$apellido_materno;
        $oPersona->nombres=$nombres;
        $oPersona->fecha_nacimiento=$fecha_nacimiento;
        $oPersona->sexo_ID=$sexo_ID;
        $oPersona->distrito_ID=$distrito_ID;
        $oPersona->direccion=$direccion;
        $oPersona->correo=$correo;
        $oPersona->telefono=$telefono;
        $oPersona->celular=$celular;  
        $oPersona->usuario_id = $_SESSION['usuario_ID'];
//        if ($oPersona->verificarDuplicado() > 0) {
//            throw new Exception($oPersona->getMessage);
//        }
        
        $oPersona->insertar();
        $dtTipo_Documento=tipo_documento::getGrid("",-1,1,"ID asc");
        $tdc=$_POST['txt'.$tipo_documento['ID']];
        foreach($dtTipo_Documento as $tipo_documento){
            if($tdc!=""){
                
                $oPersona_Documento->persona_ID=$oPersona->ID;
                $oPersona_Documento->tipo_documento_ID=$tipo_documento['ID'];
                $oPersona_Documento->numero=$tdc;
                $oPersona_Documento->usuario_id=$_SESSION['usuario_ID'];
                $oPersona_Documento->insertar();
            }
        }
        
       
        $resultado=1;
        $mensaje="Se guardò correctamente.";
  
              
    } catch (Exception $ex) {
        $resultado= -1;
        $mensaje= $ex->getMessage();
    }
    $dtTipo_Documento=tipo_documento::getGrid("",-1,-1,"nombre asc");
    $oPersona->dtDepartamento=departamento::getGrid("",-1,-1,"nombre asc");
    $oPersona->dtProvincia=provincia::getGrid("departamento_ID=".$departamento_ID,-1,-1,"nombre asc");
    $oPersona->dtDistrito=distrito::getGrid("provincia_ID=".$provincia_ID,-1,-1,"nombre asc");
    $oPersona->dtTipo_Documento=$dtTipo_Documento;
    $oPersona->departamento_ID=$departamento_ID;
    $oPersona->provincia_ID=$provincia_ID;
    $dtSexo=sexo::getGrid("",-1,-1,"nombre asc");
    $oPersona->dtSexo=$dtSexo;
    $GLOBALS['resultado']=$resultado;
    $GLOBALS['mensaje']=$mensaje;
    $GLOBALS['oPersona'] = $oPersona;
    $GLOBALS['oPersona_Documento']=$oPersona_Documento;
}

//muestra la ventana editar proveedor
function get_Persona_Mantenimiento_Editar($id) {
    require ROOT_PATH . 'models/persona.php';
    require ROOT_PATH . 'models/persona_documento.php';
    require ROOT_PATH . 'models/tipo_documento.php';
    require ROOT_PATH . 'models/departamento.php';
    require ROOT_PATH . 'models/provincia.php';
    require ROOT_PATH . 'models/distrito.php';
    require ROOT_PATH . 'models/sexo.php'; 
    global $returnView_float;
    $returnView_float = true;

   
        $oPersona = persona::getByID($id);

    if($oPersona==null){
        $GLOBALS['resultado'] = -2;
        $GLOBALS['mensaje'] = "La persona ha sido eliminado por otro usuario.";
        return;
    }
    try{
        $dtSexo = sexo::getGrid("",-1,-1,"ID desc");
        $dtPersona_Documento = persona_documento::getGrid("",-1,-1,"ID desc");
        $dtTipo_Documento = tipo_documento::getGrid("",-1,-1,"ID desc");
        
        $oPersona_Documento= persona_documento::getByID($oPersona->ID);
        $oDistrito=distrito::getByID($oPersona->distrito_ID);
        $oProvincia=provincia::getByID($oDistrito->provincia_ID);
        $oPersona->departamento_ID=$oProvincia->departamento_ID;
        $oPersona->provincia_ID=$oProvincia->ID;
        $oPersona->dtDepartamento=departamento::getGrid("",-1,-1,"nombre asc");
        $oPersona->dtProvincia=provincia::getGrid("departamento_ID=".$oProvincia->departamento_ID,-1,-1,"nombre asc");
        $oPersona->dtDistrito=distrito::getGrid("provincia_ID=".$oDistrito->provincia_ID,-1,-1,"nombre asc");


        $oPersona->dtSexo=$dtSexo;
        $oPersona->dtPersona_Documento=$dtPersona_Documento;
        $oPersona->dtTipo_Documento=$dtTipo_Documento;
        
    } catch (Exception $ex) {
      $GLOBALS['oPersona'] = $oPersona;
    }
     $GLOBALS['oPersona'] = $oPersona;
     $GLOBALS['dtTipo_Documento'] = $dtTipo_Documento;
}

//graba los datos que se recuperan por el metodo post en editar proveedor
function post_Persona_Mantenimiento_Editar($id) {
    require ROOT_PATH . 'models/usuario.php';
    require ROOT_PATH . 'models/estado.php';
    require ROOT_PATH . 'models/perfil.php';
    require ROOT_PATH . 'models/persona.php';
    global $returnView_float;
    $returnView_float = true;
    $oUsuario = usuario::getByID($id);

    if ($oUsuario == null) {
        throw  new Exception('Parecer que el registro ya fue eliminado.');
       
    }
    $persona_ID = $_POST['txtPersona_ID'];
    $nombre = FormatTextSave($_POST['txtNombre']);
    $password =FormatTextSave($_POST['txtPassword']);
    $perfil_ID = $_POST['selPerfil'];
    $estado_ID = $_POST['selEstado'];
    try {
       $oUsuario->persona_ID = $persona_ID;
        $oUsuario->nombre = $nombre;
        $oUsuario->password = $password;
        $oUsuario->perfil_ID = $perfil_ID;
        $oUsuario->estado_ID = $estado_ID;
        $oUsuario->usuario_mod_id = $_SESSION['usuario_ID'];
        if ($oUsuario->verificarDuplicado() > 0) {
            throw new Exception($oUsuario->getMessage);
        }
        $oUsuario->actualizar();
    
        $GLOBALS['resultado'] = 1;
        $GLOBALS['mensaje'] = $oUsuario->getMessage;
    } catch (Exception $ex) {
        $GLOBALS['resultado'] = -1;
        $GLOBALS['mensaje'] = $ex->getMessage();
    }
    $dtEstado=estado::getGrid('est.tabla="usuario"');
    $dtPerfil = perfil::getGrid("",-1,-1,"nombre asc");
    $oUsuario->dtEstado=$dtEstado;
    $oUsuario->dtPerfil=$dtPerfil;
    $GLOBALS['oUsuario'] = $oUsuario;
}*/
function ajaxAgregarUsuario_Perfil(){
    require ROOT_PATH . 'models/usuario_empresa.php';
    $usuario_ID=$_POST['id'];
    $perfil_ID=$_POST['id1'];
    $empresa_ID=$_POST['id2'];
    
    $resultado=0;
    
    try{
        
        $oUsuario_Empresa=new usuario_empresa();
        $oUsuario_Empresa->usuario_ID=$usuario_ID;
        $oUsuario_Empresa->perfil_ID=$perfil_ID;
        $oUsuario_Empresa->empresa_ID=$empresa_ID;
        $oUsuario_Empresa->estado_ID=86;
        if($oUsuario_Empresa->verificarDuplicado()>0){
            throw new Exception($oUsuario_Empresa->getMessage);
        }
        $oUsuario_Empresa->usuario_id_creacion=$_SESSION['usuario_ID'];
        $oUsuario_Empresa->insertar();
    }catch (Exception $ex){
        
    }
    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
    //$retorn="<h1>Hola</h1>";

    echo json_encode($retornar);
}
function tabla_usuario_empresa($dtUsuario_Empresa){
    
}
function get_Persona_Mantenimiento_Nuevo() {
    require ROOT_PATH . 'models/persona.php';
    require ROOT_PATH . 'models/persona_documento.php';
    require ROOT_PATH . 'models/tipo_documento.php';
    require ROOT_PATH . 'models/departamento.php';
    require ROOT_PATH . 'models/provincia.php';
    require ROOT_PATH . 'models/distrito.php';
    require ROOT_PATH . 'models/sexo.php';
    global $returnView_float;
    $returnView_float = true;
    $oPersona=new persona();
    $dtTipo_Documento=tipo_documento::getGrid("",-1,-1,"nombre asc");
    $dtDepartamento=departamento::getGrid("",-1,-1,"d.nombre asc");
    $dtProvincia=provincia::getGrid("departamento_ID=15",-1,-1,"nombre asc");
    $dtDistrito=distrito::getGrid("provincia_ID=129",-1,-1,"nombre asc");
    $dtSexo=sexo::getGrid("",-1,-1,"nombre asc");
    $oPersona->dtTipo_Documento=$dtTipo_Documento;
    $oPersona->dtDepartamento=$dtDepartamento;
    $oPersona->dtProvincia=$dtProvincia;
    $oPersona->dtDistrito=$dtDistrito;
    $oPersona->departamento_ID=15;
    $oPersona->provincia_ID=129;
    $oPersona->distrito_ID=1261;
    $oPersona->tipo_documento_ID=1;
    $oPersona->dtSexo=$dtSexo;
    $oPersona->numero='';
    $GLOBALS['oPersona'] = $oPersona;

}

//graba los datos que se recuperan por el metodo post en editar persona
function post_Persona_Mantenimiento_Nuevo() {
    require ROOT_PATH . 'models/persona.php';
    require ROOT_PATH . 'models/persona_documento.php';
    require ROOT_PATH . 'models/tipo_documento.php';
    require ROOT_PATH . 'models/departamento.php';
    require ROOT_PATH . 'models/provincia.php';
    require ROOT_PATH . 'models/distrito.php';
    require ROOT_PATH . 'models/sexo.php';
    global $returnView_float;
    $returnView_float = true;
    $oPersona=new persona();
    $tipo_documentop_ID=$_POST['selTipo_Documento'];
    $numero=trim($_POST['txtNumero']);
    $apellido_paterno=trim($_POST['txtApellido_Paterno']);
    $apellido_materno=trim($_POST['txtApellido_Materno']);
    $nombres=trim($_POST['txtNombres']);
    $fecha_nacimiento=$_POST['txtFecha_Nacimiento'];
    $sexo_ID=$_POST['selSexo_ID'];
    $departamento_ID=$_POST['selDepartamento'];
    $provincia_ID=$_POST['selProvincia'];
    $distrito_ID=$_POST['selDistrito'];
    $direccion=trim($_POST['txtDireccion']);
    $correo=trim($_POST['txtCorreo']);
    $telefono=trim($_POST['txtTelefono']);
    $celular=trim($_POST['txtCelular']);
    try {
        $oPersona->apellido_paterno=$apellido_paterno;
        $oPersona->apellido_materno=$apellido_materno;
        $oPersona->nombres=$nombres;
        $oPersona->fecha_nacimiento=$fecha_nacimiento;
        $oPersona->sexo_ID=$sexo_ID;
        $oPersona->distrito_ID=$distrito_ID;
        $oPersona->direccion=$direccion;
        $oPersona->correo=$correo;
        $oPersona->telefono=$telefono;
        $oPersona->celular=$celular;  
        $oPersona->usuario_id = $_SESSION['usuario_ID'];
        $oPersona->tipo_documento_ID=$tipo_documentop_ID;
        $oPersona->numero=$numero;
        $retorna=$oPersona->insertar1();
        /*if ($oPersona->verificarDuplicado() > 0) {
              throw new Exception($oPersona->getMessage);             
        }  
        if($oPersona->insertar1()>0){
            $oPersona_Documento=new persona_documento();
            $oPersona_Documento->persona_ID=$oPersona->ID;
            $oPersona_Documento->tipo_documento_ID=$tipo_documentop_ID;
            $oPersona_Documento->numero=$numero;
            $oPersona_Documento->usuario_id=$_SESSION['usuario_ID'];
            $oPersona_Documento->insertar();
        }*/
        if($retorna==-2){
            $mensaje="El número de documento ya existe";
            $resultado=-1;
        }else if($retorna>0){
            $mensaje=$oPersona->getMessage;
            $resultado=1;
        }else{
            $mensaje="Ocurrió un error al intentar grabar.";
            $resultado=-1;
        }     
    } catch (Exception $ex) {
        $resultado= -1;
        $mensaje= $ex->getMessage();
    }
    $dtTipo_Documento=tipo_documento::getGrid("",-1,-1,"nombre asc");
    $dtDepartamento=departamento::getGrid("",-1,-1,"nombre asc");
    $dtProvincia=provincia::getGrid("departamento_ID=".$departamento_ID,-1,-1,"nombre asc");
    $dtDistrito=distrito::getGrid("provincia_ID=".$provincia_ID,-1,-1,"nombre asc");
    $oPersona->dtTipo_Documento=$dtTipo_Documento;
    $oPersona->dtDepartamento=$dtDepartamento;
    $oPersona->dtProvincia=$dtProvincia;
    $oPersona->dtDistrito=$dtDistrito;
    $oDistrito=distrito::getByID($distrito_ID);
    $oProvincia=provincia::getByID($oDistrito->provincia_ID);
    $dtSexo=sexo::getGrid("",-1,-1,"nombre asc");
    $oPersona->departamento_ID=$oProvincia->departamento_ID;
    $oPersona->provincia_ID=$oProvincia->ID;
    $oPersona->dtSexo=$dtSexo;
    $GLOBALS['resultado']=$resultado;
    $GLOBALS['mensaje']=$mensaje;
    $GLOBALS['oPersona'] = $oPersona;
}
//muestra la ventana editar persona
function get_Persona_Mantenimiento_Editar($id) {
    require ROOT_PATH . 'models/persona.php';
    require ROOT_PATH . 'models/persona_documento.php';
    require ROOT_PATH . 'models/tipo_documento.php';
    require ROOT_PATH . 'models/departamento.php';
    require ROOT_PATH . 'models/provincia.php';
    require ROOT_PATH . 'models/distrito.php';
    require ROOT_PATH . 'models/sexo.php';
    global $returnView_float;
    $returnView_float = true;
    $oPersona=persona::getByID1($id);
    if($oPersona==null){
        $GLOBALS['resultado'] = -2;
        $GLOBALS['mensaje'] = "La persona ha sido eliminado por otro usuario.";
        return;
    }
    $oDistrito = distrito::getByID($oPersona->distrito_ID);
    $oProvincia = provincia::getByID($oDistrito->provincia_ID);
    $oPersona->departamento_ID=$oProvincia->departamento_ID;
    $oPersona->provincia_ID=$oProvincia->ID;

    $oPersona->dtDepartamento=departamento::getGrid("",-1,-1,"nombre asc");
    $oPersona->dtProvincia=provincia::getGrid("departamento_ID=".$oProvincia->departamento_ID,-1,-1,"nombre asc");
    $oPersona->dtDistrito=distrito::getGrid("provincia_ID=".$oDistrito->provincia_ID,-1,-1,"nombre asc");
    $oPersona->dtTipo_Documento=tipo_documento::getGrid("",-1,-1,"nombre asc");
    $oPersona->dtSexo=sexo::getGrid("",-1,-1,"nombre asc");
    
    $GLOBALS['oPersona'] = $oPersona;
    
    
        
}

//graba los datos que se recuperan por el metodo post en editar persona
function post_Persona_Mantenimiento_Editar($id) {
    require ROOT_PATH . 'models/persona.php';
    require ROOT_PATH . 'models/persona_documento.php';
    require ROOT_PATH . 'models/tipo_documento.php';
    require ROOT_PATH . 'models/departamento.php';
    require ROOT_PATH . 'models/provincia.php';
    require ROOT_PATH . 'models/distrito.php';
    require ROOT_PATH . 'models/sexo.php';
    global $returnView_float;
    $returnView_float = true;
    
    $oPersona = persona::getByID1($id);
    if($oPersona==null){
        $GLOBALS['resultado'] = -2;
        $GLOBALS['mensaje'] = "La persona ha sido eliminado por otro usuario.";
        return;
    }
    

    $tipo_documentop_ID=$_POST['selTipo_Documento'];
    $numero=trim($_POST['txtNumero']);
    $apellido_paterno=trim($_POST['txtApellido_Paterno']);
    $apellido_materno=trim($_POST['txtApellido_Materno']);
    $nombres=trim($_POST['txtNombres']);
    $fecha_nacimiento=$_POST['txtFecha_Nacimiento'];
    $sexo_ID=$_POST['selSexo_ID'];
    $departamento_ID=$_POST['selDepartamento'];
    $provincia_ID=$_POST['selProvincia'];
    $distrito_ID=$_POST['selDistrito'];
    $direccion=trim($_POST['txtDireccion']);
    $correo=trim($_POST['txtCorreo']);
    $telefono=trim($_POST['txtTelefono']);
    $celular=trim($_POST['txtCelular']);
    
    
    
    try {
        $oPersona->apellido_paterno=$apellido_paterno;
        $oPersona->apellido_materno=$apellido_materno;
        $oPersona->nombres=$nombres;
        $oPersona->fecha_nacimiento=$fecha_nacimiento;
        $oPersona->sexo_ID=$sexo_ID;
        $oPersona->distrito_ID=$distrito_ID;
        $oPersona->direccion=$direccion;
        $oPersona->correo=$correo;
        $oPersona->telefono=$telefono;
        $oPersona->celular=$celular;  
        $oPersona->usuario_mod_id = $_SESSION['usuario_ID'];
        $oPersona->tipo_documento_ID=$tipo_documentop_ID;
        $oPersona->numero=$numero;
        
  
       $retorna=$oPersona->actualizar();

        if($retorna==-2){
            $resultado=-1;
            $mensaje="Existe una persona con e mismo número de documento.";
        }else{
            $mensaje=$oPersona->getMessage;
            $resultado=1;
        }
        
    } catch (Exception $ex) {
        $resultado = -1;
        $mensaje = utf8_encode(mensaje_error);
        log_error(__FILE__, 'mantenimiento/post_Persona_Mantenimiento_Editar', $ex->getMessage());
    }
    
    $oPersona->dtDepartamento=departamento::getGrid("",-1,-1,"nombre asc");
    $oPersona->dtProvincia=provincia::getGrid("departamento_ID=".$departamento_ID,-1,-1,"nombre asc");
    $oPersona->dtDistrito=distrito::getGrid("provincia_ID=".$provincia_ID,-1,-1,"nombre asc");
    $oPersona->dtTipo_Documento=  tipo_documento::getGrid();
    $oPersona->dtSexo=sexo::getGrid();
    $oPersona->departamento_ID=$departamento_ID;
    $oPersona->provincia_ID=$provincia_ID;

    $GLOBALS['oPersona'] = $oPersona;
    $GLOBALS['mensaje'] = $mensaje;
    $GLOBALS['resultado']=$resultado;
}


//muestra la grilla cargada con datos de Persona,trabaja con ajax
function post_ajaxPersona_Mantenimiento() {
    require ROOT_PATH . 'models/persona.php';
    require ROOT_PATH . 'controls/funcionController.php';
    $buscar = $_POST['txtBuscar'];
    $paginaActual = $_POST['num_page'] == 0 ? 1 : $_POST['num_page'];
    $cantidadMostrar = ($_POST['txtMostrar'] == ''||$_POST['txtMostrar']==0)? 30 : $_POST['txtMostrar'];
    $txtOrden = $_POST['txtOrden'];
    $orden_tipo = 'DESC';
    $orden_class = 'imgOrden-desc';
    if (isset($_POST['chkOrdenASC'])) {
        $orden_class = 'imgOrden-asc';
        $orden_tipo = 'ASC';
    }
    switch ($txtOrden) {
        case 0:
            $orden = ' ID ' . $orden_tipo;
            break;
        case 1:
            $orden = ' nombres ' . $orden_tipo;
            break;
        case 2:
            $orden = ' apellido_paterno ' . $orden_tipo;
            break;
        case 3:
            $orden = ' apellido_materno ' . $orden_tipo;
            break;
        case 4:
            $orden = ' direccion ' . $orden_tipo;
            break;
        case 5:
            $orden = ' celular ' . $orden_tipo;
            break;
        case 6:
            $orden = ' correo ' . $orden_tipo;
            break;
        default:
            $orden = ' ID ' . $orden_tipo;
            break;
    }
    $selTipo_Documento=$_POST['selTipo_Documento'];
    IF($selTipo_Documento>0){
        $numero=trim($_POST['txtNumero']);
        $filtro="pd.tipo_documento_ID=".$selTipo_Documento." and pd.numero='".$numero."'";
    }ELSE{
        $filtro = 'upper(concat(pe.apellido_paterno," ",pe.apellido_materno," ",pe.nombres)) like "%' . str_replace(' ', '%', strtoupper($buscar)) . '%"';
    }
    
    //---------------------------------------					 
    $resultado = '<table id="websendeos" class="grid table table-hover table-bordered"><thead><tr>';
    $resultado.='<th class="text-center">N°</th>';
    $resultado.='<th>Documento</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(1);">Nombres' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(2);">Apellido Paterno' . (($txtOrden == 2 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(3);">Apellido Materno' . (($txtOrden == 3 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(4);">Direccion' . (($txtOrden == 4 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(5);">Celular' . (($txtOrden == 6 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(6);">Correo' . (($txtOrden == 7 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th>Opciones</th>';
    $resultado.='</tr></thead>';
    $resultado.='<tbody>';
    $colspanFooter = 10;
    try {
        $cantidadMaxima = count(persona::getGrid1($filtro));
        $dtPersona = persona::getGrid1($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
        $rows = count($dtPersona);
        $i=($paginaActual-1)*$cantidadMostrar+1;
        foreach ($dtPersona as $item) {
            $resultado.='<tr class="tr-item">';
            $resultado.='<td class="text-center">'.$i.'</td>';
            $resultado.='<td class="text-center">' . test_input($item['documento']) . '</td>';
            $resultado.='<td class="text-center">' . test_input($item['nombres']) . '</td>';
            $resultado.='<td class="tdLeft">' . test_input($item['apellido_paterno']) . '</td>';
            $resultado.='<td class="tdLeft">' . test_input($item['apellido_materno']) . '</td>';
            $resultado.='<td class="tdLeft">' . test_input($item['direccion']) . '</td>';
            $resultado.='<td class="tdLeft">' . test_input($item['celular']) . '</td>';
            $resultado.='<td class="tdLeft">' . test_input($item['correo']) . '</td>';
            
            $botones=array();
            array_push($botones,'<a onclick="fncEditar(' . $item['ID'] . ');" ><span class="glyphicon glyphicon-pencil" title="Editar Persona">Editar</a>');
            array_push($botones,'<a onclick="modal.confirmacion(&#39;El proceso es irreversible, esta seguro de eliminar el registro.&#39;,&#39;Eliminar Persona&#39;,fncEliminar,&#39;' . $item['ID'] . '&#39;);" title="Eliminar Persona"><span class="glyphicon glyphicon-trash">Eliminar</a>');
            $resultado.='<td class="btnAction" >'.extraerOpcion($botones)."</td>";
            $resultado.='</tr>';
            $i++;
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
function post_ajaxPersona_Mantenimiento_Eliminar($id) {
    require ROOT_PATH . 'models/persona.php';
    

    try {
        $oPersona = persona::getByID1($id);
        
        if ($oPersona == null) {
            $resultado=-1;
            $mensaje="No existe el registro.";
        }else{
            $oPersona->usuario_mod_id = $_SESSION['usuario_ID'];
            $retorna=$oPersona->eliminar();
            if($retorna==0){
                $resultado=-1;
                $mensaje="No se guardó ningún registro.";
            }
            if($retorna==-2){
                $resultado=-1;
                $mensaje="No se puede eliminar, la persona esta asignado como chofer.";
            }
            if($retorna==-3){
                $resultado=-1;
                $mensaje="No se puede eliminar, la persona tiene un usuario registrado.";
            }
            if($retorna==-4){
                $resultado=-1;
                $mensaje="No se puede eliminar, la persona esta registrado como contacto de un cliente.";
            }
            if($retorna==-5){
                $resultado=-1;
                $mensaje="No se puede eliminar, la persona esta registrado como contacto de un proveedor.";
            }
            if($retorna==-6){
                $resultado=-1;
                $mensaje="No se puede eliminar, la persona esta registrado como operador.";
            }
            if($retorna>0){
                $resultado=1;
                $mensaje="Se eliminó correctamente.";
            }
        }
        $funcion = '';
    } catch (Exception $ex) {
        $resultado = -1;
        log_error(__FILE__,"Configuracion_general/post_ajaxPersona_Mantenimiento_Eliminar", $ex->getMessage());
        $mensaje =mensaje_error;
        $funcion = '';
    }

    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje, 'funcion' => $funcion);

    echo json_encode($retornar);
}
