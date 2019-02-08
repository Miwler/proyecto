<?php

class proveedor_contacto {

    private $ID;
    private $persona_ID;
   
    private $telefono;
    private $celular;
    private $correo;	
    private $proveedor_ID;
    private $estado_ID;
    private $usuario_id;
    private $usuario_mod_id;
    private $getMessage;
    private $dtEstado;
    public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
        if (property_exists('proveedor_contacto', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('proveedor_contacto', $temporal)) {
            return $this->$temporal;
        }

        // Retorna nulo si no existe
        return null;
    }

    function insertar() {
        
        $retorna = -1;
        try {
            $q = 'select ifnull(max(ID),0)+1 from proveedor_contacto;';
	    $cn = new connect_new();
            $ID=$cn->getData($q);
            $q = 'insert into proveedor_contacto(ID, persona_ID,telefono, celular, correo,proveedor_ID,estado_ID,usuario_id)';
            $q.='values('.$ID.','.$this->persona_ID. ',"'.$this->telefono.'","' . $this->celular . '","' . $this->correo. '",'.$this->proveedor_ID.','.$this->estado_ID.','.$this->usuario_id.');';
            //echo $q;
	    $cn = new connect_new();
            $retorna = $cn->transa($q);
            $this->ID = $ID;
            $this->getMessage = 'Se guardó correctamente';
            return $retorna;
        } catch (Exception $ex) {

            throw new Exception('Ocurrio un error en la consulta');
        }
    }

    function actualizar() {
        $cn = new connect_new();
        $retornar = -1;
        try {
            $q = 'update proveedor_contacto set persona_ID=' . $this->persona_ID ;
            $q.=',telefono="'.$this->telefono.'",celular="'.$this->celular.'",correo="'.$this->correo.'",';
            $q.='proveedor_ID='.$this->proveedor_ID.', estado_ID='.$this->estado_ID.',usuario_mod_id='.$this->usuario_mod_id;
            $q.=', fdm=now() where del=0 and ID=' . $this->ID;
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

            $q = 'UPDATE proveedor_contacto SET del=1,usuario_mod_id=' . $this->usuario_mod_id . ', fdm=Now()';
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
            $q.=' FROM representante_proveedor as pr ';
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
            $q = 'Select ID,persona_ID,telefono,celular,correo,proveedor_ID,estado_ID,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
            $q.=' from proveedor_contacto ';
            $q.=' where del=0 and ID=' . $ID;

            $dt = $cn->getGrid($q);
            //echo $q;
            $oProveedor_Contacto = null;

            foreach ($dt as $item) {
                $oProveedor_Contacto = new proveedor_contacto();

                $oProveedor_Contacto->ID = $item['ID'];
                $oProveedor_Contacto->persona_ID = $item['persona_ID'];
                
                $oProveedor_Contacto->telefono = $item['telefono'];
                $oProveedor_Contacto->celular = $item['celular'];
                $oProveedor_Contacto->correo = $item['correo'];
                $oProveedor_Contacto->proveedor_ID = $item['proveedor_ID'];
                $oProveedor_Contacto->estado_ID = $item['estado_ID'];
                $oProveedor_Contacto->usuario_id = $item['usuario_id'];
                $oProveedor_Contacto->usuario_mod_id = $item['usuario_mod_id'];
            }
            return $oProveedor_Contacto;
        } catch (Exeption $ex) {
            throw new Exception($q);
        }
    }

    static function getGrid($filtro = '', $desde = -1, $hasta = -1, $order = 'proc.ID asc') {
    $cn = new connect_new();
        try {
            $q = 'SELECT proc.ID,proc.persona_ID,proc.telefono,proc.celular,proc.correo,proc.proveedor_ID,proc.estado_ID,proc.usuario_ID,ifnull(proc.usuario_mod_id,-1) as usuario_mod_id';
            $q.=',pe.apellido_paterno,pe.apellido_materno,pe.nombres,es.nombre as estado';
            $q.=' FROM proveedor_contacto proc,persona pe,estado es';
            $q.=' where proc.persona_ID=pe.ID and proc.estado_ID=es.ID  and proc.del=0';


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
            throw new Exception('Ocurrio un error en la consulta1');
        }
    }

    function verificarDuplicado() {
        $cn = new connect_new();
        $retornar = -1;
        try {
            $q="select count(ID) from proveedor_contacto where del=0 and proveedor_ID=".$this->proveedor_ID." and persona_ID=".$this->persona_ID;
            if($this->ID!=""){
                $q.=" and ID<>".$this->ID;
            }
            $this->Message="La persona ya se encuentra asignado";
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }
	
	
	function verificarHijos($proveedor_ID){
        $cn = new connect_new();     
        $retornar = -1;
        try {
		//Verifico que no se repita el nombre
			$q='SELECT count(ID) FROM proveedor_contacto proc';
			$q.=' WHERE proc.del=0 and proc.proveedor_ID='.$proveedor_ID;		
			//echo $q;
			$retornar=$cn->getData($q);			
			return $retornar;
			
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }

}
