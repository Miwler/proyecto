<?php

class imagen_documentos {
  private $ID;
  private $nombre;
  private $documento;
  private $ubicacion;
  private $orden;
  private $empresa_ID;
  private $usuario_id;
  private $usuario_mod_id;
  private $getMessage;
  public function __set($var, $valor)
    {
      $temporal = $var;
      if (property_exists("imagen_documentos",$temporal))
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
    if (property_exists("imagen_documentos", $temporal))
    {
      return $this->$temporal;
    }
    return null;
  }
  function __construct()
  {
        $this->nombre="";
    $this->documento="";
    $this->ubicacion="";
    $this->orden=0;
    $this->usuario_id=$_SESSION["usuario_ID"];
    $this->usuario_mod_id=$_SESSION["usuario_ID"];

  }
  function __destruct()
  {
        $this->nombre;
    $this->documento;
    $this->ubicacion;
    $this->orden;
    $this->usuario_id;
    $this->usuario_mod_id;

  }
  static function getByID($ID)
    {
    $cn =new connect_new();
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_imagen_documentos_getByID",
          array("iID"=>$ID));
      $oimagen_documentos=null;
      foreach($dt as $item)
      {
        $oimagen_documentos= new imagen_documentos();
      $oimagen_documentos->ID=$item["ID"];
      $oimagen_documentos->nombre=$item["nombre"];
      $oimagen_documentos->documento=$item["documento"];
      $oimagen_documentos->ubicacion=$item["ubicacion"];
      $oimagen_documentos->orden=$item["orden"];
      $oimagen_documentos->usuario_id=$item["usuario_id"];
      $oimagen_documentos->usuario_mod_id=$item["usuario_mod_id"];

      }
      return $oimagen_documentos;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "imagen_documentos.getByID", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  function registrar()
    {
    $cn =new connect_new();
    try
    {
      $ID=$cn->store_procedure_transa(
          "sp_imagen_documentos_Insert",
            array(
            "iID"=>0,
            "inombre"=>$this->nombre,
            "idocumento"=>$this->documento,
            "iubicacion"=>$this->ubicacion,
            "iorden"=>$this->orden,
            "iempresa_ID"=>$this->empresa_ID,
            "iusuario_id"=>$this->usuario_id

        ),0);
      if($ID>0){
        $this->getMessage="El registro se guardó correctamente.";
        $this->ID=$ID;
        return $ID;
      } else {
          throw new Exception("No se registr?");
      }
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "imagen_documentos.insertar", $ex->getMessage());
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
          "sp_imagen_documentos_Update",
            array(
              "retornar"=>$retornar,
    "iID"=>$this->ID,
    "inombre"=>$this->nombre,
    "idocumento"=>$this->documento,
    "iubicacion"=>$this->ubicacion,
    "iorden"=>$this->orden,
    "iusuario_mod_id"=>$this->usuario_mod_id
),0);
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "imagen_documentos.actualizar", $ex->getMessage());
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
          "sp_imagen_documentos_Delete",
            array(
              "retornar"=>$retornar,
              "iID"=>$this->ID,
              "iusuario_mod_id"=>$this->usuario_mod_id ),0
            );
      if($retornar>0)$this->getMessage = "Se elimin? correctamente";
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "imagen_documentos.eliminar", $ex->getMessage());
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
          "sp_imagen_documentos_getCount",
            array(
              "filtro"=>$filtro));
      return $resultado;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "imagen_documentos.getCount", $ex->getMessage());
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
          "sp_imagen_documentos_getGrid",
            array(
              "filtro"=>$filtro,
              "inicio"=>$inicio,
              "fin"=>$fin,
              "orden"=>$orden));
      return $dt;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "imagen_documentos.getGrid", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  static function getImagen($documento,$ubicacion,$orden,$empresa_ID)
    {
    $cn =new connect_new();
    $retornar ="";
    try
    {
        
      $dt=$cn->store_procedure_getGrid(
          "sp_imagen_documentos_getImg",
            array(
              "idocumento"=>$documento,
                "iubicacion"=>$ubicacion,
                "iorden"=>$orden,
                 "iempresa_ID"=>$empresa_ID
                ));
      if(count($dt)>0){
          $retornar=$dt[0]['ID'].".JPG";
      }
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "imagen_documentos.getCount", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
}  
