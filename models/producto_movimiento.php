<?php

class producto_movimiento {

    private $ID;
    private $producto_ID;
    private $oferta;
    private $nuevo;
    private $moneda_ID;
    private $estado_ID;
    private $tipo_cambio;
    private $fecha;
    private $precio;
    private $orden;
    private $descripcion;
    private $usuario_id;
    private $usuario_mod_id;
    
    private $message;
    

    public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
        if (property_exists('producto_movimiento', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('producto_movimiento', $temporal)) {
            return $this->$temporal;
        }

        // Retorna nulo si no existe
        return null;
    }

   
    static function getCount($filtro = '') {
        $cn = new connect();
        try {
            $q = 'select count(prom.ID) ';
            $q.=' from producto_movimiento prom,producto pro ,moneda mo';
            $q.=' where prom.producto_ID=pro.ID and prom.moneda_ID=mo.ID and prom.del=0 ';
            $q.=' and prom.ID in (select max(ID) from producto_movimiento group by producto_ID )';
            if ($filtro != '') {
                $q.=' and ' . $filtro;
            }
            //echo $q;
            $resultado = $cn->getData($q);

            return $resultado;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }

    static function getByID($ID) {
        $cn = new connect();
        try {
            $q = 'Select ID,producto_ID,oferta,nuevo,moneda_ID,estado_ID,tipo_cambio,fecha';
            $q = ',precio,descripcion,orden,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
            $q.=' from producto_movimiento ';
            $q.=' where del=0  and ID=' . $ID;
			//echo $q;
            $dt = $cn->getGrid($q);
            $oProducto_Movimiento = null;

            foreach ($dt as $item) {
                $oProducto_Movimiento = new producto_movimiento();
                $oProducto_Movimiento->ID = $item['ID'];
                $oProducto_Movimiento->producto_ID = $item['producto_ID'];
                $oProducto_Movimiento->oferta = $item['oferta'];
                $oProducto_Movimiento->nuevo = $item['nuevo'];
                $oProducto_Movimiento->moneda_ID = $item['moneda_ID'];
                $oProducto_Movimiento->estado_ID = $item['estado_ID'];
                $oProducto_Movimiento->tipo_cambio = $item['tipo_cambio'];
                $oProducto_Movimiento->fecha = $item['fecha'];
                $oProducto_Movimiento->precio = $item['precio'];
                $oProducto_Movimiento->descripcion = $item['descripcion'];
                $oProducto_Movimiento->orden = $item['orden'];
                $oProducto_Movimiento->usuario_id = $item['usuario_id'];
                $oProducto_Movimiento->usuario_mod_id = $item['usuario_mod_id'];
            }
            return $oProducto_Movimiento;
        } catch (Exeption $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }

    static function getGrid($filtro = '', $desde = -1, $hasta = -1, $order = 'prom.ID asc') {
        $cn = new connect();
        try {
            $q = 'select prom.ID,prom.producto_ID,prom.nuevo,prom.oferta,prom.moneda_ID,prom.estado_ID,prom.tipo_cambio,prom.fecha';
            $q.= ',prom.precio,prom.descripcion,prom.orden,prom.usuario_id,ifnull(prom.usuario_mod_id,-1) as usuario_mod_id';
            $q.= ',pro.nombre as producto,pro.imagen,mo.descripcion as moneda,mo.simbolo';
            $q.=' from producto_movimiento prom,producto pro ,moneda mo,categoria ca, linea li';
            $q.=' where prom.producto_ID=pro.ID and prom.moneda_ID=mo.ID and pro.categoria_ID=ca.ID and ca.linea_ID=li.ID and prom.del=0 ';
            $q.=' and prom.ID in (select max(ID) from producto_movimiento group by producto_ID )';
		

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
 
}
