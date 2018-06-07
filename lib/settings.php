<?php
    
   
    //define('periodo_inicio',2015);
    //define('empresa_ID',2);
    if(isset($_SESSION['empresa_ID'])){
       if(!class_exists('configuracion_empresa')){
            require ROOT_PATH.'models/configuracion_empresa.php';
        }

        $dtConfiguracion_empresa=configuracion_empresa::getGrid("empresa_ID=".$_SESSION['empresa_ID']);
        foreach($dtConfiguracion_empresa as $valor){
            define($valor['nombre'],$valor['valor']);
        } 
    }
    
    
    //define('sitio_web',$oDatos_Generales->sitio_web);
    //define('pagina_web',$oDatos_Generales->pagina_web);
    //Cuentas donde llega las alertas
    define('color_menu_principal',"rgba(0, 0, 16, 0.8)");
    //define('mail_info',"miwler0081@gmail.com");
    //define('mail_chat_soporte',"miwler0081@gmail.com");
    
    //Información de la empresa
    
    //define('pagina_web',FormatTextView($oDatos_Generales->pagina_web));
    //define('quienes_somos',FormatTextView($oDatos_Generales->quienes_somos));
   // define('mision',FormatTextView($oDatos_Generales->mision));
    //define('vision',FormatTextView($oDatos_Generales->vision));
   
    //Configuración de chat
    //define('chat_inicio','SI');
    //define('chat_soporte','SI');
    //define('mostrar_chat_inicio','NO');
    /**/
        

?>