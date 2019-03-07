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
        foreach ($dtUsuario as $item) {
            
            $resultado.='<tr class="tr-item" >';
            $resultado.='<td>'.$i.'</td>';
            $resultado.='<td class="tdLeft">' . FormatTextView(strtoupper($item['apellido_paterno'])) . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextView(strtoupper($item['apellido_materno'])). '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextView(strtoupper($item['nombres'])) . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextView(strtoupper($item['usuario'])) . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextView(strtoupper($item['password'])). '</td>';
            $resultado.='<td class="tdLeft"></td>';
            $resultado.='<td class="tdLeft">' . FormatTextView(strtoupper($item['estado'])) . '</td>';
            $botones=array();
            if($item['ID']>0){
                $boton='<a onclick="fncEditar(' . $item['ID'] . ');" title="Editar"><span class="glyphicon glyphicon-pencil"></span> Editar</a>';
                array_push($botones,$boton);
                array_push($botones,'<a onclick="fncMenu(' . $item['ID'] . ');" title="Asignar menu"><span class="glyphicon glyphicon-align-left"></span>Asignar Menu</a>');
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
    require ROOT_PATH . 'models/configuracion.php';
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
        $oUsuario->usuario_mod_id=$_SESSION['usuario_ID'];
        $oUsuario->actualizar();
        $GLOBALS['resultado'] = 1;
        $GLOBALS['mensaje'] = "Se guardó correctamente.";
    } catch (Exception $ex) {
        $GLOBALS['resultado'] = -1;
        $GLOBALS['mensaje'] = $ex->getMessage();
    }
    $dtPersona=persona::getGrid("",-1,-1,"apellido_paterno,apellido_materno,nombres");
    $dtEstado=estado::getGrid('est.tabla="usuario"');
    $dtPerfil = perfil::getGrid("",-1,-1,"nombre asc");
    $oUsuario->dtEstado=$dtEstado;
    $oUsuario->dtPerfil=$dtPerfil;
    $GLOBALS['dtPersona'] = $dtPersona;
    $GLOBALS['oUsuario'] = $oUsuario;
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
function post_ajacGrabarMenu_Usuario(){
    require ROOT_PATH . 'models/menu_usuario.php';
    $lista_menu=$_POST['lista_menu'];
    $usuario_ID=$_POST['usuario_ID'];
    $modulo_ID=$_POST['modulo_ID'];
    try{
        $retorna=menu_usuario::registrar($usuario_ID,$lista_menu,$modulo_ID);
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
    $usuario_ID=$_POST['id'];
    $modulo_ID=$_POST['id1'];
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
        
        $html=menu::getListaMenuModulo($modulo_ID,$usuario_ID);
    }catch (Exception $ex) {
        log_error(__FILE__,"configuracion_generaleController/post_ajaxExtraer_Menu_Modulo",$ex->getMessage());
        $html.=utf8_encode(mensaje_error);
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
    $resultado = '<table id="websendeos" class="grid table table-hover"><thead><tr>';
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
            $resultado.='<td class="tdLeft">' . $item['ID'] . '</td>';
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
            $resultado.='<td class="tdLeft">' . FormatTextView($item['nombre']) . '</td>';
            $resultado.='<td class="tdLeft">' . $item['ruc'] . '</td>';
            $resultado.='<td class="tdLeft">' . $item['ruta'] . '</td>';
            $resultado.='<td class="tdLeft">' . $item['direccion'] . '</td>';
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
    require ROOT_PATH . 'models/datos_generales.php';
    require ROOT_PATH . 'models/distrito.php';
    require ROOT_PATH . 'models/provincia.php';
    require ROOT_PATH . 'models/departamento.php';
    require ROOT_PATH . 'models/configuracion.php';
    global $returnView_float;
    $returnView_float = true;
    $oEmpresa = new empresa();
    $dtConfiguracion=configuracion::getGrid();
    $oEmpresa->stilo_fondo_tabs="";
    $oEmpresa->stilo_fondo_boton="";
    $oEmpresa->stilo_fondo_cabecera="";
    $oEmpresa->ruta=$dtConfiguracion[3]["valores"];
    $GLOBALS['oEmpresa'] = $oEmpresa;
    $oDatos_Generales=new datos_generales();
    
    
    $oDatos_Generales->distrito_ID=$dtConfiguracion[1]["valores"];//Seleccionamos Lima
    $oDistrito=distrito::getByID($dtConfiguracion[1]["valores"]);
    $oProvincia=provincia::getByID($oDistrito->provincia_ID);
    $dtDepartamento=departamento::getGrid("",-1,-1,"d.nombre asc");
    $dtProvincia=provincia::getGrid("pv.departamento_ID=".$oProvincia->departamento_ID,-1,-1,"pv.nombre asc");
    $dtDistrito=distrito::getGrid("dt.provincia_ID=".$oDistrito->provincia_ID,-1,-1,"dt.nombre asc");
    $oDatos_Generales->departamento_ID=$oProvincia->departamento_ID;
    $oDatos_Generales->provincia_ID=$oDistrito->provincia_ID;
    $oDatos_Generales->favicon="default.ico";
    $oDatos_Generales->logo_extension="default.jpg";
    $oDatos_Generales->imagen="default.jpg";
    $oDatos_Generales->tipo_cambio=$dtConfiguracion[4]["valores"];//Tipo de cambio por defecto;
    $oDatos_Generales->vigv=$dtConfiguracion[2]["valores"];
    $GLOBALS['oDatos_Generales']=$oDatos_Generales;
    $GLOBALS['dtDepatamento']=$dtDepartamento;
    $GLOBALS['dtProvincia']=$dtProvincia;
    $GLOBALS['dtDistrito']=$dtDistrito;
  
}
function post_Empresa_Mantenimiento_Nuevo() {
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
    
    $oEmpresa = new empresa(); 
    $oDatos_Generales=new datos_generales();
    try {  
        
        $oEmpresa->nombre = $nombre;
        $oEmpresa->stilo_fondo_tabs = $stilo_fondo_tabs;
        $oEmpresa->stilo_fondo_boton = $stilo_fondo_boton;
        $oEmpresa->stilo_fondo_cabecera = $stilo_fondo_cabecera;
        $oEmpresa->ruta=$ruta;
        $oEmpresa->usuario_id = $_SESSION['usuario_ID'];
        
        $oEmpresa->insertar();
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
}

function get_Empresa_Mantenimiento_Editar($id) {
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
}
function post_ajaxEmpresa_Mantenimiento_Eliminar($id) {
    require ROOT_PATH . 'models/empresa.php';
    require ROOT_PATH . 'models/datos_generales.php';
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
    require ROOT_PATH . 'models/datos_generales.php';
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
    global $returnView;
    $returnView = true;
}
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
}
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
