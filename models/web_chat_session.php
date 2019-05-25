<?php
class web_chat_session {
  private $ID;
  private $empresa_ID;
  private $nombre_visitante;
  private $email_visitante;
  private $usuario_remitente_ID;
  private $usuario_receptor_ID;
  private $fecha;
  private $session;
  private $estado_ID;
  private $usuario_id;
  private $usuario_mod_id;
  private $descripcion;
  private $getMessage;
  public function __set($var, $valor)
    {
      $temporal = $var;
      if (property_exists("web_chat_session",$temporal))
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
    if (property_exists("web_chat_session", $temporal))
    {
      return $this->$temporal;
    }
    return null;
  }
  function __construct()
  {
        $this->nombre_visitante="";
    $this->email_visitante="";
    $this->usuario_remitente_ID=0;
    $this->usuario_receptor_ID=0;
    $this->fecha="";
    $this->session="";
    $this->usuario_id=$_SESSION["usuario_ID"];
    $this->usuario_mod_id=$_SESSION["usuario_ID"];
    $this->descripcion="";

  }
  function __destruct()
  {
        $this->nombre_visitante;
    $this->email_visitante;
    $this->usuario_remitente_ID;
    $this->usuario_receptor_ID;
    $this->fecha;
    $this->session;
    $this->usuario_id;
    $this->usuario_mod_id;
    $this->descripcion;

  }
  static function getByID($ID)
    {
    $cn =new connect_new();
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_web_chat_session_getByID",
          array("iID"=>$ID));
      $oweb_chat_session=null;
      foreach($dt as $item)
      {
        $oweb_chat_session= new web_chat_session();
      $oweb_chat_session->ID=$item["ID"];
      $oweb_chat_session->empresa_ID=$item["empresa_ID"];
      $oweb_chat_session->nombre_visitante=$item["nombre_visitante"];
      $oweb_chat_session->email_visitante=$item["email_visitante"];
      $oweb_chat_session->usuario_remitente_ID=$item["usuario_remitente_ID"];
      $oweb_chat_session->usuario_receptor_ID=$item["usuario_receptor_ID"];
      $oweb_chat_session->fecha=$item["fecha"];
      $oweb_chat_session->session=$item["session"];
      $oweb_chat_session->estado_ID=$item["estado_ID"];
      $oweb_chat_session->usuario_id=$item["usuario_id"];
      $oweb_chat_session->usuario_mod_id=$item["usuario_mod_id"];
      $oweb_chat_session->descripcion=$item["descripcion"];

      }
      return $oweb_chat_session;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "web_chat_session.getByID", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  function insertar()
    {
    $cn =new connect_new();
    try
    {
      $ID=$cn->store_procedure_transa(
          "sp_web_chat_session_Insert",
            array(
    "iID"=>0,
    "iempresa_ID"=>$this->empresa_ID,
    "inombre_visitante"=>$this->nombre_visitante,
    "iemail_visitante"=>$this->email_visitante,
    "iusuario_remitente_ID"=>$this->usuario_remitente_ID,
    "iusuario_receptor_ID"=>$this->usuario_receptor_ID,
    "ifecha"=>$this->fecha,
    "isession"=>$this->session,
    "iestado_ID"=>$this->estado_ID,
    "iusuario_id"=>$this->usuario_id,
    "idescripcion"=>$this->descripcion
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
      log_error(__FILE__, "web_chat_session.insertar", $ex->getMessage());
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
          "sp_web_chat_session_Update",
            array(
              "retornar"=>$retornar,
    "iID"=>$this->ID,
    "iempresa_ID"=>$this->empresa_ID,
    "inombre_visitante"=>$this->nombre_visitante,
    "iemail_visitante"=>$this->email_visitante,
    "iusuario_remitente_ID"=>$this->usuario_remitente_ID,
    "iusuario_receptor_ID"=>$this->usuario_receptor_ID,
    "ifecha"=>$this->fecha,
    "isession"=>$this->session,
    "iestado_ID"=>$this->estado_ID,
    "iusuario_mod_id"=>$this->usuario_mod_id,
    "idescripcion"=>$this->descripcion
),0);
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "web_chat_session.actualizar", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  function eliminar()
    {
    $cn =new connect_new();
    $retornar =0;
    try
    {
      $retornar=$cn->store_procedure_transa(
          "sp_web_chat_session_Delete",
            array(
              "retornar"=>$retornar,
              "iID"=>$this->ID,
              "iusuario_mod_id"=>$this->usuario_mod_id ),0
            );
      if($retornar>0)$this->getMessage = "Se elimin? correctamente";
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "web_chat_session.eliminar", $ex->getMessage());
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
          "sp_web_chat_session_getCount",
            array(
              "filtro"=>$filtro));
      return $resultado;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "web_chat_session.getCount", $ex->getMessage());
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
          "sp_web_chat_session_getGrid",
            array(
              "filtro"=>$filtro,
              "inicio"=>$inicio,
              "fin"=>$fin,
              "orden"=>$orden));
      return $dt;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "web_chat_session.getGrid", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  static function getTabla()
    {
    $cn =new connect_new();
    $retornar =0;
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_web_chat_session_getTabla",
            array(
              "iempresa_ID"=>$_SESSION['empresa_ID']));
      return $dt;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "web_chat_session.getTabla", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
}  


?>