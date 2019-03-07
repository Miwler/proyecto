<?php

class factura_venta_pagos {

    private $ID;
    private $factura_venta_ID;
    private $fecha_emision;
    private $fecha_pago;
    private $monto_total_neto;
    private $monto_total_igv;
    private $monto_total;
    private $monto_pendiente_neto;
    private $monto_pendiente_igv;
    private $monto_pendiente;
    private $monto_pagado_neto;
    private $monto_pagado_igv;
    private $monto_pagado_detraccion;
    private $monto_pagado;
    private $usuario_id;
    private $usuario_mod_id;
    Private $message;

    public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
        if (property_exists('factura_venta_pagos', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('factura_venta_pagos', $temporal)) {
            return $this->$temporal;
        }
        // Retorna nulo si no existe
        return null;
    }

    function insertar() {
        $cn = new connect_new();
        $retornar = -1;
        try {

            $q = 'select ifnull(max(ID),0)+1 from factura_venta_pagos;';
            $ID=$cn->getData($q);
            $fecha_emision_save='NULL';
            if($this->fecha_emision!=null){
                $fecha_emision_save='"'.FormatTextToDate($this->fecha_emision,'Y-m-d').'"';
            }
            $fecha_pago_save='NULL';
            if($this->fecha_pago!=null){
                $fecha_pago_save='"'.FormatTextToDate($this->fecha_pago,'Y-m-d').'"';
            }
            $q = 'insert into factura_venta_pagos(ID,factura_venta_ID,fecha_emision,fecha_pago,';
            $q.='monto_total_neto,monto_total_igv,monto_total,monto_pendiente_neto,monto_pendiente_igv,monto_pendiente,monto_pagado_neto,';
            $q.='monto_pagado_igv,monto_pagado_detraccion,monto_pagado,usuario_id)';
            $q.='values('.$ID.','.$this->factura_venta_ID.','.$fecha_emision_save.','.$fecha_pago_save.',';
            $q.=$this->monto_total_neto.','.$this->monto_total_igv.','.$this->monto_total.','.$this->monto_pendiente_neto.','.$this->monto_pendiente_igv.','.$this->monto_pendiente.','.$this->monto_pagado_neto.',';
            $q.=$this->monto_pagado_igv.','.$this->monto_pagado_detraccion.','.$this->monto_pagado.','.$this->usuario_id.')';
            $retornar = $cn->transa($q);

           
            $this->ID = $ID;
            $this->message = 'Se guardó correctamente';
            return $retornar;
        } catch (Exception $ex) {

            throw new Exception($q);
        }
    }

    function actualizar() {
        $cn = new connect_new();
        $retornar = -1;
        try {
            $fecha_emision_save='NULL';
            if($this->fecha_emision!=null){
                $fecha_emision_save='"'.FormatTextToDate($this->fecha_emision,'Y-m-d').'"';
            }
            $fecha_pago_save='NULL';
            if($this->fecha_emision!=null){
                $fecha_pago_save='"'.FormatTextToDate($this->fecha_pago,'Y-m-d').'"';
            }
            
            $q = 'update factura_venta_pagos set factura_venta_ID=' . $this->factura_venta_ID . ',fecha_emision=' . $fecha_emision_save . ', fecha_pago='.$fecha_pago_save.',';
            $q.='monto_total_neto='.$this->monto_total_neto.',monto_total_igv='.$this->monto_total_igv.',monto_total='.$this->monto_total.',monto_pendiente_neto='.$this->monto_pendiente_neto.',';
            $q.='monto_pendiente_igv='.$this->monto_pendiente_igv.',monto_pendiente='.$this->monto_pendiente.',monto_pagado_neto='.$this->monto_pagado_neto.',';
            $q.='monto_pagado_igv='.$this->monto_pagado_igv.',monto_pagado_detraccion='.$this->monto_pagado_detraccion.',monto_pagado='.$this->monto_pagado.',';
            $q.='usuario_mod_id=' . $this->usuario_mod_id.', fdm=now() where del=0 and id=' . $this->ID;
           
            $retornar = $cn->transa($q);
            $this->message = 'Se guardó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            
        }
    }

    function eliminar() {
        $cn = new connect_new();
        $retornar = -1;
        try {

            $q = 'UPDATE factura_venta_pagos SET del=1,usuario_mod_id=' . $this->usuario_mod_id . ', fdm=Now()';
            $q.=' WHERE del=0 and ID=' . $this->ID;

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
            $q = 'select count(ca.ID) ';
            $q.=' FROM categoria as ca, linea li ';
            $q.=' where ca.linea_ID=li.ID and ca.del=0 ';

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
        $cn = new connect_new();
        try {
            $q = 'Select ID,factura_venta_ID,fecha_emision,fecha_pago,monto_total_neto,monto_total_igv,monto_total,monto_pendiente_neto,';
            $q.= 'monto_pendiente_igv,monto_pendiente,monto_pagado_neto,monto_pagado_igv,monto_pagado_detraccion,monto_pagado,usuario_id';
            $q.= ',ifnull(usuario_mod_id,-1) as usuario_mod_id';
            $q.=' from factura_venta_pagos ';
            $q.=' where del=0 and ID=' . $ID;

            $dt = $cn->getGrid($q);
            $oFactura_Venta_Pagos = null;

            foreach ($dt as $item) {
                $oFactura_Venta_Pagos = new factura_venta_pagos();
                $oFactura_Venta_Pagos->ID=$item['ID'];
                $oFactura_Venta_Pagos->factura_venta_ID=$item['factura_venta_ID'];
                $oFactura_Venta_Pagos->fecha_emision=$item['fecha_emision'];
                $oFactura_Venta_Pagos->fecha_pago=$item['fecha_pago'];
                $oFactura_Venta_Pagos->monto_total_neto=$item['monto_total_neto'];
                $oFactura_Venta_Pagos->monto_total_igv=$item['monto_total_igv'];
                $oFactura_Venta_Pagos->monto_total=$item['monto_total'];
                $oFactura_Venta_Pagos->monto_pendiente_neto=$item['monto_pendiente_neto'];
                $oFactura_Venta_Pagos->monto_pendiente_igv=$item['monto_pendiente_igv'];
                $oFactura_Venta_Pagos->monto_pendiente=$item['monto_pendiente'];
                $oFactura_Venta_Pagos->monto_pagado_neto=$item['monto_pagado_neto'];
                $oFactura_Venta_Pagos->monto_pagado_igv=$item['monto_pagado_igv'];
                $oFactura_Venta_Pagos->monto_pagado_detraccion=$item['monto_pagado_detraccion'];
                $oFactura_Venta_Pagos->monto_pagado=$item['monto_pagado'];
                $oFactura_Venta_Pagos->usuario_id=$item['usuario_id'];
                $oFactura_Venta_Pagos->usuario_mod_id=$item['usuario_mod_id'];
            }
            return $oFactura_Venta_Pagos;
        } catch (Exeption $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }

    static function getGrid($filtro = '', $desde = -1, $hasta = -1, $order = 'ID asc') {
        $cn = new connect_new();
        try {
            $q = 'Select ID,factura_venta_ID,fecha_emision,fecha_pago,monto_total_neto,monto_total_igv,';
            $q.='monto_total,monto_pendiente_neto,monto_pendiente_igv,monto_pendiente,monto_pagado_neto,monto_pagado_igv,';
            $q.='monto_pagado_detraccion,ifnull(monto_pagado,0) as monto_pagado,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
            $q.=' FROM factura_venta_pagos';
            $q.=' where del=0 ';


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
            throw new Exception('Ocurrio un error en la consulta');
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

}
