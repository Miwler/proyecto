<?php


class orden_compra_detalle {
    
    private $ID;
    private $orden_compra_ID;
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
            if (property_exists('orden_compra_detalle',$temporal))
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
            if (property_exists('orden_compra_detalle', $temporal))
             {
                    return $this->$temporal;
             }

            // Retorna nulo si no existe
            return null;
    }
    
   
    function insertar(){
		$cn =new connect();
		$retornar=-1;
		try{
                    $ID=0;
			$q="select ifnull(max(ID),0)+1 as ID from orden_compra_detalle;";
			$ID=$cn->getData($q);
			
			$q="INSERT INTO orden_compra_detalle(ID,orden_compra_ID,producto_ID,descripcion,cantidad,precio,subtotal,igv,total,usuario_id) ";
			$q.="VALUES (".$ID.",".$this->orden_compra_ID.",".$this->producto_ID.",'".$this->descripcion."',".$this->cantidad.",'";
			$q.=number_format($this->precio,2,'.','')."','".number_format($this->subtotal,2,'.','')."','".number_format($this->igv,2,'.','')."','".number_format($this->total,2,'.','')."',".$this->usuario_id.');';
			//echo $q;
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
		
    function actualizar(){
            $cn =new connect();
            $retornar=-1;
            try{

                    $q="UPDATE orden_compra_detalle SET producto_ID=".$this->producto_ID.", descripcion='".$this->descripcion."',cantidad=".$this->cantidad.",precio='".number_format($this->precio,2,'.','')."',subtotal='".number_format($this->subtotal,2,'.','')."',";
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
            $cn =new connect();
            $retornar=-1;
            try{

                    $q='UPDATE orden_compra_detalle SET del=1,usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
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
            $cn =new connect();
            try 
            {
                    $q='Select ID,orden_compra_ID,producto_ID,descripcion,cantidad,precio,subtotal,igv,total,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
                    $q.=' from orden_compra_detalle ';
                    $q.=' where ID='.$ID;
                    //echo $q;
                    $dt=$cn->getGrid($q);			
                    $oOrden_compra_detalle=null;

                    foreach($dt as $item)
                    {
                            $oOrden_compra_detalle=new orden_compra_detalle();

                            $oOrden_compra_detalle->ID=$item['ID'];
                            $oOrden_compra_detalle->orden_compra_ID=$item['orden_compra_ID'];
                            $oOrden_compra_detalle->producto_ID=$item['producto_ID'];
                            $oOrden_compra_detalle->descripcion=$item['descripcion'];
                            $oOrden_compra_detalle->cantidad=$item['cantidad'];
                            $oOrden_compra_detalle->precio=$item['precio'];
                            $oOrden_compra_detalle->subtotal=$item['subtotal'];
                            $oOrden_compra_detalle->igv=$item['igv'];
                            $oOrden_compra_detalle->total=$item['total'];
                            $oOrden_compra_detalle->usuario_id=$item['usuario_id'];
                            $oOrden_compra_detalle->usuario_mod_id=$item['usuario_mod_id'];
                    }			
                    return $oOrden_compra_detalle;
            }catch(Exeption $ex)
            {
                    throw new Exception("Ocurrio un error en la consulta.");
            }
    }

    function verificarDuplicado(){
            $cn =new connect();
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
            $cn =new connect();
            try 
            {
                    $q='select count(ocd.ID) ';
                    $q.=' FROM orden_compra_detalle ocd, producto pro,orden_compra oc';
                    $q.=' where ocd.del=0 and oc.del=0 and ocd.orden_compra_ID=oc.ID and ocd.producto_ID=pro.ID';

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
            $cn =new connect();
            try 
            {
                    $q='select ocd.ID,ocd.producto_ID,ocd.orden_compra_ID,ocd.descripcion,ocd.cantidad,';
                    $q.='ocd.precio,ocd.subtotal,ocd.igv,ocd.total,pro.nombre as producto,ifnull(ocd.usuario_mod_id,-1) as usuario_mod_id';
                    $q.=' FROM orden_compra_detalle ocd, producto pro,orden_compra oc';
                    $q.=' where ocd.del=0 and oc.del=0 and ocd.orden_compra_ID=oc.ID and ocd.producto_ID=pro.ID';

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
