<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of credito
 *
 * @author miwler
 */
class credito {
    private $ID;
    private $dias;
	private $texto;
   
    Private $message;
    public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el dias es la cadena en "$temporal"		
        if (property_exists('credito', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('credito', $temporal)) {
            return $this->$temporal;
        }

        // Retorna nulo si no existe
        return null;
    }
     static function getByID($ID) {
        $cn = new connect_new();
        try {
            $q = 'Select ID,dias,texto,usuario_id';
            $q.=' from credito ';
            $q.=' where del=0 and ID=' . $ID;

            $dt = $cn->getGrid($q);
            $oCredito = null;

            foreach ($dt as $item) {
                $oCredito = new credito();

                $oCredito->ID = $item['ID'];
                $oCredito->dias = $item['dias'];
				$oCredito->texto = $item['texto'];
                $oCredito->usuario_id = $item['usuario_id'];
             
            }
            return $oCredito;
        } catch (Exeption $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }
    
    static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='ID asc')
	{
		$cn =new connect_new();
		try 
		{
			$q='select ID,dias,texto';
			$q.=' FROM credito';
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
