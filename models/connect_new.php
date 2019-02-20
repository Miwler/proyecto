<?php
class connect_new
{
	var $db;
	var $sb_user;
	var $db_password;
	var $gError;
	//var $connect;
        var $connect_new;

	function __construct()
	{

            //$this->host='200.4.228.195';
            //$this->host='192.168.8.240';
						//$this->host='192.168.8.240';
            $this->host='192.168.1.24';
            //$this->db='bdsystemsales';
            //$this->db='bd_ventas_prueba';
            //$this->db='bd_jjsoluciones_test' ;
			$this->db='bd_desarrollo' ;
            $this->db_user='administrador';

            $this->db_password='Lima123';
            //$this->db_password='';

            //$this->db_password='';
            $this->gError='';
            //$this->connect();
            $this->connect_new();
	}
        function connect_new(){
            try{
                $mysqli = new mysqli($this->host, $this->db_user, $this->db_password, $this->db);
                if($mysqli->connect_errno){
                    throw new Exception("Ocurrió un error al conectarse a la base de datos Error=".$mysqli->connect_errno);
                }else{
                    $this->connect_new=$mysqli;
                }
                
            }catch(Exception $ex){
                throw new Exception($ex->getMessage());
                log_error(__FILE__,"connect_new.connect_new", $ex->getMessage());
            }
            
        }

	
        function disconnect_new()
	{
            $this->connect_new->close();
	}
	function getData($q)
	{
		try
		{
                    if (!($sentencia = $this->connect_new->prepare($q))) {
                        throw new Exception("Falló la preparación: (" .$this->connect_new->errno.")".$q);
                    }
                    if (!$sentencia->execute()) {
                        throw new Exception("Falló la ejecución: ("  .$this->connect_new->errno.")");

                    }
                    $resultado =$sentencia->get_result();
                    
                    $rows=array();
                    while($row = $resultado->fetch_row()) 
                    {
                        $rows[] = $row;

                    }  
                    
                    $resultado->free();

                    $this->disconnect_new();
                    if(count($rows)==0)
                    {
                        $rows[0][0]='';
                    }
                    
                    return $rows[0][0];
                    
                  
		}catch(Exception $ex)
		{
			$this->disconnect_new();
                        log_error(__FILE__, "connect_new.getData", $ex->getMessage());
			throw new Exception('Ocurrio un Error en la consulta');
		}
	}

        function getGrid($q)
	{
		try
		{
                    if (!($sentencia = $this->connect_new->prepare($q))) {
                        throw new Exception("Falló la preparación: (" .$this->connect_new->errno.")");
                    }
                    if (!$sentencia->execute()) {
                        throw new Exception("Falló la ejecución: ("  .$this->connect_new->errno.")");

                    }
                    $resultado =$sentencia->get_result();
                    $rows=array();
                    while($row = $resultado->fetch_assoc()) 
                    {
                        $rows[] = $row;

                    }  

                    $resultado->free();

                    $this->disconnect_new();
                    return $rows;
			
		}catch(Exception $ex)
		{
			$this->disconnect_new();
                        log_error(__FILE__,"connect_new.getGrid", $ex->getMessage());
			throw new Exception($ex->getMessage());
		}
	}
        function transa($q)
	{
		try
		{
                    $retorna=0;
                    if (!($sentencia = $this->connect_new->prepare($q))) {
                        throw new Exception("Falló la preparación: (" .$this->connect_new->errno.")");
                    }
                    if (!$sentencia->execute()) {
                        throw new Exception("Falló la ejecución: ("  .$this->connect_new->errno.")");

                    }else{
                        $retorna=1;
                    }
                    $this->disconnect_new();
 
                    return $retorna;
		}catch(Exception $ex)
		{
			$this->disconnect_new();
                        log_error(__FILE__,"connect_new.transa", $ex->getMessage().$q);
			throw new Exception($ex->getMessage());
		}
	}
        function getTabla($q)
	{
             
		try
		{
                    if (!($sentencia = $this->connect_new->prepare($q))) {
                        throw new Exception("Falló la preparación: (" .$this->connect_new->errno.")");
                    }
                    if (!$sentencia->execute()) {
                        throw new Exception("Falló la ejecución: ("  .$this->connect_new->errno.")");

                    }
                    $resultado =$sentencia->get_result();
               
                    $rows=array();
                    while($row = mysqli_fetch_assoc($resultado)) 
                    {
                            $rows[] = array_map("utf8_encode",$row);
                    }  

                    $resultado->free();
                
                
                    $this->disconnect_new();
                    
                    return $rows;
		}catch(Exception $ex)
		{
			$this->disconnect_new();
                        log_error(__FILE__,"connect_new.getTabla", $ex->getMessage());
			throw new Exception($ex->getMessage());
		}
                
	}
       

