<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of unidad_medida
 *
 * @author miwler
 */
class unidad_medida {
    private $ID;
    private $nombre;
    private $usuario_id;
    Private $message;
    public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
        if (property_exists('unidad_medida', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('unidad_medida', $temporal)) {
            return $this->$temporal;
        }

        // Retorna nulo si no existe
        return null;
    }
     static function getByID($ID) {
        $cn = new connect_new();
        try {
            $q = 'Select ID,nombre,usuario_id';
            $q.=' from unidad_medida ';
            $q.=' where del=0 and ID=' . $ID;

            $dt = $cn->getGrid($q);
            $oUnidad_medida = null;

            foreach ($dt as $item) {
                $oUnidad_medida = new unidad_medida();

                $oUnidad_medida->ID = $item['ID'];
                $oUnidad_medida->nombre = $item['nombre'];
                $oUnidad_medida->usuario_id = $item['usuario_id'];
             
            }
            return $oUnidad_medida;
        } catch (Exeption $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }
    
    static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='ID asc')
	{
		$cn =new connect_new();
		try 
		{
			$q='select ID,nombre';
			$q.=' FROM unidad_medida';
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
