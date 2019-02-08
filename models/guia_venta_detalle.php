<?php

class guia_venta_detalle {

    private $ID;
  private $guia_venta_ID;
  private $salida_detalle_ID;
  private $descripcion;
  private $ver_descripcion;
  private $ver_componente;
  private $ver_adicional;
  private $ver_serie;
  private $usuario_id;
  private $usuario_mod_id;
  private $getMessage;

    public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
        if (property_exists('guia_venta_detalle', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('guia_venta_detalle', $temporal)) {
            return $this->$temporal;
        }

        // Retorna nulo si no existe
        return null;
    }
function __construct()
  {
        $this->descripcion="";
    $this->ver_descripcion=0;
    $this->ver_componente=0;
    $this->ver_adicional=0;
    $this->ver_serie=0;
    $this->usuario_id=$_SESSION["usuario_ID"];
    $this->usuario_mod_id=$_SESSION["usuario_ID"];

  }
  function __destruct()
  {
        $this->descripcion;
    $this->ver_descripcion;
    $this->ver_componente;
    $this->ver_adicional;
    $this->ver_serie;
    $this->usuario_id;
    $this->usuario_mod_id;

  }
    /*function insertar() {
        $cn = new connect_new();
        $retornar = -1;
        try {
            
            $q = 'select ifnull(max(ID),0)+1 from guia_venta_detalle';
            $ID=$cn->getData($q);
            $q = 'insert into guia_venta_detalle(ID,guia_venta_ID,salida_detalle_ID,usuario_id)';
            $q.=' values('.$ID.','.$this->guia_venta_ID.','.$this->salida_detalle_ID.','.$this->usuario_id.')' ;
            //echo $q;
            $retornar = $cn->transa($q);

            
            $this->ID = $ID;
            $this->message = 'Se registró correctamente';
            return $retornar;
        } catch (Exception $ex) {

            throw new Exception($q);
        }
    }

    function actualizar() {
        $cn = new connect();
        $retornar = -1;
        try {
            $q = 'UPDATE guia_venta_detalle set guia_venta_ID='.$this->guia_venta_ID.',salida_detalle_ID='.$this->salida_detalle_ID.',usuario_mod_id='.$this->usuario_mod_id;
            $q.=', fdm=now() where ID='.$this->ID;
            
            $retornar = $cn->transa($q);
            $this->message = 'Se actualizó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            
        }
    }*/
/*
    function eliminar() {
        $cn = new connect();
        $retornar = -1;
        try {

            $q = 'UPDATE guia_venta_detalle SET del=1,usuario_mod_id=' . $this->usuario_mod_id . ', fdm=Now()';
            $q.=' WHERE del=0 and ID=' . $this->ID;

            $retornar = $cn->transa($q);

            $this->message = 'Se eliminó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
*/
  function insertar()
    {
    $cn =new connect_new();
    try
    {
      $ID=$cn->store_procedure_transa(
          "sp_guia_venta_detalle_Insert",
            array(
    "iID"=>0,
    "iguia_venta_ID"=>$this->guia_venta_ID,
    "isalida_detalle_ID"=>$this->salida_detalle_ID,
    "idescripcion"=>$this->descripcion,
    "iver_descripcion"=>$this->ver_descripcion,
    "iver_componente"=>$this->ver_componente,
    "iver_adicional"=>$this->ver_adicional,
    "iver_serie"=>$this->ver_serie,
    "iusuario_id"=>$this->usuario_id,

),0);
      if($ID>0){
        $this->getMessage="El registro se guard? correctamente.";
        $this->ID=$ID;
        return $ID;
      } else {
          throw new Exception("No se registr?");
      }
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "guia_venta_detalle.insertar", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  function actualizar()
    {
    $cn =new connect_new();
    $retornar =0;
    try
    {
      $ID=$cn->store_procedure_transa(
          "sp_guia_venta_detalle_Update",
            array(
              "retornar"=>$retornar,
    "iID"=>$this->ID,
    "iguia_venta_ID"=>$this->guia_venta_ID,
    "isalida_detalle_ID"=>$this->salida_detalle_ID,
    "idescripcion"=>$this->descripcion,
    "iver_descripcion"=>$this->ver_descripcion,
    "iver_componente"=>$this->ver_componente,
    "iver_adicional"=>$this->ver_adicional,
    "iver_serie"=>$this->ver_serie,
    "iusuario_mod_id"=>$this->usuario_mod_id
),0);
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "guia_venta_detalle.actualizar", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  function eliminar()
    {
    $cn =new connect_new();
    $retornar =0;
    try
    {
      $retornar=$cn->store_procedure_transa(
          "sp_guia_venta_detalle_Delete",
            array(
              "retornar"=>$retornar,
              "iID"=>$this->ID,
              "iusuario_mod_id"=>$this->usuario_mod_id ),0
            );
      if($retornar>0)$this->getMessage = "Se elimin? correctamente";
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "guia_venta_detalle.eliminar", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
    static function getCount($filtro = '') {
        $cn = new connect();
        try {
            $q = 'select count(ID) ';
            $q.=' FROM guia_venta_detalle ';
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
/*
    static function getByID($ID) {
        $cn = new connect();
        try {
            $q = 'Select ID,guia_venta_ID,salida_detalle_ID,usuario_id,ifNull(usuario_mod_id,-1) as usuario_mod_id ';
            $q.=' from guia_venta_detalle ';
            $q.=' where del=0 and ID=' . $ID;

            $dt = $cn->getGrid($q);
            $oGuia_Venta_Detalle = null;

            foreach ($dt as $item) {
                $oGuia_Venta_Detalle = new Guia_Venta_Detalle();

                $oGuia_Venta_Detalle->ID= $item['ID'];
                $oGuia_Venta_Detalle->guia_venta_ID= $item['guia_venta_ID'];
                $oGuia_Venta_Detalle->salida_detalle_ID= $item['salida_detalle_ID'];
               
                $oGuia_Venta_Detalle->usuario_id= $item['usuario_id'];
                $oGuia_Venta_Detalle->usuario_mod_id= $item['usuario_mod_id'];

            }
            return $oGuia_Venta_Detalle;
        } catch (Exeption $ex) {
            throw new Exception($q);
        }
    }
*/
    static function getByID($ID)
    {
    $cn =new connect_new();
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_guia_venta_detalle_getByID",
          array("iID"=>$ID));
      $oguia_venta_detalle=null;
      foreach($dt as $item)
      {
        $oguia_venta_detalle= new guia_venta_detalle();
      $oguia_venta_detalle->ID=$item["ID"];
      $oguia_venta_detalle->guia_venta_ID=$item["guia_venta_ID"];
      $oguia_venta_detalle->salida_detalle_ID=$item["salida_detalle_ID"];
      $oguia_venta_detalle->descripcion=$item["descripcion"];
      $oguia_venta_detalle->ver_descripcion=$item["ver_descripcion"];
      $oguia_venta_detalle->ver_componente=$item["ver_componente"];
      $oguia_venta_detalle->ver_adicional=$item["ver_adicional"];
      $oguia_venta_detalle->ver_serie=$item["ver_serie"];
      $oguia_venta_detalle->usuario_id=$item["usuario_id"];
      $oguia_venta_detalle->usuario_mod_id=$item["usuario_mod_id"];

      }
      return $oguia_venta_detalle;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "guia_venta_detalle.getByID", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
    static function getGrid($filtro = '', $desde = -1, $hasta = -1, $order = 'ID asc') {
        $cn = new connect();
        try {
            $q = 'Select ID,guia_venta_ID,salida_detalle_ID,usuario_id,ifNull(usuario_mod_id,-1) as usuario_mod_id ';
            $q.=' from Guia_Venta_Detalle ';
            $q.=' where del=0 ';

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
    static function getGrid1($filtro='',$desde=-1,$hasta=-1,$order='ovd.ID asc')
    {
        $cn =new connect();
        try 
        {
        $q='select ovd.ID, ov.moneda_ID,pro.peso, um.nombre as unidad_medida,ovd.cantidad,ovd.precio_venta_unitario_soles,ovd.precio_venta_unitario_dolares,';
        $q.='ovd.vigv_soles,ovd.vigv_dolares,ovd.precio_venta_subtotal_soles,ovd.precio_venta_subtotal_dolares,ovd.precio_venta_soles';
        $q.=',ovd.precio_venta_dolares,pro.nombre as producto,ovd.descripcion';
        $q.=' from salida ov,salida_detalle ovd,guia_venta_detalle gvd, producto pro,unidad_medida um';
        $q.=' where gvd.del=0 and ov.del=0 and ovd.del=0 and  ov.ID=ovd.salida_ID and';
        $q.=' gvd.salida_detalle_ID =ovd.ID and ovd.producto_ID=pro.ID and pro.unidad_medida_ID=um.ID';

        if($filtro!=''){
                $q.=' and '.$filtro;
        }

        $q.=' Order By '.$order;

        if($desde!=-1&&$hasta!=-1){
                $q.=' Limit '.$desde.','.$hasta;
        }
        //echo $q;
        $dt=$cn->getGrid($q);									
        return $dt;												
        }catch(Exception $ex)
        {
            throw new Exception($q);
        }
    } 
static function getListaGuia_Venta($guia_venta_ID) {
        $cn = new connect_new();
        try {
            $dt=$cn->store_procedure_getGrid("sp_guia_venta_detalle_getLista",
            array(
                "iguia_venta_ID"=>$guia_venta_ID
            ));
            return $dt;
        } catch (Exception $ex) {
            log_error(__FILE__, "guia_venta_detalle.getListaGuia_Venta", $ex->getMessage());
            throw new Exception("Ocurrió un error en la conexión");
        }
    }
}
