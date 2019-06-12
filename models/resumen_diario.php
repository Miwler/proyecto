<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of resumen_diario
 *
 * @author miwle_000
 */
class resumen_diario {
  private $ID;
  private $IdDocumento;
  private $FechaEmision;
  private $FechaReferencia;
  private $numero;
  private $tipo_ID;
  private $estado_ID;
  private $empresa_ID;
  private $usuario_id;
  private $usuario_mod_id;
  private $getMessage;
  private $dtTipo;
  private $documentos_IDs;
  public function __set($var, $valor)
    {
      $temporal = $var;
      if (property_exists("resumen_diario",$temporal))
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
    if (property_exists("resumen_diario", $temporal))
    {
      return $this->$temporal;
    }
    return null;
  }
  function __construct()
  {
        $this->IdDocumento="";
    $this->FechaEmision="NULL";
    $this->FechaReferencia="NULL";
    $this->numero=0;
    $this->tipo_ID="NULL";
    $this->estado_ID="NULL";
    $this->empresa_ID=$_GET['empresa_ID'];
    $this->usuario_id=$_SESSION["usuario_ID"];
    $this->usuario_mod_id=$_SESSION["usuario_ID"];

  }
  function __destruct()
  {
        $this->IdDocumento;
    $this->FechaEmision;
    $this->FechaReferencia;
    $this->numero;
    $this->tipo_ID;
    $this->estado_ID;
    $this->empresa_ID;
    $this->usuario_id;
    $this->usuario_mod_id;

  }
  static function getByID($ID)
    {
    $cn =new connect_new();
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_resumen_diario_getByID",
          array("iID"=>$ID));
      $oresumen_diario=null;
      foreach($dt as $item)
      {
        $oresumen_diario= new resumen_diario();
      $oresumen_diario->ID=$item["ID"];
      $oresumen_diario->IdDocumento=$item["IdDocumento"];
      $oresumen_diario->FechaEmision=$item["FechaEmision"];
      $oresumen_diario->FechaReferencia=$item["FechaReferencia"];
      $oresumen_diario->numero=$item["numero"];
      $oresumen_diario->tipo_ID=$item["tipo_ID"];
      $oresumen_diario->estado_ID=$item["estado_ID"];
      $oresumen_diario->empresa_ID=$item["empresa_ID"];
      $oresumen_diario->usuario_id=$item["usuario_id"];
      $oresumen_diario->usuario_mod_id=$item["usuario_mod_id"];

      }
      return $oresumen_diario;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "resumen_diario.getByID", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  function insertar()
    {
    $cn =new connect_new();
    try
    {
      $ID=$cn->store_procedure_transa(
          "sp_resumen_diario_Insert",
            array(
    "iID"=>0,
    "iFechaEmision"=> FormatTextToDate($this->FechaEmision, 'Y-m-d'),
    "iFechaReferencia"=>FormatTextToDate($this->FechaReferencia, 'Y-m-d'),
    "itipo_ID"=>$this->tipo_ID,
    "iestado_ID"=>$this->estado_ID,
    "iempresa_ID"=>$this->empresa_ID,
    "iusuario_id"=>$this->usuario_id,
    "documentos_IDs"=>$this->documentos_IDs
),0);
      if($ID>0){
        $this->getMessage="El registro se guardó correctamente.";
        $this->ID=$ID;
        return $ID;
      } else {
          throw new Exception("No se registró");
      }
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "resumen_diario.insertar", $ex->getMessage());
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
          "sp_resumen_diario_Update",
            array(
              "retornar"=>$retornar,
    "iID"=>$this->ID,
    "iIdDocumento"=>$this->IdDocumento,
    "iFechaEmision"=>$this->FechaEmision,
    "iFechaReferencia"=>$this->FechaReferencia,
    "inumero"=>$this->numero,
    "itipo_ID"=>$this->tipo_ID,
    "iestado_ID"=>$this->estado_ID,
    "iempresa_ID"=>$this->empresa_ID,
    "iusuario_mod_id"=>$this->usuario_mod_id
),0);
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "resumen_diario.actualizar", $ex->getMessage());
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
          "sp_resumen_diario_getCount",
            array(
              "filtro"=>$filtro));
      return $resultado;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "resumen_diario.getCount", $ex->getMessage());
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
          "sp_resumen_diario_getGrid",
            array(
              "filtro"=>$filtro,
              "inicio"=>$inicio,
              "fin"=>$fin,
              "orden"=>$orden));
      return $dt;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "resumen_diario.getGrid", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  static function getFilasDocumentos($tipo_ID,$fecha)
    {
    $cn =new connect_new();
    $retornar ="";
    try
    {
      $retornar=$cn->store_procedure_getData(
          "sp_resumen_diario_getFilasDocumentos",
            array(
              "itipo_ID"=>$tipo_ID,
              "fecha"=>$fecha));
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "resumen_diario.getGrid", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  static function getTabla()
    {
        //$cn =new connect_new();
        $cn=new connect_new();
        try
        {
            
        //$q='call getTabla_Orden_Venta("'.$opcion.'",'.$_GET['empresa_ID'].','.$cliente_ID.','.$todos.',"'.$fecha_inicio.'","'.$fecha_fin.'",'.$estado_ID.','.$moneda_ID.',"'.$periodo_texto.'",'.$numero.','.$numero_factura.');';
        //console_log($q);
        //$dt=$cn->getTabla($q);
        $dt=$cn->store_procedure_getGridParse(
                'sp_resumen_diario_getTabla',
                array(
                    'iempresa_ID'=>$_GET['empresa_ID']
                ));
        //var_dump($dt);
        return $dt;
        }catch(Exception $ex)
        {
            log_error(__FILE__, "salida.getTabla", $ex->getMessage());
                throw new Exception("Ocurrió un error en el sistema");
        }
    }
}  

