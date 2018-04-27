<?php

class textos {
  private $ID;
    private $contenido;
    private $fdc;
    private $fdm;
    private $nombre;
    private $del;
    private $usuario_id;
    private $usuario_mod_id;
    
    private $tabla;
    private $tipo;
    Private $message;

    public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
        if (property_exists('textos', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('textos', $temporal)) {
            return $this->$temporal;
        }

        // Retorna nulo si no existe
        return null;
    }
    
    static function getByID($ID) {
        $cn = new connect();
        try {
            $q = 'Select ID,contenido,nombre,ifnull(tabla,"") as tabla,ifnull(tipo,-1) as tipo,ifnull(usuario_id,-1) as usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
            $q.=' from textos ';
            $q.=' where del=0 and ID=' . $ID;

            $dt = $cn->getGrid($q);
            $oTextos = null;

            foreach ($dt as $item) {
                $oTextos = new Textos();

                $oTextos->ID = $item['ID'];
                $oTextos->contenido = $item['contenido'];
                $oTextos->nombre = $item['nombre'];
                $oTextos->tabla = $item['tabla'];
                $oTextos->tipo = $item['tipo'];
                $oTextos->usuario_id = $item['usuario_id'];
                $oTextos->usuario_mod_id = $item['usuario_mod_id'];
            }
            return $oTextos;
        } catch (Exeption $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }

}
