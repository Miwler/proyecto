<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ventasController
 *
 * @author miwler
 */
    function get_Index($id){
        global $returnView;
        $returnView=true;
    }
 
   
    /*Reportes para compras*/
    function get_Reportes_Compras(){
        require ROOT_PATH.'models/reportes_empresa_usuario.php';
        
        global $returnView;
        $returnView=true;
        
        $dtReportes=reportes_empresa_usuario::getGrid('re.modulo_ID=2 and reu.usuario_ID='.$_SESSION['usuario_ID'],-1,-1,"re.titulo asc");
        
        $GLOBALS['dtReportes']=$dtReportes;
        
    }
    
    function post_Reportes_Compras(){
        
        require ROOT_PATH.'models/reportes_empresa_usuario.php';
        require ROOT_PATH.'models/reportes.php';
        global $returnView;
        $returnView=true;
        $rango=(isset($_POST['ckRango']))? 1 : 0;
        if(isset($_POST['selPeriodo']))$periodo=$_POST['selPeriodo'];
        if(isset($_POST['txtFecha_Inicio'])) $fecha_inicio=$_POST['txtFecha_Inicio'];
        if(isset($_POST['txtFecha_Fin'])) $fecha_fin=$_POST['txtFecha_Fin'];
        if(isset($_POST['selProveedor'])) $proveedor_ID=$_POST['selProveedor'];
        if(isset($_POST['selMoneda'])) $moneda_ID=$_POST['selMoneda'];
        if(isset($_POST['txtSerie'])) $serie=$_POST['txtSerie'];
        if(isset($_POST['txtNumero']))$numero=$_POST['txtNumero'];
        $reportes_ID=$_POST['txtID'];
        $oReportes=reportes::getByID($reportes_ID);
        try{
            switch($reportes_ID){
                case 5://Compras por proveedor
                    $filtro="co.estado_ID in (9,11)";//Mostramos las compras en estado pendiente y cancelado
                    $subtitulo="";
                    if($rango==1){
                        $filtro.=($filtro=="")? "":" and ";
                        $filtro.="co.fecha_emision between '".$fecha_inicio."' and '".$fecha_fin."'"; 
                        $subtitulo="Desde: ".$fecha_inicio. " Hasta: ". $fecha_fin;
                    }else{
                        $filtro.=($filtro=="")? "":" and ";
                        $filtro.="co.periodo = ".$periodo;  
                        $subtitulo="Periodo: ".$periodo;
                    }
                    if($moneda_ID>0){
                        $filtro.=($filtro=="")? "":" and ";
                        $filtro.="co.moneda_ID=".$moneda_ID;  
                    }
                    $dtReportes1=reportes::getReporteCompras_Proveedor($filtro,-1,-1,"pro.razon_social asc,co.moneda_ID asc","co.proveedor_ID,co.moneda_ID");
                    $titulo_cabecera=array("ruc"=>"Ruc",
                        "razon_social"=>"Razón Social",
                        "moneda"=>"Moneda",
                        "sub_total"=>"Sub Total",
                        "igv"=>"IGV",
                        "total"=>"Total",
                        );
                    contructor_excel($dtReportes1,$oReportes,$titulo_cabecera,$subtitulo);
                    break;
                case 6://Compras por proveedor detalle
                    $filtro="co.estado_ID in (9,11)";//Mostramos las compras en estado pendiente y cancelado
                    $subtitulo="";
                    if($rango==1){
                        $filtro.=($filtro=="")? "":" and ";
                        $filtro.="co.fecha_emision between '".$fecha_inicio."' and '".$fecha_fin."'";  
                        $subtitulo="Desde: ".$fecha_inicio. " Hasta: ". $fecha_fin;
                    }else{
                        $filtro.=($filtro=="")? "":" and ";
                        $filtro.="co.periodo = ".$periodo;  
                        $subtitulo="Periodo: ".$periodo;
                    }
                    if($moneda_ID>0){
                        $filtro.=($filtro=="")? "":" and ";
                        $filtro.="co.moneda_ID=".$moneda_ID;  
                    }
                    if($proveedor_ID!="" && $proveedor_ID>0){
                        $filtro.=($filtro=="")? "":" and ";
                        $filtro.="co.proveedor_ID=".$proveedor_ID;  
                    }
                    $dtReportes1=reportes::getReporteCompras_Proveedor_Detalle($filtro,-1,-1);
                    $titulo_cabecera=array("ruc"=>"Ruc",
                        "razon_social"=>"Razón Social",
                        "periodo"=>"Periodo",
                        "fecha_emision"=>"Fecha emisión",
                        "factura"=>"N° Factura",
                        "simbolo"=>"Moneda",
                        "subtotal"=>"Sub Total",
                        "igv"=>"IGV",
                        "total"=>"Total",
                        );
                    contructor_excel($dtReportes1,$oReportes,$titulo_cabecera,$subtitulo);
                    break;
                case 7://Cuentas por pagar detalle
                    
                    $subtitulo="";
                    $filtro="";
                    if($rango==1){
                        $filtro.=($filtro=="")? "":" and ";
                        $filtro.="co.fecha_emision between '".$fecha_inicio."' and '".$fecha_fin."'";  
                        $subtitulo="Desde: ".$fecha_inicio. " Hasta: ". $fecha_fin;
                    }else{
                        $filtro.=($filtro=="")? "":" and ";
                        $filtro.="co.periodo = ".$periodo;  
                        $subtitulo="Periodo: ".$periodo;
                    }
                    if($moneda_ID>0){
                        $filtro.=($filtro=="")? "":" and ";
                        $filtro.="co.moneda_ID=".$moneda_ID;  
                    }
                    if($proveedor_ID!="" && $proveedor_ID>0){
                        $filtro.=($filtro=="")? "":" and ";
                        $filtro.="co.proveedor_ID=".$proveedor_ID;  
                    }
                    $dtReportes=reportes::getReporteCuentas_Pagar_Detalle($filtro,-1,-1);
                    $titulo_cabecera=array("ruc"=>"Ruc",
                    "razon_social"=>"Razón Social",
                    "periodo"=>'Periodo',
                    "fecha_emision"=>'Fecha',
                    "fecha_vencimiento"=>"Fecha vec.",
                    "factura"=>'Factura',
                    "moneda"=>"Moneda",
                    "subtotal"=>"Sub Total",
                    "igv"=>"IGV",
                    "total"=>"Total",
                    "monto_pendiente"=>"Pendiente"
                    );
                    contructor_excel($dtReportes,$oReportes,$titulo_cabecera,$subtitulo);
                    break;
                case 8://Cuentas por pagar
                    
                    $subtitulo="";
                    $filtro="";
                    if($rango==1){
                        $filtro.=($filtro=="")? "":" and ";
                        $filtro.="co.fecha_emision between '".$fecha_inicio."' and '".$fecha_fin."'";  
                        $subtitulo="Desde: ".$fecha_inicio. " Hasta: ". $fecha_fin;
                    }else{
                        $filtro.=($filtro=="")? "":" and ";
                        $filtro.="co.periodo = ".$periodo;  
                        $subtitulo="Periodo: ".$periodo;
                    }
                    if($moneda_ID>0){
                        $filtro.=($filtro=="")? "":" and ";
                        $filtro.="co.moneda_ID=".$moneda_ID;  
                    }
                    if($proveedor_ID!="" && $proveedor_ID>0){
                        $filtro.=($filtro=="")? "":" and ";
                        $filtro.="co.proveedor_ID=".$proveedor_ID;  
                    }
                    $dtReportes=reportes::getReporteCuentas_Pagar($filtro,-1,-1);
                    $titulo_cabecera=array("ruc"=>"Ruc",
                    "razon_social"=>"Razón Social",
                    "moneda"=>"Moneda",
                    "subtotal"=>"Sub Total",
                    "igv"=>"IGV",
                    "total"=>"Total",
                    "monto_pendiente"=>"Pendiente"
                    );
                    contructor_excel($dtReportes,$oReportes,$titulo_cabecera,$subtitulo);
                    break;
                case 11://Compras anuladas
                    
                    $subtitulo="";
                    $filtro="";
                    if($rango==1){
                        $filtro.=($filtro=="")? "":" and ";
                        $filtro.="co.fecha_emision between '".$fecha_inicio."' and '".$fecha_fin."'";  
                        $subtitulo="Desde: ".$fecha_inicio. " Hasta: ". $fecha_fin;
                    }else{
                        $filtro.=($filtro=="")? "":" and ";
                        $filtro.="co.periodo = ".$periodo;  
                        $subtitulo="Periodo: ".$periodo;
                    }
                    if($moneda_ID>0){
                        $filtro.=($filtro=="")? "":" and ";
                        $filtro.="co.moneda_ID=".$moneda_ID;  
                    }
                    if($proveedor_ID!="" && $proveedor_ID>0){
                        $filtro.=($filtro=="")? "":" and ";
                        $filtro.="co.proveedor_ID=".$proveedor_ID;  
                    }
                    $dtReportes=reportes::getReporteAnulacionCompras($filtro,-1,-1);
                    $titulo_cabecera=array("fecha_anulacion"=>"Fecha anulación",
                        "ruc"=>"Ruc",
                        "razon_social"=>"Razón Social",
                        "comprobante"=>"Factura",
                        "simbolo"=>"Moneda",
                        "total"=>"Total",
                        "autorizador"=>"Autorizado por",
                        "motivo"=>"Motivo"
                       
                        );
                    contructor_excel($dtReportes,$oReportes,$titulo_cabecera,$subtitulo);
                    break;
            }
            
        }catch(Exception $ex){
            $excel->sheet('Worksheet', function (PHPExcel_Worksheet $sheet) use ($ex)   
            {
            $sheet->setCellValue('A3', $ex->getMessage());
            });
           
        }
        
        $dtReportes=reportes_empresa_usuario::getGrid('re.modulo_ID=2 and reu.usuario_ID='.$_SESSION['usuario_ID'],-1,-1,"re.titulo asc");
        $GLOBALS['dtReportes']=$dtReportes;
       
        
    }
    function post_ajaxReportes_Compras_Campos() {
        require ROOT_PATH . 'models/reportes.php';
        require ROOT_PATH . 'models/reportes_campos.php';
        require ROOT_PATH . 'controls/funcionController.php';
        require ROOT_PATH . 'models/estado.php';
        require ROOT_PATH . 'models/operador.php';
        require ROOT_PATH . 'models/moneda.php';
        require ROOT_PATH . 'models/proveedor.php';
        $reportes_ID=$_POST['id'];
        $oReportes=reportes::getByID($reportes_ID);
        try {
        $resultado= '<div class="form-group">';
        $resultado.= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">';
        $resultado.='<h2 style="margin:0 0 10px 0;">'.FormatTextView(strtoupper($oReportes->titulo)).'</h2>';
        $resultado.='<input id="txtID" name="txtID" value="'.$reportes_ID.'" style="display:none;">';
        $resultado.='</div>';
        $resultado.='</div>';
         
        $resultado.= '<div class="form-group">';
        $resultado.='<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-right"><label>Periodo:</label></div>';
        $resultado.='<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">';
        $resultado.='<select id="selPeriodo" name="selPeriodo" class="form-control" disabled>';
        for($i=periodo_inicio;$i<=date("Y");$i++){
            $resultado.='<option '.((date("Y")==$i)?'selected':'').' value="'.$i.'">'.$i.'</option>';
        }
        $resultado.='</select>';
        $resultado.='</div>';
        //$resultado.='<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right"><label>Rango:</label></div>';
        $resultado.='<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">';
         $resultado.='<div class="ckbox ckbox-theme"><input type="checkbox" name="ckRango" id="ckRango" disabled onclick="fncActivarRango(this);"><label for="ckRango">Rango</label></div>';
        $resultado.='</div>';
        $resultado.='</div>';
        
        $resultado.= '<div class="form-group">';
        $resultado.='<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-right"><label>Fecha inicio:</label></div>';
        $resultado.='<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">';
        $resultado.='<input type="text" id="txtFecha_Inicio" name="txtFecha_Inicio" class="form-control date-range-picker-single" disabled>';
        $resultado.='</div>';
        $resultado.='<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-right"><label>Fecha fin:</label></div>';
        $resultado.='<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">';
        $resultado.='<input type="text" id="txtFecha_Fin" name="txtFecha_Fin" class="form-control date-range-picker-single" disabled>';
        $resultado.='</div>';
        $resultado.='</div>';
        
        $resultado.= '<div class="form-group">';
        $resultado.='<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-right"><label>Proveedor</label></div>';
        $resultado.='<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">';
        
        //$resultado.='<input type="text" id="txtProveedor_ID" class="form-control" disabled>';
        $dtProveedor=proveedor::getGrid("prv.empresa_ID=".$_SESSION['empresa_ID']." and prv.ID<>0",-1,-1,"prv.razon_social asc");
        $resultado.='<select id="selProveedor" name="selProveedor" class="chosen-select">';
        $resultado.='<option value="0">-TODOS-</option>';
        foreach($dtProveedor as $iproveedor){
           $resultado.='<option value="'.$iproveedor['ID'].'">'.FormatTextView(strtoupper($iproveedor['razon_social'])).'</option>'; 
        }
        $resultado.='<select>';
        $resultado.='</div>';
        $resultado.='<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-right"><label>Moneda</label></div>';
        $resultado.='<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">';
        $resultado.='<select id="selMoneda" name="selMoneda" class="form-control" disabled>';
         $resultado.='<option value="0">Todos</option>';
        foreach(moneda::getGrid("") as $moneda){
            $resultado.='<option value="'.$moneda['ID'].'">'.FormatTextView($moneda['descripcion']).'</option>';
        }
        
        $resultado.='</select>';
        $resultado.='</div>';
        $resultado.='</div>';
        
        $resultado.= '<div class="form-group">';
        $resultado.='<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-right"><label>Serie:</label></div>';
        $resultado.='<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">';
        $resultado.='<input type="txtSerie" id="txtSerie" class="form-control" disabled>';
        $resultado.='</div>';
        $resultado.='<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-right"><label>Número</label></div>';
        $resultado.='<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">';
        $resultado.='<input  type="text" id="txtNumero" name="txtNumero" class="form-control" disabled>';
        $resultado.='</div>';
        $resultado.='</div>';
        
        $resultado.= '<div class="form-group">';
        $resultado.='<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">';
        $resultado.='<button type="button" class="btn btn-success" title="Exportar a PDF" onclick="fncGenerar();"><span class="glyphicon glyphicon-list-alt"></span> Descargar PDF  </button>&nbsp;&nbsp;&nbsp;&nbsp;';
        $resultado.='<button class="btn btn-success" title="Exportar a excel" ><span class="glyphicon glyphicon-list-alt"></span> Descargar excel  </button>';
        $resultado.='</div>';
        $resultado.='</div>';
        
        

        } catch (Exception $ex) {
            $resultado.='<tr ><td colspan=' . $colspan . '>' . $ex->getMessage() . '</td></tr>';
        }

        $resultado.='</table>';

        
        $retornar = Array('resultado' => $resultado);
        //$retorn="<h1>Hola</h1>";

        echo json_encode($retornar);
    }
    function post_ajaxGenerar_Reportes_Compras() {
        //require ('./controls/reportepdf.php');
        require ROOT_PATH . 'models/reportes.php';
        require ROOT_PATH . 'models/reportes_campos.php';
        require ROOT_PATH . 'models/inventario.php';
        require ROOT_PATH . 'controls/funcionController.php';
        require ROOT_PATH . 'models/operador.php';
        
        $reportes_ID=$_POST['txtID'];
        
        //$oReportes=reportes::getByID($reportes_ID);
        
        $rango=(isset($_POST['ckRango']))? 1 : 0;
        if(isset($_POST['selPeriodo']))$periodo=$_POST['selPeriodo'];
        if(isset($_POST['txtFecha_Inicio']))$fecha_inicio=$_POST['txtFecha_Inicio'];
    
        if(isset($_POST['txtFecha_Fin'])) $fecha_fin=$_POST['txtFecha_Fin'];
        if(isset($_POST['selProveedor']))$proveedor_ID=$_POST['selProveedor'];
        if(isset($_POST['selMoneda']))$moneda_ID=$_POST['selMoneda'];
        if(isset($_POST['txtSerie']))$serie=$_POST['txtSerie'];
        if(isset($_POST['txtNumero']))$serie=$_POST['txtNumero'];
        try {
            
            $filtro="";
            switch($reportes_ID){
                case 5://Compras por proveedor
                   
                    $oReportes=reportes::getByID($reportes_ID);
                    $subtitulo="";
                    $filtro="co.estado_ID in (9,11)";//Mostramos las compras en estado pendiente y cancelado
                    if($rango==1){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="co.fecha_emision between '".$fecha_inicio."' and '".$fecha_fin."'";  
                        $subtitulo="Desde: ".$fecha_inicio. " Hasta: ". $fecha_fin;
                    }else{
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="co.periodo = ".$periodo;  
                        $subtitulo="Periodo: ".$periodo;
                    }
                    if($moneda_ID>0){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="co.moneda_ID=".$moneda_ID;  
                    }
                    $dtReportes=reportes::getReporteCompras_Proveedor($filtro,-1,-1,"pro.razon_social asc,co.moneda_ID asc","co.proveedor_ID,co.moneda_ID");
                    $titulo_cabecera=array("ruc"=>"Ruc",
                        "razon_social"=>"Razón Social",
                        "moneda"=>"Moneda",
                        "sub_total"=>"Sub Total",
                        "igv"=>"IGV",
                        "total"=>"Total"
                        );
                    $array_ancho=array(20,70,20,25,25,25);
                    $array_alineacion=array('L','L','C','R','R','R');
                    $array_tipo=array('texto','texto','texto','moneda','moneda','moneda');
                    $ruta=contructor_pdf_reporte($dtReportes,$oReportes,$titulo_cabecera,$subtitulo,"vertical",$array_ancho,$array_alineacion,$array_tipo);
                    
                    break;
                case 6://Compras por proveedor detalle
                //$pdf= new PDF1('L','mm','A4');
                $oReportes=reportes::getByID($reportes_ID);

                $subtitulo="";
                $filtro="co.estado_ID in (9,11)";//Mostramos las compras en estado pendiente y cancelado
                if($rango==1){
                    $filtro.=($filtro=="")? "":" and ";
                    $filtro.="co.fecha_emision between '".$fecha_inicio."' and '".$fecha_fin."'";  
                    $subtitulo="Desde: ".$fecha_inicio. " Hasta: ". $fecha_fin;
                }else{
                    $filtro.=($filtro=="")? "":" and ";
                    $filtro.="co.periodo = ".$periodo;  
                    $subtitulo="Periodo: ".$periodo;
                }
                if($moneda_ID>0){
                    $filtro.=($filtro=="")? "":" and ";
                    $filtro.="co.moneda_ID=".$moneda_ID;  
                }
                if($proveedor_ID!="" && $proveedor_ID>0){
                    $filtro.=($filtro=="")? "":" and ";
                    $filtro.="co.proveedor_ID=".$proveedor_ID;  
                }

                $dtReportes=reportes::getReporteCompras_Proveedor_Detalle($filtro,-1,-1);
                $titulo_cabecera=array("ruc"=>"Ruc",
                    "razon_social"=>"Razón Social",
                    "periodo"=>'Periodo',
                    "fecha_emision"=>'Fecha',
                    "factura"=>'Factura',
                    "simbolo"=>"Moneda",
                    "sub_total"=>"Sub Total",
                    "igv"=>"IGV",
                    "total"=>"Total"
                    );
                $array_ancho=array(20,70,20,30,20,25,25,25,25);
                $array_alineacion=array('L','L','L','L','C','R','R','R','R');
                $array_tipo=array('texto','texto','numero','texto','texto','texto','moneda','moneda','moneda');
                $ruta=contructor_pdf_reporte($dtReportes,$oReportes,$titulo_cabecera,$subtitulo,"horizontal",$array_ancho,$array_alineacion,$array_tipo);
                break;
                case 7://Compras por proveedor detalle
                //$pdf= new PDF1('L','mm','A4');
                $oReportes=reportes::getByID($reportes_ID);

                $subtitulo="";
                //$filtro="co.estado_ID in (9,11)";//Mostramos las compras en estado pendiente y cancelado
                if($rango==1){
                    $filtro.=($filtro=="")? "":" and ";
                    $filtro.="co.fecha_emision between '".$fecha_inicio."' and '".$fecha_fin."'";  
                    $subtitulo="Desde: ".$fecha_inicio. " Hasta: ". $fecha_fin;
                }else{
                    $filtro.=($filtro=="")? "":" and ";
                    $filtro.="co.periodo = ".$periodo;  
                    $subtitulo="Periodo: ".$periodo;
                }
                if($moneda_ID>0){
                    $filtro.=($filtro=="")? "":" and ";
                    $filtro.="co.moneda_ID=".$moneda_ID;  
                }
                if($proveedor_ID!="" && $proveedor_ID>0){
                    $filtro.=($filtro=="")? "":" and ";
                    $filtro.="co.proveedor_ID=".$proveedor_ID;  
                }

                $dtReportes=reportes::getReporteCuentas_Pagar_Detalle($filtro,-1,-1);
                $titulo_cabecera=array("ruc"=>"Ruc",
                    "razon_social"=>"Razón Social",
                    "periodo"=>'Periodo',
                    "fecha_emision"=>'Fecha',
                    "fecha_vencimiento"=>"Fecha vec.",
                    "factura"=>'Factura',
                    "moneda"=>"Moneda",
                    "subtotal"=>"Sub Total",
                    "igv"=>"IGV",
                    "total"=>"Total",
                    "monto_pendiente"=>"Pendiente"
                    );
                $array_ancho=array(20,50,15,20,25,20,20,25,25,25,25);
                $array_alineacion=array('L','L','C','C','C','C','C','R','R','R','R');
                $array_tipo=array('texto','texto','numero','texto','texto','texto','texto','moneda','moneda','moneda','moneda');
                $ruta=contructor_pdf_reporte($dtReportes,$oReportes,$titulo_cabecera,$subtitulo,"horizontal",$array_ancho,$array_alineacion,$array_tipo);
                break;
                case 8://Compras por proveedor

                    $oReportes=reportes::getByID($reportes_ID);

                    $subtitulo="";

                    if($rango==1){
                        $filtro.=($filtro=="")? "":" and ";
                        $filtro.="co.fecha_emision between '".$fecha_inicio."' and '".$fecha_fin."'";  
                        $subtitulo="Desde: ".$fecha_inicio. " Hasta: ". $fecha_fin;
                    }else{
                        $filtro.=($filtro=="")? "":" and ";
                        $filtro.="co.periodo = ".$periodo;  
                        $subtitulo="Periodo: ".$periodo;
                    }
                    if($moneda_ID>0){
                        $filtro.=($filtro=="")? "":" and ";
                        $filtro.="co.moneda_ID=".$moneda_ID;  
                    }
                    if($proveedor_ID!="" && $proveedor_ID>0){
                        $filtro.=($filtro=="")? "":" and ";
                        $filtro.="co.proveedor_ID=".$proveedor_ID;  
                    }

                    $dtReportes=reportes::getReporteCuentas_Pagar($filtro,-1,-1);
                    $titulo_cabecera=array("ruc"=>"Ruc",
                        "razon_social"=>"Razón Social",
                        "moneda"=>"Moneda",
                        "subtotal"=>"Sub Total",
                        "igv"=>"IGV",
                        "total"=>"Total",
                        "monto_pendiente"=>"Pendiente"
                        );
                    $array_ancho=array(20,50,15,25,25,25,25);
                    $array_alineacion=array('L','L','C','R','R','R','R');
                    $array_tipo=array('texto','texto','texto','moneda','moneda','moneda','moneda');
                    $ruta=contructor_pdf_reporte($dtReportes,$oReportes,$titulo_cabecera,$subtitulo,"vertical",$array_ancho,$array_alineacion,$array_tipo);
                    break;
                case 11://Compras anulados

                    $oReportes=reportes::getByID($reportes_ID);

                    $subtitulo="";

                    if($rango==1){
                        $filtro.=($filtro=="")? "":" and ";
                        $filtro.="co.fecha_emision between '".$fecha_inicio."' and '".$fecha_fin."'";  
                        $subtitulo="Desde: ".$fecha_inicio. " Hasta: ". $fecha_fin;
                    }else{
                        $filtro.=($filtro=="")? "":" and ";
                        $filtro.="co.periodo = ".$periodo;  
                        $subtitulo="Periodo: ".$periodo;
                    }
                    if($moneda_ID>0){
                        $filtro.=($filtro=="")? "":" and ";
                        $filtro.="co.moneda_ID=".$moneda_ID;  
                    }
                    if($proveedor_ID!="" && $proveedor_ID>0){
                        $filtro.=($filtro=="")? "":" and ";
                        $filtro.="co.proveedor_ID=".$proveedor_ID;  
                    }

                    $dtReportes=reportes::getReporteAnulacionCompras($filtro,-1,-1);
                    $titulo_cabecera=array("fecha_anulacion"=>"Fecha anulación",
                        "ruc"=>"Ruc",
                        "razon_social"=>"Razón Social",
                        "comprobante"=>"Factura",
                        "simbolo"=>"Moneda",
                        "total"=>"Total",
                        "autorizador"=>"Autorizado por",
                        "motivo"=>"Motivo"
                       
                        );
                    $array_ancho=array(30,25,70,20,20,25,30,30);
                    $array_alineacion=array('C','L','L','L','C','R','L','L');
                    $array_tipo=array('texto','texto','texto','texto','texto','numero','texto','texto');
                    $ruta=contructor_pdf_reporte($dtReportes,$oReportes,$titulo_cabecera,$subtitulo,"horizontal",$array_ancho,$array_alineacion,$array_tipo);
                    break;
            }

        $mensaje='';

        } catch (Exception $ex) {
            $mensaje= $ex->getMessage() ;
            $ruta='';
        }
        
       
        $retornar = Array('url' => $ruta,'mensaje'=>$mensaje);
        //$retorn="<h1>Hola</h1>";

        echo json_encode($retornar);
    }
    
    /*Reporte de ventas*/
    function get_Reportes_Ventas(){
        require ROOT_PATH.'models/reportes_empresa_usuario.php';
        
        global $returnView;
        $returnView=true;
        
        $dtReportes=reportes_empresa_usuario::getGrid('re.modulo_ID=3 and reu.usuario_ID='.$_SESSION['usuario_ID'],-1,-1,"re.orden,re.titulo asc");
        
        $GLOBALS['dtReportes']=$dtReportes;
        
    }
    function post_Reportes_Ventas(){
        
        require ROOT_PATH.'models/reportes_empresa_usuario.php';
        require ROOT_PATH.'models/reportes.php';
        global $returnView;
        $returnView=true;
        $rango=(isset($_POST['ckRango']))? 1 : 0;
        if(isset($_POST['selPeriodo']))$periodo=$_POST['selPeriodo'];
        if(isset($_POST['txtFecha_Inicio'])) $fecha_inicio=$_POST['txtFecha_Inicio'];
        if(isset($_POST['txtFecha_Fin'])) $fecha_fin=$_POST['txtFecha_Fin'];
        if(isset($_POST['selCliente'])) $cliente_ID=$_POST['selCliente'];
        if(isset($_POST['selMoneda'])) $moneda_ID=$_POST['selMoneda'];
        if(isset($_POST['txtSerie'])) $serie=$_POST['txtSerie'];
        if(isset($_POST['txtNumero']))$numero=$_POST['txtNumero'];
        if(isset($_POST['selOperador']))$operador_ID=$_POST['selOperador'];
        if(isset($_POST['ckEstado']))$estado_ID=$_POST['ckEstado'];
        $reportes_ID=$_POST['txtID'];
        $oReportes=reportes::getByID($reportes_ID);
        $filtro="";
        try{
            
            switch($reportes_ID){
                case 1://Comisión total por empleado
                    $subtitulo="";
                    if($rango==1){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.fecha between '".$fecha_inicio."' and '".$fecha_fin."'";  
                        $subtitulo="Desde: ".$fecha_inicio. " Hasta: ". $fecha_fin;
                    }else {
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.periodo = ".$periodo;  
                        $subtitulo="Periodo: ".$periodo;
                    }
                    if($moneda_ID>0){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.moneda_ID=".$moneda_ID;  
                    }
                    
                    if($operador_ID!=0){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.operador_ID=".$operador_ID;
                    }
                    if(isset($_POST['ckEstado'])){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="fv.estado_ID =60"; 
                    }else{
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="fv.estado_ID in (60,41)";
                        
                    }
                    $dtReportes=reportes::getComisionesGenerales($filtro,-1,-1);
                    $titulo_cabecera=array("operador"=>"Operador",
                        "comision"=>"Comisión(%)",
                        "utilidad_soles"=>"Util. (S/.)",
                        "utilidad_dolares"=>"Util. (U$$.)",
                        "comision_soles"=>"Comisión (S/.)",
                        "comision_dolares"=>"Comisión (U$$.)"
                        );
                    contructor_excel($dtReportes,$oReportes,$titulo_cabecera,$subtitulo);
                    break;
                case 2://Comisión detalle por empleado
                    $subtitulo="";
                    if($rango==1){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.fecha between '".$fecha_inicio."' and '".$fecha_fin."'";  
                        $subtitulo="Desde: ".$fecha_inicio. " Hasta: ". $fecha_fin;
                    }else {
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.periodo = ".$periodo;  
                        $subtitulo="Periodo: ".$periodo;
                    }
                    if($moneda_ID>0){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.moneda_ID=".$moneda_ID;  
                    }
                    
                    if($operador_ID!=0){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.operador_ID=".$operador_ID;
                    }
                    if(isset($_POST['ckEstado'])){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="fv.estado_ID =60"; 
                    }else{
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="fv.estado_ID in (60,41)";
                        
                    }
                    $dtReportes1=reportes::getComisionesDetalles($filtro,-1,-1);
                    $titulo_cabecera=array("operador"=>"Operador",
                        "serie"=>"Serie",
                        "numero_factura"=>"N° factura",
                        "comision"=>"Comisión(%)",
                        "utilidad_soles"=>"Util. (S/.)",
                        "utilidad_dolares"=>"Util. (U$$.)",
                        "comision_soles"=>"Comisión (S/.)",
                        "comision_dolares"=>"Comisión (U$$.)"
                        );
                    contructor_excel($dtReportes1,$oReportes,$titulo_cabecera,$subtitulo);
                    break;
                case 3://Ventas por cliente
                    $subtitulo="";
                    if($rango==1){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.fecha between '".$fecha_inicio."' and '".$fecha_fin."'";  
                        $subtitulo="Desde: ".$fecha_inicio. " Hasta: ". $fecha_fin;
                    }else {
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.periodo = ".$periodo;  
                        $subtitulo="Periodo: ".$periodo;
                    }
                    if($moneda_ID>0){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.moneda_ID=".$moneda_ID;  
                    }
                    
                    if($operador_ID!=0){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.operador_ID=".$operador_ID;
                    }
                    if(isset($_POST['ckEstado'])){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="fv.estado_ID =60"; 
                    }else{
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="fv.estado_ID in (60,41)";
                        
                    }
                    $dtReportes=reportes::getVentasClientes($filtro,-1,-1);
                    $titulo_cabecera=array("ruc"=>"RUC",
                        "razon_social"=>"Razón Social",
                        "moneda"=>"Moneda",
                        "monto_total"=>"Total"
                        );
                    contructor_excel($dtReportes,$oReportes,$titulo_cabecera,$subtitulo);
                    break;
                case 4://Ventas por cliente detalle
                    $subtitulo="";
                    if($rango==1){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.fecha between '".$fecha_inicio."' and '".$fecha_fin."'";  
                        $subtitulo="Desde: ".$fecha_inicio. " Hasta: ". $fecha_fin;
                    }else {
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.periodo = ".$periodo;  
                        $subtitulo="Periodo: ".$periodo;
                    }
                    if($moneda_ID>0){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.moneda_ID=".$moneda_ID;  
                    }
                    
                    if($operador_ID!=0){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.operador_ID=".$operador_ID;
                    }
                    if(isset($_POST['ckEstado'])){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="fv.estado_ID =60"; 
                    }else{
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="fv.estado_ID in (60,41)";
                        
                    }
                    $dtReportes=reportes::getVentasClientesDetalle($filtro,-1,-1);
                    $titulo_cabecera=array("ruc"=>"RUC",
                        "razon_social"=>"Razón Social",
                         "fecha"=>"Fecha",
                         "factura"=>"Factura",
                        "moneda"=>"Moneda",
                        "monto_total"=>"Total"
                        );
                    contructor_excel($dtReportes,$oReportes,$titulo_cabecera,$subtitulo);
                    break;
                case 9://facturas por cobrar
                    $subtitulo="";
                    if($rango==1){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.fecha between '".$fecha_inicio."' and '".$fecha_fin."'";  
                        $subtitulo="Desde: ".$fecha_inicio. " Hasta: ". $fecha_fin;
                    }else {
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.periodo = ".$periodo;  
                        $subtitulo="Periodo: ".$periodo;
                    }
                    if($moneda_ID>0){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.moneda_ID=".$moneda_ID;  
                    }
                    
                    if($operador_ID!=0){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.operador_ID=".$operador_ID;
                    }
                    if(isset($_POST['ckEstado'])){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="fv.estado_ID =60"; 
                    }else{
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="fv.estado_ID in (60,41)";
                        
                    }
                    if(isset($cliente_ID)&&$cliente_ID!=""){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.cliente_ID=" .$cliente_ID;  
                    }
                    $dtReportes=reportes::getReporteFacturasCobrarDetalle($filtro,-1,-1);
                    $titulo_cabecera=array("ruc"=>"RUC",
                        "razon_social"=>"Razón Social",
                        "factura"=>"Factura",
                        "fecha_emision"=>"Fecha Emi.",
                        "fecha_vencimiento"=>"Fecha ven.",
                        "moneda"=>"Moneda",
                        "monto_total"=>"Total",
                        "monto_pendiente"=>"Saldo"
                        );
                    contructor_excel($dtReportes,$oReportes,$titulo_cabecera,$subtitulo);
                    break;
                case 10://Cuentas totales por cobrar
                    $subtitulo="";
                    if($rango==1){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.fecha between '".$fecha_inicio."' and '".$fecha_fin."'";  
                        $subtitulo="Desde: ".$fecha_inicio. " Hasta: ". $fecha_fin;
                    }else {
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.periodo = ".$periodo;  
                        $subtitulo="Periodo: ".$periodo;
                    }
                    if($moneda_ID>0){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.moneda_ID=".$moneda_ID;  
                    }
                    
                    if($operador_ID!=0){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.operador_ID=".$operador_ID;
                    }
                    if(isset($_POST['ckEstado'])){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="fv.estado_ID =60"; 
                    }else{
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="fv.estado_ID in (60,41)";
                        
                    }
                    if(isset($cliente_ID)&&$cliente_ID!=""){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.cliente_ID=" .$cliente_ID;  
                    }
                    $dtReportes=reportes::getReporteCuentasTotaltesCobrar($filtro,-1,-1);
                    $titulo_cabecera=array("ruc"=>"RUC",
                        "razon_social"=>"Razón Social",
                        "moneda"=>"Moneda",
                        "monto_total"=>"Total",
                        "monto_pendiente"=>"Saldo"
                        );
                    contructor_excel($dtReportes,$oReportes,$titulo_cabecera,$subtitulo);
                    break;
            }
            $resultado=1;
        }catch(Exception $ex){
            $excel->sheet('Worksheet', function (PHPExcel_Worksheet $sheet) use ($ex)   
            {
            $sheet->setCellValue('A3', $ex->getMessage());
            });
           $resultado=-1;
        }
        $dtReportes=reportes_empresa_usuario::getGrid('re.modulo_ID=2 and reu.usuario_ID='.$_SESSION['usuario_ID'],-1,-1,"re.titulo asc");
        
        $GLOBALS['dtReportes']=$dtReportes;
        $GLOBALS['resultado']=$resultado;
        
        
    }
    function post_ajaxReportes_Ventas_Campos() {
        require ROOT_PATH . 'models/reportes.php';
        require ROOT_PATH . 'models/reportes_campos.php';
        require ROOT_PATH . 'controls/funcionController.php';
        require ROOT_PATH . 'models/estado.php';
        require ROOT_PATH . 'models/operador.php';
        require ROOT_PATH . 'models/moneda.php';
        require ROOT_PATH . 'models/cliente.php';
        $reportes_ID=$_POST['id'];
        $oReportes=reportes::getByID($reportes_ID);
        try {
        $resultado= '<div class="form-group">';
        $resultado.= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">';
        $resultado.='<h2 style="margin:0 0 10px 0;">'.FormatTextView(strtoupper($oReportes->titulo)).'</h2>';
        $resultado.='<input id="txtID" name="txtID" value="'.$reportes_ID.'" style="display:none;">';
        $resultado.='</div>';
        $resultado.='</div>';
         
        $resultado.= '<div class="form-group">';
        $resultado.='<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-right"><label>Periodo:</label></div>';
        $resultado.='<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">';
        $resultado.='<select id="selPeriodo" name="selPeriodo" class="form-control" disabled>';
        for($i=periodo_inicio;$i<=date("Y");$i++){
            $resultado.='<option '.((date("Y")==$i)?'selected':'').' value="'.$i.'">'.$i.'</option>';
        }
        $resultado.='</select>';
        $resultado.='</div>';
        //$resultado.='<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-right"><label>Rango:</label></div>';
        $resultado.='<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">';
        $resultado.='<div class="ckbox ckbox-theme"><input type="checkbox" name="ckRango" id="ckRango" disabled onclick="fncActivarRango(this);"><label for="ckRango">Rango</label></div>';
        $resultado.='</div>';
        $resultado.='</div>';
        
        $resultado.= '<div class="form-group">';
        $resultado.='<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-right"><label>Fecha inicio:</label></div>';
        $resultado.='<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">';
        $resultado.='<input type="text" id="txtFecha_Inicio" name="txtFecha_Inicio" class="form-control date-range-picker-single" disabled>';
        $resultado.='</div>';
        $resultado.='<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-right"><label>Fecha fin:</label></div>';
        $resultado.='<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">';
        $resultado.='<input type="text" id="txtFecha_Fin" name="txtFecha_Fin" class="form-control date-range-picker-single" disabled>';
        $resultado.='</div>';
        $resultado.='</div>';
        
        $resultado.= '<div class="form-group">';
        $resultado.='<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-right"><label>Cliente</label></div>';
        $resultado.='<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">';
        $dtCliente=cliente::getGrid("",-1,-1,"clt.razon_social");
        //$resultado.='<input type="text" id="txtCliente_ID" class="form-control" disabled>';
        $resultado.='<select id="selCliente" name="selCliente" class="chosen-select">';
        $resultado.='<option values="0">Todos</option>';
        foreach($dtCliente as $icliente){
            $resultado.='<option values="'.$icliente['ID'].'">'.FormatTextView(strtoupper($icliente['razon_social'])).'</option>';
        }
        $resultado.='</select>';
        $resultado.='</div>';
        $resultado.='<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-right"><label>Moneda</label></div>';
        $resultado.='<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">';
        $resultado.='<select id="selMoneda" name="selMoneda" class="form-control" disabled>';
        $resultado.='<option value="0">Todos</option>';
        foreach(moneda::getGrid("") as $moneda){
            $resultado.='<option value="'.$moneda['ID'].'">'.FormatTextView($moneda['descripcion']).'</option>';
        }
        
        $resultado.='</select>';
        $resultado.='</div>';
        $resultado.='</div>';
        
        $resultado.= '<div class="form-group">';
        $resultado.='<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-right"><label>Serie:</label></div>';
        $resultado.='<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">';
        $resultado.='<input type="txtSerie" id="txtSerie" class="form-control" disabled>';
        $resultado.='</div>';
        $resultado.='<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-right"><label>Número</label></div>';
        $resultado.='<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">';
        $resultado.='<input  type="text" id="txtNumero" name="txtNumero" class="form-control" disabled>';
        $resultado.='</div>';
        $resultado.='</div>';
        
        $resultado.= '<div class="form-group">';
        $resultado.='<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-right"><label>Trabajador:</label></div>';
        $resultado.='<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">';
        $resultado.='<select id="selOperador" name="selOperador" class="form-control" disabled>';
        $resultado.='<option value="0">-Todos-</option>';
        $dtOperador=operador::getGrid("",-1,-1,"pe.apellido_paterno,pe.apellido_materno, pe.nombres");
        foreach($dtOperador as $ioperador){
           $resultado.='<option value="'.$ioperador['ID'].'">'.FormatTextView($ioperador['apellido_paterno'].' '.$ioperador['nombres']).'</option>'; 
        }
        $resultado.='</select>';
        $resultado.='</div>';
        //$resultado.='<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-right"><label>Solo Facturas cobrados</label></div>';
        $resultado.='<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">';
        $resultado.='<div class="ckbox ckbox-theme"><input type="checkbox" name="ckEstado" id="ckEstado" disabled ><label for="ckEstado">Solo Facturas cobrados</label></div>';
        $resultado.='</div>';
        $resultado.='</div>';
        
        $resultado.= '<div class="form-group">';
        $resultado.='<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">';
        $resultado.='<button type="button" class="btn btn-success" title="Exportar a PDF" onclick="fncGenerar();"><span class="glyphicon glyphicon-list-alt"></span> Descargar PDF  </button>&nbsp;&nbsp;&nbsp;&nbsp;';
        $resultado.='<button class="btn btn-success" title="Exportar a excel" ><span class="glyphicon glyphicon-list-alt"></span> Descargar excel  </button>';
        $resultado.='</div>';
        $resultado.='</div>';
        } catch (Exception $ex) {
            $resultado.='<tr ><td colspan=' . $colspan . '>' . $ex->getMessage() . '</td></tr>';
        }

        $resultado.='</table>';

        
        $retornar = Array('resultado' => $resultado);
        //$retorn="<h1>Hola</h1>";

        echo json_encode($retornar);
    }
    function post_ajaxGenerar_Reportes_Ventas() {
        //require ('./controls/reportepdf.php');
        require ROOT_PATH . 'models/reportes.php';
        require ROOT_PATH . 'models/reportes_campos.php';
       // require ROOT_PATH . 'models/inventario.php';
        //require ROOT_PATH . 'controls/funcionController.php';
        //require ROOT_PATH . 'models/operador.php';
        
        $reportes_ID=$_POST['txtID'];
        
        //$oReportes=reportes::getByID($reportes_ID);
        
        $rango=(isset($_POST['ckRango']))? 1 : 0;
        if(isset($_POST['selPeriodo']))$periodo=$_POST['selPeriodo'];
        if(isset($_POST['txtFecha_Inicio']))$fecha_inicio=$_POST['txtFecha_Inicio'];
    
        if(isset($_POST['txtFecha_Fin'])) $fecha_fin=$_POST['txtFecha_Fin'];
        if(isset($_POST['selCliente']))$cliente_ID=$_POST['selCliente'];
        if(isset($_POST['selMoneda']))$moneda_ID=$_POST['selMoneda'];
        if(isset($_POST['txtSerie']))$serie=$_POST['txtSerie'];
        if(isset($_POST['txtNumero']))$serie=$_POST['txtNumero'];
        if(isset($_POST['selOperador']))$operador_ID=$_POST['selOperador'];
        if(isset($_POST['ckEstado']))$estado_ID=$_POST['ckEstado'];
        $oReportes=reportes::getByID($reportes_ID);
        try {
            
            $filtro="";
            
            switch($reportes_ID){
                case 1://Comision total por empleado
                    $subtitulo="";
                    if($rango==1){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.fecha between '".$fecha_inicio."' and '".$fecha_fin."'";  
                        $subtitulo="Desde: ".$fecha_inicio. " Hasta: ". $fecha_fin;
                    }else {
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.periodo = ".$periodo;  
                        $subtitulo="Periodo: ".$periodo;
                    }
                    if($moneda_ID>0){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.moneda_ID=".$moneda_ID;  
                    }
                    
                     if($operador_ID!=0){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.operador_ID=".$operador_ID;
                    }
                    if(isset($_POST['ckEstado'])){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="fv.estado_ID =60"; 
                    }else{
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="fv.estado_ID in (60,41)";    
                    }
                    //$dtComisiones_Generales=reportes::getComisionesGenerales($filtro,-1,-1,"CONCAT(op.nombres,' ',op.apellido_paterno)");
                    $dtReportes=reportes::getComisionesGenerales($filtro,-1,-1);
                    $titulo_cabecera=array("operador"=>"Operador",
                        "comision"=>"Comisión(%)",
                        "utilidad_soles"=>"Util. (S/.)",
                        "utilidad_dolares"=>"Util. (U$$.)",
                        "comision_soles"=>"Comisión (S/.)",
                        "comision_dolares"=>"Comisión (U$$.)"
                        );
                    $array_ancho=array(50,15,15,25,25,25);
                    $array_alineacion=array('L','C','R','R','R','R');
                    $array_tipo=array('texto','numero','moneda','moneda','moneda','moneda');
                    $ruta=contructor_pdf_reporte($dtReportes,$oReportes,$titulo_cabecera,$subtitulo,"vertical",$array_ancho,$array_alineacion,$array_tipo);
             
                    break;
                case 2://Comisión detalle por empleado
                    $subtitulo="";
                    if($rango==1){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.fecha between '".$fecha_inicio."' and '".$fecha_fin."'";  
                        $subtitulo="Desde: ".$fecha_inicio. " Hasta: ". $fecha_fin;
                    }else {
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.periodo = ".$periodo;  
                        $subtitulo="Periodo: ".$periodo;
                    }
                    if($moneda_ID>0){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.moneda_ID=".$moneda_ID;  
                    }
                    
                     if($operador_ID!=0){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.operador_ID=".$operador_ID;
                    }
                    if(isset($_POST['ckEstado'])){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="fv.estado_ID =60"; 
                    }else{
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="fv.estado_ID in (60,41)";    
                    }
                    
                    $dtReportes=reportes::getComisionesDetalles($filtro,-1,-1);
                    $titulo_cabecera=array("operador"=>"Operador",
                        "serie"=>"Serie",
                        "numero_factura"=>"N° factura",
                        "comision"=>"Comisión(%)",
                        "utilidad_soles"=>"Util. (S/.)",
                        "utilidad_dolares"=>"Util. (U$$.)",
                        "comision_soles"=>"Comisión (S/.)",
                        "comision_dolares"=>"Comisión (U$$.)"
                        );
                    $array_ancho=array(50,10,15,15,15,25,25,25);
                    $array_alineacion=array('L','L','L','C','R','R','R','R');
                    $array_tipo=array('texto','texto','texto','numero','moneda','moneda','moneda','moneda');
                    $ruta=contructor_pdf_reporte($dtReportes,$oReportes,$titulo_cabecera,$subtitulo,"vertical",$array_ancho,$array_alineacion,$array_tipo);
             
                    break;
                case 3://Ventas por cliente
                    $subtitulo="";
                    if($rango==1){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.fecha between '".$fecha_inicio."' and '".$fecha_fin."'";  
                        $subtitulo="Desde: ".$fecha_inicio. " Hasta: ". $fecha_fin;
                    }else {
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.periodo = ".$periodo;  
                        $subtitulo="Periodo: ".$periodo;
                    }
                    if($moneda_ID>0){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.moneda_ID=".$moneda_ID;  
                    }
                    
                     if($operador_ID!=0){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.operador_ID=".$operador_ID;
                    }
                    if(isset($_POST['ckEstado'])){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="fv.estado_ID =60"; 
                    }else{
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="fv.estado_ID in (60,41)";    
                    }
                    
                    $dtReportes=reportes::getVentasClientes($filtro,-1,-1);
                    $titulo_cabecera=array("ruc"=>"RUC",
                        "razon_social"=>"Razón Social",
                        "moneda"=>"Moneda",
                        "monto_total"=>"Total"
                        );
                    $array_ancho=array(30,90,30,25);
                    $array_alineacion=array('L','L','L','R');
                    $array_tipo=array('texto','texto','texto','moneda');
                    $ruta=contructor_pdf_reporte($dtReportes,$oReportes,$titulo_cabecera,$subtitulo,"vertical",$array_ancho,$array_alineacion,$array_tipo);
             
                    break;
                case 4://Ventas por cliente detalle
                    $subtitulo="";
                    if($rango==1){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.fecha between '".$fecha_inicio."' and '".$fecha_fin."'";  
                        $subtitulo="Desde: ".$fecha_inicio. " Hasta: ". $fecha_fin;
                    }else {
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.periodo = ".$periodo;  
                        $subtitulo="Periodo: ".$periodo;
                    }
                    if($moneda_ID>0){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.moneda_ID=".$moneda_ID;  
                    }
                    
                     if($operador_ID!=0){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.operador_ID=".$operador_ID;
                    }
                    if(isset($_POST['ckEstado'])){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="fv.estado_ID =60"; 
                    }else{
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="fv.estado_ID in (60,41)";    
                    }
                    
                    $dtReportes=reportes::getVentasClientesDetalle($filtro,-1,-1);
                    $titulo_cabecera=array("ruc"=>"RUC",
                        "razon_social"=>"Razón Social",
                         "fecha"=>"Fecha",
                         "factura"=>"Factura",
                        "moneda"=>"Moneda",
                        "monto_total"=>"Total"
                        );
                    $array_ancho=array(25,70,20,25,15,25);
                    $array_alineacion=array('L','L','C','C','C','R');
                    $array_tipo=array('texto','texto','texto','texto','texto','moneda');
                    $ruta=contructor_pdf_reporte($dtReportes,$oReportes,$titulo_cabecera,$subtitulo,"vertical",$array_ancho,$array_alineacion,$array_tipo);
             
                    break;    
                case 9://Facturas por cobrar
                    $subtitulo="";
                    if($rango==1){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.fecha between '".$fecha_inicio."' and '".$fecha_fin."'";  
                        $subtitulo="Desde: ".$fecha_inicio. " Hasta: ". $fecha_fin;
                    }else {
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.periodo = ".$periodo;  
                        $subtitulo="Periodo: ".$periodo;
                    }
                    if($moneda_ID>0){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.moneda_ID=".$moneda_ID;  
                    }
                    
                    if($operador_ID!=0){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.operador_ID=".$operador_ID;
                    }
                    if(isset($_POST['ckEstado'])){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="fv.estado_ID =60"; 
                    }else{
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="fv.estado_ID in (60,41)";    
                    }
                    if(isset($cliente_ID)&&$cliente_ID!=""){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.cliente_ID=" .$cliente_ID;  
                    }
                    $dtReportes=reportes::getReporteFacturasCobrarDetalle($filtro,-1,-1);
                    $titulo_cabecera=array("ruc"=>"RUC",
                        "razon_social"=>"Razón Social",
                        "factura"=>"Factura",
                        "fecha_emision"=>"Fecha Emi.",
                        "fecha_vencimiento"=>"Fecha ven.",
                        "moneda"=>"Moneda",
                        "monto_total"=>"Total",
                        "monto_pendiente"=>"Saldo"
                        );
                    $array_ancho=array(25,70,25,25,25,20,25,25);
                    $array_alineacion=array('L','L','C','C','C','C','R','R');
                    $array_tipo=array('texto','texto','texto','texto','texto','texto','moneda','moneda');
                    $ruta=contructor_pdf_reporte($dtReportes,$oReportes,$titulo_cabecera,$subtitulo,"horizontal",$array_ancho,$array_alineacion,$array_tipo);
             
                    break;
                case 10://Cuentas totales por cobrar
                    $subtitulo="";
                    if($rango==1){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.fecha between '".$fecha_inicio."' and '".$fecha_fin."'";  
                        $subtitulo="Desde: ".$fecha_inicio. " Hasta: ". $fecha_fin;
                    }else {
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.periodo = ".$periodo;  
                        $subtitulo="Periodo: ".$periodo;
                    }
                    if($moneda_ID>0){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.moneda_ID=".$moneda_ID;  
                    }
                    
                    if($operador_ID!=0){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.operador_ID=".$operador_ID;
                    }
                    if(isset($_POST['ckEstado'])){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="fv.estado_ID =60"; 
                    }else{
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="fv.estado_ID in (60,41)";    
                    }
                    if(isset($cliente_ID)&&$cliente_ID!=""){
                        $filtro.=($filtro=="")?"":" and ";
                        $filtro.="ov.cliente_ID=" .$cliente_ID;  
                    }
                    $dtReportes=reportes::getReporteCuentasTotaltesCobrar($filtro,-1,-1);
                    $titulo_cabecera=array("ruc"=>"RUC",
                        "razon_social"=>"Razón Social",
                        "moneda"=>"Moneda",
                        "monto_total"=>"Total",
                        "monto_pendiente"=>"Saldo total"
                        );
                    $array_ancho=array(25,80,20,25,25);
                    $array_alineacion=array('L','L','C','R','R');
                    $array_tipo=array('texto','texto','texto','moneda','moneda');
                    $ruta=contructor_pdf_reporte($dtReportes,$oReportes,$titulo_cabecera,$subtitulo,"vertical",$array_ancho,$array_alineacion,$array_tipo);
             
                    break;
            }

        $mensaje='';

        } catch (Exception $ex) {
            $mensaje= $ex->getMessage() ;
            $ruta='';
        }
        
       
        $retornar = Array('url' => $ruta,'mensaje'=>$mensaje);
        //$retorn="<h1>Hola</h1>";

        echo json_encode($retornar);
    }