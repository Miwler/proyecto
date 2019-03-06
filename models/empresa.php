<?php
class empresa
{
	private $ID;
	private $nombre;
	private $imagen;
        private $ruta;
        private $icono;
        private $logo;
        private $stilo_fondo_tabs;
        private $stilo_fondo_boton;
        private $stilo_fondo_cabecera;
       
	private $usuario_id;	
	private $usuario_mod_id;	
	private $getMessage;
		
	public function __set($var, $valor)
	{
		// convierte a minúsculas toda una cadena la función strtolower
		$temporal = $var;
		
		// Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
		if (property_exists('empresa',$temporal))
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
		if (property_exists('empresa', $temporal))
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
			$q='select ifnull(max(ID),0)+1 from empresa;';
			$ID=$cn->getData($q);
			
			$q='INSERT INTO empresa (ID,nombre,ruta,stilo_fondo_tabs,stilo_fondo_boton,stilo_fondo_cabecera,usuario_id) ';
			$q.='VALUES ('.$ID.',"'.$this->nombre.'","'.$this->ruta.'","'.$this->stilo_fondo_tabs.'","'.$this->stilo_fondo_boton.'","'.$this->stilo_fondo_cabecera.'",'.$this->usuario_id.');';
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
			$q='UPDATE empresa SET nombre="'.$this->nombre.'",ruta="'.$this->ruta.'",';
                        $q.=' stilo_fondo_tabs="'.$this->stilo_fondo_tabs.'", stilo_fondo_boton="'.$this->stilo_fondo_boton.'",';
                        $q.=' stilo_fondo_cabecera="'.$this->stilo_fondo_cabecera.'",'; 
			$q.=' usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
			$q.=' WHERE ID='.$this->ID;
			
			$retornar=$cn->transa($q);
			
			$this->getMessage='Se guardó correctamente.';
			return $retornar;
		}
		catch(Exception $ex){
			throw new Exception("Ocurrio un erroren la consulta");
		}
	}		
	
	function eliminar(){
            $cn =new connect_new();
            $retornar=-1;
            try{

                $q='UPDATE empresa SET del=1,usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
                $q.=' WHERE ID='.$this->ID;

                $retornar=$cn->transa($q);

                $this->getMessage='Se eliminó correctamente.';
                return $retornar;
            }
            catch(Exception $ex){
                    throw new Exception("Ocurrio un erroren la consulta");
            }
	}

 	static function getByID($ID)
	{
            $cn =new connect_new();
            try 
            {
                $q='Select ID,nombre,ruta,stilo_fondo_tabs,stilo_fondo_boton,stilo_fondo_cabecera,ifnull(icono,"") as icono,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id ';
                $q.='from empresa ';
                $q.='where del=0 and ID='.$ID;

                $dt=$cn->getGrid($q);	
                
                $oEmpresa=null;

                foreach($dt as $item)
                {
                    $oEmpresa=new empresa();					
                    $oEmpresa->ID=$item['ID'];
                    $oEmpresa->nombre=$item['nombre'];
                   
                    $oEmpresa->ruta=$item['ruta'];
                    
                    $oEmpresa->stilo_fondo_tabs=$item['stilo_fondo_tabs'];
                    $oEmpresa->stilo_fondo_boton=$item['stilo_fondo_boton'];
                    $oEmpresa->stilo_fondo_cabecera=$item['stilo_fondo_cabecera'];
                    $oEmpresa->icono=$item['icono'];
                    $oEmpresa->usuario_id=$item['usuario_id'];
                    $oEmpresa->usuario_mod_id=$item['usuario_mod_id'];
                }	
                
                return $oEmpresa;

            }catch(Exeption $ex)
            {
                    throw new Exception("Ocurrio un erroren la consulta");
            }
	}
	
	
	
	static function getCount($filtro='')
	{
		$cn =new connect_new();
		try 
		{
			$q='select count(ID) ';
			$q.=' FROM empresa ';
			$q.=' where del=0';
			
			if ($filtro!='')
			{
				$q.=' and '.$filtro;
			}
						
			$resultado=$cn->getData($q);									
		
			return $resultado;					
		}catch(Exception $ex)
		{
			throw new Exception("Ocurrio un erroren la consulta");
		}
	} 
	static function getCount1($filtro='')
	{
		$cn =new connect_new();
		try 
		{
			$q='select count(em.ID) ';
                        $q.=' FROM datos_generales dg ,empresa em';
                        $q.=' WHERE dg.empresa_ID=em.ID and em.del=0 and dg.del=0 ';
			
			if ($filtro!='')
			{
				$q.=' and '.$filtro;
			}
						
			$resultado=$cn->getData($q);									
		
			return $resultado;					
		}catch(Exception $ex)
		{
			throw new Exception("Ocurrio un erroren la consulta");
		}
	} 
	static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='ID asc')
	{
            $cn =new connect_new();
            try 
            {
                $q='SELECT ID,nombre,ruta,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
                $q.=' FROM empresa';
                $q.=' WHERE del=0 ';

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
                    throw new Exception('Ocurrio un erroren la consulta');
            }
	}
	static function getGrid1($filtro='',$desde=-1,$hasta=-1,$order='ID asc')
	{
            $cn =new connect_new();
            try 
            {
                $q='SELECT em.ID,em.nombre,em.ruta,em.usuario_id,ifnull(em.usuario_mod_id,-1) as usuario_mod_id,ifnull(dg.favicon,"") as favicon,';
                $q.=' ifnull(dg.logo_extension,"") as logo_extension,ifnull(dg.imagen,"") as imagen, ifnull(dg.ruc,"") as ruc,ifnull(dg.direccion,"") as direccion, ';
                $q.=' ifnull(dg.direccion,"") as direccion';
                $q.=' FROM datos_generales dg ,empresa em';
                $q.=' WHERE dg.empresa_ID=em.ID and em.del=0 and dg.del=0 ';

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
                    throw new Exception($q);
            }
	}
	static function getModulosxUsuarioID($usuario_id)
	{		
		$cn =new connect_new();
		try 
		{
			$q='select distinct(m.ID),m.orden,m.nombre,m.usuario_id,ifnull(m.usuario_mod_id ,-1) as usuario_mod_id ';
			$q.=' from modulo as m, menu me,menu_usuario mu';
			$q.=' where m.ID=me.modulo_ID and me.ID=mu.menu_ID and m.del=0 and me.del=0 and mu.del=0 and mu.usuario_ID='.$usuario_id;
                        $q.=' Order By m.orden';			
			//echo $q;
			$dt=$cn->getGrid($q);									
			return $dt;												
		}catch(Exception $ex)
		{
			throw new Exception('Ocurrio un erroren la consulta');
		}
	}
        
        static function getEmpresaxUsuarioID($usuario_ID)
	{		
		$cn =new connect_new();
		try 
		{
                    $q='select count(ID) from usuario_empresa';
                    $q.=' where perfil_ID=0 and usuario_ID='.$usuario_ID.' and del=0';
                    $contador_user_admin=$cn->getData($q);
                    
                    if($contador_user_admin >0){
                        $q='select em.*,ifnull((select razon_social from datos_generales where del=0 and empresa_ID=em.ID limit 0,1),"CONFIGURACIÓN GENERAL") as razon_social from empresa em where em.del=0';
                    }else{
                        $q='select distinct em.*,ifnull((select razon_social from datos_generales where del=0 and empresa_ID=em.ID limit 0,1),"CONFIGURACIÓN GENERAL") as razon_social ';
			$q.='from empresa em,usuario_empresa ue';
			$q.='  where ue.empresa_ID=em.ID and ue.del=0 and em.del=0 and ue.usuario_ID='.$usuario_ID;
                        $q.=' Order By em.nombre';	
                    }
			$cn1 =new connect_new();		
			//echo $q;
                    $dt=$cn1->getGrid($q);									
                    return $dt;												
		}catch(Exception $ex)
		{
			throw new Exception($q);
		}
	}
}

?>