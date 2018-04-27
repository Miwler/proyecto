<?php
class usuario_empresa
{
	private $ID;
        private $usuario_ID;
        private $empresa_ID;
        private $perfil_ID;
        private $estado_ID;
        private $usuario_id_creacion;
        private $usuario_mod_id;
        private $getMessage;
	public function __set($var, $valor)
	{
		// convierte a minúsculas toda una cadena la función strtolower
		$temporal = $var;
		
		// Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
		if (property_exists('usuario_empresa',$temporal))
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
		if (property_exists('usuario_empresa', $temporal))
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
                    $q='select ifnull(max(ID),0)+1 from usuario_empresa;';
                    $ID=$cn->getData($q);
                    $q='INSERT INTO usuario (ID,usuario_ID,empresa_ID,perfil_ID,estado_ID,usuario_id_creacion) ';
                    $q.='VALUES ('.$ID.','.$this->usuario_ID.','.$this->empresa_ID.','.$this->perfil_ID.','.$this->estado_ID.','.$this->usuario_id_creacion.');';
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
                    $q='UPDATE usuario_empresa';
                    $q.='usuario_ID='.$this->usuario_ID.',';
                    $q.='empresa_ID='.$this->empresa_ID.',';
                    $q.='perfil_ID='.$this->perfil_ID.',';
                    $q.='estado_ID='.$this->estado_ID.',';
                    $q.='usuario_mod_id='.$this->usuario_mod_id.',';
                    $q.' fdm=now()';
                    $q.=' WHERE ID='. $this->ID;
                    $retornar=$cn->transa($q);
                   
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
					
			$q='UPDATE usuario_empresa SET del=1,usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
			$q.=' WHERE ID='.$this->ID;
			
			$retornar=$cn->transa($q);
			
			$this->getMessage='Se eliminó correctamente';
			return $retornar;
		}
		catch(Exception $ex){
			throw new Exception("Ocurrio un Error en la consulta");
		}
	}

	static function getByID($ID)
	{
		$cn =new connect();
		try 
		{
			$q='Select ID,usuario_ID,empresa_ID,perfil_ID,estado_ID,usuario_id_creacion from usuario_empresa ';
			$q.='where ID='.$ID;
			//echo $q;
			$dt=$cn->getGrid($q);			
			$oUsuario_Empresa=null;
			
			foreach($dt as $item)
			{
                            $oUsuario_Empresa=new usuario_empresa();
                            $oUsuario_Empresa->ID=$item['ID'];
                            $oUsuario_Empresa->usuario_ID=$item['usuario_ID'];
                            $oUsuario_Empresa->empresa_ID=$item['empresa_ID'];
                            $oUsuario_Empresa->perfil_ID=$item['perfil_ID'];
                            $oUsuario_Empresa->estado_ID=$item['estado_ID'];
                            $oUsuario_Empresa->usuario_id_creacion=$item['usuario_id_creacion'];
                            $oUsuario_Empresa->usuario_mod_id=$item['usuario_mod_id'];
	
										
			}			
			return $oUsuario_Empresa;
				
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
                $q='SELECT count(ID) FROM usuario_empresa';
                $q.=' WHERE del=0 and usuario_ID='.$this->usuario_ID.' and empresa_ID='.$this->empresa_ID.' and perfil_ID='.$this->perfil_ID;	

                if($this->ID!=''){
                    $q.=' and ID<>'.$this->ID;
                }

                $retornar=$cn->getData($q);			

                if ($retornar>0){
                        $this->getMessage='Ya existe un usuario con el perfil para la empresa';
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
			$q.=' from usuario_empresa ue,usuario u,perfil per';
			$q.=' where ue.usuario_ID=u.ID and ue.perfil_ID=per.ID and ue.del=0 and u.del=0 and per.del=0';
			
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
	
	static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='ue.ID asc')
	{
            $cn =new connect();
            try 
            {
                $q='SELECT *';
               
                $q.=' from usuario_empresa ue,usuario u,perfil per';
                $q.=' where ue.usuario_ID=u.ID and ue.perfil_ID=per.ID and ue.del=0 and u.del=0 and per.del=0';

                $dt=$cn->getGrid($q);	

                if($filtro!=''){
                        $q.=' and '.$filtro;
                }

                $q.=' Order By '.$order;

                if($desde!=-1&&$hasta!=-1){
                        $q.=' Limit '.$desde.','.$hasta;
                }			
                echo $q;
                $dt=$cn->getGrid($q);									
                return $dt;												
            }catch(Exception $ex)
            {
                    throw new Exception($q);
            }
	}
}

?>