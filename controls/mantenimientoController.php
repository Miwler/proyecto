<?php

/* Vista de proveedores */

function get_Index($id) {
    global $returnView;
    $returnView = true;
}

//-----------------------------------------------------------------------------------------------------------------------------
function get_Proveedor_Mantenimiento() {
    global $returnView;
    $returnView = true;
}

//muestra la ventana para agregar nuevo proveedor
function get_Proveedor_Mantenimiento_Nuevo() {
    require ROOT_PATH . 'models/proveedor.php';
    require ROOT_PATH . 'models/proveedor_contacto.php';
    require ROOT_PATH.  'models/estado.php';
    require ROOT_PATH . 'models/departamento.php';
    require ROOT_PATH . 'models/provincia.php';
    require ROOT_PATH . 'models/distrito.php';
    global $returnView_float;
    $returnView_float = true;
    $oProveedor = new proveedor;
    
    $oProveedor->dtDepartamento=departamento::getGrid("",-1,-1,"nombre asc");
    $oProveedor->dtProvincia=provincia::getGrid("departamento_ID=15",-1,-1,"nombre asc");
    $oProveedor->dtDistrito=distrito::getGrid("provincia_ID=129",-1,-1,"nombre asc");
    $oProveedor->dtEstado=estado::getGrid("est.tabla='proveedor'",-1,-1,"est.orden asc");
    
    $oProveedor->departamento_ID=15;
    $oProveedor->provincia_ID=129;
    $oProveedor->distrito_ID=1261;
    $oProveedor_Contacto=new proveedor_contacto();
    $oProveedor_Contacto->dtEstado=estado::getGrid("est.tabla='proveedor_contacto'",-1,-1,"est.orden asc");
    $GLOBALS['oProveedor'] = $oProveedor;
    $GLOBALS['oProveedor_Contacto']=$oProveedor_Contacto;
    
}

//graba los datos que se recuperan por el metodo post en nuevo proveedor
function post_Proveedor_Mantenimiento_Nuevo() {
    require ROOT_PATH . 'models/proveedor.php';
    require ROOT_PATH . 'models/proveedor_contacto.php';
    require ROOT_PATH.  'models/estado.php';
    require ROOT_PATH . 'models/departamento.php';
    require ROOT_PATH . 'models/provincia.php';
    require ROOT_PATH . 'models/distrito.php';
    global $returnView_float;
    $returnView_float = true;
    //Datos de empresa
    $ruc = $_POST['txtRuc'];
    $razon_social = trim($_POST['txtRazon_Social']);
    $direccion_fiscal = trim($_POST['txtDireccion_Fiscal']);
    $nombre_comercial = trim($_POST['txtNombre_Comercial']);
    $telefono = trim($_POST['txtTelefono']);
    $celular = trim($_POST['txtCelular']);
    $fax=trim($_POST['txtFax']);
    $correo=trim($_POST['txtCorreo']);
    $departamento_ID=$_POST['selDepartamento'];
    $provincia_ID=$_POST['selProvincia'];
    $distrito_ID=$_POST['selDistrito'];
    $direccion=trim($_POST['txtDireccion']);
    $banco=trim($_POST['txtBanco']);
    $numero_cuenta_soles = $_POST['txtNumero_Cuenta_Soles'];
    $numero_cuenta_dolares = $_POST['txtNumero_Cuenta_Dolares'];
    $parne=trim($_POST['txtParne']);
    $estado_ID=$_POST['selEstado'];
    
    //Datos de persona de contacto
    if(isset($_POST['txtPersona_ID'])&&trim($_POST['txtPersona_ID'])!=""&& $_POST['txtPersona_ID']!=0){
        $persona_ID=$_POST['txtPersona_ID'];
        
        $telefono1 = trim($_POST['txtTelefono1']);
        $celular1 = trim($_POST['txtCelular1']);
        $correo1=trim($_POST['txtCorreo1']);
        $estado_ID1=$_POST['selEstado1'];
    }
    $oProveedor = new proveedor();
    $oProveedor_Contacto=new proveedor_contacto();
    try {
        $oProveedor->empresa_ID=$_SESSION['empresa_ID'];
        $oProveedor->ruc = $ruc;
        $oProveedor->razon_social = $razon_social;
        $oProveedor->direccion_fiscal = $direccion_fiscal;
        $oProveedor->nombre_comercial = $nombre_comercial;
        $oProveedor->telefono = $telefono;
        $oProveedor->celular = $celular;
        $oProveedor->fax = $fax;
        $oProveedor->correo = $correo;
        $oProveedor->distrito_ID = $distrito_ID;
        $oProveedor->direccion = $direccion;
        $oProveedor->banco = $banco;
        $oProveedor->numero_cuenta_soles = $numero_cuenta_soles;
        $oProveedor->numero_cuenta_dolares = $numero_cuenta_dolares;
        $oProveedor->parne = $parne;
        $oProveedor->estado_ID = $estado_ID;
        $oProveedor->usuario_id = $_SESSION['usuario_ID'];

        $retorna = $oProveedor->insertar1();

        if ($retorna==-2) {
                $resultado=-1;
                $mensaje="Ya existe un proveedor con la misma razon social..";
                
        }else{
            if ($retorna==-3)
             {
                $resultado=-1;
                $mensaje="Ya existe un proveedor con el mismo ruc..";
                
             }else{  
        
//        $oProveedor->insertar();
        if(isset($_POST['txtPersona_ID'])&&trim($_POST['txtPersona_ID'])!=""&&$_POST['txtPersona_ID']!=0){
            if($oProveedor->ID>0){
                
                $oProveedor_Contacto->persona_ID=$persona_ID;
                $oProveedor_Contacto->proveedor_ID=$oProveedor->ID;
                
                $oProveedor_Contacto->telefono=$telefono1;
                $oProveedor_Contacto->celular=$celular1;
                $oProveedor_Contacto->correo=$correo1;
                $oProveedor_Contacto->estado_ID=$estado_ID1;
                $oProveedor_Contacto->usuario_id=$_SESSION['usuario_ID'];
                if($oProveedor_Contacto->verificarDuplicado()>0){
                    throw new Exception($oProveedor_Contacto->getMessage);
                }
                $oProveedor_Contacto->insertar();
                $resultado= 1;
                $mensaje=$oProveedor_Contacto->getMessage; 
            }
        }else{
            $resultado= 1;
            $mensaje=$oProveedor->getMessage;  
        }
             }
        }
       
    } catch (Exception $ex) {
        $resultado= -1;
        $mensaje = utf8_encode(mensaje_error);
        log_error(__FILE__, "mantenimiento/post_proveedor_mantenimiento_nuevo", $ex->getMessage());
    }
    $oProveedor->dtDepartamento=departamento::getGrid("",-1,-1,"nombre asc");
    $oProveedor->dtProvincia=provincia::getGrid("departamento_ID=".$departamento_ID,-1,-1,"nombre asc");
    $oProveedor->dtDistrito=distrito::getGrid("provincia_ID=".$provincia_ID,-1,-1,"nombre asc");
    $oProveedor->dtEstado=estado::getGrid("est.tabla='proveedor'",-1,-1,"est.orden asc");
    $oProveedor->departamento_ID=$departamento_ID;
    $oProveedor->provincia_ID=$provincia_ID;
    $oProveedor_Contacto->dtEstado=estado::getGrid("est.tabla='proveedor_contacto'",-1,-1,"est.orden asc");
    $GLOBALS['oProveedor'] = $oProveedor;
    $GLOBALS['oProveedor_Contacto']=$oProveedor_Contacto;
    $GLOBALS['resultado']=$resultado;
    $GLOBALS['mensaje']=$mensaje;
}

//muestra la ventana editar proveedor
function get_Proveedor_Mantenimiento_Editar($id) {
    require ROOT_PATH . 'models/proveedor.php';
    require ROOT_PATH . 'models/proveedor_contacto.php';
    require ROOT_PATH.  'models/estado.php';
    require ROOT_PATH . 'models/departamento.php';
    require ROOT_PATH . 'models/provincia.php';
    require ROOT_PATH . 'models/distrito.php';
    global $returnView_float;
    $returnView_float = true;
    $oProveedor = proveedor::getByID($id);
    if($oProveedor==null){
        $GLOBALS['resultado'] = -2;
        $GLOBALS['mensaje'] = "El proveedor ha sido eliminado por otro usuario.";
        return;
    }
    $oDistrito=distrito::getByID($oProveedor->distrito_ID);
    $oProvincia=provincia::getByID($oDistrito->provincia_ID);
    $oProveedor->departamento_ID=$oProvincia->departamento_ID;
    $oProveedor->provincia_ID=$oProvincia->ID;
    $oProveedor->dtDepartamento=departamento::getGrid("",-1,-1,"nombre asc");
    $oProveedor->dtProvincia=provincia::getGrid("departamento_ID=".$oProvincia->departamento_ID,-1,-1,"nombre asc");
    $oProveedor->dtDistrito=distrito::getGrid("provincia_ID=".$oDistrito->provincia_ID,-1,-1,"nombre asc");
    $oProveedor->dtEstado=estado::getGrid("est.tabla='proveedor'",-1,-1,"est.orden asc");
    

    //$dtPersona_Contacto=proveedor_contacto::getGrid("proveedor_ID=".$id);
    $oProveedor_Contacto=new proveedor_contacto();
    $oProveedor_Contacto->dtEstado=estado::getGrid("est.tabla='proveedor_contacto'",-1,-1,"est.orden asc");
    $GLOBALS['oProveedor'] = $oProveedor;
    $GLOBALS['oProveedor_Contacto']=$oProveedor_Contacto;
    
}

//graba los datos que se recuperan por el metodo post en editar proveedor
function post_Proveedor_Mantenimiento_Editar($id) {
    require ROOT_PATH . 'models/proveedor.php';
    require ROOT_PATH . 'models/proveedor_contacto.php';
    require ROOT_PATH.  'models/estado.php';
    require ROOT_PATH . 'models/departamento.php';
    require ROOT_PATH . 'models/provincia.php';
    require ROOT_PATH . 'models/distrito.php';
    global $returnView_float;
    $returnView_float = true;
    
    $oProveedor = proveedor::getByID($id);

    if($oProveedor==null){
        $GLOBALS['resultado'] = -2;
        $GLOBALS['mensaje'] = "El proveedor ha sido eliminado por otro usuario.";
        return;
    }
    
    $ruc = $_POST['txtRuc'];
    $razon_social = trim($_POST['txtRazon_Social']);
    $direccion_fiscal = trim($_POST['txtDireccion_Fiscal']);
    $nombre_comercial = trim($_POST['txtNombre_Comercial']);
    $telefono = trim($_POST['txtTelefono']);
    $celular = trim($_POST['txtCelular']);
    $fax=trim($_POST['txtFax']);
    $correo=trim($_POST['txtCorreo']);
    $departamento_ID=$_POST['selDepartamento'];
    $provincia_ID=$_POST['selProvincia'];
    $distrito_ID=$_POST['selDistrito'];
    $direccion=trim($_POST['txtDireccion']);
    $banco=trim($_POST['txtBanco']);
    $numero_cuenta_soles = $_POST['txtNumero_Cuenta_Soles'];
    $numero_cuenta_dolares = $_POST['txtNumero_Cuenta_Dolares'];
    $parne=trim($_POST['txtParne']);
    $estado_ID=$_POST['selEstado'];
    
    if(isset($_POST['txtPersona_ID'])&&trim($_POST['txtPersona_ID'])!=""&&$_POST['txtPersona_ID']!=0){
    $persona_ID=$_POST['txtPersona_ID'];
//    $cargo=FormatTextSave(strtoupper(trim($_POST['txtCargo'])));
    //$direccion1=FormatTextSave(strtoupper($_POST['txtDireccion1']));
    $telefono1 = trim($_POST['txtTelefono1']);
    $celular1 = trim($_POST['txtCelular1']);
    $correo1=trim($_POST['txtCorreo1']);
    $estado_ID1=$_POST['selEstado1'];
    }
    
        $oProveedor_Contacto=new proveedor_contacto();
    
    try {
        
        $oProveedor->ruc = $ruc;
        $oProveedor->razon_social = $razon_social;
        $oProveedor->direccion_fiscal = $direccion_fiscal;
        $oProveedor->nombre_comercial = $nombre_comercial;
        $oProveedor->telefono = $telefono;
        $oProveedor->celular = $celular;
        $oProveedor->fax = $fax;
        $oProveedor->correo = $correo;
        $oProveedor->distrito_ID = $distrito_ID;
        $oProveedor->direccion = $direccion;
        $oProveedor->banco = $banco;
        $oProveedor->numero_cuenta_soles = $numero_cuenta_soles;
        $oProveedor->numero_cuenta_dolares = $numero_cuenta_dolares;
        $oProveedor->parne = $parne;
        $oProveedor->estado_ID = $estado_ID;
        $oProveedor->usuario_mod_id = $_SESSION['usuario_ID'];

        $retorna = $oProveedor->actualizar1();

        if ($retorna==-2) {
            $resultado= -1;
            $mensaje="Ya existe un proveedor con la misma razon social..";
            
        }else{
            if ($retorna==-3)
             {
            $resultado= -1;
            $mensaje="Ya existe un proveedor con el mismo ruc..";
            
             }else{  
        
//        $oProveedor->actualizar();
        
        if(isset($_POST['txtPersona_ID'])&&trim($_POST['txtPersona_ID'])!=""&&$_POST['txtPersona_ID']!=0){
           if($oProveedor->ID>0){
            $oProveedor_Contacto->persona_ID=$persona_ID;
//            $oProveedor_Contacto->codigo=$oProveedor_Contacto->getCodigo();
            $oProveedor_Contacto->proveedor_ID=$oProveedor->ID;
//            $oProveedor_Contacto->cargo=$cargo;

            $oProveedor_Contacto->telefono=$telefono1;
            $oProveedor_Contacto->celular=$celular1;
            $oProveedor_Contacto->correo=$correo1;
            $oProveedor_Contacto->estado_ID=$estado_ID1;
            $oProveedor_Contacto->usuario_id=$_SESSION['usuario_ID'];
            if($oProveedor_Contacto->verificarDuplicado>0){
                throw new Exception($oProveedor_Contacto->getMessage);
            }
            $oProveedor_Contacto->insertar();
            $resultado= 1;
            $mensaje=$oProveedor_Contacto->getMessage; 
        }
        }else{
            $resultado=1;
            $mensaje="Se actualizó correctamente";   
        }
             }
        }
        
    } catch (Exception $ex) {
        $resultado= -1;
        $mensaje = utf8_encode(mensaje_error);
        log_error(__FILE__, "mantenimiento/post_proveedor_mantenimiento_editar", $ex->getMessage());
    }
    
    $oProveedor->dtDepartamento=departamento::getGrid("",-1,-1,"nombre asc");
    $oProveedor->dtProvincia=provincia::getGrid("departamento_ID=".$departamento_ID,-1,-1,"nombre asc");
    $oProveedor->dtDistrito=distrito::getGrid("provincia_ID=".$provincia_ID,-1,-1,"nombre asc");
    $oProveedor->dtEstado=estado::getGrid("est.tabla='proveedor'",-1,-1,"est.orden asc");
    $oProveedor->departamento_ID=$departamento_ID;
    $oProveedor->provincia_ID=$provincia_ID;

    $oProveedor_Contacto->dtEstado=estado::getGrid("est.tabla='proveedor_contacto'",-1,-1,"est.orden asc");
    $GLOBALS['oProveedor'] = $oProveedor;
    $GLOBALS['oProveedor_Contacto']=$oProveedor_Contacto;
    $GLOBALS['resultado']=$resultado;
    $GLOBALS['mensaje']=$mensaje;
}

//muestra la grilla cargada con datos de proveedor,trabaja con ajax
function post_ajaxProveedor_Mantenimiento() {
    require ROOT_PATH . 'models/proveedor.php';
    require ROOT_PATH . 'controls/funcionController.php';
    $ruc = test_input($_POST['txtRUC']);
    $razon_social = test_input($_POST['txtRazon_Social']);
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
            $orden = 'prv.ID ' . $orden_tipo;
            break;
        case 1:
            $orden = 'prv.ruc ' . $orden_tipo;
            break;
        case 2:
            $orden = 'prv.razon_social ' . $orden_tipo;
            break;
        case 3:
            $orden = 'prv.direccion ' . $orden_tipo;
            break;
        case 4:
            $orden = 'prv.telefono ' . $orden_tipo;
            break;
        case 5:
            $orden = 'prv.celular ' . $orden_tipo;
            break;
        case 6:
            $orden = 'prv.correo ' . $orden_tipo;
            break;
        default:
            $orden = 'prv.ID ' . $orden_tipo;
            break;
    }
    if($ruc!=""){
        $filtro='prv.empresa_ID='.$_SESSION['empresa_ID'].' and prv.ruc="'.$ruc.'"';
    }else{
       $filtro = 'prv.empresa_ID='.$_SESSION['empresa_ID'].' and upper(prv.razon_social) like "%' . strtoupper($razon_social) . '%"';
    }
    
    //---------------------------------------					 
    $resultado = '<table id="websendeos" class="grid table table-hover table-bordered"><tr>';
    $resultado.='<th class="text-center">N°</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(1);">R.u.c.' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(2);">Razon social' . (($txtOrden == 2 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(3);">Dirección' . (($txtOrden == 3 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(4);">Teléfono' . (($txtOrden == 4 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(5);">Celular' . (($txtOrden == 5 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(6);">Correo' . (($txtOrden == 6 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th>Opciones</th>';
    $resultado.='</tr>';

    $colspanFooter = 9;
    try {
        $cantidadMaxima = proveedor::getCount($filtro);
        $dtProveedor = proveedor::getGrid($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
        $rows = count($dtProveedor);
        $i=($paginaActual-1)*$cantidadMostrar+1;
        foreach ($dtProveedor as $item) {
            $resultado.='<tr class="tr-item">';
            $resultado.='<td class="text-center">'.$i.'</td>';
            $resultado.='<td class="text-center">' . $item['ruc'] . '</td>';
            $resultado.='<td class="tdLeft">' . test_input($item['razon_social']) . '</td>';
            $resultado.='<td class="tdLeft">' . test_input($item['direccion']) . '</td>';
            $resultado.='<td class="tdLeft">' . test_input($item['telefono']) . '</td>';
            $resultado.='<td class="tdLeft">' . test_input($item['celular']) . '</td>';
            $resultado.='<td class="tdLeft">' . test_input($item['correo']) . '</td>';
            $botones=array();
            array_push($botones,'<a onclick="fncEditar(' . $item['ID'] . ');" ><span class="glyphicon glyphicon-pencil" title="Editar Proveedor">Editar</a>');
            array_push($botones,'<a onclick="modal.confirmacion(&#39;El proceso es irreversible, esta seguro de eliminar el registro.&#39;,&#39;Eliminar Proveedor&#39;,fncEliminar,&#39;' . $item['ID'] . '&#39;);" title="Eliminar Proveedor"><span class="glyphicon glyphicon-trash">Eliminar</a>');
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
    

    echo json_encode($retornar);
}
function post_ajaxMostar_Lista_Contacto() {
    
    require ROOT_PATH . 'models/proveedor_contacto.php';
    $proveedor_ID=$_POST['id'];
    $resultado='<table class="table table-striped"><thead><tr>';
    $resultado.='<th>Persona</th><th>Teléfono</th><th>Celular</th><th>Correo</th><th>Estado</th><th>Opciones</th>';
    $resultado.='</thead></tr>';
    $resultado.='<tbody>';
    try {
        
        $dtProveedor_Contacto=proveedor_contacto::getGrid("proc.proveedor_ID=".$proveedor_ID);
        foreach($dtProveedor_Contacto as $item){
            $resultado.='<tr id="'.$item['ID'].'">';
            $resultado.='<td>'.FormatTextView(strtoupper($item['apellido_paterno'].' '.$item['apellido_materno'].', '.$item['nombres'])).'</td>';
            $resultado.='<td>'.FormatTextView($item['telefono']).'</td>';
            $resultado.='<td>'.FormatTextView($item['celular']).'</td>';
            $resultado.='<td>'.FormatTextView($item['correo']).'</td>';
            $resultado.='<td>'.FormatTextView(strtoupper($item['estado'])).'<input id="txt'.$item['ID'].'" value="'.$item['persona_ID'].'" style="display:none;"><input id="est'.$item['ID'].'" value="'.$item['estado_ID'].'" style="display:none;"></td>';
            $botones=array();
            array_push($botones,'<a onclick="fncEditar(' . $item['ID'] . ');" ><span class="glyphicon glyphicon-pencil" title="Editar Contacto">Editar</a>');
            array_push($botones,'<a onclick="modal.confirmacion(&#39;El proceso es irreversible, esta seguro de eliminar el registro.&#39;,&#39;Eliminar Contacto&#39;,fncEliminar,&#39;' . $item['ID'] . '&#39;);" title="Eliminar chofer"><span class="glyphicon glyphicon-trash">Eliminar</a>');
            $resultado.='<td class="btnAction" >'.extraerOpcion($botones)."</td>";
            $resultado.='</tr>';
        }
        
    }catch(Exception $ex){
        $resultado.='<tr><td claspan="6">'.$ex->getMessage().'</td></tr>';
        
    }
    $resultado.='</tbody>';
    $resultado.='</table>';
    $retornar = Array('resultado' => $resultado);
    //$retorn="<h1>Hola</h1>";

    echo json_encode($retornar);
}
function post_ajaxAccionProveedor_Contacto() {
    require ROOT_PATH . 'models/proveedor_contacto.php';
    $ID=$_POST['txtID'];
    $proveedor_ID=$_POST['txtproveedor_ID'];
    if(isset($_POST['txtPersona_ID'])){
        $persona_ID=$_POST['txtPersona_ID'];
        
        $telefono1 = test_input($_POST['txtTelefono1']);
        $celular1 = test_input($_POST['txtCelular1']);
        $correo1=test_input($_POST['txtCorreo1']);
        $estado_ID1=$_POST['selEstado1'];
    }
    try {
        if($ID==0){
            $oProveedor_Contacto=new proveedor_contacto();
            $oProveedor_Contacto->persona_ID=$persona_ID;
            $oProveedor_Contacto->telefono=$telefono1;
            $oProveedor_Contacto->celular=$celular1;
            $oProveedor_Contacto->correo=$correo1;
            $oProveedor_Contacto->estado_ID=$estado_ID1;
            $oProveedor_Contacto->proveedor_ID=$proveedor_ID;
            $oProveedor_Contacto->usuario_id=$_SESSION['usuario_ID'];
//            if($oProveedor_Contacto->verificarDuplicado>0){
//                    throw new Exception($oProveedor_Contacto->getMessage);
//                }
            $retorna = $oProveedor_Contacto->insertar1();
        }else{
            $oProveedor_Contacto=proveedor_contacto::getByID($ID);
            $oProveedor_Contacto->persona_ID=$persona_ID;
            $oProveedor_Contacto->telefono=$telefono1;
            $oProveedor_Contacto->celular=$celular1;
            $oProveedor_Contacto->correo=$correo1;
            $oProveedor_Contacto->estado_ID=$estado_ID1;
            $oProveedor_Contacto->proveedor_ID=$proveedor_ID;
            if($oProveedor_Contacto==null){
                throw new Exception("No existe el registro.");
            }
//            if($oProveedor_Contacto->verificarDuplicado>0){
//                throw new Exception($oProveedor_Contacto->getMessage);
//            }
           
            $oProveedor_Contacto->usuario_mod_id=$_SESSION['usuario_ID'];
            $retorna = $oProveedor_Contacto->actualizar1();
        }
        
            if($retorna==-2){
                $mensaje="La persona ya existe.";
                $resultado=-1;
            }
            if($retorna==0){
                $mensaje="No se actualizó ningún registro.";
                $resultado=-1;
            }
            if($retorna>0){
                $mensaje="Se actualizó correctamente";
                $resultado=1;
            }
        
//        $mensaje=$oProveedor_Contacto->getMessage;
//        $resultado=1;
    }catch(Exception $ex){
        $resultado=-1;
        $mensaje=$ex->getMessage();
    }
    $retornar = Array('resultado' => $resultado,'mensaje'=>$mensaje);
    echo json_encode($retornar);
}
//eliminar proveedor
function post_ajaxProveedor_Mantenimiento_Eliminar($id) {
    require ROOT_PATH . 'models/proveedor.php';
	require ROOT_PATH . 'models/proveedor_contacto.php';

    try {
        $oProveedor = proveedor::getByID($id);
        $oProveedor->usuario_mod_id = $_SESSION['usuario_ID'];
        if ($oProveedor == null) {
            throw new Exception('Parece que el registro ya fue eliminado.');
        }
		
		
        $oProveedor_Contacto=new proveedor_contacto();
        $contarHijos=$oProveedor_Contacto->verificarHijos($id);
          if($contarHijos==0){
            if ($oProveedor->eliminar() == -1) {
            throw new Exception($oProveedor->getMessage);
            $mensaje = $oProveedor->getMessage;
            }else{$mensaje="Se eliminó correctamente";
                $resultado = 1;
            }
        } else {
            $mensaje="No se puede eliminar al proveedor, tiene contactos asignados.";
             $resultado = 2;
        }
        $funcion = '';
    } catch (Exception $ex) {
        $resultado = -1;
        $mensaje = $ex->getMessage();
        $funcion = '';
    }

    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje, 'funcion' => $funcion);

    echo json_encode($retornar);
}

// muestra la lista deplegable/*

function post_ajaxCbo_ProveedorRuc(){
    require ROOT_PATH.'models/proveedor.php';
    $buscar=$_POST['txtBuscar'];
    if(trim($buscar)!=""){
        $filtro='upper(prv.ruc) like "%'.strtoupper(FormatTextSave($buscar)).'%"';
    }else{
        $filtro='prv.ID=0';
    }

    $dtProveedor=proveedor::getGrid($filtro);

    $i=1;
    $resultado='<ul class="cbo-ul">';
    if(count($dtProveedor)>0){			
        foreach($dtProveedor as $iProveedor){
            $resultado.='<li id="li_'.$i.'" onclick="subirValorCaja(&#39;'.FormatTextViewHtml($iProveedor['ruc']).'&#39;,1);"><span>'.FormatTextViewHtml($iProveedor['ruc']).'</span></li>';
            $i++;
        }
    }
    $resultado.='</ul>';

    $mensaje='';
    $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);
    echo json_encode($retornar);
}
function post_ajaxCbo_ProveedorRazonSocial(){
    require ROOT_PATH.'models/proveedor.php';
    $buscar=$_POST['txtBuscar'];
    if(trim($buscar)!=""){
        $filtro='upper(prv.razon_social) like "%'.strtoupper($buscar).'%"';
    }else{
        $filtro='prv.ID=0';
    }

    $dtProveedor=proveedor::getGrid($filtro);

    $i=1;
    $resultado='<ul class="cbo-ul">';
    if(count($dtProveedor)>0){			
        foreach($dtProveedor as $iProveedor){
            $resultado.='<li id="li_'.$i.'" onclick="subirValorCaja(&#39;'.test_input($iProveedor['razon_social']).'&#39;,2);"><span>'.test_input($iProveedor['razon_social']).'</span></li>';
            $i++;
        }
    }
    $resultado.='</ul>';

    $mensaje='';
    $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);
    echo json_encode($retornar);
}





function post_ajaxProveedor_Mantenimiento_Contacto_Eliminar()
    {
        require ROOT_PATH . 'models/proveedor.php';
	require ROOT_PATH . 'models/proveedor_contacto.php';

        try{
            $id=$_POST['id'];
            $oProveedor_Contacto= proveedor_contacto::getByID($id);
            $oProveedor_Contacto->usuario_mod_id=$_SESSION['usuario_ID'];
            
            if($oProveedor_Contacto==null){
                throw new Exception('Parece que el registro ya fue eliminado.');
            }
            $oProveedor= proveedor::getByID($oProveedor_Contacto->proveedor_ID);
            if($oProveedor==null){
                throw new Exception('El proveedor ha sido eliminado por otro usuario.');
            }
            $varEliminar=$oProveedor_Contacto->eliminar();
            if($varEliminar==-1){
                throw new Exception($oProveedor_Contacto->getMessage);
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



//fin proveedor
//----------------------------------------------------------------------------------------
//inicio mantenimiento categoria
//muestra la ventana para agregar nueva categoria
function get_Categoria_Mantenimiento() {
    require ROOT_PATH . 'models/categoria.php';
    require ROOT_PATH . 'models/linea.php';
    global $returnView;
    $returnView = true;
    $GLOBALS['dtLinea']=linea::getGrid("",-1,-1,"li.nombre asc");
    $GLOBALS['dtCategoria']=categoria::getGrid("",-1,-1,"ca.nombre asc");
}

//muestra la ventana para agregar nueva categoria
function get_Categoria_Mantenimiento_Nuevo($linea_ID) {
    require ROOT_PATH . 'models/categoria.php';
    require ROOT_PATH . 'models/linea.php';
    global $returnView_float;
    $returnView_float = true;
    $oCategoria = new categoria();
   
    $dtLinea=linea::getGrid("",-1,-1,"li.nombre asc");
    $oCategoria->linea_ID=$linea_ID;
    $GLOBALS['oCategoria'] = $oCategoria;
    $GLOBALS['dtLinea']=$dtLinea;
    $GLOBALS['mensaje'] = '';
}

//graba los datos que se recuperan por el metodo post en nueva categoria
function post_Categoria_Mantenimiento_Nuevo() {
    require ROOT_PATH . 'models/categoria.php';
    require ROOT_PATH . 'models/linea.php';
    global $returnView_float;
    $returnView_float = true;

    $nombre = trim($_POST['txtNombre']);
    $descripcion = trim($_POST['txtDescripcion']);
    $linea_ID=$_POST['selLinea'];

    $oCategoria = new categoria;

    try {
        $oCategoria->nombre = $nombre;
        $oCategoria->descripcion = $descripcion;
        $oCategoria->linea_ID=$linea_ID;
        $oCategoria->imagen="";
        $oCategoria->empresa_ID=$_SESSION['empresa_ID'];
        $oCategoria->usuario_id = $_SESSION['usuario_ID'];
        if ($oCategoria->verificarDuplicado() > 0) {
            //throw new Exception($oProducto->message);
            $mensaje="No se puede registrar porque existe una categoría con el mismo nombre";
            $resultado= -1;
             
        } else {
            $oCategoria->insertar();
            $resultado= 1;
            $mensaje=$oCategoria->getMessage;;
            if($_FILES['imagen']['name']){
                $dir_subida = $_SERVER['DOCUMENT_ROOT'].'/files/imagenes/categoria/';
                $nombre_temporal=explode('.',basename($_FILES['imagen']['name']));
                //$extension=$nombre_temporal[1];
                $extension=(strtoupper($nombre_temporal[1])=="JPG"||strtoupper($nombre_temporal[1])=="png"||strtoupper($nombre_temporal[1])=="gif")?$nombre_temporal[1]:"JPG";
                $nombre2=$oCategoria->ID.'.'.$extension;
                $fichero_subido = $dir_subida .basename($nombre2);
                //$nombre_archivo=$oWeb_Banner_Imagen->ID.".".$fichero_subido[1];
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $fichero_subido)) {
                    $oCategoria->imagen=$nombre2;
                    $oCategoria->usuario_mod_id=$_SESSION['usuario_ID'];
                    $oCategoria->actualizar();

                }else{$mensaje="Se guardó la información, pero no se subió la imagen.";}	
            }
            
        }
		
    } catch (Exception $ex) {
        $resultado= -1;
        $mensaje= $ex->getMessage();
        log_error(__FILE__,"mantenimiento/post_Categoria_Mantenimiento_Nuevo",$ex->getMessage());
    }
     $dtLinea=linea::getGrid();
    $GLOBALS['dtLinea']=$dtLinea;
    $GLOBALS['oCategoria'] = $oCategoria;
    $GLOBALS['linea_ID'] = $linea_ID;
    $GLOBALS['resultado'] = $resultado;
    $GLOBALS['mensaje'] = $mensaje;
}

//muestra la ventana editar categoria
function get_Categoria_Mantenimiento_Editar($id) {
    require ROOT_PATH . 'models/categoria.php';
    require ROOT_PATH . 'models/linea.php';
    global $returnView_float;
    $returnView_float = true;
    $oCategoria = categoria::getByID($id);
    $oLinea=new linea();
    $dtLinea=$oLinea->getGrid();
    $GLOBALS['dtLinea']=$dtLinea;
    $dtLinea=$oLinea->getGrid();
    if ($oCategoria == null) {
        throw new Exception("No existe la categoría");
    }
    $ruta_imagen="/include/img/boton/camara_128x128.png";
    if(trim($oCategoria->imagen)!=""){
        $ruta_imagen = '/files/imagenes/categoria/'.$oCategoria->imagen;

    }
    $oCategoria->ruta_imagen=$ruta_imagen;
   
    $GLOBALS['oCategoria'] = $oCategoria;

}

//graba los datos que se recuperan por el metodo post en editar categoria
function post_Categoria_Mantenimiento_Editar($id) {
    require ROOT_PATH . 'models/categoria.php';
    require ROOT_PATH . 'models/linea.php';

    global $returnView_float;
    $returnView_float = true;
    
    $nombre = trim($_POST['txtNombre']);
    $descripcion =trim($_POST['txtDescripcion']);
    $linea_ID=$_POST['selLinea'];
    $oCategoria = categoria::getByID($id);
    try {
        if ($oCategoria == null) {
            throw new Exception("No existe la categoría.");
        }
        $nombre = $_POST['txtNombre'];
        $descripcion = $_POST['txtDescripcion'];
        $linea_ID=$_POST['selLinea'];
        $oCategoria->nombre = trim($nombre);
        $oCategoria->descripcion = $descripcion;
        $oCategoria->linea_ID=$linea_ID;
        $oCategoria->usuario_mod_id = $_SESSION['usuario_ID'];
        $oCategoria->empresa_ID=$_SESSION['empresa_ID'];
        if ($oCategoria->verificarDuplicado() > 0) {
            //throw new Exception($oProducto->message);
             $mensaje="No se puede registrar porque existe un producto con el mismo nombre";
             $resultado = -1;

        } else {
            $oCategoria->actualizar();
            
            $resultado= 1;
            $mensaje=$oCategoria->getMessage;
            if($_FILES['imagen']['tmp_name']!=""){
                $dir_subida = $_SERVER['DOCUMENT_ROOT'].'/files/imagenes/categoria/';
                $nombre_temporal=explode('.',basename($_FILES['imagen']['name']));
                
                $extension=(strtoupper($nombre_temporal[1])=="JPG"||strtoupper($nombre_temporal[1])=="png"||strtoupper($nombre_temporal[1])=="gif")?$nombre_temporal[1]:"JPG";
                $nombre2=$oCategoria->ID.'.'.$extension;
                $fichero_subido = $dir_subida .basename($nombre2);
                
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $fichero_subido)) {
                    $oCategoria->imagen=$nombre2;
                    $oCategoria->usuario_mod_id=$_SESSION['usuario_ID'];
                    $oCategoria->actualizar();

                }else{$mensaje="Se guardó la información, pero no se subió la imagen.";}
            }
        }
        
              
    } catch (Exception $ex) {
        $resultado= -1;
        $mensaje= $ex->getMessage();
    }
	
	$GLOBALS['dtLinea']=linea::getGrid();
	$GLOBALS['oCategoria'] = $oCategoria;
	$GLOBALS['linea_ID'] = $linea_ID;
        $GLOBALS['resultado'] = $resultado;
        $GLOBALS['mensaje']=$mensaje;
}

