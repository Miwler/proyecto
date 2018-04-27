<?php

class categoria {

    private $ID;
    private $descripcion;
    private $linea_ID;
    private $nombre;
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
        if (property_exists('categoria', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('categoria', $temporal)) {
            return $this->$temporal;
        }

        // Retorna nulo si no existe
        return null;
    }

    function insertar() {
        $cn = new connect();
        $retornar = -1;
        try {

            $q = 'select ifnull(max(ID),0)+1 from categoria;';
            $ID=$cn->getData($q);
            $q = 'insert into categoria(ID,nombre,descripcion,imagen,linea_ID,usuario_id,empresa_ID)';
            $q.='values('.$ID.',"' . $this->nombre . '","' . $this->descripcion . '","'.$this->imagen.'",'. $this->linea_ID . ',' . $this->usuario_id .','.$this->empresa_ID.');';
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
        $cn = new connect();
        $retornar = -1;
        try {
            $q = 'update categoria set descripcion="' . $this->descripcion . '",nombre="' . $this->nombre . '", linea_ID='.$this->linea_ID;
            $q.= ',imagen="'.$this->imagen.'",empresa_ID='.$this->empresa_ID.',usuario_mod_id=' . $this->usuario_mod_id;
            $q.=', fdm=now() where del=0 and id=' . $this->ID;
            $retornar = $cn->transa($q);
            $this->getMessage = 'Se guardó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            
        }
    }

    function eliminar() {
        $cn = new connect();
        $retornar = -1;
        try {

            $q = 'UPDATE categoria SET del=1,usuario_mod_id=' . $this->usuario_mod_id . ', fdm=Now()';
            $q.=' WHERE del=0 and ID=' . $this->ID;

            $retornar = $cn->transa($q);

            $this->getMessage = 'Se eliminó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }

    static function getCount($filtro = '') {
        $cn = new connect();
        try {
            $q = 'select count(ca.ID) ';
            $q.=' FROM categoria as ca, linea li ';
            $q.=' where ca.linea_ID=li.ID and ca.del=0 ';

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
        $cn = new connect();
        try {
            $q = 'Select ID,linea_ID,descripcion,nombre,ifnull(imagen,"") as imagen,empresa_ID,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
            $q.=' from categoria ';
            $q.=' where del=0 and ID=' . $ID;

            $dt = $cn->getGrid($q);
            $oCategoria = null;

            foreach ($dt as $item) {
                $oCategoria = new categoria();

                $oCategoria->ID = $item['ID'];
                $oCategoria->linea_ID=$item['linea_ID'];
                $oCategoria->nombre = $item['nombre'];
                $oCategoria->descripcion = $item['descripcion'];
                $oCategoria->imagen = $item['imagen'];
                $oCategoria->empresa_ID = $item['empresa_ID'];
                $oCategoria->usuario_id = $item['usuario_id'];
                $oCategoria->usuario_mod_id = $item['usuario_mod_id'];
            }
            return $oCategoria;
        } catch (Exeption $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }

    static function getGrid($filtro = '', $desde = -1, $hasta = -1, $order = 'ca.ID asc') {
        $cn = new connect();
        try {
            $q = 'SELECT ca.ID,UPPER(ca.nombre) as nombre,ca.descripcion,ca.linea_ID,UPPER(li.nombre) as linea,ca.empresa_ID';
            $q.=' FROM categoria  ca , linea li';
            $q.=' where ca.linea_ID=li.ID and ca.del=0 and ca.empresa_ID='.$_SESSION['empresa_ID'];


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
            throw new Exception('Ocurrio un error en la consulta');
        }
    }

    function verificarDuplicado() {
        $cn = new connect();
        $retornar = -1;
        try {
           $q="select  count(ID) from categoria ";
            $q.=" where del=0 and upper(nombre) like upper('".$this->nombre."') and empresa_ID=".$this->empresa_ID;
            
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
    function verificarHijos($linea_ID){
        $cn = new connect();     
        $retornar = -1;
        try {
            //Verifico que no se repita el nombre
            $q='SELECT count(ID) FROM categoria ca';
            $q.=' WHERE ca.del=0 and ca.linea_ID='.$linea_ID ;		
            //echo $q;
            $retornar=$cn->getData($q);			
            return $retornar;
			
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }
    
    static function getByID2($producto_ID) {
        $cn = new connect();
        try {
            $q = 'select ca.ID from linea li, categoria ca, producto pr where li.del=0 and ca.del=0 and pr.del=0 and li.ID=ca.linea_ID and ca.ID=pr.categoria_ID and pr.ID='.$producto_ID;
            $categoria_ID = $cn->getData($q);
            
            return $categoria_ID;
        } catch (Exeption $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }
}
