<?php

class chofer {

    private $ID;
    private $persona_ID;
    private $empresa_ID;
    private $licencia_conducir;
    private $celular;
    private $estado_ID;
    private $usuario_id;
    private $usuario_mod_id;
    private $getMessage;
    private $dtEstado;
    private $nombres;
    public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
        if (property_exists('chofer', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('chofer', $temporal)) {
            return $this->$temporal;
        }

        // Retorna nulo si no existe
        return null;
    }

    function insertar() {
        $cn = new connect();
        $retornar = -1;
        try {

            $q = 'select ifnull(max(ID),0)+1 from chofer;';
            $ID=$cn->getData($q);
            $q = 'insert into chofer(ID,persona_ID,empresa_ID,licencia_conducir,celular,estado_ID,usuario_id)';
            $q.='values('.$ID.','.$this->persona_ID.','.$this->empresa_ID.',"' . $this->licencia_conducir . '","' . $this->celular
                . '",'.$this->estado_ID.',' . $this->usuario_id.');';
            //echo $q;
            $retornar = $cn->transa($q);
            $this->ID = $ID;
            $this->getMessage = 'Se guardó correctamente';
            return $retornar;
        } catch (Exception $ex) {

            throw new Exception($q);
        }
    }

    function actualizar() {
        $cn = new connect();
        $retornar = -1;
        try {
            $q = 'update chofer set persona_ID='.$this->persona_ID.',empresa_ID='.$this->empresa_ID.',licencia_conducir="'.$this->licencia_conducir.'",';
            $q.= 'celular="' . $this->celular . '",estado_ID='.$this->estado_ID.',usuario_mod_id=' . $this->usuario_mod_id;
            $q.=', fdm=now() where del=0 and id=' . $this->ID;
            //echo $q;
            $retornar = $cn->transa($q);
            $this->getMessage = 'Se actualizó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }

    function eliminar() {
        $cn = new connect();
        $retornar = -1;
        try {

            $q = 'UPDATE chofer SET del=1,usuario_mod_id=' . $this->usuario_mod_id . ', fdm=Now()';
            $q.=' WHERE del=0 and ID=' . $this->ID;

            $retornar = $cn->transa($q);

            $this->getMessage = 'Se eliminó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }

    static function getCount($filtro = '') {
        $cn = new connect();
        try {
            $q = 'select count(cho.ID) ';
            $q.=' from chofer cho,persona pe,estado es ';
            $q.=' where cho.persona_ID=pe.ID and cho.estado_ID=es.ID and cho.del=0 and pe.del=0 ';

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
            $q = 'select ID,persona_ID,empresa_ID,licencia_conducir,celular,estado_ID,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
            $q.=' from chofer ';
            $q.=' where del=0 and ID=' . $ID;

            $dt = $cn->getGrid($q);
            $oChofer = null;

            foreach ($dt as $item) {
                $oChofer = new chofer();

                $oChofer->ID = $item['ID'];
                $oChofer->persona_ID = $item['persona_ID'];
                $oChofer->empresa_ID = $item['empresa_ID'];
                $oChofer->licencia_conducir=$item['licencia_conducir'];
                $oChofer->celular = $item['celular'];
                $oChofer->estado_ID = $item['estado_ID'];
                $oChofer->usuario_id = $item['usuario_id'];
                $oChofer->usuario_mod_id = $item['usuario_mod_id'];
            }
            return $oChofer;
        } catch (Exeption $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }

    static function getGrid($filtro = '', $desde = -1, $hasta = -1, $order = 'cho.ID asc') {
        $cn = new connect();
        try {
            $q = 'select cho.ID, pe.apellido_paterno,pe.apellido_materno,pe.nombres,cho.licencia_conducir,cho.celular,cho.empresa_ID,cho.estado_ID,es.nombre as estado';
            $q.=' from chofer cho,persona pe,estado es';
            $q.=' where cho.persona_ID=pe.ID and cho.estado_ID=es.ID and cho.del=0 and pe.del=0 and cho.empresa_ID='.$_SESSION['empresa_ID'];


            if ($filtro != '') {
                $q.=' and ' . $filtro;
            }

            $q.=' Order By ' . $order;

            if ($desde != -1 && $hasta != -1) {
                $q.=' Limit ' . $desde . ',' . $hasta;
            }
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
            $q="select count(ID) from chofer where del=0 and persona_ID=".$this->persona_ID;
           
            if($this->ID!=''){
                $q.=' and ID<>'.$this->ID;
            }

            $retornar=$cn->getData($q);			

            if ($retornar>0){
                $this->getMessage='Ya existe el chofer ';
                return $retornar;
            }
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }

}
