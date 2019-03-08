<?php

class orden_ingreso {

    private $ID;
    private $empresa_ID;
    private $numero_orden;
    private $fecha;
    private $proveedor_ID;
    private $moneda_ID;
    private $estado_ID;
    private $con_igv;
    private $tipo_cambio;
    private $vigv;
    private $subtotal;
    private $igv;
    private $total;
    private $comentario;
    private $tipo_orden_ID;
    private $usuario_id;
    private $usuario_mod_id;
    Private $getMessage;
    private $dtMoneda;
    private $dtEstado;
    private $oProveedor;
    private $dtProveedor;
    private $oEstado;
    public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
        if (property_exists('orden_ingreso', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('orden_ingreso', $temporal)) {
            return $this->$temporal;
        }

        // Retorna nulo si no existe
        return null;
    }
    function __construct()
    {
        $this->empresa_ID=$_SESSION["empresa_ID"];
        $this->numero_orden=0;
        $this->fecha=NULL;
        $this->proveedor_ID=0;
        $this->moneda_ID=0;
        $this->estado_ID=0;
        $this->con_igv=0;
        $this->tipo_cambio=0;
        $this->vigv=0;
        $this->subtotal=0;
        $this->igv=0;
        $this->total=0;
        $this->comentario="";
        $this->usuario_id=$_SESSION["usuario_ID"];
        $this->usuario_mod_id=$_SESSION["usuario_ID"];

    }
  function __destruct()
    {
        $this->empresa_ID;
        $this->numero_orden;
        $this->fecha;
        $this->proveedor_ID;
        $this->moneda_ID;
        $this->estado_ID;
        $this->con_igv;
        $this->tipo_cambio;
        $this->vigv;
        $this->subtotal;
        $this->igv;
        $this->total;
        $this->comentario;
        $this->usuario_id;
        $this->usuario_mod_id;

    }
    
