<?php

class comprobante_regula_sunat {

    private $ID;
    private $comprobante_regula_ID;
    private $fecha_generacion;
    private $fecha_respuesta;
    private $nombre_archivo;
    private $xml_firmado;
    private $hash;
    private $representacion_impresa;
    private $estado_envio;
    private $codigo_estado;
    private $descripcion_estado;
    private $cdr_sunat;
    private $usuario_id;

    Private $getMessage;

    public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"
        if (property_exists('comprobante_regula_sunat', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('comprobante_regula_sunat', $temporal)) {
            return $this->$temporal;
        }

        // Retorna nulo si no existe
        return null;
    }
    function __construct()
  {
        $this->comprobante_regula_ID=0;
    $this->fecha_generacion="";
    $this->fecha_respuesta="";
    $this->nombre_archivo="";
    $this->xml_firmado="";
    $this->hash="";
    $this->representacion_impresa="";
    $this->estado_envio="";
    $this->codigo_estado="";
    $this->descripcion_estado="";
    $this->cdr_sunat="";
    $this->usuario_id=$_SESSION["usuario_ID"];

  }
  function __destruct()
  {
        $this->comprobante_regula_ID;
    $this->fecha_generacion;
    $this->fecha_respuesta;
    $this->nombre_archivo;
    $this->xml_firmado;
    $this->hash;
    $this->representacion_impresa;
    $this->estado_envio;
    $this->codigo_estado;
    $this->descripcion_estado;
    $this->cdr_sunat;
    $this->usuario_id;

  }
    /*function insertar() {
        
        $retornar = -1;
        try {

            $q = 'select ifnull(max(ID),0)+1 from comprobante_regula_sunat';
            $cn = new connect_new();
            $ID=$cn->getData($q);
            $q = 'insert into comprobante_regula_sunat(ID,comprobante_regula_ID,fecha_generacion,fecha_respuesta,nombre_archivo,hash,xml_firmado,representacion_impresa,estado_envio,codigo_estado,descripcion_estado,cdr_sunat,usuario_id)';
            $q.='values('.$ID.','.$this->comprobante_regula_ID.',"' . $this->fecha_generacion . '","'.$this->fecha_respuesta.'","'.$this->nombre_archivo.'","'.$this->hash.'","'.$this->xml_firmado.'","'.$this->representacion_impresa.'","'.$this->estado_envio.'","'.$this->codigo_estado.'","'.$this->descripcion_estado.'","'.$this->cdr_sunat.'",'. $this->usuario_id .');';
            //echo $q;
//console_log($q);
            $cn = new connect_new();
            $retornar = $cn->transa($q);
            $this->ID = $ID;
            $this->getMessage = 'Se guardó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception($ex);
            //throw new Exception("Ocurrio un error en la consulta");
        }
    }*/

    /*public function getGrid($comprobante_regula_ID) {
        $cn = new connect_new();
        try {
            $q = 'SELECT * FROM comprobante_regula_sunat WHERE comprobante_regula_ID='.$comprobante_regula_ID.' ORDER BY ID DESC LIMIT 1 ';
            $dt = $cn->getGrid($q);
            return $dt;
        } catch (Exception $ex) {
            throw new Exception('Ocurrio un error en la consulta');
        }
    }*/
    function insertar()
    {
    $cn =new connect_new();
    try
    {
      $ID=$cn->store_procedure_transa(
          "sp_comprobante_regula_sunat_Insert",
            array(
                "iID"=>0,
                "icomprobante_regula_ID"=>$this->comprobante_regula_ID,
                "ifecha_generacion"=>$this->fecha_generacion,
                "ifecha_respuesta"=>$this->fecha_respuesta,
                "inombre_archivo"=>$this->nombre_archivo,
                "ixml_firmado"=>$this->xml_firmado,
                "ihash"=>$this->hash,
                "irepresentacion_impresa"=>$this->representacion_impresa,
                "iestado_envio"=>$this->estado_envio,
                "icodigo_estado"=>$this->codigo_estado,
                "idescripcion_estado"=>$this->descripcion_estado,
                "icdr_sunat"=>$this->cdr_sunat,
                "iusuario_id"=>$this->usuario_id
            ),0);
      if($ID>0){
        $this->getMessage="El registro se guard? correctamente.";
        $this->ID=$ID;
        return $ID;
      } else {
          log_error(__FILE__,"", $error);
          throw new Exception("No se registr?");
      }
    }catch(Exeption $ex)
        {
          log_error(__FILE__, "comprobante_regula_sunat.insertar", $ex->getMessage());
          throw new Exception($ex->getMessage());
        }
    }
    static function getGrid($filtro="",$inicio=-1,$fin=-1,$orden="ID asc")
    {
    $cn =new connect_new();
    $retornar =0;
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_comprobante_regula_sunat_getGrid",
            array(
              "filtro"=>$filtro,
              "inicio"=>$inicio,
              "fin"=>$fin,
              "orden"=>$orden));
      return $dt;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "comprobante_regula_sunat.getGrid", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
}
