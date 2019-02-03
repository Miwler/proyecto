<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of plantilla
 *
 * @author miwle_000
 */
class plantilla {
  private $ID;
  private $empresa_ID;
  private $documento;
  private $parte;
  private $estructura;
  private $usuario_id;
  private $usuario_mod_id;
  private $getMessage;
  public function __set($var, $valor)
    {
      $temporal = $var;
      if (property_exists("plantilla",$temporal))
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
    if (property_exists("plantilla", $temporal))
    {
      return $this->$temporal;
    }
    return null;
  }
  function __construct()
  {
        $this->empresa_ID=$_SESSION["empresa_ID"];
    $this->documento="";
    $this->parte="";
    $this->estructura="";
    $this->usuario_id=$_SESSION["usuario_ID"];
    $this->usuario_mod_id=$_SESSION["usuario_ID"];

  }
  function __destruct()
  {
        $this->empresa_ID;
    $this->documento;
    $this->parte;
    $this->estructura;
    $this->usuario_id;
    $this->usuario_mod_id;

  }
  static function getByID($ID)
    {
    $cn =new connect_new();
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_plantilla_getByID",
          array("iID"=>$ID));
      $oplantilla=null;
      foreach($dt as $item)
      {
        $oplantilla= new plantilla();
      $oplantilla->ID=$item["ID"];
      $oplantilla->empresa_ID=$item["empresa_ID"];
      $oplantilla->documento=$item["documento"];
      $oplantilla->parte=$item["parte"];
      $oplantilla->estructura=$item["estructura"];
      $oplantilla->usuario_id=$item["usuario_id"];
      $oplantilla->usuario_mod_id=$item["usuario_mod_id"];

      }
      return $oplantilla;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "plantilla.getByID", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  function insertar()
    {
    $cn =new connect_new();
    try
    {
      $ID=$cn->store_procedure_transa(
          "sp_plantilla_Insert",
            array(
    "iID"=>0,
    "iempresa_ID"=>$this->empresa_ID,
    "idocumento"=>$this->documento,
    "iparte"=>$this->parte,
    "iestructura"=>$this->estructura,
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
      log_error(__FILE__, "plantilla.insertar", $ex->getMessage());
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
          "sp_plantilla_Update",
            array(
              "retornar"=>$retornar,
    "iID"=>$this->ID,
    "iempresa_ID"=>$this->empresa_ID,
    "idocumento"=>$this->documento,
    "iparte"=>$this->parte,
    "iestructura"=>$this->estructura,
    "iusuario_mod_id"=>$this->usuario_mod_id
),0);
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "plantilla.actualizar", $ex->getMessage());
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
          "sp_plantilla_Delete",
            array(
              "retornar"=>$retornar,
              "iID"=>$this->ID,
              "iusuario_mod_id"=>$this->usuario_mod_id ),0
            );
      if($retornar>0)$this->getMessage = "Se elimin? correctamente";
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "plantilla.eliminar", $ex->getMessage());
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
          "sp_plantilla_getCount",
            array(
              "filtro"=>$filtro));
      return $resultado;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "plantilla.getCount", $ex->getMessage());
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
          "sp_plantilla_getGrid",
            array(
              "filtro"=>$filtro,
              "inicio"=>$inicio,
              "fin"=>$fin,
              "orden"=>$orden));
      return $dt;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "plantilla.getGrid", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
}  

