<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of motivo_clase
 *
 * @author miwle_000
 */
class motivo_traslado {
  private $ID;
  private $nombre;
  private $codigo;
  private $orden;
  private $usuario_id;
  private $getMessage;
  public function __set($var, $valor)
    {
      $temporal = $var;
      if (property_exists("motivo_traslado",$temporal))
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
    if (property_exists("motivo_traslado", $temporal))
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
          "sp_motivo_traslado_getByID",
          array("iID"=>$ID));
      $omotivo_traslado=null;
      foreach($dt as $item)
      {
        $omotivo_traslado= new motivo_traslado();
      $omotivo_traslado->ID=$item["ID"];
      $omotivo_traslado->nombre=$item["nombre"];
      $omotivo_traslado->codigo=$item["codigo"];
      $omotivo_traslado->orden=$item["orden"];
      $omotivo_traslado->usuario_id=$item["usuario_id"];

      }
      return $omotivo_traslado;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "motivo_traslado.getByID", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  function insertar()
    {
    $cn =new connect_new();
    try
    {
      $ID=$cn->store_procedure_transa(
          "sp_motivo_traslado_Insert",
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
      log_error(__FILE__, "motivo_traslado.insertar", $ex->getMessage());
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
          "sp_motivo_traslado_Update",
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
      log_error(__FILE__, "motivo_traslado.actualizar", $ex->getMessage());
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
          "sp_motivo_traslado_getCount",
            array(
              "filtro"=>$filtro));
      return $resultado;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "motivo_traslado.getCount", $ex->getMessage());
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
          "sp_motivo_traslado_getGrid",
            array(
              "filtro"=>$filtro,
              "inicio"=>$inicio,
              "fin"=>$fin,
              "orden"=>$orden));
     
      return $dt;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "motivo_traslado.getGrid", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
}  
