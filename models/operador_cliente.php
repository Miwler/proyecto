<?php

class operador_cliente {
    private $ID;
    private $empresa_ID;
    private $cliente_ID;
    private $operador_ID;
    private $estado_ID;
    private $usuario_id;
    private $usuario_mod_id;
    Private $getMessage;
    public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
        if (property_exists('operador_cliente', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('operador_cliente', $temporal)) {
            return $this->$temporal;
        }

        // Retorna nulo si no existe
        return null;
    }
    
    
    function __construct()
  {
        $this->usuario_id=$_SESSION["usuario_ID"];
    $this->usuario_mod_id=$_SESSION["usuario_ID"];

  }
  function __destruct()
  {
        $this->usuario_id;
    $this->usuario_mod_id;

  }
    
    function insertar() {
        
        $retornar = -1;
        try {
            $q = 'Select ifnull(max(ID),0)+1 from operador_cliente;';
            $cn = new connect_new();
            $ID=$cn->getData($q);

            $q = 'INSERT INTO operador_cliente (ID,empresa_ID,cliente_ID,operador_ID,estado_ID,usuario_id)';
            $q.='VALUES ('.$ID.','.$_SESSION['empresa_ID'].','.$this->cliente_ID.','.$this->operador_ID.','.$this->estado_ID.','. $this->usuario_id .'); ';
              
         
            $cn = new connect_new();
            $retornar = $cn->transa($q);

            $this->getMessage = 'Se guardó correctamente.';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    
    function actualizar()
    {
        $cn =new connect_new();
        $retornar =0;
        try
        {
          $retornar=$cn->store_procedure_transa(
              "sp_operador_cliente_Update",
                array(
                  "retornar"=>$retornar,
                    "iID"=>$this->ID,
                    "icliente_ID"=>$this->cliente_ID,
                    "ioperador_ID"=>$this->operador_ID,
                    "iestado_ID"=>$this->estado_ID,
                    "iempresa_ID"=>$this->empresa_ID,
                    "iusuario_mod_id"=>$this->usuario_mod_id
                ),0);
            return $retornar;
        }catch(Exeption $ex)
        {
          log_error(__FILE__, "operador_cliente.actualizar", $ex->getMessage());
          throw new Exception($ex->getMessage());
        }
    }
  
    
    
    
    function eliminar() {
        $cn = new connect_new();
        $retornar = -1;
        try {

            $q = 'UPDATE operador_cliente SET del=1,usuario_mod_id=' . $this->usuario_id . ', fdm=Now()';
            $q.=' WHERE empresa_ID='.$_SESSION['empresa_ID'].' and del=0 and operador_ID=' . $this->operador_ID. ' and cliente_ID='.$this->cliente_ID;

            $retornar = $cn->transa($q);

            $this->getMessage = 'Se eliminó correctamente.';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un Error en la consulta eliminar");
        }
    }
    
    
    
    
    
     static function getByID($ID) {
        $cn = new connect_new();
        try {
            $q = 'Select ID,descripcion,usuario_id,fecha,operador_ID,cliente_ID,estado_id';
            $q.=' from operador_cliente ';
            $q.=' where del=0 and ID=' . $ID;

            $dt = $cn->getGrid($q);
            $oOperador_Cliente = null;

            foreach ($dt as $item) {
                $oOperador_Cliente = new operador_cliente();

                $oOperador_Cliente->ID = $item['ID'];
                $oOperador_Cliente->descripcion = $item['descripcion'];
                $oOperador_Cliente->usuario_id = $item['usuario_id'];
                $oOperador_Cliente->fecha = $item['fecha'];
                $oOperador_Cliente->operador_ID = $item['operador_ID'];
                $oOperador_Cliente->cliente_ID = $item['cliente_ID'];
                $oOperador_Cliente->estado_id = $item['estado_id'];
             
            }
            return $oOperador_Cliente;
        } catch (Exeption $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }

 static function getGrid($filtro = '', $desde = -1, $hasta = -1, $order = 'opc.ID asc') {
        $cn = new connect_new();
        try {
            $q = 'SELECT opc.ID,opc.empresa_ID,opc.operador_ID,opc.cliente_ID,opc.estado_ID,opc.usuario_id,';
            $q.='pe.apellido_paterno,pe.apellido_materno,pe.nombres, cli.ruc,cli.razon_social,es.nombre as estado';
            $q.=' FROM operador_cliente opc, operador op, persona pe,cliente cli,estado es';
            $q.=' where opc.operador_ID=op.ID and op.persona_ID=pe.ID and opc.cliente_ID=cli.ID and ';
            $q.=' opc.estado_ID=es.ID and opc.del=0 ';


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
   static function getByOperador($cliente_ID) {
        $cn = new connect_new();
        try {
            $q = 'SELECT ID,cliente_ID,operador_ID,estado_ID,empresa_ID,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id FROM operador_cliente ';
            $q.=' where del=0 and cliente_ID='.$cliente_ID.' and estado_ID=74 order by ID limit 1';
          
            $dt = $cn->getGrid($q);
            $oOperador_Cliente = null;

            foreach ($dt as $item) {
                $oOperador_Cliente = new operador_cliente();
                $oOperador_Cliente->ID = $item['ID'];
                $oOperador_Cliente->cliente_ID = $item['cliente_ID'];
                $oOperador_Cliente->operador_ID = $item['operador_ID'];
                $oOperador_Cliente->empresa_ID = $item['empresa_ID'];
                $oOperador_Cliente->estado_ID = $item['estado_ID'];
                $oOperador_Cliente->usuario_id= $item['usuario_id'];
                $oOperador_Cliente->usuario_mod_id= $item['usuario_mod_id'];

            }
            //echo $oOperador_Cliente->operador_ID;
            return $oOperador_Cliente;
        } catch (Exception $ex) {
            throw new Exception('Ocurrio un error en la consulta1');
        }
    }
    
    
    
    
    function verificarExistencia(){
    $cn = new connect_new();
        try {
           
            $q='select count(ID) from operador_cliente';
            $q.=' where empresa_ID='.$_SESSION['empresa_ID'].' and del=0 and operador_ID='.$this->operador_ID.' and cliente_ID='.$this->cliente_ID;
            
//echo $q;
            $retorna = $cn->getData($q);
            return $retorna;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
}




   function verificarExistencia_Clientes() {
        $cn = new connect_new();
        try {
            $q = 'SELECT ID,descripcion,usuario_id,fecha,operador_ID,cliente_ID,estado_id';
            $q.=' FROM operador_cliente ';
            $q.=' where empresa_ID='.$_SESSION['empresa_ID'].' and del=0';
            
            echo $q;
            
            $retorna = $cn->getGrid($q);
            $this->getMessage = 'El Operador tiene clientes asociados.';
            return $retorna;
        } catch (Exception $ex) {
            throw new Exception('Ocurrio un error en la consulta1');
        }
    }
    
        }
