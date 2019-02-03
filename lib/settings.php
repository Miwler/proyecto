<?php
    

    if(isset($_SESSION['empresa_ID'])){
       if(!class_exists('configuracion_empresa')){
            require ROOT_PATH.'models/configuracion_empresa.php';
        }

        $dtConfiguracion_empresa=configuracion_empresa::getGrid("empresa_ID=".$_SESSION['empresa_ID']);
        foreach($dtConfiguracion_empresa as $valor){
            define($valor['nombre'],$valor['valor']);
        } 
    }
    if(!class_exists('configuracion')){
            require ROOT_PATH.'models/configuracion.php';
        }

        $dtConfiguracion=configuracion::getGrid();
        foreach($dtConfiguracion as $valor){
            define($valor['nombre_identificador'],$valor['valores']);
        }

    define('color_menu_principal',"rgba(0, 0, 16, 0.8)");

        

?>