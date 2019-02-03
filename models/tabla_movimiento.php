<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tabla_movimiento
 *
 * @author miwle_000
 */
class tabla_movimiento {
  private $ID;
  private $tabla_ID;
  private $tabla;
  private $estado_ID;
  private $fecha;
  private $observacion;
  private $usuario_ID_creacion;
  private $empresa_ID;
  private $usuario_id;
  private $getMessage;
  public function __set($var, $valor)
    {
      $temporal = $var;
      if (property_exists("tabla_movimiento",$temporal))
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
    if (property_exists("tabla_movimiento", $temporal))
    {
      return $this->$temporal;
    }
    return null;
  }
  function __construct()
  {
        $this->tabla_ID=0;
    $this->tabla="";
    $this->fecha="";
    $this->observacion="";
    $this->usuario_ID_creacion=0;
    $this->usuario_id=$_SESSION["usuario_ID"];

  }
  function __destruct()
  {
        $this->tabla_ID;
    $this->tabla;
    $this->fecha;
    $this->observacion;
    $this->usuario_ID_creacion;
    $this->usuario_id;

  }
  static function getByID($ID)
    {
    $cn =new connect_new();
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_tabla_movimiento_getByID",
          array("iID"=>$ID));
      $otabla_movimiento=null;
      foreach($dt as $item)
      {
        $otabla_movimiento= new tabla_movimiento();
      $otabla_movimiento->ID=$item["ID"];
      $otabla_movimiento->tabla_ID=$item["tabla_ID"];
      $otabla_movimiento->tabla=$item["tabla"];
      $otabla_movimiento->estado_ID=$item["estado_ID"];
      $otabla_movimiento->fecha=$item["fecha"];
      $otabla_movimiento->observacion=$item["observacion"];
      $otabla_movimiento->usuario_ID_creacion=$item["usuario_ID_creacion"];
      $otabla_movimiento->empresa_ID=$item["empresa_ID"];
      $otabla_movimiento->usuario_id=$item["usuario_id"];

      }
      return $otabla_movimiento;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "tabla_movimiento.getByID", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  function insertar()
    {
    $cn =new connect_new();
    try
    {
        $ID=$cn->store_procedure_transa(
            "sp_tabla_movimiento_Insert",
                array(
                "iID"=>0,
                "itabla_ID"=>$this->tabla_ID,
                "itabla"=>$this->tabla,
                "iestado_ID"=>$this->estado_ID,
                "ifecha"=>$this->fecha,
                "iobservacion"=>$this->observacion,
                "iusuario_ID_creacion"=>$this->usuario_ID_creacion,
                "iempresa_ID"=>$this->empresa_ID,
                "iusuario_id"=>$this->usuario_id
            ),0);
        if($ID>0){
        $this->getMessage="El registro se guardó correctamente.";
            $this->ID=$ID;
            return $ID;
        } else {
            throw new Exception("No se registró.");
        }
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "tabla_movimiento.insertar", $ex->getMessage());
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
          "sp_tabla_movimiento_Update",
            array(
              "retornar"=>$retornar,
    "iID"=>$this->ID,
    "itabla_ID"=>$this->tabla_ID,
    "itabla"=>$this->tabla,
    "iestado_ID"=>$this->estado_ID,
    "ifecha"=>$this->fecha,
    "iobservacion"=>$this->observacion,
    "iusuario_ID_creacion"=>$this->usuario_ID_creacion,
    "iempresa_ID"=>$this->empresa_ID,

),0);
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "tabla_movimiento.actualizar", $ex->getMessage());
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
          "sp_tabla_movimiento_getCount",
            array(
              "filtro"=>$filtro));
      return $resultado;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "tabla_movimiento.getCount", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
}  

