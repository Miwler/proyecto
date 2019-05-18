<?php
class datos_generales
{
	private $ID;
  private $empresa_ID;
	private $ruc;
	private $razon_social;
	private $alias;
	private $direccion;
	private $direccion_fiscal;
        private $urbanizacion;
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
	private $getMessage;
	private $provincia_ID;
        private $departamento_ID;
        private $nombre;
        private $ruta;
        private $usuariosol;
        private $clavesol;
        private $certificado;
        private $passwordcertificado;
        private $visc;
        private $tasadetraccion;
        private $stilo_fondo_tabs;
        private $stilo_fondo_boton;
        private $stilo_fondo_cabecera;
	public function __set($var, $valor)
	{
		// convierte a minúsculas toda una cadena la función strtolower
		$temporal = $var;

		// Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"
		if (property_exists('datos_generales',$temporal))
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
		if (property_exists('datos_generales', $temporal))
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

        $q = 'select ifnull(max(ID),0)+1 from datos_generales;';
        $ID=$cn->getData($q);
        $q = 'insert into datos_generales(ID,empresa_ID,ruc,razon_social,alias,direccion,direccion_fiscal,distrito_ID,';
        $q.='favicon,logo_extension,imagen,correo,pagina_web,telefono,celular,tipo_cambio,vigv,observacion,quienes_somos,';
        $q.='mision,vision,skype,persona_contacto,cargo_contacto,mail_webmaster,password_webmaster,servidorSMTP,puertoSMTP,';
        $q.='sitio_web,usuario_id) values (';
        $q.=$ID.','.$this->empresa_ID.',"'.$this->ruc.'","'.$this->razon_social.'","'.$this->alias.'","'.$this->direccion.'",';
        $q.='"'.$this->direccion_fiscal.'",'.$this->distrito_ID.',"'.$this->favicon.'","'.$this->logo_extension.'","'.$this->imagen.'",';
        $q.='"'.$this->correo.'","'.$this->pagina_web.'","'.$this->telefono.'","'.$this->celular.'",'.$this->tipo_cambio.','.$this->vigv.',"';
        $q.=$this->observacion.'","'.$this->quienes_somos.'","'.$this->mision.'","'.$this->vision.'","'.$this->skype.'","';
        $q.=$this->persona_contacto.'","'.$this->cargo_contacto.'","'.$this->mail_webmmaster.'","'.$this->password_webmaster.'","'.$this->servidorSMTP.'","';
        $q.=$this->puertoSMTP.'","'.$this->sitio_web.'",'.$this->usuario_id.')';
        $retornar = $cn->transa($q);


        $this->ID = $ID;
        $this->getMessage = 'Se guardó correctamente';
        return $retornar;
    } catch (Exception $ex) {

        throw new Exception($q);
    }
}


function actualizar() {
    $cn = new connect();
    $retornar = -1;
    try {
        $q = 'update datos_generales set';
        $q.=' empresa_ID='.$this->empresa_ID.',';
        $q.='ruc="'.$this->ruc.'",';
        $q.='razon_social="'.$this->razon_social.'",';
        $q.='alias="'.$this->alias.'",';
        $q.='direccion="'.$this->direccion.'",';
        $q.='direccion_fiscal="'.$this->direccion_fiscal.'",';
        $q.='distrito_ID='.$this->distrito_ID.',';
        $q.='favicon="'.$this->favicon.'",';
        $q.='logo_extension="'.$this->logo_extension.'",';
        $q.='imagen="'.$this->imagen.'",';
        $q.='correo="'.$this->correo.'",';
        $q.='pagina_web="'.$this->pagina_web.'",';
        $q.='telefono="'.$this->telefono.'",';
        $q.='celular="'.$this->celular.'",';
        $q.='tipo_cambio='.$this->tipo_cambio.',';
        $q.='vigv='.$this->vigv.',';
        $q.='observacion="'.$this->observacion.'",';
        $q.='quienes_somos="'.$this->quienes_somos.'",';
        $q.='mision="'.$this->mision.'",';
        $q.='vision="'.$this->vision.'",';
        $q.='skype="'.$this->skype.'",';
        $q.='persona_contacto="'.$this->persona_contacto.'",';
        $q.='cargo_contacto="'.$this->cargo_contacto.'",';
        $q.='mail_webmaster="'.$this->mail_webmaster.'",';
        $q.='password_webmaster="'.$this->password_webmaster.'",';
        $q.='servidorSMTP="'.$this->servidorSMTP.'",';
        $q.='puertoSMTP="'.$this->puertoSMTP.'",';
        $q.='sitio_web="'.$this->sitio_web.'",';
        $q.= 'usuario_mod_id=' . $this->usuario_mod_id.',';
        $q.='fdm=now() where del=0 and ID=' . $this->ID;
        //echo $q;
        $retornar = $cn->transa($q);
        $this->getMessage = 'Se guardó correctamente';
        return $retornar;
    } catch (Exception $ex) {
        throw new Exception($q);
    }
}
function actualizar_datos_empresa() {
    $cn = new connect();
    $retornar = -1;
    try {
        $q = 'update datos_generales set quienes_somos="'.$this->quienes_somos.'",mision="'.$this->mision.'",';
        $q.='vision="'.$this->vision.'", persona_contacto="'.$this->persona_contacto.'",';
        $q.='cargo_contacto="'.$this->cargo_contacto.'", telefono2="'.$this->telefono2.'",';
        $q.='telefono3="'.$this->telefono3.'", telefono4="'.$this->telefono4.'",';
        $q.='skype="'.$this->skype.'" where ID='.$this->ID;
        //echo $q;
        $retornar = $cn->transa($q);
        $this->getMessage = 'Se guardó correctamente';
        return $retornar;
    } catch (Exception $ex) {
        throw new Exception("Ocurrio un error en la consulta");
    }
}

