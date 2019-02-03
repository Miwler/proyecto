<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of correlativos_bajas
 *
 * @author miwle_000
 */
class correlativos_bajas {
  private $ID;
  private $numero;
  private $serie;
  private $tabla;
  private $motivo;
  private $usuario_id;
  private $getMessage;
  public function __set($var, $valor)
    {
      $temporal = $var;
      if (property_exists("correlativos_bajas",$temporal))
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
    if (property_exists("correlativos_bajas", $temporal))
    {
      return $this->$temporal;
    }
    return null;
  }
  function __construct()
  {
        $this->numero=0;
    $this->serie="";
    $this->tabla="";
    $this->motivo="";
    $this->usuario_id=$_SESSION["usuario_ID"];

  }
  function __destruct()
  {
        $this->numero;
    $this->serie;
    $this->tabla;
    $this->motivo;
    $this->usuario_id;

  }
  static function getByID($ID)
    {
    $cn =new connect_new();
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_correlativos_bajas_getByID",
          array("iID"=>$ID));
      $ocorrelativos_bajas=null;
      foreach($dt as $item)
      {
        $ocorrelativos_bajas= new correlativos_bajas();
      $ocorrelativos_bajas->ID=$item["ID"];
      $ocorrelativos_bajas->numero=$item["numero"];
      $ocorrelativos_bajas->serie=$item["serie"];
      $ocorrelativos_bajas->tabla=$item["tabla"];
      $ocorrelativos_bajas->motivo=$item["motivo"];
      $ocorrelativos_bajas->usuario_id=$item["usuario_id"];

      }
      return $ocorrelativos_bajas;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "correlativos_bajas.getByID", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  function insertar()
    {
    $cn =new connect_new();
    try
    {
      $ID=$cn->store_procedure_transa(
          "sp_correlativos_bajas_Insert",
            array(
    "iID"=>0,
    "inumero"=>$this->numero,
    "iserie"=>$this->serie,
    "itabla"=>$this->tabla,
    "imotivo"=>$this->motivo,
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
      log_error(__FILE__, "correlativos_bajas.insertar", $ex->getMessage());
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
          "sp_correlativos_bajas_Update",
            array(
              "retornar"=>$retornar,
    "iID"=>$this->ID,
    "inumero"=>$this->numero,
    "iserie"=>$this->serie,
    "itabla"=>$this->tabla,
    "imotivo"=>$this->motivo,

),0);
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "correlativos_bajas.actualizar", $ex->getMessage());
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
          "sp_correlativos_bajas_Delete",
            array(
              "retornar"=>$retornar,
              "iID"=>$this->ID,
              "iusuario_mod_id"=>$this->usuario_mod_id ),0
            );
      if($retornar>0)$this->getMessage = "Se elimin? correctamente";
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "correlativos_bajas.eliminar", $ex->getMessage());
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
          "sp_correlativos_bajas_getCount",
            array(
              "filtro"=>$filtro));
      return $resultado;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "correlativos_bajas.getCount", $ex->getMessage());
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
          "sp_correlativos_bajas_getGrid",
            array(
              "filtro"=>$filtro,
              "inicio"=>$inicio,
              "fin"=>$fin,
              "orden"=>$orden));
      return $dt;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "correlativos_bajas.getGrid", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
}  
