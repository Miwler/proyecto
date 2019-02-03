<?php

class producto {

    private $ID;
    private $empresa_ID;
    private $codigo;
    private $descripcion;
    private $nombre;
    private $unidad_medida_ID;
    private $usuario_id;
    private $usuario_mod_id;
    private $categoria_ID;
    private $precio_inicial;
    private $marca;
    private $peso;
    private $modelo;
    private $color;
    private $estado_ID;
    private $moneda_ID;
    private $precio_inicial_soles;
    private $precio_inicial_dolares;
    private $tipo_cambio;
   
    private $unidad_medida;
    private $ver_web;
    private $caracteristicas;
    private $especificaciones;
    private $getMessage;
    private $imagen;
    private $dtMoneda;
    

    public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
        if (property_exists('producto', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe1.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('producto', $temporal)) {
            return $this->$temporal;
        }

        // Retorna nulo si no existe
        return null;
    }
    function __construct()
  {
        $this->nombre="";
    $this->descripcion="";
    $this->marca="";
    $this->peso=0;
    $this->modelo="";
    $this->color="";
    $this->precio_inicial_soles=0;
    $this->precio_inicial_dolares=0;
    $this->moneda_ID=0;
    $this->tipo_cambio=0;
    $this->ver_web=0;
    $this->caracteristicas="";
    $this->especificaciones="";
    $this->usuario_id=$_SESSION["usuario_ID"];
    $this->usuario_mod_id=$_SESSION["usuario_ID"];
    $this->codigo=0;

  }
  function __destruct()
  {
        $this->nombre;
    $this->descripcion;
    $this->marca;
    $this->peso;
    $this->modelo;
    $this->color;
    $this->precio_inicial_soles;
    $this->precio_inicial_dolares;
    $this->moneda_ID;
    $this->tipo_cambio;
    $this->ver_web;
    $this->caracteristicas;
    $this->especificaciones;
    $this->usuario_id;
    $this->usuario_mod_id;
    $this->codigo;

  }
    function insertar() {
        
        $retornar = -1;
        try {

            $q = 'select ifnull(max(ID),0)+1 from producto;';
			$cn = new connect_new();
            $ID=$cn->getData($q);
            //$cn->transa($q);
            $q = 'insert into producto(ID,empresa_ID, descripcion,nombre,unidad_medida_ID, usuario_id, categoria_ID, estado_ID,marca,';
            $q.= 'modelo,color,moneda_ID,precio_inicial_soles,precio_inicial_dolares,tipo_cambio,';
            $q.= 'ver_web,caracteristicas,especificaciones)';
            $q.='values('.$ID.','.$this->empresa_ID.',"' . $this->descripcion . '","' . $this->nombre. '",'.
                   $this->unidad_medida_ID.',' . $this->usuario_id .','.$this->categoria_ID. ','.$this->estado_ID .
                   ',"'.$this->marca.'","'.$this->modelo.'","'.$this->color.'",'.$this->moneda_ID.','.
                    $this->precio_inicial_soles.','.$this->precio_inicial_dolares.','.$this->tipo_cambio.
                    ','.$this->ver_web.',"'.$this->caracteristicas.'","'.$this->especificaciones.'")';
               
           // echo $q;
		   $cn = new connect_new();
            $retornar = $cn->transa($q);

            
            $this->ID = $ID;
            $this->getMessage = 'Se guardó correctamente';
            return $retornar;
        } catch (Exception $ex) {

            throw new Exception($q);
        }
    }
    
    function actualizar() {
        $cn = new connect_new();
        $retornar = -1;
        try {
            $q = 'update producto set nombre="' . $this->nombre . '",descripcion="' . $this->descripcion. '",unidad_medida_ID=';
            $q.=$this->unidad_medida_ID.',categoria_ID='.$this->categoria_ID.',marca="'.$this->marca;
            $q.='",modelo="'.  $this->modelo.'",color="'.  $this->color;
            $q.='",moneda_ID='.$this->moneda_ID.',precio_inicial_soles='.$this->precio_inicial_soles;
            $q.=',precio_inicial_dolares='.$this->precio_inicial_dolares.',tipo_cambio='.$this->tipo_cambio;
            $q.=',ver_web=' . $this->ver_web. ',caracteristicas="'.$this->caracteristicas;
            $q.='",especificaciones="'. $this->especificaciones. '",usuario_mod_id=' . $this->usuario_mod_id;
            $q.=', fdm=now() where del=0 and id=' . $this->ID;
            //echo $q;
            $retornar = $cn->transa($q);
            $this->getMessage = 'Se guardó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            
        }
    }

