<?php

class impuestos_tipo {

    private $ID;
    private $impuestos_ID;
    private $nombre;
    private $porcentaje;
    private $tipo_ID;
    private $descripcion;
    private $usuario_id;
    private $codigo;

    private $getMessage;
    
    public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
        if (property_exists('impuestos_tipo', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('impuestos_tipo', $temporal)) {
            return $this->$temporal;
        }

        // Retorna nulo si no existe
        return null;
    }

 
    static function getCount($filtro = '') {
        $cn = new connect_new();
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
        $cn = new connect_new();
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

    static function getGrid($filtro = '', $desde = -1, $hasta = -1, $order = 'codigo asc') {
        $cn = new connect_new();
        try {
            $q = 'select ID,impuestos_ID,nombre,porcentaje,tipo_ID,descripcion,usuario_id,codigo';
            $q.=' from impuestos_tipo ';
            $q.=' where del=0 ';


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
        $cn = new connect_new();
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
    static function getImpuestoIGV($moneda_ID,$tipo_cambio,$impuesto_tipo_ID,$monto,$igv) {
        $cn = new connect_new();
        try {
            $dt=$cn->store_procedure_getGrid("sp_impuestos_tipo_getMontoImpuesto", 
                    array("iempresa_ID"=>$_SESSION['empresa_ID'],
                        "imoneda_ID"=>$moneda_ID,
                        "itipo_cambio"=>$tipo_cambio,
                        "impuestos_tipo_ID"=>$impuesto_tipo_ID,
                        "imonto"=>$monto,
                        "igv"=>$igv,
                        "bd_largo_decimal"=>bd_largo_decimal));
            
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
}
