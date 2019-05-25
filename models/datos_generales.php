<?php
class datos_generales {
  private $ID;
  private $empresa_ID;
  private $ruc;
  private $razon_social;
  private $alias;
  private $direccion;
  private $direccion_fiscal;
  private $distrito_ID;
  private $favicon;
  private $logo_extension;
  private $imagen;
  private $correo;
  private $pagina_web;
  private $telefono;
  private $celular;
  private $tipo_cambio;
  private $vigv;
  private $observacion;
  private $quienes_somos;
  private $mision;
  private $vision;
  private $skype;
  private $persona_contacto;
  private $cargo_contacto;
  private $mail_webmaster;
  private $password_webmaster;
  private $servidorSMTP;
  private $puertoSMTP;
  private $sitio_web;
  private $usuario_id;
  private $usuario_mod_id;
  private $urbanizacion;
  private $usuariosol;
  private $clavesol;
  private $certificado;
  private $passwordcertificado;
  private $visc;
  private $tasadetraccion;
  private $getMessage;
  private $nombre;
  private $ruta;
private $provincia_ID;
private $departamento_ID;

private $etiquetas_correo;
private $etiquetas_celulares;
private $beta_ws_guia;
private $beta_ws_factura;
private $prod_ws_guia;
private $prod_ws_factura;
private $periodo_defecto;
  private $stilo_fondo_tabs;
        private $stilo_fondo_boton;
        private $stilo_fondo_cabecera;
  public function __set($var, $valor)
    {
      $temporal = $var;
      if (property_exists("datos_generales",$temporal))
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
    if (property_exists("datos_generales", $temporal))
    {
      return $this->$temporal;
    }
    return null;
  }
  function __construct()
  {
        $this->ruc="";
    $this->razon_social="";
    $this->alias="";
    $this->direccion="";
    $this->direccion_fiscal="";
    $this->favicon="";
    $this->logo_extension="";
    $this->imagen="";
    $this->correo="";
    $this->pagina_web="";
    $this->telefono="";
    $this->celular="";
    $this->tipo_cambio=0;
    $this->vigv=0;
    $this->observacion="";
    $this->quienes_somos="";
    $this->mision="";
    $this->vision="";
    $this->skype="";
    $this->persona_contacto="";
    $this->cargo_contacto="";
    $this->mail_webmaster="";
    $this->password_webmaster="";
    $this->servidorSMTP="";
    $this->puertoSMTP="";
    $this->sitio_web="";
    $this->usuario_id=isset($_SESSION["usuario_ID"])?$_SESSION["usuario_ID"]:-1;
    $this->usuario_mod_id=isset($_SESSION["usuario_ID"])?$_SESSION["usuario_ID"]:-1;
    $this->urbanizacion="";
    $this->usuariosol="";
    $this->clavesol="";
    $this->certificado="";
    $this->passwordcertificado="";
    $this->visc=0;
    $this->tasadetraccion=0;

  }
  function __destruct()
  {
        $this->ruc;
    $this->razon_social;
    $this->alias;
    $this->direccion;
    $this->direccion_fiscal;
    $this->favicon;
    $this->logo_extension;
    $this->imagen;
    $this->correo;
    $this->pagina_web;
    $this->telefono;
    $this->celular;
    $this->tipo_cambio;
    $this->vigv;
    $this->observacion;
    $this->quienes_somos;
    $this->mision;
    $this->vision;
    $this->skype;
    $this->persona_contacto;
    $this->cargo_contacto;
    $this->mail_webmaster;
    $this->password_webmaster;
    $this->servidorSMTP;
    $this->puertoSMTP;
    $this->sitio_web;
    $this->usuario_id;
    $this->usuario_mod_id;
    $this->urbanizacion;
    $this->usuariosol;
    $this->clavesol;
    $this->certificado;
    $this->passwordcertificado;
    $this->visc;
    $this->tasadetraccion;

  }
  static function getByID($ID)
    {
    $cn =new connect_new();
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_datos_generales_getByID",
          array("iID"=>$ID));
      $odatos_generales=null;
      foreach($dt as $item)
      {
        $odatos_generales= new datos_generales();
      $odatos_generales->ID=$item["ID"];
      $odatos_generales->empresa_ID=$item["empresa_ID"];
      $odatos_generales->ruc=$item["ruc"];
      $odatos_generales->razon_social=$item["razon_social"];
      $odatos_generales->alias=$item["alias"];
      $odatos_generales->direccion=$item["direccion"];
      $odatos_generales->direccion_fiscal=$item["direccion_fiscal"];
      $odatos_generales->distrito_ID=$item["distrito_ID"];
      $odatos_generales->favicon=$item["favicon"];
      $odatos_generales->logo_extension=$item["logo_extension"];
      $odatos_generales->imagen=$item["imagen"];
      $odatos_generales->correo=$item["correo"];
      $odatos_generales->pagina_web=$item["pagina_web"];
      $odatos_generales->telefono=$item["telefono"];
      $odatos_generales->celular=$item["celular"];
      $odatos_generales->tipo_cambio=$item["tipo_cambio"];
      $odatos_generales->vigv=$item["vigv"];
      $odatos_generales->observacion=$item["observacion"];
      $odatos_generales->quienes_somos=$item["quienes_somos"];
      $odatos_generales->mision=$item["mision"];
      $odatos_generales->vision=$item["vision"];
      $odatos_generales->skype=$item["skype"];
      $odatos_generales->persona_contacto=$item["persona_contacto"];
      $odatos_generales->cargo_contacto=$item["cargo_contacto"];
      $odatos_generales->mail_webmaster=$item["mail_webmaster"];
      $odatos_generales->password_webmaster=$item["password_webmaster"];
      $odatos_generales->servidorSMTP=$item["servidorSMTP"];
      $odatos_generales->puertoSMTP=$item["puertoSMTP"];
      $odatos_generales->sitio_web=$item["sitio_web"];
      $odatos_generales->usuario_id=$item["usuario_id"];
      $odatos_generales->usuario_mod_id=$item["usuario_mod_id"];
      $odatos_generales->urbanizacion=$item["urbanizacion"];
      $odatos_generales->usuariosol=$item["usuariosol"];
      $odatos_generales->clavesol=$item["clavesol"];
      $odatos_generales->certificado=$item["certificado"];
      $odatos_generales->passwordcertificado=$item["passwordcertificado"];
      $odatos_generales->visc=$item["visc"];
      $odatos_generales->tasadetraccion=$item["tasadetraccion"];

      }
      return $odatos_generales;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "datos_generales.getByID", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  static function getByID1($empresa_ID)
    {
    $cn =new connect_new();
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_datos_generales_getByID1",
          array("iepresa_ID"=>$empresa_ID));
      $odatos_generales=null;
      foreach($dt as $item)
      {
        $odatos_generales= new datos_generales();
      $odatos_generales->ID=$item["ID"];
      $odatos_generales->empresa_ID=$item["empresa_ID"];
      $odatos_generales->ruc=$item["ruc"];
      $odatos_generales->razon_social=$item["razon_social"];
      $odatos_generales->alias=$item["alias"];
      $odatos_generales->direccion=$item["direccion"];
      $odatos_generales->direccion_fiscal=$item["direccion_fiscal"];
      $odatos_generales->distrito_ID=$item["distrito_ID"];
      $odatos_generales->favicon=$item["favicon"];
      $odatos_generales->logo_extension=$item["logo_extension"];
      $odatos_generales->imagen=$item["imagen"];
      $odatos_generales->correo=$item["correo"];
      $odatos_generales->pagina_web=$item["pagina_web"];
      $odatos_generales->telefono=$item["telefono"];
      $odatos_generales->celular=$item["celular"];
      $odatos_generales->tipo_cambio=$item["tipo_cambio"];
      $odatos_generales->vigv=$item["vigv"];
      $odatos_generales->observacion=$item["observacion"];
      $odatos_generales->quienes_somos=$item["quienes_somos"];
      $odatos_generales->mision=$item["mision"];
      $odatos_generales->vision=$item["vision"];
      $odatos_generales->skype=$item["skype"];
      $odatos_generales->persona_contacto=$item["persona_contacto"];
      $odatos_generales->cargo_contacto=$item["cargo_contacto"];
      $odatos_generales->mail_webmaster=$item["mail_webmaster"];
      $odatos_generales->password_webmaster=$item["password_webmaster"];
      $odatos_generales->servidorSMTP=$item["servidorSMTP"];
      $odatos_generales->puertoSMTP=$item["puertoSMTP"];
      $odatos_generales->sitio_web=$item["sitio_web"];
      $odatos_generales->usuario_id=$item["usuario_id"];
      $odatos_generales->usuario_mod_id=$item["usuario_mod_id"];
      $odatos_generales->urbanizacion=$item["urbanizacion"];
      $odatos_generales->usuariosol=$item["usuariosol"];
      $odatos_generales->clavesol=$item["clavesol"];
      $odatos_generales->certificado=$item["certificado"];
      $odatos_generales->passwordcertificado=$item["passwordcertificado"];
      $odatos_generales->visc=$item["visc"];
      $odatos_generales->tasadetraccion=$item["tasadetraccion"];
      
      }
      return $odatos_generales;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "datos_generales.getByID", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  static function getByEmpresa()
    {
    $cn =new connect_new();
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_datos_generales_getByEmpresa",
          array("iepresa_ID"=>$_SESSION['empresa_ID']));
      $oDatos_generales=null;
      foreach($dt as $item)
      {
        $oDatos_generales=new datos_generales();

                $oDatos_generales->ID=$item['ID'];
                $oDatos_generales->empresa_ID=$item['empresa_ID'];
                $oDatos_generales->ruc=$item['ruc'];
                $oDatos_generales->razon_social=$item['razon_social'];
                $oDatos_generales->alias=$item['alias'];
                $oDatos_generales->direccion=$item['direccion'];
                $oDatos_generales->direccion_fiscal=$item['direccion_fiscal'];
                $oDatos_generales->distrito_ID=$item['distrito_ID'];
                $oDatos_generales->favicon=$item['favicon'];
                $oDatos_generales->logo_extension=$item['logo_extension'];
                $oDatos_generales->imagen=$item['imagen'];
                $oDatos_generales->correo=$item['correo'];
                $oDatos_generales->pagina_web=$item['pagina_web'];
                $oDatos_generales->telefono=$item['telefono'];
                $oDatos_generales->celular=$item['celular'];
                $oDatos_generales->tipo_cambio=$item['tipo_cambio'];
                $oDatos_generales->vigv=$item['vigv'];
                $oDatos_generales->observacion=$item['observacion'];
                $oDatos_generales->quienes_somos=$item['quienes_somos'];
                $oDatos_generales->mision=$item['mision'];
                $oDatos_generales->vision=$item['vision'];
                $oDatos_generales->skype=$item['skype'];
                $oDatos_generales->persona_contacto=$item['persona_contacto'];
                $oDatos_generales->cargo_contacto=$item['cargo_contacto'];
                $oDatos_generales->mail_webmaster=$item['mail_webmaster'];
                $oDatos_generales->password_webmaster=$item['password_webmaster'];
                $oDatos_generales->servidorSMTP=$item['servidorSMTP'];
                $oDatos_generales->puertoSMTP=$item['puertoSMTP'];
                $oDatos_generales->sitio_web=$item['sitio_web'];
                $oDatos_generales->nombre=$item['nombre'];
                $oDatos_generales->ruta=$item['ruta'];
                $oDatos_generales->stilo_fondo_tabs=$item['stilo_fondo_tabs'];
                $oDatos_generales->stilo_fondo_boton=$item['stilo_fondo_boton'];
                $oDatos_generales->stilo_fondo_cabecera=$item['stilo_fondo_cabecera'];
      }
      return $oDatos_generales;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "datos_generales.getByID", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  function insertar()
    {
    $cn =new connect_new();
    try
    {
      $ID=$cn->store_procedure_transa(
          "sp_datos_generales_Insert",
            array(
    "iID"=>0,
    "iempresa_ID"=>$this->empresa_ID,
    "iruc"=>$this->ruc,
    "irazon_social"=>$this->razon_social,
    "ialias"=>$this->alias,
    "idireccion"=>$this->direccion,
    "idireccion_fiscal"=>$this->direccion_fiscal,
    "idistrito_ID"=>$this->distrito_ID,
    "ifavicon"=>$this->favicon,
    "ilogo_extension"=>$this->logo_extension,
    "iimagen"=>$this->imagen,
    "icorreo"=>$this->correo,
    "ipagina_web"=>$this->pagina_web,
    "itelefono"=>$this->telefono,
    "icelular"=>$this->celular,
    "itipo_cambio"=>$this->tipo_cambio,
    "ivigv"=>$this->vigv,
    "iobservacion"=>$this->observacion,
    "iquienes_somos"=>$this->quienes_somos,
    "imision"=>$this->mision,
    "ivision"=>$this->vision,
    "iskype"=>$this->skype,
    "ipersona_contacto"=>$this->persona_contacto,
    "icargo_contacto"=>$this->cargo_contacto,
    "imail_webmaster"=>$this->mail_webmaster,
    "ipassword_webmaster"=>$this->password_webmaster,
    "iservidorSMTP"=>$this->servidorSMTP,
    "ipuertoSMTP"=>$this->puertoSMTP,
    "isitio_web"=>$this->sitio_web,
    "iusuario_id"=>$this->usuario_id,
    "iurbanizacion"=>$this->urbanizacion,
    "iusuariosol"=>$this->usuariosol,
    "iclavesol"=>$this->clavesol,
    "icertificado"=>$this->certificado,
    "ipasswordcertificado"=>$this->passwordcertificado,
    "ivisc"=>$this->visc,
    "itasadetraccion"=>$this->tasadetraccion
),0);
      if($ID>0){
        $this->getMessage="El registro se guardó correctamente.";
        $this->ID=$ID;
        return $ID;
      } else {
          throw new Exception("No se registr?");
      }
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "datos_generales.insertar", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
  function actualizar()
    {
    $cn =new connect_new();
    $retornar =0;
    try
    {
      $retornar=$cn->store_procedure_transa(
          "sp_datos_generales_Update",
            array(
                "retornar"=>$retornar,
                "iID"=>$this->ID,
                "iempresa_ID"=>$this->empresa_ID,
                "iruc"=>$this->ruc,
                "irazon_social"=>$this->razon_social,
                "ialias"=>$this->alias,
                "idireccion"=>$this->direccion,
                "idireccion_fiscal"=>$this->direccion_fiscal,
                "idistrito_ID"=>$this->distrito_ID,
                "ifavicon"=>$this->favicon,
                "ilogo_extension"=>$this->logo_extension,
                "iimagen"=>$this->imagen,
                "icorreo"=>$this->correo,
                "ipagina_web"=>$this->pagina_web,
                "itelefono"=>$this->telefono,
                "icelular"=>$this->celular,
                "itipo_cambio"=>$this->tipo_cambio,
                "ivigv"=>$this->vigv,
                "iobservacion"=>$this->observacion,
                "iquienes_somos"=>$this->quienes_somos,
                "imision"=>$this->mision,
                "ivision"=>$this->vision,
                "iskype"=>$this->skype,
                "ipersona_contacto"=>$this->persona_contacto,
                "icargo_contacto"=>$this->cargo_contacto,
                "imail_webmaster"=>$this->mail_webmaster,
                "ipassword_webmaster"=>$this->password_webmaster,
                "iservidorSMTP"=>$this->servidorSMTP,
                "ipuertoSMTP"=>$this->puertoSMTP,
                "isitio_web"=>$this->sitio_web,
                "iurbanizacion"=>$this->urbanizacion,
                "iusuariosol"=>$this->usuariosol,
                "iclavesol"=>$this->clavesol,
                "icertificado"=>$this->certificado,
                "ipasswordcertificado"=>$this->passwordcertificado,
                "ivisc"=>$this->visc,
                "itasadetraccion"=>$this->tasadetraccion,
                "iusuario_mod_id"=>$this->usuario_mod_id
            ),0);
      if($retornar>0){
          $this->getMessage="Se actualizó correctamente.";
      }else{
          $this->getMessage="no se actualizó correctamente.";
      }
       
      return $retornar;
     
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "datos_generales.actualizar", $ex->getMessage());
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
          "sp_datos_generales_Delete",
            array(
              "retornar"=>$retornar,
              "iID"=>$this->ID,
              "iusuario_mod_id"=>$this->usuario_mod_id ),0
            );
      if($retornar>0)$this->getMessage = "Se elimin? correctamente";
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "datos_generales.eliminar", $ex->getMessage());
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
          "sp_datos_generales_getCount",
            array(
              "filtro"=>$filtro));
      return $resultado;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "datos_generales.getCount", $ex->getMessage());
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
          "sp_datos_generales_getGrid",
            array(
              "filtro"=>$filtro,
              "inicio"=>$inicio,
              "fin"=>$fin,
              "orden"=>$orden));
      return $dt;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "datos_generales.getGrid", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
}  


?>
