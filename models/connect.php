<?php
class connect
{
	var $db;
	var $sb_user;
	var $db_password;
	var $gError;
	var $connect;

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

            //$this->db_password='Lima123';
            $this->db_password='Lima12322';

            //$this->db_password='';
            $this->gError='';
            $this->connect();
	}


	function connect()
	{
		try
		{
                    
			
                        $arrOptions = array(
                            PDO::ATTR_EMULATE_PREPARES => true, 
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                         );
                        $this->connect=new PDO('mysql:host='.$this->host.';dbname='.$this->db.';charset=utf8',$this->db_user,$this->db_password,$arrOptions);
			$this->connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                        
		}catch(PDOException $ex)
		{
			throw new Exception($ex->getMessage());
		}
	}

	function disconnect()
	{
            //$this->connect->close();
		$this->conexion=null;
	}

	function getData($q)
	{
            try
            {
                //$this->connect();
                $result=$this->connect->query($q);
                $dt=$result->fetchAll();

                if(count($dt)==0)
                {
                        $dt[0][0]='';
                }

                $this->disconnect();
                return $dt[0][0];
            }catch(PDOException $ex)
            {
                    $this->disconnect();
                    throw new Exception('Ocurrio un Error en la consulta');
            }
                
	}

        function getGrid($q)
	{
		try
		{
                    //$this->connect();
                    $result=$this->connect->query($q);
                    $dt=$result->fetchAll();
			
			
                        
                    $this->disconnect();
                     return $dt;
                        
		}catch(PDOException $ex)
		{
			$this->disconnect();
			throw new Exception($ex->getMessage());
		}
                
	}
        function getTabla($q)
	{
             $mysqli = new mysqli($this->host, $this->db_user, $this->db_password, $this->db);
		try
		{
                    
                    $result = $mysqli->query($q);
                    
                    $rows=array();
                    while($row = mysqli_fetch_assoc($result)) 
                    {
                            $rows[] = array_map("utf8_encode",$row);
                    }  


                    $result->close();
                    return $rows;
		}catch(PDOException $ex)
		{
			$result->close();
			throw new Exception($ex->getMessage());
		}
                
	}
        
	function transa($q)
	{
		try
		{
                    //$this->connect();
                    $count=$this->connect->exec($q);
                    $this->disconnect();
                    return $count;
		}catch(PDOException $ex)
		{
                    $this->disconnect();
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
                    
                    
                    if (!$lv_result = $this->connect_new->query(unserialize($lv_query)))
                    {
                        
                        throw new Exception("Los parámetros son incorrectos");
                    }
                    $lv_call   .= " @_$lv_key,";
                    $lv_select .= " @_$lv_key AS $lv_key,";
                }
                $lv_call   = substr($lv_call, 0, -1).")";
                $lv_select = substr($lv_select, 0, -1);
                $lv_log.= $lv_call;
               //echo $lv_log;
                if (!($sentencia = $this->connect_new->prepare($lv_call))) 
                {
                    throw new Exception("Falló la preparación: (" .$this->connect_new->errno.")");
                    //echo "Falló la preparación: (" . $mysqli->errno . ") " . $mysqli->error;
                }
                if (!$sentencia->execute()) {
                    throw new Exception("Falló la ejecución: ("  .$this->connect_new->errno.")");
                    
                }
                $resultado =$sentencia->fetchAll();
                
                $this->disconnect_new();
                return $resultado;

            }catch(PDOException $ex){
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
                
                $po_db=$this->connect();
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
                    if (!$lv_result = $this->connect->query($lv_query))
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
                if (!($sentencia = $this->connect->prepare($lv_call))) 
                {
                    throw new Exception("Falló la preparación: (" .$this->connect->errno.")");
                    //echo "Falló la preparación: (" . $mysqli->errno . ") " . $mysqli->error;
                }
                if (!$sentencia->execute()) {
                    throw new Exception("Falló la ejecución: ("  .$this->connect->errno.")");
                    
                }
                $resultado =$sentencia->fetch();
                $retorna="";
                if(count($resultado)>0){
                    
                    $retorna=$resultado[0];
                }
                $this->disconnect();
                return $retorna;
                

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
                        $lv_query = "SET @_".$lv_key." = '".mysqli_real_escape_string($this->connect_new,$lv_value)."'";
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
               
                $resultado =$sentencia->fetch();
                 
               
                $this->disconnect_new();
                return $resultado[0];

            }catch(PDOException $ex){
                
                $this->disconnect_new();
                log_error(__FILE__, "connect_new.store_procedure_transa", $ex->getMessage()."\n".$lv_log);
                throw new Exception("Error en la bd");
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
                $resultado =$sentencia->fetchAll();
                $rows=array();
                while($row = $resultado->fetch_assoc()) 
                {
                    $rows[] = array_map("utf8_encode",$row);
                    
                    //$rows[] = $row;
                }  
                
               
                $this->disconnect_new();
                return $rows;

            }catch(PDOException $ex){
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
