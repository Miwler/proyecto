<?php

getEnviarMail();
function getEnviarMail(){
    require_once ('../models/connect.php');
    
    require_once ('../models/correo.php');
    //require_once('../lib/function.php');
    $cn = new connect();
    $dtCorreo=correo::getGrid("enviado=0 and trim(receptor) <>''");
    try{
        foreach($dtCorreo as $item){
            if(enviarCorreo($item['frontname'],$item['receptor'],$item['asunto'],$item['cuerpo'],$item['empresa_ID'])==1){
                correo::actualizarEnvio($item['ID']);
                
                //echo $oCorreo->getMessage;
            }
            
           
        }
    }catch(Exception $ex){
        echo $ex->getMessage();
    }
    
   
    
}
function enviarCorreo($fromName,$destinatario,$asunto,$cuerpo,$empresa_ID){
    require_once('../lib/class.phpmailer.php');
    require_once('../lib/class.smtp.php');
    require_once ('../models/datos_generales.php');
    //if(!class_exists("datos_generales"))require ROOT_PATH . 'models/datos_generales.php';
    $oDatos_Generales=datos_generales::getByID1($empresa_ID);
    //echo $oDatos_Generales->servidorSMTP;
    $retorna=0;
    $mensaje="";
    try{
     $mail = new PHPMailer();

     //Luego tenemos que iniciar la validación por SMTP:
     $mail->IsSMTP();
     $mail->SMTPAuth = true;
     $mail->Host = $oDatos_Generales->servidorSMTP; // A RELLENAR. Aquí pondremos el SMTP a utilizar. Por ej. mail.midominio.com
     $mail->Username = $oDatos_Generales->mail_webmaster; // A RELLENAR. Email de la cuenta de correo. ej.info@midominio.com La cuenta de correo debe ser creada previamente. 
     $mail->Password = $oDatos_Generales->password_webmaster; // A RELLENAR. Aqui pondremos la contraseña de la cuenta de correo
     $mail->Port = $oDatos_Generales->puertoSMTP; // Puerto de conexión al servidor de envio. 
     $mail->From = $oDatos_Generales->mail_webmaster; // A RELLENARDesde donde enviamos (Para mostrar). Puede ser el mismo que el email creado previamente.
     $mail->FromName = utf8_decode($fromName); //A RELLENAR Nombre a mostrar del remitente. 
     $mail->AddAddress($destinatario); // Esta es la dirección a donde enviamos 
     $mail->IsHTML(true); // El correo se envía como HTML 
     $mail->Subject = utf8_decode($asunto); // Este es el titulo del email. 
     //$body = "Hola mundo. Esta es la primer línea "; 
     //$body .= "Aquí continuamos el mensaje"; 
     $mail->Body = str_replace("--n","<br>",html_entity_decode($cuerpo)); // Mensaje a enviar.


     $exito = $mail->Send(); // Envía el correo.
     //if($exito){ echo 'El correo fue enviado correctamente.'; }else{ echo 'Hubo un problema. Contacta a un administrador.';} 
     if(!isset($exito)) {

     $retorna=0;
     } else {
    $retorna=1;
     }
    }catch (Exception $ex){
        $retorna= -1;
        echo $ex->getMessage();
    }
    RETURN $retorna;
 }


