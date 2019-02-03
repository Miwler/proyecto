<?php

class vehiculo {

    private $ID;
    private $descripcion;
    private $marca;
    private $placa;
    private $certificado_inscripcion;
    private $empresa_ID;
    private $usuario_id;
    private $usuario_mod_id;
    Private $getMessage;

    public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
        if (property_exists('vehiculo', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('vehiculo', $temporal)) {
            return $this->$temporal;
        }

        // Retorna nulo si no existe
        return null;
    }

    function insertar() {
        
        $retorna = -1;
        try {
            $q = 'select ifnull(max(ID),0)+1 from vehiculo;';
			$cn = new connect_new();
            $ID=$cn->getData($q);
            //$cn->transa($q);
            $q = 'insert into vehiculo(ID,descripcion,marca,placa,certificado_inscripcion,empresa_ID,usuario_id)';
            $q.=' values('.$ID.',"' . $this->descripcion. '","'.$this->marca.'","' . $this->placa.'","' . $this->certificado_inscripcion;
            $q.='",'.$this->empresa_ID.',' . $this->usuario_id . ')';
			$cn = new connect_new();
            $retorna = $cn->transa($q);

            $this->ID = $ID;
            $this->getMessage = 'Se guardó correctamente';
            return $retorna;
        } catch (Exception $ex) {

            throw new Exception("Ocurrió un error en la bd al insertar vehiculo");
        }
    }

    function actualizar() {
        $cn = new connect_new();
        $retornar = -1;
        try {
            $q = 'update vehiculo set descripcion="' . $this->descripcion ;
            $q.= '",marca="' . $this->marca. '",placa="' . $this->placa. '",certificado_inscripcion="' ;
            $q.=$this->certificado_inscripcion. '",usuario_mod_id=' . $this->usuario_mod_id;
            $q.=', fdm=now() where del=0 and ID=' . $this->ID;
            $retornar = $cn->transa($q);
            $this->getMessage = 'Se actualizó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            
        }
    }

    function eliminar() {
        $cn = new connect_new();
        $retornar = -1;
        try {

            $q = 'UPDATE vehiculo SET del=1,usuario_mod_id=' . $this->usuario_mod_id . ', fdm=Now()';
            $q.=' WHERE del=0 and ID=' . $this->ID;

            $retornar = $cn->transa($q);

            $this->getMessage = 'Se eliminó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }

    static function getCount($filtro = '') {
        $cn = new connect_new();
        try {
            $q = 'select count(pr.ID) ';
            $q.=' FROM vehiculo as pr ';
            $q.=' where pr.del=0 ';

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
            $q = 'Select ID,descripcion,marca,placa,certificado_inscripcion,empresa_ID,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
            $q.=' from vehiculo ';
            $q.=' where del=0 and ID=' . $ID;

            $dt = $cn->getGrid($q);
            $oVehiculo = null;

            foreach ($dt as $item) {
                $oVehiculo = new vehiculo();

                $oVehiculo->ID = $item['ID'];
                $oVehiculo->descripcion = $item['descripcion'];
                $oVehiculo->empresa_ID = $item['empresa_ID'];
                $oVehiculo->marca = $item['marca'];
                $oVehiculo->placa = $item['placa'];
                $oVehiculo->certificado_inscripcion = $item['certificado_inscripcion'];
                $oVehiculo->usuario_id = $item['usuario_id'];
                $oVehiculo->usuario_mod_id = $item['usuario_mod_id'];
            }
            return $oVehiculo;
        } catch (Exeption $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }

    static function getGrid($filtro = '', $desde = -1, $hasta = -1, $order = 'ID') {
        $cn = new connect_new();
        try {
            $q = 'SELECT ID,marca,placa,certificado_inscripcion,descripcion,empresa_ID,usuario_ID,ifnull(usuario_mod_id,-1) as usuario_mod_id';
            $q.=' FROM vehiculo';
            $q.=' where del=0 and empresa_ID='.$_SESSION['empresa_ID'];


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
            throw new Exception('Ocurrio un error en la consulta1');
        }
    }

    function verificarDuplicado() {
        $cn = new connect_new();
        $retornar = -1;
        try {
            
            $q='SELECT count(ID) FROM vehiculo';
            $q.=' WHERE del=0 and upper(placa)="'.strtoUpper(FormatTextSave($this->placa)).'" and empresa_ID='.$this->empresa_ID;		

            if($this->ID!=''){
                $q.=' and ID<>'.$this->ID;
            }

            $retornar=$cn->getData($q);			

            if ($retornar>0){
                $this->getMessage='Ya existe un vehiculo con la misma placa ';
                return $retornar;
            }
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }

}
