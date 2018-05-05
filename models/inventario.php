<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of inventario
 *
 * @author miwler
 */
class inventario {
    private $ID;
    private $producto_ID;
    private $ingreso_detalle_ID;
    private $cotizacion_detalle_ID;
    private $salida_detalle_ID;
    private $descripcion;
    private $serie;
    private $estado_ID;
    private $utilidad_soles;
    private $utilidad_dolares;
    private $comision_soles;
    private $comision_dolares;
    private $usuario_id;
    private $usuario_mod_id;
//Variables para uso 
  
    private $getMessage;
    private $stock;
    public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
        if (property_exists('inventario', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('inventario', $temporal)) {
            return $this->$temporal;
        }

        // Retorna nulo si no existe
        return null;
    }

    function insertar() {
        $cn = new connect();
        $retorna = -1;
        try {
            
            $salida_detalle_ID='NULL';
            if($this->salida_detalle_ID!=null){
                $salida_detalle_ID=$this->salida_detalle_ID;
            }
            $ingreso_detalle_ID='NULL';
            if($this->ingreso_detalle_ID!=null){
                $ingreso_detalle_ID=$this->ingreso_detalle_ID;
            }
            $cotizacion_detalle_ID='NULL';
            if($this->cotizacion_detalle_ID!=null){
                $cotizacion_detalle_ID=$this->cotizacion_detalle_ID;
            }
            $q = 'select ifnull(max(ID),0)+1 as ID from inventario;';
            $ID=$cn->getData($q);
            
            $utilidad_soles=0;
            if($this->utilidad_soles!=null){
                $utilidad_soles=$this->utilidad_soles;
            }
            $utilidad_dolares=0;
            if($this->utilidad_soles!=null){
                $utilidad_dolares=$this->utilidad_dolares;
            }
            $comision_soles=0;
            if($this->comision_soles!=null){
                $comision_soles=$this->comision_soles;
            }
            $comision_dolares=0;
            if($this->comision_dolares!=null){
                $comision_dolares=$this->comision_dolares;
            }
            $serie='';
            if($this->serie!=null){
                $serie=$this->serie;
            }     
            $q = 'insert into inventario(ID,empresa_ID, ingreso_detalle_ID,salida_detalle_ID, descripcion, producto_ID,estado_ID,';
            $q.= 'utilidad_soles,utilidad_dolares,comision_soles,comision_dolares,serie,cotizacion_detalle_ID,usuario_id )';
            $q.='values('.$ID.','.$_SESSION['empresa_ID'].','. $ingreso_detalle_ID .','.$salida_detalle_ID. ',"'. $this->descripcion. '",' .$this->producto_ID.
                ','.$this->estado_ID.','.$utilidad_soles.','.$utilidad_dolares.','.$comision_soles.','.$comision_dolares.',"'.$serie.'",'.$cotizacion_detalle_ID.','.$this->usuario_id . ')';
            //echo $q;
             $retorna=$cn->transa($q);
            $this->getMessage = 'Se guardó correctamente';
            $this->ID=$ID;
            return $retorna;
        } catch (Exception $ex) {

            throw new Exception($q);
        }
    }
   function actualizar(){
        $cn =new connect();
        $retornar=-1;
        try{
                $salida_detalle_ID='NULL';
                if($this->salida_detalle_ID!=null){
                $salida_detalle_ID=$this->salida_detalle_ID;
                }
                $ingreso_detalle_ID='NULL';
                if($this->ingreso_detalle_ID!=null){
                $ingreso_detalle_ID=$this->ingreso_detalle_ID;
                }
                $cotizacion_detalle_ID='NULL';
                if($this->cotizacion_detalle_ID!=null){
                $cotizacion_detalle_ID=$this->cotizacion_detalle_ID;
                }
                $q="UPDATE inventario SET producto_ID=".$this->producto_ID.",ingreso_detalle_ID=".$ingreso_detalle_ID;
                $q.=",salida_detalle_ID=".$salida_detalle_ID;
                $q.=",descripcion='".  $this->descripcion."',estado_ID=".$this->estado_ID.", utilidad_soles=".$this->utilidad_soles.",utilidad_dolares=".$this->utilidad_dolares;
                $q.=",comision_soles=".$this->comision_soles.", comision_dolares=".$this->comision_dolares.",serie='".$this->serie."',cotizacion_detalle_ID=".$cotizacion_detalle_ID.",";
                $q.=" usuario_mod_id=".$this->usuario_mod_id.", fdm=Now()";
                $q.=" WHERE ID=".$this->ID;
               // echo $q;
                $retornar=$cn->transa($q);
                $this->getMessage='Se guardó correctamente';
                //$q="select max(ID) from inventario where del=0 and producto_ID=".$this->producto_ID;
                //$ID=$cn->getData($q);        
                //$this->ID=$ID;
                return $retornar;
        }
        catch(Exception $ex){
                throw new Exception($q);
        }
    }
    static function getByID($ID)
    {
		$cn =new connect();
		try 
		{
			$q='select ID, producto_ID,ingreso_detalle_ID ,salida_detalle_ID,';
                        $q.=' descripcion,estado_ID,utilidad_soles,utilidad_dolares,comision_soles,comision_dolares,serie,cotizacion_detalle_ID,ifnull(usuario_mod_id,-1) as usuario_mod_id';
                        $q.=' from inventario where del=0 and ID='.$ID;
                        //echo $q;
          		$dt=$cn->getGrid($q);			
			$oInventario=null;
			
			foreach($dt as $item)
			{
				$oInventario=new inventario();
				
				$oInventario->ID=$item['ID'];
				$oInventario->producto_ID=$item['producto_ID'];
                                $oInventario->ingreso_detalle_ID=$item['ingreso_detalle_ID'];
				$oInventario->salida_detalle_ID=$item['salida_detalle_ID'];
                               	$oInventario->descripcion=$item['descripcion'];
                                $oInventario->estado_ID=$item['estado_ID'];
                                $oInventario->utilidad_soles=$item['utilidad_soles'];
                                $oInventario->utilidad_dolares=$item['utilidad_dolares'];
                                $oInventario->comision_soles=$item['comision_soles'];
                                $oInventario->comision_dolares=$item['comision_dolares'];
                                $oInventario->serie=$item['serie'];
                                $oInventario->cotizacion_detalle_ID=$item['cotizacion_detalle_ID'];
				$oInventario->usuario_mod_id=$item['usuario_mod_id'];
                               
	
			}			
			return $oInventario;
				
		}catch(Exeption $ex)
		{
			throw new Exception("Ocurrio un error en la consultaGetBy");
		}
	}
    static function getByID2($ingreso_detalle_ID)
    {
           $cn =new connect();
           try 
           {
                   $q='  select ID, producto_ID,ingreso_detalle_ID, salida_detalle_ID,cantidad_ingreso,'
                           . '  cantidad_salida, stock, fecha,descripcion,cotizacion_detalle_ID,ifnull(usuario_mod_id,-1) as usuario_mod_id ';
                   $q.=' from inventario where del=0 and ingreso_detalle_ID='.$ingreso_detalle_ID;

                   //echo $q;
                   $dt=$cn->getGrid($q);			
                   $oInventario=null;

                   foreach($dt as $item)
                   {
                           $oInventario=new inventario();
                           $oInventario->ID=$item['ID'];
                           $oInventario->producto_ID=$item['producto_ID'];
                           $oInventario->ingreso_detalle_ID=$item['ingreso_detalle_ID'];
                           $oInventario->salida_detalle_ID=$item['salida_detalle_ID'];
                           $oInventario->cotizacion_detalle_ID=$item['cotizacion_detalle_ID'];
                           $oInventario->cantidad_ingreso=$item['cantidad_ingreso'];
                           $oInventario->cantidad_salida=$item['cantidad_salida'];
                           $oInventario->stock=$item['stock'];
                           $oInventario->fecha=$item['fecha'];
                           $oInventario->descripcion=$item['descripcion'];
                           $oInventario->usuario_mod_id=$item['usuario_mod_id'];


                   }			
                   return $oInventario;

           }catch(Exeption $ex)
           {
                   throw new Exception("Ocurrio un error en la consulta2");
           }
    }
    static function getGrid($filtro = '', $desde = -1, $hasta = -1, $order = 'ID desc') {
        $cn = new connect();
        try {
            $q='select ID, producto_ID,ingreso_detalle_ID, salida_detalle_ID,';
            $q.=' descripcion,estado_ID,utilidad_soles,utilidad_dolares,comision_soles,';
            $q.="comision_dolares,ifnull(serie,'') as serie,cotizacion_detalle_ID,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id";
            $q.=' from inventario where empresa_ID='.$_SESSION['empresa_ID'].' and del=0';


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
    static function getCount($filtro = '') {
        $cn = new connect();
        try {
            $q='select count(ID)';
            $q.=' from inventario where empresa_ID='.$_SESSION['empresa_ID'].' and del=0';


            if ($filtro != '') {
                $q.=' and ' . $filtro;
            }
            //echo $q;
            $retornar = $cn->getData($q);
            
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    static function getGridInventario($filtro = '', $desde = -1, $hasta = -1, $order = 'inv.ID asc') {
        $cn = new connect();
        try {
            $q="select inv.ID,pro.nombre as producto,(case when ovd.tipo=3 then 'Componente' else 'Adicional' end) as tipo, (case when inv.serie is null or inv.serie='NULL' then '' else inv.serie end)  as serie,";
            $q.="(case when inv.ingreso_detalle_ID is null then '' else cd.ID end ) as ingreso_detalle,";
            $q.="(case when inv.ingreso_detalle_ID is null then '' else co.numero end ) as numero_ingreso,";
            $q.="(case when inv.salida_detalle_ID is null then '' else ovd.ID end ) as salida_detalle_ID,";
            $q.="(case when inv.salida_detalle_ID is null then '' else ov.numero_concatenado end ) as numero_salida,";
            $q.="ifNull((case when inv.salida_detalle_ID is null then '' else fv.numero_concatenado end ),'') as numero_factura_venta,";
            $q.="ifNull((case when inv.salida_detalle_ID is null then '' else gv.numero_concatenado end ),'') as numero_guia_venta,";
            $q.="(case when inv.cotizacion_detalle_ID is null then '' else cod.ID end ) as cotizacion_detalle_ID,";
            $q.="(case when inv.cotizacion_detalle_ID is null then '' else cot.numero_concatenado end ) as numero_cotizacion";
            $q.=" from inventario inv left join ingreso_detalle cd on inv.ingreso_detalle_ID=cd.ID";
            $q.=" left join ingreso co on cd.ingreso_ID=co.ID";
            $q.=" left join salida_detalle ovd on inv.salida_detalle_ID=ovd.ID ";
            $q.=" left join salida ov on ovd.salida_ID=ov.ID";
            $q.=" left join factura_venta fv on fv.salida_ID=ov.ID";
            $q.=" left join guia_venta gv on ov.ID=gv.salida_ID";
            $q.=" left join cotizacion_detalle cod on inv.cotizacion_detalle_ID=cod.ID";
            $q.=" left join cotizacion cot on cod.cotizacion_ID=cot.ID, producto pro";
            $q.=" where inv.producto_ID=pro.ID and inv.del=0 ";
          
            
          
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
    static function getGridInventario1($filtro = '', $desde = -1, $hasta = -1, $order = 'inv.ID asc') {
        $cn = new connect();
        try {
            $q="select inv.ID,inv.producto_ID,ifnull(inv.ingreso_detalle_ID,-1) as ingreso_detalle_ID ,ifnull(inv.salida_detalle_ID,-1) as salida_detalle_ID,";
            $q.="inv.descripcion,inv.estado_ID,inv.utilidad_soles,inv.utilidad_dolares,inv.comision_soles,inv.comision_dolares,";
            $q.="inv.serie,ifnull(inv.cotizacion_detalle_ID,-1) as  cotizacion_detalle_ID,";
            $q.="pro.nombre as producto,pro.estado_ID as estado_producto";
            $q.=" from inventario inv, producto pro";
            $q.=" where inv.producto_ID=pro.ID and inv.del=0";
                     
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
     static function getGridProductos($filtro = '', $desde = -1, $hasta = -1, $order = 'pro.nombre asc') {
        $cn = new connect();
        try {
            $q='select pro.ID as codigo,pro.nombre as producto,(select count(ID) from inventario where producto_ID=pro.ID and estado_ID=48) as total';
            $q.=' from producto pro';
            $q.=' where pro.del=0 and estado_ID<>54';
            if ($filtro != '') {
                $q.=' and ' . $filtro;
            }
            //$q.=' group by pro.nombre,pro.ID';
            
            $q.=' Order By ' . $order;

            if ($desde != -1 && $hasta != -1) {
                $q.=' Limit ' . $desde . ',' . $hasta;
            }
           
            $dt = $cn->getGrid($q);
            
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    
    
        static function getGridingresoAnulada($filtro = '', $desde = -1, $hasta = -1, $order = 'inv.ID asc') {
        $cn = new connect();
        try {
            $q='select inv.ID, inv.producto_ID,inv.ingreso_detalle_ID,inv.salida_detalle_ID,cod.descripcion,cod.ID as codigo_ingresodetalle, co.ID as codigo_ingreso,inv.estado_ID ';
            $q.=' from inventario inv, ingreso_detalle cod, ingreso co ';
            $q.=' where inv.del=0 and co.ID = cod.ingreso_ID and cod.ID = inv.ingreso_detalle_ID ';
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
    
    
    
    
      static function getGridComprobarVenta($filtro = '', $desde = -1, $hasta = -1, $order = 'inv.ID asc') {
        $cn = new connect();
        try {
            $q='select inv.ID, inv.producto_ID,inv.ingreso_detalle_ID,inv.salida_detalle_ID,cod.descripcion,cod.ID as codigo_ingresodetalle, co.ID as codigo_ingreso,inv.estado_ID ';
            $q.=' from inventario inv, ingreso_detalle cod, ingreso co ';
            $q.=' where inv.del=0 and co.ID = cod.ingreso_ID and cod.ID = inv.ingreso_detalle_ID and inv.salida_detalle_ID !="" and inv.ingreso_detalle_ID !="" ';
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
    
    
     static function getCountProductos($filtro = '') {
        $cn = new connect();
        try {
            $q='SELECT COUNT(*) FROM (';
            $q.='select pro.nombre as producto, pro.ID as codigo,count(inv.ID) as total';
            $q.=' from inventario inv, producto pro';
            $q.=' where inv.producto_ID=pro.ID and inv.del=0';
            if ($filtro != '') {
                $q.=' and ' . $filtro;
            }
             $q.=' group by pro.nombre,pro.ID';
            
            $q.=') as TOTAL';
            $resultado = $cn->getData($q);
            return $resultado;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    function actualizar2($ingreso_detalle_ID){
        $cn =new connect();
        $retornar=-1;
        try{
            $fecha='NULL';
                if($this->fecha!=null){
                        $fecha='"'.FormatTextToDate($this->fecha,'Y-m-d').'"';
                }
                $q="UPDATE inventario SET producto_ID=".$this->producto_ID.", descripcion='".FormatTextSave($this->descripcion)."',cantidad_ingreso=".$this->cantidad_ingreso.",fecha=".$fecha.",stock=".$this->stock.",";
                $q.=" usuario_mod_id=".$this->usuario_mod_id.", fdm=Now()";
                $q.=" WHERE ingreso_detalle_ID=".$ingreso_detalle_ID;
               // echo $q;
                $retornar=$cn->transa($q);
                $this->getMessage='Se guardó correctamente';
                $q="select ID from inventario where del=0 and ingreso_detalle_ID=".$ingreso_detalle_ID;
                $ID=$cn->getData($q);        
                $this->ID=$ID;
                return $retornar;
        }
        catch(Exception $ex){
                throw new Exception("Ocurrio un error en la consulta");
        }
    }
     function actualizarEstadoAutomatico(){
        $cn =new connect();
        $retornar=-1;
        try{
            
                $q="UPDATE inventario SET estado_ID=".$this->estado_ID;
                $q.=" WHERE ID=".$this->ID;
               // echo $q;
                $retornar=$cn->transa($q);
                $this->getMessage='Se guardó correctamente';
                
                return $retornar;
        }
        catch(Exception $ex){
                throw new Exception("Ocurrio un error en la consulta");
        }
    }
    function actualizarUltimostock($stock){
        $cn =new connect();
        $retornar=-1;
        try{
            
                $q="UPDATE inventario SET stock=".$stock;
                $q.=" where ID=(select max(ID)from inventario where producto_ID=)";
                $retornar=$cn->transa($q);
                $this->getMessage='Se guardó correctamente';
                $q="select ID from inventario where del=0 and ingreso_detalle_ID=".$ingreso_detalle_ID;
                $ID=$cn->getData($q);        
                $this->ID=$ID;
                return $retornar;
        }
        catch(Exception $ex){
                throw new Exception("Ocurrio un error en la consulta");
        } 
    }
    
    function actualizarEstadoAnulacion() {
        $cn = new connect();
        $retornar = -1;
        try {

            $q = 'UPDATE inventario set estado_ID=58, usuario_mod_id=' . $this->usuario_mod_id;
            $q.=', fdm=now() where del=0 and ID=' . $this->ID;
            //echo $q;
            $retornar = $cn->transa($q);
            $this->getMessage = 'Se guardó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    
    
    function eliminar2(){
         $cn =new connect();
            $retornar=-1;
            try{

                $q='UPDATE inventario SET cantidad_ingreso='.$this->cantidad_ingreso.',stock='.$this->stock.',ingreso_detalle_ID=null, usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
                $q.=' WHERE ID='.$this->ID;

                $retornar=$cn->transa($q);

                $this->getMessage='Se eliminó correctamente.';
                return $retornar;
            }
            catch(Exception $ex){
                throw new Exception("Ocurrio un error en la consulta.");
            }
    }
    function eliminar(){
         $cn =new connect();
            $retornar=-1;
            try{

                    $q='DELETE FROM inventario ';
                    $q.=' WHERE ID='.$this->ID;

                    $retornar=$cn->transa($q);

                    $this->getMessage='Se eliminó correctamente.';
                    return $retornar;
            }
            catch(Exception $ex){
                    throw new Exception("Ocurrio un error en la consulta.");
            }
    }
    function getStock($producto_ID){
        $cn =new connect();
         try 
         {
                 //$q='select ifnull(stock,0) from inventario where del=0 and producto_ID='.$producto_ID.'  order by ID desc limit 1  ';
                $q="select count(inv.ID) from inventario inv INNER JOIN ingreso_detalle cd ON inv.ingreso_detalle_ID=cd.ID where inv.del=0 and cd.del=0 and inv.producto_ID=".$producto_ID." and inv.estado_ID=48" ;
                $existencia=$cn->getData($q);
                $vendidos=$cn->getData("select count(inv.ID) from inventario inv  INNER JOIN salida_detalle ovd ON inv.salida_detalle_ID=ovd.ID where inv.del=0 and ovd.del=0 and inv.producto_ID=".$producto_ID." and inv.estado_ID=50");
                
                $retorna=$existencia-$vendidos;		
                return $retorna;
                //echo $q;
         }catch(Exeption $ex)
         {
                 throw new Exception($q);
         }
    }
    function getGuiaFaltanteSeries($producto_ID){
        $cn =new connect();
         try 
         {
                 $q='select inv.ID, inv.producto_ID,inv.salida_detalle_ID,inv.cantidad_salida,inv.stock,DATE_FORMAT(inv.fecha,"%d-%m-%Y") as fecha,inv.descripcion,';
                 $q.='ov.ID as salida_ID,ov.numero ';
                 $q.='from inventario inv,salida ov,salida_detalle ovd ';
                 $q.='where inv.salida_detalle_ID=ovd.ID and ovd.salida_ID=ov.ID and inv.del=0 and ov.del=0 and ovd.del=0  and inv.producto_ID='.$producto_ID.' and inv.tipo="salida" ';
                 $q.='and inv.cantidad_salida>(select count(ID) from  inventario_detalle where del=0 and inventario_ID=inv.ID)';
                 
                 //echo $q;
                 $dt=$cn->getGrid($q);			
                 $retorna=$dt;
                 return $retorna;
                 
         }catch(Exeption $ex)
         {
                 throw new Exception("Ocurrio un error en la consultagui");
         }
    }
    function getsalida_detalle($producto_ID,$ingreso_detalle_ID){
         $cn =new connect();
         try 
         {
                $q='select count(inv.ID) as cantidad,group_concat(inv.ID separator"|") as IDs,inv.salida_detalle_ID from inventario inv';
                $q.=' LEFT JOIN salida_detalle ovd ON inv.salida_detalle_ID=ovd.ID';
                $q.=' where inv.del=0  and ';
                if($ingreso_detalle_ID==0){
                    $q.='inv.estado_ID=50';
                }else {
                     $q.='(inv.estado_ID=50 or inv.ingreso_detalle_ID='.$ingreso_detalle_ID.')';
                }
                $q.=' and inv.producto_ID='.$producto_ID.' and ovd.del=0';
                $q.=' group by salida_detalle_ID ';
                
                 //echo $q;
                $dt=$cn->getGrid($q);			
                $retorna=$dt;
                return $retorna;
                 
         }catch(Exeption $ex)
         {
                 throw new Exception("Ocurrio un error en la consultagui");
         }
    }
    function getReporteComisiones(){
         $cn =new connect();
         try 
         {
                $q='select ovd.ID,ov.fecha,  ov.moneda_ID as moneda_venta,round(ov.tipo_cambio,2) as tipo_cambio_venta,ovd.precio_venta_unitario_soles,ovd.precio_venta_unitario_dolares,co.moneda_ID as moneda_ingreso,co.tipo_cambio as tipo_cambio_ingreso,';
                $q.='(case when co.moneda_ID=2 then  round(cod.precio*co.tipo_cambio,2) else cod.precio end) as precio_ingreso_soles,';
                $q.=' (case when co.moneda_ID=1 then  round(cod.precio/co.tipo_cambio,2) else cod.precio end) as precio_ingreso_dolares, ';
                $q.=' inv.utilidad_soles,inv.utilidad_dolares,inv.comision_soles,inv.comision_dolares';
                $q.=' from inventario inv , salida_detalle ovd,salida ov, ingreso_detalle cod,ingreso co ';
                $q.=' where inv.del=0 and ov.ID=ovd.salida_ID and ovd.ID=inv.salida_detalle_ID and inv.ingreso_detalle_ID=cod.ID and cod.ingreso_ID=co.ID  ';
                $q.=' and inv.estado_ID=49 order by inv.salida_detalle_ID asc ';
                
                 //echo $q;
                $dt=$cn->getGrid($q);			
                $retorna=$dt;
                return $retorna;
                 
         }catch(Exeption $ex)
         {
            throw new Exception("Ocurrio un error en la consultagui");
         }
    }    
    static function getMovimientoProducto($producto_ID) {
        $cn = new connect();
        try {
            
            $q="CREATE TEMPORARY TABLE  IF NOT EXISTS Temporal(";
            $q.=" select cd.ID as movimiento_ID,'ingreso' as movimiento ,co.serie,co.numero, co.fecha_emision as fecha ,pro.ID as producto_ID, pro.nombre as producto, ";
            $q.="cd.cantidad,cd.descripcion,cd.precio,cd.subtotal, cd.igv,cd.total,mo.descripcion as moneda";
            $q.=" from producto pro,ingreso co,  ingreso_detalle cd, moneda mo";
            $q.=" where cd.ingreso_ID=co.ID and cd.producto_ID=pro.ID and co.moneda_ID=mo.ID and cd.del=0 and cd.producto_ID=".$producto_ID.");";
            //echo $q;
            /*$q.=" UNION ";*/
            $cn->transa($q);
            $q=" INSERT INTO Temporal (select ovd.ID as movimiento_ID,'Venta' as movimiento, '001' as serie,fv.numero, fv.fecha_emision as fecha ,pro.ID as producto_ID, pro.nombre as producto,ovd.cantidad,ovd.descripcion,";
            $q.="(case when ov.moneda_ID=1 then ovd.precio_venta_unitario_soles else ovd.precio_venta_unitario_dolares end) as precio,";
            $q.="(case when ov.moneda_ID=1 then ovd.precio_venta_subtotal_soles else ovd.precio_venta_subtotal_dolares end) as subtotal,";
            $q.="(case when ov.moneda_ID=1 then ovd.vigv_soles else ovd.vigv_dolares end ) as igv,";
            $q.="(case when ov.moneda_ID=1 then ovd.precio_venta_soles else ovd.precio_venta_dolares end) as total,mo.descripcion as moneda";
            $q.=" from producto pro,salida ov,  salida_detalle ovd, moneda mo,factura_venta fv";
            $q.=" where ovd.salida_ID=ov.ID and ovd.producto_ID=pro.ID and fv.salida_ID=ov.ID and ov.moneda_ID=mo.ID and ovd.del=0 and ovd.producto_ID=".$producto_ID.");";
            $cn->transa($q);
            //echo $q;
            $q=" SELECT * FROM Temporal ORDER BY fecha ASC;";
            $dt = $cn->getGrid($q);
            
            $q.=" DROP TABLE IF EXISTS Temporal;";
            $cn->transa($q);
          
            
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }
    
}
