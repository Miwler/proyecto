<?php
class connect_new
{
	private $db;
	private $sb_user;
	private $db_password;
	private $gError;
	//var $connect;
        private  $connect_new;

	function __construct()
	{

            $this->host='192.168.1.24';
            $this->db='bd_desarrollo' ;
            $this->db_user='administrador';

            $this->db_password='Lima123';
            $this->gError='';
            $this->connect_new();
	}
        function __destruct(){
            $this->connect_new=null;
        }
        function connect_new(){
            try{
             $arrOptions = array(
                            PDO::ATTR_EMULATE_PREPARES => true, 
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                         );
                        $this->connect_new=new PDO('mysql:host='.$this->host.';dbname='.$this->db.';charset=utf8',$this->db_user,$this->db_password,$arrOptions);
			$this->connect_new->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                       
                
            }catch(PDOException $ex){
                log_error(__FILE__,"connect_new.connect_new", $ex->getMessage());
                throw new Exception($ex->getMessage());
                
            }
            
        }

	
        function disconnect_new()
	{
            $this->connect_new=null;
	}
	function getData($q)
	{
            //echo $q;
		try
		{
                    $sentencia=$this->connect_new->query($q);
                    
                    $resultado =$sentencia->fetchAll();
                    $retorna="";
                    if(count($resultado)>0){
                        $retorna=$resultado[0][0];
                    }
                    
                    $this->disconnect_new();
                    
                    
                    return $retorna;
                    
                  
		}catch(PDOException $ex)
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
                    
                    if($this->connect_new==null){
                        $this->connect_new();
                    }
                    /*$resultado=$this->connect_new->query($q);
                        $dt=$resultado->fetchAll();*/
                    
                   if (!$lv_result = $this->connect_new->query($q))
                    {
                        
                        throw new Exception("Los parámetros son incorrectos");
                    }
                    if(!$sentencia = $this->connect_new->prepare($q)){
                        throw new Exception("Falló en la preparación: ("  .$this->connect_new->errno.")");
                    }
                    if (!$sentencia->execute()) {
                        throw new Exception("Falló la ejecución: ("  .$this->connect_new->errno.")");

                    }
                    $dt =$sentencia->fetchAll();
                    

                    $this->disconnect_new();
                    return $dt;
			
		}catch(Exception $ex)
		{
			$this->disconnect_new();
                        log_error(__FILE__,"connect_new.getGrid", $ex->getMessage());
			throw new Exception("Ocurrió un error en la bd");
		}
	}
        function transa($q)
	{
		try
		{
                    $retorna=0;
                    if($this->connect_new==null){
                        $this->connect_new();
                    }
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
		}catch(PDOException $ex)
		{
			$this->disconnect_new();
                        log_error(__FILE__,"connect_new.transa", $ex->getMessage().$q);
			throw new Exception("Error en la conexion");
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
                    //$resultado =$sentencia->fetchAll();
               
                    $rows=array();
                    while($row = $sentencia->fetch(PDO::FETCH_ASSOC)) 
                    {
                            $rows[] = array_map("utf8_decode",$row);
                    }  

                    //$resultado->free();
                
                
                    $this->disconnect_new();
                    
                    return $rows;
		}catch(PDOException $ex)
		{
			$this->disconnect_new();
                        log_error(__FILE__,"connect_new.getTabla", $ex->getMessage());
			throw new Exception("Error en la bd");
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

                    $lv_query = "SET @_".$lv_key." = ".$this->connect_new->quote($lv_value);
                    $lv_log .= $lv_query.";\n";
                    
                    
                    if (!$lv_result = $this->connect_new->query($lv_query))
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
                    throw new Exception("Falló la preparación: (".$this->connect_new->errno.")");
                    //echo "Falló la preparación: (" . $mysqli->errno . ") " . $mysqli->error;
                }
                if (!$sentencia->execute()) {
                    throw new Exception("Falló la ejecución: (".$this->connect_new->errno.")");
                    
                }
                $resultado =$sentencia->fetchAll(PDO::FETCH_ASSOC);
                
                $this->disconnect_new();
                return $resultado;

            }catch(PDOException $ex){
                log_error(__FILE__,"connect_new.store_procedure_getGrid", $ex->getMessage()."\n".$lv_log);
                $this->disconnect_new();
                throw new Exception('Ocurrio un Error en la consulta');
            }
            
            
         
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

                    $lv_query = "SET @_$lv_key = ".$this->connect_new->quote($lv_value);
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
                $resultado =$sentencia->fetch();
                $retorna="";
                if(count($resultado)>0){
                    
                    $retorna=$resultado[0];
                }
                $this->disconnect_new();
                return $retorna;
                

            }catch(PDOException $ex){
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
                        $lv_query = "SET @_".$lv_key." = ".$this->connect_new->quote($lv_value);
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
                //echo $lv_log;
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

                    $lv_query = "SET @_".$lv_key."= ".$this->connect_new->quote($lv_value);
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
                
               
                $this->disconnect_new();
                return $resultado;

            }catch(PDOException $ex){
                log_error(__FILE__, "connect_new.store_procedure_getGridParse", $ex->getMessage()."\n".$lv_log);
                $this->disconnect_new();
                throw new Exception('Ocurrio un Error en la consulta');
            }
            
            
            /* Write log */
            //return false;
            //$po_db->close();
        }
        
        function store_procedure_getGridValidate($pv_proc, $pt_args )
        {
            try{
             
                
                $po_db=$this->connect_new();
                //$po_db= new mysqli($this->host, $this->db_user, $this->db_password, $this->db);
                if (empty($pv_proc) || empty($pt_args))
                {
                    throw new Exception("Falta parametros");
                }
                $lv_call   = "CALL $pv_proc(";
                
                foreach($pt_args as $lv_key=>$lv_value)
                {
                    $lv_call.="?,";
                    
                }
                $lv_call   = substr($lv_call, 0, -1).")";
                if (!($consulta = $this->connect_new->prepare($lv_call))) 
                {
                    throw new Exception("Falló la preparación: (" .$this->connect_new->errno.")");
                    //echo "Falló la preparación: (" . $mysqli->errno . ") " . $mysqli->error;
                }
                    $i=1;
                foreach($pt_args as $lv_key=>$lv_value){
                    $consulta->bindParam($i,$lv_value);
                }
                
               //echo $lv_log;
                
                if (!$consulta->execute()) {
                    throw new Exception("Falló la ejecución: ("  .$this->connect_new->errno.")");
                    
                }
                $resultado =$consulta->fetchAll();
                
                $this->disconnect_new();
                return $resultado;

            }catch(PDOException $ex){
                log_error(__FILE__,"connect_new.store_procedure_getGrid", $ex->getMessage()."\n".$lv_log);
                $this->disconnect_new();
                throw new Exception('Ocurrio un Error en la consulta');
            }
            
            
         
        }
        function store_procedure_transa1($pv_proc,$pt_args,$out)
        {
            try{
                //$this->connect_new();
                //$po_db= new mysqli($this->host, $this->db_user, $this->db_password, $this->db);
                $lv_call   = "CALL $pv_proc(";
                $lv_call1="";
                foreach($pt_args as $lv_key=>$lv_value)
                {
                    $lv_call1.="?,";
                    
                }
                $lv_call.= substr($lv_call1, 0, -1).")";
               
                $consulta = $this->connect_new->prepare($lv_call);
                $i=1;
                $retorna=0;
                
                foreach($pt_args as $lv_key=>$lv_value){
                   // $consulta->bindParam($i,$lv_value);
                    if($out==($i-1)){
                        
                        $consulta->bindParam(1,$retorna,PDO::PARAM_STR, 4000);
                    }else{
                        
                        $consulta->bindParam($i,$lv_value);
                    }
                    
                    $i++;
                }
                
               //echo $lv_log;
                $consulta->execute();
                /*if (!) {
                    throw new Exception("Falló la ejecución: ("  .$this->connect_new->errno.")");
                    
                }*/
                echo $retorna;
                
                $resultado =$consulta->fetch();
                 
               
                $this->disconnect_new();
                return $resultado[0];

            }catch(PDOException $ex){
                
                $this->disconnect_new();
                log_error(__FILE__, "connect_new.store_procedure_transa", $ex->getMessage()."\n");
                throw new Exception($ex->getMessage());
            }
            

        }
}       
?>
