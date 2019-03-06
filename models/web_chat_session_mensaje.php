<?php
class web_chat_session_mensaje
{
	private $ID;
	private $web_chat_session_ID;
        private $usuario_ID_chat;
        private $mensaje;
        private $ruta_archivo;
       	private $usuario_id;	
	private $usuario_mod_id;	
	private $getMessage;
		
	public function __set($var, $valor)
	{
		// convierte a minúsculas toda una cadena la función strtolower
		$temporal = $var;
		
		// Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
		if (property_exists('web_chat_session_mensaje',$temporal))
		 {
			$this->$temporal = $valor;
		 }
		 else
		 {
			echo $var . " No existe.";
		 }
	 }
	 
	 public function __get($var)
	 {
		$temporal = $var;
		
		// Verifica que exista
		if (property_exists('web_chat_session_mensaje', $temporal))
		 {
			return $this->$temporal;
		 }
		 
		// Retorna nulo si no existe
		return null;
	}
	
	function insertar(){
            
            $retornar=-1;
            try{	$cn =new connect_new();
                    $q='select ifnull(max(ID),0)+1 from web_chat_session_mensaje';
                    $ID=$cn->getData($q);
					$cn =new connect_new();
                    $q='INSERT INTO web_chat_session_mensaje (ID,web_chat_session_ID,usuario_ID_chat,mensaje,ruta_archivo,usuario_id)';
                    $q.=' VALUES ('.$ID.','.$this->web_chat_session_ID.','.$this->usuario_ID_chat.',"'.$this->mensaje.'","';
                    $q.=$this->ruta_archivo.'",'.$this->usuario_id.');';
                    $retornar=$cn->transa($q);
                    $this->ID=$ID;
                    $this->getMessage='Se guardó correctamente.';
                    return $retornar;
            }
            catch(Exception $ex){
                    throw new Exception("Ocurrio un Error en la consulta");
            }
	}	
	
	static function getByID($ID)
	{
            $cn =new connect_new();
            try 
            {
                $q='Select ID,nombre_visitante,email_visitante,usuario_remitente_ID,usuario_receptor_ID,';
                $q.='fecha,session,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
                $q.=' from web_chat_session ';
                $q.=' where del=0 and ID='.$ID;
                //echo $q;
                $dt=$cn->getGrid($q);			
                $oWeb_Chat_Session=null;

                foreach($dt as $item)
                {
                    $oWeb_Chat_Session=new web_chat_session();
                    $oWeb_Chat_Session->ID=$item['ID'];
                    $oWeb_Chat_Session->nombre_visitante=$item['nombre_visitante'];
                    $oWeb_Chat_Session->email_visitante=$item['email_visitante'];
                    $oWeb_Chat_Session->usuario_remitente_ID=$item['usuario_remitente_ID'];
                    $oWeb_Chat_Session->usuario_receptor_ID=$item['usuario_receptor_ID'];
                    $oWeb_Chat_Session->fecha=$item['fecha'];
                    $oWeb_Chat_Session->session=$item['session'];
                    $oWeb_Chat_Session->usuario_id=$item['usuario_id'];
                    $oWeb_Chat_Session->usuario_mod_id=$item['usuario_mod_id'];
                }			
                return $oWeb_Banner;

            }catch(Exeption $ex)
            {
                    throw new Exception("Ocurrio un Error en la consulta");
            }
	}
	
	
    static function getCount($filtro='')
	{
            $cn =new connect_new();
            try 
            {
                $q='select count(ID) ';
                $q.=' FROM web_chat_session_mensaje';
                $q.=' where del=0 ';
                if ($filtro!='')
                {
                        $q.=' and '.$filtro;
                }
                $resultado=$cn->getData($q);									
                return $resultado;					
            }catch(Exception $ex)
            {
                throw new Exception("Ocurrio un Error en la consulta");
            }
	} 
	
    static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='ID asc')
    {
        $cn =new connect_new();
        try 
        {
            $q='SELECT ID,web_chat_session_ID,usuario_ID_chat,mensaje,ruta_archivo,estado_ID,usuario_id,date_format(fdc,"%d/%m/%Y  %h:%i:%s %p" ) as fdc';
            $q.=' FROM web_chat_session_mensaje';
            $q.=' where del=0';

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
                throw new Exception($q);
        }
    }
    static function getGridChat($filtro='',$group="",$desde=-1,$hasta=-1,$order='wm.ID desc')
    {
        $cn =new connect_new();
        try 
        {
            $q='select wm.web_chat_session_ID,wm.mensaje,wm.fdc,count(wm.ID) as contador,ifnull(us.foto,"") as foto,';
            $q.="(case when ws.usuario_remitente_ID=-1 then ws.nombre_visitante else concat(pe.nombres,' ',pe.apellido_paterno) end)as remitente";
            $q.=" from web_chat_session_mensaje wm,web_chat_session ws left join usuario us on ws.usuario_remitente_ID=us.ID left join persona pe on us.persona_ID=pe.ID";
            $q.=" where wm.del=0 and  wm.web_chat_session_ID=ws.ID";
            if($filtro!=''){
                    $q.=' and '.$filtro;
            }
            if($group!=''){
                    $q.=' group by '.$group;
            }
            $q.=' Order By '.$order;

            if($desde!=-1&&$hasta!=-1){
                    $q.=' Limit '.$desde.','.$hasta;
            }			

            $dt=$cn->getGrid($q);									
            return $dt;												
        }catch(Exception $ex)
        {
                throw new Exception($q);
        }
    }

}

?>