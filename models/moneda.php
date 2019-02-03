<?php

class moneda {
    private $ID;
    private $codigo;
    private $descripcion;
    private $simbolo;
    private $usuario_id;
    private $message;

    public function __set($var, $valor)
    {
// convierte a min�sculas toda una cadena la funci�n strtolower
          $temporal = $var;

          // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"
          if (property_exists('moneda',$temporal))
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

        // Verifica que exista
        if (property_exists('moneda', $temporal))
         {
                return $this->$temporal;
         }

        // Retorna nulo si no existe
        return null;
    }
    static function getByID($ID) {
        $cn = new connect_new();
        try {
            $q = 'Select ID,codigo,descripcion,simbolo,usuario_id';
            $q.=' from moneda ';
            $q.=' where del=0 and ID=' . $ID;

            $dt = $cn->getGrid($q);
            $oMoneda = null;

            foreach ($dt as $item) {
                $oMoneda = new moneda();

                $oMoneda->ID = $item['ID'];
                $oMoneda->codigo = $item['codigo'];
                $oMoneda->descripcion = $item['descripcion'];
                $oMoneda->simbolo = $item['simbolo'];
                $oMoneda->usuario_id = $item['usuario_id'];

            }
            return $oMoneda;
        } catch (Exeption $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }
	static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='ID asc')
	{
		$cn =new connect_new();
		try
		{
			$q='SELECT ID,codigo,descripcion,simbolo';
			$q.=' FROM moneda ';
			$q.=' where del=0';
			if($filtro!=''){
				$q.=' and '.$filtro;
			}

			$q.=' Order By '.$order;

			if($desde!=-1&&$hasta!=-1){
				$q.=' Limit '.$desde.','.$hasta;
			}
			//echo $q;
			$dt=$cn->getGrid($q);
			return $dt;
		}catch(Exception $ex)
		{
			throw new Exception('Ocurrio un error en la consulta');
		}
	}
}
?>
