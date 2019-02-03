<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of guia_venta_sunat
 *
 * @author miwle_000
 */
class guia_venta_sunat {
  private $ID;
  private $guia_venta_ID;
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
  private $usuario_id;
  private $getMessage;
  public function __set($var, $valor)
    {
      $temporal = $var;
      if (property_exists("guia_venta_sunat",$temporal))
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
    if (property_exists("guia_venta_sunat", $temporal))
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
    $this->usuario_id;

  }
  static function getByID($ID)
    {
    $cn =new connect_new();
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_guia_venta_sunat_getByID",
          array("iID"=>$ID));
      $oguia_venta_sunat=null;
      foreach($dt as $item)
      {
        $oguia_venta_sunat= new guia_venta_sunat();
      $oguia_venta_sunat->ID=$item["ID"];
      $oguia_venta_sunat->guia_venta_ID=$item["guia_venta_ID"];
      $oguia_venta_sunat->fecha_generacion=$item["fecha_generacion"];
      $oguia_venta_sunat->fecha_respuesta=$item["fecha_respuesta"];
      $oguia_venta_sunat->nombre_archivo=$item["nombre_archivo"];
      $oguia_venta_sunat->xml_firmado=$item["xml_firmado"];
      $oguia_venta_sunat->hash=$item["hash"];
      $oguia_venta_sunat->representacion_impresa=$item["representacion_impresa"];
      $oguia_venta_sunat->estado_envio=$item["estado_envio"];
      $oguia_venta_sunat->codigo_estado=$item["codigo_estado"];
      $oguia_venta_sunat->descripcion_estado=$item["descripcion_estado"];
      $oguia_venta_sunat->cdr_sunat=$item["cdr_sunat"];
      $oguia_venta_sunat->usuario_id=$item["usuario_id"];

      }
      return $oguia_venta_sunat;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "guia_venta_sunat.getByID", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  function insertar()
    {
    $cn =new connect_new();
    try
    {
      $ID=$cn->store_procedure_transa(
          "sp_guia_venta_sunat_Insert",
            array(
            "iID"=>0,
            "iguia_venta_ID"=>$this->guia_venta_ID,
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
      log_error(__FILE__, "guia_venta_sunat.insertar", $ex->getMessage());
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
          "sp_guia_venta_sunat_Update",
            array(
              "retornar"=>$retornar,
    "iID"=>$this->ID,
    "iguia_venta_ID"=>$this->guia_venta_ID,
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
      log_error(__FILE__, "guia_venta_sunat.actualizar", $ex->getMessage());
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
          "sp_guia_venta_sunat_getCount",
            array(
              "filtro"=>$filtro));
      return $resultado;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "guia_venta_sunat.getCount", $ex->getMessage());
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
          "sp_guia_venta_sunat_getGrid",
            array(
              "filtro"=>$filtro,
              "inicio"=>$inicio,
              "fin"=>$fin,
              "orden"=>$orden));
      return $dt;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "guia_venta_sunat.getGrid", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
}  

