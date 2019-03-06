<?php
class seguridad
{	
	private $getMessage;
		
	public function __set($var, $valor)
	{
		// convierte a minúsculas toda una cadena la función strtolower
		$temporal = $var;
		
		// Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
		if (property_exists('seguridad',$temporal))
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
		if (property_exists('seguridad', $temporal))
		 {
			return $this->$temporal;
		 }
		 
		// Retorna nulo si no existe
		return null;
	}
	
	static function getValidarMenuUsuario($usuario_ID,$ruta)
	{		
            $cn =new connect_new();
            try 
            {
                $q='select count(me.ID)';
                $q.=' from menu_usuario mu,menu me';
                $q.=' where mu.menu_ID=me.ID and me.del=0 and mu.del=0 and mu.usuario_ID='.$usuario_ID.' and upper(concat("/",me.url)) like upper("'.$ruta.'")';			
                //echo $q;
                $retorna=$cn->getData($q);									
                return $retorna;												
            }catch(Exception $ex)
            {
                    throw new Exception('Ocurrio un Error en la consulta');
            }
	}
        static function getGridMenuUsuario($usuario_ID,$ruta)
	{		
            $cn =new connect_new();
            try 
            {
                $q='select me.*';
                $q.=' from menu_usuario mu,menu me';
                $q.=' where mu.menu_ID=me.ID and me.del=0 and mu.del=0 and mu.usuario_ID='.$usuario_ID.' and upper(concat("/",me.url)) like upper("'.$ruta.'")';			
                //echo $q;
                $retorna=$cn->getGrid($q);									
                return $retorna;												
            }catch(Exception $ex)
            {
                    throw new Exception('Ocurrio un Error en la consulta');
            }
	}
        static function getValidarModuloUsuario($usuario_ID,$modulo_ID)
	{		
            $cn =new connect_new();
            try 
            {
                $q='select count(mo.ID)';
                $q.=' from menu me, menu_usuario mu,modulo mo';
                $q.=' where mu.menu_ID=me.ID and me.modulo_ID=mo.ID and me.del=0 and mo.del=0 and mu.del=0 and mu.usuario_ID='.$usuario_ID.' and mo.ID='.$modulo_ID;			
                //echo $q;
                $retorna=$cn->getData($q);									
                return $retorna;												
            }catch(Exception $ex)
            {
                    throw new Exception('Ocurrio un Error en la consulta');
            }
	}
}

?>