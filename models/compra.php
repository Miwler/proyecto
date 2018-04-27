<?php


class compra {
   private $ID;
    private $descripcion;
    private $codigo;
    private $nombre;
    private $usuario_id;
    private $usuario_mod_id;
    private $proveedor_ID;
    private $numero;
    private $numero_guia;
    private $forma_pago_ID;
    private $moneda_ID;
    private $estado_ID;
    private $fecha_emision;
    private $fecha_vencimiento;
    private $con_igv;
    private $tipo_cambio;
    private $comprobante_tipo_ID;
    private $serie;
    private $vigv;
    private $descuento;
    private $recargo;
    private $subtotal;
    private $igv;
    private $total;
    private $periodo;
    private $monto_pendiente;
    private $orden_compra_ID;
    private $message;
    private $estado;
    private $moneda;
    private $dtComprobante_Tipo;
    private $oEstado;
    private $oProveedor;
    private $dtMoneda;
    private $dtOperador;
    private $dtMotivo_Anulacion;
    private $fecha_anulacion;
    private $motivo_anulacion_ID;
    private $operador_ID_anulacion;
    private $dtForma_Pago;
    private $numero_orden_compra;
    private $dtProveedor;
    public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
        if (property_exists('compra', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('compra', $temporal)) {
            return $this->$temporal;
        }

        // Retorna nulo si no existe
        return null;
    }

   function insertar(){
        $cn =new connect();
        $retornar=-1;
        try{
            $ID=0;
            $fecha_emision_save='NULL';
            if($this->fecha_emision!=null){
                    $fecha_emision_save='"'.FormatTextToDate($this->fecha_emision,'Y-m-d').'"';
            }

            $fecha_vencimiento_save='NULL';
            if($this->fecha_vencimiento!=null){
                    $fecha_vencimiento_save='"'.FormatTextToDate($this->fecha_vencimiento,'Y-m-d').'"';
            }
            $orden_compra_ID='NULL';
            if($this->orden_compra_ID!=null){
                $orden_compra_ID=$this->orden_compra_ID;
            }
            $forma_pago=1;
            if($this->forma_pago_ID!=null){
                $forma_pago=$this->forma_pago_ID!=null;
            }
            $q='select ifnull(max(ID),0)+1 as ID from compra;';
            $ID=$cn->getData($q);
            $q='select ifnull(max(codigo),0)+1 as ID from compra where empresa_ID='.$_SESSION['empresa_ID'].';';
            $codigo=$cn->getData($q);
            
            $q='INSERT INTO compra(ID,codigo,empresa_ID,comprobante_tipo_ID,serie,numero,proveedor_ID,fecha_emision,fecha_vencimiento,tipo_cambio,vigv,';
            $q.='con_igv,estado_ID,descuento,recargo,subtotal,igv,total,usuario_id,numero_guia,moneda_ID,orden_compra_ID,descripcion,periodo,monto_pendiente,forma_pago_ID) ';
            $q.='VALUES ('.$ID.','.$codigo.','.$_SESSION['empresa_ID'].','.$this->comprobante_tipo_ID.',"'.$this->serie.'",'.$this->numero.',';
            $q.=$this->proveedor_ID.','.$fecha_emision_save.','.$fecha_vencimiento_save.','.number_format($this->tipo_cambio,2,'.','').',';
            $q.= number_format($this->vigv,2,'.','').','.$this->con_igv.','.$this->estado_ID.','.number_format($this->descuento,2,'.','').','.number_format($this->recargo,2,'.','').',';
            $q.=number_format($this->subtotal,2,'.','').','.number_format($this->igv,2,'.','').','.number_format($this->total,2,'.','').','.$this->usuario_id.',"'.$this->numero_guia.'",';
            $q.=$this->moneda_ID.','.$orden_compra_ID.',"'.$this->descripcion.'",'.$this->periodo.','.number_format($this->monto_pendiente,2,'.','').','.$forma_pago.');';
            //echo $q;
            $retornar=$cn->transa($q);

            $this->ID=$ID;
            //$retornar=$q;
            $this->message='Se guardó correctamente.';
            return $retornar;
        }
        catch(Exception $ex){
                throw new Exception($q);
        }
    }	
		
