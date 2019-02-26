<?php


class orden_ingreso_detalle {
    
    private $ID;
    private $orden_ingreso_ID;
    private $producto_ID;
    private $descripcion;
    private $cantidad;
    private $precio;
    private $subtotal;
    private $igv;
    private $total;
    private $usuario_id;	
    private $usuario_mod_id;
      
    private $vigv; 
    private $oMoneda;
    private $getMessage;
    private $stock;
    //private $documentos;
    private $oProducto;
    public function __set($var, $valor)
    {
            // convierte a minúsculas toda una cadena la función strtolower
            $temporal = $var;

            // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
            if (property_exists('orden_ingreso_detalle',$temporal))
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
            if (property_exists('orden_ingreso_detalle', $temporal))
             {
                    return $this->$temporal;
             }

            // Retorna nulo si no existe
            return null;
    }
    
    function insertar1()
    {
    $cn =new connect_new();
    try
    {
      $ID=$cn->store_procedure_transa(
          "sp_orden_ingreso_detalle_Insert",
            array(
                "iID"=>0,
                "iorden_ingreso_ID"=>$this->orden_ingreso_ID,
                "iproducto_ID"=>$this->producto_ID,
                "idescripcion"=>$this->descripcion,
                "icantidad"=>$this->cantidad,
                "iprecio"=>$this->precio,
                "isubtotal"=>$this->subtotal,
                "iigv"=>$this->igv,
                "itotal"=>$this->total,
                "iusuario_id"=>$this->usuario_id,

            ),0);
      if($ID>0){
        $this->getMessage="El registro se guardó correctamente.";
        $this->ID=$ID;
        
      }
      return $ID;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "orden_ingreso_detalle.insertar", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
    function insertar(){
		
		$retornar=-1;
		try{
                    $ID=0;
			$q="select ifnull(max(ID),0)+1 as ID from orden_ingreso_detalle;";
                        $cn =new connect_new();
			$ID=$cn->getData($q);
			
			$q="INSERT INTO orden_ingreso_detalle(ID,orden_ingreso_ID,producto_ID,descripcion,cantidad,precio,subtotal,igv,total,usuario_id) ";
			$q.="VALUES (".$ID.",".$this->orden_ingreso_ID.",".$this->producto_ID.",'".$this->descripcion."',".$this->cantidad.",'";
			$q.=number_format($this->precio,2,'.','')."','".number_format($this->subtotal,2,'.','')."','".number_format($this->igv,2,'.','')."','".number_format($this->total,2,'.','')."',".$this->usuario_id.');';
			//echo $q;
                        $cn =new connect_new();
			$retornar=$cn->transa($q);
			
			
			$this->ID=$ID;
			//echo $q;
			$this->getMessage='Se guardó correctamente';
			return $retornar;
		}
		catch(Exception $ex){
			throw new Exception("Ocurrio un error en la consulta insertar compradetalle");
		}
	}	
    function actualizar1()
    {
    $cn =new connect_new();
    $retornar =0;
        try
        {
            $retornar=$cn->store_procedure_transa(
              "sp_orden_ingreso_detalle_Update",
                array(
                    "retornar"=>$retornar,
                    "iID"=>$this->ID,
                    "iorden_ingreso_ID"=>$this->orden_ingreso_ID,
                    "iproducto_ID"=>$this->producto_ID,
                    "idescripcion"=>$this->descripcion,
                    "icantidad"=>$this->cantidad,
                    "iprecio"=>$this->precio,
                    "isubtotal"=>$this->subtotal,
                    "iigv"=>$this->igv,
                    "itotal"=>$this->total,
                    "iusuario_mod_id"=>$this->usuario_mod_id
                ),0);
            if($retornar>0){
                 $this->getMessage='Se actualizó correctamente.';
            }
          return $retornar;
        }catch(Exeption $ex)
        {
          log_error(__FILE__, "orden_ingreso_detalle.actualizar", $ex->getMessage());
          throw new Exception($ex->getMessage());
        }
    }    
    function actualizar(){
            $cn =new connect_new();
            $retornar=-1;
            try{

                    $q="UPDATE orden_ingreso_detalle SET producto_ID=".$this->producto_ID.", descripcion='".$this->descripcion."',cantidad=".$this->cantidad.",precio='".number_format($this->precio,2,'.','')."',subtotal='".number_format($this->subtotal,2,'.','')."',";
                    $q.="igv='".number_format($this->igv,2,'.','')."',total='".number_format($this->total,2,'.','')."',usuario_mod_id=".$this->usuario_mod_id.", fdm=Now()";
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

    function eliminar(){
            $cn =new connect_new();
            $retornar=-1;
            try{

                    $q='UPDATE orden_ingreso_detalle SET del=1,usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
                    $q.=' WHERE ID='.$this->ID;

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
                    $q='Select ID,orden_ingreso_ID,producto_ID,descripcion,cantidad,precio,subtotal,igv,total,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
                    $q.=' from orden_ingreso_detalle ';
                    $q.=' where ID='.$ID;
                    //echo $q;
                    $dt=$cn->getGrid($q);			
                    $oorden_ingreso_detalle=null;

                    foreach($dt as $item)
                    {
                            $oorden_ingreso_detalle=new orden_ingreso_detalle();

                            $oorden_ingreso_detalle->ID=$item['ID'];
                            $oorden_ingreso_detalle->orden_ingreso_ID=$item['orden_ingreso_ID'];
                            $oorden_ingreso_detalle->producto_ID=$item['producto_ID'];
                            $oorden_ingreso_detalle->descripcion=$item['descripcion'];
                            $oorden_ingreso_detalle->cantidad=$item['cantidad'];
                            $oorden_ingreso_detalle->precio=$item['precio'];
                            $oorden_ingreso_detalle->subtotal=$item['subtotal'];
                            $oorden_ingreso_detalle->igv=$item['igv'];
                            $oorden_ingreso_detalle->total=$item['total'];
                            $oorden_ingreso_detalle->usuario_id=$item['usuario_id'];
                            $oorden_ingreso_detalle->usuario_mod_id=$item['usuario_mod_id'];
                    }			
                    return $oorden_ingreso_detalle;
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
                    $q='select count(ocd.ID) ';
                    $q.=' FROM orden_ingreso_detalle ocd, producto pro,orden_ingreso oc';
                    $q.=' where ocd.del=0 and oc.del=0 and ocd.orden_ingreso_ID=oc.ID and ocd.producto_ID=pro.ID';

                    if ($filtro!='')
                    {
                            $q.=' and '.$filtro;
                    }

                    $resultado=$cn->getData($q);									

                    return $resultado;					
            }catch(Exception $ex)
            {
                    throw new Exception("Ocurrio un error en la consulta getCount");
            }
    } 

    static function getGrid($filtro='',$desde=-1,$hasta=-1,$orden='ocd.ID asc')
    {
            $cn =new connect_new();
            try 
            {
                    $q='select ocd.ID,ocd.producto_ID,ocd.orden_ingreso_ID,ocd.descripcion,ocd.cantidad,';
                    $q.='ocd.precio,ocd.subtotal,ocd.igv,ocd.total,pro.nombre as producto,ifnull(ocd.usuario_mod_id,-1) as usuario_mod_id';
                    $q.=' FROM orden_ingreso_detalle ocd, producto pro,orden_ingreso oc';
                    $q.=' where ocd.del=0 and oc.del=0 and ocd.orden_ingreso_ID=oc.ID and ocd.producto_ID=pro.ID';

                    if($filtro!=''){
                        $q.=' and '.$filtro;
                    }

                    $q.=' Order By '.$orden;

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


}
