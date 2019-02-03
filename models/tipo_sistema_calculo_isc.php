<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tipo_sistema_calculo_isc
 *
 * @author miwle_000
 */
class tipo_sistema_calculo_isc {
  private $ID;
  private $nombre;
  private $descripcion;
  private $orden;
  private $codigo;
  private $usuario_id;
  private $getMessage;
  public function __set($var, $valor)
    {
      $temporal = $var;
      if (property_exists("tipo_sistema_calculo_isc",$temporal))
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
    if (property_exists("tipo_sistema_calculo_isc", $temporal))
    {
      return $this->$temporal;
    }
    return null;
  }
  function __construct()
  {
        $this->nombre="";
    $this->descripcion="";
    $this->orden=0;
    $this->codigo="";
    $this->usuario_id=$_SESSION["usuario_ID"];

  }
  function __destruct()
  {
        $this->nombre;
    $this->descripcion;
    $this->orden;
    $this->codigo;
    $this->usuario_id;

  }
  static function getByID($ID)
    {
    $cn =new connect_new();
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_tipo_sistema_calculo_isc_getByID",
          array("iID"=>$ID));
      $otipo_sistema_calculo_isc=null;
      foreach($dt as $item)
      {
        $otipo_sistema_calculo_isc= new tipo_sistema_calculo_isc();
      $otipo_sistema_calculo_isc->ID=$item["ID"];
      $otipo_sistema_calculo_isc->nombre=$item["nombre"];
      $otipo_sistema_calculo_isc->descripcion=$item["descripcion"];
      $otipo_sistema_calculo_isc->orden=$item["orden"];
      $otipo_sistema_calculo_isc->codigo=$item["codigo"];
      $otipo_sistema_calculo_isc->usuario_id=$item["usuario_id"];

      }
      return $otipo_sistema_calculo_isc;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "tipo_sistema_calculo_isc.getByID", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  function insertar()
    {
    $cn =new connect_new();
    try
    {
      $ID=$cn->store_procedure_transa(
          "sp_tipo_sistema_calculo_isc_Insert",
            array(
    "iID"=>0,
    "inombre"=>$this->nombre,
    "idescripcion"=>$this->descripcion,
    "iorden"=>$this->orden,
    "icodigo"=>$this->codigo,
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
      log_error(__FILE__, "tipo_sistema_calculo_isc.insertar", $ex->getMessage());
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
          "sp_tipo_sistema_calculo_isc_Update",
            array(
              "retornar"=>$retornar,
    "iID"=>$this->ID,
    "inombre"=>$this->nombre,
    "idescripcion"=>$this->descripcion,
    "iorden"=>$this->orden,
    "icodigo"=>$this->codigo,

),0);
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "tipo_sistema_calculo_isc.actualizar", $ex->getMessage());
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
          "sp_tipo_sistema_calculo_isc_Delete",
            array(
              "retornar"=>$retornar,
              "iID"=>$this->ID,
              "iusuario_mod_id"=>$this->usuario_mod_id ),0
            );
      if($retornar>0)$this->getMessage = "Se elimin? correctamente";
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "tipo_sistema_calculo_isc.eliminar", $ex->getMessage());
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
          "sp_tipo_sistema_calculo_isc_getCount",
            array(
              "filtro"=>$filtro));
      return $resultado;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "tipo_sistema_calculo_isc.getCount", $ex->getMessage());
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
          "sp_tipo_sistema_calculo_isc_getGrid",
            array(
              "filtro"=>$filtro,
              "inicio"=>$inicio,
              "fin"=>$fin,
              "orden"=>$orden));
      return $dt;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "tipo_sistema_calculo_isc.getGrid", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  static function getOpciones()
    {
    $cn =new connect_new();
    $retornar ="";
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_tipo_sistema_calculo_isc_getOpcion",
            array('valor'=>1));
      if(count($dt)>0){
        $retornar=$dt[0]['opciones'];
      }
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "tipo_sistema_calculo_isc.getGrid", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
}  

