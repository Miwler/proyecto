<?php

class sexo {

    private $ID;
    private $nombre;
    private $usuario_id;	

    private $getMessage;

    public function __set($var, $valor)
    {
            // convierte a minúsculas toda una cadena la función strtolower
            $temporal = $var;

            // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
            if (property_exists('sexo',$temporal))
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
            if (property_exists('sexo', $temporal))
             {
                    return $this->$temporal;
             }

            // Retorna nulo si no existe
            return null;
    }

    static function getByID($ID)
    {
        $cn =new connect_new();
        try 
        {
            $q='Select ID,nombre,usuario_id';
            $q.=' from sexo ';
            $q.=' where del=0 and ID='.$ID;

            $dt=$cn->getGrid($q);			
            $oSexo=null;

            foreach($dt as $item)
            {
                $oSexo=new sexo();
                $oSexo->ID=$item['ID'];
                $oSexo->nombre=$item['nombre'];
                $oSexo->usuario_id=$item['usuario_id'];

            }			
            return $oSexo;

        }catch(Exeption $ex)
        {
                throw new Exception("Ocurrio un error en la consulta.");
        }
    }

    static function getCount($filtro='')
    {
            $cn =new connect_new();
            try 
            {
                    $q='select count(ID) ';
                    $q.=' FROM sexo ';
                    $q.=' where del=0 ';

                    if ($filtro!='')
                    {
                            $q.=' and '.$filtro;
                    }

                    $resultado=$cn->getData($q);									

                    return $resultado;					
            }catch(Exception $ex)
            {
                    throw new Exception("Ocurrio un error en la consulta");
            }
    } 

    static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='ID asc')
    {
        $cn =new connect_new();
        try 
        {
            $q='SELECT ID, nombre,usuario_id';
            $q.=' FROM sexo';
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
