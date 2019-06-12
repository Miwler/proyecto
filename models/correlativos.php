<?php

class correlativos {
  private $ID;
  private $serie;
  private $ultimo_numero;
  private $tipo_comprobante_empresa_ID;
  private $electronico;
  private $empresa_ID;
  private $usuario_id;
  private $usuario_mod_id;
  private $getMessage;
  private $tipo_comprobante_ID;
  private $accion;
  public function __set($var, $valor)
    {
      $temporal = $var;
      if (property_exists("correlativos",$temporal))
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
    if (property_exists("correlativos", $temporal))
    {
      return $this->$temporal;
    }
    return null;
  }
  function __construct()
  {
        $this->serie="";
    $this->ultimo_numero=0;
    $this->electronico=0;
    $this->usuario_id=$_SESSION["usuario_ID"];
    $this->usuario_mod_id=$_SESSION["usuario_ID"];

  }
  function __destruct()
  {
    $this->serie;
    $this->ultimo_numero;
    $this->electronico;
    $this->usuario_id;
    $this->usuario_mod_id;

  }
  static function getByID($ID)
    {
    $cn =new connect_new();
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_correlativos_getByID",
          array("iID"=>$ID));
      $ocorrelativos=null;
      foreach($dt as $item)
        {
            $ocorrelativos= new correlativos();
            $ocorrelativos->ID=$item["ID"];
            $ocorrelativos->serie=$item["serie"];
            $ocorrelativos->ultimo_numero=$item["ultimo_numero"];
            $ocorrelativos->tipo_comprobante_empresa_ID=$item["tipo_comprobante_empresa_ID"];
            $ocorrelativos->electronico=$item["electronico"];
            $ocorrelativos->empresa_ID=$item["empresa_ID"];
            $ocorrelativos->usuario_id=$item["usuario_id"];
            $ocorrelativos->usuario_mod_id=$item["usuario_mod_id"];
            $ocorrelativos->tipo_comprobante_ID=$item["tipo_comprobante_ID"];
            $ocorrelativos->accion=$item["accion"];
        }
      return $ocorrelativos;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "correlativos.getByID", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  function insertar()
    {
    $cn =new connect_new();
    try
    {
      $ID=$cn->store_procedure_transa(
            "sp_correlativos_Insert",
            array(
            "iID"=>0,
            "iserie"=>$this->serie,
            "iultimo_numero"=>$this->ultimo_numero,
            "itipo_comprobante_empresa_ID"=>$this->tipo_comprobante_empresa_ID,
            "ielectronico"=>$this->electronico,
            "iempresa_ID"=>$this->empresa_ID,
            "iusuario_id"=>$this->usuario_id,

        ),0);
      if($ID>0){
        $this->getMessage="El registro se guard? correctamente.";
        $this->ID=$ID;
        return $ID;
      } else {
          throw new Exception("No se registr?");
      }
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "correlativos.insertar", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  function actualizar()
    {
    $cn =new connect_new();
    $retornar =0;
    try
    {
      $ID=$cn->store_procedure_transa(
          "sp_correlativos_Update",
            array(
              "retornar"=>$retornar,
            "iID"=>$this->ID,
            "iserie"=>$this->serie,
            "iultimo_numero"=>$this->ultimo_numero,
            "itipo_comprobante_empresa_ID"=>$this->tipo_comprobante_empresa_ID,
            "ielectronico"=>$this->electronico,
            "iempresa_ID"=>$this->empresa_ID,
            "iusuario_mod_id"=>$this->usuario_mod_id
        ),0);
        return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "correlativos.actualizar", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  static function getCount($filtro="")
    {
    $cn =new connect_new();
    $retornar =0;
    try
    {
      $resultado=$cn->store_procedure_getData(
          "sp_correlativos_getCount",
            array(
              "filtro"=>$filtro));
      return $resultado;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "correlativos.getCount", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  static function getNumero($correlativo_ID)
    {
        $cn =new connect_new();
        try 
        {
            $numero=$cn->store_procedure_getData("sp_correlativos_getNumero",
                    array(
                        "iID"=>$correlativo_ID,
                        "iempresa_ID"=>$_GET['empresa_ID']
                    ));
            		
            		
            return $numero;

        }catch(Exeption $ex)
        {
            log_error(__FILE__, "correlativos.getNumero", $ex->getMessage());
            throw new Exception("Ocurrio un error en la consulta.");
        }
    }
    static function getGridCorrelativos($accion,$electronico)
    {
            $cn =new connect_new();
            try 
            {
                $dt=$cn->store_procedure_getGrid("sp_correlativos_getGridCorrelativos",
                        array(
                           "iaccion"=> $accion,
                            "ielectronico"=>$electronico,
                            "iempresa_ID"=>$_GET['empresa_ID']
                        ));
                    									
                return $dt;												
            }catch(Exception $ex)
            {
                log_error(__FILE__, "correlativos.getGridCorrelativos", $ex->getMessage());
                    throw new Exception('Ocurrio un error en la consulta');
            }
    }
    static function getTabla($filtro='',$inicio=-1,$fin=-1,$orden='co.ID asc')
    {
            $cn =new connect_new();
            try 
            {
                $dt=$cn->store_procedure_getGrid("sp_correlativos_getTabla",
                        array(
                           "filtro"=> $filtro,
                            "inicio"=>$inicio,
                            "fin"=>$fin,
                            "orden"=>$orden
                        ));
                    									
                return $dt;												
            }catch(Exception $ex)
            {
                log_error(__FILE__, "correlativos.getGridCorrelativos", $ex->getMessage());
                    throw new Exception('Ocurrio un error en la consulta');
            }
    }
      static function verificar_electronico($correlativos_ID)
    {
            $cn =new connect_new();
            try 
            {
                    $q='select count(ID) from correlativos where del=0 and electronico=1 and ID='.$correlativos_ID;
                    
                   //echo $q;
                    $retorna=$cn->getData($q);									
                    return $retorna;												
            }catch(Exception $ex)
            {
                    throw new Exception('Ocurrio un error en la consulta');
            }
    }
    function eliminar()
    {
    $cn =new connect_new();
    $retornar =0;
    try
    {
      $retornar=$cn->store_procedure_transa(
          "sp_correlativos_Delete",
            array(
              "retornar"=>$retornar,
              "iID"=>$this->ID,
              "iusuario_mod_id"=>$this->usuario_mod_id ),0
            );
      if($retornar>0)$this->getMessage = "Se eliminó correctamente";
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "correlativos.eliminar", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
    static function Registrar_Correlativos_Defaul($correlativos_ID,$correlativos_ID_fisico,$correlativos_ID_guia_fisico,$correlativos_ID_guia_electronico,$correlativos_ID_nota_credito,$correlativos_ID_nota_debito,$compra_tipo_comprobante_ID){
        
        try{
            $retorna=0;
            $cn=new connect_new();
            $retorna=$cn->store_procedure_transa(
                    "sp_configuracion_empresa_Registrar",
                    array(
                        "iretorna"=>$retorna,
                        "correlativos_ID"=>$correlativos_ID,
                        "correlativos_ID_fisico"=>$correlativos_ID_fisico,
                        "correlativos_ID_guia_fisico"=>$correlativos_ID_guia_fisico,
                        "correlativos_ID_guia_electronico"=>$correlativos_ID_guia_electronico,
                        "correlativos_ID_nota_credito"=>$correlativos_ID_nota_credito,
                        "correlativos_ID_nota_debito"=>$correlativos_ID_nota_debito,
                        "compra_tipo_comprobante_ID"=>$compra_tipo_comprobante_ID,
                        "iusuario_id"=>$_SESSION['usuario_ID'],
                        "iempresa_ID"=>$_GET['empresa_ID']
                    ),0);
            return $retorna;
        }catch(Exception $ex){
            log_error(__FILE__, "correlativos.Registrar_Correlativos_Defaul", $ex->getMessage());
            throw new Exception('Ocurrio un error en la consulta');
        }
    }
    
    static function getValorConfiguracion_Empresa($nombre)
    {
        
        try{
            $retorna='0';
            $cn=new connect_new();
            $dt=$cn->store_procedure_getGrid(
                    "sp_configuracion_empresa_getValor",
                    array(
                        "iempresa_ID"=>$_GET['empresa_ID'],
                        "inombre"=>$nombre
                    ));
            if(count($dt)>0){
                $retorna=$dt[0]['valor'];
            }
            return $retorna;
        }catch(Exception $ex){
            log_error(__FILE__, "correlativos.Registrar_Correlativos_Defaul", $ex->getMessage());
            throw new Exception('Ocurrio un error en la consulta');
        }
    }
}  
