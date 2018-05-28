<?php 
function cargarInformacion($empresa_ID){
    //echo $empresa_ID.'oooooo';
    if(isset($_SESSION['empresa_ID'])){
        //echo $_SESSION['empresa_ID'];
        
        if($_SESSION['empresa_ID']!=1){
            if(!class_exists('datos_generales'))require ROOT_PATH."models/datos_generales.php";
           
            $oDatos_Generales=datos_generales::getByEmpresa();
            define('tipo_cambio',$oDatos_Generales->tipo_cambio);
            define('igv',$oDatos_Generales->vigv);
            //define('datos_genetales_ID',1);
            define('logo',$oDatos_Generales->sitio_web.'/'.$oDatos_Generales->ruta.'/imagenes/logo/'.$oDatos_Generales->logo_extension);
            define('favicon',$oDatos_Generales->sitio_web.'/'.$oDatos_Generales->ruta.'/imagenes/favicon/'.$oDatos_Generales->favicon);
            //define('logo',$oDatos_Generales->sitio_web.'/'.$oDatos_Generales->ruta.'/imagenes/logo/'.$oDatos_Generales->logo_extension);
            define('razon_social',FormatTextView($oDatos_Generales->razon_social));
            define('alias',FormatTextView($oDatos_Generales->alias));
        }
        if(!class_exists('configuracion_empresa')){
                require ROOT_PATH . 'models/configuracion_empresa.php';
        }
        
        $dtConfiguracion_Empresa=configuracion_empresa::getGrid("empresa_ID=".$_SESSION['empresa_ID']);
        foreach($dtConfiguracion_Empresa as $config){
            $_SESSION[$config['nombre']]=$config['valor'];
        }
    }
}
        function validar_menu($ruta){
           if(!class_exists("seguridad")){
                require ROOT_PATH . 'models/seguridad.php';
            }
            if($ruta=="/home/index"){
                $retorna=1;
            }else{
                cargarInformacion($_SESSION['empresa_ID']);
                if($ruta=='/home/main/'.$_SESSION['empresa_ID']){
                $retorna=1;
                
                }else{ 
                    $retorna=seguridad::getValidarMenuUsuario($_SESSION['usuario_ID'],$ruta);
                    $dtMenu=seguridad::getGridMenuUsuario($_SESSION['usuario_ID'],$ruta);
                    //echo '<script>window.onload=function(){document.getElementById("mod'.$dtMenu[0]['modulo_ID'].'").className="active";document.getElementById("menu'.$dtMenu[0]['ID'].'").className="active";}</script>';
                }
            }
            
            
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
		$text=str_replace('"','""',$text);
		//$text=mysql_real_escape_string(utf8_decode($text));
                $text=utf8_decode($text);
		return $text;
	}
	
	function FormatTextView($text){
		$text=str_replace('"','&quot;',$text);
		$text=htmlspecialchars(utf8_encode($text));
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
		$text=utf8_encode($text);
		return $text;
	}
	
	function FormatTextToDate($text,$format){	
		$date = DateTime::createFromFormat('d/m/Y',$text);
		return $date->format($format);
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
       $html.='<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
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
            $sheet->setCellValue('A1', utf8_encode($oReportes->titulo));
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
                    $sheet->setCellValueByColumnAndRow($z, $row, utf8_encode($avance[$key]));
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
        }catch(Exception $ex){
            $ruta="ERror-".$ex->getMessage();
        }
        $nombre_archivo='reporte'.$_SESSION['usuario_ID'].rand().'.pdf';
        $ruta='include/pdf/'.$nombre_archivo;
        $pdf->Output('F',$ruta);   
        return $ruta;
 
    }
    function console_log( $data ){
        echo '<script>';
        echo 'console.log('.  $data .')';
        echo '</script>';
      }
?>