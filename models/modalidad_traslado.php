<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of modalidad_traslado
 *
 * @author miwle_000
 */
class modalidad_traslado {
  private $ID;
  private $nombre;
  private $codigo;
  private $orden;
  private $usuario_id;
  private $getMessage;
  public function __set($var, $valor)
    {
      $temporal = $var;
      if (property_exists("modalidad_traslado",$temporal))
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
    if (property_exists("modalidad_traslado", $temporal))
    {
      return $this->$temporal;
    }
    return null;
  }
  function __construct()
  {
        $this->nombre="";
    $this->codigo="";
    $this->orden=0;
    $this->usuario_id=$_SESSION["usuario_ID"];

  }
  function __destruct()
  {
        $this->nombre;
    $this->codigo;
    $this->orden;
    $this->usuario_id;

  }
  static function getByID($ID)
    {
    $cn =new connect_new();
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_modalidad_traslado_getByID",
          array("iID"=>$ID));
      $omodalidad_traslado=null;
      foreach($dt as $item)
      {
        $omodalidad_traslado= new modalidad_traslado();
      $omodalidad_traslado->ID=$item["ID"];
      $omodalidad_traslado->nombre=$item["nombre"];
      $omodalidad_traslado->codigo=$item["codigo"];
      $omodalidad_traslado->orden=$item["orden"];
      $omodalidad_traslado->usuario_id=$item["usuario_id"];

      }
      return $omodalidad_traslado;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "modalidad_traslado.getByID", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  function insertar()
    {
    $cn =new connect_new();
    try
    {
      $ID=$cn->store_procedure_transa(
          "sp_modalidad_traslado_Insert",
            array(
    "iID"=>0,
    "inombre"=>$this->nombre,
    "icodigo"=>$this->codigo,
    "iorden"=>$this->orden,
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
      log_error(__FILE__, "modalidad_traslado.insertar", $ex->getMessage());
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
          "sp_modalidad_traslado_Update",
            array(
              "retornar"=>$retornar,
    "iID"=>$this->ID,
    "inombre"=>$this->nombre,
    "icodigo"=>$this->codigo,
    "iorden"=>$this->orden,

),0);
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "modalidad_traslado.actualizar", $ex->getMessage());
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
          "sp_modalidad_traslado_getCount",
            array(
              "filtro"=>$filtro));
      return $resultado;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "modalidad_traslado.getCount", $ex->getMessage());
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
          "sp_modalidad_traslado_getGrid",
            array(
              "filtro"=>$filtro,
              "inicio"=>$inicio,
              "fin"=>$fin,
              "orden"=>$orden));
      return $dt;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "modalidad_traslado.getGrid", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
}  