function actualizar_correoSMTP() {
    $cn = new connect();
    $retornar = -1;
    try {
        $q = 'update datos_generales set mail_webmaster="'.$this->mail_webmaster.'",password_webmaster="'.$this->password_webmaster.'",';
        $q.='servidorSMTP="'.$this->servidorSMTP.'", puertoSMTP="'.$this->puertoSMTP.'"';
        $q.=' where ID='.$this->ID;
        //echo $q;
        $retornar = $cn->transa($q);
        $this->message = 'Se guardó correctamente';
        return $retornar;
    } catch (Exception $ex) {
        throw new Exception("Ocurrio un error en la consulta");
    }
}

function eliminar() {
    $cn = new connect();
    $retornar = -1;
    try {

        $q = 'UPDATE datos_generales SET del=1,usuario_mod_id=' . $this->usuario_mod_id . ', fdm=Now()';
        $q.=' WHERE del=0 and ID=' . $this->ID;

        $retornar = $cn->transa($q);

        $this->getMessage = 'Se eliminó correctamente';
        return $retornar;
    } catch (Exception $ex) {
        throw new Exception("Ocurrio un error en la consulta");
    }
}




static function getCount($filtro = '') {
$cn = new connect();
try {
 $q = 'select count(pr.ID) ';
 $q.=' FROM datos_generales as pr ';
 $q.=' where pr.del=0 ';

 if ($filtro != '') {
     $q.=' and ' . $filtro;
 }
 //echo $q;
 $resultado = $cn->getData($q);

 return $resultado;
} catch (Exception $ex) {
 throw new Exception("Ocurrio un error en la consulta");
}
}
static function getByID($ID)
{
        $cn =new connect();
        try
        {
            $q='select ID,empresa_ID,ruc,razon_social,alias,direccion,direccion_fiscal,urbanizacion,distrito_ID,favicon,logo_extension,imagen,';
            $q.='correo,pagina_web,telefono,celular,tipo_cambio,vigv,observacion,quienes_somos,mision,vision,skype,persona_contacto';
            $q.=',cargo_contacto,mail_webmaster,password_webmaster,servidorSMTP,puertoSMTP,sitio_web,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
            $q.=' from datos_generales ';
            $q.=' where ID='.$ID;

            $dt=$cn->getGrid($q);
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
                $oDatos_generales->urbanizacion=$item['urbanizacion'];
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
                $oDatos_generales->usuario_id=$item['usuario_id'];
                $oDatos_generales->usuario_mod_id=$item['usuario_mod_id'];
            }
            return $oDatos_generales;

        }catch(Exeption $ex)
        {
                throw new Exception("Ocurrio un error en la consulta.");
        }
}

