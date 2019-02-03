<?php

class cotizacion_detalle {

    private $ID;
    private $producto_ID;
    private $cotizacion_ID;
    private $descripcion;
    private $cantidad;
    private $precio_venta_unitario_soles;
    private $precio_venta_unitario_dolares;
    private $precio_venta_subtotal_soles;
    private $precio_venta_subtotal_dolares;
    private $precio_venta_soles;
    private $precio_venta_dolares;
    private $igv;
    private $vigv_soles;
    private $vigv_dolares;
    private $cotizacion_detalle_ID;
    private $estado_id;
    private $ver_precio;
    private $separacion;
    private $tiempo_separacion;
    private $cantidad_separada;
    private $usuario_id;
    private $usuario_mod_id;
    private $tipo_ID;
    private $tipo;
    private $orden_cotizacion;
    private $pagina_cotizacion;
    
//1 producto
//2 producto con componente (se convierte en una descripción y no descuenta stock)
//3 Componente (calcula el valor de venta del padre)
//4 Adicional (producto adiconal lleva un ID del un padre)
//5 producto con componente y adicional (se convierte en descripción, los componentes que lo integran hacen la suma de la venta total , el adicional suma al precio   )
//6 Producto con adicional
//7  Obsequio (se convierte en obsequio el costo de venta es 0)
   
    Private $message;
    private $oMoneda;
    private $cotizacion_detalle_padre_ID;
    private $oProducto;
    private $oCotizacion;
    private $precio_unitario;
    private $subtotal;
    private $vigv;
    private $total;
    private $linea_ID;
    private $categoria_ID;
    private $dtLinea;
    private $dtCategoria;
    private $stock;
    private $componente;
    private $adicional;
    private $adicional_soles;
    private $adicional_dolares;
    private $subtotal_soles1;
    private $subtotal_dolares1;
    public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
        if (property_exists('cotizacion_detalle', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('cotizacion_detalle', $temporal)) {
            return $this->$temporal;
        }

        // Retorna nulo si no existe
        return null;
    }

    function insertar() {
        
        $retorna = -1;
        try {
            $q = 'select ifnull(max(ID),0)+1 as ID from cotizacion_detalle;';
            $cn = new connect_new();
            $ID=$cn->getData($q);
            $cantidad_separada=0;
            if($this->cantidad_separada!=null){
                $cantidad_separada=$this->cantidad_separada;
            }
            $q = 'insert into cotizacion_detalle (ID,producto_ID,cotizacion_ID,descripcion,cantidad,precio_venta_unitario_soles,precio_venta_unitario_dolares,precio_venta_subtotal_soles,precio_venta_subtotal_dolares,';
            $q.='precio_venta_soles,precio_venta_dolares,igv,vigv_soles,vigv_dolares,cotizacion_detalle_ID,';
            $q.='estado_id,ver_precio,separacion,tiempo_separacion,cantidad_separada,tipo,tipo_ID,usuario_id)';
            $q.=' values('.$ID.',' .$this->producto_ID. ',' .$this->cotizacion_ID.',"'.$this->descripcion.'",'.$this->cantidad.','.$this->precio_venta_unitario_soles.','.$this->precio_venta_unitario_dolares.','.$this->precio_venta_subtotal_soles.','.$this->precio_venta_subtotal_dolares.',';
            $q.=$this->precio_venta_soles . ',' . $this->precio_venta_dolares . ',' . $this->igv . ',' . $this->vigv_soles.','.$this->vigv_dolares.','.$this->cotizacion_detalle_ID.',';
            $q.=$this->estado_id.','.$this->ver_precio.','.$this->separacion.','.$this->tiempo_separacion.','.$cantidad_separada.','.$this->tipo_ID.','.$this->tipo_ID.','.$this->usuario_id.')';
           //echo $q;
            $cn = new connect_new();
            $retorna = $cn->transa($q);

            $this->ID=$ID;
            $this->message = 'Se guardó correctamente';
            return $retorna;
        } catch (Exception $ex) {

            throw new Exception($q);
        }
    }

