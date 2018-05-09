<?php

class salida_detalle {
    private $ID;
    private $producto_ID;
    private $observacion;
    private $salida_ID;
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
    private $salida_detalle_ID;
    private $ver_precio;
    private $estado_ID;
    private $cotizacion_detalle_ID;
    private $usuario_id;
    private $usuario_mod_id;
    private $tipo_ID;
    private $obsequio;

    Private $verBotonSerie;
    Private $verBotonTerminar;
    private $dtInventario;
    private $tipo;

    //1 producto
//2 producto con componente (se convierte en una descripción y no descuenta stock)
//3 Componente (calcula el valor de venta del padre)
//4 Adicional (producto adiconal lleva un ID del un padre)
//5 producto con componente y adicional (se convierte en descripción, los componentes que lo integran hacen la suma de la venta total , el adicional suma al precio   )
//6 Producto con adicional
//7  Obsequio (se convierte en obsequio el costo de venta es 0)

    Private $message;
    private $oMoneda;
    private $salida_detalle_padre_ID;
    private $oProducto;
    private $oSalida;
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
    private $internos;
    private $bloquear_edicion;
    public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"
        if (property_exists('salida_detalle', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('salida_detalle', $temporal)) {
            return $this->$temporal;
        }

        // Retorna nulo si no existe
        return null;
    }

    function insertar() {
        $cn = new connect();
        $retorna = -1;
        try {
            $q = 'select ifnull(max(ID),0)+1 as ID from salida_detalle;';
            $ID=$cn->getData($q);

            $q = 'insert into salida_detalle (ID,producto_ID,observacion,salida_ID,descripcion,cantidad,';
            $q.='precio_venta_unitario_soles,precio_venta_unitario_dolares,precio_venta_subtotal_soles,precio_venta_subtotal_dolares,';
            $q.='precio_venta_soles,precio_venta_dolares,igv,vigv_soles,vigv_dolares,salida_detalle_ID,ver_precio,estado_ID,cotizacion_detalle_ID,';
            $q.='usuario_id,tipo_ID)values ';
            $q.='('.$ID.','.$this->producto_ID.',"'.$this->observacion.'",'.$this->salida_ID.',"'.FormatTextSave($this->descripcion).'",'.$this->cantidad.',';
            $q.=$this->precio_venta_unitario_soles.','.$this->precio_venta_unitario_dolares.','.$this->precio_venta_subtotal_soles.','.$this->precio_venta_subtotal_dolares.',';
            $q.=$this->precio_venta_soles.','.$this->precio_venta_dolares.','.$this->igv.','.$this->vigv_soles.','.$this->vigv_dolares.','.$this->salida_detalle_ID.',';
            $q.=$this->ver_precio . ','.$this->estado_ID.','.$this->cotizacion_detalle_ID.','.$this->usuario_id.','.$this->tipo_ID.')';
           //echo $q;
            $retorna = $cn->transa($q);

            $this->ID=$ID;
            $this->message = 'Se guardó correctamente';
            return $retorna;
        } catch (Exception $ex) {

            throw new Exception($q);
        }
    }

