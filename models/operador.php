<?php

class operador {
    private $ID;
    private $empresa_ID;
    private $persona_ID;
    private $telefono;
    private $celular;
    private $mail;
    private $fecha_contrato;
    private $comision;
    private $cargo_ID;
    private $usuario_id;
    private $usuario_mod_id;
    private $estado_civil;
    Private $getMessage;
    private $dtTipo_Documento;
    private $dtCargo;
    private $tipo_documento_ID;
    private $nombres_completo;
    private $apellido_paterno;
    private $apellido_materno;
    private $nombres;

    public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el nombres es la cadena en "$temporal"		
        if (property_exists('operador', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('operador', $temporal)) {
            return $this->$temporal;
        }

        // Retorna nulo si no existe
        return null;
    }

    function insertar() {
        
        $retorna = -1;
        try {
            
            $fecha_nacimiento_save='NULL';
            if($this->fecha_nacimiento!=null){
                $fecha_nacimiento_save='"'.FormatTextToDate($this->fecha_nacimiento,'Y-m-d').'"';
            }
            $fecha_contrato_save='NULL';
            if($this->fecha_contrato!=null){
                $fecha_contrato_save='"'.FormatTextToDate($this->fecha_contrato,'Y-m-d').'"';
            }
            $q = 'select ifnull(max(ID),0)+1 from operador;';
			$cn = new connect_new();
            $ID=$cn->getData($q);
            
            $q = 'insert into operador(ID, persona_ID,empresa_ID, telefono,celular,mail,fecha_contrato,comision,cargo_ID, usuario_id)';
            $q.='values('.$ID.','.$this->persona_ID.','.$_SESSION["empresa_ID"].',"'.$this->telefono.'","'.$this->celular.'","'.$this->mail.'",'.$fecha_contrato_save.',';
            $q.=$this->comision.','.$this->cargo_ID.','.$this->usuario_id.');';
            //echo $q;
			$cn = new connect_new();
            $retorna = $cn->transa($q);
            $this->ID = $ID;
            $this->getMessage = 'Se guardó correctamente';
            return $retorna;
        } catch (Exception $ex) {

            throw new Exception("Ocurrio un error en la consulta");
        }
    }

