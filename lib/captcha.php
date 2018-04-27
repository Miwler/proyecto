<?php
	
	session_start();
	header('Content-type:image/png');	
	$long=80; //longitud de la imagen
	$width=25; //ancho de la imagen
	$length = 5; //longitud de la cadena
	$size =15; //tamaño de la letra 
	$_SESSION['tmpCaptcha']=randomText($length);
	$captcha = imagecreate($long, $width) or die("Cannot Initialize new GD image stream"); 
	$background_color = imagecolorallocate($captcha, 248, 248, 248); 
	$colorText=imagecolorallocate($captcha,0,0,0);
	
	// Traza Lineas
	$lineText= imagecolorallocate($captcha, rand(0,255), rand(0,255), rand(0,255)); 
	imageline($captcha, rand(0,$long), rand(0,$width), rand(0,$long), rand(0,$width), $lineText);
	imageline($captcha, rand(0,$long), rand(0,$width), rand(0,$long), rand(0,$width), $lineText); 

	imagestring($captcha,5,18,5,$_SESSION['tmpCaptcha'],$colorText);

	imagepng($captcha);
	imagedestroy($captcha); 

	function randomText($length)
	{
		$pattern="1234567890abcdefghijklmnopqrstuvwxyz";
		$key="";
		for ($i=0;$i<$length; $i++)
		{
			$key.=$pattern{rand(0,35)};
		}
		return $key;
	}	
	
	
?>