    function actualizar() {
        $cn = new connect();
        $retornar = -1;
        try {
            $cotizacion_detalle_ID='NULL';
            if(isset($this->cotizacion_detalle_ID)){
                $cotizacion_detalle_ID=$this->cotizacion_detalle_ID;
            }
            $q = 'update salida_detalle set producto_ID='.$this->producto_ID.',descripcion="'.FormatTextSave($this->descripcion);
            $q.='",cantidad='.$this->cantidad.',precio_venta_unitario_soles='.$this->precio_venta_unitario_soles.',precio_venta_subtotal_soles='.$this->precio_venta_subtotal_soles;
            $q.=',precio_venta_subtotal_dolares='.$this->precio_venta_subtotal_dolares.',precio_venta_unitario_dolares='.$this->precio_venta_unitario_dolares.',igv='.$this->igv;
            $q.=',vigv_soles='.$this->vigv_soles.',vigv_dolares='.$this->vigv_dolares.',precio_venta_soles='.$this->precio_venta_soles.',precio_venta_dolares='.$this->precio_venta_dolares;
            $q.=',salida_detalle_ID='.$this->salida_detalle_ID.',estado_ID='.$this->estado_ID.', cotizacion_detalle_ID='.$cotizacion_detalle_ID .',ver_precio='.$this->ver_precio.',tipo_ID='.$this->tipo_ID.',usuario_mod_id='.$this->usuario_mod_id;
            $q.=', fdm=now() where del=0 and id=' . $this->ID;
            $retornar = $cn->transa($q);
            $this->message = 'Se guardó correctamente';
        //echo $q;
            return $retornar;
        } catch (Exception $ex) {
             throw new Exception($q);
        }
    }
    function actualizarCosto(){
        $cn =new connect();
	$retornar=-1;
        try{
            $q='update salida_detalle set precio_venta_unitario='.$this->precio_venta_unitario.', precio_venta='.$this->precio_venta.', usuario_mod_id='. $this->usuario_mod_id;
            $q.=', fdm=now() where del=0 and id='.$this->ID;
            $retornar=$cn->transa($q);
            $this->message='Se guardó correctamente';
            //echo $q;
            return $retornar;
        } catch (Exception $ex) {

        }
    }
    function actualizarTipo(){
        $cn =new connect();
	$retornar=-1;
        try{
            $q='update salida_detalle set tipo_ID='.$this->tipo_ID;
            $q.=' where ID='.$this->ID;
            $retornar=$cn->transa($q);
            //$this->message='Se guardó correctamente';
            //echo $q;
            return $retornar;
        } catch (Exception $ex) {

        }
    }
    function actualizarCK() {
        $cn = new connect();
        $retornar = -1;
        try {
            $q = 'update salida_detalle set ver_precio=' . $this->ver_precio. ', usuario_mod_id=' . $this->usuario_mod_id;
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
        $cn = new connect();
        $retornar = -1;
        try {

            $q = 'UPDATE salida_detalle SET del=1,usuario_mod_id=' . $this->usuario_mod_id . ', fdm=Now()';
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
        $cn = new connect();
        try {
            $q = 'select count(ID) ';
            $q.=' FROM salida_detalle';
            $q.=' where del=0 ';

            if ($filtro != '') {
                $q.=' and ' . $filtro;
            }
            //echo $q;
            $resultado = $cn->getData($q);

            return $resultado;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }

    static function getByID($ID) {
        $cn = new connect();
        try {
            $q = 'SELECT ID,producto_ID,observacion,salida_ID,descripcion,cantidad,precio_venta_unitario_soles,';
            $q.='precio_venta_unitario_dolares,precio_venta_subtotal_soles,precio_venta_subtotal_dolares,precio_venta_soles,precio_venta_dolares,';
            $q.='igv,vigv_soles,vigv_dolares,salida_detalle_ID,estado_ID,cotizacion_detalle_ID,ver_precio,obsequio,tipo_ID,usuario_id,ifNull(usuario_mod_id,-1) as usuario_mod_id';
            $q.=' FROM salida_detalle ';
            $q.=' where del=0 and ID='.$ID;
            //echo $q;
            $dt = $cn->getGrid($q);
            $osalida_Detalle = null;

            foreach ($dt as $item) {
                $osalida_Detalle = new salida_detalle();

                $osalida_Detalle->ID=$item['ID'];
                $osalida_Detalle->producto_ID=$item['producto_ID'];
                $osalida_Detalle->observacion=$item['observacion'];
                $osalida_Detalle->salida_ID=$item['salida_ID'];
                $osalida_Detalle->descripcion=$item['descripcion'];
                $osalida_Detalle->cantidad=$item['cantidad'];
                $osalida_Detalle->precio_venta_unitario_soles=$item['precio_venta_unitario_soles'];
                $osalida_Detalle->precio_venta_unitario_dolares=$item['precio_venta_unitario_dolares'];
                $osalida_Detalle->precio_venta_subtotal_soles=$item['precio_venta_subtotal_soles'];
                $osalida_Detalle->precio_venta_subtotal_dolares=$item['precio_venta_subtotal_dolares'];
                $osalida_Detalle->precio_venta_soles=$item['precio_venta_soles'];
                $osalida_Detalle->precio_venta_dolares=$item['precio_venta_dolares'];
                $osalida_Detalle->igv=$item['igv'];
                $osalida_Detalle->vigv_soles=$item['vigv_soles'];
                $osalida_Detalle->vigv_dolares=$item['vigv_dolares'];
                $osalida_Detalle->salida_detalle_ID=$item['salida_detalle_ID'];
                $osalida_Detalle->estado_ID=$item['estado_ID'];
                $osalida_Detalle->cotizacion_detalle_ID=$item['cotizacion_detalle_ID'];
                $osalida_Detalle->ver_precio=$item['ver_precio'];
                $osalida_Detalle->obsequio=$item['obsequio'];
                $osalida_Detalle->tipo_ID=$item['tipo_ID'];
                $osalida_Detalle->usuario_id=$item['usuario_id'];
                $osalida_Detalle->usuario_mod_id=$item['usuario_mod_id'];


            }
            return  $osalida_Detalle;
        } catch (Exeption $ex) {
            throw new Exception($q);
        }
    }

    static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='ID asc') {
        $cn = new connect();
        try {
            $q = 'SELECT ID,producto_ID,observacion,salida_ID,descripcion,cantidad,precio_venta_unitario_soles,';
            $q.='precio_venta_unitario_dolares,precio_venta_subtotal_soles,precio_venta_subtotal_dolares,precio_venta_soles,precio_venta_dolares,';
            $q.='igv,vigv_soles,vigv_dolares,salida_detalle_ID,estado_ID,ver_precio,obsequio,cotizacion_detalle_ID,tipo_ID,usuario_id,ifNull(usuario_mod_id,-1) as usuario_mod_id';
            $q.=' FROM salida_detalle ';
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
            throw new Exception($q);
        }
    }
     static function getGridLista($filtro='',$desde=-1,$hasta=-1,$order='ovd.ID asc') {
        $cn = new connect();
        try {
            $q = 'select ovd.ID,ovd.salida_ID, ovd.cantidad,ovd.descripcion,pro.nombre as producto, um.nombre as unidad_medida,pro.peso,ovd.ver_precio,';
            $q.='ovd.precio_venta_unitario_soles,ovd.precio_venta_unitario_dolares,ovd.precio_venta_subtotal_soles,ovd.precio_venta_subtotal_dolares,ovd.vigv_soles,ovd.vigv_dolares,ovd.precio_venta_soles,ovd.precio_venta_dolares ';
            $q.=' from salida_detalle ovd, producto pro, unidad_medida um, salida ov';
            $q.=' where ovd.salida_ID=ov.ID and ovd.producto_ID=pro.ID and pro.unidad_medida_ID=um.ID';
            $q.=' and ovd.del=0';

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
            throw new Exception($q);
        }
    }
    function verificarDuplicado() {
        $cn = new connect();
        $retornar = -1;
        try {
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }

}
