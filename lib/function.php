<?php 
        function cargarInformacion($empresa_ID){
            if(!class_exists("configuracion_empresa"))require ROOT_PATH."models/configuracion_empresa.php";
            //echo $empresa_ID.'oooooo';
            if($empresa_ID>0){
                //echo $_SESSION['empresa_ID'];

                if($empresa_ID!=1){
                    if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";
                    if(!class_exists('empresa'))require ROOT_PATH."models/empresa.php";
                    $oEmpresa=empresa::getByID($empresa_ID);
                    if($oEmpresa!=null){
                        $_COOKIE["color_documentos"]=$oEmpresa->color_documentos;

                    }
                    $oDatos_Generales=datos_generales::getByEmpresa();
                    if($oDatos_Generales!=null){
                        if(!defined('tipo_cambio'))define('tipo_cambio',$oDatos_Generales->tipo_cambio);

                        if(!defined('igv'))define('igv',$oDatos_Generales->vigv);
                        //define('datos_genetales_ID',1);
                        if(!defined('logo'))define('logo',ruta_archivo.'/imagenes/logo/'.$oDatos_Generales->imagen);
                        if(!defined('logo_documentos'))define('logo_documentos',ruta_archivo.'/imagenes/logo_comprobantes/'.$oDatos_Generales->logo_extension);
                        if(!defined('favicon'))define('favicon','/'.ruta_archivo.'/imagenes/favicon/'.$oDatos_Generales->favicon);
                        //define('logo',$oDatos_Generales->sitio_web.'/'.$oDatos_Generales->ruta.'/imagenes/logo/'.$oDatos_Generales->logo_extension);
                        if(!defined('razon_social'))define('razon_social',FormatTextView($oDatos_Generales->razon_social));
                        if(!defined('alias'))define('alias',FormatTextView($oDatos_Generales->alias));
                        if(!defined('stilo_fondo_tabs'))define('stilo_fondo_tabs',$oDatos_Generales->stilo_fondo_tabs);
                        if(!defined('stilo_fondo_boton'))define('stilo_fondo_boton',$oDatos_Generales->stilo_fondo_boton);
                        if(!defined('stilo_fondo_cabecera'))define('stilo_fondo_cabecera',$oDatos_Generales->stilo_fondo_cabecera);
                        //if(!defined('bd_largo_decimal'))define('bd_largo_decimal',3);
                        $_COOKIE["stilo_fondo_cabecera"]=$oDatos_Generales->stilo_fondo_cabecera;
                        $_COOKIE["stilo_fondo_boton"]=$oDatos_Generales->stilo_fondo_boton;
                        $_COOKIE["stilo_fondo_tabs"]=$oDatos_Generales->stilo_fondo_tabs;

                    }else{
                        $_COOKIE["stilo_fondo_cabecera"]="bg-facebook";
                        $_COOKIE["stilo_fondo_boton"]="bg-facebook";
                        $_COOKIE["stilo_fondo_tabs"]="bg-facebook";
                        /*if(!defined('stilo_fondo_tabs'))define('stilo_fondo_tabs',"bg-teal");
                        if(!defined('stilo_fondo_boton'))define('stilo_fondo_boton',"bg-teal");
                        if(!defined('stilo_fondo_cabecera'))define('stilo_fondo_cabecera',"bg-teal");*/
                    }

                }else{
                    $_COOKIE["stilo_fondo_cabecera"]="bg-facebook";
                    $_COOKIE["stilo_fondo_boton"]="bg-facebook";
                    $_COOKIE["stilo_fondo_tabs"]="bg-facebook";
                    /*if(!defined('stilo_fondo_tabs'))define('stilo_fondo_tabs',"bg-facebook");
                    if(!defined('stilo_fondo_boton'))define('stilo_fondo_boton',"bg-teal");
                    if(!defined('stilo_fondo_cabecera'))define('stilo_fondo_cabecera',"bg-facebook");*/

                }
                if(!class_exists('configuracion_empresa')){
                        require ROOT_PATH . 'models/configuracion_empresa.php';
                }
                
                $dtConfiguracion_Empresa=configuracion_empresa::getGrid("empresa_ID=".$empresa_ID);
               
                foreach($dtConfiguracion_Empresa as $config){
                    //$_SESSION[$config['nombre']]=$config['valor'];
                    if(!defined($config['nombre']))define($config['nombre'],$config['valor']);
                }
            }
        }
        function validar_menu($ruta){
            
           if(!class_exists("seguridad")){
                require ROOT_PATH . 'models/seguridad.php';
            }
            $enlace=explode("?", $ruta);
            $empresa_ID=0;
            if(count($enlace)>0){
                $ruta=$enlace[0];
                $empresa_ID=$_GET['empresa_ID'];
                
            }
           
            if($ruta=="/home/index"){
                $retorna=1;
            }else if($empresa_ID>0){
                cargarInformacion($empresa_ID);
                if($ruta=='/home/main/'.$empresa_ID){
                $retorna=1;
                
                }else{ 
                    $retorna=seguridad::getValidarMenuUsuario($_SESSION['usuario_ID'],$ruta);
                    $dtMenu=seguridad::getGridMenuUsuario($_SESSION['usuario_ID'],$ruta);
                    //echo '<script>window.onload=function(){document.getElementById("mod'.$dtMenu[0]['modulo_ID'].'").className="active";document.getElementById("menu'.$dtMenu[0]['ID'].'").className="active";}</script>';
                }
            }else{$retorna=1;}
            
            
            return $retorna;
        }
        function getMenu($ruta){
            if(!class_exists("seguridad")){
                require ROOT_PATH . 'models/seguridad.php';
            }
            $dtMenu=seguridad::getGridMenuUsuario($_SESSION['usuario_ID'],$ruta);
            RETURN $dtMenu;
        }
        function filtro($array,$key,$value)
	{		
		$nArray=Array();
		foreach($array as $item)
		{
                    if ($item[$key]==$value)
                    {
                            array_push($nArray,$item);
                    }
		}
		return $nArray;
	}
	
	function FormatTextSave($text){
                //$cn = new connect_new();
		$text=str_replace('"','""',$text);
                
                //$text= mysqli_real_escape_string($cn->connect_new,$text);
		//$text=mysql_real_escape_string(utf8_decode($text));
                //$text=utf8_encode($text);
		return $text;
	}
	function FormatTextSaveP($text){
		$text=mysql_real_escape_string($text);
		//$text=mysql_real_escape_string(utf8_decode($text));
                //$text=utf8_encode($text);
		return $text;
	}
	function FormatTextView($text){
		$text=str_replace('"','&quot;',$text);
		$text=htmlspecialchars($text);
		return $text;
	}
        function FormatTextViewPDF($text){
		$text=utf8_decode($text);
		$text=html_entity_decode($text);
                $text=str_replace("&#39;","'",$text);
		return $text;
	}
        function FormatTextXML($text){
		$text=preg_replace('/[\r\n|\n|\r]+/','&lt;',$text);
                $text=utf8_encode($text);
		return $text;
	}
	function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
          }	
	function FormatTextViewHtml($text){
		$text=str_replace('"','&quot;',$text);
		$text=($text=='')?'&nbsp;':$text;
		$text=utf8_decode($text);
		return $text;
	}
	function FormatTextViewXML($text){
                $text=trim($text);
		$text=str_replace('<','&lt;',$text);
		$text=str_replace('>','&gt;',$text);
                $text=str_replace('"','&quot;',$text);
                $text=str_replace('ˋ','&apos;',$text);
                $text=str_replace('&','&amp;',$text);
		$text=utf8_encode($text);
		return $text;
	}
	function FormatTextToDate($text,$format){
           //echo $text;
		$date = DateTime::createFromFormat('d/m/Y',$text);
               
		return $date->format($format);
	}
	function saltoLineHtml($str){
           return str_replace(array("\r\n", "\r", "\n"),"<br>", $str);
	}
	function nombremes($mes){
		 setlocale(LC_TIME, 'spanish');  
		 $nombre=strftime("%B",mktime(0, 0, 0, $mes, 1, 2000)); 
		 return $nombre;
	}
	
	function decimal_default($numero){
		 $numero=number_format($numero,2,'.','');
		 return $numero;
	}
        function enviarCorreo($fromName,$destinatario,$asunto,$cuerpo,$oDato_Genetales){
           require  'class.phpmailer.php';
           require 'class.smtp.php';
           //if(!class_exists("datos_generales"))require ROOT_PATH . 'models/datos_generales.php';
           //$oDatos_Generales=datos_generales::getByID(1);
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
            $mail->Body = str_replace("--n","<br>",utf8_decode($cuerpo)); // Mensaje a enviar.
            
            
            $exito = $mail->Send(); // Envía el correo.
            //if($exito){ echo 'El correo fue enviado correctamente.'; }else{ echo 'Hubo un problema. Contacta a un administrador.';} 
            if(!isset($exito)) {
                
            $mensaje= "Error al enviar el mensaje: " . $mail­>ErrorInfo;
            } else {
            $mensaje= "";
            }
           }catch (Exception $ex){
               $mensaje=$ex->getMessage();
           }
           return $mensaje;
        }
    function extraerOpcion($dtBotones){
       $html='<div class="btn-group">';
       $html.='<button type="button" class="btn btn-teal dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
       $html.='<i class="fa fa-cogs"></i>';
       $html.='</button>';
       $html.='<ul class="dropdown-menu pull-right">';
        foreach($dtBotones as $item){
            $html.='<li>'.$item.'</li>';
        }
       $html.'</ul>';
       $html.='</div>';
        /*$html='<div class="dropdown">
            <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" title="Seleccionar una opción" style="padding:2px 6px;">
            <span class="glyphicon glyphicon-cog"></span>
               
            </button>
            <ul class="dropdown-menu dropdown-menu-right" style="right:0;">';
                    foreach($dtBotones as $item){
                $html.='<li>'.$item.'</li>';
                    }
        $html.='</ul>
        </div> ';*/
        return $html;
    }
    function estiloTituloReporte(){
        $estiloTituloReporte = array(
            'font' => array(
                'name'      => 'Verdana',
                'bold'      => true,
                'italic'    => false,
                'strike'    => false,
                'size' =>12,
                'color'     => array(
                    'rgb' => '000000'
                )
            ),
            'fill' => array(
              'type'  => PHPExcel_Style_Fill::FILL_SOLID,
              'color' => array(
                    'rgb' => 'FFFFFF')
          ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_NONE
                )
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => TRUE
            )
        );
        return $estiloTituloReporte;
    }
    function estiloTituloColumna(){
        $estiloTituloColumnas = array(
            'font' => array(
                'name'  => 'Arial',
                'size' =>10,
                'bold'  => true,
                'color' => array(
                    'rgb' => 'FFFFFF'
                )
            ),
            'fill' => array(
                'type'  => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'rgb' => '4cae4c')
          
            ),
            'borders' => array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => '143860'
                    )
                ),
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
                    'color' => array(
                        'rgb' => '143860'
                    )
                )
            ),
            'alignment' =>  array(
                'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'wrap'      => TRUE
            )
        );
        return $estiloTituloColumnas;
    }
    function estiloInformacion(){
        $estiloInformacion = new PHPExcel_Style();
        $estiloInformacion->applyFromArray( array(
            'font' => array(
                'name'  => 'Arial',
                'size' =>10,
                'color' => array(
                    'rgb' => '000000'
                )
            ),
            'fill' => array(
          'type'  => PHPExcel_Style_Fill::FILL_SOLID,
          'color' => array(
                    'rgb' => 'ffffff')
          ),
            'borders' => array(
                'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
              'color' => array(
                      'rgb' => '3a2a47'
                    )
                )
            )
        )); 
        return $estiloInformacion;
    }
    function contructor_excel($dtReportes1,$oReportes,$titulo_cabecera,$subtitulo){
        require ROOT_PATH.'include/PHPExcel/Classes/PHPExcel.php';
        require ROOT_PATH.'include/Excel.php';
       $excel = new Excel($oReportes->nombre); 
       
       $excel->sheet('Worksheet', function (PHPExcel_Worksheet $sheet) use ($dtReportes1,$oReportes,$titulo_cabecera,$subtitulo)   
        {
           $cantidad_columna=count($titulo_cabecera);
            $abc="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $sheet->getStyle('A1:G1')->applyFromArray(estiloTituloReporte());
            $sheet->mergeCells('A1:'.$abc[$cantidad_columna].'1');
            $sheet->mergeCells('A2:'.$abc[$cantidad_columna].'2');
            $sheet->getStyle('A3:'.$abc[$cantidad_columna].'3')->applyFromArray(estiloTituloColumna());
            
            $title="";
            for($i=0;$i<=$cantidad_columna;$i++){
                //damos auto ancho de cada columna
                $sheet->getColumnDimension($abc[$i])->setAutoSize(true);
                
            }
            $y=1;
            $sheet->setCellValue('A1', test_input($oReportes->titulo));
            $sheet->setCellValue('A2', $subtitulo);
            $sheet->setCellValue('A3', 'Nº');
            while ($titulo_columna = current($titulo_cabecera)) {
                //$title.=key($titulo_cabecera);
                $sheet->setCellValue($abc[$y].'3', $titulo_columna);
                $y++;
                next($titulo_cabecera);
            }

            $row = 4;
            foreach($dtReportes1 as $avance){
                
                $sheet->setSharedStyle(estiloInformacion(), "A4:".$abc[$cantidad_columna].($row));
                $sheet->setCellValueByColumnAndRow(0, $row, $row-3);
                $z=1;
                foreach($titulo_cabecera as $key=>$values){
                    $sheet->setCellValueByColumnAndRow($z, $row, test_input($avance[$key]));
                    $z++;
                }
               
                $row++;
            }


        });
        $excel->download('xls');
        
    }
    function contructor_pdf_reporte($dtReportes,$oReportes,$titulo_cabecera,$subtitulo,$pagina,$array_ancho,$array_alineacion,$array_tipo){
       require ROOT_PATH . 'models/reportepdf.php';
       // if(!class_exists("reportes"))require ROOT_PATH . 'models/reportes.php';
       //require ('./controls/reportepdf.php');
       if($pagina=="vertical"){
            $pdf= new PDF1('P','mm','A4');
            $pdf->SetY(40);
            $pdf->SetFont('Arial','',10);
            $pdf->fecha_cabecera=date("d/m/Y");
       }else{
            $pdf= new PDF1('L','mm','A4');
            //$pdf->SetX(100);
            $pdf->SetFont('Arial','',10);
            $pdf->fecha_cabecera=date("d/m/Y");
       }
        
        $pdf->oReportes=$oReportes;
        $pdf->position=$pagina;
        $pdf->SetSubTitulo($subtitulo);
        $pdf->AliasNbPages();
        $pdf->AddPage();
        try{
            $pdf->SetFillColor(117,179,114);
            array_unshift($array_ancho,10);
            $pdf->SetWidths($array_ancho);
            $array_alineado_cabecera=array("C");
            $array_border=array(1);
            $array_color_fondo=array(true);
            $array_titulo=array(utf8_decode('N°'));
            
            while ($titulo_columna = current($titulo_cabecera)) {
                array_push($array_titulo, utf8_decode($titulo_columna));
                //$title.=key($titulo_cabecera);
                array_push($array_alineado_cabecera,"C");
                array_push($array_border,1);
                array_push($array_color_fondo,true);
                next($titulo_cabecera);
            }
            $pdf->SetAligns($array_alineado_cabecera);
            $pdf->SetBorde($array_border);
            $pdf->SetTextColor(255);
            $pdf->SetColorFondo($array_color_fondo);
            
            //$pdf->setXY(10,30);
           
            //,'Ruc',utf8_decode('Razón Social'),'Moneda','Sub Total','IGV','Total');
            $pdf->Row($array_titulo,8);
            $numero=1;
            array_unshift($array_alineacion,"C");
            foreach($dtReportes as $item){

                $pdf->SetTextColor(0);
                $pdf->SetWidths($array_ancho);
                $pdf->SetAligns($array_alineacion);
                $pdf->SetBorde($array_border);
               
                $array_color_cuerpo=array(false);
                $array=array($numero);//,$item['ruc'],FormatTextView($item['razon_social']),FormatTextView($item['moneda']),number_format($item['sub_total'],2,'.',','),number_format($item['igv'],2,'.',','),number_format($item['total'],2,'.',','));
                $i=0;
                array_unshift($array_tipo,"numero");
                
                foreach($titulo_cabecera as $key=>$values){
                    switch($array_tipo[$i]){
                        case "texto":
                            $valor= utf8_decode($item[$key]);
                            break;
                        case "moneda":
                            $valor=number_format($item[$key],2,'.',',');
                        break;
                        case "numero":
                             $valor=$item[$key];
                            break;
                            
                    }
                    $i++;
                    array_push($array, $valor);
                    array_push($array_color_cuerpo,false);
                }
                $pdf->SetColorFondo($array_color_cuerpo);
                $pdf->Row($array,8);
               $numero++;
            }
            $nombre_archivo='reporte'.$_SESSION['usuario_ID'].rand().'.pdf';
            $ruta=ruta_archivo.'/temp/pdf/'.$nombre_archivo;
        }catch(Exception $ex){
            log_error(__FILE__, "funtion/contructor_pdf_reporte", $ex->getMessage());
            $ruta="ERror-".$ex->getMessage();
            $ruta="";
        }
        
        $pdf->Output('F',$ruta);   
        return $ruta;
 
    }
    function console_log( $data ){
        echo '<script>';
        echo 'console.log('.  $data .')';
        echo '</script>';
      }
    function log_error($ruta,$identificador,$error){
        $nombre_archivo = "logs_errores.txt"; 
        
        file_exists($nombre_archivo);
        if($archivo = fopen($nombre_archivo, "a"))
        {
            $texto="============================ERROR====================================\r\n";
            $texto.="FECHA Y HORA: ".date("d m Y H:m:s")."\r\n";
            $texto.="RUTA: ".$ruta."\r\n";
            $texto.="METODO: ".$identificador."\r\n";
            $texto.="ERROR: ".$error."\r\n";
            fwrite($archivo,$texto);
            fclose($archivo);
        }
    }
    function retornar_filas_registros($parametro,$valores){
       $html='';
        switch($parametro){
           case "configuracion_correo_empresa":
               $array=explode('|',configuracion_correo_empresa);
               $array_correo=explode(';',$valores);
               for($i=0;$i<count($array);$i++){
                    $html.='<div class="form-group">';
                    $html.='<label class="control-label col-sm-4">'.utf8_encode($array[$i]).':</label>'; 
                    $html.='<div class="col-sm-8"><input type="email" class="form-control" onBlur="validar_correo(this);" value="'.((isset($array_correo[$i]))?$array_correo[$i]:"").'"></div>';   
                    $html.='</div>';
                    
               }
               break;
           case "configuracion_celular_empresa":
               $array=explode('|',configuracion_celular_empresa);
               $array_correo=explode('/',$valores);
               for($i=0;$i<count($array);$i++){
                    $html.='<div class="form-group">';
                    $html.='<label class="control-label col-sm-4">'.utf8_encode($array[$i]).':</label>'; 
                    $html.='<div class="col-sm-8"><input type="text" class="form-control int" onBlur="validar_celular(this);" value="'.((isset($array_correo[$i]))?$array_correo[$i]:"").'"></div>';   
                    $html.='</div>';
                    
               }
               break;
        }
        
        

        return $html;
    }
    
    function getCodigoQr($contenido,$grafico,$config){
        require ROOT_PATH . 'include/phpqrcode/qrlib.php';
        //require("include/phpqrcode/qrlib.php");
        $dir = ROOT_PATH.'temp/';
        if (!file_exists($dir))
        {
               mkdir($dir);
        }
        if($grafico=="qr"){
            $filename = $dir.'qrfactura.png';
            $tamaño = $config['size']; //Tamaño de Pixel
            $level = $config['align']; //Precisión Baja
            $framSize = $config['border']; //Tamaño en blanco
            //$contenido = $variable; 

            QRcode::png($contenido, $filename, $level, $tamaño, $framSize); 
           return $filename;
        }
        
        //echo '<img src="'.$dir.basename($filename).'" />';  

        


    }
    function hexToRgb($hex, $alpha = false) {
   $hex      = str_replace('#', '', $hex);
   $length   = strlen($hex);
   $rgb['r'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
   $rgb['g'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
   $rgb['b'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));
   if ( $alpha ) {
      $rgb['a'] = $alpha;
   }
   return $rgb;
}
function redimensionarJPEG ($origen, $destino, $ancho_max, $alto_max, $fijar) {

    $info_imagen= getimagesize($origen);
    $ancho=$info_imagen[0];
    $alto=$info_imagen[1];
    if ($ancho>=$alto)
    {
        $nuevo_alto= round($alto * $ancho_max / $ancho,0);
        $nuevo_ancho=$ancho_max;
    }
    else
    {
        $nuevo_ancho= round($ancho * $alto_max / $alto,0);
        $nuevo_alto=$alto_max;
    }
    switch ($fijar)
    {
        case "ancho":
            $nuevo_alto= round($alto * $ancho_max / $ancho,0);
            $nuevo_ancho=$ancho_max;
            break;
        case "alto":
            $nuevo_ancho= round($ancho * $alto_max / $alto,0);
            $nuevo_alto=$alto_max;
            break;
        default:
            $nuevo_ancho=$nuevo_ancho;
            $nuevo_alto=$nuevo_alto;
            break;
    }
    $imagen_nueva= imagecreatetruecolor($nuevo_ancho,$nuevo_alto);
    $imagen_vieja= imagecreatefromjpeg($origen);
    imagecopyresampled($imagen_nueva, $imagen_vieja, 0, 0, 0, 0,$nuevo_ancho, $nuevo_alto, $ancho, $alto);
    imagejpeg($imagen_nueva,$destino);
    imagedestroy($imagen_nueva);
    imagedestroy($imagen_vieja);
}
?>