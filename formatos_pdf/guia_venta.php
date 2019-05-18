<?php
require('include/fpdf/fpdf.php');

class PDF2 extends FPDF
{
    var $widths;
    var $aligns;
    
    
    function SetWidths($w) {  
        $this->widths=$w;
    }
    function SetAligns($a)
    {
    $this->aligns=$a;
    }
    public $oGuia_Venta;
    public $oOrden_Venta;
    public $oDatos_Generales;
    public $oCliente;
    public $oCliente_Contacto;
    public $oMoneda;
    public $oForma_Pago;
    public $oOperador;
    public $oVehiculo;
    public $oChofer;
    public $dtOrden_Venta_Numero_Cuenta;
    function Row($data,$altura)
    {
            //Calculate the height of the row
            $nb=0;
            for($i=0;$i<count($data);$i++)
                    $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
            $h=$altura*$nb;
            
            //Issue a page break first if needed
            $this->CheckPageBreak($h);
            //Draw the cells of the row
            for($i=0;$i<count($data);$i++)
            {
                    $w=$this->widths[$i];
                    $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
                    //Save the current position
                    $x=$this->GetX();
                    $y=$this->GetY();
                    //$this->Write(2,$y);
                    //$alto=$this->GetMultiCellHeight(0,0,$data[$i]);
                    
                    //Draw the border
                    $this->MultiCell($w,$altura,$data[$i],0,$a,false);
                    //Put the position to the right of the cell
                    $this->SetXY($x+$w,$y);
                    
            }
            
            //Go to the next line
            $this->Ln($h);
            //$this->Cell(1,0,'',0);
            $y2=$this->GetY();
            return $y2-$y;
    }