    function actualizar(){
            $cn =new connect();
            $retornar=-1;
            try{
                    $fecha_emision_save='NULL';
                    if($this->fecha_emision!=null){
                            $fecha_emision_save='"'.FormatTextToDate($this->fecha_emision,'Y-m-d').'"';
                    }

                    $fecha_vencimiento_save='NULL';
                    if($this->fecha_vencimiento!=null){
                            $fecha_vencimiento_save='"'.FormatTextToDate($this->fecha_vencimiento,'Y-m-d').'"';
                    }
                    $orden_compra_ID='NULL';
                    if($this->orden_compra_ID!=null&&$this->orden_compra_ID!=-1){
                        $orden_compra_ID=$this->orden_compra_ID;
                    }
                    $q="UPDATE compra SET orden_compra_ID=".$orden_compra_ID.", comprobante_tipo_ID=".$this->comprobante_tipo_ID.",serie='".$this->serie."',numero='".$this->numero."',";
                    $q.="proveedor_ID=".$this->proveedor_ID.",fecha_emision=".$fecha_emision_save.",fecha_vencimiento=".$fecha_vencimiento_save.",";
                    $q.="tipo_cambio='".number_format($this->tipo_cambio,2,'.','')."',con_igv='".$this->con_igv."',vigv='".number_format($this->vigv,2,'.','')."',estado_ID=".$this->estado_ID;
                    $q.=",descuento='".number_format($this->descuento,2,'.','')."',recargo='".number_format($this->recargo,2,'.','')."',";
                    $q.="subtotal='".number_format($this->subtotal,2,'.','')."',igv='".number_format($this->igv,2,'.','')."',total='".number_format($this->total,2,'.','');
                    $q.="',usuario_mod_id=".$this->usuario_mod_id.",moneda_ID=".$this->moneda_ID.",periodo=".$this->periodo.",monto_pendiente=".number_format($this->monto_pendiente,2,'.','').",descripcion='".$this->descripcion."', fdm=Now()";
                    $q.=" WHERE ID=".$this->ID;

                    $retornar=$cn->transa($q);

                    $this->message='Se guardó correctamente';
                    return $retornar;
            }
            catch(Exception $ex){
                    throw new Exception($q);
            }
    }
     function actualizarMontoPendiente(){
            $cn =new connect();
            $retornar=-1;
            try{
                    
                    $q="UPDATE compra SET monto_pendiente=".number_format($this->monto_pendiente,2,'.','').",usuario_mod_id=".$this->usuario_mod_id.", fdm=Now()";
                    $q.=" WHERE ID=".$this->ID;

                    $retornar=$cn->transa($q);

                    $this->message='Se guardó correctamente';
                    return $retornar;
            }
            catch(Exception $ex){
                    throw new Exception("Ocurrio un error en la consulta actualizar compra");
            }
    }
    function actualizarEstado(){
       $cn =new connect();
       $retornar=-1;
       try{

               $q="UPDATE compra SET estado_ID=".$this->estado_ID.",usuario_mod_id=".$this->usuario_mod_id.", fdm=Now()";
               $q.=" WHERE ID=".$this->ID;

               $retornar=$cn->transa($q);

               $this->message='Se guardó correctamente';
               return $retornar;
       }
       catch(Exception $ex){
               throw new Exception("Ocurrio un error en la consulta actualizar compra");
       }
    }
function actualizar2(){
    $cn =new connect();
    $retornar=-1;
    try{

        $q="UPDATE compra SET subtotal='".number_format($this->subtotal,2,'.','');
        $q.="',igv='".number_format($this->igv,2,'.','')."',total='".number_format($this->total,2,'.','');
        $q.="',monto_pendiente=".number_format($this->monto_pendiente,2,'.','').",usuario_mod_id=".$this->usuario_mod_id.", fdm=Now()";
        $q.=" WHERE ID=".$this->ID;

        $retornar=$cn->transa($q);

        $this->message='Se guardó correctamente';
        return $retornar;
    }
    catch(Exception $ex){
            throw new Exception("Ocurrio un error en la consulta");
    }
}
    function eliminar(){
            $cn =new connect();
            $retornar=-1;
            try{

                    $q='UPDATE compra SET del=1,usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
                    $q.=' WHERE ID='.$this->ID;

                    $retornar=$cn->transa($q);

                    $this->message='Se eliminó correctamente';
                    return $retornar;
            }
            catch(Exception $ex){
                    throw new Exception("Ocurrio un error en la consulta.");
            }
    }

