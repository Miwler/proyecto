<?php
class web_chat_session
{
	private $ID;
	private $nombre_visitante;
        private $email_visitante;
        private $usuario_remitente_ID;
        private $usuario_receptor_ID;
        private $fecha;
	private $session;
        private $estado_ID;
        private $empresa_ID;
	private $usuario_id;	
	private $usuario_mod_id;	
	private $getMessage;
	private $usuario_receptor;	
	public function __set($var, $valor)
	{
		// convierte a minúsculas toda una cadena la función strtolower
		$temporal = $var;
		
		// Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
		if (property_exists('web_chat_session',$temporal))
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
		if (property_exists('web_chat_session', $temporal))
		 {
			return $this->$temporal;
		 }
		 
		// Retorna nulo si no existe
		return null;
	}
	
	function insertar(){
            $cn =new connect_new();
            $retornar=-1;
            try{
                    $q='select ifnull(max(ID),0)+1 from web_chat_session';
                    $ID=$cn->getData($q);
                    
                    $q='INSERT INTO web_chat_session (ID,nombre_visitante,email_visitante,usuario_remitente_ID,usuario_receptor_ID,fecha,';
                    $q.='session,usuario_id) ';
                    $q.='VALUES ('.$ID.',"'.$this->nombre_visitante.'","'.$this->email_visitante.'",'.$this->usuario_remitente_ID.',';
                    $q.=$this->usuario_receptor_ID.',"'.$this->fecha.'","'.$this->session.'",'.$this->usuario_id.');';
                    //echo $q;
                    $retornar=$cn->transa($q);
                    $this->ID=$ID;
                    $this->getMessage='Se guardó correctamente.';
                    return $retornar;
            }
            catch(Exception $ex){
                    throw new Exception($q);
            }
	}	
	
	function actualizar(){
		$cn =new connect_new();
		$retornar=-1;
		try{
					
                    $q='UPDATE web_chat_session SET nombre_visitante="'.$this->nombre_visitante.'",email_visitante="'.$this->email_visitante.'",usuario_remitente_ID='.$this->usuario_remitente_ID.',';
                    $q.='usuario_receptor_ID='.$this->usuario_receptor_ID.',fecha="'.$this->fecha.'",empresa_ID='.$this->empresa_ID.',estado_ID='.$this->estado_ID.',usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
                    $q.=' WHERE ID='.$this->ID;

                    $retornar=$cn->transa($q);

                    $this->getMessage='Se guardó correctamente.';
                    return $retornar;
		}
		catch(Exception $ex){
			throw new Exception("Ocurrio un Error en la consulta");
		}
	}		
	
    function eliminar(){
		$cn =new connect_new();
		$retornar=-1;
		try{
					
			$q='UPDATE menu SET del=1,usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
			$q.=' WHERE ID='.$this->ID;
			
			$retornar=$cn->transa($q);
			
			$this->getMessage='Se eliminó correctamente.';
			return $retornar;
		}
		catch(Exception $ex){
			throw new Exception("Ocurrio un Error en la consulta");
		}
	}
	
	static function getByID($ID)
	{
            $cn =new connect_new();
            try 
            {
                $q='Select ID,nombre_visitante,email_visitante,usuario_remitente_ID,usuario_receptor_ID,';
                $q.='fecha,session,estado_ID,empresa_ID,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
                $q.=' from web_chat_session ';
                $q.=' where del=0 and ID='.$ID;
                //echo $q;
                $dt=$cn->getGrid($q);			
                $oWeb_Chat_Session=null;

                foreach($dt as $item)
                {
                    $oWeb_Chat_Session=new web_chat_session();
                    $oWeb_Chat_Session->ID=$item['ID'];
                    $oWeb_Chat_Session->nombre_visitante=$item['nombre_visitante'];
                    $oWeb_Chat_Session->email_visitante=$item['email_visitante'];
                    $oWeb_Chat_Session->usuario_remitente_ID=$item['usuario_remitente_ID'];
                    $oWeb_Chat_Session->usuario_receptor_ID=$item['usuario_receptor_ID'];
                    $oWeb_Chat_Session->fecha=$item['fecha'];
                    $oWeb_Chat_Session->session=$item['session'];
                    $oWeb_Chat_Session->estado_ID=$item['estado_ID'];
                    $oWeb_Chat_Session->empresa_ID=$item['empresa_ID'];
                    $oWeb_Chat_Session->usuario_id=$item['usuario_id'];
                    $oWeb_Chat_Session->usuario_mod_id=$item['usuario_mod_id'];
                }			
                return $oWeb_Chat_Session;

            }catch(Exeption $ex)
            {
                    throw new Exception("Ocurrio un Error en la consulta");
            }
	}
	
	
	static function getCount($filtro='')
	{
		$cn =new connect_new();
		try 
		{
			$q='select count(ID) ';
			$q.=' FROM web_chat_session';
			$q.=' where del=0 ';
			
			if ($filtro!='')
			{
                            $q.=' and '.$filtro;
			}
						
			$resultado=$cn->getData($q);									
		
			return $resultado;					
		}catch(Exception $ex)
		{
			throw new Exception("Ocurrio un Error en la consulta");
		}
	} 
	
	static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='ID asc')
	{
		$cn =new connect_new();
		try 
		{
                    $q='Select ID,nombre_visitante,email_visitante,usuario_remitente_ID,usuario_receptor_ID,';
                    $q.='fecha,session,estado_ID,empresa_ID,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
                    $q.=' from web_chat_session ';
                    $q.=' where del=0';

                    if($filtro!=''){
                            $q.=' and '.$filtro;
                    }

                    $q.=' Order By '.$order;

                    if($desde!=-1&&$hasta!=-1){
                            $q.=' Limit '.$desde.','.$hasta;
                    }			

                    $dt=$cn->getGrid($q);									
                    return $dt;												
		}catch(Exception $ex)
		{
			throw new Exception('Ocurrio un Error en la consulta');
		}
	}
	
	
}

?>