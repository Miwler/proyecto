<?php

class menu
{
	private $ID;
        private $nombre;
        private $menu_ID;
	private $modulo_ID;
        private $descripcion;
	private $orden;
	private $url;	
	private $usuario_id;	
	private $usuario_mod_id;	
	private $getMessage;
        private $dtModulo;
        private $dtMenu_Padre;
		
	public function __set($var, $valor)
	{
		// convierte a minúsculas toda una cadena la función strtolower
		$temporal = $var;
		
		// Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
		if (property_exists('menu',$temporal))
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
		if (property_exists('menu', $temporal))
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
			$q='select ifnull(max(ID),0)+1 from menu;';
			$ID=$cn->getData($q);
			
			$q='INSERT INTO menu (ID,modulo_ID,menu_ID,orden,nombre,url,descripcion,usuario_id) ';
			$q.='VALUES ('.$ID.','.$this->modulo_ID.','.$this->menu_ID.','.$this->orden.',';
			$q.='"'.$this->nombre.'","'.$this->url.'","'.$this->descripcion.'",'.$this->usuario_id.');';
			
			$retornar=$cn->transa($q);
			
			
			$this->ID=$ID;
			
			$this->getMessage='Se guardó correctamente.';
			return $retornar;
		}
		catch(Exception $ex){
			throw new Exception("Ocurrió un Error en la consulta");
		}
	}	
	
	function actualizar(){
		$cn =new connect_new();
		$retornar=-1;
		try{
					
			$q='UPDATE menu SET modulo_ID='.$this->modulo_ID.',menu_ID='.$this->menu_ID.',orden='.$this->orden.',nombre="'.FormatTextSave($this->nombre).'",descripcion="'.FormatTextSave($this->descripcion).'",';;
			$q.='url="'.FormatTextSave($this->url).'",usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
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
			$q='Select ID,orden,modulo_ID,nombre,menu_ID,descripcion,url,usuario_id,ifnull(usuario_mod_id,0) as usuario_mod_id';
			$q.=' from menu ';
			$q.=' where ID='.$ID;
			
			$dt=$cn->getGrid($q);			
			$oMenu=null;
			
			foreach($dt as $item)
			{
                            $oMenu=new menu();

                            $oMenu->ID=$item['ID'];
                            $oMenu->modulo_ID=$item['modulo_ID'];
                            $oMenu->menu_ID=$item['menu_ID'];
                            $oMenu->orden=$item['orden'];
                            $oMenu->nombre=$item['nombre'];
                            $oMenu->descripcion=$item['descripcion'];
                            $oMenu->url=$item['url'];
                            $oMenu->usuario_id=$item['usuario_id'];
                            $oMenu->usuario_mod_id=$item['usuario_mod_id'];
			}			
			return $oMenu;
				
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
			$q='SELECT count(ID) FROM menu';
			$q.=' WHERE del=0 and Upper(nombre)="'.strtoUpper(FormatTextSave($this->nombre)).'"';		
			
			if($this->ID!=''){
                            $q.=' and ID<>'.$this->ID;
			}
			
			$retornar=$cn->getData($q);			
			
			if ($retornar>0){
				$this->getMessage='Ya existe un menu con el mismo nombre.';
				return $retornar;
			}
			
			//Verifico que no se repita la url
			$q='SELECT count(ID) FROM menu';
			$q.=' WHERE del=0 and Upper(url)="'.strtoUpper(FormatTextSave($this->url)).'"';		
			
			if($this->ID!=''){
				$q.=' and ID<>'.$this->ID;
			}
			
			$retornar=$cn->getData($q);			
			
			if ($retornar>0){
				$this->getMessage='Ya existe un menu con la misma url.';
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
		$cn =new connect_new();
		try 
		{
			$q='select count(mn.ID) ';
			$q.=' FROM menu as mn,modulo as m';
			$q.=' where mn.del=0  and m.ID=mn.modulo_ID';
			
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
	
	static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='mn.ID asc')
	{
		$cn =new connect_new();
		try 
		{
			$q='SELECT mn.ID,ifnull(mn.menu_ID,0) as menu_ID,mn.modulo_ID,mn.orden,m.nombre as modulo,mn.nombre,mn.url,mn.usuario_id,ifnull(mn.usuario_mod_id,-1) as usuario_mod_id';
			$q.=' FROM menu as mn,modulo as m';
			$q.=' where mn.del=0 and m.ID=mn.modulo_ID';
			
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
	
	static function getMenuxUsuarioID($usuario_id,$modulo_ID)
	{		
		$cn =new connect_new();
		try 
		{
			$q='select me.ID,mu.menu_ID,me.modulo_ID,me.orden,me.nombre,me.url,me.usuario_id,ifnull(me.usuario_mod_id,-1) as usuario_mod_id';
			$q.=' from menu as me,  menu_usuario mu,modulo mo';
			$q.=' where me.ID=mu.menu_ID and me.modulo_ID=mo.ID and me.del=0 and mu.del=0 and mu.usuario_ID='.$usuario_id . ' and me.modulo_ID='.$modulo_ID;			
			$q.=' Order By me.orden';			
			//echo $q;
			$dt=$cn->getGrid($q);									
			return $dt;												
		}catch(Exception $ex)
		{
			throw new Exception($q);
		}
	}
        static function getMenuxUsuarioIDHtml($usuario_id,$ruta)
	{		
		$cn =new connect_new();
		try 
		{   
			//$q='call getMenu('.$usuario_id.',2,"'.$ruta.'")';
				
			$retorna=$cn->store_procedure_getData(
                            "getMenu",
                              array(
                                "iusuario_ID"=>$usuario_id,
                                "iempresa_ID"=>$_SESSION['empresa_ID'],
                                "iruta"=>$ruta));
                        //print_r($dt);
			//$retorna=$cn->getData($q);
                        //cho $retorna;
                    //$retorna="";
			return $retorna;												
		}catch(Exception $ex)
		{
			throw new Exception($q);
		}
	}
        static function getListaMenuModulo($modulo_ID,$usuario_ID,$empresa_ID)
        {
        //$cn =new connect_new();
        $cn =new connect_new();
        $retornar =0;
        try
        {
            $retorna="";
            
           $dt=$cn->store_procedure_getGrid(
              "sp_menu_getLista",array( "imodulo_ID"=>$modulo_ID,"iusuario_ID"=>$usuario_ID,"iempresa_ID"=>$empresa_ID));

            if(count($dt)>0){
                $retorna=$dt[0]['html'];
            }
          return $retorna;
        }catch(Exeption $ex)
        {
          log_error(__FILE__, "menu.getListaMenuModulo", $ex->getMessage());
          throw new Exception($ex->getMessage());
        }
  }
        
        
}

?>