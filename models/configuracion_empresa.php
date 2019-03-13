<?php
class configuracion_empresa
{
	private $ID;
        private $nombre;
	private $empresa_ID;
        private $valor;
        private $descripcion;
	private $usuario_id;	
        
	private $usuario_mod_id;	
	private $getMessage;
		
	public function __set($var, $valor)
	{
		// convierte a minúsculas toda una cadena la función strtolower
		$temporal = $var;
		
		// Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
		if (property_exists('configuracion_empresa',$temporal))
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
		if (property_exists('configuracion_empresa', $temporal))
		 {
			return $this->$temporal;
		 }
		 
		// Retorna nulo si no existe
		return null;
	}
	
	function insertar(){
		
		$retornar=-1;
		try{
                    $cn =new connect_new();
			$q='SET @maxrow:=(select ifnull(max(ID),0) from perfil);';
			$cn->transa($q);
			
			$q='INSERT INTO perfil (ID,nombre,usuario_id) ';
			$q.='VALUES ((select @maxrow:=@maxrow+1),"'.FormatTextSave($this->nombre).'",'.$this->usuario_id.');';
			
			$retornar=$cn->transa($q);
			
			$q='select max(ID) from perfil where usuario_id='.$this->usuario_id;
			$this->ID=$cn->getData($q);
			
			$this->message='Se guardó correctamente.';
			return $retornar;
		}
		catch(Exception $ex){
			throw new Exception("Ocurrio un Error en la consulta");
		}
	}	
function insertar1()
{
    $cn =new connect_new();
    try
    {
          $ID=$cn->store_procedure_transa(
              "sp_configuracion_empresa_Insert",
                array(
            "iID"=>0,
            "iempresa_ID"=>$this->empresa_ID,
            "ivalor"=>$this->valor,
            "inombre"=>$this->nombre,
            "idescripcion"=>$this->descripcion,
            "iusuario_id"=>$this->usuario_id,

        ),0);
          if($ID>0){
            $this->getMessage="El registro se guard? correctamente.";
            $this->ID=$ID;
            return $ID;
          } else {
              throw new Exception("No se registr?");
          }
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "configuracion_empresa.insertar", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
}
	function actualizar(){
		$cn =new connect_new();
		$retornar=-1;
		try{
					
			$q='UPDATE perfil SET nombre="'.FormatTextSave($this->nombre).'",usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
			$q.=' WHERE ID='.$this->ID;
			
			$retornar=$cn->transa($q);
			
			$this->message='Se guardó correctamente.';
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
					
			$q='UPDATE perfil SET del=1,usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
			$q.=' WHERE ID='.$this->ID;
			
			$retornar=$cn->transa($q);
			
			$this->message='Se eliminó correctamente.';
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
			$q='Select ID,nombre,empresa_ID,valor,usuario_id,ifnull(usuario_mod_id,0) as usuario_mod_id';
			$q.='from configuracion_empresa ';
			$q.='where ID='.$ID;
			
			$dt=$cn->getGrid($q);			
			$oConfiguracion_Empresa=null;
			
			foreach($dt as $item)
			{
                            $oConfiguracion_Empresa=new configuracion_empresa();					
                            $oConfiguracion_Empresa->ID=$item['ID'];
                            $oConfiguracion_Empresa->nombre=$item['nombre'];
                            $oConfiguracion_Empresa->empresa_ID=$item['empresa_ID'];
                            $oConfiguracion_Empresa->valor=$item['valor'];
                            $oConfiguracion_Empresa->usuario_id=$item['usuario_id'];
                            $oConfiguracion_Empresa->usuario_mod_id=$item['usuario_mod_id'];
			}			
			return $oConfiguracion_Empresa;
				
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
			$q.=' FROM configuracion_empresa';
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
			$q='Select ID,nombre,empresa_ID,valor,usuario_id,ifnull(usuario_mod_id,0) as usuario_mod_id';
			$q.=' FROM configuracion_empresa';
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