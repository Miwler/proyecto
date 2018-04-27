<?php

class serie {

    private $ID;
    private $valor;
    private $nombre;
    private $descripcion;
    private $comprobante_tipo_ID;
    
    private $usuario_id;
    private $usuario_mod_id;
    private $dtComprobante_tipo;
    Private $message;

    public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
        if (property_exists('serie', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('serie', $temporal)) {
            return $this->$temporal;
        }

        // Retorna nulo si no existe
        return null;
    }

    function insertar() {
        $cn = new connect();
        $retornar = -1;
        try {

            $q = 'SET  @maxrow:=(select ifnull(max(ID),0) from serie);';
            $cn->transa($q);
            $q = 'insert into serie(ID,valor,nombre,descripcion,comprobante_tipo_ID,usuario_id)';
            $q.='values((select @maxrow:=@maxrow+1),'.$this->valor.',"' . FormatTextSave($this->nombre) . '","' . FormatTextSave($this->descripcion) . '",'. $this->comprobante_tipo_ID . ','. $this->usuario_id . ');';
            //echo $q;
            $retornar = $cn->transa($q);

            $q = 'select max(ID) from serie where usuario_id=' . $this->usuario_id;
            $this->ID = $cn->getData($q);
            $this->message = 'Se guardó correctamente';
            return $retornar;
        } catch (Exception $ex) {

            throw new Exception("Ocurrio un error en la consulta");
        }
    }

    function actualizar() {
        $cn = new connect();
        $retornar = -1;
        try {
            $q = 'update serie set descripcion="' . $this->descripcion . '",nombre="' . $this->nombre . '", comprobante_tipo_ID='.$this->comprobante_tipo_ID.',usuario_mod_id=' . $this->usuario_mod_id;
            $q.=', fdm=now() where del=0 and id=' . $this->ID;
            $retornar = $cn->transa($q);
            $this->message = 'Se actualizo correctamente';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }

    function eliminar() {
        $cn = new connect();
        $retornar = -1;
        try {

            $q = 'UPDATE serie SET del=1,usuario_mod_id=' . $this->usuario_mod_id . ', fdm=Now()';
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
            $q = 'select count(se.ID) ';
            $q.=' FROM serie as se, comprobante_tipo ct ';
            $q.=' where se.comprobante_tipo_ID=ct.ID and se.del=0 ';

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
            $q = 'Select ID,descripcion,nombre,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id,comprobante_tipo_ID';
            $q.=' from serie ';
            $q.=' where del=0 and ID=' . $ID;

            $dt = $cn->getGrid($q);
            $oSerie = null;

            foreach ($dt as $item) {
                $oSerie = new serie();

                $oSerie->ID = $item['ID'];
		$oSerie->comprobante_tipo_ID=$item['comprobante_tipo_ID'];
                $oSerie->nombre = $item['nombre'];
                $oSerie->descripcion = $item['descripcion'];
                $oSerie->usuario_id = $item['usuario_id'];
                $oSerie->usuario_mod_id = $item['usuario_mod_id'];
            }
            return $oSerie;
        } catch (Exeption $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }

    static function getGrid($filtro = '', $desde = -1, $hasta = -1, $order = 'se.ID asc') {
        $cn = new connect();
        try {
            $q = 'SELECT se.ID,UPPER(se.nombre) as nombre,se.descripcion,se.comprobante_tipo_ID,UPPER(ct.nombre) as comprobante_tipo';
            $q.=' FROM serie  se , comprobante_tipo ct';
            $q.=' where se.comprobante_tipo_ID=ct.ID and se.del=0 ';


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
           $q="select  count(ID) from serie ";
            $q.=" where del=0 and upper(nombre) like upper('".$this->nombre."')";
            
                if($this->ID!=''){
                       $q.=' and ID<>'.$this->ID;
                   }

                $retornar=$cn->getData($q);
                if ($retornar>0){
                            $this->message='Ya existe una serie con el mismo nombre ';
                            return $retornar;
                }
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }
    function verificarHijos($comprobante_tipo_ID){
        $cn = new connect();     
        $retornar = -1;
        try {
		//Verifico que no se repita el nombre
			$q='SELECT count(ID) FROM serie se';
			$q.=' WHERE se.del=0 and se.comprobante_tipo_ID='.$comprobante_tipo_ID;		
			//echo $q;
			$retornar=$cn->getData($q);			
			return $retornar;
			
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }
    
}
