<?php

class marca {
    private $ID;
    private $nombre;
    private $imagen;
    
    private $url;
    private $orden;
    private $empresa_ID;
    private $usuario_id;
    private $usuario_mod_id;
	
    Private $getMessage;

    public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
        if (property_exists('marca', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('marca', $temporal)) {
            return $this->$temporal;
        }

        // Retorna nulo si no existe
        return null;
    }

    function insertar() {
        $cn = new connect_new();
        $retornar = -1;
        try {

            $q = 'select ifnull(max(ID),0)+1 from marca;';
            $ID=$cn->getData($q);
            $q = 'insert into marca(ID,nombre,imagen,url,orden,empresa_ID,usuario_id)';
            $q.='values('.$ID.',"'.$this->nombre. '","' . $this->imagen . '","' . $this->url . '",'.$this->orden.','.$this->empresa_ID.','. $this->usuario_id . ');';
            //echo $q;
            $retornar = $cn->transa($q);
            $this->ID = $ID;
            $this->getMessage = 'Se guardó correctamente';
            return $retornar;
        } catch (Exception $ex) {

            throw new Exception("Ocurrio un error en la consulta");
        }
    }

    function actualizar() {
        $cn = new connect_new();
        $retornar = -1;
        try {
            $q = 'update marca set nombre="'.$this->nombre.'",imagen="'.$this->imagen.'",url="'.$this->url.'",orden='.$this->orden.',empresa_ID='.$this->empresa_ID.',usuario_mod_id=' . $this->usuario_mod_id;
            $q.=', fdm=now() where del=0 and ID=' . $this->ID;
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

            $q = 'UPDATE marca SET del=1,usuario_mod_id=' . $this->usuario_mod_id . ', fdm=Now()';
            $q.=' WHERE del=0 and ID=' . $this->ID;

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
            $q = 'select count(ID) ';
            $q.=' FROM marca  ';
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
    }

    static function getByID($ID) {
        $cn = new connect_new();
        try {
            $q = 'select ID,nombre,imagen,orden,url,usuario_id,empresa_ID,ifnull(usuario_mod_id,-1) as usuario_mod_id';
            $q.=' from marca ';
            $q.=' where del=0 and ID=' . $ID;

            $dt = $cn->getGrid($q);
            $oMarca = null;

            foreach ($dt as $item) {
                $oMarca = new marca();

                $oMarca->ID = $item['ID'];
                $oMarca->nombre = $item['nombre'];
                $oMarca->imagen = $item['imagen'];
                $oMarca->url = $item['url'];
                $oMarca->orden = $item['orden'];
                $oMarca->empresa_ID = $item['empresa_ID'];
                $oMarca->usuario_id = $item['usuario_id'];
                $oMarca->usuario_mod_id = $item['usuario_mod_id'];
            }
            return $oMarca;
        } catch (Exeption $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }

    static function getGrid($filtro = '', $desde = -1, $hasta = -1, $order = 'orden asc') {
        $cn = new connect_new();
        try {
            $q = 'SELECT ID,nombre,imagen,orden,url,empresa_ID,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
            $q.=' FROM marca';
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
            
            throw new Exception('Ocurrió un error en la consulta SQL');
        }
    }

    function verificarDuplicado() {
		
        $cn = new connect_new();     
        $retornar = -1;
        try {
		//Verifico que no se repita el nombre
            $q='SELECT count(ID) FROM linea';
            $q.=' WHERE del=0 and Upper(nombre)="'.strtoUpper(FormatTextSave($this->nombre)).'"';	
            $filtro="";
            if(isset ($this->ID)){
                    $filtro=" and ID<>".$this->ID;
            }
            $q.=$filtro;			
            $retornar=$cn->getData($q);			

            return $retornar;
			
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }
    
     static function getByID2($producto_ID) {
        $cn = new connect_new();
        try {
            $q = 'select li.ID from linea li, categoria ca, producto pr where li.del=0 and ca.del=0 and pr.del=0 and li.ID=ca.linea_ID and ca.ID=pr.categoria_ID and pr.ID='.$producto_ID;
            $linea_ID = $cn->getData($q);
            
            return $linea_ID;
        } catch (Exeption $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }


}