    function actualizar() {
        $cn = new connect_new();
        $retornar = -1;
        try {
            $q = 'update cotizacion_detalle set producto_ID='.$this->producto_ID.',cotizacion_ID='.$this->cotizacion_ID.',descripcion="'.$this->descripcion;
            $q.='",cantidad='.$this->cantidad.',precio_venta_unitario_soles='.$this->precio_venta_unitario_soles.',precio_venta_subtotal_soles='.$this->precio_venta_subtotal_soles;
            $q.=',precio_venta_subtotal_dolares='.$this->precio_venta_subtotal_dolares.',precio_venta_unitario_dolares='.$this->precio_venta_unitario_dolares.',igv='.$this->igv;
            $q.=',vigv_soles='.$this->vigv_soles.',vigv_dolares='.$this->vigv_dolares.',precio_venta_soles='.$this->precio_venta_soles.',precio_venta_dolares='.$this->precio_venta_dolares;
            $q.=',cotizacion_detalle_ID='.$this->cotizacion_detalle_ID.',estado_id='.$this->estado_id.',ver_precio='.$this->ver_precio.',separacion='.$this->separacion.',tiempo_separacion=';
            $q.=$this->tiempo_separacion.',cantidad_separada='.$this->cantidad_separada.',tipo='.$this->tipo.',usuario_mod_id='.$this->usuario_mod_id;
            $q.=', fdm=now() where del=0 and id=' . $this->ID;
            $retornar = $cn->transa($q);
            $this->message = 'Se guardó correctamente';
		//echo $q;
            return $retornar;
        } catch (Exception $ex) {
             throw new Exception($q);
        }
    }
    function actualizarTipo(){
        $cn =new connect_new();
	$retornar=-1;
        try{
            $q='update cotizacion_detalle set tipo='.$this->tipo;
            $q.=' where ID='.$this->ID;
            $retornar=$cn->transa($q);
            //$this->message='Se guardó correctamente';
            //echo $q;
            return $retornar;
        } catch (Exception $ex) {

        }
    }
     function actualizarDimension(){
        $cn =new connect_new();
	$retornar=-1;
        try{
            $q='update cotizacion_detalle set orden_cotizacion='.$this->orden_cotizacion;
            $q.=' ,pagina_cotizacion='.$this->pagina_cotizacion;
            $q.=' where ID='.$this->ID;
            $retornar=$cn->transa($q);
            //$this->message='Se guardó correctamente';
            //echo $q;
            return $retornar;
        } catch (Exception $ex) {

        }
    }
    function actualizarCosto(){
        $cn =new connect_new();
	$retornar=-1;
        try{
            $q='update cotizacion_detalle set precio_venta_unitario='.$this->precio_venta_unitario.', precio_venta='.$this->precio_venta.', usuario_mod_id='. $this->usuario_mod_id;
            $q.=', fdm=now() where del=0 and id='.$this->ID;
            $retornar=$cn->transa($q);
            $this->message='Se guardó correctamente';
            //echo $q;
            return $retornar;
        } catch (Exception $ex) {

        }
    }
    function actualizarCK() {
        $cn = new connect_new();
        $retornar = -1;
        try {
            $q = 'update cotizacion_detalle set ver_precio=' . $this->ver_precio. ', usuario_mod_id=' . $this->usuario_mod_id;
            $q.=', fdm=now() where del=0 and id=' . $this->ID;
            $retornar = $cn->transa($q);
            $this->message = 'Se guardó correctamente';
			//echo $q;
            return $q;
        } catch (Exception $ex) {
             throw new Exception("Ocurrio un error en la consulta");
        }
    }
    function eliminar() {
        $cn = new connect_new();
        $retornar = -1;
        try {

            $q = 'UPDATE cotizacion_detalle SET del=1,usuario_mod_id=' . $this->usuario_mod_id . ', fdm=Now()';
            $q.=' WHERE del=0 and ID=' . $this->ID;
            //echo $q;
            $retornar = $cn->transa($q);

            $this->message = 'Se eliminó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }

    static function getCount($filtro = '') {
        $cn = new connect_new();
        try {
            $q = 'SELECT COUNT(ID)';
            $q.= ' FROM cotizacion_detalle ';
            $q.=' where del=0 ';

            if ($filtro != '') {
                $q.=' and ' . $filtro;
            }
            //echo $q;
            $resultado = $cn->getData($q);

            return $resultado;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }

    static function getByID($ID) {
        $cn = new connect_new();
        try {
            $q = 'SELECT ID,producto_ID,cotizacion_ID,trim(descripcion) as descripcion,cantidad,precio_venta_unitario_soles,precio_venta_unitario_dolares,precio_venta_subtotal_soles,precio_venta_subtotal_dolares,';
            $q.='precio_venta_soles,precio_venta_dolares,igv,vigv_soles,vigv_dolares,cotizacion_detalle_ID,';
            $q.='estado_id,ver_precio,separacion, tiempo_separacion,cantidad_separada,tipo,tipo_ID,usuario_id,ifNull(usuario_mod_id,-1) as usuario_mod_id ';
            $q.=' FROM cotizacion_detalle ';
            $q.=' where del=0 and ID=' . $ID;
           // echo $q;
            $dt = $cn->getGrid($q);
            $oCotizacion_Detalle = null;

            foreach ($dt as $item) {
                $oCotizacion_Detalle = new cotizacion_detalle();

                $oCotizacion_Detalle->ID=$item['ID'];
                $oCotizacion_Detalle->producto_ID=$item['producto_ID'];
               
                $oCotizacion_Detalle->cotizacion_ID=$item['cotizacion_ID'];
                $oCotizacion_Detalle->descripcion=$item['descripcion'];
                $oCotizacion_Detalle->cantidad=$item['cantidad'];
                $oCotizacion_Detalle->precio_venta_unitario_soles=$item['precio_venta_unitario_soles'];
                $oCotizacion_Detalle->precio_venta_subtotal_soles=$item['precio_venta_subtotal_soles'];
                $oCotizacion_Detalle->precio_venta_subtotal_dolares=$item['precio_venta_subtotal_dolares'];
                $oCotizacion_Detalle->precio_venta_unitario_dolares=$item['precio_venta_unitario_dolares'];
                $oCotizacion_Detalle->igv=$item['igv'];
                $oCotizacion_Detalle->vigv_soles=$item['vigv_soles'];
                $oCotizacion_Detalle->vigv_dolares=$item['vigv_dolares'];
                $oCotizacion_Detalle->precio_venta_soles=$item['precio_venta_soles'];
                $oCotizacion_Detalle->precio_venta_dolares=$item['precio_venta_dolares'];
                $oCotizacion_Detalle->cotizacion_detalle_ID=$item['cotizacion_detalle_ID'];
                $oCotizacion_Detalle->estado_id=$item['estado_id'];
                $oCotizacion_Detalle->ver_precio=$item['ver_precio'];
                $oCotizacion_Detalle->separacion=$item['separacion'];
                $oCotizacion_Detalle->tiempo_separacion=$item['tiempo_separacion'];
                $oCotizacion_Detalle->cantidad_separada=$item['cantidad_separada'];
                $oCotizacion_Detalle->tipo=$item['tipo'];
                $oCotizacion_Detalle->tipo_ID=$item['tipo_ID'];
                $oCotizacion_Detalle->usuario_id=$item['usuario_id'];
                $oCotizacion_Detalle->usuario_mod_id=$item['usuario_mod_id'];

            }
            return  $oCotizacion_Detalle;
        } catch (Exeption $ex) {
            throw new Exception($q);
        }
    }

    static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='ID asc') {
        $cn = new connect_new();
        try {
            $q = 'SELECT ID,producto_ID,cotizacion_ID,trim(descripcion) as descripcion ,cantidad,precio_venta_unitario_soles,precio_venta_unitario_dolares,precio_venta_subtotal_soles,precio_venta_subtotal_dolares,';
            $q.='precio_venta_soles,precio_venta_dolares,igv,vigv_soles,vigv_dolares,cotizacion_detalle_ID,';
            $q.='estado_id,ver_precio,separacion,tiempo_separacion,cantidad_separada,tipo,orden_cotizacion,pagina_cotizacion,usuario_id,ifNull(usuario_mod_id,-1) as usuario_mod_id, ';
             $q.="ifnull((case when tipo_ID=1 then 'Producto' when tipo_ID=2 then 'Producto componente' when tipo_ID=3 then 'Componente' else 'Obsequio' end),'') as tipo_descripcion,tipo_ID";
            $q.=' FROM cotizacion_detalle ';
            $q.=' where del=0 ';
            
            if($filtro!=''){
                $q.=' and '.$filtro;
            }
			
		$q.=' Order By '.$order;
			
            if($desde!=-1&&$hasta!=-1){
                    $q.=' Limit '.$desde.','.$hasta;
            }		
//echo $q;
            $dt = $cn->getGrid($q);
            return $dt;
        } catch (Exception $ex) {
            throw new Exception("Ocrrió un error.");
        }
    }
    static function getGrid1($filtro='',$desde=-1,$hasta=-1,$order='ID asc') {
        $cn = new connect_new();
        try {
            $q = 'SELECT ID,producto_ID,cotizacion_ID,trim(descripcion) as descripcion ,cantidad,precio_venta_unitario_soles,precio_venta_unitario_dolares,precio_venta_subtotal_soles,precio_venta_subtotal_dolares,';
            $q.='precio_venta_soles,precio_venta_dolares,igv,vigv_soles,vigv_dolares,cotizacion_detalle_ID,';
            $q.='estado_id,ver_precio,separacion,tiempo_separacion,cantidad_separada,tipo,usuario_id,ifNull(usuario_mod_id,-1) as usuario_mod_id, ';
             $q.="(case when tipo=1 then 'Producto' when tipo=2 then 'Componente' else 'Obsequio' end) as tipo_descripcion";
            $q.=' FROM cotizacion_detalle ';
            $q.=' where del=0 ';
            
            if($filtro!=''){
                $q.=' and '.$filtro;
            }
			
            $q.=' Order By '.$order;
			
            if($desde!=-1&&$hasta!=-1){
                    $q.=' Limit '.$desde.','.$hasta;
            }		
//echo $q;
            $dt = $cn->getGrid($q);
            return $dt;
        } catch (Exception $ex) {
            throw new Exception("Ocrrió un error.");
        }
    }
    static function getGridByCotizacion($filtro='',$desde=-1,$hasta=-1,$order='ID asc') {
        $cn = new connect_new();
        try {
            $q = 'SELECT ID, usuario_id, producto_ID, precio_venta_unitario,cantidad,precio_venta,cotizacion_detalle_ID,descripcion,estado_id,cotizacion_ID,ver_precio';
            $q.=' FROM cotizacion_detalle ';
            $q.=' where del=0 and cotizacion_ID=' . $filtro;
            if($filtro!=''){
                $q.=' and '.$filtro;
            }
			
		$q.=' Order By '.$order;
			
            if($desde!=-1&&$hasta!=-1){
                    $q.=' Limit '.$desde.','.$hasta;
            }		

            $dt = $cn->getGrid($q);
            return $dt;
        } catch (Exception $ex) {
            throw new Exception('Ocurrio un error en la consulta1');
        }
    }

    function verificarDuplicado() {
        $cn = new connect_new();
        $retornar = -1;
        try {
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }
     function maxUbicacion($ID) {
        $cn = new connect_new();
        $retornar = -1;
        try {
            $q="select max(pagina_cotizacion) from cotizacion_detalle where del=0 and  cotizacion_ID=".$ID;
            $retornar=$cn->getData($q);
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }
    
}
