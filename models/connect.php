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
<<<<<<< HEAD
            //$this->db_password='Lima123';
            $this->db_password='Lima123';
=======
            $this->db_password='Lima123';
            //$this->db_password='';
>>>>>>> d5a94c4c5a7423ea1e5a16decc10adc1343e0600
            //$this->db_password='';
            $this->gError='';
            $this->connect();
	}


	function connect()
	{
		try
		{
                    
			$this->connect=new PDO('mysql:host='.$this->host.';dbname='.$this->db,$this->db_user,$this->db_password);
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
        
}
?>
