<?php
class empresa
{
	private $ID;
	private $nombre;
	private $imagen;
        private $ruta;
        
        private $logo;
        private $stilo_fondo_tabs;
        private $stilo_fondo_boton;
        private $stilo_fondo_cabecera;
        private $icono;
        private $color_documentos;
	private $usuario_id;	
	private $usuario_mod_id;	
	private $getMessage;
        
	private $moneda;
        private $periodo_inicio;
        private $estado_compra;
        private $compra_tipo_comprobante_ID;
        private $link_comprobante_electronico;
        private $departamento_ID_default;
        private $provincia_ID_default;
        private $distrito_ID_default;
        private $configuracion_correo_empresa;
        private $configuracion_celular_empresa;
        private $beta_ws_guia;
        private $beta_ws_factura;
        private $produccion_ws_factura;
        private $produccion_ws_guia;
        private $conexion_ws_sunat;
        private $lista_modulo;
        private $lista_reportes;
        private $correlativos_ID;
        private $correlativos_ID_nota_credito;
        private $correlativos_ID_nota_debito;
        private $correlativos_ID_guia_remision;
        private $correlativos_ID_fisico;
        private $correlativos_ID_guia_fisico;
        private $correlativos_ID_guia_electronico;
        private $imagen_documentos;
        private $precio_incluye_igv;
        private $bd_largo_decimal;
        private $fecha_inicio_reportes;
        private $fecha_view;
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
	function __construct()
        {
            $this->nombre="";
            $this->ruta="";
            $this->stilo_fondo_tabs="";
            $this->stilo_fondo_boton="";
            $this->stilo_fondo_cabecera="";
            $this->icono="";
            $this->usuario_id=isset($_SESSION["usuario_ID"])?$_SESSION["usuario_ID"]:-1;
            $this->usuario_mod_id=isset($_SESSION["usuario_ID"])?$_SESSION["usuario_ID"]:-1;

        }
        function __destruct()
        {
            $this->nombre;
            $this->ruta;
            $this->stilo_fondo_tabs;
            $this->stilo_fondo_boton;
            $this->stilo_fondo_cabecera;
            $this->icono;
            $this->usuario_id;
            $this->usuario_mod_id;

        }
	/*function insertar(){
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
	}	*/
        function insertar()
        {
        $cn =new connect_new();
        try
        {
          $ID=$cn->store_procedure_transa(
              "sp_empresa_Insert",
                array(
                    "iID"=>0,
                    "inombre"=>$this->nombre,
                    "iruta"=>$this->ruta,
                    "istilo_fondo_tabs"=>$this->stilo_fondo_tabs,
                    "istilo_fondo_boton"=>$this->stilo_fondo_boton,
                    "istilo_fondo_cabecera"=>$this->stilo_fondo_cabecera,
                     "icolor_documentos"=>$this->color_documentos,
                     "iicono"=>$this->icono,
                    "iusuario_id"=>$this->usuario_id,
                    "imoneda"=>$this->moneda,
                    "iperiodo_inicio"=>$this->periodo_inicio,
                    "iestado_compra"=>$this->estado_compra,
                    "icompra_tipo_comprobante_ID"=>$this->compra_tipo_comprobante_ID,
                    "ilink_comprobante_electronico"=>$this->link_comprobante_electronico,
                    "idepartamento_ID_default"=>$this->departamento_ID_default,
                    "iprovincia_ID_default"=>$this->provincia_ID_default,
                    "idistrito_ID_default"=>$this->distrito_ID_default,
                    "iconfiguracion_correo_empresa"=>$this->configuracion_correo_empresa,
                    "iconfiguracion_celular_empresa"=>$this->configuracion_celular_empresa,
                    "ibeta_ws_guia"=>$this->beta_ws_guia,
                    "ibeta_ws_factura"=>$this->beta_ws_factura,
                    "iproduccion_ws_factura"=>$this->produccion_ws_factura,
                    "iproduccion_ws_guia"=>$this->produccion_ws_guia,
                    "iconexion_ws_sunat"=>$this->conexion_ws_sunat,
                    "ilista_modulo"=>$this->lista_modulo,
                    "ilista_reportes"=>$this->lista_reportes,
                    "iprecio_incluye_igv"=>$this->precio_incluye_igv,
                    "ibd_largo_decimal"=>$this->bd_largo_decimal,
                     "ifecha_inicio_reportes"=>$this->fecha_inicio_reportes
                ),0);
          if($ID>0){
            $this->getMessage="El registro se guardó correctamente.";
            $this->ID=$ID;
            return $ID;
            } else {
                throw new Exception("No se registró");
            }
          }catch(Exeption $ex)
          {
            log_error(__FILE__, "empresa.insertar", $ex->getMessage());
            throw new Exception($ex->getMessage());
          }
        }
	function actualizar(){
		$cn =new connect_new();
		$retornar=-1;
		try{					
			$q='UPDATE empresa SET nombre="'.$this->nombre.'",ruta="'.$this->ruta.'",';
                        $q.=' stilo_fondo_tabs="'.$this->stilo_fondo_tabs.'", stilo_fondo_boton="'.$this->stilo_fondo_boton.'",';
                        $q.=' stilo_fondo_cabecera="'.$this->stilo_fondo_cabecera.'",'; 
                        $q.=' color_documentos="'.$this->color_documentos.'",'; 
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
	function actualizar1()
    {
    $cn =new connect_new();
    $retornar =0;
    try
    {
      $retornar=$cn->store_procedure_transa(
          "sp_empresa_Update",
            array(
              "retornar"=>$retornar,
                "iID"=>$this->ID,
                "inombre"=>$this->nombre,
                    "iruta"=>$this->ruta,
                    "istilo_fondo_tabs"=>$this->stilo_fondo_tabs,
                    "istilo_fondo_boton"=>$this->stilo_fondo_boton,
                    "istilo_fondo_cabecera"=>$this->stilo_fondo_cabecera,
                     "icolor_documentos"=>$this->color_documentos,
                     "iicono"=>$this->icono,
                    "iusuario_mod_id"=>$this->usuario_mod_id,
                    "imoneda"=>$this->moneda,
                    "iperiodo_inicio"=>$this->periodo_inicio,
                    "iestado_compra"=>$this->estado_compra,
                    "icompra_tipo_comprobante_ID"=>$this->compra_tipo_comprobante_ID,
                    "ilink_comprobante_electronico"=>$this->link_comprobante_electronico,
                    "idepartamento_ID_default"=>$this->departamento_ID_default,
                    "iprovincia_ID_default"=>$this->provincia_ID_default,
                    "idistrito_ID_default"=>$this->distrito_ID_default,
                    "iconfiguracion_correo_empresa"=>$this->configuracion_correo_empresa,
                    "iconfiguracion_celular_empresa"=>$this->configuracion_celular_empresa,
                    "ibeta_ws_guia"=>$this->beta_ws_guia,
                    "ibeta_ws_factura"=>$this->beta_ws_factura,
                    "iproduccion_ws_factura"=>$this->produccion_ws_factura,
                    "iproduccion_ws_guia"=>$this->produccion_ws_guia,
                    "iconexion_ws_sunat"=>$this->conexion_ws_sunat,
                    "ilista_modulo"=>$this->lista_modulo,
                    "ilista_reportes"=>$this->lista_reportes,
                    "iprecio_incluye_igv"=>$this->precio_incluye_igv,
                    "iprecio_incluye_igv"=>$this->precio_incluye_igv,
                    "ibd_largo_decimal"=>$this->bd_largo_decimal,
                    "ifecha_inicio_reportes"=>$this->fecha_inicio_reportes
            ),0);
      if($retornar>0){
          $this->getMessage="Se actualizó correctamente.";
      }
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "empresa.actualizar", $ex->getMessage());
      throw new Exception($ex->getMessage());
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

 	/*static function getByID($ID)
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
	}*/
	
	static function getByID($ID)
        {
        $cn =new connect_new();
        try
        {
          $dt=$cn->store_procedure_getGrid(
              "sp_empresa_getByID",
              array("iID"=>$ID));
            $oempresa=null;
            foreach($dt as $item)
            {
              $oempresa= new empresa();
              $oempresa->ID=$item["ID"];
              $oempresa->nombre=$item["nombre"];
              $oempresa->ruta=$item["ruta"];
              $oempresa->stilo_fondo_tabs=$item["stilo_fondo_tabs"];
              $oempresa->stilo_fondo_boton=$item["stilo_fondo_boton"];
              $oempresa->stilo_fondo_cabecera=$item["stilo_fondo_cabecera"];
              $oempresa->icono=$item["icono"];
              $oempresa->color_documentos=$item["color_documentos"];
              $oempresa->usuario_id=$item["usuario_id"];
              $oempresa->usuario_mod_id=$item["usuario_mod_id"];

              }
              return $oempresa;
            }catch(Exeption $ex)
            {
              log_error(__FILE__, "empresa.getByID", $ex->getMessage());
              throw new Exception($ex->getMessage());
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
			$q="select distinct em.*,ifnull((select razon_social from datos_generales where del=0 and empresa_ID=em.ID limit 0,1),'CONFIGURACIÓN GENERAL') as razon_social   from empresa em inner join menu_usuario um on um.empresa_ID=em.ID and um.del=0 and um.usuario_ID=".$usuario_ID. " where em.del=0";
                   /* $q='select count(ID) from usuario_empresa';
                    $q.=' where perfil_ID=0 and usuario_ID='.$usuario_ID.' and del=0';
                    $contador_user_admin=$cn->getData($q);
                    
                    if($contador_user_admin >0){
                        $q='select em.*,ifnull((select razon_social from datos_generales where del=0 and empresa_ID=em.ID limit 0,1),"CONFIGURACIÓN GENERAL") as razon_social from empresa em where em.del=0';
                    }else{
                        $q='select distinct em.*,ifnull((select razon_social from datos_generales where del=0 and empresa_ID=em.ID limit 0,1),"CONFIGURACIÓN GENERAL") as razon_social ';
			$q.='from empresa em,usuario_empresa ue';
			$q.='  where ue.empresa_ID=em.ID and ue.del=0 and em.del=0 and ue.usuario_ID='.$usuario_ID;
                        $q.=' Order By em.nombre';	
                    }*/
			//$cn1 =new connect_new();		
			//echo $q;
                    $dt=$cn->getGrid($q);									
                    return $dt;												
		}catch(Exception $ex)
		{
			throw new Exception($q);
		}
	}
        function getConfiguracion()
        {
        $cn =new connect_new();
        $retornar =0;
        try
        {
          $dt=$cn->store_procedure_getGrid(
              "sp_configuracion_empresa",
                array("iempresa_ID"=>$this->ID));
          //print_r($dt);
         
          if(count($dt)>0){
              foreach($dt as $item){
                if($item['nombre']=="moneda"){
                    $this->moneda=$item['valor'];
                }
                if($item['nombre']=="periodo_inicio"){
                    $this->periodo_inicio=$item['valor'];
                }  
                if($item['nombre']=="estado_compra"){
                    $this->estado_compra=$item['valor'];
                }
                if($item['nombre']=="compra_tipo_comprobante_ID"){
                    $this->compra_tipo_comprobante_ID=$item['valor'];
                }
                if($item['nombre']=="link_comprobante_electronico"){
                    $this->link_comprobante_electronico=$item['valor'];
                }
                if($item['nombre']=="departamento_ID_default"){
                    $this->departamento_ID_default=$item['valor'];
                }
                if($item['nombre']=="provincia_ID_default"){
                    $this->provincia_ID_default=$item['valor'];
                }
                if($item['nombre']=="distrito_ID_default"){
                    $this->distrito_ID_default=$item['valor'];
                }
                if($item['nombre']=="configuracion_correo_empresa"){
                    $this->configuracion_correo_empresa=$item['valor'];
                }
                if($item['nombre']=="configuracion_celular_empresa"){
                    $this->configuracion_celular_empresa=$item['valor'];
                }
                if($item['nombre']=="beta_ws_guia"){
                    $this->beta_ws_guia=$item['valor'];
                }
                
                if($item['nombre']=="beta_ws_factura"){
                    $this->beta_ws_factura=$item['valor'];
                }
                if($item['nombre']=="produccion_ws_factura"){
                    $this->produccion_ws_factura=$item['valor'];
                }
                if($item['nombre']=="produccion_ws_guia"){
                    $this->produccion_ws_guia=$item['valor'];
                }
                if($item['nombre']=="conexion_ws_sunat"){
                    $this->conexion_ws_sunat=$item['valor'];
                }
                if($item['nombre']=="precio_incluye_igv"){
                    $this->precio_incluye_igv=$item['valor'];
                }
                if($item['nombre']=="bd_largo_decimal"){
                    $this->bd_largo_decimal=$item['valor'];
                }
                if($item['nombre']=="fecha_inicio_reportes"){
                    $this->fecha_inicio_reportes=$item['valor'];
                }
                if($item['nombre']=="lista_modulo"){
                    $this->lista_modulo=$item['valor'];
                }
                
              }
            
                    
          }
          return $dt;
        }catch(Exeption $ex)
        {
          log_error(__FILE__, "configuracion_empresa.getGrid", $ex->getMessage());
          throw new Exception($ex->getMessage());
        }
      }
        
}

?>