static function getGrid($filtro = '', $desde = -1, $hasta = -1, $order = 'dg.ID asc') {
    $cn = new connect();
    try {
        $q='select dg.ID,dg.empresa_ID,dg.ruc,dg.razon_social,dg.alias,dg.direccion,dg.direccion_fiscal,dg.distrito_ID,';
        $q.='dg.favicon,dg.logo_extension,dg.imagen,dg.correo,dg.pagina_web,dg.telefono,dg.celular,dg.tipo_cambio,dg.vigv';
        $q.=',dg.observacion,dg.quienes_somos,dg.mision,dg.vision,dg.skype,dg.persona_contacto,dg.cargo_contacto,';
        $q.='dg.mail_webmaster,dg.password_webmaster,dg.servidorSMTP,dg.puertoSMTP,dg.sitio_web,dg.usuario_id,ifnull(dg.usuario_mod_id,-1) as usuario_mod_id';
        $q.=',em.nombre as empresa,em.ruta,em.stilo_fondo_tabs,em.stilo_fondo_boton,em.stilo_fondo_cabecera';
        $q.=' from datos_generales dg, empresa em ';
        $q.=' where dg.empresa_ID=em.ID and dg.del=0 and em.del=0';


        if ($filtro != '') {
            $q.=' and ' . $filtro;
        }

        $q.=' Order By ' . $order;

        if ($desde != -1 && $hasta != -1) {
            $q.=' Limit ' . $desde . ',' . $hasta;
        }
        $dt = $cn->getGrid($q);
        return $dt;
    } catch (Exception $ex) {
        throw new Exception($q);
    }
}

static function getByID1($empresa_ID)
{
    $cn =new connect();
    try
    {
        $q='select ID,empresa_ID,ruc,razon_social,alias,direccion,direccion_fiscal,distrito_ID,favicon,ifnull(logo_extension,"") as logo_extension,imagen,ifnull(imagen,"default.jpg") as imagen';
        $q.='correo,pagina_web,telefono,celular,tipo_cambio,vigv,ifnull(visc,0) as visc,ifnull(tasadetraccion,0) as tasadetraccion,observacion,quienes_somos,mision,vision,skype,persona_contacto';
        $q.=',cargo_contacto,mail_webmaster,password_webmaster,servidorSMTP,puertoSMTP,sitio_web,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
        $q.=',usuariosol,clavesol,certificado,passwordcertificado';
        $q.=' from datos_generales ';
        $q.=' where del=0 and empresa_ID='.$empresa_ID;
        //echo $q;
        $dt=$cn->getGrid($q);
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
            $oDatos_generales->visc=$item['visc'];
            $oDatos_generales->tasadetraccion=$item['tasadetraccion'];
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
            $oDatos_generales->usuariosol=$item['usuariosol'];
            $oDatos_generales->clavesol=$item['clavesol'];
            $oDatos_generales->certificado=$item['certificado'];
            $oDatos_generales->passwordcertificado=$item['passwordcertificado'];
            $oDatos_generales->usuario_id=$item['usuario_id'];
            $oDatos_generales->usuario_mod_id=$item['usuario_mod_id'];
        }
        return $oDatos_generales;

    }catch(Exeption $ex)
    {
            throw new Exception("Ocurrio un error en la consulta.");
    }
    }
    static function getByEmpresa()
    {
        $cn =new connect();
        try
        {
            $q='select dg.ID,dg.empresa_ID,dg.ruc,dg.razon_social,dg.alias,dg.direccion,dg.direccion_fiscal,dg.distrito_ID,dg.favicon,dg.logo_extension,dg.imagen,';
            $q.='dg.correo,dg.pagina_web,dg.telefono,dg.celular,dg.tipo_cambio,dg.vigv,dg.observacion,dg.quienes_somos,dg.mision,dg.vision,dg.skype,dg.persona_contacto';
            $q.=',dg.cargo_contacto,dg.mail_webmaster,dg.password_webmaster,dg.servidorSMTP,dg.puertoSMTP,dg.sitio_web,';
            $q.='em.ruta,em.nombre,em.stilo_fondo_tabs,em.stilo_fondo_boton,stilo_fondo_cabecera';
            $q.=' from datos_generales dg,empresa em ';
            $q.=' where dg.empresa_ID=em.ID and dg.del=0 and em.del=0 and dg.empresa_ID='.$_SESSION['empresa_ID'];
            //echo $q;
            $dt=$cn->getGrid($q);
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
            throw new Exception("Ocurrio un error en la consulta.");
    }
}

}

?>
