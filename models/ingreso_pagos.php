<?php

class ingreso_pagos {

    private $ID;
    private $ingreso_ID;
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
        if (property_exists('ingreso_pagos', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('ingreso_pagos', $temporal)) {
            return $this->$temporal;
        }
        // Retorna nulo si no existe
        return null;
    }

    function insertar() {
        $cn = new connect();
        $retornar = -1;
        try {

            $q = 'select ifnull(max(ID),0)+1 from ingreso_pagos;';
            $ID=$cn->getData($q);
            $fecha_save='NULL';
            if($this->fecha!=null){
                $fecha_save='"'.FormatTextToDate($this->fecha,'Y-m-d').'"';
            }
            
            $q = 'insert into ingreso_pagos(ID,ingreso_ID,fecha,';
            $q.='monto_pagado,monto_pendiente,usuario_id)';
            $q.='values('.$ID.','.$this->ingreso_ID.','.$fecha_save.',"'.number_format($this->monto_pagado,2,'.','').'","'.number_format($this->monto_pendiente,2,'.','').'",'.$this->usuario_id.')';
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
          
            $q = 'update ingreso_pagos set ingreso_ID='.$this->ingreso_ID.', fecha=' . $fecha_save . ',' ;
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

            $q = 'UPDATE ingreso_pagos SET del=1,usuario_mod_id=' . $this->usuario_mod_id . ', fdm=Now()';
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
            $q = 'Select ID,ingreso_ID,fecha,monto_pagado,monto_pendiente,usuario_id,ifNull(usuario_mod_id,-1) as usuario_mod_id';
            $q.=' from ingreso_pagos ';
            $q.=' where del=0 and ID=' . $ID;
            //echo $q;
            $dt = $cn->getGrid($q);
            $oingreso_Pagos = null;

            foreach ($dt as $item) {
                $oingreso_Pagos = new ingreso_pagos();
                $oingreso_Pagos->ID=$item['ID'];
                $oingreso_Pagos->ingreso_ID=$item['ingreso_ID'];
                $oingreso_Pagos->fecha=$item['fecha'];
                $oingreso_Pagos->monto_pagado=$item['monto_pagado'];
                $oingreso_Pagos->monto_pendiente=$item['monto_pendiente'];
                $oingreso_Pagos->usuario_id=$item['usuario_id'];
                $oingreso_Pagos->usuario_mod_id=$item['usuario_mod_id'];
            }
            return $oingreso_Pagos;
        } catch (Exeption $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }

    static function getGrid($filtro = '', $desde = -1, $hasta = -1, $order = 'ID asc') {
        $cn = new connect();
        try {
            $q = 'Select ID,ingreso_ID,fecha,monto_pagado,monto_pendiente,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
            $q.=' FROM ingreso_pagos';
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