    function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w,$txt)
    {
            //Computes the number of lines a MultiCell of width w will take
            $cw=&$this->CurrentFont['cw'];
            if($w==0)
                    $w=$this->w-$this->rMargin-$this->x;
            $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
            $s=str_replace("\r",'',$txt);
            $nb=strlen($s);
            if($nb>0 and $s[$nb-1]=="\n")
                    $nb--;
            $sep=-1;
            $i=0;
            $j=0;
            $l=0;
            $nl=1;
            while($i<$nb)
            {
                    $c=$s[$i];
                    if($c=="\n")
                    {
                            $i++;
                            $sep=-1;
                            $j=$i;
                            $l=0;
                            $nl++;
                            continue;
                    }
                    if($c==' ')
                            $sep=$i;
                    $l+=$cw[$c];
                    if($l>$wmax)
                    {
                            if($sep==-1)
                            {
                                    if($i==$j)
                                            $i++;
                            }
                            else
                                    $i=$sep+1;
                            $sep=-1;
                            $j=$i;
                            $l=0;
                            $nl++;
                    }
                    else
                            $i++;
            }
            return $nl;
    }

    function Header(){
           
    }
    function cabecera($oGuia_Venta){
        //require ROOT_PATH . 'include/lib_fecha_texto.php';
        $this->Image(logo_documentos , 8 ,8, 70, 20 , "JPG" );
        $this->SetFont('Arial','',8);
        $this->SetTextColor(0);
        $this->SetXY(8,8);
        $this->Cell(80,30,'',0);
        $this->Cell(50,30,'Nueva central',0,0,'C');
        $this->Cell(70,30,'',1);
        $this->SetXY(138,8);
        $this->SetFont('Arial','B',15);
        $this->Cell(70,10,'R.U.C.'.$this->oDatos_Generales->ruc,0,2,'C');
        $this->Cell(70,10,'GUIA DE REMISION',0,2,'C');
        $this->Cell(70,10,utf8_decode($oGuia_Venta->serie.' - N°'. $oGuia_Venta->numero_concatenado),0,0,'C');
        
        $this->Ln();
        $this->Ln();
       // $this->Cell(155,5,'FECHA',1,0,'R');
        //$this->Ln();$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
        //$this->SetXY(8,50);
        $this->SetXY(10,45);
       $this->SetFont('Arial','',7);
        $this->Cell(40,5,'FECHA DE:',0,0,'L');
        $this->Ln();
        $this->Cell(40,5,'EMISION:',0,0,'L');
        
        $this->SetXY(30,50);
        
        $this->Cell(40,5,$oGuia_Venta->fecha_emision,0,0,'L');
        $this->SetXY(80,45);
        
        $this->Cell(25,5,'FECHA DE INICIO',0,2,'L');
        $this->Cell(25,5,'DEL TRASLADO',0,2,'L');
        
        $this->SetXY(105,45);
        $this->Cell(40,5,$oGuia_Venta->fecha_inicio_traslado,0,0,'L');
        
        $this->SetXY(130,45);
        $this->Cell(40,5,utf8_decode('ORDEN DE PEDIDO N°:'),0,2,'L');
        $this->Cell(25,5,'ORDEN DE COMPRA',0,2,'L');
        $this->SetFont('Arial','',7);
        $this->SetXY(170,45);
        $this->Cell(40,5,$oGuia_Venta->orden_pedido,0,2,'L');
        $this->Cell(95,5,$oGuia_Venta->orden_ingreso,0,2,'L');
        $this->Ln(2);
        //domicilio de partida
        $this->SetFillColor(215,215,215);
        $this->Cell(99,5,'DOMICILIO DE PARTIDA',1,2,'C',true);
        $this->MultiCell(99,10,$oGuia_Venta->punto_partida,0,'C',false);
        $this->Rect(10,62,99,10);
        $this->SetXY(111,57);
        $this->Cell(99,5,'DOMICILIO DE LLEGADA',1,2,'C',true);
        $this->MultiCell(99,5,$oGuia_Venta->punto_llegada,0,'C',false);
        $this->Rect(111,62,99,10);
        $this->Ln(7);
        
        //destinatario
        
        $this->Cell(99,5,'DESTINATARIO',1,2,'C',true);
        $this->MultiCell(99,5,'NOMBRES/RAZON SOCIAL:'.$this->oCliente->razon_social,0,'L',false);
       
        $this->Ln(3);
        $this->Cell(20,5,'RUC:'.$this->oCliente->ruc,0,0,'L');
      
        $this->Rect(10,79,99,10);
        $this->SetXY(111,74);
        $this->Cell(99,5,'DATOS DEL TRANSPORTE/CONDUCTOR',1,2,'C',true);
        $this->Cell(30,5,utf8_decode('VEHICULO MARCA Y PLACA N°:').(isset($this->oVehiculo)?($this->oVehiculo->marca.' - '.$this->oVehiculo->placa):""),0,0,'L');
        $this->Ln(3);
        $this->SetX(111);
        $this->Cell(30,5,utf8_decode('CERTIFICADO DE INSCRIPCION N°: ').(isset($this->oVehiculo)?$this->oVehiculo->certificado_inscripcion:""),0,0,'L');
        $this->Ln(3);
        $this->SetX(111);
        $this->Cell(30,5,utf8_decode('LICENCIA DE CONDUCIR N°:').$this->oChofer->licencia_conducir,0,0,'L');
        
        $this->Rect(111,79,99,10);
        $this->Ln(2);
        
    }
    function contenido_detalle($dtGuia_Venta_Detalle){
        
        $this->SetXY(10,100);
        $this->SetFont('Arial','',8);
        foreach($dtGuia_Venta_Detalle as $item){
            
            $this->SetFont('Arial','B',8);
            $array=array($item['cantidad'],$item['producto'],$item['unidad_medida'],$item['peso']);
            $this->Row($array,5);
            $this->SetX(30);
            $this->SetFont('Arial','',8);
            if(trim($item['descripcion'])!=''){
                $this->MultiCell(120,5, FormatTextViewPDF($item['descripcion']),0,'J',false);
                
            }
            $this->Ln();

       }

    }
    function contenedor_detalle($alto,$oGuia_Venta){
     if(!class_exists('moneda')){
         require ROOT_PATH . 'models/moneda.php';
     }
     if(!class_exists('factura_venta')){
         require ROOT_PATH . 'models/factura_venta.php';
     }
     
    //$this->SetXY(10,$y);
    $this->Ln();
    $this->SetFont('Arial','B',7);
    $this->SetTextColor(0);
    $this->SetFillColor(215,215,215);
    $this->Cell(20,7,utf8_decode('CANTIDAD'),1,0,'C',true);
    $this->Cell(120,7,utf8_decode('DESCRIPCIÓN'),1,0,'C',true);
    $this->Cell(25,7,utf8_decode('U. MEDIDA'),1,0,'C',true);
    $this->Cell(35,7,utf8_decode('PESO TOTAL'),1,0,'C',true);
   
    $this->Ln();
    // cuerpo del detalle
    $this->Cell(20,$alto,'',1,0,'C');
    $this->Cell(120,$alto,'',1,0,'C');
    $this->Cell(25,$alto,'',1,0,'C');
    $this->Cell(35,$alto,'',1,0,'C');
    //pie de pagina
    $this->SetFont('Arial','',7);
    $this->Ln();
    $this->Ln(1);
    $this->SetTextColor(0);
    $this->Cell(80,5,'TRANSPORTISTA:',1,0,'C',true);
    $this->Ln();
    $this->Cell(80,5,'NOMBRE: '.$this->oChofer->nombres.' '.$this->oChofer->nombres.'   '.$this->oChofer->licencia_conducir,0,0,'L',false);
    
    $this->Ln();
    $this->SetX(30);
    $this->Cell(80,5,$oGuia_Venta->empresa_transporte,0,0,'L',false);
    $this->Ln(3);
    $this->SetX(30);
    $this->Cell(80,5,$this->oDatos_Generales->ruc,0,0,'L',false);
    $this->Ln(3);
    $this->SetX(30);
    $this->Cell(80,5,(isset($this->oVehiculo)?($this->oVehiculo->marca.''.$this->oVehiculo->placa):""),0,0,'L',false);
    $this->SetXY(10,243);
    $this->Cell(30,5,'R.U.C./D.N.I.:',0,0,'L',false);
    $this->Rect(10,235,80,15);
    
    
    //cuadro de giro de cheque
   
    
   }
   
   
   function Footer(){
    
    }
   
} 


?>