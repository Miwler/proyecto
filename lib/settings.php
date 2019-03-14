<?php
    

    
    if(!class_exists('configuracion')){
            require ROOT_PATH.'models/configuracion.php';
        }

        $dtConfiguracion=configuracion::getGrid();
        foreach($dtConfiguracion as $valor){
            if(!defined($valor['nombre_identificador']))define($valor['nombre_identificador'],$valor['valores']);
        }

    define('color_menu_principal',"rgba(0, 0, 16, 0.8)");

    if(isset($_SESSION['empresa_ID'])){
        
       if(!class_exists('configuracion_empresa')){
            require ROOT_PATH.'models/configuracion_empresa.php';
        }
        
        cargarInformacion($_SESSION['empresa_ID']);
        $dtConfiguracion_empresa=configuracion_empresa::getGrid("empresa_ID=".$_SESSION['empresa_ID']);
        foreach($dtConfiguracion_empresa as $valor){
            if(!defined($valor['nombre']))define($valor['nombre'],$valor['valor']);
        } 
        
    }   

?>