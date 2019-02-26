<?php
class tipo_comprobante_empresa {
  private $ID;
  private $tipo_comprobante_ID;
  private $empresa_ID;
  private $accion;
  private $imprime;
  private $usuario_id;
  private $usuario_mod_id;
  private $getMessage;
  public function __set($var, $valor)
    {
      $temporal = $var;
      if (property_exists("tipo_comprobante_empresa",$temporal))
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
    if (property_exists("tipo_comprobante_empresa", $temporal))
    {
      return $this->$temporal;
    }
    return null;
  }
  function __construct()
  {
        $this->accion="";
    $this->imprime=0;
    $this->usuario_id=$_SESSION["usuario_ID"];
    $this->usuario_mod_id=$_SESSION["usuario_ID"];

  }
  function __destruct()
  {
        $this->accion;
    $this->imprime;
    $this->usuario_id;
    $this->usuario_mod_id;

  }
  static function getByID($ID)
    {
    $cn =new connect_new();
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_tipo_comprobante_empresa_getByID",
          array("iID"=>$ID));
      $otipo_comprobante_empresa=null;
      foreach($dt as $item)
      {
        $otipo_comprobante_empresa= new tipo_comprobante_empresa();
      $otipo_comprobante_empresa->ID=$item["ID"];
      $otipo_comprobante_empresa->tipo_comprobante_ID=$item["tipo_comprobante_ID"];
      $otipo_comprobante_empresa->empresa_ID=$item["empresa_ID"];
      $otipo_comprobante_empresa->accion=$item["accion"];
      $otipo_comprobante_empresa->imprime=$item["imprime"];
      $otipo_comprobante_empresa->usuario_id=$item["usuario_id"];
      $otipo_comprobante_empresa->usuario_mod_id=$item["usuario_mod_id"];

      }
      return $otipo_comprobante_empresa;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "tipo_comprobante_empresa.getByID", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  function insertar()
    {
    $cn =new connect_new();
    try
    {
      $ID=$cn->store_procedure_transa(
          "sp_tipo_comprobante_empresa_Insert",
            array(
    "iID"=>0,
    "itipo_comprobante_ID"=>$this->tipo_comprobante_ID,
    "iempresa_ID"=>$this->empresa_ID,
    "iaccion"=>$this->accion,
    "iimprime"=>$this->imprime,
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
      log_error(__FILE__, "tipo_comprobante_empresa.insertar", $ex->getMessage());
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
          "sp_tipo_comprobante_empresa_Update",
            array(
              "retornar"=>$retornar,
    "iID"=>$this->ID,
    "itipo_comprobante_ID"=>$this->tipo_comprobante_ID,
    "iempresa_ID"=>$this->empresa_ID,
    "iaccion"=>$this->accion,
    "iimprime"=>$this->imprime,
    "iusuario_mod_id"=>$this->usuario_mod_id
),0);
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "tipo_comprobante_empresa.actualizar", $ex->getMessage());
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
          "sp_tipo_comprobante_empresa_Delete",
            array(
              "retornar"=>$retornar,
              "iID"=>$this->ID,
              "iusuario_mod_id"=>$this->usuario_mod_id ),0
            );
      if($retornar>0)$this->getMessage = "Se elimin? correctamente";
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "tipo_comprobante_empresa.eliminar", $ex->getMessage());
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
          "sp_tipo_comprobante_empresa_getCount",
            array(
              "filtro"=>$filtro));
      return $resultado;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "tipo_comprobante_empresa.getCount", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  static function getGrid($filtro="",$inicio=-1,$fin=-1,$orden="ID asc")
    {
    $cn =new connect_new();
    $retornar =0;
    try
    {
        $filtro="empresa_ID=".$_SESSION['empresa_ID'].(($filtro<>"")?" and ":"").$filtro;
        $dt=$cn->store_procedure_getGrid(
          "sp_tipo_comprobante_empresa_getGrid",
            array(
              "filtro"=>$filtro,
              "inicio"=>$inicio,
              "fin"=>$fin,
              "orden"=>$orden));
      return $dt;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "tipo_comprobante_empresa.getGrid", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
}  


?>