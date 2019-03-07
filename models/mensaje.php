<?php

class mensaje {
    private $ID;
    private $remitente_ID;
    private $nombre;
    private $email;
    private $asunto;
    private $mensaje;
    private $archivo;
    private $nombre_archivo;
    private $email_destinatario;
    private $email_amigo;
    private $nombre_amigo;
    private $empresa_ID;
   
    private $usuario_id;
    private $usuario_mod_id;
	
    Private $getMessage;
    private $remitente;

    public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
        if (property_exists('mensaje', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('mensaje', $temporal)) {
            return $this->$temporal;
        }

        // Retorna nulo si no existe
        return null;
    }

    function insertar() {
        $cn = new connect_new();
        $retornar = -1;
        try {
            $remitente="-1";
            if(isset($this->remitente_ID)){
                $remitente=$this->remitente_ID;
            }
            $email_amigo1="";
            if(isset($this->email_amigo)){
                $email_amigo1=$this->email_amigo;
            }
            $nombre_amigo1="";
            if(isset($this->nombre_amigo)){
                $nombre_amigo1=$this->nombre_amigo;
            }
            $q = 'select ifnull(max(ID),0)+1 from mensaje;';
            $ID=$cn->getData($q);
            $q = 'insert into mensaje(ID,remitente_ID,nombre,email,asunto,mensaje,archivo,email_destinatario,email_amigo,nombre_amigo,empresa_ID,usuario_id)';
            $q.='values('.$ID.',"'. $remitente .'","' . $this->nombre. '","' . $this->email. '","' . $this->asunto;
            $q.='","' . $this->mensaje. '","' . $this->archivo. '","' . $this->email_destinatario. '","'.$email_amigo1.'","'.$nombre_amigo1.'",'.$this->empresa_ID.',' . $this->usuario_id . ');';
            //echo $q;
            $retornar = $cn->transa($q);

           
            $this->ID = $ID;
            $this->getMessage = 'Se guardó correctamente.';
            return $retornar;
        } catch (Exception $ex) {

            throw new Exception($q);
        }
    }

    function actualizar() {
        $cn = new connect_new();
        $retornar = -1;
        try {
            $remitente="-1";
            if(isset($this->remitente_ID)){
                $remitente=$this->remitente_ID;
            }
            $email_amigo1="";
            if(isset($this->email_amigo)){
                $email_amigo1=$this->email_amigo;
            }
            $nombre_amigo1="";
            if(isset($this->nombre_amigo)){
                $nombre_amigo1=$this->nombre_amigo;
            }
            $q = 'update mensaje set remitente_ID='.$remitente. ',nombre="' . $this->nombre . '",email="' . $this->email;
            $q.='",asunto="' . $this->asunto . '",mensaje="' . $this->mensaje . '",archivo="' . $this->archivo ;
            $q.='",email_destinatario="' . $this->email_destinatario . '",email_amigo="'.$email_amigo1.'",nombre_amigo="'.$nombre_amigo1.'",empresa_ID='.$this->empresa_ID.',usuario_mod_id=' . $this->usuario_mod_id;
            $q.=', fdm=now() where del=0 and id=' . $this->ID;
            $retornar = $cn->transa($q);
            $this->getMessage = 'Se guardó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            
        }
    }

    function eliminar() {
        $cn = new connect_new();
        $retornar = -1;
        try {

            $q = 'UPDATE mensaje del=1,usuario_mod_id=' . $this->usuario_mod_id . ', fdm=Now()';
            $q.=' WHERE del=0 and ID=' . $this->ID;

            $retornar = $cn->transa($q);

            $this->Message = 'Se eliminó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }

    static function getCount($filtro = '') {
        $cn = new connect_new();
        try {
            $q = 'select count(ID) ';
            $q.=' FROM mensaje  ';
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
        $cn = new connect_new();
        try {
            $q = 'Select ID,remitente_ID,nombre,email,asunto,mensaje,archivo,nombre_archivo,email_destinatario,email_amigo,nombre_amigo,empresa_ID,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
            $q.=' from mensaje ';
            $q.=' where del=0 and ID=' . $ID;

            $dt = $cn->getGrid($q);
            $oMensaje = null;

            foreach ($dt as $item) {
                $oMensaje = new mensaje();

                $oMensaje->ID = $item['ID'];
                $oMensaje->remitente_ID = $item['remitente_ID'];
                $oMensaje->nombre = $item['nombre'];
                $oMensaje->email = $item['email'];
                $oMensaje->asunto = $item['asunto'];
                $oMensaje->mensaje = $item['mensaje'];
                $oMensaje->archivo = $item['archivo'];
                $oMensaje->nombre_archivo = $item['nombre_archivo'];
                $oMensaje->email_destinatario = $item['email_destinatario'];
                $oMensaje->email_amigo = $item['email_amigo'];
                $oMensaje->nombre_amigo = $item['nombre_amigo'];
                $oMensaje->empresa_ID = $item['empresa_ID'];
                $oMensaje->usuario_id = $item['usuario_id'];
                $oMensaje->usuario_mod_id = $item['usuario_mod_id'];
            }
            return $oMensaje;
        } catch (Exeption $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }

    static function getGrid($filtro = '', $desde = -1, $hasta = -1, $order = 'ID asc') {
        $cn = new connect_new();
        try {
            $q = 'select ID,remitente_ID,nombre,email,asunto,mensaje,archivo,nombre_archivo,email_destinatario,email_amigo,nombre_amigo,empresa_ID,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
            $q.=' FROM mensaje';
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
            
            throw new Exception('Ocurrió un error en la consulta SQL');
        }
    }

}