//muestra la grilla cargada con datos de categoria,trabaja con ajax
function post_ajaxCategoria_Mantenimiento() {
    require ROOT_PATH . 'models/categoria.php';
    //require ROOT_PATH . 'models/linea.php';
    require ROOT_PATH . 'controls/funcionController.php';
    $buscar = $_POST['txtBuscar'];
    $paginaActual = $_POST['num_page'] == 0 ? 1 : $_POST['num_page'];
    $opcion_tipo=$_POST['rbOpcion'];
    $cantidadMostrar = ($_POST['txtMostrar'] == ''||$_POST['txtMostrar'] ==0) ? 30 : $_POST['txtMostrar'];
    
    $txtOrden = $_POST['txtOrden'];
    $orden_tipo = 'DESC';
    $orden_class = 'imgOrden-desc';
    if (isset($_POST['chkOrdenASC'])) {
        $orden_class = 'imgOrden-asc';
        $orden_tipo = 'ASC';
    }
    switch ($txtOrden) {
        case 0:
            $orden = 'ca.ID ' . $orden_tipo;
            break;
        case 1:
            $orden = 'ca.nombre ' . $orden_tipo;
            break;
        case 2:
            $orden = 'li.nombre ' . $orden_tipo;
            break;
        default:
            $orden = 'ca.ID ' . $orden_tipo;
            break;
    }
    $filtro="";
    if($opcion_tipo=="buscar"){
        $filtro.=((trim($filtro!=""))?" and ":""). 'upper(ca.nombre) like "%' . str_replace(' ', '%', strtoupper($buscar)) . '%"';

    }else{
        $linea_ID=$_POST['selLinea'];
        $categoria_ID=$_POST['selCategoria'];
        $filtro="ca.empresa_ID=".$_SESSION['empresa_ID'];
        if($linea_ID!="0"){
           $filtro.=((trim($filtro!=""))?" and ":"").'ca.linea_ID='.$linea_ID;
        }
        if($categoria_ID!="0"){
            $filtro.=((trim($filtro!=""))?" and ":"").'ca.ID='.$categoria_ID;
        }
    }
    //$filtro.=((trim($filtro!=""))?" and ":""). 'upper(ca.nombre) like "%' . str_replace(' ', '%', strtoupper(FormatTextSave($buscar))) . '%"';

    //---------------------------------------					 
    $resultado = '<table id="websendeos" class="grid table table-hover table-bordered"><thead><tr>';
    $resultado.='<th class="text-center">N°</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(0);">Código' . (($txtOrden == 0 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(1);">Categoría' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(2);">Línea' . (($txtOrden == 2 ? "<img class=" . $orden_class . "/>" : "")) . '</th>';
    $resultado.='<th></th>';
    $resultado.='</tr></thead>';

    $colspanFooter = 5;
    try {
        $cantidadMaxima = categoria::getCount($filtro);
        
        $dtCategoria = categoria::getGrid($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
        $rows = count($dtCategoria);
        $i=($paginaActual-1)*$cantidadMostrar+1;
        foreach ($dtCategoria as $item) {
            //sprintf("%'.07d"
            $resultado.='<tr class="tr-item">';
            $resultado.='<td class="text-center">'.$i.'</td>';
            $resultado.='<td class="text-center">' . sprintf("%'.05d",$item['ID']) . '</td>';
            $resultado.='<td class="text-left">' . test_input($item['nombre']). '</td>';
            $resultado.='<td class="tdLeft">' . test_input($item['linea']). '</td>';
            $botones=array();
            array_push($botones,'<a onclick="fncEditar(' . $item['ID'] . ');" ><span class="glyphicon glyphicon-pencil"></span>Editar</a>');
            array_push($botones,'<a onclick="modal.confirmacion(&#39;El proceso es irreversible, esta seguro de eliminar el registro.&#39;,&#39;Eliminar Categoría&#39;,fncEliminar,&#39;' . $item['ID'] . '&#39;);" title="Eliminar categoría"><span class="glyphicon glyphicon-trash"></span>Eliminar</a>');
            $resultado.='<td class="btnAction" >'.extraerOpcion($botones)."</td>";
            $resultado.='</tr>';
            $i=$i+1;
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

//eliminar categoria
function post_ajaxCategoria_Mantenimiento_Eliminar($id) {
    require ROOT_PATH . 'models/categoria.php';
    require ROOT_PATH . 'models/producto.php';

    try {
        $oCategoria = categoria::getByID($id);
        $oCategoria->usuario_mod_id = $_SESSION['usuario_ID'];
        
        if ($oCategoria == null) {
            throw new Exception('Parece que el registro ya fue eliminado.');
        }
        $oProducto=new producto();
        $contarHijos=$oProducto->verificarHijos($id);
        if($contarHijos==0){
            if ($oCategoria->eliminar() == -1) {
            throw new Exception($oLineaProducto->getMessage);
            $mensaje = $oLineaProducto->getMessage;
            }else{$mensaje="Se eliminó correctamente";
                $resultado = 1;
            }
        } else {
            $mensaje="No se puede eliminar la categoría, tiene productos asignados.";
            $resultado = 2;
        }
        

        $funcion = '';
    } catch (Exception $ex) {
        $resultado = -1;
        $mensaje = $ex->getMessage();
        $funcion = '';
    }

    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje, 'funcion' => $funcion);

    echo json_encode($retornar);
}

//fin mantenimiento categoria
//----------------------------------------------------------------------------------------
//
//inicio vehiculo
function get_Vehiculo_Mantenimiento() {
    global $returnView;
    $returnView = true;
}

//muestra la ventana para agregar nuevo vehiculo
function get_Vehiculo_Mantenimiento_Nuevo() {
    require ROOT_PATH . 'models/vehiculo.php';
    global $returnView_float;
    $returnView_float = true;
    $oVehiculo = new vehiculo();

    $GLOBALS['oVehiculo'] = $oVehiculo;
    
}

//graba los datos que se recuperan por el metodo post en la ventana nuevo vehiculo
function post_Vehiculo_Mantenimiento_Nuevo() {
    require ROOT_PATH . 'models/vehiculo.php';
    global $returnView_float;
    $returnView_float = true;

    $placa = trim($_POST['txtPlaca']);
    $descripcion = trim($_POST['txtDescripcion']);
    $marca = trim($_POST['txtMarca']);
    $certificado_inscripcion = trim($_POST['txtCerti_Incripcion']);

    $oVehiculo = new vehiculo();

    try {
        $oVehiculo->placa = $placa;
        $oVehiculo->descripcion = $descripcion;
        $oVehiculo->marca = $marca;
        $oVehiculo->certificado_inscripcion = $certificado_inscripcion;
        $oVehiculo->usuario_id = $_SESSION['usuario_ID'];
        $oVehiculo->empresa_ID=$_SESSION['empresa_ID'];
        /*if ($oVehiculo->verificarDuplicado() > 0) {
            throw new Exception($oVehiculo->getMessage);
        }*/
		//llama al metodo insertar de Modelo
        $retorna=$oVehiculo->insertar1();
        if($retorna==-2){
            $GLOBALS['resultado'] = -1;
            $GLOBALS['mensaje'] = "Ya existe un vehículo con la misma placa.";
        }
        if($retorna==0){
            $GLOBALS['resultado'] = -1;
            $GLOBALS['mensaje'] = "No se registró el vehículo.";
        }
        if($retorna>1){
            $GLOBALS['resultado'] = 1;
            $GLOBALS['mensaje'] = $oVehiculo->getMessage;
        }
        
    } catch (Exception $ex) {
        $GLOBALS['resultado'] = -1;
        $GLOBALS['mensaje'] = utf8_encode(mensaje_error);
        log_error(__FILE__,"mantenimiento/post_Vehiculo_Mantenimiento_Nuevo",$ex->getMessage());
    }
    $GLOBALS['oVehiculo'] = $oVehiculo;
}

//muestra la ventana editar vehiculo
function get_Vehiculo_Mantenimiento_Editar($id) {
    require ROOT_PATH . 'models/vehiculo.php';
    global $returnView_float;
    $returnView_float = true;

    $oVehiculo = vehiculo::getByID($id);
	
    if($oVehiculo==null){
        $GLOBALS['resultado'] = -2;
        $GLOBALS['mensaje'] = "El vehiculo ha sido eliminado por otro usuario.";
        return;
    }

    try {
        $GLOBALS['oVehiculo'] = $oVehiculo;
        $GLOBALS['mensaje'] = '';
    } catch (Exception $ex) {
        log_error(__FILE__,"mantenimiento/post_Vehiculo_Mantenimiento_Nuevo",$ex->getMessage());
        $GLOBALS['mensaje'] = utf8_encode(mensaje_error);
    }
}

//graba los datos que se recuperan por el metodo post en editar Vehiculo
function post_Vehiculo_Mantenimiento_Editar($id) {
    require ROOT_PATH . 'models/vehiculo.php';
    global $returnView_float;
    $returnView_float = true;
    $oVehiculo = vehiculo::getByID($id);
    if ($oVehiculo == null) {
        $GLOBALS['resultado'] = -2;
        $GLOBALS['mensaje'] = 'El Vehiculo ha sido eliminado por otro usuario.';
        return;
    }
    $placa = FormatTextSave(strtoupper($_POST['txtPlaca']));
    $descripcion = FormatTextSave(strtoupper($_POST['txtDescripcion']));
    $marca = FormatTextSave(strtoupper($_POST['txtMarca']));
    $certificado_inscripcion = FormatTextSave(strtoupper($_POST['txtCerti_Incripcion']));

    try {
        
        $oVehiculo->placa = $placa;
        $oVehiculo->descripcion = $descripcion;
        $oVehiculo->marca = $marca;
        $oVehiculo->certificado_inscripcion = $certificado_inscripcion; 
        $oVehiculo->usuario_mod_id = $_SESSION['usuario_ID'];
        $retorna=$oVehiculo->actualizar1();
        if($retorna==-2){
            $GLOBALS['resultado'] = -1;
            $GLOBALS['mensaje'] = "Ya existe un vehículo con la misma placa.";
        }
        if($retorna==0){
            $GLOBALS['resultado'] = -1;
            $GLOBALS['mensaje'] = "No se registró el vehículo.";
        }
        if($retorna>1){
            $GLOBALS['resultado'] = 1;
            $GLOBALS['mensaje'] = $oVehiculo->getMessage;
        }
        
        
    } catch (Exception $ex) {
        $GLOBALS['resultado'] = -1;
        
        $GLOBALS['mensaje'] = utf8_encode(mensaje_error);
        log_error(__FILE__,"mantenimiento/post_Vehiculo_Mantenimiento_Nuevo",$ex->getMessage());
    }
    $GLOBALS['oVehiculo'] = $oVehiculo;
}

//muestra la grilla cargada con datos de vehiculo,trabaja con ajax
function post_ajaxVehiculo_Mantenimiento() {
    require ROOT_PATH . 'models/vehiculo.php';
    require ROOT_PATH . 'controls/funcionController.php';
    $buscar = trim($_POST['txtBuscar']);
    $codigo=$_POST['txtCodigo'];
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
        case 0:
            $orden = 'ID ' . $orden_tipo;
            break;
        case 1:
             $orden = 'placa ' . $orden_tipo;
            break;
        case 2:
            $orden = 'marca ' . $orden_tipo;
            
            break;
        case 3:
            $orden = 'descripcion ' . $orden_tipo;
           
            break;
        case 4:
            $orden = 'certificado_inscripcion ' . $orden_tipo;
                break;
        default:
        $orden = 'ID ' . $orden_tipo;
        break;
    }
    if(trim($codigo)!=""){
        $filtro= "empresa_ID=".$_SESSION['empresa_ID']. " and ID=".$codigo;
    }else{
       $filtro = 'empresa_ID='.$_SESSION['empresa_ID'].' and upper(concat(placa," ",marca)) like "%' . str_replace(' ', '%', strtoupper(FormatTextSave($buscar))) . '%"';
    }
    
    //---------------------------------------					 
    $resultado = '<table id="websendeos" class="grid table table-hover table-bordered"><thead><tr>';
    $resultado.='<th class="text-center">N°</th>';
    $resultado.='<th  class="thOrden" onclick="fncOrden(0);">Código' . (($txtOrden == 0 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th  class="thOrden" onclick="fncOrden(1);">Placa' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th  class="thOrden" onclick="fncOrden(2);">Marca' . (($txtOrden == 2 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th  class="thOrden" onclick="fncOrden(3);">Descripcion' . (($txtOrden == 3 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    
    $resultado.='<th  class="thOrden" onclick="fncOrden(4);">Certificado de Inscripción' . (($txtOrden == 4 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th>Opción</th>';
    $resultado.='</tr></thead>';
    $resultado.='<tbody>';
    $colspanFooter = 7;
    try {
        $cantidadMaxima = vehiculo::getCount($filtro);
        $dtVehiculo = vehiculo::getGrid($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
        $rows = count($dtVehiculo);
        $i=($paginaActual-1)*$cantidadMostrar+1;
        foreach ($dtVehiculo as $item) {
            
            $resultado.='<tr class="tr-item">';
            $resultado.='<td class="text-center">'.$i.'</td>';
            $resultado.='<td class="text-center">' . sprintf("%'.06d",$item['ID'])  . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextView(strtoupper($item['placa'])) . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextView(strtoupper($item['marca'])) . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextView(strtoupper($item['descripcion'])) . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextView(strtoupper($item['certificado_inscripcion'])) . '</td>';
            $botones=array();
            array_push($botones,'<a onclick="fncEditar(' . $item['ID'] . ');" title="Editar Vehículo"><span class="glyphicon glyphicon-pencil"></span> Editar</a>');	
            array_push($botones,'<a onclick="modal.confirmacion(&#39;El proceso es irreversible, esta seguro de eliminar el registro.&#39;,&#39;Eliminar Producto&#39;,fncEliminar,&#39;' . $item['ID'] . '&#39;);" title="Eliminar producto"><span class="glyphicon glyphicon-trash"></span>Eliminar</a>');
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

//eliminar vehiculo
function post_ajaxVehiculo_Mantenimiento_Eliminar($id) {
    require ROOT_PATH . 'models/vehiculo.php';

    try {
        $oVehiculo = vehiculo::getByID($id);
        if ($oVehiculo == null) {
            throw new Exception('Parece que el registro ya fue eliminado.');
        }
         $oVehiculo->usuario_mod_id = $_SESSION['usuario_ID'];
        if ($oVehiculo->eliminar() == -1) {
            throw new Exception($oVehiculo->getMessage);
        }

        $resultado = 1;
        $mensaje = $oVehiculo->getMessage;
        $funcion = '';
    } catch (Exception $ex) {
        $resultado = -1;
        $mensaje = $ex->getMessage();
        $funcion = '';
    }

    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje, 'funcion' => $funcion);

    echo json_encode($retornar);
}


//fin mantenimiento vehiculo
//-----------------------------------------------------------------------------------
//inicio mantenimiento cliente,nuevo
function get_Cliente_Mantenimiento() {
    global $returnView;
    $returnView = true;
}

function get_Cliente_Mantenimiento_Nuevo() {
    require ROOT_PATH . 'models/cliente.php';
    require ROOT_PATH . 'models/cliente_contacto.php';
    require ROOT_PATH . 'models/forma_pago.php';
    require ROOT_PATH . 'models/estado.php';
    require ROOT_PATH . 'models/departamento.php';
    require ROOT_PATH . 'models/provincia.php';
    require ROOT_PATH . 'models/distrito.php';
    require ROOT_PATH . 'models/credito.php';
    require ROOT_PATH . 'models/operador.php';
    global $returnView_float;
    $returnView_float = true;
    $oCliente = new cliente();
    $oCliente->dtDepartamento=departamento::getGrid("",-1,-1,"nombre asc");
    $oCliente->dtProvincia=provincia::getGrid("departamento_ID=15",-1,-1,"nombre asc");
    $oCliente->dtDistrito=distrito::getGrid("provincia_ID=129",-1,-1,"nombre asc");
    $oCliente->dtEstado=estado::getGrid("est.tabla='cliente'",-1,-1,"est.orden asc");
    $dtOperador=operador::getGrid("",-1,-1,"pe.apellido_paterno asc,pe.apellido_materno asc,pe.nombres asc");
    $oCliente->departamento_ID=15;
    $oCliente->provincia_ID=129;
    $oCliente->distrito_ID=1261;
    
    $oCliente_Contacto=new cliente_contacto();
    $oCliente_Contacto->dtEstado=estado::getGrid("est.tabla='cliente_contacto'",-1,-1,"est.orden asc");
    
    $oCliente->dtForma_Pago = forma_pago::getGrid();
    $oCliente->dtCredito = credito::getGrid();
    $GLOBALS['dtOperador'] = $dtOperador;
    $GLOBALS['oCliente'] = $oCliente;
    $GLOBALS['oCliente_Contacto'] = $oCliente_Contacto;
}
function post_ajaxCbo_FormaPago() {
    require ROOT_PATH . 'models/forma_pago.php';
    
    $dtFm = forma_pago::getGrid('');

    $i = 1;
    $resultado = '<ul class="cbo-ul">';
    if (count($dtFm) > 0) {
        foreach ($dtFm as $iFm) {
            $resultado.='<li id="li_' . $i . '"><span id="' . $iFm['ID'] . '" title="' . FormatTextViewHtml($iFm['nombre']) . '">' . FormatTextViewHtml($iFm['nombre']) . '</span></li>';
            $i++;
        }
    }
    $resultado.='</ul>';

    $mensaje = '';
    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
    echo json_encode($retornar);
}

function post_Cliente_Mantenimiento_Nuevo() {
    require ROOT_PATH . 'models/cliente.php';
    require ROOT_PATH . 'models/cliente_contacto.php';
    require ROOT_PATH . 'models/forma_pago.php';
    require ROOT_PATH . 'models/estado.php';
    require ROOT_PATH . 'models/departamento.php';
    require ROOT_PATH . 'models/provincia.php';
    require ROOT_PATH . 'models/distrito.php';
    require ROOT_PATH . 'models/credito.php';
    require ROOT_PATH . 'models/persona.php';
    require ROOT_PATH . 'models/operador_cliente.php';
    require ROOT_PATH . 'models/operador.php';
    global $returnView_float;
    $returnView_float = true;
    $oCliente = new cliente();
    $ruc = $_POST['txtRuc'];
    $razon_social = trim($_POST['txtRazon_Social']);
    $direccion_fiscal = trim($_POST['txtDireccion_Fiscal']);
    $nombre_comercial = trim($_POST['txtNombre_Comercial']);
    $estado_ID=$_POST['selEstado'];
    $telefono = trim($_POST['txtTelefono']);
    $celular = trim($_POST['txtCelular']);
    $correo=trim($_POST['txtCorreo']);
    $departamento_ID=$_POST['selDepartamento'];
    $provincia_ID=$_POST['selProvincia'];
    $distrito_ID=$_POST['selDistrito'];
    $direccion=trim($_POST['txtDireccion']);
    $forma_pago_ID=$_POST['selForma_Pago'];
    $tiempo_credito=(trim($_POST['txtTiempo_Credito'])=="")?0:trim($_POST['txtTiempo_Credito']);
    $descuento=(trim($_POST['txtDescuento'])=="")?0:trim($_POST['txtDescuento']);
    $banco=trim($_POST['txtBanco']);
    $numero_cuenta_soles = $_POST['txtNumero_Cuenta_Soles'];
    $numero_cuenta_dolares = $_POST['txtNumero_Cuenta_Dolares'];
    $operador_ID=$_POST['selOperador'];
    if(isset($_POST['txtPersona_ID'])&&trim($_POST['txtPersona_ID'])!=""&&$_POST['txtPersona_ID']!=0){
        $persona_ID=$_POST['txtPersona_ID'];
        $cargo=trim($_POST['txtCargo']);
        
        $telefono1 = trim($_POST['txtTelefono1']);
        $celular1 = trim($_POST['txtCelular1']);
        $correo1=trim($_POST['txtCorreo1']);
        $estado_ID1=$_POST['selEstado1'];
    }
    $oCliente=new cliente();
    $oCliente_Contacto=new cliente_contacto();
    try {
        $oCliente->empresa_ID=$_SESSION['empresa_ID'];
        $oCliente->codigo=$oCliente->getCodigo();
        $oCliente->razon_social = $razon_social;
        $oCliente->nombre_comercial = $nombre_comercial;
        $oCliente->ruc = $ruc;
        $oCliente->direccion = $direccion;
        $oCliente->direccion_fiscal = $direccion_fiscal;
        $oCliente->distrito_ID = $distrito_ID;
        $oCliente->telefono = $telefono;
        $oCliente->celular = $celular;
        $oCliente->correo = $correo;
        $oCliente->forma_pago_ID = $forma_pago_ID;
        $oCliente->banco = $banco;
        $oCliente->numero_cuenta_soles = $numero_cuenta_soles;
        $oCliente->numero_cuenta_dolares = $numero_cuenta_dolares;
        $oCliente->estado_ID = $estado_ID;
        $oCliente->descuento = $descuento;
        $oCliente->tiempo_credito = $tiempo_credito;
        $oCliente->tipo_documento_ID=6;
        $oCliente->usuario_id = $_SESSION['usuario_ID'];
        $oCliente->usuario_mod_id = $_SESSION['usuario_ID'];
        
        $retorna = $oCliente->insertar1();

        if ($retorna==-2) {
                $resultado=-1;
                $mensaje="Ya existe un cliente con la misma razon social..";
                
        }else{
            if ($retorna==-3)
             {
                $resultado=-1;
                $mensaje="Ya existe un cliente con el mismo ruc..";
                
             }else{                 
                 if($operador_ID>0){
                    $oPerador_Cliente=new operador_cliente();
                    $oPerador_Cliente->cliente_ID=$retorna;
                    $oPerador_Cliente->operador_ID=$operador_ID;
                    $oPerador_Cliente->estado_ID=74;//Estado activo//75 inactivo
                    $oPerador_Cliente->usuario_id=$_SESSION['usuario_ID'];
                    $oPerador_Cliente->empresa_ID=$_SESSION['empresa_ID'];
                    $oPerador_Cliente->insertar();
                 }
                if(isset($_POST['txtPersona_ID'])&&trim($_POST['txtPersona_ID'])!=""&&$_POST['txtPersona_ID']!=0){
                    if($oCliente->ID>0){
                        $oCliente_Contacto->persona_ID=$persona_ID;
                        $oCliente_Contacto->codigo=$oCliente_Contacto->getCodigo();
                        $oCliente_Contacto->cliente_ID=$oCliente->ID;
                        $oCliente_Contacto->cargo=$cargo;

                        $oCliente_Contacto->telefono=$telefono1;
                        $oCliente_Contacto->celular=$celular1;
                        $oCliente_Contacto->correo=$correo1;
                        $oCliente_Contacto->estado_ID=$estado_ID1;
                        $oCliente_Contacto->usuario_id=$_SESSION['usuario_ID'];
                        if($oCliente_Contacto->verificarDuplicado>0){
                            throw new Exception($oCliente_Contacto->getMessage);
                        }
                        $oCliente_Contacto->insertar();
                        $resultado= 1;
                        $mensaje=$oCliente_Contacto->getMessage; 
                    }
                }else{
                    $resultado=1;
                    $mensaje=$oCliente->getMessage;  
                }
       
             }
        }
    } catch (Exception $ex) {
        $resultado= -1;
        $mensaje = utf8_encode(mensaje_error);
        log_error(__FILE__, "mantenimiento/post_cliente_mantenimiento_nuevo", $ex->getMessage());
    }
	$oCliente->dtDepartamento=departamento::getGrid("",-1,-1,"nombre asc");
        $oCliente->dtProvincia=provincia::getGrid("departamento_ID=".$departamento_ID,-1,-1,"nombre asc");
        $oCliente->dtDistrito=distrito::getGrid("provincia_ID=".$provincia_ID,-1,-1,"nombre asc");
        $oCliente->dtEstado=estado::getGrid("est.tabla='cliente'",-1,-1,"est.orden asc");
        $oCliente->departamento_ID=$departamento_ID;
        $oCliente->provincia_ID=$provincia_ID;
        $oCliente_Contacto->dtEstado=estado::getGrid("est.tabla='cliente_contacto'",-1,-1,"est.orden asc");
        $oCliente->dtForma_Pago = forma_pago::getGrid();
        $oCliente->dtCredito = credito::getGrid();
	$dtOperador=operador::getGrid("",-1,-1,"pe.apellido_paterno asc,pe.apellido_materno asc,pe.nombres asc");
        $GLOBALS['oCliente'] = $oCliente;
        $GLOBALS['oCliente_Contacto'] = $oCliente_Contacto;
        $GLOBALS['dtOperador'] = $dtOperador;
        $GLOBALS['resultado'] = $resultado;
        $GLOBALS['mensaje'] = $mensaje;
}

//muestra la ventana editar Cliente
function get_Cliente_Mantenimiento_Editar($id) {
    require ROOT_PATH . 'models/cliente.php';
    require ROOT_PATH . 'models/cliente_contacto.php';
    require ROOT_PATH . 'models/forma_pago.php';
    require ROOT_PATH . 'models/estado.php';
    require ROOT_PATH . 'models/departamento.php';
    require ROOT_PATH . 'models/provincia.php';
    require ROOT_PATH . 'models/distrito.php';
    require ROOT_PATH . 'models/credito.php';
    require ROOT_PATH . 'models/operador_cliente.php';
    require ROOT_PATH . 'models/operador.php';
    
    global $returnView_float;
    $returnView_float = true;
    $oCliente = cliente::getByID($id);
    if($oCliente==null){
        $GLOBALS['resultado'] = -2;
        $GLOBALS['mensaje'] = "El cliente ha sido eliminado por otro usuario.";
        return;
    }
    $oDistrito=distrito::getByID($oCliente->distrito_ID);
    $oProvincia=provincia::getByID($oDistrito->provincia_ID);
    $oCliente->departamento_ID=$oProvincia->departamento_ID;
    $oCliente->provincia_ID=$oProvincia->ID;
    $Ope=operador_cliente::getByOperador($id);
    $operador_ID=(isset($Ope))?$Ope->operador_ID:0;
    $oCliente->operador_ID=$operador_ID;
    $oCliente->dtDepartamento=departamento::getGrid("",-1,-1,"nombre asc");
    $oCliente->dtProvincia=provincia::getGrid("departamento_ID=".$oProvincia->departamento_ID,-1,-1,"nombre asc");;
    $oCliente->dtDistrito=distrito::getGrid("provincia_ID=".$oDistrito->provincia_ID,-1,-1,"nombre asc");
    $oCliente->dtEstado=estado::getGrid("est.tabla='cliente'",-1,-1,"est.orden asc");
    $oCliente_Contacto=new cliente_contacto();
    $oCliente_Contacto->dtEstado=estado::getGrid("est.tabla='cliente_contacto'",-1,-1,"est.orden asc");
    
    $oCliente->dtForma_Pago = forma_pago::getGrid();
    $oCliente->dtCredito = credito::getGrid();
    $dtOperador=operador::getGrid("",-1,-1,"pe.apellido_paterno asc,pe.apellido_materno asc,pe.nombres asc");
    $GLOBALS['oCliente'] = $oCliente;
    $GLOBALS['oCliente_Contacto'] = $oCliente_Contacto;
    $GLOBALS['dtOperador'] = $dtOperador;
}
function post_Cliente_Mantenimiento_Editar($id) {
    require ROOT_PATH . 'models/cliente.php';
    require ROOT_PATH . 'models/cliente_contacto.php';
    require ROOT_PATH . 'models/forma_pago.php';
    require ROOT_PATH . 'models/estado.php';
    require ROOT_PATH . 'models/departamento.php';
    require ROOT_PATH . 'models/provincia.php';
    require ROOT_PATH . 'models/distrito.php';
    require ROOT_PATH . 'models/credito.php';
    require ROOT_PATH . 'models/persona.php';
    require ROOT_PATH . 'models/operador.php';
    require ROOT_PATH . 'models/operador_cliente.php';
    global $returnView_float;
    $returnView_float = true;
	
	$oCliente = cliente::getByID($id);
    if($oCliente==null){
        $GLOBALS['resultado'] = -2;
        $GLOBALS['mensaje'] = "El cliente ha sido eliminado por otro usuario.";
        return;
    }
   
    $ruc = $_POST['txtRuc'];
    $razon_social = test_input($_POST['txtRazon_Social']);
    $direccion_fiscal = test_input($_POST['txtDireccion_Fiscal']);
    $nombre_comercial = test_input($_POST['txtNombre_Comercial']);
    $estado_ID=$_POST['selEstado'];
    $telefono = trim($_POST['txtTelefono']);
    $celular = trim($_POST['txtCelular']);
    $correo=trim($_POST['txtCorreo']);
    $departamento_ID=$_POST['selDepartamento'];
    $provincia_ID=$_POST['selProvincia'];
    $distrito_ID=$_POST['selDistrito'];
    $direccion=trim($_POST['txtDireccion']);
    $forma_pago_ID=$_POST['selForma_Pago'];
    $tiempo_credito=(trim($_POST['txtTiempo_Credito'])=="")?0:trim($_POST['txtTiempo_Credito']);
    $descuento=(trim($_POST['txtDescuento'])=="")?0:trim($_POST['txtDescuento']);
    $banco=trim($_POST['txtBanco']);
    $numero_cuenta_soles = $_POST['txtNumero_Cuenta_Soles'];
    $numero_cuenta_dolares = $_POST['txtNumero_Cuenta_Dolares'];
    $operador_ID=$_POST['selOperador'];
    
    if(isset($_POST['txtPersona_ID'])&&trim($_POST['txtPersona_ID'])!=""&&$_POST['txtPersona_ID']!=0){
        $persona_ID=$_POST['txtPersona_ID'];
        $cargo=trim($_POST['txtCargo']);
        //$direccion1=FormatTextSave(strtoupper($_POST['txtDireccion1']));
        $telefono1 = trim($_POST['txtTelefono1']);
        $celular1 = trim($_POST['txtCelular1']);
        $correo1=trim($_POST['txtCorreo1']);
        $estado_ID1=$_POST['selEstado1'];
    }

    $oCliente_Contacto=new cliente_contacto();
    try {
        //$oCliente->empresa_ID=$_SESSION['empresa_ID'];
        //$oCliente->codigo=$oCliente->getCodigo();
        $oCliente->razon_social = $razon_social;
        $oCliente->nombre_comercial = $nombre_comercial;
        $oCliente->ruc = $ruc;
        $oCliente->direccion = $direccion;
        $oCliente->direccion_fiscal = $direccion_fiscal;
        $oCliente->distrito_ID = $distrito_ID;
        $oCliente->telefono = $telefono;
        $oCliente->celular = $celular;
        $oCliente->correo = $correo;
        $oCliente->forma_pago_ID = $forma_pago_ID;
        $oCliente->banco = $banco;
        $oCliente->numero_cuenta_soles = $numero_cuenta_soles;
        $oCliente->numero_cuenta_dolares = $numero_cuenta_dolares;
        $oCliente->estado_ID = $estado_ID;
        $oCliente->descuento = $descuento;
        $oCliente->tiempo_credito = $tiempo_credito;
        $oCliente->tipo_documento_ID=6;
        $oCliente->usuario_mod_id = $_SESSION['usuario_ID'];
        
        $retorna = $oCliente->actualizar1();
        
        if ($retorna==-2) {
            $resultado= -1;
            $mensaje="Ya existe un cliente con la misma razon social..";
            
        }else{
            if ($retorna==-3)
             {
                $resultado= -1;
                $mensaje="Ya existe un cliente con el mismo ruc..";
            
             }else{  
                 if($operador_ID>0){
                        $operador_cliente=operador_cliente::getByOperador($id);
                        if(isset($operador_cliente)){
                            $operador_cliente=new operador_cliente();
                            $operador_cliente->estado_ID=74;
                            $operador_cliente->operador_ID=$operador_ID;
                            $operador_cliente->insertar();
                        }else{
                            
                          
                            $operador_cliente->operador_ID=$operador_ID;
                            $operador_cliente->actualizar();
                        }    
                 }else{
                     $operador_cliente=operador_cliente::getByOperador($id);
                     if(isset($operador_cliente)){
                        $operador_cliente->eliminar(); 
                     }
                 }
                if(isset($_POST['txtPersona_ID'])&&trim($_POST['txtPersona_ID'])!=""&&$_POST['txtPersona_ID']!=0){
                    if($oCliente->ID>0){
                        $oCliente_Contacto->persona_ID=$persona_ID;
                        $oCliente_Contacto->codigo=$oCliente_Contacto->getCodigo();
                        $oCliente_Contacto->cliente_ID=$oCliente->ID;
                        $oCliente_Contacto->cargo=$cargo;

                        $oCliente_Contacto->telefono=$telefono1;
                        $oCliente_Contacto->celular=$celular1;
                        $oCliente_Contacto->correo=$correo1;
                        $oCliente_Contacto->estado_ID=$estado_ID1;
                        $oCliente_Contacto->usuario_id=$_SESSION['usuario_ID'];
                        if($oCliente_Contacto->verificarDuplicado()>0){
                            throw new Exception($oCliente_Contacto->getMessage);
                        }
                        $oCliente_Contacto->insertar();
                        $resultado= 1;
                        $mensaje=$oCliente_Contacto->getMessage; 
                    }
                }else{
                    $resultado=1;
                    $mensaje="Se actualizó correctamente";  
                    }
                 
             }
             
        }


    } catch (Exception $ex) {
        $resultado= -1;
        $mensaje = utf8_encode(mensaje_error);
        log_error(__FILE__, "mantenimiento/post_cliente_mantenimiento_editar", $ex->getMessage());
    }
	$oCliente->dtDepartamento=departamento::getGrid("",-1,-1,"nombre asc");
        $oCliente->dtProvincia=provincia::getGrid("departamento_ID=".$departamento_ID,-1,-1,"nombre asc");
        $oCliente->dtDistrito=distrito::getGrid("provincia_ID=".$provincia_ID,-1,-1,"nombre asc");
        $oCliente->dtEstado=estado::getGrid("est.tabla='cliente'",-1,-1,"est.orden asc");
        $oCliente->departamento_ID=$departamento_ID;
        $oCliente->provincia_ID=$provincia_ID;
        $oCliente_Contacto->dtEstado=estado::getGrid("est.tabla='cliente_contacto'",-1,-1,"est.orden asc");
        $oCliente->dtForma_Pago = forma_pago::getGrid();
        $oCliente->dtCredito = credito::getGrid();
	
        $GLOBALS['oCliente'] = $oCliente;
        $GLOBALS['oCliente_Contacto'] = $oCliente_Contacto;
        $GLOBALS['resultado'] = $resultado;
        $GLOBALS['mensaje'] = $mensaje;
}
function post_ajaxMostar_Lista_Contacto_Cliente() {
    
    require ROOT_PATH . 'models/cliente_contacto.php';
    $cliente_ID=$_POST['id'];
    $resultado='<table class="table table-striped"><thead><tr>';
    $resultado.='<th>Persona</th><th>Cargo</th><th>Teléfono</th><th>Celular</th><th>Correo</th><th>Estado</th><th>Opciones</th>';
    $resultado.='</thead></tr>';
    $resultado.='<tbody>';
    try {
        
        $dtCliente_Contacto=cliente_contacto::getGrid("clic.cliente_ID=".$cliente_ID);
        foreach($dtCliente_Contacto as $item){
            $resultado.='<tr id="'.$item['ID'].'">';
            $resultado.='<td>'.test_input($item['apellido_paterno'].' '.$item['apellido_materno'].', '.$item['nombres']).'</td>';
            $resultado.='<td>'.test_input($item['cargo']).'</td>';
            $resultado.='<td>'.test_input($item['telefono']).'</td>';
            $resultado.='<td>'.test_input($item['celular']).'</td>';
            $resultado.='<td>'.test_input($item['correo']).'</td>';
            $resultado.='<td>'.test_input($item['estado']).'<input id="txt'.$item['ID'].'" value="'.$item['persona_ID'].'" style="display:none;"><input id="est'.$item['ID'].'" value="'.$item['estado_ID'].'" style="display:none;"></td>';
            $botones=array();
            array_push($botones,'<a onclick="fncEditar(' . $item['ID'] . ');" ><span class="glyphicon glyphicon-pencil" title="Editar Contacto">Editar</a>');
            array_push($botones,'<a onclick="modal.confirmacion(&#39;El proceso es irreversible, esta seguro de eliminar el registro.&#39;,&#39;Eliminar Contacto&#39;,fncEliminar,&#39;' . $item['ID'] . '&#39;);" title="Eliminar chofer"><span class="glyphicon glyphicon-trash">Eliminar</a>');
            $resultado.='<td class="btnAction" >'.extraerOpcion($botones)."</td>";
            $resultado.='</tr>';
        }
        
    }catch(Exception $ex){
        $resultado.='<tr><td claspan="6">'.$ex->getMessage().'</td></tr>';
        
    }
    $resultado.='</tbody>';
    $resultado.='</table>';
    $retornar = Array('resultado' => $resultado);
    //$retorn="<h1>Hola</h1>";

    echo json_encode($retornar);
}
function post_ajaxAccionCliente_Contacto() {
    require ROOT_PATH . 'models/cliente_contacto.php';
    $ID=$_POST['txtID'];
    $cliente_ID=$_POST['txtcliente_ID'];
    if(isset($_POST['txtPersona_ID'])){
        $persona_ID=$_POST['txtPersona_ID'];
        $telefono1 = test_input($_POST['txtTelefono1']);
        $celular1 = $_POST['txtCelular1'];
        $correo1=test_input($_POST['txtCorreo1']);
        $cargo=test_input($_POST['txtCargo']);
        $estado_ID1=$_POST['selEstado1'];
    }
    try {
        
        
        if($ID==0){
            $oCliente_Contacto=new cliente_contacto();
            $oCliente_Contacto->codigo=$oCliente_Contacto->getCodigo();
            $oCliente_Contacto->cargo=$cargo;
            $oCliente_Contacto->persona_ID=$persona_ID;
            $oCliente_Contacto->telefono=$telefono1;
            $oCliente_Contacto->celular=$celular1;
            $oCliente_Contacto->correo=$correo1;
            $oCliente_Contacto->estado_ID=$estado_ID1;
            $oCliente_Contacto->cliente_ID=$cliente_ID;
            $oCliente_Contacto->usuario_id=$_SESSION['usuario_ID'];
            /*if($oCliente_Contacto->verificarDuplicado>0){
                    throw new Exception($oCliente_Contacto->getMessage);
                }*/
            $retorna=$oCliente_Contacto->insertar1();
        }else{
            $oCliente_Contacto=cliente_contacto::getByID($ID);
            //print_r($oCliente_Contacto);
            $oCliente_Contacto->persona_ID=$persona_ID;
            $oCliente_Contacto->cargo=$cargo;
            $oCliente_Contacto->telefono=$telefono1;
            $oCliente_Contacto->celular=$celular1;
            $oCliente_Contacto->correo=$correo1;
            $oCliente_Contacto->estado_ID=$estado_ID1;
            
            if($oCliente_Contacto==null){
                throw new Exception("No existe el registro.");
            }
            /*if($oCliente_Contacto->verificarDuplicado>0){
                throw new Exception($oCliente_Contacto->getMessage);
            }*/
            $oCliente_Contacto->usuario_mod_id=$_SESSION['usuario_ID'];
            //echo "deded";
            $retorna = $oCliente_Contacto->actualizar1();
            //echo "deded".$retorna;
            
            
        }
        if($retorna==-2){
                $mensaje="La persona ya existe.";
                $resultado=-1;
            }
            if($retorna==0){
                $mensaje="No se actualizó ningún registro.";
                $resultado=-1;
            }
            if($retorna>0){
                $mensaje="Se actualizó correctamente";
                $resultado=1;
            }
        //$mensaje=$oCliente_Contacto->getMessage;
        //$resultado=1;
    }catch(Exception $ex){
        $resultado=-1;
        $mensaje=$ex->getMessage();
    }
    $retornar = Array('resultado' => $resultado,'mensaje'=>$mensaje);
    echo json_encode($retornar);
}
//muestra la grilla cargada con datos de Cliente,trabaja con ajax
function post_ajaxCliente_Mantenimiento() {
    require ROOT_PATH . 'models/cliente.php';
    require ROOT_PATH . 'controls/funcionController.php';
    $ruc= trim($_POST['txtRUC']);
    $razon_social = test_input($_POST['txtRazon_Social']);
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
            $orden = 'clt.ID ' . $orden_tipo;
            break;
        case 1:
            $orden = 'clt.ruc ' . $orden_tipo;
            break;
        case 2:
            $orden = 'clt.razon_social ' . $orden_tipo;
            break;
        case 3:
            $orden = 'clt.direccion ' . $orden_tipo;
            break;
        case 4:
            $orden = 'clt.telefono ' . $orden_tipo;
            break;
        case 5:
            $orden = 'clt.celular ' . $orden_tipo;
            break;
        case 6:
            $orden = 'clt.correo ' . $orden_tipo;
            break;
        default:
            $orden = 'clt.ID ' . $orden_tipo;
            break;
    }
    if($ruc!=""){
        $filtro='clt.empresa_ID='.$_SESSION['empresa_ID'].' and clt.ruc="'.$ruc.'"';
    }else{
       $filtro = 'clt.empresa_ID='.$_SESSION['empresa_ID'].' and upper(clt.razon_social) like "%' . strtoupper($razon_social) . '%"';
    }
    //---------------------------------------					 
    $resultado = '<table id="websendeos" class="grid table table-hover table-bordered"><thead><tr>';
    $resultado.='<th class="text-center">N°</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(1);">R.u.c.' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(2);">Razon social' . (($txtOrden == 2 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(3);">Dirección' . (($txtOrden == 3 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(4);">Teléfono' . (($txtOrden == 4 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(5);">Celular' . (($txtOrden == 5 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(6);">Correo' . (($txtOrden == 6 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th>Opciones</th>';
    $resultado.='</tr></thead>';
    $resultado.='<tbody>';
    $colspanFooter = 9;
    try {
        $cantidadMaxima = cliente::getCount($filtro);
        $dtCliente = cliente::getGrid($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
        $rows = count($dtCliente);
        $i=($paginaActual-1)*$cantidadMostrar+1;
        foreach ($dtCliente as $item) {
            $resultado.='<tr class="tr-item">';
            $resultado.='<td class="text-center">'.$i.'</td>';
            $resultado.='<td class="text-center">' . $item['ruc'] . '</td>';
            $resultado.='<td class="tdLeft">' . test_input($item['razon_social']) . '</td>';
            $resultado.='<td class="tdLeft">' . test_input($item['direccion']) . '</td>';
            $resultado.='<td class="tdLeft">' . test_input($item['telefono']) . '</td>';
            $resultado.='<td class="tdLeft">' . test_input($item['celular']) . '</td>';
            $resultado.='<td class="tdLeft">' . test_input($item['correo']) . '</td>';
            $botones=array();
            array_push($botones,'<a onclick="fncEditar(' . $item['ID'] . ');" ><span class="glyphicon glyphicon-pencil" title="Editar Proveedor">Editar</a>');
            array_push($botones,'<a onclick="modal.confirmacion(&#39;El proceso es irreversible, esta seguro de eliminar el registro.&#39;,&#39;Eliminar Proveedor&#39;,fncEliminar,&#39;' . $item['ID'] . '&#39;);" title="Eliminar Proveedor"><span class="glyphicon glyphicon-trash">Eliminar</a>');
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

//eliminar Cliente
function post_ajaxCliente_Mantenimiento_Eliminar($id) {
    require ROOT_PATH . 'models/cliente.php';
    require ROOT_PATH . 'models/cliente_contacto.php';

    try {
        $oCliente = cliente::getByID($id);
        $oCliente->usuario_mod_id = $_SESSION['usuario_ID'];
        if ($oCliente == null) {
            throw new Exception('Parece que el registro ya fue eliminado.');
        }
		
		
        $oCliente_Contacto=new cliente_contacto();
        $contarHijos=$oCliente_Contacto->verificarHijos($id);
          if($contarHijos==0){
            if ($oCliente->eliminar() == -1) {
            throw new Exception($oCliente->getMessage);
            $mensaje = $oCliente->getMessage;
            }else{$mensaje="Se eliminó correctamente";
                $resultado = 1;
            }
        } else {
            $mensaje="No se puede eliminar al cliente, tiene representante de cliente asignados.";
             $resultado = 2;
        }
        $funcion = '';
    } catch (Exception $ex) {
        $resultado = -1;
        $mensaje = $ex->getMessage();
        $funcion = '';
    }

    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje, 'funcion' => $funcion);

    echo json_encode($retornar);
}




function post_ajaxCliente_Mantenimiento_Contacto_Eliminar()
    {
        require ROOT_PATH . 'models/cliente.php';
	require ROOT_PATH . 'models/cliente_contacto.php';

        try{
            $id=$_POST['id'];
            $oCliente_Contacto= cliente_contacto::getByID($id);
            $oCliente_Contacto->usuario_mod_id=$_SESSION['usuario_ID'];
            
            if($oCliente_Contacto==null){
                throw new Exception('Parece que el registro ya fue eliminado.');
            }
            $oCliente= cliente::getByID($oCliente_Contacto->cliente_ID);
            if($oCliente==null){
                throw new Exception('El cliente ha sido eliminado por otro usuario.');
            }
            $varEliminar=$oCliente_Contacto->eliminar();
            if($varEliminar==-1){
                throw new Exception($oCliente_Contacto->getMessage);
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



    
    function post_ajaxCbo_ClienteRuc(){
    require ROOT_PATH.'models/cliente.php';
    $buscar=$_POST['txtBuscar'];
    if(trim($buscar)!=""){
        $filtro='clt.ruc like "%'.test_input($buscar).'%"';
    }else{
        $filtro='clt.ID=0';
    }

    $dtCliente=cliente::getGrid($filtro);

    $i=1;
    $resultado='<ul class="cbo-ul">';
    if(count($dtCliente)>0){			
        foreach($dtCliente as $iCliente){
            $resultado.='<li id="li_'.$i.'" onclick="subirValorCaja(&#39;'.$iCliente['ruc'].'&#39;,1);"><span>'.$iCliente['ruc'].'</span></li>';
            $i++;
        }
    }
    $resultado.='</ul>';

    $mensaje='';
    $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);
    echo json_encode($retornar);
}
    
    
function post_ajaxCbo_ClienteRazonSocial(){
    require ROOT_PATH.'models/cliente.php';
    $buscar=$_POST['txtBuscar'];
    if(trim($buscar)!=""){
        $filtro='clt.razon_social like "%'.test_input($buscar).'%"';
    }else{
        $filtro='clt.ID=0';
    }

    $dtCliente=cliente::getGrid($filtro);

    $i=1;
    $resultado='<ul class="cbo-ul">';
    if(count($dtCliente)>0){			
        foreach($dtCliente as $iCliente){
            $resultado.='<li id="li_'.$i.'" onclick="subirValorCaja(&#39;'.test_input($iCliente['razon_social']).'&#39;,2);"><span>'.test_input($iCliente['razon_social']).'</span></li>';
            $i++;
        }
    }
    $resultado.='</ul>';

    $mensaje='';
    $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);
    echo json_encode($retornar);
}    


//fin mantenimiento Cliente
//----------------------------------------------------------------------------------------
//inicio mantenimiento estado

function get_Estado_Mantenimiento() {
    global $returnView;
    $returnView = true;
}

//muestra la ventana para agregar nuevo estado
function get_Estado_Mantenimiento_Nuevo() {
    require ROOT_PATH . 'models/estado.php';
    global $returnView_float;
    $returnView_float = true;
    $oEstado = new estado();

    $GLOBALS['oEstado'] = $oEstado;
    $GLOBALS['mensaje'] = '';
}

//graba los datos que se recuperan por el metodo post en nuevo Estado
function post_Estado_Mantenimiento_Nuevo() {
    require ROOT_PATH . 'models/estado.php';
    global $returnView_float;
    $returnView_float = true;

    $nombre = $_POST['txtNombre'];
    $tabla = $_POST['txtTabla'];

    $oEstado = new estado;

    try {
        $oEstado->nombre = $nombre;
        $oEstado->tabla = $tabla;

        $oEstado->usuario_id = $_SESSION['usuario_ID'];
        $oEstado->fdc = "";
        $oEstado->del = "0";

        $oEstado->insertar();
        $GLOBALS['resultado'] = 1;
        $GLOBALS['mensaje'] = $oEstado->message;
    } catch (Exception $ex) {
        $GLOBALS['resultado'] = -1;
        $GLOBALS['mensaje'] = $ex->getMessage();
    }
    $GLOBALS['oEstado'] = $oEstado;
}

//muestra la grilla cargada con datos de estado,trabaja con ajax
function post_ajaxEstado_Mantenimiento() {
    require ROOT_PATH . 'models/estado.php';
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
            $orden = 'est.nombre ' . $orden_tipo;
            break;
        case 2:
            $orden = 'est.tabla ' . $orden_tipo;
            break;
        default:
            $orden = 'est.ID ' . $orden_tipo;
            break;
    }
    $filtro = 'upper(concat(est.tabla," ",est.nombre)) like "%' . str_replace(' ', '%', strtoupper(FormatTextSave($buscar))) . '%"';

    //---------------------------------------					 
    $resultado = '<table class="grid"><tr>';
    $resultado.='<th colspan="2"></th>';
    $resultado.='<th style="width:80px;" class="thOrden" onclick="fncOrden(1);">Nombre' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th style="width:400px;" class="thOrden" onclick="fncOrden(2);">tabla' . (($txtOrden == 2 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th ></th>';
    $resultado.='</tr>';

    $colspanFooter = 5;
    try {
        $cantidadMaxima = estado::getCount($filtro);
        $dtEstado = estado::getGrid($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
        $rows = count($dtEstado);

        foreach ($dtEstado as $item) {
            $resultado.='<tr class="tr-item">';
            $resultado.='<td class="btnAction"><img title="Editar" src="/include/img/boton/edit_14x14.png" />&nbsp;<a onclick="fncEditar(' . $item['ID'] . ');">Editar</a></td>';
            $resultado.='<td class="btnAction"><img title="Eliminar" src="/include/img/boton/delete_14x14.png" />&nbsp;<a onclick="fncEliminar(' . $item['ID'] . ');">Eliminar</a></td>';
            $resultado.='<td class="tdCenter">' . FormatTextViewHtml($item['nombre']) . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextViewHtml($item['tabla']) . '</td>';
            $resultado.='<td></td>';
            $resultado.='</tr>';
        }

        $cantidadPaginas = '';


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

            $resultado.='<div  id=1 class="pagination pagination-ini" ><a title="Primero"><<</a></div>';
            $resultado.='<div id="' . ($paginaActual > 1 ? $paginaActual - 1 : $paginaActual) . '" class="pagination pagination-prev" ><a title="Anterior"><</a></div>';

            for ($i = $paginaInicio; $i <= $paginaFin; $i++) {
                if ($i == $paginaActual) {
                    $resultado.='<div class="pagination">' . $i . '</div>';
                } else {
                    $resultado.='<div id="' . $i . '" class="pagination"><a>' . $i . '</a></div>';
                }
            }

            $resultado.='<div id="' . ($paginaActual < $cantidadPaginas ? $paginaActual + 1 : $paginaActual) . '" class="pagination pagination-next" ><a title="Siguiente">></a></div>';
            $resultado.='<div id="' . $cantidadPaginas . '" class="pagination pagination-end" ><a title="Último">>></a></div>';

            $resultado.='</td></tr>';
        }

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

//fin mantenimiento estado
//----------------------------------------------------------------------------------------
//inicio mantenimiento chofer
function get_Chofer_Mantenimiento() {
    global $returnView;
    $returnView = true;
}

//muestra la ventana para agregar nuevo chofer
function get_Chofer_Mantenimiento_Nuevo() {
    require ROOT_PATH . 'models/chofer.php';
    require ROOT_PATH . 'models/estado.php';
    require ROOT_PATH . 'models/persona.php';
    global $returnView_float;
    $returnView_float = true;
    $oChofer = new chofer;
    
    $dtEstado=estado::getGrid('est.tabla="chofer"',-1,-1,"est.nombre");
    $dtPersona = persona::getGrid('',-1,-1,'apellido_paterno,apellido_materno,nombres');
    $oChofer->dtEstado=$dtEstado;
    $GLOBALS['oChofer'] = $oChofer;
    $GLOBALS['dtPersona'] = $dtPersona;
    $GLOBALS['mensaje'] = '';
}

//graba los datos que se recuperan por el metodo post en nuevo Chofer
function post_Chofer_Mantenimiento_Nuevo() {
    require ROOT_PATH . 'models/chofer.php';
    require ROOT_PATH . 'models/estado.php';
    global $returnView_float;
    $returnView_float = true;
    $persona_ID=$_POST['selPersona'];
    $licencia_conducir = trim($_POST['txtLicencia_Conducir']);
    $celular = trim($_POST['txtCelular']);
    $estado_ID = $_POST['selEstado_ID'];

    $oChofer = new chofer;

    try {
        $oChofer->persona_ID =$persona_ID;
        $oChofer->empresa_ID = $_SESSION['empresa_ID'];
        $oChofer->licencia_conducir = $licencia_conducir;
        $oChofer->celular = $celular;
        $oChofer->estado_ID = $estado_ID;
        $oChofer->usuario_id = $_SESSION['usuario_ID'];
        if ($oChofer->verificarDuplicado() > 0) {
            throw new Exception($oChofer->getMessage);
        }
        $oChofer->insertar();
        $GLOBALS['resultado'] = 1;
        $GLOBALS['mensaje'] = $oChofer->getMessage;
    } catch (Exception $ex) {
        $GLOBALS['resultado'] = -1;
        $GLOBALS['mensaje'] = $ex->getMessage();
    }
    $dtEstado=estado::getGrid('est.tabla="chofer"',-1,-1,"est.nombre");
    $oChofer->dtEstado=$dtEstado;
    $GLOBALS['oChofer'] = $oChofer;
}

//muestra la ventana editar Chofer
function get_Chofer_Mantenimiento_Editar($id) {
    require ROOT_PATH . 'models/chofer.php';
    require ROOT_PATH . 'models/estado.php';
    require ROOT_PATH . 'models/persona.php';
    global $returnView_float;
    $returnView_float = true;
    $oChofer = chofer::getByID($id);
    if ($oChofer == null) {
        $GLOBALS['resultado'] = -2;
        $GLOBALS['mensaje'] = "El chofer ha sido eliminado por otro usuario.";
        return;
        
    }
    $dtPersona=persona::getGrid('',-1,-1,'apellido_paterno,apellido_materno,nombres');
    $dtEstado=estado::getGrid('est.tabla="chofer"',-1,-1,"est.nombre");
    $oChofer->nombres=$dtPersona[0]['datos'];
    $oChofer->dtEstado=$dtEstado;

    $GLOBALS['oChofer'] = $oChofer;
    $GLOBALS['dtPersona'] = $dtPersona;
    
}

//graba los datos que se recuperan por el metodo post en editar Chofer
function post_Chofer_Mantenimiento_Editar($id) {
    require ROOT_PATH . 'models/chofer.php';
    require ROOT_PATH . 'models/estado.php';
    require ROOT_PATH . 'models/persona.php';
    global $returnView_float;
    $returnView_float = true;
    $oChofer = chofer::getByID($id);

    if ($oChofer == null) {
        $GLOBALS['resultado'] = -2;
        $GLOBALS['mensaje'] = "El chofer ha sido eliminado por otro usuario.";
        return;
        
    }
    $persona_ID=$_POST['selPersona'];
    $licencia_conducir = FormatTextSave(strtoupper($_POST['txtLicencia_Conducir']));
    $celular = FormatTextSave($_POST['txtCelular']);
    $estado_ID = $_POST['selEstado_ID'];
    try {
        $oChofer->persona_ID =$persona_ID;
        $oChofer->licencia_conducir = $licencia_conducir;
        $oChofer->celular = $celular;
        $oChofer->estado_ID = $estado_ID;
        $oChofer->usuario_mod_id = $_SESSION['usuario_ID'];
        if($oChofer->verificarDuplicado() > 0){
           throw new Exception($oChofer->getMessage); 
            
        }
        $oChofer->actualizar();
        $GLOBALS['mensaje'] = $oChofer->getMessage;
        $GLOBALS['resultado'] = 1;
    } catch (Exception $ex) {
        $GLOBALS['resultado'] = -1;
        $GLOBALS['mensaje'] = $ex->getMessage();
    }
    $dtPersona=persona::getGrid("ID=".$oChofer->persona_ID);
    $oChofer->nombres=$dtPersona[0]['datos'];
    $dtEstado=estado::getGrid('est.tabla="chofer"',-1,-1,"est.nombre");
    $oChofer->dtEstado=$dtEstado;
    $GLOBALS['oChofer'] = $oChofer;
}

//muestra la grilla cargada con datos de proveedor,trabaja con ajax
function post_ajaxChofer_Mantenimiento() {
    require ROOT_PATH . 'models/chofer.php';
    require ROOT_PATH . 'controls/funcionController.php';
    $buscar = trim($_POST['txtBuscar']);
    $codigo=$_POST['txtCodigo'];
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
            $orden = 'cho.ID ' . $orden_tipo;
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
            $orden = 'cho.licencia_conducir ' . $orden_tipo;
            break;
        case 6:
            $orden = 'cho.celular ' . $orden_tipo;
            break;
        case 7:
            $orden = 'es.nombre ' . $orden_tipo;
            break;
        default:
            $orden = 'cho.ID ' . $orden_tipo;
            break;
    }
    if($codigo!=""){
        $filtro="empresa_ID=".$_SESSION['empresa_ID']." and cho.ID=".$codigo;
    }else{
        $filtro = 'empresa_ID='.$_SESSION['empresa_ID'].' and upper(concat(pe.apellido_paterno," ",pe.apellido_materno,"",pe.nombres)) like "%' . str_replace(' ', '%', strtoupper(FormatTextSave($buscar))) . '%"';

    }
    
    //---------------------------------------					 
    $resultado = '<table id="websendeos" class="grid table table-hover table-bordered"><thead><tr>';
    $resultado.='<th class="text-center">N°</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(1);">Código' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(2);">Ape. paterno' . (($txtOrden == 2 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(3);">Ape. materno' . (($txtOrden == 3 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(4);">Nombres' . (($txtOrden == 4 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(5);">Lic. Conducir' . (($txtOrden == 5 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(6);">Celular' . (($txtOrden == 6 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(7);">Estado' . (($txtOrden == 7 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="tdCenter">Opciones</th>';
    $resultado.='</tr></thead>';
    $resultado.='<tbody>';
    $colspanFooter = 9;
    try {
        $cantidadMaxima = chofer::getCount($filtro);
        $dtChofer = chofer::getGrid($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
        $rows = count($dtChofer);
        $i=($paginaActual-1)*$cantidadMostrar+1;
        foreach ($dtChofer as $item) {
            $resultado.='<tr class="tr-item">';
            $resultado.='<td class="text-center">'.$i.'</td>';
            $resultado.='<td class="text-center">' . sprintf("%'.06d",$item['ID'])  . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextView(strtoupper($item['apellido_paterno'])) . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextView(strtoupper($item['apellido_materno'])) . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextView(strtoupper($item['nombres']))  . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextView(strtoupper($item['licencia_conducir']))  . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextView(strtoupper($item['celular'])) . '</td>';
            $resultado.='<td class="text-center">' . FormatTextView(strtoupper($item['estado'])) . '</td>';
            $botones=array();
            array_push($botones,'<a onclick="fncEditar(' . $item['ID'] . ');" ><span class="glyphicon glyphicon-pencil" title="Editar producto">Editar</a>');
            array_push($botones,'<a onclick="modal.confirmacion(&#39;El proceso es irreversible, esta seguro de eliminar el registro.&#39;,&#39;Eliminar Chofer&#39;,fncEliminar,&#39;' . $item['ID'] . '&#39;);" title="Eliminar chofer"><span class="glyphicon glyphicon-trash">Eliminar</a>');
            $resultado.='<td class="btnAction" >'.extraerOpcion($botones)."</td>";
            $resultado.='</tr>';
            $i++;
        }

        $cantidadPaginas = '';

        $resultado.=paginacion($cantidadMaxima,$cantidadMostrar,$colspanFooter,$paginaActual);

        $resultado.='<tr class="tr-footer"><th colspan=' . $colspanFooter . '>' . $rows . ' de ' . $cantidadMaxima . ' Registros</th></tr>';

       
    } catch (Exception $ex) {
        $resultado.='<tr><td colspan=' . $colspanFooter . '>' . $ex->getMessage() . '</td></tr>';
    }
    $resultado.='</tbody>';
    $resultado.='</table>';

    $mensaje = '';
    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
    //$retorn="<h1>Hola</h1>";

    echo json_encode($retornar);
}

//eliminar chofer
function post_ajaxChofer_Mantenimiento_Eliminar($id) {
    require ROOT_PATH . 'models/chofer.php';

    try {
        $oChofer = chofer::getByID($id);
        $oChofer->usuario_mod_id = $_SESSION['usuario_ID'];
        if ($oChofer == null) {
            throw new Exception('Parece que el registro ya fue eliminado.');
        }

        if ($oChofer->eliminar() == -1) {
            throw new Exception($oChofer->getMessage);
        }

        $resultado = 1;
        $mensaje = $oChofer->getMessage;
        $funcion = '';
    } catch (Exception $ex) {
        $resultado = -1;
        $mensaje = $ex->getMessage();
        $funcion = '';
    }

    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje, 'funcion' => $funcion);

    echo json_encode($retornar);
}


//fin mantenimiento chofer
//----------------------------------------------------------------------------------------

//mantenimiento de padre de producto
function get_Producto_Mantenimiento_Padre(){
    require ROOT_PATH . 'models/categoria.php';	
    require ROOT_PATH . 'models/linea.php';
    require ROOT_PATH . 'models/producto.php';
    require ROOT_PATH . 'models/estado.php';
    global $returnView;
    $returnView = true;
    $oCategoria=new categoria();
    $oLinea=new linea();
    $oEstado=new estado();
    $oProducto=new producto();
    $dtCategoria=$oCategoria->getGrid('',-1,-1,'ca.nombre');
    $dtLinea=$oLinea->getGrid('',-1,-1,'li.nombre');
    $dtEstado=$oEstado->getGrid('tabla="producto"',-1,-1,'orden');
    $dtProducto=$oProducto->getGrid('',-1,-1,'pr.nombre');
    $GLOBALS['dtCategoria']=$dtCategoria;
    $GLOBALS['dtLinea']=$dtLinea;
    $GLOBALS['dtEstado']=$dtEstado;
    $GLOBALS['dtProducto']=$dtProducto;
}
//inicio producto mantenimiento
function get_Producto_Mantenimiento() {
    require ROOT_PATH . 'models/categoria.php';
    require ROOT_PATH . 'models/linea.php';
    global $returnView;
    $returnView = true;

    $oLinea=new linea();
    $oCategoria=new categoria();
    $dtCategoria=$oCategoria->getGrid("",-1,-1,"ca.nombre asc");
    $dtLinea=$oLinea->getGrid("",-1,-1,"li.nombre asc");
    $GLOBALS['dtCategoria']=$dtCategoria;
    $GLOBALS['dtLinea']=$dtLinea;
}

//muestra la ventana para agregar nuevo producto
function get_Producto_Mantenimiento_Nuevo($id) {
    require ROOT_PATH . 'models/producto.php';
    require ROOT_PATH . 'models/categoria.php';
    require ROOT_PATH . 'models/linea.php';
    require ROOT_PATH . 'models/unidad_medida.php';
    require ROOT_PATH . 'models/moneda.php';
    require ROOT_PATH . 'models/datos_generales.php';
    global $returnView_float;
    $returnView_float = true;
    $oProducto = new producto;
    $oProducto->unidad_medida_ID=0;
    
    $IDs=explode('_',$id);
    $linea_ID=$IDs[0];
    $categoria_ID=$IDs[1];
    $dtLinea=linea::getGrid("",-1,-1,"li.nombre asc");
    $dtCategoria=categoria::getGrid('ca.linea_ID='.$linea_ID,-1,-1,"ca.nombre asc");
    $dtUnidad_Medida=unidad_medida::getGrid();
    $dtMoneda=moneda::getGrid('',-1,-1,'ID desc');
    $oProducto->dtMoneda=$dtMoneda;
    $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
    $oProducto->tipo_cambio=$oDatos_Generales->tipo_cambio;
    $GLOBALS['categoria_ID']= $categoria_ID;
    $GLOBALS['linea_ID']= $linea_ID;
    $GLOBALS['oProducto'] = $oProducto;
    $GLOBALS['dtLinea']=$dtLinea;
    $GLOBALS['dtCategoria']=$dtCategoria;
    $GLOBALS['dtUnidad_Medida']=$dtUnidad_Medida;
    $GLOBALS['mensaje'] = '';
}

//graba los datos que se recuperan por el metodo post en nuevo Producto
function post_Producto_Mantenimiento_Nuevo() {
    require ROOT_PATH . 'models/categoria.php';
    require ROOT_PATH . 'models/linea.php';
    require ROOT_PATH . 'models/producto.php';
    require ROOT_PATH . 'models/unidad_medida.php';
    require ROOT_PATH . 'models/moneda.php';
    require ROOT_PATH . 'models/datos_generales.php';
    require ROOT_PATH . 'models/inventario.php';
    global $returnView_float;
    $returnView_float = true;
    $categoria = $_POST['selCategoria'];
    $nombre = trim($_POST['txtNombre']);
    $descripcion = trim($_POST['txtDescripcion']);
    $moneda_ID=$_POST['selMoneda_ID'];
    $tipo_cambio=$_POST['txtTipo_Cambio'];
    $precio_inicial_soles=$_POST['txtPrecio_Inicial_soles'];
    if($precio_inicial_soles==''){
        $precio_inicial_soles=0;
    }
    $precio_inicial_dolares=$_POST['txtPrecio_Inicial_Dolares'];
    if($precio_inicial_dolares==''){
        $precio_inicial_dolares=0;
    }
    $unidad_medida_ID = $_POST['selUnidad_Medida'];
    $marca=trim($_POST['txtMarca']);
    $modelo=trim($_POST['txtModelo']);
    $color=trim($_POST['txtColor']);
    //Informacion para la web
    
    $ver_web=(!isset($_POST['ckVer_Web']))?0:$_POST['ckVer_Web'];
    
    $caracteristicas=trim($_POST['txtCaracteristicas']);
    $especificaciones=trim($_POST['txtEspecificaciones']);
   
    $oProducto = new producto;

    try {
        $oProducto->empresa_ID=$_SESSION['empresa_ID'];
        $oProducto->nombre = $nombre;
        $oProducto->descripcion = $descripcion;
        $oProducto->categoria_ID = $categoria;
        $oProducto->unidad_medida_ID = $unidad_medida_ID;
        $oProducto->marca=$marca;
        $oProducto->modelo=$modelo;
        $oProducto->color=$color;
        $oProducto->moneda_ID=$moneda_ID;
        $oProducto->precio_inicial_soles=$precio_inicial_soles;
        $oProducto->precio_inicial_dolares=$precio_inicial_dolares;
        $oProducto->tipo_cambio=$tipo_cambio;
        $oProducto->estado_ID = 24;
        $oProducto->ver_web=$ver_web;
        $oProducto->caracteristicas=$caracteristicas;
        $oProducto->especificaciones=$especificaciones;
        $oProducto->usuario_id = $_SESSION['usuario_ID'];
        if ($oProducto->verificarDuplicado() > 0) {
            
            //throw new Exception($oProducto->getMessage);
            $GLOBALS['resultado'] = -1;
            $GLOBALS['mensaje']=$oProducto->getMessage;
        } else{
            $oProducto->insertar1();
        // Mover fichero de imagen chica a su ubicación definitiva

       /*Insertamos el producto al  inventario con estado inicial */
            $oInventario=new inventario();
            $oInventario->descripcion=$descripcion;
            $oInventario->producto_ID=$oProducto->ID;
            $oInventario->estado_ID=47;
            $oInventario->salida_detalle_ID="NULL";
            $oInventario->ingreso_detalle_ID="NULL";
            $oInventario->utilidad_soles=0;
            $oInventario->utilidad_dolares=0;
            $oInventario->comision_soles=0;
            $oInventario->comision_dolares=0;
            $oInventario->serie="NULL";
            $oInventario->cotizacion_detalle_ID="NULL";
            $oInventario->usuario_id=$_SESSION['usuario_ID'];   
            $oInventario->insertar();
            $GLOBALS['resultado'] = 1;
            $GLOBALS['mensaje']=$oProducto->getMessage;
        }
        
 
    } catch (Exception $ex) {
        $GLOBALS['resultado'] = -1;
        $GLOBALS['mensaje'] = utf8_encode(mensaje_error);
        log_error(__FILE__, "", $ex->getMessage());
    }
   
    $dtMoneda=moneda::getGrid('',-1,-1,'ID desc');
    $oProducto->dtMoneda=$dtMoneda;
    $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
    $oProducto->tipo_cambio=$oDatos_Generales->tipo_cambio;

    $dtUnidad_Medida=unidad_medida::getGrid();
    $GLOBALS['dtUnidad_Medida']=$dtUnidad_Medida;
    $GLOBALS['dtLinea']=linea::getGrid();
    $GLOBALS['dtCategoria']=categoria::getGrid('ca.linea_ID='.$_POST['selLinea']);
    $GLOBALS['linea_ID']= $_POST['selLinea'];
    $GLOBALS['categoria_ID']= $_POST['selCategoria'];
    $GLOBALS['oProducto'] = $oProducto;
    
   
}
function post_ajaxCbo_Categoria() {
    require ROOT_PATH . 'models/categoria.php';
    $dtCategoria = categoria::getGrid('');

    $i = 1;
    $resultado = '<ul class="cbo-ul">';
    if (count($dtCategoria) > 0) {
        foreach ($dtCategoria as $icategoria) {
            $resultado.='<li id="li_' . $i . '"><span id="' . $icategoria['ID'] . '" title="' . FormatTextViewHtml($icategoria['nombre']) . '">' . FormatTextViewHtml($icategoria['nombre']) . '</span></li>';
            $i++;
        }
    }
    $resultado.='</ul>';

    $mensaje = '';
    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
    echo json_encode($retornar);
}

//muestra la ventana editar Producto
function get_Producto_Mantenimiento_Editar($id) {
    require ROOT_PATH . 'models/producto.php';
    require ROOT_PATH . 'models/categoria.php';
    require ROOT_PATH . 'models/linea.php';
    require ROOT_PATH . 'models/unidad_medida.php';
    require ROOT_PATH . 'models/moneda.php';
    require ROOT_PATH . 'models/datos_generales.php';
    global $returnView_float;
    $returnView_float = true;
    $oProducto = producto::getByID($id);

    if ($oProducto == null) {
       throw new Exception("No existe el producto.");
    }

    try {
        $oCategoria=categoria::getByID($oProducto->categoria_ID);
        $oLinea=linea::getByID($oCategoria->linea_ID);
        $dtUnidad_Medida=unidad_medida::getGrid();
        $GLOBALS['dtLinea']=linea::getGrid();
        $GLOBALS['dtCategoria']=categoria::getGrid('ca.linea_ID='.$oLinea->ID);
        $GLOBALS['linea_ID']=$oLinea->ID;
        $GLOBALS['categoria_ID']=$oCategoria->ID;
        $GLOBALS['oProducto'] = $oProducto;
        $GLOBALS['dtUnidad_Medida']=$dtUnidad_Medida;
        $dtMoneda=moneda::getGrid('',-1,-1,'ID desc');
        $oProducto->dtMoneda=$dtMoneda;
        $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
        $oProducto->tipo_cambio=$oDatos_Generales->tipo_cambio;
        
        $GLOBALS['mensaje'] = '';
    } catch (Exception $ex) {
        $GLOBALS['mensaje'] = $ex->getMessage();
    }
}

//graba los datos que se recuperan por el metodo post en editar Producto
function post_Producto_Mantenimiento_Editar($id) {
    require ROOT_PATH . 'models/producto.php';
    require ROOT_PATH . 'models/categoria.php';
    require ROOT_PATH . 'models/linea.php';
    require ROOT_PATH . 'models/unidad_medida.php';
    require ROOT_PATH . 'models/moneda.php';
    require ROOT_PATH . 'models/datos_generales.php';
    global $returnView_float;
    $returnView_float = true;
    $categoria_ID=$_POST['selCategoria'];
    $nombre = trim($_POST['txtNombre']);
    $descripcion =trim($_POST['txtDescripcion']);
    $moneda_ID=$_POST['selMoneda_ID'];
    $unidad_medida_ID = $_POST['selUnidad_Medida'];
    

    
    $precio_inicial_soles=$_POST['txtPrecio_Inicial_soles'];
    $precio_inicial_dolares=$_POST['txtPrecio_Inicial_Dolares'];
    $tipo_cambio=$_POST['txtTipo_Cambio'];
    $marca=trim($_POST['txtMarca']);
    $modelo=trim($_POST['txtModelo']);
    $color=trim($_POST['txtColor']);
    $ver_web=(!isset($_POST['ckVer_Web']))?0:$_POST['ckVer_Web'];
    $caracteristicas=trim($_POST['txtCaracteristicas']);
    $especificaciones=trim($_POST['txtEspecificaciones']);
    $oProducto = producto::getByID($id);
    try {
        if ($oProducto == null) {
            
            $GLOBALS['resultado'] = -1;
                $GLOBALS['mensaje']='Parecer que el registro ya fue eliminado';
        }else{
            $oProducto->ID=$id;
            $oProducto->empresa_ID=$_SESSION['empresa_ID'];
            $oProducto->nombre = $nombre;
            $oProducto->descripcion = $descripcion;
            $oProducto->unidad_medida_ID = $unidad_medida_ID;

            $oProducto->categoria_ID = $categoria_ID;
            $oProducto->marca=$marca;
            $oProducto->modelo=$modelo;
            $oProducto->color=$color;
            $oProducto->moneda_ID=$moneda_ID;
            $oProducto->precio_inicial_soles=$precio_inicial_soles;
            $oProducto->precio_inicial_dolares=$precio_inicial_dolares;
            $oProducto->tipo_cambio=$tipo_cambio;
            $oProducto->ver_web=$ver_web;
            $oProducto->caracteristicas=$caracteristicas;
            $oProducto->especificaciones=$especificaciones;
            $oProducto->usuario_mod_id = $_SESSION['usuario_ID'];

            if ($oProducto->verificarDuplicado() > 0) {
                $GLOBALS['resultado'] = -1;
                $GLOBALS['mensaje']=$oProducto->getMessage;

            }else{
                $oProducto->actualizar1();

                $GLOBALS['resultado'] = 1;
                $GLOBALS['mensaje']="Se actualizó correctamente";
            }
        }
        
        
    } catch (Exception $ex) {
        $GLOBALS['resultado'] = -1;
        $GLOBALS['mensaje'] = $ex->getMessage();
    }
    $dtMoneda=moneda::getGrid('',-1,-1,'ID desc');
    $oProducto->dtMoneda=$dtMoneda;
    $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
    $oProducto->tipo_cambio=$oDatos_Generales->tipo_cambio;
    $dtUnidad_Medida=unidad_medida::getGrid();
    $GLOBALS['dtLinea']=linea::getGrid();
    $GLOBALS['dtCategoria']=categoria::getGrid('ca.linea_ID='.$_POST['selLinea']);
    $GLOBALS['linea_ID']= $_POST['selLinea'];
    $GLOBALS['categoria_ID']= $_POST['selCategoria'];
    $GLOBALS['oProducto'] = $oProducto;
    $GLOBALS['dtUnidad_Medida']=$dtUnidad_Medida;
}
function get_Producto_Mantenimiento_Imagen($id) {
    require ROOT_PATH . 'models/producto.php';
    require ROOT_PATH . 'models/categoria.php';
    require ROOT_PATH . 'models/linea.php';
    require ROOT_PATH . 'models/unidad_medida.php';
    require ROOT_PATH . 'models/moneda.php';
    require ROOT_PATH . 'models/datos_generales.php';
    global $returnView_float;
    $returnView_float = true;
    $oProducto = producto::getByID($id);

    if ($oProducto == null) {
        throw new Exception("No existe el producto");
    }
    
    try {
        $mensaje="";
        $resultado=2;
        
    } catch (Exception $ex) {
        $resultado=-1;
        $mensaje=$ex->getMessage();
        
    }
    $GLOBALS['oProducto'] = $oProducto;
    $GLOBALS['resultado']=$resultado;
    $GLOBALS['mensaje'] = $mensaje;
}

//graba los datos que se recuperan por el metodo post en editar Producto
function post_Producto_Mantenimiento_Imagen($id) {
    require ROOT_PATH . 'models/producto.php';
    require ROOT_PATH . 'models/producto_imagen.php';
    global $returnView_float;
    $returnView_float = true;
    
    $nombre = FormatTextSave(strtoupper(trim($_POST['txtNombre'])));
    $orden = $_POST['txtOrden'];
    $oProducto = producto::getByID($id);
    try {
        if ($oProducto == null) {
            throw new Exception('Parecer que el registro ya fue eliminado');
      
        }
        $oProducto_Imagen=new producto_imagen();
        $oProducto_Imagen->nombre=$nombre;
        $oProducto_Imagen->producto_ID=$id;
        $oProducto_Imagen->orden=$orden;
        $oProducto_Imagen->ruta="";
        $oProducto_Imagen->usuario_id=$_SESSION['usuario_ID'];
        $oProducto_Imagen->insertar();
        //$oProducto->usuario_mod_id = $_SESSION['usuario_ID'];
        $dir_subida = $_SERVER['DOCUMENT_ROOT'].'/files/imagenes/producto_imagen/';
        $nombre_temporal=explode('.',basename($_FILES['imagen']['name']));
        //$extension=$nombre_temporal[1];
        $extension=(strtoupper($nombre_temporal[1])=="JPG"||strtoupper($nombre_temporal[1])=="png"||strtoupper($nombre_temporal[1])=="gif")?$nombre_temporal[1]:"JPG";
        $nombre2=$oProducto_Imagen->ID.'.'.$extension;
        $fichero_subido = $dir_subida .basename($nombre2);
        //$nombre_archivo=$oWeb_Banner_Imagen->ID.".".$fichero_subido[1];
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $fichero_subido)) {
            $oProducto_Imagen->ruta=$nombre2;
            $oProducto_Imagen->usuario_mod_id=$_SESSION['usuario_ID'];
            $oProducto_Imagen->actualizar();

        }else{$mensaje="Se guardó la información, pero no se subió la imagen.";}
        
       
            
        $GLOBALS['resultado'] = 1;
        $GLOBALS['mensaje']="Se actualizó correctamente";
    } catch (Exception $ex) {
        $GLOBALS['resultado'] = -1;
        $GLOBALS['mensaje'] = $ex->getMessage();
    }
   
    $GLOBALS['oProducto'] = $oProducto;
    
}
function post_ajaxProducto_Mantenimiento_Imagen() {
    require ROOT_PATH . 'models/producto.php';
    require ROOT_PATH . 'models/producto_imagen.php';
    $producto_ID=$_POST['id'];
    $resultado='<div class="table-responsive">';
    $resultado.="<table class='table table-hover'>";
    $resultado.="<thead><tr>";
    $resultado.="<th class='tdCenter'>#</th>";
    $resultado.="<th class='tdCenter'>Nombre</th>";
    $resultado.="<th class='tdCenter'>Orden</th>";
    $resultado.="<th class='tdCenter'>Imagen</th>";
    $resultado.="<th class='tdCenter'>Acción</th>";
    $resultado.="</tr></thead>";
    $resultado.="<tbody>";
    try{
        $dtProducto_Imagen=producto_imagen::getGrid("producto_ID=".$producto_ID,-1,-1,"orden asc");
        $i=1;
        foreach($dtProducto_Imagen as $item){
            $ruta_imagen=(trim($item['ruta'])=="")?"/include/img/boton/camara_128x128.png":"/files/imagenes/producto_imagen/".$item['ruta'];
            $resultado.="<tr>";
            $resultado.="<th scope='row' class='tdCenter'>".$i."</th>";
            $resultado.="<td>".FormatTextView($item['nombre'])."</td>";
            $resultado.="<td class='tdCenter'>".$item['orden']."</td>";
            $resultado.="<td class='tdCenter'><img src='".$ruta_imagen."' alt='' class='img-thumbnail' style='height:80px;'></td>";
            $resultado.="<td class='tdCenter'><a onclick='fncEliminar(".$item['ID'].");' class='btn btn-danger' title='Eliminar imagen'><span class='glyphicon glyphicon-trash'></span></a></td>";
            $resultado.="</tr>";
            $i++;
        }
        
    } catch (Exception $ex) {
        $resultado.="<tr>";
        $resultado.="<td colspan='3'>".$ex->getMessage()."</td>";
        $resultado.="</tr>";
    }
    $resultado.="</tbody></table>";
    $resultado.="</div>";
    $retornar = Array('resultado' => $resultado);
    //$retorn="<h1>Hola</h1>";

    echo json_encode($retornar);
}
function post_ajaxProducto_Mantenimiento_Imagen_Eliminar(){
    require ROOT_PATH.'models/producto_imagen.php';
    $ID=$_POST['id'];
    try{
        $oProducto_Imagen=producto_imagen::getByID($ID);
        if($oProducto_Imagen==null){
            throw new Exception("No existe la imagen.");
        }
        $oProducto_Imagen->usuario_mod_id=$_SESSION['usuario_ID'];
        $oProducto_Imagen->eliminar();
        if(trim($oProducto_Imagen->ruta)!=""){
            $fichero = $_SERVER['DOCUMENT_ROOT'].'/files/imagenes/producto_imagen/'.$oProducto_Imagen->ruta;
            if(!unlink($fichero)){
                $mensaje="No existe la imagen.";
            }
        }
        $resultado=1;
        $mensaje=$oProducto_Imagen->getMessage;
        
    }catch(Exception $ex){
        $resultado=-1;
        $mensaje=$ex->getMessage();
    }
    $retornar = Array('resultado' => $resultado,'mensaje'=>$mensaje);
    //$retorn="<h1>Hola</h1>";

    echo json_encode($retornar);
}
//muestra la grilla cargada con datos de Producto,trabaja con ajax

function post_ajaxProducto_Mantenimiento() {
   require ROOT_PATH . 'models/producto.php';
   require ROOT_PATH . 'controls/funcionController.php';
    $buscar = $_POST['txtBuscar'];
    $opcion_tipo=$_POST['rbOpcion'];
    $paginaActual = $_POST['num_page'] == 0 ? 1 : $_POST['num_page'];
    $cantidadMostrar = ($_POST['txtMostrar'] == ''||$_POST['txtMostrar'] ==0) ? 30 : $_POST['txtMostrar'];
    $txtOrden = $_POST['txtOrden'];
    $orden_tipo = 'DESC';
    $orden_class = 'imgOrden-desc';
    $linea_ID=$_POST['selLinea'];
    if(!isset($linea_ID)){
        $linea_ID=0;
    }
    
    $categoria_ID=$_POST['selCategoria'];
    if(!isset($categoria_ID)){
        $categoria_ID=0;
    }
    
    if(!isset($_POST['selProducto'])){
        $producto_ID=0;
    }else{
        $producto_ID=$_POST['selProducto'];
    }
    
    if (isset($_POST['chkOrdenASC'])) {
        $orden_class = 'imgOrden-asc';
        $orden_tipo = 'ASC';
    }
    switch ($txtOrden) {
        case 0:
            $orden = 'pr.ID ' . $orden_tipo;
            break;
        case 1:
            $orden = 'pr.nombre ' . $orden_tipo;
            break;
        case 2:
            $orden = 'ca.nombre ' . $orden_tipo;
            break;
        case 3:
            $orden = 'li.nombre ' . $orden_tipo;
            break;
        case 4:
            $orden = 'es.nombre ' . $orden_tipo;
            break;
        case 5:
            $orden = 'pr.activo ' . $orden_tipo;
            break;
        
        default:
            $orden = 'pr.ID ' . $orden_tipo;
            break;
    }
   $filtro='';
   if($opcion_tipo=="buscar"){
       $filtro.=((trim($filtro)!="")?" and ":""). ' upper(pr.nombre) like "%' . str_replace(' ', '%', strtoupper($buscar)) . '%"';
        if($_POST['txtCodigo']!=""){
            $filtro='pr.ID='.$_POST['txtCodigo'];
        }
   }else{
       if($linea_ID>0){
        $filtro.=((trim($filtro)!="")?" and ":"").' ca.linea_ID='.$linea_ID ;
       
        }
        if($categoria_ID>0){

            $filtro.=((trim($filtro)!="")?" and ":"").' pr.categoria_ID='.$categoria_ID;
        }
        if($producto_ID>0){

            $filtro.=((trim($filtro)!="")?" and ":"").' pr.ID='.$producto_ID;
        }
   }
    

    
    //---------------------------------------					 
    $resultado = '<table id="websendeos" class="grid table table-hover table-bordered"><thead><tr>';
    $resultado.='<th class="text-center">N°</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(0);">Código' . (($txtOrden == 0 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(1);">Nombre de Producto' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(2);">Categoría' . (($txtOrden == 2 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(3);">Línea' . (($txtOrden == 3 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(4);">Estado' . (($txtOrden == 4 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(5);">Condición' . (($txtOrden == 5 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th></th>';
    $resultado.='</tr></thead>';
    $resultado.='<tbody>';
    $colspanFooter = 8;
    try {
        $cantidadMaxima = producto::getCount($filtro);
        $dtProducto = producto::getGrid($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
        
        $rows = count($dtProducto);
        $i=($paginaActual-1)*$cantidadMostrar+1;
        foreach ($dtProducto as $item) {
            $resultado.='<tr class="tr-item">';
            $resultado.='<td class="text-center">'.$i.'</td>';
            $resultado.='<td class="tdCenter">' . sprintf("%'.06d",$item['ID']) . '</td>';
            $resultado.='<td class="tdLeft">' . $item['producto'] . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextViewHtml(ucfirst(mb_strtolower(trim($item['categoria'])))) . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextViewHtml(ucfirst(mb_strtolower(trim($item['linea'])))) . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextViewHtml(ucfirst(mb_strtolower($item['estado']))) . '</td>';
            
            if($item['activo']==1){
                $condicion = '<div title="Activado"><span style="color:green" class="glyphicon glyphicon-ok"></span></div>';
            }else{
                $condicion = '<div title="Desactivado"><span style="color:red" class="glyphicon glyphicon-ban-circle"></span></div>';
            }
            
            $resultado.='<td class="text-center">' . $condicion . '</td>';
            
            $botones=array();
            array_push($botones,'<a onclick="fncEditar(' . $item['ID'] . ');" title="Editar producto"><span class="glyphicon glyphicon-pencil"></span> Editar</a>');
            array_push($botones,'<a onclick="fncImagen(' . $item['ID'] . ');" title="Subir fotos del producto"><span class="glyphicon glyphicon-camera"></span> Fotos</a>');
            if($item['activo']==1){
                array_push($botones,'<a onclick="modal.confirmacion(&#39;El proceso es irreversible, esta seguro de desactivar el producto.&#39;,&#39;Aviso&#39;,fncDesactivar,&#39;' . $item['ID'] . '&#39;);" title="Desactivar producto"><span class="glyphicon glyphicon-ban-circle"></span>Desactivar</a>');
            }else{
                array_push($botones,'<a onclick="modal.confirmacion(&#39;El proceso es irreversible, esta seguro de activar el producto.&#39;,&#39;Aviso&#39;,fncActivar,&#39;' . $item['ID'] . '&#39;);" title="Activar producto"><span class="glyphicon glyphicon-ok"></span>Activar</a>');
            }
            
            array_push($botones,'<a onclick="modal.confirmacion(&#39;Esta seguro de eliminar el registro.&#39;,&#39;Eliminar Producto&#39;,fncEliminar,&#39;' . $item['ID'] . '&#39;);" title="Eliminar producto"><span class="glyphicon glyphicon-trash"></span>Eliminar</a>');
            $resultado.='<td class="btnAction" >'.extraerOpcion($botones)."</td>";
            $resultado.='</tr>';
            $i=$i+1;
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

// muestra la lista deplegable
function post_ajaxCbo_Producto(){
    require ROOT_PATH.'models/producto.php';
    $buscar=trim($_POST['txtBuscar']);
    if(trim($buscar)!=""){
        $filtro='pr.empresa_ID='.$_SESSION['empresa_ID'].' and upper(pr.nombre) like "%'.strtoupper($buscar).'%"';
    }else{
        $filtro='pr.empresa_ID='.$_SESSION['empresa_ID'].' and pr.ID=0';
    }

    $dtProducto=producto::getGrid1($filtro);
    
    $i=1;
    $resultado='<ul class="cbo-ul">';
    if(count($dtProducto)>0){			
            foreach($dtProducto as $iProducto){
                    $resultado.='<li id="li_'.$i.'" onclick="subirValorCaja(&#39;'. test_input($iProducto['producto']).'&#39;);"><span id="'.$iProducto['ID'].'" title="'.test_input($iProducto['producto']).'">'. test_input($iProducto['producto']).'</span></li>';
                    $i++;
            }
    }
    $resultado.='</ul>';

    $mensaje='';
    $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);
    echo json_encode($retornar);
}
	
function post_ajaxCbo_Categoria_Seleccionar(){
    require ROOT_PATH.'models/categoria.php';
    $buscar=$_POST['txtBuscar'];
    if(trim($buscar)!=""){
        $filtro='upper(ca.nombre) like "%'.strtoupper(utf8_encode($buscar)).'%"';
    }else{
        $filtro='ca.ID=0';
    }

    $dtCategoria=categoria::getGrid($filtro);

    $i=1;
    $resultado='<ul class="cbo-ul">';
    //print_r($dtCategoria);
    if(count($dtCategoria)>0){			
            foreach($dtCategoria as $iCategoria){
                    $resultado.='<li id="li_'.$i.'" onclick="subirValorCaja(&#39;'.test_input($iCategoria['nombre']).'&#39;);"><span id="'.$iCategoria['ID'].'" title="'.test_input($iCategoria['nombre']).'">'.test_input($iCategoria['nombre']).'</span></li>';
                    $i++;
            }
    }
    $resultado.='</ul>';

    $mensaje='';
    $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);
    echo json_encode($retornar);
}
function post_ajaxSelect_Categoria($Linea_ID){
		require ROOT_PATH.'models/categoria.php';
		
		//$resultado='<select id="selCategoria" name="selCategoria" style="width:200px;" onchange="fncCategoria();">';
                $resultado="";
                if($Linea_ID==0){
                    $dtCategoria=categoria::getGrid('',-1,-1,'ca.nombre');
                }else{
                    $dtCategoria=categoria::getGrid('ca.linea_ID='.$Linea_ID,-1,-1,'ca.nombre');
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
function post_AjaxSeleccionarPadres(){
    require ROOT_PATH.'models/categoria.php';
    require ROOT_PATH.'models/linea.php';
    require ROOT_PATH.'models/producto.php';
        //$resultado='<select id="selCategoria" name="selCategoria" style="width:200px;" onchange="fncCategoria();">';
    $contenido=$_POST['id'];
    $valores = explode("_",$contenido);  
    $tipo=$valores[0];
    $id=$valores[1];
    
    switch ($tipo){
        case 'categoria':
            if($id>0){
                $ocategoria=categoria::getByID($id);
                $linea_ID=$ocategoria->linea_ID; 
            }else {
                $linea_ID=0;
            }
          
            $retornar=Array('tipo'=>$tipo,'linea_ID'=>$linea_ID);
            break;
         case 'categoria2':
            $ocategoria=categoria::getByID($id);
            $linea_ID=$ocategoria->linea_ID;
            $retornar=Array('tipo'=>$tipo,'linea_ID'=>$linea_ID);
            break;
        case "producto":
            if($id>0){
                $oProducto=producto::getById($id);
                $oCategoria=categoria::getByID($oProducto->categoria_ID);
                $oLinea=linea::getByID($oCategoria->linea_ID);
                $retornar=Array('tipo'=>$tipo,'linea_ID'=>$oLinea->ID,'categoria_ID'=>$oCategoria->ID);
            }else {
                $retornar=Array('tipo'=>$tipo,'linea_ID'=>0,'categoria_ID'=>0);
            }
            
            
            break;
                
    }
    
     

        echo json_encode($retornar);
}	
function post_ajaxCbo_Linea_Seleccionar(){
		require ROOT_PATH.'models/linea.php';
		$buscar=$_POST['txtBuscar'];
                if(trim($buscar)!=""){
                    $filtro='upper(li.nombre) like "%'.strtoupper(FormatTextSave($buscar)).'%"';
                }else{
                    $filtro='li.ID=0';
                }
		
		$dtLinea=linea::getGrid($filtro);
				
		$i=1;
		$resultado='<ul class="cbo-ul">';
		if(count($dtLinea)>0){			
			foreach($dtLinea as $iLinea){
				$resultado.='<li id="li_'.$i.'" onclick="subirValorCaja(&#39;'.FormatTextViewHtml($iLinea['nombre']).'&#39;);"><span id="'.$iLinea['ID'].'" title="'.FormatTextViewHtml($iLinea['nombre']).'">'.FormatTextViewHtml($iLinea['nombre']).'</span></li>';
				$i++;
			}
		}
		$resultado.='</ul>';
		
		$mensaje='';
		$retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);
		echo json_encode($retornar);
	}
function post_ajaxSelect_Categoria1($Linea_ID){
    require ROOT_PATH.'models/categoria.php';

    //$resultado='<select id="selCategoria" name="selCategoria" style="width:335px;" >';
    $dtCategoria=categoria::getGrid('ca.linea_ID='.$Linea_ID,-1,-1,"ca.nombre asc");
    $contar=count($dtCategoria);
    $resultado="";
    if($contar>0){
        $resultado.='<option value="0">SELECCIONAR</option>';
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
function post_ajaxSelect_Producto($IDs){
        require ROOT_PATH.'models/producto.php';

        //$resultado='<select id="selProducto" name="selProducto"style="width:300px;" onchange="f.enviar();">';
        $valores=explode('_',$IDs);
        $linea_ID=$valores[0];
        $categoria_ID=$valores[1];
        
        $filtro="";
        if($linea_ID !="0" && $categoria_ID !="0" ){
            $filtro.=" li.ID=".$linea_ID . ' and pr.categoria_ID='.$categoria_ID;
        } else if($linea_ID!="0" && $categoria_ID =="0"){
            $filtro.=" li.ID=".$linea_ID ;
        }else if($linea_ID=="0" && $categoria_ID !="0") {
            $filtro.='pr.categoria_ID='.$categoria_ID;
        }
        
        $dtProducto=producto::getGrid($filtro,-1,-1,'pr.nombre');
        
        $contar=count($dtProducto);
        $resultado=$IDs;
        if($contar>0){
            $resultado.='<option value="0">--</option>';
            foreach($dtProducto as $iProducto){
                
                $resultado.='<option value="'.$iProducto['ID'].'">'.FormatTextView($iProducto['producto']).'</option>';
            }
        } else {
            $resultado.='<option value="-1">Sin Producto</option>';
        }
        
       // $resultado.='</select>';

        $mensaje='';
        $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);

        echo json_encode($retornar);
}
//eliminar producto
function verificarUtilizacionProducto($id){
    require ROOT_PATH . 'models/cotizacion_detalle.php';
    require ROOT_PATH . 'models/ingreso_detalle.php';
    require ROOT_PATH . 'models/salida_detalle.php';
    $retorna=0;
    $totalCotizacion_Detalle=cotizacion_detalle::getCount('producto_ID='.$id);
    if($totalCotizacion_Detalle>0){
        $retorna=1;
    }
    $totalIngreso_detalle=ingreso_detalle::getCount('ccd.producto_ID='.$id);
    if($totalIngreso_detalle>0){
        $retorna=1;
    }
    
    $totalSalida_Detalle=salida_detalle::getCount('producto_ID='.$id);
    if($totalSalida_Detalle>0){
        $retorna=1;
    }
    return $retorna;
}
function post_ajaxProducto_Mantenimiento_Eliminar($id) {
    require ROOT_PATH . 'models/producto.php';

    try {
        $oProducto = producto::getByID($id);
        $oProducto->usuario_mod_id = $_SESSION['usuario_ID'];
        if(verificarUtilizacionProducto($id)>0){
            throw new Exception('No se puede eliminar el producto porque tiene registros en otras tablas.');
        }
        if ($oProducto == null) {
            throw new Exception('Parece que el registro ya fue eliminado.');
        }

        if ($oProducto->eliminar() == -1) {
            throw new Exception($oProducto->getMessage);
        }

        $resultado = 1;
        $mensaje = $oProducto->getMessage;
       
    } catch (Exception $ex) {
        $resultado = -1;
        $mensaje = $ex->getMessage();
       
    }

    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);

    echo json_encode($retornar);
}


function post_ajaxProducto_Mantenimiento_Activar($id) {
    require ROOT_PATH . 'models/producto.php';

    try {
        $oProducto = producto::getByID($id);
        $oProducto->usuario_mod_id = $_SESSION['usuario_ID'];

        if ($oProducto->activar() == -1) {
            throw new Exception($oProducto->getMessage);
        }

        $resultado = 1;
        $mensaje = $oProducto->getMessage;
       
    } catch (Exception $ex) {
        $resultado = -1;
        $mensaje = $ex->getMessage();
       
    }

    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);

    echo json_encode($retornar);
}

function post_ajaxProducto_Mantenimiento_Desactivar($id) {
    require ROOT_PATH . 'models/producto.php';

    try {
        $oProducto = producto::getByID($id);
        $oProducto->usuario_mod_id = $_SESSION['usuario_ID'];

        if ($oProducto->desactivar() == -1) {
            throw new Exception($oProducto->getMessage);
        }

        $resultado = 1;
        $mensaje = $oProducto->getMessage;
       
    } catch (Exception $ex) {
        $resultado = -1;
        $mensaje = $ex->getMessage();
       
    }

    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);

    echo json_encode($retornar);
}


//fin producto mantenimiento
//----------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------
//inicio operador mantenimiento
function get_Operador_Mantenimiento() {
    global $returnView;
    $returnView = true;
}

//muestra la ventana para agregar nuevo operador
function get_Operador_Mantenimiento_Nuevo() {
    require ROOT_PATH . 'models/operador.php';
    require ROOT_PATH . 'models/cargo.php';
    require ROOT_PATH . 'models/persona.php';
    
    
    global $returnView_float;
    $returnView_float = true;
    
    $dtCargo = cargo::getGrid("",-1,-1,"nombre asc");
    $oOperador = new operador;
    $oOperador->comision=0;
    $oOperador->dtCargo=$dtCargo;
    
    $GLOBALS['oOperador'] = $oOperador;
    
}

//graba los datos que se recuperan por el metodo post en nuevo operador
function post_Operador_Mantenimiento_Nuevo() {
    require ROOT_PATH . 'models/operador.php';
    require ROOT_PATH . 'models/cargo.php';
    require ROOT_PATH . 'models/persona.php';
    require ROOT_PATH . 'models/tipo_documento.php';
    require ROOT_PATH . 'models/persona_documento.php';
    global $returnView_float;
    $returnView_float = true;
    $dtCargo = cargo::getGrid('');
    $persona_ID = $_POST['txtPersona_ID'];
    $telefono = trim($_POST['txtTelefono']);
    $celular = trim($_POST['txtCelular']);
    $mail = trim($_POST['txtMail']);
    $fecha_contrato = $_POST['txtFecha_Contrato'];
    $comision = $_POST['txtComision'];
    $cargo = $_POST['selCargo'];
    $oOperador = new operador();

    try {
        $oOperador->persona_ID = $persona_ID;
        if($oOperador->verificar_duplicado()>0){
            throw new Exception("El operador ya se encuentra registrado.");
        }
        $oOperador->telefono = $telefono;
        $oOperador->celular = $celular;
        $oOperador->mail = $mail;
        $oOperador->fecha_contrato = $fecha_contrato;
        $oOperador->comision = $comision;
        $oOperador->cargo_ID = $cargo;
        $oOperador->usuario_id = $_SESSION['usuario_ID'];
        $oOperador->insertar();
        $GLOBALS['resultado'] = 1;
        $GLOBALS['mensaje'] = $oOperador->getMessage;
    } catch (Exception $ex) {
        $GLOBALS['resultado'] = -1;
        $GLOBALS['mensaje'] = $ex->getMessage();
    }
    $dtCargo = cargo::getGrid("",-1,-1,"nombre asc");
    $oOperador->dtCargo=$dtCargo;
    $GLOBALS['oOperador'] = $oOperador;
}

//muestra la ventana editar Operador
function get_Operador_Mantenimiento_Editar($id) {
    require ROOT_PATH . 'models/operador.php';
    require ROOT_PATH . 'models/cargo.php';
    require ROOT_PATH . 'models/persona.php';
    global $returnView_float;
    $returnView_float = true;
    $dtCargo = cargo::getGrid('',-1,-1,"nombre asc");
    $oOperador = operador::getByID($id);
    $oPersona=persona::getByID($oOperador->persona_ID);

    if ($oOperador == null) {
        $GLOBALS['resultado'] = -1;
        $GLOBALS['mensaje'] = 'Parecer que el registro ya fue eliminado.';
        return;
    }
    $oOperador->dtCargo=$dtCargo;
//    if($oOperador->fecha_contrato=="0000-00-00"){
//        $oOperador->fecha_contrato="";
//    }
    
    $oOperador->nombres_completo=test_input($oPersona->apellido_paterno." ". $oPersona->apellido_materno." ".$oPersona->nombres);
    $GLOBALS['oOperador'] = $oOperador;
        
}

//graba los datos que se recuperan por el metodo post en editar Operador
function post_Operador_Mantenimiento_Editar($id) {
    require ROOT_PATH . 'models/operador.php';
    require ROOT_PATH . 'models/cargo.php';
    require ROOT_PATH . 'models/persona.php';
    global $returnView_float;
    $returnView_float = true;
    
    $persona_ID= $_POST['txtPersona_ID'];
    $telefono = trim($_POST['txtTelefono']);
    $celular = trim($_POST['txtCelular']);
    $mail = trim($_POST['txtMail']);
    $fecha_contrato = $_POST['txtFecha_Contrato'];
    $comision = $_POST['txtComision'];
    $cargo = $_POST['selCargo'];
    try {
        $dtCargo = cargo::getGrid('',-1,-1,"nombre asc");
        $oOperador = operador::getByID($id);
        $oPersona=persona::getByID($oOperador->persona_ID);

        if ($oOperador == null) {
            $GLOBALS['resultado'] = -1;

            throw new Exception('Parecer que el registro ya fue eliminado.');



        }
        
        $oOperador->persona_ID = $persona_ID;
        $oOperador->telefono = $telefono;
        $oOperador->celular = $celular;
        $oOperador->mail = $mail;
        $oOperador->fecha_contrato = $fecha_contrato;
        $oOperador->comision = $comision;
        $oOperador->cargo_ID = $cargo;
        $oOperador->usuario_mod_id = $_SESSION['usuario_ID'];
        $oOperador->actualizar();
       

        $mensaje = $oOperador->getMessage;
        $resultado = 1;
    } catch (Exception $ex) {
        $resultado = -1;
        $mensaje = utf8_encode(mensaje_error);
        log_error(__FILE__, 'mantenimiento/post_Operador_Mantenimiento_Editar', $ex->getMessage());
    }
    $oOperador->dtCargo=$dtCargo;
//    if($oOperador->fecha_contrato=="0000-00-00"){
//        $oOperador->fecha_contrato="";
//    }
    
    $oOperador->nombres_completo=test_input($oPersona->apellido_paterno." ". $oPersona->apellido_materno." ".$oPersona->nombres);
    $GLOBALS['oOperador'] = $oOperador;
    $GLOBALS['mensaje'] = $mensaje;
    $GLOBALS['resultado']=$resultado;
}

//muestra la grilla cargada con datos de Operador,trabaja con ajax
function post_ajaxOperador_Mantenimiento() {
    require ROOT_PATH . 'models/operador.php';
    require ROOT_PATH . 'models/cargo.php';
    require ROOT_PATH . 'controls/funcionController.php';
    $buscar = $_POST['txtBuscar'];
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
        case 0:
            $orden = 'op.ID ' . $orden_tipo;
            break;
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
            $orden = 'ped.numero ' . $orden_tipo;
            break;
        case 5:
            $orden = 'ca.nombre ' . $orden_tipo;
            break;
        default:
            $orden = 'pe.ID ' . $orden_tipo;
            break;
    }
    $filtro = 'upper(concat(pe.apellido_paterno," ",pe.nombres)) like "%' . str_replace(' ', '%', strtoupper($buscar)) . '%"';

    //---------------------------------------					 
    $resultado = '<table id="websendeos" class="grid table table-hover table-bordered"><thead><tr>';
    $resultado.='<th class="text-center">N°</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(1);">Apellido Paterno' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(2);">Apellido Materno' . (($txtOrden == 2 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(3);">Nombres' . (($txtOrden == 3 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(4);">DNI' . (($txtOrden == 4 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(5);">Cargo' . (($txtOrden == 5 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th></th>';
    $resultado.='</tr></head>';
    $resultado.='<tbody>';
    $colspanFooter = 7;
    try {
        $cantidadMaxima = operador::getCount($filtro);
        $dtOperador = operador::getGrid($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
        $rows = count($dtOperador);
        $i=($paginaActual-1)*$cantidadMostrar+1;
        foreach ($dtOperador as $item) {
            $oCargo = cargo::getByID($item['cargo_ID']);
            $resultado.='<tr class="tr-item">';
            $resultado.='<td class="text-center">'.$i.'</td>';
            $resultado.='<td class="tdLeft">' . test_input($item['apellido_paterno']) . '</td>';
            $resultado.='<td class="tdLeft">' . test_input($item['apellido_materno']) . '</td>';
            $resultado.='<td class="tdLeft">' . test_input($item['nombres']) . '</td>';
            $resultado.='<td class="tdLeft">' . test_input($item['numero']) . '</td>';
            $resultado.='<td class="tdLeft">' . $oCargo->nombre . '</td>';
            $botones=array();
            
            array_push($botones,'<a onclick="fncCliente(' . $item['ID'] . ');"><img title="Cliente" src="/include/img/boton/cliente.png" />&nbsp;Cliente</a>');
            array_push($botones,'<a onclick="fncEditar(' . $item['ID'] . ');"><img title="Editar" src="/include/img/boton/edit_14x14.png" />&nbsp;Editar</a>');
            array_push($botones,'<a onclick="modal.confirmacion(&#39;El proceso es irreversible, esta seguro de eliminar el registro.&#39;,&#39;Eliminar Operador&#39;,fncEliminar,&#39;' . $item['ID'] . '&#39;);" title="Eliminar operador"><span class="glyphicon glyphicon-trash">Eliminar</a>');
//          array_push($botones,'<a onclick="fncEliminar(' . $item['ID'] . ');"><img title="Eliminar" src="/include/img/boton/delete_14x14.png" />&nbsp;Eliminar</a>');
            $resultado.='<td class="btnAction">'.extraerOpcion($botones).'</td>';
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

//eliminar Operador
function post_ajaxOperador_Mantenimiento_Eliminar($id) {
    require ROOT_PATH . 'models/operador.php';
    require ROOT_PATH . 'models/operador_cliente.php';

    try {
        $oOperador = operador::getByID($id);
        $oOperador_Cliente = new operador_cliente();
        $oOperador->usuario_mod_id = $_SESSION['usuario_ID'];
        if ($oOperador == null) {
            throw new Exception('Parece que el registro ya fue eliminado.');
        }
        $dtOperador_cliente=operador_cliente::getGrid('operador_ID='.$id);
        if(count($dtOperador_cliente)>0){
             throw new Exception("No se puede eliminar el operador, tiene cliente asignados.");
        }else{
         if ($oOperador->eliminar() == -1) {
            throw new Exception($oOperador->getMessage);
        }
        }


        $resultado = 1;
        $mensaje = $oOperador->getMessage;
//           $GLOBALS['resultado']=1;
//           $GLOBALS['mensaje']=$oOperador->message;
        $funcion = '';
    } catch (Exception $ex) {
        $resultado = -1;
        $mensaje = $ex->getMessage();
//        $GLOBALS['resultado'] = -1;
//        $GLOBALS['mensaje'] = $ex->getMessage();
        $funcion = '';
    }

    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje, 'funcion' => $funcion);

    echo json_encode($retornar);
}
function post_ajaxClientes_Asignados() {
    require ROOT_PATH . 'models/operador.php';
    require ROOT_PATH . 'models/operador_cliente.php';
    $operador_ID=$_POST['id'];
    $html="<table class='table table-hover table-bordered'><thead><tr><th>RUC</th><th>Razon Social</th><th>Estado</th><th></th></tr></thead>";
    $html.='<tbody>';
    try {
        $oOperador = operador::getByID($operador_ID);
        $dtOperador_Cliente=operador_cliente::getGrid("opc.operador_ID=".$operador_ID,-1,-1,"cli.razon_social asc");
        foreach($dtOperador_Cliente as $item){
            $html.='<tr>';
            $html.='<td>'.$item['ruc'].'</td>';
            $html.='<td>'.FormatTextView($item['razon_social']).'</td>';
            $html.='<td>'.FormatTextView($item['estado']).'</td>';
            $html.='<td class="tdCenter"><a title="Eliminar" class="btn btn-danger" onclick="seleccionar('.$item['cliente_ID'].');" style="cursor:pointer;"><span class="glyphicon glyphicon-trash"></span></a></td>';
            $html.='</tr>';
        }
        
    } catch (Exception $ex) {
        
        $html.='<tr><td colspan="4">'.$ex->getMessage().'</td></tr>';
    }
    $html.='</tbody>';
    $html.='</table>';
    $retornar = Array('html' => $html);

    echo json_encode($retornar);
}
function post_ajaxClientes_Libres() {
    require ROOT_PATH . 'models/operador.php';
    require ROOT_PATH . 'models/cliente.php';
    $operador_ID=$_POST['id'];
    $html="<table class='table table-hover table-bordered'><thead><tr><th>RUC</th><th>Razon Social</th><th></th></thead>";
    $html.='<tbody>';
    try {
        $filtro="clt.ID not in (select cliente_ID from operador_cliente where estado_ID=74 and del=0)";
        $dtCliente=cliente::getGrid($filtro,-1,-1,"clt.razon_social asc");
        foreach($dtCliente as $item){
            $html.='<tr>';
            $html.='<td>'.$item['ruc'].'</td>';
            $html.='<td>'.FormatTextView($item['razon_social']).'</td>';
            $html.='<td><a class="btn btn-success" title="Agregar" onclick="seleccionar('.$item['ID'].');"><span class="glyphicon glyphicon-plus"></span></a></td>';
            $html.='</tr>';
        }
        
    } catch (Exception $ex) {
        
        $html.='<tr><td colspan="">'.$ex->getMessage().'</td></tr>';
    }
    $html.='</tbody>';
    $html.='</table>';
    $retornar = Array('html' => $html);

    echo json_encode($retornar);
}
//fin Operador
//----------------------------------------------------------------------------------------
/*Asignar clientes al operador*/
function get_Operador_Mantenimiento_Asignar_Cliente($id) {

    require ROOT_PATH . 'models/operador_cliente.php';
    global $returnView_float;
    $returnView_float = true;
    
    $dtOperador_cliente=operador_cliente::getGrid('operador_ID='.$id);
    $GLOBALS['operador_ID']=$id;
    $GLOBALS['dtOperador_cliente'] =$dtOperador_cliente;
    $GLOBALS['mensaje'] = '';
    
}

function post_ajaxAsignar_Cliente_Seleccionar(){
    require ROOT_PATH . 'models/operador_cliente.php';
    $resultado=0;
    $operador_ID=$_POST['id'];
    $cliente_ID = $_POST['id1'];
    try {
        $oOperador_Cliente= new operador_cliente();
        
        $oOperador_Cliente->operador_ID= $operador_ID;
        $oOperador_Cliente->cliente_ID=$cliente_ID;
        $oOperador_Cliente->usuario_id=$_SESSION['usuario_ID'];
        $existencia=$oOperador_Cliente->verificarExistencia();
        if($existencia==0){
            $oOperador_Cliente->estado_ID=74;//Estado activo
            $oOperador_Cliente->insertar();
            $resultado=1;
            $mensaje="Se asignó correctamente";
        } else {
            $oOperador_Cliente->eliminar();
            $resultado=0;
            $mensaje="Se eliminó";
        }
       //$mensaje=$oOperador_Cliente->getMessage;
    } catch (Exception $ex) {
        $resultado = -1;
        $mensaje = $ex->getMessage();
    }
    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
    echo json_encode($retornar);
    
}



/*+++=======================================================*/

//mantenimiento de padre de representantecliente
function get_RepresentanteCliente_Mantenimiento_Padre(){
    require ROOT_PATH . 'models/cliente.php';	
    require ROOT_PATH . 'models/representantecliente.php';
    global $returnView;
    $returnView = true;
	
    $oCliente=new cliente();
    $oRepresentanteCliente=new representantecliente();
	
    $dtCliente=$oCliente->getGrid();
    $dtRepresentanteCliente=$oRepresentanteCliente->getGrid();
	
    $GLOBALS['dtCliente']=$dtCliente;

    $GLOBALS['dtRepresentanteCliente']=$dtRepresentanteCliente;
}



//inicio operador RepresentanteCliente    
function get_RepresentanteCliente_Mantenimiento() {
    global $returnView;
    $returnView = true;
}




//graba los datos que se recuperan por el metodo post en nuevo RepresentanteCliente
function get_RepresentanteCliente_Mantenimiento_Nuevo($id) {
    require ROOT_PATH . 'models/representantecliente.php';
    require ROOT_PATH . 'models/cliente.php';
    require ROOT_PATH . 'models/operador.php';
    $dtCliente = cliente::getGrid('');
    global $returnView_float;
    $returnView_float = true;
    
    $oRepresentanteCliente = new representantecliente;
    $oRepresentanteCliente->cliente=$id;
    $dtOperador=operador::getGrid();
    $GLOBALS['dtOperador']=$dtOperador;
    $GLOBALS['dtCliente'] = $dtCliente;
    $GLOBALS['oRepresentanteCliente'] = $oRepresentanteCliente;
    $GLOBALS['mensaje'] = '';
}

//graba los datos que se recuperan por el metodo post en nuevo RepresentanteCliente
function post_RepresentanteCliente_Mantenimiento_Nuevo() {
    require ROOT_PATH . 'models/representantecliente.php';
    require ROOT_PATH . 'models/cliente.php';
    $dtCliente = cliente::getGrid('');
    global $returnView_float;
    $returnView_float = true;

    
    $nombre = $_POST['txtNombre'];
    $dni = $_POST['txtDni'];
    $apellidos = $_POST['txtApellidos'];
   // $direccion = $_POST['txtDireccion'];
    $telefono = $_POST['txtTelefono'];
    $celular1 = $_POST['txtCelular1'];
    $celular2 = $_POST['txtCelular2'];
    $correo = $_POST['txtCorreo'];
    $cliente = $_POST['cboCliente'];
    $cargo = $_POST['txtCargo'];

    $oRepresentanteCliente = new representantecliente;

    try {
        $oRepresentanteCliente->codigo=$oRepresentanteCliente->getCodigo();
        $oRepresentanteCliente->nombres = $nombre;
        $oRepresentanteCliente->dni = $dni;
        $oRepresentanteCliente->apellidos = $apellidos;
        $oRepresentanteCliente->direccion = "";
        $oRepresentanteCliente->telefono = $telefono;
        $oRepresentanteCliente->celular1 = $celular1;
        $oRepresentanteCliente->celular2 = $celular2;
        $oRepresentanteCliente->correo = $correo;
        $oRepresentanteCliente->cliente = $cliente;
        $oRepresentanteCliente->cargo = $cargo;

        $oRepresentanteCliente->usuario_id = $_SESSION['usuario_ID'];


        $oRepresentanteCliente->usuario_mod_id = $_SESSION['usuario_ID'];
        
        if ( $oRepresentanteCliente->dni!="" && $oRepresentanteCliente->verificarDuplicado() > 0) {
            throw new Exception($oRepresentanteCliente->message);
        }
        
        $oRepresentanteCliente->insertar();
        $GLOBALS['resultado'] = 1;
        $GLOBALS['mensaje'] = $oRepresentanteCliente->message;
    } catch (Exception $ex) {
        $GLOBALS['resultado'] = -1;
        $GLOBALS['mensaje'] = $ex->getMessage();
    }
    $GLOBALS['dtCliente'] = $dtCliente;
    $GLOBALS['oRepresentanteCliente'] = $oRepresentanteCliente;
}

//muestra la ventana editar RepresentanteCliente
function get_RepresentanteCliente_Mantenimiento_Editar($id) {
    require ROOT_PATH . 'models/representantecliente.php';
    require ROOT_PATH . 'models/cliente.php';
    $dtCliente = cliente::getGrid('');
    $GLOBALS['dtCliente'] = $dtCliente;
    global $returnView_float;
    $returnView_float = true;
    $oRepresentanteCliente = representantecliente::getByID($id);

    if ($oRepresentanteCliente == null) {
        $GLOBALS['resultado'] = -3;
        $GLOBALS['mensaje'] = 'Parecer que el registro ya fue eliminado.';
        return;
    }

    try {



        $GLOBALS['oRepresentanteCliente'] = $oRepresentanteCliente;

        $GLOBALS['mensaje'] = '';
    } catch (Exception $ex) {
        $GLOBALS['mensaje'] = $ex->getMessage();
    }
}

//graba los datos que se recuperan por el metodo post en editar RepresentanteCliente
function post_RepresentanteCliente_Mantenimiento_Editar($id) {
    require ROOT_PATH . 'models/representantecliente.php';
    require ROOT_PATH . 'models/cliente.php';
    $dtCliente = cliente::getGrid('');
    $GLOBALS['dtCliente'] = $dtCliente;
    global $returnView_float;
    $returnView_float = true;
    $oRepresentanteCliente = representantecliente::getByID($id);

    if ($oRepresentanteCliente == null) {
        $GLOBALS['resultado'] = -3;
        $GLOBALS['mensaje'] = 'Parecer que el registro ya fue eliminado.';
        return;
    }

    try {
        $nombre = $_POST['txtNombre'];
        $dni = $_POST['txtDni'];
        $apellidos = $_POST['txtApellidos'];
        // $direccion = $_POST['txtDireccion'];
        $telefono = $_POST['txtTelefono'];
        $celular1 = $_POST['txtCelular1'];
        $celular2 = $_POST['txtCelular2'];
        $correo = $_POST['txtCorreo'];
        $cliente = $_POST['cboCliente'];
        $cargo = $_POST['txtCargo'];


        $oRepresentanteCliente->nombres = $nombre;
        $oRepresentanteCliente->dni = $dni;
        $oRepresentanteCliente->apellidos = $apellidos;
        $oRepresentanteCliente->direccion = "";
        $oRepresentanteCliente->telefono = $telefono;
        $oRepresentanteCliente->celular1 = $celular1;
        $oRepresentanteCliente->celular2 = $celular2;
        $oRepresentanteCliente->correo = $correo;
        $oRepresentanteCliente->cliente = $cliente;
        $oRepresentanteCliente->cargo = $cargo;

        $oRepresentanteCliente->usuario_mod_id = $_SESSION['usuario_ID'];

       if ($oRepresentanteCliente->verificarDuplicado() > 0) {
           throw new Exception($oRepresentanteCliente->message);
       }

        $oRepresentanteCliente->actualizar();


        

        $GLOBALS['mensaje'] = $oRepresentanteCliente->message;
        $GLOBALS['resultado'] = 1;
    } catch (Exception $ex) {
        $GLOBALS['resultado'] = -1;
        $GLOBALS['mensaje'] = $ex->getMessage();
    }
    $GLOBALS['oRepresentanteCliente'] = $oRepresentanteCliente;
}

//muestra la grilla cargada con datos de RepresentanteCliente,trabaja con ajax
function post_ajaxRepresentanteCliente_Mantenimiento() {
    require ROOT_PATH . 'models/representantecliente.php';
    require ROOT_PATH . 'models/cliente.php';
    $buscar = $_POST['txtBuscar'];
    $paginaActual = $_POST['num_page'] == 0 ? 1 : $_POST['num_page'];
    $cantidadMostrar = $_POST['txtMostrar'] == '' ? 30 : $_POST['txtMostrar'];
    $txtOrden = $_POST['txtOrden'];
    $orden_tipo = 'DESC';
    $orden_class = 'imgOrden-desc';
	
	$cliente_ID=$_POST['selCliente'];
    if(!isset($cliente_ID)){
        $cliente_ID=0;
    }
	
	if(!isset($_POST['selRepresentanteCliente'])){
        $representantecliente_ID=0;
    }else{
        $representantecliente_ID=$_POST['selRepresentanteCliente'];
    }
	
    if (isset($_POST['chkOrdenASC'])) {
        $orden_class = 'imgOrden-asc';
        $orden_tipo = 'ASC';
    }
    switch ($txtOrden) {
        case 1:
            $orden = 'pr.nombres ' . $orden_tipo;
            break;
        case 2:
            $orden = 'pr.apellidos ' . $orden_tipo;
            break;
        case 3:
            $orden = 'pr.dni ' . $orden_tipo;
            break;
		case 4:
            $orden = 'clt.razon_social ' . $orden_tipo;
            break;	
        default:
            $orden = 'pr.ID ' . $orden_tipo;
            break;
    }
   $filtro='';

    if($cliente_ID>0){
         $filtro.=' pr.cliente_ID='.$cliente_ID . ' and ';
    }
    if($representantecliente_ID>0){
          $filtro.=' pr.ID='.$representantecliente_ID . ' and ';
    }
    $filtro.= ' concat(pr.dni," ",upper(concat(pr.nombres," ",pr.apellidos))) like "%' . str_replace(' ', '%', strtoupper(FormatTextSave($buscar))) . '%"';

    //---------------------------------------					 
    $resultado = '<table class="grid"><tr>';
    $resultado.='<th colspan="2"></th>';
    
    $resultado.='<th  class="thOrden" onclick="fncOrden(1);">Nombres' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th  class="thOrden" onclick="fncOrden(2);">Apellidos' . (($txtOrden == 2 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th  class="thOrden" onclick="fncOrden(3);">DNI' . (($txtOrden == 3 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th  class="thOrden" onclick="fncOrden(4);">Cliente' . (($txtOrden == 4 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th  class="thOrden" onclick="fncOrden(5);">Cargo' . (($txtOrden == 5 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    
    $resultado.='</tr>';

    $colspanFooter = 10;
    try {
        $cantidadMaxima = representantecliente::getCount($filtro);
        $dtRepresentanteCliente = representantecliente::getGrid($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
        $rows = count($dtRepresentanteCliente);
        $i=1;
        foreach ($dtRepresentanteCliente as $item) {
            //buscamos al cliente por su ID en cada recorrido
            $oCliente = cliente::getByID($item['cliente_ID']);
            $resultado.='<tr class="tr-item">';
            $resultado.='<td style="width:70px;" class="btnAction"><img title="Editar" src="/include/img/boton/edit_14x14.png" />&nbsp;<a onclick="fncEditar(' . $item['ID'] . ');">Editar</a></td>';
            $resultado.='<td style="width:70px;" class="btnAction"><img title="Eliminar" src="/include/img/boton/delete_14x14.png" />&nbsp;<a onclick="fncEliminar(' . $item['ID'] . ');">Eliminar</a></td>';
	
            $resultado.='<td class="tdCenter">' . FormatTextViewHtml($item['nombres']) . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextViewHtml($item['apellidos']) . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextViewHtml($item['dni']) . '</td>';
            $resultado.='<td>' . $oCliente->razon_social . '</td>';
            $resultado.='<td>' . FormatTextViewHtml($item['cargo']) . '</td>';
            		$resultado.='</tr>';
			$i=$i+1;
        }

        $cantidadPaginas = '';


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

            $resultado.='<div  id=1 class="pagination pagination-ini" ><a title="Primero"><<</a></div>';
            $resultado.='<div id="' . ($paginaActual > 1 ? $paginaActual - 1 : $paginaActual) . '" class="pagination pagination-prev" ><a title="Anterior"><</a></div>';

            for ($i = $paginaInicio; $i <= $paginaFin; $i++) {
                if ($i == $paginaActual) {
                    $resultado.='<div class="pagination">' . $i . '</div>';
                } else {
                    $resultado.='<div id="' . $i . '" class="pagination"><a>' . $i . '</a></div>';
                }
            }

            $resultado.='<div id="' . ($paginaActual < $cantidadPaginas ? $paginaActual + 1 : $paginaActual) . '" class="pagination pagination-next" ><a title="Siguiente">></a></div>';
            $resultado.='<div id="' . $cantidadPaginas . '" class="pagination pagination-end" ><a title="Último">>></a></div>';

            $resultado.='</td></tr>';
        }

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

//eliminar RepresentanteCliente
function post_ajaxRepresentanteCliente_mantenimiento_Eliminar($id) {
    require ROOT_PATH . 'models/representantecliente.php';

    try {
        $oRepresentanteCliente = representantecliente::getByID($id);
        $oRepresentanteCliente->usuario_mod_id = $_SESSION['usuario_ID'];
        if ($oRepresentanteCliente == null) {
            throw new Exception('Parece que el registro ya fue eliminado.');
        }

        if ($oRepresentanteCliente->eliminar() == -1) {
            throw new Exception($oRepresentanteCliente->message);
        }

        $resultado = 1;
        $mensaje = $oRepresentanteCliente->message;
        $funcion = '';
    } catch (Exception $ex) {
        $resultado = -1;
        $mensaje = $ex->getMessage();
        $funcion = '';
    }

    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje, 'funcion' => $funcion);

    echo json_encode($retornar);
}


//select representante cliente
function post_ajaxSelect_RepresentanteCliente($Cliente_ID){
        require ROOT_PATH.'models/representantecliente.php';

        $resultado='<select id="selRepresentanteCliente" name="selRepresentanteCliente" onchange="f.enviar();">';
        if($Cliente_ID==0){
            $dtRepresentanteCliente=representantecliente::getGrid();
        } else{
            $dtRepresentanteCliente=representantecliente::getGrid('pr.cliente_ID='.$Cliente_ID);
        } 
        
        $contar=count($dtRepresentanteCliente);
        if($contar>0){
            $resultado.='<option value="0">TODOS</option>';
            foreach($dtRepresentanteCliente as $iRepresentanteCliente){
                
                $resultado.='<option value="'.$iRepresentanteCliente['ID'].'">'.FormatTextView($iRepresentanteCliente['nombres']).'</option>';
            }
        } else {
            $resultado.='<option value="-1">Sin Representante Cliente</option>';
        }
        
        $resultado.='</select>';

        $mensaje='';
        $retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);

        echo json_encode($retornar);
}





//fin RepresentanteCliente
//----------------------------------------------------------------------------------------
//codigo ortega 29-05-2016
//----------------------------------------------------------------------------------------

/* Vista de usuario */

//----------------------------------------------------------------------------------------
function get_Usuario_Mantenimiento() {
    global $returnView;
    $returnView = true;
}

//muestra la ventana para agregar nuevo usuario
//muestra la ventana para agregar nuevo usuario


//muestra la grilla cargada con datos de proveedor,trabaja con ajax
function post_ajaxUsuario_Mantenimiento() {
    require ROOT_PATH . 'models/usuario.php';
    require ROOT_PATH . 'models/operador.php';
    require ROOT_PATH . 'models/perfil.php';
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
            $orden = 'u.nombre ' . $orden_tipo;
            break;
        
        default:
            $orden = 'u.ID ' . $orden_tipo;
            break;
    }
    $filtro = 'upper(concat(u.nombre)) like "%' . str_replace(' ', '%', strtoupper(FormatTextSave($buscar))) . '%"';

    //---------------------------------------					 
    $resultado = '<table class="grid"><tr>';
    
    $resultado.='<th style="width:150px;" class="thOrden" onclick="fncOrden(1);">Usuario' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th style="width:250px;" >Operador</th>';
    $resultado.='<th style="width:200px;">Perfil</th>';
    $resultado.='<th colspan="3"></th>';
   
    $resultado.='</tr>';

    $colspanFooter = 7;
    try {
        $cantidadMaxima = usuario::getCount($filtro);
        $dtUsuario = usuario::getGrid($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
        $rows = count($dtUsuario);

        foreach ($dtUsuario as $item) {
            $oOperador = operador::getByID($item['operador_ID']);
            $oPerfil = perfil::getByID($item['perfile_ID']);
            $resultado.='<tr class="tr-item">';
            $resultado.='<td >' . FormatTextViewHtml($item['usuario']) . '</td>';
            $resultado.='<td>' . $oOperador->apellido_paterno." ".$oOperador->apellido_materno ." ".$oOperador->nombres . '</td>';
            $resultado.='<td>' . $oPerfil->nombre . '</td>';
            $resultado.='<td class="btnAction"><img title="Editar" src="/include/img/boton/edit_14x14.png" />&nbsp;<a onclick="fncPermisos(' . $item['ID'] . ');">Permisos</a></td>';
            $resultado.='<td class="btnAction"><img title="Editar" src="/include/img/boton/edit_14x14.png" />&nbsp;<a onclick="fncEditar(' . $item['ID'] . ');">Editar</a></td>';
            $resultado.='<td class="btnAction"><img title="Eliminar" src="/include/img/boton/delete_14x14.png" />&nbsp;<a onclick="fncEliminar(' . $item['ID'] . ');">Eliminar</a></td>';
            $resultado.='</tr>';
        }

        $cantidadPaginas = '';

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

            $resultado.='<div  id=1 class="pagination pagination-ini" ><a title="Primero"><<</a></div>';
            $resultado.='<div id="' . ($paginaActual > 1 ? $paginaActual - 1 : $paginaActual) . '" class="pagination pagination-prev" ><a title="Anterior"><</a></div>';

            for ($i = $paginaInicio; $i <= $paginaFin; $i++) {
                if ($i == $paginaActual) {
                    $resultado.='<div class="pagination">' . $i . '</div>';
                } else {
                    $resultado.='<div id="' . $i . '" class="pagination"><a>' . $i . '</a></div>';
                }
            }

            $resultado.='<div id="' . ($paginaActual < $cantidadPaginas ? $paginaActual + 1 : $paginaActual) . '" class="pagination pagination-next" ><a title="Siguiente">></a></div>';
            $resultado.='<div id="' . $cantidadPaginas . '" class="pagination pagination-end" ><a title="Último">>></a></div>';

            $resultado.='</td></tr>';
        }

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

function get_ajaxAsignar_Usuario($id) {
    require ROOT_PATH . 'models/usuario.php';
    require ROOT_PATH . 'models/perfil.php';
    require ROOT_PATH . 'models/operador.php';
    require ROOT_PATH . 'models/estado.php';
    global $returnView_float;
    $returnView_float = true;
    
    $oOperador = operador::getByID($id);
    $resultado = "";
    $resultado.=$oOperador->apellido_paterno." ".$oOperador->apellido_materno ." ".$oOperador->nombres;
    $GLOBALS['operador']=$resultado;
    $GLOBALS['operador_ID']=$id;
    
    $oUsuario = new usuario();
    $dtEstado=estado::getGrid('est.tabla="usuario"');
    $dtPerfil = perfil::getGrid('');
	
    $GLOBALS['dtPerfil'] = $dtPerfil;
    $GLOBALS['oUsuario'] = $oUsuario;
    $GLOBALS['dtEstado'] = $dtEstado;
    
    $GLOBALS['mensaje'] = '';
    
}





function post_ajaxCbo_Perfil() {
    require ROOT_PATH . 'models/perfil.php';
    $dtPerfil = perfil::getGrid('');

    $i = 1;
    $resultado = '<ul class="cbo-ul">';
    if (count($dtPerfil) > 0) {
        foreach ($dtPerfil as $iperfil) {
            $resultado.='<li id="li_' . $i . '"><span id="' . $iperfil['ID'] . '" title="' . FormatTextViewHtml($iperfil['nombre']) . '">' . FormatTextViewHtml($iperfil['nombre']) . '</span></li>';
            $i++;
        }
    }
    $resultado.='</ul>';

    $mensaje = '';
    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
    echo json_encode($retornar);
}


function post_ajaxUsuario_Mantenimiento_Permiso_Seleccionar(){
    require ROOT_PATH . 'models/menu_usuario.php';
    $retorna=0;
    try {
        $oMenu_Usuario= new menu_usuario();
        $usuario_ID=$_POST['ID1'];
        $menu_id = $_POST['ID2'];
        $oMenu_Usuario->usuario_ID= $usuario_ID;
        $oMenu_Usuario->menu_ID=$menu_id;
        $oMenu_Usuario->usuario_id_creacion=$_SESSION['usuario_ID'];
        $existencia=$oMenu_Usuario->verificarExistencia();
        if($existencia==0){
            $oMenu_Usuario->insertar();
            $resultado=1;
        } else {
            $oMenu_Usuario->eliminar();
            $resultado=0;
        }
       $mensaje=$oMenu_Usuario->getMessage;
    } catch (Exception $ex) {
        $resultado = -1;
        $mensaje = $ex->getMessage();
    }
    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
    echo json_encode($retornar);
    
}

function post_ajaxCbo_Usuario() {
    require ROOT_PATH . 'models/usuario.php';
    $dtUsuario = usuario::getGrid('');

    $i = 1;
    $resultado = '<ul class="cbo-ul">';
    if (count($dtUsuario) > 0) {
        foreach ($dtUsuario as $iusuario) {
            $resultado.='<li id="li_' . $i . '"><span id="' . $iusuario['ID'] . '" title="' . FormatTextViewHtml($iusuario['nombre']) . '">' . FormatTextViewHtml($iusuario['nombre']) . '</span></li>';
            $i++;
        }
    }
    $resultado.='</ul>';

    $mensaje = '';
    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
    echo json_encode($retornar);
}

function post_ajaxCbo_Permisos() {
    require ROOT_PATH . 'models/menu.php';
    $dtMenu = menu::getGrid('');

    $i = 1;
    $resultado = '<ul class="cbo-ul">';
    if (count($dtMenu) > 0) {
        foreach ($dtMenu as $imenu) {
            $resultado.='<li id="li_' . $i . '"><span id="' . $imenu['ID'] . '" title="' . FormatTextViewHtml($imenu['nombre']) . '">' . FormatTextViewHtml($imenu['nombre']) . '</span></li>';
            $i++;
        }
    }
    $resultado.='</ul>';

    $mensaje = '';
    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
    echo json_encode($retornar);
}


   
//representanteproveedor RepresentanteCliente   


//muestra la ventana para agregar nuevo RepresentanteCliente
/* teto===================== --------------------------------------------------------------------------------------------*/
   
//inicio de representante  proveedor
function get_RepresentanteProveedor_Mantenimiento() {
    global $returnView;
    $returnView = true;
}
/*
function post_ajaxCbo_Proveedor() {
    require ROOT_PATH . 'models/proveedor.php';
    $dtProveedor = proveedor::getGrid();

    $i = 1;
    $resultado = '<ul class="cbo-ul">';
    if (count($dtProveedor) > 0) {
        foreach ($dtProveedor as $iproveedor) {
            $resultado.='<li id="li_' . $i . '"><span id="' . $iproveedor['ID'] . '" title="' . FormatTextViewHtml($iproveedor['razon_social']) . '">' . FormatTextViewHtml($iproveedor['razon_social']) . '</span></li>';
            $i++;
        }
    }
    $resultado.='</ul>';

    $mensaje = '';
    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
    echo json_encode($retornar);
}*/
//muestra la ventana para agregar nuevo representante  proveedor
function get_RepresentanteProveedor_Mantenimiento_Nuevo($id) {
    require ROOT_PATH . 'models/representanteproveedor.php';
    require ROOT_PATH . 'models/proveedor.php';

    global $returnView_float;
    $returnView_float = true;
    $oRepresentanteProveedor = new representanteproveedor;
    $oProveedor=proveedor::getByID($id);
    $GLOBALS['dtProveedor'] = proveedor::getGrid();
    $GLOBALS['oProveedor'] =$oProveedor;
    $GLOBALS['oRepresentanteProveedor'] = $oRepresentanteProveedor;
    
}

function post_RepresentanteProveedor_Mantenimiento_Nuevo($id) {
    require ROOT_PATH . 'models/representanteproveedor.php';
    require ROOT_PATH . 'models/proveedor.php';
    global $returnView_float;
    $returnView_float = true;
    //$dtProveedor = proveedor::getGrid('');
    //$GLOBALS['dtProveedor'] = $dtProveedor;
    
    $nombres = $_POST['txtNombre'];
    $dni = "";
    $apellidos = $_POST['txtApellidos'];
    $direccion = "";
    $telefono = $_POST['txtTelefono'];
    $celular1 = $_POST['txtCelular1'];
    $celular2 = $_POST['txtCelular2'];
    $correo = $_POST['txtCorreo'];
    $proveedor_ID=$id;
    try {
        $oRepresentanteProveedor = new representanteproveedor();
        $oRepresentanteProveedor->nombres = $nombres;
        $oRepresentanteProveedor->dni = $dni;
        $oRepresentanteProveedor->apellidos = $apellidos;
        $oRepresentanteProveedor->direccion = $direccion;
        $oRepresentanteProveedor->telefono = $telefono;
        $oRepresentanteProveedor->celular1 = $celular1;
        $oRepresentanteProveedor->celular2 = $celular2;
        $oRepresentanteProveedor->correo = $correo;
        $oRepresentanteProveedor->proveedor_ID = $proveedor_ID;
        $oRepresentanteProveedor->usuario_id = $_SESSION['usuario_ID'];
        $oRepresentanteProveedor->insertar();
        $resultado=1;
        $mensaje=$oRepresentanteProveedor->message;

    } catch (Exception $ex) {
        $resultado = -1;
        $mensaje=$ex->getMessage();
        //$GLOBALS['mensaje'] = $ex->getMessage();
    }
    $oProveedor=proveedor::getByID($id);
    $GLOBALS['oProveedor'] =$oProveedor;
    $GLOBALS['resultado']=$resultado;
    $GLOBALS['oRepresentanteProveedor'] = $oRepresentanteProveedor;
    $GLOBALS['mensaje']=$mensaje;
}
//graba los datos que se recuperan por el metodo post en nuevo representante  proveedor
function post_ajaxRepresentanteProveedor_Mantenimiento_Agregar() {
    require ROOT_PATH . 'models/representanteproveedor.php';
    require ROOT_PATH . 'models/proveedor.php';
    //global $returnView_float;
    //$returnView_float = true;
    //$dtProveedor = proveedor::getGrid('');
    //$GLOBALS['dtProveedor'] = $dtProveedor;
    $ID=$_POST['txtID'];
    $nombres = $_POST['txtNombre'];
    $dni = "";
    $apellidos = $_POST['txtApellidos'];
    $direccion = "";
    $telefono = $_POST['txtTelefono'];
    $celular1 = $_POST['txtCelular1'];
    $celular2 = $_POST['txtCelular2'];
    $correo = $_POST['txtCorreo'];
    $proveedor_ID=$_POST['txtProveedor_ID'];
    try {
        if($ID==0){
            $oRepresentanteProveedor = new representanteproveedor();
            $oRepresentanteProveedor->nombres = $nombres;
            $oRepresentanteProveedor->dni = $dni;
            $oRepresentanteProveedor->apellidos = $apellidos;
            $oRepresentanteProveedor->direccion = $direccion;
            $oRepresentanteProveedor->telefono = $telefono;
            $oRepresentanteProveedor->celular1 = $celular1;
            $oRepresentanteProveedor->celular2 = $celular2;
            $oRepresentanteProveedor->correo = $correo;
            $oRepresentanteProveedor->proveedor_ID = $proveedor_ID;
            $oRepresentanteProveedor->usuario_id = $_SESSION['usuario_ID'];
            $oRepresentanteProveedor->insertar();
        }else {
            $oRepresentanteProveedor=representanteproveedor::getByID($ID);
            $oRepresentanteProveedor->nombres = $nombres;
            $oRepresentanteProveedor->dni = $dni;
            $oRepresentanteProveedor->apellidos = $apellidos;
            $oRepresentanteProveedor->direccion = $direccion;
            $oRepresentanteProveedor->telefono = $telefono;
            $oRepresentanteProveedor->celular1 = $celular1;
            $oRepresentanteProveedor->celular2 = $celular2;
            $oRepresentanteProveedor->correo = $correo;
            
            $oRepresentanteProveedor->usuario_mod_id = $_SESSION['usuario_ID'];
            $oRepresentanteProveedor->actualizar();
        }
       
        $resultado=1;
        $mensaje=$oRepresentanteProveedor->message;

    } catch (Exception $ex) {
        $resultado = -1;
        $mensaje=$ex->getMessage();
        //$GLOBALS['mensaje'] = $ex->getMessage();
    }
     $retornar = Array('resultado' => $resultado, 'ID' => $proveedor_ID,'mensaje'=>$mensaje);
    //$retorn="<h1>Hola</h1>";

    echo json_encode($retornar);
   // $GLOBALS['oRepresentanteProveedor'] = $oRepresentanteProveedor;
}
function post_ajaxRepresentanteProveedor(){
    require ROOT_PATH . 'models/representanteproveedor.php';
    require ROOT_PATH . 'models/proveedor.php';
    $proveedor_ID=$_POST['id'];
    $dtRepresentanteProveedor=representanteproveedor::getGrid('pr.proveedor_ID='.$proveedor_ID);
    $resultado="<table class='grid'><tr><th>Apellidos y Nombres</th><th>correo</th><th>Celular1</th><th>Celular2</th></tr>";
    
        foreach($dtRepresentanteProveedor as $item){
            $resultado.="<tr id=".$item['ID']." class='tr-item' onclick='fncSeleccionar(this.id);'>";
            $array=$item['ID']."|".
            $resultado.="<td>".FormatTextViewHtml($item['apellidos']." ".$item['nombres'])."</td>";
            $resultado.="<td>".$item['correo']."</td>";
            $resultado.="<td>".$item['celular1']."</td>";
            $resultado.="<td>".$item['celular2']."</td>";
           
            $resultado.="</tr>";
        }
         
   
    $resultado.="</table>";
    $retornar = Array('resultado' => $resultado);
    //$retorn="<h1>Hola</h1>";

    echo json_encode($retornar);
}
function post_ajaxRepresentanteProveedor_Mantenimiento_Editar() {
    require ROOT_PATH . 'models/representanteproveedor.php';
   
    $id=$_POST['id'];
    $oRepresentanteProveedor = representanteproveedor::getByID($id);
    $nombres=$oRepresentanteProveedor->nombres;
    $apellidos=$oRepresentanteProveedor->apellidos;
    $correo=$oRepresentanteProveedor->correo;
    $telefono=$oRepresentanteProveedor->telefono;
    $celular1=$oRepresentanteProveedor->celular1;
    $celular2=$oRepresentanteProveedor->celular2;
     $retornar = Array('ID' => $id,'nombres'=>$nombres,'apellidos'=>$apellidos,'correo'=>$correo,'telefono'=>$telefono,'celular1'=>$celular1,'celular2'=>$celular2);
    //$retorn="<h1>Hola</h1>";

    echo json_encode($retornar);
}
//muestra la ventana editar representante  proveedor
function get_RepresentanteProveedor_Mantenimiento_Editar($id) {
    require ROOT_PATH . 'models/representanteproveedor.php';
    require ROOT_PATH . 'models/proveedor.php';

    global $returnView_float;
    $returnView_float = true;
	$dtProveedor = proveedor::getGrid('');
	$GLOBALS['dtProveedor'] = $dtProveedor;
    $oRepresentanteProveedor = representanteproveedor::getByID($id);

    if ($oRepresentanteProveedor == null) {
        $GLOBALS['resultado'] = -3;
        $GLOBALS['mensaje'] = 'Parecer que el registro ya fue eliminado.';
        return;
    }

    try {



        $GLOBALS['oRepresentanteProveedor'] = $oRepresentanteProveedor;

        $GLOBALS['mensaje'] = '';
    } catch (Exception $ex) {
        $GLOBALS['mensaje'] = $ex->getMessage();
    }
}

//graba los datos que se recuperan por el metodo post en editar Representanteproveedor
function post_RepresentanteProveedor_Mantenimiento_Editar($id) {
    require ROOT_PATH . 'models/representanteproveedor.php';
    require ROOT_PATH . 'models/proveedor.php';

    global $returnView_float;
    $returnView_float = true;
	$dtProveedor = proveedor::getGrid('');
    $GLOBALS['dtProveedor'] = $dtProveedor;
    $oRepresentanteProveedor = representanteproveedor::getByID($id);

    if ($oRepresentanteProveedor == null) {
        $GLOBALS['resultado'] = -3;
        $GLOBALS['mensaje'] = 'Parecer que el registro ya fue eliminado.';
        return;
    }

    try {
        $nombre = $_POST['txtNombre'];
        $dni = $_POST['txtDni'];
        $apellidos = $_POST['txtApellidos'];
        $direccion = $_POST['txtDireccion'];
        $telefono = $_POST['txtTelefono'];
        $celular1 = $_POST['txtCelular1'];
        $celular2 = $_POST['txtCelular2'];
        $correo = $_POST['txtCorreo'];
        $proveedor = $_POST['cboProveedor'];


         $oRepresentanteProveedor->nombre = $nombre;
        $oRepresentanteProveedor->dni = $dni;
        $oRepresentanteProveedor->apellidos = $apellidos;
        $oRepresentanteProveedor->direccion = $direccion;
        $oRepresentanteProveedor->telefono = $telefono;
        $oRepresentanteProveedor->celular1 = $celular1;
        $oRepresentanteProveedor->celular2 = $celular2;
        $oRepresentanteProveedor->correo = $correo;
        $oRepresentanteProveedor->proveedor = $proveedor;

        $oRepresentanteProveedor->usuario_mod_id = $_SESSION['usuario_ID'];

//        if ($oProveedor->verificarDuplicado() > 0) {
//            throw new Exception($oRepresentanteCliente->message);
//        }

        $oRepresentanteProveedor->actualizar();


        $GLOBALS['oRepresentanteProveedor'] = $oRepresentanteProveedor;

        $GLOBALS['mensaje'] = $oRepresentanteProveedor->message;
        $GLOBALS['resultado'] = 1;
    } catch (Exception $ex) {
        $GLOBALS['resultado'] = -1;
        $GLOBALS['mensaje'] = $ex->getMessage();
    }
}

//muestra la grilla cargada con datos de RepresentanteProveedor,trabaja con ajax
function post_ajaxRepresentanteProveedor_Mantenimiento() {
   require ROOT_PATH . 'models/representanteproveedor.php';
    require ROOT_PATH . 'models/proveedor.php';
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
            $orden = 'pr.nombres ' . $orden_tipo;
            break;
        case 2:
            $orden = 'pr.apellidos ' . $orden_tipo;
            break;
        case 3:
            $orden = 'pr.dni ' . $orden_tipo;
            break;
        default:
            $orden = 'pr.ID ' . $orden_tipo;
            break;
    }
    $filtro = 'upper(concat(pr.apellidos," ",pr.nombres)) like "%' . str_replace(' ', '%', strtoupper(FormatTextSave($buscar))) . '%"';

    //---------------------------------------					 
    $resultado = '<table class="grid"><tr>';
    $resultado.='<th colspan="2"></th>';
    $resultado.='<th style="width:200px;" class="thOrden" onclick="fncOrden(1);">Nombres' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th style="width:200px;" class="thOrden" onclick="fncOrden(2);">Apellidos' . (($txtOrden == 2 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th style="width:80px;" class="thOrden" onclick="fncOrden(3);">DNI' . (($txtOrden == 3 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
   $resultado.='<th style="width:80px;" class="thOrden" onclick="fncOrden(4);">Direccion' . (($txtOrden == 4 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
     $resultado.='<th style="width:80px;"  class="thOrden" onclick="fncOrden(5);">Ruc_Proveedor' . (($txtOrden == 5 ? "<img class=" .$orden_class . " />" : "")) . '</th>';
  $resultado.='<th style="width:80px;" class="thOrden" onclick="fncOrden(6);">Razon Social' . (($txtOrden == 5 ? "<img class=" .$orden_class . " />" : "")) . '</th>';
    $resultado.='</tr>';

    $colspanFooter = 10;
    try {
        $cantidadMaxima = representanteproveedor::getCount($filtro);
        $dtRepresentanteProveedor = representanteproveedor::getGrid($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
        $rows = count($dtRepresentanteProveedor);

        foreach ($dtRepresentanteProveedor as $item) {
            //buscamos al cliente por su ID en cada recorrido
            $oProveedor = proveedor::getByID($item['proveedor_ID']);
            $resultado.='<tr class="tr-item">';
            $resultado.='<td class="btnAction"><img title="Editar" src="/include/img/boton/edit_14x14.png" />&nbsp;<a onclick="fncEditar(' . $item['ID'] . ');">Editar</a></td>';
            $resultado.='<td class="btnAction"><img title="Eliminar" src="/include/img/boton/delete_14x14.png" />&nbsp;<a onclick="fncEliminar(' . $item['ID'] . ');">Eliminar</a></td>';
			
            $resultado.='<td class="tdCenter">' . FormatTextViewHtml($item['nombres']) . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextViewHtml($item['apellidos']) . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextViewHtml($item['dni']) . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextViewHtml($item['direccion']) . '</td>';
			$resultado.='<td class="tdLeft">' .FormatTextViewHtml( $oProveedor->ruc).'</td>';
			$resultado.='<td class="tdLeft">' .FormatTextViewHtml( $oProveedor->razon_social).'</td>';
            $resultado.='</tr>';
        }

        $cantidadPaginas = '';


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

            $resultado.='<div  id=1 class="pagination pagination-ini" ><a title="Primero"><<</a></div>';
            $resultado.='<div id="' . ($paginaActual > 1 ? $paginaActual - 1 : $paginaActual) . '" class="pagination pagination-prev" ><a title="Anterior"><</a></div>';

            for ($i = $paginaInicio; $i <= $paginaFin; $i++) {
                if ($i == $paginaActual) {
                    $resultado.='<div class="pagination">' . $i . '</div>';
                } else {
                    $resultado.='<div id="' . $i . '" class="pagination"><a>' . $i . '</a></div>';
                }
            }

            $resultado.='<div id="' . ($paginaActual < $cantidadPaginas ? $paginaActual + 1 : $paginaActual) . '" class="pagination pagination-next" ><a title="Siguiente">></a></div>';
            $resultado.='<div id="' . $cantidadPaginas . '" class="pagination pagination-end" ><a title="Último">>></a></div>';

            $resultado.='</td></tr>';
        }

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

//eliminar RepresentanteProveedor
function post_ajaxRepresentanteProveedor_mantenimiento_Eliminar() {
    require ROOT_PATH . 'models/representanteproveedor.php';
    $id=$_POST['id'];
    try {
        $oRepresentanteProveedor = representanteproveedor::getByID($id);
        $oRepresentanteProveedor->usuario_mod_id = $_SESSION['usuario_ID'];
        if ($oRepresentanteProveedor == null) {
            throw new Exception('Parece que el registro ya fue eliminado.');
        }

        if ($oRepresentanteProveedor->eliminar() == -1) {
            throw new Exception($oRepresentanteProveedor->message);
        }

        $resultado = 1;
        $mensaje = $oRepresentanteProveedor->message;
        $funcion = " <script type='text/javascript' > mostrarValores('resultado','/Mantenimiento/ajaxRepresentanteProveedor',".$oRepresentanteProveedor->proveedor_ID.");</script>";
    } catch (Exception $ex) {
        $resultado = -1;
        $mensaje = $ex->getMessage();
        $funcion = '';
    }

    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje, 'funcion' => $funcion);

    echo json_encode($retornar);
}
//----------------------------------------------------------------------------------------------------------------------------
//----------------------fin representanteproveedor----------------------------------------------------------------------------

/* linea*/
function get_Linea_Mantenimiento() {
    
    global $returnView;
    $returnView = true;
    
    
}
function get_Linea_Mantenimiento_Nuevo() {
    require ROOT_PATH . 'models/linea.php';
    global $returnView_float;
    $returnView_float = true;
    $oLinea = new linea();

    $GLOBALS['oLinea'] = $oLinea;
    
}



//graba los datos que se recuperan por el metodo post en nueva lineaproducto
function post_Linea_Mantenimiento_Nuevo() {
    require ROOT_PATH . 'models/linea.php';
    global $returnView_float;
    $returnView_float = true;

    $nombre = trim($_POST['txtNombre']);
    $descripcion = trim($_POST['txtDescripcion']);
    $tipo=$_POST['selTipo'];
    $oLinea = new linea;

    try {
        $oLinea->nombre = $nombre;
        $oLinea->descripcion = $descripcion;
        $oLinea->tipo=$tipo;
        $oLinea->imagen = "";
        $oLinea->empresa_ID=$_SESSION['empresa_ID'];
        $oLinea->usuario_id = $_SESSION['usuario_ID'];
        if ($oLinea->verificarDuplicado() > 0) {
            //throw new Exception($oProducto->message);
            $mensaje="No se puede registrar porque existe una línea con el mismo nombre";
            $resultado = -1;
             
        } else {
            $oLinea->insertar();
            $resultado= 1;
            $mensaje=$oLinea->getMessage;
            $dir_subida = $_SERVER['DOCUMENT_ROOT'].'/files/imagenes/linea/';
            if ($_FILES['imagen']['name']){
                $nombre_temporal=explode('.',basename($_FILES['imagen']['name']));
                //$extension=$nombre_temporal[1];
                $extension=(strtoupper($nombre_temporal[1])=="JPG"||strtoupper($nombre_temporal[1])=="png"||strtoupper($nombre_temporal[1])=="gif")?$nombre_temporal[1]:"JPG";
                $nombre2=$oLinea->ID.'.'.$extension;
                $fichero_subido = $dir_subida .basename($nombre2);
                //$nombre_archivo=$oWeb_Banner_Imagen->ID.".".$fichero_subido[1];
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $fichero_subido)) {
                    $oLinea->imagen=$nombre2;
                    $oLinea->usuario_mod_id=$_SESSION['usuario_ID'];
                    $oLinea->actualizar();

                }else{$mensaje="Se guardó la información, pero no se subió la imagen.";}
            }
            	
        }
		
    } catch (Exception $ex) {
        $GLOBALS['resultado'] = -1;
        $GLOBALS['mensaje'] = $ex->getMessage();
    }
    $GLOBALS['oLinea'] = $oLinea;
    $GLOBALS['resultado'] = 1;
    $GLOBALS['mensaje']="Se guardó correctamente";
}

//muestra la ventana editar lineaproducto
function get_Linea_Mantenimiento_Editar($id) {
    require ROOT_PATH . 'models/linea.php';
    global $returnView_float;
    $returnView_float = true;
    $oLinea = linea::getByID($id);
    
    
    if ($oLinea== null) {
        throw new Exception('Parecer que el registro ya fue eliminado.'); 
    }
    $ruta_imagen="/include/img/boton/camara_128x128.png";
    if(trim($oLinea->imagen)!=""){
        $ruta_imagen="/files/imagenes/linea/".$oLinea->imagen;
    }
    $oLinea->ruta_imagen=$ruta_imagen;
    $GLOBALS['oLinea'] = $oLinea;

}

//graba los datos que se recuperan por el metodo post en editar lineaproducto
function post_Linea_Mantenimiento_Editar($id) {
    require ROOT_PATH . 'models/linea.php';
    global $returnView_float;
    $returnView_float = true;
    
    $nombre = trim($_POST['txtNombre']);
    $descripcion = trim($_POST['txtDescripcion']);
    $tipo=$_POST['selTipo'];
    $oLinea = linea::getByID($id);
    if ($oLinea == null) {
        throw new Exception("No existe la línea.");
    }

    try {
        
        $oLinea->nombre = $nombre;
        $oLinea->descripcion = $descripcion;
        $oLinea->tipo=$tipo;
        $oLinea->usuario_mod_id = $_SESSION['usuario_ID'];
        $oLinea->empresa_ID=$_SESSION['empresa_ID'];
        if ($oLinea->verificarDuplicado() > 0) {
            
            $mensaje="No se puede registrar porque existe una línea con el mismo nombre.";
            $resultado= -1;

        } else {
            $oLinea->actualizar();
            $resultado= 1;
            $mensaje="Se actualizó correctamente";
            if($_FILES['imagen']['tmp_name']!=""){
                $dir_subida = $_SERVER['DOCUMENT_ROOT'].'/files/imagenes/linea/';
                $nombre_temporal=explode('.',basename($_FILES['imagen']['name']));
                
                $extension=(strtoupper($nombre_temporal[1])=="JPG"||strtoupper($nombre_temporal[1])=="png"||strtoupper($nombre_temporal[1])=="gif")?$nombre_temporal[1]:"JPG";
                $nombre2=$oLinea->ID.'.'.$extension;
                $fichero_subido = $dir_subida .basename($nombre2);
                
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $fichero_subido)) {
                    $oLinea->imagen=$nombre2;
                    $oLinea->usuario_mod_id=$_SESSION['usuario_ID'];
                    $oLinea->actualizar();

                }else{$mensaje="Se guardó la información, pero no se subió la imagen.";}
            }
        }

    } catch (Exception $ex) {
        $resultado= -1;
        $mensaje= $ex->getMessage();
    }
    $GLOBALS['oLinea'] = $oLinea;
    $GLOBALS['mensaje']=$mensaje;
    $GLOBALS['resultado']=$resultado;
}

//muestra la grilla cargada con datos de lineaproducto,trabaja con ajax
function post_ajaxLinea_Mantenimiento() {
    require ROOT_PATH . 'models/linea.php';
    require ROOT_PATH . 'controls/funcionController.php';
    $buscar = $_POST['txtBuscar'];
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
        case 0:
            $orden = 'li.ID ' . $orden_tipo;
            break;
        case 1:
            $orden = 'li.nombre ' . $orden_tipo;
            break;
        case 2:
            $orden = 'li.descripcion ' . $orden_tipo;
            break;
        default:
            $orden = 'li.ID' . $orden_tipo;
            break;
    }
    $filtro = ' upper(li.nombre) like "%' . str_replace(' ', '%', strtoupper(FormatTextSave($buscar))) . '%"';

    //---------------------------------------					 
    $resultado = '<table id="websendeos" class="grid table table-hover table-bordered"><tr>';
    $resultado.='<th class="text-center">N°</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(0);">Código' . (($txtOrden == 0 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(1);">Nombres' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(2);">Desccripcion' . (($txtOrden == 2 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th></th>';
    $resultado.='</tr>';

    $colspanFooter = 5;
    
    try {
        $cantidadMaxima = linea::getCount($filtro);
        $dtLineaProducto = linea::getGrid($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
        $rows = count($dtLineaProducto);
        $i=(($paginaActual-1) * $cantidadMostrar)+1;
        foreach ($dtLineaProducto as $item) {
            $resultado.='<tr class="tr-item">';
            $resultado.='<td class="text-center">'.$i.'</td>';
            $resultado.='<td class="text-center">' . sprintf("%'.06d",$item['ID']) . '</td>';
            $resultado.='<td class="tdLeft">' . ucfirst(mb_strtolower($item['nombre'])) . '</td>';
            $resultado.='<td class="tdLeft">' . ucfirst(mb_strtolower($item['descripcion'])) . '</td>';     
            $botones=array();
            array_push($botones,'<a onclick="fncEditar('. $item['ID'].');" ><span class="glyphicon glyphicon-pencil">Editar</a>');
            array_push($botones,'<a onclick="modal.confirmacion(&#39;El proceso es irreversible, esta seguro de eliminar el registro.&#39;,&#39;Eliminar Línea&#39;,fncEliminar,&#39;' . $item['ID'] . '&#39;);" title="Eliminar línea"><span class="glyphicon glyphicon-trash">Eliminar</a>');
            $resultado.='<td class="btnAction" >'.extraerOpcion($botones)."</td>";
            
            $resultado.='</tr>';
        $i=$i+1;
         }
        $cantidadPaginas = '';
        $resultado.=paginacion($cantidadMaxima,$cantidadMostrar,$colspanFooter,$paginaActual);
        $resultado.='<tr class="tr-footer"><th colspan=' . $colspanFooter . '>' . $rows . ' de ' . $cantidadMaxima . ' Registros</th></tr>';
    } catch (Exception $ex) {
        $resultado.='<tr ><td colspan=' . $colspanFooter . '>' . $ex->getMessage() . '</td></tr>';
    }

    $resultado.='</table>';
//$resultado=$dtLineaProducto;
    $mensaje = '';
    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
    //$retorn="<h1>Hola</h1>";

    echo json_encode($retornar);
}

//eliminar lineaproducto
function post_ajaxLinea_Mantenimiento_Eliminar($id) {
    require ROOT_PATH . 'models/linea.php';
    require ROOT_PATH . 'models/categoria.php';
    try {
        $oLinea= linea::getByID($id);
        $oLinea->usuario_mod_id = $_SESSION['usuario_ID'];
        if ($oLinea == null) {
            throw new Exception('Parece que el registro ya fue eliminado.');
        }
        $Categoria=new categoria();
        $contarHijos=$Categoria->verificarHijos($id);
        if($contarHijos==0){
            if ($oLinea->eliminar() == -1) {
            throw new Exception($oLinea->getMessage);
            $mensaje = $oLinea->getMessage;
            }else{$mensaje="Se eliminó correctamente";
                $resultado = 1;
            }
        } else {
            $mensaje="No se puede eliminar la línea de producto, tiene categorías asignadas";
            $resultado = 2;
        }
         
        $funcion = '';
    } catch (Exception $ex) {
        $resultado = -1;
        $mensaje = $ex->getMessage();
        $funcion = '';
    }

    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje, 'funcion' => $funcion);

    echo json_encode($retornar);
}

//fin mantenimiento lineaproducto
function post_ajaxSelect_Provincia($departamento_ID) {
    require ROOT_PATH . 'models/provincia.php';

    //$resultado = '<select id="cboProvincia" name="cboProvincia" onchange="fncProvincia();">';
    $resultado="";
    $dtProvincia = provincia::getGrid('pv.departamento_ID=' . $departamento_ID);

    foreach ($dtProvincia as $iProvincia) {
        $resultado.='<option value="' . $iProvincia['ID'] . '">' . FormatTextView($iProvincia['nombre']) . '</option>';
    }

    //$resultado.='</select>';

    $mensaje = '';
    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);

    echo json_encode($retornar);
}

function post_ajaxSelect_Distrito($provincia_ID) {
    require ROOT_PATH . 'models/distrito.php';

    $resultado ="";// '<select id="cboDistrito" name="cboDistrito" >';
    $dtDistrito = distrito::getGrid('dt.provincia_ID=' . $provincia_ID);

    foreach ($dtDistrito as $iDistrito) {
        $resultado.='<option value="' . $iDistrito['ID'] . '">' . FormatTextView($iDistrito['nombre']) . '</option>';
    }

    //$resultado.='</select>';

    $mensaje = '';
    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);

    echo json_encode($retornar);
}

//Inicio Datos generales

function get_Datos_generales_Mantenimiento() {
    require ROOT_PATH . 'models/datos_generales.php';
    require ROOT_PATH . 'models/departamento.php';
    require ROOT_PATH . 'models/provincia.php';
    require ROOT_PATH . 'models/distrito.php';
    global $returnView;
    $returnView = true;
    $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
    $oDistrito=distrito::getByID($oDatos_Generales->distrito_ID);
    $oProvincia=provincia::getByID($oDistrito->provincia_ID);
    $dtDepartamento=departamento::getGrid("",-1,-1,"d.nombre asc");
    $dtProvincia=provincia::getGrid("pv.departamento_ID=".$oProvincia->departamento_ID,-1,-1,"pv.nombre asc");
    $dtDistrito=distrito::getGrid("dt.provincia_ID=".$oDistrito->provincia_ID,-1,-1,"dt.nombre asc");
    $oDatos_Generales->departamento_ID=$oProvincia->departamento_ID;
    $oDatos_Generales->provincia_ID=$oDistrito->provincia_ID;
    $html_filas_correos=retornar_filas_registros("configuracion_correo_empresa",$oDatos_Generales->correo);
    $html_filas_celulares=retornar_filas_registros("configuracion_celular_empresa",$oDatos_Generales->celular);
    $GLOBALS['html_filas_correos']=$html_filas_correos;
    $GLOBALS['html_filas_celulares']=$html_filas_celulares;
    $GLOBALS['oDatos_Generales']=$oDatos_Generales;
    $GLOBALS['dtDepatamento']=$dtDepartamento;
    $GLOBALS['dtProvincia']=$dtProvincia;
    $GLOBALS['dtDistrito']=$dtDistrito;
    
}
function post_Datos_generales_Mantenimiento(){
    require ROOT_PATH . 'models/datos_generales.php';
    require ROOT_PATH . 'models/departamento.php';
    require ROOT_PATH . 'models/provincia.php';
    require ROOT_PATH . 'models/distrito.php';
    global $returnView;
    $returnView = true;
    $tipo_cambio=$_POST['txtTipo_Cambio'];
    $vigv=$_POST['txtVigv'];
    $pagina_web=  $_POST['txtPagina_Web'];
    $correo=$_POST['txtCorreo'];
//    $mail_principal=  FormatTextSave($_POST['txtMail_Principal']);
//    $mail_info=  FormatTextSave($_POST['txtMail_Info']);
//    $mail_venta=  FormatTextSave($_POST['txtMail_Venta']);
    $telefono=$_POST['txtTelefono'];
    $celular=$_POST['txtCelular'];
//    $rpc=  FormatTextSave($_POST['txtRpc']);
//    $rpm=  FormatTextSave($_POST['txtRpm']);
//    $nextel=  FormatTextSave($_POST['txtNextel']);
//    $otro_operador=  FormatTextSave($_POST['txtOtro_Operador']);
    $visc=$_POST['txtISC'];
    $tasadetraccion=$_POST['txtTasaDetraccion'];
    $razon_social=  test_input($_POST['txtRazon_Social']);
    $ruc= $_POST['txtRuc'];
    $direccion_fiscal=  test_input($_POST['txtDireccion_Fiscal']);
    
    $alias=  test_input($_POST['txtAlias']);
    $direccion=  test_input($_POST['txtDireccion']);
    $distrito_ID=  $_POST['selDistrito'];
    $urbanizacion=$_POST['txtUrbanizacion'];
    $observacion= trim($_POST['txtObservacion']);
    $oDatos_Generales=datos_generales::getByID1($_SESSION['empresa_ID']);
    $usuariosol=$_POST['txtUsuarioSol'];
    $clavesol=$_POST['txtClaveSol'];
    $certificado=$_POST['txtCertificado'];
    $passwordcertificado=$_POST['txtPasswordCertificado'];
    try{
        $oDatos_Generales->tipo_cambio=$tipo_cambio;
        $oDatos_Generales->vigv=$vigv;
        $oDatos_Generales->visc=$visc;
        $oDatos_Generales->tasadetraccion=$tasadetraccion;
        $oDatos_Generales->pagina_web=$pagina_web;
//        $oDatos_Generales->mail_principal=$mail_principal;
//        $oDatos_Generales->mail_info=$mail_info;
//        $oDatos_Generales->mail_venta=$mail_venta;
        $oDatos_Generales->telefono=$telefono;
        $oDatos_Generales->correo=$correo;
        $oDatos_Generales->celular=$celular;
//        $oDatos_Generales->rpc=$rpc;
//        $oDatos_Generales->rpm=$rpm;
//        $oDatos_Generales->nextel=$nextel;
//        $oDatos_Generales->otro_operador=$otro_operador;
        $oDatos_Generales->razon_social=$razon_social;
        $oDatos_Generales->ruc=$ruc;
        $oDatos_Generales->direccion_fiscal=$direccion_fiscal;
        $oDatos_Generales->alias=$alias;
        $oDatos_Generales->direccion=$direccion;
        $oDatos_Generales->distrito_ID=$distrito_ID;
        $oDatos_Generales->observacion=$observacion;
        $oDatos_Generales->usuariosol=$usuariosol;
        $oDatos_Generales->clavesol=$clavesol;
        $oDatos_Generales->certificado=$certificado;
        $oDatos_Generales->passwordcertificado=$passwordcertificado;
        $oDatos_Generales->urbanizacion=$urbanizacion;
        $oDatos_Generales->usuario_mod_id=$_SESSION['usuario_ID'];
        $oDatos_Generales->actualizar();
        $resultado=1;
        $mensaje=$oDatos_Generales->getMessage;
        if($_FILES['imagen']['tmp_name']!=""){
                $dir_subida = $_SERVER['DOCUMENT_ROOT'].'/files/imagenes/logo/';
                $nombre_temporal=explode('.',basename($_FILES['imagen']['name']));
                
                $extension=(strtoupper($nombre_temporal[1])=="JPG"||strtoupper($nombre_temporal[1])=="png"||strtoupper($nombre_temporal[1])=="gif")?$nombre_temporal[1]:"JPG";
                $nombre2=$oDatos_Generales->ID.'.'.$extension;
                $fichero_subido = $dir_subida .basename($nombre2);
                
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $fichero_subido)) {
                   
                }else{$mensaje="Se guardó la información, pero no se subió la imagen.";}
        }
        if($_FILES['icono']['tmp_name']!=""){
            $dir_subida = $_SERVER['DOCUMENT_ROOT'].'/files/imagenes/favicon/';
            $nombre_temporal=explode('.',basename($_FILES['icono']['name']));

            $extension=$nombre_temporal[1];
            $nombre2=$oDatos_Generales->ID.'.'.$extension;
            $fichero_subido = $dir_subida .basename($nombre2);

            if (move_uploaded_file($_FILES['icono']['tmp_name'], $fichero_subido)) {

            }else{$mensaje="Se guardó la información, pero no se subió el icono.";}
        }    	
    }catch(Exception $ex){
        $resultado=-1;
        $mensaje=$ex->getMessage();
    }
    $oDistrito=distrito::getByID($oDatos_Generales->distrito_ID);
    $oProvincia=provincia::getByID($oDistrito->provincia_ID);
    $dtDepartamento=departamento::getGrid("",-1,-1,"d.nombre asc");
    $dtProvincia=provincia::getGrid("pv.departamento_ID=".$oProvincia->departamento_ID,-1,-1,"pv.nombre asc");
    $dtDistrito=distrito::getGrid("dt.provincia_ID=".$oDistrito->provincia_ID,-1,-1,"dt.nombre asc");
    $oDatos_Generales->departamento_ID=$oProvincia->departamento_ID;
    $oDatos_Generales->provincia_ID=$oDistrito->provincia_ID;
    $html_filas_correos=retornar_filas_registros("configuracion_correo_empresa",$oDatos_Generales->correo);
    $html_filas_celulares=retornar_filas_registros("configuracion_celular_empresa",$oDatos_Generales->celular);
    $GLOBALS['html_filas_correos']=$html_filas_correos;
    $GLOBALS['html_filas_celulares']=$html_filas_celulares;
    $GLOBALS['dtDepatamento']=$dtDepartamento;
    $GLOBALS['dtProvincia']=$dtProvincia;
    $GLOBALS['dtDistrito']=$dtDistrito;
    $GLOBALS['oDatos_Generales']=$oDatos_Generales;
    $GLOBALS['resultado']=$resultado;
    $GLOBALS['mensaje']=$mensaje;
    
}
//muestra la grilla cargada con datos de Datos Generales,trabaja con ajax
function post_ajaxDatos_generales_Mantenimiento() {
    require ROOT_PATH . 'models/datos_generales.php';
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
            $orden = 'pr.ruc ' . $orden_tipo;
            break;
        case 2:
            $orden = 'pr.razon_social ' . $orden_tipo;
            break;
        case 3:
            $orden = 'pr.alias ' . $orden_tipo;
            break;
        case 4:
            $orden = 'pr.direccion ' . $orden_tipo;
            break;
        case 5:
            $orden = 'pr.direccion_fiscal ' . $orden_tipo;
            break;
        case 6:
            $orden = 'pr.mail_principal ' . $orden_tipo;
            break;
        case 7:
            $orden = 'pr.telefono ' . $orden_tipo;
            break;
        default:
            $orden = 'pr.ID ' . $orden_tipo;
            break;
    }
    $filtro = 'upper(concat(pr.ruc," ",pr.razon_social)) like "%' . str_replace(' ', '%', strtoupper(FormatTextSave($buscar))) . '%"';

    //---------------------------------------					 
    $resultado = '<table class="grid"><tr>';
    $resultado.='<th></th>';
    $resultado.='<th style="width:100px;" class="thOrden" onclick="fncOrden(1);">R.u.c.' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th style="width:100px;" class="thOrden" onclick="fncOrden(2);">Razon Social' . (($txtOrden == 2 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th style="width:100px;" class="thOrden" onclick="fncOrden(3);">Alias' . (($txtOrden == 3 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th style="width:150px;" class="thOrden" onclick="fncOrden(4);">Direccion' . (($txtOrden == 4 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th style="width:100px;" class="thOrden" onclick="fncOrden(5);">Direccion_Fiscal' . (($txtOrden == 5 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th style="width:120px;" class="thOrden" onclick="fncOrden(6);">Mail_Principal' . (($txtOrden == 6 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th style="width:100px;" class="thOrden" onclick="fncOrden(7);">Telefono' . (($txtOrden == 7 ? "<img class=" . $orden_class . " />" : "")) . '</th>';

    // $resultado.='<th ></th>';
    $resultado.='</tr>';

    $colspanFooter = 9;
    try {
        $cantidadMaxima = datos_generales::getCount($filtro);
        $dtDatos_generales = datos_generales::getGrid($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
        $rows = count($dtDatos_generales);

        foreach ($dtDatos_generales as $item) {
            $resultado.='<tr class="tr-item">';
            $resultado.='<td class="btnAction"><img title="Editar" src="/include/img/boton/edit_14x14.png" />&nbsp;<a onclick="fncEditar(' . $item['ID'] . ');">Editar</a></td>';
           
            $resultado.='<td class="tdCenter">' . $item['ruc'] . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextViewHtml($item['razon_social']) . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextViewHtml($item['alias']) . '</td>';
            $resultado.='<td class="tdLeft">' . FormatTextViewHtml($item['direccion']) . '</td>';
            $resultado.='<td class="tdCenter">' .FormatTextViewHtml($item['direccion_fiscal']) . '</td>';
            $resultado.='<td class="tdLeft">' . $item['mail_principal'] . '</td>';
            $resultado.='<td class="tdLeft">' . $item['telefono'] . '</td>';
            // $resultado.='<td></td>';
            $resultado.='</tr>';
        }

        $cantidadPaginas = '';


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

            $resultado.='<div  id=1 class="pagination pagination-ini" ><a title="Primero"><<</a></div>';
            $resultado.='<div id="' . ($paginaActual > 1 ? $paginaActual - 1 : $paginaActual) . '" class="pagination pagination-prev" ><a title="Anterior"><</a></div>';

            for ($i = $paginaInicio; $i <= $paginaFin; $i++) {
                if ($i == $paginaActual) {
                    $resultado.='<div class="pagination">' . $i . '</div>';
                } else {
                    $resultado.='<div id="' . $i . '" class="pagination"><a>' . $i . '</a></div>';
                }
            }

            $resultado.='<div id="' . ($paginaActual < $cantidadPaginas ? $paginaActual + 1 : $paginaActual) . '" class="pagination pagination-next" ><a title="Siguiente">></a></div>';
            $resultado.='<div id="' . $cantidadPaginas . '" class="pagination pagination-end" ><a title="Último">>></a></div>';

            $resultado.='</td></tr>';
        }

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

//muestra la ventana para agregar nuevo Datos Generales
function get_Datos_generales_Mantenimiento_Nuevo() {
    require ROOT_PATH . 'models/datos_generales.php';
    require ROOT_PATH . 'models/departamento.php';
    global $returnView_float;
    $returnView_float = true;
    $oDatos_generales = new datos_generales;


    $GLOBALS['dtDepartamento'] = departamento::getGrid();
    $GLOBALS['oDatos_generales'] = $oDatos_generales;
    $GLOBALS['departamento_ID'] = 0;
    $GLOBALS['provincia_ID'] = 0;
    $GLOBALS['distrito_ID'] = 0;
    $GLOBALS['mensaje'] = '';
}

//graba los datos que se recuperan por el metodo post en nuevo datos_generales
function post_Datos_generales_Mantenimiento_Nuevo() {
    require ROOT_PATH . 'models/datos_generales.php';
    require ROOT_PATH . 'models/departamento.php';
    global $returnView_float;
    $returnView_float = true;

    $ruc = $_POST['txtRuc'];
    $razon_social = $_POST['txtRazon_Social'];
    $alias = $_POST['txtAlias'];
    $direccion = $_POST['txtDireccion'];
    $direccion_fiscal = $_POST['txtDireccion_Fiscal'];
    $correlativo_guia = $_POST['txtCorrelativo_Guia'];
    $correlativo_factura = $_POST['txtCorrelativo_Factura'];
    $distrito_ID = $_POST['cboDistrito'];
    $logo_extension = $_POST['txtLogo_Extension'];
    $mail_principal = $_POST['txtMail_Principal'];
    $mail_info = $_POST['txtMail_Info'];
    $mail_venta = $_POST['txtMail_Venta'];
    $pagina_web = $_POST['txtPagina_Web'];
    $telefono = $_POST['txtTelefono'];
    $rpc = $_POST['txtRpc'];
    $rpm = $_POST['txtRpm'];
    $nextel = $_POST['txtNextel'];
    $otro_operador = $_POST['txtOtro_Operador'];
    $tipo_cambio = $_POST['txtTipo_Cambio'];
    $vigv = $_POST['txtVigv'];
    $observacion= $_POST['observacion'];

    $oDatos_generales = new datos_generales;

    try {
        $oDatos_generales->ruc = $ruc;
        $oDatos_generales->razon_social = $razon_social;
        $oDatos_generales->alias = $alias;
        $oDatos_generales->direccion = $direccion;
        $oDatos_generales->direccion_fiscal = $direccion_fiscal;
        $oDatos_generales->correlativo_guia = $correlativo_guia;
        $oDatos_generales->correlativo_factura = $correlativo_factura;
        $oDatos_generales->distrito_ID = $distrito_ID;
        $oDatos_generales->logo_extension = $logo_extension;
        $oDatos_generales->mail_principal = $mail_principal;
        $oDatos_generales->mail_info = $mail_info;
        $oDatos_generales->mail_venta = $mail_venta;
        $oDatos_generales->pagina_web = $pagina_web;
        $oDatos_generales->telefono = $telefono;
        $oDatos_generales->rpc = $rpc;
        $oDatos_generales->rpm = $rpm;
        $oDatos_generales->nextel = $nextel;
        $oDatos_generales->otro_operador = $otro_operador;
        $oDatos_generales->tipo_cambio = $tipo_cambio;
        $oDatos_generales->vigv = $vigv;
         $oDatos_generales->observacion = $observacion;

        $oDatos_generales->usuario_id = $_SESSION['usuario_ID'];

        $oDatos_generales->usuario_mod_id = $_SESSION['usuario_ID'];

        $oDatos_generales->insertar();
        $GLOBALS['resultado'] = 1;
        $GLOBALS['mensaje'] = $oDatos_generales->getMessage;
    } catch (Exception $ex) {
        $GLOBALS['resultado'] = -1;
        $GLOBALS['mensaje'] = $ex->getMessage();
    }
    $GLOBALS['dtDepartamento'] = departamento::getGrid();
    $GLOBALS['oDatos_generales'] = $oDatos_generales;
    $GLOBALS['departamento_ID'] = $_POST['cboDepartamento'];
    $GLOBALS['provincia_ID'] = $_POST['cboProvincia'];
}

//muestra la ventana editar Datos_generales
function get_Datos_generales_Mantenimiento_Editar($id) {
    require ROOT_PATH . 'models/datos_generales.php';
    require ROOT_PATH . 'models/departamento.php';
    require ROOT_PATH . 'models/provincia.php';
    require ROOT_PATH . 'models/distrito.php';


    global $returnView_float;
    $returnView_float = true;
    $oDatos_generales = datos_generales::getByID($id);

    if ($oDatos_generales == null) {
        $GLOBALS['resultado'] = -3;
        $GLOBALS['mensaje'] = 'Parecer que el registro ya fue eliminado.';
        return;
    }

    try {
        $oDistrito = distrito::getByID($oDatos_generales->distrito_ID);
        $oProvincia = provincia::getByID($oDistrito->provincia_ID);
        $oDepartamento = departamento::getByID($oProvincia->departamento_ID);

        $GLOBALS['dtDepartamento'] = departamento::getGrid();
        $GLOBALS['dtProvincia'] = provincia::getGrid("pv.departamento_ID=" . $oDepartamento->ID);
        $GLOBALS['dtDistrito'] = distrito::getGrid("dt.provincia_ID=" . $oProvincia->ID);


        $GLOBALS['oDatos_generales'] = $oDatos_generales;
        $GLOBALS['departamento_ID'] = $oDepartamento->ID;
        $GLOBALS['provincia_ID'] = $oProvincia->ID;
        $GLOBALS['distrito_ID'] = $oDistrito->ID;

        $GLOBALS['mensaje'] = '';
    } catch (Exception $ex) {
        $GLOBALS['mensaje'] = $ex->getMessage();
    }
}

//graba los datos que se recuperan por el metodo post en editar datos_generales
function post_Datos_generales_Mantenimiento_Editar($id) {
    require ROOT_PATH . 'models/datos_generales.php';
    require ROOT_PATH . 'models/departamento.php';
    require ROOT_PATH . 'models/provincia.php';
    require ROOT_PATH . 'models/distrito.php';


    global $returnView_float;
    $returnView_float = true;
    $oDatos_generales = datos_generales::getByID($id);

    if ($oDatos_generales == null) {
        $GLOBALS['resultado'] = -3;
        $GLOBALS['mensaje'] = 'Parecer que el registro ya fue eliminado.';
        return;
    }

    try {

        $ruc = $_POST['txtRuc'];
        $razon_social = FormatTextSave($_POST['txtRazon_Social']);
        $alias = FormatTextSave($_POST['txtAlias']);
        $direccion = FormatTextSave($_POST['txtDireccion']);
        $direccion_fiscal = FormatTextSave($_POST['txtDireccion_Fiscal']);
        $correlativo_guia = $_POST['txtCorrelativo_Guia'];
        $correlativo_factura = $_POST['txtCorrelativo_Factura'];
        $distrito_ID = $_POST['cboDistrito'];
        $logo_extension = $_POST['txtLogo_Extension'];
        $mail_principal = $_POST['txtMail_Principal'];
        $mail_info = $_POST['txtMail_Info'];
        $mail_venta = $_POST['txtMail_Venta'];
        $pagina_web = $_POST['txtPagina_Web'];
        $telefono = $_POST['txtTelefono'];
        $rpc = $_POST['txtRpc'];
        $rpm = $_POST['txtRpm'];
        $nextel = $_POST['txtNextel'];
        $otro_operador = $_POST['txtOtro_Operador'];
        $tipo_cambio = $_POST['txtTipo_Cambio'];
        $vigv = $_POST['txtVigv'];
        $observacion=  FormatTextSave($_POST['txtObservacion']);


        $oDatos_generales->ruc = $ruc;
        $oDatos_generales->razon_social = $razon_social;
        $oDatos_generales->alias = $alias;
        $oDatos_generales->direccion = $direccion;
        $oDatos_generales->direccion_fiscal = $direccion_fiscal;
        $oDatos_generales->correlativo_guia = $correlativo_guia;
        $oDatos_generales->correlativo_factura = $correlativo_factura;
        $oDatos_generales->distrito_ID = $distrito_ID;
        $oDatos_generales->logo_extension = $logo_extension;
        $oDatos_generales->mail_principal = $mail_principal;
        $oDatos_generales->mail_info = $mail_info;
        $oDatos_generales->mail_venta = $mail_venta;
        $oDatos_generales->pagina_web = $pagina_web;
        $oDatos_generales->telefono = $telefono;
        $oDatos_generales->rpc = $rpc;
        $oDatos_generales->rpm = $rpm;
        $oDatos_generales->nextel = $nextel;
        $oDatos_generales->otro_operador = $otro_operador;
        $oDatos_generales->tipo_cambio = $tipo_cambio;
        $oDatos_generales->vigv = $vigv;
        $oDatos_generales->observacion=$observacion;

        $oDatos_generales->usuario_mod_id = $_SESSION['usuario_ID'];

        if ($oDatos_generales->verificarDuplicado() > 0) {
            throw new Exception($oDatos_generales->getMessage);
        }

        $oDatos_generales->actualizar();


        $oDistrito = distrito::getByID($oDatos_generales->distrito_ID);
        $oProvincia = provincia::getByID($oDistrito->provincia_ID);
        $oDepartamento = departamento::getByID($oProvincia->departamento_ID);

        $GLOBALS['dtDepartamento'] = departamento::getGrid();
        $GLOBALS['dtProvincia'] = provincia::getGrid("pv.departamento_ID=" . $oDepartamento->ID);
        $GLOBALS['dtDistrito'] = distrito::getGrid("dt.provincia_ID=" . $oProvincia->ID);

        $GLOBALS['oDatos_generales'] = $oDatos_generales;
        $GLOBALS['departamento_ID'] = $oDepartamento->ID;
        $GLOBALS['provincia_ID'] = $oProvincia->ID;
        $GLOBALS['distrito_ID'] = $oDistrito->ID;

        $GLOBALS['mensaje'] = $oDatos_generales->message;
        $GLOBALS['resultado'] = 1;
    } catch (Exception $ex) {
        $GLOBALS['resultado'] = -1;
        $GLOBALS['mensaje'] = $ex->getMessage();
    }
}

//eliminar datos generales
function post_ajaxDatos_generales_Mantenimiento_Eliminar($id) {
    require ROOT_PATH . 'models/datos_generales.php';

    try {
        $oDatos_generales = datos_generales::getByID($id);
        $oDatos_generales->usuario_mod_id = $_SESSION['usuario_ID'];
        if ($oDatos_generales == null) {
            throw new Exception('Parece que el registro ya fue eliminado.');
        }

        if ($oDatos_generales->eliminar() == -1) {
            throw new Exception($oDatos_generales->message);
        }

        $resultado = 1;
        $mensaje = $oDatos_generales->message;
        $funcion = '';
    } catch (Exception $ex) {
        $resultado = -1;
        $mensaje = $ex->getMessage();
        $funcion = '';
    }

    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje, 'funcion' => $funcion);

    echo json_encode($retornar);
}
function get_Numero_Cuenta_Mantenimiento_Nuevo() {
    require ROOT_PATH . 'models/numero_cuenta.php';
    require ROOT_PATH . 'models/moneda.php';
    global $returnView_float;
    $returnView_float = true;
    $oNumero_Cuenta=new numero_cuenta();
   
    $dtMoneda=moneda::getGrid('',-1,-1,'ID desc');
    $oNumero_Cuenta->dtMoneda=$dtMoneda;
    $GLOBALS['oNumero_Cuenta'] = $oNumero_Cuenta;
    $GLOBALS['mensaje']='';
}
function post_Numero_Cuenta_Mantenimiento_Nuevo() {
    require ROOT_PATH . 'models/numero_cuenta.php';
    require ROOT_PATH . 'models/moneda.php';
    global $returnView_float;
    $returnView_float = true;
    $nombre_banco=$_POST['txtNombre_Banco'];
    $numero=$_POST['txtNumero'];
    $cci=$_POST['txtCci'];
    $moneda_ID=$_POST['selMoneda_ID'];
    $oNumero_Cuenta=new numero_cuenta();
    
   try {
       $oNumero_Cuenta->nombre_banco=$nombre_banco;
       $oNumero_Cuenta->numero=$numero;
       $oNumero_Cuenta->cci=$cci;
       $oNumero_Cuenta->moneda_ID=$moneda_ID;
       $oNumero_Cuenta->usuario_id=$_SESSION['usuario_ID'];
       $oNumero_Cuenta->insertar1();
       $resultado=1;
       $mensaje=$oNumero_Cuenta->getMessage;
   }catch(Exception $ex){
        $resultado = -1;
        $mensaje = $ex->getMessage();
       
   }
    $dtMoneda=moneda::getGrid('',-1,-1,'ID desc');
    $oNumero_Cuenta->dtMoneda=$dtMoneda;
    $GLOBALS['oNumero_Cuenta'] = $oNumero_Cuenta;
    $GLOBALS['mensaje']=$mensaje;
    $GLOBALS['resultado']=$resultado;
}
function get_Numero_Cuenta_Mantenimiento_Editar($id) {
    require ROOT_PATH . 'models/numero_cuenta.php';
    require ROOT_PATH . 'models/moneda.php';
    global $returnView_float;
    $returnView_float = true;
    $oNumero_Cuenta=numero_cuenta::getByID($id);
   
    $dtMoneda=moneda::getGrid('',-1,-1,'ID desc');
    $oNumero_Cuenta->dtMoneda=$dtMoneda;
    $GLOBALS['oNumero_Cuenta'] = $oNumero_Cuenta;
    $GLOBALS['mensaje']='';
}
function post_Numero_Cuenta_Mantenimiento_Editar($id) {
    require ROOT_PATH . 'models/numero_cuenta.php';
    require ROOT_PATH . 'models/moneda.php';
    global $returnView_float;
    $returnView_float = true;
    $nombre_banco=$_POST['txtNombre_Banco'];
    $numero=$_POST['txtNumero'];
    $cci=$_POST['txtCci'];
    $moneda_ID=$_POST['selMoneda_ID'];
    $oNumero_Cuenta=numero_cuenta::getByID($id);
    
   try {
       $oNumero_Cuenta->nombre_banco=$nombre_banco;
       $oNumero_Cuenta->numero=$numero;
       $oNumero_Cuenta->cci=$cci;
       $oNumero_Cuenta->moneda_ID=$moneda_ID;
       $oNumero_Cuenta->usuario_mod_id=$_SESSION['usuario_ID'];
       $oNumero_Cuenta->actualizar1();
       $resultado=1;
       $mensaje=$oNumero_Cuenta->getMessage;
   }catch(Exception $ex){
        $resultado = -1;
        $mensaje = $ex->getMessage();
       
   }
    $dtMoneda=moneda::getGrid('',-1,-1,'ID desc');
    $oNumero_Cuenta->dtMoneda=$dtMoneda;
    $GLOBALS['oNumero_Cuenta'] = $oNumero_Cuenta;
    $GLOBALS['mensaje']=$mensaje;
    $GLOBALS['resultado']=$resultado;
}
function post_ajaxNumero_Cuenta_Mantenimiento() {
    require ROOT_PATH . 'models/numero_cuenta.php';
    require ROOT_PATH . 'models/moneda.php';
    require ROOT_PATH . 'controls/funcionController.php';
    $buscar = $_POST['txtBuscar'];
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
            $orden = 'nombre_banco ' . $orden_tipo;
            break;
        case 2:
            $orden = 'numero ' . $orden_tipo;
            break;
        case 3:
            $orden = 'cci ' . $orden_tipo;
            break;
        case 4:
            $orden = 'moneda_ID ' . $orden_tipo;
            break;
        default:
            $orden = 'ID ' . $orden_tipo;
            break;
    }
    $filtro = '(numero) like "%' . str_replace(' ', '%', strtoupper(FormatTextSave($buscar))) . '%"';

    //---------------------------------------					 
    $resultado = '<table id="websendeos" class="grid table table-hover table-bordered"><tr>';
    $resultado.='<th class="text-center">N°</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(1);">Banco' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(2);">numero cuenta' . (($txtOrden == 2 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(3);">Cuenta Interbancaria' . (($txtOrden == 3 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="thOrden" onclick="fncOrden(4);">Moneda' . (($txtOrden == 4 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th class="tdCenter">Opciones</th>';
    $resultado.='</tr>';
    $colspanFooter = 6;
    try {
        
        $cantidadMaxima = numero_cuenta::getCount($filtro);
        $dtNumero_Cuenta = numero_cuenta::getGrid($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
        $rows = count($dtNumero_Cuenta);
        $i=($paginaActual-1)*$cantidadMostrar+1;
        foreach ($dtNumero_Cuenta as $item) {
            $oMoneda=moneda::getByID($item['moneda_ID']);
            $resultado.='<tr class="tr-item">';
            $resultado.='<td class="text-center">'.$i.'</td>';
            $resultado.='<td class="tdleft">' . test_input($item['nombre_banco']). '</td>';
            $resultado.='<td class="tdLeft">' . test_input($item['numero']). '</td>';
            $resultado.='<td class="tdLeft">' . test_input($item['cci']). '</td>';
            $resultado.='<td class="tdLeft">' . utf8_encode($oMoneda->descripcion). '</td>';
            $botones=array();
            array_push($botones,'<a onclick="fncEditar(' . $item['ID'] . ');" title="Editar numero de cuenta"><span class="glyphicon glyphicon-pencil"></span>Editar</a>');
            array_push($botones,'<a onclick="modal.confirmacion(&#39;El proceso es irreversible, esta seguro de eliminar el registro.&#39;,&#39;Eliminar numero de cuenta&#39;,fncEliminar,&#39;' . $item['ID'] . '&#39;);" title="Eliminar numero de cuenta"><span class="glyphicon glyphicon-trash"></span>Eliminar</a>');
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
function post_ajaxNumero_Cuenta_Mantenimiento_Eliminar($id) {
    require ROOT_PATH . 'models/numero_cuenta.php';
    require ROOT_PATH . 'models/cotizacion_numero_cuenta.php';
    require ROOT_PATH . 'models/salida_numero_cuenta.php';
    try {
        $oNumero_Cuenta = numero_cuenta::getByID($id);
        $oNumero_Cuenta->usuario_mod_id = $_SESSION['usuario_ID'];
        if ($oNumero_Cuenta == null) {
            throw new Exception('Parece que el registro ya fue eliminado.');
        }
        $dtCotizacion_Numero_Cuenta=cotizacion_numero_cuenta::getGrid('numero_cuenta_ID='.$id);
        if(count($dtCotizacion_Numero_Cuenta)>0){
             throw new Exception('La cuenta tiene registro en las cotizaciones');
        }
        $dtSalida_Numero_Cuenta=salida_numero_cuenta::getGrid('numero_cuenta_ID='.$id);
        if(count($dtSalida_Numero_Cuenta)>0){
            Throw new Exception('La cuenta tiene registro en salida');
        }
        if ($oNumero_Cuenta->eliminar() == -1) {
            throw new Exception($oNumero_Cuenta->getMessage);
        }

        $resultado = 1;
        $mensaje = $oNumero_Cuenta->getMessage;
        $funcion = '';
    } catch (Exception $ex) {
        $resultado = -1;
        $mensaje = $ex->getMessage();
        $funcion = '';
    }

    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje, 'funcion' => $funcion);

    echo json_encode($retornar);
}








//--------------Inicio de Serie------------------------//
//-----------------------------------------------------//





//inicio mantenimiento serie
function get_Serie_Mantenimiento() {
    global $returnView;
    $returnView = true;
}

//muestra la ventana para agregar nueva serie
function get_Serie_Mantenimiento_Nuevo() {
    require ROOT_PATH . 'models/serie.php';
    require ROOT_PATH . 'models/comprobante_tipo.php';
    global $returnView_float;
    $returnView_float = true;
    
    $oSerie = new serie();
    $dtComprobante_tipo=comprobante_tipo::getGrid();
    $oSerie->dtComprobante_tipo=$dtComprobante_tipo;
    
    $GLOBALS['oSerie'] = $oSerie;
    $GLOBALS['mensaje'] = '';
}

//graba los datos que se recuperan por el metodo post en nueva serie
function post_Serie_Mantenimiento_Nuevo() {
    require ROOT_PATH . 'models/serie.php';
    require ROOT_PATH . 'models/comprobante_tipo.php';
    global $returnView_float;
    $returnView_float = true;

    $nombre = $_POST['txtNombre'];
    $descripcion = $_POST['txtDescripcion'];
    $comprobante_tipo_ID=$_POST['selComprobante_Tipo'];

    $oSerie = new serie;

    try {
        $oSerie->nombre = trim($nombre);
        $oSerie->descripcion = $descripcion;
        $oSerie->comprobante_tipo_ID=$comprobante_tipo_ID;
        $oSerie->usuario_id = $_SESSION['usuario_ID'];

         if ($oSerie->verificarDuplicado() > 0) {
              throw new Exception($oSerie->message);             
        } 
       $oSerie->insertar();
        $GLOBALS['resultado'] = 1;
        $GLOBALS['mensaje'] = $oSerie->message;
		
    } catch (Exception $ex) {
        $GLOBALS['resultado'] = -1;
        $GLOBALS['mensaje'] = $ex->getMessage();
    }
   $dtComprobante_tipo=comprobante_tipo::getGrid();
    $oSerie->dtComprobante_tipo=$dtComprobante_tipo;
    
    $GLOBALS['oSerie'] = $oSerie;
//    $GLOBALS['mensaje']=$mensaje;
//    $GLOBALS['resultado']=$resultado;
}

//muestra la ventana editar categoria
function get_Serie_Mantenimiento_Editar($id) {
    require ROOT_PATH . 'models/serie.php';
    require ROOT_PATH . 'models/comprobante_tipo.php';
    global $returnView_float;
    $returnView_float = true;
    
    $oSerie = serie::getByID($id);
    $dtComprobante_tipo=comprobante_tipo::getGrid();
    $oSerie->dtComprobante_tipo=$dtComprobante_tipo;
    
    $GLOBALS['oSerie'] = $oSerie;
 $GLOBALS['dtComprobante_tipo']=$dtComprobante_tipo;
    $GLOBALS['mensaje'] = '';
}

//graba los datos que se recuperan por el metodo post en editar categoria
function post_Serie_Mantenimiento_Editar($id) {
    require ROOT_PATH . 'models/serie.php';
    require ROOT_PATH . 'models/comprobante_tipo.php';

    global $returnView_float;
    $returnView_float = true;
    $oSerie = serie::getByID($id);

    try {
        $nombre = $_POST['txtNombre'];
        $descripcion = $_POST['txtDescripcion'];
        $comprobante_tipo_ID=$_POST['selComprobante_Tipo'];
//     $oSerie = new serie;
        $oSerie->nombre = trim($nombre);
        $oSerie->descripcion = $descripcion;
        $oSerie->comprobante_tipo_ID=$comprobante_tipo_ID;
        $oSerie->usuario_mod_id = $_SESSION['usuario_ID'];
         if ($oSerie->verificarDuplicado() > 0) {
              throw new Exception($oSerie->message);             
        }  else {
                $oSerie->actualizar();
                $GLOBALS['resultado'] = 1;
                $GLOBALS['mensaje']=$oSerie->message;
        }
        
              
    } catch (Exception $ex) {
        $GLOBALS['resultado'] = -1;
        $GLOBALS['mensaje'] = $ex->getMessage();
    }
	
   $dtComprobante_tipo=comprobante_tipo::getGrid();
    $oSerie->dtComprobante_tipo=$dtComprobante_tipo;
    
    $GLOBALS['oSerie'] = $oSerie;
}

//muestra la grilla cargada con datos de serie,trabaja con ajax



function post_ajaxSerie_Mantenimiento() {
    require ROOT_PATH . 'models/serie.php';
    require ROOT_PATH . 'models/comprobante_tipo.php';
    require ROOT_PATH . 'controls/funcionController.php';
    $buscar = trim($_POST['txtBuscar']);
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
        case 0:
            $orden = 'se.ID ' . $orden_tipo;
            break;
        case 1:
            $orden = 'se.nombre ' . $orden_tipo;
            break;
        case 2:
            $orden = 'ct.nombre ' . $orden_tipo;
            break;
        default:
            $orden = 'se.ID ' . $orden_tipo;
            break;
    }
    
    $filtro= 'upper(se.nombre) like "%' . str_replace(' ', '%', strtoupper(FormatTextSave($buscar))) . '%"';

    //---------------------------------------					 
    $resultado = '<table id="websendeos" class="grid table table-hover" ><tr>';
    $resultado.='<th  class="thOrden" onclick="fncOrden(0);">Código' . (($txtOrden == 0 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th  class="thOrden" onclick="fncOrden(1);">Serie' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th  class="thOrden" onclick="fncOrden(2);">Comprobante_Tipo' . (($txtOrden == 2 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th>Opción</th>';
    $resultado.='</tr>';

    $colspanFooter = 4;
    try {
        $cantidadMaxima = serie::getCount($filtro);
        
        $dtSerie = serie::getGrid($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
        $rows = count($dtSerie);
        $i=1;
        foreach ($dtSerie as $item) {
            
            $resultado.='<tr class="tr-item">';
            $resultado.='<td class="tdCenter">' . sprintf("%'.06d",$item['ID'])  . '</td>';
            $resultado.='<td class="tdLeft">' . utf8_encode(strtoupper($item['nombre'])) . '</td>';
            $resultado.='<td class="tdLeft">' . utf8_encode(strtoupper($item['comprobante_tipo'])) . '</td>';
            $botones=array();
            array_push($botones,'<a onclick="fncEditar(' . $item['ID'] . ');" ><span class="glyphicon glyphicon-pencil" title="Editar serie"> Editar</a>');	
            array_push($botones,'<a onclick="modal.confirmacion(&#39;El proceso es irreversible, esta seguro de eliminar el registro.&#39;,&#39;Eliminar Serie&#39;,fncEliminar,&#39;' . $item['ID'] . '&#39;);" title="Eliminar serie"><span class="glyphicon glyphicon-trash">Eliminar</a>');
            $resultado.='<td class="btnAction" >'.extraerOpcion($botones)."</td>";
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




//Mantenimiento para los correlativos
//muestra la ventana editar categoria
function get_Correlativos_Mantenimiento() {
    require ROOT_PATH . 'models/correlativos.php';
    require ROOT_PATH . 'models/comprobante_tipo.php';
    global $returnView;
    $returnView = true;
    //$dtCorrelativos=correlativos::getGrid();
    
    //$GLOBALS['dtCorrelativos'] = $dtCorrelativos;
//    $GLOBALS['dtComprobante_tipo']=$dtComprobante_tipo;
   
}
function post_ajaxCorrelativos_Mantenimiento() {
    require ROOT_PATH . 'models/correlativos.php';
    require ROOT_PATH . 'controls/funcionController.php';
    //$buscar = trim($_POST['txtBuscar']);
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
        case 0:
            $orden = 'co.ID ' . $orden_tipo;
            break;
        case 1:
            $orden = 'co.serie ' . $orden_tipo;
            break;
        case 2:
            $orden = 'co.ultimo_numero ' . $orden_tipo;
            break;
        case 3:
            $orden = 'co.electronico ' . $orden_tipo;
            break;
        case 3:
            $orden = 'tc.nombre ' . $orden_tipo;
            break;
        default:
            $orden = 'co.ID ' . $orden_tipo;
            break;
    }
    
    $filtro= 'co.empresa_ID=' . $_SESSION['empresa_ID'];

    //---------------------------------------					 
    $resultado = '<table id="websendeos" class="grid table table-bordered table-hover table-teal"><thead><tr>';
    $resultado.='<th  class="thOrden" onclick="fncOrden(0);">Nro.' . (($txtOrden == 0 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th  class="thOrden" onclick="fncOrden(1);">Serie' . (($txtOrden == 1 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th  class="thOrden" onclick="fncOrden(2);">Ultimo número' . (($txtOrden == 2 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th  class="thOrden" onclick="fncOrden(3);">Electrónico' . (($txtOrden == 3 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th  class="thOrden" onclick="fncOrden(4);">Comprobante' . (($txtOrden == 4 ? "<img class=" . $orden_class . " />" : "")) . '</th>';
    $resultado.='<th></th>';
    $resultado.='</tr></thead>';
    $resultado.='<tbody>';
    $colspanFooter = 6;
    try {
        $cantidadMaxima = count(correlativos::getTabla($filtro));
        
        $dtCorrelativos = correlativos::getTabla($filtro, (($paginaActual * $cantidadMostrar) - ($cantidadMostrar)), $cantidadMostrar, $orden);
        $rows = count($dtCorrelativos);
        $i=($paginaActual-1)*$cantidadMostrar+1;
        foreach ($dtCorrelativos as $item) {
            
            $resultado.='<tr class="tr-item">';
            $resultado.='<td class="text-center">' . $i  . '</td>';
            $resultado.='<td class="text-left">' . $item['serie'] . '</td>';
            $resultado.='<td class="text-center">' . utf8_encode($item['ultimo_numero']) . '</td>';
            $resultado.='<td class="text-center">' . (($item['electronico']==1)?'SI':'NO') . '</td>';
            $resultado.='<td class="tdLeft">' . utf8_encode($item['comprobante']) . '</td>';
            $botones=array();
            array_push($botones,'<a onclick="fncEditar(' . $item['ID'] . ');" title="Editar" ><span class="glyphicon glyphicon-pencil"></span> Editar</a>');	
            array_push($botones,'<a onclick="modal.confirmacion(&#39;El proceso es irreversible, esta seguro de eliminar el registro.&#39;,&#39;Eliminar Serie&#39;,fncEliminar,&#39;' . $item['ID'] . '&#39;);" title="Eliminar serie"><span class="glyphicon glyphicon-trash"></span> Eliminar</a>');
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
function get_Correlativos_Mantenimiento_Editar($id) {
    
    require ROOT_PATH . 'models/correlativos.php';
    require ROOT_PATH . 'models/tipo_comprobante.php';
    global $returnView_float;
    $returnView_float = true;
    $dtTipo_Comprobante=tipo_comprobante::getGrid('',-1,-1,'nombre asc');
    $oCorrelativos=correlativos::getByID($id);
    $GLOBALS['oCorrelativos'] = $oCorrelativos;
    $GLOBALS['dtTipo_Comprobante']=$dtTipo_Comprobante;

}
function post_Correlativos_Mantenimiento_Editar($id) {
    require ROOT_PATH . 'models/correlativos.php';
    require ROOT_PATH . 'models/tipo_comprobante.php';
    require ROOT_PATH . 'models/tipo_comprobante_empresa.php';
    
    global $returnView_float;
    $returnView_float = true;
    $serie=$_POST['txtSerie'];
    $ultimo_numero=$_POST['txtUltimo_Numero'];
    $electronico=isset($_POST['ckElectronico'])?1:0;
    $tipo_comprobante_ID=$_POST['selTipoComprobante'];
    $accion=$_POST['selAccion'];
    try{
        $obj=correlativos::getByID($id);
        if(!isset($obj)){
            throw new Exception("No existe el objeto.");
        }
        $obj->serie=$serie;
        $obj->ultimo_numero=$ultimo_numero;
        $obj->electronico=$electronico;
        
        $obj->usuario_mod_id=$_SESSION['usuario_ID'];
        $obj->actualizar();
        $obj1=tipo_comprobante_empresa::getByID($obj->tipo_comprobante_empresa_ID);
        $obj1->accion=$accion;
        $obj1->tipo_comprobante_ID=$tipo_comprobante_ID;
        $obj1->usuario_mod_id=$_SESSION['usuario_ID'];
        $obj1->actualizar();
        $mensaje="Se actualizó correctamente";
        $resultado=1;
    }catch(Exception $ex){
        $mensaje=mensaje_error;
        $resultado=-1;
        log_error(__FILE__, "mantenimiento/post_Correlativos_Mantenimiento_Editar", $ex->getMessage());
    }
    $dtTipo_Comprobante=tipo_comprobante::getGrid('',-1,-1,'nombre asc');
    
    $GLOBALS['oCorrelativos'] = $obj;
    $GLOBALS['dtTipo_Comprobante']=$dtTipo_Comprobante;

    $GLOBALS['mensaje']=$mensaje;
    $GLOBALS['resultado']=$resultado;
//    $GLOBALS['dtComprobante_tipo']=$dtComprobante_tipo;
   
}
function get_Correlativos_Mantenimiento_Nuevo() {
    
    require ROOT_PATH . 'models/correlativos.php';
    require ROOT_PATH . 'models/tipo_comprobante.php';
    global $returnView_float;
    $returnView_float = true;
    $dtTipo_Comprobante=tipo_comprobante::getGrid('',-1,-1,'nombre asc');
    $oCorrelativos=new correlativos();
    $oCorrelativos->accion="0";
    $GLOBALS['oCorrelativos'] = $oCorrelativos;
    $GLOBALS['dtTipo_Comprobante']=$dtTipo_Comprobante;

}
function post_Correlativos_Mantenimiento_Nuevo($id) {
    require ROOT_PATH . 'models/correlativos.php';
    require ROOT_PATH . 'models/tipo_comprobante.php';
    require ROOT_PATH . 'models/tipo_comprobante_empresa.php';
    
    global $returnView_float;
    $returnView_float = true;
    $serie=$_POST['txtSerie'];
    $ultimo_numero=$_POST['txtUltimo_Numero'];
    $electronico=isset($_POST['ckElectronico'])?1:0;
    $tipo_comprobante_ID=$_POST['selTipoComprobante'];
    $accion=$_POST['selAccion'];
    try{
        
        $obj1=new tipo_comprobante_empresa();
        $obj1->accion=$accion;
        $obj1->tipo_comprobante_ID=$tipo_comprobante_ID;
        $obj1->empresa_ID=$_SESSION['empresa_ID'];
        $obj1->usuario_mod_id=$_SESSION['usuario_ID'];
        $tipo_comprobante_empresa_ID=$obj1->insertar();
        
        
        $obj=new correlativos();
        
        $obj->serie=$serie;
        $obj->ultimo_numero=$ultimo_numero;
        $obj->electronico=$electronico;
        $obj->tipo_comprobante_empresa_ID=$tipo_comprobante_empresa_ID;
        $obj->usuario_mod_id=$_SESSION['usuario_ID'];
        $obj->empresa_ID=$_SESSION['empresa_ID'];
        $obj->insertar();
        
        $mensaje="Se registró correctamente";
        $resultado=1;
    }catch(Exception $ex){
        $mensaje=mensaje_error;
        $resultado=-1;
        log_error(__FILE__, "mantenimiento/post_Correlativos_Mantenimiento_Nuevo", $ex->getMessage());
    }
    $dtTipo_Comprobante=tipo_comprobante::getGrid('',-1,-1,'nombre asc');
    
    $GLOBALS['oCorrelativos'] = $obj;
    $GLOBALS['dtTipo_Comprobante']=$dtTipo_Comprobante;

    $GLOBALS['mensaje']=$mensaje;
    $GLOBALS['resultado']=$resultado;
//    $GLOBALS['dtComprobante_tipo']=$dtComprobante_tipo;
   
}
function post_ajaxCorrelativos_Mantenimiento_Eliminar($id) {
    require ROOT_PATH . 'models/correlativos.php';
    require ROOT_PATH . 'models/tipo_comprobante_empresa.php';

    try {
        $obj = correlativos::getByID($id);
        $obj->usuario_mod_id = $_SESSION['usuario_ID'];
        
        if ($obj == null) {
            throw new Exception('Parece que el registro ya fue eliminado.');
        }

        if ($obj->eliminar() == -1) {
            throw new Exception($obj->getMessage);
        }
        
       $resultado = 1;
        $mensaje = $obj->getMessage;
        $funcion = '';
    } catch (Exception $ex) {
        $resultado = -1;
        $mensaje = mensaje_error;
        $funcion = '';
        log_error(__FILE__, "mantenimiento/ajaxCorrelativos_Mantenimiento_Eliminar", $ex->getMessage());
    }

    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje, 'funcion' => $funcion);

    echo json_encode($retornar);
}

function post_ajaxSerie_Mantenimiento_Eliminar($id) {
    require ROOT_PATH . 'models/serie.php';
    require ROOT_PATH . 'models/comprobante_tipo.php';

    try {
        $oSerie = serie::getByID($id);
        $oSerie->usuario_mod_id = $_SESSION['usuario_ID'];
        
        if ($oSerie == null) {
            throw new Exception('Parece que el registro ya fue eliminado.');
        }

        if ($oSerie->eliminar() == -1) {
        throw new Exception($oSerie->message);
        }
        
       $resultado = 1;
        $mensaje = $oSerie->message;
        $funcion = '';
    } catch (Exception $ex) {
        $resultado = -1;
        $mensaje = $ex->getMessage();
        $funcion = '';
    }

    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje, 'funcion' => $funcion);

    echo json_encode($retornar);
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

//graba los datos que se recuperan por el metodo post en editar categoria
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
        if ($oPersona->verificarDuplicado() > 0) {
              throw new Exception($oPersona->getMessage);             
        }  
        if($oPersona->insertar()>0){
            $oPersona_Documento=new persona_documento();
            $oPersona_Documento->persona_ID=$oPersona->ID;
            $oPersona_Documento->tipo_documento_ID=$tipo_documentop_ID;
            $oPersona_Documento->numero=$numero;
            $oPersona_Documento->usuario_id=$_SESSION['usuario_ID'];
            $oPersona_Documento->insertar();
        }
        
        $mensaje=$oPersona->getMessage;
        $resultado=1;
              
    } catch (Exception $ex) {
        $resultado= -1;
        $mensaje= $ex->getMessage();
    }
    $dtTipo_Documento=tipo_documento::getGrid("",-1,-1,"nombre asc");
    $dtDepartamento=departamento::getGrid("",-1,-1,"d.nombre asc");
    $dtProvincia=provincia::getGrid("departamento_ID=15",-1,-1,"nombre asc");
    $dtDistrito=distrito::getGrid("provincia_ID=129",-1,-1,"nombre asc");
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









