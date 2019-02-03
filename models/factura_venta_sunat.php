<?php

class factura_venta_sunat {
  private $ID;
  private $factura_venta_ID;
  private $fecha_generacion;
  private $fecha_respuesta;
  private $nombre_archivo;
  private $xml_firmado;
  private $hash;
  private $representacion_impresa;
  private $estado_envio;
  private $codigo_estado;
  private $descripcion_estado;
  private $cdr_sunat;
  private $observacion;
  private $usuario_id;
  private $getMessage;
  public function __set($var, $valor)
    {
      $temporal = $var;
      if (property_exists("factura_venta_sunat",$temporal))
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
    if (property_exists("factura_venta_sunat", $temporal))
    {
      return $this->$temporal;
    }
    return null;
  }
  function __construct()
  {
        $this->factura_venta_ID="NULL";
    $this->fecha_generacion="";
    $this->fecha_respuesta="";
    $this->nombre_archivo="";
    $this->xml_firmado="";
    $this->hash="";
    $this->representacion_impresa="";
    $this->estado_envio=0;
    $this->codigo_estado="";
    $this->descripcion_estado="";
    $this->cdr_sunat="";
    $this->usuario_id=$_SESSION["usuario_ID"];

  }
  function __destruct()
  {
        $this->factura_venta_ID;
    $this->fecha_generacion;
    $this->fecha_respuesta;
    $this->nombre_archivo;
    $this->xml_firmado;
    $this->hash;
    $this->representacion_impresa;
    $this->estado_envio;
    $this->codigo_estado;
    $this->descripcion_estado;
    $this->cdr_sunat;
    $this->usuario_id;

  }
  static function getByID($ID)
    {
    $cn =new connect_new();
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_factura_venta_sunat_getByID",
          array("iID"=>$ID));
      $ofactura_venta_sunat=null;
      foreach($dt as $item)
      {
        $ofactura_venta_sunat= new factura_venta_sunat();
        $ofactura_venta_sunat->ID=$item["ID"];
        $ofactura_venta_sunat->factura_venta_ID=$item["factura_venta_ID"];
        $ofactura_venta_sunat->fecha_generacion=$item["fecha_generacion"];
        $ofactura_venta_sunat->fecha_respuesta=$item["fecha_respuesta"];
        $ofactura_venta_sunat->nombre_archivo=$item["nombre_archivo"];
        $ofactura_venta_sunat->xml_firmado=$item["xml_firmado"];
        $ofactura_venta_sunat->hash=$item["hash"];
        $ofactura_venta_sunat->representacion_impresa=$item["representacion_impresa"];
        $ofactura_venta_sunat->estado_envio=$item["estado_envio"];
        $ofactura_venta_sunat->codigo_estado=$item["codigo_estado"];
        $ofactura_venta_sunat->descripcion_estado=$item["descripcion_estado"];
        $ofactura_venta_sunat->cdr_sunat=$item["cdr_sunat"];
        $ofactura_venta_sunat->usuario_id=$item["usuario_id"];

      }
      return $ofactura_venta_sunat;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "factura_venta_sunat.getByID", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  function insertar()
    {
    $cn =new connect_new();
    try
    {
      $ID=$cn->store_procedure_transa(
          "sp_factura_venta_sunat_Insert",
            array(
            "iID"=>0,
            "ifactura_venta_ID"=>$this->factura_venta_ID,
            "ifecha_generacion"=>$this->fecha_generacion,
            "ifecha_respuesta"=>$this->fecha_respuesta,
            "inombre_archivo"=>$this->nombre_archivo,
            "ixml_firmado"=>$this->xml_firmado,
            "ihash"=>$this->hash,
            "irepresentacion_impresa"=>$this->representacion_impresa,
            "iestado_envio"=>$this->estado_envio,
            "icodigo_estado"=>$this->codigo_estado,
            "idescripcion_estado"=>$this->descripcion_estado,
            "icdr_sunat"=>$this->cdr_sunat,
            "observacion"=>$this->observacion,
            "iusuario_id"=>$this->usuario_id
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
      log_error(__FILE__, "factura_venta_sunat.insertar", $ex->getMessage());
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
          "sp_factura_venta_sunat_Update",
            array(
                "retornar"=>$retornar,
                "iID"=>$this->ID,
                "ifactura_venta_ID"=>$this->factura_venta_ID,
                "ifecha_generacion"=>$this->fecha_generacion,
                "ifecha_respuesta"=>$this->fecha_respuesta,
                "inombre_archivo"=>$this->nombre_archivo,
                "ixml_firmado"=>$this->xml_firmado,
                "ihash"=>$this->hash,
                "irepresentacion_impresa"=>$this->representacion_impresa,
                "iestado_envio"=>$this->estado_envio,
                "icodigo_estado"=>$this->codigo_estado,
                "idescripcion_estado"=>$this->descripcion_estado,
                "icdr_sunat"=>$this->cdr_sunat,

          ),0);
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "factura_venta_sunat.actualizar", $ex->getMessage());
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
          "sp_factura_venta_sunat_getCount",
            array(
              "filtro"=>$filtro));
      return $resultado;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "factura_venta_sunat.getCount", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  public function getGrid2($factura_venta_ID) {
        $cn = new connect_new();
        try {
            $q = 'SELECT * FROM factura_venta_sunat WHERE factura_venta_ID='.$factura_venta_ID.' ORDER BY ID DESC LIMIT 1 ';
            $dt = $cn->getGrid($q);
            return $dt;
        } catch (Exception $ex) {
            throw new Exception('Ocurrio un error en la consulta');
        }
    }
}  
