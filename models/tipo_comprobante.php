<?php
class tipo_comprobante {
  private $ID;
  private $codigo;
  private $nombre;
  private $abreviatura;
  private $usuario_id;
  private $usuario_mod_id;
  private $getMessage;
  public function __set($var, $valor)
    {
        $temporal = $var;
        if (property_exists("tipo_comprobante",$temporal))
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
    if (property_exists("tipo_comprobante", $temporal))
    {
      return $this->$temporal;
    }
    return null;
  }
  function __construct()
  {
        $this->codigo="";
    $this->nombre="";
    $this->abreviatura="";
    $this->usuario_id=$_SESSION["usuario_ID"];
    $this->usuario_mod_id=$_SESSION["usuario_ID"];

  }
  function __destruct()
  {
        $this->codigo;
    $this->nombre;
    $this->abreviatura;
    $this->usuario_id;
    $this->usuario_mod_id;

  }
  static function getByID($ID)
    {
    $cn =new connect_new();
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_tipo_comprobante_getByID",
          array("iID"=>$ID));
      $otipo_comprobante=null;
      foreach($dt as $item)
      {
        $otipo_comprobante= new tipo_comprobante();
      $otipo_comprobante->ID=$item["ID"];
      $otipo_comprobante->codigo=$item["codigo"];
      $otipo_comprobante->nombre=$item["nombre"];
      $otipo_comprobante->abreviatura=$item["abreviatura"];
      $otipo_comprobante->usuario_id=$item["usuario_id"];
      $otipo_comprobante->usuario_mod_id=$item["usuario_mod_id"];

      }
      return $otipo_comprobante;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "tipo_comprobante.getByID", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  function insertar()
    {
    $cn =new connect_new();
    try
    {
        $ID=$cn->store_procedure_transa(
            "sp_tipo_comprobante_Insert",
            array(
                "iID"=>0,
                "icodigo"=>$this->codigo,
                "inombre"=>$this->nombre,
                "iabreviatura"=>$this->abreviatura,
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
      log_error(__FILE__, "tipo_comprobante.insertar", $ex->getMessage());
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
          "sp_tipo_comprobante_Update",
            array(
              "retornar"=>$retornar,
            "iID"=>$this->ID,
            "icodigo"=>$this->codigo,
            "inombre"=>$this->nombre,
            "iabreviatura"=>$this->abreviatura,
            "iusuario_mod_id"=>$this->usuario_mod_id
        ),0);
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "tipo_comprobante.actualizar", $ex->getMessage());
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
          "sp_tipo_comprobante_getCount",
            array(
              "filtro"=>$filtro));
      return $resultado;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "tipo_comprobante.getCount", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
   static function getComprobantes($electronico,$accion,$correlativos_ID,$itipo_comprobante_ID,$opcion)
    {
    $cn =new connect_new();
    $retornar="";
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_tipo_comprobante_getTipos",
            array(
                "iempresa_ID"=>$_GET['empresa_ID'],
                "ielectronico"=>$electronico,
                "iaccion"=>$accion,
                "correlativos_ID"=>$correlativos_ID,
                "itipo_comprobante_ID"=>$itipo_comprobante_ID,
                "opcion"=>$opcion
                ));
     $retornar=$dt[0]["opciones"];
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "tipo_comprobante.getCount", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
static function getGrid($filtro="",$inicio=-1,$fin=-1,$orden="ID asc")
    {
    $cn =new connect_new();
    $retornar =0;
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_tipo_comprobante_getGrid",
            array(
              "filtro"=>$filtro,
              "inicio"=>$inicio,
              "fin"=>$fin,
              "orden"=>$orden));
      return $dt;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "tipo_comprobante.getGrid", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
}  


?>