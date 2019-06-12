<?php

class guia_venta {
  private $ID;
  private $factura_venta_ID;
  private $serie;
  private $numero;
  private $numero_concatenado;
  private $fecha_emision;
  private $numero_orden_compra;
  private $numero_orden_venta;
  private $vehiculo_ID;
  private $chofer_ID;
  private $estado_ID;
  private $observacion;
  private $numero_pagina;
  private $fecha_inicio_traslado;
  private $punto_partida;
  private $punto_llegada;
  private $empresa_transporte;
  private $impresion;
  private $salida_ID;
  private $opcion;
  private $numero_producto;
  private $empresa_ID;
  private $correlativos_ID;
  private $ver_descripcion;
  private $ver_componente;
  private $ver_adicional;
  private $ver_serie;
  private $incluir_obsequios;
  private $motivo_traslado_ID;
  private $descripcion_motivo;
  private $transbordo;
  private $peso_bruto_total;
  private $nro_pallets;
  private $modalidad_traslado_ID;

  private $ruc_transportista;
  private $razon_social_transportista;
  private $nro_placa_vehiculo;
  private $nro_documento_conductor;
  private $distrito_ID_partida;
  private $distrito_ID_llegada;
  private $numero_contenedor;
  private $codigo_puerto;
  private $cliente_ID_subcotratista;
  private $guia_baja_ID;
  private $usuario_id;
  private $usuario_mod_id;
  private $getMessage;
  private $dtVehiculo;
  private $dtChofer;
  private $dtDepartamento;
  private $dtDistrito;
  private $dtProvincia;
  private $dtDepartamento_llegada;
  private $dtDistrito_llegada;
  private $dtProvincia_llegada;
  private $dtCorrelativos;
  private $departamento_ID_llegada;
  private $provincia_ID_llegada;
  private $departamento_ID_partida;
  private $provincia_ID_partida;
  private $dtMotivo_Traslado;
  private $dtModalidad_Traslado;
  private $dtSerie;
  private $dtFactura_Venta;
  private $tipo_documento;
  private $salida_detalle_IDs;
  Private $ver_vista_previa;
    Private $ver_imprimir;
    private $estado;
    private $cliente_ID;
    private $oCliente;
    
  public function __set($var, $valor)
    {
      $temporal = $var;
      if (property_exists("guia_venta",$temporal))
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
    if (property_exists("guia_venta", $temporal))
    {
      return $this->$temporal;
    }
    return null;
  }
  function __construct()
  {
        $this->serie="";
    $this->numero="";
    
    $this->numero_concatenado="";
    $this->fecha_emision=date("d/m/Y");
    $this->numero_orden_compra="";
    $this->numero_orden_venta="";
    $this->observacion="";
    $this->vehiculo_ID=0;
    $this->chofer_ID=0;
    $this->numero_pagina=1;
    $this->fecha_inicio_traslado=date("d/m/Y");
    $this->punto_partida="";
    $this->punto_llegada="";
    $this->empresa_transporte="";
    $this->impresion=0;
    $this->opcion=0;
    $this->numero_producto=0;
    $this->ver_descripcion=0;
    $this->ver_componente=0;
    $this->ver_adicional=0;
    $this->ver_serie=0;
    $this->incluir_obsequios=0;
    $this->descripcion_motivo="";
    $this->transbordo="";
    $this->peso_bruto_total=0;
    $this->nro_pallets=0;
    $this->modalidad_traslado_ID=2;
    $this->ruc_transportista="";
    $this->razon_social_transportista="";
    $this->nro_placa_vehiculo="";
    $this->nro_documento_conductor="";
    $this->numero_contenedor="";
    $this->codigo_puerto="";
    $this->cliente_ID_subcotratista="NULL";
    $this->guia_baja_ID="NULL";
    $this->motivo_traslado_ID=1;
    $this->usuario_id=$_SESSION["usuario_ID"];
    $this->usuario_mod_id=$_SESSION["usuario_ID"];
    $this->empresa_ID=$_GET['empresa_ID'];
    $this->departamento_ID_llegada=departamento_ID_default;
    $this->provincia_ID_llegada=provincia_ID_default;
    $this->distrito_ID_llegada=distrito_ID_default;
    $this->nro_pallets=0;

  }
  function __destruct()
  {
    $this->serie;
    $this->numero;
    $this->numero_concatenado;
    $this->fecha_emision;
    $this->numero_orden_compra;
    $this->numero_orden_venta;
    $this->observacion;
    $this->vehiculo_ID;
    $this->chofer_ID;
    $this->numero_pagina;
    $this->fecha_inicio_traslado;
    $this->punto_partida;
    $this->punto_llegada;
    $this->empresa_transporte;
    $this->impresion;
    $this->opcion;
    $this->numero_producto;
    $this->ver_descripcion;
    $this->ver_componente;
    $this->ver_adicional;
    $this->ver_serie;
    $this->incluir_obsequios;
    $this->descripcion_motivo;
    $this->transbordo;
    $this->peso_bruto_total;
    $this->nro_pallets;
    $this->modalidad_traslado_ID;
    $this->ruc_transportista;
    $this->razon_social_transportista;
    $this->nro_placa_vehiculo;
    $this->nro_documento_conductor;
    $this->numero_contenedor;
    $this->codigo_puerto;
    $this->cliente_ID_subcotratista;
    $this->guia_baja_ID;
    $this->usuario_id;
    $this->usuario_mod_id;
    $this->departamento_ID_llegada;
    $this->provincia_ID_llegada;
    $this->distrito_ID_llegada;
    $this->departamento_ID_partida;
    $this->provincia_ID_partida;
    $this->distrito_ID_partida;
  }
  static function getByID($ID)
    {
    $cn =new connect_new();
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_guia_venta_getByID",
          array("iID"=>$ID));
      $oguia_venta=null;
     
