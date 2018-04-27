<?php	
	function get_Login($id){
		global $returnView;
		$returnView=true;		
	}
	
	function post_Login(){
		require ROOT_PATH."lib/security.php";
		require ROOT_PATH."models/usuario.php"; 
                require ROOT_PATH . 'models/configuracion.php';
		if(!class_exists('menu_usuario')){
                    require ROOT_PATH . 'models/menu_usuario.php';
                }
		$resultado=0;
 		$mensaje='';
		$oSecurity=new security();
		
		if($oSecurity->login()){
                    try{
                        $nombre=$_POST['txtUsuario'];
                        $contrasena=$_POST['txtContrasena'];

                        $oUsuario=usuario::validar($nombre,$contrasena);

                        if($oUsuario){
                                $resultado=1;	
                                $_SESSION['user-autentication']=true;
                                $_SESSION['usuario_ID']=$oUsuario->ID;
                                $_SESSION['usuario_nombre']=$oUsuario->nombre;
                                $_SESSION['foto']=$oUsuario->foto;
                                $dtConfiguracion=configuracion::getGrid();
                                $_SESSION['configuracion']=$dtConfiguracion;
                        }else{
                                $mensaje='Usuario o contraseña inválidos';
                        }
                    }catch(Exception $ex){
                            $resultado=0;
                            $mensaje=$ex->getMessage();
                    }	
			
		}else{
			$mensaje=$oSecurity->message;	
		}
		
		$retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);

		echo json_encode($retornar);
	}
	
	function post_Logout(){		 			
 			unset($_SESSION['user-autentication']);
 			session_destroy();
			$resultado=0;
			$mensaje='';
			
			$retornar=Array('resultado'=>$resultado,'mensaje'=>$mensaje);
			echo json_encode($retornar);
	}
?>