    static function getByID($ID)
    {
            $cn =new connect();
            try 
            {
                    $q='Select ID,codigo,comprobante_tipo_ID,serie,numero,numero_guia,proveedor_ID,DATE_FORMAT(fecha_emision,"%d/%m/%Y") as fecha_emision,';
                    $q.='DATE_FORMAT(fecha_vencimiento,"%d/%m/%Y") as fecha_vencimiento,tipo_cambio,vigv,con_igv,estado_ID,forma_pago_ID,descuento,';
                    $q.='recargo,subtotal,igv,total,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id,moneda_ID,periodo,monto_pendiente,ifnull(orden_compra_ID,-1) as orden_compra_ID,descripcion ';
                    $q.=' from compra ';
                    $q.=' where ID='.$ID;
                    //echo $q;
                    $dt=$cn->getGrid($q);			
                    $ocompra=null;

                    foreach($dt as $item)
                    {
                            $ocompra=new compra();

                            $ocompra->ID=$item['ID'];
                            $ocompra->codigo=$item['codigo'];
                            $ocompra->comprobante_tipo_ID=$item['comprobante_tipo_ID'];
                            $ocompra->serie=$item['serie'];
                            $ocompra->numero=$item['numero'];
                            $ocompra->numero_guia=$item['numero_guia'];
                            $ocompra->proveedor_ID=$item['proveedor_ID'];
                            $ocompra->fecha_emision=$item['fecha_emision'];
                            $ocompra->fecha_vencimiento=$item['fecha_vencimiento'];
                            $ocompra->tipo_cambio=$item['tipo_cambio'];
                            $ocompra->vigv=$item['vigv'];
                            $ocompra->con_igv=$item['con_igv'];
                            $ocompra->estado_ID=$item['estado_ID'];
                            
                            $ocompra->moneda_ID=$item['moneda_ID'];
                           
                            $ocompra->descuento=$item['descuento'];
                            $ocompra->recargo=$item['recargo'];
                            $ocompra->subtotal=$item['subtotal'];
                            $ocompra->igv=$item['igv'];
                            $ocompra->total=$item['total'];
                            $ocompra->usuario_id=$item['usuario_id'];
                            $ocompra->usuario_mod_id=$item['usuario_mod_id'];
                            $ocompra->periodo=$item['periodo'];
                            $ocompra->monto_pendiente=$item['monto_pendiente'];
                            $ocompra->orden_compra_ID=$item['orden_compra_ID'];
                            $ocompra->descripcion=$item['descripcion'];
                    }			
                    return $ocompra;				
            }catch(Exeption $ex)
            {
                    throw new Exception("Ocurrio un error en la consulta.");
            }
    }

    function verificarDuplicado(){
            $cn =new connect();
            $retornar=-1;
            try{
                    //Verifico que no se repita la serie y el número por cada proveedor
                    $q='SELECT count(ID) FROM compra';
                    $q.=' WHERE empresa_ID='.$_SESSION['empresa_ID'].' and del=0 and proveedor_ID="'.$this->proveedor_ID.'" and serie="'.$this->serie.'" and numero="'.$this->numero.'"';		

                    if($this->ID!=0){
                            $q.=' and ID<>'.$this->ID;
                    }

                    $retornar=$cn->getData($q);			

                    if ($retornar>0){
                            $this->message='Ya existe una comprobante de compras con la misma serie y el mismo número para este proveedor.';
                            return $retornar;
                    }
                    //echo $q;
                    return $retornar;
            }
            catch(Exception $ex){
                    throw new Exception("Ocurrio un error en la consulta");
            }
    }

