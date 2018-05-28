<?php

class correlativos {

    private $ID;
    private $comprobante_tipo_ID;
    private $serie;
    private $ultimo_numero;
    private $empresa_ID;
    private $tipo_comprobante_empresa_ID;
    private $electronico;
    private $usuario_id;	
    private $usuario_mod_id;
    private $message;

    public function __set($var, $valor)
    {
            // convierte a minúsculas toda una cadena la función strtolower
            $temporal = $var;

            // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
            if (property_exists('correlativos',$temporal))
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
            if (property_exists('correlativos', $temporal))
             {
                    return $this->$temporal;
             }

            // Retorna nulo si no existe
            return null;
    }
    function insertar()
    {
        $cn =new connect();
        $retornar=-1;
        try{
            
            $q='select ifnull(max(ID),0)+1 as ID from correlativos;';
            $ID=$cn->getData($q);
            $q='INSERT INTO correlativos (ID,empresa_ID,comprobante_tipo_ID,serie,ultimo_numero,usuario_id) ';
            $q.='VALUES ('.$ID.','.$_SESSION['empresa_ID'].','.$this->comprobante_tipo_ID.',"'.$this->serie.'",'.$this->ultimo_numero.','.$this->usuario_id.')';

            $retornar=$cn->transa($q);
            
            $this->ID=$ID;
            $this->message='Se guardó correctamente';
            
            return $retornar;
            
        } catch (Exception $ex) {

            throw new Exception($q);
        }
    }
    function actualizar(){
        $cn =new connect();
	$retornar=-1;
        try{
           
            $q='UPDATE correlativos set comprobante_tipo_ID='.$this->comprobante_tipo_ID.',serie="'.$this->serie.'",ultimo_numero='.$this->ultimo_numero.', usuario_mod_id='.$this->usuario_mod_id;
            $q.=', fdm=now() where del=0 and ID='.$this->ID;
            //echo $q;
            $retornar=$cn->transa($q);
            $this->message='Se guardó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    static function getByID($ID)
    {
            $cn =new connect();
            try 
            {
                    $q='Select ID,serie,ultimo_numero,electronico,tipo_comprobante_empresa_ID,usuario_id';
                    $q.=' from correlativos ';
                    $q.=' where ID='.$ID;

                    $dt=$cn->getGrid($q);			
                    $oCorrelativos=null;

                    foreach($dt as $item)
                    {
                        $oCorrelativos=new correlativos();
                        $oCorrelativos->ID=$item['ID'];
                        $oCorrelativos->serie=FormatTextView($item['serie']);
                        $oCorrelativos->ultimo_numero=$item['ultimo_numero'];
                        $oCorrelativos->electronico=$item['electronico'];
                        $oCorrelativos->tipo_comprobante_empresa_ID=$item['tipo_comprobante_empresa_ID'];
                        $oCorrelativos->usuario_id=$item['usuario_id'];

                    }			
                    return $oCorrelativos;

            }catch(Exeption $ex)
            {
                    throw new Exception("Ocurrio un error en la consulta.");
            }
    }
    static function getBySerie($comprobante_tipo_ID,$serie)
    {
            $cn =new connect();
            try 
            {
                    $q='Select ID,comprobante_tipo_ID,serie,ultimo_numero,usuario_id';
                    $q.=' from correlativos ';
                    $q.='where del=0 and empresa_ID='.$_SESSION['empresa_ID'].' and comprobante_tipo_ID='.$comprobante_tipo_ID.' and serie="'.$serie.'"';
                    //echo $q;
                    $dt=$cn->getGrid($q);			
                    $oCorrelativos=null;

                    foreach($dt as $item)
                    {
                            $oCorrelativos=new correlativos();

                            $oCorrelativos->ID=$item['ID'];
                            $oCorrelativos->comprobante_tipo_ID=$item['comprobante_tipo_ID'];
                            $oCorrelativos->serie=FormatTextView($item['serie']);
                            $oCorrelativos->ultimo_numero=$item['ultimo_numero'];
                            $oCorrelativos->usuario_id=$item['usuario_id'];

                    }			
                    return $oCorrelativos;

            }catch(Exeption $ex)
            {
                    throw new Exception("Ocurrio un error en la consulta.");
            }
    }
    static function getByNumero($tipo_comprobante_ID,$serie)
    {
        $cn =new connect();
        try 
        {
            
            $q='Select ifnull(co.ultimo_numero,0)+1';
            $q.=' from correlativos co,tipo_comprobante_empresa tce,tipo_comprobante tc ';
            $q.=' where co.tipo_comprobante_empresa_ID=tce.ID and tce.tipo_comprobante_ID=tc.ID and co.del=0';
            $q.=' and co.empresa_ID='.$_SESSION['empresa_ID'].' and tc.ID='.$tipo_comprobante_ID.' and serie="'.$serie.'"';
           
            $retorna=$cn->getData($q);			
            		
            return $retorna;

        }catch(Exeption $ex)
        {
                throw new Exception("Ocurrio un error en la consulta.");
        }
    }
    static function getNumero($tabla,$correlativo_ID)
    {
        $cn =new connect();
        try 
        {
            
            $q='select ifnull(cor.ultimo_numero,0)+1';
            $q.=' from correlativos cor,tipo_comprobante_empresa tce';
            $q.=' where cor.tipo_comprobante_empresa_ID=tce.ID and tce.del=0 and cor.del=0 and tce.tabla="'.$tabla.'" and tce.empresa_ID='.$_SESSION['empresa_ID']." and cor.ID=".$correlativo_ID;

            $retorna=$cn->getData($q);			
            		
            return $retorna;

        }catch(Exeption $ex)
        {
                throw new Exception("Ocurrio un error en la consulta.");
        }
    }
    static function getCount($filtro='')
    {
            $cn =new connect();
            try 
            {
                    $q='select count(est.ID) ';
                    $q.=' FROM estado as est';
                    $q.=' where est.del=0 ';

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
            $cn =new connect();
            try 
            {
                    $q='SELECT ID,comprobante_tipo_ID,serie,ultimo_numero,usuario_id';
                    $q.=' FROM correlativos ';
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
    static function getGrid1($filtro='',$desde=-1,$hasta=-1,$order='co.ID asc')
    {
            $cn =new connect();
            try 
            {
                    $q='SELECT co.ID,co.comprobante_tipo_ID,co.serie,co.ultimo_numero,co.usuario_id,ct.nombre';
                    $q.=' from correlativos co,comprobante_tipo ct ';
                    $q.=' where co.comprobante_tipo_ID=ct.ID and co.del=0 ';

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
    static function getGridCorrelativos($tabla)
    {
            $cn =new connect();
            try 
            {
                    $q='select cor.ID,cor.serie,cor.ultimo_numero ';
                    $q.=' from correlativos cor,tipo_comprobante_empresa tce';
                    $q.=' where cor.tipo_comprobante_empresa_ID=tce.ID and tce.del=0 and cor.del=0 and tce.tabla="'.$tabla.'" and tce.empresa_ID='.$_SESSION['empresa_ID'];

                   //echo $q;
                    $dt=$cn->getGrid($q);									
                    return $dt;												
            }catch(Exception $ex)
            {
                    throw new Exception('Ocurrio un error en la consulta');
            }
    }
}
