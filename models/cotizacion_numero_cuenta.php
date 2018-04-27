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
class cotizacion_numero_cuenta {
    private $ID;
    private $cotizacion_ID;
    private $numero_cuenta_ID;
    private $usuario_id;
    private $usuario_mod_id;
    Private $getMessage;
    public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el dias es la cadena en "$temporal"		
        if (property_exists('cotizacion_numero_cuenta', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('cotizacion_numero_cuenta', $temporal)) {
            return $this->$temporal;
        }

        // Retorna nulo si no existe
        return null;
    }
    function insertar() {
        $cn = new connect();
        $retornar = -1;
        try {

            $q = 'select ifnull(max(ID),0)+1 from cotizacion_numero_cuenta;';
            $ID=$cn->getData($q);
            $q = 'insert into cotizacion_numero_cuenta(ID,cotizacion_ID,numero_cuenta_ID,usuario_id)';
            $q.='values('.$ID.',' . $this->cotizacion_ID. ',' .$this->numero_cuenta_ID . ','. $this->usuario_id . ');';
            //echo $q;
            $retornar = $cn->transa($q);
            $this->ID=$ID;
            
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
            $q = 'update cotizacion_numero_cuenta set cotizacion_ID=' . $this->cotizacion_ID . ',numero_cuenta_ID=' . $this->numero_cuenta_ID . ',usuario_mod_id=' . $this->usuario_mod_id;
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

            $q = 'delete from cotizacion_numero_cuenta ';
            $q.=' WHERE ID=' . $this->ID;

            $retornar = $cn->transa($q);

            $this->getMessage = 'Se eliminó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }
    static function getByID($ID) {
        $cn = new connect();
        try {
            $q = 'Select ID,cotizacion_ID,numero_cuenta_ID,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
            $q.=' from cotizacion_numero_cuenta ';
            $q.=' where del=0 and ID=' . $ID;

            $dt = $cn->getGrid($q);
            $oCotizacion_Numero_Cuenta = null;

            foreach ($dt as $item) {
                $oCotizacion_Numero_Cuenta = new cotizacion_numero_cuenta();

                $oCotizacion_Numero_Cuenta->ID = $item['ID'];
                $oCotizacion_Numero_Cuenta->cotizacion_ID = $item['cotizacion_ID'];
		$oCotizacion_Numero_Cuenta->numero_cuenta_ID = $item['numero_cuenta_ID'];
                $oCotizacion_Numero_Cuenta->usuario_id = $item['usuario_id'];
                $oCotizacion_Numero_Cuenta->usuario_mod_id = $item['usuario_mod_id'];
             
            }
            return $oCotizacion_Numero_Cuenta;
        } catch (Exeption $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }
     
    static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='ID asc')
	{
		$cn =new connect();
		try 
		{
			$q='select ID,cotizacion_ID,numero_cuenta_ID,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
			$q.=' FROM cotizacion_numero_cuenta';
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
        static function getGrid1($filtro='',$desde=-1,$hasta=-1,$order='cnc.ID asc')
	{
		$cn =new connect();
		try 
		{
                    $q='select cnc.ID,cnc.cotizacion_ID,cnc.numero_cuenta_ID,cnc.usuario_id,ifnull(cnc.usuario_mod_id,-1) as usuario_mod_id,';
                    $q.='nc.numero,nc.nombre_banco,nc.cci,nc.moneda_ID,nc.abreviatura';
                    $q.=' FROM cotizacion_numero_cuenta cnc,cotizacion co, numero_cuenta nc';
                    $q.=' where cnc.cotizacion_ID=co.ID and cnc.numero_cuenta_ID=nc.ID and cnc.del=0 ';

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
