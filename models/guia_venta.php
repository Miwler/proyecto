<?php

class guia_venta {

    private $ID;
    private $factura_venta_ID;
    private $serie;
    private $fecha_emision;
    private $orden_pedido;
    private $orden_ingreso;
    private $vehiculo_ID;
    private $chofer_ID;
    private $estado_ID;
    private $observacion;
    private $numero_pagina;
    
    private $fecha_inicio_traslado;
    private $punto_partida;
    private $punto_llegada;
    private $empresa_transporte;
    private $salida_ID ;
    private $usuario_id;
    private $numero;
    Private $numero_concatenado;
    private $numero_producto;
    private $fdc;
    private $usuario_mod_id;
    private $impresion;
    private $imprimir_factura;
    private $imprimir_guia;
    private $vista_previa;
    private $correlativos_ID;
    Private $message;
    
    Private $moneda_ID;
    
    Private $ver_vista_previa;
    Private $ver_imprimir;
    Private $dtVehiculo;
    Private $dtChofer;
    private $dtSerie;
    private $estado;
    private $opcion;

    public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
        if (property_exists('guia_venta', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('guia_venta', $temporal)) {
            return $this->$temporal;
        }

        // Retorna nulo si no existe
        return null;
    }

    function insertar() {
        $cn = new connect();
        $retornar = -1;
        try {
            $fecha_emision='NULL';
            if($this->fecha_emision!=null){
                $fecha_emision='"'.FormatTextToDate($this->fecha_emision,'Y-m-d').'"';
            }
            $fecha_inicio_traslado='NULL';
            if($this->fecha_inicio_traslado!=null){
                $fecha_inicio_traslado='"'.FormatTextToDate($this->fecha_inicio_traslado,'Y-m-d').'"';
            }
            $chofer='NULL';
            if($this->chofer_ID!=null){
                $chofer=$this->chofer_ID;
            }
            $vehiculo='NULL';
            if($this->vehiculo_ID!=null){
                $vehiculo=$this->vehiculo_ID;
            }
           
            $q = 'select ifnull(max(ID),0)+1 from guia_venta';
            $ID=$cn->getData($q);
            $q = 'insert into guia_venta(ID,factura_venta_ID,serie,fecha_emision,orden_pedido,orden_ingreso,';
            $q.='numero,numero_concatenado,vehiculo_ID,chofer_ID,estado_ID,fecha_inicio_traslado,punto_partida,punto_llegada,';
            $q.='empresa_transporte,salida_ID,opcion,numero_producto,usuario_id)';
            $q.='values('.$ID.','.$this->factura_venta_ID.',"'.$this->serie.'",'. $fecha_emision ;
            $q.=',"'. $this->orden_pedido.'","'.$this->orden_ingreso.'",'.$this->numero.',"'.$this->numero_concatenado.'",'.$vehiculo.','.$chofer.','.$this->estado_ID;
            $q.=','.$fecha_inicio_traslado.',"'.$this->punto_partida.'","'.$this->punto_llegada.'","'.$this->empresa_transporte.'",'. $this->salida_ID.','.$this->opcion.','.$this->numero_producto.','.$this->usuario_id.')';
            //echo $q;
            $retornar = $cn->transa($q);

            
            $this->ID = $ID;
            $this->message = 'Se registró correctamente';
            return $retornar;
        } catch (Exception $ex) {

            throw new Exception($q);
        }
    }

