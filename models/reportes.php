<?php
class reportes
{
	private $ID;
	private $nombre;
        private $orden;
        private $titulo;
        private $modulo_ID;
	private $usuario_id;	
	private $usuario_mod_id;	
	private $getMessage;
		
	public function __set($var, $valor)
	{
		// convierte a minúsculas toda una cadena la función strtolower
		$temporal = $var;
		
		// Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
		if (property_exists('reportes',$temporal))
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
		if (property_exists('reportes', $temporal))
		 {
			return $this->$temporal;
		 }
		 
		// Retorna nulo si no existe
		return null;
	}

 	static function getByID($ID)
	{
		$cn =new connect();
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
		$cn =new connect();
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
	
	static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='orden asc')
	{
		$cn =new connect();
		try 
		{
			$q='SELECT ID,modulo_ID,nombre,orden,titulo, usuario_id, ifnull(usuario_mod_id,-1) as usuario_mod_id';
			$q.=' FROM reportes';
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
			throw new Exception('Ocurrio un error en la consulta.');
		}
	}
        static function getComisionesGenerales($filtro = '', $desde = -1, $hasta = -1, $order = "CONCAT(pe.nombres,' ',pe.apellido_paterno)") {
        $cn = new connect();
        try {
            $q="select   CONCAT(pe.nombres,' ',pe.apellido_paterno) as operador,op.comision, sum(inv.utilidad_soles)  as utilidad_soles,";
            $q.="sum(inv.utilidad_dolares)  as utilidad_dolares, sum(inv.comision_soles)  as comision_soles,sum(inv.comision_dolares)  as comision_dolares";
            $q.=" from inventario inv left join salida_detalle ovd on inv.salida_detalle_ID=ovd.ID";
            $q.=" left join salida ov on ovd.salida_ID=ov.ID";
            $q.=" left join operador op on ov.operador_ID=op.ID";
            $q.=" left join persona pe on op.persona_ID=pe.ID";
            $q.=" left join factura_venta fv on fv.salida_ID=ov.ID";
            $q.=" where ovd.del=0 and ov.del=0 and inv.estado_ID=49";
           

            if ($filtro != '') {
                $q.=' and ' . $filtro;
            }
            $q.=" group by ov.operador_ID";
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
     static function getComisionesDetalles($filtro = '', $desde = -1, $hasta = -1, $order = "CONCAT(pe.nombres,' ',pe.apellido_paterno),ov.numero") {
        $cn = new connect();
        try {
            $q=" select ifnull(fv.serie,'') as serie,ifnull(fv.numero_concatenado,'') as numero_factura, ov.numero_concatenado,";
            $q.="CONCAT(pe.nombres,' ',pe.apellido_paterno) as operador,op.comision, sum(inv.utilidad_soles)  as utilidad_soles,";
            $q.=" sum(inv.utilidad_dolares)  as utilidad_dolares, sum(inv.comision_soles)  as comision_soles,sum(inv.comision_dolares)  as comision_dolares";
            $q.="  from inventario inv left join salida_detalle ovd on inv.salida_detalle_ID=ovd.ID";
            $q.=" left join salida ov on ovd.salida_ID=ov.ID";
            $q.=" left join operador op on ov.operador_ID=op.ID";
            $q.="   left join persona pe on op.persona_ID=pe.ID";
            $q.=" left join factura_venta fv on fv.salida_ID=ov.ID ";
            $q.="   where ovd.del=0 and ov.del=0 and inv.estado_ID=49 ";
           

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
    static function getVentasClientes($filtro = '', $desde = -1, $hasta = -1, $order = 'cli.razon_social asc,mo.descripcion asc') {
        $cn = new connect();
        try {
            $q="select cli.ruc,cli.razon_social,mo.descripcion as moneda,(case when ov.moneda_ID=1 then sum(ov.precio_venta_total_soles) else  sum(precio_venta_total_dolares) end) as monto_total";
            $q.=" from salida ov, cliente cli, moneda mo, factura_venta fv";
            $q.=" where ov.cliente_ID=cli.ID and fv.salida_ID = ov.ID and ov.moneda_ID=mo.ID and ov.del=0 ";
           
            if ($filtro != '') {
                $q.=' and ' . $filtro;
            }
            $q.=" group by ov.cliente_ID,ov.moneda_ID";
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
    static function getVentasClientesDetalle($filtro = '', $desde = -1, $hasta = -1, $order = 'cli.razon_social asc,fv.fecha_emision asc') {
        $cn = new connect();
        try {
            $q="select cli.ruc,cli.razon_social,concat(fv.serie,'-',fv.numero) as factura,DATE_FORMAT(fv.fecha_emision,'%d/%m/%Y')  as fecha,mo.simbolo as moneda,";
            $q.=" (case when ov.moneda_ID=1 then ov.precio_venta_total_soles else  precio_venta_total_dolares end) as monto_total";
            $q.="   from salida ov, cliente cli, moneda mo, factura_venta fv";
           $q.="   where ov.cliente_ID=cli.ID and fv.salida_ID = ov.ID and ov.moneda_ID=mo.ID and ov.del=0";
            if ($filtro != '') {
                $q.=' and ' . $filtro;
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
    
    static function getReporteCompras($filtro = '', $desde = -1, $hasta = -1, $order = 'year(co.fecha_emision),month(co.fecha_emision),co.moneda_ID',$group='') {
        $cn = new connect();
        try {
            $q="select year(co.fecha_emision) as periodo,month(co.fecha_emision) as mes,day(co.fecha_emision) as dia,co.moneda_ID,mo.descripcion as moneda, sum(co.total) as total ";
            $q.=" from ingreso co, moneda mo";
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
        $cn = new connect();
        try {
            $q="select year(ov.fecha) as periodo,month(fecha)as mes,day(fecha) as dia, ov.moneda_ID,";
            $q.=" (case ov.moneda_ID when 1 then sum(precio_venta_total_soles)  else sum(precio_venta_total_dolares) end) as total";
            $q.=" from salida ov";
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
    static function getReporteFacturasCobrarDetalle($filtro = '', $desde = -1, $hasta = -1, $order = 'cl.razon_social,fv.serie,fv.numero,fv.fecha_emision,fv.fecha_vencimiento') {
        $cn = new connect();
        try {
            $q = "select cl.ruc, cl.razon_social,concat(fv.serie,'-',fv.numero_concatenado) as factura,DATE_FORMAT(fv.fecha_emision,'%d/%m/%Y') as fecha_emision ,DATE_FORMAT(fv.fecha_vencimiento,'%d/%m/%Y') as fecha_vencimiento,";
            $q.='   mo.simbolo as moneda,fv.monto_total,fv.monto_pendiente';
            $q.=' from factura_venta fv, salida ov,cliente cl, moneda mo';
            $q.=' where fv.del=0 and ov.del=0 and fv.salida_ID=ov.ID and ov.cliente_ID=cl.ID and fv.moneda_ID=mo.ID and fv.forma_pago_ID=1 and fv.estado_ID=41';

            if ($filtro != '') {
                $q.=' and ' . $filtro;
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
     static function getReporteCuentasTotaltesCobrar($filtro = '', $desde = -1, $hasta = -1, $order = 'cl.razon_social,ov.moneda_ID') {
        $cn = new connect();
        try {
            $q = "select cl.ruc, cl.razon_social,mo.simbolo as moneda,sum(fv.monto_total) as monto_total,sum(fv.monto_pendiente) as monto_pendiente";
            $q.='  from factura_venta fv, salida ov,cliente cl, moneda mo';
            $q.=' where fv.del=0 and ov.del=0 and fv.salida_ID=ov.ID and ov.cliente_ID=cl.ID and fv.moneda_ID=mo.ID and fv.forma_pago_ID=1 and fv.estado_ID=41';
            
            if ($filtro != '') {
                $q.=' and ' . $filtro;
            }
            $q.=' group by ov.cliente_ID,ov.moneda_ID ';
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
        $cn = new connect();
        try {
            $q="select year(ov.fecha) as periodo,month(ov.fecha) as mes,day(ov.fecha) as dia,ov.moneda_ID,";
            $q.=" (case ov.moneda_ID when 1 then sum(inv.utilidad_soles) else sum(inv.utilidad_dolares)end ) as total";
            $q.=" from inventario inv left join salida_detalle ovd on inv.salida_detalle_ID=ovd.ID";
            $q.=" left join salida ov on ovd.salida_ID=ov.ID";
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
    
    /*Reportes para compras*/
    static function getReporteCompras_Proveedor($filtro = '', $desde = -1, $hasta = -1, $order = 'pro.razon_social',$group='') {
        $cn = new connect();
        try {
            $q="select pro.ruc , upper(pro.razon_social) as razon_social,pro.direccion,mo.simbolo as moneda,sum(co.subtotal) as 'sub_total',";
            $q.="sum(co.igv) as 'igv', sum(co.total) as total";
            $q.=" from ingreso co, proveedor pro,moneda mo";
            $q.=" where co.proveedor_ID=pro.ID and co.moneda_ID=mo.ID and co.del=0 and co.empresa_ID=".$_SESSION['empresa_ID'];
           
        
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
    static function getReporteCompras_Proveedor_Detalle($filtro = '', $desde = -1, $hasta = -1, $order = 'pro.razon_social,co.fecha_emision') {
        $cn = new connect();
        try {
            $q="select  pro.ruc,pro.razon_social,ifnull(co.periodo,0)as periodo,co.fecha_emision,concat(co.serie,' - ',co.numero) as factura";
            $q.=",mo.simbolo,co.subtotal as sub_total,co.igv,co.total";
            $q.=" from ingreso co, proveedor pro,moneda mo";
            $q.=" where co.proveedor_ID=pro.ID and co.moneda_ID=mo.ID and co.del=0 ";
            if ($filtro != '') {
                $q.=' and ' . $filtro;
            }
            
            $q.=' order by ' . $order;

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
    static function getReporteCuentas_Pagar_Detalle($filtro = '', $desde = -1, $hasta = -1, $order = 'pr.razon_social,co.periodo,co.fecha_emision') {
        $cn = new connect();
        try {
            $q = "select pr.ruc,pr.razon_social, ifnull(co.periodo,'') as periodo,DATE_FORMAT(co.fecha_emision,'%d/%m/%Y') AS fecha_emision,concat(co.serie,'-',co.numero) as factura,";
            $q.= "mo.simbolo as moneda,DATE_FORMAT(ifnull(co.fecha_vencimiento,'0000-00-00'),'%d/%m/%Y') as fecha_vencimiento ,";
            $q.= "co.subtotal,co.igv,co.total,ifnull(co.monto_pendiente,0) as monto_pendiente";
            $q.=" FROM ingreso co,proveedor pr,moneda mo";
            $q.=' where co.proveedor_ID=pr.ID  and co.moneda_ID=mo.ID  and co.del=0 and co.estado_ID=9 and co.forma_pago_ID=1';
            
            if ($filtro != '') {
                $q.=' and ' . $filtro;
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
    static function getReporteCuentas_Pagar($filtro = '', $desde = -1, $hasta = -1, $order = 'pr.razon_social,co.periodo,co.fecha_emision') {
        $cn = new connect();
        try {
            $q = "select pr.ruc,pr.razon_social,mo.simbolo as moneda,sum(co.subtotal) as subtotal ,sum(co.igv) as igv,";
            $q.= "sum(co.total) as total,sum(ifnull(co.monto_pendiente,0)) as monto_pendiente";
            $q.=" FROM ingreso co,proveedor pr,moneda mo";
            $q.=' where co.proveedor_ID=pr.ID  and co.moneda_ID=mo.ID  and co.del=0 and co.estado_ID=9 and co.forma_pago_ID=1';
            
            if ($filtro != '') {
                $q.=' and ' . $filtro;
            }
            $q.=' group by co.proveedor_ID,co.moneda_ID ' ;
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
    static function getReporteAnulacionCompras($filtro = '', $desde = -1, $hasta = -1, $order = 'co.fecha_anulacion,pr.razon_social,co.numero') {
        $cn = new connect();
        try {
            $q = "select  DATE_FORMAT(co.fecha_anulacion,'%d/%m/%Y') as fecha_anulacion,pr.ruc, pr.razon_social,concat(co.serie,'-',co.numero) as comprobante";
            $q.= ",mo.simbolo,co.total,concat(pe.nombres,' ', pe.apellido_paterno) as autorizador,ma.nombre as motivo";
            $q.= ' FROM ingreso co,proveedor pr,moneda mo, motivo_anulacion ma, operador op ,persona pe';
            $q.=' where co.del=0 and co.proveedor_ID=pr.ID and mo.ID=co.moneda_ID and co.operador_ID_anulacion=op.ID and op.persona_ID=pe.ID ';
            $q.=' and co.motivo_anulacion_ID=ma.ID and co.estado_ID = 10';


            if ($filtro != '') {
                $q.=' and ' . $filtro;
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
    
}

?>