<?php

class persona {
    private $ID;
    public $apellido_paterno;
    public $apellido_materno;
    public $nombres;
    public $direccion;
    public $distrito_ID;
    private $fecha_nacimiento;
    public $telefono;
    public $celular;
    public $correo;
    private $sexo_ID;
    private $usuario_id;
    private $usuario_mod_id;
    
    private $getMessage;
    private $dtTipo_Documento;
    private $tipo_documento_ID;
    private $numero;
    private $dtDepartamento;
    private $dtProvincia;
    private $dtDistrito;
    private $departamento_ID;
    private $provincia_ID;
    private $dtSexo;
    private $dtPersona_Documento;
    
    public function __set($var, $valor)
    {
            // convierte a minúsculas toda una cadena la función strtolower
            $temporal = $var;

            // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
            if (property_exists('persona',$temporal))
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
            if (property_exists('persona', $temporal))
             {
                    return $this->$temporal;
             }

            // Retorna nulo si no existe
            return null;
    }
    function insertar() {
        $cn = new connect_new();
        $retornar = -1;
        try {

            $q = 'select ifnull(max(ID),0)+1 from persona;';
            
            $ID=$cn->getData($q);
            $q = 'insert into persona(ID,apellido_paterno,apellido_materno,nombres,direccion,distrito_ID,fecha_nacimiento,telefono,';
            $q.= 'celular,correo,sexo_ID,usuario_id) values ('.$ID.',"'.$this->apellido_paterno.'","'.$this->apellido_materno.'",';
            $q.='"'.$this->nombres.'","'.$this->direccion.'",'.$this->distrito_ID.',"'.$this->fecha_nacimiento.'","'.$this->telefono.'",';
            $q.='"'.$this->celular.'","'.$this->correo.'",'.$this->sexo_ID.','.$this->usuario_id.');';
<<<<<<< HEAD
=======
            //echo $q;
>>>>>>> 9ca7ce16eaf61c0713a4eebf222fb3b2f271412b
            $cn = new connect_new();
            $retornar = $cn->transa($q);
            $this->ID = $ID;
            $this->getMessage = 'Se guardó correctamente ';
            return $retornar;
        } catch (Exception $ex) {

            throw new Exception($q);
        }
    }
    
