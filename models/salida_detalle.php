<?php

class salida_detalle {
    private $ID;
    private $producto_ID;
    private $observacion;
    private $salida_ID;
    private $descripcion;
    private $cantidad;
    private $precio_venta_unitario_soles;
    private $precio_venta_unitario_dolares;
    private $precio_venta_subtotal_soles;
    private $precio_venta_subtotal_dolares;
    private $precio_venta_soles;
    private $precio_venta_dolares;
    private $igv;
    private $vigv_soles;
    private $vigv_dolares;
    private $salida_detalle_ID;
    private $estado_ID;
    private $cotizacion_detalle_ID;
    private $ver_precio;
    private $obsequio;
    private $tipo;
    private $tipo_ID;
    private $isc;
    private $otro_impuesto;
    private $descuento;
    private $precio_referencial;
    private $suma;
    private $tipo_precio_venta_unitario_ID;
    private $impuestos_tipo_ID;
    private $peso;
    private $tipo_sistema_calculo_isc_ID;
    private $descuento_unitario;
    private $pu_incluye_igv;
    private $pu_incluye_isc;
    private $descuento_porcentaje;
    private $isc_porcentaje;
    private $isc_valor_referencial;
    private $isc_activo;
    private $valor_venta_soles;
    private $valor_venta_dolares;
    private $visc_soles;
    private $visc_dolares;
    private $descuento_soles;
    private $descuento_dolares;
    private $valor_unitario;
    private $usuario_id;
    private $usuario_mod_id;
    Private $verBotonSerie;
    Private $verBotonTerminar;
    private $dtInventario;


    //1 producto
//2 producto con componente (se convierte en una descripción y no descuenta stock)
//3 Componente (calcula el valor de venta del padre)
//4 Adicional (producto adiconal lleva un ID del un padre)
//5 producto con componente y adicional (se convierte en descripción, los componentes que lo integran hacen la suma de la venta total , el adicional suma al precio   )
//6 Producto con adicional
//7  Obsequio (se convierte en obsequio el costo de venta es 0)

