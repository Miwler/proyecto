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
class salida_numero_cuenta {
    private $ID;
    private $salida_ID;
    private $numero_cuenta_ID;
    private $usuario_id;
    private $usuario_mod_id;
    Private $message;
    public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el dias es la cadena en "$temporal"		
        if (property_exists('salida_numero_cuenta', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('salida_numero_cuenta', $temporal)) {
            return $this->$temporal;
        }

        // Retorna nulo si no existe
        return null;
    }
    function insertar() {
        $cn = new connect();
        $retornar = -1;
        try {

            $q = 'select ifnull(max(ID),0)+1 from salida_numero_cuenta;';
            $ID=$cn->getData($q);
            $q = 'insert into salida_numero_cuenta(ID,salida_ID,numero_cuenta_ID,usuario_id)';
            $q.='values('.$ID.',' . $this->salida_ID. ',' .$this->numero_cuenta_ID . ','. $this->usuario_id . ');';
            //echo $q;
            $retornar = $cn->transa($q);
            $this->ID=$ID;
            
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
            $q = 'update salida_numero_cuenta set salida_ID=' . $this->salida_ID . ',numero_cuenta_ID=' . $this->numero_cuenta_ID . ',usuario_mod_id=' . $this->usuario_mod_id;
            $q.=', fdm=now() where del=0 and id=' . $this->ID;
            $retornar = $cn->transa($q);
            $this->message = 'Se guardó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            
        }
    }

    function eliminar() {
        $cn = new connect();
        $retornar = -1;
        try {

            $q = 'delete from salida_numero_cuenta ';
            $q.=' WHERE ID=' . $this->ID;

            $retornar = $cn->transa($q);

            $this->message = 'Se eliminó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }
    static function getByID($ID) {
        $cn = new connect();
        try {
            $q = 'Select ID,salida_ID,numero_cuenta_ID,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
            $q.=' from salida_numero_cuenta ';
            $q.=' where del=0 and ID=' . $ID;

            $dt = $cn->getGrid($q);
            $osalida_numero_cuenta = null;

            foreach ($dt as $item) {
                $osalida_numero_cuenta = new salida_numero_cuenta();

                $osalida_numero_cuenta->ID = $item['ID'];
                $osalida_numero_cuenta->salida_ID = $item['salida_ID'];
				$osalida_numero_cuenta->numero_cuenta_ID = $item['numero_cuenta_ID'];
                $osalida_numero_cuenta->usuario_id = $item['usuario_id'];
                $osalida_numero_cuenta->usuario_mod_id = $item['usuario_mod_id'];
             
            }
            return $osalida_numero_cuenta;
        } catch (Exeption $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }
     
    static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='ID asc')
	{
		$cn =new connect();
		try 
		{
			$q='select ID,salida_ID,numero_cuenta_ID,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
			$q.=' FROM salida_numero_cuenta';
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
			throw new Exception('Ocurrio un error en la consulta');
		}
	}
    static function getGrid1($filtro='',$desde=-1,$hasta=-1,$order='ovnc.ID asc')
    {
        $cn =new connect();
        try 
        {
            $q='select ovnc.ID,ovnc.salida_ID,ovnc.numero_cuenta_ID,ovnc.usuario_id,ifnull(ovnc.usuario_mod_id,-1) as usuario_mod_id,';
            $q.='nc.numero,nc.nombre_banco,nc.cci,nc.moneda_ID,nc.abreviatura';
            $q.=' FROM salida_numero_cuenta ovnc,salida ov, numero_cuenta nc';
            $q.=' where ovnc.salida_ID=ov.ID and ovnc.numero_cuenta_ID=nc.ID and ovnc.del=0 ';

            if($filtro!=''){
                    $q.=' and '.$filtro;
            }

            $q.=' Order By '.$order;

            if($desde!=-1&&$hasta!=-1){
                    $q.=' Limit '.$desde.','.$hasta;
            }			
   //echo   $q;     
            $dt=$cn->getGrid($q);									
            return $dt;												
        }catch(Exception $ex)
        {
                throw new Exception('Ocurrio un error en la consulta');
        }
    }
}
