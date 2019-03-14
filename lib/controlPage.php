<?php
	session_start();
	require ROOT_PATH."lib/pathMVC.php";
	require ROOT_PATH."lib/function.php";
        require ROOT_PATH."models/connect_new.php";
        
	//require ROOT_PATH."models/connect.php";
        
	require ROOT_PATH."lib/settings.php";
	$config=json_decode(file_get_contents('lib/config.sm'),true);
	
	if(!isset($config)){
		echo "Error de configuraciòn";
		return;
	}
	
	$title='Sistema integrado de ventas';
	$head=null;
	$pageController='';
	$page='';	
	
	$controlador='';
	$vista='';	
	$id='';	
	
	//-----------------------------------------
	$method=strtolower($_SERVER['REQUEST_METHOD']);	
	$returnView=false;
	$returnView_float=false;	
	//------------------------------------
	
	pathMVC($controlador,$vista,$id);	
	
	if(!isset($_SESSION['user-autentication']))
	{
		$controlador='';
		$vista='';		
	}
	
	
	switch($controlador)
	{
		case '':	
                    //echo "aquiideed";
			$head=ROOT_PATH."lib/main_Head.php";
			$page=ROOT_PATH."lib/main.php";			
			
			$controlador='Acceso';
			$vista='Login';
			
			//verifico si el sistema me pide que me autentifique			
			if ($config['user-autentication'])			{
				if(isset($_SESSION['user-autentication']))
				{
                                    if(!class_exists('menu_usuario')){
                                        require ROOT_PATH . 'models/menu_usuario.php';
                                    }
                                   
                                    $dtUsuario_Empresa=menu_usuario::getGridUsuario_Empresa("mu.usuario_ID=".$_SESSION['usuario_ID'],-1,-1);
                                    
                                    if(count($dtUsuario_Empresa)>1){
                                        $_SESSION['contador']=3;
                                        $controlador='Home';
					$vista='Index';
                                    }else if(count($dtUsuario_Empresa)==1){
                                        $_SESSION['contador']=1;
                                        $controlador='Home';
					//$vista='Empresa_Modulos';
                                        $vista='Index';
                                        $_SESSION['empresa_ID']=$dtUsuario_Empresa[0]["ID"];
                                        
                                    }else{
                                        $_SESSION['contador']=0;
                                        $controlador='Home';
					$vista='Main1';
                                    }
					
					
					$pageController=ROOT_PATH.'controls/'.strtolower($controlador).'Controller.php';
					$page=ROOT_PATH.'views/'.strtolower($controlador).'/'.strtolower($vista).'.php';
                                       
				}else{
					$pageController=ROOT_PATH.'controls/'.strtolower($controlador).'Controller.php';
					$page=ROOT_PATH.'lib/login.php';
                                        
				}							
			}else{
				/*Configurar aquì la pàgina a la cual se redireccionará al usuario sin autentificación*/
			}							
			
			if (file_exists($pageController)) {
				require $pageController;
			}
			
			//Arma la función de acuerdo a la configuración de MVC
			if(function_exists ($method.'_'.$vista)){
                            
				call_user_func_array($method.'_'.$vista,array($id));						
			}else{
				$returnView=true;
			}
			
			//Si la accion llmada devuelve una página principal se ejecuta verificacón del fichero.
			if($returnView){		
				if (!file_exists($page)) {
					$title='Error';
					
					switch($controlador){
                                            default:
                                                    $GLOBALS['error']='error404';				
                                            break;
					}					
					$page=ROOT_PATH."error.php";
				}					
				require $page;
			}
			
			//Si la accion llmada devuelve una página flotante se ejecuta verificacón del fichero.
			if($returnView_float){		
				if (!file_exists($page)) {
					$title='Error';
					
					switch($controlador){
							default:
								$GLOBALS['error']='error404';				
							break;
					}					
					$page=ROOT_PATH."error_float.php";
				}					
				require $page;
			}
		break;	
		
		default:			
			if($vista=='')
			{
				$vista='index';
			}
                        
			//if(validar_menu($_SERVER["REQUEST_URI"])>0){
                        $pageController=ROOT_PATH.'controls/'.strtolower($controlador).'Controller.php';				
                        if(!isset($_SESSION['empresa_ID']) && $controlador!="home"){
                            if(!class_exists('empresa')){
                                require ROOT_PATH . 'models/empresa.php';
                            }
         
                            $dtEmpresa_Usuario=empresa::getEmpresaxUsuarioID($_SESSION['usuario_ID']);
                            $GLOBALS['dtEmpresa_Usuario']=$dtEmpresa_Usuario;
                            $vista="empresas";
                            $controlador="acceso";
                            $pageController=ROOT_PATH.'controls/'.strtolower($controlador).'Controller.php';
                            $page=ROOT_PATH.'lib/empresas.php';
                            require $page;
                            //$returnView=true;
                        } 
			if (file_exists($pageController)) {
				require $pageController;
			}
				
			//Arma la función de acuerdo a la configuración de MVC
			if(function_exists ($method.'_'.$vista)){
                           
                           
                            call_user_func_array($method.'_'.$vista,array($id));
										
			}else{
				$returnView=true;
			}
			
			//Si la accion lalmada devuelve una página pricipal se ejecuta verificacón del fichero.
			if($returnView){
                            if(isset($_SESSION['usuario_ID'])){
                                $nombre_fichero=ROOT_PATH.'views/'.strtolower($controlador).'/'.strtolower($vista).'.php';	
				if (file_exists($nombre_fichero)) {
                                    if(validar_menu($_SERVER["REQUEST_URI"])==0){
                                        $page=ROOT_PATH."error_seguridad.php";
                                    }else{
                                       
                                        $page=$nombre_fichero;	
                                    }
										
				} else {
					$title='Error';
					switch($controlador){
                                            default:
                                                    $GLOBALS['error']='error404';				
                                            break;
					}
					
					$page=ROOT_PATH."error.php";
				}	
				
                            }else{
                                $page=ROOT_PATH.'lib/login.php';
                            }
				require $page;
			}
			
			//Si la accion llmada devuelve una página flotante se ejecuta verificacón del fichero.
			if($returnView_float){
				$nombre_fichero=ROOT_PATH.'views/'.strtolower($controlador).'/'.strtolower($vista).'.php';	
				if (file_exists($nombre_fichero)) {
                                    $page=$nombre_fichero;
                                    
										
				} else {
					$title='Error';
					switch($controlador){
                                            default:
                                                    $GLOBALS['error']='error404';				
                                            break;
					}
					
					$page=ROOT_PATH."error_float.php";
				}				
				require $page;
			}
                       /* }else{
                            $page=ROOT_PATH."error_seguridad.php";
                            require $page;
                        }*/
			
	}
?>