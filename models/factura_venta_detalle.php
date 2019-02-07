<?php

class factura_venta_detalle {
  private $ID;
  private $factura_venta_ID;
  private $salida_detalle_ID;
  private $impuestos_tipo_ID;
  private $descripcion;
  private $ver_descripcion;
  private $ver_componente;
  private $ver_adicional;
  private $ver_serie;
  private $usuario_id;
  private $usuario_mod_id;
  private $getMessage;
  private $salida_ID;
  private $incluir_obsequios;
  public function __set($var, $valor)
    {
      $temporal = $var;
      if (property_exists("factura_venta_detalle",$temporal))
      {
        $this->$temporal = $valor;
      }
      else
      {
        echo $var . " No existe.";
      }
    }
  public function __get($var)
  {
    $temporal = $var;
    if (property_exists("factura_venta_detalle", $temporal))
    {
      return $this->$temporal;
    }
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
  static function getByID($ID)
    {
    $cn =new connect_new();
    try
    {
        $dt=$cn->store_procedure_getGrid(
          "sp_factura_venta_detalle_getByID",
            array("iID"=>$ID));
        $ofactura_venta_detalle=null;
        foreach($dt as $item)
        {
            $ofactura_venta_detalle= new factura_venta_detalle();
            $ofactura_venta_detalle->ID=$item["ID"];
            $ofactura_venta_detalle->factura_venta_ID=$item["factura_venta_ID"];
            $ofactura_venta_detalle->salida_detalle_ID=$item["salida_detalle_ID"];
            $ofactura_venta_detalle->impuestos_tipo_ID=$item["impuestos_tipo_ID"];
            $ofactura_venta_detalle->descripcion=$item["descripcion"];
            $ofactura_venta_detalle->ver_descripcion=$item["ver_descripcion"];
            $ofactura_venta_detalle->ver_componente=$item["ver_componente"];
            $ofactura_venta_detalle->ver_adicional=$item["ver_adicional"];
            $ofactura_venta_detalle->ver_serie=$item["ver_serie"];
            $ofactura_venta_detalle->usuario_id=$item["usuario_id"];
            $ofactura_venta_detalle->usuario_mod_id=$item["usuario_mod_id"];

        }
        return $ofactura_venta_detalle;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "factura_venta_detalle.getByID", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  function insertar()
    {
    $cn =new connect_new();
    try
    {
      $ID=$cn->store_procedure_transa(
          "sp_factura_venta_detalle_Insert",
            array(
                "iID"=>0,
                "ifactura_venta_ID"=>$this->factura_venta_ID,
                "isalida_detalle_ID"=>$this->salida_detalle_ID,
                "iimpuestos_tipo_ID"=>$this->impuestos_tipo_ID,
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
      log_error(__FILE__, "factura_venta_detalle.insertar", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  function insertar_todos()
    {
    $cn =new connect_new();
    $retornar =0;
    try
    {
        
      $ID=$cn->store_procedure_transa(
          "sp_factura_venta_detalle_Insert_Total",
            array(
                "retornar"=>$retornar,
                "ifactura_venta_ID"=>$this->factura_venta_ID,
                "isalida_ID"=>$this->salida_ID,
                "iver_descripcion"=>$this->ver_descripcion,
                "iver_componente"=>$this->ver_componente,
                "iver_adicional"=>$this->ver_adicional,
                "iver_serie"=>$this->ver_serie,
                "iincluir_obsequios"=>$this->incluir_obsequios,
                "iusuario_id"=>$this->usuario_id,

            ),0);
     return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "factura_venta_detalle.insertar", $ex->getMessage());
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
          "sp_factura_venta_detalle_Update",
            array(
              "retornar"=>$retornar,
                "iID"=>$this->ID,
                "ifactura_venta_ID"=>$this->factura_venta_ID,
                "isalida_detalle_ID"=>$this->salida_detalle_ID,
                "iimpuestos_tipo_ID"=>$this->impuestos_tipo_ID,
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
      log_error(__FILE__, "factura_venta_detalle.actualizar", $ex->getMessage());
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
          "sp_factura_venta_detalle_Delete",
            array(
              "retornar"=>$retornar,
              "iID"=>$this->ID,
              "iusuario_mod_id"=>$this->usuario_mod_id ),0
            );
      if($retornar>0)$this->getMessage = "Se elimin? correctamente";
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "factura_venta_detalle.eliminar", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  static function getCount($filtro="")
    {
    $cn =new connect_new();
    $retornar =0;
    try
    {
      $resultado=$cn->store_procedure_getData(
          "sp_factura_venta_detalle_getCount",
            array(
              "filtro"=>$filtro));
      return $resultado;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "factura_venta_detalle.getCount", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  
   static function getGrid1($filtro='',$desde=-1,$hasta=-1,$order='ovd.ID asc')
    {
        $cn =new connect_new();
        try
        {
        $q='select ovd.ID, ov.moneda_ID,ovd.cantidad,ovd.precio_venta_unitario_soles,ovd.precio_venta_unitario_dolares,';
        $q.='ovd.vigv_soles,ovd.vigv_dolares,ovd.precio_venta_subtotal_soles,precio_venta_subtotal_dolares,ovd.precio_venta_soles';
        $q.=',ovd.precio_venta_dolares,pro.nombre as producto,ovd.descripcion,fvd.ID as factura_venta_detalle_ID';
        $q.=' from salida ov,salida_detalle ovd,factura_venta_detalle fvd, producto pro';
        $q.=' where fvd.del=0 and ov.del=0 and ovd.del=0 and  ov.ID=ovd.salida_ID and';
        $q.=' fvd.salida_detalle_ID =ovd.ID and ovd.producto_ID=pro.ID';

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
    static function getGrid($filtro="",$inicio=-1,$fin=-1,$orden="ID asc")
    {
    $cn =new connect_new();
    $retornar =0;
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_factura_venta_detalle_getGrid",
            array(
              "filtro"=>$filtro,
              "inicio"=>$inicio,
              "fin"=>$fin,
              "orden"=>$orden));
      return $dt;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "factura_venta_detalle.getGrid", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
}  

?>