      foreach($dt as $item)
      {
        $oguia_venta= new guia_venta();
      $oguia_venta->ID=$item["ID"];
      $oguia_venta->factura_venta_ID=$item["factura_venta_ID"];
      $oguia_venta->serie=$item["serie"];
      $oguia_venta->numero=$item["numero"];
      $oguia_venta->numero_concatenado=$item["numero_concatenado"];
      $oguia_venta->fecha_emision=$item["fecha_emision"];
      $oguia_venta->numero_orden_compra=$item["numero_orden_compra"];
      $oguia_venta->numero_orden_venta=$item["numero_orden_venta"];
      $oguia_venta->vehiculo_ID=$item["vehiculo_ID"];
      $oguia_venta->chofer_ID=$item["chofer_ID"];
      $oguia_venta->estado_ID=$item["estado_ID"];
      $oguia_venta->observacion=$item["observacion"];
      $oguia_venta->numero_pagina=$item["numero_pagina"];
      $oguia_venta->fecha_inicio_traslado=$item["fecha_inicio_traslado"];
      $oguia_venta->punto_partida=$item["punto_partida"];
      $oguia_venta->punto_llegada=$item["punto_llegada"];
      $oguia_venta->empresa_transporte=$item["empresa_transporte"];
      $oguia_venta->impresion=$item["impresion"];
      $oguia_venta->salida_ID=$item["salida_ID"];
      $oguia_venta->opcion=$item["opcion"];
      $oguia_venta->numero_producto=$item["numero_producto"];
      $oguia_venta->empresa_ID=$item["empresa_ID"];
      $oguia_venta->correlativos_ID=$item["correlativos_ID"];
      $oguia_venta->ver_descripcion=$item["ver_descripcion"];
      $oguia_venta->ver_componente=$item["ver_componente"];
      $oguia_venta->ver_adicional=$item["ver_adicional"];
      $oguia_venta->ver_serie=$item["ver_serie"];
      $oguia_venta->incluir_obsequios=$item["incluir_obsequios"];
      $oguia_venta->motivo_traslado_ID=$item["motivo_traslado_ID"];
      $oguia_venta->descripcion_motivo=$item["descripcion_motivo"];
      $oguia_venta->transbordo=$item["transbordo"];
      $oguia_venta->peso_bruto_total= round($item["peso_bruto_total"],2);
      $oguia_venta->nro_pallets=$item["nro_pallets"];
      $oguia_venta->modalidad_traslado_ID=$item["modalidad_traslado_ID"];
      $oguia_venta->ruc_transportista=$item["ruc_transportista"];
      $oguia_venta->razon_social_transportista=$item["razon_social_transportista"];
      $oguia_venta->nro_placa_vehiculo=$item["nro_placa_vehiculo"];
      $oguia_venta->nro_documento_conductor=$item["nro_documento_conductor"];
      $oguia_venta->distrito_ID_partida=$item["distrito_ID_partida"];
      $oguia_venta->distrito_ID_llegada=$item["distrito_ID_llegada"];
      $oguia_venta->numero_contenedor=$item["numero_contenedor"];
      $oguia_venta->codigo_puerto=$item["codigo_puerto"];
      $oguia_venta->cliente_ID_subcotratista=$item["cliente_ID_subcotratista"];
      $oguia_venta->guia_baja_ID=$item["guia_baja_ID"];
      $oguia_venta->usuario_id=$item["usuario_id"];
      $oguia_venta->usuario_mod_id=$item["usuario_mod_id"];
      $oguia_venta->cliente_ID= $item['cliente_ID'];
      }
       
