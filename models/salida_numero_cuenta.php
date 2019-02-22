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
    function __construct()
    {
          $this->usuario_id=$_SESSION["usuario_ID"];
      $this->usuario_mod_id=$_SESSION["usuario_ID"];

    }
    function __destruct()
    {
          $this->usuario_id;
      $this->usuario_mod_id;

    }
    function insertar() {
        $cn = new connect_new();
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
        $cn = new connect_new();
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
		$cn =new connect_new();
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
        $cn =new connect_new();
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
    function insertar1()
    {
    $cn =new connect_new();
    try
    {
      $ID=$cn->store_procedure_transa(
          "sp_salida_numero_cuenta_Insert",
            array(
            "iID"=>0,
            "isalida_ID"=>$this->salida_ID,
            "inumero_cuenta_ID"=>$this->numero_cuenta_ID,
            "iusuario_id"=>$this->usuario_id,

        ),0);
      if($ID>0){
        $this->message="El registro se guard? correctamente.";
        $this->ID=$ID;
        return $ID;
      } else {
          throw new Exception("No se registr?");
      }
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "salida_numero_cuenta.insertar", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  function actualizar1()
    {
    $cn =new connect_new();
    $retornar =0;
    try
    {
      $retornar=$cn->store_procedure_transa(
          "sp_salida_numero_cuenta_Update",
            array(
              "retornar"=>$retornar,
                "iID"=>$this->ID,
                "isalida_ID"=>$this->salida_ID,
                "inumero_cuenta_ID"=>$this->numero_cuenta_ID,
                "iusuario_mod_id"=>$this->usuario_mod_id
            ),0);
      if($retornar>0){
          $this->message="Se actualizó correctamente";
      }
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "salida_numero_cuenta.actualizar", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  function eliminar1()
    {
    $cn =new connect_new();
    $retornar =0;
    try
    {
      $retornar=$cn->store_procedure_transa(
          "sp_salida_numero_cuenta_Delete",
            array(
              "retornar"=>$retornar,
              "iID"=>$this->ID,
              "iusuario_mod_id"=>$this->usuario_mod_id ),0
            );
      if($retornar>0)$this->message = "Se elimin? correctamente";
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "salida_numero_cuenta.eliminar", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
}