    function actualizar() {
        $cn = new connect();
        $retornar = -1;
        try {
             $fecha_emision='NULL';
            if($this->fecha_emision!=null){
                $fecha_emision='"'.FormatTextToDate($this->fecha_emision,'Y-m-d').'"';
            }
            $fecha_inicio_traslado='NULL';
            if($this->fecha_inicio_traslado!=null){
                $fecha_inicio_traslado='"'.FormatTextToDate($this->fecha_inicio_traslado,'Y-m-d').'"';
            }
             $chofer='NULL';
            if($this->chofer_ID!=null){
                $chofer=$this->chofer_ID;
            }
            $vehiculo='NULL';
            if($this->vehiculo_ID!=null){
                $vehiculo=$this->vehiculo_ID;
            }
           
            $q = 'update guia_venta set factura_venta_ID='.$this->factura_venta_ID.',serie="'.$this->serie.'", numero='.$this->numero;
            $q.=',numero_concatenado="'.$this->numero_concatenado.'",fecha_emision='.$fecha_emision.',orden_pedido="'. $this->orden_pedido;
            $q.='",orden_ingreso="'.$this->orden_ingreso.'",vehiculo_ID='.$vehiculo.',chofer_ID='.$chofer.',estado_ID='.$this->estado_ID;
            $q.=',fecha_inicio_traslado='.$fecha_inicio_traslado.',punto_partida="'.$this->punto_partida;
            $q.='",punto_llegada="'.$this->punto_llegada.'",empresa_transporte="'.$this->empresa_transporte.'", impresion='.$this->impresion;
            $q.=',opcion='.$this->opcion.', numero_producto='.$this->numero_producto.',usuario_mod_id='.$this->usuario_mod_id;
            $q.=', fdm=now() where ID='.$this->ID;
            //echo $q;
            $retornar = $cn->transa($q);
            $this->message = 'Se actualizó correctamente';
            return $q; //$retornar;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    function actualizarEstado(){
        $cn =new connect();
	$retornar=-1;
        try{
            
            $q='UPDATE guia_venta set estado_ID='.$this->estado_ID.',observacion="'.$this->observacion.'", usuario_mod_id='.$this->usuario_mod_id;
            $q.=', fdm=now() where del=0 and ID='.$this->ID;
            //echo $q;
            $retornar=$cn->transa($q);
            $this->message='Se guardó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
     function actualizarEstadoandNumero(){
        $cn =new connect();
	$retornar=-1;
        try{
            
            $q='UPDATE guia_venta set estado_ID='.$this->estado_ID.',numero='.$this->numero.',numero_concatenado="'.$this->numero_concatenado.'", usuario_mod_id='.$this->usuario_mod_id;
            $q.=', fdm=now() where del=0 and ID='.$this->ID;
            //echo $q;
            $retornar=$cn->transa($q);
            $this->message='Se guardó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    function eliminar() {
        $cn = new connect();
        $retornar = -1;
        try {

            $q = 'UPDATE guia_venta SET del=1,usuario_mod_id=' . $this->usuario_mod_id . ', fdm=Now()';
            $q.=' WHERE del=0 and ID=' . $this->ID;

            $retornar = $cn->transa($q);

            $this->message = 'Se eliminó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }

    static function getCount($filtro = '') {
        $cn = new connect();
        try {
            $q = 'select count(ID) ';
            $q.=' FROM guia_venta ';
            $q.=' where del=0 ';

            if ($filtro != '') {
                $q.=' and ' . $filtro;
            }
            
            $resultado = $cn->getData($q);

            return $resultado;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }

    static function getByID($ID) {
        $cn = new connect();
        try {
            $q = 'Select ID,factura_venta_ID,numero,numero_concatenado,serie,DATE_FORMAT(fecha_emision,"%d/%m/%Y") as fecha_emision,orden_pedido,orden_ingreso,vehiculo_ID,';
            $q.= 'chofer_ID,estado_ID,ifnull(numero_pagina,-1) as numero_pagina,DATE_FORMAT(fecha_inicio_traslado,"%d/%m/%Y") as fecha_inicio_traslado,punto_partida,';
            $q.='numero_producto,punto_llegada,empresa_transporte,impresion,correlativos_ID,usuario_id,opcion,ifnull(usuario_mod_id,-1) as usuario_mod_id' ;
            $q.=' from guia_venta ';
            $q.=' where del=0 and ID=' . $ID;
//echo $q;
            $dt = $cn->getGrid($q);
            $oGuia_Venta = null;

            foreach ($dt as $item) {
                $oGuia_Venta = new guia_venta();

                $oGuia_Venta->ID= $item['ID'];
                $oGuia_Venta->factura_venta_ID= $item['factura_venta_ID'];
                $oGuia_Venta->numero= $item['numero'];
                $oGuia_Venta->numero_concatenado= $item['numero_concatenado'];
                $oGuia_Venta->serie= $item['serie'];
                $oGuia_Venta->fecha_emision= $item['fecha_emision'];
                $oGuia_Venta->orden_pedido= $item['orden_pedido'];
                $oGuia_Venta->orden_ingreso= $item['orden_ingreso'];
                $oGuia_Venta->vehiculo_ID= $item['vehiculo_ID'];
                $oGuia_Venta->chofer_ID= $item['chofer_ID'];
                $oGuia_Venta->estado_ID= $item['estado_ID'];
                $oGuia_Venta->numero_pagina= $item['numero_pagina'];
                $oGuia_Venta->fecha_inicio_traslado= $item['fecha_inicio_traslado'];
                $oGuia_Venta->punto_partida= $item['punto_partida'];
                $oGuia_Venta->punto_llegada= $item['punto_llegada'];
                $oGuia_Venta->empresa_transporte= $item['empresa_transporte'];
                $oGuia_Venta->impresion=$item['impresion'];
                $oGuia_Venta->numero_producto=$item['numero_producto'];
                $oGuia_Venta->opcion=$item['opcion'];
                $oGuia_Venta->correlativos_ID=$item['correlativos_ID'];
                $oGuia_Venta->usuario_id= $item['usuario_id'];
                $oGuia_Venta->usuario_mod_id= $item['usuario_mod_id'];

            }
            return $oGuia_Venta;
        } catch (Exeption $ex) {
            throw new Exception($q);
        }
    }

    static function getGrid($filtro = '', $desde = -1, $hasta = -1, $order = 'ID asc') {
        $cn = new connect();
        try {
            $q = 'Select ID,factura_venta_ID,numero,numero_concatenado,serie,DATE_FORMAT(fecha_emision,"%d/%m/%Y") as fecha_emision,orden_pedido,orden_ingreso,vehiculo_ID,';
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
    }

    function verificarDuplicado() {
        $cn = new connect();
        $retornar = -1;
        try {
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }
static function getNumero(){
      $cn =new connect();
      $numero=0;
        try{
            $q='select ifnull(max(numero),0) as numero from guia_venta';
            $numero=$cn->getData($q);
           // echo $q;
            return $numero;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
              
    }
}
