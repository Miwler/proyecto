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
class comunicacion_baja {
  private $ID;
  private $IdDocumento;
  private $FechaEmision;
  private $FechaReferencia;
  private $numero;
  private $estado_ID;
  private $empresa_ID;
  private $MotivoBaja;
  
  private $usuario_id;
  private $usuario_mod_id;
  private $getMessage;
  private $dtEstado;
  private $documentos;
  public function __set($var, $valor)
    {
      $temporal = $var;
      if (property_exists("comunicacion_baja",$temporal))
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
    if (property_exists("comunicacion_baja", $temporal))
    {
      return $this->$temporal;
    }
    return null;
  }
  function __construct()
  {
    $this->IdDocumento="";
    $this->FechaEmision=NULL;
    $this->FechaReferencia=NULL;
    $this->numero=0;
    $this->estado_ID=108;
    $this->empresa_ID=$_SESSION["empresa_ID"];
    $this->MotivoBaja='';
    $this->usuario_id=$_SESSION["usuario_ID"];
    $this->usuario_mod_id=$_SESSION["usuario_ID"];

  }
  function __destruct()
  {
        $this->IdDocumento;
    $this->FechaEmision;
    $this->FechaReferencia;
    $this->numero;
    $this->estado_ID;
    $this->empresa_ID;
    $this->MotivoBaja;
    $this->usuario_id;
    $this->usuario_mod_id;

  }
  static function getByID($ID)
    {
    $cn =new connect_new();
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_comunicacion_baja_getByID",
          array("iID"=>$ID));
      $ocomunicacion_baja=null;
      foreach($dt as $item)
      {
        $ocomunicacion_baja= new comunicacion_baja();
      $ocomunicacion_baja->ID=$item["ID"];
      $ocomunicacion_baja->IdDocumento=$item["IdDocumento"];
      $ocomunicacion_baja->FechaEmision=$item["FechaEmision"];
      $ocomunicacion_baja->FechaReferencia=$item["FechaReferencia"];
      $ocomunicacion_baja->numero=$item["numero"];
      $ocomunicacion_baja->estado_ID=$item["estado_ID"];
      $ocomunicacion_baja->empresa_ID=$item["empresa_ID"];
      $ocomunicacion_baja->MotivoBaja=$item["MotivoBaja"];
      $ocomunicacion_baja->usuario_id=$item["usuario_id"];
      $ocomunicacion_baja->usuario_mod_id=$item["usuario_mod_id"];

      }
      return $ocomunicacion_baja;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "comunicacion_baja.getByID", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  function insertar()
    {
    $cn =new connect_new();
    try
    {
      $ID=$cn->store_procedure_transa(
          "sp_comunicacion_baja_Insert",
            array(
            "iID"=>0,
            "iFechaEmision"=>FormatTextToDate($this->FechaEmision,'Y-m-d'),
            "iFechaReferencia"=>FormatTextToDate($this->FechaReferencia,'Y-m-d'),
            "iestado_ID"=>$this->estado_ID,
            "iempresa_ID"=>$this->empresa_ID,
            "iusuario_id"=>$this->usuario_id,
            "iMotivoBaja"=>$this->MotivoBaja,
            "idocumentos"=>$this->documentos
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
      log_error(__FILE__, "comunicacion_baja.insertar", $ex->getMessage());
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
          "sp_comunicacion_baja_Update",
            array(
              "retornar"=>$retornar,
            "iID"=>$this->ID,
            "iIdDocumento"=>$this->IdDocumento,
            "iFechaEmision"=> FormatTextToDate($this->FechaEmision, 'Y-m-d'),
            "iFechaReferencia"=>FormatTextToDate($this->FechaReferencia,'Y-m-d'),
            "inumero"=>$this->numero,
            "iestado_ID"=>$this->estado_ID,
            "iempresa_ID"=>$this->empresa_ID,
            "iMotivoBaja"=>$this->MotivoBaja,
            "iusuario_mod_id"=>$this->usuario_mod_id
        ),0);
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "comunicacion_baja.actualizar", $ex->getMessage());
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
          "sp_comunicacion_baja_Delete",
            array(
              "retornar"=>$retornar,
              "iID"=>$this->ID,
              "iusuario_mod_id"=>$this->usuario_mod_id ),0
            );
      if($retornar>0)$this->getMessage = "Se eliminó correctamente";
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "comunicacion_baja.eliminar", $ex->getMessage());
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
          "sp_comunicacion_baja_getCount",
            array(
              "filtro"=>$filtro));
      return $resultado;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "comunicacion_baja.getCount", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  static function getGrid($filtro="",$inicio=-1,$fin=-1,$orden="cb.ID asc")
    {
    $cn =new connect_new();
    $retornar =0;
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_comunicacion_baja_getGrid",
            array(
              "filtro"=>$filtro,
              "inicio"=>$inicio,
              "fin"=>$fin,
              "orden"=>$orden));
      return $dt;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "comunicacion_baja.getGrid", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  static function getFilasDocumentos($factura_venta,$facturas_erradas,$nota_credito,$nota_debito,$ID=0)
    {
    $cn =new connect_new();
    $retornar ="";
    try
    {
      $retornar=$cn->store_procedure_getData(
          "sp_comunicacion_baja_getFilasDocumentos",
            array(
                "ifactura_venta"=>$factura_venta,
                "ifacturas_erradas"=>$facturas_erradas,
                "inota_credito"=>$nota_credito,
                "inota_debito"=>$nota_debito,
                "iID"=>$ID,
                "iempresa_ID"=>$_SESSION['empresa_ID']));
      
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "comunicacion_baja.getFilasDocumentos", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
}  