      return $oguia_venta;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "guia_venta.getByID", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  static function getByIDInd($ID)
    {
    $cn =new connect_new();
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_guia_venta_getByIDInd",
          array("iID"=>$ID));
      $oguia_venta=null;
     
      foreach($dt as $item)
      {
        $oguia_venta= new guia_venta();
        $oguia_venta->ID=$item["ID"];
        $oguia_venta->serie=$item["serie"];
        $oguia_venta->numero=$item["numero"];
        $oguia_venta->numero_concatenado=$item["numero_concatenado"];
        $oguia_venta->fecha_emision=$item["fecha_emision"];
        $oguia_venta->numero_orden_compra=$item["numero_orden_compra"];
        $oguia_venta->numero_orden_venta=$item["numero_orden_venta"];
        $oguia_venta->vehiculo_ID=$item["vehiculo_ID"];
        $oguia_venta->chofer_ID=$item["chofer_ID"];
        $oguia_venta->estado_ID=$item["estado_ID"];
        $oguia_venta->observacion=$item["observacion"];
        $oguia_venta->fecha_inicio_traslado=$item["fecha_inicio_traslado"];
        $oguia_venta->punto_partida=$item["punto_partida"];
        $oguia_venta->punto_llegada=$item["punto_llegada"];
        $oguia_venta->empresa_transporte=$item["empresa_transporte"];
        $oguia_venta->impresion=$item["impresion"];
        $oguia_venta->opcion=$item["opcion"];
        $oguia_venta->numero_producto=$item["numero_producto"];
        $oguia_venta->empresa_ID=$item["empresa_ID"];
        $oguia_venta->correlativos_ID=$item["correlativos_ID"];
        $oguia_venta->motivo_traslado_ID=$item["motivo_traslado_ID"];
        $oguia_venta->descripcion_motivo=$item["descripcion_motivo"];
        $oguia_venta->transbordo=$item["transbordo"];
        $oguia_venta->peso_bruto_total= round($item["peso_bruto_total"],2);
        $oguia_venta->nro_pallets=$item["nro_pallets"];
        $oguia_venta->modalidad_traslado_ID=$item["modalidad_traslado_ID"];
        $oguia_venta->ruc_transportista=$item["ruc_transportista"];
        $oguia_venta->razon_social_transportista=$item["razon_social_transportista"];
        $oguia_venta->nro_placa_vehiculo=$item["nro_placa_vehiculo"];
        $oguia_venta->nro_documento_conductor=$item["nro_documento_conductor"];
        $oguia_venta->distrito_ID_partida=$item["distrito_ID_partida"];
        $oguia_venta->distrito_ID_llegada=$item["distrito_ID_llegada"];
        $oguia_venta->numero_contenedor=$item["numero_contenedor"];
        $oguia_venta->codigo_puerto=$item["codigo_puerto"];
        $oguia_venta->cliente_ID_subcotratista=$item["cliente_ID_subcotratista"];
        $oguia_venta->cliente_ID= $item['cliente_ID'];
        $oguia_venta->guia_baja_ID= $item['guia_baja_ID'];
        $oguia_venta->usuario_id=$item["usuario_id"];
        $oguia_venta->usuario_mod_id=$item["usuario_mod_id"];
      }
       
