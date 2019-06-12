<?php

class cliente {

    private $ID;
    private $empresa_ID;
    
    private $codigo;
    private $razon_social;
    private $nombre_comercial;
    private $ruc;
    private $direccion;
    private $direccion_fiscal;
    private $distrito_ID;
    private $telefono;
    private $celular;
    private $correo;
    private $forma_pago_ID;
    private $banco;
    private $numero_cuenta_soles;
    private $numero_cuenta_dolares;
    private $estado_ID;
    private $descuento;
    private $tiempo_credito;
    private $correlativo;
    private $usuario_id;
    private $usuario_mod_id;
    Private $getMessage;
    Private $dtDepartamento;
    Private $dtProvincia;
    Private $dtDistrito;
    Private $dtEstado;
    Private $departamento_ID;
    Private $provincia_ID;
    Private $dtForma_Pago;
    Private $dtCredito;
    private $tipo_documento_ID;
    private $operador_ID;
	
    public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
        if (property_exists('cliente', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('cliente', $temporal)) {
            return $this->$temporal;
        }

        // Retorna nulo si no existe
        return null;
    }

    function insertar() {
        
        $retornar = -1;
        try {
            $q = 'select ifnull(max(ID),0)+1 from cliente';
			$cn = new connect_new();
            $ID=$cn->getData($q);

            $q= 'insert into cliente(ID,empresa_ID,codigo,razon_social,nombre_comercial,ruc,direccion,direccion_fiscal,';
            $q.='distrito_ID,telefono,celular,correo,forma_pago_ID,banco,numero_cuenta_soles,numero_cuenta_dolares,estado_ID,';
            $q.='descuento,tiempo_credito,usuario_id)';
            $q.='values('.$ID.','.$this->empresa_ID.',"'.$this->codigo.'","'.$this->razon_social.'","'.$this->nombre_comercial.'","'.$this->ruc.'",';
            $q.='"'.$this->direccion.'","'.$this->direccion_fiscal.'",'.$this->distrito_ID.',"'.$this->telefono.'","'.$this->celular.'",';
            $q.='"'.$this->correo.'",'.$this->forma_pago_ID.',"'.$this->banco. '","'.$this->numero_cuenta_soles. '","'.$this->numero_cuenta_dolares. '",';
            $q.=$this->estado_ID . ',"'.$this->descuento.'","'.$this->tiempo_credito.'",'.$this->usuario_id.')';
            //echo $q;
			$cn = new connect_new();
            $retornar = $cn->transa($q);
            $this->ID = $ID;
            $this->getMessage = 'Se guardó correctamente';
            return $retornar;
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
          "sp_cliente_Insert",
            array(
                "iID"=>0,
                "iempresa_ID"=>$this->empresa_ID,
                "icodigo"=>$this->codigo,
                "irazon_social"=>$this->razon_social,
                "inombre_comercial"=>$this->nombre_comercial,
                "iruc"=>$this->ruc,
                "idireccion"=>$this->direccion,
                "idireccion_fiscal"=>$this->direccion_fiscal,
                "idistrito_ID"=>$this->distrito_ID,
                "itelefono"=>$this->telefono,
                "icelular"=>$this->celular,
                "icorreo"=>$this->correo,
                "iforma_pago_ID"=>$this->forma_pago_ID,
                "ibanco"=>$this->banco,
                "inumero_cuenta_soles"=>$this->numero_cuenta_soles,
                "inumero_cuenta_dolares"=>$this->numero_cuenta_dolares,
                "iestado_ID"=>$this->estado_ID,
                "idescuento"=>$this->descuento,
                "itiempo_credito"=>$this->tiempo_credito,
                "iusuario_id"=>$this->usuario_id,
                "icorrelativo"=>$this->correlativo,
                "itipo_documento_ID"=>$this->tipo_documento_ID
            ),0);
      if($ID>0){
        $this->getMessage="El registro se guardó correctamente.";
        $this->ID=$ID;
        
      } 
      return $ID;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "cliente.insertar", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }

