<?php

class guia_venta_detalle {

    private $ID;
    private $guia_venta_ID;
    private $salida_detalle_ID;
    private $usuario_id;
    private $usuario_mod_id;
    Private $message;

    public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
        if (property_exists('guia_venta_detalle', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('guia_venta_detalle', $temporal)) {
            return $this->$temporal;
        }

        // Retorna nulo si no existe
        return null;
    }

    function insertar() {
        $cn = new connect();
        $retornar = -1;
        try {
            
            $q = 'select ifnull(max(ID),0)+1 from guia_venta_detalle';
            $ID=$cn->getData($q);
            $q = 'insert into guia_venta_detalle(ID,guia_venta_ID,salida_detalle_ID,usuario_id)';
            $q.=' values('.$ID.','.$this->guia_venta_ID.','.$this->salida_detalle_ID.','.$this->usuario_id.')' ;
            //echo $q;
            $retornar = $cn->transa($q);

            
            $this->ID = $ID;
            $this->message = 'Se registró correctamente';
            return $retornar;
        } catch (Exception $ex) {

            throw new Exception($q);
        }
    }

    function actualizar() {
        $cn = new connect();
        $retornar = -1;
        try {
            $q = 'UPDATE guia_venta_detalle set guia_venta_ID='.$this->guia_venta_ID.',salida_detalle_ID='.$this->salida_detalle_ID.',usuario_mod_id='.$this->usuario_mod_id;
            $q.=', fdm=now() where ID='.$this->ID;
            
            $retornar = $cn->transa($q);
            $this->message = 'Se actualizó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            
        }
    }

    function eliminar() {
        $cn = new connect();
        $retornar = -1;
        try {

            $q = 'UPDATE guia_venta_detalle SET del=1,usuario_mod_id=' . $this->usuario_mod_id . ', fdm=Now()';
            $q.=' WHERE del=0 and ID=' . $this->ID;

            $retornar = $cn->transa($q);

            $this->message = 'Se eliminó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }

    static function getCount($filtro = '') {
        $cn = new connect();
        try {
            $q = 'select count(ID) ';
            $q.=' FROM guia_venta_detalle ';
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
            $q = 'Select ID,guia_venta_ID,salida_detalle_ID,usuario_id,ifNull(usuario_mod_id,-1) as usuario_mod_id ';
            $q.=' from guia_venta_detalle ';
            $q.=' where del=0 and ID=' . $ID;

            $dt = $cn->getGrid($q);
            $oGuia_Venta_Detalle = null;

            foreach ($dt as $item) {
                $oGuia_Venta_Detalle = new Guia_Venta_Detalle();

                $oGuia_Venta_Detalle->ID= $item['ID'];
                $oGuia_Venta_Detalle->guia_venta_ID= $item['guia_venta_ID'];
                $oGuia_Venta_Detalle->salida_detalle_ID= $item['salida_detalle_ID'];
               
                $oGuia_Venta_Detalle->usuario_id= $item['usuario_id'];
                $oGuia_Venta_Detalle->usuario_mod_id= $item['usuario_mod_id'];

            }
            return $oGuia_Venta_Detalle;
        } catch (Exeption $ex) {
            throw new Exception($q);
        }
    }

    static function getGrid($filtro = '', $desde = -1, $hasta = -1, $order = 'ID asc') {
        $cn = new connect();
        try {
            $q = 'Select ID,guia_venta_ID,salida_detalle_ID,usuario_id,ifNull(usuario_mod_id,-1) as usuario_mod_id ';
            $q.=' from Guia_Venta_Detalle ';
            $q.=' where del=0 ';

            if ($filtro != '') {
                $q.=' and ' . $filtro;
            }

            $q.=' Order By ' . $order;

            if ($desde != -1 && $hasta != -1) {
                $q.=' Limit ' . $desde . ',' . $hasta;
            }
            $dt = $cn->getGrid($q);
            //echo $q;
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    static function getGrid1($filtro='',$desde=-1,$hasta=-1,$order='ovd.ID asc')
    {
        $cn =new connect();
        try 
        {
        $q='select ovd.ID, ov.moneda_ID,pro.peso, um.nombre as unidad_medida,ovd.cantidad,ovd.precio_venta_unitario_soles,ovd.precio_venta_unitario_dolares,';
        $q.='ovd.vigv_soles,ovd.vigv_dolares,ovd.precio_venta_subtotal_soles,ovd.precio_venta_subtotal_dolares,ovd.precio_venta_soles';
        $q.=',ovd.precio_venta_dolares,pro.nombre as producto,ovd.descripcion';
        $q.=' from salida ov,salida_detalle ovd,guia_venta_detalle gvd, producto pro,unidad_medida um';
        $q.=' where gvd.del=0 and ov.del=0 and ovd.del=0 and  ov.ID=ovd.salida_ID and';
        $q.=' gvd.salida_detalle_ID =ovd.ID and ovd.producto_ID=pro.ID and pro.unidad_medida_ID=um.ID';

        if($filtro!=''){
                $q.=' and '.$filtro;
        }

        $q.=' Order By '.$order;

        if($desde!=-1&&$hasta!=-1){
                $q.=' Limit '.$desde.','.$hasta;
        }
        //echo $q;
        $dt=$cn->getGrid($q);									
        return $dt;												
        }catch(Exception $ex)
        {
            throw new Exception($q);
        }
    } 
static function getListaGuia_Venta($guia_venta_ID) {
        $cn = new connect_new();
        try {
            $dt=$cn->store_procedure_getGrid("sp_guia_venta_detalle_getLista",
            array(
                "iguia_venta_ID"=>$guia_venta_ID
            ));
            return $dt;
        } catch (Exception $ex) {
            log_error(__FILE__, "guia_venta_detalle.getListaGuia_Venta", $ex->getMessage());
            throw new Exception("Ocurrió un error en la conexión");
        }
    }
}