      return $oguia_venta;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "guia_venta.getByID", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  function insertar()
    {
    $cn =new connect_new();
    try
    {
      $ID=$cn->store_procedure_transa(
          "sp_guia_venta_Insert",
            array(
            "iID"=>0,
            "ifactura_venta_ID"=>$this->factura_venta_ID,
            "iserie"=>$this->serie,
            "inumero"=>$this->numero,
            "inumero_concatenado"=>$this->numero_concatenado,
            "ifecha_emision"=>FormatTextToDate($this->fecha_emision,'Y-m-d'),
            "inumero_orden_compra"=>$this->numero_orden_compra,
            "inumero_orden_venta"=>$this->numero_orden_venta,
            "ivehiculo_ID"=>$this->vehiculo_ID,
            "ichofer_ID"=>$this->chofer_ID,
            "iestado_ID"=>$this->estado_ID,
            "iobservacion"=>$this->observacion,
            "inumero_pagina"=>$this->numero_pagina,
            "ifecha_inicio_traslado"=>FormatTextToDate($this->fecha_inicio_traslado,'Y-m-d'),
            "ipunto_partida"=>$this->punto_partida,
            "ipunto_llegada"=>$this->punto_llegada,
            "iempresa_transporte"=>$this->empresa_transporte,
            "iimpresion"=>$this->impresion,
            "isalida_ID"=>$this->salida_ID,
            "iopcion"=>$this->opcion,
            "inumero_producto"=>$this->numero_producto,
            "iempresa_ID"=>$this->empresa_ID,
            "icorrelativos_ID"=>$this->correlativos_ID,
            "iver_descripcion"=>$this->ver_descripcion,
            "iver_componente"=>$this->ver_componente,
            "iver_adicional"=>$this->ver_adicional,
            "iver_serie"=>$this->ver_serie,
            "iincluir_obsequios"=>$this->incluir_obsequios,
            "imotivo_traslado_ID"=>$this->motivo_traslado_ID,
            "idescripcion_motivo"=>$this->descripcion_motivo,
            "itransbordo"=>$this->transbordo,
            "ipeso_bruto_total"=>$this->peso_bruto_total,
            "inro_pallets"=>$this->nro_pallets,
            "imodalidad_traslado_ID"=>$this->modalidad_traslado_ID,
           
            "iruc_transportista"=>$this->ruc_transportista,
            "irazon_social_transportista"=>$this->razon_social_transportista,
            "inro_placa_vehiculo"=>$this->nro_placa_vehiculo,
            "inro_documento_conductor"=>$this->nro_documento_conductor,
            "idistrito_ID_partida"=>$this->distrito_ID_partida,
            "idistrito_ID_llegada"=>$this->distrito_ID_llegada,
            "inumero_contenedor"=>$this->numero_contenedor,
            "icodigo_puerto"=>$this->codigo_puerto,
            "icliente_ID_subcotratista"=>$this->cliente_ID_subcotratista,
            "iguia_baja_ID"=>$this->guia_baja_ID,
            "iusuario_id"=>$this->usuario_id,
            "isalida_detalle_IDs"=>$this->salida_detalle_IDs

        ),0);
      if($ID>0){
        $this->getMessage="El registro se guardó correctamente.";
        $this->ID=$ID;
        return $ID;
      } else {
          throw new Exception("No se registró la información");
      }
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "guia_venta.insertar", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
function actualizar()
    {
    $cn =new connect_new();
    $retornar =0;
    try
    {
      $retornar=$cn->store_procedure_transa(
          "sp_guia_venta_Update",
            array(
              "retornar"=>$retornar,
    "iID"=>$this->ID,
    "ifactura_venta_ID"=>$this->factura_venta_ID,
    "iserie"=>$this->serie,
    "inumero"=>$this->numero,
    "inumero_concatenado"=>$this->numero_concatenado,
    "ifecha_emision"=> FormatTextToDate($this->fecha_emision, 'Y-m-d'),
    "inumero_orden_compra"=>$this->numero_orden_compra,
    "inumero_orden_venta"=>$this->numero_orden_venta,
    "ivehiculo_ID"=>$this->vehiculo_ID,
    "ichofer_ID"=>$this->chofer_ID,
    "iestado_ID"=>$this->estado_ID,
    "iobservacion"=>$this->observacion,
    "inumero_pagina"=>$this->numero_pagina,
    "ifecha_inicio_traslado"=>FormatTextToDate($this->fecha_inicio_traslado, 'Y-m-d'),
    "ipunto_partida"=>$this->punto_partida,
    "ipunto_llegada"=>$this->punto_llegada,
    "iempresa_transporte"=>$this->empresa_transporte,
    "iimpresion"=>$this->impresion,
    "isalida_ID"=>$this->salida_ID,
    "iopcion"=>$this->opcion,
    "inumero_producto"=>$this->numero_producto,
    "iempresa_ID"=>$this->empresa_ID,
    "icorrelativos_ID"=>$this->correlativos_ID,
    "iver_descripcion"=>$this->ver_descripcion,
    "iver_componente"=>$this->ver_componente,
    "iver_adicional"=>$this->ver_adicional,
    "iver_serie"=>$this->ver_serie,
    "iincluir_obsequios"=>$this->incluir_obsequios,
    "imotivo_traslado_ID"=>$this->motivo_traslado_ID,
    "idescripcion_motivo"=>$this->descripcion_motivo,
    "itransbordo"=>$this->transbordo,
    "ipeso_bruto_total"=>$this->peso_bruto_total,
    "inro_pallets"=>$this->nro_pallets,
    "imodalidad_traslado_ID"=>$this->modalidad_traslado_ID,
    "iruc_transportista"=>$this->ruc_transportista,
    "irazon_social_transportista"=>$this->razon_social_transportista,
    "inro_placa_vehiculo"=>$this->nro_placa_vehiculo,
    "inro_documento_conductor"=>$this->nro_documento_conductor,
    "idistrito_ID_partida"=>$this->distrito_ID_partida,
    "idistrito_ID_llegada"=>$this->distrito_ID_llegada,
    "inumero_contenedor"=>$this->numero_contenedor,
    "icodigo_puerto"=>$this->codigo_puerto,
    "icliente_ID_subcotratista"=>$this->cliente_ID_subcotratista,
    "iguia_baja_ID"=>$this->guia_baja_ID,
    "iusuario_mod_id"=>$this->usuario_mod_id
),0);
      $this->getMessage="Se actualizó la información";
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "guia_venta.actualizar", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  function actualizar_guia()
    {
    $cn =new connect_new();
    $retornar =0;
    try
    {
      $retornar=$cn->store_procedure_transa(
          "sp_guia_venta_UpdateInd",
            array(
                    "retornar"=>$retornar,
                    "iID"=>$this->ID,
                    "icliente_ID"=>$this->cliente_ID,
                    "ifecha_emision"=>FormatTextToDate($this->fecha_emision,'Y-m-d'),
                    "inumero_orden_compra"=>$this->numero_orden_compra,
                    "inumero_orden_venta"=>$this->numero_orden_venta,
                    "ivehiculo_ID"=>$this->vehiculo_ID,
                    "ichofer_ID"=>$this->chofer_ID,
                    "iestado_ID"=>$this->estado_ID,
                    "iobservacion"=>$this->observacion,
                    "ifecha_inicio_traslado"=>FormatTextToDate($this->fecha_inicio_traslado,'Y-m-d'),
                    "ipunto_partida"=>$this->punto_partida,
                    "ipunto_llegada"=>$this->punto_llegada,
                    "iempresa_transporte"=>$this->empresa_transporte,
                    "iempresa_ID"=>$this->empresa_ID,
                    "icorrelativos_ID"=>$this->correlativos_ID,
                    "imotivo_traslado_ID"=>$this->motivo_traslado_ID,
                    "idescripcion_motivo"=>$this->descripcion_motivo,
                    "ipeso_bruto_total"=>$this->peso_bruto_total,
                    "imodalidad_traslado_ID"=>$this->modalidad_traslado_ID,
                    "iruc_transportista"=>$this->ruc_transportista,
                    "irazon_social_transportista"=>$this->razon_social_transportista,
                    "inro_placa_vehiculo"=>$this->nro_placa_vehiculo,
                    "inro_documento_conductor"=>$this->nro_documento_conductor,
                    "idistrito_ID_partida"=>$this->distrito_ID_partida,
                    "idistrito_ID_llegada"=>$this->distrito_ID_llegada,
                    "icliente_ID_subcotratista"=>$this->cliente_ID_subcotratista,
                    "iguia_baja_ID"=>$this->guia_baja_ID,
                    "iusuario_mod_id"=>$this->usuario_mod_id
                ),0);
      $this->getMessage="Se actualizó la información";
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "guia_venta.actualizar", $ex->getMessage());
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
          "sp_guia_venta_getCount",
            array(
              "filtro"=>$filtro));
      return $resultado;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "guia_venta.getCount", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  static function getVista_Previa($array) {
       $cn = new connect_new();
       try {
           $dt=$cn->store_procedure_getGrid("sp_guia_venta_getVistaPrevia",$array);
           
           return $dt;
       } catch (Exception $ex) {
           log_error(__FILE__,"guia_venta.getVista_Previa", $ex->getMessage());
           throw new Exception('Ocurrio un error en la consulta');
       }
    }
    static function getFilasGuias($salida_ID) {
        $cn = new connect_new();
        try {
            $dt=$cn->store_procedure_getGrid("sp_guia_venta_getGuias",
            array(
                "isalida_ID"=>$salida_ID
            ));
            return $dt;
        } catch (Exception $ex) {
            
            log_error(__FILE__,"guia_venta.getFilasGuias", $ex->getMessage());
           throw new Exception('Ocurrio un error en el sistema');
        }
    }
    static function getGuia_SUNAT($guia_venta_ID,$tipo)
	{
            $cn =new connect_new();
            try
            {
                $dt=$cn->store_procedure_getGrid("sp_guia_venta_SUNAT",
                    array(
                        "iguia_venta_ID"=>$guia_venta_ID,
                        "tipo"=>$tipo
                    ));
                
                
                return $dt;
            }catch(Exception $ex)
            {
                log_error(__FILE__,"guia_venta.getGuia_SUNAT", $ex->getMessage());
                throw new Exception('Ocurrio un error en el sistema');
            }
	}
    static function getVistaDescarga($guia_venta_ID,$tipo)
    {
        $cn =new connect_new();
        try
        {
            $dt=$cn->store_procedure_getGrid("sp_guia_venta_getDescargar",
                array(
                    "iguia_venta_ID"=>$guia_venta_ID,
                    "tipo"=>$tipo
                ));


            return $dt;
        }catch(Exception $ex)
        {
            log_error(__FILE__,"guia_venta.getGuia_SUNAT", $ex->getMessage());
            throw new Exception('Ocurrio un error en el sistema');
        }
    }
    static function getVistaDescargaInd($guia_venta_ID,$tipo)
    {
        $cn =new connect_new();
        try
        {
            $dt=$cn->store_procedure_getGrid("sp_guia_venta_getDescargarInd",
                array(
                    "iguia_venta_ID"=>$guia_venta_ID,
                    "tipo"=>$tipo
                ));


            return $dt;
        }catch(Exception $ex)
        {
            log_error(__FILE__,"guia_venta.getGuia_SUNAT", $ex->getMessage());
            throw new Exception('Ocurrio un error en el sistema');
        }
    }
   function eliminar()
    {
    $cn =new connect_new();
    $retornar =0;
    try
    {
      $retornar=$cn->store_procedure_transa(
          "sp_guia_venta_Delete",
            array(
              "retornar"=>$retornar,
              "iID"=>$this->ID,
              "iusuario_mod_id"=>$this->usuario_mod_id ),0
            );
      if($retornar>0)$this->getMessage = "Se eliminó correctamente";
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "guia_venta.eliminar", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  /*
  static function getGrid($filtro = '', $desde = -1, $hasta = -1, $order = 'ID asc') {
        $cn = new connect_new();
        try {
            $q = 'Select ID,factura_venta_ID,numero,numero_concatenado,serie,DATE_FORMAT(fecha_emision,"%d/%m/%Y") as fecha_emision,numero_orden_compra,numero_orden_venta,vehiculo_ID,';
            $q.= 'chofer_ID,estado_ID,numero_pagina,DATE_FORMAT(fecha_inicio_traslado,"%d/%m/%Y") as fecha_inicio_traslado,punto_partida,punto_llegada';
             $q.= ',empresa_transporte,impresion,numero_producto,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id' ;
            $q.=' from guia_venta ';
            $q.=' where del=0 ';

            if ($filtro != '') {
                $q.=' and ' . $filtro;
            }

            $q.=' Order By ' . $order;

            if ($desde != -1 && $hasta != -1) {
                $q.=' Limit ' . $desde . ',' . $hasta;
            }
           //echo $q;
            $dt = $cn->getGrid($q);
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }*/
  static function getGrid($filtro="",$inicio=-1,$fin=-1,$orden="ID asc")
    {
    $cn =new connect_new();
    $retornar =0;
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_guia_venta_getGrid",
            array(
              "filtro"=>$filtro,
              "inicio"=>$inicio,
              "fin"=>$fin,
              "orden"=>$orden));
      return $dt;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "guia_venta.getGrid", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  static function getGrid1($filtro="",$inicio=-1,$fin=-1,$orden="ID asc")
    {
    $cn =new connect_new();
    $retornar =0;
    try
    {
      $dt=$cn->store_procedure_getGridParse(
          "sp_guia_venta_getGrid",
            array(
              "filtro"=>$filtro,
              "inicio"=>$inicio,
              "fin"=>$fin,
              "orden"=>$orden));
      return $dt;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "guia_venta.getGrid", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  static function getTabla($filtro="",$inicio=-1,$fin=-1,$orden="gv.ID asc")
    {
    $cn =new connect_new();
    $retornar =0;
    try
    {
        
      $dt=$cn->store_procedure_getGrid(
          "sp_guia_venta_getTabla",
            array(
              "filtro"=>$filtro,
              "inicio"=>$inicio,
              "fin"=>$fin,
              "orden"=>$orden));
      return $dt;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "guia_venta.getGrid", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
    static function getGridSalida($salida_ID)
	{
            $cn =new connect_new();
            try
            {
                $dt=$cn->store_procedure_getGrid("sp_guia_venta_getSalida",
                    array(
                        "isalida_ID"=>$salida_ID
                    ));
                
                
                return $dt;
            }catch(Exception $ex)
            {
                log_error(__FILE__,"guia_venta.getGuia_SUNAT", $ex->getMessage());
                throw new Exception('Ocurrio un error en el sistema');
            }
	}
    static function getGridFactura($factura_venta_ID)
	{
            $cn =new connect_new();
            try
            {
                $dt=$cn->store_procedure_getGrid("sp_guia_venta_getEmitidos",
                    array(
                        "ifactura_venta_ID"=>$factura_venta_ID
                    ));
                
                
                return $dt;
            }catch(Exception $ex)
            {
                log_error(__FILE__,"guia_venta.getGridFactura", $ex->getMessage());
                throw new Exception('Ocurrio un error en el sistema');
            }
	}
    function actualizarEstado(){
        $cn =new connect_new();
	$retornar=-1;
        try{
            
            $q='UPDATE guia_venta set estado_ID='.$this->estado_ID.',observacion="'.$this->observacion.'", usuario_mod_id='.$this->usuario_mod_id;
            $q.=', fdm=now() where del=0 and ID='.$this->ID;
            //echo $q;
            $retornar=$cn->transa($q);
            $this->getMessage='Se guardó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    function insertar_electronico()
    {
    $cn =new connect_new();
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_guia_venta_Insert_Electronico",
            array(
            "ifactura_venta_ID"=>$this->factura_venta_ID,
            "ifecha_emision"=>FormatTextToDate($this->fecha_emision,'Y-m-d'),
            "inumero_orden_compra"=>$this->numero_orden_compra,
            "inumero_orden_venta"=>$this->numero_orden_venta,
            "ivehiculo_ID"=>$this->vehiculo_ID,
            "ichofer_ID"=>$this->chofer_ID,
            "iestado_ID"=>$this->estado_ID,
            "iobservacion"=>$this->observacion,
            "inumero_pagina"=>$this->numero_pagina,
            "ifecha_inicio_traslado"=>FormatTextToDate($this->fecha_inicio_traslado,'Y-m-d'),
            "ipunto_partida"=>$this->punto_partida,
            "ipunto_llegada"=>$this->punto_llegada,
            "iempresa_transporte"=>$this->empresa_transporte,
            "iimpresion"=>$this->impresion,
            "isalida_ID"=>$this->salida_ID,
            "iopcion"=>$this->opcion,
            "inumero_producto"=>$this->numero_producto,
            "iempresa_ID"=>$this->empresa_ID,
            "icorrelativos_ID"=>$this->correlativos_ID,
            "iver_descripcion"=>$this->ver_descripcion,
            "iver_componente"=>$this->ver_componente,
            "iver_adicional"=>$this->ver_adicional,
            "iver_serie"=>$this->ver_serie,
            "iincluir_obsequios"=>$this->incluir_obsequios,
            "imotivo_traslado_ID"=>$this->motivo_traslado_ID,
            "idescripcion_motivo"=>$this->descripcion_motivo,
            "itransbordo"=>$this->transbordo,
            "ipeso_bruto_total"=>$this->peso_bruto_total,
            "inro_pallets"=>$this->nro_pallets,
            "imodalidad_traslado_ID"=>$this->modalidad_traslado_ID,
           
            "iruc_transportista"=>$this->ruc_transportista,
            "irazon_social_transportista"=>$this->razon_social_transportista,
            "inro_placa_vehiculo"=>$this->nro_placa_vehiculo,
            "inro_documento_conductor"=>$this->nro_documento_conductor,
            "idistrito_ID_partida"=>$this->distrito_ID_partida,
            "idistrito_ID_llegada"=>$this->distrito_ID_llegada,
            "inumero_contenedor"=>$this->numero_contenedor,
            "icodigo_puerto"=>$this->codigo_puerto,
            "icliente_ID_subcotratista"=>$this->cliente_ID_subcotratista,
            "iguia_baja_ID"=>$this->guia_baja_ID,
            "iusuario_id"=>$this->usuario_id

        ));
      //print_r($dt);
      if(count($dt)>0){
          $this->ID=$dt[0]['ID'];
          $this->serie=$dt[0]['serie'];
          $this->numero=$dt[0]['numero'];
          $this->numero_concatenado=$dt[0]['numero_concatenado'];
          $this->getMessage="Se guardó correctamente";
      }else{
          throw new Exception("No se registró la información");
      }
      /*if($ID>0){
        $this->getMessage="El registro se guardó correctamente.";
        $this->ID=$ID;
        return $ID;
      } else {
          throw new Exception("No se registró la información");
      }*/
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "guia_venta.insertar", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  function insertar_guia()
    {
    $cn =new connect_new();
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_guia_venta_Insert_Individual",
            array(
            "icliente_ID"=>$this->cliente_ID,
            "ifecha_emision"=>FormatTextToDate($this->fecha_emision,'Y-m-d'),
            "inumero_orden_compra"=>$this->numero_orden_compra,
            "inumero_orden_venta"=>$this->numero_orden_venta,
            "ivehiculo_ID"=>$this->vehiculo_ID,
            "ichofer_ID"=>$this->chofer_ID,
            "iestado_ID"=>$this->estado_ID,
            "iobservacion"=>$this->observacion,
            "ifecha_inicio_traslado"=>FormatTextToDate($this->fecha_inicio_traslado,'Y-m-d'),
            "ipunto_partida"=>$this->punto_partida,
            "ipunto_llegada"=>$this->punto_llegada,
            "iempresa_transporte"=>$this->empresa_transporte,
            "iempresa_ID"=>$this->empresa_ID,
            "icorrelativos_ID"=>$this->correlativos_ID,
            "imotivo_traslado_ID"=>$this->motivo_traslado_ID,
            "idescripcion_motivo"=>$this->descripcion_motivo,
            "ipeso_bruto_total"=>$this->peso_bruto_total,
            "imodalidad_traslado_ID"=>$this->modalidad_traslado_ID,
            "iruc_transportista"=>$this->ruc_transportista,
            "irazon_social_transportista"=>$this->razon_social_transportista,
            "inro_placa_vehiculo"=>$this->nro_placa_vehiculo,
            "inro_documento_conductor"=>$this->nro_documento_conductor,
            "idistrito_ID_partida"=>$this->distrito_ID_partida,
            "idistrito_ID_llegada"=>$this->distrito_ID_llegada,
            "iusuario_id"=>$this->usuario_id

        ));
      if(count($dt)>0){
          $this->ID=$dt[0]['ID'];
          $this->serie=$dt[0]['serie'];
          $this->numero=$dt[0]['numero'];
          $this->numero_concatenado=$dt[0]['numero_concatenado'];
          $this->getMessage="Se guardó correctamente";
      }else{
          throw new Exception("No se registró la información");
      }
      /*if($ID>0){
        $this->getMessage="El registro se guardó correctamente.";
        $this->ID=$ID;
        return $ID;
      } else {
          throw new Exception("No se registró la información");
      }*/
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "guia_venta.insertar", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
     static function getGuia_Venta_SUNAT($guia_venta_ID,$tipo)
	{
            $cn =new connect_new();
            try
            {
                $dt=$cn->store_procedure_getGrid("sp_guia_venta_EnviarSUNAT",
                    array(
                        "iguia_venta_ID"=>$guia_venta_ID,
                        "tipo"=>$tipo
                    ));
                
                
                return $dt;
            }catch(Exception $ex)
            {
                log_error(__FILE__,"guia_venta.getGuia_SUNAT", $ex->getMessage());
                throw new Exception('Ocurrio un error en el sistema');
            }
	}
}  