    function actualizar() {
        $cn = new connect_new();
        $retornar = -1;
        try {
            $q='update cliente set ';
            $q.='empresa_ID='.$this->empresa_ID.',';
            $q.='codigo="'.$this->codigo.'",';
            $q.='razon_social="'.$this->razon_social.'",';
            $q.='nombre_comercial="'.$this->nombre_comercial.'",';
            $q.='ruc="'.$this->ruc.'",';
            $q.='direccion="'.$this->direccion.'",';
            $q.='direccion_fiscal="'.$this->direccion_fiscal.'",';
            $q.='distrito_ID='.$this->distrito_ID.',';
            $q.='telefono="'.$this->telefono.'",';
            $q.='celular="'.$this->celular.'",';
            $q.='correo="'.$this->correo.'",';
            $q.='forma_pago_ID='.$this->forma_pago_ID.',';
            $q.='banco="'.$this->banco.'",';
            $q.='numero_cuenta_soles="'.$this->numero_cuenta_soles.'",';
            $q.='numero_cuenta_dolares="'.$this->numero_cuenta_dolares.'",';
            $q.='estado_ID='.$this->estado_ID.',';
            $q.='descuento='.$this->descuento.',';
            $q.='tiempo_credito='.$this->tiempo_credito.',';
            $q.='usuario_mod_id='.$this->usuario_mod_id.',';
            $q.='fdm=now() where del=0 and ID=' . $this->ID;
            $retornar = $cn->transa($q);
            $this->getMessage = 'Se actualizó correctamente.';
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
          "sp_cliente_Update",
            array(
                "retornar"=>$retornar,
                "iID"=>$this->ID,
                "iempresa_ID"=>$this->empresa_ID,
                "icodigo"=>$this->codigo,
                "irazon_social"=>$this->razon_social,
                "inombre_comercial"=>$this->nombre_comercial,
                "iruc"=>$this->ruc,
                "idireccion"=>$this->direccion,
                "idireccion_fiscal"=>$this->direccion_fiscal,
                "idistrito_ID"=>$this->distrito_ID,
                "itelefono"=>$this->telefono,
                "icelular"=>$this->celular,
                "icorreo"=>$this->correo,
                "iforma_pago_ID"=>$this->forma_pago_ID,
                "ibanco"=>$this->banco,
                "inumero_cuenta_soles"=>$this->numero_cuenta_soles,
                "inumero_cuenta_dolares"=>$this->numero_cuenta_dolares,
                "iestado_ID"=>$this->estado_ID,
                "idescuento"=>$this->descuento,
                "itiempo_credito"=>$this->tiempo_credito,
                "iusuario_mod_id"=>$this->usuario_mod_id,
                "icorrelativo"=>$this->correlativo,
                "itipo_documento_ID"=>$this->tipo_documento_ID
            ),0);
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "cliente.actualizar", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
    
    

    function eliminar() {
        $cn = new connect_new();
        $retornar = -1;
        try {

            $q = 'UPDATE cliente SET del=1,usuario_mod_id=' . $this->usuario_mod_id . ', fdm=Now()';
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
            $q = 'select count(clt.ID) ';
            $q.=' FROM cliente as clt ';
            $q.=' where clt.del=0 ';

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
            $q = 'select max(ID)+1';
            $q.=' FROM cliente ';
           //sprintf("%'.07d"
            $resultado ="C".sprintf("%'.05d",$cn->getData($q) );
            return $resultado;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }
    static function getByID($ID) {
        $cn = new connect_new();
        try {
            $q = 'Select ID,empresa_ID,codigo,razon_social,nombre_comercial,ruc,direccion, direccion_fiscal,distrito_ID,';
            $q.= 'telefono, celular,correo, ifnull(forma_pago_ID,0) as forma_pago_ID,banco, numero_cuenta_soles, numero_cuenta_dolares, estado_ID,';
            $q.= 'descuento, ifnull(tiempo_credito,0) as tiempo_credito, usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
            $q.=' from cliente ';
            $q.=' where del=0 and ID='.$ID;
            //echo $q;
            $dt = $cn->getGrid($q);
            $oCliente = null;

            foreach ($dt as $item) {
                $oCliente = new cliente();

                $oCliente->ID = $item['ID'];
                $oCliente->empresa_ID = $item['empresa_ID'];
                $oCliente->codigo = $item['codigo'];
                $oCliente->razon_social = $item['razon_social'];
                $oCliente->nombre_comercial = $item['nombre_comercial'];
                $oCliente->ruc = $item['ruc'];
                $oCliente->direccion = $item['direccion'];
                $oCliente->direccion_fiscal = $item['direccion_fiscal'];
                $oCliente->distrito_ID = $item['distrito_ID'];
                $oCliente->telefono = $item['telefono'];
                $oCliente->celular= $item['celular'];
                $oCliente->correo = $item['correo'];
                $oCliente->forma_pago_ID = $item['forma_pago_ID'];
                $oCliente->banco = $item['banco'];
                $oCliente->numero_cuenta_soles = $item['numero_cuenta_soles'];
                $oCliente->numero_cuenta_dolares = $item['numero_cuenta_dolares'];
                $oCliente->estado_ID = $item['estado_ID'];
                $oCliente->descuento = $item['descuento'];
                $oCliente->tiempo_credito = $item['tiempo_credito'];
                $oCliente->usuario_id = $item['usuario_id'];
                $oCliente->usuario_mod_id = $item['usuario_mod_id'];
            }
            return $oCliente;
        } catch (Exeption $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }
    static function getByID1($ID)
    {
    $cn =new connect_new();
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_cliente_getByID",
          array("iID"=>$ID));
      $ocliente=null;
      foreach($dt as $item)
      {
        $ocliente= new cliente();
      $ocliente->ID=$item["ID"];
      $ocliente->empresa_ID=$item["empresa_ID"];
      $ocliente->codigo=$item["codigo"];
      $ocliente->razon_social=$item["razon_social"];
      $ocliente->nombre_comercial=$item["nombre_comercial"];
      $ocliente->ruc=$item["ruc"];
      $ocliente->direccion=$item["direccion"];
      $ocliente->direccion_fiscal=$item["direccion_fiscal"];
      $ocliente->distrito_ID=$item["distrito_ID"];
      $ocliente->telefono=$item["telefono"];
      $ocliente->celular=$item["celular"];
      $ocliente->correo=$item["correo"];
      $ocliente->forma_pago_ID=$item["forma_pago_ID"];
      $ocliente->banco=$item["banco"];
      $ocliente->numero_cuenta_soles=$item["numero_cuenta_soles"];
      $ocliente->numero_cuenta_dolares=$item["numero_cuenta_dolares"];
      $ocliente->estado_ID=$item["estado_ID"];
      $ocliente->descuento=$item["descuento"];
      $ocliente->tiempo_credito=$item["tiempo_credito"];
      $ocliente->usuario_id=$item["usuario_id"];
      $ocliente->usuario_mod_id=$item["usuario_mod_id"];
      $ocliente->correlativo=$item["correlativo"];
      $ocliente->tipo_documento_ID=$item["tipo_documento_ID"];

      }
      return $ocliente;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "cliente.getByID", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }

    static function getGrid($filtro = '', $desde = -1, $hasta = -1, $order = 'clt.ID asc') {
        $cn = new connect_new();
        try {
            $q = 'SELECT clt.ID,clt.empresa_ID,clt.codigo,clt.razon_social,clt.nombre_comercial,clt.ruc,';
            $q.='clt.direccion,clt.direccion_fiscal,clt.distrito_ID,clt.telefono,clt.celular,clt.correo,';
            $q.='clt.forma_pago_ID,clt.banco,clt.numero_cuenta_soles,clt.numero_cuenta_dolares,clt.estado_ID,';
            $q.='clt.descuento,clt.tiempo_credito,clt.usuario_id,td.abreviatura as documento';
            $q.=' FROM cliente as clt,tipo_documento td ';
            $q.=' where clt.tipo_documento_ID=td.ID and clt.del=0 and clt.empresa_ID='.$_GET['empresa_ID'];
            

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
            throw new Exception('Ocurrio un error en la consulta');
        }
    }

    function verificarDuplicado() {
        $cn = new connect_new();
        $retornar = -1;
        try {
            $q="select  count(ID) from cliente ";
            $q.=" where del=0 and empresa_ID=".$_GET['empresa_ID']." and ruc ='".$this->ruc."'";
           
                $filtro="";
                if(isset($this->ID)){
                    $filtro=" and ID<>".$this->ID;
                }
                $q.=$filtro;
                $retornar=$cn->getData($q);
            if($retornar>0){
                $this->getMessage="Existe un cliente registrado con el mismo ruc";
            }
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }
    
    
    
    function verificarDuplicado_RazonSocial() {
        $cn = new connect_new();
        $retornar = -1;
        try {
            $q="select  count(ID) from cliente ";
            $q.=" where del=0 and empresa_ID=".$_GET['empresa_ID']." and razon_social ='".$this->razon_social."'";
           
                $filtro="";
                if(isset($this->ID)){
                    $filtro=" and ID<>".$this->ID;
                }
                $q.=$filtro;
                $retornar=$cn->getData($q);
            if($retornar>0){
                $this->getMessage="Existe un cliente registrado con la misma razon social";
            }
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }
    
    
    static function MostrarGraficoCliente_Exclusivo() {
        $cn = new connect_new();
        try {
            $q = 'select clt.ID, clt.razon_social as razon_social, clt.ruc, sum(ovd.precio_venta_soles) as precio_venta_soles, sum(ovd.precio_venta_dolares) as precio_venta_dolares  ';
            $q.= 'from cliente clt, producto pr, orden_venta ov, orden_venta_detalle ovd  ';
            $q.= 'WHERE clt.ID = ov.cliente_ID AND ov.ID = ovd.orden_venta_ID AND pr.ID = ovd.producto_ID  ';
            $q.= 'GROUP BY clt.ID, clt.razon_social, clt.ruc ';
            $q.= 'ORDER BY  precio_venta_soles, precio_venta_dolares DESC  ';
             $q.=' limit 10';
//                       echo $q;
            $dt = $cn->getGrid($q);
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    static function geLista($buscar='')
    {
        $cn =new connect_new();
        try 
        {
            //$q='call getListaClientes('.$_GET['empresa_ID'].',"'.$buscar.'");';
            //echo $q;
            //$dt=$cn->getGrid($q);
            $dt=$cn->store_procedure_getGrid('getListaClientes',
                    array('empresa_ID'=>$_GET['empresa_ID'],
                        'buscar'=>$buscar));
            return $dt;												
        }catch(Exception $ex)
        {
                throw new Exception($ex->getMessage());
        }
    }
}
