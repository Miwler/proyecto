<?php
class reportes_empresa_usuario
{
	private $ID;
	private $usuario_ID;
	private $usuario_id_creacion;	
	private $usuario_mod_id;	
	private $getMessage;
		
	public function __set($var, $valor)
	{
		// convierte a minúsculas toda una cadena la función strtolower
		$temporal = $var;
		
		// Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
		if (property_exists('reportes_empresa_usuario',$temporal))
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
		
		// Verifica que reportes_empresa
		if (property_exists('reportes_empresa_usuario', $temporal))
		 {
			return $this->$temporal;
		 }
		 
		// Retorna nulo si no existe
		return null;
	}

 	static function getByID($ID)
	{
		$cn =new connect_new();
		try 
		{
			$q='SELECT ID,nombre,modulo_ID,orden,titulo, usuario_id, ifnull(usuario_mod_id,-1) as usuario_mod_id';
			$q.=' from reportes ';
			$q.=' where ID='.$ID;
			
			$dt=$cn->getGrid($q);			
			$oReportes=null;
			
			foreach($dt as $item)
			{
				$oReportes=new reportes();
				
				$oReportes->ID=$item['ID'];
                                $oReportes->modulo_ID=$item['modulo_ID'];
				$oReportes->nombre=$item['nombre'];
				$oReportes->titulo=$item['titulo'];
				$oReportes->orden=$item['orden'];
				$oReportes->usuario_id=$item['usuario_id'];
				$oReportes->usuario_mod_id=$item['usuario_mod_id'];
			}			
			return $oReportes;
				
		}catch(Exeption $ex)
		{
			throw new Exception("Ocurrio un error en la consulta.");
		}
	}
	
	static function getCount($filtro='')
	{
		$cn =new connect_new();
		try 
		{
			$q='select count(ID) ';
			$q.=' FROM reportes';
			$q.=' where del=0 ';
			
			if ($filtro!='')
			{
				$q.=' and '.$filtro;
			}
						
			$resultado=$cn->getData($q);									
		
			return $resultado;					
		}catch(Exception $ex)
		{
			throw new Exception("Ocurrio un error en la consulta.");
		}
	} 
	
