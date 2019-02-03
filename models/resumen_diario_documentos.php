<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of resumen_diario_documentos
 *
 * @author miwle_000
 */
class resumen_diario_documentos {
  private $ID;
  private $resumen_diario_ID;
  private $documento_ID;
  private $IdDocumento;
  private $TipoDocumentoReceptor;
  private $NroDocumentoReceptor;
  private $CodigoEstadoItem;
  private $DocumentoRelacionado;
  private $TipoDocumentoRelacionado;
  private $CorrelativoInicio;
  private $CorrelativoFin;
  private $Moneda;
  private $TotalVenta;
  private $TotalDescuentos;
  private $TotalIgv;
  private $TotalIsc;
  private $TotalOtrosImpuestos;
  private $Gravadas;
  private $Exoneradas;
  private $Inafectas;
  private $Exportacion;
  private $Gratuitas;
  private $identificador;
  private $TipoDocumento;
  private $Serie;
  private $usuario_id;
  private $usuario_mod_id;
  private $getMessage;
  public function __set($var, $valor)
    {
      $temporal = $var;
      if (property_exists("resumen_diario_documentos",$temporal))
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
    if (property_exists("resumen_diario_documentos", $temporal))
    {
      return $this->$temporal;
    }
    return null;
  }
  function __construct()
  {
        $this->resumen_diario_ID=0;
    $this->documento_ID=0;
    $this->IdDocumento="";
    $this->TipoDocumentoReceptor="";
    $this->NroDocumentoReceptor="";
    $this->CodigoEstadoItem=0;
    $this->DocumentoRelacionado="";
    $this->TipoDocumentoRelacionado="";
    $this->CorrelativoInicio=0;
    $this->CorrelativoFin=0;
    $this->Moneda="";
    $this->TotalVenta=0;
    $this->TotalDescuentos=0;
    $this->TotalIgv=0;
    $this->TotalIsc=0;
    $this->TotalOtrosImpuestos=0;
    $this->Gravadas=0;
    $this->Exoneradas=0;
    $this->Inafectas=0;
    $this->Exportacion=0;
    $this->Gratuitas=0;
    $this->identificador=0;
    $this->TipoDocumento="";
    $this->Serie="";
    $this->usuario_id=$_SESSION["usuario_ID"];
    $this->usuario_mod_id=$_SESSION["usuario_ID"];

  }
  function __destruct()
  {
        $this->resumen_diario_ID;
    $this->documento_ID;
    $this->IdDocumento;
    $this->TipoDocumentoReceptor;
    $this->NroDocumentoReceptor;
    $this->CodigoEstadoItem;
    $this->DocumentoRelacionado;
    $this->TipoDocumentoRelacionado;
    $this->CorrelativoInicio;
    $this->CorrelativoFin;
    $this->Moneda;
    $this->TotalVenta;
    $this->TotalDescuentos;
    $this->TotalIgv;
    $this->TotalIsc;
    $this->TotalOtrosImpuestos;
    $this->Gravadas;
    $this->Exoneradas;
    $this->Inafectas;
    $this->Exportacion;
    $this->Gratuitas;
    $this->identificador;
    $this->TipoDocumento;
    $this->Serie;
    $this->usuario_id;
    $this->usuario_mod_id;

  }
  static function getByID($ID)
    {
    $cn =new connect_new();
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_resumen_diario_documentos_getByID",
          array("iID"=>$ID));
      $oresumen_diario_documentos=null;
      foreach($dt as $item)
      {
        $oresumen_diario_documentos= new resumen_diario_documentos();
      $oresumen_diario_documentos->ID=$item["ID"];
      $oresumen_diario_documentos->resumen_diario_ID=$item["resumen_diario_ID"];
      $oresumen_diario_documentos->documento_ID=$item["documento_ID"];
      $oresumen_diario_documentos->IdDocumento=$item["IdDocumento"];
      $oresumen_diario_documentos->TipoDocumentoReceptor=$item["TipoDocumentoReceptor"];
      $oresumen_diario_documentos->NroDocumentoReceptor=$item["NroDocumentoReceptor"];
      $oresumen_diario_documentos->CodigoEstadoItem=$item["CodigoEstadoItem"];
      $oresumen_diario_documentos->DocumentoRelacionado=$item["DocumentoRelacionado"];
      $oresumen_diario_documentos->TipoDocumentoRelacionado=$item["TipoDocumentoRelacionado"];
      $oresumen_diario_documentos->CorrelativoInicio=$item["CorrelativoInicio"];
      $oresumen_diario_documentos->CorrelativoFin=$item["CorrelativoFin"];
      $oresumen_diario_documentos->Moneda=$item["Moneda"];
      $oresumen_diario_documentos->TotalVenta=$item["TotalVenta"];
      $oresumen_diario_documentos->TotalDescuentos=$item["TotalDescuentos"];
      $oresumen_diario_documentos->TotalIgv=$item["TotalIgv"];
      $oresumen_diario_documentos->TotalIsc=$item["TotalIsc"];
      $oresumen_diario_documentos->TotalOtrosImpuestos=$item["TotalOtrosImpuestos"];
      $oresumen_diario_documentos->Gravadas=$item["Gravadas"];
      $oresumen_diario_documentos->Exoneradas=$item["Exoneradas"];
      $oresumen_diario_documentos->Inafectas=$item["Inafectas"];
      $oresumen_diario_documentos->Exportacion=$item["Exportacion"];
      $oresumen_diario_documentos->Gratuitas=$item["Gratuitas"];
      $oresumen_diario_documentos->identificador=$item["identificador"];
      $oresumen_diario_documentos->TipoDocumento=$item["TipoDocumento"];
      $oresumen_diario_documentos->Serie=$item["Serie"];
      $oresumen_diario_documentos->usuario_id=$item["usuario_id"];
      $oresumen_diario_documentos->usuario_mod_id=$item["usuario_mod_id"];

      }
      return $oresumen_diario_documentos;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "resumen_diario_documentos.getByID", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  function insertar()
    {
    $cn =new connect_new();
    try
    {
      $ID=$cn->store_procedure_transa(
          "sp_resumen_diario_documentos_Insert",
            array(
    "iID"=>0,
    "iresumen_diario_ID"=>$this->resumen_diario_ID,
    "idocumento_ID"=>$this->documento_ID,
    "iIdDocumento"=>$this->IdDocumento,
    "iTipoDocumentoReceptor"=>$this->TipoDocumentoReceptor,
    "iNroDocumentoReceptor"=>$this->NroDocumentoReceptor,
    "iCodigoEstadoItem"=>$this->CodigoEstadoItem,
    "iDocumentoRelacionado"=>$this->DocumentoRelacionado,
    "iTipoDocumentoRelacionado"=>$this->TipoDocumentoRelacionado,
    "iCorrelativoInicio"=>$this->CorrelativoInicio,
    "iCorrelativoFin"=>$this->CorrelativoFin,
    "iMoneda"=>$this->Moneda,
    "iTotalVenta"=>$this->TotalVenta,
    "iTotalDescuentos"=>$this->TotalDescuentos,
    "iTotalIgv"=>$this->TotalIgv,
    "iTotalIsc"=>$this->TotalIsc,
    "iTotalOtrosImpuestos"=>$this->TotalOtrosImpuestos,
    "iGravadas"=>$this->Gravadas,
    "iExoneradas"=>$this->Exoneradas,
    "iInafectas"=>$this->Inafectas,
    "iExportacion"=>$this->Exportacion,
    "iGratuitas"=>$this->Gratuitas,
    "iidentificador"=>$this->identificador,
    "iTipoDocumento"=>$this->TipoDocumento,
    "iSerie"=>$this->Serie,
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
      log_error(__FILE__, "resumen_diario_documentos.insertar", $ex->getMessage());
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
          "sp_resumen_diario_documentos_Update",
            array(
              "retornar"=>$retornar,
    "iID"=>$this->ID,
    "iresumen_diario_ID"=>$this->resumen_diario_ID,
    "idocumento_ID"=>$this->documento_ID,
    "iIdDocumento"=>$this->IdDocumento,
    "iTipoDocumentoReceptor"=>$this->TipoDocumentoReceptor,
    "iNroDocumentoReceptor"=>$this->NroDocumentoReceptor,
    "iCodigoEstadoItem"=>$this->CodigoEstadoItem,
    "iDocumentoRelacionado"=>$this->DocumentoRelacionado,
    "iTipoDocumentoRelacionado"=>$this->TipoDocumentoRelacionado,
    "iCorrelativoInicio"=>$this->CorrelativoInicio,
    "iCorrelativoFin"=>$this->CorrelativoFin,
    "iMoneda"=>$this->Moneda,
    "iTotalVenta"=>$this->TotalVenta,
    "iTotalDescuentos"=>$this->TotalDescuentos,
    "iTotalIgv"=>$this->TotalIgv,
    "iTotalIsc"=>$this->TotalIsc,
    "iTotalOtrosImpuestos"=>$this->TotalOtrosImpuestos,
    "iGravadas"=>$this->Gravadas,
    "iExoneradas"=>$this->Exoneradas,
    "iInafectas"=>$this->Inafectas,
    "iExportacion"=>$this->Exportacion,
    "iGratuitas"=>$this->Gratuitas,
    "iidentificador"=>$this->identificador,
    "iTipoDocumento"=>$this->TipoDocumento,
    "iSerie"=>$this->Serie,
    "iusuario_mod_id"=>$this->usuario_mod_id
),0);
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "resumen_diario_documentos.actualizar", $ex->getMessage());
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
          "sp_resumen_diario_documentos_getCount",
            array(
              "filtro"=>$filtro));
      return $resultado;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "resumen_diario_documentos.getCount", $ex->getMessage());
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
          "sp_resumen_diario_documentos_getGrid",
            array(
              "filtro"=>$filtro,
              "inicio"=>$inicio,
              "fin"=>$fin,
              "orden"=>$orden));
      return $dt;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "resumen_diario_documentos.getGrid", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
}  

