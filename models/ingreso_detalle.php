<?php


class ingreso_detalle {
    private $ID;
    private $ingreso_ID;
    private $producto_ID;
    private $descripcion;
    private $cantidad;
    private $precio;
    private $subtotal;
    private $igv;
    private $total;
    private $usuario_id;	
    private $usuario_mod_id;
    private $destino;
    private $vigv; 
    private $stock; 
    private $oProducto;
    private $dtInventario;
    private $oMoneda;
    private $dtProducto;
    private $getMessage;
    //private $documentos;

    public function __set($var, $valor)
    {
            // convierte a minúsculas toda una cadena la función strtolower
            $temporal = $var;

            // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
            if (property_exists('ingreso_detalle',$temporal))
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
            if (property_exists('ingreso_detalle', $temporal))
             {
                    return $this->$temporal;
             }

            // Retorna nulo si no existe
            return null;
    }
    
   
    function insertar(){
		
		$retornar=-1;
		try{
                    $ID=0;
			$q="select ifnull(max(ID),0)+1 as ID from ingreso_detalle;";
                        $cn =new connect_new();
			$ID=$cn->getData($q);
			
			$q="INSERT INTO ingreso_detalle(ID,ingreso_ID,producto_ID,descripcion,cantidad,precio,subtotal,igv,total,usuario_id,destino) ";
			$q.="VALUES (".$ID.",".$this->ingreso_ID.",".$this->producto_ID.",'".$this->descripcion."',".$this->cantidad.",'";
			$q.=round($this->precio,2)."','".round($this->subtotal,2)."','".round($this->igv,2)."','".round($this->total,2)."',".$this->usuario_id.','.$this->destino.');';
			//echo $q;
                        $cn =new connect_new();
			$retornar=$cn->transa($q);
			
			
			$this->ID=$ID;
			//echo $q;
			$this->getMessage='Se guardó correctamente';
			return $retornar;
		}
		catch(Exception $ex){
			throw new Exception("Ocurrio un error en la consulta insertar ingresodetalle");
		}
	}	
    function insertar1()
    {
    $cn =new connect_new();
    try
    {
      $ID=$cn->store_procedure_transa(
          "sp_ingreso_detalle_Insert",
            array(
                "iID"=>0,
                "iingreso_ID"=>$this->ingreso_ID,
                "iproducto_ID"=>$this->producto_ID,
                "idescripcion"=>$this->descripcion,
                "icantidad"=>$this->cantidad,
                "iprecio"=>$this->precio,
                "isubtotal"=>$this->subtotal,
                "iigv"=>$this->igv,
                "itotal"=>$this->total,
                "idestino"=>$this->destino,
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
      log_error(__FILE__, "ingreso_detalle.insertar", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }	
    function actualizar(){
            $cn =new connect_new();
            $retornar=-1;
            try{

                    $q="UPDATE ingreso_detalle SET producto_ID=".$this->producto_ID.", descripcion='".FormatTextSave($this->descripcion)."',cantidad=".$this->cantidad.",precio='".number_format($this->precio,2,'.','')."',subtotal='".number_format($this->subtotal,2,'.','')."',";
                    $q.="igv='".number_format($this->igv,2,'.','')."',total='".number_format($this->total,2,'.','')."',destino=".$this->destino.",usuario_mod_id=".$this->usuario_mod_id.", fdm=Now()";
                    $q.=" WHERE ID=".$this->ID;

                    $retornar=$cn->transa($q);

                    $this->getMessage='Se guardó correctamente';
                    //echo $q;
                    return $retornar;
            }
            catch(Exception $ex){
                    throw new Exception("Ocurrio un error en la consulta");
            }
    }
     function actualizar1()
    {
    $cn =new connect_new();
    $retornar =0;
    try
    {
      $ID=$cn->store_procedure_transa(
          "sp_ingreso_detalle_Update",
            array(
              "retornar"=>$retornar,
                "iID"=>$this->ID,
                "iingreso_ID"=>$this->ingreso_ID,
                "iproducto_ID"=>$this->producto_ID,
                "idescripcion"=>$this->descripcion,
                "icantidad"=>$this->cantidad,
                "iprecio"=>$this->precio,
                "isubtotal"=>$this->subtotal,
                "iigv"=>$this->igv,
                "itotal"=>$this->total,
                "idestino"=>$this->destino,
                "iusuario_mod_id"=>$this->usuario_mod_id
            ),0);
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "ingreso_detalle.actualizar", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
    function eliminar(){
            $cn =new connect_new();
            $retornar=-1;
            try{

                    $q='UPDATE ingreso_detalle SET del=1,usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
                    $q.=' WHERE ID='.$this->ID;
                    //echo $q;
                    $retornar=$cn->transa($q);

                    $this->getMessage='Se eliminó correctamente.';
                    return $retornar;
            }
            catch(Exception $ex){
                    throw new Exception("Ocurrio un error en la consulta.");
            }
    }

    static function getByID($ID)
    {
            $cn =new connect_new();
            try 
            {
                    $q='Select ID,ingreso_ID,producto_ID,descripcion,cantidad,precio,subtotal,igv,total,destino,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
                    $q.=' from ingreso_detalle ';
                    $q.=' where ID='.$ID;
                    //echo $q;
                    $dt=$cn->getGrid($q);			
                    $oingreso_detalle=null;

                    foreach($dt as $item)
                    {
                            $oingreso_detalle=new ingreso_detalle();

                            $oingreso_detalle->ID=$item['ID'];
                            $oingreso_detalle->ingreso_ID=$item['ingreso_ID'];
                            $oingreso_detalle->producto_ID=$item['producto_ID'];
                            $oingreso_detalle->descripcion=$item['descripcion'];
                            $oingreso_detalle->cantidad=$item['cantidad'];
                            $oingreso_detalle->precio=$item['precio'];
                            $oingreso_detalle->subtotal=$item['subtotal'];
                            $oingreso_detalle->igv=$item['igv'];
                            $oingreso_detalle->total=$item['total'];
                            $oingreso_detalle->destino=$item['destino'];
                            $oingreso_detalle->usuario_id=$item['usuario_id'];
                            $oingreso_detalle->usuario_mod_id=$item['usuario_mod_id'];
                    }			
                    return $oingreso_detalle;
            }catch(Exeption $ex)
            {
                    throw new Exception("Ocurrio un error en la consulta.");
            }
    }

    function verificarDuplicado(){
            $cn =new connect_new();
            $retornar=-1;
            try{
                    return $retornar;
            }
            catch(Exception $ex){
                    throw new Exception("Ocurrio un error en la consulta");
            }
    }

    static function getCount($filtro='')
    {
        $cn =new connect_new();
        try 
        {
            $q='select count(ccd.ID) ';
            $q.=' FROM ingreso_detalle as ccd';
            $q.=' where ccd.del=0';

            if ($filtro!='')
            {
                    $q.=' and '.$filtro;
            }
            //echo $q;
            $resultado=$cn->getData($q);									

            return $resultado;					
        }catch(Exception $ex)
        {
                throw new Exception($q);
        }
    } 

    static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='ccd.ID asc')
    {
            $cn =new connect_new();
            try 
            {
                    $q='select ccd.ID as codigo,ccd.producto_ID,ccd.ingreso_ID,ccd.descripcion,ccd.cantidad,co.proveedor_ID,';
                    $q.='ccd.precio,ccd.subtotal,ccd.igv,ccd.total,pro.nombre as producto,ccd.destino,ifnull(ccd.usuario_mod_id,-1) as usuario_mod_id, es.nombre as estado';
                    $q.=' FROM ingreso_detalle ccd, producto pro,estado es,ingreso co';
                    $q.=' where ccd.del=0 and co.del=0 and ccd.ingreso_ID=co.ID and ccd.producto_ID=pro.ID and pro.estado_ID=es.ID';

                    if($filtro!=''){
                            $q.=' and '.$filtro;
                    }

                    $q.=' Order By '.$order;

                    if($desde!=-1&&$hasta!=-1){
                            $q.=' Limit '.$desde.','.$hasta;
                    }			

                    $dt=$cn->getGrid($q);	
                    //echo $q;
                    return $dt;												
            }catch(Exception $ex)
            {
                    throw new Exception($q);
            }
    }
    static function getGridPrecioingreso($producto_ID)
    {
            
            try 
            {
                $cn =new connect_new();
                $dt=$cn->store_procedure_getGrid("sp_producto_getGridPrecioCompra",
                        array("iproducto_ID"=>$producto_ID));
                //$q='create temporary TABLE tbprecio_ingreso  select cd.ID,cd.ingreso_ID,cd.precio,(case when co.moneda_ID=1 then cd.precio else round(cd.precio*co.tipo_cambio,2) end) as precio_soles,(case when co.moneda_ID=2 then cd.precio else round(cd.precio/co.tipo_cambio,2) end) as precio_dolares,co.tipo_cambio,co.fecha_emision';
                
               // $q.=' from ingreso_detalle cd,ingreso co';
                //$q.=' where cd.del=0 and co.del=0 and cd.ingreso_ID=co.ID and cd.producto_ID='.$producto_ID.' order by co.fecha_emision desc limit 0, 20;';
                
                //$cn =new connect_new();
                //$cn->transa($q);
                //$q.=' select precio_soles,  precio_dolares from tbprecio_ingreso group by precio_soles, precio_dolares order by precio_dolares desc limit 1,1;';    
                //$cn =new connect_new();
                //$dt=$cn->getGrid($q);
                //$q.='drop table tbprecio_ingreso;';
                //$cn =new connect_new();
                //$dt=$cn->getGrid($q);
                //$cn->transa($q);   
                return $dt;												
            }catch(Exception $ex)
            {
                    throw new Exception($q);
            }
    }

}
