<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of inventario_detalle
 *
 * @author miwler
 */
class inventario_detalle {
    private $ID;
    private $descripcion;
    private $usuario_id;
    private $usuario_mod_id;
    private $serie;
    private $inventario_ID;
    
    private $message;
   public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
        if (property_exists('inventario_detalle', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('inventario_detalle', $temporal)) {
            return $this->$temporal;
        }

        // Retorna nulo si no existe
        return null;
    }

    function insertar() {
        $cn = new connect();
        $retorna = -1;
        try {
            $ID=0;
            $q = 'select ifnull(max(ID),0)+1 as ID from inventario_detalle;';
            $ID=$cn->getData($q);
            
            $q = 'insert into inventario_detalle(ID, descripcion, serie, inventario_ID, usuario_id )';
            $q.='values('.$ID.',"' . FormatTextSave($this->descripcion) . '","' .FormatTextSave($this->serie). '",' . $this->inventario_ID . ',' . $this->usuario_id . ')';
            //echo $q;
            $retorna = $cn->transa($q);
            $this->ID = $ID;
            $this->message = 'Se guardó correctamente';
            return $retorna;
        } catch (Exception $ex) {

            throw new Exception($q);
        }
    }
    function eliminar(){
        $cn =new connect();
        $retornar=-1;
        try{

                $q='UPDATE inventario_detalle SET del=1,usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
                $q.=' WHERE del=0 and ID='.$this->ID;

                $retornar=$cn->transa($q);

                $this->message='Se eliminó correctamente';
                return $retornar;
        }
        catch(Exception $ex){
                throw new Exception("Ocurrio un error en la consulta");
        }
    } 
    function eliminar2(){
        $cn =new connect();
        $retornar=-1;
        try{

            $q='UPDATE inventario_detalle SET del=1,usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
            $q.=' WHERE del=0 and inventario_ID='.$this->inventario_ID;
            $retornar=$cn->transa($q);
            $this->message='Se eliminó correctamente';
            return $retornar;
        }
        catch(Exception $ex){
                throw new Exception("Ocurrio un error en la consulta");
        }
    } 
static function getByID($ID)
    {
            $cn =new connect();
            try 
            {
                    $q='Select ID,descripcion,serie,ifnull(usuario_id,-1) as usuario_id,ifNull(usuario_mod_id,-1)as usuario_mod_id,inventario_ID';
                    $q.=' from inventario_detalle ';
                    $q.=' where del=0 and ID='.$ID;

                    $dt=$cn->getGrid($q);			
                    $oinventario_detalle=null;

                    foreach($dt as $item)
                    {
                            $oinventario_detalle=new inventario_detalle();

                            $oinventario_detalle->ID=$item['ID'];
                            $oinventario_detalle->descripcion=$item['descripcion'];
                            $oinventario_detalle->serie=$item['serie'];
                            $oinventario_detalle->usuario_id=$item['usuario_id'];
                            $oinventario_detalle->usuario_mod_id=$item['usuario_mod_id'];
                            $oinventario_detalle->inventario_ID=$item['inventario_ID'];
                           
                    }			
                    return $oinventario_detalle;
            }catch(Exeption $ex)
            {
                    throw new Exception("Ocurrio un error en la consulta.");
            }
    }

    function verificarDuplicado(){
            $cn =new connect();
            $retornar=-1;
            try{
                    return $retornar;
            }
            catch(Exception $ex){
                    throw new Exception("Ocurrio un error en la consulta");
            }
    }

    static function getCount($filtro='')
    {
            $cn =new connect();
            try 
            {
                    $q='select count(cc.ID) ';
                    $q.=' FROM compra_detalle as ccd';
                    $q.=' where ccd.del=0';

                    if ($filtro!='')
                    {
                            $q.=' and '.$filtro;
                    }

                    $resultado=$cn->getData($q);									

                    return $resultado;					
            }catch(Exception $ex)
            {
                    throw new Exception("Ocurrio un error en la consulta getCount");
            }
    } 

    static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='ID asc')
    {
            $cn =new connect();
            try 
            {
                    $q='select ID,serie,usuario_id,inventario_ID from inventario_detalle ';
                    $q.=' where del=0 ';

                    if($filtro!=''){
                            $q.=' and '.$filtro;
                    }

                    $q.=' Order By '.$order;

                    if($desde!=-1&&$hasta!=-1){
                            $q.=' Limit '.$desde.','.$hasta;
                    }			

                    $dt=$cn->getGrid($q);	
                    //echo $q;
                    return $dt;												
            }catch(Exception $ex)
            {
                    throw new Exception($q);
            }
    }
}
