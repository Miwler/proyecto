<?php

class comprobante_regula_sunat {

    private $ID;
    private $comprobante_regula_ID;
    private $fecha_generacion;
    private $fecha_respuesta;
    private $nombre_archivo;
    private $xml_firmado;
    private $hash;
    private $representacion_impresa;
    private $estado_envio;
    private $codigo_estado;
    private $descripcion_estado;
    private $cdr_sunat;
    private $usuario_id;

    Private $getMessage;

    public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"
        if (property_exists('comprobante_regula_sunat', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('comprobante_regula_sunat', $temporal)) {
            return $this->$temporal;
        }

        // Retorna nulo si no existe
        return null;
    }

    function insertar() {
        
        $retornar = -1;
        try {

            $q = 'select ifnull(max(ID),0)+1 from comprobante_regula_sunat';
            $cn = new connect_new();
            $ID=$cn->getData($q);
            $q = 'insert into comprobante_regula_sunat(ID,comprobante_regula_ID,fecha_generacion,fecha_respuesta,nombre_archivo,hash,xml_firmado,representacion_impresa,estado_envio,codigo_estado,descripcion_estado,cdr_sunat,usuario_id)';
            $q.='values('.$ID.','.$this->comprobante_regula_ID.',"' . $this->fecha_generacion . '","'.$this->fecha_respuesta.'","'.$this->nombre_archivo.'","'.$this->hash.'","'.$this->xml_firmado.'","'.$this->representacion_impresa.'","'.$this->estado_envio.'","'.$this->codigo_estado.'","'.$this->descripcion_estado.'","'.$this->cdr_sunat.'",'. $this->usuario_id .');';
            //echo $q;
//console_log($q);
            $cn = new connect_new();
            $retornar = $cn->transa($q);
            $this->ID = $ID;
            $this->getMessage = 'Se guardó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception($ex);
            //throw new Exception("Ocurrio un error en la consulta");
        }
    }

    public function getGrid($comprobante_regula_ID) {
        $cn = new connect_new();
        try {
            $q = 'SELECT * FROM comprobante_regula_sunat WHERE comprobante_regula_ID='.$comprobante_regula_ID.' ORDER BY ID DESC LIMIT 1 ';
            $dt = $cn->getGrid($q);
            return $dt;
        } catch (Exception $ex) {
            throw new Exception('Ocurrio un error en la consulta');
        }
    }

    
}
