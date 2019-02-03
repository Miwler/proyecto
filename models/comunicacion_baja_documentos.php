<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of comunicacion_baja
 *
 * @author miwle_000
 */
class comunicacion_baja_documentos {
  private $ID;
  private $comunicacion_baja_ID;
  private $tabla;
  private $documento_ID;
  private $Correlativo;
  private $MotivoBaja;
  private $Identificador;
  private $TipoDocumento;
  private $Serie;
  private $usuario_id;
  private $usuario_mod_id;
  private $getMessage;
  public function __set($var, $valor)
    {
      $temporal = $var;
      if (property_exists("comunicacion_baja_documentos",$temporal))
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
    if (property_exists("comunicacion_baja_documentos", $temporal))
    {
      return $this->$temporal;
    }
    return null;
  }
  function __construct()
  {
        $this->comunicacion_baja_ID=0;
    $this->tabla="";
    $this->documento_ID=0;
    $this->Correlativo="";
    $this->MotivoBaja="";
    $this->Identificador=0;
    $this->TipoDocumento="";
    $this->Serie="";
    $this->usuario_id=$_SESSION["usuario_ID"];
    $this->usuario_mod_id=$_SESSION["usuario_ID"];

  }
  function __destruct()
  {
        $this->comunicacion_baja_ID;
    $this->tabla;
    $this->documento_ID;
    $this->Correlativo;
    $this->MotivoBaja;
    $this->Identificador;
    $this->TipoDocumento;
    $this->Serie;
    $this->usuario_id;
    $this->usuario_mod_id;

  }
  static function getByID($ID)
    {
    $cn =new connect_new();
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_comunicacion_baja_documentos_getByID",
          array("iID"=>$ID));
      $ocomunicacion_baja_documentos=null;
      foreach($dt as $item)
      {
        $ocomunicacion_baja_documentos= new comunicacion_baja_documentos();
      $ocomunicacion_baja_documentos->ID=$item["ID"];
      $ocomunicacion_baja_documentos->comunicacion_baja_ID=$item["comunicacion_baja_ID"];
      $ocomunicacion_baja_documentos->tabla=$item["tabla"];
      $ocomunicacion_baja_documentos->documento_ID=$item["documento_ID"];
      $ocomunicacion_baja_documentos->Correlativo=$item["Correlativo"];
      $ocomunicacion_baja_documentos->MotivoBaja=$item["MotivoBaja"];
      $ocomunicacion_baja_documentos->Identificador=$item["Identificador"];
      $ocomunicacion_baja_documentos->TipoDocumento=$item["TipoDocumento"];
      $ocomunicacion_baja_documentos->Serie=$item["Serie"];
      $ocomunicacion_baja_documentos->usuario_id=$item["usuario_id"];
      $ocomunicacion_baja_documentos->usuario_mod_id=$item["usuario_mod_id"];

      }
      return $ocomunicacion_baja_documentos;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "comunicacion_baja_documentos.getByID", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  function insertar()
    {
    $cn =new connect_new();
    try
    {
      $ID=$cn->store_procedure_transa(
          "sp_comunicacion_baja_documentos_Insert",
            array(
    "iID"=>0,
    "icomunicacion_baja_ID"=>$this->comunicacion_baja_ID,
    "itabla"=>$this->tabla,
    "idocumento_ID"=>$this->documento_ID,
    "iCorrelativo"=>$this->Correlativo,
    "iMotivoBaja"=>$this->MotivoBaja,
    "iIdentificador"=>$this->Identificador,
    "iTipoDocumento"=>$this->TipoDocumento,
    "iSerie"=>$this->Serie,
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
      log_error(__FILE__, "comunicacion_baja_documentos.insertar", $ex->getMessage());
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
          "sp_comunicacion_baja_documentos_Update",
            array(
              "retornar"=>$retornar,
    "iID"=>$this->ID,
    "icomunicacion_baja_ID"=>$this->comunicacion_baja_ID,
    "itabla"=>$this->tabla,
    "idocumento_ID"=>$this->documento_ID,
    "iCorrelativo"=>$this->Correlativo,
    "iMotivoBaja"=>$this->MotivoBaja,
    "iIdentificador"=>$this->Identificador,
    "iTipoDocumento"=>$this->TipoDocumento,
    "iSerie"=>$this->Serie,
    "iusuario_mod_id"=>$this->usuario_mod_id
),0);
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "comunicacion_baja_documentos.actualizar", $ex->getMessage());
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
          "sp_comunicacion_baja_documentos_Delete",
            array(
              "retornar"=>$retornar,
              "iID"=>$this->ID,
              "iusuario_mod_id"=>$this->usuario_mod_id ),0
            );
      if($retornar>0)$this->getMessage = "Se elimin? correctamente";
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "comunicacion_baja_documentos.eliminar", $ex->getMessage());
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
          "sp_comunicacion_baja_documentos_getCount",
            array(
              "filtro"=>$filtro));
      return $resultado;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "comunicacion_baja_documentos.getCount", $ex->getMessage());
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
          "sp_comunicacion_baja_documentos_getGrid",
            array(
              "filtro"=>$filtro,
              "inicio"=>$inicio,
              "fin"=>$fin,
              "orden"=>$orden));
      return $dt;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "comunicacion_baja_documentos.getGrid", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
}  

