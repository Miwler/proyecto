<?php

class cliente_contacto {
    private $ID;
    private $codigo;
    private $cliente_ID;
    private $persona_ID;
    private $telefono;
    private $celular;
    private $correo;
    private $cargo;
    private $estado_ID;
    private $usuario_id;
    private $usuario_mod_id;
    Private $getMessage;
    Private $dtEstado;
    public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
        if (property_exists('cliente_contacto', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('cliente_contacto', $temporal)) {
            return $this->$temporal;
        }

        // Retorna nulo si no existe
        return null;
    }

    function insertar() {
        
        $retorna = -1;
        try {
            $q = 'select ifnull(max(ID),0)+1 from cliente_contacto;';
	    $cn = new connect_new();
            $ID=$cn->getData($q);
            $q = 'insert into cliente_contacto(ID,codigo,cliente_ID,persona_ID,telefono,celular,correo,cargo,estado_ID,usuario_id)';
            $q.='values('.$ID.',"'.$this->codigo.'",'.$this->cliente_ID.','.$this->persona_ID.',"'.$this->telefono.'","'.$this->celular.'",';
            $q.='"'.$this->correo.'","'.$this->cargo.'",'.$this->estado_ID.','.$this->usuario_id.');';   
            //echo $q;
	    $cn = new connect_new();
            $retorna = $cn->transa($q);
            $this->ID = $ID;
            $this->getMessage = 'Se guardó correctamente';
            return $retorna;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
 function insertar1()
    {
    $cn =new connect_new();
    try
    {
      $ID=$cn->store_procedure_transa(
          "sp_cliente_contacto_Insert",
            array(
            "iID"=>0,
            "icodigo"=>$this->codigo,
            "icliente_ID"=>$this->cliente_ID,
            "ipersona_ID"=>$this->persona_ID,
            "itelefono"=>$this->telefono,
            "icelular"=>$this->celular,
            "icorreo"=>$this->correo,
            "icargo"=>$this->cargo,
            "iusuario_id"=>$this->usuario_id,
            "iestado_ID"=>$this->estado_ID
        ),0);
      if($ID>0){
        $this->getMessage="El registro se guardó correctamente.";
        $this->ID=$ID;
        
      } 
      return $ID;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "cliente_contacto.insertar", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
function actualizar() {
    $cn = new connect_new();
    $retornar = -1;
    try {
        $q = 'update cliente_contacto set codigo="'.$this->codigo.'",cliente_ID='.$this->cliente_ID.',persona_ID='.$this->persona_ID.',';
        $q.='telefono="'.$this->telefono.'",celular="'.$this->celular.'",correo="'.$this->correo.'",cargo="'.$this->cargo.'",';
        $q.='estado_ID='.$this->estado_ID.',usuario_mod_id=' . $this->usuario_mod_id.',fdm=now() ';
        $q.='where del=0 and ID=' . $this->ID;
        //echo $q;
        $retornar = $cn->transa($q);
        $this->getMessage = 'Se guardó correctamente';
        return $retornar;
    } catch (Exception $ex) {
        throw new Exception($q);
    }
}



function actualizar1()
    {
    $cn =new connect_new();
    $retornar =0;
    try
    {
      $retornar=$cn->store_procedure_transa(
          "sp_cliente_contacto_Update",
            array(
              "retornar"=>$retornar,
                    "iID"=>$this->ID,
                    "icodigo"=>$this->codigo,
                    "icliente_ID"=>$this->cliente_ID,
                    "ipersona_ID"=>$this->persona_ID,
                    "itelefono"=>$this->telefono,
                    "icelular"=>$this->celular,
                    "icorreo"=>$this->correo,
                    "icargo"=>$this->cargo,
                    "iusuario_mod_id"=>$this->usuario_mod_id,
                    "iestado_ID"=>$this->estado_ID
                ),0);
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "cliente_contacto.actualizar", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }




    function eliminar() {
        $cn = new connect_new();
        $retornar = -1;
        try {

            $q = 'UPDATE cliente_contacto SET del=1,usuario_mod_id=' . $this->usuario_mod_id . ', fdm=Now()';
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
            $q.=' FROM representante_cliente as pr ';
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
    static function getCodigo() {
        $cn = new connect_new();
        try {
            $q = 'select ifNULL(max(ID),0)+1 from cliente_contacto ';
            //echo $q;
            $resultado = "CC".sprintf("%'.05d",$cn->getData($q));

            return $resultado;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }

  static function getByID($ID) {
        $cn = new connect_new();
        try {
            $q = 'select ID,codigo,cliente_ID,persona_ID,telefono,celular,correo,cargo,estado_ID,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
            $q.=' from cliente_contacto ';
            $q.=' where del=0 and ID=' . $ID;
            //echo $q;
            $dt = $cn->getGrid($q);
            $oCliente_Contacto = null;

            foreach ($dt as $item) {
                $oCliente_Contacto = new cliente_contacto();
                $oCliente_Contacto->ID = $item['ID'];
                $oCliente_Contacto->codigo = $item['codigo'];
                $oCliente_Contacto->cliente_ID = $item['cliente_ID'];
                $oCliente_Contacto->persona_ID = $item['persona_ID'];
                $oCliente_Contacto->telefono = $item['telefono'];
                $oCliente_Contacto->celular = $item['celular'];
                $oCliente_Contacto->correo = $item['correo'];
                $oCliente_Contacto->cargo = $item['cargo'];
                $oCliente_Contacto->estado_ID = $item['estado_ID'];
                $oCliente_Contacto->usuario_id = $item['usuario_id'];
                $oCliente_Contacto->usuario_mod_id = $item['usuario_mod_id'];
            }
            return $oCliente_Contacto;
        } catch (Exeption $ex) {
            throw new Exception($q);
        }
    }
static function getByIDCliente($cliente_ID) {
        $cn = new connect_new();
        try {
            $q = 'Select ID,nombres,codigo,apellidos,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
            $q.=' from representante_cliente ';
            $q.=' where del=0 and cliente_ID=' . $cliente_ID;

            $dt = $cn->getGrid($q);
            $oRepresentanteCliente = null;

            foreach ($dt as $item) {
                $oRepresentanteCliente = new representantecliente();

                $oRepresentanteCliente->ID = $item['ID'];
                $oRepresentanteCliente->nombres = $item['nombres'];
                $oRepresentanteCliente->apellidos = $item['apellidos'];
                $oRepresentanteCliente->usuario_id = $item['usuario_id'];
                $oRepresentanteCliente->usuario_mod_id = $item['usuario_mod_id'];
            }
            return $oRepresentanteCliente;
        } catch (Exeption $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }
   
    static function getGrid($filtro = '', $desde = -1, $hasta = -1, $order = 'clic.ID asc') {
        $cn = new connect_new();
        try {
            $q = 'SELECT clic.ID,clic.codigo,clic.persona_ID,clic.telefono,clic.celular,clic.correo,clic.cargo,clic.estado_ID,';
            $q.='cli.razon_social, pe.apellido_paterno, pe.apellido_materno, CONCAT(pe.apellido_paterno," ",pe.apellido_materno) AS apellidos, pe.nombres,pe.direccion,es.nombre as estado';
            $q.=' FROM cliente_contacto clic, cliente as cli,persona pe,estado es ';
            $q.=' where cli.ID=clic.cliente_ID and clic.persona_ID=pe.ID and clic.estado_ID=es.ID and clic.del=0 ';


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
            $q="select count(ID) from cliente_contacto where del=0 and cliente_ID=".$this->cliente_ID." and persona_ID=".$this->persona_ID;
            if($this->ID!=""){
                $q.=" and ID<>".$this->ID;
            }
            $this->Message="La persona ya se encuentra asignado";
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }
   
    function verificarHijos($cliente_ID){
        $cn = new connect_new();     
        $retornar = -1;
        try {
		//Verifico que no se repita el nombre
            $q='SELECT count(ID) FROM cliente_contacto clic';
            $q.=' WHERE clic.del=0 and clic.cliente_ID='.$cliente_ID;		
            //echo $q;
            $retornar=$cn->getData($q);			
            return $retornar;
			
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }

}
