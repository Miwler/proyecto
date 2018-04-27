<?php

class compra_pagos {

    private $ID;
    private $compra_ID;
    private $fecha;
    private $monto_pagado;
    private $monto_pendiente;
    private $usuario_id;
    private $usuario_mod_id;
    Private $message;

    public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
        if (property_exists('compra_pagos', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('compra_pagos', $temporal)) {
            return $this->$temporal;
        }
        // Retorna nulo si no existe
        return null;
    }

    function insertar() {
        $cn = new connect();
        $retornar = -1;
        try {

            $q = 'select ifnull(max(ID),0)+1 from compra_pagos;';
            $ID=$cn->getData($q);
            $fecha_save='NULL';
            if($this->fecha!=null){
                $fecha_save='"'.FormatTextToDate($this->fecha,'Y-m-d').'"';
            }
            
            $q = 'insert into compra_pagos(ID,compra_ID,fecha,';
            $q.='monto_pagado,monto_pendiente,usuario_id)';
            $q.='values('.$ID.','.$this->compra_ID.','.$fecha_save.',"'.number_format($this->monto_pagado,2,'.','').'","'.number_format($this->monto_pendiente,2,'.','').'",'.$this->usuario_id.')';
            //echo $q;
            $retornar = $cn->transa($q);

           
            $this->ID = $ID;
            $this->message = 'Se guardó correctamente';
            return $retornar;
        } catch (Exception $ex) {

            throw new Exception($q);
        }
    }

    function actualizar() {
        $cn = new connect();
        $retornar = -1;
        try {
            $fecha_save='NULL';
            if($this->fecha!=null){
                $fecha_save='"'.FormatTextToDate($this->fecha,'Y-m-d').'"';
            }
          
            $q = 'update compra_pagos set compra_ID='.$this->compra_ID.', fecha=' . $fecha_save . ',' ;
            $q.='monto_pagado='.number_format($this->monto_pagado,2,'.','').',monto_pendiente='.number_format($this->monto_pendiente,2,'.','');
            $q.=',usuario_mod_id=' . $this->usuario_mod_id.', fdm=now() where del=0 and ID=' . $this->ID;
           
            $retornar = $cn->transa($q);
            $this->message = 'Se guardó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            
        }
    }

    function eliminar() {
        $cn = new connect();
        $retornar = -1;
        try {

            $q = 'UPDATE compra_pagos SET del=1,usuario_mod_id=' . $this->usuario_mod_id . ', fdm=Now()';
            $q.=' WHERE del=0 and ID=' . $this->ID;

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
        $cn = new connect();
        try {
            $q = 'Select ID,compra_ID,fecha,monto_pagado,monto_pendiente,usuario_id,ifNull(usuario_mod_id,-1) as usuario_mod_id';
            $q.=' from compra_pagos ';
            $q.=' where del=0 and ID=' . $ID;

            $dt = $cn->getGrid($q);
            $oCompra_Pagos = null;

            foreach ($dt as $item) {
                $oCompra_Pagos = new compra_pagos();
                $oCompra_Pagos->ID=$item['ID'];
                $oCompra_Pagos->compra_ID=$item['compra_ID'];
                $oCompra_Pagos->fecha=$item['fecha'];
                $oCompra_Pagos->monto_pagado=$item['monto_pagado'];
                $oCompra_Pagos->monto_pendiente=$item['monto_pendiente'];
                $oCompra_Pagos->usuario_id=$item['usuario_id'];
                $oCompra_Pagos->usuario_mod_id=$item['usuario_mod_id'];
            }
            return $oCompra_Pagos;
        } catch (Exeption $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }

    static function getGrid($filtro = '', $desde = -1, $hasta = -1, $order = 'ID asc') {
        $cn = new connect();
        try {
            $q = 'Select ID,compra_ID,fecha,monto_pagado,monto_pendiente,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
            $q.=' FROM compra_pagos';
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
        $cn = new connect();
        $retornar = -1;
        try {
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }

}
