<?php
$config=json_decode(file_get_contents(ROOT_PATH.'lib/config.sm'),true); 	
$login=$config['login'];

class security{			
	private $message;
	
	public function __set($var, $valor)
	{
		// convierte a minúsculas toda una cadena la función strtolower
		$temporal = $var;
		
		// Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
		if (property_exists('security',$temporal))
		 {
			$this->$temporal = $valor;
		 }
		 else
		 {
			echo $var . " No existe.";
		 }
	 }
	 
	 public function __get($var)
	 {
		$temporal = $var;
		
		// Verifica que exista
		if (property_exists('security', $temporal))
		 {
			return $this->$temporal;
		 }
		 
		// Retorna nulo si no existe
		return null;
	}
	
	 function login()
	{	
		$config=json_decode(file_get_contents(ROOT_PATH.'lib/config.sm'),true);
		$validate=true;
		
		if ($config['login']['captcha-enable']){
			/*Controla la fecha y hora en que intento ingresar*/
			if (!isset($_SESSION['fInicial']))
			{
				$_SESSION['fInicial']=new DateTime();
				$_SESSION['attempt']=0;
			}			
			
			$date2=new DateTime();
			$tTranscurrido=$date2->diff($_SESSION['fInicial']);

			/*Si el tiempo transcurrido es mayor al tiempo de espera se reinicia el contador y el control de fecha de intentos*/
			if ($config['login']['interval']<>"00:00:00" && $config['login']['interval']<=$tTranscurrido->format('%H:%I:%s'))
			{
				$_SESSION['attempt']=0;
				$_SESSION['fInicial']=new DateTime();			
			}
				
			if($config['login']['attempt']<>0 && $_SESSION['attempt']>$config['login']['attempt'])
			{
				$validate=false;	
				$this->message='Muchos intentos fallidos, vuelva a intentarlo en 5 minutios.';			
			}else{		
				$_SESSION['attempt']=$_SESSION['attempt']+1;
				
				
				if ($_POST['captcha']==$_SESSION['tmpCaptcha'])
				{
					$validate=true;	 				
				}else
				{
					$validate=false;	
					$this->message='Código captcha incorrecto.';
					return; 
				}				
			}
		}
		return $validate;
	}
}	
?>