	static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='reu.ID asc')
	{
		$cn =new connect_new();
		try 
		{
                    $q='SELECT reu.ID,rem.reportes_ID,rem.empresa_ID,reu.usuario_id, ifnull(reu.usuario_mod_id,-1) as usuario_mod_id';
                    $q.=',re.nombre,re.titulo,re.modulo_ID';
                    $q.=' FROM reportes re,reportes_empresa rem,reportes_empresa_usuario reu';
                    $q.=' where reu.reportes_empresa_ID=rem.ID and rem.reportes_ID=re.ID and reu.del=0';

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
        static function getComisionesGenerales($filtro = '', $desde = -1, $hasta = -1, $order = 'inv.ID asc') {
        $cn = new connect_new();
        try {
            $q="select ov.operador_ID,CONCAT(op.nombres,' ',op.apellido_paterno) as operador,op.comision, sum(inv.utilidad_soles)  as utilidad_soles,";
            $q.="sum(inv.utilidad_dolares)  as utilidad_dolares, sum(inv.comision_soles)  as comision_soles,sum(inv.comision_dolares)  as comision_dolares";
            $q.=" from inventario inv left join orden_venta_detalle ovd on inv.orden_venta_detalle_ID=ovd.ID";
            $q.=" left join orden_venta ov on ovd.orden_venta_ID=ov.ID ";
            $q.=" left join operador op on ov.operador_ID=op.ID";
            $q.=" left join factura_venta fv on fv.orden_venta_ID=ov.ID";
            $q.=" where ovd.del=0 and ov.del=0 and inv.estado_ID=49";
           

            if ($filtro != '') {
                $q.=' and ' . $filtro;
            }
            $q.=" group by ov.operador_ID,CONCAT(op.nombres,' ',op.apellido_paterno),op.comision";
            $q.=' Order By ' . $order;

            if ($desde != -1 && $hasta != -1) {
                $q.=' Limit ' . $desde . ',' . $hasta;
            }
            //echo $q;
            $dt = $cn->getGrid($q);
            
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
     static function getComisionesDetalles($filtro = '', $desde = -1, $hasta = -1, $order = 'inv.ID asc,ov.numero') {
        $cn = new connect_new();
        try {
            $q="select ov.ID as orden_venta_ID,fv.serie,fv.numero_concatenado as numero_factura, ov.numero_concatenado,ov.operador_ID,CONCAT(op.nombres,' ',op.apellido_paterno) as operador,op.comision, sum(inv.utilidad_soles)  as utilidad_soles,";
            $q.="sum(inv.utilidad_dolares)  as utilidad_dolares, sum(inv.comision_soles)  as comision_soles,sum(inv.comision_dolares)  as comision_dolares";
            $q.=" from inventario inv left join orden_venta_detalle ovd on inv.orden_venta_detalle_ID=ovd.ID";
            $q.=" left join orden_venta ov on ovd.orden_venta_ID=ov.ID ";
            $q.=" left join operador op on ov.operador_ID=op.ID";
            $q.=" left join factura_venta fv on fv.orden_venta_ID=ov.ID";
            $q.=" where ovd.del=0 and ov.del=0 and inv.estado_ID=49 ";
           

            if ($filtro != '') {
                $q.=' and ' . $filtro;
            }
            $q.=" group by ov.operador_ID,op.comision,ov.ID";
            $q.=' Order By ' . $order;

            if ($desde != -1 && $hasta != -1) {
                $q.=' Limit ' . $desde . ',' . $hasta;
            }
            //echo $q;
            $dt = $cn->getGrid($q);
            
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    static function getVentasClientes($filtro = '', $desde = -1, $hasta = -1, $order = 'cli.razon_social asc') {
        $cn = new connect_new();
        try {
            $q="select cli.ID,cli.ruc,cli.razon_social,mo.simbolo,ov.moneda_ID, sum(ov.precio_venta_total_soles)  as precio_venta_total_soles,sum(precio_venta_total_dolares) as precio_venta_total_dolares";
            $q.=" from orden_venta ov, cliente cli, moneda mo";
            $q.=" where ov.cliente_ID=cli.ID and ov.moneda_ID=mo.ID and ov.del=0 ";
           
            if ($filtro != '') {
                $q.=' and ' . $filtro;
            }
            $q.=" group by ov.cliente_ID";
            $q.=' Order By ' . $order;

            if ($desde != -1 && $hasta != -1) {
                $q.=' Limit ' . $desde . ',' . $hasta;
            }
            //echo $q;
            $dt = $cn->getGrid($q);
            
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    
    static function getReporteCompras($filtro = '', $desde = -1, $hasta = -1, $order = 'year(co.fecha_emision),month(co.fecha_emision),co.moneda_ID',$group='') {
        $cn = new connect_new();
        try {
            $q="select year(co.fecha_emision) as periodo,month(co.fecha_emision) as mes,day(co.fecha_emision) as dia,co.moneda_ID,mo.descripcion as moneda, sum(co.total) as total ";
            $q.=" from compra co, moneda mo";
            $q.=" where co.moneda_ID=mo.ID and co.del=0 and co.estado_ID<>10";
         
            if ($filtro != '') {
                $q.=' and ' . $filtro;
            }
            if($group!=''){
                $q.=" group by ".$group;
            }
            
            $q.=' Order By ' . $order;

            if ($desde != -1 && $hasta != -1) {
                $q.=' Limit ' . $desde . ',' . $hasta;
            }
            //echo $q;
            $dt = $cn->getGrid($q);
            
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    static function getReporteVentas($filtro = '', $desde = -1, $hasta = -1, $order = 'year(ov.fecha),month(fecha),day(fecha),ov.moneda_ID',$group='') {
        $cn = new connect_new();
        try {
            $q="select year(ov.fecha) as periodo,month(fecha)as mes,day(fecha) as dia, ov.moneda_ID,";
            $q.=" (case ov.moneda_ID when 1 then sum(precio_venta_total_soles)  else sum(precio_venta_total_dolares) end) as total";
            $q.=" from orden_venta ov";
            $q.=" where ov.del=0 and ov.estado_ID<>58";
         
            if ($filtro != '') {
                $q.=' and ' . $filtro;
            }
            if($group!=''){
                $q.=" group by ".$group;
            }
            
            $q.=' Order By ' . $order;

            if ($desde != -1 && $hasta != -1) {
                $q.=' Limit ' . $desde . ',' . $hasta;
            }
            //echo $q;
            $dt = $cn->getGrid($q);
            
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
     static function getReporteGanancias($filtro = '', $desde = -1, $hasta = -1, $order = 'year(ov.fecha),month(fecha),day(fecha),ov.moneda_ID',$group='') {
        $cn = new connect_new();
        try {
            $q="select year(ov.fecha) as periodo,month(ov.fecha) as mes,day(ov.fecha) as dia,ov.moneda_ID,";
            $q.=" (case ov.moneda_ID when 1 then sum(inv.utilidad_soles) else sum(inv.utilidad_dolares)end ) as total";
            $q.=" from inventario inv left join orden_venta_detalle ovd on inv.orden_venta_detalle_ID=ovd.ID";
            $q.=" left join orden_venta ov on ovd.orden_venta_ID=ov.ID";
            $q.=" where inv.del=0 and inv.estado_ID=49";
        
            if ($filtro != '') {
                $q.=' and ' . $filtro;
            }
            if($group!=''){
                $q.=" group by ".$group;
            }
            
            $q.=' Order By ' . $order;

            if ($desde != -1 && $hasta != -1) {
                $q.=' Limit ' . $desde . ',' . $hasta;
            }
            //echo $q;
            $dt = $cn->getGrid($q);
            
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    function registrar($usuario_ID,$lista_reportes) {
        $cn = new connect_new();
        $retornar = 0;
        try {
            $retornar=$cn->store_procedure_transa("sp_reportes_empresa_usuario_Registrar", array(
                "retornar"=>$retornar,
                "ireportes_empresa_IDs"=>$lista_reportes,
                "iusuario_ID"=>$usuario_ID,
                "iusuario_id_reg"=>$_SESSION['usuario_ID']
            ), 0);
            
            //$this->getMessage = 'Se guardó correctamente.';
            return $retornar;
        } catch (Exception $ex) {
            log_error(__FILE__, "menu_usuario.registrar", $ex->getMessage());
            throw new Exception("Ocurrio un Error en la consulta");
        }
    }
    static function getLista($empresa_ID,$usuario_ID,$modulo_ID)
    {
    $cn =new connect_new();
    $retornar =0;
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_reportes_empresa_usuario_getLista",
            array(
              "iempresa_ID"=>$empresa_ID,
              "iusuario_ID"=>$usuario_ID,
              "imodulo_ID"=>$modulo_ID));
      return $dt;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "reportes_empresa_usuario.getLista", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
}

?>