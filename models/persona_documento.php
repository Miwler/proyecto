<?php

class persona_documento {
    private $ID;
    private $persona_ID;
    private $tipo_documento_ID;
    private $numero;
    private $usuario_id;
    private $usuario_mod_id;
    private $getMessage;

    public function __set($var, $valor)
    {
            // convierte a minúsculas toda una cadena la función strtolower
            $temporal = $var;

            // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
            if (property_exists('persona_documento',$temporal))
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
            if (property_exists('persona_documento', $temporal))
             {
                    return $this->$temporal;
             }

            // Retorna nulo si no existe
            return null;
    }
    function insertar() {
        $cn = new connect();
        $retornar = -1;
        try {

            $q = 'select ifnull(max(ID),0)+1 from persona_documento;';
            
            $ID=$cn->getData($q);
            $q = 'insert into persona_documento(ID,persona_ID,tipo_documento_ID,numero,usuario_id) values (';
            $q.= $ID.','.$this->persona_ID.','.$this->tipo_documento_ID.',"'.$this->numero.'",'.$this->usuario_id.');';
           
            $retornar = $cn->transa($q);
            $this->ID = $ID;
            $this->getMessage = 'Se guardó correctamente ';
            return $retornar;
        } catch (Exception $ex) {

            throw new Exception($q);
        }
    }
    
    function actualizar() {
        $cn = new connect_new();
        $retornar = -1;
        try {
            $q = 'update persona_documento set persona_ID="' . $this->persona_ID ;
            $q.= '",tipo_documento_ID="' . $this->tipo_documento_ID. '",numero="' . $this->numero ;
            $q.= '",usuario_mod_id=' . $this->usuario_mod_id;
            $q.= ', fdm=now() where del=0 and ID=' . $this->ID;
            $retornar = $cn->transa($q);
            $this->getMessage = 'Se actualizó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            
        }
    }
    
    static function getByID($ID)
    {
        $cn =new connect();
        try 
        {
            $q='Select ID,persona_ID,tipo_documento_ID,numero,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
            $q.=' from persona_documento ';
            $q.=' where del=0 and ID='.$ID;

            $dt=$cn->getGrid($q);			
            $oPersona_Numero=null;

            foreach($dt as $item)
            {
                $oPersona_Numero=new persona_documento();
                $oPersona_Numero->ID=$item['ID'];
                $oPersona_Numero->persona_ID=$item['persona_ID'];
                $oPersona_Numero->tipo_documento_ID=$item['tipo_documento_ID'];
                $oPersona_Numero->numero=$item['numero'];
                $oPersona_Numero->usuario_id=$item['usuario_id'];
                $oPersona_Numero->usuario_mod_id=$item['usuario_mod_id'];

            }			
            return $oPersona_Numero;

        }catch(Exeption $ex)
        {
                throw new Exception($q);
        }
    }

    static function getCount($filtro='')
    {
            $cn =new connect();
            try 
            {
                    $q='select count(ID) ';
                    $q.=' FROM persona_documento ';
                    $q.=' where del=0 ';

                    if ($filtro!='')
                    {
                            $q.=' and '.$filtro;
                    }

                    $resultado=$cn->getData($q);									

                    return $resultado;					
            }catch(Exception $ex)
            {
                    throw new Exception($q);
            }
    } 

    static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='ID asc')
    {
        $cn =new connect();
        try 
        {
            $q='Select ID,persona_ID,tipo_documento_ID,numero,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
            $q.=' from persona_documento ';
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
    
    
    
 
    
    
}
