<?php

class linea {
    private $ID;
    private $descripcion;
    private $nombre;
    private $tipo;
    private $imagen;
    private $empresa_ID;
    private $usuario_id;
    private $usuario_mod_id;
	
    Private $getMessage;
    private $ruta_imagen;
    public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
        if (property_exists('linea', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('linea', $temporal)) {
            return $this->$temporal;
        }

        // Retorna nulo si no existe
        return null;
    }

    function insertar() {
        
        $retornar = -1;
        try {

            $q = 'select ifnull(max(ID),0)+1 from linea;';
			$cn = new connect_new();
            $ID=$cn->getData($q);
            $q = 'insert into linea(ID,nombre,descripcion,tipo,imagen,empresa_ID,usuario_id)';
            $q.='values('.$ID.',"' . $this->nombre . '","' . $this->descripcion . '","'.$this->tipo.'","'.$this->imagen.'",'.$this->empresa_ID.',' . $this->usuario_id . ');';
            //echo $q;
			$cn = new connect_new();
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
            $q = 'update linea set descripcion="' .$this->descripcion . '",nombre="' . $this->nombre ;
            $q.='",tipo="'.$this->tipo.'",imagen="'.$this->imagen.'",empresa_ID='.$this->empresa_ID.',usuario_mod_id=' . $this->usuario_mod_id;
            $q.=', fdm=now() where del=0 and id=' . $this->ID;
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

            $q = 'UPDATE linea SET del=1,usuario_mod_id=' . $this->usuario_mod_id . ', fdm=Now()';
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
            $q = 'select count(li.ID) ';
            $q.=' FROM linea as li ';
            $q.=' where li.del=0 and li.empresa_ID='.$_SESSION['empresa_ID'];

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
            $q = 'Select ID,nombre,descripcion,tipo,ifnull(imagen,"") as imagen,empresa_ID,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
            $q.=' from linea ';
            $q.=' where del=0 and ID=' . $ID;

            $dt = $cn->getGrid($q);
            $oLinea = null;

            foreach ($dt as $item) {
                $oLinea = new linea();

                $oLinea->ID = $item['ID'];
                $oLinea->nombre = $item['nombre'];
                $oLinea->descripcion = $item['descripcion'];
                $oLinea->tipo = $item['tipo'];
                $oLinea->imagen = $item['imagen'];
                $oLinea->empresa_ID = $item['empresa_ID'];
                $oLinea->usuario_id = $item['usuario_id'];
                $oLinea->usuario_mod_id = $item['usuario_mod_id'];
            }
            return $oLinea;
        } catch (Exeption $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }

    static function getGrid($filtro = '', $desde = -1, $hasta = -1, $order = 'li.ID asc') {
        $cn = new connect_new();
        try {
            $q = 'SELECT li.ID,upper(li.nombre) as nombre, upper(li.descripcion) as descripcion,ifnull(li.imagen,"") as imagen,li.empresa_ID';
            $q.=' FROM linea as li ';
            $q.=' where li.del=0 and li.empresa_ID='.$_SESSION['empresa_ID'];


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
            $q.=' WHERE del=0 and Upper(nombre)="'.strtoUpper(FormatTextSave($this->nombre)).'" and empresa_ID='.$this->empresa_ID.' and tipo="'.$this->tipo.'"';	
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
 static function getOption($empresa_ID) {
        $cn = new connect_new();
        try {
            $retorna=$cn->store_procedure_getData(
              "sp_linea_getOption",
                array(
                    "iempresa_ID"=>$empresa_ID
                ));
  
            return $retorna;
        } catch (Exception $ex) {
            log_error(__FILE__, "linea.getOption", $ex->getMessage());
            throw new Exception('Ocurrio un error en la consulta');
        }
    }

}
