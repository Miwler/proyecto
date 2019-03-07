<?php
class tipo
{
	private $ID;
	private $nombre;
	private $tabla;
        private $orden;
        private $codigo;
        private $usuario_id;
	private $getMessage;
		
	public function __set($var, $valor)
	{
		// convierte a minúsculas toda una cadena la función strtolower
		$temporal = $var;
		
		// Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
		if (property_exists('tipo',$temporal))
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
		if (property_exists('tipo', $temporal))
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
			$q='SET @maxrow:=(select ifnull(max(ID),0) from tipo_comprobante);';
			$cn->transa($q);
			
			$q='INSERT INTO tipo_comprobante(ID,documento_identidad_ID,en_venta,en_compra,codigo,nombre,con_igv,con_serie_numero,con_numero,usuario_id) ';
			$q.='VALUES ((select @maxrow:=@maxrow+1),'.$this->documento_identidad_ID.','.$this->en_venta.','.$this->en_compra.',';
			$q.='"'.FormatTextSave($this->codigo).'","'.FormatTextSave($this->nombre).'",'.$this->con_igv.','.$this->con_serie_numero.','.$this->con_numero.','.$this->usuario_id.');';
			
			$retornar=$cn->transa($q);
			
			$q='select max(ID) from comprobante_tipo where usuario_id='.$this->usuario_id;
			$this->ID=$cn->getData($q);
			
			$this->getMessage='Se guardó correctamente';
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
					
			$q='UPDATE comprobante_tipo SET documento_identidad_ID='.$this->documento_identidad_ID.',en_venta='.$this->en_venta.',';
			$q.='en_compra='.$this->en_compra.',codigo="'.FormatTextSave($this->codigo).'",nombre="'.FormatTextSave($this->nombre).'",con_igv='.$this->con_igv.',';
			$q.=' con_serie_numero='.$this->con_serie_numero.',con_numero='.$this->con_numero.',usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
			$q.=' WHERE ID='.$this->ID;
			
			$retornar=$cn->transa($q);
			
			$this->getMessage='Se guardó correctamente';
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
					
			$q='UPDATE comprobante_tipo SET del=1,usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
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
		$cn =new connect_new();
		try 
		{
			$q='Select ID,codigo,nombre,abreviatura,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
			$q.=' from tipo_comprobante ';
			$q.=' where ID='.$ID;
			
			$dt=$cn->getGrid($q);			
			$ocomprobante_tipo=null;
			
			foreach($dt as $item)
			{
				$ocomprobante_tipo=new tipo_comprobante();
				
				$ocomprobante_tipo->ID=$item['ID'];
				$ocomprobante_tipo->codigo=$item['codigo'];
				$ocomprobante_tipo->nombre=$item['nombre'];
				$ocomprobante_tipo->abreviatura=$item['abreviatura'];
				$ocomprobante_tipo->usuario_id=$item['usuario_id'];
				$ocomprobante_tipo->usuario_mod_id=$item['usuario_mod_id'];
			}			
			return $ocomprobante_tipo;
				
		}catch(Exeption $ex)
		{
			throw new Exception("Ocurrio un Error en la consulta");
		}
	}
	
	function verificarDuplicado(){
		$cn =new connect_new();
		$retornar=-1;
		try{
			
			//Verifico que no se repita el nombre
			$q='SELECT count(ID) FROM comprobante_tipo';
			$q.=' WHERE del=0 and Upper(nombre)="'.strtoUpper(FormatTextSave($this->nombre)).'"';		
			
			if($this->ID!=''){
				$q.=' and ID<>'.$this->ID;
			}
			
			$retornar=$cn->getData($q);			
			
			if ($retornar>0){
				$this->getMessage='Ya existe un tipo de comprobante con el mismo nombre.';
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
		$cn =new 	connect_new();
		try 
		{
			$q='select count(ct.ID) ';
			$q.=' FROM tipo_comprobante';
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
			$q='SELECT ID,nombre,tabla,orden,codigo,usuario_ID';
			$q.=' FROM tipo';
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