    function eliminar() {
        $cn = new connect_new();
        $retornar = -1;
        try {

            $q = 'UPDATE producto SET del=1,usuario_mod_id=' . $this->usuario_mod_id . ', fdm=Now()';
            $q.=' WHERE del=0 and ID=' . $this->ID;
            //echo $q;
            $retornar = $cn->transa($q);

            $this->getMessage = 'Se eliminó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }

    static function getCount($filtro = '') {
        $cn = new connect_new();
        try {
            $q = 'select count(pr.ID) ';
            $q.=' FROM producto pr, categoria ca, linea li ';
            $q.=' where ca.ID=pr.categoria_ID and ca.linea_ID=li.ID and pr.del=0 and li.del=0 and pr.empresa_ID='.$_SESSION['empresa_ID'];

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
        $cn = new connect_new();
        try {
            $q = 'Select ID,empresa_ID,codigo,nombre,unidad_medida_ID,descripcion,marca,peso,modelo,color,categoria_ID,estado_ID,codigo,';
            $q.= 'moneda_ID,precio_inicial_soles,precio_inicial_dolares,tipo_cambio,ifnull(ver_web,0) as ver_web,ifnull(caracteristicas,"") as caracteristicas,ifnull(especificaciones,"") as especificaciones,';
            $q.= 'usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
            $q.=' from producto ';
            $q.=' where del=0 and ID=' . $ID;
			//echo $q;
            $dt = $cn->getGrid($q);
            $oProducto = null;

            foreach ($dt as $item) {
                $oProducto = new producto();
                $oProducto->ID = $item['ID'];
                $oProducto->empresa_ID = $item['empresa_ID'];
                $oProducto->nombre = $item['nombre'];
                $oProducto->descripcion = $item['descripcion'];
                $oProducto->unidad_medida_ID = $item['unidad_medida_ID'];
                $oProducto->categoria_ID = $item['categoria_ID'];
                $oProducto->estado_ID = $item['estado_ID'];
              
                $oProducto->marca = $item['marca'];
                $oProducto->peso = $item['peso'];
                $oProducto->modelo = $item['modelo'];
                $oProducto->color = $item['color'];
                $oProducto->moneda_ID=$item['moneda_ID'];
                $oProducto->precio_inicial_soles=$item['precio_inicial_soles'];
                $oProducto->precio_inicial_dolares=$item['precio_inicial_dolares'];
                $oProducto->tipo_cambio=$item['tipo_cambio'];
                $oProducto->ver_web=$item['ver_web'];
                $oProducto->especificaciones=$item['especificaciones'];
                $oProducto->caracteristicas=$item['caracteristicas'];
                $oProducto->codigo=$item['codigo'];
                $oProducto->usuario_id = $item['usuario_id'];
                $oProducto->usuario_mod_id = $item['usuario_mod_id'];
            }
            return $oProducto;
        } catch (Exeption $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }

    static function getGrid($filtro = '', $desde = -1, $hasta = -1, $order = 'pr.ID asc') {
        $cn = new connect_new();
        try {
            $q = 'SELECT pr.ID,pr.descripcion,pr.unidad_medida_ID,upper(pr.nombre) as producto,pr.codigo,ca.nombre as categoria,';
            $q.= 'upper(li.nombre) as linea , ca.ID as categoria_ID , upper(es.nombre) as estado,pr.moneda_ID,pr.precio_inicial_soles,';
            $q.= 'pr.precio_inicial_dolares,pr.tipo_cambio,pr.ver_web,pr.caracteristicas,pr.especificaciones';
            $q.=' FROM producto pr, categoria ca, estado es,linea li ';
            $q.=' where pr.empresa_ID='.$_SESSION['empresa_ID'].' and pr.del=0 and ca.del=0 and ca.ID=pr.categoria_ID and ca.linea_ID=li.ID and es.ID=pr.estado_ID and li.del=0';


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
    static function getListaProducto($categoria_ID,$linea_ID)
    {
        $cn =new connect_new();
        try
        {
        $q='call sp_producto_getLista('.$_SESSION['empresa_ID'].','.$categoria_ID.','.$linea_ID.');';
        //echo $q;
        //console_log($q);
        $retorna=$cn->getData($q);
        return $retorna;
        }catch(Exception $ex)
        {
                throw new Exception($q);
        }
    }
    function verificarDuplicado() {
        $cn = new connect_new();
        $retornar = -1;
        try {
            $q="select  count(ID) from producto ";
            $q.=" where empresa_ID=".$_SESSION['empresa_ID']." and del=0 and upper(nombre) like upper('".$this->nombre."') and empresa_ID=".$this->empresa_ID;
           
            $filtro="";
            if(isset ($this->ID)){
                $filtro=" and ID<>".$this->ID;
            }
            $q.=$filtro;
             $retornar=$cn->getData($q);
            if($retornar>0){
                $this->getMessage="Existe un producto registrado con el mismo nombre";
            }
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }
function verificarHijos($categoria_ID){
        $cn = new connect_new();     
        $retornar = -1;
        try {
		//Verifico que no se repita el nombre
            $q='SELECT count(ID) FROM producto pr';
            $q.=' WHERE pr.empresa_ID='.$_SESSION['empresa_ID'].' and  pr.del=0 and pr.categoria_ID='.$categoria_ID;		
            //echo $q;
            $retornar=$cn->getData($q);			
            return $retornar;
			
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }
    
     static function MostrarGraficoProducto_MasVendidos() {
        $cn = new connect_new();
        try {
            $q = 'select ovd.producto_ID,pr.nombre as producto, sum(ovd.cantidad) as cantidad, sum(ovd.precio_venta_soles) as precio_venta_soles , sum(ovd.precio_venta_dolares) as precio_venta_dolares  ';
            $q.= 'from orden_venta_detalle ovd, producto pr, orden_venta ov  ';
            $q.= 'where  ovd.del=0 and pr.ID = ovd.producto_ID and ov.ID = ovd.orden_venta_ID and (ov.estado_ID = 40 or ov.estado_ID = 42) ';
            $q.= 'GROUP BY pr.nombre ';
            $q.= 'order by precio_venta_soles desc ';
             $q.=' limit 10';
//                       echo $q;
            $dt = $cn->getGrid($q);
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }   
    static function getLista($nombre) {
        $cn = new connect_new();
        try {
            
            $q="call getOptionProducto(".$_SESSION['empresa_ID'].",'".$nombre."');";
           
            //echo $q;
            $dt = $cn->getData($q);
           
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    static function geLista1($buscar='',$linea_ID=0,$categoria_ID=0)
    {
        $cn =new connect_new();
        try 
        {
            $dt=$cn->store_procedure_getGridParse("getListaProductos1", array(
                'iempresa_ID'=>$_SESSION['empresa_ID'],
                'buscar'=>$buscar,
                'ilinea_ID'=>$linea_ID,
                'icategoria_ID'=>$categoria_ID
            ));
           // $q='call getListaProductos1('.$_SESSION['empresa_ID'].',"'.$buscar.'",'.$linea_ID.','.$categoria_ID.');';
            
            //$dt=$cn->getGrid($q);									
            return $dt;												
        }catch(Exception $ex)
        {
                throw new Exception($q);
        }
    }
    
    static function getFilasHistorial($producto_ID) {
        $cn = new connect_new();
        try {
            $dt=$cn->store_procedure_getGrid("sp_producto_getHistorial",
            array(
                "iproducto_ID"=>$producto_ID
            ));
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    static function getFilasSeparaciones($producto_ID) {
        $cn = new connect_new();
        try {
            $dt=$cn->store_procedure_getGrid("sp_producto_getSeparaciones",
            array(
                "iproducto_ID"=>$producto_ID
            ));
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
}