        function store_procedure_getGrid($pv_proc, $pt_args )
        {
            try{
                $po_db=$this->connect_new();
                //$po_db= new mysqli($this->host, $this->db_user, $this->db_password, $this->db);
                if (empty($pv_proc) || empty($pt_args))
                {
                    throw new Exception("Falta parametros");
                }
                $lv_call   = "CALL `$pv_proc`(";
                $lv_select = "SELECT";
                $lv_log = "";
                foreach($pt_args as $lv_key=>$lv_value)
                {

                    $lv_query = "SET @_$lv_key = '$lv_value'";
                    $lv_log .= $lv_query.";\n";
                    if (!$lv_result = $this->connect_new->query($lv_query))
                    {
                        /* Write log */
                        throw new Exception("Los parámetros son incorrectos");
                    }
                    $lv_call   .= " @_$lv_key,";
                    $lv_select .= " @_$lv_key AS $lv_key,";
                }
                $lv_call   = substr($lv_call, 0, -1).")";
                $lv_select = substr($lv_select, 0, -1);
                $lv_log .= $lv_call;
               //echo $lv_log;
                if (!($sentencia = $this->connect_new->prepare($lv_call))) 
                {
                    throw new Exception("Falló la preparación: (" .$this->connect_new->errno.")");
                    //echo "Falló la preparación: (" . $mysqli->errno . ") " . $mysqli->error;
                }
                if (!$sentencia->execute()) {
                    throw new Exception("Falló la ejecución: ("  .$this->connect_new->errno.")");
                    
                }
                $resultado =$sentencia->get_result();
                $rows=array();
                while($row = $resultado->fetch_assoc()) 
                {
                    $rows[] = $row;
                    
                    //$rows[] = $row;
                }  
                
                $resultado->free();
                
                /*if(count($rows)==0){
                    $rows=$rows;
                }*/
                $this->disconnect_new();
                return $rows;

            }catch(Exception $ex){
                log_error(__FILE__,"connect_new.store_procedure_getGrid", $ex->getMessage()."\n".$lv_log);
                $this->disconnect_new();
                throw new Exception('Ocurrio un Error en la consulta');
            }
            
            
            /* Write log */
            //return false;
            //$po_db->close();
        }
        function store_procedure_getData($pv_proc,$pt_args)
        {
            try{
                $po_db=$this->connect_new();
                //$po_db= new mysqli($this->host, $this->db_user, $this->db_password, $this->db);
                if (empty($pv_proc) || empty($pt_args))
                {
                    throw new Exception("Falta parametros");
                }
                $lv_call   = "CALL `$pv_proc`(";
                $lv_select = "SELECT";
                $lv_log = "";
                foreach($pt_args as $lv_key=>$lv_value)
                {

                    $lv_query = "SET @_$lv_key = '".$lv_value."'";
                    $lv_log .= $lv_query.";\n";
                    if (!$lv_result = $this->connect_new->query($lv_query))
                    {
                        /* Write log */
                        throw new Exception("Los parámetros son incorrectos");
                    }
                    $lv_call   .= " @_$lv_key,";
                    $lv_select .= " @_$lv_key AS $lv_key,";
                }
                $lv_call   = substr($lv_call, 0, -1).")";
                $lv_select = substr($lv_select, 0, -1);
                $lv_log .= $lv_call;
                //echo $lv_log;
                if (!($sentencia = $this->connect_new->prepare($lv_call))) 
                {
                    throw new Exception("Falló la preparación: (" .$this->connect_new->errno.")");
                    //echo "Falló la preparación: (" . $mysqli->errno . ") " . $mysqli->error;
                }
                if (!$sentencia->execute()) {
                    throw new Exception("Falló la ejecución: ("  .$this->connect_new->errno.")");
                    
                }
                $resultado =$sentencia->get_result();
                 
                 // print_r($resultado->fetch_assoc());
                //var_dump($rows);
                $rows=array();
               
                while($row = $resultado->fetch_row()) 
                {
                    $rows[] = $row;
                }
                //print_r($rows[0][0]);
                $resultado->free();
                $this->disconnect_new();
                
                if(count($rows)==0){
                    
                    $rows[0][0]='';
                }
                
                return $rows[0][0];
                

            }catch(Exception $ex){
                log_error(__FILE__, "connect_new.store_procedure_getData", $ex->getMessage().$lv_log);
                $this->disconnect_new();
                throw new Exception('Ocurrio un Error en la consulta');
            }

        }
        function store_procedure_transa($pv_proc,$pt_args,$out)
        {
            try{
                //$this->connect_new();
                //$po_db= new mysqli($this->host, $this->db_user, $this->db_password, $this->db);
                if(!isset($out)){
                    throw new Exception("Falta indicar el parametro de retorno.");
                }
                if (empty($pv_proc) || empty($pt_args))
                {
                    throw new Exception("Faltan parametros");
                }
                $lv_call   = "CALL `$pv_proc`(";
                $lv_select = "SELECT";
                $lv_log = "";
                $i=0;
                $campo_retorno='';
                $val='';
                foreach($pt_args as $lv_key=>$lv_value)
                {
                    $val.=",'".$lv_value."'";
                    if(strtoupper($lv_value)!='NULL'){
                        $lv_query = "SET @_".$lv_key." = '".$lv_value."'";
                    }else{
                        $lv_query = "SET @_".$lv_key." = null";
                    }
                    
                    $lv_log .= $lv_query.";\n";
                   
                    if (!$lv_result = $this->connect_new->query($lv_query))
                    {
                        /* Write log */
                        throw new Exception("Los parámetros son incorrectos");
                    }
                    $lv_call   .= " @_$lv_key,";
                    
                    if($i==$out){
                        $lv_select .= " @_$lv_key AS $lv_key,";
                        $campo_retorno=$lv_key;
                    }
                
                    $i++;
                }
                
                $lv_call   = substr($lv_call, 0, -1).")";
                $lv_select = substr($lv_select, 0, -1);
                //$lv_log .= $val;
                $lv_log .= $lv_call;
                $lv_log .= $lv_select;
             // echo $lv_log;
                //echo $val;
                //echo $lv_select;
                if (!($sentencia = $this->connect_new->prepare($lv_call))) 
                {
                    throw new Exception("Falló la preparación: (" .$this->connect_new->errno.")");
                    //echo "Falló la preparación: (" . $mysqli->errno . ") " . $mysqli->error;
                }
                if (!$sentencia->execute()) {
                    throw new Exception("Falló la ejecución: ("  .$this->connect_new->errno.")");
                    
                }
                if (!($sentencia = $this->connect_new->prepare($lv_select))) 
                {
                    throw new Exception("Falló la preparación: (" .$this->connect_new->errno.")");
                    //echo "Falló la preparación: (" . $mysqli->errno . ") " . $mysqli->error;
                }
                if (!$sentencia->execute()) {
                    throw new Exception("Falló la ejecución: ("  .$this->connect_new->errno.")");
                    
                }
               
                $resultado =$sentencia->get_result();
                 
                $lt_result=$resultado->fetch_assoc();
                $resultado->free();
                
                
                $this->disconnect_new();
                return $lt_result[$campo_retorno];

            }catch(Exception $ex){
                
                $this->disconnect_new();
                log_error(__FILE__, "connect_new.store_procedure_transa", $ex->getMessage()."\n".$lv_log);
                throw new Exception($ex);
            }
            

        }
        function store_procedure_getGridParse($pv_proc, $pt_args )
        {
            try{
                $po_db=$this->connect_new();
                //$po_db= new mysqli($this->host, $this->db_user, $this->db_password, $this->db);
                if (empty($pv_proc) || empty($pt_args))
                {
                    throw new Exception("Falta parametros");
                }
                $lv_call   = "CALL `$pv_proc`(";
                $lv_select = "SELECT";
                $lv_log = "";
                foreach($pt_args as $lv_key=>$lv_value)
                {

                    $lv_query = "SET @_$lv_key = '$lv_value'";
                    $lv_log .= $lv_query.";\n";
                    if (!$lv_result = $this->connect_new->query($lv_query))
                    {
                        /* Write log */
                        throw new Exception("Los parámetros son incorrectos");
                    }
                    $lv_call   .= " @_$lv_key,";
                    $lv_select .= " @_$lv_key AS $lv_key,";
                }
                $lv_call   = substr($lv_call, 0, -1).");";
                $lv_select = substr($lv_select, 0, -1);
                $lv_log .= $lv_call;
                //echo $lv_log;
                if (!($sentencia = $this->connect_new->prepare($lv_call))) 
                {
                    throw new Exception("Falló la preparación: (" .$this->connect_new->errno.")");
                    //echo "Falló la preparación: (" . $mysqli->errno . ") " . $mysqli->error;
                }
                if (!$sentencia->execute()) {
                    throw new Exception("Falló la ejecución: ("  .$this->connect_new->errno.")");
                    
                }
                $resultado =$sentencia->get_result();
                $rows=array();
                while($row = $resultado->fetch_assoc()) 
                {
                    $rows[] = array_map("utf8_encode",$row);
                    
                    //$rows[] = $row;
                }  
                
                $resultado->free();
                
                /*if(count($rows)==0){
                    $rows=$rows;
                }*/
                $this->disconnect_new();
                return $rows;

            }catch(Exception $ex){
                log_error(__FILE__, "connect_new.store_procedure_getGridParse", $ex->getMessage()."\n".$lv_log);
                $this->disconnect_new();
                throw new Exception('Ocurrio un Error en la consulta');
            }
            
            
            /* Write log */
            //return false;
            //$po_db->close();
        }
}
?>