    function insertar1()
    {
    $cn =new connect_new();
    try
    {
      $ID=$cn->store_procedure_transa(
          "sp_persona_Insert",
            array(
    "iID"=>0,
    "iapellido_paterno"=>$this->apellido_paterno,
    "iapellido_materno"=>$this->apellido_materno,
    "inombres"=>$this->nombres,
    "idireccion"=>$this->direccion,
    "idistrito_ID"=>$this->distrito_ID,
    "ifecha_nacimiento"=>$this->fecha_nacimiento,
    "itelefono"=>$this->telefono,
    "icelular"=>$this->celular,
    "icorreo"=>$this->correo,
    "isexo_ID"=>$this->sexo_ID,
    "iusuario_id"=>$this->usuario_id,

),0);
      if($ID>0){
        $this->getMessage="El registro se guardó correctamente.";
        $this->ID=$ID;
      } 
      return $ID;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "persona.insertar", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
    
    static function getByID($ID)
    {
        $cn =new connect_new();
        try 
        {
            $q='Select ID,apellido_paterno,apellido_materno,nombres,direccion,ifnull(distrito_ID,0) as distrito_ID';
            $q.=',fecha_nacimiento,telefono,celular,correo,sexo_ID,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
            $q.=' from persona ';
            $q.=' where del=0 and ID='.$ID;

            $dt=$cn->getGrid($q);			
            $oPersona=null;

            foreach($dt as $item)
            {
                $oPersona=new persona();
                $oPersona->ID=$item['ID'];
                $oPersona->apellido_paterno=$item['apellido_paterno'];
                $oPersona->apellido_materno=$item['apellido_materno'];
                $oPersona->nombres=$item['nombres'];
                $oPersona->direccion=$item['direccion'];
                $oPersona->distrito_ID=$item['distrito_ID'];
                $oPersona->fecha_nacimiento=$item['fecha_nacimiento'];
                $oPersona->telefono=$item['telefono'];
                $oPersona->celular=$item['celular'];
                $oPersona->correo=$item['correo'];
                $oPersona->sexo_ID=$item['sexo_ID'];
                $oPersona->usuario_id=$item['usuario_id'];
                $oPersona->usuario_mod_id=$item['usuario_mod_id'];

            }			
            return $oPersona;

        }catch(Exeption $ex)
        {
                throw new Exception($q);
        }
    }
    
    static function getByID1($ID)
    {
    $cn =new connect_new();
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_persona_getByID",
          array("iID"=>$ID));
      //print_r($dt);
      $opersona=null;
      foreach($dt as $item)
        {
          $opersona= new persona();
          $opersona->ID=$item["ID"];
          $opersona->apellido_paterno=test_input($item["apellido_paterno"]);
          $opersona->apellido_materno=$item["apellido_materno"];
          $opersona->nombres=$item["nombres"];
          $opersona->direccion=test_input($item["direccion"]);
          $opersona->distrito_ID=$item["distrito_ID"];
          $opersona->fecha_nacimiento=$item["fecha_nacimiento"];
          $opersona->telefono=$item["telefono"];
          $opersona->celular=$item["celular"];
          $opersona->correo=$item["correo"];
          $opersona->sexo_ID=$item["sexo_ID"];
          $opersona->usuario_id=$item["usuario_id"];
          $opersona->usuario_mod_id=$item["usuario_mod_id"];

        }
      return $opersona;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "persona.getByID", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }

    static function getCount($filtro='')
    {
            $cn =new connect_new();
            try 
            {
                    $q='select count(ID) ';
                    $q.=' FROM persona ';
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
    
    
    
    
        static function getCount_PersonaDocumento($filtro='')
    {
            $cn =new connect_new();
            try 
            {
                    $q='select count(pe.ID) ';
                    $q.=' FROM persona pe, persona_documento pdc';
                    $q.=' where pe.ID=pdc.persona_ID and pe.del=0 ';

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
        $cn =new connect_new();
        try 
        {
            $q='Select ID,apellido_paterno,apellido_materno,nombres,concat(apellido_paterno," ",apellido_materno,", ",nombres) as datos,direccion,ifnull(distrito_ID,0) as distrito_ID';
            $q.=',fecha_nacimiento,telefono,celular,correo,sexo_ID,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
            $q.=' from persona ';
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
    
    
        static function getGrid_PersonaDocumento($filtro='',$desde=-1,$hasta=-1,$order='pe.ID asc')
    {
        $cn =new connect_new();
        try 
        {
            $q='Select pdc.persona_ID,pdc.tipo_documento_ID,pdc.numero as numero,pe.ID,pe.apellido_paterno,pe.apellido_materno,pe.nombres,pe.direccion';
            $q.=', pe.fecha_nacimiento,pe.telefono,pe.celular,pe.correo,pe.sexo_ID';
            $q.=' from persona_documento pdc, persona pe';
            $q.=' where pdc.del=0 and pe.del=0 and pe.ID=pdc.persona_ID';

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
    
    
    
    function verificarDuplicado()
    {
        $cn =new connect_new();
        try 
        {
            $q='select count(ID) from persona_documento ';
            $q.='where tipo_documento_ID='.$this->tipo_documento_ID.' and numero="'.$this->numero.'"';
            //echo $q;
            if ($this->persona_ID != '') {
                $q.=' and persona_ID<>' . $this->persona_ID;
            }
            
            $retornar = $cn->getData($q);

            if ($retornar > 0) {
                $this->getMessage = 'Ya existe una persona con el mismo número de documento ';
               
            }
            return $retornar;

        }catch(Exeption $ex)
        {
                throw new Exception($q);
        }
    }
    static function geListaPersonas($buscar='')
    {
        $cn =new connect_new();
        try 
        {
            $dt=$cn->store_procedure_getGridParse(
                    "getListaPersonas",
                    array("buscar"=>$buscar)
                    );
            
            //echo $q;
            
            
            //$dt=$cn->getGrid($q);									
            return $dt;												
        }catch(Exception $ex)
        {
                throw new Exception($q);
        }
    }
}