  function insertar1()
    {
    $cn =new connect_new();
    try
    {
      $ID=$cn->store_procedure_transa(
          "sp_orden_ingreso_Insert2",
            array(
                "iID"=>0,
                "iempresa_ID"=>$this->empresa_ID,
                "itipo_orden_ID"=>$this->tipo_orden_ID,
                "inumero_orden"=>$this->numero_orden,
                "ifecha"=>FormatTextToDate($this->fecha, 'Y-m-d'),
                "iproveedor_ID"=>$this->proveedor_ID,
                "imoneda_ID"=>$this->moneda_ID,
                "iestado_ID"=>$this->estado_ID,
                "icon_igv"=>$this->con_igv,
                "itipo_cambio"=>$this->tipo_cambio,
                "ivigv"=>$this->vigv,
                "isubtotal"=>$this->subtotal,
                "iigv"=>$this->igv,
                "itotal"=>$this->total,
                "icomentario"=>$this->comentario,
                "iusuario_id"=>$this->usuario_id,

            ),0);
      if($ID>0){
        $this->getMessage="El registro se guardó correctamente.";
        $this->ID=$ID;
        return $ID;
      } else {
          throw new Exception("No se registró");
      }
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "orden_ingreso.insertar", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
    function insertar() {
        
        $retornar = -1;
        try {
            $fecha_save = 'NULL';
            if ($this->fecha != null) {
                $fecha_save = '"' . FormatTextToDate($this->fecha, 'Y-m-d') . '"';
            }
            $q = 'select ifnull(max(ID),0)+1 as ID from orden_ingreso;';
             $cn = new connect_new();
            $ID = $cn->getData($q);
            $q = 'select ifnull(max(numero_orden),0)+1 as ID from orden_ingreso where  tipo_orden_ID='.$this->tipo_orden_ID.' and empresa_ID='.$_SESSION['empresa_ID'].';';
            $cn = new connect_new();
            $numero_orden=$cn->getData($q);
            $q = 'INSERT INTO orden_ingreso(ID,empresa_ID,tipo_orden_ID,numero_orden,fecha,proveedor_ID,moneda_ID,estado_ID,tipo_cambio,vigv,subtotal,igv,total,comentario,usuario_id)';
            $q.='values (' . $ID .','.$_SESSION["empresa_ID"].','.$this->tipo_orden_ID.',' . $numero_orden . ',' . $fecha_save . ',' . $this->proveedor_ID . ',' . $this->moneda_ID . ',' . $this->estado_ID . ',"' . number_format($this->tipo_cambio, 2, '.', '') . '","' . number_format($this->vigv, 2, '.', '') . '","' . number_format($this->subtotal, 2, '.', '') . '",' . number_format($this->igv, 2, '.', '') . ',' . number_format($this->total, 2, '.', '') .',"'.$this->comentario.'",' . $this->usuario_id . ')';
            $cn = new connect_new();
			$retornar = $cn->transa($q);
            //echo $q;
            $this->ID = $ID;
            $this->numero_orden=$numero_orden;
            $this->getMessage = 'Se guardó correctamente.';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }

    function actualizar(){
            $cn =new connect_new();
            $retornar=-1;
            try{
                    $fecha_emision_save='NULL';
                    if($this->fecha!=null){
                            $fecha_emision_save='"'.FormatTextToDate($this->fecha,'Y-m-d').'"';
                    }

                    $q="UPDATE orden_ingreso SET tipo_orden_ID=".$this->tipo_orden_ID.", numero_orden='".$this->numero_orden."',fecha=".$fecha_emision_save.", proveedor_ID=".$this->proveedor_ID.",moneda_ID=".$this->moneda_ID.",estado_ID=".$this->estado_ID.",tipo_cambio='".round($this->tipo_cambio,2)."',vigv='".round($this->vigv,2)."',subtotal='".round($this->subtotal,2)."',igv='".round($this->igv,2)."',";
                    $q.="total='".round($this->total,2)."',comentario='".$this->comentario."',usuario_mod_id=".$this->usuario_mod_id.", fdm=Now()";
                    $q.=" WHERE ID=".$this->ID;
                    //echo $q;
                    $retornar=$cn->transa($q);

                    $this->getMessage='Se actualizó correctamente';
                    return $retornar;
            }
            catch(Exception $ex){
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
          "sp_orden_ingreso_Update",
            array(
              "retornar"=>$retornar,
                "iID"=>$this->ID,
                "iempresa_ID"=>$this->empresa_ID,
                "itipo_orden_ID"=>$this->tipo_orden_ID,
                "inumero_orden"=>$this->numero_orden,
                "ifecha"=> FormatTextToDate($this->fecha, 'Y-m-d'),
                "iproveedor_ID"=>$this->proveedor_ID,
                "imoneda_ID"=>$this->moneda_ID,
                "iestado_ID"=>$this->estado_ID,
                "icon_igv"=>$this->con_igv,
                "itipo_cambio"=>$this->tipo_cambio,
                "ivigv"=>$this->vigv,
                "isubtotal"=>$this->subtotal,
                "iigv"=>$this->igv,
                "itotal"=>$this->total,
                "icomentario"=>$this->comentario,
                "iusuario_mod_id"=>$this->usuario_mod_id
            ),0);
      if($retornar>0){
          $this->getMessage="Se actualizó correctamente";
      }
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "orden_ingreso.actualizar", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
    function actualizar2() {
        $cn = new connect_new();
        $retornar = -1;
        try {

            $q = "UPDATE orden_ingreso SET subtotal='" . number_format($this->subtotal, 2, '.', '') . "',igv='" . number_format($this->igv, 2, '.', '') . "',total='" . number_format($this->total, 2, '.', '') . "',usuario_mod_id=" . $this->usuario_mod_id . ", fdm=Now()";
            $q.=" WHERE ID=" . $this->ID;

            $retornar = $cn->transa($q);

            $this->getMessage = 'Se guardó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception('Ocurrio un error en la consulta');
        }
    }

    function eliminar() {
        $cn = new connect_new();
        $retornar = -1;
        try {

            $q = 'UPDATE orden_ingreso SET del=1,usuario_mod_id=' . $this->usuario_mod_id . ', fdm=Now()';
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
            $q = 'SELECT  count(oc.ID)';
            $q.=' FROM orden_ingreso oc,proveedor prv,estado es,moneda mo ';
            $q.=' where oc.empresa_ID='.$_SESSION["empresa_ID"].' and oc.del=0 and oc.proveedor_ID=prv.ID and oc.estado_ID=es.ID and oc.moneda_ID=mo.ID';
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
            $q = 'Select ID,tipo_orden_ID,numero_orden,DATE_FORMAT(fecha,"%d/%m/%Y") as fecha,proveedor_ID,moneda_ID,estado_ID,con_igv,tipo_cambio,vigv,subtotal,igv,total,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id, comentario';
            $q.=' from orden_ingreso ';
            $q.=' where  del=0 and ID=' . $ID;
            //echo $q;
            $dt = $cn->getGrid($q);
            $oorden_ingreso = null;

            foreach ($dt as $item) {
                $oorden_ingreso = new orden_ingreso();

                $oorden_ingreso->ID = $item['ID'];
                $oorden_ingreso->tipo_orden_ID = $item['tipo_orden_ID'];
                $oorden_ingreso->numero_orden = $item['numero_orden'];
                $oorden_ingreso->fecha = $item['fecha'];
                $oorden_ingreso->proveedor_ID = $item['proveedor_ID'];
                $oorden_ingreso->moneda_ID = $item['moneda_ID'];
                $oorden_ingreso->estado_ID = $item['estado_ID'];
                $oorden_ingreso->con_igv = $item['con_igv'];
                $oorden_ingreso->tipo_cambio = $item['tipo_cambio'];
                $oorden_ingreso->vigv = $item['vigv'];
                $oorden_ingreso->subtotal = $item['subtotal'];
                $oorden_ingreso->igv = $item['igv'];
                $oorden_ingreso->total = $item['total'];
                $oorden_ingreso->comentario = $item['comentario'];
                $oorden_ingreso->usuario_id = $item['usuario_id'];
                $oorden_ingreso->usuario_mod_id = $item['usuario_mod_id'];
            }
            return $oorden_ingreso;
        } catch (Exeption $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }

    static function getGrid($filtro = '', $desde = -1, $hasta = -1, $order = 'oc.ID asc') {
        $cn = new connect_new();
        try {
            $q = 'SELECT oc.ID, oc.numero_orden,  oc.fecha, prv.razon_social as proveedor, mo.descripcion as moneda,';
            $q.= 'es.nombre as estado, oc.con_igv, oc.tipo_cambio, oc.vigv, oc.subtotal, oc.igv, oc.total, oc.usuario_id';
            $q.= ', oc.usuario_mod_id,oc.estado_ID';
            $q.=',mo.simbolo';
            $q.=' FROM orden_ingreso oc, proveedor prv, estado es, moneda mo ';
            $q.=' where oc.empresa_ID='.$_SESSION["empresa_ID"].' and  oc.del=0 and oc.proveedor_ID=prv.ID and oc.estado_ID=es.ID and oc.moneda_ID=mo.ID';


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
            throw new Exception($q);
        }
    }
    /*static function getGrid1($filtro = '', $inicio = -1, $fin = -1, $orden = 'oc.ID asc') {
        $cn = new connect_new();
        try {
            $q = 'call getTabla_Orden_Compra("'.$filtro.'",'.$inicio.','.$fin.',"'.$orden.'");';
            
            //echo $q;
            $dt = $cn->getGrid($q);
            return $dt;
        } catch (Exception $ex) {
            throw new Exception("Ocurrió un error en el la conexión");
            log_error(__FILE__, "orden_ingreso.getGrid1", $ex->getMessage());
        }
    }*/
    static function getGrid1($filtro="",$inicio=-1,$fin=-1,$orden="oc.ID asc")
    {
        $cn =new connect_new();
        $retornar =0;
        try
        {
            $dt=$cn->store_procedure_getGrid(
                "getTabla_Orden_Compra",
                array(
                  "filtro"=>$filtro,
                  "inicio"=>$inicio,
                  "fin"=>$fin,
                  "orden"=>$orden));
          return $dt;
        }catch(Exeption $ex)
        {
          log_error(__FILE__, "orden_ingreso.getGrid", $ex->getMessage());
          throw new Exception($ex->getMessage());
        }
      }
    function verificarDuplicado() {
        $cn = new connect_new();
        $retornar = -1;
        try {
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception("Ocurrió un error en la consulta");
        }
    }

}

?>