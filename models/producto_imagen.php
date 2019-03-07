<?php
class producto_imagen
{
	private $ID;
        private $nombre;
	private $ruta;
        private $producto_ID;
        private $orden;
     	private $usuario_id;	
	private $usuario_mod_id;	
	private $getMessage;
		
	public function __set($var, $valor)
	{
		// convierte a minúsculas toda una cadena la función strtolower
		$temporal = $var;
		
		// Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
		if (property_exists('producto_imagen',$temporal))
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
		if (property_exists('producto_imagen', $temporal))
		 {
			return $this->$temporal;
		 }
		 
		// Retorna nulo si no existe
		return null;
	}
        function insertar() {
            $cn = new connect_new();
            $retornar = -1;
            try {

                $q = 'select ifnull(max(ID),0)+1 from producto_imagen;';
                $ID=$cn->getData($q);
                //$cn->transa($q);
                $q = 'insert into producto_imagen(ID,producto_ID,nombre,ruta,orden,usuario_id)';
                $q.='values('.$ID.','.$this->producto_ID.',"' . $this->nombre . '","' . $this->ruta. '",'.
                       $this->orden.',' . $this->usuario_id .')';

               // echo $q;
                $retornar = $cn->transa($q);


                $this->ID = $ID;
                $this->getMessage = 'Se guardó correctamente';
                return $retornar;
            } catch (Exception $ex) {

                throw new Exception($q);
            }
        }

        function actualizar() {
            $cn = new connect_new();
            $retornar = -1;
            try {
                $q = 'update producto_imagen set producto_ID='.$this->producto_ID.', nombre="' . $this->nombre . '",ruta="' . $this->ruta. '",orden=';
                $q.=$this->orden. ',usuario_mod_id=' . $this->usuario_mod_id;
                $q.=', fdm=now() where del=0 and id=' . $this->ID;
                //echo $q;
                $retornar = $cn->transa($q);
                $this->getMessage = 'Se guardó correctamente';
                return $retornar;
            } catch (Exception $ex) {

            }
        }
        function eliminar() {
            $cn = new connect_new();
            $retornar = -1;
            try {

                $q = 'UPDATE producto_imagen SET del=1,usuario_mod_id=' . $this->usuario_mod_id . ', fdm=Now()';
                $q.=' WHERE del=0 and ID=' . $this->ID;
                //echo $q;
                $retornar = $cn->transa($q);

                $this->getMessage = 'Se eliminó correctamente';
                return $retornar;
            } catch (Exception $ex) {
                throw new Exception("Ocurrio un error en la consulta");
            }
        }
	static function getByID($ID)
	{
		$cn =new connect_new();
		try 
		{
			$q='Select ID,nombre,ruta,producto_ID,orden,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
			$q.=' from producto_imagen ';
			$q.=' where del=0 and ID='.$ID;
			//echo $q;
			$dt=$cn->getGrid($q);			
			$oProducto_Imagen=null;
			
			foreach($dt as $item)
			{
                            $oProducto_Imagen=new producto_imagen();

                            $oProducto_Imagen->ID=$item['ID'];
                            $oProducto_Imagen->nombre=$item['nombre'];
                            $oProducto_Imagen->ruta=$item['ruta'];
                            $oProducto_Imagen->producto_ID=$item['producto_ID'];
                            $oProducto_Imagen->orden=$item['orden'];
                            $oProducto_Imagen->usuario_id=$item['usuario_id'];
                            $oProducto_Imagen->usuario_mod_id=$item['usuario_mod_id'];
			}			
			return $oProducto_Imagen;
				
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
			$q.=' FROM producto_imagen';
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
			$q='SELECT ID,nombre,ruta,producto_ID,orden,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
			$q.=' FROM producto_imagen';
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
	static function getGrid1($filtro='',$desde=-1,$hasta=-1,$order='proi.ID asc')
	{
		$cn =new connect_new();
		try 
		{
			$q='select pro.ID, pro.nombre as producto, pro.descripcion as descripcion,proi.ruta ';
			$q.=' from producto_imagen proi,producto pro';
			$q.=' where proi.producto_ID=pro.ID and pro.del=0 and proi.del=0';
			
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