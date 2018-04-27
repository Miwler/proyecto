<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of forma_pago
 *
 * @author miwler
 */
class forma_pago {
    private $ID;
    private $nombre;
    private $usuario_id;
    Private $message;
    public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
        if (property_exists('forma_pago', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('forma_pago', $temporal)) {
            return $this->$temporal;
        }

        // Retorna nulo si no existe
        return null;
    }
     static function getByID($ID) {
        $cn = new connect();
        try {
            $q = 'Select ID,nombre,usuario_id';
            $q.=' from forma_pago ';
            $q.=' where del=0 and ID=' . $ID;

            $dt = $cn->getGrid($q);
            $oForma_pago = null;

            foreach ($dt as $item) {
                $oForma_pago = new forma_pago();

                $oForma_pago->ID = $item['ID'];
                $oForma_pago->nombre = $item['nombre'];
                $oForma_pago->usuario_id = $item['usuario_id'];
             
            }
            return $oForma_pago;
        } catch (Exeption $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }
    
    static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='ID asc')
	{
		$cn =new connect();
		try 
		{
			$q='select ID,nombre';
			$q.=' FROM forma_pago';
			$q.=' where del=0 ';
			
			if($filtro!=''){
				$q.=' and '.$filtro;
			}
			
			$q.=' Order By '.$order;
			
			if($desde!=-1&&$hasta!=-1){
				$q.=' Limit '.$desde.','.$hasta;
			}			
			
			$dt=$cn->getGrid($q);									
			return $dt;												
		}catch(Exception $ex)
		{
			throw new Exception('Ocurrio un error en la consulta');
		}
	}
}