    Private $message;
    private $oMoneda;
    private $salida_detalle_padre_ID;
    private $oProducto;
    private $oSalida;
    private $precio_unitario;
    private $subtotal;
    private $vigv;
    private $total;
    private $linea_ID;
    private $categoria_ID;
    private $dtLinea;
    private $dtCategoria;
    private $stock;
    private $componente;
    private $adicional;
    private $adicional_soles;
    private $adicional_dolares;
    private $subtotal_soles1;
    private $subtotal_dolares1;
    private $internos;
    private $bloquear_edicion;
    private $producto;
    public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"
        if (property_exists('salida_detalle', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('salida_detalle', $temporal)) {
            return $this->$temporal;
        }

        // Retorna nulo si no existe
        return null;
    }
    function __construct()
    {
        $this->observacion="";
        $this->descripcion="";
        $this->cantidad=0;
        $this->precio_venta_unitario_soles=0;
        $this->precio_venta_unitario_dolares=0;
        $this->precio_venta_subtotal_soles=0;
        $this->precio_venta_subtotal_dolares=0;
        $this->precio_venta_soles=0;
        $this->precio_venta_dolares=0;
        $this->igv=0;
        $this->vigv_soles=0;
        $this->vigv_dolares=0;
        $this->salida_detalle_ID=0;
        $this->estado_ID=0;
        $this->cotizacion_detalle_ID=0;
        $this->ver_precio=0;
        $this->obsequio=0;
        $this->tipo=0;
        $this->tipo_ID=0;
        $this->isc=0;
        $this->otro_impuesto=0;
        $this->descuento=0;
        $this->precio_referencial=0;
        $this->suma=0;
        $this->peso=0;
        $this->descuento_unitario=0;
        $this->pu_incluye_igv=0;
        $this->pu_incluye_isc=0;
        $this->descuento_porcentaje=0;
        $this->isc_porcentaje=0;
        $this->isc_valor_referencial=0;
        $this->isc_activo=0;
        $this->valor_venta_soles=0;
        $this->valor_venta_dolares=0;
        $this->visc_soles=0;
        $this->visc_dolares=0;
        $this->descuento_soles=0;
        $this->descuento_dolares=0;
        $this->valor_unitario=0;
        $this->usuario_id=$_SESSION["usuario_ID"];
        $this->usuario_mod_id=$_SESSION["usuario_ID"];

      }
    function __destruct()
    {
        $this->observacion;
        $this->descripcion;
        $this->cantidad;
        $this->precio_venta_unitario_soles;
        $this->precio_venta_unitario_dolares;
        $this->precio_venta_subtotal_soles;
        $this->precio_venta_subtotal_dolares;
        $this->precio_venta_soles;
        $this->precio_venta_dolares;
        $this->igv;
        $this->vigv_soles;
        $this->vigv_dolares;
        $this->salida_detalle_ID;
        $this->estado_ID;
        $this->cotizacion_detalle_ID;
        $this->ver_precio;
        $this->obsequio;
        $this->tipo;
        $this->tipo_ID;
        $this->isc;
        $this->otro_impuesto;
        $this->descuento;
        $this->precio_referencial;
        $this->suma;
        $this->peso;
        $this->descuento_unitario;
        $this->pu_incluye_igv;
        $this->pu_incluye_isc;
        $this->descuento_porcentaje;
        $this->isc_porcentaje;
        $this->isc_valor_referencial;
        $this->isc_activo;
        $this->valor_venta_soles;
        $this->valor_venta_dolares;
        $this->visc_soles;
        $this->visc_dolares;
        $this->descuento_soles;
        $this->descuento_dolares;
        $this->valor_unitario;
        $this->usuario_id;
        $this->usuario_mod_id;

    }
    function insertar() {
        
        
        $retorna = -1;
        try {
            $q = 'select ifnull(max(ID),0)+1 as ID from salida_detalle;';
            $cn = new connect_new();
            $ID=$cn->getData($q);

            $q = 'insert into salida_detalle (ID,producto_ID,observacion,salida_ID,descripcion,cantidad,';
            $q.='precio_venta_unitario_soles,precio_venta_unitario_dolares,precio_venta_subtotal_soles,precio_venta_subtotal_dolares,';
            $q.='precio_venta_soles,precio_venta_dolares,igv,vigv_soles,vigv_dolares,salida_detalle_ID,ver_precio,estado_ID,cotizacion_detalle_ID,';
            $q.='usuario_id,tipo_ID,impuestos_tipo_ID,tipo_precio_venta_unitario_ID)values ';
            $q.='('.$ID.','.$this->producto_ID.',"'.$this->observacion.'",'.$this->salida_ID.',"'.FormatTextSave($this->descripcion).'",'.$this->cantidad.',';
            $q.=$this->precio_venta_unitario_soles.','.$this->precio_venta_unitario_dolares.','.$this->precio_venta_subtotal_soles.','.$this->precio_venta_subtotal_dolares.',';
            $q.=$this->precio_venta_soles.','.$this->precio_venta_dolares.','.$this->igv.','.$this->vigv_soles.','.$this->vigv_dolares.','.$this->salida_detalle_ID.',';
            $q.=$this->ver_precio . ','.$this->estado_ID.','.$this->cotizacion_detalle_ID.','.$this->usuario_id.','.$this->tipo_ID.','.$this->impuestos_tipo_ID.','.$this->tipo_precio_venta_unitario_ID.')';
           $cn1 = new connect_new();
            $retorna = $cn1->transa($q);

            $this->ID=$ID;
            $this->message = 'Se guardó correctamente';
            return $retorna;
        } catch (Exception $ex) {

            throw new Exception($q);
        }
    }
    function insertar_new()
    {
    $cn =new connect_new();
    try
    {
        $ID=$cn->store_procedure_transa(
            "sp_salida_detalle_Insert",
            array(
            "iID"=>0,
            "iproducto_ID"=>$this->producto_ID,
            "iobservacion"=>$this->observacion,
            "isalida_ID"=>$this->salida_ID,
            "idescripcion"=>$this->descripcion,
            "icantidad"=>$this->cantidad,
            "iprecio_venta_unitario_soles"=>$this->precio_venta_unitario_soles,
            "iprecio_venta_unitario_dolares"=>$this->precio_venta_unitario_dolares,
            "iprecio_venta_subtotal_soles"=>$this->precio_venta_subtotal_soles,
            "iprecio_venta_subtotal_dolares"=>$this->precio_venta_subtotal_dolares,
            "iprecio_venta_soles"=>$this->precio_venta_soles,
            "iprecio_venta_dolares"=>$this->precio_venta_dolares,
            "iigv"=>$this->igv,
            "ivigv_soles"=>$this->vigv_soles,
            "ivigv_dolares"=>$this->vigv_dolares,
            "isalida_detalle_ID"=>$this->salida_detalle_ID,
            "iestado_ID"=>$this->estado_ID,
            "icotizacion_detalle_ID"=>$this->cotizacion_detalle_ID,
            "iver_precio"=>$this->ver_precio,
            "iobsequio"=>$this->obsequio,
            "itipo"=>$this->tipo,
            "itipo_ID"=>$this->tipo_ID,
            "iisc"=>$this->isc,
            "iotro_impuesto"=>$this->otro_impuesto,
            "idescuento"=>$this->descuento,
            "iprecio_referencial"=>$this->precio_referencial,
            "isuma"=>$this->suma,
            "itipo_precio_venta_unitario_ID"=>$this->tipo_precio_venta_unitario_ID,
            "iimpuestos_tipo_ID"=>$this->impuestos_tipo_ID,
            "ipeso"=>$this->peso,
            "itipo_sistema_calculo_isc_ID"=>$this->tipo_sistema_calculo_isc_ID,
            "idescuento_unitario"=>$this->descuento_unitario,
            "ipu_incluye_igv"=>$this->pu_incluye_igv,
            "ipu_incluye_isc"=>$this->pu_incluye_isc,
            "idescuento_porcentaje"=>$this->descuento_porcentaje,
            "iisc_porcentaje"=>$this->isc_porcentaje,
            "iisc_valor_referencial"=>$this->isc_valor_referencial,
            "iisc_activo"=>$this->isc_activo,
            "ivalor_venta_soles"=>$this->valor_venta_soles,
            "ivalor_venta_dolares"=>$this->valor_venta_dolares,
            "ivisc_soles"=>$this->visc_soles,
            "ivisc_dolares"=>$this->visc_dolares,
            "idescuento_soles"=>$this->descuento_soles,
            "idescuento_dolares"=>$this->descuento_dolares,
            "ivalor_unitario"=>$this->valor_unitario,
            "iusuario_id"=>$this->usuario_id
            ),0);
            $this->ID=$ID;
            return $ID;
        }catch(Exeption $ex)
        {
          throw new Exception($ex->getMessage());
        }
    }
    function actualizar_new()
    {
    $cn =new connect_new();
    $retornar =0;
    try
    {
      $retornar=$cn->store_procedure_transa(
          "sp_salida_detalle_Update",
            array(
              "retornar"=>$retornar,
                "iID"=>$this->ID,
                "iproducto_ID"=>$this->producto_ID,
                "iobservacion"=>$this->observacion,
                "isalida_ID"=>$this->salida_ID,
                "idescripcion"=>$this->descripcion,
                "icantidad"=>$this->cantidad,
                "iprecio_venta_unitario_soles"=>$this->precio_venta_unitario_soles,
                "iprecio_venta_unitario_dolares"=>$this->precio_venta_unitario_dolares,
                "iprecio_venta_subtotal_soles"=>$this->precio_venta_subtotal_soles,
                "iprecio_venta_subtotal_dolares"=>$this->precio_venta_subtotal_dolares,
                "iprecio_venta_soles"=>$this->precio_venta_soles,
                "iprecio_venta_dolares"=>$this->precio_venta_dolares,
                "iigv"=>$this->igv,
                "ivigv_soles"=>$this->vigv_soles,
                "ivigv_dolares"=>$this->vigv_dolares,
                "isalida_detalle_ID"=>$this->salida_detalle_ID,
                "iestado_ID"=>$this->estado_ID,
                "icotizacion_detalle_ID"=>$this->cotizacion_detalle_ID,
                "iver_precio"=>$this->ver_precio,
                "iobsequio"=>$this->obsequio,
                "itipo"=>$this->tipo,
                "itipo_ID"=>$this->tipo_ID,
                "iisc"=>$this->isc,
                "iotro_impuesto"=>$this->otro_impuesto,
                "idescuento"=>$this->descuento,
                "iprecio_referencial"=>$this->precio_referencial,
                "isuma"=>$this->suma,
                "itipo_precio_venta_unitario_ID"=>$this->tipo_precio_venta_unitario_ID,
                "iimpuestos_tipo_ID"=>$this->impuestos_tipo_ID,
                "ipeso"=>$this->peso,
                "itipo_sistema_calculo_isc_ID"=>$this->tipo_sistema_calculo_isc_ID,
                "idescuento_unitario"=>$this->descuento_unitario,
                "ipu_incluye_igv"=>$this->pu_incluye_igv,
                "ipu_incluye_isc"=>$this->pu_incluye_isc,
                "idescuento_porcentaje"=>$this->descuento_porcentaje,
                "iisc_porcentaje"=>$this->isc_porcentaje,
                "iisc_valor_referencial"=>$this->isc_valor_referencial,
                "iisc_activo"=>$this->isc_activo,
                "ivalor_venta_soles"=>$this->valor_venta_soles,
                "ivalor_venta_dolares"=>$this->valor_venta_dolares,
                "ivisc_soles"=>$this->visc_soles,
                "ivisc_dolares"=>$this->visc_dolares,
                "ivisc_dolares"=>$this->visc_dolares,
                "idescuento_soles"=>$this->descuento_soles,
                "idescuento_dolares"=>$this->descuento_dolares,
                "valor_unitario"=>$this->valor_unitario,
                "iusuario_mod_id"=>$this->usuario_mod_id
                ),0);
                $this->message="Se actualizó correctamente";
        return $retornar;
        }catch(Exeption $ex)
        {
            log_error(__FILE__, "salida_detalle.actualizar_new", $ex->getMessage());
            throw new Exception($ex->getMessage());
        }
  }
    function actualizar() {
        $cn = new connect_new();
        $retornar = -1;
        try {
            $cotizacion_detalle_ID='NULL';
            if(isset($this->cotizacion_detalle_ID)){
                $cotizacion_detalle_ID=$this->cotizacion_detalle_ID;
            }
            $q = 'update salida_detalle set producto_ID='.$this->producto_ID.',descripcion="'.FormatTextSave($this->descripcion);
            $q.='",cantidad='.$this->cantidad.',precio_venta_unitario_soles='.$this->precio_venta_unitario_soles.',precio_venta_subtotal_soles='.$this->precio_venta_subtotal_soles;
            $q.=',precio_venta_subtotal_dolares='.$this->precio_venta_subtotal_dolares.',precio_venta_unitario_dolares='.$this->precio_venta_unitario_dolares.',igv='.$this->igv;
            $q.=',vigv_soles='.$this->vigv_soles.',vigv_dolares='.$this->vigv_dolares.',precio_venta_soles='.$this->precio_venta_soles.',precio_venta_dolares='.$this->precio_venta_dolares;
            $q.=',salida_detalle_ID='.$this->salida_detalle_ID.',estado_ID='.$this->estado_ID.', cotizacion_detalle_ID='.$cotizacion_detalle_ID .',ver_precio='.$this->ver_precio.',tipo_ID='.$this->tipo_ID;
            $q.=',impuestos_tipo_ID='.$this->impuestos_tipo_ID.',tipo_precio_venta_unitario_ID='.$this->tipo_precio_venta_unitario_ID.',usuario_mod_id='.$this->usuario_mod_id;
            $q.=', fdm=now() where del=0 and id=' . $this->ID;
            $retornar = $cn->transa($q);
            $this->message = 'Se guardó correctamente';
        //echo $q;
            return $retornar;
        } catch (Exception $ex) {
             throw new Exception($q);
        }
    }
    function actualizarCosto(){
        $cn =new connect_new();
	$retornar=-1;
        try{
            $q='update salida_detalle set precio_venta_unitario='.$this->precio_venta_unitario.', precio_venta='.$this->precio_venta.', usuario_mod_id='. $this->usuario_mod_id;
            $q.=', fdm=now() where del=0 and id='.$this->ID;
            $retornar=$cn->transa($q);
            $this->message='Se guardó correctamente';
            //echo $q;
            return $retornar;
        } catch (Exception $ex) {

        }
    }
    function actualizar_costos_padre($salida_ID,$usuario_mod_id){
        $cn =new connect_new();
	$retornar=-1;
        try{
            $q='call sp_salida_Actualizar_Costo_Padre('.$salida_ID.','.$usuario_mod_id.')';
            $retornar=$cn->transa($q);
            $this->message='Se guardó correctamente';
            //echo $q;
            return $retornar;
        } catch (Exception $ex) {

        }
    }
    function actualizarTipo(){
        $cn =new connect_new();
	$retornar=-1;
        try{
            $q='update salida_detalle set tipo_ID='.$this->tipo_ID;
            $q.=' where ID='.$this->ID;
            $retornar=$cn->transa($q);
            //$this->message='Se guardó correctamente';
            //echo $q;
            return $retornar;
        } catch (Exception $ex) {

        }
    }
    function actualizarCK() {
        $cn = new connect_new();
        $retornar = -1;
        try {
            $q = 'update salida_detalle set ver_precio=' . $this->ver_precio. ', usuario_mod_id=' . $this->usuario_mod_id;
            $q.=', fdm=now() where del=0 and id=' . $this->ID;
            $retornar = $cn->transa($q);
            $this->message = 'Se guardó correctamente';
			//echo $q;
            return $q;
        } catch (Exception $ex) {
             throw new Exception("Ocurrio un error en la consulta");
        }
    }
    function eliminar() {
        $cn = new connect_new();
        $retornar = -1;
        try {

            $q = 'UPDATE salida_detalle SET del=1,usuario_mod_id=' . $this->usuario_mod_id . ', fdm=Now()';
            $q.=' WHERE del=0 and ID=' . $this->ID;
            //echo $q;
            $retornar = $cn->transa($q);

            $this->message = 'Se eliminó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }
/*
    static function getCount($filtro = '') {
        $cn = new connect_new();
        try {
            $q = 'select count(ID) ';
            $q.=' FROM salida_detalle';
            $q.=' where del=0 ';

            if ($filtro != '') {
                $q.=' and ' . $filtro;
            }
            //echo $q;
            $resultado = $cn->getData($q);

            return $resultado;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }*/
    static function getCount($filtro="")
    {
    $cn =new connect_new();
    $retornar =0;
    try
    {
      $resultado=$cn->store_procedure_getData(
          "sp_salida_detalle_getCount",
            array(
              "filtro"=>$filtro));
      return $resultado;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "salida_detalle.getCount", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
      static function getByID($ID)
    {
    $cn =new connect_new();
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_salida_detalle_getByID",
          array("iID"=>$ID));
      $osalida_detalle=null;
      foreach($dt as $item)
      {
        $osalida_detalle= new salida_detalle();
        $osalida_detalle->ID=$item["ID"];
        $osalida_detalle->producto_ID=$item["producto_ID"];
        $osalida_detalle->observacion=$item["observacion"];
        $osalida_detalle->salida_ID=$item["salida_ID"];
        $osalida_detalle->descripcion=$item["descripcion"];
        $osalida_detalle->cantidad=$item["cantidad"];
        $osalida_detalle->precio_venta_unitario_soles=$item["precio_venta_unitario_soles"];
        $osalida_detalle->precio_venta_unitario_dolares=$item["precio_venta_unitario_dolares"];
        $osalida_detalle->precio_venta_subtotal_soles=$item["precio_venta_subtotal_soles"];
        $osalida_detalle->precio_venta_subtotal_dolares=$item["precio_venta_subtotal_dolares"];
        $osalida_detalle->precio_venta_soles=$item["precio_venta_soles"];
        $osalida_detalle->precio_venta_dolares=$item["precio_venta_dolares"];
        $osalida_detalle->igv=$item["igv"];
        $osalida_detalle->vigv_soles=$item["vigv_soles"];
        $osalida_detalle->vigv_dolares=$item["vigv_dolares"];
        $osalida_detalle->salida_detalle_ID=$item["salida_detalle_ID"];
        $osalida_detalle->estado_ID=$item["estado_ID"];
        $osalida_detalle->cotizacion_detalle_ID=$item["cotizacion_detalle_ID"];
        $osalida_detalle->ver_precio=$item["ver_precio"];
        $osalida_detalle->obsequio=$item["obsequio"];
        $osalida_detalle->tipo=$item["tipo"];
        $osalida_detalle->tipo_ID=$item["tipo_ID"];
        $osalida_detalle->isc=$item["isc"];
        $osalida_detalle->otro_impuesto=$item["otro_impuesto"];
        $osalida_detalle->descuento=$item["descuento"];
        $osalida_detalle->precio_referencial=$item["precio_referencial"];
        $osalida_detalle->suma=$item["suma"];
        $osalida_detalle->tipo_precio_venta_unitario_ID=$item["tipo_precio_venta_unitario_ID"];
        $osalida_detalle->impuestos_tipo_ID=$item["impuestos_tipo_ID"];
        $osalida_detalle->peso=$item["peso"];
        $osalida_detalle->tipo_sistema_calculo_isc_ID=$item["tipo_sistema_calculo_isc_ID"];
        $osalida_detalle->descuento_unitario=$item["descuento_unitario"];
        $osalida_detalle->pu_incluye_igv=$item["pu_incluye_igv"];
        $osalida_detalle->pu_incluye_isc=$item["pu_incluye_isc"];
        $osalida_detalle->descuento_porcentaje=$item["descuento_porcentaje"];
        $osalida_detalle->isc_porcentaje=$item["isc_porcentaje"];
        $osalida_detalle->isc_valor_referencial=$item["isc_valor_referencial"];
        $osalida_detalle->isc_activo=$item["isc_activo"];
        $osalida_detalle->valor_venta_soles=$item["valor_venta_soles"];
        $osalida_detalle->valor_venta_dolares=$item["valor_venta_dolares"];
        $osalida_detalle->visc_soles=$item["visc_soles"];
        $osalida_detalle->visc_dolares=$item["visc_dolares"];
        $osalida_detalle->descuento_soles=$item["descuento_soles"];
        $osalida_detalle->descuento_dolares=$item["descuento_dolares"];
        $osalida_detalle->valor_unitario=$item["valor_unitario"];
        $osalida_detalle->usuario_id=$item["usuario_id"];
        $osalida_detalle->usuario_mod_id=$item["usuario_mod_id"];

      }
      return $osalida_detalle;
    }catch(Exeption $ex)
    {
        log_error(__FILE__, "salida_detalle.getByID", $ex->getMessage());
        throw new Exception($ex->getMessage());
    }
  }
    /*static function getByID($ID) {
        $cn = new connect_new();
        try {
            $q = 'SELECT ID,producto_ID,observacion,salida_ID,descripcion,cantidad,precio_venta_unitario_soles,';
            $q.='precio_venta_unitario_dolares,precio_venta_subtotal_soles,precio_venta_subtotal_dolares,precio_venta_soles,precio_venta_dolares,';
            $q.='igv,vigv_soles,vigv_dolares,salida_detalle_ID,estado_ID,cotizacion_detalle_ID,ver_precio,obsequio,tipo_ID,usuario_id,tipo_precio_venta_unitario_ID,impuestos_tipo_ID,ifNull(usuario_mod_id,-1) as usuario_mod_id';
            $q.=' FROM salida_detalle ';
            $q.=' where del=0 and ID='.$ID;
            //echo $q;
            $dt = $cn->getGrid($q);
            $osalida_Detalle = null;

            foreach ($dt as $item) {
                $osalida_Detalle = new salida_detalle();

                $osalida_Detalle->ID=$item['ID'];
                $osalida_Detalle->producto_ID=$item['producto_ID'];
                $osalida_Detalle->observacion=$item['observacion'];
                $osalida_Detalle->salida_ID=$item['salida_ID'];
                $osalida_Detalle->descripcion=$item['descripcion'];
                $osalida_Detalle->cantidad=$item['cantidad'];
                $osalida_Detalle->precio_venta_unitario_soles=$item['precio_venta_unitario_soles'];
                $osalida_Detalle->precio_venta_unitario_dolares=$item['precio_venta_unitario_dolares'];
                $osalida_Detalle->precio_venta_subtotal_soles=$item['precio_venta_subtotal_soles'];
                $osalida_Detalle->precio_venta_subtotal_dolares=$item['precio_venta_subtotal_dolares'];
                $osalida_Detalle->precio_venta_soles=$item['precio_venta_soles'];
                $osalida_Detalle->precio_venta_dolares=$item['precio_venta_dolares'];
                $osalida_Detalle->igv=$item['igv'];
                $osalida_Detalle->vigv_soles=$item['vigv_soles'];
                $osalida_Detalle->vigv_dolares=$item['vigv_dolares'];
                $osalida_Detalle->salida_detalle_ID=$item['salida_detalle_ID'];
                $osalida_Detalle->estado_ID=$item['estado_ID'];
                $osalida_Detalle->cotizacion_detalle_ID=$item['cotizacion_detalle_ID'];
                $osalida_Detalle->ver_precio=$item['ver_precio'];
                $osalida_Detalle->obsequio=$item['obsequio'];
                $osalida_Detalle->tipo_ID=$item['tipo_ID'];
                $osalida_Detalle->tipo_precio_venta_unitario_ID=$item['tipo_precio_venta_unitario_ID'];
                $osalida_Detalle->impuestos_tipo_ID=$item['impuestos_tipo_ID'];
                
                $osalida_Detalle->usuario_id=$item['usuario_id'];
                $osalida_Detalle->usuario_mod_id=$item['usuario_mod_id'];


            }
            return  $osalida_Detalle;
        } catch (Exeption $ex) {
            throw new Exception($q);
        }
    }*/
/*
    static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='ID asc') {
        $cn = new connect_new();
        try {
            $dt=$cn->store_procedure_getGrid("sp_salida_detalle_getComponentes",
            array(
                "salida_detalle_ID_padre"=>$salida_detalle_ID_padre
            ));
            $q = 'SELECT ID,producto_ID,observacion,salida_ID,descripcion,cantidad,precio_venta_unitario_soles,';
            $q.='precio_venta_unitario_dolares,precio_venta_subtotal_soles,precio_venta_subtotal_dolares,precio_venta_soles,precio_venta_dolares,';
            $q.='igv,vigv_soles,vigv_dolares,salida_detalle_ID,estado_ID,ver_precio,obsequio,cotizacion_detalle_ID,tipo_ID,tipo_precio_venta_unitario_ID,usuario_id,ifNull(usuario_mod_id,-1) as usuario_mod_id';
            $q.=' FROM salida_detalle ';
            $q.=' where del=0 ';

            if($filtro!=''){
                $q.=' and '.$filtro;
            }

		$q.=' Order By '.$order;

            if($desde!=-1&&$hasta!=-1){
                    $q.=' Limit '.$desde.','.$hasta;
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
          "sp_salida_detalle_getGrid",
            array(
              "filtro"=>$filtro,
              "inicio"=>$inicio,
              "fin"=>$fin,
              "orden"=>$orden));
      return $dt;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "salida_detalle.getGrid", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
     static function getGridLista($filtro='',$desde=-1,$hasta=-1,$order='ovd.ID asc') {
        $cn = new connect_new();
        try {
            $q = 'select ovd.ID,ovd.salida_ID, ovd.cantidad,ovd.descripcion,pro.nombre as producto, um.nombre as unidad_medida,pro.peso,ovd.ver_precio,';
            $q.='ovd.precio_venta_unitario_soles,ovd.precio_venta_unitario_dolares,ovd.precio_venta_subtotal_soles,ovd.precio_venta_subtotal_dolares,ovd.vigv_soles,ovd.vigv_dolares,ovd.precio_venta_soles,ovd.precio_venta_dolares ';
            $q.=' from salida_detalle ovd, producto pro, unidad_medida um, salida ov';
            $q.=' where ovd.salida_ID=ov.ID and ovd.producto_ID=pro.ID and pro.unidad_medida_ID=um.ID';
            $q.=' and ovd.del=0';

            if($filtro!=''){
                $q.=' and '.$filtro;
            }

		$q.=' Order By '.$order;

            if($desde!=-1&&$hasta!=-1){
                    $q.=' Limit '.$desde.','.$hasta;
            }
            //echo $q;
            $dt = $cn->getGrid($q);
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    function verificarDuplicado() {
        $cn = new connect_new();
        $retornar = -1;
        try {
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }
      static function getFilasComponentes($salida_detalle_ID_padre) {
        $cn = new connect_new();
        try {
            $dt=$cn->store_procedure_getGrid("sp_salida_detalle_getComponentes",
            array(
                "salida_detalle_ID_padre"=>$salida_detalle_ID_padre
            ));
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    static function getFilasAdicionales($salida_detalle_ID_padre) {
        $cn = new connect_new();
        try {
            $dt=$cn->store_procedure_getGrid("sp_salida_detalle_getAdicionales",
            array(
                "salida_detalle_ID_padre"=>$salida_detalle_ID_padre
            ));
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    static function getFilasDetalleComprobante($salida_ID,$ver_descripcion,$ver_componente,$ver_adicional,$ver_serie,$adicionar_obsequio) {
        $cn = new connect_new();
        try {
            $dt=$cn->store_procedure_getGrid("sp_factura_venta_getFilasDetalle",
            array(
                "isalida_ID"=>$salida_ID,
                "ver_descripcion"=>$ver_descripcion,
                "ver_componente"=>$ver_componente,
                "ver_adicional"=>$ver_adicional,
                "ver_serie"=>$ver_serie,
                "adicionar_obsequio"=>$adicionar_obsequio
            ));
            return $dt;
        } catch (Exception $ex) {
            log_error(__FILE__, "salida_detalle.getFilasDetalleComprobante", $ex->getMessage());
            throw new Exception($q);
        }
    }
    static function getFilasDetalleGuia($salida_ID,$ver_descripcion,$ver_componente,$ver_adicional,$ver_serie,$adicionar_obsequio) {
        $cn = new connect_new();
        try {
            $dt=$cn->store_procedure_getGrid("sp_guia_venta_getFilasDetalle",
            array(
                "isalida_ID"=>$salida_ID,
                "ver_descripcion"=>$ver_descripcion,
                "ver_componente"=>$ver_componente,
                "ver_adicional"=>$ver_adicional,
                "ver_serie"=>$ver_serie,
                "adicionar_obsequio"=>$adicionar_obsequio
            ));
            return $dt;
        } catch (Exception $ex) {
            log_error(__FILE__, "salida_detalle.getFilasDetalleComprobante", $ex->getMessage());
            throw new Exception("Ocurrió un error en la conexión");
        }
    }
    static function getEstructura($salida_ID,$ver_descripcion,$ver_componente,$ver_adicional,$ver_serie,$incluir_obsequios) {
        $cn = new connect_new();
        try {
            $dt=$cn->store_procedure_getGrid("sp_salida_detalle_getEstructura",
            array(
                "isalida_ID"=>$salida_ID,
                "iver_descripcion"=>$ver_descripcion,
                "iver_componente"=>$ver_componente,
                "iver_adicional"=>$ver_adicional,
                "iver_serie"=>$ver_serie,
                "iincluir_obsequios"=>$incluir_obsequios
            ));
            return $dt;
        } catch (Exception $ex) {
            log_error(__FILE__, "salida_detalle.getEstructura", $ex->getMessage());
            throw new Exception("Ocurrió un error en la conexión");
        }
    }
}
