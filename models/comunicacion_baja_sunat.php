<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of comunicacion_baja_sunat
 *
 * @author miwle_000
 */
class comunicacion_baja_sunat {
  private $ID;
  private $comunicacion_baja_ID;
  private $fecha_generacion;
  private $fecha_respuesta;
  private $nombre_archivo;
  private $descripcion_resultado;
  private $xml_firmado;
  private $ticket;
  private $usuario_id;
  private $getMessage;
  public function __set($var, $valor)
    {
      $temporal = $var;
      if (property_exists("comunicacion_baja_sunat",$temporal))
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
    if (property_exists("comunicacion_baja_sunat", $temporal))
    {
      return $this->$temporal;
    }
    return null;
  }
  function __construct()
  {
        $this->comunicacion_baja_ID=0;
        $this->fecha_generacion="";
        $this->fecha_respuesta="";
        $this->nombre_archivo="";
        $this->descripcion_resultado="";
        $this->xml_firmado="";
        $this->ticket="";
        $this->usuario_id=$_SESSION["usuario_ID"];

  }
  function __destruct()
  {
        $this->comunicacion_baja_ID;
        $this->fecha_generacion;
        $this->fecha_respuesta;
        $this->nombre_archivo;
        $this->descripcion_resultado;
        $this->xml_firmado;
        $this->ticket;
        $this->usuario_id;

      }
  static function getByID($ID)
    {
    $cn =new connect_new();
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_comunicacion_baja_sunat_getByID",
          array("iID"=>$ID));
      $ocomunicacion_baja_sunat=null;
      foreach($dt as $item)
      {
        $ocomunicacion_baja_sunat= new comunicacion_baja_sunat();
      $ocomunicacion_baja_sunat->ID=$item["ID"];
      $ocomunicacion_baja_sunat->comunicacion_baja_ID=$item["comunicacion_baja_ID"];
      $ocomunicacion_baja_sunat->fecha_generacion=$item["fecha_generacion"];
      $ocomunicacion_baja_sunat->fecha_respuesta=$item["fecha_respuesta"];
      $ocomunicacion_baja_sunat->nombre_archivo=$item["nombre_archivo"];
      $ocomunicacion_baja_sunat->descripcion_resultado=$item["descripcion_resultado"];
      $ocomunicacion_baja_sunat->xml_firmado=$item["xml_firmado"];
      $ocomunicacion_baja_sunat->ticket=$item["ticket"];
      $ocomunicacion_baja_sunat->usuario_id=$item["usuario_id"];

      }
      return $ocomunicacion_baja_sunat;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "comunicacion_baja_sunat.getByID", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  function insertar()
    {
    $cn =new connect_new();
    try
    {
      $ID=$cn->store_procedure_transa(
          "sp_comunicacion_baja_sunat_Insert",
            array(
        "iID"=>0,
        "icomunicacion_baja_ID"=>$this->comunicacion_baja_ID,
        "ifecha_generacion"=>$this->fecha_generacion,
        "ifecha_respuesta"=>$this->fecha_respuesta,
        "inombre_archivo"=>$this->nombre_archivo,
        "idescripcion_resultado"=>$this->descripcion_resultado,
        "ixml_firmado"=>$this->xml_firmado,
        "iticket"=>$this->ticket,
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
      log_error(__FILE__, "comunicacion_baja_sunat.insertar", $ex->getMessage());
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
          "sp_comunicacion_baja_sunat_Update",
            array(
              "retornar"=>$retornar,
    "iID"=>$this->ID,
    "icomunicacion_baja_ID"=>$this->comunicacion_baja_ID,
    "ifecha_generacion"=>$this->fecha_generacion,
    "ifecha_respuesta"=>$this->fecha_respuesta,
    "inombre_archivo"=>$this->nombre_archivo,
    "idescripcion_resultado"=>$this->descripcion_resultado,
    "ixml_firmado"=>$this->xml_firmado,
    "iticket"=>$this->ticket,

),0);
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "comunicacion_baja_sunat.actualizar", $ex->getMessage());
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
          "sp_comunicacion_baja_sunat_Delete",
            array(
              "retornar"=>$retornar,
              "iID"=>$this->ID,
              "iusuario_mod_id"=>$this->usuario_mod_id ),0
            );
      if($retornar>0)$this->getMessage = "Se elimin? correctamente";
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "comunicacion_baja_sunat.eliminar", $ex->getMessage());
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
          "sp_comunicacion_baja_sunat_getCount",
            array(
              "filtro"=>$filtro));
      return $resultado;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "comunicacion_baja_sunat.getCount", $ex->getMessage());
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
          "sp_comunicacion_baja_sunat_getGrid",
            array(
              "filtro"=>$filtro,
              "inicio"=>$inicio,
              "fin"=>$fin,
              "orden"=>$orden));
      return $dt;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "comunicacion_baja_sunat.getGrid", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
}  

