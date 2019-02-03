<?php	
    function get_Index($id){
        if(!class_exists('empresa')){
            require ROOT_PATH . 'models/empresa.php';
        }
         
        
        global $returnView;
        $returnView=true;
        
       
        $dtEmpresa_Usuario=empresa::getEmpresaxUsuarioID($_SESSION['usuario_ID']);
        
        //$dtDatos_Generales=datos_generales::getGrid();
        //$dtEmpresa=empresa::getGrid();
        /*Destruimos las sesiones*/
        $_SESSION['empresa_ID']=NULL;
        $_SESSION['empresa']=NULL;
        $_SESSION['logo']=NULL;
        $_SESSION['favicon']="default.ico";
        //$_SESSION['modulo']=  NULL;
        //$_SESSION['modulo_ID']=NULL;
        $GLOBALS['dtEmpresa_Usuario']=$dtEmpresa_Usuario;
        
        
    }
    /*
    function get_Empresa_Modulos(){
        if(!class_exists('modulo')){
            require ROOT_PATH . 'models/modulo.php';
        }
        if(!class_exists('empresa')){
            require ROOT_PATH . 'models/empresa.php';
        }
        if(!class_exists('datos_generales')){
            require ROOT_PATH . 'models/datos_generales.php';
        }
        if(!class_exists('modulo_empresa')){
            require ROOT_PATH . 'models/modulo_empresa.php';
        }
        if(!class_exists('menu_usuario')){
            require ROOT_PATH . 'models/menu_usuario.php';
        }
        if(!class_exists('configuracion_empresa')){
            require ROOT_PATH . 'models/configuracion_empresa.php';
        }
        global $returnView;
        $returnView=true;
        $id=$_SESSION['empresa_ID'];
        $dtConfiguracion_Empresa=configuracion_empresa::getGrid("empresa_ID=".$id);
        foreach($dtConfiguracion_Empresa as $config){
            $_SESSION[$config['nombre']]=$config['valor'];
        }
        $oEmpresa=empresa::getByID($id);
        $oDatos_Generales=datos_generales::getByID1($id);
        $favicon="default.ico";
        if($oDatos_Generales!=null){
            $favicon=$oDatos_Generales->favicon;
        }
        $dtUsuario_Empresa=menu_usuario::getGridUsuario_Empresa("mu.usuario_ID=".$_SESSION['usuario_ID'],-1,-1);
        
        $_SESSION['empresa_ID']=$id;
        $_SESSION['empresa']=  FormatTextView($oEmpresa->nombre);
        $_SESSION['dtUsuario_Empresa']=$dtUsuario_Empresa;
        //$_SESSION['logo']=$oDatos_Generales->logo_extension;
        $_SESSION['favicon']=$favicon;
        $_SESSION['tabs']=$oEmpresa->stilo_fondo_tabs;
        $_SESSION['boton']=$oEmpresa->stilo_fondo_boton;
        $_SESSION['cabecera']=$oEmpresa->stilo_fondo_cabecera;
        $total_modulo=count(modulo_empresa::getGridModulosUsuario("moe.empresa_ID=".$id. " and mu.usuario_ID=".$_SESSION['usuario_ID']))/4;
        //$total_modulo=ceil(modulo_empresa::getCount("moe.empresa_ID=".$id)/4);
        $html="";
        $y=0;
        for($i=0;$i<$total_modulo; $i++){
            $html.="<div class='row'>";
            $dtModulo_Empresa=modulo_empresa::getGridModulosUsuario("moe.empresa_ID=".$id. " and mu.usuario_ID=".$_SESSION['usuario_ID'],$y,4,"mo.orden asc");
            foreach($dtModulo_Empresa as $item){
                $html.="<div class='col-lg-3 col-md-3 col-sm-3 col-xs-12'>";
                $html.="<a class='modulo' title='".FormatTextView($item['nombre'])."' href='home/main/".$item['modulo_ID']."'>";
                $html.="<div><img src='../../include/img/modulo/".$item['imagen']."' alt=''/></div>";
                $html.=" <div><span>".FormatTextView($item['nombre'])."</span></div>";
                $html.="</a>";
                $html.="</div>";
            }
            $html.="</div>";
            $y=$y+4;
        } 
        $_SESSION['modulo']=  NULL;
        $_SESSION['modulo_ID']=NULL;
        //$GLOBALS['dtModulo']=$dtModulo_Empresa;
        $GLOBALS['html']=$html;
    }
    function get_Empresas_Modulos($id){
        if(!class_exists('modulo')){
            require ROOT_PATH . 'models/modulo.php';
        }
        if(!class_exists('empresa')){
            require ROOT_PATH . 'models/empresa.php';
        }
        if(!class_exists('datos_generales')){
            require ROOT_PATH . 'models/datos_generales.php';
        }
        if(!class_exists('modulo_empresa')){
            require ROOT_PATH . 'models/modulo_empresa.php';
        }
        if(!class_exists('menu_usuario')){
            require ROOT_PATH . 'models/menu_usuario.php';
        }
        if(!class_exists('configuracion_empresa')){
            require ROOT_PATH . 'models/configuracion_empresa.php';
        }
        global $returnView;
        $returnView=true;
        $oEmpresa=empresa::getByID($id);
        $oDatos_Generales=datos_generales::getByID1($id);
        $dtConfiguracion_Empresa=configuracion_empresa::getGrid("empresa_ID=".$id);
        foreach($dtConfiguracion_Empresa as $config){
            $_SESSION[$config['nombre']]=$config['valor'];
        }
        $favicon="default.ico";
        if($oDatos_Generales!=null){
            $favicon=$oDatos_Generales->favicon;
        }
        if($_SESSION['usuario_ID']>0){
            $dtUsuario_Empresa=menu_usuario::getGridUsuario_Empresa("mu.usuario_ID=".$_SESSION['usuario_ID'],-1,-1);
       
        }else{
        $dtUsuario_Empresa=empresa::getGrid("",-1,-1,"nombre asc");
        }
        $_SESSION['empresa_ID']=$id;
        $_SESSION['empresa']=  FormatTextView($oEmpresa->nombre);
        $_SESSION['dtUsuario_Empresa']=$dtUsuario_Empresa;
        //$_SESSION['logo']=$oDatos_Generales->logo_extension;
        $_SESSION['favicon']=$favicon;
        $_SESSION['tabs']=$oEmpresa->stilo_fondo_tabs;
        $_SESSION['boton']=$oEmpresa->stilo_fondo_boton;
        $_SESSION['cabecera']=$oEmpresa->stilo_fondo_cabecera;
        if($_SESSION['usuario_ID']>0){
            $total_modulo=Count(modulo_empresa::getGridModulosUsuario("moe.empresa_ID=".$id. " and mu.usuario_ID=".$_SESSION['usuario_ID']))/4;
        }else{
            $total_modulo=Count(modulo_empresa::getGrid("moe.empresa_ID=".$id))/4;
        }
        
        //$total_modulo=ceil(modulo_empresa::getCount("moe.empresa_ID=".$id)/4);
        $html="";
        $y=0;
        
        for($i=0;$i<$total_modulo; $i++){
            $html.="<div class='row'>";
            if($_SESSION['usuario_ID']>0){
                $dtModulo_Empresa=modulo_empresa::getGridModulosUsuario("moe.empresa_ID=".$id. " and mu.usuario_ID=".$_SESSION['usuario_ID'],$y,4,"mo.orden asc");
            }else{
                $dtModulo_Empresa=modulo_empresa::getGrid("moe.empresa_ID=".$id,$y,4,"mo.orden asc");
            }
            
            foreach($dtModulo_Empresa as $item){
                $html.="<div class='col-lg-3 col-md-3 col-sm-3 col-xs-12'>";
                $html.="<a class='modulo' title='".FormatTextView($item['nombre'])."' href='home/main/".$item['modulo_ID']."'>";
                $html.="<div><img src='../../include/img/modulo/".$item['imagen']."' alt=''/></div>";
                $html.=" <div><span>".FormatTextView($item['nombre'])."</span></div>";
                $html.="</a>";
                $html.="</div>";
            }
            $html.="</div>";
            $y=$y+4;
        } 
        $_SESSION['modulo']=  NULL;
        $_SESSION['modulo_ID']=NULL;
        //$GLOBALS['dtModulo']=$dtModulo_Empresa;
        $GLOBALS['html']=$html;
    }*/
    function get_Main($id){
        
        /*if(!class_exists('modulo')){
            require ROOT_PATH . 'models/modulo.php';
        }
        if(!class_exists('modulo_empresa')){
            require ROOT_PATH . 'models/modulo_empresa.php';
        }*/
        
        if(!class_exists('empresa')){
            require ROOT_PATH . 'models/empresa.php';
        }
        global $returnView;
        $returnView=true;
        
        $oEmpresa=empresa::getByID($id);
        $_SESSION['empresa_ID']=$id;
        //echo $_SESSION['empresa_ID'];
        $_SESSION['icono']=$oEmpresa->icono;
        $_SESSION['empresa']=  FormatTextView($oEmpresa->nombre);
        $_SESSION['tabs']=$oEmpresa->stilo_fondo_tabs;
        $_SESSION['boton']=$oEmpresa->stilo_fondo_boton;
        $_SESSION['cabecera']=$oEmpresa->stilo_fondo_cabecera;
        $_SESSION['dtEmpresa']=empresa::getEmpresaxUsuarioID($_SESSION['usuario_ID']);
        //cargarInformacion($id);
        /*if($_SESSION['usuario_ID']>0){
            $filtro="moe.empresa_ID=".$_SESSION['empresa_ID']." and mu.usuario_ID=".$_SESSION['usuario_ID'];
           
           $dtModulo_Empresa=modulo_empresa::getGridModulosUsuario($filtro,-1,-1,"mo.nombre asc");
        }else{
            $dtModulo_Empresa=modulo_empresa::getGrid("moe.empresa_ID=".$_SESSION['empresa_ID'],-1,-1,"mo.nombre asc");
        }*/
        
        //$oModulo=modulo::getByID($id);
        //$_SESSION['dtModulo_Empresa']=$dtModulo_Empresa;
        //$_SESSION['modulo']= $oModulo->nombre;
        //$_SESSION['color']=$oModulo->color;
        //$_SESSION['modulo_ID']=$id;
        //unset($_SESSION['menu_ID']);
        
    }
    function get_Main1(){
        global $returnView;
        $returnView=true;
    }
?>