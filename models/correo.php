<?php
class correo
{
	private $ID;
	private $frontname;
	private $receptor;
        private $asunto;
        private $cuerpo;
        private $observacion;
        private $tabla;
        private $enviado;
        private $empresa_ID;
	private $usuario_id;	
	private $usuario_mod_id;	
	private $getMessage;
		
	public function __set($var, $valor)
	{
		// convierte a minúsculas toda una cadena la función strtolower
		$temporal = $var;
		
		// Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
		if (property_exists('correo',$temporal))
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
		if (property_exists('correo', $temporal))
		 {
			return $this->$temporal;
		 }
		 
		// Retorna nulo si no existe
		return null;
	}
	
	function insertar(){
            $cn =new connect_new();
            $retornar="";
            try{
                $q='select ifnull(max(ID),0)+1 from correo;';
                $ID=$cn->getData($q);

                $q='INSERT INTO correo (ID,frontname,receptor,asunto,cuerpo,observacion,tabla,enviado,empresa_ID,usuario_id)';
                $q.='VALUES ('.$ID.',"'.$this->frontname.'","'.$this->receptor.'","'.$this->asunto.'","'.$this->cuerpo.'"';
                $q.=',"'.$this->observacion.'","'.$this->tabla.'",'.$this->enviado.','.$this->empresa_ID.','.$this->usuario_id.');';
                //$retornar=$q;   
                $retornar=$cn->transa($q);
                $this->ID=$ID;
                $this->getMessage='Se guardó correctamente.';
                return $retornar;
            }
            catch(Exception $ex){
                    throw new Exception("Ocurrio un Error en la consulta");
            }
	}	
	
	function actualizar(){
		$cn =new connect_new();
		$retornar=-1;
		try{
					
			$q='UPDATE correo SET enviado='.$this->enviado;
			$q.=',usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
			$q.=' WHERE ID='.$this->ID;
			
			$retornar=$cn->transa($q);
			
			$this->getMessage='Se actualizó correctamente.';
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
					
			$q='UPDATE correo SET del=1,usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
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
			$q='Select ID,frontname,receptor,asunto,cuerpo,observacion,tabla,enviado,empresa_ID,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
			$q.=' from correo ';
			$q.=' where del=0 and ID='.$ID;
			//echo $q;
			$dt=$cn->getGrid($q);			
			$oCorreo=null;
			
			foreach($dt as $item)
			{
                            $oCorreo=new correo();

                            $oCorreo->ID=$item['ID'];
                            $oCorreo->frontname=$item['frontname'];
                            $oCorreo->receptor=$item['receptor'];
                            $oCorreo->asunto=$item['asunto'];
                            $oCorreo->cuerpo=$item['cuerpo'];
                            $oCorreo->observacion=$item['observacion'];
                            $oCorreo->tabla=$item['tabla'];
                            $oCorreo->enviado=$item['enviado'];
                            $oCorreo->empresa_ID=$item['empresa_ID'];
                           
                            $oCorreo->usuario_id=$item['usuario_id'];
                            $oCorreo->usuario_mod_id=$item['usuario_mod_id'];
			}			
			return $oCorreo;
				
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
                $q.=' FROM correo';
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
	
	static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='ID desc')
	{
            $cn =new connect_new();
            try 
            {
                    $q='select ID,frontname,receptor,asunto,cuerpo,observacion,tabla,enviado,empresa_ID,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
                    $q.=' FROM correo';
                    $q.=' where del=0 ';

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
	
	static function actualizarEnvio($ID)
	{
            $cn =new connect_new();
            try 
            {
                $q='update correo set enviado=1 where ID='.$ID;
              

                $resultado=$cn->transa($q);									

                return $resultado;					
            }catch(Exception $ex)
            {
                    throw new Exception($q);
            }
	} 
}

?>