<?php


class compra_detalle {
    private $ID;
    private $compra_ID;
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
            if (property_exists('compra_detalle',$temporal))
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
            if (property_exists('compra_detalle', $temporal))
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
			$q="select ifnull(max(ID),0)+1 as ID from compra_detalle;";
			$ID=$cn->getData($q);
			
			$q="INSERT INTO compra_detalle(ID,compra_ID,producto_ID,descripcion,cantidad,precio,subtotal,igv,total,usuario_id,destino) ";
			$q.="VALUES (".$ID.",".$this->compra_ID.",".$this->producto_ID.",'".$this->descripcion."',".$this->cantidad.",'";
			$q.=number_format($this->precio,2,'.','')."','".number_format($this->subtotal,2,'.','')."','".number_format($this->igv,2,'.','')."','".number_format($this->total,2,'.','')."',".$this->usuario_id.','.$this->destino.');';
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

                    $q="UPDATE compra_detalle SET producto_ID=".$this->producto_ID.", descripcion='".$this->descripcion."',cantidad=".$this->cantidad.",precio='".number_format($this->precio,2,'.','')."',subtotal='".number_format($this->subtotal,2,'.','')."',";
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

    function eliminar(){
            $cn =new connect();
            $retornar=-1;
            try{

                    $q='UPDATE compra_detalle SET del=1,usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
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
            $cn =new connect();
            try 
            {
                    $q='Select ID,compra_ID,producto_ID,descripcion,cantidad,precio,subtotal,igv,total,destino,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
                    $q.=' from compra_detalle ';
                    $q.=' where ID='.$ID;
                    //echo $q;
                    $dt=$cn->getGrid($q);			
                    $ocompra_detalle=null;

                    foreach($dt as $item)
                    {
                            $ocompra_detalle=new compra_detalle();

                            $ocompra_detalle->ID=$item['ID'];
                            $ocompra_detalle->compra_ID=$item['compra_ID'];
                            $ocompra_detalle->producto_ID=$item['producto_ID'];
                            $ocompra_detalle->descripcion=$item['descripcion'];
                            $ocompra_detalle->cantidad=$item['cantidad'];
                            $ocompra_detalle->precio=$item['precio'];
                            $ocompra_detalle->subtotal=$item['subtotal'];
                            $ocompra_detalle->igv=$item['igv'];
                            $ocompra_detalle->total=$item['total'];
                            $ocompra_detalle->destino=$item['destino'];
                            $ocompra_detalle->usuario_id=$item['usuario_id'];
                            $ocompra_detalle->usuario_mod_id=$item['usuario_mod_id'];
                    }			
                    return $ocompra_detalle;
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
            $q='select count(ccd.ID) ';
            $q.=' FROM compra_detalle as ccd';
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
            $cn =new connect();
            try 
            {
                    $q='select ccd.ID as codigo,ccd.producto_ID,ccd.compra_ID,ccd.descripcion,ccd.cantidad,';
                    $q.='ccd.precio,ccd.subtotal,ccd.igv,ccd.total,pro.nombre as producto,ccd.destino,ifnull(ccd.usuario_mod_id,-1) as usuario_mod_id, es.nombre as estado';
                    $q.=' FROM compra_detalle ccd, producto pro,estado es,compra co';
                    $q.=' where ccd.del=0 and co.del=0 and ccd.compra_ID=co.ID and ccd.producto_ID=pro.ID and pro.estado_ID=es.ID';

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
    static function getGridPrecioCompra($producto_ID)
    {
            $cn =new connect();
            try 
            {
                $q='create temporary TABLE tbprecio_compra  select cd.ID,cd.compra_ID,cd.precio,(case when co.moneda_ID=1 then cd.precio else round(cd.precio*co.tipo_cambio,2) end) as precio_soles,(case when co.moneda_ID=2 then cd.precio else round(cd.precio/co.tipo_cambio,2) end) as precio_dolares,co.tipo_cambio,co.fecha_emision';
                
                $q.=' from compra_detalle cd,compra co';
                $q.=' where cd.del=0 and co.del=0 and cd.compra_ID=co.ID and cd.producto_ID='.$producto_ID.' order by co.fecha_emision desc limit 0, 20;';
                $cn->transa($q);
                $q='select precio_soles,  precio_dolares from tbprecio_compra group by precio_soles, precio_dolares order by precio_dolares desc limit 1,1 ;';    
                $dt=$cn->getGrid($q);
                $q='drop table tbprecio_compra;'   ;
                 $cn->transa($q);   
                return $dt;												
            }catch(Exception $ex)
            {
                    throw new Exception($q);
            }
    }

}