    function actualizar() {
        $cn = new connect_new();
        $retornar = -1;
        try {
           
            $fecha_contrato_save='NULL';
            if($this->fecha_contrato!=null && $this->fecha_contrato!="__/__/____"){
                $fecha_contrato_save='"'.FormatTextToDate($this->fecha_contrato,'Y-m-d').'"';
            }
            $q = 'update operador SET persona_ID=' . $this->persona_ID.', telefono="'.$this->telefono.'",';
            $q.='celular="'.$this->celular.'",mail="'.$this->mail.'",fecha_contrato="'.$fecha_contrato_save.'",';
            $q.='cargo_ID='.$this->cargo_ID.',usuario_mod_id='.$this->usuario_mod_id.', fdc=now()';
            $q.=' where del=0 and ID='.$this->ID;
            //echo $q;
            $retornar = $cn->transa($q);
            $this->getMessage = 'Se actualizó correctamente.';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }

    function eliminar() {
        $cn = new connect_new();
        $retornar = -1;
        try {

            $q = 'UPDATE operador SET del=1,usuario_mod_id=' . $this->usuario_mod_id . ', fdm=Now()';
            $q.=' WHERE del=0 and ID=' . $this->ID;

            $retornar = $cn->transa($q);

            $this->getMessage = 'Se eliminó correctamente';
            return $q;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }

    static function getCount($filtro = '') {
        $cn = new connect_new();
        try {
            $q = 'select count(op.ID) ';
            $q.=' FROM operador as op, cargo as ca, persona pe,persona_documento ped';
            $q.=' where op.persona_ID=pe.ID and op.cargo_ID=ca.ID and ped.persona_ID=pe.ID and  op.del=0 and op.empresa_ID='.$_SESSION['empresa_ID'];

            if ($filtro != '') {
                $q.=' and ' . $filtro;
            }
            //echo $q;
            $resultado = $cn->getData($q);

            return $resultado;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }

    static function getByID($ID) {
        $cn = new connect_new();
        try {
            $q = 'Select op.ID,op.empresa_ID,op.persona_ID,op.telefono, op.celular, op.mail,ifnull(op.fecha_contrato,"0000-00-00") as fecha_contrato ,op.comision,op.cargo_ID,op.usuario_id,ifnull(op.usuario_mod_id,-1) as usuario_mod_id';
            $q.=',pe.apellido_paterno,pe.apellido_materno,pe.nombres';
            $q.=' from operador op,persona pe ';
            $q.=' where op.persona_ID=pe.ID and op.del=0 and op.ID='.$ID;
             //echo $q;
            $dt = $cn->getGrid($q);

            $oOperador = null;

            foreach ($dt as $item) {
                $oOperador = new operador();

                $oOperador->ID = $item['ID'];
                $oOperador->persona_ID = $item['persona_ID'];
                $oOperador->empresa_ID = $item['empresa_ID'];
                $oOperador->telefono = $item['telefono'];
                $oOperador->celular = $item['celular'];
                $oOperador->mail = $item['mail'];
                $oOperador->fecha_contrato = $item['fecha_contrato'];
                $oOperador->comision = $item['comision'];
                $oOperador->cargo_ID = $item['cargo_ID'];
                $oOperador->usuario_id = $item['usuario_id'];
                $oOperador->usuario_mod_id = $item['usuario_mod_id'];
                $oOperador->apellido_paterno = $item['apellido_paterno'];
                $oOperador->apellido_materno = $item['apellido_materno'];
                $oOperador->nombres = $item['nombres'];
            }
            return $oOperador;
        } catch (Exeption $ex) {
            throw new Exception($q);
        }
    }

    static function getGrid($filtro = '', $desde = -1, $hasta = -1, $order = 'op.ID asc') {
        $cn = new connect_new();
        try {
            $q= 'SELECT op.ID,op.persona_ID,op.telefono,op.celular,op.mail,ifnull(op.fecha_contrato,-1) as fecha_contrato ,op.comision,op.cargo_ID,';
            $q.= 'op.usuario_id,ifnull(op.usuario_mod_id,-1) as usuario_mod_id,';
            $q.= 'pe.apellido_paterno, pe.apellido_materno,pe.nombres,ifnull(ped.numero,"") as numero';
            $q.=' FROM operador as op, cargo as ca, persona pe left join persona_documento ped on ped.persona_ID=pe.ID';
            $q.=' where op.persona_ID=pe.ID and op.cargo_ID=ca.ID  and op.del=0 and op.empresa_ID='.$_SESSION['empresa_ID'];


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


    static function getCargo($usuario_ID) {
        $cn = new connect_new();
        try {
            $q = 'select op.cargo_ID';
            $q.=' from operador op, usuario us,persona pe ';
            $q.=' where op.persona_ID=pe.ID and us.persona_ID=pe.ID and us.del=0 and us.ID='.$usuario_ID;

            $retorna = $cn->getData($q);
            return $retorna;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    static function getOperador($usuario_ID) {
        $cn = new connect_new();
        try {
            $q = 'select op.ID';
            $q.=' from operador op, usuario us,persona pe ';
            $q.=' where us.persona_ID=pe.ID and op.persona_ID=pe.ID and us.del=0 and us.ID='.$usuario_ID;

            $retorna = $cn->getData($q);
            return $retorna;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
   
    function verificar_duplicado() {
        $cn = new connect_new();
        try {
            $q = 'select count(ID) from operador where del=0 and persona_ID='.$this->persona_ID;
            if($this->ID!=""){
                $q.=' and ID<>'.$this->ID;
            }
            $retorna = $cn->getData($q);
            return $retorna;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
}
