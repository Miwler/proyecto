<?php

class proveedor {
    private $ID;
    private $empresa_ID;
    private $ruc;
    private $razon_social;
    private $nombre_comercial;
    private $direccion;
    private $direccion_fiscal;
    private $telefono;
    private $fax;
    private $celular;

    private $correo;
    private $banco;
    private $numero_cuenta_soles;
    private $numero_cuenta_dolares;
    private $parne;
    private $estado_ID;
    private $distrito_ID;
    private $usuario_id;
    private $usuario_mod_id;
    Private $getMessage;
    private $dtDepartamento;
    private $dtProvincia;
    private $dtDistrito;
    private $departamento_ID;
    private $provincia_ID;
    private $dtEstado;
    public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

// Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
        if (property_exists('proveedor', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

// Verifica que exista
        if (property_exists('proveedor', $temporal)) {
            return $this->$temporal;
        }

// Retorna nulo si no existe
        return null;
    }

    function insertar() {
        
        $retornar = -1;
        try {

            $q = 'select ifnull(max(ID),0)+1 from proveedor;';
			$cn = new connect_new();
            $ID=$cn->getData($q);
            $q= 'insert into proveedor(ID,empresa_ID, ruc, razon_social, nombre_comercial, direccion, direccion_fiscal, telefono,fax,';
            $q.= 'celular,correo, banco, numero_cuenta_soles, numero_cuenta_dolares, parne, estado_ID, distrito_ID, usuario_id)';
            $q.=' values('.$ID.','.$this->empresa_ID.',"'.$this->ruc. '","'.$this->razon_social. '","'.$this->nombre_comercial.'",';
            $q.='"'.$this->direccion.'","'.$this->direccion_fiscal.'","'.$this->telefono.'","'.$this->fax.'","'.$this->celular.'",';
            $q.='"'.$this->correo.'","'.$this->banco.'","'.$this->numero_cuenta_soles.'","'.$this->numero_cuenta_dolares.'",';
            $q.='"'.$this->parne.'",'.$this->estado_ID.','.$this->distrito_ID.','.$this->usuario_id.');';   
            //echo $q;
			$cn = new connect_new();
            $retornar = $cn->transa($q);
            $this->ID =$ID;
            $this->getMessage = 'Se guardó correctamente ';
            return $retornar;
        } catch (Exception $ex) {

            throw new Exception("Ocurrió un error al insertar el proveedor en la BD.");
        }
    }
    
    
    function insertar1()
    {
    $cn =new connect_new();
    try
    {
      $ID=$cn->store_procedure_transa(
          "sp_proveedor_Insert",
            array(
    "iID"=>0,
    "iempresa_ID"=>$this->empresa_ID,
    "iruc"=>$this->ruc,
    "irazon_social"=>$this->razon_social,
    "inombre_comercial"=>$this->nombre_comercial,
    "idireccion"=>$this->direccion,
    "idireccion_fiscal"=>$this->direccion_fiscal,
    "itelefono"=>$this->telefono,
    "ifax"=>$this->fax,
    "icelular"=>$this->celular,
    "icorreo"=>$this->correo,
    "ibanco"=>$this->banco,
    "inumero_cuenta_soles"=>$this->numero_cuenta_soles,
    "inumero_cuenta_dolares"=>$this->numero_cuenta_dolares,
    "iparne"=>$this->parne,
    "iestado_ID"=>$this->estado_ID,
    "idistrito_ID"=>$this->distrito_ID,
    "iusuario_id"=>$this->usuario_id,

),0);
      if($ID>0){
        $this->getMessage="El registro se guardó correctamente.";
        $this->ID=$ID;
        
      } 
      return $ID;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "proveedor.insertar", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
    

    function actualizar() {
        $cn = new connect_new();
        $retornar = -1;
        try {
            $q='update proveedor set empresa_ID='.$this->empresa_ID.',ruc="'.$this->ruc.'",razon_social="'.$this->razon_social.'",';
            $q.='nombre_comercial="'.$this->nombre_comercial.'",direccion="'.$this->direccion.'",direccion_fiscal="'.$this->direccion_fiscal.'",';
            $q.='telefono="'.$this->telefono.'",fax="'.$this->fax.'",celular="'.$this->celular.'",correo="'.$this->correo.'",';
            $q.='banco="'.$this->banco.'",numero_cuenta_soles="'.$this->numero_cuenta_soles.'",numero_cuenta_dolares="'.$this->numero_cuenta_dolares.'",';
            $q.='parne="'.$this->parne.'",estado_ID='.$this->estado_ID.',distrito_ID='.$this->distrito_ID.',usuario_mod_id=' . $this->usuario_mod_id;
            $q.=', fdm=now() where del=0 and ID='.$this->ID;
            $retornar = $cn->transa($q);
            $this->getMessage = 'Se actualizó correctamente';
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
      $ID=$cn->store_procedure_transa(
          "sp_proveedor_Update",
            array(
              "retornar"=>$retornar,
    "iID"=>$this->ID,
    "iempresa_ID"=>$this->empresa_ID,
    "iruc"=>$this->ruc,
    "irazon_social"=>$this->razon_social,
    "inombre_comercial"=>$this->nombre_comercial,
    "idireccion"=>$this->direccion,
    "idireccion_fiscal"=>$this->direccion_fiscal,
    "itelefono"=>$this->telefono,
    "ifax"=>$this->fax,
    "icelular"=>$this->celular,
    "icorreo"=>$this->correo,
    "ibanco"=>$this->banco,
    "inumero_cuenta_soles"=>$this->numero_cuenta_soles,
    "inumero_cuenta_dolares"=>$this->numero_cuenta_dolares,
    "iparne"=>$this->parne,
    "iestado_ID"=>$this->estado_ID,
    "idistrito_ID"=>$this->distrito_ID,
    "iusuario_mod_id"=>$this->usuario_mod_id
),0);
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "proveedor.actualizar", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
    

    function eliminar() {
        $cn = new connect_new();
        $retornar = -1;
        try {

            $q = 'UPDATE proveedor SET del=1,usuario_mod_id=' . $this->usuario_mod_id . ', fdm=Now()';
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
            $q = 'select count(prv.ID) ';
            $q.=' FROM proveedor as prv ';
            $q.=' where prv.del=0 ';

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

//modificado por ortega 31-05-2016.Solo traje los datos completos
    static function getByID($ID) {
        $cn = new connect_new();
        try {
            $q = 'Select ID,empresa_ID, ruc, razon_social, nombre_comercial, direccion, direccion_fiscal, telefono, fax, celular,correo, banco, numero_cuenta_soles, numero_cuenta_dolares, parne, estado_ID, distrito_ID, usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
            $q.=' from proveedor ';
            $q.=' where del=0 and ID=' . $ID;
            //echo $q;
            $dt = $cn->getGrid($q);
            $oProveedor = null;

            foreach ($dt as $item) {
                $oProveedor = new proveedor();

                $oProveedor->ID = $item['ID'];
                $oProveedor->empresa_ID = $item['empresa_ID'];
                $oProveedor->ruc = $item['ruc'];
                $oProveedor->razon_social = $item['razon_social'];
                $oProveedor->nombre_comercial = $item['nombre_comercial'];
                $oProveedor->direccion = $item['direccion'];
                $oProveedor->direccion_fiscal = $item['direccion_fiscal'];
                $oProveedor->distrito_ID = $item['distrito_ID'];
                $oProveedor->telefono = $item['telefono'];
                $oProveedor->fax = $item['fax'];
                $oProveedor->celular = $item['celular'];
                $oProveedor->correo = $item['correo'];
                $oProveedor->banco = $item['banco'];
                $oProveedor->correo = $item['correo'];
                $oProveedor->numero_cuenta_soles = $item['numero_cuenta_soles'];
                $oProveedor->numero_cuenta_dolares = $item['numero_cuenta_dolares'];
                $oProveedor->parne = $item['parne'];
                $oProveedor->estado_ID = $item['estado_ID'];
                $oProveedor->usuario_id = $item['usuario_id'];
                $oProveedor->usuario_mod_id = $item['usuario_mod_id'];
            }
            
            return $oProveedor;
        } catch (Exeption $ex) {
            throw new Exception($q);
        }
    }

    static function getGrid($filtro = '', $desde = -1, $hasta = -1, $order = 'prv.ID asc') {
        $cn = new connect_new();
        try {
            $q = 'Select prv.ID,prv.empresa_ID, prv.ruc, prv.razon_social, prv.nombre_comercial, prv.direccion,';
            $q.= 'prv.direccion_fiscal, prv.telefono, prv.fax, prv.celular,prv.correo, prv.banco, prv.numero_cuenta_soles,';
            $q.= 'prv.numero_cuenta_dolares, prv.parne, prv.estado_ID, prv.distrito_ID';
            $q.=' FROM proveedor as prv ';
            $q.=' where prv.del=0 ';


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

            $q = 'SELECT count(ID) FROM proveedor';
            $q.=' WHERE del=0 and ruc="'.$this->ruc.'"';

            if ($this->ID != '') {
                $q.=' and ID<>' . $this->ID;
            }
            //echo $q;
            $retornar = $cn->getData($q);

            if ($retornar > 0) {
                $this->getMessage = 'Ya existe un proveedor con el mismo ruc.';
                return $retornar;
            }
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception("Ocurrió un error en la consulta.");
        }
    }

}
