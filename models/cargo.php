<?php

class cargo {

    private $ID;
    private $nombre;
    private $tabla;
    private $orden;
    
    private $usuario_id;
    private $usuario_mod_id;
    Private $message;
    PRivate $teta;
    public $cucardas;
    public $Venezolas;
    public $Venezolas1;
    public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
        if (property_exists('cargo', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('cargo', $temporal)) {
            return $this->$temporal;
        }

        // Retorna nulo si no existe
        return null;
    }

    function insertar() {
        $cn = new connect();
        $retornar = -1;
        try {

            $q = 'SET  @maxrow:=(select ifnull(max(ID),0) from categoria);';
            $cn->transa($q);
            $q = 'insert into categoria(ID,nombre,descripcion,usuario_id,linea_ID)';
            $q.='values((select @maxrow:=@maxrow+1),"' . FormatTextSave($this->nombre) . '","' . FormatTextSave($this->descripcion) . '",'. $this->usuario_id . ',' . $this->linea_ID . ');';
            //echo $q;
            $retornar = $cn->transa($q);

            $q = 'select max(ID) from categoria where usuario_id=' . $this->usuario_id;
            $this->ID = $cn->getData($q);
            $this->message = 'Se guardó correctamente';
            return $retornar;
        } catch (Exception $ex) {

            throw new Exception("Ocurrio un error en la consulta");
        }
    }

    function actualizar() {
        $cn = new connect();
        $retornar = -1;
        try {
            $q = 'update categoria set descripcion="' . $this->descripcion . '",nombre="' . $this->nombre . '", linea_ID='.$this->linea_ID.',usuario_mod_id=' . $this->usuario_mod_id;
            $q.=', fdm=now() where del=0 and id=' . $this->ID;
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

            $q = 'UPDATE categoria SET del=1,usuario_mod_id=' . $this->usuario_mod_id . ', fdm=Now()';
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
            $q = 'Select ID,nombre,tabla,orden,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
            $q.=' from cargo ';
            $q.=' where del=0 and ID=' . $ID;

            $dt = $cn->getGrid($q);
            $oCargo = null;

            foreach ($dt as $item) {
                $oCargo = new cargo();

                $oCargo->ID = $item['ID'];
                $oCargo->nombre = $item['nombre'];
                $oCargo->tabla = $item['tabla'];
				$oCargo->orden = $item['orden'];
                $oCargo->usuario_id = $item['usuario_id'];
                $oCargo->usuario_mod_id = $item['usuario_mod_id'];
            }
            return $oCargo;
        } catch (Exeption $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }

    static function getGrid($filtro = '', $desde = -1, $hasta = -1, $order = 'ID asc') {
        $cn = new connect();
        try {
            $q = 'Select ID,nombre,tabla,orden,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
            $q.=' FROM cargo';
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
