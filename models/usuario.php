<?php
class usuario
{
	private $ID;
	private $password;
        private $nombre;
        private $persona_ID;	
        private $estado_ID;
        private $foto;
        private $correo;
	private $usuario_id;
        private $usuario_mod_id;	
	private $getMessage;
	private $dtEstado;
        private $dtPerfil;
        private $oPersona;
        private $dtEmpresa;
        private $dtModulo;
       
        
	public function __set($var, $valor)
	{
		// convierte a minúsculas toda una cadena la función strtolower
		$temporal = $var;
		
		// Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
		if (property_exists('usuario',$temporal))
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
		if (property_exists('usuario', $temporal))
		 {
			return $this->$temporal;
		 }
		 
		// Retorna nulo si no existe
		return null;
	}
	
	function insertar(){
		$cn =new connect();
		$retornar=-1;
		try{
                    $q='select ifnull(max(ID),0)+1 from usuario;';
                    $ID=$cn->getData($q);
                    $correo=(isset($this->correo))?$this->correo:"null";
                    $foto=(isset($this->foto))?$this->foto:"user-default.png";
                    $q='INSERT INTO usuario (ID,persona_ID,nombre,password,estado_ID,correo,foto,usuario_id) ';
                    $q.='VALUES ('.$ID.','.$this->persona_ID.',"'.$this->nombre.'","'.$this->password.'",'.$this->estado_ID.',"'.$correo.'","'.$foto.'",'.$this->usuario_id.');';
                    $retornar=$cn->transa($q);
                    $this->ID=$ID;
                    $this->getMessage='Se guardó correctamente';
                    return $retornar;
		}
		catch(Exception $ex){
			throw new Exception($q);
		}
	}	
	
	function actualizar(){
		$cn =new connect();
		$retornar=-1;
		try{
                    $correo=(isset($this->correo))?$this->correo:"null";
                    $foto=(isset($this->foto))?$this->foto:"user-default.png";
                    $q='UPDATE usuario  SET persona_ID='.$this->persona_ID.',nombre="'.$this->nombre.'",password="'.$this->password.'"';
                    $q.=',estado_ID='.$this->estado_ID.',correo="'.$correo.'",foto="'.$foto.'", usuario_mod_id='.$this->usuario_mod_id.', fdm=now()';
                    $q.=' WHERE ID='. $this->ID;
                    $retornar=$cn->transa($q);
                    //echo $q;
                    $this->getMessage='Se guardó correctamente';
                    return $retornar;
		}
		catch(Exception $ex){
			throw new Exception($q);
		}
	}		
	
	function eliminar(){
		$cn =new connect();
		$retornar=-1;
		try{
					
			$q='UPDATE usuario SET del=1,usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
			$q.=' WHERE ID='.$this->ID;
			
			$retornar=$cn->transa($q);
			
			$this->getMessage='Se eliminó correctamente';
			return $retornar;
		}
		catch(Exception $ex){
			throw new Exception("Ocurrio un Error en la consulta");
		}
	}
        
	static function validar($nombre,$contrasena)
	{
		$cn =new connect_new();
		try 
		{
			$q="Select ID,persona_ID,estado_ID,nombre,password,ifnull(foto,'') as foto from usuario ";
			$q.="where del=0 and nombre='".$nombre."' and password='".$contrasena."' and (estado_ID=45 or estado_ID=0)";
                        //echo $q;
			$dt=$cn->getGrid($q);			
			$usuario=null;
			
			foreach($dt as $item)
			{
					$usuario=new usuario();
					
					$usuario->ID=$item['ID'];
					$usuario->persona_ID=$item['persona_ID'];
					$usuario->estado_ID=$item['estado_ID'];
					$usuario->nombre=$item['nombre'];
                                        $usuario->foto=$item['foto'];
			}	
                        
			return $usuario;
				
		}catch(Exeption $ex)
		{
			throw new Exception("Ocurrio un Error en la consulta");
		}
	}
	
	static function getByID($ID)
	{
            $cn =new connect();
            try 
            {
                $q='Select ID,persona_ID,nombre,password,estado_ID,correo,ifnull(foto,"user-default.png") as foto,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id from usuario ';
                $q.='where ID='.$ID;
                //echo $q;
                $dt=$cn->getGrid($q);			
                $oUsuario=null;

                foreach($dt as $item)
                {
                    $oUsuario=new usuario();
                    $oUsuario->ID=$item['ID'];
                    $oUsuario->persona_ID=$item['persona_ID'];
                    $oUsuario->nombre=$item['nombre'];
                    $oUsuario->password=$item['password'];
                    $oUsuario->estado_ID=$item['estado_ID'];
                    $oUsuario->correo=$item['correo'];
                    $oUsuario->foto=$item['foto'];
                    $oUsuario->usuario_id=$item['usuario_id'];
                    $oUsuario->usuario_mod_id=$item['usuario_mod_id'];
                }			
                return $oUsuario;

            }catch(Exeption $ex)
            {
                    throw new Exception("Ocurrio un Error en la consulta");
            }
	}
	
function verificarDuplicado(){
    $cn =new connect();
    $retornar=-1;
    try{

        //Verifico que no se repita el prefijo
        $q='SELECT count(ID) FROM usuario';
        $q.=' WHERE del=0 and Upper(nombre)="'.strtoUpper($this->nombre).'"';		

        if($this->ID!=''){
            $q.=' and ID<>'.$this->ID;
        }

        $retornar=$cn->getData($q);			

        if ($retornar>0){
                $this->getMessage='Ya existe un usuario con el mismo nombre ';
                return $retornar;
        }
        $q='SELECT count(ID) FROM usuario';
        $q.=' WHERE del=0 and Upper(correo)="'.strtoUpper($this->correo).'"';	
        if($this->ID!=''){
            $q.=' and ID<>'.$this->ID;
        }
        $retornar=$cn->getData($q);			
        if ($retornar>0){
                $this->getMessage='Ya existe un usuario con el mismo correo ';
                return $retornar;
        }
       
        return $retornar;
    }
    catch(Exception $ex){
            throw new Exception("Ocurrio un Error en la consulta");
    }
}
	
	static function getCount($filtro='')
	{
		$cn =new connect();
		try 
		{
			$q='select count(u.ID) ';
			$q.=' FROM usuario as u,estado es,persona pe';
			$q.=' where u.del=0 and u.estado_ID=es.ID and u.persona_ID=pe.ID';
			
			if ($filtro!='')
			{
				$q.=' and '.$filtro;
			}
						
			$resultado=$cn->getData($q);									
		
			return $resultado;					
		}catch(Exception $ex)
		{
			throw new Exception($q);
		}
	} 
	
	static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='u.ID asc')
	{
            $cn =new connect();
            try 
            {
                $q='SELECT u.ID ,u.password,u.nombre as usuario,u.persona_ID,u.estado_ID,';
                $q.='es.nombre as estado,pe.apellido_paterno,pe.apellido_materno,pe.nombres';
                $q.=' FROM usuario as u, estado es,persona pe';
                $q.=' where u.del=0  and u.estado_ID=es.ID and u.persona_ID=pe.ID';

                $dt=$cn->getGrid($q);	

                if($filtro!=''){
                    $q.=' and '.$filtro;
                }

                $q.=' Order By '.$order;

                if($desde!=-1&&$hasta!=-1){
                    $q.=' Limit '.$desde.','.$hasta;
                }			
                //echo $q;
                $dt=$cn->getGrid($q);									
                return $dt;												
            }catch(Exception $ex)
            {
                    throw new Exception($q);
            }
	}
}

?>