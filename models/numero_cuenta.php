<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of numero de cuenta
 *
 * @author miwler
 */
class numero_cuenta {
    private $ID;
    private $numero;
    private $cci;
    private $nombre_banco;
    private $moneda_ID;
    private $dtMoneda;
    private $usuario_id;
    private $usuario_mod_id;
    private $abreviatura;
    Private $getMessage;
    public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el dias es la cadena en "$temporal"		
        if (property_exists('numero_cuenta', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('numero_cuenta', $temporal)) {
            return $this->$temporal;
        }

        // Retorna nulo si no existe
        return null;
    }
     static function getByID($ID) {
        $cn = new connect_new();
        try {
            $q = "Select ID,nombre_banco,numero,cci,moneda_ID,ifNull(abreviatura,'') as abreviatura,ifNull(usuario_id,0) as usuario_id,ifNull(usuario_mod_id,-1) as usuario_mod_id";
            $q.=' from numero_cuenta ';
            $q.=' where del=0 and ID=' . $ID;

            $dt = $cn->getGrid($q);
            $oNumero_Cuenta = null;

            foreach ($dt as $item) {
                $oNumero_Cuenta = new numero_cuenta();

                $oNumero_Cuenta->ID = $item['ID'];
                $oNumero_Cuenta->nombre_banco = $item['nombre_banco'];
		$oNumero_Cuenta->numero = $item['numero'];
                $oNumero_Cuenta->cci = $item['cci'];
                $oNumero_Cuenta->moneda_ID = $item['moneda_ID'];
                $oNumero_Cuenta->abreviatura = $item['abreviatura'];
                $oNumero_Cuenta->usuario_id = $item['usuario_id'];
                $oNumero_Cuenta->usuario_mod_id = $item['usuario_mod_id'];
             
            }
            return $oNumero_Cuenta;
        } catch (Exeption $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }
    function insertar() {
        
        try {
            $q = 'select ifNull(max(ID),0)+1 from numero_cuenta';
			$cn = new connect_new();
            $ID = $cn->getData($q);
            
            $q=' INSERT INTO numero_cuenta (ID,nombre_banco,numero,cci,moneda_ID,usuario_id) ';
            $q.=' VALUES ('.$ID.',"'.$this->nombre_banco.'","'.$this->numero.'","'.$this->cci.'",'.$this->moneda_ID.','.$this->usuario_id.')' ;
            $cn = new connect_new();
            $retorna = $cn->transa($q);
            $this->ID=$ID;
            $this->getMessage="Se guardó correctamente.";
            return $retorna;
        } catch (Exeption $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }   
    function actualizar() {
        $cn = new connect_new();
        try {
            
            $q=' UPDATE numero_cuenta set nombre_banco="'.$this->nombre_banco.'",numero="'.$this->numero.'",cci="'.$this->cci;
            $q.='",moneda_ID='.$this->moneda_ID.',usuario_mod_id='.$this->usuario_mod_id.', fdm=now() ';
            $q.=' WHERE ID='.$this->ID ;
           
            $retorna = $cn->transa($q);
            
            $this->getMessage="Se actualizó correctamente.";
            return $retorna;
        } catch (Exeption $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }  
    function eliminar() {
        $cn = new connect_new();
        $retornar = -1;
        try {

            $q = 'UPDATE numero_cuenta SET del=1,usuario_mod_id=' . $this->usuario_mod_id . ', fdm=Now()';
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
            $q.=' from numero_cuenta  ';
            $q.=' where del=0 ';

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
    
    
    
    static function getByID1($moneda_ID) {
        $cn = new connect_new();
        try {
            $q = 'Select ID,nombre_banco,numero,cci,moneda_ID';
            $q.=' from numero_cuenta ';
            $q.=' where del=0 and moneda_ID=' . $moneda_ID;
           // $q.=' order by';
            //echo $q;
            $dt = $cn->getGrid($q);
            $oNumero_Cuenta = null;

            foreach ($dt as $item) {
                $oNumero_Cuenta = new numero_cuenta();
                $oNumero_Cuenta->ID = $item['ID'];
                $oNumero_Cuenta->nombre_banco = $item['nombre_banco'];
                $oNumero_Cuenta->numero = $item['numero'];
                $oNumero_Cuenta->cci = $item['cci'];
                $oNumero_Cuenta->moneda_ID = $item['moneda_ID'];
             
            }
            return $oNumero_Cuenta;
        } catch (Exeption $ex) {
            throw new Exception($ex);
        }
    }   
    static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='ID asc')
	{
		$cn =new connect_new();
		try 
		{
			$q='select ID,nombre_banco,numero,cci,moneda_ID,ifnull(abreviatura,"") as abreviatura';
			$q.=' FROM numero_cuenta';
			$q.=' where del=0 ';
			
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
			throw new Exception($q);
		}
	}
}