    static function getCount($filtro = '') {
        $cn = new connect();
        try {
            $q = 'select count(co.ID) ';
            $q.=' FROM compra co,proveedor pr,estado est, moneda mo, comprobante_tipo ct';
            $q.=' where co.empresa_ID='.$_SESSION['empresa_ID'].' and co.del=0 and co.proveedor_ID=pr.ID and est.ID=co.estado_ID  and mo.ID=co.moneda_ID and ct.ID=co.comprobante_tipo_ID ';

            if ($filtro != '') {
                $q.=' and ' . $filtro;
            }
            //echo $q;
            $resultado = $cn->getData($q);

            return $resultado;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    
    
        static function getGrid($filtro = '', $desde = -1, $hasta = -1, $order = 'co.ID asc') {
        $cn = new connect();
        try {
            $q = 'select co.ID,co.codigo,pr.razon_social as proveedor,pr.ID as proveedor_ID,co.numero,co.numero_guia, co.moneda_ID, ';
            $q.= 'mo.descripcion as moneda,mo.simbolo,est.nombre as estado,co.fecha_emision,co.fecha_vencimiento,co.serie,';
            $q.= 'ct.nombre as comprobante,co.subtotal,co.vigv,co.subtotal,co.total,co.periodo';
            $q.=',co.monto_pendiente,co.estado_ID,ifNull(orden_compra_ID,-1) as orden_compra_ID';
            $q.=' FROM compra co,proveedor pr,estado est, moneda mo, comprobante_tipo ct ';
            $q.=' where co.empresa_ID='.$_SESSION['empresa_ID'].' and co.del=0 and co.proveedor_ID=pr.ID and est.ID=co.estado_ID and mo.ID=co.moneda_ID and ct.ID=co.comprobante_tipo_ID ';


            if ($filtro != '') {
                $q.=' and ' . $filtro;
            }

            $q.=' Order By ' . $order;

            if ($desde != -1 && $hasta != -1) {
                $q.=' Limit ' . $desde . ',' . $hasta;
            }
            //echo $q;
            $dt = $cn->getGrid($q);
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    
    

    static function getGrid_CuentaXPagar($filtro = '', $desde = -1, $hasta = -1, $order = 'co.ID asc') {
        $cn = new connect();
        try {
            $q = 'select co.ID,pr.razon_social as proveedor,pr.ID as proveedor_ID,co.numero,co.numero_guia, fp.nombre, co.moneda_ID,';
            $q.= 'mo.descripcion as moneda,mo.simbolo,est.nombre as estado,co.fecha_emision,co.fecha_vencimiento,co.serie,';
            $q.= 'ct.nombre as comprobante,co.subtotal,co.vigv,co.subtotal,co.total,co.periodo';
            $q.=',co.monto_pendiente, co.estado_ID, co.fecha_anulacion, co.operador_ID_anulacion, co.motivo_anulacion_ID';
            $q.=' FROM compra co,proveedor pr,estado est, forma_pago fp, moneda mo, comprobante_tipo ct ';
            $q.=' where co.del=0 and co.proveedor_ID=pr.ID and est.ID=co.estado_ID and fp.ID=co.forma_pago_ID and mo.ID=co.moneda_ID and ct.ID=co.comprobante_tipo_ID ';


            if ($filtro != '') {
                $q.=' and ' . $filtro;
            }

            $q.=' Order By ' . $order;

            if ($desde != -1 && $hasta != -1) {
                $q.=' Limit ' . $desde . ',' . $hasta;
            }
            //echo $q;
            $dt = $cn->getGrid($q);
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    
    
        
    function actualizarAnulacion() {
        $cn = new connect();
        $numero = 0;
        try {
            $fecha_save = 'NULL';
            if ($this->fecha_anulacion != null) {
                $fecha_save = '"' . FormatTextToDate($this->fecha_anulacion, 'Y-m-d') . '"';
            }
            $q = 'update compra set fecha_anulacion =' . $fecha_save . ',motivo_anulacion_ID=' . $this->motivo_anulacion_ID;
            $q.=',operador_ID_anulacion=' . $this->operador_ID_anulacion . ', estado_ID=10 where ID=' . $this->ID;
            //echo $q;
            $numero = $cn->transa($q);
            // echo $q;
            $this->message = "Se anuló correctamente.";
            return $numero;

            
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    
	// inicio de reportes dasboard de compra//
	
	
	   
        static function MostrarGrafico_DiarioSoles() {
        $cn = new connect();
        try {
            $q = "SET lc_time_names = 'es_PE';";
            $cn->transa($q);
            $q = 'select co.fecha_emision,dayname(co.fecha_emision) as dia, sum(co.total) as total_dia , co.moneda_ID, co.estado_ID ';
            $q.='from compra co ';
            $q.=' where  YEARWEEK(co.fecha_emision) =  YEARWEEK(CURDATE()) and co.moneda_ID = 1 and co.estado_ID!= 10 and co.del=0 ';
            $q.=' group by co.fecha_emision ';
     //       $q.=' order by day(co.fecha_emision) desc';
            $q.=' limit 7 ';

//            echo $q;
            $dt = $cn->getGrid($q);
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    
    
        static function MostrarGrafico_DiarioDolares() {
        $cn = new connect();
        try {
            $q = "SET lc_time_names = 'es_PE';";
            $cn->transa($q);
            $q = 'select co.fecha_emision,dayname(co.fecha_emision) as dia, sum(co.total) as total_dia , co.moneda_ID, co.estado_ID ';
            $q.='from compra co ';
            $q.=' where  YEARWEEK(co.fecha_emision) =  YEARWEEK(CURDATE()) and co.moneda_ID = 2 and co.estado_ID!= 10 and co.del=0 ';
            $q.=' group by co.fecha_emision ';
     //       $q.=' order by day(co.fecha_emision) desc';
            $q.=' limit 7 ';

//            echo $q;
            $dt = $cn->getGrid($q);
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    
    
       static function MostrarGrafico_DiarioxMesSoles() {
        $cn = new connect();
        try {
            $q = "SET lc_time_names = 'es_PE';";
            $cn->transa($q);
            $q = ' select co.fecha_emision, DAYOFMONTH(co.fecha_emision) as numero_dia, monthname(co.fecha_emision) as mes, sum(co.total) as total_dia, co.moneda_ID, co.estado_ID ';
            $q.='from compra co ';
            $q.='  where month(co.fecha_emision) = month(curdate()) and co.moneda_ID = 1 and co.estado_ID!= 10 and co.del=0 ';
            $q.=' group by day(co.fecha_emision)  ';
     //       $q.=' order by day(co.fecha_emision) desc';
            $q.=' limit 31 ';

//            echo $q;
            $dt = $cn->getGrid($q);
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    
    
           static function MostrarGrafico_DiarioxMesDolares() {
        $cn = new connect();
        try {
            $q = "SET lc_time_names = 'es_PE';";
            $cn->transa($q);
            $q = ' select co.fecha_emision, DAYOFMONTH(co.fecha_emision) as numero_dia, monthname(co.fecha_emision) as mes, sum(co.total) as total_dia, co.moneda_ID, co.estado_ID ';
            $q.='from compra co ';
            $q.='  where month(co.fecha_emision) = month(curdate()) and co.moneda_ID = 2 and co.estado_ID!= 10 and co.del=0 ';
            $q.=' group by day(co.fecha_emision)  ';
     //       $q.=' order by day(co.fecha_emision) desc';
            $q.=' limit 31 ';

//            echo $q;
            $dt = $cn->getGrid($q);
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    
    
        
        static function MostrarGrafico_MensualSoles() {
        $cn = new connect();
        try {
            $q = "SET lc_time_names = 'es_PE';";
            $cn->transa($q);
            $q = 'select monthname(co.fecha_emision) as mes, sum(co.total) as total_mes, co.moneda_ID, co.estado_ID ';
            $q.='from compra co ';
            $q.=' where year(co.fecha_emision) = year(curdate()) and co.moneda_ID = 1 and co.estado_ID!= 10 and co.del=0';
            $q.=' group by monthname(co.fecha_emision)';
  //          $q.=' order by month(co.fecha_emision) desc';
            $q.=' limit 12';

//            echo $q;
            $dt = $cn->getGrid($q);
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    
    
            static function MostrarGrafico_MensualDolares() {
        $cn = new connect();
        try {
            $q = "SET lc_time_names = 'es_PE';";
            $cn->transa($q);
            $q = 'select monthname(co.fecha_emision) as mes, sum(co.total) as total_mes, co.moneda_ID, co.estado_ID ';
            $q.='from compra co ';
            $q.=' where year(co.fecha_emision) = year(curdate()) and co.moneda_ID = 2 and co.estado_ID!= 10 and co.del=0';
            $q.=' group by monthname(co.fecha_emision)';
  //          $q.=' order by month(co.fecha_emision) desc';
            $q.=' limit 12';

//            echo $q;
            $dt = $cn->getGrid($q);
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    
    
       static function MostrarGrafico_AnualSoles() {
        $cn = new connect();
        try {
            $q = 'select year(co.fecha_emision) as anio, sum(co.total) as total_anio, co.moneda_ID, co.estado_ID ';
            $q.='from compra co ';
            $q.='where co.moneda_ID = 1 and co.estado_ID!= 10 and co.del=0 ';
            $q.='group by year(co.fecha_emision)  ';
     //       $q.=' order by day(co.fecha_emision) desc';
//            echo $q;
            $dt = $cn->getGrid($q);
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    
    
    
           static function MostrarGrafico_AnualDolares() {
        $cn = new connect();
        try {
            $q = 'select year(co.fecha_emision) as anio, sum(co.total) as total_anio, co.moneda_ID, co.estado_ID ';
            $q.='from compra co ';
            $q.='where co.moneda_ID = 2 and co.estado_ID!= 10 and co.del=0 ';
            $q.='group by year(co.fecha_emision)  ';
     //       $q.=' order by day(co.fecha_emision) desc';
//            echo $q;
            $dt = $cn->getGrid($q);
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    

}


