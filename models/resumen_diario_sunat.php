<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of resumen_diario_sunat
 *
 * @author miwle_000
 */
class resumen_diario_sunat {
  private $ID;
  private $resumen_diario_ID;
  private $fecha_generacion;
  private $fecha_respuesta;
  private $nombre_archivo;
  private $xml_firmado;
  private $hash;
  private $representacion_impresa;
  private $estado_envio;
  private $codigo_estado;
  private $descripcion_estado;
  private $cdr_sunat;
  private $NroTicket;
  private $usuario_id;
  private $getMessage;
  public function __set($var, $valor)
    {
      $temporal = $var;
      if (property_exists("resumen_diario_sunat",$temporal))
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
    if (property_exists("resumen_diario_sunat", $temporal))
    {
      return $this->$temporal;
    }
    return null;
  }
  function __construct()
  {
        $this->fecha_generacion="";
    $this->fecha_respuesta="";
    $this->nombre_archivo="";
    $this->xml_firmado="";
    $this->hash="";
    $this->representacion_impresa="";
    $this->estado_envio="";
    $this->codigo_estado="";
    $this->descripcion_estado="";
    $this->cdr_sunat="";
    $this->NroTicket="NULL";
    $this->usuario_id=$_SESSION["usuario_ID"];

  }
  function __destruct()
  {
        $this->fecha_generacion;
    $this->fecha_respuesta;
    $this->nombre_archivo;
    $this->xml_firmado;
    $this->hash;
    $this->representacion_impresa;
    $this->estado_envio;
    $this->codigo_estado;
    $this->descripcion_estado;
    $this->cdr_sunat;
    $this->NroTicket;
    $this->usuario_id;

  }
  static function getByID($ID)
    {
    $cn =new connect_new();
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_resumen_diario_sunat_getByID",
          array("iID"=>$ID));
      $oresumen_diario_sunat=null;
      foreach($dt as $item)
      {
        $oresumen_diario_sunat= new resumen_diario_sunat();
      $oresumen_diario_sunat->ID=$item["ID"];
      $oresumen_diario_sunat->resumen_diario_ID=$item["resumen_diario_ID"];
      $oresumen_diario_sunat->fecha_generacion=$item["fecha_generacion"];
      $oresumen_diario_sunat->fecha_respuesta=$item["fecha_respuesta"];
      $oresumen_diario_sunat->nombre_archivo=$item["nombre_archivo"];
      $oresumen_diario_sunat->xml_firmado=$item["xml_firmado"];
      $oresumen_diario_sunat->hash=$item["hash"];
      $oresumen_diario_sunat->representacion_impresa=$item["representacion_impresa"];
      $oresumen_diario_sunat->estado_envio=$item["estado_envio"];
      $oresumen_diario_sunat->codigo_estado=$item["codigo_estado"];
      $oresumen_diario_sunat->descripcion_estado=$item["descripcion_estado"];
      $oresumen_diario_sunat->cdr_sunat=$item["cdr_sunat"];
      $oresumen_diario_sunat->usuario_id=$item["usuario_id"];

      }
      return $oresumen_diario_sunat;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "resumen_diario_sunat.getByID", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  function insertar()
    {
    $cn =new connect_new();
    try
    {
      $ID=$cn->store_procedure_transa(
          "sp_resumen_diario_sunat_Insert",
            array(
    "iID"=>0,
    "iresumen_diario_ID"=>$this->resumen_diario_ID,
    "ifecha_generacion"=>$this->fecha_generacion,
    "ifecha_respuesta"=>$this->fecha_respuesta,
    "inombre_archivo"=>$this->nombre_archivo,
    "ixml_firmado"=>$this->xml_firmado,
    "ihash"=>$this->hash,
    "irepresentacion_impresa"=>$this->representacion_impresa,
    "iestado_envio"=>$this->estado_envio,
    "icodigo_estado"=>$this->codigo_estado,
    "idescripcion_estado"=>$this->descripcion_estado,
    "icdr_sunat"=>$this->cdr_sunat,
    "iNroTicket"=>$this->NroTicket,   
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
      log_error(__FILE__, "resumen_diario_sunat.insertar", $ex->getMessage());
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
          "sp_resumen_diario_sunat_Update",
            array(
              "retornar"=>$retornar,
    "iID"=>$this->ID,
    "iresumen_diario_ID"=>$this->resumen_diario_ID,
    "ifecha_generacion"=>$this->fecha_generacion,
    "ifecha_respuesta"=>$this->fecha_respuesta,
    "inombre_archivo"=>$this->nombre_archivo,
    "ixml_firmado"=>$this->xml_firmado,
    "ihash"=>$this->hash,
    "irepresentacion_impresa"=>$this->representacion_impresa,
    "iestado_envio"=>$this->estado_envio,
    "icodigo_estado"=>$this->codigo_estado,
    "idescripcion_estado"=>$this->descripcion_estado,
    "icdr_sunat"=>$this->cdr_sunat,

),0);
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "resumen_diario_sunat.actualizar", $ex->getMessage());
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
          "sp_resumen_diario_sunat_getCount",
            array(
              "filtro"=>$filtro));
      return $resultado;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "resumen_diario_sunat.getCount", $ex->getMessage());
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
          "sp_resumen_diario_sunat_getGrid",
            array(
              "filtro"=>$filtro,
              "inicio"=>$inicio,
              "fin"=>$fin,
              "orden"=>$orden));
      return $dt;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "resumen_diario_sunat.getGrid", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
}  

